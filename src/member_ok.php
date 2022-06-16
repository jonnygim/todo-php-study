<?php
include "connect.php";

$userid = $_POST['userid'];
$userpw = password_hash($_POST['userpw'], PASSWORD_DEFAULT);
$username = $_POST['username'];
$useremail = $_POST['email']."@".$_POST['emaddress'];

$query = mysqli_query($con, "INSERT INTO `todo_member` SET `id` = '".$userid."', `pw` = '".$userpw."', `name` = '".$username."', `email` = '".$useremail."', `reg_date` = NOW()");
?>
<meta charset="utf-8"/>
<script type="text/javascript">alert('회원가입이 완료되었습니다.');</script>
<meta http-equiv="refresh" content="0 url=login.php">