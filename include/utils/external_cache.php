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

/**
 * Internal -- Has the external cache been checked to determine if it is available and configured.
 */
$external_cache_checked = false;

/**
 * Internal -- Is the external cache available.  This setting is determined by checking for the availability
 * of the external cache functions.  It can be overridden by adding a config variable 
 * (external_cache_disabled=true).
 */
$external_cache_enabled = false;

/**
 * Internal -- This is controlled by a config setting (external_cache_reset) that will update the cache
 * with new values, but not read from the cache.
 */
$external_cache_overwrite = false;

/**
 * Internal -- The number of hits on the external out of process cache in this request
 */
$external_cache_request_external_hits = 0;

/**
 * Internal -- The number of total requests to the external out of process cache in this request
 */
$external_cache_request_external_total = 0;

/**
 * Internal -- The number of hits on the external local cache in this request
 */
$external_cache_request_local_hits = 0;

/**
 * Internal -- The number of total requests to the external local cache in this request
 */
$external_cache_request_local_total = 0;

/**
 * Internal -- The data structure for the local cache.
 */
static $cache_local_store = array();

/**
 * Internal -- The type of external store available.
 */
static $external_cache_type = null;

/**
 * The interval in seconds that an external cache entry is valid.
 */
define('EXTERNAL_CACHE_INTERVAL_SECONDS', 300 );

/**
 * This constant is provided as a convenience for users that want to store null values
 * in the cache.  If your function frequently has null results that take a long time to
 * calculate, store those results in the cache.  On retrieval, substitue the value you 
 * stored for null.
 */
define('EXTERNAL_CACHE_NULL_VALUE', "SUGAR_CACHE_NULL_ZZ");

/**
 * Set this to true to see cache debugging messages in the end user UI.
 * This is a quick way to determine how well the cache is working and find out what
 * records are not being cached effectively.
 */
define('EXTERNAL_CACHE_DEBUG', false);

/**
 * Internal -- Determine if there is an external cache available for use.  
 * Currently only Zend Platform is supported.
 */
function check_cache()
{
    if(EXTERNAL_CACHE_DEBUG) echo "<HR>Checking cache<HR>";
    
    if($GLOBALS['external_cache_checked'] == false)
    {
        $GLOBALS['external_cache_checked'] = true;
		
        // If the cache is manually disabled, turn it off.
        if(!empty($GLOBALS['sugar_config']['external_cache_disabled']) && true == $GLOBALS['sugar_config']['external_cache_disabled'])
        {
            $GLOBALS['external_cache_enabled'] = false;
            return;
        }
        
        // Check for supported platforms...
        if(function_exists("output_cache_get"))
        {
            $GLOBALS['external_cache_enabled'] = true;
            $GLOBALS['external_cache_type'] = "zend";
        }
        elseif(function_exists("apc_store"))
        {
            $GLOBALS['external_cache_enabled'] = true;
            $GLOBALS['external_cache_type'] = "apc";
        }
        else 
        {
            // no cache available....return
            return;
        }
        
        // If the cache is being reset, turn it off for this round trip
        $value = external_cache_retrieve_helper($GLOBALS['sugar_config']['unique_key'].'EXTERNAL_CACHE_RESET');
        if(!empty($value))
        {
            // We are in a cache reset, do not use the cache.
            $GLOBALS['external_cache_enabled'] = false;        
        }
        else
        {
            // Add one to the external cache hits.  This will keep the end user statistics simple.
            // All real checks suceeding will result in 100%.  Otherwise people will be looking for 
            // the one check that did not pass.
    		$GLOBALS['external_cache_request_external_hits']++;
        }
    }
    
    if(EXTERNAL_CACHE_DEBUG) echo "<HR>Checking cache: {$GLOBALS['external_cache_enabled']}<HR>";
}

/**
 * Retrieve a key from cache.  For the Zend Platform, a maximum age of 5 minutes is assumed.
 *
 * @param String $key -- The item to retrieve.
 * @return The item unserialized
 */
function sugar_cache_retrieve($key)
{
    if(!$GLOBALS['external_cache_checked'])
    {
        check_cache();
    }

    // If we are currently resetting the cache, do not return any value.  Inserts should still occur.
    if($GLOBALS['external_cache_enabled'] && !empty($GLOBALS['sugar_config']['external_cache_reset']) && true == $GLOBALS['sugar_config']['external_cache_reset'])
    {
        // Remove any existing value:
        sugar_cache_clear($key);
        
        return null;
    }
    
   	$GLOBALS['external_cache_request_local_total']++;    

   	if(!empty($GLOBALS['cache_local_store'][$key]))
    {
    	$GLOBALS['external_cache_request_local_hits']++;    

        return $GLOBALS['cache_local_store'][$key];
    }
    
    if(!$GLOBALS['external_cache_enabled'])
    {   
        return null;
    }

	// If it is not in memory, but is in cache, copy it to memory and use it
    $value = external_cache_retrieve_helper($GLOBALS['sugar_config']['unique_key'].$key);
    if(!empty($value))
    {
        $GLOBALS['cache_local_store'][$key] = $value; 
		$GLOBALS['external_cache_request_external_hits']++;    
    }            
	else
	{
		if(EXTERNAL_CACHE_DEBUG) echo "<HR>External cache retrieve failed: $key <HR>";    
	}

	return $value;
}

/**
 * Internal -- This function actually retrieves information from the caches.
 * It is a helper function that provides that actual cache API abstraction.
 *
 * @param unknown_type $key
 * @return unknown
 */
function external_cache_retrieve_helper($key)
{
	$GLOBALS['external_cache_request_external_total']++;    
	
	$value = null;
    if($GLOBALS['external_cache_type'] == 'zend')
    {
        $value = output_cache_get($key, EXTERNAL_CACHE_INTERVAL_SECONDS);
    }
    elseif ($GLOBALS['external_cache_type'] == 'apc')
    {
        $value = apc_fetch($key);
        if(EXTERNAL_CACHE_DEBUG) echo "<HR>retrieving key from cache ($key) value: ($value)<HR>";
    }
    
    return $value;
}

/**
 * Put a value in the cache under a key
 *
 * @param String $key -- Global namespace cache.  Key for the data.
 * @param Serializable $value -- The value to store in the cache.
 */
function sugar_cache_put($key, $value)
{
    if(!$GLOBALS['external_cache_checked'])
    {
        check_cache();
    }

    if(EXTERNAL_CACHE_DEBUG) echo "<HR>1 Adding key to APC cache $key with value ($value)<HR>";
    
    if(empty($value))
    {
    	$value = EXTERNAL_CACHE_NULL_VALUE;
    }

    if(EXTERNAL_CACHE_DEBUG) echo "<HR>2 Adding key to APC cache $key with value ($value)<HR>";
        
    $GLOBALS['cache_local_store'][$key] = $value;
    
    if($GLOBALS['external_cache_enabled'])
    {   
	    $external_key = $GLOBALS['sugar_config']['unique_key'].$key;
		if($GLOBALS['external_cache_type'] == 'zend')
		{
		    output_cache_put($external_key, $value);
		}
		elseif ($GLOBALS['external_cache_type'] == 'apc')
		{
			$test_time = EXTERNAL_CACHE_INTERVAL_SECONDS;
		    $return = apc_store($external_key, $value, $test_time);
		    if(EXTERNAL_CACHE_DEBUG) echo "<HR>Adding key to APC cache $external_key with value ($value) to be stored for $test_time seconds<HR>";
		}    
    }
}

/**
 * Clear a key from the cache.  This is used to invalidate a single key.
 *
 * @param String $key -- Key from global namespace
 */
function sugar_cache_clear($key)
{
    unset($GLOBALS['cache_local_store'][$key]);

    if($GLOBALS['external_cache_enabled'])
    {
        $external_key = $GLOBALS['sugar_config']['unique_key'].$key;
	    if($GLOBALS['external_cache_type'] == 'zend')
	    {
	        output_cache_remove_key($external_key);
	    }
	    elseif ($GLOBALS['external_cache_type'] == 'apc')
	    {
	        apc_delete($external_key);
	    }
        
    }
}

/**
 * Turn off external caching for the rest of this round trip and for all round 
 * trips for the next cache timeout.  This function should be called when global arrays
 * are affected (studio, module loader, upgrade wizard, ... ) and it is not ok to 
 * wait for the cache to expire in order to see the change.
 */
function sugar_cache_reset()
{
    // Set a flag to clear the code.
    sugar_cache_put('EXTERNAL_CACHE_RESET', true);
    
    // Clear the local cache
    $GLOBALS['cache_local_store'] = array();
    
    // Disable the external cache for the rest of the round trip
    $GLOBALS['external_cache_enabled'] = false;
}

