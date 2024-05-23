<?php
include '../DB.php';
date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=UTF-8');
session_start();
DB::connect();
$islem = $_GET["islem"];
$cari_key = $_SESSION["cari_key"];
$sube_key = $_SESSION["sube_key"];

if ($islem == "yeni_alinan_senet_girisi_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    if ($_POST["alinan_senetid"] == "") {
        $arr = [
            "cari_id" => $_POST["cari_id"],
            "insert_userid" => $_SESSION["user_id"],
            "insert_datetime" => date("Y-m-d H:i:s"),
            'cari_key' => $_SESSION["cari_key"],
            'sube_key' => $_SESSION["sube_key"]
        ];
        $yeni_senet_giris_olustur = DB::insert("alinan_senet_giris", $arr);
        if ($yeni_senet_giris_olustur) {
            echo 500;
        } else {
            $son_eklenen = DB::single_query("SELECT id FROM alinan_senet_giris where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
            if ($son_eklenen > 0) {
                $_POST["alinan_senetid"] = $son_eklenen["id"];
                unset($_POST["cari_id"]);
                $_POST["cari_key"] = $_SESSION["cari_key"];
                $_POST["sube_key"] = $_SESSION["sube_key"];
                $_POST["son_durum"] = 1;
                $_POST["bizim"] = 2;
                $senet_urunu_olustur = DB::insert("alinan_senet_urunler", $_POST);
                if ($senet_urunu_olustur) {
                    echo 500;
                } else {
                    $senet_id = $son_eklenen["id"];
                    $datalari_getir = DB::all_data("SELECT * FROM alinan_senet_urunler WHERE status=1 AND cari_key='$cari_key' AND alinan_senetid='$senet_id'");
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
        $yeni_senet_giris_olustur = DB::update("alinan_senet_giris", "id", $_POST["alinan_senetid"], $arr);
        if ($yeni_senet_giris_olustur) {
            unset($_POST["cari_id"]);
            $_POST["cari_key"] = $_SESSION["cari_key"];
            $_POST["sube_key"] = $_SESSION["sube_key"];
            $_POST["son_durum"] = 1;
            $_POST["bizim"] = 2;
            $senet_urunu_olustur = DB::insert("alinan_senet_urunler", $_POST);
            if ($senet_urunu_olustur) {
                echo 500;
            } else {
                $senet_id = $_POST["alinan_senetid"];
                $datalari_getir = DB::all_data("SELECT * FROM alinan_senet_urunler WHERE status=1 AND cari_key='$cari_key' AND alinan_senetid='$senet_id'");
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
if ($islem == "alinan_senet_onayla_sql") {
    $id = $_POST["senet_id"];
    unset($_POST["senet_id"]);
    $cek_guncelle = DB::update("alinan_senet_giris", "id", $id, $_POST);
    if ($cek_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "tum_cek_ve_senetleri_getir_sql") {
    $sql = "
SELECT
       csg.*,
       c.cari_adi,
       SUM(acu.girilen_tutar) as tutar
FROM 
     alinan_senet_giris as csg
INNER JOIN alinan_senet_urunler as acu on acu.alinan_senetid=csg.id
INNER JOIN cari as c on c.id=csg.cari_id
WHERE csg.status=1 AND csg.cari_key='$cari_key' AND acu.status=1";
    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        $sql .= " AND csg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
    }
    $sql .= " GROUP BY alinan_senetid";

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
    $cek_vazgec = DB::update("alinan_senet_giris", "id", $cek_id, $_POST);
    if ($cek_vazgec) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "cek_bilgileri_getir_sql") {
    $id = $_GET["id"];
    $datalari_getir = DB::single_query("SELECT * FROM alinan_senet_urunler WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
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
    $yeni_cek_giris_olustur = DB::update("alinan_senet_giris", "id", $_POST["alinan_senetid"], $arr);
    if ($yeni_cek_giris_olustur) {
        unset($_POST["cari_id"]);
        $_POST["cari_key"] = $_SESSION["cari_key"];
        $_POST["sube_key"] = $_SESSION["sube_key"];
        $_POST["son_durum"] = 1;
        $_POST["update_userid"] = $_SESSION["user_id"];
        $_POST["update_datetime"] = date("Y-m-d H:i:s");
        $_POST["bizim"] = 2;
        $cek_urunu_olustur = DB::update("alinan_senet_urunler", "id", $_POST["id"], $_POST);
        if ($cek_urunu_olustur) {
            $cek_id = $_POST["alinan_senetid"];
            $datalari_getir = DB::all_data("SELECT * FROM alinan_senet_urunler WHERE status=1 AND cari_key='$cari_key' AND alinan_senetid='$cek_id'");
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
if ($islem == "cek_senet_vazgec_sql") {
    if (isset($_POST["senet_id"])) {
        $cek_id = $_POST["senet_id"];
        unset($_POST["senet_id"]);
        $_POST["delete_detail"] = "Kullanıcı senet Girişi Oluşturmaktan Vazgeçmiştir";
        $_POST["delete_datetime"] = date("Y-m-d H:i:s");
        $_POST["delete_userid"] = $_SESSION["user_id"];
        $_POST["status"] = 0;
        $cek_vazgec = DB::update("alinan_senet_giris", "id", $cek_id, $_POST);
        if ($cek_vazgec) {
            echo 1;
        } else {
            echo 2;
        }
    } else {

    }
}
if ($islem == "senet_iptal_et_sql") {
    $id = $_POST["id"];
    $cek_id = $_POST["cek_id"];
    unset($_POST["cek_id"]);
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_detail"] = "Kullanıcı Çek Oluştururken Listeden Silmiştir";
    $_POST["status"] = 0;
    $cek_sil = DB::update("alinan_senet_urunler", "id", $id, $_POST);
    if ($cek_sil) {
        $datalari_getir = DB::all_data("SELECT * FROM alinan_senet_urunler WHERE status=1 AND cari_key='$cari_key' AND alinan_senetid='$cek_id'");
        if ($datalari_getir > 0) {
            echo json_encode($datalari_getir);
        } else {
            echo 2;
        }
    } else {
        echo 500;
    }
}
if ($islem == "girilen_senet_bilgileri_getir_sql") {
    $cek_id = $_GET["id"];
    $alinan_cekid = DB::all_data("SELECT * FROM alinan_senet_urunler WHERE status=1 AND cari_key='$cari_key' AND alinan_senetid='$cek_id'");
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
       cab.adres
FROM 
     alinan_senet_giris  as acg
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
if ($islem == "senetleri_cikis_icin_getir_sql") {
    $cari_id = $_GET["cari_id"];
    $alinan_cekid = DB::all_data("
SELECT
       acu.*
FROM 
     alinan_senet_urunler as acu
INNER JOIN alinan_senet_giris as acg on acg.id=acu.alinan_senetid
WHERE
      acu.status=1 AND acu.cari_key='$cari_key' AND acg.status=1 AND acg.cari_id='$cari_id' AND acu.bizim!=1");
    if ($alinan_cekid > 0) {
        echo json_encode($alinan_cekid);
    } else {
        echo 2;
    }
}
if ($islem == "senet_cikis_kaydet_sql") {
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
        'banka_id' => $_POST["banka_id"],
        'islem' => $_POST["arr"][0]["islem"],
        'sube_key' => $_SESSION["sube_key"]
    ];

    $yeni_cek_giris_olustur = DB::insert("alinan_senet_cikis", $arr);
    $ek_sorgu = "";
    if ($_SESSION["sube_key"] != 0) {
        $ek_sorgu = " AND sube_key='$sube_key'";
    }
    $son = DB::single_query("SELECT id FROM alinan_senet_cikis where cari_key='$cari_key' $ek_sorgu ORDER BY id DESC LIMIT 1");
    $id = $son["id"];
    if ($yeni_cek_giris_olustur) {
        echo 500;
    } else {
        foreach ($_POST["arr"] as $item) {
            unset($item["islem"]);
            $item["cikis_senetid"] = $id;
            $item["cari_key"] = $_SESSION["cari_key"];
            $item["sube_key"] = $_SESSION["sube_key"];
            $alinan_cekid = $item["alinan_senetid"];
            $urunleri_ekle = DB::insert("alinan_senet_cikis_urunler", $item);
            if ($urunleri_ekle) {
                echo 500;
            } else {
                $arr2 = [
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s"),
                    'status' => 2
                ];
                $alinan_cek_giris_guncelle = DB::update("alinan_senet_giris", "id", $alinan_cekid, $arr2);
            }
        }
        if ($alinan_cek_giris_guncelle) {
            echo 1;
        } else {
            echo 500;
        }

    }
}
if ($islem == "bankalari_getir_sql") {
    $bankalar = DB::all_data("SELECT * FROM banka WHERE status=1 AND cari_key='$cari_key'");
    if ($bankalar > 0) {
        echo json_encode($bankalar);
    } else {
        echo 2;
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
     alinan_senet_cikis as csg
INNER JOIN alinan_senet_cikis_urunler as acu on acu.cikis_senetid=csg.id
LEFT JOIN cari as c on c.id=csg.cari_id
LEFT JOIN banka as b on b.id=csg.banka_id
WHERE csg.status=1 AND csg.cari_key='$cari_key' AND acu.status=1 ";
    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        $sql .= " AND csg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
    }
    $sql .= " GROUP BY cikis_senetid";
    $cekler = DB::all_data($sql);

    $sql2 = "
SELECT
       csg.*,
       csg.doviz_turu as doviz_tur,
       c.cari_adi,
       SUM(acu.tutar) as tutar
FROM
     bizim_senet_cikis as csg
INNER JOIN bizim_senet_urunler as acu on acu.bizim_senetid=csg.id
INNER JOIN cari as c on c.id=csg.cari_id
WHERE csg.status=1 AND csg.cari_key='$cari_key' AND acu.status=1";
    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        $sql .= " AND csg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
    }
    $sql2 .= " GROUP BY bizim_senetid";
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
    $tum_cekler = DB::all_data("SELECT * FROM alinan_senet_cikis_urunler WHERE cikis_senetid='$cek_id'");
    if ($tum_cekler > 0) {
        foreach ($tum_cekler as $item) {
            $alinan_cekid = $item["alinan_senetid"];
            $arr = [
                'status' => 1
            ];
            $giris_cek_guncelle = DB::update("alinan_senet_giris", "id", $alinan_cekid, $arr);
        }
        if ($giris_cek_guncelle) {
            $cek_vazgec = DB::update("alinan_senet_cikis", "id", $cek_id, $_POST);
            if ($cek_vazgec) {
                echo 1;
            } else {
                echo 500;
            }
        } else {
            echo 2;
        }
    } else {
        $cek_vazgec = DB::update("alinan_senet_cikis", "id", $cek_id, $_POST);
        if ($cek_vazgec) {
            echo 1;
        } else {
            echo 2;
        }
    }
}
if ($islem == "bize_ait_cek_olustur_sql") {
    if (isset($_POST["bizim_senetid"])) {
        $bizim_senetid = $_POST["bizim_senetid"];
        unset($_POST["cari_id"]);
        $_POST["cari_key"] = $cari_key;
        $_POST["sube_key"] = $sube_key;
        $_POST["insert_userid"] = $_SESSION["user_id"];
        $_POST["insert_datetime"] = date("Y-m-d H:i:s");
        $urunu_ekle = DB::insert("bizim_senet_urunler", $_POST);
        if ($urunu_ekle) {
            echo 500;
        } else {
            $urunleri_getir = DB::all_data("
SELECT
       bcu.*,
       b.banka_adi,
       b.sube_adi,
       b.hesap_no
FROM 
     bizim_senet_urunler AS bcu
INNER JOIN banka as b on b.id=bcu.banka_id
WHERE bcu.status=1 AND bcu.bizim_senetid='$bizim_senetid' AND bcu.cari_key='$cari_key'");
            if ($urunleri_getir > 0) {
                echo json_encode($urunleri_getir);
            } else {
                echo 2;
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
        $bize_ait_senet_olustur = DB::insert("bizim_senet_cikis", $arr);
        if ($bize_ait_senet_olustur) {
            echo 500;
        } else {
            $son_eklenen = DB::single_query("SELECT id FROM bizim_senet_cikis where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
            $_POST["bizim_senetid"] = $son_eklenen["id"];
            unset($_POST["cari_id"]);
            $bizim_senetid = $son_eklenen["id"];
            $_POST["cari_key"] = $cari_key;
            $_POST["sube_key"] = $sube_key;
            $_POST["insert_userid"] = $_SESSION["user_id"];
            $_POST["insert_datetime"] = date("Y-m-d H:i:s");
            $yeni_urun_ekle = DB::insert("bizim_senet_urunler", $_POST);
            if ($yeni_urun_ekle) {
                echo 500;
            } else {
                $urunleri_getir = DB::all_data("
SELECT
       bcu.*,
       b.banka_adi,
       b.sube_adi,
       b.hesap_no
FROM 
     bizim_senet_urunler AS bcu
INNER JOIN banka as b on b.id=bcu.banka_id
WHERE bcu.status=1 AND bcu.bizim_senetid='$bizim_senetid' AND bcu.cari_key='$cari_key'");
                if ($urunleri_getir > 0) {
                    echo json_encode($urunleri_getir);
                } else {
                    echo 2;
                }
            }
        }
    }
}
if ($islem == "kendi_senetimizi_iptal_et_sql") {
    $id = $_POST["id"];
    $cek_bilgileri = DB::single_query("SELECT * FROM bizim_senet_urunler WHERE status=1 AND id='$id'");
    if ($cek_bilgileri > 0) {
        $arr = [
            'status' => 0,
            'delete_userid' => $_SESSION["user_id"],
            'delete_datetime' => date("Y-m-d H:i:s")
        ];
        $cek_sil = DB::update("bizim_senet_urunler", "id", $id, $arr);
        if ($cek_sil) {
            echo 1;
        } else {
            echo 500;
        }
    } else {
        echo 2;
    }
}
if ($islem == "kendi_cekimiz_vazgec_sql") {
    $_POST["delete_detail"] = "Kullanıcı Vazgeçti";
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["status"] = 0;
    $vazgec = DB::update("bizim_senet_cikis", "id", $_POST["id"], $_POST);
    if ($vazgec) {
        echo 1;
    } else {
        echo 500;
    }
}
if ($islem == "kendi_cekimizin_bilgilerini_guncelle") {
    $id = $_POST["id"];
    $_POST["islem"] = "kendi_cekimiz";
    $bizim_cekimizi_guncelle = DB::update("bizim_senet_cikis", "id", $id, $_POST);
    if ($bizim_cekimizi_guncelle) {
        echo 1;
    } else {
        echo 500;
    }
}
if ($islem == "kendi_cekimiz_sil_sql") {
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["status"] = 0;
    $vazgec = DB::update("bizim_senet_cikis", "id", $_POST["id"], $_POST);
    if ($vazgec) {
        echo 1;
    } else {
        echo 500;
    }
}
if ($islem == "bizim_senetleri_getir_sql") {
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
     bizim_senet_urunler as ccu
INNER JOIN bizim_senet_cikis AS acc on acc.id=ccu.bizim_senetid
INNER JOIN banka as b on b.id=ccu.banka_id
INNER JOIN cari as c on c.id=acc.cari_id
WHERE acc.status=1 AND ccu.status=1 AND acc.cari_key='$cari_key'");
    if ($tahsile_verilen_cekler > 0) {
        echo json_encode($tahsile_verilen_cekler);
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
    $ana_bilgileri_olustur = DB::insert("senet_odeme", $arr);
    if ($ana_bilgileri_olustur) {
        echo 500;
    } else {
        $son = DB::single_query("SELECT id FROM senet_odeme where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        foreach ($_POST["arr"] as $item) {
            $item["odeme_id"] = $son["id"];
            $item["cari_key"] = $_SESSION["cari_key"];
            $item["sube_key"] = $_SESSION["sube_key"];
            $urunleri_ekle = DB::insert("senet_odeme_urunler", $item);
            if ($urunleri_ekle) {

            } else {
                $cek_id = $item["cek_id"];
                $arr2 = [
                    'status' => 2,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $bizim_ceki_dusur = DB::update("bizim_senet_urunler", "id", $cek_id, $arr2);
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
     senet_odeme as csg
INNER JOIN senet_odeme_urunler as acu on acu.odeme_id=csg.id
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
    $urunlerini_getir = DB::all_data("SELECT * FROM senet_odeme_urunler WHERE status=1 AND cari_key='$cari_key' AND odeme_id='$id'");
    if ($urunlerini_getir > 0) {
        foreach ($urunlerini_getir as $item) {
            $cekid = $item["cek_id"];
            $arr = [
                'status' => 1
            ];
            $guncelle = DB::update("bizim_senet_urunler", "id", $cekid, $arr);
        }
        if ($guncelle) {
            $tahsil_sil = DB::update("senet_odeme", "id", $id, $_POST);
            if ($tahsil_sil) {
                echo 1;
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    } else {
        $tahsil_sil = DB::update("senet_odeme", "id", $id, $_POST);
        if ($tahsil_sil) {
            echo 1;
        } else {
            echo 2;
        }
    }
}
if ($islem == "tahsile_verilen_cek_senetleri_getir") {
    $tahsile_verilen_cekler = DB::all_data("
SELECT 
       ccu.*,
       b.banka_adi,
       b.sube_adi,
       b.hesap_no,
       b.id as banka_id
FROM 
     alinan_senet_cikis_urunler as ccu
INNER JOIN alinan_senet_cikis AS acc on acc.id=ccu.cikis_senetid
INNER JOIN banka as b on b.id=acc.banka_id
WHERE acc.islem='tahsile_verilmis_senet' AND acc.status=1 AND ccu.status=1 AND acc.cari_key='$cari_key'");
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

    $tahsil_edilen_cek_senet_kaydet = DB::insert("tahsil_edilen_senet", $cek_arr);
    if ($tahsil_edilen_cek_senet_kaydet) {
        echo 500;
    } else {
        $son = DB::single_query("SELECT id FROM tahsil_edilen_senet where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        foreach ($_POST["arr"] as $item) {
            $urun_arr = [
                'banka_id' => $item["banka_id"],
                'tahsilat_id' => $son["id"],
                'senet_id' => $item["senet_id"],
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
            $urunleri_ekle = DB::insert("tahsil_edilen_senet_urunler", $urun_arr);
        }
        if ($urunleri_ekle) {
            echo 500;
        } else {
            foreach ($_POST["arr"] as $item) {
                $cekid = $item["senet_id"];
                $cekler_arr = [
                    'status' => 2,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $cekleri_gizle = DB::update("alinan_senet_cikis_urunler", "id", $cekid, $cekler_arr);
            }
            if ($cekleri_gizle) {
                echo 1;
            } else {
                echo 500;
            }
        }
    }
}
if ($islem == "tum_tahsilatlari_getir_sql"){
    $sql = "
SELECT
       csg.*,
       b.banka_adi,
       k.kasa_adi,
       SUM(acu.tutar) as tutar
FROM 
     tahsil_edilen_senet as csg
INNER JOIN tahsil_edilen_senet_urunler as acu on acu.tahsilat_id=csg.id
LEFT JOIN banka as b on b.id=acu.banka_id
LEFT JOIN kasa as k on k.id=csg.kasa_id
WHERE csg.status=1 AND csg.cari_key='$cari_key' AND acu.status=1";
    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        $sql .= " AND csg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
    }
    $sql .= " GROUP BY tahsilat_id";
    $cek_senetler_listesi = DB::all_data($sql);
    if ($cek_senetler_listesi > 0) {
        echo json_encode($cek_senetler_listesi);
    } else {
        echo 2;
    }
}
if ($islem == "tahsil_edilen_seneti_sil_sql"){
    $id = $_POST["id"];
    $_POST["status"] = 0;
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $urunlerini_getir = DB::all_data("SELECT * FROM tahsil_edilen_senet_urunler WHERE status=1 AND cari_key='$cari_key' AND tahsilat_id='$id'");
    if ($urunlerini_getir > 0) {
        foreach ($urunlerini_getir as $item) {
            $cekid = $item["senet_id"];
            $arr = [
                'status' => 1
            ];
            $guncelle = DB::update("alinan_senet_cikis_urunler", "id", $cekid, $arr);
        }
        if ($guncelle) {
            $tahsil_sil = DB::update("tahsil_edilen_senet", "id", $id, $_POST);
            if ($tahsil_sil) {
                echo 1;
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    } else {
        $tahsil_sil = DB::update("tahsil_edilen_senet", "id", $id, $_POST);
        if ($tahsil_sil) {
            echo 1;
        } else {
            echo 2;
        }
    }
}
if ($islem == "teminata_verilen_cek_senetleri_getir"){
    $tahsile_verilen_cekler = DB::all_data("
SELECT 
       ccu.*,
       b.banka_adi,
       b.sube_adi,
       b.hesap_no,
       b.id as banka_id
FROM 
     alinan_senet_cikis_urunler as ccu
INNER JOIN alinan_senet_cikis AS acc on acc.id=ccu.cikis_senetid
INNER JOIN banka as b on b.id=acc.banka_id
WHERE acc.islem='teminata_verilmis_senet' AND acc.status=1 AND ccu.status=1 AND acc.cari_key='$cari_key'");
    if ($tahsile_verilen_cekler > 0) {
        echo json_encode($tahsile_verilen_cekler);
    } else {
        echo 2;
    }
}
if ($islem == "teminata_verilen_tahsilati_gerceklestir_sql"){
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

    $tahsil_edilen_cek_senet_kaydet = DB::insert("tahsil_edilen_senet", $cek_arr);
    if ($tahsil_edilen_cek_senet_kaydet) {
        echo 500;
    } else {
        $son = DB::single_query("SELECT id FROM tahsil_edilen_senet where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        foreach ($_POST["arr"] as $item) {
            $urun_arr = [
                'banka_id' => $item["banka_id"],
                'tahsilat_id' => $son["id"],
                'senet_id' => $item["cek_id"],
                'seri_no' => $item["seri_no"],
                'vade_tarih' => $item["vade_tarih"],
                'asil_borclu' => $item["asil_borclu"],
                'ciro_edilmis' => $item["ciro_edilmis"],
                'tutar' => $item["tutar"],
                'keside_yeri' => $item["keside_yeri"],
                'ozel_kod' => $item["ozel_kod"],
                'islem' => 'teminata_verilen_senet_tahsili',
                'insert_userid' => $_SESSION["user_id"],
                'insert_datetime' => date("Y-m-d H:i:s"),
                'cari_key' => $cari_key,
                'sube_key' => $_SESSION["sube_key"]
            ];
            $urunleri_ekle = DB::insert("tahsil_edilen_senet_urunler", $urun_arr);
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
                $cekleri_gizle = DB::update("alinan_senet_cikis_urunler", "id", $cekid, $cekler_arr);
            }
            if ($cekleri_gizle) {
                echo 1;
            } else {
                echo 500;
            }
        }
    }
}
if ($islem == "cek_girislerini_getir_sql"){
    $alinan_cekid = DB::all_data("
SELECT
       acu.*
FROM 
     alinan_senet_urunler as acu
INNER JOIN alinan_senet_giris as acg on acg.id=acu.alinan_senetid
WHERE
      acu.status=1 AND acu.cari_key='$cari_key' AND acg.status=1 AND acu.bizim!=1");
    if ($alinan_cekid > 0){
        echo json_encode($alinan_cekid);
    }else{
        echo 2;
    }
}
if ($islem == "elden_tahsilati_gerceklestir_sql"){
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

    $tahsil_edilen_cek_senet_kaydet = DB::insert("tahsil_edilen_senet", $cek_arr);
    if ($tahsil_edilen_cek_senet_kaydet) {
        echo 500;
    } else {
        $son = DB::single_query("SELECT id FROM tahsil_edilen_senet where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        foreach ($_POST["arr"] as $item) {
            $urun_arr = [
                'tahsilat_id' => $son["id"],
                'senet_id' => $item["cek_id"],
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
            $urunleri_ekle = DB::insert("tahsil_edilen_senet_urunler", $urun_arr);
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
                $cekleri_gizle = DB::update("alinan_senet_urunler", "id", $cekid, $cekler_arr);
            }
            if ($cekleri_gizle) {
                echo 1;
            } else {
                echo 500;
            }
        }
    }
}
if ($islem == "elden_cek_tahsil_sil_sql"){
    $id = $_POST["id"];
    $_POST["status"] = 0;
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $urunlerini_getir = DB::all_data("SELECT * FROM tahsil_edilen_senet_urunler WHERE status=1 AND cari_key='$cari_key' AND tahsilat_id='$id'");
    if ($urunlerini_getir > 0) {
        foreach ($urunlerini_getir as $item) {
            $cekid = $item["senet_id"];
            $arr = [
                'status' => 1
            ];
            $guncelle = DB::update("alinan_senet_urunler", "id", $cekid, $arr);
        }
        if ($guncelle) {
            $tahsil_sil = DB::update("tahsil_edilen_senet", "id", $id, $_POST);
            if ($tahsil_sil) {
                echo 1;
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    } else {
        $tahsil_sil = DB::update("tahsil_edilen_senet", "id", $id, $_POST);
        if ($tahsil_sil) {
            echo 1;
        } else {
            echo 2;
        }
    }
}