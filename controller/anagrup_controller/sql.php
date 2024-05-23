<?php
include '../DB.php';
date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=UTF-8');
session_start();
DB::connect();

$_POST["cari_key"] = $_SESSION["cari_key"];
$_POST["sube_key"] = $_SESSION["sube_key"];
$cari_key = $_SESSION["cari_key"];
$sube_key = $_SESSION["sube_key"];
$ek_sorgu = "";
if ($sube_key != 0){
    $ek_sorgu = " AND sube_key='$sube_key'";
}
$islem = $_GET["islem"];
if ($islem == "ana_grup_listesi_getir"){
    $veriler = DB::all_data("SELECT * FROM stok_ana_grup WHERE status=1 and cari_key='$cari_key' ");
    if ($veriler > 0){
        echo json_encode($veriler);
    }else{
        echo 2;
    }
}
if ($islem == "yeni_ana_grup"){
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $ana_grup_ekle = DB::insert("stok_ana_grup",$_POST);
    if ($ana_grup_ekle){
        echo 2;
    }else{
        echo 1;
    }
}
if ($islem == "ana_grup_sil_sql"){
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $id = $_POST["id"];
    $cari_sil = DB::update("stok_ana_grup", "id", $id, $_POST);
    if ($cari_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "anagrup_bilgileri_getir_sql"){
    $id = $_GET["id"];
    $ana_grup_bilgi = DB::single_query("SELECT * FROM stok_ana_grup WHERE status=1 AND id='$id' and cari_key='$cari_key' ");
    if ($ana_grup_bilgi > 0){
        echo json_encode($ana_grup_bilgi);
    }else{
        echo 2;
    }
}
if ($islem == "ana_grup_guncelle_sql"){
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $id = $_POST["id"];
    $ana_grup_guncelle = DB::update("stok_ana_grup", "id", $id, $_POST);
    if ($ana_grup_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}