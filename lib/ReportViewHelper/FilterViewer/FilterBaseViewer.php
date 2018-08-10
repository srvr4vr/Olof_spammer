<?php
namespace olof_spammer\ReportViewHelper\FilterViewer;


use olof_spammer\Interfaces;

abstract class FilterBaseViewer implements Interfaces\IFilterViewer
{
    public $type;
    public $name;
    public $title;

    protected $fields;
    /**
     * @var Interfaces\IReportViewHelper
     */
    protected $helper;


    public function getFields()
    {
        return $this->fields;
    }

    public function getTitle()
    {
        return ($this->title)? $this->title: $this->name;
    }

    /**
     * @return FilterData
     */
    public function getFilterData()
    {
        $arguments = array_reduce($this->fields, function ($carry, $item) {
            $value = $this->helper->getFieldValueByName(str_replace([' ','.'], '_', $item));
            $carry[] = $value;
            return $carry;
        }, []);
        if (self::ifHasArgs($arguments)) {
            return new FilterData($this->name, $this->type, $arguments);
            //return ["name"=>$this->name, "type"=> $this->type, "arguments"=> $arguments];
        }
        return null;
    }

    protected static function ifHasArgs($arguments)
    {
        foreach ($arguments as $arg) {
            if ($arg) {
                return true;
            }
        }
        return false;
    }

    protected $nameWithPrefix;

    protected function wrapName($name)
    {
        return str_replace([' ','.'], '_', $name);
    }

    abstract public function getHtml();

    /**
     * FilterBaseViewer constructor.
     * @param $name
     * @param Interfaces\IReportViewHelper $helper
     * @param $title
     */
    public function __construct($name, Interfaces\IReportViewHelper $helper, $title)
    {
        $this->title = ($title)?$title: $name;
        $this->nameWithPrefix = $helper->getPrefix() . $this->wrapName($name);
        $this->name = $name;
        $this->helper = $helper;
    }
}
