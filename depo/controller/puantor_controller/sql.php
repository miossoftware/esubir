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


if ($islem == "sahaya_urun_serme_islemini_kaydet_sql") {

    $_POST["insert_userid"] = $_SESSION["user_id"];

    $_POST["insert_datetime"] = date("Y-m-d H:i:s");

    $_POST["cari_key"] = $cari_key;

    $_POST["sube_key"] = $sube_key;

    $ekle = DBD::insert("sahaya_urun_ser", $_POST);

    if ($ekle) {

        echo 500;

    } else {

        $arr = [

            'status' => 2

        ];

        $araci_cikart = DBD::update("arac_giris", "id", $_POST["giris_id"], $arr);

        if ($araci_cikart) {

            echo 1;

        } else {

            echo 2;

        }

    }

}

if ($islem == "sahadaki_tum_urunleri_getir_sql") {

    $sahadaki_urunler = DBD::all_data("

SELECT

       kg.giris_tarihi as konteyner_giris,

       ag.giris_tarihi as arac_giris,

       kg.cari_id as konteyner_cari,

       ag.cari_id as arac_cariid,

       kg.konteyner_no,

       kg.plaka_id,

       ag.plaka_no,

       kg.surucu_adi as konteyner_surucu,

       ag.surucu_adi as arac_surucu,

       kg.is_emri_id as konteyner_girisid,

       ag.is_emri_id as arac_girisid,

       sus.birim_id,

       sus.id,

       sus.miktar

FROM

     sahaya_urun_ser as sus 

LEFT JOIN konteyner_giris as kg on kg.id=sus.k_girisid

LEFT JOIN arac_giris as ag on ag.id=sus.giris_id

WHERE sus.status=1 AND sus.cari_key='$cari_key'");

    if ($sahadaki_urunler > 0) {

        $gidecek_arr = [];

        foreach ($sahadaki_urunler as $item) {

            $giris_tarihi = "";

            if ($item["konteyner_giris"] != null || $item["konteyner_giris"] != "") {

                $giris_tarihi = $item["konteyner_giris"];

            } else {

                $giris_tarihi = $item["arac_giris"];

            }

            $is_emri_id = "";

            if ($item["konteyner_girisid"] != null || $item["konteyner_girisid"] != "") {

                $is_emri_id = $item["konteyner_girisid"];

            } else {

                $is_emri_id = $item["arac_girisid"];

            }

            $is_emri_info = DBD::single_query("SELECT * FROM is_emri_main WHERE id='$is_emri_id'");

            $cari_id = "";

            if ($item["konteyner_cari"] != null || $item["konteyner_cari"] != "") {

                $cari_id = $item["konteyner_cari"];

            } else {

                $cari_id = $item["arac_cariid"];

            }

            $surucu_adi = "";

            if ($item["konteyner_surucu"] != null || $item["konteyner_surucu"] != "") {

                $surucu_adi = $item["konteyner_surucu"];

            } else {

                $surucu_adi = $item["arac_surucu"];

            }

            $plaka_no = "";

            if ($item["plaka_id"] != null || $item["plaka_id"] != "") {

                $plaka_id = $item["plaka_id"];

                $arac = DB::single_query("SELECT plaka_no FROM arac_kartlari WHERE id='$plaka_id'");

                $plaka_no = $arac["plaka_no"];

            } else {

                $plaka_no = $item["plaka_no"];

            }

            $birim_id = $item["birim_id"];

            $birim = DB::single_query("SELECT birim_adi FROM birim WHERE id='$birim_id'");


            $cari = DB::single_query("SELECT cari_adi FROM cari WHERE id='$cari_id'");

            $miktar = number_format($item["miktar"], 2);

            if ($giris_tarihi != "0000-00-00 00:00:00") {

                $giris_tarihi = date("d/m/Y", strtotime($giris_tarihi));

            }

            $arr = [

                'giris_tarihi' => $giris_tarihi,

                'cari_adi' => $cari["cari_adi"],

                'konteyner_no' => $item["konteyner_no"],

                'id' => $item["id"],

                'plaka_no' => $plaka_no,

                'surucu_adi' => $surucu_adi,

                'epro_ref' => $is_emri_info["epro_ref"],

                'miktar' => $miktar,

                'birim_adi' => $birim["birim_adi"],

                'islem' => "<button class='btn btn-sm' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm sahadaki_urunu_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"

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
if ($islem == "sahadaki_urunleri_ve_plakalari_getir_sql") {

    $sahadaki_urunler = DBD::all_data("
SELECT
       kg.giris_tarihi as konteyner_giris,
       ag.giris_tarihi as arac_giris,
       kg.cari_id as konteyner_cari,
       ag.cari_id as arac_cariid,
       kg.konteyner_no,
       kg.plaka_id,
       ag.plaka_no,
       kg.surucu_adi as konteyner_surucu,
       ag.surucu_adi as arac_surucu,
       kg.is_emri_id as konteyner_girisid,
       ag.is_emri_id as arac_girisid,
       sus.birim_id,
       sus.id,
       sus.miktar
FROM
     sahaya_urun_ser as sus 
LEFT JOIN konteyner_giris as kg on kg.id=sus.k_girisid
LEFT JOIN arac_giris as ag on ag.id=sus.giris_id
WHERE sus.status=1 AND sus.cari_key='$cari_key'");

    if ($sahadaki_urunler > 0) {
        $gidecek_arr = [];
        foreach ($sahadaki_urunler as $item) {
            $giris_tarihi = "";
            if ($item["konteyner_giris"] != null || $item["konteyner_giris"] != "") {
                $giris_tarihi = $item["konteyner_giris"];
            } else {
                $giris_tarihi = $item["arac_giris"];
            }
            $is_emri_id = "";
            if ($item["konteyner_girisid"] != null || $item["konteyner_girisid"] != "") {
                $is_emri_id = $item["konteyner_girisid"];
            } else {
                $is_emri_id = $item["arac_girisid"];
            }
            $is_emri_info = DBD::single_query("SELECT * FROM is_emri_main WHERE id='$is_emri_id'");
            $cari_id = "";
            if ($item["konteyner_cari"] != null || $item["konteyner_cari"] != "") {
                $cari_id = $item["konteyner_cari"];
            } else {
                $cari_id = $item["arac_cariid"];
            }
            $surucu_adi = "";
            if ($item["konteyner_surucu"] != null || $item["konteyner_surucu"] != "") {
                $surucu_adi = $item["konteyner_surucu"];
            } else {
                $surucu_adi = $item["arac_surucu"];
            }
            $plaka_no = "";
            if ($item["plaka_id"] != null || $item["plaka_id"] != "") {
                $plaka_id = $item["plaka_id"];
                $arac = DB::single_query("SELECT plaka_no FROM arac_kartlari WHERE id='$plaka_id'");
                $plaka_no = $arac["plaka_no"];
            } else {
                $plaka_no = $item["plaka_no"];
            }
            $birim_id = $item["birim_id"];
            $birim = DB::single_query("SELECT birim_adi FROM birim WHERE id='$birim_id'");
            $cari = DB::single_query("SELECT cari_adi FROM cari WHERE id='$cari_id'");
            $miktar = number_format($item["miktar"], 2);
            if ($giris_tarihi != "0000-00-00 00:00:00") {
                $giris_tarihi = date("d/m/Y", strtotime($giris_tarihi));
            }
            $arr = [
                'giris_tarihi' => $giris_tarihi,
                'cari_adi' => $cari["cari_adi"],
                'konteyner_no' => $item["konteyner_no"],
                'id' => $item["id"],
                'plaka_no' => $plaka_no,
                'surucu_adi' => $surucu_adi,
                'epro_ref' => $is_emri_info["epro_ref"],
                'miktar' => $miktar,
                'bulundugu_yer' => "SAHADA",
                'birim_adi' => $birim["birim_adi"],
                'islem' => "<button class='btn btn-sm' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm sahadaki_urunu_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
            ];
            array_push($gidecek_arr, $arr);
        }
    }
    $sahadaki_urunler = DBD::all_data("
SELECT
       giris_tarihi,
       cari_id,
       plaka_no,
       surucu_adi,
       is_emri_id,
       id,
       miktar
FROM arac_giris
WHERE status=1 AND cari_key='$cari_key'");
    if ($sahadaki_urunler > 0) {
        if (!isset($gidecek_arr)){
            $gidecek_arr = [];
        }
        foreach ($sahadaki_urunler as $item) {
            $id = $item["id"];
            $giris_tarihi = $item["giris_tarihi"];
            $is_emri_id = $item["is_emri_id"];
            $is_emri_info = DBD::single_query("SELECT * FROM is_emri_main WHERE id='$is_emri_id'");
            $cari_id = $item["cari_id"];
            $surucu_adi = $item["surucu_adi"];
            $plaka_no = $item["plaka_no"];
            $birim_id = $is_emri_info["birim_id"];
            $birim = DB::single_query("SELECT birim_adi FROM birim WHERE id='$birim_id'");
            $cari = DB::single_query("SELECT cari_adi FROM cari WHERE id='$cari_id'");
            $miktar = number_format($item["miktar"], 2);
            if ($giris_tarihi != "0000-00-00 00:00:00") {
                $giris_tarihi = date("d/m/Y", strtotime($giris_tarihi));
            }
            $sahaya_serilmismi = DBD::single_query("SELECT id FROM sahaya_urun_ser WHERE giris_id='$id'");
            if ($sahaya_serilmismi > 0) {

            } else {
                $arr = [
                    'giris_tarihi' => $giris_tarihi,
                    'cari_adi' => $cari["cari_adi"],
                    'konteyner_no' => "",
                    'id' => $item["id"],
                    'plaka_no' => $plaka_no,
                    'surucu_adi' => $surucu_adi,
                    'epro_ref' => $is_emri_info["epro_ref"],
                    'miktar' => $miktar,
                    'bulundugu_yer' => "ARAÇ SIRTINDA",
                    'birim_adi' => $birim["birim_adi"],
                    'islem' => "<button class='btn btn-sm' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm sahadaki_urunu_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
                ];
                array_push($gidecek_arr, $arr);
            }
        }
    }

    if (!empty($gidecek_arr)) {
        echo json_encode($gidecek_arr);
    } else {
        echo 2;
    }
}
if ($islem == "sahadaki_konteynerleri_getir_sql") {
    $sahadaki_konteynerleri_getir = DBD::all_data("
SELECT
       kg.*,
       sks.aciklama,
       sks.id as giris_id,
       iem.cut_of_tarihi,
       iem.demoraj_tarihi,
       iem.ardiyesiz_giris_tarihi,
       iem.beyanname_no,
       iem.referans_no as referans,
       iem.cari_id,
       iem.konteyner_tipi
FROM
     sahaya_konteyner_ser AS sks 
INNER JOIN konteyner_giris AS kg on kg.id=sks.giris_id
INNER JOIN is_emri_main as iem on iem.id=kg.is_emri_id
WHERE sks.status=1 AND kg.status=1 AND sks.cari_key='$cari_key' GROUP BY sks.id
");

    if ($sahadaki_konteynerleri_getir > 0) {
        $gidecek_arr = [];
        foreach ($sahadaki_konteynerleri_getir as $item) {
            $plaka_id = $item["plaka_id"];
            $cari_id = $item["cari_id"];
            $plaka_bilgi = DB::single_query("SELECT * FROM arac_kartlari WHERE status=1 AND cari_key='$cari_key' AND id='$plaka_id'");
            $cari = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");

            $cut_off_tarihi = "";
            if ($item["cut_of_tarihi"] == "0000-00-00 00:00:00") {
            } else {
                $cut_off_tarihi = date("d/m/Y", strtotime($item["cut_of_tarihi"]));
            }
            $ardiyesiz_giris_tarihi = "";
            if ($item["ardiyesiz_giris_tarihi"] == "0000-00-00 00:00:00") {
            } else {
                $ardiyesiz_giris_tarihi = date("d/m/Y", strtotime($item["ardiyesiz_giris_tarihi"]));
            }
            $demoraj_tarihi = "";
            if ($item["demoraj_tarihi"] == "0000-00-00 00:00:00") {
            } else {
                $demoraj_tarihi = date("d/m/Y", strtotime($item["demoraj_tarihi"]));
            }

            $konteyner_no = "";
            if ($item["prim_yazilsin"] == 0) {
                $konteyner_no = $item["konteyner_no1"];
            } else {
                $konteyner_no = $item["konteyner_no"];
            }

            $giris_tarihi = date("d/m/Y", strtotime($item["giris_tarihi"]));
            $bos_dolu = "";
            $giris_id = $item["id"];
            $durum_degisti = false;
            $single = DBD::single_query("SELECT * FROM urunleri_konteynere_aktar WHERE status=1 AND cari_key='$cari_key' AND (konteyner_id1='$giris_id' OR konteyner_id2='$giris_id')");
            if ($single > 0) {
                $bos_dolu = "Dolu";
                $durum_degisti = true;
            }
            $single2 = DBD::single_query("SELECT * FROM sahaya_urun_ser WHERE status=1 AND cari_key='$cari_key' AND k_girisid='$giris_id'");
            $single3 = DBD::single_query("SELECT * FROM urunleri_konteynere_aktar WHERE konteyner_urunid='$giris_id'");
            if ($single2 > 0) {
                $bos_dolu = "Boş";
                $durum_degisti = true;
            }
            if ($single3 > 0) {
                $bos_dolu = "Boş";
                $durum_degisti = true;
            }
            if ($durum_degisti == false) {
                $bos_dolu = $item["bos_dolu"];
            }
            if ($bos_dolu != "Boş") {

            } else {
                $arr = [
                    'giris_tarihi' => $giris_tarihi,
                    'konteyner_no' => $konteyner_no,
                    'cari_adi' => $cari["cari_adi"],
                    'referans' => $item["referans"],
                    'bulundugu_yer' => "SAHADA",
                    'beyanname_no' => $item["beyanname_no"],
                    'konteyner_tipi' => $item["konteyner_tipi"],
                    'durumu' => $bos_dolu,
                    'plaka_no' => $plaka_bilgi["plaka_no"],
                    'surucu_adi' => $item["surucu_adi"],
                    'cut_off_tarihi' => $cut_off_tarihi,
                    'ardiyesiz_giris_tarihi' => $ardiyesiz_giris_tarihi,
                    'demoraj_tarihi' => $demoraj_tarihi,
                    'id' => $item["id"],
                    'islem' => "<button class='btn btn-sm sahadaki_konteyneri_guncelle_button' data-id='" . $item["giris_id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm sahadaki_konteyneri_sil_button' data-id='" . $item["giris_id"] . "'><i class='fa fa-trash'></i></button>"
                ];
                array_push($gidecek_arr, $arr);
            }
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
if ($islem == "konteyner_girislerini_getir_sql") {

    $sahadaki_konteynerleri_getir = DBD::all_data("
SELECT
       kg.*,
       iem.cut_of_tarihi,
       iem.demoraj_tarihi,
       iem.ardiyesiz_giris_tarihi,
       iem.beyanname_no,
       iem.referans_no as referans,
       iem.konteyner_tipi
FROM
     konteyner_giris as kg
INNER JOIN is_emri_main as iem on iem.id=kg.is_emri_id
WHERE  kg.status=1 AND kg.cari_key='$cari_key'
");

    if ($sahadaki_konteynerleri_getir > 0) {
        $gidecek_arr = [];
        foreach ($sahadaki_konteynerleri_getir as $item) {
            $id = $item["id"];
            $plaka_id = $item["plaka_id"];
            $cari_id = $item["cari_id"];
            $plaka_bilgi = DB::single_query("SELECT * FROM arac_kartlari WHERE status=1 AND cari_key='$cari_key' AND id='$plaka_id'");
            $cari = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
            $cut_off_tarihi = "";
            if ($item["cut_of_tarihi"] != "0000-00-00 00:00:00") {
                $cut_off_tarihi = date("d/m/Y", strtotime($item["cut_of_tarihi"]));
            }
            $ardiyesiz_giris_tarihi = "";
            if ($item["ardiyesiz_giris_tarihi"] != "0000-00-00 00:00:00") {
                $ardiyesiz_giris_tarihi = date("d/m/Y", strtotime($item["ardiyesiz_giris_tarihi"]));
            }
            $demoraj_tarihi = "";
            if ($item["demoraj_tarihi"] != "0000-00-00 00:00:00") {
                $demoraj_tarihi = date("d/m/Y", strtotime($item["demoraj_tarihi"]));
            }
            $giris_tarihi = date("d/m/Y", strtotime($item["giris_tarihi"]));
            $bos_dolu = "";
            $giris_id = $item["id"];
            $durum_degisti = false;
            $single = DBD::single_query("SELECT * FROM urunleri_konteynere_aktar WHERE status=1 AND cari_key='$cari_key' AND (konteyner_id1='$giris_id' OR konteyner_id2='$giris_id')");
            if ($single > 0) {
                $bos_dolu = "Dolu";
                $durum_degisti = true;
            }
            $single2 = DBD::single_query("SELECT * FROM sahaya_urun_ser WHERE status=1 AND cari_key='$cari_key' AND k_girisid='$giris_id'");
            $single3 = DBD::single_query("SELECT * FROM urunleri_konteynere_aktar WHERE konteyner_urunid='$giris_id'");
            if ($single2 > 0) {
                $bos_dolu = "Boş";
                $durum_degisti = true;
            }
            if ($single3 > 0) {
                $bos_dolu = "Boş";
                $durum_degisti = true;
            }
            if ($durum_degisti == false) {
                $bos_dolu = $item["bos_dolu"];
            }
            $sahadami = DBD::single_query("SELECT * FROM sahaya_konteyner_ser WHERE id='$id' AND status=1");

            if ($sahadami > 0) {


            } else {

                $arr = [

                    'giris_tarihi' => $giris_tarihi,

                    'konteyner_no' => $item["konteyner_no"],

                    'cari_adi' => $cari["cari_adi"],

                    'bulundugu_yer' => "BLOKTA",

                    'referans' => $item["referans"],

                    'beyanname_no' => $item["beyanname_no"],

                    'konteyner_tipi' => $item["konteyner_tipi"],

                    'durumu' => $bos_dolu,

                    'plaka_no' => $plaka_bilgi["plaka_no"],

                    'surucu_adi' => $item["surucu_adi"],

                    'cut_off_tarihi' => $cut_off_tarihi,

                    'ardiyesiz_giris_tarihi' => $ardiyesiz_giris_tarihi,

                    'demoraj_tarihi' => $demoraj_tarihi,

                    'id' => $item["id"],

                ];

                array_push($gidecek_arr, $arr);

            }

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

if ($islem == "giris_yapan_konteynerin_bilgilerini_getir_sql") {

    $id = $_GET["id"];

    $item = DBD::single_query("

SELECT

       kg.*,

       iem.cut_of_tarihi,

       iem.demoraj_tarihi,

       iem.ardiyesiz_giris_tarihi,

       iem.beyanname_no,

       iem.referans_no as referans,

       iem.konteyner_tipi,

       iem.tipi

FROM

     konteyner_giris as kg 

INNER JOIN is_emri_main as iem on iem.id=kg.is_emri_id

WHERE  kg.status=1 AND kg.cari_key='$cari_key' AND kg.id='$id'

");


    if ($item > 0) {

        $plaka_id = $item["plaka_id"];

        $cari_id = $item["cari_id"];

        $plaka_bilgi = DB::single_query("SELECT * FROM arac_kartlari WHERE status=1 AND cari_key='$cari_key' AND id='$plaka_id'");

        $cari = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");


        $cut_off_tarihi = "";

        if ($item["cut_of_tarihi"] != "0000-00-00 00:00:00") {

            $cut_off_tarihi = date("Y-m-d", strtotime($item["cut_of_tarihi"]));

        }

        $ardiyesiz_giris_tarihi = "";

        if ($item["ardiyesiz_giris_tarihi"] != "0000-00-00 00:00:00") {

            $ardiyesiz_giris_tarihi = date("Y-m-d", strtotime($item["ardiyesiz_giris_tarihi"]));

        }

        $demoraj_tarihi = "";

        if ($item["demoraj_tarihi"] != "0000-00-00 00:00:00") {

            $demoraj_tarihi = date("Y-m-d", strtotime($item["demoraj_tarihi"]));

        }

        $giris_tarihi = date("Y-m-d", strtotime($item["giris_tarihi"]));

        $bos_dolu = "";

        $giris_id = $item["id"];

        $durum_degisti = false;

        $single = DBD::single_query("SELECT * FROM urunleri_konteynere_aktar WHERE status=1 AND cari_key='$cari_key' AND (konteyner_id1='$giris_id' OR konteyner_id2='$giris_id')");

        if ($single > 0) {

            $bos_dolu = "Dolu";

            $durum_degisti = true;

        }

        $single2 = DBD::single_query("SELECT * FROM sahaya_urun_ser WHERE status=1 AND cari_key='$cari_key' AND k_girisid='$giris_id'");

        $single3 = DBD::single_query("SELECT * FROM urunleri_konteynere_aktar WHERE konteyner_urunid='$giris_id'");

        if ($single2 > 0) {

            $bos_dolu = "Boş";

            $durum_degisti = true;

        }

        if ($single3 > 0) {

            $bos_dolu = "Boş";

            $durum_degisti = true;

        }

        if ($durum_degisti == false) {

            $bos_dolu = $item["bos_dolu"];

        }

        $sahadami = DBD::single_query("SELECT * FROM sahaya_konteyner_ser WHERE id='$id' AND status=1");
        if ($sahadami > 0) {
            echo 2;
        } else {
            $arr = [
                'giris_tarihi' => $giris_tarihi,
                'konteyner_no' => $item["konteyner_no"],
                'cari_adi' => $cari["cari_adi"],
                'bulundugu_yer' => "BLOKTA",
                'referans' => $item["referans"],
                'tipi' => $item["tipi"],
                'beyanname_no' => $item["beyanname_no"],
                'konteyner_tipi' => $item["konteyner_tipi"],
                'durumu' => $bos_dolu,
                'plaka_no' => $plaka_bilgi["plaka_no"],
                'surucu_adi' => $item["surucu_adi"],
                'cut_off_tarihi' => $cut_off_tarihi,
                'ardiyesiz_giris_tarihi' => $ardiyesiz_giris_tarihi,
                'demoraj_tarihi' => $demoraj_tarihi,
                'id' => $item["id"],
            ];
            if (!empty($arr)) {
                echo json_encode($arr);
            } else {
                echo 2;
            }
        }
    } else {
        echo 2;
    }
}
if ($islem == "konteyner_sahaya_ser_kaydet_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $konteyneri_sahaya_ser = DBD::insert("sahaya_konteyner_ser", $_POST);
    if ($konteyneri_sahaya_ser) {
        echo 500;
    } else {
        echo 1;
    }
}
if ($islem == "sahadaki_konteyneri_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $konteyneri_sahadan_dusur = DBD::update("sahaya_konteyner_ser", "id", $_POST["id"], $_POST);
    if ($konteyneri_sahadan_dusur) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "sahadaki_urunu_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $konteyneri_sahadan_dusur = DBD::update("sahaya_urun_ser", "id", $_POST["id"], $_POST);
    if ($konteyneri_sahadan_dusur) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "secilen_saha_urunu_bilgisini_getir_sql") {
    $id = $_GET["id"];
    $item = DBD::single_query("
SELECT
       kg.giris_tarihi as konteyner_giris,
       ag.giris_tarihi as arac_giris,
       kg.cari_id as konteyner_cari,
       ag.cari_id as arac_cariid,
       kg.konteyner_no,
       kg.plaka_id,
       ag.plaka_no,
       kg.surucu_adi as konteyner_surucu,
       ag.surucu_adi as arac_surucu,
       kg.is_emri_id as konteyner_girisid,
       ag.is_emri_id as arac_girisid,
       sus.birim_id,
       sus.id,
       sus.miktar
FROM
     sahaya_urun_ser as sus 
LEFT JOIN konteyner_giris as kg on kg.id=sus.k_girisid
LEFT JOIN arac_giris as ag on ag.id=sus.giris_id
WHERE sus.status=1 AND sus.cari_key='$cari_key' AND sus.id='$id'");
    if ($item > 0) {
        $giris_tarihi = "";
        if ($item["konteyner_giris"] != null || $item["konteyner_giris"] != "") {
            $giris_tarihi = $item["konteyner_giris"];
        } else {
            $giris_tarihi = $item["arac_giris"];
        }
        $is_emri_id = "";
        if ($item["konteyner_girisid"] != null || $item["konteyner_girisid"] != "") {
            $is_emri_id = $item["konteyner_girisid"];
        } else {
            $is_emri_id = $item["arac_girisid"];
        }
        $is_emri_info = DBD::single_query("SELECT * FROM is_emri_main WHERE id='$is_emri_id'");
        $cari_id = "";
        if ($item["konteyner_cari"] != null || $item["konteyner_cari"] != "") {
            $cari_id = $item["konteyner_cari"];
        } else {
            $cari_id = $item["arac_cariid"];
        }
        $surucu_adi = "";
        if ($item["konteyner_surucu"] != null || $item["konteyner_surucu"] != "") {
            $surucu_adi = $item["konteyner_surucu"];
        } else {
            $surucu_adi = $item["arac_surucu"];
        }
        $plaka_no = "";
        if ($item["plaka_id"] != null || $item["plaka_id"] != "") {
            $plaka_id = $item["plaka_id"];
            $arac = DB::single_query("SELECT plaka_no FROM arac_kartlari WHERE id='$plaka_id'");
            $plaka_no = $arac["plaka_no"];
        } else {
            $plaka_no = $item["plaka_no"];
        }
        $birim_id = $item["birim_id"];
        $birim = DB::single_query("SELECT birim_adi,id FROM birim WHERE id='$birim_id'");

        $cari = DB::single_query("SELECT cari_adi FROM cari WHERE id='$cari_id'");
        $miktar = number_format($item["miktar"], 2);
        if ($giris_tarihi != "0000-00-00 00:00:00") {
            $giris_tarihi = date("d/m/Y", strtotime($giris_tarihi));
        }
        $arr = [
            'giris_tarihi' => $giris_tarihi,
            'cari_adi' => $cari["cari_adi"],
            'konteyner_no' => $item["konteyner_no"],
            'plaka_no' => $plaka_no,
            'surucu_adi' => $surucu_adi,
            'epro_ref' => $is_emri_info["epro_ref"],
            'beyanname_no' => $is_emri_info["beyanname_no"],
            'miktar' => $miktar,
            'birim_adi' => $birim["birim_adi"],
            'birim_id' => $birim["id"],
            'id' => $item["id"],
            'islem' => "<button class='btn btn-sm' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm sahadaki_urunu_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "sahadaki_konteynerleri_getir_sql2") {
    $sahadaki_konteynerleri_getir = DBD::all_data("
SELECT
       kg.*,
       sks.aciklama,
       sks.id as giris_id,
       iem.cut_of_tarihi,
       iem.demoraj_tarihi,
       iem.ardiyesiz_giris_tarihi,
       iem.beyanname_no,
       iem.referans_no as referans,
       iem.cari_id,
       iem.konteyner_tipi
FROM
     sahaya_konteyner_ser AS sks 
INNER JOIN konteyner_giris AS kg on kg.id=sks.giris_id
INNER JOIN is_emri_main as iem on iem.id=kg.is_emri_id
WHERE sks.status=1 AND kg.status=1 AND sks.cari_key='$cari_key' GROUP BY sks.id
");

    if ($sahadaki_konteynerleri_getir > 0) {
        $gidecek_arr = [];
        foreach ($sahadaki_konteynerleri_getir as $item) {
            $plaka_id = $item["plaka_id"];
            $cari_id = $item["cari_id"];
            $plaka_bilgi = DB::single_query("SELECT * FROM arac_kartlari WHERE status=1 AND cari_key='$cari_key' AND id='$plaka_id'");
            $cari = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");

            $cut_off_tarihi = "";
            if ($item["cut_of_tarihi"] == "0000-00-00 00:00:00") {
            } else {
                $cut_off_tarihi = date("d/m/Y", strtotime($item["cut_of_tarihi"]));
            }
            $ardiyesiz_giris_tarihi = "";
            if ($item["ardiyesiz_giris_tarihi"] == "0000-00-00 00:00:00") {
            } else {
                $ardiyesiz_giris_tarihi = date("d/m/Y", strtotime($item["ardiyesiz_giris_tarihi"]));
            }
            $demoraj_tarihi = "";
            if ($item["demoraj_tarihi"] == "0000-00-00 00:00:00") {
            } else {
                $demoraj_tarihi = date("d/m/Y", strtotime($item["demoraj_tarihi"]));
            }
            $giris_tarihi = date("d/m/Y", strtotime($item["giris_tarihi"]));
            $bos_dolu = "";
            $giris_id = $item["id"];
            $durum_degisti = false;
            $single = DBD::single_query("SELECT * FROM urunleri_konteynere_aktar WHERE status=1 AND cari_key='$cari_key' AND (konteyner_id1='$giris_id' OR konteyner_id2='$giris_id')");
            if ($single > 0) {
                $bos_dolu = "Dolu";
                $durum_degisti = true;
            }
            $single2 = DBD::single_query("SELECT * FROM sahaya_urun_ser WHERE status=1 AND cari_key='$cari_key' AND k_girisid='$giris_id'");
            $single3 = DBD::single_query("SELECT * FROM urunleri_konteynere_aktar WHERE konteyner_urunid='$giris_id'");
            if ($single2 > 0) {
                $bos_dolu = "Boş";
                $durum_degisti = true;
            }
            if ($single3 > 0) {
                $bos_dolu = "Boş";
                $durum_degisti = true;
            }
            if ($durum_degisti == false) {
                $bos_dolu = $item["bos_dolu"];
            }
            if ($bos_dolu != "Boş") {

            } else {
                $arr = [
                    'giris_tarihi' => $giris_tarihi,
                    'konteyner_no' => $item["konteyner_no"],
                    'cari_adi' => $cari["cari_adi"],
                    'referans' => $item["referans"],
                    'bulundugu_yer' => "SAHADA",
                    'beyanname_no' => $item["beyanname_no"],
                    'konteyner_tipi' => $item["konteyner_tipi"],
                    'durumu' => $bos_dolu,
                    'plaka_no' => $plaka_bilgi["plaka_no"],
                    'surucu_adi' => $item["surucu_adi"],
                    'cut_off_tarihi' => $cut_off_tarihi,
                    'ardiyesiz_giris_tarihi' => $ardiyesiz_giris_tarihi,
                    'demoraj_tarihi' => $demoraj_tarihi,
                    'id' => $item["id"],
                    'islem' => "<button class='btn btn-sm sahadaki_konteyneri_guncelle_button' data-id='" . $item["giris_id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm sahadaki_konteyneri_sil_button' data-id='" . $item["giris_id"] . "'><i class='fa fa-trash'></i></button>"
                ];
                array_push($gidecek_arr, $arr);
            }
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
if ($islem == "guncellenecek_konteyner_girisleri_getir_sql") {
    $id = $_GET["id"];

    $item = DBD::single_query("
SELECT
       kg.*,
       sks.aciklama,
       sks.id as giris_id,
       iem.cut_of_tarihi,
       iem.demoraj_tarihi,
       iem.ardiyesiz_giris_tarihi,
       iem.beyanname_no,
       iem.referans_no as referans,
       iem.cari_id,
       iem.konteyner_tipi
FROM
     sahaya_konteyner_ser AS sks 
INNER JOIN konteyner_giris AS kg on kg.id=sks.giris_id
INNER JOIN is_emri_main as iem on iem.id=kg.is_emri_id
WHERE sks.status=1 AND kg.status=1 AND sks.cari_key='$cari_key' AND kg.id='$id' GROUP BY sks.id
");

    if ($item > 0) {
        $plaka_id = $item["plaka_id"];
        $cari_id = $item["cari_id"];
        $plaka_bilgi = DB::single_query("SELECT * FROM arac_kartlari WHERE status=1 AND cari_key='$cari_key' AND id='$plaka_id'");
        $cari = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");

        $cut_off_tarihi = "";
        if ($item["cut_of_tarihi"] == "0000-00-00 00:00:00") {
        } else {
            $cut_off_tarihi = date("d/m/Y", strtotime($item["cut_of_tarihi"]));
        }
        $ardiyesiz_giris_tarihi = "";
        if ($item["ardiyesiz_giris_tarihi"] == "0000-00-00 00:00:00") {
        } else {
            $ardiyesiz_giris_tarihi = date("d/m/Y", strtotime($item["ardiyesiz_giris_tarihi"]));
        }
        $demoraj_tarihi = "";
        if ($item["demoraj_tarihi"] == "0000-00-00 00:00:00") {
        } else {
            $demoraj_tarihi = date("d/m/Y", strtotime($item["demoraj_tarihi"]));
        }
        $giris_tarihi = date("d/m/Y", strtotime($item["giris_tarihi"]));
        $bos_dolu = "";
        $giris_id = $item["id"];
        $durum_degisti = false;
        $single = DBD::single_query("SELECT * FROM urunleri_konteynere_aktar WHERE status=1 AND cari_key='$cari_key' AND (konteyner_id1='$giris_id' OR konteyner_id2='$giris_id')");
        if ($single > 0) {
            $bos_dolu = "Dolu";
            $durum_degisti = true;
        }
        $single2 = DBD::single_query("SELECT * FROM sahaya_urun_ser WHERE status=1 AND cari_key='$cari_key' AND k_girisid='$giris_id'");
        $single3 = DBD::single_query("SELECT * FROM urunleri_konteynere_aktar WHERE konteyner_urunid='$giris_id'");
        if ($single2 > 0) {
            $bos_dolu = "Boş";
            $durum_degisti = true;
        }
        if ($single3 > 0) {
            $bos_dolu = "Boş";
            $durum_degisti = true;
        }
        if ($durum_degisti == false) {
            $bos_dolu = $item["bos_dolu"];
        }
        if ($bos_dolu != "Boş") {

        } else {
            $arr = [
                'giris_tarihi' => $giris_tarihi,
                'konteyner_no' => $item["konteyner_no"],
                'cari_adi' => $cari["cari_adi"],
                'referans' => $item["referans"],
                'bulundugu_yer' => "SAHADA",
                'beyanname_no' => $item["beyanname_no"],
                'konteyner_tipi' => $item["konteyner_tipi"],
                'durumu' => $bos_dolu,
                'plaka_no' => $plaka_bilgi["plaka_no"],
                'surucu_adi' => $item["surucu_adi"],
                'cut_off_tarihi' => $cut_off_tarihi,
                'ardiyesiz_giris_tarihi' => $ardiyesiz_giris_tarihi,
                'demoraj_tarihi' => $demoraj_tarihi,
                'id' => $item["id"],
                'islem' => "<button class='btn btn-sm sahadaki_konteyneri_guncelle_button' data-id='" . $item["giris_id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm sahadaki_konteyneri_sil_button' data-id='" . $item["giris_id"] . "'><i class='fa fa-trash'></i></button>"
            ];
        }
        if (!empty($arr)) {
            echo json_encode($arr);
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "konteynere_urun_aktar_kaydet_sql") {
    $geldigi_yer = $_POST["geldigi_yer"];
    unset($_POST["geldigi_yer"]);
    if ($geldigi_yer != null){
        if ($geldigi_yer == "sahadan"){
            $urun_id = $_POST["urun_id"];
            $arr = [
                'status' => 2
            ];
            $sahadaki_urunu_sil = DBD::update("sahaya_urun_ser", "id", $urun_id, $arr);
        }else{
            $urun_id = $_POST["urun_id"];
            $arr = [
                'status' => 2
            ];
            $sahadaki_urunu_sil = DBD::update("arac_giris", "id", $urun_id, $arr);
        }
    }
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $konteyner_urun_aktar = DBD::insert("urunleri_konteynere_aktar", $_POST);
    if ($konteyner_urun_aktar) {
        echo 2;
    } else {
        echo 1;
    }
}
if ($islem == "konteynere_aktarilan_urunleri_getir_sql") {
    $konteynere_aktarilan_urunler = DBD::all_data("
SELECT 
       *
FROM
     urunleri_konteynere_aktar
WHERE
      status=1 
AND 
      cari_key='$cari_key'");

    if ($konteynere_aktarilan_urunler > 0) {
        $gidecek_arr = [];
        foreach ($konteynere_aktarilan_urunler as $item) {
            $is_emri_id = "";
            $giris_tarihi = "";
            $plaka_no = "";
            if ($item["konteyner_urunid"] != 0) {
                $konteyner_id = $item["konteyner_urunid"];
                $konteyner_giris_infos = DBD::single_query("SELECT * FROM konteyner_giris WHERE  cari_key='$cari_key' AND id='$konteyner_id'");
                $is_emri_id = $konteyner_giris_infos["is_emri_id"];
                $giris_tarihi = $konteyner_giris_infos["giris_tarihi"];
                $plaka_id = $konteyner_giris_infos["plaka_id"];
                $arac = DB::single_query("SELECT plaka_no FROM arac_kartlari WHERE status=1 AND cari_key='$cari_key' AND id='$plaka_id'");
                $plaka_no = $arac["plaka_no"];
            } else {
                $plaka_id = $item["urun_id"];
                $arac_infos = DBD::single_query("SELECT * FROM arac_giris WHERE cari_key='$cari_key' AND id='$plaka_id'");
                $is_emri_id = $arac_infos["is_emri_id"];
                $giris_tarihi = $item["giris_tarihi"];
                $plaka_no = $arac_infos["plaka_no"];
            }

            $is_emri_bilgileri = DBD::single_query("SELECT * FROM is_emri_main WHERE status=1 AND cari_key='$cari_key' AND id='$is_emri_id'");
            $giris_tarihi = date("d/m/Y", strtotime($giris_tarihi));
            $tarih = date("d/m/Y", strtotime($item["tarih"]));
            $cari_id = $is_emri_bilgileri["cari_id"];

            $cari = DB::single_query("SELECT cari_adi FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
            $toplam_miktar = $item["yuklenen_miktar1"] + $item["yuklenen_miktar2"];
            $toplam_miktar = number_format($toplam_miktar, 2);
            $yuklenen_miktar1 = number_format($item["yuklenen_miktar1"], 2);
            $yuklenen_miktar2 = number_format($item["yuklenen_miktar2"], 2);
            $konteyner_no1 = $item["konteyner_id1"];
            $konteyner_no2 = $item["konteyner_id2"];
            $giris1 = DBD::single_query("SELECT konteyner_no FROM konteyner_giris WHERE id='$konteyner_no1'");
            $giris2 = DBD::single_query("SELECT konteyner_no FROM konteyner_giris WHERE id='$konteyner_no2'");
            $birim_id1 = $item["birim_id1"];
            $birim_id2 = $item["birim_id2"];
            $birim1 = DB::single_query("SELECT birim_adi FROM birim WHERE id='$birim_id1'");
            $birim2 = DB::single_query("SELECT birim_adi FROM birim WHERE id='$birim_id2'");

            $arr = [
                'giris_tarihi' => $giris_tarihi,
                'tarih' => $tarih,
                'cari_adi' => $cari["cari_adi"],
                'plaka_no' => $plaka_no,
                'miktar' => $toplam_miktar,
                'epro_ref' => $is_emri_bilgileri["epro_ref"],
                'referans_no' => $is_emri_bilgileri["referans_no"],
                'beyanname_no' => $is_emri_bilgileri["beyanname_no"],
                'konteyner_no1' => $giris1["konteyner_no"],
                'konteyner_no2' => $giris2["konteyner_no"],
                'yuklenen_miktar1' => $yuklenen_miktar1,
                'yuklenen_miktar2' => $yuklenen_miktar2,
                'birim_adi1' => $birim1["birim_adi"],
                'birim_adi2' => $birim2["birim_adi"],
                'islem' => "<button class='btn btn-sm' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm konteynere_aktarilan_kaydi_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "aktarilan_konteyneri_sil_sql") {
    $id = $_POST["id"];
    $bilgiler = DBD::single_query("SELECT * FROM urunleri_konteynere_aktar WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $kaydi_sil = DBD::update("urunleri_konteynere_aktar", "id", $_POST["id"], $_POST);
    if ($kaydi_sil) {
        $arr = [
            'status' => 1
        ];
        $urunu_sahaya_ser = DBD::update("sahaya_urun_ser", "id", $bilgiler["urun_id"], $arr);
        if ($urunu_sahaya_ser) {
            echo 1;
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "sahadaki_araclari_getir_sql"){
    $sahadaki_urunler = DBD::all_data("
SELECT
       giris_tarihi,
       cari_id,
       plaka_no,
       surucu_adi,
       is_emri_id,
       id,
       surucu_tel,
       miktar
FROM arac_giris
WHERE status=1 AND cari_key='$cari_key'");
    if ($sahadaki_urunler > 0) {
        $gidecek_arr = [];
        foreach ($sahadaki_urunler as $item) {
            $id = $item["id"];
            $giris_tarihi = $item["giris_tarihi"];
            $is_emri_id = $item["is_emri_id"];
            $is_emri_info = DBD::single_query("SELECT * FROM is_emri_main WHERE id='$is_emri_id'");
            $cari_id = $item["cari_id"];
            $surucu_adi = $item["surucu_adi"];
            $plaka_no = $item["plaka_no"];
            $birim_id = $is_emri_info["birim_id"];
            $birim = DB::single_query("SELECT birim_adi FROM birim WHERE id='$birim_id'");
            $cari = DB::single_query("SELECT cari_adi FROM cari WHERE id='$cari_id'");
            $miktar = number_format($item["miktar"], 2);
            if ($giris_tarihi != "0000-00-00 00:00:00") {
                $giris_tarihi = date("d/m/Y", strtotime($giris_tarihi));
            }
            $sahaya_serilmismi = DBD::single_query("SELECT id FROM sahaya_urun_ser WHERE giris_id='$id'");
            if ($sahaya_serilmismi > 0) {

            } else {
                $arr = [
                    'giris_tarihi' => $giris_tarihi,
                    'cari_adi' => $cari["cari_adi"],
                    'konteyner_no' => "",
                    'id' => $item["id"],
                    'plaka_no' => $plaka_no,
                    'surucu_adi' => $surucu_adi,
                    'surucu_tel' => $item["surucu_tel"],
                    'epro_ref' => $is_emri_info["epro_ref"],
                    'referans_no' => $is_emri_info["referans_no"],
                    'beyanname_no' => $is_emri_info["beyanname_no"],
                    'miktar' => $miktar,
                    'birim_adi' => $birim["birim_adi"],
                    'islem' => "<button class='btn btn-sm' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm sahadaki_urunu_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
                ];
                array_push($gidecek_arr, $arr);
            }
        }
    }

    if (!empty($gidecek_arr)) {
        echo json_encode($gidecek_arr);
    } else {
        echo 2;
    }
}