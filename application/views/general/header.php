<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Vehicle Informartion System</title>
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="<?php echo base_url(); ?>assets/img/kaiadmin/favicon.ico"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="<?php echo base_url(); ?>assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["<?php echo base_url(); ?>assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/plugins.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/demo.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />

    <!--   Core JS Files   -->
    <script src="<?php echo base_url(); ?>assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/core/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/core/bootstrap.min.js"></script>

    <!-- Chart JS -->
    <script src="<?php echo base_url(); ?>assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="<?php echo base_url(); ?>assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="<?php echo base_url(); ?>assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugin/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugin/datatables/dataTables.select.min.js"></script>
    
    <!-- Bootstrap Notify -->
    <script src="<?php echo base_url(); ?>assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="<?php echo base_url(); ?>assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo base_url(); ?>assets/js/plugin/sweetalert/sweetalert.min.js"></script>

   

    <script src="<?php echo base_url(); ?>assets/js/uppercase.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/harga.js"></script>
  </head>
  <body>
    <div class="wrapper">