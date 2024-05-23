<?php

include '../DB.php';

date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=UTF-8');

session_start();

DB::connect();
$islem = $_GET["islem"];
$cari_key = $_SESSION["cari_key"];
$sube_key = $_SESSION["sube_key"];


if ($islem == "pos_tanim_bankalar_getir_sql") {

    $bankalar = DB::all_data("SELECT * FROM banka WHERE status=1 AND cari_key='$cari_key'");

    if ($bankalar > 0) {

        echo json_encode($bankalar);

    } else {

        echo 2;

    }

}

if ($islem == "secilen_banka_bilgilerini_getir_sql") {

    $id = $_GET["id"];

    $bilgileri = DB::single_query("SELECT * FROM banka WHERE status=1 AND cari_key='$cari_key' AND id='$id'");

    if ($bilgileri > 0) {

        echo json_encode($bilgileri);

    } else {

        echo 2;

    }

}

if ($islem == "cari_kodu_bilgileri_getir_sql") {

    $cari_kodu = $_GET["cari_kodu"];

    $cari_bilgileri = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' AND cari_kodu='$cari_kodu'");

    if ($cari_bilgileri > 0) {

        echo json_encode($cari_bilgileri);

    } else {

        echo 2;

    }

}

if ($islem == "yeni_pos_kaydet_sql") {

    $_POST["insert_userid"] = $_SESSION["user_id"];

    $_POST["insert_datetime"] = date("Y-m-d h:i:s");

    $_POST["cari_key"] = $cari_key;

    $_POST["sube_key"] = $sube_key;

    $yeni_pos_tanimla = DB::insert("pos_tanim", $_POST);

    if ($yeni_pos_tanimla) {

        echo 500;

    } else {

        echo 1;

    }

}

if ($islem == "poslari_getir_sql") {

    $poslar = DB::all_data("
SELECT 
       pt.*,
       b.banka_kodu,
       b.banka_adi,
       b.hesap_adi,
       (SELECT SUM(tutar) FROM pos_cekim WHERE pos_id = pt.id) AS toplam_cekilen,
       (SELECT SUM(tutar) FROM bireysel_tahakkuk WHERE pos_id = pt.id and status=1) AS toplam_cekilen2
FROM 
     pos_tanim as pt
INNER JOIN banka as b on b.id=pt.banka_id
WHERE pt.status=1 AND pt.cari_key='$cari_key' GROUP BY pt.id");

    if ($poslar > 0) {
        echo json_encode($poslar);
    } else {
        echo 2;
    }
}

if ($islem == "secilen_pos_bilgilerini_getir_sql") {

    $id = $_GET["id"];

    $bilgileri_ver = DB::single_query("

SELECT 

       pt.*,

       b.hesap_adi,

       b.sube_adi,

       b.iban_no,

       c.cari_adi,

       c.cari_kodu

FROM 

     pos_tanim as pt

INNER JOIN banka as b on b.id=pt.banka_id

INNER JOIN cari as c on c.id=pt.cari_id

WHERE pt.status=1 AND pt.cari_key='$cari_key' AND pt.id='$id'");

    if ($bilgileri_ver > 0) {

        echo json_encode($bilgileri_ver);

    } else {

        echo 2;

    }

}

if ($islem == "pos_guncelle_sql") {

    $_POST["update_userid"] = $_SESSION["user_id"];

    $_POST["update_datetime"] = date("Y-m-d h:i:s");

    $yeni_pos_tanimla = DB::update("pos_tanim", "id", $_POST["id"], $_POST);

    if ($yeni_pos_tanimla) {

        echo 1;

    } else {

        echo 500;

    }

}

if ($islem == "pos_sil_main_sql") {

    $_POST["delete_userid"] = $_SESSION["user_id"];

    $_POST["status"] = 0;

    $_POST["delete_datetime"] = date("Y-m-d H:i:s");

    $id = $_POST["id"];


    $urunu_varmi = DB::single_query("SELECT * FROM pos_cekim WHERE status=1 AND pos_id='$id'");

    if ($urunu_varmi > 0) {

        echo 300;

    } else {

        $pos_sil_sql = DB::update("pos_tanim", "id", $id, $_POST);

        if ($pos_sil_sql) {

            echo 1;

        } else {

            echo 2;

        }

    }

}

if ($islem == "tanimli_pos_cihazlarini_getir") {

    $tum_pos_cihazlari = DB::all_data("

SELECT

       pt.*,

       b.banka_adi

FROM 

     pos_tanim as pt

INNER JOIN banka as b on b.id=pt.banka_id

WHERE pt.status=1 AND pt.cari_key='$cari_key'");

    if ($tum_pos_cihazlari > 0) {

        echo json_encode($tum_pos_cihazlari);

    } else {

        echo 2;

    }

}

if ($islem == "pos_cekim_islemini_kaydet") {

    $arr = [

        "cari_id" => $_POST["cari_id"],

        "pos_id" => $_POST["pos_id"],

        "tahsil_tarihi" => $_POST["tahsil_tarihi"],

        "belge_no" => $_POST["belge_no"],

        "tarih" => $_POST["tarih"],

        "tutar" => $_POST["tutar"],

        "taksit_sayisi" => $_POST["taksit_sayisi"],

        "aciklama" => $_POST["aciklama"],

        "insert_userid" => $_SESSION["user_id"],

        "insert_datetime" => date("Y-m-d H:i:s"),

        "cari_key" => $cari_key,

        "sube_key" => $sube_key

    ];


    $pos_cekim_olustur = DB::insert("pos_cekim", $arr);

    if ($pos_cekim_olustur) {

        echo 500;

    } else {

        $son_eklenen = DB::single_query("SELECT id FROM pos_cekim where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");

        foreach ($_POST["new_arr"] as $item) {

            $item["cekim_id"] = $son_eklenen["id"];

            $item["cari_key"] = $cari_key;

            $item["sube_key"] = $sube_key;

            $urunleri_ekle = DB::insert("pos_cekim_urunler", $item);

        }

        if ($urunleri_ekle) {

            echo 500;

        } else {

            echo 1;

        }

    }

}

if ($islem == "pos_cekimlerini_getir_sql") {

    $pos_cekimleri = DB::all_data("

SELECT 

    pc.*,

    b.banka_adi,

    c.cari_adi,

    c.cari_kodu,

    COALESCE(SUM(CASE WHEN pcu.status = 2 THEN pcu.taksit_tutari END), 0) AS toplam_tahsil_miktari

FROM 

    pos_cekim as pc

INNER JOIN cari AS c on c.id=pc.cari_id

INNER JOIN pos_tanim AS pt on pt.id=pc.pos_id

INNER JOIN banka AS b on b.id=pt.banka_id

LEFT JOIN pos_cekim_urunler as pcu on pcu.cekim_id=pc.id

WHERE 

    pc.status=1 AND pc.cari_key='$cari_key'

GROUP BY 

    pc.id, b.banka_adi, c.cari_adi, c.cari_kodu");

    if ($pos_cekimleri > 0) {

        echo json_encode($pos_cekimleri);

    } else {

        echo 2;

    }

}

if ($islem == "tahsil_edilebilir_pos_islemleri") {

    $islemler = DB::all_data("

SELECT

       pcu.*,

       c.cari_adi,

       pc.cari_id as cari_id,

       pc.tarih as kayit_tarih,

       b.banka_adi,

       pc.pos_id as pid,

       pt.komisyon_orani

FROM 

     pos_cekim_urunler as pcu

INNER JOIN pos_cekim as pc on pc.id=pcu.cekim_id

INNER JOIN cari as c on pc.cari_id=c.id

INNER JOIN pos_tanim as pt on pt.id=pc.pos_id

INNER JOIN banka as b on b.id=pt.banka_id

WHERE pcu.status=1 AND pc.status=1 AND pcu.cari_key='$cari_key'");

    if ($islemler > 0) {

        echo json_encode($islemler);

    } else {

        echo 2;

    }

}

if ($islem == "tahsilleri_kaydet_sql") {

    foreach ($_POST["arr"] as $item) {

        $item["cari_key"] = $cari_key;

        $item["sube_key"] = $sube_key;

        $item["insert_userid"] = $_SESSION["user_id"];

        $item["insert_datetime"] = date("Y-m-d H:i:s");

        $pos_cekim_tahsil_et = DB::insert("pos_cekim_tahsiller", $item);

        $arr = [

            'status' => 2,

            'update_userid' => $_SESSION["user_id"],

            'update_datetime' => date("Y-m-d H:i:s")

        ];

        if ($pos_cekim_tahsil_et) {


        } else {

            $id = $item["pos_cekimid"];

            $durumu_degistir = DB::update("pos_cekim_urunler", "id", $id, $arr);

        }

    }

    if ($durumu_degistir) {

        echo 1;

    } else {

        echo 500;

    }

}

if ($islem == "tahsil_edilenleri_getir_sql") {

    $tum_kesilen_tahsilleri_getir = DB::all_data("

SELECT 

       pct.*,

       b.banka_adi,

       c.cari_adi,

       c.cari_kodu

FROM 

     pos_cekim_tahsiller as pct

INNER JOIN cari as c on pct.cari_id=c.id

INNER JOIN pos_tanim as pt on pt.id=pct.pos_id

INNER JOIN banka as b on b.id=pt.banka_id

WHERE pct.status=1 AND pct.cari_key='$cari_key'

");

    if ($tum_kesilen_tahsilleri_getir > 0) {

        echo json_encode($tum_kesilen_tahsilleri_getir);

    } else {

        echo 2;

    }

}

if ($islem == "tahsili_iptal_et_sql") {

    $_POST["delete_userid"] = $_SESSION["user_id"];

    $_POST["delete_datetime"] = date("Y-m-d H:i:s");

    $_POST["status"] = 0;

    $tekrar_guncelle = DB::update("pos_cekim_tahsiller", "id", $_POST["id"], $_POST);

    if ($tekrar_guncelle) {

        $id = $_POST["id"];

        $bilgiler = DB::single_query("SELECT * FROM pos_cekim_tahsiller WHERE id='$id'");

        $pos_cekimid = $bilgiler["pos_cekimid"];

        $arr = [

            'status' => 1,

            'update_userid' => $_SESSION["user_id"],

            'update_datetime' => date("Y-m-d H:i:s")

        ];

        $guncelle = DB::update("pos_cekim_urunler", "id", $pos_cekimid, $arr);

        if ($guncelle) {

            echo 1;

        } else {

            echo 500;

        }

    } else {

        echo 500;

    }

}

if ($islem == "pos_cekim_sil_sql") {

    $id = $_POST["id"];

    $arr = [];

    $pos_cekim_urunler = DB::single_query("SELECT 

    pc.*,

    b.banka_adi,

    c.cari_adi,

    c.cari_kodu,

    COALESCE(SUM(CASE WHEN pcu.status = 2 THEN pcu.taksit_tutari END), 0) AS toplam_tahsil_miktari

FROM 

    pos_cekim as pc

INNER JOIN cari AS c on c.id=pc.cari_id

INNER JOIN pos_tanim AS pt on pt.id=pc.pos_id

INNER JOIN banka AS b on b.id=pt.banka_id

LEFT JOIN pos_cekim_urunler as pcu on pcu.cekim_id=pc.id

WHERE 

    pc.status=1 AND pc.cari_key='$cari_key' AND pc.id='$id'

GROUP BY 

    pc.id, b.banka_adi, c.cari_adi, c.cari_kodu");


    if ($pos_cekim_urunler["toplam_tahsil_miktari"] != 0) {

        echo 300;

    } else {

        $_POST["delete_datetime"] = date("Y-m-d H:i:s");

        $_POST["delete_userid"] = $_SESSION["user_id"];

        $_POST["status"] = 0;

        $cekim_sil = DB::update("pos_cekim", "id", $id, $_POST);

        if ($cekim_sil) {

            echo 1;

        } else {

            echo 500;

        }

    }

}