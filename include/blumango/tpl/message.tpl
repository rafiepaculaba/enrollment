<!--{if $class eq "errorbox"}
    <div class="{$class}" id="bigcontainer">
{elseif $class eq "confirmbox"}
    <div class="{$class}" style="display:{$display}; background: url(include/blumango/images/msg_info.gif) 5px center no-repeat; " id="bigcontainer">
{elseif $class eq "dummy"}    
    <div class="{$class}" style="display:{$display}; background: url(include/blumango/images/msg_error.gif) 5px center no-repeat; " id="bigcontainer">
    <div class="{$class}" style="display:{$display}; background: url(include/blumango/images/msg_info.gif) 5px center no-repeat; " id="bigcontainer">
    <div class="{$class}" style="display:{$display}; background: url(include/blumango/images/msg_check.gif) 5px center no-repeat;" id="bigcontainer">
{else}
    <div class="{$class}" style="display:{$display}; background: url(include/blumango/images/msg_check.gif) 5px center no-repeat;" id="bigcontainer">
{/if}-->
<div class="{$class}" style="display:{$display};

{if $class eq 'errorbox'}
    background: url(include/blumango/images/msg_error.gif) 5px center no-repeat;
{elseif $class eq 'confirmbox'}
    background: url(include/blumango/images/msg_info.gif) 5px center no-repeat;
{elseif $class eq 'notificationbox'}
    background: url(include/blumango/images/msg_check.gif) 5px center no-repeat;
{/if}

" id="bigcontainer">
        <div class="boxcontent" id="msgcontainer">
        {if $loading=='1'}
            <img src='themes/Sugar/images/sqsWait.gif' alt='loading'/>
    	{/if}
    	
        {$msg}
        </div>
</div>


<div id="divloading" class="loading" style="width: 150px; height: 25px; visibility:hidden; display:none;" >
&nbsp;&nbsp;<img src="themes/Sugar/images/sqsWait.gif" alt="Loading"/> &nbsp;&nbsp;<b>Loading...</b>
</div>