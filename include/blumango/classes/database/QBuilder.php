<?php
/**
 * class: QBuilder ver. 2.0
 * description: This is a query helper class
 * date created: 12/20/2007
 * created by: BluMango Dev Team
 */

class QBuilder
{
	var $tables;
	var $fields;
	var $conds;
	var $safer;
	var $offset;
	var $multi_orders;
	var $order;
	var $groupby;
	var $sorting;
	var $limit;
	var $lock;
	var $errs;

    /**
     * Constructor method
     */
	public function __construct() 
	{
	    // set default values
	    $this->sorting = 'ASC';
	}

	/**
	 * Insert() method will generate insert query.
	 *
	 * @return sql
	 */
	public function Insert()
	{
        $x = 1;
        $y = 1;
        $lfields = count($this->fields);
        
        // clear errors
        unset($this->errs);
        
        $query   = "INSERT INTO ";

        //post tables
        if (!empty($this->tables)) {
            if (is_array($this->tables)) {
                foreach($this->tables as $val) {
                	$query .= $val . ' ';
                }
            } else {
                $query .= $this->tables . ' ';
            }
        } else {
            // error found - table is required
            $this->errs[] = "No table/s set.";
        }
        
        //post fields
        if (!empty($this->fields)) {
            $query .= '(';
            foreach($this->fields as $key => $val) {
            	if ($x++ < $lfields) {
            	    $query .= '`' . $key . '`, ';
            	} else {
            	    $query .= '`' . $key . '`) ';
            	}
            }
        }
        
        //post values
        if (!empty($this->fields)) {
            $query .= 'VALUES(';
            foreach($this->fields as $key => $val) {
            	//replace special quotes with safe quotes
            	if($y++<$lfields) {
            	   $query .= "'" . addslashes($val) . "', ";
            	} else {
            	   $query .= "'" . addslashes($val) . "')";
            	}
            }
        } else {
            // error found - values are required
            $this->errs[] = "No values/s set.";
        }
        
        return $query;
	}

	/**
	 * Update() method will generate update query.
	 *
	 * @return sql
	 */
    public function Update()
    {
        $x=1;
        $y=1;
        $lfields  = count($this->fields);
        $lconds   = count($this->conds);
        
        // clear errors
        unset($this->errs);
        
        $query    = 'UPDATE ';
        
        // post tables
        if (!empty($this->tables)) {
            if (is_array($this->tables)) {
                foreach ($this->tables as $val) {
                    $query .= $val . ' ';
                }
            } else {
                $query .= $this->tables . ' ';
            }
        } else {
            // error found - table is required
            $this->errs[] = "No table/s set.";
        }
        
        // post value setters
        if(!empty($this->fields)) {
            $query .= 'SET ';
            
            foreach ($this->fields as $key => $val) {
                if($x++ < $lfields) {
                    $query .= $key . " = '" . addslashes($val)  . "', ";
                } else {
                    $query .= $key . " = '" . addslashes($val)  . "' ";
                }
            }
        }
        
        // post conditions
        if(!empty($this->conds)) {
            if(is_array($this->conds)) {
                $query .= 'WHERE ';
                
                foreach ($this->conds as $key => $val) {
                    foreach($val as $key => $val) {
                        $query .= $key . $val . ' ';
                    }
                }
            }
        }
    
        return $query;
    }

	/**
	 * Delete() method will generate delete query.
	 *
	 * @return sql
	 */
	public function Delete()
	{
        $x = 1;
        $y = 1;
        $z = 1;
        $ltables  = count($this->tables);
        $lfields  = count($this->fields);
        $lconds   = count($this->conds);
        
        // clear errors
        unset($this->errs);
        
        $query    = 'DELETE FROM ';
        
        // post tables
        if (!empty($this->tables)) {
            if (is_array($this->tables)) {
                foreach ($this->tables as $val){
                    if($y++ < $ltables) {
                        $query .= $val . ', ';
                    } else {
                        $query .= $val . ' ';
                    }
                }
            } else {
                $query .= $this->tables . ' ';
            }
        } else {
            // error found - table is required
            $this->errs[] = "No table/s set.";
        }
        
        // post conditions
        if (!empty($this->conds)) {
            if (is_array($this->conds)) {
                $query .= 'WHERE ';
            
                foreach($this->conds as $key => $val){
                    foreach($val as $key => $val) {
                        $query .= $key . $val . ' ';
                    }
                }
            }
        }
        
        return $query;
	}

	/**
	 * Select() method will generate select query.
	 *
	 * @return sql
	 */
	public function Select()
	{
		$x = 1;
		$y = 1;
		$z = 1;
		$lfields  = count($this->fields);
		$ltables  = count($this->tables);
		$lconds   = count($this->conds);
		
		// clear errors
        unset($this->errs);
		
		$query    = 'SELECT ';

		//post fields
		if (is_array($this->fields)) {
			foreach ($this->fields as $key => $val){
				if($x++ < $lfields) {
				    $query .= $key . ', ';
				} else {
				    $query .= $key . ' ';
				}
			}
		} else {
			$query .= ' * ';
		}

		// post tables
		$query .= 'FROM ';
		
		if (!empty($this->tables)) {
    		if(is_array($this->tables)) {
    			foreach($this->tables as $val){
    				if($y++ < $ltables) {
    					$query .= addslashes($val) . ', ';
    				} else {
    					$query .= addslashes($val) . ' ';
    				}
    			}
    		} else {
    			$query .= $this->tables . ' ';
    		}
		} else {
		    // error found - table is required
            $this->errs[] = "No table/s set.";
		}

		// post conditions
		if(isset($this->conds)) {
			if(is_array($this->conds)) {
				$query .= 'WHERE ';
				
				foreach($this->conds as $val) {
					if(is_array($val)) {
    					foreach($val as $keys => $vals){
    						$query .= $keys . $vals . ' ';
    					}
					}
				}
			}
		}
		
		//set safer - safe query terminator
		if($this->safer) {
			$query .= '1';
		} else {
		    
		    if($this->lock) {
    			$query .= 'LOCK IN SHARE MODE ';
    		}
		    
    		if($this->groupby) {
    			$query .= 'GROUP BY ' . $this->groupby. ' ';
    		}
    
    		
    		if($this->order) {
    			$query .= 'ORDER BY ' . $this->order . ' ' . $this->sorting . ' ';
    		} else if ($this->multi_orders) {
    		    $x = 1;
    		    $lfields  = count($this->multi_orders);
    		    
    		    $query .= 'ORDER BY ';
    		    
    		    foreach($this->multi_orders as $key => $sort) {
                    if($x++ < $lfields) {
                        $query .= $key . " $sort, ";
                    } else {
                        $query .= $key . " $sort ";
                    }
                }
    		}
    
    		//post limit and offset
    		if($this->offset || $this->limit) {
    			$query .= 'LIMIT ' . (($this->offset) ? ($this->offset) : '') . (($this->offset && $this->limit) ? ', ' : '') . $this->limit;
    		}
    		
		}


		return $query;
	}
	
	/**
	 * reset method - will reset the particular attribute if specified or all attribute will not specified
	 *
	 * @param unknown_type $var
	 */
	public function reset($var="") {
	    if ($var){
	       if (isset($var)) {
        		switch($var) {
    			case 'table':
    			case 'tables':
          			$this->tables  = "";
          			break;
        
          		case 'fields':
          			$this->fields  = "";
          			break;
        
          		case 'conds':
          			$this->conds   = "";
          			break;
        
        		case 'offset':
          			$this->offset  = "";
          			break;
        
          		case 'groupby':
          			$this->groupby = "";
          			break;
        
        		case 'order':
          			$this->order   = "";
          			break;
          			
          		case 'multi_orders':
          			$this->multi_orders = "";
          			break;
        
        		case 'sorting':
          			$this->sorting = "";
          			break;
          		
      			case 'lock':
          			$this->lock    = "";
          			break;
        
        		case 'limit':
          			$this->limit   = "";
          			break;
        		}
    		}
	    } else {
            // reset all attributes
            $this->tables  = "";
        	$this->fields  = "";
        	$this->conds   = "";
        	$this->safer   = "";
        	$this->offset  = "";
        	$this->multi_orders = "";
        	$this->order   = "";
        	$this->groupby = "";
        	$this->sorting = "";
        	$this->limit   = "";
        	$this->errs    = "";        
	    }
	}
	
	/**
	 * displayErrors method -  will display all the errors found during building a query
	 *
	 * @return unknown
	 */
	public function displayErrors()
	{
	    if ($this->errs) {
	        $output = "Error(s) in building query: <br>";
	        foreach ($this->errs as $err) {
	            $output .= $err."<br>";
	        }
	    }
	    return $output;
	}
}

?>