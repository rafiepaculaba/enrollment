<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
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
require_once('include/dir_inc.php');
require_once('include/utils/file_utils.php');
require_once('include/utils/progress_bar_utils.php');
include_once ('include/database/DBManagerFactory.php');
require_once('modules/Relationships/Relationship.php');

class ModuleInstaller{
	var $modules = array();
	var $silent = false;
	var $base_dir  = '';
	function ModuleInstaller(){
		$this->modules = get_module_dir_list();	
		$this->db = & DBManagerFactory::getInstance();
  
		
	}
	function install($base_dir, $is_upgrade = false, $previous_version = ''){
		global $app_strings;
		$this->base_dir = $base_dir;
		$total_steps = 4; //minimum number of steps with no tasks
		$current_step = 0;
		$tasks = array(
								'pre_execute',
								'install_mkdirs',
								'install_copy',
								'install_images',
								'install_menus',
								'install_userpage',
								'install_dashlets',
								'install_administration',
								'install_vardefs',
								'install_layoutdefs',
								'install_relationships',
								'install_languages',
		);
		$total_steps += count($tasks);
		if(file_exists($this->base_dir . '/manifest.php')){
				if(!$this->silent){
					$current_step++;
					display_progress_bar('install', $current_step, $total_steps);
					echo '<div id ="displayLoglink" ><a href="#" onclick="toggleDisplay(\'displayLog\')">'.$app_strings['LBL_DISPLAY_LOG'].'</a> </div><div id="displayLog" style="display:none">';
				}
					
				require_once($this->base_dir . '/manifest.php');
				if($is_upgrade && !empty($previous_version)){
					//check if the upgrade path exists
					if(!empty($upgrade_manifest)){
						if(!empty($upgrade_manifest['upgrade_paths'])){
							if(!empty($upgrade_manifest['upgrade_paths'][$previous_version])){
								$installdefs = 	$upgrade_manifest['upgrade_paths'][$previous_version];
							}else{
								$errors[] = 'No Upgrade Path Found in manifest.';
								$this->abort($errors);
							}//fi
						}//fi
					}//fi
				}//fi
				$this->id_name = $installdefs['id'];
				$this->installdefs = $installdefs;
				$installed_modules = array();
				if(isset($installdefs['beans'])){
					$str = "<?php \n //WARNING: The contents of this file are auto-generated\n";
					foreach($installdefs['beans'] as $bean){
						if(!empty($bean['module']) && !empty($bean['class']) && !empty($bean['path'])){
							$module = $bean['module'];
							$class = $bean['class'];
							$path = $bean['path'];
							
							$str .= "\$beanList['$module'] = '$class';\n";
							$str .= "\$beanFiles['$class'] = '$path';\n";
							if($bean['tab']){
								$str .= "\$moduleList[] = '$module';\n";
								$this->install_user_prefs($module, empty($bean['hide_by_default']));	
								
							}else{
								$str .= "\$modInvisList[] = '$module';\n";	
							}
							$installed_modules[] = $module;
						}else{
							$errors[] = 'Bean array not well defined.';
							$this->abort($errors);
						}
					}
					$str.= "\n?>";
					if(!file_exists("custom/Extension/application/Ext/Include")){
						mkdir_recursive("custom/Extension/application/Ext/Include", true);
					}
					$out = fopen("custom/Extension/application/Ext/Include/$this->id_name.php", 'w');
					fwrite($out,$str);
					fclose($out);	
					$this->merge_files('Ext/Include', 'modules.ext.php', '', true);
				}	
				if(!$this->silent){
					$current_step++;
					update_progress_bar('install', $current_step, $total_steps);
				}
				
				foreach($tasks as $task){
					$this->$task();
					if(!$this->silent){
						$current_step++;
						update_progress_bar('install', $current_step, $total_steps);
					}	
				}
				$this->install_beans($installed_modules);
				if(!$this->silent){
					$current_step++;
					update_progress_bar('install', $total_steps, $total_steps);
				}
				if(isset($installdefs['custom_fields'])){
					$GLOBALS['log']->debug('Installing Custom Fields...');
					$this->install_custom_fields($installdefs['custom_fields']);
				}
				if(!$this->silent){
					$current_step++;
					update_progress_bar('install', $current_step, $total_steps);
					echo '</div>';
				}
				
				$this->post_execute();
				
				$GLOBALS['log']->debug('Complete');
		
		}else{
			die("No \$installdefs Defined In $this->base_dir/manifest.php");	
		}
		
	}
	
	function install_user_prefs($module, $hide_from_user=false){
		require_once('include/utils/user_utils.php');
		updateAllUserPrefs('display_tabs', $module, '', true, !$hide_from_user);
		updateAllUserPrefs('hide_tabs', $module, '', true, $hide_from_user);
		updateAllUserPrefs('remove_tabs', $module, '', true, $hide_from_user);	
	}
	function uninstall_user_prefs($module){
		require_once('include/utils/user_utils.php');
		updateAllUserPrefs('display_tabs', $module, '', true, true);
		updateAllUserPrefs('hide_tabs', $module, '', true, true);
		updateAllUserPrefs('remove_tabs', $module, '', true, true);	
	}
	function install_mkdirs(){
		if(isset($this->installdefs['mkdir'])){
				foreach($this->installdefs['mkdir'] as $mkdir){
					$mkdir['path'] = str_replace('<basepath>', $this->base_dir, $mkdir['path']);
					if(!mkdir_recursive($mkdir['path'], true)){
						die('Failed to make directory ' . $mkdir['path']);
					}	
				}
			}	
	}
	
	function pre_execute(){
		require_once($this->base_dir . '/manifest.php');
		if(isset($this->installdefs['pre_execute']) && is_array($this->installdefs['pre_execute'])){
			foreach($this->installdefs['pre_execute'] as $includefile){
				require_once(str_replace('<basepath>', $this->base_dir, $includefile));
			}
		}
	}
	
	function post_execute(){
		require_once($this->base_dir . '/manifest.php');
		if(isset($this->installdefs['post_execute']) && is_array($this->installdefs['post_execute'])){
			foreach($this->installdefs['post_execute'] as $includefile){
				require_once(str_replace('<basepath>', $this->base_dir, $includefile));
			}
		}
	}
	
	function pre_uninstall(){
		require_once($this->base_dir . '/manifest.php');
		if(isset($this->installdefs['pre_uninstall']) && is_array($this->installdefs['pre_uninstall'])){
			foreach($this->installdefs['pre_uninstall'] as $includefile){
				require_once(str_replace('<basepath>', $this->base_dir, $includefile));
			}
		}
	}
	
	function post_uninstall(){
		require_once($this->base_dir . '/manifest.php');
		if(isset($this->installdefs['post_uninstall']) && is_array($this->installdefs['post_uninstall'])){
			foreach($this->installdefs['post_uninstall'] as $includefile){
				require_once(str_replace('<basepath>', $this->base_dir, $includefile));
			}
		}
	}
	
	function uninstall_mkdirs(){
		if(isset($this->installdefs['mkdir'])){
					foreach($this->installdefs['mkdir'] as $mkdir){
						$mkdir['path'] = str_replace('<basepath>', $this->base_dir, $mkdir['path']);
						rmdir_recursive($mkdir['path']);
					}
		}	
	}
	/*
	 * Copies both directories and files from a loaction to a location
	 */
	function install_copy(){
		if(isset($this->installdefs['copy'])){
			/* BEGIN - RESTORE POINT - by MR. MILK August 31, 2005 02:22:11 PM */
			$backup_path = clean_path( remove_file_extension(urldecode($_REQUEST['install_file']))."-restore" );
			/* END - RESTORE POINT - by MR. MILK August 31, 2005 02:22:18 PM */
			foreach($this->installdefs['copy'] as $cp){
				$GLOBALS['log']->debug("Copying ..." . $cp['from'].  " to " .$cp['to'] );
				/* BEGIN - RESTORE POINT - by MR. MILK August 31, 2005 02:22:11 PM */
				//$this->copy_path($cp['from'], $cp['to']);
				$this->copy_path($cp['from'], $cp['to'], $backup_path);
				/* END - RESTORE POINT - by MR. MILK August 31, 2005 02:22:18 PM */
			}
		}	
	}
	function uninstall_copy(){
		if(isset($this->installdefs['copy'])){
					foreach($this->installdefs['copy'] as $cp){
						$cp['to'] = clean_path(str_replace('<basepath>', $this->base_dir, $cp['to']));
						$GLOBALS['log']->debug('Unlink ' . $cp['to']);
				/* BEGIN - RESTORE POINT - by MR. MILK August 31, 2005 02:22:11 PM */
						//rmdir_recursive($cp['to']);
						$backup_path = clean_path( remove_file_extension(urldecode($_REQUEST['install_file']))."-restore/".$cp['to'] );
						$this->copy_path($backup_path, $cp['to'], $backup_path, true);
				/* END - RESTORE POINT - by MR. MILK August 31, 2005 02:22:18 PM */
					}
					$backup_path = clean_path( remove_file_extension(urldecode($_REQUEST['install_file']))."-restore");
					if(file_exists($backup_path))
						rmdir_recursive($backup_path);
				}	
	}
	
	
	function install_dashlets(){
		if(isset($this->installdefs['dashlets'])){
			foreach($this->installdefs['dashlets'] as $cp){
				$cp['from'] = str_replace('<basepath>', $this->base_dir, $cp['from']);
				$path = 'custom/modules/Home/Dashlets/' . $cp['name'] . '/';
				$GLOBALS['log']->debug("Installing Dashlet " . $cp['name'] . "..." . $cp['from'] );
				if(!file_exists($path)){
					mkdir_recursive($path, true);
				}
				copy_recursive($cp['from'] , $path);
			}
			include('modules/Administration/RebuildDashlets.php');
			
		}	
	}
	
	function uninstall_dashlets(){
		if(isset($this->installdefs['dashlets'])){
					foreach($this->installdefs['dashlets'] as $cp){
						$path = 'custom/modules/Home/Dashlets/' . $cp['name'];
						$GLOBALS['log']->debug('Unlink ' .$path);
						rmdir_recursive($path);
					}
					include('modules/Administration/RebuildDashlets.php');
				}	
	}
	
	
	function install_images(){
		if(isset($this->installdefs['image_dir'])){
			$GLOBALS['log']->debug("Installing Images" );
			$this->copy_path($this->installdefs['image_dir'] , 'themes');
					
		}	
	}
	
	function install_menus(){
		if(isset($this->installdefs['menu'])){
					foreach($this->installdefs['menu'] as $menu){	
						$menu['from'] = str_replace('<basepath>', $this->base_dir, $menu['from']);
						$GLOBALS['log']->debug("Installing Menu ..." . $menu['from'].  " for " .$menu['to_module'] );
						$path = 'custom/Extension/modules/' . $menu['to_module']. '/Ext/Menus';
						if($menu['to_module'] == 'application'){
							$path ='custom/Extension/' . $menu['to_module']. '/Ext/Menus';
						}
						if(!file_exists($path)){
							mkdir_recursive($path, true);
							
						}
						copy_recursive($menu['from'] , $path . '/'. $this->id_name . '.php');
					}
					$this->rebuild_menus();
		}	
		
	}
	
	function uninstall_menus(){
		if(isset($this->installdefs['menu'])){
					foreach($this->installdefs['menu'] as $menu){	
						$menu['from'] = str_replace('<basepath>', $this->base_dir, $menu['from']);
						$GLOBALS['log']->debug("Uninstalling Menu ..." . $menu['from'].  " for " .$menu['to_module'] );
						$path = 'custom/Extension/modules/' . $menu['to_module']. '/Ext/Menus';
						if($menu['to_module'] == 'application'){
							$path ='custom/Extension/' . $menu['to_module']. '/Ext/Menus';
						}
						rmdir_recursive( $path . '/'. $this->id_name . '.php');
						
					}
					$this->rebuild_menus();
				}	
	}
	
	function install_administration(){
		if(isset($this->installdefs['administration'])){
					foreach($this->installdefs['administration'] as $administration){	
						$administration['from'] = str_replace('<basepath>', $this->base_dir, $administration['from']);
						$GLOBALS['log']->debug("Installing Administration Section ..." . $administration['from'] );
						$path = 'custom/Extension/modules/Administration/Ext/Administration';
						if(!file_exists($path)){
							mkdir_recursive($path, true);
							
						}
						copy_recursive($administration['from'] , $path . '/'. $this->id_name . '.php');
					}
					$this->rebuild_administration();
				}	
		
	}
	function uninstall_administration(){
			if(isset($this->installdefs['administration'])){
					foreach($this->installdefs['administration'] as $administration){	
						$administration['from'] = str_replace('<basepath>', $this->base_dir, $administration['from']);
						$GLOBALS['log']->debug("Uninstalling Administration Section ..." . $administration['from'] );
						$path = 'custom/Extension/modules/Administration/Ext/Administration';
						rmdir_recursive( $path . '/'. $this->id_name . '.php');
					}
					$this->rebuild_administration();
				}	
	}
	
	function install_userpage(){
		if(isset($this->installdefs['user_page'])){
					foreach($this->installdefs['user_page'] as $userpage){	
						$userpage['from'] = str_replace('<basepath>', $this->base_dir, $userpage['from']);
						$GLOBALS['log']->debug("Installing User Page Section ..." . $userpage['from'] );
						$path = 'custom/Extension/modules/Users/Ext/UserPage';
						if(!file_exists($path)){
							mkdir_recursive($path, true);
							
						}
						copy_recursive($userpage['from'] , $path . '/'. $this->id_name . '.php');
					}
					$this->rebuild_userpage();
				}	
		
	}
	function uninstall_userpage(){
			if(isset($this->installdefs['user_page'])){
					foreach($this->installdefs['user_page'] as $userpage){	
						$userpage['from'] = str_replace('<basepath>', $this->base_dir, $userpage['from']);
						$GLOBALS['log']->debug("Uninstalling User Page Section ..." . $userpage['from'] );
						$path = 'custom/Extension/modules/Users/Ext/UserPage';
						rmdir_recursive( $path . '/'. $this->id_name . '.php');
					}
					$this->rebuild_userpage();
				}	
	}
	
	/*
	 * handles the installation of vardefs
	 * 
	 */
	function install_vardefs(){
		if(isset($this->installdefs['vardefs'])){
			foreach($this->installdefs['vardefs'] as $vardefs){	
				$vardefs['from'] = str_replace('<basepath>', $this->base_dir, $vardefs['from']);
				$this->install_vardef($vardefs['from'], $vardefs['to_module'], $this->id_name);
			}
			$this->rebuild_vardefs();
		}	
	}
	function uninstall_vardefs(){
		if(isset($this->installdefs['vardefs'])){
					
					foreach($this->installdefs['vardefs'] as $vardefs){	
						$vardefs['from'] = str_replace('<basepath>', $this->base_dir, $vardefs['from']);
						$GLOBALS['log']->debug("Uninstalling Vardefs ..." . $vardefs['from'] .  " for " .$vardefs['to_module']);
						$path = 'custom/Extension/modules/' . $vardefs['to_module']. '/Ext/Vardefs';
						if($vardefs['to_module'] == 'application'){
							$path ='custom/Extension/' . $vardefs['to_module']. '/Ext/Vardefs';
						}
						
						rmdir_recursive( $path . '/'. $this->id_name . '.php');
					}
					$this->rebuild_vardefs();
				}	
	}
	function install_vardef($from, $to_module){
			$GLOBALS['log']->debug("Installing Vardefs ..." . $from .  " for " .$to_module);
			$path = 'custom/Extension/modules/' . $to_module. '/Ext/Vardefs';
			if($to_module == 'application'){
				$path ='custom/Extension/' . $to_module. '/Ext/Vardefs';
			}
			if(!file_exists($path)){
				mkdir_recursive($path, true);
			}
			copy_recursive($from , $path.'/'. $this->id_name . '.php');
	}
	function install_layoutdefs(){
		if(isset($this->installdefs['layoutdefs'])){
			foreach($this->installdefs['layoutdefs'] as $layoutdefs){	
				$layoutdefs['from'] = str_replace('<basepath>', $this->base_dir, $layoutdefs['from']);
				$this->install_layoutdef($layoutdefs['from'], $layoutdefs['to_module'], $this->id_name);
			}
			$this->rebuild_layoutdefs();	
		}
	}
	function uninstall_layoutdefs(){
		if(isset($this->installdefs['layoutdefs'])){
					
					foreach($this->installdefs['layoutdefs'] as $layoutdefs){	
						$layoutdefs['from'] = str_replace('<basepath>', $this->base_dir, $layoutdefs['from']);
						$GLOBALS['log']->debug("Uninstalling Layoutdefs ..." . $layoutdefs['from'] .  " for " .$layoutdefs['to_module']);
						$path = 'custom/Extension/modules/' . $layoutdefs['to_module']. '/Ext/Layoutdefs';
						if($layoutdefs['to_module'] == 'application'){
							$path ='custom/Extension/' . $layoutdefs['to_module']. '/Ext/Layoutdefs';
						}
						
						rmdir_recursive( $path . '/'. $this->id_name . '.php');
					}
					$this->rebuild_layoutdefs();
				}	
	}
	function install_layoutdef($from, $to_module){
			$GLOBALS['log']->debug("Installing Layout Defs ..." . $from .  " for " .$to_module);
			$path = 'custom/Extension/modules/' . $to_module. '/Ext/Layoutdefs';
			if($to_module == 'application'){
				$path ='custom/Extension/' . $to_module. '/Ext/Layoutdefs';
			}
			if(!file_exists($path)){
				mkdir_recursive($path, true);
			}
			copy_recursive($from , $path.'/'. $this->id_name . '.php');
	}
	
	function install_languages(){
		$languages = array();
				if(isset($this->installdefs['language'])){
					foreach($this->installdefs['language'] as $packs){	
						$languages[$packs['language']] = $packs['language'];
						$packs['from'] = str_replace('<basepath>', $this->base_dir, $packs['from']);
						$GLOBALS['log']->debug("Installing Language Pack ..." . $packs['from']  .  " for " .$packs['to_module']);
						$path = 'custom/Extension/modules/' . $packs['to_module']. '/Ext/Language';
						if($packs['to_module'] == 'application'){
							$path ='custom/Extension/' . $packs['to_module']. '/Ext/Language';
						}
							
						if(!file_exists($path)){
							mkdir_recursive($path, true);
							
						}
						copy_recursive($packs['from'] , $path.'/'.$packs['language'].'.'. $this->id_name . '.php');
					}
					$this->rebuild_languages($languages);
					
				}	
	}
	
	function uninstall_languages(){
		$languages = array();
				if(isset($this->installdefs['language'])){
					foreach($this->installdefs['language'] as $packs){	
						$languages[] = $packs['language'];
						$packs['from'] = str_replace('<basepath>', $this->base_dir, $packs['from']);
						$GLOBALS['log']->debug("Uninstalling Language Pack ..." . $packs['from']  .  " for " .$packs['to_module']);
						$path = 'custom/Extension/modules/' . $packs['to_module']. '/Ext/Language';
						if($packs['to_module'] == 'application'){
							$path ='custom/Extension/' . $packs['to_module']. '/Ext/Language';
						}
							
						rmdir_recursive( $path.'/'.$packs['language'].'.'. $this->id_name . '.php');
						
					}
					$this->rebuild_languages($languages);
					
				}	
	}
	
/* BEGIN - RESTORE POINT - by MR. MILK August 31, 2005 02:22:18 PM */
	function copy_path($from, $to, $backup_path='', $uninstall=false){
	//function copy_path($from, $to){
/* END - RESTORE POINT - by MR. MILK August 31, 2005 02:22:18 PM */
		$to = str_replace('<basepath>', $this->base_dir, $to);

		if(!$uninstall) {
		$from = str_replace('<basepath>', $this->base_dir, $from);
		$GLOBALS['log']->debug('Copy ' . $from);
		}
		else {
			$from = str_replace('<basepath>', $backup_path, $from);
			//$GLOBALS['log']->debug('Restore ' . $from);
		}
		$from = clean_path($from);
		$to = clean_path($to);

		$dir = dirname($to);
		if(!file_exists($dir))
			mkdir_recursive($dir, true);
/* BEGIN - RESTORE POINT - by MR. MILK August 31, 2005 02:22:18 PM */
		if(empty($backup_path)) {
/* END - RESTORE POINT - by MR. MILK August 31, 2005 02:22:18 PM */
		if(!copy_recursive($from, $to)){
			die('Failed to copy ' . $from. ' ' . $to);
		}	
/* BEGIN - RESTORE POINT - by MR. MILK August 31, 2005 02:22:18 PM */
		}
		elseif(!$this->copy_recursive_with_backup($from, $to, $backup_path, $uninstall)){
			die('Failed to copy ' . $from. ' ' . $to);
		}
/* END - RESTORE POINT - by MR. MILK August 31, 2005 02:22:18 PM */
	}	
	
	function install_custom_fields($fields){
		global $beanList, $beanFiles;
		include('include/modules.php');
		foreach($fields as $field){
			$installed = false;
			if(isset($beanList[ $field['module']])){
				$class = $beanList[ $field['module']];
                if(!isset($field['ext4']))$field['ext4'] = '';
                if(!isset($field['mass_update']))$field['mass_update'] = 0;
                if(!isset($field['duplicate_merge']))$field['duplicate_merge'] = 0;
                if(!isset($field['help']))$field['help'] = '';

				if(file_exists($beanFiles[$class])){
					require_once($beanFiles[$class]);
					$mod = new $class();
					$installed = true;
					$mod->custom_fields->addField($field['name'], $field['label'], $field['type'], $field['max_size'], $field['require_option'], $field['default_value'], $field['ext1'], $field['ext2'], $field['ext3'], $field['audited'], $field['mass_update'],$field['ext4'], $field['help'], $field['duplicate_merge']);
				}
				}
				if(!$installed){
					$GLOBALS['log']->debug('Could not install custom field ' . $field['name'] . ' for module ' .  $field['module'] . ': Module does not exist');	
				}
		}	
	}
	
	function uninstall_custom_fields($fields){
		global $beanList, $beanFiles;
		require_once('modules/DynamicFields/DynamicField.php');
		$dyField = new DynamicField();

		foreach($fields as $field){
			$class = $beanList[ $field['module']];
			if(file_exists($beanFiles[$class])){
					require_once($beanFiles[$class]);
					$mod = new $class();
					$dyField->bean = $mod;
					$dyField->module = $field['module'];
					$dyField->dropField($field['name']);
			}
		}	
	}
		
	function install_relationships(){
	if(isset($this->installdefs['relationships'])){
			$str = "<?php \n //WARNING: The contents of this file are auto-generated\n";
			$save_table_dictionary = false;
			foreach($this->installdefs['relationships'] as $relationship){
						
						$filename	=basename($relationship['meta_data']);
						$this->copy_path($relationship['meta_data'], 'metadata/'. $filename);
						$this->install_relationship('metadata/'. $filename);
						$save_table_dictionary  = true;
						$str .= "include_once('metadata/$filename');\n";
						if(!empty($relationship['module_vardefs'])){
							$relationship['module_vardefs'] = str_replace('<basepath>', $this->base_dir, $relationship['module_vardefs']);
							$this->install_vardef($relationship['module_vardefs'], $relationship['module']);	
						}
						if(!empty($relationship['module_layoutdefs'])){
							$relationship['module_layoutdefs'] = str_replace('<basepath>', $this->base_dir, $relationship['module_layoutdefs']);
							$this->install_layoutdef($relationship['module_layoutdefs'], $relationship['module']);
						}
					}
				$this->rebuild_vardefs();
				$this->rebuild_layoutdefs();
				if($save_table_dictionary){
					if(!file_exists("custom/Extension/application/Ext/TableDictionary")){
						mkdir_recursive("custom/Extension/application/Ext/TableDictionary", true);
					}
					$out = fopen("custom/Extension/application/Ext/TableDictionary/$this->id_name.php", 'w');
					fwrite($out,$str . "\n?>");
					fclose($out);	
					$this->rebuild_tabledictionary();
				}
					
					
			}
	}
	function install_relationship($file){
		
		if(!file_exists($file)){
			$GLOBALS['log']->debug( 'File does not exists : '.$file);
			return;
		}
		include_once($file);
		$rel_dictionary = $dictionary;
		 foreach ($rel_dictionary as $rel_name => $rel_data)
   	{  
		$table = $rel_data['table'];

     

      if(!$this->db->tableExists($table))
      {
      	$this->db->createTableParams($table, $rel_data['fields'], $rel_data['indices']);
      }
     
	if(!$this->silent)$GLOBALS['log']->debug("Processing relationship meta for ". $rel_name."...");
	  SugarBean::createRelationshipMeta($rel_name, $this->db,$table,$rel_dictionary,'');
	Relationship::delete_cache();
	 if(!$this->silent) $GLOBALS['log']->debug( 'done<br>');			
      

   }
	}
	
	function uninstall_relationship($file){
		if(!file_exists($file)){
			$GLOBALS['log']->debug( 'File does not exists : '.$file);
			return;
		}
			
		include_once($file);
		$rel_dictionary = $dictionary;
		foreach ($rel_dictionary as $rel_name => $rel_data)
   		{  
            if (isset($rel_data['table'])){
			    $table = $rel_data['table'];
            }
            else{
                $table = ' One-to-Many ';
            }
     	
        	if ($this->db->tableExists($table))
         	{
         	    SugarBean::removeRelationshipMeta($rel_name, $this->db,$table,$rel_dictionary,'');
         		$this->db->dropTableName($table);
         		if(!$this->silent) $GLOBALS['log']->debug( 'droping table ' . $table);
         	}
        }
        Relationship::delete_cache();
	}

	function uninstall_relationships(){
		if(isset($this->installdefs['relationships'])){
					foreach($this->installdefs['relationships'] as $relationship){
						$filename	=basename($relationship['meta_data']);
						if(isset($GLOBALS['mi_remove_tables']) && $GLOBALS['mi_remove_tables'])
							$this->uninstall_relationship('metadata/'. $filename);
						unlink( 'metadata/'. $filename);
						//remove the vardefs
						$path = 'custom/Extension/modules/' . $relationship['module']. '/Ext/Vardefs';
						if($relationship['module'] == 'application'){
							$path ='custom/Extension/' . $relationship['module']. '/Ext/Vardefs';
						}
						if(!empty($relationship['module_vardefs']) && file_exists($path . '/'. $this->id_name . '.php'))
							rmdir_recursive( $path . '/'. $this->id_name . '.php');
						//remove the layoutdefs
						$path = 'custom/Extension/modules/' . $relationship['module']. '/Ext/Layoutdefs';
						if($relationship['module'] == 'application'){
							$path ='custom/Extension/' . $relationship['module']. '/Ext/Layoutdefs';
						}
						
						if(!empty($relationship['module_layoutdefs']) && file_exists($path . '/'. $this->id_name . '.php'))
							rmdir_recursive( $path . '/'. $this->id_name . '.php');
					}
					if(file_exists("custom/Extension/application/Ext/TableDictionary/$this->id_name.php")){
						unlink("custom/Extension/application/Ext/TableDictionary/$this->id_name.php");	
					}
					$this->rebuild_tabledictionary();
					$this->rebuild_vardefs();
					$this->rebuild_layoutdefs();
				}	
	}
		
	
	
	
	function uninstall($base_dir){
		global $app_strings;
		$total_steps = 4; //min steps with no tasks
		$current_step = 0;
		$this->base_dir = $base_dir;
		$tasks = array(
							'pre_uninstall',
							'uninstall_mkdirs',
							'uninstall_copy',
							'uninstall_menus',
							'uninstall_dashlets',
							'uninstall_userpage',
							'uninstall_administration',
							'uninstall_vardefs',
							'uninstall_layoutdefs',
							'uninstall_relationships',
							'uninstall_languages',
							);
		$total_steps += count($tasks); //now the real number of steps
		if(file_exists($this->base_dir . '/manifest.php')){
				if(!$this->silent){
					$current_step++;
					display_progress_bar('install', $current_step, $total_steps);
					echo '<div id ="displayLoglink" ><a href="#" onclick="toggleDisplay(\'displayLog\')">'.$app_strings['LBL_DISPLAY_LOG'].'</a> </div><div id="displayLog" style="display:none">';
				}
					
				require_once($this->base_dir . '/manifest.php');
				$this->installdefs = $installdefs;
				$this->id_name = $this->installdefs['id'];
				$installed_modules = array();
				if(isset($this->installdefs['beans'])){
					
					foreach($this->installdefs['beans'] as $bean){
	
						$installed_modules[] = $bean['module'];
						$this->uninstall_user_prefs($bean['module']);	
						
						
					}

					$this->uninstall_beans($installed_modules);
					if(!$this->silent){
						$current_step++;
						update_progress_bar('install', $total_steps, $total_steps);
					}
					rmdir_recursive("custom/Extension/application/Ext/Include/$this->id_name.php");
					$this->merge_files('Ext/Include', 'modules.ext.php', '', true);					
				}	
				if(!$this->silent){
					$current_step++;
					update_progress_bar('install', $current_step, $total_steps);
				}
				
				
				foreach($tasks as $task){
					$this->$task();
					if(!$this->silent){
						$current_step++;
						update_progress_bar('install', $current_step, $total_steps);
					}	
				}
				if(isset($installdefs['custom_fields']) && (isset($GLOBALS['mi_remove_tables']) && $GLOBALS['mi_remove_tables'])){
					$GLOBALS['log']->debug('Uninstalling Custom Fields...');
					$this->uninstall_custom_fields($installdefs['custom_fields']);
				}
				if(!$this->silent){
					$current_step++;
					update_progress_bar('install', $current_step, $total_steps);
					echo '</div>';
				}

				$this->post_uninstall();
				
				$GLOBALS['log']->debug('Complete');
				update_progress_bar('install', $total_steps, $total_steps);
		}else{
			die("No manifest.php Defined In $this->base_dir/manifest.php");	
		}
	}
	
	
	function rebuild_languages($languages){
			foreach($languages as $language=>$value){
				$GLOBALS['log']->debug("Rebuilding Language...$language");
				$this->merge_files('Ext/Language/', $language.'.lang.ext.php', $language);
			}
			sugar_cache_reset();
	}
	
	function rebuild_vardefs(){
			$GLOBALS['log']->debug("Rebuilding Vardefs...");
			$this->merge_files('Ext/Vardefs/', 'vardefs.ext.php');
			sugar_cache_reset();	
	}
	function rebuild_layoutdefs(){
			$GLOBALS['log']->debug("Rebuilding Layoutdefs...");
			$this->merge_files('Ext/Layoutdefs/', 'layoutdefs.ext.php');
			
	}
	
	function rebuild_menus(){
			$GLOBALS['log']->debug("Rebuilding Menus...");
			$this->merge_files('Ext/Menus/', 'menu.ext.php');
	}
	
	
	function rebuild_administration(){
			$GLOBALS['log']->debug("Rebuilding administration Section...");
			$this->merge_files('Ext/Administration/', 'administration.ext.php');
	}
	function rebuild_userpage(){
			$GLOBALS['log']->debug("Rebuilding User Page Section...");
			$this->merge_files('Ext/UserPage/', 'userpage.ext.php');
	}
	function rebuild_tabledictionary(){
			$GLOBALS['log']->debug("Rebuilding administration Section...");
			$this->merge_files('Ext/TableDictionary/', 'tabledictionary.ext.php');
	}
	
	function rebuild_relationships() {
		global $beanFiles;
		
		include('include/modules.php'); // get this locally
		include('sugar_version.php'); // for versions table at end
		require_once('data/SugarBean.php');
		
		$GLOBALS['log']->debug("Rebuilding administration Section...");
		
		$query = "DELETE from relationships";
		$this->db->query($query);
		
		foreach($beanFiles as $bean => $file){
			if(strlen($file) > 0 && file_exists($file)) {
				if (!class_exists($bean)) {
					require($file);
				}
				$focus = new $bean();
			    $table_name = $focus->table_name;
				$empty = '';	
			    SugarBean::createRelationshipMeta($focus->getObjectName(), $this->db, $table_name, $empty, $focus->module_dir);
			}
		}
		
		foreach($beanFiles as $bean => $file){
		    if(!class_exists($bean)) {
		        require($file);
		    }
		    
		    $focus = new $bean();
		    $table_name = $focus->table_name;
		    $empty = '';   
		    SugarBean::createRelationshipMeta($focus->getObjectName(), $this->db, $table_name, $empty, $focus->module_dir, true);
		}
		
		$dictionary = array();
		include('modules/TableDictionary.php'); // fills-in $dictionary
		$rel_dictionary = $dictionary;
		foreach($rel_dictionary as $rel_name => $rel_data){  
			$table = $rel_data['table'];
		    SugarBean::createRelationshipMeta($rel_name, $this->db, $table, $rel_dictionary, '');
		}
		
		//clean relationship cache..will be rebuilt upon first access.
		Relationship::delete_cache();
		
		// clear the database row if it exists (just to be sure)
		$query = "DELETE FROM versions WHERE name='Rebuild Relationships'";
		$GLOBALS['log']->info($query);
		$this->db->query($query);
		
		// insert a new database row to show the rebuild relationships is done
		$id = create_guid();
		$gmdate = gmdate('Y-m-d H:i:s');
		$date_entered = db_convert("'$gmdate'", 'datetime');
		$query = "INSERT INTO versions (id, deleted, date_entered, date_modified, modified_user_id, created_by, name, file_version, db_version) VALUES ('{$id}', '0', {$date_entered}, {$date_entered}, '1', '1', 'Rebuild Relationships', '{$sugar_version}', '{$sugar_db_version}')"; 
		$GLOBALS['log']->info($query);
		$this->db->query($query);
		
		// unset the session variable so it is not picked up in DisplayWarnings.php
		if(isset($_SESSION['rebuild_relationships'])) {
		    unset($_SESSION['rebuild_relationships']);
		}
	}
	
	/**
	 * Wrapper call to modules/Administration/RepairIndex.php
	 */
	function repair_indices() {
		global $current_user,$beanFiles,$dictionary;

		$silent = true; // local var flagging echo'd output in repair script
		$_REQUEST['mode'] = 'execute'; // flag to just go ahead and run the script
		include("modules/Administration/RepairIndex.php");
	}

	function rebuild_all(){
		global $sugar_config;
		
		$this->rebuild_languages($sugar_config['languages']);
		$this->rebuild_vardefs();
		$this->rebuild_layoutdefs();
		$this->rebuild_menus();
		$this->rebuild_userpage();
		$this->rebuild_administration();
		$this->rebuild_relationships();
		$this->repair_indices();
		sugar_cache_reset();	
	}
	
	function merge_files($path, $name, $filter = '', $application = false){
		if(!$application){
		$GLOBALS['log']->debug("Merging module files for $name in $path");
		foreach($this->modules as $module){
				$extension = "<?php \n //WARNING: The contents of this file are auto-generated\n";
				$extpath = "modules/$module/$path";
				$module_install  = 'custom/Extension/'.$extpath;
				$shouldSave = false;
				if(is_dir($module_install)){
					$dir = dir($module_install);
					$shouldSave = true;
					while($entry = $dir->read()){
							if((empty($filter) || substr_count($entry, $filter) > 0) && is_file($module_install.'/'.$entry) && $entry != '.' && $entry != '..'){
								$fp = fopen($module_install . '/' . $entry, 'r');
								$file = fread($fp , filesize($module_install . '/' . $entry));
								fclose($fp);
								$extension .= "\n". str_replace(array('<?php', '?>', '<?PHP', '<?'), array('','', '' ,'') , $file);
							}
					}	
				}
				$extension .= "\n?>";
				
				if($shouldSave){
					if(!file_exists("custom/$extpath")){
					mkdir_recursive("custom/$extpath", true);
				}
					$out = fopen("custom/$extpath/$name", 'w');
					fwrite($out,$extension);
					fclose($out);	
				}else{
					if(file_exists("custom/$extpath/$name")){
						unlink("custom/$extpath/$name");	
					}
				}
			}
				
		}

		$GLOBALS['log']->debug("Merging application files for $name in $path");
		//Now the application stuff
		$extension = "<?php \n //WARNING: The contents of this file are auto-generated\n";
		$extpath = "application/$path";
		$module_install  = 'custom/Extension/'.$extpath;
		$shouldSave = false;
					if(is_dir($module_install)){
						$dir = dir($module_install);
						while($entry = $dir->read()){
								$shouldSave = true;
								if((empty($filter) || substr_count($entry, $filter) > 0) && is_file($module_install.'/'.$entry) && $entry != '.' && $entry != '..'){
									$fp = fopen($module_install . '/' . $entry, 'r');
									$file = fread($fp , filesize($module_install . '/' . $entry));
									fclose($fp);
									$extension .= "\n". str_replace(array('<?php', '?>', '<?PHP', '<?'), array('','', '' ,'') , $file);
								}
						}	
					}
					$extension .= "\n?>";
					if($shouldSave){
						if(!file_exists("custom/$extpath")){
							mkdir_recursive("custom/$extpath", true);
						}
						$out = fopen("custom/$extpath/$name", 'w');
						fwrite($out,$extension);
						fclose($out);	
					}else{
					if(file_exists("custom/$extpath/$name")){
						unlink("custom/$extpath/$name");	
					}
				}
				
}

	function install_beans($beans){
		include('include/modules.php');
		foreach($beans as $bean){
			$GLOBALS['log']->debug( "Installing Bean : $bean");
			if(isset($beanList[$bean])){
				$class = $beanList[$bean];
				if(file_exists($beanFiles[$class])){
					require_once($beanFiles[$class]);
					$mod = new $class();
					if(is_subclass_of($mod, 'SugarBean')){
						$GLOBALS['log']->debug( "Creating Tables Bean : $bean");
						$mod->create_tables();	
						SugarBean::createRelationshipMeta($mod->getObjectName(), $mod->db,$mod->table_name,'',$mod->module_dir);
					}
				}else{
					$GLOBALS['log']->debug( "File Does Not Exist:" . $beanFiles[$class] );	
				}
			}	
		}	
	}
	
		function uninstall_beans($beans){
		include('include/modules.php');
		foreach($beans as $bean){
			$GLOBALS['log']->debug( "Uninstalling Bean : $bean");
			if(isset($beanList[$bean])){
				$class = $beanList[$bean];
				
				if(file_exists($beanFiles[$class])){
					require_once($beanFiles[$class]);
					$mod = new $class();
					
					if(is_subclass_of($mod, 'SugarBean')){
						$GLOBALS['log']->debug( "Drop Tables : $bean");
						if(isset($GLOBALS['mi_remove_tables']) && $GLOBALS['mi_remove_tables'])
							$mod->drop_tables();	
					}
				}else{
					$GLOBALS['log']->debug( "File Does Not Exist:" . $beanFiles[$class] );	
				}
			}	
		}	
	}
	
	function log($str){
		$GLOBALS['log'] .= $str . "\n";
		if(!$this->silent){
			echo $str . '<br>';	
		}
	}

/* BEGIN - RESTORE POINT - by MR. MILK August 31, 2005 02:15:18 PM 	*/
function copy_recursive_with_backup( $source, $dest, $backup_path, $uninstall=false ) {





	if(is_file($source)) {
	    if($uninstall) {
		    $GLOBALS['log']->debug("Restoring ... " . $source.  " to " .$dest );
		    if(copy( $source, $dest)) {
			    if(is_writable($dest))
					touch( $dest, filemtime($source) );
		    	return(unlink($source));
	    	}
		    else {
		    	$GLOBALS['log']->debug( "Can't restore file: " . $source );
		    	return true;
	    	}
	    }
	    else {
			if(file_exists($dest)) {
				$rest = clean_path($backup_path."/$dest");
				if( !is_dir(dirname($rest)) )
					mkdir_recursive(dirname($rest), true);

				$GLOBALS['log']->debug("Backup ... " . $dest.  " to " .$rest );
				if(copy( $dest, $rest)) {
					if(is_writable($rest))
						touch( $rest, filemtime($dest) );
				}
				else {
					$GLOBALS['log']->debug( "Can't backup file: " . $dest );
				}
			}
			return( copy( $source, $dest ) );
		}
    }
    elseif(!is_dir($source)) {
	    if($uninstall) {
			if(is_file($dest))
				return(unlink($dest));
			else {
				rmdir_recursive($dest);
				return true;
			}
		}
		else
			return false;
	}

    if( !is_dir($dest) && !$uninstall){
        mkdir( $dest );
    }

    $status = true;

    $d = dir( $source );
    while( $f = $d->read() ){
        if( $f == "." || $f == ".." ){
            continue;
        }
        $status &= $this->copy_recursive_with_backup( "$source/$f", "$dest/$f", $backup_path, $uninstall );
    }
    $d->close();
    return( $status );
}
/* END - RESTORE POINT - by MR. MILK August 31, 2005 02:15:34 PM */

	
	/**
	 * Static function which allows a module developer to abort their progress, pass in an array of errors and 
	 * redirect back to the main module loader page
	 * 
	 * @param errors	an array of error messages which will be displayed on the 
	 * 					main module loader page once it is loaded.
	 */
	function abort($errors = array()){
		//set the errors onto the session so we can display them one the moduler loader page loads
		$_SESSION['MODULEINSTALLER_ERRORS'] = $errors;
		echo '<META HTTP-EQUIV="Refresh" content="0;url=index.php?module=Administration&action=UpgradeWizard&view=module">';
		die();
		//header('Location: index.php?module=Administration&action=UpgradeWizard&view=module');
	}
	
	/**
	 * Return the set of errors stored in the SESSION
	 * 
	 * @return an array of errors
	 */
	function getErrors(){
		if(!empty($_SESSION['MODULEINSTALLER_ERRORS'])){
			$errors = $_SESSION['MODULEINSTALLER_ERRORS'];
			unset($_SESSION['MODULEINSTALLER_ERRORS']);
			return $errors;
		}
		else
			return null;	
	}
}
?>
