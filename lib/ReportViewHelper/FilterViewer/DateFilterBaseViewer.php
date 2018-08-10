<?php
/**
 * Created by PhpStorm.
 * User: srvr4vr
 * Date: 23.07.2018
 * Time: 15:49
 */

namespace olof_spammer\ReportViewHelper\FilterViewer;

use olof_spammer\Interfaces;

abstract class DateFilterBaseViewer extends RangeFilterBaseViewer
{
    public function __construct($name, Interfaces\IReportViewHelper $helper, $title)
    {
        parent::__construct($name, $helper, $title);
        $this->fields[] = $this->nameWithPrefix . "_1_FILTER_PERIOD";
        $this->fields[] = $this->nameWithPrefix . "_1_FILTER_DIRECTION";
    }
}