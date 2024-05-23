<?php
include "../../../controller/DB.php";
date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=UTF-8');
session_start();
DB::connect();
$cari_key = $_SESSION["cari_key"];
$sube_key = $_SESSION["sube_key"];
$islem = $_GET["islem"];

if ($islem == "konteyner_irsaliye_bilgisi_cek") {
    $konteyner_no = $_GET["konteyner_no"];
    $irsaliye_bilgileri = DB::single_query("
SELECT 
       ki.*,
       c.cari_adi,
       c.cari_kodu,
       ak.plaka_no,
       c2.cari_adi as arac_cari
FROM
     konteyner_irsaliye as ki
INNER JOIN cari as c on c.id=ki.cari_id
INNER JOIN arac_kartlari as ak on ak.id=ki.plaka_id
LEFT JOIN cari as c2 on c2.id=ak.cari_id
WHERE ki.status!=0  AND  ki.konteyner_no1='$konteyner_no' OR ki.konteyner_no2='$konteyner_no' AND ki.depolama_kesildi=1");
    if ($irsaliye_bilgileri > 0) {
        echo json_encode($irsaliye_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "depo_konteyner_girisi_ekle_sql") {
    $arac_id = $_POST["plaka_id"];
    $arac_kiralik_mi = DB::single_query("SELECT * FROM arac_kartlari WHERE status=1 AND id='$arac_id'");
    if ($arac_kiralik_mi["arac_grubu"] == "Kiralık") {
        $_POST["surucu_prim"] = 0;
        $_POST["prim_yazilsin"] = 2;
    } else {
        $_POST["arac_kirasi"] = 0;
    }

    if ($_POST["prim_yazilsin"] == 2) {
        $_POST["surucu_prim"] = 0;
    }

    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");

    $stok_id = DB::single_query("SELECT * FROM stok WHERE status=1 AND stok_kodu='DEPO.001'");
    $_POST["stok_id"] = $stok_id["id"];

    $konteyner_no = $_POST["konteyner_no"];

    $depodami = DB::single_query("SELECT * FROM depo_konteyner_giris WHERE status=1 AND cari_key='$cari_key' AND konteyner_no='$konteyner_no'");
    if ($depodami > 0) {
        echo 300;
    } else {
        $depoya_giris_ekle = DB::insert("depo_konteyner_giris", $_POST);
        if ($depoya_giris_ekle) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "depodaki_konteynerleri_getir_sql") {
    $ek_sorgu = "";
    if (isset($_GET["cari_id"])) {
        if ($_GET["cari_id"] != "") {
            $cari_id = $_GET["cari_id"];
            $ek_sorgu = " AND dkg.depo_cari_id='$cari_id'";
        }
    }
    $depodaki_konteynerler = DB::all_data("
SELECT
       dkg.*,
       depo_cari.cari_adi as depo_adi,
       depo_cari.cari_kodu as depo_kodu,
       c.cari_adi as firma_adi,
       c.cari_kodu as firma_kodu,
       ak.plaka_no,
       arac_cari.cari_adi as arac_carisi,
       s.stok_kodu as hizmet_kodu,
       s.stok_adi as hizmet_adi
FROM
     depo_konteyner_giris as dkg
INNER JOIN cari as depo_cari on depo_cari.id=dkg.depo_cari_id
INNER JOIN cari as c on c.id=dkg.firma_cari_id
INNER JOIN arac_kartlari as ak on ak.id=dkg.plaka_id
LEFT JOIN cari as arac_cari on arac_cari.id=ak.cari_id
INNER JOIN stok as s on s.id=dkg.stok_id
WHERE dkg.status=1 AND dkg.cari_key='$cari_key' $ek_sorgu");

    if ($depodaki_konteynerler > 0) {
        echo json_encode($depodaki_konteynerler);
    } else {
        echo 2;
    }
}
if ($islem == "depodan_giris_sil_sql") {
    $_POST["status"] = 0;
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $sil = DB::update("depo_konteyner_giris", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "secilen_konteyneri_getir_sql") {
    $id = $_GET["id"];
    $depodaki_konteynerler = DB::single_query("
SELECT
       dkg.*,
       depo_cari.cari_adi as depo_adi,
       depo_cari.cari_kodu as depo_kodu,
       c.cari_adi as firma_adi,
       c.cari_kodu as firma_kodu,
       ak.plaka_no,
       arac_cari.cari_adi as arac_carisi,
       s.stok_kodu as hizmet_kodu,
       s.stok_adi as hizmet_adi
FROM
     depo_konteyner_giris as dkg
INNER JOIN cari as depo_cari on depo_cari.id=dkg.depo_cari_id
INNER JOIN cari as c on c.id=dkg.firma_cari_id
INNER JOIN arac_kartlari as ak on ak.id=dkg.plaka_id
LEFT JOIN cari as arac_cari on arac_cari.id=ak.cari_id
INNER JOIN stok as s on s.id=dkg.stok_id
WHERE dkg.status=1 AND dkg.cari_key='$cari_key' AND dkg.id='$id'");

    if ($depodaki_konteynerler > 0) {
        echo json_encode($depodaki_konteynerler);
    } else {
        echo 2;
    }
}
if ($islem == "hizmet_primi_sql") {
    $stok_id = $_GET["stok_id"];
    $stok_bilgi = DB::single_query("SELECT yol_primi FROM stok WHERE id='$stok_id'");
    if ($stok_bilgi > 0) {
        echo json_encode($stok_bilgi);
    } else {
        echo 2;
    }
}
if ($islem == "depodan_konteyneri_cikart_sql") {

    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $depo_hizmeti = DB::single_query("SELECT * FROM stok WHERE status=1 AND stok_kodu='DEPO.001'");
    $_POST["stok_id"] = $depo_hizmeti["id"];

    $depo_giris_id = $_POST["depo_giris_id"];

    $depodami = DB::single_query("SELECT * FROM depo_konteyner_cikis WHERE status=1 AND cari_key='$cari_key' AND depo_giris_id='$depo_giris_id'");
    if ($depodami > 0) {
        echo 300;
    } else {
        $depoya_giris_ekle = DB::insert("depo_konteyner_cikis", $_POST);
        if ($depoya_giris_ekle) {
            echo 500;
        } else {
            $arr = [
                'status' => 2
            ];
            $giris_guncelle = DB::update("depo_konteyner_giris", "id", $depo_giris_id, $arr);
            if ($giris_guncelle) {
                echo 1;
            } else {
                echo 2;
            }
        }
    }
}
if ($islem == "cikan_konteynerleri_getir_sql") {
    $cikan_konteynerler = DB::all_data("
SELECT
       dkc.*,
       dkg.cutt_off_tarihi,
       dkg.demoraj_tarihi,
       dkg.ardiye_giris_tarih,
       dkg.tasima_tipi,
       dkg.konteyner_tipi,
       dkg.konteyner_no,
       dkg.tarih as giris_tarihi,
       fc.cari_adi as firma_adi,
       fc.cari_kodu as firma_kodu,
       ak.plaka_no,
       arac_cari.cari_adi as arac_cari,
       s.stok_adi as hizmet_adi,
       s.stok_kodu as hizmet_kodu,
       depo_cari.cari_adi as depo_adi,
       depo_cari.cari_kodu as depo_kodu
FROM
     depo_konteyner_cikis as dkc
INNER JOIN depo_konteyner_giris as dkg on dkg.id=dkc.depo_giris_id
INNER JOIN cari as fc on fc.id=dkg.firma_cari_id
INNER JOIN arac_kartlari as ak on ak.id=dkc.plaka_id
LEFT JOIN cari as arac_cari on arac_cari.id=ak.cari_id
INNER JOIN stok as s on s.id=dkc.stok_id
INNER JOIN cari as depo_cari on depo_cari.id=dkc.depo_id
WHERE
      dkc.status=1 AND dkc.cari_key='$cari_key'");
    if ($cikan_konteynerler > 0) {
        echo json_encode($cikan_konteynerler);
    } else {
        echo 2;
    }
}
if ($islem == "depodan_cikis_sil_sql") {
    $id = $_POST["id"];
    $bilgileri = DB::single_query("SELECT * FROM depo_konteyner_cikis WHERE status=1 AND id='$id'");
    if ($bilgileri > 0) {
        $depo_giris_id = $bilgileri["depo_giris_id"];
        $arr = [
            'status' => 1
        ];
        $listeye_dusur = DB::update("depo_konteyner_giris", "id", $depo_giris_id, $arr);
        if ($listeye_dusur) {
            $_POST["status"] = 0;
            $_POST["delete_userid"] = $_SESSION["user_id"];
            $_POST["delete_datetime"] = date("Y-m-d H:i:s");
            $sil = DB::update("depo_konteyner_cikis", "id", $_POST["id"], $_POST);
            if ($sil) {
                echo 1;
            } else {
                echo 2;
            }
        } else {
            echo 500;
        }
    }
}
if ($islem == "depo_cikis_bilgilerini_getir_sql") {
    $id = $_GET["id"];
    $nakliye_depo_cikis = DB::single_query("
SELECT 
       dkc.*,
       depo_cari.cari_adi as depo_adi,
       depo_cari.cari_kodu as depo_kodu,
       ak.plaka_no,
       c2.cari_adi as arac_cari,
       dkg.konteyner_no,
       dkg.tarih as giris_tarih,
       c3.cari_adi as firma_adi,
       ak.arac_grubu,
       c3.cari_kodu as firma_kodu,
       dkg.konteyner_tipi,
       dkg.tasima_tipi,
       s.stok_adi
FROM
     depo_konteyner_cikis as dkc
INNER JOIN cari as depo_cari on depo_cari.id=dkc.depo_id
INNER JOIN arac_kartlari as ak on ak.id=dkc.plaka_id
INNER JOIN stok as s on s.id=dkc.stok_id
LEFT JOIN cari as c2 on c2.id=ak.cari_id
INNER JOIN depo_konteyner_giris as dkg on dkg.id=dkc.depo_giris_id
INNER JOIN cari as c3 on c3.id=dkg.firma_cari_id
WHERE dkc.status=1 AND dkc.cari_key='$cari_key' AND dkc.id='$id'");
    if ($nakliye_depo_cikis > 0) {
        echo json_encode($nakliye_depo_cikis);
    } else {
        echo 2;
    }
}
if ($islem == "depodan_konteyneri_guncelle_sql") {
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DB::update("depo_konteyner_cikis", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "ek_hizmetleri_getir") {
    $ek_hizmetler = DB::all_data("SELECT * FROM stok WHERE status=1 AND cari_key='$cari_key' AND stok_alt_grupid='2' AND stok_kodu='CNTR.00001' OR stok_kodu='CNTR.00002'");
    if ($ek_hizmetler > 0) {
        echo json_encode($ek_hizmetler);
    } else {
        echo 2;
    }
}
if ($islem == "depo_giris_bilgileri_getir_sql") {
    $id = $_GET["id"];

    $nakliye_depo_giris_bilgileri = DB::single_query("
SELECT 
       dkg.*,
       c1.cari_adi as depo_adi,
       c1.cari_kodu as depo_kodu,
       c2.cari_adi as firma_adi,
       c2.cari_kodu as firma_kodu,
       ak.plaka_no,
       c3.cari_adi as arac_cari
FROM
     depo_konteyner_giris as dkg
INNER JOIN cari as c1 on c1.id=dkg.depo_cari_id
INNER JOIN cari as c2 on c2.id=dkg.firma_cari_id
INNER JOIN arac_kartlari as ak on ak.id=dkg.plaka_id
LEFT JOIN cari as c3 on c3.id=ak.cari_id
WHERE dkg.status=1 AND dkg.cari_key='$cari_key' AND dkg.id='$id'");
    if ($nakliye_depo_giris_bilgileri > 0) {
        echo json_encode($nakliye_depo_giris_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "depo_konteyner_girisi_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");

    $guncelle = DB::update("depo_konteyner_giris", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "depodaki_konteynerleri_getir_sql2"){
    $ek_sorgu = "";
    if (isset($_GET["cari_id"])) {
        if ($_GET["cari_id"] != "") {
            $cari_id = $_GET["cari_id"];
            $ek_sorgu = " AND dkg.depo_cari_id='$cari_id'";
        }
    }
    $depodaki_konteynerler = DB::all_data("
SELECT
       dkg.*,
       depo_cari.cari_adi as depo_adi,
       depo_cari.cari_kodu as depo_kodu,
       c.cari_adi as firma_adi,
       c.cari_kodu as firma_kodu,
       ak.plaka_no,
       arac_cari.cari_adi as arac_carisi,
       s.stok_kodu as hizmet_kodu,
       s.stok_adi as hizmet_adi
FROM
     depo_konteyner_giris as dkg
INNER JOIN cari as depo_cari on depo_cari.id=dkg.depo_cari_id
INNER JOIN cari as c on c.id=dkg.firma_cari_id
INNER JOIN arac_kartlari as ak on ak.id=dkg.plaka_id
LEFT JOIN cari as arac_cari on arac_cari.id=ak.cari_id
INNER JOIN stok as s on s.id=dkg.stok_id
WHERE  dkg.cari_key='$cari_key' $ek_sorgu");

    if ($depodaki_konteynerler > 0) {
        echo json_encode($depodaki_konteynerler);
    } else {
        echo 2;
    }
}
if ($islem == "depodan_giris_sil_sql") {
    $_POST["status"] = 0;
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $sil = DB::update("depo_konteyner_giris", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}