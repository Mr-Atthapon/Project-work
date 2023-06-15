<!DOCTYPE html>
<html lang="zxx" class="no-js">

<?php include("./head.php"); ?>

<body>

	<?php include ('./header.php'); ?>
	<!-- start banner Area -->

	<!-- start banner Area -->
	<section class="about-banner relative">
		<div class="overlay overlay-bg"></div>
		<div class="container">
			<div class="row d-flex align-items-center justify-content-center">
				<div class="about-content col-lg-12">
					<h1 class="text-white">
						ข้อมูลส่วนตัว
					</h1>
					<p class="text-white link-nav"><a href="./">หน้าหลัก </a> <span class="lnr lnr-arrow-right"></span> <a href="javascript:void(0)"> ข้อมูลส่วนตัว</a></p>
				</div>
			</div>
		</div>
	</section>

	<section class="insurence-one-area section-gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 order-1 order-lg-0">
					<div class="sidebar sidebar-left">
						<h3 class="widget-title">ข้อมูลส่วนตัว</h3>
						<div class="list-wrap">
							<ul class="">
								<!-- <li><a href="#">แก้ไขข้อมูล</a></li> -->
								<li><a href="javascript:show_div('info_show')">ข้อมูลส่วนตัว</a></li>
								<li><a href="javascript:show_div('edit_info')">แก้ไขข้อมูลส่วนตัว</a></li>
							</ul>
						</div>
					</div>

				</div>
				<script>
					function show_div(id) {
						if (id == 'edit_info') {
							$("#info_show").css("display", "none");
							$("#edit_info").css("display", "block");
							update_hiShow_table();

						} else if (id == 'info_show') {
							$("#info_show").css("display", "block");
							$("#edit_info").css("display", "none");
						}
					}
				</script>
				<div id="info_show" style="display: block;" class="">
					<div class="post">
						<div class="post-body">
							<div class="entry-header">
								<h2 class="entry-title">
									<a href="javascript:void(0)">ข้อมูลส่วนตัว</a>
								</h2>
							</div><!-- header end -->

							<div class="entry-content mb-30 mt-30">
								<div class="mb-2 mt-2"><strong class="info_name ">รหัสบัตรประชาชน : </strong> <?php echo $resultRowUser->idCode_cm ?></div>

								<div class="mb-2 mt-2"><strong class="info_name ">ชื่อ : </strong> <?php echo $resultRowUser->name_cm . " " . $resultRowUser->lastname_cm ?></div>

								<div class="mb-2 mt-2"><strong class="info_name ">เบอร์ : </strong> <?php echo $resultRowUser->tel_cm ?></div>

							</div>

						</div>
					</div>
				</div>

				<div id="edit_info" style="display: none;" class="">
					<div class="post">
						<div class="post-body">
							<div class="entry-header">
								<h2 class="entry-title">
									<a href="javascript:void(0)">แก้ไขข้อมูลส่วนตัว</a>
								</h2>
							</div><!-- header end -->

							<form id="edit_info" action="javascript:void(0)" method="POST">

								<input type="hidden" name="id_cm" value="<?php echo $ID_USER ?>">
								<label for="" class="form-control-label">ข้อมูลทั่วไป</label>
								<div class="form-group">
									<input type="text" name="idCode_cm" value="<?php echo $resultRowUser->idCode_cm ?>" class="form-control" placeholder="รหัสบัตรประชาชน">
								</div>
								<div class="form-group">
									<input type="text" name="name_cm" value="<?php echo $resultRowUser->name_cm ?>" class="form-control" placeholder="ชื่อ">
								</div>
								<div class="form-group">
									<input type="text" name="lastname_cm" value="<?php echo $resultRowUser->lastname_cm ?>" class="form-control" placeholder="นามสกุล">
								</div>
								<div class="form-group">
									<input type="tel" name="tel_cm" value="<?php echo $resultRowUser->tel_cm ?>" class="form-control" placeholder="เบอร์">
								</div>
								<label for="" class="form-control-label">ข้อมูลล็อกอิน</label>
								<div class="form-group">
									<input type="text" name="uname_cm" value="<?php echo $resultRowUser->uname_cm ?>" class="form-control" placeholder="ชื่อผู้ใช้">
								</div>
								<div class="form-group">
									<input type="password" name="pass_cm" value="<?php echo $resultRowUser->pass_cm ?>" class="form-control" placeholder="รหัสผ่าน">
								</div>

								<div class="post-footer">
									<button type="submit" class="btn btn-sm primary-btn">แก้ไขข้อมูล</button>
								</div>
							</form>
							<script>
								$("#edit_info").submit(function() {
									var inputs = $("#edit_info :input");
									var values = {};
									inputs.each(function() {
										values[this.name] = $(this).val();
									});

									$.ajax({
										url: "./controller/customer_cl.php",
										type: "POST",
										data: {
											key: "edit_customer_cl",
											data: values
										},
										success: function(result, statusText) {

											console.log(result);
											const obj = JSON.parse(result);
											if (obj.msg === "success") {
												alert("แก้ไขข้อมูลสำเร็จ");
												location.reload(true);
											} else if (obj.msg === "error") {
												alert(obj.msg_text);
											} else {
												alert(obj.msg_text);
											}
										},
										error: function(result, statusText) {
											alert("ไม่สามารถแก้ไขข้อมูลส่วนตัวได้")
											location.reload()
										}
									});
								});
							</script>
						</div>
					</div>
				</div>

			</div>
		</div>
	</section>



	<?php include('./footer.php'); ?>
</body>

</html>