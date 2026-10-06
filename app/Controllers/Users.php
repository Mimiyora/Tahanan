<?php

namespace App\Controllers;

use App\Models\StaffModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
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
            'title'       => 'User Accounts',
            'currentPage' => 'users',
            'users'       => $users,
            'legacyUsers' => $legacyUsers,
        ]);
    }

    public function legacy(): string
    {
        return view('staff/index', [
            'title'       => 'Legacy Team Directory',
            'currentPage' => 'legacy-team',
            'users'       => $this->staffWithInitials(),
        ]);
    }

    public function new(): string
    {
        return $this->formView(null, 'New User', 'Create a user account', 'New point-of-sale account', site_url('users'), 'Save user');
    }

    public function create()
    {
        $data = $this->userData();

        if (! $this->validateData($data, $this->userRules())) {
            return redirect()->to(site_url('users/new'))->withInput()->with('errors', $this->validator->getErrors());
        }

        $data['created_at'] = date('Y-m-d H:i:s');
        $id = (new UserModel())->insert($data, true);

        return redirect()->to(site_url('users/' . $id . '/edit'))
            ->with('success', 'User account created. You can now add a profile picture.');
    }

    public function edit(int $id): string
    {
        $user = (new UserModel())->find($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound('User account not found.');
        }

        return $this->formView($user, 'Edit User', 'Edit user account', 'Update account and avatar', site_url('users/' . $id), 'Update user');
    }

    public function update(int $id)
    {
        $model = new UserModel();
        $user = $model->find($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound('User account not found.');
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
        $newAvatar = null;

        try {
            if ($hasAvatar && $avatar !== null) {
                $newAvatar = $this->prepareAvatar($avatar);
                $data['avatar'] = $newAvatar;
            }

            $model->update($id, $data);
        } catch (Throwable $exception) {
            if ($newAvatar !== null) {
                $this->removeAvatarFile($newAvatar);
            }

            log_message('error', 'Avatar preparation failed: {message}', ['message' => $exception->getMessage()]);

            return redirect()->to(site_url('users/' . $id . '/edit'))->withInput()->with('errors', [
                'avatar' => 'The image could not be prepared. Please try another JPG or PNG file.',
            ]);
        }

        if ($newAvatar !== null && ! empty($user['avatar'])) {
            $this->removeAvatarFile((string) $user['avatar']);
        }

        return redirect()->to(site_url('users'))->with('success', 'User account updated successfully.');
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
        ];
    }

    private function prepareAvatar($avatar): string
    {
        $directory = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'avatars';

        if (! is_dir($directory) && ! mkdir($directory, 0775, true) && ! is_dir($directory)) {
            throw new \RuntimeException('Unable to create the avatar upload directory.');
        }

        $extension = strtolower($avatar->getExtension());
        $filename = pathinfo($avatar->getRandomName(), PATHINFO_FILENAME) . '.' . $extension;
        $destination = $directory . DIRECTORY_SEPARATOR . $filename;

        service('image')
            ->withFile($avatar->getTempName())
            ->fit(320, 320, 'center')
            ->save($destination, 85);

        return $filename;
    }

    private function removeAvatarFile(string $filename): void
    {
        $safeName = basename($filename);
        $path = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'avatars' . DIRECTORY_SEPARATOR . $safeName;

        if (is_file($path)) {
            unlink($path);
        }
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
