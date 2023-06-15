<?php
$ID_USER = $_POST['ID_USER'];
include('../config/connectdb.php');
?>


<div id="mgStadium_show">
    <div class="post">
        <div class="post-body">
            <div class="entry-header">
                <h2 class="entry-title">
                    <a href="javascript:void(0)">ประวัติการจอง <span style="color: red"></span></a>
                </h2>
            </div><!-- header end -->

            <div class="entry-content">

                <table id="mgBook_table" class="table  table-borderless " style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">ลำดับ</th>
                            <th class="text-center">สนาม</th>
                            <th class="text-center">จำนวนคน</th>
                            <th class="text-center">เวลาจองสนาม</th>
                            <th class="text-center">ระยะเวลาใช้สนาม</th>
                            <th class="text-center">ราคา</th>
                            <th>สถานะ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $thaiweek = array("วันอาทิตย์", "วันจันทร์", "วันอังคาร", "วันพุธ", "วันพฤหัส", "วันศุกร์", "วันเสาร์");
                        $thaimonth = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];

                        $sql_search = "SELECT *,
                                                DATE_FORMAT(rt.date_reserv, '%d') as Dd ,
                                                DATE_FORMAT(rt.date_reserv, '%c') as month ,
                                                DATE_FORMAT(rt.date_reserv, '%Y') as year, 
                                                DATE_FORMAT(rt.timeStart_reserv, '%H : %i ') as timeStart_n ,
                                                DATE_FORMAT(rt.timeEnd_reserv, '%H : %i ') as timeEnd_n 
                                        FROM `reserv_stadium` as rt INNER JOIN stadium as st ON st.id_stadium  = rt.id_stadium  WHERE rt.id_cm  = '$ID_USER' AND rt.status_reserv = 2;";
                        $i_r = null;
                        foreach (DB::query($sql_search, PDO::FETCH_OBJ) as $row) :
                            // $date = 'วันที่ '.$row->Dd.' เดือน'.$thaimonth[$row->month-1].' พ.ศ.'.$row->year+543;
                            $date = '' . $row->Dd . ' ' . $thaimonth[$row->month - 1] . ' ' . (543 + intval($row->year));;
                            $timeStart_reserv = $date . "</br> " . $row->timeStart_n . ' น.';
                            $timeEnd_reserv = $date . "</br> " . $row->timeEnd_n . ' น.';
                        ?>
                            <tr>
                                <td class="text-center"><?php echo ++$i_r; ?></td>
                                <td class=""><?php echo  $row->name_stadium  ?></td>
                                <td class="text-center"><?php echo  $row->quantity_reserv ?> คน</td>
                                <td><?php echo $timeStart_reserv; ?> </td>

                                <td class="text-center"><?php echo $row->sumHour_reserv; ?> ชม.</td>
                                <td class="text-center"><?php echo $row->priceHourSum_reserv; ?> บาท</td>
                                <td>
                                    <?php
                                    echo $row->status_reserv == 2 ? "<span class='badge badge-primary'>สำเร็จ</span>" : "<span class='badge badge-primary'>ยืนยันแล้ว</span>";
                                    ?>

                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <script>
                    function update_mgBook_table() {
                        $('#mgBook_table').DataTable({
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
                            buttons: []
                        });
                    }

                    update_mgBook_table();
                </script>

            </div>
        </div>
    </div>
    <!-- </div> -->