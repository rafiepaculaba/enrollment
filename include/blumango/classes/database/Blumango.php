<?php
/**
 * class: Blumango
 * 
 * descriptioin: This class is for database connectivity and expanding the PDO extension of database abstration.
 * date created: 12/20/2007
 * created by: BluMango Dev Team
 */
require('config.php');
require_once('include/blumango/classes/database/QBuilder.php');
require_once('include/blumango/classes/utils/debug_utils.php');

global $sugar_config;

/*************************************************************************************
 * Enrollment System: Separate database for Elem, HS, College Level
 *************************************************************************************/
$categoryDatabases[1]="elementary";
$categoryDatabases[2]="highschool";
$categoryDatabases[3]="college";
$categoryDatabases[4]="preschool";

/**
 * Class: Database
 * Description: This class contains all the methods to interface the mysql database server used in the record management.
 */

class Blumango extends QBuilder
{
	var $db;
	var $dbase_errs;
	
	/**
	 * Database() constructor of the this Database class
	 */
	function Blumango($level=0)
	{
	    global $sugar_config;
	    
        // create connection to the mysql server
        try{
            switch ($level)
            {
            case 1:
                // elementary level
                echo "elementary level-scad";
                $this->db = new PDO('mysql:host='.$sugar_config['dbconfig']['db_host_name'].';dbname='.$categoryDatabases[1], $sugar_config['dbconfig']['db_user_name'], $sugar_config['dbconfig']['db_password'], array( PDO::ATTR_PERSISTENT => true, PDO::ATTR_AUTOCOMMIT  => false));		
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            case 2:
                // highschool level
                $this->db = new PDO('mysql:host='.$sugar_config['dbconfig']['db_host_name'].';dbname='.$categoryDatabases[2], $sugar_config['dbconfig']['db_user_name'], $sugar_config['dbconfig']['db_password'], array( PDO::ATTR_PERSISTENT => true, PDO::ATTR_AUTOCOMMIT  => false));		
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            case 3:
                // highschool level
                $this->db = new PDO('mysql:host='.$sugar_config['dbconfig']['db_host_name'].';dbname='.$categoryDatabases[3], $sugar_config['dbconfig']['db_user_name'], $sugar_config['dbconfig']['db_password'], array( PDO::ATTR_PERSISTENT => true, PDO::ATTR_AUTOCOMMIT  => false));		
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            case 4:
                // preschool level
                $this->db = new PDO('mysql:host='.$sugar_config['dbconfig']['db_host_name'].';dbname='.$categoryDatabases[4], $sugar_config['dbconfig']['db_user_name'], $sugar_config['dbconfig']['db_password'], array( PDO::ATTR_PERSISTENT => true, PDO::ATTR_AUTOCOMMIT  => false));		
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            default:
                // highschool level
                $this->db = new PDO('mysql:host='.$sugar_config['dbconfig']['db_host_name'].';dbname='.$sugar_config['dbconfig']['db_name'], $sugar_config['dbconfig']['db_user_name'], $sugar_config['dbconfig']['db_password'], array( PDO::ATTR_PERSISTENT => true, PDO::ATTR_AUTOCOMMIT  => false));		
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        }catch(PDOException $e){
            echo $e;
        }
	}
	
}


?>