<!DOCTYPE html>
<html lang="zxx" class="no-js">
<?php include_once __DIR__ . './head.php'; ?>

<body>
	<?php include_once __DIR__ . './header.php'; ?>

	<!-- start banner Area -->
	<section class="about-banner relative">
		<div class="overlay overlay-bg"></div>
		<div class="container">
			<div class="row d-flex align-items-center justify-content-center">
				<div class="about-content col-lg-12">
					<h1 class="text-white">
						หน้าหลัก
					</h1>
				</div>
			</div>
		</div>
	</section>
	<!-- End banner Area -->
	<section class="destinations-area section-gap">

		<div class="container">
			<div class="row">
				<h2 class="mb-10">จัดการคิวการจอง</h2>
				<div class="col-lg-12 col-md-12 ">
					<div class="ts-service-box">

						<table id="mgBook_table" class="table  table-borderless " style="width:100%">
							<thead>

								<tr>
									<th class="text-center">ลำดับ</th>
									<th class="text-center">ผู้จอง</th>
									<th class="text-center">สนาม</th>
									<th class="text-center">จำนวนคน</th>
									<th class="text-center">เวลาจองสนาม</th>
									<th class="text-center">ระยะเวลาใช้สนาม</th>
									<th class="text-center">ราคา</th>
									<th>สถานะ</th>
									<th>จัดการ</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$thaiweek = array("วันอาทิตย์", "วันจันทร์", "วันอังคาร", "วันพุธ", "วันพฤหัส", "วันศุกร์", "วันเสาร์");
								$thaimonth = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];

								$sql_search = "SELECT *, DATE_FORMAT(rt.date_reserv, '%d') as Dd , 
												DATE_FORMAT(rt.date_reserv, '%c') as month , 
												DATE_FORMAT(rt.date_reserv, '%Y') as year, 
												DATE_FORMAT(rt.timeStart_reserv, '%H : %i ') as timeStart_n , 
												DATE_FORMAT(rt.timeEnd_reserv, '%H : %i ') as timeEnd_n 
												FROM `reserv_stadium` as rt 
												INNER JOIN stadium as st ON st.id_stadium = rt.id_stadium 
												INNER JOIN customer as cu ON cu.id_cm = rt.id_cm 
												WHERE (rt.status_reserv != 2 AND rt.status_reserv != 3);";
								$i_r = null;
								foreach (DB::query($sql_search, PDO::FETCH_OBJ) as $row) :
									// $date = 'วันที่ '.$row->Dd.' เดือน'.$thaimonth[$row->month-1].' พ.ศ.'.$row->year+543;
									$date = '' . $row->Dd . ' ' . $thaimonth[$row->month - 1] . ' ' . (543 + intval($row->year));;
									$timeStart_reserv = $date . "</br> " . $row->timeStart_n . ' น.';
									$timeEnd_reserv = $date . "</br> " . $row->timeEnd_n . ' น.';
								?>
									<tr>
										<td class="text-center"><?php echo ++$i_r; ?></td>
										<td class=""><?php echo  $row->name_cm . " " . $row->lastname_cm  ?></td>
										<td class="text-center"><?php echo  $row->name_stadium ?> คน</td>
										<td class="text-center"><?php echo  $row->quantity_reserv ?> คน</td>

										<td><?php echo $timeStart_reserv; ?> </td>

										<td class="text-center"><?php echo $row->sumHour_reserv; ?> ชม.</td>
										<td class="text-center"><?php echo $row->priceHourSum_reserv; ?> บาท</td>
										<th>
											<?php
											if ($row->status_reserv == 0) {
												echo '<span class="badge badge-primary">รอยืนยัน</span>';
											} else {
												echo '<span class="badge badge-warning">ยืนยันจ่ายเงิน</span>';
											}
											?>
										</th>
										<td><?php
											if ($row->status_reserv == 0) {
												echo "<a href=\"javascript:update_reAd('$row->id_reserv')\" class='badge badge-success'>ยืนยัน</a>";
											} else {
												echo "<a href=\"javascript:success_reAd('$row->id_reserv')\" class='badge badge-primary'>ยืนยันจ่ายเงิน</a>";
											}
											?>
											&nbsp;&nbsp;
											<a href="javascript:cencel_reAd('<?php echo $row->id_reserv ?>')" class="badge badge-danger">ยกเลิก</a>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<script>
							function update_reAd(id) {
								if (confirm('ต้องการตอบรับการจองสนาม ใช่หรือไม่')) {
									$.ajax({
										url: "../controllers/reserve_cl.php",
										type: "POST",
										data: {
											key: "update_reAd",
											id: id
										},
										success: function(result, statusText, jqXHR) {
											console.log(result);
											const obj = JSON.parse(result);
											if (obj.msg === "success") {
												alert(obj.msg_text);
												location.reload();
											} else if (obj.msg === "error") {
												alert(obj.msg_text);
											} else {
												alert(obj.msg_text);
											}
										},
										error: function(jqXHR, statusText, error) {
											alert('ตอบรับการจองโต๊ะไม่สำเร็จ')
										}
									});
								}
							}

							function success_reAd(id) {
								if (confirm('ลูกค้าชำระเงินเสร็จสิ้น ใช่หรือไม่')) {
									$.ajax({
										url: "../controllers/reserve_cl.php",
										type: "POST",
										data: {
											key: "success_reAd",
											id: id
										},
										success: function(result, statusText, jqXHR) {
											console.log(result);
											const obj = JSON.parse(result);
											if (obj.msg === "success") {
												alert(obj.msg_text);
												location.reload();
											} else if (obj.msg === "error") {
												alert(obj.msg_text);
											} else {
												alert(obj.msg_text);
											}
										},
										error: function(jqXHR, statusText, error) {
											alert('บันทึกลงประวัติการจองไม่สำเร็จ')
										}
									});
								}
							}

							function cencel_reAd(id) {
								if (confirm('ต้องการยกเลิกจากจองใช้หรือไม่')) {
									$.ajax({
										url: "../controllers/reserve_cl.php",
										type: "POST",
										data: {
											key: "cencel_reserveAd",
											id: id
										},
										success: function(result, statusText, jqXHR) {
											console.log(result);
											const obj = JSON.parse(result);
											if (obj.msg === "success") {
												alert(obj.msg_text);
												location.reload();
											} else if (obj.msg === "error") {
												alert(obj.msg_text);
											} else {
												alert(obj.msg_text);
											}
										},
										error: function(jqXHR, statusText, error) {
											alert('ยกเลิกการจองโต๊ะไม่สำเร็จ')
										}
									});
								}
							}

							$(document).ready(function() {
								ad_mgBook_table();
							});

							function ad_mgBook_table() {
								$('#mgBook_table').DataTable({
									dom: 'lBfrtip',
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
						</script>

					</div>
					<!-- Service1 end -->
				</div>
				<!-- Col 1 end -->

			</div>
		</div>
	</section>

	<!-- Start destinations Area -->
	<section class="destinations-area section-gap">
		<div class="container">
			<h2 class="mb-10">ข้อมูลสนาม</h2>
			<button class="btn btn-sm btn-primary" onclick="$('#add_stadium').modal('show');">เพิ่มสนาม</button>
			<div class="row">
				<?php
				$sql_select_stadium = "SELECT * FROM `stadium` WHERE status_stadium != 0  ";
				foreach (DB::query($sql_select_stadium, PDO::FETCH_OBJ) as $rw) :
				?>

					<div class="col-lg-4">
						<div class="single-destinations" style="cursor: pointer;" onclick="location.assign('./reserve.php?stadium=<?php echo $rw->id_stadium ?>')">
							<div class="thumb">
								<img src="../assets/img/stadium/<?php echo $rw->img_stadium ?>" alt="" width="100%" height="200px">
							</div>
							<div class="details">
								<h4 class="d-flex justify-content-between">
									<span><?php echo $rw->name_stadium ?></span>
									<div class="star">
										<?php $statusText = $rw->status_stadium == 1 ? "พร้อมใช้งาน" : "ปิดปรับปรุง"; ?>
										<h5 class='badge  <?php echo $rw->status_stadium == 1 ? "badge-success" : "badge-warning"; ?>'><?php echo $rw->status_stadium == 1 ? "พร้อมใช้งาน" : "ปิดปรับปรุง"; ?></h5>
									</div>
								</h4>
								<p>
									จำนวนคนที่รองรับ | <?php echo $rw->quantity_stadium ?> ครั้ง
								</p>
								<p>
									ราคาเช่า /ชม. | <?php echo $rw->priceHour_stadium ?> บาท
								</p>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<section class="destinations-area section-gap">
		<div class="container">
			<h2 class="mb-10">ประวัติการจอง</h2>
			<div class="row">
				<div class="col-lg-12">
					<table id="mgBookHistory_table" class="table  table-borderless" style="width:100%">
						<thead>
							<tr>
								<th class="text-center">ลำดับ</th>
								<th class="text-center">ผู้จอง</th>
								<th class="text-center">เบอร์โทรศัพท์</th>
								<th class="text-center">สนามที่จอง</th>
								<th class="text-center">จำนวนคน</th>
								<th class="text-center">ระยะเวลาใช้สนาม</th>
								<th class="text-center">ราคา</th>
								<th>เวลาจองสนาม</th>
								<!-- <th>เวลาจองในระบบ</th> -->
							</tr>
						</thead>
						<tbody>
							<?php
							$thaiweek = array("วันอาทิตย์", "วันจันทร์", "วันอังคาร", "วันพุธ", "วันพฤหัส", "วันศุกร์", "วันเสาร์");
							$thaimonth = ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];

							$sql_search = "SELECT *, DATE_FORMAT(rt.date_reserv, '%d') as Dd , 
												DATE_FORMAT(rt.date_reserv, '%c') as month , 
												DATE_FORMAT(rt.date_reserv, '%Y') as year, 
												DATE_FORMAT(rt.timeStart_reserv, '%H : %i ') as timeStart_n , 
												DATE_FORMAT(rt.timeEnd_reserv, '%H : %i ') as timeEnd_n 
												FROM `reserv_stadium` as rt 
												INNER JOIN stadium as st ON st.id_stadium = rt.id_stadium 
												INNER JOIN customer as cu ON cu.id_cm = rt.id_cm 
												WHERE rt.status_reserv = 2;";
							$i_r = null;
							foreach (DB::query($sql_search, PDO::FETCH_OBJ) as $row) :
								// $date = 'วันที่ '.$row->Dd.' เดือน'.$thaimonth[$row->month-1].' พ.ศ.'.$row->year+543;
								$date = '' . $row->Dd . ' ' . $thaimonth[$row->month - 1] . ' ' . (543 + intval($row->year));;
								$timeStart_reserv = $date . "</br> " . $row->timeStart_n . ' น.';
								$timeEnd_reserv = $date . "</br> " . $row->timeEnd_n . ' น.';
							?>
								<tr>
									<td class="text-center"><?php echo ++$i_r; ?></td>
									<td class=""><?php echo  $row->name_cm . " " . $row->lastname_cm  ?></td>
									<td class=""><?php echo  $row->tel_cm ?></td>
									<td class="text-center"><?php echo  $row->name_stadium ?> คน</td>
									<td class="text-center"><?php echo  $row->quantity_reserv ?> คน</td>
									<td class="text-center"><?php echo $row->sumHour_reserv; ?> ชม.</td>
									<td class="text-center"><?php echo $row->priceHourSum_reserv; ?> บาท</td>
									<td><?php echo $timeStart_reserv; ?> </td>
								</tr>
							<?php endforeach; ?>

						</tbody>
					</table>
					<script>
						$(document).ready(function() {
							ad_mgBookHistory_table();
						});

						function ad_mgBookHistory_table() {
							$('#mgBookHistory_table').DataTable({
								dom: 'lBfrtip',
								lengthMenu: [
									[10, 25, 50, 60, -1],
									[10, 25, 50, 60, "All"]
								],
								language: {
									sProcessing: " กำลังดำเนินการ...",
									sLengthMenu: " แสดง  _MENU_  แถว ",
									sZeroRecords: " ไม่พบข้อมูล ",
									sInfo: " แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว ",
									sInfoEmpty: "แสดง 0 ถึง 0 จาก 0 แถว",
									sInfoFiltered: "( กรองข้อมูล  _MAX_  ทุกแถว )",
									sInfoPostFix: "",
									sSearch: "ค้นหา:",
									sUrl: "",
									oPaginate: {
										"sFirst": " เริ่มต้น ",
										"sPrevious": " ก่อนหน้า ",
										"sNext": " ถัดไป ",
										"sLast": " สุดท้าย "
									}
								}, // sInfoEmpty: "แสดง 0 ถึง 0 ของ 0 เร็คคอร์ด",
								processing: true, // แสดงข้อความกำลังดำเนินการ กรณีข้อมูลมีมากๆ จะสังเกตเห็นง่าย
								//serverSide: true, // ใช้งานในโหมด Server-side processing
								// กำหนดให้ไม่ต้องการส่งการเรียงข้อมูลค่าเริ่มต้น จะใช้ค่าเริ่มต้นตามค่าที่กำหนดในไฟล์ php

								buttons: [{
									extend: 'excel',
									text: 'ส่งออก EXCEL',
									messageTop: '',
									filename: function() {
										// const d = new Date();
										// // let time = d.getTime();
										// let hour = d.getHours();
										// let minutes = d.getMinutes();
										// let day = d.getDay();
										// let month = d.getMonth();
										// let year = d.getFullYear();
										return "ประวัติการจอง"; //+hour+'-'+minutes + '-'+days +'-'+month +'-'+years
									},
									// title: 'รายชื่อสิทเข้าห้อง',
									exportOptions: {
										// columns: [0, 1, 2]
										// คอลัมส์ที่จะส่งออก
										// modifier: {
										//     page: 'all' // หน้าที่จะส่งออก all / current
										// },
										// stripHtml: true
									}
								}, {
									extend: 'print',
									text: 'พิมพ์',
								}],
								retrieve: true,
							});
						}
					</script>
				</div>
			</div>
		</div>
	</section>
	<!-- End destinations Area -->
	<!-- start footer Area -->
	<?php include_once __DIR__ . './footer.php'; ?>

	<div class="modal fade" id="add_stadium" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<form id="form-add_stadium" action="javascript:void(0)" method="POST">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">เพิ่มสนาม</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">

						<div class="form-group">
							<label class="form-control-label">ชื่อสนาม</label>
							<input type="text" name="name_stadium" class="form-control" required>
						</div>
						<div class="form-group">
							<label class="form-control-label">รายเอียดสนาม</label>
							<textarea row="4" name="details_stadium" class="form-control" required></textarea>
						</div>
						<div class="form-group">
							<label class="form-control-label">เลือกรูป</label>
							<input id="img_stadium" type="file" class="form-control" required>
							<input name="img_stadium" value="" type="hidden">
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
							<input type="number" name="quantity_stadium" min="1" class="form-control" required>
						</div>
						<div class="form-group">
							<label class="form-control-label">ราคาใช้สนาม/ชม.</label>
							<input type="number" name="priceHour_stadium" min="0" class="form-control" required>
						</div>
						<div class="form-group">
							<label class="form-control-label">สถานะ</label>
							<select name="status_stadium" class="form-control" required>
								<option value="" disabled selected>เลือกสถานะ</option>
								<option value="1">พร้อมใช้งาน</option>
								<option value="2">ไม่พร้อมใช้งาน</option>
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
						<button type="submit" class="btn btn-primary">เพิ่มสนาม</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script>
		$("#form-add_stadium").submit(function() {
			var inputs = $("#form-add_stadium :input");
			var values = {};
			inputs.each(function() {
				values[this.name] = $(this).val();
			});

			console.log(values);

			if (confirm("กรุณาตรวจสอบข้อมูลอีกครั้ง ก่อนกดยืนยัน")) {
				$.ajax({
					url: "./controllers/stadium_cl.php",
					type: "POST",
					data: {
						key: "form-add_stadium",
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
			}

		});
	</script>
</body>

</html>