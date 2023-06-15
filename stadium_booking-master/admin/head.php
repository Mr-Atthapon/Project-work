<?php 

session_start();
if ((!isset($_SESSION["auth"])) || isset($_SESSION["key"]) && $_SESSION["key"] !== 'admin') {

    $result = new stdClass();
    $result->msg = 'error';
    $result->msg_text = 'เกิดข้อผิดพลาดจัดการสิทธิ์';
    // getOutputJson($result);
    echo "<script>window.history.back(-1);</script>";
    exit;
}

include_once("../config/connectdb.php");

$ID_USER = isset($_SESSION["id"]) ? $_SESSION["id"] : null;
$resultRowUser = DB::query("SELECT * FROM `admin` WHERE id_ad = $ID_USER", PDO::FETCH_OBJ)->fetch(PDO::FETCH_OBJ);




?>


<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <!-- <link rel="icon" type="image/png" href="../images/logo5.png"> -->
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
    
    <style>
        #script-warning {
            display: none;
            background: #eee;
            border-bottom: 1px solid #ddd;
            padding: 0 10px;
            line-height: 40px;
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            color: red;
        }

        #loading {
            display: none;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        #calendar {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 10px;
        }
    </style>
</head>