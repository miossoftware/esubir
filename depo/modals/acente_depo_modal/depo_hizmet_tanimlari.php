<?php


$islem = $_GET["islem"];

if ($islem == "yeni_depo_hizmeti_tanim_button") {
    ?>
    <style>
        #cari_hizmet_tanimla_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="cari_hizmet_tanimla_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 40%; max-width: 40%">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="depo_hizmet_tanimlari_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>HİZMET TANIMLARI</div>
                        </div>
                        <div class="modal-body">
                            <div id="carileri_getir_div"></div>
                            <nav class="nav nav-pills flex-column flex-sm-row">
                                <a class="flex-sm-fill text-sm-center nav-link active cari_page_color"
                                   aria-current="page"
                                   id="cari_tanimlari" style="font-weight: bold">MÜŞTERİYE HİZMET TANIMLA</a>
                                <a class="flex-sm-fill text-sm-center nav-link cari_page_color"
                                   style="font-weight: bold"
                                   id="cari_alis_irsaliyeleri">MÜŞTERİLERE EK HİZMET TANIMLA</a>
                            </nav>
                            <div class="musteriye_ozel_hizmet">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Cari Adı</label>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" id="secilen_cari">
                                            <div class="input-group-append">
                                                <button class="btn btn-warning btn-sm" id="cari_getir_modal"><i
                                                            class="fa fa-ellipsis-h"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Günlük Ücret</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" id="gunluk_ucret"
                                               style="text-align: right">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Depo Ücreti</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm"
                                               style="text-align: right" id="depo_ucreti">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Konteyner Tipi</label>
                                    </div>
                                    <div class="col-md-7">
                                        <select class="custom-select custom-select-sm" id="konteyner_tipi">
                                            <option value="">Konteyner Tipi</option>
                                            <option value="40 HC">40 HC</option>
                                            <option value="20 DC">20 DC</option>
                                            <option value="40 DC">40 DC</option>
                                            <option value="20 OT">20 OT</option>
                                            <option value="40 OT">40 OT</option>
                                            <option value="20 RF">20 RF</option>
                                            <option value="40 RF">40 RF</option>
                                            <option value="40 HC RF">40 HC RF</option>
                                            <option value="20 TANK">20 TANK</option>
                                            <option value="20 VENTILATED">20 VENTILATED</option>
                                            <option value="40 HC PAL. WIDE">40 HC PAL. WIDE</option>
                                            <option value="20 FLAT">20 FLAT</option>
                                            <option value="40 FLAT">40 FLAT</option>
                                            <option value="40 HC FLAT">40 HC FLAT</option>
                                            <option value="20 PLATFORM">20 PLATFORM</option>
                                            <option value="40 PLATFORM">40 PLATFORM</option>
                                            <option value="45 HC">45 HC</option>
                                            <option value="KARGO">KARGO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Free Time</label>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="input-group">
                                            <input style="text-align: right" type="number"
                                                   class="form-control form-control-sm" value="0" id="free_time">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="musterilere_ek_hizmet" style="display: none">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Cari Adı</label>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm" id="secilen_cari2">
                                            <div class="input-group-append">
                                                <button class="btn btn-warning btn-sm" id="cari_getir_modal2"><i class="fa fa-ellipsis-h"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Hizmet Adı</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" id="hizmet_adi">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Hizmet Fiyat</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" id="hizmet_fiyat"
                                               style="text-align: right">
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
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="depo_hizmet_tanimlari_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="depo_hizmet_ekle_button"><i
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
            $("#cari_hizmet_tanimla_modal").modal("show");
        });

        $("body").off("click", "#depo_hizmet_ekle_button").on("click", "#depo_hizmet_ekle_button", function () {
            let cari_id = $("#secilen_cari").attr("data-id");
            let cari_id2 = $("#secilen_cari2").attr("data-id");
            let free_time = $("#free_time").val();
            let hizmet_adi = $("#hizmet_adi").val();
            let hizmet_fiyat = $("#hizmet_fiyat").val();
            hizmet_fiyat = hizmet_fiyat.replace(/\./g, "").replace(",", ".");
            hizmet_fiyat = parseFloat(hizmet_fiyat);
            let konteyner_tipi = $("#konteyner_tipi").val();
            let depo_ucreti = $("#depo_ucreti").val();
            depo_ucreti = depo_ucreti.replace(/\./g, "").replace(",", ".");
            depo_ucreti = parseFloat(depo_ucreti);
            let gunluk_ucret = $("#gunluk_ucret").val();
            gunluk_ucret = gunluk_ucret.replace(/\./g, "").replace(",", ".");
            gunluk_ucret = parseFloat(gunluk_ucret);
            let aciklama = $("#aciklama").val();

            if (cari_id == undefined || cari_id == "") {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'mx-2 btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Uyarı',
                    text: "Herhangi Bir Acente Seçimi Yapmadınız Devam Etmek İstiyormusunuz ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Evet',
                    cancelButtonText: 'Hayır',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "depo/controller/acente_controller/sql.php?islem=depo_acente_tanimlari_kaydet_sql",
                            type: "POST",
                            data: {
                                cari_id: cari_id,
                                free_time: free_time,
                                hizmet_adi: hizmet_adi,
                                hizmet_fiyat: hizmet_fiyat,
                                konteyner_tipi: konteyner_tipi,
                                depo_ucreti: depo_ucreti,
                                gunluk_ucret: gunluk_ucret,
                                cari_id2: cari_id2,
                                aciklama: aciklama
                            },
                            success: function (res) {
                                if (res == 1) {
                                    Swal.fire(
                                        "Başarılı",
                                        "Tanımlamalar Kaydedildi",
                                        "success"
                                    );
                                    $("#cari_hizmet_tanimla_modal").modal("hide");
                                    $.get("depo/view/depo_acente_tanimlari.php", function (getList) {
                                        $(".admin-modal-icerik").html(getList);
                                    });
                                    $.get("depo/view/depo_acente_tanimlari.php", function (getList) {
                                        $(".modal-icerik").html(getList);
                                    });
                                }
                            }
                        });
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Vazgeçildi',
                            'İşlemden Vazgeçtiniz..',
                            'error'
                        )
                    }
                })
            } else {
                $.ajax({
                    url: "depo/controller/acente_controller/sql.php?islem=depo_acente_tanimlari_kaydet_sql",
                    type: "POST",
                    data: {
                        cari_id: cari_id,
                        free_time: free_time,
                        hizmet_adi: hizmet_adi,
                        hizmet_fiyat: hizmet_fiyat,
                        konteyner_tipi: konteyner_tipi,
                        depo_ucreti: depo_ucreti,
                        gunluk_ucret: gunluk_ucret,
                        aciklama: aciklama
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Tanımlamalar Kaydedildi",
                                "success"
                            );
                            $("#cari_hizmet_tanimla_modal").modal("hide");
                            $.get("depo/view/depo_acente_tanimlari.php", function (getList) {
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/depo_acente_tanimlari.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }
        });

        $("body").off("click", "#cari_getir_modal").on("click", "#cari_getir_modal", function () {
            $.get("modals/alis_modal/modal_page.php?islem=cariler_listesi_getir_modal", function (getModal) {
                $("#carileri_getir_div").html(getModal);
            })
        });

        $("body").off("click", "#cari_getir_modal2").on("click", "#cari_getir_modal2", function () {
            $.get("modals/alis_modal/modal_page.php?islem=cariler_listesi_getir_modal2", function (getModal) {
                $("#carileri_getir_div").html(getModal);
            })
        });


        $("body").off("focusout", "#hizmet_fiyat").on("focusout", "#hizmet_fiyat", function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
            $(this).val(val);
        });


        $("body").off("focusout", "#depo_ucreti").on("focusout", "#depo_ucreti", function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
            $(this).val(val);
        });


        $("body").off("focusout", "#gunluk_ucret").on("focusout", "#gunluk_ucret", function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
            $(this).val(val);
        });

        $("body").off("click", "#cari_tanimlari").on("click", "#cari_tanimlari", function () {
            $(".cari_page_color").removeClass("active");
            $(this).addClass("active");
            $(".musteriye_ozel_hizmet").show();
            $(".musterilere_ek_hizmet").hide();
            $(".paging_ekstre").html("");
        })
        $("body").off("click", "#cari_alis_irsaliyeleri").on("click", "#cari_alis_irsaliyeleri", function () {
            $(".cari_page_color").removeClass("active");
            $(this).addClass("active");
            $(".musteriye_ozel_hizmet").hide();
            $(".musterilere_ek_hizmet").show();
            setTimeout(function () {
                $("#click9").trigger("click");
            }, 500);
        })

        $("body").off("click", "#depo_hizmet_tanimlari_kapat").on("click", "#depo_hizmet_tanimlari_kapat", function () {
            $("#cari_hizmet_tanimla_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "yeni_depo_kondisyon_tanim_button") {
    ?>
    <style>
        #depo_kondisyon_tanimlari {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="depo_kondisyon_tanimlari" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 40%; max-width: 40%">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="depo_kondisyon_tanimlari_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>HİZMET TANIMLARI</div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Kondisyon Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="kondisyon_adi">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="depo_kondisyon_tanimlari_kapat"><i
                                        class="fa fa-trash"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="kondisyon_kaydet"><i class="fa fa-trash"></i>
                                Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function () {
            $("#depo_kondisyon_tanimlari").modal("show");
        });

        $("body").off("click", "#kondisyon_kaydet").on("click", "#kondisyon_kaydet", function () {
            let kondisyon_adi = $("#kondisyon_adi").val();
            if (kondisyon_adi == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Kondisyon Adı Giriniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "depo/controller/acente_controller/sql.php?islem=acente_kondisyon_tanim_kaydet_sql",
                    type: "POST",
                    data: {
                        kondisyon_adi: kondisyon_adi
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Kondisyon Kaydedildi",
                                "success"
                            );
                            $.get("depo/view/depo_acente_kondisyon_tanimlari.php", function (getList) {
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/depo_acente_kondisyon_tanimlari.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            });
                            $("#depo_kondisyon_tanimlari").modal("hide");
                        }
                    }
                });
            }
        });

    </script>

    <?php
}