<?php
$id_cm = $_POST['id_cm'];
include('../config/connectdb.php');

$row_result = DB::query("SELECT * FROM `customer` WHERE id_cm = $id_cm  ", PDO::FETCH_OBJ)->fetch(PDO::FETCH_OBJ);




?>
<div class="modal fade" id="model_edit_cu" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="form-edit_cu" action="javascript:void(0)" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขข้อมูล</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_cm" class="form-control" value="<?php echo $row_result->id_cm  ?>" required>
                    <div class="form-group">
                        <label class="form-control-label">รหัสประชาชน</label>
                        <input type="text" name="idCode_cm" class="form-control" value="<?php echo $row_result->idCode_cm ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">ชื่อ</label>
                        <input type="text" name="name_cm" class="form-control" required value="<?php echo $row_result->name_cm ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">นามสกุล</label>
                        <input type="text" name="lastname_cm" class="form-control" required value="<?php echo $row_result->lastname_cm ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">เบอร์โทร</label>
                        <input type="tel" name="tel_cm" class="form-control" required value="<?php echo $row_result->tel_cm ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">ชื่อผู้ใช้</label>
                        <input type="text" name="uname_cm" class="form-control" required value="<?php echo $row_result->uname_cm ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">รหัสผ่าน</label>
                        <input type="password" name="pass_cm" class="form-control" required value="<?php echo $row_result->pass_cm ?>">
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">แก้ไขข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#form-edit_cu").submit(function() {
        var inputs = $("#form-edit_cu :input");
        var values = {};
        inputs.each(function() {
            values[this.name] = $(this).val();
        });

        console.log(values);

        $.ajax({
            url: "./controllers/customer_cl.php",
            type: "POST",
            data: {
                key: "form-edit_cu",
                data: values
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
                alert('จองสนามไม่สำเร็จ กรุณาลองใหม่อีกครั้ง')
            }
        });

    });
</script>