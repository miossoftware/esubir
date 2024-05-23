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
if ($sube_key != 0) {
    $ek_sorgu = " AND sube_key='$sube_key'";
}
if ($islem == "kasalari_getir") {
    $kasalar = DB::all_data("SELECT * FROM kasa WHERE status=1 and cari_key='$cari_key' $ek_sorgu");
    if ($kasalar > 0) {
        $banka_ekstre_arr = [];
        $b_durum = "";
        $ekstre_arr = [];
        $last_bas_tarih = date("Y-m-d");
        foreach ($kasalar as $kasa) {
            $kasa_devir_giren_tutar = 0;
            $kasa_devir_cikan_tutar = 0;
            $kasa_devir_bakiye = 0;
            $kasa_id = $kasa["id"];
            $kasa_tahsilat = DB::all_data("
SELECT
tahsilat_toplam
FROM
kasa_tahsilat
WHERE status=1 AND kasa_id='$kasa_id' AND cari_key='$cari_key' AND islem_tarihi < '$last_bas_tarih 23:59:59'
");
            if ($kasa_tahsilat > 0) {
                foreach ($kasa_tahsilat as $alislar) {
                    $kasa_devir_giren_tutar += $alislar["tahsilat_toplam"];
                }
            }

            $bireysel_tahakkuk = DB::all_data("
SELECT
bt.tutar
FROM
bireysel_tahakkuk as bt
INNER JOIN uye_tanim as ut on ut.id=bt.uye_id
WHERE bt.status=1 AND bt.kasa_id='$kasa_id' AND bt.cari_key='$cari_key' AND bt.tarih < '$last_bas_tarih 23:59:59'
");
            if ($bireysel_tahakkuk > 0) {
                foreach ($bireysel_tahakkuk as $alislar) {
                    $kasa_devir_giren_tutar += $alislar["tutar"];
                }
            }

            $binek_vergi = DB::all_data("
SELECT
       bvgf.*,
       bvg.tarih,
       bk.arac_plaka
FROM
     binek_vergi_gider as bvg
INNER JOIN binek_vergi_gider_fisleri AS bvgf on bvgf.gider_id=bvg.id
INNER JOIN binek_kartlari as bk on bk.id=bvgf.plaka_id
WHERE bvgf.status=1 AND bvg.status=1 AND bvg.cari_key='$cari_key' AND bvgf.kasa_id='$kasa_id' AND  bvg.tarih < '$last_bas_tarih 23:59:59'
     ");
            if ($binek_vergi > 0) {
                foreach ($binek_vergi as $alislar) {
                    $kasa_devir_cikan_tutar += $alislar["tutar"];
                }
            }

            $hgs_gider = DB::all_data("
SELECT
       bhgf.tutar
FROM
     binek_hgs_gider as bhg
INNER JOIN binek_hgs_gider_fisleri AS bhgf on bhgf.gider_id=bhg.id
WHERE bhg.status=1 AND bhgf.status=1 AND bhgf.kasa_id='$kasa_id' AND bhg.tarih < '$last_bas_tarih 23:59:59'
     ");
            if ($hgs_gider > 0) {
                foreach ($hgs_gider as $alislar) {
                    $kasa_devir_cikan_tutar += $alislar["tutar"];
                }
            }

            $satis_faturalari = DB::all_data("
SELECT
miktar,
tl_tutar
FROM
binek_yakit_cikis
WHERE status!=0 AND tarih < '$last_bas_tarih 23:59:59' AND kasa_id='$kasa_id'
");
            if ($satis_faturalari > 0) {
                foreach ($satis_faturalari as $alislar) {
                    $kasa_devir_cikan_tutar += $alislar["tl_tutar"];
                }
            }

            $prim_odeme = DB::all_data("
SELECT
pou.prim_tutari
FROM
prim_odeme_urunler as pou
INNER JOIN prim_odeme AS po on po.id=pou.odeme_id 
WHERE pou.status=1 AND po.kasa_id='$kasa_id' AND pou.cari_key='$cari_key' AND po.status=1 AND po.odeme_tarihi < '$last_bas_tarih 23:59:59'
");
            if ($prim_odeme > 0) {
                foreach ($prim_odeme as $alislar) {
                    $kasa_devir_cikan_tutar += $alislar["prim_tutari"];
                }
            }
            $perakende_satislar = DB::all_data("
SELECT
       ps.*,
       (SELECT SUM(genel_toplam) FROM perakende_satis_urunler WHERE satis_id = ps.id) AS toplam_tutar
FROM 
     perakende_satis as ps
INNER JOIN perakende_satis_urunler as psu
WHERE ps.status=1 AND psu.status=1 AND ps.cari_key='$cari_key' AND ps.kasa_id='$kasa_id' AND psu.status=1 AND ps.fatura_tarihi < '$last_bas_tarih 23:59:59'  GROUP BY ps.id
");
            if ($perakende_satislar > 0) {
                foreach ($perakende_satislar as $alislar) {
                    $kasa_devir_giren_tutar += $alislar["toplam_tutar"];
                }
            }
            $kasa_odeme = DB::all_data("
SELECT
odeme_toplam
FROM
kasa_odeme
WHERE status=1 AND kasa_id='$kasa_id' AND cari_key='$cari_key' AND islem_tarihi  < '$last_bas_tarih 23:59:59'
");
            if ($kasa_odeme > 0) {
                foreach ($kasa_odeme as $alislar) {
                    $kasa_devir_cikan_tutar += $alislar["odeme_toplam"];
                }
            }
            $havale_cikis = DB::all_data("
SELECT
tecu.tutar
FROM
tahsil_edilen_cek_urunler as tecu
INNER JOIN tahsil_edilen_cek_senet as tecs on tecs.id=tecu.tahsil_id
WHERE tecu.status=1 AND tecs.kasa_id='$kasa_id' AND tecu.cari_key='$cari_key' AND tecs.tarih  < '$last_bas_tarih 23:59:59'
");
            if ($havale_cikis > 0) {
                foreach ($havale_cikis as $alislar) {
                    $kasa_devir_giren_tutar += $alislar["tutar"];
                }
            }
            $havale_cikis = DB::all_data("
SELECT
tecu.tutar
FROM
tahsil_edilen_senet_urunler as tecu
INNER JOIN tahsil_edilen_senet as tecs on tecs.id=tecu.tahsilat_id
WHERE tecu.status=1 AND tecs.kasa_id='$kasa_id' AND tecu.cari_key='$cari_key' AND tecs.tarih  < '$last_bas_tarih 23:59:59'
");
            if ($havale_cikis > 0) {
                foreach ($havale_cikis as $alislar) {
                    $kasa_devir_giren_tutar += $alislar["tutar"];
                }
            }
//            $kasa_odeme = DB::all_data("
//SELECT
//odeme_toplam
//FROM
//kasa_odeme
//WHERE status=1 AND kasa_id='$kasa_id' AND cari_key='$cari_key' AND islem_tarihi  < '$last_bas_tarih 23:59:59'
//");
//            if ($kasa_odeme > 0) {
//                foreach ($kasa_odeme as $alislar) {
//                    $kasa_devir_cikan_tutar += $alislar["odeme_toplam"];
//                }
//            }
            $bankaya_yatan = DB::all_data("
SELECT
gonderilen_tutar
FROM
kasadan_bankaya
WHERE status=1 AND kasa_id='$kasa_id' AND cari_key='$cari_key' AND tarih  < '$last_bas_tarih 23:59:59'
");
            if ($bankaya_yatan > 0) {
                foreach ($bankaya_yatan as $alislar) {
                    $kasa_devir_cikan_tutar += $alislar["gonderilen_tutar"];
                }
            }
            $kasaya_cekilen = DB::all_data("
SELECT
gonderilen_tutar
FROM
bankadan_kasaya
WHERE status=1 AND kasa_id='$kasa_id' AND cari_key='$cari_key' AND tarih < '$last_bas_tarih 23:59:59'
");
            if ($kasaya_cekilen > 0) {
                foreach ($kasaya_cekilen as $alislar) {
                    $kasa_devir_giren_tutar += $alislar["gonderilen_tutar"];
                }
            }
            $kasa_virman_giren = DB::all_data("
SELECT
gonderilen_miktar
FROM
kasa_virman
WHERE status=1 AND alan_kasaid='$kasa_id' AND cari_key='$cari_key' AND tarih < '$last_bas_tarih 23:59:59'
");
            if ($kasa_virman_giren > 0) {
                foreach ($kasa_virman_giren as $alislar) {
                    $kasa_devir_giren_tutar += $alislar["gonderilen_miktar"];
                }
            }
            $kasa_virman_cikan = DB::all_data("
SELECT
gonderilen_miktar
FROM
kasa_virman
WHERE status=1 AND gonderen_kasaid='$kasa_id' AND cari_key='$cari_key' AND tarih < '$last_bas_tarih 23:59:59'
");
            if ($kasa_virman_cikan > 0) {
                foreach ($kasa_virman_cikan as $alislar) {
                    $kasa_devir_cikan_tutar += $alislar["gonderilen_miktar"];
                }
            }
            $kasa_acilis_giren = DB::all_data("
SELECT
giren_tutar,
acilis_tarihi
FROM
kasa_acilis_fisi
WHERE status=1 AND kasa_id='$kasa_id' AND cari_key='$cari_key' AND acilis_tarihi < '$last_bas_tarih 23:59:59'
");
            if ($kasa_acilis_giren > 0) {
                foreach ($kasa_acilis_giren as $alislar) {
                    $kasa_devir_giren_tutar += $alislar["giren_tutar"];
                }
            }
            $kasa_acilis_cikan = DB::all_data("
SELECT
cikan_tutar,
acilis_tarihi
FROM
kasa_acilis_fisi
WHERE status=1 AND kasa_id='$kasa_id' AND cari_key='$cari_key' AND acilis_tarihi < '$last_bas_tarih 23:59:59'
");
            if ($kasa_acilis_cikan > 0) {
                foreach ($kasa_acilis_cikan as $alislar) {
                    $kasa_devir_cikan_tutar += $alislar["cikan_tutar"];
                }
            }
            $kasa_devir_bakiye = floatval($kasa_devir_cikan_tutar) - floatval($kasa_devir_giren_tutar);
            if ($kasa_devir_bakiye < 0) {
                $kasa_devir_bakiye = -$kasa_devir_bakiye;
                $b_durum = "A";
            } else if ($kasa_devir_bakiye == 0) {
                $b_durum = "YOK";
            } else {
                $b_durum = "B";
            }
            if ($kasa_devir_cikan_tutar == 0 || $kasa_devir_cikan_tutar == null) {
                $kasa_devir_cikan_tutar = 0;
            }
            if ($kasa_devir_giren_tutar == 0 || $kasa_devir_giren_tutar == null) {
                $kasa_devir_giren_tutar = 0;
            }
            $arr = [
                'kasa_kodu' => $kasa["kasa_kodu"],
                'kasa_adi' => $kasa["kasa_adi"],
                'giren_tutar' => $kasa_devir_giren_tutar,
                'cikan_tutar' => $kasa_devir_cikan_tutar,
                'varsayilan_kasa' => $kasa["varsayilan_kasa"]
            ];
            array_push($ekstre_arr, $arr);
        }
        if ($ekstre_arr > 0) {
            echo json_encode($ekstre_arr);
        }
    } else {
        echo 2;
    }
}
if ($islem == "yeni_kasa_tanimla_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $kasa_kodu = $_POST["kasa_kodu"];
    $kasa_kodu_varmi = DB::single_query("SELECT * FROM kasa WHERE status=1 AND kasa_kodu='$kasa_kodu' AND cari_key='$cari_key' $ek_sorgu");
    if ($kasa_kodu_varmi > 0) {
        echo 300;
    } else {
        $varsayilan_varmi = DB::single_query("select * from kasa where status=1 and cari_key='$cari_key' $ek_sorgu NOT IN (varsayilan_kasa=0)");
        if ($_POST["varsayilan_kasa"] == "1" && $varsayilan_varmi > 0) {
            $id = $varsayilan_varmi["id"];
            $arr = [
                'varsayilan_kasa' => 0
            ];
            $varsayilani_degis = DB::update("kasa", "id", $id, $arr);
            if ($varsayilani_degis) {
                $depoyu_ekle = DB::insert("kasa", $_POST);
                if ($depoyu_ekle) {
                    echo 2;
                } else {
                    echo 1;
                }
            } else {
                echo 2;
            }
        } else {
            $depoyu_ekle = DB::insert("kasa", $_POST);
            if ($depoyu_ekle) {
                echo 2;
            } else {
                echo 1;
            }
        }
    }
}
if ($islem == "kasa_sil") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $kasa_kodu = $_POST["kasa_kodu"];
    $cari_sil = DB::update("kasa", "kasa_kodu", $kasa_kodu, $_POST);
    if ($cari_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "kasa_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $kasa_kodu = $_POST["kasa_kodu"];
    $varsayilan_varmi = DB::single_query("select * from kasa where status=1 and cari_key='$cari_key' $ek_sorgu NOT IN (varsayilan_kasa=0)");
    if ($_POST["varsayilan_kasa"] == "1" && $varsayilan_varmi > 0) {
        $id = $varsayilan_varmi["id"];
        $arr = [
            'varsayilan_kasa' => 0
        ];
        $varsayilani_degis = DB::update("kasa", "id", $id, $arr);
        if ($varsayilani_degis) {
            $cari_guncelle = DB::update("kasa", "kasa_kodu", $kasa_kodu, $_POST);
            if ($cari_guncelle) {
                echo 1;
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    } else {
        $cari_sil = DB::update("kasa", "kasa_kodu", $kasa_kodu, $_POST);
        $varsayilan_varmi = DB::single_query("select * from kasa where status=1 and cari_key='$cari_key' $ek_sorgu NOT IN (varsayilan_kasa=0)");
        if ($cari_sil) {
            echo 1;
        } else {
            echo 2;
        }
    }

}
if ($islem == "kasa_bilgilerini_getir") {
    $kasa_kodu = $_GET["kasa_kodu"];
    $kasa_bilgileri = DB::single_query("SELECT * FROM kasa WHERE status=1 AND kasa_kodu='$kasa_kodu' and cari_key='$cari_key' and cari_key='$cari_key' $ek_sorgu");
    if ($kasa_bilgileri > 0) {
        echo json_encode($kasa_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "kasalari_getir_sql") {
    $kasa_ek = "";
    if ($_SESSION["sube_key"] != 0) {
        $kasa_ek = " AND sube_key='$sube_key'";
    }
    $kasalari_getir = DB::all_data("SELECT id,kasa_adi,varsayilan_kasa,kasa_kodu FROM kasa WHERE status=1 AND cari_key='$cari_key'  $kasa_ek");
    if ($kasalari_getir > 0) {
        echo json_encode($kasalari_getir);
    } else {
        echo 2;
    }
}
if ($islem == "cari_kodu_bilgileri_getir") {
    $cari_kodu = $_GET["cari_kodu"];
    $sago = "";
    if ($_SESSION["sube_key"] != 0) {
        $sago = " AND sube_key='$sube_key'";
    }
    $verileri_cek = DB::single_query("SELECT id,cari_adi,cari_kodu FROM cari WHERE status=1 and cari_kodu='$cari_kodu' AND cari_key='$cari_key' $sago");

    if ($verileri_cek > 0) {
        echo json_encode($verileri_cek);
    } else {
        echo 2;
    }
}
if ($islem == "kasa_tahsilat_urun_ekle_sql") {
    $cari_id = 0;
    $uye_id = 0;
    $cari_kodu = $_POST["cari_kodu"];
    $caridemi = DB::single_query("select id from cari WHERE status=1 AND cari_key='$cari_key' AND cari_kodu='$cari_kodu'");
    if ($caridemi > 0) {
        $cari_id = $caridemi["id"];
    } else {
        $uyedemi = DB::single_query("select id from uye_tanim WHERE status=1 AND cari_key='$cari_key' AND tc_no='$cari_kodu'");
        if ($uyedemi > 0) {
            $uye_id = $uyedemi["id"];
            $cari_kodu = 0;
        }
    }
    if ($uye_id != 0) {
        $cari_id = 0;
    } else {
        $uye_id = 0;
    }

    if (isset($_POST["tahsilat_id"])) {
        $tahsilat_id = $_POST["tahsilat_id"];
        $tahsilat_bilgi = DB::single_query("SELECT tahsilat_toplam,kasa_id FROM kasa_tahsilat WHERE status=1 AND id='$tahsilat_id'");
        if ($tahsilat_bilgi > 0) {
            $toplam_tahsilat = $tahsilat_bilgi["tahsilat_toplam"];
            $yeni_tahsilat_toplam = floatval($toplam_tahsilat) + floatval($_POST["tutar"]);
            $arr = [
                'doviz_kuru' => $_POST["doviz_kuru"],
                'doviz_turu' => $_POST["doviz_tur"],
                'kasa_id' => $_POST["kasa_id"],
                'tahsilat_toplam' => $yeni_tahsilat_toplam,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $tahsilat_guncelle = DB::update("kasa_tahsilat", "id", $tahsilat_id, $arr);
            if ($tahsilat_guncelle) {
                unset($_POST["kasa_id"]);
                unset($_POST["doviz_tur"]);
                unset($_POST["doviz_kuru"]);
                $cari_bilgileri = DB::single_query("SELECT borc,alacak FROM cari WHERE status=1 AND id='$cari_id'");
                $artan_miktar = 0;
                if ($cari_bilgileri["borc"] < $_POST["tutar"]) {
                    $artan_miktar = floatval($_POST["tutar"]) - floatval($cari_bilgileri["borc"]);
                }

                $urun_arr = [
                    'cari_id' => $cari_id,
                    'uye_id' => $uye_id,
                    'aciklama' => $_POST["aciklama"],
                    'tutar' => $_POST["tutar"],
                    'tahsilat_id' => $tahsilat_id,
                    'cari_key' => $_SESSION["cari_key"],
                    'sube_key' => $_SESSION["sube_key"],
                    'artan_miktar' => $artan_miktar,
                    'insert_userid' => $_SESSION["user_id"],
                    'insert_datetime' => date("Y-m-d H:i:s")
                ];
                $tahsilat_urun_ekle = DB::insert("kasa_tahsilat_urunler", $urun_arr);
                if ($tahsilat_urun_ekle) {
                    echo 2;
                } else {
                    $eklenen_verileri_cek = DB::all_data("
SELECT
       ktu.aciklama, kt.doviz_turu,kt.doviz_kuru,ut.tc_no,ut.uye_adi,ktu.tutar,c.cari_kodu,c.cari_adi,ktu.id,ktu.tahsilat_id,ktu.cari_id
FROM 
     kasa_tahsilat_urunler as ktu 
LEFT JOIN cari as c on c.id=ktu.cari_id
LEFT JOIN uye_tanim as ut on ut.id=ktu.uye_id
INNER JOIN kasa_tahsilat as kt on kt.id=ktu.tahsilat_id
WHERE ktu.status=1 AND ktu.cari_key='$cari_key' AND ktu.tahsilat_id='$tahsilat_id'
     ");
                    if ($eklenen_verileri_cek > 0) {
                        echo json_encode($eklenen_verileri_cek);
                    } else {
                        echo 2;
                    }
                }
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    } else {
        $tahsilat_olustur_arr = [
            'kasa_id' => $_POST["kasa_id"],
            'doviz_kuru' => $_POST["doviz_kuru"],
            'doviz_turu' => $_POST["doviz_tur"],
            'tahsilat_toplam' => $_POST["tutar"],
            'cari_key' => $_SESSION["cari_key"],
            'sube_key' => $_SESSION["sube_key"],
            'insert_userid' => $_SESSION["user_id"],
            'insert_datetime' => date("Y-m-d H:i:s")
        ];
        $tahsilat_fisi_olustur = DB::insert("kasa_tahsilat", $tahsilat_olustur_arr);
        if ($tahsilat_fisi_olustur) {
            echo 2;
        } else {
            $son_tahsilat = DB::single_query("SELECT id FROM kasa_tahsilat where cari_key='$cari_key'  ORDER BY id DESC LIMIT 1");
            if ($son_tahsilat > 0) {
                $tahsilat_id = $son_tahsilat["id"];
                $_POST["tahsilat_id"] = $tahsilat_id;
                $tahsilat_bilgi = DB::single_query("SELECT tahsilat_toplam,kasa_id FROM kasa_tahsilat WHERE status=1 AND id='$tahsilat_id'");
                if ($tahsilat_bilgi > 0) {
                    $toplam_tahsilat = $tahsilat_bilgi["tahsilat_toplam"];
                    unset($_POST["kasa_id"]);
                    unset($_POST["doviz_tur"]);
                    unset($_POST["doviz_kuru"]);
                    $cari_bilgileri = DB::single_query("SELECT borc,alacak FROM cari WHERE status=1 AND id='$cari_id'");
                    $artan_miktar = 0;
                    if ($cari_bilgileri["borc"] < $_POST["tutar"]) {
                        $artan_miktar = floatval($_POST["tutar"]) - floatval($cari_bilgileri["borc"]);
                    }

                    $urun_arr = [
                        'cari_id' => $cari_id,
                        'uye_id' => $uye_id,
                        'aciklama' => $_POST["aciklama"],
                        'tutar' => $_POST["tutar"],
                        'tahsilat_id' => $tahsilat_id,
                        'cari_key' => $_SESSION["cari_key"],
                        'sube_key' => $_SESSION["sube_key"],
                        'artan_miktar' => $artan_miktar,
                        'insert_userid' => $_SESSION["user_id"],
                        'insert_datetime' => date("Y-m-d H:i:s")
                    ];
                    $tahsilat_urun_ekle = DB::insert("kasa_tahsilat_urunler", $urun_arr);
                    if ($tahsilat_urun_ekle) {
                        echo 2;
                    } else {
                        $eklenen_verileri_cek = DB::all_data("
SELECT
       ktu.aciklama, kt.doviz_turu,kt.doviz_kuru,ut.tc_no,ut.uye_adi,ktu.tutar,c.cari_kodu,c.cari_adi,ktu.id,ktu.tahsilat_id,ktu.cari_id
FROM 
     kasa_tahsilat_urunler as ktu 
LEFT JOIN cari as c on c.id=ktu.cari_id
LEFT JOIN uye_tanim as ut on ut.id=ktu.uye_id
INNER JOIN kasa_tahsilat as kt on kt.id=ktu.tahsilat_id
WHERE ktu.status=1 AND ktu.cari_key='$cari_key' AND ktu.tahsilat_id='$tahsilat_id'
     ");
                        if ($eklenen_verileri_cek > 0) {
                            echo json_encode($eklenen_verileri_cek);
                        } else {
                            echo 2;
                        }
                    }
                } else {
                    echo 2;
                }
            } else {
                echo 2;
            }
        }
    }
}
if ($islem == "tahsilat_kaydi_sil_sql") {
    $id = $_POST["id"];
    $kasa_tahsilat_urun_bilgi = DB::single_query("SELECT tutar,artan_miktar,cari_id,tahsilat_id FROM kasa_tahsilat_urunler WHERE status=1 AND id='$id'");
    if ($kasa_tahsilat_urun_bilgi > 0) {
        $tutari = $kasa_tahsilat_urun_bilgi["tutar"];
        $cari_id = $kasa_tahsilat_urun_bilgi["cari_id"];
        $borca_eklenecek = $kasa_tahsilat_urun_bilgi["tutar"];
        $alacaktan_silinecek = $kasa_tahsilat_urun_bilgi["artan_miktar"];


        $tahsilat_id = $kasa_tahsilat_urun_bilgi["tahsilat_id"];
        $tahsilat_arr = [
            'status' => 0,
            'delete_userid' => $_SESSION["user_id"],
            'delete_datetime' => date("Y-m-d H:i:s"),
            'delete_detail' => 'Kullanıcı Ürünü Kalemden Çıkartmıştır'
        ];
        $tahsilat_guncelle = DB::update("kasa_tahsilat_urunler", "id", $id, $tahsilat_arr);
        $kasa_tahsilat_bilgi = DB::single_query("SELECT * FROM kasa_tahsilat WHERE status=1 AND id='$tahsilat_id'");
        if ($kasa_tahsilat_bilgi > 0) {
            $genel_tutar = floatval($kasa_tahsilat_bilgi["tahsilat_toplam"]) - floatval($tutari);

            $arr = [
                'tahsilat_toplam' => $genel_tutar,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $kasa_guncelle = DB::update("kasa_tahsilat", "id", $tahsilat_id, $arr);
            if ($kasa_guncelle) {
                echo 1;
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    }
}
if ($islem == "kasa_tahsilati_kaydet") {
    $id = $_POST["id"];
    $kasa_tahsilat_guncelle = DB::update("kasa_tahsilat", "id", $id, $_POST);
    if ($kasa_tahsilat_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "tahsilat_iptal_et_sql") {
    $tahsilat_id = $_POST["id"];
    $tahsilat_urunleri = DB::all_data("SELECT * FROM kasa_tahsilat_urunler WHERE status=1 AND tahsilat_id='$tahsilat_id'");
    if (isset($_POST["delete_detail"])) {
        $tahsilat_arr = [
            'status' => 0,
            'delete_userid' => $_SESSION["user_id"],
            'delete_datetime' => date("Y-m-d H:i:s"),
            'delete_detail' => $_POST["delete_detail"]
        ];
    } else {
        $tahsilat_arr = [
            'status' => 0,
            'delete_userid' => $_SESSION["user_id"],
            'delete_datetime' => date("Y-m-d H:i:s"),
            'delete_detail' => 'Kullanıcı Tahsilattan Vazgeçmiştir'
        ];
    }

    $tahsilat_guncelle = DB::update("kasa_tahsilat", "id", $tahsilat_id, $tahsilat_arr);
    if ($tahsilat_urunleri > 0) {
        foreach ($tahsilat_urunleri as $urunler) {
            $cari_id = $urunler["cari_id"];
            $tutar = $urunler["tutar"];
            $artan_miktar = $urunler["artan_miktar"];
            $cari_borc_alacak = DB::single_query("SELECT * FROM cari WHERE status=1 AND id='$cari_id'");
            if ($cari_borc_alacak > 0) {
                $borc = $cari_borc_alacak["borc"];
                $alacak = $cari_borc_alacak["alacak"];
                $eklenecek_borc = floatval($tutar) - floatval($artan_miktar);
                $yeni_borc = floatval($borc) + $eklenecek_borc;
                $yeni_alacak = floatval($alacak) - floatval($artan_miktar);
                $cari_arr = [
                    'borc' => $yeni_borc,
                    'alacak' => $yeni_alacak,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $cari_guncelle = DB::update("cari", "id", $cari_id, $cari_arr);
            }
        }

        if ($cari_guncelle) {
            echo 1;
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "tahsilat_fisleri_getir_sql") {
    $sql = "
SELECT
       kt.*,k.kasa_adi,k.kasa_kodu 
FROM 
     kasa_tahsilat AS kt 
INNER JOIN kasa as k on k.id=kt.kasa_id
WHERE kt.status=1";
    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        if ($bas_tarih != "" && $bit_tarih != "") {
            $sql .= " AND islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
        }
    }
    $tahsilat_fisleri_cek = DB::all_data($sql);
    if ($tahsilat_fisleri_cek > 0) {
        echo json_encode($tahsilat_fisleri_cek);
    } else {
        echo 2;
    }
}
if ($islem == "tahsilat_urun_guncelle_sql") {
    $urun_id = $_POST["id"];
    $urun_bilgileri = DB::single_query("SELECT * FROM kasa_tahsilat_urunler WHERE status=1 AND id='$urun_id'");
    if ($urun_bilgileri > 0) {
        $onceki_artan = $urun_bilgileri["artan_miktar"];
        $onceki_tutar = $urun_bilgileri["tutar"];
        $cari_id = $urun_bilgileri["cari_id"];
        $cari_bilgileri = DB::single_query("SELECT * FROM cari WHERE status=1 AND id='$cari_id'");
        if ($cari_bilgileri > 0) {
            if ($_POST["tutar"] > $cari_bilgileri["borc"]) {
                $miktar_farki = floatval($_POST["tutar"]) - floatval($onceki_tutar);
                $cari_alacak = $cari_bilgileri["alacak"];
                $yeni_alacak2 = floatval($cari_alacak) - floatval($urun_bilgileri["artan_miktar"]);
                $yeni_alacak = floatval($cari_alacak) + $miktar_farki;
                $cari_arr = [];
                if ($yeni_alacak < 0) {
                    $yeni_alacak = $yeni_alacak - floatval($cari_alacak);
                    $_POST["artan_miktar"] = 0;
                    $yeni_alacak = -$yeni_alacak;
                    $cari_arr = [
                        'borc' => $yeni_alacak,
                        'alacak' => $yeni_alacak2,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];
                } else {
                    $_POST["artan_miktar"] = floatval($urun_bilgileri["artan_miktar"]) + $miktar_farki;
                    $cari_arr = [
                        'borc' => 0,
                        'alacak' => $yeni_alacak,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];
                }

                $cariyi_guncelle = DB::update("cari", "id", $cari_id, $cari_arr);
                if ($cariyi_guncelle) {
                    $tahsilat_id = $urun_bilgileri["tahsilat_id"];
                    $tahsilat_tutar = DB::single_query("SELECT * FROM kasa_tahsilat WHERE status=1 AND id='$tahsilat_id'");
                    if ($tahsilat_tutar > 0) {
                        $tahsilat_toplam_tutar = $tahsilat_tutar["tahsilat_toplam"];
                        $yeni_artan_miktar = floatval($tahsilat_toplam_tutar) + $miktar_farki;
                        $yeni_tahsilat_toplam = [
                            'tahsilat_toplam' => $yeni_artan_miktar,
                            'update_userid' => $_SESSION["user_id"],
                            'update_datetime' => date("Y-m-d H:i:s")
                        ];
                        $kasa_guncelle = DB::update("kasa_tahsilat", "id", $tahsilat_id, $yeni_tahsilat_toplam);
                        if ($kasa_guncelle) {
                            $kasa_urun_guncelle = DB::update("kasa_tahsilat_urunler", "id", $urun_id, $_POST);
                            unset($_POST["artan_miktar"]);
                            if ($kasa_urun_guncelle) {
                                $urun_bilgileri_getir = DB::all_data("
SELECT
       ktu.aciklama, kt.doviz_turu,kt.doviz_kuru,ktu.tutar,c.cari_kodu,c.cari_adi,ktu.id,ktu.tahsilat_id,ktu.cari_id
FROM 
     kasa_tahsilat_urunler as ktu 
INNER JOIN cari as c on c.id=ktu.cari_id
INNER JOIN kasa_tahsilat as kt on kt.id=ktu.tahsilat_id
WHERE ktu.status=1 AND ktu.cari_key='$cari_key' AND ktu.tahsilat_id='$tahsilat_id'");
                                if ($urun_bilgileri_getir > 0) {
                                    echo json_encode($urun_bilgileri_getir);
                                } else {
                                    echo 3;
                                }
                            } else {
                                echo 4;
                            }
                        } else {
                            echo 5;
                        }
                    } else {
                        echo 6;
                    }
                } else {
                    echo 7;
                }
            } else {
                $miktar_farki = floatval($_POST["tutar"]) - floatval($onceki_tutar);
                $yeni_alacak = floatval($cari_bilgileri["borc"]) - $miktar_farki;
                $cari_arr = [
                    'borc' => $yeni_alacak,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $cariyi_guncelle = DB::update("cari", "id", $cari_id, $cari_arr);
                if ($cariyi_guncelle) {
                    $tahsilat_id = $urun_bilgileri["tahsilat_id"];
                    $tahsilat_tutar = DB::single_query("SELECT * FROM kasa_tahsilat WHERE status=1 AND id='$tahsilat_id'");
                    if ($tahsilat_tutar > 0) {
                        $tahsilat_toplam_tutar = $tahsilat_tutar["tahsilat_toplam"];
                        $yeni_artan_miktar = floatval($tahsilat_toplam_tutar) + $miktar_farki;
                        $yeni_tahsilat_toplam = [
                            'tahsilat_toplam' => $yeni_artan_miktar,
                            'update_userid' => $_SESSION["user_id"],
                            'update_datetime' => date("Y-m-d H:i:s")
                        ];
                        $kasa_guncelle = DB::update("kasa_tahsilat", "id", $tahsilat_id, $yeni_tahsilat_toplam);
                        if ($kasa_guncelle) {
                            $kasa_urun_guncelle = DB::update("kasa_tahsilat_urunler", "id", $urun_id, $_POST);
                            if ($kasa_urun_guncelle) {
                                $urun_bilgileri_getir = DB::all_data("
SELECT
       ktu.aciklama, kt.doviz_turu,kt.doviz_kuru,ktu.tutar,c.cari_kodu,c.cari_adi,ktu.id,ktu.tahsilat_id,ktu.cari_id
FROM 
     kasa_tahsilat_urunler as ktu 
INNER JOIN cari as c on c.id=ktu.cari_id
INNER JOIN kasa_tahsilat as kt on kt.id=ktu.tahsilat_id
WHERE ktu.status=1 AND ktu.cari_key='$cari_key' AND ktu.tahsilat_id='$tahsilat_id'");
                                if ($urun_bilgileri_getir > 0) {
                                    echo json_encode($urun_bilgileri_getir);
                                } else {
                                    echo 8;
                                }
                            } else {
                                echo 9;
                            }
                        } else {
                            echo 10;
                        }
                    } else {
                        echo 11;
                    }
                } else {
                    echo 12;
                }
            }
        } else {
            echo 13;
        }
    } else {
        echo 14;
    }
}
if ($islem == "tahsilat_ust_bilgileri_getir_sql") {
    $id = $_GET["id"];
    $ust_bilgiler = DB::single_query("SELECT * FROM kasa_tahsilat WHERE status=1 AND id='$id'");
    if ($ust_bilgiler > 0) {
        echo json_encode($ust_bilgiler);
    } else {
        echo 2;
    }
}
if ($islem == "urunleri_getir_sql") {
    $id = $_GET["id"];
    $veriler = DB::all_data("
SELECT
       ktu.aciklama, kt.doviz_turu,ut.tc_no,ut.uye_adi,kt.doviz_kuru,ktu.tutar,c.cari_kodu,c.cari_adi,ktu.id,ktu.tahsilat_id,ktu.cari_id
FROM 
     kasa_tahsilat_urunler as ktu 
LEFT JOIN cari as c on c.id=ktu.cari_id
LEFT JOIN uye_tanim as ut on ut.id=ktu.uye_id
INNER JOIN kasa_tahsilat as kt on kt.id=ktu.tahsilat_id
WHERE ktu.status=1 AND ktu.cari_key='$cari_key' AND ktu.tahsilat_id='$id'");
    if ($veriler > 0) {
        echo json_encode($veriler);
    } else {
        echo 2;
    }
}
if ($islem == "kasa_odeme_urun_ekle_sql") {

    $cari_id = $_POST["cari_id"];
    if (isset($_POST["odeme_id"])) {
        $odeme_id = $_POST["odeme_id"];
        $odeme_bilgi = DB::single_query("SELECT odeme_toplam,kasa_id FROM kasa_odeme WHERE status=1 AND id='$odeme_id'");
        if ($odeme_bilgi > 0) {
            $toplam_odeme = $odeme_bilgi["odeme_toplam"];
            $yeni_odeme_toplam = floatval($toplam_odeme) + floatval($_POST["tutar"]);
            $arr = [
                'doviz_kuru' => $_POST["doviz_kuru"],
                'doviz_turu' => $_POST["doviz_tur"],
                'kasa_id' => $_POST["kasa_id"],
                'odeme_toplam' => $yeni_odeme_toplam,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $odeme_guncelle = DB::update("kasa_odeme", "id", $odeme_id, $arr);
            if ($odeme_guncelle) {
                unset($_POST["kasa_id"]);
                unset($_POST["doviz_tur"]);
                unset($_POST["doviz_kuru"]);
                $cari_bilgileri = DB::single_query("SELECT borc,alacak FROM cari WHERE status=1 AND id='$cari_id'");
                $artan_miktar = 0;
                if ($cari_bilgileri["alacak"] < $_POST["tutar"]) {
                    $artan_miktar = floatval($_POST["tutar"]) - floatval($cari_bilgileri["alacak"]);
                }
                $urun_arr = [
                    'cari_id' => $_POST["cari_id"],
                    'aciklama' => $_POST["aciklama"],
                    'tutar' => $_POST["tutar"],
                    'odeme_id' => $odeme_id,
                    'cari_key' => $_SESSION["cari_key"],
                    'sube_key' => $_SESSION["sube_key"],
                    'artan_miktar' => $artan_miktar,
                    'insert_userid' => $_SESSION["user_id"],
                    'insert_datetime' => date("Y-m-d H:i:s")
                ];
                $odeme_urun_ekle = DB::insert("kasa_odeme_urunler", $urun_arr);
                if ($odeme_urun_ekle) {
                    echo 2;
                } else {
                    $cari_bilgileri = DB::single_query("SELECT borc,alacak FROM cari WHERE status=1 AND id='$cari_id'");
                    if ($cari_bilgileri > 0) {
                        if ($_POST["tutar"] > $cari_bilgileri["alacak"]) {
                            $eklenecek_alacak = floatval($_POST["tutar"]) - floatval($cari_bilgileri["alacak"]);
                            $yeni_alacak = $eklenecek_alacak + $cari_bilgileri["borc"];
                            $cari_arr = [
                                'borc' => $yeni_alacak,
                                'alacak' => 0,
                                'update_userid' => $_SESSION["user_id"],
                                'update_datetime' => date("Y-m-d H:i:s")
                            ];
                            $cari_bilgileri_guncelle = DB::update("cari", "id", $cari_id, $cari_arr);
                            if ($cari_bilgileri_guncelle) {
                                $eklenen_verileri_cek = DB::all_data("
SELECT
       ktu.aciklama, kt.doviz_turu,kt.doviz_kuru,ktu.tutar,c.cari_kodu,c.cari_adi,ktu.id,ktu.odeme_id,ktu.cari_id
FROM 
     kasa_odeme_urunler as ktu 
INNER JOIN cari as c on c.id=ktu.cari_id
INNER JOIN kasa_odeme as kt on kt.id=ktu.odeme_id
WHERE ktu.status=1 AND ktu.cari_key='$cari_key' AND ktu.odeme_id='$odeme_id'
     ");
                                if ($eklenen_verileri_cek > 0) {
                                    echo json_encode($eklenen_verileri_cek);
                                } else {
                                    echo 2;
                                }
                            } else {
                                echo 2;
                            }
                        } else {
                            $yeni_borc = floatval($cari_bilgileri["alacak"]) - floatval($_POST["tutar"]);
                            $yeni_arr = [
                                'alacak' => $yeni_borc,
                                'update_userid' => $_SESSION["user_id"],
                                'update_datetime' => date("Y-m-d H:i:s")
                            ];
                            $cari_bilgi_guncele = DB::update("cari", "id", $cari_id, $yeni_arr);
                            if ($cari_bilgi_guncele) {
                                $eklenen_verileri_cek = DB::all_data("
SELECT
       ktu.aciklama, kt.doviz_turu,kt.doviz_kuru,ktu.tutar,c.cari_kodu,c.cari_adi,ktu.id,ktu.odeme_id,ktu.cari_id
FROM 
     kasa_odeme_urunler as ktu 
INNER JOIN cari as c on c.id=ktu.cari_id
INNER JOIN kasa_odeme as kt on kt.id=ktu.odeme_id
WHERE ktu.status=1 AND ktu.cari_key='$cari_key' AND ktu.odeme_id='$odeme_id'
     ");
                                if ($eklenen_verileri_cek > 0) {
                                    echo json_encode($eklenen_verileri_cek);
                                } else {
                                    echo 2;
                                }
                            } else {
                                echo 2;
                            }
                        }
                    } else {
                        echo 2;
                    }
                }
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    } else {
        $odeme_olustur_arr = [
            'kasa_id' => $_POST["kasa_id"],
            'doviz_kuru' => $_POST["doviz_kuru"],
            'doviz_turu' => $_POST["doviz_tur"],
            'odeme_toplam' => $_POST["tutar"],
            'cari_key' => $_SESSION["cari_key"],
            'sube_key' => $_SESSION["sube_key"],
            'insert_userid' => $_SESSION["user_id"],
            'insert_datetime' => date("Y-m-d H:i:s")
        ];
        $odeme_fisi_olustur = DB::insert("kasa_odeme", $odeme_olustur_arr);
        if ($odeme_fisi_olustur) {
            echo 2;
        } else {
            $son_odeme = DB::single_query("SELECT id FROM kasa_odeme where cari_key='$cari_key'  ORDER BY id DESC LIMIT 1");
            if ($son_odeme > 0) {
                $odeme_id = $son_odeme["id"];
                $_POST["odeme_id"] = $odeme_id;
                $odeme_bilgi = DB::single_query("SELECT odeme_toplam,kasa_id FROM kasa_odeme WHERE status=1 AND id='$odeme_id'");
                if ($odeme_bilgi > 0) {
                    $toplam_odeme = $odeme_bilgi["odeme_toplam"];
                    unset($_POST["kasa_id"]);
                    unset($_POST["doviz_tur"]);
                    unset($_POST["doviz_kuru"]);
                    $cari_bilgileri = DB::single_query("SELECT borc,alacak FROM cari WHERE status=1 AND id='$cari_id'");
                    $artan_miktar = 0;
                    if ($cari_bilgileri["alacak"] < $_POST["tutar"]) {
                        $artan_miktar = floatval($_POST["tutar"]) - floatval($cari_bilgileri["alacak"]);
                    }
                    $urun_arr = [
                        'cari_id' => $_POST["cari_id"],
                        'aciklama' => $_POST["aciklama"],
                        'tutar' => $_POST["tutar"],
                        'odeme_id' => $odeme_id,
                        'cari_key' => $_SESSION["cari_key"],
                        'sube_key' => $_SESSION["sube_key"],
                        'artan_miktar' => $artan_miktar,
                        'insert_userid' => $_SESSION["user_id"],
                        'insert_datetime' => date("Y-m-d H:i:s")
                    ];
                    $odeme_urun_ekle = DB::insert("kasa_odeme_urunler", $urun_arr);
                    if ($odeme_urun_ekle) {
                        echo 2;
                    } else {
                        $cari_bilgileri = DB::single_query("SELECT borc,alacak FROM cari WHERE status=1 AND id='$cari_id'");
                        if ($cari_bilgileri > 0) {
                            if ($_POST["tutar"] > $cari_bilgileri["alacak"]) {
                                $eklenecek_alacak = floatval($_POST["tutar"]) - floatval($cari_bilgileri["alacak"]);
                                $yeni_alacak = $eklenecek_alacak + $cari_bilgileri["borc"];
                                $cari_arr = [
                                    'borc' => $yeni_alacak,
                                    'alacak' => 0,
                                    'update_userid' => $_SESSION["user_id"],
                                    'update_datetime' => date("Y-m-d H:i:s")
                                ];
                                $cari_bilgileri_guncelle = DB::update("cari", "id", $cari_id, $cari_arr);
                                if ($cari_bilgileri_guncelle) {
                                    $eklenen_verileri_cek = DB::all_data("
SELECT
       ktu.aciklama, kt.doviz_turu,kt.doviz_kuru,ktu.tutar,c.cari_kodu,c.cari_adi,ktu.id,ktu.odeme_id,ktu.cari_id
FROM 
     kasa_odeme_urunler as ktu 
INNER JOIN cari as c on c.id=ktu.cari_id
INNER JOIN kasa_odeme as kt on kt.id=ktu.odeme_id
WHERE ktu.status=1 AND ktu.cari_key='$cari_key' AND ktu.odeme_id='$odeme_id'
     ");
                                    if ($eklenen_verileri_cek > 0) {
                                        echo json_encode($eklenen_verileri_cek);
                                    } else {
                                        echo 2;
                                    }
                                } else {
                                    echo 2;
                                }
                            } else {
                                $yeni_borc = floatval($cari_bilgileri["alacak"]) - floatval($_POST["tutar"]);
                                $yeni_arr = [
                                    'alacak' => $yeni_borc,
                                    'update_userid' => $_SESSION["user_id"],
                                    'update_datetime' => date("Y-m-d H:i:s")
                                ];
                                $cari_bilgi_guncele = DB::update("cari", "id", $cari_id, $yeni_arr);
                                if ($cari_bilgi_guncele) {
                                    $eklenen_verileri_cek = DB::all_data("
SELECT
       ktu.aciklama, kt.doviz_turu,kt.doviz_kuru,ktu.tutar,c.cari_kodu,c.cari_adi,ktu.id,ktu.odeme_id,ktu.cari_id
FROM 
     kasa_odeme_urunler as ktu 
INNER JOIN cari as c on c.id=ktu.cari_id
INNER JOIN kasa_odeme as kt on kt.id=ktu.odeme_id
WHERE ktu.status=1 AND ktu.cari_key='$cari_key' AND ktu.odeme_id='$odeme_id'
     ");
                                    if ($eklenen_verileri_cek > 0) {
                                        echo json_encode($eklenen_verileri_cek);
                                    } else {
                                        echo 2;
                                    }
                                } else {
                                    echo 2;
                                }
                            }
                        } else {
                            echo 2;
                        }
                    }
                } else {
                    echo 2;
                }
            } else {
                echo 2;
            }
        }
    }
}
if ($islem == "odeme_kaydi_sil_sql") {

    $id = $_POST["id"];
    $kasa_odeme_urun_bilgi = DB::single_query("SELECT tutar,artan_miktar,cari_id,odeme_id FROM kasa_odeme_urunler WHERE status=1 AND id='$id'");
    if ($kasa_odeme_urun_bilgi > 0) {
        $tutari = $kasa_odeme_urun_bilgi["tutar"];
        $cari_id = $kasa_odeme_urun_bilgi["cari_id"];
        $borca_eklenecek = $kasa_odeme_urun_bilgi["tutar"];
        $alacaktan_silinecek = $kasa_odeme_urun_bilgi["artan_miktar"];
        $cari_borc_alacak_info = DB::single_query("SELECT borc,alacak FROM cari WHERE status=1 AND id='$cari_id'");
        if ($cari_borc_alacak_info > 0) {
            $cikacak_tutar = floatval($kasa_odeme_urun_bilgi["tutar"]) - floatval($kasa_odeme_urun_bilgi["artan_miktar"]);
            $yeni_borc = floatval($cari_borc_alacak_info["alacak"]) + $cikacak_tutar;
            $yeni_alacak = floatval($cari_borc_alacak_info["borc"]) - floatval($alacaktan_silinecek);
            $cari_arr = [
                'alacak' => $yeni_borc,
                'borc' => $yeni_alacak,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];

            $odeme_arr = [
                'status' => 0,
                'delete_userid' => $_SESSION["user_id"],
                'delete_datetime' => date("Y-m-d H:i:s"),
                'delete_detail' => 'Kullanıcı Ürünü Kalemden Çıkartmıştır'
            ];
            $odeme_guncelle = DB::update("kasa_odeme_urunler", "id", $id, $odeme_arr);
            if ($odeme_guncelle) {
                $cari_guncelle = DB::update("cari", "id", $cari_id, $cari_arr);
                if ($cari_guncelle > 0) {
                    $odeme_id = $kasa_odeme_urun_bilgi["odeme_id"];
                    $kasa_odeme_bilgi = DB::single_query("SELECT * FROM kasa_odeme WHERE status=1 AND id='$odeme_id'");
                    if ($kasa_odeme_bilgi > 0) {
                        $genel_tutar = floatval($kasa_odeme_bilgi["odeme_toplam"]) - floatval($tutari);

                        $arr = [
                            'odeme_toplam' => $genel_tutar,
                            'update_userid' => $_SESSION["user_id"],
                            'update_datetime' => date("Y-m-d H:i:s")
                        ];
                        $kasa_guncelle = DB::update("kasa_odeme", "id", $odeme_id, $arr);
                        if ($kasa_guncelle) {
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
    }
}
if ($islem == "odeme_iptal_et_sql") {

    $odeme_id = $_POST["id"];
    $odeme_urunleri = DB::all_data("SELECT * FROM kasa_odeme_urunler WHERE status=1 AND odeme_id='$odeme_id'");
    if (isset($_POST["delete_detail"])) {
        $odeme_arr = [
            'status' => 0,
            'delete_userid' => $_SESSION["user_id"],
            'delete_datetime' => date("Y-m-d H:i:s"),
            'delete_detail' => $_POST["delete_detail"]
        ];
    } else {
        $odeme_arr = [
            'status' => 0,
            'delete_userid' => $_SESSION["user_id"],
            'delete_datetime' => date("Y-m-d H:i:s"),
            'delete_detail' => 'Kullanıcı odemetan Vazgeçmiştir'
        ];
    }

    $odeme_guncelle = DB::update("kasa_odeme", "id", $odeme_id, $odeme_arr);
    if ($odeme_urunleri > 0) {
        foreach ($odeme_urunleri as $urunler) {
            $cari_id = $urunler["cari_id"];
            $tutar = $urunler["tutar"];
            $artan_miktar = $urunler["artan_miktar"];
            $cari_borc_alacak = DB::single_query("SELECT * FROM cari WHERE status=1 AND id='$cari_id'");
            if ($cari_borc_alacak > 0) {
                $borc = $cari_borc_alacak["borc"];
                $alacak = $cari_borc_alacak["alacak"];
                $eklenecek_borc = floatval($tutar) - floatval($artan_miktar);
                $yeni_borc = floatval($alacak) + $eklenecek_borc;
                $yeni_alacak = floatval($borc) - floatval($artan_miktar);
                $cari_arr = [
                    'alacak' => $yeni_borc,
                    'borc' => $yeni_alacak,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $cari_guncelle = DB::update("cari", "id", $cari_id, $cari_arr);
            }
        }

        if ($cari_guncelle) {
            echo 1;
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "kasa_odemeyi_kaydet") {

    $id = $_POST["id"];
    $kasa_odeme_toplami = DB::single_query("SELECT odeme_toplam,kasa_id FROM kasa_odeme WHERE status=1 AND id='$id'");
    if ($kasa_odeme_toplami > 0) {
        $odeme_toplam = $kasa_odeme_toplami["odeme_toplam"];
        $kasa_id = $kasa_odeme_toplami["kasa_id"];
        $kasa_bilgileri = DB::single_query("SELECT giren_tutar,cikan_tutar FROM kasa WHERE status=1 AND id='$kasa_id'");
        if ($kasa_bilgileri > 0) {
            if (isset($_POST["ilk_tutar"])) {
                if ($_POST["ilk_tutar"] == $odeme_toplam) {
                    unset($_POST["ilk_tutar"]);
                    $kasa_odeme_guncelle = DB::update("kasa_odeme", "id", $id, $_POST);
                    if ($kasa_odeme_guncelle) {
                        echo 1;
                    } else {
                        echo 2;
                    }
                } else if ($_POST["ilk_tutar"] < $odeme_toplam) {
                    $fark = floatval($odeme_toplam) - floatval($_POST["ilk_tutar"]);
                    $yeni_giren = floatval($kasa_bilgileri["giren_tutar"]) + $fark;
                    $arr3 = [
                        'giren_tutar' => $yeni_giren,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];
                    $kasa_guncel = DB::update("kasa", "id", $kasa_id, $arr3);
                    if ($kasa_guncel) {
                        unset($_POST["ilk_tutar"]);
                        $kasa_odeme_guncelle = DB::update("kasa_odeme", "id", $id, $_POST);
                        if ($kasa_odeme_guncelle) {
                            echo 1;
                        } else {
                            echo 2;
                        }
                    } else {
                        echo 2;
                    }
                } else if ($_POST["ilk_tutar"] > $odeme_toplam) {
                    $fark = floatval($_POST["ilk_tutar"]) - floatval($odeme_toplam);
                    $yeni_cikan = floatval($kasa_bilgileri["cikan_tutar"]) + $fark;
                    $arr3 = [
                        'cikan_tutar' => $yeni_cikan,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];
                    $kasa_guncel = DB::update("kasa", "id", $kasa_id, $arr3);
                    if ($kasa_guncel) {
                        unset($_POST["ilk_tutar"]);
                        $kasa_odeme_guncelle = DB::update("kasa_odeme", "id", $id, $_POST);
                        if ($kasa_odeme_guncelle) {
                            echo 1;
                        } else {
                            echo 2;
                        }
                    } else {
                        echo 2;
                    }
                }
            } else {
                $kasa_giren = $kasa_bilgileri["cikan_tutar"];
                $yeni_tutar = floatval($odeme_toplam) + floatval($kasa_giren);
                $arr = [
                    'cikan_tutar' => $yeni_tutar,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $kasa_guncelle = DB::update("kasa", "id", $kasa_id, $arr);
                if ($kasa_guncelle) {
                    $kasa_odeme_guncelle = DB::update("kasa_odeme", "id", $id, $_POST);
                    if ($kasa_odeme_guncelle) {
                        echo 1;
                    } else {
                        echo 2;
                    }
                } else {
                    echo 2;
                }
            }

        } else {
            echo 3;
        }
    } else {
        echo 2;
    }
}
if ($islem == "odeme_fisleri_getir_sql") {
    $sql = "
SELECT
       kt.*,k.kasa_adi,k.kasa_kodu 
FROM 
     kasa_odeme AS kt 
INNER JOIN kasa as k on k.id=kt.kasa_id
WHERE kt.status=1";
    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        if ($bas_tarih != "" && $bit_tarih != "") {
            $sql .= " AND islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
        }
    }
    $tahsilat_fisleri_cek = DB::all_data($sql);
    if ($tahsilat_fisleri_cek > 0) {
        echo json_encode($tahsilat_fisleri_cek);
    } else {
        echo 2;
    }
}
if ($islem == "odeme_iptal_et_main_sql") {
    $odeme_id = $_POST["id"];
    $odeme_urunleri = DB::all_data("SELECT * FROM kasa_odeme_urunler WHERE status=1 AND odeme_id='$odeme_id'");
    if (isset($_POST["delete_detail"])) {
        $odeme_arr = [
            'status' => 0,
            'delete_userid' => $_SESSION["user_id"],
            'delete_datetime' => date("Y-m-d H:i:s"),
            'delete_detail' => $_POST["delete_detail"]
        ];
    } else {
        $odeme_arr = [
            'status' => 0,
            'delete_userid' => $_SESSION["user_id"],
            'delete_datetime' => date("Y-m-d H:i:s"),
            'delete_detail' => 'Kullanıcı odemetan Vazgeçmiştir'
        ];
    }
    $odeme_bilgi = DB::single_query("SELECT * FROM kasa_odeme WHERE status=1 AND id='$odeme_id'");
    if ($odeme_bilgi > 0) {
        $kasa_id = $odeme_bilgi["kasa_id"];
        $odeme_toplam = $odeme_bilgi["odeme_toplam"];
        $odeme_guncelle = DB::update("kasa_odeme", "id", $odeme_id, $odeme_arr);
        if ($odeme_urunleri > 0) {
            foreach ($odeme_urunleri as $urunler) {
                $cari_id = $urunler["cari_id"];
                $tutar = $urunler["tutar"];
                $artan_miktar = $urunler["artan_miktar"];
                $cari_borc_alacak = DB::single_query("SELECT * FROM cari WHERE status=1 AND id='$cari_id'");
                if ($cari_borc_alacak > 0) {
                    $borc = $cari_borc_alacak["borc"];
                    $alacak = $cari_borc_alacak["alacak"];
                    $eklenecek_borc = floatval($tutar) - floatval($artan_miktar);
                    $yeni_borc = floatval($alacak) + $eklenecek_borc;
                    $yeni_alacak = floatval($borc) - floatval($artan_miktar);
                    $cari_arr = [
                        'alacak' => $yeni_borc,
                        'borc' => $yeni_alacak,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];
                    $cari_guncelle = DB::update("cari", "id", $cari_id, $cari_arr);
                }
            }
            if ($cari_guncelle) {
                $kasa_bilgi = DB::single_query("SELECT * FROM kasa WHERE status=1 AND id='$kasa_id'");
                if ($kasa_bilgi > 0) {
                    $kasa_cikan_tutar = $kasa_bilgi["cikan_tutar"];
                    $yeni_tutar = floatval($kasa_cikan_tutar) - floatval($odeme_toplam);
                    $yeni_cikan = [
                        'cikan_tutar' => $yeni_tutar,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];
                    $kasa_guncelle = DB::update("kasa", "id", $kasa_id, $yeni_cikan);
                    if ($kasa_guncelle) {
                        echo 1;
                    } else {
                        echo 2;
                    }
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
if ($islem == "tahsilat_iptal_et_main_sql") {
    $tahsilat_id = $_POST["id"];
    $tahsilat_urunleri = DB::all_data("SELECT * FROM kasa_tahsilat_urunler WHERE status=1 AND tahsilat_id='$tahsilat_id'");
    if (isset($_POST["delete_detail"])) {
        $tahsilat_arr = [
            'status' => 0,
            'delete_userid' => $_SESSION["user_id"],
            'delete_datetime' => date("Y-m-d H:i:s"),
            'delete_detail' => $_POST["delete_detail"]
        ];
    } else {
        $tahsilat_arr = [
            'status' => 0,
            'delete_userid' => $_SESSION["user_id"],
            'delete_datetime' => date("Y-m-d H:i:s"),
            'delete_detail' => 'Kullanıcı Tahsilattan Vazgeçmiştir'
        ];
    }
    $odeme_bilgi = DB::single_query("SELECT * FROM kasa_tahsilat WHERE status=1 AND id='$tahsilat_id'");
    if ($odeme_bilgi > 0) {
        $kasa_id = $odeme_bilgi["kasa_id"];
        $odeme_toplam = $odeme_bilgi["tahsilat_toplam"];
        $tahsilat_guncelle = DB::update("kasa_tahsilat", "id", $tahsilat_id, $tahsilat_arr);
        if ($tahsilat_urunleri > 0) {
            $kasa_bilgi = DB::single_query("SELECT * FROM kasa WHERE status=1 AND id='$kasa_id'");
            if ($kasa_bilgi > 0) {
                $kasa_cikan_tutar = $kasa_bilgi["giren_tutar"];
                $yeni_tutar = floatval($kasa_cikan_tutar) - floatval($odeme_toplam);
                $yeni_cikan = [
                    'giren_tutar' => $yeni_tutar,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $kasa_guncelle = DB::update("kasa", "id", $kasa_id, $yeni_cikan);
                if ($kasa_guncelle) {
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
if ($islem == "odeme_ust_bilgileri_getir_sql") {
    $id = $_GET["id"];
    $ust_bilgiler = DB::single_query("SELECT * FROM kasa_odeme WHERE status=1 AND id='$id'");
    if ($ust_bilgiler > 0) {
        echo json_encode($ust_bilgiler);
    } else {
        echo 2;
    }
}
if ($islem == "odeme_urunleri_getir_sql") {
    $id = $_GET["id"];
    $veriler = DB::all_data("
SELECT
       ktu.aciklama, kt.doviz_turu,kt.doviz_kuru,ktu.tutar,c.cari_kodu,c.cari_adi,ktu.id,ktu.odeme_id,ktu.cari_id
FROM 
     kasa_odeme_urunler as ktu 
INNER JOIN cari as c on c.id=ktu.cari_id
INNER JOIN kasa_odeme as kt on kt.id=ktu.odeme_id
WHERE ktu.status=1 AND ktu.cari_key='$cari_key' AND ktu.odeme_id='$id'");
    if ($veriler > 0) {
        echo json_encode($veriler);
    } else {
        echo 2;
    }
}
if ($islem == "gonderen_kasa_getir") {
    $kasa_ek = "";
    if ($_SESSION["sube_key"] != 0) {
        $kasa_ek = " AND sube_key='$sube_key'";
    }
    $kasalari_getir = DB::all_data("SELECT * FROM kasa WHERE status=1 and cari_key='$cari_key' $kasa_ek");
    if ($kasalari_getir > 0) {
        echo json_encode($kasalari_getir);
    } else {
        echo 2;
    }
}
if ($islem == "alici_kasa_getir_sql") {
    $id = $_GET["id"];
    $alici_ek = "";
    if ($_SESSION["sube_key"] != 0) {
        $alici_ek = " AND sube_key='$sube_key'";
    }
    $alici_kasalar = DB::all_data("SELECT * FROM kasa WHERE status=1 AND  id!='$id' AND cari_key='$cari_key' $alici_ek");
    if ($alici_kasalar > 0) {
        echo json_encode($alici_kasalar);
    } else {
        echo 2;
    }
}
if ($islem == "yeni_kasa_virman_ekle") {

    $gonderen_id = $_POST["gonderen_kasaid"];
    $alan_kasaid = $_POST["alan_kasaid"];

    $gonderen_kasa_bilgi = DB::single_query("SELECT * FROM kasa WHERE status=1 AND id='$gonderen_id'");
    if ($gonderen_kasa_bilgi > 0) {
        $alan_kasaid = DB::single_query("SELECT * FROM kasa WHERE status=1 AND id='$alan_kasaid'");
        if ($alan_kasaid > 0) {
            $alan_kasaya_ekle = floatval($alan_kasaid["giren_tutar"]) + floatval($_POST["gonderilen_miktar"]);
            $gonderen_kasadan_cikart = floatval($gonderen_kasa_bilgi["cikan_tutar"]) + floatval($_POST["gonderilen_miktar"]);
            $gonderen_arr = [
                'cikan_tutar' => $gonderen_kasadan_cikart,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $gonderen_miktar_guncelle = DB::update("kasa", "id", $gonderen_kasa_bilgi["id"], $gonderen_arr);
            if ($gonderen_miktar_guncelle) {
                $giren_arr = [
                    'giren_tutar' => $alan_kasaya_ekle,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $alan_kasa_guncelle = DB::update("kasa", "id", $alan_kasaid["id"], $giren_arr);
                if ($alan_kasa_guncelle > 0) {
                    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
                    $_POST["insert_userid"] = $_SESSION["user_id"];
                    $kaydi_ekle = DB::insert("kasa_virman", $_POST);
                    if ($kaydi_ekle) {
                        echo 2;
                    } else {
                        $son_eklenen = DB::single_query("SELECT id FROM kasa_virman where cari_key='$cari_key'  ORDER BY id DESC LIMIT 1");
                        $son_id = $son_eklenen["id"];
                        $veriyi_getir = DB::single_query("
SELECT
       kv.*,
       gk.kasa_adi as gonderen_adi,
       gk.kasa_kodu as gonderen_kodu,
       ak.kasa_adi,
       ak.kasa_kodu
FROM 
     kasa_virman as kv
INNER JOIN kasa AS gk on gk.id=kv.gonderen_kasaid
INNER JOIN kasa AS ak on ak.id=kv.alan_kasaid
WHERE 
      kv.status=1 
  AND 
      kv.id='$son_id'");
                        if ($veriyi_getir > 0) {
                            echo json_encode($veriyi_getir);
                        } else {
                            echo 2;
                        }
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
    } else {
        echo 2;
    }
}
if ($islem == "virman_cikart") {
    $id = $_POST["id"];
    $virman_bilgiler = DB::single_query("SELECT * FROM kasa_virman WHERE status=1 AND id='$id'");
    if ($virman_bilgiler > 0) {
        $gonderen_id = $virman_bilgiler["gonderen_kasaid"];
        $alan_kasaid = $virman_bilgiler["alan_kasaid"];
        $miktar = $virman_bilgiler["gonderilen_miktar"];
        $gonderen_kasa_bilgi = DB::single_query("SELECT * FROM kasa WHERE status=1 AND id='$gonderen_id'");
        if ($gonderen_kasa_bilgi > 0) {
            $yeni_tutar = floatval($gonderen_kasa_bilgi["giren_tutar"]) + floatval($miktar);
            $yeni_arr = [
                'giren_tutar' => $yeni_tutar,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $gonderen_guncelle = DB::update("kasa", "id", $gonderen_kasa_bilgi["id"], $yeni_arr);
            if ($gonderen_guncelle) {
                $alan_kasa_bilgi = DB::single_query("SELECT * FROM kasa WHERE status=1 AND id='$alan_kasaid'");
                if ($alan_kasa_bilgi > 0) {
                    $yeni_miktar = floatval($alan_kasa_bilgi["cikan_tutar"]) + floatval($miktar);
                    $alan_arr = [
                        'cikan_tutar' => $yeni_miktar,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];
                    $alan_kasa_guncelle = DB::update("kasa", "id", $alan_kasa_bilgi["id"], $alan_arr);
                    if ($alan_arr) {
                        if (isset($_POST["delete_detail"])) {
                            $arr = [
                                'status' => 0,
                                'delete_userid' => $_SESSION["user_id"],
                                'delete_datetime' => date("Y-m-d H:i:s"),
                                'delete_detail' => $_POST["delete_detail"]
                            ];
                        } else {
                            $arr = [
                                'status' => 0,
                                'delete_userid' => $_SESSION["user_id"],
                                'delete_datetime' => date("Y-m-d H:i:s"),
                                'delete_detail' => "Kullanıcı Listeden Silmiştir"
                            ];
                        }
                        $virman_guncelle = DB::update("kasa_virman", "id", $id, $arr);
                        if ($virman_guncelle) {
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
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "virman_vazgec_sql") {
    foreach ($_POST["id"] as $item) {
        $id = $item;
        $virman_bilgiler = DB::single_query("SELECT * FROM kasa_virman WHERE status=1 AND id='$id'");
        if ($virman_bilgiler > 0) {
            $gonderen_id = $virman_bilgiler["gonderen_kasaid"];
            $alan_kasaid = $virman_bilgiler["alan_kasaid"];
            $miktar = $virman_bilgiler["gonderilen_miktar"];
            $gonderen_kasa_bilgi = DB::single_query("SELECT * FROM kasa WHERE status=1 AND id='$gonderen_id'");
            if ($gonderen_kasa_bilgi > 0) {
                $yeni_tutar = floatval($gonderen_kasa_bilgi["giren_tutar"]) + floatval($miktar);
                $yeni_arr = [
                    'giren_tutar' => $yeni_tutar,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $gonderen_guncelle = DB::update("kasa", "id", $gonderen_kasa_bilgi["id"], $yeni_arr);
                if ($gonderen_guncelle) {
                    $alan_kasa_bilgi = DB::single_query("SELECT * FROM kasa WHERE status=1 AND id='$alan_kasaid'");
                    if ($alan_kasa_bilgi > 0) {
                        $yeni_miktar = floatval($alan_kasa_bilgi["cikan_tutar"]) + floatval($miktar);
                        $alan_arr = [
                            'cikan_tutar' => $yeni_miktar,
                            'update_userid' => $_SESSION["user_id"],
                            'update_datetime' => date("Y-m-d H:i:s")
                        ];
                        $alan_kasa_guncelle = DB::update("kasa", "id", $alan_kasa_bilgi["id"], $alan_arr);
                        if ($alan_arr) {
                            $arr = [
                                'status' => 0,
                                'delete_userid' => $_SESSION["user_id"],
                                'delete_datetime' => date("Y-m-d H:i:s"),
                                'delete_detail' => "Kullanıcı Listeden Silmiştir"
                            ];
                            $virman_guncelle = DB::update("kasa_virman", "id", $id, $arr);

                        }
                    }
                }
            }
        }
    }
    if ($virman_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "virman_bilgileri_getir_sql") {
    $id = $_GET["id"];
    $veriyi_getir = DB::single_query("SELECT * FROM kasa_virman WHERE status=1 AND id='$id'");
    if ($veriyi_getir > 0) {
        echo json_encode($veriyi_getir);
    } else {
        echo 2;
    }
}
if ($islem == "virmanlari_getir_sql") {
    $ek = "";
    if ($_SESSION["user_id"]) {
        $ek = " AND kv.sube_key='$sube_key'";
    }
    $sql = "
SELECT
       kv.*,
       ak.kasa_adi as alan_kasa_adi,
       gk.kasa_adi
       
FROM 
     kasa_virman as kv
INNER JOIN kasa as ak on ak.id=kv.alan_kasaid
INNER JOIN kasa as gk on gk.id=kv.gonderen_kasaid
WHERE kv.status=1 AND kv.cari_key='$cari_key' $ek";
    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        if ($bas_tarih != "" && $bit_tarih != "") {
            $sql .= " AND kv.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
        }
    }
    $virmanlar = DB::all_data($sql);
    if ($virmanlar > 0) {
        echo json_encode($virmanlar);
    } else {
        echo 2;
    }
}
if ($islem == "bankalari_getir_sql") {
    $ek_banka = "";
    if ($_SESSION["sube_key"] != 0) {
        $ek_banka = " AND sube_key='$sube_key'";
    }
    $bankalari_getir = DB::all_data("SELECT id,banka_adi FROM banka WHERE status=1 AND cari_key='$cari_key'  $ek_banka");
    if ($bankalari_getir > 0) {
        echo json_encode($bankalari_getir);
    } else {
        echo 2;
    }
}
if ($islem == "bankaya_para_gonder_sql") {
    $banka_id = $_POST["banka_id"];
    $kasa_id = $_POST["kasa_id"];
    $banka_bilgileri = DB::single_query("SELECT yatan FROM banka WHERE status=1 AND id='$banka_id'");
    if ($banka_bilgileri > 0) {
        $kasa_bilgileri = DB::single_query("SELECT cikan_tutar FROM kasa WHERE status=1 AND id='$kasa_id'");
        if ($kasa_bilgileri > 0) {
            $banka_yatan = $banka_bilgileri["yatan"];
            $kasa_cikan = $kasa_bilgileri["cikan_tutar"];
            $bankaya_eklenecek = floatval($banka_yatan) + floatval($_POST["gonderilen_tutar"]);
            $kasadan_cikan = floatval($kasa_cikan) + floatval($_POST["gonderilen_tutar"]);

            $banka_arr = [
                'yatan' => $bankaya_eklenecek,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];

            $kasa_arr = [
                'cikan_tutar' => $kasadan_cikan,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];

            $banka_guncelle = DB::update("banka", "id", $banka_id, $banka_arr);
            if ($banka_guncelle) {
                $kasa_guncelle = DB::update("kasa", "id", $kasa_id, $kasa_arr);
                if ($kasa_guncelle) {
                    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
                    $_POST["insert_userid"] = $_SESSION["user_id"];
                    $kasadan_bankaya_ekle = DB::insert("kasadan_bankaya", $_POST);
                    if ($kasadan_bankaya_ekle) {
                        echo 2;
                    } else {
                        $son_id = DB::single_query("SELECT id FROM kasadan_bankaya where cari_key='$cari_key'  ORDER BY id DESC LIMIT 1");
                        if ($son_id > 0) {
                            $id = $son_id["id"];
                            $kasadan_bankaya_eklenen_veri = DB::single_query("
SELECT
       kb.*,k.kasa_adi,b.banka_adi
FROM 
     kasadan_bankaya as kb
INNER JOIN kasa as k on k.id=kb.kasa_id
INNER JOIN banka as b on b.id=kb.banka_id
WHERE 
      kb.status=1 
  AND 
      kb.id='$id'");
                            if ($kasadan_bankaya_eklenen_veri > 0) {
                                echo json_encode($kasadan_bankaya_eklenen_veri);
                            } else {
                                echo 2;
                            }
                        }
                    }
                } else {
                    echo 2;
                }
            } else {
                echo 1;
            }

        }
    }
}
if ($islem == "kasadan_bankaya_iptal_sql") {
    $id = $_POST["id"];
    $bilgiler = DB::single_query("SELECT * FROM kasadan_bankaya WHERE status=1 AND id='$id'");
    if ($bilgiler > 0) {
        $kasa_id = $bilgiler["kasa_id"];
        $banka_id = $bilgiler["banka_id"];
        $miktar = $bilgiler["gonderilen_tutar"];
        $banka_bilgi = DB::single_query("SELECT * FROM banka WHERE status=1 AND id='$banka_id'");
        if ($banka_bilgi > 0) {
            $banka_cekilen = $banka_bilgi["cekilen"];
            $yeni_cekilen = floatval($banka_cekilen) + floatval($miktar);
            $banka_arr = [
                'cekilen' => $yeni_cekilen,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $banka_guncelle = DB::update("banka", "id", $banka_id, $banka_arr);
            if ($banka_guncelle) {
                $kasa_bilgileri = DB::single_query("SELECT * FROM kasa WHERE status=1 AND id='$kasa_id'");
                if ($kasa_bilgileri > 0) {
                    $kasa_giren = $kasa_bilgileri["giren_tutar"];
                    $yeni_giren = floatval($kasa_giren) + floatval($miktar);
                    $kasa_arr = [
                        'giren_tutar' => $yeni_giren,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];
                    $kasa_guncelle = DB::update("kasa", "id", $kasa_id, $kasa_arr);
                    if ($kasa_guncelle) {
                        if (isset($_POST["delete_detail"])) {
                            $arr = [
                                'status' => 0,
                                'delete_userid' => $_SESSION["user_id"],
                                'delete_datetime' => date("Y-m-d H:i:s"),
                                'delete_detail' => $_POST["delete_detail"]
                            ];
                        } else {
                            $arr = [
                                'status' => 0,
                                'delete_userid' => $_SESSION["user_id"],
                                'delete_datetime' => date("Y-m-d H:i:s"),
                                'delete_detail' => "Kullanıcı Giriş Esnasındaki Listeden Silmiştir"
                            ];
                        }
                        $guncelle = DB::update("kasadan_bankaya", "id", $id, $arr);
                        if ($guncelle) {
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
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "kasadan_transfer_vazgec") {
    foreach ($_POST["id"] as $item) {
        $id = $item;
        $bilgiler = DB::single_query("SELECT * FROM kasadan_bankaya WHERE status=1 AND id='$id'");
        if ($bilgiler > 0) {
            $kasa_id = $bilgiler["kasa_id"];
            $banka_id = $bilgiler["banka_id"];
            $miktar = $bilgiler["gonderilen_tutar"];
            $banka_bilgi = DB::single_query("SELECT * FROM banka WHERE status=1 AND id='$banka_id'");
            if ($banka_bilgi > 0) {
                $banka_cekilen = $banka_bilgi["cekilen"];
                $yeni_cekilen = floatval($banka_cekilen) + floatval($miktar);
                $banka_arr = [
                    'cekilen' => $yeni_cekilen,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $banka_guncelle = DB::update("banka", "id", $banka_id, $banka_arr);
                if ($banka_guncelle) {
                    $kasa_bilgileri = DB::single_query("SELECT * FROM kasa WHERE status=1 AND id='$kasa_id'");
                    if ($kasa_bilgileri > 0) {
                        $kasa_giren = $kasa_bilgileri["giren_tutar"];
                        $yeni_giren = floatval($kasa_giren) + floatval($miktar);
                        $kasa_arr = [
                            'giren_tutar' => $yeni_giren,
                            'update_userid' => $_SESSION["user_id"],
                            'update_datetime' => date("Y-m-d H:i:s")
                        ];
                        $kasa_guncelle = DB::update("kasa", "id", $kasa_id, $kasa_arr);
                        if ($kasa_guncelle) {
                            $arr = [
                                'status' => 0,
                                'delete_userid' => $_SESSION["user_id"],
                                'delete_datetime' => date("Y-m-d H:i:s"),
                                'delete_detail' => "Kullanıcı Giriş Esnasındaki Listeden Silmiştir"
                            ];
                            $guncelle = DB::update("kasadan_bankaya", "id", $id, $arr);
                            if ($guncelle) {
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
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    }
}
if ($islem == "transfer_guncellenecek_bilgiler") {
    $id = $_GET["id"];
    $kasadan_bankaya_eklenen_veri = DB::single_query("
SELECT
       *
FROM 
     kasadan_bankaya
WHERE 
      status=1
  AND 
      id='$id'");
    if ($kasadan_bankaya_eklenen_veri > 0) {
        echo json_encode($kasadan_bankaya_eklenen_veri);
    } else {
        echo 2;
    }
}
if ($islem == "bankaya_yatirilan_paralari_getir_sql") {
    $ek_kasa = "";
    if ($_SESSION["sube_key"] != 0) {
        $ek_kasa = " AND kb.sube_key='$sube_key'";
    }
    $sql = "
SELECT
       kb.*,k.kasa_adi,b.banka_adi
FROM 
     kasadan_bankaya as kb
INNER JOIN kasa as k on k.id=kb.kasa_id
INNER JOIN banka as b on b.id=kb.banka_id
WHERE 
      kb.status=1 
  AND
      kb.cari_key='$cari_key' $ek_kasa";
    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        if ($bas_tarih != "" && $bit_tarih != "") {
            $sql .= " AND kb.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
        }
    }
    $verileri_getir = DB::all_data($sql);
    if ($verileri_getir > 0) {
        echo json_encode($verileri_getir);
    } else {
        echo 2;
    }
}
if ($islem == "bankadan_para_cek") {
    $banka_id = $_POST["banka_id"];
    $kasa_id = $_POST["kasa_id"];
    $banka_bilgileri = DB::single_query("SELECT cekilen FROM banka WHERE status=1 AND id='$banka_id'");
    if ($banka_bilgileri > 0) {
        $kasa_bilgileri = DB::single_query("SELECT giren_tutar FROM kasa WHERE status=1 AND id='$kasa_id'");
        if ($kasa_bilgileri > 0) {
            $banka_yatan = $banka_bilgileri["cekilen"];
            $kasa_cikan = $kasa_bilgileri["giren_tutar"];
            $bankaya_eklenecek = floatval($banka_yatan) + floatval($_POST["gonderilen_tutar"]);
            $kasadan_cikan = floatval($kasa_cikan) + floatval($_POST["gonderilen_tutar"]);

            $banka_arr = [
                'cekilen' => $bankaya_eklenecek,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];

            $kasa_arr = [
                'giren_tutar' => $kasadan_cikan,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];

            $banka_guncelle = DB::update("banka", "id", $banka_id, $banka_arr);
            if ($banka_guncelle) {
                $kasa_guncelle = DB::update("kasa", "id", $kasa_id, $kasa_arr);
                if ($kasa_guncelle) {
                    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
                    $_POST["insert_userid"] = $_SESSION["user_id"];
                    $kasadan_bankaya_ekle = DB::insert("bankadan_kasaya", $_POST);
                    if ($kasadan_bankaya_ekle) {
                        echo 2;
                    } else {
                        $son_id = DB::single_query("SELECT id FROM bankadan_kasaya where cari_key='$cari_key'  ORDER BY id DESC LIMIT 1");
                        if ($son_id > 0) {
                            $id = $son_id["id"];
                            $kasadan_bankaya_eklenen_veri = DB::single_query("
SELECT
       kb.*,k.kasa_adi,b.banka_adi
FROM 
     bankadan_kasaya as kb
INNER JOIN kasa as k on k.id=kb.kasa_id
INNER JOIN banka as b on b.id=kb.banka_id
WHERE 
      kb.status=1 
  AND 
      kb.id='$id'");
                            if ($kasadan_bankaya_eklenen_veri > 0) {
                                echo json_encode($kasadan_bankaya_eklenen_veri);
                            } else {
                                echo 2;
                            }
                        }
                    }
                } else {
                    echo 2;
                }
            } else {
                echo 1;
            }

        }
    }
}
if ($islem == "bankadan_kasaya_iptal_et_sql") {
    $id = $_POST["id"];
    $bilgiler = DB::single_query("SELECT * FROM bankadan_kasaya WHERE status=1 AND id='$id'");
    if ($bilgiler > 0) {
        $kasa_id = $bilgiler["kasa_id"];
        $banka_id = $bilgiler["banka_id"];
        $miktar = $bilgiler["gonderilen_tutar"];
        $banka_bilgi = DB::single_query("SELECT * FROM banka WHERE status=1 AND id='$banka_id'");
        if ($banka_bilgi > 0) {
            $banka_cekilen = $banka_bilgi["yatan"];
            $yeni_cekilen = floatval($banka_cekilen) + floatval($miktar);
            $banka_arr = [
                'yatan' => $yeni_cekilen,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $banka_guncelle = DB::update("banka", "id", $banka_id, $banka_arr);
            if ($banka_guncelle) {
                $kasa_bilgileri = DB::single_query("SELECT * FROM kasa WHERE status=1 AND id='$kasa_id'");
                if ($kasa_bilgileri > 0) {
                    $kasa_giren = $kasa_bilgileri["cikan_tutar"];
                    $yeni_giren = floatval($kasa_giren) + floatval($miktar);
                    $kasa_arr = [
                        'cikan_tutar' => $yeni_giren,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];
                    $kasa_guncelle = DB::update("kasa", "id", $kasa_id, $kasa_arr);
                    if ($kasa_guncelle) {
                        if (isset($_POST["delete_detail"])) {
                            $arr = [
                                'status' => 0,
                                'delete_userid' => $_SESSION["user_id"],
                                'delete_datetime' => date("Y-m-d H:i:s"),
                                'delete_detail' => $_POST["delete_detail"]
                            ];
                        } else {
                            $arr = [
                                'status' => 0,
                                'delete_userid' => $_SESSION["user_id"],
                                'delete_datetime' => date("Y-m-d H:i:s"),
                                'delete_detail' => "Kullanıcı Giriş Esnasındaki Listeden Silmiştir"
                            ];
                        }
                        $guncelle = DB::update("bankadan_kasaya", "id", $id, $arr);
                        if ($guncelle) {
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
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "bankada_transfer_guncellenecek_bilgiler") {
    $id = $_GET["id"];
    $kasadan_bankaya_eklenen_veri = DB::single_query("
SELECT
       *
FROM 
     bankadan_kasaya
WHERE 
      status=1
  AND 
      id='$id'");
    if ($kasadan_bankaya_eklenen_veri > 0) {
        echo json_encode($kasadan_bankaya_eklenen_veri);
    } else {
        echo 2;
    }
}
if ($islem == "bankadan_transfer_vazgec") {
    foreach ($_POST["id"] as $item) {
        $id = $item;
        $bilgiler = DB::single_query("SELECT * FROM bankadan_kasaya WHERE status=1 AND id='$id'");
        if ($bilgiler > 0) {
            $kasa_id = $bilgiler["kasa_id"];
            $banka_id = $bilgiler["banka_id"];
            $miktar = $bilgiler["gonderilen_tutar"];
            $banka_bilgi = DB::single_query("SELECT * FROM banka WHERE status=1 AND id='$banka_id'");
            if ($banka_bilgi > 0) {
                $banka_cekilen = $banka_bilgi["yatan"];
                $yeni_cekilen = floatval($banka_cekilen) + floatval($miktar);
                $banka_arr = [
                    'yatan' => $yeni_cekilen,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $banka_guncelle = DB::update("banka", "id", $banka_id, $banka_arr);
                if ($banka_guncelle) {
                    $kasa_bilgileri = DB::single_query("SELECT * FROM kasa WHERE status=1 AND id='$kasa_id'");
                    if ($kasa_bilgileri > 0) {
                        $kasa_giren = $kasa_bilgileri["cikan_tutar"];
                        $yeni_giren = floatval($kasa_giren) + floatval($miktar);
                        $kasa_arr = [
                            'cikan_tutar' => $yeni_giren,
                            'update_userid' => $_SESSION["user_id"],
                            'update_datetime' => date("Y-m-d H:i:s")
                        ];
                        $kasa_guncelle = DB::update("kasa", "id", $kasa_id, $kasa_arr);
                        if ($kasa_guncelle) {
                            $arr = [
                                'status' => 0,
                                'delete_userid' => $_SESSION["user_id"],
                                'delete_datetime' => date("Y-m-d H:i:s"),
                                'delete_detail' => "Kullanıcı Giriş Esnasındaki Listeden Silmiştir"
                            ];
                            $guncelle = DB::update("bankadan_kasaya", "id", $id, $arr);
                            if ($guncelle) {
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
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    }
}
if ($islem == "bankadan_kasaya_cekilenleri_getir_sql") {

    $ek_gelen = "";

    if ($_SESSION["sube_key"] != 0) {
        $ek_gelen = " AND kb.sube_key='$sube_key'";
    }
    $sql = "
SELECT
       kb.*,k.kasa_adi,b.banka_adi
FROM 
     bankadan_kasaya as kb
INNER JOIN kasa as k on k.id=kb.kasa_id
INNER JOIN banka as b on b.id=kb.banka_id
WHERE 
      kb.status=1 $ek_gelen";
    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        if ($bas_tarih != "" && $bit_tarih != "") {
            $sql .= " AND kb.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
        }
    }
    $kasadan_bankaya_eklenen_veri = DB::all_data($sql);
    if ($kasadan_bankaya_eklenen_veri > 0) {
        echo json_encode($kasadan_bankaya_eklenen_veri);
    } else {
        echo 2;
    }
}
if ($islem == "acilis_icin_kasalari_getir") {

    $acilis_icin_kasalari_getir = DB::all_data("SELECT * FROM kasa WHERE status=1 AND cari_key='$cari_key' $ek_sorgu");
    if ($acilis_icin_kasalari_getir > 0) {
        echo json_encode($acilis_icin_kasalari_getir);
    } else {
        echo 2;
    }
}
if ($islem == "kasa_acilis_fisi_ekle") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $kasa_acilis_fisi_ekle = DB::insert("kasa_acilis_fisi", $_POST);
    if ($kasa_acilis_fisi_ekle) {
        echo 2;
    } else {
        $son_eklenen = DB::single_query("SELECT id FROM kasa_acilis_fisi where cari_key='$cari_key'  ORDER BY id DESC LIMIT 1");
        $son_id = $son_eklenen["id"];
        $kasa_id = $_POST["kasa_id"];
        $kasa_bilgileri = DB::single_query("SELECT giren_tutar,cikan_tutar FROM kasa WHERE status=1 AND id='$kasa_id'");
        if ($kasa_bilgileri > 0) {
            $yeni_giren = floatval($kasa_bilgileri["giren_tutar"]) + floatval($_POST["giren_tutar"]);
            $yeni_cikan = floatval($kasa_bilgileri["cikan_tutar"]) + floatval($_POST["cikan_tutar"]);
            $kasa_arr = [
                'giren_tutar' => $yeni_giren,
                'cikan_tutar' => $yeni_cikan,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $kasa_guncelle = DB::update("kasa", "id", $kasa_id, $kasa_arr);
            if ($kasa_guncelle) {
                $eklenen_kasa_bilgileri = DB::single_query("
SELECT 
       kaf.giren_tutar,kaf.cikan_tutar,kaf.aciklama,k.kasa_adi,k.kasa_kodu,kaf.id
FROM 
     kasa_acilis_fisi as kaf
INNER JOIN kasa AS k on k.id=kaf.kasa_id
WHERE 
      kaf.status=1 
  AND 
      kaf.id='$son_id'");
                if ($eklenen_kasa_bilgileri > 0) {
                    echo json_encode($eklenen_kasa_bilgileri);
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
if ($islem == "secilen_acilislari_sil_sql") {
    foreach ($_POST["id"] as $item) {
        $id = $item;
        $acilis_bilgi = DB::single_query("SELECT giren_tutar,cikan_tutar,kasa_id FROM kasa_acilis_fisi WHERE status=1 AND id='$id'");
        if ($acilis_bilgi > 0) {
            $kasa_id = $acilis_bilgi["kasa_id"];
            $kasa_bilgi = DB::single_query("SELECT giren_tutar,cikan_tutar FROM kasa WHERE status=1 AND id='$kasa_id'");
            if ($kasa_bilgi > 0) {
                $yeni_giren = floatval($kasa_bilgi["giren_tutar"]) - floatval($acilis_bilgi["giren_tutar"]);
                $yeni_cikan = floatval($kasa_bilgi["cikan_tutar"]) - floatval($acilis_bilgi["cikan_tutar"]);
                $kasa_arr = [
                    'giren_tutar' => $yeni_giren,
                    'cikan_tutar' => $yeni_cikan,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $kasa_guncelle = DB::update("kasa", "id", $kasa_id, $kasa_arr);
                if ($kasa_guncelle) {
                    if (isset($_POST["delete_detail"])) {
                        $arr = [
                            'status' => 0,
                            'delete_userid' => $_SESSION["user_id"],
                            'delete_datetime' => date("Y-m-d H:i:s"),
                            'delete_detail' => $_POST["delete_detail"],
                        ];
                    } else {
                        $arr = [
                            'status' => 0,
                            'delete_userid' => $_SESSION["user_id"],
                            'delete_datetime' => date("Y-m-d H:i:s"),
                            'delete_detail' => "Kullanıcı Açılış Oluşturulurken Silinmiştir",
                        ];
                    }
                    $acilis_guncelle = DB::update("kasa_acilis_fisi", "id", $item, $arr);
                }
            }
        }
    }
    if ($acilis_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "secilen_kasa_acilis_bilgileri_sql") {
    $id = $_GET["id"];
    $secilen_acilis = DB::single_query("SELECT * FROM kasa_acilis_fisi WHERE status=1 AND id='$id'");
    if ($secilen_acilis > 0) {
        echo json_encode($secilen_acilis);
    } else {
        echo 2;
    }
}
if ($islem == "kasa_acilis_fislerini_getir_sql") {
    $ek1 = "";
    if ($_SESSION["sube_key"] != 0) {
        $ek1 = " AND kaf.sube_key='$sube_key'";
    }
    $acilis_fisleri = DB::all_data("
SELECT 
       kaf.*,k.kasa_adi,k.kasa_kodu
FROM 
     kasa_acilis_fisi as kaf
INNER JOIN kasa as k on k.id=kaf.kasa_id
WHERE kaf.status=1 AND kaf.cari_key='$cari_key' $ek1");
    if ($acilis_fisleri > 0) {
        echo json_encode($acilis_fisleri);
    } else {
        echo 2;
    }
}
if ($islem == "acilis_bilgilerini_getir_sql") {
    $id = $_GET["id"];
    $kasa_acilis_bilgi = DB::single_query("SELECT * FROM kasa_acilis_fisi WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    if ($kasa_acilis_bilgi > 0) {
        echo json_encode($kasa_acilis_bilgi);
    } else {
        echo 2;
    }
}
if ($islem == "acilis_fisi_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $acilis_fisi_guncelle = DB::update("kasa_acilis_fisi", "id", $_POST["id"], $_POST);
    if ($acilis_fisi_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "virman_bilgilerini_getir_sql") {
    $id = $_GET["id"];
    $kasa_virman_bilgi = DB::single_query("SELECT * FROM kasa_virman WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    if ($kasa_virman_bilgi > 0) {
        echo json_encode($kasa_virman_bilgi);
    } else {
        echo 2;
    }
}
if ($islem == "kasa_virman_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $kasa_virman_guncelle = DB::update("kasa_virman", "id", $_POST["id"], $_POST);
    if ($kasa_virman_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "kasadan_bankaya_bilgileri_sql") {
    $id = $_GET["id"];
    $banka_kasa_bilgi = DB::single_query("SELECT * FROM kasadan_bankaya WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    if ($banka_kasa_bilgi > 0) {
        echo json_encode($banka_kasa_bilgi);
    } else {
        echo 2;
    }
}
if ($islem == "transferi_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DB::update("kasadan_bankaya", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "bankadan_kasaya_bilgileri_sql") {
    $id = $_GET["id"];
    $banka_kasa_bilgi = DB::single_query("SELECT * FROM bankadan_kasaya WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    if ($banka_kasa_bilgi > 0) {
        echo json_encode($banka_kasa_bilgi);
    } else {
        echo 2;
    }
}
if ($islem == "transferi_guncelle_banka_cekilen_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DB::update("bankadan_kasaya", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "tahsilat_fislerini_getir_sql") {
    $id = $_GET["id"];
    $tahsilat_bilgileri = DB::single_query("
SELECT 
       ktu.*,
       kt.belge_no,
       ut.uye_adi,
       c.cari_adi,
       kt.islem_tarihi
FROM
     kasa_tahsilat_urunler as ktu
INNER JOIN kasa_tahsilat as kt on kt.id=ktu.tahsilat_id
LEFT JOIN uye_tanim as ut on ut.id=ktu.uye_id
LEFT JOIN cari as c on c.id=ktu.cari_id
WHERE ktu.status=1 AND ktu.tahsilat_id='$id'");
    if ($tahsilat_bilgileri > 0) {
        echo json_encode($tahsilat_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "son_belge_noyu_getir_sql") {
    $son_belge = DB::single_query("SELECT * FROM kasa_tahsilat WHERE status=1 AND cari_key='$cari_key   ORDER BY id DESC LIMIT 1'");
    if ($son_belge > 0) {
        $belge_no = floatval($son_belge["belge_no"]);
        $belge_no += 1;
        $basamak_sayisi = strlen((string)$belge_no);
        switch ($basamak_sayisi) {
            case 1:
                // İki basamaklı işlem
                echo "00000" . $belge_no;
                // İşlem kodu buraya yazılabilir
                break;
            case 2:
                // Üç basamaklı işlem
                echo "0000" . $belge_no;
                // İşlem kodu buraya yazılabilir
                break;
            case 3:
                // Dört basamaklı işlem
                echo "0000" . $belge_no;
                // İşlem kodu buraya yazılabilir
                break;
            case 4:
                echo "000" . $belge_no;
                break;
            case 5:
                echo "00" . $belge_no;
                break;
            default:
                echo "0" . $belge_no;
        }
    } else {
        $belge_no = "000001";
    }
}