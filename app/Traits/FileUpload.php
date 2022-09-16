<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

trait FileUpload
{
    public function imageUpload($imageFile, $filename = '', $uploadFolder = 'images')
    {
        $fileExtension = $imageFile->getClientOriginalExtension();
        $filenameWithExtension = $filename . '.' . $fileExtension;
        $imageUploadedPath = $imageFile->storeAs($uploadFolder, $filenameWithExtension, 'public');
        $fileUrl = Storage::disk('public')->url($imageUploadedPath);

        if (env('APP_ENV', 'local') == 'local') {
            $fileUrl = str_replace('localhost', '127.0.0.1:8000', $fileUrl);
        }

        return $fileUrl;
    }

    public function imageUploadForBase64($base64Image, $filename = '', $uploadFolder = 'misc')
    {
        
        if (preg_match('/^data:image\/(\w+);base64,/', $base64Image)) {
            $data = substr($base64Image, strpos($base64Image, ',') + 1);
            $data = base64_decode($data);
            $filenameWithExtension = $filename . '.png';
            $imagePath = 'images/' . $uploadFolder . '/' . $filenameWithExtension;
            Storage::disk('public')->put($imagePath, $data);
            // $fileUrl = URL::to('/') . Storage::url($imagePath);
            $fileUrl = Storage::url($imagePath);

            return $fileUrl;
        }


        return null;

    }
}