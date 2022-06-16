<?php
include "connect.php";

$query = mysqli_query($con, "SELECT `idx`, `id` FROM `todo`");
$rows = mysqli_fetch_assoc($query);

print_r($_GET);
?>
<!DOCTYPE html>
<html>
<body>
	<form method="post" action="view.php">
		<table>
			<tr>
				<td><h3>비밀번호를 입력하세요.</h3></td>
			</tr>
			<tr>
				<td><input type="password" name="pw"></td>
			</tr>
			<input type="hidden" name="idx" value=<?=$_GET['idx']?>>
		</table>
	</form>
</body>
</html>