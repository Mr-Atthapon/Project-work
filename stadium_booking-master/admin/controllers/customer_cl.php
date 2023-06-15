<?php
date_default_timezone_set('Asia/Bangkok');

include_once('../../config/connectdb.php');
$result = new stdClass();

$key = $_POST["key"] !== "" ? $_POST["key"] : null;


if (isset($_POST['key']) && $_POST['key'] == 'delete_cu') {

    $id_cm = $_POST['id_cm'];

    $sql_update = "UPDATE `customer` SET `status_cm` = '0' WHERE `customer`.`id_cm` = $id_cm;";
    if (DB::query($sql_update)) {
        $result->msg = 'success';
        $result->msg_text = "ลบข้อมูลลูกค้าสำเร็จ";
        getOutputJson($result);
    } else {
        $result->msg = 'error';
        $result->msg_text = "ไม่สามารถลบข้อมูลลูกค้าได้";
        getOutputJson($result);
    }
}

// form-edit_cu
if (isset($_POST['key']) && $_POST['key'] == 'form-edit_cu') {
    $values = $_POST['data'];

    $id_cm  = $values['id_cm'];
    $idCode_cm =  $values['idCode_cm'];
    $name_cm  = $values['name_cm'];
    $lastname_cm  =  $values['lastname_cm'];
    $tel_cm =  $values['tel_cm'];
    $uname_cm  =  $values['uname_cm'];
    $pass_cm  =  $values['pass_cm'];

    $sql_update = "UPDATE `customer` SET `idCode_cm` = '$idCode_cm',
                                        `name_cm` = '$name_cm',
                                        `lastname_cm` = '$lastname_cm',
                                        `tel_cm` = '$tel_cm',
                                        `uname_cm` = '$uname_cm',
                                        `pass_cm` = '$pass_cm'
                WHERE `customer`.`id_cm` = $id_cm;";
    if (DB::query($sql_update)) {
        $result->msg = 'success';
        $result->msg_text = "แก้ไขข้อมูลลูกค้าสำเร็จ";
        getOutputJson($result);
    } else {
        $result->msg = 'error';
        $result->msg_text = "ไม่สามารถแก้ไขข้อมูลลูกค้าได้";
        getOutputJson($result);
    }
}
