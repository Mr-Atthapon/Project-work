<?php
date_default_timezone_set('Asia/Bangkok');

include_once('../../config/connectdb.php');
$result = new stdClass();

$key = $_POST["key"] !== "" ? $_POST["key"] : null;


if (isset($_POST['key']) && $_POST['key'] == 'edit_admin_cl') {

    $values = $_POST['data'];

    $id_ad = $values['id_ad'];
    $name_ad = $values['name_ad'];
    $uname_ad = $values['uname_ad'];
    $pass_ad = $values['pass_ad'];


    $sql_update = "UPDATE `admin` SET `name_ad` = '$name_ad', `uname_ad` = '$uname_ad', `pass_ad` = '$pass_ad' WHERE `admin`.`id_ad` = $id_ad;";
    if (DB::query($sql_update)) {
        $result->msg = 'success';
        $result->msg_text = "แก้ไขข้อมูลส่วนตัวสำเร็จ";
        getOutputJson($result);
    } else {
        $result->msg = 'error';
        $result->msg_text = "ไม่สามารถแก้ไขข้อมูลส่วนตัวได้";
        getOutputJson($result);
    }
}
