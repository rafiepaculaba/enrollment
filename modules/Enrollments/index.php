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

global $current_user;

$access = new AccessChecker();

$ac1=$access->getAccessCode("List Col Enrollment");
$ac2=$access->getAccessCode("List HS Enrollment");
$ac3=$access->getAccessCode("List Elem Enrollment");
$ac4=$access->getAccessCode("List Old Enrollment");
$ac5=$access->getAccessCode("List Preschool Enrollment");

if ($access->check_access($current_user->id,$ac1)) {
    include('modules/Enrollments/listEnrollmentsCol.php');
} else if ($access->check_access($current_user->id,$ac2)) {
    include('modules/Enrollments/listEnrollmentsHS.php');
} else if ($access->check_access($current_user->id,$ac3)) {
    include('modules/Enrollments/listEnrollmentsElem.php');
} else if ($access->check_access($current_user->id,$ac4)) {
    include('modules/Enrollments/listOldEnrollmentsCol.php');
} else if ($access->check_access($current_user->id,$ac5)) {
    include('modules/Enrollments/listEnrollmentsPreschool.php');
}




?>
