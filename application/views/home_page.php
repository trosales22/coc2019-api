<?php
	$session_data = $this->session->userdata('logged_in');
	$session_username = $session_data['username'];

	if (!$session_data) {
		redirect(base_url('login_page'));
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="<?php echo base_url(); ?>static/images/jasper_jean.ico"/>
  <meta name="description" content="Jasper Jean - We Transport People.">
  <meta name="author" content="Tristan Rosales">

  <title>Clash Of Codes - Dashboard</title>

  <!-- Custom fonts for this template -->
  <link href="<?php echo base_url(); ?>static/SBAdmin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="<?php echo base_url(); ?>static/SBAdmin/css/sb-admin-2.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>static/SBAdmin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.css">
	<link href="<?php echo base_url(); ?>static/css/parsley.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>static/js/libraries/jquery-confirm-v3.3.4/dist/jquery-confirm.min.css" rel="stylesheet">
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

		<?php include 'pages/sidebar.php';?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

				<?php include 'pages/topbar.php';?>
				
        <!-- Begin Events -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Events</h1>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <a class="btnAddProduct btn btn-danger btn-icon-split" href="#" data-toggle="modal" data-target="#addEventModal">
                <span class="icon text-white-50">
                  <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Add Event</span>
              </a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="tbl_events" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Details</th>
											<th>Venue</th>
											<th>Schedule</th>
											<th>Creator</th>
											<th>Date Added</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  
                  <tbody>
									<?php foreach($events as $event){?>
											<tr>
												<td><?php echo $event->event_name; ?></td>
												<td><?php echo $event->event_details; ?></td>
												<td><?php echo $event->event_venue; ?></td>
												<td><?php echo $event->event_schedule; ?></td>
												<td><?php echo $event->firstname . ' ' . $event->lastname; ?></td>
												<td><?php echo $event->event_created_date; ?></td>
												<td>
													<a style="width: 100%; margin-bottom: 8px; cursor: pointer; color: white;" data-toggle="modal" data-id="<?php echo $event->event_id;?>" data-target="#editProductModal" class="btnEditProduct btn btn-info btn-icon-split">
														<span class="icon text-white-50" style="margin-right: auto;">
															<i class="fas fa-edit"></i>
														</span>
														<span class="text" style="margin-right: auto;">Edit Event</span>
													</a>

													<a style="width: 100%; cursor: pointer; color: white;" data-id="<?php echo $event->event_id;?>" class="btnDeleteProduct btn btn-danger btn-icon-split">
														<span class="icon text-white-50" style="margin-right: auto;">
															<i class="fas fa-trash"></i>
														</span>
														<span class="text" style="margin-right: auto;">Delete Event</span>
													</a>
												</td>
											</tr> 
                     <?php }?>
                  </tbody>

                  <tfoot>
                    <tr>
											<th>Name</th>
                      <th>Details</th>
											<th>Venue</th>
											<th>Schedule</th>
											<th>Creator</th>
											<th>Date Added</th>
                      <th>Actions</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
				<!-- End Events -->
				
				<!-- Begin Announcements -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Announcements</h1>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <a class="btnAddAnnouncement btn btn-danger btn-icon-split" href="#" data-toggle="modal" data-target="#addAnnouncementModal">
                <span class="icon text-white-50">
                  <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Add Announcement</span>
              </a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="tbl_announcements" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Caption</th>
											<th>Details</th>
											<th>Source/Link</th>
											<th>Creator</th>
											<th>Date Posted</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  
                  <tbody>
										<?php foreach($announcements as $announcement){?>
											<tr>
												<td><?php echo $announcement->announcement_caption; ?></td>
												<td><?php echo $announcement->announcement_details; ?></td>
												<td>
													<?php 
														if(empty($announcement->announcement_link)){
															echo '<div class="alert alert-danger">
																			<span class="icon text-red-50" style="margin-right: auto;">
																				<i class="fas fa-exclamation-triangle"></i>
																			</span> <b>LINK NOT AVAILABLE!</b>
																		</div>';
														}else{
															echo $announcement->announcement_link; 
														}
													?>
												</td>
												<td><?php echo $announcement->firstname . ' ' . $announcement->lastname; ?></td>
												<td><?php echo $announcement->announcement_created_date;?></td>
												<td>
													<a style="width: 100%; margin-bottom: 8px; cursor: pointer; color: white;" data-toggle="modal" data-id="<?php echo $announcement->announcement_id;?>" data-target="#editProductModal" class="btnEditProduct btn btn-info btn-icon-split">
														<span class="icon text-white-50" style="margin-right: auto;">
															<i class="fas fa-edit"></i>
														</span>
														<span class="text" style="margin-right: auto;">Edit Announcement</span>
													</a>

													<a style="width: 100%; cursor: pointer; color: white;" data-id="<?php echo $announcement->announcement_id;?>" class="btnDeleteProduct btn btn-danger btn-icon-split">
														<span class="icon text-white-50" style="margin-right: auto;">
															<i class="fas fa-trash"></i>
														</span>
														<span class="text" style="margin-right: auto;">Delete Announcement</span>
													</a>
												</td>
											</tr> 
                     <?php }?>
                  </tbody>

                  <tfoot>
                    <tr>
											<th>Caption</th>
											<th>Details</th>
											<th>Source/Link</th>
											<th>Creator</th>
											<th>Date Posted</th>
                      <th>Actions</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- End Announcements -->
				
				<!-- Begin News & Articles -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">News & Articles</h1>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <a class="btnAddNews btn btn-danger btn-icon-split" href="#" data-toggle="modal" data-target="#addNewsModal">
                <span class="icon text-white-50">
                  <i class="fas fa-plus-circle"></i>
                </span>
                <span class="text">Add News & Articles</span>
              </a>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="tbl_news" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Caption</th>
                      <th>Source/Link</th>
											<th>Creator</th>
											<th>Date Posted</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  
                  <tbody>
										<?php foreach($news_and_articles as $news_and_article){?>
											<tr>
												<td>
													<?php 
														if(empty($news_and_article->news_caption)){
															echo '<div class="alert alert-danger">
																			<span class="icon text-red-50" style="margin-right: auto;">
																				<i class="fas fa-exclamation-triangle"></i>
																			</span> <b>NOT AVAILABLE!</b>
																		</div>';
														}else{
															echo $news_and_article->news_caption; 
														}
													?>
												</td>
												<td><?php echo $news_and_article->news_url; ?></td>
												<td><?php echo $news_and_article->firstname . ' ' . $announcement->lastname; ?></td>
												<td><?php echo $news_and_article->news_created_date;?></td>
												<td>
													<a style="width: 100%; margin-bottom: 8px; cursor: pointer; color: white;" data-toggle="modal" data-id="<?php echo $news_and_article->news_id;?>" data-target="#editProductModal" class="btnEditProduct btn btn-info btn-icon-split">
														<span class="icon text-white-50" style="margin-right: auto;">
															<i class="fas fa-edit"></i>
														</span>
														<span class="text" style="margin-right: auto;">Edit News</span>
													</a>

													<a style="width: 100%; cursor: pointer; color: white;" data-id="<?php echo $news_and_article->news_id;?>" class="btnDeleteProduct btn btn-danger btn-icon-split">
														<span class="icon text-white-50" style="margin-right: auto;">
															<i class="fas fa-trash"></i>
														</span>
														<span class="text" style="margin-right: auto;">Delete News</span>
													</a>
												</td>
											</tr> 
                     <?php }?>
                  </tbody>

                  <tfoot>
                    <tr>
											<th>Caption</th>
                      <th>Source/Link</th>
											<th>Creator</th>
											<th>Date Posted</th>
                      <th>Actions</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
				<!-- End News & Articles -->
				
      </div>
      <!-- End of Main Content -->

      <?php include 'pages/footer.php';?>

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
	</a>
	
	<?php include 'pages/modals/add_event.php';?>

	<?php include 'pages/modals/add_news.php';?>
	
	<?php include 'pages/modals/add_announcement.php';?>
	
	<?php include 'pages/modals/logout.php';?>
	
  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url(); ?>static/SBAdmin/vendor/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>static/SBAdmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url(); ?>static/SBAdmin/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url(); ?>static/SBAdmin/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="<?php echo base_url(); ?>static/SBAdmin/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>static/SBAdmin/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
	<script src="<?php echo base_url(); ?>static/SBAdmin/js/demo/datatables-demo.js"></script>
	<script src="https://parsleyjs.org/dist/parsley.min.js"></script>
	<script src="<?php echo base_url(); ?>static/js/libraries/jquery-confirm-v3.3.4/js/jquery-confirm.js"></script>
	<script src="<?php echo base_url(); ?>static/js/home.js"></script>

</body>

</html>
