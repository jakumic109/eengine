<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Classes;

use App\Interfaces\DataType;

/**
 * Description of MoneyType
 *
 * @author Kuba
 */
class MoneyType implements DataType{
    
    private $value;
    private $currency;
    
    public function __construct(string $currency = 'USD', bool $showAfterComma = true,
                                string $separatorThousands = ' ',
                                string $separatorComma = ',') {
        $this->value = new NumberType(($showAfterComma ? 2 : 0), 
                                        $separatorThousands, $separatorComma);
        $this->currency = $currency;
    }    
    
    public function isValid($value) : bool {
        return $this->value->isValid($value);
    }
    
    public function format(string $value) : string {
        return $this->value->format($value) . ' ' . $this->currency;
    }
}
