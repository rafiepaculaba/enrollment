<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version
 * 1.1.3 ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied.  See the License
 * for the specific language governing rights and limitations under the
 * License.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *    (i) the "Powered by SugarCRM" logo and
 *    (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * The Original Code is: SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) 2004-2006 SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
if(!is_admin($current_user)) sugar_die("Unauthorized access to administration.");

require_once('modules/Calls/Call.php');
require_once('modules/Meetings/Meeting.php');

$callBean = new Call();
$callQuery = "SELECT * FROM calls where calls.status != 'Held' and calls.deleted=0";
//$callQuery = "SELECT * FROM calls where calls.name like '1' and calls.deleted=0";

$result = $callBean->db->query($callQuery, true, "");
$row = $callBean->db->fetchByAssoc($result);
while ($row != null) {
	$timeStartArr = split(' ', $row['time_start']);
	if (isset($timeStartArr[1]))
		$timeStart = $timeStartArr[1];
	else
		$timeStart = $timeStartArr[0];
	$date_time_start =DateTimeUtil::get_time_start($row['date_start'],$timeStart);
    $date_time_end =DateTimeUtil::get_time_end($date_time_start,$row['duration_hours'], $row['duration_minutes']);
    $date_end = "{$date_time_end->year}-{$date_time_end->month}-{$date_time_end->day}";
	$updateQuery = "UPDATE calls set calls.date_end='{$date_end}' where calls.id='{$row['id']}'";
	$call = new Call();
    $call->db->query($updateQuery); 
    $row = $callBean->db->fetchByAssoc($result);
}

$meetingBean = new Meeting();
$meetingQuery = "SELECT * FROM meetings where meetings.status != 'Held' and meetings.deleted=0";
//$meetingQuery = "SELECT * FROM meetings where meetings.name like '1' and meetings.deleted=0";

$result = $meetingBean->db->query($meetingQuery, true, "");
$row = $meetingBean->db->fetchByAssoc($result);
while ($row != null) {
	$timeStartArr = split(' ', $row['time_start']);
	if (isset($timeStartArr[1]))
		$timeStart = $timeStartArr[1];
	else
		$timeStart = $timeStartArr[0];
	$date_time_start =DateTimeUtil::get_time_start($row['date_start'],$timeStart);
    $date_time_end =DateTimeUtil::get_time_end($date_time_start,$row['duration_hours'], $row['duration_minutes']);
    $date_end = "{$date_time_end->year}-{$date_time_end->month}-{$date_time_end->day}";
	$updateQuery = "UPDATE meetings set meetings.date_end='{$date_end}' where meetings.id='{$row['id']}'";
	$meeting = new Meeting();
    $meeting->db->query($updateQuery); 
    $row = $meetingBean->db->fetchByAssoc($result);
}
echo $mod_strings['LBL_DIAGNOSTIC_DONE'];

