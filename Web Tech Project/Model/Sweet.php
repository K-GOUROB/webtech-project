<?php
require_once "../Model/FileIO.php";
class Sweet{

    public static function getAllSweets(){
        $fileIO = new FileIO();
        $sweets = $fileIO->readJson('../Model/File/sweets.json');
        return $sweets;
    }

    public static function getSweetsByArea($area){
        $fileIO = new FileIO();
        $sweets = $fileIO->readJson('../Model/File/sweets.json');
        $sweetsByArea = [];
        foreach($sweets as $sweet){
            if($sweet['area'] == $area){
                array_push($sweetsByArea, $sweet);
            }
        }
        return $sweetsByArea;
    }
}