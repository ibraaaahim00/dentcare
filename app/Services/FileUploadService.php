<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload a file to public storage disk and return its relative path.
     */
    public function upload(UploadedFile $file, string $directory = 'uploads'): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = Str::uuid().'.'.$extension;

        return $file->storeAs($directory, $filename, 'public');
    }

    /**
     * Delete an existing file from public storage disk if present.
     */
    public function delete(?string $path): bool
    {
        if ($path && Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }

        return false;
    }

    /**
     * Replace an old file with a new uploaded file.
     */
    public function replace(?string $oldPath, UploadedFile $newFile, string $directory = 'uploads'): string
    {
        $this->delete($oldPath);

        return $this->upload($newFile, $directory);
    }
}
