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
/*********************************************************************************

 * Description:
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
 * Reserved. Contributor(s): contact@synolia.com - www.synolia.com
 * *******************************************************************************/

$mod_strings = array (










































	
  'DEFAULT_CHARSET' => 'UTF-8',
  'ERR_ADMIN_PASS_BLANK' => 'Le mot de passe admin de SugarCRM ne peut pas �tre vide.',
  'ERR_CHECKSYS_CALL_TIME' => 'La fonction \'Allow Call Time Pass Reference\' est � Off (veuillez l\'activer dans le php.ini)',
  'ERR_CHECKSYS_CURL' => 'iNTROUVABLE: Le planificateur Sugar fonctionnera avec des fonctionnalit�s limit�es.',
  'ERR_CHECKSYS_IMAP' => 'iNTROUVABLE: Les mails entrants et les comapgnes (Email) n�cessaite la librairie IMAP dans PHP. Aucun des 2 ne pourra fonctionner.',
  'ERR_CHECKSYS_MSSQL_MQGPC' => 'La fonction Magic Quotes GPC ne peut pas �tre mise � "On" lorsque vous utilisez MSSQL SERVER.',
  'ERR_CHECKSYS_MBSTRING' => "iNTROUVABLE: SugarCRM ne pourra pas utiliser les jeux de caract�res multibytes. Cela affectera la r�ception d'emails dans des jeux de caract�res diff�rents de UTF-8.",
  'ERR_CHECKSYS_MEM_LIMIT_1' => 'ATTENTION: $memory_limit (Mettre ',
  'ERR_CHECKSYS_MEM_LIMIT_2' => 'M ou plus dans votre fichier php.ini)',
  'ERR_CHECKSYS_MYSQL_VERSION' => 'Version Minimum 4.1.2 - Trouv�e: ',
  'ERR_CHECKSYS_NO_SESSIONS' => 'Impossible d\'�crire ou lire les param�tres de session. Impossible de continuer l\'installation.',
  'ERR_CHECKSYS_NOT_VALID_DIR' => 'R�pertoire Invalide',
  'ERR_CHECKSYS_NOT_WRITABLE' => 'ATTENTION: Impossible d\'�crire',
  'ERR_CHECKSYS_PHP_INVALID_VER' => 'Version de PHP install�e Invalide: ( ver',
  'ERR_CHECKSYS_PHP_UNSUPPORTED' => 'Version de PHP install�e non support�e: ( ver',
  'ERR_CHECKSYS_SAFE_MODE' => 'Safe Mode est activ� (veuillez le d�sactiv� dans le fichier php.ini)',
  'ERR_CHECKSYS_ZLIB' => 'iNTROUVABLE: SugarCRM peut gagner beaucoup en performance avec la compression zlib activ�e.',
  'ERR_DB_ADMIN' => 'Le login ou le mot de passe de l\'administrateur de la base de donn�es est invalide (ERREUR ',
  'ERR_DB_EXISTS_NOT' => 'La base de donn�es sp�cifi�e n\'existe pas.',
  'ERR_DB_EXISTS_WITH_CONFIG' => 'La base de donn�es contient d�j� des donn�es de configuration. Pour lancer une installation avec la base de donn�es s�lectionn�es, veuillez relancer l\'installation et s�lectionnez :"Effacer et recr�er les tables existantes de SugarCRM ?" Pour mettre � jour, utilisez l\'assistant de mise � jour dans la console d\'administration.  Veullez lire la documentation de mise � jour situ�e  <a href="http://www.sugarforge.org/content/downloads/" target="_new">ici</a>.',
  'ERR_DB_EXISTS' => 'Une base de donn�es avec le m�me nom existe d�j�--Impossible d\'en cr�er une autre avec le m�me nom.',
  'ERR_DB_HOSTNAME' => 'Le nom de l\'hote (Hostname) ne peut pas �tre vide.',
  'ERR_DB_INVALID' => 'LE type de base de donn�es s�lectionn�e est invalide.',
  'ERR_DB_LOGIN_FAILURE_MYSQL' => 'Le login ou le mot de passe de l\'utilisateur de SugarCRM est invalide (ERREUR ',
  'ERR_DB_LOGIN_FAILURE_MSSQL' => 'Le login ou le mot de passe de la base de donn�es SugarCRM est invalide.',
  'ERR_DB_MYSQL_VERSION1' => 'Version de MySQL ',
  'ERR_DB_MYSQL_VERSION2' => ' n\'est pas support�. Seule la verion 4.1.x et plus de MySQL est support�e.',
  'ERR_DB_NAME' => 'Le nom de la base de donn�es ne peut pas �tre vide.',
  'ERR_DB_NAME2' => 'Le nom de la base de donn�es ne peut pas contenir les caract�res \'\\\', \'/\', ou \'.\'',
  'ERR_DB_PASSWORD' => 'Les mots de passe pour SugarCRM ne correspondent pas.',
  'ERR_DB_PRIV_USER' => 'L\'identifiant Admin de la base de donn�es est n�cessaire.',
  'ERR_DB_USER_EXISTS' => 'L\'utilisateur pour SugarCRM existe d�j�--Impossibe d\'en cr�er un second avec le m�me identifiant.',
  'ERR_DB_USER' => 'L\'identifiant pour SugarCRM ne peut pas �tre vide.',
  'ERR_DBCONF_VALIDATION' => 'Veuillez corriger les erreurs suivantes avant de continuer:',
  'ERR_ERROR_GENERAL' => 'Les erreurs suivantes ont �t� rencontr�es:',
  'ERR_LANG_CANNOT_DELETE_FILE' => 'Impossible d\'effacer le fichier: ',
  'ERR_LANG_MISSING_FILE' => 'Impossible de trouver le fichier: ',
  'ERR_LANG_NO_LANG_FILE' => 'Pas de pack de langue trouv� dans include/language � l\'int�rieur de : ',
  'ERR_LANG_UPLOAD_1' => 'Un probl�me a �t� rencontr� avec votre upload. Veuillez r�essayer.',
  'ERR_LANG_UPLOAD_2' => 'PHP n\'a pas pu d�placer le fichier temporaire vers le r�pertoire de mises � jour.',
  'ERR_LANG_UPLOAD_3' => 'PHP n\'a pas pu d�placer le fichier temporaire vers le r�pertoire d\'upgrade.',
  'ERR_LICENSE_MISSING' => 'Les champs requis ne sont pas tous renseign�s',
  'ERR_LICENSE_NOT_FOUND' => 'Fichier de licence introuvable!',
  'ERR_LOG_DIRECTORY_NOT_EXISTS' => 'Le r�pertoire de Logs d�finis n\'est pas valide.',
  'ERR_LOG_DIRECTORY_NOT_WRITABLE' => 'Impossible d\'�crire dans le r�pertoire de Logs d�fini.',
  'ERR_LOG_DIRECTORY_REQUIRED' => 'Un r�pertoire de Logs est obligatoire si vous voulez sp�cifier votre propre r�pertoire.',
  'ERR_NO_DIRECT_SCRIPT' => 'Impossible d\'ex�cuter le script directement.',
  'ERR_PASSWORD_MISMATCH' => 'Les mots de passe pour SugarCRM Admin ne correspondent pas.',
  'ERR_PERFORM_CONFIG_PHP_1' => 'Impossible d\'�crire dans le fichier <span class=stop>config.php</span>.',
  'ERR_PERFORM_CONFIG_PHP_2' => 'Vous pouvez continuer cette installation en cr�ant manuellement le fichier config.php et en collant les informations de configuration ci dessous dans le fichier. Cependant vous <strong>devez </strong> cr�er le fichier config.php avant de proc�der � l\'�tape suivante.',
  'ERR_PERFORM_CONFIG_PHP_3' => 'Avez vous cr�� le fichier config.php?',
  'ERR_PERFORM_CONFIG_PHP_4' => 'ATTENTION: Impossible d\'�crire dans le fichier config.php.  Veuillez vous assurer qu\'il existe.',
  'ERR_PERFORM_HTACCESS_1' => 'Impossible d\'�crire dans le fichier ',
  'ERR_PERFORM_HTACCESS_2' => ' .',
  'ERR_PERFORM_HTACCESS_3' => 'Si vous voulez s�curiser votre fichier de Logs d\'un acc�s par un navigateur, cr�ez un fichier .htaccess dans le r�pertoire de Logs avec cette ligne:',
  'ERR_PERFORM_NO_TCPIP' => '<b>Nous n\'avons pas d�tecter de connexion internet.</b> D�s vous en avez une, veuillez vous rendre sur  <a href=\\"http://www.sugarcrm.com/home/index.php?option=com_extended_registration&task=register\\">http://www.sugarcrm.com/home/index.php?option=com_extended_registration&task=register</a> pour vous enregistrer aup�s de SugarCRM.En nous laissant savoir comment votre soci�t� compte utilisr SugarCRM, nous pouvons vous garantir de vous fournir toujours la bonne application pour vos besoins de business.',
  'ERR_SESSION_DIRECTORY_NOT_EXISTS' => '>Le r�pertoire de session d�fini n\'est pas un r�pertoire valide.',
  'ERR_SESSION_DIRECTORY' => 'Impossible d\'�crire dans le r�pertoire de session d�fini.',
  'ERR_SESSION_PATH' => 'Un r�pertoire de session est n�cessaire si vous voulez d�finir votre propre r�pertoire.',
  'ERR_SI_NO_CONFIG' => 'Vous n\'avez pas inclus de fichier config_si.php dans la racine ou vou n\'avez pas sp�cifi� de $sugar_config_si dans le fichier config.php',
  'ERR_SITE_GUID' => 'ID d\'Application n�cessaire si vous voulez sp�cifier votre propre application.',
  'ERR_UPLOAD_MAX_FILESIZE' => "ATTENTION: Votre configuration de PHP doit �tre modifi�e pour autoriser les fichiers d'au moins 6MB a �tre t�l�charg�s.",
  'ERR_URL_BLANK' => 'URL ne peut pas �tre vide.',
  'ERROR_FLAVOR_INCOMPATIBLE' => 'Le fichier upload� n\'est pas compatible avec cette note (Open Source, Professional, ou Enterprise) de Sugar Suite: ',
  'ERROR_LICENSE_EXPIRED' => 'ERREUR: Votre licenc� a expir�e il y a ',
  'ERROR_LICENSE_EXPIRED2' => ' jour(s). Veuillez vous rendre dans <a href=\'index.php?action=LicenseSettings&module=Administration\'>\'"Gestion de licences "</a>  dans l\\\'�cran d\\\'Admin pour renseigner votre nouvelle cl�.  Si vous sp�cifizer pas de nouvelle cl� dans les 30 jours suivnat l\\\'expiration de votre cl�, vous ne pourrez plus vous connecter � l\\\'application .',
  'ERROR_MANIFEST_TYPE' => 'Le fichier Manifest doit sp�cifier un type de package.',
  'ERROR_PACKAGE_TYPE' => 'Le fichier Manifest sp�cifie un type de package non reconnu',
  'ERROR_VALIDATION_EXPIRED' => 'ERREUR: Votre licenc� a expir�e il y a  ',
  'ERROR_VALIDATION_EXPIRED2' => ' jour(s.   Veuillez vous rendre dans <a href=\'index.php?action=LicenseSettings&module=Administration\'>\'"Gestion de licences"</a> dans l\\\'�cran d\\\'Admin pour renseigner votre nouvelle cl�.  Si vous sp�cifizer pas de nouvelle cl� dans les 30 jours suivnat l\\\'expiration de votre cl�, vous ne pourrez plus vous connecter � l\\\'application.',
  'ERROR_VERSION_INCOMPATIBLE' => 'Le fichier upload� n\'est pas compatible avec la vesrion de Sugar Suite: ',
  'LBL_BACK' => 'Pr�c�dent',
  'LBL_CHECKSYS_1' => 'Afin que votre installation de SugarCRM fonctionne correctement, veuillez vous assurer que toutes les v�rifications du syst�me list�es ci-dessous sont en vert. Si au moins une est en rouge veuillez corriger le probl�me avant de continuer.',
  'LBL_CHECKSYS_CACHE' => 'Ecriture possible dans les sous-r�pertoires de cache ',
  'LBL_CHECKSYS_CALL_TIME' => 'La fonction Allow Call Time Pass Reference est OK',
  'LBL_CHECKSYS_COMPONENT' => 'Composants',
  'LBL_CHECKSYS_COMPONENT_OPTIONAL' => 'Composants Optionels',
  'LBL_CHECKSYS_CONFIG' => 'Ecriture dans le fichier de config de SugarCRM (config.php)',
  'LBL_CHECKSYS_CURL' => 'Librairie cURL',
  'LBL_CHECKSYS_CUSTOM' => 'Ecriture possible dans le r�pertoire utilisateur',
  'LBL_CHECKSYS_DATA' => 'Ecriture possible dans les sous-r�pertoires de donn�es',
  'LBL_CHECKSYS_IMAP' => 'IMAP Module',
  'LBL_CHECKSYS_MQGPC' => 'Magic Quotes GPC',
  'LBL_CHECKSYS_MBSTRING' => ' Module MB Strings',
  'LBL_CHECKSYS_MEM_OK' => 'OK (Pas de limite)',
  'LBL_CHECKSYS_MEM_UNLIMITED' => 'OK (Illimit�)',
  'LBL_CHECKSYS_MEM' => 'Limite M�moire PHP >= ',
  'LBL_CHECKSYS_MODULE' => 'Ecriture possible dans les sous-r�pertoires des modules et les fichiers',
  'LBL_CHECKSYS_MYSQL_VERSION' => 'Version de MySQL',
  'LBL_CHECKSYS_NOT_AVAILABLE' => 'Non disponible',
  'LBL_CHECKSYS_OK' => 'OK',
  'LBL_CHECKSYS_PHP_INI' => '<b>nOTE:</b> Votre fichier de configuration php (php.ini) est situ� ici :',
  'LBL_CHECKSYS_PHP_OK' => 'OK (ver ',
  'LBL_CHECKSYS_PHPVER' => 'Version PHP ',
  'LBL_CHECKSYS_RECHECK' => 'Re-v�rifier',
  'LBL_CHECKSYS_SAFE_MODE' => 'La fonction PHP Safe Mode est d�sactiv�e',
  'LBL_CHECKSYS_SESSION' => 'Ecriture possible dans chemin de sauvegarde des sessions (',
  'LBL_CHECKSYS_STATUS' => 'Statut',
  'LBL_CHECKSYS_TITLE' => 'V�rification du System Accept�',
  'LBL_CHECKSYS_VER' => 'Trouv�: ( ver ',
  'LBL_CHECKSYS_XML' => 'Parsage du XML',
  'LBL_CHECKSYS_ZLIB' => 'Module ZLIB Compression',
  'LBL_CLOSE' => 'Fermer',
  'LBL_CONFIRM_BE_CREATED' => '� cr�er',
  'LBL_CONFIRM_DB_TYPE' => 'Type base de donn�es',
  'LBL_CONFIRM_DIRECTIONS' => 'Veuillez confirmer les param�tres ci-dessous. Si vous voulez modifier une des valeur, cliquez sur "pr�c�dent". Sinon cliquez sur "suivant" pour commencer l\'installation.',
  'LBL_CONFIRM_LICENSE_TITLE' => 'Information concernant la License',
  'LBL_CONFIRM_NOT' => 'pas',
  'LBL_CONFIRM_TITLE' => 'Confirmer les param�tres',
  'LBL_CONFIRM_WILL' => 'va',
  'LBL_DBCONF_CREATE_DB' => 'Cr�er la base de donn�es',
  'LBL_DBCONF_CREATE_USER' => 'Cr�er Utilisateur',
  'LBL_DBCONF_DB_DROP_CREATE_WARN' => 'AVERTISSEMENT: Toutes les donn�es de Sugar seront effac�es<br> si cette case est coch�.',
  'LBL_DBCONF_DB_DROP_CREATE' => 'Effacer et recr�er les tables Sugar existantes ?',
  'LBL_DBCONF_DB_NAME' => 'Nom de la base de donn�es',
  'LBL_DBCONF_DB_PASSWORD' => 'Mot de passe de base de donn�es',
  'LBL_DBCONF_DB_PASSWORD2' => 'Re-saisissez votre mot de passe pour la base de donn�es',
  'LBL_DBCONF_DB_USER' => 'Utilisateur de la base de donn�es',
  'LBL_DBCONF_DEMO_DATA' => 'Remplir la base de donn�es avec des donn�es de D�mo?',
  'LBL_DBCONF_HOST_NAME' => 'Nom de l\'H�te (HostName)',
  'LBL_DBCONF_INSTRUCTIONS' => 'Veuillez saisir les infos de configuration de la base de donn�es. Si vous n\'�tes pas s�r des champs � renseigner, nous vous conseillons d\'utiliser les valeurs par d�faut.',
  'LBL_DBCONF_MB_DEMO_DATA' => 'Utiliser du texte multi-octet dans les donn�es de d�mo?',
  'LBL_DBCONF_PRIV_PASS' => 'Mot de passe de l\'utilisateur privil�gi� de la base de donn�es',
  'LBL_DBCONF_PRIV_USER_2' => 'Le compte utilisateur de la base de donn�es est celui d\'un utilisateur privil�gi�?',
  'LBL_DBCONF_PRIV_USER_DIRECTIONS' => 'Cet utilisateur privil�gi� doit avoir les bonnes autorisations pour cr�er une base de donn�es, cr�er/supprimer tables, cr�er des utilisateurs.Cet utilsateur privil�gi� va �tre utilis� pour ex�cuter ces t�che pendant le processus d\'installatio.Vous pouvez aussi utiliser le m�me utilisateur que ci-dessus si cet utilisateur a des privil�ges suffisants.',
  'LBL_DBCONF_PRIV_USER' => 'Identifiant de l\'utilisateur pivil�gie de la base de donn�es',
  'LBL_DBCONF_TITLE' => 'Configuration de la base de donn�es',
  'LBL_DISABLED_DESCRIPTION_2' => 'Apr�s avoir fait cette modification, vous pouvez cliquer sur le bouton "D�marrer" ci-dessous pour lancer l\'installation.  <i>Une fois l\'installation termin�e, vous pouvez modifier la valeur de  \'installer_locked\' � \'true\'.</i>',
  'LBL_DISABLED_DESCRIPTION' => 'Le processus d\'installation a �t� lanc� d�j� une fois. Pour des mesures de s�curit�, lon lancement une seconde fois a �t� d�sactiv�. Si vous �tes absolument certain que vous voulez le lancer encore une fois, veuillez trouver (ou ajouter) dans votre fichier config.php la variable suivante:  \'installer_locked\' et renseignez sa valeur � \'false\'.  La ligne doit �tre comme celle-ci:',
  'LBL_DISABLED_HELP_1' => 'Pour avoir de l\'aide sur installation, veuillez vous rendre sur SugarCRM',
  'LBL_DISABLED_HELP_2' => 'forums d\'aide',
  'LBL_DISABLED_TITLE_2' => 'L\'installation SugarCRM a �t� d�sactiv�e',
  'LBL_DISABLED_TITLE' => 'Installation SugarCRM d�sactiv�e',
  'LBL_HELP' => 'Aide',
  'LBL_LANG_1' => 'Si vous voulez installer un autre pack de langue autre que celui par d�faut de US-English, vous pouvez le faire ci-dessous. Sinon cliquez sur "Suivant" pour paser � l\'�tape suivante.',
  'LBL_LANG_BUTTON_COMMIT' => 'Installer',
  'LBL_LANG_BUTTON_REMOVE' => 'Supprimer',
  'LBL_LANG_BUTTON_UNINSTALL' => 'D�sinstaller',
  'LBL_LANG_BUTTON_UPLOAD' => 'Upload',
  'LBL_LANG_NO_PACKS' => 'aucun',
  'LBL_LANG_PACK_INSTALLED' => 'Les packs de langue suivants ont �t� install�: ',
  'LBL_LANG_PACK_READY' => 'Les packs de langue suivants sont pr�ts � �tre install�s: ',
  'LBL_LANG_SUCCESS' => 'The language pack was successfully uploaded.',
  'LBL_LANG_TITLE' => 'Pack de Langue ',
  'LBL_LANG_UPLOAD' => 'Upload un pack de langue',
  'LBL_LICENSE_ACCEPTANCE' => 'Acceptation de la licence',
  'LBL_LICENSE_DIRECTIONS' => 'Si vous avez votre information de licence, veuillez la renseigner dans les champs ci-dessous.',
  'LBL_LICENSE_DOWNLOAD_KEY' => 'T�lecharger la cl�',
  'LBL_LICENSE_EXPIRY' => 'Date d\'Expiration',
  'LBL_LICENSE_I_ACCEPT' => 'J\'Accepte',
  'LBL_LICENSE_NUM_USERS' => 'Nombre d\'utilisateurs',
  'LBL_LICENSE_OC_DIRECTIONS' => 'Veuillez sasir le nombre de clients d�connect�s achet�s.',
  'LBL_LICENSE_OC_NUM' => 'Nombre de licences de clients d�connect�s',
  'LBL_LICENSE_OC' => 'Licences de clients d�connect�s',
  'LBL_LICENSE_PRINTABLE' => ' Apper�u avant impression',
  'LBL_LICENSE_TITLE_2' => 'License SugarCRM ',
  'LBL_LICENSE_TITLE' => 'Information License ',
  'LBL_LICENSE_USERS' => 'Utilisateurs autoris�s',
  'LBL_LOCALE_CURRENCY' => 'Param�tres de la devise',
  'LBL_LOCALE_CURR_DEFAULT' => 'Devise par d�faut',
  'LBL_LOCALE_CURR_SYMBOL' => 'Symbole de la devise',
  'LBL_LOCALE_CURR_ISO' => 'Code de la devise (ISO 4217)',
  'LBL_LOCALE_CURR_1000S' => 'S�parateur des milliers',
  'LBL_LOCALE_CURR_DECIMAL' => 'S�parateur d�cimal',
  'LBL_LOCALE_CURR_EXAMPLE' => 'Exemple',
  'LBL_LOCALE_CURR_SIG_DIGITS' => 'Chiffres significatifs',
  'LBL_LOCALE_DATEF' => 'Format de date par d�faut',
  'LBL_LOCALE_DESC' => 'Ajustez votre param�trage des variables Locales ci-dessous.',
  'LBL_LOCALE_EXPORT' => 'Jeux de caract�res pour les exports (pour les exports de vCard et CSV)',
  'LBL_LOCALE_EXPORT_DELIMITER' => 'Export avec d�limiteur (.csv)',
  'LBL_LOCALE_EXPORT_TITLE' => "Param�trage d'export",
  'LBL_LOCALE_LANG' => 'Langue par d�faut',
  'LBL_LOCALE_NAMEF' => 'Format du nom par d�fautt',
  'LBL_LOCALE_NAMEF_DESC' => '"s" Civilit�<br />"f" Pr�nom<br />"l" Nom',
  'LBL_LOCALE_NAME_FIRST' => 'David',
  'LBL_LOCALE_NAME_LAST' => 'Livingstone',
  'LBL_LOCALE_NAME_SALUTATION' => 'Dr.',
  'LBL_LOCALE_TIMEF' => "Format de l'heure par d�faut",
  'LBL_LOCALE_TITLE' => 'Param�trages des variables Locales',
  'LBL_LOCALE_UI' => 'Interface Utilisateur',
  'LBL_ML_ACTION' => 'Action',
  'LBL_ML_DESCRIPTION' => 'Description',
  'LBL_ML_INSTALLED' => 'Date d\'Installation',
  'LBL_ML_NAME' => 'Nom',
  'LBL_ML_PUBLISHED' => 'Date Publication',
  'LBL_ML_TYPE' => 'Type',
  'LBL_ML_UNINSTALLABLE' => 'Impossible de d�sinstaller',
  'LBL_ML_VERSION' => 'Version',
  'LBL_MSSQL' => 'MSSQL Server',
  'LBL_MYSQL' => 'MySQL',
  'LBL_NEXT' => 'Suivant',
  'LBL_NO' => 'Non',
  'LBL_ORACLE' => 'Oracle',
  'LBL_PERFORM_ADMIN_PASSWORD' => 'D�finir le mot de passe pour l\'admin du site',
  'LBL_PERFORM_AUDIT_TABLE' => 'auditer la table ?',
  'LBL_PERFORM_CONFIG_PHP' => 'Cr�ation de fichier de configuration Sugar',
  'LBL_PERFORM_CREATE_DB_1' => 'Cr�ation de la base de donn�es ',
  'LBL_PERFORM_CREATE_DB_2' => ' ok ',
  'LBL_PERFORM_CREATE_DB_USER' => 'Cr�ation de l\'utilisateur et mot de passe de la base de donn�es...',
  'LBL_PERFORM_CREATE_DEFAULT' => 'Cr�ation de donn�es Sugar par d�faut',
  'LBL_PERFORM_CREATE_LOCALHOST' => 'Cr�ation de l\'utilisateur et mot de passe pour le localhost...',
  'LBL_PERFORM_CREATE_RELATIONSHIPS' => 'Cr�ation des tables relationnelles Sugar',
  'LBL_PERFORM_CREATING' => 'cr�ation / ',
  'LBL_PERFORM_DEFAULT_REPORTS' => 'Cr�ation des rapports par d�faut',
  'LBL_PERFORM_DEFAULT_SCHEDULER' => 'Cr�ation de t�ches du planificateur par d�faut',
  'LBL_PERFORM_DEFAULT_SETTINGS' => 'Insertion des param�tres par d�faut',
  'LBL_PERFORM_DEFAULT_USERS' => 'Cr�ation des utilisateur par d�faut',
  'LBL_PERFORM_DEMO_DATA' => 'Remplir la base de donn�es avec les donn�es de d�mo  (ceci peut prendre un peu de temps)...',
  'LBL_PERFORM_DONE' => 'fait<br>',
  'LBL_PERFORM_DROPPING' => 'suppression / ',
  'LBL_PERFORM_FINISH' => 'Finir',
  'LBL_PERFORM_LICENSE_SETTINGS' => 'Mise � jour de l\'information de license',
  'LBL_PERFORM_OUTRO_1' => 'Le param�trage de Sugar ',
  'LBL_PERFORM_OUTRO_2' => ' est maintenant t�rmin�.',
  'LBL_PERFORM_OUTRO_3' => 'Temps total: ',
  'LBL_PERFORM_OUTRO_4' => ' secondes.',
  'LBL_PERFORM_OUTRO_5' => 'M�moire utilis�e Approx.: ',
  'LBL_PERFORM_OUTRO_6' => ' octets.',
  'LBL_PERFORM_OUTRO_7' => 'Votre syst�me est maintenant install� et configur� pour �tre utilis�.',
  'LBL_PERFORM_REL_META' => 'relation meta ... ',
  'LBL_PERFORM_SUCCESS' => 'Succ�s !',
  'LBL_PERFORM_TABLES' => 'Cr�ation de tables de l\'application Sugar, tables d\'audit, et relations des m�tadonn�es...',
  'LBL_PERFORM_TITLE' => 'Param�trer',
  'LBL_PRINT' => 'Imprimer',
  'LBL_REG_CONF_1' => 'SVP veuillez prendre un instant pour vous enregistrer avec sugarCRM. En nous laissant savoir comment votre soci�t� compte utilisr SugarCRM, nous pouvons vous garantir de vous fournir toujours la bonne application pour vos besoins de business.',
  'LBL_REG_CONF_2' => 'Votre nom et votre adresse email sont les seuls champs requis pour l\'enregistrement. Tous les autrs champs sont optionnels, mais nous aiderons beaucoup. Nous ne revendons pas, ni ne louons, ni ne partageons, ni ne redistribuons d\'une quelconque fa�on les informations transmises ici',
  'LBL_REG_CONF_3' => 'Merci de vous �tre enregistr�. Cliquez sur le bouton Terminer pour vous logguer sur SugarCRM. Vous aurez besoin de vous logguer pour la premi�re fois avec l\'utilisateur "admin" et le mot de passe renseign� lors de la 2�me �tape.',
  'LBL_REG_TITLE' => 'Enregistrement',
  'LBL_REQUIRED' => '* Champs requis',
  'LBL_SITECFG_ADMIN_PASS_2' => 'Re-saisissez le mote de passe <em>Admin</em> de Sugar',
  'LBL_SITECFG_ADMIN_PASS_WARN' => 'ATTENTION: Vous allez remplacer le mot de passe admin de toute installation pr�c�dente.',
  'LBL_SITECFG_ADMIN_PASS' => 'Mot de passe <em>Admin</em> de Sugar',
  'LBL_SITECFG_APP_ID' => 'ID Application',
  'LBL_SITECFG_CUSTOM_ID_DIRECTIONS' => 'Ecraser l\'ID d\'Application autog�n�r� qui emp�che les sessions d\'une instance de sugar d\'�tre utilis� sur une autre instance. Si vous avez un cluster d\'installation de Sugar, elles doivent toute partager le m�me ID d\'Application',
  'LBL_SITECFG_CUSTOM_ID' => 'Fournissez votre propre ID d\'Application',
  'LBL_SITECFG_CUSTOM_LOG_DIRECTIONS' => 'Ecraser le r�pertoire par d�faut ou r�sident les Logs de Sugar. Aucun probl�me d\'o� vous aller mettre le fichier de Logs, l\'acc�s � celui-ci par un navigateur sera limit� par une redirection du .htaccess ',
  'LBL_SITECFG_CUSTOM_LOG' => 'Utilisez un r�pertoire personnalis� pour les Logs',
  'LBL_SITECFG_CUSTOM_SESSION_DIRECTIONS' => 'Fournissez un r�pertoire s�curis� pour enregistrer les informations de session et emp�cher les donn�es de sessions d\'�tre vuln�rables sur les serveurs mutualis�s.',
  'LBL_SITECFG_CUSTOM_SESSION' => 'Utiliser un r�pertoire de session personnalis� pour Sugar',
  'LBL_SITECFG_DIRECTIONS' => 'Veuillez saisir les informations de confiuration de votre site. Si vous n\'�tes pas s�r des champs, nous vous sugg�rons d\'utiliser les valeurs par d�faut.',
  'LBL_SITECFG_FIX_ERRORS' => 'Veuillez corriger les erreurs suivant avant de continuer:',
  'LBL_SITECFG_LOG_DIR' => 'R�pertoire de Logs',
  'LBL_SITECFG_SESSION_PATH' => 'Chemin vers le r�pertoire de Session<br>(il doit �tre possible d\'y �crire)',
  'LBL_SITECFG_SITE_SECURITY' => 'S�curit� Avanc�e du site',
  'LBL_SITECFG_SUGAR_UP_DIRECTIONS' => 'Quand vous activez cette option votre syst�me va envoyer p�riodiquement des infomations statistiques anonymes sur votre installation qui vont nous aider � comprendre les modes d\'utilisation et am�liorer le produit.  En retour de ces informations, les administrateurs vont recevoir les notifications de mise � jour quand de nouvelles versions sont disponibles.',
  'LBL_SITECFG_SUGAR_UP' => 'Activer les Mises � Jour Sugar?',
  'LBL_SITECFG_SUGAR_UPDATES' => 'Configuration des Mises � Jour',
  'LBL_SITECFG_TITLE' => 'Configuration du site',
  'LBL_SITECFG_URL' => 'URL de l\'instance Sugar',
  'LBL_SITECFG_USE_DEFAULTS' => 'Utilisation des param par d�faut?',
  'LBL_SITECFG_ANONSTATS' => 'Envoyer des statistiques compl�tement anonymes ?',
  'LBL_SITECFG_ANONSTATS_DIRECTIONS' => "Si vous cochez cette otion Sugar enverra des statistiques d'utilisation anonymes � SugarCRM Inc. chaque fois que votre syst�me v�rifiera la pr�sence de nouvelle version. Ces informations nous permettrons de mieux comprendre comment vous utilisez l'application et nous aiderons � orienter les am�liorations du produit.",
  'LBL_START' => 'D�marrer',
  'LBL_STEP' => 'Etape',
  'LBL_TITLE_WELCOME' => 'Bienvenue sur SugarCRM ',
  'LBL_WELCOME_1' => 'Cet installeur cr�e les tables de la base de donn�es SugarCRM et enregistre les param�tres de configuration n�cessaire pour d�marrer. Le processus d\'installation ne devrait pas d�passer une dizaine de minutes.',
  'LBL_WELCOME_2' => 'Pour obtenir de l\'aide sur l\'installation, veuillez vous rendre sur les forums <a href="http://www.sugarcrm.com/forums/" target="_blank">SugarCRM</a> ou .<a href="http://forums.crm-france.com/" target="_blank">CRM-France</a>',
  'LBL_WELCOME_CHOOSE_LANGUAGE' => 'S�lectionnez votre langue',
  'LBL_WELCOME_SETUP_WIZARD' => 'Assistant d\'installation',
  'LBL_WELCOME_TITLE_WELCOME' => 'Bienvenue sur SugarCRM ',
  'LBL_WELCOME_TITLE' => 'Assistant de configuration SugarCRM',
  'LBL_WIZARD_TITLE' => 'Assistant de configuration SugarCRM: Etape ',
  'LBL_YES' => 'Oui',
  'LBL_OOTB_WORKFLOW' => 'R�aliser les t�ches de Workflow',
  'LBL_OOTB_REPORTS' => 'Lancer les t�ches planifi�es de g�n�ration de rapports',
  'LBL_OOTB_IE' => 'V�rifier les emails entrants',
  'LBL_OOTB_BOUNCE' => 'Lancer les processus nocturnes des campagnes emails bounc�es',
  'LBL_OOTB_CAMPAIGN' => 'Lancer les processus nocturnes des campganes emails en masse',
  'LBL_OOTB_PRUNE' => 'Nettoyage de la base le 1er du mois',
  'LBL_OC_INSTAL_ADMIN_NAME' => 'Identifiant Administrateur',
  'LBL_OC_INSTAL_SERVER_URL' => 'URL du Serveur Sugar ',
	// OOTB Scheduler Job Names:
);


?>
