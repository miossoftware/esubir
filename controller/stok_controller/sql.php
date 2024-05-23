<?php
include '../DB.php';
date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=UTF-8');
session_start();
DB::connect();
$_POST["cari_key"] = $_SESSION["cari_key"];
$_POST["sube_key"] = $_SESSION["sube_key"];
$_GET["cari_key"] = $_SESSION["cari_key"];
$cari_key = $_SESSION["cari_key"];
$sube_key = $_SESSION["sube_key"];
$islem = $_GET["islem"];
$ek_sorgu = "";
if ($sube_key != 0) {
    $ek_sorgu = " AND sube_key='$sube_key'";
}
if ($islem == "stoklari_getir") {
    $ek_sorgu_stok = "";
    if (isset($_GET["aktif_modul"])) {
        $aktif_modul = $_GET["aktif_modul"];
        if ($aktif_modul == "STOK EKSTRESİ") {
            $ek_sorgu_stok = " AND (stok.stok_turu!=3 OR salt.altgrup_adi='EK HİZMET' OR salt.altgrup_adi='YAKITLAR')";
        } else if ($aktif_modul == "HİZMET EKSTRESİ") {
            $ek_sorgu_stok = " AND stok.stok_turu=3 AND salt.altgrup_adi!='EK HİZMET' AND salt.altgrup_adi!='YAKITLAR'";
        }
    }
    $veriler = DB::all_data("
SELECT stok.*,marka.marka_adi,sag.ana_grup_adi,salt.altgrup_adi,model.model_adi,b.birim_adi FROM stok
LEFT JOIN stok_ana_grup as sag on sag.id=stok.stok_ana_grupid
LEFT JOIN stok_alt_grup as salt on salt.id=stok.stok_alt_grupid
LEFT JOIN marka on marka.id=stok.marka
LEFT JOIN model on model.id=stok.model
LEFT JOIN birim as b on b.id=stok.birim
WHERE stok.status=1 and stok.cari_key='$cari_key' $ek_sorgu_stok");
    if ($veriler > 0) {
        echo json_encode($veriler);
    } else {
        echo 2;
    }
}
if ($islem == "stok_bilgileri_getir") {
    $stok_kodu = $_GET["stok_kodu"];
    $stok_bilgileri_getir = DB::single_query("SELECT * FROM stok WHERE status=1 AND stok_kodu='$stok_kodu' and cari_key='$cari_key' ");
    if ($stok_bilgileri_getir > 0) {
        echo json_encode($stok_bilgileri_getir);
    } else {
        echo 2;
    }
}
if ($islem == "stok_guncelle") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $stok_kodu = $_POST["stok_kodu"];
    $cari_sil = DB::update("stok", "stok_kodu", $stok_kodu, $_POST);
    if ($cari_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "stok_ekle") {
    $stok_kodu = $_POST["stok_kodu"];
    $stok_adi = $_POST["stok_adi"];
    $stok_kodu_varmi = DB::single_query("SELECT * FROM stok WHERE status=1 AND stok_kodu='$stok_kodu' OR stok_adi='$stok_adi' AND cari_key='$cari_key'");
    if ($stok_kodu_varmi > 0) {
        echo 300;
    } else {
        $_POST["insert_userid"] = $_SESSION["user_id"];
        $_POST["insert_datetime"] = date("Y-m-d H:i:s");
        $cariyi_ekle = DB::insert("stok", $_POST);
        if ($cariyi_ekle) {
            echo 2;
        } else {
            echo 1;
        }
    }
}
if ($islem == "ana_grup_getir") {
    $ana_gruplari_getir = DB::all_data("SELECT id,ana_grup_adi FROM stok_ana_grup WHERE status=1 and cari_key='$cari_key'");
    if ($ana_gruplari_getir > 0) {
        echo json_encode($ana_gruplari_getir);
    }
}
if ($islem == "anagrup_ait_alt_grup_getir") {
    $id = $_GET["id"];
    $ana_gruplari_getir = DB::all_data("SELECT id,altgrup_adi FROM stok_alt_grup WHERE status=1 AND ana_grupid='$id' and cari_key='$cari_key'");
    if ($ana_gruplari_getir > 0) {
        echo json_encode($ana_gruplari_getir);
    }
}
if ($islem == "marka_listesi_getir") {
    $markalar = DB::all_data("SELECT * FROM marka WHERE status=1 and cari_key='$cari_key'");
    if ($markalar > 0) {
        echo json_encode($markalar);
    } else {
        echo 2;
    }
}
if ($islem == "ana_grup_karsilik") {
    $id = $_GET["id"];
    $marka_karsilik = DB::single_query("SELECT ana_grup_adi FROM stok_ana_grup WHERE status=1 AND id='$id' and cari_key='$cari_key' ");
    if ($marka_karsilik > 0) {
        echo json_encode($marka_karsilik);
    } else {
        echo 2;
    }
}
if ($islem == "markaya_ait_model_getir") {
    $id = $_GET["id"];
    $modelleri_cek = DB::all_data("SELECT model_adi,id FROM model WHERE status=1 AND marka_id='$id' and cari_key='$cari_key'");
    if ($modelleri_cek > 0) {
        echo json_encode($modelleri_cek);
    } else {
        echo 2;
    }
}
if ($islem == "stok_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $stok_kodu = $_POST["stok_kodu"];
    $stok_id = DB::single_query("SELECT * FROM stok WHERE status=1 AND stok_kodu='$stok_kodu' AND cari_key='$cari_key'");
    $id = $stok_id["id"];
    $alis_hareket_varmi = DB::single_query("SELECT * FROM alis_urunler WHERE status=1 AND stok_id='$id' and cari_key='$cari_key'");
    $alis_irsaliye_hareket_varmi = DB::single_query("SELECT * FROM alis_irsaliye_urunler WHERE status=1 AND stok_id='$id' and cari_key='$cari_key'");
    if ($alis_hareket_varmi > 0 || $alis_irsaliye_hareket_varmi > 0) {
        echo 300;
    } else {
        $cari_sil = DB::update("stok", "stok_kodu", $stok_kodu, $_POST);
        if ($cari_sil) {
            echo 1;
        } else {
            echo 2;
        }
    }
}
if ($islem == "birimleri_getir") {
    $birimler = DB::all_data("SELECT * FROM birim WHERE status=1 and cari_key='$cari_key'");
    if ($birimler > 0) {
        echo json_encode($birimler);
    } else {
        echo 2;
    }
}
if ($islem == "modelleri_getir") {
    $stok_kodu = $_GET["stok_kodu"];
    $model_id = DB::single_query("SELECT * FROM stok WHERE status=1 AND stok_kodu='$stok_kodu' and cari_key='$cari_key'");
    $id = $model_id["marka"];
    if ($model_id > 0) {
        $modeller = DB::all_data("SELECT * FROM model WHERE status=1 AND marka_id='$id' and cari_key='$cari_key'");
        if ($modeller > 0) {
            echo json_encode($modeller);
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "alt_gruplari_getir") {
    $stok_kodu = $_GET["stok_kodu"];
    $model_id = DB::single_query("SELECT * FROM stok WHERE status=1 AND stok_kodu='$stok_kodu' and cari_key='$cari_key' ");
    if ($model_id > 0) {
        $id = $model_id["stok_ana_grupid"];
        $alt_gruplar = DB::all_data("SELECT * FROM stok_alt_grup WHERE status=1 AND ana_grupid='$id' and cari_key='$cari_key'");
        if ($alt_gruplar > 0) {
            echo json_encode($alt_gruplar);
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "marka_karsilik") {
    $id = $_GET["id"];
    $marka_adi = DB::single_query("SELECT marka_adi FROM marka WHERE status=1 AND id='$id' and cari_key='$cari_key' ");
    if ($marka_adi > 0) {
        echo json_encode($marka_adi);
    } else {
        echo 2;
    }
}
if ($islem == "model_karsilik") {
    $id = $_GET["id"];
    $marka_adi = DB::single_query("SELECT model_adi FROM model WHERE status=1 AND id='$id' and cari_key='$cari_key' ");
    if ($marka_adi > 0) {
        echo json_encode($marka_adi);
    } else {
        echo 2;
    }
}
if ($islem == "alt_grup_karsilik") {
    $id = $_GET["id"];
    $marka_adi = DB::single_query("SELECT altgrup_adi FROM stok_alt_grup WHERE status=1 AND id='$id' and cari_key='$cari_key'");
    if ($marka_adi > 0) {
        echo json_encode($marka_adi);
    } else {
        echo 2;
    }
}
if ($islem == "birim_karsilik") {
    $id = $_GET["id"];
    $marka_adi = DB::single_query("SELECT birim_adi FROM birim WHERE status=1 AND id='$id' and cari_key='$cari_key'");
    if ($marka_adi > 0) {
        echo json_encode($marka_adi);
    } else {
        echo 2;
    }
}
if ($islem == "stok_listesi_getir") {
    $sorgu_devam = "";
    if ($_SESSION["sube_key"] != 0) {
        $sorgu_devam = " AND sube_key='$sube_key'";
    }
    $stoklari_getir = DB::all_data("SELECT * FROM stok WHERE status=1 and cari_key='$cari_key' $sorgu_devam");
    if ($stoklari_getir > 0) {
        echo json_encode($stoklari_getir);
    } else {
        echo 2;
    }
}
if ($islem == "fire_cikisi_ekle") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $stok_fire_cikisi_ekle = DB::insert("stok_fire", $_POST);
    if ($stok_fire_cikisi_ekle) {
        echo 2;
    } else {
        $miktar = $_POST["miktar"];
        $stok_id = $_POST["stok_id"];
        $stoktaki_miktar = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id' AND cari_key='$cari_key'");
        if ($stoktaki_miktar > 0) {
            $envanter_miktar = $stoktaki_miktar["cikan_miktar"];
            $yeni_miktar = floatval($envanter_miktar) + floatval($miktar);
            $miktar_guncel_arr = [
                'cikan_miktar' => $yeni_miktar,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $stok_miktarini_guncelle = DB::update("stok", "id", $stok_id, $miktar_guncel_arr);
            if ($stok_miktarini_guncelle) {
                $son_eklenen = DB::single_query("SELECT id FROM stok_fire where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
                $fire_id = $son_eklenen["id"];
                echo 'id:' . $fire_id;
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    }
}
if ($islem == "fire_cikis_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $stok_fireyi_sil = DB::update("stok_fire", "id", $_POST["id"], $_POST);
    if ($stok_fireyi_sil) {
        $id = $_POST["id"];
        $stok_icin_sorgu = DB::single_query("SELECT * FROM stok_fire WHERE id='$id'");
        if ($stok_icin_sorgu > 0) {
            $stok_id = $stok_icin_sorgu["stok_id"];
            $miktar = $stok_icin_sorgu["miktar"];
            $stoktaki_miktar = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id' AND cari_key='$cari_key'");
            if ($stoktaki_miktar > 0) {
                $envanter_miktar = $stoktaki_miktar["cikan_miktar"];
                $yeni_miktar = floatval($envanter_miktar) - floatval($miktar);
                $miktar_guncel_arr = [
                    'cikan_miktar' => $yeni_miktar,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $stok_miktarini_guncelle = DB::update("stok", "id", $stok_id, $miktar_guncel_arr);
                if ($stok_miktarini_guncelle) {
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
    } else {
        echo 2;
    }
}
if ($islem == "secilenleri_getir") {
    $id = $_GET["id"];
    $fire_bilgileri = DB::single_query("
SELECT
       stok_fire.*,s.stok_adi,s.stok_kodu
FROM
    stok_fire 
INNER JOIN stok as s on s.id=stok_fire.stok_id
WHERE 
      stok_fire.status=1 AND stok_fire.id='$id'
");
    if ($fire_bilgileri > 0) {
        echo json_encode($fire_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "fire_bilgilerini_guncelle") {
    $miktar_farki = $_POST["miktar_farki"];
    unset($_POST["miktar_farki"]);
    $id = $_POST["id"];
    $stok_id = $_POST["stok_id"];
    $stok_icerisindeki_miktar = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");
    if ($stok_icerisindeki_miktar > 0) {
        $fire_guncelle = DB::update("stok_fire", "id", $id, $_POST);
        if ($fire_guncelle) {
            $stoktaki_miktar = $stok_icerisindeki_miktar["cikan_miktar"];
            $yeni_miktar = floatval($stoktaki_miktar) + floatval($miktar_farki);
            $arr = [
                'cikan_miktar' => $yeni_miktar,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $stok_miktar_guncelle = DB::update("stok", "id", $stok_id, $arr);
            if ($stok_miktar_guncelle) {
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
if ($islem == "stok_fire_listesini_getir") {
    $fire_ek = "";
    if ($_SESSION["sube_key"] != 0) {
        $fire_ek = " AND stok_fire.sube_key='$sube_key'";
    }
    $fire_listesini_getir = DB::all_data("SELECT stok_fire.*,s.stok_adi,s.stok_kodu FROM stok_fire
INNER JOIN stok as s on s.id=stok_fire.stok_id
WHERE stok_fire.status=1 AND stok_fire.cari_key='$cari_key' $fire_ek");
    if ($fire_listesini_getir > 0) {
        echo json_encode($fire_listesini_getir);
    } else {
        echo 2;
    }
}
if ($islem == "fire_cikis_iptal_sql") {
    foreach ($_POST["list_ids"] as $fire_info) {
        $fire_id = $fire_info;
        $firenin_bilgileri = DB::single_query("SELECT stok_id,miktar FROM stok_fire WHERE status=1 AND id='$fire_id'");
        if ($firenin_bilgileri > 0) {
            $stok_id = $firenin_bilgileri["stok_id"];
            $fire_miktar = $firenin_bilgileri["miktar"];
            $stok_bilgileri = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");
            if ($stok_bilgileri > 0) {
                $envanter_miktar = $stok_bilgileri["cikan_miktar"];
                $yeni_miktar = floatval($envanter_miktar) - floatval($fire_miktar);
                $arr = [
                    'cikan_miktar' => $yeni_miktar,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $stok_miktar_guncelle = DB::update("stok", "id", $stok_id, $arr);
                if ($stok_miktar_guncelle) {
                    $fire_guncelle_arr = [
                        'delete_userid' => $_SESSION["user_id"],
                        'delete_datetime' => date("Y-m-d H:i:s"),
                        'delete_detail' => "Kullanıcı Fire Oluşturmaktan Vazgeçmiştir",
                        'status' => 0
                    ];
                    $fire_guncelle = DB::update("stok_fire", "id", $fire_id, $fire_guncelle_arr);
                }
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    }
    if ($fire_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "gonderilen_fire_depodan_buyukmu") {
    $stok_id = $_GET["stok_id"];
    $miktar = $_GET["miktar"];
    $stok_info = DB::single_query("SELECT * FROM stok WHERE id='$stok_id' AND status=1");
    $stok_miktar = $stok_info["giren_miktar"];
    if ($stok_miktar < $miktar) {
        echo 2;
    } else {
        echo 1;
    }
}
if ($islem == "acilis_fisleri_icin_stoklari_getir_sql") {
    $acilis_ek = "";
    if ($_SESSION["sube_key"] != 0) {
        $acilis_ek = " AND stok.sube_key='$sube_key'";
    }
    $tum_stoklar = DB::all_data("
SELECT stok.*,b.birim_adi FROM stok
INNER JOIN birim as b on b.id=stok.birim
WHERE stok.status=1 AND stok.cari_key='$cari_key' $acilis_ek");
    if ($tum_stoklar > 0) {
        echo json_encode($tum_stoklar);
    } else {
        echo 2;
    }
}
if ($islem == "stok_acilis_fisi_aciklama_ekle") {
    if (isset($_POST["id"])) {
        $_POST["update_userid"] = $_SESSION["user_id"];
        $_POST["update_datetime"] = date("Y-m-d H:i:s");
        $id = $_POST["id"];
        $acilis_fis_guncelle = DB::update("stok_acilis_fisleri", "id", $id, $_POST);
        if ($acilis_fis_guncelle) {
            echo "id:" . $id;
        } else {
            echo 2;
        }
    } else {
        $_POST["insert_userid"] = $_SESSION["user_id"];
        $_POST["insert_datetime"] = date("Y-m-d H:i:s");
        $acilis_fisi_olustur = DB::insert("stok_acilis_fisleri", $_POST);
        if ($acilis_fisi_olustur) {
            echo 2;
        } else {
            $son_eklenen = DB::single_query("SELECT id FROM stok_acilis_fisleri where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
            $fire_id = $son_eklenen["id"];
            echo 'id:' . $fire_id;
        }
    }
}
if ($islem == "stok_acilis_fisi_miktar_ekle") {
    if (isset($_POST["id"])) {
        $stok_id = $_POST["stok_id"];
        $_POST["update_userid"] = $_SESSION["user_id"];
        $_POST["update_datetime"] = date("Y-m-d H:i:s");
        $id = $_POST["id"];
        $en_son_miktar = DB::single_query("SELECT * FROM stok_acilis_fisleri WHERE status=1 AND id='$id'");
        $acilis_son_miktar = $en_son_miktar["miktar"];
        $acilis_fis_guncelle = DB::update("stok_acilis_fisleri", "id", $id, $_POST);
        if ($acilis_fis_guncelle) {
            $stok_bilgileri = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");
            $envanter_miktar = $stok_bilgileri["giren_miktar"];
            $gonderilen_miktar = $_POST["miktar"];
            $fark_miktar = floatval($gonderilen_miktar) - floatval($acilis_son_miktar);
            $yeni_miktar = floatval($envanter_miktar) + $fark_miktar;
            $arr = [
                'giren_miktar' => $yeni_miktar,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $stok_miktarini_guncelle = DB::update("stok", "id", $stok_id, $arr);
            if ($stok_miktarini_guncelle) {
                echo "id:" . $id;
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    } else {
        $stok_id = $_POST["stok_id"];
        $_POST["insert_userid"] = $_SESSION["user_id"];
        $_POST["insert_datetime"] = date("Y-m-d H:i:s");
        $acilis_fisi_olustur = DB::insert("stok_acilis_fisleri", $_POST);
        if ($acilis_fisi_olustur) {
            echo 2;
        } else {
            $son_eklenen = DB::single_query("SELECT id FROM stok_acilis_fisleri where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
            $fire_id = $son_eklenen["id"];
            $stok_bilgileri = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");
            $envanter_miktar = $stok_bilgileri["giren_miktar"];
            $gonderilen_miktar = $_POST["miktar"];
            $yeni_miktar = floatval($envanter_miktar) + floatval($gonderilen_miktar);
            $arr = [
                'giren_miktar' => $yeni_miktar,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $stok_miktarini_guncelle = DB::update("stok", "id", $stok_id, $arr);
            if ($stok_miktarini_guncelle) {
                echo "id:" . $fire_id;
            } else {
                echo 2;
            }
        }
    }
}
if ($islem == "acilis_alis_fiyat_guncelle_sql") {
    $alis_fiyat = $_POST["alis_fiyat"];
    if (isset($_POST["id"])) {
        $_POST["update_userid"] = $_SESSION["user_id"];
        $_POST["update_datetime"] = date("Y-m-d H:i:s");
        $id = $_POST["id"];
        $acilis_fis_guncelle = DB::update("stok_acilis_fisleri", "id", $id, $_POST);
        if ($acilis_fis_guncelle) {
            $stok_id = $_POST["stok_id"];
            $arr = [
                'alis_fiyat' => $alis_fiyat,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $stok_alis_fiyat_guncelle = DB::update("stok", "id", $stok_id, $arr);
            if ($stok_alis_fiyat_guncelle) {
                echo "id:" . $id;
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    } else {
        $_POST["insert_userid"] = $_SESSION["user_id"];
        $_POST["insert_datetime"] = date("Y-m-d H:i:s");
        $acilis_fisi_olustur = DB::insert("stok_acilis_fisleri", $_POST);
        if ($acilis_fisi_olustur) {
            echo 2;
        } else {
            $son_eklenen = DB::single_query("SELECT id FROM stok_acilis_fisleri where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
            $fire_id = $son_eklenen["id"];
            echo 'id:' . $fire_id;
            $stok_id = $_POST["stok_id"];
            $arr = [
                'alis_fiyat' => $alis_fiyat,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $stok_alis_fiyat_guncelle = DB::update("stok", "id", $stok_id, $arr);
            if ($stok_alis_fiyat_guncelle) {
                echo "id:" . $fire_id;
            } else {
                echo 2;
            }
        }
    }
}
if ($islem == "secilen_acilislari_sil") {
    foreach ($_POST["silinecek_acilisids"] as $acilis_info) {
        $acilis_id = $acilis_info;
        $ilk_arr = [
            'delete_userid' => $_SESSION["user_id"],
            'delete_datetime' => date("Y-m-d H:i:s"),
            'delete_detail' => 'Kullanıcı Listeden Silme İşlemi Yapmıştır',
            'status' => 0
        ];
        $stok_acilis_sil = DB::update("stok_acilis_fisleri", "id", $acilis_id, $ilk_arr);
        if ($stok_acilis_sil) {
            $stok_acilis_bilgileri = DB::single_query("SELECT * FROM stok_acilis_fisleri WHERE id='$acilis_id'");
            if ($stok_acilis_bilgileri > 0) {
                $stok_id = $stok_acilis_bilgileri["stok_id"];
                $acilis_miktar = $stok_acilis_bilgileri["miktar"];
                $stok_envanter_bilgi = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");
                $envanter_miktar = $stok_envanter_bilgi["giren_miktar"];
                $yeni_miktar = floatval($envanter_miktar) - floatval($acilis_miktar);
                $yeni_arr = [
                    "giren_miktar" => $yeni_miktar,
                    "update_userid" => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $stok_miktar_guncelle = DB::update("stok", "id", $stok_id, $yeni_arr);
            }
        }
    }
    if ($stok_miktar_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "tum_kayitlari_sil") {
    foreach ($_POST["gonderilecek_ids"] as $acilis_info) {
        $acilis_id = $acilis_info;
        $ilk_arr = [
            'delete_userid' => $_SESSION["user_id"],
            'delete_datetime' => date("Y-m-d H:i:s"),
            'delete_detail' => 'Kullanıcı Listeden Silme İşlemi Yapmıştır',
            'status' => 0
        ];
        $stok_acilis_sil = DB::update("stok_acilis_fisleri", "id", $acilis_id, $ilk_arr);
        if ($stok_acilis_sil) {
            $stok_acilis_bilgileri = DB::single_query("SELECT * FROM stok_acilis_fisleri WHERE id='$acilis_id'");
            if ($stok_acilis_bilgileri > 0) {
                $stok_id = $stok_acilis_bilgileri["stok_id"];
                $acilis_miktar = $stok_acilis_bilgileri["miktar"];
                $stok_envanter_bilgi = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");
                $envanter_miktar = $stok_envanter_bilgi["giren_miktar"];
                $yeni_miktar = floatval($envanter_miktar) - floatval($acilis_miktar);
                $yeni_arr = [
                    "giren_miktar" => $yeni_miktar,
                    "update_userid" => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $stok_miktar_guncelle = DB::update("stok", "id", $stok_id, $yeni_arr);
            }
        }
    }
    if ($stok_miktar_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "stok_acilis_fisi_birim_ekle") {
    if (isset($_POST["id"])) {
        $_POST["update_userid"] = $_SESSION["user_id"];
        $_POST["update_datetime"] = date("Y-m-d H:i:s");
        $id = $_POST["id"];
        $acilis_fis_guncelle = DB::update("stok_acilis_fisleri", "id", $id, $_POST);
        if ($acilis_fis_guncelle) {
            $acilis_info = DB::single_query("SELECT * FROM stok_acilis_fisleri WHERE status=1 AND id='$id'");
            $stok_id = $acilis_info["stok_id"];
            $arr = [
                'birim' => $_POST["birim_id"],
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $stok_birim_guncelle = DB::update("stok", "id", $stok_id, $arr);
            if ($stok_birim_guncelle) {
                echo "id:" . $id;
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    } else {
        $_POST["insert_userid"] = $_SESSION["user_id"];
        $_POST["insert_datetime"] = date("Y-m-d H:i:s");
        $acilis_fisi_olustur = DB::insert("stok_acilis_fisleri", $_POST);
        if ($acilis_fisi_olustur) {
            echo 2;
        } else {
            $son_eklenen = DB::single_query("SELECT id FROM stok_acilis_fisleri where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
            $fire_id = $son_eklenen["id"];
            $acilis_info = DB::single_query("SELECT * FROM stok_acilis_fisleri WHERE status=1 AND id='$fire_id'");
            $stok_id = $acilis_info["stok_id"];
            $arr = [
                'birim' => $_POST["birim_id"],
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $stok_birim_guncelle = DB::update("stok", "id", $stok_id, $arr);
            if ($stok_birim_guncelle) {
                echo "id:" . $fire_id;
            } else {
                echo 2;
            }
        }
    }
}
if ($islem == "stok_acilis_depo_ekle") {
    if (isset($_POST["id"])) {
        $_POST["update_userid"] = $_SESSION["user_id"];
        $_POST["update_datetime"] = date("Y-m-d H:i:s");
        $id = $_POST["id"];
        $acilis_fis_guncelle = DB::update("stok_acilis_fisleri", "id", $id, $_POST);
        if ($acilis_fis_guncelle) {
            echo "id:" . $id;
        } else {
            echo 2;
        }
    } else {
        $_POST["insert_userid"] = $_SESSION["user_id"];
        $_POST["insert_datetime"] = date("Y-m-d H:i:s");
        $acilis_fisi_olustur = DB::insert("stok_acilis_fisleri", $_POST);
        if ($acilis_fisi_olustur) {
            echo 2;
        } else {
            $son_eklenen = DB::single_query("SELECT id FROM stok_acilis_fisleri where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
            $fire_id = $son_eklenen["id"];
            echo 'id:' . $fire_id;
        }
    }
}
if ($islem == "acilis_fislerini_getir") {
    $tum_acilis_fisler = DB::all_data("SELECT stok_acilis_fisleri.*,d.depo_adi,b.birim_adi,s.stok_adi,s.stok_kodu FROM stok_acilis_fisleri
LEFT JOIN stok as s on s.id=stok_acilis_fisleri.stok_id
LEFT JOIN birim as b on b.id=stok_acilis_fisleri.birim_id
LEFT JOIN depolar as d on d.id=stok_acilis_fisleri.depo_id
WHERE stok_acilis_fisleri.status=1 and s.status=1 and stok_acilis_fisleri.cari_key='$cari_key'");
    if ($tum_acilis_fisler > 0) {
        echo json_encode($tum_acilis_fisler);
    } else {
        echo 2;
    }
}
if ($islem == "yeni_ust_acilis_fisi_olustur_sql") {
    $alis_fiyat = $_POST["alis_fiyat"];
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");

    $acilis_fisi_ekle = DB::insert("stok_acilis_fisleri", $_POST);
    $son_id = DB::single_query("SELECT id FROM stok_acilis_fisleri where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
    $acilis_id = $son_id["id"];
    if ($acilis_fisi_ekle) {
        echo 2;
    } else {
        $stok_id = $_POST["stok_id"];
        $stok_envanter_bilgi = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");
        if ($stok_envanter_bilgi > 0) {
            $envanter_miktar = $stok_envanter_bilgi["giren_miktar"];
            $gonderilen_miktar = $_POST["miktar"];
            $yeni_miktar = floatval($envanter_miktar) + floatval($gonderilen_miktar);
            $birim_id = $_POST["birim_id"];
            if ($alis_fiyat == "") {
                $alis_fiyat = $stok_envanter_bilgi["alis_fiyat"];
            }
            if ($birim_id == "") {
                $birim_id = $stok_envanter_bilgi["birim"];
            }
            $yeni_arr = [
                'giren_miktar' => $yeni_miktar,
                'alis_fiyat' => $alis_fiyat,
                'birim' => $birim_id,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $stok_bilgilerini_guncelle = DB::update("stok", "id", $stok_id, $yeni_arr);
            if ($stok_bilgilerini_guncelle) {
                $tum_acilis_fisler = DB::single_query("
SELECT 
       stok_acilis_fisleri.*,d.depo_adi,d.id as depo_id,b.birim_adi,s.stok_adi,s.stok_kodu,s.id as stok_id,s.alis_fiyat
FROM 
     stok_acilis_fisleri
LEFT JOIN stok as s on s.id=stok_acilis_fisleri.stok_id
LEFT JOIN birim as b on b.id=stok_acilis_fisleri.birim_id
LEFT JOIN depolar as d on d.id=stok_acilis_fisleri.depo_id
WHERE stok_acilis_fisleri.status=1 and s.status=1 AND stok_acilis_fisleri.id='$acilis_id'");
                if ($tum_acilis_fisler > 0) {
                    echo json_encode($tum_acilis_fisler);
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
if ($islem == "acilis_fisi_sil_main_sql") {
    $id = $_POST["id"];
    $acilis_fisi_bilgileri = DB::single_query("SELECT * FROM stok_acilis_fisleri WHERE status=1 AND id='$id'");
    if ($acilis_fisi_bilgileri > 0) {
        $acilis_stok_id = $acilis_fisi_bilgileri["stok_id"];
        $acilis_miktar = $acilis_fisi_bilgileri["miktar"];
        $stok_envanter_bilgi = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$acilis_stok_id'");
        if ($stok_envanter_bilgi > 0) {
            $acilis_arr = [
                'status' => 0,
                'delete_userid' => $_SESSION["user_id"],
                'delete_detail' => $_POST["delete_detail"],
                'delete_datetime' => date("Y-m-d H:i:s")
            ];

            $acilis_fisi_sil = DB::update("stok_acilis_fisleri", "id", $id, $acilis_arr);
            if ($acilis_fisi_sil) {
                $envanter_miktar = $stok_envanter_bilgi["giren_miktar"];
                $yeni_miktar = floatval($envanter_miktar) - floatval($acilis_miktar);
                $yeni_arr = [
                    'giren_miktar' => $yeni_miktar,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $envanter_bilgi_guncelle = DB::update("stok", "id", $acilis_stok_id, $yeni_arr);
                if ($envanter_bilgi_guncelle) {
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
    } else {
        echo 2;
    }
}
if ($islem == "stok_kod_getir_sql") {
    $harf_kodu = $_GET["stok_kodu"];
    $sql = "";
    if ($harf_kodu == "") {
        $sql = "SELECT * FROM stok WHERE status=1 AND cari_key='2' AND NOT stok_kodu REGEXP '^[A-Za-z]'
  AND stok_kodu NOT LIKE 'Ş%'  ORDER BY id DESC LIMIT 1";
    } else {
        $sql = "SELECT * FROM stok WHERE status=1 AND cari_key='$cari_key' AND stok_kodu LIKE '$harf_kodu%'  ORDER BY id DESC LIMIT 1";
    }

    $cariler = DB::single_query($sql);
    if ($cariler > 0) {
        $ayrilanlar = preg_replace("/[^0-9]/", "", $cariler["stok_kodu"]);
        $sayi = floatval($ayrilanlar) + 1;
        if ($sayi >= 10 && $sayi <= 99) {
            // 2 basamaklıysa önüne sıfır ekleyerek 3 basamaklı yap
            $sayi = "0" . $sayi;
        } else if ($sayi < 10) {
            $sayi = "00" . $sayi;
        }
        echo mb_strtoupper($harf_kodu) . $sayi;
    } else {
        echo mb_strtoupper($harf_kodu) . "001";
    }
}
if ($islem == "stok_sayim_fazlasi_kaydet_sql") {
    foreach ($_POST["gidecek_arr"] as $item) {
        $item["insert_datetime"] = date("Y-m-d H:i:s");
        $item["insert_userid"] = $_SESSION["user_id"];
        $item["cari_key"] = $cari_key;
        $item["sube_key"] = $sube_key;
        $sayim_fazlasi_kaydet = DB::insert("stok_sayim_fazlasi", $item);
    }
    if ($sayim_fazlasi_kaydet) {
        echo 500;
    } else {
        echo 1;
    }
}
if ($islem == "sayim_fazlalarini_getir_sql") {
    $sayim_fazlalari = DB::all_data("
SELECT
       ssf.*,
       s.stok_adi,
       s.stok_kodu,
       b.birim_adi
FROM
     stok_sayim_fazlasi as ssf
INNER JOIN stok as s on s.id=ssf.stok_id
INNER JOIN birim as b on b.id=ssf.birim_id
WHERE ssf.status=1 AND ssf.cari_key='$cari_key'");
    if ($sayim_fazlalari > 0) {
        echo json_encode($sayim_fazlalari);
    } else {
        echo 2;
    }
}
if ($islem == "acilis_bilgilerini_getir_sql") {
    $id = $_GET["id"];
    $stok_acilis_bilgileri = DB::single_query("
SELECT
       saf.*,
       s.stok_adi,
       s.stok_kodu
FROM
     stok_acilis_fisleri as saf
INNER JOIN stok as s on s.id=saf.stok_id
WHERE saf.id='$id' AND saf.status=1 AND saf.cari_key='$cari_key'");
    if ($stok_acilis_bilgileri > 0) {
        echo json_encode($stok_acilis_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "acilis_fisi_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $stok_acilis_guncelle = DB::update("stok_acilis_fisleri", "id", $_POST["id"], $_POST);
    if ($stok_acilis_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "stok_fire_sil_sql") {
    $_POST["status"] = 0;
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_detail"] = $_SESSION["user_id"];
    $fire_sil_sql = DB::update("stok_fire", "id", $_POST["id"], $_POST);
    if ($fire_sil_sql) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "stok_fire_bilgileri_getir_sql") {
    $id = $_GET["id"];
    $stok_fire_bilgileri = DB::single_query("
SELECT
       sf.*,
       s.stok_adi,
       s.stok_kodu
FROM
     stok_fire as sf
INNER JOIN stok as s on s.id=sf.stok_id
WHERE
      sf.status=1
  AND
      sf.cari_key='$cari_key'
  AND
      sf.id='$id'");
    if ($stok_fire_bilgileri > 0) {
        echo json_encode($stok_fire_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "stok_fire_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $stok_fire_guncelle = DB::update("stok_fire", "id", $_POST["id"], $_POST);
    if ($stok_fire_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "sayim_fazlasi_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $sayim_fazlasi_sil_sql = DB::update("stok_sayim_fazlasi", "id", $_POST["id"], $_POST);
    if ($sayim_fazlasi_sil_sql) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "stok_sayim_fazlasi_bilgileri_getir_sql") {
    $id = $_GET["id"];
    $sayim_fazlasi_info = DB::single_query("
SELECT 
       ssf.*,
       s.stok_adi,
       s.stok_kodu
FROM
     stok_sayim_fazlasi as ssf
INNER JOIN stok as s on s.id=ssf.stok_id
WHERE 
      ssf.status=1
  AND
      ssf.cari_key='$cari_key' 
  AND 
      ssf.id='$id'");
    if ($sayim_fazlasi_info > 0) {
        echo json_encode($sayim_fazlasi_info);
    } else {
        echo 2;
    }
}
if ($islem == "stok_sayim_fazlasi_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $sayim_fazlasi_guncelle = DB::update("stok_sayim_fazlasi", "id", $_POST["id"], $_POST);
    if ($sayim_fazlasi_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}