<?php
date_default_timezone_set('Asia/Bangkok');

include_once('../../config/connectdb.php');
$result = new stdClass();

$key = $_POST["key"] !== "" ? $_POST["key"] : null;

if (isset($_POST['key']) && $_POST['key'] == 'form-reserve') {
    $values = $_POST['data'];

    $id_cm = $values['id_cm'];
    $id_stadium  = $values['id_stadium'];
    $quantity_reserv = $values['quantity_reserv'];
    $date_reserv = $values['date_reserv'];
    $timeStart_reserv = $values['timeStart_reserv'];
    $timeEnd_reserv = $values['timeEnd_reserv'];
    $priceHourSum_reserv = $values['priceHourSum_reserv'];
    $sumHour_reserv = $values['sumHour_reserv'];


    $dateN = date('Y-m-d');
    $TimeNP = date('H:i', strtotime('+0 minutes'));
    $TimeEP = date('H:i', strtotime('+100 minutes'));

    if ($dateN <=  $date_reserv) {
        $sql_search = "SELECT * FROM reserv_stadium WHERE ((timeStart_reserv BETWEEN '$timeStart_reserv:00' and '$timeEnd_reserv') or (timeEnd_reserv BETWEEN '$timeStart_reserv' and '$timeEnd_reserv:00')) AND id_stadium  = '$id_stadium ' AND date_reserv = '$date_reserv' AND (status_reserv != '2' OR  status_reserv != '3') ";
        $row = DB::query($sql_search, PDO::FETCH_OBJ)->fetch(PDO::FETCH_OBJ);
        if ($row == null) {
            // สามารถจองได้
            $sql_insert = "INSERT INTO `reserv_stadium` (`id_reserv`, `id_cm`, `id_stadium`, `quantity_reserv`, `date_reserv`, `timeStart_reserv`, `timeEnd_reserv`, `createTime_reserv`, `status_reserv`, `priceHourSum_reserv`, `sumHour_reserv`) 
                                                    VALUES (NULL, '$id_cm', '$id_stadium', '$quantity_reserv', '$date_reserv', '$timeStart_reserv', '$timeEnd_reserv', current_timestamp(), '0', '$priceHourSum_reserv', '$sumHour_reserv');";
            if (DB::query($sql_insert)) {
                $result->msg = 'success';
                $result->msg_text = "จองสำเร็จ";
                getOutputJson($result);
            } else {
                $result->msg = 'error';
                $result->msg_text = "ไม่สามารถจองสนามได้";
                getOutputJson($result);
            }
        } else {

            $result->msg = 'error';
            $result->msg_text = "ไม่สามารถจองสนามได้";
            getOutputJson($result);
        }
    } else {
        $result->msg = 'error';
        $result->msg_text = "ไม่สามารถเลือกวันที่ในอดีตได้";
        getOutputJson($result);
    }
}
