<?php
include '../DB.php';
date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=UTF-8');
session_start();
DB::connect();
$islem = $_GET["islem"];
$cari_key = $_SESSION["cari_key"];
if ($islem == "tahsile_verilen_cek_senetleri_getir") {
    $tahsile_verilen_cekler = DB::all_data("
SELECT 
       ccu.*,
       b.banka_adi,
       b.sube_adi,
       b.hesap_no,
       b.id as banka_id
FROM 
     cikis_cek_urunler as ccu
INNER JOIN alinan_cek_cikis AS acc on acc.id=ccu.cikis_cekid
INNER JOIN banka as b on b.id=acc.banka_id
WHERE acc.islem='bankaya_tahsile_verme' AND acc.status=1 AND ccu.status=1 AND acc.cari_key='$cari_key'");
    if ($tahsile_verilen_cekler > 0) {
        echo json_encode($tahsile_verilen_cekler);
    } else {
        echo 2;
    }
}
if ($islem == "tahsilati_gerceklestir_sql") {
    $cek_arr = [
        'tarih' => $_POST["tarih"],
        'belge_no' => $_POST["belge_no"],
        'ozel_kod' => $_POST["ozel_kod"],
        'doviz_tur' => $_POST["doviz_tur"],
        'aciklama' => $_POST["aciklama"],
        'insert_userid' => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s"),
        'cari_key' => $cari_key,
        'sube_key' => $_SESSION["sube_key"]
    ];

    $tahsil_edilen_cek_senet_kaydet = DB::insert("tahsil_edilen_cek_senet", $cek_arr);
    if ($tahsil_edilen_cek_senet_kaydet) {
        echo 500;
    } else {
        $son = DB::single_query("SELECT id FROM tahsil_edilen_cek_senet where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        foreach ($_POST["arr"] as $item) {
            $urun_arr = [
                'banka_id' => $item["banka_id"],
                'tahsil_id' => $son["id"],
                'cek_id' => $item["cek_id"],
                'seri_no' => $item["seri_no"],
                'vade_tarih' => $item["vade_tarih"],
                'asil_borclu' => $item["asil_borclu"],
                'ciro_edilmis' => $item["ciro_edilmis"],
                'tutar' => $item["tutar"],
                'keside_yeri' => $item["keside_yeri"],
                'ozel_kod' => $item["ozel_kod"],
                'islem' => 'tahsile_verilen_cek_senet_tahsili',
                'insert_userid' => $_SESSION["user_id"],
                'insert_datetime' => date("Y-m-d H:i:s"),
                'cari_key' => $cari_key,
                'sube_key' => $_SESSION["sube_key"]
            ];
            $urunleri_ekle = DB::insert("tahsil_edilen_cek_urunler", $urun_arr);
        }
        if ($urunleri_ekle) {
            echo 500;
        } else {
            foreach ($_POST["arr"] as $item) {
                $cekid = $item["cek_id"];
                $cekler_arr = [
                    'status' => 2,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $cekleri_gizle = DB::update("cikis_cek_urunler", "id", $cekid, $cekler_arr);
            }
            if ($cekleri_gizle) {
                echo 1;
            } else {
                echo 500;
            }
        }
    }
}
if ($islem == "teminata_verilen_cek_senetleri_getir") {
    $tahsile_verilen_cekler = DB::all_data("
SELECT 
       ccu.*,
       b.banka_adi,
       b.sube_adi,
       b.hesap_no,
       b.id as banka_id
FROM 
     cikis_cek_urunler as ccu
INNER JOIN alinan_cek_cikis AS acc on acc.id=ccu.cikis_cekid
INNER JOIN banka as b on b.id=acc.banka_id
WHERE acc.islem='bankaya_teminata_verme' AND acc.status=1 AND ccu.status=1 AND acc.cari_key='$cari_key'");
    if ($tahsile_verilen_cekler > 0) {
        echo json_encode($tahsile_verilen_cekler);
    } else {
        echo 2;
    }
}
if ($islem == "teminata_verilen_tahsilati_gerceklestir_sql") {
    $cek_arr = [
        'tarih' => $_POST["tarih"],
        'belge_no' => $_POST["belge_no"],
        'ozel_kod' => $_POST["ozel_kod"],
        'doviz_tur' => $_POST["doviz_tur"],
        'aciklama' => $_POST["aciklama"],
        'insert_userid' => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s"),
        'cari_key' => $cari_key,
        'sube_key' => $_SESSION["sube_key"]
    ];

    $tahsil_edilen_cek_senet_kaydet = DB::insert("tahsil_edilen_cek_senet", $cek_arr);
    if ($tahsil_edilen_cek_senet_kaydet) {
        echo 500;
    } else {
        $son = DB::single_query("SELECT id FROM tahsil_edilen_cek_senet where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        foreach ($_POST["arr"] as $item) {
            $urun_arr = [
                'banka_id' => $item["banka_id"],
                'tahsil_id' => $son["id"],
                'cek_id' => $item["cek_id"],
                'seri_no' => $item["seri_no"],
                'vade_tarih' => $item["vade_tarih"],
                'asil_borclu' => $item["asil_borclu"],
                'ciro_edilmis' => $item["ciro_edilmis"],
                'tutar' => $item["tutar"],
                'keside_yeri' => $item["keside_yeri"],
                'ozel_kod' => $item["ozel_kod"],
                'islem' => 'teminata_verilen_cek_senet_tahsili',
                'insert_userid' => $_SESSION["user_id"],
                'insert_datetime' => date("Y-m-d H:i:s"),
                'cari_key' => $cari_key,
                'sube_key' => $_SESSION["sube_key"]
            ];
            $urunleri_ekle = DB::insert("tahsil_edilen_cek_urunler", $urun_arr);
        }
        if ($urunleri_ekle) {
            echo 500;
        } else {
            foreach ($_POST["arr"] as $item) {
                $cekid = $item["cek_id"];
                $cekler_arr = [
                    'status' => 2,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $cekleri_gizle = DB::update("cikis_cek_urunler", "id", $cekid, $cekler_arr);
            }
            if ($cekleri_gizle) {
                echo 1;
            } else {
                echo 500;
            }
        }
    }
}
if ($islem == "tum_tahsilatlari_getir_sql") {
    $sql = "
SELECT
       csg.*,
       b.banka_adi,
       k.kasa_adi,
       SUM(acu.tutar) as tutar
FROM 
     tahsil_edilen_cek_senet as csg
INNER JOIN tahsil_edilen_cek_urunler as acu on acu.tahsil_id=csg.id
LEFT JOIN banka as b on b.id=acu.banka_id
LEFT JOIN kasa as k on k.id=csg.kasa_id
WHERE csg.status=1 AND csg.cari_key='$cari_key' AND acu.status=1";
    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        $sql .= " AND csg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
    }
    $sql .= " GROUP BY tahsil_id";
    $cek_senetler_listesi = DB::all_data($sql);
    if ($cek_senetler_listesi > 0) {
        echo json_encode($cek_senetler_listesi);
    } else {
        echo 2;
    }
}
if ($islem == "tahsil_edilen_ceki_sil_sql") {
    $id = $_POST["id"];
    $_POST["status"] = 0;
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $urunlerini_getir = DB::all_data("SELECT * FROM tahsil_edilen_cek_urunler WHERE status=1 AND cari_key='$cari_key' AND tahsil_id='$id'");
    if ($urunlerini_getir > 0) {
        foreach ($urunlerini_getir as $item) {
            $cekid = $item["cek_id"];
            $arr = [
                'status' => 1
            ];
            $guncelle = DB::update("cikis_cek_urunler", "id", $cekid, $arr);
        }
        if ($guncelle) {
            $tahsil_sil = DB::update("tahsil_edilen_cek_senet", "id", $id, $_POST);
            $sil = DB::update("tahsil_edilen_cek_urunler", "tahsil_id", $id, $_POST);
            if ($tahsil_sil) {
                echo 1;
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    } else {
        $tahsil_sil = DB::update("tahsil_edilen_cek_senet", "id", $id, $_POST);
        $sil = DB::update("tahsil_edilen_cek_urunler", "tahsil_id", $id, $_POST);
        if ($tahsil_sil) {
            echo 1;
        } else {
            echo 2;
        }
    }
}
if ($islem == "elden_tahsilati_gerceklestir_sql") {
    $cek_arr = [
        'tarih' => $_POST["tarih"],
        'belge_no' => $_POST["belge_no"],
        'ozel_kod' => $_POST["ozel_kod"],
        'doviz_tur' => $_POST["doviz_tur"],
        'aciklama' => $_POST["aciklama"],
        'insert_userid' => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s"),
        'cari_key' => $cari_key,
        'kasa_id' => $_POST["kasa_id"],
        'sube_key' => $_SESSION["sube_key"]
    ];

    $tahsil_edilen_cek_senet_kaydet = DB::insert("tahsil_edilen_cek_senet", $cek_arr);
    if ($tahsil_edilen_cek_senet_kaydet) {
        echo 500;
    } else {
        $son = DB::single_query("SELECT id FROM tahsil_edilen_cek_senet where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        foreach ($_POST["arr"] as $item) {
            $urun_arr = [
                'tahsil_id' => $son["id"],
                'cek_id' => $item["cek_id"],
                'seri_no' => $item["seri_no"],
                'vade_tarih' => $item["vade_tarih"],
                'asil_borclu' => $item["asil_borclu"],
                'ciro_edilmis' => $item["ciro_edilmis"],
                'tutar' => $item["tutar"],
                'keside_yeri' => $item["keside_yeri"],
                'ozel_kod' => $item["ozel_kod"],
                'islem' => 'elden_cek_senet_tahsilati',
                'insert_userid' => $_SESSION["user_id"],
                'insert_datetime' => date("Y-m-d H:i:s"),
                'cari_key' => $cari_key,
                'sube_key' => $_SESSION["sube_key"]
            ];
            $urunleri_ekle = DB::insert("tahsil_edilen_cek_urunler", $urun_arr);
        }
        if ($urunleri_ekle) {
            echo 500;
        } else {
            foreach ($_POST["arr"] as $item) {
                $cekid = $item["cek_id"];
                $cekler_arr = [
                    'status' => 2,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $cekleri_gizle = DB::update("alinan_cek_urunler", "id", $cekid, $cekler_arr);
            }
            if ($cekleri_gizle) {
                echo 1;
            } else {
                echo 500;
            }
        }
    }
}
if ($islem == "elden_cek_tahsil_sil_sql") {
    $id = $_POST["id"];
    $_POST["status"] = 0;
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $urunlerini_getir = DB::all_data("SELECT * FROM tahsil_edilen_cek_urunler WHERE status=1 AND cari_key='$cari_key' AND tahsil_id='$id'");
    if ($urunlerini_getir > 0) {
        foreach ($urunlerini_getir as $item) {
            $cekid = $item["cek_id"];
            $arr = [
                'status' => 1
            ];
            $guncelle = DB::update("alinan_cek_urunler", "id", $cekid, $arr);
        }
        if ($guncelle) {
            $tahsil_sil = DB::update("tahsil_edilen_cek_senet", "id", $id, $_POST);
            $urun_sil = DB::update("tahsil_edilen_cek_urunler", "tahsil_id", $id, $_POST);
            if ($tahsil_sil) {
                echo 1;
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    } else {
        $tahsil_sil = DB::update("tahsil_edilen_cek_senet", "id", $id, $_POST);
        $urun_sil = DB::update("tahsil_edilen_cek_urunler", "tahsil_id", $id, $_POST);
        if ($tahsil_sil) {
            echo 1;
        } else {
            echo 2;
        }
    }
}
if ($islem == "bizim_cekleri_getir_sql") {
    $donecek_arr = [];
    $tahsile_verilen_cekler = DB::all_data("
SELECT 
       ccu.*,
       b.banka_adi,
       b.sube_adi,
       b.hesap_no,
       c.cari_adi,
       b.id as banka_id,
       acc.cari_id
FROM 
     bizim_cek_urunler as ccu
INNER JOIN bizim_cek_cikis AS acc on acc.id=ccu.bizim_cekid
INNER JOIN banka as b on b.id=ccu.banka_id
LEFT JOIN cari as c on c.id=acc.cari_id
WHERE acc.status=1 AND ccu.status=1 AND acc.cari_key='$cari_key'");
    if ($tahsile_verilen_cekler > 0) {
        $donecek_arr = array_merge($donecek_arr, $tahsile_verilen_cekler);
    }

    $tahsile_verilen_cekler2 = DB::all_data("
SELECT
       acc.*,
       acc.status as main_status,
       ccu.status as second_status,
       acc.ozel_kod1 as ozel_kod,
       ccu.vade_tarih,
       ccu.keside_yeri,
       ccu.girilen_tutar as tutar,
       ccu.seri_no as bordro_no,
       acu.banka_adi,
       acu.asil_borclu,
       acu.ciro_edilmis,
       acu.seri_no,
       acu.banka_sube as sube_adi,
       acu.hesap_no
FROM
     alinan_cek_cikis as acc
INNER JOIN cikis_cek_urunler as ccu on ccu.cikis_cekid=acc.id
INNER JOIN alinan_cek_urunler as acu on acu.alinan_cekid=ccu.id
INNER JOIN alinan_cek_giris as acg on acg.id=acu.alinan_cekid
WHERE acc.status=1 AND ccu.status=1 AND acc.cari_key='$cari_key'");
    if ($tahsile_verilen_cekler2 > 0) {
        $donecek_arr = array_merge($donecek_arr, $tahsile_verilen_cekler2);
    }
    if ($donecek_arr > 0) {
        echo json_encode($donecek_arr);
    } else {
        echo 2;
    }
}
if ($islem == "odemeyi_gerceklestir_sql") {
    $arr = [
        'tarih' => $_POST["tarih"],
        'belge_no' => $_POST["belge_no"],
        'ozel_kod' => $_POST["ozel_kod"],
        'doviz_tur' => $_POST["doviz_tur"],
        'aciklama' => $_POST["aciklama"],
        'insert_userid' => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s"),
        'cari_key' => $_SESSION["cari_key"],
        'sube_key' => $_SESSION["sube_key"]
    ];
    $ana_bilgileri_olustur = DB::insert("cek_senet_odeme", $arr);
    if ($ana_bilgileri_olustur) {
        echo 500;
    } else {
        $son = DB::single_query("SELECT id FROM cek_senet_odeme where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        foreach ($_POST["arr"] as $item) {
            $item["odeme_id"] = $son["id"];
            $item["cari_key"] = $_SESSION["cari_key"];
            $item["sube_key"] = $_SESSION["sube_key"];
            $urunleri_ekle = DB::insert("cek_senet_odeme_urunler", $item);
            if ($urunleri_ekle) {

            } else {
                $cek_id = $item["cek_id"];
                $arr2 = [
                    'status' => 2,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                if ($item["banka_id"] == 0) {
                    $bizim_ceki_dusur = DB::update("cikis_cek_urunler", "id", $cek_id, $arr2);
                } else {
                    $bizim_ceki_dusur = DB::update("bizim_cek_urunler", "id", $cek_id, $arr2);
                }

            }
        }
        if ($bizim_ceki_dusur) {
            echo 1;
        } else {
            echo 500;
        }
    }
}
if ($islem == "odenen_cekleri_getir_sql") {
    $sql = "
SELECT
       csg.*,
       b.banka_adi,
       k.cari_adi,
       SUM(acu.tutar) as tutar,
       acu.seri_no
FROM 
     cek_senet_odeme as csg
INNER JOIN cek_senet_odeme_urunler as acu on acu.odeme_id=csg.id
LEFT JOIN banka as b on b.id=acu.banka_id
LEFT JOIN cari as k on k.id=acu.cari_id
WHERE csg.status=1 AND csg.cari_key='$cari_key' AND acu.status=1";
    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        $sql .= " AND csg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
    }
    $sql .= " GROUP BY odeme_id";
    $cek_senetler_listesi = DB::all_data($sql);
    if ($cek_senetler_listesi > 0) {
        echo json_encode($cek_senetler_listesi);
    } else {
        echo 2;
    }
}
if ($islem == "cek_senet_odemeyi_iptal_et_sql") {
    $id = $_POST["id"];
    $_POST["status"] = 0;
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $urunlerini_getir = DB::all_data("SELECT * FROM cek_senet_odeme_urunler WHERE status=1 AND cari_key='$cari_key' AND odeme_id='$id'");
    if ($urunlerini_getir > 0) {
        foreach ($urunlerini_getir as $item) {
            if ($item["asil_borclu"] == "BİZ") {
                $cekid = $item["cek_id"];
                $arr = [
                    'status' => 1
                ];
                $guncelle = DB::update("bizim_cek_urunler", "id", $cekid, $arr);
            } else {
                $cekid = $item["cek_id"];
                $arr = [
                    'status' => 1
                ];
                $guncelle = DB::update("cikis_cek_urunler", "id", $cekid, $arr);
            }

        }
        if ($guncelle) {
            $tahsil_sil = DB::update("cek_senet_odeme", "id", $id, $_POST);
            $odeme_sil = DB::update("cek_senet_odeme_urunler", "odeme_id", $id, $_POST);
            if ($tahsil_sil) {
                echo 1;
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    } else {
        $tahsil_sil = DB::update("cek_senet_odeme", "id", $id, $_POST);
        $odeme_sil = DB::update("cek_senet_odeme_urunler", "odeme_id", $id, $_POST);
        if ($tahsil_sil) {
            echo 1;
        } else {
            echo 2;
        }
    }
}