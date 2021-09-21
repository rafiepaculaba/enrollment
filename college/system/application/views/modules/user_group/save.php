
<!--Javascripts-->
	
<script language="javascript">
    
    function refreshOpener() 
    {
         window.opener.location='index.php?user_group/view/<?php echo $groupID; ?>';
    }
    
    refreshOpener();
    window.close();
     

</script>
	
