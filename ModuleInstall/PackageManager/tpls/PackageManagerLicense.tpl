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
 <table>
 	<tr>
 		<td>{$MOD.LBL_MODULE_LICENSE}</td>
 	</tr>
 	<tr>
 		<td><textarea id='license' cols='75' rows='8'>{$LICENSE_CONTENTS}</textarea></td>
 	</tr>
 	<tr>
 		<td><input type='radio' id='radio_license_agreement_accept' name='radio_license_agreement' value='accept'>{$MOD.LBL_ACCEPT}&nbsp;<input type='radio' id='radio_license_agreement_reject' name='radio_license_agreement' value='reject'>{$MOD.LBL_DENY}</td>
 	</tr>
 	<tr>
 		<tr><td><input type='button' id='btnLicense' value='OK' onClick='PackageManager.processLicense("{$FILE}");' class='button'></td>
 	</tr>
</table>
