<?php
class Role_model extends Model 
{
	
	var $roleID;
	var $roleName;
	var $rstatus;
	var $description;
	
    function Role_model($id='')
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database();
    }
    
    function create()
    {
    	$data['roleID'] 	= $this->roleID ;
       	$data['roleName'] 	= $this->roleName ;
       	$data['rstatus'] 	= $this->rstatus ;
       	$data['description']= $this->description ;
        $this->db->insert('roles', $data); 
    }
    
    function retrieve($id)
    {
    	$query = $this->db->query("SELECT * FROM `roles` Where roleID = '".$id."' ");
    	$row = $query->result();
    	
    	if ($row && $id) {
        	$this->roleID      = $row[0]->roleID;
        	$this->roleName    = $row[0]->roleName;
        	$this->description = $row[0]->description;
    	}
    }
    
    function update($id = '')
    {
    	$data['roleID'] 	= $id;
       	$data['roleName'] 	= $this->roleName;
       	$data['rstatus'] 	= $this->rstatus;
       	$data['description']= $this->description;
       	
       	$this->db->where('roleID', $id);
        $this->db->update('roles', $data); 
    }

	function delete($id)
    {
    	$this->db->where('roleID', $id);
		$this->db->delete('roles'); 
    }    
    
    function retrieveAll($offset=0, $limit=50)
    {
    	$query = $this->db->get("roles");
    	return $query->result();
    }

    function isExist($roleName)
    {
    	$this->db->where('roleName', $roleName);
    	$this->db->select('roleID');
		$query = $this->db->get('roles'); 
		if($query->result()) {
			return 1;
		} else {
			return 0;
		}
    }
    
    function getlastID($roleName)
    {
    	$this->db->where('roleName', $roleName);
    	$this->db->select('roleID');
		$query = $this->db->get('roles',1); 
		return $query->result();
    }
    
}
?>