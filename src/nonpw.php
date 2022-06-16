<?php
include "connect.php";

$query = mysqli_query($con, "SELECT `idx`, `id` FROM `todo`");
$rows = mysqli_fetch_assoc($query);

print_r($_GET);
?>
<!DOCTYPE html>
<html>
<head>

</head>
<body>
	<?php
	// 글에 저장된 id와 다른 id로 로그인
	if($_SESSION['userid']) {
		alert("회원님의 글이 아닙니다!", "list.php");
	} else if($rows['id']){//회원 글	
		alert("로그인 하세요!", "login.php");
	} else {// 비회원
	?>
	<form method="post" action="view.php">
		<table>
			<tr>
				<td><h3>비밀번호를 입력하세요.</h3></td>
			</tr>
			<tr>
				<td><input type="password" name="nonpw"></td>
			</tr>
			<input type="hidden" name="nonidx" value=<?=$_GET['idx']?>>
		</table>
	</form>
	<?php
	}
	?>
</body>
</html>