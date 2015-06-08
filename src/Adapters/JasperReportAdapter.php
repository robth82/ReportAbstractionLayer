<?php
/**
 * Created by PhpStorm.
 * User: Rob
 * Date: 25-4-2015
 * Time: 22:19
 */

namespace Robth82\ReportAbstraction\Adapters;


use Jaspersoft\Client\Client;
use Robth82\ReportAbstraction\AdapterInterface;
use Robth82\ReportAbstraction\Report;
use Robth82\ReportAbstraction\ReportCollection;
use Robth82\ReportAbstraction\ReportOption;
use Robth82\ReportAbstraction\ReportOptions;
use Robth82\ReportAbstraction\UnknownFormatException;

class JasperReportAdapter implements AdapterInterface {
    private $jasperClient;

    function __construct(Client $jasperClient)
    {
        $this->jasperClient = $jasperClient;
    }

    public function getReports($path, $search)
    {
        $criteria = new \Jaspersoft\Service\Criteria\RepositorySearchCriteria($search);
        $criteria->folderUri = $path;

        $jobs = $this->jasperClient->repositoryService()->searchResources($criteria);

        $collection = new ReportCollection();
        foreach($jobs->items as $job) {
//var_dump($job);
            $collection->addReport($this->createReport($job));
        }
        return $collection;
    }

    private function checkSupportedFormats($path, $format) {
        $posibleFormats = ['pdf', 'html', 'xls', 'xlsx', 'rtf', 'csv', 'xml', 'docx', 'odt', 'ods', 'jprint'];
        if(!in_array($format, $posibleFormats)) {
            throw new UnknownFormatException($format);
        }
    }

    public function runReport($path, $format, $page = null, $options = null)
    {
        $this->checkSupportedFormats($path, $format);


        if($format == 'html') {
            return $this->runHtmlReport($path, $page, $options);
        }

        $report = $this->jasperClient->reportService()->runReport($path, $format, $page, null, $options, true);



        return $report;
    }


    public function runHtmlReport($path, $page, $input) {


        $reportXML = $this->jasperClient->reportService()->runReport($path, 'xml', $page, null, $input, true);

        $docXML = new \DOMDocument();
        $docXML->loadXML($reportXML); //mark the use of loadXML
        $imagesXML = $docXML->getElementsByTagName('image');
        $imagesBase64 = array();
        foreach ($imagesXML as $image) {
            foreach ($image->childNodes as $child) {
                if ($child->nodeName == 'imageSource') {
                    $imagesBase64[] = $child->textContent;
                }
            }
        }

        $reportHTML = $this->jasperClient->reportService()->runReport($path, 'html', $page, null, $input, true);

        $reportHTML2 = preg_replace_callback('#src=["\']([^"\']+)["\']#', function($matches) use (&$imagesBase64) { return 'src="data:image/png;base64,'.trim(array_shift($imagesBase64).'"');}, $reportHTML);

        return $reportHTML2;
    }

    public function getOptions($path) {
        $report_options = $this->jasperClient->reportService()->getReportInputControls($path);
        var_dump($report_options);
        die();
    }

    private function createReport(\Jaspersoft\Dto\Resource\ResourceLookup $job) {
        $report = new Report($job->uri, $job->label, $job->description);
        return $report;
    }

    public function getReportOptions($path) {
        $reportOptions = $this->jasperClient->reportService()->getReportInputControls($path);

//        echo  '<pre>';
//        print_r($reportOptions);
//        echo  '</pre>';

        $returnOptions = [];
        /** @var \Jaspersoft\Dto\Report\InputControl $reportOption */
        foreach ($reportOptions as $reportOption) {
            $returnOption = new ReportOptions($reportOption->id);
            foreach($reportOption->options as $option)
            {
                $returnOption->addOption(new ReportOption($option['label'], $option['selected'] == 'true', $option['value']));
            }
            $returnOptions[] = $returnOption;
        }

        return $returnOptions;
    }


} 