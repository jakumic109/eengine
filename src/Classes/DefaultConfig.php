<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Classes;

use App\Interfaces\Config;
use App\Interfaces\Column;
use App\Classes\TableColumn;
use App\Interfaces\DataType;

/**
 * Description of DefaultConfig
 *
 * @author Kuba
 */
class DefaultConfig implements Config
{
    private $allColumns = [];
    
    public function addColumn(string $key, Column $column) : Config 
    {
        $this->allColumns[$key] = $column;
        return $this;
    }
    
    public function getColumns() : array 
    {
        return $this->allColumns;
    }
    
    public function addTextColumn($key) : Config
    {
        return $this->addTypicalColumn($key, new TextType());
    }
    
    public function addIntColumn($key) : Config
    {
        return $this->addTypicalColumn($key, new NumberType(0), 'right');
    }
    
    public function addCurrencyColumn($key, string $currency) : Config
    {
        return $this->addTypicalColumn($key, new MoneyType($currency), 'right');
    }
    
    private function addTypicalColumn(string $key, DataType $type, $align = ''){
        $column = new TableColumn();
        $column->withDataType($type);
        $column->withLabel($key);
        if($align != ''){
            $column->withAlign($align);
        }
        return $this->addColumn($key, $column);
    }
    
    public function columnExists($columnName)
    {
        $result = FALSE;
        foreach($this->allColumns as $col => $v){
            if($columnName == $col){
                $result = TRUE;
                break;
            }
        }
        return $result;
    }
    
    public function clearAllColumnsError() : void
    {
        foreach($this->allColumns as $col){
            $col->clearIsValid();
        }
    }
    
    public function getAllColumnsAsRow(array $row) : string
    {
        $result = '';
        foreach($this->allColumns as $kElem => $column){
            $value = array_key_exists($kElem, $row) ? $row[$kElem] : NULL;
            $result .= $this->renderCell($column->showColumnValue($value), $column);
        }
        if(!$this->isValidRow()){
            $error = new Error();
            $result = '<td colspan="100%" class="text-danger">' . $error->rowError() . '</td>';
        }
        $this->clearAllColumnsError();
        return $result;
    }
    
    public function isValidRow() : bool
    {
        (bool) $result = false;
        foreach($this->allColumns as $col){
            if($col->getIsValid()){
                $result = true;
                break;
            }
        }
        return $result;
    }
    
    private function renderCell($value, TableColumn $column) : string
    {
        return '<td style="text-align: ' . $column->getAlign() . ';">' . $value . '</td>';
    }
}