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

 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/
include('include/phpmailer/class.phpmailer.php');

class SugarPHPMailer extends PHPMailer {
	var $preppedForOutbound = false;

	/**
	 * Sole constructor
	 */
	function SugarPHPMailer() {
		global $locale;

		$this->SetLanguage('en', 'include/phpmailer/language/');
		$this->PluginDir	= 'include/phpmailer/';
		$this->Mailer		= 'sendmail';
        // cn: i18n
        $this->CharSet		= $locale->getPrecedentPreference('default_email_charset');
		$this->Encoding		= 'quoted-printable';
        $this->IsHTML(false);  // default to plain-text email
        $this->WordWrap		= 996;



	}

    /**
     * Attaches all fs, string, and binary attachments to the message.
     * Returns an empty string on failure.
     * @access private
     * @return string
     */
    function AttachAll() {
        // Return text of body
        $mime = array();

        // Add all attachments
        for($i = 0; $i < count($this->attachment); $i++) {
            // Check for string attachment
            $bString = $this->attachment[$i][5];
            if ($bString) {
                $string = $this->attachment[$i][0];
            } else {
				$path = $this->attachment[$i][0];
            }

			// cn: overriding parent class' method to perform encode on the following
            $filename    = $this->EncodeHeader(trim($this->attachment[$i][1]));
            $name        = $this->EncodeHeader(trim($this->attachment[$i][2]));
            $encoding    = $this->attachment[$i][3];
            $type        = $this->attachment[$i][4];
            $disposition = $this->attachment[$i][6];
            $cid         = $this->attachment[$i][7];

            $mime[] = sprintf("--%s%s", $this->boundary[1], $this->LE);
            $mime[] = sprintf("Content-Type: %s; name=\"%s\"%s", $type, $name, $this->LE);
            $mime[] = sprintf("Content-Transfer-Encoding: %s%s", $encoding, $this->LE);

            if($disposition == "inline") {
                $mime[] = sprintf("Content-ID: <%s>%s", $cid, $this->LE);
            }

            $mime[] = sprintf("Content-Disposition: %s; filename=\"%s\"%s", $disposition, $name, $this->LE.$this->LE);

            // Encode as string attachment
            if($bString) {
                $mime[] = $this->EncodeString($string, $encoding);
                if($this->IsError()) { return ""; }
                $mime[] = $this->LE.$this->LE;
            } else {
                $mime[] = $this->EncodeFile($path, $encoding);

                if($this->IsError()) {
                	return "";
                }
                $mime[] = $this->LE.$this->LE;
            }
        }
        $mime[] = sprintf("--%s--%s", $this->boundary[1], $this->LE);

        return join("", $mime);
    }

	/**
	 * handles Charset translation for all visual parts of the email.
	 */
	function prepForOutbound() {
		global $locale;

		if($this->preppedForOutbound == false) {
			$this->preppedForOutbound = true; // flag so we don't redo this
			$OBCharset = $locale->getPrecedentPreference('default_email_charset');

			// body text
			$this->Body			= $locale->translateCharset(trim($this->Body), 'UTF-8', $OBCharset);
			$this->AltBody		= $locale->translateCharset(trim($this->AltBody), 'UTF-8', $OBCharset);
            $subjectUTF8		= from_html(trim($this->Subject));
            $subject			= $locale->translateCharset($subjectUTF8, 'UTF-8', $OBCharset);
            $this->Subject		= $locale->translateCharsetMIME($subjectUTF8, 'UTF-8', $OBCharset);

			// HTML email RFC compliance
			if($this->ContentType == "text/html") {
				if(strpos($this->Body, '<html') === false) {
					$head=<<<eoq
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset={$OBCharset}" />
<title>{$subject}</title>
</head>
<body>
eoq;
					$this->Body = $head.$this->Body."</body></html>";
				}
			}

			// Headers /////////////////////////////////
			// the below is done in PHPMailer::CreateHeader();
			//$this->Subject			= $locale->translateCharsetMIME(trim($this->Subject), 'UTF-8', $locale->getPrecedentPreference('default_email_charset'));
			$this->FromName		= $locale->translateCharsetMIME(trim($this->FromName), 'UTF-8', $OBCharset);
			foreach($this->ReplyTo as $k => $v) {
				$this->ReplyTo[$k][1] = $locale->translateCharsetMIME(trim($v[1]), 'UTF-8', $OBCharset);
			}
			// TO: fields
			foreach($this->to as $k => $toArr) {
				$this->to[$k][1]	= $locale->translateCharsetMIME(trim($toArr[1]), 'UTF-8', $OBCharset);
			}
			// CC: fields
			foreach($this->cc as $k => $ccAddr) {
				$this->cc[$k][1]	= $locale->translateCharsetMIME(trim($ccAddr[1]), 'UTF-8', $OBCharset);
			}
			// BCC: fields
			foreach($this->bcc as $k => $bccAddr) {
				$this->bcc[$k][1]	= $locale->translateCharsetMIME(trim($bccAddr[1]), 'UTF-8', $OBCharset);
			}

			// attachment names
			/*
			 * $this->attachment[$cur][1] = $filename;
			 * $this->attachment[$cur][2] = $name;
			 */
			foreach($this->attachment as $k => $attachment) {
				$this->attachment[$k][1] = $locale->translateCharset(trim($this->attachment[$k][1]), 'UTF-8', $OBCharset);
				$this->attachment[$k][2] = $locale->translateCharset(trim($this->attachment[$k][2]), 'UTF-8', $OBCharset);
			}
		}
	}

	/**
	 * @param notes	array of note beans
	 */
	function handleAttachments($notes) {
		if (empty($notes)) {
			return;
		}

		// cn: bug 4864 - reusing same SugarPHPMailer class, need to clear attachments
		$this->ClearAttachments();
		require_once('include/upload_file.php');

		foreach($notes as $note) {
				$mime_type = 'text/plain';
				$file_location = '';
				$filename = '';

				if($note->object_name == 'Note') {
					if (! empty($note->file->temp_file_location) && is_file($note->file->temp_file_location)) {
						$file_location = $note->file->temp_file_location;
						$filename = $note->file->original_file_name;
						$mime_type = $note->file->mime_type;
					} else {
						$file_location = rawurldecode(UploadFile::get_file_path($note->filename,$note->id));
						$filename = $note->id.$note->filename;
						$mime_type = $note->file_mime_type;
					}
				} elseif($note->object_name == 'DocumentRevision') { // from Documents
					$filename = $note->id.$note->filename;
					$file_location = getcwd().'/cache/upload/'.$filename;
					$mime_type = $note->file_mime_type;
				}

				$filename = substr($filename, 36, strlen($filename)); // strip GUID	for PHPMailer class to name outbound file
				$this->AddAttachment($file_location, $filename, 'base64', $mime_type);
			}
	}

	/**
	 * overloads class.phpmailer's SetError() method so that we can log errors in sugarcrm.log
	 *
	 */
	function SetError($msg) {
		$GLOBALS['log']->fatal("SugarPHPMailer encountered an error: {$msg}");
		parent::SetError($msg);
	}
} // end class definition
