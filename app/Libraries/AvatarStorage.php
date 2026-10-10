<?php

namespace App\Libraries;

use Cloudinary\Cloudinary;
use CodeIgniter\HTTP\Files\UploadedFile;
use RuntimeException;

final class AvatarStorage
{
    private ?Cloudinary $cloudinary = null;

    public function __construct()
    {
        $cloudinaryUrl = getenv('CLOUDINARY_URL');

        if (is_string($cloudinaryUrl) && $cloudinaryUrl !== '') {
            $this->cloudinary = new Cloudinary($cloudinaryUrl);
        }
    }

    /** @return array{url: string, publicId: ?string} */
    public function store(UploadedFile $avatar): array
    {
        if ($this->cloudinary !== null) {
            $result = $this->cloudinary->uploadApi()->upload($avatar->getTempName(), [
                'folder'          => 'tahanan/avatars',
                'resource_type'   => 'image',
                'transformation'  => [
                    'width'   => 320,
                    'height'  => 320,
                    'crop'    => 'fill',
                    'gravity' => 'auto',
                    'quality' => 'auto',
                ],
            ]);

            $url = (string) ($result['secure_url'] ?? '');
            $publicId = (string) ($result['public_id'] ?? '');

            if ($url === '' || $publicId === '') {
                throw new RuntimeException('Cloudinary did not return an image URL and public ID.');
            }

            return ['url' => $url, 'publicId' => $publicId];
        }

        if (ENVIRONMENT === 'production') {
            throw new RuntimeException('CLOUDINARY_URL is required for production avatar uploads.');
        }

        $directory = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'avatars';

        if (! is_dir($directory) && ! mkdir($directory, 0775, true) && ! is_dir($directory)) {
            throw new RuntimeException('Unable to create the avatar upload directory.');
        }

        $extension = strtolower($avatar->getExtension());
        $filename = pathinfo($avatar->getRandomName(), PATHINFO_FILENAME) . '.' . $extension;

        service('image')
            ->withFile($avatar->getTempName())
            ->fit(320, 320, 'center')
            ->save($directory . DIRECTORY_SEPARATOR . $filename, 85);

        return ['url' => $filename, 'publicId' => null];
    }

    public function delete(?string $url, ?string $publicId): void
    {
        if ($publicId !== null && $publicId !== '' && $this->cloudinary !== null) {
            $this->cloudinary->uploadApi()->destroy($publicId, ['invalidate' => true]);

            return;
        }

        if ($url === null || $url === '' || preg_match('#^https?://#i', $url) === 1) {
            return;
        }

        $path = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'avatars' . DIRECTORY_SEPARATOR . basename($url);

        if (is_file($path)) {
            unlink($path);
        }
    }
}
