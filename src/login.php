<?php
include "connect.php";
?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8"/>
	<title>로그인</title>
<head>
<body>
	<div id="login_box">
		<h1 align="center">로그인</h1>
		<form method="post" action="login_ok.php">
			<table align="center" height="200" style="border: 1px solid #000">
				<tr>
				<td>ID</td>
				<td><input type="text" name="userid"></td>
				</tr>
				<tr>
				<td>Password</td>
				<td><input type="password" name="userpw"></td>
				</tr>
				<tr>
				<td><input type="submit" value="로그인"></td>
				</tr>
				<tr>
				<td><a href="list.php" name="non">비회원</a></td>
				</tr>
				<tr>
				<td><a href="member.php">회원가입</a></td>
				</tr>
			</table>

		</form>
	</div>
</body>