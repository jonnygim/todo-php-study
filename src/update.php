<?php
include "connect.php";

// 게시글의 idx (입력인지 수정인지 구분하기 위해)
$idx = $_POST['idx'];

// 수정시 체크한 항목 삭제
$idx_file_chk = $_POST['check'];
if($idx_file_chk > 0) {
	for($i=0; $i < count($idx_file_chk); $i++) {
		$query = "DELETE FROM `todo_file` WHERE `no` = ".$idx_file_chk[$i];
		mysqli_query($con, $query);
	}
}

//로그인 상태인지 아닌지 구분
if(isset($_SESSION['userid'])) {
	$name = $_SESSION['userid'];
} else {
	$name = "비회원";
}
$id = $_SESSION['userid'];
$pw = password_hash($_POST['passwd'], PASSWORD_DEFAULT);
$title = $_POST['title'];
$memo = $_POST['memo'];
$address = $_POST['address'];
$data = explode(' ', $_POST['address']); //주소 앞부분 추출

print_r($_POST);

// 작성글 수정 & 신규 등록
if($idx) {
	$query = "UPDATE `todo` SET `title` = '".$title."', `name` = '".$name."', `id` = '".$id."',  `pw` = '".$pw."', `address` = '".$address."', `category` = '".$data[0]."', `memo` = '".$memo."' WHERE `idx` = '".$idx."'";
} else {
	$query = "INSERT INTO `todo` SET `title` = '".$title."', `name` = '".$name."', `id` = '".$id."', `pw` = '".$pw."', `address` = '".$address."', `category` = '".$data[0]."', `memo` = '".$memo."', `reg_date` = NOW();";
}
mysqli_query($con, $query);

// 파일
if(isset($_FILES['upfile']) && $_FILES['upfile']['name'] != "") {
	$cnt = count($_FILES['upfile']['name']);

	for($i = 0; $i < $cnt; $i++) {
		if(isset($_FILES['upfile']['name'][$i]) && $_FILES['upfile']['size'][$i] > 0 ) {
			$file = $_FILES['upfile'];
			$name_orig = $_FILES['upfile']['name'][$i];
			$upload_directory = 'data/'; // 저장할 디렉토리
			$name_save = md5(microtime()) . '.' . $ext;
			$uploadFile = $upload_directory.iconv("UTF-8", "cp949", $name_save);
			$ext = pathinfo($name_orig, PATHINFO_EXTENSION);
			$extArr = array('hwp', 'xls', 'doc', 'xlsx', 'docx', 'pdf', 'jpg', 'gif', 'png', 'ppt', 'pptx');
	//		$uploadOk = 1;
		}
		
		if(!$idx) {
			$idx = mysqli_insert_id($con);
		}
	
		// 파일 신규 등록
		if(move_uploaded_file($_FILES['upfile']['tmp_name'][$i], $uploadFile)) {
			$query = "INSERT INTO `todo_file` SET `name_orig` = '".$name_orig."', `name_save` = '".$name_save."', `con_id` = '".$idx."', `reg_date` = NOW();";
		}
		mysqli_query($con, $query);
	} // --- for 문 ---
	alert("저장되었습니다.", "view.php?idx=".$idx);
}








//		if(!$uploadOk) {
	//		echo "<script>alert('파일이 업로드 되지 않았습니다.'); history.back();</script>";

//var_dump($_FILES);
//exit;
	// 업로드 파일 제한
//	if(file_exists($uploadFile)) {
//		echo "<script>alert('파일이 이미 존재합니다.')</script>";
//		$uploadOk = 0;
//	}
//	if($file['size'] > 400000) {
//		echo "<script>alert('파일 용량이 너무 큽니다.')</script>";
//		$uploadOk = 0;
//	}
//	if(array_search($ext, $extArr) === false) {
//		echo "<script>alert('이 확장자의 파일은 올릴 수 없습니다.')</script>";
//		$uploadOk = 0;
//	}
	



//if(mysqli_query($con, $query)) {
//	if($idx > 0) {
//		$str = "수정";
//	} else {
//		$str = "입력";
//		$idx = mysqli_insert_id($con); // idx 가 없으니 마지막으로 실행된 쿼리문의 id를 가져옴
//	}
//alert($str."되었습니다.", "view.php?idx=".$idx);
//}