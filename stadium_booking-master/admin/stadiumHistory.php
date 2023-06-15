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

								// $sql_search = "SELECT *, 
								//                         DATE_FORMAT(rt.date_re, '%d') as Dd , 
								//                         DATE_FORMAT(rt.date_re, '%c') as month , 
								//                         DATE_FORMAT(rt.date_re, '%Y') as year, 
								//                         DATE_FORMAT(rt.timeStart_re, '%H : %i ') as timeStart_n , 
								//                         DATE_FORMAT(rt.timeEnd_re, '%H : %i ') as timeEnd_n 
								//                 FROM `reservation_tb` as rt 
								//                         INNER JOIN service_table as st ON st.id_tb = rt.id_tb 
								//                         INNER JOIN customer as cm ON cm.id_cm = rt.id_cm 
								//                     WHERE (rt.status_re != 2 AND rt.status_re != 3);";
								// $i_r = null;
								// foreach (DB::query($sql_search, PDO::FETCH_OBJ) as $row) :
								// 	// $date = 'วันที่ '.$row->Dd.' เดือน'.$thaimonth[$row->month-1].' พ.ศ.'.$row->year+543;
								// 	$date = '' . $row->Dd . ' ' . $thaimonth[$row->month - 1] . ' ' . (543 + intval($row->year));;
								// 	$timeStart_re = $date . "</br> " . $row->timeStart_n . ' น.';
								// 	$timeEnd_re = $date . "</br> " . $row->timeEnd_n . ' น.';
								?>


								<tr>
									<th class="text-center">1</th>
									<th class="text-center">นายกอไก่</th>
									<th class="text-center">สนาม</th>
									<th class="text-center">15 คน</th>
									<th class="text-center">12/10/2564</th>
									<th class="text-center">3 ชม.</th>
									<th class="text-center">900 บาท</th>
									<th>
										<?php
										if (0 == '0') {
											echo '<span class="badge badge-primary">รอยืนยัน</span>';
										} else {
											echo '<span class="badge badge-warning">ยืนยันแล้ว</span>';
										}
										?>
									</th>
									<td><?php
										if (0 == '0') {
											echo "<a href=\"javascript:update_reAd('0')\" class='badge badge-success'>ยืนยัน</a>";
										} else {
											echo "<a href=\"javascript:success_reAd('0')\" class='badge badge-primary'>สำเร็จ</a>";
										}
										?>
										&nbsp;&nbsp;
										<a href="javascript:cencel_reAd('<?php echo 0 ?>')" class="badge badge-danger">ยกเลิก</a>
									</td>
								</tr>

								<?php //e//ndforeach; 
								?>

							</tbody>
						</table>
						<script>
							function update_reAd(id) {
								if (confirm('ต้องการตอบรับจากจองโต๊ะนี้ ใช่หรือไม่')) {
									$.ajax({
										url: "../controllers/reserve_cl.php",
										type: "POST",
										data: {
											key: "update_reAd",
											id: id
										},
										success: function(result, statusText, jqXHR) {
											console.log(result);
											if (result == 'success') {
												alert("ตอบรับการจองสำเร็จ");
												location.reload();
											} else {
												alert('ตอบรับการจองโต๊ะไม่สำเร็จ')
												location.reload();

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
											if (result == 'success') {
												alert("บันทึกลงประวัติการจองสำเร็จ");
												location.reload();
											} else {
												alert('บันทึกลงประวัติการจองไม่สำเร็จ')
												location.reload();

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
											if (result == 'success') {
												alert("ยกเลิกการจองสำเร็จ");
												location.reload();
											} else {
												alert('ยกเลิกการจองโต๊ะไม่สำเร็จ')
												location.reload();

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
			<div class="row">
				<div class="col-lg-4">
					<div class="single-destinations" style="cursor: pointer;" onclick="location.assign('./reserve.php?stadium=xx')">
						<div class="thumb">
							<img src="../assets/img/stadium/0002st.jpg" alt="" width="100%" height="200px">
						</div>
						<div class="details">
							<h4 class="d-flex justify-content-between">
								<span>ชื่อสนาม</span>
								<div class="star">
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star checked"></span>
								</div>
							</h4>
							<p>
								จำนวนครั้งที่ใช้งาน | 49 ครั้ง
							</p>

						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="single-destinations" style="cursor: pointer;" onclick="location.assign('./reserve.php?stadium=xx')">
						<div class="thumb">
							<img src="../assets/img/stadium/0001st.jpg" alt="" width="100%" height="200px">
						</div>
						<div class="details">
							<h4 class="d-flex justify-content-between">
								<span>ชื่อสนาม 1</span>
								<div class="star">
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star checked"></span>
									<span class="fa fa-star checked"></span>
								</div>
							</h4>
							<p>
								จำนวนครั้งที่ใช้งาน | 49 ครั้ง
							</p>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End destinations Area -->
	<!-- start footer Area -->
	<?php include_once __DIR__ . './footer.php'; ?>
</body>

</html>