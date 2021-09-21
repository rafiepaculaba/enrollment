<?php

global $current_user;

$access = new AccessChecker();

$ac1=$access->getAccessCode("View Col Class Roster");
$ac2=$access->getAccessCode("View HS Class Roster");
$ac3=$access->getAccessCode("View Elem Class Roster");
$ac4=$access->getAccessCode("Generate Col Enrollment Status");
$ac5=$access->getAccessCode("Generate HS Enrollment Status");
$ac6=$access->getAccessCode("Generate Elem Enrollment Status");
$ac7=$access->getAccessCode("Collection Report Col");
$ac8=$access->getAccessCode("Collection Report HS");
$ac9=$access->getAccessCode("Collection Report Elem");
$ac10=$access->getAccessCode("View Receivable Col");
$ac11=$access->getAccessCode("View Receivable HS");
$ac12=$access->getAccessCode("View Receivable Elem");
$ac13=$access->getAccessCode("Teachers Load Col");
$ac14=$access->getAccessCode("Teachers Load HS");
$ac15=$access->getAccessCode("Teachers Load Elem");

$ac16=$access->getAccessCode("View Preschool Class Roster");
$ac17=$access->getAccessCode("Generate Preschool Enrollment Status");
$ac18=$access->getAccessCode("Collection Report Preschool");
$ac19=$access->getAccessCode("View Receivable Preschool");
$ac20=$access->getAccessCode("Teachers Load Preschool");
$ac21=$access->getAccessCode("Summary of Income Col");
$ac22=$access->getAccessCode("Cashier Report Col");


if ($access->check_access($current_user->id,$ac1)) {
	include('modules/Reports/viewClassRosterCol.php');
} else if ($access->check_access($current_user->id,$ac2)) {
	include('modules/Reports/viewClassRosterHS.php');
} else if ($access->check_access($current_user->id,$ac3)) {
	include('modules/Reports/viewClassRosterElem.php');
} else if ($access->check_access($current_user->id,$ac4)) {
	include('modules/Reports/generateEnrollmentStatusCol.php');
} else if ($access->check_access($current_user->id,$ac5)) {
	include('modules/Reports/generateEnrollmentStatusHS.php');
} else if ($access->check_access($current_user->id,$ac6)) {
	include('modules/Reports/generateEnrollmentStatusElem.php');
} else if ($access->check_access($current_user->id,$ac7)) {
	include('modules/Reports/collectionReportCol.php');
} else if ($access->check_access($current_user->id,$ac8)) {
	include('modules/Reports/collectionReportHS.php');
} else if ($access->check_access($current_user->id,$ac9)) {
	include('modules/Reports/collectionReportElem.php');
} else if ($access->check_access($current_user->id,$ac10)) {
	include('modules/Reports/receivableReportCol.php');
} else if ($access->check_access($current_user->id,$ac11)) {
	include('modules/Reports/receivableReportHS.php');
} else if ($access->check_access($current_user->id,$ac12)) {
	include('modules/Reports/receivableReportElem.php');
} else if ($access->check_access($current_user->id,$ac13)) {
	include('modules/Reports/teachersLoadCol.php');
} else if ($access->check_access($current_user->id,$ac14)) {
	include('modules/Reports/teachersLoadHS.php');
} else if ($access->check_access($current_user->id,$ac15)) {
	include('modules/Reports/teachersLoadElem.php');
} else if ($access->check_access($current_user->id,$ac16)) {
	include('modules/Reports/viewClassRosterPreschool.php');
} else if ($access->check_access($current_user->id,$ac17)) {
	include('modules/Reports/generateEnrollmentStatusElem.php');
} else if ($access->check_access($current_user->id,$ac18)) {
	include('modules/Reports/collectionReportPreschool.php');
} else if ($access->check_access($current_user->id,$ac19)) {
	include('modules/Reports/receivableReportPreschool.php');
} else if ($access->check_access($current_user->id,$ac20)) {
	include('modules/Reports/teachersLoadPreschool.php');
} else if ($access->check_access($current_user->id,$ac21)) {
	include('modules/Reports/summaryIncomeCol.php');
} else if ($access->check_access($current_user->id,$ac22)) {
	include('modules/Reports/cashierReportCol.php');
}

?>
