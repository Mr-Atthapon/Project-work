<!DOCTYPE html>
<html lang="zxx" class="no-js">
<?php include('./head.php'); ?>
<?php

$stadium_id = isset($_GET["stadium"]) ? $_GET["stadium"] : null;
if ($stadium_id === null) {
    // echo "<script>window.history.back(-1);</script>";
    header("Location: ./index");
    exit;
}

$sql_select_stadium = "SELECT * FROM stadium WHERE id_stadium = '$stadium_id' LIMIT 1";
$data_stadium = DB::query($sql_select_stadium, PDO::FETCH_OBJ)->fetch(PDO::FETCH_OBJ);

?>
<?php //include_once('./reserve_model.php'); 
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            timeZone: 'Asia/Bangkok',
            firstDay: 0,
            dateClick: function(info) {
                // alert('Date: ' + info.dateStr);
                // alert('Resource ID: ' + info.resource.id);
                // $("#date-input").val(info.dateStr);

            },
            headerToolbar: {
                left: 'title',
                center: 'dayGridMonth,listWeek',
                right: 'today prev,next'

            },
            locale: 'th',
            initialDate: new Date(),
            editable: false,
            eventLimit: true,
            navLinks: false, // can click day/week names to navigate views
            selectable: true,
            selectMirror: true,
            select: function(arg) {
                $('#reserve_table').modal('show');
                $("#dataStarts").val(convert(arg.start));
                calendar.unselect()
            },
            dayMaxEvents: true, // allow "more" link when too many events
            events: {
                url: "../controllers/getReserve.php?stadium=<?php echo $stadium_id ?>",
                failure: function() {
                    document.getElementById('script-warning').style.display = 'block'
                }
            },
            loading: function(bool) {
                document.getElementById('loading').style.display =
                    bool ? 'block' : 'none';
            },
            eventTimeFormat: { // รูปแบบการแสดงของเวลา เช่น '14:30' 
                hour: '2-digit',
                minute: '2-digit',
                meridiem: false
            }
        });

        calendar.render();
        calendar.setOption('themeSystem', 'lux');
    });
</script>

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


<body>
    <?php include('./header.php'); ?>

    <!-- start banner Area -->
    <section class="about-banner relative">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="about-content col-lg-12">
                    <h1 class="text-white">
                        จองสนาม
                    </h1>
                    <p class="text-white link-nav">
                        <a href="./">หน้าหลัก</a>
                        <span class="lnr lnr-arrow-right"></span>
                        <a href="่javascript:void(0)">ปฏิทินการจอง</a>
                    </p>
                </div>
            </div>
        </div>
    </section>


    <section class="contact-page-area section-gap pb-0">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content col-lg-8">
                    <div class="title text-center">

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="insurence-one-area section-gap pt-0">
        <div class="container ">
            <div class="row">

                <div class="col-lg-6 insurence-left">
                    <h2 class="mb-10">ข้อมูลสนาม</h2>
                    <img class="img-fluid img-one" src="../assets/img/stadium/<?php echo $data_stadium->img_stadium ?>" alt="">
                </div>
                <div class="col-lg-6 insurence-right pt-30">

                    <h1><?php echo $data_stadium->name_stadium ?></h1>

                    <p>
                        <?php echo $data_stadium->details_stadium ?>
                    </p>
                    <div class="list-wrap">
                        <ul>
                            <li>สถานะ :
                                <h5 class='badge  <?php echo $data_stadium->status_stadium == 1 ? "badge-success" : "badge-warning"; ?>'><?php echo $data_stadium->status_stadium == 1 ? "พร้อมใช้งาน" : "ปิดปรับปรุง"; ?></h5>
                            </li>
                            <li>จำนวนคนที่รองรับ : <?php echo $data_stadium->quantity_stadium ?> คน</li>
                            <li>ราคาใช้สนาม/ชม. : <?php echo $data_stadium->priceHour_stadium ?> บาท/ช.ม.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="insurence-one-area section-gap pt-0">
        <div class="container">
            <div class="row ">
                <div class="col-lg-12 insurence-left">
                    <h2 class="mb-10">ปฏิทินการจอง</h2>
                    <div id='script-warning'>
                        <code>php/get-events.php</code> must be running.
                    </div>

                    <div id='loading'>loading...</div>

                    <div id='calendar'></div>
                    <!-- Service1 end -->
                </div>
            </div>
        </div>
    </section>



    <?php include('./footer.php'); ?>



    <div class="modal fade" id="reserve_table" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="form-reserve" action="javascript:void(0)" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">จองสนาม</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_cm" value="<?php echo $ID_USER ?>" required>
                        <input type="hidden" name="id_stadium" value="<?php echo $data_stadium->id_stadium; ?>" required>
                        <div class="form-group">
                            <label class="form-control-label">จำนวนคนทั้งหมด</label>
                            <select class="form-control" name="quantity_reserv" required>
                                <option value="">กรุณาเลือกจำนวนคน</option>
                                <?php for ($i = 1; $i <= 30; $i++) : ?>
                                    <option value="<?php echo $i ?>"><?php echo $i; ?> คน</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">เลือกวันที่จอง</label>
                            <input id="dataStarts" type="date" name="date_reserv" value="" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">เวลาที่ต้องการใช้สนาม</label>
                            <input id="timeStart" type="time" name="timeStart_reserv" value="08:00" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label">ระยะเวลาใช้งานสนาม</label>
                            <select id="sumHour_reserv" class="form-control" name="sumHour_reserv" required>
                                <option value="">กรุณาเลือกระยะเวลาใช้งาน</option>
                                <?php for ($i = 1; $i <= 12; $i++) : ?>
                                    <option value="<?php echo $i ?>"><?php echo $i; ?> ชั่วโมง</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">ใช้งานสนามได้ถึงเวลา</label>
                            <input id="timeEnd" type="text" disabled type="time" name="timeEnd_reserv" value="00:00" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">ราคาเช่าที่ต้องจ่าย</label>
                            <input id="priceHourSum_reserv" disabled type="text" name="priceHourSum_reserv" class="form-control" value="0" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        <button <?php echo $data_stadium->status_stadium == 1 ? "" : "disabled"; ?> type="submit" class="btn  <?php echo $data_stadium->status_stadium == 1 ? "btn-primary" : "btn-danger"; ?>"> <?php echo $data_stadium->status_stadium == 1 ? "จองสนาม" : "กำลังปิดปรับปรุง"; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script>
        $("#form-reserve").submit(function() {
            var inputs = $("#form-reserve :input");
            var values = {};
            inputs.each(function() {
                values[this.name] = $(this).val();
            });


            console.log(values);

            if (confirm("กรุณาตรวจสอบข้อมูลอีกครั้ง ก่อนกดยืนยัน")) {
                $.ajax({
                    url: "./controller/reserve_cl.php",
                    type: "POST",
                    data: {
                        key: "form-reserve",
                        data: values
                    },
                    success: function(result, statusText, jqXHR) {

                        console.log(result);
                        const obj = JSON.parse(result);
                        if (obj.msg === "success") {
                            alert("จองสนามสำเร็จ");
                            location.reload(true);
                        } else if (obj.msg === "error") {
                            alert(obj.msg_text);
                        } else {
                            alert(obj.msg_text);
                        }
                    },
                    error: function(jqXHR, statusText) {
                        alert('จองสนามไม่สำเร็จ กรุณาลองใหม่อีกครั้ง')
                    }
                });
            }

        });

        Date.prototype.addHours = function(h) {
            this.setTime(this.getTime() + (h * 60 * 60 * 1000));
            return this;
        }


        $("#sumHour_reserv").change(function() {
            var value = $("#sumHour_reserv").val();

            var dateTimeStart = new Date($("#dataStarts").val() + ' ' + $("#timeStart").val());
            var gHS = dateTimeStart.getHours();
            var gMS = dateTimeStart.getMinutes();


            var timeEnd_add = new Date(dateTimeStart);
            timeEnd_add.setMinutes(dateTimeStart.getMinutes() + (value * 60));

            var tEgM = "" + timeEnd_add.getMinutes();
            var sNews = tEgM.length == 1 ? "0" + tEgM : tEgM;

            if (gHS >= 8 && gHS <= 21) {

                // $("#timeEnd").val(datetimeAdd.getHours() + ":" + sNew);

                $("#timeEnd").val(timeEnd_add.getHours() + ":" + sNews);

                $("#priceHourSum_reserv").val(<?php echo $data_stadium->priceHour_stadium; ?> * value);


            } else if (gHS == 22) {
                $("#timeEnd").val('23:59');
                $("#priceHourSum_reserv").val(<?php echo $data_stadium->priceHour_stadium; ?> * 1);
            } else {
                alert("กรุณาเลือกเวลา 08:00 - 22:59")
                $(this).val("");
                $("#timeEnd").val('');
                $("#priceHourSum_reserv").val('0');
            }
        })


        $(document).ready(function() {
            $("#dataStarts").val(convert(new Date()));

        })
    </script>

    <!-- End banner Area -->

</body>

</html>