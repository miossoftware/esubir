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

if ($islem == "mal_cinslerini_getir_sql"){
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
if ($islem == "birimleri_getir_sql") {
    $birimler = DB::all_data("SELECT * FROM birim  WHERE status=1 AND cari_key='$cari_key'");
    if ($birimler > 0) {
        echo json_encode($birimler);
    } else {
        echo 2;
    }
}
if ($islem == "son_epro_referans_sql") {
    $ay_bas = date("Y-m-01");
    $ay_sonu = date("Y-m-t");
    $siparisler = DBD::single_query("
SELECT
       *
FROM
     is_emri_main
WHERE status=1 AND cari_key='$cari_key' AND insert_datetime BETWEEN '$ay_bas 00:00:00' AND '$ay_sonu 23:59:59' ORDER BY id DESC LIMIT 1");
    if ($siparisler > 0) {
        echo json_encode($siparisler);
    } else {
        echo 2;
    }
}
if ($islem == "is_emri_kaydet_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $urun_arr = $_POST["urun_arr"];
    unset($_POST["urun_arr"]);
    $is_emri_ekle = DBD::insert("is_emri_main", $_POST);
    if ($is_emri_ekle) {
        echo 500;
    } else {
        $son_eklenen = DBD::single_query("SELECT id FROM is_emri_main where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        foreach ($urun_arr as $item) {
            $item["insert_userid"] = $_SESSION["user_id"];
            $item["insert_datetime"] = date("Y-m-d H:i:s");
            $item["cari_key"] = $cari_key;
            $item["sube_key"] = $sube_key;
            $item["is_emri_id"] = $son_eklenen["id"];
            $ekle = DBD::insert("is_emri_urunler", $item);
        }
        if ($ekle) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "ozmal_is_emirlerini_getir_sql") {
    $tum_is_emirleri = DBD::all_data("SELECT * FROM is_emri_main WHERE status=1 AND cari_key='$cari_key' AND depo_cariid=0");
    if ($tum_is_emirleri > 0) {
        $gidecek_arr = [];
        foreach ($tum_is_emirleri as $item) {
            $siparis_tarihi = "";
            if ($item["siparis_tarihi"] != "0000-00-00 00:00:00") {
                $siparis_tarihi = date("d/m/Y", strtotime($item["siparis_tarihi"]));
            }
            $demoraj_tarihi = "";
            if ($item["demoraj_tarihi"] != "0000-00-00 00:00:00") {
                $demoraj_tarihi = date("d/m/Y", strtotime($item["demoraj_tarihi"]));
            }
            $ardiyesiz_giris_tarihi = "";
            if ($item["ardiyesiz_giris_tarihi"] != "0000-00-00 00:00:00") {
                $ardiyesiz_giris_tarihi = date("d/m/Y", strtotime($item["ardiyesiz_giris_tarihi"]));
            }
            $cut_of_tarihi = "";
            if ($item["cut_of_tarihi"] != "0000-00-00 00:00:00") {
                $cut_of_tarihi = date("d/m/Y", strtotime($item["cut_of_tarihi"]));
            }
            $cari_id = $item["cari_id"];
            $cari = DB::single_query("SELECT cari_adi FROM cari WHERE id='$cari_id'");
            $stok_id = $item["hizmet_id"];
            $hizmet = DB::single_query("SELECT stok_adi FROM stok WHERE id='$stok_id'");
            $miktar = number_format($item["miktar"], 2);
            $birim_id = $item["birim_id"];
            $birim = DB::single_query("SELECT birim_adi FROM birim WHERE id='$birim_id'");
            $bos_dolu = '';
            if ($item["tipi"] == "İTHALAT") {
                $bos_dolu = "Dolu";
            } else {
                $bos_dolu = "Boş";
            }
            $id = $item["id"];
            $giris_sayisi = DBD::single_query("SELECT COUNT(id) as giris_sayisi FROM konteyner_giris WHERE status!=0 AND cari_key='$cari_key' AND bos_dolu='$bos_dolu' AND is_emri_id='$id'");

            $cikis_sayisi = DBD::single_query("
SELECT
       COUNT(kc.id) as cikis_sayisi 
FROM 
     konteyner_cikis as kc
INNER JOIN konteyner_giris AS kg on kg.id=kc.konteyner_id
WHERE
kc.status=1 AND kc.cari_key='$cari_key' AND kg.bos_dolu='$bos_dolu' AND kg.is_emri_id='$id'
");

            $arr = [
                'tipi' => $item["tipi"],
                'siparis_tarihi' => $siparis_tarihi,
                'cari_adi' => $cari["cari_adi"],
                'konteyner_tipi' => $item["konteyner_tipi"],
                'konteyner_sayisi' => $item["konteyner_sayisi"],
                'gelen_konteyner' => $giris_sayisi["giris_sayisi"],
                'tamamlanan_konteyner' => $cikis_sayisi["cikis_sayisi"],
                'hizmet_adi' => $hizmet["stok_adi"],
                'miktar' => $miktar,
                'birim' => $birim["birim_adi"],
                'beyanname_no' => $item["beyanname_no"],
                'aciklama' => $item["aciklama"],
                'id' => $item["id"],
                'epro_ref' => $item["epro_ref"],
                'demoraj_tarihi' => $demoraj_tarihi,
                'referans_no' => $item["referans_no"],
                'acente' => $item["acente"],
                'ardiyesiz_giris_tarihi' => $ardiyesiz_giris_tarihi,
                'cut_of_tarihi' => $cut_of_tarihi,
                'alim_yeri' => $item["kont_alim_yeri"],
                'teslim_yeri' => $item["kont_teslim_yeri"],
                'islem' => "<button data-id='" . $item["id"] . "' class='btn btn-sm is_emrini_guncelle_button' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm is_emrini_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "kiralik_is_emirlerini_getir_sql") {
    $tum_is_emirleri = DBD::all_data("SELECT * FROM is_emri_main WHERE status=1 AND cari_key='$cari_key' AND depo_cariid!=0");
    if ($tum_is_emirleri > 0) {
        $gidecek_arr = [];
        foreach ($tum_is_emirleri as $item) {
            $siparis_tarihi = "";
            if ($item["siparis_tarihi"] != "0000-00-00 00:00:00") {
                $siparis_tarihi = date("d/m/Y", strtotime($item["siparis_tarihi"]));
            }
            $demoraj_tarihi = "";
            if ($item["demoraj_tarihi"] != "0000-00-00 00:00:00") {
                $demoraj_tarihi = date("d/m/Y", strtotime($item["demoraj_tarihi"]));
            }
            $ardiyesiz_giris_tarihi = "";
            if ($item["ardiyesiz_giris_tarihi"] != "0000-00-00 00:00:00") {
                $ardiyesiz_giris_tarihi = date("d/m/Y", strtotime($item["ardiyesiz_giris_tarihi"]));
            }
            $cut_of_tarihi = "";
            if ($item["cut_of_tarihi"] != "0000-00-00 00:00:00") {
                $cut_of_tarihi = date("d/m/Y", strtotime($item["cut_of_tarihi"]));
            }
            $cari_id = $item["cari_id"];
            $cari = DB::single_query("SELECT cari_adi FROM cari WHERE id='$cari_id'");
            $stok_id = $item["hizmet_id"];
            $hizmet = DB::single_query("SELECT stok_adi FROM stok WHERE id='$stok_id'");
            $miktar = number_format($item["miktar"], 2);
            $birim_id = $item["birim_id"];
            $birim = DB::single_query("SELECT birim_adi FROM birim WHERE id='$birim_id'");
            $bos_dolu = '';
            if ($item["tipi"] == "İTHALAT") {
                $bos_dolu = "Dolu";
            } else {
                $bos_dolu = "Boş";
            }
            $id = $item["id"];
            $giris_sayisi = DBD::single_query("SELECT COUNT(id) as giris_sayisi FROM konteyner_giris WHERE status!=0 AND cari_key='$cari_key' AND bos_dolu='$bos_dolu' AND is_emri_id='$id'");

            $cikis_sayisi = DBD::single_query("
SELECT
       COUNT(kc.id) as cikis_sayisi 
FROM 
     konteyner_cikis as kc
INNER JOIN konteyner_giris AS kg on kg.id=kc.konteyner_id
WHERE
kc.status=1 AND kc.cari_key='$cari_key' AND kg.bos_dolu='$bos_dolu' AND kg.is_emri_id='$id'
");

            $arr = [
                'tipi' => $item["tipi"],
                'siparis_tarihi' => $siparis_tarihi,
                'cari_adi' => $cari["cari_adi"],
                'konteyner_tipi' => $item["konteyner_tipi"],
                'konteyner_sayisi' => $item["konteyner_sayisi"],
                'gelen_konteyner' => $giris_sayisi["giris_sayisi"],
                'tamamlanan_konteyner' => $cikis_sayisi["cikis_sayisi"],
                'hizmet_adi' => $hizmet["stok_adi"],
                'miktar' => $miktar,
                'birim' => $birim["birim_adi"],
                'beyanname_no' => $item["beyanname_no"],
                'aciklama' => $item["aciklama"],
                'id' => $item["id"],
                'epro_ref' => $item["epro_ref"],
                'demoraj_tarihi' => $demoraj_tarihi,
                'referans_no' => $item["referans_no"],
                'acente' => $item["acente"],
                'ardiyesiz_giris_tarihi' => $ardiyesiz_giris_tarihi,
                'cut_of_tarihi' => $cut_of_tarihi,
                'alim_yeri' => $item["kont_alim_yeri"],
                'teslim_yeri' => $item["kont_teslim_yeri"],
                'islem' => "<button data-id='" . $item["id"] . "' class='btn btn-sm is_emrini_guncelle_button' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm is_emrini_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "tum_is_emirlerini_getir_sql") {
    $ek = "";
    if (isset($_GET["cari_id"])) {
        $cari_id = $_GET["cari_id"];
        if ($cari_id != "") {
            $ek = " AND (depo_cariid='$cari_id' OR cari_id='$cari_id')";
        }
    }
    $tum_is_emirleri = DBD::all_data("SELECT * FROM is_emri_main WHERE status=1 AND cari_key='$cari_key' $ek");
    if ($tum_is_emirleri > 0) {
        $gidecek_arr = [];
        foreach ($tum_is_emirleri as $item) {
            $siparis_tarihi = "";
            if ($item["siparis_tarihi"] != "0000-00-00 00:00:00") {
                $siparis_tarihi = date("d/m/Y", strtotime($item["siparis_tarihi"]));
            }
            $demoraj_tarihi = "";
            if ($item["demoraj_tarihi"] != "0000-00-00 00:00:00") {
                $demoraj_tarihi = date("d/m/Y", strtotime($item["demoraj_tarihi"]));
            }
            $ardiyesiz_giris_tarihi = "";
            if ($item["ardiyesiz_giris_tarihi"] != "0000-00-00 00:00:00") {
                $ardiyesiz_giris_tarihi = date("d/m/Y", strtotime($item["ardiyesiz_giris_tarihi"]));
            }
            $cut_of_tarihi = "";
            if ($item["cut_of_tarihi"] != "0000-00-00 00:00:00") {
                $cut_of_tarihi = date("d/m/Y", strtotime($item["cut_of_tarihi"]));
            }
            $cari_id = $item["cari_id"];
            $cari = DB::single_query("SELECT cari_adi FROM cari WHERE id='$cari_id'");
            $stok_id = $item["hizmet_id"];
            $hizmet = DB::single_query("SELECT stok_adi FROM stok WHERE id='$stok_id'");
            $miktar = number_format($item["miktar"], 2);
            $birim_id = $item["birim_id"];
            $birim = DB::single_query("SELECT birim_adi FROM birim WHERE id='$birim_id'");
            $bos_dolu = '';
            if ($item["tipi"] == "İTHALAT") {
                $bos_dolu = "Dolu";
            } else {
                $bos_dolu = "Boş";
            }
            $id = $item["id"];
            $giris_sayisi = DBD::single_query("SELECT COUNT(id) as giris_sayisi FROM konteyner_giris WHERE status!=0 AND cari_key='$cari_key' AND bos_dolu='$bos_dolu' AND is_emri_id='$id'");

            $cikis_sayisi = DBD::single_query("
SELECT
       COUNT(kc.id) as cikis_sayisi 
FROM 
     konteyner_cikis as kc
INNER JOIN konteyner_giris AS kg on kg.id=kc.konteyner_id
WHERE
kc.status=1 AND kc.cari_key='$cari_key' AND kg.bos_dolu='$bos_dolu'
");

            $arr = [
                'tipi' => $item["tipi"],
                'siparis_tarihi' => $siparis_tarihi,
                'cari_adi' => $cari["cari_adi"],
                'konteyner_tipi' => $item["konteyner_tipi"],
                'konteyner_sayisi' => $item["konteyner_sayisi"],
                'gelen_konteyner' => $giris_sayisi["giris_sayisi"],
                'tamamlanan_konteyner' => $cikis_sayisi["cikis_sayisi"],
                'hizmet_adi' => $hizmet["stok_adi"],
                'miktar' => $miktar,
                'birim' => $birim["birim_adi"],
                'beyanname_no' => $item["beyanname_no"],
                'aciklama' => $item["aciklama"],
                'id' => $item["id"],
                'epro_ref' => $item["epro_ref"],
                'demoraj_tarihi' => $demoraj_tarihi,
                'referans_no' => $item["referans_no"],
                'acente' => $item["acente"],
                'ardiyesiz_giris_tarihi' => $ardiyesiz_giris_tarihi,
                'cut_of_tarihi' => $cut_of_tarihi,
                'alim_yeri' => $item["kont_alim_yeri"],
                'teslim_yeri' => $item["kont_teslim_yeri"],
                'islem' => "<button data-id='" . $item["id"] . "' class='btn btn-sm is_emrini_guncelle_button' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm is_emrini_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "tum_is_emirlerini_getir_sql3") {
    $ek = "";
    if (isset($_GET["cari_id"])) {
        $cari_id = $_GET["cari_id"];
        if ($cari_id != "") {
            $ek = " AND (depo_cariid='$cari_id' OR cari_id='$cari_id')";
        }
    }
    $tum_is_emirleri = DBD::all_data("SELECT * FROM is_emri_main WHERE status=1 AND tipi='İHRACAT' AND cari_key='$cari_key' $ek");
    if ($tum_is_emirleri > 0) {
        $gidecek_arr = [];
        foreach ($tum_is_emirleri as $item) {
            $siparis_tarihi = "";
            if ($item["siparis_tarihi"] != "0000-00-00 00:00:00") {
                $siparis_tarihi = date("d/m/Y", strtotime($item["siparis_tarihi"]));
            }
            $demoraj_tarihi = "";
            if ($item["demoraj_tarihi"] != "0000-00-00 00:00:00") {
                $demoraj_tarihi = date("d/m/Y", strtotime($item["demoraj_tarihi"]));
            }
            $ardiyesiz_giris_tarihi = "";
            if ($item["ardiyesiz_giris_tarihi"] != "0000-00-00 00:00:00") {
                $ardiyesiz_giris_tarihi = date("d/m/Y", strtotime($item["ardiyesiz_giris_tarihi"]));
            }
            $cut_of_tarihi = "";
            if ($item["cut_of_tarihi"] != "0000-00-00 00:00:00") {
                $cut_of_tarihi = date("d/m/Y", strtotime($item["cut_of_tarihi"]));
            }
            $cari_id = $item["cari_id"];
            $cari = DB::single_query("SELECT cari_adi FROM cari WHERE id='$cari_id'");
            $stok_id = $item["hizmet_id"];
            $hizmet = DB::single_query("SELECT stok_adi FROM stok WHERE id='$stok_id'");
            $miktar = number_format($item["miktar"], 2);
            $birim_id = $item["birim_id"];
            $birim = DB::single_query("SELECT birim_adi FROM birim WHERE id='$birim_id'");
            $bos_dolu = '';
            if ($item["tipi"] == "İTHALAT") {
                $bos_dolu = "Dolu";
            } else {
                $bos_dolu = "Boş";
            }
            $id = $item["id"];
            $giris_sayisi = DBD::single_query("SELECT COUNT(id) as giris_sayisi FROM konteyner_giris WHERE status!=0 AND cari_key='$cari_key' AND bos_dolu='$bos_dolu' AND is_emri_id='$id'");

            $cikis_sayisi = DBD::single_query("
SELECT
       COUNT(kc.id) as cikis_sayisi 
FROM 
     konteyner_cikis as kc
INNER JOIN konteyner_giris AS kg on kg.id=kc.konteyner_id
WHERE
kc.status=1 AND kc.cari_key='$cari_key' AND kg.bos_dolu='$bos_dolu'
");

            $arr = [
                'tipi' => $item["tipi"],
                'siparis_tarihi' => $siparis_tarihi,
                'cari_adi' => $cari["cari_adi"],
                'konteyner_tipi' => $item["konteyner_tipi"],
                'konteyner_sayisi' => $item["konteyner_sayisi"],
                'gelen_konteyner' => $giris_sayisi["giris_sayisi"],
                'tamamlanan_konteyner' => $cikis_sayisi["cikis_sayisi"],
                'hizmet_adi' => $hizmet["stok_adi"],
                'miktar' => $miktar,
                'birim' => $birim["birim_adi"],
                'beyanname_no' => $item["beyanname_no"],
                'aciklama' => $item["aciklama"],
                'id' => $item["id"],
                'epro_ref' => $item["epro_ref"],
                'demoraj_tarihi' => $demoraj_tarihi,
                'referans_no' => $item["referans_no"],
                'acente' => $item["acente"],
                'ardiyesiz_giris_tarihi' => $ardiyesiz_giris_tarihi,
                'cut_of_tarihi' => $cut_of_tarihi,
                'alim_yeri' => $item["kont_alim_yeri"],
                'teslim_yeri' => $item["kont_teslim_yeri"],
                'islem' => "<button data-id='" . $item["id"] . "' class='btn btn-sm is_emrini_guncelle_button' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm is_emrini_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "tum_is_emirlerini_getir_sql2") {
    $ek = "";
    if (isset($_GET["cari_id"])) {
        $cari_id = $_GET["cari_id"];
        if ($cari_id != "") {
            $ek = " AND (depo_cariid='$cari_id' OR cari_id='$cari_id')";
        }
    }
    $tum_is_emirleri = DBD::all_data("SELECT * FROM is_emri_main WHERE status=1 AND cari_key='$cari_key' AND tipi='İTHALAT' $ek");
    if ($tum_is_emirleri > 0) {
        $gidecek_arr = [];
        foreach ($tum_is_emirleri as $item) {
            $siparis_tarihi = "";
            if ($item["siparis_tarihi"] != "0000-00-00 00:00:00") {
                $siparis_tarihi = date("d/m/Y", strtotime($item["siparis_tarihi"]));
            }
            $demoraj_tarihi = "";
            if ($item["demoraj_tarihi"] != "0000-00-00 00:00:00") {
                $demoraj_tarihi = date("d/m/Y", strtotime($item["demoraj_tarihi"]));
            }
            $ardiyesiz_giris_tarihi = "";
            if ($item["ardiyesiz_giris_tarihi"] != "0000-00-00 00:00:00") {
                $ardiyesiz_giris_tarihi = date("d/m/Y", strtotime($item["ardiyesiz_giris_tarihi"]));
            }
            $cut_of_tarihi = "";
            if ($item["cut_of_tarihi"] != "0000-00-00 00:00:00") {
                $cut_of_tarihi = date("d/m/Y", strtotime($item["cut_of_tarihi"]));
            }
            $cari_id = $item["cari_id"];
            $cari = DB::single_query("SELECT cari_adi FROM cari WHERE id='$cari_id'");
            $stok_id = $item["hizmet_id"];
            $hizmet = DB::single_query("SELECT stok_adi FROM stok WHERE id='$stok_id'");
            $miktar = number_format($item["miktar"], 2);
            $birim_id = $item["birim_id"];
            $birim = DB::single_query("SELECT birim_adi FROM birim WHERE id='$birim_id'");
            $bos_dolu = '';
            if ($item["tipi"] == "İTHALAT") {
                $bos_dolu = "Dolu";
            } else {
                $bos_dolu = "Boş";
            }
            $id = $item["id"];
            $giris_sayisi = DBD::single_query("SELECT COUNT(id) as giris_sayisi FROM konteyner_giris WHERE status!=0 AND cari_key='$cari_key' AND bos_dolu='$bos_dolu' AND is_emri_id='$id'");

            $cikis_sayisi = DBD::single_query("
SELECT
       COUNT(kc.id) as cikis_sayisi 
FROM 
     konteyner_cikis as kc
INNER JOIN konteyner_giris AS kg on kg.id=kc.konteyner_id
WHERE
kc.status=1 AND kc.cari_key='$cari_key' AND kg.bos_dolu='$bos_dolu'
");
            $arr = [
                'tipi' => $item["tipi"],
                'siparis_tarihi' => $siparis_tarihi,
                'cari_adi' => $cari["cari_adi"],
                'konteyner_tipi' => $item["konteyner_tipi"],
                'konteyner_sayisi' => $item["konteyner_sayisi"],
                'gelen_konteyner' => $giris_sayisi["giris_sayisi"],
                'tamamlanan_konteyner' => $cikis_sayisi["cikis_sayisi"],
                'hizmet_adi' => $hizmet["stok_adi"],
                'miktar' => $miktar,
                'birim' => $birim["birim_adi"],
                'beyanname_no' => $item["beyanname_no"],
                'aciklama' => $item["aciklama"],
                'id' => $item["id"],
                'epro_ref' => $item["epro_ref"],
                'demoraj_tarihi' => $demoraj_tarihi,
                'referans_no' => $item["referans_no"],
                'acente' => $item["acente"],
                'ardiyesiz_giris_tarihi' => $ardiyesiz_giris_tarihi,
                'cut_of_tarihi' => $cut_of_tarihi,
                'alim_yeri' => $item["kont_alim_yeri"],
                'teslim_yeri' => $item["kont_teslim_yeri"],
                'islem' => "<button data-id='" . $item["id"] . "' class='btn btn-sm is_emrini_guncelle_button' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm is_emrini_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "is_emrini_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $sil = DBD::update("is_emri_main", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "is_emrinin_ana_bilgilerini_getir_sql") {
    $id = $_GET["id"];
    $item = DBD::single_query("SELECT * FROM is_emri_main WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    if ($item > 0) {
        $siparis_tarihi = "";
        if ($item["siparis_tarihi"] != "0000-00-00 00:00:00") {
            $siparis_tarihi = date("Y-m-d", strtotime($item["siparis_tarihi"]));
        }
        $demoraj_tarihi = "";
        if ($item["demoraj_tarihi"] != "0000-00-00 00:00:00") {
            $demoraj_tarihi = date("Y-m-d", strtotime($item["demoraj_tarihi"]));
        }
        $ardiyesiz_giris_tarihi = "";
        if ($item["ardiyesiz_giris_tarihi"] != "0000-00-00 00:00:00") {
            $ardiyesiz_giris_tarihi = date("Y-m-d", strtotime($item["ardiyesiz_giris_tarihi"]));
        }
        $cut_of_tarihi = "";
        if ($item["cut_of_tarihi"] != "0000-00-00 00:00:00") {
            $cut_of_tarihi = date("Y-m-d", strtotime($item["cut_of_tarihi"]));
        }
        $cari_id = $item["cari_id"];
        $cari = DB::single_query("SELECT * FROM cari WHERE id='$cari_id'");
        $cari_id2 = $item["depo_cariid"];
        $cari2 = DB::single_query("SELECT * FROM cari WHERE id='$cari_id2'");
        $stok_id = $item["hizmet_id"];
        $hizmet = DB::single_query("SELECT stok_adi FROM stok WHERE id='$stok_id'");
        $birim_id = $item["birim_id"];
        $birim = DB::single_query("SELECT birim_adi FROM birim WHERE id='$birim_id'");


        $arr = [
            'tipi' => $item["tipi"],
            'siparis_tarihi' => $siparis_tarihi,
            'cari_adi' => $cari["cari_adi"],
            'depo_cari' => $cari2["cari_adi"],
            'cari_kodu' => $cari["cari_kodu"],
            'vergi_dairesi' => $cari["vergi_dairesi"],
            'vergi_no' => $cari["vergi_no"],
            'cari_id' => $item["cari_id"],
            'konteyner_tipi' => $item["konteyner_tipi"],
            'konteyner_sayisi' => $item["konteyner_sayisi"],
            'gelen_konteyner' => 0,
            'tamamlanan_konteyner' => 0,
            'hizmet_adi' => $hizmet["stok_adi"],
            'hizmet_id' => $item["hizmet_id"],
            'epro_ref' => $item["epro_ref"],
            'forklift_turu' => $item["forklift_turu"],
            'aciklama' => $item["aciklama"],
            'miktar' => $item["miktar"],
            'urun_adi' => $item["urun_adi"],
            'urun_id' => $item["urun_id"],
            'birim_id' => $birim_id,
            'beyanname_no' => $item["beyanname_no"],
            'demoraj_tarihi' => $demoraj_tarihi,
            'referans_no' => $item["referans_no"],
            'depo_bedeli' => $item["depo_bedeli"],
            'tasima_bedeli' => $item["tasima_bedeli"],
            'kont_alim_yeri' => $item["kont_alim_yeri"],
            'kont_teslim_yeri' => $item["kont_teslim_yeri"],
            'acente' => $item["acente"],
            'depo_cariid' => $item["depo_cariid"],
            'ardiyesiz_giris_tarihi' => $ardiyesiz_giris_tarihi,
            'cut_of_tarihi' => $cut_of_tarihi,
            'alim_yeri' => $item["kont_alim_yeri"],
            'teslim_yeri' => $item["kont_teslim_yeri"],
            'islem' => "<button data-id='" . $item["id"] . "' class='btn btn-sm is_emrini_guncelle_button' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm is_emrini_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "is_emrina_ait_urunler_sql") {
    $is_emri_id = $_GET["is_emri_id"];

    $is_emri_urunleri = DBD::all_data("SELECT * FROM is_emri_urunler WHERE status=1 AND cari_key='$cari_key' AND is_emri_id='$is_emri_id'");
    if ($is_emri_urunleri > 0) {
        $gidecek_arr = [];
        foreach ($is_emri_urunleri as $item) {
            $stok_id = $item["hizmet_id"];
            $hizmet = DB::single_query("SELECT stok_adi FROM stok WHERE id='$stok_id'");
            $birim_id = $item["birim_id"];
            $birim = DB::single_query("SELECT birim_adi FROM birim WHERE id='$birim_id'");
            $arr = [
                'hizmet_adi' => $hizmet["stok_adi"],
                'birim_adi' => $birim["birim_adi"],
                'sefer_sayisi' => $item["sefer_sayisi"],
                'hizmet_turu' => $item["hizmet_turu"],
                'prim_tutari' => $item["prim_tutari"],
                'alis_fiyat' => $item["alis_fiyat"],
                'satis_fiyat' => $item["satis_fiyat"],
                'islem' => "<button class='btn btn-danger btn-sm is_emri_hizmeti_sil_guncelle' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "is_emrine_hizmet_ekle_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $ekle = DBD::insert("is_emri_urunler", $_POST);
    if ($ekle) {
        echo 2;
    } else {
        $son_eklenen = DBD::single_query("SELECT id FROM is_emri_urunler where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        echo 'id:' . $son_eklenen["id"];
    }
}
if ($islem == "is_emrini_listeden_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $_POST["delete_detail"] = "Kullanıcı Listeden Silmiştir";
    $sil = DBD::update("is_emri_urunler", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "is_emri_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DBD::update("is_emri_main", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}