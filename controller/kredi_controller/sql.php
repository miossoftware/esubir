<?php
include '../DB.php';
date_default_timezone_set('Europe/Istanbul');
session_start();
DB::connect();
$cari_key = $_SESSION["cari_key"];
$sube_key = $_SESSION["sube_key"];
$islem = $_GET["islem"];

if ($islem == "yeni_kredi_kullan_sql") {
    $gelecek_arr = $_POST["gidecek_arr"];
    unset($_POST["gidecek_arr"]);

    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;

    $kredi_kullanim_ekle = DB::insert("kredi_kullanim", $_POST);
    if ($kredi_kullanim_ekle) {
        echo 500;
    } else {
        $son_tahsilat = DB::single_query("SELECT id FROM kredi_kullanim where cari_key='$cari_key'  ORDER BY id DESC LIMIT 1");
        foreach ($gelecek_arr as $item) {
            $item["kredi_id"] = $son_tahsilat["id"];
            $item["cari_key"] = $cari_key;
            $item["sube_key"] = $sube_key;
            $kredi_kullanim_urunler = DB::insert("kredi_kullanim_urunler", $item);
        }
        if ($kredi_kullanim_urunler) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "son_kredi_kodu_sql") {
    $son_tahsilat = DB::single_query("SELECT kredi_kodu FROM kredi_kullanim where cari_key='$cari_key'  ORDER BY id DESC LIMIT 1");
    if ($son_tahsilat > 0) {
        $kredi_kodu = $son_tahsilat["kredi_kodu"];
        $rakamsalVeri = preg_replace("/[^0-9]/", "", $kredi_kodu);
        $rakamsalVeri++;
        $sayi = 0;
        if ($rakamsalVeri < 9) {
            $sayi = "00" . $rakamsalVeri;
        } else if ($rakamsalVeri > 99) {
            $sayi = "0" . $rakamsalVeri;
        }
        echo "KREDİ." . $sayi;
    } else {
        echo 2;
    }
}
if ($islem == "kullanilan_kredileri_getir_sql") {
    $tum_kredileri_getir = DB::all_data("
SELECT
    kk.*,
    SUM(kto.toplam_odeme) AS toplam_odenmis,
    b.banka_adi,
    c.cari_adi as masraf_cari_adi,
    (select COUNT(id) from kredi_kullanim_urunler as kku where kku.status=2 and kku.kredi_id=kk.id) as odenilen_taksit
FROM
    kredi_kullanim AS kk
INNER JOIN kredi_kullanim_urunler AS kku ON kku.kredi_id = kk.id
INNER JOIN banka AS b ON b.id = kk.banka_id
INNER JOIN cari as c on c.id=kk.cari_id
LEFT JOIN kredi_taksit_odeme as kto on kto.kredi_id=kku.id AND kto.status=1
WHERE kk.status=1 AND kk.cari_key='$cari_key'
GROUP BY
    kk.id, b.banka_adi");
    if ($tum_kredileri_getir > 0) {
        $gidecek_arr = [];
        $toplam_kredi = 0;
        $toplam_odenecek = 0;
        $toplam_kalan = 0;
        foreach ($tum_kredileri_getir as $item) {
            $id = $item["id"];

            $urun = DB::single_query("SELECT SUM(toplam_odeme) as odenmis_acilis FROM kredi_kullanim_urunler where kredi_id='$id' AND acilis_mi=2");

            $kullanim_tarihi = date("d/m/Y", strtotime($item["kullanim_tarihi"]));
            $ilk_odeme_tarihi = date("d/m/Y", strtotime($item["ilk_odeme_tarih"]));
            $kredi_tutari = number_format(floatval($item["kredi_tutari"]), 2, ',', '.');
            $toplam_geri_odeme = number_format(floatval($item["odenecek_toplam"]), 2, ',', '.');
            $toplam_odenmis = floatval($item["toplam_odenmis"] + floatval($urun["odenmis_acilis"]));
            if ($toplam_odenmis > $item["kredi_tutari"]) {
                $toplam_odenmis = $item["kredi_tutari"];
            }
            $toplam_odenmis = number_format($toplam_odenmis, 2, ',', '.');
            $faiz_orani = number_format(floatval($item["faiz_orani"]), 2, ',', '.');
            $toplam_odeme = floatval($urun["odenmis_acilis"]) + floatval($item["toplam_odenmis"]);
            $kalan_tutar = floatval($item["odenecek_toplam"]) - $toplam_odeme;
            if ($kalan_tutar < 0) {
                $kalan_tutar = 0;
            }
            $toplam_kalan += $kalan_tutar;
            $kalan_tutar = number_format($kalan_tutar, 2, ',', '.');
            
            $toplam_kredi += 1;
            $toplam_odenecek += $item["kredi_tutari"];

            $arr = [
                'taksitler' => "<button data-id='" . $item["id"] . "' class='btn btn-info btn-sm kredi_detaylari_button' style='border-radius: 50%;'><i class='fa fa-plus'></i></button>",
                'kullanim_tarihi' => $kullanim_tarihi,
                'kredi_kodu' => $item["kredi_kodu"],
                'banka_adi' => $item["banka_adi"],
                'kullanim_nedeni' => $item["kullanim_nedeni"],
                'faiz_orani' => $faiz_orani,
                'ilk_odeme_tarih' => $ilk_odeme_tarihi,
                'toplam_geri_odeme' => $toplam_geri_odeme,
                'masraf_cari_adi' => $item["masraf_cari_adi"],
                'odenmis_taksit' => $item["odenilen_taksit"],
                'kredi_tutari' => $kredi_tutari,
                'geri_odenmis_tutar' => $toplam_odenmis,
                'kalan_tutar' => $kalan_tutar,
                'aciklama' => $item["aciklama"],
                'id' => $item["id"],
                'button' => '<button class="btn btn-sm" style="background-color: #F6FA70"><i class="fa fa-refresh"></i></button> <button class="btn btn-danger btn-sm kullanilan_kredi_sil_main_button" data-id="' . $item["id"] . '"><i class="fa fa-trash"></i></button>'
            ];
            array_push($gidecek_arr, $arr);
        }
        if (!empty($gidecek_arr)) {
            $gidecek_arr[0]["toplam_kredi"] = $toplam_kredi;
            $toplam_odenecek = number_format($toplam_odenecek, 2);
            $toplam_kalan = number_format($toplam_kalan, 2);
            $gidecek_arr[0]["toplam_odenecek"] = $toplam_odenecek;
            $gidecek_arr[0]["toplam_kalan"] = $toplam_kalan;
            echo json_encode($gidecek_arr);
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "kullanilan_kredileri_getir_sql2") {
    $tum_kredileri_getir = DB::all_data("
SELECT
    kk.*,
    SUM(kto.toplam_odeme) AS toplam_odenmis,
    b.banka_adi,
    c.cari_adi as masraf_cari_adi
FROM
    kredi_kullanim AS kk
INNER JOIN kredi_kullanim_urunler AS kku ON kku.kredi_id = kk.id
INNER JOIN banka AS b ON b.id = kk.banka_id
INNER JOIN cari as c on c.id=kk.cari_id
LEFT JOIN kredi_taksit_odeme as kto on kto.kredi_id=kku.id AND kto.status=1
WHERE kk.status=1 AND kk.cari_key='$cari_key'
GROUP BY
    kk.id, b.banka_adi");
    if ($tum_kredileri_getir > 0) {
        $gidecek_arr = [];
        foreach ($tum_kredileri_getir as $item) {
            $kullanim_tarihi = date("d/m/Y", strtotime($item["kullanim_tarihi"]));
            $ilk_odeme_tarihi = date("d/m/Y", strtotime($item["ilk_odeme_tarih"]));
            $kredi_tutari = number_format(floatval($item["kredi_tutari"]), 2, ',', '.');
            $toplam_geri_odeme = number_format(floatval($item["odenecek_toplam"]), 2, ',', '.');
            $toplam_odenmis = number_format(floatval($item["toplam_odenmis"] + floatval($item["odenmis_acilis"])), 2, ',', '.');
            $faiz_orani = number_format(floatval($item["faiz_orani"]), 2, ',', '.');
            $toplam_odeme = floatval($item["odenmis_acilis"]) + floatval($item["toplam_odenmis"]);
            $kalan_tutar = floatval($item["odenecek_toplam"]) - $toplam_odeme;

            if ($kalan_tutar < 0) {
                $kalan_tutar = 0;
            }
            $kalan_tutar = number_format($kalan_tutar, 2, ',', '.');

            $arr = [
                'kullanim_tarihi' => $kullanim_tarihi,
                'kredi_kodu' => $item["kredi_kodu"],
                'banka_adi' => $item["banka_adi"],
                'kullanim_nedeni' => $item["kullanim_nedeni"],
                'faiz_orani' => $faiz_orani,
                'ilk_odeme_tarih' => $ilk_odeme_tarihi,
                'toplam_geri_odeme' => $toplam_geri_odeme,
                'masraf_cari_adi' => $item["masraf_cari_adi"],
                'kredi_tutari' => $kredi_tutari,
                'geri_odenmis_tutar' => $toplam_odenmis,
                'kalan_tutar' => $kalan_tutar,
                'aciklama' => $item["aciklama"],
                'id' => $item["id"],
                'button' => '<button class="btn btn-sm" style="background-color: #F6FA70"><i class="fa fa-refresh"></i></button> <button class="btn btn-danger btn-sm kullanilan_kredi_sil_main_button" data-id="' . $item["id"] . '"><i class="fa fa-trash"></i></button>'
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
if ($islem == "acilis_kredilerini_getir_sql") {
    $tum_kredileri_getir = DB::all_data("
SELECT
    kk.*,
    SUM(kto.toplam_odeme) AS toplam_odenmis,
    b.banka_adi,
    c.cari_adi as masraf_cari_adi
FROM
    kredi_kullanim AS kk
INNER JOIN kredi_kullanim_urunler AS kku ON kku.kredi_id = kk.id
INNER JOIN banka AS b ON b.id = kk.banka_id
INNER JOIN cari as c on c.id=kk.cari_id
LEFT JOIN kredi_taksit_odeme as kto on kto.kredi_id=kku.id AND kto.status=1
WHERE kk.status=1 AND kk.cari_key='$cari_key'
GROUP BY
    kk.id, b.banka_adi");
    if ($tum_kredileri_getir > 0) {
        $gidecek_arr = [];
        foreach ($tum_kredileri_getir as $item) {
            $id = $item["id"];
            $urun = DB::single_query("SELECT SUM(toplam_odeme) as odenmis_acilis FROM kredi_kullanim_urunler where kredi_id='$id' AND acilis_mi=2");

            $kullanim_tarihi = date("d/m/Y", strtotime($item["kullanim_tarihi"]));
            $ilk_odeme_tarihi = date("d/m/Y", strtotime($item["ilk_odeme_tarih"]));
            $kredi_tutari = number_format(floatval($item["kredi_tutari"]), 2, ',', '.');
            $toplam_geri_odeme = number_format(floatval($item["odenecek_toplam"]), 2, ',', '.');
            $toplam_odenmis = number_format(floatval($item["toplam_odenmis"] + floatval($urun["odenmis_acilis"])), 2, ',', '.');
            $faiz_orani = number_format(floatval($item["faiz_orani"]), 2, ',', '.');
            $toplam_odeme = floatval($urun["odenmis_acilis"]) + floatval($item["toplam_odenmis"]);
            $kalan_tutar = floatval($item["odenecek_toplam"]) - $toplam_odeme;
            $kalan_tutar = number_format($kalan_tutar, 2, ',', '.');
            if ($item["acilis_tarihi"] != "0000-00-00 00:00:00") {
                $arr = [
                    'kullanim_tarihi' => $kullanim_tarihi,
                    'kredi_kodu' => $item["kredi_kodu"],
                    'banka_adi' => $item["banka_adi"],
                    'kullanim_nedeni' => $item["kullanim_nedeni"],
                    'faiz_orani' => $faiz_orani,
                    'ilk_odeme_tarih' => $ilk_odeme_tarihi,
                    'toplam_geri_odeme' => $toplam_geri_odeme,
                    'masraf_cari_adi' => $item["masraf_cari_adi"],
                    'kredi_tutari' => $kredi_tutari,
                    'geri_odenmis_tutar' => $toplam_odenmis,
                    'kalan_tutar' => $kalan_tutar,
                    'aciklama' => $item["aciklama"],
                    'id' => $item["id"],
                    'button' => '<button class="btn btn-sm" style="background-color: #F6FA70"><i class="fa fa-refresh"></i></button> <button class="btn btn-danger btn-sm kullanilan_kredi_sil_main_button" data-id="' . $item["id"] . '"><i class="fa fa-trash"></i></button>'
                ];
                array_push($gidecek_arr, $arr);
            }
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
if ($islem == "kullanilan_kredi_sil_sql") {
    $id = $_POST["id"];
    $tum_kredileri_getir = DB::single_query("
SELECT * FROM kredi_kullanim_urunler WHERE status=2 AND kredi_id='$id'");
    if ($tum_kredileri_getir > 0) {
        echo 300;
    } else {
        $_POST["delete_userid"] = $_SESSION["user_id"];
        $_POST["delete_datetime"] = date("Y-m-d H:i:s");
        $_POST["status"] = 0;
        $krediyi_sil_sql = DB::update("kredi_kullanim", "id", $id, $_POST);
        if ($krediyi_sil_sql) {
            echo 1;
        } else {
            echo 2;
        }
    }
}
if ($islem == "kredi_kodu_bilgileri_getir_sql") {
    $kredi_kodu = $_GET["kredi_kodu"];

    $urunler = DB::all_data("
SELECT
       kku.*,
       c.cari_adi as masraf_carisi,
       kk.kredi_kodu
FROM
     kredi_kullanim_urunler as kku
INNER JOIN kredi_kullanim as kk on kk.id=kku.kredi_id
INNER JOIN cari as c on c.id=kk.cari_id
WHERE kku.status=1 AND kku.cari_key='$cari_key' AND kk.kredi_kodu='$kredi_kodu' AND kku.acilis_mi!=2 ORDER BY kku.taksit ASC");

    $gidecek_arr = [];
    if ($urunler > 0) {
        foreach ($urunler as $item) {
            $vade_tarihi = date("d/m/Y", strtotime($item["vade_tarih"]));
            $ana_para = number_format(floatval($item["ana_para"]), 2, ',', '.');
            $faiz_tutari = number_format(floatval($item["faiz_tutari"]), 2, ',', '.');
            $toplam_odeme = number_format(floatval($item["toplam_odeme"]), 2, ',', '.');

            $arr = [
                'sec' => "<input type='checkbox' data-id='" . $item["id"] . "'/>",
                'taksit' => $item["taksit"],
                'vade_tarihi' => $vade_tarihi,
                'masraf_carisi' => $item["masraf_carisi"],
                'ana_para' => $ana_para,
                'id' => $item["kredi_id"],
                'kredi_kodu' => $item["kredi_kodu"],
                'faiz_tutari' => $faiz_tutari,
                'toplam_odeme' => "<input type='text' style='text-align:right' class='form-control form-control-sm col-9 toplam_odenecekler_input' value='" . $toplam_odeme . "'/>"
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
if ($islem == "odemeyi_al_sql") {

    foreach ($_POST["secilenler"] as $item) {
        $item["cari_key"] = $cari_key;
        $item["sube_key"] = $sube_key;
        $item["insert_userid"] = $_SESSION["user_id"];
        $item["insert_datetime"] = date("Y-m-d H:i:s");
        $kredi_taksit_ode = DB::insert("kredi_taksit_odeme", $item);

        $arr = [
            'status' => 2
        ];
        $kredi_urunu = DB::update("kredi_kullanim_urunler", "id", $item["kredi_id"], $arr);
    }
    if ($kredi_urunu) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "odenmis_taksitlerini_getir_sql") {
    $odenmis_taksitler = DB::all_data("
SELECT
       kto.*,
       kk.kredi_kodu,
       kk.kullanim_tarihi
FROM
     kredi_taksit_odeme as kto
INNER JOIN kredi_kullanim_urunler AS kku on kku.id=kto.kredi_id
INNER JOIN kredi_kullanim as kk on kk.id=kku.kredi_id
WHERE kto.status=1 AND kto.cari_key='$cari_key'");
    if ($odenmis_taksitler > 0) {
        $donecek_arr = [];
        foreach ($odenmis_taksitler as $item) {
            $odeme_tarihi = date("d/m/Y", strtotime($item["odeme_tarihi"]));
            $kullanim_tarihi = date("d/m/Y", strtotime($item["kullanim_tarihi"]));
            $ana_para = number_format(floatval($item["toplam_odeme"]), 2, ',', '.');
            $arr = [
                'kredi_kodu' => $item["kredi_kodu"],
                'kullanim_tarihi' => $kullanim_tarihi,
                'odeme_tarih' => $odeme_tarihi,
                'odeme_tutari' => $ana_para,
                'odeme_aciklamasi' => $item["aciklama"],
                'button' => "<button class='btn btn-sm' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm kredi_odemesini_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
            ];
            array_push($donecek_arr, $arr);
        }
        if ($donecek_arr > 0) {
            echo json_encode($donecek_arr);
        } else {
            echo 2;
        }
    }
}
if ($islem == "odenen_kredi_taksiti_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $id = $_POST["id"];
    $bilgiler = DB::single_query("SELECT kredi_id FROM kredi_taksit_odeme WHERE status=1 AND id='$id'");
    $guncelle = DB::update("kredi_taksit_odeme", "id", $id, $_POST);
    if ($guncelle) {
        $arr = [
            'status' => 1
        ];
        $tekrar_ac = DB::update("kredi_kullanim_urunler", "id", $bilgiler["kredi_id"], $arr);
        if ($tekrar_ac) {
            echo 1;
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "kredi_ekstresini_getir") {


    $sql = "SELECT
       kku.*,
       kk.kredi_kodu,
       kto.odeme_tarihi as odeme_tarihi,
       kto.toplam_odeme as taksit_odeme,
       kk.faiz_orani,
       kk.kredi_kesintisi,
       kk.odenecek_toplam
FROM 
     kredi_kullanim_urunler as kku
LEFT JOIN kredi_taksit_odeme as kto on kto.kredi_id=kku.id AND kto.status=1
INNER JOIN kredi_kullanim as kk on kk.id=kku.kredi_id
WHERE kku.status!=0 AND kku.cari_key='$cari_key'";


    if (isset($_GET["kredi_id"])) {
        $kredi_id = $_GET["kredi_id"];
        if ($kredi_id != "") {
            $sql .= " AND kku.kredi_id='$kredi_id'";
        }
    }

    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        if ($bas_tarih != "" && $bit_tarih != "") {
            $sql .= " AND kku.vade_tarih BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
        }
    }
    $sql .= " ORDER BY kku.taksit ASC";
    $taksitleri_getir_sql = DB::all_data($sql);

    if ($taksitleri_getir_sql > 0) {
        $gidecek_arr = [];
        $taksit_tot = 0;
        $ana_para_tot = 0;
        $masraf_tot = 0;
        $gecikme_faiz_tot = 0;
        $erken_odeme_tot = 0;
        foreach ($taksitleri_getir_sql as $item) {
            $odeme_tarihi = "";
            if (isset($item["odeme_tarihi"])) {
                $odeme_tarihi = $item["odeme_tarihi"];
            } else {
                $odeme_tarihi = $item["vade_tarih"];
            }
            $ana_para_tot += $item["ana_para"];
            $masraf_tot += $item["faiz_tutari"];

            $toplam_odeme = 0;
            if ($item["taksit_odeme"] != null) {
                $toplam_odeme = $item["taksit_odeme"];
            } else {
                $toplam_odeme = $item["toplam_odeme"];
            }
            $taksit_tot += $toplam_odeme;
            $durum = "ÖDENMEDİ";
            if ($item["status"] == 2) {
                $durum = "ÖDENDİ";
                if ($item["taksit_odeme"] == $item["toplam_odeme"]) {

                } else if ($item["taksit_odeme"] > $item["toplam_odeme"]) {
                    $odenmesi_gereken = $item["toplam_odeme"];
                    $odenen = $item["taksit_odeme"];
                    $fark = $odenen - $odenmesi_gereken;
                    $gecikme_faiz_tot += $fark;
                } else if ($item["taksit_odeme"] < $item["toplam_odeme"]) {
                    $odenmesi_gereken = $item["toplam_odeme"];
                    $odenen = $item["taksit_odeme"];
                    $fark = $odenmesi_gereken - $odenen;
                    $erken_odeme_tot += $fark;
                }
            }

            $odeme_tarihi = date("d/m/Y", strtotime($odeme_tarihi));
            $ana_para = number_format($item["ana_para"], 2);
            $toplam_odeme = number_format($toplam_odeme, 2);
            $faiz_tutari = number_format($item["faiz_tutari"], 2);
            $arr = [
                'taksit_no' => $item["taksit"],
                'kredi_kodu' => $item["kredi_kodu"],
                'taksit_tarihi' => $odeme_tarihi,
                'taksit_tutari' => $toplam_odeme,
                'ana_para' => $ana_para,
                'faiz_tutari' => $faiz_tutari,
                'faiz_orani' => $item["faiz_orani"],
                'durum' => $durum
            ];
            array_push($gidecek_arr, $arr);
        }

        if (!empty($gidecek_arr)) {
            $taksit_tot = number_format($taksit_tot, 2);
            $ana_para_tot = number_format($ana_para_tot, 2);
            $masraf_tot = number_format($masraf_tot, 2);
            $gecikme_faiz_tot = number_format($gecikme_faiz_tot, 2);
            $erken_odeme_tot = number_format($erken_odeme_tot, 2);
            $gidecek_arr[0]["taksit_tot"] = $taksit_tot;
            $gidecek_arr[0]["ana_para_tot"] = $ana_para_tot;
            $gidecek_arr[0]["masraf_tot"] = $masraf_tot;
            $gidecek_arr[0]["gecikme_faiz_tot"] = $gecikme_faiz_tot;
            $gidecek_arr[0]["erken_odeme_tot"] = $erken_odeme_tot;
            echo json_encode($gidecek_arr);
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "kredi_acilisi_yap_sql") {
    $acilis_tarihi = $_POST["acilis_tarihi"];
    $gidecek_arr = $_POST["gidecek_arr"];
    unset($_POST["gidecek_arr"]);

    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;

    $kredi_kullanim_ekle = DB::insert("kredi_kullanim", $_POST);
    $son_tahsilat = DB::single_query("SELECT id FROM kredi_kullanim where cari_key='$cari_key'  ORDER BY id DESC LIMIT 1");
    foreach ($gidecek_arr as $item) {
        $item["kredi_id"] = $son_tahsilat["id"];
        $item["cari_key"] = $cari_key;
        $item["sube_key"] = $sube_key;
        $item["insert_userid"] = $_SESSION["user_id"];
        $item["insert_datetime"] = date("Y-m-d");
        if (strtotime($item["vade_tarih"]) < strtotime($acilis_tarihi)) {
            $item["status"] = 2;
            $item["acilis_mi"] = 2;
        }
        $kredi_kullanim_urunler = DB::insert("kredi_kullanim_urunler", $item);
    }
    if ($kredi_kullanim_urunler) {
        echo 500;
    } else {
        echo 1;
    }
}