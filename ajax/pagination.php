<?php
require_once('model/dbhandler.php');
require_once('model/model.overview.php');
$overviewService = new OverviewService();
echo $overviewService->createPageContent($_POST['page']);