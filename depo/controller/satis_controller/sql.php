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
       iem.cari_id,
       iem.id as is_emri_id,
       iem.depo_bedeli,
       iem.tasima_bedeli,
       kc.cikis_tarihi,
       kg.giris_tarihi,
       iem.siparis_tarihi,
       kg.konteyner_no,
       kg.konteyner_no1,
       kg.prim_yazilsin,
       iem.referans_no,
       kc.id as konteyner_cikisid,
       iem.beyanname_no,
       iem.tipi,
       kc.bos_dolu,
       iem.epro_ref
FROM
     konteyner_cikis AS kc
INNER JOIN konteyner_giris as kg on kg.id=kc.konteyner_id
INNER JOIN is_emri_main AS iem on iem.id=kg.is_emri_id
WHERE kc.status=1 AND kc.cari_key='$cari_key'  AND iem.depo_bedeli!=0 AND kc.depo_kesildi=1 AND iem.status=1
");
    if ($gelmesi_beklenen_faturalar > 0) {
        $gidecek_arr = [];
        foreach ($gelmesi_beklenen_faturalar as $item) {
            $cari_id = $item["cari_id"];
            $tarih = $item["siparis_tarihi"];
            $depo_bedeli = $item["depo_bedeli"];
            $tasima_bedeli = $item["tasima_bedeli"];
            $id = $item["konteyner_cikisid"];
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

            $kont_no = "";
            if ($item["prim_yazilsin"] == 0) {
                $kont_no = $item["konteyner_no1"];
            } else {
                $kont_no = $item["konteyner_no"];
            }

            $depo_bedeli = number_format($depo_bedeli, 2);
            $tasima_bedeli = number_format($tasima_bedeli, 2);

            if ($item["tipi"] == "İHRACAT" && $item["bos_dolu"] == "Dolu") {
                $arr = [
                    'giris_tarihi' => $giris_tarihi,
                    'cikis_tarihi' => $cikis_tarihi,
                    'siparis_tarihi' => $tarih,
                    'konteyner_no' => $kont_no,
                    'cari' => $cari["cari_adi"],
                    'ucret' => $depo_bedeli,
                    'hizmet_turu' => 'Depo Hizmeti',
                    'beyanname_no' => $item["beyanname_no"],
                    'referans_no' => $item["referans_no"],
                    'epro_ref' => $item["epro_ref"],
                    'id' => $id,
                    'is_emri_id' => $item["is_emri_id"]
                ];
                array_push($gidecek_arr, $arr);
            } else if ($item["tipi"] == "İTHALAT" && $item["bos_dolu"] == "Boş") {
                $arr = [
                    'giris_tarihi' => $giris_tarihi,
                    'cikis_tarihi' => $cikis_tarihi,
                    'siparis_tarihi' => $tarih,
                    'konteyner_no' => $kont_no,
                    'cari' => $cari["cari_adi"],
                    'ucret' => $depo_bedeli,
                    'hizmet_turu' => 'Depo Hizmeti',
                    'beyanname_no' => $item["beyanname_no"],
                    'referans_no' => $item["referans_no"],
                    'epro_ref' => $item["epro_ref"],
                    'id' => $id,
                    'is_emri_id' => $item["is_emri_id"]
                ];
                array_push($gidecek_arr, $arr);
            }


        }
    }
    $gelmesi_beklenen_faturalar = DBD::all_data("
SELECT 
       iem.cari_id,
       iem.id as is_emri_id,
       iem.depo_bedeli,
       iem.tasima_bedeli,
       kc.cikis_tarihi,
       kg.giris_tarihi,
       kc.bos_dolu,
       iem.siparis_tarihi,
       kg.konteyner_no,
       kg.konteyner_no1,
       kg.prim_yazilsin,
       iem.referans_no,
       kc.id as konteyner_cikisid,
       iem.beyanname_no,
       iem.tipi,
       iem.epro_ref
FROM
     konteyner_cikis AS kc
INNER JOIN konteyner_giris as kg on kg.id=kc.konteyner_id
INNER JOIN is_emri_main AS iem on iem.id=kg.is_emri_id
WHERE kc.status=1 AND kc.cari_key='$cari_key' AND iem.tasima_bedeli!=0 AND kc.tasima_kesildi=1  AND iem.status=1
");
    if ($gelmesi_beklenen_faturalar > 0) {
        foreach ($gelmesi_beklenen_faturalar as $item) {
            $cari_id = $item["cari_id"];
            $tarih = $item["siparis_tarihi"];
            $depo_bedeli = $item["depo_bedeli"];
            $tasima_bedeli = $item["tasima_bedeli"];
            $id = $item["konteyner_cikisid"];
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

            $kont_no = "";
            if ($item["prim_yazilsin"] == 0) {
                $kont_no = $item["konteyner_no1"];
            } else {
                $kont_no = $item["konteyner_no"];
            }

            $depo_bedeli = number_format($depo_bedeli, 2);
            $tasima_bedeli = number_format($tasima_bedeli, 2);

            if ($item["bos_dolu"] == "Dolu") {
                $arr = [
                    'giris_tarihi' => $giris_tarihi,
                    'cikis_tarihi' => $cikis_tarihi,
                    'siparis_tarihi' => $tarih,
                    'konteyner_no' => $kont_no,
                    'cari' => $cari["cari_adi"],
                    'ucret' => $tasima_bedeli,
                    'hizmet_turu' => 'Taşıma Hizmeti',
                    'beyanname_no' => $item["beyanname_no"],
                    'epro_ref' => $item["epro_ref"],
                    'referans_no' => $item["referans_no"],
                    'id' => $id,
                    'is_emri_id' => $item["is_emri_id"]
                ];
                array_push($gidecek_arr, $arr);
            }
        }
    }

    $now_date = date("Y-m-d");
    $acente_konteyner = DBD::all_data("
SELECT
       akc.*,
       akg.tarih as giris_tarihi,
       COUNT(akt.id) as konteyner_sayisi,
       MIN(akt.bildirim_tarihi) as bildirim_tarihi,
       MAX(akc.tarih) as cikis_tarihi,
       akg.konteyner_tipi as konteyner_tipi,
       act.gunluk_ucret,
       act.depo_ucreti,
       act.free_time
FROM 
     acente_konteyner_cikis as akc
INNER JOIN acente_konteyner_giris as akg on akg.id=akc.konteyner_id AND akg.status!=0
INNER JOIN acente_konteyner_tanim as akt on akt.id=akg.konteyner_id
INNER JOIN acente_cari_tanimi as act on act.cari_id=akt.cari_id AND act.konteyner_tipi=akt.konteyner_tipi
WHERE akc.status=1 AND akc.cari_key='$cari_key' AND akc.acente_kesildi=1 AND akc.tarih < '$now_date 23:59:59' GROUP BY akt.cari_id,akg.konteyner_tipi");

    foreach ($acente_konteyner as $item) {
        $arr = [
            'giris_tarihi' => date("d/m/Y", strtotime($item["giris_tarihi"])),
            'cikis_tarihi' => date("d/m/Y", strtotime($item["cikis_tarihi"])),
            'siparis_tarihi' => date("d/m/Y", strtotime($item["bildirim_tarihi"])),
            'konteyner_no' => $item["konteyner_sayisi"] . "X" . $item["konteyner_tipi"],
            'cari' => $item["acente_adi"],
            'ucret' => number_format($item["depo_ucreti"], 2), // BURAYA GERÇEK ÜCRET BASILACAK
            'hizmet_turu' => "ACENTE HİZMETİ",
            'beyanname_no' => "",
            'epro_ref' => "",
            'referans_no' => $item["referans_no"],
            'id' => "",
            'is_emri_id' => ""
        ];
        array_push($gidecek_arr, $arr);
    }

    $kesilecek_ardiye = DBD::all_data("
SELECT
       akc.*,
       akg.tarih as giris_tarihi,
       COUNT(akt.id) as konteyner_sayisi,
       MIN(akt.bildirim_tarihi) as bildirim_tarihi,
       MAX(akc.tarih) as cikis_tarihi,
       akg.konteyner_tipi as konteyner_tipi,
       act.gunluk_ucret,
       act.depo_ucreti,
       act.free_time,
       SUM(
        CASE 
            WHEN DATEDIFF(akc.tarih, akg.tarih) > act.free_time THEN
                DATEDIFF(akc.tarih, akg.tarih) - act.free_time
            ELSE 
                0
        END
    ) AS toplam_ardiye_gunu
FROM 
     acente_konteyner_cikis as akc
INNER JOIN acente_konteyner_giris as akg on akg.id=akc.konteyner_id AND akg.status!=0
INNER JOIN acente_konteyner_tanim as akt on akt.id=akg.konteyner_id
INNER JOIN acente_cari_tanimi as act on act.cari_id=akt.cari_id AND act.konteyner_tipi=akt.konteyner_tipi
WHERE akc.status=1 AND akc.ardiye_kesildi=1 AND akc.cari_key='$cari_key' GROUP BY akt.cari_id,akg.konteyner_tipi");

    foreach ($kesilecek_ardiye as $item) {
        $ucret = floatval($item["gunluk_ucret"]) * floatval($item["toplam_ardiye_gunu"]);
        if ($item["toplam_ardiye_gunu"] > 0) {
            $arr = [
                'giris_tarihi' => date("d/m/Y", strtotime($item["giris_tarihi"])),
                'cikis_tarihi' => date("d/m/Y", strtotime($item["cikis_tarihi"])),
                'siparis_tarihi' => date("d/m/Y", strtotime($item["bildirim_tarihi"])),
                'konteyner_no' => $item["konteyner_sayisi"] . "X" . $item["konteyner_tipi"],
                'cari' => $item["acente_adi"],
                'ucret' => number_format($ucret, 2), // BURAYA GERÇEK ÜCRET BASILACAK
                'hizmet_turu' => "ARDİYE ÜCRETİ",
                'beyanname_no' => "",
                'epro_ref' => "",
                'referans_no' => $item["referans_no"],
                'id' => "",
                'is_emri_id' => ""
            ];
            array_push($gidecek_arr, $arr);
        }
    }

    $estimate_islemleri = DBD::all_data("
SELECT
       SUM(keu.islem_ucreti) as toplam_ucret,
       akc.konteyner_no,
       akg.tarih as giris_tarihi,
       akc.tarih as cikis_tarihi,
       ke.acente_adi,
       ke.id
FROM
     konteyner_estimate as ke
INNER JOIN konteyner_estimate_urunler as keu on keu.estimate_id=ke.id
INNER JOIN acente_konteyner_cikis as akc on akc.konteyner_id=ke.konteyner_id
INNER JOIN acente_konteyner_giris as akg on akg.id=akc.konteyner_id
WHERE ke.status=1 AND akc.estimate_kesildi=1 AND keu.status=1 AND ke.cari_key='$cari_key' GROUP BY ke.id
");
    if ($estimate_islemleri > 0) {
        foreach ($estimate_islemleri as $item) {
            $arr = [
                'giris_tarihi' => date("d/m/Y", strtotime($item["giris_tarihi"])),
                'cikis_tarihi' => date("d/m/Y", strtotime($item["cikis_tarihi"])),
                'siparis_tarihi' => date("d/m/Y", strtotime($item["giris_tarihi"])),
                'konteyner_no' => $item["konteyner_no"],
                'cari' => $item["acente_adi"],
                'ucret' => number_format($item["toplam_ucret"], 2), // BURAYA GERÇEK ÜCRET BASILACAK
                'hizmet_turu' => "ESTİMATE İŞLEMİ",
                'beyanname_no' => "",
                'epro_ref' => "",
                'referans_no' => "",
                'id' => $item["id"],
                'is_emri_id' => ""
            ];
            array_push($gidecek_arr, $arr);
        }
    }
    $ek_hizmetler = DBD::all_data("
SELECT
       SUM(aht.hizmet_fiyat) as toplam_fiyat,
       akg.tarih as giris_tarihi,
       akc.tarih as cikis_tarihi,
       akc.acente_adi,
       keh.id,
       akc.konteyner_no
FROM 
     konteyner_ek_hizmet as keh
INNER JOIN acente_konteyner_giris as akg on akg.id=keh.konteyner_id
INNER JOIN acente_hizmet_tanimlari as aht on aht.id=keh.ek_hizmet_id
INNER JOIN acente_konteyner_cikis as akc on akc.konteyner_id=akg.id
WHERE keh.status=1 AND akc.ek_hizmet_kesildi=1 AND keh.cari_key='$cari_key' GROUP BY keh.konteyner_id
");
    if ($ek_hizmetler > 0) {
        foreach ($ek_hizmetler as $item) {
            $arr = [
                'giris_tarihi' => date("d/m/Y", strtotime($item["giris_tarihi"])),
                'cikis_tarihi' => date("d/m/Y", strtotime($item["cikis_tarihi"])),
                'siparis_tarihi' => date("d/m/Y", strtotime($item["giris_tarihi"])),
                'konteyner_no' => $item["konteyner_no"],
                'cari' => $item["acente_adi"],
                'ucret' => number_format($item["toplam_fiyat"], 2), // BURAYA GERÇEK ÜCRET BASILACAK
                'hizmet_turu' => "ESTİMATE EK HİZMET",
                'beyanname_no' => "",
                'epro_ref' => "",
                'referans_no' => "",
                'id' => $item["id"],
                'is_emri_id' => ""
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
if ($islem == "cariye_ait_irsaliyeler_getir_sql") {
    $cari_id = $_GET["cari_id"];
    $gelmesi_beklenen_faturalar = DBD::all_data("
SELECT 
       iem.cari_id,
       iem.id as is_emri_id,
       iem.depo_bedeli,
       iem.tasima_bedeli,
       kc.cikis_tarihi,
       kg.giris_tarihi,
       iem.siparis_tarihi,
       kg.konteyner_no,
       kg.konteyner_no1,
       kg.prim_yazilsin,
       iem.referans_no,
       kc.id as konteyner_cikisid,
       iem.beyanname_no,
       iem.tipi,
       kc.bos_dolu,
       iem.epro_ref
FROM
     konteyner_cikis AS kc
INNER JOIN konteyner_giris as kg on kg.id=kc.konteyner_id
INNER JOIN is_emri_main AS iem on iem.id=kg.is_emri_id
WHERE kc.status=1 AND kc.cari_key='$cari_key'  AND iem.cari_id='$cari_id' AND  iem.depo_bedeli!=0 AND kc.depo_kesildi=1 AND iem.status=1
");

    $gidecek_arr = [];
    if ($gelmesi_beklenen_faturalar > 0) {
        foreach ($gelmesi_beklenen_faturalar as $item) {
            $cari_id = $item["cari_id"];
            $tarih = $item["siparis_tarihi"];
            $depo_bedeli = $item["depo_bedeli"];
            $tasima_bedeli = $item["tasima_bedeli"];
            $id = $item["konteyner_cikisid"];
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


            $kont_no = "";
            if ($item["prim_yazilsin"] == 0) {
                $kont_no = $item["konteyner_no1"];
            } else {
                $kont_no = $item["konteyner_no"];
            }

            $depo_bedeli = number_format($depo_bedeli, 2);
            $tasima_bedeli = number_format($tasima_bedeli, 2);

            if ($item["tipi"] == "İHRACAT" && $item["bos_dolu"] == "Dolu") {
                $arr = [
                    'giris_tarihi' => $giris_tarihi,
                    'cikis_tarihi' => $cikis_tarihi,
                    'siparis_tarihi' => $tarih,
                    'konteyner_no' => $kont_no,
                    'cari' => $cari["cari_adi"],
                    'ucret' => $depo_bedeli,
                    'hizmet_turu' => 'Depo Hizmeti',
                    'beyanname_no' => $item["beyanname_no"],
                    'referans_no' => $item["referans_no"],
                    'epro_ref' => $item["epro_ref"],
                    'id' => $id,
                    'is_emri_id' => $item["is_emri_id"]
                ];
                array_push($gidecek_arr, $arr);
            } else if ($item["tipi"] == "İTHALAT" && $item["bos_dolu"] == "Boş") {
                $arr = [
                    'giris_tarihi' => $giris_tarihi,
                    'cikis_tarihi' => $cikis_tarihi,
                    'siparis_tarihi' => $tarih,
                    'konteyner_no' => $kont_no,
                    'cari' => $cari["cari_adi"],
                    'ucret' => $depo_bedeli,
                    'hizmet_turu' => 'Depo Hizmeti',
                    'beyanname_no' => $item["beyanname_no"],
                    'referans_no' => $item["referans_no"],
                    'epro_ref' => $item["epro_ref"],
                    'id' => $id,
                    'is_emri_id' => $item["is_emri_id"]
                ];
                array_push($gidecek_arr, $arr);
            }


        }
    }
    $gelmesi_beklenen_faturalar = DBD::all_data("
SELECT 
       iem.cari_id,
       iem.id as is_emri_id,
       iem.depo_bedeli,
       iem.tasima_bedeli,
       kc.cikis_tarihi,
       kg.giris_tarihi,
       kc.bos_dolu,
       iem.siparis_tarihi,
       kg.konteyner_no,
       kg.konteyner_no1,
       kg.prim_yazilsin,
       iem.referans_no,
       kc.id as konteyner_cikisid,
       iem.beyanname_no,
       iem.tipi,
       iem.epro_ref
FROM
     konteyner_cikis AS kc
INNER JOIN konteyner_giris as kg on kg.id=kc.konteyner_id
INNER JOIN is_emri_main AS iem on iem.id=kg.is_emri_id
WHERE kc.status=1 AND kc.cari_key='$cari_key' AND iem.cari_id='$cari_id' AND iem.tasima_bedeli!=0 AND kc.tasima_kesildi=1  AND iem.status=1
");
    if ($gelmesi_beklenen_faturalar > 0) {
        foreach ($gelmesi_beklenen_faturalar as $item) {
            $cari_id = $item["cari_id"];
            $tarih = $item["siparis_tarihi"];
            $depo_bedeli = $item["depo_bedeli"];
            $tasima_bedeli = $item["tasima_bedeli"];
            $id = $item["konteyner_cikisid"];
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

            $kont_no = "";
            if ($item["prim_yazilsin"] == 0) {
                $kont_no = $item["konteyner_no1"];
            } else {
                $kont_no = $item["konteyner_no"];
            }

            $depo_bedeli = number_format($depo_bedeli, 2);
            $tasima_bedeli = number_format($tasima_bedeli, 2);

            if ($item["bos_dolu"] == "Dolu") {
                $arr = [
                    'giris_tarihi' => $giris_tarihi,
                    'cikis_tarihi' => $cikis_tarihi,
                    'siparis_tarihi' => $tarih,
                    'konteyner_no' => $kont_no,
                    'cari' => $cari["cari_adi"],
                    'ucret' => $tasima_bedeli,
                    'hizmet_turu' => 'Taşıma Hizmeti',
                    'beyanname_no' => $item["beyanname_no"],
                    'epro_ref' => $item["epro_ref"],
                    'referans_no' => $item["referans_no"],
                    'id' => $id,
                    'is_emri_id' => $item["is_emri_id"]
                ];
                array_push($gidecek_arr, $arr);
            }
        }
    }


    /// BURADAN SONRA


    $now_date = date("Y-m-d");
    $acente_konteyner = DBD::all_data("
SELECT
       akc.*,
       akg.tarih as giris_tarihi,
       COUNT(akt.id) as konteyner_sayisi,
       GROUP_CONCAT(akc.id) as konteyner_ids,
       MIN(akt.bildirim_tarihi) as bildirim_tarihi,
       MAX(akc.tarih) as cikis_tarihi,
       akg.konteyner_tipi as konteyner_tipi,
       act.gunluk_ucret,
       act.depo_ucreti,
       act.free_time
FROM 
     acente_konteyner_cikis as akc
INNER JOIN acente_konteyner_giris as akg on akg.id=akc.konteyner_id AND akg.status!=0
INNER JOIN acente_konteyner_tanim as akt on akt.id=akg.konteyner_id
INNER JOIN acente_cari_tanimi as act on act.cari_id=akt.cari_id AND act.konteyner_tipi=akt.konteyner_tipi
WHERE akc.status=1 AND akc.cari_key='$cari_key' AND act.cari_id='$cari_id' AND akc.tarih < '$now_date 23:59:59' GROUP BY akt.cari_id,akg.konteyner_tipi");

    foreach ($acente_konteyner as $item) {
        $arr = [
            'giris_tarihi' => date("d/m/Y", strtotime($item["giris_tarihi"])),
            'cikis_tarihi' => date("d/m/Y", strtotime($item["cikis_tarihi"])),
            'siparis_tarihi' => date("d/m/Y", strtotime($item["bildirim_tarihi"])),
            'konteyner_no' => $item["konteyner_sayisi"] . "X" . $item["konteyner_tipi"],
            'cari' => $item["acente_adi"],
            'ucret' => number_format($item["depo_ucreti"], 2), // BURAYA GERÇEK ÜCRET BASILACAK
            'hizmet_turu' => "ACENTE HİZMETİ",
            'beyanname_no' => "",
            'epro_ref' => "",
            'referans_no' => $item["referans_no"],
            'id' => $item["konteyner_ids"],
            'is_emri_id' => ""
        ];
        array_push($gidecek_arr, $arr);
    }

    $kesilecek_ardiye = DBD::all_data("
SELECT
       akc.*,
       akg.tarih as giris_tarihi,
       COUNT(akt.id) as konteyner_sayisi,
       MIN(akt.bildirim_tarihi) as bildirim_tarihi,
       MAX(akc.tarih) as cikis_tarihi,
       GROUP_CONCAT(akc.id) as konteyner_ids,
       akg.konteyner_tipi as konteyner_tipi,
       act.gunluk_ucret,
       act.depo_ucreti,
       act.free_time,
       SUM(
        CASE 
            WHEN DATEDIFF(akc.tarih, akg.tarih) > act.free_time THEN
                DATEDIFF(akc.tarih, akg.tarih) - act.free_time
            ELSE 
                0
        END
    ) AS toplam_ardiye_gunu
FROM 
     acente_konteyner_cikis as akc
INNER JOIN acente_konteyner_giris as akg on akg.id=akc.konteyner_id AND akg.status!=0
INNER JOIN acente_konteyner_tanim as akt on akt.id=akg.konteyner_id
INNER JOIN acente_cari_tanimi as act on act.cari_id=akt.cari_id AND act.konteyner_tipi=akt.konteyner_tipi
WHERE akc.status=1 AND akc.cari_key='$cari_key' AND act.cari_id='$cari_id' GROUP BY akt.cari_id,akg.konteyner_tipi");

    foreach ($kesilecek_ardiye as $item) {
        $ucret = floatval($item["gunluk_ucret"]) * floatval($item["toplam_ardiye_gunu"]);
        if ($item["toplam_ardiye_gunu"] > 0) {
            $arr = [
                'giris_tarihi' => date("d/m/Y", strtotime($item["giris_tarihi"])),
                'cikis_tarihi' => date("d/m/Y", strtotime($item["cikis_tarihi"])),
                'siparis_tarihi' => date("d/m/Y", strtotime($item["bildirim_tarihi"])),
                'konteyner_no' => $item["konteyner_sayisi"] . "X" . $item["konteyner_tipi"],
                'cari' => $item["acente_adi"],
                'ucret' => number_format($ucret, 2), // BURAYA GERÇEK ÜCRET BASILACAK
                'hizmet_turu' => "ARDİYE ÜCRETİ",
                'beyanname_no' => "",
                'epro_ref' => "",
                'referans_no' => $item["referans_no"],
                'id' => $item["konteyner_ids"],
                'is_emri_id' => ""
            ];
            array_push($gidecek_arr, $arr);
        }
    }

    $estimate_islemleri = DBD::all_data("
SELECT
       SUM(keu.islem_ucreti) as toplam_ucret,
       akc.konteyner_no,
       akg.tarih as giris_tarihi,
       akc.tarih as cikis_tarihi,
       ke.acente_adi,
       ke.id
FROM
     konteyner_estimate as ke
INNER JOIN konteyner_estimate_urunler as keu on keu.estimate_id=ke.id
INNER JOIN acente_konteyner_cikis as akc on akc.konteyner_id=ke.konteyner_id
INNER JOIN acente_konteyner_giris as akg on akg.id=akc.konteyner_id
INNER JOIN acente_konteyner_tanim as akt on akt.id=akg.konteyner_id
WHERE ke.status=1 AND keu.status=1 AND ke.cari_key='$cari_key' AND akt.cari_id='$cari_id' GROUP BY ke.id
");
    if ($estimate_islemleri > 0) {
        foreach ($estimate_islemleri as $item) {
            $arr = [
                'giris_tarihi' => date("d/m/Y", strtotime($item["giris_tarihi"])),
                'cikis_tarihi' => date("d/m/Y", strtotime($item["cikis_tarihi"])),
                'siparis_tarihi' => date("d/m/Y", strtotime($item["giris_tarihi"])),
                'konteyner_no' => $item["konteyner_no"],
                'cari' => $item["acente_adi"],
                'ucret' => number_format($item["toplam_ucret"], 2), // BURAYA GERÇEK ÜCRET BASILACAK
                'hizmet_turu' => "ESTİMATE İŞLEMİ",
                'beyanname_no' => "",
                'epro_ref' => "",
                'referans_no' => "",
                'id' => $item["id"],
                'is_emri_id' => ""
            ];
            array_push($gidecek_arr, $arr);
        }
    }
    $ek_hizmetler = DBD::all_data("
SELECT
       SUM(aht.hizmet_fiyat) as toplam_fiyat,
       akg.tarih as giris_tarihi,
       akc.tarih as cikis_tarihi,
       akc.acente_adi,
       keh.id,
       akc.konteyner_no
FROM 
     konteyner_ek_hizmet as keh
INNER JOIN acente_konteyner_giris as akg on akg.id=keh.konteyner_id
INNER JOIN acente_hizmet_tanimlari as aht on aht.id=keh.ek_hizmet_id
INNER JOIN acente_konteyner_cikis as akc on akc.konteyner_id=akg.id
INNER JOIN acente_konteyner_tanim as akt on akt.id=akg.konteyner_id
WHERE keh.status=1 AND keh.cari_key='$cari_key' AND akt.cari_id='$cari_id' GROUP BY keh.konteyner_id
");
    if ($ek_hizmetler > 0) {
        foreach ($ek_hizmetler as $item) {
            $arr = [
                'giris_tarihi' => date("d/m/Y", strtotime($item["giris_tarihi"])),
                'cikis_tarihi' => date("d/m/Y", strtotime($item["cikis_tarihi"])),
                'siparis_tarihi' => date("d/m/Y", strtotime($item["giris_tarihi"])),
                'konteyner_no' => $item["konteyner_no"],
                'cari' => $item["acente_adi"],
                'ucret' => number_format($item["toplam_fiyat"], 2), // BURAYA GERÇEK ÜCRET BASILACAK
                'hizmet_turu' => "ESTİMATE EK HİZMET",
                'beyanname_no' => "",
                'epro_ref' => "",
                'referans_no' => "",
                'id' => $item["id"],
                'is_emri_id' => ""
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
if ($islem == "aktarma_icin_satis_faturasi_olustur_sql") {
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $satis_faturasi = DBD::insert("satis_default", $_POST);
    if ($satis_faturasi) {
        echo 2;
    } else {
        $son_eklenen = DBD::single_query("SELECT id FROM satis_default where  cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        echo 'id:' . $son_eklenen["id"];
    }
}
if ($islem == "secilen_irsaliyeyi_faturalastir") {
    $genel_toplam = 0;
    $ara_toplam = 0;
    $kdv_toplam = 0;
    $tevkifat_toplam = 0;
    $iskonto_toplam = 0;
    $satis_defaultid = $_POST["satis_id"];
    if (isset($_POST["select_irsaliye"])) {
        foreach ($_POST["select_irsaliye"] as $item) {
            $hizmet_turu = $item["hizmet_turu"];
            $id = $item["id"];
            $konteyner_irsaliye_bilgileri = DBD::single_query("
SELECT 
       iem.cari_id,
       iem.id as is_emri_id,
       iem.depo_bedeli,
       iem.tasima_bedeli,
       kc.cikis_tarihi,
       kg.giris_tarihi,
       iem.siparis_tarihi,
       kg.konteyner_no,
       iem.referans_no,
       iem.birim_id,
       kc.id as konteyner_cikisid,
       iem.beyanname_no,
       iem.birim_id,
       iem.epro_ref,
       iem.tipi
FROM
     konteyner_cikis AS kc
INNER JOIN konteyner_giris as kg on kg.id=kc.konteyner_id
INNER JOIN is_emri_main AS iem on iem.id=kg.is_emri_id
WHERE kc.status=1 AND kc.cari_key='$cari_key' AND kc.id='$id'
");

            $stok_id = "";
            $fiyat = 0;
            $tipi = "";
            if ($hizmet_turu == "Depo Hizmeti") {
                $depo_stogu = DB::single_query("SELECT id FROM stok WHERE status=1 AND stok_kodu='DEPO.001'");
                $stok_id = $depo_stogu["id"];
                $fiyat = $konteyner_irsaliye_bilgileri["depo_bedeli"];
                $tipi = $konteyner_irsaliye_bilgileri["tipi"];
            } else if ($hizmet_turu == "ESTİMATE İŞLEMİ") {
                $depo_stogu = DB::single_query("SELECT id FROM stok WHERE status=1 AND stok_adi='KONTEYNER TAMİR BEDELİ'");
                $stok_id = $depo_stogu["id"];
                $fiyat = $item["fiyat"];
            } else if ($hizmet_turu == "ACENTE HİZMETİ") {
                $depo_stogu = DB::single_query("SELECT id FROM stok WHERE status=1 AND stok_kodu='DEPO.001'");
                $stok_id = $depo_stogu["id"];
                $fiyat = $item["fiyat"];

                $ids = $item["id"];
                $explode = explode(",", $ids);
                $i = 0;
                foreach ($explode as $item2) {
                    $dusur_arr1 = [
                        'acente_kesildi' => 2
                    ];
                    $acente = DBD::update("acente_konteyner_cikis", "id", $item2, $dusur_arr1);
                    $i++;
                }

            } else if ($hizmet_turu == "ARDİYE ÜCRETİ") {
                $depo_stogu = DB::single_query("SELECT id FROM stok WHERE status=1 AND stok_adi='ARDİYE BEDELİ'");
                $stok_id = $depo_stogu["id"];
                $fiyat = $item["fiyat"];

                $ids = $item["id"];
                $explode = explode(",", $ids);
                $i = 0;
                foreach ($explode as $item2) {
                    $dusur_arr1 = [
                        'ardiye_kesildi' => 2
                    ];
                    $acente = DBD::update("acente_konteyner_cikis", "id", $item2, $dusur_arr1);
                    $i++;
                }
            } else if ($hizmet_turu == "ESTİMATE EK HİZMET") {
                $depo_stogu = DB::single_query("SELECT id FROM stok WHERE status=1 AND stok_adi='DEPO EK HİZMETLERİ'");
                $stok_id = $depo_stogu["id"];
                $fiyat = $item["fiyat"];
            } else {
                $siparis_id = $konteyner_irsaliye_bilgileri["is_emri_id"];
                $ihracat_is_emri_urunu = DBD::single_query("SELECT hizmet_id FROM is_emri_urunler WHERE status=1 AND is_emri_id='$siparis_id'");
                $stok_id = $ihracat_is_emri_urunu["hizmet_id"];
                $tipi = $konteyner_irsaliye_bilgileri["tipi"];
                $fiyat = $konteyner_irsaliye_bilgileri["tasima_bedeli"];
            }
            $arac_id = $konteyner_irsaliye_bilgileri["plaka_id"];
            $stok_bilgileri = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");
            $kdv_yuzde = floatval($stok_bilgileri["kdv_orani"]) / 100;
            $kdv_tutar = floatval($fiyat) * floatval($kdv_yuzde);
            $yeni_tutar = $kdv_tutar + $fiyat;

            $tevkifat_orani = floatval($stok_bilgileri["tevkifat_yuzde"]) / 100;

            $arac_ozmal_mi = DB::single_query("SELECT arac_grubu FROM arac_kartlari WHERE status=1 AND id='$arac_id'");
            $satis_urun = DBD::single_query("SELECT * FROM satis_urunler WHERE status=1 AND cari_key='$cari_key' AND satis_defaultid='$satis_defaultid' AND stok_id='$stok_id' AND birim_fiyat='$fiyat'");
            if ($satis_urun > 0) {
                $miktar_dizi = 1 + floatval($satis_urun["miktar"]);
                $fiyat_dizi = floatval($fiyat) + floatval($satis_urun["toplam_tutar"]);

                $tekrar_ara_toplam = $miktar_dizi * floatval($fiyat);
                $tekrar_kdv_tutar = $tekrar_ara_toplam * floatval($kdv_yuzde);

                $tevkifat_tutari = 0;

                $tekrar_yeni_tutar = $tekrar_ara_toplam + $tekrar_kdv_tutar;

                if ($arac_ozmal_mi["arac_grubu"] == "Öz Mal") {
                    $tevkifat_tutari = $tekrar_kdv_tutar * $tevkifat_orani;
                    $tekrar_yeni_tutar = $tekrar_yeni_tutar - $tevkifat_tutari;
                }

                if ($hizmet_turu != "Depo Hizmeti" || $hizmet_turu != "Taşıma Hizmeti") {
                    $arr = [
                        'satis_defaultid' => $satis_defaultid,
                        'stok_id' => $stok_id,
                        'birim_id' => $stok_bilgileri["birim"],
                        'miktar' => $miktar_dizi,
                        'birim_fiyat' => $fiyat,
                        'kdv_orani' => $stok_bilgileri["kdv_orani"],
                        'iskonto' => 0,
                        'tevkifat_kodu' => "",
                        'toplam_tutar' => $tekrar_yeni_tutar,
                        'insert_userid' => $_SESSION["user_id"],
                        'insert_datetime' => date("Y-m-d H:i:s"),
                        'cari_key' => $cari_key,
                        'sube_key' => $sube_key,
                        'tevkifat_tutari' => 0,
                        'tevkifat_yuzde' => 0,
                        'kdv_tutari' => $tekrar_kdv_tutar,
                        'iskonto_tutari' => 0
                    ];
                } else {
                    $arr = [
                        'satis_defaultid' => $satis_defaultid,
                        'stok_id' => $stok_id,
                        'birim_id' => $konteyner_irsaliye_bilgileri["birim_id"],
                        'miktar' => $miktar_dizi,
                        'birim_fiyat' => $fiyat,
                        'kdv_orani' => $stok_bilgileri["kdv_orani"],
                        'iskonto' => 0,
                        'tevkifat_kodu' => "",
                        'toplam_tutar' => $tekrar_yeni_tutar,
                        'insert_userid' => $_SESSION["user_id"],
                        'insert_datetime' => date("Y-m-d H:i:s"),
                        'cari_key' => $cari_key,
                        'sube_key' => $sube_key,
                        'tevkifat_tutari' => $tevkifat_tutari,
                        'tevkifat_yuzde' => $stok_bilgileri["tevkifat_yuzde"],
                        'kdv_tutari' => $tekrar_kdv_tutar,
                        'iskonto_tutari' => 0
                    ];
                }
                $satis_fatura_urunleri = DBD::update("satis_urunler", "id", $satis_urun["id"], $arr);
                $dusur_arr1 = [];
                $irsaliyeden_dusur_arr123 = [];
                if ($hizmet_turu == "Depo Hizmeti") {
                    $irsaliyeden_dusur_arr123 = [
                        'depo_kesildi' => 2
                    ];
                } else if ($hizmet_turu == "ESTİMATE İŞLEMİ") {
                    $dusur_arr1 = [
                        'estimate_kesildi' => 2
                    ];
                } else if ($hizmet_turu == "ESTİMATE EK HİZMET") {
                    $dusur_arr1 = [
                        'ek_hizmet_kesildi' => 2
                    ];
                } else if ($hizmet_turu == "ACENTE HİZMETİ") {
                    $dusur_arr1 = [
                        'acente_kesildi' => 2
                    ];
                } else if ($hizmet_turu == "ARDİYE ÜCRETİ") {
                    $dusur_arr1 = [
                        'ardiye_kesildi' => 2
                    ];
                } else {
                    $irsaliyeden_dusur_arr123 = [
                        'tasima_kesildi' => 2
                    ];
                }


                $acente = DBD::update("acente_konteyner_cikis", "konteyner_no", $item["konteyner_no"], $dusur_arr1);
                $irsaliye_urunler = DBD::update("konteyner_cikis", "id", $konteyner_irsaliye_bilgileri["konteyner_cikisid"], $irsaliyeden_dusur_arr123);

                $ids = array_column($_POST["select_irsaliye"], "id");
                $implode_ids = implode(",", $ids);
                if ($hizmet_turu == "Depo Hizmeti") {
                    $arr2 = [
                        'depo_ids' => $implode_ids
                    ];
                } else if ($hizmet_turu == "ESTİMATE İŞLEMİ") {
                    $arr2 = [
                        'estimate_ids' => $implode_ids
                    ];
                } else if ($hizmet_turu == "ESTİMATE EK HİZMET") {
                    $arr2 = [
                        'ek_hizmet_ids' => $implode_ids
                    ];
                } else if ($hizmet_turu == "ACENTE HİZMETİ") {
                    $single = DBD::single_query("SELECT acente_ids FROM satis_default WHERE id='$satis_defaultid'");
                    $arr2 = [
                        'acente_ids' => $item["id"] . "," . $single["acente_ids"]
                    ];
                } else if ($hizmet_turu == "ARDİYE ÜCRETİ") {
                    $single = DBD::single_query("SELECT ardiye_ids FROM satis_default WHERE id='$satis_defaultid'");
                    $arr2 = [
                        'ardiye_ids' => $item["id"] . "," . $single["ardiye_ids"]
                    ];
                } else {
                    $arr2 = [
                        'irsaliye_ids' => $implode_ids
                    ];
                }
                $satis_default_guncelle = DBD::update("satis_default", "id", $satis_defaultid, $arr2);
            } else {

                $tevkifat_tutari = 0;
                if ($arac_ozmal_mi["arac_grubu"] == "Öz Mal") {
                    $tevkifat_tutari = $kdv_tutar * $tevkifat_orani;
                    $yeni_tutar = $yeni_tutar - $tevkifat_tutari;
                }
                if ($hizmet_turu != "Taşıma Hizmeti" || $hizmet_turu != "Depo Hizmeti") {
                    $arr = [
                        'satis_defaultid' => $satis_defaultid,
                        'stok_id' => $stok_id,
                        'birim_id' => $stok_bilgileri["birim"],
                        'miktar' => 1,
                        'birim_fiyat' => $fiyat,
                        'kdv_orani' => $stok_bilgileri["kdv_orani"],
                        'iskonto' => 0,
                        'tevkifat_kodu' => "",
                        'toplam_tutar' => $yeni_tutar,
                        'insert_userid' => $_SESSION["user_id"],
                        'insert_datetime' => date("Y-m-d H:i:s"),
                        'cari_key' => $cari_key,
                        'sube_key' => $sube_key,
                        'tevkifat_tutari' => "0",
                        'tevkifat_yuzde' => "0",
                        'kdv_tutari' => $kdv_tutar,
                        'iskonto_tutari' => 0
                    ];
                } else {
                    $arr = [
                        'satis_defaultid' => $satis_defaultid,
                        'stok_id' => $stok_id,
                        'birim_id' => $konteyner_irsaliye_bilgileri["birim_id"],
                        'miktar' => 1,
                        'birim_fiyat' => $fiyat,
                        'kdv_orani' => $stok_bilgileri["kdv_orani"],
                        'iskonto' => 0,
                        'tevkifat_kodu' => "",
                        'toplam_tutar' => $yeni_tutar,
                        'insert_userid' => $_SESSION["user_id"],
                        'insert_datetime' => date("Y-m-d H:i:s"),
                        'cari_key' => $cari_key,
                        'sube_key' => $sube_key,
                        'tevkifat_tutari' => $tevkifat_tutari,
                        'tevkifat_yuzde' => $stok_bilgileri["tevkifat_yuzde"],
                        'kdv_tutari' => $kdv_tutar,
                        'iskonto_tutari' => 0
                    ];
                }
                $satis_fatura_urunleri = DBD::insert("satis_urunler", $arr);
                $irsaliyeden_dusur_arr123 = [];
                $dusur_arr1 = [];

                if ($hizmet_turu == "Depo Hizmeti") {
                    $irsaliyeden_dusur_arr123 = [
                        'depo_kesildi' => 2
                    ];
                } else if ($hizmet_turu == "ESTİMATE İŞLEMİ") {
                    $dusur_arr1 = [
                        'estimate_kesildi' => 2
                    ];
                } else if ($hizmet_turu == "ESTİMATE EK HİZMET") {
                    $dusur_arr1 = [
                        'ek_hizmet_kesildi' => 2
                    ];
                } else if ($hizmet_turu == "ACENTE HİZMETİ") {
                    $dusur_arr1 = [
                        'acente_kesildi' => 2
                    ];
                } else if ($hizmet_turu == "ARDİYE ÜCRETİ") {
                    $dusur_arr1 = [
                        'ardiye_kesildi' => 2
                    ];
                } else {
                    $irsaliyeden_dusur_arr123 = [
                        'tasima_kesildi' => 2
                    ];
                }
                $acente = DBD::update("acente_konteyner_cikis", "konteyner_no", $item["konteyner_no"], $dusur_arr1);
                $irsaliye_urunler = DBD::update("konteyner_cikis", "id", $konteyner_irsaliye_bilgileri["konteyner_cikisid"], $irsaliyeden_dusur_arr123);

                $ids = array_column($_POST["select_irsaliye"], "id");
                $implode_ids = implode(",", $ids);
                if ($hizmet_turu == "Depo Hizmeti") {
                    $arr2 = [
                        'depo_ids' => $implode_ids
                    ];
                } else if ($hizmet_turu == "ESTİMATE İŞLEMİ") {
                    $arr2 = [
                        'estimate_ids' => $implode_ids
                    ];
                } else if ($hizmet_turu == "ESTİMATE EK HİZMET") {
                    $arr2 = [
                        'ek_hizmet_ids' => $implode_ids
                    ];
                } else if ($hizmet_turu == "ACENTE HİZMETİ") {
                    $single = DBD::single_query("SELECT acente_ids FROM satis_default WHERE id='$satis_defaultid'");
                    $arr2 = [
                        'acente_ids' => $item["id"] . "," . $single["acente_ids"]
                    ];
                } else if ($hizmet_turu == "ARDİYE ÜCRETİ") {
                    $single = DBD::single_query("SELECT ardiye_ids FROM satis_default WHERE id='$satis_defaultid'");
                    $arr2 = [
                        'ardiye_ids' => $item["id"] . "," . $single["ardiye_ids"]
                    ];
                } else {
                    $arr2 = [
                        'irsaliye_ids' => $implode_ids
                    ];
                }
                $satis_default_guncelle = DBD::update("satis_default", "id", $satis_defaultid, $arr2);
            }
        }
    }
    $faturadaki_urunler = DBD::all_data("
SELECT *
FROM
     satis_urunler
WHERE
      status=1
AND
      satis_defaultid='$satis_defaultid'  and cari_key='$cari_key'");
    if ($faturadaki_urunler > 0) {
        $gidecek_arr = [];
        foreach ($faturadaki_urunler as $urunler) {
            $stok_id = $urunler["stok_id"];
            $stok = DB::single_query("SELECT * FROM stok WHERE id='$stok_id'");
            $birim_id = $urunler["birim_id"];
            $birim = DB::single_query("SELECT * FROM birim WHERE status=1 AND id='$birim_id'");
            $arr = [
                'stok_kodu' => $stok["stok_kodu"],
                'stok_adi' => $stok["stok_adi"],
                'birim_adi' => $birim["birim_adi"],
                'miktar' => $urunler["miktar"],
                'birim_fiyat' => $urunler["birim_fiyat"],
                'kdv' => $urunler["kdv_orani"],
                'kdv_tutar' => $urunler["kdv_tutari"],
                'iskonto' => $urunler["iskonto"],
                'iskonto_tutari' => $urunler["iskonto_tutari"],
                'tevkifat_kodu' => $urunler["tevkifat_kodu"],
                'tevkifat_tutari' => $urunler["tevkifat_tutari"],
                'toplam_tutar' => $urunler["toplam_tutar"],
                'id' => $urunler["id"],
                'islem' => "<button class='btn btn-danger btn-sm satis_fat_eksilt' data-id='" . $urunler["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "faturadaki_urunun_bilgilerini_getir") {
    $id = $_GET["id"];
    $fatura_urun_bilgileri = DBD::single_query(
        "
SELECT 
       *
FROM 
     satis_urunler
WHERE 
      status=1 
AND 
      id='$id'"
    );
    if ($fatura_urun_bilgileri > 0) {
        $stok_id = $fatura_urun_bilgileri["stok_id"];
        $stok = DB::single_query("SELECT * FROM stok WHERE status=1 AND cari_key='$cari_key' AND stok_id='$stok_id'");
        $birim_id = $fatura_urun_bilgileri["birim_id"];
        $gidecek_arr = [
            'stok_adi' => $stok["stok_adi"],
            'stok_id' => $stok_id,
            'birim_id' => $birim_id,
            'miktar' => $fatura_urun_bilgileri["miktar"],
            'birim_fiyat' => $fatura_urun_bilgileri["birim_fiyat"],
            'kdv_orani' => $fatura_urun_bilgileri["kdv_orani"],
            'iskonto' => $fatura_urun_bilgileri["iskonto"],
            'tevkifat_kodu' => $fatura_urun_bilgileri["tevkifat_kodu"],
            'tevkifat_yuzde' => $fatura_urun_bilgileri["tevkifat_yuzde"],
            'tevkifat_tutar' => $fatura_urun_bilgileri["tevkifat_tutari"],
            'toplam_tutar' => $fatura_urun_bilgileri["toplam_tutar"]
        ];
        if (!empty($gidecek_arr)) {
            echo json_encode($gidecek_arr);
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "faturadaki_urunu_guncelle") {
    $id = $_POST["id"];
    $miktar_fark = $_POST["miktar_farki"];
    unset($_POST["miktar_farki"]);
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    if (isset($_POST["satis_defaultid"])) {
        $fatura_id = $_POST["satis_defaultid"];
        $fatura_bilgileri = DBD::single_query("SELECT * FROM satis_default WHERE status=1 AND id='$fatura_id'  and cari_key='$cari_key'");
        if ($fatura_bilgileri > 0) {

            unset($_POST["kdv_fark"]);
            unset($_POST["iskonto_fark"]);
            unset($_POST["tutar_fark"]);
            unset($_POST["tevkifat_fark"]);
            unset($_POST["ara_toplam_fark"]);
            $urunleri_guncelle = DBD::update("satis_urunler", "id", $id, $_POST);
            if ($urunleri_guncelle) {
                $faturadaki_urunler = DBD::all_data("
SELECT *
FROM
     satis_urunler
WHERE
      status=1
AND
      satis_defaultid='$fatura_id'  and cari_key='$cari_key'");
                if ($faturadaki_urunler > 0) {
                    $gidecek_arr = [];
                    foreach ($faturadaki_urunler as $urunler) {
                        $stok_id = $urunler["stok_id"];
                        $stok = DB::single_query("SELECT * FROM stok WHERE id='$stok_id'");
                        $birim_id = $urunler["birim_id"];
                        $birim = DB::single_query("SELECT * FROM birim WHERE status=1 AND id='$birim_id'");
                        $arr = [
                            'stok_kodu' => $stok["stok_kodu"],
                            'stok_adi' => $stok["stok_adi"],
                            'birim_adi' => $birim["birim_adi"],
                            'miktar' => $urunler["miktar"],
                            'birim_fiyat' => $urunler["birim_fiyat"],
                            'kdv' => $urunler["kdv_orani"],
                            'kdv_tutar' => $urunler["kdv_tutari"],
                            'iskonto' => $urunler["iskonto"],
                            'iskonto_tutari' => $urunler["iskonto_tutari"],
                            'tevkifat_kodu' => $urunler["tevkifat_kodu"],
                            'tevkifat_tutari' => $urunler["tevkifat_tutari"],
                            'toplam_tutar' => $urunler["toplam_tutar"],
                            'id' => $urunler["id"],
                            'islem' => "<button class='btn btn-danger btn-sm satis_fat_eksilt' data-id='" . $urunler["id"] . "'><i class='fa fa-trash'></i></button>"
                        ];
                        array_push($gidecek_arr, $arr);
                    }
                    if (!empty($gidecek_arr)) {
                        echo json_encode($gidecek_arr);
                    } else {
                        echo 2;
                    }
                } else {
                    echo 500;
                }
            } else {
                echo 500;
            }
        }
    }
}
if ($islem == "urunu_faturadan_cikart") {
    $id = $_POST["id"];
    $fatura_id = $_POST["fatura_id"];
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["status"] = 0;
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_detail"] = "Kullanıcı Faturayı Oluştururken Silmiştir";
    $urun_bilgileri = DBD::single_query("SELECT * FROM satis_urunler WHERE status=1 AND id='$id' and cari_key='$cari_key'");
    $fatura_bilgileri = DBD::single_query("SELECT * FROM satis_default WHERE status=1 AND id='$fatura_id'  and cari_key='$cari_key'");

    unset($_POST["fatura_turu"]);
    unset($_POST["fatura_id"]);
    $urunu_faturadan_cikart = DBD::update("satis_urunler", "id", $id, $_POST);
    if ($urunu_faturadan_cikart) {
        $faturadaki_urunler = DBD::all_data("
SELECT 
       *
FROM
     satis_urunler
WHERE
      status=1
AND
      satis_defaultid='$fatura_id'  and cari_key='$cari_key'");
        if ($faturadaki_urunler > 0) {
            $gidecek_arr = [];
            foreach ($faturadaki_urunler as $urunler) {
                $stok_id = $urunler["stok_id"];
                $birim_id = $urunler["birim_id"];
                $stok = DB::single_query("SELECT * FROM stok WHERE id='$stok_id'");
                $birim = DB::single_query("SELECT * FROM birim WHERE status=1 AND id='$birim_id'");
                $arr = [
                    'stok_kodu' => $stok["stok_kodu"],
                    'stok_adi' => $stok["stok_adi"],
                    'birim_adi' => $birim["birim_adi"],
                    'miktar' => $urunler["miktar"],
                    'birim_fiyat' => $urunler["birim_fiyat"],
                    'kdv' => $urunler["kdv_orani"],
                    'kdv_tutar' => $urunler["kdv_tutari"],
                    'iskonto' => $urunler["iskonto"],
                    'iskonto_tutari' => $urunler["iskonto_tutari"],
                    'tevkifat_kodu' => $urunler["tevkifat_kodu"],
                    'tevkifat_tutari' => $urunler["tevkifat_tutari"],
                    'toplam_tutar' => $urunler["toplam_tutar"],
                    'id' => $urunler["id"],
                    'islem' => "<button class='btn btn-danger btn-sm satis_fat_eksilt' data-id='" . $urunler["id"] . "'><i class='fa fa-trash'></i></button>"
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
    } else {
        echo 500;
    }
}
if ($islem == "faturayi_kaydet_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $faturayi_olustur = DBD::update("satis_default", "id", $_POST["id"], $_POST);
    if ($faturayi_olustur) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "faturayi_iptal_et_sql") {
    $id = $_POST["id"];
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    if (!isset($_POST["delete_detail"])) {
        $_POST["delete_detail"] = "Kullanıcı Faturadan Vazgeçmiştir";
    }

    $satis_default_bilgi = DBD::single_query("SELECT * FROM satis_default WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    $depo_ids = explode(",", $satis_default_bilgi["depo_ids"]);
    $tasima_ids = explode(",", $satis_default_bilgi["irsaliye_ids"]);
    $acente_ids = explode(",", $satis_default_bilgi["acente_ids"]);
    $ardiye_ids = explode(",", $satis_default_bilgi["ardiye_ids"]);
    $estimate_ids = explode(",", $satis_default_bilgi["estimate_ids"]);
    $ek_hizmet_ids = explode(",", $satis_default_bilgi["ek_hizmet_ids"]);
    $tipi = $satis_default_bilgi["tipi"];

    foreach ($depo_ids as $item) {
        $arr = [
            'depo_kesildi' => 1
        ];
        $guncelle = DBD::update("konteyner_cikis", "id", $item, $arr);
    }

    foreach ($acente_ids as $item) {
        $arr = [
            'acente_kesildi' => 1
        ];
        $guncelle = DBD::update("acente_konteyner_cikis", "id", $item, $arr);
    }

    foreach ($ek_hizmet_ids as $item) {
        $arr = [
            'ek_hizmet_kesildi' => 1
        ];
        $guncelle = DBD::update("acente_konteyner_cikis", "id", $item, $arr);
    }


    foreach ($ardiye_ids as $item) {
        $arr = [
            'ardiye_kesildi' => 1
        ];
        $guncelle = DBD::update("acente_konteyner_cikis", "id", $item, $arr);
    }
    foreach ($estimate_ids as $item) {
        $arr = [
            'estimate_kesildi' => 1
        ];
        $guncelle = DBD::update("acente_konteyner_cikis", "id", $item, $arr);
    }

    foreach ($tasima_ids as $item) {
        $arr = [
            'tasima_kesildi' => 1
        ];
        $guncelle = DBD::update("konteyner_cikis", "id", $item, $arr);
    }
    $sil = DBD::update("satis_default", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "kesilen_faturalari_getir_sql") {
    $sql = "
    SELECT * FROM satis_default 
WHERE status=1 and cari_key='$cari_key'";
    $faturalar = DBD::all_data($sql);
    if ($faturalar > 0) {
        $gidecek_arr = [];
        foreach ($faturalar as $item) {
            $depo_id = $item["depo_id"];
            $cari_id = $item["cari_id"];
            $fatura_turid = $item["fatura_turu"];
            $depo = DB::single_query("SELECT depo_adi FROM depolar WHERE id='$depo_id'");
            $cari = DB::single_query("SELECT cari_adi,cari_kodu FROM cari WHERE id='$cari_id'");
            $fatura_turu = DB::single_query("SELECT fatura_turu_adi FROM fatura_tur_tanim WHERE id='$fatura_turid'");
            $doviz_kuru = $item["doviz_kuru"];
            $mal_tutari = $doviz_kuru * $item["ara_toplam"];
            $kdv_tutari = $item["kdv_toplam"] * $doviz_kuru;
            $genel_toplam = $item["genel_toplam"] * $doviz_kuru;
            $fatura_tarihi = $item["fatura_tarihi"];
            if ($fatura_tarihi != "0000-00-00 00:00:00") {
                $fatura_tarihi = date("d/m/Y", strtotime($fatura_tarihi));
            }
            $mal_tutari = number_format($mal_tutari, 2);
            $kdv_tutari = number_format($kdv_tutari, 2);
            $genel_toplam = number_format($genel_toplam, 2);
            $doviz_kuru = number_format($doviz_kuru, 2);
            $ara_toplam = number_format($item["ara_toplam"], 2);
            $kdv_toplam = number_format($item["kdv_toplam"], 2);
            $genel_toplam = number_format($item["genel_toplam"], 2);

            $mal_tutari = str_replace(',', '.', str_replace('.', ',', $mal_tutari));
            $kdv_tutari = str_replace(',', '.', str_replace('.', ',', $kdv_tutari));
            $genel_toplam = str_replace(',', '.', str_replace('.', ',', $genel_toplam));
            $doviz_kuru = str_replace(',', '.', str_replace('.', ',', $doviz_kuru));
            $ara_toplam = str_replace(',', '.', str_replace('.', ',', $ara_toplam));
            $kdv_toplam = str_replace(',', '.', str_replace('.', ',', $kdv_toplam));
            $genel_toplam = str_replace(',', '.', str_replace('.', ',', $genel_toplam));

            $arr = [
                'fatura_no' => $item["fatura_no"],
                'fatura_turu' => $fatura_turu["fatura_turu_adi"],
                'fatura_tarihi' => $fatura_tarihi,
                'cari_kodu' => $cari["cari_kodu"],
                'cari_adi' => $cari["cari_adi"],
                'mal_tutari' => $mal_tutari,
                'kdv' => $kdv_tutari,
                'genel_toplam' => $genel_toplam,
                'doviz_tipi' => $item["doviz_tur"],
                'doviz_kuru' => $doviz_kuru,
                'doviz_mal_tutari' => $ara_toplam,
                'doviz_kdv' => $kdv_toplam,
                'doviz_genel_toplam' => $genel_toplam,
                'islem' => "<button class='btn btn-sm depo_satis_fat_guncelle_button' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm depo_satis_faturasini_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "satis_faturasi_ana_bilgilerini_getir_sql") {
    $id = $_GET["id"];
    $sql = "
    SELECT * FROM satis_default 
WHERE status=1 and cari_key='$cari_key' AND id='$id'";
    $item = DBD::single_query($sql);
    if ($item > 0) {
        $depo_id = $item["depo_id"];
        $cari_id = $item["cari_id"];
        $fatura_turid = $item["fatura_turu"];
        $depo = DB::single_query("SELECT depo_adi FROM depolar WHERE id='$depo_id'");

        $cari = DB::single_query("
SELECT
       c.cari_adi,c.cari_kodu,c.telefon,c.yetkili_adi1,c.yetkili_tel1,c.vergi_dairesi,c.vergi_no,cab.adres ,c.id
FROM
     cari as c
LEFT JOIN cari_adres_bilgileri as cab on cab.cari_id=c.id
WHERE c.id='$cari_id'
");
        $fatura_turu = DB::single_query("SELECT fatura_turu_adi FROM fatura_tur_tanim WHERE id='$fatura_turid'");
        $doviz_kuru = $item["doviz_kuru"];
        $mal_tutari = $doviz_kuru * $item["ara_toplam"];
        $kdv_tutari = $item["kdv_toplam"] * $doviz_kuru;
        $genel_toplam = $item["genel_toplam"] * $doviz_kuru;
        $fatura_tarihi = $item["fatura_tarihi"];
        if ($fatura_tarihi != "0000-00-00 00:00:00") {
            $fatura_tarihi = date("Y-m-d", strtotime($fatura_tarihi));
        }
        $irsaliye_tarihi = $item["irsaliye_tarihi"];
        if ($irsaliye_tarihi != "0000-00-00 00:00:00") {
            $irsaliye_tarihi = date("Y-m-d", strtotime($irsaliye_tarihi));
        }
        $vade_tarihi = $item["vade_tarihi"];
        if ($vade_tarihi != "0000-00-00 00:00:00") {
            $vade_tarihi = date("Y-m-d", strtotime($vade_tarihi));
        }
        $mal_tutari = number_format($mal_tutari, 2);
        $kdv_tutari = number_format($kdv_tutari, 2);
        $genel_toplam = number_format($genel_toplam, 2);
        $doviz_kuru = number_format($doviz_kuru, 2);
        $ara_toplam = number_format($item["ara_toplam"], 2);
        $kdv_toplam = number_format($item["kdv_toplam"], 2);
        $genel_toplam = number_format($item["genel_toplam"], 2);
        $arr = [
            'fatura_no' => $item["fatura_no"],
            'fatura_turu' => $item["fatura_turu"],
            'fatura_tipi' => $item["fatura_tipi"],
            'vade_tarihi' => $vade_tarihi,
            'irsaliye_no' => $item["irsaliye_no"],
            'irsaliye_tarihi' => $irsaliye_tarihi,
            'depo_id' => $item["depo_id"],
            'doviz_turu' => $item["doviz_tur"],
            'doviz_kuru' => $item["doviz_kuru"],
            'aciklama' => $item["aciklama"],
            'fatura_tarihi' => $fatura_tarihi,
            'cari_kodu' => $cari["cari_kodu"],
            'cari_adi' => $cari["cari_adi"],
            'cari_id' => $cari["id"],
            'telefon' => $cari["telefon"],
            'yetkili_adi' => $cari["yetkili_adi1"],
            'yetkili_tel' => $cari["yetkili_tel1"],
            'vergi_dairesi' => $cari["vergi_dairesi"],
            'vergi_no' => $cari["vergi_no"],
            'adres' => $cari["adres"],
            'mal_tutari' => $mal_tutari,
            'kdv' => $kdv_tutari,
            'genel_toplam' => $genel_toplam,
            'doviz_tipi' => $item["doviz_tur"],
            'doviz_mal_tutari' => $ara_toplam,
            'doviz_kdv' => $kdv_toplam,
            'doviz_genel_toplam' => $genel_toplam,
            'id' => $item["id"]
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
if ($islem == "satis_urunlerini_getir_sql") {
    $satis_defaultid = $_GET["id"];
    $faturadaki_urunler = DBD::all_data("
SELECT *
FROM
     satis_urunler
WHERE
      status=1
AND
      satis_defaultid='$satis_defaultid'  and cari_key='$cari_key'");
    if ($faturadaki_urunler > 0) {
        $gidecek_arr = [];
        foreach ($faturadaki_urunler as $urunler) {
            $stok_id = $urunler["stok_id"];
            $stok = DB::single_query("SELECT * FROM stok WHERE id='$stok_id'");
            $birim_id = $urunler["birim_id"];
            $birim = DB::single_query("SELECT * FROM birim WHERE status=1 AND id='$birim_id'");
            $arr = [
                'stok_kodu' => $stok["stok_kodu"],
                'stok_adi' => $stok["stok_adi"],
                'birim_adi' => $birim["birim_adi"],
                'miktar' => $urunler["miktar"],
                'birim_fiyat' => $urunler["birim_fiyat"],
                'kdv' => $urunler["kdv_orani"],
                'kdv_tutar' => $urunler["kdv_tutari"],
                'iskonto' => $urunler["iskonto"],
                'iskonto_tutari' => $urunler["iskonto_tutari"],
                'tevkifat_kodu' => $urunler["tevkifat_kodu"],
                'tevkifat_tutari' => $urunler["tevkifat_tutari"],
                'toplam_tutar' => $urunler["toplam_tutar"],
                'id' => $urunler["id"],
                'islem' => "<button class='btn btn-danger btn-sm satis_fat_eksilt' data-id='" . $urunler["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "faturayi_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $faturayi_olustur = DBD::update("satis_default", "id", $_POST["id"], $_POST);
    if ($faturayi_olustur) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "faturaya_urun_ekle_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $fatura_id = $_POST["satis_defaultid"];

    $faturaya_urun_ekle = DBD::insert("satis_urunler", $_POST);
    if ($faturaya_urun_ekle > 0) {
        echo 2;
    } else {
        $faturadaki_urunler = DBD::all_data("SELECT * FROM satis_urunler WHERE status=1 AND satis_defaultid='$fatura_id'  and cari_key='$cari_key'");
        if ($faturadaki_urunler > 0) {
            $gidecek_arr = [];
            foreach ($faturadaki_urunler as $urunler) {
                $stok_id = $urunler["stok_id"];
                $stok = DB::single_query("SELECT * FROM stok WHERE id='$stok_id'");
                $birim_id = $urunler["birim_id"];
                $birim = DB::single_query("SELECT * FROM birim WHERE status=1 AND id='$birim_id'");
                $arr = [
                    'stok_kodu' => $stok["stok_kodu"],
                    'stok_adi' => $stok["stok_adi"],
                    'birim_adi' => $birim["birim_adi"],
                    'miktar' => $urunler["miktar"],
                    'birim_fiyat' => $urunler["birim_fiyat"],
                    'kdv' => $urunler["kdv_orani"],
                    'kdv_tutar' => $urunler["kdv_tutari"],
                    'iskonto' => $urunler["iskonto"],
                    'iskonto_tutari' => $urunler["iskonto_tutari"],
                    'tevkifat_kodu' => $urunler["tevkifat_kodu"],
                    'tevkifat_tutari' => $urunler["tevkifat_tutari"],
                    'toplam_tutar' => $urunler["toplam_tutar"],
                    'id' => $urunler["id"],
                    'islem' => "<button class='btn btn-danger btn-sm satis_fat_eksilt' data-id='" . $urunler["id"] . "'><i class='fa fa-trash'></i></button>"
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
}