<?php
include "connect.php";
?>
<!DOCTYPE html>
<html>
<header>
<?php
echo "<h3>{$_SESSION['userid']} 님 반갑습니다.</h3>";
?>
<a href="logout.php">로그아웃</a>
</header>
</html>
