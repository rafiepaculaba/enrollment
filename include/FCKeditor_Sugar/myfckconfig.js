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
/*********************************************************************************

 * Description: use this file to override config setting in include/FCKeditor/fckconfig.js
 ********************************************************************************/

FCKConfig.ToolbarStartExpanded	= true;
/* removed save option from the default toolbar.*/
FCKConfig.ToolbarSets["Default"] = [
	['Source','DocProps','-','NewPage','Preview','-','Templates'],
	['Cut','Copy','Paste','PasteText','PasteWord','-','Print','SpellCheck'],
	['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
	['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript'],
	['OrderedList','UnorderedList','-','Outdent','Indent'],
	['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
	['Link','Unlink','Anchor'],
	['Table','Rule','Smiley','SpecialChar','PageBreak','UniversalKey'],
	['Form','Checkbox','Radio','TextField','Textarea','Select','Button','HiddenField'],
	'/',
	['Style','FontFormat','FontName','FontSize'],
	['TextColor','BGColor'],
	['About']
	//['InsertAttachment'],
	//['EmbedAttachment']
] ;

FCKConfig.ToolbarSets["Light"] = [
	['Bold','Italic', 'Underline','StrikeThrough','-','OrderedList','UnorderedList','-','Link','Unlink','-','TextColor'],
	['About']
] ;
/*
FCKConfig.Plugins.Add('InsertAttachment', 'en'); 
FCKConfig.Plugins.Add('EmbedAttachment','en');

//Adding support for embedded images
FCKConfig.LinkBrowserURL = FCKConfig.BasePath +
  'filemanager/browser/default/browser.html?Connector=/attachment/command';
FCKConfig.ImageBrowserURL = FCKConfig.BasePath +
  'filemanager/browser/default/browser.html?Type=Image&Connector=/attachment/command';
FCKConfig.LinkUploadURL = '/attachment/upload';
FCKConfig.ImageUploadURL = '/attachment/upload?Type=Image';
FCKConfig.FlashUploadURL = '/attachment/upload?Type=Flash';
*/
