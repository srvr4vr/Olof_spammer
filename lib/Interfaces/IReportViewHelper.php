<?php
/**
 * Created by PhpStorm.
 * User: srvr4vr
 * Date: 09.08.2018
 * Time: 14:01
 */

namespace olof_spammer\Interfaces;

interface IReportViewHelper
{
    public function getFindParams();
    public function getFiltersData();
    public function getFieldValueByName($name);
    public function getPrefix();
    public function getUniqueValuesFromField($columnName): array;
    public function writeFilterTable();
    public function getFindFields();

}