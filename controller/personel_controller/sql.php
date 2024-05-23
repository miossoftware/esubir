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

if ($islem == "yeni_personel_ekle_sql") {
    $personel_kodu = $_POST["personel_kodu"];
    $single = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_kodu='$personel_kodu' AND cari_key='$cari_key'");
    if ($single > 0) {
        echo 300;
    } else {
        $cari_arr = [
            'insert_userid' => $_SESSION["user_id"],
            'insert_datetime' => date("Y-m-d H:i:s"),
            'cari_kodu' => $_POST["personel_kodu"],
            'cari_unvani' => $_POST["ad_soyad"],
            'cari_adi' => $_POST["ad_soyad"],
            'cep_telefonu' => $_POST["cep_tel"],
            'telefon' => $_POST["ev_tel"],
            'bilanco_id' => $_POST["bilanco_id"],
            'e_mail' => $_POST["e_mail"],
            'cari_key' => $_SESSION["cari_key"],
            'sube_key' => $_SESSION["sube_key"]
        ];
        $cari_olustur = DB::insert("cari", $cari_arr);
        if ($cari_olustur) {
            echo 2;
        } else {
            $son_cari = DB::single_query("SELECT id FROM cari where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
            $_POST["cari_id"] = $son_cari["id"];
            $adres_arr = [
                'insert_userid' => $_SESSION["user_id"],
                'insert_datetime' => date("Y-m-d H:i:s"),
                'il' => $_POST["il_id"],
                'cari_id' => $son_cari["id"],
                'ilce' => $_POST["ilce_id"],
                'ozel_kod1' => $_POST["ozel_kod1"],
                'ozel_kod2' => $_POST["ozel_kod2"],
            ];
            $adres_ekle = DB::insert("cari_adres_bilgileri", $adres_arr);
            $departman_id = 0;
            if (isset($_POST["departman_id"])) {
                $departman_id = $_POST["departman_id"];
            }
            $gorev_id = 0;
            if (isset($_POST["gorev_id"])) {
                $gorev_id = $_POST["gorev_id"];
            }
            $meslek_id = 0;
            if (isset($_POST["meslek_id"])) {
                $meslek_id = $_POST["meslek_id"];
            }
            $ilk_arr = [
                'insert_userid' => $_SESSION["user_id"],
                'insert_datetime' => date("Y-m-d H:i:s"),
                'personel_kodu' => $_POST["personel_kodu"],
                'ad_soyad' => $_POST["ad_soyad"],
                'departman_id' => $departman_id,
                'gorev_id' => $gorev_id,
                'meslek_id' => $meslek_id,
                'personel_tipi' => $_POST["personel_tipi"],
                'egitim_durumu' => $_POST["egitim_durumu"],
//                    'servis_id' => $_POST["servis_id"],
                'ev_tel' => $_POST["ev_tel"],
                'cep_tel' => $_POST["cep_tel"],
                'e_mail' => $_POST["e_mail"],
                'cari_id' => $_POST["cari_id"],
                'il_id' => $_POST["il_id"],
                'ilce_id' => $_POST["ilce_id"],
                'ozel_kod1' => $_POST["ozel_kod1"],
                'ozel_kod2' => $_POST["ozel_kod2"],
                'aciklama' => $_POST["aciklama"],
                'cari_key' => $_SESSION["cari_key"],
                'sube_key' => $_SESSION["sube_key"]
            ];
            $personel_olustur = DB::insert("personel_tanim", $ilk_arr);
            if ($personel_olustur) {
                echo 2;
            } else {
                $son_personel = DB::single_query("SELECT id FROM personel_tanim where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
                $personel_id = $son_personel["id"];
                $ikinci_arr = [
                    'insert_userid' => $_SESSION["user_id"],
                    'insert_datetime' => date("Y-m-d H:i:s"),
                    'tc_no' => $_POST["tc_no"],
                    'baba_adi' => $_POST["baba_adi"],
                    'personel_id' => $personel_id,
                    'medeni_hal' => $_POST["medeni_hal"],
                    'ilk_soyad' => $_POST["ilk_soyad"],
                    'dogum_tarihi' => $_POST["dogum_tarihi"],
                    'dogum_il' => $_POST["dogum_il"],
                    'dogum_ilce' => $_POST["dogum_ilce"],
                    'cinsiyet' => $_POST["cinsiyet"],
                    'seri_no' => $_POST["seri_no"],
                    'kan_grubu' => $_POST["kan_grubu"],
                    'mahalle_koy' => $_POST["mahalle_koy"],
                    'cari_key' => $_SESSION["cari_key"],
                    'sube_key' => $_SESSION["sube_key"]
                ];
                $tc_bilgileri_olustur = DB::insert("personel_tc_bilgi", $ikinci_arr);
                if ($tc_bilgileri_olustur) {
                    echo 2;
                } else {
                    $ucuncu_arr = [
                        'insert_userid' => $_SESSION["user_id"],
                        'insert_datetime' => date("Y-m-d H:i:s"),
                        'is_basi_tarih1' => $_POST["is_basi_tarih1"],
                        'ssk_bas_tarih' => $_POST["ssk_bas_tarih"],
                        'personel_id' => $personel_id,
                        'isten_ayrilma_tarih' => $_POST["isten_ayrilma_tarih"],
                        'isbasi_tekrar' => $_POST["isbasi_tekrar"],
                        'ssk_bas_tekrar' => $_POST["ssk_bas_tekrar"],
                        'net_maas' => $_POST["net_maas"],
                        'haftalik_ucret' => $_POST["haftalik_ucret"],
                        'gunluk_ucret' => $_POST["gunluk_ucret"],
                        'saat_ucreti' => $_POST["saat_ucreti"],
                        'cocuk_sayisi' => $_POST["cocuk_sayisi"],
                        'cari_key' => $_SESSION["cari_key"],
                        'sube_key' => $_SESSION["sube_key"]
                    ];
                    $personel_detay_bilgi_ekle = DB::insert("personel_detay_bilgi", $ucuncu_arr);
                    if ($personel_detay_bilgi_ekle) {
                        echo 2;
                    } else {
                        echo 1;
                    }
                }
            }
        }
    }
}
if ($islem == "cari_kodu_bilgileri_getir_sql") {
    $cari_kodu = $_GET["cari_kodu"];
    $cari_kodu_bilgi = DB::single_query("SELECT cari_kodu,id FROM cari WHERE status=1 AND cari_kodu='$cari_kodu' AND cari_key='$cari_key'");
    if ($cari_kodu_bilgi > 0) {
        echo json_encode($cari_kodu_bilgi);
    } else {
        echo 2;
    }
}
if ($islem == "il_getir") {
    $tum_iller = DB::all_data("SELECT * FROM il");
    if ($tum_iller > 0) {
        echo json_encode($tum_iller);
    } else {
        echo 2;
    }
}
if ($islem == "secilen_il_ilce_getir") {
    $il_id = $_GET["id"];
    $ilceleri_getir = DB::all_data("SELECT id,ilce_adi FROM ilce WHERE il_id='$il_id'");
    if ($ilceleri_getir > 0) {
        echo json_encode($ilceleri_getir);
    } else {
        echo 2;
    }
}
if ($islem == "bilancolari_getir") {
    $bilancolar = DB::all_data("SELECT * FROM bilancolar WHERE status=1 AND cari_key='$cari_key'");
    if ($bilancolar > 0) {
        echo json_encode($bilancolar);
    } else {
        echo 2;
    }
}
if ($islem == "personelleri_getir_sql") {
    $personeller = DB::all_data("
SELECT 
       pt.*,pdb.is_basi_tarih1 ,pgt.gorev_adi,pd.departman_adi,pm.meslek_adi,ptb.tc_no
FROM 
     personel_tanim as pt
LEFT JOIN personel_detay_bilgi pdb on pdb.personel_id=pt.id
LEFT JOIN personel_tc_bilgi as ptb on ptb.personel_id=pt.id
LEFT JOIN personel_gorev_tanim AS pgt on pgt.id=pt.gorev_id
LEFT JOIN personel_departman AS pd on pd.id=pt.departman_id
LEFT JOIN personel_meslek AS pm on pm.id=pt.meslek_id
WHERE pt.cari_key='$cari_key'
");
    if ($personeller > 0) {
        echo json_encode($personeller);
    } else {
        echo 2;
    }
}
if ($islem == "girilen_personel_bilgisi") {
    $personel_kodu = $_GET["personel_kodu"];
    $personeller = DB::single_query("
SELECT 
       pt.*
FROM 
     personel_tanim as pt
WHERE pt.status=1 AND pt.cari_key='$cari_key' AND pt.personel_kodu='$personel_kodu'");
    if ($personeller > 0) {
        echo json_encode($personeller);
    } else {
        echo 2;
    }
}
if ($islem == "personele_izin_ekle_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $personele_izin_ekle = DB::insert("personel_izin", $_POST);
    if ($personele_izin_ekle) {
        echo 2;
    } else {
        echo 1;
    }
}
if ($islem == "izinli_personeller_listesi") {
    $izinleri_getir = DB::all_data("SELECT * FROM personel_izin WHERE status=1 AND cari_key='$cari_key' AND sube_key='$sube_key'");
    if ($izinleri_getir > 0) {
        echo json_encode($izinleri_getir);
    } else {
        echo 2;
    }
}
if ($islem == "personel_izni_sil_sql") {
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["status"] = 0;
    $id = $_POST["id"];
    $sil = DB::update("personel_izin", "id", $id, $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "personel_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $id = $_POST["id"];
    $personel_sil = DB::update("personel_tanim", "id", $id, $_POST);
    if ($personel_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "personel_aktif_et_sql") {
    $_POST["status"] = 1;
    $id = $_POST["id"];
    $personel_sil = DB::update("personel_tanim", "id", $id, $_POST);
    if ($personel_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "personel_devamsizlik_ekle_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $personel_devamsizlik_ekle = DB::insert("personel_devamsizlik", $_POST);
    if ($personel_devamsizlik_ekle) {
        echo 2;
    } else {
        echo 1;
    }
}
if ($islem == "personel_devamsizliklari") {
    $tum_devamsizliklar = DB::all_data("
SELECT
       pd.*,pt.ad_soyad 
FROM 
     personel_devamsizlik as pd 
INNER JOIN personel_tanim as pt on pt.id=pd.personel_id
WHERE pd.status=1 AND pd.cari_key='$cari_key'");
    if ($tum_devamsizliklar > 0) {
        echo json_encode($tum_devamsizliklar);
    } else {
        echo 2;
    }
}
if ($islem == "personel_devamsizlik_sil_sql") {
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["status"] = 0;
    $id = $_POST["id"];
    $devamsizlik_sil = DB::update("personel_devamsizlik", "id", $id, $_POST);
    if ($devamsizlik_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "gorev_tanimla_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $gorev_tanimla = DB::insert("personel_gorev_tanim", $_POST);
    if ($gorev_tanimla) {
        echo 2;
    } else {
        echo 1;
    }
}
if ($islem == "gorevleri_getir_sql") {
    $gorevler = DB::all_data("SELECT * FROM personel_gorev_tanim WHERE status=1 AND cari_key='$cari_key'");
    if ($gorevler > 0) {
        echo json_encode($gorevler);
    } else {
        echo 2;
    }
}
if ($islem == "gorev_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $id = $_POST["id"];
    $sil = DB::update("personel_gorev_tanim", "id", $id, $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "departman_ekle_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $gorev_tanimla = DB::insert("personel_departman", $_POST);
    if ($gorev_tanimla) {
        echo 2;
    } else {
        echo 1;
    }
}
if ($islem == "departman_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $id = $_POST["id"];
    $sil = DB::update("personel_departman", "id", $id, $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "departmanlari_getir_sql") {
    $gorevler = DB::all_data("SELECT * FROM personel_departman WHERE status=1 AND cari_key='$cari_key'");
    if ($gorevler > 0) {
        echo json_encode($gorevler);
    } else {
        echo 2;
    }
}
if ($islem == "meslek_ekle_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $gorev_tanimla = DB::insert("personel_meslek", $_POST);
    if ($gorev_tanimla) {
        echo 2;
    } else {
        echo 1;
    }
}
if ($islem == "meslek_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $id = $_POST["id"];
    $sil = DB::update("personel_meslek", "id", $id, $_POST);
    if ($sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "meslekleri_getir_sql") {
    $gorevler = DB::all_data("SELECT * FROM personel_meslek WHERE status=1 AND cari_key='$cari_key'");
    if ($gorevler > 0) {
        echo json_encode($gorevler);
    } else {
        echo 2;
    }
}
if ($islem == "personel_bilgilerini_getir_sql") {
    $id = $_GET["id"];
    $personel_bilgileri = DB::single_query("
SELECT
       pt.*,ptb.tc_no,ptb.baba_adi,ptb.ana_adi,ptb.medeni_hal,ptb.dogum_tarihi,ptb.dogum_il,ptb.dogum_ilce,ptb.mahalle_koy,ptb.kan_grubu,ptb.cinsiyet,ptb.seri_no,pdb.is_basi_tarih1,pdb.ssk_bas_tarih,pdb.isten_ayrilma_tarih,pdb.isbasi_tekrar,pdb.ssk_bas_tekrar,pdb.net_maas,pdb.haftalik_ucret,pdb.gunluk_ucret,pdb.saat_ucreti,pdb.cocuk_sayisi,ptb.ilk_soyad,i.ilce_adi
FROM 
     personel_tanim as pt 
LEFT JOIN personel_tc_bilgi as ptb on ptb.personel_id=pt.id
LEFT JOIN personel_detay_bilgi as pdb on pdb.personel_id=pt.id
LEFT JOIN ilce as i on i.il_id=pt.il_id
WHERE pt.status=1 AND pt.cari_key='$cari_key' AND pt.id='$id' 
GROUP BY id");
    if ($personel_bilgileri > 0) {
        echo json_encode($personel_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "bilanco_kodu_ne_sql") {
    $cari_kodu = $_GET["cari_kodu"];
    $cari_bilanco = DB::single_query("SELECT bilanco_id FROM cari WHERE status=1 AND cari_kodu='$cari_kodu' AND cari_key='$cari_key'");
    if ($cari_bilanco > 0) {
        echo json_encode($cari_bilanco);
    } else {
        echo 2;
    }
}
if ($islem == "departman_getir_sql") {
    $departmanlar = DB::all_data("SELECT * FROM personel_departman WHERE status=1 AND cari_key='$cari_key'");
    if ($departmanlar > 0) {
        echo json_encode($departmanlar);
    } else {
        echo 2;
    }
}
if ($islem == "gorev_getir_sql") {
    $departmanlar = DB::all_data("SELECT * FROM personel_gorev_tanim WHERE status=1 AND cari_key='$cari_key'");
    if ($departmanlar > 0) {
        echo json_encode($departmanlar);
    } else {
        echo 2;
    }
}
if ($islem == "meslek_getir_sql") {
    $departmanlar = DB::all_data("SELECT * FROM personel_meslek WHERE status=1 AND cari_key='$cari_key'");
    if ($departmanlar > 0) {
        echo json_encode($departmanlar);
    } else {
        echo 2;
    }
}
if ($islem == "personel_guncelle_sql") {
    $personel_k = $_POST["personel_kodu"];
    $son_cari = DB::single_query("SELECT id FROM cari where cari_key='$cari_key' AND status=1 AND cari_kodu='$personel_k'");
    $cari_arr = [
        'update_userid' => $_SESSION["user_id"],
        'update_datetime' => date("Y-m-d H:i:s"),
        'cari_unvani' => $_POST["ad_soyad"],
        'cari_adi' => $_POST["ad_soyad"],
        'cep_telefonu' => $_POST["cep_tel"],
        'telefon' => $_POST["ev_tel"],
        'bilanco_id' => $_POST["bilanco_id"],
        'e_mail' => $_POST["e_mail"],
        'cari_key' => $_SESSION["cari_key"],
        'sube_key' => $_SESSION["sube_key"]
    ];
    $cari_olustur = DB::update("cari", "id", $son_cari["id"], $cari_arr);
    if ($cari_olustur) {
        $_POST["cari_id"] = $son_cari["id"];
        $adres_arr = [
            'update_userid' => $_SESSION["user_id"],
            'update_datetime' => date("Y-m-d H:i:s"),
            'il' => $_POST["il_id"],
            'cari_id' => $son_cari["id"],
            'ilce' => $_POST["ilce_id"],
            'ozel_kod1' => $_POST["ozel_kod1"],
            'ozel_kod2' => $_POST["ozel_kod2"],
        ];
        $adres_ekle = DB::update("cari_adres_bilgileri", "cari_id", $son_cari["id"], $adres_arr);
        $ilk_arr = [
            'update_userid' => $_SESSION["user_id"],
            'departman_id' => $_POST["departman_id"],
            'update_datetime' => date("Y-m-d H:i:s"),
            'personel_kodu' => $_POST["personel_kodu"],
            'ad_soyad' => $_POST["ad_soyad"],
            'gorev_id' => $_POST["gorev_id"],
            'meslek_id' => $_POST["meslek_id"],
            'personel_tipi' => $_POST["personel_tipi"],
            'egitim_durumu' => $_POST["egitim_durumu"],
//            'servis_id' => $_POST["servis_id"],
            'ev_tel' => $_POST["ev_tel"],
            'cep_tel' => $_POST["cep_tel"],
            'e_mail' => $_POST["e_mail"],
            'cari_id' => $_POST["cari_id"],
            'il_id' => $_POST["il_id"],
            'ilce_id' => $_POST["ilce_id"],
            'ozel_kod1' => $_POST["ozel_kod1"],
            'ozel_kod2' => $_POST["ozel_kod2"],
            'aciklama' => $_POST["aciklama"],
            'cari_key' => $_SESSION["cari_key"],
            'sube_key' => $_SESSION["sube_key"]
        ];
        $personel_olustur = DB::update("personel_tanim", "id", $_POST["id"], $ilk_arr);
        if ($personel_olustur) {
            $personel_id = $_POST["id"];
            $ikinci_arr = [
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s"),
                'tc_no' => $_POST["tc_no"],
                'baba_adi' => $_POST["baba_adi"],
                'personel_id' => $personel_id,
                'medeni_hal' => $_POST["medeni_hal"],
                'ilk_soyad' => $_POST["ilk_soyad"],
                'dogum_tarihi' => $_POST["dogum_tarihi"],
                'dogum_il' => $_POST["dogum_il"],
                'dogum_ilce' => $_POST["dogum_ilce"],
                'cinsiyet' => $_POST["cinsiyet"],
                'seri_no' => $_POST["seri_no"],
                'kan_grubu' => $_POST["kan_grubu"],
                'mahalle_koy' => $_POST["mahalle_koy"],
                'cari_key' => $_SESSION["cari_key"],
                'sube_key' => $_SESSION["sube_key"]
            ];
            $tc_bilgileri_olustur = DB::update("personel_tc_bilgi", "personel_id", $personel_id, $ikinci_arr);
            if ($tc_bilgileri_olustur) {

                $ucuncu_arr = [
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s"),
                    'is_basi_tarih1' => $_POST["is_basi_tarih1"],
                    'ssk_bas_tarih' => $_POST["ssk_bas_tarih"],
                    'personel_id' => $personel_id,
                    'isten_ayrilma_tarih' => $_POST["isten_ayrilma_tarih"],
                    'isbasi_tekrar' => $_POST["isbasi_tekrar"],
                    'ssk_bas_tekrar' => $_POST["ssk_bas_tekrar"],
                    'net_maas' => $_POST["net_maas"],
                    'haftalik_ucret' => $_POST["haftalik_ucret"],
                    'gunluk_ucret' => $_POST["gunluk_ucret"],
                    'saat_ucreti' => $_POST["saat_ucreti"],
                    'cocuk_sayisi' => $_POST["cocuk_sayisi"],
                    'cari_key' => $_SESSION["cari_key"],
                    'sube_key' => $_SESSION["sube_key"]
                ];
                $personel_detay_bilgi_ekle = DB::update("personel_detay_bilgi", "personel_id", $personel_id, $ucuncu_arr);
                if ($personel_detay_bilgi_ekle) {
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
if ($islem == "personel_maaslarini_getir") {
    $ay_basi = date('Y-m-01');
    $ay_sonu = date('Y-m-t');
    $islem_tarihi = $_POST["islem_tarihi"];
    $ayBasi = date("Y-m-01", strtotime($islem_tarihi));
    $aySonu = date("Y-m-t", strtotime($islem_tarihi));
    $arr = [];
    $tum_personeller = DB::all_data("
SELECT
       pt.*,pdb.is_basi_tarih1,pdb.net_maas,pdb.gunluk_ucret
FROM 
     personel_tanim as pt 
INNER JOIN personel_detay_bilgi as pdb on pdb.personel_id=pt.id
WHERE pt.status=1 AND pt.cari_key='$cari_key'");
    foreach ($tum_personeller as $item) {
        $personel_id = $item["id"];
        $firma_personelleri = DB::single_query("
SELECT
       pt.*,pd.maas_etkilensin,SUM(pd.devamsizlik_suresi) as devamsizlik_suresi,pd.devamsizlik_bas,pd.devamsizlik_bit,pd.status as personel_status
FROM personel_tanim as pt 
LEFT JOIN personel_devamsizlik as pd on pd.personel_id=pt.id
WHERE pt.status=1 AND pd.status=1 AND pt.cari_key='$cari_key' AND pd.personel_id='$personel_id' AND  pd.devamsizlik_bit BETWEEN '$ayBasi 00:00:00' AND '$aySonu 23:59:59' OR pd.devamsizlik_bas BETWEEN '$ayBasi 00:00:00' AND '$aySonu 23:59:59' GROUP BY pt.id");

        if ($item["is_basi_tarih1"] > $islem_tarihi) {

        } else {
            $firma_personelleri = DB::single_query("
SELECT
       pt.*,pd.maas_etkilensin,SUM(pd.devamsizlik_suresi) as devamsizlik_suresi,pd.devamsizlik_bas,pd.devamsizlik_bit,pd.status as personel_status
FROM personel_tanim as pt 
LEFT JOIN personel_devamsizlik as pd on pd.personel_id=pt.id
WHERE pt.status=1 AND pd.status=1 AND pt.cari_key='$cari_key' AND pd.personel_id='$personel_id' AND (pd.devamsizlik_bas BETWEEN '$ayBasi 00:00:00' AND '$aySonu 23:59:59' OR pd.devamsizlik_bit BETWEEN '$ayBasi 00:00:00' AND '$aySonu 23:59:59') GROUP BY pt.id");
            $tarih1 = new DateTime($islem_tarihi);
            $tarih1->modify('first day of this month');
            $ayBaslangici = $tarih1->format('Y-m-d');


            $ilk_tarih = $firma_personelleri["devamsizlik_bas"];
            if ($ayBasi >= $firma_personelleri["devamsizlik_bas"] && $ayBasi <= $firma_personelleri["devamsizlik_bit"]) {
                $ilk_tarih = $ayBasi;
            }
            $ikinci_tarih = $firma_personelleri["devamsizlik_bit"];

// Tarihleri DateTime nesnelerine dönüştürün
            $ilk_tarih_obj = new DateTime($ilk_tarih);
            $ikinci_tarih_obj = new DateTime($ikinci_tarih);

// Tarih farkını hesaplayın
            $fark = $ilk_tarih_obj->diff($ikinci_tarih_obj);

// Farkı gün cinsinden alın
            $fark_gun = $fark->days;
            $devamsizlik_suresi = 0;
            if (($firma_personelleri["devamsizlik_bas"] != null || $firma_personelleri["devamsizlik_bit"] != null) && $item["id"] == $firma_personelleri["id"]) {
                $devamsizlik_suresi = $fark_gun;
            }

            $arr2 = [
                'is_basi_tarih1' => $item["is_basi_tarih1"],
                'net_maas' => $item["net_maas"],
                'gunluk_ucret' => $item["gunluk_ucret"],
                'maas_etkilensin' => $firma_personelleri["maas_etkilensin"],
                'devamsizlik_bas' => $firma_personelleri["devamsizlik_bas"],
                'devamsizlik_bit' => $firma_personelleri["devamsizlik_bit"],
                'devamsizlik_suresi' => $devamsizlik_suresi,
                'personel_status' => $firma_personelleri["personel_status"],
                'personel_kodu' => $item["personel_kodu"],
                'ad_soyad' => $item["ad_soyad"]
            ];
            array_push($arr, $arr2);
        }
    }
    if ($arr > 0) {
        echo json_encode($arr);
    } else {
        echo 2;
    }
}
if ($islem == "personel_maas_ekle_sql") {
    $toplam = 0;

    foreach ($_POST["arr"] as $item2) {
        $toplam += $item2["tutar"];
    }
    $arr = [
        'olusturma_tarihi' => $_POST["arr"][0]["islem_tarihi"],
        'aciklama' => $_POST["arr"][0]["aciklama"],
        'toplam' => $toplam,
        'cari_key' => $cari_key,
        'sube_key' => $sube_key,
        'insert_userid' => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s")
    ];

    $personel_tahakkuk_main = DB::insert("personel_tahakkuk_ana", $arr);
    $son_cari = DB::single_query("SELECT id FROM personel_tahakkuk_ana where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
    if ($personel_tahakkuk_main) {
        echo 2;
    } else {
        foreach ($_POST["arr"] as $item) {
            $personel_kodu = $item["personel_kodu"];
            $personel_info = DB::single_query("SELECT id FROM personel_tanim WHERE status=1 AND personel_kodu='$personel_kodu'");
            $personel_id = $personel_info["id"];
            $cari_bilgi = DB::single_query("SELECT alacak,id FROM cari WHERE status=1 AND cari_key='$cari_key' AND cari_kodu='$personel_kodu'");
            $cari_id = $cari_bilgi["id"];
            $yeni_alacak = floatval($cari_bilgi["alacak"]) + floatval($item["tutar"]);
            $arr_cari = [
                'alacak' => $yeni_alacak,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $cari_guncel = DB::update("cari", "id", $cari_id, $arr_cari);

            $personel_arr = [
                'personel_id' => $personel_id,
                'aciklama' => $item["aciklama"],
                'tahakuk_id' => $son_cari["id"],
                'tutar' => $item["tutar"],
                'cari_key' => $_SESSION["cari_key"],
                'sube_key' => $_SESSION["sube_key"],
                'islem_tarihi' => $item["islem_tarihi"]
            ];
            $personele_tahakkuk_ekle = DB::insert("personel_tahakkuk", $personel_arr);
        }
        if ($personele_tahakkuk_ekle) {
            echo 2;
        } else {
            echo 1;
        }
    }
}
if ($islem == "tum_personel_maaslarini_getir_sql") {
    $maaslari_getir = DB::all_data("
SELECT
       *
FROM  personel_tahakkuk_ana 
WHERE status=1 AND cari_key='$cari_key'
");
    if ($maaslari_getir > 0) {
        echo json_encode($maaslari_getir);
    } else {
        echo 2;
    }
}
if ($islem == "tahakkuk_iptal_et_sql") {
    $id = $_POST["id"];
    $arr = [
        'status' => 0,
        'delete_userid' => $_SESSION["user_id"],
        'delete_datetime' => date("Y-m-d H:i:s"),
        'delete_detail' => $_POST["delete_detail"],
    ];
    $personel_tahakkuk_sil = DB::update("personel_tahakkuk_ana", "id", $id, $arr);
    if ($personel_tahakkuk_sil){
        echo 1;
    }else{
        echo 2;
    }
}
if ($islem == "tahakkuklari_getir_sql") {
    $tahakkuk_id = $_GET["id"];
    $tahakkuk_urunler = DB::all_data("
SELECT
       pt.*,
       pt2.ad_soyad,
       pt2.personel_kodu
FROM
     personel_tahakkuk as pt
INNER JOIN personel_tanim as pt2 on pt2.id=pt.personel_id
WHERE pt.status=1 AND pt.cari_key='$cari_key' AND pt.tahakuk_id='$tahakkuk_id'");
    if ($tahakkuk_urunler) {
        echo json_encode($tahakkuk_urunler);
    } else {
        echo 2;
    }
}
if ($islem == "ana_bilgiler") {
    $id = $_GET["id"];

    $bilgileri = DB::single_query("SELECT * FROM personel_tahakkuk_ana WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    if ($bilgileri > 0) {
        echo json_encode($bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "personel_maas_guncelle_sql") {
    $toplam = 0;
    foreach ($_POST["arr"] as $item) {
        $toplam += $item["tutar"];
        $personel_arr = [
            'aciklama' => $item["aciklama"],
            'tutar' => $item["tutar"],
            'cari_key' => $_SESSION["cari_key"],
            'sube_key' => $_SESSION["sube_key"],
            'update_userid' => $_SESSION["user_id"],
            'update_datetime' => date("Y-m-d H:i:s"),
            'islem_tarihi' => $item["islem_tarihi"]
        ];
        $personele_tahakkuk_ekle = DB::update("personel_tahakkuk", "id", $item["id"], $personel_arr);
    }
    if ($personele_tahakkuk_ekle) {
        $arr = [
            'toplam' => $toplam,
            'update_userid' => $_SESSION["user_id"],
            'update_datetime' => date("Y-m-d H:i:s"),
            'olusturma_tarihi' => $_POST["islem_tarihi"],
            'aciklama' => $_POST["aciklama"]
        ];
        $tahakkuk_guncelle = DB::update("personel_tahakkuk_ana", "id", $_POST["id"], $arr);
        if ($tahakkuk_guncelle) {
            echo 1;
        } else {
            echo 2;
        }
    }
}