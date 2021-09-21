<!--Javascripts-->

<script language="javascript">
    
    function refreshOpener() 
    {
         window.opener.location='index.php?enrollment/reservation_edit/<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4); ?>/<?php echo $this->uri->segment(5); ?>';
    }
    
    refreshOpener();
    window.close();
     

</script>