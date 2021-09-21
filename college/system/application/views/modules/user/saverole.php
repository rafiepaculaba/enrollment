
<!--Javascripts-->
	
<script language="javascript">
    
    function refreshOpener() 
    {
         window.opener.location='index.php?user/view/<?php echo $userID; ?>';
    }
    
    refreshOpener();
    window.close();
     

</script>
	
