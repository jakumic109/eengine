<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Interfaces;

/**
 * Description of DataType
 *
 * @author Kuba
 */
interface DataType 
{
    /**
     * Formatuje dane dla danego typu.
     */
    public function format(string $value): string;
    
    public function isValid($value) : bool;
}
