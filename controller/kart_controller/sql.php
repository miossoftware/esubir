<?php
include '../DB.php';
date_default_timezone_set('Europe/Istanbul');
session_start();
DB::connect();
$cari_key = $_SESSION["cari_key"];
$sube_key = $_SESSION["sube_key"];
$islem = $_GET["islem"];

if ($islem == "yeni_kart_kaydet_sql") {
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $kart_kodu = $_POST["kart_kodu"];
    $varmi = DB::single_query("SELECT * FROM kredi_kart_tanim WHERE status=1 AND cari_key='$cari_key' AND kart_kodu='$kart_kodu'");
    if ($varmi > 0) {
        echo 300;
    } else {
        $kredi_karti_tanimla = DB::insert("kredi_kart_tanim", $_POST);
        if ($kredi_karti_tanimla) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "kredi_kartlarini_getir_sql") {
    $tum_kartlar = DB::all_data("
SELECT
       *,
       (SELECT SUM(tutar) FROM kart_harcama as kko WHERE kko.kart_id = kkt.id AND kko.status=1) AS toplam_cekilen,
       (SELECT SUM(borc) FROM kredi_kart_acilis as kka WHERE kka.kart_id = kkt.id AND kka.status=1) AS toplam_odenen1,
       (SELECT SUM(alacak) FROM kredi_kart_acilis as kka1 WHERE kka1.kart_id = kkt.id AND kka1.status=1) AS toplam_cekilen7,
       (SELECT SUM(tutar) FROM kaza_ceza_gider_fisleri as kcgf INNER JOIN kaza_ceza_gider as kcg on kcg.id=kcgf.gider_id WHERE  kcgf.kart_id = kkt.id AND kcgf.status=1 and kcg.status=1) AS toplam_cekilen1,
       (SELECT SUM(tutar) FROM yonetim_gider_fisi as ygf INNER JOIN yonetim_gider as yg on yg.id=ygf.gider_id WHERE  ygf.kart_id = kkt.id AND ygf.status=1 and yg.status=1) AS toplam_cekilen2,
       (SELECT SUM(tutar) FROM hgs_gider_fisleri as hgf INNER JOIN hgs_gider as hg on hg.id=hgf.gider_id WHERE  hgf.kart_id = kkt.id AND hgf.status=1 and hg.status=1) AS toplam_cekilen3,
       (SELECT SUM(tutar) FROM binek_hgs_gider_fisleri as bhgf INNER JOIN binek_hgs_gider as bhg on bhg.id=bhgf.gider_id WHERE  bhgf.kart_id = kkt.id AND bhgf.status=1 and bhg.status=1) AS toplam_cekilen9,
       (SELECT SUM(tutar) FROM arac_gider_fisi as agf INNER JOIN arac_gider as ag on ag.id=agf.gider_id WHERE  agf.kart_id = kkt.id AND agf.status=1 and ag.status=1) AS toplam_cekilen4,
       (SELECT SUM(tutar) FROM sgk_gider_fisleri as sgf INNER JOIN sgk_giderleri as sg on sg.id=sgf.gider_id WHERE  sgf.kart_id = kkt.id AND sgf.status=1 and sg.status=1) AS toplam_cekilen5,
       (SELECT SUM(tutar) FROM vergi_gider_fisi as vgf INNER JOIN vergi_gider as vg on vg.id=vgf.gider_id WHERE  vgf.kart_id = kkt.id AND vgf.status=1 and vg.status=1) AS toplam_cekilen6,
       (SELECT SUM(tutar) FROM binek_vergi_gider_fisleri as vgf INNER JOIN binek_vergi_gider as vg on vg.id=vgf.gider_id WHERE  vgf.kart_id = kkt.id AND vgf.status=1 and vg.status=1) AS toplam_cekilen10,
       (SELECT SUM(tutar) FROM kredi_kart_odeme as kko1 WHERE kko1.kart_id = kkt.id AND kko1.status=1) AS toplam_odenen,
       (SELECT SUM(tl_tutar) FROM binek_yakit_cikis as byc WHERE byc.kart_id = kkt.id AND byc.status!=0) AS toplam_cekilen8
FROM 
     kredi_kart_tanim as kkt
WHERE kkt.status=1 AND kkt.cari_key='$cari_key' GROUP BY kkt.id");

    if ($tum_kartlar > 0) {
        echo json_encode($tum_kartlar);
    } else {
        echo 2;
    }
}
if ($islem == "kartlari_getir_sql") {
    $kartlar = DB::all_data("SELECT * FROM kredi_kart_tanim WHERE status=1 AND cari_key='$cari_key'");
    if ($kartlar > 0) {
        echo json_encode($kartlar);
    } else {
        echo 2;
    }
}
if ($islem == "kredi_kart_acilislari_getir_sql") {
    $acilislar = DB::all_data("
SELECT 
       kka.*,
       kkt.kart_kodu,
       kkt.kart_adi
FROM
    kredi_kart_acilis as kka
INNER JOIN kredi_kart_tanim as kkt on kkt.id=kka.kart_id
WHERE kka.status=1 AND kka.cari_key='$cari_key'
    ");
    if ($acilislar > 0) {
        echo json_encode($acilislar);
    } else {
        echo 2;
    }
}
if ($islem == "kart_acilis_sil_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $acilis_fisi_ekle = DB::update("kredi_kart_acilis", "id", $_POST["id"], $_POST);
    if ($acilis_fisi_ekle) {
        echo 1;
    } else {
        echo 500;
    }
}
if ($islem == "kart_acilis_fisi_kaydet_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $acilis_fisi_ekle = DB::insert("kredi_kart_acilis", $_POST);
    if ($acilis_fisi_ekle) {
        echo 500;
    } else {
        echo 1;
    }
}
if ($islem == "kart_sil_main_sql") {
    $id = $_POST["id"];
    $urunu_varmi = DB::single_query("SELECT * FROM kredi_kartindan_odeme WHERE status=1 AND kart_id='$id'");
    if ($urunu_varmi > 0) {
        echo 300;
    } else {
        $_POST["delete_userid"] = $_SESSION["user_id"];
        $_POST["delete_datetime"] = date("Y-m-d H:i:s");
        $_POST["status"] = 0;
        $karti_sil = DB::update("kredi_kart_tanim", "id", $_POST["id"], $_POST);

        if ($karti_sil) {
            echo 1;
        } else {
            echo 500;
        }
    }
}
if ($islem == "kart_guncelle_sql") {
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $kredi_karti_tanimla = DB::update("kredi_kart_tanim", "id", $_POST["id"], $_POST);
    if ($kredi_karti_tanimla) {
        echo 1;
    } else {
        echo 500;
    }
}
if ($islem == "secilen_kart_bilgilerini_getir_sql") {
    $id = $_GET["id"];
    $bilgileri_ver = DB::single_query("
SELECT 
       pt.*
FROM 
     kredi_kart_tanim as pt
WHERE pt.status=1 AND pt.cari_key='$cari_key' AND pt.id='$id'");
    if ($bilgileri_ver > 0) {
        echo json_encode($bilgileri_ver);
    } else {
        echo 2;
    }
}
if ($islem == "tanimli_kredi_kartlari") {
    $tum_kartlar = DB::all_data("SELECT * FROM kredi_kart_tanim WHERE status=1 AND cari_key='$cari_key'");
    if ($tum_kartlar > 0) {
        echo json_encode($tum_kartlar);
    } else {
        echo 2;
    }
}
if ($islem == "kart_cekim_islemini_kaydet") {
    $arr = [
        "cari_id" => $_POST["cari_id"],
        "kart_id" => $_POST["kart_id"],
        "belge_no" => $_POST["belge_no"],
        "islem_tarihi" => $_POST["tarih"],
        "tutar" => $_POST["tutar"],
        "aciklama" => $_POST["aciklama"],
        "insert_userid" => $_SESSION["user_id"],
        "insert_datetime" => date("Y-m-d H:i:s"),
        "cari_key" => $cari_key,
        "sube_key" => $sube_key
    ];

    $pos_cekim_olustur = DB::insert("kredi_kartindan_odeme", $arr);
    if ($pos_cekim_olustur) {
        echo 500;
    } else {
//        $son_eklenen = DB::single_query("SELECT id FROM kredi_kartindan_odeme where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
//        foreach ($_POST["new_arr"] as $item) {
//            $item["cekim_id"] = $son_eklenen["id"];
//            $item["cari_key"] = $cari_key;
//            $item["sube_key"] = $sube_key;
//            $urunleri_ekle = DB::insert("kredi_kart_cekim_urunler", $item);
//        }
//        if ($urunleri_ekle) {
//            echo 500;
//        } else {
//            echo 1;
//        }
    }
}
if ($islem == "kart_cekim_kaydet_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $_SESSION["cari_key"];
    $_POST["sube_key"] = $_SESSION["sube_key"];
    $kredi_kart_harcama_ekle = DB::insert("kart_harcama", $_POST);
    if ($kredi_kart_harcama_ekle) {
        echo 500;
    } else {
        echo 1;
    }
}
if ($islem == "kart_cekimlerini_getir_sql") {
    $pos_cekimleri = DB::all_data("
SELECT 
    pc.*,
    pt.kart_adi,
    c.cari_adi,
    c.cari_kodu
FROM 
    kart_harcama as pc
INNER JOIN cari AS c on c.id=pc.cari_id
INNER JOIN kredi_kart_tanim AS pt on pt.id=pc.kart_id
WHERE 
    pc.status=1 AND pc.cari_key='$cari_key'");
    if ($pos_cekimleri > 0) {
        echo json_encode($pos_cekimleri);
    } else {
        echo 2;
    }
}
if ($islem == "kart_cekim_sil") {
    $id = $_POST["id"];
    $kart_cekim_urunler = DB::single_query("
SELECT 
    COALESCE(SUM(CASE WHEN pcu.status = 2 THEN pcu.taksit_tutari END), 0) AS toplam_tahsil_miktari
FROM 
    kredi_kartindan_odeme as pc
INNER JOIN cari AS c on c.id=pc.cari_id
INNER JOIN kredi_kart_tanim AS pt on pt.id=pc.kart_id
LEFT JOIN kredi_kart_cekim_urunler as pcu on pcu.cekim_id=pc.id
WHERE 
    pc.status=1 AND pc.cari_key='$cari_key'
GROUP BY 
    pc.id, c.cari_adi, c.cari_kodu");
    if ($kart_cekim_urunler["toplam_tahsil_miktari"] != 0) {
        echo 300;
    } else {
        $_POST["delete_datetime"] = date("Y-m-d H:i:s");
        $_POST["delete_userid"] = $_SESSION["user_id"];
        $_POST["status"] = 0;
        $cekim_sil = DB::update("kredi_kartindan_odeme", "id", $id, $_POST);
        if ($cekim_sil) {
            echo 1;
        } else {
            echo 500;
        }
    }
}
if ($islem == "kredi_karti_cekim_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $kredi_kart_cekim_iptal = DB::update("kart_harcama", "id", $_POST["id"], $_POST);
    if ($kredi_kart_cekim_iptal) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "odenebilir_kart_islemleri") {
    $harcamalar = DB::all_data("
SELECT
       kkcu.*,
       c.cari_adi,
       kkt.kart_adi,
       kko.cari_id,
       kkt.id as kart_id
FROM 
     kredi_kart_cekim_urunler as kkcu
INNER JOIN kredi_kartindan_odeme as kko on kko.id=kkcu.cekim_id
INNER JOIN cari as c on c.id=kko.cari_id
INNER JOIN kredi_kart_tanim as kkt on kkt.id=kko.kart_id
WHERE kkcu.status=1 AND kkcu.cari_key='$cari_key'");
    if ($harcamalar > 0) {
        echo json_encode($harcamalar);
    } else {
        echo 2;
    }
}
if ($islem == "kart_odemelerini_kaydet_sql") {
    $item["cari_key"] = $cari_key;
    $item["sube_key"] = $sube_key;
    $item["insert_userid"] = $_SESSION["user_id"];
    $item["insert_datetime"] = date("Y-m-d H:i:s");
    $pos_cekim_tahsil_et = DB::insert("kredi_karti_odemeler", $item);
    if ($pos_cekim_tahsil_et) {
        echo 1;
    } else {
        echo 500;
    }
}
if ($islem == "kredi_kart_odeme_yap_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $_SESSION["cari_key"];
    $_POST["sube_key"] = $_SESSION["sube_key"];
    $kredi_karti_odeme_yap = DB::insert("kredi_kart_odeme", $_POST);
    if ($kredi_karti_odeme_yap) {
        echo 500;
    } else {
        echo 1;
    }
}
if ($islem == "karttan_odenenleri_getir") {
    $odemeler = DB::all_data("
SELECT 
       kko.*,
       b.hesap_adi,
       b.banka_kodu as hesap_kodu,
       kkt.kart_adi
FROM 
     kredi_kart_odeme as kko
INNER JOIN banka as b on b.id=kko.banka_id
INNER JOIN kredi_kart_tanim AS kkt on kkt.id=kart_id
WHERE kko.status=1 AND kko.cari_key='$cari_key'");
    if ($odemeler > 0) {
        echo json_encode($odemeler);
    } else {
        echo 2;
    }
}
if ($islem == "kart_odemesini_iptal_et_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $sil = DB::update("kredi_kart_odeme", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
//    $tekrar_guncelle = DB::update("kredi_karti_odemeler", "id", $_POST["id"], $_POST);
//    if ($tekrar_guncelle) {
//        $id = $_POST["id"];
//        $bilgiler = DB::single_query("SELECT * FROM kredi_karti_odemeler WHERE id='$id'");
//        $pos_cekimid = $bilgiler["kart_cekimid"];
//        $arr = [
//            'status' => 1,
//            'update_userid' => $_SESSION["user_id"],
//            'update_datetime' => date("Y-m-d H:i:s")
//        ];
//        $guncelle = DB::update("kredi_kart_cekim_urunler", "id", $pos_cekimid, $arr);
//        if ($guncelle) {
//            echo 1;
//        } else {
//            echo 500;
//        }
//    } else {
//        echo 500;
//    }
}