<?php
include "connect.php";

print_r($_GET);
//view 의 idx필요
$rep_idx = $_GET['rep_idx'];
$idx = $_GET['idx'];

$query = mysqli_query($con, "SELECT * FROM `reply` WHERE `idx` = ".$rep_idx);
$rows = mysqli_fetch_assoc($query);
?>
<body>
<div>
<form method="post" action="reply_edit.php">
<input type="hidden" name="rep_idx" value="<?php echo $rep_idx ?>">
<input type="hidden" name="idx" value="<?php echo $idx ?>">
	<h2>댓글 수정하기</h2>
	<textarea name="edit_rep"></textarea>
</div>
<div>
	<input type="submit" value="저장">
</form>
</div>
</body>