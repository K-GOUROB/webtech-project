<?php 
require_once "../Model/Sweet.php";
class SweetController{

    public static function getAllSweets(){
        $sweets = Sweet::getAllSweets();
        return $sweets;
    }

    public static function getSweetById($id){
        $sweets = Sweet::getAllSweets();
        foreach($sweets as $sweet){
            if($sweet['uid'] == $id){
                return $sweet;
            }
        }
    }

    public static function getSweetsByArea($area){
        if($area=="All"){
            $sweets = Sweet::getAllSweets();
            return $sweets;
        }
        $sweets = Sweet::getSweetsByArea($area);
        return $sweets;
    }
}