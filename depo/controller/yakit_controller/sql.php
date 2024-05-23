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

if ($islem == "yakit_cikis_fisi_kaydet_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;

    $depo_yakit_ekle = DBD::insert("yakit_alim", $_POST);
    if ($depo_yakit_ekle) {
        echo 500;
    } else {
        echo 1;
    }
}
if ($islem == "yakit_fislerini_getir_sql") {
    $tum_yakit_fislerini_getir = DBD::all_data("
SELECT 
       ya.*,
       fk.forklift_adi,
       fk.forklift_grubu,
       kk.kalmar_adi,
       kk.kalmar_grubu
FROM
     yakit_alim as ya
LEFT JOIN forklift_kartlari as fk on fk.id=ya.forklift_id
LEFT JOIN kalmar_kartlari as kk on kk.id=ya.kalmar_id
WHERE ya.status=1 AND ya.cari_key='$cari_key'
");
    $gidecek_arr = [];
    $miktar_tot = 0;
    $tutar_tot = 0;
    $fark_tot = 0;
    foreach ($tum_yakit_fislerini_getir as $item) {
        $miktar_tot += $item["miktar"];
        $tutar_tot += $item["tl_tutar"];
        $fark_tot += $item["fark_saat"];

        $arac_adi = "";
        $arac_grubu = "";
        if ($item["forklift_adi"] != "" || $item["forklift_adi"] != null) {
            $arac_adi = $item["forklift_adi"];
            $arac_grubu = $item["forklift_grubu"];
        } else {
            $arac_adi = $item["kalmar_adi"];
            $arac_grubu = $item["kalmar_grubu"];
        }

        $cari_id = $item["istasyon_id"];
        $cari = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");

        $arr = [
            'alim_yeri' => $item["alim_yeri"],
            'tarih' => date("d/m/Y", strtotime($item["tarih"])),
            'arac_adi' => $arac_adi,
            'surucu_adi' => $item["surucu_adi"],
            'fis_no' => $item["fis_no"],
            'miktar' => number_format($item["miktar"], 2),
            'litre_fiyat' => number_format($item["litre_fiyati"], 2),
            'tutar' => number_format($item["tl_tutar"], 2),
            'yakit_tipi' => $item["yakit_tipi"],
            'istasyon_adi' => $cari["cari_adi"],
            'arac_tipi' => $arac_grubu,
            'son_alinan_saat' => number_format($item["son_alinan_saat"], 0),
            'yakit_alim_saat' => number_format($item["yakit_alim_saat"], 0),
            'fark_saat' => $item["fark_saat"],
            'fatura_no' => "",
            'fatura_tarihi' => "",
            'durum' => "Bekliyor",
            'islem' => "<button class='btn btn-sm depo_yakit_fisleri_guncelle_button' data-id='" . $item["id"] . "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm depo_yakit_sil_button' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
        ];
        array_push($gidecek_arr, $arr);
    }
    if (!empty($gidecek_arr)) {
        $gidecek_arr[0]["miktar_tot"] = number_format($miktar_tot, 2);
        $gidecek_arr[0]["tutar_tot"] = number_format($tutar_tot, 2);
        $gidecek_arr[0]["fark_tot"] = number_format($fark_tot, 0);
        echo json_encode($gidecek_arr);
    } else {
        echo 2;
    }
}
if ($islem == "yakit_cikis_fisi_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;

    $guncelle = DBD::update("yakit_alim", "id", $_POST["id"], $_POST);

    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "yakit_bilgilerini_getir_sql") {
    $id = $_GET["id"];

    $item = DBD::single_query("SELECT * FROM yakit_alim WHERE status=1 AND id='$id'");
    if ($item > 0) {

        $cari_id = $item["istasyon_id"];
        $cari = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' AND id='$cari_id'");

        $arr = [
            'alim_yeri' => $item["alim_yeri"],
            'tarih' => date("Y-m-d", strtotime($item["tarih"])),
            'forklift_id' => $item["forklift_id"],
            'kalmar_id' => $item["kalmar_id"],
            'surucu_adi' => $item["surucu_adi"],
            'surucu_id' => $item["surucu_id"],
            'fis_no' => $item["fis_no"],
            'miktar' => $item["miktar"],
            'yakit_depo_id' => $item["yakit_depo_id"],
            'litre_fiyat' => $item["litre_fiyati"],
            'tutar' => $item["tl_tutar"],
            'yakit_tuketim' => $item["yakit_tuketim"],
            'yakit_tipi' => $item["yakit_tipi"],
            'tasima_kg' => $item["tasima_kg"],
            'istasyon_adi' => $cari["cari_adi"],
            'istasyon_id' => $item["istasyon_id"],
            'son_alinan_saat' => $item["son_alinan_saat"],
            'yakit_alim_saat' => $item["yakit_alim_saat"],
            'fark_saat' => $item["fark_saat"],
            'fatura_no' => "",
            'fatura_tarihi' => "",
            'durum' => "Bekliyor"
        ];
        echo json_encode($arr);
    } else {
        echo 2;
    }
}
if ($islem == "yakit_cikis_fisi_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DBD::update("yakit_alim", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}