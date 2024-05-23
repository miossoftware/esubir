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

if ($islem == "acente_konteyner_tanimla_sql") {
    foreach ($_POST["gidecek_arr"] as $item) {
        $item["tipi"] = $_POST["tipi"];
        $item["cari_id"] = $_POST["cari_id"];
        $item["bildirim_tarihi"] = $_POST["bildirim_tarihi"];
        $item["referans_no"] = $_POST["referans_no"];
        $item["cari_key"] = $cari_key;
        $item["sube_key"] = $sube_key;
        $item["insert_userid"] = $_SESSION["user_id"];
        $item["insert_datetime"] = date("Y-m-d H:i:s");

        $acente_konteyner_tanimla = DBD::insert("acente_konteyner_tanim", $item);
    }
    if ($acente_konteyner_tanimla) {
        echo 500;
    } else {
        echo 1;
    }
}
if ($islem == "tanimli_konteynerleri_getir_sql") {
    $tanimlanan_konteynerleri_getir = DBD::all_data("SELECT * FROM acente_konteyner_tanim WHERE status=1 AND cari_key='$cari_key'");
    if ($tanimlanan_konteynerleri_getir > 0) {
        $gidecek_arr = [];
        foreach ($tanimlanan_konteynerleri_getir as $item) {
            $cari_id = $item["cari_id"];
            $cari = DB::single_query("SELECT cari_adi,cari_kodu FROM cari WHERE status=1 AND id='$cari_id'");

            $date = $item["bildirim_tarihi"];
            if ($date != "0000-00-00 00:00:00") {
                $date = date("d/m/Y", strtotime($item["bildirim_tarihi"]));
            }

            $arr = [
                'bildirim_tarihi' => $date,
                'konteyner_no' => $item["konteyner_no"],
                'konteyner_tipi' => $item["konteyner_tipi"],
                'tipi' => $item["tipi"],
                'cari_adi' => $cari["cari_adi"],
                'cari_kodu' => $cari["cari_kodu"],
                'aciklama' => $item["aciklama"],
                'islem' => "<button class='btn btn-sm' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm acente_tanimli_konteyner_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "konteyner_tanim_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;

    $sil = DBD::update("acente_konteyner_tanim", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "tanimlanan_bloklari_getir_sql") {
    $adresler = DBD::all_data("SELECT * FROM adres_tanimlama WHERE status=1 AND cari_key='$cari_key'");
    if ($adresler > 0) {
        echo json_encode($adresler);
    } else {
        echo 2;
    }
}
if ($islem == "tanimli_konteyner_getir_sql") {
    $ek = "";
    if (isset($_GET["konteyner_no"])) {
        $konteyner_no = $_GET["konteyner_no"];
        $ek = " AND konteyner_no='$konteyner_no'";
    }

    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $ek = " AND id='$id'";
    }

    $tanimli_konteyner = DBD::single_query("SELECT * FROM acente_konteyner_tanim WHERE status=1 $ek");
    if ($tanimli_konteyner > 0) {
        $cari_id = $tanimli_konteyner["cari_id"];
        $cari = DB::single_query("SELECT cari_adi FROM cari WHERE id='$cari_id'");
        $arr = [
            "tipi" => $tanimli_konteyner["tipi"],
            "konteyner_no" => $tanimli_konteyner["konteyner_no"],
            "konteyner_tipi" => $tanimli_konteyner["konteyner_tipi"],
            "acente_adi" => $cari["cari_adi"],
            "referans_no" => $tanimli_konteyner["referans_no"],
            "id" => $tanimli_konteyner["id"],
        ];
        echo json_encode($arr);
    } else {
        echo 2;
    }
}
if ($islem == "tanimli_tum_konteynerler_sql") {
    $tum_tanimli_konteynerler = DBD::all_data("SELECT * FROM acente_konteyner_tanim WHERE status=1 AND cari_key='$cari_key'");
    if ($tum_tanimli_konteynerler > 0) {
        $gidecek_arr = [];
        foreach ($tum_tanimli_konteynerler as $item) {
            $tarih = $item["bildirim_tarihi"];
            if ($tarih != "0000-00-00 00:00:00") {
                $tarih = date("d/m/Y", strtotime($tarih));
            }

            $cari_id = $item["cari_id"];
            $cari = DB::single_query("SELECT cari_adi FROM cari WHERE status=1 AND id='$cari_id'");

            $arr = [
                'bildirim_tarihi' => $tarih,
                'konteyner_no' => $item["konteyner_no"],
                'cari_adi' => $cari["cari_adi"],
                'referans_no' => $item["referans_no"],
                'aciklama' => $item["aciklama"],
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
if ($islem == "konteyner_giris_kaydet_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $konteyner_giris_ekle = DBD::insert("acente_konteyner_giris", $_POST);
    if ($konteyner_giris_ekle) {
        echo 500;
    } else {
        $konteyner_id = $_POST["konteyner_id"];
        $arr = [
            'status' => 0
        ];

        $konteyner_tanim_dusur = DBD::update("acente_konteyner_tanim", "id", $konteyner_id, $arr);
        if ($konteyner_tanim_dusur) {
            echo 1;
        } else {
            echo 2;
        }
    }
}
if ($islem == "konteyner_girisleri_getir_sql") {
    $tum_konteynerler = DBD::all_data("SELECT * FROM acente_konteyner_giris WHERE status=1 AND cari_key='$cari_key'");
    if ($tum_konteynerler > 0) {
        $gidecek_arr = [];
        foreach ($tum_konteynerler as $item) {
            $tarih = $item["tarih"];
            if ($tarih != "0000-00-00 00:00:00") {
                $tarih = date("d/m/Y", strtotime($tarih));
            }
            $arr = [
                'tipi' => $item["tipi"],
                'acente_adi' => $item["acente_adi"],
                'referans_no' => $item["referans_no"],
                'konteyner_no' => $item["konteyner_no"],
                'plaka_no' => $item["plaka_no"],
                'surucu_adi' => $item["surucu_adi"],
                'giris_tarihi' => $tarih,
                'aciklama' => $item["aciklama"],
                'kondisyon' => $item["kondisyon"],
                'id' => $item["id"],
                'islem' => "<button class='btn btn-sm acente_kont_giris_guncelle' style='background-color: #F6FA70' data-id='" . $item["id"] . "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm acente_kont_giris_sil' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "konteyner_giris_sil_sql") {
    $id = $_POST["id"];
    $info = DBD::single_query("SELECT * FROM acente_konteyner_giris WHERE status=1 AND cari_key='$cari_key' AND id='$id'");

    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $sil = DBD::update("acente_konteyner_giris", "id", $id, $_POST);
    if ($sil) {
        $arr = [
            'status' => 1
        ];
        $tanim = DBD::update("acente_konteyner_tanim", "id", $info["konteyner_id"], $arr);
        if ($tanim) {
            echo 1;
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "konteyner_giris_bilgileri_sql") {
    $id = $_GET["id"];
    $item = DBD::single_query("
SELECT 
       akg.*,
       act.free_time
FROM
     acente_konteyner_giris akg
INNER JOIN acente_konteyner_tanim as akt on akt.id=akg.konteyner_id
LEFT JOIN acente_cari_tanimi as act on act.cari_id=akt.cari_id
WHERE akg.status=1 AND akg.cari_key='$cari_key' AND akg.id='$id'");
    if ($item > 0) {
        $tarih = $item["tarih"];
        if ($tarih != "0000-00-00 00:00:00") {
            $tarih = date("Y-m-d", strtotime($tarih));
        }
        $arr = [
            'tipi' => $item["tipi"],
            'acente_adi' => $item["acente_adi"],
            'referans_no' => $item["referans_no"],
            'konteyner_no' => $item["konteyner_no"],
            'free_time' => $item["free_time"],
            'konteyner_id' => $item["konteyner_id"],
            'konteyner_tipi' => $item["konteyner_tipi"],
            'plaka_no' => $item["plaka_no"],
            'surucu_adi' => $item["surucu_adi"],
            'surucu_tel' => $item["surucu_tel"],
            'id' => $item["id"],
            'giris_tarihi' => $tarih,
            'aciklama' => $item["aciklama"],
            'blok_id' => $item["blok_id"],
            'nakliye_firmasi' => $item["nakliye_firmasi"],
            'islem' => "<button class='btn btn-sm acente_kont_giris_guncelle' style='background-color: #F6FA70' data-id='" . $item["id"] . "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm acente_kont_giris_sil' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "konteyner_giris_guncelle_sql") {
    $id = $_POST["id"];
    $info = DBD::single_query("SELECT * FROM acente_konteyner_giris WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    $konteyner_id = $info["konteyner_id"];

    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d");

    if ($konteyner_id == $_POST["konteyner_id"]) {
        $guncelle = DBD::update("acente_konteyner_giris", "id", $_POST["id"], $_POST);
        if ($guncelle) {
            echo 1;
        } else {
            echo 2;
        }
    } else {
        $guncelle = DBD::update("acente_konteyner_giris", "id", $_POST["id"], $_POST);
        if ($guncelle) {
            $arr1 = [
                'status' => 1
            ];

            $gun1 = DBD::update("acente_konteyner_tanim", "id", $konteyner_id, $arr1);
            if ($gun1) {
                $arr2 = [
                    'status' => 2
                ];
                $gun2 = DBD::update("acente_konteyner_tanim", "id", $_POST["konteyner_id"], $arr2);
                if ($gun2) {
                    echo 1;
                } else {
                    echo 2;
                }
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    }
}
if ($islem == "depo_acente_tanimlari_kaydet_sql") {
    if (isset($_POST["cari_id"]) && $_POST["free_time"] != 0) {
        $arr = [
            'cari_id' => $_POST["cari_id"],
            'free_time' => $_POST["free_time"],
            'konteyner_tipi' => $_POST["konteyner_tipi"],
            'gunluk_ucret' => $_POST["gunluk_ucret"],
            'depo_ucreti' => $_POST["depo_ucreti"],
            'insert_userid' => $_SESSION["user_id"],
            'insert_datetime' => date("Y-m-d H:i:s"),
            'cari_key' => $cari_key,
            'sube_key' => $sube_key
        ];

        $musteri_hizmet_ekle = DBD::insert("acente_cari_tanimi", $arr);
    }

    if ($_POST["hizmet_adi"] != "") {
        $arr = [
            'hizmet_adi' => $_POST["hizmet_adi"],
            'hizmet_fiyat' => $_POST["hizmet_fiyat"],
            'cari_id' => $_POST["cari_id2"],
            'aciklama' => "aciklama",
            'insert_userid' => $_SESSION["user_id"],
            'insert_datetime' => date("Y-m-d H:i:s"),
            'cari_key' => $cari_key,
            'sube_key' => $sube_key
        ];
        $musteri_hizmet_ekle = DBD::insert("acente_hizmet_tanimlari", $arr);
    }
    if ($musteri_hizmet_ekle) {
        echo 500;
    } else {
        echo 1;
    }
}
if ($islem == "acente_tanimlarini_getir_sql") {
    $tum_cari_hizmetleri = DBD::all_data("SELECT * FROM acente_cari_tanimi WHERE status=1 AND cari_key='$cari_key'");
    if ($tum_cari_hizmetleri > 0) {
        $gidecek_arr = [];
        foreach ($tum_cari_hizmetleri as $item) {
            $cari_id = $item["cari_id"];
            $cari = DB::single_query("select cari_adi from cari WHERE status=1 AND id='$cari_id'");

            $arr = [
                'cari_adi' => $cari["cari_adi"],
                'free_time' => $item["free_time"],
                'gunluk_ucret' => number_format($item["gunluk_ucret"], 2),
                'depo_ucreti' => number_format($item["depo_ucreti"], 2),
                'konteyner_tipi' => $item["konteyner_tipi"],
                'islem' => "<button class='btn btn-sm' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>"
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
if ($islem == "acente_ek_hizmetleri_getir_sql") {
    $tum_cari_hizmetleri = DBD::all_data("SELECT * FROM acente_hizmet_tanimlari WHERE status=1 AND cari_key='$cari_key'");
    if ($tum_cari_hizmetleri > 0) {
        $gidecek_arr = [];
        foreach ($tum_cari_hizmetleri as $item) {
            $cari_id = $item["cari_id"];

            $cari = DB::single_query("select * from cari where id='$cari_id'");

            $arr = [
                'hizmet_adi' => $item["hizmet_adi"],
                'cari_adi' => $cari["cari_adi"],
                'hizmet_fiyati' => number_format($item["hizmet_fiyat"], 2),
                'aciklama' => $item["aciklama"],
                'islem' => "<button class='btn btn-sm' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></button>"
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
if ($islem == "estimate_kaydet_sql") {

    $arr = [
        "konteyner_no" => $_POST["konteyner_no"],
        "konteyner_id" => $_POST["konteyner_id"],
        "acente_adi" => $_POST["acente_adi"],
        "konteyner_tipi" => $_POST["konteyner_tipi"],
        "hasar_aciklamasi" => $_POST["hasar_aciklamasi"],
        "insert_userid" => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s"),
        'cari_key' => $cari_key,
        'sube_key' => $sube_key
    ];
    $estimate_kaydet = DBD::insert("konteyner_estimate", $arr);
    if ($estimate_kaydet) {
        echo 500;
    } else {
        $son_eklenen = DBD::single_query("SELECT id FROM konteyner_estimate where  cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        foreach ($_POST["gidecek_arr"] as $item) {
            $tarih = $item["tarih"];
            $item["estimate_id"] = $son_eklenen["id"];
            $tarih = date("Y-m-d", strtotime($tarih));
            $item["insert_userid"] = $_SESSION["user_id"];
            $item["insert_datetime"] = date("Y-m-d H:i:s");
            $item["cari_key"] = $cari_key;
            $item["sube_key"] = $sube_key;
            $ekle = DBD::insert("konteyner_estimate_urunler", $item);
        }
        if ($ekle) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "estimate_emirlerini_getir_sql") {
    $tum_estimateler = DBD::all_data("
SELECT
       ke.konteyner_no,
       ke.acente_adi,
       ke.hasar_aciklamasi,
       ke.konteyner_tipi,
       COUNT(keu.id) as toplam_islem,
       SUM(keu.islem_ucreti) as toplam_fiyat,
       ke.id
FROM
     konteyner_estimate AS ke
INNER JOIN konteyner_estimate_urunler as keu on keu.estimate_id=ke.id
WHERE ke.status=1 AND keu.status=1 AND ke.cari_key='$cari_key'
");
    if ($tum_estimateler > 0) {
        $gidecek_arr = [];
        foreach ($tum_estimateler as $item) {
            if ($item["konteyner_no"] != null) {
                $arr = [
                    'konteyner_no' => $item["konteyner_no"],
                    'acente_adi' => $item["acente_adi"],
                    'hasar_aciklamasi' => $item["hasar_aciklamasi"],
                    'konteyner_tipi' => $item["konteyner_tipi"],
                    'toplam_islem' => $item["toplam_islem"],
                    'toplam_fiyat' => number_format($item["toplam_fiyat"], 2),
                    'islem' => "<button class='btn btn-sm konteyner_estimate_guncelle_button' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm estimate_islemi_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "estimate_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $estimate_sil = DBD::update("konteyner_estimate", "id", $_POST["id"], $_POST);
    if ($estimate_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "estimate_ana_bilgileri_getir_sql") {
    $id = $_GET["id"];
    $konteyner_estimate = DBD::single_query("SELECT * FROM konteyner_estimate WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    if ($konteyner_estimate > 0) {
        echo json_encode($konteyner_estimate);
    } else {
        echo 2;
    }
}
if ($islem == "estimate_urunlerini_getir_sql") {
    $id = $_GET["id"];
    $konteyner_estimate_urunleri = DBD::all_data("SELECT * FROM konteyner_estimate_urunler WHERE status=1 AND cari_key='$cari_key' AND estimate_id='$id'");
    if ($konteyner_estimate_urunleri > 0) {
        echo json_encode($konteyner_estimate_urunleri);
    } else {
        echo 2;
    }
}
if ($islem == "konteyner_estimate_urun_ekle_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $ekle = DBD::insert("konteyner_estimate_urunler", $_POST);
    if ($ekle) {
        echo 2;
    } else {
        $son_eklenen = DBD::single_query("SELECT id FROM konteyner_estimate_urunler where  cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        echo "id:" . $son_eklenen["id"];
    }
}
if ($islem == "listedeki_estimate_urunu_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_detail"] = "Kullanıcı Listeden Sildi";
    $_POST["status"] = 0;
    $guncelle = DBD::update("konteyner_estimate_urunler", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "estimate_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DBD::update("konteyner_estimate", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "estimate_emirli_konteynerler") {
    $tum_estimate_emirliler = DBD::all_data("SELECT * FROM konteyner_estimate WHERE status=1 AND cari_key='$cari_key'");
    if ($tum_estimate_emirliler > 0) {
        $gidecek_arr = [];
        foreach ($tum_estimate_emirliler as $item) {
            $id = $item["id"];
            $db = DBD::single_query("SELECT * FROM estimate_is_basi WHERE estimate_id='$id' AND is_basi=1 AND status=1");
            if ($db > 0) {

            } else {
                $arr = [
                    'konteyner_no' => $item["konteyner_no"],
                    'id' => $item["id"],
                    'konteyner_tipi' => $item["konteyner_tipi"],
                    'aciklama' => $item["hasar_aciklamasi"],
                    'acente_adi' => $item["acente_adi"]
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
if ($islem == "secilen_estimateli_konteyner_sql") {
    $id = $_GET["id"];

    $item = DBD::single_query("SELECT * FROM konteyner_estimate WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    if ($item > 0) {
        $arr = [
            'konteyner_no' => $item["konteyner_no"],
            'id' => $item["id"],
            'konteyner_tipi' => $item["konteyner_tipi"],
            'aciklama' => $item["hasar_aciklamasi"],
            'acente_adi' => $item["acente_adi"]
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
if ($islem == "estimate_is_basi_kaydet_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $estimate_isi_baslat = DBD::insert("estimate_is_basi", $_POST);
    if ($estimate_isi_baslat) {
        echo 500;
    } else {
        echo 1;
    }
}
if ($islem == "estimate_is_basi_yapilanlari_getir_sql") {
    $estimate_is_baslari = DBD::all_data("
SELECT 
       eib.*,
       eib.insert_datetime as is_basi_saat,
       ke.acente_adi,
       ke.konteyner_no,
       ke.konteyner_tipi,
       ke.hasar_aciklamasi,
       ke.konteyner_id
       
FROM
     estimate_is_basi as eib
INNER JOIN konteyner_estimate as ke on ke.id=eib.estimate_id
WHERE
      eib.status=1 AND eib.cari_key='$cari_key'");
    if ($estimate_is_baslari > 0) {
        $gidecek_arr = [];
        foreach ($estimate_is_baslari as $item) {
            $baslangicTarihi = strtotime($item["is_basi_saat"]);
            $bitisTarihi = strtotime($item["is_bitis_saat"]);

            // İki tarih arasındaki farkı hesaplayın
            $fark = $bitisTarihi - $baslangicTarihi;

            // Farkı gün, saat, dakika ve saniye olarak ayırın
            $gun = floor($fark / (60 * 60 * 24));
            $saat = floor(($fark % (60 * 60 * 24)) / (60 * 60));
            $dakika = floor(($fark % (60 * 60)) / 60);
            $saniye = $fark % 60;

            // Sonucu istediğiniz formatta kullanabilirsiniz
            $sonuc = "$gun gün $saat saat $dakika dakika $saniye saniye";
            if ($item["is_bitis_saat"] == "0000-00-00 00:00:00") {
                $sonuc = "0 gün 0 saat 0 dakika 0 saniye";
            }
            $bitis = "";
            if ($item["is_bitis_saat"] != "0000-00-00 00:00:00") {
                $bitis = date("d/m/Y H:i:s", strtotime($item["is_bitis_saat"]));
            }
            $progress = "";
            $button = "";
            if ($item["is_basi"] == 1) {
                $progress = "<div class='progress'>
<div class='progress-bar bg-warning' role='progressbar' style='width: 100%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>DEVAM EDİYOR</div>
</div>";
                $button = "<button class='btn btn-success btn-sm is_bitir_main_button' data-id='" . $item["id"] . "'><i class='fa fa-flag-checkered'></i> Bitir</button> ";
            } else {
                $progress = "<div class='progress'>
<div class='progress-bar bg-success' role='progressbar' style='width: 100%' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'>BİTTİ</div>
</div>";
            }

            $arr = [
                'ek_hizmet' => "<button data-id='" . $item["konteyner_id"] . "' class='btn btn-info btn-sm estimate_hizmetleri_getir_button' style='border-radius: 50%;'><i class='fa fa-plus'></i></button>",
                'acente_adi' => $item["acente_adi"],
                'konteyner_no' => $item["konteyner_no"],
                'konteyner_tipi' => $item["konteyner_tipi"],
                'hasar_aciklamasi' => $item["hasar_aciklamasi"],
                'is_basi' => date("d/m/Y H:i:s", strtotime($item["is_basi_saat"])),
                'is_bitis_saat' => $bitis,
                'toplam_sure' => $sonuc,
                'durumu' => $progress,
                'islem' => " " . $button . " <button class='btn btn-sm acente_estimate_islem_guncelle_button' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm estimate_is_basi_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "isi_tamamen_bitir_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $_POST["is_basi"] = 2;
    $_POST["is_bitis_saat"] = date("Y-m-d H:i:s");
    $guncelle = DBD::update("estimate_is_basi", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "estimate_sil_main_sql") {

    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $id = $_POST["id"];
    $sorgula = DBD::single_query("SELECT * FROM estimate_is_basi WHERE status=1 AND id='$id' AND is_basi=2");
    if ($sorgula > 0) {
        echo 300;
    } else {
        $sil = DBD::update("estimate_is_basi", "id", $_POST["id"], $_POST);
        if ($sil) {
            echo 1;
        } else {
            echo 2;
        }
    }
}
if ($islem == "estimate_emir_bilgileri_sql") {
    $id = $_GET["id"];

    $bilgiler = DBD::single_query("
SELECT
       eib.*,
       ke.konteyner_no,
       ke.konteyner_tipi,
       ke.hasar_aciklamasi,
       ke.acente_adi
FROM
     estimate_is_basi as eib
INNER JOIN konteyner_estimate as ke on ke.id=eib.estimate_id
WHERE eib.status=1 AND eib.cari_key='$cari_key' AND eib.id='$id'");
    if ($bilgiler > 0) {
        echo json_encode($bilgiler);
    } else {
        echo 2;
    }
}
if ($islem == "estimate_is_basi_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DBD::update("estimate_is_basi", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "konteyner_cikis_kaydet_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;

    $konteyner_cikis_kaydet = DBD::insert("acente_konteyner_cikis", $_POST);
    if ($konteyner_cikis_kaydet) {
        echo 500;
    } else {
        $konteyner_id = $_POST["konteyner_id"];
        $arr = [
            'status' => 2
        ];
        $giris_guncelle = DBD::update("acente_konteyner_giris", "id", $konteyner_id, $arr);
        if ($giris_guncelle) {
            echo 1;
        } else {
            echo 2;
        }
    }
}
if ($islem == "cikis_yapan_konteynerleri_getir_sql") {
    $cikis_yapan_konteynerler = DBD::all_data("
SELECT
       akc.*,
       akg.tarih as giris_tarih
FROM
     acente_konteyner_cikis as akc
INNER JOIN acente_konteyner_giris as akg on akg.id=akc.konteyner_id
WHERE akc.status=1 AND akc.cari_key='$cari_key'");
    if ($cikis_yapan_konteynerler > 0) {
        $gidecek_arr = [];
        foreach ($cikis_yapan_konteynerler as $item) {

            $arr = [
                'tipi' => $item["tipi"],
                'acente_adi' => $item["acente_adi"],
                'referans_no' => $item["referans_no"],
                'konteyner_no' => $item["konteyner_no"],
                'plaka_no' => $item["plaka_no"],
                'surucu_adi' => $item["surucu_adi"],
                'nakliye_firma' => $item["nakliye_firmasi"],
                'giris_tarihi' => date("d/m/Y", strtotime($item["giris_tarih"])),
                'cikis_tarihi' => date("d/m/Y", strtotime($item["tarih"])),
                'aciklama' => $item["aciklama"],
                'islem' => "<button class='btn btn-sm acente_konteyner_cikis_guncelle' style='background-color: #F6FA70' data-id='" . $item["id"] . "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm acente_konteyner_cikis_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
    $id = $_POST["id"];

    $bilgiler = DBD::single_query("SELECT * FROM acente_konteyner_cikis WHERE status=1 AND id='$id'");

    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $sil = DBD::update("acente_konteyner_cikis", "id", $_POST["id"], $_POST);
    if ($sil) {
        $arr = [
            'status' => 1
        ];
        $giris_ac = DBD::update("acente_konteyner_giris", "id", $bilgiler["konteyner_id"], $arr);
        if ($giris_ac) {
            echo 1;
        } else {
            echo 500;
        }
    } else {
        echo 500;
    }
}
if ($islem == "guncellenecek_cikis_bilgileri") {
    $id = $_GET["id"];

    $cikis_bilgileri_getir_sql = DBD::single_query("select * from acente_konteyner_cikis WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    if ($cikis_bilgileri_getir_sql > 0) {
        echo json_encode($cikis_bilgileri_getir_sql);
    } else {
        echo 2;
    }
}
if ($islem == "konteyner_cikis_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DBD::update("acente_konteyner_cikis", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "acente_kondisyon_tanim_kaydet_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $kondisyon_ekle = DBD::insert("kondisyon_tanimlari", $_POST);
    if ($kondisyon_ekle) {
        echo 500;
    } else {
        echo 1;
    }
}
if ($islem == "kondisyon_tanimlari_getir_sql") {
    $kondisyonlari_getir_sql = DBD::all_data("SELECT * FROM kondisyon_tanimlari WHERE status=1 AND cari_key='$cari_key'");
    if ($kondisyonlari_getir_sql > 0) {
        $gidecek_arr = [];
        foreach ($kondisyonlari_getir_sql as $item) {
            $arr = [
                'kondisyon_adi' => "<input type='text' class='form-control form-control-sm col-9 guncellenecek_kondisyon_adi' data-id='" . $item["id"] . "' value='" . $item["kondisyon_adi"] . "' />",
                'islem' => "<button class='btn btn-danger btn-sm kondisyon_tanim_sil_sql' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "kondisyon_tanimlari_getir_sql2") {
    $kondisyonlari_getir_sql = DBD::all_data("SELECT * FROM kondisyon_tanimlari WHERE status=1 AND cari_key='$cari_key'");
    if ($kondisyonlari_getir_sql > 0) {
        echo json_encode($kondisyonlari_getir_sql);
    } else {
        echo 2;
    }
}
if ($islem == "kondisyon_tanim_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;

    $sil = DBD::update("kondisyon_tanimlari", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }

}
if ($islem == "kondisyon_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");

    $sil = DBD::update("kondisyon_tanimlari", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "ek_hizmetleri_getir_sql") {
    $hizmet_tanimlar = DBD::all_data("SELECT * FROM acente_hizmet_tanimlari WHERE status=1 AND cari_key='$cari_key'");
    if ($hizmet_tanimlar > 0) {
        echo json_encode($hizmet_tanimlar);
    } else {
        echo 2;
    }
}
if ($islem == "konteynere_ek_hizmet_ekle_sql") {

    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $ekle = DBD::insert("konteyner_ek_hizmet", $_POST);
    if ($ekle) {
        echo 500;
    } else {
        echo 1;
    }
}
if ($islem == "estimate_hizmet_getir_sql") {
    $konteyner_id = $_GET["konteyner_id"];
    $hizmetler = DBD::all_data("SELECT * FROM konteyner_ek_hizmet WHERE status=1 AND cari_key='$cari_key' AND konteyner_id='$konteyner_id'");
    if ($hizmetler > 0) {
        echo json_encode($hizmetler);
    } else {
        echo 2;
    }
}
if ($islem == "depoda_bulunan_konteynerleri_getir_sql") {
    $acentedeki_konteynerler = DBD::all_data("
SELECT 
       akg.*,
       kt.cari_id
FROM
     acente_konteyner_giris as akg
INNER JOIN konteyner_tanim as kt on kt.id=akg.konteyner_id
WHERE akg.status=1 AND akg.cari_key='$cari_key'");
    $gidecek_arr = [];
    if ($acentedeki_konteynerler > 0) {
        foreach ($acentedeki_konteynerler as $item) {
            $cari_id = $item["cari_id"];
            $cari = DB::single_query("SELECT cari_adi FROM cari WHERE status=1 AND id='$cari_id'");

            $arr = [
                'giris_tarihi' => date("d/m/Y", strtotime($item["tarih"])),
                'tasima_tipi' => $item["tipi"],
                'bos_dolu' => $item["bos_dolu"],
                'depo_firma_adi' => 'Kendi Depomuz',
                'konteyner_no' => $item["konteyner_no"],
                'firma_adi' => "",
                'acente_adi' => $item["acente_adi"],
                'tipi' => $item["konteyner_tipi"],
                'plaka_no' => $item["plaka_no"],
                'plaka_cari' => $item["nakliye_firmasi"],
                'ardiye_giris_tarihi' => "",
                'cut_off_tarihi' => "",
                'demoraj_tarihi' => "",
                'aciklama' => $item["aciklama"]
            ];
            array_push($gidecek_arr, $arr);
        }
    }

    $depo_tasimaciligi_konteynerleri = DBD::all_data("
SELECT
       kg.*,
       iem.demoraj_tarihi,
       iem.konteyner_tipi,
       iem.cut_of_tarihi,
       iem.ardiyesiz_giris_tarihi,
       iem.aciklama,
       iem.depo_cariid,
       iem.tipi
FROM
     konteyner_giris as kg
INNER JOIN is_emri_main as iem on iem.id=kg.is_emri_id
WHERE kg.status=1 AND iem.status=1
");
    if ($depo_tasimaciligi_konteynerleri > 0) {
        foreach ($depo_tasimaciligi_konteynerleri as $item) {
            $cari_id = $item["cari_id"];
            $cari = DB::single_query("SELECT cari_adi FROM cari WHERE status=1 AND id='$cari_id'");

            $cari_id2 = $item["depo_cariid"];
            $cari2 = DB::single_query("SELECT cari_adi FROM cari WHERE status=1 AND id='$cari_id2'");

            $plaka_id = $item["plaka_id"];
            $arac = DB::single_query("
SELECT
       ak.plaka_no,
       c.cari_adi
FROM
     arac_kartlari as ak
LEFT JOIN cari as c on c.id=ak.cari_id
WHERE ak.status=1 AND ak.id='$plaka_id'");

            $arr = [
                'giris_tarihi' => date("d/m/Y", strtotime($item["tarih"])),
                'tasima_tipi' => $item["tipi"],
                'bos_dolu' => $item["bos_dolu"],
                'konteyner_no' => $item["konteyner_no"],
                'firma_adi' => $cari["cari_adi"],
                'depo_firma_adi' => $cari2["cari_adi"],
                'acente_adi' => $item["acente"],
                'tipi' => $item["konteyner_tipi"],
                'plaka_no' => $arac["plaka_no"],
                'plaka_cari' => $arac["cari_adi"],
                'ardiye_giris_tarihi' => date("d/m/Y", strtotime($item["ardiyesiz_giris_tarihi"])),
                'cut_off_tarihi' => date("d/m/Y", strtotime($item["cut_of_tarihi"])),
                'demoraj_tarihi' => date("d/m/Y", strtotime($item["demoraj_tarihi"])),
                'aciklama' => $item["aciklama"]
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
if ($islem == "depodaki_urunleri_getir_sql") {
    $konteyner_girisleri = DBD::all_data("
SELECT
       SUM(sus.miktar) as miktar,
       SUM(uka.yuklenen_miktar1) as yuklenen1,
       SUM(uka.yuklenen_miktar2) as yuklenen2,
       iem.miktar as toplam_miktar,
       iem.urun_adi,
       iem.id,
       iem.cari_id
FROM 
     konteyner_giris as kg
INNER JOIN is_emri_main as iem on iem.id=kg.is_emri_id AND iem.status=1
LEFT JOIN sahaya_urun_ser as sus on sus.k_girisid=kg.id AND sus.status!=0
LEFT JOIN urunleri_konteynere_aktar as uka on uka.konteyner_urunid=kg.id
WHERE kg.status!=0 AND kg.cari_key='$cari_key' GROUP BY iem.cari_id,iem.urun_adi
");
    $gidecek_arr = [];
    $giren_tot = 0;
    $cikan_tot = 0;
    $is_emri_tot = 0;
    $toplam_tot = 0;
    if ($konteyner_girisleri > 0) {
        foreach ($konteyner_girisleri as $item) {
            $toplam_giren = 0;
            $toplam_cikan = 0;
            $is_emri_id = $item["id"];
            $cari_id = $item["cari_id"];

            $arac_girisleri = DBD::single_query("
SELECT 
       SUM(ag.miktar) as miktar,
       SUM(uka.yuklenen_miktar1) as yuklenen1,
       SUM(uka.yuklenen_miktar2) as yuklenen2
FROM
     arac_giris as ag
INNER JOIN is_emri_main as iem on iem.id=ag.is_emri_id AND iem.status=1
LEFT JOIN sahaya_urun_ser as sus on sus.giris_id=ag.id AND sus.status!=0
LEFT JOIN urunleri_konteynere_aktar as uka on uka.urun_id=ag.id AND uka.status!=0
WHERE ag.status!=0 AND ag.cari_key='$cari_key' AND iem.id='$is_emri_id' GROUP BY iem.cari_id,iem.urun_adi
");
            if ($arac_girisleri > 0) {
                $toplam_giren += $arac_girisleri["miktar"];
                $toplam_giren += $arac_girisleri["yuklenen1"];
                $toplam_giren += $arac_girisleri["yuklenen2"];
            }
            $cari = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
            $toplam_giren += $item["miktar"];
            $toplam_giren += $item["yuklenen1"];
            $toplam_giren += $item["yuklenen2"];

            $cikan_urunler = DBD::single_query("

SELECT
       SUM(uka.yuklenen_miktar1) as miktar1,
       SUM(uka.yuklenen_miktar2) as miktar2
FROM
     konteyner_cikis as kc
INNER JOIN konteyner_giris as kg on kg.id=kc.konteyner_id AND kg.status!=0
INNER JOIN urunleri_konteynere_aktar as uka on uka.konteyner_id1=kg.id AND uka.status=1
INNER JOIN is_emri_main as iem on iem.id=kg.is_emri_id AND iem.status=1
WHERE kc.status=1 AND kc.cari_key='$cari_key' AND iem.id='$is_emri_id' GROUP BY iem.cari_id,iem.urun_adi
");
            $toplam_cikan += $cikan_urunler["miktar1"];
            $toplam_cikan += $cikan_urunler["miktar2"];


            if ($toplam_cikan > 0 && $toplam_giren == 0) {
                $toplam_giren = $toplam_cikan;
            }

            $kalan_miktar = $item["toplam_miktar"] - $toplam_giren;
            if ($kalan_miktar <= 0) {
                $toplam_cikan = $toplam_giren;
                $kalan_miktar = 0;
            }
            if ($kalan_miktar != 0){

                $giren_tot += $toplam_giren;
                $cikan_tot += $toplam_cikan;
                $is_emri_tot += $item["toplam_miktar"];
                $toplam_tot += $kalan_miktar;
                $arr = [
                    'giren_miktar' => number_format($toplam_giren),
                    'cikan_miktar' => number_format($toplam_cikan),
                    'mal_cinsi' => $item["urun_adi"],
                    'is_emri_miktar' => number_format($item["toplam_miktar"]),
                    'kalan_miktar' => number_format($kalan_miktar),
                    'cari_adi' => $cari["cari_adi"]
                ];
                array_push($gidecek_arr, $arr);
            }
        }
    }
    if (!empty($gidecek_arr)) {
        $gidecek_arr[0]["giren_tot"] = number_format($giren_tot, 2);
        $gidecek_arr[0]["cikan_tot"] = number_format($cikan_tot, 2);
        $gidecek_arr[0]["is_emri_tot"] = number_format($is_emri_tot, 2);
        $gidecek_arr[0]["toplam_tot"] = number_format($toplam_tot, 2);
        echo json_encode($gidecek_arr);
    } else {
        echo 2;
    }
}