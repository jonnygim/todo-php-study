<?php
include "connect.php";

//넘어온 idx 는 con_num 에 저장
//넘어온 content 는 content 에 저장
// date,`reg_date` = NOW()"
// name은 세션 id로 저장

$post = [];
foreach($_POST as $key => $value) {
	$post[$key] = $value;
}
unset($_POST);
echo "dd";

print_r($post);

$bno = $_GET['idx'];

if($_SESSION['userid']) {
	$username = $_SESSION['userid'];
} else {
	$username = "비회원";
}

if($post['re_reply']) {

}
$ddd = [seq]
if(  >1 ) seq++
exit;

if($post['idx'] && $post['re_reply']) { // 대댓글
	$query = "INSERT INTO `reply` SET `con_num` = '".$bno."', `name` = '".$username."', `content` = '".$post['content']."', `date` = NOW(), `parent` = '".$post['idx']."', `seq` = 1";


	$query = "UPDATE `reply` SET `content` = '".$post['content']."' WHERE `idx` = ".$post['idx'];
} else { // 신규 seq = 1
	$query = "INSERT INTO `reply` SET `con_num` = '".$bno."', `name` = '".$username."', `content` = '".$post['content']."', `date` = NOW(), `parent` = null, `seq` = 1";
}

if(mysqli_query($con, $query)) {
	echo "<script>location.replace('view.php?idx=".$bno."#commentBox');</script>";
}


/*
if($bno && $username && $_POST['content']){
	$query = mysqli_query($con, "INSERT INTO `reply` SET `con_num` = '".$bno."', `name` = '".$username."', `content` = '".$_POST['content']."', `date` = NOW()");
	alert("댓글을 작성했습니다.", "view.php?idx=".$_GET['idx']);
} else {
	echo "<script>alert('로그인 하세요.'); history.back();</script>";
}
*/