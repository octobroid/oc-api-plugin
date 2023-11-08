<?php namespace Octobro\API\Classes;

use System\Models\File;

class Base64 extends File {

    public static function base64ToFile($string)
    {
        $mimeType = substr(array_get(explode(';', $string), 0), 5);

        switch($mimeType) {
            case 'image/jpeg':
                $fileExt = '.jpg';
                break;
            case 'image/png':
                $fileExt = '.png';
                break;
            case 'image/gif':
                $fileExt = '.gif';
                break;
            case 'application/xlsx':
                $fileExt = '.xlsx';
                break;
            default:
                $fileExt = '';
        }

        $data = base64_decode(array_last(explode(',', $string)));

        $filePath = temp_path(time() . rand() . $fileExt);

        file_put_contents($filePath, $data);

        $file = new self;
        $file = $file->fromFile($filePath);

        unlink($filePath);

        return $file;
    }

}