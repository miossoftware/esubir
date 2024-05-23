<?php
include '../DB.php';
date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=UTF-8');
session_start();
DB::connect();
$islem = $_GET["islem"];
$_POST["cari_key"] = $_SESSION["cari_key"];
$_GET["cari_key"] = $_SESSION["cari_key"];
$_POST["sube_key"] = $_SESSION["sube_key"];
$sube_key = $_SESSION["sube_key"];
$cari_key = $_SESSION["cari_key"];

if ($islem == "uye_tanimla_sql") {
    $uye_arr = [
        'abone_mi' => $_POST["uye_turu"],
        'tc_no' => $_POST["tc_no"],
        'uye_adi' => $_POST["uye_adi"],
        'cep_no' => $_POST["cep_no"],
        'dogum_tarihi' => $_POST["dogum_tarihi"],
        'uye_numarasi' => $_POST["uye_numarasi"],
        'il' => $_POST["il"],
        'ilce' => $_POST["ilce"],
        'adres' => $_POST["adres"],
        'baba_adi' => $_POST["baba_adi"],
        'insert_userid' => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s"),
        'cari_key' => $cari_key,
        'sube_key' => $sube_key
    ];
    $tc = $_POST["tc_no"];
    $sor = DB::single_query("select * from uye_tanim where status=1 and tc_no='$tc' AND cari_key='$cari_key'");
    if ($sor > 0) {
        echo 300;
    } else {
        $uye_tanimla = DB::insert("uye_tanim", $uye_arr);
        if ($uye_tanimla) {
            echo 500;
        } else {
            $son_eklenen = DB::single_query("SELECT id FROM uye_tanim where  cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
            $tapular = DB::all_data("SELECT * FROM uye_tapu WHERE status=1 AND tc_no='$tc'");
            foreach ($tapular as $item) {
                $item["uye_id"] = $son_eklenen["id"];
                $guncelle = DB::update("uye_tapu", "id", $item["id"], $item);
                $tapu_id = $item["id"];
                $tarifeler = DB::all_data("SELECT * FROM uye_tarifeleri WHERE status=1 AND tapu_id='$tapu_id'");
                foreach ($tarifeler as $item2) {
                    $item2["uye_id"] = $son_eklenen["id"];
                    $guncel = DB::update("uye_tarifeleri", "id", $item2["id"], $item2);
                }
            }
            echo 1;
        }
    }
}
if ($islem == "uyeleri_getir_sql") {
    $uyeler = DB::all_data("
SELECT
       ut.abone_mi,
       ut.tc_no,
       ut.uye_adi,
       ut.cep_no,
       ut.il as uye_il,
       ut.ilce as uye_ilce,
       ut.adres,
       ut.id,
       ut.status
FROM
     uye_tanim AS ut
LEFT JOIN uye_tapu AS utap on utap.uye_id=ut.id
WHERE ut.cari_key='$cari_key' GROUP BY ut.id
");
    if ($uyeler > 0) {
        $gidecek_arr = [];
        foreach ($uyeler as $item) {
            $button = "";
            if ($item["status"] == 1) {
                $button = "<button class='btn btn-danger btn-sm uye_sil_button' data-id='" . $item["tc_no"] . "'>Pasif Et</button>";
            } else {
                $button = "<button class='btn btn-success btn-sm uye_aktif_button' data-id='" . $item["id"] . "'>Aktif Et</button>";
            }

            $arr = [
                'tapular' => '<button data-id="' . $item['id'] . '" class="btn btn-info btn-sm uyeye_ait_tapulari_getir" style="border-radius: 50%;"><i class="fa fa-plus"></i></button>',
                'abone_mi' => $item["abone_mi"],
                'tc_no' => $item["tc_no"],
                'id' => $item["uye_id"],
                'uye_adi' => $item["uye_adi"],
                'cep_no' => $item["cep_no"],
                'uye_il' => $item["uye_il"],
                'uye_ilce' => $item["uye_ilce"],
                'adres' => $item["adres"],
                'islem' => $button,
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
if ($islem == "uyeyi_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $uyeyi_sil = DB::update("uye_tanim", "tc_no", $_POST["tc_no"], $_POST);
    if ($uyeyi_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "uyeyi_aktif_et_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 1;
    $uyeyi_sil = DB::update("uye_tanim", "id", $_POST["id"], $_POST);
    if ($uyeyi_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "secilen_uyeleri_getir_sql") {
    $tc = $_GET["tc"];

    $item = DB::single_query("
SELECT
       utap.*,
       ut.abone_mi,
       ut.tc_no,
       ut.baba_adi,
       ut.uye_adi,
       ut.uye_numarasi,
       ut.dogum_tarihi,
       ut.cep_no,
       ut.il as uye_il,
       ut.ilce as uye_ilce,
       ut.adres
FROM
     uye_tanim AS ut
LEFT JOIN uye_tapu AS utap on utap.uye_id=ut.id
WHERE ut.status=1 AND ut.cari_key='$cari_key' AND ut.tc_no='$tc'
");
    if ($item > 0) {
        $arr = [
            'abone_mi' => $item["abone_mi"],
            'tc_no' => $item["tc_no"],
            'id' => $item["uye_id"],
            'uye_adi' => $item["uye_adi"],
            'ad_soyad' => $item["ad_soyad"],
            'uye_numarasi' => $item["uye_numarasi"],
            'dogum_tarihi' => date("Y-m-d",strtotime($item["dogum_tarihi"])),
            'baba_adi' => $item["baba_adi"],
            'cep_no' => $item["cep_no"],
            'uye_il' => $item["uye_il"],
            'uye_ilce' => $item["uye_ilce"],
            'adres' => $item["adres"],
            'il' => $item["uye_il"],
            'ilce' => $item["uye_ilce"],
            'mahalle_koy' => $item["mahalle_koy"],
            'ada' => $item["ada"],
            'yuz_olcumu' => $item["yuz_olcumu"],
            'sulama_alani' => $item["sulama_alani"],
            'parsel' => $item["parsel"],
            'tescil_tarihi' => $item["tescil_tarihi"],
            'cilt_no' => $item["cilt_no"],
            'tasinmaz_no' => $item["tasinmaz_no"],
            'edinme_nedeni' => $item["edinme_nedeni"],
            'islem_bedeli' => $item["islem_bedeli"],
            'aciklama' => $item["aciklama"],
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
if ($islem == "uye_guncelle_sql") {
    $uye_arr = [
        'abone_mi' => $_POST["uye_turu"],
        'tc_no' => $_POST["tc_no"],
        'uye_adi' => $_POST["uye_adi"],
        'cep_no' => $_POST["cep_no"],
        'dogum_tarihi' => $_POST["dogum_tarihi"],
        'baba_adi' => $_POST["baba_adi"],
        'uye_numarasi' => $_POST["uye_numarasi"],
        'il' => $_POST["il"],
        'ilce' => $_POST["ilce"],
        'adres' => $_POST["adres"],
        'insert_userid' => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s"),
        'cari_key' => $cari_key,
        'sube_key' => $sube_key
    ];
    $tc = $_POST["tc_no"];
    $uye_tanimla = DB::update("uye_tanim", "tc_no", $tc, $uye_arr);
    if ($uye_tanimla) {
        echo 1;
    } else {
        echo 500;
    }
}
if ($islem == "uye_acilis_fisi_kaydet_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $acilis_kaydet = DB::insert("uye_acilis_fisi", $_POST);
    if ($acilis_kaydet) {
        echo 500;
    } else {
        echo 1;
    }
}
if ($islem == "acilis_fislerini_getir_sql") {
    $acilis_fisleri = DB::all_data("
SELECT
       uaf.*,
       ut.tc_no,
       ut.uye_adi
FROM
     uye_acilis_fisi as uaf
INNER JOIN uye_tanim as ut on ut.id=uaf.uye_id
WHERE uaf.status=1 AND uaf.cari_key='$cari_key'");
    if ($acilis_fisleri > 0) {
        $gidecek_arr = [];
        $toplam_borc = 0;
        $toplam_alacak = 0;
        foreach ($acilis_fisleri as $item) {
            $toplam_alacak += $item["alacak"];
            $toplam_borc += $item["borc"];
            $arr = [
                'tc_no' => $item["tc_no"],
                'uye_adi' => $item["uye_adi"],
                'tarih' => date("d/m/Y", strtotime($item["acilis_tarihi"])),
                'borc' => number_format($item["borc"]),
                'alacak' => number_format($item["alacak"]),
                'islem' => "<button class='btn btn-sm uye_acilis_guncelle_button' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button data-id='" . $item["id"] . "' class='btn btn-danger btn-sm acilis_fisi_sil_sql'><i class='fa fa-trash'></i></button>"
            ];
            array_push($gidecek_arr, $arr);
        }
        if (!empty($gidecek_arr)) {
            $gidecek_arr[0]["toplam_borc"] = number_format($toplam_borc);
            $gidecek_arr[0]["toplam_alacak"] = number_format($toplam_alacak);
            echo json_encode($gidecek_arr);
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "acilis_fisi_sil_main_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $uye_acilis_sil = DB::update("uye_acilis_fisi", "id", $_POST["id"], $_POST);
    if ($uye_acilis_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "tarife_tanim_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $tarife_kodu = $_POST["tarife_kodu"];
    $sorgula = DB::single_query("select * from uye_tarife_tanim where status=1 AND tarife_kodu='$tarife_kodu'");
    if ($sorgula > 0) {
        echo 300;
    } else {
        $ekle = DB::insert("uye_tarife_tanim", $_POST);
        if ($ekle) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "tarifeleri_getir_sql") {
    $tarifeler = DB::all_data("SELECT * FROM uye_tarife_tanim WHERE status=1 AND cari_key='$cari_key'");
    if ($tarifeler > 0) {
        echo json_encode($tarifeler);
    } else {
        echo 2;
    }
}
if ($islem == "tarife_sil") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $uyeyi_sil = DB::update("uye_tarife_tanim", "tarife_kodu", $_POST["tarife_kodu"], $_POST);
    if ($uyeyi_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "secilen_tarifeyi_getir_sql") {
    $tarife_kodu = $_GET["tarife_kodu"];
    $bilgisi = DB::single_query("SELECT * FROM uye_tarife_tanim WHERE status=1 AND tarife_kodu='$tarife_kodu' AND cari_key='$cari_key'");
    if ($bilgisi > 0) {
        echo json_encode($bilgisi);
    } else {
        echo 2;
    }
}
if ($islem == "tarife_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DB::update("uye_tarife_tanim", "tarife_kodu", $_POST["tarife_kodu"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "acilis_bilgilerini_getir_sql") {
    $id = $_GET["id"];
    $bilgiler = DB::single_query("
SELECT
       uaf.*,
       ut.tc_no,
       ut.uye_adi
FROM
     uye_acilis_fisi as uaf
INNER JOIN uye_tanim as ut on ut.id=uaf.uye_id
WHERE uaf.status=1 AND uaf.cari_key='$cari_key' AND uaf.id='$id'");
    if ($bilgiler > 0) {
        echo json_encode($bilgiler);
    } else {
        echo 2;
    }
}
if ($islem == "uye_acilis_fisi_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DB::update("uye_acilis_fisi", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "uyeye_ait_tarifeleri_getir_sql") {
    $tc_no = $_GET["tc_no"];
    $uye_id = DB::single_query("SELECT id FROM uye_tanim WHERE status=1 AND tc_no='$tc_no' AND cari_key='$cari_key'");
    $uye_id = $uye_id["id"];
    $tarifeler = DB::all_data("
SELECT
       utt.*,
       ut.sulama_metrekare
FROM
     uye_tarifeleri as ut 
INNER JOIN uye_tarife_tanim as utt on utt.id=ut.tarife_id
WHERE ut.status=1 AND ut.uye_id='$uye_id' AND ut.cari_key='$cari_key'");
    if ($tarifeler > 0) {
        echo json_encode($tarifeler);
    } else {
        echo 2;
    }
}
if ($islem == "uyelerin_tahakkuklarini_getir_sql") {
    $uye_tahakkuklari = DB::all_data("
SELECT
       SUM(utaf.sulama_metrekare * utt.tarife_fiyati) as uyenin_toplam_borcu,
       ut.tc_no,
       ut.uye_adi,
       utt.tarife_adi
FROM 
     uye_tarifeleri as utaf
INNER JOIN uye_tanim as ut on ut.id=utaf.uye_id AND ut.status=1
INNER JOIN uye_tarife_tanim as utt on utt.id=utaf.tarife_id
WHERE utaf.status=1 AND utaf.cari_key='$cari_key' AND ut.abone_mi=utt.uye_mi GROUP BY utaf.id");
    if ($uye_tahakkuklari > 0) {
        echo json_encode($uye_tahakkuklari);
    } else {
        echo 2;
    }
}
if ($islem == "tahakkuk_kaydet_sql") {
    $ana_bilgiler = [
        'insert_userid' => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s"),
        'cari_key' => $cari_key,
        'sube_key' => $sube_key,
        'islem_tarihi' => $_POST["islem_tarihi"],
        'aciklama' => $_POST["aciklama"]
    ];
    $ekle = DB::insert("uye_tahakkuk", $ana_bilgiler);
    if ($ekle) {
        echo 500;
    } else {
        $son_eklenen = DB::single_query("SELECT id FROM uye_tahakkuk where  cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        foreach ($_POST["gidecek_arr"] as $item) {
            $tc_no = $item["tc_no"];
            unset($item["tc_no"]);
            $uye_id = DB::single_query("SELECT * FROM uye_tanim WHERE status=1 AND tc_no='$tc_no' AND cari_key='$cari_key'");
            $item["uye_id"] = $uye_id["id"];
            $item["insert_userid"] = $_SESSION["user_id"];
            $item["insert_datetime"] = date("Y-m-d H:i:s");
            $item["cari_key"] = $cari_key;
            $item["tahakkuk_id"] = $son_eklenen["id"];
            $item["sube_key"] = $sube_key;
            $tahakkuk_urun_ekle = DB::insert("uye_tahakkuk_urunler", $item);
        }
        if ($tahakkuk_urun_ekle) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "tum_tahakkuklari_getir_sql") {
    $tum_tahakkuklar = DB::all_data("
SELECT 
    ut.islem_tarihi,
    ut.id,
    SUM(utu.tutar) as toplam_tahakkuk,
    ut.aciklama
FROM
    uye_tahakkuk as ut
INNER JOIN uye_tahakkuk_urunler as utu ON utu.tahakkuk_id = ut.id
WHERE 
    ut.status = 1 AND 
    utu.status = 1 AND 
    ut.cari_key='$cari_key' AND
    ut.id IS NOT NULL
GROUP BY
    ut.islem_tarihi, ut.id;
");
    if ($tum_tahakkuklar > 0) {
        $gidecek_arr = [];
        $toplam = 0;
        foreach ($tum_tahakkuklar as $item) {
            $tarih = "";
            if ($item["islem_tarihi"] != "0000-00-00 00:00:00") {
                $tarih = date("d/m/Y", strtotime($item["islem_tarihi"]));
            }
            $toplam += $item["toplam_tahakkuk"];
            $arr = [
                'tarih' => $tarih,
                'aciklama' => $item["aciklama"],
                'tahakkuk_tutari' => number_format($item['toplam_tahakkuk'], 2),
                'islem' => "<button class='btn btn-sm tahakkuk_guncelle_main_button' style='background-color: #F6FA70' data-id='" . $item["id"] . "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm uye_tahakkuk_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
            ];
            array_push($gidecek_arr, $arr);
        }
        if (!empty($gidecek_arr)) {
            $gidecek_arr[0]["toplam_tah"] = number_format($toplam);
            echo json_encode($gidecek_arr);
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "tahakkuk_iptal_et_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $uyeyi_sil = DB::update("uye_tahakkuk", "id", $_POST["id"], $_POST);
    if ($uyeyi_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "uye_bilgileri_getir_sql") {
    $tc_no = $_GET["cari_kodu"];
    $uye_bilgileri = DB::single_query("SELECT * FROM uye_tanim WHERE status=1 AND cari_key='$cari_key' AND tc_no='$tc_no'");
    if ($uye_bilgileri > 0) {
        echo json_encode($uye_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "uye_hesap_ekstre_getir") {
    $ekstre_arr = [];
    $cari_id = $_GET["cari_id"];
    $bas_tarih = $_GET["bas_tarih"];
    $sorgu_bas = $_GET["bas_tarih"];
    $bit_tarih = $_GET["bit_tarih"];

    $bas_tarih = date("Y-m-d", strtotime($bas_tarih));
    $last_bas_tarih = $bas_tarih;

    $yil_basi = new DateTime();
    $yil_basi->modify('first day of January ' . $yil_basi->format('Y'));

    $yil_basi = $yil_basi->format('Y-m-d');

    if ($bas_tarih == "" && $bit_tarih == "") {
        $last_bas_tarih = date("Y-m-d");
    }


    $doviz_turu = $_GET["doviz_turu"];


    $alis_faturalari = DB::all_data("
SELECT
fatura_no,
vade_tarihi,
fatura_tarihi,
aciklama,
genel_toplam
FROM
alis_default
WHERE status=1 AND cari_key='$cari_key' AND uye_id='$cari_id' AND fatura_tarihi < '$last_bas_tarih 23:59:59'");

    $cari_devir_borc = 0;
    $cari_devir_alacak = 0;
    $cari_devir_bakiye = 0;
    $b_durum = "";
    $belge_turu = "";
    if ($alis_faturalari > 0) {
        foreach ($alis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }
//    $satis_faturalari = DB::all_data("
//SELECT
//belge_no,
//tarih,
//aciklama,
//tutar
//FROM
//pos_cekim
//WHERE status=1 AND cari_key='$cari_key' AND cari_id='$cari_id' AND tarih < '$last_bas_tarih 23:59:59'");
//    if ($satis_faturalari > 0) {
//        foreach ($satis_faturalari as $alislar) {
//            $cari_devir_alacak += $alislar["tutar"];
//        }
//    }

    $uye_tahakkuk = DB::all_data("
SELECT
       utu.tutar
FROM
     uye_tahakkuk AS utah
INNER JOIN uye_tahakkuk_urunler as utu on utu.tahakkuk_id=utah.id
INNER JOIN uye_tanim as ut on ut.id=utu.uye_id
WHERE utu.status=1 AND utah.status=1 AND utah.cari_key='$cari_key' AND ut.id='$cari_id' AND utu.tarih < '$last_bas_tarih 23:59:59'
");
    if ($uye_tahakkuk > 0) {
        foreach ($uye_tahakkuk as $item) {
            $cari_devir_borc += $item["tutar"];
        }
    }

    $satis_faturalari = DB::all_data("
SELECT
acg.tarih,
acu.seri_no,
acg.aciklama,
acu.vade_tarih,
acu.girilen_tutar
FROM
     alinan_cek_urunler AS acu
INNER JOIN alinan_cek_giris AS acg on acg.id=acu.alinan_cekid
WHERE acu.status!=0 AND acu.bizim=2 AND acg.acilis_mi!=2 AND acu.cari_key='$cari_key' AND acg.uye_id='$cari_id' AND acg.tarih < '$last_bas_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["girilen_tutar"];
        }
    }
//    $satis_faturalari = DB::all_data("
//SELECT
//acg.tarih,
//acu.seri_no,
//acg.aciklama,
//acu.vade_tarih,
//acu.girilen_tutar
//FROM
//     alinan_senet_urunler AS acu
//INNER JOIN alinan_senet_giris AS acg on acg.id=acu.alinan_senetid
//WHERE acu.status!=0 AND acg.doviz_tur='$doviz_turu' AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acg.tarih < '$last_bas_tarih 23:59:59'");
//    if ($satis_faturalari > 0) {
//        foreach ($satis_faturalari as $alislar) {
//            $cari_devir_alacak += $alislar["girilen_tutar"];
//        }
//    }

    $havale_giris = DB::all_data("
SELECT
hg.islem_tarihi,
hgu.giris_tutar,
hg.belge_no,
hgu.aciklama
FROM havale_giris_urunler as hgu
INNER JOIN havale_giris AS hg on hg.id=hgu.giris_id
INNER JOIN banka as b on b.id=hg.banka_id
WHERE hg.status=1 AND hgu.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.uye_id='$cari_id' AND hg.islem_tarihi < '$last_bas_tarih 23:59:59'");
    if ($havale_giris > 0) {
        foreach ($havale_giris as $giris) {
            $cari_devir_alacak += $giris["giris_tutar"];
        }
    }

    $kasa_tahsilat = DB::all_data("
SELECT
hg.islem_tarihi,
hgu.tutar,
hg.belge_no,
hg.aciklama
FROM kasa_tahsilat_urunler as hgu
INNER JOIN kasa_tahsilat AS hg on hg.id=hgu.tahsilat_id
WHERE hg.status=1 AND hgu.status=1 AND  hgu.cari_key='$cari_key' AND hgu.uye_id='$cari_id' AND hg.islem_tarihi < '$last_bas_tarih 23:59:59'");
    if ($kasa_tahsilat > 0) {
        foreach ($kasa_tahsilat as $giris) {
            $cari_devir_borc -= $giris["tutar"];
        }
    }
    $mahsup_hareketleri = DB::all_data("
SELECT
hg.islem_tarihi,
hgu.borc,
hgu.alacak,
hgu.aciklama,
hg.belge_no
FROM cari_mahsup_urunler as hgu
INNER JOIN cari_mahsup AS hg on hg.id=hgu.mahsup_id
WHERE hg.status=1 and  hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.uye_id='$cari_id' AND hg.islem_tarihi < '$last_bas_tarih 23:59:59'");

    if ($mahsup_hareketleri > 0) {
        foreach ($mahsup_hareketleri as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
        }
    }

    $acilis_fisi = DB::all_data("
SELECT
acilis_tarihi,
borc,
alacak
FROM uye_acilis_fisi
WHERE status=1 AND cari_key='$cari_key' AND uye_id='$cari_id' AND acilis_tarihi < '$last_bas_tarih 23:59:59'");
    if ($acilis_fisi > 0) {
        foreach ($acilis_fisi as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
        }
    }

    // BURAYA KADAR OLAN KISIM DEVİR İÇİN
    $cari_devir_bakiye = floatval($cari_devir_borc) - floatval($cari_devir_alacak);
    if ($cari_devir_bakiye < 0) {
        $cari_devir_bakiye = -$cari_devir_bakiye;
        $b_durum = "A";
    } else if ($cari_devir_bakiye == 0) {
        $b_durum = "YOK";
    } else {
        $b_durum = "B";
    }
    $devir_arr = [
        'tarih' => $sorgu_bas,
        'belge_no' => "....",
        'belge_turu' => ".....",
        'aciklama' => 'Bir Önceki Tarihten Devir',
        'borc' => $cari_devir_borc,
        'alacak' => $cari_devir_alacak,
        'bakiye' => $cari_devir_bakiye,
        'b_durum' => $b_durum,
        'vade_tarihi' => "",
        'doviz_tur' => "",
    ];
    array_push($ekstre_arr, $devir_arr);

    $ekstre_arr1 = [];

    $satis_faturalari = DB::all_data("
SELECT
acg.tarih,
acu.seri_no,
acg.aciklama,
acu.vade_tarih,
acu.girilen_tutar,
acg.doviz_tur
FROM
     alinan_cek_urunler AS acu
INNER JOIN alinan_cek_giris AS acg on acg.id=acu.alinan_cekid
WHERE acu.status!=0 AND acg.acilis_mi!=2 AND acg.status!=0 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.uye_id='$cari_id' AND acg.tarih BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'belge_no' => $alislar["seri_no"],
                'belge_turu' => 'Çek Giriş',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["vade_tarih"],
                'tutar' => $alislar["girilen_tutar"],
                'doviz_tur' => $alislar["doviz_tur"],
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }
//    $satis_faturalari = DB::all_data("
//SELECT
//belge_no,
//tarih,
//aciklama,
//tutar
//FROM
//pos_cekim
//WHERE status=1 AND cari_key='$cari_key' AND cari_id='$cari_id' AND tarih  BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59'");
//    if ($satis_faturalari > 0) {
//        foreach ($satis_faturalari as $alislar) {
//            $duzenle_arr3 = [
//                'tarih' => $alislar["tarih"],
//                'belge_no' => $alislar["belge_no"],
//                'belge_turu' => 'POS ÇEKİM',
//                'aciklama' => $alislar["aciklama"],
//                'vade_tarihi' => $alislar["tarih"],
//                'tutar' => $alislar["tutar"],
//                'doviz_tur' => "TL",
//            ];
//            array_push($ekstre_arr1, $duzenle_arr3);
//        }
//    }

//    $satis_faturalari = DB::all_data("
//SELECT
//acg.tarih,
//acu.seri_no,
//acg.aciklama,
//acu.vade_tarih,
//acu.girilen_tutar,
//acg.doviz_tur
//FROM
//     alinan_senet_urunler AS acu
//INNER JOIN alinan_senet_giris AS acg on acg.id=acu.alinan_senetid
//WHERE acu.status=1 AND acg.doviz_tur='$doviz_turu' AND acg.status!=0 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acg.tarih BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59'");
//    if ($satis_faturalari > 0) {
//        foreach ($satis_faturalari as $alislar) {
//            $duzenle_arr3 = [
//                'tarih' => $alislar["tarih"],
//                'belge_no' => $alislar["seri_no"],
//                'belge_turu' => 'Senet Giriş',
//                'aciklama' => $alislar["aciklama"],
//                'vade_tarihi' => $alislar["vade_tarih"],
//                'tutar' => $alislar["girilen_tutar"],
//                'doviz_tur' => $alislar["doviz_tur"],
//            ];
//            array_push($ekstre_arr1, $duzenle_arr3);
//        }
//    }


    $mahsup_hareketleri = DB::all_data("
SELECT
hg.islem_tarihi,
hgu.borc,
hgu.alacak,
hgu.aciklama,
hg.belge_no,
hg.doviz_tur
FROM cari_mahsup_urunler as hgu
INNER JOIN cari_mahsup AS hg on hg.id=hgu.mahsup_id
WHERE hg.status=1  and hgu.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.uye_id='$cari_id' AND hg.islem_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'");

    if ($mahsup_hareketleri > 0) {
        foreach ($mahsup_hareketleri as $faturalar) {
            $duzenle_arr3 = [
                'tarih' => $faturalar["islem_tarihi"],
                'belge_no' => $faturalar["belge_no"],
                'belge_turu' => 'Mahsup Fişi',
                'aciklama' => $faturalar["aciklama"],
                'vade_tarihi' => date("Y-m-d"),
                'alacak' => $faturalar["alacak"],
                'borc' => $faturalar["borc"],
                'doviz_tur' => $faturalar["doviz_tur"],
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }
    $alis_faturalari = DB::all_data("
SELECT
fatura_no,
vade_tarihi,
fatura_tarihi,
aciklama,
genel_toplam,
doviz_tur
FROM
alis_default
WHERE status=1 AND cari_key='$cari_key' AND uye_id='$cari_id' AND fatura_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($alis_faturalari > 0) {
        foreach ($alis_faturalari as $faturalar) {
            $duzenle_arr3 = [
                'tarih' => $faturalar["fatura_tarihi"],
                'belge_no' => $faturalar["fatura_no"],
                'belge_turu' => 'Alış Faturası',
                'aciklama' => $faturalar["aciklama"],
                'vade_tarihi' => $faturalar["vade_tarihi"],
                'tutar' => $faturalar["genel_toplam"],
                'doviz_tur' => $faturalar["doviz_tur"],
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }

    $uye_tahakkuk = DB::all_data("
SELECT
       utu.tutar,
       utu.tarih,
       utu.aciklama,
       utu.tarife_adi
FROM
     uye_tahakkuk AS utah
INNER JOIN uye_tahakkuk_urunler as utu on utu.tahakkuk_id=utah.id
INNER JOIN uye_tanim as ut on ut.id=utu.uye_id
WHERE utu.status=1 AND utah.status=1 AND ut.id='$cari_id' AND utu.tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($uye_tahakkuk > 0) {
        foreach ($uye_tahakkuk as $faturalar) {
            $duzenle_arr3 = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => $faturalar["tarife_adi"],
                'belge_turu' => 'ÜYE TAHAKKUK',
                'aciklama' => $faturalar["aciklama"],
                'vade_tarihi' => $faturalar["tarih"],
                'tutar' => $faturalar["tutar"],
                'doviz_tur' => "TL",
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }
    $havale_giris = DB::all_data("
SELECT
hg.islem_tarihi,
hgu.giris_tutar,
hg.belge_no,
hgu.aciklama,
b.doviz_tipi
FROM havale_giris_urunler as hgu
INNER JOIN havale_giris AS hg on hg.id=hgu.giris_id
INNER JOIN banka as b on b.id=hg.banka_id
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.uye_id='$cari_id' AND hg.islem_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'");

    if ($havale_giris > 0) {
        foreach ($havale_giris as $faturalar) {
            $duzenle_arr3 = [
                'tarih' => $faturalar["islem_tarihi"],
                'belge_no' => $faturalar["belge_no"],
                'belge_turu' => 'Havale Giriş',
                'aciklama' => $faturalar["aciklama"],
                'vade_tarihi' => date("Y-m-d"),
                'tutar' => $faturalar["giris_tutar"],
                'doviz_tur' => $faturalar["doviz_tipi"],
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }
    $kasa_tahsilat = DB::all_data("
SELECT
hg.islem_tarihi,
hgu.tutar,
hg.belge_no,
hgu.aciklama
FROM kasa_tahsilat_urunler as hgu
INNER JOIN kasa_tahsilat AS hg on hg.id=hgu.tahsilat_id
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.uye_id='$cari_id' AND hg.islem_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($kasa_tahsilat > 0) {
        foreach ($kasa_tahsilat as $faturalar) {
            $duzenle_arr3 = [
                'tarih' => $faturalar["islem_tarihi"],
                'belge_no' => $faturalar["belge_no"],
                'belge_turu' => 'Kasa Tahsilat',
                'aciklama' => $faturalar["aciklama"],
                'vade_tarihi' => date("Y-m-d"),
                'tutar' => $faturalar["tutar"],
                'doviz_tur' => "TL",
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }
    $acilis_fisi = DB::all_data("
SELECT
acilis_tarihi,
borc,
alacak
FROM uye_acilis_fisi
WHERE status=1 AND cari_key='$cari_key' AND uye_id='$cari_id' AND acilis_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'");

    if ($acilis_fisi > 0) {
        foreach ($acilis_fisi as $faturalar) {
            $duzenle_arr3 = [
                'tarih' => $faturalar["acilis_tarihi"],
                'belge_no' => $faturalar["belge_no"],
                'belge_turu' => 'Açılış Fişi',
                'aciklama' => "",
                'vade_tarihi' => date("Y-m-d"),
                'borc' => $faturalar["borc"],
                'alacak' => $faturalar["alacak"],
                'doviz_tur' => "TL",
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }

    usort($ekstre_arr1, function ($a, $b) {
        $tarihA = strtotime($a['tarih']); // $a dizisindeki tarih değerini alıp zaman damgasına dönüştür
        $tarihB = strtotime($b['tarih']);
        if ($tarihA == $tarihB) {
            return 0;
        }

        return ($tarihA < $tarihB) ? -1 : 1;
    });

    $gidecek_array = [];
    array_push($gidecek_array, $ekstre_arr[0]);
    foreach ($ekstre_arr1 as $dizaynli_bilgi) {
        $borc = 0;
        $alacak = 0;
        if ($dizaynli_bilgi["belge_turu"] == "Alış Faturası") {
            $alacak = $dizaynli_bilgi["tutar"];

            if ($b_durum == "A") {
                $cari_devir_bakiye += $alacak;
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $alacak;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $cari_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "Alış Faturası",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "Mahsup Fişi") {
            if ($dizaynli_bilgi["borc"] != 0) {
                $borc = $dizaynli_bilgi["borc"];
                if ($b_durum == "B") {
                    $cari_devir_bakiye += $borc;
                    $b_durum = "B";
                } else if ($b_durum == "A") {
                    $cari_devir_bakiye -= $borc;
                    if ($cari_devir_bakiye < 0) {
                        $cari_devir_bakiye = -$cari_devir_bakiye;
                        $b_durum = "B";
                    } else if ($cari_devir_bakiye == 0) {
                        $b_durum = "YOK";
                    }
                } else {
                    $b_durum = "B";
                    $cari_devir_bakiye += $borc;
                }

                $duzenle_arr3 = [
                    'tarih' => $dizaynli_bilgi["tarih"],
                    'belge_no' => $dizaynli_bilgi["belge_no"],
                    'belge_turu' => "Mahsup Fişi",
                    'aciklama' => $dizaynli_bilgi["aciklama"],
                    'borc' => $borc,
                    'alacak' => $alacak,
                    'bakiye' => $cari_devir_bakiye,
                    'b_durum' => $b_durum,
                    'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                    'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
                ];
                array_push($gidecek_array, $duzenle_arr3);
            } else {

                $alacak = $dizaynli_bilgi["alacak"];
                if ($b_durum == "A") {
                    $cari_devir_bakiye += $alacak;
                } else if ($b_durum == "B") {
                    $cari_devir_bakiye -= $alacak;
                    if ($cari_devir_bakiye < 0) {
                        $cari_devir_bakiye = -$cari_devir_bakiye;
                        $b_durum = "A";
                    } else if ($cari_devir_bakiye == 0) {
                        $b_durum = "YOK";
                    }
                } else {
                    $b_durum = "A";
                    $cari_devir_bakiye += $alacak;
                }
                $duzenle_arr2 = [
                    'tarih' => $dizaynli_bilgi["tarih"],
                    'belge_no' => $dizaynli_bilgi["belge_no"],
                    'belge_turu' => "Mahsup Fişi",
                    'aciklama' => $dizaynli_bilgi["aciklama"],
                    'borc' => $borc,
                    'alacak' => $alacak,
                    'bakiye' => $cari_devir_bakiye,
                    'b_durum' => $b_durum,
                    'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                    'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
                ];
                array_push($gidecek_array, $duzenle_arr2);
            }
        } else if ($dizaynli_bilgi["belge_turu"] == "Lastik Alış Faturası") {
            $alacak = $dizaynli_bilgi["tutar"];

            if ($b_durum == "A") {
                $cari_devir_bakiye += $alacak;
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $alacak;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $cari_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "Lastik Alış Faturası",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "Depo Alış Faturası") {
            $alacak = $dizaynli_bilgi["tutar"];

            if ($b_durum == "A") {
                $cari_devir_bakiye += $alacak;
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $alacak;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $cari_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "Depo Alış Faturası",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "ARACA STOK ÇIKIŞI") {
            $borc = $dizaynli_bilgi["tutar"];

            if ($b_durum == "B") {
                $cari_devir_bakiye += $borc;
                $b_durum = "B";
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $borc;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "B";
                $cari_devir_bakiye += $borc;
            }
            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "ARACA STOK ÇIKIŞI",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "YAKIT ALIM FATURASI") {
            $alacak = $dizaynli_bilgi["tutar"];

            if ($b_durum == "A") {
                $cari_devir_bakiye += $alacak;
                $b_durum = "A";
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $alacak;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $cari_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "YAKIT ALIM FATURASI",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "Maaş Tahakkuk") {
            $alacak = $dizaynli_bilgi["tutar"];

            if ($b_durum == "A") {
                $cari_devir_bakiye += $alacak;
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $alacak;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $cari_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "Maaş Tahakkuk",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "Muhasebe Gider Faturası") {
            $alacak = $dizaynli_bilgi["tutar"];

            if ($b_durum == "A") {
                $cari_devir_bakiye += $alacak;
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $alacak;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $cari_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "Gider Faturası",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "ARAC GİDER") {
            $alacak = $dizaynli_bilgi["tutar"];

            if ($b_durum == "A") {
                $cari_devir_bakiye += $alacak;
                $b_durum = "A";
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $alacak;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $cari_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "ARAC GİDER",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "SGK GİDER") {
            $alacak = $dizaynli_bilgi["tutar"];

            if ($b_durum == "A") {
                $cari_devir_bakiye += $alacak;
                $b_durum = "A";
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $alacak;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $cari_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "SGK GİDER",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "YÖNETİM GİDER") {
            $alacak = $dizaynli_bilgi["tutar"];

            if ($b_durum == "A") {
                $cari_devir_bakiye += $alacak;
                $b_durum = "A";
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $alacak;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $cari_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "YÖNETİM GİDER",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "VERGİ GİDER") {
            $alacak = $dizaynli_bilgi["tutar"];

            if ($b_durum == "A") {
                $cari_devir_bakiye += $alacak;
                $b_durum = "A";
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $alacak;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $cari_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "VERGİ GİDER",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "Satış Faturası") {
            $borc = $dizaynli_bilgi["tutar"];

            if ($b_durum == "B") {
                $cari_devir_bakiye += $borc;
                $b_durum = "B";
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $borc;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "B";
                $cari_devir_bakiye += $borc;
            }
            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "Satış Faturası",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "Depo Satış Faturası") {
            $borc = $dizaynli_bilgi["tutar"];

            if ($b_durum == "B") {
                $cari_devir_bakiye += $borc;
                $b_durum = "B";
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $borc;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "B";
                $cari_devir_bakiye += $borc;
            }
            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "Depo Satış Faturası",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "YAKIT ALIM FİŞİ") {
            $borc = $dizaynli_bilgi["tutar"];

            if ($b_durum == "B") {
                $cari_devir_bakiye += $borc;
                $b_durum = "B";
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $borc;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "B";
                $cari_devir_bakiye += $borc;
            }
            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "YAKIT ALIM FİŞİ",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "Kredi Kartından Ödeme") {
            $borc = $dizaynli_bilgi["tutar"];

            if ($b_durum == "B") {
                $cari_devir_bakiye += $borc;
                $b_durum = "B";
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $borc;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "B";
                $cari_devir_bakiye += $borc;
            }
            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "Kredi Kartından Ödeme",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "Havale Giriş") {
            $alacak = $dizaynli_bilgi["tutar"];
            if ($b_durum == "A") {
                $cari_devir_bakiye += $alacak;
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $alacak;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $cari_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "Havale Giriş",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "POS ÇEKİM") {
            $alacak = $dizaynli_bilgi["tutar"];

            if ($b_durum == "A") {
                $cari_devir_bakiye += $alacak;
                $b_durum = "A";
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $alacak;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $cari_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "POS ÇEKİM",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "Çek Giriş") {
            $alacak = $dizaynli_bilgi["tutar"];

            if ($b_durum == "A") {
                $cari_devir_bakiye += $alacak;
                $b_durum = "A";
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $alacak;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $cari_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "Çek Giriş",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "Sanayi Faturası") {
            $alacak = $dizaynli_bilgi["tutar"];

            if ($b_durum == "A") {
                $cari_devir_bakiye += $alacak;
                $b_durum = "A";
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $alacak;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $cari_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "Sanayi Faturası",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "Binek Sanayi Faturası") {
            $alacak = $dizaynli_bilgi["tutar"];

            if ($b_durum == "A") {
                $cari_devir_bakiye += $alacak;
                $b_durum = "A";
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $alacak;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $cari_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "Binek Sanayi Faturası",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "Senet Giriş") {
            $alacak = $dizaynli_bilgi["tutar"];

            if ($b_durum == "A") {
                $cari_devir_bakiye += $alacak;
                $b_durum = "A";
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $alacak;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $cari_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "Senet Giriş",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "Havale Çıkış") {

            $borc = $dizaynli_bilgi["tutar"];

            if ($b_durum == "B") {
                $cari_devir_bakiye += $borc;
                $b_durum = "B";
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $borc;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "B";
                $cari_devir_bakiye += $borc;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "Havale Çıkış",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "Karşılıksız Çek") {

            $borc = $dizaynli_bilgi["tutar"];

            if ($b_durum == "B") {
                $cari_devir_bakiye += $borc;
                $b_durum = "B";
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $borc;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "B";
                $cari_devir_bakiye += $borc;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "Karşılıksız Çek",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "Verilen Çek") {

            $borc = $dizaynli_bilgi["tutar"];

            if ($b_durum == "B") {
                $cari_devir_bakiye += $borc;
                $b_durum = "B";
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $borc;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "B";
                $cari_devir_bakiye += $borc;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "Verilen Çek",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "Çek Çıkış") {

            $borc = $dizaynli_bilgi["tutar"];

            if ($b_durum == "B") {
                $cari_devir_bakiye += $borc;
                $b_durum = "B";
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $borc;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "B";
                $cari_devir_bakiye += $borc;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "Çek Çıkış",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "Bizden Verilen Senet") {

            $borc = $dizaynli_bilgi["tutar"];

            if ($b_durum == "B") {
                $cari_devir_bakiye += $borc;
                $b_durum = "B";
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $borc;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "B";
                $cari_devir_bakiye += $borc;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "Bizden Verilen Senet",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "Kasa Tahsilat") {
            $alacak = $dizaynli_bilgi["tutar"];

            if ($b_durum == "A") {
                $cari_devir_bakiye += $alacak;
                $b_durum = "A";
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $alacak;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $cari_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "Kasa Tahsilat",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "ÜYE TAHAKKUK") {
            $borc = $dizaynli_bilgi["tutar"];

            if ($b_durum == "B") {
                $cari_devir_bakiye += $borc;
                $b_durum = "B";
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $borc;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "B";
                $cari_devir_bakiye += $borc;
            }
            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "ÜYE TAHAKKUK",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "Kasa Ödeme") {
            $borc = $dizaynli_bilgi["tutar"];

            if ($b_durum == "B") {
                $cari_devir_bakiye += $borc;
                $b_durum = "B";
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $borc;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "B";
                $cari_devir_bakiye += $borc;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'belge_no' => $dizaynli_bilgi["belge_no"],
                'belge_turu' => "Kasa Ödeme",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
            ];
            array_push($gidecek_array, $duzenle_arr2);
        } else if ($dizaynli_bilgi["belge_turu"] == "Mahsup Fişi") {
            if ($dizaynli_bilgi["borc"] != 0) {
                $borc = $dizaynli_bilgi["borc"];
                if ($b_durum == "B") {
                    $cari_devir_bakiye += $borc;
                    $b_durum = "B";
                } else if ($b_durum == "A") {
                    $cari_devir_bakiye -= $borc;
                    if ($cari_devir_bakiye < 0) {
                        $cari_devir_bakiye = -$cari_devir_bakiye;
                        $b_durum = "B";
                    } else if ($cari_devir_bakiye == 0) {
                        $b_durum = "YOK";
                    }
                } else {
                    $b_durum = "B";
                    $cari_devir_bakiye += $borc;
                }

                $duzenle_arr3 = [
                    'tarih' => $dizaynli_bilgi["tarih"],
                    'belge_no' => $dizaynli_bilgi["belge_no"],
                    'belge_turu' => "Mahsup Fişi",
                    'aciklama' => $dizaynli_bilgi["aciklama"],
                    'borc' => $borc,
                    'alacak' => $alacak,
                    'bakiye' => $cari_devir_bakiye,
                    'b_durum' => $b_durum,
                    'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                    'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
                ];
                array_push($gidecek_array, $duzenle_arr3);
            } else {

                $alacak = $dizaynli_bilgi["alacak"];
                if ($b_durum == "A") {
                    $cari_devir_bakiye += $alacak;
                } else if ($b_durum == "B") {
                    $cari_devir_bakiye -= $alacak;
                    if ($cari_devir_bakiye < 0) {
                        $cari_devir_bakiye = -$cari_devir_bakiye;
                        $b_durum = "A";
                    } else if ($cari_devir_bakiye == 0) {
                        $b_durum = "YOK";
                    }
                } else {
                    $b_durum = "A";
                    $cari_devir_bakiye += $alacak;
                }
                $duzenle_arr2 = [
                    'tarih' => $dizaynli_bilgi["tarih"],
                    'belge_no' => $dizaynli_bilgi["belge_no"],
                    'belge_turu' => "Mahsup Fişi",
                    'aciklama' => $dizaynli_bilgi["aciklama"],
                    'borc' => $borc,
                    'alacak' => $alacak,
                    'bakiye' => $cari_devir_bakiye,
                    'b_durum' => $b_durum,
                    'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                    'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
                ];
                array_push($gidecek_array, $duzenle_arr2);
            }
        } else if ($dizaynli_bilgi["belge_turu"] == "Açılış Fişi") {
            if ($dizaynli_bilgi["borc"] != 0) {
                $borc = $dizaynli_bilgi["borc"];
                if ($b_durum == "B") {
                    $cari_devir_bakiye += $borc;
                    $b_durum = "B";
                } else if ($b_durum == "A") {
                    $cari_devir_bakiye -= $borc;
                    if ($cari_devir_bakiye < 0) {
                        $cari_devir_bakiye = -$cari_devir_bakiye;
                        $b_durum = "B";
                    } else if ($cari_devir_bakiye == 0) {
                        $b_durum = "YOK";
                    }
                } else {
                    $b_durum = "B";
                    $cari_devir_bakiye += $borc;
                }
                $duzenle_arr2 = [
                    'tarih' => $dizaynli_bilgi["tarih"],
                    'belge_no' => $dizaynli_bilgi["belge_no"],
                    'belge_turu' => "Açılış Fişi",
                    'aciklama' => $dizaynli_bilgi["aciklama"],
                    'borc' => $borc,
                    'alacak' => 0,
                    'bakiye' => $cari_devir_bakiye,
                    'b_durum' => $b_durum,
                    'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                    'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
                ];
                array_push($gidecek_array, $duzenle_arr2);
            }
            if ($dizaynli_bilgi["alacak"] != 0) {
                $alacak = $dizaynli_bilgi["alacak"];
                if ($b_durum == "A") {
                    $cari_devir_bakiye += $alacak;
                    $b_durum = "A";
                } else if ($b_durum == "B") {
                    $cari_devir_bakiye -= $alacak;
                    if ($cari_devir_bakiye < 0) {
                        $cari_devir_bakiye = -$cari_devir_bakiye;
                        $b_durum = "A";
                    } else if ($cari_devir_bakiye == 0) {
                        $b_durum = "YOK";
                    }
                } else {
                    $b_durum = "A";
                    $cari_devir_bakiye += $alacak;
                }
                $duzenle_arr2 = [
                    'tarih' => $dizaynli_bilgi["tarih"],
                    'belge_no' => $dizaynli_bilgi["belge_no"],
                    'belge_turu' => "Açılış Fişi",
                    'aciklama' => $dizaynli_bilgi["aciklama"],
                    'borc' => 0,
                    'alacak' => $alacak,
                    'bakiye' => $cari_devir_bakiye,
                    'b_durum' => $b_durum,
                    'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"],
                    'doviz_tur' => $dizaynli_bilgi["doviz_tur"],
                ];
                array_push($gidecek_array, $duzenle_arr2);
            }
        }
    }
    usort($gidecek_array, function ($a, $b) {
        $tarihA = strtotime($a['tarih']); // $a dizisindeki tarih değerini alıp zaman damgasına dönüştür
        $tarihB = strtotime($b['tarih']);
        if ($tarihA == $tarihB) {
            return 0;
        }

        return ($tarihA < $tarihB) ? -1 : 1;
    });

    if ($gidecek_array > 0) {
        echo json_encode($gidecek_array);
    } else {
        echo 2;
    }
}
if ($islem == "uye_borc_alacak_durumu_filtrele") {
    $bas_tarih = $_GET["bas_tarih"];
    $bit_tarih = $_GET["bit_tarih"];
    $cari_turu = $_GET["cari_turu"];

    $last_bas_tarih = $bit_tarih;
    $yil_basi = $bas_tarih;
    $sql = "
SELECT 
       c.tc_no,
       c.uye_adi,
       c.id, 
       (select SUM(cmu1.borc) from cari_mahsup_urunler as cmu1 inner join cari_mahsup as cm1 on cm1.id=cmu1.mahsup_id WHERE cm1.status=1 AND cmu1.status=1 AND cmu1.cari_id=c.id AND cm1.islem_tarihi < '$last_bas_tarih 23:59:59') as borc11,
       (select SUM(cmu.alacak) from cari_mahsup_urunler as cmu inner join cari_mahsup as cm on cm.id=cmu.mahsup_id WHERE cm.status=1 AND cmu.status=1 AND cmu.cari_id=c.id AND cm.islem_tarihi < '$last_bas_tarih 23:59:59') as alacak22,
       (select SUM(genel_toplam) FROM alis_default as ad WHERE ad.uye_id=c.id AND ad.status=1 AND ad.fatura_tarihi < '$last_bas_tarih 23:59:59') as alacak1,
       (select SUM(acu.girilen_tutar) from alinan_cek_urunler as acu inner join alinan_cek_giris as acg on acg.id=acu.alinan_cekid WHERE acg.status!=0 AND acu.status!=0 AND acu.bizim=2 AND acg.acilis_mi!=2 AND acg.uye_id=c.id AND acg.tarih < '$last_bas_tarih 23:59:59') as alacak13,
       (select SUM(ktu.tutar) from kasa_tahsilat_urunler as ktu inner join kasa_tahsilat as kt on kt.id=ktu.tahsilat_id WHERE kt.status=1 AND ktu.status=1 AND ktu.uye_id=c.id AND kt.islem_tarihi < '$last_bas_tarih 23:59:59') as alacak16,   
       (select SUM(caf1.borc) from uye_acilis_fisi as caf1 WHERE caf1.uye_id=c.id AND caf1.status=1 AND caf1.acilis_tarihi < '$last_bas_tarih 23:59:59') as borc9,
       (select SUM(caf.alacak) from uye_acilis_fisi as caf WHERE caf.uye_id=c.id and caf.status=1 AND caf.acilis_tarihi < '$last_bas_tarih 23:59:59') as alacak18
FROM 
     uye_tanim as c
WHERE 
      c.status=1 
  AND 
      c.cari_key='$cari_key'
";
    $sql .= " GROUP BY 
c.id";
    $ekstre_arr = [];
    // BURAYA KADAR OLAN KISIM DOĞRU CARİLERİ ÇEKMEK ADINA YAPILAN BİR FİLTRELEME

    $dogru_cariler = DB::all_data($sql);
    foreach ($dogru_cariler as $item) {

        $cari_devir_borc = 0;
        $cari_devir_alacak = 0;
        $cari_id = $item["id"];
        $uye_tahakkuk = DB::all_data("
SELECT
       utu.tutar
FROM
     uye_tahakkuk AS utah
INNER JOIN uye_tahakkuk_urunler as utu on utu.tahakkuk_id=utah.id
INNER JOIN uye_tanim as ut on ut.id=utu.uye_id
WHERE utu.status=1 AND utah.status=1 AND utah.cari_key='$cari_key' AND ut.id='$cari_id' AND utu.tarih < '$last_bas_tarih 23:59:59'
");
        if ($uye_tahakkuk > 0) {
            foreach ($uye_tahakkuk as $item2) {
                $cari_devir_borc += $item2["tutar"];
            }
        }
        $cari_devir_borc += $item["borc1"];
        $cari_devir_borc += $item["borc2"];
        $cari_devir_borc += $item["borc3"];
        $cari_devir_borc += $item["borc4"];
        $cari_devir_borc += $item["borc5"];
        $cari_devir_borc += $item["borc6"];
        $cari_devir_borc += $item["borc7"];
        $cari_devir_borc += $item["borc8"];
        $cari_devir_borc += $item["borc9"];
        $cari_devir_borc += $item["borc10"];
        $cari_devir_borc += $item["borc11"];

        $cari_devir_alacak += $item["alacak1"];
        $cari_devir_alacak += $item["alacak2"];
        $cari_devir_alacak += $item["alacak3"];
        $cari_devir_alacak += $item["alacak4"];
        $cari_devir_alacak += $item["alacak5"];
        $cari_devir_alacak += $item["alacak6"];
        $cari_devir_alacak += $item["alacak7"];
        $cari_devir_alacak += $item["alacak8"];
        $cari_devir_alacak += $item["alacak9"];
        $cari_devir_alacak += $item["alacak10"];
        $cari_devir_alacak += $item["alacak11"];
        $cari_devir_alacak += $item["alacak12"];
        $cari_devir_alacak += $item["alacak13"];
        $cari_devir_alacak += $item["alacak14"];
        $cari_devir_alacak += $item["alacak15"];
        $cari_devir_alacak += $item["alacak16"];
        $cari_devir_alacak += $item["alacak17"];
        $cari_devir_alacak += $item["alacak18"];
        $cari_devir_alacak += $item["alacak22"];

        $cari_devir_bakiye = floatval($cari_devir_borc) - floatval($cari_devir_alacak);
        if ($cari_devir_bakiye < 0) {
            $cari_devir_bakiye = -$cari_devir_bakiye;
            $b_durum = "A";
        } else if ($cari_devir_bakiye > 0) {
            $b_durum = "B";
        } else {
            $b_durum = "YOK";
        }
        $devir_arr = [
            'cari_kodu' => $item["tc_no"],
            'cari_unvan' => $item["uye_adi"],
            'cari_grubu' => $item["abone_mi"],
            'borc' => $cari_devir_borc,
            'alacak' => $cari_devir_alacak,
            'bakiye' => $cari_devir_bakiye,
            'b_durum' => $b_durum,
            'aciklama' => ""
        ];
        array_push($ekstre_arr, $devir_arr);
    }
    if ($ekstre_arr > 0) {
        echo json_encode($ekstre_arr);
    } else {
        echo 2;
    }
}
if ($islem == "tarife_bilgilerini_getir_sql") {
    $tarife_kodu = $_GET["tarife_kodu"];

    $tarife = DB::single_query("SELECT * FROM uye_tarife_tanim WHERE status=1 AND cari_key='$cari_key' AND tarife_kodu='$tarife_kodu'");
    if ($tarife > 0) {
        echo json_encode($tarife);
    } else {
        echo 2;
    }
}
if ($islem == "tum_tarifeleri_getir_sql") {
    $uye_mi = $_GET["uye_mi"];
    $ek = "";
    if ($uye_mi != "") {
        $ek = " AND uye_mi='$uye_mi'";
    }
    $tarife = DB::all_data("SELECT * FROM uye_tarife_tanim WHERE status=1 AND cari_key='$cari_key' $ek");
    if ($tarife > 0) {
        echo json_encode($tarife);
    } else {
        echo 2;
    }
}
if ($islem == "bireysel_tahakkuk_kaydet_sql") {
    foreach ($_POST["gidecek_arr"] as $item) {
        $item["insert_userid"] = $_SESSION["user_id"];
        $item["insert_datetime"] = date("Y-m-d H:i:s");
        $item["cari_key"] = $cari_key;
        $item["sube_key"] = $sube_key;
        $tahakkuk_kaydet = DB::insert("bireysel_tahakkuk", $item);
    }
    if ($tahakkuk_kaydet) {
        echo 500;
    } else {
        echo 1;
    }
}
if ($islem == "bireysel_tahakku_islemlerini_getir_sql") {
    $bireysel_tahakkuklar = DB::all_data("
SELECT
       ut.tc_no,
       ut.uye_adi,
       bt.tarih,
       bt.kasa_id,
       bt.banka_id,
       bt.pos_id,
       bt.tutar,
       utaf.tarife_adi,
       bt.aciklama,
       bt.id
FROM bireysel_tahakkuk as bt
INNER JOIN uye_tanim as ut on ut.id=bt.uye_id
INNER JOIN uye_tarife_tanim as utaf on utaf.id=bt.tarife_id
WHERE bt.status=1 AND bt.cari_key='$cari_key'
");
    if ($bireysel_tahakkuklar > 0) {
        $gidecek_arr = [];
        $toplam_tahakkuk = 0;
        foreach ($bireysel_tahakkuklar as $item) {
            $odeme_yontemi = "";
            if ($item["banka_id"] != 0) {
                $odeme_yontemi = "Banka";
            } else if ($item["kasa_id"] != 0) {
                $odeme_yontemi = "Kasa";
            } else if ($item["pos_id"] != 0) {
                $odeme_yontemi = "Kart Çekimi";
            }
            $toplam_tahakkuk += $item["tutar"];

            $arr = [
                'tc_no' => $item["tc_no"],
                'uye_adi' => $item["uye_adi"],
                'tarih' => date("d/m/Y", strtotime($item["tarih"])),
                'odeme_yontemi' => $odeme_yontemi,
                'tutar' => number_format($item["tutar"], 2),
                'tarife' => $item["tarife_adi"],
                'aciklama' => $item["aciklama"],
                'islem' => "<button class='btn btn-sm bireysel_tahakkuk_guncelle_button' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm yukleme_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
            ];
            array_push($gidecek_arr, $arr);
        }
        if (!empty($gidecek_arr)) {
            $gidecek_arr[0]["toplam_tahakkuk"] = number_format($toplam_tahakkuk, 2);
            echo json_encode($gidecek_arr);
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "bireysel_tahakkuk_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $sil = DB::update("bireysel_tahakkuk", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "uyeye_ait_tapulari_getir_sql") {
    if (isset($_GET["tc_no"])) {
        $tc = $_GET["tc_no"];
        $uye = DB::single_query("SELECT id FROM uye_tanim WHERE status=1 AND tc_no='$tc' AND cari_key='$cari_key'");
        $uye_id = $uye["id"];
    } else {
        $uye_id = $_GET["id"];
    }
    $tapulari = DB::all_data("SELECT * FROM uye_tapu WHERE status=1 AND uye_id='$uye_id' AND cari_key='$cari_key'");
    $tum_tarifeler = [];
    $i = 0;
    foreach ($tapulari as $item) {
        $tapu_id = $item["id"];
        $tarifeleri = DB::all_data("SELECT
       utt.tarife_kodu,
       utt.tarife_adi,
       utt.tarife_fiyati,
       ut.sulama_metrekare as metre_kare
FROM
     uye_tarifeleri as ut
INNER JOIN uye_tarife_tanim as utt on utt.id=ut.tarife_id
WHERE
      ut.status=1 AND ut.tapu_id='$tapu_id' AND ut.cari_key='$cari_key'");
        foreach ($tarifeleri as $item) {
            $tum_tarifeler = $tarifeleri;
        }
        $tapulari[$i]["data_array"] = $tum_tarifeler;
        $i++;
    }
    if ($tapulari > 0) {
        echo json_encode($tapulari);
    } else {
        echo 2;
    }
}
if ($islem == "bireysel_tahakkuk_detayini_getir_sql") {
    $id = $_GET["id"];
    $bireysel_tahakkuk = DB::single_query("
SELECT
       bt.*,
       ut.uye_adi,
       ut.tc_no,
       utt.tarife_adi,
       b.banka_adi,
       pos_b.banka_adi as pos_adi,
       k.kasa_adi
FROM
     bireysel_tahakkuk as bt
LEFT JOIN kasa as k on k.id=bt.kasa_id
LEFT JOIN banka as b on b.id=bt.banka_id
LEFT JOIN pos_tanim as pt on pt.id=bt.pos_id
LEFT JOIN banka as pos_b on pos_b.id=pt.banka_id
INNER JOIN uye_tanim as ut on ut.id=bt.uye_id
LEFT JOIN uye_tarife_tanim as utt on utt.id=bt.tarife_id
WHERE bt.status=1 AND bt.cari_key='$cari_key' GROUP  BY bt.id
");
    if ($bireysel_tahakkuk > 0) {
        echo json_encode($bireysel_tahakkuk);
    } else {
        echo 2;
    }
}
if ($islem == "bireysel_tahakkuk_guncelle") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DB::update("bireysel_tahakkuk", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "dummy_tapu_ekle_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    if (isset($_POST["tc_no"])) {
        $tc = $_POST["tc_no"];
        $uye = DB::single_query("SELECT id FROM uye_tanim WHERE tc_no='$tc' AND cari_key='$cari_key'");
        if ($uye > 0) {
            $_POST["uye_id"] = $uye["id"];
        }
    }
    $dummy_tapu_ekle = DB::insert("uye_tapu", $_POST);
    if ($dummy_tapu_ekle) {
        echo 500;
    } else {
        $son_eklenen = DB::single_query("SELECT id FROM uye_tapu where  cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        echo 'id:' . $son_eklenen["id"];
    }
}
if ($islem == "dummy_tapulari_getir_sql") {
    $tc_no = $_GET["tc_no"];
    $dummy_tapular = DB::all_data("SELECT * FROM uye_tapu WHERE status=1 AND cari_key='$cari_key' AND tc_no='$tc_no'");
    if ($dummy_tapular > 0) {
        echo json_encode($dummy_tapular);
    } else {
        echo 2;
    }
}
if ($islem == "tapuya_tarife_ekle_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    if (isset($_POST["tc_no"])) {
        $tc = $_POST["tc_no"];
        $uye = DB::single_query("SELECT id FROM uye_tanim WHERE tc_no='$tc' AND cari_key='$cari_key'");
        $_POST["uye_id"] = $uye["id"];
        unset($_POST["tc_no"]);
    }

    $ekle = DB::insert("uye_tarifeleri", $_POST);
    if ($ekle) {
        echo 500;
    } else {
        $son_eklenen = DB::single_query("
SELECT
       ut.mahalle_koy,
       utaf.id,
       utt.tarife_kodu,
       utt.tarife_fiyati,
       utaf.sulama_metrekare
FROM
     uye_tarifeleri as utaf
INNER JOIN uye_tapu as ut on ut.id=utaf.tapu_id
INNER JOIN uye_tarife_tanim as utt on utt.id=utaf.tarife_id
where 
      utaf.cari_key='$cari_key' ORDER BY utaf.id DESC LIMIT 1");
        if ($son_eklenen > 0) {
            echo json_encode($son_eklenen);
        } else {
            echo 2;
        }
    }
}
if ($islem == "uye_tarifesini_sil_sql") {
    $_POST["status"] = 0;
    $sil = DB::update("uye_tarifeleri", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "uyeye_ait_tapu_sil_sql") {
    $_POST["status"] = 0;
    $sil = DB::update("uye_tapu", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "tapuya_ait_tarifeleri_getir_sql") {
    $tapu_id = $_GET["id"];
    $tarifeler = DB::all_data("
SELECT 
       utap.mahalle_koy,
       utt.tarife_kodu,
       utt.tarife_fiyati,
       utaf.sulama_metrekare,
       utaf.id
FROM
     uye_tarifeleri as utaf
INNER JOIN uye_tapu as utap on utap.id=utaf.tapu_id
INNER JOIN uye_tarife_tanim as utt on utt.id=utaf.tarife_id
WHERE 
      utaf.status=1 AND utaf.tapu_id='$tapu_id'");
    if ($tarifeler > 0) {
        echo json_encode($tarifeler);
    } else {
        echo 2;
    }
}
if ($islem == "uyenini_tum_tarifelerini_getir_sql") {
    $tc_no = $_GET["tc_no"];
    $uye = DB::single_query("SELECT * FROM uye_tanim WHERE status=1 AND tc_no='$tc_no'");
    $uye_id = $uye["id"];
    $tarifeleri = DB::all_data("
SELECT
       ut.mahalle_koy,
       utt.tarife_kodu,
       utt.tarife_fiyati,
       utaf.sulama_metrekare
FROM
     uye_tarifeleri as utaf
LEFT JOIN uye_tarife_tanim as utt on utt.id=utaf.tarife_id
LEFT JOIN uye_tapu as ut on utaf.tapu_id=ut.id
WHERE utaf.status=1 AND utaf.uye_id='$uye_id' AND utaf.cari_key='$cari_key'");

    if ($tarifeleri > 0) {
        echo json_encode($tarifeleri);
    } else {
        echo 2;
    }
}
if ($islem == "sms_yollanan_kisiler") {
    $id = $_GET["id"];

    $yollanan_kisiler = DB::all_data("
SELECT
       sgd.ad_soyad
FROM
     sms_gonder AS sg
INNER JOIN sms_gonder_detay as sgd on sgd.sms_id=sg.id
WHERE sg.status=1 AND sg.id='$id'
");
    if ($yollanan_kisiler > 0) {
        echo json_encode($yollanan_kisiler);
    } else {
        echo 2;
    }

}
if ($islem == "borc_alacak_durumunu_getir_sql") {
    $sql = "
SELECT 
       c.tc_no,
       c.uye_adi,
       c.id,
       c.cep_no,
       ut.tarife_id,
       (select SUM(cmu1.borc) from cari_mahsup_urunler as cmu1 inner join cari_mahsup as cm1 on cm1.id=cmu1.mahsup_id WHERE cm1.status=1 AND cmu1.status=1 AND cmu1.cari_id=c.id) as borc11,
       (select SUM(cmu.alacak) from cari_mahsup_urunler as cmu inner join cari_mahsup as cm on cm.id=cmu.mahsup_id WHERE cm.status=1 AND cmu.status=1 AND cmu.cari_id=c.id) as alacak22,
       (select SUM(genel_toplam) FROM alis_default as ad WHERE ad.uye_id=c.id AND ad.status=1 AND ad.fatura_tarihi ) as alacak1,
       (select SUM(acu.girilen_tutar) from alinan_cek_urunler as acu inner join alinan_cek_giris as acg on acg.id=acu.alinan_cekid WHERE acg.status!=0 AND acu.status!=0 AND acu.bizim=2 AND acg.acilis_mi!=2 AND acg.uye_id=c.id) as alacak13,
       (select SUM(ktu.tutar) from kasa_tahsilat_urunler as ktu inner join kasa_tahsilat as kt on kt.id=ktu.tahsilat_id WHERE kt.status=1 AND ktu.status=1 AND ktu.uye_id=c.id) as alacak16,   
       (select SUM(caf1.borc) from uye_acilis_fisi as caf1 WHERE caf1.uye_id=c.id AND caf1.status=1) as borc9,
       (select SUM(caf.alacak) from uye_acilis_fisi as caf WHERE caf.uye_id=c.id and caf.status=1) as alacak18
FROM 
     uye_tanim as c
INNER JOIN uye_tarifeleri as ut on ut.uye_id=c.id
WHERE 
      c.status=1 
  AND 
      c.cari_key='$cari_key'
";
    if (isset($_GET["tarife_id"])) {
        $tarife_id = $_GET["tarife_id"];
        if ($tarife_id != "") {
            $sql .= " AND ut.tarife_id='$tarife_id'";
        }
    }

    $sql .= " GROUP BY 
c.id";
    $ekstre_arr = [];
    // BURAYA KADAR OLAN KISIM DOĞRU CARİLERİ ÇEKMEK ADINA YAPILAN BİR FİLTRELEME

    $dogru_cariler = DB::all_data($sql);
    foreach ($dogru_cariler as $item) {

        $cari_devir_borc = 0;
        $cari_devir_alacak = 0;
        $cari_id = $item["id"];
        $uye_tahakkuk = DB::all_data("
SELECT
       utu.tutar
FROM
     uye_tahakkuk AS utah
INNER JOIN uye_tahakkuk_urunler as utu on utu.tahakkuk_id=utah.id
INNER JOIN uye_tanim as ut on ut.id=utu.uye_id
WHERE utu.status=1 AND utah.status=1 AND utah.cari_key='$cari_key' AND ut.id='$cari_id'
");
        if ($uye_tahakkuk > 0) {
            foreach ($uye_tahakkuk as $item2) {
                $cari_devir_borc += $item2["tutar"];
            }
        }
        $cari_devir_borc += $item["borc1"];
        $cari_devir_borc += $item["borc2"];
        $cari_devir_borc += $item["borc3"];
        $cari_devir_borc += $item["borc4"];
        $cari_devir_borc += $item["borc5"];
        $cari_devir_borc += $item["borc6"];
        $cari_devir_borc += $item["borc7"];
        $cari_devir_borc += $item["borc8"];
        $cari_devir_borc += $item["borc9"];
        $cari_devir_borc += $item["borc10"];
        $cari_devir_borc += $item["borc11"];

        $cari_devir_alacak += $item["alacak1"];
        $cari_devir_alacak += $item["alacak2"];
        $cari_devir_alacak += $item["alacak3"];
        $cari_devir_alacak += $item["alacak4"];
        $cari_devir_alacak += $item["alacak5"];
        $cari_devir_alacak += $item["alacak6"];
        $cari_devir_alacak += $item["alacak7"];
        $cari_devir_alacak += $item["alacak8"];
        $cari_devir_alacak += $item["alacak9"];
        $cari_devir_alacak += $item["alacak10"];
        $cari_devir_alacak += $item["alacak11"];
        $cari_devir_alacak += $item["alacak12"];
        $cari_devir_alacak += $item["alacak13"];
        $cari_devir_alacak += $item["alacak14"];
        $cari_devir_alacak += $item["alacak15"];
        $cari_devir_alacak += $item["alacak16"];
        $cari_devir_alacak += $item["alacak17"];
        $cari_devir_alacak += $item["alacak18"];
        $cari_devir_alacak += $item["alacak22"];

        $cari_devir_bakiye = floatval($cari_devir_borc) - floatval($cari_devir_alacak);
        if ($cari_devir_bakiye < 0) {
            $cari_devir_bakiye = -$cari_devir_bakiye;
            $b_durum = "A";
        } else if ($cari_devir_bakiye > 0) {
            $b_durum = "B";
        } else {
            $b_durum = "YOK";
        }
        $devir_arr = [
            'cari_kodu' => $item["tc_no"],
            'cari_unvan' => $item["uye_adi"],
            'cari_grubu' => $item["abone_mi"],
            'cep_no' => $item["cep_no"],
            'borc' => $cari_devir_borc,
            'alacak' => $cari_devir_alacak,
            'bakiye' => number_format($cari_devir_bakiye, 2),
            'b_durum' => $b_durum,
            'aciklama' => "",
            'islem' => '<button class="btn btn-danger btn-sm gonderilecek_kisiyi sil"><i class="fa fa-trash"></i></button>'
        ];
        if ($b_durum == "B") {
            if ($_GET["ilk_fiyat"] != "" && $_GET["son_fiyat"] != "") {
                $ilk_fiyat = $_GET["ilk_fiyat"];
                $son_fiyat = $_GET["son_fiyat"];
                if ($cari_devir_bakiye > $ilk_fiyat && $cari_devir_bakiye < $son_fiyat) {
                    array_push($ekstre_arr, $devir_arr);
                }
            } else {
                array_push($ekstre_arr, $devir_arr);
            }

        }
    }
    if (!empty($ekstre_arr)) {
        echo json_encode($ekstre_arr);
    } else {
        echo 2;
    }
}