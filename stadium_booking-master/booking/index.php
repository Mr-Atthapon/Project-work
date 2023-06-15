<!DOCTYPE html>
<html lang="zxx" class="no-js">
<?php include('./head.php'); ?>

<body>
	<?php include('./header.php'); ?>

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

	<!-- Start destinations Area -->
	<section class="destinations-area section-gap">
		<div class="container">
			<div class="row d-flex justify-content-center">
				<div class="menu-content pb-40 col-lg-8">
					<div class="title text-center">
						<h1 class="mb-10">เลือกสนาม</h1>
						<p>รายละเอียด</p>
					</div>
				</div>
			</div>
			<div class="row">

				<!-- SELECT * FROM `stadium` WHERE status_stadium != 0  -->
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
	<!-- End destinations Area -->
	<!-- start footer Area -->
	<?php include('./footer.php'); ?>
</body>

</html>