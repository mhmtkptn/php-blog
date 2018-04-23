<?php

class Validation
{
    public static function testInput($data){
        if(!isset($data)){
            throw new \Exception("Hatali veri ");
        }
        return $data;
    }
}
