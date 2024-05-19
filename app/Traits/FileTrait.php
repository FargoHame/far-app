<?php

namespace App\Traits;

use App\Models\File;
use App\Models\RotationImage;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

trait FileTrait
{
    public function upFile($fileUp, $fileType, $is_manageable): File
    {
        $time = now();
        // get name and extension of file
        $name = explode(".", $fileUp->getClientOriginalName());
        // this is for create a new file everytime we upload a file. if not add a unique name then it will update a previous file with same name
        $filename = $name[0] . '_' . Auth::user()->id . '_' . $time->format('d-m-Y:H:m:s') . '.' . $name[1];
        $file = new File();
        $file->user_id = Auth::user()->id;
        $file->file_type_id = $fileType;
        $file->filename = $filename;
        $file->is_manageable = $is_manageable;

        $s3 = App::make('aws')->createClient('s3');
        $path = $s3->putObject(array(
            'Bucket'     => env('AWS_BUCKET', ''),
            'Key'        => 'user documents/' . $filename,
            'SourceFile' => $fileUp,
            'visibility' => 'public',
        ));
        $file->path = $path['ObjectURL'];
        $file->save();
        return $file;
    }

    public function upFileRotation($fileUp, $rotation): RotationImage
    {
        $time = now();
        // get name and extension of file
        $name = explode(".", $fileUp->getClientOriginalName());
        // this is for create a new file everytime we upload a file. if not add a unique name then it will update a previous file with same name
        $filename = $name[0] . '_' . Auth::user()->id . '_' . $time->format('d-m-Y:H:m:s') . '.' . $name[1];
        $file = new RotationImage();
        $file->rotation_id = $rotation->id;

        $s3 = App::make('aws')->createClient('s3');
        $path = $s3->putObject(array(
            'Bucket'     => env('AWS_BUCKET', ''),
            'Key'        => 'rotation documents/' . $filename,
            'SourceFile' => $fileUp,
            'visibility' => 'public',
        ));
        $file->path = $path['ObjectURL'];
        $file->save();
        return $file;
    }
}
