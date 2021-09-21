<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/**
 * CacheHandler
 *
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
 */



    $moduleDefs = array();
    $fileName = 'field_arrays.php';

    /************************************************
    * LoadCachedArray
    * PARAMS
    * module_dir - the module directory
    * module - the name of the module
    * key - the type of field array we are referencing, i.e. list_fields,
    *       column_fields, required_fields
    * DESCRIPTION
    * This function is designed to cache references
    * to field arrays that were previously stored in the bean files
    * and have since been moved to seperate files.
    *************************************************/
	function LoadCachedArray($module_dir, $module, $key)
	{
        global $moduleDefs, $fileName;
        
        $cache_key = "load_cached_array.$module_dir.$module.$key";
        $result = sugar_cache_retrieve($cache_key);
        if(!empty($result))
        {
        	// Use EXTERNAL_CACHE_NULL_VALUE to store null values in the cache.
        	if($result == EXTERNAL_CACHE_NULL_VALUE)
        	{
        		return null;
        	}
        	
        	return $result;
        }
        
        if(file_exists('modules/'.$module_dir.'/'.$fileName))
        {
            // If the data was not loaded, try loading again....
            if(!isset($moduleDefs[$module]))
            {
            	include('modules/'.$module_dir.'/'.$fileName);
                $moduleDefs[$module] = $fields_array;
		    }
		    // Now that we have tried loading, make sure it was loaded
            if(empty($moduleDefs[$module]) || empty($moduleDefs[$module][$module][$key]))
            {
                // It was not loaded....  Fail.  Cache null to prevent future repeats of this calculation
				sugar_cache_put($cache_key, EXTERNAL_CACHE_NULL_VALUE);
                return  null;
            }
            
            // It has been loaded, cache the result.
            sugar_cache_put($cache_key, $moduleDefs[$module][$module][$key]);
            return $moduleDefs[$module][$module][$key];
        }
        
        // It was not loaded....  Fail.  Cache null to prevent future repeats of this calculation
        sugar_cache_put($cache_key, EXTERNAL_CACHE_NULL_VALUE);
		return null;
	}
?>
