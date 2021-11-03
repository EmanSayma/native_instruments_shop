<?php

namespace App\Helpers;

class Helper
{
    public static function readCSV($csvFile)
    {
        $file_handle = fopen($csvFile, 'r');
        while(!feof($file_handle)) {
            $data[] = fgetcsv($file_handle, 0, ',');
        }
        fclose($file_handle);
        unset($data[0]);
        return $data;
    }

}