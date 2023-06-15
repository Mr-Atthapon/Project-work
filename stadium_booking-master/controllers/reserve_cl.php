<?php
date_default_timezone_set('Asia/Bangkok');
include('../config/connectdb.php');


$result = new stdClass();

$key = $_POST["key"] !== "" ? $_POST["key"] : null;

if ($key !== null && $key ===  'cencel_reserve') {
    $id = $_POST['id'];

    $timeNow = $_POST['timeNow'];
    $timeEn = $_POST['timeEn'];

    $date = date('Y-m-d');
    $TimeNP = date('H:i:00', strtotime('+0 minutes'));
    $TimeEP = date('H:i:00', strtotime('+100 minutes'));


    $sql_search = "SELECT * FROM `reserv_stadium` WHERE id_reserv = '$id'";
    $row_search = DB::query($sql_search, PDO::FETCH_OBJ)->fetch(PDO::FETCH_OBJ);

    if ($row_search->date_reserv >= $date) {
        if (DB::query("UPDATE `reserv_stadium` SET `status_reserv` = '3' WHERE `reserv_stadium`.`id_reserv` = '$id';")) {
            $result->msg = 'success';
            $result->msg_text = "ยกเลิกสำเร็จ";
        } else {
            $result->msg = 'error';
            $result->msg_text = "ไม่สามารถยกเลิกได้";
        }
    } else {
        $result->msg = 'error';
        $result->msg_text = "กรุณาตรวจข้อมูวันที่";
    }
    getOutputJson($result);
}


if (isset($_POST['key']) && $_POST['key'] == 'cencel_reserveAd') {
    $id = $_POST['id'];

    if (DB::query("UPDATE `reserv_stadium` SET `status_reserv` = '3' WHERE `reserv_stadium`.`id_reserv` = '$id';")) {
        $result->msg = 'success';
        $result->msg_text = "ยกเลิกสำเร็จ";
        getOutputJson($result);
    } else {

        $result->msg = 'error';
        $result->msg_text = "ไม่สามารถยกเลิกได้";
        getOutputJson($result);
    }
}

// update_reAd
if (isset($_POST['key']) && $_POST['key'] == 'update_reAd') {
    $id = $_POST['id'];

    if (DB::query("UPDATE `reserv_stadium` SET `status_reserv` = '1' WHERE `reserv_stadium`.`id_reserv` = '$id';")) {
        $result->msg = 'success';
        $result->msg_text = "ยืนยันการจองสำเร็จ";
        getOutputJson($result);
    } else {
        $result->msg = 'error';
        $result->msg_text = "ไม่สามารถยกเลิกได้";
        getOutputJson($result);
    }
}


if (isset($_POST['key']) && $_POST['key'] == 'success_reAd') {
    $id = $_POST['id'];

    if (DB::query("UPDATE `reserv_stadium` SET `status_reserv` = '2' WHERE `reserv_stadium`.`id_reserv` = '$id';")) {
        $result->msg = 'success';
        $result->msg_text = "ยืนยันการชำระเงินสำเร็จ";
        getOutputJson($result);
    } else {

        $result->msg = 'error';
        $result->msg_text = "ไม่สามารถยกเลิกได้";
        getOutputJson($result);
    }
}


if (isset($_POST['key']) && $_POST['key'] == '') {
}
