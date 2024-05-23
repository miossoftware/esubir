<?php


$islem = $_GET["islem"];

if ($islem == "estimate_is_baslat_modal") {
    ?>
    <style>
        #estimate_is_basi_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="estimate_is_basi_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 55%; max-width: 55%">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="estimate_is_basi_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ESTİAMTE İŞ BAŞI</div>
                        </div>
                        <div class="modal-body">
                            <div class="estimate_konteynerler_div"></div>
                            <div class="konteyner_irasliye_suruculeri_getir_div"></div>
                            <div class="konteyner_tanim_cari_div"></div>
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
                                                            id="estimate_yapilan_konteynernerler_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Acente Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="acente_adi"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Konteyner Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" disabled
                                                   id="konteyner_tipi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Hasar Açıklaması</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" disabled
                                                   id="hasar_aciklamasi">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Personel Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="usta_adi"
                                                       data-id="">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="personel_button"><i
                                                                class="fa fa-ellipsis-h"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Cari Kodu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="firma_kodu"
                                                       data-id="">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="firma_kodu_button"><i
                                                                class="fa fa-ellipsis-h"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Cari Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="firma_adi"
                                                   disabled>
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
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="estimate_is_basi_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="estimate_is_basi_kaydet_button"><i
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
            $("#estimate_is_basi_modal").modal("show");
        });

        $("body").off("click", "#estimate_is_basi_modal_kapat").on("click", "#estimate_is_basi_modal_kapat", function () {
            $("#estimate_is_basi_modal").modal("hide");
        });

        $("body").off("click", "#estimate_yapilan_konteynernerler_button").on("click", "#estimate_yapilan_konteynernerler_button", function () {
            $.get("depo/modals/acente_depo_modal/estimate_is_basi.php?islem=estimate_olan_konteynerler_modal", function (getModal) {
                $(".estimate_konteynerler_div").html(getModal);
            })
        });
        $("body").off("click", "#personel_button").on("click", "#personel_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=irsaliye_icin_suruculeri_getir", function (getModal) {
                $(".konteyner_irasliye_suruculeri_getir_div").html(getModal);
            });
        });

        $("body").off("click", "#firma_kodu_button").on("click", "#firma_kodu_button", function () {
            $.get("depo/modals/nakliye_depolama_modal/nakliye_depolama.php?islem=nakliye_giris_carileri_getir", function (getModal) {
                $(".konteyner_tanim_cari_div").html(getModal);
            })
        });

        $("body").off("click", "#estimate_is_basi_kaydet_button").on("click", "#estimate_is_basi_kaydet_button", function () {
            let estimate_id = $("#konteyner_no").attr("data-id");
            let personel_adi = $("#usta_adi").val();
            let personel_id = $("#usta_adi").attr("data-id");
            let cari_adi = $("#firma_adi").val();
            let cari_kodu = $("#firma_kodu").val();
            let cari_id = $("#firma_kodu").attr("data-id");
            let aciklama = $("#aciklama").val();

            if (estimate_id == undefined || estimate_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Konteyner Seçiniz...",
                    "warning"
                );
            } else if (personel_id == "" && cari_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Personel Veya Bir Cari Seçiniz...",
                    "warning"
                );
            } else if (personel_id != "" && cari_id != "") {
                Swal.fire(
                    "Uyarı!",
                    "Personel Veya Caride Sadece Birini Seçebilirsiniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "depo/controller/acente_controller/sql.php?islem=estimate_is_basi_kaydet_sql",
                    type: "POST",
                    data: {
                        estimate_id: estimate_id,
                        cari_kodu: cari_kodu,
                        personel_id: personel_id,
                        personel_adi: personel_adi,
                        cari_adi: cari_adi,
                        cari_id: cari_id,
                        aciklama: aciklama
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı!",
                                "Estimate İşi Başlatıldı",
                                "success"
                            );
                            $("#estimate_is_basi_modal").modal("hide");
                            $.get("depo/view/acente_puantor_islemleri.php", function (getList) {
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/acente_puantor_islemleri.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }
        });

    </script>
    <?php
}
if ($islem == "estimate_olan_konteynerler_modal") {
    ?>
    <div class="modal fade" id="estimate_emirli_konteynerler_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="acente_giris_konteynerleri"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ESTİMATE EMİRLİ KONTEYNERLER
                            </div>
                        </div>
                        <div class="modal-body">
                            <table class="table table-sm table-bordered w-100 display nowrap"
                                   style="cursor:pointer;font-size: 13px;"
                                   id="is_emri_select_liste">
                                <thead>
                                <tr>
                                    <th>Konteyner No</th>
                                    <th>Konteyner Tipi</th>
                                    <th>Acente Adı</th>
                                    <th>Hasar Açıklaması</th>
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
            $("#estimate_emirli_konteynerler_modal").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 500);
            var table = $('#is_emri_select_liste').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "konteyner_no"},
                    {'data': "konteyner_tipi"},
                    {'data': "acente_adi"},
                    {'data': "aciklama"}
                ],
                createdRow: function (row) {
                    $(row).addClass("giris_yapan_kont_selected");
                    $(row).find('td').css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                    $(row).addClass("estimate_emri_alan_kont");
                }
            });

            $.get("depo/controller/acente_controller/sql.php?islem=estimate_emirli_konteynerler", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                }
            })

            $("body").off("click", ".estimate_emri_alan_kont").on("click", ".estimate_emri_alan_kont", function () {
                let id = $(this).attr("data-id");
                $.get("depo/controller/acente_controller/sql.php?islem=secilen_estimateli_konteyner_sql", {id: id}, function (res) {
                    if (res != 2) {
                        var item = JSON.parse(res);
                        $("#konteyner_no").attr("data-id", item.id);
                        $("#konteyner_no").val(item.konteyner_no);
                        $("#konteyner_tipi").val(item.konteyner_tipi);
                        $("#acente_adi").val(item.acente_adi);
                        $("#hasar_aciklamasi").val(item.aciklama);
                        $("#estimate_emirli_konteynerler_modal").modal("hide");
                    }
                });
            });

        });

        $("body").off("click", "#acente_giris_konteynerleri").on("click", "#acente_giris_konteynerleri", function () {
            $("#estimate_emirli_konteynerler_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "estimate_is_basi_guncelle_modal") {
    ?>
    <style>
        #estimate_is_basi_guncelle_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="estimate_is_basi_guncelle_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 55%; max-width: 55%">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="estimate_is_basi_guncelle_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ESTİAMTE İŞ BAŞI</div>
                        </div>
                        <div class="modal-body">
                            <div class="estimate_konteynerler_div"></div>
                            <div class="konteyner_irasliye_suruculeri_getir_div"></div>
                            <div class="konteyner_tanim_cari_div"></div>
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
                                                            id="estimate_yapilan_konteynernerler_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Acente Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="acente_adi"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Konteyner Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" disabled
                                                   id="konteyner_tipi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Hasar Açıklaması</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" disabled
                                                   id="hasar_aciklamasi">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Personel Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="usta_adi"
                                                       data-id="">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="personel_button"><i
                                                                class="fa fa-ellipsis-h"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Cari Kodu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="firma_kodu"
                                                       data-id="">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="firma_kodu_button"><i
                                                                class="fa fa-ellipsis-h"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Cari Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="firma_adi"
                                                   disabled>
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
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="estimate_is_basi_guncelle_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="estimate_is_basi_kaydet_button"><i
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
            $("#estimate_is_basi_guncelle_modal").modal("show");

            $.get("depo/controller/acente_controller/sql.php?islem=estimate_emir_bilgileri_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#konteyner_no").val(item.konteyner_no);
                    $("#konteyner_no").attr("data-id", item.estimate_id);
                    $("#acente_adi").val(item.acente_adi);
                    $("#konteyner_tipi").val(item.konteyner_tipi);
                    $("#hasar_aciklamasi").val(item.hasar_aciklamasi);
                    let personel_id = item.personel_id;
                    if (personel_id == 0) {
                        personel_id = "";
                    }
                    let cari_id = item.cari_id;
                    if (cari_id == 0) {
                        cari_id = "";
                    }
                    $("#usta_adi").attr("data-id", personel_id);
                    $("#usta_adi").val(item.personel_adi);
                    $("#firma_kodu").attr("data-id", cari_id);
                    $("#firma_kodu").val(item.cari_kodu);
                    $("#firma_adi").val(item.cari_adi);
                    $("#aciklama").val(item.aciklama);
                }
            })
        });

        $("body").off("click", "#estimate_is_basi_guncelle_modal_kapat").on("click", "#estimate_is_basi_guncelle_modal_kapat", function () {
            $("#estimate_is_basi_guncelle_modal").modal("hide");
        });

        $("body").off("click", "#estimate_yapilan_konteynernerler_button").on("click", "#estimate_yapilan_konteynernerler_button", function () {
            $.get("depo/modals/acente_depo_modal/estimate_is_basi.php?islem=estimate_olan_konteynerler_modal", function (getModal) {
                $(".estimate_konteynerler_div").html(getModal);
            })
        });
        $("body").off("click", "#personel_button").on("click", "#personel_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=irsaliye_icin_suruculeri_getir", function (getModal) {
                $(".konteyner_irasliye_suruculeri_getir_div").html(getModal);
            });
        });

        $("body").off("click", "#firma_kodu_button").on("click", "#firma_kodu_button", function () {
            $.get("depo/modals/nakliye_depolama_modal/nakliye_depolama.php?islem=nakliye_giris_carileri_getir", function (getModal) {
                $(".konteyner_tanim_cari_div").html(getModal);
            })
        });

        $("body").off("click", "#estimate_is_basi_kaydet_button").on("click", "#estimate_is_basi_kaydet_button", function () {
            let estimate_id = $("#konteyner_no").attr("data-id");
            let personel_adi = $("#usta_adi").val();
            let personel_id = $("#usta_adi").attr("data-id");
            let cari_adi = $("#firma_adi").val();
            let cari_kodu = $("#firma_kodu").val();
            let cari_id = $("#firma_kodu").attr("data-id");
            let aciklama = $("#aciklama").val();

            if (estimate_id == undefined || estimate_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Konteyner Seçiniz...",
                    "warning"
                );
            } else if (personel_id == "" && cari_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Personel Veya Bir Cari Seçiniz...",
                    "warning"
                );
            } else if (personel_id != "" && cari_id != "") {
                Swal.fire(
                    "Uyarı!",
                    "Personel Veya Caride Sadece Birini Seçebilirsiniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "depo/controller/acente_controller/sql.php?islem=estimate_is_basi_guncelle_sql",
                    type: "POST",
                    data: {
                        estimate_id: estimate_id,
                        cari_kodu: cari_kodu,
                        personel_id: personel_id,
                        personel_adi: personel_adi,
                        cari_adi: cari_adi,
                        cari_id: cari_id,
                        aciklama: aciklama,
                        id: "<?=$_GET["id"]?>"
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı!",
                                "Estimate İşi Başlatıldı",
                                "success"
                            );
                            $("#estimate_is_basi_guncelle_modal").modal("hide");
                            $.get("depo/view/acente_puantor_islemleri.php", function (getList) {
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/acente_puantor_islemleri.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }
        });

    </script>
    <?php
}
if ($islem == "acente_ek_hizmet_ekle_button") {
    ?>
    <style>
        #estimate_ek_hizmet_ekle_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="estimate_ek_hizmet_ekle_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 50%; max-width: 50%">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="estimate_ek_hizmet_ekle_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>KONTEYNER EK HİZMET EKLE
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="giris-yapmis-konteynerler"></div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Konteyner No</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="konteyner_no">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm"
                                                    id="giris_yapmis_konteynerler"><i
                                                        class="fa fa-ellipsis-h"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Ek Hizmet</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="custom-select custom-select-sm" id="ek_hizmetler">
                                        <option value="">Ek Hizmet Seçiniz...</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="estimate_ek_hizmet_ekle_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="estimate_ek_hizmet_kaydet_button"><i
                                        class="fa fa-close"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function () {
            $("#estimate_ek_hizmet_ekle_modal").modal("show");

            $.get("depo/controller/acente_controller/sql.php?islem=ek_hizmetleri_getir_sql", function (res) {
                if (res != 2) {
                    let json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#ek_hizmetler").append("" +
                            "<option value='" + item.id + "'>" + item.hizmet_adi + "</option>" +
                            "");
                    });
                }
            })
        });

        $("body").off("click", "#estimate_ek_hizmet_kaydet_button").on("click", "#estimate_ek_hizmet_kaydet_button", function () {
            let konteyner_id = $("#konteyner_no").attr("data-id");
            let konteyner_no = $("#konteyner_no").val();
            let ek_hizmet_id = $("#ek_hizmetler").val();
            let ek_hizmet_adi = $("#ek_hizmetler option:selected").text();
            if (konteyner_id == undefined || konteyner_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Konteyner Seçiniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "depo/controller/acente_controller/sql.php?islem=konteynere_ek_hizmet_ekle_sql",
                    type: "POST",
                    data: {
                        konteyner_id: konteyner_id,
                        konteyner_no: konteyner_no,
                        ek_hizmet_adi: ek_hizmet_adi,
                        ek_hizmet_id: ek_hizmet_id
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Konteynere Ek Hizmet Eklendi",
                                "success"
                            );
                            $("#estimate_ek_hizmet_ekle_modal").modal("hide");
                            $.get("depo/view/acente_puantor_islemleri.php", function (getList) {
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/acente_puantor_islemleri.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }
        });


        $("body").off("click", "#giris_yapmis_konteynerler").on("click", "#giris_yapmis_konteynerler", function () {
            $.get("depo/modals/acente_depo_modal/estimate_modal.php?islem=giris_yapmis_konteynerleri_getir", function (getModal) {
                $(".giris-yapmis-konteynerler").html(getModal)
            })
        });

        $("body").off("click", "#estimate_ek_hizmet_ekle_modal_kapat").on("click", "#estimate_ek_hizmet_ekle_modal_kapat", function () {
            $("#estimate_ek_hizmet_ekle_modal").modal("hide");
        });

    </script>
    <?php
}