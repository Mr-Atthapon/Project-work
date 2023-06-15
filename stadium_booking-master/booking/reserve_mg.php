<!DOCTYPE html>
<html lang="zxx" class="no-js">
<?php include('./head.php'); ?>
<?php

$stadium_id = isset($_GET["stadium"]) ? $_GET["stadium"] : null;
$stadium_id = 1;
if ($stadium_id === null) {
    // exit;
}

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
                url: "/controllers/getReserve.php?stadium=<?php echo   $stadium_id ?>",
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
                        ข้อมูลการจองสนาม
                    </h1>
                    <p class="text-white link-nav">
                        <a href="./">หน้าหลัก</a>
                        <span class="lnr lnr-arrow-right"></span>
                        <a href="">ข้อมูลการจองสนาม</a>
                    </p>
                </div>
            </div>
        </div>
    </section>


    <section class="insurence-one-area section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 order-1 order-lg-0">
                    <div class="sidebar sidebar-left">
                        <h3 class="widget-title">จัดการการจอง</h3>
                        <div class="list-wrap">

                            <ul class="">
                                <!-- <li><a href="#">แก้ไขข้อมูล</a></li> -->
                                <li><a href="javascript:show_div('mgStadium_show')">จัดการการจอง</a></li>
                                <li><a href="javascript:show_div('hi_show')">ประวัติการจอง</a></li>
                                <!-- <li><a href="javascript:show_div('hiC_show')">ประวัติการจองที่ยกเลิก</a></li> -->
                                <!-- hiC_show -->
                            </ul>
                        </div>
                    </div>
                </div>
                <script>
                    $(document).ready(function() {
                        // $("#mgStadium_show").css("display", "block");
                        // update_mgBook_table();
                        // update_hiShow_table();
                        // update_hiCancelShow_table();

                        $.ajax({
                            url: "./plMgStadium_show.php",
                            type: "POST",
                            data: {
                                ID_USER: "<?php echo $ID_USER; ?>",
                            },
                            dataType: "html",
                            success: function(data) {
                                $("#axjShow").html(data);
                            }
                        });
                    });

                    function show_div(id) {
                        $("#axjShow").html('');
                        if (id == 'hi_show') {
                            $.ajax({
                                url: "./plMghi_show.php",
                                type: "POST",
                                dataType: "html",
                                data: {
                                    ID_USER: "<?php echo $ID_USER; ?>",
                                },
                                success: function(data) {
                                    $("#axjShow").html(data);
                                }
                            });
                            // update_hiShow_table();
                        } else if (id == 'mgStadium_show') {
                            $.ajax({
                                url: "./plMgStadium_show.php",
                                type: "POST",
                                data: {
                                    ID_USER: "<?php echo $ID_USER; ?>",
                                },
                                dataType: "html",
                                success: function(data) {
                                    $("#axjShow").html(data);
                                }
                            });
                        } else if (id == 'hiC_show') {
                            $.ajax({
                                url: "./plMghiC_show.php",
                                type: "POST",
                                data: {
                                    ID_USER: "<?php echo $ID_USER; ?>",
                                },
                                dataType: "html",
                                success: function(data) {
                                    $("#axjShow").html(data);
                                }
                            });
                        }
                    }
                </script>

                <div id="axjShow" class="col-lg-9">

                </div>

            </div>

        </div>
    </section>




    <?php include('./footer.php'); ?>


    <!-- End banner Area -->

</body>

</html>