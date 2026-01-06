<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class CloudinaryService
{
    /**
     * Upload image to Cloudinary with folder
     */
    public function uploadImage(
        UploadedFile $file,
        string $folder,
        string $publicId
    ): array {

        $result = cloudinary()
            ->uploadApi()
            ->upload(
                $file->getRealPath(),
                [
                    'folder'        => $folder,      // ✅ folder thật trong Media Library
                    'public_id'     => $publicId,
                    'overwrite'     => true,
                    'resource_type' => 'image',
                ]
            );

        return [
            'url'       => $result['secure_url'],
            'public_id' => $result['public_id'],
        ];
    }

    /**
     * Delete image by public_id
     */
    public function deleteImage(?string $publicId): void
    {
        if ($publicId) {
            cloudinary()
                ->uploadApi()
                ->destroy($publicId);
        }
    }
}
