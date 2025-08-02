<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Storage;

class StorageService
{



    static public function storeFile($file, $path = 'uploads/', $disk = 'public',)
    {
        $name = base64_encode(microtime()) . $file->getClientOriginalName();
        Storage::disk($disk)->put($path . $name, file_get_contents($file));
        $finalPath = $disk . '/' . $path . $name;
        if (self::$isTransaction)
            array_push(self::$stored, $finalPath);

        return $finalPath;
    }

    static public function deleteFile($path)
    {
        if (self::$isTransaction) {
            array_push(self::$deleted, $path);
        } else {
            Storage::delete($path);
        }
    }

    static public function urlOf($path)
    {
        return url(Storage::url($path));
    }


    static private array $stored = [];
    static private array $deleted = [];
    static private bool $isTransaction = false;


    static public function beginTransaction()
    {
        self::$isTransaction = true;
    }

    static public function commit()
    {
        self::$isTransaction = false;
        self::$stored = [];
        foreach (self::$deleted as $path) {
            self::deleteFile($path);
        }
        self::$deleted = [];
    }

    static public function rollback()
    {
        self::$isTransaction = false;
        foreach (self::$stored as $path) {
            try {
                self::deleteFile($path);
            } catch (Exception $e) {
            }
        }
        self::$stored = [];
        self::$deleted = [];
    }

    static public function getType($file)
    {
        $extension = strtolower($file->getClientOriginalExtension()); 

        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];
        $videoExtensions = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv', 'webm'];

        if (in_array($extension, $imageExtensions)) {
            return 'image';
        }

        if (in_array($extension, $videoExtensions)) {
            return 'video';
        }

        return 'other';
    }
}
