<?php
$outPutArray =  array();
$stadium_id = isset($_GET["stadium"]) ? $_GET["stadium"] : null;

if ($stadium_id === null) {
    echo json_encode($outPutArray);
    exit;
}

include('../config/connectdb.php');

foreach(DB::query("SELECT * FROM `reserv_stadium` as rs INNER JOIN customer as cu ON cu.id_cm = rs.id_cm WHERE rs.id_stadium='$stadium_id' AND rs.status_reserv != 3 ",PDO::FETCH_OBJ) as $row) {

    $r = new stdClass();
    $r->title = $row->name_cm . " " . $row->lastname_cm;
    $r->start = "$row->date_reserv"."T"."$row->timeStart_reserv"."+07:00";
    $r->end = "$row->date_reserv"."T"."$row->timeEnd_reserv"."+07:00";
    array_push($outPutArray, $r);
}





echo json_encode($outPutArray);
exit;
