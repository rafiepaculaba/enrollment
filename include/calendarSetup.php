<?php
    require_once('data/Tracker.php');
    require_once('include/JSON.php');
    require_once('include/TimeDate.php');
    require_once('include/utils.php');
    require_once('modules/Emails/Email.php');
    require_once('modules/EmailTemplates/EmailTemplate.php');
    require_once('XTemplate/xtpl.php');
    
    global $app_strings;
    global $app_list_strings;
    global $mod_strings;
    global $current_user;
    global $sugar_version, $sugar_config;
    
    
        /*Calendar.setup ({
                inputField : "expiry_date", ifFormat : "%m/%d/%Y", showsTime : false, button : "jscal_trigger1", singleClick : true, step : 1
        });
    */
        
    function calendarSetup($inputField, $button) {
        echo '<script type="text/javascript">';
        //jscal_field
        echo 'Calendar.setup ({';
        echo '        inputField : "'.$inputField.'", ifFormat : "%m/%d/%Y", showsTime : false, button : "'.$button.'", singleClick : true, step : 1';
        echo '});';
        echo '</script>';
    }
        
?>

