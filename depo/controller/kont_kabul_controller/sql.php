<?php
include "../../../controller/DB.php";
include "../depo_db.php";
date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=UTF-8');
session_start();
DB::connect();
depo_db::depo_connect();
$cari_key = $_SESSION["cari_key"];
$sube_key = $_SESSION["sube_key"];
$islem = $_GET["islem"];

if ($islem == "depo_konteyner_tanim_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["cari_key"] = $cari_key;
    $_POST["sube_key"] = $sube_key;
    $konteyner_no = $_POST["konteyner_no"];
    $beklenen_konteynerler = depo_db::depo_all_data("SELECT * FROM konteyner_tanim WHERE status=1 AND cari_key='$cari_key' AND konteyner_no='$konteyner_no'");
    if ($beklenen_konteynerler > 0){
        echo 300;
    }else{
        $depoya_ekle = depo_db::depo_insert("konteyner_tanim", $_POST);
        if ($depoya_ekle) {
            echo 2;
        } else {
            echo 1;
        }
    }
}
if ($islem == "beklenen_konteynerleri_getir") {
    $beklenen_konteynerler = depo_db::depo_all_data("SELECT * FROM konteyner_tanim WHERE status=1 AND cari_key='$cari_key'");
    if ($beklenen_konteynerler > 0) {
        $gidecek_arr = [];
        foreach ($beklenen_konteynerler as $item) {
            $bildirim_tarihi = date("d/m/Y", strtotime($item["bildirim_tarihi"]));
            $arr = [
                'bildirim_tarihi' => $bildirim_tarihi,
                'konteyner_no' => $item["konteyner_no"],
                'konteyner_tipi' => $item["konteyner_tipi"],
                'tipi' => $item["tipi"],
                'acenta_adi' => $item["acenta_adi"],
                'acenta_kodu' => $item["acenta_kodu"],
                'shipper' => $item["shipper"],
                'islem' => "<button class='btn btn-sm konteyner_tanim_guncelle_button' style='background-color: #F6FA70' data-id='" . $item["id"] . "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm gelecek_konteyneri_iptal_et' data-id='" . $item["id"] . "'><i class='fa fa-trash'></i></button>"
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
if ($islem == "konteyner_tanim_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $veriyi_sil = depo_db::depo_update("konteyner_tanim", "id", $_POST["id"], $_POST);
    if ($veriyi_sil) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "konteyner_bilgilerini_getir_sql") {
    $id = $_GET["id"];
    $beklenen_konteynerler = depo_db::depo_single_query("SELECT * FROM konteyner_tanim WHERE status=1 AND cari_key='$cari_key' AND id='$id'");
    if ($beklenen_konteynerler > 0) {
        $bildirim_tarihi = date("Y-m-d", strtotime($beklenen_konteynerler["bildirim_tarihi"]));
        $gidecek_arr = [
            'bildirim_tarihi' => $bildirim_tarihi,
            'konteyner_no' => $beklenen_konteynerler["konteyner_no"],
            'konteyner_tipi' => $beklenen_konteynerler["konteyner_tipi"],
            'tipi' => $beklenen_konteynerler["tipi"],
            'acenta_adi' => $beklenen_konteynerler["acenta_adi"],
            'acenta_kodu' => $beklenen_konteynerler["acenta_kodu"],
            'acenta_id' => $beklenen_konteynerler["acenta_id"],
            'shipper' => $beklenen_konteynerler["shipper"]
        ];
        if (!empty($gidecek_arr)) {
            echo json_encode($gidecek_arr);
        } else {
            echo 2;
        }
    }
}
if ($islem == "depo_konteyner_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $veriyi_sil = depo_db::depo_update("konteyner_tanim", "id", $_POST["id"], $_POST);
    if ($veriyi_sil) {
        echo 1;
    } else {
        echo 2;
    }
}