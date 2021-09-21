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
/*********************************************************************************gf

 * Description:  Executes a step in the installation process.
 ********************************************************************************/
session_start();

require_once('include\blumango\classes\utils\AccessChecker.php');

$access = new AccessChecker();
$user_id = $_SESSION['oUser']->id;

$moduleList = array();
// this list defines the modules shown in the top tab list of the app
//the order of this list is the default order displayed - do not change the order unless it is on purpose
// global user
$moduleList[] = 'Home';

// for registration tab
$accessCode1 = $access->getAccessCode("List Col Registration");
$accessCode2 = $access->getAccessCode("Create Col Registration");
$accessCode3 = $access->getAccessCode("List HS Registration");
$accessCode4 = $access->getAccessCode("Create HS Registration");
$accessCode5 = $access->getAccessCode("List Elem Registration");
$accessCode6 = $access->getAccessCode("Create Elem Registration");
    
if ( $access->check_access($user_id,$accessCode1,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode2,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode3,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode4,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode5,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode6,$_SESSION['oUser']->is_admin) ) {
    $moduleList[] = 'Registrations';
}

// for student tab
$accessCode1 = $access->getAccessCode("List Col Student");
$accessCode2 = $access->getAccessCode("Create Col Student");
$accessCode3 = $access->getAccessCode("List HS Student");
$accessCode4 = $access->getAccessCode("Create HS Student");
$accessCode5 = $access->getAccessCode("List Elem Student");
$accessCode6 = $access->getAccessCode("Create Elem Student");
if ( $access->check_access($user_id,$accessCode1,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode2,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode3,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode4,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode5,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode6,$_SESSION['oUser']->is_admin) ) {
    $moduleList[] = 'Students';
}

// for account tab
$accessCode1 = $access->getAccessCode("List Col Account");
$accessCode2 = $access->getAccessCode("List HS Account");
$accessCode3 = $access->getAccessCode("List Elem Account");
$accessCode4 = $access->getAccessCode("List Col Assessment");
$accessCode5 = $access->getAccessCode("Create Col Assessment");
$accessCode6 = $access->getAccessCode("List HS Assessment");
$accessCode7 = $access->getAccessCode("Create HS Assessment");
$accessCode8 = $access->getAccessCode("List Elem Assessment");
$accessCode9 = $access->getAccessCode("Create Elem Assessment");
if ( $access->check_access($user_id,$accessCode1,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode2,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode3,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode4,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode5,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode6,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode7,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode8,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode9,$_SESSION['oUser']->is_admin) ) {
    $moduleList[] = 'Account';
}

// for department tab
$accessCode1 = $access->getAccessCode("List Department");
$accessCode2 = $access->getAccessCode("Create Department");
if ( $access->check_access($user_id,$accessCode1,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode2,$_SESSION['oUser']->is_admin) ) {
    $moduleList[] = 'Departments';
}

$accessCode1 = $access->getAccessCode("List Course");
$accessCode2 = $access->getAccessCode("Create Course");
if ( $access->check_access($user_id,$accessCode1,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode2,$_SESSION['oUser']->is_admin) ) {
    $moduleList[] = 'Courses';
}


// for subject tab
$accessCode1 = $access->getAccessCode("List Col Subject");
$accessCode2 = $access->getAccessCode("Create Col Subject");
$accessCode3 = $access->getAccessCode("List HS Subject");
$accessCode4 = $access->getAccessCode("Create HS Subject");
$accessCode5 = $access->getAccessCode("List Elem Subject");
$accessCode6 = $access->getAccessCode("Create Elem Subject");
if ( $access->check_access($user_id,$accessCode1,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode2,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode3,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode4,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode5,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode6,$_SESSION['oUser']->is_admin) ) {
    $moduleList[] = 'Subjects';
}
    
// for schedule tab
$accessCode1 = $access->getAccessCode("List Col Subject");
$accessCode2 = $access->getAccessCode("Create Col Subject");
$accessCode3 = $access->getAccessCode("List HS Subject");
$accessCode4 = $access->getAccessCode("Create HS Subject");
$accessCode5 = $access->getAccessCode("List Elem Subject");
$accessCode6 = $access->getAccessCode("Create Elem Subject");

$accessCode7 = $access->getAccessCode("List Col Block Section");
$accessCode8 = $access->getAccessCode("Create Col Block Section");
$accessCode9 = $access->getAccessCode("List HS Block Section");
$accessCode10 = $access->getAccessCode("Create HS Block Section");
$accessCode11 = $access->getAccessCode("List Elem Block Section");
$accessCode12 = $access->getAccessCode("Create Elem Block Section");
if ( $access->check_access($user_id,$accessCode1,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode2,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode3,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode4,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode5,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode6,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode7,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode8,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode9,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode10,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode11,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode12,$_SESSION['oUser']->is_admin) ) {
    $moduleList[] = 'Schedules';
}

// cashier

// for payments tab
$accessCode1 = $access->getAccessCode("List Col Payment");
$accessCode2 = $access->getAccessCode("Create Col Payment");
$accessCode3 = $access->getAccessCode("List HS Payment");
$accessCode4 = $access->getAccessCode("Create HS Payment");
$accessCode5 = $access->getAccessCode("List Elem Payment");
$accessCode6 = $access->getAccessCode("Create Elem Payment");

$accessCode7 = $access->getAccessCode("List Col Registration Payment");
$accessCode8 = $access->getAccessCode("Create Col Registration Payment");
$accessCode9 = $access->getAccessCode("List HS Registration Payment");
$accessCode10 = $access->getAccessCode("Create HS Registration Payment");
$accessCode11 = $access->getAccessCode("List Elem Registration Payment");
$accessCode12 = $access->getAccessCode("Create Elem Registration Payment");
if ( $access->check_access($user_id,$accessCode1,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode2,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode3,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode4,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode5,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode6,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode7,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode8,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode9,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode10,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode11,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode12,$_SESSION['oUser']->is_admin) ) {
    $moduleList[] = 'Payments';
}


// for Refunds tab
$accessCode1 = $access->getAccessCode("List Col Refund");
$accessCode2 = $access->getAccessCode("Create Col Refund");
$accessCode3 = $access->getAccessCode("List HS Refund");
$accessCode4 = $access->getAccessCode("Create HS Refund");
$accessCode5 = $access->getAccessCode("List Elem Refund");
$accessCode6 = $access->getAccessCode("Create Elem Refund");
if ( $access->check_access($user_id,$accessCode1,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode2,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode3,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode4,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode5,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode6,$_SESSION['oUser']->is_admin) ) {
    $moduleList[] = 'Refunds';
}   

// admin
// for curriculum tab
$accessCode1 = $access->getAccessCode("List Curriculum");
$accessCode2 = $access->getAccessCode("Create Curriculum");
$accessCode3 = $access->getAccessCode("List Equivalency");
$accessCode4 = $access->getAccessCode("Create Equivalency");
if ( $access->check_access($user_id,$accessCode1,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode2,$_SESSION['oUser']->is_admin) ||  $access->check_access($user_id,$accessCode3,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode4,$_SESSION['oUser']->is_admin) ) {
    $moduleList[] = 'Curriculums';
}

// for credited subject tab
$accessCode1 = $access->getAccessCode("List CreditedSubject");
$accessCode2 = $access->getAccessCode("Create CreditedSubject");
if ( $access->check_access($user_id,$accessCode1,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode2,$_SESSION['oUser']->is_admin) ) {
    $moduleList[] = 'Credited';
}

// for Enrollment tab
$accessCode1 = $access->getAccessCode("List Col Enrollment");
$accessCode2 = $access->getAccessCode("Create Col Enrollment");
$accessCode3 = $access->getAccessCode("List HS Enrollment");
$accessCode4 = $access->getAccessCode("Create HS Enrollment");
$accessCode5 = $access->getAccessCode("List Elem Enrollment");
$accessCode6 = $access->getAccessCode("Create Elem Enrollment");
$accessCode7 = $access->getAccessCode("List Old Enrollment");
$accessCode8 = $access->getAccessCode("Create Old Enrollment");
if ( $access->check_access($user_id,$accessCode1,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode2,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode3,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode4,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode5,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode6,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode7,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode8,$_SESSION['oUser']->is_admin) ) {
    $moduleList[] = 'Enrollments';
}

// professor
// for Refunds tab
$accessCode1 = $access->getAccessCode("List Col Grade");
$accessCode2 = $access->getAccessCode("Create Col Grade");
$accessCode3 = $access->getAccessCode("List HS Grade");
$accessCode4 = $access->getAccessCode("Create HS Grade");
$accessCode5 = $access->getAccessCode("List Elem Grade");
$accessCode6 = $access->getAccessCode("Create Elem Grade");
if ( $access->check_access($user_id,$accessCode1,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode2,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode3,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode4,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode5,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode6,$_SESSION['oUser']->is_admin) ) {
    $moduleList[] = 'Grades';
}

//School Fee
// for payments tab
$accessCode1 = $access->getAccessCode("List Col School Fee");
$accessCode2 = $access->getAccessCode("Create Col School Fee");
$accessCode3 = $access->getAccessCode("List HS School Fee");
$accessCode4 = $access->getAccessCode("Create HS School Fee");
$accessCode5 = $access->getAccessCode("List Elem School Fee");
$accessCode6 = $access->getAccessCode("Create Elem School Fee");

$accessCode7 = $access->getAccessCode("List Col Lab Fee");
$accessCode8 = $access->getAccessCode("Assign Col Lab Fee");
$accessCode9 = $access->getAccessCode("List HS Lab Fee");
$accessCode10 = $access->getAccessCode("Assign HS Lab Fee");
$accessCode11 = $access->getAccessCode("List Elem Lab Fee");
$accessCode12 = $access->getAccessCode("Assign Elem Lab Fee");
if ( $access->check_access($user_id,$accessCode1,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode2,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode3,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode4,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode5,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode6,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode7,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode8,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode9,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode10,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode11,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode12,$_SESSION['oUser']->is_admin) ) {
    $moduleList[] = 'SchoolFees';
}

//Report
// for Report tab
$accessCode1 = $access->getAccessCode("View Col Class Roster");
$accessCode2 = $access->getAccessCode("View HS Class Roster");
$accessCode3 = $access->getAccessCode("View Elem Class Roster");
if ( $access->check_access($user_id,$accessCode1,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode2,$_SESSION['oUser']->is_admin) || $access->check_access($user_id,$accessCode3,$_SESSION['oUser']->is_admin) ) {
    $moduleList[] = 'Reports';
}

//$moduleList[] = 'Dashboard';
//$moduleList[] = 'Emails';
//$moduleList[] = 'Feeds';
//$moduleList[] = 'iFrames';
//$moduleList[] = 'Calendar';
//$moduleList[] = 'Activities';
//$moduleList[] = 'Contacts';
//$moduleList[] = 'Accounts';
//$moduleList[] = 'Leads';
//$moduleList[] = 'Opportunities';
//$moduleList[] = 'Cases';
//$moduleList[] = 'Bugs';
//$moduleList[] = 'Documents';
//$moduleList[] = 'Campaigns';
//$moduleList[] = 'Project';


// this list defines all of the module names and bean names in the app
// to create a new module's bean class, add the bean definition here
$beanList = array();

$beanList['ACLRoles']       = 'ACLRole';
$beanList['ACLActions']     = 'ACLAction';


//ACL Objects
//END ACL OBJECTS
$beanList['Leads']          = 'Lead';
$beanList['Contacts']       = 'Contact';
$beanList['Accounts']       = 'Account';
$beanList['DynamicFields']  = 'DynamicField';
$beanList['EditCustomFields']   = 'FieldsMetaData';
$beanList['Opportunities']  = 'Opportunity';
$beanList['Cases']          = 'aCase';
$beanList['Notes']          = 'Note';
$beanList['EmailTemplates']     = 'EmailTemplate';
$beanList['EmailMan'] = 'EmailMan';
$beanList['Calls']          = 'Call';
$beanList['Emails']         = 'Email';
$beanList['Meetings']       = 'Meeting';
$beanList['Tasks']          = 'Task';
$beanList['Users']          = 'User';
$beanList['Employees']      = 'Employee';
$beanList['Currencies']     = 'Currency';
$beanList['Trackers']       = 'Tracker';
$beanList['Import']         = 'ImportMap';
$beanList['Import_1']       = 'SugarFile';
$beanList['Import_2']       = 'UsersLastImport';
$beanList['Versions']       = 'Version';
$beanList['Administration'] = 'Administration';
$beanList['vCals']          = 'vCal';
$beanList['CustomFields']   = 'CustomFields';
$beanList['Bugs']           = 'Bug';
$beanList['Releases']       = 'Release';
$beanList['Feeds']          = 'Feed';
$beanList['iFrames']        = 'iFrame';
$beanList['Project']        = 'Project';
$beanList['ProjectTask']    = 'ProjectTask';
$beanList['Campaigns']      = 'Campaign';
$beanList['ProspectLists']  = 'ProspectList';
$beanList['Prospects']      = 'Prospect';
$beanList['Documents']      = 'Document';
$beanList['DocumentRevisions']  = 'DocumentRevision';
$beanList['Roles']          = 'Role';
$beanList['EmailMarketing'] = 'EmailMarketing';
$beanList['Audit']  = 'Audit';
$beanList['Schedulers']     = 'Scheduler';
$beanList['SchedulersJobs'] = 'SchedulersJob';
// deferred
//$beanList['Queues'] = 'Queue';
$beanList['InboundEmail']   = 'InboundEmail';
$beanList['Groups']         = 'Group';

$beanList['DocumentRevisions'] = 'DocumentRevision';
$beanList['CampaignLog']       = 'CampaignLog';
$beanList['Dashboard']         = 'Dashboard';
$beanList['CampaignTrackers']  = 'CampaignTracker';
$beanList['SavedSearch']       = 'SavedSearch';
$beanList['UserPreferences']   = 'UserPreference';
$beanList['MergeRecords']      = 'MergeRecord';


// this list defines all of the files that contain the SugarBean class definitions from $beanList
// to create a new module's bean class, add the file definition here
$beanFiles = array();
$beanFiles['Relationship']      = 'modules/Relationships/Relationship.php';
$beanFiles['Feed']              = 'modules/Feeds/Feed.php';
$beanFiles['ACLRole']           = 'modules/ACLRoles/ACLRole.php';
$beanFiles['ACLAction']         = 'modules/ACLActions/ACLAction.php';
$beanFiles['EmailTemplate']     = 'modules/EmailTemplates/EmailTemplate.php';
$beanFiles['Email']             = 'modules/Emails/Email.php';
$beanFiles['iFrame']            = 'modules/iFrames/iFrame.php';
$beanFiles['User']              = 'modules/Users/User.php';
$beanFiles['Currency']          = 'modules/Currencies/Currency.php';
$beanFiles['Tracker']           = 'data/Tracker.php';
$beanFiles['Administration']    = 'modules/Administration/Administration.php';
$beanFiles['UpgradeHistory']    = 'modules/Administration/UpgradeHistory.php';
$beanFiles['Version']           = 'modules/Versions/Version.php';
$beanFiles['Role']              = 'modules/Roles/Role.php';


$beanFiles['Scheduler']         = 'modules/Schedulers/Scheduler.php';
$beanFiles['SchedulersJob']     = 'modules/SchedulersJobs/SchedulersJob.php';
$beanFiles['InboundEmail']      = 'modules/InboundEmail/InboundEmail.php';
$beanFiles['Group']             = 'modules/Groups/Group.php';
$beanFiles['Dashboard']         = 'modules/Dashboard/Dashboard.php';
$beanFiles['SavedSearch']       = 'modules/SavedSearch/SavedSearch.php';
$beanFiles['UserPreference']    = 'modules/UserPreferences/UserPreference.php';
$beanFiles['ImportMap']         = 'modules/Import/ImportMap.php';
$beanFiles['SugarFile']         = 'modules/Import/SugarFile.php';
$beanFiles['UsersLastImport']   = 'modules/Import/UsersLastImport.php';


//$beanFiles['Lead']              = 'modules/Leads/Lead.php';
//$beanFiles['Contact']           = 'modules/Contacts/Contact.php';
//$beanFiles['Account']           = 'modules/Accounts/Account.php';
//$beanFiles['Opportunity']       = 'modules/Opportunities/Opportunity.php';
//$beanFiles['aCase']             = 'modules/Cases/Case.php';
//$beanFiles['Note']              = 'modules/Notes/Note.php';
//$beanFiles['Call']              = 'modules/Calls/Call.php';
//$beanFiles['Task']              = 'modules/Tasks/Task.php';
//$beanFiles['Employee']          = 'modules/Employees/Employee.php';
//$beanFiles['Bug']               = 'modules/Bugs/Bug.php';

//$beanFiles['EmailMan']          = 'modules/EmailMan/EmailMan.php';
//$beanFiles['Meeting']           = 'modules/Meetings/Meeting.php';
//$beanFiles['vCal']              = 'modules/vCals/vCal.php';
//$beanFiles['Release']           = 'modules/Releases/Release.php';

//$beanFiles['Project']           = 'modules/Project/Project.php';
//$beanFiles['ProjectTask']       = 'modules/ProjectTask/ProjectTask.php';
//$beanFiles['EmailMarketing']    = 'modules/EmailMarketing/EmailMarketing.php';
//$beanFiles['Campaign']          = 'modules/Campaigns/Campaign.php';
//$beanFiles['ProspectList']      = 'modules/ProspectLists/ProspectList.php';
//$beanFiles['Prospect']          = 'modules/Prospects/Prospect.php';
//$beanFiles['Document']          = 'modules/Documents/Document.php';
//$beanFiles['DocumentRevision']  = 'modules/DocumentRevisions/DocumentRevision.php';
//$beanFiles['FieldsMetaData']    = 'modules/EditCustomFields/FieldsMetaData.php';
////$beanFiles['Audit']           = 'modules/Audit/Audit.php';
//
//// deferred
////$beanFiles['Queue'] = 'modules/Queues/Queue.php';
//$beanFiles['CampaignLog']       = 'modules/CampaignLog/CampaignLog.php';
//$beanFiles['CampaignTracker']   = 'modules/CampaignTrackers/CampaignTracker.php';
//$beanFiles['MergeRecord']       = 'modules/MergeRecords/MergeRecord.php';



// added these lists for security settings for tabs
$modInvisList = array('Administration', 'Currencies', 'CustomFields',
    'Dropdown', 'Dynamic', 'DynamicFields', 'DynamicLayout', 'EditCustomFields',
    'EmailTemplates', 'Help', 'Import',  'MySettings', 'EditCustomFields','FieldsMetaData',
    'UpgradeWizard',



    'Releases','Sync',
    'Users',  'Versions', 'EmailMan', 'ProjectTask', 'ProspectLists', 'Prospects', 'Employees', 'LabelEditor','Roles','EmailMarketing'
    ,'OptimisticLock', 'TeamMemberships', 'Audit', 'MailMerge', 'MergeRecords',



    'Schedulers','Schedulers_jobs', /*'Queues',*/ 'InboundEmail',
    'CampaignLog', 'Groups',
    'ACLActions', 'ACLRoles','CampaignTrackers','DocumentRevisions',

    'Config','Reports',
//    'Reports',

    
    );
$adminOnlyList = array(
                    //module => list of actions  (all says all actions are admin only)
                    'Administration'=>array('all'=>1, 'SupportPortal'=>'allow'),
                    'Dropdown'=>array('all'=>1),
                    'Dynamic'=>array('all'=>1),
                    'DynamicFields'=>array('all'=>1),
                    'Currencies'=>array('all'=>1),
                    'EditCustomFields'=>array('all'=>1),
                    'FieldsMetaData'=>array('all'=>1),
                    'LabelEditor'=>array('all'=>1),
                    'ACL'=>array('all'=>1),
                    'ACLActions'=>array('all'=>1),
                    'ACLRoles'=>array('all'=>1),
                    //'Groups'=>array('all'=>1),
                    'UpgradeWizard' => array('all' => 1),
                    'Studio' => array('all' => 1),
                    );



$modInvisListActivities = array('Calls', 'Meetings','Notes','Tasks');

















$modInvisList[] = 'ACL';
$modInvisList[] = 'ACLRoles';
$modInvisList[] = 'Configurator';
$modInvisList[] = 'UserPreferences';
$modInvisList[] = 'SavedSearch';
// deferred
//$modInvisList[] = 'Queues';
$modInvisList[] = 'Studio';
if (file_exists('include/modules_override.php'))
{
    include('include/modules_override.php');
}
if (file_exists('custom/application/Ext/Include/modules.ext.php'))
{
    include('custom/application/Ext/Include/modules.ext.php');
}
?>
