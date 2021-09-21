<?php /* Smarty version 2.6.11, created on 2008-12-26 08:18:25
         compiled from include/blumango/tpl/message.tpl */ ?>
<!--<?php if ($this->_tpl_vars['class'] == 'errorbox'): ?>
    <div class="<?php echo $this->_tpl_vars['class']; ?>
" id="bigcontainer">
<?php elseif ($this->_tpl_vars['class'] == 'confirmbox'): ?>
    <div class="<?php echo $this->_tpl_vars['class']; ?>
" style="display:<?php echo $this->_tpl_vars['display']; ?>
; background: url(include/blumango/images/msg_info.gif) 5px center no-repeat; " id="bigcontainer">
<?php elseif ($this->_tpl_vars['class'] == 'dummy'): ?>    
    <div class="<?php echo $this->_tpl_vars['class']; ?>
" style="display:<?php echo $this->_tpl_vars['display']; ?>
; background: url(include/blumango/images/msg_error.gif) 5px center no-repeat; " id="bigcontainer">
    <div class="<?php echo $this->_tpl_vars['class']; ?>
" style="display:<?php echo $this->_tpl_vars['display']; ?>
; background: url(include/blumango/images/msg_info.gif) 5px center no-repeat; " id="bigcontainer">
    <div class="<?php echo $this->_tpl_vars['class']; ?>
" style="display:<?php echo $this->_tpl_vars['display']; ?>
; background: url(include/blumango/images/msg_check.gif) 5px center no-repeat;" id="bigcontainer">
<?php else: ?>
    <div class="<?php echo $this->_tpl_vars['class']; ?>
" style="display:<?php echo $this->_tpl_vars['display']; ?>
; background: url(include/blumango/images/msg_check.gif) 5px center no-repeat;" id="bigcontainer">
<?php endif; ?>-->
<div class="<?php echo $this->_tpl_vars['class']; ?>
" style="display:<?php echo $this->_tpl_vars['display']; ?>
;

<?php if ($this->_tpl_vars['class'] == 'errorbox'): ?>
    background: url(include/blumango/images/msg_error.gif) 5px center no-repeat;
<?php elseif ($this->_tpl_vars['class'] == 'confirmbox'): ?>
    background: url(include/blumango/images/msg_info.gif) 5px center no-repeat;
<?php elseif ($this->_tpl_vars['class'] == 'notificationbox'): ?>
    background: url(include/blumango/images/msg_check.gif) 5px center no-repeat;
<?php endif; ?>

" id="bigcontainer">
        <div class="boxcontent" id="msgcontainer">
        <?php if ($this->_tpl_vars['loading'] == '1'): ?>
            <img src='themes/Sugar/images/sqsWait.gif' alt='loading'/>
    	<?php endif; ?>
    	
        <?php echo $this->_tpl_vars['msg']; ?>

        </div>
</div>


<div id="divloading" class="loading" style="width: 150px; height: 25px; visibility:hidden; display:none;" >
&nbsp;&nbsp;<img src="themes/Sugar/images/sqsWait.gif" alt="Loading"/> &nbsp;&nbsp;<b>Loading...</b>
</div>