<?php
include '../DB.php';
date_default_timezone_set('Europe/Istanbul');
session_start();
DB::connect();
$cari_key = $_SESSION["cari_key"];
$sube_key = $_SESSION["sube_key"];
$islem = $_GET["islem"];


if ($islem == "kredi_kart_ekstresini_getir") {
    $ekstre_arr = [];
    $kart_id = $_GET["kart_id"];
    $bas_tarih = $_GET["bas_tarih"];
    $sorgu_bas = $_GET["bas_tarih"];
    $bit_tarih = $_GET["bit_tarih"];


    $bas_tarih = new DateTime($bas_tarih);
    $bas_tarih->modify('-1 day');
    $last_bas_tarih = $bas_tarih->format('Y-m-d');

    $yil_basi = new DateTime();
    $yil_basi->modify('first day of January ' . $yil_basi->format('Y'));

    $yil_basi = $yil_basi->format('Y-m-d');
    if ($bas_tarih == "" && $bit_tarih == "") {
        $last_bas_tarih = date("Y-m-d");
    }
    $kart_devir_borc = 0;
    $kart_devir_alacak = 0;
    $kart_devir_bakiye = 0;
    $b_durum = "";
    $belge_turu = "";
    $kart_harcamalari = DB::all_data("
SELECT
kh.*,
c.cari_adi
FROM
kart_harcama as kh
INNER JOIN cari as c on c.id=kh.cari_id
WHERE kh.status=1 AND kh.cari_key='$cari_key' AND kh.kart_id='$kart_id' AND kh.tarih < '$last_bas_tarih 23:59:59'");

    if ($kart_harcamalari > 0) {
        foreach ($kart_harcamalari as $alislar) {
            $kart_devir_borc += $alislar["tutar"];
        }
    }
    $kart_odemeleri = DB::all_data("
SELECT
b.hesap_adi,
kko.islem_tarihi,
kko.aciklama,
kko.tutar
FROM
kredi_kart_odeme as kko
INNER JOIN banka as b on b.id=kko.banka_id
WHERE kko.status=1 AND kko.cari_key='$cari_key' AND kko.kart_id='$kart_id' AND kko.islem_tarihi < '$last_bas_tarih 23:59:59'");
    if ($kart_odemeleri > 0) {
        foreach ($kart_odemeleri as $alislar) {
            $kart_devir_borc += $alislar["tutar"];
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
      byc.status!=0 AND byc.cari_key='$cari_key' AND byc.kart_id='$kart_id' AND byc.tarih  < '$last_bas_tarih 23:59:59'");
    if ($binek_yakit_alim > 0) {
        foreach ($binek_yakit_alim as $alislar) {
            $kart_devir_alacak += $alislar["tl_tutar"];
        }
    }
    $arac_gider = DB::all_data("
SELECT
tutar
FROM
arac_gider_fisi as agf
INNER JOIN arac_gider as ag on ag.id=agf.gider_id
WHERE agf.status=1 AND ag.status!=0 AND agf.kart_id='$kart_id' AND agf.cari_key='$cari_key' AND agf.tarih  < '$last_bas_tarih 23:59:59'
");
    if ($arac_gider > 0) {
        foreach ($arac_gider as $alislar) {
            $kart_devir_alacak += $alislar["tutar"];
        }
    }
    $sgk_gider_fisleri = DB::all_data("
SELECT
sgf.tutar
FROM
sgk_gider_fisleri as sgf
INNER JOIN sgk_giderleri as sg on sg.id=sgf.gider_id
WHERE sgf.status=1 AND sgf.kart_id='$kart_id' AND sgf.cari_key='$cari_key' AND sg.status!=0 AND sgf.tarih  < '$last_bas_tarih 23:59:59'
");
    if ($sgk_gider_fisleri > 0) {
        foreach ($sgk_gider_fisleri as $alislar) {
            $kart_devir_alacak += $alislar["tutar"];
        }
    }
    $sgk_gider_fisleri = DB::all_data("
SELECT
borc,
alacak
FROM
kredi_kart_acilis
WHERE status=1 AND kart_id='$kart_id' AND cari_key='$cari_key' AND acilis_tarihi  < '$last_bas_tarih 23:59:59'
");

    if ($sgk_gider_fisleri > 0) {
        foreach ($sgk_gider_fisleri as $alislar) {
            $kart_devir_borc += $alislar["borc"];
            $kart_devir_alacak += $alislar["alacak"];
        }
    }

    $sgk_gider_fisleri = DB::all_data("
SELECT
sgf.tutar
FROM
sgk_gider_fisleri as sgf
INNER JOIN sgk_giderleri as sg on sg.id=sgf.gider_id
WHERE sgf.status=1 AND sgf.kart_id='$kart_id' AND sgf.cari_key='$cari_key' AND sg.status!=0 AND sgf.tarih  < '$last_bas_tarih 23:59:59'
");
    if ($sgk_gider_fisleri > 0) {
        foreach ($sgk_gider_fisleri as $alislar) {
            $kart_devir_alacak += $alislar["tutar"];
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
WHERE vgf.status=1 AND vg.status!=0 AND vgf.kart_id='$kart_id' AND vgf.cari_key='$cari_key' AND vgf.tarih < '$last_bas_tarih 23:59:59'
");
    if ($vergi_gider > 0) {
        foreach ($vergi_gider as $alislar) {
            $kart_devir_alacak += $alislar["tutar"];
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
WHERE vgf.status=1 AND vg.status=1 AND vgf.kart_id='$kart_id' AND vgf.cari_key='$cari_key' AND vg.tarih  < '$last_bas_tarih 23:59:59'
");
    if ($vergi_gider > 0) {
        foreach ($vergi_gider as $alislar) {
            $kart_devir_alacak += $alislar["tutar"];
        }
    }

    $vergi_gider = DB::all_data("
SELECT
tutar,
tarih,
aciklama
FROM
yonetim_gider_fisi 
WHERE status=1 AND kart_id='$kart_id' AND cari_key='$cari_key' AND tarih < '$last_bas_tarih 23:59:59'
");
    if ($vergi_gider > 0) {
        foreach ($vergi_gider as $alislar) {
            $kart_devir_alacak += $alislar["tutar"];
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
WHERE hgf.status=1 AND hg.status=1 AND hgf.kart_id='$kart_id' AND hgf.cari_key='$cari_key' AND hg.tarih < '$last_bas_tarih 23:59:59'
");
    if ($hgs_gider > 0) {
        foreach ($hgs_gider as $alislar) {
            $kart_devir_alacak += $alislar["tutar"];
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
WHERE hgf.status=1 AND hg.status=1 AND hgf.kart_id='$kart_id' AND hgf.cari_key='$cari_key' AND hg.tarih < '$last_bas_tarih 23:59:59'
");
    if ($hgs_gider > 0) {
        foreach ($hgs_gider as $alislar) {
            $kart_devir_alacak += $alislar["tutar"];
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
WHERE hgf.status=1 AND hg.status=1 AND hgf.kart_id='$kart_id' AND hgf.cari_key='$cari_key' AND hg.tarih < '$last_bas_tarih 23:59:59'
");
    if ($kaza_ceza > 0) {
        foreach ($kaza_ceza as $alislar) {
            $kart_devir_alacak += $alislar["tutar"];
        }
    }
// BURAYA KADAR OLAN DEVİR İÇİN
    $kart_devir_bakiye = floatval($kart_devir_borc) - floatval($kart_devir_alacak);
    if ($kart_devir_bakiye < 0) {
        $kart_devir_bakiye = -$kart_devir_bakiye;
        $b_durum = "A";
    } else if ($kart_devir_bakiye == 0) {
        $b_durum = "YOK";
    } else {
        $b_durum = "B";
    }
    $devir_arr = [
        'tarih' => $sorgu_bas,
        'belge_turu' => "",
        'cari_adi' => ".....",
        'aciklama' => 'Bir Önceki Tarihten Devir',
        'borc' => $kart_devir_alacak,
        'alacak' => $kart_devir_alacak,
        'bakiye' => $kart_devir_bakiye,
        'b_durum' => $b_durum,
        'vade_tarihi' => ""
    ];
    array_push($ekstre_arr, $devir_arr);
    $ekstre_arr1 = [];

    $kart_odemeleri = DB::all_data("
SELECT
b.hesap_adi,
kko.islem_tarihi,
kko.aciklama,
kko.tutar
FROM
kredi_kart_odeme as kko
INNER JOIN banka as b on b.id=kko.banka_id
WHERE kko.status=1 AND kko.cari_key='$cari_key' AND kko.kart_id='$kart_id' AND kko.islem_tarihi BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($kart_odemeleri > 0) {
        foreach ($kart_odemeleri as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["islem_tarihi"],
                'cari_adi' => "",
                'belge_turu' => 'Kart Ödemesi',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["islem_tarihi"],
                'borc' => $alislar["tutar"],
                'alacak' => 0,
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
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
WHERE vgf.status=1 AND vg.status=1 AND vgf.kart_id='$kart_id' AND vgf.cari_key='$cari_key' AND vg.tarih  BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($vergi_gider > 0) {
        foreach ($vergi_gider as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'cari_adi' => $alislar["arac_plaka"],
                'belge_turu' => 'BİNEK VERGİ ÖDEMESİ',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["tarih"],
                'borc' => 0,
                'alacak' => $alislar["tutar"],
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }

    $sgk_gider_fisleri = DB::all_data("
SELECT
borc,
alacak,
acilis_tarihi,
aciklama
FROM
kredi_kart_acilis
WHERE status=1 AND kart_id='$kart_id' AND cari_key='$cari_key' AND acilis_tarihi  BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");

    if ($sgk_gider_fisleri > 0) {
        foreach ($sgk_gider_fisleri as $alislar) {
            if ($alislar["borc"] == 0){

            }else{
                $duzenle_arr3 = [
                    'tarih' => $alislar["acilis_tarihi"],
                    'cari_adi' => "",
                    'belge_turu' => 'Kart Açılış Fişi Borç',
                    'aciklama' => $alislar["aciklama"],
                    'vade_tarihi' => $alislar["acilis_tarihi"],
                    'borc' => $alislar["borc"],
                    'alacak' => 0,
                ];
                array_push($ekstre_arr1, $duzenle_arr3);
            }
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
      byc.status!=0 AND byc.cari_key='$cari_key' AND byc.kart_id='$kart_id' AND byc.tarih  BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($binek_yakit_alim > 0) {
        foreach ($binek_yakit_alim as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'cari_adi' => "TAŞITLAR",
                'belge_turu' => 'BİNEK YAKIT ALIMI',
                'aciklama' => $alislar["arac_plaka"],
                'vade_tarihi' => $alislar["tarih"],
                'borc' => 0,
                'alacak' => $alislar["tl_tutar"],
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }

    $sgk_gider_fisleri = DB::all_data("
SELECT
borc,
alacak,
acilis_tarihi,
aciklama
FROM
kredi_kart_acilis
WHERE status=1 AND kart_id='$kart_id' AND cari_key='$cari_key' AND acilis_tarihi  BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");

    if ($sgk_gider_fisleri > 0) {
        foreach ($sgk_gider_fisleri as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["acilis_tarihi"],
                'cari_adi' => "",
                'belge_turu' => 'Kart Açılış Fişi Alacak',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["acilis_tarihi"],
                'borc' => 0,
                'alacak' => $alislar["alacak"],
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }
    $kaza_ceza = DB::all_data("
SELECT
hgf.tutar,
hgf.aciklama,
hg.tarih,
ak.plaka_no
FROM
kaza_ceza_gider_fisleri as hgf
INNER JOIN kaza_ceza_gider as hg on hg.id=hgf.gider_id
INNER JOIN arac_kartlari as ak on ak.id=hgf.plaka_id
WHERE hgf.status=1 AND hg.status=1 AND hgf.kart_id='$kart_id' AND hgf.cari_key='$cari_key' AND hg.tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($kaza_ceza > 0) {
        foreach ($kaza_ceza as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'cari_adi' => $alislar["plaka_no"],
                'belge_turu' => 'KAZA CEZA GİDERLERİ',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["tarih"],
                'borc' => 0,
                'alacak' => $alislar["tutar"],
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }
    $hgs_gider = DB::all_data("
SELECT
hgf.tutar,
hgf.aciklama,
hg.tarih,
ak.plaka_no
FROM
hgs_gider_fisleri as hgf
INNER JOIN hgs_gider as hg on hg.id=hgf.gider_id
INNER JOIN arac_kartlari as ak on ak.id=hgf.plaka_id
WHERE hgf.status=1 AND hg.status=1 AND hgf.kart_id='$kart_id' AND hgf.cari_key='$cari_key' AND hg.tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($hgs_gider > 0) {
        foreach ($hgs_gider as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'cari_adi' => $alislar["plaka_no"],
                'belge_turu' => 'HGS GİDER',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["tarih"],
                'borc' => 0,
                'alacak' => $alislar["tutar"],
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }
    $hgs_gider = DB::all_data("
SELECT
hgf.tutar,
hgf.aciklama,
hg.tarih,
ak.arac_plaka
FROM
binek_hgs_gider_fisleri as hgf
INNER JOIN binek_hgs_gider as hg on hg.id=hgf.gider_id
INNER JOIN binek_kartlari as ak on ak.id=hgf.plaka_id
WHERE hgf.status=1 AND hg.status=1 AND hgf.kart_id='$kart_id' AND hgf.cari_key='$cari_key' AND hg.tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($hgs_gider > 0) {
        foreach ($hgs_gider as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'cari_adi' => $alislar["arac_plaka"],
                'belge_turu' => 'Binek HGS GİDER',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["tarih"],
                'borc' => 0,
                'alacak' => $alislar["tutar"],
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }
    $yonetim_gider = DB::all_data("
SELECT
ygf.tutar,
ygf.tarih,
ygf.aciklama,
ak.plaka_no
FROM
yonetim_gider_fisi as ygf
INNER JOIN arac_kartlari as ak on ak.id=ygf.plaka_id
INNER JOIN yonetim_gider AS yg on yg.id=ygf.gider_id
WHERE yg.status=1 AND ygf.kart_id='$kart_id' AND ygf.cari_key='$cari_key' AND ygf.tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($yonetim_gider > 0) {
        foreach ($yonetim_gider as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'cari_adi' => $alislar["plaka_no"],
                'belge_turu' => 'YÖNETİM GİDERİ',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["tarih"],
                'borc' => 0,
                'alacak' => $alislar["tutar"],
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }
    $vergi_gider = DB::all_data("
SELECT
vgf.tutar,
vgf.tarih,
vgf.aciklama,
ak.plaka_no
FROM
vergi_gider_fisi as vgf
INNER JOIN arac_kartlari as ak on ak.id=vgf.plaka_id
INNER JOIN vergi_gider as vg on vg.id=vgf.gider_id
WHERE vgf.status=1 AND vgf.kart_id='$kart_id' AND vg.status!=0 AND vgf.cari_key='$cari_key' AND vgf.tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($vergi_gider > 0) {
        foreach ($vergi_gider as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'cari_adi' => $alislar["plaka_no"],
                'belge_turu' => 'VERGİ GİDER',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["tarih"],
                'borc' => 0,
                'alacak' => $alislar["tutar"],
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }
    $sgk_gider_fisleri = DB::all_data("
SELECT
sgf.tutar,
sgf.aciklama,
sgf.tarih,
ak.plaka_no
FROM
sgk_gider_fisleri as sgf
INNER JOIN arac_kartlari as ak on ak.id=sgf.plaka_id
INNER JOIN sgk_giderleri as sg on sg.id=sgf.gider_id
WHERE sgf.status=1 AND sgf.kart_id='$kart_id' AND sg.status!=0 AND sgf.cari_key='$cari_key' AND sgf.tarih  BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($sgk_gider_fisleri > 0) {
        foreach ($sgk_gider_fisleri as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'cari_adi' => $alislar["plaka_no"],
                'belge_turu' => 'SGK GİDER',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["tarih"],
                'borc' => 0,
                'alacak' => $alislar["tutar"],
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }
    $arac_gider = DB::all_data("
SELECT
agf.tutar,
agf.aciklama,
agf.tarih,
ak.plaka_no
FROM
arac_gider_fisi as agf
INNER JOIN arac_kartlari as ak on ak.id=agf.plaka_id
INNER JOIN arac_gider as ag on ag.id=agf.gider_id
WHERE agf.status=1 AND ag.status!=0 AND agf.kart_id='$kart_id' AND agf.cari_key='$cari_key' AND agf.tarih  BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'
");
    if ($arac_gider > 0) {
        foreach ($arac_gider as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'cari_adi' => $alislar["plaka_no"],
                'belge_turu' => 'ARAÇ GİDER',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["tarih"],
                'borc' => 0,
                'alacak' => $alislar["tutar"],
            ];
            array_push($ekstre_arr1, $duzenle_arr3);
        }
    }

    $kart_harcamalari = DB::all_data("
SELECT
kh.*,
c.cari_adi
FROM
kart_harcama as kh
INNER JOIN cari as c on c.id=kh.cari_id
WHERE kh.status=1 AND kh.cari_key='$cari_key' AND kh.kart_id='$kart_id' AND kh.tarih BETWEEN '$sorgu_bas 00:00:00' AND '$bit_tarih 23:59:59'");
    if ($kart_harcamalari > 0) {
        foreach ($kart_harcamalari as $alislar) {
            $duzenle_arr3 = [
                'tarih' => $alislar["tarih"],
                'cari_adi' => $alislar["cari_adi"],
                'belge_turu' => 'Kart Harcamalari',
                'aciklama' => $alislar["aciklama"],
                'vade_tarihi' => $alislar["tarih"],
                'borc' => 0,
                'alacak' => $alislar["tutar"],
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
        if ($dizaynli_bilgi["belge_turu"] == "Kart Ödemesi") {
            $borc = $dizaynli_bilgi["borc"];

            if ($b_durum == "B") {
                $kart_devir_bakiye += $borc;
            } else if ($b_durum == "A") {
                $kart_devir_bakiye -= $borc;
                if ($kart_devir_bakiye < 0) {
                    $kart_devir_bakiye = -$kart_devir_bakiye;
                    $b_durum = "B";
                } else if ($kart_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "B";
                $kart_devir_bakiye += $borc;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'cari_adi' => $dizaynli_bilgi["cari_adi"],
                'belge_turu' => "Kart Ödemesi",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $kart_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"]
            ];
            array_push($gidecek_array, $duzenle_arr2);

        }else if ($dizaynli_bilgi["belge_turu"] == "Kart Açılış Fişi Alacak") {
            $alacak = $dizaynli_bilgi["alacak"];

            if ($b_durum == "A") {
                $kart_devir_bakiye += $alacak;
            } else if ($b_durum == "B") {
                $kart_devir_bakiye -= $alacak;
                if ($kart_devir_bakiye < 0) {
                    $kart_devir_bakiye = -$kart_devir_bakiye;
                    $b_durum = "A";
                } else if ($kart_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $kart_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'cari_adi' => $dizaynli_bilgi["cari_adi"],
                'belge_turu' => "Kart Açılış Fişi Alacak",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $kart_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"]
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "Kart Harcamalari") {
            $alacak = $dizaynli_bilgi["alacak"];

            if ($b_durum == "A") {
                $kart_devir_bakiye += $alacak;
            } else if ($b_durum == "B") {
                $kart_devir_bakiye -= $alacak;
                if ($kart_devir_bakiye < 0) {
                    $kart_devir_bakiye = -$kart_devir_bakiye;
                    $b_durum = "A";
                } else if ($kart_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $kart_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'cari_adi' => $dizaynli_bilgi["cari_adi"],
                'belge_turu' => "Kart Harcamalari",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $kart_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"]
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "ARAÇ GİDER") {
            $alacak = $dizaynli_bilgi["alacak"];

            if ($b_durum == "A") {
                $kart_devir_bakiye += $alacak;
            } else if ($b_durum == "B") {
                $kart_devir_bakiye -= $alacak;
                if ($kart_devir_bakiye < 0) {
                    $kart_devir_bakiye = -$kart_devir_bakiye;
                    $b_durum = "A";
                } else if ($kart_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $kart_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'cari_adi' => $dizaynli_bilgi["cari_adi"],
                'belge_turu' => "ARAÇ GİDER",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $kart_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"]
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "SGK GİDER") {
            $alacak = $dizaynli_bilgi["alacak"];

            if ($b_durum == "A") {
                $kart_devir_bakiye += $alacak;
            } else if ($b_durum == "B") {
                $kart_devir_bakiye -= $alacak;
                if ($kart_devir_bakiye < 0) {
                    $kart_devir_bakiye = -$kart_devir_bakiye;
                    $b_durum = "A";
                } else if ($kart_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $kart_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'cari_adi' => $dizaynli_bilgi["cari_adi"],
                'belge_turu' => "SGK GİDER",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $kart_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"]
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "VERGİ GİDER") {
            $alacak = $dizaynli_bilgi["alacak"];

            if ($b_durum == "A") {
                $kart_devir_bakiye += $alacak;
            } else if ($b_durum == "B") {
                $kart_devir_bakiye -= $alacak;
                if ($kart_devir_bakiye < 0) {
                    $kart_devir_bakiye = -$kart_devir_bakiye;
                    $b_durum = "A";
                } else if ($kart_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $kart_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'cari_adi' => $dizaynli_bilgi["cari_adi"],
                'belge_turu' => "VERGİ GİDER",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $kart_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"]
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "YÖNETİM GİDERİ") {
            $alacak = $dizaynli_bilgi["alacak"];

            if ($b_durum == "A") {
                $kart_devir_bakiye += $alacak;
            } else if ($b_durum == "B") {
                $kart_devir_bakiye -= $alacak;
                if ($kart_devir_bakiye < 0) {
                    $kart_devir_bakiye = -$kart_devir_bakiye;
                    $b_durum = "A";
                } else if ($kart_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $kart_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'cari_adi' => $dizaynli_bilgi["cari_adi"],
                'belge_turu' => "YÖNETİM GİDERİ",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $kart_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"]
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "HGS GİDER") {
            $alacak = $dizaynli_bilgi["alacak"];

            if ($b_durum == "A") {
                $kart_devir_bakiye += $alacak;
            } else if ($b_durum == "B") {
                $kart_devir_bakiye -= $alacak;
                if ($kart_devir_bakiye < 0) {
                    $kart_devir_bakiye = -$kart_devir_bakiye;
                    $b_durum = "A";
                } else if ($kart_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $kart_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'cari_adi' => $dizaynli_bilgi["cari_adi"],
                'belge_turu' => "HGS GİDER",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $kart_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"]
            ];
            array_push($gidecek_array, $duzenle_arr2);

        }else if ($dizaynli_bilgi["belge_turu"] == "Binek HGS GİDER") {
            $alacak = $dizaynli_bilgi["alacak"];

            if ($b_durum == "A") {
                $kart_devir_bakiye += $alacak;
            } else if ($b_durum == "B") {
                $kart_devir_bakiye -= $alacak;
                if ($kart_devir_bakiye < 0) {
                    $kart_devir_bakiye = -$kart_devir_bakiye;
                    $b_durum = "A";
                } else if ($kart_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $kart_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'cari_adi' => $dizaynli_bilgi["cari_adi"],
                'belge_turu' => "Binek HGS GİDER",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $kart_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"]
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "KAZA CEZA GİDERLERİ") {
            $alacak = $dizaynli_bilgi["alacak"];

            if ($b_durum == "A") {
                $kart_devir_bakiye += $alacak;
            } else if ($b_durum == "B") {
                $kart_devir_bakiye -= $alacak;
                if ($kart_devir_bakiye < 0) {
                    $kart_devir_bakiye = -$kart_devir_bakiye;
                    $b_durum = "A";
                } else if ($kart_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $kart_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'cari_adi' => $dizaynli_bilgi["cari_adi"],
                'belge_turu' => "KAZA CEZA GİDERLERİ",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $kart_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"]
            ];
            array_push($gidecek_array, $duzenle_arr2);

        } else if ($dizaynli_bilgi["belge_turu"] == "BİNEK YAKIT ALIMI") {
            $alacak = $dizaynli_bilgi["alacak"];

            if ($b_durum == "A") {
                $kart_devir_bakiye += $alacak;
            } else if ($b_durum == "B") {
                $kart_devir_bakiye -= $alacak;
                if ($kart_devir_bakiye < 0) {
                    $kart_devir_bakiye = -$kart_devir_bakiye;
                    $b_durum = "A";
                } else if ($kart_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $kart_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'cari_adi' => $dizaynli_bilgi["cari_adi"],
                'belge_turu' => "BİNEK YAKIT ALIMI",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $kart_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"]
            ];
            array_push($gidecek_array, $duzenle_arr2);

        }else if ($dizaynli_bilgi["belge_turu"] == "BİNEK VERGİ ÖDEMESİ") {
            $alacak = $dizaynli_bilgi["alacak"];

            if ($b_durum == "A") {
                $kart_devir_bakiye += $alacak;
            } else if ($b_durum == "B") {
                $kart_devir_bakiye -= $alacak;
                if ($kart_devir_bakiye < 0) {
                    $kart_devir_bakiye = -$kart_devir_bakiye;
                    $b_durum = "A";
                } else if ($kart_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "A";
                $kart_devir_bakiye += $alacak;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'cari_adi' => $dizaynli_bilgi["cari_adi"],
                'belge_turu' => "BİNEK VERGİ ÖDEMESİ",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $kart_devir_bakiye,
                'b_durum' => $b_durum,
                'vade_tarihi' => $dizaynli_bilgi["vade_tarihi"]
            ];
            array_push($gidecek_array, $duzenle_arr2);

        }else if ($dizaynli_bilgi["belge_turu"] == "Kart Açılış Fişi Borç") {
            $borc = $dizaynli_bilgi["borc"];

            if ($b_durum == "B") {
                $kart_devir_bakiye += $borc;
            } else if ($b_durum == "A") {
                $kart_devir_bakiye -= $borc;
                if ($kart_devir_bakiye < 0) {
                    $kart_devir_bakiye = -$kart_devir_bakiye;
                    $b_durum = "B";
                } else if ($kart_devir_bakiye == 0) {
                    $b_durum = "YOK";
                }
            } else {
                $b_durum = "B";
                $kart_devir_bakiye += $borc;
            }

            $duzenle_arr2 = [
                'tarih' => $dizaynli_bilgi["tarih"],
                'cari_adi' => $dizaynli_bilgi["cari_adi"],
                'belge_turu' => "Kart Açılış Fişi Borç",
                'aciklama' => $dizaynli_bilgi["aciklama"],
                'borc' => $borc,
                'alacak' => $alacak,
                'bakiye' => $kart_devir_bakiye,
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