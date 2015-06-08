<?php
/**
 * Created by PhpStorm.
 * User: Rob
 * Date: 25-4-2015
 * Time: 23:33
 */

namespace Robth82\ReportAbstraction;


class Report {
    private $path;
    private $label;
    private $description;

    function __construct($path, $label, $description)
    {
        $this->path = $path;
        $this->label = $label;
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

} 