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
        if (confirm('ต้องการยกเลิกจากจองใช้หรือไม่')) {

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
                    if (result == 'success') {
                        alert("ยกเลิกการจองสำเร็จ");
                        location.reload();
                    } else {
                        alert("ไม่สามารถยกเลิกได้ เนื่องเกินเวลาที่กำหนดไว้");
                        location.reload();

                    }
                },
                error: function(jqXHR, statusText, error) {
                    alert('ยกเลิกการจองสนามไม่สำเร็จ')
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
                    <input type="hidden" name="id_cm" value="<?php echo $ID; ?>" required>
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
                        <input id="timeStart" type="time" name="timeStart_reserv" value="00:00" class="form-control" required>
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
                    <label class="form-control-label">ใช้งานสนามได้ถึงเวลา</label>
                    <input id="timeEnd" type="text" disabled type="time" name="timeEnd_reserv" value="00:00" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">จองสนาม</button>
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
                    if (result == 'success') {
                        alert('จองสนามสำเร็จ');
                        // $('#form-reserve').trigger("reset");
                        location.reload(true);
                    } else if (result == 'errorT') {
                        alert("กรุณาเลือกวันในอนาคต");
                    } else {
                        alert("มีลูกค้าจองสนามล่วงหน้าแล้ว");
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
        var value = $(this).val();

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
        } else if (gHS == 22) {
            $("#timeEnd").val('23:59');
        } else {
            alert("กรุณาเลือกเวลา 08:00 - 22:59")
            $(this).val("");
            $("#timeEnd").val('');
        }
    })


    $(document).ready(function() {
        $("#dataStarts").val(convert(new Date()));

    })
</script>