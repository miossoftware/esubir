<?php

header('Content-Type: text/html; charset=UTF-8');
?>
<!doctype html>
<html lang="en">
<head>
    <link href="./assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="./assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="./assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet"/>
    <link href="./assets/vendors/DataTables/datatables.min.css" rel="stylesheet"/>
    <link href="assets/css/main.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css"
          href="assets/vendors/DataTables/DataTables-1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <meta charset="UTF-8" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="./assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="./assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <link href="./assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet"/>
    <link href="./assets/vendors/jvectormap/jquery-jvectormap-2.0.3.css" rel="stylesheet"/>
    <link href="assets/css/main.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <!--   YEMİ EKLENEN SATIR BU -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Buttons JavaScript -->
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <link rel="icon" href="assets/img/ep_logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <title>SULAMA BİRLİĞİ</title>
</head>
<style>
    td {
        text-align: right;
        text-transform: uppercase;
        padding: 2px !important;
        font-size: 12px !important;
        font-weight: bold;
    }
    .dataTables_scrollHeadInner table {
        width: 100% !important;
    }

    @media screen and (max-width: 768px) {
        .modal-footer {
            width: 95%;
            height: 95%;
        }
    }

    table {
        cursor: pointer;
    }

    .modal-header {
        background-color: #374f65
    }

    .modal-body {
        background-color: #DDE6ED;
    }

    .card-body {
        background-color: #DDE6ED;
    }

    .ibox {
        background-color: #DDE6ED;
    }

    /*:root{*/
    /*    --dt-row-selected:255, 184, 51;*/
    /*}*/
    .odd {
        background-color: #F5F5F5 !important; /* Yeşil */
    }
</style>

<?php
include "controller/DB.php";
DB::connect();
session_start();
$style = "";
if (isset($_SESSION["username"])) {
    $style = "background-color:#9DB2BF";
} else {
    $style = "background-color: #FDF4F5";
}
?>
<body style="<?= $style ?>">
<script type="text/javascript" src="assets/vendors/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js"></script>
<?php
if (isset($_SESSION["username"]) && isset($_SESSION["user_root"])) {
    if ($_SESSION["user_root"] == 2 || $_SESSION["user_root"] == 1) {
        include __DIR__ . "/view/admins_page.php";
    } else {
        include __DIR__ . '/view/admin_panel.php';
    }

} else {
    include __DIR__ . '/view/login.php';
}
?>
<script>

    function checkSessionAndReload() {
        $.ajax({
            url: "controller/sql.php?islem=session_check", // Oturum durumu kontrol eden bir PHP dosyasının yolunu belirtin
            method: "GET",
            success: function (response) {
                if (response == 2) {
                    location.reload();
                }
            }
        });
    }

    setInterval(checkSessionAndReload, 100000);
</script>
<div class="getModals"></div>
<script src="assets/js/app.js" type="text/javascript"></script>
<script src="./assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
<script src="./assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
<script src="./assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
<script src="./assets/vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
<script src="./assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
<script src="./assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
<script src="./assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
<script src="./assets/vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
<script src="./assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="./assets/vendors/DataTables/datatables.min.js" type="text/javascript"></script>
<script src="assets/js/app.min.js" type="text/javascript"></script>

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/tr.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.13/xlsx.full.min.js"></script>

<script>
    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });
</script>
</body>
</html>



