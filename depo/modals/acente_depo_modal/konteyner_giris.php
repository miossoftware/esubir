<?php

$islem = $_GET["islem"];

if ($islem == "konteyner_girisi_yap_modal") {
    ?>
    <style>
        #acente_konteyner_girisi_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="acente_konteyner_girisi_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="acente_konteyner_girisi_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>KONTEYNER GİRİŞ</div>
                        </div>
                        <div class="modal-body">
                            <div class="tanimli_konteynerler"></div>
                            <div class="col-12 row">
                                <div class="col-6">
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
                                            <label>Konteyner No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="konteyner_no">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="konteyner_no_button"><i
                                                                class="fa fa-ellipsis-h"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Konteyner Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="konteyner_tipi"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Kondisyon</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="kondisyon">
                                                <option value="">Konteyner Kondisyon</option>
                                                <option value="HASARLI">HASARLI</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" disabled id="tipi">
                                                <option value="">Tipi...</option>
                                                <option value="İTHALAT">İTHALAT</option>
                                                <option value="LİMAN">LİMAN</option>
                                            </select>
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
                                            <label>Referans No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="referans_no"
                                                   disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Blok Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="adres_id">
                                                <option value="">Blok Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Nakliye Firması</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="nakliye_firmasi">
                                        </div>
                                    </div>
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
                            <button class="btn btn-danger btn-sm" id="acente_konteyner_girisi_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="acente_konteyner_giris_kaydet"><i
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
            $("#acente_konteyner_girisi_modal").modal("show");
            $.get("depo/controller/acente_controller/sql.php?islem=tanimlanan_bloklari_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#adres_id").append("" +
                            "<option value='" + item.id + "'>" + item.adres_adi + "</option>" +
                            "");
                    })
                }
            });

            $.get("depo/controller/acente_controller/sql.php?islem=kondisyon_tanimlari_getir_sql2", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#kondisyon").append("" +
                            "<option value='" + item.kondisyon_adi + "'>" + item.kondisyon_adi + "</option>" +
                            "");
                    })
                }
            })
        });

        $("body").off("click", "#acente_konteyner_giris_kaydet").on("click", "#acente_konteyner_giris_kaydet", function () {
            let tarih = $("#tarih").val();
            let konteyner_id = $("#konteyner_no").attr("data-id");
            let konteyner_no = $("#konteyner_no").val();
            let konteyner_tipi = $("#konteyner_tipi").val();
            let tipi = $("#tipi").val();
            let acente_adi = $("#acente_adi").val();
            let referans_no = $("#referans_no").val();
            let blok_id = $("#adres_id").val();
            let nakliye_firmasi = $("#nakliye_firmasi").val();
            let plaka_no = $("#plaka_no").val();
            let surucu_adi = $("#surucu_adi").val();
            let surucu_tel = $("#surucu_tel").val();
            let aciklama = $("#aciklama").val();
            let kondisyon = $("#kondisyon").val();

            if (konteyner_id == undefined || konteyner_tipi == "") {
                Swal.fire(
                    "Uyarı!",
                    'Lütfen Bir Konteyner Seçiniz...',
                    "warning"
                );
            } else {
                $.ajax({
                    url: "depo/controller/acente_controller/sql.php?islem=konteyner_giris_kaydet_sql",
                    type: "POST",
                    data: {
                        tarih: tarih,
                        konteyner_no: konteyner_no,
                        konteyner_id: konteyner_id,
                        konteyner_tipi: konteyner_tipi,
                        tipi: tipi,
                        acente_adi: acente_adi,
                        referans_no: referans_no,
                        blok_id: blok_id,
                        nakliye_firmasi: nakliye_firmasi,
                        kondisyon: kondisyon,
                        plaka_no: plaka_no,
                        surucu_adi: surucu_adi,
                        surucu_tel: surucu_tel,
                        aciklama: aciklama
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Konteyner Girişi Başarılı",
                                "success"
                            );
                            $.get("depo/view/acente_konteyner_giris.php", function (getList) {
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/acente_konteyner_giris.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            });
                            $("#acente_konteyner_girisi_modal").modal("hide");
                        }
                    }
                });
            }
        });

        $("body").off("click", "#konteyner_no_button").on("click", "#konteyner_no_button", function () {
            $.get("depo/modals/acente_depo_modal/konteyner_giris.php?islem=tanimli_konteynerler_modal", function (getModal) {
                $(".tanimli_konteynerler").html(getModal);
            })
        });

        $("body").off("keyup", "#konteyner_no").on("keyup", "#konteyner_no", function () {
            let konteyner_no = $(this).val();
            $.get("depo/controller/acente_controller/sql.php?islem=tanimli_konteyner_getir_sql", {konteyner_no: konteyner_no}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#konteyner_no").attr("data-id", item.id);
                    $("#konteyner_no").val(item.konteyner_no);
                    $("#tipi").val(item.tipi);
                    $("#konteyner_tipi").val(item.konteyner_tipi);
                    $("#acente_adi").val(item.acente_adi);
                    $("#referans_no").val(item.referans_no);
                } else {
                    $("#konteyner_no").attr("data-id", "");
                    $("#tipi").val("");
                    $("#konteyner_tipi").val("");
                    $("#acente_adi").val("");
                    $("#referans_no").val("");
                }
            });
        });

        $("body").off("click", "#acente_konteyner_girisi_modal_kapat").on("click", "#acente_konteyner_girisi_modal_kapat", function () {
            $("#acente_konteyner_girisi_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "tanimli_konteynerler_modal") {
    ?>
    <div class="modal fade" id="tanimli_konteynerler_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="acente_tanimli_konteyner_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>TANIMLI KONTEYNERLER</div>
                        </div>
                        <div class="modal-body">
                            <table class="table table-sm table-bordered w-100 display nowrap"
                                   style="cursor:pointer;font-size: 13px;"
                                   id="is_emri_select_liste">
                                <thead>
                                <tr>
                                    <th id="click1">Bildirim Tarihi</th>
                                    <th>Konteyner No</th>
                                    <th>Acente Adı</th>
                                    <th>Referans No</th>
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
            $("#tanimli_konteynerler_modal").modal("show");
            var table = $('#is_emri_select_liste').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "bildirim_tarihi"},
                    {'data': "konteyner_no"},
                    {'data': "cari_adi"},
                    {'data': "referans_no"},
                    {'data': "aciklama"}
                ],
                createdRow: function (row) {
                    $(row).addClass("tanimli_konteyner_selected");
                    $(row).find('td').css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                    $(row).addClass("tanimli_kont_selected");
                }
            });

            $.get("depo/controller/acente_controller/sql.php?islem=tanimli_tum_konteynerler_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                }
            })

            $("body").off("click", ".tanimli_kont_selected").on("click", ".tanimli_kont_selected", function () {
                let id = $(this).attr("data-id");
                $.get("depo/controller/acente_controller/sql.php?islem=tanimli_konteyner_getir_sql", {id: id}, function (res) {
                    if (res != 2) {
                        var item = JSON.parse(res);
                        $("#konteyner_no").attr("data-id", item.id);
                        $("#konteyner_no").val(item.konteyner_no);
                        $("#tipi").val(item.tipi);
                        $("#konteyner_tipi").val(item.konteyner_tipi);
                        $("#acente_adi").val(item.acente_adi);
                        $("#referans_no").val(item.referans_no);
                        $("#tanimli_konteynerler_modal").modal("hide");
                    }
                });
            });

        });

        $("body").off("click", "#acente_tanimli_konteyner_kapat").on("click", "#acente_tanimli_konteyner_kapat", function () {
            $("#tanimli_konteynerler_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "konteyner_giris_guncelle_modal") {
    ?>
    <style>
        #acente_konteyner_giris_guncelle_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="acente_konteyner_giris_guncelle_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="acente_konteyner_giris_guncelle_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>KONTEYNER GİRİŞ</div>
                        </div>
                        <div class="modal-body">
                            <div class="tanimli_konteynerler"></div>
                            <div class="col-12 row">
                                <div class="col-6">
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
                                            <label>Konteyner No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="konteyner_no">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="konteyner_no_button"><i
                                                                class="fa fa-ellipsis-h"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Konteyner Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="konteyner_tipi"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" disabled id="tipi">
                                                <option value="">Tipi...</option>
                                                <option value="İTHALAT">İTHALAT</option>
                                                <option value="LİMAN">LİMAN</option>
                                            </select>
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
                                            <label>Referans No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="referans_no"
                                                   disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Blok Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="adres_id">
                                                <option value="">Blok Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Nakliye Firması</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="nakliye_firmasi">
                                        </div>
                                    </div>
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
                            <button class="btn btn-danger btn-sm" id="acente_konteyner_giris_guncelle_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="acente_konteyner_giris_kaydet"><i
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
            $("#acente_konteyner_giris_guncelle_modal").modal("show");
            $.get("depo/controller/acente_controller/sql.php?islem=tanimlanan_bloklari_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#adres_id").append("" +
                            "<option value='" + item.id + "'>" + item.adres_adi + "</option>" +
                            "");
                    })
                }
            });

            $.get("depo/controller/acente_controller/sql.php?islem=konteyner_giris_bilgileri_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#tarih").val(item.giris_tarihi);
                    $("#konteyner_no").attr("data-id", item.konteyner_id);
                    $("#konteyner_no").val(item.konteyner_no);
                    $("#konteyner_tipi").val(item.konteyner_tipi);
                    $("#tipi").val(item.tipi);
                    $("#acente_adi").val(item.acente_adi);
                    $("#referans_no").val(item.referans_no);
                    $("#adres_id").val(item.blok_id);
                    $("#nakliye_firmasi").val(item.nakliye_firmasi);
                    $("#plaka_no").val(item.plaka_no);
                    $("#surucu_adi").val(item.surucu_adi);
                    $("#surucu_tel").val(item.surucu_tel);
                    $("#aciklama").val(item.aciklama);
                }
            })

        });

        $("body").off("click", "#acente_konteyner_giris_kaydet").on("click", "#acente_konteyner_giris_kaydet", function () {
            let tarih = $("#tarih").val();
            let konteyner_id = $("#konteyner_no").attr("data-id");
            let konteyner_no = $("#konteyner_no").val();
            let konteyner_tipi = $("#konteyner_tipi").val();
            let tipi = $("#tipi").val();
            let acente_adi = $("#acente_adi").val();
            let referans_no = $("#referans_no").val();
            let blok_id = $("#adres_id").val();
            let nakliye_firmasi = $("#nakliye_firmasi").val();
            let plaka_no = $("#plaka_no").val();
            let surucu_adi = $("#surucu_adi").val();
            let surucu_tel = $("#surucu_tel").val();
            let aciklama = $("#aciklama").val();

            if (konteyner_id == undefined || konteyner_tipi == "") {
                Swal.fire(
                    "Uyarı!",
                    'Lütfen Bir Konteyner Seçiniz...',
                    "warning"
                );
            } else {
                $.ajax({
                    url: "depo/controller/acente_controller/sql.php?islem=konteyner_giris_guncelle_sql",
                    type: "POST",
                    data: {
                        tarih: tarih,
                        konteyner_no: konteyner_no,
                        konteyner_id: konteyner_id,
                        konteyner_tipi: konteyner_tipi,
                        tipi: tipi,
                        acente_adi: acente_adi,
                        referans_no: referans_no,
                        blok_id: blok_id,
                        nakliye_firmasi: nakliye_firmasi,
                        plaka_no: plaka_no,
                        surucu_adi: surucu_adi,
                        surucu_tel: surucu_tel,
                        aciklama: aciklama,
                        id: "<?=$_GET["id"]?>"
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Konteyner Girişi Başarılı",
                                "success"
                            );
                            $.get("depo/view/acente_konteyner_giris.php", function (getList) {
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/acente_konteyner_giris.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            });
                            $("#acente_konteyner_giris_guncelle_modal").modal("hide");
                        }
                    }
                });
            }
        });

        $("body").off("click", "#konteyner_no_button").on("click", "#konteyner_no_button", function () {
            $.get("depo/modals/acente_depo_modal/konteyner_giris.php?islem=tanimli_konteynerler_modal", function (getModal) {
                $(".tanimli_konteynerler").html(getModal);
            })
        });

        $("body").off("keyup", "#konteyner_no").on("keyup", "#konteyner_no", function () {
            let konteyner_no = $(this).val();
            $.get("depo/controller/acente_controller/sql.php?islem=tanimli_konteyner_getir_sql", {konteyner_no: konteyner_no}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#konteyner_no").attr("data-id", item.id);
                    $("#konteyner_no").val(item.konteyner_no);
                    $("#tipi").val(item.tipi);
                    $("#konteyner_tipi").val(item.konteyner_tipi);
                    $("#acente_adi").val(item.acente_adi);
                    $("#referans_no").val(item.referans_no);
                } else {
                    $("#konteyner_no").attr("data-id", "");
                    $("#tipi").val("");
                    $("#konteyner_tipi").val("");
                    $("#acente_adi").val("");
                    $("#referans_no").val("");
                }
            });
        });

        $("body").off("click", "#acente_konteyner_giris_guncelle_modal_kapat").on("click", "#acente_konteyner_giris_guncelle_modal_kapat", function () {
            $("#acente_konteyner_giris_guncelle_modal").modal("hide");
        });

    </script>
    <?php
}