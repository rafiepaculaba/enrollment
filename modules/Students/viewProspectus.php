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

global $current_user, $sugar_version, $sugar_config, $image_path;

require_once('config.php');
require_once('include/Sugar_Smarty.php');

require_once('common.php');

require_once('modules/Config/ConfigCol.php');
require_once('modules/Departments/Department.php');
require_once('modules/Courses/Course.php');
require_once('modules/Students/StudentCol.php');
require_once('modules/Subjects/SubjectCol.php');
require_once('modules/Users/User2.php');
require_once('modules/Curriculums/Prerequisite.php');
require_once('modules/Curriculums/CurriculumSubject.php');
require_once('modules/Curriculums/Curriculum.php');
require_once('modules/Grades/TOR.php');
require_once('modules/Schedules/Schedule.php');
require_once('modules/Enrollments/EnrollmentCol.php');
require_once('modules/Enrollments/EnrollmentDetailCol.php');

require_once('modules/Enrollments/OldEnrollmentCol.php');
require_once('modules/Enrollments/OldEnrollmentDetailCol.php');

echo "\n<p>\n";
echo get_module_title($mod_strings['LBL_MODULE_NAME'], $mod_strings['LBL_MODULE_TITLE_COL'], false);
echo "\n</p>\n";
global $theme;

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$sugar_smarty = new Sugar_Smarty();

global $current_user;
$access = new AccessChecker();
$accessCode = $access->getAccessCode("View Col TOR");
if ($access->check_access($current_user->id,$accessCode)) {
    $idno = $_GET['idno'];
    
    $tor = new TOR();
    
    if (!$idno) {
        $msg = "Opps! no Student ID seleted.";
        $sugar_smarty->assign('class', 'errorbox');
        $sugar_smarty->assign('display', 'block');
        $sugar_smarty->assign('msg', $msg );
        echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
    } else {
        
        $config        = new config();
        $enrollment    = new Enrollment();
        $enrollDetail  = new EnrollmentDetail();
        $student       = new Student($idno);
        
        $schYear = $config->getConfig('School Year');
        $semCode = $config->getConfig('Semester');
         
        $failed_grades = $config->getConfig('Failed Grades');
	    $failed_grades = explode("," , $failed_grades);
	    
	    if ($failed_grades) {
	        $data = array();
	        foreach ($failed_grades as $grade) {
	            $data[]=strtoupper(trim($grade));
	        }
	        
	        $failed_grades = $data;
	    }
         
        $sugar_smarty->assign('subjects', $data );
        
        $sugar_smarty->assign('idno', $idno );
        $sugar_smarty->assign('name', $student->lname.", ".$student->fname." ".$student->mname );
        $sugar_smarty->assign('courseName', $student->courseName );
        
        //get curID of student
        $curID = $student->curID;
        
        //display all subjects in curricullum
        $curriculum = new Curriculum($curID);
        
        $sugar_smarty->assign('curID', $curID );
        $sugar_smarty->assign('curName', $curriculum->curName );
        $sugar_smarty->assign('courseID', $curriculum->courseID );
        $sugar_smarty->assign('courseCode', $curriculum->courseCode );
        $sugar_smarty->assign('effectivity', $curriculum->effectivity );
        $sugar_smarty->assign('major', $curriculum->major );
        $sugar_smarty->assign('remarks', $curriculum->remarks );
        // list for subject
        $sugar_smarty->assign('subj11', $curriculum->subjects11 );
        $sugar_smarty->assign('subj11_ctr', count($curriculum->subjects11) );
        $sugar_smarty->assign('subj11_total', $curriculum->getTotalUnits($curriculum->subjects11) );
        $sugar_smarty->assign('subj12', $curriculum->subjects12 );
        $sugar_smarty->assign('subj12_ctr', count($curriculum->subjects12) );
        $sugar_smarty->assign('subj12_total', $curriculum->getTotalUnits($curriculum->subjects12) );
        $sugar_smarty->assign('subj14', $curriculum->subjects14 );
        $sugar_smarty->assign('subj14_ctr', count($curriculum->subjects14) );
        $sugar_smarty->assign('subj14_total', $curriculum->getTotalUnits($curriculum->subjects14) );

        $sugar_smarty->assign('subj21', $curriculum->subjects21 );
        $sugar_smarty->assign('subj21_ctr', count($curriculum->subjects21) );
        $sugar_smarty->assign('subj21_total', $curriculum->getTotalUnits($curriculum->subjects21) );
        $sugar_smarty->assign('subj22', $curriculum->subjects22 );
        $sugar_smarty->assign('subj22_ctr', count($curriculum->subjects22) );
        $sugar_smarty->assign('subj22_total', $curriculum->getTotalUnits($curriculum->subjects22) );
        $sugar_smarty->assign('subj24', $curriculum->subjects24 );
        $sugar_smarty->assign('subj24_ctr', count($curriculum->subjects24) );
        $sugar_smarty->assign('subj24_total', $curriculum->getTotalUnits($curriculum->subjects24) );

        $sugar_smarty->assign('subj31', $curriculum->subjects31 );
        $sugar_smarty->assign('subj31_ctr', count($curriculum->subjects31) );
        $sugar_smarty->assign('subj31_total', $curriculum->getTotalUnits($curriculum->subjects31) );
        $sugar_smarty->assign('subj32', $curriculum->subjects32 );
        $sugar_smarty->assign('subj32_ctr', count($curriculum->subjects32) );
        $sugar_smarty->assign('subj32_total', $curriculum->getTotalUnits($curriculum->subjects32) );
        $sugar_smarty->assign('subj34', $curriculum->subjects34 );
        $sugar_smarty->assign('subj34_ctr', count($curriculum->subjects34) );
        $sugar_smarty->assign('subj34_total', $curriculum->getTotalUnits($curriculum->subjects34) );
        
        $sugar_smarty->assign('subj41', $curriculum->subjects41 );
        $sugar_smarty->assign('subj41_ctr', count($curriculum->subjects41) );
        $sugar_smarty->assign('subj41_total', $curriculum->getTotalUnits($curriculum->subjects41) );
        $sugar_smarty->assign('subj42', $curriculum->subjects42 );
        $sugar_smarty->assign('subj42_ctr', count($curriculum->subjects42) );
        $sugar_smarty->assign('subj42_total', $curriculum->getTotalUnits($curriculum->subjects42) );
        $sugar_smarty->assign('subj44', $curriculum->subjects44 );
        $sugar_smarty->assign('subj44_ctr', count($curriculum->subjects44) );
        $sugar_smarty->assign('subj44_total', $curriculum->getTotalUnits($curriculum->subjects44) );
        
        $sugar_smarty->assign('subj51', $curriculum->subjects51 );
        $sugar_smarty->assign('subj51_ctr', count($curriculum->subjects51) );
        $sugar_smarty->assign('subj51_total', $curriculum->getTotalUnits($curriculum->subjects51) );
        $sugar_smarty->assign('subj52', $curriculum->subjects52 );
        $sugar_smarty->assign('subj52_ctr', count($curriculum->subjects52) );
        $sugar_smarty->assign('subj52_total', $curriculum->getTotalUnits($curriculum->subjects52) );
        $sugar_smarty->assign('subj54', $curriculum->subjects54 );
        $sugar_smarty->assign('subj54_ctr', count($curriculum->subjects54) );
        $sugar_smarty->assign('subj54_total', $curriculum->getTotalUnits($curriculum->subjects54) );      

        
/*to check for equivalency
get all passed subject in the tor with the idno

find out if there's match in the result

if not,
get all equivalency under all subject above*/
        
        
//        FOR 1ST YEAR 1ST SEM
        $ctr = 0;
        $subj11_legend=array();
        if($curriculum->subjects11) {
            foreach ($curriculum->subjects11 as $subj11) {
                $subjID11 = $subj11['subjID'];

                //conds forcurrently enrolled
                unset($where11);
                $where11[0]['enrollments.idno'] = " = '$idno' AND";
                $where11[0]['enrollments.schYear'] = " = '$schYear' AND ";
                $where11[0]['enrollments.semCode'] = " = '$semCode' AND ";
                $where11[0]['enrollments.rstatus'] = " > 0 ";
                $result11   = $enrollment->retrieveAllEnrollments($where11);
                $enID11     = $result11[0]['enID'];
                unset($where11);
                $where11[0]['enID'] = " = '$enID11' AND";
                $where11[0]['subjID'] = " = '$subjID11'";

                if ($tor->checkTORs($subjID11,$idno)) {
					$subj11_legend[$ctr]="clsTaken";
                } else if ($enrollDetail->retrieveAllEnrollmentDetails($where11)) {
                    // check for current enrollment
                    $subj11_legend[$ctr]="clsCurrentEnroll";
                } else {
                	$myTOR = $tor->getTOR($idno);
                	if ($myTOR) {
                		$passed_subjects = "";
                		$r=0;
                		foreach ($myTOR as $row) {
                			if ($r==0) {
            					$passed_subjects .= $row['subjID'];
                			} else {
                				$passed_subjects .= ",".$row['subjID'];
                			}
                			$r++;
                		}
                			
                		if ($passed_subjects) {
	                		if ($tor->checkEquivalence($subjID11,$passed_subjects)) {
	                			$subj11_legend[$ctr]="clsTaken";
	                		}
                		}
                	}
                	
                    // not yet taken - white bg
                }
                $ctr++;
            }
        }
        $sugar_smarty->assign('subj11_legend', $subj11_legend );

        
//        FOR 1ST YEAR 2ND SEM
        $ctr = 0;
        $subj12_legend=array();
        if($curriculum->subjects12) {
            foreach ($curriculum->subjects12 as $subj12) {
                $subjID12 = $subj12['subjID'];

                //conds forcurrently enrolled
                unset($where12);
                $where12[0]['enrollments.idno'] = " = '$idno' AND";
                $where12[0]['enrollments.schYear'] = " = '$schYear' AND ";
                $where12[0]['enrollments.semCode'] = " = '$semCode' AND ";
                $where12[0]['enrollments.rstatus'] = " >0 ";
                $result12 = $enrollment->retrieveAllEnrollments($where12);
                $enID12     = $result12[0]['enID'];
                unset($where12);
                $where12[0]['enID'] = " = '$enID12' AND";
                $where12[0]['subjID'] = " = '$subjID12'";
                
                if ($tor->checkTORs($subjID12,$idno)) {
					$subj12_legend[$ctr]="clsTaken";
                } else if ($enrollDetail->retrieveAllEnrollmentDetails($where12)) {
                    // check for current enrollment
                    $subj12_legend[$ctr]="clsCurrentEnroll";
                } else {
                	$myTOR = $tor->getTOR($idno);
                	if ($myTOR) {
                		$passed_subjects = "";
                		$r=0;
                		foreach ($myTOR as $row) {
                			if ($r==0) {
            					$passed_subjects .= $row['subjID'];
                			} else {
                				$passed_subjects .= ",".$row['subjID'];
                			}
                			$r++;
                		}
                			
                		if ($passed_subjects) {
	                		if ($tor->checkEquivalence($subjID12,$passed_subjects)) {
	                			$subj12_legend[$ctr]="clsTaken";
	                		}
                		}
                	}
                	
                    // not yet taken - white bg
                }
                
                $ctr++;
            }
        }
        $sugar_smarty->assign('subj12_legend', $subj12_legend );
        
//        FOR 1ST YEAR SUMMER
        $ctr = 0;
        $subj14_legend=array();
        if($curriculum->subjects14) {
            foreach ($curriculum->subjects14 as $subj14) {
                $subjID14 = $subj14['subjID'];
                
                //conds forcurrently enrolled
                unset($where14);
                $where14[0]['enrollments.idno'] = " = '$idno' AND";
                $where14[0]['enrollments.schYear'] = " = '$schYear' AND ";
                $where14[0]['enrollments.semCode'] = " = '$semCode' AND ";
                $where14[0]['enrollments.rstatus'] = " >0 ";
                $result14 = $enrollment->retrieveAllEnrollments($where14);
                $enID14     = $result14[0]['enID'];
                unset($where14);
                $where14[0]['enID'] = " = '$enID14' AND";
                $where14[0]['subjID'] = " = '$subjID14'";
                
                if ($tor->checkTORs($subjID14,$idno)) {
					$subj14_legend[$ctr]="clsTaken";
                } else if ($enrollDetail->retrieveAllEnrollmentDetails($where14)) {
                    // check for current enrollment
                    $subj14_legend[$ctr]="clsCurrentEnroll";
                } else {
                	$myTOR = $tor->getTOR($idno);
                	if ($myTOR) {
                		$passed_subjects = "";
                		$r=0;
                		foreach ($myTOR as $row) {
                			if ($r==0) {
            					$passed_subjects .= $row['subjID'];
                			} else {
                				$passed_subjects .= ",".$row['subjID'];
                			}
                			$r++;
                		}
                			
                		if ($passed_subjects) {
	                		if ($tor->checkEquivalence($subjID14,$passed_subjects)) {
	                			$subj14_legend[$ctr]="clsTaken";
	                		}
                		}
                	}
                	
                    // not yet taken - white bg
                }
                $ctr++;
            }
        }
        $sugar_smarty->assign('subj14_legend', $subj14_legend );

        
//        FOR 2ND YEAR 1ST SEM
        $ctr = 0;
        $subj21_legend=array();
        if($curriculum->subjects21) {
            foreach ($curriculum->subjects21 as $subj21) {
                $subjID21 = $subj21['subjID'];
                
                //conds forcurrently enrolled
                unset($where21);
                $where21[0]['enrollments.idno'] = " = '$idno' AND";
                $where21[0]['enrollments.schYear'] = " = '$schYear' AND ";
                $where21[0]['enrollments.semCode'] = " = '$semCode' AND ";
                $where21[0]['enrollments.rstatus'] = " > 0 ";
                $result21 = $enrollment->retrieveAllEnrollments($where21);
                $enID21     = $result21[0]['enID'];
                unset($where21);
                $where21[0]['enID'] = " = '$enID21' AND";
                $where21[0]['subjID'] = " = '$subjID21'";
                
                if ($tor->checkTORs($subjID21,$idno)) {
					$subj21_legend[$ctr]="clsTaken";
                } else if ($enrollDetail->retrieveAllEnrollmentDetails($where21)) {
                    // check for current enrollment
                    $subj21_legend[$ctr]="clsCurrentEnroll";
                } else {
                	$myTOR = $tor->getTOR($idno);
                	if ($myTOR) {
                		$passed_subjects = "";
                		$r=0;
                		foreach ($myTOR as $row) {
                			if ($r==0) {
            					$passed_subjects .= $row['subjID'];
                			} else {
                				$passed_subjects .= ",".$row['subjID'];
                			}
                			$r++;
                		}
                			
                		if ($passed_subjects) {
	                		if ($tor->checkEquivalence($subjID21,$passed_subjects)) {
	                			$subj21_legend[$ctr]="clsTaken";
	                		}
                		}
                	}
                	
                    // not yet taken - white bg
                }
                
                $ctr++;
            }
        }
        $sugar_smarty->assign('subj21_legend', $subj21_legend );        

//        FOR 2ND YEAR 2ND SEM
        $ctr = 0;
        $subj22_legend=array();
        if ($curriculum->subjects22) {
            foreach ($curriculum->subjects22 as $subj22) {
                $subjID22 = $subj22['subjID'];
                
                //conds forcurrently enrolled
                unset($where22);
                $where22[0]['enrollments.idno'] = " = '$idno' AND";
                $where22[0]['enrollments.schYear'] = " = '$schYear' AND ";
                $where22[0]['enrollments.semCode'] = " = '$semCode' AND ";
                $where22[0]['enrollments.rstatus'] = " > 0";
                $result22 = $enrollment->retrieveAllEnrollments($where22);
                $enID22     = $result22[0]['enID'];
                unset($where22);
                $where22[0]['enID'] = " = '$enID22' AND";
                $where22[0]['subjID'] = " = '$subjID22'";
                
                if ($tor->checkTORs($subjID22,$idno)) {
					$subj22_legend[$ctr]="clsTaken";
                } else if ($enrollDetail->retrieveAllEnrollmentDetails($where22)) {
                    // check for current enrollment
                    $subj22_legend[$ctr]="clsCurrentEnroll";
                } else {
                	$myTOR = $tor->getTOR($idno);
                	if ($myTOR) {
                		$passed_subjects = "";
                		$r=0;
                		foreach ($myTOR as $row) {
                			if ($r==0) {
            					$passed_subjects .= $row['subjID'];
                			} else {
                				$passed_subjects .= ",".$row['subjID'];
                			}
                			$r++;
                		}
                			
                		if ($passed_subjects) {
	                		if ($tor->checkEquivalence($subjID22,$passed_subjects)) {
	                			$subj22_legend[$ctr]="clsTaken";
	                		}
                		}
                	}
                	
                    // not yet taken - white bg
                }
                
                $ctr++;
            }
        }
        $sugar_smarty->assign('subj22_legend', $subj22_legend );
        
        
//        FOR 2ND YEAR SUMMER
        $ctr = 0;
        $subj24_legend=array();
        if ($curriculum->subjects24) {
            foreach ($curriculum->subjects24 as $subj24) {
                $subjID24 = $subj24['subjID'];
                
                //conds forcurrently enrolled
                unset($where24);
                $where24[0]['enrollments.idno'] = " = '$idno' AND";
                $where24[0]['enrollments.schYear'] = " = '$schYear' AND ";
                $where24[0]['enrollments.semCode'] = " = '$semCode' AND ";
                $where24[0]['enrollments.rstatus'] = " > 0";
                $result24 = $enrollment->retrieveAllEnrollments($where24);
                $enID24     = $result24[0]['enID'];
                unset($where24);
                $where24[0]['enID'] = " = '$enID24' AND";
                $where24[0]['subjID'] = " = '$subjID24'";
                
                if ($tor->checkTORs($subjID24,$idno)) {
					$subj24_legend[$ctr]="clsTaken";
                } else if ($enrollDetail->retrieveAllEnrollmentDetails($where24)) {
                    // check for current enrollment
                    $subj24_legend[$ctr]="clsCurrentEnroll";
                } else {
                	$myTOR = $tor->getTOR($idno);
                	if ($myTOR) {
                		$passed_subjects = "";
                		$r=0;
                		foreach ($myTOR as $row) {
                			if ($r==0) {
            					$passed_subjects .= $row['subjID'];
                			} else {
                				$passed_subjects .= ",".$row['subjID'];
                			}
                			$r++;
                		}
                			
                		if ($passed_subjects) {
	                		if ($tor->checkEquivalence($subjID24,$passed_subjects)) {
	                			$subj24_legend[$ctr]="clsTaken";
	                		}
                		}
                	}
                	
                    // not yet taken - white bg
                }
                
                $ctr++;
            }
        }
        $sugar_smarty->assign('subj24_legend', $subj24_legend );


//        FOR 3RD YEAR 1ST SEM
        $ctr = 0;
        $subj31_legend=array();
        if($curriculum->subjects31) {
            foreach ($curriculum->subjects31 as $subj31) {
                $subjID31 = $subj31['subjID'];
                
                //conds forcurrently enrolled
                unset($where31);
                $where31[0]['enrollments.idno'] = " = '$idno' AND";
                $where31[0]['enrollments.schYear'] = " = '$schYear' AND ";
                $where31[0]['enrollments.semCode'] = " = '$semCode' AND ";
                $where31[0]['enrollments.rstatus'] = " > 0";
                $result31 = $enrollment->retrieveAllEnrollments($where31);
                $enID31     = $result31[0]['enID'];
                unset($where31);
                $where31[0]['enID'] = " = '$enID31' AND";
                $where31[0]['subjID'] = " = '$subjID31'";
                
                if ($tor->checkTORs($subjID31,$idno)) {
					$subj31_legend[$ctr]="clsTaken";
                } else if ($enrollDetail->retrieveAllEnrollmentDetails($where31)) {
                    // check for current enrollment
                    $subj31_legend[$ctr]="clsCurrentEnroll";
                } else {
                	$myTOR = $tor->getTOR($idno);
                	if ($myTOR) {
                		$passed_subjects = "";
                		$r=0;
                		foreach ($myTOR as $row) {
                			if ($r==0) {
            					$passed_subjects .= $row['subjID'];
                			} else {
                				$passed_subjects .= ",".$row['subjID'];
                			}
                			$r++;
                		}
                			
                		if ($passed_subjects) {
	                		if ($tor->checkEquivalence($subjID31,$passed_subjects)) {
	                			$subj31_legend[$ctr]="clsTaken";
	                		}
                		}
                	}
                	
                    // not yet taken - white bg
                }
                
                $ctr++;
            }
        }
        $sugar_smarty->assign('subj31_legend', $subj31_legend );        
        

//        FOR 3RD YEAR 2ND SEM
        $ctr = 0;
        $subj32_legend=array();
        if ($curriculum->subjects32) {
            foreach ($curriculum->subjects32 as $subj32) {
                $subjID32 = $subj32['subjID'];
                $conds32[0]['idno'] = "= '$idno' AND ";
                $conds32[0]['subjID'] = "= '$subjID32'";
                
                //conds forcurrently enrolled
                unset($where32);
                $where32[0]['enrollments.idno'] = " = '$idno' AND";
                $where32[0]['enrollments.schYear'] = " = '$schYear' AND ";
                $where32[0]['enrollments.semCode'] = " = '$semCode' AND ";
                $where32[0]['enrollments.rstatus'] = " >0 ";
                $result32 = $enrollment->retrieveAllEnrollments($where32);
                $enID32     = $result32[0]['enID'];
                unset($where32);
                $where32[0]['enID'] = " = '$enID32' AND";
                $where32[0]['subjID'] = " = '$subjID32'";
                
                if ($tor->checkTORs($subjID32,$idno)) {
					$subj32_legend[$ctr]="clsTaken";
                } else if ($enrollDetail->retrieveAllEnrollmentDetails($where32)) {
                    // check for current enrollment
                    $subj32_legend[$ctr]="clsCurrentEnroll";
                } else {
                	$myTOR = $tor->getTOR($idno);
                	if ($myTOR) {
                		$passed_subjects = "";
                		$r=0;
                		foreach ($myTOR as $row) {
                			if ($r==0) {
            					$passed_subjects .= $row['subjID'];
                			} else {
                				$passed_subjects .= ",".$row['subjID'];
                			}
                			$r++;
                		}
                			
                		if ($passed_subjects) {
	                		if ($tor->checkEquivalence($subjID32,$passed_subjects)) {
	                			$subj32_legend[$ctr]="clsTaken";
	                		}
                		}
                	}
                	
                    // not yet taken - white bg
                }
                
                $ctr++;
            }
        }
        $sugar_smarty->assign('subj32_legend', $subj32_legend );
        
//        FOR 3RD YEAR SUMMER
        $ctr = 0;
        $subj34_legend=array();
        if ($curriculum->subjects34) {
            foreach ($curriculum->subjects34 as $subj34) {
                $subjID34 = $subj34['subjID'];
                
                //conds forcurrently enrolled
                unset($where34);
                $where34[0]['enrollments.idno'] = " = '$idno' AND";
                $where34[0]['enrollments.schYear'] = " = '$schYear' AND ";
                $where34[0]['enrollments.semCode'] = " = '$semCode' AND ";
                $where34[0]['enrollments.rstatus'] = " >0 ";
                $result34 = $enrollment->retrieveAllEnrollments($where34);
                $enID34     = $result34[0]['enID'];
                unset($where34);
                $where34[0]['enID'] = " = '$enID34' AND";
                $where34[0]['subjID'] = " = '$subjID34'";
                
                if ($tor->checkTORs($subjID34,$idno)) {
					$subj34_legend[$ctr]="clsTaken";
                } else if ($enrollDetail->retrieveAllEnrollmentDetails($where34)) {
                    // check for current enrollment
                    $subj34_legend[$ctr]="clsCurrentEnroll";
                } else {
                	$myTOR = $tor->getTOR($idno);
                	if ($myTOR) {
                		$passed_subjects = "";
                		$r=0;
                		foreach ($myTOR as $row) {
                			if ($r==0) {
            					$passed_subjects .= $row['subjID'];
                			} else {
                				$passed_subjects .= ",".$row['subjID'];
                			}
                			$r++;
                		}
                			
                		if ($passed_subjects) {
	                		if ($tor->checkEquivalence($subjID34,$passed_subjects)) {
	                			$subj34_legend[$ctr]="clsTaken";
	                		}
                		}
                	}
                	
                    // not yet taken - white bg
                }
                
                $ctr++;
            }
        }
        $sugar_smarty->assign('subj34_legend', $subj34_legend );
        
                
//        FOR 4TH YEAR 1ST SEM
        $ctr = 0;
        $subj41_legend=array();
        if ($curriculum->subjects41) {
            foreach ($curriculum->subjects41 as $subj41) {
                $subjID41 = $subj41['subjID'];
                
                //conds forcurrently enrolled
                unset($where41);
                $where41[0]['enrollments.idno'] = " = '$idno' AND";
                $where41[0]['enrollments.schYear'] = " = '$schYear' AND ";
                $where41[0]['enrollments.semCode'] = " = '$semCode' AND ";
                $where41[0]['enrollments.rstatus'] = " >0 ";
                $result41 = $enrollment->retrieveAllEnrollments($where41);
                $enID41     = $result41[0]['enID'];
                unset($where41);
                $where41[0]['enID'] = " = '$enID41' AND";
                $where41[0]['subjID'] = " = '$subjID41'";
                
                if ($tor->checkTORs($subjID41,$idno)) {
					$subj41_legend[$ctr]="clsTaken";
                } else if ($enrollDetail->retrieveAllEnrollmentDetails($where41)) {
                    // check for current enrollment
                    $subj41_legend[$ctr]="clsCurrentEnroll";
                } else {
                	$myTOR = $tor->getTOR($idno);
                	if ($myTOR) {
                		$passed_subjects = "";
                		$r=0;
                		foreach ($myTOR as $row) {
                			if ($r==0) {
            					$passed_subjects .= $row['subjID'];
                			} else {
                				$passed_subjects .= ",".$row['subjID'];
                			}
                			$r++;
                		}
                			
                		if ($passed_subjects) {
	                		if ($tor->checkEquivalence($subjID41,$passed_subjects)) {
	                			$subj41_legend[$ctr]="clsTaken";
	                		}
                		}
                	}
                	
                    // not yet taken - white bg
                }
                
                $ctr++;
            }
        }
        $sugar_smarty->assign('subj41_legend', $subj41_legend );

//        FOR 4TH YEAR 2ND SEM
        $ctr = 0;
        $subj42_legend=array();
        if ($curriculum->subjects42) {
            foreach ($curriculum->subjects42 as $subj42) {
                $subjID42 = $subj42['subjID'];
                
                //conds forcurrently enrolled
                unset($where42);
                $where42[0]['enrollments.idno'] = " = '$idno' AND";
                $where42[0]['enrollments.schYear'] = " = '$schYear' AND ";
                $where42[0]['enrollments.semCode'] = " = '$semCode' AND ";
                $where42[0]['enrollments.rstatus'] = " > 0 ";
                $result42 = $enrollment->retrieveAllEnrollments($where42);
                $enID42     = $result42[0]['enID'];
                unset($where42);
                $where42[0]['enID'] = " = '$enID42' AND";
                $where42[0]['subjID'] = " = '$subjID42'";
                
                if ($tor->checkTORs($subjID42,$idno)) {
					$subj42_legend[$ctr]="clsTaken";
                } else if ($enrollDetail->retrieveAllEnrollmentDetails($where42)) {
                    // check for current enrollment
                    $subj42_legend[$ctr]="clsCurrentEnroll";
                } else {
                	$myTOR = $tor->getTOR($idno);
                	if ($myTOR) {
                		$passed_subjects = "";
                		$r=0;
                		foreach ($myTOR as $row) {
                			if ($r==0) {
            					$passed_subjects .= $row['subjID'];
                			} else {
                				$passed_subjects .= ",".$row['subjID'];
                			}
                			$r++;
                		}
                			
                		if ($passed_subjects) {
	                		if ($tor->checkEquivalence($subjID42,$passed_subjects)) {
	                			$subj42_legend[$ctr]="clsTaken";
	                		}
                		}
                	}
                	
                    // not yet taken - white bg
                }
                
                $ctr++;
            }
        }
        $sugar_smarty->assign('subj42_legend', $subj42_legend );
        
//        FOR 4TH YEAR SUMMER
        $ctr = 0;
        $subj44_legend=array();
        if ($curriculum->subjects44) {
            foreach ($curriculum->subjects44 as $subj44) {
                $subjID44 = $subj44['subjID'];
                
                //conds forcurrently enrolled
                unset($where44);
                $where44[0]['enrollments.idno'] = " = '$idno' AND";
                $where44[0]['enrollments.schYear'] = " = '$schYear' AND ";
                $where44[0]['enrollments.semCode'] = " = '$semCode' AND ";
                $where44[0]['enrollments.rstatus'] = " > 0 ";
                $result44 = $enrollment->retrieveAllEnrollments($where44);
                $enID44     = $result44[0]['enID'];
                unset($where44);
                $where44[0]['enID'] = " = '$enID44' AND";
                $where44[0]['subjID'] = " = '$subjID44'";
                
                if ($tor->checkTORs($subjID44,$idno)) {
					$subj44_legend[$ctr]="clsTaken";
                } else if ($enrollDetail->retrieveAllEnrollmentDetails($where44)) {
                    // check for current enrollment
                    $subj44_legend[$ctr]="clsCurrentEnroll";
                } else {
                	$myTOR = $tor->getTOR($idno);
                	if ($myTOR) {
                		$passed_subjects = "";
                		$r=0;
                		foreach ($myTOR as $row) {
                			if ($r==0) {
            					$passed_subjects .= $row['subjID'];
                			} else {
                				$passed_subjects .= ",".$row['subjID'];
                			}
                			$r++;
                		}
                			
                		if ($passed_subjects) {
	                		if ($tor->checkEquivalence($subjID44,$passed_subjects)) {
	                			$subj44_legend[$ctr]="clsTaken";
	                		}
                		}
                	}
                	
                    // not yet taken - white bg
                }
                
                $ctr++;
            }
        }
        $sugar_smarty->assign('subj44_legend', $subj44_legend );
        
//        FOR 5TH YEAR 1ST SEM
        $ctr = 0;
        $subj51_legend=array();
        if ($curriculum->subjects51) {
            foreach ($curriculum->subjects51 as $subj51) {
                $subjID51 = $subj51['subjID'];
                
                //conds forcurrently enrolled
                unset($where51);
                $where51[0]['enrollments.idno'] = " = '$idno' AND";
                $where51[0]['enrollments.schYear'] = " = '$schYear' AND ";
                $where51[0]['enrollments.semCode'] = " = '$semCode' AND ";
                $where51[0]['enrollments.rstatus'] = " >0 ";
                $result51 = $enrollment->retrieveAllEnrollments($where51);
                $enID51     = $result51[0]['enID'];
                unset($where51);
                $where51[0]['enID'] = " = '$enID51' AND";
                $where51[0]['subjID'] = " = '$subjID51'";
                
                if ($tor->checkTORs($subjID51,$idno)) {
					$subj51_legend[$ctr]="clsTaken";
                } else if ($enrollDetail->retrieveAllEnrollmentDetails($where51)) {
                    // check for current enrollment
                    $subj51_legend[$ctr]="clsCurrentEnroll";
                } else {
                	$myTOR = $tor->getTOR($idno);
                	if ($myTOR) {
                		$passed_subjects = "";
                		$r=0;
                		foreach ($myTOR as $row) {
                			if ($r==0) {
            					$passed_subjects .= $row['subjID'];
                			} else {
                				$passed_subjects .= ",".$row['subjID'];
                			}
                			$r++;
                		}
                			
                		if ($passed_subjects) {
	                		if ($tor->checkEquivalence($subjID51,$passed_subjects)) {
	                			$subj51_legend[$ctr]="clsTaken";
	                		}
                		}
                	}
                	
                    // not yet taken - white bg
                }
                
                $ctr++;
            }
        }
        $sugar_smarty->assign('subj51_legend', $subj51_legend );

//        FOR 5TH YEAR 2ND SEM
        $ctr = 0;
        $subj52_legend=array();
        if ($curriculum->subjects52) {
            foreach ($curriculum->subjects52 as $subj52) {
                $subjID52 = $subj52['subjID'];

                //conds forcurrently enrolled
                unset($where52);
                $where52[0]['enrollments.idno'] = " = '$idno' AND";
                $where52[0]['enrollments.schYear'] = " = '$schYear' AND ";
                $where52[0]['enrollments.semCode'] = " = '$semCode' AND ";
                $where52[0]['enrollments.rstatus'] = " > 0 ";
                $result52 = $enrollment->retrieveAllEnrollments($where52);
                $enID52     = $result52[0]['enID'];
                unset($where52);
                $where52[0]['enID'] = " = '$enID52' AND";
                $where52[0]['subjID'] = " = '$subjID52'";
                
                if ($tor->checkTORs($subjID52,$idno)) {
					$subj52_legend[$ctr]="clsTaken";
                } else if ($enrollDetail->retrieveAllEnrollmentDetails($where52)) {
                    // check for current enrollment
                    $subj52_legend[$ctr]="clsCurrentEnroll";
                } else {
                	$myTOR = $tor->getTOR($idno);
                	if ($myTOR) {
                		$passed_subjects = "";
                		$r=0;
                		foreach ($myTOR as $row) {
                			if ($r==0) {
            					$passed_subjects .= $row['subjID'];
                			} else {
                				$passed_subjects .= ",".$row['subjID'];
                			}
                			$r++;
                		}
                			
                		if ($passed_subjects) {
	                		if ($tor->checkEquivalence($subjID52,$passed_subjects)) {
	                			$subj52_legend[$ctr]="clsTaken";
	                		}
                		}
                	}
                	
                    // not yet taken - white bg
                }
                
                $ctr++;
            }
        }
        $sugar_smarty->assign('subj52_legend', $subj52_legend );
        
//        FOR 5TH YEAR SUMMER
        $ctr = 0;
        $subj54_legend=array();
        if ($curriculum->subjects54) {
            foreach ($curriculum->subjects54 as $subj54) {
                $subjID54 = $subj54['subjID'];
                
                //conds forcurrently enrolled
                unset($where54);
                $where54[0]['enrollments.idno'] = " = '$idno' AND";
                $where54[0]['enrollments.schYear'] = " = '$schYear' AND ";
                $where54[0]['enrollments.semCode'] = " = '$semCode' AND ";
                $where54[0]['enrollments.rstatus'] = " > 0 ";
                $result54 = $enrollment->retrieveAllEnrollments($where54);
                $enID54     = $result54[0]['enID'];
                unset($where54);
                $where54[0]['enID'] = " = '$enID54' AND";
                $where54[0]['subjID'] = " = '$subjID54'";
                
                if ($tor->checkTORs($subjID54,$idno)) {
					$subj54_legend[$ctr]="clsTaken";
                } else if ($enrollDetail->retrieveAllEnrollmentDetails($where54)) {
                    // check for current enrollment
                    $subj54_legend[$ctr]="clsCurrentEnroll";
                } else {
                	$myTOR = $tor->getTOR($idno);
                	if ($myTOR) {
                		$passed_subjects = "";
                		$r=0;
                		foreach ($myTOR as $row) {
                			if ($r==0) {
            					$passed_subjects .= $row['subjID'];
                			} else {
                				$passed_subjects .= ",".$row['subjID'];
                			}
                			$r++;
                		}
                			
                		if ($passed_subjects) {
	                		if ($tor->checkEquivalence($subjID54,$passed_subjects)) {
	                			$subj54_legend[$ctr]="clsTaken";
	                		}
                		}
                	}
                	
                    // not yet taken - white bg
                }
                
                $ctr++;
            }
        }
        $sugar_smarty->assign('subj54_legend', $subj54_legend );

        
        echo $sugar_smarty->fetch('modules/Students/templates/viewProspectus.tpl');
    }
} else {
    $msg = "Sorry, you dont have permission to access this page.";
    $sugar_smarty->assign('class', 'errorbox');
    $sugar_smarty->assign('display', 'block');
    $sugar_smarty->assign('msg', $msg );
    echo $sugar_smarty->fetch('include/blumango/tpl/message.tpl');
}
?>

<script language="javascript">
function hideShowDiv(divName)
{
    if ( $(divName).style.display=="Block" || $(divName).style.display=="block" ) {
        $(divName).style.display="None";
        $(divName+"Handle").src="themes/Sugar/images/advanced_search.gif";
    } else {
        $(divName).style.display="Block";
        $(divName+"Handle").src="themes/Sugar/images/basic_search.gif";
    }
}

</script>