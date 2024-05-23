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

if ($islem == "alis_hizmet_listesi_sql") {

    $gelmesi_beklenen_faturalar = DBD::all_data("
SELECT
       iem.cari_id,
       iem.id as is_emri_id,
       kc.cikis_tarihi,
       kg.giris_tarihi,
       iem.siparis_tarihi,
       kg.konteyner_no,
       iem.referans_no,
       kc.id as konteyner_cikisid,
       iem.beyanname_no,
       kc.plaka_id as cikis_plaka,
       kg.id as konteyner_girisid,
       iem.epro_ref,
       ieu.alis_fiyat,
       ieu.hizmet_id,
       ieu.hizmet_turu,
       iem.tipi,
       kc.bos_dolu as cikis_bosdolu,
       kg.bos_dolu as giris_bosdolu,
       iem.depo_cariid
FROM
     konteyner_cikis AS kc
INNER JOIN konteyner_giris as kg on kg.id=kc.konteyner_id
INNER JOIN is_emri_main AS iem on iem.id=kg.is_emri_id
INNER JOIN is_emri_urunler as ieu on ieu.is_emri_id=iem.id
WHERE kc.status=1 AND kc.cari_key='$cari_key' AND ieu.status=1 AND kc.alis_kesildi=1 AND ieu.hizmet_turu='Depo Hizmeti'
");

    if ($gelmesi_beklenen_faturalar > 0) {
        $gidecek_arr = [];
        foreach ($gelmesi_beklenen_faturalar as $item) {
            $tarih = $item["siparis_tarihi"];
            $id = $item["konteyner_cikisid"];
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
            $hizmet_id = $item["hizmet_id"];
            $hizmet_bilgisi = DB::single_query("SELECT * FROM stok WHERE id='$hizmet_id'");
            $alis_fiyat = number_format($item["alis_fiyat"], 2);
            if ($item["depo_cariid"] != 0) {
                $depo_cariid = $item["depo_cariid"];
                $cari = DB::single_query("SELECT * FROM cari WHERE id='$depo_cariid'");
                if ($item["tipi"] == "İTHALAT"){
                    if ($item["giris_bosdolu"] == "Dolu" && $item["cikis_bosdolu"] == "Boş"){
                        $arr = [
                            'giris_tarihi' => $giris_tarihi,
                            'cikis_tarihi' => $cikis_tarihi,
                            'siparis_tarihi' => $tarih,
                            'konteyner_no' => $item["konteyner_no"],
                            'cari' => $cari["cari_adi"],
                            'geldigi_yer' => "KONTEYNER ÇIKIŞ",
                            'ucret' => $alis_fiyat,
                            'hizmet_turu' => $item["hizmet_turu"],
                            'beyanname_no' => $item["beyanname_no"],
                            'referans_no' => $item["referans_no"],
                            'epro_ref' => $item["epro_ref"],
                            'id' => $id,
                            'is_emri_id' => $item["is_emri_id"]
                        ];
                        array_push($gidecek_arr, $arr);
                    }
                }else{
                    if ($item["giris_bosdolu"] == "Boş" && $item["cikis_bosdolu"] == "Dolu"){
                        $arr = [
                            'giris_tarihi' => $giris_tarihi,
                            'cikis_tarihi' => $cikis_tarihi,
                            'siparis_tarihi' => $tarih,
                            'konteyner_no' => $item["konteyner_no"],
                            'cari' => $cari["cari_adi"],
                            'geldigi_yer' => "KONTEYNER ÇIKIŞ",
                            'ucret' => $alis_fiyat,
                            'hizmet_turu' => $item["hizmet_turu"],
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
        }
    }
    $gelmesi_beklenen_faturalar = DBD::all_data("
SELECT 
       iem.cari_id,
       iem.id as is_emri_id,
       kc.cikis_tarihi,
       kg.giris_tarihi,
       iem.siparis_tarihi,
       kg.konteyner_no,
       iem.referans_no,
       kc.id as konteyner_cikisid,
       iem.beyanname_no,
       kc.plaka_id as cikis_plaka,
       kg.id as konteyner_girisid,
       iem.epro_ref,
       ieu.alis_fiyat,
       ieu.hizmet_id,
       ieu.hizmet_turu,
       kc.bos_dolu,
       iem.depo_cariid,
       kc.bos_kesildi,
       kc.dolu_kesildi
FROM
     konteyner_cikis AS kc
INNER JOIN konteyner_giris as kg on kg.id=kc.konteyner_id
INNER JOIN is_emri_main AS iem on iem.id=kg.is_emri_id
INNER JOIN is_emri_urunler as ieu on ieu.is_emri_id=iem.id
WHERE kc.status=1 AND kc.cari_key='$cari_key' AND ieu.status=1 AND ieu.hizmet_turu='Aktarma Hizmeti'
");

    if ($gelmesi_beklenen_faturalar > 0) {
        if (!isset($gidecek_arr)) {
            $gidecek_arr = [];
        }
        foreach ($gelmesi_beklenen_faturalar as $item) {
            $tarih = $item["siparis_tarihi"];
            $id = $item["konteyner_cikisid"];
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
            $hizmet_id = $item["hizmet_id"];
            $hizmet_bilgisi = DB::single_query("SELECT * FROM stok WHERE id='$hizmet_id'");
            $alis_fiyat = number_format($item["alis_fiyat"], 2);

            $cikis_plaka = $item["cikis_plaka"];
            $arac_cikis = DB::single_query("
SELECT 
       c.cari_adi,ak.cari_id 
FROM arac_kartlari as ak 
INNER JOIN cari as c on c.id=ak.cari_id
WHERE ak.id='$cikis_plaka' AND ak.arac_grubu='KİRALIK'
");
            if ($arac_cikis > 0){
                if ($hizmet_bilgisi["stok_adi"] == "BOŞ AKTARMA BEDELİ" && $item["bos_kesildi"] == 1){
                    $arr = [
                        'giris_tarihi' => $giris_tarihi,
                        'cikis_tarihi' => $cikis_tarihi,
                        'siparis_tarihi' => $tarih,
                        'konteyner_no' => $item["konteyner_no"],
                        'cari' => $arac_cikis["cari_adi"],
                        'ucret' => $alis_fiyat,
                        'geldigi_yer' => "KONTEYNER ÇIKIŞ",
                        'hizmet_turu' => $item["hizmet_turu"],
                        'beyanname_no' => $item["beyanname_no"],
                        'referans_no' => $item["referans_no"],
                        'epro_ref' => $item["epro_ref"],
                        'id' => $id,
                        'is_emri_id' => $item["is_emri_id"]
                    ];
                    array_push($gidecek_arr, $arr);
                }else if ($hizmet_bilgisi["stok_adi"] == "DOLU AKTARMA BEDELİ" && $item["dolu_kesildi"] == 1){
                    $arr = [
                        'giris_tarihi' => $giris_tarihi,
                        'cikis_tarihi' => $cikis_tarihi,
                        'siparis_tarihi' => $tarih,
                        'konteyner_no' => $item["konteyner_no"],
                        'cari' => $arac_cikis["cari_adi"],
                        'ucret' => $alis_fiyat,
                        'geldigi_yer' => "KONTEYNER ÇIKIŞ",
                        'hizmet_turu' => $item["hizmet_turu"],
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
    }
    
    $gelmesi_beklenen_faturalar = DBD::all_data("
SELECT 
       iem.cari_id,
       iem.id as is_emri_id,
       kc.cikis_tarihi,
       kg.giris_tarihi,
       iem.siparis_tarihi,
       kg.konteyner_no,
       iem.referans_no,
       kc.id as konteyner_cikisid,
       iem.beyanname_no,
       kg.plaka_id as cikis_plaka,
       kg.id as konteyner_girisid,
       iem.epro_ref,
       ieu.alis_fiyat,
       ieu.hizmet_id,
       ieu.hizmet_turu,
       kc.bos_dolu,
       iem.depo_cariid,
       kg.bos_kesildi,
       kg.dolu_kesildi
FROM
     konteyner_giris AS kg
LEFT JOIN konteyner_cikis as kc on kg.id=kc.konteyner_id
INNER JOIN is_emri_main AS iem on iem.id=kg.is_emri_id
INNER JOIN is_emri_urunler as ieu on ieu.is_emri_id=iem.id
WHERE kg.status=1 AND kg.cari_key='$cari_key' AND ieu.status=1 AND ieu.hizmet_turu='Aktarma Hizmeti'
");

    if ($gelmesi_beklenen_faturalar > 0) {
        if (!isset($gidecek_arr)) {
            $gidecek_arr = [];
        }
        foreach ($gelmesi_beklenen_faturalar as $item) {
            $tarih = $item["siparis_tarihi"];
            $id = $item["konteyner_cikisid"];
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
            $hizmet_id = $item["hizmet_id"];
            $hizmet_bilgisi = DB::single_query("SELECT * FROM stok WHERE id='$hizmet_id'");
            $alis_fiyat = number_format($item["alis_fiyat"], 2);

            $cikis_plaka = $item["cikis_plaka"];
            $arac_cikis = DB::single_query("
SELECT 
       c.cari_adi,ak.cari_id 
FROM arac_kartlari as ak 
INNER JOIN cari as c on c.id=ak.cari_id
WHERE ak.id='$cikis_plaka' AND ak.arac_grubu='KİRALIK'
");
            if ($item["depo_cariid"] != 0) {
                // EĞER KİRALIK CARİ VAR İSE ALIŞ LİSTESİNE BASTIRMIYORUZ
            } else {
                if ($arac_cikis > 0){
                    if ($hizmet_bilgisi["stok_adi"] == "BOŞ AKTARMA BEDELİ" && $item["bos_kesildi"] == 1){
                        $arr = [
                            'giris_tarihi' => $giris_tarihi,
                            'cikis_tarihi' => $cikis_tarihi,
                            'siparis_tarihi' => $tarih,
                            'konteyner_no' => $item["konteyner_no"],
                            'cari' => $arac_cikis["cari_adi"],
                            'ucret' => $alis_fiyat,
                            'geldigi_yer' => "KONTEYNER GİRİŞ",
                            'hizmet_turu' => $item["hizmet_turu"],
                            'beyanname_no' => $item["beyanname_no"],
                            'referans_no' => $item["referans_no"],
                            'epro_ref' => $item["epro_ref"],
                            'id' => $id,
                            'is_emri_id' => $item["is_emri_id"]
                        ];
                        array_push($gidecek_arr, $arr);
                    }else if ($hizmet_bilgisi["stok_adi"] == "DOLU AKTARMA BEDELİ" && $item["dolu_kesildi"] == 1){
                        $arr = [
                            'giris_tarihi' => $giris_tarihi,
                            'cikis_tarihi' => $cikis_tarihi,
                            'siparis_tarihi' => $tarih,
                            'konteyner_no' => $item["konteyner_no"],
                            'cari' => $arac_cikis["cari_adi"],
                            'ucret' => $alis_fiyat,
                            'geldigi_yer' => "KONTEYNER GİRİŞ",
                            'hizmet_turu' => $item["hizmet_turu"],
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
        }
    }
    $gelmesi_beklenen_faturalar = DBD::all_data("
SELECT 
       iem.cari_id,
       iem.id as is_emri_id,
       kc.cikis_tarihi,
       kg.giris_tarihi,
       iem.siparis_tarihi,
       kg.konteyner_no,
       iem.referans_no,
       kc.id as konteyner_cikisid,
       iem.beyanname_no,
       kg.plaka_id as cikis_plaka,
       kg.id as konteyner_girisid,
       iem.epro_ref,
       ieu.alis_fiyat,
       ieu.hizmet_id,
       ieu.hizmet_turu,
       iem.tipi,
       kc.bos_dolu as cikis_bosdolu,
       kg.bos_dolu as giris_bosdolu
FROM
     konteyner_cikis AS kc
INNER JOIN konteyner_giris as kg on kg.id=kc.konteyner_id
INNER JOIN is_emri_main AS iem on iem.id=kg.is_emri_id
INNER JOIN is_emri_urunler as ieu on ieu.is_emri_id=iem.id
WHERE kc.status=1 AND kc.cari_key='$cari_key' AND ieu.status=1 AND ieu.hizmet_turu='Taşıma Hizmeti' AND kc.alis_kesildi=1
");

    if ($gelmesi_beklenen_faturalar > 0) {
        foreach ($gelmesi_beklenen_faturalar as $item) {
            $tarih = $item["siparis_tarihi"];
            $id = $item["konteyner_girisid"];
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
            $hizmet_id = $item["hizmet_id"];
            $hizmet_bilgisi = DB::single_query("SELECT * FROM stok WHERE id='$hizmet_id'");
            $cikis_plaka = $item["cikis_plaka"];
            $arac_cikis = DB::single_query("
SELECT 
       c.cari_adi,ak.cari_id 
FROM arac_kartlari as ak 
INNER JOIN cari as c on c.id=ak.cari_id
WHERE ak.id='$cikis_plaka' AND ak.arac_grubu='KİRALIK'
");
            $alis_fiyat = number_format($item["alis_fiyat"], 2);
            // TAŞIMA HİZMETİNDE ÖZ MAL AKTARMALARI GETİRTMİYORUZ
            if ($arac_cikis > 0) {
                // İŞLEM TİPİNE GÖRE FİLTRELEME YAPIP ARRAYA ATIYORUZ
                if ($item["tipi"] == "İTHALAT"){
                    if ($item["giris_bosdolu"] == "Boş" && $item["cikis_bosdolu"] == "Dolu"){
                        $arr = [
                            'giris_tarihi' => $giris_tarihi,
                            'cikis_tarihi' => $cikis_tarihi,
                            'siparis_tarihi' => $tarih,
                            'konteyner_no' => $item["konteyner_no"],
                            'cari' => $arac_cikis["cari_adi"],
                            'ucret' => $alis_fiyat,
                            'geldigi_yer' => "KONTEYNER ÇIKIŞ",
                            'hizmet_turu' => $item["hizmet_turu"],
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
        }
    }
//    $gelmesi_beklenen_faturalar = DBD::all_data("
//SELECT
//       iem.cari_id,
//       iem.id as is_emri_id,
//       iem.siparis_tarihi,
//       iem.referans_no,
//       iem.beyanname_no,
//       iem.epro_ref,
//       ieu.alis_fiyat,
//       ieu.hizmet_id,
//       ieu.hizmet_turu,
//       iem.tipi,
//       ag.id as arac_girisid,
//       ag.giris_tarihi,
//       ag.giris_tarihi as cikis_tarihi
//FROM
//     arac_giris AS ag
//INNER JOIN is_emri_main AS iem on iem.id=ag.is_emri_id
//INNER JOIN is_emri_urunler as ieu on ieu.is_emri_id=iem.id
//WHERE ag.status=1 AND ag.cari_key='$cari_key' AND ag.alis_kesildi=1 AND ieu.status=1 AND ieu.hizmet_turu='Taşıma Hizmeti'
//");
//
//    if ($gelmesi_beklenen_faturalar > 0) {
//        foreach ($gelmesi_beklenen_faturalar as $item) {
//            $tarih = $item["siparis_tarihi"];
//            $id = $item["arac_girisid"];
//            $giris_tarihi = $item["giris_tarihi"];
//            if ($giris_tarihi != null) {
//                $giris_tarihi = date("d/m/Y", strtotime($giris_tarihi));
//            }
//            $cikis_tarihi = $item["cikis_tarihi"];
//            if ($cikis_tarihi != null) {
//                $cikis_tarihi = date("d/m/Y", strtotime($cikis_tarihi));
//            }
//            if ($tarih != null) {
//                $tarih = date("d/m/Y", strtotime($tarih));
//            }
//            $hizmet_id = $item["hizmet_id"];
//            $hizmet_bilgisi = DB::single_query("SELECT * FROM stok WHERE id='$hizmet_id'");
//            $cikis_plaka = $item["cikis_plaka"];
//            $arac_cikis = DB::single_query("
//SELECT
//       c.cari_adi,ak.cari_id
//FROM arac_kartlari as ak
//INNER JOIN cari as c on c.id=ak.cari_id
//WHERE ak.id='$cikis_plaka' AND ak.arac_grubu='KİRALIK'
//");
//            $alis_fiyat = number_format($item["alis_fiyat"], 2);
//            if ($arac_cikis > 0) {
//                // ARAÇ GİRİŞLERİNİ DİREKT OLARAK TAŞIMA HİZMETİ ALIYORUZ
//                $arr = [
//                    'giris_tarihi' => $giris_tarihi,
//                    'cikis_tarihi' => $cikis_tarihi,
//                    'siparis_tarihi' => $tarih,
//                    'konteyner_no' => $item["konteyner_no"],
//                    'cari' => $arac_cikis["cari_adi"],
//                    'ucret' => $alis_fiyat,
//                    'geldigi_yer' => "ARAÇ GİRİŞ",
//                    'hizmet_turu' => $item["hizmet_turu"],
//                    'beyanname_no' => $item["beyanname_no"],
//                    'referans_no' => $item["referans_no"],
//                    'epro_ref' => $item["epro_ref"],
//                    'id' => $id,
//                    'is_emri_id' => $item["is_emri_id"]
//                ];
//                array_push($gidecek_arr, $arr);
//            }
//        }
//    }

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
       kc.cikis_tarihi,
       kg.giris_tarihi,
       iem.siparis_tarihi,
       kg.konteyner_no,
       iem.referans_no,
       kc.id as konteyner_cikisid,
       iem.beyanname_no,
       kc.plaka_id as cikis_plaka,
       kg.id as konteyner_girisid,
       iem.epro_ref,
       ieu.alis_fiyat,
       ieu.hizmet_id,
       ieu.hizmet_turu,
       kc.bos_dolu as cikis_bosdolu,
       kg.bos_dolu as giris_bosdolu,
       iem.tipi,
       iem.depo_cariid
FROM
     konteyner_cikis AS kc
INNER JOIN konteyner_giris as kg on kg.id=kc.konteyner_id
INNER JOIN is_emri_main AS iem on iem.id=kg.is_emri_id
INNER JOIN is_emri_urunler as ieu on ieu.is_emri_id=iem.id
WHERE kc.status=1 AND kc.cari_key='$cari_key' AND ieu.status=1 AND  kc.alis_kesildi=1 AND  ieu.hizmet_turu='Depo Hizmeti' AND iem.depo_cariid='$cari_id'
");
    if ($gelmesi_beklenen_faturalar > 0) {
        $gidecek_arr = [];
        foreach ($gelmesi_beklenen_faturalar as $item) {
            $tarih = $item["siparis_tarihi"];
            $id = $item["konteyner_cikisid"];
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
            $hizmet_id = $item["hizmet_id"];
            $hizmet_bilgisi = DB::single_query("SELECT * FROM stok WHERE id='$hizmet_id'");
            $alis_fiyat = number_format($item["alis_fiyat"], 2);
            if ($item["depo_cariid"] != 0) {
                $depo_cariid = $item["depo_cariid"];
                $cari = DB::single_query("SELECT * FROM cari WHERE id='$depo_cariid'");
                if ($item["tipi"] == "İTHALAT"){
                    if ($item["giris_bosdolu"] == "Dolu" && $item["cikis_bosdolu"] == "Boş"){
                        $arr = [
                            'giris_tarihi' => $giris_tarihi,
                            'cikis_tarihi' => $cikis_tarihi,
                            'siparis_tarihi' => $tarih,
                            'konteyner_no' => $item["konteyner_no"],
                            'cari' => $cari["cari_adi"],
                            'aktarma_hizmeti' => "",
                            'geldigi_yer' => "KONTEYNER ÇIKIŞ",
                            'ucret' => $alis_fiyat,
                            'hizmet_turu' => $item["hizmet_turu"],
                            'beyanname_no' => $item["beyanname_no"],
                            'referans_no' => $item["referans_no"],
                            'epro_ref' => $item["epro_ref"],
                            'id' => $id,
                            'is_emri_id' => $item["is_emri_id"]
                        ];
                        array_push($gidecek_arr, $arr);
                    }
                }else{
                    if ($item["giris_bosdolu"] == "Boş" && $item["cikis_bosdolu"] == "Dolu"){
                        $arr = [
                            'giris_tarihi' => $giris_tarihi,
                            'cikis_tarihi' => $cikis_tarihi,
                            'siparis_tarihi' => $tarih,
                            'konteyner_no' => $item["konteyner_no"],
                            'aktarma_hizmeti' => "",
                            'cari' => $cari["cari_adi"],
                            'geldigi_yer' => "KONTEYNER ÇIKIŞ",
                            'ucret' => $alis_fiyat,
                            'hizmet_turu' => $item["hizmet_turu"],
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
        }
    }
    $gelmesi_beklenen_faturalar = DBD::all_data("
SELECT 
       iem.cari_id,
       iem.id as is_emri_id,
       kc.cikis_tarihi,
       kg.giris_tarihi,
       iem.siparis_tarihi,
       kg.konteyner_no,
       iem.referans_no,
       kc.id as konteyner_cikisid,
       iem.beyanname_no,
       kc.plaka_id as cikis_plaka,
       kg.id as konteyner_girisid,
       iem.epro_ref,
       ieu.alis_fiyat,
       ieu.hizmet_id,
       ieu.hizmet_turu,
       kc.bos_kesildi,
       kc.dolu_kesildi,
       kc.bos_dolu,
       iem.depo_cariid
FROM
     konteyner_cikis AS kc
INNER JOIN konteyner_giris as kg on kg.id=kc.konteyner_id
INNER JOIN is_emri_main AS iem on iem.id=kg.is_emri_id
INNER JOIN is_emri_urunler as ieu on ieu.is_emri_id=iem.id
WHERE kc.status=1 AND kc.cari_key='$cari_key' AND kc.alis_kesildi=1 AND ieu.status=1 AND ieu.hizmet_turu='Aktarma Hizmeti'
");
    // ÖZ MAL İŞ EMİRLERİ GELİYOR SADECE
    if ($gelmesi_beklenen_faturalar > 0) {
        if (!isset($gidecek_arr)) {
            $gidecek_arr = [];
        }
        foreach ($gelmesi_beklenen_faturalar as $item) {
            $tarih = $item["siparis_tarihi"];
            $id = $item["konteyner_cikisid"];
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
            $hizmet_id = $item["hizmet_id"];
            $hizmet_bilgisi = DB::single_query("SELECT * FROM stok WHERE id='$hizmet_id'");
            $alis_fiyat = number_format($item["alis_fiyat"], 2);

            $cikis_plaka = $item["cikis_plaka"];
            $arac_cikis = DB::single_query("
SELECT 
       c.cari_adi,ak.cari_id 
FROM arac_kartlari as ak 
INNER JOIN cari as c on c.id=ak.cari_id
WHERE ak.id='$cikis_plaka' AND c.id='$cari_id' AND ak.arac_grubu='KİRALIK'
");
            // BURADA HEM PLAKA İD Yİ HEMDİ GÖNDERİLEN CARİ İD İLE ARAC CARİSİ EŞLEŞİYORMU BUNU SORGULUYORUZ
            if ($arac_cikis > 0) {
                if ($hizmet_bilgisi["stok_adi"] == "BOŞ AKTARMA BEDELİ" && $item["bos_kesildi"] == 1){
                    $arr = [
                        'giris_tarihi' => $giris_tarihi,
                        'cikis_tarihi' => $cikis_tarihi,
                        'siparis_tarihi' => $tarih,
                        'konteyner_no' => $item["konteyner_no"],
                        'cari' => $arac_cikis["cari_adi"],
                        'ucret' => $alis_fiyat,
                        'aktarma_hizmeti' => $hizmet_bilgisi["stok_adi"],
                        'geldigi_yer' => "KONTEYNER ÇIKIŞ",
                        'hizmet_turu' => $item["hizmet_turu"],
                        'beyanname_no' => $item["beyanname_no"],
                        'referans_no' => $item["referans_no"],
                        'epro_ref' => $item["epro_ref"],
                        'id' => $id,
                        'is_emri_id' => $item["is_emri_id"]
                    ];
                    array_push($gidecek_arr, $arr);
                }else if ($hizmet_bilgisi["stok_adi"] == "DOLU AKTARMA BEDELİ" && $item["dolu_kesildi"] == 1){
                    $arr = [
                        'giris_tarihi' => $giris_tarihi,
                        'cikis_tarihi' => $cikis_tarihi,
                        'siparis_tarihi' => $tarih,
                        'konteyner_no' => $item["konteyner_no"],
                        'cari' => $arac_cikis["cari_adi"],
                        'ucret' => $alis_fiyat,
                        'geldigi_yer' => "KONTEYNER ÇIKIŞ",
                        'aktarma_hizmeti' => $hizmet_bilgisi["stok_adi"],
                        'hizmet_turu' => $item["hizmet_turu"],
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
        // 4 ADET KAYIT BURADAN GELİYOR
    }
    $gelmesi_beklenen_faturalar = DBD::all_data("
SELECT 
       iem.cari_id,
       iem.id as is_emri_id,
       kc.cikis_tarihi,
       kg.giris_tarihi,
       iem.siparis_tarihi,
       kg.konteyner_no,
       iem.referans_no,
       kc.id as konteyner_cikisid,
       iem.beyanname_no,
       kg.plaka_id as cikis_plaka,
       kg.id as konteyner_girisid,
       iem.epro_ref,
       ieu.alis_fiyat,
       ieu.hizmet_id,
       ieu.hizmet_turu,
       kc.bos_dolu,
       iem.depo_cariid,
       kg.bos_kesildi,
       kg.dolu_kesildi
FROM
     konteyner_giris AS kg
LEFT JOIN konteyner_cikis as kc on kg.id=kc.konteyner_id
INNER JOIN is_emri_main AS iem on iem.id=kg.is_emri_id
INNER JOIN is_emri_urunler as ieu on ieu.is_emri_id=iem.id
WHERE kg.status=1 AND kg.cari_key='$cari_key' AND kg.alis_kesildi=1 AND ieu.status=1 AND ieu.hizmet_turu='Aktarma Hizmeti'
");
    // DEPO CARİ İD Sİ OLMAYANLAR GELECEK YANİ ÖZMAL İŞ EMİRLERİ GELİYOR SADECE
    if ($gelmesi_beklenen_faturalar > 0) {
        if (!isset($gidecek_arr)) {
            $gidecek_arr = [];
        }
        foreach ($gelmesi_beklenen_faturalar as $item) {
            $tarih = $item["siparis_tarihi"];
            $id = $item["konteyner_girisid"];
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
            $hizmet_id = $item["hizmet_id"];
            $hizmet_bilgisi = DB::single_query("SELECT * FROM stok WHERE id='$hizmet_id'");
            $alis_fiyat = number_format($item["alis_fiyat"], 2);

            $cikis_plaka = $item["cikis_plaka"];
            $arac_cikis = DB::single_query("
SELECT 
       c.cari_adi,ak.cari_id 
FROM arac_kartlari as ak 
INNER JOIN cari as c on c.id=ak.cari_id
WHERE ak.id='$cikis_plaka' AND ak.cari_id='$cari_id' AND ak.arac_grubu='KİRALIK'
");
            if ($item["depo_cariid"] != 0) {
                // EĞER KİRALIK CARİ VAR İSE ALIŞ LİSTESİNE BASTIRMIYORUZ
            } else {
                if ($arac_cikis > 0){
                    if ($hizmet_bilgisi["stok_adi"] == "BOŞ AKTARMA BEDELİ" && $item["bos_kesildi"] == 1){
                        $arr = [
                            'giris_tarihi' => $giris_tarihi,
                            'cikis_tarihi' => $cikis_tarihi,
                            'siparis_tarihi' => $tarih,
                            'konteyner_no' => $item["konteyner_no"],
                            'cari' => $arac_cikis["cari_adi"],
                            'ucret' => $alis_fiyat,
                            'geldigi_yer' => "KONTEYNER GİRİŞ",
                            'aktarma_hizmeti' => $hizmet_bilgisi["stok_adi"],
                            'hizmet_turu' => $item["hizmet_turu"],
                            'beyanname_no' => $item["beyanname_no"],
                            'referans_no' => $item["referans_no"],
                            'epro_ref' => $item["epro_ref"],
                            'id' => $id,
                            'is_emri_id' => $item["is_emri_id"]
                        ];
                        array_push($gidecek_arr, $arr);
                    }else if ($hizmet_bilgisi["stok_adi"] == "DOLU AKTARMA BEDELİ" && $item["dolu_kesildi"] == 1){
                        $arr = [
                            'giris_tarihi' => $giris_tarihi,
                            'cikis_tarihi' => $cikis_tarihi,
                            'siparis_tarihi' => $tarih,
                            'konteyner_no' => $item["konteyner_no"],
                            'cari' => $arac_cikis["cari_adi"],
                            'ucret' => $alis_fiyat,
                            'geldigi_yer' => "KONTEYNER GİRİŞ",
                            'hizmet_turu' => $item["hizmet_turu"],
                            'aktarma_hizmeti' => $hizmet_bilgisi["stok_adi"],
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
        }
        // 4 KAYIT BURADAN GELİYOR
    }
    $gelmesi_beklenen_faturalar = DBD::all_data("
SELECT 
       iem.cari_id,
       iem.id as is_emri_id,
       kc.cikis_tarihi,
       kg.giris_tarihi,
       iem.siparis_tarihi,
       kg.konteyner_no,
       iem.referans_no,
       kc.id as konteyner_cikisid,
       iem.beyanname_no,
       kg.plaka_id as cikis_plaka,
       kg.id as konteyner_girisid,
       iem.epro_ref,
       ieu.alis_fiyat,
       ieu.hizmet_id,
       ieu.hizmet_turu,
       kc.bos_dolu as cikis_bosdolu,
       kg.bos_dolu as giris_bosdolu,
       iem.tipi
FROM
     konteyner_cikis AS kc
INNER JOIN konteyner_giris as kg on kg.id=kc.konteyner_id
INNER JOIN is_emri_main AS iem on iem.id=kg.is_emri_id
INNER JOIN is_emri_urunler as ieu on ieu.is_emri_id=iem.id
WHERE kc.status=1 AND kc.cari_key='$cari_key' AND kg.alis_kesildi=1 AND ieu.status=1 AND ieu.hizmet_turu='Taşıma Hizmeti' AND kc.alis_kesildi=1
");

    if ($gelmesi_beklenen_faturalar > 0) {
        foreach ($gelmesi_beklenen_faturalar as $item) {
            $tarih = $item["siparis_tarihi"];
            $id = $item["konteyner_girisid"];
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
            $hizmet_id = $item["hizmet_id"];
            $hizmet_bilgisi = DB::single_query("SELECT * FROM stok WHERE id='$hizmet_id'");
            $cikis_plaka = $item["cikis_plaka"];
            $arac_cikis = DB::single_query("
SELECT 
       c.cari_adi,ak.cari_id 
FROM arac_kartlari as ak 
INNER JOIN cari as c on c.id=ak.cari_id
WHERE ak.cari_id='$cari_id' AND ak.arac_grubu='KİRALIK'
");
            $alis_fiyat = number_format($item["alis_fiyat"], 2);
            if ($arac_cikis > 0) {
                // TAŞIMA HİZMETİNDE ÖZ MAL AKTARMALARI GETİRTMİYORUZ
                if ($item["tipi"] == "İTHALAT"){
                    if ($item["giris_bosdolu"] == "Boş" && $item["cikis_bosdolu"] == "Dolu"){
                        $arr = [
                            'giris_tarihi' => $giris_tarihi,
                            'cikis_tarihi' => $cikis_tarihi,
                            'siparis_tarihi' => $tarih,
                            'konteyner_no' => $item["konteyner_no"],
                            'cari' => $arac_cikis["cari_adi"],
                            'ucret' => $alis_fiyat,
                            'geldigi_yer' => "KONTEYNER ÇIKIŞ",
                            'hizmet_turu' => $item["hizmet_turu"],
                            'beyanname_no' => $item["beyanname_no"],
                            'referans_no' => $item["referans_no"],
                            'epro_ref' => $item["epro_ref"],
                            'aktarma_hizmeti' => "",
                            'id' => $id,
                            'is_emri_id' => $item["is_emri_id"]
                        ];
                        array_push($gidecek_arr, $arr);
                    }
                }
            }
        }
    }
    if (!empty($gidecek_arr)) {
        echo json_encode($gidecek_arr);
    } else {
        echo 2;
    }
}
if ($islem == "secilen_irsaliyeyi_faturalastir") {
    $genel_toplam = 0;
    $ara_toplam = 0;
    $kdv_toplam = 0;
    $tevkifat_toplam = 0;
    $iskonto_toplam = 0;
    $alis_defaultid = $_POST["alis_id"];
    if (isset($_POST["select_irsaliye"])) {
        foreach ($_POST["select_irsaliye"] as $item) {
            $hizmet_turu = $item["hizmet_turu"];
            $geldigi_yer = $item["geldigi_yer"];
            $id = $item["id"];
            $find_const = "";
            $konteyner_irsaliye_bilgileri = [];
            if ($geldigi_yer == "KONTEYNER GİRİŞ") {
                $konteyner_irsaliye_bilgileri = DBD::single_query("
SELECT 
       iem.cari_id,
       iem.id as is_emri_id,
       kc.cikis_tarihi,
       kg.giris_tarihi,
       iem.siparis_tarihi,
       kg.konteyner_no,
       iem.referans_no,
       iem.beyanname_no,
       kg.plaka_id as cikis_plaka,
       kg.id as konteyner_girisid,
       iem.epro_ref,
       ieu.alis_fiyat,
       ieu.hizmet_id,
       iem.birim_id,
       ieu.hizmet_turu,
       kg.bos_dolu
FROM
     konteyner_giris AS kg
LEFT JOIN konteyner_cikis AS kc on kc.konteyner_id=kg.id AND kc.status=1
INNER JOIN is_emri_main AS iem on iem.id=kg.is_emri_id
INNER JOIN is_emri_urunler as ieu on ieu.is_emri_id=iem.id
WHERE kg.status!=0 AND kg.cari_key='$cari_key' AND ieu.status=1 AND kg.id='$id'
");
            } else if ($geldigi_yer == "KONTEYNER ÇIKIŞ") {
                $konteyner_irsaliye_bilgileri = DBD::single_query("
SELECT 
       iem.cari_id,
       iem.id as is_emri_id,
       kc.cikis_tarihi,
       kg.giris_tarihi,
       iem.siparis_tarihi,
       kg.konteyner_no,
       iem.referans_no,
       kc.id as konteyner_cikisid,
       iem.beyanname_no,
       iem.birim_id,
       kc.plaka_id as cikis_plaka,
       kg.id as konteyner_girisid,
       iem.epro_ref,
       ieu.alis_fiyat,
       ieu.hizmet_id,
       ieu.hizmet_turu,
       kc.bos_dolu
FROM
     konteyner_cikis AS kc
INNER JOIN konteyner_giris as kg on kg.id=kc.konteyner_id
INNER JOIN is_emri_main AS iem on iem.id=kg.is_emri_id
INNER JOIN is_emri_urunler as ieu on ieu.is_emri_id=iem.id
WHERE kc.status=1 AND kc.cari_key='$cari_key' AND ieu.status=1 AND kc.id='$id'
");
            } else {
                $find_const = "NOT FOUND";
            }

            if ($find_const == "NOT FOUND") {
                die();
            }

            $stok_id = "";
            $fiyat = 0;
            $tipi = "";
            $fiyat = $item["fiyat"];
            if ($hizmet_turu == "Depo Hizmeti") {
                $depo_stogu = DB::single_query("SELECT id FROM stok WHERE status=1 AND stok_kodu='DEPO.001'");
                $stok_id = $depo_stogu["id"];
                $tipi = $konteyner_irsaliye_bilgileri["tipi"];
            } else {
                $siparis_id = $konteyner_irsaliye_bilgileri["is_emri_id"];
                $ihracat_is_emri_urunu = DBD::single_query("SELECT hizmet_id FROM is_emri_urunler WHERE status=1 AND is_emri_id='$siparis_id'");
                $stok_id = $ihracat_is_emri_urunu["hizmet_id"];
                $tipi = $konteyner_irsaliye_bilgileri["tipi"];
            }
            $arac_id = $konteyner_irsaliye_bilgileri["plaka_id"];

            $stok_bilgileri = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");

            $kdv_yuzde = floatval($stok_bilgileri["kdv_orani"]) / 100;
            $kdv_tutar = floatval($fiyat) * floatval($kdv_yuzde);
            $yeni_tutar = floatval($kdv_tutar) + floatval($fiyat);

            $tevkifat_orani = floatval($stok_bilgileri["tevkifat_yuzde"]) / 100;

            $arac_ozmal_mi = DB::single_query("SELECT arac_grubu FROM arac_kartlari WHERE status=1 AND id='$arac_id'");
            $alis_urun = DBD::single_query("SELECT * FROM alis_urunler WHERE status=1 AND cari_key='$cari_key' AND alis_defaultid='$alis_defaultid' AND stok_id='$stok_id' AND birim_fiyat='$fiyat'");
            if ($alis_urun > 0) {
                $miktar_dizi = 1 + floatval($alis_urun["miktar"]);
                $fiyat_dizi = floatval($fiyat) + floatval($alis_urun["toplam_tutar"]);

                $tekrar_ara_toplam = $miktar_dizi * floatval($fiyat);
                $tekrar_kdv_tutar = $tekrar_ara_toplam * floatval($kdv_yuzde);

                $tevkifat_tutari = 0;


                $tekrar_yeni_tutar = $tekrar_ara_toplam + $tekrar_kdv_tutar;

                if ($arac_ozmal_mi["arac_grubu"] == "Öz Mal") {
                    $tevkifat_tutari = $tekrar_kdv_tutar * $tevkifat_orani;
                    $tekrar_yeni_tutar = $tekrar_yeni_tutar - $tevkifat_tutari;
                }


                $arr = [
                    'alis_defaultid' => $alis_defaultid,
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
                $alis_fatura_urunleri = DBD::update("alis_urunler", "id", $alis_urun["id"], $arr);


                $ids = array_column($_POST["select_irsaliye"], "id");
                $implode_ids = implode(",", $ids);
                if ($item["geldigi_yer"] == "KONTEYNER GİRİŞ") {
                    if ($item["aktarma_turu"] != "") {
                        if ($item["aktarma_turu"] == "BOŞ AKTARMA BEDELİ") {
                            $irsaliyeden_dusur_arr123 = [
                                'bos_kesildi' => 2
                            ];

                            $irsaliye_urunler = DBD::update("konteyner_giris", "id", $konteyner_irsaliye_bilgileri["konteyner_girisid"], $irsaliyeden_dusur_arr123);

                            $arr2 = [
                                'bos_ids' => $implode_ids
                            ];
                            $alis_default_guncelle = DBD::update("alis_default", "id", $alis_defaultid, $arr2);
                            // FATURADAN BULUNAN bos_ids İÇİN BİR ARRAY OLUŞTURULDU OLUŞMA SEBEBİ İSE SİLME İŞLEMİNDE BOŞ MU YOKSA DOLUSUNU MU TEKRAR DÜŞÜRECEĞİ
                        } else {
                            $irsaliyeden_dusur_arr123 = [
                                'dolu_kesildi' => 2
                            ];

                            $irsaliye_urunler = DBD::update("konteyner_giris", "id", $konteyner_irsaliye_bilgileri["konteyner_girisid"], $irsaliyeden_dusur_arr123);

                            $arr2 = [
                                'dolu_ids' => $implode_ids
                            ];
                            $alis_default_guncelle = DBD::update("alis_default", "id", $alis_defaultid, $arr2);
                            // FATURADAN BULUNAN bos_ids İÇİN BİR ARRAY OLUŞTURULDU OLUŞMA SEBEBİ İSE SİLME İŞLEMİNDE BOŞ MU YOKSA DOLUSUNU MU TEKRAR DÜŞÜRECEĞİ
                        }
                    } else {
                        $irsaliyeden_dusur_arr123 = [
                            'alis_kesildi' => 2
                        ];

                        $irsaliye_urunler = DBD::update("konteyner_giris", "id", $konteyner_irsaliye_bilgileri["konteyner_girisid"], $irsaliyeden_dusur_arr123);
                    }
                    $arr2 = [
                        'giris_id' => $implode_ids
                    ];
                } else {
                    if ($item["aktarma_turu"] != "") {
                        if ($item["aktarma_turu"] == "BOŞ AKTARMA BEDELİ") {
                            $irsaliyeden_dusur_arr123 = [
                                'bos_kesildi' => 2
                            ];

                            $irsaliye_urunler = DBD::update("konteyner_cikis", "id", $konteyner_irsaliye_bilgileri["konteyner_cikisid"], $irsaliyeden_dusur_arr123);

                            $arr2 = [
                                'bos_ids' => $implode_ids
                            ];
                            $alis_default_guncelle = DBD::update("alis_default", "id", $alis_defaultid, $arr2);
                            // FATURADAN BULUNAN bos_ids İÇİN BİR ARRAY OLUŞTURULDU OLUŞMA SEBEBİ İSE SİLME İŞLEMİNDE BOŞ MU YOKSA DOLUSUNU MU TEKRAR DÜŞÜRECEĞİ
                        } else {
                            $irsaliyeden_dusur_arr123 = [
                                'dolu_kesildi' => 2
                            ];

                            $irsaliye_urunler = DBD::update("konteyner_cikis", "id", $konteyner_irsaliye_bilgileri["konteyner_cikisid"], $irsaliyeden_dusur_arr123);

                            $arr2 = [
                                'dolu_ids' => $implode_ids
                            ];
                            $alis_default_guncelle = DBD::update("alis_default", "id", $alis_defaultid, $arr2);
                            // FATURADAN BULUNAN bos_ids İÇİN BİR ARRAY OLUŞTURULDU OLUŞMA SEBEBİ İSE SİLME İŞLEMİNDE BOŞ MU YOKSA DOLUSUNU MU TEKRAR DÜŞÜRECEĞİ
                        }
                    } else {
                        $irsaliyeden_dusur_arr123 = [
                            'alis_kesildi' => 2
                        ];

                        $irsaliye_urunler = DBD::update("konteyner_cikis", "id", $konteyner_irsaliye_bilgileri["konteyner_cikisid"], $irsaliyeden_dusur_arr123);

                    }
                    $arr2 = [
                        'cikis_id' => $implode_ids
                    ];
                }
                $alis_default_guncelle = DBD::update("alis_default", "id", $alis_defaultid, $arr2);
            } else {
                if ($konteyner_irsaliye_bilgileri > 0) {
                    $tevkifat_tutari = 0;
                    if ($arac_ozmal_mi["arac_grubu"] == "Öz Mal") {
                        $tevkifat_tutari = $kdv_tutar * $tevkifat_orani;
                        $yeni_tutar = $yeni_tutar - $tevkifat_tutari;
                    }

                    $arr = [
                        'alis_defaultid' => $alis_defaultid,
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
                    $alis_fatura_urunleri = DBD::insert("alis_urunler", $arr);
                    $irsaliyeden_dusur_arr123 = [
                        'alis_kesildi' => 2
                    ];
                    $irsaliye_urunler = DBD::update("konteyner_cikis", "id", $konteyner_irsaliye_bilgileri["konteyner_cikisid"], $irsaliyeden_dusur_arr123);

                    $ids = array_column($_POST["select_irsaliye"], "id");
                    $implode_ids = implode(",", $ids);
                    if ($item["geldigi_yer"] == "KONTEYNER GİRİŞ") {
                        if ($item["aktarma_turu"] != "") {
                            if ($item["aktarma_turu"] == "BOŞ AKTARMA BEDELİ") {
                                $irsaliyeden_dusur_arr123 = [
                                    'bos_kesildi' => 2
                                ];

                                $irsaliye_urunler = DBD::update("konteyner_giris", "id", $konteyner_irsaliye_bilgileri["konteyner_girisid"], $irsaliyeden_dusur_arr123);

                                $arr2 = [
                                    'bos_ids' => $implode_ids
                                ];
                                $alis_default_guncelle = DBD::update("alis_default", "id", $alis_defaultid, $arr2);
                                // FATURADAN BULUNAN bos_ids İÇİN BİR ARRAY OLUŞTURULDU OLUŞMA SEBEBİ İSE SİLME İŞLEMİNDE BOŞ MU YOKSA DOLUSUNU MU TEKRAR DÜŞÜRECEĞİ
                            } else {
                                $irsaliyeden_dusur_arr123 = [
                                    'dolu_kesildi' => 2
                                ];

                                $irsaliye_urunler = DBD::update("konteyner_giris", "id", $konteyner_irsaliye_bilgileri["konteyner_girisid"], $irsaliyeden_dusur_arr123);

                                $arr2 = [
                                    'dolu_ids' => $implode_ids
                                ];
                                $alis_default_guncelle = DBD::update("alis_default", "id", $alis_defaultid, $arr2);
                                // FATURADAN BULUNAN bos_ids İÇİN BİR ARRAY OLUŞTURULDU OLUŞMA SEBEBİ İSE SİLME İŞLEMİNDE BOŞ MU YOKSA DOLUSUNU MU TEKRAR DÜŞÜRECEĞİ
                            }
                        } else {
                            $irsaliyeden_dusur_arr123 = [
                                'alis_kesildi' => 2
                            ];

                            $irsaliye_urunler = DBD::update("konteyner_giris", "id", $konteyner_irsaliye_bilgileri["konteyner_girisid"], $irsaliyeden_dusur_arr123);
                        }
                        $arr2 = [
                            'giris_id' => $implode_ids
                        ];
                    } else {
                        if ($item["aktarma_turu"] != "") {
                            if ($item["aktarma_turu"] == "BOŞ AKTARMA BEDELİ") {
                                $irsaliyeden_dusur_arr123 = [
                                    'bos_kesildi' => 2
                                ];

                                $irsaliye_urunler = DBD::update("konteyner_cikis", "id", $konteyner_irsaliye_bilgileri["konteyner_cikisid"], $irsaliyeden_dusur_arr123);

                                $arr2 = [
                                    'bos_ids' => $implode_ids
                                ];
                                $alis_default_guncelle = DBD::update("alis_default", "id", $alis_defaultid, $arr2);
                                // FATURADAN BULUNAN bos_ids İÇİN BİR ARRAY OLUŞTURULDU OLUŞMA SEBEBİ İSE SİLME İŞLEMİNDE BOŞ MU YOKSA DOLUSUNU MU TEKRAR DÜŞÜRECEĞİ
                            } else {
                                $irsaliyeden_dusur_arr123 = [
                                    'dolu_kesildi' => 2
                                ];

                                $irsaliye_urunler = DBD::update("konteyner_cikis", "id", $konteyner_irsaliye_bilgileri["konteyner_cikisid"], $irsaliyeden_dusur_arr123);

                                $arr2 = [
                                    'dolu_ids' => $implode_ids
                                ];
                                $alis_default_guncelle = DBD::update("alis_default", "id", $alis_defaultid, $arr2);
                                // FATURADAN BULUNAN bos_ids İÇİN BİR ARRAY OLUŞTURULDU OLUŞMA SEBEBİ İSE SİLME İŞLEMİNDE BOŞ MU YOKSA DOLUSUNU MU TEKRAR DÜŞÜRECEĞİ
                            }
                        } else {
                            $irsaliyeden_dusur_arr123 = [
                                'alis_kesildi' => 2
                            ];

                            $irsaliye_urunler = DBD::update("konteyner_cikis", "id", $konteyner_irsaliye_bilgileri["konteyner_cikisid"], $irsaliyeden_dusur_arr123);
                        }
                        $arr2 = [
                            'cikis_id' => $implode_ids
                        ];
                    }
                    $alis_default_guncelle = DBD::update("alis_default", "id", $alis_defaultid, $arr2);
                }
            }
        }
    }
    $faturadaki_urunler = DBD::all_data("
SELECT *
FROM
     alis_urunler
WHERE
      status=1
AND
      alis_defaultid='$alis_defaultid'  and cari_key='$cari_key'");
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
                'islem' => "<button class='btn btn-danger btn-sm alis_fat_eksilt' data-id='" . $urunler["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "aktarma_icin_alis_faturasi_olustur_sql") {
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $alis_faturasi = DBD::insert("alis_default", $_POST);
    if ($alis_faturasi) {
        echo 2;
    } else {
        $son_eklenen = DBD::single_query("SELECT id FROM alis_default where  cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        echo 'id:' . $son_eklenen["id"];
    }
}
if ($islem == "faturadaki_urunun_bilgilerini_getir") {
    $id = $_GET["id"];
    $fatura_urun_bilgileri = DBD::single_query(
        "
SELECT 
       *
FROM 
     alis_urunler
WHERE 
      status=1 
AND 
      id='$id'"
    );
    if ($fatura_urun_bilgileri > 0) {
        $stok_id = $fatura_urun_bilgileri["stok_id"];
        $stok = DB::single_query("SELECT * FROM stok WHERE status=1 AND cari_key='$cari_key' AND id='$stok_id'");
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
    if (isset($_POST["alis_defaultid"])) {
        $fatura_id = $_POST["alis_defaultid"];
        $fatura_bilgileri = DBD::single_query("SELECT * FROM alis_default WHERE status=1 AND id='$fatura_id'  and cari_key='$cari_key'");
        if ($fatura_bilgileri > 0) {

            unset($_POST["kdv_fark"]);
            unset($_POST["iskonto_fark"]);
            unset($_POST["tutar_fark"]);
            unset($_POST["tevkifat_fark"]);
            unset($_POST["ara_toplam_fark"]);
            $urunleri_guncelle = DBD::update("alis_urunler", "id", $id, $_POST);
            if ($urunleri_guncelle) {
                $faturadaki_urunler = DBD::all_data("
SELECT *
FROM
     alis_urunler
WHERE
      status=1
AND
      alis_defaultid='$fatura_id'  and cari_key='$cari_key'");
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
                            'islem' => "<button class='btn btn-danger btn-sm alis_fat_eksilt' data-id='" . $urunler["id"] . "'><i class='fa fa-trash'></i></button>"
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
    $urun_bilgileri = DBD::single_query("SELECT * FROM alis_urunler WHERE status=1 AND id='$id' and cari_key='$cari_key'");
    $fatura_bilgileri = DBD::single_query("SELECT * FROM alis_default WHERE status=1 AND id='$fatura_id'  and cari_key='$cari_key'");

    unset($_POST["fatura_turu"]);
    unset($_POST["fatura_id"]);
    $urunu_faturadan_cikart = DBD::update("alis_urunler", "id", $id, $_POST);
    if ($urunu_faturadan_cikart) {
        $faturadaki_urunler = DBD::all_data("
SELECT 
       *
FROM
     alis_urunler
WHERE
      status=1
AND
      alis_defaultid='$fatura_id'  and cari_key='$cari_key'");
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
                    'islem' => "<button class='btn btn-danger btn-sm alis_fat_eksilt' data-id='" . $urunler["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "faturayi_iptal_et_sql") {
    $id = $_POST["id"];
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    if (!isset($_POST["delete_detail"])) {
        $_POST["delete_detail"] = "Kullanıcı Faturadan Vazgeçmiştir";
    }

    $satis_default_bilgi = DBD::single_query("SELECT * FROM alis_default WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    $depo_ids = explode(",", $satis_default_bilgi["giris_id"]);
    $tasima_ids = explode(",", $satis_default_bilgi["cikis_id"]);
    $bos_ids = explode(",", $satis_default_bilgi["bos_ids"]);
    $dolu_ids = explode(",", $satis_default_bilgi["dolu_ids"]);
    $tipi = $satis_default_bilgi["tipi"];

    foreach ($depo_ids as $item) {
        $arr = [
            'alis_kesildi' => 1
        ];
        $guncelle = DBD::update("konteyner_giris", "id", $item, $arr);
    }

    foreach ($bos_ids as $item) {
        if ($satis_default_bilgi["giris_id"] != ""){
            $arr = [
                'bos_kesildi' => 1
            ];
            $guncelle = DBD::update("konteyner_giris", "id", $item, $arr);
        }else{
            $arr = [
                'bos_kesildi' => 1
            ];
            $guncelle = DBD::update("konteyner_cikis", "id", $item, $arr);
        }
    }
    foreach ($dolu_ids as $item) {
        if ($satis_default_bilgi["giris_id"] != ""){
            $arr = [
                'dolu_kesildi' => 1
            ];
            $guncelle = DBD::update("konteyner_giris", "id", $item, $arr);
        }else{
            $arr = [
                'dolu_kesildi' => 1
            ];
            $guncelle = DBD::update("konteyner_cikis", "id", $item, $arr);
        }
    }

    foreach ($tasima_ids as $item) {
        $arr = [
            'alis_kesildi' => 1
        ];
        $guncelle = DBD::update("konteyner_cikis", "id", $item, $arr);
    }
    $sil = DBD::update("alis_default", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "faturayi_kaydet_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $faturayi_olustur = DBD::update("alis_default", "id", $_POST["id"], $_POST);
    if ($faturayi_olustur) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "kesilen_faturalari_getir_sql") {
    $sql = "
    SELECT * FROM alis_default 
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
                'islem' => "<button class='btn btn-sm depo_alis_fat_guncelle_button' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm depo_alis_faturasini_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "alis_faturasi_ana_bilgilerini_getir_sql") {
    $id = $_GET["id"];
    $sql = "
    SELECT * FROM alis_default 
WHERE status=1 and cari_key='$cari_key' AND id='$id'";
    $item = DBD::single_query($sql);
    if ($item > 0) {
        $depo_id = $item["depo_id"];
        $cari_id = $item["cari_id"];
        $fatura_turid = $item["fatura_turu"];
        $depo = DB::single_query("SELECT depo_adi FROM depolar WHERE id='$depo_id'");

        $cari = DB::single_query("
SELECT
       c.cari_adi,c.cari_kodu,c.telefon,c.yetkili_adi1,c.yetkili_tel1,c.vergi_dairesi,c.vergi_no,cab.adres 
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
if ($islem == "alis_urunlerini_getir_sql") {
    $alis_defaultid = $_GET["id"];
    $faturadaki_urunler = DBD::all_data("
SELECT *
FROM
     alis_urunler
WHERE
      status=1
AND
      alis_defaultid='$alis_defaultid'  and cari_key='$cari_key'");
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
                'islem' => "<button class='btn btn-danger btn-sm alis_fat_eksilt' data-id='" . $urunler["id"] . "'><i class='fa fa-trash'></i></button>"
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
    $faturayi_olustur = DBD::update("alis_default", "id", $_POST["id"], $_POST);
    if ($faturayi_olustur) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "faturaya_urun_ekle_sql"){
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $fatura_id = $_POST["alis_defaultid"];

    $faturaya_urun_ekle = DBD::insert("alis_urunler", $_POST);
    if ($faturaya_urun_ekle > 0){
        echo 2;
    }else{
        $faturadaki_urunler = DBD::all_data("SELECT * FROM alis_urunler WHERE status=1 AND alis_defaultid='$fatura_id'  and cari_key='$cari_key'");
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
                    'islem' => "<button class='btn btn-danger btn-sm alis_fat_eksilt' data-id='" . $urunler["id"] . "'><i class='fa fa-trash'></i></button>"
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