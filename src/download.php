<?php
include "connect.php";

$no = $_GET['no']; // view 에서 받음

$query = "SELECT `name_orig`, `name_save` FROM `todo_file` WHERE `no` = ".$no;

$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$filename = $row['name_save']; // data 디렉토리에 저장된 암호화된 이름
$file = "./data/".$filename;

$dname = $row['name_orig']; // 실제 파일 이름
echo $file;
echo $dname;

if (is_file($file)) {

    if (preg_match("MSIE", $_SERVER['HTTP_USER_AGENT'])) {
        header("Content-type: application/octet-stream");
        header("Content-Length: ".filesize("$file"));
        header("Content-Disposition: attachment; filename=$dname");
        header("Content-Transfer-Encoding: binary");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: public");
        header("Expires: 0");
    }
    else {
        header("Content-type: file/unknown");
        header("Content-Length: ".filesize("$file"));
        header("Content-Disposition: attachment;  filename=$dname");
        header("Content-Description: PHP3 Generated Data");
        header("Pragma: no-cache");
        header("Expires: 0");
    }
	ob_clean();
	flush();
	readfile($file);
}
else {
    echo "해당 파일이 없습니다.";
}



