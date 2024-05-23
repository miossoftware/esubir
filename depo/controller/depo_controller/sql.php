<?php
include '../DB.php';
include "../../../controller/DB.php";
date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=UTF-8');
session_start();
DBD::connect();
DB::connect();
$cari_key = $_SESSION["cari_key"];
$sube_key = $_SESSION["sube_key"];
$islem = $_GET["islem"];


if ($islem == "birimleri_getir_sql") {
    $birimler = DB::all_data("SELECT * FROM birim  WHERE status=1 AND cari_key='$cari_key'");
    if ($birimler > 0) {
        echo json_encode($birimler);
    } else {
        echo 2;
    }
}