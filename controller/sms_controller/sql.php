<?php
include '../DB.php';
date_default_timezone_set('Europe/Istanbul');
header('Content-Type: text/html; charset=UTF-8');
session_start();
DB::connect();
$cari_key = $_SESSION["cari_key"];
$sube_key = $_SESSION["sube_key"];
$islem = $_GET["islem"];

if ($islem == "genel_sms_gonder_sql") {
    $arr = [
        'insert_userid' => $_SESSION["user_id"],
        'insert_datetime' => date("Y-m-d H:i:s"),
        'cari_key' => $cari_key,
        'sube_key' => $sube_key
    ];

    $ana_kayit = DB::insert("sms_gonder", $arr);
    if ($ana_kayit) {
        echo 500;
    } else {
        $son_eklenen = DB::single_query("SELECT id FROM sms_gonder where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        foreach ($_POST["gidecek_arr"] as $item) {
            $item["sms_id"] = $son_eklenen["id"];
            $item["insert_userid"] = $_SESSION["user_id"];
            $item["insert_datetime"] = date("Y-m-d H:i:s");
            $item["cari_key"] = $cari_key;
            $item["sube_key"] = $sube_key;
            $ekle = DB::insert("sms_gonder_detay", $item);
        }
        if ($ekle) {
            echo 500;
        } else {
            echo 1;
        }
    }
}
if ($islem == "gonderilen_smsleri_getir_sql") {
    $giden_smsler = DB::all_data("
SELECT
       sg.*,
       COUNT(sgd.id) as kisi_sayisi,
       sgd.baslik,
       sgd.icerik,
       u.name_surname
FROM
     sms_gonder as sg
INNER JOIN sms_gonder_detay as sgd on sgd.sms_id=sg.id
INNER JOIN users as u on u.id=sg.insert_userid
WHERE sg.status=1 AND sg.cari_key='$cari_key' GROUP BY sg.id
");
    if ($giden_smsler > 0) {
        $gidecek_arr = [];
        foreach ($giden_smsler as $item) {
            $arr = [
                '#' => "<button data-id='" . $item["id"] . "' class='btn btn-info btn-sm kredi_detaylari_button' style='border-radius: 50%;'><i class='fa fa-plus'></i></button>",
                'gonderim_tarihi' => date("d/m/Y", strtotime($item["insert_datetime"])),
                'gonderen_kullanici' => $item["name_surname"],
                'kisi_sayisi' => $item["kisi_sayisi"],
                'baslik' => $item["baslik"],
                "icerik" => $item["icerik"]
            ];
            array_push($gidecek_arr, $arr);
        }
        if (!empty($gidecek_arr)) {
            echo json_encode($gidecek_arr);
        } else {
            echo 2;
        }
    }
}