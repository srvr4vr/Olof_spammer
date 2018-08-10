<?php
/**
 * Created by PhpStorm.
 * User: srvr4vr
 * Date: 09.08.2018
 * Time: 14:16
 */

namespace olof_spammer\ReportViewHelper\FilterViewer;


class FilterData
{
    public $name;
    public $type;
    /**
     * @var array
     */
    public $arguments;

    /**
     * FilterData constructor.
     * @param $name
     * @param $type
     * @param array $arguments
     */
    public function __construct($name, $type, $arguments)
    {
        $this->name = $name;
        $this->type = $type;
        $this->arguments = $arguments;
    }
}