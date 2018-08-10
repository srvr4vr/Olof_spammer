<?php
namespace olof_spammer\ReportViewHelper\FilterViewer;

use olof_spammer\Interfaces;

abstract class RangeFilterBaseViewer extends FilterBaseViewer
{
    public function __construct($name, Interfaces\IReportViewHelper $helper, $title)
    {
        parent::__construct($name, $helper, $title);
        $this->fields[] = $this->nameWithPrefix . $name."_1";
        $this->fields[] = $this->nameWithPrefix . $name."_2";
    }
}
