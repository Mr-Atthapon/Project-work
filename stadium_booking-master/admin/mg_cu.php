<!DOCTYPE html>
<html lang="zxx" class="no-js">
<?php include_once __DIR__ . './head.php'; ?>
<?php

$stadium_id = isset($_GET["stadium"]) ? $_GET["stadium"] : null;
$stadium_id = 1;
if ($stadium_id === null) {
    // exit;
}

?>

</style>


<body>
    <?php include_once __DIR__ . './header.php'; ?>

    <!-- start banner Area -->
    <section class="about-banner relative">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="about-content col-lg-12">
                    <h1 class="text-white">
                        จัดการข้อมูลลูกค้า
                    </h1>
                    <p class="text-white link-nav">
                        <a href="./">หน้าหลัก</a>
                        <span class="lnr lnr-arrow-right"></span>
                        <a href="">ข้อมูลลูกค้า</a>
                    </p>
                </div>
            </div>
        </div>
    </section>


    <section class="insurence-one-area section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="entry-header">
                        <h2 class="entry-title">
                            <a href="javascript:void(0)">จัดการข้อมูลลูกค้า <span style="color: red"></span></a>
                        </h2>
                    </div><!-- header end -->

                    <div class="entry-content">

                        <table id="mg_cuTable" class="table  table-borderless " style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">ลำดับ</th>
                                    <th class="text-center">รหัสประชาชน</th>
                                    <th class="text-center">ชื่อ - สกุล</th>
                                    <th class="text-center">เบอร์โทร</th>
                                    <th class="text-center">ชื่อผู้ใช้</th>
                                    <th>จัดการ</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $i = 1;
                                foreach (DB::query("SELECT * FROM `customer` WHERE status_cm != 0", PDO::FETCH_OBJ) as $row) :
                                ?>
                                    <tr>
                                        <th class="text-center"><?php echo $i++ ?></th>
                                        <th class="text-center"><?php echo $row->idCode_cm ?></th>
                                        <th class="text-center"><?php echo $row->name_cm . " " . $row->lastname_cm ?></th>
                                        <th class="text-center"><?php echo $row->tel_cm ?></th>
                                        <th class="text-center"><?php echo $row->uname_cm ?></th>
                                        <td>
                                            <a href="javascript:edit_cu(<?php echo $row->id_cm ?>)" class="badge badge-warning">แก้ไข</a>
                                            <a href="javascript:delete_cu(<?php echo $row->id_cm ?>)" class="badge badge-danger">ลบ</a>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>


                            </tbody>
                        </table>
                        <script>
                            function update_mg_cuTable() {
                                $('#mg_cuTable').DataTable({
                                    dom: 'lBfrtip',
                                    // select: true,
                                    lengthMenu: [
                                        [10, 25, 50, 60, -1],
                                        [10, 25, 50, 60, "All"]
                                    ],
                                    language: {
                                        sProcessing: "กำลังดำเนินการ...",
                                        sLengthMenu: "แสดง  _MENU_  แถว",
                                        sZeroRecords: "ไม่พบข้อมูล",
                                        sInfo: "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
                                        sInfoEmpty: "แสดง 0 ถึง 0 จาก 0 แถว",
                                        sInfoFiltered: "(กรองข้อมูล _MAX_ ทุกแถว)",
                                        sInfoPostFix: "",
                                        sSearch: "ค้นหา: ",
                                        sUrl: "",
                                        oPaginate: {
                                            "sFirst": "เริ่มต้น",
                                            "sPrevious": "ก่อนหน้า",
                                            "sNext": "ถัดไป",
                                            "sLast": "สุดท้าย"
                                        }
                                    }, // sInfoEmpty: "แสดง 0 ถึง 0 ของ 0 เร็คคอร์ด",
                                    processing: true, // แสดงข้อความกำลังดำเนินการ กรณีข้อมูลมีมากๆ จะสังเกตเห็นง่าย
                                    //serverSide: true, // ใช้งานในโหมด Server-side processing
                                    // กำหนดให้ไม่ต้องการส่งการเรียงข้อมูลค่าเริ่มต้น จะใช้ค่าเริ่มต้นตามค่าที่กำหนดในไฟล์ php
                                    retrieve: true,
                                    buttons: [{
                                        extend: 'print',
                                        text: 'พิมพ์',
                                        messageTop: '',

                                        filename: function() {
                                            return "ข้อมูลลูกค้า"; //+hour+'-'+minutes + '-'+days +'-'+month +'-'+years
                                        },
                                        // title: 'รายชื่อสิทเข้าห้อง',
                                        exportOptions: {
                                            pageSize: 'LEGAL'
                                        }
                                    }]
                                });
                            }

                            update_mg_cuTable();

                            function edit_cu(id_cm) {

                                $("#show_model_edit_cu").html();

                                $.ajax({
                                    url: "./model_edit_cu.php",
                                    type: "POST",
                                    data: {
                                        key: "delete_cu",
                                        id_cm: id_cm
                                    },
                                    success: function(result, statusText, jqXHR) {
                                        $("#show_model_edit_cu").html(result);
                                        $('#model_edit_cu').modal('show');
                                    },
                                    error: function(jqXHR, statusText) {
                                        alert('ตรวจพบข้อผิดพลาดกรุณาลองใหม่อีกครั้ง')
                                    }
                                });

                            }


                            function delete_cu(id_cm) {

                                $.ajax({
                                    url: "./controllers/customer_cl.php",
                                    type: "POST",
                                    data: {
                                        key: "delete_cu",
                                        id_cm: id_cm
                                    },
                                    success: function(result, statusText, jqXHR) {
                                        console.log(result);
                                        const obj = JSON.parse(result);
                                        if (obj.msg === "success") {
                                            alert(obj.msg_text);
                                            location.reload(true);
                                        } else if (obj.msg === "error") {
                                            alert(obj.msg_text);
                                        } else {
                                            alert(obj.msg_text);
                                        }
                                    },
                                    error: function(jqXHR, statusText) {
                                        alert('ลบสนามไม่สำเร็จ กรุณาลองใหม่อีกครั้ง')
                                    }
                                });

                            }
                        </script>


                    </div>
                    <!-- </div> -->
                </div>

            </div>
    </section>


    <div id="show_model_edit_cu">


    </div>




    <?php include_once __DIR__ . './footer.php'; ?>


    <!-- End banner Area -->

</body>

</html>