<?php
/**
 * Created by PhpStorm.
 * User: srvr4vr
 * Date: 09.08.2018
 * Time: 14:31
 */

namespace olof_spammer;

class Filter
{
    public $key;
    public $type;
    public $title;

    /**
     * Filter constructor.
     * @param $key
     * @param $title
     * @param $type
     */
    public function __construct($key, $title, $type)
    {
        $this->key = $key;
        $this->type = $type;
        $this->title = $title;
    }
}