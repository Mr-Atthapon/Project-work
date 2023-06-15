<!DOCTYPE html>
<html lang="zxx" class="no-js">
<?php

include("./head.php");

?>
<body>
	<?php include('./header.php'); ?>
	<section class="banner-area relative">
		<div class="overlay overlay-bg"></div>
		<div class="container">
			<div class="row fullscreen align-items-center justify-content-between">
				<div class="col-lg-6 col-md-6 banner-left">
					<h6 class="text-white">ระบบจองสนาม</h6>
					<h1 class="text-white">ยินดีตอนรับ</h1>
					<p class="text-white">
						รายละเอียดต่าง ๆ
					</p>
					<a href="javascript:alert('กรุณาเข้าสู่ระบบก่อน')" class="primary-btn text-uppercase">จองสนาม</a>
				</div>
				<div class="col-lg-4 col-md-6 banner-right">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="flight-tab" data-toggle="tab" href="#flight" role="tab" aria-controls="flight" aria-selected="true">เข้าสู่ระบบ</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="hotel-tab" data-toggle="tab" href="#hotel" role="tab" aria-controls="hotel" aria-selected="false">สมัครสมาชิก</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="holiday-tab" data-toggle="tab" href="#holiday" role="tab" aria-controls="holiday" aria-selected="false">ADMIN</a>
						</li>
					</ul>
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade show active" id="flight" role="tabpanel" aria-labelledby="flight-tab">
							<form id="form-login-cu" action="javascript:void(0)" method="POST" class="form-wrap">
								<input type="text" class="form-control" name="uname_cm" placeholder="ชื่อผู้ใช้" onfocus="this.placeholder = ''" onblur="this.placeholder = 'ชื่อผู้ใช้ '">
								<input type="password" class="form-control" name="pass_cm" placeholder="รหัสผ่าน" onfocus="this.placeholder = ''" onblur="this.placeholder = 'รหัสผ่าน '">
								<button type="submit" class="primary-btn text-uppercase">เข้าสู่ระบบ</button>
							</form>
							<script>
								$("#form-login-cu").submit(function() {
									var $inputs = $("#form-login-cu :input");
									var values = {};
									$inputs.each(function() {
										values[this.name] = $(this).val();
									});
									$.ajax({
										url: "./controllers/Auth.php",
										type: "POST",
										data: {
											key: "login-cm",
											data: values
										},
										success: function(result, textStatus, jqXHR) {
											console.log(result);
											const obj = JSON.parse(result);
											if (obj.msg === "success") {
												alert("ยินดีตอนรับเข้าสู่ระบบ");
												location.assign("./booking/")
											} else if (obj.msg === "error") {
												alert(obj.msg_text);
											} else {
												alert(obj.msg_text);
											}
										},
										error: function(jqXHR, textStatus, errorThrown) {
										}
									});
									console.log(values);
								});
							</script>
						</div>
						
						<div class="tab-pane fade" id="hotel" role="tabpanel" aria-labelledby="hotel-tab">
							<form id="form-register-cu" action="javascript:void(0)" method="POST" class="form-wrap">
								<label for="">ข้อมูลส่วนตัว</label>
								<input type="text" class="form-control" name="idCode_cm" placeholder="รหัสบัตรประชาชน " onfocus="this.placeholder = ''" onblur="this.placeholder = 'รหัสบัตรประชาชน '">
								<input type="text" class="form-control" name="name_cm" placeholder="ชื่อ " onfocus="this.placeholder = ''" onblur="this.placeholder = 'ชื่อ '">
								<input type="text" class="form-control" name="lastname_cm" placeholder="นามสกุล " onfocus="this.placeholder = ''" onblur="this.placeholder = 'นามสกุล '">
								<input type="tel" class="form-control" name="tel_cm" placeholder="เบอร์โทร " onfocus="this.placeholder = ''" onblur="this.placeholder = 'เบอร์โทร '">
								<label for="">ข้อมูลล็อกอิน</label>
								<input type="text" class="form-control" name="uname_cm" placeholder="ชื่อผู้ใช้ " onfocus="this.placeholder = ''" onblur="this.placeholder = 'ชื่อผู้ใช้ '">
								<input type="password" class="form-control" name="pass_cm" placeholder="รหัสผ่าน " onfocus="this.placeholder = ''" onblur="this.placeholder = 'รหัสผ่าน '">
								<button type="submit" class="primary-btn text-uppercase">สมัครสมาชิก</button>
							</form>

							<script>
								$("#form-register-cu").submit(function() {
									var $inputs = $("#form-register-cu :input");
									var values = {};
									$inputs.each(function() {
										values[this.name] = $(this).val();
									});

									$.ajax({
										url: "./controllers/Auth.php",
										type: "POST",
										data: {
											key: "form-register-cu",
											data: values
										},
										success: function(result, textStatus, jqXHR) {
											console.log(result);
											const obj = JSON.parse(result);
											if (obj.msg === "success") {
												alert("สมัครสมาชิกสำเร็จ");
												location.reload();
											} else if (obj.msg === "error") {
												alert(obj.msg_text);
											} else {
												alert(obj.msg_text);
											}
										},
										error: function(jqXHR, textStatus, errorThrown) {

										}
									});
									console.log(values);
								});
							</script>
						</div>
						<div class="tab-pane fade" id="holiday" role="tabpanel" aria-labelledby="holiday-tab">
							<form id="form-login-admin" action="javascript:void(0)" class="form-wrap">
								<input type="text" class="form-control" name="uname_ad" placeholder="ชื่อผู้ใช้" onfocus="this.placeholder = ''" onblur="this.placeholder = 'ชื่อผู้ใช้ '">
								<input type="password" class="form-control" name="pass_ad" placeholder="รหัสผ่าน" onfocus="this.placeholder = ''" onblur="this.placeholder = 'รหัสผ่าน '">
								<button type="submit" class="primary-btn text-uppercase">LOGING</button>
							</form>
							<script>

								$("#form-login-admin").submit(function() {
									var $inputs = $("#form-login-admin :input");
									var values = {};
									$inputs.each(function() {
										values[this.name] = $(this).val();
									});
									$.ajax({
										url: "./controllers/Auth.php",
										type: "POST",
										data: {
											key: "login-ad",
											data: values
										},
										success: function(result, textStatus, jqXHR) {
											console.log(result);
											const obj = JSON.parse(result);
											if (obj.msg === "success") {
												alert("ยินดีตอนรับเข้าสู่ระบบ");
												location.assign("./admin/")
											} else if (obj.msg === "error") {
												alert(obj.msg_text);
											} else {
												alert(obj.msg_text);
											}
										},
										error: function(jqXHR, textStatus, errorThrown) {

										}
									});
									console.log(values);
								});

							</script>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

</body>

</html>