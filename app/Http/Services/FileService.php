<?php

namespace App\Http\Services;

use App\Models\Image;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function upload($imageFile, $validated)
    {
        $image = new Image();
        $filenameWithExt = $imageFile->getClientOriginalName();
        $validated['filename'] = time() . "_" . $filenameWithExt;
        $validated['path'] = $validated['path'] ?? "images/";
        $fileNameToStore = $validated['path'] . $validated['filename'];
        $imageFile->storeAs('public', $fileNameToStore, $validated['disk']);
        $image->fill($validated);
        $image->save();
    }

    public function delete($validated)
    {
        $image = Image::where('imageable_id', $validated['imageable_id'])->where('imageable_type', $validated['imageable_type'])->first();
        Storage::delete($image->path . $image->file_name);
        $image->delete();
    }
}
