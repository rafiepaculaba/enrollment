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



$mod_strings = array (










































































































	'LBL_REPAIR_IE' => 'Repair InboundEmail Accounts',
	'LBL_REPAIR_IE_DESC' => 'Repairs InboundEmail accounts, encrypting account passwords.',
	'LBL_REPAIR_IE_SUCCESS'	=> 'All InboundEmail accounts repaired successfully!',
	'LBL_REPAIR_IE_FAILURE'	=> 'The following InboundEmail accounts must be repaired manually - please re-enter login name and password for each:',

	'LBL_OOTB_WORKFLOW'		=> 'Process Workflow Tasks',
	'LBL_OOTB_REPORTS'		=> 'Run Report Generation Scheduled Tasks',
	'LBL_OOTB_IE'			=> 'Check Inbound Mailboxes',
	'LBL_OOTB_BOUNCE'		=> 'Run Nightly Process Bounced Campaign Emails',
	'LBL_OOTB_CAMPAIGN'		=> 'Run Nightly Mass Email Campaigns',
	'LBL_OOTB_PRUNE'		=> 'Prune Database on 1st of Month',

	'BTN_REBUILD_CONFIG' =>'Rebuild',
	'DESC_MODULES_INSTALLED' => 'The following modules have been installed:',
	'DESC_FILES_QUEUED' => 'The following modules are ready to be installed:',
	'DESC_FILES_INSTALLED' => 'The following upgrades have been installed:',

	'DESC_DROPDOWN_EDITOR' => 'Add, delete, or change the dropdown lists in the application',
	'DESC_EDIT_CUSTOM_FIELDS' => 'Edit the custom fields created for the Field Layout',
	'DESC_IFRAME' => 'Add tabs which can display any web site',

	'ERR_DELETE_RECORD' => 'A record number must be specified to delete the account.',
	'ERR_NOT_FOR_ORACLE'=>'This function is not currently implemented for this configuration.',
    'ERR_NOT_FOR_MSSQL'=>'This function is not currently implemented for this configuration.',
	'ERR_UW_CONFIG_FAILED'						=> "Error writing out config.php file.",
	'ERR_UW_COPY_FAILED'						=> 'Could not copy file ',
	'ERR_UW_INVALID_VIEW'						=> 'Invalid View specified.',
	'ERR_UW_NO_FILES'							=> "File(s) to copy not specified.",
	'ERR_UW_NO_INSTALL_FILE'					=> "Install file not specified.",
	'ERR_UW_NO_LANG'							=> "Language name not specified.",
	'ERR_UW_NO_LANG_DESC'						=> "Language description not specified.",
	'ERR_UW_NO_MODE'							=> "Mode of operation not specified.",
	'ERR_UW_NO_TEMP_DIR'						=> "Temp directory to copy files from not specified.",
	'ERR_UW_NO_UPDATE_RECORD'					=> 'Could not locate installation record of',
	'ERR_UW_NO_VIEW'							=> "View not defined.  Please go to the Administration home to navigate to this page.",
	'ERR_UW_UPLOAD_ERROR'						=> "There was an error uploading the file, please try again!<br>\n",
	'ERR_UW_NO_UPLOAD_FILE'						=> "Please specify a file and try again!<br>\n",
	'ERR_UW_NOT_RECOGNIZED'						=> 'is not recognized',
	'ERR_UW_NOT_VALID_UPLOAD'					=> 'Not valid upload.',
	'ERR_UW_NOT_ACCEPTIBLE_TYPE'				=> "You can only upload module packs, theme packs, and language packs on this page.",
	'ERR_UW_ONLY_PATCHES'						=> "You can only upload patches on this page.",
	'ERR_UW_NO_MANIFEST'						=> "The zip file is missing a manifest.php file.  Cannot proceed.",
	'ERR_UW_REMOVE_FAILED'						=> 'Could not remove file ',
	'ERR_UW_REMOVE_PACKAGE'						=> "Problem removing package ",
	'ERR_UW_RUN_SQL'							=> "Error running sql file: ",
	'ERR_UW_UPDATE_CONFIG'						=> "Error updating config.php with new version information.",


	'LBL_UW_BTN_DELETE_PACKAGE'				=> 'Delete Package',
	'LBL_UW_BTN_INSTALL'						=> 'Install',
	'LBL_UW_BTN_UPLOAD'							=> 'Upload',
	'LBL_UW_BTN_BACK_TO_MOD_LOADER'			=> 'Back to Module Loader',
	'LBL_UW_BTN_BACK_TO_UW'						=> 'Back to Upgrade Wizard',
	'LBL_UW_FOLLOWING_FILES'					=> 'The following files were ',
	'LBL_UW_INCLUDING'							=> 'Including',
	'LBL_UW_NO_FILES_SELECTED'					=> 'No files selected to be ',
	'LBL_UW_NO_INSTALLED_UPGRADES'				=> "<i>No recorded upgrades.</i><br>\n",
	'LBL_UW_NONE'								=> 'None',
	'LBL_UW_NOT_AVAILABLE'						=> "Not Available",
	'LBL_UW_OP_MODE'							=> 'Mode of operation:',
	'LBL_UW_PACKAGE_REMOVED'					=> " has been removed.<br>\n",
	'LBL_UW_UNINSTALL'							=> 'Uninstall',
	'LBL_UW_UPGRADE_SUCCESSFUL'				=> "<b>Upgrade applied successfully!</b><br>\n",
	'LBL_UW_UPLOAD_MODULE'						=> 'Module',
	'LBL_UW_UPLOAD_SUCCESS'						=> " has been uploaded.<br>\n",

	'LBL_UW_DESC_MODULES_INSTALLED'			=> 'The following modules have been installed:',
	'LBL_UW_DESC_MODULES_QUEUED'				=> 'The following modules are ready to be installed:',
	'LBL_UW_MODULE_READY' 			=> 'The module is ready to be installed.',
	'LBL_UW_MODULE_READY_UNISTALL' 			=> 'The module is ready to be uninstalled.',
	'ERROR_FLAVOR_INCOMPATIBLE' => 'The uploaded file is not compatible with this flavor (Open Source, Professional, or Enterprise) of Sugar Suite: ',
	'ERROR_LICENSE_EXPIRED'=> "Error: Your license expired ",
	'ERROR_LICENSE_EXPIRED2' => " day(s) ago.   Please go to the <a href='index.php?action=LicenseSettings&module=Administration'>'\"License Management\"</a>  in the Admin screen to enter your new license key.  If you do not enter a new license key within 30 days of your license key expiration, you will no longer be able to log into this application.",
	'ERROR_MANIFEST_TYPE' => 'Manifest file must specify the package type.',
	'ERROR_PACKAGE_TYPE' => 'Manifest file specifies an unrecognized package type',
	'ERROR_VALIDATION_EXPIRED'=> "Error: Your validation key expired ",
	'ERROR_VALIDATION_EXPIRED2' => " day(s) ago.   Please go to the <a href='index.php?action=LicenseSettings&module=Administration'>'\"License Management\"</a> in the Admin screen to enter your new validation key.  If you do not enter a new validation key within 30 days of your validation key expiration, you will no longer be able to log into this application.",
	'ERROR_VERSION_INCOMPATIBLE' => 'The uploaded file is not compatible with this version of Sugar Suite: ',

	'FATAL_LICENSE_ALTERED' => "Your license has been altered since the last time you were able to validate it. <br> Please go to the <a href='index.php?action=LicenseSettings&module=Administration'>'\"License Management\"</a>  in the Admin screen.",
	'FATAL_LICENSE_EXPIRED'=> "Fatal: Your license has expired for more than 30 days",
	'FATAL_LICENSE_EXPIRED2'=> "Please go to the <a href='index.php?action=LicenseSettings&module=Administration'>'\"License Management\"</a>  in the Admin screen to update your license information and restore full functionality.",
	'FATAL_LICENSE_REQUIRED' => "Fatal: Your license key information is required .<br>   Please go to the <a href='index.php?action=LicenseSettings&module=Administration'>'\"License Management\"</a>  in the Admin screen to update your license information and restore full functionality.",
	'FATAL_VALIDATION_EXPIRED'=> "Fatal: Your validation key has expired for more than 30 days",
	'FATAL_VALIDATION_EXPIRED2'=> "Please go to the <a href='index.php?action=LicenseSettings&module=Administration'>'\"License Management\"</a>  in the Admin screen to update your license information and restore full functionality.",
	'FATAL_VALIDATION_REQUIRED' => "Fatal: Your validation key information is required .<br>   Please go to the <a href='index.php?action=LicenseSettings&module=Administration'>'\"License Management\"</a>  in the Admin screen to update your license information and restore full functionality.<br>Either re-save your license information to have it authenticated or export the key and import the validation key. " ,
	'HEARTBEAT_MESSAGE'=>"<BR>The Sugar Updates mechanism allows your server to check to see if an update to your version of Sugar is available.",

	'LBL_ADMINISTRATION_HOME_TITLE' => 'System',
	'LBL_ALLOW_USER_TABS' => 'Allow users to configure tabs',
	'LBL_APPLY_DST_FIX_DESC' => 'This mandatory step will update the time handling functionality (MYSQL ONLY).',
	'LBL_APPLY_DST_FIX' => 'Apply Daylight Savings Time Fix',
	'LBL_AVAILABLE_UPDATES'=>'Available Updates',
	'LBL_BACKUP_BACK_HOME' => 'Back to Admin Home',
	'LBL_BACKUP_CONFIRM' => 'Confirm Settings',
	'LBL_BACKUP_CONFIRMED' => 'Settings confirmed. Press backup to perform the backup.',
	'LBL_BACKUP_DIRECTORY_ERROR' => 'Backup directory must be specified.',
	'LBL_BACKUP_DIRECTORY_EXISTS' => 'Backup directory does not exist, and could not be created.',
	'LBL_BACKUP_DIRECTORY_NOT_WRITABLE' => 'Backup directory exists, but is not writable.',
	'LBL_BACKUP_DIRECTORY_WRITABLE' => 'Must be writable by Sugar',
	'LBL_BACKUP_DIRECTORY' => 'Directory:',
	'LBL_BACKUP_FILE_AS_SUB' => 'Target file already exists as a sub-directory in the specified backup directory',
	'LBL_BACKUP_FILE_EXISTS' => 'The target file already exists in directory.',
	'LBL_BACKUP_FILE_STORED' => 'Backup successfully stored as',
	'LBL_BACKUP_FILENAME_ERROR' => 'Backup filename must be specified.',
	'LBL_BACKUP_FILENAME' => 'Filename:',
	'LBL_BACKUP_INSTRUCTIONS_1' => 'This purpose of this tool is to assist in creating backups of the Sugar application files. Database backups should also be performed regularly. Please refer to your database vendor\'s documentation for more information',
	'LBL_BACKUP_INSTRUCTIONS_2' => 'To backup your Sugar application files as a zip file, enter the following information:',
	'LBL_BACKUP_RUN_BACKUP' => 'Run Backup',
	'LBL_BACKUP_TITLE' => 'Online Backups',
	'LBL_BACKUP' => 'Schedule backups to the Sugar Online Data Vault.  Activate a system restore from backup.',
	'LBL_BACKUPS_TITLE' => 'Backups',
	'LBL_BACKUPS' => 'Perform a backup',
	'LBL_BUG_TITLE' => 'Bug Tracker',
	'LBL_CHANGE_NAME_TABS'=>'Change the label of the tabs',
	'LBL_CHECK_NOW_LABEL' =>'Check Now',
	'LBL_CHECK_NOW_TITLE' =>'Check Now',
	'LBL_CHOOSE_WHICH'=>'Choose which tabs are displayed system-wide',
	'LBL_CLEAN_EMAIL_ADDRESSES' => 'Clean Email Addresses',
	'LBL_CLEAN_EMAIL_ADDRESSES_DESC' => 'Removes whitespace from email addresses to ensure proper linking for InboundEmail and other modules.',
	'LBL_CLEAN_EMAIL_ADDRESSES_RESULT' => 'Queries run to fix email addresses',
	'LBL_CLEAR_CHART_DATA_CACHE_DESC'=>'Removes cached data files used by charts.',
	'LBL_CLEAR_CHART_DATA_CACHE_TITLE'=>'Clear Chart Data Cache',
	'LBL_CONFIG_CHECK' =>'Config Check',
	'LBL_CONFIGURATOR_DESC'=>'Set up Config.php',
	'LBL_CONFIGURATOR_TITLE'=>'Configurator',
	'LBL_CONFIGURE_SETTINGS_TITLE' => 'System Settings',
	'LBL_CONFIGURE_SETTINGS' => 'Configure system-wide settings',
	'LBL_CONFIGURE_TABS' => 'Configure Tabs',
	'LBL_CONFIGURE_GROUP_TABS' => 'Configure Group Tabs',
	'LBL_CONFIGURE_GROUP_TABS_DESC' => 'Create and edit groupings of tabs',
	'LBL_CONFIGURE_UPDATER'=>'Configure Sugar Updates',
	'LBL_COULD_NOT_CONNECT'=>'Error: Could not connect to the Sugar Server. Please check your Proxy Settings value in the <a href="index.php?module=Configurator&action=EditView">System Settings</a> admin panel. Last attempted connection @ ',
	'LBL_CURRENCY' => 'Set up currencies and currency rates',
	'LBL_DIAG_CANCEL_BUTTON' => 'Cancel',
	'LBL_DIAG_EXECUTE_BUTTON' => 'Execute Diagnostic',
	'LBL_DIAGNOSTIC_ACCESS' => 'You must be an administrator to run the diagnostic tool.',
	'LBL_DIAGNOSTIC_BEANLIST_DESC' => 'This information tells us whether or not the beanFiles specified in the beanList actually exists. This can be an issue with an improperly defined module loaded extension.',
	'LBL_DIAGNOSTIC_BEANLIST_GREEN' => 'Green means the file does exist.',
	'LBL_DIAGNOSTIC_BEANLIST_ORANGE' => 'Orange means there is no indexed file, so we cant look it up.',
	'LBL_DIAGNOSTIC_BEANLIST_RED' => 'Red means the file doesnt exist.',
	'LBL_DIAGNOSTIC_BLBF'=>'BeanList/BeanFiles files exist',
	'LBL_DIAGNOSTIC_CALCMD5'=>'&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Copy MD5 Calculated array',
	'LBL_DIAGNOSTIC_CONFIGPHP'=>'SugarCRM config.php',
	'LBL_DIAGNOSTIC_CUSTOMDIR'=>'SugarCRM Custom directory',
	'LBL_DIAGNOSTIC_DELETELINK' => 'Delete the Diagnostic file',
	'LBL_DIAGNOSTIC_DESC'=>'Capture system configuraton for diagnostics and analysis',
	'LBL_DIAGNOSTIC_DONE' => 'Done',
	'LBL_DIAGNOSTIC_DOWNLOADLINK' => 'Download the Diagnostic file',
	'LBL_DIAGNOSTIC_EXECUTING' => 'Executing Diagnostic Operations...',
	'LBL_DIAGNOSTIC_FILESMD5'=>'&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;Copy files.md5',
	'LBL_DIAGNOSTIC_GETBEANFILES' => 'Checking that bean files exist...',
	'LBL_DIAGNOSTIC_GETCONFPHP' => 'Getting config.php...',
	'LBL_DIAGNOSTIC_GETCUSTDIR' => 'Getting custom dir...',
	'LBL_DIAGNOSTIC_GETMD5INFO' => 'Getting md5 information...',
	'LBL_DIAGNOSTIC_GETMYSQLINFO' => 'mysql info',
	'LBL_DIAGNOSTIC_GETMYSQLTD' => 'mysql dumps',
	'LBL_DIAGNOSTIC_GETMYSQLTS' => 'mysql schema',
	'LBL_DIAGNOSTIC_GETPHPINFO' => 'Getting phpinfo()',
	'LBL_DIAGNOSTIC_GETSUGARLOG' => 'Getting sugarcrm.log',
	'LBL_DIAGNOSTIC_GETTING' => 'Getting...',
	'LBL_DIAGNOSTIC_MD5'=>'MD5 info',
	'LBL_DIAGNOSTIC_MYSQLDUMPS'=>'MySQL - Configuration Table Dumps',
	'LBL_DIAGNOSTIC_MYSQLINFO'=>'MySQL - General Information',
	'LBL_DIAGNOSTIC_MYSQLSCHEMA'=>'MySQL - All Tables Schema',
	'LBL_DIAGNOSTIC_NO_MYSQL' => 'You do not have MySQL. The MySQL functions in have been disabled.',
	'LBL_DIAGNOSTIC_PHPINFO'=>'phpinfo()',
	'LBL_DIAGNOSTIC_SUGARLOG'=>'SugarCRM Log File',
	'LBL_DIAGNOSTIC_TITLE'=>'Diagnostic Tool',
	'LBL_DIAGNOSTIC_VARDEFS'=>'Sugar schema output (VARDEFS)',
	'LBL_DIAGNOSTIC_DELETED' => 'File has been deleted',
	'LBL_DISPLAY_TABS'=>'Display Tabs',
	'LBL_DOCUMENTATION_TITLE' => 'Online Documentation',
	'LBL_DOCUMENTATION' => 'Get end-user and administrator documentation',
	'LBL_DROPDOWN_EDITOR' => 'Dropdown Editor',
	'LBL_DST_APPLY_FIX' => 'Apply Daylight Savings Time fix to existing data.  Please backup your data first.',
	'LBL_DST_BEFORE_DESC' => 'This fix will make changes to your data.  Please make a full backup of your database before running this fix.',
	'LBL_DST_BEFORE' => 'Before Beginning:',
	'LBL_DST_CURRENT_SERVER_TIME_ZONE_LOCALE' => 'Server Time Zone Locale:',
	'LBL_DST_CURRENT_SERVER_TIME_ZONE' => 'Detected Server Time Zone:',
	'LBL_DST_CURRENT_SERVER_TIME' => 'Detected Local Server Time:',
	'LBL_DST_END_DATE_TIME' => 'End Date/Time',
	'LBL_DST_FIX_CONFIRM_DESC' => 'Please review the values below and confirm that your system is correctly configured.',
	'LBL_DST_FIX_CONFIRM' => 'Confirm: ',
	'LBL_DST_FIX_DONE_DESC' => 'The Daylight Saving Time fix has been successfully applied.',
	'LBL_DST_FIX_TARGET' => 'Target:',
	'LBL_DST_FIX_USER_TZ' => 'This step sets the time zone for all users to the most likely value.',
	'LBL_DST_FIX_USER' => 'User Timezones:<br>(OPTIONAL)',
	'LBL_DST_SET_USER_TZ' => 'Set User Time Zones',
	'LBL_DST_START_DATE_TIME' => 'Start Date/Time',
	'LBL_DST_UPGRADE' => 'Upgrade:',
	'LBL_EDIT_CUSTOM_FIELDS' => 'Edit Custom Fields',
	'LBL_EDIT_TABS'=>'Edit Tabs',
	'LBL_EMAIL_TITLE' => 'Email',
	'LBL_ENABLE_MAILMERGE' => 'Enable Mail Merge?',
	'LBL_ERROR_VERSION_INFO'=>'Error fetching version information, please try again later.',
	'LBL_EXPORT_CUSTOM_FIELDS_TITLE' => 'Export Custom Fields Structure',
	'LBL_EXPORT_CUSTOM_FIELDS'=> 'Export custom field definitions to a .sugar file',
	'LBL_EXPORT_DOWNLOAD_KEY' =>'Export Download Key',
	'LBL_EXTERNAL_DEV_DESC'=> 'Migrate custom fields structure from one system to another',
	'LBL_EXTERNAL_DEV_TITLE'=> 'Migrate Custom Fields',
	'LBL_FORECAST_TITLE'=> 'Forecast',
	'LBL_GLOBAL_TEAM_DESC' => 'Globally Visible',
	'LBL_GO' => 'Go',
	'LBL_HELP_BOOKMARK' => 'Bookmark this page',
	'LBL_HELP_EMAIL' => 'Email',
	'LBL_HELP_LINK' => 'Link to this page',
	'LBL_HELP_PRINT' => 'Print',
	'LBL_HIDE_TABS'=>'Hide Tabs',
	'LBL_HT_DONE' => '--- DONE ---',
	'LBL_HT_NO_WRITE_2' => 'If you want to secure your files from being accessible via browser, create an .htaccess file in your root directory with the lines:',
	'LBL_HT_NO_WRITE' => 'Cannot write to the file: ',
	'LBL_ICF_ADDING' => 'Adding Custom Field Meta Data Information - ',
	'LBL_ICF_DROPPING' => 'Dropping - Custom Fields Meta Data Information',
	'LBL_ICF_IMPORT_S' => 'Import Structure',
	'LBL_IFRAME'=> 'Portal',
	'LBL_IMPORT_CUSTOM_FIELDS_DESC'=> ' <br>Import a .sug file that was exported from another machine. This will cause the custom field structure on this machine to match that of the other machine. It is recommended you export your current Custom Field Structure prior to importing one. After importing the Custom Field Structure, the system will automatically run you through a Custom Field Upgrade informing you of what changes will be made to the database. If you agree with these changes click the execute non-simulation mode link at the bottom. If you wish to revert the import process simply import the structure you exported prior to running this import. If you do <br> Warning: This will remove any previously defined custom field structures that are not defined in the .sug file as well as any data stored in those custom fields.',
	'LBL_IMPORT_CUSTOM_FIELDS_STRUCT'=> ' Custom Field Structure (SugarCustomFieldStruct.sug)',
	'LBL_IMPORT_CUSTOM_FIELDS_TITLE' => 'Import Custom Fields Structure',
	'LBL_IMPORT_CUSTOM_FIELDS'=> 'Import custom field definitions from a .sugar file',
	'LBL_IMPORT_VALIDATION_KEY' =>'Import Validation Key',
	'LBL_INBOUND_EMAIL_TITLE' => 'Inbound Email',
	'LBL_LAYOUT' => 'Add, remove, change fields, and layout fields and panels across the application',
	'LBL_LOCALE_DB_COLLATION'					=> 'Collation',
	'LBL_LOCALE_DB_COLLATION_TITLE'				=> 'Database Collation',
	'LBL_LOCALE_DEFAULT_CURRENCY_ISO4217'		=> 'ISO 4217 Currency Code',
	'LBL_LOCALE_DEFAULT_CURRENCY_NAME'			=> 'Currency',
	'LBL_LOCALE_DEFAULT_CURRENCY_SYMBOL'		=> 'Currency Symbol',
	'LBL_LOCALE_DEFAULT_CURRENCY'				=> 'Default Currency',
	'LBL_LOCALE_DEFAULT_DATE_FORMAT'			=> 'Default Date Format',
	'LBL_LOCALE_DEFAULT_DECIMAL_SEP'			=> 'Decimal Symbol',
	'LBL_LOCALE_DEFAULT_LANGUAGE'				=> 'Default Language',
	'LBL_LOCALE_DEFAULT_NAME_FORMAT'			=> 'Default Name Format',
	'LBL_LOCALE_DEFAULT_NUMBER_GROUPING_SEP'	=> '1000s Separator',
	'LBL_LOCALE_DEFAULT_SYSTEM_SETTINGS'		=> 'User Interface',
	'LBL_LOCALE_DEFAULT_TIME_FORMAT'			=> 'Default Time Format',
	'LBL_LOCALE_EXAMPLE_NAME_FORMAT'			=> 'Example',
	'LBL_LOCALE_NAME_FORMAT_DESC'				=> '"s" Salutation<br>"f" First Name<br>"l" Last Name',
	'LBL_LOCALE_TITLE'							=> 'System Locale Settings',
	'LBL_LOCALE' => 'Set default localization settings for your system.',
	'LBL_MAILBOX_DESC' => 'Set up mailboxes to be monitored for inbound email',
	'LBL_MANAGE_CURRENCIES' => 'Currencies',
	'LBL_MANAGE_GROUPS_TITLE'	=> 'Manage Groups',
	'LBL_MANAGE_GROUPS'			=> 'Manage groups queues',
	'LBL_MANAGE_LAYOUT' => 'Field Layout',
	'LBL_MANAGE_LOCALE'	=> 'Locale Settings',
	'LBL_MANAGE_MAILBOX' => 'Inbound Email',
	'LBL_MANAGE_OPPORTUNITIES' => 'Opportunities',
	'LBL_MANAGE_RELEASES' => 'Releases',
	'LBL_MANAGE_ROLES_TITLE' => 'Role Management',
	'LBL_MANAGE_ROLES' => 'Manage role membership and properties',
	'LBL_MANAGE_USERS_TITLE' => 'User Management',
	'LBL_MANAGE_USERS' => 'Manage user accounts and passwords',
	'LBL_MANUAL_VALIDATION_TXT' => 'Manual Validation',
	'LBL_MANUAL_VALIDATION'=>'If you experience persistent problems with automatic validation, please check your Proxy configuration in the <a href="index.php?module=Configurator&action=EditView">System Settings</a> admin panel.  If your system environment prohibits your system from communicating to the license validation server through the internet, you should proceed with the <a href="#" onclick="toggleDisplay(\'mainbody\');toggleDisplay(\'manualbody\');">Manual Validation</a> steps. ',
	'LBL_MANUAL_VALIDATION1'=> 'Step 1: Generate a license key information file by clicking the following button. ',
	'LBL_MANUAL_VALIDATION2'=> 'Then save the file (sugarkey.lic) on your local file system.',
	'LBL_MANUAL_VALIDATION3'=> 'Step 2: Transfer the sugarkey.lic file to a system where you can access the internet with a web browser.   <br<br>Go to <a href="http://updates.sugarcrm.com/license">http://updates.sugarcrm.com/license</a>  and submit the sugarkey.lic file.  <br><br>The license validation web site will perform the validation immediately and return you the validation key file (sugarvalidationkey.lic) if the validation is successful.  You browser should prompt you to save the file.  ',
	'LBL_MANUAL_VALIDATION4'=>'Step 3:  Transfer the validation key file (sugarvalidationkey.lic) back to the SugarCRM system.  Import the validation key using this form below: ',
	'LBL_MANUAL_VALIDATION5'=> 'After you import the validation key, you have completed the manual validation process.  Your system will update the validation key expiration date, which is the next time you need re-validate.',
	'LBL_MASS_EMAIL_CONFIG_DESC'=> 'Configure email settings',
	'LBL_MASS_EMAIL_CONFIG_TITLE'=>'Email Settings',
	'LBL_MASS_EMAIL_MANAGER_DESC'=> 'Manage the outbound email queue',
	'LBL_MASS_EMAIL_MANAGER_HEADER'=>'Campaign Email Management',
	'LBL_MASS_EMAIL_MANAGER_TITLE'=> 'Manage Email Queue',
	'LBL_MASSAGE_MASS_EMAIL_DESC'=>'SugarCRM 3.5.1+ requires an update to the Mass Email data.  Click "Begin Update" to continue.',
	'LBL_MASSAGE_MASS_EMAIL'=>'GMT Date Time Fix for Sent Mass Email',
	
	
	// school fees
	'LBL_SCHOOLFEE_TITLE' => 'School Fees',
	'LBL_SCHOOL_FEE_COLLEGE_DESC'=> 'College school fee settings',
	'LBL_SCHOOL_FEE_COLLEGE_TITLE'=>'College',
	
	'LBL_SCHOOL_FEE_HS_DESC'=> 'High school fee settings',
	'LBL_SCHOOL_FEE_HS_TITLE'=>'High School',
	
	'LBL_SCHOOL_FEE_ELEM_DESC'=> 'Elementary school fee settings',
	'LBL_SCHOOL_FEE_ELEM_TITLE'=>'Elementary School',
	
	'LBL_SCHOOL_FEE_COLLEGE_DESC'=> 'College school fee settings',
	'LBL_SCHOOL_FEE_COLLEGE_TITLE'=>'College',
	
	// school config
	'LBL_SCHOOLCONFIG_TITLE' => 'School Configuration',
	'LBL_SCHOOL_CONFIG_DESC'=> 'All school configuration',
	'LBL_SCHOOL_CONFIG_TITLE'=>'Configuration',
	'LBL_COPY_SCHED_TITLE' => 'Copy Schedules',
	'LBL_COPY_SCHED_DESC'=> 'Copy existing/previous schedules',
	'LBL_CHART_OF_ACCOUNTS_TITLE'=> 'Chart of accounts',
	'LBL_CHART_OF_ACCOUNTS_DESC'=> 'Chart of accounts',
	
	'LBL_ML_ACTION' => 'Action',
	'LBL_ML_DESCRIPTION' => 'Description',
	'LBL_ML_INSTALLED' => 'Date Installed',
	'LBL_ML_NAME' => 'Name',
	'LBL_ML_PUBLISHED' => 'Date Published',
	'LBL_ML_TYPE' => 'Type',
	'LBL_ML_UNINSTALLABLE' => 'Uninstallable',
	'LBL_ML_VERSION' => 'Version',
	'LBL_MODULE_LOADER_TITLE' => 'Module Loader',
	'LBL_MODULE_LOADER' => 'Add or remove Sugar modules, themes, and language packs',
	'LBL_MODULE_NAME' => 'Administration',
	'LBL_MODULE_TITLE' => 'Administration: Home',
	'LBL_NEVER'=>'Never',
	'LBL_NEW_FORM_TITLE' => 'Create Account',
	'LBL_NOTIFY_SUBJECT' => 'Email subject:',
	'LBL_PERFORM_UPDATE'=>'Perform Update',
	'LBL_PLUGINS_TITLE' => 'Sugar Forge',
	'LBL_PLUGINS' => 'Get plug-ins and other Sugar Suite extensions.',
	'LBL_PROXY_AUTH'=>'Authentication?',
	'LBL_PROXY_HOST'=>'Proxy Host',
	'LBL_PROXY_ON_DESC'=>'Use a proxy to access external information such as Sugar updates.',
	'LBL_PROXY_ON'=>'Enable Proxy?',
	'LBL_PROXY_PASSWORD'=>'Password',
	'LBL_PROXY_PORT'=>'Port',
	'LBL_PROXY_TITLE'=>'Proxy Settings',
	'LBL_PROXY_USERNAME'=>'User Name',
	'LBL_REBUILD_AUDIT_DESC' => 'Rebuilds audit table.',
	'LBL_REBUILD_AUDIT_TITLE' => 'Rebuild Audit',
	'LBL_REBUILD_CONFIG_DESC' =>'Rebuild config.php by updating version and adding defaults when not explicitly declared.',
	'LBL_REBUILD_CONFIG' =>'Rebuild Config File',
	'LBL_REBUILD_DASHLETS_DESC_SHORT' => 'Rebuild the Dashlets cache file.',
	'LBL_REBUILD_DASHLETS_DESC_SUCCESS' => 'Dashlets cache file rebuilt.',
	'LBL_REBUILD_DASHLETS_DESC' => 'Removing Dashlets cache and scanning known directories for Dashlet files.',
	'LBL_REBUILD_DASHLETS_TITLE' => 'Rebuild Dashlets',
    'LBL_REBUILD_JAVASCRIPT_LANG_TITLE' => 'Rebuild Javascript Languages',
    'LBL_REBUILD_JAVASCRIPT_LANG_DESC_SHORT' => 'Rebuild javascript versions of language files',
    'LBL_REBUILD_JAVASCRIPT_LANG_DESC' => 'Removing javascript versions of language files, will rebuild when needed.',
	'LBL_REBUILD_EXTENSIONS_DESC' => 'Rebuild extensions including extended vardefs, language packs, menus, and administration',
	'LBL_REBUILD_EXTENSIONS_TITLE' => 'Rebuild Extensions',
	'LBL_REBUILD_HTACCESS_DESC'=>'Rebuilds .htaccess to limit access to certain files directly.',
	'LBL_REBUILD_HTACCESS'=>'Rebuild .htaccess file',
	'LBL_REBUILD_REL_DESC'=>'Rebuilds relationship meta data and drops the cache file.',
	'LBL_REBUILD_REL_TITLE'=>'Rebuild Relationships',
	'LBL_REBUILD_SCHEDULERS_DESC_SHORT' => 'Rebuild your out-of-the-box Scheduler Jobs.',
	'LBL_REBUILD_SCHEDULERS_DESC_SUCCESS' => 'Scheduler Job rebuild complete.',
	'LBL_REBUILD_SCHEDULERS_DESC' => 'Rebuilding your Scheduler Jobs will delete all existing Job entries and their respective logs.  All out-of-the-box Scheduler Jobs will be rebuilt with their default settings, including the Active/Inactive flag.',
	'LBL_REBUILD_SCHEDULERS_TITLE' => 'Rebuild Schedulers',
	'LBL_REBUILD' => 'Rebuild',
	'LBL_RELEASE' => 'Manage releases and versions',
	'LBL_RENAME_TABS'=>'Rename Tabs',
	'LBL_REPAIR_ACTION' => 'What action would you like to take?',
	'LBL_REPAIR_DATABASE_DESC' =>'Repair database based on values defined in vardefs',
    'LBL_REPAIR_DATABASE_TEXT'=>'This tool allows you to upgrade the database to match any changes made to bean vardefs and relationship metadata. <br>You may choose from three options : <br>Display SQL will display the sql that will be executed on the screen<br> Export SQL will export the sql to a file<br> Execute SQL will execute the SQL.',
    'LBL_REPAIR_DATABASE' =>'Repair Database',
	'LBL_REPAIR_DISPLAYSQL' =>'Display SQL',
	'LBL_REPAIR_ENTRY_POINTS_DESC' => 'Repair Entry Points check.  Run this script if you receive \'Not A Valid Entry Point\' errors.',
	'LBL_REPAIR_ENTRY_POINTS' => 'Repair Entry Points',
	'LBL_REPAIR_EXECUTESQL' =>'Execute SQL',
	'LBL_REPAIR_EXPORTSQL' =>'Export SQL',
	'LBL_REPAIR_INDEX_DESC'=>'Validates and optionally repair database indexes against definitions in vardef files.',
	'LBL_REPAIR_INDEX'=>'Repair Indexes',
	'LBL_REPAIR_ROLES'=>'Repair Roles',
	'LBL_REPAIR_ROLES_DESC'=>'Repairs Roles adding all new modules that support Access Controls as well as adding any new Access Controls to existing modules',
	'LBL_REPAIR_ACTIVITIES_DESC' =>'Repair Activity (Calls, Meetings) end date.',
	'LBL_REPAIR_ACTIVITIES_TEXT'=>'This tool allows you to fix the end date for Calls and Meetings.',
	'LBL_REPAIR_ACTIVITIES' =>'Repair Activities',
	
	'LBL_RETURN' => 'Return',
	'LBL_REVALIDATE'=>'Re-validate' ,
	'LBL_SEND_STAT'=>'<B>Send Anonymous Usage Statistics</B> - If checked, Sugar will send anonymous statistics about your installation to SugarCRM Inc. every time your system checks for new versions.  This information will help us better understand how the application is used and guide improvements to the product.',

	'LBL_STATUS'=>'Status ',
	'LBL_STUDIO_DESC' => 'Edit Dropdowns, Custom Fields, Layouts and Labels',
	'LBL_STUDIO_TITLE' => 'Studio',
	'LBL_STUDIO' => 'Studio',
	'LBL_SUGAR_NETWORK_TITLE' => 'Sugar Network',
	'LBL_SUGAR_SCHEDULER_TITLE' => 'Scheduler',
	'LBL_SUGAR_SCHEDULER' => 'Set up scheduled events',
	'LBL_SUGAR_UPDATE_TITLE'=>'Sugar Updates',
	'LBL_SUGAR_UPDATE'=>'Check for latest updates.',
	'LBL_SUGARCRM_HELP' => 'SugarCRM Help',
	'LBL_SUPPORT_TITLE' => 'Sugar Support Portal',
	'LBL_SUPPORT' => 'Access your personalized portal for technical support and more',
	'LBL_TIMEZONE' => 'Time Zone',
	'LBL_TO'	=> ' to ',
	'LBL_UPDATE_CHECK_AUTO'=>'Automatically',
	'LBL_UPDATE_CHECK_MANUAL'=>'Manually',
	'LBL_UPDATE_CHECK_TYPE'=>'<B>Automatically Check For Updates</B> - If checked, the system will periodically check to see if updated versions of the application are available.',
	'LBL_UPDATE_DESCRIPTIONS'=>'Description',
	'LBL_UPDATE_TITLE'=>'Sugar Updates',
	'LBL_UPGRADE_STUDIO_TITLE'=>'Upgrade Studio',
	'LBL_UPGRADE_STUDIO_DESC'=>' Upgrade pre 4.5 files for 4.5 studio',
	'LBL_UPGRADE_CURRENCY' => 'Upgrade currency amounts in ',
	'LBL_UPGRADE_CUSTOM_LABELS_DESC'=>'Upgrade the format of the custom field labels in every language file.',
	'LBL_UPGRADE_CUSTOM_LABELS_TITLE'=>'Upgrade Custom Labels',
	'LBL_UPGRADE_DB_BEGIN' => 'Begining Upgrade',
	'LBL_UPGRADE_DB_COMPLETE' => 'Upgrade Complete',
	'LBL_UPGRADE_DB_FAIL' => 'Upgrade Failed',
	'LBL_UPGRADE_DB_TITLE' => 'Upgrade database',
	'LBL_UPGRADE_DB' => 'Update the database from version 2.0.x to 2.5 ',
	'LBL_UPGRADE_TITLE' => 'Repair',
	'LBL_UPGRADE_VERSION'=>'Updating version info',
	'LBL_UPGRADE_WIZARD_TITLE' => 'Upgrade Wizard',
	'LBL_UPGRADE_WIZARD' => 'Upload and install Sugar Suite upgrades',
	'LBL_UPGRADE' => 'Check and repair Sugar Suite',
	'LBL_UPLOAD_UPGRADE' => 'Upload an upgrade: ',
	'LBL_UPTODATE'=>'You have the latest version available',
	'LBL_USERS_TITLE' => 'Users',
	'LBL_VALIDATION_FAIL_DATE'=>'Last failed validation : ',
	'LBL_VALIDATION_FILE'=>'Validation Key File',
	'LBL_VALIDATION_SUCCESS_DATE'=>'Last succesful validation : ',
	'LNK_NEW_USER' => 'Create New User',
	'LNK_REPAIR_CUSTOM_FIELD' => 'Repair Custom Fields',
	'LNK_SELECT_CUSTOM_FIELD' => 'Select Custom Field',
	'MSG_CONFIG_FILE_READY_FOR_REBUILD' => 'The config.php file is ready for rebuild.',
	'MSG_CONFIG_FILE_REBUILD_FAILED' => 'The config.php could not be rebuilt.',
	'LBL_CONFIG_TABS'=>'Drag and Drop the tabs below to set them either as visible or hidden. If you want to prevent non-admin users from conifguring tabs uncheck the "Allow users to configure tabs"',
	'MSG_CONFIG_FILE_REBUILD_SUCCESS' => 'The config.php was successfully rebuilt.',
	'MSG_INCREASE_UPLOAD_MAX_FILESIZE' => 'Warning: Your PHP configuration must be changed to allow files of at least 6MB to be uploaded.  Please modify the upload_max_filesize value in your php.ini located at:',
	'MSG_MAKE_CONFIG_FILE_WRITABLE' => 'Please make the config.php writable and try again.',
	'MSG_REBUILD_EXTENSIONS' => 'Please go to the <a href="index.php?module=Administration&action=Upgrade">Repair</a> screen and click on Rebuild Extensions.',
	'MSG_REBUILD_RELATIONSHIPS' => 'Please go to the <a href="index.php?module=Administration&action=Upgrade">Repair</a> screen and click on Rebuild Relationships.',
	'WARN_INSTALLER_LOCKED'=>'Warning: To safeguard your data, the installer must be locked by setting \'installer_locked\' to \'true\' in the config.php file.',
	'WARN_LICENSE_EXPIRED'=> "Notice: Your license expires in ",
	'WARN_LICENSE_EXPIRED2' =>" day(s). Please go to the <a href='index.php?action=LicenseSettings&module=Administration'>'\"License Management\"</a>  in the Admin screen.",
	'WARN_LICENSE_SEATS'=>  "Warning: User licenses exceeded by ",
	'WARN_LICENSE_SEATS2' => ".  Please contact your sales representative or email cagroup@sugarcrm.com.",
	'WARN_REPAIR_CONFIG' => 'Warning: The config.php file needs to be repaired.  Please use the "Repair" link in the Admin screen to repair your config file.',
	'WARN_UPGRADE_APP'=> "An updated version of the application is now available. ",
	'WARN_UPGRADE' => 'Warning: Please upgrade ',
	'WARN_UPGRADE2'=>' using the upgrade in the <a href="index.php?module=Administration&action=Upgrade">administration panel</a>',
	'WARN_VALIDATION_EXPIRED'=> "Notice: Your validation key expires in ",
	'WARN_VALIDATION_EXPIRED2' =>" day(s). Please go to the <a href='index.php?action=LicenseSettings&module=Administration'>'\"License Management\"</a>  in the Admin screen.",






    'LBL_UW_SUCCESSFUL' => 'Successful',
    'LBL_UW_PATCH_READY'=> '<h2>Ready To Install</h2>',
    'LBL_UW_SHOW_DETAILS'=> 'Show Details',
    'LBL_UW_HIDE_DETAILS'=> 'Hide Details',
    'LBL_UW_CHECK_ALL'=>'Check All',
    'LBL_ML_COMMIT'=>'Commit',
    'LBL_MODULE_LICENSE'                        => 'Please read the following License Agreement:',
    'LBL_ACCEPT'                                => 'Accept',
    'LBL_DENY'                                  => 'Deny',
    'ERR_UW_ACCEPT_LICENSE'                     => 'Before proceeding you must accept the License Agreement',
    'LBL_UW_BTN_DOWNLOAD' => 'Download',
    'LBL_CAT_VIEW'              => 'Categories',
    'LBL_LIST_VIEW'             => 'List',
    'LBL_AVAILABLE_MODULES'     => 'Modules Available for Download',
    'LBL_MODULES_TO_DOWNLOAD'     => 'Modules to Download (drag and drop here)',
    'DOWNLOAD_QUESTION'         => 'Are you sure you wish to download the selected package(s)?',
    'LBL_LOADING'               => 'Loading, Please wait...',
    'LBL_BROWSE'                => 'Browse',
    'LBL_SEARCH_MODULE_NAME'    => 'Enter all or part of the module name:',
    'ERR_SUGAR_DEPOT_DOWN'      => 'The system is unable to connect to Sugar Exchange for browsing and downloading packages.',
    'LBL_CHECK_FOR_UPDATES'     => 'Check for Updates',
    'HDR_LOGIN_PANEL'           => 'Please enter your sugarcrm.com credentials.',
    'LBL_USERNAME'               => 'UserName',
    'LBL_PASSWORD'               => 'Password',
    'LBL_MODIFY_CREDENTIALS'     => 'Modify Credentials',
    'ML_DESC_DOCUMENTATION'		=> 'Click on a tree node to view the associated details and documentation.',
    'LBL_ML_CANCEL'				=> 'Cancel',
    'ERR_UW_NO_DEPENDENCY'		=> "The following dependenccie(s) were not found on the system.",
    'REMOVE_QUESTION'			=> 'Are you sure you wish to remove the selected package?',
    'LBL_LICENSE'				=> 'License',
    'LBL_README'				=> 'Readme',
    'ML_LBL_DETAIILS'			=> 'Details',
    'ML_LBL_DOCUMENTATION'		=> 'Documentation',
    'ML_LBL_REVIEWS'			=> 'Reviews',
    'ML_LBL_SCREENSHOTS'		=> 'Screenshots',
    'ML_LBL_INSTALL_FROM_SERVER' => 'Install from Sugar Exchange',
    'ML_LBL_INSTALL_FROM_LOCAL'=> 'Install from local file',
    'LBL_SYSTEM_NAME' => 'System Name',
    'LBL_TERMS_AND_CONDITIONS' => 'Terms and Conditions',
    'LBL_ACCEPT_TERMS' =>'Accept Terms and Conditions',
    'ERR_CREDENTIALS_MISSING'	=> 'Your sugarcrm.com credentials are missing.',
	'LNK_NEW_ACCOUNT' => 'Create an account',
	'LNK_FORGOT_PASS' => 'Forgotten your password?',
	'ERR_ENABLE_CURL'	=> 'Please ensure that you have curl enabled.',

	'ERR_NOT_FOR_MYSQL'=>'This function is not currently implemented for this configuration.',
	'LBL_EXPAND_DATABASE_COLUMNS' => 'Expand Column Width',
    'LBL_EXPAND_DATABASE_COLUMNS_DESC' => 'Expand certain char, varchar and text columns in database (MSSQL ONLY)',
 	'LBL_EXPAND_DATABASE_TEXT'=>'This tool allows you to expand selected database columns as an interim fix for multi-byte character limitations in SQL Server. <br>You may choose from three options: <br>Display SQL will display the sql that will be executed on the screen<br> Export SQL will export the sql to a file<br> Execute SQL will execute the SQL.',
	'ERR_CANNOT_CREATE_RESTORE_FILE' => 'Error: Could not create restore file',
	'LBL_CREATE_RESOTRE_FILE' => 'restoreExpand.sql file was successfully created.  Please use this file to revert column changes.',








    'ML_LBL_REMOVE_TABLES' => 'Remove Tables',
    'ML_LBL_DO_NOT_REMOVE_TABLES' => 'Do Not Remove Tables',

	'LBL_EXECUTE'							=> 'Execute',
	'LBL_DONE'								=> 'Done.',
	'LBL_ALL'								=> 'All',
	'LBL_REPAIR_XSS'						=> 'Remove XSS',
	
	'LBL_REPAIRXSS_COUNT'					=> 'Object(s) found',
	'LBL_REPAIRXSS_INSTRUCTIONS'			=> 'Select a module to remove potential XSS strings.  Select "All" to address every module.<br>Press execute to start the detection and removal process.',
	'LBL_REPAIRXSS_REPAIRED'				=> 'Object(s) repaired',
	'LBL_REPAIRXSS_TITLE'					=> 'Remove XSS Vulnerabilities from the Database', 
	'MI_REDIRECT_TO_UPGRADE_WIZARD' => 'Selecting this patch will redirect you to the Upgrade Wizard to perform the necessary system checks.  Do you wish to continue?',
);


?>
