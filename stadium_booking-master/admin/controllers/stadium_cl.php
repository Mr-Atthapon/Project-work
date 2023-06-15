<?php
date_default_timezone_set('Asia/Bangkok');

include_once('../../config/connectdb.php');
$result = new stdClass();

$key = $_POST["key"] !== "" ? $_POST["key"] : null;



if (isset($_POST['key']) && $_POST['key'] == 'form-add_stadium') {
    $values = $_POST['data'];

    $name_stadium = $values['name_stadium'];
    $details_stadium  = $values['details_stadium'];
    $status_stadium   = $values['status_stadium'];
    $img_stadium    = $values['img_stadium'];
    $quantity_stadium    = $values['quantity_stadium'];
    $priceHour_stadium    = $values['priceHour_stadium'];


    $dataImage = new stdClass();
    $dataImage->path = "../../assets/img/stadium/";
    $dataImage->base64_code = $img_stadium;



    try {
        $newDataImage = uploadeImageBase64($dataImage); //return stdClass msg,msg_text
        if ($newDataImage->msg === 'success') {
            // echo $newDataImage->msg_text;
            try {
                $sqlText = "INSERT INTO `stadium` (`id_stadium`, `name_stadium`, `details_stadium`, `status_stadium`, `img_stadium`, `quantity_stadium`, `priceHour_stadium`) 
                                            VALUES (NULL, '$name_stadium', '$details_stadium', '$status_stadium', '$newDataImage->nameImge', '$quantity_stadium', '$priceHour_stadium');";
                if (DB::query($sqlText)) {
                    $result->msg = 'success';
                    $result->msg_text = 'เพิ่มสนามสำเร็จ';
                } else {
                    $result->msg = 'error';
                    $result->msg_text = 'เกิดข้อผิดพลาดเกียวกับข้อมูล';
                }
            } catch (Exception $e) {
                $result->msg = 'error';
                $result->msg_text = $e->getMessage();
            }
        } else {
            $result->msg = 'error';
            $result->msg_text = $newDataImage->msg_text;
        }
    } catch (Exception $e) {
        $result->msg = 'error';
        $result->msg_text = $newDataImage->msg_text;
        getOutputJson($result);
        return;
    }

    getOutputJson($result);
    return;
}



if (isset($_POST['key']) && $_POST['key'] == 'form-edit_stadium') {
    $values = $_POST['data'];

    $id_stadium  = $values['id_stadium'];
    $name_stadium = $values['name_stadium'];
    $details_stadium  = $values['details_stadium'];
    $status_stadium   = $values['status_stadium'];
    $img_stadium    = $values['img_stadium'];
    $quantity_stadium    = $values['quantity_stadium'];
    $priceHour_stadium    = $values['priceHour_stadium'];

    $dataImage = new stdClass();
    $dataImage->path = "../../assets/img/stadium/";
    $dataImage->base64_code = $img_stadium;

    $resultPro = DB::query("SELECT * FROM `stadium` WHERE id_stadium ='$id_stadium'", PDO::FETCH_OBJ)->fetch(PDO::FETCH_OBJ);
    try {
        if (strlen($values['img_stadium']) > 40) { //base64_code
            if (strlen($resultPro->img_stadium) < 40) {
                @unlink($dataImage->path . $resultPro->img_stadium);
            }

            $dataImage->base64_code = $values['img_stadium'];
            $img_stadium = uploadeImageBase64($dataImage)->nameImge;
        } else {
            $img_stadium = $values['img_stadium'];
        }
    } catch (Exception $e) {
        $result->msg = "error";
        $result->msg_text = $e->getMessage();
    }

    try {
        $sqlText = "UPDATE `stadium` SET `name_stadium` = '$name_stadium', 
                                        `details_stadium` = '$details_stadium', 
                                        `status_stadium` = '$status_stadium', 
                                        `img_stadium` = '$img_stadium', 
                                        `quantity_stadium` = '$quantity_stadium', 
                                        `priceHour_stadium` = '$priceHour_stadium' 
                                        WHERE `stadium`.`id_stadium` = $id_stadium ;";
        if (DB::query($sqlText)) {
            $result->msg = 'success';
            $result->msg_text = 'แก้ไขสนามสำเร็จ';
        } else {
            $result->msg = 'error';
            $result->msg_text = 'เกิดข้อผิดพลาดเกียวกับข้อมูล';
        }
    } catch (Exception $e) {
        $result->msg = 'error';
        $result->msg_text = $e->getMessage();
    }


    getOutputJson($result);
    return;
}


// form-delete_stadium
if (isset($_POST['key']) && $_POST['key'] == 'form-delete_stadium') {
    $id_stadium = $_POST['id_stadium'];

    $sqlText = "UPDATE `stadium` SET `status_stadium` = '0' WHERE `stadium`.`id_stadium` = $id_stadium ;";
    if (DB::query($sqlText)) {
        $result->msg = 'success';
        $result->msg_text = 'ลบสนามสำเร็จ';
    } else {
        $result->msg = 'error';
        $result->msg_text = 'เกิดข้อผิดพลาดเกียวกับข้อมูล';
    }
    getOutputJson($result);
    return;
}
