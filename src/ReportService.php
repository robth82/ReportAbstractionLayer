<?php
/**
 * Created by PhpStorm.
 * User: Rob
 * Date: 25-4-2015
 * Time: 22:18
 */

namespace Robth82\ReportAbstraction;


use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReportService {
    private $adapter;
    private $options;

    function __construct(AdapterInterface $adapter, array $options = [])
    {
        $this->adapter = $adapter;

        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }

    protected function configureOptions(OptionsResolverInterface $options) {
        return $options;
    }

    /**
     * @param $path
     * @param $search
     * @return ReportCollection
     */
    public function getReports($path, $search) {
        return $this->adapter->getReports($path, $search);
    }

    public function runReport($path, $format, $page = null, $options) {
        return $this->adapter->runReport($path, $format, $page, $options);
    }

    public function getReportOptions($path) {
        return $this->adapter->getReportOptions($path);
    }


} 