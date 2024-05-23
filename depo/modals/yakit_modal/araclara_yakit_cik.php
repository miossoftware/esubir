<?php

$islem = $_GET["islem"];

if ($islem == "depo_araclarina_yakit_cikis") {
    ?>
    <style>
        #depo_araclarina_yakit_cik {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="depo_araclarina_yakit_cik" data-bs-keyboard="false" data-backdrop="static"
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
                            <div class="ibox-title" style='color:white; font-weight:bold;'>YAKIT ÇIKIŞ EKLE</div>
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
                                                <option value="Depodan">Depomuzdan</option>
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
                                            <label>Kalmar</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select id="kalmar_id" class="custom-select custom-select-sm">
                                                <option>Kalmar Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Forklift</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select id="forklift_id" class="custom-select custom-select-sm">
                                                <option>Forklift Seçiniz...</option>
                                            </select>
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
                                        <label>Son Alınan Saat</label>
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
                                        <label>Yakıt Alım Saat</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" value="0,00"
                                               style="text-align: right" id="yakit_km">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Fark Saat</label>
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
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" value="0,00"
                                               style="text-align: right" id="tasima_kg">
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
            $.get("konteyner/controller/irsaliye_controller/sql.php?islem=plaka_bilgilerini_getir_sql", {plaka_no: val}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#dorse_id").attr("data-id", item.dorse_id);
                    $("#plaka_id").val(item.plaka_no);
                    $("#plaka_id").attr("data-id", item.id);
                    $("#dorse_id").val(item.dorse_plaka);
                    $("#surucu_id").val(item.surucu_adi);
                    $("#surucu_id").attr("data-id", item.surucu_id);
                    let id = item.id;
                    $.get("konteyner/controller/yakit_controller/sql.php?islem=son_alinan_km_sql", {plaka_id: id}, function (response) {
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
                            $.get("konteyner/controller/yakit_controller/sql.php?islem=aracin_guncel_km_si", {id: id}, function (response) {
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
                    $("#dorse_id").attr("data-id", "");
                    $("#plaka_id").attr("data-id", "");
                    $("#dorse_id").val("");
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
                $("#istasyon_adi").val("");
                $("#yakit_depo_id").prop("disabled", false);
            } else {
                $("#istasyon_kodu_getir_button").prop("disabled", false);
                $("#istasyon_kodu").prop("disabled", false);
                $("#yakit_depo_id").prop("disabled", true);
                $("#yakit_depo_id").val("");
            }
        });

        $('input').click(function () {
            $(this).select();
        });

        $("body").off("click", "#yakit_cikis_fis_kaydet_button").on("click", "#yakit_cikis_fis_kaydet_button", function () {
            let alim_yeri = $("#alim_yeri").val();
            let fis_no = $("#fis_no").val();
            let tarih = $("#tarih").val();
            let yakit_depo_id = $("#yakit_depo_id").val();
            let istasyon_id = $("#istasyon_kodu").attr("data-id");
            let son_alinan_saat = $("#son_alinan_km").val();
            son_alinan_saat = son_alinan_saat.replace(/\./g, "").replace(",", ".");
            son_alinan_saat = parseFloat(son_alinan_saat);
            let yakit_alim_saat = $("#yakit_km").val();
            yakit_alim_saat = yakit_alim_saat.replace(/\./g, "").replace(",", ".");
            yakit_alim_saat = parseFloat(yakit_alim_saat);
            let miktar = $("#miktar").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            let tl_tutar = $("#tl_tutar").val();
            tl_tutar = tl_tutar.replace(/\./g, "").replace(",", ".");
            tl_tutar = parseFloat(tl_tutar);
            let fark_saat = $("#fark_km").val();
            fark_saat = fark_saat.replace(/\./g, "").replace(",", ".");
            fark_saat = parseFloat(fark_saat);
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
            let forklift_id = $("#forklift_id").val();
            let kalmar_id = $("#kalmar_id").val();

            if (alim_yeri != "Depodan") {
                if (istasyon_id == undefined || istasyon_id == "") {
                    Swal.fire(
                        "Uyarı!",
                        'Alım Yeriniz İstasyon Bir İstasyon Seçiniz...',
                        'warning'
                    );
                } else {
                    $.ajax({
                        url: "depo/controller/yakit_controller/sql.php?islem=yakit_cikis_fisi_kaydet_sql",
                        type: "POST",
                        data: {
                            alim_yeri: alim_yeri,
                            forklift_id: forklift_id,
                            kalmar_id: kalmar_id,
                            surucu_adi: surucu_adi,
                            tarih: tarih,
                            fis_no: fis_no,
                            istasyon_id: istasyon_id,
                            son_alinan_saat: son_alinan_saat,
                            yakit_alim_saat: yakit_alim_saat,
                            miktar: miktar,
                            tl_tutar: tl_tutar,
                            fark_saat: fark_saat,
                            yakit_tuketim: yakit_tuketim,
                            litre_fiyati: litre_fiyati,
                            tasima_kg: tasima_kg,
                            surucu_id: surucu_id,
                            yakit_tipi: yakit_tipi,
                            yakit_depo_id: yakit_depo_id
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı',
                                    'Yakıt Fişi Kaydedildi',
                                    'success'
                                );
                                $.get("depo/view/depo_yakit_islemleri.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                });
                                $.get("depo/view/depo_yakit_islemleri.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                });
                                $("#depo_araclarina_yakit_cik").modal("hide");
                            } else {
                                Swal.fire(
                                    'Oops...',
                                    'Bilinmeyen Bir Hata Oluştu',
                                    'error'
                                );
                                $.get("depo/view/depo_yakit_islemleri.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                });
                                $.get("depo/view/depo_yakit_islemleri.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                });
                                $("#depo_araclarina_yakit_cik").modal("hide");
                            }
                        }
                    });
                }
            } else {
                $.ajax({
                    url: "depo/controller/yakit_controller/sql.php?islem=yakit_cikis_fisi_kaydet_sql",
                    type: "POST",
                    data: {
                        alim_yeri: alim_yeri,
                        tarih: tarih,
                        fis_no: fis_no,
                        istasyon_id: istasyon_id,
                        son_alinan_saat: son_alinan_saat,
                        surucu_adi: surucu_adi,
                        yakit_alim_saat: yakit_alim_saat,
                        miktar: miktar,
                        tl_tutar: tl_tutar,
                        forklift_id: forklift_id,
                        kalmar_id: kalmar_id,
                        fark_saat: fark_saat,
                        yakit_tuketim: yakit_tuketim,
                        litre_fiyati: litre_fiyati,
                        tasima_kg: tasima_kg,
                        surucu_id: surucu_id,
                        yakit_tipi: yakit_tipi,
                        yakit_depo_id: yakit_depo_id
                    },
                    success: function (result) {
                        if (result == 1) {
                            Swal.fire(
                                'Başarılı',
                                'Yakıt Fişi Kaydedildi',
                                'success'
                            );
                            $.get("depo/view/depo_yakit_islemleri.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/depo_yakit_islemleri.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                            $("#depo_araclarina_yakit_cik").modal("hide");
                        } else {
                            Swal.fire(
                                'Oops...',
                                'Bilinmeyen Bir Hata Oluştu',
                                'error'
                            );
                            $.get("depo/view/depo_yakit_islemleri.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/depo_yakit_islemleri.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                            $("#depo_araclarina_yakit_cik").modal("hide");
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
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=irsaliye_plakalari_getir", {modul: "ozmal_yakit"}, function (getModal) {
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
            $("#depo_araclarina_yakit_cik").modal("show");
            $.get("depo/controller/tanim_controller/sql.php?islem=tum_forkliftleri_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#forklift_id").append("<option value='" + item.id + "'>" + item.forklift_adi + "</option>");
                    })
                }
            });

            $.get("depo/controller/tanim_controller/sql.php?islem=tum_kalmarlari_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#kalmar_id").append("<option value='" + item.id + "'>" + item.forklift_adi + "</option>");
                    })
                }
            });
        });

        $("body").off("change", "#forklift_id").on("change", "#forklift_id", function () {
            let val = $(this).val();
            if (val != "Forklift Seçiniz...") {
                $("#kalmar_id").prop("disabled", true);
                $("#kalmar_id").val("");
                $("#forklift_id").prop("disabled", false);
            } else {
                $("#kalmar_id").prop("disabled", false);
            }
        });

        $("body").off("change", "#kalmar_id").on("change", "#kalmar_id", function () {
            let val = $(this).val();
            if (val != "Kalmar Seçiniz...") {
                $("#kalmar_id").prop("disabled", false);
                $("#forklift_id").val("");
                $("#forklift_id").prop("disabled", true);
            } else {
                $("#forklift_id").prop("disabled", false);
            }
        });

        $("body").off("click", "#konteyner_yakit_cikis_vazgec").on("click", "#konteyner_yakit_cikis_vazgec", function () {
            $("#depo_araclarina_yakit_cik").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "depo_araclarina_yakit_cikis_guncelle") {
    ?>
    <style>
        #depo_araclarina_yakit_cik {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="depo_araclarina_yakit_cik" data-bs-keyboard="false" data-backdrop="static"
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
                            <div class="ibox-title" style='color:white; font-weight:bold;'>YAKIT ÇIKIŞ GÜNCELLE
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
                                                <option value="Depodan">Depomuzdan</option>
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
                                            <label>Kalmar</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select id="kalmar_id" class="custom-select custom-select-sm">
                                                <option>Kalmar Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Forklift</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select id="forklift_id" class="custom-select custom-select-sm">
                                                <option>Forklift Seçiniz...</option>
                                            </select>
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
                                        <label>Son Alınan Saat</label>
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
                                        <label>Yakıt Alım Saat</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" value="0,00"
                                               style="text-align: right" id="yakit_km">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Fark Saat</label>
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
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" value="0,00"
                                               style="text-align: right" id="tasima_kg">
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
            $.get("konteyner/controller/irsaliye_controller/sql.php?islem=plaka_bilgilerini_getir_sql", {plaka_no: val}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#dorse_id").attr("data-id", item.dorse_id);
                    $("#plaka_id").val(item.plaka_no);
                    $("#plaka_id").attr("data-id", item.id);
                    $("#dorse_id").val(item.dorse_plaka);
                    $("#surucu_id").val(item.surucu_adi);
                    $("#surucu_id").attr("data-id", item.surucu_id);
                    let id = item.id;
                    $.get("konteyner/controller/yakit_controller/sql.php?islem=son_alinan_km_sql", {plaka_id: id}, function (response) {
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
                            $.get("konteyner/controller/yakit_controller/sql.php?islem=aracin_guncel_km_si", {id: id}, function (response) {
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
                    $("#dorse_id").attr("data-id", "");
                    $("#plaka_id").attr("data-id", "");
                    $("#dorse_id").val("");
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
                $("#istasyon_adi").val("");
                $("#yakit_depo_id").prop("disabled", false);
            } else {
                $("#istasyon_kodu_getir_button").prop("disabled", false);
                $("#istasyon_kodu").prop("disabled", false);
                $("#yakit_depo_id").prop("disabled", true);
                $("#yakit_depo_id").val("");
            }
        });

        $('input').click(function () {
            $(this).select();
        });

        $("body").off("click", "#yakit_cikis_fis_kaydet_button").on("click", "#yakit_cikis_fis_kaydet_button", function () {
            let alim_yeri = $("#alim_yeri").val();
            let fis_no = $("#fis_no").val();
            let tarih = $("#tarih").val();
            let yakit_depo_id = $("#yakit_depo_id").val();
            let istasyon_id = $("#istasyon_kodu").attr("data-id");
            let son_alinan_saat = $("#son_alinan_km").val();
            son_alinan_saat = son_alinan_saat.replace(/\./g, "").replace(",", ".");
            son_alinan_saat = parseFloat(son_alinan_saat);
            let yakit_alim_saat = $("#yakit_km").val();
            yakit_alim_saat = yakit_alim_saat.replace(/\./g, "").replace(",", ".");
            yakit_alim_saat = parseFloat(yakit_alim_saat);
            let miktar = $("#miktar").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            let tl_tutar = $("#tl_tutar").val();
            tl_tutar = tl_tutar.replace(/\./g, "").replace(",", ".");
            tl_tutar = parseFloat(tl_tutar);
            let fark_saat = $("#fark_km").val();
            fark_saat = fark_saat.replace(/\./g, "").replace(",", ".");
            fark_saat = parseFloat(fark_saat);
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
            let forklift_id = $("#forklift_id").val();
            let kalmar_id = $("#kalmar_id").val();

            if (alim_yeri != "Depodan") {
                if (istasyon_id == undefined || istasyon_id == "") {
                    Swal.fire(
                        "Uyarı!",
                        'Alım Yeriniz İstasyon Bir İstasyon Seçiniz...',
                        'warning'
                    );
                } else {
                    $.ajax({
                        url: "depo/controller/yakit_controller/sql.php?islem=yakit_cikis_fisi_guncelle_sql",
                        type: "POST",
                        data: {
                            alim_yeri: alim_yeri,
                            forklift_id: forklift_id,
                            kalmar_id: kalmar_id,
                            surucu_adi: surucu_adi,
                            tarih: tarih,
                            fis_no: fis_no,
                            istasyon_id: istasyon_id,
                            son_alinan_saat: son_alinan_saat,
                            yakit_alim_saat: yakit_alim_saat,
                            miktar: miktar,
                            tl_tutar: tl_tutar,
                            fark_saat: fark_saat,
                            yakit_tuketim: yakit_tuketim,
                            litre_fiyati: litre_fiyati,
                            tasima_kg: tasima_kg,
                            surucu_id: surucu_id,
                            id: "<?=$_GET["id"]?>",
                            yakit_tipi: yakit_tipi,
                            yakit_depo_id: yakit_depo_id
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı',
                                    'Yakıt Fişi Kaydedildi',
                                    'success'
                                );
                                $.get("depo/view/depo_yakit_islemleri.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                });
                                $.get("depo/view/depo_yakit_islemleri.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                });
                                $("#depo_araclarina_yakit_cik").modal("hide");
                            } else {
                                Swal.fire(
                                    'Oops...',
                                    'Bilinmeyen Bir Hata Oluştu',
                                    'error'
                                );
                                $.get("depo/view/depo_yakit_islemleri.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                });
                                $.get("depo/view/depo_yakit_islemleri.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                });
                                $("#depo_araclarina_yakit_cik").modal("hide");
                            }
                        }
                    });
                }
            } else {
                $.ajax({
                    url: "depo/controller/yakit_controller/sql.php?islem=yakit_cikis_fisi_guncelle_sql",
                    type: "POST",
                    data: {
                        alim_yeri: alim_yeri,
                        tarih: tarih,
                        fis_no: fis_no,
                        istasyon_id: istasyon_id,
                        son_alinan_saat: son_alinan_saat,
                        surucu_adi: surucu_adi,
                        yakit_alim_saat: yakit_alim_saat,
                        id: "<?=$_GET["id"]?>",
                        miktar: miktar,
                        tl_tutar: tl_tutar,
                        forklift_id: forklift_id,
                        kalmar_id: kalmar_id,
                        fark_saat: fark_saat,
                        yakit_tuketim: yakit_tuketim,
                        litre_fiyati: litre_fiyati,
                        tasima_kg: tasima_kg,
                        surucu_id: surucu_id,
                        yakit_tipi: yakit_tipi,
                        yakit_depo_id: yakit_depo_id
                    },
                    success: function (result) {
                        if (result == 1) {
                            Swal.fire(
                                'Başarılı',
                                'Yakıt Fişi Kaydedildi',
                                'success'
                            );
                            $.get("depo/view/depo_yakit_islemleri.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/depo_yakit_islemleri.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                            $("#depo_araclarina_yakit_cik").modal("hide");
                        } else {
                            Swal.fire(
                                'Oops...',
                                'Bilinmeyen Bir Hata Oluştu',
                                'error'
                            );
                            $.get("depo/view/depo_yakit_islemleri.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/depo_yakit_islemleri.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                            $("#depo_araclarina_yakit_cik").modal("hide");
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
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=irsaliye_plakalari_getir", {modul: "ozmal_yakit"}, function (getModal) {
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
            $("#depo_araclarina_yakit_cik").modal("show");
            $.get("depo/controller/tanim_controller/sql.php?islem=tum_forkliftleri_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#forklift_id").append("<option value='" + item.id + "'>" + item.forklift_adi + "</option>");
                    })
                }
            });

            $.get("depo/controller/tanim_controller/sql.php?islem=tum_kalmarlari_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#kalmar_id").append("<option value='" + item.id + "'>" + item.forklift_adi + "</option>");
                    })
                }
            });

            $.get("depo/controller/yakit_controller/sql.php?islem=yakit_bilgilerini_getir_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#alim_yeri").val(item.alim_yeri);
                    $("#fis_no").val(item.fis_no);
                    $("#tarih").val(item.tarih);
                    setTimeout(function () {
                        $("#yakit_depo_id").val(item.yakit_depo_id);
                        $("#forklift_id").val(item.forklift_id);
                        $("#kalmar_id").val(item.kalmar_id);
                    }, 500);
                    $("#istasyon_kodu").attr("data-id", item.istasyon_id);
                    $("#istasyon_kodu").val(item.istasyon_adi);
                    let son_alim_saat = item.son_alinan_saat;
                    son_alim_saat = parseFloat(son_alim_saat);
                    son_alim_saat = son_alim_saat.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    })
                    let yakit_alim_saat = item.yakit_alim_saat;
                    yakit_alim_saat = parseFloat(yakit_alim_saat);
                    yakit_alim_saat = yakit_alim_saat.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    })
                    let fark_saat = item.fark_saat;
                    fark_saat = parseFloat(fark_saat);
                    fark_saat = fark_saat.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2})
                    let miktar = item.miktar;
                    miktar = parseFloat(miktar);
                    miktar = miktar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2})
                    let tutar = item.tutar;
                    tutar = parseFloat(tutar);
                    tutar = tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2})
                    let litre_fiyat = item.litre_fiyat;
                    litre_fiyat = parseFloat(litre_fiyat);
                    litre_fiyat = litre_fiyat.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    })
                    let yakit_tuketim = item.yakit_tuketim;
                    yakit_tuketim = parseFloat(yakit_tuketim);
                    yakit_tuketim = yakit_tuketim.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    })

                    $("#son_alinan_km").val(son_alim_saat);
                    $("#yakit_km").val(yakit_alim_saat);
                    $("#miktar").val(miktar);
                    $("#tl_tutar").val(tutar);
                    $("#fark_km").val(fark_saat);
                    $("#yakit_tuketimi").val(yakit_tuketim);
                    $("#litre_fiyati").val(litre_fiyat);
                    $("#tasima_kg").val(item.tasima_kg);
                    $("#surucu_id").attr("data-id", item.surucu_id);
                    $("#surucu_id").val(item.surucu_adi);
                    $("#yakit_tipi").val(item.yakit_tipi);
                }
            });

        });

        $("body").off("change", "#forklift_id").on("change", "#forklift_id", function () {
            let val = $(this).val();
            if (val != "Forklift Seçiniz...") {
                $("#kalmar_id").prop("disabled", true);
                $("#kalmar_id").val("");
                $("#forklift_id").prop("disabled", false);
            } else {
                $("#kalmar_id").prop("disabled", false);
            }
        });

        $("body").off("change", "#kalmar_id").on("change", "#kalmar_id", function () {
            let val = $(this).val();
            if (val != "Kalmar Seçiniz...") {
                $("#kalmar_id").prop("disabled", false);
                $("#forklift_id").val("");
                $("#forklift_id").prop("disabled", true);
            } else {
                $("#forklift_id").prop("disabled", false);
            }
        });

        $("body").off("click", "#konteyner_yakit_cikis_vazgec").on("click", "#konteyner_yakit_cikis_vazgec", function () {
            $("#depo_araclarina_yakit_cik").modal("hide");
        });

    </script>
    <?php
}