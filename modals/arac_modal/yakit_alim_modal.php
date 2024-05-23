<?php

$islem = $_GET["islem"];


if ($islem == "yakit_fisi_giris_modal") {
    ?>
    <style>
        #binek_yakit_alim_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="binek_yakit_alim_modal" data-bs-keyboard="false" data-backdrop="static"
         role="dialog">
        <div class="modal-dialog" style="width: 70%; max-width: 70%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="konteyner_yakit_cikis_vazgec"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>BİNEK ARAÇ YAKIT FİŞ ÇIKIŞI
                            </div>
                        </div>
                        <div class="mt-4"></div>
                        <div class="ibox-title" style="background-color: #9DB2BF;color: white;text-align: center">
                            <span>Araç Bilgileri</span>
                        </div>
                        <div class="modal-body">
                            <div class="konteyner_irasliye_plakalari_getir_div"></div>
                            <div class="konteyner_irasliye_suruculeri_getir_div"></div>
                            <div class="konteyner_yakit_cikis_fisi_div"></div>
                            <div class="konteyner_yakit_cikis_seferleri_div"></div>
                            <div class="konteyner_hgs_kasalar"></div>
                            <div class="konteyner_hgs_bankalar"></div>
                            <div class="konteyner_hgs_kartlar"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Alım Yeri</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="alim_yeri">
                                                <option value="">Alım Yeri Seçiniz...</option>
                                                <option value="İstasyondan">İstasyondan</option>
                                                <option value="Depodan">Depodan</option>
                                                <option value="Peşin Alım">Peşin Alım</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Fiş No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="fis_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Tarih</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>" id="tarih"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Yakıt Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="yakit_tipi">
                                                <option value="">Yakıt Tipi Seçiniz...</option>
                                                <option value="EURO DİZEL">EURO DİZEL</option>
                                                <option selected value="DİZEL">DİZEL</option>
                                                <option value="LPG">LPG</option>
                                                <option value="BENZİN">BENZİN</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Depo Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <select class="custom-select custom-select-sm" id="yakit_depo_id">
                                                    <option value="">Depo Seçiniz...</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Plaka</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="plaka_id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="irsaliye_plakalari_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Sürücü</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="surucu_id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="irsaliye_icin_suruculeri_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>İstasyon Kodu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="istasyon_kodu">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="istasyon_kodu_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>İstasyon Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" disabled class="form-control form-control-sm"
                                                   id="istasyon_adi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Ödeme Yöntemi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="odeme_yontemi">
                                                <option value="">Ödeme Yöntemi Seçiniz...</option>
                                                <option value="Nakit">Nakit</option>
                                                <option value="Havale">Havale</option>
                                                <option value="Kart">Kart</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row kart_show" style="display: none;">
                                        <div class="col-md-4">
                                            <label>Kredi Kartı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       placeholder="Kredi Kartı Kodu..."
                                                       id="kredi_kart_id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="kartlari_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row banka_show" style="display: none;">
                                        <div class="col-md-4">
                                            <label>Banka</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="banka_id"
                                                       placeholder="Banka Kodu...">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="bankalari_getir_button">
                                                        <i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row kasa_show" style="display: none;">
                                        <div class="col-md-4">
                                            <label>Kasa</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="kasa_id"
                                                       placeholder="Kasa Kodu...">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="kasa_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-title" style="background-color: #9DB2BF;color: white;text-align: center">
                            <span>Yakıt Bilgileri</span>
                        </div>
                        <div class="col-12 row mt-3">
                            <div class="col-6">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Son Alınan KM</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" value="0,00"
                                               style="text-align: right" id="son_alinan_km">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Miktar (LT)</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" value="0,00"
                                               style="text-align: right" id="miktar">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Litre Fiyatı</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" value="0,00"
                                               style="text-align: right" id="litre_fiyati">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>TL Tutar</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" value="0,00"
                                               style="text-align: right" id="tl_tutar">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Yakıt Alım KM</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" value="0,00"
                                               style="text-align: right" id="yakit_km">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Fark KM</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" disabled class="form-control form-control-sm" value="0,00"
                                               style="text-align: right" id="fark_km">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Yakıt Tüketimi</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" disabled class="form-control form-control-sm" value="0,00"
                                               style="text-align: right" id="yakit_tuketimi">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Açıklama</label>
                                    </div>
                                    <div class="col-7">
                                        <input type="text" class="form-control form-control-sm"
                                               id="yakit_cikis_aciklamasi">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="konteyner_yakit_cikis_vazgec"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="yakit_cikis_fis_kaydet_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("body").off("change", "#odeme_yontemi").on("change", "#odeme_yontemi", function () {
            let val = $(this).val();
            if (val == "Nakit") {
                $(".kasa_show").show();
                $("#kredi_kart_id").val("");
                $("#kredi_kart_id").attr("data-id", "");
                $(".kart_show").hide();
                $("#banka_id").val("");
                $("#banka_id").attr("data-id", "");
                $(".banka_show").hide();
            } else if (val == "Havale") {
                $(".kasa_show").hide();
                $(".kart_show").hide();
                $("#kasa_id").val("");
                $("#kasa_id").attr("data-id", "");
                $(".banka_show").show();
                $("#kredi_kart_id").val("");
                $("#kredi_kart_id").attr("data-id", "");
            } else if (val == "Kart") {
                $(".kasa_show").hide();
                $(".kart_show").show();
                $("#banka_id").val("");
                $("#banka_id").attr("data-id", "");
                $(".banka_show").hide();
                $("#kasa_id").val("");
                $("#kasa_id").attr("data-id", "");
            } else {
                $("#kredi_kart_id").val("");
                $("#kredi_kart_id").attr("data-id", "");
                $(".kasa_show").hide();
                $(".kart_show").hide();
                $("#banka_id").val("");
                $("#banka_id").attr("data-id", "");
                $(".banka_show").hide();
                $("#kasa_id").val("");
                $("#kasa_id").attr("data-id", "");
            }
        });

        $.get("konteyner/controller/yakit_controller/sql.php?islem=depolari_getir_sql", function (response) {
            if (response != 2) {
                var json = JSON.parse(response);
                json.forEach(function (item) {
                    $("#yakit_depo_id").append("" +
                        "<option value='" + item.id + "'>" + item.depo_adi + "</option>" +
                        "");
                });
            }
        })

        $("body").off("keyup", "#istasyon_kodu").on("keyup", "#istasyon_kodu", function () {
            let val = $(this).val();
            $.get("konteyner/controller/yakit_controller/sql.php?islem=girilen_istasyon_bilgilerini_getir_sql", {cari_kodu: val}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#istasyon_kodu").val(item.cari_kodu);
                    $("#istasyon_kodu").attr("data-id", item.id);
                    $("#istasyon_adi").val(item.cari_adi);
                } else {
                    $("#istasyon_kodu").attr("data-id", "");
                    $("#istasyon_adi").val("");
                }
            });
        });

        $("body").off("keyup", "#plaka_id").on("keyup", "#plaka_id", function () {
            let val = $(this).val();
            $.get("controller/arac_controller/sql.php?islem=arac_bilgilerini_getir_sql", {plaka_no: val}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#plaka_id").val(item.arac_plaka);
                    $("#plaka_id").attr("data-id", item.id);
                    $("#surucu_id").val(item.surucu_adi);
                    $("#surucu_id").attr("data-id", item.surucu_id);
                    let id = item.id;
                    $.get("controller/arac_controller/sql.php?islem=son_alinan_km_sql", {plaka_id: id}, function (response) {
                        if (response != 2) {
                            var item = JSON.parse(response);
                            let yakit_km = item.yakit_km;
                            yakit_km = parseFloat(yakit_km);
                            yakit_km = yakit_km.toLocaleString("tr-TR", {
                                maximumFractionDigits: 2,
                                minimumFractionDigits: 2
                            });
                            $("#son_alinan_km").val(yakit_km);
                        } else {
                            $.get("controller/arac_controller/sql.php?islem=aracin_guncel_km_si", {id: id}, function (response) {
                                if (response != 2) {
                                    var item = JSON.parse(response);
                                    let yakit_km = item.guncel_km;
                                    yakit_km = parseFloat(yakit_km);
                                    yakit_km = yakit_km.toLocaleString("tr-TR", {
                                        maximumFractionDigits: 2,
                                        minimumFractionDigits: 2
                                    });
                                    $("#son_alinan_km").val(yakit_km);
                                }
                            })
                        }
                    })
                } else {
                    $("#plaka_id").attr("data-id", "");
                    $("#surucu_id").val("");
                    $("#surucu_id").attr("data-id", "");
                }
            })
        });

        $("body").off("change", "#alim_yeri").on("change", "#alim_yeri", function () {
            let val = $(this).val();
            if (val == "Depodan") {
                $("#istasyon_kodu_getir_button").prop("disabled", true);
                $("#istasyon_kodu").prop("disabled", true);
                $("#istasyon_kodu").val("");
                $("#istasyon_kodu").attr("data-id", "");
                $("#odeme_yontemi").prop("disabled", true);
                $("#odeme_yontemi").val("");
                $("#istasyon_adi").val("");
                $("#yakit_depo_id").prop("disabled", false);
                $(".kasa_show").hide();
                $(".kart_show").hide();
                $("#kasa_id").val("");
                $("#kasa_id").attr("data-id", "");
                $("#kredi_kart_id").val("");
                $("#kredi_kart_id").attr("data-id", "");
                $("#banka_id").val("");
                $("#banka_id").attr("data-id", "");
                $(".banka_show").hide();
            } else if (val == "İstasyondan") {
                $("#istasyon_kodu_getir_button").prop("disabled", false);
                $("#istasyon_kodu").prop("disabled", false);
                $("#yakit_depo_id").prop("disabled", true);
                $("#yakit_depo_id").val("");
                $("#odeme_yontemi").prop("disabled", true);
                $("#odeme_yontemi").val("");
                $(".kasa_show").hide();
                $(".kart_show").hide();
                $("#kasa_id").val("");
                $("#kasa_id").attr("data-id", "");
                $("#kredi_kart_id").val("");
                $("#kredi_kart_id").attr("data-id", "");
                $("#banka_id").val("");
                $("#banka_id").attr("data-id", "");
                $(".banka_show").hide();
            } else {
                $("#istasyon_adi").val("");
                $("#istasyon_kodu_getir_button").prop("disabled", true);
                $("#istasyon_kodu").prop("disabled", true);
                $("#istasyon_kodu").val("");
                $("#istasyon_kodu").attr("data-id", "");
                $("#yakit_depo_id").prop("disabled", true);
                $("#yakit_depo_id").val("");
                $("#odeme_yontemi").prop("disabled", false);
                $("#odeme_yontemi").val("");
            }
        });

        $('input').click(function () {
            $(this).select();
        });
        $("body").off("click", "#kasa_getir_button").on("click", "#kasa_getir_button", function () {
            $.get("konteyner/modals/arac_modal/hgs_gider_giris.php?islem=kasalari_getir_modal", function (getModal) {
                $(".konteyner_hgs_kasalar").html("");
                $(".konteyner_hgs_kasalar").html(getModal);
            })
        });
        $("body").off("click", "#bankalari_getir_button").on("click", "#bankalari_getir_button", function () {
            $.get("konteyner/modals/arac_modal/hgs_gider_giris.php?islem=bankalari_getir_modal", function (getModal) {
                $(".konteyner_hgs_bankalar").html("");
                $(".konteyner_hgs_bankalar").html(getModal);
            })
        });
        $("body").off("click", "#kartlari_getir_button").on("click", "#kartlari_getir_button", function () {
            $.get("konteyner/modals/arac_modal/hgs_gider_giris.php?islem=kartlari_getir_modal", function (getModal) {
                $(".konteyner_hgs_kartlar").html("");
                $(".konteyner_hgs_kartlar").html(getModal);
            })
        });

        $("body").off("click", "#yakit_cikis_fis_kaydet_button").on("click", "#yakit_cikis_fis_kaydet_button", function () {
            let alim_yeri = $("#alim_yeri").val();
            let fis_no = $("#fis_no").val();
            let tarih = $("#tarih").val();
            let plaka_id = $("#plaka_id").attr("data-id");
            let yakit_depo_id = $("#yakit_depo_id").val();
            let istasyon_id = $("#istasyon_kodu").attr("data-id");
            let son_alinan_km = $("#son_alinan_km").val();
            son_alinan_km = son_alinan_km.replace(/\./g, "").replace(",", ".");
            son_alinan_km = parseFloat(son_alinan_km);
            let yakit_km = $("#yakit_km").val();
            yakit_km = yakit_km.replace(/\./g, "").replace(",", ".");
            yakit_km = parseFloat(yakit_km);
            let miktar = $("#miktar").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            let tl_tutar = $("#tl_tutar").val();
            tl_tutar = tl_tutar.replace(/\./g, "").replace(",", ".");
            tl_tutar = parseFloat(tl_tutar);
            let fark_km = $("#fark_km").val();
            fark_km = fark_km.replace(/\./g, "").replace(",", ".");
            fark_km = parseFloat(fark_km);
            let yakit_tuketim = $("#yakit_tuketimi").val();
            yakit_tuketim = yakit_tuketim.replace(/\./g, "").replace(",", ".");
            yakit_tuketim = parseFloat(yakit_tuketim);
            let litre_fiyati = $("#litre_fiyati").val();
            litre_fiyati = litre_fiyati.replace(/\./g, "").replace(",", ".");
            litre_fiyati = parseFloat(litre_fiyati);
            let tasima_kg = $("#tasima_kg").val();
            let surucu_id = $("#surucu_id").attr("data-id");
            let surucu_adi = $("#surucu_id").val();
            let yakit_tipi = $("#yakit_tipi").val();
            let aciklama = $("#yakit_cikis_aciklamasi").val();
            let banka_id = $("#banka_id").attr("data-id");
            let kasa_id = $("#kasa_id").attr("data-id");
            let kart_id = $("#kredi_kart_id").attr("data-id");
            let odeme_yontem = $("#odeme_yontemi").val();

            if (alim_yeri == "İstasyondan") {
                if (istasyon_id == undefined || istasyon_id == "") {
                    Swal.fire(
                        "Uyarı!",
                        'Alım Yeriniz İstasyon Bir İstasyon Seçiniz...',
                        'warning'
                    );
                } else if (plaka_id == "" || plaka_id == undefined) {
                    Swal.fire(
                        "Uyarı!",
                        'Lütfen Plaka Belirtiniz...',
                        'warning'
                    );
                } else {
                    $.ajax({
                        url: "controller/arac_controller/sql.php?islem=yakit_cikis_fisi_kaydet_sql",
                        type: "POST",
                        data: {
                            alim_yeri: alim_yeri,
                            plaka_id: plaka_id,
                            tarih: tarih,
                            banka_id: banka_id,
                            surucu_adi: surucu_adi,
                            kasa_id: kasa_id,
                            kart_id: kart_id,
                            fis_no: fis_no,
                            istasyon_id: istasyon_id,
                            son_alim_km: son_alinan_km,
                            odeme_yontem: odeme_yontem,
                            yakit_km: yakit_km,
                            miktar: miktar,
                            tl_tutar: tl_tutar,
                            fark_km: fark_km,
                            yakit_tuketim: yakit_tuketim,
                            litre_fiyati: litre_fiyati,
                            tasima_kg: tasima_kg,
                            surucu_id: surucu_id,
                            yakit_tipi: yakit_tipi,
                            depo_id: yakit_depo_id,
                            aciklama: aciklama
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı',
                                    'Yakıt Fişi Kaydedildi',
                                    'success'
                                );
                                $.get("view/yakit_alim_fisleri.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                });
                                $.get("view/yakit_alim_fisleri.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                });
                                $("#binek_yakit_alim_modal").modal("hide");
                            } else {
                                Swal.fire(
                                    'Oops...',
                                    'Bilinmeyen Bir Hata Oluştu',
                                    'error'
                                );
                                $.get("view/yakit_alim_fisleri.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                });
                                $.get("view/yakit_alim_fisleri.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                });
                                $("#binek_yakit_alim_modal").modal("hide");
                            }
                        }
                    });
                }
            } else {
                if (plaka_id == "" || plaka_id == undefined) {
                    Swal.fire(
                        "Uyarı!",
                        'Lütfen Plaka Belirtiniz...',
                        'warning'
                    );
                } else {
                    $.ajax({
                        url: "controller/arac_controller/sql.php?islem=yakit_cikis_fisi_kaydet_sql",
                        type: "POST",
                        data: {
                            alim_yeri: alim_yeri,
                            plaka_id: plaka_id,
                            tarih: tarih,
                            surucu_adi: surucu_adi,
                            banka_id: banka_id,
                            kasa_id: kasa_id,
                            kart_id: kart_id,
                            fis_no: fis_no,
                            istasyon_id: istasyon_id,
                            son_alim_km: son_alinan_km,
                            odeme_yontem: odeme_yontem,
                            yakit_km: yakit_km,
                            miktar: miktar,
                            tl_tutar: tl_tutar,
                            fark_km: fark_km,
                            yakit_tuketim: yakit_tuketim,
                            litre_fiyati: litre_fiyati,
                            tasima_kg: tasima_kg,
                            surucu_id: surucu_id,
                            yakit_tipi: yakit_tipi,
                            depo_id: yakit_depo_id,
                            aciklama: aciklama
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı',
                                    'Yakıt Fişi Kaydedildi',
                                    'success'
                                );
                                $.get("view/yakit_alim_fisleri.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                });
                                $.get("view/yakit_alim_fisleri.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                });
                                $("#binek_yakit_alim_modal").modal("hide");
                            } else {
                                Swal.fire(
                                    'Oops...',
                                    'Bilinmeyen Bir Hata Oluştu',
                                    'error'
                                );
                                $.get("view/yakit_alim_fisleri.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                });
                                $.get("view/yakit_alim_fisleri.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                });
                                $("#binek_yakit_alim_modal").modal("hide");
                            }
                        }
                    });
                }
            }
        });

        $("body").off("focusout", "#son_alinan_km").on("focusout", "#son_alinan_km", function () {
            let yakit_alim_km = $("#yakit_km").val();
            yakit_alim_km = yakit_alim_km.replace(/\./g, "").replace(",", ".");
            yakit_alim_km = parseFloat(yakit_alim_km);
            if (isNaN(yakit_alim_km)) {
                yakit_alim_km = 0
            }
            let son_km = $(this).val();
            son_km = son_km.replace(/\./g, "").replace(",", ".");
            son_km = parseFloat(son_km);
            if (isNaN(son_km)) {
                son_km = 0
            }
            let fark_km = yakit_alim_km - son_km;

            // YAKIT TÜKETİM HESABI
            let miktar = $("#miktar").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            if (isNaN(miktar)) {
                miktar = 0
            }
            let baz_yakit_tuketim = miktar / fark_km;
            baz_yakit_tuketim = baz_yakit_tuketim * 100;
            if (isNaN(baz_yakit_tuketim)) {
                baz_yakit_tuketim = 0
            }
            $("#yakit_tuketimi").val(baz_yakit_tuketim.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));


            $("#fark_km").val(fark_km.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            $(this).val(son_km.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
            $("#yakit_km").focus();
            $("#yakit_km").select();
        });

        $("body").off("focusout", "#yakit_km").on("focusout", "#yakit_km", function () {
            let yakit_alim_km = $(this).val();
            yakit_alim_km = yakit_alim_km.replace(/\./g, "").replace(",", ".");
            yakit_alim_km = parseFloat(yakit_alim_km);
            if (isNaN(yakit_alim_km)) {
                yakit_alim_km = 0
            }
            let son_km = $("#son_alinan_km").val();
            son_km = son_km.replace(/\./g, "").replace(",", ".");
            son_km = parseFloat(son_km);
            if (isNaN(son_km)) {
                son_km = 0
            }
            let fark_km = yakit_alim_km - son_km;

            let miktar = $("#miktar").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            if (isNaN(miktar)) {
                miktar = 0
            }
            let baz_yakit_tuketim = miktar / fark_km;
            baz_yakit_tuketim = baz_yakit_tuketim * 100;
            if (isNaN(baz_yakit_tuketim)) {
                baz_yakit_tuketim = 0
            }
            $("#yakit_tuketimi").val(baz_yakit_tuketim.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));


            $("#fark_km").val(fark_km.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            $(this).val(yakit_alim_km.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
            $("#miktar").focus();
            $("#miktar").select();
        });

        $("body").off("focusout", "#tl_tutar").on("focusout", "#tl_tutar", function () {
            $("#tasima_kg").focus();
            $("#tasima_kg").select();
        });


        $("body").off("focusout", "#litre_fiyati").on("focusout", "#litre_fiyati", function () {
            let litre_fiyat = $(this).val();
            litre_fiyat = litre_fiyat.replace(/\./g, "").replace(",", ".");
            litre_fiyat = parseFloat(litre_fiyat);
            if (isNaN(litre_fiyat)) {
                litre_fiyat = 0
            }

            let miktar = $("#miktar").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            if (isNaN(miktar)) {
                miktar = 0
            }

            let tl_tutar = miktar * litre_fiyat;
            $("#tl_tutar").val(tl_tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            $(this).val(litre_fiyat.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });


        $("body").off("focusout", "#miktar").on("focusout", "#miktar", function () {


            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }

            // YAKIT TÜKETİM HESABI

            let yakit_alim_km = $("#yakit_km").val();
            yakit_alim_km = yakit_alim_km.replace(/\./g, "").replace(",", ".");
            yakit_alim_km = parseFloat(yakit_alim_km);
            if (isNaN(yakit_alim_km)) {
                yakit_alim_km = 0
            }
            let son_km = $("#son_alinan_km").val();
            son_km = son_km.replace(/\./g, "").replace(",", ".");
            son_km = parseFloat(son_km);
            if (isNaN(son_km)) {
                son_km = 0
            }
            let fark_km = yakit_alim_km - son_km;

            let baz_yakit_tuketim = val / fark_km;
            baz_yakit_tuketim = baz_yakit_tuketim * 100;
            if (isNaN(baz_yakit_tuketim)) {
                baz_yakit_tuketim = 0
            }
            $("#yakit_tuketimi").val(baz_yakit_tuketim.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));


            $("#fark_km").val(fark_km.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            $(this).val(yakit_alim_km.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));


            let litre_fiyati = $("#litre_fiyati").val();
            litre_fiyati = litre_fiyati.replace(/\./g, "").replace(",", ".");
            litre_fiyati = parseFloat(litre_fiyati);

            if (isNaN(litre_fiyati)) {
                litre_fiyati = 0
            }

            let tl_tutar = litre_fiyati * val;
            $("#tl_tutar").val(tl_tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));

            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));

        });

        $("body").off("click", "#irsaliye_plakalari_getir_button").on("click", "#irsaliye_plakalari_getir_button", function () {
            $.get("modals/arac_modal/yakit_alim_modal.php?islem=irsaliye_plakalari_getir", function (getModal) {
                $(".konteyner_irasliye_plakalari_getir_div").html("");
                $(".konteyner_irasliye_plakalari_getir_div").html(getModal);
            });
        });

        $("body").off("click", "#irsaliye_icin_suruculeri_getir_button").on("click", "#irsaliye_icin_suruculeri_getir_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=irsaliye_icin_suruculeri_getir", function (getModal) {
                $(".konteyner_irasliye_suruculeri_getir_div").html("");
                $(".konteyner_irasliye_suruculeri_getir_div").html(getModal);
            });
        });

        $("body").off("click", "#istasyon_kodu_getir_button").on("click", "#istasyon_kodu_getir_button", function () {
            $.get("konteyner/modals/yakit_modal/ozmal_yakit_cikis.php?islem=istasyonlari_modal_getir", function (getModal) {
                $(".konteyner_yakit_cikis_fisi_div").html("");
                $(".konteyner_yakit_cikis_fisi_div").html(getModal);
            });
        });


        $("body").off("click", "#sefer_kodlarini_getir_button").on("click", "#sefer_kodlarini_getir_button", function () {
            let plaka_id = $("#plaka_id").attr("data-id");
            if (plaka_id == undefined || plaka_id == "") {
                Swal.fire(
                    'Uyarı!',
                    'Lütfen Bir Plaka Seçiniz...',
                    'warning'
                );
            } else {
                $.get("konteyner/modals/yakit_modal/ozmal_yakit_cikis.php?islem=yakita_baglanacak_fisleri_getir", {plaka_id: plaka_id}, function (getModal) {
                    $(".konteyner_yakit_cikis_seferleri_div").html("");
                    $(".konteyner_yakit_cikis_seferleri_div").html(getModal);
                });
            }

        });

        $(document).ready(function () {
            $("#binek_yakit_alim_modal").modal("show");

        });

        $("body").off("click", "#konteyner_yakit_cikis_vazgec").on("click", "#konteyner_yakit_cikis_vazgec", function () {
            $("#binek_yakit_alim_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "irsaliye_plakalari_getir") {
    ?>
    <div class="modal fade" id="konteyner_irsaliye_plakalar_modal"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 55%; max-width: 55%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">PLAKALARI GETİR
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="aktarma_plakalar_listesi">
                            <thead>
                            <tr>
                                <th id="click1">Plaka No</th>
                                <th id="click1">Sürücü Adı</th>
                                <th id="click1">Muayene Tarihi</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('input').click(function () {
            $(this).select();
        });
        var aktarma_plakalar = "";
        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#konteyner_irsaliye_plakalar_modal").modal("hide");
        })
        $(document).ready(function () {
            $("#konteyner_irsaliye_plakalar_modal").modal("show");

            setTimeout(function () {

                $("#click1").trigger("click");

            }, 300);

            aktarma_plakalar = $('#aktarma_plakalar_listesi').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                paging: false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "arac_plaka"},
                    {'data': "surucu_adi"},
                    {'data': "muayene_tarihi"}
                ],
                createdRow: function (row) {
                    $(row).addClass("plakalar_select");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                    $(row).find('td').eq(2).css('text-align', 'left');
                    $(row).find('td').eq(3).css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                    $(row).attr("surucu_id", data.surucu_id);
                }
            })
            $.get("controller/arac_controller/sql.php?islem=binekleri_getir_sql", {modul: "<?=$_GET["modul"]?>"}, function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    aktarma_plakalar.rows.add(json).draw(false);
                }
            })

        })


        $("body").off("click", ".plakalar_select").on("click", ".plakalar_select", function () {
            var id = $(this).attr("data-id");
            let plaka_no = $(this).find("td").eq(0).text();
            let surucu_adi = $(this).find("td").eq(1).text();
            let surucu_id = $(this).attr("surucu_id");
            $("#plaka_id").val(plaka_no);
            $("#plaka_id").attr("data-id", id);
            $("#plaka_no_input").val(plaka_no);
            $("#plaka_no_input").attr("data-id", id);
            $("#surucu_id").val(surucu_adi);
            $("#surucu_id").attr("data-id", surucu_id);
            $.get("controller/arac_controller/sql.php?islem=son_alinan_km_sql", {
                plaka_id: id,
                tarih: $("#tarih").val()
            }, function (response) {
                if (response != 2) {
                    var item = JSON.parse(response);
                    let yakit_km = item.yakit_km;
                    yakit_km = parseFloat(yakit_km);
                    yakit_km = yakit_km.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });
                    $("#son_alinan_km").val(yakit_km);
                } else {
                    $.get("controller/arac_controller/sql.php?islem=aracin_guncel_km_si", {id: id}, function (response) {
                        if (response != 2) {
                            var item = JSON.parse(response);
                            let yakit_km = item.guncel_km;
                            yakit_km = parseFloat(yakit_km);
                            yakit_km = yakit_km.toLocaleString("tr-TR", {
                                maximumFractionDigits: 2,
                                minimumFractionDigits: 2
                            });
                            $("#son_alinan_km").val(yakit_km);
                        }
                    })
                }
            })
            $("#konteyner_irsaliye_plakalar_modal").modal("hide");
        })

    </script>
    <?php
}
if ($islem == "yakit_alim_guncelle_modal") {
    ?>
    <style>
        #binek_yakit_alim_guncelle_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="binek_yakit_alim_guncelle_modal" data-bs-keyboard="false" data-backdrop="static"
         role="dialog">
        <div class="modal-dialog" style="width: 70%; max-width: 70%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="konteyner_yakit_cikis_vazgec"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>BİNEK ARAÇ YAKIT FİŞ ÇIKIŞI
                                GÜNCELLE
                            </div>
                        </div>
                        <div class="mt-4"></div>
                        <div class="ibox-title" style="background-color: #9DB2BF;color: white;text-align: center">
                            <span>Araç Bilgileri</span>
                        </div>
                        <div class="modal-body">
                            <div class="konteyner_irasliye_plakalari_getir_div"></div>
                            <div class="konteyner_irasliye_suruculeri_getir_div"></div>
                            <div class="konteyner_yakit_cikis_fisi_div"></div>
                            <div class="konteyner_yakit_cikis_seferleri_div"></div>
                            <div class="konteyner_hgs_kasalar"></div>
                            <div class="konteyner_hgs_bankalar"></div>
                            <div class="konteyner_hgs_kartlar"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Alım Yeri</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="alim_yeri">
                                                <option value="">Alım Yeri Seçiniz...</option>
                                                <option value="İstasyondan">İstasyondan</option>
                                                <option value="Depodan">Depodan</option>
                                                <option value="Peşin Alım">Peşin Alım</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Fiş No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="fis_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Tarih</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>" id="tarih"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Yakıt Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="yakit_tipi">
                                                <option value="">Yakıt Tipi Seçiniz...</option>
                                                <option value="EURO DİZEL">EURO DİZEL</option>
                                                <option selected value="DİZEL">DİZEL</option>
                                                <option value="LPG">LPG</option>
                                                <option value="BENZİN">BENZİN</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Depo Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <select class="custom-select custom-select-sm" id="yakit_depo_id">
                                                    <option value="">Depo Seçiniz...</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Plaka</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="plaka_id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="irsaliye_plakalari_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Sürücü</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="surucu_id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="irsaliye_icin_suruculeri_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>İstasyon Kodu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="istasyon_kodu">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="istasyon_kodu_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>İstasyon Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" disabled class="form-control form-control-sm"
                                                   id="istasyon_adi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Ödeme Yöntemi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="odeme_yontemi">
                                                <option value="">Ödeme Yöntemi Seçiniz...</option>
                                                <option value="Nakit">Nakit</option>
                                                <option value="Havale">Havale</option>
                                                <option value="Kart">Kart</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row kart_show" style="display: none;">
                                        <div class="col-md-4">
                                            <label>Kredi Kartı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       placeholder="Kredi Kartı Kodu..."
                                                       id="kredi_kart_id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="kartlari_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row banka_show" style="display: none;">
                                        <div class="col-md-4">
                                            <label>Banka</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="banka_id"
                                                       placeholder="Banka Kodu...">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="bankalari_getir_button">
                                                        <i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row kasa_show" style="display: none;">
                                        <div class="col-md-4">
                                            <label>Kasa</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="kasa_id"
                                                       placeholder="Kasa Kodu...">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="kasa_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-title" style="background-color: #9DB2BF;color: white;text-align: center">
                            <span>Yakıt Bilgileri</span>
                        </div>
                        <div class="col-12 row mt-3">
                            <div class="col-6">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Son Alınan KM</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" value="0,00"
                                               style="text-align: right" id="son_alinan_km">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Miktar (LT)</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" value="0,00"
                                               style="text-align: right" id="miktar">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Litre Fiyatı</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" value="0,00"
                                               style="text-align: right" id="litre_fiyati">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>TL Tutar</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" value="0,00"
                                               style="text-align: right" id="tl_tutar">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Yakıt Alım KM</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" value="0,00"
                                               style="text-align: right" id="yakit_km">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Fark KM</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" disabled class="form-control form-control-sm" value="0,00"
                                               style="text-align: right" id="fark_km">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Yakıt Tüketimi</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" disabled class="form-control form-control-sm" value="0,00"
                                               style="text-align: right" id="yakit_tuketimi">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Açıklama</label>
                                    </div>
                                    <div class="col-7">
                                        <input type="text" class="form-control form-control-sm"
                                               id="yakit_cikis_aciklamasi">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="konteyner_yakit_cikis_vazgec"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="yakit_cikis_fis_guncelle_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("body").off("change", "#odeme_yontemi").on("change", "#odeme_yontemi", function () {
            let val = $(this).val();
            if (val == "Nakit") {
                $(".kasa_show").show();
                $("#kredi_kart_id").val("");
                $("#kredi_kart_id").attr("data-id", "");
                $(".kart_show").hide();
                $("#banka_id").val("");
                $("#banka_id").attr("data-id", "");
                $(".banka_show").hide();
            } else if (val == "Havale") {
                $(".kasa_show").hide();
                $(".kart_show").hide();
                $("#kasa_id").val("");
                $("#kasa_id").attr("data-id", "");
                $(".banka_show").show();
                $("#kredi_kart_id").val("");
                $("#kredi_kart_id").attr("data-id", "");
            } else if (val == "Kart") {
                $(".kasa_show").hide();
                $(".kart_show").show();
                $("#banka_id").val("");
                $("#banka_id").attr("data-id", "");
                $(".banka_show").hide();
                $("#kasa_id").val("");
                $("#kasa_id").attr("data-id", "");
            } else {
                $("#kredi_kart_id").val("");
                $("#kredi_kart_id").attr("data-id", "");
                $(".kasa_show").hide();
                $(".kart_show").hide();
                $("#banka_id").val("");
                $("#banka_id").attr("data-id", "");
                $(".banka_show").hide();
                $("#kasa_id").val("");
                $("#kasa_id").attr("data-id", "");
            }
        });

        $.get("konteyner/controller/yakit_controller/sql.php?islem=depolari_getir_sql", function (response) {
            if (response != 2) {
                var json = JSON.parse(response);
                json.forEach(function (item) {
                    $("#yakit_depo_id").append("" +
                        "<option value='" + item.id + "'>" + item.depo_adi + "</option>" +
                        "");
                });
            }
        })

        $("body").off("keyup", "#istasyon_kodu").on("keyup", "#istasyon_kodu", function () {
            let val = $(this).val();
            $.get("konteyner/controller/yakit_controller/sql.php?islem=girilen_istasyon_bilgilerini_getir_sql", {cari_kodu: val}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#istasyon_kodu").val(item.cari_kodu);
                    $("#istasyon_kodu").attr("data-id", item.id);
                    $("#istasyon_adi").val(item.cari_adi);
                } else {
                    $("#istasyon_kodu").attr("data-id", "");
                    $("#istasyon_adi").val("");
                }
            });
        });

        $("body").off("keyup", "#plaka_id").on("keyup", "#plaka_id", function () {
            let val = $(this).val();
            $.get("controller/arac_controller/sql.php?islem=arac_bilgilerini_getir_sql", {plaka_no: val}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#plaka_id").val(item.arac_plaka);
                    $("#plaka_id").attr("data-id", item.id);
                    $("#surucu_id").val(item.surucu_adi);
                    $("#surucu_id").attr("data-id", item.surucu_id);
                    let id = item.id;
                    $.get("controller/arac_controller/sql.php?islem=son_alinan_km_sql", {plaka_id: id}, function (response) {
                        if (response != 2) {
                            var item = JSON.parse(response);
                            let yakit_km = item.yakit_km;
                            yakit_km = parseFloat(yakit_km);
                            yakit_km = yakit_km.toLocaleString("tr-TR", {
                                maximumFractionDigits: 2,
                                minimumFractionDigits: 2
                            });
                            $("#son_alinan_km").val(yakit_km);
                        } else {
                            $.get("controller/arac_controller/sql.php?islem=aracin_guncel_km_si", {id: id}, function (response) {
                                if (response != 2) {
                                    var item = JSON.parse(response);
                                    let yakit_km = item.guncel_km;
                                    yakit_km = parseFloat(yakit_km);
                                    yakit_km = yakit_km.toLocaleString("tr-TR", {
                                        maximumFractionDigits: 2,
                                        minimumFractionDigits: 2
                                    });
                                    $("#son_alinan_km").val(yakit_km);
                                }
                            })
                        }
                    })
                } else {
                    $("#plaka_id").attr("data-id", "");
                    $("#surucu_id").val("");
                    $("#surucu_id").attr("data-id", "");
                }
            })
        });

        $("body").off("change", "#alim_yeri").on("change", "#alim_yeri", function () {
            let val = $(this).val();
            if (val == "Depodan") {
                $("#istasyon_kodu_getir_button").prop("disabled", true);
                $("#istasyon_kodu").prop("disabled", true);
                $("#istasyon_kodu").val("");
                $("#istasyon_kodu").attr("data-id", "");
                $("#odeme_yontemi").prop("disabled", true);
                $("#odeme_yontemi").val("");
                $("#istasyon_adi").val("");
                $("#yakit_depo_id").prop("disabled", false);
                $(".kasa_show").hide();
                $(".kart_show").hide();
                $("#kasa_id").val("");
                $("#kasa_id").attr("data-id", "");
                $("#kredi_kart_id").val("");
                $("#kredi_kart_id").attr("data-id", "");
                $("#banka_id").val("");
                $("#banka_id").attr("data-id", "");
                $(".banka_show").hide();
            } else if (val == "İstasyondan") {
                $("#istasyon_kodu_getir_button").prop("disabled", false);
                $("#istasyon_kodu").prop("disabled", false);
                $("#yakit_depo_id").prop("disabled", true);
                $("#yakit_depo_id").val("");
                $("#odeme_yontemi").prop("disabled", true);
                $("#odeme_yontemi").val("");
                $(".kasa_show").hide();
                $(".kart_show").hide();
                $("#kasa_id").val("");
                $("#kasa_id").attr("data-id", "");
                $("#kredi_kart_id").val("");
                $("#kredi_kart_id").attr("data-id", "");
                $("#banka_id").val("");
                $("#banka_id").attr("data-id", "");
                $(".banka_show").hide();
            } else {
                $("#istasyon_adi").val("");
                $("#istasyon_kodu_getir_button").prop("disabled", true);
                $("#istasyon_kodu").prop("disabled", true);
                $("#istasyon_kodu").val("");
                $("#istasyon_kodu").attr("data-id", "");
                $("#yakit_depo_id").prop("disabled", true);
                $("#yakit_depo_id").val("");
                $("#odeme_yontemi").prop("disabled", false);
                $("#odeme_yontemi").val("");
            }
        });

        $('input').click(function () {
            $(this).select();
        });
        $("body").off("click", "#kasa_getir_button").on("click", "#kasa_getir_button", function () {
            $.get("konteyner/modals/arac_modal/hgs_gider_giris.php?islem=kasalari_getir_modal", function (getModal) {
                $(".konteyner_hgs_kasalar").html("");
                $(".konteyner_hgs_kasalar").html(getModal);
            })
        });
        $("body").off("click", "#bankalari_getir_button").on("click", "#bankalari_getir_button", function () {
            $.get("konteyner/modals/arac_modal/hgs_gider_giris.php?islem=bankalari_getir_modal", function (getModal) {
                $(".konteyner_hgs_bankalar").html("");
                $(".konteyner_hgs_bankalar").html(getModal);
            })
        });
        $("body").off("click", "#kartlari_getir_button").on("click", "#kartlari_getir_button", function () {
            $.get("konteyner/modals/arac_modal/hgs_gider_giris.php?islem=kartlari_getir_modal", function (getModal) {
                $(".konteyner_hgs_kartlar").html("");
                $(".konteyner_hgs_kartlar").html(getModal);
            })
        });

        $("body").off("click", "#yakit_cikis_fis_guncelle_button").on("click", "#yakit_cikis_fis_guncelle_button", function () {
            let alim_yeri = $("#alim_yeri").val();
            let fis_no = $("#fis_no").val();
            let tarih = $("#tarih").val();
            let plaka_id = $("#plaka_id").attr("data-id");
            let yakit_depo_id = $("#yakit_depo_id").val();
            let istasyon_id = $("#istasyon_kodu").attr("data-id");
            let son_alinan_km = $("#son_alinan_km").val();
            son_alinan_km = son_alinan_km.replace(/\./g, "").replace(",", ".");
            son_alinan_km = parseFloat(son_alinan_km);
            let yakit_km = $("#yakit_km").val();
            yakit_km = yakit_km.replace(/\./g, "").replace(",", ".");
            yakit_km = parseFloat(yakit_km);
            let miktar = $("#miktar").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            let tl_tutar = $("#tl_tutar").val();
            tl_tutar = tl_tutar.replace(/\./g, "").replace(",", ".");
            tl_tutar = parseFloat(tl_tutar);
            let fark_km = $("#fark_km").val();
            fark_km = fark_km.replace(/\./g, "").replace(",", ".");
            fark_km = parseFloat(fark_km);
            let yakit_tuketim = $("#yakit_tuketimi").val();
            yakit_tuketim = yakit_tuketim.replace(/\./g, "").replace(",", ".");
            yakit_tuketim = parseFloat(yakit_tuketim);
            let litre_fiyati = $("#litre_fiyati").val();
            litre_fiyati = litre_fiyati.replace(/\./g, "").replace(",", ".");
            litre_fiyati = parseFloat(litre_fiyati);
            let tasima_kg = $("#tasima_kg").val();
            let surucu_id = $("#surucu_id").attr("data-id");
            let surucu_adi = $("#surucu_id").val();
            let yakit_tipi = $("#yakit_tipi").val();
            let aciklama = $("#yakit_cikis_aciklamasi").val();
            let banka_id = $("#banka_id").attr("data-id");
            let kasa_id = $("#kasa_id").attr("data-id");
            let kart_id = $("#kredi_kart_id").attr("data-id");
            let odeme_yontem = $("#odeme_yontemi").val();

            if (alim_yeri == "İstasyondan") {
                if (istasyon_id == undefined || istasyon_id == "") {
                    Swal.fire(
                        "Uyarı!",
                        'Alım Yeriniz İstasyon Bir İstasyon Seçiniz...',
                        'warning'
                    );
                } else {
                    $.ajax({
                        url: "controller/arac_controller/sql.php?islem=yakit_cikis_fisi_guncelle_sql",
                        type: "POST",
                        data: {
                            alim_yeri: alim_yeri,
                            plaka_id: plaka_id,
                            tarih: tarih,
                            banka_id: banka_id,
                            surucu_adi: surucu_adi,
                            kasa_id: kasa_id,
                            kart_id: kart_id,
                            fis_no: fis_no,
                            istasyon_id: istasyon_id,
                            son_alim_km: son_alinan_km,
                            odeme_yontem: odeme_yontem,
                            yakit_km: yakit_km,
                            miktar: miktar,
                            tl_tutar: tl_tutar,
                            fark_km: fark_km,
                            yakit_tuketim: yakit_tuketim,
                            litre_fiyati: litre_fiyati,
                            tasima_kg: tasima_kg,
                            surucu_id: surucu_id,
                            yakit_tipi: yakit_tipi,
                            depo_id: yakit_depo_id,
                            id: "<?=$_GET["id"]?>",
                            aciklama: aciklama
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı',
                                    'Yakıt Fişi Güncellendi',
                                    'success'
                                );
                                $.get("view/yakit_alim_fisleri.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                });
                                $.get("view/yakit_alim_fisleri.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                });
                                $("#binek_yakit_alim_guncelle_modal").modal("hide");
                            } else {
                                Swal.fire(
                                    'Oops...',
                                    'Bilinmeyen Bir Hata Oluştu',
                                    'error'
                                );
                                $.get("view/yakit_alim_fisleri.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                });
                                $.get("view/yakit_alim_fisleri.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                });
                                $("#binek_yakit_alim_guncelle_modal").modal("hide");
                            }
                        }
                    });
                }
            } else {
                $.ajax({
                    url: "controller/arac_controller/sql.php?islem=yakit_cikis_fisi_guncelle_sql",
                    type: "POST",
                    data: {
                        alim_yeri: alim_yeri,
                        plaka_id: plaka_id,
                        tarih: tarih,
                        surucu_adi: surucu_adi,
                        banka_id: banka_id,
                        kasa_id: kasa_id,
                        kart_id: kart_id,
                        fis_no: fis_no,
                        istasyon_id: istasyon_id,
                        son_alim_km: son_alinan_km,
                        odeme_yontem: odeme_yontem,
                        yakit_km: yakit_km,
                        miktar: miktar,
                        tl_tutar: tl_tutar,
                        fark_km: fark_km,
                        yakit_tuketim: yakit_tuketim,
                        litre_fiyati: litre_fiyati,
                        tasima_kg: tasima_kg,
                        surucu_id: surucu_id,
                        yakit_tipi: yakit_tipi,
                        depo_id: yakit_depo_id,
                        id: "<?=$_GET["id"]?>",
                        aciklama: aciklama
                    },
                    success: function (result) {
                        if (result == 1) {
                            Swal.fire(
                                'Başarılı',
                                'Yakıt Fişi Kaydedildi',
                                'success'
                            );
                            $.get("view/yakit_alim_fisleri.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("view/yakit_alim_fisleri.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                            $("#binek_yakit_alim_guncelle_modal").modal("hide");
                        } else {
                            Swal.fire(
                                'Oops...',
                                'Bilinmeyen Bir Hata Oluştu',
                                'error'
                            );
                            $.get("view/yakit_alim_fisleri.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("view/yakit_alim_fisleri.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                            $("#binek_yakit_alim_guncelle_modal").modal("hide");
                        }
                    }
                });
            }
        });

        $("body").off("focusout", "#son_alinan_km").on("focusout", "#son_alinan_km", function () {
            let yakit_alim_km = $("#yakit_km").val();
            yakit_alim_km = yakit_alim_km.replace(/\./g, "").replace(",", ".");
            yakit_alim_km = parseFloat(yakit_alim_km);
            if (isNaN(yakit_alim_km)) {
                yakit_alim_km = 0
            }
            let son_km = $(this).val();
            son_km = son_km.replace(/\./g, "").replace(",", ".");
            son_km = parseFloat(son_km);
            if (isNaN(son_km)) {
                son_km = 0
            }
            let fark_km = yakit_alim_km - son_km;

            // YAKIT TÜKETİM HESABI
            let miktar = $("#miktar").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            if (isNaN(miktar)) {
                miktar = 0
            }
            let baz_yakit_tuketim = miktar / fark_km;
            baz_yakit_tuketim = baz_yakit_tuketim * 100;
            if (isNaN(baz_yakit_tuketim)) {
                baz_yakit_tuketim = 0
            }
            $("#yakit_tuketimi").val(baz_yakit_tuketim.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));


            $("#fark_km").val(fark_km.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            $(this).val(son_km.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
            $("#yakit_km").focus();
            $("#yakit_km").select();
        });

        $("body").off("focusout", "#yakit_km").on("focusout", "#yakit_km", function () {
            let yakit_alim_km = $(this).val();
            yakit_alim_km = yakit_alim_km.replace(/\./g, "").replace(",", ".");
            yakit_alim_km = parseFloat(yakit_alim_km);
            if (isNaN(yakit_alim_km)) {
                yakit_alim_km = 0
            }
            let son_km = $("#son_alinan_km").val();
            son_km = son_km.replace(/\./g, "").replace(",", ".");
            son_km = parseFloat(son_km);
            if (isNaN(son_km)) {
                son_km = 0
            }
            let fark_km = yakit_alim_km - son_km;

            let miktar = $("#miktar").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            if (isNaN(miktar)) {
                miktar = 0
            }
            let baz_yakit_tuketim = miktar / fark_km;
            baz_yakit_tuketim = baz_yakit_tuketim * 100;
            if (isNaN(baz_yakit_tuketim)) {
                baz_yakit_tuketim = 0
            }
            $("#yakit_tuketimi").val(baz_yakit_tuketim.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));


            $("#fark_km").val(fark_km.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            $(this).val(yakit_alim_km.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
            $("#miktar").focus();
            $("#miktar").select();
        });

        $("body").off("focusout", "#tl_tutar").on("focusout", "#tl_tutar", function () {
            $("#tasima_kg").focus();
            $("#tasima_kg").select();
        });


        $("body").off("focusout", "#litre_fiyati").on("focusout", "#litre_fiyati", function () {
            let litre_fiyat = $(this).val();
            litre_fiyat = litre_fiyat.replace(/\./g, "").replace(",", ".");
            litre_fiyat = parseFloat(litre_fiyat);
            if (isNaN(litre_fiyat)) {
                litre_fiyat = 0
            }

            let miktar = $("#miktar").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            if (isNaN(miktar)) {
                miktar = 0
            }

            let tl_tutar = miktar * litre_fiyat;
            $("#tl_tutar").val(tl_tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            $(this).val(litre_fiyat.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });


        $("body").off("focusout", "#miktar").on("focusout", "#miktar", function () {


            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }

            // YAKIT TÜKETİM HESABI

            let yakit_alim_km = $("#yakit_km").val();
            yakit_alim_km = yakit_alim_km.replace(/\./g, "").replace(",", ".");
            yakit_alim_km = parseFloat(yakit_alim_km);
            if (isNaN(yakit_alim_km)) {
                yakit_alim_km = 0
            }
            let son_km = $("#son_alinan_km").val();
            son_km = son_km.replace(/\./g, "").replace(",", ".");
            son_km = parseFloat(son_km);
            if (isNaN(son_km)) {
                son_km = 0
            }
            let fark_km = yakit_alim_km - son_km;

            let baz_yakit_tuketim = val / fark_km;
            baz_yakit_tuketim = baz_yakit_tuketim * 100;
            if (isNaN(baz_yakit_tuketim)) {
                baz_yakit_tuketim = 0
            }
            $("#yakit_tuketimi").val(baz_yakit_tuketim.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));


            $("#fark_km").val(fark_km.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            $(this).val(yakit_alim_km.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));


            let litre_fiyati = $("#litre_fiyati").val();
            litre_fiyati = litre_fiyati.replace(/\./g, "").replace(",", ".");
            litre_fiyati = parseFloat(litre_fiyati);

            if (isNaN(litre_fiyati)) {
                litre_fiyati = 0
            }

            let tl_tutar = litre_fiyati * val;
            $("#tl_tutar").val(tl_tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));

            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));

        });

        $("body").off("click", "#irsaliye_plakalari_getir_button").on("click", "#irsaliye_plakalari_getir_button", function () {
            $.get("modals/arac_modal/yakit_alim_modal.php?islem=irsaliye_plakalari_getir", function (getModal) {
                $(".konteyner_irasliye_plakalari_getir_div").html("");
                $(".konteyner_irasliye_plakalari_getir_div").html(getModal);
            });
        });

        $("body").off("click", "#irsaliye_icin_suruculeri_getir_button").on("click", "#irsaliye_icin_suruculeri_getir_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=irsaliye_icin_suruculeri_getir", function (getModal) {
                $(".konteyner_irasliye_suruculeri_getir_div").html("");
                $(".konteyner_irasliye_suruculeri_getir_div").html(getModal);
            });
        });

        $("body").off("click", "#istasyon_kodu_getir_button").on("click", "#istasyon_kodu_getir_button", function () {
            $.get("konteyner/modals/yakit_modal/ozmal_yakit_cikis.php?islem=istasyonlari_modal_getir", function (getModal) {
                $(".konteyner_yakit_cikis_fisi_div").html("");
                $(".konteyner_yakit_cikis_fisi_div").html(getModal);
            });
        });


        $("body").off("click", "#sefer_kodlarini_getir_button").on("click", "#sefer_kodlarini_getir_button", function () {
            let plaka_id = $("#plaka_id").attr("data-id");
            if (plaka_id == undefined || plaka_id == "") {
                Swal.fire(
                    'Uyarı!',
                    'Lütfen Bir Plaka Seçiniz...',
                    'warning'
                );
            } else {
                $.get("konteyner/modals/yakit_modal/ozmal_yakit_cikis.php?islem=yakita_baglanacak_fisleri_getir", {plaka_id: plaka_id}, function (getModal) {
                    $(".konteyner_yakit_cikis_seferleri_div").html("");
                    $(".konteyner_yakit_cikis_seferleri_div").html(getModal);
                });
            }

        });

        $(document).ready(function () {
            $("#binek_yakit_alim_guncelle_modal").modal("show");

            $.get("controller/arac_controller/sql.php?islem=binek_yakit_alim_getir_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#alim_yeri").val(item.alim_yeri);
                    $("#fis_no").val(item.fis_no);
                    let tarih = item.tarih;
                    tarih = tarih.split(" ");
                    $("#tarih").val(tarih[0]);
                    $("#plaka_id").attr("data-id", item.plaka_id);
                    $("#plaka_id").val(item.arac_plaka);
                    setTimeout(function () {
                        $("#yakit_depo_id").val(item.depo_id);
                    }, 500);
                    $("#istasyon_kodu").attr("data-id", item.istasyon_id);
                    $("#istasyon_kodu").val(item.istasyon_adi);
                    let son_alim = item.son_alim_km;
                    son_alim = parseFloat(son_alim);
                    son_alim = son_alim.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    $("#son_alinan_km").val(son_alim);
                    let yakit_km = item.yakit_km;
                    yakit_km = parseFloat(yakit_km);
                    yakit_km = yakit_km.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    $("#yakit_km").val(yakit_km);
                    let miktar = item.miktar;
                    miktar = parseFloat(miktar);
                    miktar = miktar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    $("#miktar").val(miktar);
                    let tl_tutar = item.tl_tutar;
                    tl_tutar = parseFloat(tl_tutar);
                    tl_tutar = tl_tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    $("#tl_tutar").val(tl_tutar);
                    let fark_km = item.fark_km;
                    fark_km = parseFloat(fark_km);
                    fark_km = fark_km.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    $("#fark_km").val(fark_km);
                    $("#yakit_tuketimi").val(item.yakit_tuketim);
                    let litre_fiyati = item.litre_fiyati;
                    litre_fiyati = parseFloat(litre_fiyati);
                    litre_fiyati = litre_fiyati.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    $("#litre_fiyati").val(litre_fiyati);
                    $("#surucu_id").attr("data-id", item.surucu_id);
                    $("#surucu_id").val(item.surucu_adi);
                    $("#yakit_tipi").val(item.yakit_tipi);
                    $("#yakit_cikis_aciklamasi").val(item.aciklama);
                    $("#banka_id").attr("data-id", item.banka_id);
                    $("#banka_id").val(item.banka_adi);
                    $("#kasa_id").attr("data-id", item.kasa_id);
                    $("#kasa_id").val(item.kasa_adi);
                    $("#kredi_kart_id").attr("data-id", item.kart_id);
                    $("#kredi_kart_id").val(item.kart_id);
                    $("#odeme_yontemi").val(item.odeme_yontem);
                }
            })

        });

        $("body").off("click", "#konteyner_yakit_cikis_vazgec").on("click", "#konteyner_yakit_cikis_vazgec", function () {
            $("#binek_yakit_alim_guncelle_modal").modal("hide");
        });

    </script>
    <?php
}