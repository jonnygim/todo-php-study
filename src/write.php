<?php
include "connect.php";

$idx = $_GET['idx'];
//$idx = mysqli_real_escape_string($con, $idx);
if($idx > 0) {
	$query = "SELECT * FROM `todo` WHERE `idx`=".$idx;
	$result = mysqli_query($con, $query);
	$row = mysqli_fetch_assoc($result);
}?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>글쓰기</title>

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<!-- include libraries(jQuery, bootstrap) -->
<link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
<!-- include summernote css/js-->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.js"></script>

<style>
.table{
	border-collapse: separate;
	border-spacing: 1px;
	text-align: left;
	line-height: 1.5;
	border-top: 1px solid #ccc;
	margin : 20px 10px;
}
.table tr {
	width: 50px;
	padding: 10px;
	font-weight: bold;
	vertical-align: top;
	border-bottom: 1px solid #ccc;
}
.table td {
	width: 100px;
	padding: 10px;
	vertical-align: top;
	border-bottom: 1px solid #ccc;
}
</style>
</head>
<body>
	<form method="post" enctype="multipart/form-data" onsubmit="return formSubmit(this);" action="update.php">
		<input type="hidden" name="idx" value="<?php echo $idx?>">

        <h2 align="center">글쓰기</h2>
        <table class="table">
            <tr>
                <th>제목</th>
                <td colspan="2"><input type="text" name="title" value="<?php echo $row['title']?>" style="width: 100%;" required></td>
            </tr>
			<?php
			if(!isset($_SESSION['userid'])) { ?>
				<tr>
					<th>작성자</th>
					<td colspan="2">비회원</td>
				</tr>
				<tr>
					<th>비밀번호</th>
					<td colspan="2"><input type="password" name="passwd" required></td>
				</tr>
			<?php
			} else { ?>
				<tr>
					<th>작성자</th>
					<td colspan="2"><?php echo $_SESSION['userid']?></td>
				</tr>
			<?php
			} ?>
			<tr>
				<th><label for="upfile">첨부파일</label></th>
				<td><input type="file" name="upfile[]" id="upfile" multiple></td>
				<td>
					파일삭제<br>
					<?php
					$query = "SELECT `no`, `name_orig`FROM `todo_file` WHERE `con_id` = '".$_GET['idx']."' ORDER BY `reg_date` DESC";
					$result = mysqli_query($con, $query);

					while($rows = mysqli_fetch_assoc($result)) {
						if($rows['con_id'] == $_GET['idx'] || $rows['con_id'] == $_POST['nonidx']) { ?>
						<input type="checkbox" name="check[]" value=<?= $rows['no'] ?>><?= $rows['name_orig'] ?><br>
					<?php
						}
					} ?>
				</td>
			</tr>
			<tr>
				<th>주소</th>
				<td colspan="2"><input type="text" name="address" id="address" style="width: 255" value="<?php echo $row['address']?>" readonly>
				<button type="button" id="btnAddress">주소찾기</button>
				</td>
			</tr>
			<script>
				$(function() {
					$("#btnAddress").on("click", function() {
						new daum.Postcode({
						oncomplete: function(data) {
							// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분입니다.
							// 예제를 참고하여 다양한 활용법을 확인해 보세요.
						$("#address").val(data.address);
						}
					}).open();
					});
				});
			</script>
            <tr>
                <th>내용</th>
                <td colspan="2">
                    <textarea name="memo" id="summernote" class="summernote" required><?php echo $row['memo']?></textarea>
                </td>
            </tr>

			<script>
			$('.summernote').summernote({
				height: 300,
				minHeight: null,
				maxHeight: null,
				lang : 'ko-KR',
				onImageUpload: function(files, editor, welEditable) {
					sendFile(files[0], editor, welEditable);
				}
			});
			</script>
            <tr>
                <td colspan="2">
                    <input type="submit" value="저장">
                </td>
				<td>
                    <a href="./list.php">취소</a>
				</td>
            </tr>
        </table>
	</form>
<script type="text/javascript">

function formSubmit(f) {
    // 업로드 할 수 있는 파일 확장자를 제한합니다.
	var extArray = new Array('hwp','xls','doc','xlsx','docx','pdf','jpg','gif','png','txt','ppt','pptx');
	var path = document.getElementById("upfile").value;

	if(path == "") {
		return true;
	}

	var pos = path.indexOf(".");

	if(pos < 0) {
		alert("확장자가 없는파일 입니다.");
		return false;
	}

	var ext = path.slice(path.indexOf(".") + 1).toLowerCase();
	var checkExt = false;

	for(var i = 0; i < extArray.length; i++) {
		if(ext == extArray[i]) {
			checkExt = true;
			break;
		}
	}
	if(checkExt == false) {
		alert("업로드 할 수 없는 파일 확장자 입니다.");
	    return false;
	}
	return true;
}
</script>
</body>
</html>