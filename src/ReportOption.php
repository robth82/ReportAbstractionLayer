<?php
/**
 * Created by PhpStorm.
 * User: Rob
 * Date: 8-6-2015
 * Time: 22:00
 */

namespace Robth82\ReportAbstraction;


class ReportOption {
    private $label;
    private $value;
    private $selected;

    function __construct($label, $selected, $value)
    {
        $this->label = $label;
        $this->selected = $selected;
        $this->value = $value;
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
    public function getSelected()
    {
        return $this->selected;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }




} 