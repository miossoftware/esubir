<?php

$islem = $_GET["islem"];


if ($islem == "konteyner_cikisi_yap_modal") {
    ?>
    <style>
        #konteyner_giris_main_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="konteyner_giris_main_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="konteyner_giris_main_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>KONTEYNER ÇIKIŞ</div>
                        </div>
                        <div class="modal-body">
                            <div class="konteynerler_div"></div>
                            <div class="konteyner_irasliye_plakalari_getir_div"></div>
                            <div class="konteyner_irasliye_suruculeri_getir_div"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Konteyner No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="konteyner_no">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="giris_yapan_konteynerleri_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Giriş Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>" disabled
                                                   id="depoya_giris_tarih"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
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
                                            <label>Boş / Dolu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="bos_dolu" disabled>
                                                <option value="Boş">Boş</option>
                                                <option value="Dolu">Dolu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>2.Konteyner</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="konteyner2_varmi">
                                                <option value="yok">Yok</option>
                                                <option value="var">Var</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row konteyner2_hidden" style="display: none">
                                        <div class="col-md-4">
                                            <label>2.Konteyner No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="konteyner_no1">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="giris_yapan_konteynerleri_getir_button2"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row konteyner2_hidden" style="display: none">
                                        <div class="col-md-4">
                                            <label>Boş / Dolu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="bos_dolu2" disabled>
                                                <option value="Boş">Boş</option>
                                                <option value="Dolu">Dolu</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Plaka No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="plaka_id">
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
                                            <label>Sürücü Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="surucu_id">
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
                                            <label>Plaka Cari</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="arac_cari_adi"
                                                   disabled>
                                        </div>
                                    </div>
                                    <!--                                    <div class="form-group row">-->
                                    <!--                                        <div class="col-md-4">-->
                                    <!--                                            <label>Free Time</label>-->
                                    <!--                                        </div>-->
                                    <!--                                        <div class="col-md-7">-->
                                    <!--                                            <input type="number" class="form-control form-control-sm" id="free_time">-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->
                                    <!--                                    <div class="form-group row">-->
                                    <!--                                        <div class="col-md-4">-->
                                    <!--                                            <label>Günlük Ücret</label>-->
                                    <!--                                        </div>-->
                                    <!--                                        <div class="col-md-7 row no-gutters">-->
                                    <!--                                            <div class="col">-->
                                    <!--                                                <input type="text" class="form-control form-control-sm"-->
                                    <!--                                                       id="gunluk_ucret" value="0,00"-->
                                    <!--                                                       style="text-align: right">-->
                                    <!--                                            </div>-->
                                    <!--                                            <div class="col">-->
                                    <!--                                                <input type="text" placeholder="Ardiye Günü"-->
                                    <!--                                                       class="form-control form-control-sm" id="ardiye_gunu" disabled>-->
                                    <!--                                            </div>-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->
                                    <!--                                    <div class="form-group row">-->
                                    <!--                                        <div class="col-md-4">-->
                                    <!--                                            <label>Toplam Ücret</label>-->
                                    <!--                                        </div>-->
                                    <!--                                        <div class="col-md-7">-->
                                    <!--                                            <input type="text" class="form-control form-control-sm" disabled-->
                                    <!--                                                   id="toplam_ucret" value="0,00"-->
                                    <!--                                                   style="text-align: right">-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="aciklama">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="konteyner_giris_main_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="konteyner_cikis_kaydet_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("body").off("change", "#konteyner2_varmi").on("change", "#konteyner2_varmi", function () {
            let val = $(this).val();
            if (val == "var") {
                $(".konteyner2_hidden").show();
            } else {
                $(".konteyner2_hidden").hide();
            }
        });

        $("body").off("click", "#giris_yapan_konteynerleri_getir_button2").on("click", "#giris_yapan_konteynerleri_getir_button2", function () {
            $.get("depo/modals/konteyner_modal/konteyner_cikis.php?islem=konteyner_girislerini_getir_modal2", function (getModal) {
                $(".konteynerler_div").html(getModal);
            })
        });

        $("body").off("click", "#giris_yapan_konteynerleri_getir_button").on("click", "#giris_yapan_konteynerleri_getir_button", function () {
            $.get("depo/modals/konteyner_modal/konteyner_cikis.php?islem=konteyner_girislerini_getir_modal", function (getModal) {
                $(".konteynerler_div").html(getModal);
            })
        });
        $("body").off("keyup", "#plaka_id").on("keyup", "#plaka_id", function () {
            let val = $(this).val();
            $.get("konteyner/controller/irsaliye_controller/sql.php?islem=plaka_bilgilerini_getir_sql", {plaka_no: val}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#dorse_id").attr("data-id", item.dorse_id);
                    $("#plaka_id").val((item.plaka_no).toUpperCase());
                    if (item.cari_adi != null) {
                        $("#arac_cari_adi").val((item.cari_adi).toUpperCase());
                    }
                    if (item.dorse_plaka != null) {
                        $("#dorse_id").val((item.dorse_plaka).toUpperCase());
                    }
                    if (item.surucu_adi != null) {
                        $("#surucu_id").val((item.surucu_adi).toUpperCase());
                    }
                    $("#plaka_id").attr("data-id", item.id);
                    $("#surucu_tel").val(item.surucu_tel);
                    $("#surucu_id").attr("data-id", item.surucu_id);

                    if (item.arac_grubu == "Kiralık") {
                        $("#surucu_prim").val("0,00");
                        $("#surucu_prim").prop("disabled", true);
                        $("#arac_kirasi").prop("disabled", false);
                    } else if (item.arac_grubu == "Öz Mal") {
                        $("#surucu_prim").prop("disabled", false);
                        $("#arac_kirasi").prop("disabled", true);
                        $("#arac_kirasi").val("0,00");
                    } else {
                        $("#arac_kirasi").prop("disabled", false);
                        $("#surucu_prim").prop("disabled", false);
                    }

                } else {
                    $("#dorse_id").attr("data-id", "");
                    $("#plaka_id").attr("data-id", "");
                    $("#arac_kirasi").prop("disabled", false);
                    $("#surucu_prim").prop("disabled", false);
                    $("#dorse_id").val("");
                    $("#surucu_tel").val("");
                    $("#arac_cari_adi").val("")
                    $("#surucu_id").val("");
                    $("#surucu_id").attr("data-id", "");
                }
            })
        });

        $("body").off("keyup", "#konteyner_no").on("keyup", "#konteyner_no", function () {
            let val = $(this).val();
            $.get("depo/controller/konteyner_controller/sql.php?islem=giris_yapmis_konteynerleri_getir", {konteyner_no: val}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#konteyner_no").val(item.konteyner_no);
                    $("#konteyner_no").attr("data-id", item.id);
                    let giris_tarihi = item.giris_tarihi;
                    if (giris_tarihi != null) {
                        giris_tarihi = giris_tarihi.split(" ");
                        giris_tarihi = giris_tarihi[0]
                    }
                    $("#depoya_giris_tarih").val(giris_tarihi);
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });
                    Toast.fire({
                        icon: "success",
                        title: "Konteyner Bulundu"
                    });
                } else {
                    $("#konteyner_no").attr("data-id", "");
                }
            });
        });

        $("body").off("click", "#konteyner_cikis_kaydet_button").on("click", "#konteyner_cikis_kaydet_button", function () {
            let konteyner_id = $("#konteyner_no").attr("data-id");
            let giris_tarihi = $("#depoya_giris_tarih").val();
            let cikis_tarihi = $("#cikis_tarihi").val();
            let bos_dolu = $("#bos_dolu").val();
            let plaka_id = $("#plaka_id").attr("data-id");
            let konteyner_id2 = $("#konteyner_no1").attr("data-id");
            let bos_dolu2 = $("#bos_dolu1").val();
            let surucu_id = $("#surucu_id").attr("data-id");
            let surucu_adi = $("#surucu_id").val();
            let aciklama = $("#aciklama").val();

            if (konteyner_id == undefined || konteyner_id == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir Konteyner Seçiniz...",
                    "warning"
                );
            } else if (plaka_id == undefined || plaka_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Plaka Seçiniz...",
                    "warning"
                );
            } else if (cikis_tarihi == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Çıkış Tarihi Giriniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "depo/controller/konteyner_controller/sql.php?islem=konteyner_cikis_yap_sql",
                    type: "POST",
                    data: {
                        konteyner_id: konteyner_id,
                        giris_tarihi: giris_tarihi,
                        konteyner_id2: konteyner_id2,
                        bos_dolu: bos_dolu,
                        bos_dolu2: bos_dolu2,
                        cikis_tarihi: cikis_tarihi,
                        plaka_id: plaka_id,
                        surucu_id: surucu_id,
                        surucu_adi: surucu_adi,
                        aciklama: aciklama
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Konteyner Çıkışı Yapıldı",
                                "success"
                            );
                            $("#konteyner_giris_main_modal").modal("hide");
                            $.get("depo/view/konteyner_cikis_main.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/konteyner_cikis_main.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                        } else if (res == 300) {
                            Swal.fire(
                                "Uyarı!",
                                "Bu Konteyner Bir İTHALAT Projesine Aittir Dolu Girmiştir Dolu Çıkamaz...",
                                "warning"
                            );
                        }
                    }
                });
            }

        });

        $("body").off("click", "#irsaliye_plakalari_getir_button").on("click", "#irsaliye_plakalari_getir_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=irsaliye_plakalari_getir", function (getModal) {
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
            $(this).val(gunluk.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));

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
        });

        $(document).ready(function () {
            $("#konteyner_giris_main_modal").modal("show");
        });

        $("body").off("click", "#konteyner_giris_main_modal_kapat").on("click", "#konteyner_giris_main_modal_kapat", function () {
            $("#konteyner_giris_main_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "konteyner_cikis_guncelle_modal") {
    ?>
    <style>
        #konteyner_giris_main_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="konteyner_giris_main_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="konteyner_giris_main_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>KONTEYNER ÇIKIŞ</div>
                        </div>
                        <div class="modal-body">
                            <div class="konteynerler_div"></div>
                            <div class="konteyner_irasliye_plakalari_getir_div"></div>
                            <div class="konteyner_irasliye_suruculeri_getir_div"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Konteyner No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="konteyner_no">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="giris_yapan_konteynerleri_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Giriş Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>" disabled
                                                   id="depoya_giris_tarih"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
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
                                            <label>Boş / Dolu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="bos_dolu">
                                                <option value="Boş">Boş</option>
                                                <option value="Dolu">Dolu</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Plaka No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="plaka_id">
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
                                            <label>Plaka Cari</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="arac_cari_adi"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Sürücü Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="surucu_id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="irsaliye_icin_suruculeri_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                    <div class="form-group row">-->
                                    <!--                                        <div class="col-md-4">-->
                                    <!--                                            <label>Free Time</label>-->
                                    <!--                                        </div>-->
                                    <!--                                        <div class="col-md-7">-->
                                    <!--                                            <input type="number" class="form-control form-control-sm" id="free_time">-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->
                                    <!--                                    <div class="form-group row">-->
                                    <!--                                        <div class="col-md-4">-->
                                    <!--                                            <label>Günlük Ücret</label>-->
                                    <!--                                        </div>-->
                                    <!--                                        <div class="col-md-7 row no-gutters">-->
                                    <!--                                            <div class="col">-->
                                    <!--                                                <input type="text" class="form-control form-control-sm"-->
                                    <!--                                                       id="gunluk_ucret" value="0,00"-->
                                    <!--                                                       style="text-align: right">-->
                                    <!--                                            </div>-->
                                    <!--                                            <div class="col">-->
                                    <!--                                                <input type="text" placeholder="Ardiye Günü"-->
                                    <!--                                                       class="form-control form-control-sm" id="ardiye_gunu" disabled>-->
                                    <!--                                            </div>-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->
                                    <!--                                    <div class="form-group row">-->
                                    <!--                                        <div class="col-md-4">-->
                                    <!--                                            <label>Toplam Ücret</label>-->
                                    <!--                                        </div>-->
                                    <!--                                        <div class="col-md-7">-->
                                    <!--                                            <input type="text" class="form-control form-control-sm" disabled-->
                                    <!--                                                   id="toplam_ucret" value="0,00"-->
                                    <!--                                                   style="text-align: right">-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="aciklama">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="konteyner_giris_main_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="konteyner_cikis_guncelle_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("body").off("click", "#giris_yapan_konteynerleri_getir_button").on("click", "#giris_yapan_konteynerleri_getir_button", function () {
            $.get("depo/modals/konteyner_modal/konteyner_cikis.php?islem=konteyner_girislerini_getir_modal", function (getModal) {
                $(".konteynerler_div").html(getModal);
            })
        });

        $("body").off("click", "#konteyner_cikis_guncelle_button").on("click", "#konteyner_cikis_guncelle_button", function () {
            let konteyner_id = $("#konteyner_no").attr("data-id");
            let giris_tarihi = $("#depoya_giris_tarih").val();
            let cikis_tarihi = $("#cikis_tarihi").val();
            let plaka_id = $("#plaka_id").attr("data-id");
            let surucu_id = $("#surucu_id").attr("data-id");
            let surucu_adi = $("#surucu_id").val();
            let ardiye_gunu = $("#ardiye_gunu").val();
            let bos_dolu = $("#bos_dolu").val();
            let aciklama = $("#aciklama").val();

            if (konteyner_id == undefined || konteyner_id == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir Konteyner Seçiniz...",
                    "warning"
                );
            } else if (plaka_id == undefined || plaka_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Plaka Seçiniz...",
                    "warning"
                );
            } else if (cikis_tarihi == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Çıkış Tarihi Giriniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "depo/controller/konteyner_controller/sql.php?islem=konteyner_cikis_guncelle_sql",
                    type: "POST",
                    data: {
                        konteyner_id: konteyner_id,
                        giris_tarihi: giris_tarihi,
                        cikis_tarihi: cikis_tarihi,
                        plaka_id: plaka_id,
                        surucu_id: surucu_id,
                        surucu_adi: surucu_adi,
                        bos_dolu: bos_dolu,
                        aciklama: aciklama,
                        id: "<?=$_GET["id"]?>"
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Konteyner Çıkışı Yapıldı",
                                "success"
                            );
                            $("#konteyner_giris_main_modal").modal("hide");
                            $.get("depo/view/konteyner_cikis_main.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/konteyner_cikis_main.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }

        });

        $("body").off("click", "#irsaliye_plakalari_getir_button").on("click", "#irsaliye_plakalari_getir_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=irsaliye_plakalari_getir", function (getModal) {
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
            $(this).val(gunluk.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));

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
        });

        $(document).ready(function () {
            $("#konteyner_giris_main_modal").modal("show");
            $.get("depo/controller/konteyner_controller/sql.php?islem=guncellenecek_cikis_bilgileri_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#konteyner_no").attr("data-id", item.konteyner_id);
                    $("#konteyner_no").val(item.konteyner_no);
                    $("#depoya_giris_tarih").val(item.giris_tarihi);
                    $("#cikis_tarihi").val(item.cikis_tarihi);
                    $("#arac_cari_adi").val(item.arac_cari);
                    $("#plaka_id").attr("data-id", item.plaka_id);
                    $("#plaka_id").val(item.plaka_no);
                    $("#bos_dolu").val(item.bos_dolu);
                    $("#surucu_id").attr("data-id", item.surucu_id);
                    $("#surucu_id").val(item.surucu_adi);
                    $("#free_time").val(item.free_time);
                    let gunluk = item.gunluk_ucret;
                    gunluk = parseFloat(gunluk);
                    gunluk = gunluk.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    let toplam_ucret = item.toplam_ucret;
                    toplam_ucret = parseFloat(toplam_ucret);
                    toplam_ucret = toplam_ucret.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    $("#gunluk_ucret").val(gunluk);
                    $("#ardiye_gunu").val(item.ardiye_gunu);
                    $("#toplam_ucret").val(toplam_ucret);
                    $("#aciklama").val(item.aciklama);
                }
            })
        });

        $("body").off("click", "#konteyner_giris_main_modal_kapat").on("click", "#konteyner_giris_main_modal_kapat", function () {
            $("#konteyner_giris_main_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "konteyner_girislerini_getir_modal") {
    ?>
    <div class="modal fade" id="konteyner_cikis_icin_girenleri_getir" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 100%; max-width: 100%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="konteyner_cikis_icin_girenleri_getir_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>KONTEYNER GİRİŞLERİ</div>
                        </div>
                        <div class="modal-body">
                            <table class="table table-sm table-bordered w-100 display nowrap"
                                   style="cursor:pointer;font-size: 13px;"
                                   id="arac_girisleri_list">
                                <thead>
                                <tr>
                                    <th id="click1">Konteyner No</th>
                                    <th>Cari Adı</th>
                                    <th>Konteyner Tipi</th>
                                    <th>Giriş Tarihi</th>
                                    <th>Referans</th>
                                    <th>Beyanname No</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function () {
            $("#konteyner_cikis_icin_girenleri_getir").modal("show");

            setTimeout(function () {
                $("#click1").trigger("click");
            }, 500);

            var table = $('#arac_girisleri_list').DataTable({
                scrollY: '30vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "konteyner_no"},
                    {'data': "cari_adi"},
                    {'data': "konteyner_tipi"},
                    {'data': "giris_tarihi"},
                    {'data': "referans_no"},
                    {'data': "beyanname_no"}
                ],
                createdRow: function (row, data) {
                    $(row).addClass("depo_konteyner_giris_selected");
                    $(row).find('td').css('text-align', 'left');
                    $(row).attr("data-id", data.id);
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $.get("depo/controller/konteyner_controller/sql.php?islem=konteyner_girislerini_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                }
            })
        });

        $("body").off("click", ".depo_konteyner_giris_selected").on("click", ".depo_konteyner_giris_selected", function () {
            let id = $(this).attr("data-id");
            $.get("depo/controller/konteyner_controller/sql.php?islem=secilen_konteyner_giris_bilgileri", {id: id}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#konteyner_no").attr("data-id", item.id);
                    $("#konteyner_no").val(item.konteyner_no);
                    $("#giris_tarihi").val(item.giris_tarihi);
                    $("#referans_no").val(item.referans);
                    $("#beyanname_no").val(item.beyanname_no);
                    $("#bos_dolu").val(item.bos_dolu);
                    $("#tipi").val(item.tipi);
                    $("#konteyner_tipi").val(item.konteyner_tipi);
                    $("#cut_off_tarihi").val(item.cut_off_tarihi);
                    $("#ardiyesiz_giris_tarihi").val(item.ardiyesiz_giris_tarihi);
                    $("#demoraj_tarihi").val(item.demoraj_tarihi);
                    $("#durumu").val(item.durumu);
                    $("#depoya_giris_tarih").val(item.giris_tarihi);
                    $("#plaka_no").val(item.plaka_no);
                }
            })
            $("#konteyner_cikis_icin_girenleri_getir").modal("hide");
        });

        $("body").off("click", "#konteyner_cikis_icin_girenleri_getir_kapat").on("click", "#konteyner_cikis_icin_girenleri_getir_kapat", function () {
            $("#konteyner_cikis_icin_girenleri_getir").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "konteyner_girislerini_getir_modal2") {
    ?>
    <div class="modal fade" id="konteyner_cikis_icin_girenleri_getir" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 100%; max-width: 100%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="konteyner_cikis_icin_girenleri_getir_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>KONTEYNER GİRİŞLERİ</div>
                        </div>
                        <div class="modal-body">
                            <table class="table table-sm table-bordered w-100 display nowrap"
                                   style="cursor:pointer;font-size: 13px;"
                                   id="arac_girisleri_list">
                                <thead>
                                <tr>
                                    <th id="click1">Konteyner No</th>
                                    <th>Cari Adı</th>
                                    <th>Konteyner Tipi</th>
                                    <th>Giriş Tarihi</th>
                                    <th>Referans</th>
                                    <th>Beyanname No</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function () {
            $("#konteyner_cikis_icin_girenleri_getir").modal("show");

            setTimeout(function () {
                $("#click1").trigger("click");
            }, 500);

            var table = $('#arac_girisleri_list').DataTable({
                scrollY: '30vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "konteyner_no"},
                    {'data': "cari_adi"},
                    {'data': "konteyner_tipi"},
                    {'data': "giris_tarihi"},
                    {'data': "referans_no"},
                    {'data': "beyanname_no"}
                ],
                createdRow: function (row, data) {
                    $(row).addClass("depo_konteyner_giris_selected");
                    $(row).find('td').css('text-align', 'left');
                    $(row).attr("data-id", data.id);
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $.get("depo/controller/konteyner_controller/sql.php?islem=konteyner_girislerini_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                }
            })
        });

        $("body").off("click", ".depo_konteyner_giris_selected").on("click", ".depo_konteyner_giris_selected", function () {
            let id = $(this).attr("data-id");
            $.get("depo/controller/konteyner_controller/sql.php?islem=secilen_konteyner_giris_bilgileri", {id: id}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#konteyner_no1").attr("data-id", item.id);
                    $("#konteyner_no1").val(item.konteyner_no);
                    $("#giris_tarihi").val(item.giris_tarihi);
                    $("#bos_dolu2").val(item.bos_dolu);
                    $("#referans_no").val(item.referans);
                    $("#beyanname_no").val(item.beyanname_no);
                    $("#tipi").val(item.tipi);
                    $("#konteyner_tipi").val(item.konteyner_tipi);
                    $("#cut_off_tarihi").val(item.cut_off_tarihi);
                    $("#ardiyesiz_giris_tarihi").val(item.ardiyesiz_giris_tarihi);
                    $("#demoraj_tarihi").val(item.demoraj_tarihi);
                    $("#durumu").val(item.durumu);
                    $("#depoya_giris_tarih").val(item.giris_tarihi);
                    $("#plaka_no").val(item.plaka_no);
                }
            })
            $("#konteyner_cikis_icin_girenleri_getir").modal("hide");
        });

        $("body").off("click", "#konteyner_cikis_icin_girenleri_getir_kapat").on("click", "#konteyner_cikis_icin_girenleri_getir_kapat", function () {
            $("#konteyner_cikis_icin_girenleri_getir").modal("hide");
        });

    </script>
    <?php
}