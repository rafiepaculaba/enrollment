<!--start of footer file-->
		</td>
		<!--end of body-->
		
	</tr>
	<tr>
		<td class="aboveFooter" colspan="3"/>
	</tr>
	<tr>
		<td class="footer" bgcolor="#ffcc66" align="center" colspan="3">
		 <!--start of footer-->
		<?php
		if (is_array($modules)) {
			$ctr=0;
			foreach($modules as $key=>$module) {
				echo ' &nbsp;<a class="footerLink" href="index.php?' .$key. '">'.$module.'</a>&nbsp; ';
				$ctr++;
				if ($ctr < count($modules)) {
					echo " | ";
				}
			}
		}
		?>
	    <br>
	    <a href="http://www.emssinc.com" target="_blank" class="copyRightLink">BluMango Technologies Inc.</a> &copy; 2005-2008 All Rights Reserved.<br><div style="display: none;">Server response time: 0.88 seconds.<br>© 2004-2007 <a href="http://www.sugarcrm.com" target="_blank" class="copyRightLink">SugarCRM Inc.</a> All Rights Reserved.<br><a href="http://www.sugarforge.org" target="_blank"><img style="margin-top: 2px;" src="include/images/poweredby_sugarcrm.png" alt="Powered By SugarCRM" border="0" width="106" height="23"></a>
<!--		<a href="http://www.kerrygroup.com/" target="_blank" class="copyRightLink">Kerry Foods Int.&trade;</a> © 2005-2008 All Rights Reserved.-->
	    <!--end end footer-->
		</td>
	</tr>
</tbody>
</table>
</body>
</html>
<!--end of footer file-->