<?php
$islem = $_GET["islem"];

if ($islem == "sahaya_yeni_konteyner_ser_modal") {
    ?>
    <style>
        #sahaya_konteyner_ser_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="sahaya_konteyner_ser_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="sahaya_konteyner_ser_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>SAHAYA KONTEYNER SER</div>
                        </div>
                        <div class="modal-body">
                            <div class="konteynerler_div"></div>
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
                                            <input type="date"
                                                   class="form-control form-control-sm" disabled id="giris_tarihi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Referans No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" disabled
                                                   id="referans_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Beyanname No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" disabled
                                                   id="beyanname_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="tipi" disabled>
                                                <option value="İHRACAT">İHRACAT</option>
                                                <option value="İTHALAT">İTHALAT</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Konteyner Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="konteyner_tipi" disabled>
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
                                </div>
                                <div class="col-6">

                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>CUT - OFF Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date"
                                                   class="form-control form-control-sm" disabled id="cut_off_tarihi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Ardiyesiz Giriş</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date"
                                                   class="form-control form-control-sm" disabled
                                                   id="ardiyesiz_giris_tarihi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Demoraj Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date"
                                                   class="form-control form-control-sm" disabled id="demoraj_tarihi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Durumu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="durumu" disabled>
                                                <option value="Boş">Boş</option>
                                                <option value="Dolu">Dolu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Plaka No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="plaka_no"
                                                   disabled>
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
                            <button class="btn btn-danger btn-sm" id="sahaya_konteyner_ser_modal_kapat"><i
                                    class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="konteyneri_sahaya_ser_kaydet"><i
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
            $("#sahaya_konteyner_ser_modal").modal("show");


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

        $("body").off("click", "#sahaya_konteyner_ser_modal_kapat").on("click", "#sahaya_konteyner_ser_modal_kapat", function () {
            $("#sahaya_konteyner_ser_modal").modal("hide");
        });

        $("body").off("click", "#giris_yapan_konteynerleri_getir_button").on("click", "#giris_yapan_konteynerleri_getir_button", function () {
            $.get("depo/modals/puantor_modal/sahaya_konteyner_ser.php?islem=konteyner_girislerini_getir_modal", function (getModal) {
                $(".konteynerler_div").html(getModal);
            })
        });

        $("body").off("keyup", "#konteyner_no").on("keyup", "#konteyner_no", function () {
            let val = $(this).val();
            $.get("depo/controller/konteyner_controller/sql.php?islem=kont_no_giris_yapan_konteynerin_bilgilerini_getir_sql", {konteyner_no: val}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#konteyner_no").attr("data-id", item.id);
                    $("#konteyner_no").val(item.konteyner_no);
                    $("#giris_tarihi").val(item.giris_tarihi);
                    $("#referans_no").val(item.referans);
                    $("#beyanname_no").val(item.beyanname_no);
                    $("#tipi").val(item.tipi);
                    $("#konteyner_tipi").val(item.konteyner_tipi);
                    let cut_of = item.cut_off_tarihi;
                    if (cut_of != "" || cut_of != null) {
                        cut_of = cut_of.split(" ");
                        cut_of = cut_of[0];
                    }
                    let demoraj_tarihi = item.demoraj_tarihi;
                    if (demoraj_tarihi != "" || demoraj_tarihi != null) {
                        demoraj_tarihi = demoraj_tarihi.split(" ");
                        demoraj_tarihi = demoraj_tarihi[0];
                    }
                    let ardiyesiz_giris_tarihi = item.ardiyesiz_giris_tarihi;
                    if (ardiyesiz_giris_tarihi != "" || ardiyesiz_giris_tarihi != null) {
                        ardiyesiz_giris_tarihi = ardiyesiz_giris_tarihi.split(" ");
                        ardiyesiz_giris_tarihi = ardiyesiz_giris_tarihi[0];
                    }
                    $("#cut_off_tarihi").val(cut_of);
                    $("#ardiyesiz_giris_tarihi").val(ardiyesiz_giris_tarihi);
                    $("#demoraj_tarihi").val(demoraj_tarihi);
                    $("#durumu").val(item.durumu);
                    $("#plaka_no").val(item.plaka_no);
                } else {
                    $("#konteyner_no").attr("data-id", "");
                    $("#giris_tarihi").val("");
                    $("#referans_no").val("");
                    $("#beyanname_no").val("");
                    $("#tipi").val("");
                    $("#konteyner_tipi").val("");
                    $("#cut_off_tarihi").val("");
                    $("#ardiyesiz_giris_tarihi").val("");
                    $("#demoraj_tarihi").val("");
                    $("#durumu").val("");
                    $("#plaka_no").val("");
                }
            })
        });

        $("body").off("click", "#konteyneri_sahaya_ser_kaydet").on("click", "#konteyneri_sahaya_ser_kaydet", function () {
            let giris_id = $("#konteyner_no").attr("data-id");
            let kalmar_id = $("#kalmar_id").val();
            let aciklama = $("#aciklama").val();
            if (giris_id == undefined || giris_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Konteyner Girişi Seçiniz...",
                    "warning"
                );
            }else if (kalmar_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Kalmar Seçiniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "depo/controller/puantor_controller/sql.php?islem=konteyner_sahaya_ser_kaydet_sql",
                    type: "POST",
                    data: {
                        giris_id: giris_id,
                        kalmar_id: kalmar_id,
                        aciklama: aciklama
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Konteyner Sahaya Serildi",
                                "success"
                            );
                            $.get("depo/view/sahaya_urun_ser.php", function (getList) {
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/sahaya_urun_ser.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            });
                            $("#sahaya_konteyner_ser_modal").modal("hide");
                        }
                    }
                });
            }

        });

    </script>
    <?php
}
if ($islem == "konteyner_girislerini_getir_modal") {
    ?>
    <div class="modal fade" id="konteyner_girisleri_getir_main_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 100%; max-width: 100%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="konteyner_girisleri_getir_main_modal_kapat"
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
                                    <th>Plaka No</th>
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
            $("#konteyner_girisleri_getir_main_modal").modal("show");

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
                    {'data': "plaka_no"},
                    {'data': "cari_adi"},
                    {'data': "konteyner_tipi"},
                    {'data': "giris_tarihi"},
                    {'data': "referans"},
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

            $.get("depo/controller/puantor_controller/sql.php?islem=konteyner_girislerini_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                }
            })
        });

        $("body").off("click", ".depo_konteyner_giris_selected").on("click", ".depo_konteyner_giris_selected", function () {
            let id = $(this).attr("data-id");
            $.get("depo/controller/puantor_controller/sql.php?islem=giris_yapan_konteynerin_bilgilerini_getir_sql", {id: id}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#konteyner_no").attr("data-id", item.id);
                    $("#konteyner_no").val(item.konteyner_no);
                    $("#giris_tarihi").val(item.giris_tarihi);
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
            $("#konteyner_girisleri_getir_main_modal").modal("hide");
        });

        $("body").off("click", "#konteyner_girisleri_getir_main_modal_kapat").on("click", "#konteyner_girisleri_getir_main_modal_kapat", function () {
            $("#konteyner_girisleri_getir_main_modal").modal("hide");
        });

    </script>
    <?php
}