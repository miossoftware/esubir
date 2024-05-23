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
if ($sube_key != 0){
    $ek_sorgu = " AND sube_key='$sube_key'";
}
if ($islem == "birim_listesi_getir"){
    $veriler = DB::all_data("SELECT * FROM birim WHERE status=1 and cari_key='$cari_key'");
    if ($veriler > 0){
        echo json_encode($veriler);
    }else{
        echo 2;
    }
}
if ($islem == "yeni_birim_ekle"){
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $cariyi_ekle = DB::insert("birim",$_POST);
    if ($cariyi_ekle){
        echo 2;
    }else{
        echo 1;
    }
}
if ($islem == "birim_sil_sql"){
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $id = $_POST["id"];
    $cari_sil = DB::update("birim", "id", $id, $_POST);
    if ($cari_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "birim_bilgileri_getir"){
    $id = $_GET["id"];
    $birim_bilgileri = DB::single_query("SELECT * FROM birim WHERE status=1 AND id='$id' and cari_key='$cari_key'");
    if ($birim_bilgileri > 0){
        echo json_encode($birim_bilgileri);
    }else{
        echo 2;
    }
}
if ($islem == "birim_guncelle_sql"){
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $id = $_POST["id"];
    $birim_guncelle = DB::update("birim", "id", $id, $_POST);
    if ($birim_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}