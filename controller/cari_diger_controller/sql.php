<?php
include '../DB.php';
date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=UTF-8');
session_start();
DB::connect();
$cari_key = $_SESSION["cari_key"];
$sube_key = $_SESSION["sube_key"];
$islem = $_GET["islem"];
if ($islem == "vadesine_gore_borc_alacak_filtrele") {

    $ilk_vade = $_GET["ilk_vade"];
    $son_vade = $_GET["son_vade"];
    $limit_b = $_GET["bakiye_limit"];
    $cari_grubu = $_GET["cari_grubu"];
    $cari_turu = $_GET["cari_turu"];
    $last_bas_tarih = $ilk_vade;
    $yil_basi = $son_vade;
    $sql = "
SELECT 
       c.cari_kodu,
       c.cari_adi,
       c.aciklama,
       c.id,
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
    if ($cari_grubu != "") {
        if ($cari_grubu == "0") {

        } else {
            $sql .= " AND c.cari_grubu='$cari_grubu'";
        }
    }
    $vadesi_gecmis_arr = [];
    // BURAYA KADAR OLAN KISIM DOĞRU CARİLERİ ÇEKMEK ADINA YAPILAN BİR FİLTRELEME

    $dogru_cariler = DB::all_data($sql);
    foreach ($dogru_cariler as $item) {

        $cari_id = $item["id"];

        $alis_faturalari = DB::single_query("
SELECT
SUM(genel_toplam) as genel_toplam
FROM
alis_default
WHERE status=1 AND cari_key='$cari_key' AND cari_id='$cari_id' AND vade_tarihi BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        $cari_devir_borc = 0;
        $cari_devir_alacak = 0;
        $cari_devir_bakiye = 0;
        $b_durum = "";
        $belge_turu = "";
        if ($alis_faturalari > 0) {
            $cari_devir_alacak += floatval($alis_faturalari["genel_toplam"]);
        }
        $gider_faturalari = DB::single_query("
SELECT
mg.fatura_no as belge_no,
mg.fatura_tarihi as tarih,
mg.aciklama,
SUM(mgu.genel_toplam) as tutar
FROM
muhasebe_gider_urunler as mgu
INNER JOIN muhasebe_gider as mg on mgu.gider_id=mg.id
WHERE mg.status=1 AND mg.cari_key='$cari_key' AND mgu.cari_id='$cari_id' AND mg.fatura_tarihi BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59' GROUP BY mgu.id");
        if ($gider_faturalari > 0) {
            $cari_devir_alacak += floatval($gider_faturalari["tutar"]);
        }

        $satis_faturalari = DB::single_query("
SELECT
SUM(genel_toplam) as genel_toplam
FROM
satis_default
WHERE status=1 AND cari_key='$cari_key' AND cari_id='$cari_id' AND vade_tarihi BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        if ($satis_faturalari > 0) {
            $cari_devir_borc += floatval($satis_faturalari["genel_toplam"]);
        }

        $personel_kodu = $item["cari_kodu"];
        $satis_faturalari = DB::single_query("
SELECT
SUM(pta.tutar) as tutar
FROM
personel_tahakkuk as pta
INNER JOIN personel_tanim as pt on pt.id=pta.personel_id
WHERE pta.status=1 AND pta.cari_key='$cari_key' AND pt.personel_kodu='$personel_kodu' AND pta.islem_tarihi BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        if ($satis_faturalari > 0) {
            $cari_devir_alacak += floatval($satis_faturalari["tutar"]);
        }
        $kart_islemi = DB::single_query("
SELECT
SUM(tutar) as tutar
FROM kredi_kartindan_odeme
WHERE status=1 AND cari_id='$cari_id' AND cari_key='$cari_key' AND islem_tarihi BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        if ($kart_islemi > 0) {
            $cari_devir_borc += floatval($kart_islemi["tutar"]);
        }

        $satis_faturalari = DB::single_query("
SELECT
SUM(tutar) as tutar
FROM
pos_cekim
WHERE status=1 AND cari_key='$cari_key' AND cari_id='$cari_id' AND tarih BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        if ($satis_faturalari > 0) {
            $cari_devir_alacak += floatval($satis_faturalari["tutar"]);
        }
        $satis_faturalari = DB::single_query("SELECT
SUM(acu.girilen_tutar) as girilen_tutar
FROM
     alinan_cek_urunler AS acu
INNER JOIN alinan_cek_giris AS acg on acg.id=acu.alinan_cekid
WHERE acu.status!=0 AND acg.status!=0 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acu.vade_tarih BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        if ($satis_faturalari > 0) {
            $cari_devir_alacak += floatval($satis_faturalari["girilen_tutar"]);
        }
        $satis_faturalari = DB::single_query("
SELECT
SUM(ac.girilen_tutar) as girilen_tutar
FROM
     karsiliksiz_cek_senet AS acu
INNER JOIN alinan_cek_urunler as ac on ac.id=acu.alinan_cekid
INNER JOIN alinan_cek_giris as acg on acg.id=ac.alinan_cekid
WHERE acu.status=1 AND ac.status!=0  AND acg.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acu.insert_datetime BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        if ($satis_faturalari > 0) {
            $cari_devir_borc += floatval($satis_faturalari["girilen_tutar"]);
        }
        $satis_faturalari = DB::single_query("SELECT
SUM(acu.girilen_tutar) as girilen_tutar
FROM
     alinan_senet_urunler AS acu
INNER JOIN alinan_senet_giris AS acg on acg.id=acu.alinan_senetid
WHERE acu.status=1 AND acg.status!=0 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acu.vade_tarih BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        if ($satis_faturalari > 0) {
            $cari_devir_alacak += floatval($satis_faturalari["girilen_tutar"]);
        }

        $havale_giris = DB::single_query("
SELECT
SUM(hgu.giris_tutar) as giris_tutar
FROM havale_giris_urunler as hgu
INNER JOIN havale_giris AS hg on hg.id=hgu.giris_id
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        if ($havale_giris > 0) {
            $cari_devir_alacak += floatval($havale_giris["giris_tutar"]);
        }

        $havale_cikis = DB::single_query("
SELECT
SUM(hgu.cikis_tutar) as cikis_tutar
FROM havale_cikis_urunler as hgu
INNER JOIN havale_cikis AS hg on hg.id=hgu.cikis_id
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        if ($havale_cikis > 0) {
            $cari_devir_borc += floatval($havale_cikis["cikis_tutar"]);
        }

        $kasa_tahsilat = DB::single_query("
SELECT
SUM(hgu.tutar) as tutar
FROM kasa_tahsilat_urunler as hgu
INNER JOIN kasa_tahsilat AS hg on hg.id=hgu.tahsilat_id
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        if ($kasa_tahsilat > 0) {
            $cari_devir_alacak += floatval($kasa_tahsilat["tutar"]);
        }

        $kasa_odeme = DB::single_query("
SELECT
SUM(hgu.tutar) as tutar
FROM kasa_odeme_urunler as hgu
INNER JOIN kasa_odeme AS hg on hg.id=hgu.odeme_id
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");

        if ($kasa_odeme > 0) {
            $cari_devir_borc += floatval($kasa_odeme["tutar"]);
        }

        $mahsup_hareketleri = DB::single_query("
SELECT
SUM(hgu.borc) as borc,
SUM(hgu.alacak) as alacak
FROM cari_mahsup_urunler as hgu
INNER JOIN cari_mahsup AS hg on hg.id=hgu.mahsup_id
WHERE hg.status=1 AND hgu.status=1 and hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");

        if ($mahsup_hareketleri > 0) {
            $cari_devir_alacak += floatval($mahsup_hareketleri["alacak"]);
            $cari_devir_borc += floatval($mahsup_hareketleri["borc"]);
        }

        $acilis_fisi = DB::single_query("
SELECT
SUM(borc) as borc,
SUM(alacak) as alacak
FROM cari_acilis_fisleri
WHERE status=1 AND cari_key='$cari_key' AND cari_id='$cari_id' AND acilis_tarihi BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        if ($acilis_fisi > 0) {
            $cari_devir_alacak += floatval($acilis_fisi["alacak"]);
            $cari_devir_borc += floatval($acilis_fisi["borc"]);
        }

        // BURADAN SONRA
        $alis_faturalari = DB::single_query("
SELECT
SUM(genel_toplam) as genel_toplam
FROM
alis_default
WHERE status=1 AND cari_key='$cari_key' AND cari_id='$cari_id' AND vade_tarihi > '$yil_basi 23:59:59'");
        if ($alis_faturalari > 0) {
            $cari_devir_alacak += floatval($alis_faturalari["genel_toplam"]);
        }
        $gider_faturalari = DB::single_query("
SELECT
mg.fatura_no as belge_no,
mg.fatura_tarihi as tarih,
mg.aciklama,
SUM(mgu.genel_toplam) as tutar
FROM
muhasebe_gider_urunler as mgu
INNER JOIN muhasebe_gider as mg on mgu.gider_id=mg.id
WHERE mg.status=1 AND mg.cari_key='$cari_key' AND mgu.cari_id='$cari_id' AND mg.fatura_tarihi > '$yil_basi 23:59:59' GROUP BY mgu.id");
        if ($gider_faturalari > 0) {
            $cari_devir_alacak += floatval($gider_faturalari["tutar"]);
        }
        $satis_faturalari = DB::single_query("
SELECT
SUM(pta.tutar) as tutar
FROM
personel_tahakkuk as pta
INNER JOIN personel_tanim as pt on pt.id=pta.personel_id
WHERE pta.status=1 AND pta.cari_key='$cari_key' AND pt.personel_kodu='$personel_kodu' AND pta.islem_tarihi > '$yil_basi 23:59:59'");
        if ($satis_faturalari > 0) {
            $cari_devir_alacak += floatval($satis_faturalari["tutar"]);
        }

        $satis_faturalari = DB::single_query("
SELECT
SUM(tutar) as tutar
FROM
pos_cekim
WHERE status=1 AND cari_key='$cari_key' AND cari_id='$cari_id' AND tarih > '$yil_basi 23:59:59'");
        if ($satis_faturalari > 0) {
            $cari_devir_alacak += floatval($satis_faturalari["tutar"]);
        }
        $satis_faturalari = DB::single_query("SELECT
SUM(acu.girilen_tutar) as girilen_tutar
FROM
     alinan_cek_urunler AS acu
INNER JOIN alinan_cek_giris AS acg on acg.id=acu.alinan_cekid
WHERE acu.status!=0 AND acg.status!=0 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acu.vade_tarih > '$yil_basi 23:59:59'");
        if ($satis_faturalari > 0) {
            $cari_devir_alacak += floatval($satis_faturalari["girilen_tutar"]);
        }


        $satis_faturalari = DB::single_query("SELECT
SUM(acu.girilen_tutar) as girilen_tutar
FROM
     alinan_senet_urunler AS acu
INNER JOIN alinan_senet_giris AS acg on acg.id=acu.alinan_senetid
WHERE acu.status=1 AND acg.status!=0 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acu.vade_tarih > '$yil_basi 23:59:59'");
        if ($satis_faturalari > 0) {
            $cari_devir_alacak += floatval($satis_faturalari["girilen_tutar"]);
        }


        $havale_giris = DB::single_query("
SELECT
SUM(hgu.giris_tutar) as giris_tutar
FROM havale_giris_urunler as hgu
INNER JOIN havale_giris AS hg on hg.id=hgu.giris_id
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi > '$yil_basi 23:59:59'");
        if ($havale_giris > 0) {
            $cari_devir_alacak += floatval($havale_giris["giris_tutar"]);
        }


        $kasa_tahsilat = DB::single_query("
SELECT
SUM(hgu.tutar) as tutar
FROM kasa_tahsilat_urunler as hgu
INNER JOIN kasa_tahsilat AS hg on hg.id=hgu.tahsilat_id
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi > '$yil_basi 23:59:59'");
        if ($kasa_tahsilat > 0) {
            $cari_devir_alacak += floatval($kasa_tahsilat["tutar"]);
        }


        $mahsup_hareketleri = DB::single_query("
SELECT
SUM(hgu.borc) as borc,
SUM(hgu.alacak) as alacak
FROM cari_mahsup_urunler as hgu
INNER JOIN cari_mahsup AS hg on hg.id=hgu.mahsup_id
WHERE hg.status=1 AND hgu.status=1 and hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi > '$yil_basi 23:59:59'");

        if ($mahsup_hareketleri > 0) {
            $cari_devir_alacak += floatval($mahsup_hareketleri["alacak"]);
        }

        $acilis_fisi = DB::single_query("
SELECT
SUM(borc) as borc,
SUM(alacak) as alacak
FROM cari_acilis_fisleri
WHERE status=1 AND cari_key='$cari_key' AND cari_id='$cari_id' AND acilis_tarihi > '$yil_basi 23:59:59'");
        if ($acilis_fisi > 0) {
            $cari_devir_alacak += floatval($acilis_fisi["alacak"]);
        }


        $cari_devir_bakiye = floatval($cari_devir_borc) - floatval($cari_devir_alacak);
        if ($cari_devir_bakiye < 0) {
            $cari_devir_bakiye = -$cari_devir_bakiye;
            $b_durum = "A";
        } else {
            $b_durum = "B";
        }
        $devir_arr = [
            'cari_id' => $cari_id,
            'bakiye' => $cari_devir_bakiye,
        ];
        array_push($vadesi_gecmis_arr, $devir_arr);
    }
    // BURAYA KADAR OLAN KISIM VADESİ GEÇMİŞ BORÇLARI HESAPLAMAK İÇİN AŞŞAĞIDAKİ FOREACH İSE CARİNİN TÜM BAKİYESİNİ GETİRİYOR
    $ekstre_arr = [];
    foreach ($vadesi_gecmis_arr as $item2) {
        $cari_id = $item2["cari_id"];
        $sql = "
SELECT 
        c.*,
        (select SUM(tl_tutar) from yakit_cikis_fisleri as ycf where ycf.kiralik_cari_id=c.id and ycf.status!=0 and ycf.cari_key='$cari_key') as borc10,  
       (select SUM(genel_toplam) FROM alis_default as ad WHERE ad.cari_id=c.id AND ad.status=1 AND ad.fatura_tarihi < '$yil_basi 23:59:59') as alacak1,
  
       (select SUM(genel_toplam) from satis_default as sd WHERE sd.cari_id=c.id AND sd.status=1 AND sd.fatura_tarihi < '$yil_basi 23:59:59') as borc1,
       (
       select 
       SUM(asu.toplam_tutar) 
from araclara_stok_cik as arac
 INNER JOIN araclara_stok_urunler as asu on asu.ana_id=arac.id 
 INNER JOIN arac_kartlari as ak on ak.id=asu.plaka_id
WHERE arac.status=1 AND asu.status=1 AND arac.cari_key='$cari_key' AND ak.cari_id=c.id AND arac.tarih < '$yil_basi 23:59:59') as borc11,
       
       (select SUM(bsfu.genel_toplam) FROM binek_sanayi_fatura as bsf INNER JOIN binek_sanayi_fatura_urunler as bsfu on bsfu.fatura_id=bsf.id WHERE bsf.status=1 AND bsfu.status=1 AND bsf.cari_id=c.id AND bsf.fatura_tarih < '$yil_basi 23:59:59') as alacak2,
       
       (select SUM(byc.tl_tutar) FROM binek_yakit_fatura as byf INNER JOIN binek_fis_faturasi as bff on bff.fatura_id=byf.id INNER JOIN binek_yakit_cikis as byc on byc.id=bff.yakit_fis_id WHERE byf.status=1 AND bff.status=1 AND byf.cari_id=c.id AND byf.fatura_tarihi < '$yil_basi 23:59:59') as alacak3,
       
       (select SUM(lafu.toplam) from lastik_alis_fatura as laf inner join lastik_alis_fatura_urunler as lafu on  lafu.fatura_id=laf.id WHERE laf.status=1 AND lafu.status=1 AND laf.cari_id=c.id AND laf.fatura_tarihi < '$yil_basi 23:59:59') as alacak4,
       
       (select SUM(ccu.girilen_tutar) from cikis_cek_urunler as ccu inner join alinan_cek_cikis as acc on acc.id=ccu.cikis_cekid WHERE ccu.status!=0 AND acc.status!=0 AND acc.cari_id=c.id AND acc.tarih < '$yil_basi 23:59:59') as borc2,
       
       (select SUM(vgf.tutar) from vergi_gider as vg inner join vergi_gider_fisi as vgf on vgf.gider_id=vg.id WHERE vg.status=1 AND vgf.status=1 AND vgf.cari_id=c.id AND vgf.tarih < '$yil_basi 23:59:59') as alacak5,
       
       (select SUM(ygf.tutar) from yonetim_gider as yg inner join yonetim_gider_fisi as ygf on ygf.gider_id=yg.id WHERE ygf.status=1 AND yg.status=1 AND ygf.cari_id=c.id AND ygf.tarih < '$yil_basi 23:59:59') as alacak6,
       
       (select SUM(sgf.tutar) from sgk_giderleri as sg inner join sgk_gider_fisleri as sgf on sgf.gider_id=sg.id WHERE sg.status=1 AND sgf.status=1 AND sgf.cari_id=c.id AND sgf.tarih < '$yil_basi 23:59:59') as alacak7,
       
       (select SUM(agf.tutar) from arac_gider as ag inner join arac_gider_fisi as agf on agf.gider_id=ag.id WHERE ag.status=1 AND agf.status=1 AND agf.cari_id=c.id AND agf.tarih < '$yil_basi 23:59:59') as alacak8,
       
       (select SUM(mgu.genel_toplam) from muhasebe_gider as mg inner join muhasebe_gider_urunler as mgu on mgu.gider_id=mg.id WHERE mg.status=1 AND mgu.status=1 AND mgu.cari_id=c.id AND mg.fatura_tarihi < '$yil_basi 23:59:59') as alacak9,
       
       (select SUM(sfu.genel_toplam) from sanayi_fatura as sf inner join sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id WHERE sf.status=1 AND sfu.status=1 AND sf.cari_id=c.id AND sf.fatura_tarih < '$yil_basi 23:59:59') as alacak10,
       
       (select SUM(pta.tutar) from personel_tahakkuk as pta inner join personel_tanim as pt on pt.id=pta.personel_id WHERE pta.status=1 AND pt.personel_kodu=c.cari_kodu AND pta.islem_tarihi < '$yil_basi 23:59:59') as alacak11,
       
       (select SUM(pc.tutar) from pos_cekim as pc WHERE pc.cari_id=c.id AND pc.status=1 AND pc.tarih < '$yil_basi 23:59:59') as alacak12,
    
       (select SUM(kh.tutar) from kart_harcama as kh WHERE kh.cari_id=c.id AND kh.status=1 AND kh.tarih < '$yil_basi 23:59:59') as borc3,
       
       (select SUM(acu.girilen_tutar) from alinan_cek_urunler as acu inner join alinan_cek_giris as acg on acg.id=acu.alinan_cekid WHERE acg.status!=0 AND acu.status!=0 AND acu.bizim=2 AND acg.acilis_mi!=2 AND acg.cari_id=c.id AND acg.tarih < '$yil_basi 23:59:59') as alacak13,
       
       (select SUM(bcu.tutar) from bizim_cek_cikis as bcc inner join bizim_cek_urunler as bcu on bcu.bizim_cekid=bcc.id WHERE bcu.status!=0 AND bcc.status!=0 AND bcc.cari_id=c.id AND bcc.tarih < '$yil_basi 23:59:59') as borc4,
       
      (select SUM(acu2.girilen_tutar) from karsiliksiz_cek_senet as kcs inner join alinan_cek_urunler as acu2 on acu2.id=kcs.alinan_cekid inner join alinan_cek_giris as acg on acg.id=acu2.alinan_cekid WHERE kcs.status=1 AND acg.status!=0 AND acg.cari_id=c.id AND kcs.insert_datetime < '$yil_basi 23:59:59')as borc5,
       
       (select SUM(asu.girilen_tutar) from alinan_senet_urunler as asu inner join alinan_senet_giris as asg on asg.id=asu.alinan_senetid WHERE asu.status=1 AND asg.status!=0  AND asu.bizim=2 AND asg.cari_id=c.id AND asg.tarih < '$yil_basi 23:59:59') as alacak14,
       
       (select SUM(hgu.giris_tutar) from havale_giris_urunler as hgu inner join havale_giris as hg on hg.id=hgu.giris_id WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_id=c.id AND hg.islem_tarihi < '$yil_basi 23:59:59') as alacak15,
       
       (select SUM(hcu.cikis_tutar) from havale_cikis_urunler as hcu inner join havale_cikis AS hc on hc.id=hcu.cikis_id WHERE hc.status=1 AND hcu.status=1 AND hcu.cari_id=c.id AND hc.islem_tarihi < '$yil_basi 23:59:59') as borc6,
       
       (select SUM(ktu.tutar) from kasa_tahsilat_urunler as ktu inner join kasa_tahsilat as kt on kt.id=ktu.tahsilat_id WHERE kt.status=1 AND ktu.status=1 AND ktu.cari_id=c.id AND kt.islem_tarihi < '$yil_basi 23:59:59') as alacak16,
       
       (select SUM(kou.tutar) from kasa_odeme_urunler as kou inner join kasa_odeme as ko on ko.id=kou.odeme_id WHERE ko.status=1 AND kou.status=1 AND kou.cari_id=c.id AND ko.islem_tarihi < '$yil_basi 23:59:59') as borc7,
       
       (select SUM(cmu1.borc) from cari_mahsup_urunler as cmu1 inner join cari_mahsup as cm1 on cm1.id=cmu1.mahsup_id WHERE cm1.status=1 AND cmu1.status=1 AND cmu1.cari_id=c.id AND cm1.islem_tarihi < '$yil_basi 23:59:59') as borc8,
       
       (select SUM(cmu.alacak) from cari_mahsup_urunler as cmu inner join cari_mahsup as cm on cm.id=cmu.mahsup_id WHERE cm.status=1 AND cmu.status=1 AND cmu.cari_id=c.id AND cm.islem_tarihi < '$yil_basi 23:59:59') as alacak17,
       
       (select SUM(caf1.borc) from cari_acilis_fisleri as caf1 WHERE caf1.cari_id=c.id AND caf1.status=1 AND caf1.acilis_tarihi < '$yil_basi 23:59:59') as borc9,
       
       (select SUM(caf.alacak) from cari_acilis_fisleri as caf WHERE caf.cari_id=c.id and caf.status=1 AND caf.acilis_tarihi < '$yil_basi 23:59:59') as alacak18,
       
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
AND c.id='$cari_id'
";
        if ($cari_turu != "") {
            if ($cari_turu == "0") {

            } else {
                $sql .= " AND c.cari_turu='$cari_turu'";
            }
        }
        $sql .= " GROUP BY 
c.id";

        $dogru_cariler = DB::single_query($sql);


        $cari_devir_borc = 0;
        $cari_devir_alacak = 0;
        $cari_devir_borc += $dogru_cariler["borc1"];
        $cari_devir_borc += $dogru_cariler["borc2"];
        $cari_devir_borc += $dogru_cariler["borc3"];
        $cari_devir_borc += $dogru_cariler["borc4"];
        $cari_devir_borc += $dogru_cariler["borc5"];
        $cari_devir_borc += $dogru_cariler["borc6"];
        $cari_devir_borc += $dogru_cariler["borc7"];
        $cari_devir_borc += $dogru_cariler["borc8"];
        $cari_devir_borc += $dogru_cariler["borc9"];
        $cari_devir_borc += $dogru_cariler["borc10"];

        $cari_devir_alacak += $dogru_cariler["alacak1"];
        $cari_devir_alacak += $dogru_cariler["alacak2"];
        $cari_devir_alacak += $dogru_cariler["alacak3"];
        $cari_devir_alacak += $dogru_cariler["alacak4"];
        $cari_devir_alacak += $dogru_cariler["alacak5"];
        $cari_devir_alacak += $dogru_cariler["alacak6"];
        $cari_devir_alacak += $dogru_cariler["alacak7"];
        $cari_devir_alacak += $dogru_cariler["alacak8"];
        $cari_devir_alacak += $dogru_cariler["alacak9"];
        $cari_devir_alacak += $dogru_cariler["alacak10"];
        $cari_devir_alacak += $dogru_cariler["alacak11"];
        $cari_devir_alacak += $dogru_cariler["alacak12"];
        $cari_devir_alacak += $dogru_cariler["alacak13"];
        $cari_devir_alacak += $dogru_cariler["alacak14"];
        $cari_devir_alacak += $dogru_cariler["alacak15"];
        $cari_devir_alacak += $dogru_cariler["alacak16"];
        $cari_devir_alacak += $dogru_cariler["alacak17"];
        $cari_devir_alacak += $dogru_cariler["alacak18"];

        $cari_devir_bakiye = floatval($cari_devir_borc) - floatval($cari_devir_alacak);
        if ($cari_devir_bakiye < 0) {
            $cari_devir_bakiye = -$cari_devir_bakiye;
            $b_durum = "A";
        } else {
            $b_durum = "B";
            if ($item2["bakiye"] > $cari_devir_bakiye) {
                $item2["bakiye"] = $cari_devir_bakiye;
            }
            if ($item2["bakiye"] != 0) {
                $devir_arr = [
                    'cari_kodu' => $dogru_cariler["cari_kodu"],
                    'cari_unvan' => $dogru_cariler["cari_adi"],
                    'bilanco_kodu' => $dogru_cariler["bilanco_kodu"],
                    'cari_grubu' => $dogru_cariler["cari_grubu"],
                    'borc' => $cari_devir_borc,
                    'alacak' => $cari_devir_alacak,
                    'bakiye' => $cari_devir_bakiye,
                    'vadesi_gecmis' => $item2["bakiye"],
                    'b_durum' => $b_durum
                ];
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
if ($islem == "vadesine_gore_odeme_filtrele") {

    $ilk_vade = $_GET["ilk_vade"];
    $son_vade = $_GET["son_vade"];
    $limit_b = $_GET["bakiye_limit"];
    $cari_grubu = $_GET["cari_grubu"];
    $cari_turu = $_GET["cari_turu"];
    $last_bas_tarih = $ilk_vade;
    $yil_basi = $son_vade;
    $sql = "
SELECT 
       c.cari_kodu,
       c.cari_adi,
       c.aciklama,
       c.id,
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
    if ($cari_grubu != "") {
        if ($cari_grubu == "0") {

        } else {
            $sql .= " AND c.cari_grubu='$cari_grubu'";
        }
    }
    $vadesi_gecmis_arr = [];
    // BURAYA KADAR OLAN KISIM DOĞRU CARİLERİ ÇEKMEK ADINA YAPILAN BİR FİLTRELEME

    $dogru_cariler = DB::all_data($sql);
    foreach ($dogru_cariler as $item) {

        $cari_id = $item["id"];

        $alis_faturalari = DB::single_query("
SELECT
SUM(genel_toplam) as genel_toplam
FROM
alis_default
WHERE status=1 AND cari_key='$cari_key' AND cari_id='$cari_id' AND vade_tarihi BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        $cari_devir_borc = 0;
        $cari_devir_alacak = 0;
        $cari_devir_bakiye = 0;
        $b_durum = "";
        $belge_turu = "";
        if ($alis_faturalari > 0) {
            $cari_devir_alacak += floatval($alis_faturalari["genel_toplam"]);
        }
        $gider_faturalari = DB::single_query("
SELECT
mg.fatura_no as belge_no,
mg.fatura_tarihi as tarih,
mg.aciklama,
SUM(mgu.genel_toplam) as tutar
FROM
muhasebe_gider_urunler as mgu
INNER JOIN muhasebe_gider as mg on mgu.gider_id=mg.id
WHERE mg.status=1 AND mg.cari_key='$cari_key' AND mgu.cari_id='$cari_id' AND mg.fatura_tarihi BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59' GROUP BY mgu.id");
        if ($gider_faturalari > 0) {
            $cari_devir_alacak += floatval($gider_faturalari["tutar"]);
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
WHERE sf.status=1 AND sf.cari_key='$cari_key' AND sf.cari_id='$cari_id' AND sf.fatura_tarih BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59' GROUP BY sf.id");
        if ($sanayi_fis_fat > 0) {
            foreach ($sanayi_fis_fat as $alislar) {
                $cari_devir_alacak += $alislar["genel_toplam"];
            }
        }


        $satis_faturalari = DB::single_query("
SELECT
SUM(genel_toplam) as genel_toplam
FROM
satis_default
WHERE status=1 AND cari_key='$cari_key' AND cari_id='$cari_id' AND vade_tarihi BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        if ($satis_faturalari > 0) {
            $cari_devir_borc += floatval($satis_faturalari["genel_toplam"]);
        }


        $kiralik_yakit_alim = DB::single_query("SELECT SUM(tl_tutar) as tutar FROM yakit_cikis_fisleri WHERE status!=0 AND kiralik_cari_id='$cari_id' AND tarih BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        $cari_devir_borc += $kiralik_yakit_alim["tutar"];

        $personel_kodu = $item["cari_kodu"];
        $satis_faturalari = DB::single_query("
SELECT
SUM(pta.tutar) as tutar
FROM
personel_tahakkuk as pta
INNER JOIN personel_tanim as pt on pt.id=pta.personel_id
WHERE pta.status=1 AND pta.cari_key='$cari_key' AND pt.personel_kodu='$personel_kodu' AND pta.islem_tarihi BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        if ($satis_faturalari > 0) {
            $cari_devir_alacak += floatval($satis_faturalari["tutar"]);
        }
        $kart_islemi = DB::single_query("
SELECT
SUM(tutar) as tutar
FROM kredi_kartindan_odeme
WHERE status=1 AND cari_id='$cari_id' AND cari_key='$cari_key' AND islem_tarihi BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        if ($kart_islemi > 0) {
            $cari_devir_borc += floatval($kart_islemi["tutar"]);
        }

        $satis_faturalari = DB::single_query("
SELECT
SUM(tutar) as tutar
FROM
pos_cekim
WHERE status=1 AND cari_key='$cari_key' AND cari_id='$cari_id' AND tarih BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        if ($satis_faturalari > 0) {
            $cari_devir_alacak += floatval($satis_faturalari["tutar"]);
        }
        $satis_faturalari = DB::single_query("SELECT
SUM(acu.girilen_tutar) as girilen_tutar
FROM
     alinan_cek_urunler AS acu
INNER JOIN alinan_cek_giris AS acg on acg.id=acu.alinan_cekid
WHERE acu.status!=0 AND acg.status!=0 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acu.vade_tarih BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        if ($satis_faturalari > 0) {
            $cari_devir_alacak += floatval($satis_faturalari["girilen_tutar"]);
        }
        $satis_faturalari = DB::single_query("
SELECT
SUM(ac.girilen_tutar) as girilen_tutar
FROM
     karsiliksiz_cek_senet AS acu
INNER JOIN alinan_cek_urunler as ac on ac.id=acu.alinan_cekid
INNER JOIN alinan_cek_giris as acg on acg.id=ac.alinan_cekid
WHERE acu.status=1 AND ac.status!=0  AND acg.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acu.insert_datetime BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        if ($satis_faturalari > 0) {
            $cari_devir_borc += floatval($satis_faturalari["girilen_tutar"]);
        }
        $satis_faturalari = DB::single_query("SELECT
SUM(acu.girilen_tutar) as girilen_tutar
FROM
     alinan_senet_urunler AS acu
INNER JOIN alinan_senet_giris AS acg on acg.id=acu.alinan_senetid
WHERE acu.status=1 AND acg.status!=0 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acu.vade_tarih BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        if ($satis_faturalari > 0) {
            $cari_devir_alacak += floatval($satis_faturalari["girilen_tutar"]);
        }

        $havale_giris = DB::single_query("
SELECT
SUM(hgu.giris_tutar) as giris_tutar
FROM havale_giris_urunler as hgu
INNER JOIN havale_giris AS hg on hg.id=hgu.giris_id
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        if ($havale_giris > 0) {
            $cari_devir_alacak += floatval($havale_giris["giris_tutar"]);
        }

        $havale_cikis = DB::single_query("
SELECT
SUM(hgu.cikis_tutar) as cikis_tutar
FROM havale_cikis_urunler as hgu
INNER JOIN havale_cikis AS hg on hg.id=hgu.cikis_id
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        if ($havale_cikis > 0) {
            $cari_devir_borc += floatval($havale_cikis["cikis_tutar"]);
        }

        $kasa_tahsilat = DB::single_query("
SELECT
SUM(hgu.tutar) as tutar
FROM kasa_tahsilat_urunler as hgu
INNER JOIN kasa_tahsilat AS hg on hg.id=hgu.tahsilat_id
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        if ($kasa_tahsilat > 0) {
            $cari_devir_alacak += floatval($kasa_tahsilat["tutar"]);
        }

        $kasa_odeme = DB::single_query("
SELECT
SUM(hgu.tutar) as tutar
FROM kasa_odeme_urunler as hgu
INNER JOIN kasa_odeme AS hg on hg.id=hgu.odeme_id
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");

        if ($kasa_odeme > 0) {
            $cari_devir_borc += floatval($kasa_odeme["tutar"]);
        }

        $mahsup_hareketleri = DB::single_query("
SELECT
SUM(hgu.borc) as borc,
SUM(hgu.alacak) as alacak
FROM cari_mahsup_urunler as hgu
INNER JOIN cari_mahsup AS hg on hg.id=hgu.mahsup_id
WHERE hg.status=1 AND hgu.status=1 and hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");

        if ($mahsup_hareketleri > 0) {
            $cari_devir_alacak += floatval($mahsup_hareketleri["alacak"]);
            $cari_devir_borc += floatval($mahsup_hareketleri["borc"]);
        }

        $acilis_fisi = DB::single_query("
SELECT
SUM(borc) as borc,
SUM(alacak) as alacak
FROM cari_acilis_fisleri
WHERE status=1 AND cari_key='$cari_key' AND cari_id='$cari_id' AND acilis_tarihi BETWEEN '$last_bas_tarih 00:00:00' AND '$yil_basi 23:59:59'");
        if ($acilis_fisi > 0) {
            $cari_devir_alacak += floatval($acilis_fisi["alacak"]);
            $cari_devir_borc += floatval($acilis_fisi["borc"]);
        }


        $cari_devir_bakiye = floatval($cari_devir_alacak) - floatval($cari_devir_borc);
        if ($cari_devir_bakiye < 0) {
            $cari_devir_bakiye = -$cari_devir_bakiye;
            $b_durum = "B";
        } else {
            $b_durum = "A";
        }
        $devir_arr = [
            'cari_id' => $cari_id,
            'bakiye' => $cari_devir_bakiye
        ];
        array_push($vadesi_gecmis_arr, $devir_arr);
    }
    // BURAYA KADAR OLAN KISIM VADESİ GEÇMİŞ BORÇLARI HESAPLAMAK İÇİN AŞŞAĞIDAKİ FOREACH İSE CARİNİN TÜM BAKİYESİNİ GETİRİYOR
    $ekstre_arr = [];
    foreach ($vadesi_gecmis_arr as $item2) {
        $cari_id = $item2["cari_id"];
        $sql = "
SELECT 
        c.*,
        (select SUM(tl_tutar) from yakit_cikis_fisleri as ycf where ycf.kiralik_cari_id=c.id and ycf.status!=0 and ycf.cari_key='$cari_key') as borc10,  
       (select SUM(genel_toplam) FROM alis_default as ad WHERE ad.cari_id=c.id AND ad.status=1 AND ad.fatura_tarihi < '$yil_basi 23:59:59') as alacak1,
  
       (select SUM(genel_toplam) from satis_default as sd WHERE sd.cari_id=c.id AND sd.status=1 AND sd.fatura_tarihi < '$yil_basi 23:59:59') as borc1,
       (
       select 
       SUM(asu.toplam_tutar) 
from araclara_stok_cik as arac
 INNER JOIN araclara_stok_urunler as asu on asu.ana_id=arac.id 
 INNER JOIN arac_kartlari as ak on ak.id=asu.plaka_id
WHERE arac.status=1 AND asu.status=1 AND arac.cari_key='$cari_key' AND ak.cari_id=c.id AND arac.tarih < '$yil_basi 23:59:59') as borc11,
       
       (select SUM(bsfu.genel_toplam) FROM binek_sanayi_fatura as bsf INNER JOIN binek_sanayi_fatura_urunler as bsfu on bsfu.fatura_id=bsf.id WHERE bsf.status=1 AND bsfu.status=1 AND bsf.cari_id=c.id AND bsf.fatura_tarih < '$yil_basi 23:59:59') as alacak2,
       
       (select SUM(byc.tl_tutar) FROM binek_yakit_fatura as byf INNER JOIN binek_fis_faturasi as bff on bff.fatura_id=byf.id INNER JOIN binek_yakit_cikis as byc on byc.id=bff.yakit_fis_id WHERE byf.status=1 AND bff.status=1 AND byf.cari_id=c.id AND byf.fatura_tarihi < '$yil_basi 23:59:59') as alacak3,
       
       (select SUM(lafu.toplam) from lastik_alis_fatura as laf inner join lastik_alis_fatura_urunler as lafu on  lafu.fatura_id=laf.id WHERE laf.status=1 AND lafu.status=1 AND laf.cari_id=c.id AND laf.fatura_tarihi < '$yil_basi 23:59:59') as alacak4,
       
       (select SUM(ccu.girilen_tutar) from cikis_cek_urunler as ccu inner join alinan_cek_cikis as acc on acc.id=ccu.cikis_cekid WHERE ccu.status!=0 AND acc.status!=0 AND acc.cari_id=c.id AND acc.tarih < '$yil_basi 23:59:59') as borc2,
       
       (select SUM(vgf.tutar) from vergi_gider as vg inner join vergi_gider_fisi as vgf on vgf.gider_id=vg.id WHERE vg.status=1 AND vgf.status=1 AND vgf.cari_id=c.id AND vgf.tarih < '$yil_basi 23:59:59') as alacak5,
       
       (select SUM(ygf.tutar) from yonetim_gider as yg inner join yonetim_gider_fisi as ygf on ygf.gider_id=yg.id WHERE ygf.status=1 AND yg.status=1 AND ygf.cari_id=c.id AND ygf.tarih < '$yil_basi 23:59:59') as alacak6,
       
       (select SUM(sgf.tutar) from sgk_giderleri as sg inner join sgk_gider_fisleri as sgf on sgf.gider_id=sg.id WHERE sg.status=1 AND sgf.status=1 AND sgf.cari_id=c.id AND sgf.tarih < '$yil_basi 23:59:59') as alacak7,
       
       (select SUM(agf.tutar) from arac_gider as ag inner join arac_gider_fisi as agf on agf.gider_id=ag.id WHERE ag.status=1 AND agf.status=1 AND agf.cari_id=c.id AND agf.tarih < '$yil_basi 23:59:59') as alacak8,
       
       (select SUM(mgu.genel_toplam) from muhasebe_gider as mg inner join muhasebe_gider_urunler as mgu on mgu.gider_id=mg.id WHERE mg.status=1 AND mgu.status=1 AND mgu.cari_id=c.id AND mg.fatura_tarihi < '$yil_basi 23:59:59') as alacak9,
       
       (select SUM(sfu.genel_toplam) from sanayi_fatura as sf inner join sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id WHERE sf.status=1 AND sfu.status=1 AND sf.cari_id=c.id AND sf.fatura_tarih < '$yil_basi 23:59:59') as alacak10,
       
       (select SUM(pta.tutar) from personel_tahakkuk as pta inner join personel_tanim as pt on pt.id=pta.personel_id WHERE pta.status=1 AND pt.personel_kodu=c.cari_kodu AND pta.islem_tarihi < '$yil_basi 23:59:59') as alacak11,
       
       (select SUM(pc.tutar) from pos_cekim as pc WHERE pc.cari_id=c.id AND pc.status=1 AND pc.tarih < '$yil_basi 23:59:59') as alacak12,
    
       (select SUM(kh.tutar) from kart_harcama as kh WHERE kh.cari_id=c.id AND kh.status=1 AND kh.tarih < '$yil_basi 23:59:59') as borc3,
       
       (select SUM(acu.girilen_tutar) from alinan_cek_urunler as acu inner join alinan_cek_giris as acg on acg.id=acu.alinan_cekid WHERE acg.status!=0 AND acu.status!=0 AND acu.bizim=2 AND acg.acilis_mi!=2 AND acg.cari_id=c.id AND acg.tarih < '$yil_basi 23:59:59') as alacak13,
       
       (select SUM(bcu.tutar) from bizim_cek_cikis as bcc inner join bizim_cek_urunler as bcu on bcu.bizim_cekid=bcc.id WHERE bcu.status!=0 AND bcc.status!=0 AND bcc.cari_id=c.id AND bcc.tarih < '$yil_basi 23:59:59') as borc4,
       
      (select SUM(acu2.girilen_tutar) from karsiliksiz_cek_senet as kcs inner join alinan_cek_urunler as acu2 on acu2.id=kcs.alinan_cekid inner join alinan_cek_giris as acg on acg.id=acu2.alinan_cekid WHERE kcs.status=1 AND acg.status!=0 AND acg.cari_id=c.id AND kcs.insert_datetime < '$yil_basi 23:59:59')as borc5,
       
       (select SUM(asu.girilen_tutar) from alinan_senet_urunler as asu inner join alinan_senet_giris as asg on asg.id=asu.alinan_senetid WHERE asu.status=1 AND asg.status!=0  AND asu.bizim=2 AND asg.cari_id=c.id AND asg.tarih < '$yil_basi 23:59:59') as alacak14,
       
       (select SUM(hgu.giris_tutar) from havale_giris_urunler as hgu inner join havale_giris as hg on hg.id=hgu.giris_id WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_id=c.id AND hg.islem_tarihi < '$yil_basi 23:59:59') as alacak15,
       
       (select SUM(hcu.cikis_tutar) from havale_cikis_urunler as hcu inner join havale_cikis AS hc on hc.id=hcu.cikis_id WHERE hc.status=1 AND hcu.status=1 AND hcu.cari_id=c.id AND hc.islem_tarihi < '$yil_basi 23:59:59') as borc6,
       
       (select SUM(ktu.tutar) from kasa_tahsilat_urunler as ktu inner join kasa_tahsilat as kt on kt.id=ktu.tahsilat_id WHERE kt.status=1 AND ktu.status=1 AND ktu.cari_id=c.id AND kt.islem_tarihi < '$yil_basi 23:59:59') as alacak16,
       
       (select SUM(kou.tutar) from kasa_odeme_urunler as kou inner join kasa_odeme as ko on ko.id=kou.odeme_id WHERE ko.status=1 AND kou.status=1 AND kou.cari_id=c.id AND ko.islem_tarihi < '$yil_basi 23:59:59') as borc7,
       
       (select SUM(cmu1.borc) from cari_mahsup_urunler as cmu1 inner join cari_mahsup as cm1 on cm1.id=cmu1.mahsup_id WHERE cm1.status=1 AND cmu1.status=1 AND cmu1.cari_id=c.id AND cm1.islem_tarihi < '$yil_basi 23:59:59') as borc8,
       
       (select SUM(cmu.alacak) from cari_mahsup_urunler as cmu inner join cari_mahsup as cm on cm.id=cmu.mahsup_id WHERE cm.status=1 AND cmu.status=1 AND cmu.cari_id=c.id AND cm.islem_tarihi < '$yil_basi 23:59:59') as alacak17,
       
       (select SUM(caf1.borc) from cari_acilis_fisleri as caf1 WHERE caf1.cari_id=c.id AND caf1.status=1 AND caf1.acilis_tarihi < '$yil_basi 23:59:59') as borc9,
       
       (select SUM(caf.alacak) from cari_acilis_fisleri as caf WHERE caf.cari_id=c.id and caf.status=1 AND caf.acilis_tarihi < '$yil_basi 23:59:59') as alacak18,
       
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
AND c.id='$cari_id'
";
        if ($cari_turu != "") {
            if ($cari_turu == "0") {

            } else {
                $sql .= " AND c.cari_turu='$cari_turu'";
            }
        }
        $sql .= " GROUP BY 
c.id";

        $dogru_cariler = DB::single_query($sql);


        $cari_devir_borc = 0;
        $cari_devir_alacak = 0;
        $cari_devir_borc += $dogru_cariler["borc1"];
        $cari_devir_borc += $dogru_cariler["borc2"];
        $cari_devir_borc += $dogru_cariler["borc3"];
        $cari_devir_borc += $dogru_cariler["borc4"];
        $cari_devir_borc += $dogru_cariler["borc5"];
        $cari_devir_borc += $dogru_cariler["borc6"];
        $cari_devir_borc += $dogru_cariler["borc7"];
        $cari_devir_borc += $dogru_cariler["borc8"];
        $cari_devir_borc += $dogru_cariler["borc9"];
        $cari_devir_borc += $dogru_cariler["borc10"];

        $cari_devir_alacak += $dogru_cariler["alacak1"];
        $cari_devir_alacak += $dogru_cariler["alacak2"];
        $cari_devir_alacak += $dogru_cariler["alacak3"];
        $cari_devir_alacak += $dogru_cariler["alacak4"];
        $cari_devir_alacak += $dogru_cariler["alacak5"];
        $cari_devir_alacak += $dogru_cariler["alacak6"];
        $cari_devir_alacak += $dogru_cariler["alacak7"];
        $cari_devir_alacak += $dogru_cariler["alacak8"];
        $cari_devir_alacak += $dogru_cariler["alacak9"];
        $cari_devir_alacak += $dogru_cariler["alacak10"];
        $cari_devir_alacak += $dogru_cariler["alacak11"];
        $cari_devir_alacak += $dogru_cariler["alacak12"];
        $cari_devir_alacak += $dogru_cariler["alacak13"];
        $cari_devir_alacak += $dogru_cariler["alacak14"];
        $cari_devir_alacak += $dogru_cariler["alacak15"];
        $cari_devir_alacak += $dogru_cariler["alacak16"];
        $cari_devir_alacak += $dogru_cariler["alacak17"];
        $cari_devir_alacak += $dogru_cariler["alacak18"];

        $cari_devir_bakiye = floatval($cari_devir_borc) - floatval($cari_devir_alacak);
        if ($cari_devir_bakiye < 0) {
            $cari_devir_bakiye = -$cari_devir_bakiye;
            $b_durum = "A";
            if ($item2["bakiye"] > $cari_devir_bakiye) {
                $item2["bakiye"] = $cari_devir_bakiye;
            }
            if ($item2["bakiye"] != 0 && $cari_devir_bakiye != 0) {
                $devir_arr = [
                    'cari_kodu' => $dogru_cariler["cari_kodu"],
                    'cari_unvan' => $dogru_cariler["cari_adi"],
                    'bilanco_kodu' => $dogru_cariler["bilanco_kodu"],
                    'cari_grubu' => $dogru_cariler["cari_grubu"],
                    'borc' => $cari_devir_borc,
                    'alacak' => $cari_devir_alacak,
                    'bakiye' => $cari_devir_bakiye,
                    'vadesi_gecmis' => $item2["bakiye"],
                    'b_durum' => $b_durum
                ];
                array_push($ekstre_arr, $devir_arr);
            }
        } else {
            $b_durum = "B";
        }
    }
    if (!empty($ekstre_arr)) {
        echo json_encode($ekstre_arr);
    } else {
        echo 2;
    }
}
if ($islem == "aylik_tahsilat_listesi_sql") {

    $hangi_ay = $_GET["hangi_ay"];

    $bas_tarih = date("Y-$hangi_ay-01");
    $son_tarih = new DateTime($bas_tarih);
    $son_tarih->modify('last day of this month');
    $bit_tarih = $son_tarih->format('Y-m-d');

    $limit_b = $_GET["bakiye_limit"];
    $cari_grubu = $_GET["cari_grubu"];
    $cari_turu = $_GET["cari_turu"];
    $sql = "
SELECT 
       c.cari_kodu,
       c.cari_adi,
       c.aciklama,
       c.id,
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
AND c.borc!=0
      ";
    if ($cari_turu != "") {
        if ($cari_turu == "0") {

        } else {
            $sql .= " AND c.cari_turu='$cari_turu'";
        }
    }
    if ($cari_grubu != "") {
        if ($cari_grubu == "0") {

        } else {
            $sql .= " AND c.cari_grubu='$cari_grubu'";
        }
    }
    $ekstre_arr = [];
    // BURAYA KADAR OLAN KISIM DOĞRU CARİLERİ ÇEKMEK ADINA YAPILAN BİR FİLTRELEME

    $dogru_cariler = DB::all_data($sql);
    $last_bas_tarih = $bit_tarih;
    $yil_basi = $bas_tarih;
    foreach ($dogru_cariler as $item) {

        $cari_id = $item["id"];

        $alis_faturalari = DB::all_data("
SELECT
SUM(genel_toplam) as genel_toplam
FROM
alis_default
WHERE status=1 AND cari_key='$cari_key' AND cari_id='$cari_id' AND vade_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$last_bas_tarih 23:59:59'");
        $cari_devir_borc = 0;
        $cari_devir_alacak = 0;
        $cari_devir_bakiye = 0;
        $b_durum = "";
        $belge_turu = "";
        if ($alis_faturalari > 0) {
            $cari_devir_alacak += $alis_faturalari["genel_toplam"];
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
WHERE mg.status=1 AND mg.cari_key='$cari_key' AND mgu.cari_id='$cari_id' AND mg.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$last_bas_tarih 23:59:59' GROUP BY mgu.id");
        if ($gider_faturalari > 0) {
            $cari_devir_alacak += $gider_faturalari["tutar"];
        }

        $satis_faturalari = DB::all_data("
SELECT
SUM(genel_toplam) as genel_toplam
FROM
satis_default
WHERE status=1 AND cari_key='$cari_key' AND cari_id='$cari_id' AND vade_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$last_bas_tarih 23:59:59'");
        if ($satis_faturalari > 0) {
            $cari_devir_borc += $satis_faturalari["genel_toplam"];
        }

        $personel_kodu = $item["cari_kodu"];
        $satis_faturalari = DB::all_data("
SELECT
SUM(pta.tutar) as tutar
FROM
personel_tahakkuk as pta
INNER JOIN personel_tanim as pt on pt.id=pta.personel_id
WHERE pta.status=1 AND pta.cari_key='$cari_key' AND pt.personel_kodu='$personel_kodu' AND pta.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$last_bas_tarih 23:59:59'");
        if ($satis_faturalari > 0) {
            $cari_devir_alacak += $satis_faturalari["tutar"];
        }
        $kart_islemi = DB::all_data("
SELECT
tutar
FROM kredi_kartindan_odeme
WHERE status=1 AND cari_id='$cari_id' AND cari_key='$cari_key' AND islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$last_bas_tarih 23:59:59'");
        if ($kart_islemi > 0) {
            foreach ($kart_islemi as $alislar) {
                $cari_devir_borc += $alislar["tutar"];
            }
        }

        $satis_faturalari = DB::all_data("
SELECT
tutar
FROM
pos_cekim
WHERE status=1 AND cari_key='$cari_key' AND cari_id='$cari_id' AND tarih BETWEEN '$bas_tarih 00:00:00' AND '$last_bas_tarih 23:59:59'");
        if ($satis_faturalari > 0) {
            foreach ($satis_faturalari as $alislar) {
                $cari_devir_alacak += $alislar["tutar"];
            }
        }
        $satis_faturalari = DB::all_data("SELECT
acu.girilen_tutar
FROM
     alinan_cek_urunler AS acu
INNER JOIN alinan_cek_giris AS acg on acg.id=acu.alinan_cekid
WHERE acu.status!=0 AND acg.status!=0 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acu.vade_tarih BETWEEN '$bas_tarih 00:00:00' AND '$last_bas_tarih 23:59:59'");
        if ($satis_faturalari > 0) {
            foreach ($satis_faturalari as $alislar) {
                $cari_devir_alacak += $alislar["girilen_tutar"];
            }
        }
        $satis_faturalari = DB::all_data("
SELECT
acg.tutar
FROM
     bizim_senet_cikis AS acu
INNER JOIN bizim_senet_urunler AS acg on acg.bizim_senetid=acu.id
WHERE acu.status!=0 AND acg.status!=0 AND acu.cari_key='$cari_key' AND acu.cari_id='$cari_id' AND acg.vade_tarih BETWEEN '$bas_tarih 00:00:00' AND '$last_bas_tarih 23:59:59'");
        if ($satis_faturalari > 0) {
            foreach ($satis_faturalari as $alislar) {
                $cari_devir_borc += $alislar["tutar"];
            }
        }
        $satis_faturalari = DB::all_data("
SELECT
acg.tutar
FROM
     bizim_cek_cikis AS acu
INNER JOIN bizim_cek_urunler AS acg on acg.bizim_cekid=acu.id
WHERE acu.status!=0 AND acg.status!=0 AND acu.cari_key='$cari_key' AND acu.cari_id='$cari_id' AND acg.vade_tarih BETWEEN '$bas_tarih 00:00:00' AND '$last_bas_tarih 23:59:59'");
        if ($satis_faturalari > 0) {
            foreach ($satis_faturalari as $alislar) {
                $cari_devir_borc += $alislar["tutar"];
            }
        }
        $satis_faturalari = DB::all_data("
SELECT
ac.girilen_tutar
FROM
     karsiliksiz_cek_senet AS acu
INNER JOIN alinan_cek_urunler as ac on ac.id=acu.alinan_cekid
INNER JOIN alinan_cek_giris as acg on acg.id=ac.alinan_cekid
WHERE acu.status=1 AND ac.status!=0  AND acg.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acu.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$last_bas_tarih 23:59:59'");
        if ($satis_faturalari > 0) {
            foreach ($satis_faturalari as $alislar) {
                $cari_devir_borc += $alislar["girilen_tutar"];
            }
        }
        $satis_faturalari = DB::all_data("SELECT
acu.girilen_tutar
FROM
     alinan_senet_urunler AS acu
INNER JOIN alinan_senet_giris AS acg on acg.id=acu.alinan_senetid
WHERE acu.status=1 AND acg.status!=0 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acu.vade_tarih BETWEEN '$bas_tarih 00:00:00' AND '$last_bas_tarih 23:59:59'");
        if ($satis_faturalari > 0) {
            foreach ($satis_faturalari as $alislar) {
                $cari_devir_alacak += $alislar["girilen_tutar"];
            }
        }

        $havale_giris = DB::all_data("
SELECT
hgu.giris_tutar
FROM havale_giris_urunler as hgu
INNER JOIN havale_giris AS hg on hg.id=hgu.giris_id
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$last_bas_tarih 23:59:59'");
        if ($havale_giris > 0) {
            foreach ($havale_giris as $giris) {
                $cari_devir_alacak += $giris["giris_tutar"];
            }
        }

        $havale_cikis = DB::all_data("
SELECT
hgu.cikis_tutar
FROM havale_cikis_urunler as hgu
INNER JOIN havale_cikis AS hg on hg.id=hgu.cikis_id
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$last_bas_tarih 23:59:59'");
        if ($havale_cikis > 0) {
            foreach ($havale_cikis as $giris) {
                $cari_devir_borc += $giris["cikis_tutar"];
            }
        }

        $kasa_tahsilat = DB::all_data("
SELECT
hgu.tutar
FROM kasa_tahsilat_urunler as hgu
INNER JOIN kasa_tahsilat AS hg on hg.id=hgu.tahsilat_id
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$last_bas_tarih 23:59:59'");
        if ($kasa_tahsilat > 0) {
            foreach ($kasa_tahsilat as $giris) {
                $cari_devir_alacak += $giris["tutar"];
            }
        }

        $kasa_odeme = DB::all_data("
SELECT
hgu.tutar
FROM kasa_odeme_urunler as hgu
INNER JOIN kasa_odeme AS hg on hg.id=hgu.odeme_id
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$last_bas_tarih 23:59:59'");

        if ($kasa_odeme > 0) {
            foreach ($kasa_odeme as $giris) {
                $cari_devir_borc += $giris["tutar"];
            }
        }

        $mahsup_hareketleri = DB::all_data("
SELECT
hgu.borc,
hgu.alacak
FROM cari_mahsup_urunler as hgu
INNER JOIN cari_mahsup AS hg on hg.id=hgu.mahsup_id
WHERE hg.status=1 AND hgu.status=1 and hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$last_bas_tarih 23:59:59'");

        if ($mahsup_hareketleri > 0) {
            foreach ($mahsup_hareketleri as $giris) {
                $cari_devir_alacak += $giris["alacak"];
                $cari_devir_borc += $giris["borc"];
            }
        }

        $acilis_fisi = DB::all_data("
SELECT
borc,
alacak
FROM cari_acilis_fisleri
WHERE status=1 AND cari_key='$cari_key' AND cari_id='$cari_id' AND acilis_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$last_bas_tarih 23:59:59'");
        if ($acilis_fisi > 0) {
            foreach ($acilis_fisi as $giris) {
                $cari_devir_alacak += $giris["alacak"];
                $cari_devir_borc += $giris["borc"];
            }
        }
        $cari_devir_bakiye = floatval($cari_devir_borc) - floatval($cari_devir_alacak);
        $b_durum2 = "";
        if ($cari_devir_bakiye < 0) {
            $b_durum2 = "A";
        } else {
            $b_durum2 = "B";
        }
        if ($cari_devir_bakiye < $limit_b || $b_durum2 == "A") {

        } else {
            if ($cari_devir_bakiye < 0) {
                $cari_devir_bakiye = -$cari_devir_bakiye;
                $b_durum = "A";
            } else {
                $b_durum = "B";
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
    }
    if (!empty($ekstre_arr)) {
        echo json_encode($ekstre_arr);
    } else {
        echo 2;
    }
}