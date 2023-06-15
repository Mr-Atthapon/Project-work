<?php

// session_start();
// $_SESSION["auth"] = true;
// $_SESSION["key"] = "customers";
// $_SESSION["id"] = $row->id_cm;
session_start();
if ((!isset($_SESSION["auth"])) || isset($_SESSION["key"]) && $_SESSION["key"] !== 'customers') {

    $result = new stdClass();
    $result->msg = 'error';
    $result->msg_text = 'เกิดข้อผิดพลาดจัดการสิทธิ์';
    // getOutputJson($result);
    echo "<script>window.history.back(-1);</script>";
    exit;
}

include("../config/connectdb.php");

$ID_USER = isset($_SESSION["id"]) ? $_SESSION["id"] : null;
$resultRowUser = DB::query("SELECT * FROM `customer` WHERE id_cm = $ID_USER", PDO::FETCH_OBJ)->fetch(PDO::FETCH_OBJ);



?>

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="../assets/img/logo.png">
    <!-- Author Meta -->
    <meta name="author" content="colorlib">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>ระบบจองสนาม</title>


    <link rel="stylesheet" href="../assets/css/linearicons.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/magnific-popup.css">
    <link rel="stylesheet" href="../assets/css/jquery-ui.css">
    <link rel="stylesheet" href="../assets/css/nice-select.css">
    <link rel="stylesheet" href="../assets/css/animate.min.css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.css">
    <link rel="stylesheet" href="../assets/css/main.css">

    <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/vendor/bootstrap.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
    <script src="../assets/js/jquery-ui.js"></script>
    <script src="../assets/js/easing.min.js"></script>
    <script src="../assets/js/hoverIntent.js"></script>
    <script src="../assets/js/superfish.min.js"></script>
    <script src="../assets/js/jquery.ajaxchimp.min.js"></script>
    <script src="../assets/js/jquery.magnific-popup.min.js"></script>
    <script src="../assets/js/jquery.nice-select.min.js"></script>
    <script src="../assets/js/owl.carousel.min.js"></script>
    <script src="../assets/js/mail-script.js"></script>
    <script src="../assets/js/main.js"></script>


    <link href='../plugins/fullcalendar/main.css' rel='stylesheet' />

    <script src='../plugins/fullcalendar/main.js'></script>

    <link rel="stylesheet" type="text/css" href="../plugins/dataTable/datatables.css" />
    <script type="text/javascript" src="../plugins/dataTable/datatables.js"></script>
    <script type="text/javascript" src="../plugins/dataTable/vfs_fonts.js"></script>



    <script>
        function cancel_re(id) {

            var dateTimeStart = new Date();
            var gHS = dateTimeStart.getHours();
            var gMS = dateTimeStart.getMinutes();

            var timeEnd_add = new Date(dateTimeStart);
            timeEnd_add.setMinutes(dateTimeStart.getMinutes() + 100);

            var sde = "" + gMS;
            var sNewse = sde.length == 1 ? "0" + sde : sde;

            var sd = "" + timeEnd_add.getMinutes();
            var sNews = sd.length == 1 ? "0" + sd : sd;

            var timeNo = gHS + ":" + sNewse;
            var timeEn = timeEnd_add.getHours() + ":" + sNews;
            if (confirm('ต้องการยกเลิกการจองใช้หรือไม่')) {

                $.ajax({
                    url: "../controllers/reserve_cl.php",
                    type: "POST",
                    data: {
                        key: "cencel_reserve",
                        id: id,
                        timeNow: timeNo,
                        timeEn: timeEn
                    },
                    success: function(result, statusText, jqXHR) {
                        console.log(result);
                        const obj = JSON.parse(result);
                        if (obj.msg === "success") {
                            alert("ยกเลิกการจองสำเร็จ");
                            location.reload();
                        } else if (obj.msg === "error") {
                            alert(obj.msg_text);
                            location.reload();
                        } else {
                            alert(obj.msg_text);
                            location.reload();
                        }
                    },
                    error: function(jqXHR, statusText, error) {
                        alert('ยกเลิกการจองสนามไม่สำเร็จ')
                        location.reload();
                    }
                });
            }
        }

        function convert(str) {
            var date = new Date(str),
                mnth = ("0" + (date.getMonth() + 1)).slice(-2),
                day = ("0" + date.getDate()).slice(-2);
            return [date.getFullYear(), mnth, day].join("-");
        }
    </script>
</head>