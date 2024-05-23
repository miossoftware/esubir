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
if ($islem == "cari_hesap_ekstre_getir") {
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

    $per_kode = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");
    $personel_kodu = $per_kode["cari_kodu"];

    $alis_faturalari = DB::all_data("
SELECT
fatura_no,
vade_tarihi,
fatura_tarihi,
aciklama,
genel_toplam
FROM
alis_default
WHERE status=1 AND cari_key='$cari_key' AND doviz_tur='$doviz_turu' AND cari_id='$cari_id' AND fatura_tarihi < '$last_bas_tarih 23:59:59'");

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

    $stok_cikisi = DB::single_query("
SELECT
       SUM(asu.toplam_tutar) as genel_toplam
FROM
     araclara_stok_cik as arac
INNER JOIN araclara_stok_urunler as asu on asu.ana_id=arac.id
INNER JOIN arac_kartlari as ak on ak.id=asu.plaka_id
WHERE arac.status=1 AND asu.status=1 AND arac.cari_key='$cari_key' AND ak.cari_id='$cari_id' AND arac.tarih < '$last_bas_tarih 23:59:59'
");
    $cari_devir_borc += $stok_cikisi["genel_toplam"];

    $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(byc.tl_tutar) as tutar
FROM
binek_yakit_fatura as laf
INNER JOIN binek_fis_faturasi as lafu on lafu.fatura_id=laf.id
INNER JOIN binek_yakit_cikis as byc on byc.id=lafu.yakit_fis_id
WHERE laf.status=1 AND lafu.status=1 AND laf.cari_key='$cari_key' AND laf.cari_id='$cari_id' AND laf.fatura_tarihi < '$last_bas_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari["tutar"];

    $kiralik_yakit_alim = DB::single_query("SELECT SUM(tl_tutar) as tutar FROM yakit_cikis_fisleri WHERE status!=0 AND kiralik_cari_id='$cari_id' AND tarih < '$last_bas_tarih 23:59:59'");
    $cari_devir_borc += $kiralik_yakit_alim["tutar"];

    $lastik_alis_faturalari1 = DB::single_query("
SELECT
SUM(lafu.toplam) as tutar
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.fatura_id=laf.id
WHERE laf.status=1 AND lafu.status=1 AND laf.doviz_tur='$doviz_turu' AND laf.cari_key='$cari_key' AND laf.cari_id='$cari_id' AND laf.fatura_tarihi < '$last_bas_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari1["tutar"];

    $vergi_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
vergi_gider as laf
INNER JOIN vergi_gider_fisi as lafu on lafu.gider_id=laf.id
WHERE laf.status=1 AND lafu.status=1 AND laf.cari_key='$cari_key' AND lafu.cari_id='$cari_id' AND laf.tarih < '$last_bas_tarih 23:59:59'");
    $cari_devir_alacak += $vergi_gider["tutar"];

    $yonetim_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
yonetim_gider as laf
INNER JOIN yonetim_gider_fisi as lafu on lafu.gider_id=laf.id
WHERE laf.status=1 AND lafu.status=1 AND laf.cari_key='$cari_key' AND lafu.cari_id='$cari_id' AND laf.tarih < '$last_bas_tarih 23:59:59'");
    $cari_devir_alacak += $yonetim_gider["tutar"];


    $sgk_gider_fisleri = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar 
FROM
     sgk_giderleri as laf
INNER JOIN sgk_gider_fisleri as lafu on lafu.gider_id=laf.id
WHERE laf.status=1 AND lafu.status=1 AND laf.cari_key='$cari_key' AND lafu.cari_id='$cari_id' AND laf.tarih < '$last_bas_tarih 23:59:59'");
    $cari_devir_alacak += $sgk_gider_fisleri["tutar"];


    $arac_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
     arac_gider as laf
INNER JOIN arac_gider_fisi as lafu on lafu.gider_id=laf.id
WHERE laf.status=1 AND lafu.status=1 AND laf.cari_key='$cari_key' AND lafu.cari_id='$cari_id' AND laf.tarih < '$last_bas_tarih 23:59:59'");
    $cari_devir_alacak += $arac_gider["tutar"];

    if ($lastik_alis_faturalari > 0) {
        foreach ($lastik_alis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $satis_faturalari = DB::all_data("
SELECT
pta.islem_tarihi,
pta.aciklama,
pta.tutar
FROM
personel_tahakkuk as pta
INNER JOIN personel_tahakkuk_ana as pta1 on pta1.id=pta.tahakuk_id
INNER JOIN personel_tanim as pt on pt.id=pta.personel_id
WHERE pta.status=1 AND pta.cari_key='$cari_key' AND pta1.status=1 AND pt.personel_kodu='$personel_kodu' AND pta.islem_tarihi < '$last_bas_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["tutar"];
        }
    }

    $satis_faturalari = DB::all_data("
SELECT
genel_toplam
FROM
satis_default
WHERE status=1 AND doviz_tur='$doviz_turu' AND cari_key='$cari_key' AND cari_id='$cari_id' AND fatura_tarihi < '$last_bas_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $cari_devir_borc += $alislar["genel_toplam"];
        }
    }

    $sanayi_fis_fat = DB::all_data("
SELECT
       sf.*,
       c.cari_adi,
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
WHERE sf.status=1 AND sf.cari_key='$cari_key' AND sf.cari_id='$cari_id' AND sf.fatura_tarih < '$last_bas_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }
    $sanayi_fis_fat = DB::all_data("
SELECT
       sf.*,
       c.cari_adi,
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     binek_sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN binek_sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
WHERE sf.status=1 AND sf.cari_key='$cari_key' AND sf.cari_id='$cari_id' AND sf.fatura_tarih < '$last_bas_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $satis_faturalari = DB::all_data("
SELECT
belge_no,
tarih,
aciklama,
tutar
FROM
pos_cekim
WHERE status=1 AND cari_key='$cari_key' AND cari_id='$cari_id' AND tarih < '$last_bas_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["tutar"];
        }
    }

    $gider_faturalari = DB::all_data("
SELECT
mg.fatura_no as belge_no,
mg.fatura_tarihi as tarih,
mg.aciklama,
SUM(mgu.genel_toplam) as tutar
FROM
muhasebe_gider_urunler as mgu
INNER JOIN muhasebe_gider as mg on mgu.gider_id=mg.id
WHERE mg.status=1 AND mg.cari_key='$cari_key' AND mgu.cari_id='$cari_id' AND mg.fatura_tarihi < '$last_bas_tarih 23:59:59' GROUP BY mgu.id");
    if ($gider_faturalari > 0) {
        foreach ($gider_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["tutar"];
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
WHERE acu.status!=0 AND acg.doviz_tur='$doviz_turu' AND acu.bizim=2 AND acg.acilis_mi!=2 AND acu.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acg.tarih < '$last_bas_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["girilen_tutar"];
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
     cikis_cek_urunler AS acu
INNER JOIN alinan_cek_cikis AS acg on acg.id=acu.cikis_cekid
WHERE acu.status!=0 AND acg.doviz_tur='$doviz_turu' AND acg.status!=0 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acg.tarih < '$last_bas_tarih 23:59:59'");

    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $cari_devir_borc += $alislar["girilen_tutar"];
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
acu.tarih,
acg.seri_no,
acu.aciklama,
acg.vade_tarih,
acg.tutar
FROM
     bizim_senet_cikis AS acu
INNER JOIN bizim_senet_urunler AS acg on acg.bizim_senetid=acu.id
WHERE acu.status!=0 AND acu.doviz_turu='$doviz_turu' AND acg.status!=0 AND acu.cari_key='$cari_key' AND acu.cari_id='$cari_id' AND acu.tarih < '$last_bas_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $cari_devir_borc += $alislar["girilen_tutar"];
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
acu.tarih,
acg.seri_no,
acu.aciklama,
acg.vade_tarih,
acg.tutar
FROM
     bizim_cek_cikis AS acu
INNER JOIN bizim_cek_urunler AS acg on acg.bizim_cekid=acu.id
WHERE acu.status!=0 AND acu.doviz_turu='$doviz_turu' AND acg.status!=0 AND acu.acilis_mi!=2 AND acu.cari_key='$cari_key' AND acu.cari_id='$cari_id' AND acu.tarih < '$last_bas_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $cari_devir_borc += $alislar["tutar"];
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
acu.insert_datetime,
ac.seri_no,
acg.aciklama,
ac.vade_tarih,
ac.girilen_tutar
FROM
     karsiliksiz_cek_senet AS acu
INNER JOIN alinan_cek_urunler as ac on ac.id=acu.alinan_cekid
INNER JOIN alinan_cek_giris AS acg on acg.id=ac.alinan_cekid
WHERE acu.status=1 AND acu.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acg.insert_datetime < '$last_bas_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $cari_devir_borc += $alislar["girilen_tutar"];
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
     alinan_senet_urunler AS acu
INNER JOIN alinan_senet_giris AS acg on acg.id=acu.alinan_senetid
WHERE acu.status!=0 AND acg.doviz_tur='$doviz_turu' AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acg.tarih < '$last_bas_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["girilen_tutar"];
        }
    }

    $havale_giris = DB::all_data("
SELECT
hg.islem_tarihi,
hgu.giris_tutar,
hg.belge_no,
hgu.aciklama
FROM havale_giris_urunler as hgu
INNER JOIN havale_giris AS hg on hg.id=hgu.giris_id
INNER JOIN banka as b on b.id=hg.banka_id
WHERE hg.status=1 AND hgu.status=1 AND hgu.status=1 AND b.doviz_tipi='$doviz_turu' AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi < '$last_bas_tarih 23:59:59'");
    if ($havale_giris > 0) {
        foreach ($havale_giris as $giris) {
            $cari_devir_alacak += $giris["giris_tutar"];
        }
    }

    $havale_cikis = DB::all_data("
SELECT
hg.islem_tarihi,
hgu.cikis_tutar,
hg.belge_no,
hg.aciklama
FROM havale_cikis_urunler as hgu
INNER JOIN havale_cikis AS hg on hg.id=hgu.cikis_id
INNER JOIN banka as b on b.id=hg.banka_id
WHERE hg.status=1 AND hgu.status=1 AND b.doviz_tipi='$doviz_turu' AND hgu.status=1 and  hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi < '$last_bas_tarih 23:59:59'");
    if ($havale_cikis > 0) {
        foreach ($havale_cikis as $giris) {
            $cari_devir_borc += $giris["cikis_tutar"];
            $belge_turu = "Havale Çıkış";
        }
    }
    $kart_islemi = DB::all_data("
SELECT
tutar,
tarih,
belge_no,
aciklama
FROM kart_harcama
WHERE status=1 AND cari_id='$cari_id' AND cari_key='$cari_key' AND tarih < '$last_bas_tarih 23:59:59'");
    if ($kart_islemi > 0) {
        foreach ($kart_islemi as $giris) {
            $cari_devir_borc += $giris["tutar"];
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
WHERE hg.status=1 AND hgu.status=1 AND  hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi < '$last_bas_tarih 23:59:59'");
    if ($kasa_tahsilat > 0) {
        foreach ($kasa_tahsilat as $giris) {
            $cari_devir_borc -= $giris["tutar"];
        }
    }

    $kasa_odeme = DB::all_data("
SELECT
hg.islem_tarihi,
hgu.tutar,
hg.belge_no,
hg.aciklama
FROM kasa_odeme_urunler as hgu
INNER JOIN kasa_odeme AS hg on hg.id=hgu.odeme_id
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi < '$last_bas_tarih 23:59:59'");

    if ($kasa_odeme > 0) {
        foreach ($kasa_odeme as $giris) {
            $cari_devir_alacak -= $giris["tutar"];
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
WHERE hg.status=1 and hg.doviz_tur='$doviz_turu' and  hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi < '$last_bas_tarih 23:59:59'");

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
alacak,
aciklama
FROM cari_acilis_fisleri
WHERE status=1 AND doviz_turu='$doviz_turu' AND cari_key='$cari_key' AND cari_id='$cari_id' AND acilis_tarihi < '$last_bas_tarih 23:59:59'");
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
WHERE acu.status!=0 AND acg.doviz_tur='$doviz_turu' AND acg.acilis_mi!=2 AND acg.status!=0 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acg.tarih BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59'");
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
    $stok_cikisi = DB::all_data("
SELECT
asu.toplam_tutar,
arac.tarih,
arac.belge_no,
arac.aciklama
FROM
     araclara_stok_cik as arac
INNER JOIN araclara_stok_urunler as asu on asu.ana_id=arac.id
INNER JOIN arac_kartlari as ak on ak.id=asu.plaka_id
WHERE arac.status=1 AND asu.status=1 AND arac.cari_key='$cari_key' AND ak.cari_id='$cari_id' AND arac.tarih BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59'
");
    if ($stok_cikisi > 0) {
        foreach ($stok_cikisi as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'belge_no' => $alislar["belge_no"],
                'belge_turu' => 'ARACA STOK ÇIKIŞI',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["tarih"],
                'tutar' => $alislar["toplam_tutar"],
                'doviz_tur' => "TL",
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }

    $satis_faturalari = DB::all_data("
SELECT 
       tl_tutar,
       tarih,
       aciklama,
       kiralik_plaka,
       miktar
FROM
     yakit_cikis_fisleri
WHERE
      status!=0
       AND 
       kiralik_cari_id='$cari_id'
        AND
         tarih BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59'
");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $miktar = number_format($alislar["miktar"], 2);
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'belge_no' => $alislar["fis_no"],
                'belge_turu' => 'YAKIT ALIM FİŞİ',
                'aciklama' => $alislar["kiralik_plaka"] . " " . $miktar . " LT",
                'vade_tarihi' => $alislar["tarih"],
                'tutar' => $alislar["tl_tutar"],
                'doviz_tur' => "TL",
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }

    $binek_yakit_fat = DB::all_data("
SELECT
byc.tl_tutar,
laf.fatura_tarihi,
laf.fatura_no,
bk.arac_plaka
FROM
binek_yakit_fatura as laf
INNER JOIN binek_fis_faturasi as lafu on lafu.fatura_id=laf.id
INNER JOIN binek_yakit_cikis as byc on byc.id=lafu.yakit_fis_id
INNER JOIN binek_kartlari as bk on bk.id=byc.plaka_id
WHERE laf.status=1 AND lafu.status=1 AND laf.cari_key='$cari_key' AND laf.cari_id='$cari_id' AND laf.fatura_tarihi BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59'");
    if ($binek_yakit_fat > 0) {
        foreach ($binek_yakit_fat as $item) {
            $duzenle_arr3 = [
                'tarih' => $item["fatura_tarihi"],
                'belge_no' => $item["fatura_no"],
                'belge_turu' => 'YAKIT ALIM FATURASI',
                'aciklama' => $item["arac_plaka"],
                'vade_tarihi' => $item["fatura_tarihi"],
                'tutar' => $item["tl_tutar"],
                'doviz_tur' => "TL",
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }

    $satis_faturalari = DB::all_data("
SELECT
acg.tarih,
acu.seri_no,
acg.aciklama,
acu.vade_tarih,
acu.girilen_tutar,
acg.doviz_tur
FROM
     cikis_cek_urunler AS acu
INNER JOIN alinan_cek_cikis AS acg on acg.id=acu.cikis_cekid
WHERE acu.status!=0 AND acg.doviz_tur='$doviz_turu' AND acg.status!=0 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acg.tarih BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'belge_no' => $alislar["seri_no"],
                'belge_turu' => 'Çek Çıkış',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["vade_tarih"],
                'tutar' => $alislar["girilen_tutar"],
                'doviz_tur' => $alislar["doviz_tur"],
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }

    $lastik_alis_faturalari = DB::all_data("
SELECT
laf.genel_toplam,
laf.fatura_tarihi,
laf.fatura_no,
laf.aciklama,
laf.vade_tarihi,
laf.doviz_tur
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.fatura_id=laf.id
WHERE laf.status=1 AND laf.doviz_tur='$doviz_turu' AND lafu.status=1 AND laf.cari_key='$cari_key' AND laf.cari_id='$cari_id' AND laf.fatura_tarihi BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59'");

    if ($lastik_alis_faturalari > 0) {
        foreach ($lastik_alis_faturalari as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["fatura_tarihi"],
                'belge_no' => $alislar["fatura_no"],
                'belge_turu' => 'Lastik Alış Faturası',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["vade_tarih"],
                'tutar' => $alislar["genel_toplam"],
                'doviz_tur' => $alislar["doviz_tur"],
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }

    $sanayi_fis_fat = DB::all_data("
SELECT
       sf.*,
       c.cari_adi,
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
WHERE sf.status=1 AND sf.cari_key='$cari_key' AND sf.cari_id='$cari_id' AND sf.fatura_tarih BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["fatura_tarih"],
                'belge_no' => $alislar["fatura_no"],
                'belge_turu' => 'Sanayi Faturası',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["fatura_tarih"],
                'tutar' => $alislar["genel_toplam"],
                'doviz_tur' => "TL",
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }
    $sanayi_fis_fat = DB::all_data("
SELECT
       sf.*,
       c.cari_adi,
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     binek_sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN binek_sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
WHERE sf.status=1 AND sf.cari_key='$cari_key' AND sf.cari_id='$cari_id' AND sf.fatura_tarih BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["fatura_tarih"],
                'belge_no' => $alislar["fatura_no"],
                'belge_turu' => 'Binek Sanayi Faturası',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["fatura_tarih"],
                'tutar' => $alislar["genel_toplam"],
                'doviz_tur' => "TL",
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }
    $vergi_gider = DB::all_data("
SELECT
lafu.tutar,
laf.aciklama,
laf.tarih,
ak.plaka_no
FROM
vergi_gider as laf
INNER JOIN vergi_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN arac_kartlari as ak on lafu.plaka_id=ak.id
WHERE laf.status=1 AND lafu.status=1 AND laf.cari_key='$cari_key' AND lafu.cari_id='$cari_id' AND laf.tarih BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59'");
    if ($vergi_gider > 0) {
        foreach ($vergi_gider as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'belge_no' => $alislar["plaka_no"],
                'belge_turu' => 'VERGİ GİDER',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["tarih"],
                'tutar' => $alislar["tutar"],
                'doviz_tur' => "TL",
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }

    $yonetim_gider = DB::all_data("
SELECT
lafu.tutar,
laf.aciklama,
laf.tarih,
ak.plaka_no
FROM
yonetim_gider as laf
INNER JOIN yonetim_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN arac_kartlari as ak on lafu.plaka_id=ak.id
WHERE laf.status=1 AND lafu.status=1 AND laf.cari_key='$cari_key' AND lafu.cari_id='$cari_id' AND laf.tarih BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59'");
    if ($yonetim_gider > 0) {
        foreach ($yonetim_gider as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'belge_no' => $alislar["plaka_no"],
                'belge_turu' => 'YÖNETİM GİDER',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["tarih"],
                'tutar' => $alislar["tutar"],
                'doviz_tur' => "TL",
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }


    $sgk_gider_fisleri = DB::all_data("
SELECT
lafu.tutar,
laf.aciklama,
laf.tarih,
ak.plaka_no
FROM
sgk_giderleri as laf
INNER JOIN sgk_gider_fisleri as lafu on lafu.gider_id=laf.id
INNER JOIN arac_kartlari as ak on lafu.plaka_id=ak.id
WHERE laf.status=1 AND lafu.status=1 AND laf.cari_key='$cari_key' AND lafu.cari_id='$cari_id' AND laf.tarih BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59'");
    if ($sgk_gider_fisleri > 0) {
        foreach ($sgk_gider_fisleri as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'belge_no' => $alislar["plaka_no"],
                'belge_turu' => 'SGK GİDER',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["tarih"],
                'tutar' => $alislar["tutar"],
                'doviz_tur' => "TL",
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }


    $arac_gider = DB::all_data("
SELECT
lafu.tutar,
laf.aciklama,
laf.tarih,
ak.plaka_no
FROM
     arac_gider as laf
INNER JOIN arac_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN arac_kartlari as ak on lafu.plaka_id=ak.id
WHERE laf.status=1 AND lafu.status=1 AND laf.cari_key='$cari_key' AND lafu.cari_id='$cari_id' AND laf.tarih BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59'");
    if ($arac_gider > 0) {
        foreach ($arac_gider as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'belge_no' => $alislar["plaka_no"],
                'belge_turu' => 'ARAC GİDER',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["tarih"],
                'tutar' => $alislar["tutar"],
                'doviz_tur' => "TL",
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
belge_no,
tarih,
aciklama,
tutar
FROM
pos_cekim
WHERE status=1 AND cari_key='$cari_key' AND cari_id='$cari_id' AND tarih  BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'belge_no' => $alislar["belge_no"],
                'belge_turu' => 'POS ÇEKİM',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["tarih"],
                'tutar' => $alislar["tutar"],
                'doviz_tur' => "TL",
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }
    $gider_faturalari = DB::all_data("
SELECT
mg.fatura_no as belge_no,
mg.fatura_tarihi as tarih,
mg.aciklama,
SUM(mgu.genel_toplam) as tutar
FROM
muhasebe_gider_urunler as mgu
INNER JOIN muhasebe_gider as mg on mgu.gider_id=mg.id
WHERE mg.status=1 AND mg.cari_key='$cari_key' AND mgu.cari_id='$cari_id' AND mg.fatura_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY mgu.id");
    if ($gider_faturalari > 0) {
        foreach ($gider_faturalari as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'belge_no' => $alislar["belge_no"],
                'belge_turu' => 'Muhasebe Gider Faturası',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["tarih"],
                'tutar' => $alislar["tutar"],
                'doviz_tur' => "TL",
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
acu.tarih,
acg.seri_no,
acu.aciklama,
acg.vade_tarih,
acg.tutar,
acu.doviz_turu
FROM
     bizim_cek_cikis AS acu
INNER JOIN bizim_cek_urunler AS acg on acg.bizim_cekid=acu.id
WHERE acu.status!=0 AND acu.doviz_turu='$doviz_turu' AND acg.status!=0 AND acu.acilis_mi!=2 AND acu.cari_key='$cari_key' AND acu.cari_id='$cari_id' AND acu.tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'belge_no' => $alislar["seri_no"],
                'belge_turu' => 'Verilen Çek',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["vade_tarih"],
                'tutar' => $alislar["tutar"],
                'doviz_tur' => $alislar["doviz_turu"],
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
acu.tarih,
acg.seri_no,
acu.aciklama,
acg.vade_tarih,
acg.tutar,
acu.doviz_turu
FROM
     bizim_senet_cikis AS acu
INNER JOIN bizim_senet_urunler AS acg on acg.bizim_senetid=acu.id
WHERE acu.status!=0 AND acu.doviz_turu='$doviz_turu' AND acg.status!=0 AND acu.cari_key='$cari_key' AND acu.cari_id='$cari_id' AND acu.tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'belge_no' => $alislar["seri_no"],
                'belge_turu' => 'Bizden Verilen Senet',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["vade_tarih"],
                'tutar' => $alislar["tutar"],
                'doviz_tur' => $alislar["doviz_turu"],
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
acu.insert_datetime,
ac.seri_no,
acg.aciklama,
ac.vade_tarih,
ac.girilen_tutar,
acg.doviz_tur
FROM
     karsiliksiz_cek_senet AS acu
INNER JOIN alinan_cek_urunler as ac on ac.id=acu.alinan_cekid
INNER JOIN alinan_cek_giris AS acg on acg.id=ac.alinan_cekid
WHERE acu.status!=0 AND  acg.acilis_mi!=2 AND acu.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acg.insert_datetime BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["insert_datetime"],
                'belge_no' => $alislar["seri_no"],
                'belge_turu' => 'Karşılıksız Çek',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["vade_tarih"],
                'tutar' => $alislar["girilen_tutar"],
                'doviz_tur' => $alislar["doviz_tur"],
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }

    $satis_faturalari = DB::all_data("
SELECT
acg.tarih,
acu.seri_no,
acg.aciklama,
acu.vade_tarih,
acu.girilen_tutar,
acg.doviz_tur
FROM
     alinan_senet_urunler AS acu
INNER JOIN alinan_senet_giris AS acg on acg.id=acu.alinan_senetid
WHERE acu.status=1 AND acg.doviz_tur='$doviz_turu' AND acg.status!=0 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acg.tarih BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'belge_no' => $alislar["seri_no"],
                'belge_turu' => 'Senet Giriş',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["vade_tarih"],
                'tutar' => $alislar["girilen_tutar"],
                'doviz_tur' => $alislar["doviz_tur"],
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
WHERE status=1 AND doviz_tur='$doviz_turu' AND cari_key='$cari_key' AND cari_id='$cari_id' AND fatura_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'");
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
    $maas_tahakkuk = DB::all_data("
SELECT
pta.islem_tarihi,
pta.aciklama,
pta.tutar
FROM
personel_tahakkuk as pta
INNER JOIN personel_tahakkuk_ana as pta1 on pta1.id=pta.tahakuk_id
INNER JOIN personel_tanim as pt on pt.id=pta.personel_id
WHERE pta.status=1 AND pta.cari_key='$cari_key' AND pta1.status=1 AND pt.personel_kodu='$personel_kodu' AND pta.islem_tarihi BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59'");
    if ($maas_tahakkuk > 0) {
        foreach ($maas_tahakkuk as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["islem_tarihi"],
                'belge_no' => "",
                'belge_turu' => 'Maaş Tahakkuk',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["islem_tarihi"],
                'tutar' => $alislar["tutar"]
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
fatura_no,
vade_tarihi,
fatura_tarihi,
aciklama,
genel_toplam,
doviz_tur
FROM
satis_default
WHERE status=1 AND doviz_tur='$doviz_turu' AND cari_key='$cari_key' AND cari_id='$cari_id' AND fatura_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $faturalar) {
            $duzenle_arr3 = [
                'tarih' => $faturalar["fatura_tarihi"],
                'belge_no' => $faturalar["fatura_no"],
                'belge_turu' => 'Satış Faturası',
                'aciklama' => $faturalar["aciklama"],
                'vade_tarihi' => $faturalar["vade_tarihi"],
                'tutar' => $faturalar["genel_toplam"],
                'doviz_tur' => $faturalar["doviz_tur"],
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
WHERE hg.status=1 AND b.doviz_tipi='$doviz_turu' AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'");

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
    $kart_islemi = DB::all_data("
SELECT
tutar,
tarih,
belge_no,
aciklama
FROM kart_harcama
WHERE status=1 AND cari_key='$cari_key' and cari_id='$cari_id' AND tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'");

    if ($kart_islemi > 0) {
        foreach ($kart_islemi as $faturalar) {
            $duzenle_arr3 = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => $faturalar["belge_no"],
                'belge_turu' => 'Kredi Kartından Ödeme',
                'aciklama' => $faturalar["aciklama"],
                'vade_tarihi' => date("Y-m-d"),
                'tutar' => $faturalar["tutar"],
                'doviz_tur' => "TL",
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }

    $havale_cikis = DB::all_data("
SELECT
hg.islem_tarihi,
hgu.cikis_tutar,
hg.belge_no,
hgu.aciklama,
b.doviz_tipi
FROM havale_cikis_urunler as hgu
INNER JOIN havale_cikis AS hg on hg.id=hgu.cikis_id
INNER JOIN banka as b on b.id=hg.banka_id
WHERE hg.status=1 AND b.doviz_tipi='$doviz_turu' AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'");

    if ($havale_cikis > 0) {
        foreach ($havale_cikis as $faturalar) {
            $duzenle_arr3 = [
                'tarih' => $faturalar["islem_tarihi"],
                'belge_no' => $faturalar["belge_no"],
                'belge_turu' => 'Havale Çıkış',
                'aciklama' => $faturalar["aciklama"],
                'vade_tarihi' => date("Y-m-d"),
                'tutar' => $faturalar["cikis_tutar"],
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
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'");
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

    $kasa_odeme = DB::all_data("
SELECT
hg.islem_tarihi,
hgu.tutar,
hg.belge_no,
hgu.aciklama
FROM kasa_odeme_urunler as hgu
INNER JOIN kasa_odeme AS hg on hg.id=hgu.odeme_id
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'");

    if ($kasa_odeme > 0) {
        foreach ($kasa_odeme as $faturalar) {
            $duzenle_arr3 = [
                'tarih' => $faturalar["islem_tarihi"],
                'belge_no' => $faturalar["belge_no"],
                'belge_turu' => 'Kasa Ödeme',
                'aciklama' => $faturalar["aciklama"],
                'vade_tarihi' => date("Y-m-d"),
                'tutar' => $faturalar["tutar"],
                'doviz_tur' => "TL",
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }

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
WHERE hg.status=1 and hg.doviz_tur='$doviz_turu' and hgu.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'");

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
    $acilis_fisi = DB::all_data("
SELECT
acilis_tarihi,
borc,
alacak,
aciklama,
doviz_turu
FROM cari_acilis_fisleri
WHERE status=1 AND doviz_turu='$doviz_turu' AND cari_key='$cari_key' AND cari_id='$cari_id' AND acilis_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'");

    if ($acilis_fisi > 0) {
        foreach ($acilis_fisi as $faturalar) {
            $duzenle_arr3 = [
                'tarih' => $faturalar["acilis_tarihi"],
                'belge_no' => $faturalar["belge_no"],
                'belge_turu' => 'Açılış Fişi',
                'aciklama' => $faturalar["aciklama"],
                'vade_tarihi' => date("Y-m-d"),
                'borc' => $faturalar["borc"],
                'alacak' => $faturalar["alacak"],
                'doviz_tur' => $faturalar["doviz_turu"],
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
                    'alacak' => $alacak,
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
                    'borc' => $borc,
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
if ($islem == "cari_turleri_getir_sql") {
    $tum_cari_turlerini_cek = DB::all_data("SELECT * FROM cari_turleri_tanim WHERE status=1 AND id!=10 AND cari_key='$cari_key'");
    if ($tum_cari_turlerini_cek > 0) {
        echo json_encode($tum_cari_turlerini_cek);
    } else {
        echo 2;
    }
}
if ($islem == "cari_borc_alacak_durumu_filtrele") {

    $bas_tarih = $_GET["bas_tarih"];
    $bit_tarih = $_GET["bit_tarih"];
    $cari_turu = $_GET["cari_turu"];

    $last_bas_tarih = $bit_tarih;
    $yil_basi = $bas_tarih;
    $sql = "
SELECT 
       c.cari_kodu,
       c.cari_adi,
       c.aciklama,
       c.id,
        (select SUM(tl_tutar) from yakit_cikis_fisleri as ycf where ycf.kiralik_cari_id=c.id and ycf.status!=0 and ycf.cari_key='$cari_key') as borc10,  
       (select SUM(genel_toplam) FROM alis_default as ad WHERE ad.cari_id=c.id AND ad.status=1 AND ad.fatura_tarihi < '$last_bas_tarih 23:59:59') as alacak1,
  
       (select SUM(genel_toplam) from satis_default as sd WHERE sd.cari_id=c.id AND sd.status=1 AND sd.fatura_tarihi < '$last_bas_tarih 23:59:59') as borc1,
       (
       select 
       SUM(asu.toplam_tutar) 
from araclara_stok_cik as arac
 INNER JOIN araclara_stok_urunler as asu on asu.ana_id=arac.id 
 INNER JOIN arac_kartlari as ak on ak.id=asu.plaka_id
WHERE arac.status=1 AND asu.status=1 AND arac.cari_key='$cari_key' AND ak.cari_id=c.id AND arac.tarih < '$last_bas_tarih 23:59:59') as borc11,
       
       (select SUM(bsfu.genel_toplam) FROM binek_sanayi_fatura as bsf INNER JOIN binek_sanayi_fatura_urunler as bsfu on bsfu.fatura_id=bsf.id WHERE bsf.status=1 AND bsfu.status=1 AND bsf.cari_id=c.id AND bsf.fatura_tarih < '$last_bas_tarih 23:59:59') as alacak2,
       
       (select SUM(byc.tl_tutar) FROM binek_yakit_fatura as byf INNER JOIN binek_fis_faturasi as bff on bff.fatura_id=byf.id INNER JOIN binek_yakit_cikis as byc on byc.id=bff.yakit_fis_id WHERE byf.status=1 AND bff.status=1 AND byf.cari_id=c.id AND byf.fatura_tarihi < '$last_bas_tarih 23:59:59') as alacak3,
       
       (select SUM(lafu.toplam) from lastik_alis_fatura as laf inner join lastik_alis_fatura_urunler as lafu on  lafu.fatura_id=laf.id WHERE laf.status=1 AND lafu.status=1 AND laf.cari_id=c.id AND laf.fatura_tarihi < '$last_bas_tarih 23:59:59') as alacak4,
       
       (select SUM(ccu.girilen_tutar) from cikis_cek_urunler as ccu inner join alinan_cek_cikis as acc on acc.id=ccu.cikis_cekid WHERE ccu.status!=0 AND acc.status!=0 AND acc.cari_id=c.id AND acc.tarih < '$last_bas_tarih 23:59:59') as borc2,
       
       (select SUM(vgf.tutar) from vergi_gider as vg inner join vergi_gider_fisi as vgf on vgf.gider_id=vg.id WHERE vg.status=1 AND vgf.status=1 AND vgf.cari_id=c.id AND vgf.tarih < '$last_bas_tarih 23:59:59') as alacak5,
       
       (select SUM(ygf.tutar) from yonetim_gider as yg inner join yonetim_gider_fisi as ygf on ygf.gider_id=yg.id WHERE ygf.status=1 AND yg.status=1 AND ygf.cari_id=c.id AND ygf.tarih < '$last_bas_tarih 23:59:59') as alacak6,
       
       (select SUM(sgf.tutar) from sgk_giderleri as sg inner join sgk_gider_fisleri as sgf on sgf.gider_id=sg.id WHERE sg.status=1 AND sgf.status=1 AND sgf.cari_id=c.id AND sgf.tarih < '$last_bas_tarih 23:59:59') as alacak7,
       
       (select SUM(agf.tutar) from arac_gider as ag inner join arac_gider_fisi as agf on agf.gider_id=ag.id WHERE ag.status=1 AND agf.status=1 AND agf.cari_id=c.id AND agf.tarih < '$last_bas_tarih 23:59:59') as alacak8,
       
       (select SUM(mgu.genel_toplam) from muhasebe_gider as mg inner join muhasebe_gider_urunler as mgu on mgu.gider_id=mg.id WHERE mg.status=1 AND mgu.status=1 AND mgu.cari_id=c.id AND mg.fatura_tarihi < '$last_bas_tarih 23:59:59') as alacak9,
       
       (select SUM(sfu.genel_toplam) from sanayi_fatura as sf inner join sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id WHERE sf.status=1 AND sfu.status=1 AND sf.cari_id=c.id AND sf.fatura_tarih < '$last_bas_tarih 23:59:59') as alacak10,
       
       (select SUM(pta.tutar) from personel_tahakkuk as pta inner join personel_tanim as pt on pt.id=pta.personel_id WHERE pta.status=1 AND pt.personel_kodu=c.cari_kodu AND pta.islem_tarihi < '$last_bas_tarih 23:59:59') as alacak11,
       
       (select SUM(pc.tutar) from pos_cekim as pc WHERE pc.cari_id=c.id AND pc.status=1 AND pc.tarih < '$last_bas_tarih 23:59:59') as alacak12,
    
       (select SUM(kh.tutar) from kart_harcama as kh WHERE kh.cari_id=c.id AND kh.status=1 AND kh.tarih < '$last_bas_tarih 23:59:59') as borc3,
       
       (select SUM(acu.girilen_tutar) from alinan_cek_urunler as acu inner join alinan_cek_giris as acg on acg.id=acu.alinan_cekid WHERE acg.status!=0 AND acu.status!=0 AND acu.bizim=2 AND acg.acilis_mi!=2 AND acg.cari_id=c.id AND acg.tarih < '$last_bas_tarih 23:59:59') as alacak13,
       
       (select SUM(bcu.tutar) from bizim_cek_cikis as bcc inner join bizim_cek_urunler as bcu on bcu.bizim_cekid=bcc.id WHERE bcu.status!=0 AND bcc.status!=0 AND bcc.cari_id=c.id AND bcc.tarih < '$last_bas_tarih 23:59:59') as borc4,
       
      (select SUM(acu2.girilen_tutar) from karsiliksiz_cek_senet as kcs inner join alinan_cek_urunler as acu2 on acu2.id=kcs.alinan_cekid inner join alinan_cek_giris as acg on acg.id=acu2.alinan_cekid WHERE kcs.status=1 AND acg.status!=0 AND acg.cari_id=c.id AND kcs.insert_datetime < '$last_bas_tarih 23:59:59')as borc5,
       
       (select SUM(asu.girilen_tutar) from alinan_senet_urunler as asu inner join alinan_senet_giris as asg on asg.id=asu.alinan_senetid WHERE asu.status=1 AND asg.status!=0  AND asu.bizim=2 AND asg.cari_id=c.id AND asg.tarih < '$last_bas_tarih 23:59:59') as alacak14,
       
       (select SUM(hgu.giris_tutar) from havale_giris_urunler as hgu inner join havale_giris as hg on hg.id=hgu.giris_id WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_id=c.id AND hg.islem_tarihi < '$last_bas_tarih 23:59:59') as alacak15,
       
       (select SUM(hcu.cikis_tutar) from havale_cikis_urunler as hcu inner join havale_cikis AS hc on hc.id=hcu.cikis_id WHERE hc.status=1 AND hcu.status=1 AND hcu.cari_id=c.id AND hc.islem_tarihi < '$last_bas_tarih 23:59:59') as borc6,
       
       (select SUM(ktu.tutar) from kasa_tahsilat_urunler as ktu inner join kasa_tahsilat as kt on kt.id=ktu.tahsilat_id WHERE kt.status=1 AND ktu.status=1 AND ktu.cari_id=c.id AND kt.islem_tarihi < '$last_bas_tarih 23:59:59') as alacak16,
       
       (select SUM(kou.tutar) from kasa_odeme_urunler as kou inner join kasa_odeme as ko on ko.id=kou.odeme_id WHERE ko.status=1 AND kou.status=1 AND kou.cari_id=c.id AND ko.islem_tarihi < '$last_bas_tarih 23:59:59') as borc7,
       
       (select SUM(cmu1.borc) from cari_mahsup_urunler as cmu1 inner join cari_mahsup as cm1 on cm1.id=cmu1.mahsup_id WHERE cm1.status=1 AND cmu1.status=1 AND cmu1.cari_id=c.id AND cm1.islem_tarihi < '$last_bas_tarih 23:59:59') as borc8,
       
       (select SUM(cmu.alacak) from cari_mahsup_urunler as cmu inner join cari_mahsup as cm on cm.id=cmu.mahsup_id WHERE cm.status=1 AND cmu.status=1 AND cmu.cari_id=c.id AND cm.islem_tarihi < '$last_bas_tarih 23:59:59') as alacak17,
       
       (select SUM(caf1.borc) from cari_acilis_fisleri as caf1 WHERE caf1.cari_id=c.id AND caf1.status=1 AND caf1.acilis_tarihi < '$last_bas_tarih 23:59:59') as borc9,
       
       (select SUM(caf.alacak) from cari_acilis_fisleri as caf WHERE caf.cari_id=c.id and caf.status=1 AND caf.acilis_tarihi < '$last_bas_tarih 23:59:59') as alacak18,
       
       (select bilanco_adi from bilancolar where id=c.bilanco_id) as bilanco_kodu,
       (select cari_turu_adi from cari_turleri_tanim where id=c.cari_turu) as cari_grubu
FROM 
     cari as c
LEFT JOIN cari_turleri_tanim as ctt on ctt.id=c.cari_turu
LEFT JOIN cari_grubu_tanim as cgt on cgt.id=c.cari_grubu
WHERE 
      c.status=1 
  AND 
      c.cari_key='$cari_key'
  AND 
        ctt.gider_hesabi!=1
  AND 
        cgt.gider_hesabi!=1
";
    if ($cari_turu != "") {
        if ($cari_turu == "0") {

        } else {
            $sql .= " AND c.cari_turu='$cari_turu'";
        }
    }
    $sql .= " GROUP BY 
c.id";
    $ekstre_arr = [];
    // BURAYA KADAR OLAN KISIM DOĞRU CARİLERİ ÇEKMEK ADINA YAPILAN BİR FİLTRELEME

    $dogru_cariler = DB::all_data($sql);
    foreach ($dogru_cariler as $item) {
        $cari_id = $item["id"];
        $cari_devir_borc = 0;
        $cari_devir_alacak = 0;
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
            'cari_kodu' => $item["cari_kodu"],
            'cari_unvan' => $item["cari_adi"],
            'bilanco_kodu' => $item["bilanco_kodu"],
            'cari_grubu' => $item["cari_grubu"],
            'borc' => $cari_devir_borc,
            'alacak' => $cari_devir_alacak,
            'bakiye' => $cari_devir_bakiye,
            'b_durum' => $b_durum,
            'aciklama' => $item["aciklama"]
        ];
        array_push($ekstre_arr, $devir_arr);
    }
    if ($ekstre_arr > 0) {
        echo json_encode($ekstre_arr);
    } else {
        echo 2;
    }

}
if ($islem == "banka_hesap_ekstre_getir_sql") {
    $banka_id = $_GET["banka_id"];
    $bas_tarih = $_GET["bas_tarih"];
    $bit_tarih = $_GET["bit_tarih"];

    $banka_ekstre_arr = [];
    $banka_devir_yatan = 0;
    $banka_devir_cekilen = 0;
    $banka_devir_bakiye = 0;
    $b_durum = "";
    $ekstre_arr = [];


    $bas_tarih = new DateTime($bas_tarih);
    $bas_tarih->modify('-1 day');
    $sorgu_bas = $_GET["bas_tarih"];
    $last_bas_tarih = $bas_tarih->format('Y-m-d');

    $yil_basi = new DateTime();
    $yil_basi->modify('first day of January ' . $yil_basi->format('Y'));

    $banka_bilgileri = DB::single_query("SELECT * FROM banka WHERE status=1 AND id='$banka_id'");

    $yil_basi = $yil_basi->format('Y-m-d');

    if ($bas_tarih == "" && $bit_tarih == "") {
        $last_bas_tarih = date("Y-m-d");
    }

    $havale_giris = DB::all_data("
SELECT
giris_toplam
FROM
havale_giris
WHERE status=1 AND banka_id='$banka_id' AND cari_key='$cari_key' AND islem_tarihi < '$last_bas_tarih 23:59:59'
");
    if ($havale_giris > 0) {
        foreach ($havale_giris as $alislar) {
            $banka_devir_yatan += $alislar["giris_toplam"];
        }
    }
    $bireysel_tahakkuk = DB::all_data("
SELECT
bt.tutar,
bt.tarih,
ut.uye_adi
FROM
bireysel_tahakkuk as bt
INNER JOIN uye_tanim as ut on ut.id=bt.uye_id
WHERE bt.status=1 AND bt.banka_id='$banka_id' AND bt.tarih < '$last_bas_tarih 23:59:59'
");
    if ($bireysel_tahakkuk > 0) {
        foreach ($bireysel_tahakkuk as $alislar) {
            $banka_devir_yatan += $alislar["tutar"];
        }
    }

    $prim_odeme = DB::all_data("
SELECT
pou.prim_tutari
FROM
prim_odeme_urunler as pou
INNER JOIN prim_odeme AS po on po.id=pou.odeme_id 
WHERE pou.status=1 AND po.banka_id='$banka_id' AND pou.cari_key='$cari_key' AND po.status=1 AND po.odeme_tarihi < '$last_bas_tarih 23:59:59' 
");
    if ($prim_odeme > 0) {
        foreach ($prim_odeme as $alislar) {
            $banka_devir_cekilen += $alislar["prim_tutari"];
        }
    }

    $kredi_kullanim = DB::all_data("
SELECT * FROM kredi_kullanim WHERE status=1 AND cari_key='$cari_key' AND banka_id='$banka_id' AND kullanim_tarihi < '$last_bas_tarih 23:59:59' 
");
    if ($kredi_kullanim > 0) {
        foreach ($kredi_kullanim as $alislar) {
            $kredi_id = $alislar["id"];
            $acilislari_dus = DB::single_query("select SUM(toplam_odeme) as acilislar from kredi_kullanim_urunler WHERE status!=0 AND kredi_id='$kredi_id' AND acilis_mi=2");
            $kredi_tutari = floatval($alislar["kredi_tutari"]);
            $masraf_bedeli = floatval($alislar["kredi_kesintisi"]);
            $yansiyacak = $kredi_tutari - $masraf_bedeli - floatval($acilislari_dus["acilislar"]);

            $banka_devir_yatan += $yansiyacak;
        }
    }

    $kredi_odeme = DB::all_data("
SELECT
       kto.toplam_odeme
FROM
     kredi_taksit_odeme as kto
INNER JOIN kredi_kullanim_urunler as kku on kku.id=kto.kredi_id
INNER JOIN kredi_kullanim as kk on kk.id=kku.kredi_id
WHERE kto.status=1 AND kto.cari_key='$cari_key' AND kk.banka_id='$banka_id' AND kto.odeme_tarihi < '$last_bas_tarih 23:59:59' 
");
    if ($kredi_odeme > 0) {
        foreach ($kredi_odeme as $alislar) {
            $banka_devir_cekilen += $alislar["toplam_odeme"];
        }
    }


    $havale_cikis = DB::all_data("
SELECT
tecu.tutar
FROM
tahsil_edilen_cek_urunler as tecu
INNER JOIN tahsil_edilen_cek_senet as tecs on tecs.id=tecu.tahsil_id
WHERE tecu.status=1 AND tecu.banka_id='$banka_id' AND tecu.cari_key='$cari_key' AND tecs.tarih  < '$last_bas_tarih 23:59:59'
");
    if ($havale_cikis > 0) {
        foreach ($havale_cikis as $alislar) {
            $banka_devir_yatan += $alislar["tutar"];
        }
    }
    $perakende_satislar = DB::all_data("
SELECT
       ps.*,
       (SELECT SUM(genel_toplam) FROM perakende_satis_urunler WHERE satis_id = ps.id) AS toplam_tutar
FROM 
     perakende_satis as ps
INNER JOIN perakende_satis_urunler as psu
WHERE ps.status=1 AND psu.status=1 AND ps.cari_key='$cari_key' AND ps.banka_id='$banka_id' AND psu.status=1 AND ps.fatura_tarihi < '$last_bas_tarih 23:59:59'  GROUP BY ps.id
");
    if ($perakende_satislar > 0) {
        foreach ($perakende_satislar as $alislar) {
            $banka_devir_yatan += $alislar["toplam_tutar"];
        }
    }
    $pos_urunler = DB::all_data("
SELECT
tutar
FROM
pos_cekim_tahsiller as pct
INNER JOIN pos_tanim as pt on pct.pos_id=pt.id
INNER JOIN banka as b on pt.banka_id=b.id
WHERE pct.status=1 AND b.id='$banka_id' AND pct.cari_key='$cari_key' AND pct.islem_tarihi  < '$last_bas_tarih 23:59:59'
");
    if ($pos_urunler > 0) {
        foreach ($pos_urunler as $alislar) {
            $banka_devir_yatan += $alislar["tutar"];
        }
    }
    $havale_cikis = DB::all_data("
SELECT
tecu.tutar
FROM
cek_senet_odeme_urunler as tecu
INNER JOIN cek_senet_odeme as tecs on tecs.id=tecu.odeme_id
WHERE tecu.status=1 AND tecu.banka_id='$banka_id' AND tecu.cari_key='$cari_key' AND tecs.tarih  < '$last_bas_tarih 23:59:59'
");
    if ($havale_cikis > 0) {
        foreach ($havale_cikis as $alislar) {
            $banka_devir_cekilen += $alislar["tutar"];
        }
    }
    $havale_cikis = DB::all_data("
SELECT
tecu.tutar
FROM
tahsil_edilen_senet_urunler as tecu
INNER JOIN tahsil_edilen_senet as tecs on tecs.id=tecu.tahsilat_id
WHERE tecu.status=1 AND tecu.banka_id='$banka_id' AND tecu.cari_key='$cari_key' AND tecs.tarih  < '$last_bas_tarih 23:59:59'
");
    if ($havale_cikis > 0) {
        foreach ($havale_cikis as $alislar) {
            $banka_devir_yatan += $alislar["tutar"];
        }
    }

    $binek_yakit_alim = DB::all_data("
SELECT
       byc.*,
       bk.arac_plaka
FROM
     binek_yakit_cikis as byc
INNER JOIN binek_kartlari as bk on bk.id=byc.plaka_id
WHERE
      byc.status!=0 AND byc.cari_key='$cari_key' AND byc.banka_id='$banka_id' AND byc.tarih  < '$last_bas_tarih 23:59:59'");
    if ($binek_yakit_alim > 0) {
        foreach ($binek_yakit_alim as $alislar) {
            $banka_devir_cekilen += $alislar["tl_tutar"];
        }
    }

    $arac_gider = DB::all_data("
SELECT
agf.tutar,
agf.aciklama,
agf.tarih
FROM
arac_gider_fisi as agf
INNER JOIN arac_gider as ag on ag.id=agf.gider_id
WHERE agf.status=1 AND ag.status=1 AND agf.banka_id='$banka_id' AND agf.cari_key='$cari_key' AND agf.tarih < '$last_bas_tarih 23:59:59'
");
    if ($arac_gider > 0) {
        foreach ($arac_gider as $alislar) {
            $banka_devir_cekilen += $alislar["tutar"];
        }
    }
    $sgk_gider_fisleri = DB::all_data("
    SELECT
sgf.tutar,
sgf.tarih,
sgf.aciklama
FROM
sgk_gider_fisleri as sgf
INNER JOIN sgk_giderleri as sg on sg.id=sgf.gider_id
WHERE sgf.status=1 AND sg.status=1 AND sgf.banka_id='$banka_id' AND sgf.cari_key='$cari_key' AND sgf.tarih  < '$last_bas_tarih 23:59:59'
");
    if ($sgk_gider_fisleri > 0) {
        foreach ($sgk_gider_fisleri as $alislar) {
            $banka_devir_cekilen += $alislar["tutar"];
        }
    }

    $vergi_gider = DB::all_data("
SELECT
vgf.tutar,
vgf.tarih,
vgf.aciklama
FROM
vergi_gider_fisi as vgf
INNER JOIN vergi_gider as vg on vg.id=vgf.gider_id
WHERE vgf.status=1 AND vg.status=1 AND vgf.banka_id='$banka_id' AND vgf.cari_key='$cari_key' AND vgf.tarih  < '$last_bas_tarih 23:59:59'
");
    if ($vergi_gider > 0) {
        foreach ($vergi_gider as $alislar) {
            $banka_devir_cekilen += $alislar["tutar"];
        }
    }
    $vergi_gider = DB::all_data("
SELECT
vgf.tutar,
vg.tarih,
vgf.aciklama
FROM
binek_vergi_gider_fisleri as vgf
INNER JOIN binek_vergi_gider as vg on vg.id=vgf.gider_id
WHERE vgf.status=1 AND vg.status=1 AND vgf.banka_id='$banka_id' AND vgf.cari_key='$cari_key' AND vg.tarih  < '$last_bas_tarih 23:59:59'
");
    if ($vergi_gider > 0) {
        foreach ($vergi_gider as $alislar) {
            $banka_devir_cekilen += $alislar["tutar"];
        }
    }

    $vergi_gider = DB::all_data("
    SELECT
ygf.tutar,
ygf.tarih,
ygf.aciklama
FROM
yonetim_gider_fisi as ygf
INNER JOIN yonetim_gider as yg on yg.id=ygf.gider_id
WHERE ygf.status=1 AND yg.status=1 AND ygf.banka_id='$banka_id' AND ygf.cari_key='$cari_key' AND ygf.tarih < '$last_bas_tarih 23:59:59'
");
    if ($vergi_gider > 0) {
        foreach ($vergi_gider as $alislar) {
            $banka_devir_cekilen += $alislar["tutar"];
        }
    }
    $hgs_gider = DB::all_data("
SELECT
hgf.tutar,
hgf.aciklama,
hg.tarih
FROM
hgs_gider_fisleri as hgf
INNER JOIN hgs_gider as hg on hg.id=hgf.gider_id
WHERE hgf.status=1 AND hg.status=1 AND hgf.banka_id='$banka_id' AND hgf.cari_key='$cari_key' AND hg.tarih < '$last_bas_tarih 23:59:59'
");
    if ($hgs_gider > 0) {
        foreach ($hgs_gider as $alislar) {
            $banka_devir_cekilen += $alislar["tutar"];
        }
    }
    $hgs_gider = DB::all_data("
SELECT
hgf.tutar,
hgf.aciklama,
hg.tarih
FROM
binek_hgs_gider_fisleri as hgf
INNER JOIN binek_hgs_gider as hg on hg.id=hgf.gider_id
WHERE hgf.status=1 AND hg.status=1 AND hgf.banka_id='$banka_id' AND hgf.cari_key='$cari_key' AND hg.tarih < '$last_bas_tarih 23:59:59'
");
    if ($hgs_gider > 0) {
        foreach ($hgs_gider as $alislar) {
            $banka_devir_cekilen += $alislar["tutar"];
        }
    }
    $kaza_ceza = DB::all_data("
SELECT
hgf.tutar,
hgf.aciklama,
hg.tarih
FROM
kaza_ceza_gider_fisleri as hgf
INNER JOIN kaza_ceza_gider as hg on hg.id=hgf.gider_id
WHERE hgf.status=1 AND hg.status=1 AND hgf.banka_id='$banka_id' AND hgf.cari_key='$cari_key' AND hg.tarih < '$last_bas_tarih 23:59:59'
");
    if ($kaza_ceza > 0) {
        foreach ($kaza_ceza as $alislar) {
            $banka_devir_cekilen += $alislar["tutar"];
        }
    }
    $havale_cikis = DB::all_data("
SELECT
tecu.tutar
FROM
senet_odeme_urunler as tecu
INNER JOIN senet_odeme as tecs on tecs.id=tecu.odeme_id
WHERE tecu.status=1 AND tecu.banka_id='$banka_id' AND tecu.cari_key='$cari_key' AND tecs.tarih  < '$last_bas_tarih 23:59:59'
");
    if ($havale_cikis > 0) {
        foreach ($havale_cikis as $alislar) {
            $banka_devir_cekilen += $alislar["tutar"];
        }
    }

    $havale_cikis = DB::all_data("
SELECT
cikis_toplam
FROM
havale_cikis
WHERE status=1 AND banka_id='$banka_id' AND cari_key='$cari_key' AND islem_tarihi  < '$last_bas_tarih 23:59:59'
");
    if ($havale_cikis > 0) {
        foreach ($havale_cikis as $alislar) {
            $banka_devir_cekilen += $alislar["cikis_toplam"];
        }
    }

    $bankaya_yatan = DB::all_data("
SELECT
gonderilen_tutar
FROM
kasadan_bankaya
WHERE status=1 AND banka_id='$banka_id' AND cari_key='$cari_key' AND tarih  < '$last_bas_tarih 23:59:59'
");

    if ($bankaya_yatan > 0) {
        foreach ($bankaya_yatan as $alislar) {
            $banka_devir_yatan += $alislar["gonderilen_tutar"];
        }
    }

    $bankadan_cekilen = DB::all_data("
SELECT
gonderilen_tutar
FROM
bankadan_kasaya
WHERE status=1 AND banka_id='$banka_id' AND cari_key='$cari_key' AND tarih < '$last_bas_tarih 23:59:59'
");

    if ($bankadan_cekilen > 0) {
        foreach ($bankadan_cekilen as $alislar) {
            $banka_devir_cekilen += $alislar["gonderilen_tutar"];
        }
    }

    $banka_virman = DB::all_data("
SELECT
gonderilen_miktar
FROM
banka_virman
WHERE status=1 AND gonderen_bankaid='$banka_id' AND cari_key='$cari_key' AND virman_tarihi  < '$last_bas_tarih 23:59:59'
");

    if ($banka_virman > 0) {
        foreach ($banka_virman as $alislar) {
            $banka_devir_cekilen += $alislar["gonderilen_miktar"];
        }
    }

    $banka_virman = DB::all_data("
SELECT
gonderilen_miktar
FROM
banka_virman
WHERE status=1 AND alici_bankaid='$banka_id' AND cari_key='$cari_key' AND virman_tarihi < '$last_bas_tarih 23:59:59'
");

    if ($banka_virman > 0) {
        foreach ($banka_virman as $alislar) {
            $banka_devir_yatan += $alislar["gonderilen_miktar"];
        }
    }
    $acilis_fisleri = DB::all_data("
SELECT
yatan_tutar,
cekilen_tutar
FROM
banka_acilis_fisi
WHERE status=1 AND banka_id='$banka_id' AND cari_key='$cari_key' AND acilis_tarih < '$last_bas_tarih 23:59:59'
");

    if ($acilis_fisleri > 0) {
        foreach ($acilis_fisleri as $alislar) {
            $banka_devir_yatan += $alislar["yatan_tutar"];
            $banka_devir_cekilen += $alislar["cekilen_tutar"];
        }
    }

    $kart_odeme = DB::all_data("
SELECT
tutar
FROM
kredi_kart_odeme
WHERE status=1 AND banka_id='$banka_id' AND cari_key='$cari_key' AND islem_tarihi < '$last_bas_tarih 23:59:59'
");

    if ($kart_odeme > 0) {
        foreach ($kart_odeme as $alislar) {
            $banka_devir_cekilen += $alislar["tutar"];
        }
    }


    $cari_devir_bakiye = floatval($banka_devir_yatan) - floatval($banka_devir_cekilen);
    if ($cari_devir_bakiye < 0) {
        $cari_devir_bakiye = -$cari_devir_bakiye;
        $b_durum = "B";
    } else {
        $b_durum = "A";
    }
    $devir_arr = [
        'tarih' => $sorgu_bas,
        'belge_no' => "......",
        'belge_turu' => "Devir",
        'banka_kodu' => "......",
        'banka_adi' => "......",
        'sube_adi' => "......",
        'yatan' => $banka_devir_yatan,
        'cekilen' => $banka_devir_cekilen,
        'bakiye' => $cari_devir_bakiye,
        'b_durum' => $b_durum,
        'aciklama' => "Bir Önceki Tarihten Devir...."
    ];
    array_push($ekstre_arr, $devir_arr);
    $havale_cikis = DB::all_data("
SELECT
hc.belge_no,
hc.islem_tarihi,
hcu.aciklama,
hcu.cikis_tutar,
c.cari_adi
FROM havale_cikis as hc
INNER JOIN havale_cikis_urunler as hcu on hc.id=hcu.cikis_id
LEFT JOIN cari as c on c.id=hcu.cari_id
WHERE hc.status=1 AND hcu.status=1 AND hc.banka_id='$banka_id' AND hc.cari_key='$cari_key' AND hc.islem_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");
    if ($havale_cikis > 0) {
        foreach ($havale_cikis as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["islem_tarihi"],
                'belge_no' => $faturalar["belge_no"],
                'belge_turu' => 'Havale Çıkış',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => 0,
                'aciklama' => $faturalar["aciklama"] . " " . $faturalar["cari_adi"],
                'cekilen' => $faturalar["cikis_tutar"]
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $bireysel_tahakkuk = DB::all_data("
SELECT
bt.tutar,
bt.tarih,
ut.uye_adi
FROM
bireysel_tahakkuk as bt
INNER JOIN uye_tanim as ut on ut.id=bt.uye_id
WHERE bt.status=1 AND bt.banka_id='$banka_id'  AND bt.tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");
    if ($bireysel_tahakkuk > 0) {
        foreach ($bireysel_tahakkuk as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => $faturalar["uye_adi"],
                'belge_turu' => 'BİREYSEL TAHAKKUK',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => $faturalar["tutar"],
                'aciklama' => $faturalar["aciklama"],
                'cekilen' => 0
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $vergi_gider = DB::all_data("
SELECT
vgf.tutar,
vg.tarih,
vgf.aciklama,
bk.arac_plaka
FROM
binek_vergi_gider_fisleri as vgf
INNER JOIN binek_vergi_gider as vg on vg.id=vgf.gider_id
INNER JOIN binek_kartlari as bk on bk.id=vgf.plaka_id
WHERE vgf.status=1 AND vg.status=1 AND vgf.banka_id='$banka_id' AND vgf.cari_key='$cari_key' AND vg.tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");
    if ($vergi_gider > 0) {
        foreach ($vergi_gider as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => $faturalar["arac_plaka"],
                'belge_turu' => 'BİNEK VERGİ GİDER',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => 0,
                'aciklama' => $faturalar["aciklama"],
                'cekilen' => $faturalar["tutar"]
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $binek_yakit_alim = DB::all_data("
SELECT
       byc.*,
       bk.arac_plaka
FROM
     binek_yakit_cikis as byc
INNER JOIN binek_kartlari as bk on bk.id=byc.plaka_id
WHERE
      byc.status!=0 AND byc.cari_key='$cari_key' AND byc.banka_id='$banka_id' AND byc.tarih  BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' ");
    if ($binek_yakit_alim > 0) {
        foreach ($binek_yakit_alim as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => $faturalar["fis_no"],
                'belge_turu' => 'BİNEK YAKIT ALIM',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => 0,
                'aciklama' => $faturalar["arac_plaka"],
                'cekilen' => $faturalar["tl_tutar"]
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $kredi_kullanim = DB::all_data("
SELECT
       *
FROM
     kredi_kullanim
WHERE
      status=1 AND cari_key='$cari_key' AND banka_id='$banka_id' AND kullanim_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");

    if ($kredi_kullanim > 0) {
        foreach ($kredi_kullanim as $faturalar) {

            $kredi_tutari = floatval($faturalar["kredi_tutari"]);
            $kesinti_tutari = floatval($faturalar["kredi_kesintisi"]);
            $kredi_id = $faturalar["id"];
            $acilislari_dus = DB::single_query("select SUM(toplam_odeme) as acilislar from kredi_kullanim_urunler WHERE status!=0 AND kredi_id='$kredi_id' AND acilis_mi=2");
            $yatan_miktar = $kredi_tutari - $kesinti_tutari;
            $yatan_miktar = $yatan_miktar - floatval($acilislari_dus["acilislar"]);

            $banka_duzenle_arr = [
                'tarih' => $faturalar["kullanim_tarihi"],
                'belge_no' => $faturalar["belge_no"],
                'belge_turu' => 'KREDİ KULLANIMI',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => $yatan_miktar,
                'aciklama' => $faturalar["aciklama"],
                'cekilen' => 0
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $kredi_odeme = DB::all_data("
SELECT
       kto.toplam_odeme,
       kto.odeme_tarihi,
       kto.aciklama
FROM
     kredi_taksit_odeme as kto
INNER JOIN kredi_kullanim_urunler as kku on kku.id=kto.kredi_id
INNER JOIN kredi_kullanim as kk on kk.id=kku.kredi_id
WHERE kto.status=1 AND kto.cari_key='$cari_key' AND kk.banka_id='$banka_id' AND kto.odeme_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");

    if ($kredi_odeme > 0) {
        foreach ($kredi_odeme as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["odeme_tarihi"],
                'belge_no' => "",
                'belge_turu' => 'KREDİ TAKSİT ÖDEME',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => 0,
                'aciklama' => $faturalar["aciklama"],
                'cekilen' => $faturalar["toplam_odeme"]
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }

    $kart_odeme = DB::all_data("
SELECT
tutar,
islem_tarihi,
aciklama
FROM
kredi_kart_odeme
WHERE status=1 AND banka_id='$banka_id' AND cari_key='$cari_key' AND islem_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");

    if ($kart_odeme > 0) {
        foreach ($kart_odeme as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["islem_tarihi"],
                'belge_no' => "",
                'belge_turu' => 'KREDİ KART ÖDEMESİ',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => 0,
                'aciklama' => $faturalar["aciklama"],
                'cekilen' => $faturalar["tutar"]
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $arac_gider = DB::all_data("
SELECT
agf.tutar,
agf.aciklama,
agf.tarih
FROM
arac_gider_fisi as agf
INNER JOIN arac_gider as ag on ag.id=agf.gider_id
WHERE agf.status=1 AND ag.status=1 AND agf.banka_id='$banka_id' AND agf.cari_key='$cari_key' AND agf.tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");
    if ($arac_gider > 0) {
        foreach ($arac_gider as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => "",
                'belge_turu' => 'Araç Gider',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => 0,
                'aciklama' => $faturalar["aciklama"],
                'cekilen' => $faturalar["tutar"]
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $sgk_gider_fisleri = DB::all_data("
SELECT
sgf.tutar,
sgf.tarih,
sgf.aciklama
FROM
sgk_gider_fisleri as sgf
INNER JOIN sgk_giderleri as sg on sg.id=sgf.gider_id
WHERE sgf.status=1 AND sg.status=1 AND sgf.banka_id='$banka_id' AND sgf.cari_key='$cari_key' AND sgf.tarih  BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");
    if ($sgk_gider_fisleri > 0) {
        foreach ($sgk_gider_fisleri as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => "",
                'belge_turu' => 'SGK GİDER FİŞLERİ',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => 0,
                'aciklama' => $faturalar["aciklama"],
                'cekilen' => $faturalar["tutar"]
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $vergi_gider = DB::all_data("
SELECT
ygf.tutar,
ygf.tarih,
ygf.aciklama
FROM
yonetim_gider_fisi as ygf
INNER JOIN yonetim_gider as yg on yg.id=ygf.gider_id
WHERE ygf.status=1 AND yg.status=1 AND ygf.banka_id='$banka_id' AND ygf.cari_key='$cari_key' AND ygf.tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");
    if ($vergi_gider > 0) {
        foreach ($vergi_gider as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => "",
                'belge_turu' => 'Yönetim Giderleri',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => 0,
                'aciklama' => $faturalar["aciklama"],
                'cekilen' => $faturalar["tutar"]
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $sgk_gider_fisleri = DB::all_data("
SELECT
vgf.tutar,
vgf.tarih,
vgf.aciklama
FROM
vergi_gider_fisi as vgf
INNER JOIN vergi_gider as vg on vg.id=vgf.gider_id
WHERE vgf.status=1 AND vg.status=1 AND vgf.banka_id='$banka_id' AND vgf.cari_key='$cari_key' AND vgf.tarih  BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");
    if ($sgk_gider_fisleri > 0) {
        foreach ($sgk_gider_fisleri as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => "",
                'belge_turu' => 'Vergi Gider',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => 0,
                'aciklama' => $faturalar["aciklama"],
                'cekilen' => $faturalar["tutar"]
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $hgs_gider = DB::all_data("
SELECT
hgf.tutar,
hgf.aciklama,
hg.tarih
FROM
hgs_gider_fisleri as hgf
INNER JOIN hgs_gider as hg on hg.id=hgf.gider_id
WHERE hgf.status=1 AND hg.status=1 AND hgf.banka_id='$banka_id' AND hgf.cari_key='$cari_key' AND hg.tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");
    if ($hgs_gider > 0) {
        foreach ($hgs_gider as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => "",
                'belge_turu' => 'HGS Gider',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => 0,
                'aciklama' => $faturalar["aciklama"],
                'cekilen' => $faturalar["tutar"]
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $hgs_gider = DB::all_data("
SELECT
hgf.tutar,
hgf.aciklama,
hg.tarih,
bk.arac_plaka
FROM
binek_hgs_gider_fisleri as hgf
INNER JOIN binek_hgs_gider as hg on hg.id=hgf.gider_id
INNER JOIN binek_kartlari as bk on bk.id=hgf.plaka_id
WHERE hgf.status=1 AND hg.status=1 AND hgf.banka_id='$banka_id' AND hgf.cari_key='$cari_key' AND hg.tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");
    if ($hgs_gider > 0) {
        foreach ($hgs_gider as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => $faturalar["arac_plaka"],
                'belge_turu' => 'Binek HGS Gider',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => 0,
                'aciklama' => $faturalar["aciklama"],
                'cekilen' => $faturalar["tutar"]
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $kaza_ceza = DB::all_data("
SELECT
hgf.tutar,
hgf.aciklama,
hg.tarih
FROM
kaza_ceza_gider_fisleri as hgf
INNER JOIN kaza_ceza_gider as hg on hg.id=hgf.gider_id
WHERE hgf.status=1 AND hg.status=1 AND hgf.banka_id='$banka_id' AND hgf.cari_key='$cari_key' AND hg.tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");
    if ($kaza_ceza > 0) {
        foreach ($kaza_ceza as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => "",
                'belge_turu' => 'Kaza Ceza Gider',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => 0,
                'aciklama' => $faturalar["aciklama"],
                'cekilen' => $faturalar["tutar"]
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $prim_odeme = DB::all_data("
SELECT
SUM(pou.prim_tutari) as prim_tutari,
po.odeme_tarihi,
po.aciklama,
pt.ad_soyad
FROM
prim_odeme_urunler as pou
INNER JOIN prim_odeme AS po on po.id=pou.odeme_id
INNER JOIN personel_tanim as pt on po.sofor_id=pt.id
WHERE pou.status=1 AND po.banka_id='$banka_id' AND pou.cari_key='$cari_key' AND po.status=1 AND po.odeme_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'  GROUP BY po.sofor_id ,po.odeme_tarihi
");
    if ($prim_odeme > 0) {
        foreach ($prim_odeme as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["odeme_tarihi"],
                'belge_no' => $faturalar["ad_soyad"],
                'belge_turu' => 'Prim Ödeme',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => 0,
                'aciklama' => $faturalar["aciklama"],
                'cekilen' => $faturalar["prim_tutari"]
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }

    $havale_cikis = DB::all_data("
SELECT
    tecu.tutar,
    tecs.tarih,
    tecu.seri_no,
    tecs.aciklama,
    tecu.vade_tarih
    FROM
    tahsil_edilen_cek_urunler as tecu
    INNER JOIN tahsil_edilen_cek_senet as tecs on tecs.id=tecu.tahsil_id
    WHERE tecu.status=1 AND tecu.banka_id='$banka_id' AND tecu.cari_key='$cari_key' AND tecs.tarih  BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($havale_cikis > 0) {
        foreach ($havale_cikis as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => $faturalar["belge_no"],
                'belge_turu' => 'Çek Tahsili',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => $faturalar["tutar"],
                'aciklama' => $faturalar["vade_tarih"] . " VADE TARİHLİ " . $faturalar["seri_no"] . " Numaralı Çek Tahsili",
                'cekilen' => 0
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $perakende_satislar = DB::all_data("
SELECT
       ps.*,
       (SELECT SUM(genel_toplam) FROM perakende_satis_urunler WHERE satis_id = ps.id) AS toplam_tutar
FROM 
     perakende_satis as ps
INNER JOIN perakende_satis_urunler as psu
WHERE ps.status=1 AND psu.status=1 AND ps.cari_key='$cari_key' AND ps.banka_id='$banka_id' AND psu.status=1 AND ps.fatura_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'  GROUP BY ps.id
");
    if ($perakende_satislar > 0) {
        foreach ($perakende_satislar as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["fatura_tarihi"],
                'belge_no' => "",
                'belge_turu' => 'Perakende Satış',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => $faturalar["toplam_tutar"],
                'aciklama' => $faturalar["aciklama"],
                'cekilen' => 0
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $pos_urunler = DB::all_data("
SELECT
pct.tutar,
pct.islem_tarihi,
pct.aciklama
FROM
pos_cekim_tahsiller as pct
INNER JOIN pos_tanim as pt on pct.pos_id=pt.id
INNER JOIN banka as b on pt.banka_id=b.id
WHERE pct.status=1 AND b.id='$banka_id' AND pct.cari_key='$cari_key' AND pct.islem_tarihi  BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($pos_urunler > 0) {
        foreach ($pos_urunler as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["islem_tarihi"],
                'belge_no' => "",
                'belge_turu' => 'POS TAHSİLATI',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => $faturalar["tutar"],
                'aciklama' => $faturalar["aciklama"],
                'cekilen' => 0
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }

    $havale_cikis = DB::all_data("
SELECT
    tecu.tutar,
    tecs.tarih,
    tecu.seri_no,
    tecs.aciklama
    FROM
    tahsil_edilen_senet_urunler as tecu
    INNER JOIN tahsil_edilen_senet as tecs on tecs.id=tecu.tahsilat_id
    WHERE tecu.status=1 AND tecu.banka_id='$banka_id' AND tecu.cari_key='$cari_key' AND tecs.tarih  BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($havale_cikis > 0) {
        foreach ($havale_cikis as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => $faturalar["belge_no"],
                'belge_turu' => 'Senet Tahsili',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => $faturalar["tutar"],
                'aciklama' => $faturalar["aciklama"],
                'cekilen' => 0
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $havale_cikis = DB::all_data("
SELECT
    tecu.tutar,
    tecs.tarih,
    tecu.seri_no,
    tecs.aciklama
    FROM
    senet_odeme_urunler as tecu
    INNER JOIN senet_odeme as tecs on tecs.id=tecu.odeme_id
    WHERE tecu.status=1 AND tecu.banka_id='$banka_id' AND tecu.cari_key='$cari_key' AND tecs.tarih  BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($havale_cikis > 0) {
        foreach ($havale_cikis as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => $faturalar["belge_no"],
                'belge_turu' => 'Senet Ödeme',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => 0,
                'aciklama' => $faturalar["aciklama"],
                'cekilen' => $faturalar["tutar"]
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $havale_cikis = DB::all_data("
SELECT
    tecu.tutar,
    tecs.tarih,
    tecu.seri_no,
    tecs.aciklama,
    tecu.vade_tarih,
    tecu.seri_no
    FROM
    cek_senet_odeme_urunler as tecu
    INNER JOIN cek_senet_odeme as tecs on tecs.id=tecu.odeme_id
    WHERE tecu.status=1 AND tecu.banka_id='$banka_id' AND tecu.cari_key='$cari_key' AND tecs.tarih  BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($havale_cikis > 0) {
        foreach ($havale_cikis as $faturalar) {
            $vade_tarih = date("d/m/Y", strtotime($faturalar["vade_tarih"]));
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => $faturalar["belge_no"],
                'belge_turu' => 'Çek Ödeme',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => 0,
                'aciklama' => $vade_tarih . " VADE TARİHLİ " . $faturalar["seri_no"] . " Numaralı Çek Ödemesi",
                'cekilen' => $faturalar["tutar"]
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $havale_giris = DB::all_data("
SELECT
hg.belge_no,
hg.islem_tarihi,
hgu.aciklama,
hgu.giris_tutar,
c.cari_adi
FROM havale_giris as hg
INNER JOIN havale_giris_urunler as hgu on hgu.giris_id=hg.id
LEFT JOIN cari as c on c.id=hgu.cari_id
WHERE hg.status=1 AND hgu.status=1 AND hg.banka_id='$banka_id' AND hg.cari_key='$cari_key' AND hg.islem_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");

    if ($havale_giris > 0) {
        foreach ($havale_giris as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["islem_tarihi"],
                'belge_no' => $faturalar["belge_no"],
                'belge_turu' => 'Havale Giriş',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'aciklama' => $faturalar["aciklama"] . " " . $faturalar["cari_adi"],
                'yatan' => $faturalar["giris_tutar"],
                'cekilen' => 0
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $banka_virman = DB::all_data("
SELECT
virman_tarihi,
aciklama,
gonderilen_miktar
FROM banka_virman
WHERE status=1 AND gonderen_bankaid='$banka_id' AND cari_key='$cari_key' AND virman_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");
    if ($banka_virman > 0) {
        foreach ($banka_virman as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["virman_tarihi"],
                'belge_no' => "",
                'belge_turu' => 'Banka Virman Çıkış',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'aciklama' => $faturalar["aciklama"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => 0,
                'cekilen' => $faturalar["gonderilen_miktar"]
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $banka_virman2 = DB::all_data("
SELECT
virman_tarihi,
aciklama,
gonderilen_miktar
FROM banka_virman
WHERE status=1 AND alici_bankaid='$banka_id' AND cari_key='$cari_key' AND virman_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");
    if ($banka_virman2 > 0) {
        foreach ($banka_virman2 as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["virman_tarihi"],
                'belge_no' => "",
                'belge_turu' => 'Banka Virman Giriş',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'aciklama' => $faturalar["aciklama"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => $faturalar["gonderilen_miktar"],
                'cekilen' => 0
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $bankaya_yatan = DB::all_data("
SELECT
insert_datetime,
aciklama,
gonderilen_tutar,
tarih
FROM kasadan_bankaya
WHERE status=1 AND banka_id='$banka_id' AND cari_key='$cari_key' AND tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");
    if ($bankaya_yatan > 0) {
        foreach ($bankaya_yatan as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => "",
                'belge_turu' => 'Kasadan Bankaya Aktarım',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'aciklama' => $faturalar["aciklama"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => $faturalar["gonderilen_tutar"],
                'cekilen' => 0
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $bankadan_cekilen = DB::all_data("
SELECT
insert_datetime,
aciklama,
gonderilen_tutar,
tarih
FROM bankadan_kasaya
WHERE status=1 AND banka_id='$banka_id' AND cari_key='$cari_key' AND tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");
    if ($bankadan_cekilen > 0) {
        foreach ($bankadan_cekilen as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => "",
                'belge_turu' => 'Bankadan Kasaya Aktarım',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'aciklama' => $faturalar["aciklama"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => 0,
                'cekilen' => $faturalar["gonderilen_tutar"]
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $banka_acilis_yatan = DB::all_data("
SELECT
acilis_tarih,
aciklama,
yatan_tutar
FROM banka_acilis_fisi
WHERE status=1 AND banka_id='$banka_id' AND cari_key='$cari_key' AND acilis_tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");
    if ($banka_acilis_yatan > 0) {
        foreach ($banka_acilis_yatan as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["acilis_tarih"],
                'belge_no' => "",
                'belge_turu' => 'Banka Açılış Giriş',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'aciklama' => $faturalar["aciklama"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => $faturalar["yatan_tutar"],
                'cekilen' => 0
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    $banka_acilis_cekilen = DB::all_data("
SELECT
acilis_tarih,
aciklama,
cekilen_tutar
FROM banka_acilis_fisi
WHERE status=1 AND banka_id='$banka_id' AND cari_key='$cari_key' AND insert_datetime BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");
    if ($banka_acilis_yatan > 0) {
        foreach ($banka_acilis_yatan as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["acilis_tarih"],
                'belge_no' => "",
                'belge_turu' => 'Banka Açılış Çıkış',
                'banka_kodu' => $banka_bilgileri["banka_kodu"],
                'aciklama' => $faturalar["aciklama"],
                'banka_adi' => $banka_bilgileri["banka_adi"],
                'sube_adi' => $banka_bilgileri["sube_adi"],
                'yatan' => 0,
                'cekilen' => $faturalar["cekilen_tutar"]
            ];
            array_push($banka_ekstre_arr, $banka_duzenle_arr);
        }
    }
    usort($banka_ekstre_arr, function ($a, $b) {
        $tarihA = strtotime($a['tarih']); // $a dizisindeki tarih değerini alıp zaman damgasına dönüştür
        $tarihB = strtotime($b['tarih']);
        if ($tarihA == $tarihB) {
            return 0;
        }

        return ($tarihA < $tarihB) ? -1 : 1;
    });

    $gidecek_arr = [];
    array_push($gidecek_arr, $ekstre_arr[0]);
    foreach ($banka_ekstre_arr as $item) {
        if ($item["belge_turu"] == "Banka Virman Giriş") {

            if ($b_durum == "A") {
                $cari_devir_bakiye += $item["yatan"];
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $item["yatan"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["yatan"];
                $b_durum = "A";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => $item["yatan"],
                'aciklama' => $item["aciklama"],
                'cekilen' => 0,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);

        } else if ($item["belge_turu"] == "Banka Virman Çıkış") {

            if ($b_durum == "B") {
                $cari_devir_bakiye += $item["cekilen"];
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $item["cekilen"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["cekilen"];
                $b_durum = "B";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'aciklama' => $item["aciklama"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => 0,
                'cekilen' => $item["cekilen"],
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);
        } else if ($item["belge_turu"] == "Senet Ödeme") {

            if ($b_durum == "B") {
                $cari_devir_bakiye += $item["cekilen"];
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $item["cekilen"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["cekilen"];
                $b_durum = "B";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'aciklama' => $item["aciklama"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => 0,
                'cekilen' => $item["cekilen"],
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);
        } else if ($item["belge_turu"] == "Çek Ödeme") {

            if ($b_durum == "B") {
                $cari_devir_bakiye += $item["cekilen"];
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $item["cekilen"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["cekilen"];
                $b_durum = "B";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'aciklama' => $item["aciklama"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => 0,
                'cekilen' => $item["cekilen"],
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);
        } else if ($item["belge_turu"] == "Havale Giriş") {

            if ($b_durum == "A") {
                $cari_devir_bakiye += $item["yatan"];
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $item["yatan"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["yatan"];
                $b_durum = "A";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => $item["yatan"],
                'aciklama' => $item["aciklama"],
                'cekilen' => 0,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);

        } else if ($item["belge_turu"] == "POS TAHSİLATI") {

            if ($b_durum == "A") {
                $cari_devir_bakiye += $item["yatan"];
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $item["yatan"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["yatan"];
                $b_durum = "A";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => $item["yatan"],
                'aciklama' => $item["aciklama"],
                'cekilen' => 0,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);

        } else if ($item["belge_turu"] == "Çek Tahsili") {

            if ($b_durum == "A") {
                $cari_devir_bakiye += $item["yatan"];
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $item["yatan"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["yatan"];
                $b_durum = "A";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => $item["yatan"],
                'aciklama' => $item["aciklama"],
                'cekilen' => 0,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);

        } else if ($item["belge_turu"] == "KREDİ KULLANIMI") {

            if ($b_durum == "A") {
                $cari_devir_bakiye += $item["yatan"];
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $item["yatan"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["yatan"];
                $b_durum = "A";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => $item["yatan"],
                'aciklama' => $item["aciklama"],
                'cekilen' => 0,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);

        } else if ($item["belge_turu"] == "BİREYSEL TAHAKKUK") {

            if ($b_durum == "A") {
                $cari_devir_bakiye += $item["yatan"];
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $item["yatan"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["yatan"];
                $b_durum = "A";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => $item["yatan"],
                'aciklama' => $item["aciklama"],
                'cekilen' => 0,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);

        } else if ($item["belge_turu"] == "Perakende Satış") {

            if ($b_durum == "A") {
                $cari_devir_bakiye += $item["yatan"];
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $item["yatan"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["yatan"];
                $b_durum = "A";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => $item["yatan"],
                'aciklama' => $item["aciklama"],
                'cekilen' => 0,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);

        } else if ($item["belge_turu"] == "Senet Tahsili") {

            if ($b_durum == "A") {
                $cari_devir_bakiye += $item["yatan"];
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $item["yatan"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["yatan"];
                $b_durum = "A";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => $item["yatan"],
                'aciklama' => $item["aciklama"],
                'cekilen' => 0,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);

        } else if ($item["belge_turu"] == "Havale Çıkış") {
            if ($b_durum == "B") {
                $cari_devir_bakiye += $item["cekilen"];
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $item["cekilen"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["cekilen"];
                $b_durum = "B";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => 0,
                'cekilen' => $item["cekilen"],
                'bakiye' => $cari_devir_bakiye,
                'aciklama' => $item["aciklama"],
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);
        } else if ($item["belge_turu"] == "BİNEK VERGİ GİDER") {
            if ($b_durum == "B") {
                $cari_devir_bakiye += $item["cekilen"];
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $item["cekilen"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["cekilen"];
                $b_durum = "B";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => 0,
                'cekilen' => $item["cekilen"],
                'bakiye' => $cari_devir_bakiye,
                'aciklama' => $item["aciklama"],
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);
        } else if ($item["belge_turu"] == "BİNEK YAKIT ALIM") {
            if ($b_durum == "B") {
                $cari_devir_bakiye += $item["cekilen"];
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $item["cekilen"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["cekilen"];
                $b_durum = "B";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => 0,
                'cekilen' => $item["cekilen"],
                'bakiye' => $cari_devir_bakiye,
                'aciklama' => $item["aciklama"],
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);
        } else if ($item["belge_turu"] == "Prim Ödeme") {
            if ($b_durum == "B") {
                $cari_devir_bakiye += $item["cekilen"];
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $item["cekilen"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["cekilen"];
                $b_durum = "B";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => 0,
                'cekilen' => $item["cekilen"],
                'bakiye' => $cari_devir_bakiye,
                'aciklama' => $item["aciklama"],
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);
        } else if ($item["belge_turu"] == "Araç Gider") {
            if ($b_durum == "B") {
                $cari_devir_bakiye += $item["cekilen"];
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $item["cekilen"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["cekilen"];
                $b_durum = "B";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => 0,
                'cekilen' => $item["cekilen"],
                'bakiye' => $cari_devir_bakiye,
                'aciklama' => $item["aciklama"],
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);
        } else if ($item["belge_turu"] == "KREDİ KART ÖDEMESİ") {
            if ($b_durum == "B") {
                $cari_devir_bakiye += $item["cekilen"];
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $item["cekilen"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["cekilen"];
                $b_durum = "B";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => 0,
                'cekilen' => $item["cekilen"],
                'bakiye' => $cari_devir_bakiye,
                'aciklama' => $item["aciklama"],
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);
        } else if ($item["belge_turu"] == "KREDİ TAKSİT ÖDEME") {
            if ($b_durum == "B") {
                $cari_devir_bakiye += $item["cekilen"];
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $item["cekilen"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["cekilen"];
                $b_durum = "B";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => 0,
                'cekilen' => $item["cekilen"],
                'bakiye' => $cari_devir_bakiye,
                'aciklama' => $item["aciklama"],
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);
        } else if ($item["belge_turu"] == "SGK GİDER FİŞLERİ") {
            if ($b_durum == "B") {
                $cari_devir_bakiye += $item["cekilen"];
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $item["cekilen"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["cekilen"];
                $b_durum = "B";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => 0,
                'cekilen' => $item["cekilen"],
                'bakiye' => $cari_devir_bakiye,
                'aciklama' => $item["aciklama"],
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);
        } else if ($item["belge_turu"] == "Yönetim Giderleri") {
            if ($b_durum == "B") {
                $cari_devir_bakiye += $item["cekilen"];
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $item["cekilen"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["cekilen"];
                $b_durum = "B";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => 0,
                'cekilen' => $item["cekilen"],
                'bakiye' => $cari_devir_bakiye,
                'aciklama' => $item["aciklama"],
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);
        } else if ($item["belge_turu"] == "Vergi Gider") {
            if ($b_durum == "B") {
                $cari_devir_bakiye += $item["cekilen"];
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $item["cekilen"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["cekilen"];
                $b_durum = "B";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => 0,
                'cekilen' => $item["cekilen"],
                'bakiye' => $cari_devir_bakiye,
                'aciklama' => $item["aciklama"],
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);
        } else if ($item["belge_turu"] == "HGS Gider") {
            if ($b_durum == "B") {
                $cari_devir_bakiye += $item["cekilen"];
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $item["cekilen"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["cekilen"];
                $b_durum = "B";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => 0,
                'cekilen' => $item["cekilen"],
                'bakiye' => $cari_devir_bakiye,
                'aciklama' => $item["aciklama"],
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);
        } else if ($item["belge_turu"] == "Binek HGS Gider") {
            if ($b_durum == "B") {
                $cari_devir_bakiye += $item["cekilen"];
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $item["cekilen"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["cekilen"];
                $b_durum = "B";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => 0,
                'cekilen' => $item["cekilen"],
                'bakiye' => $cari_devir_bakiye,
                'aciklama' => $item["aciklama"],
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);
        } else if ($item["belge_turu"] == "Kaza Ceza Gider") {
            if ($b_durum == "B") {
                $cari_devir_bakiye += $item["cekilen"];
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $item["cekilen"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["cekilen"];
                $b_durum = "B";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => 0,
                'cekilen' => $item["cekilen"],
                'bakiye' => $cari_devir_bakiye,
                'aciklama' => $item["aciklama"],
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);
        } else if ($item["belge_turu"] == "Bankadan Kasaya Aktarım") {
            if ($b_durum == "B") {
                $cari_devir_bakiye += $item["cekilen"];
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $item["cekilen"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["cekilen"];
                $b_durum = "B";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'banka_adi' => $item["banka_adi"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => 0,
                'cekilen' => $item["cekilen"],
                'bakiye' => $cari_devir_bakiye,
                'aciklama' => $item["aciklama"],
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);
        } else if ($item["belge_turu"] == "Kasadan Bankaya Aktarım") {

            if ($b_durum == "A") {
                $cari_devir_bakiye += $item["yatan"];
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $item["yatan"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["yatan"];
                $b_durum = "A";
            }

            $eklenecek_arr = [
                'tarih' => $item["tarih"],
                'belge_no' => $item["belge_no"],
                'belge_turu' => $item["belge_turu"],
                'banka_kodu' => $item["banka_kodu"],
                'banka_adi' => $item["banka_adi"],
                'aciklama' => $item["aciklama"],
                'sube_adi' => $item["sube_adi"],
                'yatan' => $item["yatan"],
                'cekilen' => 0,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum
            ];
            array_push($gidecek_arr, $eklenecek_arr);

        } else if ($item["belge_turu"] == "Banka Açılış Giriş") {

            if ($b_durum == "A") {
                $cari_devir_bakiye += $item["yatan"];
            } else if ($b_durum == "B") {
                $cari_devir_bakiye -= $item["yatan"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["yatan"];
                $b_durum = "A";
            }
            if ($item["yatan"] == 0 && $item["cekilen"] == 0) {

            } else {
                $eklenecek_arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'belge_turu' => $item["belge_turu"],
                    'banka_kodu' => $item["banka_kodu"],
                    'banka_adi' => $item["banka_adi"],
                    'sube_adi' => $item["sube_adi"],
                    'yatan' => $item["yatan"],
                    'aciklama' => $item["aciklama"],
                    'cekilen' => 0,
                    'bakiye' => $cari_devir_bakiye,
                    'b_durum' => $b_durum
                ];
                array_push($gidecek_arr, $eklenecek_arr);
            }

        } else if ($item["belge_turu"] == "Banka Açılış Çıkış") {
            if ($b_durum == "B") {
                $cari_devir_bakiye += $item["cekilen"];
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $item["cekilen"];
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "B";
                } else if ($cari_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $cari_devir_bakiye += $item["cekilen"];
                $b_durum = "B";
            }

            if ($item["yatan"] == 0 && $item["cekilen"] == 0) {

            } else {
                $eklenecek_arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'belge_turu' => $item["belge_turu"],
                    'banka_kodu' => $item["banka_kodu"],
                    'aciklama' => $item["aciklama"],
                    'banka_adi' => $item["banka_adi"],
                    'sube_adi' => $item["sube_adi"],
                    'yatan' => 0,
                    'cekilen' => $item["cekilen"],
                    'bakiye' => $cari_devir_bakiye,
                    'b_durum' => $b_durum
                ];
                array_push($gidecek_arr, $eklenecek_arr);
            }
        }
    }
    usort($gidecek_arr, function ($a, $b) {
        $tarihA = strtotime($a['tarih']); // $a dizisindeki tarih değerini alıp zaman damgasına dönüştür
        $tarihB = strtotime($b['tarih']);
        if ($tarihA == $tarihB) {
            return 0;
        }

        return ($tarihA < $tarihB) ? -1 : 1;
    });
    if ($gidecek_arr > 0) {
        echo json_encode($gidecek_arr);
    } else {
        echo 2;
    }
}
if ($islem == "kasa_hesap_ekstre_getir_sql") {
    $kasa_id = $_GET["kasa_id"];
    $bas_tarih = $_GET["bas_tarih"];
    $bit_tarih = $_GET["bit_tarih"];

    $banka_ekstre_arr = [];
    $kasa_devir_giren_tutar = 0;
    $kasa_devir_cikan_tutar = 0;
    $kasa_devir_bakiye = 0;
    $b_durum = "";
    $ekstre_arr = [];


    $bas_tarih = new DateTime($bas_tarih);
    $bas_tarih->modify('-1 day');
    $sorgu_bas = $_GET["bas_tarih"];
    $last_bas_tarih = $bas_tarih->format('Y-m-d');

    $yil_basi = new DateTime();
    $yil_basi->modify('first day of January ' . $yil_basi->format('Y'));

    $kasa_bilgileri = DB::single_query("SELECT * FROM kasa WHERE status=1 AND id='$kasa_id'");

    $yil_basi = $yil_basi->format('Y-m-d');

    if ($bas_tarih == "" && $bit_tarih == "") {
        $last_bas_tarih = date("Y-m-d");
    }


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

    $binek_vergi = DB::all_data("
SELECT
       bvgf.*,
       bvg.tarih,
       bk.arac_plaka
FROM
     binek_vergi_gider as bvg
INNER JOIN binek_vergi_gider_fisleri AS bvgf on bvgf.gider_id=bvg.id
INNER JOIN binek_kartlari as bk on bk.id=bvgf.plaka_id
WHERE bvgf.status=1 AND bvg.status=1 AND bvg.cari_key='$cari_key' AND bvgf.kasa_id='$kasa_id' AND  bvg.tarih  < '$last_bas_tarih 23:59:59'
     ");
    if ($binek_vergi > 0) {
        foreach ($binek_vergi as $alislar) {
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
    $arr = [
        'tarih' => $sorgu_bas,
        'belge_no' => ".....",
        'belge_turu' => 'Devir',
        'aciklama' => 'Önceki Tarihten Devir',
        'giren_tutar' => $kasa_devir_giren_tutar,
        'cikan_tutar' => $kasa_devir_cikan_tutar,
        'bakiye' => $kasa_devir_bakiye,
        'b_durum' => $b_durum
    ];
    array_push($ekstre_arr, $arr);
    $kasa_hesap_ekstre = [];
    $kasa_tahsilat = DB::all_data("
SELECT
belge_no,
islem_tarihi,
aciklama,
tahsilat_toplam
FROM kasa_tahsilat
WHERE status=1 AND kasa_id='$kasa_id' AND cari_key='$cari_key' AND islem_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");

    if ($kasa_tahsilat > 0) {
        foreach ($kasa_tahsilat as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["islem_tarihi"],
                'belge_no' => $faturalar["belge_no"],
                'belge_turu' => 'Kasa Tahsilat',
                'aciklama' => $faturalar["aciklama"],
                'giren_tutar' => $faturalar["tahsilat_toplam"],
                'cikan_tutar' => 0
            ];
            array_push($kasa_hesap_ekstre, $banka_duzenle_arr);
        }
    }
    $bireysel_tahakkuk = DB::all_data("
SELECT
bt.tutar,
bt.tarih,
ut.uye_adi
FROM
bireysel_tahakkuk as bt
INNER JOIN uye_tanim as ut on ut.id=bt.uye_id
WHERE bt.status=1 AND bt.kasa_id='$kasa_id'  AND bt.tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");
    if ($bireysel_tahakkuk > 0) {
        foreach ($bireysel_tahakkuk as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => $faturalar["uye_adi"],
                'belge_turu' => 'BİREYSEL ÜYE TAHAKKUK',
                'aciklama' => $faturalar["aciklama"],
                'giren_tutar' => $faturalar["tutar"],
                'cikan_tutar' => 0
            ];
            array_push($kasa_hesap_ekstre, $banka_duzenle_arr);
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
WHERE bvgf.status=1 AND bvg.status=1 AND bvg.cari_key='$cari_key' AND bvgf.kasa_id='$kasa_id' AND  bvg.tarih  BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
     ");

    if ($binek_vergi > 0) {
        foreach ($binek_vergi as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => $faturalar["arac_plaka"],
                'belge_turu' => 'BİNEK VERGİ GİDER',
                'aciklama' => $faturalar["aciklama"],
                'giren_tutar' => 0,
                'cikan_tutar' => $faturalar["tutar"]
            ];
            array_push($kasa_hesap_ekstre, $banka_duzenle_arr);
        }
    }

    $hgs_gider = DB::all_data("
SELECT
       bhgf.tutar,
       bhg.tarih,
       bk.arac_plaka,
       bhgf.aciklama
FROM
     binek_hgs_gider as bhg
INNER JOIN binek_hgs_gider_fisleri AS bhgf on bhgf.gider_id=bhg.id
INNER JOIN binek_kartlari as bk on bk.id=bhgf.plaka_id
WHERE bhg.status=1 AND bhgf.status=1 AND bhgf.kasa_id='$kasa_id' AND bhg.tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
     ");

    if ($hgs_gider > 0) {
        foreach ($hgs_gider as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => $faturalar["arac_plaka"],
                'belge_turu' => 'BİNEK HGS GİDER',
                'aciklama' => $faturalar["aciklama"],
                'giren_tutar' => 0,
                'cikan_tutar' => $faturalar["tutar"]
            ];
            array_push($kasa_hesap_ekstre, $banka_duzenle_arr);
        }
    }
    $binek_yakit_alim = DB::all_data("
SELECT
       byc.*,
       bk.arac_plaka
FROM
     binek_yakit_cikis as byc
INNER JOIN binek_kartlari as bk on bk.id=byc.plaka_id
WHERE
      byc.status!=0 AND byc.cari_key='$cari_key' AND byc.kasa_id='$kasa_id' AND byc.tarih  BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' ");


    if ($binek_yakit_alim > 0) {
        foreach ($binek_yakit_alim as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => $faturalar["fis_no"],
                'belge_turu' => 'BİNEK YAKIT ALIM',
                'aciklama' => $faturalar["arac_plaka"],
                'giren_tutar' => 0,
                'cikan_tutar' => $faturalar["tl_tutar"],
            ];
            array_push($kasa_hesap_ekstre, $banka_duzenle_arr);
        }
    }
    $prim_odeme = DB::all_data("
SELECT
pou.prim_tutari,
po.aciklama,
pt.ad_soyad,
po.odeme_tarihi
FROM
prim_odeme_urunler as pou
INNER JOIN prim_odeme AS po on po.id=pou.odeme_id
INNER JOIN personel_tanim as pt on pt.id=po.sofor_id
WHERE pou.status=1 AND po.kasa_id='$kasa_id' AND pou.cari_key='$cari_key' AND po.status=1 AND po.odeme_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");

    if ($prim_odeme > 0) {
        foreach ($prim_odeme as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["odeme_tarihi"],
                'belge_no' => $faturalar["ad_soyad"],
                'belge_turu' => 'Prim Ödeme',
                'aciklama' => $faturalar["aciklama"],
                'giren_tutar' => 0,
                'cikan_tutar' => $faturalar["prim_tutari"]
            ];
            array_push($kasa_hesap_ekstre, $banka_duzenle_arr);
        }
    }

    $kasa_odeme = DB::all_data("
SELECT
belge_no,
islem_tarihi,
aciklama,
odeme_toplam
FROM kasa_odeme
WHERE status=1 AND kasa_id='$kasa_id' AND cari_key='$cari_key' AND islem_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");

    if ($kasa_odeme > 0) {
        foreach ($kasa_odeme as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["islem_tarihi"],
                'belge_no' => $faturalar["belge_no"],
                'belge_turu' => 'Kasa Ödeme',
                'aciklama' => $faturalar["aciklama"],
                'giren_tutar' => 0,
                'cikan_tutar' => $faturalar["odeme_toplam"]
            ];
            array_push($kasa_hesap_ekstre, $banka_duzenle_arr);
        }
    }
    $kasa_acilis_giren = DB::all_data("
SELECT
acilis_tarihi,
aciklama,
giren_tutar
FROM kasa_acilis_fisi
WHERE status=1 AND kasa_id='$kasa_id' AND cari_key='$cari_key' AND acilis_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");

    if ($kasa_acilis_giren > 0) {
        foreach ($kasa_acilis_giren as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["acilis_tarihi"],
                'belge_no' => "",
                'belge_turu' => 'Kasa Açılış Giren',
                'aciklama' => $faturalar["aciklama"],
                'giren_tutar' => $faturalar["giren_tutar"],
                'cikan_tutar' => 0
            ];
            array_push($kasa_hesap_ekstre, $banka_duzenle_arr);
        }
    }
    $perakende_satislar = DB::all_data("
SELECT
       ps.*,
       (SELECT SUM(genel_toplam) FROM perakende_satis_urunler WHERE satis_id = ps.id) AS toplam_tutar
FROM 
     perakende_satis as ps
INNER JOIN perakende_satis_urunler as psu
WHERE ps.status=1 AND psu.status=1 AND ps.cari_key='$cari_key' AND ps.kasa_id='$kasa_id' AND psu.status=1 AND ps.fatura_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'   GROUP BY ps.id
");

    if ($perakende_satislar > 0) {
        foreach ($perakende_satislar as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["fatura_tarihi"],
                'belge_no' => "",
                'belge_turu' => 'Perakende Satış',
                'aciklama' => $faturalar["aciklama"],
                'giren_tutar' => $faturalar["toplam_tutar"],
                'cikan_tutar' => 0
            ];
            array_push($kasa_hesap_ekstre, $banka_duzenle_arr);
        }
    }
    $havale_cikis = DB::all_data("
SELECT
tecu.tutar,
tecs.tarih,
tecs.aciklama
FROM
tahsil_edilen_senet_urunler as tecu
INNER JOIN tahsil_edilen_senet as tecs on tecs.id=tecu.tahsilat_id
WHERE tecu.status=1 AND tecs.kasa_id='$kasa_id' AND tecu.cari_key='$cari_key' AND tecs.tarih  BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");

    if ($havale_cikis > 0) {
        foreach ($havale_cikis as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => "",
                'belge_turu' => 'Senet Tahsilat',
                'aciklama' => $faturalar["aciklama"],
                'giren_tutar' => $faturalar["tutar"],
                'cikan_tutar' => 0
            ];
            array_push($kasa_hesap_ekstre, $banka_duzenle_arr);
        }
    }
    $havale_cikis = DB::all_data("
SELECT
tecu.tutar,
tecs.tarih,
tecs.aciklama
FROM
tahsil_edilen_cek_urunler as tecu
INNER JOIN tahsil_edilen_cek_senet as tecs on tecs.id=tecu.tahsil_id
WHERE tecu.status=1 AND tecs.kasa_id='$kasa_id' AND tecu.cari_key='$cari_key' AND tecs.tarih  BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");

    if ($havale_cikis > 0) {
        foreach ($havale_cikis as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => "",
                'belge_turu' => 'Çek Tahsilat',
                'aciklama' => $faturalar["aciklama"],
                'giren_tutar' => $faturalar["tutar"],
                'cikan_tutar' => 0
            ];
            array_push($kasa_hesap_ekstre, $banka_duzenle_arr);
        }
    }
    $kasa_acilis_cikan = DB::all_data("
SELECT
acilis_tarihi,
aciklama,
cikan_tutar
FROM kasa_acilis_fisi
WHERE status=1 AND kasa_id='$kasa_id' AND cari_key='$cari_key' AND acilis_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");

    if ($kasa_acilis_cikan > 0) {
        foreach ($kasa_acilis_cikan as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["acilis_tarihi"],
                'belge_no' => "",
                'belge_turu' => 'Kasa Açılış Çıkan',
                'aciklama' => $faturalar["aciklama"],
                'giren_tutar' => 0,
                'cikan_tutar' => $faturalar["cikan_tutar"]
            ];
            array_push($kasa_hesap_ekstre, $banka_duzenle_arr);
        }
    }
    $kasa_virman_giren = DB::all_data("
SELECT
insert_datetime,
aciklama,
gonderilen_miktar,
tarih
FROM kasa_virman
WHERE status=1 AND alan_kasaid='$kasa_id' AND cari_key='$cari_key' AND tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");

    if ($kasa_virman_giren > 0) {
        foreach ($kasa_virman_giren as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => "",
                'belge_turu' => 'Kasa Virman Giren',
                'aciklama' => $faturalar["aciklama"],
                'giren_tutar' => $faturalar["gonderilen_miktar"],
                'cikan_tutar' => 0
            ];
            array_push($kasa_hesap_ekstre, $banka_duzenle_arr);
        }
    }
    $kasa_virman_cikan = DB::all_data("
SELECT
insert_datetime,
aciklama,
gonderilen_miktar,
tarih
FROM kasa_virman
WHERE status=1 AND gonderen_kasaid='$kasa_id' AND cari_key='$cari_key' AND tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");

    if ($kasa_virman_cikan > 0) {
        foreach ($kasa_virman_cikan as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => "",
                'belge_turu' => 'Kasa Virman Çıkan',
                'aciklama' => $faturalar["aciklama"],
                'giren_tutar' => 0,
                'cikan_tutar' => $faturalar["gonderilen_miktar"]
            ];
            array_push($kasa_hesap_ekstre, $banka_duzenle_arr);
        }
    }
    $kasadan_bankaya = DB::all_data("
SELECT
insert_datetime,
aciklama,
gonderilen_tutar,
tarih
FROM kasadan_bankaya
WHERE status=1 AND kasa_id='$kasa_id' AND cari_key='$cari_key' AND tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");

    if ($kasadan_bankaya > 0) {
        foreach ($kasadan_bankaya as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => "",
                'belge_turu' => 'Kasadan Bankaya Giden',
                'aciklama' => $faturalar["aciklama"],
                'giren_tutar' => 0,
                'cikan_tutar' => $faturalar["gonderilen_tutar"]
            ];
            array_push($kasa_hesap_ekstre, $banka_duzenle_arr);
        }
    }
    $bankadan_kasaya = DB::all_data("
SELECT
insert_datetime,
aciklama,
gonderilen_tutar,
tarih
FROM bankadan_kasaya
WHERE status=1 AND kasa_id='$kasa_id' AND cari_key='$cari_key' AND tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");

    if ($bankadan_kasaya > 0) {
        foreach ($bankadan_kasaya as $faturalar) {
            $banka_duzenle_arr = [
                'tarih' => $faturalar["tarih"],
                'belge_no' => "",
                'belge_turu' => 'Bankadan Kasaya Giden',
                'aciklama' => $faturalar["aciklama"],
                'giren_tutar' => $faturalar["gonderilen_tutar"],
                'cikan_tutar' => 0
            ];
            array_push($kasa_hesap_ekstre, $banka_duzenle_arr);
        }
    }
    usort($kasa_hesap_ekstre, function ($a, $b) {
        $tarihA = strtotime($a['tarih']); // $a dizisindeki tarih değerini alıp zaman damgasına dönüştür
        $tarihB = strtotime($b['tarih']);
        if ($tarihA == $tarihB) {
            return 0;
        }

        return ($tarihA < $tarihB) ? -1 : 1;
    });
    $gidecek_ekstre_arr = [];
    array_push($gidecek_ekstre_arr, $arr);
    if ($kasa_hesap_ekstre > 0) {
        foreach ($kasa_hesap_ekstre as $item) {
            if ($item["belge_turu"] == "Kasa Tahsilat") {

                if ($b_durum == "A") {
                    $kasa_devir_bakiye += $item["giren_tutar"];
                } else if ($b_durum == "B") {
                    $kasa_devir_bakiye -= $item["giren_tutar"];
                    if ($kasa_devir_bakiye < 0) {
                        $b_durum = "A";
                        $kasa_devir_bakiye = -$kasa_devir_bakiye;
                    } else if ($kasa_devir_bakiye == 0) {
                        $b_durum = "YOK";
                    }
                } else {
                    $b_durum = "A";
                    $kasa_devir_bakiye += $item["giren_tutar"];
                }

                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'giren_tutar' => $item["giren_tutar"],
                    'cikan_tutar' => 0,
                    'bakiye' => $kasa_devir_bakiye,
                    'b_durum' => $b_durum
                ];

                array_push($gidecek_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "BİREYSEL ÜYE TAHAKKUK") {

                if ($b_durum == "A") {
                    $kasa_devir_bakiye += $item["giren_tutar"];
                } else if ($b_durum == "B") {
                    $kasa_devir_bakiye -= $item["giren_tutar"];
                    if ($kasa_devir_bakiye < 0) {
                        $b_durum = "A";
                        $kasa_devir_bakiye = -$kasa_devir_bakiye;
                    } else if ($kasa_devir_bakiye == 0) {
                        $b_durum = "YOK";
                    }
                } else {
                    $b_durum = "A";
                    $kasa_devir_bakiye += $item["giren_tutar"];
                }

                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'giren_tutar' => $item["giren_tutar"],
                    'cikan_tutar' => 0,
                    'bakiye' => $kasa_devir_bakiye,
                    'b_durum' => $b_durum
                ];

                array_push($gidecek_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "Kasa Ödeme") {

                if ($b_durum == "B") {
                    $kasa_devir_bakiye += $item["cikan_tutar"];
                } else if ($b_durum == "A") {
                    $kasa_devir_bakiye -= $item["cikan_tutar"];
                    if ($kasa_devir_bakiye < 0) {
                        $kasa_devir_bakiye = -$kasa_devir_bakiye;
                        $b_durum = "B";
                    } else if ($kasa_devir_bakiye == 0) {
                        $b_durum = "YOK";
                    }
                } else {
                    $kasa_devir_bakiye += $item["cikan_tutar"];
                    $b_durum = "B";
                }

                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'giren_tutar' => 0,
                    'cikan_tutar' => $item["cikan_tutar"],
                    'bakiye' => $kasa_devir_bakiye,
                    'b_durum' => $b_durum
                ];

                array_push($gidecek_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "Prim Ödeme") {

                if ($b_durum == "B") {
                    $kasa_devir_bakiye += $item["cikan_tutar"];
                } else if ($b_durum == "A") {
                    $kasa_devir_bakiye -= $item["cikan_tutar"];
                    if ($kasa_devir_bakiye < 0) {
                        $kasa_devir_bakiye = -$kasa_devir_bakiye;
                        $b_durum = "B";
                    } else if ($kasa_devir_bakiye == 0) {
                        $b_durum = "YOK";
                    }
                } else {
                    $kasa_devir_bakiye += $item["cikan_tutar"];
                    $b_durum = "B";
                }

                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'giren_tutar' => 0,
                    'cikan_tutar' => $item["cikan_tutar"],
                    'bakiye' => $kasa_devir_bakiye,
                    'b_durum' => $b_durum
                ];

                array_push($gidecek_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "BİNEK YAKIT ALIM") {

                if ($b_durum == "B") {
                    $kasa_devir_bakiye += $item["cikan_tutar"];
                } else if ($b_durum == "A") {
                    $kasa_devir_bakiye -= $item["cikan_tutar"];
                    if ($kasa_devir_bakiye < 0) {
                        $kasa_devir_bakiye = -$kasa_devir_bakiye;
                        $b_durum = "B";
                    } else if ($kasa_devir_bakiye == 0) {
                        $b_durum = "YOK";
                    }
                } else {
                    $kasa_devir_bakiye += $item["cikan_tutar"];
                    $b_durum = "B";
                }

                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'giren_tutar' => 0,
                    'cikan_tutar' => $item["cikan_tutar"],
                    'bakiye' => $kasa_devir_bakiye,
                    'b_durum' => $b_durum
                ];

                array_push($gidecek_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "BİNEK HGS GİDER") {

                if ($b_durum == "B") {
                    $kasa_devir_bakiye += $item["cikan_tutar"];
                } else if ($b_durum == "A") {
                    $kasa_devir_bakiye -= $item["cikan_tutar"];
                    if ($kasa_devir_bakiye < 0) {
                        $kasa_devir_bakiye = -$kasa_devir_bakiye;
                        $b_durum = "B";
                    } else if ($kasa_devir_bakiye == 0) {
                        $b_durum = "YOK";
                    }
                } else {
                    $kasa_devir_bakiye += $item["cikan_tutar"];
                    $b_durum = "B";
                }

                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'giren_tutar' => 0,
                    'cikan_tutar' => $item["cikan_tutar"],
                    'bakiye' => $kasa_devir_bakiye,
                    'b_durum' => $b_durum
                ];

                array_push($gidecek_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "BİNEK VERGİ GİDER") {

                if ($b_durum == "B") {
                    $kasa_devir_bakiye += $item["cikan_tutar"];
                } else if ($b_durum == "A") {
                    $kasa_devir_bakiye -= $item["cikan_tutar"];
                    if ($kasa_devir_bakiye < 0) {
                        $kasa_devir_bakiye = -$kasa_devir_bakiye;
                        $b_durum = "B";
                    } else if ($kasa_devir_bakiye == 0) {
                        $b_durum = "YOK";
                    }
                } else {
                    $kasa_devir_bakiye += $item["cikan_tutar"];
                    $b_durum = "B";
                }

                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'giren_tutar' => 0,
                    'cikan_tutar' => $item["cikan_tutar"],
                    'bakiye' => $kasa_devir_bakiye,
                    'b_durum' => $b_durum
                ];

                array_push($gidecek_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "Kasa Virman Giren") {

                if ($b_durum == "A") {
                    $kasa_devir_bakiye += $item["giren_tutar"];
                } else if ($b_durum == "B") {
                    $kasa_devir_bakiye -= $item["giren_tutar"];
                    if ($kasa_devir_bakiye < 0) {
                        $b_durum = "A";
                        $kasa_devir_bakiye = -$kasa_devir_bakiye;
                    } else if ($kasa_devir_bakiye == 0) {
                        $b_durum = "YOK";
                    }
                } else {
                    $b_durum = "A";
                    $kasa_devir_bakiye += $item["giren_tutar"];
                }

                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'giren_tutar' => $item["giren_tutar"],
                    'cikan_tutar' => 0,
                    'bakiye' => $kasa_devir_bakiye,
                    'b_durum' => $b_durum
                ];

                array_push($gidecek_ekstre_arr, $arr);
            } else if ($item["belge_turu"] == "Senet Tahsilat") {

                if ($b_durum == "A") {
                    $kasa_devir_bakiye += $item["giren_tutar"];
                } else if ($b_durum == "B") {
                    $kasa_devir_bakiye -= $item["giren_tutar"];
                    if ($kasa_devir_bakiye < 0) {
                        $b_durum = "A";
                        $kasa_devir_bakiye = -$kasa_devir_bakiye;
                    } else if ($kasa_devir_bakiye == 0) {
                        $b_durum = "YOK";
                    }
                } else {
                    $b_durum = "A";
                    $kasa_devir_bakiye += $item["giren_tutar"];
                }

                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'giren_tutar' => $item["giren_tutar"],
                    'cikan_tutar' => 0,
                    'bakiye' => $kasa_devir_bakiye,
                    'b_durum' => $b_durum
                ];

                array_push($gidecek_ekstre_arr, $arr);
            } else if ($item["belge_turu"] == "Çek Tahsilat") {

                if ($b_durum == "A") {
                    $kasa_devir_bakiye += $item["giren_tutar"];
                } else if ($b_durum == "B") {
                    $kasa_devir_bakiye -= $item["giren_tutar"];
                    if ($kasa_devir_bakiye < 0) {
                        $b_durum = "A";
                        $kasa_devir_bakiye = -$kasa_devir_bakiye;
                    } else if ($kasa_devir_bakiye == 0) {
                        $b_durum = "YOK";
                    }
                } else {
                    $b_durum = "A";
                    $kasa_devir_bakiye += $item["giren_tutar"];
                }

                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'giren_tutar' => $item["giren_tutar"],
                    'cikan_tutar' => 0,
                    'bakiye' => $kasa_devir_bakiye,
                    'b_durum' => $b_durum
                ];

                array_push($gidecek_ekstre_arr, $arr);
            } else if ($item["belge_turu"] == "Kasa Virman Çıkan") {
                if ($b_durum == "B") {
                    $kasa_devir_bakiye += $item["cikan_tutar"];
                } else if ($b_durum == "A") {
                    $kasa_devir_bakiye -= $item["cikan_tutar"];
                    if ($kasa_devir_bakiye < 0) {
                        $kasa_devir_bakiye = -$kasa_devir_bakiye;
                        $b_durum = "B";
                    } else if ($kasa_devir_bakiye == 0) {
                        $b_durum = "YOK";
                    }
                } else {
                    $kasa_devir_bakiye += $item["cikan_tutar"];
                    $b_durum = "B";
                }

                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'giren_tutar' => 0,
                    'cikan_tutar' => $item["cikan_tutar"],
                    'bakiye' => $kasa_devir_bakiye,
                    'b_durum' => $b_durum
                ];

                array_push($gidecek_ekstre_arr, $arr);
            } else if ($item["belge_turu"] == "Kasadan Bankaya Giden") {
                if ($b_durum == "B") {
                    $kasa_devir_bakiye += $item["cikan_tutar"];
                } else if ($b_durum == "A") {
                    $kasa_devir_bakiye -= $item["cikan_tutar"];
                    if ($kasa_devir_bakiye < 0) {
                        $kasa_devir_bakiye = -$kasa_devir_bakiye;
                        $b_durum = "B";
                    } else if ($kasa_devir_bakiye == 0) {
                        $b_durum = "YOK";
                    }
                } else {
                    $kasa_devir_bakiye += $item["cikan_tutar"];
                    $b_durum = "B";
                }

                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'giren_tutar' => 0,
                    'cikan_tutar' => $item["cikan_tutar"],
                    'bakiye' => $kasa_devir_bakiye,
                    'b_durum' => $b_durum
                ];

                array_push($gidecek_ekstre_arr, $arr);
            } else if ($item["belge_turu"] == "Bankadan Kasaya Giden") {

                if ($b_durum == "A") {
                    $kasa_devir_bakiye += $item["giren_tutar"];
                } else if ($b_durum == "B") {
                    $kasa_devir_bakiye -= $item["giren_tutar"];
                    if ($kasa_devir_bakiye < 0) {
                        $b_durum = "A";
                        $kasa_devir_bakiye = -$kasa_devir_bakiye;
                    } else if ($kasa_devir_bakiye == 0) {
                        $b_durum = "YOK";
                    }
                } else {
                    $b_durum = "A";
                    $kasa_devir_bakiye += $item["giren_tutar"];
                }

                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'giren_tutar' => $item["giren_tutar"],
                    'cikan_tutar' => 0,
                    'bakiye' => $kasa_devir_bakiye,
                    'b_durum' => $b_durum
                ];

                array_push($gidecek_ekstre_arr, $arr);
            } else if ($item["belge_turu"] == "Kasa Açılış Çıkan") {
                if ($b_durum == "B") {
                    $kasa_devir_bakiye += $item["cikan_tutar"];
                } else if ($b_durum == "A") {
                    $kasa_devir_bakiye -= $item["cikan_tutar"];
                    if ($kasa_devir_bakiye < 0) {
                        $kasa_devir_bakiye = -$kasa_devir_bakiye;
                        $b_durum = "B";
                    } else if ($kasa_devir_bakiye == 0) {
                        $b_durum = "YOK";
                    }
                } else {
                    $kasa_devir_bakiye += $item["cikan_tutar"];
                    $b_durum = "B";
                }

                if ($item["giren_tutar"] == 0 && $item["cikan_tutar"] == 0) {

                } else {
                    $arr = [
                        'tarih' => $item["tarih"],
                        'belge_no' => $item["belge_no"],
                        'belge_turu' => $item["belge_turu"],
                        'aciklama' => $item["aciklama"],
                        'giren_tutar' => 0,
                        'cikan_tutar' => $item["cikan_tutar"],
                        'bakiye' => $kasa_devir_bakiye,
                        'b_durum' => $b_durum
                    ];

                    array_push($gidecek_ekstre_arr, $arr);
                }
            } else if ($item["belge_turu"] == "Kasa Açılış Giren") {
                if ($b_durum == "A") {
                    $kasa_devir_bakiye += $item["giren_tutar"];
                } else if ($b_durum == "B") {
                    $kasa_devir_bakiye -= $item["giren_tutar"];
                    if ($kasa_devir_bakiye < 0) {
                        $b_durum = "A";
                        $kasa_devir_bakiye = -$kasa_devir_bakiye;
                    } else if ($kasa_devir_bakiye == 0) {
                        $b_durum = "YOK";
                    }
                } else {
                    $b_durum = "A";
                    $kasa_devir_bakiye += $item["giren_tutar"];
                }

                if ($item["giren_tutar"] == 0 && $item["cikan_tutar"] == 0) {

                } else {
                    $arr = [
                        'tarih' => $item["tarih"],
                        'belge_no' => $item["belge_no"],
                        'belge_turu' => $item["belge_turu"],
                        'aciklama' => $item["aciklama"],
                        'giren_tutar' => $item["giren_tutar"],
                        'cikan_tutar' => 0,
                        'bakiye' => $kasa_devir_bakiye,
                        'b_durum' => $b_durum
                    ];

                    array_push($gidecek_ekstre_arr, $arr);
                }

            } else if ($item["belge_turu"] == "Perakende Satış") {
                if ($b_durum == "A") {
                    $kasa_devir_bakiye += $item["giren_tutar"];
                } else if ($b_durum == "B") {
                    $kasa_devir_bakiye -= $item["giren_tutar"];
                    if ($kasa_devir_bakiye < 0) {
                        $b_durum = "A";
                        $kasa_devir_bakiye = -$kasa_devir_bakiye;
                    } else if ($kasa_devir_bakiye == 0) {
                        $b_durum = "YOK";
                    }
                } else {
                    $b_durum = "A";
                    $kasa_devir_bakiye += $item["giren_tutar"];
                }

                if ($item["giren_tutar"] == 0 && $item["cikan_tutar"] == 0) {

                } else {
                    $arr = [
                        'tarih' => $item["tarih"],
                        'belge_no' => $item["belge_no"],
                        'belge_turu' => $item["belge_turu"],
                        'aciklama' => $item["aciklama"],
                        'giren_tutar' => $item["giren_tutar"],
                        'cikan_tutar' => 0,
                        'bakiye' => $kasa_devir_bakiye,
                        'b_durum' => $b_durum
                    ];

                    array_push($gidecek_ekstre_arr, $arr);
                }

            }
        }
    }
    if ($gidecek_ekstre_arr > 0) {
        echo json_encode($gidecek_ekstre_arr);
    } else {
        echo 2;
    }
}
if ($islem == "stok_ekstresi_getir_sql") {
    $kasa_id = $_GET["stok_id"];
    $bas_tarih = $_GET["bas_tarih"];
    $bit_tarih = $_GET["bit_tarih"];

    $banka_ekstre_arr = [];
    $kasa_devir_giren_miktar = 0;
    $kasa_devir_cikan_miktar = 0;
    $kasa_devir_kalan_miktar = 0;
    $b_durum = "";
    $ekstre_arr = [];


    $bas_tarih = new DateTime($bas_tarih);
    $bas_tarih->modify('-1 day');
    $sorgu_bas = $_GET["bas_tarih"];
    $last_bas_tarih = $bas_tarih->format('Y-m-d');

    $yil_basi = new DateTime();
    $yil_basi->modify('first day of January ' . $yil_basi->format('Y'));

    $kasa_bilgileri = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$kasa_id'");

    $yil_basi = $yil_basi->format('Y-m-d');

    if ($bas_tarih == "" && $bit_tarih == "") {
        $last_bas_tarih = date("Y-m-d");
    }


    $stok_bilgileri = DB::single_query("SELECT * FROM stok WHERE status=1 AND cari_key='$cari_key' AND id='$kasa_id'");
    $alis_toplam = 0;
    $satis_toplam = 0;
    $alis_faturasi = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat
FROM
alis_default as ad
INNER JOIN alis_urunler as au on au.alis_defaultid=ad.id
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.fatura_tarihi  < '$last_bas_tarih 23:59:59'
");
    if ($alis_faturasi > 0) {
        foreach ($alis_faturasi as $alislar) {
            $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
            $alis_toplam += $ara_toplam;
            $kasa_devir_giren_miktar += $alislar["miktar"];
        }
    }
    $alis_faturasi = DB::all_data("
SELECT
miktar,
birim_fiyat
FROM
stok_sayim_fazlasi
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key' AND tarih  < '$last_bas_tarih 23:59:59'
");
    if ($alis_faturasi > 0) {
        foreach ($alis_faturasi as $alislar) {
            $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
            $alis_toplam += $ara_toplam;
            $kasa_devir_giren_miktar += $alislar["miktar"];
        }
    }

    $stok_cikisi = DB::all_data("
SELECT
asu.toplam_tutar,
asu.birim_fiyat,
asu.miktar,
arac.tarih,
arac.belge_no,
arac.aciklama
FROM
     araclara_stok_cik as arac
INNER JOIN araclara_stok_urunler as asu on asu.ana_id=arac.id
INNER JOIN arac_kartlari as ak on ak.id=asu.plaka_id
WHERE arac.status=1 AND asu.status=1 AND arac.cari_key='$cari_key' AND asu.stok_id='$kasa_id' AND arac.tarih < '$last_bas_tarih 23:59:59'
");
    if ($stok_cikisi > 0) {
        foreach ($stok_cikisi as $alislar) {
            $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
            $alis_toplam += $ara_toplam;
            $kasa_devir_cikan_miktar += $alislar["miktar"];
        }
    }


//    $sql = "
//SELECT
//    au.miktar,
//    au.birim_fiyat,
//    ad.fatura_tarihi
//FROM
//     alis_default as ad
//INNER JOIN alis_urunler AS au on au.alis_defaultid=ad.id
//WHERE ad.status=1 AND au.status=1 and ad.cari_key='$cari_key' AND ad.fatura_tarihi < '$last_bas_tarih 23:59:59'  AND au.stok_id='$kasa_id'";
//    $faturalar = DBD::all_data($sql);
//    if ($faturalar > 0) {
//        foreach ($faturalar as $alislar) {
//            $kasa_devir_giren_miktar += $alislar["miktar"];
//            $arr3 = [
//                'birim_fiyat' => $alislar["birim_fiyat"],
//                'aktif_miktar' => $alislar["miktar"],
//                'tarih' => $alislar["fatura_tarihi"]
//            ];
//            $last_birim_fiyat = $alislar["birim_fiyat"];
//            $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
//            $alis_tutar += $ara_toplam;
//            $maliyet_tutar += $ara_toplam;
//            array_push($alislar_arr, $arr3);
//        }
//    }
//
//    $sql = "
//SELECT
//su.miktar,
//su.birim_fiyat
//FROM
//     satis_default as sd
//INNER JOIN satis_urunler as su on su.satis_defaultid=sd.id
//WHERE sd.status=1 AND su.status=1 and sd.cari_key='$cari_key' AND sd.fatura_tarihi < '$last_bas_tarih 23:59:59' AND su.stok_id='$kasa_id'";
//    $faturalar = DBD::all_data($sql);
//    if ($faturalar > 0) {
//        foreach ($faturalar as $alislar) {
//            $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
//            $satis_tutar += $ara_toplam;
//            $kasa_devir_cikan_miktar += $alislar["miktar"];
//        }
//    }

    $alis_faturasi = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat
FROM
alis_irsaliye as ad
INNER JOIN alis_irsaliye_urunler as au on au.irsaliye_id=ad.id
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.irsaliye_tarihi  < '$last_bas_tarih 23:59:59'
");
    if ($alis_faturasi > 0) {
        foreach ($alis_faturasi as $alislar) {
            $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
            $alis_toplam += $ara_toplam;
            $kasa_devir_giren_miktar += $alislar["miktar"];
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat
FROM
satis_default as ad
INNER JOIN satis_urunler as au on au.satis_defaultid=ad.id
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.fatura_tarihi < '$last_bas_tarih 23:59:59'
");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
            $satis_toplam += $ara_toplam;
            $kasa_devir_cikan_miktar += $alislar["miktar"];
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
miktar,
tl_tutar
FROM
yakit_cikis_fisleri 
WHERE status!=0 AND tarih < '$last_bas_tarih 23:59:59' AND stok_id='$kasa_id'
");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $satis_toplam += $alislar["tl_tutar"];
            $kasa_devir_cikan_miktar += $alislar["miktar"];
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat
FROM
satis_irsaliye as ad
INNER JOIN satis_irsaliye_urunler as au on au.irsaliye_id=ad.id
WHERE ad.status!=0 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.irsaliye_tarihi < '$last_bas_tarih 23:59:59'
");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
            $satis_toplam += $ara_toplam;
            $kasa_devir_cikan_miktar += $alislar["miktar"];
        }
    }
    $acilis_fisi = DB::all_data("
SELECT
miktar,
alis_fiyat
FROM
stok_acilis_fisleri
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key' AND acilis_tarih < '$last_bas_tarih 23:59:59'
");
    if ($acilis_fisi > 0) {
        foreach ($acilis_fisi as $alislar) {
            $ara_toplam = $alislar["alis_fiyat"] * $alislar["miktar"];
            $alis_toplam += $ara_toplam;
            $kasa_devir_giren_miktar += $alislar["miktar"];
        }
    }
    $lastik_alis_fat = DB::all_data("
SELECT
lafu.miktar,
lafu.birim_fiyat
FROM
lastik_alis_fatura_urunler as lafu
INNER JOIN lastik_alis_fatura as laf on laf.id=lafu.fatura_id 
WHERE laf.status=1 AND lafu.status=1 AND lafu.stok_id='$kasa_id' AND laf.cari_key='$cari_key' AND laf.fatura_tarihi < '$last_bas_tarih 23:59:59'
");
    if ($lastik_alis_fat > 0) {
        foreach ($lastik_alis_fat as $alislar) {
            $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
            $alis_toplam += $ara_toplam;
            $kasa_devir_giren_miktar += $alislar["miktar"];
        }
    }
    $lastik_alis_irsaliye = DB::all_data("
SELECT
lafu.miktar,
lafu.birim_fiyat
FROM
lastik_alis_irsaliye_urunler as lafu
INNER JOIN lastik_alis_irsaliye as laf on laf.id=lafu.irsaliye_id
WHERE laf.status=1 AND lafu.status=1 AND lafu.stok_id='$kasa_id' AND laf.cari_key='$cari_key' AND laf.irsaliye_tarih < '$last_bas_tarih 23:59:59'
");
    if ($lastik_alis_irsaliye > 0) {
        foreach ($lastik_alis_irsaliye as $alislar) {
            $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
            $alis_toplam += $ara_toplam;
            $kasa_devir_giren_miktar += $alislar["miktar"];
        }
    }
    $lastik_tak = DB::all_data("
SELECT
*
FROM
arac_lastik_tak
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key' AND insert_datetime < '$last_bas_tarih 23:59:59'
");
    if ($lastik_tak > 0) {
        foreach ($lastik_tak as $alislar) {
            $kasa_devir_cikan_miktar += 1;
        }
    }
    $stok_kodu = $stok_bilgileri["stok_kodu"];
    $perakende_satislar = DB::all_data("
SELECT
psu.miktar,
psu.birim_fiyat
FROM
perakende_satis_urunler as psu
INNER JOIN perakende_satis as ps on ps.id=psu.satis_id
WHERE psu.status=1 AND ps.status=1 AND psu.stok_kodu='$stok_kodu' AND psu.cari_key='$cari_key' AND psu.insert_datetime < '$last_bas_tarih 23:59:59'
");
    if ($perakende_satislar > 0) {
        foreach ($perakende_satislar as $alislar) {
            $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
            $satis_toplam += $ara_toplam;
            $kasa_devir_cikan_miktar += $alislar["miktar"];
        }
    }
    $acilis_fisi = DB::all_data("
SELECT
miktar,
birim_fiyat
FROM
stok_fire
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key' AND insert_datetime < '$last_bas_tarih 23:59:59'
");
    if ($acilis_fisi > 0) {
        foreach ($acilis_fisi as $alislar) {
            $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
            $satis_toplam += $ara_toplam;
            $kasa_devir_cikan_miktar += $alislar["miktar"];
        }
    }
    $kasa_devir_kalan_miktar = floatval($kasa_devir_giren_miktar) - floatval($kasa_devir_cikan_miktar);
    $arr = [
        'tarih' => $sorgu_bas,
        'belge_no' => "......",
        'belge_turu' => "Devir",
        'aciklama' => "Önceki Tarihten Devir",
        'giren_miktar' => $kasa_devir_giren_miktar,
        'cikan_miktar' => $kasa_devir_cikan_miktar,
        'alis_tutar' => $alis_toplam,
        'satis_tutar' => $satis_toplam,
        'fiyat' => "",
        'kalan_miktar' => $kasa_devir_kalan_miktar
    ];
    array_push($ekstre_arr, $arr);

    $cok_kibarsin = [];
    $alislar_arr = [];


    $stok_cikisi = DB::all_data("
SELECT
asu.toplam_tutar,
asu.kdv_tutar,
asu.birim_fiyat,
asu.miktar,
arac.tarih,
arac.belge_no,
arac.aciklama
FROM
     araclara_stok_cik as arac
INNER JOIN araclara_stok_urunler as asu on asu.ana_id=arac.id
INNER JOIN arac_kartlari as ak on ak.id=asu.plaka_id
WHERE arac.status=1 AND asu.status=1 AND arac.cari_key='$cari_key' AND asu.stok_id='$kasa_id' AND arac.tarih BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59'
");
    if ($stok_cikisi > 0) {

        foreach ($stok_cikisi as $alislar) {
            $ara_toplam = $alislar["miktar"] * $alislar["birim_fiyat"];
            $arr = [
                'tarih' => $alislar["tarih"],
                'belge_no' => $alislar["belge_no"],
                'belge_turu' => "ARACA STOK ÇIKIŞI",
                'aciklama' => $alislar["aciklama"],
                'giren_miktar' => 0,
                'cikan_miktar' => $alislar["miktar"],
                'alis_tutar' => 0,
                'fiyat' => $alislar["birim_fiyat"],
                'kdv_fiyat' => $alislar["kdv_tutar"],
                'satis_tutar' => $ara_toplam
            ];
            array_push($cok_kibarsin, $arr);
        }
    }

    $alis_faturasi = DB::all_data("
SELECT
au.miktar,
ad.aciklama,
ad.fatura_tarihi,
ad.genel_toplam,
ad.fatura_no,
au.kdv_tutari,
au.birim_fiyat
FROM
alis_default as ad
INNER JOIN alis_urunler as au on au.alis_defaultid=ad.id
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.fatura_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($alis_faturasi > 0) {
        foreach ($alis_faturasi as $alislar) {
            $ara_toplam = $alislar["miktar"] * $alislar["birim_fiyat"];
            $arr2 = [
                'birim_fiyat' => $alislar["birim_fiyat"],
                'miktar' => $alislar["miktar"],
                'tarih' => $alislar["fatura_tarihi"]
            ];
            array_push($alislar_arr, $arr2);
            $arr = [
                'tarih' => $alislar["fatura_tarihi"],
                'belge_no' => $alislar["fatura_no"],
                'belge_turu' => "Alış Faturası",
                'aciklama' => $alislar["aciklama"],
                'giren_miktar' => $alislar["miktar"],
                'cikan_miktar' => 0,
                'alis_tutar' => $ara_toplam,
                'fiyat' => $alislar["birim_fiyat"],
                'kdv_fiyat' => $alislar["kdv_tutari"],
                'satis_tutar' => 0
            ];
            array_push($cok_kibarsin, $arr);
        }
    }

//    $sql = "
//SELECT
//au.miktar,
//ad.aciklama,
//ad.fatura_tarihi,
//ad.genel_toplam,
//ad.fatura_no,
//au.kdv_tutari,
//au.birim_fiyat
//FROM
//     alis_default as ad
//INNER JOIN alis_urunler AS au on au.alis_defaultid=ad.id
//WHERE ad.status=1 AND au.status=1 and ad.cari_key='$cari_key' AND ad.fatura_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' AND au.stok_id='$kasa_id'";
//    $faturalar = DBD::all_data($sql);
//    if ($faturalar > 0) {
//        foreach ($faturalar as $alislar) {
//            $ara_toplam = $alislar["miktar"] * $alislar["birim_fiyat"];
//            $arr = [
//                'tarih' => $alislar["fatura_tarihi"],
//                'belge_no' => $alislar["fatura_no"],
//                'belge_turu' => "Depo Alış Faturası",
//                'aciklama' => $alislar["aciklama"],
//                'giren_miktar' => $alislar["miktar"],
//                'cikan_miktar' => 0,
//                'alis_tutar' => $ara_toplam,
//                'fiyat' => $alislar["birim_fiyat"],
//                'kdv_fiyat' => $alislar["kdv_tutari"],
//                'satis_tutar' => 0
//            ];
//            array_push($cok_kibarsin, $arr);
//        }
//    }
//
//    $sql = "
//SELECT
//au.miktar,
//ad.aciklama,
//ad.fatura_tarihi,
//ad.genel_toplam,
//ad.fatura_no,
//au.kdv_tutari,
//au.birim_fiyat
//FROM
//     satis_default as ad
//INNER JOIN satis_urunler as au on au.satis_defaultid=ad.id
//WHERE ad.status=1 AND au.status=1 and ad.cari_key='$cari_key' AND ad.fatura_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' AND au.stok_id='$kasa_id'";
//    $faturalar = DBD::all_data($sql);
//    if ($faturalar > 0) {
//        foreach ($faturalar as $alislar) {
//            $ara_toplam = $alislar["miktar"] * $alislar["birim_fiyat"];
//            $arr = [
//                'tarih' => $alislar["fatura_tarihi"],
//                'belge_no' => $alislar["fatura_no"],
//                'belge_turu' => "Depo Satış Faturası",
//                'aciklama' => $alislar["aciklama"],
//                'giren_miktar' => 0,
//                'cikan_miktar' => $alislar["miktar"],
//                'alis_tutar' => 0,
//                'fiyat' => $alislar["birim_fiyat"],
//                'kdv_fiyat' => $alislar["kdv_tutari"],
//                'satis_tutar' => $ara_toplam
//            ];
//            array_push($cok_kibarsin, $arr);
//        }
//    }

    $alis_faturasi = DB::all_data("
SELECT
miktar,
birim_fiyat,
aciklama,
tarih
FROM
stok_sayim_fazlasi
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key' AND tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($alis_faturasi > 0) {
        foreach ($alis_faturasi as $alislar) {
            $ara_toplam = $alislar["miktar"] * $alislar["birim_fiyat"];
            $arr2 = [
                'birim_fiyat' => $alislar["birim_fiyat"],
                'miktar' => $alislar["miktar"],
                'tarih' => $alislar["tarih"]
            ];
            array_push($alislar_arr, $arr2);
            $arr = [
                'tarih' => $alislar["tarih"],
                'belge_no' => "",
                'belge_turu' => "STOK SAYIM FAZLASI",
                'aciklama' => $alislar["aciklama"],
                'giren_miktar' => $alislar["miktar"],
                'cikan_miktar' => 0,
                'alis_tutar' => $ara_toplam,
                'fiyat' => $alislar["birim_fiyat"],
                'kdv_fiyat' => 0,
                'satis_tutar' => 0
            ];
            array_push($cok_kibarsin, $arr);
        }
    }

    $lastik_alis_fat = DB::all_data("
SELECT
lafu.miktar,
lafu.birim_fiyat,
laf.fatura_no,
laf.fatura_tarihi,
laf.aciklama,
lafu.kdv_toplam
FROM
lastik_alis_fatura_urunler as lafu
INNER JOIN lastik_alis_fatura as laf on laf.id=lafu.fatura_id 
WHERE laf.status=1 AND lafu.status=1 AND lafu.stok_id='$kasa_id' AND laf.cari_key='$cari_key' AND laf.fatura_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($lastik_alis_fat > 0) {
        foreach ($lastik_alis_fat as $alislar) {
            $ara_toplam = $alislar["miktar"] * $alislar["birim_fiyat"];
            $arr2 = [
                'birim_fiyat' => $alislar["birim_fiyat"],
                'miktar' => $alislar["miktar"],
                'tarih' => $alislar["fatura_tarihi"]
            ];
            array_push($alislar_arr, $arr2);
            $arr = [
                'tarih' => $alislar["fatura_tarihi"],
                'belge_no' => $alislar["fatura_no"],
                'belge_turu' => "Lastik Alış Faturası",
                'aciklama' => $alislar["aciklama"],
                'giren_miktar' => $alislar["miktar"],
                'cikan_miktar' => 0,
                'alis_tutar' => $ara_toplam,
                'fiyat' => $alislar["birim_fiyat"],
                'kdv_fiyat' => $alislar["kdv_toplam"],
                'satis_tutar' => 0
            ];
            array_push($cok_kibarsin, $arr);
        }
    }


    $lastik_alis_irsaliye = DB::all_data("
SELECT
lafu.miktar,
lafu.birim_fiyat,
laf.irsaliye_no,
laf.irsaliye_tarih,
laf.aciklama,
lafu.kdv_toplam
FROM
lastik_alis_irsaliye_urunler as lafu
INNER JOIN lastik_alis_irsaliye as laf on laf.id=lafu.irsaliye_id
WHERE laf.status=1 AND lafu.status=1 AND lafu.stok_id='$kasa_id' AND laf.cari_key='$cari_key' AND laf.irsaliye_tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($lastik_alis_irsaliye > 0) {
        foreach ($lastik_alis_irsaliye as $alislar) {
            $ara_toplam = $alislar["miktar"] * $alislar["birim_fiyat"];
            $arr2 = [
                'birim_fiyat' => $alislar["birim_fiyat"],
                'miktar' => $alislar["miktar"],
                'tarih' => $alislar["irsaliye_tarih"]
            ];
            array_push($alislar_arr, $arr2);
            $arr = [
                'tarih' => $alislar["irsaliye_tarih"],
                'belge_no' => $alislar["irsaliye_no"],
                'belge_turu' => "Lastik Alış İrsaliyesi",
                'aciklama' => $alislar["aciklama"],
                'giren_miktar' => $alislar["miktar"],
                'cikan_miktar' => 0,
                'alis_tutar' => $ara_toplam,
                'fiyat' => $alislar["birim_fiyat"],
                'kdv_fiyat' => $alislar["kdv_toplam"],
                'satis_tutar' => 0
            ];
            array_push($cok_kibarsin, $arr);
        }
    }

    $lastik_tak = DB::all_data("
SELECT
alt.*,
ak.plaka_no
FROM
arac_lastik_tak as alt
LEFT JOIN arac_kartlari as ak on ak.id=alt.arac_id
WHERE alt.status=1 AND alt.stok_id='$kasa_id' AND alt.cari_key='$cari_key' AND alt.insert_datetime BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($lastik_tak > 0) {
        foreach ($lastik_tak as $alislar) {
            $arr = [
                'tarih' => $alislar["insert_datetime"],
                'belge_no' => $alislar["plaka_no"],
                'belge_turu' => "Araç Lastik Takımı",
                'aciklama' => $alislar["takilacagi_yer"] . "_" . $alislar["dot_no"] . "_" . $alislar["arac_km"],
                'giren_miktar' => 0,
                'cikan_miktar' => 1,
                'alis_tutar' => 0,
                'fiyat' => 0,
                'kdv_fiyat' => 0,
                'satis_tutar' => 0
            ];
            array_push($cok_kibarsin, $arr);
        }
    }
    $yakit_cikislari = DB::all_data("
SELECT
miktar,
fis_no,
tarih,
aciklama,
tl_tutar,
litre_fiyati
FROM
yakit_cikis_fisleri 
WHERE status!=0 AND stok_id='$kasa_id' AND tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($yakit_cikislari > 0) {
        foreach ($yakit_cikislari as $alislar) {
            $ara_toplam = $alislar["miktar"] * $alislar["litre_fiyati"];
            $arr = [
                'tarih' => $alislar["tarih"],
                'belge_no' => $alislar["fis_no"],
                'belge_turu' => "Yakıt Çıkış",
                'aciklama' => $alislar["aciklama"],
                'giren_miktar' => 0,
                'cikan_miktar' => $alislar["miktar"],
                'fiyat' => $alislar["litre_fiyati"],
                'kdv_fiyat' => 0,
                'alis_tutar' => 0,
                'satis_tutar' => $ara_toplam
            ];
            array_push($cok_kibarsin, $arr);
        }
    }
    $perakende_satislar = DB::all_data("
SELECT
psu.miktar,
psu.insert_datetime,
ps.aciklama,
psu.birim_fiyat,
psu.kdv_tutar
FROM
perakende_satis_urunler as psu
INNER JOIN perakende_satis as ps on ps.id=psu.satis_id
WHERE psu.status=1 AND ps.status=1 AND psu.stok_kodu='$stok_kodu' AND psu.cari_key='$cari_key' AND psu.insert_datetime BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($perakende_satislar > 0) {
        foreach ($perakende_satislar as $alislar) {
            $ara_toplam = $alislar["miktar"] * $alislar["birim_fiyat"];
            $arr = [
                'tarih' => $alislar["insert_datetime"],
                'belge_no' => "",
                'belge_turu' => "Perakende Satış",
                'aciklama' => $alislar["aciklama"],
                'giren_miktar' => 0,
                'cikan_miktar' => $alislar["miktar"],
                'kdv_fiyat' => $alislar["kdv_tutar"],
                'fiyat' => $alislar["birim_fiyat"],
                'alis_tutar' => 0,
                'satis_tutar' => $ara_toplam
            ];
            array_push($cok_kibarsin, $arr);
        }
    }
    $alis_faturasi = DB::all_data("
SELECT
au.miktar,
ad.aciklama,
ad.irsaliye_tarihi,
ad.irsaliye_no,
au.birim_fiyat,
au.kdv_tutari
FROM
alis_irsaliye as ad
INNER JOIN alis_irsaliye_urunler as au on au.irsaliye_id=ad.id
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.irsaliye_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($alis_faturasi > 0) {
        foreach ($alis_faturasi as $alislar) {
            $arr2 = [
                'birim_fiyat' => $alislar["birim_fiyat"],
                'miktar' => $alislar["miktar"],
                'tarih' => $alislar["irsaliye_tarihi"]
            ];
            array_push($alislar_arr, $arr2);
            $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
            $arr = [
                'tarih' => $alislar["irsaliye_tarihi"],
                'belge_no' => $alislar["irsaliye_no"],
                'belge_turu' => "Alış İrsaliyesi",
                'aciklama' => $alislar["aciklama"],
                'giren_miktar' => $alislar["miktar"],
                'kdv_fiyat' => $alislar["kdv_tutari"],
                'cikan_miktar' => 0,
                'alis_tutar' => $ara_toplam,
                'fiyat' => $alislar["birim_fiyat"],
                'satis_tutar' => 0
            ];
            array_push($cok_kibarsin, $arr);
        }
    }

    $satis_faturalari = DB::all_data("
SELECT
au.miktar,
ad.aciklama,
ad.fatura_tarihi,
ad.fatura_no,
au.birim_fiyat,
au.kdv_tutari
FROM
satis_default as ad
INNER JOIN satis_urunler as au on au.satis_defaultid=ad.id
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.fatura_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $ara_toplam = $alislar["miktar"] * $alislar["birim_fiyat"];
            $arr = [
                'tarih' => $alislar["fatura_tarihi"],
                'belge_no' => $alislar["fatura_no"],
                'belge_turu' => "Satış Faturası",
                'aciklama' => $alislar["aciklama"],
                'giren_miktar' => 0,
                'cikan_miktar' => $alislar["miktar"],
                'kdv_fiyat' => $alislar["kdv_tutari"],
                'alis_tutar' => 0,
                'fiyat' => $alislar["birim_fiyat"],
                'satis_tutar' => $ara_toplam
            ];
            array_push($cok_kibarsin, $arr);
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
au.miktar,
ad.aciklama,
ad.irsaliye_tarihi,
ad.irsaliye_no,
au.birim_fiyat,
au.kdv_tutari
FROM
satis_irsaliye as ad
INNER JOIN satis_irsaliye_urunler as au on au.irsaliye_id=ad.id
WHERE ad.status!=0 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.irsaliye_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $ara_toplam = $alislar["miktar"] * $alislar["birim_fiyat"];
            $arr = [
                'tarih' => $alislar["irsaliye_tarihi"],
                'belge_no' => $alislar["irsaliye_no"],
                'belge_turu' => "Satış İrsaliyesi",
                'aciklama' => $alislar["aciklama"],
                'giren_miktar' => 0,
                'cikan_miktar' => $alislar["miktar"],
                'fiyat' => $alislar["birim_fiyat"],
                'kdv_fiyat' => $alislar["kdv_tutari"],
                'alis_tutar' => 0,
                'satis_tutar' => $ara_toplam
            ];
            array_push($cok_kibarsin, $arr);
        }
    }
    $acilis_fisi = DB::all_data("
SELECT
miktar,
aciklama,
insert_datetime,
alis_fiyat,
acilis_tarih
FROM
stok_acilis_fisleri
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key' AND acilis_tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($acilis_fisi > 0) {
        foreach ($acilis_fisi as $alislar) {
            $ara_toplam = $alislar["alis_fiyat"] * $alislar["miktar"];
            $alis_toplam += $ara_toplam;
            $arr2 = [
                'birim_fiyat' => $alislar["alis_fiyat"],
                'miktar' => $alislar["miktar"],
                'tarih' => $alislar["acilis_tarih"]
            ];
            array_push($alislar_arr, $arr2);
            $arr = [
                'tarih' => $alislar["acilis_tarih"],
                'belge_no' => "",
                'belge_turu' => "Stok Açılış Fişi",
                'aciklama' => $alislar["aciklama"],
                'giren_miktar' => $alislar["miktar"],
                'cikan_miktar' => 0,
                'alis_tutar' => $ara_toplam,
                'fiyat' => $alislar["alis_fiyat"],
                'kdv_fiyat' => 0,
                'satis_tutar' => 0
            ];
            array_push($cok_kibarsin, $arr);
        }
    }
    $acilis_fisi = DB::all_data("
SELECT
miktar,
aciklama,
birim_fiyat,
insert_datetime
FROM
stok_fire
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key' AND insert_datetime BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($acilis_fisi > 0) {
        foreach ($acilis_fisi as $alislar) {

            $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
            $arr = [
                'tarih' => $alislar["insert_datetime"],
                'belge_no' => "",
                'belge_turu' => "Stok Fire Çıkışı",
                'aciklama' => $alislar["aciklama"],
                'giren_miktar' => 0,
                'cikan_miktar' => $alislar["miktar"],
                'alis_tutar' => 0,
                'kdv_fiyat' => 0,
                'fiyat' => $alislar["birim_fiyat"],
                'satis_tutar' => $ara_toplam
            ];
            array_push($cok_kibarsin, $arr);
        }
    }
    usort($cok_kibarsin, function ($a, $b) {
        $tarihA = strtotime($a['tarih']); // $a dizisindeki tarih değerini alıp zaman damgasına dönüştür
        $tarihB = strtotime($b['tarih']);
        if ($tarihA == $tarihB) {
            return 0;
        }

        return ($tarihA < $tarihB) ? -1 : 1;
    });


    usort($alislar_arr, function ($a, $b) {
        $tarihA = strtotime($a['tarih']); // $a dizisindeki tarih değerini alıp zaman damgasına dönüştür
        $tarihB = strtotime($b['tarih']);
        if ($tarihA == $tarihB) {
            return 0;
        }

        return ($tarihA < $tarihB) ? -1 : 1;
    });
    $gonderilen_ekstre_arr = [];
    array_push($gonderilen_ekstre_arr, $ekstre_arr[0]);
    if ($cok_kibarsin > 0) {
        foreach ($cok_kibarsin as $item) {
            if ($item["belge_turu"] == "Alış İrsaliyesi") {

                $kasa_devir_kalan_miktar += $item["giren_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'giren_miktar' => $item["giren_miktar"],
                    'cikan_miktar' => 0,
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'fiyat' => $item["fiyat"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "Alış Faturası") {

                $kasa_devir_kalan_miktar += $item["giren_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'fiyat' => $item["fiyat"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'giren_miktar' => $item["giren_miktar"],
                    'cikan_miktar' => 0,
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "Depo Alış Faturası") {

                $kasa_devir_kalan_miktar += $item["giren_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'fiyat' => $item["fiyat"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'giren_miktar' => $item["giren_miktar"],
                    'cikan_miktar' => 0,
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "STOK SAYIM FAZLASI") {

                $kasa_devir_kalan_miktar += $item["giren_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'fiyat' => $item["fiyat"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'giren_miktar' => $item["giren_miktar"],
                    'cikan_miktar' => 0,
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "Lastik Alış Faturası") {

                $kasa_devir_kalan_miktar += $item["giren_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'fiyat' => $item["fiyat"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'giren_miktar' => $item["giren_miktar"],
                    'cikan_miktar' => 0,
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "Lastik Alış İrsaliyesi") {

                $kasa_devir_kalan_miktar += $item["giren_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'fiyat' => $item["fiyat"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'giren_miktar' => $item["giren_miktar"],
                    'cikan_miktar' => 0,
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "Satış Faturası") {
                $kasa_devir_kalan_miktar -= $item["cikan_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'fiyat' => $item["fiyat"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'giren_miktar' => 0,
                    'cikan_miktar' => $item["cikan_miktar"],
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "Depo Satış Faturası") {
                $kasa_devir_kalan_miktar -= $item["cikan_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'fiyat' => $item["fiyat"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'giren_miktar' => 0,
                    'cikan_miktar' => $item["cikan_miktar"],
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "ARACA STOK ÇIKIŞI") {
                $kasa_devir_kalan_miktar -= $item["cikan_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'fiyat' => $item["fiyat"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'giren_miktar' => 0,
                    'cikan_miktar' => $item["cikan_miktar"],
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "Satış İrsaliyesi") {
                $kasa_devir_kalan_miktar -= $item["cikan_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'fiyat' => $item["fiyat"],
                    'belge_turu' => $item["belge_turu"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'aciklama' => $item["aciklama"],
                    'giren_miktar' => 0,
                    'cikan_miktar' => $item["cikan_miktar"],
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "Perakende Satış") {
                $kasa_devir_kalan_miktar -= $item["cikan_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'belge_turu' => $item["belge_turu"],
                    'fiyat' => $item["fiyat"],
                    'aciklama' => $item["aciklama"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'giren_miktar' => 0,
                    'cikan_miktar' => $item["cikan_miktar"],
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "Alış İrsaliye") {

                $kasa_devir_kalan_miktar += $item["giren_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'fiyat' => $item["fiyat"],
                    'belge_turu' => $item["belge_turu"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'aciklama' => $item["aciklama"],
                    'giren_miktar' => $item["giren_miktar"],
                    'cikan_miktar' => 0,
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);


            } else if ($item["belge_turu"] == "Satış İrsaliye") {

                $kasa_devir_kalan_miktar -= $item["cikan_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'fiyat' => $item["fiyat"],
                    'belge_turu' => $item["belge_turu"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'aciklama' => $item["aciklama"],
                    'giren_miktar' => 0,
                    'cikan_miktar' => $item["cikan_miktar"],
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "Yakıt Çıkış") {

                $kasa_devir_kalan_miktar -= $item["cikan_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'fiyat' => $item["fiyat"],
                    'belge_turu' => $item["belge_turu"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'aciklama' => $item["aciklama"],
                    'giren_miktar' => 0,
                    'cikan_miktar' => $item["cikan_miktar"],
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "Araç Lastik Takımı") {

                $kasa_devir_kalan_miktar -= $item["cikan_miktar"];
                $birim_fiyat = 0;
                $yeni_kalan = $kasa_devir_kalan_miktar;
                foreach ($alislar_arr as $item2) {
                    if ($yeni_kalan < $item2["miktar"]) {
                        $yeni_kalan -= $item2["miktar"];
                        $arr = [
                            'tarih' => $item["tarih"],
                            'belge_no' => $item["belge_no"],
                            'fiyat' => $item2["birim_fiyat"],
                            'belge_turu' => $item["belge_turu"],
                            'kdv_fiyat' => $item["kdv_fiyat"],
                            'aciklama' => $item["aciklama"],
                            'giren_miktar' => 0,
                            'cikan_miktar' => $item["cikan_miktar"],
                            'kalan_miktar' => $kasa_devir_kalan_miktar,
                            'alis_tutar' => $item["alis_tutar"],
                            'satis_tutar' => $item2["birim_fiyat"]
                        ];
                        array_push($gonderilen_ekstre_arr, $arr);
                    } else {
                        $arr = [
                            'tarih' => $item["tarih"],
                            'belge_no' => $item["belge_no"],
                            'fiyat' => $item["fiyat"],
                            'belge_turu' => $item["belge_turu"],
                            'kdv_fiyat' => $item["kdv_fiyat"],
                            'aciklama' => $item["aciklama"],
                            'giren_miktar' => 0,
                            'cikan_miktar' => $item["cikan_miktar"],
                            'kalan_miktar' => $kasa_devir_kalan_miktar,
                            'alis_tutar' => $item["alis_tutar"],
                            'satis_tutar' => $item["satis_tutar"]
                        ];
                        array_push($gonderilen_ekstre_arr, $arr);
                    }
                }


            } else if ($item["belge_turu"] == "Stok Açılış Fişi") {
                $kasa_devir_kalan_miktar += $item["giren_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'belge_turu' => $item["belge_turu"],
                    'fiyat' => $item["fiyat"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'aciklama' => $item["aciklama"],
                    'giren_miktar' => $item["giren_miktar"],
                    'cikan_miktar' => 0,
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);
            } else if ($item["belge_turu"] == "Stok Fire Çıkışı") {

                $kasa_devir_kalan_miktar -= $item["cikan_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'fiyat' => $item["fiyat"],
                    'belge_turu' => $item["belge_turu"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'aciklama' => $item["aciklama"],
                    'giren_miktar' => 0,
                    'cikan_miktar' => $item["cikan_miktar"],
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);
            }
        }
    }
    if ($gonderilen_ekstre_arr > 0) {
        echo json_encode($gonderilen_ekstre_arr);
    }
}
if ($islem == "stok_genel_ekstre") {
    $bas_tarih = $_GET["bas_tarih"];
    $bit_tarih = $_GET["bit_tarih"];
    $ekstre_arr = [];

    $stoklar = DB::all_data("SELECT stok.*,marka.marka_adi,sag.ana_grup_adi,salt.altgrup_adi,model.model_adi,b.birim_adi FROM stok
LEFT JOIN stok_ana_grup as sag on sag.id=stok.stok_ana_grupid
LEFT JOIN stok_alt_grup as salt on salt.id=stok.stok_alt_grupid
LEFT JOIN marka on marka.id=stok.marka
LEFT JOIN model on model.id=stok.model
LEFT JOIN birim as b on b.id=stok.birim
WHERE stok.status=1 and stok.cari_key='$cari_key' AND stok.stok_turu!=3");

    $last_birim_fiyat = 0;
    foreach ($stoklar as $item) {
        $alislar_arr = [];
        $kasa_id = $item["id"];
        $kasa_devir_giren_miktar = 0;
        $kasa_devir_cikan_miktar = 0;
        $alis_tutar = 0;
        $satis_tutar = 0;
        $maliyet_tutar = 0;


        $alis_faturasi = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat,
ad.fatura_tarihi
FROM
alis_default as ad
INNER JOIN alis_urunler as au on au.alis_defaultid=ad.id
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' AND ad.irsaliye_ids=''
");
        if ($alis_faturasi > 0) {
            foreach ($alis_faturasi as $alislar) {
                $kasa_devir_giren_miktar += $alislar["miktar"];
                $arr3 = [
                    'birim_fiyat' => $alislar["birim_fiyat"],
                    'aktif_miktar' => $alislar["miktar"],
                    'tarih' => $alislar["fatura_tarihi"]
                ];
                $last_birim_fiyat = $alislar["birim_fiyat"];
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $alis_tutar += $ara_toplam;
                $maliyet_tutar += $ara_toplam;
                array_push($alislar_arr, $arr3);
            }
        }

        $stok_cikisi = DB::all_data("
    SELECT
    asu.miktar,
    asu.birim_fiyat
    FROM
    araclara_stok_cik as arac
    INNER JOIN araclara_stok_urunler as asu on asu.ana_id=arac.id
    INNER JOIN arac_kartlari as ak on ak.id=asu.plaka_id
    WHERE arac.status=1 AND asu.status=1 AND arac.cari_key='$cari_key' AND asu.stok_id='$kasa_id' AND arac.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
    ");
        if ($stok_cikisi > 0) {
            foreach ($stok_cikisi as $alislar) {
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $satis_tutar += $ara_toplam;
                $kasa_devir_cikan_miktar += $alislar["miktar"];
            }
        }

        $alis_faturasi = DB::all_data("
SELECT
miktar,
birim_fiyat,
miktar,
tarih
FROM
stok_sayim_fazlasi
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key' AND tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
        if ($alis_faturasi > 0) {
            foreach ($alis_faturasi as $alislar) {
                $kasa_devir_giren_miktar += $alislar["miktar"];
                $arr3 = [
                    'birim_fiyat' => $alislar["birim_fiyat"],
                    'aktif_miktar' => $alislar["miktar"],
                    'tarih' => $alislar["tarih"]
                ];
                $last_birim_fiyat = $alislar["birim_fiyat"];
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $alis_tutar += $ara_toplam;
                $maliyet_tutar += $ara_toplam;
                array_push($alislar_arr, $arr3);
            }
        }
        $stok_kodu = $item["stok_kodu"];
        $perakende_satislar = DB::all_data("
SELECT
psu.miktar,
psu.birim_fiyat
FROM
perakende_satis_urunler as psu
INNER JOIN perakende_satis as ps on ps.id=psu.satis_id
WHERE psu.status=1 AND ps.status=1 AND psu.stok_kodu='$stok_kodu' AND psu.cari_key='$cari_key' AND psu.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
        if ($perakende_satislar > 0) {
            foreach ($perakende_satislar as $alislar) {
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $satis_tutar += $ara_toplam;
                $kasa_devir_cikan_miktar += $alislar["miktar"];
            }
        }

        $satis_faturalari = DB::all_data("
SELECT
miktar,
tl_tutar
FROM
yakit_cikis_fisleri 
WHERE status!=0 AND tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' AND stok_id='$kasa_id'
");
        if ($satis_faturalari > 0) {
            foreach ($satis_faturalari as $alislar) {
                $satis_tutar += $alislar["tl_tutar"];
                $kasa_devir_cikan_miktar += $alislar["miktar"];
            }
        }
        $satis_faturalari = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat
FROM
satis_default as ad
INNER JOIN satis_urunler as au on au.satis_defaultid=ad.id
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' AND ad.irsaliye_ids=''
");
        if ($satis_faturalari > 0) {
            foreach ($satis_faturalari as $alislar) {
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $satis_tutar += $ara_toplam;

                $kasa_devir_cikan_miktar += $alislar["miktar"];
            }
        }
        $alis_irsaliye = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat,
ad.irsaliye_tarihi
FROM
alis_irsaliye as ad
INNER JOIN alis_irsaliye_urunler as au on au.irsaliye_id=ad.id
WHERE ad.status!=0 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.irsaliye_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
        if ($alis_irsaliye > 0) {
            foreach ($alis_irsaliye as $alislar) {
                $kasa_devir_giren_miktar += $alislar["miktar"];
                $arr3 = [
                    'birim_fiyat' => $alislar["birim_fiyat"],
                    'aktif_miktar' => $alislar["miktar"],
                    'tarih' => $alislar["irsaliye_tarihi"]
                ];
                $last_birim_fiyat = $alislar["birim_fiyat"];
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $alis_tutar += $ara_toplam;
                $maliyet_tutar += $ara_toplam;
                array_push($alislar_arr, $arr3);
            }
        }
        $satis_irsaliye = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat
FROM
satis_irsaliye as ad
INNER JOIN satis_irsaliye_urunler as au on au.irsaliye_id=ad.id
WHERE ad.status!=0 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.irsaliye_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
        if ($satis_irsaliye > 0) {
            foreach ($satis_irsaliye as $alislar) {
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $satis_tutar += $ara_toplam;

                $kasa_devir_cikan_miktar += $alislar["miktar"];
            }
        }
        $stok_acilis_fisleri = DB::all_data("
SELECT
miktar,
alis_fiyat,
acilis_tarih
FROM
stok_acilis_fisleri
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key' AND acilis_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
        if ($stok_acilis_fisleri > 0) {
            foreach ($stok_acilis_fisleri as $alislar) {
                $kasa_devir_giren_miktar += $alislar["miktar"];
                $arr3 = [
                    'birim_fiyat' => $alislar["alis_fiyat"],
                    'aktif_miktar' => $alislar["miktar"],
                    'tarih' => $alislar["acilis_tarih"]
                ];
                $last_birim_fiyat = $alislar["alis_fiyat"];
                $ara_toplam = $alislar["alis_fiyat"] * $alislar["miktar"];
                $alis_tutar += $ara_toplam;
                $maliyet_tutar += $ara_toplam;
                array_push($alislar_arr, $arr3);
            }
        }

        $lastik_alis_fat = DB::all_data("
SELECT
lafu.miktar,
lafu.birim_fiyat,
laf.fatura_tarihi
FROM
lastik_alis_fatura_urunler as lafu
INNER JOIN lastik_alis_fatura as laf on laf.id=lafu.fatura_id 
WHERE laf.status=1 AND lafu.status=1 AND lafu.stok_id='$kasa_id' AND laf.cari_key='$cari_key' AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
        if ($lastik_alis_fat > 0) {
            foreach ($lastik_alis_fat as $alislar) {
                $kasa_devir_giren_miktar += $alislar["miktar"];
                $arr3 = [
                    'birim_fiyat' => $alislar["birim_fiyat"],
                    'aktif_miktar' => $alislar["miktar"],
                    'tarih' => $alislar["fatura_tarihi"]
                ];
                $last_birim_fiyat = $alislar["birim_fiyat"];
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $alis_tutar += $ara_toplam;
                $maliyet_tutar += $ara_toplam;
                array_push($alislar_arr, $arr3);
            }
        }
        $lastik_alis_irsaliye = DB::all_data("
SELECT
lafu.miktar,
lafu.birim_fiyat,
laf.irsaliye_tarih
FROM
lastik_alis_irsaliye_urunler as lafu
INNER JOIN lastik_alis_irsaliye as laf on laf.id=lafu.irsaliye_id
WHERE laf.status=1 AND lafu.status=1 AND lafu.stok_id='$kasa_id' AND laf.cari_key='$cari_key' AND laf.irsaliye_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
        if ($lastik_alis_irsaliye > 0) {
            foreach ($lastik_alis_irsaliye as $alislar) {
                $kasa_devir_giren_miktar += $alislar["miktar"];
                $arr3 = [
                    'birim_fiyat' => $alislar["birim_fiyat"],
                    'aktif_miktar' => $alislar["miktar"],
                    'tarih' => $alislar["irsaliye_tarih"]
                ];
                $last_birim_fiyat = $alislar["birim_fiyat"];
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $alis_tutar += $ara_toplam;
                $maliyet_tutar += $ara_toplam;
                array_push($alislar_arr, $arr3);
            }
        }

        $acilis_fisi = DB::all_data("
SELECT
miktar,
birim_fiyat
FROM
stok_fire
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key' AND insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
        if ($acilis_fisi > 0) {
            foreach ($acilis_fisi as $alislar) {
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $satis_tutar += $ara_toplam;
                $kasa_devir_cikan_miktar += $alislar["miktar"];
            }
        }


        $lastik_tak = DB::all_data("
SELECT
*
FROM
arac_lastik_tak
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key' AND insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
        if ($lastik_tak > 0) {
            foreach ($lastik_tak as $alislar) {
                $kasa_devir_cikan_miktar += 1;

                usort($alislar_arr, function ($a, $b) {
                    $tarihA = strtotime($a['tarih']); // $a dizisindeki tarih değerini alıp zaman damgasına dönüştür
                    $tarihB = strtotime($b['tarih']);
                    if ($tarihA == $tarihB) {
                        return 0;
                    }

                    return ($tarihA > $tarihB) ? -1 : 1;
                });
                foreach ($alislar_arr as $maliyetler) {

                    if ($devirli_miktar > $maliyetler["aktif_miktar"]) {
                        $devirli_miktar -= $maliyetler["aktif_miktar"];
                        $satis_tutar += $maliyetler["birim_fiyat"];
                    } else {
                        $satis_tutar += $maliyetler["birim_fiyat"];
                        break;
                    }
                }
            }
        }

        $kasa_devir_kalan_miktar = floatval($kasa_devir_giren_miktar) - floatval($kasa_devir_cikan_miktar);
        $devirli_miktar = $kasa_devir_kalan_miktar;
        $elimdeki_maliyet = 0;

        usort($alislar_arr, function ($a, $b) {
            $tarihA = strtotime($a['tarih']); // $a dizisindeki tarih değerini alıp zaman damgasına dönüştür
            $tarihB = strtotime($b['tarih']);
            if ($tarihA == $tarihB) {
                return 0;
            }

            return ($tarihA > $tarihB) ? -1 : 1;
        });
        foreach ($alislar_arr as $maliyetler) {

            if ($devirli_miktar > $maliyetler["aktif_miktar"]) {
                $devirli_miktar -= $maliyetler["aktif_miktar"];
                $elimdeki_maliyet += $maliyetler["aktif_miktar"] * $maliyetler["birim_fiyat"];
            } else {
                $elimdeki_maliyet += $devirli_miktar * $maliyetler["birim_fiyat"];
                break;
            }
        }
        $kasa_devir_kalan_miktar = 0;
        $arr = [
            'stok_kodu' => $item["stok_kodu"],
            'stok_adi' => $item["stok_adi"],
            'barkod' => $item["barkod"],
            'birim_adi' => $item["birim_adi"],
            'ana_grup_adi' => $item["ana_grup_adi"],
            'altgrup_adi' => $item["altgrup_adi"],
            'elimdeki_maliyet' => $elimdeki_maliyet,
            'giren_miktar' => $kasa_devir_giren_miktar,
            'satis_tutar' => $satis_tutar,
            'alis_tutar' => $alis_tutar,
            'maliyet_tutar' => $maliyet_tutar,
            'cikan_miktar' => $kasa_devir_cikan_miktar,
            'kalan_miktar' => $kasa_devir_kalan_miktar
        ];
        array_push($ekstre_arr, $arr);


    }
    if ($ekstre_arr > 0) {
        echo json_encode($ekstre_arr);
    } else {
        echo 2;
    }
}
if ($islem == "hizmet_genel_ekstre") {
    $bas_tarih = $_GET["bas_tarih"];
    $bit_tarih = $_GET["bit_tarih"];
    $ekstre_arr = [];

    $stoklar = DB::all_data("SELECT stok.*,marka.marka_adi,sag.ana_grup_adi,salt.altgrup_adi,model.model_adi,b.birim_adi FROM stok
LEFT JOIN stok_ana_grup as sag on sag.id=stok.stok_ana_grupid
LEFT JOIN stok_alt_grup as salt on salt.id=stok.stok_alt_grupid
LEFT JOIN marka on marka.id=stok.marka
LEFT JOIN model on model.id=stok.model
LEFT JOIN birim as b on b.id=stok.birim
WHERE stok.status=1 and stok.cari_key='$cari_key' AND stok.stok_turu=3");
    $alislar_arr = [];
    $last_birim_fiyat = 0;
    foreach ($stoklar as $item) {
        $kasa_id = $item["id"];
        $kasa_devir_giren_miktar = 0;
        $kasa_devir_cikan_miktar = 0;
        $alis_tutar = 0;
        $satis_tutar = 0;
        $maliyet_tutar = 0;


        $alis_faturasi = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat,
ad.fatura_tarihi
FROM
alis_default as ad
INNER JOIN alis_urunler as au on au.alis_defaultid=ad.id
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' AND ad.irsaliye_ids=''
");
        if ($alis_faturasi > 0) {
            foreach ($alis_faturasi as $alislar) {
                $kasa_devir_giren_miktar += $alislar["miktar"];
                $arr3 = [
                    'birim_fiyat' => $alislar["birim_fiyat"],
                    'aktif_miktar' => $alislar["miktar"],
                    'tarih' => $alislar["fatura_tarihi"]
                ];
                $last_birim_fiyat = $alislar["birim_fiyat"];
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $alis_tutar += $ara_toplam;
                $maliyet_tutar += $ara_toplam;
                array_push($alislar_arr, $arr3);
            }
        }


//        $sql = "
//SELECT
//    au.miktar,
//    au.birim_fiyat,
//    ad.fatura_tarihi
//FROM
//     alis_default as ad
//INNER JOIN alis_urunler AS au on au.alis_defaultid=ad.id
//WHERE ad.status=1 AND au.status=1 and ad.cari_key='$cari_key' AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'  AND au.stok_id='$kasa_id'";
//        $faturalar = DBD::all_data($sql);
//        if ($faturalar > 0) {
//            foreach ($faturalar as $alislar) {
//                $kasa_devir_giren_miktar += $alislar["miktar"];
//                $arr3 = [
//                    'birim_fiyat' => $alislar["birim_fiyat"],
//                    'aktif_miktar' => $alislar["miktar"],
//                    'tarih' => $alislar["fatura_tarihi"]
//                ];
//                $last_birim_fiyat = $alislar["birim_fiyat"];
//                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
//                $alis_tutar += $ara_toplam;
//                $maliyet_tutar += $ara_toplam;
//                array_push($alislar_arr, $arr3);
//            }
//        }
//
//        $sql = "
//SELECT
//su.miktar,
//su.birim_fiyat
//FROM
//     satis_default as sd
//INNER JOIN satis_urunler as su on su.satis_defaultid=sd.id
//WHERE sd.status=1 AND su.status=1 and sd.cari_key='$cari_key' AND sd.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' AND su.stok_id='$kasa_id'";
//        $faturalar = DBD::all_data($sql);
//        if ($faturalar > 0) {
//            foreach ($faturalar as $alislar) {
//                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
//                $satis_tutar += $ara_toplam;
//                $kasa_devir_cikan_miktar += $alislar["miktar"];
//            }
//        }

        $alis_faturasi = DB::all_data("
SELECT
miktar,
birim_fiyat,
tarih
FROM
stok_sayim_fazlasi
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key' AND tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
        if ($alis_faturasi > 0) {
            foreach ($alis_faturasi as $alislar) {
                $kasa_devir_giren_miktar += $alislar["miktar"];
                $arr3 = [
                    'birim_fiyat' => $alislar["birim_fiyat"],
                    'aktif_miktar' => $alislar["miktar"],
                    'tarih' => $alislar["tarih"]
                ];
                $last_birim_fiyat = $alislar["birim_fiyat"];
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $alis_tutar += $ara_toplam;
                $maliyet_tutar += $ara_toplam;
                array_push($alislar_arr, $arr3);
            }
        }
        $stok_kodu = $item["stok_kodu"];
        $perakende_satislar = DB::all_data("
SELECT
psu.miktar,
psu.birim_fiyat
FROM
perakende_satis_urunler as psu
INNER JOIN perakende_satis as ps on ps.id=psu.satis_id
WHERE psu.status=1 AND ps.status=1 AND psu.stok_kodu='$stok_kodu' AND psu.cari_key='$cari_key' AND psu.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
        if ($perakende_satislar > 0) {
            foreach ($perakende_satislar as $alislar) {
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $satis_tutar += $ara_toplam;
                $kasa_devir_cikan_miktar += $alislar["miktar"];
            }
        }

        $satis_faturalari = DB::all_data("
SELECT
miktar,
tl_tutar
FROM
yakit_cikis_fisleri 
WHERE status!=0 AND tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' AND stok_id='$kasa_id'
");
        if ($satis_faturalari > 0) {
            foreach ($satis_faturalari as $alislar) {
                $satis_tutar += $alislar["tl_tutar"];
                $kasa_devir_cikan_miktar += $alislar["miktar"];
            }
        }
        $satis_faturalari = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat
FROM
satis_default as ad
INNER JOIN satis_urunler as au on au.satis_defaultid=ad.id
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' AND ad.irsaliye_ids=''
");
        if ($satis_faturalari > 0) {
            foreach ($satis_faturalari as $alislar) {
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $satis_tutar += $ara_toplam;

                $kasa_devir_cikan_miktar += $alislar["miktar"];
            }
        }
        $alis_irsaliye = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat
FROM
alis_irsaliye as ad
INNER JOIN alis_irsaliye_urunler as au on au.irsaliye_id=ad.id
WHERE ad.status!=0 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.irsaliye_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
        if ($alis_irsaliye > 0) {
            foreach ($alis_irsaliye as $alislar) {
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $alis_tutar += $ara_toplam;
                $maliyet_tutar += $ara_toplam;

                $kasa_devir_giren_miktar += $alislar["miktar"];
            }
        }
        $satis_irsaliye = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat
FROM
satis_irsaliye as ad
INNER JOIN satis_irsaliye_urunler as au on au.irsaliye_id=ad.id
WHERE ad.status!=0 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.irsaliye_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
        if ($satis_irsaliye > 0) {
            foreach ($satis_irsaliye as $alislar) {
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $satis_tutar += $ara_toplam;

                $kasa_devir_cikan_miktar += $alislar["miktar"];
            }
        }
        $acilis_fisi = DB::all_data("
SELECT
miktar,
alis_fiyat
FROM
stok_acilis_fisleri
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key' AND acilis_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
        if ($acilis_fisi > 0) {
            foreach ($acilis_fisi as $alislar) {
                $ara_toplam = $alislar["alis_fiyat"] * $alislar["miktar"];
                $alis_tutar += $ara_toplam;
                $maliyet_tutar += $ara_toplam;
                $kasa_devir_giren_miktar += $alislar["miktar"];
            }
        }
        $acilis_fisi = DB::all_data("
SELECT
miktar,
birim_fiyat
FROM
stok_fire
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key' AND insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
        if ($acilis_fisi > 0) {
            foreach ($acilis_fisi as $alislar) {
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $satis_tutar += $ara_toplam;
                $kasa_devir_cikan_miktar += $alislar["miktar"];
            }
        }
        $kasa_devir_kalan_miktar = 0;
        $kasa_devir_kalan_miktar = floatval($kasa_devir_giren_miktar) + floatval($kasa_devir_cikan_miktar);
        $devirli_miktar = $kasa_devir_kalan_miktar;
        $elimdeki_maliyet = 0;
        usort($alislar_arr, function ($a, $b) {
            $tarihA = strtotime($a['tarih']); // $a dizisindeki tarih değerini alıp zaman damgasına dönüştür
            $tarihB = strtotime($b['tarih']);
            if ($tarihA == $tarihB) {
                return 0;
            }

            return ($tarihA > $tarihB) ? -1 : 1;
        });
        foreach ($alislar_arr as $maliyetler) {

            if ($devirli_miktar > $maliyetler["aktif_miktar"]) {
                $devirli_miktar -= $maliyetler["aktif_miktar"];
                $elimdeki_maliyet += $maliyetler["aktif_miktar"] * $maliyetler["birim_fiyat"];
            } else {
                $elimdeki_maliyet += $devirli_miktar * $maliyetler["birim_fiyat"];
                break;
            }
        }
        $arr = [
            'stok_kodu' => $item["stok_kodu"],
            'stok_adi' => $item["stok_adi"],
            'barkod' => $item["barkod"],
            'birim_adi' => $item["birim_adi"],
            'ana_grup_adi' => $item["ana_grup_adi"],
            'altgrup_adi' => $item["altgrup_adi"],
            'elimdeki_maliyet' => $elimdeki_maliyet,
            'giren_miktar' => $kasa_devir_giren_miktar,
            'satis_tutar' => $satis_tutar,
            'alis_tutar' => $alis_tutar,
            'maliyet_tutar' => $maliyet_tutar,
            'cikan_miktar' => $kasa_devir_cikan_miktar,
            'kalan_miktar' => $kasa_devir_kalan_miktar
        ];
        array_push($ekstre_arr, $arr);


    }
    if ($ekstre_arr > 0) {
        echo json_encode($ekstre_arr);
    } else {
        echo 2;
    }
}
if ($islem == "stok_devir_hizi_getir_sql") {
    $stoklar = DB::all_data("SELECT stok.*,marka.marka_adi,sag.ana_grup_adi,salt.altgrup_adi,model.model_adi,b.birim_adi FROM stok
LEFT JOIN stok_ana_grup as sag on sag.id=stok.stok_ana_grupid
LEFT JOIN stok_alt_grup as salt on salt.id=stok.stok_alt_grupid
LEFT JOIN marka on marka.id=stok.marka
LEFT JOIN model on model.id=stok.model
LEFT JOIN birim as b on b.id=stok.birim
WHERE stok.status=1 and stok.cari_key='$cari_key' AND stok.stok_turu!=3");
    $alislar_arr = [];
    $ekstre_arr = [];
    $last_birim_fiyat = 0;
    $bas_tarih = $_GET["bas_tarih"];
    $bit_tarih = $_GET["bit_tarih"];
    $last_bas_tarih = $_GET["bas_tarih"];
    foreach ($stoklar as $item) {
        $kasa_id = $item["id"];
        $kasa_devir_giren_miktar = 0;
        $kasa_devir_cikan_miktar = 0;
        $alis_tutar = 0;
        $satis_tutar = 0;
        $maliyet_tutar = 0;

        $alis_faturasi = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat
FROM
alis_default as ad
INNER JOIN alis_urunler as au on au.alis_defaultid=ad.id
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.fatura_tarihi  < '$last_bas_tarih 23:59:59'
");
        if ($alis_faturasi > 0) {
            foreach ($alis_faturasi as $alislar) {
                $kasa_devir_giren_miktar += $alislar["miktar"];
            }
        }

        $alis_faturasi = DB::all_data("
SELECT
miktar,
birim_fiyat
FROM
stok_sayim_fazlasi
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key' AND tarih  < '$last_bas_tarih 23:59:59'
");
        if ($alis_faturasi > 0) {
            foreach ($alis_faturasi as $alislar) {
                $kasa_devir_giren_miktar += $alislar["miktar"];
            }
        }

        $alis_faturasi = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat
FROM
alis_irsaliye as ad
INNER JOIN alis_irsaliye_urunler as au on au.irsaliye_id=ad.id
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.irsaliye_tarihi  < '$last_bas_tarih 23:59:59'
");
        if ($alis_faturasi > 0) {
            foreach ($alis_faturasi as $alislar) {
                $kasa_devir_giren_miktar += $alislar["miktar"];
            }
        }
        $satis_faturalari = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat
FROM
satis_default as ad
INNER JOIN satis_urunler as au on au.satis_defaultid=ad.id
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.fatura_tarihi < '$last_bas_tarih 23:59:59'
");
        if ($satis_faturalari > 0) {
            foreach ($satis_faturalari as $alislar) {
                $kasa_devir_cikan_miktar += $alislar["miktar"];
            }
        }
        $satis_faturalari = DB::all_data("
SELECT
miktar,
tl_tutar
FROM
yakit_cikis_fisleri 
WHERE status=1 AND tarih < '$last_bas_tarih 23:59:59' AND stok_id='$kasa_id'
");
        if ($satis_faturalari > 0) {
            foreach ($satis_faturalari as $alislar) {
                $kasa_devir_cikan_miktar += $alislar["miktar"];
            }
        }
        $satis_faturalari = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat
FROM
satis_irsaliye as ad
INNER JOIN satis_irsaliye_urunler as au on au.irsaliye_id=ad.id
WHERE ad.status!=0 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.irsaliye_tarihi < '$last_bas_tarih 23:59:59'
");
        if ($satis_faturalari > 0) {
            foreach ($satis_faturalari as $alislar) {
                $kasa_devir_cikan_miktar += $alislar["miktar"];
            }
        }
        $acilis_fisi = DB::all_data("
SELECT
miktar
FROM
stok_acilis_fisleri
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key' AND acilis_tarih < '$last_bas_tarih 23:59:59'
");
        $stok_kodu = $item["stok_kodu"];
        $perakende_satislar = DB::all_data("
SELECT
psu.miktar,
psu.birim_fiyat
FROM
perakende_satis_urunler as psu
INNER JOIN perakende_satis as ps on ps.id=psu.satis_id
WHERE psu.status=1 AND ps.status=1 AND psu.stok_kodu='$stok_kodu' AND psu.cari_key='$cari_key' AND psu.insert_datetime < '$last_bas_tarih 23:59:59'
");
        if ($perakende_satislar > 0) {
            foreach ($perakende_satislar as $alislar) {
                $kasa_devir_cikan_miktar += $alislar["miktar"];
            }
        }
        $acilis_fisi = DB::all_data("
SELECT
miktar,
birim_fiyat
FROM
stok_fire
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key' AND insert_datetime < '$last_bas_tarih 23:59:59'
");
        if ($acilis_fisi > 0) {
            foreach ($acilis_fisi as $alislar) {
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $satis_tutar += $ara_toplam;
                $kasa_devir_cikan_miktar += $alislar["miktar"];
            }
        }


        $stok_cikisi = DB::all_data("
    SELECT
    asu.miktar,
    asu.birim_fiyat,
    asu.toplam_tutar
    FROM
    araclara_stok_cik as arac
    INNER JOIN araclara_stok_urunler as asu on asu.ana_id=arac.id
    INNER JOIN arac_kartlari as ak on ak.id=asu.plaka_id
    WHERE arac.status=1 AND asu.status=1 AND arac.cari_key='$cari_key' AND asu.stok_id='$kasa_id' AND arac.tarih < '$last_bas_tarih 23:59:59'
    ");
        if ($stok_cikisi > 0) {
            foreach ($stok_cikisi as $alislar) {
                $satis_tutar += $alislar["toplam_tutar"];
                $kasa_devir_cikan_miktar += $alislar["miktar"];
            }
        }

        $donem_basi_stok = floatval($kasa_devir_giren_miktar) - floatval($kasa_devir_cikan_miktar);
        $kasa_devir_giren_miktar = 0;
        $kasa_devir_cikan_miktar = 0;

        $alis_faturasi = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat,
ad.fatura_tarihi
FROM
alis_default as ad
INNER JOIN alis_urunler as au on au.alis_defaultid=ad.id
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' AND ad.irsaliye_ids=''
");
        if ($alis_faturasi > 0) {
            foreach ($alis_faturasi as $alislar) {
                $kasa_devir_giren_miktar += $alislar["miktar"];
                $arr3 = [
                    'birim_fiyat' => $alislar["birim_fiyat"],
                    'aktif_miktar' => $alislar["miktar"],
                    'tarih' => $alislar["fatura_tarihi"]
                ];
                $last_birim_fiyat = $alislar["birim_fiyat"];
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $alis_tutar += $ara_toplam;
                $maliyet_tutar += $ara_toplam;
                array_push($alislar_arr, $arr3);
            }
        }

        $alis_faturasi = DB::all_data("
SELECT
tarih,
miktar,
birim_fiyat
FROM
stok_sayim_fazlasi
WHERE status=1  AND stok_id='$kasa_id' AND cari_key='$cari_key' AND tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
        if ($alis_faturasi > 0) {
            foreach ($alis_faturasi as $alislar) {
                $kasa_devir_giren_miktar += $alislar["miktar"];
                $arr3 = [
                    'birim_fiyat' => $alislar["birim_fiyat"],
                    'aktif_miktar' => $alislar["miktar"],
                    'tarih' => $alislar["tarih"]
                ];
                $last_birim_fiyat = $alislar["birim_fiyat"];
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $alis_tutar += $ara_toplam;
                $maliyet_tutar += $ara_toplam;
                array_push($alislar_arr, $arr3);
            }
        }
        $stok_kodu = $item["stok_kodu"];
        $perakende_satislar = DB::all_data("
SELECT
psu.miktar,
psu.birim_fiyat
FROM
perakende_satis_urunler as psu
INNER JOIN perakende_satis as ps on ps.id=psu.satis_id
WHERE psu.status=1 AND ps.status=1 AND psu.stok_kodu='$stok_kodu' AND psu.cari_key='$cari_key' AND psu.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
        if ($perakende_satislar > 0) {
            foreach ($perakende_satislar as $alislar) {
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $satis_tutar += $ara_toplam;
                $kasa_devir_cikan_miktar += $alislar["miktar"];
            }
        }

        $satis_faturalari = DB::all_data("
SELECT
miktar,
tl_tutar
FROM
yakit_cikis_fisleri 
WHERE status!=0 AND tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' AND stok_id='$kasa_id'
");
        if ($satis_faturalari > 0) {
            foreach ($satis_faturalari as $alislar) {
                $satis_tutar += $alislar["tl_tutar"];
                $kasa_devir_cikan_miktar += $alislar["miktar"];
            }
        }

        $stok_cikisi = DB::all_data("
    SELECT
    asu.miktar,
    asu.birim_fiyat,
    asu.toplam_tutar
    FROM
    araclara_stok_cik as arac
    INNER JOIN araclara_stok_urunler as asu on asu.ana_id=arac.id
    INNER JOIN arac_kartlari as ak on ak.id=asu.plaka_id
    WHERE arac.status=1 AND asu.status=1 AND arac.cari_key='$cari_key' AND asu.stok_id='$kasa_id' AND arac.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
    ");
        if ($stok_cikisi > 0) {
            foreach ($stok_cikisi as $alislar) {
                $satis_tutar += $alislar["toplam_tutar"];
                $kasa_devir_cikan_miktar += $alislar["miktar"];
            }
        }

        $satis_faturalari = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat
FROM
satis_default as ad
INNER JOIN satis_urunler as au on au.satis_defaultid=ad.id
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' AND ad.irsaliye_ids=''
");
        if ($satis_faturalari > 0) {
            foreach ($satis_faturalari as $alislar) {
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $satis_tutar += $ara_toplam;

                $kasa_devir_cikan_miktar += $alislar["miktar"];
            }
        }
        $alis_irsaliye = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat
FROM
alis_irsaliye as ad
INNER JOIN alis_irsaliye_urunler as au on au.irsaliye_id=ad.id
WHERE ad.status!=0 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.irsaliye_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
        if ($alis_irsaliye > 0) {
            foreach ($alis_irsaliye as $alislar) {
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $alis_tutar += $ara_toplam;
                $maliyet_tutar += $ara_toplam;

                $kasa_devir_giren_miktar += $alislar["miktar"];
            }
        }
        $satis_irsaliye = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat
FROM
satis_irsaliye as ad
INNER JOIN satis_irsaliye_urunler as au on au.irsaliye_id=ad.id
WHERE ad.status!=0 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.irsaliye_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
        if ($satis_irsaliye > 0) {
            foreach ($satis_irsaliye as $alislar) {
                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $satis_tutar += $ara_toplam;

                $kasa_devir_cikan_miktar += $alislar["miktar"];
            }
        }
        $acilis_fisi = DB::all_data("
SELECT
miktar,
alis_fiyat
FROM
stok_acilis_fisleri
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key' AND acilis_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
        if ($acilis_fisi > 0) {
            foreach ($acilis_fisi as $alislar) {
                $ara_toplam = $alislar["alis_fiyat"] * $alislar["miktar"];
                $alis_tutar += $ara_toplam;
                $maliyet_tutar += $ara_toplam;
                $kasa_devir_giren_miktar += $alislar["miktar"];
            }
        }
        $acilis_fisi = DB::all_data("
SELECT
miktar,
birim_fiyat
FROM
stok_fire
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key' AND insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
        if ($acilis_fisi > 0) {
            foreach ($acilis_fisi as $alislar) {

                $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
                $satis_tutar += $ara_toplam;
                $kasa_devir_cikan_miktar += $alislar["miktar"];
            }
        }
        $kasa_devir_kalan_miktar = 0;
        $kasa_devir_kalan_miktar = floatval($kasa_devir_giren_miktar) - floatval($kasa_devir_cikan_miktar);
        $devirli_miktar = $kasa_devir_kalan_miktar;
        $elimdeki_maliyet = 0;
        usort($alislar_arr, function ($a, $b) {
            $tarihA = strtotime($a['tarih']); // $a dizisindeki tarih değerini alıp zaman damgasına dönüştür
            $tarihB = strtotime($b['tarih']);
            if ($tarihA == $tarihB) {
                return 0;
            }

            return ($tarihA > $tarihB) ? -1 : 1;
        });
        foreach ($alislar_arr as $maliyetler) {

            if ($devirli_miktar > $maliyetler["aktif_miktar"]) {
                $devirli_miktar -= $maliyetler["aktif_miktar"];
                $elimdeki_maliyet += $maliyetler["aktif_miktar"] * $maliyetler["birim_fiyat"];
            } else {
                $elimdeki_maliyet += $devirli_miktar * $maliyetler["birim_fiyat"];
                break;
            }
        }
        $arr = [
            'stok_kodu' => $item["stok_kodu"],
            'stok_adi' => $item["stok_adi"],
            'barkod' => $item["barkod"],
            'birim_adi' => $item["birim_adi"],
            'ana_grup_adi' => $item["ana_grup_adi"],
            'altgrup_adi' => $item["altgrup_adi"],
            'elimdeki_maliyet' => $elimdeki_maliyet,
            'giren_miktar' => $kasa_devir_giren_miktar,
            'satis_tutar' => $satis_tutar,
            'alis_tutar' => $alis_tutar,
            'maliyet_tutar' => $maliyet_tutar,
            'cikan_miktar' => $kasa_devir_cikan_miktar,
            'donem_basi_stok' => $donem_basi_stok,
            'donem_sonu_stok' => $kasa_devir_kalan_miktar
        ];
        array_push($ekstre_arr, $arr);


    }
    if ($ekstre_arr > 0) {
        echo json_encode($ekstre_arr);
    } else {
        echo 2;
    }
}
if ($islem == "cariye_ait_acik_alis_irsaliyelerini_getir") {
    $cari_id = $_GET["cari_id"];
    $bas_tarih = $_GET["bas_tarih"];
    $bit_tarih = $_GET["bit_tarih"];
    $cari_acik_alislar = DB::all_data("
SELECT
       ai.irsaliye_tarihi,
       s.stok_adi,
       aiu.miktar,
       aiu.birim_fiyat,
       aiu.toplam_tutar
FROM 
     alis_irsaliye as ai
INNER JOIN alis_irsaliye_urunler as aiu on aiu.irsaliye_id=ai.id
INNER JOIN stok as s on s.id=aiu.stok_id
WHERE 
      ai.status=1 
  AND 
      ai.cari_key='$cari_key'
    AND 
      aiu.status=1
AND 
      ai.cari_id='$cari_id'
AND 
      ai.irsaliye_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
      ");
    if ($cari_acik_alislar > 0) {
        echo json_encode($cari_acik_alislar);
    } else {
        echo 2;
    }
}
if ($islem == "cariye_ait_acik_satis_irsaliyelerini_getir") {
    $cari_id = $_GET["cari_id"];
    $bas_tarih = $_GET["bas_tarih"];
    $bit_tarih = $_GET["bit_tarih"];
    $cari_acik_alislar = DB::all_data("
SELECT
       ai.irsaliye_tarihi,
       s.stok_adi,
       aiu.miktar,
       aiu.birim_fiyat,
       aiu.toplam_tutar
FROM 
     satis_irsaliye as ai
INNER JOIN satis_irsaliye_urunler as aiu on aiu.irsaliye_id=ai.id
INNER JOIN stok as s on s.id=aiu.stok_id
WHERE 
      ai.status=1 
  AND 
      ai.cari_key='$cari_key'
    AND 
      aiu.status=1
AND 
      ai.cari_id='$cari_id'
AND 
      ai.irsaliye_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
      ");
    if ($cari_acik_alislar > 0) {
        echo json_encode($cari_acik_alislar);
    } else {
        echo 2;
    }
}
if ($islem == "pos_banka_hesap_ekstresi_getir_sql") {
    $pos_id = $_GET["pos_id"];
    $bas_tarih = $_GET["bas_tarih"];
    $bit_tarih = $_GET["bit_tarih"];

    $banka_ekstre_arr = [];
    $pos_devir_giren_miktar = 0;
    $pos_devir_cikan_miktar = 0;
    $pos_devir_kalan_miktar = 0;
    $b_durum = "";
    $ekstre_arr = [];


    $bas_tarih = new DateTime($bas_tarih);
    $bas_tarih->modify('-1 day');
    $sorgu_bas = $_GET["bas_tarih"];
    $last_bas_tarih = $bas_tarih->format('Y-m-d');

    $yil_basi = new DateTime();
    $yil_basi->modify('first day of January ' . $yil_basi->format('Y'));

    $pos_tanim = DB::single_query("SELECT * FROM pos_tanim WHERE status=1 AND id='$pos_id'");

    $yil_basi = $yil_basi->format('Y-m-d');

    if ($bas_tarih == "" && $bit_tarih == "") {
        $last_bas_tarih = date("Y-m-d");
    }

    $pos_devir_cekilen = DB::single_query("SELECT * FROM pos_cekim_urunler WHERE status=1 AND cari_key='$cari_key'");

    $perakende_islemler = DB::all_data("
SELECT
       ps.*,
       (SELECT SUM(genel_toplam) FROM perakende_satis_urunler WHERE satis_id = ps.id) AS toplam_tutar
FROM 
     perakende_satis as ps 
INNER JOIN perakende_satis_urunler as psu on psu.satis_id=ps.id
WHERE ps.status=1 AND psu.status=1 AND ps.cari_key='$cari_key' AND ps.pos_id='$pos_id' AND ps.fatura_tarihi < '$last_bas_tarih 23:59:59'
");

    if ($perakende_islemler > 0) {
        foreach ($perakende_islemler as $alislar) {
            $pos_devir_giren_miktar += $alislar["toplam_tutar"];
        }
    }
    $bireysel_tahakkuk = DB::all_data("
SELECT
bt.tutar,
bt.tarih,
ut.uye_adi
FROM
bireysel_tahakkuk as bt
INNER JOIN uye_tanim as ut on ut.id=bt.uye_id
WHERE bt.status=1 AND bt.pos_id='$pos_id' AND bt.tarih < '$last_bas_tarih 23:59:59'
");

    if ($bireysel_tahakkuk > 0) {
        foreach ($bireysel_tahakkuk as $alislar) {
            $pos_devir_giren_miktar += $alislar["tutar"];
        }
    }
    $pos_cekim_islemleri = DB::all_data("
SELECT
       tutar
FROM 
     pos_cekim
WHERE status=1 AND cari_key='$cari_key' AND pos_id='$pos_id' AND tarih < '$last_bas_tarih 23:59:59'
");

    if ($pos_cekim_islemleri > 0) {
        foreach ($pos_cekim_islemleri as $alislar) {
            $pos_devir_giren_miktar += $alislar["tutar"];
        }
    }
    $pos_tahsilat_islemleri = DB::all_data("
SELECT
       tutar
FROM 
     pos_cekim_tahsiller
WHERE status=1 AND cari_key='$cari_key' AND pos_id='$pos_id' AND islem_tarihi < '$last_bas_tarih 23:59:59'
");

    if ($pos_tahsilat_islemleri > 0) {
        foreach ($pos_tahsilat_islemleri as $alislar) {
            $pos_devir_cikan_miktar += $alislar["tutar"];
        }
    }

    // BURAYA KADAR OLAN KISIM DEVİR İÇİN
    $cari_devir_bakiye = floatval($pos_devir_cikan_miktar) - floatval($pos_devir_giren_miktar);
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
        'borc' => $pos_devir_cikan_miktar,
        'alacak' => $pos_devir_giren_miktar,
        'bakiye' => $cari_devir_bakiye,
        'b_durum' => $b_durum,
        'vade_tarihi' => ""
    ];
    array_push($ekstre_arr, $devir_arr);
    $ekstre_arr1 = [];

    $pos_cekim_islemleri = DB::all_data("
SELECT
       tutar,
       tarih,
       aciklama
FROM 
     pos_cekim
WHERE status=1 AND cari_key='$cari_key' AND tarih  BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59'
");
    if ($pos_cekim_islemleri > 0) {
        foreach ($pos_cekim_islemleri as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'belge_turu' => 'POS Çekim',
                'aciklama' => $alislar["aciklama"],
                'tutar' => $alislar["tutar"]
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }
    $bireysel_tahakkuk = DB::all_data("
SELECT
bt.tutar,
bt.tarih,
ut.uye_adi
FROM
bireysel_tahakkuk as bt
INNER JOIN uye_tanim as ut on ut.id=bt.uye_id
WHERE bt.status=1 AND bt.pos_id='$pos_id' AND bt.tarih BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59'
");
    if ($bireysel_tahakkuk > 0) {
        foreach ($bireysel_tahakkuk as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'belge_turu' => 'BİREYSEL TAHAKKUK',
                'aciklama' => $alislar["aciklama"]." ".$alislar["uye_adi"],
                'tutar' => $alislar["tutar"]
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }
    $perakende_islemler = DB::all_data("
SELECT
       ps.*,
       (SELECT SUM(genel_toplam) FROM perakende_satis_urunler WHERE satis_id = ps.id) AS toplam_tutar
FROM 
     perakende_satis as ps 
INNER JOIN perakende_satis_urunler as psu on psu.satis_id=ps.id
WHERE ps.status=1 AND psu.status=1 AND ps.cari_key='$cari_key' AND ps.pos_id='$pos_id' AND ps.fatura_tarihi BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59'
");
    if ($perakende_islemler > 0) {
        foreach ($perakende_islemler as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["fatura_tarihi"],
                'belge_turu' => 'Perakende Satış',
                'aciklama' => $alislar["aciklama"],
                'tutar' => $alislar["toplam_tutar"]
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }

    $pos_tahsilat_islemleri = DB::all_data("
SELECT
       tutar,
       aciklama,
       islem_tarihi,
       islem_tarihi
FROM 
     pos_cekim_tahsiller
WHERE status=1 AND cari_key='$cari_key' AND islem_tarihi BETWEEN '$sorgu_bas 23:59:59' AND '$bit_tarih 23:59:59'
");
    if ($pos_tahsilat_islemleri > 0) {
        foreach ($pos_tahsilat_islemleri as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["islem_tarihi"],
                'belge_turu' => 'POS Çekim Tahsilat',
                'aciklama' => $alislar["aciklama"],
                'tutar' => $alislar["tutar"]
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
        if ($dizaynli_bilgi["belge_turu"] == "POS Çekim") {
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
                'belge_turu' => "POS Çekim",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"]
            ];
            array_push($gidecek_array, $duzenle_arr2);
        } else if ($dizaynli_bilgi["belge_turu"] == "Perakende Satış") {
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
                'belge_turu' => "Perakende Satış",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"]
            ];
            array_push($gidecek_array, $duzenle_arr2);
        }else if ($dizaynli_bilgi["belge_turu"] == "BİREYSEL TAHAKKUK") {
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
                'belge_turu' => "BİREYSEL TAHAKKUK",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"]
            ];
            array_push($gidecek_array, $duzenle_arr2);
        } else if ($dizaynli_bilgi["belge_turu"] == "POS Çekim Tahsilat") {
            $borc = $dizaynli_bilgi["tutar"];
            if ($b_durum == "B") {
                $cari_devir_bakiye += $borc;
            } else if ($b_durum == "A") {
                $cari_devir_bakiye -= $borc;
                if ($cari_devir_bakiye < 0) {
                    $cari_devir_bakiye = -$cari_devir_bakiye;
                    $b_durum = "A";
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
                'belge_turu' => "POS Çekim Tahsilat",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $cari_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"]
            ];
            array_push($gidecek_array, $duzenle_arr2);
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
if ($islem == "hizmet_ekstresi_getir_sql") {

    $kasa_id = $_GET["stok_id"];
    $bas_tarih = $_GET["bas_tarih"];
    $bit_tarih = $_GET["bit_tarih"];

    $banka_ekstre_arr = [];
    $kasa_devir_giren_miktar = 0;
    $kasa_devir_cikan_miktar = 0;
    $kasa_devir_kalan_miktar = 0;
    $b_durum = "";
    $ekstre_arr = [];


    $bas_tarih = new DateTime($bas_tarih);
    $bas_tarih->modify('-1 day');
    $sorgu_bas = $_GET["bas_tarih"];
    $last_bas_tarih = $bas_tarih->format('Y-m-d');

    $yil_basi = new DateTime();
    $yil_basi->modify('first day of January ' . $yil_basi->format('Y'));

    $kasa_bilgileri = DB::single_query("SELECT * FROM stok WHERE status=1 AND id='$kasa_id'");

    $yil_basi = $yil_basi->format('Y-m-d');

    if ($bas_tarih == "" && $bit_tarih == "") {
        $last_bas_tarih = date("Y-m-d");
    }


    $stok_bilgileri = DB::single_query("SELECT * FROM stok WHERE status=1 AND cari_key='$cari_key' AND id='$kasa_id'");
    $alis_toplam = 0;
    $satis_toplam = 0;
    $alis_faturasi = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat
FROM
alis_default as ad
INNER JOIN alis_urunler as au on au.alis_defaultid=ad.id
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.fatura_tarihi  < '$last_bas_tarih 23:59:59'
");
    if ($alis_faturasi > 0) {
        foreach ($alis_faturasi as $alislar) {
            $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
            $alis_toplam += $ara_toplam;
            $kasa_devir_giren_miktar += $alislar["miktar"];
        }
    }

    $alis_faturasi = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat
FROM
alis_irsaliye as ad
INNER JOIN alis_irsaliye_urunler as au on au.irsaliye_id=ad.id
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.irsaliye_tarihi  < '$last_bas_tarih 23:59:59'
");
    if ($alis_faturasi > 0) {
        foreach ($alis_faturasi as $alislar) {
            $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
            $alis_toplam += $ara_toplam;
            $kasa_devir_giren_miktar += $alislar["miktar"];
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat
FROM
satis_default as ad
INNER JOIN satis_urunler as au on au.satis_defaultid=ad.id
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.fatura_tarihi < '$last_bas_tarih 23:59:59'
");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
            $satis_toplam += $ara_toplam;
            $kasa_devir_cikan_miktar += $alislar["miktar"];
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
miktar,
tl_tutar
FROM
yakit_cikis_fisleri 
WHERE status=1 AND tarih < '$last_bas_tarih 23:59:59' AND stok_id='$kasa_id'
");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $satis_toplam += $alislar["tl_tutar"];
            $kasa_devir_cikan_miktar += $alislar["miktar"];
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
au.miktar,
au.birim_fiyat
FROM
satis_irsaliye as ad
INNER JOIN satis_irsaliye_urunler as au on au.irsaliye_id=ad.id
WHERE ad.status!=0 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.irsaliye_tarihi < '$last_bas_tarih 23:59:59'
");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
            $satis_toplam += $ara_toplam;
            $kasa_devir_cikan_miktar += $alislar["miktar"];
        }
    }
    $acilis_fisi = DB::all_data("
SELECT
miktar
FROM
stok_acilis_fisleri
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key' AND acilis_tarih < '$last_bas_tarih 23:59:59'
");
    $stok_kodu = $stok_bilgileri["stok_kodu"];
    $perakende_satislar = DB::all_data("
SELECT
psu.miktar,
psu.birim_fiyat
FROM
perakende_satis_urunler as psu
INNER JOIN perakende_satis as ps on ps.id=psu.satis_id
WHERE psu.status=1 AND ps.status=1 AND psu.stok_kodu='$stok_kodu' AND psu.cari_key='$cari_key' AND psu.insert_datetime < '$last_bas_tarih 23:59:59'
");
    if ($perakende_satislar > 0) {
        foreach ($perakende_satislar as $alislar) {
            $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
            $satis_toplam += $ara_toplam;
            $kasa_devir_cikan_miktar += $alislar["miktar"];
        }
    }
    $acilis_fisi = DB::all_data("
SELECT
miktar
FROM
stok_fire
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key' AND insert_datetime < '$last_bas_tarih 23:59:59'
");
    if ($acilis_fisi > 0) {
        foreach ($acilis_fisi as $alislar) {
            $kasa_devir_cikan_miktar += $alislar["miktar"];
        }
    }
    $kasa_devir_kalan_miktar = floatval($kasa_devir_giren_miktar) - floatval($kasa_devir_cikan_miktar);
    $arr = [
        'tarih' => $sorgu_bas,
        'belge_no' => "......",
        'belge_turu' => "Devir",
        'aciklama' => "Önceki Tarihten Devir",
        'giren_miktar' => $kasa_devir_giren_miktar,
        'cikan_miktar' => $kasa_devir_cikan_miktar,
        'alis_tutar' => $alis_toplam,
        'satis_tutar' => $satis_toplam,
        'fiyat' => "",
        'kalan_miktar' => $kasa_devir_kalan_miktar
    ];
    array_push($ekstre_arr, $arr);

    $cok_kibarsin = [];
    $alis_faturasi = DB::all_data("
SELECT
au.miktar,
ad.aciklama,
ad.fatura_tarihi,
ad.genel_toplam,
ad.fatura_no,
au.kdv_tutari,
au.birim_fiyat
FROM
alis_default as ad
INNER JOIN alis_urunler as au on au.alis_defaultid=ad.id
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.fatura_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($alis_faturasi > 0) {
        foreach ($alis_faturasi as $alislar) {
            $ara_toplam = $alislar["miktar"] * $alislar["birim_fiyat"];
            $arr = [
                'tarih' => $alislar["fatura_tarihi"],
                'belge_no' => $alislar["fatura_no"],
                'belge_turu' => "Alış Faturası",
                'aciklama' => $alislar["aciklama"],
                'giren_miktar' => $alislar["miktar"],
                'cikan_miktar' => 0,
                'alis_tutar' => $ara_toplam,
                'fiyat' => $alislar["birim_fiyat"],
                'kdv_fiyat' => $alislar["kdv_tutari"],
                'satis_tutar' => 0
            ];
            array_push($cok_kibarsin, $arr);
        }
    }

    $yakit_cikislari = DB::all_data("
SELECT
miktar,
fis_no,
tarih,
aciklama,
tl_tutar,
litre_fiyati
FROM
yakit_cikis_fisleri 
WHERE status=1 AND stok_id='$kasa_id' AND tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($yakit_cikislari > 0) {
        foreach ($yakit_cikislari as $alislar) {
            $ara_toplam = $alislar["miktar"] * $alislar["litre_fiyati"];
            $arr = [
                'tarih' => $alislar["tarih"],
                'belge_no' => $alislar["fis_no"],
                'belge_turu' => "Yakıt Çıkış",
                'aciklama' => $alislar["aciklama"],
                'giren_miktar' => 0,
                'cikan_miktar' => $alislar["miktar"],
                'fiyat' => $alislar["litre_fiyati"],
                'kdv_fiyat' => 0,
                'alis_tutar' => 0,
                'satis_tutar' => $ara_toplam
            ];
            array_push($cok_kibarsin, $arr);
        }
    }
    $perakende_satislar = DB::all_data("
SELECT
psu.miktar,
psu.insert_datetime,
ps.aciklama,
psu.birim_fiyat,
psu.kdv_tutar
FROM
perakende_satis_urunler as psu
INNER JOIN perakende_satis as ps on ps.id=psu.satis_id
WHERE psu.status=1 AND ps.status=1 AND psu.stok_kodu='$stok_kodu' AND psu.cari_key='$cari_key' AND psu.insert_datetime BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($perakende_satislar > 0) {
        foreach ($perakende_satislar as $alislar) {
            $ara_toplam = $alislar["miktar"] * $alislar["birim_fiyat"];
            $arr = [
                'tarih' => $alislar["insert_datetime"],
                'belge_no' => "",
                'belge_turu' => "Perakende Satış",
                'aciklama' => $alislar["aciklama"],
                'giren_miktar' => 0,
                'cikan_miktar' => $alislar["miktar"],
                'kdv_fiyat' => $alislar["kdv_tutar"],
                'fiyat' => $alislar["birim_fiyat"],
                'alis_tutar' => 0,
                'satis_tutar' => $ara_toplam
            ];
            array_push($cok_kibarsin, $arr);
        }
    }
    $alis_faturasi = DB::all_data("
SELECT
au.miktar,
ad.aciklama,
ad.irsaliye_tarihi,
ad.irsaliye_no,
au.birim_fiyat,
au.kdv_tutari
FROM
alis_irsaliye as ad
INNER JOIN alis_irsaliye_urunler as au on au.irsaliye_id=ad.id
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.irsaliye_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($alis_faturasi > 0) {
        foreach ($alis_faturasi as $alislar) {
            $ara_toplam = $alislar["birim_fiyat"] * $alislar["miktar"];
            $arr = [
                'tarih' => $alislar["irsaliye_tarihi"],
                'belge_no' => $alislar["irsaliye_no"],
                'belge_turu' => "Alış İrsaliyesi",
                'aciklama' => $alislar["aciklama"],
                'giren_miktar' => $alislar["miktar"],
                'kdv_fiyat' => $alislar["kdv_tutari"],
                'cikan_miktar' => 0,
                'alis_tutar' => $ara_toplam,
                'fiyat' => $alislar["birim_fiyat"],
                'satis_tutar' => 0
            ];
            array_push($cok_kibarsin, $arr);
        }
    }

    $satis_faturalari = DB::all_data("
SELECT
au.miktar,
ad.aciklama,
ad.fatura_tarihi,
ad.fatura_no,
au.birim_fiyat,
au.kdv_tutari
FROM
satis_default as ad
INNER JOIN satis_urunler as au on au.satis_defaultid=ad.id
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.fatura_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $ara_toplam = $alislar["miktar"] * $alislar["birim_fiyat"];
            $arr = [
                'tarih' => $alislar["fatura_tarihi"],
                'belge_no' => $alislar["fatura_no"],
                'belge_turu' => "Satış Faturası",
                'aciklama' => $alislar["aciklama"],
                'giren_miktar' => 0,
                'cikan_miktar' => $alislar["miktar"],
                'kdv_fiyat' => $alislar["kdv_tutari"],
                'alis_tutar' => 0,
                'fiyat' => $alislar["birim_fiyat"],
                'satis_tutar' => $ara_toplam
            ];
            array_push($cok_kibarsin, $arr);
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
au.miktar,
ad.aciklama,
ad.irsaliye_tarihi,
ad.irsaliye_no,
au.birim_fiyat,
au.kdv_tutari
FROM
satis_irsaliye as ad
INNER JOIN satis_irsaliye_urunler as au on au.irsaliye_id=ad.id
WHERE ad.status!=0 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.irsaliye_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59' 
");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $ara_toplam = $alislar["miktar"] * $alislar["birim_fiyat"];
            $arr = [
                'tarih' => $alislar["irsaliye_tarihi"],
                'belge_no' => $alislar["irsaliye_no"],
                'belge_turu' => "Satış İrsaliyesi",
                'aciklama' => $alislar["aciklama"],
                'giren_miktar' => 0,
                'cikan_miktar' => $alislar["miktar"],
                'fiyat' => $alislar["birim_fiyat"],
                'kdv_fiyat' => $alislar["kdv_tutari"],
                'alis_tutar' => 0,
                'satis_tutar' => $ara_toplam
            ];
            array_push($cok_kibarsin, $arr);
        }
    }
    $acilis_fisi = DB::all_data("
SELECT
miktar,
aciklama,
insert_datetime,
acilis_tarih
FROM
stok_acilis_fisleri
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key' AND acilis_tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($acilis_fisi > 0) {
        foreach ($acilis_fisi as $alislar) {
            $arr = [
                'tarih' => $alislar["acilis_tarih"],
                'belge_no' => "",
                'belge_turu' => "Stok Açılış Fişi",
                'aciklama' => $alislar["aciklama"],
                'giren_miktar' => $alislar["miktar"],
                'cikan_miktar' => 0,
                'alis_tutar' => 0,
                'fiyat' => 0,
                'kdv_fiyat' => 0,
                'satis_tutar' => 0
            ];
            array_push($cok_kibarsin, $arr);
        }
    }
    $acilis_fisi = DB::all_data("
SELECT
miktar,
aciklama,
insert_datetime
FROM
stok_fire
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key' AND insert_datetime BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($acilis_fisi > 0) {
        foreach ($acilis_fisi as $alislar) {
            $arr = [
                'tarih' => $alislar["insert_datetime"],
                'belge_no' => "",
                'belge_turu' => "Stok Fire Çıkışı",
                'aciklama' => $alislar["aciklama"],
                'giren_miktar' => 0,
                'cikan_miktar' => $alislar["miktar"],
                'alis_tutar' => 0,
                'kdv_fiyat' => 0,
                'fiyat' => 0,
                'satis_tutar' => 0
            ];
            array_push($cok_kibarsin, $arr);
        }
    }
    usort($cok_kibarsin, function ($a, $b) {
        $tarihA = strtotime($a['tarih']); // $a dizisindeki tarih değerini alıp zaman damgasına dönüştür
        $tarihB = strtotime($b['tarih']);
        if ($tarihA == $tarihB) {
            return 0;
        }

        return ($tarihA < $tarihB) ? -1 : 1;
    });
    $gonderilen_ekstre_arr = [];
    array_push($gonderilen_ekstre_arr, $ekstre_arr[0]);
    if ($cok_kibarsin > 0) {
        foreach ($cok_kibarsin as $item) {
            if ($item["belge_turu"] == "Alış İrsaliyesi") {

                $kasa_devir_kalan_miktar += $item["giren_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'giren_miktar' => $item["giren_miktar"],
                    'cikan_miktar' => 0,
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'fiyat' => $item["fiyat"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "Alış Faturası") {

                $kasa_devir_kalan_miktar += $item["giren_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'fiyat' => $item["fiyat"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'giren_miktar' => $item["giren_miktar"],
                    'cikan_miktar' => 0,
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "Depo Alış Faturası") {

                $kasa_devir_kalan_miktar += $item["giren_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'fiyat' => $item["fiyat"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'giren_miktar' => $item["giren_miktar"],
                    'cikan_miktar' => 0,
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "Satış Faturası") {
                $kasa_devir_kalan_miktar += $item["cikan_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'fiyat' => $item["fiyat"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'giren_miktar' => 0,
                    'cikan_miktar' => $item["cikan_miktar"],
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "Depo Satış Faturası") {
                $kasa_devir_kalan_miktar += $item["cikan_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'fiyat' => $item["fiyat"],
                    'belge_turu' => $item["belge_turu"],
                    'aciklama' => $item["aciklama"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'giren_miktar' => 0,
                    'cikan_miktar' => $item["cikan_miktar"],
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "Satış İrsaliyesi") {
                $kasa_devir_kalan_miktar += $item["cikan_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'fiyat' => $item["fiyat"],
                    'belge_turu' => $item["belge_turu"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'aciklama' => $item["aciklama"],
                    'giren_miktar' => 0,
                    'cikan_miktar' => $item["cikan_miktar"],
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "Perakende Satış") {
                $kasa_devir_kalan_miktar += $item["cikan_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'belge_turu' => $item["belge_turu"],
                    'fiyat' => $item["fiyat"],
                    'aciklama' => $item["aciklama"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'giren_miktar' => 0,
                    'cikan_miktar' => $item["cikan_miktar"],
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "Alış İrsaliye") {

                $kasa_devir_kalan_miktar += $item["giren_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'fiyat' => $item["fiyat"],
                    'belge_turu' => $item["belge_turu"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'aciklama' => $item["aciklama"],
                    'giren_miktar' => $item["giren_miktar"],
                    'cikan_miktar' => 0,
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);


            } else if ($item["belge_turu"] == "Satış İrsaliye") {

                $kasa_devir_kalan_miktar += $item["cikan_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'fiyat' => $item["fiyat"],
                    'belge_turu' => $item["belge_turu"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'aciklama' => $item["aciklama"],
                    'giren_miktar' => 0,
                    'cikan_miktar' => $item["cikan_miktar"],
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "Yakıt Çıkış") {

                $kasa_devir_kalan_miktar += $item["cikan_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'fiyat' => $item["fiyat"],
                    'belge_turu' => $item["belge_turu"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'aciklama' => $item["aciklama"],
                    'giren_miktar' => 0,
                    'cikan_miktar' => $item["cikan_miktar"],
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);

            } else if ($item["belge_turu"] == "Stok Açılış Fişi") {
                $kasa_devir_kalan_miktar += $item["giren_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'belge_turu' => $item["belge_turu"],
                    'fiyat' => $item["fiyat"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'aciklama' => $item["aciklama"],
                    'giren_miktar' => $item["giren_miktar"],
                    'cikan_miktar' => 0,
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);
            } else if ($item["belge_turu"] == "Stok Fire Çıkışı") {

                $kasa_devir_kalan_miktar += $item["cikan_miktar"];
                $arr = [
                    'tarih' => $item["tarih"],
                    'belge_no' => $item["belge_no"],
                    'fiyat' => $item["fiyat"],
                    'belge_turu' => $item["belge_turu"],
                    'kdv_fiyat' => $item["kdv_fiyat"],
                    'aciklama' => $item["aciklama"],
                    'giren_miktar' => 0,
                    'cikan_miktar' => $item["cikan_miktar"],
                    'kalan_miktar' => $kasa_devir_kalan_miktar,
                    'alis_tutar' => $item["alis_tutar"],
                    'satis_tutar' => $item["satis_tutar"]
                ];
                array_push($gonderilen_ekstre_arr, $arr);
            }
        }
    }
    if ($gonderilen_ekstre_arr > 0) {
        echo json_encode($gonderilen_ekstre_arr);
    }
}