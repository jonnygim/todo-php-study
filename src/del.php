<?php
include "connect.php";
$idx = $_GET['idx'];
$query = "DELETE FROM `todo` WHERE `idx` = ".$idx;
if(mysqli_query($con, $query)) alert("삭제되었습니다.", "list.php");

//print_r($_POST);
//var_dump($_POST);
$idx_chk = $_POST['check'];


if($idx_chk > 0) {
	for($i=0; $i < count($idx_chk); $i++) {
		$query = "DELETE FROM `todo` WHERE `idx` = ".$idx_chk[$i];
		if(mysqli_query($con, $query)) alert("항목이 삭제되었습니다.", "list.php");
	}
	
}