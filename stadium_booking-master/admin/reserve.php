<!DOCTYPE html>
<html lang="zxx" class="no-js">
<?php include_once __DIR__ . './head.php'; ?>
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
                // $('#reserve_table').modal('show');
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
    <?php include_once __DIR__ . './header.php'; ?>

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
                        <a href="่#">ปฏิทินการจอง</a>
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
                    <button class="btn btn-sm btn-primary" onclick="$('#edit_stadium').modal('show');">แก้ไขข้อมูล</button>

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



    <?php include_once __DIR__ . './footer.php'; ?>



    <div class="modal fade" id="edit_stadium" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form id="form-edit_stadium" action="javascript:void(0)" method="POST">
                    <input type="hidden" name="id_stadium" value="<?php echo $data_stadium->id_stadium ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มสนาม</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="form-control-label">ชื่อสนาม</label>
                            <input type="text" name="name_stadium" class="form-control" required value="<?php echo $data_stadium->name_stadium ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">รายเอียดสนาม</label>
                            <textarea row="4" name="details_stadium" class="form-control" required><?php echo $data_stadium->details_stadium ?></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label">เลือกรูป</label>
                            <input id="img_stadium" type="file" class="form-control" accept="image/*">
                            <input name="img_stadium" value="<?php echo $data_stadium->img_stadium ?>" type="hidden">
                        </div>

                        <script>
                            $("input[id=img_stadium]").on("change", (e) => {
                                var base64StringImg_show = null;

                                const file = e.target.files[0];

                                const reader = new FileReader();
                                reader.onloadend = (e) => {
                                    var img = document.createElement("img");
                                    img.onload = function(event) {
                                        // Dynamically create a canvas element
                                        var canvas = document.createElement("canvas");
                                        canvas.width = 600;
                                        canvas.height = 600;
                                        // var canvas = document.getElementById("canvas");
                                        var ctx = canvas.getContext("2d");
                                        // Actual resizing
                                        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                                        // Show resized image in preview element
                                        var dataurl = canvas.toDataURL(file.type);
                                        // document.getElementById("preview").src = dataurl;

                                        // console.log(dataurl.replace(/^data:image\/(png|jpg);base64,/, ""));
                                        const base64String_ = dataurl.replace("data:", "").replace(/^.+,/, "");
                                        base64StringImg_show = base64String_;
                                        $("input[name=img_stadium]").val(base64StringImg_show);
                                    };
                                    img.src = e.target.result;
                                };
                                reader.readAsDataURL(file);
                            });
                        </script>


                        <div class="form-group">
                            <label class="form-control-label">จำนวนคนที่รองรับ</label>
                            <input type="number" name="quantity_stadium" class="form-control" required value="<?php echo $data_stadium->quantity_stadium ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">ราคาใช้สนาม/ชม.</label>
                            <input type="number" name="priceHour_stadium" class="form-control" required value="<?php echo $data_stadium->priceHour_stadium ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">สถานะ</label>
                            <select name="status_stadium" class="form-control" required>
                                <option disabled>เลือกสถานะ</option>
                                <option <?php echo $data_stadium->status_stadium == 1 ? "selected" : "" ?> value="1">พร้อมใช้งาน</option>
                                <option <?php echo $data_stadium->status_stadium == 2 ? "selected" : "" ?> value="2">ไม่พร้อมใช้งาน</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="delete_stadium(<?php echo $data_stadium->id_stadium ?>)" class="btn btn-danger">ลบ</button>
                        <button type="submit" class="btn btn-primary">แก้ไขสนาม</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script>
        $("#form-edit_stadium").submit(function() {
            var inputs = $("#form-edit_stadium :input");
            var values = {};
            inputs.each(function() {
                values[this.name] = $(this).val();
            });

            console.log(values);

            $.ajax({
                url: "./controllers/stadium_cl.php",
                type: "POST",
                data: {
                    key: "form-edit_stadium",
                    data: values
                },
                success: function(result, statusText, jqXHR) {

                    console.log(result);
                    const obj = JSON.parse(result);
                    if (obj.msg === "success") {
                        alert("แก้ไขสนามสำเร็จ");
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

        });


        function delete_stadium(id_stadium) {
            if (confirm("คุณต้องการลบสนามนี้ใช้หรือไม่")) {
                $.ajax({
                    url: "./controllers/stadium_cl.php",
                    type: "POST",
                    data: {
                        key: "form-delete_stadium",
                        id_stadium: id_stadium
                    },
                    success: function(result, statusText, jqXHR) {

                        console.log(result);
                        const obj = JSON.parse(result);
                        if (obj.msg === "success") {
                            alert(obj.msg_text);
                            location.assign('./')
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
        }
    </script>

    <!-- End banner Area -->

</body>

</html>