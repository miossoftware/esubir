<?php

include '../DB.php';
date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=UTF-8');
session_start();
DB::connect();
$_POST["cari_key"] = $_SESSION["cari_key"];
$_POST["sube_key"] = $_SESSION["sube_key"];
$_GET["cari_key"] = $_SESSION["cari_key"];
$cari_key = $_SESSION["cari_key"];
$islem = $_GET["islem"];
$sube_key = $_SESSION["sube_key"];
$ek_sorgu = "";
if ($sube_key != 0) {
    $ek_sorgu = " AND sube_key='$sube_key'";
}
if ($islem == "fatura_turu_olustur_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $fatura_turu_ekle = DB::insert("fatura_tur_tanim", $_POST);
    if ($fatura_turu_ekle) {
        echo 2;
    } else {
        echo 1;
    }
}
if ($islem == "fatura_turleri_getir_sql") {
    $fatura_turleri_getir = DB::all_data("SELECT * FROM fatura_tur_tanim WHERE cari_key='$cari_key' AND status=1");
    if ($fatura_turleri_getir > 0) {
        echo json_encode($fatura_turleri_getir);
    } else {
        echo 2;
    }
}
if ($islem == "fatura_tur_sil_sql"){
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $fatura_tur_sil = DB::update("fatura_tur_tanim","id",$_POST["id"],$_POST);
    if ($fatura_tur_sil){
        echo 1;
    }else{
        echo 2;
    }
}
if ($islem == "fatura_tipi_kaydet_sql"){
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $fatura_turu_ekle = DB::insert("fatura_tip_tanim", $_POST);
    if ($fatura_turu_ekle) {
        echo 2;
    } else {
        echo 1;
    }
}
if ($islem == "fatura_tiplerini_getir_sql"){
    $fatura_turleri_getir = DB::all_data("SELECT * FROM fatura_tip_tanim WHERE cari_key='$cari_key' AND status=1");
    if ($fatura_turleri_getir > 0) {
        echo json_encode($fatura_turleri_getir);
    } else {
        echo 2;
    }
}
if ($islem == "fatura_tip_sil_sql"){
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $fatura_tur_sil = DB::update("fatura_tip_tanim","id",$_POST["id"],$_POST);
    if ($fatura_tur_sil){
        echo 1;
    }else{
        echo 2;
    }
}