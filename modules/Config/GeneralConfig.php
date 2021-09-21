<?php
/**
 * Edited
 * Filename: GeneralConfig.php
 * Date: 	 Nov 4, 2008
 * 
 * Author: 	 Erwin Dacua
 * 
 */

/**
 * Class: GeneralConfig
 * Description: This class is a model of the object - GeneralConfig
 * 				Implementing the active record pattern of database record
 */

class GeneralConfig extends Database 
{
	
	var $configID;
	var $title;
	var $definition;
	var $rstatus;
	/**
	 *Config() constructor of the Config class
	 *
	 * @return Config
	 */
	function GeneralConfig($lvl=3) 
	{
	    // calling the parent class
	    parent::Database($lvl); 
	}
	
	/**
	 * retrieveAllConfigs() method to retrieve all/selected Config records
	 *
	 * @param array $where
	 * @param string $orderby
	 * @param string $sorting
	 * @param int $offset
	 * @param int $limit
	 * @return array recordset
	 */
	function retrieveAllConfigs($where='',$orderby='title', $sorting='ASC', $offset=0, $limit='')
	{
		// building an insert query
	    $this->tables = "configurations";
	    $this->conds  = $where;
	    $this->order  = $orderby;
	    $this->sorting= $sorting;
	    $this->offset = $offset;
	    $this->limit  = $limit;
	    $this->lock   = 0;

	    // building an select query
	    $query = $this->Select();  // generate delete sql query
	    $this->reset();            // reset all variables in query generator
		
	    
		try {
    	    $this->db->beginTransaction();
        	$result   = $this->db->query($query);
    		$records  = $result->fetchAll(PDO::FETCH_BOTH);
    		$this->db->commit();
    		return $records;
		} catch (PDOException $e) {
		    echo "SQL query error.";
		    return false;
		}
	}
	
	/**
	 * getConfig() method that will get the definition of the config
	 *
	 * @param string $title
	 */
	function getConfig($title) 
	{
	    $conds[0]['title'] = "='$title'";
        $result = $this->retrieveAllConfigs($conds);
        if ($result) {
            return $result[0]['definition'];
        } else {
            return "";
        }
	}
	
}
?>