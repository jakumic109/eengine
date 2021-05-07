<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Classes;

use App\Interfaces\DataGrid;
use App\Interfaces\Config;
use App\Interfaces\State;

/**
 * Description of HtmlDataGrid
 *
 * @author Kuba
 */
class HtmlDataGrid implements DataGrid{
    
    private $config;
    
    public function withConfig(Config $config) : DataGrid
    {
        $this->config = $config;
        return $this;
    }
    
    public function render(array $rows, State $state) : void
    {
        $result = '';
        if(count($rows) == 0){
            $error = new Error();
            $result = $error->criticalError('Brak danych w tabeli');
        }else{
            $rows = $this->sort($rows, $state);
            $result = '<table class="table table-bordered">';
            $result .= $this->renderHeaders($state);
            $result .= $this->renderBody($rows, $state);
            $result .= '</table>';
            $result .= $this->renderPagination(count($rows), $state);
        }
        echo $result;
    }
    
    private function sort($rows, $state){
        if($state->getOrderBy() != '' && $this->config->columnExists($state->getOrderBy())){
            if($state->isOrderAsc()){
                usort($rows, $this->buildSorter($state->getOrderBy()));
            }elseif($state->isOrderDesc()){
                usort($rows, $this->buildSorter($state->getOrderBy()));
                $rows = array_reverse($rows);
            }
        }
        return $rows;
    }
    
    private function renderHeaders(State $state)
    {
        $result = '<tr>';
        foreach($this->config->getColumns() as $colKey => $column){
            $result .= '<th>';
            $result .= '<a href="/?orderBy=' . $colKey . '&' . $state->getNextOrderByParams() . '">' . $column->getLabel() . '</a>';
            if($colKey == $state->getOrderBy()){
                if($state->isOrderAsc()){
                    $result .= $this->renderArrowUp();
                }elseif($state->isOrderDesc()){
                    $result .= $this->renderArrowDown();
                }
            }
            $result .= '</th>';
        }
        $result .= '</tr>';
        return $result;
    }
    
    private function renderBody(array $rows, State $state){
        $result = '';
        $startIndex = $state->getStartRow();
        $stopIndex = $state->getStopRow();
        $counter = 0;
        foreach($rows as $row){
            if($counter >= $startIndex && $counter <= $stopIndex){
                $result .= $this->renderRow($row);
            }
            ++$counter;
        }
        return $result;
    }
    
    private function renderRow($row) : string
    {
        return '<tr>' . $this->config->getAllColumnsAsRow($row) . '</tr>';
    }
    
    private function renderPagination(int $rowsCount, State $state) : string
    {
        $result = '<nav aria-label="Page navigation example">
                    <ul class="pagination">
                      <li class="page-item">
                        <a class="page-link" href="?currentPage=1&orderBy=' . $state->getOrderBy() . '&orderType=' . $state->getOrderType() . '" aria-label="Previous">
                          <span aria-hidden="true">&laquo;</span>
                          <span class="sr-only">Previous</span>
                        </a>
                      </li>';
        $lastPage = 1;
        for($i = 1; (($i - 1) * $state->getRowsPerPage()) < $rowsCount; ++$i){
            $result .= '<li class="page-item"><a class="page-link" '
                    . 'href="/?currentPage=' . $i .'&orderBy=' . $state->getOrderBy() . '&orderType=' . $state->getOrderType() . '">' . $i . '</a></li>';
            $lastPage = $i;
        }
        $result .= '<li class="page-item">
                            <a class="page-link" href="?currentPage=' . $lastPage . '&orderBy=' . $state->getOrderBy() . '&orderType=' . $state->getOrderType() . '" aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                          <span class="sr-only">Next</span>
                        </a>
                      </li>
                    </ul>
                  </nav>';
        return $result;
    }
    
    private function getAllCellsInRow($row) : string 
    {
        $result = '';
        foreach($this->config->getColumns() as $kElem => $conf){
            $value = array_key_exists($kElem, $row) ? $row[$kElem] : NULL;
            $result .= $this->renderCell($conf->showColumnValue($value));
        }
        if(!$this->config->isValidRow()){
            $error = new Error();
            $result = '<td colspan="100%" class="text-danger">' . $error->rowError() . '</td>';
        }
        $this->config->clearColumnsError();
        return $result;
    }
    
    private function renderCell($value) : string
    {
        return '<td>' . $value . '</td>';
    }
    
    private function buildSorter($key){
        return function($a,$b) use ($key) {
            return $a[$key] <=> $b[$key];
        };
    }
    
    private function renderArrowDown(){
        return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-down" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                  </svg>';
    }
    
    private function renderArrowUp(){
        return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
                  </svg>';
    }
}
