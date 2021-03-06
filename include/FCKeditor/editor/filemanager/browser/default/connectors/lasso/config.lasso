[//lasso
/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2005 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.fckeditor.net/
 * 
 * "Support Open Source software. What about a donation today?"
 * 
 * File Name: config.lasso
 * 	Configuration file for the File Manager Connector for Lasso.
 * 
 * File Authors:
 * 		Jason Huck (jason.huck@corefive.com)
 */

    /*.....................................................................     
    The connector uses the file tags, which require authentication. Enter a
    valid username and password from Lasso admin for a group with file tags
    permissions for uploads and the path you define in UserFilesPath below.                                                                        
    */ 
    
	var('connection') = array(
		-username='xxxxxxxx',
		-password='xxxxxxxx'
	);


    /*.....................................................................     
    Set the base path for files that users can upload and browse (relative
    to server root).
    
    Set which file extensions are allowed and/or denied for each file type.                                                                           
    */                                                                          
	var('config') = map(
		'UserFilesPath' = '/UserFiles/',
		'AllowedExtensions' = map(
			'File' = array(),
			'Image' = array('jpg','gif','jpeg','png'),
			'Flash' = array('swf','fla'),
			'Media' = array('swf','fla','jpg','gif','jpeg','png','avi','mpg','mpeg')
		),
		'DeniedExtensions' = map(
			'File' = array('php','asp','aspx','ascx','jsp','cfm','cfc','pl','bat','exe','dll','reg','inc','lasso','lassoapp','cgi'),
			'Image' = array(),
			'Flash' = array(),
			'Media' = array()
		)
	);
]
