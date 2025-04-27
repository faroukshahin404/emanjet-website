<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

trait UploadFile
{
    /**
     * Upload a file to a specific folder under /public/uploads.
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param string|null $customName
     * @return string File name
     */
    public function upload(UploadedFile $file, string $folder, string $customName = null): string
    {
        $extension = $file->getClientOriginalExtension();
        $name = $customName ? Str::slug($customName) . '.' . $extension : Str::random(20) . '.' . $extension;
        $uploadPath = public_path('uploads/' . $folder . '/');

        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0777, true);
        }

        $file->move($uploadPath, $name);

        return 'uploads/' . $folder . '/' . $name;
    }

    /**
     * Delete file from public path
     *
     * @param string $relativePath
     * @return void
     */
    public function deleteImage(string $relativePath): void
    {
        $path = public_path($relativePath);
        if (File::exists($path)) {
            File::delete($path);
        }
    }
}
