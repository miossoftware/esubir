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
if ($islem == "depolari_getir"){
    $depolar_listesi = DB::all_data("SELECT * FROM depolar WHERE status=1 and cari_key='$cari_key' $ek_sorgu");
    if ($depolar_listesi > 0){
        echo json_encode($depolar_listesi);
    }else{
        echo 2;
    }
}
if ($islem == "yeni_depo_tanimla"){
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $varsayilan_varmi = DB::single_query("select * from depolar where status=1 and cari_key='$cari_key' $ek_sorgu NOT IN (varsayilan_depo=0)");
    if ($_POST["varsayilan_depo"] == "1" && $varsayilan_varmi > 0){
        $id = $varsayilan_varmi["id"];
        $arr = [
            'varsayilan_depo' => 0
        ];
        $varsayilani_degis = DB::update("depolar","id",$id,$arr);
        if ($varsayilani_degis){
            $depoyu_ekle = DB::insert("depolar",$_POST);
            if ($depoyu_ekle){
                echo 2;
            }else{
                echo 1;
            }
        }else{
            echo 2;
        }
    }else{
        $depoyu_ekle = DB::insert("depolar",$_POST);
        if ($depoyu_ekle){
            echo 2;
        }else{
            echo 1;
        }
    }
}
if ($islem == "depo_sil_sql"){
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $id = $_POST["id"];
    $cari_sil = DB::update("depolar", "id", $id, $_POST);
    if ($cari_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "depo_guncelle_sql"){
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $asil_id = $_POST["id"];
    $varsayilan_varmi = DB::single_query("select * from depolar where status=1 and cari_key='$cari_key' $ek_sorgu NOT IN (varsayilan_depo=0)");
    if ($_POST["varsayilan_depo"] == "1" && $varsayilan_varmi > 0) {
        $id = $varsayilan_varmi["id"];
        $arr = [
            'varsayilan_depo' => 0
        ];
        $varsayilani_degis = DB::update("depolar", "id", $id, $arr);
        if ($varsayilani_degis) {
            $cari_guncelle = DB::update("depolar", "id", $asil_id, $_POST);
            if ($cari_guncelle) {
                echo 1;
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    }else{
        $cari_sil = DB::update("depolar", "id", $asil_id, $_POST);
        $varsayilan_varmi = DB::single_query("select * from depolar where status=1 and cari_key='$cari_key' $ek_sorgu NOT IN (varsayilan_depo=0)");
        if ($cari_sil) {
            echo 1;
        } else {
            echo 2;
        }
    }
}
if ($islem == "depo_bilgileri_getir_sql"){
    $id = $_GET["id"];
    $depo_bilgileri = DB::single_query("SELECT * FROM depolar WHERE status=1 AND id='$id' $ek_sorgu and cari_key='$cari_key'");
    if ($depo_bilgileri > 0){
        echo json_encode($depo_bilgileri);
    }else{
        echo 2;
    }
}