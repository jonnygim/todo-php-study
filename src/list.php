<?php
include "connect.php";
mysqli_query($con, "set names utf8");

if(!isset($_SESSION['userid'])) {
	if($_POST['non']){
	echo '<script>alert("비회원 입니다."); location.href="list.php";</sciript>';
	}
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>TODO LIST</title>
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
	<style>
		#wrapper {
			min-width: 1200px;
			padding: 10px;
		}
		#header {
			color: #04009A;
			background-color: #B5EAEA;
			height: 100px;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		#aside {
			float: right;
			height: 100%;
		}
		#asideHead {
			position: relative;
			padding-left: 80px;
		}
		#container {
			position: relative;
			float: left;
			min-height: 500px;
			height: auto !important;
			margin: 20 0;
			width: 930px;
		}
		#login {
			border: 1px solid #dde7e9;
			width: 235px;
			height: 243px;
		}
		#logout {
			text-align: center;
			font-weight: bold;
			display: block;
			padding: 15px 0;
			color: #a0a0a1;
			border-top: 1px solid #dde7e9;
		}
		#loginBox {
			text-align: center;
			font-weight: bold;
			display: block;
			padding: 15px 0;
			color: #a0a0a1;
			background: gray;
			border-top: 1px solid #dde7e9;
		}
		table{
		    width: 100%;
			border-collapse: collapse;
			border-spacing: 0 5px;
			background: #fff;
			border-top: 1px solid #ececec;
			border-bottom: 1px solid #ececec;
		}
		thead {
			display: table-header-group;
			vertical-align: middle;
			border-color: inherit;
		}
		#tmTable tr:nth-child(even){
			background-color: #f2f2f2;
		}
		th, td {
			padding: 10 5 10 0;
			text-align: center;
		}
		tr:hover {
			border-left: 1px solid blue;
			background-color: #f2f2f2;
		}
		ul {
			margin: 0;
			padding: 0;
			list-style: none;
		}
		li{
			display: block;
			color: #465168;
			line-height: 18px;
			padding: 10px 10px 10px 20px;
		}
		.view_btn{
			margin: 0 30 0 0;
			float: right;
		}
		#footer {
			height: 200px;
		}
		a:link {
			color: #000;
			text-decoration-line: none;
		}
		a:visited {
			text-decoration-line: none;
			color: #000;
		}
		a:hover {
			text-decoration-line: underline;
		}
	</style>
</head>
<body>
<div id="wrapper">
	<div id="header">
		<h1 class="titlec">TODO LIST</h1>
	</div>
	<hr>
	<div id="main_nav">
		<div>
			<ul>
				<li><a href="" target="self">TODO LIST</a></li>
				<li><a href="" target="self"><a href="./webzine/list.php">webzine</a></li>
			</ul>
		</div>
	</div>
	<div id="list_cat">
		<hr>
		<form name="mainList" method="get" action="">
			<!--checkbox-->
			<input type="hidden" name="kind" value="<?php $kind?>">
			<!--카테고리-->
			<select name="category" id="category" onchange="this.form.submit()">
				<option value="">전체</option>
			<?php
			$query = mysqli_query($con, "SELECT `category` FROM `todo` WHERE `category` <> '' GROUP BY `category` ORDER BY `category`");
			while($data = mysqli_fetch_assoc($query)) {
				$selected = $_GET['category'] == $data['category'] ? " selected" : "";
				echo "<option value='".$data['category']."'".$selected.">".$data['category']."</option>";
			} ?>
			</select>
		</form>
	</div>

	<div id="aside">
		<!--로그인-->
		<section id="login" class="login">
			<header id="asideHead">
				<?php
				if(isset($_SESSION['userid'])) {
					echo "<h4>{$_SESSION['userid']} 님<br></h4>"; ?>
			</header>
			<ul>
				<li>포인트</li>
				<li>쪽지</li>
				<li>스크랩</li>
			</ul>
			<footer>
				<a href="logout.php" id="logout">로그아웃</a>
			</footer>
			<?php
			} else { ?>
				<h4>비회원 접속<br></h4>
			</header>
				<ul>
					<li>아이디 찾기</li>
					<li>비밀번호 찾기</li>
					<li><a href="member.php">회원 가입</a></li>
				</ul>
				<footer>
					<a href="login.php" id="loginBox">로그인</a>
				</footer>
			<?php
			}?>
		</section>
	</div>
	<div id="container">
		<table id="tmtable">
			<thead>

					<th><input type="checkbox" id="checkAll" onclick="cAll();"/></th>
					<script>
						function cAll() {
							if ($("#checkAll").is(':checked')) {
								$("input[type=checkbox]").prop("checked", true);
							} else {
								$("input[type=checkbox]").prop("checked", false);
							}
						}
					</script>
					<th scope="col" class="no">번호</th>
					<th scope="col" class="title">제목</th>
					<th scope="col" class="name">작성자</th>
					<th scope="col" class="address">주소</th>
					<th scope="col" class="date">작성일</th>

			</thead>
	<div class="view_btn">
		<a href="write.php">글쓰기</a>
	</div>
			<tbody>
			<?php
			$where = '';
			if($_GET['category']) $where = "WHERE `category` = '".$_GET['category']."'";
			$query = "SELECT * FROM `todo`".$where."ORDER BY `idx` DESC";
			//echo $query;
			$result = mysqli_query($con, $query);
			while($rows = mysqli_fetch_assoc($result)) {
				//echo sprintf("%05d", 2);
				// https://www.php.net/manual/en/datetime.format.php
			?>
			<!--check form-->
			<form method="post" action="del.php" onsubmit="return chkdel();">
                <tr>
					<td><input type="checkbox" name="check[]" value="<?=$rows['idx']?>" class="checkSelect"></td>
                    <td class="no"><?php echo $rows['idx']?></td>
					<td class="title">
						<a href="view.php?idx=<?=$rows['idx']?>"><?php echo mb_strimwidth($rows['title'], 0, 20, "...", "utf-8")?></a>
						<?php
						// 댓글 수 출력
						$query2 = "SELECT * FROM `reply` WHERE `con_num` = ".$rows['idx'];
						$c_result = mysqli_query($con, $query2);
						$row2 = mysqli_num_rows($c_result); // 데이터 총 개수 가져옴
						if($row2) echo "<span style='color: #96BAFF;'>(".$row2.")</span>";
						 ?>
					</td>
                    <td class="name"><?php echo $rows['name']?></td>
					<td><?php echo $rows['category']?></td>
                    <td class="dae"><?php echo date("Y-m-d", strtotime($rows['reg_date']))?></td>
                </tr>
			<?php
            } ?>
				<input type="submit" value="선택 삭제" id="btnRemove"></a>
			</form>
			<script>
				function chkdel() {
					if(confirm("삭제하시겠습니까?")) {
					return true;
					}
				};
			</script>
			</tbody>
		</table>
	</div>
	<div id="footer">
	</div>
</div> <!--wrapper-->
</body>
</html>




<!--
카테고리 관련 작성했던 코드
$selectOption = $data['category'];
$query = mysqli_query($con, "SELECT * FROM `todo` WHERE `category` $_GET['category']."'");
while($cat = mysqli_fetch_assoc($query)) {
<script>
$(function() {
$("#category").change(function() {
	console.log($('option').attr('value'));
	});
});
</script>-->