<script>
  $(document).on('hidden.bs.modal',  function (e) {
        var target = $(e.target);
        target.removeData('bs.modal')
              .find(".modal-body").html('');	var div = document.getElementById('modal-body');
	var div = document.getElementById('modal-body');
	div.innerHTML = div.innerHTML + '<i class="fa fa-times modal-close" data-dismiss="modal"></i><div class="div-modal-body"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>';
    });

</script>
<div class="modal-body" id="modal-body">
<i class="fa fa-times modal-close" data-dismiss="modal"></i>
<table class="table1">
                <thead>
                    <tr>
                        <th></th>
                        <th scope="col" abbr="zadnjih7dana">7 dana</th>
                        <th scope="col" abbr="ukupno">Ukupno</th>
                     </tr>
                </thead>
                <tbody id="ga_modal_body">

<?php
/// Load the Google API PHP Client Library.
// more CI like. scavara-09022017
require_once(APPPATH.'SET_PROPER_LOCATION/google.php');

$analytics = initializeAnalytics();
$realTimeanalytics = initializeRealTimeAnalytics();
$response = getReport($analytics);
$responseEmbed = getEmbedReport($analytics);
$responseEvents = getEventsReport($analytics);
printResults($response);
printEmbedResults($responseEmbed);
printEventsResults($responseEvents);

function initializeAnalytics()
{
  /// Creates and returns the Analytics Reporting service object.
  // Use the developers console and download your service account
  // credentials in JSON format. Place them in this directory or
  // change the key file location if necessary.
  // $KEY_FILE_LOCATION = __DIR__ . '/service-account-credentials.json';
  // TODO: change the location to something 'nicer'. scavara-10022017
  $KEY_FILE_LOCATION = APPPATH.'SETPROPERLOCATION/SETPROPERNAMEOFJSONFILE.json';

  /// Create and configure a new client object.
  $client = new Google_Client();
  $client->setApplicationName("Hello from SET_YOUR_SITE_NAME, Analytics Reporting");
  $client->setAuthConfig($KEY_FILE_LOCATION);
  $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
  $analytics = new Google_Service_AnalyticsReporting($client);

  return $analytics;
}

function initializeRealTimeAnalytics()
{
  $KEY_FILE_LOCATION = APPPATH.'SETPROPERLOCATION/SETPROPERNAMEOFJSONFILE.json';
  $client = new Google_Client();
  $client->setApplicationName("Hello from YOUR SITE, Realtime Analytics");
  $client->setAuthConfig($KEY_FILE_LOCATION);
  $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
  $URI = $_SERVER['HTTP_REFERER'];
  $FILTERED_LINK = parse_url($URI, PHP_URL_PATH);
  $optParams = array(
	'filters' => "ga:pagePath==$FILTERED_LINK");

  $service = new Google_Service_Analytics($client);
	try {
    $realTimeResult = $service->data_realtime->get(
        "ga:SET_PROPER_ID",
        "rt:activeVisitors",
        $optParams);
} catch(Exception $e) {
//    var_dump($e);
	print("Invalid request. Can't process active users.");
}
  return $realTimeResult;
}

function getReport($analytics) {
  $VIEW_ID = "SET_PROPER_ID";
  $SEEK = array("embed","stream","watch");
  $URI = $_SERVER['HTTP_REFERER'];
  $FILTERED_LINK = parse_url($URI, PHP_URL_PATH);
  $RURI = str_replace($SEEK,".*",$FILTERED_LINK);

  /// Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate("7daysAgo");
  $dateRange->setEndDate("today");
  
  $dateRangeWeek = new Google_Service_AnalyticsReporting_DateRange();
  $dateRangeWeek->setStartDate("SET_PROPER_DATE_WHEN_YOU_STARTED_COLLECTING_GA_STATS-EX_2015-11-15");
  $dateRangeWeek->setEndDate("today");

  /// Create the Metrics object.
  $pageViews = new Google_Service_AnalyticsReporting_Metric();
  $pageViews->setExpression("ga:pageviews");
  $pageViews->setAlias("Broj pregleda");
  $pageViewsUnique = new Google_Service_AnalyticsReporting_Metric();
  $pageViewsUnique->setExpression("ga:uniquePageviews");
  $pageViewsUnique->setAlias("Number of unique views");
  $visitors = new Google_Service_AnalyticsReporting_Metric();
  $visitors->setExpression("ga:visitors");
  $visitors->setAlias("Number of visitors");
  $avgTimeOnPage = new Google_Service_AnalyticsReporting_Metric();
  $avgTimeOnPage->setExpression("ga:avgTimeOnPage");
  $avgTimeOnPage->setAlias("Average tiem spent on page");
 
  /// Create Dimension Filter.
  $dimensionFilter = new Google_Service_AnalyticsReporting_DimensionFilter();
  $dimensionFilter->setDimensionName("ga:pagePath");
  $dimensionFilter->setOperator("REGEXP");
  $dimensionFilter->setExpressions(array("$RURI"));
  $dimensionFilterClause = new Google_Service_AnalyticsReporting_DimensionFilterClause();
  $dimensionFilterClause->setFilters([$dimensionFilter]);

/// Create the ReportRequest object.
$request = new Google_Service_AnalyticsReporting_ReportRequest();
$request->setViewId($VIEW_ID);
$request->setDateRanges(array($dateRange,$dateRangeWeek));
$request->setMetrics(array($pageViews,$pageViewsUnique,$visitors,$avgTimeOnPage));
$request->setDimensionFilterClauses([$dimensionFilterClause]);
$body = new Google_Service_AnalyticsReporting_GetReportsRequest();
$body->setReportRequests( array( $request ) );
return $analytics->reports->batchGet( $body );
}

function getEmbedReport($analytics) {
  $VIEW_ID = "SET_PROPER_ID";
  $SEEK = array("stream","watch");
  $URI = $_SERVER['HTTP_REFERER'];
  $FILTERED_LINK = parse_url($URI, PHP_URL_PATH);
  $RURI = str_replace($SEEK,"embed","$FILTERED_LINK");

  /// Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate("7daysAgo");
  $dateRange->setEndDate("today");
  
  $dateRangeWeek = new Google_Service_AnalyticsReporting_DateRange();
  $dateRangeWeek->setStartDate("2015-11-15");
  $dateRangeWeek->setEndDate("today");

  /// Create the Metrics object.
  $pageViews = new Google_Service_AnalyticsReporting_Metric();
  $pageViews->setExpression("ga:pageviews");
  $pageViews->setAlias("Number of page view that has embed in URL");

  /// Create Dimension Filter.
  $dimensionFilter = new Google_Service_AnalyticsReporting_DimensionFilter();
  $dimensionFilter->setDimensionName("ga:pagePath");
  $dimensionFilter->setOperator("EXACT");
  $dimensionFilter->setExpressions(array("$RURI"));
  $dimensionFilterClause = new Google_Service_AnalyticsReporting_DimensionFilterClause();
  $dimensionFilterClause->setFilters([$dimensionFilter]);

/// Create the ReportRequest object.
$request = new Google_Service_AnalyticsReporting_ReportRequest();
$request->setViewId($VIEW_ID);
$request->setDateRanges(array($dateRange,$dateRangeWeek));
$request->setMetrics(array($pageViews));
$request->setDimensionFilterClauses([$dimensionFilterClause]);
$body = new Google_Service_AnalyticsReporting_GetReportsRequest();
$body->setReportRequests( array( $request ) );
return $analytics->reports->batchGet( $body );
}

function getEventsReport($analytics) {
  $VIEW_ID = "SET_PROPER_ID";
  $SEEK = array("embed","stream","watch");
  $URI = $_SERVER['HTTP_REFERER'];
  $FILTERED_LINK = parse_url($URI, PHP_URL_PATH);
  $RURI = str_replace($SEEK,".*",$FILTERED_LINK);

  /// Create the DateRange object.
  $dateRange = new Google_Service_AnalyticsReporting_DateRange();
  $dateRange->setStartDate("7daysAgo");
  $dateRange->setEndDate("today");
  
  $dateRangeWeek = new Google_Service_AnalyticsReporting_DateRange();
  $dateRangeWeek->setStartDate("2015-11-15");
  $dateRangeWeek->setEndDate("today");

  /// Create the Metrics object.
  $totalEvents = new Google_Service_AnalyticsReporting_Metric();
  $totalEvents->setExpression("ga:totalEvents");
  $totalEvents->setAlias("Number of events on video player(jw)");
 
  /// Create Dimension Filter.
  $dimensionFilter = new Google_Service_AnalyticsReporting_DimensionFilter();
  $dimensionFilter->setDimensionName("ga:pagePath");
  $dimensionFilter->setOperator("REGEXP");
  $dimensionFilter->setExpressions(array("$RURI"));
  $dimensionFilterClause = new Google_Service_AnalyticsReporting_DimensionFilterClause();
  $dimensionFilterClause->setFilters([$dimensionFilter]);

/// Create the ReportRequest object.
$request = new Google_Service_AnalyticsReporting_ReportRequest();
$request->setViewId($VIEW_ID);
$request->setDateRanges(array($dateRange,$dateRangeWeek));
$request->setMetrics(array($totalEvents));
$request->setDimensionFilterClauses([$dimensionFilterClause]);
$body = new Google_Service_AnalyticsReporting_GetReportsRequest();
$body->setReportRequests( array( $request ) );
return $analytics->reports->batchGet( $body );
}

function printResults(&$reports) {
  for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
    $report = $reports[ $reportIndex ];
    $header = $report->getColumnHeader();
    $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
    $rows = $report->getData()->getRows();
    for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
	$row = $rows[ $rowIndex ];
	$metrics = $row->getMetrics();
	for ( $i = 0; $i < count($metricHeaders); $i++ ) {
		$lastweek = $metrics[0]->getValues();
		$total = $metrics[1]->getValues();
		$entry = $metricHeaders[$i];
		if ( $i == 3 ) {
		print("<tr><th scope='row'>" .  $entry->getName() . "</th>");
	        print("<td>" . round($lastweek[$i]) . "</td><td>" . round($total[$i]) . "</td></tr>");
		} else {
		print("<tr><th scope='row'>" .  $entry->getName() . "</th>");
	        print("<td>" . $lastweek[$i] . "</td><td>" . $total[$i] . "</td></tr>");
		}
	}
    }
  }
}

function printEmbedResults(&$reports) {
  for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
    $report = $reports[ $reportIndex ];
    $header = $report->getColumnHeader();
    $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
    $rows = $report->getData()->getRows();
    for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
	$row = $rows[ $rowIndex ];
	$metrics = $row->getMetrics();
	for ( $i = 0; $i < count($metricHeaders); $i++ ) {
		$lastweek = $metrics[0]->getValues();
		$total = $metrics[1]->getValues();
		$entry = $metricHeaders[$i];
		print("<tr><th scope='row'>" .  $entry->getName() . "</th>");
	        print("<td>" . $lastweek[$i] . "</td><td>" . $total[$i] . "</td></tr>");
	}
    }
  }
}

function printEventsResults(&$reports) {
  for ( $reportIndex = 0; $reportIndex < count( $reports ); $reportIndex++ ) {
    $report = $reports[ $reportIndex ];
    $header = $report->getColumnHeader();
    $metricHeaders = $header->getMetricHeader()->getMetricHeaderEntries();
    $rows = $report->getData()->getRows();
    for ( $rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
	$row = $rows[ $rowIndex ];
	$metrics = $row->getMetrics();
	for ( $i = 0; $i < count($metricHeaders); $i++ ) {
		$lastweek = $metrics[0]->getValues();
		$total = $metrics[1]->getValues();
		$entry = $metricHeaders[$i];
		print("<tr><th scope='row'>" .  $entry->getName() . "</th>");
	        print("<td>" . $lastweek[$i] . "</td><td>" . $total[$i] . "</td></tr>");
	}
    }
  }
}

print("<tr><th></th><td></td>");
print("<tr><th scope='row'>Trenutno aktivni korisnici</th>");
print("<td>" . $realTimeanalytics->totalsForAllResults['rt:activeVisitors'] . "</td></tr>");
?>
                </tbody>
            </table>
      </div>
      <div class="modal-footer div-modal-footer">
      </div>
