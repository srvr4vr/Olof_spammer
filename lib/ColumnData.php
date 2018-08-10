<?php
/**
 * Created by PhpStorm.
 * User: srvr4vr
 * Date: 09.08.2018
 * Time: 15:14
 */

namespace olof_spammer;


class ColumnData
{
    /**
     * @var string
     */
    public $id;
    /**
     * @var string
     */
    public $content;
    /**
     * @var string
     */
    public $sort;
    /**
     * @var bool
     */
    public $default;

    public static function createByName($name)
    {
        return new self($name, $name, $name, true);
    }

    public function __construct(string $id, string $content, string $sort, bool $default = true)
    {
        $this->id = $id;
        $this->content = $content;
        $this->sort = $sort;
        $this->default = $default;
    }

    /**
     * @return array
     */
    public function asArray(): array
    {
        $result['id'] = $this->id;
        $result['content'] = $this->content;
        $result['sort'] = $this->sort;
        $result['default'] = $this->default;
        return $result;
    }
}