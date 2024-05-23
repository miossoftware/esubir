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
if ($islem == "yeni_banka_tanimla") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $banka_kodu = $_POST["banka_kodu"];
    $banka_varmi = DB::single_query("SELECT * FROM banka WHERE status=1 AND cari_key='$cari_key' AND banka_kodu='$banka_kodu'");
    if ($banka_varmi > 0) {
        echo 300;
    } else {
        $ana_grup_ekle = DB::insert("banka", $_POST);
        if ($ana_grup_ekle) {
            echo 2;
        } else {
            echo 1;
        }
    }
}
if ($islem == "banka_listesi_getir") {
    $last_bas_tarih = date("Y-m-d");
    $veriler = DB::all_data("SELECT * FROM banka WHERE status=1 and cari_key='$cari_key' $ek_sorgu");
    $gidecek_arr = [];
    foreach ($veriler as $veri) {
        $banka_devir_yatan = 0;
        $banka_devir_cekilen = 0;
        $banka_id = $veri["id"];

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
        $doviz_alim = DB::single_query("SELECT SUM(doviz_miktari) as doviz_miktari FROM banka_doviz_alim WHERE status=1 AND doviz_hesap='$banka_id' AND cari_key='$cari_key' AND tarih < '$last_bas_tarih 23:59:59'");
        $banka_devir_yatan += $doviz_alim["doviz_miktari"];

        // BURADAK DÜŞECEK OLAN TL HESABI İÇİN GEÇMİŞ SORGU YAPILIR
        $doviz_alim_tl = DB::single_query("SELECT SUM(tl_tutar) as tl_tutar FROM banka_doviz_alim WHERE status=1 AND tl_hesap='$banka_id' AND cari_key='$cari_key' AND tarih < '$last_bas_tarih 23:59:59'");
        $banka_devir_cekilen += $doviz_alim_tl["tl_tutar"];

        $alim_masrafi = DB::single_query("
    SELECT  SUM(masraf_tutari) as masraf_tutari FROM banka_doviz_alim 
WHERE CASE
    WHEN dusulecek_hesap = 'TL Hesabı' THEN tl_hesap = '$banka_id'
    ELSE doviz_hesap = '$banka_id'
END AND tarih < '$last_bas_tarih 23:59:59' AND status=1
");
        $banka_devir_cekilen += $alim_masrafi["masraf_tutari"];

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

        // DÖVİZ SATIM
        $doviz_alim = DB::single_query("SELECT SUM(doviz_miktari) as doviz_miktari FROM banka_doviz_satim WHERE status=1 AND doviz_hesap='$banka_id' AND cari_key='$cari_key' AND tarih < '$last_bas_tarih 23:59:59'");
        $banka_devir_cekilen += $doviz_alim["doviz_miktari"];

        $doviz_alim_tl = DB::single_query("SELECT SUM(tl_tutar) as tl_tutar FROM banka_doviz_satim WHERE status=1 AND tl_hesap='$banka_id' AND cari_key='$cari_key' AND tarih < '$last_bas_tarih 23:59:59'");
        $banka_devir_yatan += $doviz_alim_tl["tl_tutar"];

        $alim_masrafi = DB::single_query("
    SELECT  SUM(masraf_tutari) as masraf_tutari FROM banka_doviz_satim 
WHERE CASE
    WHEN dusulecek_hesap = 'TL Hesabı' THEN tl_hesap = '$banka_id'
    ELSE doviz_hesap = '$banka_id'
END AND tarih < '$last_bas_tarih 23:59:59' AND status=1
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
      byc.status!=0 AND byc.cari_key='$cari_key' AND byc.banka_id='$banka_id' AND byc.tarih  < '$last_bas_tarih 23:59:59'");
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
            'banka_kodu' => $veri["banka_kodu"],
            'banka_adi' => $veri["banka_adi"],
            'sube_kodu' => $veri["sube_kodu"],
            'sube_adi' => $veri["sube_adi"],
            'hesap_adi' => $veri["hesap_adi"],
            'yatan' => $banka_devir_yatan,
            'cekilen' => $banka_devir_cekilen,
            'doviz_tipi' => $veri["doviz_tipi"],
            'iban_no' => $veri["iban_no"],
            'hesap_no' => $veri["hesap_no"],
            'yetkili_mail' => $veri["yetkili_mail"],
            'yetkili_adi' => $veri["yetkili_adi"],
        ];
        array_push($gidecek_arr, $devir_arr);
    }
    if ($gidecek_arr > 0) {
        echo json_encode($gidecek_arr);
    } else {
        echo 2;
    }
}
if ($islem == "banka_sil") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $banka_kodu = $_POST["banka_kodu"];
    $cari_sil = DB::update("banka", "banka_kodu", $banka_kodu, $_POST);
    if ($cari_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "secili_banka_bilgileri") {
    $banka_kodu = $_GET["banka_kodu"];
    $banka_bilgileri = DB::single_query("SELECT * FROM banka WHERE status=1 AND banka_kodu='$banka_kodu' and cari_key='$cari_key' $ek_sorgu");
    if ($banka_bilgileri > 0) {
        echo json_encode($banka_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "banka_guncelle") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $banka_kodu = $_POST["banka_kodu"];
    $cari_sil = DB::update("banka", "banka_kodu", $banka_kodu, $_POST);
    if ($cari_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "bankalari_getir") {
    $bankalar = DB::all_data("SELECT id,banka_adi,hesap_adi FROM banka WHERE status=1 AND cari_key='$cari_key' $ek_sorgu");
    if ($bankalar > 0) {
        echo json_encode($bankalar);
    } else {
        echo 2;
    }
}
if ($islem == "banka_acilis_fisi_ekle_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $banka_acilis_fisi_ekle = DB::insert("banka_acilis_fisi", $_POST);
    if ($banka_acilis_fisi_ekle) {
        echo 2;
    } else {
        $son_eklenen = DB::single_query("SELECT id FROM banka_acilis_fisi where cari_key='$cari_key'  ORDER BY id DESC LIMIT 1");
        $son_id = $son_eklenen["id"];
        $banka_id = $_POST["banka_id"];
        $banka_bilgileri = DB::single_query("SELECT yatan,cekilen FROM banka WHERE status=1 AND id='$banka_id'");
        if ($banka_bilgileri > 0) {
            $yeni_yatan = floatval($banka_bilgileri["yatan"]) + floatval($_POST["yatan_tutar"]);
            $yeni_cekilen = floatval($banka_bilgileri["cekilen"]) + floatval($_POST["cekilen_tutar"]);
            $banka_arr = [
                'yatan' => $yeni_yatan,
                'cekilen' => $yeni_cekilen,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $banka_guncelle = DB::update("banka", "id", $banka_id, $banka_arr);
            if ($banka_guncelle) {
                $eklenen_banka_bilgileri = DB::single_query("
SELECT 
       kaf.yatan_tutar,kaf.cekilen_tutar,kaf.aciklama,k.banka_adi,k.banka_kodu,kaf.id
FROM 
     banka_acilis_fisi as kaf
INNER JOIN banka AS k on k.id=kaf.banka_id
WHERE 
      kaf.status=1 
  AND 
      kaf.id='$son_id'");
                if ($eklenen_banka_bilgileri > 0) {
                    echo json_encode($eklenen_banka_bilgileri);
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
        $acilis_bilgi = DB::single_query("SELECT yatan_tutar,cekilen_tutar,banka_id FROM banka_acilis_fisi WHERE status=1 AND id='$id'");
        if ($acilis_bilgi > 0) {
            $banka_id = $acilis_bilgi["banka_id"];
            $banka_bilgi = DB::single_query("SELECT yatan,cekilen FROM banka WHERE status=1 AND id='$banka_id'");
            if ($banka_bilgi > 0) {
                $yeni_giren = floatval($banka_bilgi["yatan"]) - floatval($acilis_bilgi["yatan_tutar"]);
                $yeni_cikan = floatval($banka_bilgi["cekilen"]) - floatval($acilis_bilgi["cekilen_tutar"]);
                $banka_arr = [
                    'yatan' => $yeni_giren,
                    'cekilen' => $yeni_cikan,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $banka_guncelle = DB::update("banka", "id", $banka_id, $banka_arr);
                if ($banka_guncelle) {
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
                    $acilis_guncelle = DB::update("banka_acilis_fisi", "id", $item, $arr);
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
if ($islem == "acilis_bilgileri_getir") {
    $id = $_GET["id"];
    $banka_aclis_bilgi = DB::single_query("SELECT * FROM banka_acilis_fisi WHERE status=1 AND id='$id'");
    if ($banka_aclis_bilgi > 0) {
        echo json_encode($banka_aclis_bilgi);
    } else {
        echo 2;
    }
}
if ($islem == "kayitli_banka_acilislari_getir") {
    $ek_baf = "";

    if ($_SESSION["sube_key"] != 0) {
        $ek_baf = " AND baf.sube_key='$sube_key'";
    }

    $acilislar = DB::all_data("
SELECT
       baf.*,b.banka_adi,b.banka_kodu
FROM banka_acilis_fisi as baf
INNER JOIN banka AS b on b.id=baf.banka_id
WHERE baf.status=1 AND baf.cari_key='$cari_key' $ek_baf");
    if ($acilislar > 0) {
        echo json_encode($acilislar);
    } else {
        echo 2;
    }
}
if ($islem == "havale_giris_bankalari_getir_sql") {
    $bankalari_getir = DB::all_data("SELECT id,banka_adi,hesap_no FROM banka WHERE status=1 AND cari_key='$cari_key' $ek_sorgu");
    if ($bankalari_getir > 0) {
        echo json_encode($bankalari_getir);
    } else {
        echo 2;
    }
}
if ($islem == "girilen_cari_kodu_bilgileri") {
    $cari_kodu = $_GET["cari_kodu"];
    $cari_bilgi = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' AND cari_kodu='$cari_kodu'");
    if ($cari_bilgi > 0) {
        echo json_encode($cari_bilgi);
    } else {
        echo 2;
    }
}
if ($islem == "havale_giris_ekle_sql") {
    $cari_id = 0;
    $uye_id = 0;
    $cari_kodu = $_POST["cari_kodu"];
    $caridemi = DB::single_query("SELECT id FROM cari WHERE status=1 AND cari_key='$cari_key' AND cari_kodu='$cari_kodu'");
    if ($caridemi > 0) {
        $cari_id = $caridemi["id"];
    } else {
        $uyemi = DB::single_query("SELECT id FROM uye_tanim WHERE status=1 AND cari_key='$cari_key' AND tc_no='$cari_kodu'");
        if ($uyemi > 0) {
            $uye_id = $uyemi["id"];
        }
    }

    if (isset($_POST["giris_id"])) {
        $giris_id = $_POST["giris_id"];
        $giris_bilgi = DB::single_query("SELECT giris_toplam,banka_id FROM havale_giris WHERE status=1 AND id='$giris_id'");
        if ($giris_bilgi > 0) {
            $toplam_giris = $giris_bilgi["giris_toplam"];
            $yeni_giris_toplam = floatval($toplam_giris) + floatval($_POST["giris_tutar"]);
            $arr = [
                'banka_id' => $_POST["banka_id"],
                'giris_toplam' => $yeni_giris_toplam,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $giris_guncelle = DB::update("havale_giris", "id", $giris_id, $arr);
            if ($giris_guncelle) {
                unset($_POST["banka_id"]);
                $cari_bilgileri = DB::single_query("SELECT borc,alacak FROM cari WHERE status=1 AND id='$cari_id'");
                $artan_miktar = 0;
                if ($cari_bilgileri["borc"] < $_POST["giris_tutar"]) {
                    $artan_miktar = floatval($_POST["giris_tutar"]) - floatval($cari_bilgileri["borc"]);
                }
                $urun_arr = [
                    'cari_id' => $cari_id,
                    'uye_id' => $uye_id,
                    'aciklama' => $_POST["aciklama"],
                    'giris_tutar' => $_POST["giris_tutar"],
                    'giris_id' => $giris_id,
                    'cari_key' => $_SESSION["cari_key"],
                    'sube_key' => $_SESSION["sube_key"],
                    'artan_miktar' => $artan_miktar,
                    'insert_userid' => $_SESSION["user_id"],
                    'insert_datetime' => date("Y-m-d H:i:s")
                ];
                $giris_urun_ekle = DB::insert("havale_giris_urunler", $urun_arr);
                if ($giris_urun_ekle) {
                    echo 2;
                } else {
                    $eklenen_verileri_cek = DB::all_data("
SELECT
       ktu.aciklama,ktu.giris_tutar,ut.tc_no,ut.uye_adi,c.cari_kodu,c.cari_adi,ktu.id,ktu.giris_id,ktu.cari_id
FROM 
     havale_giris_urunler as ktu 
LEFT JOIN cari as c on c.id=ktu.cari_id
LEFT JOIN uye_tanim as ut on ut.id=ktu.uye_id
INNER JOIN havale_giris as kt on kt.id=ktu.giris_id
WHERE ktu.status=1 AND ktu.cari_key='$cari_key' AND ktu.giris_id='$giris_id'
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
        $giris_olustur_arr = [
            'banka_id' => $_POST["banka_id"],
            'giris_toplam' => $_POST["giris_tutar"],
            'cari_key' => $_SESSION["cari_key"],
            'sube_key' => $_SESSION["sube_key"],
            'insert_userid' => $_SESSION["user_id"],
            'insert_datetime' => date("Y-m-d H:i:s")
        ];
        $giris_fisi_olustur = DB::insert("havale_giris", $giris_olustur_arr);
        if ($giris_fisi_olustur) {
            echo 2;
        } else {
            $son_giris = DB::single_query("SELECT id FROM havale_giris where cari_key='$cari_key'  ORDER BY id DESC LIMIT 1");
            if ($son_giris > 0) {
                $giris_id = $son_giris["id"];
                $_POST["giris_id"] = $giris_id;
                $giris_bilgi = DB::single_query("SELECT giris_toplam,banka_id FROM havale_giris WHERE status=1 AND id='$giris_id'");
                if ($giris_bilgi > 0) {
                    $toplam_giris = $giris_bilgi["giris_toplam"];
                    unset($_POST["banka_id"]);
                    $cari_bilgileri = DB::single_query("SELECT borc,alacak FROM cari WHERE status=1 AND id='$cari_id'");
                    $artan_miktar = 0;
                    if ($cari_bilgileri["borc"] < $_POST["giris_tutar"]) {
                        $artan_miktar = floatval($_POST["giris_tutar"]) - floatval($cari_bilgileri["borc"]);
                    }
                    $urun_arr = [
                        'cari_id' => $cari_id,
                        'uye_id' => $uye_id,
                        'aciklama' => $_POST["aciklama"],
                        'giris_tutar' => $_POST["giris_tutar"],
                        'giris_id' => $giris_id,
                        'cari_key' => $_SESSION["cari_key"],
                        'sube_key' => $_SESSION["sube_key"],
                        'artan_miktar' => $artan_miktar,
                        'insert_userid' => $_SESSION["user_id"],
                        'insert_datetime' => date("Y-m-d H:i:s")
                    ];
                    $giris_urun_ekle = DB::insert("havale_giris_urunler", $urun_arr);
                    if ($giris_urun_ekle) {
                        echo 2;
                    } else {
                        $eklenen_verileri_cek = DB::all_data("
SELECT
       ktu.aciklama,ktu.giris_tutar,ut.tc_no,ut.uye_adi,c.cari_kodu,c.cari_adi,ktu.id,ktu.giris_id,ktu.cari_id
FROM 
     havale_giris_urunler as ktu 
LEFT JOIN cari as c on c.id=ktu.cari_id
LEFT JOIN uye_tanim as ut on ut.id=ktu.uye_id
INNER JOIN havale_giris as kt on kt.id=ktu.giris_id
WHERE ktu.status=1 AND ktu.cari_key='$cari_key' AND ktu.giris_id='$giris_id'
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
if ($islem == "banka_giris_kaydi_sil_sql") {
    $id = $_POST["id"];
    $banka_giris_urun_bilgi = DB::single_query("SELECT giris_tutar,artan_miktar,cari_id,giris_id FROM havale_giris_urunler WHERE status=1 AND id='$id'");
    if ($banka_giris_urun_bilgi > 0) {
        $giris_tutar = $banka_giris_urun_bilgi["giris_tutar"];
        $cari_id = $banka_giris_urun_bilgi["cari_id"];
        $borca_eklenecek = $banka_giris_urun_bilgi["giris_tutar"];
        $alacaktan_silinecek = $banka_giris_urun_bilgi["artan_miktar"];
        $cari_borc_alacak_info = DB::single_query("SELECT borc,alacak FROM cari WHERE status=1 AND id='$cari_id'");
        $giris_arr = [
            'status' => 0,
            'delete_userid' => $_SESSION["user_id"],
            'delete_datetime' => date("Y-m-d H:i:s"),
            'delete_detail' => 'Kullanıcı Ürünü Kalemden Çıkartmıştır'
        ];
        $giris_guncelle = DB::update("havale_giris_urunler", "id", $id, $giris_arr);
        if ($giris_guncelle) {
            $giris_id = $banka_giris_urun_bilgi["giris_id"];
            $havale_giris_bilgi = DB::single_query("SELECT * FROM havale_giris WHERE status=1 AND id='$giris_id'");
            if ($havale_giris_bilgi > 0) {
                $genel_giris_tutar = floatval($havale_giris_bilgi["giris_toplam"]) - floatval($giris_tutar);

                $arr = [
                    'giris_toplam' => $genel_giris_tutar,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $havale_guncelle = DB::update("havale_giris", "id", $giris_id, $arr);
                if ($havale_guncelle) {
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
if ($islem == "giris_iptal_et_sql") {
    $giris_id = $_POST["id"];
    $tahsilat_urunleri = DB::all_data("SELECT * FROM havale_giris_urunler WHERE status=1 AND giris_id='$giris_id'");
    if (isset($_POST["delete_detail"])) {
        $tahsilat_arr = [
            'status' => 0,
            'delete_userid' => $_SESSION["user_id"],
            'delete_datetime' => date("Y-m-d H:i:s"),
            'delete_detail' => $_POST["delete_detail"]
        ];
        $giris_bilgiler = DB::single_query("SELECT * FROM havale_giris WHERE status=1 AND id='$giris_id'");
        $banka_id = $giris_bilgiler["banka_id"];
        $banka_bilgi = DB::single_query("SELECT yatan FROM banka WHERE status=1 AND id='$banka_id'");
        $yeni_cekis = floatval($banka_bilgi["yatan"]) - floatval($giris_bilgiler["giris_toplam"]);
        $arr2 = [
            'yatan' => $yeni_cekis,
            'update_userid' => $_SESSION["user_id"],
            'update_datetime' => date("Y-m-d H:i:s")
        ];
        $banka_guncelle = DB::update("banka", "id", $banka_id, $arr2);
    } else {
        $tahsilat_arr = [
            'status' => 0,
            'delete_userid' => $_SESSION["user_id"],
            'delete_datetime' => date("Y-m-d H:i:s"),
            'delete_detail' => 'Kullanıcı Tahsilattan Vazgeçmiştir'
        ];
    }

    $tahsilat_guncelle = DB::update("havale_giris", "id", $giris_id, $tahsilat_arr);
    if ($tahsilat_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "havale_giris_kaydet") {
    $id = $_POST["id"];
    $kasa_giris_toplami = DB::single_query("SELECT giris_toplam,banka_id FROM havale_giris WHERE status=1 AND id='$id'");
    if ($kasa_giris_toplami > 0) {
        $giris_toplam = $kasa_giris_toplami["giris_toplam"];
        $kasa_id = $kasa_giris_toplami["banka_id"];
        $kasa_bilgileri = DB::single_query("SELECT yatan,cekilen FROM banka WHERE status=1 AND id='$kasa_id'");
        if ($kasa_bilgileri > 0) {
            if (isset($_POST["ilk_ucret"])) {
                if ($kasa_giris_toplami["giris_toplam"] == $_POST["ilk_ucret"]) {
                    unset($_POST["ilk_ucret"]);
                    $kasa_giris_guncelle = DB::update("havale_giris", "id", $id, $_POST);
                    if ($kasa_giris_guncelle) {
                        echo 1;
                    } else {
                        echo 503;
                    }
                } else if ($_POST["ilk_ucret"] > $kasa_giris_toplami["giris_toplam"]) {
                    $fark = floatval($_POST["ilk_ucret"]) - floatval($kasa_giris_toplami["giris_toplam"]);
                    $guncel_miktar = floatval($kasa_bilgileri["cekilen"]) + $fark;
                    $arr = [
                        'cekilen' => $guncel_miktar,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];
                    $kasa_guncelle = DB::update("banka", "id", $kasa_id, $arr);
                    if ($kasa_guncelle) {
                        unset($_POST["ilk_ucret"]);
                        $kasa_giris_guncelle = DB::update("havale_giris", "id", $id, $_POST);
                        if ($kasa_giris_guncelle) {
                            echo 1;
                        } else {
                            echo 500;
                        }
                    } else {
                        echo 501;
                    }
                } else if ($_POST["ilk_ucret"] < $kasa_giris_toplami["giris_toplam"]) {
                    $fark = floatval($kasa_giris_toplami["giris_toplam"]) - floatval($_POST["ilk_ucret"]);
                    $guncel_miktar = floatval($kasa_bilgileri["yatan"]) + $fark;
                    $arr = [
                        'yatan' => $guncel_miktar,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];
                    $kasa_guncelle = DB::update("banka", "id", $kasa_id, $arr);
                    if ($kasa_guncelle) {
                        unset($_POST["ilk_ucret"]);
                        $kasa_giris_guncelle = DB::update("havale_giris", "id", $id, $_POST);
                        if ($kasa_giris_guncelle) {
                            echo 1;
                        } else {
                            echo 50;
                        }
                    } else {
                        echo 51;
                    }
                } else {
                    $kasa_giren = $kasa_bilgileri["yatan"];
                    $yeni_tutar = floatval($giris_toplam) + floatval($kasa_giren);
                    $arr = [
                        'yatan' => $yeni_tutar,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];
                    $kasa_guncelle = DB::update("banka", "id", $kasa_id, $arr);
                    if ($kasa_guncelle) {
                        unset($_POST["ilk_ucret"]);
                        $kasa_giris_guncelle = DB::update("havale_giris", "id", $id, $_POST);
                        if ($kasa_giris_guncelle) {
                            echo 1;
                        } else {
                            echo 503;
                        }
                    } else {
                        echo 504;
                    }
                }
            } else {
                $kasa_giren = $kasa_bilgileri["yatan"];
                $yeni_tutar = floatval($giris_toplam) + floatval($kasa_giren);
                $arr = [
                    'yatan' => $yeni_tutar,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $kasa_guncelle = DB::update("banka", "id", $kasa_id, $arr);
                if ($kasa_guncelle) {
                    $kasa_giris_guncelle = DB::update("havale_giris", "id", $id, $_POST);
                    if ($kasa_giris_guncelle) {
                        echo 1;
                    } else {
                        echo 506;
                    }
                } else {
                    echo 507;
                }
            }
        } else {
            echo 3;
        }
    } else {
        echo 508;
    }
}
if ($islem == "banka_havale_girisleri_getir_sql") {
    $ek1 = "";
    if ($_SESSION["sube_key"] != 0) {
        $ek1 = " AND hg.sube_key='$sube_key'";
    }
    $sql = "
SELECT 
       hg.islem_tarihi,hg.aciklama,hg.giris_toplam,b.banka_adi,b.banka_kodu,hg.belge_no,hg.id,b.doviz_tipi
FROM 
     havale_giris as hg
INNER JOIN banka as b on b.id=hg.banka_id
WHERE hg.status=1 AND hg.cari_key='$cari_key' $ek1";

    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        if ($bas_tarih != "" && $bit_tarih != "") {
            $sql .= " AND hg.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
        }
    }

    $havale_girisleri_getir = DB::all_data($sql);
    if ($havale_girisleri_getir > 0) {
        echo json_encode($havale_girisleri_getir);
    } else {
        echo 2;
    }
}
if ($islem == "giris_detay_ust_bilgi") {
    $ek2 = "";
    if ($_SESSION["sube_key"] != 0) {
        $ek2 = " AND hg.sube_key='$sube_key'";
    }
    $id = $_GET["id"];
    $ust_bilgiler = DB::single_query("
SELECT 
       hg.*,b.hesap_no
FROM 
     havale_giris as hg
INNER JOIN banka as b on b.id=hg.banka_id
WHERE hg.status=1 AND hg.cari_key='$cari_key' AND hg.id='$id' $ek2");
    if ($ust_bilgiler > 0) {
        echo json_encode($ust_bilgiler);
    } else {
        echo 2;
    }
}
if ($islem == "havale_giris_alt_bilgileri_getir_sql") {
    $giris_id = $_GET["giris_id"];
    $giris_bilgi = DB::all_data("
SELECT
       hgu.*,c.cari_adi,c.cari_kodu,ut.tc_no,ut.uye_adi
FROM 
     havale_giris_urunler as hgu
LEFT JOIN cari as c on c.id=hgu.cari_id
LEFT JOIN uye_tanim as ut on ut.id=hgu.uye_id
WHERE hgu.status=1 AND hgu.cari_key='$cari_key' AND hgu.giris_id='$giris_id'");
    if ($giris_bilgi > 0) {
        echo json_encode($giris_bilgi);
    } else {
        echo 2;
    }
}
if ($islem == "havale_cikis_ekle_sql") {
    $cari_id = $_POST["cari_id"];
    if (isset($_POST["cikis_id"])) {
        $cikis_id = $_POST["cikis_id"];
        $cikis_bilgi = DB::single_query("SELECT cikis_toplam,banka_id FROM havale_cikis WHERE status=1 AND id='$cikis_id'");
        if ($cikis_bilgi > 0) {
            $toplam_cikis = $cikis_bilgi["cikis_toplam"];
            $yeni_cikis_toplam = floatval($toplam_cikis) + floatval($_POST["cikis_tutar"]);
            $arr = [
                'banka_id' => $_POST["banka_id"],
                'cikis_toplam' => $yeni_cikis_toplam,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $cikis_guncelle = DB::update("havale_cikis", "id", $cikis_id, $arr);
            if ($cikis_guncelle) {
                unset($_POST["banka_id"]);
                $cari_bilgileri = DB::single_query("SELECT borc,alacak FROM cari WHERE status=1 AND id='$cari_id'");
                $artan_miktar = 0;
                if ($cari_bilgileri["alacak"] < $_POST["cikis_tutar"]) {
                    $artan_miktar = floatval($_POST["cikis_tutar"]) - floatval($cari_bilgileri["alacak"]);
                }
                $urun_arr = [
                    'cari_id' => $_POST["cari_id"],
                    'aciklama' => $_POST["aciklama"],
                    'cikis_tutar' => $_POST["cikis_tutar"],
                    'cikis_id' => $cikis_id,
                    'cari_key' => $_SESSION["cari_key"],
                    'sube_key' => $_SESSION["sube_key"],
                    'artan_miktar' => $artan_miktar,
                    'insert_userid' => $_SESSION["user_id"],
                    'insert_datetime' => date("Y-m-d H:i:s")
                ];
                $cikis_urun_ekle = DB::insert("havale_cikis_urunler", $urun_arr);
                if ($cikis_urun_ekle) {
                    echo 2;
                } else {
                    $cari_bilgileri = DB::single_query("SELECT borc,alacak FROM cari WHERE status=1 AND id='$cari_id'");
                    if ($cari_bilgileri > 0) {
                        if ($_POST["cikis_tutar"] > $cari_bilgileri["alacak"]) {
                            $eklenecek_alacak = floatval($_POST["cikis_tutar"]) - floatval($cari_bilgileri["alacak"]);
                            $yeni_alacak = $eklenecek_alacak + $cari_bilgileri["borc"];
                            $cari_arr = [
                                'alacak' => 0,
                                'borc' => $yeni_alacak,
                                'update_userid' => $_SESSION["user_id"],
                                'update_datetime' => date("Y-m-d H:i:s")
                            ];
                            $cari_bilgileri_guncelle = DB::update("cari", "id", $cari_id, $cari_arr);
                            if ($cari_bilgileri_guncelle) {
                                $eklenen_verileri_cek = DB::all_data("
SELECT
       ktu.aciklama,ktu.cikis_tutar,c.cari_kodu,c.cari_adi,ktu.id,ktu.cikis_id,ktu.cari_id
FROM 
     havale_cikis_urunler as ktu 
INNER JOIN cari as c on c.id=ktu.cari_id
INNER JOIN havale_cikis as kt on kt.id=ktu.cikis_id
WHERE ktu.status=1 AND ktu.cari_key='$cari_key' AND ktu.cikis_id='$cikis_id'
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
                            $yeni_borc = floatval($cari_bilgileri["alacak"]) - floatval($_POST["cikis_tutar"]);
                            $yeni_arr = [
                                'alacak' => $yeni_borc,
                                'update_userid' => $_SESSION["user_id"],
                                'update_datetime' => date("Y-m-d H:i:s")
                            ];
                            $cari_bilgi_guncele = DB::update("cari", "id", $cari_id, $yeni_arr);
                            if ($cari_bilgi_guncele) {
                                $eklenen_verileri_cek = DB::all_data("
SELECT
       ktu.aciklama,ktu.cikis_tutar,c.cari_kodu,c.cari_adi,ktu.id,ktu.cikis_id,ktu.cari_id
FROM 
     havale_cikis_urunler as ktu 
INNER JOIN cari as c on c.id=ktu.cari_id
INNER JOIN havale_cikis as kt on kt.id=ktu.cikis_id
WHERE ktu.status=1 AND ktu.cari_key='$cari_key' AND ktu.cikis_id='$cikis_id'
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
        $cikis_olustur_arr = [
            'banka_id' => $_POST["banka_id"],
            'cikis_toplam' => $_POST["cikis_tutar"],
            'cari_key' => $_SESSION["cari_key"],
            'sube_key' => $_SESSION["sube_key"],
            'insert_userid' => $_SESSION["user_id"],
            'insert_datetime' => date("Y-m-d H:i:s")
        ];
        $cikis_fisi_olustur = DB::insert("havale_cikis", $cikis_olustur_arr);
        if ($cikis_fisi_olustur) {
            echo 2;
        } else {
            $son_cikis = DB::single_query("SELECT id FROM havale_cikis where cari_key='$cari_key'  ORDER BY id DESC LIMIT 1");
            if ($son_cikis > 0) {
                $cikis_id = $son_cikis["id"];
                $_POST["cikis_id"] = $cikis_id;
                $cikis_bilgi = DB::single_query("SELECT cikis_toplam,banka_id FROM havale_cikis WHERE status=1 AND id='$cikis_id'");
                if ($cikis_bilgi > 0) {
                    $toplam_cikis = $cikis_bilgi["cikis_toplam"];
                    unset($_POST["banka_id"]);
                    $cari_bilgileri = DB::single_query("SELECT borc,alacak FROM cari WHERE status=1 AND id='$cari_id'");
                    $artan_miktar = 0;
                    if ($cari_bilgileri["alacak"] < $_POST["cikis_tutar"]) {
                        $artan_miktar = floatval($_POST["cikis_tutar"]) - floatval($cari_bilgileri["alacak"]);
                    }
                    $urun_arr = [
                        'cari_id' => $_POST["cari_id"],
                        'aciklama' => $_POST["aciklama"],
                        'cikis_tutar' => $_POST["cikis_tutar"],
                        'cikis_id' => $cikis_id,
                        'cari_key' => $_SESSION["cari_key"],
                        'sube_key' => $_SESSION["sube_key"],
                        'artan_miktar' => $artan_miktar,
                        'insert_userid' => $_SESSION["user_id"],
                        'insert_datetime' => date("Y-m-d H:i:s")
                    ];
                    $cikis_urun_ekle = DB::insert("havale_cikis_urunler", $urun_arr);
                    if ($cikis_urun_ekle) {
                        echo 2;
                    } else {
                        $cari_bilgileri = DB::single_query("SELECT borc,alacak FROM cari WHERE status=1 AND id='$cari_id'");
                        if ($cari_bilgileri > 0) {
                            if ($_POST["cikis_tutar"] > $cari_bilgileri["alacak"]) {
                                $eklenecek_alacak = floatval($_POST["cikis_tutar"]) - floatval($cari_bilgileri["alacak"]);
                                $yeni_alacak = $eklenecek_alacak + $cari_bilgileri["borc"];
                                $cari_arr = [
                                    'alacak' => 0,
                                    'borc' => $yeni_alacak,
                                    'update_userid' => $_SESSION["user_id"],
                                    'update_datetime' => date("Y-m-d H:i:s")
                                ];
                                $cari_bilgileri_guncelle = DB::update("cari", "id", $cari_id, $cari_arr);
                                if ($cari_bilgileri_guncelle) {
                                    $eklenen_verileri_cek = DB::all_data("
SELECT
       ktu.aciklama,ktu.cikis_tutar,c.cari_kodu,c.cari_adi,ktu.id,ktu.cikis_id,ktu.cari_id
FROM 
     havale_cikis_urunler as ktu 
INNER JOIN cari as c on c.id=ktu.cari_id
INNER JOIN havale_cikis as kt on kt.id=ktu.cikis_id
WHERE ktu.status=1 AND ktu.cari_key='$cari_key' AND ktu.cikis_id='$cikis_id'
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
                                $yeni_borc = floatval($cari_bilgileri["alacak"]) - floatval($_POST["cikis_tutar"]);
                                $yeni_arr = [
                                    'alacak' => $yeni_borc,
                                    'update_userid' => $_SESSION["user_id"],
                                    'update_datetime' => date("Y-m-d H:i:s")
                                ];
                                $cari_bilgi_guncele = DB::update("cari", "id", $cari_id, $yeni_arr);
                                if ($cari_bilgi_guncele) {
                                    $eklenen_verileri_cek = DB::all_data("
SELECT
       ktu.aciklama,ktu.cikis_tutar,c.cari_kodu,c.cari_adi,ktu.id,ktu.cikis_id,ktu.cari_id
FROM 
     havale_cikis_urunler as ktu 
INNER JOIN cari as c on c.id=ktu.cari_id
INNER JOIN havale_cikis as kt on kt.id=ktu.cikis_id
WHERE ktu.status=1 AND ktu.cari_key='$cari_key' AND ktu.cikis_id='$cikis_id'
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
if ($islem == "banka_cikis_kaydi_sil_sql") {
    $id = $_POST["id"];
    $havale_cikis_urun_bilgi = DB::single_query("SELECT cikis_tutar,artan_miktar,cari_id,cikis_id FROM havale_cikis_urunler WHERE status=1 AND id='$id'");
    if ($havale_cikis_urun_bilgi > 0) {
        $cikan_tutari = $havale_cikis_urun_bilgi["cikis_tutar"];
        $cari_id = $havale_cikis_urun_bilgi["cari_id"];
        $borca_eklenecek = $havale_cikis_urun_bilgi["cikis_tutar"];
        $alacaktan_silinecek = $havale_cikis_urun_bilgi["artan_miktar"];
        $cari_borc_alacak_info = DB::single_query("SELECT borc,alacak FROM cari WHERE status=1 AND id='$cari_id'");
        if ($cari_borc_alacak_info > 0) {
            $cikacak_cikis_tutar = floatval($havale_cikis_urun_bilgi["cikis_tutar"]) - floatval($havale_cikis_urun_bilgi["artan_miktar"]);
            $yeni_borc = floatval($cari_borc_alacak_info["alacak"]) + $cikacak_cikis_tutar;
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
            $odeme_guncelle = DB::update("havale_cikis_urunler", "id", $id, $odeme_arr);
            if ($odeme_guncelle) {
                $cari_guncelle = DB::update("cari", "id", $cari_id, $cari_arr);
                if ($cari_guncelle > 0) {
                    $cikis_id = $havale_cikis_urun_bilgi["cikis_id"];
                    $havale_cikis_bilgi = DB::single_query("SELECT * FROM havale_cikis WHERE status=1 AND id='$cikis_id'");
                    if ($havale_cikis_bilgi > 0) {
                        $genel_cikis_tutar = floatval($havale_cikis_bilgi["cikis_toplam"]) - floatval($cikan_tutari);

                        $arr = [
                            'cikis_toplam' => $genel_cikis_tutar,
                            'update_userid' => $_SESSION["user_id"],
                            'update_datetime' => date("Y-m-d H:i:s")
                        ];
                        $kasa_guncelle = DB::update("havale_cikis", "id", $cikis_id, $arr);
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
if ($islem == "cikis_iptal_et_sql") {
    $cikis_id = $_POST["id"];
    $tahsilat_urunleri = DB::all_data("SELECT * FROM havale_cikis_urunler WHERE status=1 AND cikis_id='$cikis_id'");
    if (isset($_POST["delete_detail"])) {
        $tahsilat_arr = [
            'status' => 0,
            'delete_userid' => $_SESSION["user_id"],
            'delete_datetime' => date("Y-m-d H:i:s"),
            'delete_detail' => $_POST["delete_detail"]
        ];
        $giris_bilgiler = DB::single_query("SELECT * FROM havale_cikis WHERE status=1 AND id='$cikis_id'");
        $banka_id = $giris_bilgiler["banka_id"];
        $banka_bilgi = DB::single_query("SELECT cekilen FROM banka WHERE status=1 AND id='$banka_id'");
        $yeni_cekis = floatval($banka_bilgi["cekilen"]) - floatval($giris_bilgiler["cikis_toplam"]);
        $arr2 = [
            'cekilen' => $yeni_cekis,
            'update_userid' => $_SESSION["user_id"],
            'update_datetime' => date("Y-m-d H:i:s")
        ];
        $banka_guncelle = DB::update("banka", "id", $banka_id, $arr2);
    } else {
        $tahsilat_arr = [
            'status' => 0,
            'delete_userid' => $_SESSION["user_id"],
            'delete_datetime' => date("Y-m-d H:i:s"),
            'delete_detail' => 'Kullanıcı Tahsilattan Vazgeçmiştir'
        ];
    }

    $tahsilat_guncelle = DB::update("havale_cikis", "id", $cikis_id, $tahsilat_arr);
    if ($tahsilat_urunleri > 0) {
        foreach ($tahsilat_urunleri as $urunler) {
            $id = $urunler["id"];
            $cikan_tutari = $urunler["cikis_tutar"];
            $cari_id = $urunler["cari_id"];
            $borca_eklenecek = $urunler["cikis_tutar"];
            $alacaktan_silinecek = $urunler["artan_miktar"];
            $cari_borc_alacak_info = DB::single_query("SELECT borc,alacak FROM cari WHERE status=1 AND id='$cari_id'");
            if ($cari_borc_alacak_info > 0) {
                $cikacak_cikis_tutar = floatval($urunler["cikis_tutar"]) - floatval($urunler["artan_miktar"]);
                $yeni_borc = floatval($cari_borc_alacak_info["alacak"]) + $cikacak_cikis_tutar;
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
                $odeme_guncelle = DB::update("havale_cikis_urunler", "id", $id, $odeme_arr);
                if ($odeme_guncelle) {
                    $cari_guncelle = DB::update("cari", "id", $cari_id, $cari_arr);
                    if ($cari_guncelle > 0) {
                        $cikis_id = $urunler["cikis_id"];
                        $havale_cikis_bilgi = DB::single_query("SELECT * FROM havale_cikis WHERE status=1 AND id='$cikis_id'");
                        if ($havale_cikis_bilgi > 0) {
                            $genel_cikis_tutar = floatval($havale_cikis_bilgi["cikis_toplam"]) - floatval($cikan_tutari);
                            $arr = [
                                'cikis_toplam' => $genel_cikis_tutar,
                                'update_userid' => $_SESSION["user_id"],
                                'update_datetime' => date("Y-m-d H:i:s")
                            ];
                            $kasa_guncelle = DB::update("havale_cikis", "id", $cikis_id, $arr);
                        }
                    }
                }
            }
        }

        if ($kasa_guncelle) {
            echo 1;
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "havale_cikis_kaydet") {
    $id = $_POST["id"];
    $kasa_cikis_toplami = DB::single_query("SELECT cikis_toplam,banka_id FROM havale_cikis WHERE status=1 AND id='$id'");
    if ($kasa_cikis_toplami > 0) {
        $cikis_toplam = $kasa_cikis_toplami["cikis_toplam"];
        $kasa_id = $kasa_cikis_toplami["banka_id"];
        $kasa_bilgileri = DB::single_query("SELECT cekilen,yatan FROM banka WHERE status=1 AND id='$kasa_id'");
        if ($kasa_bilgileri > 0) {
            if (isset($_POST["ilk_tutar"])) {
                if ($_POST["ilk_tutar"] == $kasa_cikis_toplami["cikis_toplam"]) {
                    unset($_POST["ilk_tutar"]);
                    $kasa_cikis_guncelle = DB::update("havale_cikis", "id", $id, $_POST);
                    if ($kasa_cikis_guncelle) {
                        echo 1;
                    } else {
                        echo 3;
                    }
                } else if ($_POST["ilk_tutar"] < $kasa_cikis_toplami["cikis_toplam"]) {
                    $fark = floatval($kasa_cikis_toplami["cikis_toplam"]) - floatval($_POST["ilk_tutar"]);
                    $yeni_cekilen = floatval($kasa_bilgileri["cekilen"]) + $fark;
                    $arr3 = [
                        'cekilen' => $yeni_cekilen,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];
                    $banka_guncelle = DB::update("banka", "id", $kasa_cikis_toplami["banka_id"], $arr3);
                    if ($banka_guncelle) {
                        if ($kasa_guncelle) {
                            unset($_POST["ilk_tutar"]);
                            $kasa_cikis_guncelle = DB::update("havale_cikis", "id", $id, $_POST);
                            if ($kasa_cikis_guncelle) {
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
                } else if ($_POST["ilk_tutar"] > $kasa_cikis_toplami["cikis_toplam"]) {
                    $fark = floatval($_POST["ilk_tutar"]) - floatval($kasa_cikis_toplami["cikis_toplam"]);
                    $yeni_tutar = floatval($kasa_bilgileri["yatan"]) + $fark;
                    $arr = [
                        'yatan' => $yeni_tutar,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];
                    $kasa_guncelle = DB::update("banka", "id", $kasa_id, $arr);
                    if ($kasa_guncelle) {
                        unset($_POST["ilk_tutar"]);
                        $kasa_cikis_guncelle = DB::update("havale_cikis", "id", $id, $_POST);
                        if ($kasa_cikis_guncelle) {
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
                $kasa_giren = $kasa_bilgileri["cekilen"];
                $yeni_tutar = floatval($cikis_toplam) + floatval($kasa_giren);
                $arr = [
                    'cekilen' => $yeni_tutar,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $kasa_guncelle = DB::update("banka", "id", $kasa_id, $arr);
                if ($kasa_guncelle) {
                    $kasa_cikis_guncelle = DB::update("havale_cikis", "id", $id, $_POST);
                    if ($kasa_cikis_guncelle) {
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
if ($islem == "havale_cikislari_getir") {
    $sube_sorgu = "";
    if ($_SESSION["sube_key"] != 0) {
        $sube_sorgu = " AND hc.sube_key='$sube_key'";
    }
    $sql = "
SELECT
       hc.*,b.banka_kodu,b.banka_adi,b.doviz_tipi,SUM(hcu.cikis_tutar) as toplam_tutar
FROM 
     havale_cikis as hc
INNER JOIN havale_cikis_urunler as hcu on hcu.cikis_id=hc.id
INNER JOIN banka as b on b.id=hc.banka_id
WHERE hc.status=1 AND hcu.status=1 AND hc.cari_key='$cari_key'";
    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        if ($bas_tarih != "" && $bit_tarih != "") {
            $sql .= " AND hc.islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
        }
    }
    $sql .= "GROUP BY hc.id";
    $havale_cikislar = DB::all_data($sql);
    if ($havale_cikislar > 0) {
        echo json_encode($havale_cikislar);
    } else {
        echo 2;
    }
}
if ($islem == "havale_cikis_ust_bilgiler") {
    $id = $_GET["id"];
    $ust_bilgi = DB::single_query("
SELECT
       hc.*,b.hesap_no
FROM
     havale_cikis as hc
INNER JOIN banka as b on b.id=hc.banka_id
WHERE hc.status=1 AND hc.id='$id' AND hc.cari_key='$cari_key'");
    if ($ust_bilgi > 0) {
        echo json_encode($ust_bilgi);
    } else {
        echo 2;
    }
}
if ($islem == "cikis_urunleri_getir_sql") {
    $id = $_GET["cikis_id"];
    $urunler = DB::all_data("
SELECT 
       hcu.*,c.cari_kodu,c.cari_adi
FROM 
     havale_cikis_urunler as hcu
INNER JOIN cari as c on c.id=hcu.cari_id
WHERE hcu.status=1 AND hcu.cari_key='$cari_key' AND hcu.cikis_id='$id'");
    if ($urunler > 0) {
        echo json_encode($urunler);
    } else {
        echo 2;
    }
}
if ($islem == "gonderen_banka_getir_sql") {
    $bankalari_getir = DB::all_data("SELECT id,banka_adi FROM banka WHERE status=1 AND cari_key='$cari_key' $ek_sorgu");
    if ($bankalari_getir > 0) {
        echo json_encode($bankalari_getir);
    } else {
        echo 2;
    }
}
if ($islem == "alabilecek_bankalari_getir_sql") {
    $id = $_GET["id"];
    $bankalari_getir = DB::all_data("SELECT id,banka_adi FROM banka WHERE status=1 and id!='$id' AND cari_key='$cari_key' $ek_sorgu");
    if ($bankalari_getir > 0) {
        echo json_encode($bankalari_getir);
    } else {
        echo 2;
    }
}
if ($islem == "banka_virman_ekle") {
    foreach ($_POST["arr"] as $bilgiler) {
        $bilgiler["insert_userid"] = $_SESSION["user_id"];
        $bilgiler["insert_datetime"] = date("Y-m-d H:i:s");
        $bilgiler["cari_key"] = $_SESSION["cari_key"];
        $bilgiler["sube_key"] = $_SESSION["sube_key"];
        $bilgileri_ekle = DB::insert("banka_virman", $bilgiler);
        if ($bilgileri_ekle) {

        } else {
            $alici_banka = $bilgiler["alici_bankaid"];
            $gonderen_banka = $bilgiler["gonderen_bankaid"];
            $alici_banka_bilgi = DB::single_query("SELECT id,yatan FROM banka WHERE status=1 AND id='$alici_banka'");
            $gonderen_banka_bilgi = DB::single_query("SELECT id,cekilen FROM banka WHERE status=1 AND id='$gonderen_banka'");
            $alici_yatan = floatval($alici_banka_bilgi["yatan"]) + floatval($bilgiler["gonderilen_miktar"]);
            $gonderici_cekilen = floatval($gonderen_banka_bilgi["cekilen"]) + floatval($bilgiler["gonderilen_miktar"]);
            $gonderilen_arr = [
                'cekilen' => $gonderici_cekilen,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $yatan_arr = [
                'yatan' => $alici_yatan,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $gonderen_banka_guncelle = DB::update("banka", "id", $gonderen_banka, $gonderilen_arr);
            $alan_banka_guncelle = DB::update("banka", "id", $alici_banka, $yatan_arr);
        }
    }
    if ($alan_banka_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "virmanlari_getir_sql") {

    $ek_virman = "";
    if ($_SESSION["sube_key"] != 0) {
        $ek_virman = " AND bv.sube_key='$sube_key'";
    }
    $sql = "
SELECT 
       bv.insert_datetime,bv.virman_tarihi,ab.banka_adi as alan_banka,gb.banka_adi as gonderen_banka,bv.gonderilen_miktar,bv.aciklama,bv.id
FROM 
     banka_virman as bv
INNER JOIN banka as gb on gb.id=bv.gonderen_bankaid
INNER JOIN banka as ab on ab.id=bv.alici_bankaid
WHERE bv.status=1 AND bv.cari_key='$cari_key' $ek_virman";
    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        if ($bas_tarih != "" && $bit_tarih != "") {
            $sql .= " AND bv.insert_datetime BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
        }
    }

    $verileri_getir = DB::all_data($sql);
    if ($verileri_getir > 0) {
        echo json_encode($verileri_getir);
    } else {
        echo 2;
    }
}
if ($islem == "virman_cikart") {
    $id = $_POST["id"];
    $virman_bilgiler = DB::single_query("SELECT * FROM banka_virman WHERE status=1 AND id='$id'");
    if ($virman_bilgiler > 0) {
        $gonderen_id = $virman_bilgiler["gonderen_bankaid"];
        $alan_bankaid = $virman_bilgiler["alici_bankaid"];
        $miktar = $virman_bilgiler["gonderilen_miktar"];
        $gonderen_banka_bilgi = DB::single_query("SELECT * FROM banka WHERE status=1 AND id='$gonderen_id'");
        if ($gonderen_banka_bilgi > 0) {
            $yeni_tutar = floatval($gonderen_banka_bilgi["yatan"]) + floatval($miktar);
            $yeni_arr = [
                'yatan' => $yeni_tutar,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $gonderen_guncelle = DB::update("banka", "id", $gonderen_banka_bilgi["id"], $yeni_arr);
            if ($gonderen_guncelle) {
                $alan_banka_bilgi = DB::single_query("SELECT * FROM banka WHERE status=1 AND id='$alan_bankaid'");
                if ($alan_banka_bilgi > 0) {
                    $yeni_miktar = floatval($alan_banka_bilgi["cekilen"]) + floatval($miktar);
                    $alan_arr = [
                        'cekilen' => $yeni_miktar,
                        'update_userid' => $_SESSION["user_id"],
                        'update_datetime' => date("Y-m-d H:i:s")
                    ];
                    $alan_banka_guncelle = DB::update("banka", "id", $alan_banka_bilgi["id"], $alan_arr);
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
                        $virman_guncelle = DB::update("banka_virman", "id", $id, $arr);
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
if ($islem == "bankalari_getir_sql") {
    $bankalar = DB::all_data("SELECT * FROM banka WHERE status=1 AND cari_key='$cari_key' $ek_sorgu");
    if ($bankalar > 0) {
        echo json_encode($bankalar);
    } else {
        echo 2;
    }
}
if ($islem == "banka_kodu_bilgileri_sql") {
    $banka_kodu = $_GET["banka_kodu"];
    $banka_bilgileri = DB::single_query("SELECT * FROM banka WHERE status=1 AND cari_key='$cari_key' AND sube_key='$sube_key' AND banka_kodu='$banka_kodu'");
    if ($banka_bilgileri > 0) {
        echo json_encode($banka_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "acilis_bilgilerini_getir_sql") {
    $id = $_GET["id"];
    $acilis_fisi = DB::single_query("SELECT * FROM banka_acilis_fisi WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    if ($acilis_fisi > 0) {
        echo json_encode($acilis_fisi);
    } else {
        echo 2;
    }
}
if ($islem == "acilis_fisi_guncelle_sql") {
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $_POST["update_userid"] = $_SESSION["user_id"];
    $banka_acilis_fisi_guncelle = DB::update("banka_acilis_fisi", "id", $_POST["id"], $_POST);
    if ($banka_acilis_fisi_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "virman_bilgilerini_getir_sql") {
    $id = $_GET["id"];
    $virman_bilgileri = DB::single_query("SELECT * FROM banka_virman WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    if ($virman_bilgileri > 0) {
        echo json_encode($virman_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "virman_guncelle_sql") {
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $_POST["update_userid"] = $_SESSION["user_id"];
    $virman_guncelle = DB::update("banka_virman", "id", $_POST["id"], $_POST);
    if ($virman_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "tl_hesaplari_getir_sql") {
    $tl_hesaplari = DB::all_data("SELECT * FROM banka WHERE status=1 AND cari_key='$cari_key' AND doviz_tipi='TL'");
    if ($tl_hesaplari > 0) {
        echo json_encode($tl_hesaplari);
    } else {
        echo 2;
    }
}
if ($islem == "bankaya_ait_doviz_hesaplari_sql") {
    $doviz_hesaplari = DB::all_data("SELECT * FROM banka WHERE status=1 AND cari_key='$cari_key' AND doviz_tipi!='TL'");
    if ($doviz_hesaplari > 0) {
        echo json_encode($doviz_hesaplari);
    } else {
        echo 2;
    }
}
if ($islem == "doviz_alim_kaydet_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $banka_doviz_alim_ekle = DB::insert("banka_doviz_alim", $_POST);
    if ($banka_doviz_alim_ekle) {
        echo 500;
    } else {
        echo 1;
    }
}
if ($islem == "doviz_alimlari_getir_sql") {
    $doviz_alimlar = DB::all_data("
SELECT
       bda.*,
       b.banka_adi as tl_hesap,
       b2.banka_adi as doviz_hesap,
       c.cari_adi
FROM
     banka_doviz_alim as bda
INNER JOIN banka as b on b.id=bda.tl_hesap
INNER JOIN banka as b2 on b2.id=bda.doviz_hesap
LEFT JOIN cari as c on c.id=bda.cari_id
WHERE
      bda.status=1 AND bda.cari_key='$cari_key'");
    if ($doviz_alimlar > 0) {
        $gidecek_arr = [];
        foreach ($doviz_alimlar as $item) {
            $tarih = date("d/m/Y", strtotime($item["tarih"]));
            $doviz_miktari = number_format($item["doviz_miktari"], 2);
            $tl_tutar = number_format($item["tl_tutar"], 2);
            $masraf_tutari = number_format($item["masraf_tutari"], 2);
            $arr = [
                'tarih' => $tarih,
                'doviz_hesabi' => $item["doviz_hesap"],
                'tl_hesabi' => $item["tl_hesap"],
                'doviz_miktari' => $doviz_miktari,
                'doviz_turu' => $item["doviz_turu"],
                'tl_tutari' => $tl_tutar,
                'cari_adi' => $item["cari_adi"],
                'masraf_tutari' => $masraf_tutari,
                'islem' => "<button class='btn btn-sm doviz_alim_guncelle_button' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm doviz_alim_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>",
                'id' => $item["id"]
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
if ($islem == "doviz_alim_sil_sql") {
    $_POST["status"] = 0;
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $update_edin = DB::update("banka_doviz_alim", "id", $_POST["id"], $_POST);
    if ($update_edin) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "doviz_hesaplari_getir_sql") {
    $doviz_hesaplari = DB::all_data("SELECT * FROM banka WHERE status=1 AND cari_key='$cari_key' AND doviz_tipi!='TL'");
    if ($doviz_hesaplari > 0) {
        echo json_encode($doviz_hesaplari);
    } else {
        echo 2;
    }
}
if ($islem == "bankaya_ait_tl_hesaplari_sql") {
    $banka_adi = DB::all_data("SELECT * FROM banka WHERE status=1 AND cari_key='$cari_key' AND doviz_tipi='TL'");
    if ($banka_adi > 0) {
        echo json_encode($banka_adi);
    } else {
        echo 2;
    }
}
if ($islem == "doviz_satim_kaydet_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $banka_doviz_alim_ekle = DB::insert("banka_doviz_satim", $_POST);
    if ($banka_doviz_alim_ekle) {
        echo 500;
    } else {
        echo 1;
    }
}
if ($islem == "doviz_satimlari_getir_sql") {
    $doviz_alimlar = DB::all_data("
SELECT
       bda.*,
       b.banka_adi as tl_hesap,
       b2.banka_adi as doviz_hesap,
       c.cari_adi
FROM
     banka_doviz_satim as bda
INNER JOIN banka as b on b.id=bda.tl_hesap
INNER JOIN banka as b2 on b2.id=bda.doviz_hesap
LEFT JOIN cari as c on c.id=bda.cari_id
WHERE
      bda.status=1 AND bda.cari_key='$cari_key'");
    if ($doviz_alimlar > 0) {
        $gidecek_arr = [];
        foreach ($doviz_alimlar as $item) {
            $tarih = date("d/m/Y", strtotime($item["tarih"]));
            $doviz_miktari = number_format($item["doviz_miktari"], 2);
            $tl_tutar = number_format($item["tl_tutar"], 2);
            $masraf_tutari = number_format($item["masraf_tutari"], 2);
            $arr = [
                'tarih' => $tarih,
                'doviz_hesabi' => $item["doviz_hesap"],
                'tl_hesabi' => $item["tl_hesap"],
                'doviz_miktari' => $doviz_miktari,
                'doviz_turu' => $item["doviz_turu"],
                'tl_tutari' => $tl_tutar,
                'cari_adi' => $item["cari_adi"],
                'masraf_tutari' => $masraf_tutari,
                'islem' => "<button class='btn btn-sm banka_satim_guncelle_button' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm doviz_satim_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>",
                'id' => $item["id"]
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
if ($islem == "doviz_satim_sil_sql") {
    $_POST["status"] = 0;
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $update_edin = DB::update("banka_doviz_satim", "id", $_POST["id"], $_POST);
    if ($update_edin) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "banka_satim_bilgileri_sql") {
    $id = $_GET["id"];
    $satim_bilgileri = DB::single_query("
SELECT
       bds.*,
       c.cari_adi
FROM 
     banka_doviz_satim as bds
LEFT JOIN cari as c on c.id=bds.cari_id
WHERE bds.status=1 AND bds.cari_key='$cari_key' AND bds.id='$id'");
    if ($satim_bilgileri > 0) {
        echo json_encode($satim_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "doviz_satim_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DB::update("banka_doviz_satim", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "banka_alim_bilgileri_sql") {
    $id = $_GET["id"];
    $satim_bilgileri = DB::single_query("
SELECT
       bds.*,
       c.cari_adi
FROM 
     banka_doviz_alim as bds
LEFT JOIN cari as c on c.id=bds.cari_id
WHERE bds.status=1 AND bds.cari_key='$cari_key' AND bds.id='$id'");
    if ($satim_bilgileri > 0) {
        echo json_encode($satim_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "doviz_alim_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DB::update("banka_doviz_alim", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}