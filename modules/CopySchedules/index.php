<?php

global $current_user;

$access = new AccessChecker();

$ac1=$access->getAccessCode("View Col Class Roster");
$ac2=$access->getAccessCode("View HS Class Roster");
$ac3=$access->getAccessCode("View Elem Class Roster");


if ($access->check_access($current_user->id,$ac1)) {
	include('modules/Reports/viewClassRosterCol.php');
} else if ($access->check_access($current_user->id,$ac2)) {
	include('modules/Reports/viewClassRosterHS.php');
} else if ($access->check_access($current_user->id,$ac3)) {
	include('modules/Reports/viewClassRosterElem.php');
}

?>
