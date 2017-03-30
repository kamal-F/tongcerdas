<?php
session_start();

if(!$_SESSION['namaq']){
	// kalau login sukses, maka update status tong sampah	
	$logok = true;	
} else {
	// masukan username, pass, idtong
	$logok = false;
}

?>
<table width="300" border="0" align="center" cellpadding="0"
	cellspacing="1" bgcolor="#CCCCCC">
	<tr>
		<form name="form1" method="post" action="./api.php">
			<td>
				<table width="100%" border="0" cellpadding="3" cellspacing="1"
					bgcolor="#FFFFFF">
					<?php 
					if($logok){
					?>
					<tr>
						<td colspan="3"><strong>Member Login </strong></td>
					</tr>
					<tr>
						<td width="78">Nama</td>
						<td width="6">:</td>
						<td width="294"><input name="namaq" type="text"
							id="myusername"></td>
					</tr>
					<tr>
						<td>Password</td>
						<td>:</td>
						<td><input name="passwordq" type="password" id="mypassword"></td>
					</tr>
					<tr>
						<td width="78">Nomor Tong</td>
						<td width="6">:</td>
						<td width="294"><input name="idtong" type="text"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><input type="submit" name="Submit" value="Login"></td>
					</tr>
					<?php 
					} else {
					?>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><input type="submit" name="Out" value="Logout"></td>
					</tr>
					<?php 
						}
					?>
				</table>
			</td>
		</form>
	</tr>
</table>