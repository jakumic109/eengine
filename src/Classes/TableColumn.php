<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Classes;

use App\Interfaces\Column;
use App\Interfaces\DataType;

/**
 * Description of TableColumn
 *
 * @author Kuba
 */
class TableColumn implements Column{
    
    private $label;
    private $dataType;
    private $align;
    private $isValid;
    
    public function __construct() {
        $this->isValid = true;
        $this->align = 'left';
    }
    
    public function withLabel(string $label) : Column
    {
        $this->label = ucfirst($label);
        return $this;
    }
    
    public function getLabel() : string 
    {
        return $this->label;
    }
    
    public function withDataType(DataType $type) : Column 
    {
        $this->dataType = $type;
        return $this;
    }
    
    public function getDataType() : DataType
    {
        return $this->dataType;
    }
    
    public function withAlign(string $align) : Column
    {
        $this->align = $align;
        return $this;
    }
    
    public function getAlign() : string 
    {
        return $this->align;
    }
    
    public function showColumnValue($value) : string
    {
        $result = '';
        if($this->dataType->isValid($value)){
            $result = $this->dataType->format($value);
        }else{
            $this->isValid = false;
            $error = new Error();
            $result = $error->cellError();
        }
        return $result;
    }
    
    public function getIsValid() : bool
    {
        return $this->isValid;
    }
    
    public function clearIsValid() : void
    {
        $this->isValid = true;
    }
}
