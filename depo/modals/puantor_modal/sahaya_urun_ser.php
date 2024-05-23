<?php

$islem = $_GET["islem"];

if ($islem == "sahaya_yeni_urun_ser_modal") {
    ?>
    <style>
        #sahaya_urun_ser_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="sahaya_urun_ser_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="sahaya_urun_ser_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>SAHAYA ÜRÜN SER</div>
                        </div>
                        <div class="modal-body">
                            <div class="arac_girislerini_getir_div"></div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Araç Plaka</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="plaka_id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="arac_girislerini_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                                            id="dolu_giris_konteynerleri_getir_button"><i
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
                                            <input type="text" class="form-control form-control-sm" disabled
                                                   id="cari_adi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Cari Kodu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" disabled
                                                   id="cari_kodu">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Sürücü Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" disabled
                                                   id="surucu_adi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Forklift</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="forklift_id">
                                                <option value="">Forklift Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Miktar</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="miktar"
                                                   value="0,00"
                                                   style="text-align: right">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Birim</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="birim_id">
                                                <option value="">Birim Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Referans</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" disabled
                                                   id="referans">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Epro. Referans</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" disabled
                                                   id="epro_ref">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Beyanname No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" disabled class="form-control form-control-sm"
                                                   id="beyanname_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Kalmar</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="kalmar_id">
                                                <option value="">Kalmar Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="sahaya_urun_ser_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="sahaya_urun_ser_kaydet_button"><i
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
            $("#sahaya_urun_ser_modal").modal("show");


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

            $.get("depo/controller/is_emri_controller/sql.php?islem=birimleri_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#birim_id").append("<option value='" + item.id + "'>" + item.birim_adi + "</option>");
                    })
                }
            });

        });

        $("body").off("keyup", "#plaka_id").on("keyup", "#plaka_id", function () {
            let plaka_no = $("#plaka_id").val();
            $.get("depo/controller/konteyner_controller/sql.php?islem=plaka_no_giris_yapan_aracin_bilgilerini_getir_sql", {plaka_no: plaka_no}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#cari_adi").val(item.cari_adi);
                    $("#cari_kodu").val(item.cari_kodu);
                    $("#surucu_adi").val(item.surucu_adi);
                    $("#plaka_id").attr("data-id", item.id);
                    $("#plaka_id").val(item.plaka_no);
                    $("#surucu_tel").val(item.surucu_tel);
                    $("#mal_cinsi").val(item.mal_cinsi);
                    let miktar = item.miktar;
                    miktar = parseFloat(miktar);
                    $("#miktar").val(miktar.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                    $("#referans").val(item.referans_no);
                    $("#fabrika_ref").val(item.fabrika_ref);
                    $("#epro_ref").val(item.epro_ref);
                } else {
                    $("#cari_adi").val("");
                    $("#cari_kodu").val("");
                    $("#surucu_adi").val("");
                    $("#plaka_id").attr("data-id", "");
                    $("#surucu_tel").val("");
                    $("#mal_cinsi").val("");
                    $("#miktar").val("");
                    $("#referans").val("");
                    $("#fabrika_ref").val("");
                    $("#epro_ref").val("");
                }
            })
            $("#arac_girisleri_modal").modal("hide");
        });

        $("body").off("click", "#sahaya_urun_ser_modal_kapat").on("click", "#sahaya_urun_ser_modal_kapat", function () {
            $("#sahaya_urun_ser_modal").modal("hide");
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

        $("body").off("click", "#sahaya_urun_ser_kaydet_button").on("click", "#sahaya_urun_ser_kaydet_button", function () {
            let giris_id = $("#plaka_id").attr("data-id");
            let miktar = $("#miktar").val();
            let birim_id = $("#birim_id").val();
            let forklift_id = $("#forklift_id").val();
            let kalmar_id = $("#kalmar_id").val();
            let k_girisid = $("#konteyner_no").attr("data-id");
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            let aciklama = $("#aciklama").val();

            if ((giris_id == undefined || giris_id == "") && (k_girisid == "" || k_girisid == undefined)) {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Ürün Girişi Seçiniz...",
                    "warning"
                );
            } else if (forklift_id == "" && !$("#forklift_id").is(":disabled")) {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Forklift Seçiniz...",
                    "warning"
                );
            } else if (kalmar_id == "" && !$("#kalmar_id").is(":disabled")) {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Kalmar Seçiniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "depo/controller/puantor_controller/sql.php?islem=sahaya_urun_serme_islemini_kaydet_sql",
                    type: "POST",
                    data: {
                        giris_id: giris_id,
                        birim_id: birim_id,
                        forklift_id: forklift_id,
                        kalmar_id: kalmar_id,
                        k_girisid: k_girisid,
                        miktar: miktar,
                        aciklama: aciklama
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Sahaya Ürün Serildi...",
                                "success"
                            );
                            $.get("depo/view/sahaya_urun_ser.php", function (getList) {
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/sahaya_urun_ser.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            });
                            $("#sahaya_urun_ser_modal").modal("hide");
                        }
                    }
                });
            }
        });

        $("body").off("click", "#arac_girislerini_getir_button").on("click", "#arac_girislerini_getir_button", function () {
            $.get("depo/modals/puantor_modal/sahaya_urun_ser.php?islem=giris_yapan_araclari_getir_modal", function (getModal) {
                $(".arac_girislerini_getir_div").html(getModal);
            })
        });

        $("body").off("click", "#dolu_giris_konteynerleri_getir_button").on("click", "#dolu_giris_konteynerleri_getir_button", function () {
            $.get("depo/modals/puantor_modal/sahaya_urun_ser.php?islem=dolu_giris_yapan_konteynerleri_getir_modal", function (getModal) {
                $(".arac_girislerini_getir_div").html(getModal);
            })
        });

    </script>
    <?php
}
if ($islem == "giris_yapan_araclari_getir_modal") {
    ?>
    <div class="modal fade" id="arac_girisleri_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 100%; max-width: 100%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="arac_girisleri_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ARAÇ GİRİŞLERİ</div>
                        </div>
                        <div class="modal-body">
                            <table class="table table-sm table-bordered w-100 display nowrap"
                                   style="cursor:pointer;font-size: 13px;"
                                   id="arac_girisleri_list">
                                <thead>
                                <tr>
                                    <th id="click1">Plaka No</th>
                                    <th>Sürücü Adı</th>
                                    <th>Referans</th>
                                    <th>Epro Ref.</th>
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
            $("#arac_girisleri_modal").modal("show");

            setTimeout(function () {
                $("#click1").trigger("click");
            }, 500);

            var table = $('#arac_girisleri_list').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "plaka_no"},
                    {'data': "surucu_adi"},
                    {'data': "referans_no"},
                    {'data': "epro_ref"}
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

            $.get("depo/controller/konteyner_controller/sql.php?islem=arac_girislerini_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                }
            })
        });

        $("body").off("click", ".depo_siparis_selected").on("click", ".depo_siparis_selected", function () {
            let id = $(this).attr("data-id");
            $.get("depo/controller/konteyner_controller/sql.php?islem=giris_yapan_aracin_bilgilerini_getir_sql", {id: id}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#cari_adi").val(item.cari_adi);
                    $("#cari_kodu").val(item.cari_kodu);
                    $("#surucu_adi").val(item.surucu_adi);
                    $("#plaka_id").attr("data-id", item.id);
                    $("#plaka_id").val(item.plaka_no);
                    $("#konteyner_no").attr("data-id", "");
                    $("#surucu_tel").val(item.surucu_tel);
                    $("#referans").val(item.referans_no);
                    $("#epro_ref").val(item.epro_ref);
                }
            })
            $("#arac_girisleri_modal").modal("hide");
        });

        $("body").off("click", "#arac_girisleri_modal_kapat").on("click", "#arac_girisleri_modal_kapat", function () {
            $("#arac_girisleri_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "dolu_giris_yapan_konteynerleri_getir_modal") {
    ?>
    <div class="modal fade" id="dolu_giris_konteynerleri_getir_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 100%; max-width: 100%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="dolu_giris_konteynerleri_getir_modal_kapat"
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
                                   id="konteynerden_serilmis_urunler_list">
                                <thead>
                                <tr>
                                    <th>Giriş Tarihi</th>
                                    <th id="click1">Konteyner No</th>
                                    <th>Cari Adı</th>
                                    <th>Plaka No</th>
                                    <th>Sürücü Adı</th>
                                    <th>Referans No</th>
                                    <th>Beyanname No</th>
                                    <th>Epro Ref.</th>
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
            $("#dolu_giris_konteynerleri_getir_modal").modal("show");

            setTimeout(function () {
                $("#click1").trigger("click");
            }, 500);

            var table = $('#konteynerden_serilmis_urunler_list').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "giris_tarihi"},
                    {'data': "konteyner_no"},
                    {'data': "cari_adi"},
                    {'data': "plaka_no"},
                    {'data': "surucu_adi"},
                    {'data': "referans_no"},
                    {'data': "beyanname_no"},
                    {'data': "epro_ref"}
                ],
                createdRow: function (row, data) {
                    $(row).addClass("dolu_giris_konteyner_selected");
                    $(row).find('td').css('text-align', 'left');
                    $(row).attr("data-id", data.id);
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                    $(row).attr("mal_id", data.mal_id);
                }
            })

            $.get("depo/controller/konteyner_controller/sql.php?islem=dolu_giris_konteynerleri_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                }
            })
        });

        $("body").off("click", ".dolu_giris_konteyner_selected").on("click", ".dolu_giris_konteyner_selected", function () {
            let id = $(this).attr("data-id");
            $.get("depo/controller/konteyner_controller/sql.php?islem=secilen_dolu_giris_konteynerleri_getir_sql", {id: id}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#cari_adi").val(item.cari_adi);
                    $("#cari_kodu").val(item.cari_kodu);
                    $("#surucu_adi").val(item.surucu_adi);
                    $("#konteyner_no").attr("data-id", id);
                    if (item.depo_cari != 0) {
                        $("#forklift_id").prop("disabled", true);
                        $("#forklift_id").val("");
                        $("#kalmar_id").val("");
                        $("#kalmar_id").prop("disabled", true);
                    }else {
                        $("#kalmar_id").prop("disabled", false);
                        $("#forklift_id").prop("disabled", false);
                    }
                    $("#konteyner_no").val(item.konteyner_no);
                    $("#plaka_id").attr("data-id", "");
                    $("#plaka_id").val(item.plaka_no);
                    $("#beyanname_no").val(item.beyanname_no);
                    $("#referans_no").val(item.referans_no);
                    $("#plaka_no").val(item.plaka_no);
                    $("#birim_id").val(item.birim_id);
                    $("#surucu_tel").val(item.surucu_tel);
                    let miktar = item.miktar;
                    miktar = parseFloat(miktar);
                    if (isNaN(miktar)) {
                        miktar = 0;
                    }
                    $("#miktar").val(miktar.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                    $("#1yuklenen_miktar").val(miktar.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                    $("#referans").val(item.referans_no);
                    $("#beyanname_no").val(item.beyanname_no);
                    $("#epro_ref").val(item.epro_ref);
                }
            })
            $("#dolu_giris_konteynerleri_getir_modal").modal("hide");
        });

        $("body").off("click", "#dolu_giris_konteynerleri_getir_modal_kapat").on("click", "#dolu_giris_konteynerleri_getir_modal_kapat", function () {
            $("#dolu_giris_konteynerleri_getir_modal").modal("hide");
        });

    </script>
    <?php
}