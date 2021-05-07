<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Classes;

use App\Interfaces\State;

/**
 * Description of HttpState
 *
 * @author Kuba
 */
class HttpState implements State{
    
    private $currentPage;
    private $orderBy;
    private $orderType;
    private $rowsPerPage;
    
    public function getCurrentPage(): int 
    {
        return (int)$this->currentPage;
    }
    
    public function getOrderBy(): string
    {
        return (string)$this->orderBy;
    }
    
    public function isOrderDesc(): bool 
    {
        return ($this->orderType == 'desc') ? TRUE : FALSE;
    }
    
    public function isOrderAsc(): bool 
    {
        return ($this->orderType == 'asc') ? TRUE : FALSE;
    }
    
    public function getRowsPerPage(): int 
    {
        return (int) $this->rowsPerPage;
    }
    
    public function getOrderType(): string
    {
        return (string) $this->orderType;
    }
    
    public function create()
    {
        $result = new HttpState();
        $result->setVariables();
        return $result;
    }
    
    public function getNextOrderByParams() : string
    {
        $result = 'orderType=';
        if($this->isOrderAsc()){
            $result .= 'desc';
        }elseif($this->isOrderDesc()){
            $result .= 'none';
        }else{
            $result .= 'asc';
        }
        return $result;
    }
    
    public function getStartRow() : int
    {
        return ($this->currentPage - 1) * $this->rowsPerPage;
    }
    
    public function getStopRow() : int
    {
        return $this->currentPage * $this->rowsPerPage - 1;
    }
    
    private function setVariables()
    {
        $this->currentPage = $this->currentPageValue();
        $this->orderBy = $this->orderByValue();
        $this->orderType = $this->orderTypeValue();
        $this->rowsPerPage = $this->rowsPerPageValue();
    }
    
    private function currentPageValue()
    {
        return $this->getValidIntValue('currentPage');
    }
    
    private function orderByValue()
    {
        return $this->getValidStringValue('orderBy');
    }
    
    private function orderTypeValue()
    {
        return $this->getValidStringValue('orderType');
    }
    
    private function rowsPerPageValue(){
        return $this->getValidIntValue('rowsPerPage', 9);
    }
    
    protected function getValidIntValue($key, int $default = 1)
    {
        $result = $default;
        if($this->isValidIntValue($key)){
            $result = (int)$this->getValue($key);
        }
        return $result;
    }
    
    protected function isValidIntValue($key)
    {
        return ($this->isKeyInGetValues($key) && is_int(filter_var($this->getValue($key), FILTER_VALIDATE_INT)));
    }
    
    protected function getValidStringValue($key, string $default = '')
    {
        $result = $default;
        if($this->isValidStringValue($key)){
            $result = (string)$this->getValue($key);
        }
        return $result;
    }
    
    protected function isValidStringValue($key)
    {
        return $this->isKeyInGetValues($key);
    }
    
    protected function isKeyInGetValues($key)
    {
        return array_key_exists($key, $_GET);
    }
    
    protected function getValue($key)
    {
        return $_GET[$key];
    }
}
