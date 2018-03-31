<?php

namespace App\Helpers\Admin;

class AdminUploadFileHelper
{
    const UPLOADS_PATH = 'uploads/';
    
    public static function uploadFile($file, $folder_name, $id)
    {
        // Set file name
        $fileName = str_pad($id, 12, '0', STR_PAD_LEFT) . "-image." . $file->getClientOriginalExtension();
    
        // Move file to public path
        $file->move(public_path(self::UPLOADS_PATH . $folder_name), $fileName);
    
        // Return file name
        return $fileName;
    }
}

