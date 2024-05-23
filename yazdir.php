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
    <title>TAHSİLAT MAKBUZU</title>
</head>
<body>
<style>
    @media print {
        @page {
            margin-top: 0; /* Sayfa üst kısmındaki boşluğu sıfırlar */
            margin-bottom: 0;
        }
    }

    .bold-text {
        font-weight: bold;
        font-size: 17px;
        display: inline-block; /* Tek satırda hizalamak için ekledik */
    }

</style>
<br>
<br>
<br>
<br>
<div class="col-12 row">
    <div class="col-4">
        <div class="mt-3"></div>
        <center><span class="bold-text">S.S. TOROSLAR ARSLANKÖY SULAMA</span></center>
        <center><span class="bold-text">KOOPERATİFİ BAŞKANLIĞI</span></center>
        <center><span class="bold-text">MERSİN</span></center>
        <center><span>Merkez: Arslanköy Mah. Toroslar / MERSİN</span></center>
        <center><span>Liman V.D. 853 036 9028</span></center>
        <center><span>Tic. Sic. No: 39669</span></center>
    </div>
    <div class="col-4">
        <div class="mt-5"></div>
        <br><br><br><br>
        <center><span style="font-weight: bold; font-size: 22px">TAHSİLAT MAKBUZU</span></center>
        <!--        <div class="mt-5"></div>-->
        <!--        <center><span style="font-weight: bold; font-size: 20px">728.007,00 TL</span></center>-->
    </div>
    <br>
    <br>
    <br>
    <br>
    <div class="col-4">
        <div class="mt-3"></div>
        <center><span style="font-weight: bold; font-size: 15px">No: <?= $_GET["belge_no"] ?></span></center>
        <div class="mt-2"></div>
        <center style="font-weight: bold; font-size: 15px">Tarih : <?= $_GET["tarih"] ?></center>
    </div>
    <br>
    <br>
    <br>
    <br>
    <div class="col-12">
        <div class="mt-5"></div>
        <span class="mx-3" style="font-size: 17px;font-weight: bold">Sayın <?= $_GET["cari_adi"] ?></span>
        <div class="col-12 row no-gutters mt-2">

            <div class="col">

                <table class="table table-sm table-bordered w-80 display nowrap" style="font-size: 17px">
                    <tr>
                        <th style="text-align: center">Açıklama</th>
                    </tr>
                    <tr>
                        <th>Sulama Ücreti</th>
                    </tr>
                    <tr>
                        <th>Aidat</th>
                    </tr>
                    <tr>
                        <th>Bağış Ve Yardım</th>
                    </tr>
                    <tr>
                        <th>Ortalık Sermayesi</th>
                    </tr>
                </table>
            </div>
            <div class="col">
                <table class="table table-sm table-bordered w-100 display nowrap" style="font-size: 17px">
                    <thead>
                    <tr>
                        <th style="text-align: center">TUTAR (TL)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="text-align: right;font-weight: bold">0,00 TL</td>
                    </tr>
                    <tr>
                        <td style="text-align: right;font-weight: bold"><?= $_GET["tutar"] ?> TL</td>
                    </tr>
                    <tr>
                        <td style="text-align: right;font-weight: bold">0,00 TL</td>
                    </tr>
                    <tr>
                        <td style="text-align: right;font-weight: bold">0,00 TL</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <table class="table table-sm table-bordered w-100 display">
                <thead>
                <tr>
                    <td style="font-weight: bold;font-size: 15px">Yalnız <?= $_GET["metinsel"] ?> Tahsil
                        Edilmiştir.
                    </td>
                </tr>
                </thead>
            </table>
        </div>

        <span class="mx-3">5520 Sayılı Kurumsal Vergisi Kanunu 4-K Maddesi uyarınca Kurumlar Vergisinden Muaftır</span>
        <div class="col-12 row">
            <div class="mt-5"></div>
            <div class="col-6">
                <center><span style="font-weight: bold;font-size: 15px;text-decoration:underline;">Parayı Alan</span>
                </center>
            </div>
            <div class="col-6">
                <center><span style="font-weight: bold;font-size: 15px;text-decoration:underline;">Parayı Veren</span>
                </center>
            </div>
        </div>
    </div>

</div>
<script src="./assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
<script src="./assets/vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
<script src="./assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
<script src="./assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
<script src="./assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>