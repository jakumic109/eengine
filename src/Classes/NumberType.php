<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Classes;

use App\Interfaces\DataType;

/**
 * Description of NumberType
 *
 * @author Kuba
 */
class NumberType implements DataType{
    
    private $separatorThousands;
    private $separatorComma;
    private $precision;
    private $roundMethod;
    private $precisionFormat;
    
    public function __construct(int $precision = 2, string $separatorThousands = ' ', 
                                    string $separatorComma = ',', 
                                    string $roundType = 'PHP_ROUND_HALF_UP', 
                                    bool $precisionFormat = true) {
        $this->separatorThousands = $separatorThousands;
        $this->separatorComma = $separatorComma;
        $this->precision = $precision;
        $this->roundMethod = $this->roundValue($roundType);
        $this->precisionFormat = $precisionFormat;
    }
    
    public function format(string $value): string
    {
        $result = number_format($value,$this->precision,$this->separatorComma,$this->separatorThousands);
        return $result;
    }
    
    public function isValid($value) : bool {
        return is_numeric($value);
    }
    
    private function roundValue(string $roundType): string
    {
        switch($roundType){
            case 'even':
                $result = 'PHP_ROUND_HALF_EVEN';
                break;
            case 'odd':
                $result = 'PHP_ROUND_HALF_ODD';
                break;
            default:
                $result = 'PHP_ROUND_HALF_UP';
                break;
        }
        return $result;
    }
}
