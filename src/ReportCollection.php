<?php
/**
 * Created by PhpStorm.
 * User: Rob
 * Date: 25-4-2015
 * Time: 23:33
 */

namespace Robth82\ReportAbstraction;


class ReportCollection {
    protected $collection;

    public function addReport(Report $report) {
        $this->collection[] = $report;
    }

    /**
     * @return array with Report
     */
    public function getReports() {
        return $this->collection;
    }
} 