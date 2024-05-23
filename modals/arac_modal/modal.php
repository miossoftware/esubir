<?php

$islem = $_GET["islem"];

if ($islem == "yeni_arac_tanimla_modal") {
    ?>
    <style>
        #yeni_binek_arac_tanim_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="yeni_binek_arac_tanim_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 80%; max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="binek_arac_tanim_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>YENİ BİNEK ARAÇ TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="arac_tanim_icin_suruculeri_getir"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Plaka No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="plaka_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Güncel KM</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="number" class="form-control form-control-sm" id="guncel_km">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Marka</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="marka">
                                                <option value="">Marka Giriniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Model</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="model">
                                                <option value="">Model Giriniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Model Yılı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="model_yili">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Yakıt Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="yakit_tipi">
                                                <option value="">Yakıt Tipi Seçiniz...</option>
                                                <option value="Dizel">Dizel</option>
                                                <option value="Benzin">Benzin</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Ehliyet No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="ehliyet_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>HGS / KGS No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="hgs_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>TTS No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="tts_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Sürücü Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" id="suruc_id" class="form-control form-control-sm">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="suruculeri_getir"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Muayene Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>" id="muayene_tarihi"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Satın Alım Fiyatı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" style="text-align: right"
                                                   class="form-control form-control-sm" value="0,00" id="alim_fiyati">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="binek_arac_tanim_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="binek_arac_kaydet_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function () {
            $("#yeni_binek_arac_tanim_modal").modal("show");
            $.get("controller/stok_controller/sql.php?islem=marka_listesi_getir", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        var markaAdi = item.marka_adi;
                        $("#marka").append("" +
                            "<option value='" + item.id + "'>" + markaAdi.toUpperCase() +
                            "</option>" +
                            ""
                        );
                    })
                }
            });
        });

        $("body").off("focusout", "#alim_fiyati").on("focusout", "#alim_fiyati", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });

        $("body").off("click", "#suruculeri_getir").on("click", "#suruculeri_getir", function () {
            $.get("konteyner/modals/arac_modal/modal.php?islem=arac_tanim_icin_suruculeri_getir_modal", function (getModal) {
                $(".arac_tanim_icin_suruculeri_getir").html("");
                $(".arac_tanim_icin_suruculeri_getir").html(getModal);
            });
        });

        $("body").off("change", "#marka").on("change", "#marka", function () {
            var id = $(this).val();
            $.get("controller/stok_controller/sql.php?islem=markaya_ait_model_getir", {id: id}, function (result) {
                if (result != 2) {
                    $("#model").html("");
                    $("#model").append("" +
                        "<option value=''>Seçiniz...</option>" +
                        "");
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        var model_adi = item.model_adi;
                        $("#model").append("" +
                            "<option value='" + item.id + "'>" + model_adi.toUpperCase() + "</option>" +
                            "");
                    })
                } else {
                    $("#model").html("");
                    $("#model").append("" +
                        "<option value=''>Seçiniz...</option>" +
                        "");
                }
            })
        })

        $("body").off("click", "#binek_arac_tanim_modal_kapat").on("click", "#binek_arac_tanim_modal_kapat", function () {
            $("#yeni_binek_arac_tanim_modal").modal("hide");
        });

        $("body").off("click", "#binek_arac_kaydet_button").on("click", "#binek_arac_kaydet_button", function () {
            let plaka_no = $("#plaka_no").val();
            let guncel_km = $("#guncel_km").val();
            let marka = $("#marka").val();
            let model = $("#model").val();
            let model_yili = $("#model_yili").val();
            let yakit_tipi = $("#yakit_tipi").val();
            let ehliyet_no = $("#ehliyet_no").val();
            let hgs_no = $("#hgs_no").val();
            let tts_no = $("#tts_no").val();
            let suruc_id = $("#suruc_id").attr("data-id");
            let suruc_adi = $("#suruc_id").val();
            let muayene_tarihi = $("#muayene_tarihi").val();
            let alim_fiyati = $("#alim_fiyati").val();
            alim_fiyati = alim_fiyati.replace(/\./g, "").replace(",", ".");
            alim_fiyati = parseFloat(alim_fiyati);

            $.ajax({
                url: "controller/arac_controller/sql.php?islem=yeni_binek_arac_ekle_sql",
                type: "POST",
                data: {
                    arac_plaka: plaka_no,
                    guncel_km: guncel_km,
                    marka: marka,
                    model: model,
                    model_yili: model_yili,
                    yakit_tipi: yakit_tipi,
                    ehliyet_no: ehliyet_no,
                    hgs_no: hgs_no,
                    tts_no: tts_no,
                    surucu_adi: suruc_adi,
                    surucu_id: suruc_id,
                    muayene_tarihi: muayene_tarihi,
                    degeri: alim_fiyati
                },
                success: function (res) {
                    if (res == 1) {
                        Swal.fire(
                            "Başarılı",
                            "Taşıt Kaydedildi",
                            "success"
                        );
                        $("#yeni_binek_arac_tanim_modal").modal("hide");
                        $.get("view/binek_arac_tanim.php", function (getList) {
                            $(".admin-modal-icerik").html(getList);
                        });
                        $.get("view/binek_arac_tanim.php", function (getList) {
                            $(".modal-icerik").html(getList);
                        });
                    }
                }
            });
        });
    </script>
    <?php
}
if ($islem == "yeni_arac_guncelle_modal") {
    ?>
    <style>
        #binek_arac_guncelle_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="binek_arac_guncelle_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 80%; max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="binek_arac_tanim_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>BİNEK ARAÇ GÜNCELLE</div>
                        </div>
                        <div class="modal-body">
                            <div class="arac_tanim_icin_suruculeri_getir"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Plaka No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="plaka_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Güncel KM</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="number" class="form-control form-control-sm" id="guncel_km">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Marka</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="marka">
                                                <option value="">Marka Giriniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Model</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="model">
                                                <option value="">Model Giriniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Model Yılı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="model_yili">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Yakıt Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="yakit_tipi">
                                                <option value="">Yakıt Tipi Seçiniz...</option>
                                                <option value="Dizel">Dizel</option>
                                                <option value="Benzin">Benzin</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Ehliyet No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="ehliyet_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>HGS / KGS No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="hgs_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>TTS No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="tts_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Sürücü Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" id="suruc_id" class="form-control form-control-sm">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="suruculeri_getir"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Muayene Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>" id="muayene_tarihi"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Satın Alım Fiyatı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" style="text-align: right"
                                                   class="form-control form-control-sm" value="0,00" id="alim_fiyati">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="binek_arac_tanim_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="binek_arac_kaydet_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function () {
            $("#binek_arac_guncelle_modal").modal("show");
            $.get("controller/stok_controller/sql.php?islem=marka_listesi_getir", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        var markaAdi = item.marka_adi;
                        $("#marka").append("" +
                            "<option value='" + item.id + "'>" + markaAdi.toUpperCase() +
                            "</option>" +
                            ""
                        );
                    })
                }
            });

            $.get("controller/arac_controller/sql.php?islem=arac_bilgilerini_getir_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#plaka_no").val(item.arac_plaka);
                    $("#guncel_km").val(item.guncel_km);
                    $("#marka").val(item.marka);
                    $("#model").val(item.model);
                    $("#model_yili").val(item.model_yili);
                    $("#yakit_tipi").val(item.yakit_tipi);
                    $("#ehliyet_no").val(item.ehliyet_no);
                    $("#hgs_no").val(item.hgs_no);
                    $("#tts_no").val(item.tts_no);
                    $("#suruc_id").val(item.surucu_adi);
                    let alim_fiyat = item.degeri;
                    alim_fiyat = parseFloat(alim_fiyat);
                    alim_fiyat = alim_fiyat.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    $.get("controller/stok_controller/sql.php?islem=markaya_ait_model_getir", {id: item.marka}, function (result) {
                        if (result != 2) {
                            $("#model").html("");
                            $("#model").append("" +
                                "<option value=''>Seçiniz...</option>" +
                                "");
                            var json = JSON.parse(result);
                            json.forEach(function (item) {
                                var model_adi = item.model_adi;
                                $("#model").append("" +
                                    "<option value='" + item.id + "'>" + model_adi.toUpperCase() + "</option>" +
                                    "");
                            })
                        } else {
                            $("#model").html("");
                            $("#model").append("" +
                                "<option value=''>Seçiniz...</option>" +
                                "");
                        }
                    })

                    setTimeout(function () {
                        $("#model").val(item.model)
                        $("#marka").val(item.marka)
                    }, 500);

                    let muayene_tarihi = item.muayene_tarihi;
                    if (muayene_tarihi != "") {
                        muayene_tarihi = muayene_tarihi.split(" ");
                        muayene_tarihi = muayene_tarihi[0];
                    }
                    $("#muayene_tarihi").val(muayene_tarihi);
                    $("#alim_fiyati").val(alim_fiyat);
                    $("#suruc_id").attr("data-id", item.surucu_id);
                }
            })
        });

        $("body").off("focusout", "#alim_fiyati").on("focusout", "#alim_fiyati", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });

        $("body").off("click", "#suruculeri_getir").on("click", "#suruculeri_getir", function () {
            $.get("konteyner/modals/arac_modal/modal.php?islem=arac_tanim_icin_suruculeri_getir_modal", function (getModal) {
                $(".arac_tanim_icin_suruculeri_getir").html("");
                $(".arac_tanim_icin_suruculeri_getir").html(getModal);
            });
        });

        $("body").off("change", "#marka").on("change", "#marka", function () {
            var id = $(this).val();
            $.get("controller/stok_controller/sql.php?islem=markaya_ait_model_getir", {id: id}, function (result) {
                if (result != 2) {
                    $("#model").html("");
                    $("#model").append("" +
                        "<option value=''>Seçiniz...</option>" +
                        "");
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        var model_adi = item.model_adi;
                        $("#model").append("" +
                            "<option value='" + item.id + "'>" + model_adi.toUpperCase() + "</option>" +
                            "");
                    })
                } else {
                    $("#model").html("");
                    $("#model").append("" +
                        "<option value=''>Seçiniz...</option>" +
                        "");
                }
            })
        })

        $("body").off("click", "#binek_arac_tanim_modal_kapat").on("click", "#binek_arac_tanim_modal_kapat", function () {
            $("#binek_arac_guncelle_modal").modal("hide");
        });

        $("body").off("click", "#binek_arac_kaydet_button").on("click", "#binek_arac_kaydet_button", function () {
            let plaka_no = $("#plaka_no").val();
            let guncel_km = $("#guncel_km").val();
            let marka = $("#marka").val();
            let model = $("#model").val();
            let model_yili = $("#model_yili").val();
            let yakit_tipi = $("#yakit_tipi").val();
            let ehliyet_no = $("#ehliyet_no").val();
            let hgs_no = $("#hgs_no").val();
            let tts_no = $("#tts_no").val();
            let suruc_id = $("#suruc_id").attr("data-id");
            let suruc_adi = $("#suruc_id").val();
            let muayene_tarihi = $("#muayene_tarihi").val();
            let alim_fiyati = $("#alim_fiyati").val();
            alim_fiyati = alim_fiyati.replace(/\./g, "").replace(",", ".");
            alim_fiyati = parseFloat(alim_fiyati);

            $.ajax({
                url: "controller/arac_controller/sql.php?islem=yeni_binek_arac_guncelle_sql",
                type: "POST",
                data: {
                    arac_plaka: plaka_no,
                    guncel_km: guncel_km,
                    marka: marka,
                    model: model,
                    model_yili: model_yili,
                    yakit_tipi: yakit_tipi,
                    ehliyet_no: ehliyet_no,
                    hgs_no: hgs_no,
                    tts_no: tts_no,
                    surucu_adi: suruc_adi,
                    surucu_id: suruc_id,
                    id: "<?=$_GET["id"]?>",
                    muayene_tarihi: muayene_tarihi,
                    degeri: alim_fiyati
                },
                success: function (res) {
                    if (res == 1) {
                        Swal.fire(
                            "Başarılı",
                            "Taşıt Kaydedildi",
                            "success"
                        );
                        $("#binek_arac_guncelle_modal").modal("hide");
                        $.get("view/binek_arac_tanim.php", function (getList) {
                            $(".admin-modal-icerik").html(getList);
                        });
                        $.get("view/binek_arac_tanim.php", function (getList) {
                            $(".modal-icerik").html(getList);
                        });
                    }
                }
            });
        });
    </script>
    <?php
}