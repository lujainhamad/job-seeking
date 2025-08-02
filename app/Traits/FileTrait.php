<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

trait FileTrait
{
    public function uploadFile($path, $file)
    {
        $allowedfileExtension = ['jpg', 'png', 'JPEG', 'PNG', 'jpeg', 'pdf','doc','docx'];
        $extension = $file->getClientOriginalExtension();
        $check = in_array($extension, $allowedfileExtension);
        if (!$check) {
            return "";
        }
        $uniqueFileName = Str::random(20) . now()->format('YmdHis');
        $filePath = $path . "/$uniqueFileName" .  "." . $extension;
        Storage::disk('public')->put($filePath, file_get_contents($file));

        return $filePath;
    }

    public function deleteFile($path)
    {
        try {
            if (str_contains($path, "default")) {
                return true;
            }
            Storage::disk('public')->delete($path);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
