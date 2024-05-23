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
if ($islem == "modelleri_getir_sql"){
    $modeller = DB::all_data("SELECT * FROM model WHERE status=1 and cari_key='$cari_key' ");
    if ($modeller > 0){
        echo json_encode($modeller);
    }else{
        echo 2;
    }
}
if ($islem == "marka_adi_getir"){
    $id = $_GET["id"];
    $marka_adi = DB::single_query("SELECT marka_adi FROM marka WHERE status=1 AND id='$id' and cari_key='$cari_key' ");
    if ($marka_adi > 0){
        echo json_encode($marka_adi);
    }else{
        echo 2;
    }
}
if ($islem == "markalari_getir_sql"){
    $markalar = DB::all_data("SELECT id,marka_adi FROM marka WHERE status=1 and cari_key='$cari_key' ");
    if ($markalar > 0){
        echo json_encode($markalar);
    }else{
        echo 2;
    }
}
if ($islem == "yeni_model_ekle"){
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $ana_grup_ekle = DB::insert("model",$_POST);
    if ($ana_grup_ekle){
        echo 2;
    }else{
        echo 1;
    }
}
if ($islem == "model_sil_sql"){
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $id = $_POST["id"];
    $cari_sil = DB::update("model", "id", $id, $_POST);
    if ($cari_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "model_bilgileri_getir"){
    $id = $_GET["id"];
    $model_bilgi = DB::single_query("SELECT * FROM model WHERE status=1 AND id='$id' and cari_key='$cari_key' ");
    if ($model_bilgi > 0){
        echo json_encode($model_bilgi);
    }else{
        echo 2;
    }
}
if ($islem == "model_guncelle_sql"){
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $id = $_POST["id"];
    $model_guncelle = DB::update("model", "id", $id, $_POST);
    if ($model_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}