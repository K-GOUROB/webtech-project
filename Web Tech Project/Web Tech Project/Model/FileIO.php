<?php

class FileIO
{
    public function readJson($file)
    {
        if(!file_exists($file)) {
            return [];
        }
        $json = file_get_contents($file);
        $data = json_decode($json, true);
        $dataToArray = [];
        foreach($data as $key => $value) {
            $dataToArray[] = $value;
        }
        return $dataToArray;
    }

    public function writeJson($file, $data)
    {
        if(!file_exists($file)) {
            $arr = [];
            $arr[] = $data;
            $json = json_encode($arr, JSON_PRETTY_PRINT);
            file_put_contents($file, $json);
            return true;
        }
        else {
            $json = file_get_contents($file);
            $arr = json_decode($json, true);
            $arr[] = $data;
            $json = json_encode($arr, JSON_PRETTY_PRINT);
            file_put_contents($file, $json);
            return true;
        }
    }

    public function updateJson($file, $data)
    {
        if(!file_exists($file)) {
            return false;
        }
        else {
            $json = file_get_contents($file);
            $arr = json_decode($json, true);
            foreach($arr as $key => $value) {
                if($value['uid'] == $data['uid']) {
                    $arr[$key] = $data;
                }
            }
            $json = json_encode($arr, JSON_PRETTY_PRINT);
            file_put_contents($file, $json);
            return true;
        }
    }
}