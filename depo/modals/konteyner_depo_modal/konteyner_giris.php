<?php

$islem = $_GET["islem"];

if ($islem == "depoya_konteyner_al_modal") {
    ?>
    <style>
        #konteyner_depo_tanim {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="konteyner_depo_tanim" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 40%; max-width: 40%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="konteyner_depo_tanim_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>DEPO KONTEYNER TANIM
                            </div>
                        </div>
                        <div class="modal-body">

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
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Tipi</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="custom-select custom-select-sm" id="tipi">
                                        <option value="">Tipi</option>
                                        <option value="İTHALAT">İTHALAT</option>
                                        <option value="LİMAN">LİMAN</option>
                                    </select>
                                </div>
                            </div>
                            <div class="konteyner_tanim_cari_div"></div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Acenta Kodu</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="firma_kodu">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm" id="firma_kodu_button"><i
                                                        class="fa fa-ellipsis-h"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Acenta Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="firma_adi"
                                           style="font-weight: bold" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Konteyner No</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="konteyner_no">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Bildirim Tarihi</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="date" class="form-control form-control-sm" value="<?= date("Y-m-d") ?>"
                                           id="bildirim_tarihi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>SHİPPER</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="shipper">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="konteyner_depo_tanim_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="depo_konteyner_tanimla"><i
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
            $("#konteyner_depo_tanim").modal("show");
        });


        $("body").off("click", "#konteyner_depo_tanim_kapat").on("click", "#konteyner_depo_tanim_kapat", function () {
            $("#konteyner_depo_tanim").modal("hide");
        });

        $("body").off("click", "#firma_kodu_button").on("click", "#firma_kodu_button", function () {
            $.get("depo/modals/nakliye_depolama_modal/nakliye_depolama.php?islem=nakliye_giris_carileri_getir", function (getModal) {
                $(".konteyner_tanim_cari_div").html(getModal);
            })
        });

        $("body").off("click", "#depo_konteyner_tanimla").on("click", "#depo_konteyner_tanimla", function () {
            let konteyner_tipi = $("#konteyner_tipi").val();
            let tipi = $("#tipi").val();
            let acenta_kodu = $("#firma_kodu").val();
            let acenta_id = $("#firma_kodu").attr("data-id");
            let acenta_adi = $("#firma_adi").val();
            let konteyner_no = $("#konteyner_no").val();
            let bildirim_tarihi = $("#bildirim_tarihi").val();
            let shipper = $("#shipper").val();

            if (konteyner_no == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Konteyner Numarasını Giriniz...",
                    "warning"
                )
            } else if (acenta_id == undefined || acenta_id == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir Acenta Belirtiniz...",
                    "warning"
                )
            } else {
                $.ajax({
                    url: "depo/controller/kont_kabul_controller/sql.php?islem=depo_konteyner_tanim_sql",
                    type: "POST",
                    data: {
                        konteyner_tipi: konteyner_tipi,
                        tipi: tipi,
                        acenta_kodu: acenta_kodu,
                        acenta_id: acenta_id,
                        acenta_adi: acenta_adi,
                        konteyner_no: konteyner_no,
                        bildirim_tarihi: bildirim_tarihi,
                        shipper: shipper
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Konteyner Tanıtıldı",
                                "success"
                            );
                            $("#konteyner_depo_tanim").modal("hide");
                            $.get("depo/view/konteyner_manuel_tanim.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/konteyner_manuel_tanim.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                        } else if (res == 300) {
                            Swal.fire(
                                "Uyarı",
                                "Bu Konteyner Zaten Tanımlı",
                                "warning"
                            );
                        } else {
                            Swal.fire(
                                "Oops...",
                                "Bilinmeyen Bir Hata Oluştu",
                                "error"
                            );
                        }
                    }
                });
            }
        });

    </script>
    <?php
}
if ($islem == "konteyner_tanim_guncelle_modal") {
    ?>
    <style>
        #konteyner_tanim_guncelle_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="konteyner_tanim_guncelle_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 40%; max-width: 40%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="konteyner_tanim_guncelle_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>DEPO KONTEYNER TANIM
                            </div>
                        </div>
                        <div class="modal-body">

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
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Tipi</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="custom-select custom-select-sm" id="tipi">
                                        <option value="">Tipi</option>
                                        <option value="İTHALAT">İTHALAT</option>
                                        <option value="LİMAN">LİMAN</option>
                                    </select>
                                </div>
                            </div>
                            <div class="konteyner_tanim_cari_div"></div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Acenta Kodu</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="firma_kodu">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm" id="firma_kodu_button"><i
                                                        class="fa fa-ellipsis-h"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Acenta Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="firma_adi"
                                           style="font-weight: bold" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Konteyner No</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="konteyner_no">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Bildirim Tarihi</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="date" class="form-control form-control-sm" value="<?= date("Y-m-d") ?>"
                                           id="bildirim_tarihi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>SHİPPER</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="shipper">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="konteyner_tanim_guncelle_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="depo_konteyner_tanimla"><i
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
            $("#konteyner_tanim_guncelle_modal").modal("show");
            $.get("depo/controller/kont_kabul_controller/sql.php?islem=konteyner_bilgilerini_getir_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#bildirim_tarihi").val(item.bildirim_tarihi);
                    $("#konteyner_no").val(item.konteyner_no);
                    $("#konteyner_tipi").val(item.konteyner_tipi);
                    $("#tipi").val(item.tipi);
                    $("#firma_kodu").val(item.acenta_kodu);
                    $("#firma_kodu").attr("data-id", item.acenta_id);
                    $("#firma_adi").val(item.acenta_adi);
                    $("#shipper").val(item.shipper);
                }
            })
        });

        $("body").off("click", "#konteyner_tanim_guncelle_modal_kapat").on("click", "#konteyner_tanim_guncelle_modal_kapat", function () {
            $("#konteyner_tanim_guncelle_modal").modal("hide");
        });

        $("body").off("click", "#firma_kodu_button").on("click", "#firma_kodu_button", function () {
            $.get("depo/modals/nakliye_depolama_modal/nakliye_depolama.php?islem=nakliye_giris_carileri_getir", function (getModal) {
                $(".konteyner_tanim_cari_div").html(getModal);
            })
        });

        $("body").off("click", "#depo_konteyner_tanimla").on("click", "#depo_konteyner_tanimla", function () {
            let konteyner_tipi = $("#konteyner_tipi").val();
            let tipi = $("#tipi").val();
            let acenta_kodu = $("#firma_kodu").val();
            let acenta_id = $("#firma_kodu").attr("data-id");
            let acenta_adi = $("#firma_adi").val();
            let konteyner_no = $("#konteyner_no").val();
            let bildirim_tarihi = $("#bildirim_tarihi").val();
            let shipper = $("#shipper").val();

            if (konteyner_no == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Konteyner Numarasını Giriniz...",
                    "warning"
                )
            } else if (acenta_id == undefined || acenta_id == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir Acenta Belirtiniz...",
                    "warning"
                )
            } else {
                $.ajax({
                    url: "depo/controller/kont_kabul_controller/sql.php?islem=depo_konteyner_guncelle_sql",
                    type: "POST",
                    data: {
                        konteyner_tipi: konteyner_tipi,
                        tipi: tipi,
                        acenta_kodu: acenta_kodu,
                        acenta_id: acenta_id,
                        acenta_adi: acenta_adi,
                        konteyner_no: konteyner_no,
                        bildirim_tarihi: bildirim_tarihi,
                        shipper: shipper,
                        id: "<?=$_GET["id"]?>"
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Konteyner Tanıtıldı",
                                "success"
                            );
                            $("#konteyner_tanim_guncelle_modal").modal("hide");
                            $.get("depo/view/konteyner_manuel_tanim.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/konteyner_manuel_tanim.php", function (getList) {
                                $(".modal-icerik").html("");
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
if ($islem == "konteyner_toplu_tanim_button") {
    ?>
    <style>
        #konteyner_toplu_tanim_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="konteyner_toplu_tanim_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 50%; max-width: 50%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="konteyner_toplu_tanim_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>DEPO KONTEYNER TOPLU TANIM
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Tipi</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="custom-select custom-select-sm" id="tipi">
                                        <option value="">Tipi</option>
                                        <option value="İTHALAT">İTHALAT</option>
                                        <option value="LİMAN">LİMAN</option>
                                    </select>
                                </div>
                            </div>
                            <div class="konteyner_tanim_cari_div"></div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Acenta Kodu</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="firma_kodu">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm" id="firma_kodu_button"><i
                                                        class="fa fa-ellipsis-h"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Acenta Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="firma_adi"
                                           style="font-weight: bold" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Bildirim Tarihi</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="date" class="form-control form-control-sm" value="<?= date("Y-m-d") ?>"
                                           id="bildirim_tarihi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>SHİPPER</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="shipper">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <input type="file" id="dosyaSec" accept=".xlsx, .csv">
                                </div>
                                <div class="col-md-7">
                                    <span style="font-weight: bold;color: red">
                                        KONTEYNER NUMARALARINIZ EXCEL'DE konteyner_no OLARAK BAŞLIKLANDIRINIZ<br>
                                        KONTEYNER TİPLERİNİZİ ARALARINDA BOŞLUK OLARAK VE BÜYÜK HARFLERLE YAZINIZ! ÖRNEK:(40 HC)<br>
                                        HER KONTEYNERİN TİPİ OLMASI GEREKİR AKSİ TAKDİRDE HATA ALIRSINIZ
                                    </span>
                                </div>
                            </div>
                            <div class="col-12 row">
                                <div class="col-12 row mt-2">
                                    <table class="table table-sm table-bordered w-100  nowrap"
                                           id="konteyner_toplu_table"
                                           style="font-size: 13px;">
                                        <thead>
                                        <tr>
                                            <th id="ant_1">Konteyner No</th>
                                            <th>Tipi</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="konteyner_toplu_tanim_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="depo_konteyner_tanimla"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        var toplu_table = "";
        $(document).ready(function () {
            setTimeout(function () {
                $("#ant_1").trigger("click");
            }, 500);

            $("#konteyner_toplu_tanim_modal").modal("show");
            toplu_table = $('#konteyner_toplu_table').DataTable({
                scrollY: '35vh',
                scrollX: true,
                columns: [
                    {'data': 'konteyner_no'},
                    {'data': 'tipi'}
                ],
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row, data, dataIndex) {
                    $(row).addClass("bilanco_selected");
                    $(row).find("td").css("text-align", "left");

                }
            });
        });

        document.getElementById('dosyaSec').addEventListener('change', function () {
            dosyaOku();
        });

        function dosyaOku() {
            var fileInput = document.getElementById('dosyaSec');
            var file = fileInput.files[0];

            if (!file) {
                Swal.fire(
                    "Uyarı",
                    "Herhangi Bir Dosya Seçilmedi"
                )
                return;
            }

            var dosyaUzanti = file.name.split('.').pop().toLowerCase();
            if (dosyaUzanti !== 'xlsx' && dosyaUzanti !== 'csv') {
                Swal.fire(
                    "Uyarı",
                    "Seçtiğiniz Dosya Excel Uzantılı Değildir...",
                    "warning"
                )
                return;
            }

            var reader = new FileReader();
            reader.onload = function (e) {
                var data = new Uint8Array(e.target.result);
                var workbook = XLSX.read(data, {type: 'array'});

                // İlk çalışma sayfasını al
                var sheetName = workbook.SheetNames[0];
                var worksheet = workbook.Sheets[sheetName];

                // Verileri alma
                var veri = XLSX.utils.sheet_to_json(worksheet, {header: 1});

                // "konteyner_no" sütunundaki verileri al
                var scriptTagFound = false;
                for (let n = 0; n < veri.length; n++) {
                    for (let j = 0; j < veri[n].length; j++) {
                        if (typeof veri[n][j] === 'string' && veri[n][j].includes('<script>')) {
                            scriptTagFound = true;
                            break;
                        }
                    }
                    if (scriptTagFound) {
                        break;
                    }
                }

                if (scriptTagFound) {
                    Swal.fire(
                        "Uyarı",
                        "Excel dosyası içerisinde script bulundu!",
                        "warning"
                    );
                    $.ajax({
                        url: "controller/sql.php?islem=logout",
                        type: "POST",
                        data: {},
                        success: function () {
                            setTimeout(function () {
                                location.reload();
                            }, 800);
                        }
                    });
                } else {
                    let konteynerNoIndex = veri[0].indexOf('konteyner_no');
                    let konteynerNoIndex1 = veri[0].indexOf('tipi');
                    let konteynerNoData = [];
                    for (let i = 1; i < veri.length; i++) {
                        let newRow = {
                            'konteyner_no': veri[i][konteynerNoIndex],
                            'tipi': veri[i][konteynerNoIndex1]
                        };
                        konteynerNoData.push(newRow);
                    }
                    toplu_table.rows.add(konteynerNoData).draw(false);
                }
            };

            reader.readAsArrayBuffer(file);
        }


        $("body").off("click", "#konteyner_toplu_tanim_modal_kapat").on("click", "#konteyner_toplu_tanim_modal_kapat", function () {
            $("#konteyner_toplu_tanim_modal").modal("hide");
        });

        $("body").off("click", "#firma_kodu_button").on("click", "#firma_kodu_button", function () {
            $.get("depo/modals/nakliye_depolama_modal/nakliye_depolama.php?islem=nakliye_giris_carileri_getir", function (getModal) {
                $(".konteyner_tanim_cari_div").html(getModal);
            })
        });

        $("body").off("click", "#depo_konteyner_tanimla").on("click", "#depo_konteyner_tanimla", function () {
            let konteyner_tipi = $("#konteyner_tipi").val();
            let tipi = $("#tipi").val();
            let acenta_kodu = $("#firma_kodu").val();
            let acenta_id = $("#firma_kodu").attr("data-id");
            let acenta_adi = $("#firma_adi").val();
            let konteyner_no = $("#konteyner_no").val();
            let bildirim_tarihi = $("#bildirim_tarihi").val();
            let shipper = $("#shipper").val();

            if (konteyner_no == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Konteyner Numarasını Giriniz...",
                    "warning"
                )
            } else if (acenta_id == undefined || acenta_id == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir Acenta Belirtiniz...",
                    "warning"
                )
            } else {
                $.ajax({
                    url: "depo/controller/kont_kabul_controller/sql.php?islem=depo_konteyner_tanim_sql",
                    type: "POST",
                    data: {
                        konteyner_tipi: konteyner_tipi,
                        tipi: tipi,
                        acenta_kodu: acenta_kodu,
                        acenta_id: acenta_id,
                        acenta_adi: acenta_adi,
                        konteyner_no: konteyner_no,
                        bildirim_tarihi: bildirim_tarihi,
                        shipper: shipper
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Konteyner Tanıtıldı",
                                "success"
                            );
                            $("#konteyner_toplu_tanim_modal").modal("hide");
                            $.get("depo/view/konteyner_manuel_tanim.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/konteyner_manuel_tanim.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                        } else if (res == 300) {
                            Swal.fire(
                                "Uyarı",
                                "Bu Konteyner Zaten Tanımlı",
                                "warning"
                            );
                        } else {
                            Swal.fire(
                                "Oops...",
                                "Bilinmeyen Bir Hata Oluştu",
                                "error"
                            );
                        }
                    }
                });
            }
        });

    </script>
    <?php
}