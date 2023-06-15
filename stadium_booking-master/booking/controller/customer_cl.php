<?php
date_default_timezone_set('Asia/Bangkok');

include_once('../../config/connectdb.php');
$result = new stdClass();

$key = $_POST["key"] !== "" ? $_POST["key"] : null;


if (isset($_POST['key']) && $_POST['key'] == 'edit_customer_cl') {

    $values = $_POST['data'];

    $id_cm = $values['id_cm'];
    $idCode_cm = $values['idCode_cm'];
    $name_cm = $values['name_cm'];
    $lastname_cm = $values['lastname_cm'];
    $uname_cm = $values['uname_cm'];
    $pass_cm = $values['pass_cm'];
    $tel_cm = $values['tel_cm'];

    $sql_update  = "UPDATE `customer` SET `idCode_cm` = '$idCode_cm', 
                                            `name_cm` = '$name_cm', 
                                            `lastname_cm` = '$lastname_cm', 
                                            `uname_cm` = '$uname_cm', 
                                            `tel_cm` = '$tel_cm', 
                                            `pass_cm` = '$pass_cm' 
                                WHERE `customer`.`id_cm` = '$id_cm';";

    $sql_search_idCode = "SELECT * FROM `customer` WHERE idCode_cm = '$idCode_cm' AND id_cm != '$id_cm'";

    $row_search = DB::query($sql_search_idCode, PDO::FETCH_OBJ)->fetch(PDO::FETCH_OBJ);

    if ($row_search == null) {
        if (DB::query($sql_update)) {
            $result->msg = 'success';
            $result->msg_text = "แก้ไขข้อมูลส่วนตัวสำเร็จ";
            getOutputJson($result);
        } else {
            $result->msg = 'error';
            $result->msg_text = "ไม่สามารถแก้ไขข้อมูลส่วนตัวได้";
            getOutputJson($result);
        }
    } else {
        $result->msg = 'error';
        $result->msg_text = "ไม่สามารถแก้ไขข้อมูลส่วนตัวได้";
        getOutputJson($result);
    }
}

if (isset($_POST['key']) && $_POST['key'] == '') {
}
