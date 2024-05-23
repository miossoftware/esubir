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


if ($islem == "gelmesi_beklenen_faturalari_getir_sql") {
    $gelmesi_beklenen_faturalar = DBD::all_data("
SELECT
       kc.cikis_tarihi,
       its.siparis_tarihi as ithalat_tarih,
       is_s.siparis_tarihi as ihracat_tarih,
       kg.konteyner_no,
       kg.giris_tarihi,
       iem.depo_bedeli as ihracat_depo_bedeli,
       iem.tasima_bedeli as ihracat_tasima_bedeli,
       iie.depo_bedeli as ithalat_depo_bedeli,
       iie.tasima_bedeli as ithalat_tasima_bedeli,
       its.beyanname_no,
       is_s.acente_ref,
       its.cari_id as ithalat_cari,
       is_s.cari_id as ihracat_cari,
       iem.id as ihracat_id,
       iie.id as ithalat_id
FROM
     konteyner_cikis as kc
INNER JOIN konteyner_giris as kg on kg.konteyner_id=kc.id
LEFT JOIN ithalat_siparis as its on its.id=kg.siparis_id
LEFT JOIN ihracat_siparis as is_s on is_s.id=kg.siparis_id
LEFT JOIN is_emri_main as iem on iem.siparis_id=is_s.id
LEFT JOIN ithalat_is_emri as iie on iie.siparis_id=its.id
WHERE kc.status=1 AND kc.cari_key='$cari_key' GROUP BY kc.id");
    if ($gelmesi_beklenen_faturalar > 0) {
        $gidecek_arr = [];
        foreach ($gelmesi_beklenen_faturalar as $item) {
            $cari_id = "";
            $tarih = "";
            $depo_bedeli = 0;
            $tasima_bedeli = 0;
            $id = "";
            if ($item["ihracat_cari"] == null) {
                $cari_id = $item["ithalat_cari"];
                $tarih = $item["ithalat_tarih"];
                $id = $item["ithalat_id"];
            } else {
                $cari_id = $item["ihracat_cari"];
                $tarih = $item["ihracat_tarih"];
                $id = $item["ihracat_id"];
            }
            $cari = DB::single_query("SELECT cari_adi FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
            $giris_tarihi = $item["giris_tarihi"];
            if ($giris_tarihi != null) {
                $giris_tarihi = date("d/m/Y", strtotime($giris_tarihi));
            }
            $cikis_tarihi = $item["cikis_tarihi"];
            if ($cikis_tarihi != null) {
                $cikis_tarihi = date("d/m/Y", strtotime($cikis_tarihi));
            }
            if ($tarih != null) {
                $tarih = date("d/m/Y", strtotime($tarih));
            }
            if ($item["ihracat_tasima_bedeli"] == 0){
                $tasima_bedeli = $item["ithalat_tasima_bedeli"];
            }else{
                $tasima_bedeli = $item["ihracat_tasima_bedeli"];
            }
            if ($item["ihracat_depo_bedeli"] == 0){
                $depo_bedeli = $item["ithalat_depo_bedeli"];
            }else{
                $depo_bedeli = $item["ihracat_depo_bedeli"];
            }

            $depo_bedeli = number_format($depo_bedeli, 2);
            $tasima_bedeli = number_format($tasima_bedeli, 2);

            $arr = [
                'giris_tarihi' => $giris_tarihi,
                'cikis_tarihi' => $cikis_tarihi,
                'siparis_tarihi' => $tarih,
                'konteyner_no' => $item["konteyner_no"],
                'cari' => $cari["cari_adi"],
                'depo_bedeli' => $depo_bedeli,
                'tasima_bedeli' => $tasima_bedeli,
                'beyanname_no' => $item["beyanname_no"],
                'referans_no' => $item["acente_ref"],
                'id' => $id
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
if ($islem == "cariye_ait_irsaliyeler_getir_sql") {
    $cari_id = $_GET["cari_id"];
    $gelmesi_beklenen_faturalar = DBD::all_data("
SELECT
       kc.cikis_tarihi,
       its.siparis_tarihi as ithalat_tarih,
       is_s.siparis_tarihi as ihracat_tarih,
       kg.konteyner_no,
       kg.giris_tarihi,
       iem.depo_bedeli as ihracat_depo_bedeli,
       iem.tasima_bedeli as ihracat_tasima_bedeli,
       iie.depo_bedeli as ithalat_depo_bedeli,
       its.beyanname_no,
       is_s.acente_ref,
       its.cari_id as ithalat_cari,
       is_s.cari_id as ihracat_cari,
       kc.id
FROM
     konteyner_cikis as kc
INNER JOIN konteyner_giris as kg on kg.konteyner_id=kc.id
LEFT JOIN ithalat_siparis as its on its.id=kg.siparis_id
LEFT JOIN ihracat_siparis as is_s on is_s.id=kg.siparis_id
LEFT JOIN is_emri_main as iem on iem.siparis_id=is_s.id
LEFT JOIN ithalat_is_emri as iie on iie.siparis_id=its.id
WHERE kc.status=1 AND kc.cari_key='$cari_key' AND (its.cari_id='$cari_id' OR is_s.cari_id='$cari_id') AND ((iem.depo_kesildi =1 AND iem.depo_bedeli!=0) OR (iie.depo_kesildi=1 AND iie.depo_bedeli!=0)) GROUP BY kc.id");
    if ($gelmesi_beklenen_faturalar > 0) {
        $gidecek_arr = [];
        foreach ($gelmesi_beklenen_faturalar as $item) {
            $cari_id = "";
            $tarih = "";
            $depo_bedeli = 0;
            $tasima_bedeli = 0;
            $id = "";
            if ($item["ihracat_cari"] == null) {
                $cari_id = $item["ithalat_cari"];
                $tarih = $item["ithalat_tarih"];
            } else {
                $cari_id = $item["ihracat_cari"];
                $tarih = $item["ihracat_tarih"];
            }
            if ($item["ihracat_depo_bedeli"] == 0) {
                $depo_bedeli = $item["ithalat_depo_bedeli"];
            } else {
                $depo_bedeli = $item["ihracat_depo_bedeli"];
            }
            $cari = DB::single_query("SELECT cari_adi FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
            $giris_tarihi = $item["giris_tarihi"];
            if ($giris_tarihi != null) {
                $giris_tarihi = date("d/m/Y", strtotime($giris_tarihi));
            }
            $cikis_tarihi = $item["cikis_tarihi"];
            if ($cikis_tarihi != null) {
                $cikis_tarihi = date("d/m/Y", strtotime($cikis_tarihi));
            }
            if ($tarih != null) {
                $tarih = date("d/m/Y", strtotime($tarih));
            }

            $depo_bedeli = number_format($depo_bedeli, 2);

            $arr = [
                'giris_tarihi' => $giris_tarihi,
                'cikis_tarihi' => $cikis_tarihi,
                'hizmet_turu' => "Depo Hizmeti",
                'siparis_tarihi' => $tarih,
                'konteyner_no' => $item["konteyner_no"],
                'cari' => $cari["cari_adi"],
                'ucret' => $depo_bedeli,
                'tasima_bedeli' => 0,
                'beyanname_no' => $item["beyanname_no"],
                'referans_no' => $item["acente_ref"],
                'id' => $item["id"]
            ];
            array_push($gidecek_arr, $arr);
        }
    }
    $gelmesi_beklenen_faturalar = DBD::all_data("
SELECT
       kc.cikis_tarihi,
       its.siparis_tarihi as ithalat_tarih,
       is_s.siparis_tarihi as ihracat_tarih,
       kg.konteyner_no,
       kg.giris_tarihi,
       iem.depo_bedeli as ihracat_depo_bedeli,
       iem.tasima_bedeli as ihracat_tasima_bedeli,
       iie.depo_bedeli as ithalat_depo_bedeli,
       iie.tasima_bedeli as ithalat_tasima_bedeli,
       its.beyanname_no,
       is_s.acente_ref,
       its.cari_id as ithalat_cari,
       is_s.cari_id as ihracat_cari,
       kc.id
FROM
     konteyner_cikis as kc
INNER JOIN konteyner_giris as kg on kg.konteyner_id=kc.id
LEFT JOIN ithalat_siparis as its on its.id=kg.siparis_id
LEFT JOIN ihracat_siparis as is_s on is_s.id=kg.siparis_id
LEFT JOIN is_emri_main as iem on iem.siparis_id=is_s.id
LEFT JOIN ithalat_is_emri as iie on iie.siparis_id=its.id
WHERE kc.status=1 AND kc.cari_key='$cari_key' AND (its.cari_id='$cari_id' OR is_s.cari_id='$cari_id') AND ((iem.tasima_kesildi=1 AND iem.tasima_bedeli!=0) OR (iie.tasima_kesildi=1 AND iie.tasima_bedeli!=0))");
    if ($gelmesi_beklenen_faturalar > 0) {
        foreach ($gelmesi_beklenen_faturalar as $item) {
            $cari_id = "";
            $tarih = "";
            $depo_bedeli = 0;
            $tasima_bedeli = 0;
            $id = "";
            if ($item["ihracat_cari"] == null) {
                $cari_id = $item["ithalat_cari"];
                $tarih = $item["ithalat_tarih"];
            } else {
                $cari_id = $item["ihracat_cari"];
                $tarih = $item["ihracat_tarih"];
            }

            if ($item["ihracat_tasima_bedeli"] == 0){
                $tasima_bedeli = $item["ithalat_tasima_bedeli"];
            }else{
                $tasima_bedeli = $item["ihracat_tasima_bedeli"];
            }

            $cari = DB::single_query("SELECT cari_adi FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
            $giris_tarihi = $item["giris_tarihi"];
            if ($giris_tarihi != null) {
                $giris_tarihi = date("d/m/Y", strtotime($giris_tarihi));
            }
            $cikis_tarihi = $item["cikis_tarihi"];
            if ($cikis_tarihi != null) {
                $cikis_tarihi = date("d/m/Y", strtotime($cikis_tarihi));
            }
            if ($tarih != null) {
                $tarih = date("d/m/Y", strtotime($tarih));
            }

            $tasima_bedeli = number_format($tasima_bedeli, 2);

            $arr = [
                'giris_tarihi' => $giris_tarihi,
                'cikis_tarihi' => $cikis_tarihi,
                'siparis_tarihi' => $tarih,
                'hizmet_turu' => "Taşıma Hizmeti",
                'konteyner_no' => $item["konteyner_no"],
                'cari' => $cari["cari_adi"],
                'depo_bedeli' => 0,
                'ucret' => $tasima_bedeli,
                'beyanname_no' => $item["beyanname_no"],
                'referans_no' => $item["acente_ref"],
                'id' => $item["id"]
            ];
            array_push($gidecek_arr, $arr);
        }
    }


    if (!empty($gidecek_arr)) {
        echo json_encode($gidecek_arr);
    } else {
        echo 2;
    }
}