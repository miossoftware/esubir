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
if ($islem == "carileri_getir") {
    $cariler = DB::all_data("

SELECT 
       c.*,
       (select bilanco_adi from bilancolar where id=c.bilanco_id) as bilanco_kodu,
       (select cari_grup_adi from cari_grubu_tanim where id=c.cari_grubu) as cari_grubu
FROM
     cari as c
WHERE c.status=1 and c.cari_key='$cari_key'");
    if ($cariler > 0) {
        echo json_encode($cariler);
    } else {
        echo 2;
    }
}
if ($islem == "cari_ekle") {
    $son_no = $_POST["son_no"];
    $harf_kodu = $_POST["harf_kodu"];
    unset($_POST["harf_kodu"]);
    unset($_POST["son_no"]);
    if ($harf_kodu == "") {
        $arr = [
            'son_rakam' => 1,
            'modul_adi' => 'Cari Ekle',
            'cari_key' => $cari_key,
            'sube_key' => $sube_key
        ];
        $belge_referans = DB::insert("belge_referans", $arr);
        if ($belge_referans) {
            echo 2;
        } else {
            $_POST["insert_userid"] = $_SESSION["user_id"];
            $_POST["insert_datetime"] = date("Y-m-d H:i:s");
            $cari_kodu = $_POST["cari_kodu"];
            $cari_kodu_varmi = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_kodu='$cari_kodu' and cari_key='$cari_key'");
            if ($cari_kodu_varmi > 0) {
                echo 500;
            } else {
                $cari_arr_genel = [
                    "cari_turu" => $_POST["cari_turu"],
                    "cari_kodu" => $_POST["cari_kodu"],
                    "cari_adi" => $_POST["cari_adi"],
                    "vergi_dairesi" => $_POST["vergi_dairesi"],
                    "vergi_no" => $_POST["vergi_no"],
                    "internet_sitesi" => $_POST["internet_sitesi"],
                    "bilanco_id" => $_POST["bilanco_id"],
                    "cari_grubu" => $_POST["cari_grubu"],
                    "vade_gunu" => $_POST["vade_gunu"],
                    "telefon" => $_POST["telefon"],
                    "cep_telefonu" => $_POST["cep_telefonu"],
                    "faks" => $_POST["faks"],
                    "e_mail" => $_POST["e_mail"],
                    "yetkili_adi1" => $_POST["yetkili_adi1"],
                    "yetkili_tel1" => $_POST["yetkili_tel1"],
                    "yetkili_mail1" => $_POST["yetkili_mail1"],
                    "yetkili_ad2" => $_POST["yetkili_ad2"],
                    "yetkili_tel2" => $_POST["yetkili_tel2"],
                    "yetkili_mail" => $_POST["yetkili_mail"],
                    'insert_userid' => $_SESSION["user_id"],
                    'insert_datetime' => date("Y-m-d H:i:s"),
                    'cari_key' => $cari_key,
                    'sube_key' => $sube_key,
                    'aciklama' => $_POST["aciklama"]
                ];

                $cariyi_ekle = DB::insert("cari", $cari_arr_genel);
                if ($cariyi_ekle) {
                    echo 2;
                } else {
                    $son_eklenen = DB::single_query("SELECT id FROM cari where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
                    $adres_arr = [
                        'cari_id' => $son_eklenen["id"],
                        'il' => $_POST["cari_il"],
                        'ilce' => $_POST["cari_ilce"],
                        'adres' => $_POST["adres"],
                        'ozel_kod1' => $_POST["ozel_kod1"],
                        'ozel_kod2' => $_POST["ozel_kod2"],
                        'ozel_kod3' => $_POST["ozel_kod3"],
                        'insert_userid' => $_SESSION["user_id"],
                        'insert_datetime' => date("Y-m-d H:i:s"),
                        'cari_key' => $cari_key,
                        'sube_key' => $sube_key
                    ];
                    $cari_adres_bilgisi_ekle = DB::insert("cari_adres_bilgileri", $adres_arr);
                    if ($cari_adres_bilgisi_ekle) {
                        echo 2;
                    } else {
                        foreach ($_POST["banka_arr"] as $item) {
                            $item["cari_id"] = $son_eklenen["id"];
                            $item["cari_key"] = $cari_key;
                            $item["sube_key"] = $sube_key;
                            $item["insert_userid"] = $_SESSION["user_id"];
                            $item["insert_datetime"] = date("Y-m-d H:i:s");
                            $cariye_banka_ekle = DB::insert("cari_banka_bilgileri", $item);
                        }
                        if ($cariye_banka_ekle) {
                            echo 2;
                        } else {
                            echo 1;
                        }
                    }
                }
            }
        }
    } else {
        $arr = [
            'son_rakam' => $son_no,
            'modul_adi' => 'Cari Ekle',
            'cari_key' => $cari_key,
            'sube_key' => $sube_key,
            'harf_kodu' => $harf_kodu
        ];
        $belge_referans = DB::insert("belge_referans", $arr);
        if ($belge_referans) {
            echo 2;
        } else {
            $_POST["insert_userid"] = $_SESSION["user_id"];
            $_POST["insert_datetime"] = date("Y-m-d H:i:s");
            $cari_kodu = $_POST["cari_kodu"];
            $cari_kodu_varmi = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_kodu='$cari_kodu' and cari_key='$cari_key'");
            if ($cari_kodu_varmi > 0) {
                echo 500;
            } else {
                $cari_arr_genel = [
                    "cari_turu" => $_POST["cari_turu"],
                    "cari_kodu" => $_POST["cari_kodu"],
                    "cari_adi" => $_POST["cari_adi"],
                    "vergi_dairesi" => $_POST["vergi_dairesi"],
                    "vergi_no" => $_POST["vergi_no"],
                    "internet_sitesi" => $_POST["internet_sitesi"],
                    "bilanco_id" => $_POST["bilanco_id"],
                    "cari_grubu" => $_POST["cari_grubu"],
                    "vade_gunu" => $_POST["vade_gunu"],
                    "telefon" => $_POST["telefon"],
                    "cep_telefonu" => $_POST["cep_telefonu"],
                    "faks" => $_POST["faks"],
                    "e_mail" => $_POST["e_mail"],
                    "yetkili_adi1" => $_POST["yetkili_adi1"],
                    "yetkili_tel1" => $_POST["yetkili_tel1"],
                    "yetkili_mail1" => $_POST["yetkili_mail1"],
                    "yetkili_ad2" => $_POST["yetkili_ad2"],
                    "yetkili_tel2" => $_POST["yetkili_tel2"],
                    "yetkili_mail" => $_POST["yetkili_mail"],
                    'insert_userid' => $_SESSION["user_id"],
                    'insert_datetime' => date("Y-m-d H:i:s"),
                    'cari_key' => $cari_key,
                    'sube_key' => $sube_key,
                    'aciklama' => $_POST["aciklama"]
                ];

                $cariyi_ekle = DB::insert("cari", $cari_arr_genel);
                if ($cariyi_ekle) {
                    echo 2;
                } else {
                    $son_eklenen = DB::single_query("SELECT id FROM cari where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
                    $adres_arr = [
                        'cari_id' => $son_eklenen["id"],
                        'il' => $_POST["cari_il"],
                        'ilce' => $_POST["cari_ilce"],
                        'adres' => $_POST["adres"],
                        'ozel_kod1' => $_POST["ozel_kod1"],
                        'ozel_kod2' => $_POST["ozel_kod2"],
                        'ozel_kod3' => $_POST["ozel_kod3"],
                        'insert_userid' => $_SESSION["user_id"],
                        'insert_datetime' => date("Y-m-d H:i:s"),
                        'cari_key' => $cari_key,
                        'sube_key' => $sube_key
                    ];
                    $cari_adres_bilgisi_ekle = DB::insert("cari_adres_bilgileri", $adres_arr);
                    if ($cari_adres_bilgisi_ekle) {
                        echo 2;
                    } else {
                        foreach ($_POST["banka_arr"] as $item) {
                            $item["cari_id"] = $son_eklenen["id"];
                            $item["cari_key"] = $cari_key;
                            $item["sube_key"] = $sube_key;
                            $item["insert_userid"] = $_SESSION["user_id"];
                            $item["insert_datetime"] = date("Y-m-d H:i:s");
                            $cariye_banka_ekle = DB::insert("cari_banka_bilgileri", $item);
                        }
                        if ($cariye_banka_ekle) {
                            echo 2;
                        } else {
                            echo 1;
                        }
                    }
                }
            }
        }
    }

}
if ($islem == "cari_bilgileri_getir") {
    $cari_kodu = $_GET["cari_kodu"];
    $cari_bilgileri = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_kodu='$cari_kodu' and cari_key='$cari_key'");
    if ($cari_bilgileri > 0) {
        echo json_encode($cari_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "cari_guncelle") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $cari_kodu = $_POST["cari_kodu"];
    $cari_bilgileri = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_kodu='$cari_kodu'");
    if ($cari_bilgileri > 0) {
        $id = $cari_bilgileri["id"];
        $cari_sil = DB::update("cari", "id", $id, $_POST);
        if ($cari_sil) {
            echo 1;
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "cariyi_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $cari_kodu = $_POST["cari_kodu"];
    $uzunluk = strlen($cari_kodu);
    $son_karakter_silinmis_metin = substr($cari_kodu, 0, $uzunluk - 1);
    $harf_kodu = DB::single_query("SELECT * FROM belge_referans WHERE harf_kodu='$son_karakter_silinmis_metin' and cari_key='$cari_key' and modul_adi='Cari Ekle'");
    $id = $harf_kodu["id"];
    $stok_bilgileri = DB::single_query("SELECT id,cari_kodu FROM cari WHERE status=1 AND cari_kodu='$cari_kodu'");
    $cari_id = $stok_bilgileri["id"];

    $alis_fatura = DB::single_query("SELECT id FROM alis_default WHERE status=1 AND cari_id='$cari_id' AND cari_key='$cari_key'") ?: [];
    $mahsup = DB::single_query("SELECT id FROM cari_mahsup_urunler WHERE status=1 AND cari_id='$cari_id' AND cari_key='$cari_key'") ?: [];
    $acilis_fisi = DB::single_query("SELECT id FROM cari_acilis_fisleri WHERE status=1 AND cari_id='$cari_id' AND cari_key='$cari_key'") ?: [];
    $alis_irsaliye = DB::single_query("SELECT id FROM alis_irsaliye WHERE status=1 AND cari_id='$cari_id' AND cari_key='$cari_key'") ?: [];
    $verilen_siparis = DB::single_query("SELECT id FROM verilen_siparisler WHERE status=1 AND cari_id='$cari_id' AND cari_key='$cari_key'") ?: [];
    $satis_fatura = DB::single_query("SELECT id FROM satis_default WHERE status=1 AND cari_id='$cari_id' AND cari_key='$cari_key'") ?: [];
    $satis_irsaliye = DB::single_query("SELECT id FROM satis_irsaliye WHERE status=1 AND cari_id='$cari_id' AND cari_key='$cari_key'") ?: [];
    $satis_siparis = DB::single_query("SELECT id FROM alinan_siparisler WHERE status=1 AND cari_id='$cari_id' AND cari_key='$cari_key'") ?: [];
    $kasa_tahsilat = DB::single_query("SELECT id FROM kasa_tahsilat_urunler WHERE status=1 AND cari_id='$cari_id' AND cari_key='$cari_key'") ?: [];
    $kasa_odeme = DB::single_query("SELECT id FROM kasa_odeme_urunler WHERE status=1 AND cari_id='$cari_id' AND cari_key='$cari_key'") ?: [];
    $havale_giris = DB::single_query("SELECT id FROM havale_giris_urunler WHERE status=1 AND cari_id='$cari_id' AND cari_key='$cari_key'") ?: [];
    $havale_cikis = DB::single_query("SELECT id FROM havale_cikis_urunler WHERE status=1 AND cari_id='$cari_id' AND cari_key='$cari_key'") ?: [];
    $cek_senet_giris = DB::single_query("SELECT id FROM alinan_cek_giris WHERE status=1 AND cari_id='$cari_id' AND cari_key='$cari_key'") ?: [];
    $personel_bilgi = DB::all_data("SELECT id,personel_kodu FROM personel_tanim WHERE status=1 AND cari_key='$cari_key'") ?: [];
    $maas = [];
    foreach ($personel_bilgi as $item) {
        if ($item["personel_kodu"] == $stok_bilgileri["cari_kodu"]) {
            $personel_id = $item["id"];
            $maas_tahakkuk = DB::single_query("SELECT id FROM personel_tahakkuk WHERE status=1 AND personel_id='$personel_id' AND cari_key='$cari_key'") ?: [];
            array_push($maas, $maas_tahakkuk);
        }
    }
    $merged_array = array_merge($alis_fatura, $mahsup, $acilis_fisi, $alis_irsaliye, $verilen_siparis, $satis_fatura, $satis_irsaliye, $satis_siparis, $kasa_tahsilat, $kasa_odeme, $havale_cikis, $havale_giris, $cek_senet_giris, $maas);
    if (!empty($merged_array)) {
        echo 300;
    } else {
        $arr = [
            "status" => 0
        ];
        $belge_referans_sil = DB::update("belge_referans", "id", $id, $arr);
        if ($belge_referans_sil) {
            $cari_sil = DB::update("cari", "cari_kodu", $cari_kodu, $_POST);
            if ($cari_sil) {
                echo 1;
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    }

}
if ($islem == "bilanco_kodu_getir") {
    $id = $_GET["id"];
    $bilanco_adi = DB::single_query("SELECT bilanco_kodu FROM bilancolar WHERE status=1 AND id='$id' and cari_key='$cari_key'");
    if ($bilanco_adi > 0) {
        echo json_encode($bilanco_adi);
    } else {
        echo 2;
    }
}
if ($islem == "bilancolari_getir_sql") {
    $bilancolar = DB::all_data("SELECT id,bilanco_adi FROM bilancolar WHERE status=1 and cari_key='$cari_key'");
    if ($bilancolar > 0) {
        echo json_encode($bilancolar);
    } else {
        echo 2;
    }
}
if ($islem == "cari_adres_bilgi_ekle") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $cari_kodu = $_POST["cari_id"];
    $cari_bilgi = DB::single_query("SELECT * FROM cari WHERE cari_kodu='$cari_kodu' and cari_key='$cari_key' ");
    if ($cari_bilgi > 0) {
        $cari_id = $cari_bilgi["id"];
        $_POST["cari_id"] = $cari_id;
        $adres_bilgileri_guncelle = DB::insert("cari_adres_bilgileri", $_POST);
        if ($adres_bilgileri_guncelle) {
            echo 2;
        } else {
            echo 1;
        }
    }
}
if ($islem == "cari_adres_bilgi_guncelle") {
    if ($_POST["cari_id"] == "") {
        echo 400;
    } else {
        $cari_kodu = $_POST["cari_id"];
        $cari_bilgi = DB::single_query("SELECT * FROM cari WHERE cari_kodu='$cari_kodu' and cari_key='$cari_key' ");
        $cari_id = $cari_bilgi["id"];
        $carinin_adresi_varmi = DB::single_query("SELECT * FROM cari_adres_bilgileri WHERE status=1 AND cari_id='$cari_id' and cari_key='$cari_key'");
        if ($carinin_adresi_varmi > 0) {
            $_POST["update_userid"] = $_SESSION["user_id"];
            $_POST["update_datetime"] = date("Y-m-d H:i:s");
            if ($cari_bilgi > 0) {
                $_POST["cari_id"] = $cari_id;
                $adres_bilgileri_guncelle = DB::update("cari_adres_bilgileri", "cari_id", $cari_id, $_POST);
                if ($adres_bilgileri_guncelle) {
                    echo 1;
                } else {
                    echo 2;
                }
            }
        } else {
            $_POST["insert_userid"] = $_SESSION["user_id"];
            $_POST["insert_datetime"] = date("Y-m-d H:i:s");
            $cari_bilgi = DB::single_query("SELECT * FROM cari WHERE cari_kodu='$cari_kodu' and cari_key='$cari_key' ");
            if ($cari_bilgi > 0) {
                $cari_id = $cari_bilgi["id"];
                $_POST["cari_id"] = $cari_id;
                $adres_bilgileri_guncelle = DB::insert("cari_adres_bilgileri", $_POST);
                if ($adres_bilgileri_guncelle) {
                    echo 2;
                } else {
                    echo 1;
                }
            }
        }
    }

}
if ($islem == "illeri_getir") {
    $iller = DB::all_data("SELECT * FROM il");
    if ($iller > 0) {
        echo json_encode($iller);
    } else {
        echo 2;
    }
}
if ($islem == "ilceleri_getir") {
    $il_id = $_GET["il_id"];
    $ilceler = DB::all_data("SELECT * FROM ilce WHERE il_id='$il_id'");
    if ($ilceler > 0) {
        echo json_encode($ilceler);
    } else {
        echo 2;
    }
}
if ($islem == "adres_bilgileri_getir") {
    $cari_kodu = $_GET["cari_kodu"];
    $cari_bilgi = DB::single_query("SELECT * FROM cari WHERE cari_kodu='$cari_kodu' and cari_key='$cari_key' ");
    if ($cari_bilgi > 0) {
        $cari_id = $cari_bilgi["id"];
        $adres_bilgileri = DB::single_query("SELECT * FROM cari_adres_bilgileri WHERE status=1 AND cari_id='$cari_id' and cari_key='$cari_key'");
        if ($adres_bilgileri > 0) {
            echo json_encode($adres_bilgileri);
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "ile_ait_ilceleri_getir") {
    $cari_kodu = $_GET["cari_kodu"];
    $cari_adres_bilgileri = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_kodu='$cari_kodu' and cari_key='$cari_key'");
    if ($cari_adres_bilgileri > 0) {
        $cari_id = $cari_adres_bilgileri["id"];
        $cari_il = DB::single_query("SELECT * FROM cari_adres_bilgileri WHERE status=1 AND cari_id='$cari_id' and cari_key='$cari_key'");
        if ($cari_il > 0) {
            $cari_il_kodu = $cari_il["il"];
            $ilceler = DB::all_data("SELECT * FROM ilce WHERE il_id='$cari_il_kodu'");
            if ($ilceler > 0) {
                echo json_encode($ilceler);
            } else {
                echo 2;
            }
        }
    } else {
        echo 2;
    }
}
if ($islem == "cariye_banka_ekle") {
    $cari_kodu = $_POST["cari_kodu"];
    $cari_id_getir = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_kodu='$cari_kodu' and cari_key='$cari_key'");
    if ($cari_id_getir > 0) {
        $cari_id = $cari_id_getir["id"];
        unset($_POST["cari_kodu"]);
        $_POST["cari_id"] = $cari_id;
        $cariye_bankayi_ekle = DB::insert("cari_banka_bilgileri", $_POST);
        if ($cariye_bankayi_ekle) {
            echo 2;
        } else {
            echo 1;
        }
    }
}
if ($islem == "carinin_bankalarini_getir") {
    $cari_kodu = $_GET["cari_kodu"];
    $cari_bilgi = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_kodu='$cari_kodu' and cari_key='$cari_key'");
    if ($cari_bilgi > 0) {
        $cari_id = $cari_bilgi["id"];
        $banka_bilgileri = DB::all_data("SELECT * FROM cari_banka_bilgileri WHERE status=1 AND cari_id='$cari_id' and cari_key='$cari_key'");
        if ($banka_bilgileri > 0) {
            echo json_encode($banka_bilgileri);
        } else {
            echo 2;
        }
    }
}
if ($islem == "cariye_ait_banka_sil") {
    $id = $_POST["id"];
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $cari_id_getir = DB::single_query("SELECT * FROM cari_banka_bilgileri WHERE status=1 AND id='$id' and cari_key='$cari_key'");
    if ($cari_id_getir > 0) {
        $cari_id = $cari_id_getir["cari_id"];
        $_POST["status"] = 0;
        $_POST["delete_detail"] = "Kullanıcı Tarafından Silinmiştir";
        $banka_sil = DB::update("cari_banka_bilgileri", "id", $id, $_POST);
        if ($banka_sil) {
            $bankalari_sec = DB::all_data("SELECT * FROM cari_banka_bilgileri WHERE status=1 AND cari_id='$cari_id' and cari_key='$cari_key' ");
            if ($bankalari_sec > 0) {
                echo json_encode($bankalari_sec);
            } else {
                echo 2;
            }
        } else {
            echo 500;
        }
    }
}
if ($islem == "cariye_sube_ekle") {
    $cari_kodu = $_POST["cari_kodu"];
    $cari_bilgileri = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_kodu='$cari_kodu' and cari_key='$cari_key'");
    if ($cari_bilgileri > 0) {
        $_POST["insert_datetime"] = date("Y-m-d H:i:s");
        $_POST["insert_userid"] = $_SESSION["user_id"];
        unset($_POST["cari_kodu"]);
        $_POST["cari_id"] = $cari_bilgileri["id"];
        $sube_ekle = DB::insert("cari_sube_bilgileri", $_POST);
        if ($sube_ekle) {
            echo 2;
        } else {
            $cari_id = $_POST["cari_id"];
            $subeler = DB::all_data("SELECT 
csb.*,il.il_adi,ilce.ilce_adi
FROM cari_sube_bilgileri as csb
INNER JOIN il on il.id=csb.il
INNER JOIN ilce on ilce.id=csb.ilce
WHERE status=1 AND cari_id='$cari_id' and cari_key='$cari_key'");
            if ($subeler > 0) {
                echo json_encode($subeler);
            } else {
                echo 2;
            }
        }
    } else {
        echo 500;
    }
}
if ($islem == "carinin_subeleri") {
    $cari_kodu = $_GET["cari_kodu"];
    $cari_bilgileri = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_kodu='$cari_kodu' and cari_key='$cari_key'");
    if ($cari_bilgileri > 0) {
        $cari_id = $cari_bilgileri["id"];
        $subeler = DB::all_data("SELECT 
csb.*,il.il_adi,ilce.ilce_adi
FROM cari_sube_bilgileri as csb
INNER JOIN il on il.id=csb.il
INNER JOIN ilce on ilce.id=csb.ilce
WHERE status=1 AND cari_id='$cari_id' and cari_key='$cari_key'");
        if ($subeler > 0) {
            echo json_encode($subeler);
        } else {
            echo 2;
        }
    }
}
if ($islem == "cariye_ait_sube_sil") {
    $id = $_POST["id"];
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $cari_bilgi = DB::single_query("SELECT * FROM cari_sube_bilgileri WHERE id='$id' and cari_key='$cari_key'");
    $sube_sil = DB::update("cari_sube_bilgileri", "id", $id, $_POST);
    if ($sube_sil) {
        $cari_id = $cari_bilgi["cari_id"];
        $subeler = DB::all_data("SELECT 
csb.*,il.il_adi,ilce.ilce_adi
FROM cari_sube_bilgileri as csb
INNER JOIN il on il.id=csb.il
INNER JOIN ilce on ilce.id=csb.ilce
WHERE status=1 AND cari_id='$cari_id'");
        if ($subeler > 0) {
            echo json_encode($subeler);
        } else {
            echo 2;
        }
    } else {
        echo 500;
    }
}
if ($islem == "son_cari_kodu_cek") {
    $harf_kodu = $_GET["harf_kodu"];
    $sql = "";
    if ($harf_kodu == "") {
        $sql = "SELECT * FROM cari WHERE status=1 AND cari_key='2' AND NOT cari_kodu REGEXP '^[A-Za-z]'
  AND cari_kodu NOT LIKE 'Ş%'  ORDER BY id DESC LIMIT 1";
    } else {
        $sql = "SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' AND cari_kodu LIKE '$harf_kodu%'  ORDER BY id DESC LIMIT 1";
    }

    $cariler = DB::single_query($sql);
    if ($cariler > 0) {
        $ayrilanlar = preg_replace("/[^0-9]/", "", $cariler["cari_kodu"]);
        $sayi = floatval($ayrilanlar) + 1;
        if ($sayi >= 10 && $sayi <= 99) {
            // 2 basamaklıysa önüne sıfır ekleyerek 3 basamaklı yap
            $sayi = "0" . $sayi;
        } else if ($sayi < 10) {
            $sayi = "00" . $sayi;
        }
        echo mb_strtoupper($harf_kodu) . $sayi;
    } else {
        echo mb_strtoupper($harf_kodu) . "001";
    }
}
if ($islem == "acilis_icin_cari_getir_sql") {
    $ek1 = "";
    if ($_SESSION["sube_key"] != 0) {
        $ek1 = " AND sube_key='$sube_key'";
    }
    $cari_listesi = DB::all_data("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' $ek1");
    if ($cari_listesi > 0) {
        echo json_encode($cari_listesi);
    } else {
        echo 2;
    }
}
if ($islem == "secilen_cari_bilgileri") {
    $id = $_GET["id"];
    $secilen_cari = DB::single_query("
SELECT 
       c.*,cab.adres
FROM
     cari as c
LEFT JOIN cari_adres_bilgileri AAS cab on cab.cari_id=c.id
WHERE c.id='$id' AND c.status=1");
    if ($secilen_cari > 0) {
        echo json_encode($secilen_cari);
    } else {
        echo 2;
    }
}
if ($islem == "acilis_secilen_cari_bilgileri_sql") {
    $id = $_GET["id"];
    $secilen_cari = DB::single_query("SELECT * FROM cari WHERE id='$id' AND status=1");
    if ($secilen_cari > 0) {
        echo json_encode($secilen_cari);
    } else {
        echo 2;
    }
}
if ($islem == "cari_acilis_fisi_ekle_sql") {
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $cari_acilis_fis_ekle = DB::insert("cari_acilis_fisleri", $_POST);
    if ($cari_acilis_fis_ekle) {
        echo 2;
    } else {
        $cari_id = $_POST["cari_id"];
        $cari_bilgileri = DB::single_query("SELECT * FROM cari WHERE status=1 AND id='$cari_id'");
        $son_eklenen = DB::single_query("SELECT id FROM cari_acilis_fisleri where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
        $acilis_id = $son_eklenen["id"];
        if ($cari_bilgileri > 0) {
            $carinin_borcu = $cari_bilgileri["borc"];
            $cari_alacak = $cari_bilgileri["alacak"];
            $gonderline_borc = $_POST["borc"];
            $gonderilen_alacak = $_POST["alacak"];
            $yeni_borc = floatval($gonderline_borc) + floatval($carinin_borcu);
            $yeni_alacak = floatval($gonderilen_alacak) + floatval($cari_alacak);
            $yeni_arr = [
                'borc' => $yeni_borc,
                'alacak' => $yeni_alacak,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];

            $yeni_cari_bilgileri = DB::update("cari", "id", $cari_id, $yeni_arr);
            if ($yeni_cari_bilgileri) {
                $acilis_bilgieri = DB::single_query("
SELECT
       cari_acilis_fisleri.*,c.cari_kodu,c.cari_adi
FROM 
     cari_acilis_fisleri
INNER JOIN cari as c on c.id=cari_acilis_fisleri.cari_id
WHERE cari_acilis_fisleri.status=1 AND cari_acilis_fisleri.id='$acilis_id'
");
                if ($acilis_bilgieri > 0) {
                    echo json_encode($acilis_bilgieri);
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
if ($islem == "acilis_borc_miktari_guncelle_sql") {
    if (isset($_POST["id"])) {
        $stok_id = $_POST["cari_id"];
        $_POST["update_userid"] = $_SESSION["user_id"];
        $_POST["update_datetime"] = date("Y-m-d H:i:s");
        $id = $_POST["id"];
        $en_son_miktar = DB::single_query("SELECT * FROM cari_acilis_fisleri WHERE status=1 AND id='$id'");
        $acilis_son_miktar = $en_son_miktar["borc"];
        $acilis_fis_guncelle = DB::update("cari_acilis_fisleri", "id", $id, $_POST);
        if ($acilis_fis_guncelle) {
            $stok_bilgileri = DB::single_query("SELECT * FROM cari WHERE status=1 AND id='$stok_id'");
            $envanter_miktar = $stok_bilgileri["borc"];
            $gonderilen_miktar = $_POST["borc"];
            $fark_miktar = floatval($gonderilen_miktar) - floatval($acilis_son_miktar);
            $yeni_miktar = floatval($envanter_miktar) + $fark_miktar;
            $arr = [
                'borc' => $yeni_miktar,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $stok_miktarini_guncelle = DB::update("cari", "id", $stok_id, $arr);
            if ($stok_miktarini_guncelle) {
                echo "id:" . $id;
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    } else {
        $stok_id = $_POST["cari_id"];
        $_POST["insert_userid"] = $_SESSION["user_id"];
        $_POST["insert_datetime"] = date("Y-m-d H:i:s");
        $acilis_fisi_olustur = DB::insert("cari_acilis_fisleri", $_POST);
        if ($acilis_fisi_olustur) {
            echo 2;
        } else {
            $son_eklenen = DB::single_query("SELECT id FROM cari_acilis_fisleri where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
            $fire_id = $son_eklenen["id"];
            $stok_bilgileri = DB::single_query("SELECT * FROM cari WHERE status=1 AND id='$stok_id'");
            $envanter_miktar = $stok_bilgileri["borc"];
            $gonderilen_miktar = $_POST["borc"];
            $yeni_miktar = floatval($envanter_miktar) + floatval($gonderilen_miktar);
            $arr = [
                'borc' => $yeni_miktar,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $stok_miktarini_guncelle = DB::update("cari", "id", $stok_id, $arr);
            if ($stok_miktarini_guncelle) {
                echo "id:" . $fire_id;
            } else {
                echo 2;
            }
        }
    }
}
if ($islem == "acilis_alacak_miktari_guncelle_sql") {
    if (isset($_POST["id"])) {
        $stok_id = $_POST["cari_id"];
        $_POST["update_userid"] = $_SESSION["user_id"];
        $_POST["update_datetime"] = date("Y-m-d H:i:s");
        $id = $_POST["id"];
        $en_son_miktar = DB::single_query("SELECT * FROM cari_acilis_fisleri WHERE status=1 AND id='$id'");
        $acilis_son_miktar = $en_son_miktar["alacak"];
        $acilis_fis_guncelle = DB::update("cari_acilis_fisleri", "id", $id, $_POST);
        if ($acilis_fis_guncelle) {
            $stok_bilgileri = DB::single_query("SELECT * FROM cari WHERE status=1 AND id='$stok_id'");
            $envanter_miktar = $stok_bilgileri["alacak"];
            $gonderilen_miktar = $_POST["alacak"];
            $fark_miktar = floatval($gonderilen_miktar) - floatval($acilis_son_miktar);
            $yeni_miktar = floatval($envanter_miktar) + $fark_miktar;
            $arr = [
                'alacak' => $yeni_miktar,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $stok_miktarini_guncelle = DB::update("cari", "id", $stok_id, $arr);
            if ($stok_miktarini_guncelle) {
                echo "id:" . $id;
            } else {
                echo 2;
            }
        } else {
            echo 2;
        }
    } else {
        $stok_id = $_POST["cari_id"];
        $_POST["insert_userid"] = $_SESSION["user_id"];
        $_POST["insert_datetime"] = date("Y-m-d H:i:s");
        $acilis_fisi_olustur = DB::insert("cari_acilis_fisleri", $_POST);
        if ($acilis_fisi_olustur) {
            echo 2;
        } else {
            $son_eklenen = DB::single_query("SELECT id FROM cari_acilis_fisleri where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
            $fire_id = $son_eklenen["id"];
            $stok_bilgileri = DB::single_query("SELECT * FROM cari WHERE status=1 AND id='$stok_id'");
            $envanter_miktar = $stok_bilgileri["alacak"];
            $gonderilen_miktar = $_POST["alacak"];
            $yeni_miktar = floatval($envanter_miktar) + floatval($gonderilen_miktar);
            $arr = [
                'alacak' => $yeni_miktar,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s")
            ];
            $stok_miktarini_guncelle = DB::update("cari", "id", $stok_id, $arr);
            if ($stok_miktarini_guncelle) {
                echo "id:" . $fire_id;
            } else {
                echo 2;
            }
        }
    }
}
if ($islem == "acilis_aciklama_ekle_guncelle_sql") {
    if (isset($_POST["id"])) {
        $_POST["update_userid"] = $_SESSION["user_id"];
        $_POST["update_datetime"] = date("Y-m-d H:i:s");
        $id = $_POST["id"];
        $acilis_fis_guncelle = DB::update("cari_acilis_fisleri", "id", $id, $_POST);
        if ($acilis_fis_guncelle) {
            echo "id:" . $id;
        } else {
            echo 2;
        }
    } else {
        $_POST["insert_userid"] = $_SESSION["user_id"];
        $_POST["insert_datetime"] = date("Y-m-d H:i:s");
        $acilis_fisi_olustur = DB::insert("cari_acilis_fisleri", $_POST);
        if ($acilis_fisi_olustur) {
            echo 2;
        } else {
            $son_eklenen = DB::single_query("SELECT id FROM cari_acilis_fisleri where cari_key='$cari_key' ORDER BY id DESC LIMIT 1");
            $fire_id = $son_eklenen["id"];
            echo 'id:' . $fire_id;
        }
    }
}
if ($islem == "tum_carileri_getir_sql") {
    $acilis_ek = "";
    if ($_SESSION["sube_key"] != 0) {
        $acilis_ek = " AND sube_key='$sube_key'";
    }
    $tum_stoklar = DB::all_data("
SELECT * FROM cari
WHERE status=1 AND cari_key='$cari_key' $acilis_ek");
    if ($tum_stoklar > 0) {
        echo json_encode($tum_stoklar);
    } else {
        echo 2;
    }
}
if ($islem == "secilen_acilislari_sil") {
    foreach ($_POST["silinecek_acilisids"] as $acilis_info) {
        $acilis_id = $acilis_info;
        $ilk_arr = [
            'delete_userid' => $_SESSION["user_id"],
            'delete_datetime' => date("Y-m-d H:i:s"),
            'delete_detail' => 'Kullanıcı Listeden Silme İşlemi Yapmıştır',
            'status' => 0
        ];
        $cari_acilis_sil = DB::update("cari_acilis_fisleri", "id", $acilis_id, $ilk_arr);
        if ($cari_acilis_sil) {
            $cari_acilis_bilgileri = DB::single_query("SELECT * FROM cari_acilis_fisleri WHERE id='$acilis_id'");
            if ($cari_acilis_bilgileri > 0) {
                $cari_id = $cari_acilis_bilgileri["cari_id"];
                $acilis_miktar = $cari_acilis_bilgileri["borc"];
                $alacak_miktar = $cari_acilis_bilgileri["alacak"];
                $cari_envanter_bilgi = DB::single_query("SELECT * FROM cari WHERE status=1 AND id='$cari_id'");
                $envanter_miktar = $cari_envanter_bilgi["borc"];
                $cari_alacak = $cari_envanter_bilgi["alacak"];
                $yeni_borc = floatval($envanter_miktar) - floatval($acilis_miktar);
                $yeni_alacak = floatval($cari_alacak) - floatval($alacak_miktar);
                $yeni_arr = [
                    "borc" => $yeni_borc,
                    "alacak" => $yeni_alacak,
                    "update_userid" => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $cari_miktar_guncelle = DB::update("cari", "id", $cari_id, $yeni_arr);
            }
        }
    }
    if ($cari_miktar_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "tum_acilislari_sil") {
    foreach ($_POST["silinecek_acilisids"] as $acilis_info) {
        $acilis_id = $acilis_info;
        $ilk_arr = [
            'delete_userid' => $_SESSION["user_id"],
            'delete_datetime' => date("Y-m-d H:i:s"),
            'delete_detail' => 'Kullanıcı Listeden Silme İşlemi Yapmıştır',
            'status' => 0
        ];
        $cari_acilis_sil = DB::update("cari_acilis_fisleri", "id", $acilis_id, $ilk_arr);
        if ($cari_acilis_sil) {
            $cari_acilis_bilgileri = DB::single_query("SELECT * FROM cari_acilis_fisleri WHERE id='$acilis_id'");
            if ($cari_acilis_bilgileri > 0) {
                $cari_id = $cari_acilis_bilgileri["cari_id"];
                $acilis_miktar = $cari_acilis_bilgileri["borc"];
                $alacak_miktar = $cari_acilis_bilgileri["alacak"];
                $cari_envanter_bilgi = DB::single_query("SELECT * FROM cari WHERE status=1 AND id='$cari_id'");
                $envanter_miktar = $cari_envanter_bilgi["borc"];
                $cari_alacak = $cari_envanter_bilgi["alacak"];
                $yeni_borc = floatval($envanter_miktar) - floatval($acilis_miktar);
                $yeni_alacak = floatval($cari_alacak) - floatval($alacak_miktar);
                $yeni_arr = [
                    "borc" => $yeni_borc,
                    "alacak" => $yeni_alacak,
                    "update_userid" => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $cari_miktar_guncelle = DB::update("cari", "id", $cari_id, $yeni_arr);
            }
        }
    }
    if ($cari_miktar_guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "tum_acilis_fislerini_getir_sql") {
    $ek2 = "";
    if ($_SESSION["sube_key"] != 0) {
        $ek2 = " AND caf.sube_key='$sube_key'";
    }
    $tum_acilislari_getir = DB::all_data("
SELECT
       caf.*,c.cari_kodu,c.cari_adi 
FROM
    cari_acilis_fisleri as caf
INNER JOIN cari as c on c.id=caf.cari_id
WHERE caf.status=1 AND caf.cari_key='$cari_key' $ek2 
  ");
    if ($tum_acilislari_getir > 0) {
        echo json_encode($tum_acilislari_getir);
    } else {
        echo 2;
    }
}
if ($islem == "acilis_fisi_sil_main_sql") {
    $id = $_POST["id"];
    $acilis_fisi_bilgileri = DB::single_query("SELECT * FROM cari_acilis_fisleri WHERE status=1 AND id='$id'");
    if ($acilis_fisi_bilgileri > 0) {
        $acilis_cari_id = $acilis_fisi_bilgileri["cari_id"];
        $acilis_miktar = $acilis_fisi_bilgileri["borc"];
        $acilis_alacak = $acilis_fisi_bilgileri["alacak"];
        $cari_envanter_bilgi = DB::single_query("SELECT * FROM cari WHERE status=1 AND id='$acilis_cari_id'");
        if ($cari_envanter_bilgi > 0) {
            $acilis_arr = [
                'status' => 0,
                'delete_userid' => $_SESSION["user_id"],
                'delete_detail' => $_POST["delete_detail"],
                'delete_datetime' => date("Y-m-d H:i:s")
            ];

            $acilis_fisi_sil = DB::update("cari_acilis_fisleri", "id", $id, $acilis_arr);
            if ($acilis_fisi_sil) {
                $envanter_miktar = $cari_envanter_bilgi["borc"];
                $envanter_alacak = $cari_envanter_bilgi["alacak"];
                $yeni_borc = floatval($envanter_miktar) - floatval($acilis_miktar);
                $yeni_alacak = floatval($envanter_alacak) - floatval($acilis_alacak);
                $yeni_arr = [
                    'borc' => $yeni_borc,
                    'alacak' => $yeni_alacak,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $envanter_bilgi_guncelle = DB::update("cari", "id", $acilis_cari_id, $yeni_arr);
                if ($envanter_bilgi_guncelle) {
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
if ($islem == "cariye_mahsup_fisi_ekle") {
    $cari_kodu = $_POST["cari_kodu"];
    $carimi = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_kodu='$cari_kodu'");
    $cari_id = "";
    $uye_id = "";
    if ($carimi > 0) {
        $cari_id = $carimi["id"];
    } else {
        $uyemi = DB::single_query("SELECT * FROM uye_tanim WHERE status=1 AND tc_no='$cari_kodu'");
        if ($uyemi > 0) {
            $uye_id = $uyemi["id"];
        }
    }
    unset($_POST["cari_kodu"]);
    $gonderilen_borc = $_POST["borc"];
    $gonderilen_alacak = $_POST["alacak"];
    if (isset($_POST["mahsup_id"])) {
        $mahsup_id = $_POST["mahsup_id"];

        $mahsup_bilgileri = DB::single_query("SELECT * FROM cari_mahsup WHERE status=1 AND id='$mahsup_id'");
        if ($mahsup_bilgileri > 0) {
            $mahsup_borc = $mahsup_bilgileri["toplam_borc"];
            $mahsup_alacak = $mahsup_bilgileri["toplam_alacak"];

            $yeni_toplam_borc = floatval($mahsup_borc) + floatval($gonderilen_borc);
            $yeni_toplam_alacak = floatval($mahsup_alacak) + floatval($gonderilen_alacak);
            $mahsup_arr = [
                'toplam_borc' => $yeni_toplam_borc,
                'toplam_alacak' => $yeni_toplam_alacak,
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s"),
                'doviz_tur' => $_POST["doviz_tur"],
                'doviz_kuru' => $_POST["kur_fiyat"]
            ];
            $ana_mahsup_guncelle = DB::update("cari_mahsup", "id", $mahsup_id, $mahsup_arr);
            if ($ana_mahsup_guncelle) {
                $arr = [
                    'aciklama' => $_POST["aciklama"],
                    'borc' => $_POST["borc"],
                    'alacak' => $_POST["alacak"],
                    'cari_id' => $cari_id,
                    'uye_id' => $uye_id,
                    'mahsup_id' => $mahsup_id,
                    'cari_key' => $cari_key,
                    'sube_key' => $sube_key
                ];
                $acilis_mahsup_ekle = DB::insert("cari_mahsup_urunler", $arr);
                if ($acilis_mahsup_ekle) {
                    echo 2;
                } else {
                    $cari_id = $_POST["cari_id"];
                    $cari_bilgileri = DB::single_query("SELECT * FROM cari WHERE status=1 AND id='$cari_id'");
                    $son_bilgiler = DB::all_data("
SELECT
        cmu.*,c.cari_adi,c.cari_kodu,cm.toplam_borc,cm.toplam_alacak,cm.doviz_tur,cm.doviz_kuru,ut.uye_adi,ut.tc_no
FROM
        cari_mahsup_urunler as cmu
LEFT JOIN cari as c on c.id=cmu.cari_id
LEFT JOIN uye_tanim as ut on ut.id=cmu.uye_id
INNER JOIN cari_mahsup as cm on cm.id=cmu.mahsup_id
WHERE
cmu.status=1 AND cmu.cari_key='$cari_key' AND cmu.mahsup_id='$mahsup_id'
");
                    if ($son_bilgiler > 0) {
                        echo json_encode($son_bilgiler);
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
        $mahsup_fisi_arr = [
            'doviz_tur' => $_POST["doviz_tur"],
            'doviz_kuru' => $_POST["kur_fiyat"],
            'insert_userid' => $_SESSION["user_id"],
            'insert_datetime' => date("Y-m-d H:i:s"),
            'cari_key' => $cari_key,
            'sube_key' => $sube_key,
            'toplam_borc' => $_POST["borc"],
            'toplam_alacak' => $_POST["alacak"]
        ];
        $mahsup_fisi_olustur = DB::insert("cari_mahsup", $mahsup_fisi_arr);
        if ($mahsup_fisi_olustur) {
            echo 2;
        } else {
            $e_sorgu = "";
            if ($_SESSION["sube_key"] != 0) {
                $ek_sorgu = " AND sube_key='$sube_key'";
            }
            $olusan_mahsup = DB::single_query("SELECT id FROM cari_mahsup where cari_key='$cari_key' $e_sorgu ORDER BY id DESC LIMIT 1");
            if ($olusan_mahsup > 0) {
                $mahsup_id = $olusan_mahsup["id"];
                $mahsup_fis_urun_arr = [
                    'cari_id' => $cari_id,
                    'uye_id' => $uye_id,
                    'borc' => $_POST["borc"],
                    'alacak' => $_POST["alacak"],
                    'mahsup_id' => $mahsup_id,
                    'aciklama' => $_POST["aciklama"],
                    'cari_key' => $cari_key,
                    'sube_key' => $sube_key,
                    'insert_userid' => $_SESSION["user_id"],
                    'insert_datetime' => date("Y-m-d H:i:s")
                ];
                $mahsup_urun_ekle = DB::insert("cari_mahsup_urunler", $mahsup_fis_urun_arr);
                if ($mahsup_urun_ekle) {
                    echo 2;
                } else {
                    $cari_id = $_POST["cari_id"];
                    $cari_bilgileri = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' $e_sorgu");
                    $son_bilgiler = DB::all_data("
SELECT
        cmu.*,c.cari_adi,c.cari_kodu,cm.toplam_borc,cm.toplam_alacak,cm.doviz_tur,cm.doviz_kuru,ut.uye_adi,ut.tc_no
FROM
        cari_mahsup_urunler as cmu
LEFT JOIN cari as c on c.id=cmu.cari_id
LEFT JOIN uye_tanim as ut on ut.id=cmu.uye_id
INNER JOIN cari_mahsup as cm on cm.id=cmu.mahsup_id
WHERE
cmu.status=1 AND cmu.cari_key='$cari_key' AND cmu.mahsup_id='$mahsup_id'
");
                    if ($son_bilgiler > 0) {
                        echo json_encode($son_bilgiler);
                    } else {
                        echo 2;
                    }
                }
            } else {
                echo 2;
            }
        }
    }
}
if ($islem == "mahsup_fisi_eksilt_sql") {
    $id = $_POST["id"];

    $mahsup_bilgileri = DB::single_query("SELECT * FROM cari_mahsup_urunler WHERE status=1 AND id='$id'");
    if ($mahsup_bilgileri > 0) {
        $borc = $mahsup_bilgileri["borc"];
        $mahsup_id = $mahsup_bilgileri["mahsup_id"];
        $alacak = $mahsup_bilgileri["alacak"];
        $cari_id = $mahsup_bilgileri["cari_id"];
        $cari_borc_alacak = DB::single_query("SELECT * FROM cari WHERE status=1 AND id='$cari_id'");
        $yeni_arr = [
            'delete_userid' => $_SESSION["user_id"],
            'delete_datetime' => date("Y-m-d H:i:s"),
            'delete_detail' => 'Kullanıcı Mahsup Fişi Oluştururken Fişi Listeden Silmiştir',
            'status' => 0,
        ];
        $mahsup_sil = DB::update("cari_mahsup_urunler", "id", $id, $yeni_arr);
        if ($mahsup_sil) {
            $ana_mahsup = DB::single_query("SELECT * FROM cari_mahsup WHERE status=1 AND id='$mahsup_id'");
            if ($ana_mahsup > 0) {
                $toplam_borc = $ana_mahsup["toplam_borc"];
                $toplam_alacak = $ana_mahsup["toplam_alacak"];
                $yeni_alacak = floatval($toplam_alacak) - floatval($alacak);
                $yeni_borc = floatval($toplam_borc) - floatval($borc);
                $ana_mahsup_arr = [
                    'toplam_borc' => $yeni_borc,
                    'toplam_alacak' => $yeni_alacak,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $ana_mahsup_guncelle = DB::update("cari_mahsup", "id", $mahsup_id, $ana_mahsup_arr);
                if ($ana_mahsup_guncelle) {
                    $yeni_miktarlar = DB::single_query("SELECT * FROM cari_mahsup WHERE status=1 AND id='$mahsup_id'");
                    if ($yeni_miktarlar > 0) {
                        echo json_encode($yeni_miktarlar);
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
    } else {
        echo 2;
    }
}
if ($islem == "cariyi_iptal_et_sql") {
    $mahsup_id = $_POST["mahsup_id"];
    $mahsup_icerisindeki_urunler = DB::all_data("SELECT * FROM cari_mahsup_urunler WHERE status=1 AND mahsup_id='$mahsup_id'");
    if ($mahsup_icerisindeki_urunler > 0) {
        foreach ($mahsup_icerisindeki_urunler as $urunler) {
            $mahsup_borc = $urunler["borc"];
            $mahsup_alacak = $urunler["alacak"];
            $cari_id = $urunler["cari_id"];
            $cari_bilgisi = DB::single_query("SELECT * FROM cari WHERE status=1 AND id='$cari_id'");
            if ($cari_bilgisi > 0) {
                $cari_borc = $cari_bilgisi["borc"];
                $cari_alacak = $cari_bilgisi["alacak"];
                $yeni_borc = floatval($mahsup_borc) - floatval($cari_borc);
                $yeni_alacak = floatval($mahsup_alacak) - floatval($cari_alacak);
                $arr = [
                    'borc' => $yeni_borc,
                    'alacak' => $yeni_alacak,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $cari_guncelle = DB::update("cari", "id", $cari_id, $arr);
            } else {
                echo 2;
            }
        }
        $yeni_arr = [
            'delete_userid' => $_SESSION["user_id"],
            'status' => 0,
            'delete_datetime' => date("Y-m-d H:i:s"),
            'delete_detail' => "Kullanıcı Mahsup Oluşturmaktan Vazgeçmiştir"
        ];
        $mahsup_sil = DB::update("cari_mahsup", "id", $mahsup_id, $yeni_arr);
        if ($mahsup_sil) {
            echo 1;
        } else {
            echo 2;
        }
    } else {
        echo 2;
    }
}
if ($islem == "mahsup_fisini_kaydet") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");

    $id = $_POST["id"];
    $mahsup_onayla = DB::update("cari_mahsup", "id", $id, $_POST);
    if ($mahsup_onayla) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "secilen_kaydi_getir_mahsup") {
    $id = $_GET["id"];
    $verileri_cek = DB::single_query("
SELECT 
       cmu.*,c.cari_adi,c.cari_kodu,ut.uye_adi,ut.tc_no
FROM cari_mahsup_urunler as cmu
LEFT JOIN cari as c on c.id=cmu.cari_id
LEFT JOIN uye_tanim as ut on ut.id=cmu.uye_id
WHERE cmu.status=1 AND cmu.id='$id'");
    if ($verileri_cek > 0) {
        echo json_encode($verileri_cek);
    } else {
        echo 2;
    }
}
if ($islem == "mahsup_fis_guncelle_sql") {
    $cari_kodu = $_POST["cari_kodu"];
    unset($_POST["cari_kodu"]);

    $borc_fark = $_POST["borc_fark"];
    $alacak_fark = $_POST["alacak_fark"];
    $secilen_borc = $_POST["secilen_borc"];
    $secilen_alacak = $_POST["secilen_alacak"];

    $id = $_POST["mahsup_id"];
    $mahsup_urun_bilgileri = DB::single_query("SELECT * FROM cari_mahsup_urunler WHERE status=1 AND id='$id'");
    if ($mahsup_urun_bilgileri > 0) {
        $mahsup_id = $mahsup_urun_bilgileri["mahsup_id"];
        $mahsup_bilgileri = DB::single_query("SELECT * FROM cari_mahsup WHERE status=1 AND id='$mahsup_id'");
        if ($mahsup_bilgileri > 0) {
            $cari_id = $mahsup_urun_bilgileri["cari_id"];
            $toplam_borc = $mahsup_bilgileri["toplam_borc"];
            $toplam_alacak = $mahsup_bilgileri["toplam_alacak"];
            $yeni_toplam_borc = floatval($toplam_borc) + floatval($borc_fark);
            $yeni_toplam_alacak = floatval($toplam_alacak) + floatval($alacak_fark);
            $genel_arr = [
                'update_userid' => $_SESSION["user_id"],
                'update_datetime' => date("Y-m-d H:i:s"),
                'doviz_kuru' => $_POST["kur_fiyat"],
                'doviz_tur' => $_POST["doviz_tur"],
                'toplam_borc' => $yeni_toplam_borc,
                'toplam_alacak' => $yeni_toplam_alacak
            ];

            $genel_mahsup_guncelle = DB::update("cari_mahsup", "id", $mahsup_id, $genel_arr);
            if ($genel_mahsup_guncelle) {
                unset($_POST["borc_fark"]);
                unset($_POST["alacak_fark"]);
                unset($_POST["doviz_tur"]);
                unset($_POST["kur_fiyat"]);
                unset($_POST["mahsup_id"]);
                unset($_POST["secilen_alacak"]);
                unset($_POST["secilen_borc"]);
                $_POST["cari_id"] = 0;
                $_POST["uye_id"] = 0;
                $carimi = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_kodu='$cari_kodu'");
                if ($carimi > 0) {
                    $_POST["cari_id"] = $carimi["id"];
                }
                $uyemi = DB::single_query("SELECT * FROM uye_tanim WHERE status=1 AND tc_no='$cari_kodu'");
                if ($uyemi > 0) {
                    $_POST["uye_id"] = $uyemi["id"];
                }
                $mahsup_kalem_guncelle = DB::update("cari_mahsup_urunler", "id", $id, $_POST);
                if ($mahsup_kalem_guncelle) {
                    $son_bilgiler = DB::all_data("
SELECT
        cmu.*,c.cari_adi,c.cari_kodu,cm.toplam_borc,cm.toplam_alacak,cm.doviz_tur,cm.doviz_kuru,ut.uye_adi,ut.tc_no
FROM
        cari_mahsup_urunler as cmu
LEFT JOIN cari as c on c.id=cmu.cari_id
LEFT JOIN uye_tanim as ut on ut.id=cmu.uye_id
INNER JOIN cari_mahsup as cm on cm.id=cmu.mahsup_id
WHERE
cmu.status=1 AND cmu.cari_key='$cari_key' AND cmu.mahsup_id='$mahsup_id'
                            ");
                    if ($son_bilgiler > 0) {
                        echo json_encode($son_bilgiler);
                    } else {
                        echo 501;
                    }
                } else {
                    echo 507;
                }
            } else {
                echo 508;
            }
        } else {
            echo 509;
        }
    } else {
        echo 510;
    }
}
if ($islem == "mahsup_fislerini_getir") {
    $sql = "SELECT id,doviz_tur,belge_no,aciklama,islem_tarihi,ozel_kod,toplam_borc,toplam_alacak FROM cari_mahsup WHERE status=1 AND cari_key='$cari_key'";

    if (isset($_GET["bas_tarih"]) && isset($_GET["bit_tarih"])) {
        $bas_tarih = $_GET["bas_tarih"];
        $bit_tarih = $_GET["bit_tarih"];
        $sql .= " AND islem_tarihi BETWEEN '$bas_tarih 00:00:00' AND '$bit_tarih 23:59:59'";
    }

    $mahsuplar = DB::all_data($sql);
    if ($mahsuplar > 0) {
        echo json_encode($mahsuplar);
    } else {
        echo 2;
    }
}
if ($islem == "mahsup_acilis_sil_sql") {
    $id = $_POST["id"];
    $acilis_fisi_bilgileri = DB::all_data("SELECT * FROM cari_mahsup_urunler WHERE status=1 AND mahsup_id='$id'");
    if ($acilis_fisi_bilgileri > 0) {
        foreach ($acilis_fisi_bilgileri as $bilgiler) {
            $acilis_cari_id = $bilgiler["cari_id"];
            $acilis_miktar = $bilgiler["borc"];
            $acilis_alacak = $bilgiler["alacak"];
            $cari_envanter_bilgi = DB::single_query("SELECT * FROM cari WHERE status=1 AND id='$acilis_cari_id'");
            if ($cari_envanter_bilgi > 0) {
                $cari_borc = $cari_envanter_bilgi["borc"];
                $cari_alacak = $cari_envanter_bilgi["alacak"];
                $yeni_borc = floatval($cari_borc) - floatval($acilis_miktar);
                $yeni_alacak = floatval($cari_alacak) - floatval($acilis_alacak);
                $yeni_arr = [
                    'borc' => $yeni_borc,
                    'alacak' => $yeni_alacak,
                    'update_userid' => $_SESSION["user_id"],
                    'update_datetime' => date("Y-m-d H:i:s")
                ];
                $envanter_bilgi_guncelle = DB::update("cari", "id", $acilis_cari_id, $yeni_arr);
            } else {
                echo 2;
            }
        }
        if ($envanter_bilgi_guncelle) {
            $acilis_arr = [
                'status' => 0,
                'delete_userid' => $_SESSION["user_id"],
                'delete_detail' => $_POST["delete_detail"],
                'delete_datetime' => date("Y-m-d H:i:s")
            ];
            $acilis_fisi_sil = DB::update("cari_mahsup", "id", $id, $acilis_arr);
            if ($acilis_fisi_sil) {
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
}
if ($islem == "cari_kodunun_bilgilerini_getir_sql") {
    $ek_kod = "";
    if ($_SESSION["sube_key"] != 0) {
        $ek_kod = " AND sube_key='$sube_key'";
    }
    $cari_kodu = $_GET["cari_kodu"];
    $cari_kodu = DB::single_query("SELECT cari_kodu,id,cari_adi FROM cari WHERE cari_kodu='$cari_kodu' AND status=1 AND cari_key='$cari_key' $ek_kod");
    if ($cari_kodu > 0) {
        echo json_encode($cari_kodu);
    } else {
        echo 2;
    }
}
if ($islem == "mahsup_bilgilerini_getir_sql") {
    $id = $_GET["id"];
    $ana_mahsup_bilgileri = DB::single_query("SELECT * FROM cari_mahsup WHERE status=1 AND id='$id'");
    if ($ana_mahsup_bilgileri > 0) {
        echo json_encode($ana_mahsup_bilgileri);
    } else {
        echo 2;
    }
}
if ($islem == "mahsup_urunleri_getir") {
    $mahsup_id = $_GET["mahsup_id"];
    $mahsup_bilgilerini_getir = DB::all_data("
SELECT
        cmu.*,c.cari_adi,c.cari_kodu,cm.toplam_borc,cm.toplam_alacak,cm.doviz_tur,cm.doviz_kuru,ut.uye_adi,ut.tc_no
FROM
        cari_mahsup_urunler as cmu
LEFT JOIN cari as c on c.id=cmu.cari_id
LEFT JOIN uye_tanim as ut on ut.id=cmu.uye_id
INNER JOIN cari_mahsup as cm on cm.id=cmu.mahsup_id
WHERE
cmu.status=1 AND cmu.cari_key='$cari_key' AND cmu.mahsup_id='$mahsup_id' ");
    if ($mahsup_bilgilerini_getir > 0) {
        echo json_encode($mahsup_bilgilerini_getir);
    } else {
        echo 2;
    }
}
if ($islem == "cari_bilgilerini_getir_sql") {
    $verileri_getir = DB::all_data("
SELECT 
c.cari_turu,
c.cari_kodu,
c.cari_adi,
c.cari_unvani,
c.vergi_dairesi,
c.vergi_no,
b.bilanco_kodu,
c.cari_grubu,
c.vade_gunu,
c.telefon,
c.e_mail,
c.yetkili_adi1,
c.yetkili_ad2,
c.yetkili_tel1,
c.yetkili_tel2,
c.yetkili_mail1,
c.yetkili_mail,
cab.adres as cari_adres,
cab.ozel_kod1,
cab.ozel_kod2,
cab.ozel_kod3,
cbb.banka_adi,
cbb.sube_adi as banka_sube,
cbb.iban_no,
il.il_adi,
cgt.cari_grup_adi as cari_grubu,
ctt.cari_turu_adi as cari_turu
FROM cari as c 
LEFT JOIN cari_adres_bilgileri as cab on cab.cari_id=c.id
LEFT JOIN cari_banka_bilgileri as cbb on cbb.cari_id=c.id AND cbb.status=1
LEFT JOIN cari_turleri_tanim as ctt on ctt.id=c.cari_turu
LEFT JOIN cari_grubu_tanim as cgt on cgt.id=c.cari_grubu
LEFT JOIN bilancolar as b on b.id=c.bilanco_id
LEFT JOIN il on il.id=cab.il
WHERE c.status=1 AND c.cari_key='$cari_key'
GROUP BY c.id
");
    if ($verileri_getir > 0) {
        echo json_encode($verileri_getir);
    } else {
        echo 2;
    }
}
if ($islem == "yeni_cari_turu_tanimla_sql") {
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $cari_turu_ekle = DB::insert("cari_turleri_tanim", $_POST);
    if ($cari_turu_ekle) {
        echo 2;
    } else {
        echo 1;
    }
}
if ($islem == "cari_turleri_getir_sql") {
    $tum_cari_turleri = DB::all_data("SELECT * FROM cari_turleri_tanim WHERE status=1 AND cari_key='$cari_key'");
    if ($tum_cari_turleri > 0) {
        echo json_encode($tum_cari_turleri);
    } else {
        echo 2;
    }
}
if ($islem == "cari_turu_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $id = $_POST["id"];
    $cariler = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' AND cari_turu='$id'");
    if ($cariler > 0) {
        echo 300;
    } else {
        $cari_tanim_sil = DB::update("cari_turleri_tanim", "id", $_POST["id"], $_POST);
        if ($cari_tanim_sil) {
            echo 1;
        } else {
            echo 2;
        }
    }
}
if ($islem == "cari_grubu_tanimla_sql") {
    $_POST["insert_datetime"] = date("Y-m-d H:i:s");
    $_POST["insert_userid"] = $_SESSION["user_id"];
    $cari_turu_ekle = DB::insert("cari_grubu_tanim", $_POST);
    if ($cari_turu_ekle) {
        echo 2;
    } else {
        echo 1;
    }
}
if ($islem == "cari_gruplarini_getir_sql") {
    $tum_cari_turleri = DB::all_data("SELECT * FROM cari_grubu_tanim WHERE status=1 AND cari_key='$cari_key'");
    if ($tum_cari_turleri > 0) {
        echo json_encode($tum_cari_turleri);
    } else {
        echo 2;
    }
}
if ($islem == "cari_grubu_sil_sql") {
    $_POST["delete_userid"] = $_SESSION["user_id"];
    $_POST["delete_datetime"] = date("Y-m-d H:i:s");
    $_POST["status"] = 0;
    $id = $_POST["id"];
    $carisi_varmi = DB::single_query("SELECT * FROM cari WHERE status=1 AND cari_key='$cari_key' AND cari_grubu='$id'");
    if ($carisi_varmi > 0) {
        echo 300;
    } else {
        $cari_tanim_sil = DB::update("cari_grubu_tanim", "id", $_POST["id"], $_POST);
        if ($cari_tanim_sil) {
            echo 1;
        } else {
            echo 2;
        }
    }

}
if ($islem == "acilis_bilgilerini_getir_sql") {
    $id = $_GET["id"];
    $bilgileri_cek = DB::single_query("
SELECT 
       caf.*,
       c.cari_adi,
       c.cari_kodu
FROM
     cari_acilis_fisleri as caf
INNER JOIN cari as c on c.id=caf.cari_id
WHERE caf.status=1 AND caf.cari_key='$cari_key' AND caf.id='$id'");
    if ($bilgileri_cek > 0) {
        echo json_encode($bilgileri_cek);
    } else {
        echo 2;
    }
}
if ($islem == "acilis_fisi_guncelle_sql") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DB::update("cari_acilis_fisleri", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "cari_turu_adi_degistir") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DB::update("cari_turleri_tanim", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}
if ($islem == "cari_grubu_adi_degistir") {
    $_POST["update_userid"] = $_SESSION["user_id"];
    $_POST["update_datetime"] = date("Y-m-d H:i:s");
    $guncelle = DB::update("cari_grubu_tanim", "id", $_POST["id"], $_POST);
    if ($guncelle) {
        echo 1;
    } else {
        echo 2;
    }
}