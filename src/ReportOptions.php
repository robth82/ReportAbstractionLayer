<?php
/**
 * Created by PhpStorm.
 * User: Rob
 * Date: 8-6-2015
 * Time: 22:00
 */

namespace Robth82\ReportAbstraction;


class ReportOptions {
    private $id;
    private $options = [];

    function __construct($id)
    {
        $this->id = $id;
    }


    public function addOption(ReportOption $option) {
        $this->options[] = $option;
    }

    public function getOptions() {
        return $this->options;

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }




} 