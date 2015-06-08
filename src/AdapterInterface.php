<?php
/**
 * Created by PhpStorm.
 * User: Rob
 * Date: 25-4-2015
 * Time: 22:28
 */

namespace Robth82\ReportAbstraction;


interface AdapterInterface {
    public function getReports($path, $search);
    public function runReport($path, $format, $page, $options);
    public function getReportOptions($path);
} 