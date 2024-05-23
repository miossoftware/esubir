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

if ($islem == "konteyner_giris_kaydet_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $serilsinmi = $_POST["sahaya_ser"];
    unset($_POST["sahaya_ser"]);
    $konteyner_giris_ekle = DBD::insert("konteyner_giris", $_POST);
    if ($konteyner_giris_ekle) {
    } else {
        if ($serilsinmi == "1") {
            $son_eklenen = DBD::single_query("SELECT id FROM konteyner_giris where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
            $arr = [
                'giris_id' => $son_eklenen["id"],
                'insert_userid' => $_SESSION["user_id"],
                'insert_datetime' => date("Y-m-d H:i:s"),
                'cari_key' => $cari_key,
                'sube_key' => $sube_key
            ];
            $sahaya_konteyner_ser = DBD::insert("sahaya_konteyner_ser", $arr);
        }
    }
    if ($_POST["konteyner_no1"] != "") {
        $_POST["prim_yazilsin"] = 0;
        $konteyner_giris_ekle = DBD::insert("konteyner_giris", $_POST);
        if ($konteyner_giris_ekle) {
        } else {
            if ($serilsinmi == "1") {
                $son_eklenen = DBD::single_query("SELECT id FROM konteyner_giris where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
                $arr = [
                    'giris_id' => $son_eklenen["id"],
                    'insert_userid' => $_SESSION["user_id"],
                    'insert_datetime' => date("Y-m-d H:i:s"),
                    'cari_key' => $cari_key,
                    'sube_key' => $sube_key
                ];
                $sahaya_konteyner_ser = DBD::insert("sahaya_konteyner_ser", $arr);
            } else {
                echo 1;
            }
        }
    }

    $arr = [
        'status' => 2
    ];
    $konteyner_tanimdan_dus = DBD::update("konteyner_tanim", "id", $_POST["konteyner_id"], $arr);
    if ($konteyner_giris_ekle) {
        echo 500;
    } else {
        echo 1;
    }
}
if ($islem == "konteyner_girisleri_getir_sql") {
    $konteyner_girisler = DBD::all_data("SELECT * FROM konteyner_giris WHERE status=1 AND cari_key='$cari_key'");
    if ($konteyner_girisler > 0) {
        $gidecek_arr = [];
        foreach ($konteyner_girisler as $item) {
            $giris_tarihi = date("d/m/Y", strtotime($item["giris_tarihi"]));
            $plaka_id = $item["plaka_id"];
            $araclar = DB::single_query("
SELECT
       ak.*,
       c.cari_adi
FROM
     arac_kartlari as ak
LEFT JOIN cari as c on c.id=ak.cari_id
WHERE ak.status=1 AND ak.cari_key='$cari_key' AND ak.id='$plaka_id'");
            $cari_id = $item["cari_id"];
            $cari = DB::single_query("select cari_adi from cari where status=1 and cari_key='$cari_key' and id='$cari_id'");

            $giris_id = $item["id"];
            $durum_degisti = false;
            $bos_dolu = "";
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
            $konteyner_no = "";
            $muhur_no = "";
            if ($item["prim_yazilsin"] == 0) {
                $konteyner_no = $item["konteyner_no1"];
                $muhur_no = $item["muhur_no2"];
            } else {
                $konteyner_no = $item["konteyner_no"];
                $muhur_no = $item["muhur_no"];
            }

            $arr = [
                'arac_grubu' => $araclar["arac_grubu"],
                'konteyner_no' => $konteyner_no,
                'plaka_no' => $araclar["plaka_no"],
                'muhur_no' => $muhur_no,
                'arac_cari' => $araclar["cari_adi"],
                'surucu_adi' => $item["surucu_adi"],
                'giris_tarihi' => $giris_tarihi,
                'tipi' => $item["tipi"],
                'bos_dolu' => $bos_dolu,
                'aciklama' => $item["aciklama"],
                'cari_adi' => $cari["cari_adi"],
                'referans_no' => $item["referans_no"],
                'beyanname_no' => $item["beyanname_no"],
                'islem' => "<button class='btn btn-sm konteyner_giris_guncelle' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm tanimli_konteyner_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "dolu_giris_konteynerleri_getir_sql") {
    $konteyner_girisler = DBD::all_data("
SELECT
       kg.*,
       iem.epro_ref,
       iem.referans_no
FROM
     konteyner_giris as kg
INNER JOIN is_emri_main as iem on iem.id=kg.is_emri_id
WHERE kg.status=1 AND kg.cari_key='$cari_key' AND kg.bos_dolu='Dolu'");
    if ($konteyner_girisler > 0) {
        $gidecek_arr = [];
        foreach ($konteyner_girisler as $item) {
            $giris_tarihi = date("d/m/Y", strtotime($item["giris_tarihi"]));
            $plaka_id = $item["plaka_id"];
            $araclar = DB::single_query("
SELECT
       ak.*,
       c.cari_adi
FROM
     arac_kartlari as ak
LEFT JOIN cari as c on c.id=ak.cari_id
WHERE ak.status=1 AND ak.cari_key='$cari_key' AND ak.id='$plaka_id'");
            $cari_id = $item["cari_id"];
            $cari = DB::single_query("select cari_adi from cari where status=1 and cari_key='$cari_key' and id='$cari_id'");

            $giris_id = $item["id"];
            $durum_degisti = false;
            $bos_dolu = "";
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

            if ($bos_dolu == "Boş") {

            } else {
                $arr = [
                    'arac_grubu' => $araclar["arac_grubu"],
                    'konteyner_no' => $item["konteyner_no"],
                    'plaka_no' => $araclar["plaka_no"],
                    'arac_cari' => $araclar["cari_adi"],
                    'referans_no' => $item["referans_no"],
                    'epro_ref' => $item["epro_ref"],
                    'surucu_adi' => $item["surucu_adi"],
                    'giris_tarihi' => $giris_tarihi,
                    'tipi' => $item["tipi"],
                    'bos_dolu' => $bos_dolu,
                    'aciklama' => $item["aciklama"],
                    'id' => $item["id"],
                    'cari_adi' => $cari["cari_adi"],
                    'beyanname_no' => $item["beyanname_no"],
                    'islem' => "<button class='btn btn-sm konteyner_giris_guncelle' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm tanimli_konteyner_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
}
if ($islem == "secilen_dolu_giris_konteynerleri_getir_sql") {
    $id = $_GET["id"];
    $item = DBD::single_query("
SELECT
       kg.*,
       iem.epro_ref,
       iem.referans_no,
       iem.depo_cariid
FROM
     konteyner_giris as kg
INNER JOIN is_emri_main as iem on iem.id=kg.is_emri_id
WHERE kg.status=1 AND kg.cari_key='$cari_key' AND kg.bos_dolu='Dolu' AND kg.id='$id'");
    if ($item > 0) {
        $gidecek_arr = [];
        $giris_tarihi = date("d/m/Y", strtotime($item["giris_tarihi"]));
        $plaka_id = $item["plaka_id"];
        $araclar = DB::single_query("
SELECT
       ak.*,
       c.cari_adi
FROM
     arac_kartlari as ak
LEFT JOIN cari as c on c.id=ak.cari_id
WHERE ak.status=1 AND ak.cari_key='$cari_key' AND ak.id='$plaka_id'");
        $cari_id = $item["cari_id"];
        $cari = DB::single_query("select cari_adi,cari_kodu from cari where status=1 and cari_key='$cari_key' and id='$cari_id'");

        $giris_id = $item["id"];
        $durum_degisti = false;
        $bos_dolu = "";
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

        if ($bos_dolu == "Boş") {
            echo 2;
        } else {
            $arr = [
                'arac_grubu' => $araclar["arac_grubu"],
                'konteyner_no' => $item["konteyner_no"],
                'plaka_no' => $araclar["plaka_no"],
                'plaka_id' => $araclar["id"],
                'arac_cari' => $araclar["cari_adi"],
                'referans_no' => $item["referans_no"],
                'epro_ref' => $item["epro_ref"],
                'depo_cariid' => $item["depo_cariid"],
                'surucu_adi' => $item["surucu_adi"],
                'giris_tarihi' => $giris_tarihi,
                'tipi' => $item["tipi"],
                'bos_dolu' => $bos_dolu,
                'aciklama' => $item["aciklama"],
                'cari_adi' => $cari["cari_adi"],
                'cari_kodu' => $cari["cari_kodu"],
                'beyanname_no' => $item["beyanname_no"],
                'islem' => "<button class='btn btn-sm konteyner_giris_guncelle' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm tanimli_konteyner_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "konteyner_girislerini_getir_sql") {
    $konteyner_girisleri = DBD::all_data("
SELECT
       kg.*,
       iem.konteyner_tipi,
       iem.referans_no,
       iem.beyanname_no
FROM
     konteyner_giris as kg
INNER JOIN is_emri_main AS iem on iem.id=kg.is_emri_id
WHERE kg.status=1 AND kg.cari_key='$cari_key'");
    if ($konteyner_girisleri > 0) {
        $gidecek_arr = [];
        foreach ($konteyner_girisleri as $item) {
            $cari_id = $item["cari_id"];
            $cari = DB::single_query("SELECT cari_adi FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
            $giris_tarihi = "";
            if ($item["giris_tarihi"] != "0000-00-00 00:00:00") {
                $giris_tarihi = $item["giris_tarihi"];
                $giris_tarihi = date("d/m/Y", strtotime($giris_tarihi));
            }
            $konteyner_no = "";
            if ($item["prim_yazilsin"] == 0) {
                $konteyner_no = $item["konteyner_no1"];
            } else {
                $konteyner_no = $item["konteyner_no"];
            }
            $arr = [
                'konteyner_no' => $konteyner_no,
                'cari_adi' => $cari["cari_adi"],
                'giris_tarihi' => $giris_tarihi,
                'konteyner_tipi' => $item["konteyner_tipi"],
                'referans_no' => $item["referans_no"],
                'beyanname_no' => $item["beyanname_no"],
                'id' => $item["id"]
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
if ($islem == "secilen_konteyner_giris_bilgileri") {
    $id = $_GET["id"];
    $item = DBD::single_query("
SELECT
       kg.*,
       iem.konteyner_tipi,
       iem.referans_no,
       iem.beyanname_no
FROM
     konteyner_giris as kg
INNER JOIN is_emri_main AS iem on iem.id=kg.is_emri_id
WHERE kg.status=1 AND kg.cari_key='$cari_key' AND kg.id='$id'");
    if ($item > 0) {
        $cari_id = $item["cari_id"];
        $cari = DB::single_query("SELECT cari_adi FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
        $giris_tarihi = "";
        if ($item["giris_tarihi"] != "0000-00-00 00:00:00") {
            $giris_tarihi = $item["giris_tarihi"];
            $giris_tarihi = date("Y-m-d", strtotime($giris_tarihi));
        }
        $giris_id = $item["id"];
        $durum_degisti = false;
        $bos_dolu = "";
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
        $arr = [
            'konteyner_no' => $item["konteyner_no"],
            'cari_adi' => $cari["cari_adi"],
            'bos_dolu' => $bos_dolu,
            'giris_tarihi' => $giris_tarihi,
            'konteyner_tipi' => $item["konteyner_tipi"],
            'referans_no' => $item["referans_no"],
            'beyanname_no' => $item["beyanname_no"],
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
if ($islem == "konteyner_cikis_yap_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;

    $konteyner_id = $_POST["konteyner_id"];

    $giris_bilgileri = DBD::single_query("
SELECT
       iem.tipi,
       kg.bos_dolu
FROM
     konteyner_giris as kg
INNER JOIN is_emri_main AS iem on iem.id=kg.is_emri_id
WHERE kg.status=1 AND kg.cari_key='$cari_key' AND kg.id='$konteyner_id'
");
    if ($giris_bilgileri["tipi"] == "İTHALAT" && $giris_bilgileri["bos_dolu"] == "Dolu") {
        if ($_POST["bos_dolu"] == "Dolu") {
            echo 300;
        } else {
            $konteyneri_cikart = DBD::insert("konteyner_cikis", $_POST);
            if ($konteyneri_cikart) {
                echo 500;
            } else {
                $arr = [
                    'status' => 2
                ];
                $girisi_dusur = DBD::update("konteyner_giris", "id", $_POST["konteyner_id"], $arr);
                $girisi_dusur = DBD::update("konteyner_giris", "id", $_POST["konteyner_id2"], $arr);
                if ($girisi_dusur) {
                    echo 1;
                } else {
                    echo 2;
                }
            }
        }
    } else {
        $konteyneri_cikart = DBD::insert("konteyner_cikis", $_POST);
        if ($konteyneri_cikart) {
            echo 500;
        } else {
            $arr = [
                'status' => 2
            ];
            $girisi_dusur = DBD::update("konteyner_giris", "id", $_POST["konteyner_id"], $arr);
            $girisi_dusur = DBD::update("konteyner_giris", "id", $_POST["konteyner_id2"], $arr);
            if ($girisi_dusur) {
                echo 1;
            } else {
                echo 2;
            }
        }
    }
}
if ($islem == "konteyner_cikislari_getir") {
    $konteyner_cikislari = DBD::all_data("
SELECT
       kc.*,
       kg.konteyner_no,
       iem.konteyner_tipi,
       kg.prim_yazilsin
FROM
     konteyner_cikis as kc
INNER JOIN konteyner_giris as kg on kg.id=kc.konteyner_id
INNER JOIN is_emri_main AS iem on iem.id=kg.is_emri_id
WHERE kc.status=1 AND kc.cari_key='$cari_key'");
    if ($konteyner_cikislari > 0) {
        $gidecek_arr = [];
        foreach ($konteyner_cikislari as $item) {
            $plaka_id = $item["plaka_id"];
            $arac_bilgi = DB::single_query("
SELECT
       ak.*,
       c.cari_adi
FROM
     arac_kartlari as ak
LEFT JOIN cari as c on c.id=ak.cari_id
WHERE
      ak.status=1 AND ak.cari_key='$cari_key' AND ak.id='$plaka_id'");

            $giris_tarihi = date("d/m/Y", strtotime($item["giris_tarihi"]));
            $cikis_tarihi = date("d/m/Y", strtotime($item["cikis_tarihi"]));
            $gunluk_ucret = number_format($item["gunluk_ucret"], 2);
            $ardiye_gunu = number_format($item["ardiye_gunu"], 2);
            $toplam_ucret = number_format($item["toplam_ucret"], 2);

            $kont_no = "";
            if ($item["prim_yazilsin"] == 0){
                $kont_no = $item["konteyner_no1"];
            }else{
                $kont_no = $item["konteyner_no"];
            }

            $arr = [
                'arac_grubu' => $arac_bilgi["arac_grubu"],
                'giris_tarihi' => $giris_tarihi,
                'cikis_tarihi' => $cikis_tarihi,
                'konteyner_no' => $kont_no,
                'konteyner_tipi' => $item["konteyner_tipi"],
                'plaka_no' => $arac_bilgi["plaka_no"],
                'arac_cari' => $arac_bilgi["cari_adi"],
                'surucu_adi' => $item["surucu_adi"],
                'free_time' => $item["free_time"],
                'gunluk_ucret' => $gunluk_ucret,
                'ardiye_gunu' => $ardiye_gunu,
                'toplam_ucret' => $toplam_ucret,
                'aciklama' => $item["aciklama"],
                'islem' => "<button class='btn btn-sm konteyner_cikis_guncelle_button' style='background-color: #F6FA70' data-id='" . $item["id"] . "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm konteyner_cikis_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "konteyner_cikis_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $id = $_POST["id"];
    $bilgisi = DBD::single_query("SELECT * FROM konteyner_cikis WHERE id='$id'");
    $cikis_sil = DBD::update("konteyner_cikis", "id", $_POST["id"], $_POST);
    if ($cikis_sil) {
        $konteyner_id = $bilgisi["konteyner_id"];
        $arr = [
            'status' => 1
        ];
        $active = DBD::update("konteyner_giris", "id", $konteyner_id, $arr);
        if ($active) {
            echo 1;
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "guncellenecek_cikis_bilgileri_sql") {
    $id = $_GET["id"];

    $konteyner_cikislari = DBD::single_query("
SELECT
       kc.*,
       kg.konteyner_no,
       iem.konteyner_tipi
FROM
     konteyner_cikis as kc
INNER JOIN konteyner_giris as kg on kg.id=kc.konteyner_id
INNER JOIN is_emri_main as iem on iem.id=kg.is_emri_id
WHERE kc.status=1 AND kc.cari_key='$cari_key' AND kc.id='$id'");
    if ($konteyner_cikislari > 0) {
        $plaka_id = $konteyner_cikislari["plaka_id"];
        $arac_bilgi = DB::single_query("
SELECT
       ak.*,
       c.cari_adi
FROM
     arac_kartlari as ak
LEFT JOIN cari as c on c.id=ak.cari_id
WHERE
      ak.status=1 AND ak.cari_key='$cari_key' AND ak.id='$plaka_id'");

        $giris_tarihi = date("Y-m-d", strtotime($konteyner_cikislari["giris_tarihi"]));
        $cikis_tarihi = date("Y-m-d", strtotime($konteyner_cikislari["cikis_tarihi"]));

        $arr = [
            'arac_grubu' => $arac_bilgi["arac_grubu"],
            'giris_tarihi' => $giris_tarihi,
            'cikis_tarihi' => $cikis_tarihi,
            'konteyner_no' => $konteyner_cikislari["konteyner_no"],
            'bos_dolu' => $konteyner_cikislari["bos_dolu"],
            'konteyner_tipi' => $konteyner_cikislari["konteyner_tipi"],
            'plaka_id' => $konteyner_cikislari["plaka_id"],
            'surucu_id' => $konteyner_cikislari["surucu_id"],
            'plaka_no' => $arac_bilgi["plaka_no"],
            'arac_cari' => $arac_bilgi["cari_adi"],
            'surucu_adi' => $konteyner_cikislari["surucu_adi"],
            'konteyner_id' => $konteyner_cikislari["konteyner_id"],
            'free_time' => $konteyner_cikislari["free_time"],
            'gunluk_ucret' => $konteyner_cikislari["gunluk_ucret"],
            'ardiye_gunu' => $konteyner_cikislari["ardiye_gunu"],
            'toplam_ucret' => $konteyner_cikislari["toplam_ucret"],
            'aciklama' => $konteyner_cikislari["aciklama"]
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
if ($islem == "konteyner_cikis_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $id = $_POST["id"];
    $bilgi = DBD::single_query("SELECT * FROM konteyner_cikis WHERE id='$id'");
    $guncelle = DBD::update("konteyner_cikis", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        $first_id = $bilgi["konteyner_id"];
        $arr1 = [
            'status' => 1
        ];
        $guncelle = DBD::update("konteyner_giris", "id", $first_id, $arr1);
        $arr2 = [
            'status' => 2
        ];
        $guncelle3 = DBD::update("konteyner_giris", "id", $_POST["konteyner_id"], $arr2);
        if ($guncelle3) {
            echo 1;
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "arac_giris_kaydet_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;

    $serilsinmi = $_POST["serilsin_mi"];
    unset($_POST["serilsin_mi"]);

    $ekle = DBD::insert("arac_giris", $_POST);
    if ($ekle) {
        echo 500;
    } else {
        $son_eklenen = DBD::single_query("SELECT id FROM arac_giris where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        $is_emri_id = $_POST["is_emri_id"];
        $is_emri = DBD::single_query("SELECT birim_id FROM is_emri_main WHERE id='$is_emri_id'");
        if ($serilsinmi == 1) {
            $arr = [
                'giris_id' => $son_eklenen["id"],
                'miktar' => $_POST["miktar"],
                'birim_id' => $is_emri["birim_id"],
                'insert_userid' => $_SESSION["user_id"],
                'insert_datetime' => date("Y-m-d H:i:s"),
                'cari_key' => $cari_key,
                'sube_key' => $sube_key,
                'tarih' => $_POST["giris_tarihi"]
            ];
            $sahaya_urun_ser = DBD::insert("sahaya_urun_ser", $arr);
        }
        $arr = [
            'status' => 2
        ];
        $araci_dusur = DBD::update("depo_arac_tanim", "id", $_POST["plaka_id"], $arr);
        echo 1;
    }
}
if ($islem == "arac_girislerini_getir_sql") {
    $arac_girisleri_getir_sql = DBD::all_data("SELECT * FROM arac_giris WHERE status=1 AND cari_key='$cari_key'");

    if ($arac_girisleri_getir_sql > 0) {
        $gidecek_arr = [];
        foreach ($arac_girisleri_getir_sql as $item) {
            $giris_tarihi = date("d/m/Y", strtotime($item["giris_tarihi"]));
            $miktar = number_format($item["miktar"], 2);
            $birim_id = $item["birim_id"];
            $birim = DB::single_query("SELECT birim_adi FROM birim WHERE status=1 AND cari_key='$cari_key' AND id='$birim_id'");
            $arr = [
                'giris_tarihi' => $giris_tarihi,
                'plaka_no' => $item["plaka_no"],
                'surucu_adi' => $item["surucu_adi"],
                'surucu_tel' => $item["surucu_tel"],
                'fabrika_ref' => $item["fabrika_ref"],
                'referans_no' => $item["referans_no"],
                'epro_ref' => $item["epro_ref"],
                'mal_cinsi' => $item["mal_cinsi"],
                'miktar' => $miktar,
                'birim' => $birim["birim_adi"],
                'id' => $item["id"],
                'islem' => "<button class='btn btn-sm arac_giris_guncelle_button' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm arac_giris_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "giris_yapan_aracin_bilgilerini_getir_sql") {
    $id = $_GET["id"];
    $arac_giris_bilgileri = DBD::single_query("SELECT * FROM arac_giris WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    if ($arac_giris_bilgileri > 0) {
        $cari_id = $arac_giris_bilgileri["cari_id"];
        $is_emri_id = $arac_giris_bilgileri["is_emri_id"];
        $is_emri_bilgileri = DBD::single_query("SELECT * FROM is_emri_main WHERE id='$is_emri_id'");
        $cari = DB::single_query("SELECT cari_adi,cari_kodu FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
        $arr = [
            'plaka_id' => $arac_giris_bilgileri["plaka_id"],
            'miktar' => $arac_giris_bilgileri["miktar"],
            'plaka_no' => $arac_giris_bilgileri["plaka_no"],
            'giris_tarihi' => $arac_giris_bilgileri["giris_tarihi"],
            'surucu_adi' => $arac_giris_bilgileri["surucu_adi"],
            'surucu_tel' => $arac_giris_bilgileri["surucu_tel"],
            'cari_adi' => $cari["cari_adi"],
            'cari_kodu' => $cari["cari_kodu"],
            'cari_id' => $arac_giris_bilgileri["cari_id"],
            'is_emir_id' => $arac_giris_bilgileri["is_emri_id"],
            'epro_ref' => $arac_giris_bilgileri["epro_ref"],
            'birim_id' => $is_emri_bilgileri["birim_id"],
            'id' => $arac_giris_bilgileri["id"],
            'referans_no' => $is_emri_bilgileri["referans_no"],
            'beyanname_no' => $is_emri_bilgileri["beyanname_no"],
            'aciklama' => $arac_giris_bilgileri["aciklama"],
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
if ($islem == "konteyner_giris_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $sil = DBD::update("konteyner_giris", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "arac_giris_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $sil = DBD::update("arac_giris", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "tanitilacak_konteynerler_sql") {
    $ep_id = $_GET["siparis_id"];
    $tum_veriler = DBD::single_query("
SELECT 
       konteyner_sayisi,
       konteyner_tipi
FROM
     is_emri_main
WHERE status=1 AND cari_key='$cari_key' AND id='$ep_id' AND kont_tanimlandi=1");
    if ($tum_veriler > 0) {
        echo json_encode($tum_veriler);
    } else {
        $tum_veriler = DBD::single_query("
SELECT 
       konteyner_sayisi,
       konteyner_tipi
FROM
     is_emri_main
WHERE status=1 AND cari_key='$cari_key' AND id='$ep_id'");
        $tanitilmis_kont_sayisi = DBD::single_query("SELECT COUNT(id) as konteyner_sayisi FROM konteyner_tanim WHERE status=1 AND is_emri_id='$ep_id'");

        if ($tanitilmis_kont_sayisi["kontyner_sayisi"] >= $tum_veriler["konteyner_sayisi"]) {
            echo 2;
        } else {
            $konteyner_sayisi = intval($tum_veriler["konteyner_sayisi"]) - intval($tanitilmis_kont_sayisi["kontyner_sayisi"]);
            $tum_veriler["konteyner_sayisi"] = $konteyner_sayisi;
            echo json_encode($tum_veriler);
        }
    }
}
if ($islem == "konteynerleri_tanit_sql") {
    foreach ($_POST["gidecek_arr"] as $item) {
        $arr = [
            'konteyner_no' => $item["konteyner_no"],
            'konteyner_tipi' => $item["konteyner_tipi"],
            'cari_id' => $_POST["cari_id"],
            'is_emri_id' => $_POST["is_emri_id"],
            'insert_userid' => $_SESSION["user_id"],
            'insert_datetime' => date("Y-m-d H:i:s"),
            'cari_key' => $cari_key,
            'sube_key' => $sube_key
        ];
        $ekle = DBD::insert("konteyner_tanim", $arr);
    }
    if ($ekle) {
        echo 500;
    } else {
        $is_emri_id = $_POST["is_emri_id"];
        $arr = [
            'kont_tanimlandi' => 2
        ];
        $guncelle = DBD::update("is_emri_main", "id", $is_emri_id, $arr);
        if ($guncelle) {
            echo 1;
        } else {
            echo 2;
        }
    }
}
if ($islem == "tanimlanan_konteynerleri_getir_sql") {
    $konteynerler = DBD::all_data("SELECT *,kt.id as konteyner_id FROM konteyner_tanim AS kt INNER JOIN is_emri_main AS iem on iem.id=kt.is_emri_id WHERE kt.status=1");
    if ($konteynerler > 0) {
        $gidecek_arr = [];
        foreach ($konteynerler as $item) {
            $tarih = $item["tarih"];
            if ($tarih != "0000-00-00 00:00:00") {
                $tarih = date("d/m/Y", strtotime($tarih));
            }
            $cari_id = $item["cari_id"];
            $cari = DB::single_query("SELECT cari_adi FROM cari WHERE id='$cari_id'");
            $arr = [
                'tipi' => $item["tipi"],
                'tarih' => $tarih,
                'cari_adi' => $cari["cari_adi"],
                'epro_ref' => $item["epro_ref"],
                'referans_no' => $item["referans_no"],
                'beyanname_no' => $item["beyanname_no"],
                'konteyner_no' => $item["konteyner_no"],
                'konteyner_tipi' => $item["konteyner_tipi"],
                'id' => $item["konteyner_id"],
                'islem' => "<button class='btn btn-danger btn-sm tanitilan_kont_sil_button' data-id='" . $item["konteyner_id"] . "'><i class='fa fa-trash'></i></button>"
            ];
            array_push($gidecek_arr, $arr);
        }
        echo json_encode($gidecek_arr);
    } else {
        echo 2;
    }
}
if ($islem == "secilen_konteyner_bilgilerini_getir_sql") {
    $id = $_GET["id"];
    $item = DBD::single_query("SELECT * FROM konteyner_tanim AS kt INNER JOIN is_emri_main AS iem on iem.id=kt.is_emri_id WHERE kt.status=1 AND kt.id='$id'");
    if ($item > 0) {
        $cari_id = $item["cari_id"];
        $cari = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
        if ($item["tipi"] == "İTHALAT") {
            $bos_dolu = "Dolu";
        } else {
            $bos_dolu = "Boş";
        }
        $arr = [
            'tipi' => $item["tipi"],
            'epro_ref' => $item["epro_ref"],
            'is_emri_id' => $item["is_emri_id"],
            'referans_no' => $item["referans_no"],
            'beyanname_no' => $item["beyanname_no"],
            'bos_dolu' => $bos_dolu,
            'cari_id' => $item["cari_id"],
            'cari_adi' => $cari["cari_adi"],
            'konteyner_no' => $item["konteyner_no"],
            'konteyner_tipi' => $item["konteyner_tipi"],
            'islem' => "<button class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>"
        ];
        if ($arr > 0) {
            echo json_encode($arr);
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}