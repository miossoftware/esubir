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
$islem = $_GET["islem"];
$sube_key = $_SESSION["sube_key"];
$ek_sorgu = "";
$ek_sorgu_alis_urunler = "";
$ek_sorgu_ad = "";
$ek_sorgu_verilen_siparis = "";
$ek_sorgu_vs = "";
if ($sube_key != 0) {
    $ek_sorgu = " AND sube_key='$sube_key'";
    $ek_sorgu_alis_urunler = " AND alis_urunler.sube_key='$sube_key'";
    $ek_sorgu_ad = " AND ad.sube_key='$sube_key'";
    $ek_sorgu_verilen_siparis = " AND verilen_siparis.sube_key='$sube_key'";
    $ek_sorgu_vs = " AND vs.sube_key='$sube_key'";
}
if ($islem == "carileri_getir") {
    $cariler = DB::all_data("SELECT * FROM cari WHERE status=1 and cari_key='$cari_key'");
    $uyeler = DB::all_data("
SELECT
    tc_no as cari_kodu,
    uye_adi as cari_adi,
    id
FROM
    uye_tanim
WHERE status=1 AND cari_key='$cari_key'");
    $merge_arr = [];
    if (!empty($cariler)) {
        $merge_arr = array_merge($merge_arr, $cariler);
    }
    if (!empty($uyeler)) {
        $merge_arr = array_merge($merge_arr, $uyeler);
    }

    if ($merge_arr > 0) {
        echo json_encode($merge_arr);
    } else {
        echo 2;
    }
}
if ($islem == "carileri_getir2") {
    if (isset($_GET["from"])) {
        if ($_GET["from"] != "") {
            $uyeler = DB::all_data("
SELECT
    tc_no as cari_kodu,
    uye_adi as cari_adi,
    id
FROM
    uye_tanim
WHERE status=1 AND cari_key='$cari_key'");
            if ($uyeler > 0) {
                echo json_encode($uyeler);
            } else {
                echo 2;
            }
        } else {
            $cariler = DB::all_data("SELECT * FROM cari WHERE status=1 and cari_key='$cari_key'");
            if ($cariler > 0) {
                echo json_encode($cariler);
            } else {
                echo 2;
            }
        }
    } else {
        $cariler = DB::all_data("SELECT * FROM cari WHERE status=1 and cari_key='$cari_key'");
        if ($cariler > 0) {
            echo json_encode($cariler);
        } else {
            echo 2;
        }
    }
}
if ($islem == "secilen_cari_bilgileri") {
    $cari_kodu = $_GET["cari_kodu"];
    $cari_bilgi = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_kodu='$cari_kodu'");
    $cari_id = $cari_bilgi["id"];
    $cari_adres = DB::single_query("SELECT adres FROM cari_adres_bilgileri WHERE cari_id='$cari_id' AND status=1 and cari_key='$cari_key'");
    if ($cari_adres > 0) {
        $combine = array_merge($cari_bilgi, $cari_adres);
        if ($combine > 0) {
            echo json_encode($combine);
        } else {
            echo 2;
        }
    } else {
        if ($cari_bilgi > 0) {
            echo json_encode($cari_bilgi);
        } else {
            $uye_bilgileri = DB::single_query("SELECT id,tc_no as cari_kodu,uye_adi as cari_adi FROM uye_tanim WHERE status=1 AND cari_key='$cari_key' AND tc_no='$cari_kodu'");
            if ($uye_bilgileri > 0) {
                echo json_encode($uye_bilgileri);
            } else {
                echo 2;
            }
        }
    }
}
if ($islem == "birimleri_getir") {
    $birimleri_getir = DB::all_data("SELECT * FROM birim WHERE status=1 and cari_key='$cari_key'");
    if ($birimleri_getir > 0) {
        echo json_encode($birimleri_getir);
    } else {
        echo 2;
    }
}
if ($islem == "depolari_getir") {
    $depolari_getir = DB::all_data("SELECT * FROM depolar WHERE status=1 and cari_key='$cari_key' $ek_sorgu");
    if ($depolari_getir > 0) {
        echo json_encode($depolari_getir);
    } else {
        echo 2;
    }
}
if ($islem == "stok_listesi_getir") {
    $stoklari_getir = DB::all_data("SELECT * FROM stok WHERE status=1 and cari_key='$cari_key'");
    if ($stoklari_getir > 0) {
        echo json_encode($stoklari_getir);
    } else {
        echo 2;
    }
}
if ($islem == "stok_listesi_getir_lastikler") {
    $stoklari_getir = DB::all_data("SELECT * FROM stok WHERE status=1 and stok_kodu LIKE '%LASTİK%'");
    if ($stoklari_getir > 0) {
        echo json_encode($stoklari_getir);
    } else {
        echo 2;
    }
}
if ($islem == "secilen_stok_bilgileri") {
    $id = $_GET["id"];
    $bilgileri_getir = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$id' and cari_key='$cari_key'");
    if ($bilgileri_getir > 0) {
        echo json_encode($bilgileri_getir);
    } else {
        echo 2;
    }
}

if ($islem == "faturayi_guncelle_sql") {
    $cari_id = $_POST["cari_id"];
    $_POST["update_userid"] = $_SESSION["user_id"];

    $_POST["update_datetime"] = date("Y-m-d H:i:s");

    $fatura_tipi = $_POST["muhtelif_tipi"];

    $fatura_no = $_POST["fatura_no"];


    $fatura_id = $_POST["id"];

    if ($fatura_tipi == "") {

        $cari_id = $_POST["cari_id"];
        $fatura_bilgi_ilk = DB::single_query("SELECT genel_toplam FROM alis_default WHERE status=1 AND id='$fatura_id'");
        if (isset($_POST["ilk_tutar"])) {
            $fark = floatval($_POST["ilk_tutar"]) - $fatura_bilgi_ilk["genel_toplam"];
            $cari_bilgileri = DB::single_query("SELECT alacak,borc FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
            $yeni_alacak = floatval($cari_bilgileri["alacak"]) - $fark;
            $arr3 = [
                'alacak' => $yeni_alacak,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $cari_guncelle = DB::update("cari", "id", $cari_id, $arr3);
            unset($_POST["ilk_tutar"]);
        } else {
            $fatura_bilgi = DB::single_query("SELECT genel_toplam FROM alis_default WHERE status=1 AND id='$fatura_id'");
            $cari_bilgileri_getir = DB::single_query("SELECT borc,alacak FROM cari WHERE status=1 AND id='$cari_id'");
            $cari_alacak_miktar = $cari_bilgileri_getir["alacak"];
            $yeni_alacak = floatval($cari_alacak_miktar) + floatval($fatura_bilgi["genel_toplam"]);
            $cari_arr = [
                'alacak' => $yeni_alacak,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $cari_alacaklandir = DB::update("cari", "id", $cari_id, $cari_arr);
            unset($_POST["ilk_tutar"]);
        }
        unset($_POST["muhtelif_tipi"]);

        $cari_kodu = $_POST["cari_kodu"];
        $caridemi = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_kodu='$cari_kodu'");
        if ($caridemi > 0) {
            unset($_POST["cari_kodu"]);
        } else {
            $uyedemi = DB::single_query("SELECT * FROM uye_tanim WHERE status=1 AND cari_key='$cari_key' AND tc_no='$cari_kodu'");
            if ($uyedemi > 0) {
                unset($_POST["cari_kodu"]);
                unset($_POST["cari_id"]);
                $_POST["uye_id"] = $uyedemi["id"];
                $arr = [
                    'cari_id' => 0
                ];
                $guncelle = DB::update("alis_default", "id", $fatura_id, $arr);
            }
        }
        $faturayi_olustur = DB::update("alis_default", "id", $fatura_id, $_POST);

        if ($faturayi_olustur) {
            echo 1;
        } else {
            echo 2;
        }

    } else {
        unset($_POST["muhtelif_tipi"]);
        $fatura_bilgi_ilk = DB::single_query("SELECT genel_toplam FROM alis_muhtelif WHERE status=1 AND id='$fatura_id'");
        if (isset($_POST["ilk_tutar"])) {
            $fark = floatval($_POST["ilk_tutar"]) - $fatura_bilgi_ilk["genel_toplam"];
            $cari_bilgileri = DB::single_query("SELECT alacak,borc FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
            $yeni_alacak = floatval($cari_bilgileri["alacak"]) + $fark;
            $arr3 = [
                'alacak' => $yeni_alacak,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $cari_guncelle = DB::update("cari", "id", $cari_id, $arr3);
            unset($_POST["ilk_tutar"]);
        } else {
            $cari_id = $_POST["cari_id"];
            $fatura_bilgi = DB::single_query("SELECT genel_toplam FROM alis_muhtelif WHERE status=1 AND id='$fatura_id'");
            $cari_bilgileri_getir = DB::single_query("SELECT borc,alacak FROM cari WHERE status=1 AND id='$cari_id'");
            $cari_alacak_miktar = $cari_bilgileri_getir["alacak"];
            $yeni_alacak = floatval($cari_alacak_miktar) + floatval($fatura_bilgi["genel_toplam"]);
            $cari_arr = [
                'alacak' => $yeni_alacak,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $cari_alacaklandir = DB::update("cari", "id", $cari_id, $cari_arr);
            unset($_POST["ilk_tutar"]);
        }
        $fatura_no = DB::single_query("SELECT * FROM alis_muhtelif WHERE status=1 AND fatura_no='$fatura_no' and cari_key='$cari_key' $ek_sorgu");
        if ($fatura_no > 0) {
            echo 300;
        } else {
            $faturayi_olustur = DB::update("alis_muhtelif", "id", $fatura_id, $_POST);
            if ($faturayi_olustur) {
                echo 1;
            } else {
                echo 2;
            }

        }

    }

}

if ($islem == "faturaya_urun_ekle_sql") {

    $_POST["insert_userid"] = $_SESSION["user_id"];

    $_POST["insert_datetime"] = date("Y-m-d H:i:s");


    $cari_id = $_POST["cari_id"];

    $doviz_tur = $_POST["doviz_tur"];

    unset($_POST["doviz_tur"]);

    unset($_POST["cari_id"]);

    if ($_POST["alis_defaultid"] == "") {

        $arr = [

            'insert_userid' => $_SESSION["user_id"],

            'insert_datetime' => date("Y-m-d H:i:s"),

            'cari_id' => $cari_id,

            'cari_key' => $cari_key,

            'doviz_tur' => $doviz_tur,

            'sube_key' => $_SESSION["sube_key"]

        ];

        $faturayi_olustur = DB::insert("alis_default", $arr);

        $son_eklenen = DB::single_query("SELECT id FROM alis_default where cari_key='$cari_key' $ek_sorgu ORDER BY id DESC LIMIT 1");

        $fatura_id = $son_eklenen["id"];

        $_POST["alis_defaultid"] = $fatura_id;

    }

    $fatura_id = $_POST["alis_defaultid"];

    $kdv_tutar = $_POST["kdv_tutari"];

    $iskonto_tutari = $_POST["iskonto_tutari"];

    $toplam_tutar = $_POST["toplam_tutar"];

    $tevkifat_tutari = $_POST["tevkifat_tutari"];

    $ara_toplam = 0;

    if ($_POST["iskonto"] != 0) {

        $yeni_fiyat = $_POST["birim_fiyat"] - $iskonto_tutari;

        $ara_toplam = $yeni_fiyat * $_POST["miktar"];

    } else {

        $ara_toplam = $_POST["miktar"] * $_POST["birim_fiyat"];

    }


    $fatura_toplam_bilgiler = DB::single_query("SELECT * FROM alis_default WHERE id='$fatura_id' and cari_key='$cari_key' $ek_sorgu");

    if ($fatura_toplam_bilgiler > 0) {

        $faturadaki_kdv = $fatura_toplam_bilgiler["kdv_toplam"];

        $faturadaki_iskonto = $fatura_toplam_bilgiler["iskonto_toplam"];

        $fatura_ara_toplam = $fatura_toplam_bilgiler["ara_toplam"];

        $fatura_genel_toplam = $fatura_toplam_bilgiler["genel_toplam"];

        $tevkifat_toplami = $fatura_toplam_bilgiler["tevkifat_toplam"];


        $faturaya_urun_ekle = DB::insert("alis_urunler", $_POST);

        if ($faturaya_urun_ekle) {

            echo 500;

        } else {


            $yeni_kdv_tutar = $faturadaki_kdv + $kdv_tutar;

            $yeni_iskonto_tutar = $faturadaki_iskonto + $iskonto_tutari;

            $yeni_toplam_tutar = $fatura_genel_toplam + $toplam_tutar;

            $yeni_ara_toplam = $fatura_ara_toplam + $ara_toplam;

            $yeni_tevkifat_toplam = $tevkifat_toplami + $tevkifat_tutari;

            $arr = [

                'iskonto_toplam' => $yeni_iskonto_tutar,

                'kdv_toplam' => $yeni_kdv_tutar,

                'ara_toplam' => $yeni_ara_toplam,

                'genel_toplam' => $yeni_toplam_tutar,

                'tevkifat_toplam' => $yeni_tevkifat_toplam,

                'cari_key' => $_SESSION["cari_key"],

                'sube_key' => $_SESSION["sube_key"]

            ];


            $fatura_miktarlarini_guncelle = DB::update("alis_default", "id", $fatura_id, $arr);

            if ($fatura_miktarlarini_guncelle) {

                $faturadaki_urunler = DB::all_data("

SELECT alis_urunler.*,stok.stok_kodu,stok.stok_adi,birim.birim_adi,alis_default.iskonto_toplam,alis_default.kdv_toplam,alis_default.ara_toplam,

       alis_default.genel_toplam,alis_default.tevkifat_toplam,alis_default.doviz_tur

FROM 

     alis_urunler

INNER JOIN stok ON stok.id=alis_urunler.stok_id

INNER JOIN birim ON birim.id=alis_urunler.birim_id

INNER JOIN alis_default ON alis_default.id=alis_urunler.alis_defaultid

WHERE 

      alis_urunler.status=1 

AND 

      alis_urunler.alis_defaultid='$fatura_id' and alis_urunler.cari_key='$cari_key'");

                if ($faturadaki_urunler > 0) {
                    $stok_id = $_POST["stok_id"];
                    $stok_miktar_bilgileri = DB::single_query("SELECT * FROM stok where status=1 AND id='$stok_id' and cari_key='$cari_key'");
                    $stokdaki_miktar = $stok_miktar_bilgileri["giren_miktar"];
                    $gonderilen_miktar = $_POST["miktar"];
                    $yeni_miktar = $stokdaki_miktar + $gonderilen_miktar;
                    $stok_miktari_arr = [
                        'giren_miktar' => $yeni_miktar,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];
                    $stok_miktarini_guncelle = DB::update("stok", "id", $stok_id, $stok_miktari_arr);
                    if ($stok_miktarini_guncelle) {
                        echo json_encode($faturadaki_urunler);
                    } else {
                        echo 2;
                    }

                } else {

                    echo 2;

                }

            } else {

                echo 500;

            }

        }

    }

}

if ($islem == "urunu_faturadan_cikart") {

    $id = $_POST["id"];

    $fatura_id = $_POST["fatura_id"];

    $_POST["delete_userid"] = $_SESSION["user_id"];

    $_POST["status"] = 0;

    $_POST["delete_datetime"] = date("Y-m-d H:i:s");

    $_POST["delete_detail"] = "Kullanıcı Faturayı Oluştururken Silmiştir";


    $urun_bilgileri = DB::single_query("SELECT * FROM alis_urunler WHERE status=1 AND id='$id' and cari_key='$cari_key' $ek_sorgu");

    $fatura_bilgileri = DB::single_query("SELECT * FROM alis_default WHERE status=1 AND id='$fatura_id'  and cari_key='$cari_key' $ek_sorgu");


    $faturadaki_kdv = $fatura_bilgileri["kdv_toplam"];

    $faturadaki_iskonto = $fatura_bilgileri["iskonto_toplam"];

    $faturadaki_ara_toplam = $fatura_bilgileri["ara_toplam"];

    $faturadaki_genel_toplam = $fatura_bilgileri["genel_toplam"];

    $faturadaki_tevkifat_toplam = $fatura_bilgileri["tevkifat_toplam"];


    $urun_kdv = $urun_bilgileri["kdv_tutari"];

    $urun_iskonto = $urun_bilgileri["iskonto_tutari"];

    $ara_toplam = 0;

    if ($urun_iskonto != 0) {

        $yeni_tutar = $urun_bilgileri["birim_fiyat"] - $urun_bilgileri["iskonto_tutari"];

        $ara_toplam = $yeni_tutar * $urun_bilgileri["miktar"];

    } else {

        $ara_toplam = $urun_bilgileri["miktar"] * $urun_bilgileri["birim_fiyat"];

    }

    $urun_genel_toplam = $urun_bilgileri["toplam_tutar"];

    $urun_tevkifat_toplam = $urun_bilgileri["tevkifat_tutari"];


    $yeni_kdv = $faturadaki_kdv - $urun_kdv;

    $yeni_iskonto = $faturadaki_iskonto - $urun_iskonto;

    $yeni_ara_toplam = $faturadaki_ara_toplam - $ara_toplam;

    $yeni_genel_toplam = $faturadaki_genel_toplam - $urun_genel_toplam;

    $yeni_tevkifat_toplam = $faturadaki_tevkifat_toplam - $urun_tevkifat_toplam;

    $arr = [

        'iskonto_toplam' => $yeni_iskonto,

        'kdv_toplam' => $yeni_kdv,

        'ara_toplam' => $yeni_ara_toplam,

        'genel_toplam' => $yeni_genel_toplam,

        'tevkifat_toplam' => $yeni_tevkifat_toplam

    ];


    $fatura_miktari_guncelle = DB::update("alis_default", "id", $fatura_id, $arr);

    if ($fatura_miktari_guncelle) {

        if ($_POST["fatura_turu"] == "default") {

            unset($_POST["fatura_turu"]);

            unset($_POST["fatura_id"]);

            $urunu_faturadan_cikart = DB::update("alis_urunler", "id", $id, $_POST);

            if ($urunu_faturadan_cikart) {

                $faturadaki_urunler = DB::all_data("

SELECT alis_urunler.*,stok.stok_kodu,stok.stok_adi,birim.birim_adi,alis_default.iskonto_toplam,alis_default.kdv_toplam,alis_default.ara_toplam,

       alis_default.genel_toplam,alis_default.tevkifat_toplam,alis_default.doviz_tur

FROM 

     alis_urunler

INNER JOIN stok ON stok.id=alis_urunler.stok_id

INNER JOIN birim ON birim.id=alis_urunler.birim_id

INNER JOIN alis_default ON alis_default.id=alis_urunler.alis_defaultid

WHERE 

      alis_urunler.status=1 

AND 

      alis_urunler.alis_defaultid='$fatura_id'  and alis_urunler.cari_key='$cari_key'");
                if ($faturadaki_urunler > 0) {
                    $stok_id = $urun_bilgileri["stok_id"];
                    $stok_miktari = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");
                    if ($stok_miktari > 0) {
                        $stok_giren_miktar = $stok_miktari["giren_miktar"];
                        $vt_miktar = $urun_bilgileri["miktar"];
                        $yeni_miktar = $stok_giren_miktar - $vt_miktar;
                        $miktar_arr = [
                            'giren_miktar' => $yeni_miktar,
                            'update_userid' => $_SESSION["user_id"],
                            'update_datetime' => date("Y-m-d H:i:s")
                        ];
                        $veritabani_miktar_guncelle = DB::update("stok", "id", $stok_id, $miktar_arr);
                        if ($veritabani_miktar_guncelle) {
                            echo json_encode($faturadaki_urunler);
                        } else {
                            echo 2;
                        }
                    } else {
                        echo 2;
                    }
                } else {
                    $stok_id = $urun_bilgileri["stok_id"];
                    $stok_miktari = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");
                    if ($stok_miktari > 0) {
                        $stok_giren_miktar = $stok_miktari["giren_miktar"];
                        $vt_miktar = $urun_bilgileri["miktar"];
                        $yeni_miktar = $stok_giren_miktar - $vt_miktar;
                        $miktar_arr = [
                            'giren_miktar' => $yeni_miktar,
                            'update_userid' => $_SESSION["user_id"],
                            'update_datetime' => date("Y-m-d H:i:s")
                        ];
                        $veritabani_miktar_guncelle = DB::update("stok", "id", $stok_id, $miktar_arr);
                        if ($veritabani_miktar_guncelle) {
                            echo 2;
                        } else {
                            echo 500;
                        }
                    } else {
                        echo 500;
                    }
                }
            } else {
                echo 500;
            }
        }
    } else {
        echo 500;
    }
}
if ($islem == "muhtelif_faturdan_urunu_cikart") {

    $id = $_POST["id"];

    $fatura_id = $_POST["fatura_id"];

    $_POST["delete_userid"] = $_SESSION["user_id"];

    $_POST["status"] = 0;

    $_POST["delete_datetime"] = date("Y-m-d H:i:s");

    $_POST["delete_detail"] = "Kullanıcı Faturayı Oluştururken Silmiştir";


    $urun_bilgileri = DB::single_query("SELECT * FROM alis_urunler WHERE status=1 AND id='$id'  and cari_key='$cari_key' $ek_sorgu");

    $fatura_bilgileri = DB::single_query("SELECT * FROM alis_muhtelif WHERE status=1 AND id='$fatura_id'  and cari_key='$cari_key' $ek_sorgu");


    $faturadaki_kdv = $fatura_bilgileri["kdv_toplam"];

    $faturadaki_iskonto = $fatura_bilgileri["iskonto_toplam"];

    $faturadaki_ara_toplam = $fatura_bilgileri["ara_toplam"];

    $faturadaki_genel_toplam = $fatura_bilgileri["genel_toplam"];

    $faturadaki_tevkifat_toplam = $fatura_bilgileri["tevkifat_toplam"];


    $urun_kdv = $urun_bilgileri["kdv_tutari"];

    $urun_iskonto = $urun_bilgileri["iskonto_tutari"];

    $ara_toplam = 0;

    if ($urun_iskonto != 0) {

        $yeni_tutar = $urun_bilgileri["birim_fiyat"] - $urun_bilgileri["iskonto_tutari"];

        $ara_toplam = $yeni_tutar * $urun_bilgileri["miktar"];

    } else {

        $ara_toplam = $urun_bilgileri["miktar"] * $urun_bilgileri["birim_fiyat"];

    }

    $urun_genel_toplam = $urun_bilgileri["toplam_tutar"];

    $urun_tevkifat_toplam = $urun_bilgileri["tevkifat_tutari"];


    $yeni_kdv = $faturadaki_kdv - $urun_kdv;

    $yeni_iskonto = $faturadaki_iskonto - $urun_iskonto;

    $yeni_ara_toplam = $faturadaki_ara_toplam - $ara_toplam;

    $yeni_genel_toplam = $faturadaki_genel_toplam - $urun_genel_toplam;

    $yeni_tevkifat_toplam = $faturadaki_tevkifat_toplam - $urun_tevkifat_toplam;

    $arr = [

        'iskonto_toplam' => $yeni_iskonto,

        'kdv_toplam' => $yeni_kdv,

        'ara_toplam' => $yeni_ara_toplam,

        'genel_toplam' => $yeni_genel_toplam,

        'tevkifat_toplam' => $yeni_tevkifat_toplam

    ];


    $fatura_miktari_guncelle = DB::update("alis_muhtelif", "id", $fatura_id, $arr);


    if ($fatura_miktari_guncelle) {

        if ($_POST["fatura_turu"] == "muhtelif") {

            unset($_POST["fatura_turu"]);

            unset($_POST["fatura_id"]);

            $urunu_faturadan_cikart = DB::update("alis_urunler", "id", $id, $_POST);

            if ($urunu_faturadan_cikart) {

                $faturadaki_urunler = DB::all_data("

SELECT alis_urunler.*,stok.stok_kodu,stok.stok_adi,birim.birim_adi,alis_muhtelif.iskonto_toplam,alis_muhtelif.kdv_toplam,alis_muhtelif.ara_toplam,

       alis_muhtelif.genel_toplam,alis_muhtelif.tevkifat_toplam,alis_muhtelif.doviz_tur

FROM 

     alis_urunler

INNER JOIN stok ON stok.id=alis_urunler.stok_id

INNER JOIN birim ON birim.id=alis_urunler.birim_id

INNER JOIN alis_muhtelif ON alis_muhtelif.id=alis_urunler.alis_muhtelifid

WHERE 

      alis_urunler.status=1 

AND 

      alis_urunler.alis_muhtelifid='$fatura_id'  and alis_urunler.cari_key='$cari_key' ");

                if ($faturadaki_urunler > 0) {
                    $stok_id = $urun_bilgileri["stok_id"];
                    $stok_miktari = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");
                    if ($stok_miktari > 0) {
                        $stok_giren_miktar = $stok_miktari["giren_miktar"];
                        $vt_miktar = $urun_bilgileri["miktar"];
                        $yeni_miktar = $stok_giren_miktar - $vt_miktar;
                        $miktar_arr = [
                            'giren_miktar' => $yeni_miktar,
                            'update_userid' => $_SESSION["user_id"],
                            'update_datetime' => date("Y-m-d H:i:s")
                        ];
                        $veritabani_miktar_guncelle = DB::update("stok", "id", $stok_id, $miktar_arr);
                        if ($veritabani_miktar_guncelle) {
                            echo json_encode($faturadaki_urunler);
                        } else {
                            echo 501;
                        }
                    } else {
                        echo 502;
                    }

                } else {
                    $stok_id = $urun_bilgileri["stok_id"];
                    $stok_miktari = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");
                    if ($stok_miktari > 0) {
                        $stok_giren_miktar = $stok_miktari["giren_miktar"];
                        $vt_miktar = $urun_bilgileri["miktar"];
                        $yeni_miktar = $stok_giren_miktar - $vt_miktar;
                        $miktar_arr = [
                            'giren_miktar' => $yeni_miktar,
                            'update_userid' => $_SESSION["user_id"],
                            'update_datetime' => date("Y-m-d H:i:s")
                        ];
                        $veritabani_miktar_guncelle = DB::update("stok", "id", $stok_id, $miktar_arr);
                        if ($veritabani_miktar_guncelle) {
                            echo 2;
                        } else {
                            echo 500;
                        }
                    } else {
                        echo 502;
                    }
                }

            } else {

                echo 500;

            }

        }

    } else {

        echo 500;

    }

}
if ($islem == "muhtelif_faturaya_urun_ekle") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $cari_id = $_POST["cari_id"];
    $doviz_tur = $_POST["doviz_tur"];
    unset($_POST["doviz_tur"]);
    unset($_POST["cari_id"]);
    if ($_POST["alis_muhtelifid"] == "") {
        $arr = [
            'insert_userid' => $_SESSION["user_id"],
            'insert_datetime' => date("Y-m-d H:i:s"),
            'cari_id' => $cari_id,
            'doviz_tur' => $doviz_tur,
            'cari_key' => $cari_key,
            'sube_key' => $sube_key
        ];
        $faturayi_olustur = DB::insert("alis_muhtelif", $arr);
        $son_eklenen = DB::single_query("SELECT id FROM alis_muhtelif where cari_key='$cari_key' and sube_key='$sube_key' ORDER BY id DESC LIMIT 1");
        $fatura_id = $son_eklenen["id"];
        $_POST["alis_muhtelifid"] = $fatura_id;
    }
    $fatura_id = $_POST["alis_muhtelifid"];
    $faturaya_urun_ekle = DB::insert("alis_urunler", $_POST);
    $kdv_tutar = $_POST["kdv_tutari"];
    $iskonto_tutari = $_POST["iskonto_tutari"];
    $toplam_tutar = $_POST["toplam_tutar"];
    $tevkifat_tutari = $_POST["tevkifat_tutari"];
    $ara_toplam = 0;
    if ($_POST["iskonto"] != 0) {
        $yeni_fiyat = $_POST["birim_fiyat"] - $iskonto_tutari;
        $ara_toplam = $yeni_fiyat * $_POST["miktar"];
    } else {
        $ara_toplam = $_POST["miktar"] * $_POST["birim_fiyat"];
    }
    $fatura_toplam_bilgiler = DB::single_query("SELECT * FROM alis_muhtelif where  id='$fatura_id' and cari_key='$cari_key' $ek_sorgu");
    if ($fatura_toplam_bilgiler > 0) {
        if ($faturaya_urun_ekle) {
            echo 500;
        } else {
            $faturadaki_kdv = $fatura_toplam_bilgiler["kdv_toplam"];
            $faturadaki_iskonto = $fatura_toplam_bilgiler["iskonto_toplam"];
            $fatura_ara_toplam = $fatura_toplam_bilgiler["ara_toplam"];
            $fatura_genel_toplam = $fatura_toplam_bilgiler["genel_toplam"];
            $tevkifat_toplami = $fatura_toplam_bilgiler["tevkifat_toplam"];
            $yeni_kdv_tutar = $faturadaki_kdv + $kdv_tutar;
            $yeni_iskonto_tutar = $faturadaki_iskonto + $iskonto_tutari;
            $yeni_toplam_tutar = $fatura_genel_toplam + $toplam_tutar;
            $yeni_ara_toplam = $fatura_ara_toplam + $ara_toplam;
            $yeni_tevkifat_toplam = $tevkifat_toplami + $tevkifat_tutari;
            $arr = [
                'iskonto_toplam' => $yeni_iskonto_tutar,
                'kdv_toplam' => $yeni_kdv_tutar,
                'ara_toplam' => $yeni_ara_toplam,
                'genel_toplam' => $yeni_toplam_tutar,
                'tevkifat_toplam' => $yeni_tevkifat_toplam
            ];
            $fatura_miktarlarini_guncelle = DB::update("alis_muhtelif", "id", $fatura_id, $arr);
            if ($fatura_miktarlarini_guncelle) {
                $faturadaki_urunler = DB::all_data("
                SELECT alis_urunler.*,stok.stok_kodu,stok.stok_adi,birim.birim_adi,alis_muhtelif.iskonto_toplam,alis_muhtelif.kdv_toplam,alis_muhtelif.ara_toplam,
       alis_muhtelif.genel_toplam,alis_muhtelif.tevkifat_toplam,alis_muhtelif.doviz_tur
FROM 
     alis_urunler
INNER JOIN stok ON stok.id=alis_urunler.stok_id
INNER JOIN birim ON birim.id=alis_urunler.birim_id
INNER JOIN alis_muhtelif ON alis_muhtelif.id=alis_urunler.alis_muhtelifid
WHERE 
      alis_urunler.status=1 
AND 
      alis_urunler.alis_muhtelifid='$fatura_id' and alis_urunler.cari_key='$cari_key'");
                if ($faturadaki_urunler > 0) {
                    $stok_id = $_POST["stok_id"];
                    $stok_miktar_bilgileri = DB::single_query("SELECT * FROM stok where status=1 AND id='$stok_id' and cari_key='$cari_key'");
                    $stokdaki_miktar = $stok_miktar_bilgileri["giren_miktar"];
                    $gonderilen_miktar = $_POST["miktar"];
                    $yeni_miktar = floatval($gonderilen_miktar) + floatval($stokdaki_miktar);
                    $stok_miktari_arr = [
                        'giren_miktar' => $yeni_miktar,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];
                    $stok_miktarini_guncelle = DB::update("stok", "id", $stok_id, $stok_miktari_arr);
                    if ($stok_miktarini_guncelle) {
                        echo json_encode($faturadaki_urunler);
                    } else {
                        echo 2;
                    }
                } else {
                    echo 2;
                }
            } else {
                echo 500;
            }
        }
    }
}
if ($islem == "faturadaki_urunun_bilgilerini_getir") {

    $id = $_GET["id"];

    $fatura_urun_bilgileri = DB::single_query(

        "

SELECT alis_urunler.*,stok.stok_kodu,stok.stok_adi,birim.birim_adi,stok.birim

FROM 

     alis_urunler

INNER JOIN stok ON stok.id=alis_urunler.stok_id

INNER JOIN birim ON birim.id=alis_urunler.birim_id

WHERE 

      alis_urunler.status=1 

AND 

      alis_urunler.id='$id'"

    );

    if ($fatura_urun_bilgileri > 0) {

        echo json_encode($fatura_urun_bilgileri);

    } else {

        echo 2;

    }

}

if ($islem == "faturadaki_urunu_guncelle") {

    $id = $_POST["id"];
    $miktar_fark = $_POST["miktar_farki"];
    unset($_POST["miktar_farki"]);

    $_POST["update_userid"] = $_SESSION["user_id"];

    $_POST["update_datetime"] = date("Y-m-d H:i:s");

    if (isset($_POST["alis_defaultid"])) {

        $fatura_id = $_POST["alis_defaultid"];

        $fatura_bilgileri = DB::single_query("SELECT * FROM alis_default WHERE status=1 AND id='$fatura_id'  and cari_key='$cari_key' $ek_sorgu");

        if ($fatura_bilgileri > 0) {

            $faturadaki_genel_toplam = $fatura_bilgileri["genel_toplam"];

            $faturadaki_iskonto_toplam = $fatura_bilgileri["iskonto_toplam"];

            $faturadaki_kdv_toplam = $fatura_bilgileri["kdv_toplam"];

            $fatura_ara_toplam = $fatura_bilgileri["ara_toplam"];

            $fatura_tevkifat_toplam = $fatura_bilgileri["tevkifat_toplam"];

            $arr = [
                'genel_toplam' => $faturadaki_genel_toplam + $_POST["tutar_fark"],
                'tevkifat_toplam' => $fatura_tevkifat_toplam + $_POST["tevkifat_fark"],
                'ara_toplam' => $fatura_ara_toplam + $_POST["ara_toplam_fark"],
                'kdv_toplam' => $faturadaki_kdv_toplam + $_POST["kdv_fark"],
                'iskonto_toplam' => $faturadaki_iskonto_toplam + $_POST["iskonto_fark"]
            ];

            $ana_faturayi_guncelle = DB::update("alis_default", "id", $fatura_id, $arr);
            if ($ana_faturayi_guncelle) {
                unset($_POST["kdv_fark"]);
                unset($_POST["iskonto_fark"]);
                unset($_POST["tutar_fark"]);
                unset($_POST["tevkifat_fark"]);
                unset($_POST["ara_toplam_fark"]);
                $urunleri_guncelle = DB::update("alis_urunler", "id", $id, $_POST);

                if ($urunleri_guncelle) {
                    $faturadaki_urunler = DB::all_data("
SELECT alis_urunler.*,stok.stok_kodu,stok.stok_adi,birim.birim_adi,alis_default.iskonto_toplam,alis_default.kdv_toplam,alis_default.ara_toplam,
       alis_default.genel_toplam,alis_default.tevkifat_toplam,alis_default.doviz_tur
FROM 
     alis_urunler
INNER JOIN stok ON stok.id=alis_urunler.stok_id
INNER JOIN birim ON birim.id=alis_urunler.birim_id
INNER JOIN alis_default ON alis_default.id=alis_urunler.alis_defaultid
WHERE 
      alis_urunler.status=1 
AND 
      alis_urunler.alis_defaultid='$fatura_id'  and alis_urunler.cari_key='$cari_key'");
                    if ($faturadaki_urunler > 0) {
                        $stok_id = $_POST["stok_id"];
                        $stok_envanter_bilgileri = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");
                        if ($stok_envanter_bilgileri > 0) {
                            $envanter_miktar = $stok_envanter_bilgileri["giren_miktar"];
                            $yeni_miktar = intval($miktar_fark) + intval($envanter_miktar);
                            $arr_envanter_miktar = [
                                'giren_miktar' => $yeni_miktar,
                                'update_userid' => $_SESSION["user_id"],
                                'update_datetime' => date("Y-m-d H:i:s")
                            ];
                            $urun_miktarini_guncelle = DB::update("stok", "id", $stok_id, $arr_envanter_miktar);
                            if ($urun_miktarini_guncelle) {
                                echo json_encode($faturadaki_urunler);
                            } else {
                                echo 502;
                            }
                        } else {
                            echo 505;
                        }
                    } else {
                        echo 2;
                    }
                } else {
                    echo 500;
                }
            } else {
                echo 500;
            }
        } else {
            echo 500;
        }
    } else {
        $fatura_id = $_POST["alis_muhtelifid"];
        $fatura_bilgileri = DB::single_query("SELECT * FROM alis_muhtelif WHERE status=1 AND id='$fatura_id'  and cari_key='$cari_key' $ek_sorgu");
        if ($fatura_bilgileri > 0) {
            $faturadaki_genel_toplam = $fatura_bilgileri["genel_toplam"];
            $faturadaki_iskonto_toplam = $fatura_bilgileri["iskonto_toplam"];
            $faturadaki_kdv_toplam = $fatura_bilgileri["kdv_toplam"];
            $fatura_ara_toplam = $fatura_bilgileri["ara_toplam"];
            $fatura_tevkifat_toplam = $fatura_bilgileri["tevkifat_toplam"];
            $arr = [
                'genel_toplam' => $faturadaki_genel_toplam + $_POST["tutar_fark"],
                'tevkifat_toplam' => $fatura_tevkifat_toplam + $_POST["tevkifat_fark"],
                'ara_toplam' => $fatura_ara_toplam + $_POST["ara_toplam_fark"],
                'kdv_toplam' => $faturadaki_kdv_toplam + $_POST["kdv_fark"],
                'iskonto_toplam' => $faturadaki_iskonto_toplam + $_POST["iskonto_fark"]
            ];
            $ana_faturayi_guncelle = DB::update("alis_muhtelif", "id", $fatura_id, $arr);
            if ($ana_faturayi_guncelle) {
                unset($_POST["kdv_fark"]);
                unset($_POST["iskonto_fark"]);
                unset($_POST["tutar_fark"]);
                unset($_POST["tevkifat_fark"]);
                unset($_POST["ara_toplam_fark"]);
                $urunleri_guncelle = DB::update("alis_urunler", "id", $id, $_POST);
                if ($urunleri_guncelle) {
                    $faturadaki_urunler = DB::all_data("
SELECT alis_urunler.*,stok.stok_kodu,stok.stok_adi,birim.birim_adi,alis_muhtelif.iskonto_toplam,alis_muhtelif.kdv_toplam,alis_muhtelif.ara_toplam,
       alis_muhtelif.genel_toplam,alis_muhtelif.tevkifat_toplam,alis_muhtelif.doviz_tur
FROM 
     alis_urunler
INNER JOIN stok ON stok.id=alis_urunler.stok_id
INNER JOIN birim ON birim.id=alis_urunler.birim_id
INNER JOIN alis_muhtelif ON alis_muhtelif.id=alis_urunler.alis_muhtelifid
WHERE 
      alis_urunler.status=1 
AND 
      alis_urunler.alis_muhtelifid='$fatura_id'  and alis_urunler.cari_key='$cari_key'");

                    if ($faturadaki_urunler > 0) {
                        $stok_id = $_POST["stok_id"];
                        $stok_envanter_bilgileri = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");
                        if ($stok_envanter_bilgileri > 0) {
                            $envanter_miktar = $stok_envanter_bilgileri["giren_miktar"];
                            $yeni_miktar = intval($miktar_fark) + intval($envanter_miktar);
                            $arr_envanter_miktar = [
                                'giren_miktar' => $yeni_miktar,
                                'update_userid' => $_SESSION["user_id"],
                                'update_datetime' => date("Y-m-d H:i:s")
                            ];
                            $urun_miktarini_guncelle = DB::update("stok", "id", $stok_id, $arr_envanter_miktar);
                            if ($urun_miktarini_guncelle) {
                                echo json_encode($faturadaki_urunler);
                            } else {
                                echo 502;
                            }
                        } else {
                            echo 505;
                        }

                    } else {

                        echo 2;

                    }

                } else {

                    echo 500;

                }

            } else {

                echo 500;

            }

        } else {

            echo 500;

        }

    }

}

if ($islem == "faturayi_iptal_et_sql") {
    $gonderilen_id = $_POST["id"];
    $_POST["delete_detail"] = "Kullanıcı Fatura Oluşturulurken Vazgeçmiştir";
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $default_sorgu = DB::single_query("SELECT * FROM alis_default WHERE status=1 AND id='$gonderilen_id'  and cari_key='$cari_key'");
    if ($default_sorgu > 0) {
        unset($_POST["id"]);
        $explode_ids = explode(",", $default_sorgu["irsaliye_ids"]);
        foreach ($explode_ids as $irsaliye_id) {
            $maini = DB::single_query("SELECT * FROM alis_irsaliye_urunler WHERE id='$irsaliye_id'");
            $arr = [
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s"),
                'status' => 1
            ];
            $guncelle = DB::update("alis_irsaliye", "id", $maini["irsaliye_id"], $arr);
        }
        $explode_ids = explode(",", $default_sorgu["depo_ids"]);
        foreach ($explode_ids as $irsaliye_id) {
            $arr = [
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s"),
                'depo_alis_kesildi' => 0
            ];
            $guncelle = DB::update("depo_konteyner_cikis", "id", $irsaliye_id, $arr);
        }
        $explode_ids = explode(",", $default_sorgu["kiralik_cikis_depo_ids"]);
        foreach ($explode_ids as $irsaliye_id) {
            $arr = [
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s"),
                'kiralik_alis_kesildi' => 0
            ];
            $guncelle = DB::update("depo_konteyner_cikis", "id", $irsaliye_id, $arr);
        }
        $explode_ids = explode(",", $default_sorgu["kiralik_depo_ids"]);
        foreach ($explode_ids as $irsaliye_id) {
            $arr = [
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s"),
                'kiralik_arac_kesildi' => 0
            ];
            $guncelle = DB::update("depo_konteyner_giris", "id", $irsaliye_id, $arr);
        }
        $explode_ids3 = explode(",", $default_sorgu["ek_hizmet_ids"]);
        if ($default_sorgu["irsaliye_ids"] == "" || $default_sorgu == null) {
            $faturadaki_urunler = DB::all_data("SELECT stok_id,miktar FROM alis_urunler WHERE status=1 AND alis_defaultid='$gonderilen_id'");
            foreach ($faturadaki_urunler as $urunler) {
                $stok_id = $urunler["stok_id"];
                $miktar = $urunler["miktar"];
                $stoktaki_urun_miktari = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");
                $yeni_miktar = $stoktaki_urun_miktari["giren_miktar"] - $miktar;
                $stok_miktar_arr = [
                    'giren_miktar' => $yeni_miktar,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $stok_miktarini_guncelle = DB::update("stok", "id", $stok_id, $stok_miktar_arr);
            }
            if ($stok_miktarini_guncelle) {
                $faturayi_sil = DB::update("alis_default", "id", $gonderilen_id, $_POST);
                if ($faturayi_sil) {

                    foreach ($explode_ids3 as $irsaliye_id1) {
                        $arr = [
                            'update_userid' => $_SESSION["user_id"],
                            'update_datetime' => date("Y-m-d H:i:s"),
                            'alis_status' => 1
                        ];
                        $guncelle = DB::update("konteyner_irsaliye_ek_hizmet", "id", $irsaliye_id1, $arr);
                    }

                    echo 1;
                } else {
                    echo 2;
                }
            } else {
                echo 2;
            }
        } else {
            foreach ($explode_ids as $irsaliye_id) {
                $arr = [
                    'id' => $irsaliye_id,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s"),
                    'status' => 1
                ];
                $guncelle = DB::update("alis_irsaliye", "id", $irsaliye_id, $arr);
            }


            foreach ($explode_ids3 as $irsaliye_id1) {
                $arr = [
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s"),
                    'alis_status' => 1
                ];
                $guncelle = DB::update("konteyner_irsaliye_ek_hizmet", "id", $irsaliye_id1, $arr);
            }
            if ($guncelle) {
                $faturayi_sil = DB::update("alis_default", "id", $gonderilen_id, $_POST);
                if ($faturayi_sil) {
                    echo 1;
                } else {
                    echo 2;
                }
            } else {
                echo 2;
            }
        }
    } else {
        unset($_POST["id"]);
        $muhtelif_sorgu = DB::single_query("SELECT * FROM alis_muhtelif WHERE status=1 AND id='$gonderilen_id'  and cari_key='$cari_key' $ek_sorgu");
        $silinecek_id = $muhtelif_sorgu["id"];
        $faturayi_sil = DB::update("alis_muhtelif", "id", $silinecek_id, $_POST);
        if ($faturayi_sil) {
            $explode_ids = explode(",", $muhtelif_sorgu["irsaliye_ids"]);
            if ($default_sorgu["irsaliye_ids"] == "" || $default_sorgu == null) {
                $faturadaki_urunler = DB::all_data("SELECT stok_id,miktar FROM alis_urunler WHERE status=1 AND alis_muhtelifid='$gonderilen_id'");
                foreach ($faturadaki_urunler as $urunler) {
                    $stok_id = $urunler["stok_id"];
                    $miktar = $urunler["miktar"];
                    $stoktaki_urun_miktari = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");
                    $yeni_miktar = $stoktaki_urun_miktari["giren_miktar"] - $miktar;
                    echo $yeni_miktar;
                    $stok_miktar_arr = [
                        'giren_miktar' => $yeni_miktar,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];
                    $stok_miktarini_guncelle = DB::update("stok", "id", $stok_id, $stok_miktar_arr);
                }
                if ($stok_miktarini_guncelle) {
                    $faturayi_sil = DB::update("alis_muhtelif", "id", $gonderilen_id, $_POST);
                    if ($faturayi_sil) {
                        echo 1;
                    } else {
                        echo 2;
                    }
                } else {
                    echo 2;
                }
            } else {
                foreach ($explode_ids as $irsaliye_id) {
                    $arr = [
                        'id' => $irsaliye_id,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s"),
                        'status' => 1
                    ];
                    $guncelle = DB::update("alis_irsaliye", "id", $irsaliye_id, $arr);
                }
                if ($guncelle) {
                    echo 1;
                } else {
                    echo 2;
                }
            }
        } else {
            echo 2;
        }
    }
}
if ($islem == "guncel_kurlar") {


    $curl = curl_init();


    curl_setopt_array($curl, array(

        CURLOPT_URL => "https://www.tcmb.gov.tr/kurlar/today.xml",

        CURLOPT_RETURNTRANSFER => true,

        CURLOPT_ENCODING => "",

        CURLOPT_MAXREDIRS => 10,

        CURLOPT_TIMEOUT => 30,

        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

        CURLOPT_CUSTOMREQUEST => "GET",

        CURLOPT_HTTPHEADER => array(

            "cache-control: no-cache"

        ),

    ));


    $response = curl_exec($curl);

    $err = curl_error($curl);


    curl_close($curl);


    if ($err) {

        echo "cURL Hatası #:" . $err;

    } else {

        // XML dosyasını yükleme

        $xml = simplexml_load_string($response);


        // döviz kurlarını ayrı ayrı çekmek

        $usd = $xml->Currency[0]->BanknoteBuying; // USD kuru

        $eur = $xml->Currency[3]->BanknoteBuying; // EUR kuru

        $gbp = $xml->Currency[4]->BanknoteBuying; // GBP kuru


        $kurlar = [

            'USD' => $usd,

            'EUR' => $eur,

            'GBP' => $gbp

        ];

        echo json_encode($kurlar);

    }

}

if ($islem == "faturalari_getir_sql") {

    $merge_arr = [];

    $alis_faturalarini_getir = DB::all_data("

SELECT ad.*,d.depo_adi,c.cari_adi,c.cari_kodu,ut.uye_adi,ut.tc_no,ftt.fatura_turu_adi FROM alis_default as ad

LEFT JOIN depolar as d on d.id=ad.depo_id
LEFT JOIN cari as c on c.id=ad.cari_id
LEFT JOIN uye_tanim as ut on ut.id=ad.uye_id
LEFT JOIN fatura_tur_tanim AS ftt on ftt.id=ad.fatura_turu
WHERE ad.status=1  and ad.cari_key='$cari_key' $ek_sorgu_ad

");

    $tum_lastik_alis_faturalari = DB::all_data("
SELECT
       laf.*,
       c.cari_kodu,
       c.cari_adi
FROM
     lastik_alis_fatura as laf
INNER JOIN cari as c on c.id=laf.cari_id
WHERE laf.status=1 AND laf.cari_key='$cari_key'");

    $binek_yakit_faturalari = DB::all_data("
SELECT
       byf.fatura_no,
       byf.fatura_tarihi,
       c.cari_adi,
       c.cari_kodu,
       byf.aciklama,
       SUM(byc.tl_tutar) as tutar
FROM
     binek_yakit_fatura as byf
INNER JOIN binek_fis_faturasi as bff on bff.fatura_id=byf.id
INNER JOIN binek_yakit_cikis as byc on byc.id=bff.yakit_fis_id
INNER JOIN cari as c on c.id=byf.cari_id
WHERE
      byf.status=1 AND byf.cari_key='$cari_key' GROUP BY byf.id");


    if ($binek_yakit_faturalari > 0) {
        $binek_yakit_arr = [];
        foreach ($binek_yakit_faturalari as $item) {
            $tl_ara_toplam = $item["tutar"] / 1.20;
            $tl_kdv_toplam = $item["tutar"] - $tl_ara_toplam;
            $arr = [
                'fatura_no' => $item["fatura_no"],
                'fatura_turu_adi' => "",
                'fatura_tarihi' => $item["fatura_tarihi"],
                'cari_kodu' => $item["cari_kodu"],
                'cari_adi' => $item["cari_adi"],
                'tl_ara_toplam' => $tl_ara_toplam,
                'tl_kdv' => $tl_kdv_toplam,
                'tl_genel_toplam' => $item["tutar"],
                'doviz_tur' => 'TL',
                'doviz_kuru' => 1,
                'ara_toplam' => $tl_ara_toplam,
                'kdv_toplam' => $tl_kdv_toplam,
                'genel_toplam' => $item["tutar"],
                'yakit_faturasi' => 1,
                'vade_tarihi' => $item["fatura_tarihi"],
                'aciklama' => $item["aciklama"]
            ];
            array_push($binek_yakit_arr, $arr);
        }
    }


    if (!empty($tum_lastik_alis_faturalari)) {
        $merge_arr = array_merge($merge_arr, $tum_lastik_alis_faturalari);
    }
    if (!empty($alis_faturalarini_getir)) {
        $merge_arr = array_merge($merge_arr, $alis_faturalarini_getir);
    }
    if (!empty($gidecek_arr)) {
        $merge_arr = array_merge($merge_arr, $gidecek_arr);
    }

//    if ($tum_lastik_alis_faturalari > 0 && $alis_faturalarini_getir > 0) {
//        $merge_arr = array_merge($tum_lastik_alis_faturalari, $alis_faturalarini_getir);
//    } else if ($tum_lastik_alis_faturalari > 0) {
//        $merge_arr = $tum_lastik_alis_faturalari;
//    } else if ($alis_faturalarini_getir > 0) {
//        $merge_arr = $alis_faturalarini_getir;
//    }
    if (!empty($binek_yakit_arr)) {
        $merge_arr = array_merge($merge_arr, $binek_yakit_arr);
    }

    if ($merge_arr > 0) {
        echo json_encode($merge_arr);
    } else {
        echo 2;
    }
}

if ($islem == "fatura_ana_bilgileri_getir") {

    $id = $_GET["id"];

    $fatura_ana_bilgileri = DB::single_query("SELECT * FROM alis_default WHERE status=1 AND id='$id'  and cari_key='$cari_key' $ek_sorgu");

    if ($fatura_ana_bilgileri > 0) {

        echo json_encode($fatura_ana_bilgileri);

    } else {

        echo 2;

    }

}

if ($islem == "faturanini_urunlerini_getir") {

    $alis_defaultid = $_GET["alis_defaultid"];

    $alinan_urunler = DB::all_data("
SELECT alis_urunler.*,stok.stok_kodu,stok.stok_adi,birim.birim_adi,alis_default.iskonto_toplam,alis_default.kdv_toplam,alis_default.ara_toplam,
       alis_default.genel_toplam,alis_default.tevkifat_toplam,alis_default.doviz_tur
FROM 
     alis_urunler
INNER JOIN stok ON stok.id=alis_urunler.stok_id
INNER JOIN birim ON birim.id=alis_urunler.birim_id
INNER JOIN alis_default ON alis_default.id=alis_urunler.alis_defaultid
WHERE 
      alis_urunler.status=1 
AND 
      alis_urunler.alis_defaultid='$alis_defaultid'");
    if ($alinan_urunler > 0) {

        echo json_encode($alinan_urunler);

    } else {

        echo 2;

    }

}

if ($islem == "fatura_sil_sql") {
    $id = $_POST["id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["status"] = 0;
    $default_sorgu = DB::single_query("select * from alis_default WHERE id='$id'");
    $fatura_tutar = $default_sorgu["genel_toplam"];
    $cari_id = $default_sorgu["cari_id"];
    $cari_bilgileri = DB::single_query("SELECT alacak,borc FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
    $yeni_alacak = floatval($cari_bilgileri["alacak"]) - floatval($fatura_tutar);
    $arr3 = [
        'alacak' => $yeni_alacak,
        'update_userid' => $_SESSION["user_id"],
        'update_datetime' => date("Y-m-d H:i:s")
    ];
    $cari_guncel = DB::update("cari", "id", $cari_id, $arr3);

    $explode_ids = explode(",", $default_sorgu["irsaliye_ids"]);
    foreach ($explode_ids as $irsaliye_id) {
        $default_id = DB::single_query("SELECT * FROM alis_irsaliye_urunler WHERE id='$irsaliye_id'");
        $arr = [
            'update_userid' => $_SESSION["user_id"],
            'update_datetime' => date("Y-m-d H:i:s"),
            'status' => 1
        ];
        $guncelle = DB::update("alis_irsaliye", "id", $default_id["irsaliye_id"], $arr);
    }

    $explode_ids = explode(",", $default_sorgu["kiralik_cikis_depo_ids"]);
    foreach ($explode_ids as $irsaliye_id) {
        $arr = [
            'update_userid' => $_SESSION["user_id"],
            'update_datetime' => date("Y-m-d H:i:s"),
            'kiralik_alis_kesildi' => 0
        ];
        $guncelle = DB::update("depo_konteyner_cikis", "id", $irsaliye_id, $arr);
    }

    $explode_ids = explode(",", $default_sorgu["kiralik_depo_ids"]);
    foreach ($explode_ids as $irsaliye_id) {
        $arr = [
            'update_userid' => $_SESSION["user_id"],
            'update_datetime' => date("Y-m-d H:i:s"),
            'kiralik_arac_kesildi' => 0
        ];
        $guncelle = DB::update("depo_konteyner_giris", "id", $irsaliye_id, $arr);
    }
    $explode_ids = explode(",", $default_sorgu["depo_ids"]);
    foreach ($explode_ids as $irsaliye_id) {
        $arr = [
            'update_userid' => $_SESSION["user_id"],
            'update_datetime' => date("Y-m-d H:i:s"),
            'depo_alis_kesildi' => 0
        ];
        $guncelle = DB::update("depo_konteyner_cikis", "id", $irsaliye_id, $arr);
    }
    $explode_ids2 = explode(",", $default_sorgu["ek_hizmet_ids"]);
    if ($default_sorgu["irsaliye_ids"] == "" || $default_sorgu["irsaliye_ids"] == null) {
        $fatura_urunleri = DB::all_data("SELECT * FROM alis_urunler WHERE alis_defaultid='$id'");
        foreach ($fatura_urunleri as $urunler) {
            $stok_id = $urunler["stok_id"];
            $miktar = $urunler["miktar"];
            $stokdaki_miktar = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");
            if ($stokdaki_miktar > 0) {
                $envanter_miktar = $stokdaki_miktar["giren_miktar"];
                $yeni_miktar = $envanter_miktar - $miktar;
                $guncelle_arr = [
                    'giren_miktar' => $yeni_miktar,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $envanter_miktar_guncelle = DB::update("stok", "id", $stok_id, $guncelle_arr);
            }
        }
    }

    foreach ($explode_ids2 as $irsaliye_id) {
        $arr = [
            'update_userid' => $_SESSION["user_id"],
            'update_datetime' => date("Y-m-d H:i:s"),
            'alis_status' => 1
        ];
        $guncelle = DB::update("konteyner_irsaliye_ek_hizmet", "id", $irsaliye_id, $arr);
    }
    if ($guncelle) {
        $faturayi_sil = DB::update("alis_default", "id", $id, $_POST);
        if ($faturayi_sil) {
            echo 1;
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}

if ($islem == "siparis_son_belge_no_cek") {

    $modul_adi = "Sipariş";

    $cari_id = $_GET["cari_id"];

    $son_belge = DB::single_query("SELECT * FROM belge_referans WHERE status=1 AND modul_adi='$modul_adi'  and cari_key='$cari_key' ORDER BY id DESC");

    if ($son_belge > 0) {

        $son_id = $son_belge["son_rakam"];

        $son_id = $son_id + 1;

        echo $son_id;

    }

}

if ($islem == "siparis_urun_ekle_sql") {

    $_POST["insert_userid"] = $_SESSION["user_id"];

    $_POST["insert_datetime"] = date("Y-m-d H:i:s");

    $cari_id = $_POST["cari_id"];

    $doviz_tur = $_POST["doviz_tur"];

    $kur_fiyat = $_POST["kur_fiyat"];

    unset($_POST["cari_id"]);

    unset($_POST["doviz_tur"]);

    unset($_POST["kur_fiyat"]);

    if (!isset($_POST["siparis_id"])) {

        $arr = [

            'insert_userid' => $_SESSION["user_id"],

            'insert_datetime' => date("Y-m-d H:i:s"),

            'cari_id' => $cari_id,

            'cari_key' => $cari_key,

            'sube_key' => $sube_key,

            'doviz_tur' => $doviz_tur,

            'kur_fiyat' => $kur_fiyat

        ];

        $faturayi_olustur = DB::insert("verilen_siparisler", $arr);

        $son_eklenen = DB::single_query("SELECT id FROM verilen_siparisler where  cari_key='$cari_key' $ek_sorgu ORDER BY id DESC LIMIT 1");

        $fatura_id = $son_eklenen["id"];

        $_POST["siparis_id"] = $fatura_id;

    }

    $fatura_id = $_POST["siparis_id"];

    $kdv_tutar = $_POST["kdv_tutari"];

    $iskonto_tutari = $_POST["iskonto_tutari"];

    $toplam_tutar = $_POST["toplam_tutar"];

    $tevkifat_tutari = $_POST["tevkifat_tutari"];

    $ara_toplam = 0;

    if ($_POST["iskonto"] != 0) {

        $yeni_fiyat = $_POST["birim_fiyat"] - $iskonto_tutari;

        $ara_toplam = $yeni_fiyat * $_POST["miktar"];

    } else {

        $ara_toplam = $_POST["miktar"] * $_POST["birim_fiyat"];

    }


    $fatura_toplam_bilgiler = DB::single_query("SELECT * FROM verilen_siparisler WHERE id='$fatura_id'  and cari_key='$cari_key' $ek_sorgu");

    if ($fatura_toplam_bilgiler > 0) {

        $faturadaki_kdv = $fatura_toplam_bilgiler["kdv_toplam"];

        $faturadaki_iskonto = $fatura_toplam_bilgiler["iskonto_toplam"];

        $fatura_ara_toplam = $fatura_toplam_bilgiler["ara_toplam"];

        $fatura_genel_toplam = $fatura_toplam_bilgiler["genel_toplam"];

        $tevkifat_toplami = $fatura_toplam_bilgiler["tevkifat_toplam"];


        $faturaya_urun_ekle = DB::insert("verilen_siparis_urunler", $_POST);

        if ($faturaya_urun_ekle) {

            echo 500;

        } else {


            $yeni_kdv_tutar = $faturadaki_kdv + $kdv_tutar;

            $yeni_iskonto_tutar = $faturadaki_iskonto + $iskonto_tutari;

            $yeni_toplam_tutar = $fatura_genel_toplam + $toplam_tutar;

            $yeni_ara_toplam = $fatura_ara_toplam + $ara_toplam;

            $yeni_tevkifat_toplam = $tevkifat_toplami + $tevkifat_tutari;

            $arr = [

                'iskonto_toplam' => $yeni_iskonto_tutar,

                'kdv_toplam' => $yeni_kdv_tutar,

                'ara_toplam' => $yeni_ara_toplam,

                'genel_toplam' => $yeni_toplam_tutar,

                'tevkifat_toplam' => $yeni_tevkifat_toplam

            ];


            $fatura_miktarlarini_guncelle = DB::update("verilen_siparisler", "id", $fatura_id, $arr);

            if ($fatura_miktarlarini_guncelle) {

                $faturadaki_urunler = DB::all_data("

SELECT verilen_siparis_urunler.*,stok.stok_kodu,stok.stok_adi,birim.birim_adi,verilen_siparisler.iskonto_toplam,verilen_siparisler.kdv_toplam,verilen_siparisler.ara_toplam,

       verilen_siparisler.genel_toplam,verilen_siparisler.tevkifat_toplam,verilen_siparisler.doviz_tur

FROM 

     verilen_siparis_urunler

INNER JOIN stok ON stok.id=verilen_siparis_urunler.stok_id

INNER JOIN birim ON birim.id=verilen_siparis_urunler.birim_id

INNER JOIN verilen_siparisler ON verilen_siparisler.id=verilen_siparis_urunler.siparis_id

WHERE 

      verilen_siparis_urunler.status=1 

AND 

      verilen_siparis_urunler.siparis_id='$fatura_id'");

                if ($faturadaki_urunler > 0) {

                    echo json_encode($faturadaki_urunler);

                } else {

                    echo 2;

                }

            } else {

                echo 500;

            }

        }

    }

}

if ($islem == "siparisten_urun_cikart") {

    $id = $_POST["id"];

    $fatura_id = $_POST["siparis_id"];

    $_POST["delete_userid"] = $_SESSION["user_id"];

    $_POST["status"] = 0;

    $_POST["delete_datetime"] = date("Y-m-d H:i:s");

    $_POST["delete_detail"] = "Kullanıcı Sipariş Oluştururken Silmiştir";


    $urun_bilgileri = DB::single_query("SELECT * FROM verilen_siparis_urunler WHERE status=1 AND id='$id'");

    $fatura_bilgileri = DB::single_query("SELECT * FROM verilen_siparisler WHERE status=1 AND id='$fatura_id'");


    $faturadaki_kdv = $fatura_bilgileri["kdv_toplam"];

    $faturadaki_iskonto = $fatura_bilgileri["iskonto_toplam"];

    $faturadaki_ara_toplam = $fatura_bilgileri["ara_toplam"];

    $faturadaki_genel_toplam = $fatura_bilgileri["genel_toplam"];

    $faturadaki_tevkifat_toplam = $fatura_bilgileri["tevkifat_toplam"];


    $urun_kdv = $urun_bilgileri["kdv_tutari"];

    $urun_iskonto = $urun_bilgileri["iskonto_tutari"];

    $ara_toplam = 0;

    if ($urun_iskonto != 0) {

        $yeni_tutar = $urun_bilgileri["birim_fiyat"] - $urun_bilgileri["iskonto_tutari"];

        $ara_toplam = $yeni_tutar * $urun_bilgileri["miktar"];

    } else {

        $ara_toplam = $urun_bilgileri["miktar"] * $urun_bilgileri["birim_fiyat"];

    }

    $urun_genel_toplam = $urun_bilgileri["toplam_tutar"];

    $urun_tevkifat_toplam = $urun_bilgileri["tevkifat_tutari"];


    $yeni_kdv = $faturadaki_kdv - $urun_kdv;

    $yeni_iskonto = $faturadaki_iskonto - $urun_iskonto;

    $yeni_ara_toplam = $faturadaki_ara_toplam - $ara_toplam;

    $yeni_genel_toplam = $faturadaki_genel_toplam - $urun_genel_toplam;

    $yeni_tevkifat_toplam = $faturadaki_tevkifat_toplam - $urun_tevkifat_toplam;

    $arr = [

        'iskonto_toplam' => $yeni_iskonto,

        'kdv_toplam' => $yeni_kdv,

        'ara_toplam' => $yeni_ara_toplam,

        'genel_toplam' => $yeni_genel_toplam,

        'tevkifat_toplam' => $yeni_tevkifat_toplam

    ];


    $fatura_miktari_guncelle = DB::update("verilen_siparisler", "id", $fatura_id, $arr);

    if ($fatura_miktari_guncelle) {

        unset($_POST["siparis_id"]);

        $urunu_faturadan_cikart = DB::update("verilen_siparis_urunler", "id", $id, $_POST);

        if ($urunu_faturadan_cikart) {

            $faturadaki_urunler = DB::all_data("

SELECT verilen_siparis_urunler.*,stok.stok_kodu,stok.stok_adi,birim.birim_adi,verilen_siparisler.iskonto_toplam,verilen_siparisler.kdv_toplam,verilen_siparisler.ara_toplam,

       verilen_siparisler.genel_toplam,verilen_siparisler.tevkifat_toplam,verilen_siparisler.doviz_tur

FROM 

     verilen_siparis_urunler

INNER JOIN stok ON stok.id=verilen_siparis_urunler.stok_id

INNER JOIN birim ON birim.id=verilen_siparis_urunler.birim_id

INNER JOIN verilen_siparisler ON verilen_siparisler.id=verilen_siparis_urunler.siparis_id

WHERE 

      verilen_siparis_urunler.status=1 

AND 

      verilen_siparis_urunler.siparis_id='$fatura_id'");

            if ($faturadaki_urunler > 0) {

                echo json_encode($faturadaki_urunler);

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

if ($islem == "siparisteki_urun_bilgilerini_getir") {

    $id = $_GET["id"];

    $fatura_urun_bilgileri = DB::single_query(

        "

SELECT verilen_siparis_urunler.*,stok.stok_kodu,stok.stok_adi,birim.birim_adi,stok.birim

FROM 

     verilen_siparis_urunler

INNER JOIN stok ON stok.id=verilen_siparis_urunler.stok_id

INNER JOIN birim ON birim.id=verilen_siparis_urunler.birim_id

WHERE 

      verilen_siparis_urunler.status=1 

AND 

      verilen_siparis_urunler.id='$id'"

    );

    if ($fatura_urun_bilgileri > 0) {

        echo json_encode($fatura_urun_bilgileri);

    } else {

        echo 2;

    }

}

if ($islem == "siparis_urun_guncelle") {

    $id = $_POST["id"];

    $_POST["update_userid"] = $_SESSION["user_id"];

    $_POST["update_datetime"] = date("Y-m-d H:i:s");


    $fatura_id = $_POST["siparis_id"];

    $fatura_bilgileri = DB::single_query("SELECT * FROM verilen_siparisler WHERE status=1 AND id='$fatura_id'");

    if ($fatura_bilgileri > 0) {

        $faturadaki_genel_toplam = $fatura_bilgileri["genel_toplam"];

        $faturadaki_iskonto_toplam = $fatura_bilgileri["iskonto_toplam"];

        $faturadaki_kdv_toplam = $fatura_bilgileri["kdv_toplam"];

        $fatura_ara_toplam = $fatura_bilgileri["ara_toplam"];

        $fatura_tevkifat_toplam = $fatura_bilgileri["tevkifat_toplam"];


        $arr = [

            'genel_toplam' => $faturadaki_genel_toplam + $_POST["tutar_fark"],

            'tevkifat_toplam' => $fatura_tevkifat_toplam + $_POST["tevkifat_fark"],

            'ara_toplam' => $fatura_ara_toplam + $_POST["ara_toplam_fark"],

            'kdv_toplam' => $faturadaki_kdv_toplam + $_POST["kdv_fark"],

            'iskonto_toplam' => $faturadaki_iskonto_toplam + $_POST["iskonto_fark"]

        ];

        $ana_faturayi_guncelle = DB::update("verilen_siparisler", "id", $fatura_id, $arr);

        if ($ana_faturayi_guncelle) {

            unset($_POST["kdv_fark"]);

            unset($_POST["iskonto_fark"]);

            unset($_POST["tutar_fark"]);

            unset($_POST["tevkifat_fark"]);

            unset($_POST["ara_toplam_fark"]);

            $urunleri_guncelle = DB::update("verilen_siparis_urunler", "id", $id, $_POST);

            if ($urunleri_guncelle) {

                $faturadaki_urunler = DB::all_data("

SELECT verilen_siparis_urunler.*,stok.stok_kodu,stok.stok_adi,birim.birim_adi,verilen_siparisler.iskonto_toplam,verilen_siparisler.kdv_toplam,verilen_siparisler.ara_toplam,

       verilen_siparisler.genel_toplam,verilen_siparisler.tevkifat_toplam,verilen_siparisler.doviz_tur

FROM 

     verilen_siparis_urunler

INNER JOIN stok ON stok.id=verilen_siparis_urunler.stok_id

INNER JOIN birim ON birim.id=verilen_siparis_urunler.birim_id

INNER JOIN verilen_siparisler ON verilen_siparisler.id=verilen_siparis_urunler.siparis_id

WHERE 

      verilen_siparis_urunler.status=1 

AND 

      verilen_siparis_urunler.siparis_id='$fatura_id'");

                if ($faturadaki_urunler > 0) {

                    echo json_encode($faturadaki_urunler);

                } else {

                    echo 502;

                }

            } else {

                echo 500;

            }

        } else {

            echo 500;

        }

    } else {

        echo 500;

    }

}

if ($islem == "siparisi_iptal_et_sql") {

    $gonderilen_id = $_POST["id"];

    $_POST["delete_detail"] = "Kullanıcı Sipariş Oluşturulurken Vazgeçmiştir";

    $_POST["delete_userid"] = $_SESSION["user_id"];

    $_POST["delete_datetime"] = date("Y-m-d H:i:s");

    $_POST["status"] = 0;

    unset($_POST["id"]);

    $faturayi_sil = DB::update("verilen_siparisler", "id", $gonderilen_id, $_POST);

    if ($faturayi_sil) {

        $urunler_sil = DB::update("verilen_siparis_urunler", "siparis_id", $gonderilen_id, $_POST);

        if ($urunler_sil) {

            echo 1;

        } else {

            echo 2;

        }

    } else {

        echo 2;

    }

}

if ($islem == "siparisi_guncelle_sql") {

    $_POST["update_userid"] = $_SESSION["user_id"];

    $_POST["update_datetime"] = date("Y-m-d H:i:s");

    $siparis_id = $_POST["id"];

    $faturayi_olustur = DB::update("verilen_siparisler", "id", $siparis_id, $_POST);

    if ($faturayi_olustur) {

        $arr = [

            'cari_id' => $_POST["cari_id"],

            'son_rakam' => $_POST["siparis_no"],

            'modul_adi' => 'Sipariş',

            'cari_key' => $cari_key,

            'sube_key' => $sube_key

        ];

        $belge_referans_ekle = DB::insert("belge_referans", $arr);

        if ($belge_referans_ekle) {

            echo 2;

        } else {

            echo 1;

        }

    } else {

        echo 2;

    }

}

if ($islem == "verilen_siparisleri_getir_sql") {

    $ek_vs = "";

    if ($_SESSION["sube_key"] != 0) {

        $ek_vs = " AND vs.sube_key='$sube_key'";

    }

    $verilen_siparisleri_cek = DB::all_data("

SELECT vs.*,d.depo_adi,c.cari_adi FROM verilen_siparisler as vs

INNER JOIN cari as c on c.id=vs.cari_id

INNER JOIN depolar as d on d.id=vs.depo_id

WHERE vs.status=1 and vs.cari_key='$cari_key' $ek_vs");

    if ($verilen_siparisleri_cek > 0) {

        echo json_encode($verilen_siparisleri_cek);

    } else {

        echo 2;

    }

}

if ($islem == "siparis_sil_sql") {

    $gonderilen_id = $_POST["id"];

    $_POST["delete_userid"] = $_SESSION["user_id"];

    $_POST["delete_datetime"] = date("Y-m-d H:i:s");

    $_POST["status"] = 0;

    $faturayi_sil = DB::update("verilen_siparisler", "id", $gonderilen_id, $_POST);

    if ($faturayi_sil) {

        $siparis_urun_sil = DB::update("verilen_siparis_urunler", "siparis_id", $gonderilen_id, $_POST);

        if ($siparis_urun_sil) {

            echo 1;

        } else {

            echo 2;

        }

    } else {

        echo 2;

    }

}

if ($islem == "secilen_siparis_bilgilerini_getir") {

    $id = $_GET["id"];

    $fatura_ana_bilgileri = DB::single_query("SELECT * FROM verilen_siparisler WHERE status=1 AND id='$id' and cari_key='$cari_key' $ek_sorgu");

    if ($fatura_ana_bilgileri > 0) {

        echo json_encode($fatura_ana_bilgileri);

    } else {

        echo 2;

    }

}

if ($islem == "siparisin_urunlerini_getir") {

    $siparis_id = $_GET["siparis_id"];

    $faturadaki_urunler = DB::all_data("

SELECT verilen_siparis_urunler.*,stok.stok_kodu,stok.stok_adi,birim.birim_adi,verilen_siparisler.iskonto_toplam,verilen_siparisler.kdv_toplam,verilen_siparisler.ara_toplam,

       verilen_siparisler.genel_toplam,verilen_siparisler.tevkifat_toplam,verilen_siparisler.doviz_tur

FROM 

     verilen_siparis_urunler

INNER JOIN stok ON stok.id=verilen_siparis_urunler.stok_id

INNER JOIN birim ON birim.id=verilen_siparis_urunler.birim_id

INNER JOIN verilen_siparisler ON verilen_siparisler.id=verilen_siparis_urunler.siparis_id

WHERE 

      verilen_siparis_urunler.status=1 

AND 

      verilen_siparis_urunler.siparis_id='$siparis_id'");

    if ($faturadaki_urunler > 0) {

        echo json_encode($faturadaki_urunler);

    } else {

        echo 2;

    }

}

if ($islem == "siparis_filtrele_main") {

    $bas_tarih = $_GET["bas_tarih"];

    $bit_tarih = $_GET["bit_tarih"];

    $siparis_durum = $_GET["siparis_durumu"];

    $ek1 = "";

    if ($_SESSION["sube_key"] != 0) {

        $ek1 = " and vs.sube_key='$sube_key'";

    }


    $sql = "";

    if ($siparis_durum != "") {
        if ($siparis_durum == 0) {
            $sql = "

SELECT vs.*,d.depo_adi,c.cari_adi 
FROM 
     verilen_siparisler as vs
INNER JOIN depolar as d on d.id=vs.depo_id
INNER JOIN cari as c on c.id=vs.cari_id
WHERE vs.status !=0 and vs.cari_key='$cari_key' $ek1";
        } else {
            $sql = "

SELECT vs.*,d.depo_adi,c.cari_adi FROM verilen_siparisler as vs

INNER JOIN depolar as d on d.id=vs.depo_id

INNER JOIN cari as c on c.id=vs.cari_id

WHERE vs.status='$siparis_durum' and vs.cari_key='$cari_key' $ek1";
        }

    } else {

        $sql = "

SELECT vs.*,d.depo_adi,c.cari_adi FROM verilen_siparisler as vs

INNER JOIN depolar as d on d.id=vs.depo_id

INNER JOIN cari as c on c.id=vs.cari_id

WHERE vs.status=1 and vs.cari_key='$cari_key' $ek1";

    }

    if ($bas_tarih != "" || $bit_tarih != "") {

        $sql .= " AND vs.siparis_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 00:00:00'";

    }

    $alis_faturalarini_getir = DB::all_data($sql);

    if ($alis_faturalarini_getir > 0) {

        echo json_encode($alis_faturalarini_getir);

    } else {

        echo 2;

    }

}

if ($islem == "girilen_cari_kodu_bilgileri") {

    $id = $_GET["cari_kodu"];

    $cari_bilgi = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_kodu='$id' and cari_key='$cari_key'");

    $cari_id = $cari_bilgi["id"];

    $cari_adres = DB::single_query("SELECT adres FROM cari_adres_bilgileri WHERE cari_id='$cari_id' AND status=1 and cari_key='$cari_key'");

    if ($cari_adres > 0) {

        $combine = array_merge($cari_bilgi, $cari_adres);

        if ($combine > 0) {

            echo json_encode($combine);

        } else {

            echo 3;

        }

    } else {

        if ($cari_bilgi > 0) {

            echo json_encode($cari_bilgi);

        } else {

            echo 2;

        }

    }

}

if ($islem == "stok_kodu_bilgileri_getir") {

    $id = $_GET["stok_kodu"];

    $bilgileri_getir = DB::single_query("SELECT * FROM stok WHERE status=1 AND stok_kodu='$id' and cari_key='$cari_key'");

    if ($bilgileri_getir > 0) {

        echo json_encode($bilgileri_getir);

    } else {

        echo 2;

    }

}

if ($islem == "doviz_kur_degistir") {

    $_POST["update_datetime"] = date("Y-m-d H:i:s");

    $_POST["update_userid"] = $_SESSION["user_id"];

    if (isset($_POST["alis_muhtelifid"])) {

        $id = $_POST["alis_muhtelifid"];

        unset($_POST["alis_muhtelifid"]);

        $fatura_kur_guncelle = DB::update("alis_muhtelif", "id", $id, $_POST);

        if ($fatura_kur_guncelle) {

            $alinan_urunler = DB::all_data("

    

                

SELECT alis_urunler.*,stok.stok_kodu,stok.stok_adi,birim.birim_adi,alis_muhtelif.iskonto_toplam,alis_muhtelif.kdv_toplam,alis_muhtelif.ara_toplam,

       alis_muhtelif.genel_toplam,alis_muhtelif.tevkifat_toplam,alis_muhtelif.doviz_tur

FROM 

     alis_urunler

INNER JOIN stok ON stok.id=alis_urunler.stok_id

INNER JOIN birim ON birim.id=alis_urunler.birim_id

INNER JOIN alis_muhtelif ON alis_muhtelif.id=alis_urunler.alis_muhtelifid

WHERE 

      alis_urunler.status=1 

AND 

      alis_urunler.alis_muhtelifid='$id' and alis_urunler.cari_key='$cari_key'");

            if ($alinan_urunler > 0) {

                echo json_encode($alinan_urunler);

            } else {

                echo 2;

            }

        } else {

            echo 500;

        }

    } else {

        $id = $_POST["alis_defaultid"];

        unset($_POST["alis_defaultid"]);

        $fatura_kur_guncelle = DB::update("alis_default", "id", $id, $_POST);

        if ($fatura_kur_guncelle) {

            $alinan_urunler = DB::all_data("

    

                

SELECT alis_urunler.*,stok.stok_kodu,stok.stok_adi,birim.birim_adi,alis_default.iskonto_toplam,alis_default.kdv_toplam,alis_default.ara_toplam,

       alis_default.genel_toplam,alis_default.tevkifat_toplam,alis_default.doviz_tur

FROM 

     alis_urunler

INNER JOIN stok ON stok.id=alis_urunler.stok_id

INNER JOIN birim ON birim.id=alis_urunler.birim_id

INNER JOIN alis_default ON alis_default.id=alis_urunler.alis_defaultid

WHERE 

      alis_urunler.status=1 

AND 

      alis_urunler.alis_defaultid='$id' and alis_urunler.cari_key='$cari_key'");

            if ($alinan_urunler > 0) {

                echo json_encode($alinan_urunler);

            } else {

                echo 2;

            }

        } else {

            echo 500;

        }

    }

}

if ($islem == "doviz_kur_guncelle_sql") {

    $_POST["update_userid"] = $_SESSION["user_id"];

    $_POST["update_datetime"] = date("Y-m-d H:i:s");

    $id = $_POST["id"];

    $kur_guncelle = DB::update("alis_default", "id", $id, $_POST);

    if ($kur_guncelle) {

        echo 1;

    } else {

        echo 2;

    }

}

if ($islem == "alis_faturalari_filtrele_sql") {

    $bas_tarih = $_GET["bas_tarih"];

    $bit_tarih = $_GET["bit_tarih"];

    $bas_fiyat = $_GET["bas_fiyat"];

    $bit_fiyat = $_GET["bit_fiyat"];

    $doviz_tur = $_GET["doviz_tur"];

    $fatura_no = $_GET["fatura_no"];

    $cari_kodu = $_GET["cari_kodu"];

    $cari_adi = $_GET["cari_adi"];

    $aciklama = $_GET["aciklama"];
    $ek_sql = "";
    if ($_SESSION["sube_key"] != 0) {
        $ek_sql = " AND ad.sube_key='$sube_key'";
    }

    $sql = "SELECT ad.*,d.depo_adi,c.cari_adi,c.cari_kodu,ftt.fatura_turu_adi FROM alis_default as ad

INNER JOIN depolar as d on d.id=ad.depo_id
INNER JOIN fatura_tur_tanim as ftt on ftt.id=ad.fatura_turu
INNER JOIN cari as c on c.id=ad.cari_id

WHERE ad.status=1 and ad.cari_key='$cari_key'";

    if ($bas_tarih != "" || $bit_tarih != "") {

        $sql .= " AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 00:00:00'";

    }

    if ($bas_fiyat != "" || $bit_fiyat != "") {

        $sql .= "  AND ad.genel_toplam BETWEEN '$bas_fiyat' AND '$bit_fiyat'";

    }

    if ($doviz_tur != "") {

        $sql .= " AND ad.doviz_tur='$doviz_tur'";

    }

    if ($fatura_no != "") {

        $sql .= " AND ad.fatura_no like '$fatura_no%'";

    }

    if ($cari_kodu != "") {

        $sql .= " AND c.cari_kodu='$cari_kodu'";

    }

    if ($cari_adi != "") {

        $sql .= " AND c.cari_adi like '$cari_adi%'";

    }

    if ($aciklama != "") {

        $sql .= " AND ad.aciklama like '$aciklama%'";

    }

    $alis_faturalarini_getir = DB::all_data($sql);

    if ($alis_faturalarini_getir > 0) {

        echo json_encode($alis_faturalarini_getir);

    } else {

        echo 2;

    }

}

if ($islem == "siparis_doviz_tur_degistir") {

    $_POST["update_datetime"] = date("Y-m-d H:i:s");

    $_POST["update_userid"] = $_SESSION["user_id"];

    $id = $_POST["id"];

    $doviz_tip_guncelle = DB::update("verilen_siparisler", "id", $id, $_POST);

    if ($doviz_tip_guncelle) {

        echo 1;

    } else {

        echo 2;

    }

}

if ($islem == "doviz_kuru_guncelle") {

    $_POST["update_datetime"] = date("Y-m-d H:i:s");

    $_POST["update_userid"] = $_SESSION["user_id"];

    $id = $_POST["id"];

    $doviz_tip_guncelle = DB::update("verilen_siparisler", "id", $id, $_POST);

    if ($doviz_tip_guncelle) {

        echo 1;

    } else {

        echo 2;

    }

}

if ($islem == "irsaliye_urun_ekle_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $cari_id = $_POST["cari_id"];
    $doviz_tur = $_POST["doviz_tur"];
    $kur_fiyat = $_POST["kur_fiyat"];
    unset($_POST["cari_id"]);
    unset($_POST["doviz_tur"]);
    unset($_POST["kur_fiyat"]);
    if ($_POST["irsaliye_id"] == "") {
        $arr = [
            'insert_userid' => $_SESSION["user_id"],
            'insert_datetime' => date("Y-m-d H:i:s"),
            'cari_id' => $cari_id,
            'cari_key' => $cari_key,
            'sube_key' => $sube_key,
            'doviz_tur' => $doviz_tur,
            'kur_fiyat' => $kur_fiyat
        ];
        $faturayi_olustur = DB::insert("alis_irsaliye", $arr);
        $son_eklenen = DB::single_query("SELECT id FROM alis_irsaliye where  cari_key='$cari_key' $ek_sorgu ORDER BY id DESC LIMIT 1");
        $fatura_id = $son_eklenen["id"];
        $_POST["irsaliye_id"] = $fatura_id;
    }
    $fatura_id = $_POST["irsaliye_id"];
    $kdv_tutar = $_POST["kdv_tutari"];
    $iskonto_tutari = $_POST["iskonto_tutari"];
    $toplam_tutar = $_POST["toplam_tutar"];
    $tevkifat_tutari = $_POST["tevkifat_tutari"];
    $ara_toplam = 0;
    if ($_POST["iskonto"] != 0) {
        $yeni_fiyat = $_POST["birim_fiyat"] - $iskonto_tutari;
        $ara_toplam = $yeni_fiyat * $_POST["miktar"];
    } else {
        $ara_toplam = $_POST["miktar"] * $_POST["birim_fiyat"];
    }
    $fatura_toplam_bilgiler = DB::single_query("SELECT * FROM alis_irsaliye WHERE id='$fatura_id'  and cari_key='$cari_key' $ek_sorgu");
    if ($fatura_toplam_bilgiler > 0) {
        $faturadaki_kdv = $fatura_toplam_bilgiler["kdv_toplam"];
        $faturadaki_iskonto = $fatura_toplam_bilgiler["iskonto_toplam"];
        $fatura_ara_toplam = $fatura_toplam_bilgiler["ara_toplam"];
        $fatura_genel_toplam = $fatura_toplam_bilgiler["genel_toplam"];
        $tevkifat_toplami = $fatura_toplam_bilgiler["tevkifat_toplam"];
        $faturaya_urun_ekle = DB::insert("alis_irsaliye_urunler", $_POST);
        if ($faturaya_urun_ekle) {
            echo 500;
        } else {
            $yeni_kdv_tutar = $faturadaki_kdv + $kdv_tutar;
            $yeni_iskonto_tutar = $faturadaki_iskonto + $iskonto_tutari;
            $yeni_toplam_tutar = $fatura_genel_toplam + $toplam_tutar;
            $yeni_ara_toplam = $fatura_ara_toplam + $ara_toplam;
            $yeni_tevkifat_toplam = $tevkifat_toplami + $tevkifat_tutari;
            $arr = [
                'iskonto_toplam' => $yeni_iskonto_tutar,
                'kdv_toplam' => $yeni_kdv_tutar,
                'ara_toplam' => $yeni_ara_toplam,
                'genel_toplam' => $yeni_toplam_tutar,
                'tevkifat_toplam' => $yeni_tevkifat_toplam
            ];
            $fatura_miktarlarini_guncelle = DB::update("alis_irsaliye", "id", $fatura_id, $arr);
            if ($fatura_miktarlarini_guncelle) {
                $faturadaki_urunler = DB::all_data("
SELECT alis_irsaliye_urunler.*,stok.stok_kodu,stok.stok_adi,birim.birim_adi,alis_irsaliye.iskonto_toplam,alis_irsaliye.kdv_toplam,alis_irsaliye.ara_toplam,
       alis_irsaliye.genel_toplam,alis_irsaliye.tevkifat_toplam,alis_irsaliye.doviz_tur
FROM 
     alis_irsaliye_urunler
INNER JOIN stok ON stok.id=alis_irsaliye_urunler.stok_id
INNER JOIN birim ON birim.id=alis_irsaliye_urunler.birim_id
INNER JOIN alis_irsaliye ON alis_irsaliye.id=alis_irsaliye_urunler.irsaliye_id
WHERE 
      alis_irsaliye_urunler.status=1 
AND 
      alis_irsaliye_urunler.irsaliye_id='$fatura_id'");
                if ($faturadaki_urunler > 0) {
                    $stok_id = $_POST["stok_id"];
                    $stok_miktar_bilgileri = DB::single_query("SELECT * FROM stok where status=1 AND id='$stok_id' and cari_key='$cari_key'");
                    $stokdaki_miktar = $stok_miktar_bilgileri["giren_miktar"];
                    $gonderilen_miktar = $_POST["miktar"];
                    $yeni_miktar = floatval($gonderilen_miktar) + floatval($stokdaki_miktar);
                    $stok_miktari_arr = [
                        'giren_miktar' => $yeni_miktar,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];
                    $stok_miktarini_guncelle = DB::update("stok", "id", $stok_id, $stok_miktari_arr);
                    if ($stok_miktarini_guncelle) {
                        echo json_encode($faturadaki_urunler);
                    } else {
                        echo 2;
                    }
                } else {
                    echo 2;
                }
            } else {
                echo 500;
            }
        }
    }
}
if ($islem == "irsaliyeden_urun_cikart") {

    $id = $_POST["id"];
    $fatura_id = $_POST["irsaliye_id"];
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["status"] = 0;
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_detail"] = "Kullanıcı İrsaliye Oluştururken Silmiştir";
    $urun_bilgileri = DB::single_query("SELECT * FROM alis_irsaliye_urunler WHERE status=1 AND id='$id'");
    $fatura_bilgileri = DB::single_query("SELECT * FROM alis_irsaliye WHERE status=1 AND id='$fatura_id'");
    $faturadaki_kdv = $fatura_bilgileri["kdv_toplam"];
    $faturadaki_iskonto = $fatura_bilgileri["iskonto_toplam"];
    $faturadaki_ara_toplam = $fatura_bilgileri["ara_toplam"];
    $faturadaki_genel_toplam = $fatura_bilgileri["genel_toplam"];
    $faturadaki_tevkifat_toplam = $fatura_bilgileri["tevkifat_toplam"];
    $urun_kdv = $urun_bilgileri["kdv_tutari"];
    $urun_iskonto = $urun_bilgileri["iskonto_tutari"];
    $ara_toplam = 0;
    if ($urun_iskonto != 0) {
        $yeni_tutar = $urun_bilgileri["birim_fiyat"] - $urun_bilgileri["iskonto_tutari"];
        $ara_toplam = $yeni_tutar * $urun_bilgileri["miktar"];
    } else {
        $ara_toplam = $urun_bilgileri["miktar"] * $urun_bilgileri["birim_fiyat"];
    }
    $urun_genel_toplam = $urun_bilgileri["toplam_tutar"];
    $urun_tevkifat_toplam = $urun_bilgileri["tevkifat_tutari"];
    $yeni_kdv = $faturadaki_kdv - $urun_kdv;
    $yeni_iskonto = $faturadaki_iskonto - $urun_iskonto;
    $yeni_ara_toplam = $faturadaki_ara_toplam - $ara_toplam;
    $yeni_genel_toplam = $faturadaki_genel_toplam - $urun_genel_toplam;
    $yeni_tevkifat_toplam = $faturadaki_tevkifat_toplam - $urun_tevkifat_toplam;
    $arr = [
        'iskonto_toplam' => $yeni_iskonto,
        'kdv_toplam' => $yeni_kdv,
        'ara_toplam' => $yeni_ara_toplam,
        'genel_toplam' => $yeni_genel_toplam,
        'tevkifat_toplam' => $yeni_tevkifat_toplam
    ];
    $fatura_miktari_guncelle = DB::update("alis_irsaliye", "id", $fatura_id, $arr);
    if ($fatura_miktari_guncelle) {
        unset($_POST["siparis_id"]);
        $urunu_faturadan_cikart = DB::update("alis_irsaliye_urunler", "id", $id, $_POST);
        if ($urunu_faturadan_cikart) {
            $faturadaki_urunler = DB::all_data("
SELECT alis_irsaliye_urunler.*,stok.stok_kodu,stok.stok_adi,birim.birim_adi,alis_irsaliye.iskonto_toplam,alis_irsaliye.kdv_toplam,alis_irsaliye.ara_toplam,
       alis_irsaliye.genel_toplam,alis_irsaliye.tevkifat_toplam,alis_irsaliye.doviz_tur
FROM 
     alis_irsaliye_urunler
INNER JOIN stok ON stok.id=alis_irsaliye_urunler.stok_id
INNER JOIN birim ON birim.id=alis_irsaliye_urunler.birim_id
INNER JOIN alis_irsaliye ON alis_irsaliye.id=alis_irsaliye_urunler.irsaliye_id
WHERE 
      alis_irsaliye_urunler.status=1 
AND 
      alis_irsaliye_urunler.irsaliye_id='$fatura_id'");
            if ($faturadaki_urunler > 0) {
                $stok_id = $urun_bilgileri["stok_id"];
                $stok_miktari = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");
                if ($stok_miktari > 0) {
                    $stok_giren_miktar = $stok_miktari["giren_miktar"];
                    $vt_miktar = $urun_bilgileri["miktar"];
                    $yeni_miktar = $stok_giren_miktar - $vt_miktar;
                    $miktar_arr = [
                        'giren_miktar' => $yeni_miktar,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];
                    $veritabani_miktar_guncelle = DB::update("stok", "id", $stok_id, $miktar_arr);
                    if ($veritabani_miktar_guncelle) {
                        echo json_encode($faturadaki_urunler);
                    } else {
                        echo 501;
                    }
                } else {
                    echo 502;
                }
            } else {
                $stok_id = $urun_bilgileri["stok_id"];
                $stok_miktari = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");
                if ($stok_miktari > 0) {
                    $stok_giren_miktar = $stok_miktari["giren_miktar"];
                    $vt_miktar = $urun_bilgileri["miktar"];
                    $yeni_miktar = $stok_giren_miktar - $vt_miktar;
                    $miktar_arr = [
                        'giren_miktar' => $yeni_miktar,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];
                    $veritabani_miktar_guncelle = DB::update("stok", "id", $stok_id, $miktar_arr);
                    if ($veritabani_miktar_guncelle) {
                        echo 503;
                    } else {
                        echo 501;
                    }
                } else {
                    echo 502;
                }
            }
        } else {
            echo 500;
        }
    } else {
        echo 500;
    }
}
if ($islem == "siparisteki_urun_bilgileri") {

    $id = $_GET["id"];

    $fatura_urun_bilgileri = DB::single_query(

        "

SELECT alis_irsaliye_urunler.*,stok.stok_kodu,stok.stok_adi,birim.birim_adi,stok.birim

FROM 

     alis_irsaliye_urunler

INNER JOIN stok ON stok.id=alis_irsaliye_urunler.stok_id

INNER JOIN birim ON birim.id=alis_irsaliye_urunler.birim_id

WHERE 

      alis_irsaliye_urunler.status=1 

AND 

      alis_irsaliye_urunler.id='$id'"

    );

    if ($fatura_urun_bilgileri > 0) {

        echo json_encode($fatura_urun_bilgileri);

    } else {

        echo 2;

    }

}

if ($islem == "irsaliye_urun_guncelle") {

    $id = $_POST["id"];
    $miktar_fark = $_POST["miktar_farki"];
    unset($_POST["miktar_farki"]);

    $_POST["update_userid"] = $_SESSION["user_id"];

    $_POST["update_datetime"] = date("Y-m-d H:i:s");

    $irsaliye_id = DB::single_query("SELECT irsaliye_id FROM alis_irsaliye_urunler WHERE id='$id'");

    $_POST["irsaliye_id"] = $irsaliye_id["irsaliye_id"];

    $fatura_id = $_POST["irsaliye_id"];

    $fatura_bilgileri = DB::single_query("SELECT * FROM alis_irsaliye WHERE status=1 AND id='$fatura_id'");

    if ($fatura_bilgileri > 0) {

        $faturadaki_genel_toplam = $fatura_bilgileri["genel_toplam"];

        $faturadaki_iskonto_toplam = $fatura_bilgileri["iskonto_toplam"];

        $faturadaki_kdv_toplam = $fatura_bilgileri["kdv_toplam"];

        $fatura_ara_toplam = $fatura_bilgileri["ara_toplam"];

        $fatura_tevkifat_toplam = $fatura_bilgileri["tevkifat_toplam"];


        $arr = [

            'genel_toplam' => $faturadaki_genel_toplam + $_POST["tutar_fark"],

            'tevkifat_toplam' => $fatura_tevkifat_toplam + $_POST["tevkifat_fark"],

            'ara_toplam' => $fatura_ara_toplam + $_POST["ara_toplam_fark"],

            'kdv_toplam' => $faturadaki_kdv_toplam + $_POST["kdv_fark"],

            'iskonto_toplam' => $faturadaki_iskonto_toplam + $_POST["iskonto_fark"]

        ];

        $ana_faturayi_guncelle = DB::update("alis_irsaliye", "id", $fatura_id, $arr);

        if ($ana_faturayi_guncelle) {

            unset($_POST["kdv_fark"]);

            unset($_POST["iskonto_fark"]);

            unset($_POST["tutar_fark"]);

            unset($_POST["tevkifat_fark"]);

            unset($_POST["ara_toplam_fark"]);

            $urunleri_guncelle = DB::update("alis_irsaliye_urunler", "id", $id, $_POST);

            $arr = [
                'arac_kirasi' => $_POST["birim_fiyat"]
            ];
            $bilgiler = DB::single_query("SELECT * FROM alis_irsaliye_urunler WHERE id='$id'");
            $konteyner_irsaliye_guncelle = DB::update("konteyner_irsaliye", "id", $bilgiler["konteyner_irsaliye_id"], $arr);

            if ($urunleri_guncelle) {

                $faturadaki_urunler = DB::all_data("

SELECT alis_irsaliye_urunler.*,stok.stok_kodu,stok.stok_adi,birim.birim_adi,alis_irsaliye.iskonto_toplam,alis_irsaliye.kdv_toplam,alis_irsaliye.ara_toplam,

       alis_irsaliye.genel_toplam,alis_irsaliye.tevkifat_toplam,alis_irsaliye.doviz_tur

FROM 

     alis_irsaliye_urunler

INNER JOIN stok ON stok.id=alis_irsaliye_urunler.stok_id

INNER JOIN birim ON birim.id=alis_irsaliye_urunler.birim_id

INNER JOIN alis_irsaliye ON alis_irsaliye.id=alis_irsaliye_urunler.irsaliye_id

WHERE 

      alis_irsaliye_urunler.status=1 

AND 

      alis_irsaliye_urunler.irsaliye_id='$fatura_id'");

                if ($faturadaki_urunler > 0) {
                    $stok_id = $_POST["stok_id"];
                    $stok_envanter_bilgileri = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");
                    if ($stok_envanter_bilgileri > 0) {
                        $envanter_miktar = $stok_envanter_bilgileri["giren_miktar"];
                        $yeni_miktar = intval($miktar_fark) + intval($envanter_miktar);
                        $arr_envanter_miktar = [
                            'giren_miktar' => $yeni_miktar,
                            'update_userid' => $_SESSION["user_id"],
                            'update_datetime' => date("Y-m-d H:i:s")
                        ];
                        $urun_miktarini_guncelle = DB::update("stok", "id", $stok_id, $arr_envanter_miktar);
                        if ($urun_miktarini_guncelle) {
                            echo json_encode($faturadaki_urunler);
                        } else {
                            echo 502;
                        }
                    } else {
                        echo 505;
                    }
                } else {
                    echo 502;
                }
            } else {
                echo 503;
            }
        } else {
            echo 504;
        }
    } else {
        echo 505;
    }
}
if ($islem == "irsaliye_iptal_et_sql") {

    $gonderilen_id = $_POST["id"];

    $_POST["delete_detail"] = "Kullanıcı İrsaliye Oluşturulurken Vazgeçmiştir";

    $_POST["delete_userid"] = $_SESSION["user_id"];

    $_POST["delete_datetime"] = date("Y-m-d H:i:s");

    $_POST["status"] = 0;

    unset($_POST["id"]);

    $siparis_ids = DB::single_query("SELECT siparis_ids FROM alis_irsaliye WHERE id='$gonderilen_id'");

    $explode_ids = explode(",", $siparis_ids["siparis_ids"]);

    foreach ($explode_ids as $siparis_id) {

        $arr = [

            'id' => $siparis_id,

            'update_userid' => $_SESSION["user_id"],

            'update_datetime' => date("Y-m-d H:i:s"),

            'status' => 1

        ];

        $guncelle = DB::update("verilen_siparisler", "id", $siparis_id, $arr);

    }
    $faturadaki_urunler = DB::all_data("SELECT stok_id,miktar FROM alis_irsaliye_urunler WHERE status=1 AND irsaliye_id='$gonderilen_id'");
    foreach ($faturadaki_urunler as $urunler) {
        $stok_id = $urunler["stok_id"];
        $miktar = $urunler["miktar"];
        $stoktaki_urun_miktari = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");
        $yeni_miktar = $stoktaki_urun_miktari["giren_miktar"] - $miktar;
        echo $yeni_miktar;
        $stok_miktar_arr = [
            'giren_miktar' => $yeni_miktar,
            'update_userid' => $_SESSION["user_id"],
            'update_datetime' => date("Y-m-d H:i:s")
        ];
        $stok_miktarini_guncelle = DB::update("stok", "id", $stok_id, $stok_miktar_arr);
    }

    if ($guncelle) {
        if ($stok_miktarini_guncelle) {
            $faturayi_sil = DB::update("alis_irsaliye", "id", $gonderilen_id, $_POST);
            if ($faturayi_sil) {
                $urunler_sil = DB::update("alis_irsaliye_urunler", "irsaliye_id", $gonderilen_id, $_POST);
                if ($urunler_sil) {
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
if ($islem == "irsaliyeyi_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $id = $_POST["id"];
    $faturayi_olustur = DB::update("alis_irsaliye", "id", $id, $_POST);
    if ($faturayi_olustur) {
        echo 1;
    } else {
        echo 2;
    }
}

if ($islem == "siparis_iptal_sql") {
    $gonderilen_id = $_POST["id"];
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 3;
    $faturayi_sil = DB::update("verilen_siparisler", "id", $gonderilen_id, $_POST);
    if ($faturayi_sil) {
        $siparis_iptal_urunler = DB::update("verilen_siparis_urunler", "siparis_id", $gonderilen_id, $_POST);
        if ($siparis_iptal_urunler) {
            echo 1;
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "alis_irsaliyelerini_getir") {

    $ek_sorgu_ai = "";

    if ($_SESSION["sube_key"] != 0) {

        $ek_sorgu_ad = " AND ai.sube_key='$sube_key'";

    }

    $alis_irsaliyeleri_cek = DB::all_data("

    SELECT ai.*,d.depo_adi,c.cari_adi,c.cari_kodu FROM alis_irsaliye as ai

INNER JOIN cari as c on c.id=ai.cari_id

LEFT JOIN depolar as d on d.id=ai.depo_id

WHERE ai.status!=0 and ai.cari_key='$cari_key' $ek_sorgu_ad");

    if ($alis_irsaliyeleri_cek > 0) {

        echo json_encode($alis_irsaliyeleri_cek);

    } else {

        echo 2;

    }

}

if ($islem == "irsaliye_sil_sql") {
    $id = $_POST["id"];
    $siparis_ids = DB::single_query("SELECT siparis_ids FROM alis_irsaliye WHERE id='$id'");
    if ($siparis_ids["siparis_ids"] == "" || $siparis_ids["siparis_ids"] == null) {
        $_POST["delete_datetime"] = date("Y-m-d H:i:s");
        $_POST["delete_userid"] = $_SESSION["user_id"];
        $_POST["status"] = 0;
        $fatura_urunleri = DB::all_data("SELECT * FROM alis_irsaliye_urunler WHERE irsaliye_id='$id'");
        foreach ($fatura_urunleri as $urunler) {
            $stok_id = $urunler["stok_id"];
            $miktar = $urunler["miktar"];
            $stokdaki_miktar = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");
            if ($stokdaki_miktar > 0) {
                $envanter_miktar = $stokdaki_miktar["giren_miktar"];
                $yeni_miktar = $envanter_miktar - $miktar;
                $guncelle_arr = [
                    'giren_miktar' => $yeni_miktar,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $envanter_miktar_guncelle = DB::update("stok", "id", $stok_id, $guncelle_arr);
            }
        }
        if ($envanter_miktar_guncelle) {
            $faturayi_sil = DB::update("alis_irsaliye", "id", $id, $_POST); // İRSALİYENİN KAYDI SİLİNİYOR
            if ($faturayi_sil) { // İRSALİYE SİLİNDİMİ KONTROLÜ
                echo 1;
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    } else {
        $explode_ids = explode(",", $siparis_ids["siparis_ids"]);
        foreach ($explode_ids as $ids) {
            $arr = [
                "update_userid" => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s"),
                'status' => 1
            ];
            $guncelle = DB::update("verilen_siparisler", "id", $ids, $arr);
        }
        if ($guncelle) {
            $_POST["delete_datetime"] = date("Y-m-d H:i:s");
            $_POST["delete_userid"] = $_SESSION["user_id"];
            $_POST["status"] = 0;
            $faturayi_sil = DB::update("alis_irsaliye", "id", $id, $_POST); // İRSALİYENİN KAYDI SİLİNİYOR
            if ($faturayi_sil) { // İRSALİYE SİLİNDİMİ KONTROLÜ
                echo 1;
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    }
}
if ($islem == "secilen_irsaliye_bilgilerini_getir") {

    $id = $_GET["id"];

    $ust_bilgileri_getir = DB::single_query("SELECT * FROM alis_irsaliye WHERE id='$id'");

    if ($ust_bilgileri_getir > 0) {

        echo json_encode($ust_bilgileri_getir);

    } else {

        echo 2;

    }

}

if ($islem == "irsaliye_urunlerini_getir") {
    $irsaliye_id = $_GET["irsaliye_id"];
    $faturadaki_urunler = DB::all_data("
SELECT alis_irsaliye_urunler.*,stok.stok_kodu,stok.stok_adi,birim.birim_adi,alis_irsaliye.iskonto_toplam,alis_irsaliye.kdv_toplam,alis_irsaliye.ara_toplam,
       alis_irsaliye.genel_toplam,alis_irsaliye.tevkifat_toplam,alis_irsaliye.doviz_tur
FROM 
     alis_irsaliye_urunler
INNER JOIN stok ON stok.id=alis_irsaliye_urunler.stok_id
INNER JOIN birim ON birim.id=alis_irsaliye_urunler.birim_id
INNER JOIN alis_irsaliye ON alis_irsaliye.id=alis_irsaliye_urunler.irsaliye_id
WHERE 
      alis_irsaliye_urunler.status=1 
AND 
      alis_irsaliye_urunler.irsaliye_id='$irsaliye_id'");
    if ($faturadaki_urunler > 0) {
        echo json_encode($faturadaki_urunler);
    } else {
        echo 2;
    }
}

if ($islem == "cariye_ait_siparisleri_getir_sql") {
    $cari_id = $_GET["cari_id"];
    $ek_sube = "";
    if ($_SESSION["sube_key"] != 0) {
        $ek_sube = " AND verilen_siparisler.sube_key='$sube_key'";
    }
    $carinin_siparisleri = DB::all_data("SELECT verilen_siparisler.*,b.birim_adi,s.stok_adi,s.stok_kodu,vsu.miktar
FROM verilen_siparisler
INNER JOIN verilen_siparis_urunler as vsu on vsu.siparis_id=verilen_siparisler.id
INNER JOIN stok as s on s.id=vsu.stok_id
INNER JOIN birim as b on b.id=vsu.birim_id
WHERE verilen_siparisler.cari_id='$cari_id'  and verilen_siparisler.cari_key='$cari_key' and verilen_siparisler.status=1 and vsu.status=1");
    if ($carinin_siparisleri > 0) {
        echo json_encode($carinin_siparisleri);
    } else {
        echo 2;
    }
}

if ($islem == "secilen_siparisi_irsaliyelestir") {
    $COUNT = count($_POST["select_siparis"]);
    $arr = [];
    $siparis_ids = [];
    for ($i = 0; $i < $COUNT; $i++) {
        $siparis_id = $_POST["select_siparis"][$i];
        array_push($siparis_ids, $siparis_id);
        $siparisin_bilgileri = DB::single_query("SELECT * FROM verilen_siparisler WHERE id='$siparis_id'");
        if ($siparisin_bilgileri > 0) {
            $siparis_urun_bilgileri = DB::all_data("SELECT * FROM verilen_siparis_urunler WHERE siparis_id='$siparis_id'");
            if ($siparis_urun_bilgileri > 0) {
                $merge = array_merge([$siparisin_bilgileri], [$siparis_urun_bilgileri]);
                $arr[] = $merge;
            }
        }
        $degisecek_arr = [
            "update_userid" => $_SESSION["user_id"],
            'update_datetime' => date("Y-m-d H:i:s"),
            'status' => 2
        ];
        $siparis_durum_degistir = DB::update("verilen_siparisler", "id", $siparis_id, $degisecek_arr);
    }
    $genel_toplam = 0;
    $tevkifat_toplam = 0;
    $iskonto_toplam = 0;
    $kdv_toplam = 0;
    $ara_toplam = 0;
    $doviz_tur_arr = [];
    $ilk_deger = $arr[0][0]["doviz_tur"];
    $implode_ids = implode(",", $siparis_ids);
    foreach ($arr as $item) {
        array_push($doviz_tur_arr, $item[0]["doviz_tur"]);
        $genel_toplam = $item[0]["genel_toplam"];
        $ara_toplam = $item[0]["ara_toplam"];
        $kdv_toplam = $item[0]["kdv_toplam"];
        $tevkifat_toplam = $item[0]["tevkifat_toplam"];
        $iskonto_toplam = $item[0]["iskonto_toplam"];
    }
    $irsaliye_olustur_arr = [
        'cari_id' => $arr[0][0]["cari_id"],
        'doviz_tur' => $arr[0][0]["doviz_tur"],
        'kur_fiyat' => $arr[0][0]["kur_fiyat"],
        'genel_toplam' => $genel_toplam,
        'ara_toplam' => $ara_toplam,
        'kdv_toplam' => $kdv_toplam,
        'tevkifat_toplam' => $tevkifat_toplam,
        'iskonto_toplam' => $iskonto_toplam,
        'insert_userid' => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s"),
        'cari_key' => $cari_key,
        'siparis_ids' => $implode_ids,
        'sube_key' => $sube_key
    ];
    $yeni_irsaliye_olustur = DB::insert("alis_irsaliye", $irsaliye_olustur_arr); // array içerisine atadığımız verileri alis_irsaliye tablosuna ekliyoruz
    $son_eklenen = DB::single_query("SELECT id FROM alis_irsaliye where  cari_key='$cari_key' $ek_sorgu ORDER BY id DESC LIMIT 1");
    $irsaliye_id = $son_eklenen["id"]; // oluşturduğumuz irsaliyenin son id değerini alıyoruz
    if ($yeni_irsaliye_olustur) {
        echo 2;
    } else {
        unset($_POST["select_siparis"]);
        $i = 0;
        foreach ($arr as $item) {
            $_POST["irsaliye_id"] = $irsaliye_id;
            $_POST["stok_id"] = $item[1][$i]["stok_id"];
            $_POST["birim_id"] = $item[1][$i]["birim_id"];
            $_POST["miktar"] = $item[1][$i]["miktar"];
            $_POST["birim_fiyat"] = $item[1][$i]["birim_fiyat"];
            $_POST["kdv_orani"] = $item[1][$i]["kdv_orani"];
            $_POST["iskonto"] = $item[1][$i]["iskonto"];
            $_POST["tevkifat_kodu"] = $item[1][$i]["tevkifat_kodu"];
            $_POST["toplam_tutar"] = $item[1][$i]["toplam_tutar"];
            $_POST["tevkifat_yuzde"] = $item[1][$i]["tevkifat_yuzde"];
            $_POST["kdv_tutari"] = $item[1][$i]["kdv_tutari"];
            $_POST["iskonto_tutari"] = $item[1][$i]["iskonto_tutari"];
            $_POST["tevkifat_doviz_tutari"] = $item[1][$i]["tevkifat_doviz_tutari"];
            $_POST["cari_key"] = $cari_key;
            $_POST["sube_key"] = $sube_key;
            $irsaliye_urunleri_ekle = DB::insert("alis_irsaliye_urunler", $_POST);
            $i += 1;
            if ($irsaliye_urunleri_ekle) {
                echo 2;
            } else {
                $stok_id = $_POST["stok_id"];
                $stok_bilgileri = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");
                if ($stok_bilgileri > 0) {
                    $gonderilen_miktar = $_POST["miktar"];
                    $stok_envanter_miktar = $stok_bilgileri["giren_miktar"];
                    $yeni_miktar = floatval($gonderilen_miktar) + floatval($stok_envanter_miktar);
                    $stok_miktari_arr = [
                        'giren_miktar' => $yeni_miktar,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];
                    $stok_miktarini_guncelle = DB::update("stok", "id", $stok_id, $stok_miktari_arr);
                }
            }
        }

    }
    if ($irsaliye_urunleri_ekle) {
        echo 2;
    } else {
        $faturadaki_urunler = DB::all_data("
SELECT alis_irsaliye_urunler.*,stok.stok_kodu,stok.stok_adi,birim.birim_adi,alis_irsaliye.iskonto_toplam,alis_irsaliye.kdv_toplam,alis_irsaliye.ara_toplam,
       alis_irsaliye.genel_toplam,alis_irsaliye.tevkifat_toplam,alis_irsaliye.doviz_tur
FROM
     alis_irsaliye_urunler
INNER JOIN stok ON stok.id=alis_irsaliye_urunler.stok_id
INNER JOIN birim ON birim.id=alis_irsaliye_urunler.birim_id
INNER JOIN alis_irsaliye ON alis_irsaliye.id=alis_irsaliye_urunler.irsaliye_id
WHERE
      alis_irsaliye_urunler.status=1
AND
      alis_irsaliye_urunler.irsaliye_id='$irsaliye_id'");
        if ($faturadaki_urunler > 0) {
            if ($stok_miktarini_guncelle) {
                echo json_encode($faturadaki_urunler);
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    }
}
if ($islem == "alis_irsaliye_filtrele") {
    $bas_tarih = $_GET["bas_tarih"];
    $bit_tarih = $_GET["bit_tarih"];
    $fatura_durumu = $_GET["fatura_durumu"];
    $ek_sorgu_genel = "";
    if ($_SESSION["sube_key"] != 0) {
        $ek_sorgu_genel = " AND ai.sube_key='$sube_key'";
    }
    $sql = "
    SELECT ai.*,d.depo_adi,c.cari_adi,c.cari_kodu FROM alis_irsaliye as ai
INNER JOIN cari as c on c.id=ai.cari_id
INNER JOIN depolar as d on d.id=ai.depo_id
WHERE ai.status!=0 and ai.cari_key='$cari_key' $ek_sorgu_genel
    ";
    if ($bas_tarih != "" || $bit_tarih != "") {
        $sql .= " AND ai.irsaliye_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 00:00:00'";
    }

    if ($fatura_durumu != "") {
        $sql .= " AND ai.status='$fatura_durumu'";
    }

    $data = DB::all_data($sql);
    if ($data > 0) {
        echo json_encode($data);
    } else {
        echo 2;
    }
}
if ($islem == "cariye_ait_irsaliyeler_getir_sql") {
    $cari_id = $_GET["cari_id"];
    $ek_sube = "";
    if ($_SESSION["sube_key"] != 0) {
        $ek_sube = " AND alis_irsaliye.sube_key='$sube_key'";
    }

    $alis_irsaliye_ek = "";
    $konteyner_irsaliye_ek = "";
    $dg_ek = "";
    $dgc_ek = "";

    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        if ($bas_tarih != "" && $bit_tarih != "") {
            $alis_irsaliye_ek = " AND alis_irsaliye.irsaliye_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
            $konteyner_irsaliye_ek = " AND ki.irsaliye_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
            $dg_ek = " AND dkg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
            $dgc_ek = " AND dkg.cikis_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
        }
    }

    $merge_arr = [];
    $carinin_siparisleri = DB::all_data("SELECT alis_irsaliye.*,b.birim_adi,s.stok_adi,s.stok_kodu,aiu.miktar,alis_irsaliye.aciklama,aiu.id as ai_id
FROM alis_irsaliye
INNER JOIN alis_irsaliye_urunler as aiu on aiu.irsaliye_id=alis_irsaliye.id
INNER JOIN stok as s on s.id=aiu.stok_id
INNER JOIN birim as b on b.id=aiu.birim_id
WHERE alis_irsaliye.status=1 and aiu.status=1 and alis_irsaliye.cari_id='$cari_id'  and alis_irsaliye.cari_key='$cari_key' $alis_irsaliye_ek");

    $ek_hizmetler = DB::all_data("
SELECT 
       kieh.*,
       ki.irsaliye_no,
       ki.aciklama,
       ki.irsaliye_tarih,
       ki.konteyner_no1,
       s.stok_adi,
       s.stok_kodu,
       b.birim_adi
FROM 
     konteyner_irsaliye_ek_hizmet as kieh
INNER JOIN cari as c on c.id=kieh.cari_id
INNER JOIN konteyner_irsaliye AS ki on ki.id=kieh.irsaliye_id
INNER JOIN stok as s on s.id=kieh.hizmet_id
LEFT JOIN birim as b on b.id=s.birim
WHERE kieh.alis_status=1 AND kieh.status!=0 AND kieh.cari_key='$cari_key' AND kieh.cari_id='$cari_id' AND ki.status!=0 $konteyner_irsaliye_ek");

    $depo_giris = DB::all_data("
SELECT
       dkg.*,
       s.stok_kodu,
       s.stok_adi
FROM
     depo_konteyner_giris as dkg
INNER JOIN stok as s on s.id=dkg.stok_id
INNER JOIN arac_kartlari as ak on ak.id=dkg.plaka_id
INNER JOIN cari as c on c.id=ak.cari_id
WHERE dkg.status=1 AND dkg.cari_key='$cari_key' AND c.id='$cari_id' AND dkg.kiralik_arac_kesildi=0 $dg_ek");

    $depo_cikis = DB::all_data("
SELECT
       dkg.*,
       s.stok_kodu as stok_kiralik,
       s.stok_adi,
       dkg2.konteyner_no
FROM
     depo_konteyner_cikis as dkg
INNER JOIN stok as s on s.id=dkg.stok_id
INNER JOIN arac_kartlari as ak on ak.id=dkg.plaka_id
INNER JOIN depo_konteyner_giris as dkg2 on dkg2.id=dkg.depo_giris_id 
INNER JOIN cari as c on c.id=ak.cari_id
WHERE dkg.status=1 AND dkg.cari_key='$cari_key' AND c.id='$cari_id' AND dkg.kiralik_alis_kesildi=0 $dgc_ek");


    $depo_faturasi = DB::all_data("
    SELECT
       dkg.*,
       s.stok_kodu,
       s.stok_adi,
       dkg2.konteyner_no,
       dkg.free_time as depocu_free_time
FROM
     depo_konteyner_cikis as dkg
INNER JOIN stok as s on s.id=dkg.stok_id
INNER JOIN arac_kartlari as ak on ak.id=dkg.plaka_id
INNER JOIN depo_konteyner_giris as dkg2 on dkg2.id=dkg.depo_giris_id 
INNER JOIN cari as c on c.id=dkg.depo_id
WHERE dkg.status=1 AND dkg.cari_key='$cari_key' AND dkg.depo_id='$cari_id' AND dkg.depo_alis_kesildi=0 $dgc_ek");


    if (!empty($carinin_siparisleri)) {
        $merge_arr = array_merge($merge_arr, $carinin_siparisleri);
    }
    if (!empty($ek_hizmetler)) {
        $merge_arr = array_merge($merge_arr, $ek_hizmetler);
    }
    if (!empty($depo_giris)) {
        $merge_arr = array_merge($merge_arr, $depo_giris);
    }
    if (!empty($depo_cikis)) {
        $merge_arr = array_merge($merge_arr, $depo_cikis);
    }
    if (!empty($depo_faturasi)) {
        $merge_arr = array_merge($merge_arr, $depo_faturasi);
    }

    if ($merge_arr > 0) {
        echo json_encode($merge_arr);
    } else {
        echo 2;
    }
}
if ($islem == "secilen_irsaliyeyi_faturalastir") {
    $satis_defaultid = $_POST["satis_defaultid"];
    if (isset($_POST["select_alis_irsaliye"])) {
        foreach ($_POST["select_alis_irsaliye"] as $item2) {
            $id = $item2;
            $konteyner_irsaliye_bilgileri = DB::single_query("SELECT * FROM alis_irsaliye_urunler WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
            $stok_id = $konteyner_irsaliye_bilgileri["stok_id"];
            $fiyat = $konteyner_irsaliye_bilgileri["toplam_tutar"];
            $stok_bilgileri = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$stok_id'");

            $birim_fiyat = $konteyner_irsaliye_bilgileri["birim_fiyat"];
            $kdv_oran = $stok_bilgileri["kdv_orani"];
            $iskonto_oran = $konteyner_irsaliye_bilgileri["iskonto"];
            $miktar = $konteyner_irsaliye_bilgileri["miktar"];

            $ilk_ara_t = floatval($birim_fiyat) * floatval($miktar);
            $ilk_kdv_yuzde = $kdv_oran / 100;
            $ilk_kdv_tutar = $ilk_ara_t * $ilk_kdv_yuzde;
            $ilk_yeni_tutar = $ilk_ara_t + $ilk_kdv_tutar;

            $tevkifat = $stok_bilgileri["tevkifat_yuzde"];
            $tevkifat_yuzde = floatval($tevkifat) / 100;
            $tevkifat_tutari = $tevkifat_yuzde * $ilk_kdv_tutar;
            $ilk_yeni_tutar = $ilk_yeni_tutar - $tevkifat_tutari;


            $satis_urun = DB::single_query("SELECT * FROM alis_urunler WHERE status=1 AND cari_key='$cari_key' AND kdv_orani='$kdv_oran' AND birim_fiyat='$birim_fiyat' AND stok_id='$stok_id' AND alis_defaultid='$satis_defaultid' AND tevkifat_yuzde='$tevkifat'");

            if ($satis_urun > 0) {

                $yeni_miktar = floatval($satis_urun["miktar"]) + floatval($konteyner_irsaliye_bilgileri["miktar"]);
                $yeni_ara_toplam = floatval($satis_urun["birim_fiyat"]) * $yeni_miktar;
                $yeni_kdv_yuzde = $kdv_oran / 100;
                $kdv_tutar2 = $yeni_ara_toplam * $yeni_kdv_yuzde;
                $yeni_iskonto_yuzde = $iskonto_oran / 100;
                $yeni_iskonto_tutar = $yeni_ara_toplam * $yeni_iskonto_yuzde;
                $yeni_tutar = ($yeni_ara_toplam - $yeni_iskonto_tutar) + $kdv_tutar2;

                $tevkifat_tutari2 = $kdv_tutar2 * $tevkifat_yuzde;
                $yeni_tutar = $yeni_tutar - $tevkifat_tutari2;


                $arr = [
                    'alis_defaultid' => $satis_defaultid,
                    'stok_id' => $konteyner_irsaliye_bilgileri["stok_id"],
                    'birim_id' => $konteyner_irsaliye_bilgileri["birim_id"],
                    'miktar' => $yeni_miktar,
                    'birim_fiyat' => $satis_urun["birim_fiyat"],
                    'kdv_orani' => $kdv_oran,
                    'iskonto' => $iskonto_oran,
                    'tevkifat_kodu' => $konteyner_irsaliye_bilgileri["tevkifat_kodu"],
                    'toplam_tutar' => $yeni_tutar,
                    'insert_userid' => $_SESSION["user_id"],
                    'insert_datetime' => date("Y-m-d H:i:s"),
                    'cari_key' => $cari_key,
                    'sube_key' => $sube_key,
                    'tevkifat_tutari' => $tevkifat_tutari2,
                    'tevkifat_yuzde' => $tevkifat,
                    'kdv_tutari' => $kdv_tutar2,
                    'iskonto_tutari' => $yeni_iskonto_tutar
                ];

                $satis_fatura_urunleri = DB::update("alis_urunler", "id", $satis_urun["id"], $arr);

                $irsaliyeden_dusur_arr = [
                    'status' => 2,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];

                $implode_ids = implode(",", $_POST["select_alis_irsaliye"]);


                $irsaliye_urunler = DB::update("alis_irsaliye", "id", $konteyner_irsaliye_bilgileri["irsaliye_id"], $irsaliyeden_dusur_arr);
                $arr2 = [
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s"),
                    'irsaliye_ids' => $implode_ids,
                ];
                $satis_default_guncelle = DB::update("alis_default", "id", $satis_defaultid, $arr2);
            } else {
                $arr = [
                    'alis_defaultid' => $satis_defaultid,
                    'stok_id' => $konteyner_irsaliye_bilgileri["stok_id"],
                    'birim_id' => $konteyner_irsaliye_bilgileri["birim_id"],
                    'miktar' => $konteyner_irsaliye_bilgileri["miktar"],
                    'birim_fiyat' => $konteyner_irsaliye_bilgileri["birim_fiyat"],
                    'kdv_orani' => $kdv_oran,
                    'iskonto' => $konteyner_irsaliye_bilgileri["iskonto"],
                    'tevkifat_kodu' => $konteyner_irsaliye_bilgileri["tevkifat_kodu"],
                    'toplam_tutar' => $ilk_yeni_tutar,
                    'insert_userid' => $_SESSION["user_id"],
                    'insert_datetime' => date("Y-m-d H:i:s"),
                    'cari_key' => $cari_key,
                    'sube_key' => $sube_key,
                    'tevkifat_tutari' => $tevkifat_tutari,
                    'tevkifat_yuzde' => $tevkifat,
                    'kdv_tutari' => $ilk_kdv_tutar,
                    'iskonto_tutari' => $konteyner_irsaliye_bilgileri["iskonto_tutari"]
                ];

                $satis_fatura_urunleri = DB::insert("alis_urunler", $arr);

                $implode_ids = implode(",", $_POST["select_alis_irsaliye"]);

                $irsaliyeden_dusur_arr = [
                    'status' => 2,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];

                $irsaliye_urunler = DB::update("alis_irsaliye", "id", $konteyner_irsaliye_bilgileri["irsaliye_id"], $irsaliyeden_dusur_arr);

                $arr2 = [
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s"),
                    'irsaliye_ids' => $implode_ids,
                ];
                $satis_default_guncelle = DB::update("alis_default", "id", $satis_defaultid, $arr2);

            }

        }
    }
    if (isset($_POST["ek_hizmet_arr"])) {
        foreach ($_POST["ek_hizmet_arr"] as $item3) {
            $id = $item3;
            $ek_hizmet_bilgisi = DB::single_query("SELECT * FROM konteyner_irsaliye_ek_hizmet WHERE alis_status=1 AND cari_key='$cari_key' AND id='$id'");
            $stok_id = $ek_hizmet_bilgisi["hizmet_id"];
            $fiyat = $ek_hizmet_bilgisi["alis_fiyat"];

            $stok_bilgileri = DB::single_query("SELECT * FROM stok WHERE status=1 AND cari_key='$cari_key' AND id='$stok_id'");
            $kdv_yuzde = floatval($stok_bilgileri["kdv_orani"]) / 100;
            $kdv_tutar = floatval($fiyat) * floatval($kdv_yuzde);
            $yeni_tutar = $kdv_tutar + $fiyat;
            $satis_urun = DB::single_query("SELECT * FROM alis_urunler WHERE status=1 AND cari_key='$cari_key' AND alis_defaultid='$satis_defaultid' AND stok_id='$stok_id' AND birim_fiyat='$fiyat'");

            if ($satis_urun > 0) {
                $miktar_dizi = floatval($satis_urun["miktar"]) + 1;
                $fiyat_dizi = floatval($ek_hizmet_bilgisi["alis_fiyat"]) + floatval($satis_urun["alis_fiyat"]);

                $tekrar_ara_toplam = $miktar_dizi * floatval($ek_hizmet_bilgisi["alis_fiyat"]);
                $tekrar_kdv_tutar = $tekrar_ara_toplam * floatval($kdv_yuzde);
                $tekrar_yeni_tutar = $tekrar_ara_toplam + $tekrar_kdv_tutar;


                $arr = [
                    'alis_defaultid' => $satis_defaultid,
                    'stok_id' => $stok_id,
                    'birim_id' => $stok_bilgileri["birim"],
                    'miktar' => $miktar_dizi,
                    'birim_fiyat' => $ek_hizmet_bilgisi["alis_fiyat"],
                    'kdv_orani' => $stok_bilgileri["kdv_orani"],
                    'iskonto' => 0,
                    'tevkifat_kodu' => "",
                    'toplam_tutar' => $tekrar_yeni_tutar,
                    'insert_userid' => $_SESSION["user_id"],
                    'insert_datetime' => date("Y-m-d H:i:s"),
                    'cari_key' => $cari_key,
                    'sube_key' => $sube_key,
                    'tevkifat_tutari' => 0,
                    'kdv_tutari' => $tekrar_kdv_tutar,
                    'iskonto_tutari' => 0
                ];
                $satis_fatura_urunleri = DB::update("alis_urunler", "id", $satis_urun["id"], $arr);
                $irsaliyeden_dusur_arr = [
                    'alis_status' => 2,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];

                $irsaliye_urunler = DB::update("konteyner_irsaliye_ek_hizmet", "id", $item3, $irsaliyeden_dusur_arr);

                $implode_ids = implode(",", $_POST["ek_hizmet_arr"]);
                $arr2 = [
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s"),
                    'ek_hizmet_ids' => $implode_ids
                ];
                $satis_default_guncelle = DB::update("alis_default", "id", $satis_defaultid, $arr2);
            } else {
                $arr = [
                    'alis_defaultid' => $satis_defaultid,
                    'stok_id' => $stok_id,
                    'birim_id' => $stok_bilgileri["birim"] ?? 0,
                    'miktar' => 1,
                    'birim_fiyat' => $ek_hizmet_bilgisi["alis_fiyat"],
                    'kdv_orani' => $stok_bilgileri["kdv_orani"],
                    'iskonto' => 0,
                    'tevkifat_kodu' => "",
                    'toplam_tutar' => $yeni_tutar,
                    'insert_userid' => $_SESSION["user_id"],
                    'insert_datetime' => date("Y-m-d H:i:s"),
                    'cari_key' => $cari_key,
                    'sube_key' => $sube_key,
                    'tevkifat_tutari' => 0,
                    'kdv_tutari' => $kdv_tutar,
                    'iskonto_tutari' => 0
                ];
                $satis_fatura_urunleri = DB::insert("alis_urunler", $arr);
                $irsaliyeden_dusur_arr = [
                    'alis_status' => 2,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];

                $irsaliye_urunler = DB::update("konteyner_irsaliye_ek_hizmet", "id", $item3, $irsaliyeden_dusur_arr);
                $implode_ids = implode(",", $_POST["ek_hizmet_arr"]);
                $arr2 = [
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s"),
                    'ek_hizmet_ids' => $implode_ids
                ];
                $satis_default_guncelle = DB::update("alis_default", "id", $satis_defaultid, $arr2);
            }
        }
    }
    if (isset($_POST["select_depo_cikis_firma"])) {
        foreach ($_POST["select_depo_cikis_firma"] as $item3) {
            $id = $item3;
            $ek_hizmet_bilgisi = DB::single_query("SELECT * FROM depo_konteyner_cikis WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
            $stok_id = $ek_hizmet_bilgisi["stok_id"];
            $fiyat = $ek_hizmet_bilgisi["depo_bedeli"];

            $stok_bilgileri = DB::single_query("SELECT * FROM stok WHERE status=1 AND cari_key='$cari_key' AND id='$stok_id'");
            $kdv_yuzde = floatval($stok_bilgileri["kdv_orani"]) / 100;
            $kdv_tutar = floatval($fiyat) * floatval($kdv_yuzde);
            $yeni_tutar = $kdv_tutar + $fiyat;
            $satis_urun = DB::single_query("SELECT * FROM alis_urunler WHERE status=1 AND cari_key='$cari_key' AND alis_defaultid='$satis_defaultid' AND stok_id='$stok_id' AND birim_fiyat='$fiyat'");

            if ($satis_urun > 0) {
                $miktar_dizi = floatval($satis_urun["miktar"]) + 1;
                $fiyat_dizi = floatval($ek_hizmet_bilgisi["depo_bedeli"]) + floatval($satis_urun["birim_fiyat"]);

                $tekrar_ara_toplam = $miktar_dizi * floatval($ek_hizmet_bilgisi["depo_bedeli"]);
                $tekrar_kdv_tutar = $tekrar_ara_toplam * floatval($kdv_yuzde);
                $tekrar_yeni_tutar = $tekrar_ara_toplam + $tekrar_kdv_tutar;


                $arr = [
                    'alis_defaultid' => $satis_defaultid,
                    'stok_id' => $ek_hizmet_bilgisi["stok_id"],
                    'birim_id' => $stok_bilgileri["birim"],
                    'miktar' => $miktar_dizi,
                    'birim_fiyat' => $ek_hizmet_bilgisi["depo_bedeli"],
                    'kdv_orani' => $stok_bilgileri["kdv_orani"],
                    'iskonto' => 0,
                    'tevkifat_kodu' => "",
                    'toplam_tutar' => $tekrar_yeni_tutar,
                    'insert_userid' => $_SESSION["user_id"],
                    'insert_datetime' => date("Y-m-d H:i:s"),
                    'cari_key' => $cari_key,
                    'sube_key' => $sube_key,
                    'tevkifat_tutari' => 0,
                    'kdv_tutari' => $tekrar_kdv_tutar,
                    'iskonto_tutari' => 0
                ];
                $satis_fatura_urunleri = DB::update("alis_urunler", "id", $satis_urun["id"], $arr);
                $irsaliyeden_dusur_arr = [
                    'depo_alis_kesildi' => 1,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];

                $irsaliye_urunler = DB::update("depo_konteyner_cikis", "id", $item3, $irsaliyeden_dusur_arr);
                $implode_ids = implode(",", $_POST["select_depo_cikis_firma"]);
                $arr2 = [
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s"),
                    'depo_ids' => $implode_ids
                ];
                $satis_default_guncelle = DB::update("alis_default", "id", $satis_defaultid, $arr2);
            } else {
                $arr = [
                    'alis_defaultid' => $satis_defaultid,
                    'stok_id' => $ek_hizmet_bilgisi["stok_id"],
                    'birim_id' => $stok_bilgileri["birim"] ?? 0,
                    'miktar' => 1,
                    'birim_fiyat' => $ek_hizmet_bilgisi["depo_bedeli"],
                    'kdv_orani' => $stok_bilgileri["kdv_orani"],
                    'iskonto' => 0,
                    'tevkifat_kodu' => "",
                    'toplam_tutar' => $yeni_tutar,
                    'insert_userid' => $_SESSION["user_id"],
                    'insert_datetime' => date("Y-m-d H:i:s"),
                    'cari_key' => $cari_key,
                    'sube_key' => $sube_key,
                    'tevkifat_tutari' => 0,
                    'kdv_tutari' => $kdv_tutar,
                    'iskonto_tutari' => 0
                ];
                $satis_fatura_urunleri = DB::insert("alis_urunler", $arr);
                $irsaliyeden_dusur_arr = [
                    'depo_alis_kesildi' => 1,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];

                $irsaliye_urunler = DB::update("depo_konteyner_cikis", "id", $item3, $irsaliyeden_dusur_arr);
                $implode_ids = implode(",", $_POST["select_depo_cikis_firma"]);
                $arr2 = [
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s"),
                    'depo_ids' => $implode_ids
                ];
                $satis_default_guncelle = DB::update("alis_default", "id", $satis_defaultid, $arr2);
            }
        }
    }
    if (isset($_POST["select_giris_kiralik"])) {
        foreach ($_POST["select_giris_kiralik"] as $item3) {
            $id = $item3;
            $ek_hizmet_bilgisi = DB::single_query("SELECT * FROM depo_konteyner_giris WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
            $stok_id = $ek_hizmet_bilgisi["stok_id"];
            $fiyat = $ek_hizmet_bilgisi["arac_kirasi"];

            $stok_bilgileri = DB::single_query("SELECT * FROM stok WHERE status=1 AND cari_key='$cari_key' AND id='$stok_id'");
            $kdv_yuzde = floatval($stok_bilgileri["kdv_orani"]) / 100;
            $kdv_tutar = floatval($fiyat) * floatval($kdv_yuzde);
            $yeni_tutar = $kdv_tutar + $fiyat;
            $satis_urun = DB::single_query("SELECT * FROM alis_urunler WHERE status=1 AND cari_key='$cari_key' AND alis_defaultid='$satis_defaultid' AND stok_id='$stok_id' AND birim_fiyat='$fiyat'");

            if ($satis_urun > 0) {
                $miktar_dizi = floatval($satis_urun["miktar"]) + 1;
                $fiyat_dizi = floatval($ek_hizmet_bilgisi["arac_kirasi"]) + floatval($satis_urun["birim_fiyat"]);

                $tekrar_ara_toplam = $miktar_dizi * floatval($ek_hizmet_bilgisi["arac_kirasi"]);
                $tekrar_kdv_tutar = $tekrar_ara_toplam * floatval($kdv_yuzde);
                $tekrar_yeni_tutar = $tekrar_ara_toplam + $tekrar_kdv_tutar;


                $arr = [
                    'alis_defaultid' => $satis_defaultid,
                    'stok_id' => $ek_hizmet_bilgisi["stok_id"],
                    'birim_id' => $stok_bilgileri["birim"],
                    'miktar' => $miktar_dizi,
                    'birim_fiyat' => $ek_hizmet_bilgisi["arac_kirasi"],
                    'kdv_orani' => $stok_bilgileri["kdv_orani"],
                    'iskonto' => 0,
                    'tevkifat_kodu' => "",
                    'toplam_tutar' => $tekrar_yeni_tutar,
                    'insert_userid' => $_SESSION["user_id"],
                    'insert_datetime' => date("Y-m-d H:i:s"),
                    'cari_key' => $cari_key,
                    'sube_key' => $sube_key,
                    'tevkifat_tutari' => 0,
                    'kdv_tutari' => $tekrar_kdv_tutar,
                    'iskonto_tutari' => 0
                ];
                $satis_fatura_urunleri = DB::update("alis_urunler", "id", $satis_urun["id"], $arr);
                $irsaliyeden_dusur_arr = [
                    'kiralik_arac_kesildi' => 1,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];

                $irsaliye_urunler = DB::update("depo_konteyner_giris", "id", $item3, $irsaliyeden_dusur_arr);
                $implode_ids = implode(",", $_POST["select_giris_kiralik"]);
                $arr2 = [
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s"),
                    'kiralik_depo_ids' => $implode_ids
                ];
                $satis_default_guncelle = DB::update("alis_default", "id", $satis_defaultid, $arr2);
            } else {
                $arr = [
                    'alis_defaultid' => $satis_defaultid,
                    'stok_id' => $ek_hizmet_bilgisi["stok_id"],
                    'birim_id' => $stok_bilgileri["birim"] ?? 0,
                    'miktar' => 1,
                    'birim_fiyat' => $ek_hizmet_bilgisi["arac_kirasi"],
                    'kdv_orani' => $stok_bilgileri["kdv_orani"],
                    'iskonto' => 0,
                    'tevkifat_kodu' => "",
                    'toplam_tutar' => $yeni_tutar,
                    'insert_userid' => $_SESSION["user_id"],
                    'insert_datetime' => date("Y-m-d H:i:s"),
                    'cari_key' => $cari_key,
                    'sube_key' => $sube_key,
                    'tevkifat_tutari' => 0,
                    'kdv_tutari' => $kdv_tutar,
                    'iskonto_tutari' => 0
                ];
                $satis_fatura_urunleri = DB::insert("alis_urunler", $arr);
                $irsaliyeden_dusur_arr = [
                    'kiralik_arac_kesildi' => 1,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];

                $irsaliye_urunler = DB::update("depo_konteyner_giris", "id", $item3, $irsaliyeden_dusur_arr);
                $implode_ids = implode(",", $_POST["select_giris_kiralik"]);
                $arr2 = [
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s"),
                    'kiralik_depo_ids' => $implode_ids
                ];
                $satis_default_guncelle = DB::update("alis_default", "id", $satis_defaultid, $arr2);
            }
        }
    }
    if (isset($_POST["select_cikis_kiralik"])) {
        foreach ($_POST["select_cikis_kiralik"] as $item4) {
            $id = $item4;
            $ek_hizmet_bilgisi = DB::single_query("SELECT * FROM depo_konteyner_cikis WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
            $stok_id = $ek_hizmet_bilgisi["stok_id"];
            $fiyat = $ek_hizmet_bilgisi["arac_kirasi"];

            $stok_bilgileri = DB::single_query("SELECT * FROM stok WHERE status=1 AND cari_key='$cari_key' AND id='$stok_id'");
            $kdv_yuzde = floatval($stok_bilgileri["kdv_orani"]) / 100;
            $kdv_tutar = floatval($fiyat) * floatval($kdv_yuzde);
            $yeni_tutar = $kdv_tutar + $fiyat;
            $satis_urun = DB::single_query("SELECT * FROM alis_urunler WHERE status=1 AND cari_key='$cari_key' AND alis_defaultid='$satis_defaultid' AND stok_id='$stok_id' AND birim_fiyat='$fiyat'");

            if ($satis_urun > 0) {
                $miktar_dizi = floatval($satis_urun["miktar"]) + 1;
                $fiyat_dizi = floatval($ek_hizmet_bilgisi["arac_kirasi"]) + floatval($satis_urun["birim_fiyat"]);

                $tekrar_ara_toplam = $miktar_dizi * floatval($ek_hizmet_bilgisi["arac_kirasi"]);
                $tekrar_kdv_tutar = $tekrar_ara_toplam * floatval($kdv_yuzde);
                $tekrar_yeni_tutar = $tekrar_ara_toplam + $tekrar_kdv_tutar;


                $arr = [
                    'alis_defaultid' => $satis_defaultid,
                    'stok_id' => $ek_hizmet_bilgisi["stok_id"],
                    'birim_id' => $stok_bilgileri["birim"],
                    'miktar' => $miktar_dizi,
                    'birim_fiyat' => $ek_hizmet_bilgisi["arac_kirasi"],
                    'kdv_orani' => $stok_bilgileri["kdv_orani"],
                    'iskonto' => 0,
                    'tevkifat_kodu' => "",
                    'toplam_tutar' => $tekrar_yeni_tutar,
                    'insert_userid' => $_SESSION["user_id"],
                    'insert_datetime' => date("Y-m-d H:i:s"),
                    'cari_key' => $cari_key,
                    'sube_key' => $sube_key,
                    'tevkifat_tutari' => 0,
                    'kdv_tutari' => $tekrar_kdv_tutar,
                    'iskonto_tutari' => 0
                ];
                $satis_fatura_urunleri = DB::update("alis_urunler", "id", $satis_urun["id"], $arr);
                $irsaliyeden_dusur_arr = [
                    'kiralik_alis_kesildi' => 1,
                    'aciklama' => "depo_kiralik",
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];

                $irsaliye_urunler = DB::update("depo_konteyner_cikis", "id", $item4, $irsaliyeden_dusur_arr);
                $implode_ids = implode(",", $_POST["select_cikis_kiralik"]);
                $arr2 = [
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s"),
                    'kiralik_cikis_depo_ids' => $implode_ids
                ];
                $satis_default_guncelle = DB::update("alis_default", "id", $satis_defaultid, $arr2);
            } else {
                $arr = [
                    'alis_defaultid' => $satis_defaultid,
                    'stok_id' => $ek_hizmet_bilgisi["stok_id"],
                    'birim_id' => $stok_bilgileri["birim"] ?? 0,
                    'miktar' => 1,
                    'birim_fiyat' => $ek_hizmet_bilgisi["arac_kirasi"],
                    'kdv_orani' => $stok_bilgileri["kdv_orani"],
                    'iskonto' => 0,
                    'tevkifat_kodu' => "",
                    'toplam_tutar' => $yeni_tutar,
                    'insert_userid' => $_SESSION["user_id"],
                    'insert_datetime' => date("Y-m-d H:i:s"),
                    'cari_key' => $cari_key,
                    'sube_key' => $sube_key,
                    'tevkifat_tutari' => 0,
                    'kdv_tutari' => $kdv_tutar,
                    'iskonto_tutari' => 0
                ];
                $satis_fatura_urunleri = DB::insert("alis_urunler", $arr);
                $irsaliyeden_dusur_arr = [
                    'kiralik_alis_kesildi' => 1,
                    'aciklama' => "depo_kiralik",
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];

                $irsaliye_urunler = DB::update("depo_konteyner_cikis", "id", $item4, $irsaliyeden_dusur_arr);
                $implode_ids = implode(",", $_POST["select_cikis_kiralik"]);
                $arr2 = [
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s"),
                    'kiralik_cikis_depo_ids' => $implode_ids
                ];
                $satis_default_guncelle = DB::update("alis_default", "id", $satis_defaultid, $arr2);
            }
        }
    }


    $faturadaki_urunler = DB::all_data("
SELECT alis_urunler.*,stok.stok_kodu,stok.stok_adi,birim.birim_adi,alis_default.iskonto_toplam,alis_default.kdv_toplam,alis_default.ara_toplam,
       alis_default.genel_toplam,alis_default.tevkifat_toplam,alis_default.doviz_tur,alis_default.irsaliye_no,alis_default.irsaliye_tarih
FROM 
     alis_urunler
INNER JOIN stok ON stok.id=alis_urunler.stok_id
INNER JOIN birim ON birim.id=alis_urunler.birim_id
INNER JOIN alis_default ON alis_default.id=alis_urunler.alis_defaultid
WHERE 
      alis_urunler.status=1 
AND 
      alis_urunler.alis_defaultid='$satis_defaultid' and alis_urunler.cari_key='$cari_key'");
    if ($faturadaki_urunler > 0) {
        echo json_encode($faturadaki_urunler);
    } else {
        echo 2;
    }
}
if ($islem == "secilen_fatura_bilgilerini_getir") {
    $id = $_GET["id"];

    $arr = [
        'genel_toplam' => $_GET["genel_toplam"],
        'kdv_toplam' => $_GET["kdv_toplam"],
        'ara_toplam' => $_GET["ara_toplam"],
        'iskonto_toplam' => $_GET["iskonto_toplam"],
        'tevkifat_toplam' => $_GET["tevkifat_toplam"]
    ];

    $guncelle = DB::update("alis_default", "id", $id, $arr);

    $ust_bilgileri_getir = DB::single_query("SELECT * FROM alis_default WHERE id='$id'");
    if ($ust_bilgileri_getir > 0) {
        echo json_encode($ust_bilgileri_getir);
    } else {
        echo 2;
    }
}
if ($islem == "fatura_turlerini_getir_sql") {
    $fatura_turlerini_getir = DB::all_data("SELECT * FROM fatura_tur_tanim WHERE status=1 AND cari_key='$cari_key' AND modul_id=1");
    if ($fatura_turlerini_getir > 0) {
        echo json_encode($fatura_turlerini_getir);
    } else {
        echo 2;
    }
}
if ($islem == "fatura_tipi_getir_sql") {
    $fatura_turlerini_getir = DB::all_data("SELECT * FROM fatura_tip_tanim WHERE status=1 AND cari_key='$cari_key' AND modul_id=1");
    if ($fatura_turlerini_getir > 0) {
        echo json_encode($fatura_turlerini_getir);
    } else {
        echo 2;
    }
}
if ($islem == "aktarma_icin_satis_faturasi_olustur_sql") {
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $satis_faturasi = DB::insert("alis_default", $_POST);
    if ($satis_faturasi) {
        echo 2;
    } else {
        $son_eklenen = DB::single_query("SELECT id FROM alis_default where  cari_key='$cari_key' $ek_sorgu ORDER BY id DESC LIMIT 1");
        echo 'id:' . $son_eklenen["id"];
    }
}
if ($islem == "vade_tarihi_getir_sql") {
    $cari_id = $_GET["cari_id"];
    $cari_bilgi = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
    if ($cari_bilgi > 0) {
        echo json_encode($cari_bilgi);
    } else {
        echo 2;
    }
}
if ($islem == "saticilara_gore_fatura_listesi_sql") {
    $sql = "
SELECT 
       SUM(ad.ara_toplam) as ara_toplam,
       SUM(ad.kdv_toplam) as kdv_toplam,
       SUM(ad.genel_toplam) as genel_toplam,
       COUNT(ad.id) as toplam_fatura,
       ad.doviz_tur,
       c.cari_adi,
       c.cari_kodu
FROM 
     alis_default as ad
INNER JOIN cari AS c on c.id=ad.cari_id
INNER JOIN cari_turleri_tanim as ctt on ctt.id=c.cari_turu
WHERE ad.status=1 AND ad.cari_key='$cari_key'";

    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        if ($bas_tarih != "" && $bit_tarih != "") {
            $sql .= " AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
        }
    }
    if (isset($_GET["doviz_turu"])) {
        $doviz_turu = $_GET["doviz_turu"];
        if ($doviz_turu != "") {
            $sql .= " AND ad.doviz_tur='$doviz_turu'";
        }
    }
    if (isset($_GET["cari_adi"])) {
        $cari_adi = $_GET["cari_adi"];
        if ($cari_adi != "") {
            $sql .= " AND c.cari_adi LIKE '%$cari_adi%'";
        }
    }

    if (isset($_GET["cari_turu_adi"])) {
        $cari_turu_adi = $_GET["cari_turu_adi"];
        if ($cari_turu_adi != "") {
            $sql .= "  AND c.cari_turu='$cari_turu_adi'";
        }
    }


    $sql .= " GROUP BY c.id,ad.doviz_tur ORDER BY genel_toplam DESC";
    $tum_alislar = DB::all_data($sql);

    $gidecek_arr = [];
    $ara_tot = 0;
    $kdv_tot = 0;
    $genel_tot = 0;
    foreach ($tum_alislar as $item) {
        $arr = [
            'cari_adi' => $item["cari_adi"],
            'cari_kodu' => $item["cari_kodu"],
            'doviz_tur' => $item["doviz_tur"],
            'toplam_fatura' => $item["toplam_fatura"],
            'ara_toplam' => number_format($item["ara_toplam"], 2),
            'kdv_toplam' => number_format($item["kdv_toplam"], 2),
            'genel_toplam' => number_format($item["genel_toplam"], 2)
        ];
        $ara_tot += $item["ara_toplam"];
        $kdv_tot += $item["kdv_toplam"];
        $genel_tot += $item["genel_toplam"];
        array_push($gidecek_arr, $arr);
        $gidecek_arr[0]["tl_ara_tot"] = number_format($ara_tot, 2);
        $gidecek_arr[0]["tl_kdv_tot"] = number_format($kdv_tot, 2);
        $gidecek_arr[0]["tl_genel_tot"] = number_format($genel_tot, 2);
    }


    if (!empty($gidecek_arr)) {
        echo json_encode($gidecek_arr);
    } else {
        echo 2;
    }

}