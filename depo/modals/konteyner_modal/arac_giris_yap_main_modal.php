<?php

$islem = $_GET["islem"];

if ($islem == "arac_giris_yap_main_modal") {
    ?>
    <style>
        #arac_giris_main_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="arac_giris_main_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="arac_giris_main_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ARAÇ GİRİŞ</div>
                        </div>
                        <div class="modal-body">
                            <div class="konteyner_irasliye_suruculeri_getir_div"></div>
                            <div class="tanimli_konteynerleri_getir_div"></div>
                            <div class="konteyner_irasliye_plakalari_getir_div"></div>
                            <div class="yeni_mal_cinsi_ekle"></div>
                            <div class="mal_cinsleri_div"></div>
                            <div id="carileri_getir_irsaliye"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Plaka No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="plaka_no">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="tanimli_tektek_arabalari_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Giriş Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" class="form-control form-control-sm" id="giris_tarihi"
                                                   value="<?= date("Y-m-d") ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Cari Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="cari_id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="cari_getir_modal_irsaliye"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>İş Emirleri</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="epro_ref">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="is_emirlerini_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Miktar</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="miktar"
                                                   style="text-align: right">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Sürücü Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="surucu_adi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Sürücü Tel</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="surucu_tel">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Referans</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="referans_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Beyanname No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="beyanname_no">
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
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Sahaya Ser</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="sahaya_ser">
                                                <option value="2">Serilmesin</option>
                                                <option value="1">Serilsin</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="arac_giris_main_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="depo_arac_giris_kaydet_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        $("body").off("click", "#cari_getir_modal_irsaliye").on("click", "#cari_getir_modal_irsaliye", function () {
            $.get("modals/alis_modal/alis_irsaliye_page.php?islem=irsaliye_icin_carileri_getir", function (getModal) {
                $("#carileri_getir_irsaliye").html("");
                $("#carileri_getir_irsaliye").html(getModal);
            })
        });

        $("body").off("click", "#is_emirlerini_getir_button").on("click", "#is_emirlerini_getir_button", function () {
            $.get("depo/modals/konteyner_modal/arac_giris_yap_main_modal.php?islem=is_emirlerini_getir_sql", function (getModal) {
                $("#carileri_getir_irsaliye").html(getModal);
            })
        });

        $("body").off("click", "#mal_cinsi_ekle_button").on("click", "#mal_cinsi_ekle_button", function () {
            $.get("depo/modals/siparis_modal/depo_siparis_olustur.php?islem=yeni_mal_cinsi_ekle_modal", function (getModal) {
                $(".yeni_mal_cinsi_ekle").html(getModal);
            })
        });

        $("body").off("click", "#mal_cinslerini_getir_button").on("click", "#mal_cinslerini_getir_button", function () {
            $.get("depo/modals/siparis_modal/depo_siparis_olustur.php?islem=mal_cinslerini_getir_modal", function (getModal) {
                $(".mal_cinsleri_div").html(getModal);
            })
        });

        $(document).ready(function () {
            $("#arac_giris_main_modal").modal("show");

            $.get("depo/controller/depo_controller/sql.php?islem=birimleri_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#birim_id").append("<option value='" + item.id + "'>" + item.birim_adi + "</option>");
                    })
                }
            });
        });

        $("body").off("keyup", "#plaka_no").on("keyup", "#plaka_no", function () {
            let val = $(this).val();
            $.get("depo/controller/tanim_controller/sql.php?islem=secilen_tanimli_araclari_getir_sql", {plaka_no: val}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#plaka_no").val(item.plaka_no);
                    $("#plaka_no").attr("data-id", item.id);
                    $("#surucu_adi").val(item.surucu_adi);
                    $("#surucu_tel").val(item.surucu_tel);
                    $("#cari_id").val(item.cari_adi);
                    $("#cari_id").attr("data-id", item.cari_id);
                    $("#referans_no").val(item.acente_ref);
                    $("#beyanname_no").val(item.beyanname_no);
                    $("#epro_ref").val(item.epro_ref);
                    $("#epro_ref").attr("data-id", item.is_emir_id);
                    $("#acenta").val(item.acente);
                    $("#alim_yeri").val(item.alim_yeri);
                    $("#fabrika_ref").val(item.fabrika_ref);
                    $("#mal_kodu").attr("data-id", item.mal_id);
                    $("#mal_kodu").val(item.urun_adi);
                    $("#birim_id").val(item.birim_id);
                } else {
                    $("#plaka_no").attr("data-id", "");
                    $("#surucu_adi").val("");
                    $("#surucu_tel").val("");
                    $("#cari_id").val("");
                    $("#cari_id").attr("data-id", "");
                    $("#referans_no").val("");
                    $("#beyanname_no").val("");
                    $("#epro_ref").val("");
                    $("#epro_ref").attr("data-id", "");
                    $("#acenta").val("");
                    $("#alim_yeri").val("");
                    $("#fabrika_ref").val("");
                    $("#mal_kodu").attr("data-id", "");
                    $("#mal_kodu").val("");
                    $("#birim_id").val("");
                }
            })
        });

        $("body").off("focusout", "#miktar").on("focusout", "#miktar", function () {
            let miktar = $(this).val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            if (isNaN(miktar)) {
                miktar = 0;
            }
            $(this).val(miktar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });


        $("body").off("click", "#irsaliye_plakalari_getir_button").on("click", "#irsaliye_plakalari_getir_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=irsaliye_plakalari_getir", function (getModal) {
                $(".konteyner_irasliye_plakalari_getir_div").html("");
                $(".konteyner_irasliye_plakalari_getir_div").html(getModal);
            });
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

        $("body").off("focusout", "#surucu_prim").on("focusout", "#surucu_prim", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });

        $("body").off("click", "#depo_arac_giris_kaydet_button").on("click", "#depo_arac_giris_kaydet_button", function () {
            let giris_tarihi = $("#giris_tarihi").val();
            let plaka_no = $("#plaka_no").val();
            let plaka_id = $("#plaka_no").attr("data-id");
            let surucu_adi = $("#surucu_adi").val();
            let surucu_tel = $("#surucu_tel").val();
            let cari_id = $("#cari_id").attr("data-id");
            let is_emir_id = $("#epro_ref").attr("data-id");
            let epro_ref = $("#epro_ref").val();
            let referans_no = $("#referans_no").val();
            let beyanname_no = $("#beyanname_no").val();
            let aciklama = $("#aciklama").val();
            let miktar = $("#miktar").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            if (isNaN(miktar)) {
                miktar = 0;
            }
            let serilsin_mi = $("#sahaya_ser").val();

            if (plaka_no == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Giriş Yapan Plakayı Giriniz...",
                    "warning"
                );
            } else if (giris_tarihi == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Giriş Tarihi Belirtiniz...",
                    "warning"
                );
            } else if (cari_id == undefined || cari_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Cari Seçiniz...",
                    "warning"
                );
            } else if (is_emir_id == undefined || is_emir_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir İş Emri Seçiniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "depo/controller/konteyner_controller/sql.php?islem=arac_giris_kaydet_sql",
                    type: "POST",
                    data: {
                        giris_tarihi: giris_tarihi,
                        plaka_no: plaka_no,
                        miktar: miktar,
                        plaka_id: plaka_id,
                        surucu_adi: surucu_adi,
                        surucu_tel: surucu_tel,
                        cari_id: cari_id,
                        is_emri_id: is_emir_id,
                        epro_ref: epro_ref,
                        referans_no: referans_no,
                        beyanname_no: beyanname_no,
                        serilsin_mi: serilsin_mi,
                        aciklama: aciklama
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Araç Giriş Kaydedildi",
                                "success"
                            );
                            $("#arac_giris_main_modal").modal("hide");
                            $.get("depo/view/arac_giris_main.php", function (getList) {
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/arac_giris_main.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }
        });

        $("body").off("keyup", "#konteyner_no").on("keyup", "#konteyner_no", function () {
            let val = $(this).val();
            $.get("depo/controller/konteyner_controller/sql.php?islem=tanimli_konteynerleri_getir_sql", {konteyner_no: val}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#konteyner_no").attr("data-id", item.id);
                    $("#referans_no").val(item.acente_ref);
                    $("#beyanname_no").val(item.beyanname_no);
                    $("#konteyner_tipi").val(item.konteyner_tipi);
                    $("#cari_id").val(item.cari_adi)
                    $("#cari_id").attr("data-id", item.cari_id)
                    let cut_of = item.cutt_off_tarihi;
                    if (cut_of != null) {
                        cut_of = cut_of.split(" ");
                        cut_of = cut_of[0];
                    }
                    let ardiyesiz_giris_tarihi = item.ardiyesiz_giris_tarihi;
                    if (ardiyesiz_giris_tarihi != null) {
                        ardiyesiz_giris_tarihi = ardiyesiz_giris_tarihi.split(" ");
                        ardiyesiz_giris_tarihi = ardiyesiz_giris_tarihi[0];
                    }
                    let demoraj_tarihi = item.demoraj_tarihi;
                    if (demoraj_tarihi != null) {
                        demoraj_tarihi = demoraj_tarihi.split(" ");
                        demoraj_tarihi = demoraj_tarihi[0];
                    }
                    $("#cut_off_tarihi").val(cut_of);
                    $("#ardiyesiz_giris_tarihi").val(ardiyesiz_giris_tarihi);
                    $("#demoraj_tarihi").val(demoraj_tarihi);
                    $("#tipi").val(item.tipi);
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
                }
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
                        $("#arac_cari_adi").val((item.cari_adi).toUpperCase())
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
                    $("#arac_cari_adi").val("");
                    $("#surucu_id").val("");
                    $("#surucu_id").attr("data-id", "");
                }
            })
        });

        $("body").off("click", "#irsaliye_icin_suruculeri_getir_button").on("click", "#irsaliye_icin_suruculeri_getir_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=irsaliye_icin_suruculeri_getir", function (getModal) {
                $(".konteyner_irasliye_suruculeri_getir_div").html("");
                $(".konteyner_irasliye_suruculeri_getir_div").html(getModal);
            });
        });

        $("body").off("click", "#tanimli_konteynerleri_getir_button").on("click", "#tanimli_konteynerleri_getir_button", function () {
            $.get("depo/modals/konteyner_modal/konteyner_giris.php?islem=tanimli_konteynerleri_getir_modal", function (getModal) {
                $(".tanimli_konteynerleri_getir_div").html("");
                $(".tanimli_konteynerleri_getir_div").html(getModal);
            });
        });

        $("body").off("click", "#tanimli_tektek_arabalari_getir_button").on("click", "#tanimli_tektek_arabalari_getir_button", function () {
            $.get("depo/modals/konteyner_modal/arac_giris_yap_main_modal.php?islem=tanimli_araclari_getir_modal", function (getModal) {
                $(".tanimli_konteynerleri_getir_div").html("");
                $(".tanimli_konteynerleri_getir_div").html(getModal);
            });
        });

        $("body").off("click", "#arac_giris_main_modal_kapat").on("click", "#arac_giris_main_modal_kapat", function () {
            $("#arac_giris_main_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "is_emirlerini_getir_sql") {
    ?>
    <div class="modal fade" id="depo_siparisleri_getir_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="depo_siparisleri_getir_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>SİPARİŞLER</div>
                        </div>
                        <div class="modal-body">
                            <table class="table table-sm table-bordered w-100 display nowrap"
                                   style="cursor:pointer;font-size: 13px;"
                                   id="is_emri_depo_siparsileri_table_list">
                                <thead>
                                <tr>
                                    <th id="click1">Acenta</th>
                                    <th>Referans</th>
                                    <th>Beyanname No</th>
                                    <th>Sipariş Tarihi</th>
                                    <th>CUT - OFF Tarihi</th>
                                    <th>Ardiyesiz Giriş</th>
                                    <th>Demoraj Tarihi</th>
                                    <th>Alım Yeri</th>
                                    <th>Epro Ref.</th>
                                    <th>Tipi</th>
                                    <th>Açıklama</th>
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
            $("#depo_siparisleri_getir_modal").modal("show");

            setTimeout(function () {
                $("#click1").trigger("click");
            }, 500);

            var table = $('#is_emri_depo_siparsileri_table_list').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "acente"},
                    {'data': "referans_no"},
                    {'data': "beyanname_no"},
                    {'data': "siparis_tarihi"},
                    {'data': "cut_of_tarihi"},
                    {'data': "ardiyesiz_giris_tarihi"},
                    {'data': "demoraj_tarihi"},
                    {'data': "alim_yeri"},
                    {'data': "epro_ref"},
                    {'data': "tipi"},
                    {'data': "aciklama"}
                ],
                createdRow: function (row, data) {
                    $(row).addClass("depo_siparis_selected");
                    $(row).find('td').css('text-align', 'left');
                    $(row).attr("data-id", data.id);
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $.get("depo/controller/is_emri_controller/sql.php?islem=tum_is_emirlerini_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                }
            })
        });

        $("body").off("click", ".depo_siparis_selected").on("click", ".depo_siparis_selected", function () {
            let id = $(this).attr("data-id");
            $.get("depo/controller/is_emri_controller/sql.php?islem=is_emrinin_ana_bilgilerini_getir_sql", {id: id}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#cari_id").val(item.cari_adi);
                    $("#cari_id").attr("data-id", item.cari_id);
                    $("#firma_unvan").val(item.cari_adi);
                    $("#vergi_dairesi").val(item.vergi_dairesi);
                    $("#vergi_no").val(item.vergi_no);
                    $("#adres").val(item.adres);
                    $("#referans_no").val(item.acente_ref);
                    $("#beyanname_no").val(item.beyanname_no);
                    $("#siparis_ep_ref").val(item.epro_ref);
                    $("#siparis_ep_ref").attr("data-id", id);
                    $("#epro_ref").val(item.epro_ref);
                    $("#epro_ref").attr("data-id", id);
                    $("#acenta").val(item.acente);
                    $("#acenta_ref").val(item.referans_no);
                    $("#referans_no").val(item.referans_no);
                    $("#alim_yeri").val(item.alim_yeri);
                    $("#fabrika_ref").val(item.fabrika_ref);
                    $("#mal_kodu").attr("data-id", item.mal_id);
                    $("#mal_kodu").val(item.urun_adi);
                    $("#birim_id").val(item.birim_id);
                }
            })
            $("#depo_siparisleri_getir_modal").modal("hide");
        });

        $("body").off("click", "#depo_siparisleri_getir_modal_kapat").on("click", "#depo_siparisleri_getir_modal_kapat", function () {
            $("#depo_siparisleri_getir_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "tanimli_araclari_getir_modal") {
    ?>
    <div class="modal fade" id="depo_tanimli_araclari_getir_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="depo_tanimli_araclari_getir_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>TANIMLI ARAÇLAR</div>
                        </div>
                        <div class="modal-body">
                            <table class="table table-sm table-bordered w-100 display nowrap"
                                   style="cursor:pointer;font-size: 13px;"
                                   id="tanimlanan_araclar_main_table">
                                <thead>
                                <tr>
                                    <th id="click1">Epro. Referans</th>
                                    <th>Araç Plaka</th>
                                    <th>Dorse Plaka</th>
                                    <th>Sürücü Adı</th>
                                    <th>Sürücü Tel</th>
                                    <th>Açıklama</th>
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
            $("#depo_tanimli_araclari_getir_modal").modal("show");

            setTimeout(function () {
                $("#click1").trigger("click");
            }, 500);

            var table = $('#tanimlanan_araclar_main_table').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "epro_ref"},
                    {'data': "plaka_no"},
                    {'data': "dorse_plaka"},
                    {'data': "surucu_adi"},
                    {'data': "surucu_tel"},
                    {'data': "aciklama"}
                ],
                createdRow: function (row, data) {
                    $(row).addClass("tanimli_arac_selected");
                    $(row).find('td').css('text-align', 'left');
                    $(row).attr("data-id", data.arac_id);
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.arac_id); // Her satıra data-id attribütü ekleyin
                }
            })

            $.get("depo/controller/tanim_controller/sql.php?islem=tum_tanimli_araclari_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                }
            });
        });

        $("body").off("click", ".tanimli_arac_selected").on("click", ".tanimli_arac_selected", function () {
            let id = $(this).attr("data-id");
            $.get("depo/controller/tanim_controller/sql.php?islem=secilen_tanimli_araclari_getir_sql", {id: id}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#plaka_no").val(item.plaka_no);
                    $("#plaka_no").attr("data-id", id);
                    $("#surucu_adi").val(item.surucu_adi);
                    $("#surucu_tel").val(item.surucu_tel);
                    $("#cari_id").val(item.cari_adi);
                    $("#cari_id").attr("data-id", item.cari_id);
                    $("#referans_no").val(item.referans_no);
                    $("#beyanname_no").val(item.beyanname_no);
                    $("#epro_ref").val(item.epro_ref);
                    $("#epro_ref").attr("data-id", item.is_emir_id);
                    $("#acenta").val(item.acente);
                    $("#alim_yeri").val(item.alim_yeri);
                    $("#fabrika_ref").val(item.fabrika_ref);
                    $("#mal_kodu").attr("data-id", item.mal_id);
                    $("#mal_kodu").val(item.urun_adi);
                    $("#birim_id").val(item.birim_id);
                }
            })
            $("#depo_tanimli_araclari_getir_modal").modal("hide");
        });

        $("body").off("click", "#depo_tanimli_araclari_getir_modal_kapat").on("click", "#depo_tanimli_araclari_getir_modal_kapat", function () {
            $("#depo_tanimli_araclari_getir_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "arac_giris_guncelle_modal") {
    ?>
    <style>
        #arac_giris_guncelle_main_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="arac_giris_guncelle_main_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="arac_giris_guncelle_main_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ARAÇ GİRİŞ</div>
                        </div>
                        <div class="modal-body">
                            <div class="konteyner_irasliye_suruculeri_getir_div"></div>
                            <div class="tanimli_konteynerleri_getir_div"></div>
                            <div class="konteyner_irasliye_plakalari_getir_div"></div>
                            <div class="yeni_mal_cinsi_ekle"></div>
                            <div class="mal_cinsleri_div"></div>
                            <div id="carileri_getir_irsaliye"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Plaka No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="plaka_no">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="tanimli_tektek_arabalari_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Giriş Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" class="form-control form-control-sm" id="giris_tarihi"
                                                   value="<?= date("Y-m-d") ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Cari Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="cari_id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="cari_getir_modal_irsaliye"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>İş Emirleri</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="epro_ref">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="is_emirlerini_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Miktar</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   style="text-align: right">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Sürücü Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="surucu_adi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Sürücü Tel</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="surucu_tel">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Referans</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="referans_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Beyanname No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="beyanname_no">
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
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Sahaya Serilsinmi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="sahaya_ser">
                                                <option value="2">Serilmesin</option>
                                                <option value="1">Serilsin</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="arac_giris_guncelle_main_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="depo_arac_giris_guncelle_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        $("body").off("click", "#cari_getir_modal_irsaliye").on("click", "#cari_getir_modal_irsaliye", function () {
            $.get("modals/alis_modal/alis_irsaliye_page.php?islem=irsaliye_icin_carileri_getir", function (getModal) {
                $("#carileri_getir_irsaliye").html("");
                $("#carileri_getir_irsaliye").html(getModal);
            })
        });

        $("body").off("click", "#is_emirlerini_getir_button").on("click", "#is_emirlerini_getir_button", function () {
            $.get("depo/modals/konteyner_modal/arac_giris_yap_main_modal.php?islem=is_emirlerini_getir_sql", function (getModal) {
                $("#carileri_getir_irsaliye").html(getModal);
            })
        });

        $("body").off("click", "#mal_cinsi_ekle_button").on("click", "#mal_cinsi_ekle_button", function () {
            $.get("depo/modals/siparis_modal/depo_siparis_olustur.php?islem=yeni_mal_cinsi_ekle_modal", function (getModal) {
                $(".yeni_mal_cinsi_ekle").html(getModal);
            })
        });

        $("body").off("click", "#mal_cinslerini_getir_button").on("click", "#mal_cinslerini_getir_button", function () {
            $.get("depo/modals/siparis_modal/depo_siparis_olustur.php?islem=mal_cinslerini_getir_modal", function (getModal) {
                $(".mal_cinsleri_div").html(getModal);
            })
        });

        $(document).ready(function () {
            $("#arac_giris_guncelle_main_modal").modal("show");

            $.get("depo/controller/depo_controller/sql.php?islem=birimleri_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#birim_id").append("<option value='" + item.id + "'>" + item.birim_adi + "</option>");
                    })
                }
            });

            $.get("depo/controller/konteyner_controller/sql.php?islem=giris_yapan_aracin_bilgilerini_getir_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    let giris_tarihi = item.giris_tarihi;
                    if (giris_tarihi != "") {
                        giris_tarihi = giris_tarihi.split(" ");
                        giris_tarihi = giris_tarihi[0];
                    }
                    $("#cari_id").attr("data-id", item.cari_id);
                    $("#cari_id").val(item.cari_adi);
                    $("#plaka_no").attr("data-id", item.plaka_id);
                    $("#plaka_no").val(item.plaka_no);
                    $("#surucu_adi").val(item.surucu_adi);
                    $("#surucu_tel").val(item.surucu_tel);
                    $("#giris_tarihi").val(giris_tarihi);
                    $("#epro_ref").attr("data-id", item.is_emir_id);
                    $("#epro_ref").val(item.epro_ref);
                    $("#mal_kodu").attr("data-id", item.mal_id);
                    $("#mal_kodu").val(item.mal_cinsi);
                    let miktar = item.miktar;
                    miktar = parseFloat(miktar);
                    if (isNaN(miktar)) {
                        miktar = 0;
                    }
                    $("#miktar").val(miktar.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }));
                    $("#birim_id").val(item.birim_id);
                    $("#referans_no").val(item.referans_no);
                    $("#fabrika_ref").val(item.fabrika_ref);
                    $("#beyanname_no").val(item.beyanname_no);
                    $("#aciklama").val(item.aciklama);
                }
            })
        });

        $("body").off("keyup", "#plaka_no").on("keyup", "#plaka_no", function () {
            let val = $(this).val();
            $.get("depo/controller/tanim_controller/sql.php?islem=secilen_tanimli_araclari_getir_sql", {plaka_no: val}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#plaka_no").val(item.plaka_no);
                    $("#plaka_no").attr("data-id", item.id);
                    $("#surucu_adi").val(item.surucu_adi);
                    $("#surucu_tel").val(item.surucu_tel);
                    $("#cari_id").val(item.cari_adi);
                    $("#cari_id").attr("data-id", item.cari_id);
                    $("#referans_no").val(item.acente_ref);
                    $("#beyanname_no").val(item.beyanname_no);
                    $("#epro_ref").val(item.epro_ref);
                    $("#epro_ref").attr("data-id", item.is_emir_id);
                    $("#acenta").val(item.acente);
                    $("#alim_yeri").val(item.alim_yeri);
                    $("#fabrika_ref").val(item.fabrika_ref);
                    $("#mal_kodu").attr("data-id", item.mal_id);
                    $("#mal_kodu").val(item.urun_adi);
                    $("#birim_id").val(item.birim_id);
                } else {
                    $("#plaka_no").attr("data-id", "");
                    $("#surucu_adi").val("");
                    $("#surucu_tel").val("");
                    $("#cari_id").val("");
                    $("#cari_id").attr("data-id", "");
                    $("#referans_no").val("");
                    $("#beyanname_no").val("");
                    $("#epro_ref").val("");
                    $("#epro_ref").attr("data-id", "");
                    $("#acenta").val("");
                    $("#alim_yeri").val("");
                    $("#fabrika_ref").val("");
                    $("#mal_kodu").attr("data-id", "");
                    $("#mal_kodu").val("");
                    $("#birim_id").val("");
                }
            })
        });

        $("body").off("focusout", "#miktar").on("focusout", "#miktar", function () {
            let miktar = $(this).val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            if (isNaN(miktar)) {
                miktar = 0;
            }
            $(this).val(miktar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });


        $("body").off("click", "#irsaliye_plakalari_getir_button").on("click", "#irsaliye_plakalari_getir_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=irsaliye_plakalari_getir", function (getModal) {
                $(".konteyner_irasliye_plakalari_getir_div").html("");
                $(".konteyner_irasliye_plakalari_getir_div").html(getModal);
            });
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

        $("body").off("focusout", "#surucu_prim").on("focusout", "#surucu_prim", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });

        $("body").off("click", "#depo_arac_giris_guncelle_button").on("click", "#depo_arac_giris_guncelle_button", function () {
            let giris_tarihi = $("#giris_tarihi").val();
            let plaka_no = $("#plaka_no").val();
            let plaka_id = $("#plaka_no").attr("data-id");
            let surucu_adi = $("#surucu_adi").val();
            let surucu_tel = $("#surucu_tel").val();
            let cari_id = $("#cari_id").attr("data-id");
            let birim_id = $("#birim_id").val();
            let is_emir_id = $("#epro_ref").attr("data-id");
            let epro_ref = $("#epro_ref").val();
            let referans_no = $("#referans_no").val();
            let fabrika_ref = $("#fabrika_ref").val();
            let beyanname_no = $("#beyanname_no").val();
            let aciklama = $("#aciklama").val();
            if (plaka_no == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Giriş Yapan Plakayı Giriniz...",
                    "warning"
                );
            } else if (giris_tarihi == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Giriş Tarihi Belirtiniz...",
                    "warning"
                );
            } else if (cari_id == undefined || cari_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Cari Seçiniz...",
                    "warning"
                );
            } else if (is_emir_id == undefined || is_emir_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir İş Emri Seçiniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "depo/controller/konteyner_controller/sql.php?islem=arac_giris_guncelle_sql",
                    type: "POST",
                    data: {
                        giris_tarihi: giris_tarihi,
                        plaka_no: plaka_no,
                        plaka_id: plaka_id,
                        surucu_adi: surucu_adi,
                        surucu_tel: surucu_tel,
                        cari_id: cari_id,
                        is_emri_id: is_emir_id,
                        mal_id: mal_id,
                        epro_ref: epro_ref,
                        mal_cinsi: urun_adi,
                        miktar: miktar,
                        birim_id: birim_id,
                        referans_no: referans_no,
                        fabrika_ref: fabrika_ref,
                        beyanname_no: beyanname_no,
                        aciklama: aciklama,
                        id: "<?=$_GET["id"]?>"
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Araç Giriş Kaydedildi",
                                "success"
                            );
                            $("#arac_giris_guncelle_main_modal").modal("hide");
                            $.get("depo/view/arac_giris_main.php", function (getList) {
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/arac_giris_main.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }
        });

        $("body").off("keyup", "#konteyner_no").on("keyup", "#konteyner_no", function () {
            let val = $(this).val();
            $.get("depo/controller/konteyner_controller/sql.php?islem=tanimli_konteynerleri_getir_sql", {konteyner_no: val}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#konteyner_no").attr("data-id", item.id);
                    $("#referans_no").val(item.acente_ref);
                    $("#beyanname_no").val(item.beyanname_no);
                    $("#konteyner_tipi").val(item.konteyner_tipi);
                    $("#cari_id").val(item.cari_adi)
                    $("#cari_id").attr("data-id", item.cari_id)
                    let cut_of = item.cutt_off_tarihi;
                    if (cut_of != null) {
                        cut_of = cut_of.split(" ");
                        cut_of = cut_of[0];
                    }
                    let ardiyesiz_giris_tarihi = item.ardiyesiz_giris_tarihi;
                    if (ardiyesiz_giris_tarihi != null) {
                        ardiyesiz_giris_tarihi = ardiyesiz_giris_tarihi.split(" ");
                        ardiyesiz_giris_tarihi = ardiyesiz_giris_tarihi[0];
                    }
                    let demoraj_tarihi = item.demoraj_tarihi;
                    if (demoraj_tarihi != null) {
                        demoraj_tarihi = demoraj_tarihi.split(" ");
                        demoraj_tarihi = demoraj_tarihi[0];
                    }
                    $("#cut_off_tarihi").val(cut_of);
                    $("#ardiyesiz_giris_tarihi").val(ardiyesiz_giris_tarihi);
                    $("#demoraj_tarihi").val(demoraj_tarihi);
                    $("#tipi").val(item.tipi);
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
                }
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
                        $("#arac_cari_adi").val((item.cari_adi).toUpperCase())
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

        $("body").off("click", "#irsaliye_icin_suruculeri_getir_button").on("click", "#irsaliye_icin_suruculeri_getir_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=irsaliye_icin_suruculeri_getir", function (getModal) {
                $(".konteyner_irasliye_suruculeri_getir_div").html("");
                $(".konteyner_irasliye_suruculeri_getir_div").html(getModal);
            });
        });

        $("body").off("click", "#tanimli_konteynerleri_getir_button").on("click", "#tanimli_konteynerleri_getir_button", function () {
            $.get("depo/modals/konteyner_modal/konteyner_giris.php?islem=tanimli_konteynerleri_getir_modal", function (getModal) {
                $(".tanimli_konteynerleri_getir_div").html("");
                $(".tanimli_konteynerleri_getir_div").html(getModal);
            });
        });

        $("body").off("click", "#tanimli_tektek_arabalari_getir_button").on("click", "#tanimli_tektek_arabalari_getir_button", function () {
            $.get("depo/modals/konteyner_modal/arac_giris_yap_main_modal.php?islem=tanimli_araclari_getir_modal", function (getModal) {
                $(".tanimli_konteynerleri_getir_div").html("");
                $(".tanimli_konteynerleri_getir_div").html(getModal);
            });
        });

        $("body").off("click", "#arac_giris_guncelle_main_modal_kapat").on("click", "#arac_giris_guncelle_main_modal_kapat", function () {
            $("#arac_giris_guncelle_main_modal").modal("hide");
        });

    </script>
    <?php
}