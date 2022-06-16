<?php
include "connect.php";

//회원의 접근인지 비회원의 접근인지 확인
$idx = $_GET['idx'] > 0 ? $_GET['idx'] : $_POST['idx'];

$query = "SELECT * FROM `todo` WHERE `idx` = ".$idx;
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
print_r($_GET);

$hash_pw = $row['pw'];
$password = $_POST['pw'];


//exit;

//비회원 수정 접근
if($_POST['idx']) {
	if(password_verify($password, $hash_pw) == true) {//password_verify(string $password, string $hash): bool
		alert("확인되었습니다.",  "write.php?idx=".$idx);
		//$_SESSION['userpw'] = $member["pw"];
	}else {
		alert("비밀번호를 확인해주세요", "list.php");
	}
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>작성글 보기</title>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=61c714d12bc7d5a4c13d02324bf2cf81&libraries=services"></script>
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
			margin: 0 20 0 20;
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
		.view-memo{
			width: 100px;
			height: 300px;
			padding-top: 20px;
			color: #000000;
		}
		.view-reply {
			margin: 50 0 0 30;
			position: relative;

		}
		.dap-lo {
			padding: 15px 0;
			position: relative;
			border-bottom: 1px solid #f0f0f0;
		}
		#commentBox {
			margin: 50 0 0 30;
		}
		#replyContent {
			width: 900px;
			height: 100px;
		}
		.btn-rep {
			margin: 10 0 10 0;
			float: right;
		}
		footer {
			height: 200px;
		}
		#editDel {
			display: flex;
			flex-direction: row;
			justify-content: flex-end;
		}
		.re-reply {
			float: right;
			margin-top: 30px;
		}
		.date {
			color: #B2B1B9;
			margin-top: 10px;
		}
		.empty {
			padding-bottom: 10px;
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
	<hr>
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
		<form method="post" action="write.php">
				<h2>view</h2>
				<table>
					<tr>
						<th> 제목 </th>
						<td colspan="4" id="viewTitle"><? echo $row['title']?></td>
					</tr>
					<tr>
						<th class="view_name">작성자</th>
						<td colspan="4" id="viewName"><?=$row['name']?></td>
					</tr>
					<tr>
						<th>파일명</th>
						<td colspan="4">
						<?php
							$query = "SELECT `name_orig`, `name_save`, `con_id`, `no` FROM `todo_file` WHERE `con_id` = '".$_GET['idx']."' ORDER BY `reg_date` DESC";
							$result = mysqli_query($con, $query);

							while($rows = mysqli_fetch_assoc($result)) {
								if($rows['con_id'] == $_GET['idx'] || $rows['con_id'] == $_POST['nonidx']) {
									// idx로 넘기기?>
								  <a href="download.php?no=<?= $rows['no'] ?>" target="_blank"><?= $rows['name_orig'] ?></a><br>
								<?php
								}
							} ?>
						</td>
					</tr>
					<tr>
						<th>주소</th>
						<td colspan="4" id="view_address"><?= $row['address']?></td>
					</tr>
					<!--지도-->
					<tr>
						<td colspan="4">
							<div id="map" style="border: 1px solid #000; height: 500px;"></div>
								<script>
									var mapContainer = document.getElementById('map'), // 지도를 표시할 div
										mapOption = {
											center: new kakao.maps.LatLng(33.450701, 126.570667), // 지도의 중심좌표
											level: 3 // 지도의 확대 레벨
										};

									// 지도를 생성합니다
									var map = new kakao.maps.Map(mapContainer, mapOption);

									// 주소-좌표 변환 객체를 생성합니다
									var geocoder = new kakao.maps.services.Geocoder();

									// 주소로 좌표를 검색합니다
									geocoder.addressSearch($("#view_address").text(), function(result, status) {

									// 정상적으로 검색이 완료됐으면
									 if (status === kakao.maps.services.Status.OK) {

										var coords = new kakao.maps.LatLng(result[0].y, result[0].x);

										// 결과값으로 받은 위치를 마커로 표시합니다
										var marker = new kakao.maps.Marker({
											map: map,
											position: coords
										});

										// 인포윈도우로 장소에 대한 설명을 표시합니다
										var infowindow = new kakao.maps.InfoWindow({
											content: '<div style="width:150px;text-align:center;padding:6px 0;">' + $("#view_address").text() + '</div>'
										});
										infowindow.open(map, marker);

										// 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
										map.setCenter(coords);
									}
								});
								</script>
						</td>
					</tr>

					<tr>
						<th>내용</th>
						<td colspan="4" class="view-memo"><?=nl2br($row['memo'])?></td>
					</tr>
					<tr>
						<td><a href="list.php">목록으로</a></td>
						<td><a href="del.php?idx=<?php echo $row['idx']?>" id="btnRemove">삭제</a></td>
						<td>
						<?php
						if($_SESSION['userid'] && $_SESSION['userid'] == $row['id']) { ?>
							<a href="write.php?idx=<?=$row['idx']?>">수정</a>
					<?php
						} else { ?>
							<a href="edit.php?idx=<?=$row['idx']?>">수정</a>
							<?php
						}?>
						</td>
					</tr>
				</table>
		</form>


		<!--댓글 보기-->
			<div class="view-reply">
				<h4>댓글 목록</h4>
				<hr>
				<?php
					$query = mysqli_query($con, "SELECT * FROM `reply` WHERE `con_num` =".$idx);
					$reply_id = $_SESSION['userid'];

					while($rows = mysqli_fetch_assoc($query)){ ?>
						<div class="dap-lo">
							<div><b><?php echo $rows['name'];?></b></div>
							<div id="editDel">
								<a href="reply_del.php?idx=<?php echo $rowsidx;?>&rep_idx=<?= $rows['idx']?>" onclick="return comment_delete();">&nbsp삭제</a>
								<input type="button" class="btn-rep-edit" data-idx="<?=$rows['idx']?>" value="수정">
							</div>
							<div><input type="button" class="re-reply" data-idx="<?=$rows['idx']?>" value="댓글 달기"></div>
							<div class="dap-edit"><?php echo nl2br($rows['content']); ?></div>
							<div class="date"><?php echo $rows['date']; ?></div>
							<div class="empty"></div>
						</div>
					<?php
					}?>
			</div>
			<script>
			$(function(){
				$(".btn-rep-edit").on("click", function() {
					var comment = $("#commentForm")[0],
						idx = $(this).data("idx"),
						content = $(this).parent().siblings(".dap-edit").text();
					$(this).parent().siblings(".empty").append(comment);
					$("#idx").val(idx);
					$("#replyContent").val(content);
					$("#commentBox").html(""); // 원래 있던 댓글 입력 폼은 지우기
				});
			});

			$(function(){
				$(".re-reply").on("click", function() {
					var comment = $("#commentForm")[0],
						idx = $(this).data("idx"),
						reply = 2;
					$(this).parent().siblings(".empty").append(comment);
					$("#idx").val(idx);
					$("#reReply").val(reply);
					$("#commentBox").html("");
				});
			});
			</script>
			<!--댓글 입력-->
			<div id="commentBox">
				<form method="post" id="commentForm" action="reply_ok.php?idx=<?php echo $idx;?>">
				<?php print_r($idx);?>
					<input type="hidden" name="idx" id="idx" value=""> <!--form 전체를 옮겨서 idx값을 받아옴-->
					<input type="hidden" name="re_replay" id="reReply" value="">
					<input type="hidden" name="dat_user" id="repUser" class="rep-user" size="15" value=<?$_SESSION['userid']?>>
					<div>
						<textarea name="content" class="reply-content" id="replyContent" placeholder="댓글 내용을 입력해주세요"></textarea><br>
						<button id="btnRep" class="btn-rep">댓글 입력</button>
					</div>
				</form>
			</div>
	</div>
</div>
<script>
	$(function() {
		$("#btnRemove").on("click", function(e) {
			e.preventDefault();
			if(confirm("삭제하시겠습니까?")) {
				$(location).attr("href", $(this).attr("href"));
			}
		});
	});

	function comment_delete()
	{
		return confirm("이 댓글을 삭제하시겠습니까?");
	}
</script>
<footer>
</footer>
</body>
</html>