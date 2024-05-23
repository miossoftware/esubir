<?php

$islem = $_GET["islem"];


if ($islem == "nakliye_depodan_cikis_modal") {
    ?>
    <style>
        #nakliye_depolama_cikis_hizmet_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="nakliye_depolama_cikis_hizmet_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 80%; max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="nakliye_depolama_cikis_hizmet_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>DEPO KONTEYNER ÇIKIŞ İŞLEMİ
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="depo_carileri_getir_div"></div>
                            <div class="konteyner_irasliye_suruculeri_getir_div"></div>
                            <div class="siparis_icin_aktarma_plaka_getir_div"></div>
                            <div class="konteyner_irsaliye_ek_hizmetler_getir_div"></div>
                            <div class="depo_giris_carileri_getir_div"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Çıkış Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>" id="cikis_tarihi"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Depo Kodu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="depo_cari_kodu">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="depo_cari_kod_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Depo Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="depo_cari_adi"
                                                   style="font-weight: bold" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Konteyner No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="konteyner_no_cikis">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="depodaki_konteynerler_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Depoya Giriş Tarih</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>" id="depoya_giris_tarih"
                                                   disabled
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Firma Kodu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="firma_kodu"
                                                       disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Firma Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="firma_adi"
                                                   style="font-weight: bold" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Konteyner Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="konteyner_tipi" disabled>
                                                <option value="">Konteyner Tipi Seçiniz...</option>
                                                <option value="1">20 DC</option>
                                                <option value="2">40 DC</option>
                                                <option value="3">20 OT</option>
                                                <option value="4">40 OT</option>
                                                <option value="5">20 RF</option>
                                                <option value="6">40 RF</option>
                                                <option value="7">40 HC RF</option>
                                                <option value="8">40 HC</option>
                                                <option value="9">20 TANK</option>
                                                <option value="10">20 VENTILATED</option>
                                                <option value="11">40 HC PAL. WIDE</option>
                                                <option value="12">20 FLAT</option>
                                                <option value="13">40 FLAT</option>
                                                <option value="14">40 HC FLAT</option>
                                                <option value="15">20 PLATFORM</option>
                                                <option value="16">40 PLATFORM</option>
                                                <option value="17">45 HC</option>
                                                <option value="18">KARGO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Depo Alış Fiyat</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="depo_bedeli"
                                                   style="text-align: right" value="0,00">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="aciklama">
                                        </div>
                                    </div>
                                    <input type="checkbox" id="surucu_prim_yaz"> <label
                                            style="font-weight: bold" for="surucu_prim_yaz">Sürücüye Prim
                                        Yazılsın</label><br>
                                    <input type="checkbox" id="surucu_prim_yaz"> <label
                                            style="font-weight: bold" for="musteriye_yansitilsin">Müşteriye Yansıtılsın</label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Taşıma Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="tasima_tipi" disabled>
                                                <option value="">Taşıma Tipi Belirtiniz...</option>
                                                <option value="İHRACAT">İHRACAT</option>
                                                <option value="İTHALAT">İTHALAT</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Plaka</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="plaka_no">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="plakalar_button"><i
                                                                class="fa fa-ellipsis-h"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Araç Cari</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="arac_cari_adi"
                                                   style="font-weight: bold" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Sürücü</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="surucu_id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="irsaliye_icin_suruculeri_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Boş / Dolu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="bos_dolu">
                                                <option value="">Boş Dolu Hizmeti Seçiniz...</option>
                                                <option value="Boş Aktarma">Boş Aktarma</option>
                                                <option value="Dolu Aktarma">Dolu Aktarma</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Sürücü Prim</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="surucu_prim_getir"
                                                   style="text-align: right">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Depo Müşteri Fiyatı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="depo_ucret"
                                                   style="text-align: right">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Araç Kirası</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="arac_kirasi"
                                                   style="text-align: right">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Free Time</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="number" class="form-control form-control-sm" id="free_time">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Günlük Ücret</label>
                                        </div>
                                        <div class="col-md-7 row no-gutters">
                                            <div class="col">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="gunluk_ucret"
                                                       style="text-align: right">
                                            </div>
                                            <div class="col">
                                                <input type="text" placeholder="Ardiye Günü"
                                                       class="form-control form-control-sm" id="ardiye_gunu" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Toplam Ücret</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" disabled
                                                   id="toplam_ucret" value="0,00"
                                                   style="text-align: right">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="nakliye_depolama_cikis_hizmet_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="depo_cikis_kaydet_sql"><i
                                        class="fa fa-check"></i>
                                Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("body").off("keyup", "#plaka_no").on("keyup", "#plaka_no", function () {
            let val = $(this).val();
            $.get("konteyner/controller/irsaliye_controller/sql.php?islem=plaka_bilgilerini_getir_sql", {plaka_no: val}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#dorse_id").attr("data-id", item.dorse_id);
                    $("#arac_carisi").val(item.cari_adi);
                    $("#plaka_no").val((item.plaka_no).toUpperCase());
                    if (item.cari_adi != null) {
                        $("#arac_cari_adi").val((item.cari_adi).toUpperCase())
                    }
                    if (item.dorse_plaka != null) {
                        $("#dorse_id").val((item.dorse_plaka).toUpperCase());
                    }
                    if (item.surucu_adi != null) {
                        $("#surucu_id").val((item.surucu_adi).toUpperCase());
                    }
                    $("#plaka_no").attr("data-id", item.id);
                    $("#surucu_tel").val(item.surucu_tel);
                    $("#surucu_id").attr("data-id", item.surucu_id);

                    if (item.arac_grubu == "Kiralık") {
                        $("#surucu_prim_getir").val("0,00");
                        $("#surucu_prim_getir").prop("disabled", true);
                        $("#arac_kirasi").prop("disabled", false);
                    } else if (item.arac_grubu == "Öz Mal") {
                        $("#surucu_prim_getir").prop("disabled", false);
                        $("#arac_kirasi").prop("disabled", true);
                        $("#arac_kirasi").val("0,00");
                    } else {
                        $("#arac_kirasi").prop("disabled", false);
                        $("#yol_primi").prop("disabled", false);
                    }

                } else {
                    $("#dorse_id").attr("data-id", "");
                    $("#plaka_id").attr("data-id", "");
                    $("#arac_kirasi").prop("disabled", false);
                    $("#surucu_prim_getir").prop("disabled", false);
                    $("#dorse_id").val("");
                    $("#surucu_tel").val("");
                    $("#arac_cari_adi").val("")
                    $("#surucu_id").val("");
                    $("#surucu_id").attr("data-id", "");
                }
            })
        });

        $("body").off("focusout", "#arac_kirasi").on("focusout", "#arac_kirasi", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });

        $("body").off("focusout", "#depo_ucret").on("focusout", "#depo_ucret", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            let free_tim = $("#free_time").val();
            free_tim = parseFloat(free_tim);
            let alinacak_gun = 0;
            var startDate = new Date($("#cikis_tarihi").val());
            var endDate = new Date($("#depoya_giris_tarih").val());

            let gunluk = $("#gunluk_ucret").val();
            gunluk = gunluk.replace(/\./g, "").replace(",", ".");
            gunluk = parseFloat(gunluk);

            if (!isNaN(startDate.getTime()) && !isNaN(endDate.getTime())) {
                var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
                var daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
                alinacak_gun = daysDiff - free_tim;
                if (isNaN(alinacak_gun)) {
                    alinacak_gun = 0;
                }
                if (alinacak_gun <= 0) {
                    $("#toplam_ucret").val("0,00");
                    $("#ardiye_gunu").val("0");
                } else {
                    let toplam = gunluk * alinacak_gun;
                    $("#ardiye_gunu").val(alinacak_gun);
                    if (isNaN(toplam)) {
                        toplam = 0;
                    }
                    $("#toplam_ucret").val(toplam.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }))
                }
            }
            let toplam_ucret = $("#toplam_ucret").val();
            toplam_ucret = toplam_ucret.replace(/\./g, "").replace(",", ".");
            toplam_ucret = parseFloat(toplam_ucret);
            let depo_ucret = $("#depo_ucret").val();
            depo_ucret = depo_ucret.replace(/\./g, "").replace(",", ".");
            depo_ucret = parseFloat(depo_ucret);
            toplam_ucret += depo_ucret;
            $("#toplam_ucret").val(toplam_ucret.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));

            $(this).val(val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });

        $("body").off("focusout", "#surucu_prim_getir").on("focusout", "#surucu_prim_getir", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });


        $("body").off("click", "#irsaliye_icin_suruculeri_getir_button").on("click", "#irsaliye_icin_suruculeri_getir_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=irsaliye_icin_suruculeri_getir", function (getModal) {
                $(".konteyner_irasliye_suruculeri_getir_div").html("");
                $(".konteyner_irasliye_suruculeri_getir_div").html(getModal);
            });
        });

        $("body").off("click", "#plakalar_button").on("click", "#plakalar_button", function () {
            $.get("konteyner/modals/sefer_modal/siparis_olustur.php?islem=konteyner_icin_plakalari_getir", function (getModal) {
                $(".siparis_icin_aktarma_plaka_getir_div").html("");
                $(".siparis_icin_aktarma_plaka_getir_div").html(getModal);
            })
        });

        $("body").off("click", "#depo_cikis_kaydet_sql").on("click", "#depo_cikis_kaydet_sql", function () {
            let cikis_tarihi = $("#cikis_tarihi").val();
            let bos_dolu = $("#bos_dolu").val();
            let aciklama = $("#aciklama").val();
            let depo_cari_id = $("#depo_cari_kodu").attr("data-id");
            let giris_id = $("#konteyner_no_cikis").attr("data-id");
            let plaka_id = $("#plaka_no").attr("data-id");
            let surucu_adi = $("#surucu_id").val();
            let surucu_id = $("#surucu_id").attr("data-id");
            let surucu_prim = $("#surucu_prim_getir").val();
            surucu_prim = surucu_prim.replace(/\./g, "").replace(",", ".");
            surucu_prim = parseFloat(surucu_prim);
            let depo_ucret = $("#depo_ucret").val();
            depo_ucret = depo_ucret.replace(/\./g, "").replace(",", ".");
            depo_ucret = parseFloat(depo_ucret);
            let arac_kirasi = $("#arac_kirasi").val();
            arac_kirasi = arac_kirasi.replace(/\./g, "").replace(",", ".");
            arac_kirasi = parseFloat(arac_kirasi);
            let free_time = $("#free_time").val();
            let ardiye_gunu = $("#ardiye_gunu").val();
            let gunluk_ucret = $("#gunluk_ucret").val();
            gunluk_ucret = gunluk_ucret.replace(/\./g, "").replace(",", ".");
            gunluk_ucret = parseFloat(gunluk_ucret);
            let depo_bedeli = $("#depo_bedeli").val();
            depo_bedeli = depo_bedeli.replace(/\./g, "").replace(",", ".");
            depo_bedeli = parseFloat(depo_bedeli);
            let toplam_ucret = $("#toplam_ucret").val();
            toplam_ucret = toplam_ucret.replace(/\./g, "").replace(",", ".");
            toplam_ucret = parseFloat(toplam_ucret);
            let prim_yazilsin = 0;

            if ($("#surucu_prim_yaz").prop("checked")) {
                prim_yazilsin = 1;
            }
            let musteriye_yansitilsin = 0;

            if ($("#musteriye_yansitilsin").prop("checked")) {
                musteriye_yansitilsin = 1;
            }

            if (depo_cari_id == undefined || depo_cari_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Depo Seçiniz...",
                    "warning"
                )
            } else if (bos_dolu == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Boş Dolu Hizmeti Seçiniz...",
                    "warning"
                )
            } else if (giris_id == undefined || giris_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Konteyner Seçiniz...",
                    "warning"
                )
            } else if (plaka_id == undefined || plaka_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Plaka Seçiniz...",
                    "warning"
                )
            } else if (depo_bedeli == 0 || depo_bedeli == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Depo Bedeli Giriniz...",
                    "warning"
                )
            } else {
                $.ajax({
                    url: "depo/controller/nakliye_controller/sql.php?islem=depodan_konteyneri_cikart_sql",
                    type: "POST",
                    data: {
                        cikis_tarih: cikis_tarihi,
                        surucu_adi: surucu_adi,
                        surucu_id: surucu_id,
                        depo_id: depo_cari_id,
                        musteriye_yansitilsin: musteriye_yansitilsin,
                        depo_giris_id: giris_id,
                        depo_ucret: depo_ucret,
                        plaka_id: plaka_id,
                        surucu_prim: surucu_prim,
                        depo_bedeli: depo_bedeli,
                        arac_kirasi: arac_kirasi,
                        aciklama: aciklama,
                        free_time: free_time,
                        ardiye_gunu: ardiye_gunu,
                        bos_dolu: bos_dolu,
                        gunluk_ucret: gunluk_ucret,
                        toplam_ucret: toplam_ucret,
                        prim_yazilsin: prim_yazilsin
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı!",
                                "Depo Konteyner Çıkışı Kaydedildi",
                                "success"
                            );
                            $.get("depo/view/nakliye_depolama_cikis.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/nakliye_depolama_cikis.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                            $("#nakliye_depolama_cikis_hizmet_modal").modal("hide");
                        } else if (res == 300) {
                            Swal.fire(
                                "Başarılı!",
                                "Böyle Bir Konteyner Depoda Yok...",
                                "success"
                            );
                        }
                    }
                });
            }
        });
        $("input").click(function () {
            $(this).select();
        });

        $("body").off("focusout", "#depo_bedeli").on("focusout", "#depo_bedeli", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}))
        });

        $("body").off("focusout", "#free_time").on("focusout", "#free_time", function () {
            let free_tim = $(this).val();
            free_tim = parseFloat(free_tim);
            let alinacak_gun = 0;
            var startDate = new Date($("#cikis_tarihi").val());
            var endDate = new Date($("#depoya_giris_tarih").val());

            if (!isNaN(startDate.getTime()) && !isNaN(endDate.getTime())) {
                var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
                var daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
                alinacak_gun = daysDiff - free_tim;
                if (isNaN(alinacak_gun)) {
                    alinacak_gun = 0;
                }
                if (alinacak_gun <= 0) {
                    $("#toplam_ucret").val("0,00");
                    $("#ardiye_gunu").val("0");
                } else {
                    let gunluk = $("#gunluk_ucret").val();
                    gunluk = gunluk.replace(/\./g, "").replace(",", ".");
                    gunluk = parseFloat(gunluk);
                    let toplam = gunluk * alinacak_gun;
                    if (isNaN(toplam)) {
                        toplam = 0;
                    }
                    $("#ardiye_gunu").val(alinacak_gun);
                    $("#toplam_ucret").val(toplam.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }))
                }
            }
            let toplam_ucret = $("#toplam_ucret").val();
            toplam_ucret = toplam_ucret.replace(/\./g, "").replace(",", ".");
            toplam_ucret = parseFloat(toplam_ucret);
            let depo_ucret = $("#depo_ucret").val();
            depo_ucret = depo_ucret.replace(/\./g, "").replace(",", ".");
            depo_ucret = parseFloat(depo_ucret);
            toplam_ucret += depo_ucret;
            $("#toplam_ucret").val(toplam_ucret.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
        });

        $("body").off("focusout", "#gunluk_ucret").on("focusout", "#gunluk_ucret", function () {
            let free_tim = $("#free_time").val();
            free_tim = parseFloat(free_tim);
            let alinacak_gun = 0;
            var startDate = new Date($("#cikis_tarihi").val());
            var endDate = new Date($("#depoya_giris_tarih").val());

            let gunluk = $("#gunluk_ucret").val();
            gunluk = gunluk.replace(/\./g, "").replace(",", ".");
            gunluk = parseFloat(gunluk);

            if (!isNaN(startDate.getTime()) && !isNaN(endDate.getTime())) {
                var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
                var daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
                alinacak_gun = daysDiff - free_tim;
                if (isNaN(alinacak_gun)) {
                    alinacak_gun = 0;
                }
                if (alinacak_gun <= 0) {
                    $("#toplam_ucret").val("0,00");
                    $("#ardiye_gunu").val("0");
                } else {
                    let toplam = gunluk * alinacak_gun;
                    if (isNaN(toplam)) {
                        toplam = 0;
                    }
                    $("#ardiye_gunu").val(alinacak_gun);
                    $("#toplam_ucret").val(toplam.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }))
                }
            }
            if (isNaN(gunluk)) {
                gunluk = 0;
            }
            let toplam_ucret = $("#toplam_ucret").val();
            toplam_ucret = toplam_ucret.replace(/\./g, "").replace(",", ".");
            toplam_ucret = parseFloat(toplam_ucret);
            let depo_ucret = $("#depo_ucret").val();
            depo_ucret = depo_ucret.replace(/\./g, "").replace(",", ".");
            depo_ucret = parseFloat(depo_ucret);
            toplam_ucret += depo_ucret;
            $("#toplam_ucret").val(toplam_ucret.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
            $(this).val(gunluk.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });


        $("body").off("focusout", "#cikis_tarihi").on("focusout", "#cikis_tarihi", function () {
            let free_tim = $("#free_time").val();
            free_tim = parseFloat(free_tim);
            let alinacak_gun = 0;
            var startDate = new Date($("#cikis_tarihi").val());
            var endDate = new Date($("#depoya_giris_tarih").val());

            let gunluk = $("#gunluk_ucret").val();
            gunluk = gunluk.replace(/\./g, "").replace(",", ".");
            gunluk = parseFloat(gunluk);

            if (!isNaN(startDate.getTime()) && !isNaN(endDate.getTime())) {
                var timeDiff = Math.abs(endDate.getTime() - startDate.getTime());
                var daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
                alinacak_gun = daysDiff - free_tim;
                if (isNaN(alinacak_gun)) {
                    alinacak_gun = 0;
                }
                if (alinacak_gun <= 0) {
                    $("#toplam_ucret").val("0,00");
                    $("#ardiye_gunu").val("0");
                } else {
                    let toplam = gunluk * alinacak_gun;
                    $("#ardiye_gunu").val(alinacak_gun);
                    if (isNaN(toplam)) {
                        toplam = 0;
                    }
                    $("#toplam_ucret").val(toplam.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }))
                }
            }
            let toplam_ucret = $("#toplam_ucret").val();
            toplam_ucret = toplam_ucret.replace(/\./g, "").replace(",", ".");
            toplam_ucret = parseFloat(toplam_ucret);
            let depo_ucret = $("#depo_ucret").val();
            depo_ucret = depo_ucret.replace(/\./g, "").replace(",", ".");
            depo_ucret = parseFloat(depo_ucret);
            toplam_ucret += depo_ucret;
            $("#toplam_ucret").val(toplam_ucret.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
        });


        $("body").off("click", "#depo_cari_kod_button").on("click", "#depo_cari_kod_button", function () {
            $.get("depo/modals/nakliye_depolama_modal/nakliye_depolama.php?islem=depo_carileri_getir", function (getModal) {
                $(".depo_carileri_getir_div").html("");
                $(".depo_carileri_getir_div").html(getModal);
            })
        })
        $("body").off("click", "#depodaki_konteynerler_button").on("click", "#depodaki_konteynerler_button", function () {
            $.get("depo/modals/nakliye_depolama_modal/nakliye_depolama_cikis.php?islem=depodaki_konteynerler_modal_getir", function (getModal) {
                $(".depo_giris_carileri_getir_div").html("");
                $(".depo_giris_carileri_getir_div").html(getModal);
            })
        });


        $("body").off("click", "#ek_hizmet_kodu_getir_button").on("click", "#ek_hizmet_kodu_getir_button", function () {
            $.get("depo/modals/nakliye_depolama_modal/depo_cikis_page.php?islem=ek_hizmetleri_getir", function (getModal) {
                $(".konteyner_irsaliye_ek_hizmetler_getir_div").html("");
                $(".konteyner_irsaliye_ek_hizmetler_getir_div").html(getModal);
            });
        });

        $(document).ready(function () {
            $("#nakliye_depolama_cikis_hizmet_modal").modal("show");
        });

        $("body").off("click", "#nakliye_depolama_cikis_hizmet_modal_kapat").on("click", "#nakliye_depolama_cikis_hizmet_modal_kapat", function () {
            $("#nakliye_depolama_cikis_hizmet_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "depodaki_konteynerler_modal_getir") {
    ?>
    <div class="modal fade" id="depodaki_konteynerler_modal"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 55%; max-width: 55%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Cari Listesi
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="depodaki_konteyner_table">
                            <thead>
                            <tr>
                                <th id="click1">Konteyner No</th>
                                <th>Depo Adı</th>
                                <th>Firma Adı</th>
                                <th>Konteyner Tipi</th>
                                <th>Taşıma Tipi</th>
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
        var table = "";

        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#depodaki_konteynerler_modal").modal("hide");
        })

        $(document).ready(function () {
            $.get("controller/alis_controller/sql.php?islem=fatura_turlerini_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#fatura_turu").append("" +
                            "<option value='" + item.id + "'>" + item.fatura_turu_adi + "</option>" +
                            "");
                    })
                }
            })
            $("#depodaki_konteynerler_modal").modal("show");

            setTimeout(function () {

                $("#click1").trigger("click");

            }, 300);

            table = $('#depodaki_konteyner_table').DataTable({

                scrollY: '35vh',

                scrollX: true,

                "info": false,

                "paging": false,

                "dom": '<"pull-left"f><"pull-right"l>tip',

                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "konteyner_no"},
                    {'data': "depo_adi"},
                    {'data': "firma_adi"},
                    {'data': "konteyner_tipi"},
                    {'data': "tasima_tipi"}
                ],
                createdRow: function (row) {
                    $(row).addClass("cari_select");
                    $(row).find('td').css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }

            })
            let depo_cari_id = $("#depo_cari_kodu").attr("data-id");
            $.get("depo/controller/nakliye_controller/sql.php?islem=depodaki_konteynerleri_getir_sql", {cari_id: depo_cari_id}, function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    table.rows.add(json).draw(false);
                }
            })

        })


        $("body").off("click", ".cari_select").on("click", ".cari_select", function () {
            var id = $(this).attr("data-id");
            $.get("depo/controller/nakliye_controller/sql.php?islem=secilen_konteyneri_getir_sql", {id: id}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#depo_cari_kodu").val(item.depo_kodu);
                    $("#depo_cari_kodu").attr("data-id", item.depo_cari_id);
                    $("#depo_cari_adi").val(item.depo_adi);
                    $("#firma_kodu").val(item.firma_kodu);
                    $("#firma_adi").val(item.firma_adi);
                    $("#firma_kodu").attr("data-id", item.firma_cari_id);
                    $("#konteyner_tipi").val(item.konteyner_tipi);
                    $("#konteyner_no_cikis").val(item.konteyner_no);
                    $("#tasima_tipi").val(item.tasima_tipi);
                    $("#konteyner_no_cikis").attr("data-id", item.id);
                    $("#ek_hizmet_kodu").attr("data-id", item.stok_id);
                    $("#aciklama").val(item.aciklama);
                    let tarih = item.tarih;
                    tarih = tarih.split(" ");
                    $("#depoya_giris_tarih").val(tarih[0]);
                    $.get("depo/controller/nakliye_controller/sql.php?islem=hizmet_primi_sql", {stok_id: item.stok_id}, function (res) {
                        if (res != 2) {
                            var item2 = JSON.parse(res);
                            let prim = item2.yol_primi;
                            prim = parseFloat(prim);
                            prim = prim.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            $("#surucu_prim_getir").val(prim);
                        }
                    })
                    $("#ek_hizmet_kodu").val(item.hizmet_adi);

                }
            });
            $("#depodaki_konteynerler_modal").modal("hide");
        })
    </script>
    <?php
}