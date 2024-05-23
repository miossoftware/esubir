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

if ($islem == "depo_ithalat_konteyner_siparis_kaydet_sql") {
    $arr = [
        'cari_id' => $_POST["cari"],
        'siparis_tarihi' => $_POST["siparis_tarihi"],
        'alim_yeri' => $_POST["alim_yeri"],
        'demoraj_tarihi' => $_POST["demoraj_tarihi"],
        'aciklama' => $_POST["aciklama"],
        "acente" => $_POST["acente"],
        "beyanname_no" => $_POST["beyanname_no"],
        'insert_userid' => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s"),
        'cari_key' => $cari_key,
        'sube_key' => $sube_key
    ];

    $ihracat_siparis_olustur = DBD::insert("ithalat_siparis", $arr);
    if ($ihracat_siparis_olustur) {
        echo 500;
    } else {
        $son_eklenen = DBD::single_query("SELECT id FROM ithalat_siparis where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");

        foreach ($_POST["gonderilecek_arr"] as $item) {
            $item["siparis_id"] = $son_eklenen["id"];
            $item["insert_userid"] = $_SESSION["user_id"];
            $item["insert_datetime"] = date("Y-m-d H:i:s");
            $item["cari_key"] = $cari_key;
            $item["sube_key"] = $sube_key;

            $ihracat_siparis_urunleri = DBD::insert("ithalat_siparis_urunler", $item);
        }
        if ($ihracat_siparis_urunleri) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "ithalat_siparislerini_getir_sql") {
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
            $demoraj_tarihi = date("d/m/Y", strtotime($item["demoraj_tarihi"]));
            $toplam_miktar = number_format($item["toplam_miktar"], 2);
            $konteyner_tipleri = str_replace(',', "<br>", $item["konteynerler"]);
            $arr = [
                'cari_adi' => $cari_adi["cari_adi"],
                'cari_kodu' => $cari_adi["cari_kodu"],
                'siparis_tarihi' => $siparis_tarihi,
                'alim_yeri' => $item["alim_yeri"],
                'demoraj_tarihi' => $demoraj_tarihi,
                'toplam_yukleme_miktari' => $toplam_miktar . " " . $birim["birim_adi"],
                'toplam_siparis' => $item["siparis_adet"],
                'acente' => $item["acente"],
                'beyanname_no' => $item["beyanname_no"],
                'toplam_konteyner_sayisi' => $item["konteyner_sayisi"],
                'epro_ref' => $item["epro_ref"],
                'konteyner_tipleri' => $konteyner_tipleri,
                'aciklama' => $item["aciklama"],
                'islem' => "<button class='btn btn-sm depo_ithalat_siparis_guncelle' style='background-color: #F6FA70' data-id='" . $item["id"] . "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm depo_ithalat_siparis_islemleri_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>",
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
if ($islem == "ithalat_siparislerini_getir_sql2") {
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
        $gonderilecek_arr = [];

        foreach ($tum_siparisler as $item) {
            $siparis_id = $item["id"];
            $cari_id = $item["cari_id"];
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
                    'demoraj_tarihi' => $demoraj_tarihi,
                    'toplam_yukleme_miktari' => $toplam_miktar . " " . $birim["birim_adi"],
                    'toplam_siparis' => $item["siparis_adet"],
                    'acente' => $item["acente"],
                    'beyanname_no' => $item["beyanname_no"],
                    'toplam_konteyner_sayisi' => $item["konteyner_sayisi"],
                    'epro_ref' => $item["epro_ref"],
                    'konteyner_tipleri' => $konteyner_tipleri,
                    'aciklama' => $item["aciklama"],
                    'islem' => "<button class='btn btn-sm depo_ithalat_siparis_guncelle' style='background-color: #F6FA70' data-id='" . $item["id"] . "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm depo_ithalat_siparis_islemleri_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>",
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
if ($islem == "son_epro_referans_sql") {
    $ay_bas = date("Y-m-01");
    $ay_sonu = date("Y-m-t");
    $siparisler = DBD::single_query("
SELECT
       isu.*
FROM
     ithalat_siparis_urunler as isu
INNER JOIN ithalat_siparis as is_s on is_s.id=isu.siparis_id
WHERE isu.status=1 AND isu.cari_key='$cari_key' AND is_s.siparis_tarihi BETWEEN '$ay_bas 00:00:00' AND '$ay_sonu 23:59:59' ORDER BY isu.id DESC LIMIT 1");
    if ($siparisler > 0) {
        echo json_encode($siparisler);
    } else {
        echo 2;
    }
}
if ($islem == "depo_ithlat_siparisi_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $sil = DBD::update("ithalat_siparis", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
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
     ithalat_siparis as is_s
INNER JOIN ithalat_siparis_urunler as isu on isu.siparis_id=is_s.id
WHERE (is_s.status=2 OR is_s.status=1) AND isu.status=1 AND is_s.id='$id' AND is_s.cari_key='$cari_key'");
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
            'beyanname_no' => $guncellenecek_ana["beyanname_no"],
            'urun_adi' => $guncellenecek_ana["urun_adi"],
            'mal_id' => $guncellenecek_ana["mal_id"],
            'acente' => $guncellenecek_ana["acente"],
            'epro_ref' => $guncellenecek_ana["epro_ref"],
            'birim_id' => $guncellenecek_ana["birim_id"],
            'alim_yeri' => $guncellenecek_ana["alim_yeri"],
            'siparis_tarihi' => $guncellenecek_ana["siparis_tarihi"],
            'demoraj_tarihi' => $guncellenecek_ana["demoraj_tarihi"],
            'aciklama' => $guncellenecek_ana["aciklama"],
            'fabrika_ref' => $guncellenecek_ana["fabrika_ref"],
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
     ithalat_siparis as is_s
INNER JOIN ithalat_siparis_urunler as isu on isu.siparis_id=is_s.id
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
            'beyanname_no' => $guncellenecek_ana["beyanname_no"],
            'urun_adi' => $guncellenecek_ana["urun_adi"],
            'mal_id' => $guncellenecek_ana["mal_id"],
            'konteyner_tipi' => $guncellenecek_ana["konteyner_tipi"],
            'acente' => $guncellenecek_ana["acente"],
            'epro_ref' => $guncellenecek_ana["epro_ref"],
            'birim_id' => $guncellenecek_ana["birim_id"],
            'alim_yeri' => $guncellenecek_ana["alim_yeri"],
            'siparis_tarihi' => $guncellenecek_ana["siparis_tarihi"],
            'demoraj_tarihi' => $guncellenecek_ana["demoraj_tarihi"],
            'aciklama' => $guncellenecek_ana["aciklama"],
            'fabrika_ref' => $guncellenecek_ana["fabrika_ref"],
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
SELECT * FROM ithalat_siparis_urunler WHERE status=1 AND cari_key='$cari_key' AND siparis_id='$siparis_id'");
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
                'islem' => "<button class='btn btn-danger btn-sm ithalat_listesindeki_urunu_sil' data-id='" . $urun["id"] . "'><i class='fa fa-trash'></i></button>"
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
    $ekle = DBD::insert("ithalat_siparis_urunler", $_POST);
    if ($ekle) {
        echo 2;
    } else {
        $son_eklenen = DBD::single_query("SELECT id FROM ithalat_siparis_urunler where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        echo 'id:' . $son_eklenen["id"];
    }
}
if ($islem == "ithalat_siparis_urunu_sil_sql") {
    $_POST["status"] = 0;
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_detail"] = "Kullanıcı Güncelleme Sayfasından Silmiştir";
    $sil = DBD::update("ithalat_siparis_urunler", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "depo_konteyner_siparis_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DBD::update("ithalat_siparis", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "tum_is_emirlerini_getir_sql") {
    $tum_is_emirlerini_getir = DBD::all_data("
SELECT
       iem.tarih,
       is_s.siparis_tarihi,
       COUNT(is_s.id) as siparis_sayisi,
       isu.epro_ref,
       SUM(isu.konteyner_sayisi) as konteyner_sayisi,
       is_s.beyanname_no,
       is_s.alim_yeri,
       is_s.demoraj_tarihi,
       is_s.aciklama as sip_aciklama,
       iem.aciklama,
       is_s.cari_id,
       iem.depo_bedeli,
       iem.tasima_bedeli,
       iem.id,
       is_s.id as siparis_id
FROM
     ithalat_is_emri AS iem 
INNER JOIN ithalat_siparis as is_s on is_s.id=iem.siparis_id
INNER JOIN ithalat_siparis_urunler as isu on isu.siparis_id=is_s.id
WHERE iem.status=1  AND iem.cari_key='$cari_key' AND (is_s.status=2) AND isu.status=1
GROUP BY iem.id
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
WHERE kc.status=1 AND kc.cari_key='$cari_key' AND kg.siparis_id='$siparis_id' AND kg.bos_dolu='Dolu'");
            if ($konteyner_cikis > 0) {
                if ($konteyner_cikis["konteyner_sayisi"] >= $item["konteyner_sayisi"]) {
                    $siparis_tarihi = date("d/m/Y", strtotime($item["siparis_tarihi"]));
                    $demoraj_tarihi = date("d/m/Y", strtotime($item["demoraj_tarihi"]));
                    $depo_bedeli = number_format($item["depo_bedeli"], 2);
                    $hizmet_bedeli = number_format($item["tasima_bedeli"], 2);
                    $res_arr = [
                        'siparis_tarihi' => $siparis_tarihi,
                        'cari_adi' => $cari["cari_adi"],
                        'siparis_sayisi' => $item["siparis_sayisi"],
                        'epro_referans' => $item["epro_ref"],
                        'beyanname_no' => $item["beyanname_no"],
                        'alim_yeri' => $item["alim_yeri"],
                        'demoraj_tarihi' => $demoraj_tarihi,
                        'depo_bedeli' => $depo_bedeli,
                        'hizmet_bedeli' => $hizmet_bedeli,
                        'konteyner_sayisi' => $item["konteyner_sayisi"],
                        'tamamlanan_konteynerler' => $item["konteyner_sayisi"],
                        'siparis_aciklama' => $item["sip_aciklama"],
                        'aciklama' => $item["aciklama"],
                        'islem' => "<button class='btn btn-secondary btn-sm depo_is_emri_guncelleme_button' data-id='" . $item["id"] . "'><i class='fa fa-eye'></i></button> <button class='btn btn-danger btn-sm ithalat_is_emri_sil_main_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
                    ];
                    array_push($response, $res_arr);
                }else{
                    $siparis_tarihi = date("d/m/Y", strtotime($item["siparis_tarihi"]));
                    $demoraj_tarihi = date("d/m/Y", strtotime($item["demoraj_tarihi"]));
                    $depo_bedeli = number_format($item["depo_bedeli"], 2);
                    $hizmet_bedeli = number_format($item["tasima_bedeli"], 2);
                    $res_arr = [
                        'siparis_tarihi' => $siparis_tarihi,
                        'cari_adi' => $cari["cari_adi"],
                        'siparis_sayisi' => $item["siparis_sayisi"],
                        'epro_referans' => $item["epro_ref"],
                        'beyanname_no' => $item["beyanname_no"],
                        'alim_yeri' => $item["alim_yeri"],
                        'demoraj_tarihi' => $demoraj_tarihi,
                        'depo_bedeli' => $depo_bedeli,
                        'hizmet_bedeli' => $hizmet_bedeli,
                        'konteyner_sayisi' => $item["konteyner_sayisi"],
                        'tamamlanan_konteynerler' => 0,
                        'siparis_aciklama' => $item["sip_aciklama"],
                        'aciklama' => $item["aciklama"],
                        'islem' => "<button class='btn btn-sm depo_is_emri_guncelleme_button' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm ithalat_is_emri_sil_main_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
                    ];
                    array_push($response, $res_arr);
                }
            }else{
                $siparis_tarihi = date("d/m/Y", strtotime($item["siparis_tarihi"]));
                $demoraj_tarihi = date("d/m/Y", strtotime($item["demoraj_tarihi"]));
                $depo_bedeli = number_format($item["depo_bedeli"], 2);
                $hizmet_bedeli = number_format($item["tasima_bedeli"], 2);
                $res_arr = [
                    'siparis_tarihi' => $siparis_tarihi,
                    'cari_adi' => $cari["cari_adi"],
                    'siparis_sayisi' => $item["siparis_sayisi"],
                    'epro_referans' => $item["epro_ref"],
                    'beyanname_no' => $item["beyanname_no"],
                    'alim_yeri' => $item["alim_yeri"],
                    'demoraj_tarihi' => $demoraj_tarihi,
                    'depo_bedeli' => $depo_bedeli,
                    'hizmet_bedeli' => $hizmet_bedeli,
                    'konteyner_sayisi' => $item["konteyner_sayisi"],
                    'tamamlanan_konteynerler' => 0,
                    'siparis_aciklama' => $item["sip_aciklama"],
                    'aciklama' => $item["aciklama"],
                    'islem' => "<button class='btn btn-sm depo_is_emri_guncelleme_button' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm ithalat_is_emri_sil_main_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "is_emri_olustur_ve_kaydet_sql") {
    $siparis_id = "";
    $siparisin_geldigi_yer = "";
    if (!isset($_POST["siparis_id"])) {
        $arr = [
            'cari_id' => $_POST["cari_id"],
            'siparis_tarihi' => $_POST["siparis_tarihi"],
            'demoraj_tarihi' => $_POST["demoraj_tarihi"],
            'alim_yeri' => $_POST["alim_yeri"],
            'aciklama' => $_POST["aciklama"],
            "acente" => $_POST["acenta"],
            "beyanname_no" => $_POST["beyanname_no"],
            'insert_userid' => $_SESSION["user_id"],
            'insert_datetime' => date("Y-m-d H:i:s"),
            'cari_key' => $cari_key,
            'sube_key' => $sube_key,
            'status' => 2
        ];

        $ihracat_siparis_olustur = DBD::insert("ithalat_siparis", $arr);
        if ($ihracat_siparis_olustur) {
            echo 500;
        } else {
            $son_eklenen = DBD::single_query("SELECT id FROM ithalat_siparis where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
            $siparis_id = $son_eklenen["id"];
            foreach ($_POST["gonderilecek_siparis_arr"] as $item) {
                $item["siparis_id"] = $son_eklenen["id"];
                $item["insert_userid"] = $_SESSION["user_id"];
                $item["insert_datetime"] = date("Y-m-d H:i:s");
                $item["cari_key"] = $cari_key;
                $item["sube_key"] = $sube_key;

                $ihracat_siparis_urunleri = DBD::insert("ithalat_siparis_urunler", $item);
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
            'status' => 2
        ];
        $siparisi_dusur = DBD::update("ithalat_siparis", "id", $siparis_id, $arr);
        $siparisin_geldigi_yer = 2;
    }

    $is_emri_main_arr = [
        "siparis_id" => $siparis_id,
        "siparisin_geldigi_yer" => $siparisin_geldigi_yer,
        "aciklama" => $_POST["ana_aciklama"],
        'depo_bedeli' => $_POST["depo_bedeli"],
        'tasima_bedeli' => $_POST["tasima_bedeli"],
        'forklift_tipi' => $_POST["forklift_tipi"],
        "tarih" => date("Y-m-d H:i:s"),
        'insert_userid' => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s"),
        'cari_key' => $cari_key,
        'sube_key' => $sube_key
    ];

    $main_is_emri_olustur = DBD::insert("ithalat_is_emri", $is_emri_main_arr);
    if ($main_is_emri_olustur) {
        echo 500;
    } else {
        $son_eklenen = DBD::single_query("SELECT id FROM ithalat_is_emri where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        $is_emri_id = $son_eklenen["id"];
        foreach ($_POST["gonderilecek_islem_arr"] as $item2) {
            $urun_arr = [
                "hizmet_id" => $item2["stok_id"],
                "birim_id" => $item2["birim_id"],
                "sefer_sayisi" => $item2["sefer_sayisi"],
                'hizmet_turu' => $item2["hizmet_turu"],
                "is_emri_id" => $is_emri_id,
                'insert_userid' => $_SESSION["user_id"],
                'insert_datetime' => date("Y-m-d H:i:s"),
                'alis_fiyat' => $item2["alis_fiyat"],
                'satis_fiyat' => $item2["satis_fiyat"],
                'cari_key' => $cari_key,
                'sube_key' => $sube_key
            ];
            $is_emri_urunu_olustur = DBD::insert("ithalat_is_emri_urunler", $urun_arr);
        }
        if ($is_emri_urunu_olustur) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "is_emrini_sil_sql") {
    $id = $_POST["id"];
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $is_emri_bilgileri = DBD::single_query("SELECT * FROM ithalat_is_emri WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    $siparis_id = $is_emri_bilgileri["siparis_id"];
    if ($is_emri_bilgileri["siparisin_geldigi_yer"] == 2) {
        $arr = [
            'status' => 1
        ];
        $siparisi_guncelle = DBD::update("ithalat_siparis", "id", $siparis_id, $arr);
    } else {
        $arr = [
            'status' => 3
        ];
        $siparisi_guncelle = DBD::update("ithalat_siparis", "id", $siparis_id, $arr);
    }
    $is_emri_sil = DBD::update("ithalat_is_emri", "id", $id, $_POST);
    if ($is_emri_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "ithalat_is_emri_bilgilerini_getir_sql") {
    $id = $_GET["id"];

    $is_emri_main_bilgileri = DBD::single_query("SELECT * FROM ithalat_is_emri WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
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
     ithalat_siparis as is_s
INNER JOIN ithalat_siparis_urunler as isu on isu.siparis_id=is_s.id
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
            'beyanname_no' => $guncellenecek_ana["beyanname_no"],
            'acente' => $guncellenecek_ana["acente"],
            'alim_yeri' => $guncellenecek_ana["alim_yeri"],
            'siparis_tarihi' => $guncellenecek_ana["siparis_tarihi"],
            'demoraj_tarihi' => $guncellenecek_ana["demoraj_tarihi"],
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
if ($islem == "ithalat_siparisin_urunlerini_getir_sql") {
    $siparis_id = $_GET["siparis_id"];
    $urun_bilgi = DBD::all_data("
SELECT * FROM ithalat_siparis_urunler WHERE status=1 AND cari_key='$cari_key' AND siparis_id='$siparis_id'");
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

    $is_emri_urunlerini_getir_sql = DBD::all_data("SELECT * FROM ithalat_is_emri_urunler WHERE status=1 AND cari_key='$cari_key' AND is_emri_id='$is_emri_id'");
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
                'hizmet_turu' => $item["hizmet_turu"],
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