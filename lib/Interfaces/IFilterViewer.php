<?php
/**
 * Created by PhpStorm.
 * User: srvr4vr
 * Date: 09.08.2018
 * Time: 14:15
 */

namespace olof_spammer\Interfaces;

use olof_spammer\FilterData;


interface IFilterViewer
{
    public function getHtml();
    public function getFields();

    /**
     * @return FilterData
     */
    public function getFilterData();
    public function __construct($name, IReportViewHelper $helper, $title);

}