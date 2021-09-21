{*
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version
 * 1.1.3 ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied.  See the License
 * for the specific language governing rights and limitations under the
 * License.
 *
 * All copies of the Covered Code must include on each user interface screen:
 *    (i) the "Powered by SugarCRM" logo and
 *    (ii) the SugarCRM copyright notice
 * in the same form as they appear in the distribution.  See full license for
 * requirements.
 *
 * The Original Code is: SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) 2004-2006 SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
 *}
{$scripts}
{$TREEHEADER}
{literal}
	<link rel="stylesheet" type="text/css" href="include/javascript/yui/assets/container.css"/>
	<link rel="stylesheet" type="text/css" href="include/javascript/yui/ext/resources/css/grid.css?1027"/>
	<link rel="stylesheet" type="text/css" href="include/javascript/yui/ext/resources/css/toolbar.css"/>
	<link rel="stylesheet" type="text/css" href="include/javascript/yui/ext/resources/css/tabs.css?1030"/>
	<link rel="stylesheet" type="text/css" href="include/javascript/yui/assets/tabview/css/tabs.css">
<link rel="stylesheet" type="text/css" href="include/javascript/yui/assets/tabview/css/round_tabs.css">
<style type="text/css">
#demo { width:100%; }
#demo .yui-content {
    padding:1em; /* pad content container */
}
.list {list-style:square;width:500px;padding-left:16px;}
.list li{padding:2px;font-size:8pt;}

/* hide the tab content while loading */
.tab-content{display:none;}

pre {
   font-size:11px; 
}

#tabs1 {width:100%;}
#tabs1 .yui-ext-tabbody {border:1px solid #999;border-top:none;}
#tabs1 .yui-ext-tabitembody {display:none;padding:10px;}

/* default loading indicator for ajax calls */
.loading-indicator {
	font-size:8pt;
	background-image:url('include/javascript/ui/ext/resources/images/grid/loading.gif');
	background-repeat: no-repeat;
	background-position: left;
	padding-left:20px;
}
</style>
{/literal}
{if $installation != 'true'}
<ul class="tablist">
<li id="server_upload_li" class="active"><a id="server_upload_link"  class="current" href="javascript:PackageManager.selectTabCSS('server_upload');">{$MOD.ML_LBL_INSTALL_FROM_SERVER}</a></li>  
<li class="active" id="local_upload_li"><a id="local_upload_link" href="javascript:PackageManager.selectTabCSS('local_upload');">{$MOD.ML_LBL_INSTALL_FROM_LOCAL}</a></li> 
</ul>
{/if}
<form action='{$form_action}' method="post" name="installForm">
<input type=hidden name="release_id">
{$hidden_fields}
<div id='server_upload_div'>
{$FORM_2_PLACE_HOLDER}
{$MODULE_SELECTOR}
<div id='search_results_div'></div>
</div>
</form>
<div id='local_upload_div' style='display: none;'>
{$FORM_1_PLACE_HOLDER}
</div>
{$INSTALLED_PACKAGES_HOLDER}
{if $module_load == 'true'}
{literal}<script>
//PackageManager.toggleView('browse');
</script>
{/literal}
{/if}



