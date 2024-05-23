<?php
include '../DB.php';
date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=UTF-8');
session_start();
DB::connect();
$islem = $_GET["islem"];
$cari_key = $_SESSION["cari_key"];
$sube_key = $_SESSION["sube_key"];

if ($islem == "yeni_binek_arac_ekle_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $binek_arac_ekle = DB::insert("binek_kartlari", $_POST);
    if ($binek_arac_ekle) {
        echo 500;
    } else {
        echo 1;
    }
}
if ($islem == "binekleri_getir_sql") {
    $binek_araclar = DB::all_data("
SELECT
       bk.*,
       m.marka_adi,
       mo.model_adi
FROM
     binek_kartlari as bk
LEFT JOIN marka as m on m.id=bk.marka
LEFT JOIN model as mo on mo.id=bk.model
WHERE bk.status=1");
    if ($binek_araclar > 0) {
        $donecek_arr = [];
        foreach ($binek_araclar as $item) {
            $degeri = number_format($item["degeri"], 2);
            $muayene_tarihi = date("m/d/Y", strtotime($item["muayene_tarihi"]));

            $arr = [
                'arac_plaka' => $item["arac_plaka"],
                'surucu_adi' => $item["surucu_adi"],
                'marka_adi' => $item["marka_adi"],
                'model_adi' => $item["model_adi"],
                'model_yili' => $item["model_yili"],
                'yakit_tipi' => $item["yakit_tipi"],
                'ehliyet_no' => $item["ehliyet_no"],
                'muayene_tarihi' => $muayene_tarihi,
                'guncel_km' => $item["guncel_km"],
                'hgs_no' => $item["hgs_no"],
                'degeri' => $degeri,
                'id' => $item["id"],
                'surucu_id' => $item["surucu_id"],
                'islem' => "<button class='btn btn-sm binek_guncelle_button' style='background-color: #F6FA70' data-id='" . $item["id"] . "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm binek_kartlari_sil_button'  data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>",
            ];
            array_push($donecek_arr, $arr);
        }
        if (!empty($donecek_arr)) {
            echo json_encode($donecek_arr);
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "binek_arac_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $binek_arac_sil = DB::update("binek_kartlari", "id", $_POST["id"], $_POST);
    if ($binek_arac_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "arac_bilgilerini_getir_sql") {
    $id = $_GET["id"];

    $ek = "";
    if (isset($_GET["plaka_no"])) {
        $plaka = $_GET["plaka_no"];
        $ek = " AND arac_plaka='$plaka'";
    }
    $binek_bilgileri = DB::single_query("SELECT * FROM binek_kartlari WHERE status=1 AND cari_key='$cari_key' $ek AND id='$id'");
    if ($binek_bilgileri > 0) {
        echo json_encode($binek_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "yeni_binek_arac_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DB::update("binek_kartlari", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "yakit_cikis_fisi_kaydet_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;

    if ($_POST["alim_yeri"] == "İstasyondan") {
        $istasyon_stok_id = DB::single_query("SELECT id FROM stok WHERE status=1 AND cari_key='$cari_key' AND stok_kodu='YAKIT.001'");
        $_POST["stok_id"] = $istasyon_stok_id["id"];
    } else if ($_POST["alim_yeri"] == "Depodan") {
        $istasyon_stok_id = DB::single_query("SELECT id FROM stok WHERE status=1 AND cari_key='$cari_key' AND stok_kodu='YAKIT.002'");
        $_POST["stok_id"] = $istasyon_stok_id["id"];
    }

    $yakit_alim_fisi_ekle = DB::insert("binek_yakit_cikis", $_POST);
    if ($yakit_alim_fisi_ekle) {
        echo 500;
    } else {
        echo 1;
    }
}
if ($islem == "son_alinan_km_sql") {
    $plaka_id = $_GET["plaka_id"];
    $tarih = $_GET["tarih"];
    $aracin_son_km_si = DB::single_query("SELECT * FROM binek_yakit_cikis WHERE status=1 AND cari_key='$cari_key' AND plaka_id='$plaka_id' AND tarih < '$tarih 23:59:59' ORDER BY id DESC LIMIT 1");
    if ($aracin_son_km_si > 0) {
        echo json_encode($aracin_son_km_si);
    } else {
        echo 2;
    }
}
if ($islem == "aracin_guncel_km_si") {
    $id = $_GET["id"];
    $arac_kartlari = DB::single_query("SELECT * FROM binek_kartlari WHERE status=1 AND id='$id'");
    if ($arac_kartlari > 0) {
        echo json_encode($arac_kartlari);
    } else {
        echo 2;
    }
}
if ($islem == "tum_yakit_cikis_fislerini_getir_sql") {
    $yakit_cikis_fisleri = DB::all_data("
SELECT
       byc.*,
       k.kasa_adi,
       b.banka_adi,
       kkt.kart_adi,
       bk.arac_plaka,
       c.cari_adi as istasyon_adi
FROM
     binek_yakit_cikis as byc
LEFT JOIN banka as b on b.id=byc.banka_id
LEFT JOIN kasa as k on k.id=byc.kasa_id
LEFT JOIN kredi_kart_tanim as kkt on kkt.id=byc.kart_id
INNER JOIN binek_kartlari as bk on bk.id=byc.plaka_id
LEFT JOIN cari as c on c.id=byc.istasyon_id
WHERE
      byc.status=1 AND byc.cari_key='$cari_key'");
    if ($yakit_cikis_fisleri > 0) {
        $gidecek_arr = [];
        foreach ($yakit_cikis_fisleri as $item) {
            $tarih = date("d/m/Y", strtotime($item["tarih"]));
            $miktar = number_format($item["miktar"], 2);
            $litre_fiyati = number_format($item["litre_fiyati"], 2);
            $tl_tutar = number_format($item["tl_tutar"], 2);
            $son_alim_km = number_format($item["son_alim_km"], 0);
            $yakit_km = number_format($item["yakit_km"], 0);
            $fark_km = number_format($item["fark_km"], 0);

            $arr = [
                'id' => $item["id"],
                'alinan_yer' => $item["alim_yeri"],
                'alim_yontem' => $item["odeme_yontem"],
                'kasa_adi' => $item["kasa_adi"],
                'banka_adi' => $item["banka_adi"],
                'kart_adi' => $item["kart_adi"],
                'tarih' => $tarih,
                'plaka' => $item["arac_plaka"],
                'surucu' => $item["surucu_adi"],
                'fis_no' => $item["fis_no"],
                'miktar' => $miktar,
                'litre_fiyati' => $litre_fiyati,
                'tutar' => $tl_tutar,
                'yakit_tipi' => $item["yakit_tipi"],
                'istasyon_adi' => $item["istasyon_adi"],
                'son_km' => $son_alim_km,
                'alinan_km' => $yakit_km,
                'fark_km' => $fark_km,
                'aciklama' => $item["aciklama"],
                'islem' => "<button class='btn btn-sm binek_yakit_alim_guncelle' style='background-color: #F6FA70' data-id='" . $item["id"] . "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm binek_yakit_alim_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "yakit_cikis_fisi_sil_sql") {
    $_POST["status"] = 0;
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");

    $yakit_alim_sil = DB::update("binek_yakit_cikis", "id", $_POST["id"], $_POST);
    if ($yakit_alim_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "kesilecek_yakit_fislerini_getir_sql") {
    $bas_tarih = $_GET["bas_tarih"];
    $bit_tarih = $_GET["bit_tarih"];
    $cari_id = $_GET["cari_id"];
    $yakit_fisleri = DB::all_data("
    SELECT
       ycf.*,
       pt.ad_soyad as surucu_adi,
       c.cari_adi,
        c.cari_kodu,
       ak.arac_grubu,
       ak.arac_plaka as plaka
FROM
     binek_yakit_cikis as ycf
LEFT JOIN binek_kartlari as ak on ak.id=ycf.plaka_id
LEFT JOIN cari as c on c.id=ycf.istasyon_id
LEFT JOIN personel_tanim as pt on pt.id=ycf.surucu_id
WHERE ycf.status=1 AND ycf.cari_key='$cari_key' AND ycf.istasyon_id='$cari_id' AND ycf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' AND ycf.alim_yeri='İstasyondan'");
    if ($yakit_fisleri > 0) {
        echo json_encode($yakit_fisleri);
    } else {
        echo 2;
    }
}
if ($islem == "yakit_fislerini_faturalandir") {
    $arr = [
        'fatura_no' => $_POST["fatura_no"],
        'fatura_tarihi' => $_POST["fatura_tarihi"],
        'cari_id' => $_POST["cari_id"],
        'insert_userid' => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s"),
        'cari_key' => $cari_key,
        'sube_key' => $sube_key
    ];
    $cari_id = $_POST["cari_id"];
    $cari_vadesi = DB::single_query("SELECT vade_gunu FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
    $vade_gunu = $cari_vadesi["vade_gunu"];
    $baslangic_tarihi = $_POST["fatura_tarihi"];
    $datetime = new DateTime($baslangic_tarihi);
    $datetime->modify('+' . $vade_gunu . ' days');
    $sonuc_tarihi = $datetime->format('Y-m-d');

    $fatura_olustur = DB::insert("binek_yakit_fatura", $arr);
    $son_eklenen = DB::single_query("SELECT * FROM binek_yakit_fatura WHERE status=1 AND cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
    $yakit_fatura_id = $son_eklenen["id"];
    $fis_toplam = 0;
    $muhasebe_fatura_urun_bilgi = [];
    foreach ($_POST["yakit_fisleri"] as $item) {
        $yakit_fis_bilgisi = DB::single_query("SELECT * FROM yakit_cikis_fisleri WHERE status=1 AND id='$item'");
        $fis_toplam += floatval($yakit_fis_bilgisi["tl_tutar"]);
        $arr2 = [
            'yakit_fis_id' => $item,
            'fatura_id' => $son_eklenen["id"],
            'insert_userid' => $_SESSION["user_id"],
            'insert_datetime' => date("Y-m-d H:i:s"),
            'cari_key' => $cari_key,
            'sube_key' => $sube_key
        ];
        $yakit_fis_fatura_ekle = DB::insert("binek_fis_faturasi", $arr2);
    }

    foreach ($_POST["yakit_fisleri"] as $item3) {
        $arr = [
            'fatura_id' => $son_eklenen["id"],
            'status' => 2,
            'update_userid' => $_SESSION["user_id"],
            'update_datetime' => date("Y-m-d H:i:s")
        ];
        $yakit_fisi_guncelle = DB::update("binek_yakit_cikis", "id", $item3, $arr);
    }
    if ($yakit_fisi_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "yakit_faturalarini_getir_sql") {
    $faturalanmis_yakit_fisleri = DB::all_data("
SELECT
       yf.*,
       plaka.arac_plaka,
       ycf.surucu_adi,
       ycf.fis_no,
       ycf.tarih,
       SUM(ycf.miktar) as miktar,
       AVG(ycf.litre_fiyati) as litre_fiyati,
       SUM(ycf.tl_tutar) AS tl_tutar,
       ycf.yakit_tipi,
       c.cari_adi
FROM 
     binek_yakit_fatura as yf 
INNER JOIN binek_fis_faturasi as yff on yff.fatura_id=yf.id
INNER JOIN binek_yakit_cikis as ycf on ycf.id=yff.yakit_fis_id
INNER JOIN binek_kartlari as plaka on plaka.id=ycf.plaka_id
INNER JOIN cari as c on c.id=yf.cari_id
WHERE yf.status=1 AND yf.cari_key='$cari_key' GROUP BY yf.id
");

    if ($faturalanmis_yakit_fisleri > 0) {
        echo json_encode($faturalanmis_yakit_fisleri);
    } else {
        echo 2;
    }
}
if ($islem == "yakit_cikis_fislerini_sil_sql") {
    $id = $_POST["id"];
    $fatura_urunler = DB::all_data("SELECT * FROM binek_fis_faturasi WHERE status=1 AND fatura_id='$id'");
    $fatura_yakit = DB::single_query("SELECT * FROM binek_yakit_fatura WHERE status=1 AND id='$id'");
    foreach ($fatura_urunler as $item) {
        $yakit_fisi_id = $item["yakit_fis_id"];
        $arr = [
            'status' => 1
        ];
        $guncelle = DB::update("binek_yakit_cikis", "id", $yakit_fisi_id, $arr);
    }
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $guncelle = DB::update("binek_yakit_fatura", "id", $id, $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "sanayi_fisi_kaydet_sql") {
    $arr = [
        'cari_id' => $_POST["cari_id"],
        'fis_no' => $_POST["fis_no"],
        'tarih' => $_POST["tarih"],
        'aciklama' => $_POST["aciklama"],
        'cari_key' => $cari_key,
        'sube_key' => $sube_key,
        'insert_userid' => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s")
    ];

    $sanayi_fisi_olustur = DB::insert("binek_sanayi_fisi", $arr);
    if ($sanayi_fisi_olustur) {
        echo 500;
    } else {
        $son_id = DB::single_query("SELECT * FROM binek_sanayi_fisi WHERE status=1 AND cari_key='$cari_key' ORDER BY id DESC LIMIT 1");

        foreach ($_POST["gidecek_arr"] as $item) {
            $item["fis_id"] = $son_id["id"];
            $item["cari_key"] = $cari_key;
            $item["sube_key"] = $sube_key;
            $item["insert_userid"] = $_SESSION["user_id"];
            $item["insert_datetime"] = date("Y-m-d H:i:s");
            $urunleri_olustur = DB::insert("binek_sanayi_fisi_urunler", $item);
        }
        if ($urunleri_olustur) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "tum_sanayi_fislerini_getir_sql") {
    $sanayi_fisleri = DB::all_data("
SELECT 
       sf.*,
       c.cari_adi,
       c.cari_kodu,
       SUM(sfu.ara_toplam) as ara_toplam,
       SUM(sfu.genel_toplam) as genel_toplam
FROM 
     binek_sanayi_fisi as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN binek_sanayi_fisi_urunler AS sfu on sfu.fis_id=sf.id
WHERE 
      sf.status=1 AND sf.cari_key='$cari_key' AND sfu.status=1 GROUP BY sf.id ");
    if ($sanayi_fisleri > 0) {
        echo json_encode($sanayi_fisleri);
    } else {
        echo 2;
    }
}
if ($islem == "sanayi_cikis_fisi_sil_sql") {
    $_POST["status"] = 0;
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $sanayi_fisi_sil = DB::update("binek_sanayi_fisi", "id", $_POST["id"], $_POST);
    if ($sanayi_fisi_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "guncellenecek_yakit_fisi_bilgileri_sql") {
    $id = $_GET["id"];
    $sanayi_fisi_bilgileri = DB::single_query("SELECT 
       sf.*,
       c.cari_adi,
       c.cari_kodu,
       c.vergi_dairesi,
       c.vergi_no,
       cab.adres,
       SUM(sfu.ara_toplam) as ara_toplam,
       SUM(sfu.kdv_tutar) as kdv_toplam,
       SUM(sfu.iskonto_tutar) as iskonto_toplam,
       SUM(sfu.genel_toplam) as genel_toplam
FROM 
     binek_sanayi_fisi as sf
INNER JOIN cari as c on c.id=sf.cari_id
LEFT JOIN cari_adres_bilgileri as cab on c.id=cab.cari_id
INNER JOIN binek_sanayi_fisi_urunler AS sfu on sfu.fis_id=sf.id
WHERE 
      sf.status=1 AND sf.cari_key='$cari_key'  AND sf.id='$id' AND sfu.status=1 GROUP BY sf.id ");
    if ($sanayi_fisi_bilgileri > 0) {
        echo json_encode($sanayi_fisi_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "sanayi_fisi_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DB::update("binek_sanayi_fisi", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "kesilecek_sanayi_fisleri_sql") {
    $cari_id = $_POST["cari_id"];
    $bas_tarih = $_POST["bas_tarih"];
    $bit_tarih = $_POST["bit_tarih"];

    $sanayi_fislerini_getir = DB::all_data("
SELECT 
       sfu.*,
       sf.tarih,
       sf.fis_no,
       c.cari_adi,
       c.cari_kodu,
       ak.plaka_no
FROM 
     binek_sanayi_fisi_urunler as sfu
INNER JOIN binek_sanayi_fisi as sf on sf.id=sfu.fis_id
INNER JOIN arac_kartlari AS ak on ak.id=sfu.plaka_id
INNER JOIN cari as c on c.id=sf.cari_id
WHERE 
sfu.status=1 AND sfu.cari_key='$cari_key' AND sf.cari_id='$cari_id' AND sf.status=1 AND sf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
     ");
    if ($sanayi_fislerini_getir > 0) {
        echo json_encode($sanayi_fislerini_getir);
    } else {
        echo 2;
    }
}
if ($islem == "sanayi_fis_fatura_kaydet_sql") {
    $count = $_POST["gidecek_sanayi"];
    if ($count == 0) {
        echo 300;
    } else {
        unset($_POST["gidecek_sanayi"]);
        $_POST["cari_key"] = $cari_key;
        $_POST["sube_key"] = $sube_key;
        $_POST["insert_userid"] = $_SESSION["user_id"];
        $_POST["insert_datetime"] = date("Y-m-d H:i:s");
        $sanayi_faturasi_olustur = DB::insert("binek_sanayi_fatura", $_POST);
        if ($sanayi_faturasi_olustur) {
            echo 500;
        } else {
            $son_id = DB::single_query("SELECT * FROM binek_sanayi_fatura WHERE status=1 AND cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
            foreach ($count as $item) {
                $item["fatura_id"] = $son_id["id"];
                $item["insert_datetime"] = date("Y-m-d H:i:s");
                $item["insert_userid"] = $_SESSION["user_id"];
                $item["cari_key"] = $cari_key;
                $item["sube_key"] = $sube_key;
                $fatura_urun_olustur = DB::insert("binek_sanayi_fatura_urunler", $item);
                if ($fatura_urun_olustur) {

                } else {
                    $arr = [
                        'status' => 2,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];

                    $sanayi_fis_faturala = DB::update("binek_sanayi_fisi_urunler", "id", $item["sanayi_fisid"], $arr);

                }
            }
            if ($sanayi_fis_faturala) {
                echo 1;
            } else {
                echo 500;
            }
        }

    }
}
if ($islem == "faturalanmis_sanayi_fisleri_getir_sql") {
    $sanayi_faturalar = DB::all_data("
SELECT
       sf.*,
       c.cari_adi,
       SUM(sfu.genel_toplam) as toplam_tutar,
       SUM(sfu.ara_toplam) as ara_toplam,
       SUM(sfu.kdv_tutar) as kdv_tutar,
       SUM(sfu.iskonto_tutar) as iskonto_tutar
FROM
     binek_sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN binek_sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
INNER JOIN binek_sanayi_fisi_urunler as sfu2 on sfu2.id=sfu.sanayi_fisid
WHERE sf.status=1 AND sf.cari_key='$cari_key' GROUP BY sf.id");
    if ($sanayi_faturalar > 0) {
        echo json_encode($sanayi_faturalar);
    } else {
        echo 2;
    }
}
if ($islem == "sanayi_faturasini_sil_sql") {
    $id = $_POST["id"];
    $urunleri = DB::all_data("SELECT * FROM binek_sanayi_fatura_urunler WHERE status=1 AND cari_key='$cari_key' AND fatura_id='$id'");

    foreach ($urunleri as $item) {
        $arr = [
            'status' => 1,
            'update_userid' => $_SESSION["user_id"],
            'update_datetime' => date("Y-m-d H:i:s")
        ];
        $urunleri_guncelle = DB::update("binek_sanayi_fisi_urunler", "id", $item["sanayi_fisid"], $arr);
    }
    if ($urunleri_guncelle) {
        $_POST["status"] = 0;
        $_POST["delete_userid"] = $_SESSION["user_id"];
        $_POST["delete_datetime"] = date("Y-m-d H:i:s");
        $fatura_sil_sql = DB::update("binek_sanayi_fatura", "id", $_POST["id"], $_POST);
        if ($fatura_sil_sql) {
            echo 1;
        } else {
            echo 500;
        }
    } else {
        echo 500;
    }
}
if ($islem == "fatura_ana_bilgileri_getir_sql") {
    $id = $_GET["id"];
    $fatura_ana_bilgiler = DB::single_query("
SELECT
       sf.*,
       c.cari_kodu,
       c.cari_adi,
       sf.fatura_tur,
       sf.fatura_tip
FROM 
     binek_sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
WHERE sf.status=1 AND sf.cari_key='$cari_key' AND sf.id='$id'");
    if ($fatura_ana_bilgiler > 0) {
        echo json_encode($fatura_ana_bilgiler);
    } else {
        echo 2;
    }
}
if ($islem == "sanayi_fatura_kalemleri_getir_sql") {
    $fatura_id = $_GET["fatura_id"];
    $fatura_urun_bilgileri = DB::all_data("
SELECT 
       sfu.*,
       c.cari_adi,
       c.cari_kodu,
       ak.arac_plaka,
       sf2.tarih,
       sf2.fis_no
FROM 
     binek_sanayi_fatura_urunler as sfu
INNER JOIN binek_sanayi_fisi_urunler as sfu2 on sfu2.id=sfu.sanayi_fisid
INNER JOIN binek_sanayi_fatura as sf on sf.id=sfu.fatura_id
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN binek_sanayi_fisi as sf2 on sf2.id=sfu2.fis_id
INNER JOIN binek_kartlari as ak on ak.id=sfu2.plaka_id
WHERE sfu.status=1 AND sfu.cari_key='$cari_key' AND sfu.fatura_id='$fatura_id'");

    if ($fatura_urun_bilgileri > 0) {
        echo json_encode($fatura_urun_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "hgsye_ait_arac_getir_sql") {
    $hgs = $_GET["hgs"];
    $hgsye_ait_arac = DB::single_query("SELECT * FROM binek_kartlari WHERE status=1 AND cari_key='$cari_key' AND hgs_no='$hgs'");
    if ($hgsye_ait_arac > 0) {
        echo json_encode($hgsye_ait_arac);
    } else {
        echo 2;
    }
}
if ($islem == "hgs_gider_fisi_kaydet_sql") {
    $arr = [
        'insert_userid' => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s"),
        'cari_key' => $cari_key,
        'sube_key' => $sube_key,
        'tarih' => $_POST["gidecek_arr"][0]["tarih"],
        'aciklama' => $_POST["g_aciklama"]
    ];
    $hgs_gideri_ekle = DB::insert("binek_hgs_gider", $arr);
    if ($hgs_gideri_ekle) {
        echo 500;
    } else {
        $son_eklenen = DB::single_query("SELECT id FROM binek_hgs_gider where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        foreach ($_POST["gidecek_arr"] as $item) {
            $item["gider_id"] = $son_eklenen["id"];
            unset($item["tarih"]);
            $item["insert_userid"] = $_SESSION["user_id"];
            $item["insert_datetime"] = date("Y-m-d H:i:s");
            $item["cari_key"] = $cari_key;
            $item["sube_key"] = $sube_key;
            $ekle = DB::insert("binek_hgs_gider_fisleri", $item);
        }
        if ($ekle) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "hgs_gider_fislerini_getir_sql") {
    $hgs_gider_fisleri = DB::all_data("
SELECT
       hg.*,
       SUM(hgf.tutar) as tutar
FROM
     binek_hgs_gider as hg 
INNER JOIN binek_hgs_gider_fisleri AS hgf on hgf.gider_id=hg.id
WHERE hg.status=1 AND hg.cari_key='$cari_key' AND hgf.status=1 GROUP BY hg.id");
    if ($hgs_gider_fisleri > 0) {
        echo json_encode($hgs_gider_fisleri);
    } else {
        echo 2;
    }
}
if ($islem == "hgs_gider_fisi_bilgilerini_getir_sql") {
    $id = $_GET["gider_id"];
    $hgs_gider_bilgileri = DB::all_data("
SELECT
       hgf.*,
       kkt.kart_adi,
       b.banka_adi,
       k.kasa_adi,
       ak.arac_plaka,
       hg.tarih,
       hg.aciklama as genel_aciklama
FROM 
     binek_hgs_gider_fisleri as hgf
LEFT JOIN kasa as k on k.id=hgf.kasa_id
INNER JOIN binek_hgs_gider as hg on hg.id=hgf.gider_id
LEFT JOIN binek_kartlari as ak on ak.id=hgf.plaka_id
LEFT JOIN banka as b on b.id=hgf.banka_id
LEFT JOIN kredi_kart_tanim as kkt on kkt.id=hgf.kart_id
WHERE hgf.status=1 AND hgf.cari_key='$cari_key' AND hgf.gider_id='$id'");
    if ($hgs_gider_bilgileri > 0) {
        echo json_encode($hgs_gider_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "hgs_gider_fisi_ekle_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $hgs_gider_ekle = DB::insert("binek_hgs_gider_fisleri", $_POST);
    if ($hgs_gider_ekle) {
        echo 500;
    } else {
        $son_eklenen = DB::single_query("SELECT id FROM binek_hgs_gider_fisleri where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        echo 'id:' . $son_eklenen["id"];
    }
}
if ($islem == "hgs_gider_fisi_sil_sql") {
    $id = $_POST["id"];
    $_POST["status"] = 0;
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $gider_fisi_sil = DB::update("binek_hgs_gider_fisleri", "id", $id, $_POST);
    if ($gider_fisi_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "hgs_gider_fisi_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_idr"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DB::update("binek_hgs_gider", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 500;
    }
}
if ($islem == "vergi_gider_fisi_kaydet_sql") {
    $arr = [
        'insert_userid' => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s"),
        'cari_key' => $cari_key,
        'sube_key' => $sube_key,
        'tarih' => $_POST["gidecek_arr"][0]["tarih"],
        'aciklama' => $_POST["g_aciklama"]
    ];
    $hgs_gideri_ekle = DB::insert("binek_vergi_gider", $arr);
    if ($hgs_gideri_ekle) {
        echo 500;
    } else {
        $son_eklenen = DB::single_query("SELECT id FROM binek_vergi_gider where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        foreach ($_POST["gidecek_arr"] as $item) {
            $item["gider_id"] = $son_eklenen["id"];
            unset($item["tarih"]);
            $item["insert_userid"] = $_SESSION["user_id"];
            $item["insert_datetime"] = date("Y-m-d H:i:s");
            $item["cari_key"] = $cari_key;
            $item["sube_key"] = $sube_key;
            $ekle = DB::insert("binek_vergi_gider_fisleri", $item);
        }
        if ($ekle) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "vergi_gider_fislerini_getir_sql") {
    $hgs_gider_fisleri = DB::all_data("
SELECT
       hg.*,
       SUM(hgf.tutar) as tutar
FROM
     binek_vergi_gider as hg 
INNER JOIN binek_vergi_gider_fisleri AS hgf on hgf.gider_id=hg.id
WHERE hg.status=1 AND hg.cari_key='$cari_key' AND hgf.status=1 GROUP BY hg.id");
    if ($hgs_gider_fisleri > 0) {
        echo json_encode($hgs_gider_fisleri);
    } else {
        echo 2;
    }
}
if ($islem == "vergi_gider_fisi_bilgilerini_getir_sql") {
    $id = $_GET["gider_id"];
    $hgs_gider_bilgileri = DB::all_data("
SELECT
       hgf.*,
       kkt.kart_adi,
       b.banka_adi,
       k.kasa_adi,
       ak.arac_plaka,
       hg.tarih,
       hg.aciklama as genel_aciklama
FROM 
     binek_vergi_gider_fisleri as hgf
LEFT JOIN kasa as k on k.id=hgf.kasa_id
INNER JOIN binek_vergi_gider as hg on hg.id=hgf.gider_id
LEFT JOIN binek_kartlari as ak on ak.id=hgf.plaka_id
LEFT JOIN banka as b on b.id=hgf.banka_id
LEFT JOIN kredi_kart_tanim as kkt on kkt.id=hgf.kart_id
WHERE hgf.status=1 AND hgf.cari_key='$cari_key' AND hgf.gider_id='$id'");
    if ($hgs_gider_bilgileri > 0) {
        echo json_encode($hgs_gider_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "vergi_gider_fisi_ekle_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $hgs_gider_ekle = DB::insert("binek_vergi_gider_fisleri", $_POST);
    if ($hgs_gider_ekle) {
        echo 500;
    } else {
        $son_eklenen = DB::single_query("SELECT id FROM binek_vergi_gider_fisleri where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        echo 'id:' . $son_eklenen["id"];
    }
}
if ($islem == "vergi_gider_fisi_sil_sql") {
    $id = $_POST["id"];
    $_POST["status"] = 0;
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $gider_fisi_sil = DB::update("binek_vergi_gider_fisleri", "id", $id, $_POST);
    if ($gider_fisi_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "vergi_gider_fisi_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_idr"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DB::update("binek_vergi_gider", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 500;
    }
}
if ($islem == "vergi_gider_fisi_tum_sil_sql") {
    $id = $_POST["id"];
    $_POST["status"] = 0;
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $gider_fisi_sil = DB::update("binek_vergi_gider", "id", $id, $_POST);
    if ($gider_fisi_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "hgs_gider_fisi_tum_sil_sql") {
    $id = $_POST["id"];
    $_POST["status"] = 0;
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $gider_fisi_sil = DB::update("binek_hgs_gider", "id", $id, $_POST);
    if ($gider_fisi_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "binek_yakit_alim_getir_sql") {
    $id = $_GET["id"];
    $yakit_cikis_fisleri = DB::single_query("
SELECT
       byc.*,
       k.kasa_adi,
       b.banka_adi,
       kkt.kart_adi,
       bk.arac_plaka,
       c.cari_adi as istasyon_adi
FROM
     binek_yakit_cikis as byc
LEFT JOIN banka as b on b.id=byc.banka_id
LEFT JOIN kasa as k on k.id=byc.kasa_id
LEFT JOIN kredi_kart_tanim as kkt on kkt.id=byc.kart_id
INNER JOIN binek_kartlari as bk on bk.id=byc.plaka_id
LEFT JOIN cari as c on c.id=byc.istasyon_id
WHERE
      byc.status=1 AND byc.cari_key='$cari_key' AND byc.id='$id'");

    if ($yakit_cikis_fisleri > 0) {
        echo json_encode($yakit_cikis_fisleri);
    } else {
        echo 2;
    }
}
if ($islem == "yakit_cikis_fisi_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");

    $guncelle = DB::update("binek_yakit_cikis", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "yakit_fatura_detayi_ana_bilgi_getir_sql") {
    $id = $_GET["id"];
    $fatura_ana_bilgiler = DB::single_query("
SELECT
       byf.*,
       c.cari_adi,
       c.cari_kodu,
       SUM(byc.tl_tutar) as toplam_tutar,
       SUM(byc.miktar) as toplam_lt
FROM
     binek_yakit_fatura as byf
INNER JOIN binek_fis_faturasi as bff on bff.fatura_id=byf.id
INNER JOIN binek_yakit_cikis as byc on byc.id=bff.yakit_fis_id
INNER JOIN cari as c on c.id=byf.cari_id
WHERE byf.status=1 AND byf.cari_key='$cari_key' AND byf.id='$id'");
    if ($fatura_ana_bilgiler > 0) {
        echo json_encode($fatura_ana_bilgiler);
    } else {
        echo 2;
    }
}
if ($islem == "yakit_alim_fat_icerik_bilgi") {
    $id = $_GET["id"];

    $yakit_urunler = DB::all_data("
SELECT
       byc.*,
       c.cari_adi as istasyon_adi,
       c.cari_kodu as istasyon_kodu,
       byc.tl_tutar,
       byc.litre_fiyati,
       bk.arac_plaka,
       byc.miktar
FROM
     binek_fis_faturasi as bff
INNER JOIN binek_yakit_cikis as byc on byc.id=bff.yakit_fis_id
INNER JOIN cari as c on c.id=byc.istasyon_id
INNER JOIN binek_kartlari as bk on bk.id=byc.plaka_id
WHERE bff.status=1 AND bff.cari_key='$cari_key' AND bff.fatura_id='$id'
     ");

    if ($yakit_urunler > 0) {
        echo json_encode($yakit_urunler);
    } else {
        echo 2;
    }
}
if ($islem == "faturalanmis_fisi_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DB::update("binek_yakit_fatura", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "sanayi_fisi_urunlerini_getir_sql") {
    $id = $_GET["fis_id"];
    $fis_urunleri = DB::all_data("
SELECT 
       sfu.*,
       b.birim_adi,
       ak.arac_plaka
FROM 
     binek_sanayi_fisi_urunler as sfu
INNER JOIN binek_kartlari as ak on ak.id=sfu.plaka_id
INNER JOIN birim as b on b.id=sfu.birim_id
WHERE sfu.status!=0 AND sfu.cari_key='$cari_key' AND sfu.fis_id='$id'");
    if ($fis_urunleri > 0) {
        echo json_encode($fis_urunleri);
    } else {
        echo 2;
    }
}
if ($islem == "sanayi_fisi_sil_list_sql") {
    $_POST["status"] = 0;
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $urunu_sil = DB::update("binek_sanayi_fisi_urunler", "id", $_POST["id"], $_POST);
    if ($urunu_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "sanayi_fisi_ekle_sql") {
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");

    $sanayi_fis_urun_ekle = DB::insert("binek_sanayi_fisi_urunler", $_POST);
    if ($sanayi_fis_urun_ekle) {
        echo 2;
    } else {
        $son_id = DB::single_query("SELECT * FROM binek_sanayi_fisi_urunler WHERE status=1 AND cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        echo 'id:' . $son_id["id"];
    }
}
if ($islem == "yakit_hareketlerini_getir_sql") {
    $iki_tarih_sorgusu = "";
    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];

        $iki_tarih_sorgusu = " AND ycf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
    }

    $arac_grup_sorgu = "";
    if (isset($_GET["arac_grubu"])) {
        if ($_GET["arac_grubu"] == "Öz Mal") {
            $arac_grup_sorgu = " AND ycf.kiralik_plaka=''";
        } else if ($_GET["arac_grubu"] == "Kiralık") {
            $arac_grup_sorgu = " AND ycf.kiralik_plaka!=''";
        }
    }

    $alim_yeri = "";
    if (isset($_GET["alim_yeri"])) {
        if ($_GET["alim_yeri"] == "1") {
            $alim_yeri = " AND ycf.istasyon_id!='0'";
        } else if ($_GET["alim_yeri"] == "2") {
            $alim_yeri = " AND ycf.istasyon_id='0'";
        }
    }

    $yakit_hareketleri = DB::all_data("
SELECT
       ycf.*,
       c.cari_adi,
       COALESCE(pt.ad_soyad,'') as ad_soyad,
       COALESCE(ak.arac_plaka,'') as plaka_no,
       yf.fatura_no,
       yf.fatura_tarihi
FROM
     binek_yakit_cikis as ycf
LEFT JOIN cari as c on c.id=ycf.istasyon_id
LEFT JOIN personel_tanim as pt on pt.id=ycf.surucu_id
LEFT JOIN binek_kartlari as ak on ak.id=ycf.plaka_id
LEFT JOIN binek_fis_faturasi as yff on yff.id=ycf.fatura_id AND yff.status=1
LEFT JOIN binek_yakit_fatura as yf on yf.id=yff.fatura_id AND yff.status=1
WHERE ycf.status!=0 AND ycf.cari_key='$cari_key' $iki_tarih_sorgusu $arac_grup_sorgu $alim_yeri GROUP BY ycf.id");
    $donecek_arr = [];
    $toplam_miktar = 0;
    $toplam_tutar = 0;
    $fark_km_toplam = 0;
    if ($yakit_hareketleri > 0) {
        foreach ($yakit_hareketleri as $item) {
            $surucu_adi = "";
            if ($item["arac_grubu"] == "Kiralık") {
                $surucu_adi = $item["kiralik_surucu"];
            } else {
                $surucu_adi = $item["ad_soyad"];
            }
            $toplam_tutar += $item["tl_tutar"];
            $toplam_miktar += $item["miktar"];
            $fark_km_toplam += $item["fark_km"];
            $fatura_tarihi = $item["fatura_tarihi"];
            if ($item["fatura_tarihi"] != "") {
                $fatura_tarihi = date("d/m/Y", strtotime($item["fatura_tarihi"]));
            }
            $tarih = $newDate = date("d/m/Y", strtotime($item["tarih"]));
            $yakit_km = number_format($item["yakit_km"], 0, ',', '.');
            $son_alinan_km = number_format($item["son_alinan_km"], 0, ',', '.');
            $fark_km = number_format($item["fark_km"], 0, ',', '.');
            $yakit_tuketim = number_format($item["yakit_tuketim"], 2, ',', '.');
            $tl_tutar = number_format($item["tl_tutar"], 2, ',', '.');
            $litre_fiyati = number_format($item["litre_fiyati"], 2, ',', '.');
            $miktar = number_format($item["miktar"], 2, ',', '.');
            $arr = [
                'arac_grubu' => $item["arac_grubu"],
                'tarih' => $tarih,
                'kiralik_cari' => $item["kiralik_cari"],
                'fis_no' => $item["fis_no"],
                'istasyon_adi' => $item["cari_adi"],
                'plaka' => $item["plaka_no"],
                'surucu_adi' => $surucu_adi,
                'miktar' => $miktar,
                'litre_fiyati' => $litre_fiyati,
                'tl_tutar' => $tl_tutar,
                'yakit_km' => $yakit_km,
                'son_alinan_km' => $son_alinan_km,
                'fark_km' => $fark_km,
                'tuketim_yuzde' => $yakit_tuketim . " %",
                'aciklama' => $item["aciklama"],
                'fatura_no' => $item["fatura_no"],
                'fatura_tarihi' => $fatura_tarihi
            ];
            array_push($donecek_arr, $arr);
        }

        $toplam_miktar = number_format($toplam_miktar, 2, ',', '.');
        $toplam_tutar = number_format($toplam_tutar, 2, ',', '.');
        $fark_km_toplam = number_format($fark_km_toplam, 0, ',', '.');
        $donecek_arr[0]["toplam_miktar"] = $toplam_miktar;
        $donecek_arr[0]["toplam_tutar"] = $toplam_tutar;
        $donecek_arr[0]["fark_km_toplam"] = $fark_km_toplam;
        if (!empty($donecek_arr)) {
            echo json_encode($donecek_arr);
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}