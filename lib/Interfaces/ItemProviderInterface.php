<?php
/**
 * Created by PhpStorm.
 * User: srvr4vr
 * Date: 09.08.2018
 * Time: 13:47
 */

namespace olof_spammer\Interfaces;


interface ItemProviderInterface
{
    public function getMap(): array;
    public function getList(array $filter = []);
    public function getFilters(): array;
    public function getUniqueValuesFromField($columnName) : array ;
}