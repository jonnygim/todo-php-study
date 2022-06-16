<?php
include "connect.php";

$no = $_POST['rep_idx'];
$idx = $_POST['idx'];
$edit_rep = $_POST['edit_rep'];

$query = mysqli_query($con, "SELECT * FROM `reply` WHERE `idx` = ".$no);
$rows = mysqli_fetch_assoc($query);

// update
$query = "UPDATE `reply` SET `content` = '".$edit_rep."' WHERE `idx` = '".$no."'";

if(mysqli_query($con, $query)) {
alert("수정되었습니다.", "view.php?idx=".$idx);
}
