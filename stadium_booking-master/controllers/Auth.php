<?php


session_start();

include("../config/connectdb.php");

$result = new stdClass();
$key = $_POST["key"] !== "" ? $_POST["key"] : null;


if ($key !== null && $key === "login-cm") {
    $value = $_POST["data"];

    $uname_cm = $value["uname_cm"];
    $pass_cm = $value['pass_cm'];

    try {
        $row = DB::query("SELECT * FROM `customer` WHERE uname_cm ='$uname_cm' AND status_cm != 0  ;", PDO::FETCH_OBJ)->fetch(PDO::FETCH_OBJ);
        if (isset($row) && $row != null) {
            if ($row->uname_cm === $uname_cm && $row->pass_cm === $pass_cm) {

                $_SESSION["auth"] = true;
                $_SESSION["key"] = "customers";
                $_SESSION["id"] = $row->id_cm;
                $result->msg = "success";
                $result->msg_text = "ยินดีตอนรับเข้าสู่ระบบ";
            } else {
                $result->msg = "error";
                $result->msg_text = "กรุณาตรวจสอบชื่อผู้ใช้หรือรหัสผ่านใหม่อีกครั้ง!!!!!!!!";
            }
        } else {
            $result->msg = "error";
            $result->msg_text = "กรุณาตรวจสอบชื่อผู้ใช้หรือรหัสผ่านใหม่อีกครั้ง!!!!!!!!";
        }
    } catch (Exception $e) {
        $result->msg = 'error';
        $result->msg_text = $e->getMessage();
    }

    getOutputJson($result);
}

if ($key !== null && $key === "form-register-cu") {
    $value = $_POST["data"];


    $idCode_cm = $value["idCode_cm"];
    $name_cm    = $value['name_cm'];
    $lastname_cm = $value['lastname_cm'];
    $uname_cm    = $value['uname_cm'];
    $pass_cm    = $value['pass_cm'];
    $tel_cm    = $value['tel_cm'];


    try {
        foreach (DB::query("SELECT * FROM `customer` WHERE idCode_cm ='$idCode_cm'", PDO::FETCH_OBJ) as $row) {
            if ($row->idCode_cm === $idCode_cm) {
                $result->msg = 'error';
                $result->msg_text = 'ไม่สามรถใช้รหัสประชาชนนี้ได้';
                getOutputJson($result);
                return;
            }
        }
    } catch (Exception $e) {
        $result->msg = 'error';
        $result->msg_text = $e->getMessage();
        getOutputJson($result);
        return;
    }


    try {
        $sqlText = "INSERT INTO `customer` (`id_cm`, `idCode_cm`, `name_cm`, `lastname_cm`, `uname_cm`, `pass_cm`, `tel_cm`, `status_cm`) 
                                    VALUES (NULL, '$idCode_cm', '$name_cm', '$lastname_cm', '$uname_cm', '$pass_cm', '$tel_cm', '1');";
        if (DB::query($sqlText)) {
            $result->msg = 'success';
            $result->msg_text = 'ลงทะเบียนสำเร็จระบบท่านไปหน้าล็อกอิน......';
        } else {
            $result->msg = 'error';
            $result->msg_text = 'เกิดข้อผิดพลาดเกียวกับข้อมูล';
        }
    } catch (Exception $e) {
        $result->msg = 'error';
        $result->msg_text = $e->getMessage();
        getOutputJson($result);
        return;
    }

    getOutputJson($result);
    return;
}


if ($key !== null && $key === "login-ad") {
    $value = $_POST["data"];

    $uname_ad = $value["uname_ad"];
    $pass_ad = $value['pass_ad'];

    try {
        $row = DB::query("SELECT * FROM `admin` WHERE uname_ad ='$uname_ad'  ;", PDO::FETCH_OBJ)->fetch(PDO::FETCH_OBJ);
        if (isset($row) && $row != null) {
            if ($row->uname_ad === $uname_ad && $row->pass_ad === $pass_ad) {

                $_SESSION["auth"] = true;
                $_SESSION["key"] = "admin";
                $_SESSION["id"] = $row->id_ad;
                $result->msg = "success";
                $result->msg_text = "ยินดีตอนรับเข้าสู่ระบบ";
            } else {
                $result->msg = "error";
                $result->msg_text = "กรุณาตรวจสอบชื่อผู้ใช้หรือรหัสผ่านใหม่อีกครั้ง!!!!!!!!";
            }
        } else {
            $result->msg = "error";
            $result->msg_text = "กรุณาตรวจสอบชื่อผู้ใช้หรือรหัสผ่านใหม่อีกครั้ง!!!!!!!!";
            getOutputJson($result);
            return;
        }
    } catch (Exception $e) {
        $result->msg = 'error';
        $result->msg_text = $e->getMessage();
        getOutputJson($result);
        return;
    }

    getOutputJson($result);
    return;
}
