<?php

namespace App\Controllers;

use App\Libraries\AvatarStorage;
use App\Models\StaffModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;
use Throwable;

class Users extends BaseController
{
    public function index(): string
    {
        $users = (new UserModel())->orderBy('full_name', 'ASC')->findAll();
        $legacyUsers = $this->staffWithInitials();

        foreach ($users as &$user) {
            $user['initials'] = $this->initials($user['full_name']);
        }
        unset($user);

        return view('users/index', [
            'title'       => 'House Team',
            'currentPage' => 'users',
            'users'       => $users,
            'legacyUsers' => $legacyUsers,
        ]);
    }

    public function legacy(): string
    {
        return view('staff/index', [
            'title'       => 'Original Tahanan Team',
            'currentPage' => 'legacy-team',
            'users'       => $this->staffWithInitials(),
        ]);
    }

    public function new(): string
    {
        return $this->formView(null, 'Add Team Member', 'Welcome a team member', 'Behind the counter', site_url('users'), 'Save team member');
    }

    public function create()
    {
        $data = $this->userData();
        $password = (string) $this->request->getPost('password');

        if (! $this->validateData([...$data, 'password' => $password], $this->userRules())) {
            return redirect()->to(site_url('users/new'))->withInput()->with('errors', $this->validator->getErrors());
        }

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        $id = (new UserModel())->insert($data, true);

        return redirect()->to(site_url('users/' . $id . '/edit'))
            ->with('success', 'Team member added. You can now add a profile picture.');
    }

    public function edit(int $id): string
    {
        $user = (new UserModel())->find($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound('Team member not found.');
        }

        return $this->formView($user, 'Update Team Member', 'Update team details', 'Behind the counter', site_url('users/' . $id), 'Save team member');
    }

    public function update(int $id)
    {
        $model = new UserModel();
        $user = $model->find($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound('Team member not found.');
        }

        $rules = $this->userRules($id);
        $avatar = $this->request->getFile('avatar');
        $hasAvatar = $avatar !== null && $avatar->getError() !== UPLOAD_ERR_NO_FILE;

        if ($hasAvatar) {
            $rules['avatar'] = [
                'label' => 'Profile picture',
                'rules' => 'uploaded[avatar]|max_size[avatar,2048]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]|ext_in[avatar,jpg,jpeg,png]',
                'errors' => [
                    'max_size' => 'The profile picture must be 2 MB or smaller.',
                    'is_image' => 'Choose a valid JPG or PNG image.',
                    'mime_in'  => 'Only JPG and PNG images are allowed.',
                    'ext_in'   => 'Only .jpg, .jpeg, and .png files are allowed.',
                ],
            ];
        }

        if (! $this->validate($rules)) {
            return redirect()->to(site_url('users/' . $id . '/edit'))->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->userData();
        $password = (string) $this->request->getPost('password');

        if ($password !== '') {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }
        $newAvatar = null;
        $avatarStorage = new AvatarStorage();

        try {
            if ($hasAvatar && $avatar !== null) {
                $newAvatar = $avatarStorage->store($avatar);
                $data['avatar'] = $newAvatar['url'];
                $data['avatar_public_id'] = $newAvatar['publicId'];
            }

            if ($model->update($id, $data) === false) {
                throw new RuntimeException('Unable to save the team member.');
            }
        } catch (Throwable $exception) {
            if ($newAvatar !== null) {
                try {
                    $avatarStorage->delete($newAvatar['url'], $newAvatar['publicId']);
                } catch (Throwable $cleanupException) {
                    log_message('error', 'New avatar cleanup failed: {message}', ['message' => $cleanupException->getMessage()]);
                }
            }

            log_message('error', 'Avatar preparation failed: {message}', ['message' => $exception->getMessage()]);

            return redirect()->to(site_url('users/' . $id . '/edit'))->withInput()->with('errors', [
                'avatar' => 'The image could not be prepared. Please try another JPG or PNG file.',
            ]);
        }

        if ($newAvatar !== null && ! empty($user['avatar'])) {
            try {
                $avatarStorage->delete(
                    (string) $user['avatar'],
                    empty($user['avatar_public_id']) ? null : (string) $user['avatar_public_id'],
                );
            } catch (Throwable $exception) {
                log_message('error', 'Previous avatar cleanup failed: {message}', ['message' => $exception->getMessage()]);
            }
        }

        return redirect()->to(site_url('users'))->with('success', 'Team member details updated.');
    }

    private function formView(?array $user, string $title, string $heading, string $eyebrow, string $action, string $submitLabel): string
    {
        return view('users/form', [
            'title'       => $title,
            'currentPage' => 'users',
            'heading'     => $heading,
            'eyebrow'     => $eyebrow,
            'action'      => $action,
            'submitLabel' => $submitLabel,
            'user'        => $user,
            'errors'      => session('errors') ?? [],
            'success'     => session('success'),
        ]);
    }

    private function userData(): array
    {
        return [
            'username'  => trim((string) $this->request->getPost('username')),
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email'     => trim((string) $this->request->getPost('email')),
        ];
    }

    private function userRules(?int $id = null): array
    {
        $unique = $id === null ? 'is_unique[users.username]' : 'is_unique[users.username,id,' . $id . ']';

        return [
            'username' => [
                'label' => 'Username',
                'rules' => 'required|max_length[50]|regex_match[/\\A[a-zA-Z0-9._-]+\\z/]|' . $unique,
                'errors' => [
                    'regex_match' => 'Use only letters, numbers, periods, underscores, and hyphens.',
                    'is_unique'   => 'That username is already in use.',
                ],
            ],
            'full_name' => ['label' => 'Full name', 'rules' => 'required|min_length[2]|max_length[100]'],
            'email'     => ['label' => 'Email address', 'rules' => 'required|valid_email|max_length[100]'],
            'password'  => [
                'label' => 'Password',
                'rules' => ($id === null ? 'required|' : 'permit_empty|') . 'min_length[8]|max_length[72]',
            ],
        ];
    }

    private function staffWithInitials(): array
    {
        $users = (new StaffModel())->orderBy('full_name', 'ASC')->findAll();

        foreach ($users as &$user) {
            $user['initials'] = $this->initials($user['full_name']);
        }
        unset($user);

        return $users;
    }

    private function initials(string $fullName): string
    {
        $words = preg_split('/\s+/', trim($fullName)) ?: [];

        return strtoupper(implode('', array_map(
            static fn (string $word): string => substr($word, 0, 1),
            array_slice($words, 0, 2),
        )));
    }
}
