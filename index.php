<?php


include('bootstrap.php');

//$template = $twig->loadTemplate('index.twig');

use Jaspersoft\Client\Client;
use Robth82\ReportAbstraction\Adapters\JasperReportAdapter;
use Robth82\ReportAbstraction\Report;
use Robth82\ReportAbstraction\ReportService;

$c = new Client(
    "http://localhost:8080/jasperserver",
    "jasperadmin",
    "jasperadmin"
);

$reportService = new ReportService(new JasperReportAdapter($c));


if(!isset($_GET['report'])) {
    $result = $reportService->getReports('/reports', '');

    /** @var Report $report */
    foreach($result->getReports() as $report) {
        echo '<a href="index.php?report=' . $report->getPath() . '">' . $report->getLabel() . '</a><Br/>';
    }
    //var_dump($result);
} else {
//    header('Content-Type: application/pdf');
//    header('Content-Disposition: attachment; filename="downloaded.pdf"');
    $controls = array(
        'Country_multi_select' => array('USA', 'Mexico'),
        'Cascading_state_multi_select' => array('CA', 'OR')
    );

    $options = $reportService->getReportOptions($_GET['report']);
    echo '<form method="post">';
    /** @var \Robth82\ReportAbstraction\ReportOptions $option */
    foreach($options as $option) {
        //var_dump();
        echo '<select multiple name="' . $option->getId() . '[]" size=10>';
        /** @var \Robth82\ReportAbstraction\ReportOption $field */
        foreach ($option->getOptions() as $field) {
            echo '<option value="'.$field->getValue().'" ' . ($field->getSelected() ? 'selected' : '') . '>' . $field->getLabel() . '</option>';
        }
        echo '</select> ';
    }
    echo '<button>Report</button>';
    echo '</form>';
//var_dump($_POST);
//var_dump($controls);
//    print_r($options);
//    echo '<pre>';

    try {
        echo $reportService->runReport($_GET['report'], 'html', null, $_POST);
    } catch (\Exception $e) {
        echo '<pre>';
        print_r($e);
        echo '</pre>';
    }

}


?>