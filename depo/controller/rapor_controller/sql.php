<?php
include '../DB.php';
include "../../../controller/DB.php";
date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=UTF-8');
session_start();
DBD::connect();
DB::connect();
$cari_key = $_SESSION["cari_key"];
$sube_key = $_SESSION["sube_key"];
$islem = $_GET["islem"];

if ($islem == "is_emri_raporalirini_getir_sql") {
    $is_emri_id = $_GET["is_emri_id"];
    $tipi = $_GET["tipi"];

    if ($tipi == "İTHALAT") {
        $item = DBD::single_query("
SELECT
       iem.*
FROM
     is_emri_main as iem
INNER JOIN is_emri_urunler as ieu on ieu.is_emri_id=iem.id
INNER JOIN konteyner_giris as kg on kg.is_emri_id=iem.id AND kg.bos_dolu='Dolu'
WHERE iem.status=1 AND iem.cari_key='$cari_key' AND ieu.status=1 AND kg.is_emri_id='$is_emri_id' GROUP BY kg.id
");

        $gidecek_arr = [];
        $no = 1;
        $cari_id = $item["cari_id"];
        $cari = DB::single_query("SELECT cari_adi FROM cari WHERE id='$cari_id'");
        $birim_id = $item["birim_id"];
        $birim = DB::single_query("select * from birim where id='$birim_id'");

        $konteyner_girisleri = DBD::all_data("
SELECT
       kg.*,
       kc.cikis_tarihi
FROM
     konteyner_giris as kg
INNER JOIN konteyner_cikis as kc on kc.konteyner_id=kg.id
WHERE kg.status!=0 AND kg.is_emri_id='$is_emri_id' AND kg.bos_dolu='Dolu'");

        foreach ($konteyner_girisleri as $girisler) {
            $id = $girisler["id"];

            $sahaya_serilen = DBD::single_query("SELECT * FROM sahaya_urun_ser WHERE k_girisid='$id' AND status!=0");
            $saha_id = $sahaya_serilen["id"];
            $urunleri_aktarma = DBD::single_query("SELECT * FROM urunleri_konteynere_aktar WHERE (urun_id='$saha_id' OR konteyner_urunid='$id') AND status!=0");
            $konteyner_id1 = $urunleri_aktarma["konteyner_id1"];
            $cikis = DBD::single_query("
SELECT
       kg.konteyner_no,
       kc.plaka_id,
       kc.cikis_tarihi
FROM
     konteyner_cikis as kc
INNER JOIN konteyner_giris as kg on kg.id=kc.konteyner_id
where kg.id='$konteyner_id1' AND kc.bos_dolu='Dolu' AND kc.status=1");

            $plaka = $cikis["plaka_id"];
            $arac = DB::single_query("SELECT * FROM arac_kartlari where id='$plaka'");

            $plaka_id = $girisler["plaka_id"];
            $arac2 = DB::single_query("SELECT * FROM arac_kartlari WHERE id='$plaka_id'");

            $arr = [
                'no' => $no,
                'cari_adi' => $cari["cari_adi"],
                'siparis_tarihi' => date("d/m/Y", strtotime($item["siparis_tarihi"])),
                'liman_alim_tarihi' => date("d/m/Y", strtotime($girisler["giris_tarihi"])),
                'liman_alan_plaka' => $arac2["plaka_no"],
                'konteyner_no' => $girisler["konteyner_no"],
                'acente' => $item["acente"],
                'epro_ref' => $item["referans_no"],
                'mal_cinsi' => $item["urun_adi"],
                'birim_adi' => $birim["birim_adi"],
                'miktar' => number_format($urunleri_aktarma["yuklenen_miktar1"], 2),
                'demoraj_tarihi' => date("d/m/Y", strtotime($item["demoraj_tarihi"])),
                'bos_teslim' => $item["kont_teslim_yeri"],
                'sevk_plaka' => $arac["plaka_no"],
                'ihr_kont_no' => $cikis["konteyner_no"],
                'bos_teslim_tarihi' => date("d/m/Y", strtotime($girisler["cikis_tarihi"])),
                'sevk_tarihi' => date("d/m/Y", strtotime($cikis["cikis_tarihi"])),
                'yuklenen_miktar' => number_format($urunleri_aktarma["yuklenen_miktar1"], 2),
            ];
            array_push($gidecek_arr, $arr);
            $no++;
        }

        $arac_girisleri = DBD::all_data("SELECT * FROM arac_giris WHERE is_emri_id='$is_emri_id'");
        foreach ($arac_girisleri as $araclar_giris) {
            $id = $araclar_giris["id"];

            $sahaya_serilen = DBD::single_query("SELECT * FROM sahaya_urun_ser WHERE k_girisid='$id'");
            $saha_id = $sahaya_serilen["id"];
            $urunleri_aktarma = DBD::single_query("SELECT * FROM urunleri_konteynere_aktar WHERE (urun_id='$saha_id' OR konteyner_urunid='$id')");
            $konteyner_id1 = $urunleri_aktarma["konteyner_id1"];
            $cikis = DBD::single_query("
SELECT
       kg.konteyner_no,
       kc.plaka_id
FROM
     konteyner_cikis as kc
INNER JOIN konteyner_giris as kg on kg.id=kc.konteyner_id
where kg.id='$konteyner_id1' AND kc.bos_dolu='Dolu'");

            $plaka = $cikis["plaka_id"];
            $arac = DB::single_query("SELECT * FROM arac_kartlari where id='$plaka'");

            $arr = [
                'no' => $no,
                'cari_adi' => $cari["cari_adi"],
                'siparis_tarihi' => date("d/m/Y", strtotime($item["siparis_tarihi"])),
                'liman_alim_tarihi' => date("d/m/Y", strtotime($araclar_giris["giris_tarihi"])),
                'konteyner_no' => $cikis["konteyner_no"],
                'acente' => $item["acente"],
                'epro_ref' => $item["epro_ref"],
                'mal_cinsi' => $item["urun_adi"],
                'birim_adi' => $birim["birim_adi"],
                'miktar' => number_format($urunleri_aktarma["yuklenen_miktar1"], 2),
                'demoraj_tarihi' => date("d/m/Y", strtotime($item["demoraj_tarihi"])),
                'bos_teslim' => $item["kont_teslim_yeri"],
                'bos_teslim_tarihi' => $item["kont_teslim_yeri"],
                'sevk_plaka' => $arac["plaka_no"],
                'ihr_kont_no' => ""
            ];
            array_push($gidecek_arr, $arr);
            $no++;
        }
        if ($item["tipi"] == "İHRACAT") {
            unset($gidecek_arr);
        }
        $gidecek_arr[0]["birim_adi"] = $birim["birim_adi"];
        if (!empty($gidecek_arr)) {
            echo json_encode($gidecek_arr);
        } else {
            echo 2;
        }
    } else {
        $item = DBD::single_query("
SELECT
       iem.*
FROM
     is_emri_main as iem
INNER JOIN is_emri_urunler as ieu on ieu.is_emri_id=iem.id
INNER JOIN konteyner_giris as kg on kg.is_emri_id=iem.id AND kg.bos_dolu='Boş'
WHERE iem.status=1 AND iem.cari_key='$cari_key' AND ieu.status=1 AND kg.is_emri_id='$is_emri_id' GROUP BY kg.id
");
        $calisma = $item["forklift_turu"];

        $gidecek_arr = [];
        $no = 1;
        $cari_id = $item["cari_id"];
        $cari = DB::single_query("SELECT cari_adi FROM cari WHERE id='$cari_id'");
        $birim_id = $item["birim_id"];
        $birim = DB::single_query("select * from birim where id='$birim_id'");

        $konteyner_girisleri = DBD::all_data("
SELECT
       kg.*,
       kc.cikis_tarihi
FROM
     konteyner_giris as kg
INNER JOIN konteyner_cikis as kc on kc.konteyner_id=kg.id
WHERE kg.status!=0 AND kg.is_emri_id='$is_emri_id' AND kg.bos_dolu='Boş'");

        foreach ($konteyner_girisleri as $girisler) {
            $id = $girisler["id"];
            $plaka_id = $girisler["plaka_id"];
            $arac2 = DB::single_query("SELECT * FROM arac_kartlari WHERE id='$plaka_id'");

            $urunleri_aktarma = DBD::single_query("SELECT * FROM urunleri_konteynere_aktar WHERE (konteyner_id1='$id' OR konteyner_id2='$id') AND status!=0");
            if ($urunleri_aktarma["konteyner_urunid"] == null || $urunleri_aktarma["konteyner_urunid"] == 0) {
                $urun_id = $urunleri_aktarma["urun_id"];
                $sahaya_serilen = DBD::single_query("SELECT * FROM sahaya_urun_ser WHERE id='$urun_id' AND status!=0");
                if ($sahaya_serilen > 0) {
                    $giris_id = $sahaya_serilen["giris_id"];
                    $giris_id = $urunleri_aktarma["urun_id"];
                    $arac_girisleri = DBD::single_query("SELECT * FROM arac_giris WHERE id='$giris_id' AND status!=0");

                    $konteyner_id1 = $urunleri_aktarma["konteyner_id1"];

                    $konteyner_giris = DBD::single_query("select konteyner_no,konteyner_no1 from konteyner_giris where id='$konteyner_id1'");

                    $konteyner_cikis = DBD::single_query("SELECT * FROM konteyner_cikis WHERE konteyner_id='$konteyner_id1'");
                    $cikan_plaka = $konteyner_cikis["plaka_id"];
                    $cikan_plaka_bilgileri = DB::single_query("SELECT plaka_no FROM arac_kartlari WHERE id='$cikan_plaka'");

                    $arr = [
                        'no' => $no,
                        'bos_giris_tarihi' => date("d/m/Y", strtotime($girisler["giris_tarihi"])),
                        'bos_giris_plaka' => $arac2["plaka_no"],
                        'dolu_giris_tarih' => date("d/m/Y", strtotime($arac_girisleri["giris_tarihi"])),
                        'dolu_giris_plaka' => $arac_girisleri["plaka_no"],
                        'dolan_konteyner' => $konteyner_giris["konteyner_no"],
                        'dolan_konteyner2' => $konteyner_giris["konteyner_no1"],
                        'konteyner_tipi' => $item["konteyner_tipi"],
                        'calisma' => $calisma,
                        'yukleme_tarihi' => date("d/m/Y", strtotime($urunleri_aktarma["tarih"])),
                        'dolu_cikis_plaka' => $cikan_plaka_bilgileri["plaka_no"],
                        'dolu_cikis_tarihi' => date("d/m/Y", strtotime($konteyner_cikis["cikis_tarihi"]))
                    ];
                    array_push($gidecek_arr, $arr);
                    $no++;
                } else {
                    $giris_id = $urunleri_aktarma["urun_id"];
                    $arac_girisleri = DBD::single_query("SELECT * FROM arac_giris WHERE id='$giris_id' AND status!=0");

                    $konteyner_id1 = $urunleri_aktarma["konteyner_id1"];

                    $konteyner_giris = DBD::single_query("select konteyner_no,konteyner_no1 from konteyner_giris where id='$konteyner_id1'");

                    $konteyner_cikis = DBD::single_query("SELECT * FROM konteyner_cikis WHERE konteyner_id='$konteyner_id1'");
                    $cikan_plaka = $konteyner_cikis["plaka_id"];
                    $cikan_plaka_bilgileri = DB::single_query("SELECT plaka_no FROM arac_kartlari WHERE id='$cikan_plaka'");

                    $arr = [
                        'no' => $no,
                        'bos_giris_tarihi' => date("d/m/Y", strtotime($girisler["giris_tarihi"])),
                        'bos_giris_plaka' => $arac2["plaka_no"],
                        'dolu_giris_tarih' => date("d/m/Y", strtotime($arac_girisleri["giris_tarihi"])),
                        'dolu_giris_plaka' => $arac_girisleri["plaka_no"],
                        'dolan_konteyner' => $konteyner_giris["konteyner_no"],
                        'dolan_konteyner2' => $konteyner_giris["konteyner_no1"],
                        'konteyner_tipi' => $item["konteyner_tipi"],
                        'calisma' => $calisma,
                        'yukleme_tarihi' => date("d/m/Y", strtotime($urunleri_aktarma["tarih"])),
                        'dolu_cikis_plaka' => $cikan_plaka_bilgileri["plaka_no"],
                        'dolu_cikis_tarihi' => date("d/m/Y", strtotime($konteyner_cikis["cikis_tarihi"]))
                    ];
                    array_push($gidecek_arr, $arr);
                    $no++;
                }
            } else {
            }
        }

        $gidecek_arr[0]["birim_adi"] = $birim["birim_adi"];

        $last_array = [];

        foreach ($gidecek_arr as $item) {
            if (!empty($last_array) && end($last_array)['dolan_konteyner'] == $item["dolan_konteyner"]) {
                $arr = [
                    'no' => $item["no"],
                    'bos_giris_tarihi' => $item["bos_giris_tarihi"],
                    'bos_giris_plaka' => $item["bos_giris_plaka"],
                    'dolu_giris_tarih' => $item["dolu_giris_tarih"],
                    'dolu_giris_plaka' => $item["dolu_giris_plaka"],
                    'dolan_konteyner' => $item["dolan_konteyner2"],
                    'konteyner_tipi' => $item["konteyner_tipi"],
                    'calisma' => $calisma,
                    'yukleme_tarihi' => $item["yukleme_tarihi"],
                    'dolu_cikis_plaka' => $item["dolu_cikis_plaka"],
                    'dolu_cikis_tarihi' => $item["dolu_cikis_tarihi"]
                ];
                array_push($last_array, $arr);
            } else {

                $arr = [
                    'no' => $item["no"],
                    'bos_giris_tarihi' => $item["bos_giris_tarihi"],
                    'bos_giris_plaka' => $item["bos_giris_plaka"],
                    'dolu_giris_tarih' => $item["dolu_giris_tarih"],
                    'dolu_giris_plaka' => $item["dolu_giris_plaka"],
                    'dolan_konteyner' => $item["dolan_konteyner"],
                    'konteyner_tipi' => $item["konteyner_tipi"],
                    'calisma' => $calisma,
                    'yukleme_tarihi' => $item["yukleme_tarihi"],
                    'dolu_cikis_plaka' => $item["dolu_cikis_plaka"],
                    'dolu_cikis_tarihi' => $item["dolu_cikis_tarihi"]
                ];
                array_push($last_array, $arr);
            }
        }

        if (!empty($last_array)) {
            echo json_encode($last_array);
        } else {
            echo 2;
        }
    }
}