<?php
include '../DB.php';
include "../../../controller/DB.php";
date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=UTF-8');
session_start();
DBD::connect();
DB::connect();
$cari_key = $_SESSION["cari_key"];
$sube_key = $_SESSION["sube_key"];
$islem = $_GET["islem"];

if ($islem == "depo_adresi_kaydet_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $adres_kodu = $_POST["adres_kodu"];

    $adres_tanimda_varmi = DBD::single_query("SELECT * FROM adres_tanimlama WHERE status=1 AND adres_kodu='$adres_kodu'");
    if ($adres_tanimda_varmi > 0) {
        echo 300;
    } else {
        $adres_tanim_ekle = DBD::insert("adres_tanimlama", $_POST);
        if ($adres_tanim_ekle) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "tanimlanan_adresleri_getir_sql") {
    $tanimlanan_adresler = DBD::all_data("SELECT * FROM adres_tanimlama WHERE status=1 AND cari_key='$cari_key'");
    if ($tanimlanan_adresler > 0) {
        $gidecek_arr = [];
        foreach ($tanimlanan_adresler as $item) {
            $arr = [
                'adres_adi' => $item["adres_adi"],
                'adres_kodu' => $item["adres_kodu"],
                'aciklama' => $item["aciklama"],
                'islem' => "<button class='btn btn-sm tanimlanan_adresi_guncelle_button' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm tanimlanan_adresi_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
            ];
            array_push($gidecek_arr, $arr);
        }
        if (!empty($gidecek_arr)) {
            echo json_encode($gidecek_arr);
        } else {
            echo 2;
        }
    }
}
if ($islem == "tanimlanan_adresi_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $adresi_sil = DBD::update("adres_tanimlama", "id", $_POST["id"], $_POST);
    if ($adresi_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "adres_tanim_bilgilerini_getir_sql") {
    $id = $_GET["id"];
    $adres_bilgileri = DBD::single_query("SELECT * FROM adres_tanimlama WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    if ($adres_bilgileri > 0) {
        echo json_encode($adres_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "depo_adresi_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $adres_guncelle = DBD::update("adres_tanimlama", "id", $_POST["id"], $_POST);
    if ($adres_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "mal_cinsi_kaydet_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;

    $mal_kodu = $_POST["mal_kodu"];

    $mal_sorgu = DBD::single_query("SELECT * FROM mal_cinsleri WHERE status=1 AND mal_kodu='$mal_kodu'");
    if ($mal_sorgu > 0) {
        echo 300;
    } else {
        $mal_cinsi_ekle = DBD::insert("mal_cinsleri", $_POST);
        if ($mal_cinsi_ekle) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "tanimlanan_mal_cinslerini_getir_sql") {
    $tanimlanan_adresler = DBD::all_data("SELECT * FROM mal_cinsleri WHERE status=1 AND cari_key='$cari_key'");
    if ($tanimlanan_adresler > 0) {
        $gidecek_arr = [];
        foreach ($tanimlanan_adresler as $item) {
            $arr = [
                'mal_adi' => $item["mal_adi"],
                'mal_kodu' => $item["mal_kodu"],
                'aciklama' => $item["aciklama"],
                'islem' => "<button class='btn btn-sm mal_cinsi_guncelle_button' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm mal_cinsini_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
            ];
            array_push($gidecek_arr, $arr);
        }
        if (!empty($gidecek_arr)) {
            echo json_encode($gidecek_arr);
        } else {
            echo 2;
        }
    }
}
if ($islem == "arac_tanim_kaydet_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $ekle = DBD::insert("depo_arac_tanim", $_POST);
    if ($ekle) {
        echo 500;
    } else {
        echo 1;
    }
}
if ($islem == "depo_arac_tanimlari_getir") {
    $araclar = DBD::all_data("SELECT * FROM depo_arac_tanim WHERE status=1 AND cari_key='$cari_key'");
    if ($araclar > 0) {
        $gidecek_arr = [];
        foreach ($araclar as $item) {
            $arr = [
                'arac_plaka' => $item["plaka_no"],
                'dorse_plaka' => $item["dorse_plaka"],
                'surucu_adi' => $item["surucu_adi"],
                'surucu_tel' => $item["surucu_tel"],
                'id' => $item["id"],
                'islem' => "<button class='btn btn-sm depo_arac_tanim_guncelle_button' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm tanimlanan_araci_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>",
            ];
            array_push($gidecek_arr, $arr);
        }
        if (!empty($gidecek_arr)) {
            echo json_encode($gidecek_arr);
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "tanimlanan_araci_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $sil = DBD::update("depo_arac_tanim", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "tum_tanimli_araclari_getir_sql") {
    $araclar = DBD::all_data("
SELECT 
       dat.*,
       iem.cari_id,
       iem.epro_ref
FROM
     depo_arac_tanim as dat
INNER JOIN is_emri_main AS iem on iem.id=dat.is_emri_id
WHERE
      dat.status=1 AND dat.cari_key='$cari_key'");
    if ($araclar > 0) {
        $gidecek_arr = [];
        foreach ($araclar as $item) {
            $cari_id = $item["cari_id"];
            $cari = DB::single_query("SELECT cari_adi FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
            $arr = [
                'plaka_no' => $item["plaka_no"],
                'dorse_plaka' => $item["dorse_plaka"],
                'surucu_adi' => $item["surucu_adi"],
                'surucu_tel' => $item["surucu_tel"],
                'cari_adi' => $cari["cari_adi"],
                'cari_id' => $cari_id,
                'epro_ref' => $item["epro_ref"],
                'urun_adi' => $item["urun_adi"],
                'mal_id' => $ithalat_siparisler["mal_id"],
                'birim_id' => $ithalat_siparisler["birim_id"],
                'referans_no' => "",
                'fabrika_ref' => $ithalat_siparisler["fabrika_ref"],
                'beyanname_no' => $ithalat_siparisler["beyanname_no"],
                'arac_id' => $item["id"],
                'aciklama' => $item["aciklama"]
            ];
            array_push($gidecek_arr, $arr);
        }
        if (!empty($gidecek_arr)) {
            echo json_encode($gidecek_arr);
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "secilen_tanimli_araclari_getir_sql") {
    $sorgu = "";
    if (isset($_GET["plaka_no"])) {
        $plaka_no = $_GET["plaka_no"];
        $sorgu = " AND plaka_no='$plaka_no'";
    } else {
        $id = $_GET["id"];
        $sorgu = " AND id='$id'";
    }
    $araclar = DBD::single_query("
SELECT 
       dat.*,
       iem.cari_id,
       iem.referans_no,
       iem.beyanname_no,
       iem.epro_ref
FROM
     depo_arac_tanim as dat
INNER JOIN is_emri_main AS iem on iem.id=dat.is_emri_id
WHERE
      dat.status=1 AND dat.cari_key='$cari_key'");
    if ($araclar > 0) {
        $cari_id = $araclar["cari_id"];
        $cari = DB::single_query("SELECT cari_adi FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
        $arr = [
            'plaka_no' => $araclar["plaka_no"],
            'dorse_plaka' => $araclar["dorse_plaka"],
            'surucu_adi' => $araclar["surucu_adi"],
            'surucu_tel' => $araclar["surucu_tel"],
            'is_emir_id' => $araclar["is_emri_id"],
            'id' => $araclar["id"],
            'cari_adi' => $cari["cari_adi"],
            'cari_id' => $araclar["cari_id"],
            'epro_ref' => $araclar["epro_ref"],
            'urun_adi' => $araclar["urun_adi"],
            'mal_id' => $araclar["mal_id"],
            'birim_id' => $araclar["birim_id"],
            'referans_no' => $araclar["referans_no"],
            'beyanname_no' => $araclar["beyanname_no"],
            'aciklama' => $araclar["aciklama"]
        ];
        if (!empty($arr)) {
            echo json_encode($arr);
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "tum_forkliftleri_getir_sql") {
    $tum_forkliftler = DBD::all_data("SELECT * FROM forklift_kartlari WHERE status=1 AND cari_key='$cari_key'");
    if ($tum_forkliftler > 0) {
        $gidecek_arr = [];
        foreach ($tum_forkliftler as $item) {
            $arr = [
                'forklift_grubu' => $item["forklift_grubu"],
                'forklift_kodu' => $item["forklift_kodu"],
                'forklift_adi' => $item["forklift_adi"],
                'surucu_adi' => $item["surucu_adi"],
                'id' => $item["id"],
                'islem' => "<button class='btn btn-sm tanimli_forklifti_guncelle_main_button' style='background-color: #F6FA70' data-id='" . $item["id"] . "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm tanimlanan_forkliftleri_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
            ];
            array_push($gidecek_arr, $arr);
        }
        if (!empty($gidecek_arr)) {
            echo json_encode($gidecek_arr);
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "yeni_forklift_tanimla") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;

    $forklift_kodu = $_POST["forklift_kodu"];

    $forklift_query = DBD::single_query("SELECT * FROM forklift_kartlari WHERE status=1 AND cari_key='$cari_key' AND forklift_kodu='$forklift_kodu'");
    if ($forklift_query > 0) {
        echo 300;
    } else {
        $yeni_forklift_ekle = DBD::insert("forklift_kartlari", $_POST);
        if ($yeni_forklift_ekle) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "tanimli_forklifti_sil_button") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $forklifti_sil = DBD::update("forklift_kartlari", "id", $_POST["id"], $_POST);
    if ($forklifti_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "tum_kalmarlari_getir_sql") {
    $tum_forkliftler = DBD::all_data("SELECT * FROM kalmar_kartlari WHERE status=1 AND cari_key='$cari_key'");
    if ($tum_forkliftler > 0) {
        $gidecek_arr = [];
        foreach ($tum_forkliftler as $item) {
            $arr = [
                'forklift_grubu' => $item["kalmar_grubu"],
                'forklift_kodu' => $item["kalmar_kodu"],
                'forklift_adi' => $item["kalmar_adi"],
                'surucu_adi' => $item["surucu_adi"],
                'id' => $item["id"],
                'islem' => "<button class='btn btn-sm tanimli_kalmari_guncelle_button' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm tanimlanan_kalmarlari_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
            ];
            array_push($gidecek_arr, $arr);
        }
        if (!empty($gidecek_arr)) {
            echo json_encode($gidecek_arr);
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "yeni_kalmar_tanimla") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;

    $forklift_kodu = $_POST["kalmar_kodu"];

    $forklift_query = DBD::single_query("SELECT * FROM kalmar_kartlari WHERE status=1 AND cari_key='$cari_key' AND forklift_kodu='$forklift_kodu'");
    if ($forklift_query > 0) {
        echo 300;
    } else {
        $yeni_forklift_ekle = DBD::insert("kalmar_kartlari", $_POST);
        if ($yeni_forklift_ekle) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "ilgili_kalmari_getir_sql") {
    $id = $_GET["id"];
    $kalmar_query = DBD::single_query("SELECT * FROM kalmar_kartlari WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    if ($kalmar_query > 0) {
        echo json_encode($kalmar_query);
    } else {
        echo 2;
    }
}
if ($islem == "yeni_kalmar_guncelle") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DBD::update("kalmar_kartlari", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "tanimlanan_forklift_bilgisi_sql") {
    $id = $_GET["id"];
    $forklift_query = DBD::single_query("SELECT * FROM forklift_kartlari WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    if ($forklift_query > 0) {
        echo json_encode($forklift_query);
    } else {
        echo 2;
    }
}
if ($islem == "yeni_forklift_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DBD::update("forklift_kartlari", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "tanitilan_arac_bilgilerini_getir_sql") {
    $id = $_GET["id"];
    $depo_arac_tanimla = DBD::single_query("
SELECT
       dat.*,
       iem.epro_ref
FROM
     depo_arac_tanim as dat
INNER JOIN is_emri_main as iem on iem.id=dat.is_emri_id
WHERE
      dat.status=1 AND dat.cari_key='$cari_key' AND dat.id='$id' GROUP BY dat.id");
    if ($depo_arac_tanimla > 0) {
        echo json_encode($depo_arac_tanimla);
    } else {
        echo 2;
    }
}
if ($islem == "arac_tanim_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DBD::update("depo_arac_tanim", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "mal_cinsi_detayini_getir_sql") {
    $id = $_GET["id"];
    $mal_cinsi = DBD::single_query("SELECT * FROM mal_cinsleri WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    if ($mal_cinsi > 0) {
        echo json_encode($mal_cinsi);
    } else {
        echo 2;
    }
}
if ($islem == "mal_cinsi_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DBD::update("mal_cinsleri", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "tanimlanan_mal_cinsi_sil") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $sil = DBD::update("mal_cinsleri", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}