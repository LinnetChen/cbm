<?php
$conn = mysqli_connect("localhost", "root", "", "rco_web");
$msql = "select * from images_upload";
$res = $conn->query('select * from images_upload;');
$i = 0;
$list_arr = array();
while ($list = mysqli_fetch_array($res)) {
    $list_arr[$i] = $list;
    $i++;
}
$host = $_SERVER['HTTP_HOST'];
?>
