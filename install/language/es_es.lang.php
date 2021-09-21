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

 * Source: SugarCRM 4.5.0g
 * Description:
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc. All Rights
 * Reserved. Contributor(s): apserrano@grupobbva.net
 * *******************************************************************************/

$mod_strings = array(








	


































	
	'DEFAULT_CHARSET'					=> 'UTF-8',
	'ERR_ADMIN_PASS_BLANK'				=> 'La contraseña de admin de SugarCRM no puede estar vacía.',
	'ERR_CHECKSYS_CALL_TIME'			=> '"Allow Call Time Pass Reference" está Deshabilitado (por favor, habilítelo en php.ini)',
	'ERR_CHECKSYS_CURL'					=> 'No encontrado: El Planificador de Sugar tendrá funcionalidad limitada.',
	'ERR_CHECKSYS_IMAP'					=> 'No encontrado: Email Entrante y Campañas (Email) requieren las bibliotecas de IMAP. Ninguno será funcional.',
	'ERR_CHECKSYS_MSSQL_MQGPC'			=> 'Magic Quotes GPC no puede ser activado cuando se usa MS SQL Server.',
	'ERR_CHECKSYS_MBSTRING'				=> 'No encontrado: SugarCRM no podrá procesar caracteres multi-byte.  Esto afectará a los emails que utilicen juegos de caracteres distintos de UTF-8.',
	'ERR_CHECKSYS_MEM_LIMIT_1'			=> 'Aviso: $memory_limit (Establézcalo a ',
	'ERR_CHECKSYS_MEM_LIMIT_2'			=> 'M o más en su archivo your php.ini)',
	'ERR_CHECKSYS_MYSQL_VERSION'		=> 'Versión Mínima 4.1.2 - Encontrada: ',
	'ERR_CHECKSYS_NO_SESSIONS'			=> 'Ha ocurrido un error al escribir y leer las variables de sesión.  No se ha podido proceder con la instalación.',
	'ERR_CHECKSYS_NOT_VALID_DIR'		=> 'No es un Directorio Válido',
	'ERR_CHECKSYS_NOT_WRITABLE'			=> 'Aviso: No Escribible',
	'ERR_CHECKSYS_PHP_INVALID_VER'		=> 'Versión Instalada de PHP No Válida: ( ver',
	'ERR_CHECKSYS_PHP_UNSUPPORTED'		=> 'Versión de PHP Instalada No Soportada: ( ver',
	'ERR_CHECKSYS_SAFE_MODE'			=> 'El Modo Seguro está activado (por favor, deshabilítelo en php.ini)',
	'ERR_CHECKSYS_ZLIB'					=> 'No encontrado: SugarCRM obtiene grandes beneficios de rendimiento con compresión zlib.',
	'ERR_DB_ADMIN'						=> 'El nombre de usuario o contraseña del administrador de base de datos no son válidos (Error ',
	'ERR_DB_EXISTS_NOT'					=> 'La base de datos especificada no existe.',
	'ERR_DB_EXISTS_WITH_CONFIG'			=> 'La base de datos ya existe y contiene datos de configuración.  Para ejecutar una instalación con la base de datos elegida, por favor, ejecute de nuevo la instalación y seleccione: "¿Eliminar y crear de nuevo las tablas de SugarCRM?"  Para actualizar, utilice el Asistente de Actualizaciones en la Consola de Administración.  Por favor, lea la documentación referente a actualizaciones <a href="http://www.sugarforge.org/content/downloads/" target="_new">aquí</a>.',
	'ERR_DB_EXISTS'						=> 'El nombre de base de datos ya existe--no puede crearse otra con el mismo nombre.',
	'ERR_DB_HOSTNAME'					=> 'El nombre de equipo no puede estar vacío.',
	'ERR_DB_INVALID'					=> 'El tipo de base de datos seleccionado no es válido.',
	'ERR_DB_LOGIN_FAILURE_MYSQL'		=> 'SugarCRM database user name and/or password is invalid (Error ',
	'ERR_DB_LOGIN_FAILURE_MSSQL'		=> 'SugarCRM database user name and/or password is invalid.',
	'ERR_DB_MYSQL_VERSION1'				=> 'Versión de MySQL ',
	'ERR_DB_MYSQL_VERSION2'				=> ' no soportada.  Sólo MySQL 4.1.x o superiores están soportadas.',
	'ERR_DB_NAME'						=> 'El nombre de base de datos no puede estar vacío.',
	'ERR_DB_NAME2'						=> "El nombre de base de datos no puede contener los caracteres '\\', '/', o '.'",
	'ERR_DB_PASSWORD'					=> 'Las contraseñas para SugarCRM no coinciden.',
	'ERR_DB_PRIV_USER'					=> 'Se requiere el usuario admin de base de datos.',
	'ERR_DB_USER_EXISTS'				=> 'El nombre de usuario para SugarCRM ya existe--no puede crearse otro con el mismo nombre.',
	'ERR_DB_USER'						=> 'El nombre de usuario para SugarCRM no puede estar vacío.',
	'ERR_DBCONF_VALIDATION'				=> 'Por favor, corrija los siguientes errores antes de continuar:',
	'ERR_ERROR_GENERAL'					=> 'Se han encontrado los siguientes errores:',
	'ERR_LANG_CANNOT_DELETE_FILE'		=> 'El archivo no puede ser eliminado: ',
	'ERR_LANG_MISSING_FILE'				=> 'El archivo no ha sido encontrado: ',
	'ERR_LANG_NO_LANG_FILE'			 	=> 'No se ha encontrado un paquete de lenguaje en include/language dentro de: ',
	'ERR_LANG_UPLOAD_1'					=> 'Ha ocurrido un problema con su subida de archivo.  Por favor, inténtelo de nuevo.',
	'ERR_LANG_UPLOAD_2'					=> 'Los paquetes de lenguaje deben ser archivos ZIP.',
	'ERR_LANG_UPLOAD_3'					=> 'PHP no ha podido mover el archivo temporal al directorio de actualizaciones.',
	'ERR_LICENSE_MISSING'				=> 'Faltan Campos Requeridos',
	'ERR_LICENSE_NOT_FOUND'				=> '¡No se ha encontrado el archivo de licencia!',
	'ERR_LOG_DIRECTORY_NOT_EXISTS'		=> 'El directorio de trazas indicado no es un directorio válido.',
	'ERR_LOG_DIRECTORY_NOT_WRITABLE'	=> 'El directorio de trazas indicado no es un directorio escribible.',
	'ERR_LOG_DIRECTORY_REQUIRED'		=> 'Se requiere un directorio de trazas si desea indicar uno personalizado.',
	'ERR_NO_DIRECT_SCRIPT'				=> 'No se ha podido procesar el script directamente.',
	'ERR_NO_SINGLE_QUOTE'				=> 'No puede utilizarse las comillas simples para ',
	'ERR_PASSWORD_MISMATCH'				=> 'Las contraseñas para el admin de SugarCRM no coinciden.',
	'ERR_PERFORM_CONFIG_PHP_1'			=> 'No ha podido escribirse en el archivo <span class=stop>config.php</span>.',
	'ERR_PERFORM_CONFIG_PHP_2'			=> 'Puede continuar esta instalación crando manualmente el archivo config.php y pegando la información de configuración indicada a continuación en el archivo config.php.  Sin embargo, <strong>debe </strong>crear el archivo config.php antes de avanzar al siguiente paso.',
	'ERR_PERFORM_CONFIG_PHP_3'			=> '¿Recordó crear el archivo config.php?',
	'ERR_PERFORM_CONFIG_PHP_4'			=> 'Aviso: No ha podido escribirse en el archivo config.php.  Por favor, asegúrese de que existe.',
	'ERR_PERFORM_HTACCESS_1'			=> 'No ha podido escribirse en el archivo ',
	'ERR_PERFORM_HTACCESS_2'			=> ' .',
	'ERR_PERFORM_HTACCESS_3'			=> 'Si quiere securizar su archivo de trazas, para evitar que sea accesible mediante el navegador web, cree un archivo .htaccess en su directorio de trazas con la línea:',
	'ERR_PERFORM_NO_TCPIP'				=> '<b>No se ha podido detectar una conexión a internet.</b>Por favor, cuando disponga de una, visite <a href=\"http://www.sugarcrm.com/home/index.php?option=com_extended_registration&task=register\">http://www.sugarcrm.com/home/index.php?option=com_extended_registration&task=register</a> para registrarse con SugarCRM. Permitiéndonos saber un poco sobre los planes de su compañía para utilizar SugarCRM, podemos asegurarnos de que siempre estamos suministrando el producto adecuado para las necesidades de su negocio.',
	'ERR_SESSION_DIRECTORY_NOT_EXISTS'	=> 'El directorio de sesión indicado no es un directorio válido.',
	'ERR_SESSION_DIRECTORY'				=> 'El directorio de sesión indicado no es un directorio escribible.',
	'ERR_SESSION_PATH'					=> 'Se requiere un directorio de sesión si desea indicar uno personalizado.',
	'ERR_SI_NO_CONFIG'					=> 'No ha incluido config_si.php en la carpeta raíz de documentos, o no ha definido $sugar_config_si en config.php',
	'ERR_SITE_GUID'						=> 'Se requiere un ID de Aplicación si desea indicar uno personalizado.',
	'ERR_UPLOAD_MAX_FILESIZE'			=> 'Aviso: Su configuración de PHP debe ser cambiada para permitir subidas de archivos de al menos 6MB.',
	'ERR_URL_BLANK'						=> 'El URL no puede estar vacío.',
	'ERR_UW_NO_UPDATE_RECORD'			=> 'No se ha localizado el registro de instalación de',
	'ERROR_FLAVOR_INCOMPATIBLE'			=> 'El archivo subido no es compatible con esta edición (Open Source, Professional, o Enterprise) de Sugar Suite: ',
	'ERROR_LICENSE_EXPIRED'				=> "Error: Su licencia caducó hace ",
	'ERROR_LICENSE_EXPIRED2'			=> " día(s).   Por favor, vaya a la <a href='index.php?action=LicenseSettings&module=Administration'>'\"Administración de Licencias\"</a>, en la pantalla de Administración, para introducir su nueva clave de licencia.  Si no introduce una nueva clave de licencia en 30 días a partir de la caducidad de su clave de licencia, no podrá iniciar la sesión en esta aplicación.",
	'ERROR_MANIFEST_TYPE'				=> 'El archivo de manifiesto debe especificar el tipo de paquete.',
	'ERROR_PACKAGE_TYPE'				=> 'El archivo de manifiesto debe especifica un tipo de paquete no reconocido',
	'ERROR_VALIDATION_EXPIRED'			=> "Error: Su clave de validación caducó hace ",
	'ERROR_VALIDATION_EXPIRED2'			=> " día(s).   Por favor, vaya a la <a href='index.php?action=LicenseSettings&module=Administration'>'\"Administración de Licencias\"</a>, en la pantalla de Administración, para introducir su nueva clave de validación.  Si no introduce una nueva clave de validación en 30 días a partir de la caducidad de su clave de validación, no podrá iniciar la sesión en esta aplicación.",
	'ERROR_VERSION_INCOMPATIBLE'		=> 'El archivo subido no es compatible con esta versión de Sugar Suite: ',
	
	'LBL_BACK'							=> 'Atrás',
	'LBL_CHECKSYS_1'					=> 'Para que su instalación de SugarCRM funcione correctamenteto, asegúrese de que todos los elementos de comprobación listados a continuación están en verde. Si alguno está en rojo, por favor, realice los pasos necesarios para corregirlos. <BR><BR> Para encontrar ayuda sobre estas comprobaciones del sistema, por favor visite el <a href="http://www.sugarcrm.com/crm/installation" target="_blank">Sugar Wiki</a>',
	'LBL_CHECKSYS_CACHE'				=> 'Subdirectorios de Caché Escribibles',
	'LBL_CHECKSYS_CALL_TIME'			=> 'PHP "Allow Call Time Pass Reference" Habilitado',
	'LBL_CHECKSYS_COMPONENT'			=> 'Componente',
	'LBL_CHECKSYS_COMPONENT_OPTIONAL'	=> 'Componentes Opcionales',
	'LBL_CHECKSYS_CONFIG'				=> 'Archivo de Configuración de SugarCRM (config.php) Escribible',
	'LBL_CHECKSYS_CURL'					=> 'Módulo cURL',
	'LBL_CHECKSYS_CUSTOM'				=> 'Directorio Personalizado (custom) Escribible',
	'LBL_CHECKSYS_DATA'					=> 'Subdirectorios de Datos Escribibles',
	'LBL_CHECKSYS_IMAP'					=> 'Módulo IMAP',
	'LBL_CHECKSYS_MQGPC'				=> 'Magic Quotes GPC',
	'LBL_CHECKSYS_MBSTRING'				=> 'Módulo de Cadenas MB',
	'LBL_CHECKSYS_MEM_OK'				=> 'Correcto (Sin Límite)',
	'LBL_CHECKSYS_MEM_UNLIMITED'		=> 'Correcto (Sin Límite)',
	'LBL_CHECKSYS_MEM'					=> 'Límite de Memoria PHP >= ',
	'LBL_CHECKSYS_MODULE'				=> 'Subdirectorios y Archivos de Módulos Escribibles',
	'LBL_CHECKSYS_MYSQL_VERSION'		=> 'Versión de MySQL',
	'LBL_CHECKSYS_NOT_AVAILABLE'		=> 'No Disponible',
	'LBL_CHECKSYS_OK'					=> 'Correcto',
	'LBL_CHECKSYS_PHP_INI'				=> '<b>Nota:</b> Su archivo de configuración de PHP (php.ini) está localizado en:',
	'LBL_CHECKSYS_PHP_OK'				=> 'Correcto (ver ',
	'LBL_CHECKSYS_PHPVER'				=> 'Versión de PHP',
	'LBL_CHECKSYS_RECHECK'				=> 'Comprobar de nuevo',
	'LBL_CHECKSYS_SAFE_MODE'			=> 'Modo Seguro de PHP Deshabilitado',
	'LBL_CHECKSYS_SESSION'				=> 'Ruta de Almacenamiento de Sesión Escribible (',
	'LBL_CHECKSYS_STATUS'				=> 'Estado',
	'LBL_CHECKSYS_TITLE'				=> 'Aceptación de Comprobaciones del Sistema',
	'LBL_CHECKSYS_VER'					=> 'Encontrado: ( ver ',
	'LBL_CHECKSYS_XML'					=> 'Análisis XML',
	'LBL_CHECKSYS_ZLIB'					=> 'Módulo de Compresión ZLIB',
	'LBL_CLOSE'							=> 'Cerrar',
	'LBL_CONFIRM_BE_CREATED'			=> 'será creado',
	'LBL_CONFIRM_DB_TYPE'				=> 'Tipo de Base de datos',
	'LBL_CONFIRM_DIRECTIONS'			=> 'Por favor, confirme la siguiente configuración.  Si desea cambiar cualquiera de los valores, haga clic en "Atrás" para editarlos.  En otro caso, haga clic en "Siguiente" para iniciar la instalación.',
	'LBL_CONFIRM_LICENSE_TITLE'			=> 'Información de Licencia',
	'LBL_CONFIRM_NOT'					=> 'no',
	'LBL_CONFIRM_TITLE'					=> 'Confirmar Configuración',
	'LBL_CONFIRM_WILL'					=> '',
	'LBL_DBCONF_CREATE_DB'				=> 'Crear Base de datos',
	'LBL_DBCONF_CREATE_USER'			=> 'Crear Usuario',
	'LBL_DBCONF_DB_DROP_CREATE_WARN'	=> 'Advertencia: Todos los datos de Sugar serán eliminados<br>si se marca esta opción.',
	'LBL_DBCONF_DB_DROP_CREATE'			=> '¿Eliminar las tablas de Sugar actuales y crearlas de nuevo?',
	'LBL_DBCONF_DB_NAME'				=> 'Nombre de Base de datos',
	'LBL_DBCONF_DB_PASSWORD'			=> 'Contraseña de Base de datos',
	'LBL_DBCONF_DB_PASSWORD2'			=> 'Introduzca de nuevo la Contraseña de Base de datos',
	'LBL_DBCONF_DB_USER'				=> 'Usuario de Base de datos',
	'LBL_DBCONF_DEMO_DATA'				=> '¿Introducir Datos de Demostración en la Base de datos?',
	'LBL_DBCONF_HOST_NAME'				=> 'Nombre de Equipo / Instancia en Equipo',
	'LBL_DBCONF_INSTRUCTIONS'			=> 'Por favor, introduzca la información de configuración de su base de datos a continuación. Si no está seguro de qué datos utilizar, le sugerimos que utilice los valores por defecto.',
	'LBL_DBCONF_MB_DEMO_DATA'			=> 'Utilizar texto multi-byte en datos de demostración?',
	'LBL_DBCONF_PRIV_PASS'				=> 'Contraseña de Usuario Privilegiado de Base de datos',
	'LBL_DBCONF_PRIV_USER_2'			=> '¿Corresponde la Cuenta de Base de datos Anterior a un Usuario Privilegiado?',
	'LBL_DBCONF_PRIV_USER_DIRECTIONS'	=> 'Este usuario privilegiado de base de datos debe de tener los permisos adecuados para crear una base de datos, eliminar/crear tablas, y crear un usuario.  Este usuario privilegiado de base de datos sólo se utilizará para realizar estas tareas según sean necesarias durante el proceso de instalación.  También puede utilizar el mismo usuario de base de datos anterior si tiene los privilegios suficientes.',
	'LBL_DBCONF_PRIV_USER'				=> 'Nombre de Usuario Privilegiado de Base de datos',
	'LBL_DBCONF_TITLE'					=> 'Configuración de Base de datos',
	'LBL_DISABLED_DESCRIPTION_2'		=> 'Después de que se haya realizado este cambio, puede hacer clic en el botón "Iniciar" situado abajo, para iniciar su instalación.  <i>Una vez se haya completado la instalación, es probable que desee cambiar el valor para la variable \'installer_locked\' a \'true\'.</i>',
	'LBL_DISABLED_DESCRIPTION'			=> 'El instalador ya ha sido ejecutado. Como medida de seguridad, se ha deshabilitado para que no sea ejecutado por segunda vez.  Si está totalmente seguro de que desea ejecutarlo de nuevo, por favor vaya a su archivo config.php y localice (o añada) una variable llamada  \'installer_locked\' y establézcala a \'false\'.  La línea debería quedar como lo siguiente:',
	'LBL_DISABLED_HELP_1'				=> 'Para ayuda sobre la instalación, por favor visite los foros de soporte de SugarCRM',
	'LBL_DISABLED_HELP_2'				=> '',
	'LBL_DISABLED_TITLE_2'				=> 'La Instalación de SugarCRM ha sido Deshabilitada',
	'LBL_DISABLED_TITLE'				=> 'Instalación de SugarCRM Deshabilitada',
	'LBL_EMAIL_CHARSET_DESC'			=> 'Establezca esto al juego de caracteres más utilizado en su configuración regional',
	'LBL_EMAIL_CHARSET_TITLE'			=> 'Juego de Caracteres de Email Saliente',
	'LBL_HELP'							=> 'Ayuda',
	'LBL_LANG_1'						=> 'Si desea instalar un paquete de lenguaje distinto al incluido por defecto (US-English), por favor hágalo a continuación.  En otro caso, haga clic en "Siguiente" para continuar con el siguiente paso.',
	'LBL_LANG_BUTTON_COMMIT'			=> 'Proceder',
	'LBL_LANG_BUTTON_REMOVE'			=> 'Quitar',
	'LBL_LANG_BUTTON_UNINSTALL'			=> 'Desinstalar',
	'LBL_LANG_BUTTON_UPLOAD'			=> 'Subir',
	'LBL_LANG_NO_PACKS'					=> 'ninguno',
	'LBL_LANG_PACK_INSTALLED'			=> 'Los siguientes paquetes de lenguaje han sido instalados: ',
	'LBL_LANG_PACK_READY'				=> 'Los siguientes paquetes de lenguaje están listos para ser instalados: ',
	'LBL_LANG_SUCCESS'					=> 'El paquete de lenguaje ha sido subido con éxito.',
	'LBL_LANG_TITLE'			   		=> 'Paquete de Lenguaje',
	'LBL_LANG_UPLOAD'					=> 'Subir un Paquete de Lenguaje',
	'LBL_LICENSE_ACCEPTANCE'			=> 'Aceptación de Licencia',
	'LBL_LICENSE_DIRECTIONS'			=> 'Si tiene información acerca de su licencia, por favor introdúzcala en los siguientes campos.',
	'LBL_LICENSE_DOWNLOAD_KEY'			=> 'Clave de Descarga',
	'LBL_LICENSE_EXPIRY'				=> 'Fecha de Caducidad',
	'LBL_LICENSE_I_ACCEPT'				=> 'Acepto',
	'LBL_LICENSE_NUM_USERS'				=> 'Número de Usuarios',
	'LBL_LICENSE_OC_DIRECTIONS'			=> 'Por favor, introduzca el nombre de clientes desconectados adquiridos.',
	'LBL_LICENSE_OC_NUM'				=> 'Número de Licencias de Cliente Desconectado',
	'LBL_LICENSE_OC'					=> 'Licencias de Cliente Desconectado',
	'LBL_LICENSE_PRINTABLE'				=> ' Vista Imprimible ',
	'LBL_LICENSE_TITLE_2'				=> 'Licencia de SugarCRM',
	'LBL_LICENSE_TITLE'					=> 'Información de Licencia',
	'LBL_LICENSE_USERS'					=> 'Usuarios con Licencia',
	
	'LBL_LOCALE_CURRENCY'				=> 'Configuración de Moneda',
	'LBL_LOCALE_CURR_DEFAULT'			=> 'Moneda por Defecto',
	'LBL_LOCALE_CURR_SYMBOL'			=> 'Símbolo de Moneda',
	'LBL_LOCALE_CURR_ISO'				=> 'Código de Moneda (ISO 4217)',
	'LBL_LOCALE_CURR_1000S'				=> 'Separador de miles',
	'LBL_LOCALE_CURR_DECIMAL'			=> 'Separador Decimal',
	'LBL_LOCALE_CURR_EXAMPLE'			=> 'Ejemplo',
	'LBL_LOCALE_CURR_SIG_DIGITS'		=> 'Dígitos Significavos',
	'LBL_LOCALE_DATEF'					=> 'Formato de Fecha por Defecto',
	'LBL_LOCALE_DESC'					=> 'Ajuste sus opciones de configuración regional de SugarCRM mostradas a continuación.',
	'LBL_LOCALE_EXPORT'					=> 'Juego de caracteres de Importación/Exportación <i>(Email, .csv, vCard, PDF, importación de datos)</i>',
	'LBL_LOCALE_EXPORT_DELIMITER'		=> 'Delimitador para Exportación (.csv)',
	'LBL_LOCALE_EXPORT_TITLE'			=> 'Configuración de Exportación',
	'LBL_LOCALE_LANG'					=> 'Lenguaje por Defecto',
	'LBL_LOCALE_NAMEF'					=> 'Formato de Nombre por Defecto',
	'LBL_LOCALE_NAMEF_DESC'				=> '"s" Título<br />"f" Nombre<br />"l" Apellido',
	'LBL_LOCALE_NAME_FIRST'				=> 'David',
	'LBL_LOCALE_NAME_LAST'				=> 'Livingstone',
	'LBL_LOCALE_NAME_SALUTATION'		=> 'Dr.',
	'LBL_LOCALE_TIMEF'					=> 'Formato de Hora por Defecto',
	'LBL_LOCALE_TITLE'					=> 'Configuración Regional',
	'LBL_LOCALE_UI'						=> 'Interfaz de Usuario',
	
	'LBL_ML_ACTION'						=> 'Acción',
	'LBL_ML_DESCRIPTION'				=> 'Descripción',
	'LBL_ML_INSTALLED'					=> 'Fecha de Instalación',
	'LBL_ML_NAME'						=> 'Nombre',
	'LBL_ML_PUBLISHED'					=> 'Fecha de Publicación',
	'LBL_ML_TYPE'						=> 'Tipo',
	'LBL_ML_UNINSTALLABLE'				=> 'No desinstalable',
	'LBL_ML_VERSION'					=> 'Versión',
	'LBL_MSSQL'							=> 'SQL Server',
	'LBL_MYSQL'							=> 'MySQL',
	'LBL_NEXT'							=> 'Siguiente',
	'LBL_NO'							=> 'No',
	'LBL_ORACLE'						=> 'Oracle',
	'LBL_PERFORM_ADMIN_PASSWORD'		=> 'Estableciendo la contraseña del admin del sitio',
	'LBL_PERFORM_AUDIT_TABLE'			=> 'tabla de auditoría / ',
	'LBL_PERFORM_CONFIG_PHP'			=> 'Creando el archivo de configuración de Sugar',
	'LBL_PERFORM_CREATE_DB_1'			=> 'Creando la base de datos ',
	'LBL_PERFORM_CREATE_DB_2'			=> ' en ',
	'LBL_PERFORM_CREATE_DB_USER'		=> 'Creando el usuario y la contraseña de Base de datos...',
	'LBL_PERFORM_CREATE_DEFAULT'		=> 'Creando datos de Sugar predeterminados',
	'LBL_PERFORM_CREATE_LOCALHOST'		=> 'Creando el usuario y la contraseña de Base de datos para localhost...',
	'LBL_PERFORM_CREATE_RELATIONSHIPS'	=> 'Creando tablas de relaciones de Sugar',
	'LBL_PERFORM_CREATING'				=> 'creando / ',
	'LBL_PERFORM_DEFAULT_REPORTS'		=> 'Creando informes predefinidos',
	'LBL_PERFORM_DEFAULT_SCHEDULER'		=> 'Creando trabajos del planificador por defecto',
	'LBL_PERFORM_DEFAULT_SETTINGS'		=> 'Insertando configuración por defecto',
	'LBL_PERFORM_DEFAULT_USERS'			=> 'Creando usuarios por defecto',
	'LBL_PERFORM_DEMO_DATA'				=> 'Insertando en las tablas de base de datos datos de demostración (esto puede llevar un rato)...',
	'LBL_PERFORM_DONE'					=> 'hecho<br>',
	'LBL_PERFORM_DROPPING'				=> 'eliminando / ',
	'LBL_PERFORM_FINISH'				=> 'Finalizado',
	'LBL_PERFORM_LICENSE_SETTINGS'		=> 'Actualizando información de licencia',
	'LBL_PERFORM_OUTRO_1'				=> 'La instalación de Sugar ',
	'LBL_PERFORM_OUTRO_2'				=> ' ha sido completada.',
	'LBL_PERFORM_OUTRO_3'				=> 'Tiempo total: ',
	'LBL_PERFORM_OUTRO_4'				=> ' segundos.',
	'LBL_PERFORM_OUTRO_5'				=> 'Memoria utiliza aproximadamente: ',
	'LBL_PERFORM_OUTRO_6'				=> ' bytes.',
	'LBL_PERFORM_OUTRO_7'				=> 'Su sistema ha sido instalado y configurado para su uso.',
	'LBL_PERFORM_REL_META'				=> 'metadatos de relaciones ... ',
	'LBL_PERFORM_SUCCESS'				=> '¡Éxito!',
	'LBL_PERFORM_TABLES'				=> 'Creando las tables de aplicación de Sugar, tablas de auditoría, y metadatos de relaciones...',
	'LBL_PERFORM_TITLE'					=> 'Realizar Instalación',
	'LBL_PRINT'							=> 'Imprimir',
	'LBL_REG_CONF_1'					=> 'Por favor, tómese un momento en registrarse con SugarCRM. Permitiéndonos saber un poco sobre los planes de su compañía para utilizar SugarCRM, podemos asegurarnos de que siempre estamos suministrando el producto adecuado para las necesidades de su negocio.',
	'LBL_REG_CONF_2'					=> 'Su nombre y dirección de email son los únicos campos requeridos para el registro. El resto de campos son opcionales, pero de mucho valor. No vendemos, alquilamos, compartimos, o distribuimos en modo alguno la información aquí recogida a terceros.',
	'LBL_REG_CONF_3'					=> 'Gracias por registrarse. Haga clic en el botón Finalizar para iniciar una sesión en SugarCRM. Necesitará iniciar la sesión por primera vez utilizando el nombre de usuario "admin" y la contraseña que introdujo en el paso 2.',
	'LBL_REG_TITLE'						=> 'Registro',
	'LBL_REQUIRED'						=> '* Campo requerido',
	'LBL_SITECFG_ADMIN_PASS_2'			=> 'Introduzca de nuevo la Contraseña del <em>Admin</em> de Sugar',
	'LBL_SITECFG_ADMIN_PASS_WARN'		=> 'Precaución: Esto substituirá la contraseña de admin de cualquier instalación previa.',
	'LBL_SITECFG_ADMIN_PASS'			=> 'Contraseña del <em>Admin</em> de Sugar',
	'LBL_SITECFG_APP_ID'				=> 'ID de Aplicación',
	'LBL_SITECFG_CUSTOM_ID_DIRECTIONS'	=> 'Sustituye el ID de aplicación auto-generado que evita que las sesiones de una instancia de Sugar sean utilizadas en otra instancia.  Si tiene un cluster de instalaciones Sugar, todas deben compartir el mismo ID de aplicación.',
	'LBL_SITECFG_CUSTOM_ID'				=> 'Proveer Su Propio ID de Aplicación',
	'LBL_SITECFG_CUSTOM_LOG_DIRECTIONS'	=> 'Sustituye el directorio por defecto donde las trazas de Sugar residen.  Independientemente de donde resida el archivo de trazas, el acceso al mismo a través del navegador será restringido mediante una redirección definida en un archivo .htaccess.',
	'LBL_SITECFG_CUSTOM_LOG'			=> 'Usar un Directorio Personalizado de Trazas',
	'LBL_SITECFG_CUSTOM_SESSION_DIRECTIONS'	=> 'Proveer una carpeta segura en la que almacenar la información de sesiones de Sugar para evitar que los datos de la sesión sean vulnerables en servidores compartidos.',
	'LBL_SITECFG_CUSTOM_SESSION'		=> 'Utilizar un Directorio Personalizado de Sesiones para Sugar',
	'LBL_SITECFG_DIRECTIONS'			=> 'Por favor, introduzca la información de configuración de su sitio a continuación. Si no está seguro del significado de los campos, le sugerimos que utilice los valores por defecto.',
	'LBL_SITECFG_FIX_ERRORS'			=> 'Por favor, corrija los siguientes errores antes de continuar:',
	'LBL_SITECFG_LOG_DIR'				=> 'Directorio de Trazas',
	'LBL_SITECFG_SESSION_PATH'			=> 'Ruta al Directorio de Sesiones<br>(debe ser escribible)',
	'LBL_SITECFG_SITE_SECURITY'			=> 'Seguridad Avanzada del Sitio',
	'LBL_SITECFG_SUGAR_UP_DIRECTIONS'	=> 'Si está marcado, el sistema comprobará periódicamente si hay disponibles versiones actualizadas de la aplicación.',
	'LBL_SITECFG_SUGAR_UP'				=> '¿Comprobar Automáticamente Actualizaciones?',
	'LBL_SITECFG_SUGAR_UPDATES'			=> 'Configuración de Actualizaciones de Sugar',
	'LBL_SITECFG_TITLE'					=> 'Configuración del Sitio',
	'LBL_SITECFG_URL'					=> 'URL de la Instancia de Sugar',
	'LBL_SITECFG_USE_DEFAULTS'			=> '¿Usar valores por defecto?',
	'LBL_SITECFG_ANONSTATS'             => 'Enviar Estadísticas de Uso Anónimas?',
	'LBL_SITECFG_ANONSTATS_DIRECTIONS'        => 'Si está marcado, Sugar enviará estadísticas anónimas sobre su instalación a SugarCRM Inc. cada vez que su sistema compruebe la existencia de nuevas versiones. Esta información nos ayudará a entender mejor cómo la aplicación es usada y guiar así las mejoras al producto.',
	'LBL_START'							=> 'Iniciar',
	'LBL_STEP'							=> 'Paso',
	'LBL_TITLE_WELCOME'					=> 'Bienvenido a SugarCRM ',
	'LBL_WELCOME_1'						=> 'Este instalador crea las tablas de base de datos de SugarCRM y establece las variables de configuración necesarias para iniciar. El proceso completo debería tardar unos diez minutos.',
	'LBL_WELCOME_2'						=> 'Para encontrar documentación sobre la instalación, por favor visite el <a href="http://www.sugarcrm.com/crm/installation" target="_blank">Sugar Wiki</a>.  <BR><BR> También puede encontrar ayuda dela Comunidad Sugar en los <a href="http://www.sugarcrm.com/forums/" target="_blank">Sugar Forums</a>.',



	'LBL_WELCOME_CHOOSE_LANGUAGE'		=> 'Seleccione su lenguaje',
	'LBL_WELCOME_SETUP_WIZARD'			=> 'Asistente de Instalación',
	'LBL_WELCOME_TITLE_WELCOME'			=> 'Bienvenido a SugarCRM ',
	'LBL_WELCOME_TITLE'					=> 'Asistente de Instalación de SugarCRM',
	'LBL_WIZARD_TITLE'					=> 'Asistente de Instalación de SugarCRM: Paso ',
	'LBL_YES'							=> 'Sí',
	// OOTB Scheduler Job Names:
	'LBL_OOTB_WORKFLOW'		=> 'Procesar Tareas de Workflow',
	'LBL_OOTB_REPORTS'		=> 'Ejecutar Tareas Programadas de Generación de Informes',
	'LBL_OOTB_IE'			=> 'Comprobar Bandejas de Entrada',
	'LBL_OOTB_BOUNCE'		=> 'Ejecutar Proceso Nocturno de Emails de Campaña Rebotados',
	'LBL_OOTB_CAMPAIGN'		=> 'Ejecutar Proceso Nocturno de Campañas de Email Masivo',
	'LBL_OOTB_PRUNE'		=> 'Truncar Base de datos al Inicio del Mes',
	'LBL_SESSION_ERR_DESCRIPTION'		=> "SugarCRM depende de las sesiones de PHP para almacenar información importante mientras que está conectado a su servidor web.  Su instalación de PHP no tiene la información de Sesión correctamente configurada.  
											<br><br>Un error de configuración bastante común es que la directiva <b>'session.save_path'</b> no apunte a un directorio válido.  <br>
											<br> Por favor, corrija su <a target=_new href='http://us2.php.net/manual/en/ref.session.php'>configuración PHP</a> en el archivo php.ini localizado donde se indica a continuación.",
	'LBL_SESSION_ERR_TITLE'				=> 'Error de Configuración de Sesiones PHP',
);

?>
