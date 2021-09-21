<?php
class Group_model extends Model 
{
	
	var $groupID;
	var $groupName;
	var $rstatus;
	var $description;
	
    function Group_model($id='')
    {
        // Call the Model constructor
        parent::Model();
        $this->load->database();
    }
    
    function create()
    {
    	$data['groupID'] 	= $this->groupID ;
       	$data['groupName'] 	= $this->groupName ;
       	$data['rstatus'] 	= $this->rstatus ;
       	$data['description']= $this->description ;
        $this->db->insert('user_groups', $data); 
    }
    
    function retrieve($id = '')
    {
    	$query = $this->db->query("SELECT * FROM `user_groups` Where groupID = '".$id."' ");
    	return $query->result();
    }
    
    function update($id = '')
    {
    	$data['groupID'] 	= $id;
       	$data['groupName'] 	= $this->groupName;
       	$data['rstatus'] 	= $this->rstatus;
       	$data['description']= $this->description;
       	
       	$this->db->where('groupID', $id);
        $this->db->update('user_groups', $data); 
    }

	function delete($id)
    {
    	$this->db->where('groupID', $id);
		$this->db->delete('user_groups'); 
    }    
    
    function retrieveAll($offset=0, $limit=50)
    {
    	$query = $this->db->get("user_groups");
    	return $query->result();
    }

    function isExist($groupName)
    {
    	$this->db->where('groupName', $groupName);
    	$this->db->select('groupID');
		$query = $this->db->get('user_groups'); 
		if($query->result()) {
			return 1;
		} else {
			return 0;
		}
    }
    
    function getlastID($groupName)
    {
    	$this->db->where('groupName', $groupName);
    	$this->db->select('groupID');
		$query = $this->db->get('user_groups',1); 
		return $query->result();
    }
    
}
?>