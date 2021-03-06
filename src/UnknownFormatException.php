<?php
/**
 * Created by PhpStorm.
 * User: Rob
 * Date: 8-6-2015
 * Time: 21:17
 */

namespace Robth82\ReportAbstraction;


use Exception;

/**
 * Class UnknownFormatException
 * @package Robth82\ReportAbstraction\Adapters
 */
class UnknownFormatException extends \Exception {

    public function __construct($format = "", $code = 0, Exception $previous = null)
    {
        $message = 'Unknown format: ' . $format;
        parent::__construct($message, $code, $previous); // TODO: Change the autogenerated stub
    }


} 