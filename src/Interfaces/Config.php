<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Interfaces;

/**
 *
 * @author Kuba
 */
interface Config {
    /**
     * Dodaje nową kolumną do DataGrid.
     */
    public function addColumn(string $key, Column $column): Config;

    /**
     * Zwraca wszystkie kolumny dla danego DataGrid.
     */
    public function getColumns(): array;
}
