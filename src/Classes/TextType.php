<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Classes;

use App\Interfaces\DataType;
use App\Interfaces\Validation;

/**
 * Description of TextType
 *
 * @author Kuba
 */
class TextType implements DataType{
    
    public function format(string $value): string 
    {
        $result = '';
        if($this->isValid($value)){
            $result = $value;
        }else{
            $result = new ColumnError();
        }
        return $result;
    }
    
    public function isValid($value) : bool
    {
        return (is_string($value) && !$this->isHtmlCode($value) && !$this->isJsCode($value));
    }
    
    private function isHtmlCode(string $string) : bool
    {
        return ($string != strip_tags($string) ? TRUE : FALSE);
    }
    
    private function isJsCode(string $string) : bool
    {
        return false;
    }
}
