<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image shortcut" href="<?= base_url('assets/images/logo.png') ?>">
    <title>MS Ticket</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
        rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url("assets/plugins/fontawesome-free/css/all.min.css") ?>">

    <!-- icheck boots trap -->
    <link rel="stylesheet" href="<?= base_url("assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css") ?>">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url("assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css") ?>">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url("assets/plugins/toastr/toastr.min.css") ?>">

    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url("assets/plugins/select2/css/select2.min.css") ?>">
    <link rel="stylesheet" href="<?= base_url("assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css") ?>">

    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url("assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css")  ?>">
    <link rel="stylesheet" href="<?= base_url("assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css")  ?>">
    <link rel="stylesheet" href="<?= base_url("assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css")  ?>">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url("assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css") ?>">

    <link rel="stylesheet" href="<?= base_url("assets/dist/css/adminlte.min.css") ?>">
    
</head>

<body class="hold-transition <?php if(!isLoggedIn()){ echo("dark-mode");} ?> layout-top-nav <?php if($login){echo("login-page");} ?>">
    <div class="<?php if($login){echo("login-box");} else{ echo("wrapper"); } ?>">
		<?php
			if($login || $error){
				echo $content;
			}
			else{
				?>
					<!-- Preloader -->
					<div class="preloader flex-column justify-content-center align-items-center">
						<i class="fas fa-3x fa-spinner fa-spin text-default"></i>
					</div>
				<?php
				echo $header;
				?>
				<div class="content-wrapper">
					<?php
					echo $content;
					?>
				</div>
				<?php
				echo $footer;
			}
		?>
    </div>

    <!-- jQuery -->
    <script src="<?= base_url("assets/plugins/jquery/jquery.min.js") ?>"></script>
    <!-- Bootstrap -->
    <script src="<?= base_url("assets/plugins/bootstrap/js/bootstrap.bundle.min.js") ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url("assets/dist/js/adminlte.js") ?>"></script>

    <!-- SweetAlert2 -->
    <script src="<?= base_url("assets/plugins/sweetalert2/sweetalert2.min.js") ?>"></script>

    <!-- bs-custom-file-input -->
    <script src="<?= base_url("assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js") ?>"></script>
    <!-- Toastr -->
    <script src="<?= base_url("assets/plugins/toastr/toastr.min.js") ?>"></script>

    <!-- Select2 -->
    <script src="<?= base_url("assets/plugins/select2/js/select2.full.min.js") ?>"></script>

    <!-- DataTables  & Plugins -->
    <script src="<?= base_url("assets/plugins/datatables/jquery.dataTables.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/datatables-responsive/js/dataTables.responsive.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/datatables-buttons/js/dataTables.buttons.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/jszip/jszip.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/pdfmake/pdfmake.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/pdfmake/vfs_fonts.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/datatables-buttons/js/buttons.html5.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/datatables-buttons/js/buttons.print.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/datatables-buttons/js/buttons.colVis.min.js") ?>"></script>

    <!-- overlayScrollbars -->
    <script src="<?= base_url("assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js") ?>"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="<?= base_url("assets/plugins/jquery-mousewheel/jquery.mousewheel.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/raphael/raphael.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/jquery-mapael/jquery.mapael.min.js") ?>"></script>
    <script src="<?= base_url("assets/plugins/jquery-mapael/maps/usa_states.min.js") ?>"></script>
    <!-- ChartJS -->
    <script src="<?= base_url("assets/plugins/chart.js/Chart.min.js") ?>"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="<?= base_url("assets/dist/js/demo.js") ?>"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->

    <script src="<?= base_url("assets/js/pages.js") ?>"></script>
    <?php include($js) ?>
</body>

</html>
