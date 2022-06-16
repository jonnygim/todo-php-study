<?php
include "connect.php";

$rep_no = $_GET['rep_idx'];

$query = "DELETE FROM `reply` WHERE `idx` = ".$rep_no;
if(mysqli_query($con, $query)) alertb("댓글이 삭제되었습니다.");