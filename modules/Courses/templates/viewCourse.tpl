<table width="100%" border="0">
  <tr>
    <td>
	<input class="button" name="cmdback" type="button" id="cmdback" value="Back to List" onclick="redirect('index.php?module=Courses&action=listCourses');" />
    
    {if $hasEdit eq 1 }
    <input class="button" name="cmdedit" type="button" id="cmdedit" value="Edit" onclick="redirect('index.php?module=Courses&action=editCourse&courseID={$courseID}');" />
    {/if}
        
    {if $hasDelete eq 1 }
	<input class="button" name="cmddelete" type="button" id="cmddelete" value="Delete" onclick="deleteCourse('{$courseID}');" />
    {/if}
  </tr>
</table>  
<p>
<table class="tabDetailView" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td class="tabDetailViewDL"><slot>Department : </slot></td>      
        <td class="tabDetailViewDF"><slot>{$deptCode} &nbsp; </slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL" width="18%"><slot>Course Code :</slot></td>
        <td class="tabDetailViewDF" width="80%"><slot>{$courseCode} &nbsp; </slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Course Name :</slot></td>
        <td class="tabDetailViewDF"><slot>{$courseName} &nbsp; </slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Dean :</slot></td>
        <td class="tabDetailViewDF"><slot>{$dean} &nbsp; </slot></td>
    </tr>
    <tr>
        <td class="tabDetailViewDL"><slot>Remarks : </slot></td>
        <td class="tabDetailViewDF"><slot>{$remarks} &nbsp; </slot></td>
    </tr>

</table>
</p>