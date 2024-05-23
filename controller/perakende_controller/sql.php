<?php

include '../DB.php';
date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=UTF-8');
session_start();
DB::connect();
$islem = $_GET["islem"];
$cari_key = $_SESSION["cari_key"];
$sube_key = $_SESSION["sube_key"];

if ($islem == "girilen_stok_bilgileri_getir_sql") {
    $gelen_bilgi = $_GET["value"];
    $query = DB::single_query("
SELECT 
       s.*,
       b.birim_adi
FROM 
     stok as s
INNER JOIN birim as b on b.id=s.birim
WHERE s.status=1 AND s.cari_key='2' AND s.stok_kodu='$gelen_bilgi' OR s.barkod='$gelen_bilgi'");
    if ($query > 0) {
        echo json_encode($query);
    } else {
        echo 2;
    }
}
if ($islem == "perakende_kasa_satisi_olustur") {
    $arr = [
        'depo_id' => $_POST["depo_id"],
        'musteri_adi' => $_POST["musteri_adi"],
        'fatura_no' => $_POST["fatura_no"],
        'fatura_tarihi' => $_POST["fatura_tarihi"],
        'telefon' => $_POST["telefon"],
        'e_mail' => $_POST["e_posta"],
        'vergi_dairesi' => $_POST["vergi_dairesi"],
        'vergi_no' => $_POST["vergi_no"],
        'aciklama' => $_POST["aciklama"],
        'adres' => $_POST["adres"],
        'kasa_id' => $_POST["kasa_id"],
        'insert_userid' => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s"),
        'cari_key' => $_SESSION["cari_key"],
        'sube_key' => $_SESSION["sube_key"],
    ];
    $perakende_satisa_ekle = DB::insert("perakende_satis", $arr);
    if ($perakende_satisa_ekle) {
        echo 500;
    } else {
        $son_eklenen = DB::single_query("SELECT id FROM perakende_satis where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        foreach ($_POST["arr"] as $item) {
            $item["satis_id"] = $son_eklenen["id"];
            $item["cari_key"] = $cari_key;
            $item["sube_key"] = $sube_key;
            $item["insert_userid"] = $_SESSION["user_id"];
            $item["insert_datetime"] = date("Y-m-d H:i:s");
            $urunu_ekle = DB::insert("perakende_satis_urunler", $item);
        }
        if ($urunu_ekle) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "pos_cihazlarini_getir") {
    $pos_cihazlari = DB::all_data("
SELECT
       pt.*,
       b.banka_adi
FROM
     pos_tanim as pt 
INNER JOIN banka as b on b.id=pt.banka_id
WHERE pt.status=1 AND pt.cari_key='$cari_key'");
    if ($pos_cihazlari > 0) {
        echo json_encode($pos_cihazlari);
    } else {
        echo 2;
    }
}
if ($islem == "perakende_pos_satisi_olustur") {
    $arr = [
        'depo_id' => $_POST["depo_id"],
        'musteri_adi' => $_POST["musteri_adi"],
        'fatura_no' => $_POST["fatura_no"],
        'fatura_tarihi' => $_POST["fatura_tarihi"],
        'telefon' => $_POST["telefon"],
        'e_mail' => $_POST["e_posta"],
        'vergi_dairesi' => $_POST["vergi_dairesi"],
        'vergi_no' => $_POST["vergi_no"],
        'aciklama' => $_POST["aciklama"],
        'adres' => $_POST["adres"],
        'pos_id' => $_POST["pos_id"],
        'insert_userid' => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s"),
        'cari_key' => $_SESSION["cari_key"],
        'sube_key' => $_SESSION["sube_key"],
    ];
    $perakende_satisa_ekle = DB::insert("perakende_satis", $arr);
    if ($perakende_satisa_ekle) {
        echo 500;
    } else {
        $son_eklenen = DB::single_query("SELECT id FROM perakende_satis where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        foreach ($_POST["arr"] as $item) {
            $item["satis_id"] = $son_eklenen["id"];
            $item["cari_key"] = $cari_key;
            $item["sube_key"] = $sube_key;
            $item["insert_userid"] = $_SESSION["user_id"];
            $item["insert_datetime"] = date("Y-m-d H:i:s");
            $urunu_ekle = DB::insert("perakende_satis_urunler", $item);
        }
        if ($urunu_ekle) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "perakende_banka_satisi_olustur") {
    $arr = [
        'depo_id' => $_POST["depo_id"],
        'musteri_adi' => $_POST["musteri_adi"],
        'fatura_no' => $_POST["fatura_no"],
        'fatura_tarihi' => $_POST["fatura_tarihi"],
        'telefon' => $_POST["telefon"],
        'e_mail' => $_POST["e_posta"],
        'vergi_dairesi' => $_POST["vergi_dairesi"],
        'vergi_no' => $_POST["vergi_no"],
        'aciklama' => $_POST["aciklama"],
        'adres' => $_POST["adres"],
        'banka_id' => $_POST["banka_id"],
        'insert_userid' => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s"),
        'cari_key' => $_SESSION["cari_key"],
        'sube_key' => $_SESSION["sube_key"],
    ];
    $perakende_satisa_ekle = DB::insert("perakende_satis", $arr);
    if ($perakende_satisa_ekle) {
        echo 500;
    } else {
        $son_eklenen = DB::single_query("SELECT id FROM perakende_satis where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        foreach ($_POST["arr"] as $item) {
            $item["satis_id"] = $son_eklenen["id"];
            $item["cari_key"] = $cari_key;
            $item["sube_key"] = $sube_key;
            $item["insert_userid"] = $_SESSION["user_id"];
            $item["insert_datetime"] = date("Y-m-d H:i:s");
            $urunu_ekle = DB::insert("perakende_satis_urunler", $item);
        }
        if ($urunu_ekle) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "perakende_satislari_getir_sql") {

    $ek_sor = "";
    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])){
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        $ek_sor = " AND ps.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
    }

    $perakende_satislar = DB::all_data("
SELECT
       ps.*,
       b1.banka_adi as pos_banka_adi,
       b.banka_adi as banka_adi,
       k.kasa_adi as kasa_adi,
       d.depo_adi,
       (SELECT SUM(genel_toplam) FROM perakende_satis_urunler WHERE satis_id = ps.id) AS toplam_tutar
FROM 
     perakende_satis as ps
INNER JOIN perakende_satis_urunler as psu
LEFT JOIN banka as b on b.id=ps.banka_id
LEFT JOIN kasa as k on k.id=ps.kasa_id
LEFT JOIN pos_tanim as pt on pt.id=ps.pos_id
LEFT JOIN banka as b1 on b1.id=pt.banka_id
INNER JOIN depolar as d on d.id=ps.depo_id
WHERE ps.status=1 AND ps.cari_key='$cari_key' AND psu.status=1 $ek_sor  GROUP BY ps.id
");

    if ($perakende_satislar > 0) {
        echo json_encode($perakende_satislar);
    } else {
        echo 2;
    }
}
if ($islem == "perakende_satis_sil_sql") {
    $id = $_POST["id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["status"] = 0;
    $perakende_satis_sil = DB::update("perakende_satis", "id", $id, $_POST);
    if ($perakende_satis_sil) {
        echo 1;
    } else {
        echo 500;
    }
}
if ($islem == "secilen_kayit_bilgilerini_getir") {
    $id = $_GET["id"];
    $perakende_satis_bilgileri = DB::single_query("
SELECT
       ps.*,
       (SELECT SUM(kdv_tutar) FROM perakende_satis_urunler WHERE satis_id = ps.id) AS toplam_kdv,
       (SELECT SUM(iskonto_tutar) FROM perakende_satis_urunler WHERE satis_id = ps.id) AS toplam_iskonto,
       (SELECT SUM(ara_toplam) FROM perakende_satis_urunler WHERE satis_id = ps.id) AS toplam_ara_toplam,
       (SELECT SUM(genel_toplam) FROM perakende_satis_urunler WHERE satis_id = ps.id) AS toplam_genel_toplam
FROM
     perakende_satis as ps
INNER JOIN perakende_satis_urunler AS psu on psu.satis_id=ps.id
WHERE ps.status=1 AND ps.cari_key='$cari_key' AND ps.id='$id' AND psu.status=1");
    if ($perakende_satis_bilgileri > 0) {
        echo json_encode($perakende_satis_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "perakende_satis_urunleri_getir_sql") {
    $satis_id = $_GET["satis_id"];
    $satislar = DB::all_data("SELECT * FROM perakende_satis_urunler WHERE status=1 AND cari_key='$cari_key' AND satis_id='$satis_id'");
    if ($satislar > 0) {
        echo json_encode($satislar);
    } else {
        echo 2;
    }
}