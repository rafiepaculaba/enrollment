<?php
if(!defined('sugarEntry'))define('sugarEntry', true);
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

define('PACKAGE_MANAGER_DOWNLOAD_SERVER', 'https://depot.sugarcrm.com/depot/');
define('PACKAGE_MANAGER_DOWNLOAD_PAGE', 'download.php');
define('PACKAGE_MANAGER_DOWNLOAD_PATH', 'cache/upload/');
class PackageManagerDownloader{

	/**
	 * Using curl we will download the file from the depot server
	 *
	 * @param session_id		the session_id this file is queued for
	 * @param file_name			the file_name to download
	 * @param save_dir			(optional) if specified it will direct where to save the file once downloaded
	 * @param download_sever	(optional) if specified it will direct the url for the download
	 *
	 * @return the full path of the saved file
	 */
	function download($session_id, $file_name, $save_dir = '', $download_server = ''){
		if(empty($save_dir)){
			$save_dir = PACKAGE_MANAGER_DOWNLOAD_PATH;
		}
		if(empty($download_server)){
			$download_server = PACKAGE_MANAGER_DOWNLOAD_SERVER;
		}
		$download_server .= PACKAGE_MANAGER_DOWNLOAD_PAGE;
		$ch = curl_init($download_server . '?filename='. $file_name);
		$fp = fopen($save_dir . $file_name, 'w');
		curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID='.$session_id. ';');
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);
		return $save_dir . $file_name;
	}
}
?>
