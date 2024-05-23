<?php
include '../DB.php';
date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=UTF-8');
session_start();
DB::connect();
$cari_key = $_SESSION["cari_key"];
$sube_key = $_SESSION["sube_key"];
$islem = $_GET["islem"];

if ($islem == "bilanco_tutarlarini_getir_sql") {
    $kasa_devir_giren_tutar = 0;
    $kasa_devir_cikan_tutar = 0;
    $kasa_devir_bakiye = 0;
    $bas_tarih = "1987-01-01";
    $secilen_ay = $_GET["secilen_ay"];
    $secilen_yil = $_GET["secilen_yil"];
    $bit_tarih = date("Y-m-t", strtotime("$secilen_yil-$secilen_ay-01"));

    $kasa_tahsilat = DB::all_data("
SELECT
tahsilat_toplam
FROM
kasa_tahsilat
WHERE status=1 AND cari_key='$cari_key' AND islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($kasa_tahsilat > 0) {
        foreach ($kasa_tahsilat as $alislar) {
            $kasa_devir_giren_tutar += $alislar["tahsilat_toplam"];
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
WHERE bvgf.status=1 AND bvg.status=1 AND bvg.cari_key='$cari_key' AND bvgf.kasa_id!=0 AND bvg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE bhg.status=1 AND bhgf.status=1 AND bhgf.kasa_id!=0 AND bhg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
     ");
    if ($hgs_gider > 0) {
        foreach ($hgs_gider as $alislar) {
            $kasa_devir_cikan_tutar += $alislar["tutar"];
        }
    }

    $arac_hgs = DB::all_data("
SELECT
       hgf.tutar
FROM
     hgs_gider as hg
INNER JOIN hgs_gider_fisleri as hgf on hgf.gider_id=hg.id
WHERE hg.status=1 AND hgf.status=1 AND hg.cari_key='$cari_key' AND hgf.kasa_id!=0 AND hg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($arac_hgs > 0) {
        foreach ($arac_hgs as $item) {
            $kasa_devir_cikan_tutar += $item["tutar"];
        }
    }

    $arac_sgk = DB::all_data("
SELECT
       sgf.tutar
FROM
     sgk_giderleri as sg
INNER JOIN sgk_gider_fisleri as sgf on sgf.gider_id=sg.id
WHERE sg.status=1 AND sgf.status=1 AND sg.cari_key='$cari_key' AND sgf.kasa_id!=0 AND sg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($arac_sgk > 0) {
        foreach ($arac_sgk as $item) {
            $kasa_devir_cikan_tutar += $item["tutar"];
        }
    }

    $arac_vergi = DB::all_data("
SELECT
       sgf.tutar
FROM
     vergi_gider as sg
INNER JOIN vergi_gider_fisi as sgf on sgf.gider_id=sg.id
WHERE sg.status=1 AND sgf.status=1 AND sg.cari_key='$cari_key' AND sgf.kasa_id!=0 AND sg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($arac_vergi > 0) {
        foreach ($arac_vergi as $item) {
            $kasa_devir_cikan_tutar += $item["tutar"];
        }
    }
    $yonetim_gider = DB::all_data("
SELECT
       sgf.tutar
FROM
     yonetim_gider as sg
INNER JOIN yonetim_gider_fisi as sgf on sgf.gider_id=sg.id
WHERE sg.status=1 AND sgf.status=1 AND sg.cari_key='$cari_key' AND sgf.kasa_id!=0  AND sg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($yonetim_gider > 0) {
        foreach ($yonetim_gider as $item) {
            $kasa_devir_cikan_tutar += $item["tutar"];
        }
    }

    $arac_gider_main = DB::all_data("
SELECT
       sgf.tutar
FROM
     arac_gider as sg
INNER JOIN arac_gider_fisi as sgf on sgf.gider_id=sg.id
WHERE sg.status=1 AND sgf.status=1 AND sg.cari_key='$cari_key' AND sgf.kasa_id!=0  AND sg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($arac_gider_main > 0) {
        foreach ($arac_gider_main as $item) {
            $kasa_devir_cikan_tutar += $item["tutar"];
        }
    }

    $kaza_ceza_gider = DB::all_data("
SELECT
       sgf.tutar
FROM
     kaza_ceza_gider as sg
INNER JOIN kaza_ceza_gider_fisleri as sgf on sgf.gider_id=sg.id
WHERE sg.status=1 AND sgf.status=1 AND sg.cari_key='$cari_key' AND sgf.kasa_id!=0 AND sg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($kaza_ceza_gider > 0) {
        foreach ($kaza_ceza_gider as $item) {
            $kasa_devir_cikan_tutar += $item["tutar"];
        }
    }


    $satis_faturalari = DB::all_data("
SELECT
miktar,
tl_tutar
FROM
binek_yakit_cikis
WHERE status!=0 AND kasa_id!=0  AND tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE pou.status=1 AND pou.cari_key='$cari_key' AND po.status=1 AND po.kasa_id!=0  AND po.odeme_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE ps.status=1 AND psu.status=1 AND ps.cari_key='$cari_key' AND psu.status=1 AND ps.kasa_id!=0  AND ps.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY ps.id
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
WHERE status=1 AND cari_key='$cari_key'  AND islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE tecu.status=1 AND tecu.cari_key='$cari_key' AND tecs.kasa_id!=0 AND tecs.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE tecu.status=1 AND tecu.cari_key='$cari_key' AND tecs.kasa_id!=0 AND tecs.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($havale_cikis > 0) {
        foreach ($havale_cikis as $alislar) {
            $kasa_devir_giren_tutar += $alislar["tutar"];
        }
    }
//    $kasa_odeme = DB::all_data("
//SELECT
//odeme_toplam
//FROM
//kasa_odeme
//WHERE status=1 AND cari_key='$cari_key' AND islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
//");
//    if ($kasa_odeme > 0) {
//        foreach ($kasa_odeme as $alislar) {
//            $kasa_devir_cikan_tutar += $alislar["odeme_toplam"];
//        }
//    }
    $bankaya_yatan = DB::all_data("
SELECT
gonderilen_tutar
FROM
kasadan_bankaya
WHERE status=1 AND cari_key='$cari_key' AND insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE status=1 AND cari_key='$cari_key' AND insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE status=1 AND cari_key='$cari_key' AND insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE status=1 AND cari_key='$cari_key' AND insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE status=1 AND cari_key='$cari_key' AND acilis_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE status=1 AND cari_key='$cari_key' AND acilis_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($kasa_acilis_cikan > 0) {
        foreach ($kasa_acilis_cikan as $alislar) {
            $kasa_devir_cikan_tutar += $alislar["cikan_tutar"];
        }
    }
    $kasa_devir_bakiye = floatval($kasa_devir_giren_tutar) - floatval($kasa_devir_cikan_tutar);

    $banka_devir_yatan = 0;
    $banka_devir_cekilen = 0;
    $havale_giris = DB::all_data("
SELECT
giris_toplam
FROM
havale_giris
WHERE status=1 AND cari_key='$cari_key' AND islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($havale_giris > 0) {
        foreach ($havale_giris as $alislar) {
            $banka_devir_yatan += $alislar["giris_toplam"];
        }
    }

    $prim_odeme = DB::all_data("
SELECT
pou.prim_tutari
FROM
prim_odeme_urunler as pou
INNER JOIN prim_odeme AS po on po.id=pou.odeme_id 
WHERE pou.status=1 AND pou.cari_key='$cari_key' AND po.status=1 AND po.banka_id!=0 AND po.odeme_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($prim_odeme > 0) {
        foreach ($prim_odeme as $alislar) {
            $banka_devir_cekilen += $alislar["prim_tutari"];
        }
    }

    $doviz_alim = DB::single_query("SELECT SUM(doviz_miktari) as doviz_miktari FROM banka_doviz_alim WHERE status=1 AND cari_key='$cari_key' AND tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
        $banka_devir_yatan += ($doviz_alim["doviz_miktari"] * $usd);
    }
    // BURADAK DÜŞECEK OLAN TL HESABI İÇİN GEÇMİŞ SORGU YAPILIR
    $doviz_alim_tl = DB::single_query("SELECT SUM(tl_tutar) as tl_tutar FROM banka_doviz_alim WHERE status=1 AND cari_key='$cari_key'  AND tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $banka_devir_cekilen += $doviz_alim_tl["tl_tutar"];
    $alim_masrafi = DB::single_query("
    SELECT  SUM(masraf_tutari) as masraf_tutari FROM banka_doviz_alim 
WHERE status=1  AND tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
    $banka_devir_cekilen += $alim_masrafi["masraf_tutari"];

    $vergi_gider = DB::all_data("
SELECT
vgf.tutar,
vg.tarih,
vgf.aciklama
FROM
binek_vergi_gider_fisleri as vgf
INNER JOIN binek_vergi_gider as vg on vg.id=vgf.gider_id
WHERE vgf.status=1 AND vg.status=1 AND vgf.cari_key='$cari_key' AND vgf.banka_id!=0 AND vg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($vergi_gider > 0) {
        foreach ($vergi_gider as $alislar) {
            $banka_devir_cekilen += $alislar["tutar"];
        }
    }

    $kredi_kullanim = DB::all_data("
SELECT * FROM kredi_kullanim WHERE status=1 AND cari_key='$cari_key' AND kullanim_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($kredi_kullanim > 0) {
        foreach ($kredi_kullanim as $alislar) {
            $kredi_tutari = floatval($alislar["kredi_tutari"]);
            $masraf_bedeli = floatval($alislar["kredi_kesintisi"]);
            $yansiyacak = $kredi_tutari - $masraf_bedeli;

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
WHERE kto.status=1 AND kto.cari_key='$cari_key' AND kto.odeme_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($kredi_odeme > 0) {
        foreach ($kredi_odeme as $alislar) {
            $banka_devir_cekilen += $alislar["toplam_odeme"];
        }
    }

    // DÖVİZ SATIM
    $doviz_alim = DB::single_query("SELECT SUM(tl_tutar) as doviz_miktari FROM banka_doviz_satim WHERE status=1 AND cari_key='$cari_key' AND tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $banka_devir_cekilen += $doviz_alim["doviz_miktari"];

    $doviz_alim_tl = DB::single_query("SELECT SUM(tl_tutar) as tl_tutar FROM banka_doviz_satim WHERE status=1 AND cari_key='$cari_key'  AND tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $banka_devir_yatan += $doviz_alim_tl["tl_tutar"];

    $alim_masrafi = DB::single_query("
    SELECT  SUM(masraf_tutari) as masraf_tutari FROM banka_doviz_satim 
WHERE  status=1 AND tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
    $banka_devir_cekilen += $alim_masrafi["masraf_tutari"];

    $binek_yakit_alim = DB::all_data("
SELECT
       byc.*,
       bk.arac_plaka
FROM
     binek_yakit_cikis as byc
INNER JOIN binek_kartlari as bk on bk.id=byc.plaka_id
WHERE
      byc.status!=0 AND byc.cari_key='$cari_key' AND byc.banka_id!=0 AND byc.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($binek_yakit_alim > 0) {
        foreach ($binek_yakit_alim as $alislar) {
            $banka_devir_cekilen += $alislar["tl_tutar"];
        }
    }


    $havale_cikis = DB::all_data("
SELECT
tecu.tutar
FROM
tahsil_edilen_cek_urunler as tecu
INNER JOIN tahsil_edilen_cek_senet as tecs on tecs.id=tecu.tahsil_id
WHERE tecu.status=1 AND tecu.banka_id!=0 AND tecu.cari_key='$cari_key' AND tecs.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE ps.status=1 AND psu.status=1 AND ps.cari_key='$cari_key' AND ps.banka_id!=0 AND psu.status=1 AND ps.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY ps.id
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
WHERE pct.status=1 AND pct.cari_key='$cari_key' AND pct.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE tecu.status=1 AND tecu.banka_id!=0 AND tecu.cari_key='$cari_key' AND tecs.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE tecu.status=1 AND tecu.banka_id!=0 AND tecu.cari_key='$cari_key' AND tecs.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($havale_cikis > 0) {
        foreach ($havale_cikis as $alislar) {
            $banka_devir_yatan += $alislar["tutar"];
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
WHERE agf.status=1 AND ag.status=1 AND agf.banka_id!=0 AND agf.cari_key='$cari_key' AND ag.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE sgf.status=1 AND sg.status=1 AND sgf.banka_id!=0 AND sgf.cari_key='$cari_key' AND sg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE vgf.status=1 AND vg.status=1 AND vgf.banka_id!=0 AND vgf.cari_key='$cari_key' AND vg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE ygf.status=1 AND yg.status=1 AND ygf.banka_id!=0 AND ygf.cari_key='$cari_key' AND yg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE hgf.status=1 AND hg.status=1 AND hgf.banka_id!=0 AND hgf.cari_key='$cari_key' AND hg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE hgf.status=1 AND hg.status=1 AND hgf.banka_id!=0 AND hgf.cari_key='$cari_key' AND hg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE hgf.status=1 AND hg.status=1 AND hgf.banka_id!=0 AND hgf.cari_key='$cari_key' AND hg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE tecu.status=1 AND tecu.banka_id!=0 AND tecu.cari_key='$cari_key' AND tecs.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE status=1 AND cari_key='$cari_key' AND islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE status=1 AND cari_key='$cari_key' AND insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE status=1 AND cari_key='$cari_key' AND insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");

    if ($bankadan_cekilen > 0) {
        foreach ($bankadan_cekilen as $alislar) {
            $banka_devir_cekilen += $alislar["gonderilen_tutar"];
        }
    }
    $acilis_fisleri = DB::all_data("
SELECT
yatan_tutar,
cekilen_tutar
FROM
banka_acilis_fisi
WHERE status=1 AND cari_key='$cari_key' AND acilis_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE status=1 AND banka_id!=0 AND cari_key='$cari_key' AND islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");

    if ($kart_odeme > 0) {
        foreach ($kart_odeme as $alislar) {
            $banka_devir_cekilen += $alislar["tutar"];
        }
    }

    $verilen_cekler_toplam = 0;
    $alinan_cekler_toplam = 0;
    $verilen_senetler_toplam = 0;

    $alinan_cek_giris = DB::single_query("
SELECT
SUM(acu.girilen_tutar) as girilen_tutar
FROM
     alinan_cek_urunler AS acu
INNER JOIN alinan_cek_giris AS acg on acg.id=acu.alinan_cekid
WHERE acu.status!=0 AND acg.status!=0 AND acu.cari_key='$cari_key' AND acu.bizim=2   AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' AND acu.vade_tarih > '$bit_tarih 00:00:00'");

    $cikis_cek_urunler = DB::single_query("
SELECT
SUM(acu.girilen_tutar) as girilen_tutar
FROM
     cikis_cek_urunler AS acu
INNER JOIN alinan_cek_cikis AS acg on acg.id=acu.alinan_cekid
WHERE acu.status!=0 AND acu.cari_key='$cari_key' AND acg.banka_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' AND acu.vade_tarih > '$bit_tarih 00:00:00'");


    $verilen_cekler = DB::single_query("
SELECT
SUM(acg.tutar) as tutar
FROM
     bizim_cek_cikis AS acu
INNER JOIN bizim_cek_urunler AS acg on acg.bizim_cekid=acu.id
WHERE acu.status!=0 AND acg.status!=0 AND acg.status!=0 AND acu.cari_key='$cari_key' AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' AND acg.vade_tarih > '$bit_tarih 00:00:00'");

    $verilen_cekler_toplam += $verilen_cekler["tutar"];

    $verilen_senetler = DB::single_query("
SELECT
SUM(acg.tutar) as tutar
FROM
     bizim_senet_cikis AS acu
INNER JOIN bizim_senet_urunler AS acg on acg.bizim_cekid=acu.id
WHERE acu.status=1 AND acg.status=1 AND acg.status!=0 AND acu.cari_key='$cari_key' AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

    $verilen_senetler_toplam += $verilen_senetler["tutar"];

    $alinan_cekler_toplam += $alinan_cek_giris["girilen_tutar"];
    $alinan_cekler_toplam += $cikis_cek_urunler["girilen_tutar"];


    $banka_bakiye = floatval($banka_devir_yatan) - floatval($banka_devir_cekilen);

    $alinan_senet_giris = DB::single_query("
SELECT
SUM(acu.girilen_tutar) as girilen_tutar
FROM
     alinan_senet_urunler AS acu
INNER JOIN alinan_senet_giris AS acg on acg.id=acu.alinan_cekid
WHERE acu.status=1 AND acg.status=1 AND acu.cari_key='$cari_key' AND acu.bizim=2 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

    $alinan_senet_cikis = DB::single_query("
SELECT
SUM(acu.girilen_tutar) as girilen_tutar
FROM
     alinan_senet_cikis_urunler AS acu
INNER JOIN alinan_senet_cikis AS acg on acg.id=acu.alinan_cekid
WHERE acu.status=1 AND acu.cari_key='$cari_key' AND acg.banka_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $alinan_senetler_toplam = 0;
    $alinan_senetler_toplam += $alinan_senet_giris["girilen_tutar"];
    $alinan_senetler_toplam += $alinan_senet_cikis["girilen_tutar"];


    $alis_faturalari = DB::all_data("
SELECT
ad.genel_toplam
FROM
alis_default as ad
INNER JOIN cari as c on c.id=ad.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE ad.status=1 AND ad.cari_key='$cari_key' AND ad.cari_id!=0 AND b.bilanco_kodu='M' AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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

    $kiralik_yakit_alim = DB::single_query("
SELECT
       SUM(tl_tutar) as tutar 
FROM
     yakit_cikis_fisleri as ycf
INNER JOIN cari as c on c.id=ycf.kiralik_cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE ycf.status!=0 AND ycf.kiralik_cari_id!=0 AND b.bilanco_kodu='M' AND ycf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_borc += $kiralik_yakit_alim["tutar"];


    $sanayi_fis_fat = DB::all_data("
SELECT
       sf.*,
       c.cari_adi,
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     binek_sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
INNER JOIN binek_sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
WHERE sf.status=1 AND sf.cari_key='$cari_key' AND b.bilanco_kodu='M' AND sf.cari_id!=0 AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(byc.tl_tutar) as tutar
FROM
binek_yakit_fatura as laf
INNER JOIN binek_fis_faturasi as lafu on lafu.fatura_id=laf.id
INNER JOIN binek_yakit_cikis as byc on byc.id=lafu.yakit_fis_id
INNER JOIN cari as c on c.id=laf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='M' AND laf.cari_key='$cari_key' AND laf.cari_id!=0 AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


    $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='M' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0  AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


    $satis_faturalari = DB::single_query("
SELECT
SUM(acu.girilen_tutar) as tutar
FROM
     cikis_cek_urunler AS acu
INNER JOIN alinan_cek_cikis AS acg on acg.id=acu.cikis_cekid
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='M' AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_borc += $satis_faturalari["tutar"];

    $vergi_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
vergi_gider as laf
INNER JOIN vergi_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='M' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $vergi_gider["tutar"];

    $yonetim_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
yonetim_gider as laf
INNER JOIN yonetim_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='M' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $yonetim_gider["tutar"];


    $sgk_gider_fisleri = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar 
FROM
     sgk_giderleri as laf
INNER JOIN sgk_gider_fisleri as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='M' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $sgk_gider_fisleri["tutar"];


    $arac_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
     arac_gider as laf
INNER JOIN arac_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='M' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $arac_gider["tutar"];

    $gider_faturalari = DB::all_data("
SELECT
mg.fatura_no as belge_no,
mg.fatura_tarihi as tarih,
mg.aciklama,
SUM(mgu.genel_toplam) as tutar
FROM
muhasebe_gider_urunler as mgu
INNER JOIN muhasebe_gider as mg on mgu.gider_id=mg.id
INNER JOIN cari as c on c.id=mgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE mg.status=1 AND mg.cari_key='$cari_key' AND b.bilanco_kodu='M' AND mgu.cari_id!=0 AND mg.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY mgu.id");
    if ($gider_faturalari > 0) {
        foreach ($gider_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["tutar"];
        }
    }

    $lastik_alis_faturalari = DB::all_data("
SELECT
laf.genel_toplam,
laf.fatura_tarihi,
laf.fatura_no,
laf.aciklama,
laf.vade_tarihi
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.fatura_id=laf.id
INNER JOIN cari as c on c.id=laf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='M' AND laf.cari_key='$cari_key' AND laf.cari_id!=0 AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($lastik_alis_faturalari > 0) {
        foreach ($lastik_alis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $sanayi_fis_fat = DB::all_data("
SELECT
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE sf.status=1 AND b.bilanco_kodu='M' AND sf.cari_key='$cari_key' AND sf.cari_id!=0 AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $satis_faturalari = DB::all_data("
SELECT
sd.genel_toplam
FROM
satis_default as sd
INNER JOIN cari as c on c.id=sd.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE sd.status=1 AND sd.cari_key='$cari_key' AND b.bilanco_kodu='M' AND sd.cari_id!=0 AND sd.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $cari_devir_borc += $alislar["genel_toplam"];
        }
    }
    $kart_islemi = DB::all_data("
SELECT
kh.tutar
FROM kart_harcama as kh
INNER JOIN cari as c on c.id=kh.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE kh.status=1 AND kh.cari_id!=0 AND b.bilanco_kodu='M' AND kh.cari_key='$cari_key' AND kh.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($kart_islemi > 0) {
        foreach ($kart_islemi as $alislar) {
            $cari_devir_borc += $alislar["tutar"];
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
pc.tutar
FROM
pos_cekim as pc
INNER JOIN cari as c on c.id=pc.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE pc.status=1 AND pc.cari_key='$cari_key' AND b.bilanco_kodu='M' AND pc.cari_id!=0 AND pc.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='M' AND acg.acilis_mi!=2 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='M' AND acu.cari_key='$cari_key' AND acu.cari_id!=0 AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='M' AND acu.acilis_mi!=2 AND acu.cari_key='$cari_key' AND acu.cari_id!=0 AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND ac.status!=0 AND b.bilanco_kodu='M' AND acg.acilis_mi!=2  AND acg.cari_key='$cari_key' AND acg.cari_id!=0 AND acu.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND acg.status!=0 AND b.bilanco_kodu='M' AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='M' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='M' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='M' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='M' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='M' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

    if ($mahsup_hareketleri > 0) {
        foreach ($mahsup_hareketleri as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
        }
    }

    $acilis_fisi = DB::all_data("
SELECT
caf.borc,
caf.alacak
FROM cari_acilis_fisleri as caf
INNER JOIN cari as c on c.id=caf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE caf.status=1 AND caf.cari_key='$cari_key' AND b.bilanco_kodu='M' AND caf.cari_id!=0 AND caf.acilis_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($acilis_fisi > 0) {
        foreach ($acilis_fisi as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
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
    INNER JOIN cari as c on c.id=ak.cari_id
    INNER JOIN bilancolar as b on c.bilanco_id=b.id
    WHERE arac.status=1 AND asu.status=1 AND b.bilanco_kodu='M' AND arac.cari_key='$cari_key' AND arac.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
    ");
    if ($stok_cikisi > 0) {
        foreach ($stok_cikisi as $alislar) {
            $cari_devir_borc += $alislar["toplam_tutar"];
        }
    }

    $musteri_total = $cari_devir_borc - $cari_devir_alacak;


    $cari_devir_borc = 0;
    $cari_devir_alacak = 0;
    $alis_faturalari = DB::all_data("
SELECT
ad.genel_toplam
FROM
alis_default as ad
INNER JOIN cari as c on c.id=ad.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE ad.status=1 AND ad.cari_key='$cari_key' AND ad.cari_id!=0 AND b.bilanco_kodu='PA' AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

    $b_durum = "";
    $belge_turu = "";
    if ($alis_faturalari > 0) {
        foreach ($alis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $kiralik_yakit_alim = DB::single_query("
SELECT
       SUM(tl_tutar) as tutar 
FROM
     yakit_cikis_fisleri as ycf
INNER JOIN cari as c on c.id=ycf.kiralik_cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE ycf.status!=0 AND ycf.kiralik_cari_id!=0 AND b.bilanco_kodu='PA' AND ycf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_borc += $kiralik_yakit_alim["tutar"];


    $sanayi_fis_fat = DB::all_data("
SELECT
       sf.*,
       c.cari_adi,
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     binek_sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
INNER JOIN binek_sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
WHERE sf.status=1 AND sf.cari_key='$cari_key' AND b.bilanco_kodu='PA' AND sf.cari_id!=0 AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(byc.tl_tutar) as tutar
FROM
binek_yakit_fatura as laf
INNER JOIN binek_fis_faturasi as lafu on lafu.fatura_id=laf.id
INNER JOIN binek_yakit_cikis as byc on byc.id=lafu.yakit_fis_id
INNER JOIN cari as c on c.id=laf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='PA' AND laf.cari_key='$cari_key' AND laf.cari_id!=0 AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


    $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='PA' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0  AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


    $satis_faturalari = DB::single_query("
SELECT
SUM(acu.girilen_tutar) as tutar
FROM
     cikis_cek_urunler AS acu
INNER JOIN alinan_cek_cikis AS acg on acg.id=acu.cikis_cekid
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='PA' AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_borc += $satis_faturalari["tutar"];

    $vergi_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
vergi_gider as laf
INNER JOIN vergi_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='PA' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $vergi_gider["tutar"];

    $yonetim_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
yonetim_gider as laf
INNER JOIN yonetim_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='PA' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $yonetim_gider["tutar"];


    $sgk_gider_fisleri = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar 
FROM
     sgk_giderleri as laf
INNER JOIN sgk_gider_fisleri as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='PA' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $sgk_gider_fisleri["tutar"];


    $arac_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
     arac_gider as laf
INNER JOIN arac_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='PA' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $arac_gider["tutar"];

    $gider_faturalari = DB::all_data("
SELECT
mg.fatura_no as belge_no,
mg.fatura_tarihi as tarih,
mg.aciklama,
SUM(mgu.genel_toplam) as tutar
FROM
muhasebe_gider_urunler as mgu
INNER JOIN muhasebe_gider as mg on mgu.gider_id=mg.id
INNER JOIN cari as c on c.id=mgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE mg.status=1 AND mg.cari_key='$cari_key' AND b.bilanco_kodu='PA' AND mgu.cari_id!=0 AND mg.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY mgu.id");
    if ($gider_faturalari > 0) {
        foreach ($gider_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["tutar"];
        }
    }

    $lastik_alis_faturalari = DB::all_data("
SELECT
laf.genel_toplam,
laf.fatura_tarihi,
laf.fatura_no,
laf.aciklama,
laf.vade_tarihi
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.fatura_id=laf.id
INNER JOIN cari as c on c.id=laf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='PA' AND laf.cari_key='$cari_key' AND laf.cari_id!=0 AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($lastik_alis_faturalari > 0) {
        foreach ($lastik_alis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $sanayi_fis_fat = DB::all_data("
SELECT
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE sf.status=1 AND b.bilanco_kodu='PA' AND sf.cari_key='$cari_key' AND sf.cari_id!=0 AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $satis_faturalari = DB::all_data("
SELECT
sd.genel_toplam
FROM
satis_default as sd
INNER JOIN cari as c on c.id=sd.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE sd.status=1 AND sd.cari_key='$cari_key' AND b.bilanco_kodu='PA' AND sd.cari_id!=0 AND sd.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $cari_devir_borc += $alislar["genel_toplam"];
        }
    }
    $kart_islemi = DB::all_data("
SELECT
kh.tutar
FROM kart_harcama as kh
INNER JOIN cari as c on c.id=kh.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE kh.status=1 AND kh.cari_id!=0 AND b.bilanco_kodu='PA' AND kh.cari_key='$cari_key' AND kh.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($kart_islemi > 0) {
        foreach ($kart_islemi as $alislar) {
            $cari_devir_borc += $alislar["tutar"];
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
pc.tutar
FROM
pos_cekim as pc
INNER JOIN cari as c on c.id=pc.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE pc.status=1 AND pc.cari_key='$cari_key' AND b.bilanco_kodu='PA' AND pc.cari_id!=0 AND pc.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='PA' AND acg.acilis_mi!=2 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='PA' AND acu.cari_key='$cari_key' AND acu.cari_id!=0 AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='PA' AND acu.acilis_mi!=2 AND acu.cari_key='$cari_key' AND acu.cari_id!=0 AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND ac.status!=0 AND b.bilanco_kodu='PA' AND acg.acilis_mi!=2  AND acg.cari_key='$cari_key' AND acg.cari_id!=0 AND acu.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND acg.status!=0 AND b.bilanco_kodu='PA' AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='PA' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='PA' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='PA' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='PA' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='PA' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

    if ($mahsup_hareketleri > 0) {
        foreach ($mahsup_hareketleri as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
        }
    }

    $satis_faturalari = DB::all_data("
SELECT
pta.tutar
FROM
personel_tahakkuk as pta
INNER JOIN personel_tanim as pt on pt.id=pta.personel_id
INNER JOIN personel_tahakkuk_ana as pta2 on pta2.id=pta.tahakuk_id
WHERE pta.status=1 AND pta.cari_key='$cari_key' AND  pta2.olusturma_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["tutar"];
        }
    }

    $acilis_fisi = DB::all_data("
SELECT
caf.borc,
caf.alacak
FROM cari_acilis_fisleri as caf
INNER JOIN cari as c on c.id=caf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE caf.status=1 AND caf.cari_key='$cari_key' AND b.bilanco_kodu='PA' AND caf.cari_id!=0 AND caf.acilis_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($acilis_fisi > 0) {
        foreach ($acilis_fisi as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
        }
    }
    $personel_total = $cari_devir_borc - $cari_devir_alacak;

    $cari_devir_borc = 0;
    $cari_devir_alacak = 0;
    $alis_faturalari = DB::all_data("
SELECT
ad.genel_toplam
FROM
alis_default as ad
INNER JOIN cari as c on c.id=ad.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE ad.status=1 AND ad.cari_key='$cari_key' AND ad.cari_id!=0 AND b.bilanco_kodu='DVA' AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

    $b_durum = "";
    $belge_turu = "";
    if ($alis_faturalari > 0) {
        foreach ($alis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $kiralik_yakit_alim = DB::single_query("
SELECT
       SUM(tl_tutar) as tutar 
FROM
     yakit_cikis_fisleri as ycf
INNER JOIN cari as c on c.id=ycf.kiralik_cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE ycf.status!=0 AND ycf.kiralik_cari_id!=0 AND b.bilanco_kodu='DVA' AND ycf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_borc += $kiralik_yakit_alim["tutar"];


    $sanayi_fis_fat = DB::all_data("
SELECT
       sf.*,
       c.cari_adi,
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     binek_sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
INNER JOIN binek_sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
WHERE sf.status=1 AND sf.cari_key='$cari_key' AND b.bilanco_kodu='DVA' AND sf.cari_id!=0 AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(byc.tl_tutar) as tutar
FROM
binek_yakit_fatura as laf
INNER JOIN binek_fis_faturasi as lafu on lafu.fatura_id=laf.id
INNER JOIN binek_yakit_cikis as byc on byc.id=lafu.yakit_fis_id
INNER JOIN cari as c on c.id=laf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='DVA' AND laf.cari_key='$cari_key' AND laf.cari_id!=0 AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


    $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='DVA' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0  AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


    $satis_faturalari = DB::single_query("
SELECT
SUM(acu.girilen_tutar) as tutar
FROM
     cikis_cek_urunler AS acu
INNER JOIN alinan_cek_cikis AS acg on acg.id=acu.cikis_cekid
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='DVA' AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_borc += $satis_faturalari["tutar"];

    $vergi_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
vergi_gider as laf
INNER JOIN vergi_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='DVA' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $vergi_gider["tutar"];

    $yonetim_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
yonetim_gider as laf
INNER JOIN yonetim_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='DVA' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $yonetim_gider["tutar"];


    $sgk_gider_fisleri = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar 
FROM
     sgk_giderleri as laf
INNER JOIN sgk_gider_fisleri as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='DVA' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $sgk_gider_fisleri["tutar"];


    $arac_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
     arac_gider as laf
INNER JOIN arac_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='DVA' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $arac_gider["tutar"];

    $gider_faturalari = DB::all_data("
SELECT
mg.fatura_no as belge_no,
mg.fatura_tarihi as tarih,
mg.aciklama,
SUM(mgu.genel_toplam) as tutar
FROM
muhasebe_gider_urunler as mgu
INNER JOIN muhasebe_gider as mg on mgu.gider_id=mg.id
INNER JOIN cari as c on c.id=mgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE mg.status=1 AND mg.cari_key='$cari_key' AND b.bilanco_kodu='DVA' AND mgu.cari_id!=0 AND mg.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY mgu.id");
    if ($gider_faturalari > 0) {
        foreach ($gider_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["tutar"];
        }
    }

    $lastik_alis_faturalari = DB::all_data("
SELECT
laf.genel_toplam,
laf.fatura_tarihi,
laf.fatura_no,
laf.aciklama,
laf.vade_tarihi
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.fatura_id=laf.id
INNER JOIN cari as c on c.id=laf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='DVA' AND laf.cari_key='$cari_key' AND laf.cari_id!=0 AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($lastik_alis_faturalari > 0) {
        foreach ($lastik_alis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $sanayi_fis_fat = DB::all_data("
SELECT
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE sf.status=1 AND b.bilanco_kodu='DVA' AND sf.cari_key='$cari_key' AND sf.cari_id!=0 AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $satis_faturalari = DB::all_data("
SELECT
sd.genel_toplam
FROM
satis_default as sd
INNER JOIN cari as c on c.id=sd.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE sd.status=1 AND sd.cari_key='$cari_key' AND b.bilanco_kodu='DVA' AND sd.cari_id!=0 AND sd.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $cari_devir_borc += $alislar["genel_toplam"];
        }
    }
    $kart_islemi = DB::all_data("
SELECT
kh.tutar
FROM kart_harcama as kh
INNER JOIN cari as c on c.id=kh.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE kh.status=1 AND kh.cari_id!=0 AND b.bilanco_kodu='DVA' AND kh.cari_key='$cari_key' AND kh.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($kart_islemi > 0) {
        foreach ($kart_islemi as $alislar) {
            $cari_devir_borc += $alislar["tutar"];
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
pc.tutar
FROM
pos_cekim as pc
INNER JOIN cari as c on c.id=pc.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE pc.status=1 AND pc.cari_key='$cari_key' AND b.bilanco_kodu='DVA' AND pc.cari_id!=0 AND pc.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='DVA' AND acg.acilis_mi!=2 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='DVA' AND acu.cari_key='$cari_key' AND acu.cari_id!=0 AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='DVA' AND acu.acilis_mi!=2 AND acu.cari_key='$cari_key' AND acu.cari_id!=0 AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND ac.status!=0 AND b.bilanco_kodu='DVA' AND acg.acilis_mi!=2  AND acg.cari_key='$cari_key' AND acg.cari_id!=0 AND acu.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND acg.status!=0 AND b.bilanco_kodu='DVA' AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='DVA' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='DVA' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='DVA' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='DVA' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='DVA' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

    if ($mahsup_hareketleri > 0) {
        foreach ($mahsup_hareketleri as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
        }
    }

    $acilis_fisi = DB::all_data("
SELECT
caf.borc,
caf.alacak
FROM cari_acilis_fisleri as caf
INNER JOIN cari as c on c.id=caf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE caf.status=1 AND caf.cari_key='$cari_key' AND b.bilanco_kodu='DVA' AND caf.cari_id!=0 AND caf.acilis_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($acilis_fisi > 0) {
        foreach ($acilis_fisi as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
        }
    }

    $diger_varlik_total = $cari_devir_borc - $cari_devir_alacak;


    $cari_devir_borc = 0;
    $cari_devir_alacak = 0;
    $alis_faturalari = DB::all_data("
SELECT
ad.genel_toplam
FROM
alis_default as ad
INNER JOIN cari as c on c.id=ad.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE ad.status=1 AND ad.cari_key='$cari_key' AND ad.cari_id!=0 AND b.bilanco_kodu='SVA' AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($alis_faturalari > 0) {
        foreach ($alis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $kiralik_yakit_alim = DB::single_query("
SELECT
       SUM(tl_tutar) as tutar 
FROM
     yakit_cikis_fisleri as ycf
INNER JOIN cari as c on c.id=ycf.kiralik_cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE ycf.status!=0 AND ycf.kiralik_cari_id!=0 AND b.bilanco_kodu='SVA' AND ycf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_borc += $kiralik_yakit_alim["tutar"];


    $sanayi_fis_fat = DB::all_data("
SELECT
       sf.*,
       c.cari_adi,
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     binek_sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
INNER JOIN binek_sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
WHERE sf.status=1 AND sf.cari_key='$cari_key' AND b.bilanco_kodu='SVA' AND sf.cari_id!=0 AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(byc.tl_tutar) as tutar
FROM
binek_yakit_fatura as laf
INNER JOIN binek_fis_faturasi as lafu on lafu.fatura_id=laf.id
INNER JOIN binek_yakit_cikis as byc on byc.id=lafu.yakit_fis_id
INNER JOIN cari as c on c.id=laf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='SVA' AND laf.cari_key='$cari_key' AND laf.cari_id!=0 AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


    $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='SVA' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0  AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


    $satis_faturalari = DB::single_query("
SELECT
SUM(acu.girilen_tutar) as tutar
FROM
     cikis_cek_urunler AS acu
INNER JOIN alinan_cek_cikis AS acg on acg.id=acu.cikis_cekid
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='SVA' AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_borc += $satis_faturalari["tutar"];

    $vergi_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
vergi_gider as laf
INNER JOIN vergi_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='SVA' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $vergi_gider["tutar"];

    $yonetim_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
yonetim_gider as laf
INNER JOIN yonetim_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='SVA' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $yonetim_gider["tutar"];


    $sgk_gider_fisleri = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar 
FROM
     sgk_giderleri as laf
INNER JOIN sgk_gider_fisleri as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='SVA' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $sgk_gider_fisleri["tutar"];


    $arac_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
     arac_gider as laf
INNER JOIN arac_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='SVA' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $arac_gider["tutar"];

    $gider_faturalari = DB::all_data("
SELECT
mg.fatura_no as belge_no,
mg.fatura_tarihi as tarih,
mg.aciklama,
SUM(mgu.genel_toplam) as tutar
FROM
muhasebe_gider_urunler as mgu
INNER JOIN muhasebe_gider as mg on mgu.gider_id=mg.id
INNER JOIN cari as c on c.id=mgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE mg.status=1 AND mg.cari_key='$cari_key' AND b.bilanco_kodu='SVA' AND mgu.cari_id!=0 AND mg.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY mgu.id");
    if ($gider_faturalari > 0) {
        foreach ($gider_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["tutar"];
        }
    }

    $lastik_alis_faturalari = DB::all_data("
SELECT
laf.genel_toplam,
laf.fatura_tarihi,
laf.fatura_no,
laf.aciklama,
laf.vade_tarihi
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.fatura_id=laf.id
INNER JOIN cari as c on c.id=laf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='SVA' AND laf.cari_key='$cari_key' AND laf.cari_id!=0 AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($lastik_alis_faturalari > 0) {
        foreach ($lastik_alis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $sanayi_fis_fat = DB::all_data("
SELECT
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE sf.status=1 AND b.bilanco_kodu='SVA' AND sf.cari_key='$cari_key' AND sf.cari_id!=0 AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $satis_faturalari = DB::all_data("
SELECT
sd.genel_toplam
FROM
satis_default as sd
INNER JOIN cari as c on c.id=sd.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE sd.status=1 AND sd.cari_key='$cari_key' AND b.bilanco_kodu='SVA' AND sd.cari_id!=0 AND sd.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $cari_devir_borc += $alislar["genel_toplam"];
        }
    }
    $kart_islemi = DB::all_data("
SELECT
kh.tutar
FROM kart_harcama as kh
INNER JOIN cari as c on c.id=kh.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE kh.status=1 AND kh.cari_id!=0 AND b.bilanco_kodu='SVA' AND kh.cari_key='$cari_key' AND kh.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($kart_islemi > 0) {
        foreach ($kart_islemi as $alislar) {
            $cari_devir_borc += $alislar["tutar"];
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
pc.tutar
FROM
pos_cekim as pc
INNER JOIN cari as c on c.id=pc.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE pc.status=1 AND pc.cari_key='$cari_key' AND b.bilanco_kodu='SVA' AND pc.cari_id!=0 AND pc.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='SVA' AND acg.acilis_mi!=2 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='SVA' AND acu.cari_key='$cari_key' AND acu.cari_id!=0 AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='SVA' AND acu.acilis_mi!=2 AND acu.cari_key='$cari_key' AND acu.cari_id!=0 AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND ac.status!=0 AND b.bilanco_kodu='SVA' AND acg.acilis_mi!=2  AND acg.cari_key='$cari_key' AND acg.cari_id!=0 AND acu.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND acg.status!=0 AND b.bilanco_kodu='SVA' AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='SVA' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='SVA' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='SVA' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='SVA' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='SVA' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

    if ($mahsup_hareketleri > 0) {
        foreach ($mahsup_hareketleri as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
        }
    }

    $acilis_fisi = DB::all_data("
SELECT
caf.borc,
caf.alacak
FROM cari_acilis_fisleri as caf
INNER JOIN cari as c on c.id=caf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE caf.status=1 AND caf.cari_key='$cari_key' AND b.bilanco_kodu='SVA' AND caf.cari_id!=0 AND caf.acilis_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($acilis_fisi > 0) {
        foreach ($acilis_fisi as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
        }
    }

    $saticilara_verilen_avanslar = $cari_devir_borc - $cari_devir_alacak;


    $cari_devir_borc = 0;
    $cari_devir_alacak = 0;
    $alis_faturalari = DB::all_data("
SELECT
ad.genel_toplam
FROM
alis_default as ad
INNER JOIN cari as c on c.id=ad.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE ad.status=1 AND ad.cari_key='$cari_key' AND ad.cari_id!=0 AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

    $b_durum = "";
    $belge_turu = "";
    if ($alis_faturalari > 0) {
        foreach ($alis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $kiralik_yakit_alim = DB::single_query("
SELECT
       SUM(tl_tutar) as tutar 
FROM
     yakit_cikis_fisleri as ycf
INNER JOIN cari as c on c.id=ycf.kiralik_cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE ycf.status!=0 AND ycf.kiralik_cari_id!=0 AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND ycf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_borc += $kiralik_yakit_alim["tutar"];


    $sanayi_fis_fat = DB::all_data("
SELECT
       sf.*,
       c.cari_adi,
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     binek_sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
INNER JOIN binek_sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
WHERE sf.status=1 AND sf.cari_key='$cari_key' AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND sf.cari_id!=0 AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(byc.tl_tutar) as tutar
FROM
binek_yakit_fatura as laf
INNER JOIN binek_fis_faturasi as lafu on lafu.fatura_id=laf.id
INNER JOIN binek_yakit_cikis as byc on byc.id=lafu.yakit_fis_id
INNER JOIN cari as c on c.id=laf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND laf.cari_key='$cari_key' AND laf.cari_id!=0 AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


    $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND laf.cari_key='$cari_key' AND lafu.cari_id!=0  AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


    $satis_faturalari = DB::single_query("
SELECT
SUM(acu.girilen_tutar) as tutar
FROM
     cikis_cek_urunler AS acu
INNER JOIN alinan_cek_cikis AS acg on acg.id=acu.cikis_cekid
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_borc += $satis_faturalari["tutar"];

    $vergi_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
vergi_gider as laf
INNER JOIN vergi_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $vergi_gider["tutar"];

    $yonetim_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
yonetim_gider as laf
INNER JOIN yonetim_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $yonetim_gider["tutar"];


    $sgk_gider_fisleri = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar 
FROM
     sgk_giderleri as laf
INNER JOIN sgk_gider_fisleri as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $sgk_gider_fisleri["tutar"];


    $arac_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
     arac_gider as laf
INNER JOIN arac_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $arac_gider["tutar"];

    $gider_faturalari = DB::all_data("
SELECT
mg.fatura_no as belge_no,
mg.fatura_tarihi as tarih,
mg.aciklama,
SUM(mgu.genel_toplam) as tutar
FROM
muhasebe_gider_urunler as mgu
INNER JOIN muhasebe_gider as mg on mgu.gider_id=mg.id
INNER JOIN cari as c on c.id=mgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE mg.status=1 AND mg.cari_key='$cari_key' AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND mgu.cari_id!=0 AND mg.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY mgu.id");
    if ($gider_faturalari > 0) {
        foreach ($gider_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["tutar"];
        }
    }

    $lastik_alis_faturalari = DB::all_data("
SELECT
laf.genel_toplam,
laf.fatura_tarihi,
laf.fatura_no,
laf.aciklama,
laf.vade_tarihi
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.fatura_id=laf.id
INNER JOIN cari as c on c.id=laf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND laf.cari_key='$cari_key' AND laf.cari_id!=0 AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($lastik_alis_faturalari > 0) {
        foreach ($lastik_alis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $sanayi_fis_fat = DB::all_data("
SELECT
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE sf.status=1 AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND sf.cari_key='$cari_key' AND sf.cari_id!=0 AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $satis_faturalari = DB::all_data("
SELECT
sd.genel_toplam
FROM
satis_default as sd
INNER JOIN cari as c on c.id=sd.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE sd.status=1 AND sd.cari_key='$cari_key' AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND sd.cari_id!=0 AND sd.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $cari_devir_borc += $alislar["genel_toplam"];
        }
    }
    $kart_islemi = DB::all_data("
SELECT
kh.tutar
FROM kart_harcama as kh
INNER JOIN cari as c on c.id=kh.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE kh.status=1 AND kh.cari_id!=0 AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND kh.cari_key='$cari_key' AND kh.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($kart_islemi > 0) {
        foreach ($kart_islemi as $alislar) {
            $cari_devir_borc += $alislar["tutar"];
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
pc.tutar
FROM
pos_cekim as pc
INNER JOIN cari as c on c.id=pc.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE pc.status=1 AND pc.cari_key='$cari_key' AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND pc.cari_id!=0 AND pc.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND acg.acilis_mi!=2 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND acu.cari_key='$cari_key' AND acu.cari_id!=0 AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND acu.acilis_mi!=2 AND acu.cari_key='$cari_key' AND acu.cari_id!=0 AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND ac.status!=0 AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND acg.acilis_mi!=2  AND acg.cari_key='$cari_key' AND acg.cari_id!=0 AND acu.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND acg.status!=0 AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

    if ($mahsup_hareketleri > 0) {
        foreach ($mahsup_hareketleri as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
        }
    }

    $acilis_fisi = DB::all_data("
SELECT
caf.borc,
caf.alacak
FROM cari_acilis_fisleri as caf
INNER JOIN cari as c on c.id=caf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE caf.status=1 AND caf.cari_key='$cari_key' AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND caf.cari_id!=0 AND caf.acilis_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($acilis_fisi > 0) {
        foreach ($acilis_fisi as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
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
    INNER JOIN cari as c on c.id=ak.cari_id
    INNER JOIN bilancolar as b on c.bilanco_id=b.id
    WHERE arac.status=1 AND asu.status=1 AND (b.bilanco_kodu='S' OR b.bilanco_kodu='NAK') AND arac.cari_key='$cari_key' AND arac.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
    ");
    if ($stok_cikisi > 0) {
        foreach ($stok_cikisi as $alislar) {
            $cari_devir_borc += $alislar["toplam_tutar"];
        }
    }


    $saticilar_toplam = $cari_devir_alacak - $cari_devir_borc;


    $cari_devir_borc = 0;
    $cari_devir_alacak = 0;
    $alis_faturalari = DB::all_data("
SELECT
ad.genel_toplam
FROM
alis_default as ad
INNER JOIN cari as c on c.id=ad.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE ad.status=1 AND ad.cari_key='$cari_key' AND ad.cari_id!=0 AND b.bilanco_kodu='DB' AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($alis_faturalari > 0) {
        foreach ($alis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $kiralik_yakit_alim = DB::single_query("
SELECT
       SUM(tl_tutar) as tutar 
FROM
     yakit_cikis_fisleri as ycf
INNER JOIN cari as c on c.id=ycf.kiralik_cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE ycf.status!=0 AND ycf.kiralik_cari_id!=0 AND b.bilanco_kodu='DB' AND ycf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_borc += $kiralik_yakit_alim["tutar"];


    $sanayi_fis_fat = DB::all_data("
SELECT
       sf.*,
       c.cari_adi,
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     binek_sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
INNER JOIN binek_sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
WHERE sf.status=1 AND sf.cari_key='$cari_key' AND b.bilanco_kodu='DB' AND sf.cari_id!=0 AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(byc.tl_tutar) as tutar
FROM
binek_yakit_fatura as laf
INNER JOIN binek_fis_faturasi as lafu on lafu.fatura_id=laf.id
INNER JOIN binek_yakit_cikis as byc on byc.id=lafu.yakit_fis_id
INNER JOIN cari as c on c.id=laf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='DB' AND laf.cari_key='$cari_key' AND laf.cari_id!=0 AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


    $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='DB' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0  AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


    $satis_faturalari = DB::single_query("
SELECT
SUM(acu.girilen_tutar) as tutar
FROM
     cikis_cek_urunler AS acu
INNER JOIN alinan_cek_cikis AS acg on acg.id=acu.cikis_cekid
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='DB' AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_borc += $satis_faturalari["tutar"];

    $vergi_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
vergi_gider as laf
INNER JOIN vergi_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='DB' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $vergi_gider["tutar"];

    $yonetim_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
yonetim_gider as laf
INNER JOIN yonetim_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='DB' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $yonetim_gider["tutar"];


    $sgk_gider_fisleri = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar 
FROM
     sgk_giderleri as laf
INNER JOIN sgk_gider_fisleri as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='DB' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $sgk_gider_fisleri["tutar"];


    $arac_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
     arac_gider as laf
INNER JOIN arac_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='DB' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $arac_gider["tutar"];

    $gider_faturalari = DB::all_data("
SELECT
mg.fatura_no as belge_no,
mg.fatura_tarihi as tarih,
mg.aciklama,
SUM(mgu.genel_toplam) as tutar
FROM
muhasebe_gider_urunler as mgu
INNER JOIN muhasebe_gider as mg on mgu.gider_id=mg.id
INNER JOIN cari as c on c.id=mgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE mg.status=1 AND mg.cari_key='$cari_key' AND b.bilanco_kodu='DB' AND mgu.cari_id!=0 AND mg.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY mgu.id");
    if ($gider_faturalari > 0) {
        foreach ($gider_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["tutar"];
        }
    }

    $lastik_alis_faturalari = DB::all_data("
SELECT
laf.genel_toplam,
laf.fatura_tarihi,
laf.fatura_no,
laf.aciklama,
laf.vade_tarihi
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.fatura_id=laf.id
INNER JOIN cari as c on c.id=laf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='DB' AND laf.cari_key='$cari_key' AND laf.cari_id!=0 AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($lastik_alis_faturalari > 0) {
        foreach ($lastik_alis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $sanayi_fis_fat = DB::all_data("
SELECT
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE sf.status=1 AND b.bilanco_kodu='DB' AND sf.cari_key='$cari_key' AND sf.cari_id!=0 AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $satis_faturalari = DB::all_data("
SELECT
sd.genel_toplam
FROM
satis_default as sd
INNER JOIN cari as c on c.id=sd.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE sd.status=1 AND sd.cari_key='$cari_key' AND b.bilanco_kodu='DB' AND sd.cari_id!=0 AND sd.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $cari_devir_borc += $alislar["genel_toplam"];
        }
    }
    $kart_islemi = DB::all_data("
SELECT
kh.tutar
FROM kart_harcama as kh
INNER JOIN cari as c on c.id=kh.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE kh.status=1 AND kh.cari_id!=0 AND b.bilanco_kodu='DB' AND kh.cari_key='$cari_key' AND kh.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($kart_islemi > 0) {
        foreach ($kart_islemi as $alislar) {
            $cari_devir_borc += $alislar["tutar"];
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
pc.tutar
FROM
pos_cekim as pc
INNER JOIN cari as c on c.id=pc.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE pc.status=1 AND pc.cari_key='$cari_key' AND b.bilanco_kodu='DB' AND pc.cari_id!=0 AND pc.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='DB' AND acg.acilis_mi!=2 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='DB' AND acu.cari_key='$cari_key' AND acu.cari_id!=0 AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='DB' AND acu.acilis_mi!=2 AND acu.cari_key='$cari_key' AND acu.cari_id!=0 AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND ac.status!=0 AND b.bilanco_kodu='DB' AND acg.acilis_mi!=2  AND acg.cari_key='$cari_key' AND acg.cari_id!=0 AND acu.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND acg.status!=0 AND b.bilanco_kodu='DB' AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='DB' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='DB' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='DB' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='DB' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='DB' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

    if ($mahsup_hareketleri > 0) {
        foreach ($mahsup_hareketleri as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
        }
    }

    $acilis_fisi = DB::all_data("
SELECT
caf.borc,
caf.alacak
FROM cari_acilis_fisleri as caf
INNER JOIN cari as c on c.id=caf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE caf.status=1 AND caf.cari_key='$cari_key' AND b.bilanco_kodu='DB' AND caf.cari_id!=0 AND caf.acilis_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($acilis_fisi > 0) {
        foreach ($acilis_fisi as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
        }
    }
    $diger_borclar_total = $cari_devir_alacak - $cari_devir_borc;


    $cari_devir_borc = 0;
    $cari_devir_alacak = 0;
    $alis_faturalari = DB::all_data("
SELECT
ad.genel_toplam
FROM
alis_default as ad
INNER JOIN cari as c on c.id=ad.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE ad.status=1 AND ad.cari_key='$cari_key' AND ad.cari_id!=0 AND b.bilanco_kodu='VRG' AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($alis_faturalari > 0) {
        foreach ($alis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $kiralik_yakit_alim = DB::single_query("
SELECT
       SUM(tl_tutar) as tutar 
FROM
     yakit_cikis_fisleri as ycf
INNER JOIN cari as c on c.id=ycf.kiralik_cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE ycf.status!=0 AND ycf.kiralik_cari_id!=0 AND b.bilanco_kodu='VRG' AND ycf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_borc += $kiralik_yakit_alim["tutar"];


    $sanayi_fis_fat = DB::all_data("
SELECT
       sf.*,
       c.cari_adi,
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     binek_sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
INNER JOIN binek_sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
WHERE sf.status=1 AND sf.cari_key='$cari_key' AND b.bilanco_kodu='VRG' AND sf.cari_id!=0 AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(byc.tl_tutar) as tutar
FROM
binek_yakit_fatura as laf
INNER JOIN binek_fis_faturasi as lafu on lafu.fatura_id=laf.id
INNER JOIN binek_yakit_cikis as byc on byc.id=lafu.yakit_fis_id
INNER JOIN cari as c on c.id=laf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='VRG' AND laf.cari_key='$cari_key' AND laf.cari_id!=0 AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


    $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='VRG' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0  AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


    $satis_faturalari = DB::single_query("
SELECT
SUM(acu.girilen_tutar) as tutar
FROM
     cikis_cek_urunler AS acu
INNER JOIN alinan_cek_cikis AS acg on acg.id=acu.cikis_cekid
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='VRG' AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_borc += $satis_faturalari["tutar"];

    $vergi_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
vergi_gider as laf
INNER JOIN vergi_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='VRG' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $vergi_gider["tutar"];

    $yonetim_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
yonetim_gider as laf
INNER JOIN yonetim_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='VRG' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $yonetim_gider["tutar"];


    $sgk_gider_fisleri = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar 
FROM
     sgk_giderleri as laf
INNER JOIN sgk_gider_fisleri as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='VRG' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $sgk_gider_fisleri["tutar"];


    $arac_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
     arac_gider as laf
INNER JOIN arac_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='VRG' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $arac_gider["tutar"];

    $gider_faturalari = DB::all_data("
SELECT
mg.fatura_no as belge_no,
mg.fatura_tarihi as tarih,
mg.aciklama,
SUM(mgu.genel_toplam) as tutar
FROM
muhasebe_gider_urunler as mgu
INNER JOIN muhasebe_gider as mg on mgu.gider_id=mg.id
INNER JOIN cari as c on c.id=mgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE mg.status=1 AND mg.cari_key='$cari_key' AND b.bilanco_kodu='VRG' AND mgu.cari_id!=0 AND mg.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY mgu.id");
    if ($gider_faturalari > 0) {
        foreach ($gider_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["tutar"];
        }
    }

    $lastik_alis_faturalari = DB::all_data("
SELECT
laf.genel_toplam,
laf.fatura_tarihi,
laf.fatura_no,
laf.aciklama,
laf.vade_tarihi
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.fatura_id=laf.id
INNER JOIN cari as c on c.id=laf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='VRG' AND laf.cari_key='$cari_key' AND laf.cari_id!=0 AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($lastik_alis_faturalari > 0) {
        foreach ($lastik_alis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $sanayi_fis_fat = DB::all_data("
SELECT
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE sf.status=1 AND b.bilanco_kodu='VRG' AND sf.cari_key='$cari_key' AND sf.cari_id!=0 AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $satis_faturalari = DB::all_data("
SELECT
sd.genel_toplam
FROM
satis_default as sd
INNER JOIN cari as c on c.id=sd.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE sd.status=1 AND sd.cari_key='$cari_key' AND b.bilanco_kodu='VRG' AND sd.cari_id!=0 AND sd.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $cari_devir_borc += $alislar["genel_toplam"];
        }
    }
    $kart_islemi = DB::all_data("
SELECT
kh.tutar
FROM kart_harcama as kh
INNER JOIN cari as c on c.id=kh.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE kh.status=1 AND kh.cari_id!=0 AND b.bilanco_kodu='VRG' AND kh.cari_key='$cari_key' AND kh.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($kart_islemi > 0) {
        foreach ($kart_islemi as $alislar) {
            $cari_devir_borc += $alislar["tutar"];
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
pc.tutar
FROM
pos_cekim as pc
INNER JOIN cari as c on c.id=pc.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE pc.status=1 AND pc.cari_key='$cari_key' AND b.bilanco_kodu='VRG' AND pc.cari_id!=0 AND pc.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='VRG' AND acg.acilis_mi!=2 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='VRG' AND acu.cari_key='$cari_key' AND acu.cari_id!=0 AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='VRG' AND acu.acilis_mi!=2 AND acu.cari_key='$cari_key' AND acu.cari_id!=0 AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND ac.status!=0 AND b.bilanco_kodu='VRG' AND acg.acilis_mi!=2  AND acg.cari_key='$cari_key' AND acg.cari_id!=0 AND acu.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND acg.status!=0 AND b.bilanco_kodu='VRG' AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='VRG' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='VRG' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='VRG' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='VRG' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='VRG' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

    if ($mahsup_hareketleri > 0) {
        foreach ($mahsup_hareketleri as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
        }
    }

    $acilis_fisi = DB::all_data("
SELECT
caf.borc,
caf.alacak
FROM cari_acilis_fisleri as caf
INNER JOIN cari as c on c.id=caf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE caf.status=1 AND caf.cari_key='$cari_key' AND b.bilanco_kodu='VRG' AND caf.cari_id!=0 AND caf.acilis_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($acilis_fisi > 0) {
        foreach ($acilis_fisi as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
        }
    }

    $odenecek_vergi_vs = $cari_devir_alacak - $cari_devir_borc;


    $cari_devir_borc = 0;
    $cari_devir_alacak = 0;
    $alis_faturalari = DB::all_data("
SELECT
ad.genel_toplam
FROM
alis_default as ad
INNER JOIN cari as c on c.id=ad.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE ad.status=1 AND ad.cari_key='$cari_key' AND ad.cari_id!=0 AND b.bilanco_kodu='DMR' AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($alis_faturalari > 0) {
        foreach ($alis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $kiralik_yakit_alim = DB::single_query("
SELECT
       SUM(tl_tutar) as tutar 
FROM
     yakit_cikis_fisleri as ycf
INNER JOIN cari as c on c.id=ycf.kiralik_cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE ycf.status!=0 AND ycf.kiralik_cari_id!=0 AND b.bilanco_kodu='DMR' AND ycf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_borc += $kiralik_yakit_alim["tutar"];


    $sanayi_fis_fat = DB::all_data("
SELECT
       sf.*,
       c.cari_adi,
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     binek_sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
INNER JOIN binek_sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
WHERE sf.status=1 AND sf.cari_key='$cari_key' AND b.bilanco_kodu='DMR' AND sf.cari_id!=0 AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(byc.tl_tutar) as tutar
FROM
binek_yakit_fatura as laf
INNER JOIN binek_fis_faturasi as lafu on lafu.fatura_id=laf.id
INNER JOIN binek_yakit_cikis as byc on byc.id=lafu.yakit_fis_id
INNER JOIN cari as c on c.id=laf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='DMR' AND laf.cari_key='$cari_key' AND laf.cari_id!=0 AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


    $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='DMR' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0  AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


    $satis_faturalari = DB::single_query("
SELECT
SUM(acu.girilen_tutar) as tutar
FROM
     cikis_cek_urunler AS acu
INNER JOIN alinan_cek_cikis AS acg on acg.id=acu.cikis_cekid
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='DMR' AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_borc += $satis_faturalari["tutar"];

    $vergi_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
vergi_gider as laf
INNER JOIN vergi_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='DMR' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $vergi_gider["tutar"];

    $yonetim_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
yonetim_gider as laf
INNER JOIN yonetim_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='DMR' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $yonetim_gider["tutar"];


    $sgk_gider_fisleri = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar 
FROM
     sgk_giderleri as laf
INNER JOIN sgk_gider_fisleri as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='DMR' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $sgk_gider_fisleri["tutar"];


    $arac_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
     arac_gider as laf
INNER JOIN arac_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='DMR' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $arac_gider["tutar"];

    $gider_faturalari = DB::all_data("
SELECT
mg.fatura_no as belge_no,
mg.fatura_tarihi as tarih,
mg.aciklama,
SUM(mgu.genel_toplam) as tutar
FROM
muhasebe_gider_urunler as mgu
INNER JOIN muhasebe_gider as mg on mgu.gider_id=mg.id
INNER JOIN cari as c on c.id=mgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE mg.status=1 AND mg.cari_key='$cari_key' AND b.bilanco_kodu='DMR' AND mgu.cari_id!=0 AND mg.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY mgu.id");
    if ($gider_faturalari > 0) {
        foreach ($gider_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["tutar"];
        }
    }

    $lastik_alis_faturalari = DB::all_data("
SELECT
laf.genel_toplam,
laf.fatura_tarihi,
laf.fatura_no,
laf.aciklama,
laf.vade_tarihi
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.fatura_id=laf.id
INNER JOIN cari as c on c.id=laf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='DMR' AND laf.cari_key='$cari_key' AND laf.cari_id!=0 AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($lastik_alis_faturalari > 0) {
        foreach ($lastik_alis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $sanayi_fis_fat = DB::all_data("
SELECT
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE sf.status=1 AND b.bilanco_kodu='DMR' AND sf.cari_key='$cari_key' AND sf.cari_id!=0 AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $satis_faturalari = DB::all_data("
SELECT
sd.genel_toplam
FROM
satis_default as sd
INNER JOIN cari as c on c.id=sd.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE sd.status=1 AND sd.cari_key='$cari_key' AND b.bilanco_kodu='DMR' AND sd.cari_id!=0 AND sd.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $cari_devir_borc += $alislar["genel_toplam"];
        }
    }
    $kart_islemi = DB::all_data("
SELECT
kh.tutar
FROM kart_harcama as kh
INNER JOIN cari as c on c.id=kh.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE kh.status=1 AND kh.cari_id!=0 AND b.bilanco_kodu='DMR' AND kh.cari_key='$cari_key' AND kh.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($kart_islemi > 0) {
        foreach ($kart_islemi as $alislar) {
            $cari_devir_borc += $alislar["tutar"];
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
pc.tutar
FROM
pos_cekim as pc
INNER JOIN cari as c on c.id=pc.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE pc.status=1 AND pc.cari_key='$cari_key' AND b.bilanco_kodu='DMR' AND pc.cari_id!=0 AND pc.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='DMR' AND acg.acilis_mi!=2 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='DMR' AND acu.cari_key='$cari_key' AND acu.cari_id!=0 AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='DMR' AND acu.acilis_mi!=2 AND acu.cari_key='$cari_key' AND acu.cari_id!=0 AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND ac.status!=0 AND b.bilanco_kodu='DMR' AND acg.acilis_mi!=2  AND acg.cari_key='$cari_key' AND acg.cari_id!=0 AND acu.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND acg.status!=0 AND b.bilanco_kodu='DMR' AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='DMR' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='DMR' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='DMR' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='DMR' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='DMR' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

    if ($mahsup_hareketleri > 0) {
        foreach ($mahsup_hareketleri as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
        }
    }

    $acilis_fisi = DB::all_data("
SELECT
caf.borc,
caf.alacak
FROM cari_acilis_fisleri as caf
INNER JOIN cari as c on c.id=caf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE caf.status=1 AND caf.cari_key='$cari_key' AND b.bilanco_kodu='DMR' AND caf.cari_id!=0 AND caf.acilis_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($acilis_fisi > 0) {
        foreach ($acilis_fisi as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
        }
    }

    $demirbas_toplam = $cari_devir_borc - $cari_devir_alacak;


    $cari_devir_borc = 0;
    $cari_devir_alacak = 0;
    $alis_faturalari = DB::all_data("
SELECT
ad.genel_toplam
FROM
alis_default as ad
INNER JOIN cari as c on c.id=ad.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE ad.status=1 AND ad.cari_key='$cari_key' AND ad.cari_id!=0 AND b.bilanco_kodu='MAK' AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($alis_faturalari > 0) {
        foreach ($alis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $kiralik_yakit_alim = DB::single_query("
SELECT
       SUM(tl_tutar) as tutar 
FROM
     yakit_cikis_fisleri as ycf
INNER JOIN cari as c on c.id=ycf.kiralik_cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE ycf.status!=0 AND ycf.kiralik_cari_id!=0 AND b.bilanco_kodu='MAK' AND ycf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_borc += $kiralik_yakit_alim["tutar"];


    $sanayi_fis_fat = DB::all_data("
SELECT
       sf.*,
       c.cari_adi,
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     binek_sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
INNER JOIN binek_sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
WHERE sf.status=1 AND sf.cari_key='$cari_key' AND b.bilanco_kodu='MAK' AND sf.cari_id!=0 AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(byc.tl_tutar) as tutar
FROM
binek_yakit_fatura as laf
INNER JOIN binek_fis_faturasi as lafu on lafu.fatura_id=laf.id
INNER JOIN binek_yakit_cikis as byc on byc.id=lafu.yakit_fis_id
INNER JOIN cari as c on c.id=laf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='MAK' AND laf.cari_key='$cari_key' AND laf.cari_id!=0 AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


    $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='MAK' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0  AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


    $satis_faturalari = DB::single_query("
SELECT
SUM(acu.girilen_tutar) as tutar
FROM
     cikis_cek_urunler AS acu
INNER JOIN alinan_cek_cikis AS acg on acg.id=acu.cikis_cekid
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='MAK' AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_borc += $satis_faturalari["tutar"];

    $vergi_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
vergi_gider as laf
INNER JOIN vergi_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='MAK' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $vergi_gider["tutar"];

    $yonetim_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
yonetim_gider as laf
INNER JOIN yonetim_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='MAK' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $yonetim_gider["tutar"];


    $sgk_gider_fisleri = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar 
FROM
     sgk_giderleri as laf
INNER JOIN sgk_gider_fisleri as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='MAK' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $sgk_gider_fisleri["tutar"];


    $arac_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
     arac_gider as laf
INNER JOIN arac_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='MAK' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $arac_gider["tutar"];

    $gider_faturalari = DB::all_data("
SELECT
mg.fatura_no as belge_no,
mg.fatura_tarihi as tarih,
mg.aciklama,
SUM(mgu.genel_toplam) as tutar
FROM
muhasebe_gider_urunler as mgu
INNER JOIN muhasebe_gider as mg on mgu.gider_id=mg.id
INNER JOIN cari as c on c.id=mgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE mg.status=1 AND mg.cari_key='$cari_key' AND b.bilanco_kodu='MAK' AND mgu.cari_id!=0 AND mg.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY mgu.id");
    if ($gider_faturalari > 0) {
        foreach ($gider_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["tutar"];
        }
    }

    $lastik_alis_faturalari = DB::all_data("
SELECT
laf.genel_toplam,
laf.fatura_tarihi,
laf.fatura_no,
laf.aciklama,
laf.vade_tarihi
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.fatura_id=laf.id
INNER JOIN cari as c on c.id=laf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='MAK' AND laf.cari_key='$cari_key' AND laf.cari_id!=0 AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($lastik_alis_faturalari > 0) {
        foreach ($lastik_alis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $sanayi_fis_fat = DB::all_data("
SELECT
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE sf.status=1 AND b.bilanco_kodu='MAK' AND sf.cari_key='$cari_key' AND sf.cari_id!=0 AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $satis_faturalari = DB::all_data("
SELECT
sd.genel_toplam
FROM
satis_default as sd
INNER JOIN cari as c on c.id=sd.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE sd.status=1 AND sd.cari_key='$cari_key' AND b.bilanco_kodu='MAK' AND sd.cari_id!=0 AND sd.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $cari_devir_borc += $alislar["genel_toplam"];
        }
    }
    $kart_islemi = DB::all_data("
SELECT
kh.tutar
FROM kart_harcama as kh
INNER JOIN cari as c on c.id=kh.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE kh.status=1 AND kh.cari_id!=0 AND b.bilanco_kodu='MAK' AND kh.cari_key='$cari_key' AND kh.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($kart_islemi > 0) {
        foreach ($kart_islemi as $alislar) {
            $cari_devir_borc += $alislar["tutar"];
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
pc.tutar
FROM
pos_cekim as pc
INNER JOIN cari as c on c.id=pc.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE pc.status=1 AND pc.cari_key='$cari_key' AND b.bilanco_kodu='MAK' AND pc.cari_id!=0 AND pc.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='MAK' AND acg.acilis_mi!=2 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='MAK' AND acu.cari_key='$cari_key' AND acu.cari_id!=0 AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='MAK' AND acu.acilis_mi!=2 AND acu.cari_key='$cari_key' AND acu.cari_id!=0 AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND ac.status!=0 AND b.bilanco_kodu='MAK' AND acg.acilis_mi!=2  AND acg.cari_key='$cari_key' AND acg.cari_id!=0 AND acu.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND acg.status!=0 AND b.bilanco_kodu='MAK' AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='MAK' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='MAK' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='MAK' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='MAK' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='MAK' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

    if ($mahsup_hareketleri > 0) {
        foreach ($mahsup_hareketleri as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
        }
    }

    $acilis_fisi = DB::all_data("
SELECT
caf.borc,
caf.alacak
FROM cari_acilis_fisleri as caf
INNER JOIN cari as c on c.id=caf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE caf.status=1 AND caf.cari_key='$cari_key' AND b.bilanco_kodu='MAK' AND caf.cari_id!=0 AND caf.acilis_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($acilis_fisi > 0) {
        foreach ($acilis_fisi as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
        }
    }
    $makine_ve_ekipman = $cari_devir_borc - $cari_devir_alacak;


    $cari_devir_borc = 0;
    $cari_devir_alacak = 0;
    $alis_faturalari = DB::all_data("
SELECT
ad.genel_toplam
FROM
alis_default as ad
INNER JOIN cari as c on c.id=ad.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE ad.status=1 AND ad.cari_key='$cari_key' AND ad.cari_id!=0 AND b.bilanco_kodu='TAS' AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($alis_faturalari > 0) {
        foreach ($alis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $kiralik_yakit_alim = DB::single_query("
SELECT
       SUM(tl_tutar) as tutar 
FROM
     yakit_cikis_fisleri as ycf
INNER JOIN cari as c on c.id=ycf.kiralik_cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE ycf.status!=0 AND ycf.kiralik_cari_id!=0 AND b.bilanco_kodu='TAS' AND ycf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_borc += $kiralik_yakit_alim["tutar"];


    $sanayi_fis_fat = DB::all_data("
SELECT
       sf.*,
       c.cari_adi,
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     binek_sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
INNER JOIN binek_sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
WHERE sf.status=1 AND sf.cari_key='$cari_key' AND b.bilanco_kodu='TAS' AND sf.cari_id!=0 AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(byc.tl_tutar) as tutar
FROM
binek_yakit_fatura as laf
INNER JOIN binek_fis_faturasi as lafu on lafu.fatura_id=laf.id
INNER JOIN binek_yakit_cikis as byc on byc.id=lafu.yakit_fis_id
INNER JOIN cari as c on c.id=laf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='TAS' AND laf.cari_key='$cari_key' AND laf.cari_id!=0 AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


    $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='TAS' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0  AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


    $satis_faturalari = DB::single_query("
SELECT
SUM(acu.girilen_tutar) as tutar
FROM
     cikis_cek_urunler AS acu
INNER JOIN alinan_cek_cikis AS acg on acg.id=acu.cikis_cekid
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='TAS' AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_borc += $satis_faturalari["tutar"];

    $vergi_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
vergi_gider as laf
INNER JOIN vergi_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='TAS' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $vergi_gider["tutar"];

    $yonetim_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
yonetim_gider as laf
INNER JOIN yonetim_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='TAS' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $yonetim_gider["tutar"];


    $sgk_gider_fisleri = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar 
FROM
     sgk_giderleri as laf
INNER JOIN sgk_gider_fisleri as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='TAS' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $sgk_gider_fisleri["tutar"];


    $arac_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
     arac_gider as laf
INNER JOIN arac_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='TAS' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $arac_gider["tutar"];

    $gider_faturalari = DB::all_data("
SELECT
mg.fatura_no as belge_no,
mg.fatura_tarihi as tarih,
mg.aciklama,
SUM(mgu.genel_toplam) as tutar
FROM
muhasebe_gider_urunler as mgu
INNER JOIN muhasebe_gider as mg on mgu.gider_id=mg.id
INNER JOIN cari as c on c.id=mgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE mg.status=1 AND mg.cari_key='$cari_key' AND b.bilanco_kodu='TAS' AND mgu.cari_id!=0 AND mg.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY mgu.id");
    if ($gider_faturalari > 0) {
        foreach ($gider_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["tutar"];
        }
    }

    $lastik_alis_faturalari = DB::all_data("
SELECT
laf.genel_toplam,
laf.fatura_tarihi,
laf.fatura_no,
laf.aciklama,
laf.vade_tarihi
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.fatura_id=laf.id
INNER JOIN cari as c on c.id=laf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='TAS' AND laf.cari_key='$cari_key' AND laf.cari_id!=0 AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($lastik_alis_faturalari > 0) {
        foreach ($lastik_alis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $sanayi_fis_fat = DB::all_data("
SELECT
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE sf.status=1 AND b.bilanco_kodu='TAS' AND sf.cari_key='$cari_key' AND sf.cari_id!=0 AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $satis_faturalari = DB::all_data("
SELECT
sd.genel_toplam
FROM
satis_default as sd
INNER JOIN cari as c on c.id=sd.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE sd.status=1 AND sd.cari_key='$cari_key' AND b.bilanco_kodu='TAS' AND sd.cari_id!=0 AND sd.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $cari_devir_borc += $alislar["genel_toplam"];
        }
    }
    $kart_islemi = DB::all_data("
SELECT
kh.tutar
FROM kart_harcama as kh
INNER JOIN cari as c on c.id=kh.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE kh.status=1 AND kh.cari_id!=0 AND b.bilanco_kodu='TAS' AND kh.cari_key='$cari_key' AND kh.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($kart_islemi > 0) {
        foreach ($kart_islemi as $alislar) {
            $cari_devir_borc += $alislar["tutar"];
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
pc.tutar
FROM
pos_cekim as pc
INNER JOIN cari as c on c.id=pc.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE pc.status=1 AND pc.cari_key='$cari_key' AND b.bilanco_kodu='TAS' AND pc.cari_id!=0 AND pc.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='TAS' AND acg.acilis_mi!=2 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='TAS' AND acu.cari_key='$cari_key' AND acu.cari_id!=0 AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='TAS' AND acu.acilis_mi!=2 AND acu.cari_key='$cari_key' AND acu.cari_id!=0 AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND ac.status!=0 AND b.bilanco_kodu='TAS' AND acg.acilis_mi!=2  AND acg.cari_key='$cari_key' AND acg.cari_id!=0 AND acu.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND acg.status!=0 AND b.bilanco_kodu='TAS' AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='TAS' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='TAS' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='TAS' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='TAS' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='TAS' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

    if ($mahsup_hareketleri > 0) {
        foreach ($mahsup_hareketleri as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
        }
    }

    $acilis_fisi = DB::all_data("
SELECT
caf.borc,
caf.alacak
FROM cari_acilis_fisleri as caf
INNER JOIN cari as c on c.id=caf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE caf.status=1 AND caf.cari_key='$cari_key' AND b.bilanco_kodu='TAS' AND caf.cari_id!=0 AND caf.acilis_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($acilis_fisi > 0) {
        foreach ($acilis_fisi as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
        }
    }

    $tasitlar_toplam = $cari_devir_borc - $cari_devir_alacak;


    $cari_devir_borc = 0;
    $cari_devir_alacak = 0;
    $alis_faturalari = DB::all_data("
SELECT
ad.genel_toplam
FROM
alis_default as ad
INNER JOIN cari as c on c.id=ad.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE ad.status=1 AND ad.cari_key='$cari_key' AND ad.cari_id!=0 AND b.bilanco_kodu='BAA' AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($alis_faturalari > 0) {
        foreach ($alis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $kiralik_yakit_alim = DB::single_query("
SELECT
       SUM(tl_tutar) as tutar 
FROM
     yakit_cikis_fisleri as ycf
INNER JOIN cari as c on c.id=ycf.kiralik_cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE ycf.status!=0 AND ycf.kiralik_cari_id!=0 AND b.bilanco_kodu='BAA' AND ycf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_borc += $kiralik_yakit_alim["tutar"];


    $sanayi_fis_fat = DB::all_data("
SELECT
       sf.*,
       c.cari_adi,
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     binek_sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
INNER JOIN binek_sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
WHERE sf.status=1 AND sf.cari_key='$cari_key' AND b.bilanco_kodu='BAA' AND sf.cari_id!=0 AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(byc.tl_tutar) as tutar
FROM
binek_yakit_fatura as laf
INNER JOIN binek_fis_faturasi as lafu on lafu.fatura_id=laf.id
INNER JOIN binek_yakit_cikis as byc on byc.id=lafu.yakit_fis_id
INNER JOIN cari as c on c.id=laf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='BAA' AND laf.cari_key='$cari_key' AND laf.cari_id!=0 AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


    $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='BAA' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0  AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


    $satis_faturalari = DB::single_query("
SELECT
SUM(acu.girilen_tutar) as tutar
FROM
     cikis_cek_urunler AS acu
INNER JOIN alinan_cek_cikis AS acg on acg.id=acu.cikis_cekid
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='BAA' AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_borc += $satis_faturalari["tutar"];

    $vergi_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
vergi_gider as laf
INNER JOIN vergi_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='BAA' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $vergi_gider["tutar"];

    $yonetim_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
yonetim_gider as laf
INNER JOIN yonetim_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='BAA' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $yonetim_gider["tutar"];


    $sgk_gider_fisleri = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar 
FROM
     sgk_giderleri as laf
INNER JOIN sgk_gider_fisleri as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='BAA' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $sgk_gider_fisleri["tutar"];


    $arac_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
     arac_gider as laf
INNER JOIN arac_gider_fisi as lafu on lafu.gider_id=laf.id
INNER JOIN cari as c on c.id=lafu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='BAA' AND laf.cari_key='$cari_key' AND lafu.cari_id!=0 AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $cari_devir_alacak += $arac_gider["tutar"];

    $gider_faturalari = DB::all_data("
SELECT
mg.fatura_no as belge_no,
mg.fatura_tarihi as tarih,
mg.aciklama,
SUM(mgu.genel_toplam) as tutar
FROM
muhasebe_gider_urunler as mgu
INNER JOIN muhasebe_gider as mg on mgu.gider_id=mg.id
INNER JOIN cari as c on c.id=mgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE mg.status=1 AND mg.cari_key='$cari_key' AND b.bilanco_kodu='BAA' AND mgu.cari_id!=0 AND mg.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY mgu.id");
    if ($gider_faturalari > 0) {
        foreach ($gider_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["tutar"];
        }
    }

    $lastik_alis_faturalari = DB::all_data("
SELECT
laf.genel_toplam,
laf.fatura_tarihi,
laf.fatura_no,
laf.aciklama,
laf.vade_tarihi
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.fatura_id=laf.id
INNER JOIN cari as c on c.id=laf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE laf.status=1 AND lafu.status=1 AND b.bilanco_kodu='BAA' AND laf.cari_key='$cari_key' AND laf.cari_id!=0 AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($lastik_alis_faturalari > 0) {
        foreach ($lastik_alis_faturalari as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $sanayi_fis_fat = DB::all_data("
SELECT
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE sf.status=1 AND b.bilanco_kodu='BAA' AND sf.cari_key='$cari_key' AND sf.cari_id!=0 AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    if ($sanayi_fis_fat > 0) {
        foreach ($sanayi_fis_fat as $alislar) {
            $cari_devir_alacak += $alislar["genel_toplam"];
        }
    }

    $satis_faturalari = DB::all_data("
SELECT
sd.genel_toplam
FROM
satis_default as sd
INNER JOIN cari as c on c.id=sd.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE sd.status=1 AND sd.cari_key='$cari_key' AND b.bilanco_kodu='BAA' AND sd.cari_id!=0 AND sd.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($satis_faturalari > 0) {
        foreach ($satis_faturalari as $alislar) {
            $cari_devir_borc += $alislar["genel_toplam"];
        }
    }
    $kart_islemi = DB::all_data("
SELECT
kh.tutar
FROM kart_harcama as kh
INNER JOIN cari as c on c.id=kh.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE kh.status=1 AND kh.cari_id!=0 AND b.bilanco_kodu='BAA' AND kh.cari_key='$cari_key' AND kh.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($kart_islemi > 0) {
        foreach ($kart_islemi as $alislar) {
            $cari_devir_borc += $alislar["tutar"];
        }
    }
    $satis_faturalari = DB::all_data("
SELECT
pc.tutar
FROM
pos_cekim as pc
INNER JOIN cari as c on c.id=pc.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE pc.status=1 AND pc.cari_key='$cari_key' AND b.bilanco_kodu='BAA' AND pc.cari_id!=0 AND pc.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='BAA' AND acg.acilis_mi!=2 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='BAA' AND acu.cari_key='$cari_key' AND acu.cari_id!=0 AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND b.bilanco_kodu='BAA' AND acu.acilis_mi!=2 AND acu.cari_key='$cari_key' AND acu.cari_id!=0 AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND ac.status!=0 AND b.bilanco_kodu='BAA' AND acg.acilis_mi!=2  AND acg.cari_key='$cari_key' AND acg.cari_id!=0 AND acu.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=acg.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND acg.status!=0 AND b.bilanco_kodu='BAA' AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id!=0 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='BAA' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='BAA' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='BAA' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='BAA' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

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
INNER JOIN cari as c on c.id=hgu.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND b.bilanco_kodu='BAA' AND hgu.cari_key='$cari_key' AND hgu.cari_id!=0 AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

    if ($mahsup_hareketleri > 0) {
        foreach ($mahsup_hareketleri as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
        }
    }

    $acilis_fisi = DB::all_data("
SELECT
caf.borc,
caf.alacak
FROM cari_acilis_fisleri as caf
INNER JOIN cari as c on c.id=caf.cari_id
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE caf.status=1 AND caf.cari_key='$cari_key' AND b.bilanco_kodu='BAA' AND caf.cari_id!=0 AND caf.acilis_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($acilis_fisi > 0) {
        foreach ($acilis_fisi as $giris) {
            $cari_devir_alacak += $giris["alacak"];
            $cari_devir_borc += $giris["borc"];
        }
    }

    $tum_kartlar = DB::all_data("
SELECT
       *,
       (SELECT SUM(tutar) FROM kart_harcama as kko WHERE kko.kart_id = kkt.id AND kko.status=1 AND kko.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59') AS toplam_cekilen,
       (SELECT SUM(borc) FROM kredi_kart_acilis as kka WHERE kka.kart_id = kkt.id AND kka.status=1 AND kka.acilis_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59') AS toplam_odenen1,
       (SELECT SUM(alacak) FROM kredi_kart_acilis as kka1 WHERE kka1.kart_id = kkt.id AND kka1.status=1 AND kka1.acilis_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59') AS toplam_cekilen7,
       (SELECT SUM(tutar) FROM kaza_ceza_gider_fisleri as kcgf INNER JOIN kaza_ceza_gider as kcg on kcg.id=kcgf.gider_id WHERE  kcgf.kart_id = kkt.id AND kcgf.status=1 and kcg.status=1 AND kcg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59') AS toplam_cekilen1,
       (SELECT SUM(tutar) FROM yonetim_gider_fisi as ygf INNER JOIN yonetim_gider as yg on yg.id=ygf.gider_id WHERE  ygf.kart_id = kkt.id AND ygf.status=1 and yg.status=1 AND ygf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59') AS toplam_cekilen2,
       (SELECT SUM(tutar) FROM hgs_gider_fisleri as hgf INNER JOIN hgs_gider as hg on hg.id=hgf.gider_id WHERE  hgf.kart_id = kkt.id AND hgf.status=1 and hg.status=1 AND hg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59') AS toplam_cekilen3,
       (SELECT SUM(tutar) FROM binek_hgs_gider_fisleri as bhgf INNER JOIN binek_hgs_gider as bhg on bhg.id=bhgf.gider_id WHERE  bhgf.kart_id = kkt.id AND bhgf.status=1 and bhg.status=1  AND bhg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59') AS toplam_cekilen9,
       (SELECT SUM(tutar) FROM arac_gider_fisi as agf INNER JOIN arac_gider as ag on ag.id=agf.gider_id WHERE  agf.kart_id = kkt.id AND agf.status=1 and ag.status=1  AND agf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59') AS toplam_cekilen4,
       (SELECT SUM(tutar) FROM sgk_gider_fisleri as sgf INNER JOIN sgk_giderleri as sg on sg.id=sgf.gider_id WHERE  sgf.kart_id = kkt.id AND sgf.status=1 and sg.status=1 AND sgf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59') AS toplam_cekilen5,
       (SELECT SUM(tutar) FROM vergi_gider_fisi as vgf INNER JOIN vergi_gider as vg on vg.id=vgf.gider_id WHERE  vgf.kart_id = kkt.id AND vgf.status=1 and vg.status=1 AND vg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59') AS toplam_cekilen6,
       (SELECT SUM(tutar) FROM binek_vergi_gider_fisleri as vgf INNER JOIN binek_vergi_gider as vg on vg.id=vgf.gider_id WHERE  vgf.kart_id = kkt.id AND vgf.status=1 and vg.status=1 AND vg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59') AS toplam_cekilen10,
       (SELECT SUM(tutar) FROM kredi_kart_odeme as kko1 WHERE kko1.kart_id = kkt.id AND kko1.status=1 AND kko1.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59') AS toplam_odenen,
       (SELECT SUM(tl_tutar) FROM binek_yakit_cikis as byc WHERE byc.kart_id = kkt.id AND byc.status!=0 AND byc.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59') AS toplam_cekilen8
FROM 
     kredi_kart_tanim as kkt
WHERE kkt.status=1 AND kkt.cari_key='$cari_key' GROUP BY kkt.id");

    $total = 0;
    foreach ($tum_kartlar as $item) {
        $total += $item["toplam_cekilen"];
        $total += $item["toplam_cekilen1"];
        $total += $item["toplam_cekilen2"];
        $total += $item["toplam_cekilen3"];
        $total += $item["toplam_cekilen4"];
        $total += $item["toplam_cekilen5"];
        $total += $item["toplam_cekilen6"];
        $total += $item["toplam_cekilen7"];
        $total += $item["toplam_cekilen8"];
        $total += $item["toplam_cekilen9"];
        $total += $item["toplam_cekilen10"];
        $total -= $item["toplam_odenen"];
        $total -= $item["toplam_odenen1"];
    }

    $tum_kredileri_getir = DB::all_data("
SELECT
    kk.*,
    kk.odenecek_toplam,
    SUM(kto.toplam_odeme) AS toplam_odenmis,
    b.banka_adi
FROM
    kredi_kullanim AS kk
INNER JOIN kredi_kullanim_urunler AS kku ON kku.kredi_id = kk.id
INNER JOIN banka AS b ON b.id = kk.banka_id
LEFT JOIN kredi_taksit_odeme as kto on kto.kredi_id=kku.id AND kto.status=1
WHERE kk.status=1 AND kk.cari_key='$cari_key' AND kk.kullanim_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

    $toplam_kredi = 0;
    $toplam_odeme = 0;
    foreach ($tum_kredileri_getir as $item) {
        $toplam_kredi += $item["odenecek_toplam"];
        $toplam_odeme += $item["toplam_odenmis"];
    }
    $toplam_kredi = $toplam_kredi - $toplam_odeme;

    $krediler_toplam = 0;
    $krediler_toplam += $total;
    $krediler_toplam += $toplam_kredi;
    $bina_arazi = $cari_devir_borc - $cari_devir_alacak;


    $stoklar = DB::all_data("SELECT stok.*,marka.marka_adi,sag.ana_grup_adi,salt.altgrup_adi,model.model_adi,b.birim_adi FROM stok
LEFT JOIN stok_ana_grup as sag on sag.id=stok.stok_ana_grupid
LEFT JOIN stok_alt_grup as salt on salt.id=stok.stok_alt_grupid
LEFT JOIN marka on marka.id=stok.marka
LEFT JOIN model on model.id=stok.model
LEFT JOIN birim as b on b.id=stok.birim
WHERE stok.status=1 and stok.cari_key='$cari_key' AND stok.stok_turu!=3");

    $last_birim_fiyat = 0;
    $toplam_emtia = 0;
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
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.irsaliye_ids='' AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE psu.status=1 AND ps.status=1 AND psu.stok_kodu='$stok_kodu' AND psu.cari_key='$cari_key' AND ps.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE status!=0 AND stok_id='$kasa_id' AND tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.irsaliye_ids='' AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
WHERE ad.status!=0 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key'  AND ad.irsaliye_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
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
        $toplam_emtia += $elimdeki_maliyet;


    }


    $donen_varlik_total = $kasa_devir_bakiye + $toplam_emtia + $banka_bakiye + $alinan_cekler_toplam + $musteri_total + $alinan_senetler_toplam + $personel_total + $diger_varlik_total + $saticilara_verilen_avanslar;

    $duran_varlik_total = $demirbas_toplam + $makine_ve_ekipman + $tasitlar_toplam + $bina_arazi;

    $varliklar_total = $duran_varlik_total + $donen_varlik_total;

    $cari_donem_borc = $saticilar_toplam + $verilen_cekler_toplam + $verilen_senetler_toplam + $krediler_toplam + $diger_borclar_total + $odenecek_vergi_vs;

    $arr = [
        'kasalar' => $kasa_devir_bakiye,
        'bankalar' => $banka_bakiye,
        'alinan_cekler_toplami' => $alinan_cekler_toplam,
        'verilen_cek_total' => $verilen_cekler_toplam,
        'alinan_senetler_total' => $alinan_senetler_toplam,
        'musteri_total' => $musteri_total,
        'personel_avanslari_total' => $personel_total,
        'diger_varlik_total' => $diger_varlik_total,
        'saticilara_verilen_avanslar_total' => $saticilara_verilen_avanslar,
        'saticilar_total' => $saticilar_toplam,
        'verilen_senetler_total' => $verilen_senetler_toplam,
        'diger_borclar_toplam' => $diger_borclar_total,
        'odenecek_vergi_vs_total' => $odenecek_vergi_vs,
        'demirbaslar_total' => $demirbas_toplam,
        'makine_ekipman_total' => $makine_ve_ekipman,
        'tasitlar_total' => $tasitlar_toplam,
        'bina_arazi_total' => $bina_arazi,
        'krediler_total' => $krediler_toplam,
        'donen_varlik_total' => $donen_varlik_total,
        'duran_varliklar_total' => $duran_varlik_total,
        'aktif_varliklar_aktif_total' => $varliklar_total,
        'donem_borclar_totali' => $cari_donem_borc,
        'emtia_stok_total' => $toplam_emtia
    ];
    echo json_encode($arr);
}
if ($islem == "arac_hesaplari_sql") {
    $bas_tarih = $_GET["bas_tarih"];
    $bit_tarih = $_GET["bit_tarih"];
    $arac_hesabi = DB::all_data("SELECT
    ak.plaka_no,
    i.il_adi AS bolgesi
FROM
    arac_kartlari AS ak 
LEFT JOIN
    il AS i ON i.id = ak.bolge
WHERE 
    ak.cari_key = '$cari_key'  
    AND ak.arac_grubu = 'Öz Mal' 
    AND ak.status = 1 
    AND ak.arac_tipi != 'Dorse 2 Dingil' 
    AND ak.arac_tipi != 'Dorse 3 Dingil' 
    AND ak.id IS NOT NULL
GROUP BY
    ak.id, ak.plaka_no, i.il_adi;");

    $response = [];
    $i = 1;
    $ciro_toplam = 0;
    $masraf_toplam = 0;
    $kar_zarar_toplam = 0;
    $prim_toplam = 0;
    $hgs_toplam = 0;
    $maas_toplam = 0;
    $sgk_toplam = 0;
    $motorin_toplam = 0;
    $sanayi_toplam_main = 0;
    $lastik_toplam = 0;
    $ceza_mtv_toplam = 0;
    $arac_gider_toplam = 0;

    foreach ($arac_hesabi as $item) {
        $ciro = 0;
        $plaka_no = $item["plaka_no"];
        $surucu_prim = DB::single_query("
SELECT
SUM(pou.prim_tutari) as prim_tutari
FROM
     prim_odeme AS po
INNER JOIN prim_odeme_urunler AS pou on pou.odeme_id=po.id
LEFT JOIN arac_kartlari as ak on ak.surucu_id=po.sofor_id
WHERE po.status=1 AND po.cari_key='$cari_key' AND ak.plaka_no='$plaka_no' AND po.odeme_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
     ");
        $prim_tutari = $surucu_prim["prim_tutari"];


        $hgs_gider = DB::single_query("
SELECT
SUM(hgu.tutar) as hgs_tutar
FROM
     hgs_gider AS hg
LEFT JOIN hgs_gider_fisleri as hgu on hg.id=hgu.gider_id
INNER JOIN arac_kartlari as ak on ak.id=hgu.plaka_id
WHERE hg.status=1 AND hgu.status=1 AND hg.cari_key='$cari_key' AND ak.plaka_no='$plaka_no' AND hg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
     ");
        $hgs_tutari = $hgs_gider["hgs_tutar"];


        $personel_maas = DB::single_query("
SELECT
SUM(pt.tutar) as tahakkuk_toplam
FROM
     personel_tahakkuk AS pt
INNER JOIN arac_kartlari as ak on ak.surucu_id=pt.personel_id
WHERE pt.status=1 AND pt.cari_key='$cari_key' AND ak.plaka_no='$plaka_no' AND pt.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
     ");
        $tahakkuk_toplam = $personel_maas["tahakkuk_toplam"];


        $personel_maas = DB::single_query("
SELECT
SUM(ycf.tl_tutar) as yakit_toplam
FROM
     yakit_cikis_fisleri AS ycf
INNER JOIN arac_kartlari as ak on ak.id=ycf.plaka_id
WHERE ycf.status!=0 AND ycf.cari_key='$cari_key' AND ak.plaka_no='$plaka_no' AND ycf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
     ");
        $yakit_toplam = $personel_maas["yakit_toplam"];

        $personel_maas = DB::single_query("
SELECT
SUM(sfu.genel_toplam) as genel_toplam
FROM
     sanayi_fisi AS sf
INNER JOIN sanayi_fisi_urunler as sfu on sfu.fis_id=sf.id
INNER JOIN arac_kartlari as ak on ak.id=sfu.plaka_id
WHERE sfu.status!=0 AND sfu.cari_key='$cari_key' AND ak.plaka_no='$plaka_no' AND sf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
     ");
        $sanayi_toplam = $personel_maas["genel_toplam"];

        $personel_maas = DB::single_query("
SELECT
SUM(ki.tasima_fiyat) as tasima_fiyat
FROM
konteyner_irsaliye as ki
INNER JOIN arac_kartlari as ak on ki.plaka_id=ak.id
WHERE ki.status!=0 AND ki.cari_key='$cari_key' AND ak.plaka_no='$plaka_no' AND ki.irsaliye_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
     ");
        $ciro += $personel_maas["tasima_fiyat"];


//        $personel_maas = DB::single_query("
//SELECT
//SUM(kieh.satis_fiyat) as bekleme_tutari
//FROM
//konteyner_irsaliye_ek_hizmet as kieh
//INNER JOIN konteyner_irsaliye as ki on ki.id=kieh.irsaliye_id
//INNER JOIN arac_kartlari as ak on ki.plaka_id=ak.id
//WHERE ki.status!=0 AND kieh.status!=0 AND kieh.cari_id=0 AND kieh.cari_key='$cari_key' AND ak.plaka_no='$plaka_no' AND ki.irsaliye_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
//     ");
//        $ciro += $personel_maas["bekleme_tutari"];

        $personel_maas = DB::single_query("
SELECT
SUM(sgf.tutar) as sgk_tutari
FROM
sgk_gider_fisleri as sgf
LEFT JOIN sgk_giderleri as sg on sg.id=sgf.gider_id
INNER JOIN arac_kartlari as ak on sgf.plaka_id=ak.id
WHERE sg.status=1 AND sgf.status=1 AND sgf.cari_key='$cari_key' AND ak.plaka_no='$plaka_no' AND sg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
     ");
        $sgk_tutari = $personel_maas["sgk_tutari"];

        $ceza_mtv_tot = 0;
        $ceza_mtv = DB::single_query("
SELECT
       SUM(kcgf.tutar) as tutar
FROM
     kaza_ceza_gider as kcg
INNER JOIN kaza_ceza_gider_fisleri AS kcgf on kcgf.gider_id=kcg.id
INNER JOIN arac_kartlari as ak on ak.id=kcgf.plaka_id
WHERE
      kcg.status=1 AND kcgf.status=1 AND kcg.cari_key='$cari_key' AND ak.plaka_no='$plaka_no' AND kcg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

        $ceza_mtv_tot += $ceza_mtv["tutar"];

        $vergi_mtv_main_arac = DB::single_query("
SELECT
       SUM(kcgf.tutar) as tutar
FROM
     vergi_gider as kcg
INNER JOIN vergi_gider_fisi AS kcgf on kcgf.gider_id=kcg.id
INNER JOIN arac_kartlari as ak on ak.id=kcgf.plaka_id
WHERE
      kcg.status=1 AND kcgf.status=1 AND kcg.cari_key='$cari_key' AND ak.plaka_no='$plaka_no' AND kcg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");

        $ceza_mtv_tot += $vergi_mtv_main_arac["tutar"];
        $aracgider_tot = 0;
        $arac_gider = DB::single_query("
SELECT
       SUM(agf.tutar) as tutar
FROM 
     arac_gider AS ag
INNER JOIN arac_gider_fisi AS agf on agf.gider_id=ag.id
INNER JOIN arac_kartlari as ak on ak.id=agf.plaka_id
WHERE ag.status=1 AND agf.status=1 AND ag.cari_key='$cari_key' AND ak.plaka_no='$plaka_no' AND ag.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
        $aracgider_tot += $arac_gider["tutar"];

        $lastik_gider_tot = 0;
        $lastik_takma = DB::all_data("
SELECT
       alt.stok_id
FROM
     arac_lastik_tak as alt
INNER JOIN arac_kartlari as ak on ak.id=alt.arac_id
WHERE alt.status!=0 AND alt.cari_key='$cari_key' AND ak.plaka_no='$plaka_no' AND alt.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
        $last_birim_fiyat = 0;
        $son_satis = 0;
        foreach ($lastik_takma as $item2) {
            $son_satis = 0;
            $alislar_arr = [];
            $kasa_id = $item2["stok_id"];
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
WHERE psu.status=1 AND ps.status=1 AND psu.stok_kodu='$stok_kodu' AND psu.cari_key='$cari_key'
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
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.irsaliye_ids=''
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
WHERE ad.status!=0 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key'
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
WHERE ad.status!=0 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key'
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
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key'
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
WHERE laf.status=1 AND lafu.status=1 AND lafu.stok_id='$kasa_id' AND laf.cari_key='$cari_key'
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
WHERE laf.status=1 AND lafu.status=1 AND lafu.stok_id='$kasa_id' AND laf.cari_key='$cari_key'
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
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key'
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
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key'
");

            $kasa_devir_kalan_miktar = floatval($kasa_devir_giren_miktar) - floatval($kasa_devir_cikan_miktar);
            $devirli_miktar = $kasa_devir_kalan_miktar;
            $elimdeki_maliyet = 0;
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
                            $son_satis += $maliyetler["birim_fiyat"];
                            break;
                        }
                    }
                }
            }

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
        }
        $lastik_gider_tot += $son_satis;


        // DORSEYİ ARACA YANSITTIĞIMIZ YER
        $dorse_sanayi = DB::all_data("
SELECT
       ak.plaka_no as dorse_plaka,
       ak2.plaka_no default_arac,
       ak3.plaka_no as asil_arac
FROM
     arac_kartlari as ak
INNER JOIN arac_kartlari as ak2 on ak2.dorse_id=ak.id
LEFT JOIN dorse_degisikligi as dg on dg.dorse_id=ak.id
LEFT JOIN arac_kartlari as ak3 on ak3.id=dg.arac_id
WHERE
      ak.status=1 AND (ak.arac_tipi='Dorse 2 Dingil' OR ak.arac_tipi='Dorse 3 Dingil') AND ak.arac_grubu='Öz Mal'");
        foreach ($dorse_sanayi as $item2) {
            $plaka_no = $item2["dorse_plaka"];
            $aracin_plakasi = $item2["default_arac"];
            if ($item2["asil_arac"] != null) {
                $aracin_plakasi = $item2["asil_arac"];
            }


            $hgs_gider = DB::single_query("
SELECT
SUM(hgu.tutar) as hgs_tutar
FROM
     hgs_gider AS hg
LEFT JOIN hgs_gider_fisleri as hgu on hg.id=hgu.gider_id
INNER JOIN arac_kartlari as ak on ak.id=hgu.plaka_id
WHERE hg.status=1 AND hgu.status=1 AND hg.cari_key='$cari_key' AND ak.plaka_no='$plaka_no' AND hg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
     ");
            if ($aracin_plakasi == $item["plaka_no"]) {
                $hgs_tutari += $hgs_gider["hgs_tutar"];
            }

            $personel_maas = DB::single_query("
SELECT
SUM(ycf.tl_tutar) as yakit_toplam
FROM
     yakit_cikis_fisleri AS ycf
INNER JOIN arac_kartlari as ak on ak.id=ycf.plaka_id
WHERE ycf.status!=0 AND ycf.cari_key='$cari_key' AND ak.plaka_no='$plaka_no' AND ycf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
     ");
            if ($aracin_plakasi == $item["plaka_no"]) {
                $yakit_toplam += $personel_maas["yakit_toplam"];
            }


            $personel_maas = DB::single_query("
SELECT
SUM(sfu.genel_toplam) as genel_toplam
FROM
     sanayi_fisi AS sf
INNER JOIN sanayi_fisi_urunler as sfu on sfu.fis_id=sf.id
INNER JOIN arac_kartlari as ak on ak.id=sfu.plaka_id
WHERE sfu.status!=0 AND sfu.cari_key='$cari_key' AND ak.plaka_no='$plaka_no' AND sf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
     ");
            if ($aracin_plakasi == $item["plaka_no"]) {
                $sanayi_toplam += $personel_maas["genel_toplam"];
            }

            $personel_maas = DB::single_query("
SELECT
SUM(sgf.tutar) as sgk_tutari
FROM
sgk_gider_fisleri as sgf
LEFT JOIN sgk_giderleri as sg on sg.id=sgf.gider_id
INNER JOIN arac_kartlari as ak on sgf.plaka_id=ak.id
WHERE sg.status=1 AND sgf.status=1 AND sgf.cari_key='$cari_key' AND ak.plaka_no='$plaka_no' AND sg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
     ");
            if ($aracin_plakasi == $item["plaka_no"]) {
                $sgk_tutari += $personel_maas["sgk_tutari"];
            }
            $lastik_takma = DB::all_data("
SELECT
       alt.stok_id
FROM
     arac_lastik_tak as alt
INNER JOIN arac_kartlari as ak on ak.id=alt.arac_id
WHERE alt.status!=0 AND alt.cari_key='$cari_key' AND ak.plaka_no='$plaka_no' AND alt.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
            if ($aracin_plakasi == $item["plaka_no"]) {
                $last_birim_fiyat = 0;
                $son_satis = 0;
                foreach ($lastik_takma as $item3) {
                    $son_satis = 0;
                    $alislar_arr = [];
                    $kasa_id = $item3["stok_id"];
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
WHERE psu.status=1 AND ps.status=1 AND psu.stok_kodu='$stok_kodu' AND psu.cari_key='$cari_key'
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
WHERE ad.status=1 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key' AND ad.irsaliye_ids=''
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
WHERE ad.status!=0 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key'
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
WHERE ad.status!=0 AND au.status=1 AND au.stok_id='$kasa_id' AND ad.cari_key='$cari_key'
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
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key'
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
WHERE laf.status=1 AND lafu.status=1 AND lafu.stok_id='$kasa_id' AND laf.cari_key='$cari_key'
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
WHERE laf.status=1 AND lafu.status=1 AND lafu.stok_id='$kasa_id' AND laf.cari_key='$cari_key'
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
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key'
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
WHERE status=1 AND stok_id='$kasa_id' AND cari_key='$cari_key'
");

                    $kasa_devir_kalan_miktar = floatval($kasa_devir_giren_miktar) - floatval($kasa_devir_cikan_miktar);
                    $devirli_miktar = $kasa_devir_kalan_miktar;
                    $elimdeki_maliyet = 0;
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
                                    $son_satis += $maliyetler["birim_fiyat"];
                                    break;
                                }
                            }
                        }
                    }


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
                }
                $lastik_gider_tot += $son_satis;
            }
            $ceza_mtv = DB::single_query("
SELECT
       SUM(kcgf.tutar) as tutar
FROM
     kaza_ceza_gider as kcg
INNER JOIN kaza_ceza_gider_fisleri AS kcgf on kcgf.gider_id=kcg.id
INNER JOIN arac_kartlari as ak on ak.id=kcgf.plaka_id
WHERE
      kcg.status=1 AND kcgf.status=1 AND kcg.cari_key='$cari_key' AND ak.plaka_no='$plaka_no' AND kcg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
            if ($aracin_plakasi == $item["plaka_no"]) {
                $ceza_mtv_tot += $ceza_mtv["tutar"];
            }

            $vergi_mtv = DB::single_query("
SELECT
       SUM(kcgf.tutar) as tutar
FROM
     vergi_gider as kcg
INNER JOIN vergi_gider_fisi AS kcgf on kcgf.gider_id=kcg.id
INNER JOIN arac_kartlari as ak on ak.id=kcgf.plaka_id
WHERE
      kcg.status=1 AND kcgf.status=1 AND kcg.cari_key='$cari_key' AND ak.plaka_no='$plaka_no' AND kcg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
            if ($aracin_plakasi == $item["plaka_no"]) {
                $ceza_mtv_tot += $vergi_mtv["tutar"];
            }
            $arac_gider = DB::single_query("
SELECT
       SUM(agf.tutar) as tutar
FROM 
     arac_gider AS ag
INNER JOIN arac_gider_fisi AS agf on agf.gider_id=ag.id
INNER JOIN arac_kartlari as ak on ak.id=agf.plaka_id
WHERE ag.status=1 AND agf.status=1 AND ag.cari_key='$cari_key' AND ak.plaka_no='$plaka_no' AND kcg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
            if ($aracin_plakasi == $item["plaka_no"]) {
                $aracgider_tot += $arac_gider["tutar"];
            }
        }


        $ciro = $ciro * 1.16;
        $ciro_toplam += $ciro;
        $lastik_toplam += $lastik_gider_tot;
        $ceza_mtv_toplam += $ceza_mtv_tot;
        $arac_gider_toplam += $aracgider_tot;
        $masraf = $prim_tutari + $aracgider_tot + $ceza_mtv_tot + $hgs_tutari + $tahakkuk_toplam + $yakit_toplam + $sanayi_toplam + $sgk_tutari + $lastik_gider_tot;
        $masraf_toplam += $masraf;
        $kar_zarar = $ciro - $masraf;
        $kar_zarar_toplam += $kar_zarar;
        $prim_toplam += $prim_tutari;
        $hgs_toplam += $hgs_tutari;
        $maas_toplam += $tahakkuk_toplam;
        $sgk_toplam += $sgk_tutari;
        $motorin_toplam += $yakit_toplam;
        $sanayi_toplam_main += $sanayi_toplam;

        $prim_tutari = number_format(floatval($prim_tutari), 2, ',', '.');
        $hgs_tutar = number_format(floatval($hgs_tutari), 2, ',', '.');
        $tahakkuk_toplam = number_format(floatval($tahakkuk_toplam), 2, ',', '.');
        $yakit_tutar = number_format(floatval($yakit_toplam), 2, ',', '.');
        $sanayi_toplam = number_format(floatval($sanayi_toplam), 2, ',', '.');
        $sgk_tutari = number_format(floatval($sgk_tutari), 2, ',', '.');
        $kar_zarar = number_format(floatval($kar_zarar), 2, ',', '.');
        $ciro = number_format($ciro, 2, ',', '.');
        $lastik_gider_tot = number_format($lastik_gider_tot, 2, ',', '.');
        $masraf = number_format(floatval($masraf), 2, ',', '.');
        $ceza_mtv_tot = number_format(floatval($ceza_mtv_tot), 2, ',', '.');
        $aracgider_tot = number_format(floatval($aracgider_tot), 2, ',', '.');
        $arr = [
            'no' => $i,
            'prim_odeme' => $prim_tutari,
            'hgs_tutar' => $hgs_tutar,
            'maas_tutar' => $tahakkuk_toplam,
            'yakit_tutar' => $yakit_tutar,
            'sanayi_toplam' => $sanayi_toplam,
            'sgk_tutari' => $sgk_tutari,
            'bolgesi' => $item["bolgesi"],
            'plaka_no' => $item["plaka_no"],
            'kar_zarar' => $kar_zarar,
            'lastik_tutar' => $lastik_gider_tot,
            'ciro' => $ciro,
            'ceza_mtv' => $ceza_mtv_tot,
            'aracgider' => $aracgider_tot,
            'masraf' => $masraf
        ];
        array_push($response, $arr);
        $i++;

    }
    $ciro_toplam = number_format(floatval($ciro_toplam), 2, ',', '.');
    $masraf_toplam = number_format(floatval($masraf_toplam), 2, ',', '.');
    $kar_zarar_toplam = number_format(floatval($kar_zarar_toplam), 2, ',', '.');
    $prim_toplam = number_format(floatval($prim_toplam), 2, ',', '.');
    $hgs_toplam = number_format(floatval($hgs_toplam), 2, ',', '.');
    $maas_toplam = number_format(floatval($maas_toplam), 2, ',', '.');
    $sgk_toplam = number_format(floatval($sgk_toplam), 2, ',', '.');
    $motorin_toplam = number_format(floatval($motorin_toplam), 2, ',', '.');
    $sanayi_toplam_main = number_format(floatval($sanayi_toplam_main), 2, ',', '.');
    $lastik_toplam = number_format(floatval($lastik_toplam), 2, ',', '.');
    $ceza_mtv_toplam = number_format(floatval($ceza_mtv_toplam), 2, ',', '.');
    $arac_gider_toplam = number_format(floatval($arac_gider_toplam), 2, ',', '.');


    if (!empty($response)) {
        $response[0]["ciro_toplam"] = $ciro_toplam;
        $response[0]["masraf_toplam"] = $masraf_toplam;
        $response[0]["kar_zarar_toplam"] = $kar_zarar_toplam;
        $response[0]["prim_toplam"] = $prim_toplam;
        $response[0]["hgs_toplam"] = $hgs_toplam;
        $response[0]["maas_toplam"] = $maas_toplam;
        $response[0]["sgk_toplam"] = $sgk_toplam;
        $response[0]["motorin_toplam"] = $motorin_toplam;
        $response[0]["sanayi_toplam_main"] = $sanayi_toplam_main;
        $response[0]["lastik_toplam"] = $lastik_toplam;
        $response[0]["ceza_mtv_tot"] = $ceza_mtv_toplam;
        $response[0]["arac_gider_toplam"] = $arac_gider_toplam;
        echo json_encode($response);
    } else {
        echo 2;
    }
}
if ($islem == "kar_zarar_raporlarini_getir_sql") {
    $oz_mal_motorin = 0;
    $kiralik_mal_motorin = 0;

    $bas_tarih = "";
    $bit_tarih = "";
    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
    }

    $oz_mal_alislar = DB::single_query("
SELECT 
SUM(tl_tutar) as ozmal_yakit_tutari 
FROM 
     yakit_cikis_fisleri 
WHERE status!=0 AND kiralik_cari_id=0 AND cari_key='$cari_key' AND tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
    $oz_mal_motorin = $oz_mal_alislar["ozmal_yakit_tutari"];

    $kiralik_alislar = DB::single_query("
SELECT 
SUM(tl_tutar) as kiralik_yakit_tutari 
FROM 
     yakit_cikis_fisleri 
WHERE status!=0 AND kiralik_cari_id!=0 AND cari_key='$cari_key' AND tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");
    $kiralik_mal_motorin = $kiralik_alislar["kiralik_yakit_tutari"];

    $odenen_prim_tot = 0;
    $odenen_primler = DB::single_query("
SELECT
SUM(pou.prim_tutari) as prim_tutari
FROM
    prim_odeme as po 
INNER JOIN prim_odeme_urunler as pou on pou.odeme_id=po.id
LEFT JOIN konteyner_irsaliye AS ki on ki.id=pou.irsaliye_id 
WHERE po.status=1 AND pou.status=1 AND po.cari_key='$cari_key' AND ki.irsaliye_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $odenen_prim_tot += $odenen_primler["prim_tutari"];

    $bekleyen_primler = DB::single_query("SELECT SUM(surucu_prim) as prim_tutari FROM konteyner_irsaliye WHERE prim_odendi=1 AND cari_key='$cari_key' AND irsaliye_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $odenen_prim_tot += $bekleyen_primler["prim_tutari"];

    $personel_maas = DB::single_query("
SELECT 
       SUM(pt.tutar) as tutar 
FROM
     personel_tahakkuk as pt 
INNER JOIN personel_tahakkuk_ana as pta on pta.id=pt.tahakuk_id
WHERE pt.status=1 AND pt.cari_key='$cari_key' AND pta.olusturma_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $personel_maaslari = $personel_maas["tutar"];

    $hgs_gider = DB::single_query("
SELECT
SUM(hgu.tutar) as hgs_tutari
FROM
     hgs_gider as hg
INNER JOIN hgs_gider_fisleri AS hgu on hgu.gider_id=hg.id
WHERE hg.status=1 AND hgu.status=1 AND hg.cari_key='$cari_key' AND hg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");

    $lastik_giderleri = DB::single_query("
SELECT 
SUM(lafu.toplam) as genel_toplam
FROM
     lastik_alis_fatura AS laf
INNER JOIN lastik_alis_fatura_urunler AS lafu on lafu.fatura_id=laf.id
WHERE laf.status=1 AND lafu.status=1 AND laf.cari_key='$cari_key'  AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
     ");

    $aku_toplamlari = DB::single_query("
SELECT 
SUM(sfu.genel_toplam) as genel_toplam
FROM 
     sanayi_fatura as sf
INNER JOIN sanayi_fatura_urunler AS sfu ON sfu.fatura_id=sf.id
INNER JOIN sanayi_fisi_urunler as sfu2 on sfu2.id=sfu.sanayi_fisid
WHERE sf.status=1 AND sfu.status=1 AND sfu2.servis_tipi='Akü' AND sf.cari_key='$cari_key'  AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");

    $diger_sanayi = DB::single_query("
SELECT 
SUM(sfu.genel_toplam) as genel_toplam
FROM 
     sanayi_fatura as sf
INNER JOIN sanayi_fatura_urunler AS sfu ON sfu.fatura_id=sf.id
INNER JOIN sanayi_fisi_urunler as sfu2 on sfu2.id=sfu.sanayi_fisid
WHERE sf.status=1 AND sfu.status=1 AND sfu2.servis_tipi!='Akü' AND sf.cari_key='$cari_key'  AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");

    $sgk_giderleri = DB::single_query("
SELECT
SUM(sgf.tutar) as sgk_toplam
FROM
     sgk_giderleri as sg
INNER JOIN sgk_gider_fisleri AS sgf on sgf.gider_id=sg.id
WHERE sgf.status=1 AND sg.status=1 AND sg.cari_key='$cari_key' AND sg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");

    $vergi_giderleri = DB::single_query("
SELECT
SUM(sgf.tutar) as vergi_gider
FROM
     vergi_gider as sg
INNER JOIN vergi_gider_fisi AS sgf on sgf.gider_id=sg.id
WHERE sgf.status=1 AND sg.status=1 AND sg.cari_key='$cari_key' AND sg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");

    $yonetim_giderleri = DB::single_query("
SELECT
SUM(sgf.tutar) as yonetim_gider
FROM
     yonetim_gider as sg
INNER JOIN yonetim_gider_fisi AS sgf on sgf.gider_id=sg.id
WHERE sgf.status=1 AND sg.status=1 AND sg.cari_key='$cari_key' AND sg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");

    $arac_giderleri_sorgu = DB::single_query("
SELECT
SUM(sgf.tutar) as arac_giderleri
FROM
     arac_gider as sg
INNER JOIN arac_gider_fisi AS sgf on sgf.gider_id=sg.id
WHERE sgf.status=1 AND sg.status=1 AND sg.cari_key='$cari_key' AND sg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");

    $kaza_ceza_giderleri = DB::single_query("
SELECT
SUM(sgf.tutar) as kaza_ceza_giderleri
FROM
     kaza_ceza_gider as sg
INNER JOIN kaza_ceza_gider_fisleri AS sgf on sgf.gider_id=sg.id
WHERE sgf.status=1 AND sg.status=1 AND sg.cari_key='$cari_key' AND sg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
");


    $nakliye_zararlari_borc = 0;
    $nakliye_zararlari_alacak = 0;

    $alis_faturalari = DB::single_query("
SELECT
SUM(ad.genel_toplam) as genel_toplam
FROM
alis_default as ad
INNER JOIN cari as c on c.id=ad.cari_id AND c.status=1
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE ad.status=1 AND c.cari_adi='NAKLİYE ZARARLARI' AND ad.cari_key='$cari_key'  AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $nakliye_zararlari_alacak += $alis_faturalari["genel_toplam"];

    $satis_faturalari = DB::single_query("
SELECT
SUM(sd.genel_toplam) as genel_toplam
FROM
satis_default as sd
INNER JOIN cari as c on c.id=sd.cari_id AND c.status=1
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE sd.status=1 AND sd.cari_key='$cari_key' AND c.cari_adi='NAKLİYE ZARARLARI'  AND sd.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $nakliye_zararlari_borc += $satis_faturalari["genel_toplam"];

    $sanayi_fis_fat = DB::single_query("
SELECT
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id AND c.status=1
INNER JOIN bilancolar as b on b.id=c.bilanco_id
INNER JOIN sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
WHERE sf.status=1 AND sfu.status=1 AND sf.cari_key='$cari_key' AND c.cari_adi='NAKLİYE ZARARLARI'  AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    $nakliye_zararlari_alacak += $sanayi_fis_fat["genel_toplam"];

    $satis_faturalari = DB::single_query("
SELECT
SUM(pc.tutar) as tutar
FROM
pos_cekim as pc
INNER JOIN cari as c on c.id=pc.cari_id AND c.status=1
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE pc.status=1 AND pc.cari_key='$cari_key' AND c.cari_adi='NAKLİYE ZARARLARI' AND pc.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
    $nakliye_zararlari_alacak += $satis_faturalari["tutar"];

    $gider_faturalari = DB::single_query("
SELECT
SUM(mgu.genel_toplam) as tutar
FROM
muhasebe_gider_urunler as mgu
INNER JOIN muhasebe_gider as mg on mgu.gider_id=mg.id
INNER JOIN cari as c on c.id=mgu.cari_id AND c.status=1
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE mg.status=1 AND mg.cari_key='$cari_key' AND c.cari_adi='NAKLİYE ZARARLARI' AND mgu.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY mgu.id");
    $nakliye_zararlari_alacak += $gider_faturalari["tutar"];


    $satis_faturalari = DB::single_query("
SELECT
SUM(acu.girilen_tutar) as girilen_tutar
FROM
     alinan_cek_urunler AS acu
INNER JOIN alinan_cek_giris AS acg on acg.id=acu.alinan_cekid
INNER JOIN cari as c on c.id=acg.cari_id AND c.status=1
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND acg.acilis_mi!=2 AND acu.bizim=2 AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' AND acu.cari_key='$cari_key' AND c.cari_adi='NAKLİYE ZARARLARI'");
    $nakliye_zararlari_alacak += $satis_faturalari["girilen_tutar"];

    $satis_faturalari = DB::single_query("
SELECT
SUM(acg.tutar) as tutar
FROM
     bizim_senet_cikis AS acu
INNER JOIN bizim_senet_urunler AS acg on acg.bizim_senetid=acu.id
INNER JOIN cari as c on c.id=acu.cari_id AND c.status=1
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND acu.cari_key='$cari_key' AND c.cari_adi='NAKLİYE ZARARLARI' AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $nakliye_zararlari_borc += $satis_faturalari["tutar"];

    $satis_faturalari = DB::single_query("
SELECT
SUM(acg.tutar) as tutar
FROM
     bizim_cek_cikis AS acu
INNER JOIN bizim_cek_urunler AS acg on acg.bizim_cekid=acu.id
INNER JOIN cari as c on c.id=acu.cari_id and c.status=1
INNER JOIN bilancolar as b ON b.id=c.bilanco_id
WHERE acu.status!=0 AND acg.status!=0 AND acu.acilis_mi!=2 AND acu.cari_key='$cari_key' AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' AND c.cari_adi='NAKLİYE ZARARLARI'");
    $nakliye_zararlari_borc += $satis_faturalari["tutar"];

    $satis_faturalari = DB::single_query("
SELECT
SUM(ac.girilen_tutar) as girilen_tutar
FROM
     karsiliksiz_cek_senet AS acu
INNER JOIN alinan_cek_urunler as ac on ac.id=acu.alinan_cekid
INNER JOIN alinan_cek_giris AS acg on acg.id=ac.alinan_cekid
INNER JOIN cari as c on c.id=acg.cari_id AND c.status=1
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND ac.status!=0 AND acg.acilis_mi!=2  AND acu.cari_key='$cari_key' AND c.cari_adi='NAKLİYE ZARARLARI' AND acu.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $nakliye_zararlari_borc += $satis_faturalari["girilen_tutar"];

    $satis_faturalari = DB::single_query("
SELECT
SUM(acu.girilen_tutar) as girilen_tutar
FROM
     alinan_senet_urunler AS acu
INNER JOIN alinan_senet_giris AS acg on acg.id=acu.alinan_senetid
INNER JOIN cari as c on c.id=acg.cari_id AND c.status=1
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE acu.status=1 AND acg.status!=0 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND c.cari_adi='NAKLİYE ZARARLARI' AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $nakliye_zararlari_alacak += $satis_faturalari["girilen_tutar"];


    $havale_giris = DB::single_query("
SELECT
SUM(hgu.giris_tutar) as giris_tutar
FROM havale_giris_urunler as hgu
INNER JOIN havale_giris AS hg on hg.id=hgu.giris_id
INNER JOIN cari as c on c.id=hgu.cari_id AND c.status=1
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND c.cari_adi='NAKLİYE ZARARLARI' AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $nakliye_zararlari_alacak += $havale_giris["giris_tutar"];

    $havale_cikis = DB::single_query("
SELECT
SUM(hgu.cikis_tutar) as cikis_tutar
FROM havale_cikis_urunler as hgu
INNER JOIN havale_cikis AS hg on hg.id=hgu.cikis_id
INNER JOIN cari as c on c.id=hgu.cari_id AND c.status=1
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 and  hgu.cari_key='$cari_key' AND c.cari_adi='NAKLİYE ZARARLARI' AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $nakliye_zararlari_borc += $havale_cikis["cikis_tutar"];

    $kart_islemi = DB::single_query("
SELECT
SUM(kh.tutar) as tutar
FROM kart_harcama as kh
INNER JOIN cari as c on c.id=kh.cari_id AND c.status=1
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE kh.status=1 AND kh.cari_key='$cari_key' AND c.cari_adi='NAKLİYE ZARARLARI' AND kh.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $nakliye_zararlari_borc += $kart_islemi["tutar"];

    $kasa_tahsilat = DB::single_query("
SELECT
SUM(hgu.tutar) as tutar
FROM kasa_tahsilat_urunler as hgu
INNER JOIN kasa_tahsilat AS hg on hg.id=hgu.tahsilat_id
INNER JOIN cari as c on c.id=hgu.cari_id AND c.status=1
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND  hgu.cari_key='$cari_key' AND c.cari_adi='NAKLİYE ZARARLARI' AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $nakliye_zararlari_alacak += $kasa_tahsilat["tutar"];

    $kasa_odeme = DB::single_query("
SELECT
SUM(hgu.tutar) as tutar
FROM kasa_odeme_urunler as hgu
INNER JOIN kasa_odeme AS hg on hg.id=hgu.odeme_id
INNER JOIN cari as c on c.id=hgu.cari_id AND c.status=1
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND c.cari_adi='NAKLİYE ZARARLARI' AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $nakliye_zararlari_borc += $kasa_odeme["tutar"];


    $mahsup_hareketleri = DB::single_query("
SELECT
SUM(hgu.borc) as borc,
SUM(hgu.alacak) as alacak
FROM cari_mahsup_urunler as hgu
INNER JOIN cari_mahsup AS hg on hg.id=hgu.mahsup_id
INNER JOIN cari as c on c.id=hgu.cari_id AND c.status=1
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND c.cari_adi='NAKLİYE ZARARLARI' AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $nakliye_zararlari_borc += $mahsup_hareketleri["borc"];
    $nakliye_zararlari_alacak += $mahsup_hareketleri["alacak"];

    $acilis_fisi = DB::single_query("
SELECT
SUM(caf.borc) as borc,
SUM(caf.alacak) as alacak
FROM cari_acilis_fisleri as caf
INNER JOIN cari as c on c.id=caf.cari_id AND c.status=1
INNER JOIN bilancolar as b on b.id=c.bilanco_id
WHERE caf.status=1 AND caf.cari_key='$cari_key' AND c.cari_adi='NAKLİYE ZARARLARI' AND caf.acilis_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
    $nakliye_zararlari_borc += $acilis_fisi["borc"];
    $nakliye_zararlari_alacak += $acilis_fisi["alacak"];

    $nakliye_zararlari_toplam = $nakliye_zararlari_borc - $nakliye_zararlari_alacak;

    $ciro = 0;
    $personel_maas = DB::single_query("
SELECT
SUM(ki.tasima_fiyat) as tasima_fiyat
FROM
konteyner_irsaliye as ki
INNER JOIN arac_kartlari as ak on ki.plaka_id=ak.id
WHERE ki.status=2 AND ki.cari_key='$cari_key' AND ak.arac_grubu='Öz Mal' AND ki.irsaliye_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
     ");
    $ciro += $personel_maas["tasima_fiyat"];

//    $personel_maas = DB::single_query("
//SELECT
//SUM(kieh.satis_fiyat) as bekleme_tutari
//FROM
//konteyner_irsaliye_ek_hizmet as kieh
//INNER JOIN konteyner_irsaliye as ki on ki.id=kieh.irsaliye_id
//INNER JOIN arac_kartlari as ak on ki.plaka_id=ak.id
//WHERE ki.status=2 AND kieh.status!=0 AND kieh.cari_id=0 AND kieh.cari_key='$cari_key' AND ak.arac_grubu='Öz Mal' AND ki.irsaliye_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
//     ");
    $ciro += $personel_maas["bekleme_tutari"];
    $ciro = $ciro * 1.16;

    $personel_maas = DB::single_query("
SELECT
SUM(ki.arac_kirasi) as tasima_fiyat
FROM
konteyner_irsaliye as ki
INNER JOIN arac_kartlari as ak on ki.plaka_id=ak.id
WHERE ki.status!=0 AND ki.cari_key='$cari_key' AND ki.irsaliye_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
     ");
    $kiralik_alis = $personel_maas["tasima_fiyat"];
    $kiralik_alis = $kiralik_alis * 1.20;

    $personel_maas = DB::single_query("
SELECT
SUM(ki.tasima_fiyat) as tasima_fiyat
FROM
konteyner_irsaliye as ki
INNER JOIN arac_kartlari as ak on ki.plaka_id=ak.id
WHERE ki.status!=0 AND ki.cari_key='$cari_key' AND ak.arac_grubu='Kiralık' AND ki.irsaliye_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
     ");
    $kiralik_satis = $personel_maas["tasima_fiyat"];
    $kiralik_satis = $kiralik_satis * 1.20;


    $sql = "
SELECT 
       c.cari_kodu,
       c.cari_adi,
       c.aciklama,
       c.id
FROM 
     cari as c
INNER JOIN cari_grubu_tanim AS ctt on ctt.id=c.cari_grubu
WHERE 
      c.status=1 
  AND 
      c.cari_key='$cari_key'
AND ctt.cari_grup_adi='FAALİYET GİDERLERİ'
      ";
    $ekstre_arr = [];

    $dogru_cariler = DB::all_data($sql);
    $toplam_faaliyet_giderleri = 0;
    foreach ($dogru_cariler as $item) {

        $cari_id = $item["id"];
        $alis_faturalari = DB::all_data("
SELECT
genel_toplam
FROM
alis_default
WHERE status=1 AND cari_key='$cari_key' AND cari_id='$cari_id' AND fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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

        $kiralik_yakit_alim = DB::single_query("SELECT SUM(tl_tutar) as tutar FROM yakit_cikis_fisleri WHERE status!=0 AND kiralik_cari_id='$cari_id' AND tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
        $cari_devir_borc += $kiralik_yakit_alim["tutar"];


        $sanayi_fis_fat = DB::all_data("
SELECT
       sf.*,
       c.cari_adi,
       SUM(sfu.genel_toplam) as genel_toplam
FROM
     binek_sanayi_fatura as sf
INNER JOIN cari as c on c.id=sf.cari_id
INNER JOIN binek_sanayi_fatura_urunler as sfu on sfu.fatura_id=sf.id
WHERE sf.status=1 AND sf.cari_key='$cari_key' AND sf.cari_id='$cari_id' AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
        if ($sanayi_fis_fat > 0) {
            foreach ($sanayi_fis_fat as $alislar) {
                $cari_devir_alacak += $alislar["genel_toplam"];
            }
        }

        $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(byc.tl_tutar) as tutar
FROM
binek_yakit_fatura as laf
INNER JOIN binek_fis_faturasi as lafu on lafu.fatura_id=laf.id
INNER JOIN binek_yakit_cikis as byc on byc.id=lafu.yakit_fis_id
WHERE laf.status=1 AND lafu.status=1 AND laf.cari_key='$cari_key' AND laf.cari_id='$cari_id' AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
        $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


        $lastik_alis_faturalari = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.gider_id=laf.id
WHERE laf.status=1 AND lafu.status=1 AND laf.cari_key='$cari_key' AND lafu.cari_id='$cari_id' AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
        $cari_devir_alacak += $lastik_alis_faturalari["tutar"];


        $satis_faturalari = DB::single_query("
SELECT
SUM(acu.girilen_tutar) as tutar
FROM
     cikis_cek_urunler AS acu
INNER JOIN alinan_cek_cikis AS acg on acg.id=acu.cikis_cekid
WHERE acu.status!=0 AND acg.status!=0 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
        $cari_devir_borc += $satis_faturalari["tutar"];

        $vergi_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
vergi_gider as laf
INNER JOIN vergi_gider_fisi as lafu on lafu.gider_id=laf.id
WHERE laf.status=1 AND lafu.status=1 AND laf.cari_key='$cari_key' AND lafu.cari_id='$cari_id' AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
        $cari_devir_alacak += $vergi_gider["tutar"];

        $yonetim_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
yonetim_gider as laf
INNER JOIN yonetim_gider_fisi as lafu on lafu.gider_id=laf.id
WHERE laf.status=1 AND lafu.status=1 AND laf.cari_key='$cari_key' AND lafu.cari_id='$cari_id' AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
        $cari_devir_alacak += $yonetim_gider["tutar"];


        $sgk_gider_fisleri = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar 
FROM
     sgk_giderleri as laf
INNER JOIN sgk_gider_fisleri as lafu on lafu.gider_id=laf.id
WHERE laf.status=1 AND lafu.status=1 AND laf.cari_key='$cari_key' AND lafu.cari_id='$cari_id' AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
        $cari_devir_alacak += $sgk_gider_fisleri["tutar"];


        $arac_gider = DB::single_query("
SELECT
SUM(lafu.tutar) as tutar
FROM
     arac_gider as laf
INNER JOIN arac_gider_fisi as lafu on lafu.gider_id=laf.id
WHERE laf.status=1 AND lafu.status=1 AND laf.cari_key='$cari_key' AND lafu.cari_id='$cari_id' AND laf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
        $cari_devir_alacak += $arac_gider["tutar"];

        $gider_faturalari = DB::all_data("
SELECT
mg.fatura_no as belge_no,
mg.fatura_tarihi as tarih,
mg.aciklama,
SUM(mgu.genel_toplam) as tutar
FROM
muhasebe_gider_urunler as mgu
INNER JOIN muhasebe_gider as mg on mgu.gider_id=mg.id
WHERE mg.status=1 AND mg.cari_key='$cari_key' AND mgu.cari_id='$cari_id' AND mg.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY mgu.id");
        if ($gider_faturalari > 0) {
            foreach ($gider_faturalari as $alislar) {
                $cari_devir_alacak += $alislar["tutar"];
            }
        }

        $lastik_alis_faturalari = DB::all_data("
SELECT
laf.genel_toplam,
laf.fatura_tarihi,
laf.fatura_no,
laf.aciklama,
laf.vade_tarihi
FROM
lastik_alis_fatura as laf
INNER JOIN lastik_alis_fatura_urunler as lafu on lafu.fatura_id=laf.id
WHERE laf.status=1 AND lafu.status=1 AND laf.cari_key='$cari_key' AND laf.cari_id='$cari_id' AND laf.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
        if ($lastik_alis_faturalari > 0) {
            foreach ($lastik_alis_faturalari as $alislar) {
                $cari_devir_alacak += $alislar["genel_toplam"];
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
WHERE sf.status=1 AND sf.cari_key='$cari_key' AND sf.cari_id='$cari_id' AND sf.fatura_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY sf.id");
        if ($sanayi_fis_fat > 0) {
            foreach ($sanayi_fis_fat as $alislar) {
                $cari_devir_alacak += $alislar["genel_toplam"];
            }
        }

        $satis_faturalari = DB::all_data("
SELECT
genel_toplam
FROM
satis_default
WHERE status=1 AND cari_key='$cari_key' AND cari_id='$cari_id' AND fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
        if ($satis_faturalari > 0) {
            foreach ($satis_faturalari as $alislar) {
                $cari_devir_borc += $alislar["genel_toplam"];
            }
        }

        $personel_kodu = $item["cari_kodu"];
        $satis_faturalari = DB::all_data("
SELECT
pta.tutar
FROM
personel_tahakkuk as pta
INNER JOIN personel_tanim as pt on pt.id=pta.personel_id
INNER JOIN personel_tahakkuk_ana as pta2 on pta2.id=pta.tahakuk_id
WHERE pta.status=1 AND pta.cari_key='$cari_key' AND pt.personel_kodu='$personel_kodu' AND pta2.olusturma_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
        if ($satis_faturalari > 0) {
            foreach ($satis_faturalari as $alislar) {
                $cari_devir_alacak += $alislar["tutar"];
            }
        }
        $kart_islemi = DB::all_data("
SELECT
tutar,
tarih,
belge_no,
aciklama
FROM kart_harcama
WHERE status=1 AND cari_id='$cari_id' AND cari_key='$cari_key' AND tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
WHERE status=1 AND cari_key='$cari_key' AND cari_id='$cari_id' AND tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
WHERE acu.status!=0 AND acg.status!=0 AND acg.acilis_mi!=2 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
WHERE acu.status!=0 AND acg.status!=0 AND acu.cari_key='$cari_key' AND acu.cari_id='$cari_id' AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
WHERE acu.status!=0 AND acg.status!=0 AND acu.acilis_mi!=2 AND acu.cari_key='$cari_key' AND acu.cari_id='$cari_id' AND acu.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
WHERE acu.status=1 AND ac.status!=0 AND acg.acilis_mi!=2  AND acg.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acu.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
WHERE acu.status=1 AND acg.status!=0 AND acu.bizim=2 AND acu.cari_key='$cari_key' AND acg.cari_id='$cari_id' AND acg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
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
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

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
WHERE hg.status=1 AND hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.cari_id='$cari_id' AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

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
WHERE status=1 AND cari_key='$cari_key' AND cari_id='$cari_id' AND acilis_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");
        if ($acilis_fisi > 0) {
            foreach ($acilis_fisi as $giris) {
                $cari_devir_alacak += $giris["alacak"];
                $cari_devir_borc += $giris["borc"];
            }
        }
        $cari_devir_bakiye = floatval($cari_devir_borc) - floatval($cari_devir_alacak);
        $toplam_faaliyet_giderleri += $cari_devir_bakiye;
        $cari_devir_bakiye = number_format($cari_devir_bakiye, 2);
        $devir_arr = [
            'cari_kodu' => $item["cari_kodu"],
            'cari_unvan' => $item["cari_adi"],
            'bilanco_kodu' => $item["bilanco_kodu"],
            'cari_grubu' => $item["cari_grubu"],
            'borc' => $cari_devir_borc,
            'alacak' => $cari_devir_alacak,
            'bakiye' => $cari_devir_bakiye,
            'aciklama' => $item["aciklama"]
        ];
        if ($cari_devir_bakiye == 0) {

        } else {
            array_push($ekstre_arr, $devir_arr);
        }
    }
    $motorin_total = $oz_mal_motorin;

    $binek_yakit = DB::single_query("
select
       SUM(tl_tutar) as tutar 
from binek_yakit_cikis 
WHERE status!=0 AND cari_key='$cari_key' AND tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'");

    $binek_yakit_total = $binek_yakit["tutar"];

    $binek_sanayi = DB::single_query("
SELECT
       SUM(genel_toplam) as toplam
FROM
     binek_sanayi_fisi as bsf
INNER JOIN binek_sanayi_fisi_urunler  as bsfu on bsfu.fis_id=bsf.id
WHERE bsf.status!=0 AND bsfu.status!=0 AND bsf.cari_key='$cari_key' AND bsf.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
     ");
    $binek_bakim_tot = $binek_sanayi["toplam"];

    $binek_mtv_vs = 0;
    $binek_hgs = DB::single_query("
SELECT
       SUM(bhgf.tutar) as tutar
FROM 
     binek_hgs_gider AS bhg
INNER JOIN binek_hgs_gider_fisleri as bhgf on bhgf.gider_id=bhg.id
WHERE bhg.status=1 AND bhg.cari_key='$cari_key' AND bhg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
     ");
    $binek_mtv_vs += $binek_hgs["tutar"];

    $binek_vergi_ve_diger = DB::single_query("
SELECT
       SUM(bvgf.tutar) as tutar
FROM
     binek_vergi_gider AS bvg 
INNER JOIN binek_vergi_gider_fisleri AS bvgf on bvgf.gider_id=bvg.id
WHERE bvg.status=1 AND bvgf.status=1 AND bvg.cari_key='$cari_key' AND bvg.tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'
     ");
    $binek_mtv_vs += $binek_vergi_ve_diger["tutar"];

//    $ek_hizmetler = DB::all_data("
//SELECT
//       SUM(kieh.alis_fiyat) as alis_fiyat,
//       SUM(kieh.satis_fiyat) as satis_fiyat,
//       s.stok_adi,
//       s.kdv_orani
//FROM
//     konteyner_irsaliye_ek_hizmet as kieh
//INNER JOIN konteyner_irsaliye as ki on ki.id=kieh.irsaliye_id
//INNER JOIN stok as s on s.id=kieh.hizmet_id
//WHERE kieh.status!=0 AND kieh.cari_key='$cari_key' AND ki.irsaliye_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY kieh.hizmet_id");

    $merge_arr = [];
    $ek_hizmetler_alis = DB::all_data("
SELECT
       SUM(au.toplam_tutar) as alis_fiyat,
       s.stok_adi
FROM
     alis_default as ad 
INNER JOIN alis_urunler as au on au.alis_defaultid=ad.id
INNER JOIN stok as s on s.id=au.stok_id
INNER JOIN stok_alt_grup as sago on sago.id=s.stok_alt_grupid
WHERE ad.status=1 AND au.status=1 AND sago.altgrup_adi='EK HİZMET' AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY s.id
");
    if (!empty($ek_hizmetler_alis)) {
        $merge_arr = array_merge($merge_arr, $ek_hizmetler_alis);
    }

    $ek_hizmetler_satis = DB::all_data("
SELECT
       SUM(au.toplam_tutar) as satis_fiyat,
       s.stok_adi
FROM
     satis_default as ad 
INNER JOIN satis_urunler as au on au.satis_defaultid=ad.id
INNER JOIN stok as s on s.id=au.stok_id
INNER JOIN stok_alt_grup as sago on sago.id=s.stok_alt_grupid
WHERE ad.status=1 AND au.status=1 AND sago.altgrup_adi='EK HİZMET' AND ad.fatura_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59' GROUP BY s.id
");
    if (!empty($ek_hizmetler_satis)) {
        $merge_arr = array_merge($merge_arr, $ek_hizmetler_satis);
    }
    $merge_arr = DB::birlestirVeSifirla($merge_arr);
    $ek_hizmetler_arr = [];
    $total_ek_kazanc = 0;
    foreach ($merge_arr as $hizmetler) {
        $fiyat_farki = $hizmetler["satis_fiyat"] - $hizmetler["alis_fiyat"];
        $total_ek_kazanc += $fiyat_farki;
        $fiyat_farki = number_format($fiyat_farki, 2);
        $arr = [
            'stok_adi' => $hizmetler["stok_adi"],
            'kazanc' => $fiyat_farki
        ];
        array_push($ek_hizmetler_arr, $arr);
    }

    $depo_hizmet_gelirleri = 0;
    $merge_arr1 = [];
    if (!empty($satis_gelirleri)) {
        $merge_arr1 = array_merge($merge_arr1, $satis_gelirleri);
    }

    if (!empty($alis_giderleri)) {
        $merge_arr1 = array_merge($merge_arr1, $alis_giderleri);
    }

    $birlestirilmis = [];

// Her elemanı kontrol etmek için döngü
    foreach ($merge_arr1 as $item) {
        $stok_id = $item['stok_id'];

        // stok_id değerine göre birleştirilmiş dizide ilgili stok_id var mı kontrol et
        if (!isset($birlestirilmis[$stok_id])) {
            $birlestirilmis[$stok_id] = [
                'stok_id' => $stok_id,
                'satis_fiyat' => 0,
                'alis_fiyat' => 0,
            ];
        }

        // Verileri ilgili stok_id içinde birleştir
        foreach ($item as $key => $value) {
            if ($key !== 'stok_id') {
                $birlestirilmis[$stok_id][$key] += $value;
            }
        }
    }
    $depo_arr = [];
    $depo_tot = 0;

    $ciro += $dusecek_fiyat;
    foreach ($birlestirilmis as $item) {

        $stock_id = $item["stok_id"];
        $stock = DB::single_query("SELECT stok_adi FROM stok WHERE id='$stock_id'");
        if ($stock["stok_adi"] == "İÇ YÜKLEMELER/BOŞALTMALAR") {
            $fiyat_farki = ($item["satis_fiyat"] - $dusecek_fiyat) - $item["alis_fiyat"];
        } else {
            $fiyat_farki = ($item["satis_fiyat"]) - $item["alis_fiyat"];
        }
        $arr = [
            'stock_id' => $item["stok_id"],
            'stock_name' => $stock["stok_adi"],
            'net_kazanc' => number_format($fiyat_farki, 2)
        ];
        $depo_tot += $fiyat_farki;
        array_push($depo_arr, $arr);
    }


    $sanayi_giderler_toplami = $lastik_giderleri["genel_toplam"] + $aku_toplamlari["genel_toplam"] + $diger_sanayi["genel_toplam"];
    $arac_giderleri = $hgs_gider["hgs_tutari"] + $sgk_giderleri["sgk_toplam"] + $vergi_giderleri["vergi_gider"] + $yonetim_giderleri["yonetim_gider"] + $arac_giderleri_sorgu["arac_giderleri"] + $kaza_ceza_giderleri["kaza_ceza_giderleri"];
    $tasit_gider_tot = $binek_mtv_vs + $binek_bakim_tot + $binek_yakit_total;
    $toplam_giderler = $motorin_total + $nakliye_zararlari_toplam + $personel_maaslari + $toplam_faaliyet_giderleri + $sanayi_giderler_toplami + $arac_giderleri + $odenen_prim_tot + $tasit_gider_tot;
    $kiralik_satis_geliri = $kiralik_satis - $kiralik_alis;
    $toplam_gelirler = $kiralik_satis_geliri + $ciro + $total_ek_kazanc + $depo_tot;
    $kar_zarar_toplami = $toplam_gelirler - $toplam_giderler;

    $arr = [
        'ozmal_motorin' => $oz_mal_motorin,
        'prim_tutari' => $odenen_prim_tot,
        'personel_maas' => $personel_maaslari,
        'hgs_gider' => $hgs_gider["hgs_tutari"],
        'lastik_giderleri' => $lastik_giderleri["genel_toplam"],
        'sgk_toplam' => $sgk_giderleri["sgk_toplam"],
        'vergi_gider' => $vergi_giderleri["vergi_gider"],
        'motorin_total' => $motorin_total,
        'yonetim_gider' => $yonetim_giderleri["yonetim_gider"],
        'arac_giderleri' => $arac_giderleri_sorgu["arac_giderleri"],
        'aku_faturalari' => $aku_toplamlari["genel_toplam"],
        'kaza_ceza_giderleri' => $kaza_ceza_giderleri["kaza_ceza_giderleri"],
        'toplam_giderler' => $toplam_giderler,
        'kar_zarar_toplami' => $kar_zarar_toplami,
        'kiralik_satis_geliri' => $kiralik_satis_geliri,
        'toplam_gelirler' => $toplam_gelirler,
        'nakliye_zararlari' => $nakliye_zararlari_toplam,
        'faaliyet_total' => $toplam_faaliyet_giderleri,
        'arac_gider_total' => $arac_giderleri,
        'ciro' => $ciro,
        'faaliyet_giderleri' => $ekstre_arr,
        'kiralik_alis' => $kiralik_alis,
        'sanayi_giderler_total' => $sanayi_giderler_toplami,
        'kiralik_satis' => $kiralik_satis,
        'diger_sanayi' => $diger_sanayi["genel_toplam"],
        'kiralik_motorin' => $kiralik_mal_motorin,
        'binek_yakit' => $binek_yakit_total,
        'binek_bakim_toplam' => $binek_bakim_tot,
        'binek_mtv_vs' => $binek_mtv_vs,
        'tasit_gider_tot' => $tasit_gider_tot,
        'ek_hizmet_arr' => $ek_hizmetler_arr,
        'depo_arr' => $depo_arr,
        'total_ek_kazanc' => $total_ek_kazanc,
        'toplam_depo_geliri' => $depo_tot,
    ];
    echo json_encode($arr);
}