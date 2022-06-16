<?php
include "connect.php"
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title>회원가입</title>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
	<form method="post" action="member_ok.php">
		<h1>회원가입</h1>
		<fieldset>
			<legend>입력사항</legend>
			<table>
				<tr>
					<td>아이디 <input type="text" size="35" name="userid" placeholder="아이디"></td>
				</tr>
				<tr>
					<td>비밀번호 <input type="text" size="35" name="userpw" placeholder="비밀번호"></td>
				</tr>
				<tr>
					<td>이름 <input type="text" name="username" placeholder="이름"></td>
				</tr>
				<tr>
					<td>이메일 <input type="text" name="email"> @ 
						<select name="emaddress">
							<option value="naver.com">naver.com</option>
							<option value="daum.net">daum.net</option>
							<option value="gmail.com">gmail.com</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<div id="captcha" class="g-recaptcha" data-sitekey="6LdFWYQbAAAAANEUTLqUoiLFoBUSY-S4YaQJbhO6"></div>
					</td>
				</tr>
			</table>
			<input type="submit" id="btnSub" onclick='return check_recaptcha();' value="가입하기">
		</fieldset>
	</form>
	<script>
			function check_recaptcha(){
				var v = grecaptcha.getResponse();
				if (v.length ==0) {
					alert ("'로봇이 아닙니다.'를 체크해주세요.");
					return false;
				} else {
					location.reload();
					return true;
				}
			}
			</script>
</body>
</html>