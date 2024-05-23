<?php

include '../DB.php';
date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=UTF-8');
session_start();
DB::connect();
$cari_key = $_SESSION["cari_key"];
$sube_key = $_SESSION["sube_key"];
$islem = $_GET["islem"];

if ($islem == "tum_gideleri_getir_sql") {

    $merge = [];

    $sanayi_faturalar = DB::all_data("
SELECT
       sf.*,
       c.cari_adi,
       c.cari_kodu,
       SUM(sfu.genel_toplam) as toplam_tutar
FROM
     sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
INNER JOIN sanayi_fisi_urunler as sfu2 on sfu2.id=sfu.sanayi_fisid
WHERE sf.status=1 AND sf.cari_key='$cari_key' GROUP BY sf.id");

    $gider_faturalari = DB::all_data("
SELECT 
       mg.*,
       c.cari_adi,
       c.cari_kodu,
       SUM(mgu.genel_toplam) as muhasebe_toplam_tutar
FROM 
     muhasebe_gider as mg
INNER JOIN muhasebe_gider_urunler AS mgu on mgu.gider_id=mg.id
INNER JOIN cari as c on c.id=mgu.cari_id
WHERE mg.status=1 AND mg.cari_key='$cari_key' AND mgu.status=1 GROUP BY mg.id");

    if ($sanayi_faturalar > 0 && $gider_faturalari > 0) {
        $merge = array_merge($sanayi_faturalar, $gider_faturalari);
    } else if ($sanayi_faturalar > 0) {
        $merge = $sanayi_faturalar;
    } else if ($gider_faturalari > 0) {
        $merge = $gider_faturalari;
    }
    if ($merge > 0) {
        echo json_encode($merge);
    } else {
        echo 2;
    }
}
if ($islem == "yeni_muhasebe_gider_ekle_sql") {
    $arr = [
        'fatura_no' => $_POST["fatura_no"],
        'fatura_tarihi' => $_POST["fatura_tarihi"],
        'aciklama' => $_POST["aciklama"],
        'insert_userid' => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s"),
        'cari_key' => $cari_key,
        'sube_key' => $sube_key
    ];
    $muhasebe_gideri_ekle = DB::insert("muhasebe_gider", $arr);
    if ($muhasebe_gideri_ekle) {
        echo 500;
    } else {
        $son_eklenen = DB::single_query("SELECT id FROM muhasebe_gider where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        foreach ($_POST["basilacak_arr"] as $item) {
            $item["insert_userid"] = $_SESSION["user_id"];
            $item["insert_datetime"] = date("Y-m-d H:i:s");
            $item["cari_key"] = $cari_key;
            $item["sube_key"] = $sube_key;
            $item["gider_id"] = $son_eklenen["id"];
            $muhasebe_gider_urunu_ekle = DB::insert("muhasebe_gider_urunler", $item);
        }
        if ($muhasebe_gider_urunu_ekle) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "muhasebe_gider_sil_sql") {
    $_POST["status"] = 0;
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DB::update("muhasebe_gider", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "guncellenecek_gider_bilgilerini_getir_sql") {
    $id = $_GET["id"];
    $bilgileri_getir = DB::single_query("
SELECT
       mg.*,
       SUM(mgu.genel_toplam) as genel_toplam,
       SUM(mgu.iskonto_tutar) as iskonto_tutar,
       SUM(mgu.kdv_tutar) as kdv_tutar
FROM
     muhasebe_gider as mg
INNER JOIN muhasebe_gider_urunler as mgu on mgu.gider_id=mg.id
WHERE mg.status=1 AND mg.cari_key='$cari_key' AND mg.id='$id' AND mgu.status=1");
    if ($bilgileri_getir > 0) {
        echo json_encode($bilgileri_getir);
    } else {
        echo 2;
    }
}
if ($islem == "gider_fatura_urunleri_getir_sql") {
    $id = $_GET["id"];
    $gider_urunler = DB::all_data("
SELECT
       mgu.*,
       c.cari_adi,
       c.cari_kodu
FROM 
     muhasebe_gider_urunler as mgu
INNER JOIN cari as c on c.id=mgu.cari_id
WHERE 
      mgu.status=1 AND mgu.cari_key='$cari_key' AND mgu.gider_id='$id'");
    if ($gider_urunler > 0) {
        echo json_encode($gider_urunler);
    } else {
        echo 2;
    }
}