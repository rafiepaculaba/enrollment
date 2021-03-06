<?PHP
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

class SugarSecure{
	var $results = array();
	function display(){
		echo '<table>';
		foreach($this->results as $result){
			echo '<tr><td>' . nl2br($result) . '</td></tr>';
		}
		echo '</table>';
	}

	function save($file=''){
		$fp = fopen($file, 'a');
		foreach($this->results as $result){
			fwrite($fp , $result);
		}
		fclose($fp);
	}

	function scan($path= '.', $ext = '.php'){
		$dir = dir($path);
		while($entry = $dir->read()){
			if(is_dir($path . '/' . $entry) && $entry != '.' && $entry != '..'){
				$this->scan($path .'/' . $entry);
			}
			if(is_file($path . '/'. $entry) && substr($entry, strlen($entry) - strlen($ext), strlen($ext)) == $ext){
				$contents = file_get_contents($path .'/'. $entry);
				$this->scanContents($contents, $path .'/'. $entry);
			}
		}
	}

	function scanContents($contents){
		return;
	}


}

class ScanFileIncludes extends SugarSecure{
	function scanContents($contents, $file){
		$results = array();
		$found = '';
		/*preg_match_all("'(require_once\([^\)]*\\$[^\)]*\))'si", $contents, $results, PREG_SET_ORDER);
		foreach($results as $result){

			$found .= "\n" . $result[0];
		}
		$results = array();
		preg_match_all("'include_once\([^\)]*\\$[^\)]*\)'si", $contents, $results, PREG_SET_ORDER);
		foreach($results as $result){
			$found .= "\n" . $result[0];
		}
		*/
		$results = array();
		preg_match_all("'require\([^\)]*\\$[^\)]*\)'si", $contents, $results, PREG_SET_ORDER);
		foreach($results as $result){
			$found .= "\n" . $result[0];
		}
		$results = array();
		preg_match_all("'include\([^\)]*\\$[^\)]*\)'si", $contents, $results, PREG_SET_ORDER);
		foreach($results as $result){
			$found .= "\n" . $result[0];
		}
		$results = array();
		preg_match_all("'require_once\([^\)]*\\$[^\)]*\)'si", $contents, $results, PREG_SET_ORDER);
		foreach($results as $result){
			$found .= "\n" . $result[0];
		}
		$results = array();
		preg_match_all("'fopen\([^\)]*\\$[^\)]*\)'si", $contents, $results, PREG_SET_ORDER);
		foreach($results as $result){
			$found .= "\n" . $result[0];
		}
		$results = array();
		preg_match_all("'file_get_contents\([^\)]*\\$[^\)]*\)'si", $contents, $results, PREG_SET_ORDER);
		foreach($results as $result){
			$found .= "\n" . $result[0];
		}
		if(!empty($found)){
			$this->results[] = $file . $found."\n\n";
		}

	}


}



class SugarSecureManager{
	var $scanners = array();
	function registerScan($class){
		$this->scanners[] = new $class();
	}

	function scan(){

		while($scanner = current($this->scanners)){
			$scanner->scan();
			$scanner = next($this->scanners);
		}
		reset($this->scanners);
	}

	function display(){

		while($scanner = current($this->scanners)){
			echo 'Scan Results: ';
			$scanner->display();
			$scanner = next($this->scanners);
		}
		reset($this->scanners);
	}

	function save(){
		//reset($this->scanners);
		$name = 'SugarSecure'. time() . '.txt';
		while($this->scanners  = next($this->scanners)){
			$scanner->save($name);
		}
	}

}
$secure = new SugarSecureManager();
$secure->registerScan('ScanFileIncludes');
$secure->scan();
$secure->display();
