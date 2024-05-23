<?php
include '../DB.php';
date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=UTF-8');
session_start();
DB::connect();
$islem = $_GET["islem"];
$cari_key = $_SESSION["cari_key"];
$sube_key = $_SESSION["sube_key"];

if ($islem == "yeni_alinan_cek_girisi_sql") {

    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    if ($_POST["alinan_cekid"] == "") {
        $arr = [
            "cari_id" => $_POST["cari_id"],
            "insert_userid" => $_SESSION["user_id"],
            "insert_datetime" => date("Y-m-d H:i:s"),
            'cari_key' => $_SESSION["cari_key"],
            'sube_key' => $_SESSION["sube_key"]
        ];
        $yeni_cek_giris_olustur = DB::insert("alinan_cek_giris", $arr);
        if ($yeni_cek_giris_olustur) {
            echo 500;
        } else {
            $son_eklenen = DB::single_query("SELECT id FROM alinan_cek_giris where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
            if ($son_eklenen > 0) {
                $_POST["alinan_cekid"] = $son_eklenen["id"];
                unset($_POST["cari_id"]);
                $_POST["cari_key"] = $_SESSION["cari_key"];
                $_POST["sube_key"] = $_SESSION["sube_key"];
                $_POST["son_durum"] = 1;
                $_POST["bizim"] = 2;
                $cek_urunu_olustur = DB::insert("alinan_cek_urunler", $_POST);
                if ($cek_urunu_olustur) {
                    echo 500;
                } else {
                    $cek_id = $son_eklenen["id"];
                    $datalari_getir = DB::all_data("SELECT * FROM alinan_cek_urunler WHERE status=1 AND cari_key='$cari_key' AND alinan_cekid='$cek_id'");
                    if ($datalari_getir > 0) {
                        echo json_encode($datalari_getir);
                    } else {
                        echo 2;
                    }
                }
            } else {
                echo 2;
            }
        }
    } else {
        $arr = [
            "cari_id" => $_POST["cari_id"],
            "update_userid" => $_SESSION["user_id"],
            "update_datetime" => date("Y-m-d H:i:s"),
            'cari_key' => $_SESSION["cari_key"],
            'sube_key' => $_SESSION["sube_key"]
        ];
        $yeni_cek_giris_olustur = DB::update("alinan_cek_giris", "id", $_POST["alinan_cekid"], $arr);
        if ($yeni_cek_giris_olustur) {
            unset($_POST["cari_id"]);
            $_POST["cari_key"] = $_SESSION["cari_key"];
            $_POST["sube_key"] = $_SESSION["sube_key"];
            $_POST["son_durum"] = 1;
            $_POST["bizim"] = 2;
            $cek_urunu_olustur = DB::insert("alinan_cek_urunler", $_POST);
            if ($cek_urunu_olustur) {
                echo 500;
            } else {
                $cek_id = $_POST["alinan_cekid"];
                $datalari_getir = DB::all_data("SELECT * FROM alinan_cek_urunler WHERE status=1 AND cari_key='$cari_key' AND alinan_cekid='$cek_id'");
                if ($datalari_getir > 0) {
                    echo json_encode($datalari_getir);
                } else {
                    echo 2;
                }
            }
        } else {
            echo 500;
        }
    }
}
if ($islem == "cek_iptal_et_sql") {
    $id = $_POST["id"];
    $cek_id = $_POST["cek_id"];
    unset($_POST["cek_id"]);
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_detail"] = "Kullanıcı Çek Oluştururken Listeden Silmiştir";
    $_POST["status"] = 0;
    $cek_sil = DB::update("alinan_cek_urunler", "id", $id, $_POST);
    if ($cek_sil) {
        $datalari_getir = DB::all_data("SELECT * FROM alinan_cek_urunler WHERE status=1 AND cari_key='$cari_key' AND alinan_cekid='$cek_id'");
        if ($datalari_getir > 0) {
            echo json_encode($datalari_getir);
        } else {
            echo 2;
        }
    } else {
        echo 500;
    }
}
if ($islem == "cek_bilgileri_getir_sql") {
    $id = $_GET["id"];
    $datalari_getir = DB::single_query("SELECT * FROM alinan_cek_urunler WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    if ($datalari_getir > 0) {
        echo json_encode($datalari_getir);
    } else {
        echo 2;
    }
}
if ($islem == "yeni_alinan_cek_guncelle_sql") {
    $arr = [
        "cari_id" => $_POST["cari_id"],
        "update_userid" => $_SESSION["user_id"],
        "update_datetime" => date("Y-m-d H:i:s"),
        'cari_key' => $_SESSION["cari_key"],
        'sube_key' => $_SESSION["sube_key"]
    ];
    $yeni_cek_giris_olustur = DB::update("alinan_cek_giris", "id", $_POST["alinan_cekid"], $arr);
    if ($yeni_cek_giris_olustur) {
        unset($_POST["cari_id"]);
        $_POST["cari_key"] = $_SESSION["cari_key"];
        $_POST["sube_key"] = $_SESSION["sube_key"];
        $_POST["son_durum"] = 1;
        $_POST["update_userid"] = $_SESSION["user_id"];
        $_POST["update_datetime"] = date("Y-m-d H:i:s");
        $_POST["bizim"] = 2;
        $cek_urunu_olustur = DB::update("alinan_cek_urunler", "id", $_POST["id"], $_POST);
        if ($cek_urunu_olustur) {
            $cek_id = $_POST["alinan_cekid"];
            $datalari_getir = DB::all_data("SELECT * FROM alinan_cek_urunler WHERE status=1 AND cari_key='$cari_key' AND alinan_cekid='$cek_id'");
            if ($datalari_getir > 0) {
                echo json_encode($datalari_getir);
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
if ($islem == "cek_senet_onayla_sql") {
    if (isset($_POST["cek_id"])) {
        $id = $_POST["cek_id"];
        unset($_POST["cek_id"]);
        $cari_kodu = $_POST["cari_kodu"];
        unset($_POST["cari_kodu"]);
        $caridemi = DB::single_query("SELECT id FROM cari WHERE status=1 AND cari_kodu='$cari_kodu'");
        if ($caridemi > 0) {

        } else {
            $_POST["cari_id"] = 0;
            $uyedemi = DB::single_query("select id from uye_tanim WHERE status=1 AND tc_no='$cari_kodu'");
            if ($uyedemi > 0) {
                $_POST["uye_id"] = $uyedemi["id"];
            }
        }
        $cek_guncelle = DB::update("alinan_cek_giris", "id", $id, $_POST);
        if ($cek_guncelle) {
            echo 1;
        } else {
            echo 2;
        }
    } else {

    }
}
if ($islem == "cek_senet_vazgec_sql") {
    if (isset($_POST["cek_id"])) {
        $cek_id = $_POST["cek_id"];
        unset($_POST["cek_id"]);
        $_POST["delete_detail"] = "Kullanıcı Çek Girişi Oluşturmaktan Vazgeçmiştir";
        $_POST["delete_datetime"] = date("Y-m-d H:i:s");
        $_POST["delete_userid"] = $_SESSION["user_id"];
        $_POST["status"] = 0;
        $cek_vazgec = DB::update("alinan_cek_giris", "id", $cek_id, $_POST);
        if ($cek_vazgec) {
            echo 1;
        } else {
            echo 2;
        }
    } else {

    }
}
if ($islem == "tum_cek_ve_senetleri_getir_sql") {
    $sql = "
SELECT
       csg.*,
       c.cari_adi,
       ut.uye_adi as cari_adi,
       SUM(acu.girilen_tutar) as tutar
FROM 
     alinan_cek_giris as csg
INNER JOIN alinan_cek_urunler as acu on acu.alinan_cekid=csg.id
LEFT JOIN cari as c on c.id=csg.cari_id
LEFT JOIN uye_tanim as ut on ut.id=csg.uye_id
WHERE csg.status=1 AND csg.cari_key='$cari_key' AND acu.status=1";
    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        $sql .= " AND csg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
    }
    $sql .= " GROUP BY alinan_cekid";

    $cekler = DB::all_data($sql);
    if ($cekler > 0) {
        echo json_encode($cekler);
    } else {
        echo 2;
    }
}
if ($islem == "cek_senet_sil_sql") {
    $cek_id = $_POST["id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["status"] = 0;
    $cek_vazgec = DB::update("alinan_cek_giris", "id", $cek_id, $_POST);
    if ($cek_vazgec) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "girilen_cek_senet_bilgileri_sql") {
    $cek_id = $_GET["id"];
    $alinan_cekid = DB::all_data("SELECT * FROM alinan_cek_urunler WHERE status=1 AND cari_key='$cari_key' AND alinan_cekid='$cek_id'");
    if ($alinan_cekid > 0) {
        echo json_encode($alinan_cekid);
    } else {
        echo 2;
    }
}
if ($islem == "alinan_cek_ana_bilgiler_sql") {
    $id = $_GET["id"];
    $cek_ust_bilgiler = DB::single_query("
SELECT 
       acg.*,
       c.cari_adi,
       c.cari_kodu,
       c.telefon,
       c.yetkili_adi1,
       c.yetkili_tel1,
       c.vergi_dairesi,
       c.vergi_no,
       ut.tc_no as cari_kodu,
       ut.uye_adi as cari_adi,
       ut.id as cari_id,
       ut.adres,
       cab.adres
FROM 
     alinan_cek_giris  as acg
LEFT JOIN cari AS c on c.id=acg.cari_id
LEFT JOIN uye_tanim as ut on ut.id=acg.uye_id
LEFT JOIN cari_adres_bilgileri AS cab on cab.cari_id=c.id
WHERE 
      acg.status=1 
  AND 
      acg.cari_key='$cari_key' 
      AND 
      acg.id='$id'");
    if ($cek_ust_bilgiler > 0) {
        echo json_encode($cek_ust_bilgiler);
    } else {
        echo 2;
    }
}
if ($islem == "cekler_ve_senetleri_cikis_icin_getir_sql") {
    $cari_id = $_GET["cari_id"];
    $alinan_cekid = DB::all_data("
SELECT
       acu.*
FROM 
     alinan_cek_urunler as acu
INNER JOIN alinan_cek_giris as acg on acg.id=acu.alinan_cekid
WHERE
      acu.status=1 AND acu.cari_key='$cari_key' AND acg.status=1 AND acu.bizim!=1");
    if ($alinan_cekid > 0) {
        echo json_encode($alinan_cekid);
    } else {
        echo 2;
    }
}
if ($islem == "cek_senet_cikis_kaydet_sql") {
    if (isset($_POST["cari_id"])) {
        $arr = [
            "cari_id" => $_POST["cari_id"],
            "insert_userid" => $_SESSION["user_id"],
            "insert_datetime" => date("Y-m-d H:i:s"),
            'cari_key' => $_SESSION["cari_key"],
            'tarih' => $_POST["tarih"],
            'belge_no' => $_POST["belge_no"],
            'doviz_kuru' => $_POST["doviz_kuru"],
            'doviz_tur' => $_POST["doviz_tur"],
            'ort_vade' => $_POST["ort_vade"],
            'ort_gun' => $_POST["ort_gun"],
            'mutabakat' => $_POST["mutabakat"],
            'ozel_kod1' => $_POST["ozel_kod1"],
            'ozel_kod2' => $_POST["ozel_kod2"],
            'aciklama' => $_POST["aciklama"],
            'islem' => $_POST["arr"][0]["islem"],
            'sube_key' => $_SESSION["sube_key"]
        ];
    } else {
        $arr = [
            "banka_id" => $_POST["banka_id"],
            "insert_userid" => $_SESSION["user_id"],
            "insert_datetime" => date("Y-m-d H:i:s"),
            'cari_key' => $_SESSION["cari_key"],
            'tarih' => $_POST["tarih"],
            'belge_no' => $_POST["belge_no"],
            'doviz_kuru' => $_POST["doviz_kuru"],
            'doviz_tur' => $_POST["doviz_tur"],
            'ort_vade' => $_POST["ort_vade"],
            'ort_gun' => $_POST["ort_gun"],
            'mutabakat' => $_POST["mutabakat"],
            'ozel_kod1' => $_POST["ozel_kod1"],
            'ozel_kod2' => $_POST["ozel_kod2"],
            'aciklama' => $_POST["aciklama"],
            'islem' => $_POST["arr"][0]["islem"],
            'sube_key' => $_SESSION["sube_key"]
        ];
    }

    $yeni_cek_giris_olustur = DB::insert("alinan_cek_cikis", $arr);
    $ek_sorgu = "";
    if ($_SESSION["sube_key"] != 0) {
        $ek_sorgu = " AND sube_key='$sube_key'";
    }
    $son = DB::single_query("SELECT id FROM alinan_cek_cikis where cari_key='$cari_key' $ek_sorgu ORDER BY id DESC LIMIT 1");
    $id = $son["id"];
    if ($yeni_cek_giris_olustur) {
        echo 500;
    } else {
        foreach ($_POST["arr"] as $item) {
            unset($item["islem"]);
            $item["cikis_cekid"] = $id;
            $item["cari_key"] = $_SESSION["cari_key"];
            $item["sube_key"] = $_SESSION["sube_key"];
            $alinan_cekid = $item["alinan_cekid"];
            $urunleri_ekle = DB::insert("cikis_cek_urunler", $item);
            if ($urunleri_ekle) {
                echo 500;
            } else {
                $arr2 = [
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s"),
                    'status' => 2
                ];
                $alinan_cek_giris_guncelle = DB::update("alinan_cek_giris", "id", $alinan_cekid, $arr2);
            }
        }
        if ($alinan_cek_giris_guncelle) {
            echo 1;
        } else {
            echo 500;
        }

    }


}
if ($islem == "tum_cek_ve_senet_cikislari_getir_sql") {
    $sql = "
SELECT
       csg.*,
       c.cari_adi,
       b.banka_adi,
       SUM(acu.girilen_tutar) as tutar
FROM 
     alinan_cek_cikis as csg
INNER JOIN cikis_cek_urunler as acu on acu.cikis_cekid=csg.id
LEFT JOIN cari as c on c.id=csg.cari_id
LEFT JOIN banka as b on b.id=csg.banka_id
WHERE csg.status=1 AND csg.cari_key='$cari_key' AND acu.status=1 ";
    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        $sql .= " AND csg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
    }
    $sql .= " GROUP BY cikis_cekid";
    $cekler = DB::all_data($sql);

    $sql2 = "
SELECT
       csg.*,
       csg.doviz_turu as doviz_tur,
       c.cari_adi,
       SUM(acu.tutar) as tutar
FROM 
     bizim_cek_cikis as csg
INNER JOIN bizim_cek_urunler as acu on acu.bizim_cekid=csg.id
LEFT JOIN cari as c on c.id=csg.cari_id
WHERE csg.status=1 AND csg.cari_key='$cari_key' AND acu.status=1";
    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        $sql .= " AND csg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
    }
    $sql2 .= " GROUP BY acu.bizim_cekid";
    $cekler2 = DB::all_data($sql2);
    if ($cekler2 > 0 && $cekler > 0) {
        $merge = array_merge($cekler, $cekler2);
    } else if ($cekler > 0) {
        $merge = $cekler;
    } else {
        $merge = $cekler2;
    }
    if ($merge > 0) {
        echo json_encode($merge);
    } else {
        echo 2;
    }
}
if ($islem == "cek_senet_cikis_sil_sql") {
    $cek_id = $_POST["id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["status"] = 0;
    $tum_cekler = DB::all_data("SELECT * FROM cikis_cek_urunler WHERE cikis_cekid='$cek_id'");
    if ($tum_cekler > 0) {
        foreach ($tum_cekler as $item) {
            $alinan_cekid = $item["alinan_cekid"];
            $arr = [
                'status' => 1
            ];
            $giris_cek_guncelle = DB::update("alinan_cek_giris", "id", $alinan_cekid, $arr);
        }
        if ($giris_cek_guncelle) {
            $cek_vazgec = DB::update("alinan_cek_cikis", "id", $cek_id, $_POST);
            if ($cek_vazgec) {
                echo 1;
            } else {
                echo 500;
            }
        } else {
            echo 2;
        }
    } else {
        $cek_vazgec = DB::update("alinan_cek_cikis", "id", $cek_id, $_POST);
        if ($cek_vazgec) {
            echo 1;
        } else {
            echo 2;
        }
    }
}
if ($islem == "cek_senet_bilgilerini_getir_cikis") {
    $id = $_GET["id"];
    $cikis_urun_bilgileri = DB::all_data("SELECT * FROM cikis_cek_urunler WHERE status=1 AND cari_key='$cari_key' AND cikis_cekid='$id'");
    if ($cikis_urun_bilgileri > 0) {
        echo json_encode($cikis_urun_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "alinan_cikis_cek_ana_bilgiler_sql") {
    $id = $_GET["id"];
    $cek_ust_bilgiler = DB::single_query("
SELECT 
       acg.*,
       c.cari_adi,
       c.cari_kodu,
       c.telefon,
       c.yetkili_adi1,
       c.yetkili_tel1,
       c.vergi_dairesi,
       c.vergi_no,
       cab.adres
FROM 
     alinan_cek_cikis  as acg
INNER JOIN cari AS c on c.id=acg.cari_id
LEFT JOIN cari_adres_bilgileri AS cab on cab.cari_id=c.id
WHERE 
      acg.status=1 
  AND 
      acg.cari_key='$cari_key' 
      AND 
      acg.id='$id'");
    if ($cek_ust_bilgiler > 0) {
        echo json_encode($cek_ust_bilgiler);
    } else {
        echo 2;
    }
}
if ($islem == "cek_cikisi_iptal_et_sql") {
    $id = $_POST["id"];
    $_POST["status"] = 0;
    $_POST["delete_detail"] = "Kullanıcı Güncelleme Sayfasından Silmiştir";
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $urun_guncelle = DB::update("cikis_cek_urunler", "id", $id, $_POST);
    if ($urun_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "cek_senet_cikis_guncelle_sql") {
    $id = $_POST["id"];
    $cek_cikis_guncelle = DB::update("alinan_cek_cikis", "id", $id, $_POST);
    if ($cek_cikis_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "banka_kodu_bilgileri_getir_sql") {
    $banka_kodu = $_GET["banka_kodu"];
    $ek_banka = "";
    if ($_SESSION["sube_key"] != 0) {
        $ek_banka = " AND sube_key='$sube_key'";
    }
    $banka_bilgileri = DB::single_query("SELECT * FROM banka WHERE status=1 AND cari_key='$cari_key' $ek_banka AND banka_kodu='$banka_kodu'");
    if ($banka_bilgileri > 0) {
        echo json_encode($banka_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "cekler_ve_senetleri_cikis_banka_icin_getir_sql") {
    $alinan_cekid = DB::all_data("
SELECT
       acu.*
FROM 
     alinan_cek_urunler as acu
INNER JOIN alinan_cek_giris as acg on acg.id=acu.alinan_cekid
WHERE
      acu.status=1 AND acu.cari_key='$cari_key' AND acg.status=1 AND acu.bizim!=1");
    if ($alinan_cekid > 0) {
        echo json_encode($alinan_cekid);
    } else {
        echo 2;
    }
}
if ($islem == "ciro_edilen_cekleri_getir_sql") {
    $alinan_cekid = DB::all_data("
SELECT
       acu.*
FROM 
     cikis_cek_urunler as acu
INNER JOIN alinan_cek_cikis as acg on acg.id=acu.cikis_cekid
WHERE
      acu.status=1 AND acu.cari_key='$cari_key' AND acg.status=1  AND acu.bizim!=1 AND acg.islem='cek_senet_cirosu'");
    if ($alinan_cekid > 0) {
        echo json_encode($alinan_cekid);
    } else {
        echo 2;
    }
}
if ($islem == "tahsile_verilen_cekleri_getir_sql") {
    $alinan_cekid = DB::all_data("
SELECT
       acu.*
FROM 
     cikis_cek_urunler as acu
INNER JOIN alinan_cek_cikis as acg on acg.id=acu.cikis_cekid
WHERE
      acu.status=1 AND acu.cari_key='$cari_key' AND acg.status=1  AND acu.bizim!=1 AND acg.islem='bankaya_tahsile_verme'");
    if ($alinan_cekid > 0) {
        echo json_encode($alinan_cekid);
    } else {
        echo 2;
    }
}
if ($islem == "teminata_verilen_cekleri_getir_sql") {
    $alinan_cekid = DB::all_data("
SELECT
       acu.*
FROM 
     cikis_cek_urunler as acu
INNER JOIN alinan_cek_cikis as acg on acg.id=acu.cikis_cekid
WHERE
      acu.status=1 AND acu.cari_key='$cari_key' AND acg.status=1  AND acu.bizim!=1 AND acg.islem='bankaya_teminata_verme'");
    if ($alinan_cekid > 0) {
        echo json_encode($alinan_cekid);
    } else {
        echo 2;
    }
}
if ($islem == "portfoydeki_cekleri_getir_sql") {
    $alinan_cekid = DB::all_data("
SELECT
       acu.*
FROM 
     alinan_cek_urunler as acu
INNER JOIN alinan_cek_giris as acg on acg.id=acu.alinan_cekid
WHERE
      acu.status=1 AND acu.cari_key='$cari_key' AND acg.status=1 AND acu.bizim!=1");
    if ($alinan_cekid > 0) {
        echo json_encode($alinan_cekid);
    } else {
        echo 2;
    }
}
if ($islem == "ciro_edilen_cek_karsiliksiz_sql") {
    foreach ($_POST["arr"] as $item) {
        if (isset($item["alinan_cekid"])) {
            $arr = [
                'alinan_cekid' => $item["alinan_cekid"],
                'insert_userid' => $_SESSION["user_id"],
                'insert_datetime' => date("Y-m-d H:i:s"),
                'cari_key' => $cari_key,
                'sube_key' => $sube_key,
                'islem' => "ciro_edilen_cek_senet_karsiliksiz"
            ];
            $karsiliksiz_cek_senet = DB::insert("karsiliksiz_cek_senet", $arr);
            if ($karsiliksiz_cek_senet) {
                echo 500;
            } else {
                $id = $item["alinan_cekid"];
                $arr2 = [
                    'status' => 2,
                ];
                $cikis_cek_urunler = DB::update("cikis_cek_urunler", "id", $id, $arr2);
            }
        } else if (isset($item["alinan_senetid"])) {

        }
    }
    if ($cikis_cek_urunler) {
        echo 1;
    } else {
        echo 500;
    }
}
if ($islem == "karsiliksiz_ciro_edilen_cekleri_getir") {
    $karsiliksiz_ciro_edilen_cekler = DB::all_data("
SELECT 
       kcs.insert_datetime as karsiliksiz_tarih,
       kcs.id,
       ccu.seri_no,
       c.cari_adi,
       c.yetkili_adi1,
       ccu.girilen_tutar,
       ccu.vade_tarih
FROM 
     karsiliksiz_cek_senet as kcs
INNER JOIN cikis_cek_urunler AS ccu ON ccu.id=kcs.alinan_cekid
INNER JOIN alinan_cek_cikis AS acc ON acc.id=ccu.cikis_cekid
INNER JOIN cari AS c on c.id=acc.cari_id
WHERE kcs.status=1 AND kcs.cari_key='$cari_key' AND kcs.islem='ciro_edilen_cek_senet_karsiliksiz'");
    if ($karsiliksiz_ciro_edilen_cekler > 0) {
        echo json_encode($karsiliksiz_ciro_edilen_cekler);
    } else {
        echo 2;
    }
}
if ($islem == "karsiliksiz_cek_iptal_et_sql") {
    $id = $_POST["id"];
    $bilgileri = DB::single_query("SELECT alinan_cekid,alinan_senetid FROM karsiliksiz_cek_senet WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    if ($bilgileri > 0) {
        $alinan_cekid = $bilgileri["alinan_cekid"];
        $alinan_senetid = $bilgileri["alinan_senetid"];
        if ($alinan_senetid == 0) {
            $_POST["delete_userid"] = $_SESSION["user_id"];
            $_POST["delete_datetime"] = date("Y-m-d H:i:s");
            $_POST["status"] = 0;
            $karsiliksiz_ceki_sil = DB::update("karsiliksiz_cek_senet", "id", $id, $_POST);
            if ($karsiliksiz_ceki_sil) {
                $arr = [
                    'status' => 1,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $cikis_urun_geri_getir = DB::update("cikis_cek_urunler", "id", $alinan_cekid, $arr);
                if ($cikis_urun_geri_getir) {
                    echo 1;
                } else {
                    echo 500;
                }
            } else {
                echo 500;
            }
        } else {

        }
    }
}
if ($islem == "tahsile_verilen_cek_karsiliksiz_sql") {
    foreach ($_POST["arr"] as $item) {
        if (isset($item["alinan_cekid"])) {
            $arr = [
                'alinan_cekid' => $item["alinan_cekid"],
                'insert_userid' => $_SESSION["user_id"],
                'insert_datetime' => date("Y-m-d H:i:s"),
                'cari_key' => $cari_key,
                'sube_key' => $sube_key,
                'islem' => "tahsile_verilen_cek_senet_karsiliksizdir"
            ];
            $karsiliksiz_cek_senet = DB::insert("karsiliksiz_cek_senet", $arr);
            if ($karsiliksiz_cek_senet) {
                echo 500;
            } else {
                $id = $item["alinan_cekid"];
                $arr2 = [
                    'status' => 2,
                ];
                $cikis_cek_urunler = DB::update("cikis_cek_urunler", "id", $id, $arr2);
            }
        } else if (isset($item["alinan_senetid"])) {

        }
    }
    if ($cikis_cek_urunler) {
        echo 1;
    } else {
        echo 500;
    }
}
if ($islem == "karsiliksiz_tahsile_verilen_cekleri_getir") {
    $karsiliksiz_ciro_edilen_cekler = DB::all_data("
SELECT 
       kcs.insert_datetime as karsiliksiz_tarih,
       kcs.id,
       ccu.seri_no,
       c.cari_adi,
       c.yetkili_adi1,
       ccu.girilen_tutar,
       ccu.vade_tarih
FROM 
     karsiliksiz_cek_senet as kcs
INNER JOIN cikis_cek_urunler AS ccu ON ccu.id=kcs.alinan_cekid
INNER JOIN alinan_cek_cikis AS acc ON acc.id=ccu.cikis_cekid
INNER JOIN alinan_cek_giris AS acg on acg.id=ccu.alinan_cekid
INNER JOIN cari AS c ON c.id=acg.cari_id
WHERE kcs.status=1 AND kcs.cari_key='$cari_key' AND kcs.islem='tahsile_verilen_cek_senet_karsiliksizdir'");
    if ($karsiliksiz_ciro_edilen_cekler > 0) {
        echo json_encode($karsiliksiz_ciro_edilen_cekler);
    } else {
        echo 2;
    }
}
if ($islem == "karsiliksiz_teminata_verilen_cekleri_getir") {
    $karsiliksiz_ciro_edilen_cekler = DB::all_data("
SELECT 
       kcs.insert_datetime as karsiliksiz_tarih,
       kcs.id,
       ccu.seri_no,
       c.cari_adi,
       c.yetkili_adi1,
       ccu.girilen_tutar,
       ccu.vade_tarih
FROM 
     karsiliksiz_cek_senet as kcs
INNER JOIN cikis_cek_urunler AS ccu ON ccu.id=kcs.alinan_cekid
INNER JOIN alinan_cek_cikis AS acc ON acc.id=ccu.cikis_cekid
INNER JOIN alinan_cek_giris AS acg on acg.id=ccu.alinan_cekid
INNER JOIN cari AS c ON c.id=acg.cari_id
WHERE kcs.status=1 AND kcs.cari_key='$cari_key' AND kcs.islem='teminata_verilen_cek_senet_karsiliksizdir'");
    if ($karsiliksiz_ciro_edilen_cekler > 0) {
        echo json_encode($karsiliksiz_ciro_edilen_cekler);
    } else {
        echo 2;
    }
}
if ($islem == "teminata_verilen_cek_karsiliksiz_sql") {
    foreach ($_POST["arr"] as $item) {
        if (isset($item["alinan_cekid"])) {
            $arr = [
                'alinan_cekid' => $item["alinan_cekid"],
                'insert_userid' => $_SESSION["user_id"],
                'insert_datetime' => date("Y-m-d H:i:s"),
                'cari_key' => $cari_key,
                'sube_key' => $sube_key,
                'islem' => "teminata_verilen_cek_senet_karsiliksizdir"
            ];
            $karsiliksiz_cek_senet = DB::insert("karsiliksiz_cek_senet", $arr);
            if ($karsiliksiz_cek_senet) {
                echo 500;
            } else {
                $id = $item["alinan_cekid"];
                $arr2 = [
                    'status' => 2,
                ];
                $cikis_cek_urunler = DB::update("cikis_cek_urunler", "id", $id, $arr2);
            }
        } else if (isset($item["alinan_senetid"])) {

        }
    }
    if ($cikis_cek_urunler) {
        echo 1;
    } else {
        echo 500;
    }
}
if ($islem == "karsiliksiz_portfoydeki_verilen_cekleri_getir") {
    $karsiliksiz_ciro_edilen_cekler = DB::all_data("
SELECT 
       kcs.insert_datetime as karsiliksiz_tarih,
       kcs.id,
       ccu.seri_no,
       c.cari_adi,
       c.yetkili_adi1,
       ccu.girilen_tutar,
       ccu.vade_tarih
FROM 
     karsiliksiz_cek_senet as kcs
INNER JOIN alinan_cek_urunler AS ccu ON ccu.id=kcs.alinan_cekid
INNER JOIN alinan_cek_giris AS acc ON acc.id=ccu.alinan_cekid
INNER JOIN cari AS c on c.id=acc.cari_id
WHERE kcs.status=1 AND kcs.cari_key='$cari_key' AND kcs.islem='portfoydeki_cek_senet_karsiliksizdir'");
    if ($karsiliksiz_ciro_edilen_cekler > 0) {
        echo json_encode($karsiliksiz_ciro_edilen_cekler);
    } else {
        echo 2;
    }
}
if ($islem == "portfoydeki_cek_karsiliksiz_sql") {
    foreach ($_POST["arr"] as $item) {
        if (isset($item["alinan_cekid"])) {
            $arr = [
                'alinan_cekid' => $item["alinan_cekid"],
                'insert_userid' => $_SESSION["user_id"],
                'insert_datetime' => date("Y-m-d H:i:s"),
                'cari_key' => $cari_key,
                'sube_key' => $sube_key,
                'islem' => "portfoydeki_cek_senet_karsiliksizdir"
            ];
            $karsiliksiz_cek_senet = DB::insert("karsiliksiz_cek_senet", $arr);
            if ($karsiliksiz_cek_senet) {
                echo 500;
            } else {
                $id = $item["alinan_cekid"];
                $arr2 = [
                    'status' => 2,
                ];
                $cikis_cek_urunler = DB::update("alinan_cek_urunler", "id", $id, $arr2);
            }
        } else if (isset($item["alinan_senetid"])) {

        }
    }
    if ($cikis_cek_urunler) {
        echo 1;
    } else {
        echo 500;
    }
}
if ($islem == "portfoydeki_karsiliksiz_cek_iptal_et_sql") {
    $id = $_POST["id"];
    $bilgileri = DB::single_query("SELECT alinan_cekid,alinan_senetid FROM karsiliksiz_cek_senet WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    if ($bilgileri > 0) {
        $alinan_cekid = $bilgileri["alinan_cekid"];
        $alinan_senetid = $bilgileri["alinan_senetid"];
        if ($alinan_senetid == 0) {
            $_POST["delete_userid"] = $_SESSION["user_id"];
            $_POST["delete_datetime"] = date("Y-m-d H:i:s");
            $_POST["status"] = 0;
            $karsiliksiz_ceki_sil = DB::update("karsiliksiz_cek_senet", "id", $id, $_POST);
            if ($karsiliksiz_ceki_sil) {
                $arr = [
                    'status' => 1,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $cikis_urun_geri_getir = DB::update("alinan_cek_urunler", "id", $alinan_cekid, $arr);
                if ($cikis_urun_geri_getir) {
                    echo 1;
                } else {
                    echo 500;
                }
            } else {
                echo 500;
            }
        } else {

        }
    }
}
if ($islem == "cek_stok_tanimla_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["cari_key"] = $_SESSION["cari_key"];
    $_POST["sube_key"] = $_SESSION["sube_key"];
    $baslangic = DB::alone_number($_POST["cek_baslangic_no"]);
    $bitis = DB::alone_number($_POST["cek_bitis_no"]);
    $fark = $bitis - $baslangic;
    $fark = $fark + 1;
    $cek_tanim_kaydet = DB::insert("cek_stok_tanim", $_POST);
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    if ($cek_tanim_kaydet) {
        echo 500;
    } else {
        $sonid = DB::single_query("SELECT id FROM cek_stok_tanim where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        for ($i = 0; $i < $fark; $i++) {
            $cek_stokid = $sonid["id"];
            $arr = [
                'cek_stokid' => $cek_stokid,
                'cek_no' => $baslangic,
                'insert_userid' => $_SESSION["user_id"],
                'insert_datetime' => date("Y-m-d H:i:s"),
                'cari_key' => $cari_key,
                'sube_key' => $sube_key,
                'banka_id' => $_POST["banka_id"]
            ];
            $yeni_cek_yaprak_olustur = DB::insert("tanimlanan_cekler", $arr);
            $baslangic++;
        }
        if ($yeni_cek_yaprak_olustur) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "tanimli_cekleri_getir_sql") {
    $tum_tanimli_cekleri_getir_sql = DB::all_data("
SELECT
    cst.*,
    b.banka_adi,
    (SELECT COUNT(*) FROM tanimlanan_cekler tc WHERE tc.status = 2 AND tc.banka_id = cst.banka_id) as tanimlanandaki_kullanilan
FROM 
    cek_stok_tanim as cst
INNER JOIN banka AS b on b.id = cst.banka_id
WHERE cst.status = 1 AND cst.cari_key = '$cari_key'");
    if ($tum_tanimli_cekleri_getir_sql > 0) {
        echo json_encode($tum_tanimli_cekleri_getir_sql);
    } else {
        echo 2;
    }
}
if ($islem == "bankaya_ait_ceklerimizi_getir_sql") {
    $banka_id = $_GET["banka_id"];
    $bankaya_ait_cekler = DB::single_query("
SELECT 
       tc.*,
       cst.cek_baslangic_no
FROM 
     tanimlanan_cekler as tc
INNER JOIN cek_stok_tanim as cst on cst.id=tc.cek_stokid
WHERE tc.status=1 AND tc.banka_id='$banka_id' ORDER BY tc.id ASC LIMIT 1");
    if ($bankaya_ait_cekler > 0) {
        echo json_encode($bankaya_ait_cekler);
    } else {
        echo 2;
    }
}
if ($islem == "bize_ait_cek_olustur_sql") {
    if (isset($_POST["bizim_cekid"])) {
        $bizim_cekid = $_POST["bizim_cekid"];
        $seri_no = $_POST["seri_no"];
        $seri_no_stoktami = DB::single_query("SELECT * FROM tanimlanan_cekler WHERE status=1 AND cek_no='$seri_no'");
        if ($seri_no_stoktami > 0) {
            unset($_POST["cari_id"]);
            $_POST["tanimli_cekid"] = $seri_no_stoktami["id"];
            $_POST["cari_key"] = $cari_key;
            $bizim_ceklere_ekle = DB::insert("bizim_cek_urunler", $_POST);
            if ($bizim_ceklere_ekle) {
                echo 500;
            } else {
                $arr2 = [
                    'status' => 2,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $tanimlanan_ceklerden_dusur = DB::update("tanimlanan_cekler", "cek_no", $_POST["seri_no"], $arr2);
                if ($tanimlanan_ceklerden_dusur > 0) {
                    $urunleri_getir = DB::all_data("
SELECT
       bcu.*,
       b.banka_adi,
       b.sube_adi,
       b.hesap_no
FROM 
     bizim_cek_urunler AS bcu
INNER JOIN banka as b on b.id=bcu.banka_id
WHERE bcu.status=1 AND bcu.bizim_cekid='$bizim_cekid' AND bcu.cari_key='$cari_key'");
                    if ($urunleri_getir > 0) {
                        echo json_encode($urunleri_getir);
                    } else {
                        echo 2;
                    }
                } else {
                    echo 500;
                }
            }
        } else {
            unset($_POST["cari_id"]);
            $_POST["cari_key"] = $cari_key;
            $bizim_ceklere_ekle = DB::insert("bizim_cek_urunler", $_POST);
            if ($bizim_ceklere_ekle) {
                echo 500;
            } else {
                $urunleri_getir = DB::all_data("
SELECT
       bcu.*,
       b.banka_adi,
       b.sube_adi,
       b.hesap_no
FROM 
     bizim_cek_urunler AS bcu
INNER JOIN banka as b on b.id=bcu.banka_id
WHERE bcu.status=1 AND bcu.bizim_cekid='$bizim_cekid' AND bcu.cari_key='$cari_key'");
                if ($urunleri_getir > 0) {
                    echo json_encode($urunleri_getir);
                } else {
                    echo 2;
                }
            }
        }
    } else {
        $arr = [
            'cari_id' => $_POST["cari_id"],
            'cari_key' => $cari_key,
            'sube_key' => $sube_key,
            'insert_userid' => $_SESSION["user_id"],
            'insert_datetime' => date("Y-m-d H:i:s")
        ];
        $bizim_cek_olustur = DB::insert("bizim_cek_cikis", $arr);
        if ($bizim_cek_olustur) {
            echo 500;
        } else {
            $son_eklenen = DB::single_query("SELECT id FROM bizim_cek_cikis where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
            $bizim_cekid = $son_eklenen["id"];
            $seri_no = $_POST["seri_no"];
            $seri_no_stoktami = DB::single_query("SELECT * FROM tanimlanan_cekler WHERE status=1 AND cek_no='$seri_no'");
            if ($seri_no_stoktami > 0) {
                $_POST["bizim_cekid"] = $son_eklenen["id"];
                unset($_POST["cari_id"]);
                $_POST["tanimli_cekid"] = $seri_no_stoktami["id"];
                $_POST["cari_key"] = $cari_key;
                $bizim_ceklere_ekle = DB::insert("bizim_cek_urunler", $_POST);
                if ($bizim_ceklere_ekle) {
                    echo 500;
                } else {
                    $arr2 = [
                        'status' => 2,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];
                    $tanimlanan_ceklerden_dusur = DB::update("tanimlanan_cekler", "cek_no", $_POST["seri_no"], $arr2);
                    if ($tanimlanan_ceklerden_dusur > 0) {
                        $urunleri_getir = DB::all_data("
SELECT
       bcu.*,
       b.banka_adi,
       b.sube_adi,
       b.hesap_no
FROM 
     bizim_cek_urunler AS bcu
INNER JOIN banka as b on b.id=bcu.banka_id
WHERE bcu.status=1 AND bcu.bizim_cekid='$bizim_cekid' AND bcu.cari_key='$cari_key'");
                        if ($urunleri_getir > 0) {
                            echo json_encode($urunleri_getir);
                        } else {
                            echo 2;
                        }
                    } else {
                        echo 500;
                    }
                }
            } else {
                $_POST["bizim_cekid"] = $son_eklenen["id"];
                unset($_POST["cari_id"]);
                $_POST["cari_key"] = $cari_key;
                $bizim_ceklere_ekle = DB::insert("bizim_cek_urunler", $_POST);
                if ($bizim_ceklere_ekle) {
                    echo 500;
                } else {
                    $urunleri_getir = DB::all_data("
SELECT
       bcu.*,
       b.banka_adi,
       b.sube_adi,
       b.hesap_no
FROM 
     bizim_cek_urunler AS bcu
INNER JOIN banka as b on b.id=bcu.banka_id
WHERE bcu.status=1 AND bcu.bizim_cekid='$bizim_cekid' AND bcu.cari_key='$cari_key'");
                    if ($urunleri_getir > 0) {
                        echo json_encode($urunleri_getir);
                    } else {
                        echo 2;
                    }
                }
            }
        }
    }
}
if ($islem == "kendi_cekimizi_iptal_et_sql") {
    $id = $_POST["id"];
    $cek_bilgileri = DB::single_query("SELECT * FROM bizim_cek_urunler WHERE status=1 AND id='$id'");
    if ($cek_bilgileri > 0) {
        $tanimli_cekid = $cek_bilgileri["tanimli_cekid"];
        $arr = [
            'status' => 0,
            'delete_userid' => $_SESSION["user_id"],
            'delete_datetime' => date("Y-m-d H:i:s")
        ];
        if ($tanimli_cekid == 0) {
            $cek_sil = DB::update("bizim_cek_urunler", "id", $id, $arr);
            if ($cek_sil) {
                echo 1;
            } else {
                echo 500;
            }
        } else {
            $arr2 = [
                'status' => 1
            ];
            $tanimli_ceki_gerial = DB::update("tanimlanan_cekler", "id", $tanimli_cekid, $arr2);
            if ($tanimli_ceki_gerial) {
                $cek_sil = DB::update("bizim_cek_urunler", "id", $id, $arr);
                if ($cek_sil) {
                    echo 1;
                } else {
                    echo 500;
                }
            } else {
                echo 500;
            }
        }
    } else {
        echo 2;
    }
}
if ($islem == "kendi_cekimizin_bilgilerini_guncelle") {
    $id = $_POST["id"];
    $bizim_cekimizi_guncelle = DB::update("bizim_cek_cikis", "id", $id, $_POST);
    if ($bizim_cekimizi_guncelle) {
        echo 1;
    } else {
        echo 500;
    }
}
if ($islem == "kendi_cekimiz_vazgec_sql") {
    $_POST["delete_detail"] = "Kullanıcı Vazgeçti";
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["status"] = 0;
    $vazgec = DB::update("bizim_cek_cikis", "id", $_POST["id"], $_POST);
    if ($vazgec) {
        $id = $_POST["id"];
        $bilgiler = DB::all_data("SELECT * FROM bizim_cek_urunler WHERE status=1 AND bizim_cekid='$id'");
        if ($bilgiler > 0) {
            foreach ($bilgiler as $item) {
                $tanimlicek = $item["tanimli_cekid"];
                if ($tanimlicek == 0) {
                } else {
                    $arr = [
                        'status' => 1
                    ];
                    $tanimlanan_cekler = DB::update("tanimlanan_cekler", "id", $tanimlicek, $arr);
                }
            }
            if ($tanimlanan_cekler) {
                echo 1;
            } else {
                echo 2;
            }
        } else {
            echo 1;
        }
    } else {
        echo 500;
    }
}
if ($islem == "kendi_cekimiz_sil_sql") {
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["status"] = 0;
    $vazgec = DB::update("bizim_cek_cikis", "id", $_POST["id"], $_POST);
    if ($vazgec) {
        $id = $_POST["id"];
        $bilgiler = DB::all_data("SELECT * FROM bizim_cek_urunler WHERE status=1 AND bizim_cekid='$id'");
        if ($bilgiler > 0) {
            foreach ($bilgiler as $item) {
                $tanimlicek = $item["tanimli_cekid"];
                if ($tanimlicek == 0) {
                } else {
                    $arr = [
                        'status' => 1
                    ];
                    $tanimlanan_cekler = DB::update("tanimlanan_cekler", "id", $tanimlicek, $arr);
                }
            }
            echo 1;
        } else {
            echo 1;
        }
    } else {
        echo 500;
    }
}
if ($islem == "cek_girislerini_getir_sql") {
    $alinan_cekid = DB::all_data("
SELECT
       acu.*
FROM 
     alinan_cek_urunler as acu
INNER JOIN alinan_cek_giris as acg on acg.id=acu.alinan_cekid
WHERE
      acu.status=1 AND acu.cari_key='$cari_key' AND acg.status=1 AND acu.bizim!=1");
    if ($alinan_cekid > 0) {
        echo json_encode($alinan_cekid);
    } else {
        echo 2;
    }
}
if ($islem == "kasa_kodu_bilgileri_getir") {
    $kasa_kodu = $_GET["banka_kodu"];
    $kasa_bilgileri = DB::single_query("SELECT * FROM kasa WHERE status=1 AND cari_key='$cari_key' AND kasa_kodu='$kasa_kodu'");
    if ($kasa_bilgileri > 0) {
        echo json_encode($kasa_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "bize_ait_cekleri_getir") {
    $banka_id = $_GET["banka_id"];
    $cekler = DB::all_data("
SELECT 
       tc.*,
       cst.cek_baslangic_no,
       b.banka_adi
FROM 
     tanimlanan_cekler as tc
INNER JOIN cek_stok_tanim as cst on cst.id=tc.cek_stokid
INNER JOIN banka as b on tc.banka_id=b.id
WHERE tc.status=1 AND tc.cari_key='$cari_key' AND tc.banka_id='$banka_id'");
    if ($cekler > 0) {
        echo json_encode($cekler);
    } else {
        echo 2;
    }
}
if ($islem == "verilen_cek_acilis_kaydet_sql") {
    $_POST["insert_datetime"] = date("Y-m-d");
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;

    $cek_acilis_fisi_kaydet = DB::insert("kendi_cek_acilis", $_POST);
    if ($cek_acilis_fisi_kaydet) {
        echo 500;
    } else {
        $ilkTarih = new DateTime($_POST["acilis_tarihi"]);

        $ikinciTarih = new DateTime($_POST["vade_tarihi"]);

        $fark = $ilkTarih->diff($ikinciTarih);

        $farkGun = $fark->days;
        $arr1 = [
            'tarih' => $_POST["acilis_tarihi"],
            'doviz_kuru' => "1",
            'doviz_turu' => 'TL',
            'cari_id' => $_POST["cari_id"],
            'ort_vade' => $_POST["vade_tarihi"],
            'ort_gun' => $farkGun,
            'aciklama' => $_POST["aciklama"],
            'insert_userid' => $_SESSION["user_id"],
            'insert_datetime' => date("Y-m-d H:i:s"),
            'cari_key' => $cari_key,
            'sube_key' => $sube_key,
            'acilis_mi' => 2,
            'islem' => 'kendi_cekimiz'
        ];
        $bizim_cek_olustur = DB::insert("bizim_cek_cikis", $arr1);
        if ($bizim_cek_olustur) {
            echo 500;
        } else {
            $son_eklenen = DB::single_query("SELECT id FROM bizim_cek_cikis where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
            $arr = [
                'bizim_cekid' => $son_eklenen["id"],
                'seri_no' => $_POST["seri_no"],
                'vade_tarih' => $_POST["vade_tarihi"],
                'tutar' => $_POST["tutar"],
                'keside_yeri' => $_POST["keside_yeri"],
                'banka_id' => $_POST["banka_id"],
                'insert_userid' => $_SESSION["user_id"],
                'insert_datetime' => date("Y-m-d H:i:s"),
                'cari_key' => $cari_key,
                'sube_key' => $sube_key,
                'aciklama' => $_POST["aciklama"]
            ];
            $bizim_cek_urun_ekle = DB::insert("bizim_cek_urunler", $arr);
            if ($bizim_cek_urun_ekle) {
                echo 500;
            } else {
                echo 1;
            }

        }
    }
}
if ($islem == "acilis_ceklerini_getir_sql") {
    $merge_arr = [];
    $cekler = DB::all_data("
SELECT
       kca.*,
       b.banka_adi as kendi_banka
FROM
     kendi_cek_acilis as kca
INNER JOIN banka as b on b.id=kca.banka_id
WHERE kca.status=1 AND kca.cari_key='$cari_key'");

    $alinan_cekler = DB::all_data("SELECT * FROM alinan_cek_acilisi WHERE status=1 AND cari_key='$cari_key'");

    if (!empty($alinan_cekler)) {
        $merge_arr = array_merge($alinan_cekler, $merge_arr);
    }
    if (!empty($cekler)) {
        $merge_arr = array_merge($cekler, $merge_arr);
    }

    if ($merge_arr > 0) {
        echo json_encode($merge_arr);
    } else {
        echo 2;
    }
}
if ($islem == "alinan_cek_acilis_kaydet_sql") {
    $_POST["insert_datetime"] = date("Y-m-d");
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;

    $cek_acilis_fisi_kaydet = DB::insert("alinan_cek_acilisi", $_POST);
    if ($cek_acilis_fisi_kaydet) {
        echo 500;
    } else {
        $ilkTarih = new DateTime($_POST["acilis_tarihi"]);

        $ikinciTarih = new DateTime($_POST["vade_tarihi"]);

        $fark = $ilkTarih->diff($ikinciTarih);

        $farkGun = $fark->days;

        $arr2 = [
            'tarih' => $_POST["acilis_tarihi"],
            'ort_vade' => $_POST["vade_tarihi"],
            'ort_gun' => $farkGun,
            'aciklama' => $_POST["aciklama"],
            'insert_userid' => $_SESSION["user_id"],
            'insert_datetime' => date("Y-m-d H:i:s"),
            'cari_key' => $cari_key,
            'cari_id' => $_POST["cari_id"],
            'acilis_mi' => 2,
            'sube_key' => $sube_key
        ];
        $alinan_cek_cikis = DB::insert("alinan_cek_giris", $arr2);
        if ($alinan_cek_cikis) {
            echo 500;
        } else {
            $son_eklenen = DB::single_query("SELECT id FROM alinan_cek_giris where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
            $arr = [
                'alinan_cekid' => $son_eklenen["id"],
                'seri_no' => $_POST["seri_no"],
                'asil_borclu' => $_POST["asil_borclu"],
                'ciro_edilmis' => $_POST["ciro_edilmis"],
                'keside_yeri' => $_POST["keside_yeri"],
                'banka_adi' => $_POST["banka_adi"],
                'girilen_tutar' => $_POST["tutar"],
                'vade_tarih' => $_POST["vade_tarihi"],
                'bizim' => '2',
                'cari_key' => $cari_key,
                'sube_key' => $sube_key,
                'son_durum' => '1'
            ];
            $alinan_cek_urun_ekle = DB::insert("alinan_cek_urunler", $arr);
            if ($alinan_cek_urun_ekle) {
                echo 500;
            } else {
                echo 1;
            }
        }
    }
}
if ($islem == "verilen_cek_sil_sql") {
    $_POST["status"] = 0;
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $sil = DB::update("kendi_cek_acilis", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "alinan_cek_sil_sql") {
    $_POST["status"] = 0;
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $sil = DB::update("alinan_cek_acilisi", "id", $_POST["id"], $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "verilen_cek_raporlari_sql") {

    $sql = "
SELECT
       bcu.*,
       bcc.status as main_status,
       bcu.status as second_status,
       bcc.tarih,
       b.banka_adi,
       b.sube_adi,
       c.cari_adi
FROM
     bizim_cek_cikis as bcc
INNER JOIN bizim_cek_urunler AS bcu on bcu.bizim_cekid=bcc.id
INNER JOIN banka as b on b.id=bcu.banka_id
LEFT JOIN cari as c on c.id=bcc.cari_id
WHERE
      bcc.status!=0
  AND 
      bcu.status!=0
  AND
      bcc.cari_key='$cari_key'";

    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        if ($bas_tarih != "" && $bit_tarih != "") {
            $sql .= " AND bcc.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
        }
    }

    if (isset($_GET["cari_adi"])) {
        $cari_adi = $_GET["cari_adi"];
        if ($cari_adi != "") {
            $sql .= " AND c.cari_adi LIKE '%$cari_adi%'";
        }
    }

    $verilen_cekler = DB::all_data($sql);

    $sql2 = "SELECT
       acc.*,
       acc.status as main_status,
       ccu.status as second_status,
       acc.ozel_kod1 as ozel_kod,
       ccu.vade_tarih,
       ccu.keside_yeri,
       ccu.girilen_tutar as tutar,
       ccu.seri_no
FROM
     alinan_cek_cikis as acc
INNER JOIN cikis_cek_urunler as ccu on ccu.cikis_cekid=acc.id
LEFT JOIN cari as c on c.id=acc.cari_id
WHERE
      acc.status!=0 
  AND 
      acc.cari_id!=0 
  AND 
        ccu.status!=0";

    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        if ($bas_tarih != "" && $bit_tarih != "") {
            $sql2 .= " AND acc.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
        }
    }

    if (isset($_GET["cari_adi"])) {
        $cari_adi = $_GET["cari_adi"];
        if ($cari_adi != "") {
            $sql2 .= " AND c.cari_adi LIKE '%$cari_adi%'";
        }
    }

    $ciro_edilen_cekler = DB::all_data($sql2);

    $merge_arr = [];
    if (!empty($verilen_cekler)) {
        $merge_arr = array_merge($merge_arr, $verilen_cekler);
    }
    if (!empty($ciro_edilen_cekler)) {
        $merge_arr = array_merge($merge_arr, $ciro_edilen_cekler);
    }

    $donecek_arr = [];
    $toplam = 0;
    $odenmemis_tutar = 0;
    foreach ($merge_arr as $item) {
        $tarih = date("d/m/Y", strtotime($item["tarih"]));
        $vade_tarih = date("d/m/Y", strtotime($item["vade_tarih"]));

        $banka_adi = "";
        $sube_adi = "";
        $geldigi_yer = 1;

        if (isset($item["banka_adi"])) {
            $banka_adi = $item["banka_adi"];
            $sube_adi = $item["sube_adi"];
            $geldigi_yer = 0;
        }
        $son_durum = "";

        if ($item["second_status"] == 1) {
            $son_durum = "Ciro Edildi";
            $odenmemis_tutar += $item["tutar"];
        } else {
            $son_durum = "Ödendi";
        }

        // EĞER GELDİĞİ YER BORÇ KARŞILIĞI VERİLEN ÇEKLER İSE DURUM 1 DEĞİL İSE DURUM 0


        $toplam += $item["tutar"];
        $tutar = number_format($item["tutar"], 2);

        $arr = [
            'tarih' => $tarih,
            'vade_tarih' => $vade_tarih,
            'tutar' => $tutar,
            'keside_yeri' => $item["keside_yeri"],
            'banka_adi' => $banka_adi,
            'sube_adi' => $sube_adi,
            'seri_no' => $item["seri_no"],
            'aciklama' => $item["aciklama"],
            'ozel_kod' => $item["ozel_kod"],
            'son_durum' => $son_durum,
            'geldigi_yer' => $geldigi_yer,
            'id' => $item["id"]
        ];
        array_push($donecek_arr, $arr);
    }

    if (!empty($donecek_arr)) {
        $odenmemis_tutar = number_format($odenmemis_tutar, 2);
        $toplam = number_format($toplam, 2);
        $donecek_arr[0]["toplam_tutar"] = $toplam;
        $donecek_arr[0]["odenmemis_tutar"] = $odenmemis_tutar;
        echo json_encode($donecek_arr);
    } else {
        echo 2;
    }
}
if ($islem == "odenecek_cek_ve_senetler") {

    $sql = "
        
SELECT
       bcu.*,
       bcc.status as main_status,
       bcu.status as second_status,
       bcc.tarih,
       b.banka_adi,
       b.sube_adi
FROM
     bizim_cek_cikis as bcc
INNER JOIN bizim_cek_urunler AS bcu on bcu.bizim_cekid=bcc.id
INNER JOIN banka as b on b.id=bcu.banka_id
INNER JOIN cari as c on c.id=bcc.cari_id
WHERE
      bcc.status!=0
  AND 
      bcu.status!=0
  AND
      bcc.cari_key='$cari_key'
";
    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        if ($bas_tarih != "" && $bit_tarih != "") {
            $sql .= " AND bcc.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
        }
    }

    if (isset($_GET["cari_adi"])) {
        $cari_adi = $_GET["cari_adi"];
        if ($cari_adi != "") {
            $sql .= " AND c.cari_adi LIKE '%$cari_adi%'";
        }
    }

    $verilen_cekler = DB::all_data($sql);

    $sql2 = "
SELECT
       acc.*,
       acc.status as main_status,
       ccu.status as second_status,
       acc.ozel_kod1 as ozel_kod,
       ccu.vade_tarih,
       ccu.keside_yeri,
       ccu.girilen_tutar as tutar,
       ccu.seri_no
FROM
     alinan_cek_cikis as acc
INNER JOIN cikis_cek_urunler as ccu on ccu.cikis_cekid=acc.id
LEFT JOIN cari as c on c.id=acc.cari_id
WHERE
      acc.status!=0 
  AND 
      acc.cari_id!=0 
  AND 
        ccu.status!=0";


    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        if ($bas_tarih != "" && $bit_tarih != "") {
            $sql2 .= " AND acc.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
        }
    }

    if (isset($_GET["cari_adi"])) {
        $cari_adi = $_GET["cari_adi"];
        if ($cari_adi != "") {
            $sql2 .= " AND c.cari_adi LIKE '%$cari_adi%'";
        }
    }

    $ciro_edilen_cekler = DB::all_data($sql2);

    $merge_arr = [];
    if (!empty($verilen_cekler)) {
        $merge_arr = array_merge($merge_arr, $verilen_cekler);
    }
    if (!empty($ciro_edilen_cekler)) {
        $merge_arr = array_merge($merge_arr, $ciro_edilen_cekler);
    }

    $donecek_arr = [];
    $toplam = 0;
    $odenmemis_tutar = 0;
    foreach ($merge_arr as $item) {
        $tarih = date("d/m/Y", strtotime($item["tarih"]));
        $vade_tarih = date("d/m/Y", strtotime($item["vade_tarih"]));

        $banka_adi = "";
        $sube_adi = "";
        $geldigi_yer = 1;

        if (isset($item["banka_adi"])) {
            $banka_adi = $item["banka_adi"];
            $sube_adi = $item["sube_adi"];
            $geldigi_yer = 0;
        }
        $son_durum = "";

        if ($item["second_status"] == 1) {
            $son_durum = "Ciro Edildi";
            $odenmemis_tutar += $item["tutar"];
        } else {
            $son_durum = "Ödendi";
        }

        // EĞER GELDİĞİ YER BORÇ KARŞILIĞI VERİLEN ÇEKLER İSE DURUM 1 DEĞİL İSE DURUM 0


        $toplam += $item["tutar"];
        $tutar = number_format($item["tutar"], 2);
        if ($son_durum != "Ödendi") {
            $arr = [
                'tarih' => $tarih,
                'vade_tarih' => $vade_tarih,
                'tutar' => $tutar,
                'keside_yeri' => $item["keside_yeri"],
                'banka_adi' => $banka_adi,
                'sube_adi' => $sube_adi,
                'seri_no' => $item["seri_no"],
                'aciklama' => $item["aciklama"],
                'ozel_kod' => $item["ozel_kod"],
                'son_durum' => $son_durum,
                'geldigi_yer' => $geldigi_yer,
                'id' => $item["id"]
            ];
            array_push($donecek_arr, $arr);
        }
    }

    if (!empty($donecek_arr)) {
        $odenmemis_tutar = number_format($odenmemis_tutar, 2);
        $toplam = number_format($toplam, 2);
        $donecek_arr[0]["toplam_tutar"] = $toplam;
        $donecek_arr[0]["odenmemis_tutar"] = $odenmemis_tutar;
        echo json_encode($donecek_arr);
    } else {
        echo 2;
    }
}
if ($islem == "bizim_verdigimiz_cek_detayi_sql") {
    $id = $_GET["id"];
    $first_arr = [];
//    $verdigimiz_cek_bilgisi = DB::single_query("
//SELECT
//       bcu.*,
//       bcu.status as cek_verildi,
//       bcu.seri_no as bordro_no,
//       bcc.tarih,
//       bcc.doviz_kuru,
//       bcc.doviz_turu,
//       b.banka_adi,
//       b.sube_adi,
//       c.cari_adi
//FROM
//     bizim_cek_cikis as bcc
//INNER JOIN bizim_cek_urunler AS bcu on bcu.bizim_cekid=bcc.id
//INNER JOIN banka as b on b.id=bcu.banka_id
//INNER JOIN cari as c on c.id=bcc.cari_id
//WHERE
//      bcc.status!=0
//  AND
//      bcu.status!=0
//  AND
//      bcc.cari_key='$cari_key' AND bcu.id='$id'");
//    array_push($first_arr, $verdigimiz_cek_bilgisi);
    $bizim_cek_cikis = DB::single_query("
SELECT
       bcc.*,
       bcu.status as cek_verildi,
       bcu.tutar,
       b.banka_adi,
       c.cari_adi
FROM
     bizim_cek_cikis as bcc
INNER JOIN bizim_cek_urunler as bcu on bcu.bizim_cekid=bcc.id
INNER JOIN banka as b on b.id=bcu.banka_id
LEFT JOIN cari as c on c.id=bcc.cari_id
WHERE
      bcc.status!=0 AND bcu.id='$id' ");
    array_push($first_arr, $bizim_cek_cikis);

    $odeme_bilgisi = DB::single_query("
SELECT
       cso.*,
       cso.status as cek_odendi,
       csou.seri_no as bordro_no,
       csou.tutar,
       cso.doviz_tur as doviz_turu,
       c.cari_adi,
       b.banka_adi,
       bcc.doviz_kuru
FROM
     cek_senet_odeme as cso
INNER JOIN cek_senet_odeme_urunler as csou
LEFT JOIN cari as c on c.id=csou.cari_id
INNER JOIN bizim_cek_urunler as bcu on bcu.id=csou.cek_id
INNER JOIN bizim_cek_cikis as bcc on bcc.id=bcu.bizim_cekid
LEFT JOIN banka as b on b.id=csou.banka_id
WHERE cso.status=1 AND csou.status=1 AND cso.cari_key='$cari_key' AND bcu.id='$id'
     ");
    if ($odeme_bilgisi > 0) {
        array_push($first_arr, $odeme_bilgisi);
    }
    $donecek_arr = [];
    foreach ($first_arr as $item) {
        $doviz_tutari = $item["doviz_kuru"] * $item["tutar"];
        $tarih = date("d/m/Y", strtotime($item["tarih"]));
        $tutar = number_format($item["tutar"], 2);
        $doviz_kuru = number_format($item["doviz_kuru"], 2);
        $doviz_tutari = number_format($doviz_tutari, 2);
        $durum = "";
        if (isset($item["cek_verildi"])) {
            $durum = "CİRO EDİLDİ";
        } else {
            $durum = "ÖDENDİ";
        }

        $arr = [
            'tarih' => $tarih,
            'bordro_no' => $item["bordro_no"],
            'cari_adi' => $item["cari_adi"],
            'banka_adi' => $item["banka_adi"],
            'tutar' => $tutar,
            'doviz_turu' => $item["doviz_turu"],
            'doviz_kuru' => $doviz_kuru,
            'doviz_tutar' => $doviz_tutari,
            'durum' => $durum,
            'status' => $item["status"]
        ];
        array_push($donecek_arr, $arr);
    }
    usort($donecek_arr, function ($a, $b) {
        $tarihA = strtotime($a['tarih']); // $a dizisindeki tarih değerini alıp zaman damgasına dönüştür
        $tarihB = strtotime($b['tarih']);
        if ($tarihA == $tarihB) {
            return 0;
        }

        return ($tarihA < $tarihB) ? -1 : 1;
    });

    if (!empty($donecek_arr)) {
        echo json_encode($donecek_arr);
    } else {
        echo 2;
    }
}
if ($islem == "ciro_verdigimiz_cek_detayi_sql") {
    $id = $_GET["id"];
    $first_arr = [];
    $cek_girisi = DB::single_query("
SELECT
       acg.*,
       acg.status as giris_status,
       acu.banka_adi,
       acu.seri_no as bordro_no,
       acu.girilen_tutar as tutar,
       c.cari_adi
FROM
     alinan_cek_giris as acg 
INNER JOIN alinan_cek_urunler as acu on acu.alinan_cekid=acg.id
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN cikis_cek_urunler as ccu on ccu.alinan_cekid=acu.id
WHERE ccu.id='$id' AND ccu.status!=0
     ");
    array_push($first_arr, $cek_girisi);
    $ciro_edilen_cekler = DB::single_query("
SELECT
       acc.*,
       acc.status as cikis_status,
       ccu.status as second_status,
       acc.ozel_kod1 as ozel_kod,
       ccu.vade_tarih,
       ccu.keside_yeri,
       ccu.girilen_tutar as tutar,
       ccu.seri_no as bordro_no,
       c.cari_adi
FROM
     alinan_cek_cikis as acc
INNER JOIN cikis_cek_urunler as ccu on ccu.cikis_cekid=acc.id
INNER JOIN cari as c on c.id=acc.cari_id
WHERE
   ccu.id='$id' AND ccu.status!=0");
    array_push($first_arr, $ciro_edilen_cekler);


    $odeme_bilgisi = DB::single_query("
SELECT
       cso.*,
       cso.status as odeme_status,
       csou.seri_no as bordro_no,
       csou.tutar,
       cso.doviz_tur as doviz_turu,
       c.cari_adi,
       b.banka_adi,
       bcc.doviz_kuru
FROM
     cek_senet_odeme as cso
INNER JOIN cek_senet_odeme_urunler as csou on csou.odeme_id=cso.id
INNER JOIN cari as c on c.id=csou.cari_id
INNER JOIN cikis_cek_urunler as bcu on bcu.id=csou.cek_id
INNER JOIN alinan_cek_cikis as bcc on bcc.id=bcu.alinan_cekid
LEFT JOIN banka as b on b.id=csou.banka_id
WHERE cso.status=1 AND csou.status=1 AND bcu.id='$id' AND csou.asil_borclu!='BİZ'
     ");
    if ($odeme_bilgisi > 0) {
        array_push($first_arr, $odeme_bilgisi);
    }
    $donecek_arr = [];
    foreach ($first_arr as $item) {
        $doviz_tutari = $item["doviz_kuru"] * $item["tutar"];
        $tarih = date("d/m/Y", strtotime($item["tarih"]));
        $tutar = number_format($item["tutar"], 2);
        $doviz_kuru = number_format($item["doviz_kuru"], 2);
        $doviz_tutari = number_format($doviz_tutari, 2);

        $durum = "";
        if (isset($item["giris_status"])) {
            $durum = "ÇEK ALINDI";
        } else if (isset($item["cikis_status"])) {
            $durum = "CİRO EDİLDİ";
        } else {
            $durum = "ÖDENDİ";
        }

        $arr = [
            'tarih' => $tarih,
            'bordro_no' => $item["bordro_no"],
            'cari_adi' => $item["cari_adi"],
            'banka_adi' => $item["banka_adi"],
            'tutar' => $tutar,
            'doviz_turu' => $item["doviz_turu"],
            'doviz_kuru' => $doviz_kuru,
            'doviz_tutar' => $doviz_tutari,
            'durum' => $durum
        ];
        array_push($donecek_arr, $arr);
    }
    usort($donecek_arr, function ($a, $b) {
        $tarihA = strtotime($a['tarih']); // $a dizisindeki tarih değerini alıp zaman damgasına dönüştür
        $tarihB = strtotime($b['tarih']);
        if ($tarihA == $tarihB) {
            return 0;
        }

        return ($tarihA < $tarihB) ? -1 : 1;
    });

    if (!empty($donecek_arr)) {
        echo json_encode($donecek_arr);
    } else {
        echo 2;
    }

}
if ($islem == "alinan_cek_raporlari_sql") {

    $first_arr = [];

    $sql = "SELECT
       acg.tarih,
       acu.vade_tarih,
       acu.keside_yeri,
       acu.girilen_tutar as tutar,
       acu.banka_adi,
       acu.banka_sube,
       acu.seri_no,
       acg.aciklama,
       acu.ozel_kod,
       acu.id
FROM
     alinan_cek_giris as acg
INNER JOIN alinan_cek_urunler AS acu on acu.alinan_cekid=acg.id
LEFT JOIN cari as c on c.id=acg.cari_id
WHERE acg.status!=0 AND acu.status!=0 AND acg.cari_key='$cari_key'
";
    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        if ($bas_tarih != "" && $bit_tarih != "") {
            $sql .= " AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
        }
    }

    if (isset($_GET["cari_adi"])) {
        $cari_adi = $_GET["cari_adi"];
        if ($cari_adi != "") {
            $sql .= " AND c.cari_adi LIKE '%$cari_adi%'";
        }
    }

    $alinan_cekler = DB::all_data($sql);
    $toplam = 0;
    foreach ($alinan_cekler as $item) {
        $son_durum = "";
        if ($item["status"] == 1) {
            $son_durum = "Çek Alındı";
        } else {
            $son_durum = "Ciro Edildi";
        }
        $toplam += $item["tutar"];
        $tarih = date("d/m/Y", strtotime($item["tarih"]));
        $vade_tarih = date("d/m/Y", strtotime($item["vade_tarih"]));
        $tutar = number_format($item["tutar"], 2);
        $arr = [
            'tarih' => $tarih,
            'vade_tarih' => $vade_tarih,
            'keside_yeri' => $item["keside_yeri"],
            'tutar' => $tutar,
            'banka_adi' => $item["banka_adi"],
            'sube_adi' => $item["sube_adi"],
            'seri_no' => $item["seri_no"],
            'aciklama' => $item["aciklama"],
            'ozel_kod' => $item["ozel_kod"],
            'son_durum' => $son_durum,
            'id' => $item["id"]
        ];
        $first_arr[0]["toplam_tutar"] = $toplam;
        array_push($first_arr, $arr);
    }
    $toplam = number_format($toplam, 2);
    if (!empty($first_arr)) {
        echo json_encode($first_arr);
    } else {
        echo 2;
    }
}
if ($islem == "aldigimiz_cek_senet_detayini_getir_sql") {
    $id = $_GET["id"];

    $first_arr = [];
    $cek_girisi = DB::single_query("
SELECT
       acg.*,
       acg.status as giris_status,
       acu.banka_adi,
       acu.seri_no as bordro_no,
       acu.girilen_tutar as tutar,
       c.cari_adi
FROM
     alinan_cek_giris as acg 
INNER JOIN alinan_cek_urunler as acu on acu.alinan_cekid=acg.id
INNER JOIN cari as c on c.id=acg.cari_id
WHERE acu.id='$id'
     ");
    array_push($first_arr, $cek_girisi);

    $ciro_edilen_cekler = DB::single_query("
SELECT
       acc.*,
       acc.status as cikis_status,
       ccu.status as second_status,
       acc.ozel_kod1 as ozel_kod,
       ccu.vade_tarih,
       ccu.keside_yeri,
       ccu.girilen_tutar as tutar,
       ccu.seri_no as bordro_no,
       c.cari_adi,
       ccu.ciro_edilmis
FROM
     alinan_cek_cikis as acc
INNER JOIN cikis_cek_urunler as ccu on ccu.cikis_cekid=acc.id
LEFT JOIN cari as c on c.id=acc.cari_id
WHERE ccu.alinan_cekid='$id' AND ccu.status!=0");
    if ($ciro_edilen_cekler > 0) {
        array_push($first_arr, $ciro_edilen_cekler);
    }

    $tahsilati = DB::single_query("
SELECT
       tecs.*,
       tecs.doviz_tur as doviz_turu,
       tecs.doviz_kur as doviz_kuru,
       tecu.seri_no as bordro_no,
       tecu.ciro_edilmis as cari_adi,
       b.banka_adi,
       tecu.tutar
FROM
     tahsil_edilen_cek_senet as tecs
INNER JOIN tahsil_edilen_cek_urunler as tecu
INNER JOIN cikis_cek_urunler as ccu on ccu.id=tecu.cek_id
INNER JOIN banka as b on b.id=tecu.banka_id
WHERE tecs.status=1 AND tecu.status=1 AND ccu.alinan_cekid='$id'
     ");
    if ($tahsilati > 0) {
        array_push($first_arr, $tahsilati);
    }

    $donecek_arr = [];
    foreach ($first_arr as $item) {
        $doviz_tutari = $item["doviz_kuru"] * $item["tutar"];
        $tarih = date("d/m/Y", strtotime($item["tarih"]));
        $tutar = number_format($item["tutar"], 2);
        $doviz_kuru = number_format($item["doviz_kuru"], 2);
        $doviz_tutari = number_format($doviz_tutari, 2);

        $durum = "";
        if (isset($item["giris_status"])) {
            $durum = "ÇEK ALINDI";
        } else if (isset($item["cikis_status"])) {
            $durum = "CİRO EDİLDİ";
        } else {
            $durum = "TAHSİL EDİLDİ";
        }
        $cari_adi = $item["cari_adi"];
        if ($item["cari_adi"] == "") {
            $cari_adi = $item["ciro_edilmis"];
        }

        $arr = [
            'tarih' => $tarih,
            'bordro_no' => $item["bordro_no"],
            'cari_adi' => $cari_adi,
            'banka_adi' => $item["banka_adi"],
            'tutar' => $tutar,
            'doviz_turu' => $item["doviz_turu"],
            'doviz_kuru' => $doviz_kuru,
            'doviz_tutar' => $doviz_tutari,
            'durum' => $durum
        ];
        array_push($donecek_arr, $arr);
    }
    usort($donecek_arr, function ($a, $b) {
        $tarihA = strtotime($a['tarih']); // $a dizisindeki tarih değerini alıp zaman damgasına dönüştür
        $tarihB = strtotime($b['tarih']);
        if ($tarihA == $tarihB) {
            return 0;
        }
        return ($tarihA < $tarihB) ? -1 : 1;
    });

    if (!empty($donecek_arr)) {
        echo json_encode($donecek_arr);
    } else {
        echo 2;
    }
}
if ($islem == "karsiliksiz_cek_ve_senetler") {

    $sql = "SELECT 
       kcs.insert_datetime as karsiliksiz_tarih,
       kcs.id,
       ccu.seri_no,
       c.cari_adi,
       c.yetkili_adi1,
       ccu.girilen_tutar,
       ccu.vade_tarih,
       ccu.banka_adi,
       ccu.ciro_edilmis
FROM 
     karsiliksiz_cek_senet as kcs
INNER JOIN cikis_cek_urunler AS ccu ON ccu.id=kcs.alinan_cekid
INNER JOIN alinan_cek_cikis AS acc ON acc.id=ccu.cikis_cekid
INNER JOIN cari AS c on c.id=acc.cari_id
WHERE kcs.status=1 AND kcs.cari_key='$cari_key'";

    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        if ($bas_tarih != "" && $bit_tarih != "") {
            $sql .= " AND kcs.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
        }
    }

    if (isset($_GET["cari_adi"])) {
        $cari_adi = $_GET["cari_adi"];
        if ($cari_adi != "") {
            $sql .= " AND ccu.ciro_edilmis LIKE '%$cari_adi%'";
        }
    }

    $karsiliksiz_cek_ve_senetler = DB::all_data($sql);

    if ($karsiliksiz_cek_ve_senetler > 0) {
        $gidecek_arr = [];
        $toplam = 0;
        foreach ($karsiliksiz_cek_ve_senetler as $item) {
            $arr = [
                'tarih' => $item["karsiliksiz_tarih"],
                'vade_tarihi' => $item["vade_tarih"],
                'cari_adi' => $item["ciro_edilmis"],
                'banka_adi' => $item["banka_adi"],
                'tutar' => number_format($item["girilen_tutar"], 2),
                'cek_no' => $item["seri_no"]
            ];
            $toplam += $item["girilen_tutar"];
            array_push($gidecek_arr, $arr);
        }
        if (!empty($gidecek_arr)) {
            $gidecek_arr[0]["toplam_tutar"] = number_format($toplam, 2);
            echo json_encode($gidecek_arr);
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}