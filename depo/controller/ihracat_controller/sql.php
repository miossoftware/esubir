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

if ($islem == "mal_cinslerini_getir_sql") {
    $mal_cinsleri = DBD::all_data("SELECT * FROM mal_cinsleri WHERE status=1 AND cari_key='$cari_key'");
    if ($mal_cinsleri > 0) {
        echo json_encode($mal_cinsleri);
    } else {
        echo 2;
    }
}
if ($islem == "hizmetleri_getir_sql") {
    $hizmetler = DB::all_data("
SELECT
       s.*
FROM
     stok as s 
LEFT JOIN stok_ana_grup as sag on sag.id=s.stok_ana_grupid
WHERE s.status=1 AND s.cari_key='$cari_key' AND sag.ana_grup_adi='LOJİSTİK'");
    if ($hizmetler > 0) {
        echo json_encode($hizmetler);
    } else {
        echo 2;
    }
}
if ($islem == "depo_konteyner_siparis_kaydet_sql") {
    $arr = [
        'cari_id' => $_POST["cari"],
        'siparis_tarihi' => $_POST["siparis_tarihi"],
        'cutt_off_tarihi' => $_POST["cut_off_tarihi"],
        'alim_yeri' => $_POST["alim_yeri"],
        'ardiyesiz_giris_tarihi' => $_POST["ardiyesiz_giris_tarihi"],
        'aciklama' => $_POST["aciklama"],
        "acente" => $_POST["acente"],
        "acente_ref" => $_POST["acente_ref"],
        'insert_userid' => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s"),
        'cari_key' => $cari_key,
        'sube_key' => $sube_key
    ];

    $ihracat_siparis_olustur = DBD::insert("ihracat_siparis", $arr);
    if ($ihracat_siparis_olustur) {
        echo 500;
    } else {
        $son_eklenen = DBD::single_query("SELECT id FROM ihracat_siparis where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");

        foreach ($_POST["gonderilecek_arr"] as $item) {
            $item["siparis_id"] = $son_eklenen["id"];
            $item["insert_userid"] = $_SESSION["user_id"];
            $item["insert_datetime"] = date("Y-m-d H:i:s");
            $item["cari_key"] = $cari_key;
            $item["sube_key"] = $sube_key;

            $ihracat_siparis_urunleri = DBD::insert("ihracat_siparis_urunler", $item);
        }
        if ($ihracat_siparis_urunleri) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "ihracat_siparislerini_getir_sql") {
    $ek_sorgu = "";
    if (isset($_GET["cari_id"])) {
        $cari_id = $_GET["cari_id"];
        if ($cari_id == "") {

        } else {
            $ek_sorgu = " AND is_m.cari_id='$cari_id'";
        }
    }
    $tum_siparisler = DBD::all_data("
SELECT
       is_m.*,
       isu.birim_id,
       isu.epro_ref,
       COUNT(isu.id) as siparis_adet,
       GROUP_CONCAT(CONCAT(isu.konteyner_sayisi, 'X', isu.konteyner_tipi)) as konteynerler,
       SUM(isu.miktar) as toplam_miktar,
       SUM(isu.konteyner_sayisi) as konteyner_sayisi
FROM 
     ihracat_siparis as is_m
INNER JOIN ihracat_siparis_urunler AS isu on isu.siparis_id=is_m.id
WHERE
      is_m.status=1 AND isu.status=1 AND is_m.cari_key='$cari_key' $ek_sorgu
GROUP BY is_m.id");
    if ($tum_siparisler > 0) {
        $gonderilecek_arr = [];

        foreach ($tum_siparisler as $item) {
            $cari_id = $item["cari_id"];
            $birim_id = $item["birim_id"];
            $cari_adi = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
            $birim = DB::single_query("SELECT * FROM birim WHERE status=1 AND cari_key='$cari_key' AND id='$birim_id'");
            $siparis_tarihi = date("d/m/Y", strtotime($item["siparis_tarihi"]));
            $cut_of_tarihi = date("d/m/Y", strtotime($item["cutt_off_tarihi"]));
            $ardiyesiz_giris_tarihi = date("d/m/Y", strtotime($item["ardiyesiz_giris_tarihi"]));
            $toplam_miktar = number_format($item["toplam_miktar"], 2);
            $konteyner_tipleri = str_replace(',', "<br>", $item["konteynerler"]);
            $arr = [
                'cari_adi' => $cari_adi["cari_adi"],
                'cari_kodu' => $cari_adi["cari_kodu"],
                'siparis_tarihi' => $siparis_tarihi,
                'alim_yeri' => $item["alim_yeri"],
                'cut_of_tarihi' => $cut_of_tarihi,
                'ardiyesiz_giris_tarihi' => $ardiyesiz_giris_tarihi,
                'toplam_yukleme_miktari' => $toplam_miktar . " " . $birim["birim_adi"],
                'toplam_siparis' => $item["siparis_adet"],
                'acente' => $item["acente"],
                'acente_ref' => $item["acente_ref"],
                'toplam_konteyner_sayisi' => $item["konteyner_sayisi"],
                'epro_ref' => $item["epro_ref"],
                'konteyner_tipleri' => $konteyner_tipleri,
                'aciklama' => $item["aciklama"],
                'islem' => "<button class='btn btn-sm depo_ihracat_siparis_guncelle' style='background-color: #F6FA70' data-id='" . $item["id"] . "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm depo_ihracat_siparis_islemleri_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>",
                'id' => $item["id"],
            ];
            array_push($gonderilecek_arr, $arr);
        }
        if (!empty($gonderilecek_arr)) {
            echo json_encode($gonderilecek_arr);
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "ihracat_siparislerini_getir_sql2") {
    $ek_sorgu = "";
    if (isset($_GET["cari_id"])) {
        $cari_id = $_GET["cari_id"];
        if ($cari_id == "") {

        } else {
            $ek_sorgu = " AND is_m.cari_id='$cari_id'";
        }
    }
    $tum_siparisler = DBD::all_data("
SELECT
       is_m.*,
       isu.birim_id,
       isu.epro_ref,
       COUNT(isu.id) as siparis_adet,
       GROUP_CONCAT(CONCAT(isu.konteyner_sayisi, 'X', isu.konteyner_tipi)) as konteynerler,
       SUM(isu.miktar) as toplam_miktar,
       SUM(isu.konteyner_sayisi) as konteyner_sayisi
FROM 
     ihracat_siparis as is_m
INNER JOIN ihracat_siparis_urunler AS isu on isu.siparis_id=is_m.id
WHERE
      (is_m.status=1 OR is_m.status=2) AND isu.status=1 AND is_m.cari_key='$cari_key' $ek_sorgu AND is_m.konteyner_tanimlandi=0
GROUP BY is_m.id");
    if ($tum_siparisler > 0) {
        $gonderilecek_arr = [];

        foreach ($tum_siparisler as $item) {
            $siparis_id = $item["id"];
            $konteyner_cikis = DBD::single_query("
SELECT
       COUNT(kg.id) as konteyner_sayisi
FROM
     konteyner_giris as kg
INNER JOIN konteyner_cikis as kc on kc.konteyner_id=kg.id
WHERE kc.status=1 AND kc.cari_key='$cari_key' AND kg.siparis_id='$siparis_id' AND kg.bos_dolu='Boş'");
            $cari_id = $item["cari_id"];
            $birim_id = $item["birim_id"];
            $cari_adi = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
            $birim = DB::single_query("SELECT * FROM birim WHERE status=1 AND cari_key='$cari_key' AND id='$birim_id'");
            if ($konteyner_cikis["konteyner_sayisi"] == $item["konteyner_sayisi"]){

            }else{
                $siparis_tarihi = date("d/m/Y", strtotime($item["siparis_tarihi"]));
                $cut_of_tarihi = date("d/m/Y", strtotime($item["cutt_off_tarihi"]));
                $ardiyesiz_giris_tarihi = date("d/m/Y", strtotime($item["ardiyesiz_giris_tarihi"]));
                $toplam_miktar = number_format($item["toplam_miktar"], 2);
                $konteyner_tipleri = str_replace(',', "<br>", $item["konteynerler"]);
                $arr = [
                    'cari_adi' => $cari_adi["cari_adi"],
                    'cari_kodu' => $cari_adi["cari_kodu"],
                    'siparis_tarihi' => $siparis_tarihi,
                    'alim_yeri' => $item["alim_yeri"],
                    'cut_of_tarihi' => $cut_of_tarihi,
                    'ardiyesiz_giris_tarihi' => $ardiyesiz_giris_tarihi,
                    'toplam_yukleme_miktari' => $toplam_miktar . " " . $birim["birim_adi"],
                    'toplam_siparis' => $item["siparis_adet"],
                    'acente' => $item["acente"],
                    'acente_ref' => $item["acente_ref"],
                    'toplam_konteyner_sayisi' => $item["konteyner_sayisi"],
                    'epro_ref' => $item["epro_ref"],
                    'konteyner_tipleri' => $konteyner_tipleri,
                    'aciklama' => $item["aciklama"],
                    'islem' => "<button class='btn btn-sm depo_ihracat_siparis_guncelle' style='background-color: #F6FA70' data-id='" . $item["id"] . "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm depo_ihracat_siparis_islemleri_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>",
                    'id' => $item["id"],
                ];
                array_push($gonderilecek_arr, $arr);
            }
        }
        if (!empty($gonderilecek_arr)) {
            echo json_encode($gonderilecek_arr);
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "depo_ihracat_siparisi_sil_sql") {
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["status"] = 0;
    $sil = DBD::update("ihracat_siparis", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "son_epro_referans_sql") {
    $ay_bas = date("Y-m-01");
    $ay_sonu = date("Y-m-t");
    $siparisler = DBD::single_query("
SELECT
       isu.*
FROM
     ihracat_siparis_urunler as isu
INNER JOIN ihracat_siparis as is_s on is_s.id=isu.siparis_id
WHERE isu.status=1 AND isu.cari_key='$cari_key' AND is_s.siparis_tarihi BETWEEN '$ay_bas 00:00:00' AND '$ay_sonu 23:59:59' ORDER BY isu.id DESC LIMIT 1");
    if ($siparisler > 0) {
        echo json_encode($siparisler);
    } else {
        echo 2;
    }
}
if ($islem == "guncellenecek_siparis_ana_bilgi") {
    $id = $_GET["id"];

    $guncellenecek_ana = DBD::single_query("
SELECT
       is_s.*,
       SUM(isu.miktar) as toplam_miktar,
       SUM(isu.konteyner_sayisi) as konteyner_sayisi,
       COUNT(isu.id) as siparis_adet,
       isu.birim_id,
       isu.fabrika_ref,
       isu.epro_ref,
       isu.mal_id,
       isu.urun_adi,
       isu.birim_id
FROM
     ihracat_siparis as is_s
INNER JOIN ihracat_siparis_urunler as isu on isu.siparis_id=is_s.id
WHERE (is_s.status=2 OR isu.status=2) AND is_s.id='$id' AND is_s.cari_key='$cari_key'");
    if ($guncellenecek_ana > 0) {
        $cari_id = $guncellenecek_ana["cari_id"];
        $gidecek_arr = [];
        $cari_bilgileri = DB::single_query("
SELECT
       c.*,
       cab.adres
FROM
     cari as c 
LEFT JOIN cari_adres_bilgileri AS cab on cab.cari_id=c.id
WHERE c.status=1 AND c.id='$cari_id'");

        $birim_id = $guncellenecek_ana["birim_id"];

        $birim = DB::single_query("SELECT * FROM birim WHERE status=1 AND cari_key='$cari_key' AND id='$birim_id'");
        $miktar = number_format($guncellenecek_ana["toplam_miktar"], 2);
        $gidecek_arr = [
            'cari_adi' => $cari_bilgileri["cari_adi"],
            'cari_kodu' => $cari_bilgileri["cari_kodu"],
            'toplam_miktar' => $miktar . " " . $birim["birim_adi"],
            'konteyner_sayisi' => $guncellenecek_ana["konteyner_sayisi"],
            'siparis_adet' => $guncellenecek_ana["siparis_adet"],
            'vergi_dairesi' => $cari_bilgileri["vergi_dairesi"],
            'vergi_no' => $cari_bilgileri["vergi_no"],
            'adres' => $cari_bilgileri["adres"],
            'acente_ref' => $guncellenecek_ana["acente_ref"],
            'urun_adi' => $guncellenecek_ana["urun_adi"],
            'birim_id' => $guncellenecek_ana["birim_id"],
            'mal_id' => $guncellenecek_ana["mal_id"],
            'acente' => $guncellenecek_ana["acente"],
            'epro_ref' => $guncellenecek_ana["epro_ref"],
            'alim_yeri' => $guncellenecek_ana["alim_yeri"],
            'siparis_tarihi' => $guncellenecek_ana["siparis_tarihi"],
            'cutt_off_tarihi' => $guncellenecek_ana["cutt_off_tarihi"],
            'fabrika_ref' => $guncellenecek_ana["fabrika_ref"],
            'ardiyesiz_giris_tarihi' => $guncellenecek_ana["ardiyesiz_giris_tarihi"],
            'aciklama' => $guncellenecek_ana["aciklama"],
            'cari_id' => $guncellenecek_ana["cari_id"],
            'id' => $guncellenecek_ana["id"]
        ];
        echo json_encode($gidecek_arr);

    } else {
        echo 2;
    }
}
if ($islem == "guncellenecek_siparis_ana_bilgi1") {
    $id = $_GET["id"];
    
    $guncellenecek_ana = DBD::single_query("
SELECT
       is_s.*,
       SUM(isu.miktar) as toplam_miktar,
       SUM(isu.konteyner_sayisi) as konteyner_sayisi,
       COUNT(isu.id) as siparis_adet,
       isu.birim_id,
       isu.fabrika_ref,
       isu.epro_ref,
       isu.mal_id,
       isu.konteyner_tipi,
       isu.urun_adi,
       isu.birim_id
FROM
     ihracat_siparis as is_s
INNER JOIN ihracat_siparis_urunler as isu on isu.siparis_id=is_s.id
WHERE (is_s.status=1 OR is_s.status=2) AND isu.status=1 AND is_s.id='$id' AND is_s.cari_key='$cari_key'");
    if ($guncellenecek_ana > 0) {
        $cari_id = $guncellenecek_ana["cari_id"];
        $gidecek_arr = [];
        $cari_bilgileri = DB::single_query("
SELECT
       c.*,
       cab.adres
FROM
     cari as c 
LEFT JOIN cari_adres_bilgileri AS cab on cab.cari_id=c.id
WHERE c.status=1 AND c.id='$cari_id'");

        $birim_id = $guncellenecek_ana["birim_id"];

        $birim = DB::single_query("SELECT * FROM birim WHERE status=1 AND cari_key='$cari_key' AND id='$birim_id'");
        $miktar = number_format($guncellenecek_ana["toplam_miktar"], 2);
        $gidecek_arr = [
            'cari_adi' => $cari_bilgileri["cari_adi"],
            'cari_kodu' => $cari_bilgileri["cari_kodu"],
            'toplam_miktar' => $miktar . " " . $birim["birim_adi"],
            'konteyner_sayisi' => $guncellenecek_ana["konteyner_sayisi"],
            'siparis_adet' => $guncellenecek_ana["siparis_adet"],
            'vergi_dairesi' => $cari_bilgileri["vergi_dairesi"],
            'vergi_no' => $cari_bilgileri["vergi_no"],
            'adres' => $cari_bilgileri["adres"],
            'acente_ref' => $guncellenecek_ana["acente_ref"],
            'urun_adi' => $guncellenecek_ana["urun_adi"],
            'birim_id' => $guncellenecek_ana["birim_id"],
            'mal_id' => $guncellenecek_ana["mal_id"],
            'acente' => $guncellenecek_ana["acente"],
            'epro_ref' => $guncellenecek_ana["epro_ref"],
            'alim_yeri' => $guncellenecek_ana["alim_yeri"],
            'siparis_tarihi' => $guncellenecek_ana["siparis_tarihi"],
            'konteyner_tipi' => $guncellenecek_ana["konteyner_tipi"],
            'cutt_off_tarihi' => $guncellenecek_ana["cutt_off_tarihi"],
            'fabrika_ref' => $guncellenecek_ana["fabrika_ref"],
            'ardiyesiz_giris_tarihi' => $guncellenecek_ana["ardiyesiz_giris_tarihi"],
            'aciklama' => $guncellenecek_ana["aciklama"],
            'cari_id' => $guncellenecek_ana["cari_id"],
            'id' => $guncellenecek_ana["id"]
        ];
        echo json_encode($gidecek_arr);

    } else {
        echo 2;
    }
}
if ($islem == "siparis_ihracat_urun_bilgisi_sql") {
    $siparis_id = $_GET["id"];

    $urun_bilgi = DBD::all_data("
SELECT * FROM ihracat_siparis_urunler WHERE status=1 AND cari_key='$cari_key' AND siparis_id='$siparis_id'");
    if ($urun_bilgi > 0) {
        $response = [];
        foreach ($urun_bilgi as $urun) {
            $stok_id = $urun["hizmet_id"];
            $birim_id = $urun["birim_id"];
            $stok = DB::single_query("
SELECT
       * FROM stok WHERE status=1 AND cari_key='$cari_key' AND id='$stok_id'");
            $birim = DB::single_query("SELECT * FROM birim WHERE status=1 AND id='$birim_id'");
            $arr = [
                'stok_adi' => $stok["stok_adi"],
                'fabrika_ref' => $urun["fabrika_ref"],
                'epro_ref' => $urun["epro_ref"],
                'urun_adi' => $urun["urun_adi"],
                'mal_kodu' => $urun["mal_kodu"],
                'konteyner_sayisi' => $urun["konteyner_sayisi"],
                'konteyner_tipi' => $urun["konteyner_tipi"],
                'miktar' => $urun["miktar"],
                'birim' => $birim["birim_adi"],
                'islem' => "<button class='btn btn-danger btn-sm listedeki_urunu_sil_button' data-id='" . $urun["id"] . "'><i class='fa fa-trash'></i></button>"
            ];
            array_push($response, $arr);
        }
        if (!empty($response)) {
            echo json_encode($response);
        } else {
            echo 2;
        }
    }
}
if ($islem == "siparise_urun_ekle_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $ekle = DBD::insert("ihracat_siparis_urunler", $_POST);
    if ($ekle) {
        echo 2;
    } else {
        $son_eklenen = DBD::single_query("SELECT id FROM ihracat_siparis_urunler where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        echo 'id:' . $son_eklenen["id"];
    }
}
if ($islem == "ihracat_siparis_urunu_sil_sql") {
    $_POST["status"] = 0;
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_detail"] = "Kullanıcı Güncelleme Sayfasından Silmiştir";
    $sil = DBD::update("ihracat_siparis_urunler", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "depo_konteyner_siparis_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DBD::update("ihracat_siparis", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "tanitilacak_konteynerler_sql") {
    $siparis_id = $_GET["siparis_id"];
    $referans_no = $_GET["referans_no"];
    $beyanname_no = $_GET["beyanname_no"];
    $tipi = "";
    $epro_ref = $_GET["epro_ref"];
    $desen = '/^İTH/';
    if (preg_match($desen, $epro_ref)) {
        $tipi = "İTHALAT";
    } else {
        $tipi = "İHRACAT";
    }


    if ($tipi == "İTHALAT") {
        $ek = "";
        if ($beyanname_no != "") {
            $ek = " AND beyanname_no='$beyanname_no'";
        }
        $ek2 = "";
        if (isset($_GET["siparis_id"])) {
            $ek2 = " AND is_s.id='$siparis_id'";
        }

        $tum_veriler = DBD::all_data("
SELECT 
       isu.*
FROM
     ithalat_siparis as is_s
INNER JOIN ithalat_siparis_urunler as isu on isu.siparis_id=is_s.id
WHERE (is_s.status=1 OR is_s.status=2) AND isu.status=1 AND is_s.cari_key='$cari_key' $ek2 $ek AND is_s.konteyner_tanimlandi=0");
        if ($tum_veriler > 0) {
            echo json_encode($tum_veriler);
        } else {
            echo 2;
        }
    } else {
        $ek2 = "";
        if (isset($_GET["siparis_id"])) {
            $ek2 = " AND is_s.id='$siparis_id'";
        }
        $ek = "";
        if ($referans_no != "") {
            $ek = " AND acente_ref='$referans_no'";
        }
        $tum_veriler = DBD::all_data("
SELECT 
       isu.*
FROM
     ihracat_siparis as is_s
INNER JOIN ihracat_siparis_urunler as isu on isu.siparis_id=is_s.id
WHERE (is_s.status=1 OR is_s.status=2) AND isu.status=1 AND is_s.cari_key='$cari_key' $ek2 $ek");
        if ($tum_veriler > 0) {
            echo json_encode($tum_veriler);
        } else {
            echo 2;
        }
    }
}
if ($islem == "kayitli_is_emri_ekle_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $gelen_arr = $_POST["gidecek_arr"];
    unset($_POST["gidecek_arr"]);
    $is_emri_adi = $_POST["is_emri_adi"];

    $kayitli_mi = DBD::single_query("SELECT * FROM kayitli_is_emirleri_ana WHERE status=1 AND cari_key='$cari_key' AND is_emri_adi='$is_emri_adi'");

    if ($kayitli_mi > 0) {
        echo 300;
    } else {
        $ekle = DBD::insert("kayitli_is_emirleri_ana", $_POST);
        if ($ekle) {
            echo 500;
        } else {
            $son_eklenen = DBD::single_query("SELECT id FROM kayitli_is_emirleri_ana where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
            foreach ($gelen_arr as $item) {
                $item["insert_userid"] = $_SESSION["user_id"];
                $item["insert_datetime"] = date("Y-m-d H:i:s");
                $item["cari_key"] = $cari_key;
                $item["sube_key"] = $sube_key;
                $item["is_emri_anaid"] = $son_eklenen["id"];
                $urun_ekle = DBD::insert("kayitli_is_emirleri", $item);
            }
            if ($urun_ekle) {
                echo 500;
            } else {
                echo 1;
            }
        }
    }
}
if ($islem == "kayitli_is_emirleri_sql") {
    $is_emirleri = DBD::all_data("SELECT * FROM kayitli_is_emirleri_ana WHERE status=1 AND cari_key='$cari_key'");
    if ($is_emirleri > 0) {
        echo json_encode($is_emirleri);
    } else {
        echo 2;
    }
}
if ($islem == "secilen_is_emri_getir_sql") {
    $ana_id = $_GET["id"];
    $urunleri = DBD::all_data("SELECT * FROM kayitli_is_emirleri WHERE status=1 AND cari_key='$cari_key' AND is_emri_anaid='$ana_id'");
    if ($urunleri > 0) {
        $gidecek_arr = [];
        foreach ($urunleri as $item) {
            $stok_id = $item["stok_id"];
            $birim_id = $item["birim_id"];
            $stok_adi = DB::single_query("SELECT stok_adi FROM stok WHERE status=1 AND cari_key='$cari_key' AND id='$stok_id'");
            $birimler = DB::single_query("SELECT birim_adi FROM birim WHERE status=1 AND cari_key='$cari_key' AND id='$birim_id'");

            $arr = [
                'stok_adi' => $stok_adi["stok_adi"],
                'birim_adi' => $birimler["birim_adi"],
                'stok_id' => $item["stok_id"],
                'birim_id' => $item["birim_id"],
                'sefer_sayisi' => "<input type='text' value='0' class='form-control form-control-sm col-9' />",
                'islem' => "<button class='btn btn-danger btn-sm is_emri_hizmet_sil_button'><i class='fa fa-trash'></i></button>"
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
if ($islem == "is_emri_olustur_ve_kaydet_sql") {
    $siparis_id = "";
    $siparisin_geldigi_yer = "";
    if (!isset($_POST["siparis_id"])) {
        $arr = [
            'cari_id' => $_POST["cari_id"],
            'siparis_tarihi' => $_POST["siparis_tarihi"],
            'cutt_off_tarihi' => $_POST["cut_off_tarihi"],
            'alim_yeri' => $_POST["alim_yeri"],
            'ardiyesiz_giris_tarihi' => $_POST["ardiyesiz_giris_tarihi"],
            'aciklama' => $_POST["aciklama"],
            "acente" => $_POST["acenta"],
            "acente_ref" => $_POST["acenta_ref"],
            'insert_userid' => $_SESSION["user_id"],
            'insert_datetime' => date("Y-m-d H:i:s"),
            'cari_key' => $cari_key,
            'sube_key' => $sube_key,
            'status' => 2
        ];

        $ihracat_siparis_olustur = DBD::insert("ihracat_siparis", $arr);
        if ($ihracat_siparis_olustur) {
            echo 500;
        } else {
            $son_eklenen = DBD::single_query("SELECT id FROM ihracat_siparis where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
            $siparis_id = $son_eklenen["id"];
            foreach ($_POST["gonderilecek_siparis_arr"] as $item) {
                $item["siparis_id"] = $son_eklenen["id"];
                $item["insert_userid"] = $_SESSION["user_id"];
                $item["insert_datetime"] = date("Y-m-d H:i:s");
                $item["cari_key"] = $cari_key;
                $item["sube_key"] = $sube_key;

                $ihracat_siparis_urunleri = DBD::insert("ihracat_siparis_urunler", $item);
            }
            if ($ihracat_siparis_urunleri) {
                echo 500;
                die();
            }
        }
        $siparisin_geldigi_yer = 1;
    } else {
        $siparis_id = $_POST["siparis_id"];
        $arr = [
            'status' => 2
        ];
        $siparisi_dusur = DBD::update("ihracat_siparis", "id", $siparis_id, $arr);
        $siparisin_geldigi_yer = 2;
    }

    $is_emri_main_arr = [
        "siparis_id" => $siparis_id,
        "siparisin_geldigi_yer" => $siparisin_geldigi_yer,
        'forklift_tipi' => $_POST["forklift_tipi"],
        'depo_bedeli' => $_POST["depo_bedeli"],
        'tasima_bedeli' => $_POST["tasima_bedeli"],
        "aciklama" => $_POST["ana_aciklama"],
        "tarih" => date("Y-m-d H:i:s"),
        'insert_userid' => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s"),
        'cari_key' => $cari_key,
        'sube_key' => $sube_key
    ];

    $main_is_emri_olustur = DBD::insert("is_emri_main", $is_emri_main_arr);
    if ($main_is_emri_olustur) {
        echo 500;
    } else {
        $son_eklenen = DBD::single_query("SELECT id FROM is_emri_main where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        $is_emri_id = $son_eklenen["id"];
        foreach ($_POST["gonderilecek_islem_arr"] as $item2) {
            $urun_arr = [
                "hizmet_id" => $item2["stok_id"],
                "birim_id" => $item2["birim_id"],
                "sefer_sayisi" => $item2["sefer_sayisi"],
                "hizmet_turu" => $item2["hizmet_turu"],
                "alis_fiyat" => $item2["alis_fiyat"],
                "satis_fiyat" => $item2["satis_fiyat"],
                "is_emri_id" => $is_emri_id,
                'insert_userid' => $_SESSION["user_id"],
                'insert_datetime' => date("Y-m-d H:i:s"),
                'cari_key' => $cari_key,
                'sube_key' => $sube_key
            ];
            $is_emri_urunu_olustur = DBD::insert("is_emri_urunler", $urun_arr);
        }
        if ($is_emri_urunu_olustur) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "tum_is_emirlerini_getir_sql") {
    $tum_is_emirlerini_getir = DBD::all_data("
SELECT
       iem.tarih,
       is_s.siparis_tarihi,
       COUNT(is_s.id) as siparis_sayisi,
       isu.epro_ref,
       SUM(isu.konteyner_sayisi) as sefer_sayisi,
       is_s.acente_ref,
       is_s.alim_yeri,
       is_s.cutt_off_tarihi,
       is_s.ardiyesiz_giris_tarihi,
       is_s.aciklama as sip_aciklama,
       iem.aciklama,
       is_s.cari_id,
       iem.id,
       is_s.id as siparis_id
FROM
     is_emri_main AS iem 
INNER JOIN ihracat_siparis as is_s on is_s.id=iem.siparis_id
INNER JOIN ihracat_siparis_urunler as isu on isu.siparis_id=is_s.id
WHERE iem.status=1 AND iem.cari_key='$cari_key' AND is_s.status=2 AND isu.status=1 GROUP BY iem.id
");
    if ($tum_is_emirlerini_getir > 0) {
        $response = [];
        foreach ($tum_is_emirlerini_getir as $item) {
            $cari_id = $item["cari_id"];
            $siparis_id = $item["siparis_id"];
            $cari = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
            $konteyner_cikis = DBD::single_query("
SELECT
       COUNT(kg.id) as konteyner_sayisi
FROM
     konteyner_giris as kg
INNER JOIN konteyner_cikis as kc on kc.konteyner_id=kg.id
WHERE kc.status=1 AND kc.cari_key='$cari_key' AND kg.siparis_id='$siparis_id' AND kg.bos_dolu='Boş'");
            $siparis_tarihi = date("d/m/Y", strtotime($item["siparis_tarihi"]));
            $cutt_off_tarihi = date("d/m/Y", strtotime($item["cutt_off_tarihi"]));
            $ardiyesiz_giris_tarihi = date("d/m/Y", strtotime($item["ardiyesiz_giris_tarihi"]));
            if ($konteyner_cikis > 0) {
                if ($konteyner_cikis["konteyner_sayisi"] >= $item["sefer_sayisi"]) {
                    $res_arr = [
                        'siparis_tarihi' => $siparis_tarihi,
                        'cari_adi' => $cari["cari_adi"],
                        'siparis_sayisi' => $item["siparis_sayisi"],
                        'epro_referans' => $item["epro_ref"],
                        'acenta_referans' => $item["acente_ref"],
                        'alim_yeri' => $item["alim_yeri"],
                        'cut_off_tarihi' => $cutt_off_tarihi,
                        'ardiyesiz_giris' => $ardiyesiz_giris_tarihi,
                        'konteyner_sayisi' => $item["sefer_sayisi"],
                        'tamamlanan_konteynerler' => $item["konteyner_sayisi"],
                        'siparis_aciklama' => $item["sip_aciklama"],
                        'aciklama' => $item["aciklama"],
                        'islem' => "<button class='btn btn-primary btn-sm depo_is_emri_guncelleme_button' data-id='" . $item["id"] . "'><i class='fa fa-eye'></i></button> <button class='btn btn-danger btn-sm is_emri_sil_main_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
                    ];
                    array_push($response, $res_arr);
                }else{
                    $res_arr = [
                        'siparis_tarihi' => $siparis_tarihi,
                        'cari_adi' => $cari["cari_adi"],
                        'siparis_sayisi' => $item["siparis_sayisi"],
                        'epro_referans' => $item["epro_ref"],
                        'acenta_referans' => $item["acente_ref"],
                        'alim_yeri' => $item["alim_yeri"],
                        'cut_off_tarihi' => $cutt_off_tarihi,
                        'ardiyesiz_giris' => $ardiyesiz_giris_tarihi,
                        'konteyner_sayisi' => $item["sefer_sayisi"],
                        'tamamlanan_konteynerler' => $konteyner_cikis["konteyner_sayisi"],
                        'siparis_aciklama' => $item["sip_aciklama"],
                        'aciklama' => $item["aciklama"],
                        'islem' => "<button class='btn btn-primary btn-sm depo_is_emri_guncelleme_button' data-id='" . $item["id"] . "'><i class='fa fa-eye'></i></button> <button class='btn btn-danger btn-sm is_emri_sil_main_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
                    ];
                    array_push($response, $res_arr);
                }
            }else{
                $res_arr = [
                    'siparis_tarihi' => $siparis_tarihi,
                    'cari_adi' => $cari["cari_adi"],
                    'siparis_sayisi' => $item["siparis_sayisi"],
                    'epro_referans' => $item["epro_ref"],
                    'acenta_referans' => $item["acente_ref"],
                    'alim_yeri' => $item["alim_yeri"],
                    'cut_off_tarihi' => $cutt_off_tarihi,
                    'ardiyesiz_giris' => $ardiyesiz_giris_tarihi,
                    'konteyner_sayisi' => $item["sefer_sayisi"],
                    'tamamlanan_konteynerler' => 0,
                    'siparis_aciklama' => $item["sip_aciklama"],
                    'aciklama' => $item["aciklama"],
                    'islem' => "<button class='btn btn-sm depo_is_emri_guncelleme_button' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm is_emri_sil_main_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
                ];
                array_push($response, $res_arr);
            }
        }
        if (!empty($response)) {
            echo json_encode($response);
        } else {
            echo 2;
        }
    }
}
if ($islem == "is_emrini_sil_sql") {
    $id = $_POST["id"];
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $is_emri_bilgileri = DBD::single_query("SELECT * FROM is_emri_main WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    $siparis_id = $is_emri_bilgileri["siparis_id"];
    if ($is_emri_bilgileri["siparisin_geldigi_yer"] == 2) {
        $arr = [
            'status' => 1
        ];
        $siparisi_guncelle = DBD::update("ihracat_siparis", "id", $siparis_id, $arr);
    } else {
        $arr = [
            'status' => 3
        ];
        $siparisi_guncelle = DBD::update("ihracat_siparis", "id", $siparis_id, $arr);
    }
    $is_emri_sil = DBD::update("is_emri_main", "id", $id, $_POST);
    if ($is_emri_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "is_emri_ana_bilgileri_getir_sql") {
    $id = $_GET["id"];

    $is_emri_main_bilgileri = DBD::single_query("SELECT * FROM is_emri_main WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    $siparis_id = $is_emri_main_bilgileri["siparis_id"];

    $guncellenecek_ana = DBD::single_query("
SELECT
       is_s.*,
       SUM(isu.miktar) as toplam_miktar,
       SUM(isu.konteyner_sayisi) as konteyner_sayisi,
       COUNT(isu.id) as siparis_adet,
       isu.epro_ref,
       isu.birim_id
FROM
     ihracat_siparis as is_s
INNER JOIN ihracat_siparis_urunler as isu on isu.siparis_id=is_s.id
WHERE is_s.status!=0 AND isu.status!=0 AND is_s.id='$siparis_id' AND is_s.cari_key='$cari_key'");
    if ($guncellenecek_ana > 0) {
        $cari_id = $guncellenecek_ana["cari_id"];
        $gidecek_arr = [];
        $cari_bilgileri = DB::single_query("
SELECT
       c.*,
       cab.adres
FROM
     cari as c 
LEFT JOIN cari_adres_bilgileri AS cab on cab.cari_id=c.id
WHERE c.status=1 AND c.id='$cari_id'");

        $birim_id = $guncellenecek_ana["birim_id"];

        $birim = DB::single_query("SELECT * FROM birim WHERE status=1 AND cari_key='$cari_key' AND id='$birim_id'");
        $miktar = number_format($guncellenecek_ana["toplam_miktar"], 2);
        $gidecek_arr = [
            'cari_adi' => $cari_bilgileri["cari_adi"],
            'cari_kodu' => $cari_bilgileri["cari_kodu"],
            'toplam_miktar' => $miktar . " " . $birim["birim_adi"],
            'konteyner_sayisi' => $guncellenecek_ana["konteyner_sayisi"],
            'siparis_adet' => $guncellenecek_ana["siparis_adet"],
            'epro_ref' => $guncellenecek_ana["epro_ref"],
            'vergi_dairesi' => $cari_bilgileri["vergi_dairesi"],
            'vergi_no' => $cari_bilgileri["vergi_no"],
            'adres' => $cari_bilgileri["adres"],
            'acente_ref' => $guncellenecek_ana["acente_ref"],
            'acente' => $guncellenecek_ana["acente"],
            'alim_yeri' => $guncellenecek_ana["alim_yeri"],
            'siparis_tarihi' => $guncellenecek_ana["siparis_tarihi"],
            'cutt_off_tarihi' => $guncellenecek_ana["cutt_off_tarihi"],
            'ardiyesiz_giris_tarihi' => $guncellenecek_ana["ardiyesiz_giris_tarihi"],
            'aciklama' => $guncellenecek_ana["aciklama"],
            'cari_id' => $guncellenecek_ana["cari_id"],
            'depo_bedeli' => $is_emri_main_bilgileri["depo_bedeli"],
            'tasima_bedeli' => $is_emri_main_bilgileri["tasima_bedeli"],
            'forklift_tipi' => $is_emri_main_bilgileri["forklift_tipi"],
            'siparisin_geldigi_yer' => $is_emri_main_bilgileri["siparisin_geldigi_yer"],
            'siparis_id' => $siparis_id,
            'ana_aciklama' => $is_emri_main_bilgileri["aciklama"]
        ];
        if ($gidecek_arr > 0) {
            echo json_encode($gidecek_arr);
        } else {
            echo 2;
        }
    }
}
if ($islem == "siparisin_urunlerini_getir_sql") {
    $siparis_id = $_GET["siparis_id"];
    $urun_bilgi = DBD::all_data("
SELECT * FROM ihracat_siparis_urunler WHERE status=1 AND cari_key='$cari_key' AND siparis_id='$siparis_id'");
    if ($urun_bilgi > 0) {
        $response = [];
        foreach ($urun_bilgi as $urun) {
            $stok_id = $urun["hizmet_id"];
            $birim_id = $urun["birim_id"];
            $stok = DB::single_query("
SELECT
       * FROM stok WHERE status=1 AND cari_key='$cari_key' AND id='$stok_id'");
            $birim = DB::single_query("SELECT * FROM birim WHERE status=1 AND id='$birim_id'");
            $arr = [
                'stok_adi' => $stok["stok_adi"],
                'fabrika_ref' => $urun["fabrika_ref"],
                'epro_ref' => $urun["epro_ref"],
                'urun_adi' => $urun["urun_adi"],
                'mal_kodu' => $urun["mal_kodu"],
                'konteyner_sayisi' => $urun["konteyner_sayisi"],
                'konteyner_tipi' => $urun["konteyner_tipi"],
                'miktar' => $urun["miktar"],
                'birim' => $birim["birim_adi"],
                'islem' => "<button class='btn btn-danger btn-sm listedeki_urunu_sil_button' data-id='" . $urun["id"] . "'><i class='fa fa-trash'></i></button>"
            ];
            array_push($response, $arr);
        }
        if (!empty($response)) {
            echo json_encode($response);
        } else {
            echo 2;
        }
    }
}
if ($islem == "is_emri_urunlerini_getir_sql") {
    $is_emri_id = $_GET["id"];

    $is_emri_urunlerini_getir_sql = DBD::all_data("SELECT * FROM is_emri_urunler WHERE status=1 AND cari_key='$cari_key' AND is_emri_id='$is_emri_id'");
    if ($is_emri_urunlerini_getir_sql > 0) {
        $gidecek_arr = [];
        foreach ($is_emri_urunlerini_getir_sql as $item) {
            $stok_id = $item["hizmet_id"];
            $birim_id = $item["birim_id"];

            $stok = DB::single_query("SELECT * FROM stok WHERE status=1 AND cari_key='$cari_key' AND id='$stok_id'");
            $birim = DB::single_query("SELECT * FROM birim WHERE status=1 AND cari_key='$cari_key' AND id='$birim_id'");

            $arr = [
                'stok_adi' => $stok["stok_adi"],
                'birim_adi' => $birim["birim_adi"],
                'sefer_sayisi' => "<input type='text' class='form-control form-control-sm col-9 sefer_sayisini_degistir_input' data-id='" . $item["id"] . "' value='" . $item["sefer_sayisi"] . "' />",
                'islem' => "<button class='btn btn-danger btn-sm is_emri_kalem_urununu_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "sefer_sayisi_degisikligi_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DBD::update("is_emri_urunler", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "is_emri_olustur_ve_guncelle_sql") {
    $siparis_id = "";
    $siparisin_geldigi_yer = "";
    if ($_POST["siparis_id"] == "") {
        $arr = [
            'cari_id' => $_POST["cari_id"],
            'siparis_tarihi' => $_POST["siparis_tarihi"],
            'cutt_off_tarihi' => $_POST["cut_off_tarihi"],
            'alim_yeri' => $_POST["alim_yeri"],
            'ardiyesiz_giris_tarihi' => $_POST["ardiyesiz_giris_tarihi"],
            'aciklama' => $_POST["aciklama"],
            "acente" => $_POST["acenta"],
            "acente_ref" => $_POST["acenta_ref"],
            'insert_userid' => $_SESSION["user_id"],
            'insert_datetime' => date("Y-m-d H:i:s"),
            'cari_key' => $cari_key,
            'sube_key' => $sube_key,
            'status' => 2
        ];

        $ihracat_siparis_olustur = DBD::update("ihracat_siparis", $arr);
        if ($ihracat_siparis_olustur) {
            echo 500;
        } else {
            $son_eklenen = DBD::single_query("SELECT id FROM ihracat_siparis where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
            $siparis_id = $son_eklenen["id"];
            foreach ($_POST["gonderilecek_siparis_arr"] as $item) {
                $item["siparis_id"] = $son_eklenen["id"];
                $item["insert_userid"] = $_SESSION["user_id"];
                $item["insert_datetime"] = date("Y-m-d H:i:s");
                $item["cari_key"] = $cari_key;
                $item["sube_key"] = $sube_key;

                $ihracat_siparis_urunleri = DBD::insert("ihracat_siparis_urunler", $item);
            }
            if ($ihracat_siparis_urunleri) {
                echo 500;
            } else {
            }
        }
        $siparisin_geldigi_yer = 1;
    } else {
        $siparis_id = $_POST["siparis_id"];
        $arr = [
            'cari_id' => $_POST["cari_id"],
            'siparis_tarihi' => $_POST["siparis_tarihi"],
            'cutt_off_tarihi' => $_POST["cut_off_tarihi"],
            'alim_yeri' => $_POST["alim_yeri"],
            'ardiyesiz_giris_tarihi' => $_POST["ardiyesiz_giris_tarihi"],
            'aciklama' => $_POST["aciklama"],
            'depo_bedeli' => $_POST["depo_bedeli"],
            'tasima_bedeli' => $_POST["tasima_bedeli"],
            'forklift_tipi' => $_POST["forklift_tipi"],
            "acente" => $_POST["acenta"],
            "acente_ref" => $_POST["acenta_ref"],
            'insert_userid' => $_SESSION["user_id"],
            'insert_datetime' => date("Y-m-d H:i:s"),
            'cari_key' => $cari_key,
            'sube_key' => $sube_key,
            'status' => 2
        ];
        $siparisi_dusur = DBD::update("ihracat_siparis", "id", $siparis_id, $arr);
        $siparisin_geldigi_yer = 2;
    }

    $arr_main = [
        'aciklama' => $_POST["ana_aciklama"],
    ];

    foreach ($_POST["gonderilecek_islem_arr"] as $urunler) {
        if (isset($urunler["id"])) {

        } else {
            $urun_arr = [
                "hizmet_id" => $urunler["stok_id"],
                "birim_id" => $urunler["birim_id"],
                "sefer_sayisi" => $urunler["sefer_sayisi"],
                "is_emri_id" => $_POST["id"],
                'insert_userid' => $_SESSION["user_id"],
                'insert_datetime' => date("Y-m-d H:i:s"),
                'cari_key' => $cari_key,
                'sube_key' => $sube_key
            ];
            $is_emri_urunu_olustur = DBD::insert("is_emri_urunler", $urun_arr);
        }
    }

    $main_is_emri_olustur = DBD::update("is_emri_main", "id", $_POST["id"], $arr_main);
    if ($main_is_emri_olustur) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "is_emri_urunu_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_detail"] = "Güncelleme Sayfasından Silinmiştir";
    $_POST["status"] = 0;
    $sil = DBD::update("is_emri_urunler", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "konteynerleri_tanit_sql") {
    $arr = [
        'tipi' => $_POST["tipi"],
        'siparis_id' => $_POST["siparis_id"],
        'insert_userid' => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s"),
        'cari_key' => $cari_key,
        'cari_id' => $_POST["cari_id"],
        'sube_key' => $sube_key
    ];

    $konteyner_ana_tanim = DBD::insert("konteyner_tanim", $arr);
    if ($konteyner_ana_tanim) {
        echo 500;
    } else {
        $son_eklenen = DBD::single_query("SELECT id FROM konteyner_tanim where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        foreach ($_POST["gidecek_arr"] as $item) {
            $arr2 = [
                'ana_id' => $son_eklenen["id"],
                'konteyner_no' => $item["konteyner_no"],
                'konteyner_tipi' => $item["konteyner_tipi"],
                'cari_key' => $cari_key,
                'sube_key' => $sube_key,
                'insert_userid' => $_SESSION["user_id"],
                'insert_datetime' => date("Y-m-d H:i:s")
            ];
            $urunler = DBD::insert("konteyner_tanim_urunler", $arr2);
        }
        if ($urunler) {
            echo 500;
        } else {
            $siparis_id = $_POST["siparis_id"];
            if ($_POST["tipi"] == "İHRACAT") {
                $arr3 = [
                    'konteyner_tanimlandi' => 1
                ];
                $konteynerler_tanimli = DBD::update("ihracat_siparis", "id", $siparis_id, $arr3);
            } else {
                $arr3 = [
                    'konteyner_tanimlandi' => 1
                ];
                $konteynerler_tanimli = DBD::update("ithalat_siparis", "id", $siparis_id, $arr3);
            }
            if ($konteynerler_tanimli) {
                echo 1;
            } else {
                echo 2;
            }
        }
    }
}
if ($islem == "tanimlanan_konteynerleri_getir_sql") {
    $tanimlanan_konteynerler = DBD::all_data("
SELECT
       kt.*,
       COUNT(ktu.id) as toplam_konteyner
FROM
     konteyner_tanim AS kt 
INNER JOIN konteyner_tanim_urunler AS ktu on ktu.ana_id=kt.id
WHERE kt.status!=0 AND ktu.status!=0 AND kt.cari_key='$cari_key' GROUP BY kt.id
");
    if ($tanimlanan_konteynerler > 0) {
        $gidecek_arr = [];
        foreach ($tanimlanan_konteynerler as $item) {
            $arr = [
                'tipi' => $item["tipi"],
                'toplam_konteyner' => $item["toplam_konteyner"],
                'islem' => "<button class='btn btn-sm' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>"
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
if ($islem == "tum_siparisleri_getir") {
    $ek_sorgu = "";
    if (isset($_GET["cari_id"])) {
        $cari_id = $_GET["cari_id"];
        if ($cari_id == "") {

        } else {
            $ek_sorgu = " AND is_m.cari_id='$cari_id'";
        }
    }

    $tum_siparisler = DBD::all_data("
SELECT
       is_m.*,
       isu.birim_id,
       isu.epro_ref,
       COUNT(isu.id) as siparis_adet,
       GROUP_CONCAT(CONCAT(isu.konteyner_sayisi, 'X', isu.konteyner_tipi)) as konteynerler,
       SUM(isu.miktar) as toplam_miktar,
       SUM(isu.konteyner_sayisi) as konteyner_sayisi
FROM 
     ihracat_siparis as is_m
INNER JOIN ihracat_siparis_urunler AS isu on isu.siparis_id=is_m.id
WHERE
      (is_m.status=2 OR is_m.status=1) AND isu.status=1 AND is_m.cari_key='$cari_key' $ek_sorgu AND is_m.konteyner_tanimlandi=0
GROUP BY is_m.id");
    if ($tum_siparisler > 0) {
        $gonderilecek_arr = [];

        foreach ($tum_siparisler as $item) {
            $cari_id = $item["cari_id"];
            $birim_id = $item["birim_id"];
            $cari_adi = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
            $birim = DB::single_query("SELECT * FROM birim WHERE status=1 AND cari_key='$cari_key' AND id='$birim_id'");
            $siparis_tarihi = date("d/m/Y", strtotime($item["siparis_tarihi"]));
            $cut_of_tarihi = date("d/m/Y", strtotime($item["cutt_off_tarihi"]));
            $ardiyesiz_giris_tarihi = date("d/m/Y", strtotime($item["ardiyesiz_giris_tarihi"]));
            $toplam_miktar = number_format($item["toplam_miktar"], 2);
            $konteyner_tipleri = str_replace(',', "<br>", $item["konteynerler"]);
            $arr = [
                'cari_adi' => $cari_adi["cari_adi"],
                'cari_kodu' => $cari_adi["cari_kodu"],
                'siparis_tarihi' => $siparis_tarihi,
                'alim_yeri' => $item["alim_yeri"],
                'cut_of_tarihi' => $cut_of_tarihi,
                'ardiyesiz_giris_tarihi' => $ardiyesiz_giris_tarihi,
                'toplam_yukleme_miktari' => $toplam_miktar . " " . $birim["birim_adi"],
                'toplam_siparis' => $item["siparis_adet"],
                'acente' => $item["acente"],
                'acente_ref' => $item["acente_ref"],
                'toplam_konteyner_sayisi' => $item["konteyner_sayisi"],
                'epro_ref' => $item["epro_ref"],
                'beyanname_no' => '',
                'konteyner_tipleri' => $konteyner_tipleri,
                'aciklama' => $item["aciklama"],
                'demoraj_tarihi' => "",
                'tipi' => "İHRACAT",
                'islem' => "<button class='btn btn-sm depo_ihracat_siparis_guncelle' style='background-color: #F6FA70' data-id='" . $item["id"] . "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm depo_ihracat_siparis_islemleri_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>",
                'id' => $item["id"],
            ];
            array_push($gonderilecek_arr, $arr);
        }
    }
    $ek_sorgu = "";
    if (isset($_GET["cari_id"])) {
        $cari_id = $_GET["cari_id"];
        if ($cari_id == "") {

        } else {
            $ek_sorgu = " AND is_m.cari_id='$cari_id'";
        }
    }

    $tum_siparisler = DBD::all_data("
SELECT
       is_m.*,
       isu.birim_id,
       isu.epro_ref,
       COUNT(isu.id) as siparis_adet,
       GROUP_CONCAT(CONCAT(isu.konteyner_sayisi, 'X', isu.konteyner_tipi)) as konteynerler,
       SUM(isu.miktar) as toplam_miktar,
       SUM(isu.konteyner_sayisi) as konteyner_sayisi
FROM 
     ithalat_siparis as is_m
INNER JOIN ithalat_siparis_urunler AS isu on isu.siparis_id=is_m.id
WHERE
      (is_m.status=1 OR is_m.status=2) AND isu.status=1 AND is_m.cari_key='$cari_key' $ek_sorgu
GROUP BY is_m.id");
    if ($tum_siparisler > 0) {
        $gonderilecek_arr2 = [];

        foreach ($tum_siparisler as $item) {
            $cari_id = $item["cari_id"];
            $birim_id = $item["birim_id"];
            $cari_adi = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
            $birim = DB::single_query("SELECT * FROM birim WHERE status=1 AND cari_key='$cari_key' AND id='$birim_id'");
            $siparis_tarihi = date("d/m/Y", strtotime($item["siparis_tarihi"]));
            $demoraj_tarihi = date("d/m/Y", strtotime($item["demoraj_tarihi"]));
            $toplam_miktar = number_format($item["toplam_miktar"], 2);
            $konteyner_tipleri = str_replace(',', "<br>", $item["konteynerler"]);
            $arr = [
                'cari_adi' => $cari_adi["cari_adi"],
                'cari_kodu' => $cari_adi["cari_kodu"],
                'siparis_tarihi' => $siparis_tarihi,
                'alim_yeri' => $item["alim_yeri"],
                'acente_ref' => '',
                'demoraj_tarihi' => $demoraj_tarihi,
                'toplam_yukleme_miktari' => $toplam_miktar . " " . $birim["birim_adi"],
                'toplam_siparis' => $item["siparis_adet"],
                'acente' => $item["acente"],
                'beyanname_no' => $item["beyanname_no"],
                'toplam_konteyner_sayisi' => $item["konteyner_sayisi"],
                'epro_ref' => $item["epro_ref"],
                'konteyner_tipleri' => $konteyner_tipleri,
                'cut_of_tarihi' => '',
                'ardiyesiz_giris_tarihi' => '',
                'aciklama' => $item["aciklama"],
                'tipi' => "İTHALAT",
                'islem' => "<button class='btn btn-sm depo_ithalat_siparis_guncelle' style='background-color: #F6FA70' data-id='" . $item["id"] . "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm depo_ithalat_siparis_islemleri_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>",
                'id' => $item["id"],
            ];
            array_push($gonderilecek_arr2, $arr);
        }
    }

    $merge = [];
    if (!empty($gonderilecek_arr2)) {
        $merge = array_merge($merge, $gonderilecek_arr2);
    }
    if (!empty($gonderilecek_arr)) {
        $merge = array_merge($merge, $gonderilecek_arr);
    }
    if (!empty($merge)) {
        echo json_encode($merge);
    } else {
        echo 2;
    }
}
if ($islem == "tum_siparisleri_getir2") {
    $ek_sorgu = "";
    if (isset($_GET["cari_id"])) {
        $cari_id = $_GET["cari_id"];
        if ($cari_id == "") {

        } else {
            $ek_sorgu = " AND is_m.cari_id='$cari_id'";
        }
    }
    $ek_sorgu3 = "";
    if ($_GET["modul"] == ""){
        
    }else{
        $ek_sorgu3 = " AND is_m.konteyner_tanimlandi=0";
    }

    $tum_siparisler = DBD::all_data("
SELECT
       is_m.*,
       isu.birim_id,
       isu.epro_ref,
       COUNT(isu.id) as siparis_adet,
       GROUP_CONCAT(CONCAT(isu.konteyner_sayisi, 'X', isu.konteyner_tipi)) as konteynerler,
       SUM(isu.miktar) as toplam_miktar,
       SUM(isu.konteyner_sayisi) as konteyner_sayisi
FROM 
     ihracat_siparis as is_m
INNER JOIN ihracat_siparis_urunler AS isu on isu.siparis_id=is_m.id
WHERE
      (is_m.status=2 OR is_m.status=1) AND isu.status=1 AND is_m.cari_key='$cari_key' $ek_sorgu $ek_sorgu3
GROUP BY is_m.id");
    if ($tum_siparisler > 0) {
        $gonderilecek_arr = [];

        foreach ($tum_siparisler as $item) {
            $siparis_id = $item["id"];



            $konteyner_cikis = DBD::single_query("
SELECT
       COUNT(kg.id) as konteyner_sayisi
FROM
     konteyner_giris as kg
INNER JOIN konteyner_cikis as kc on kc.konteyner_id=kg.id
WHERE kc.status=1 AND kc.cari_key='$cari_key' AND kg.siparis_id='$siparis_id' AND kg.bos_dolu='Boş'");
            $cari_id = $item["cari_id"];
            $birim_id = $item["birim_id"];
            $cari_adi = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
            $birim = DB::single_query("SELECT * FROM birim WHERE status=1 AND cari_key='$cari_key' AND id='$birim_id'");
            if ($konteyner_cikis["konteyner_sayisi"] == $item["konteyner_sayisi"]){

            }else{
                $siparis_tarihi = date("d/m/Y", strtotime($item["siparis_tarihi"]));
                $cut_of_tarihi = date("d/m/Y", strtotime($item["cutt_off_tarihi"]));
                $ardiyesiz_giris_tarihi = date("d/m/Y", strtotime($item["ardiyesiz_giris_tarihi"]));
                $toplam_miktar = number_format($item["toplam_miktar"], 2);
                $konteyner_tipleri = str_replace(',', "<br>", $item["konteynerler"]);
                $arr = [
                    'cari_adi' => $cari_adi["cari_adi"],
                    'cari_kodu' => $cari_adi["cari_kodu"],
                    'siparis_tarihi' => $siparis_tarihi,
                    'alim_yeri' => $item["alim_yeri"],
                    'cut_of_tarihi' => $cut_of_tarihi,
                    'ardiyesiz_giris_tarihi' => $ardiyesiz_giris_tarihi,
                    'toplam_yukleme_miktari' => $toplam_miktar . " " . $birim["birim_adi"],
                    'toplam_siparis' => $item["siparis_adet"],
                    'acente' => $item["acente"],
                    'acente_ref' => $item["acente_ref"],
                    'toplam_konteyner_sayisi' => $item["konteyner_sayisi"],
                    'epro_ref' => $item["epro_ref"],
                    'beyanname_no' => '',
                    'konteyner_tipleri' => $konteyner_tipleri,
                    'aciklama' => $item["aciklama"],
                    'demoraj_tarihi' => "",
                    'tipi' => "İHRACAT",
                    'islem' => "<button class='btn btn-sm depo_ihracat_siparis_guncelle' style='background-color: #F6FA70' data-id='" . $item["id"] . "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm depo_ihracat_siparis_islemleri_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>",
                    'id' => $item["id"],
                ];
                array_push($gonderilecek_arr, $arr);
            }
        }
    }
    $ek_sorgu = "";
    if (isset($_GET["cari_id"])) {
        $cari_id = $_GET["cari_id"];
        if ($cari_id == "") {

        } else {
            $ek_sorgu = " AND is_m.cari_id='$cari_id'";
        }
    }

    $tum_siparisler = DBD::all_data("
SELECT
       is_m.*,
       isu.birim_id,
       isu.epro_ref,
       COUNT(isu.id) as siparis_adet,
       GROUP_CONCAT(CONCAT(isu.konteyner_sayisi, 'X', isu.konteyner_tipi)) as konteynerler,
       SUM(isu.miktar) as toplam_miktar,
       SUM(isu.konteyner_sayisi) as konteyner_sayisi
FROM 
     ithalat_siparis as is_m
INNER JOIN ithalat_siparis_urunler AS isu on isu.siparis_id=is_m.id
WHERE
      (is_m.status=2 OR is_m.status=1) AND isu.status=1 AND is_m.cari_key='$cari_key' $ek_sorgu
GROUP BY is_m.id");
    if ($tum_siparisler > 0) {
        $gonderilecek_arr2 = [];

        foreach ($tum_siparisler as $item) {
            $cari_id = $item["cari_id"];
            $siparis_id = $item["id"];
            $birim_id = $item["birim_id"];
            $cari_adi = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
            $birim = DB::single_query("SELECT * FROM birim WHERE status=1 AND cari_key='$cari_key' AND id='$birim_id'");


            $konteyner_cikis = DBD::single_query("
SELECT
       COUNT(kg.id) as konteyner_sayisi
FROM
     konteyner_giris as kg
INNER JOIN konteyner_cikis as kc on kc.konteyner_id=kg.id
WHERE kc.status=1 AND kc.cari_key='$cari_key' AND kg.siparis_id='$siparis_id' AND kg.bos_dolu='Dolu'");
            if ($konteyner_cikis["konteyner_sayisi"] == $item["konteyner_sayisi"]){

            }else{
                $siparis_tarihi = date("d/m/Y", strtotime($item["siparis_tarihi"]));
                $demoraj_tarihi = date("d/m/Y", strtotime($item["demoraj_tarihi"]));
                $toplam_miktar = number_format($item["toplam_miktar"], 2);
                $konteyner_tipleri = str_replace(',', "<br>", $item["konteynerler"]);
                $arr = [
                    'cari_adi' => $cari_adi["cari_adi"],
                    'cari_kodu' => $cari_adi["cari_kodu"],
                    'siparis_tarihi' => $siparis_tarihi,
                    'alim_yeri' => $item["alim_yeri"],
                    'acente_ref' => '',
                    'demoraj_tarihi' => $demoraj_tarihi,
                    'toplam_yukleme_miktari' => $toplam_miktar . " " . $birim["birim_adi"],
                    'toplam_siparis' => $item["siparis_adet"],
                    'acente' => $item["acente"],
                    'beyanname_no' => $item["beyanname_no"],
                    'toplam_konteyner_sayisi' => $item["konteyner_sayisi"],
                    'epro_ref' => $item["epro_ref"],
                    'konteyner_tipleri' => $konteyner_tipleri,
                    'cut_of_tarihi' => '',
                    'ardiyesiz_giris_tarihi' => '',
                    'aciklama' => $item["aciklama"],
                    'tipi' => "İTHALAT",
                    'islem' => "<button class='btn btn-sm depo_ithalat_siparis_guncelle' style='background-color: #F6FA70' data-id='" . $item["id"] . "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm depo_ithalat_siparis_islemleri_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>",
                    'id' => $item["id"],
                ];
                array_push($gonderilecek_arr2, $arr);
            }
        }
    }

    $merge = [];
    if (!empty($gonderilecek_arr2)) {
        $merge = array_merge($merge, $gonderilecek_arr2);
    }
    if (!empty($gonderilecek_arr)) {
        $merge = array_merge($merge, $gonderilecek_arr);
    }
    if (!empty($merge)) {
        echo json_encode($merge);
    } else {
        echo 2;
    }
}