<?php
namespace olof_spammer\ReportViewHelper\FilterViewer;

use olof_spammer\Interfaces;

class FormFilterFactory
{
    protected $helper;

    public function __construct(FilterHelper $helper)
    {
        $this->helper = $helper;
    }


    public function getFilterViewer($name, $title="", $type="") : Interfaces\IFilterViewer
    {
        $name = trim($name);
        switch ($type) {
          case 'range':
              return new RangeInputFilter($name, $this->helper, $title);
          case 'date':
              return new DateInputFilter($name, $this->helper, $title);
          case 'datex':
              return new DateInputFilter($name, $this->helper, $title, true);
          case 'select':
              return new SelectInputFilterViewer($name, $this->helper, $title);
          default:
              return new SimpleInputFilterViewer($name, $this->helper, $title);
        }
    }
}
