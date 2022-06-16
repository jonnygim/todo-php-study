<?php
include "connect.php";


if($_POST["userid"] == "" || $_POST["userpw"] == "") {
	echo '<script> alert("아이디나 패스워드 입력하세요"); history.back(); </script>';
} else {
	$password = $_POST['userpw'];
	$query = mysqli_query($con, "SELECT * FROM `todo_member` WHERE id='".$_POST['userid']."'");
	$member = mysqli_fetch_assoc($query);
	$hash_pw = $member['pw'];


	if(password_verify($password, $hash_pw)){
		session_start();
		$_SESSION['userid'] = $member["id"];
		$_SESSION['userpw'] = $member["pw"];
		print_r($_SESSION);

		echo "<script>alert('로그인되었습니다.'); location.href='list.php';</script>";
	} else {
		echo "<script>alert('아이디 혹은 비밀번호를 확인하세요.'); history.back();</script>";
	}
}
?>