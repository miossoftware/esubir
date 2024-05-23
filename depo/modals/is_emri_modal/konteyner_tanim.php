<?php


$islem = $_GET["islem"];


if ($islem == "konteyner_tanimla_modal") {
    ?>
    <style>
        #konteyner_tanim_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="konteyner_tanim_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 45%; max-width: 45%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="konteyner_tanim_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>KONTEYNER TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="kayitli_siparisler_div"></div>
                            <div id="carileri_getir_irsaliye"></div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Cari Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="cari_id">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm" id="cari_getir_modal_irsaliye"><i
                                                        class="fa fa-ellipsis-h"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Epro. Referans</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="siparis_ep_ref">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm" id="tum_siparisleri_getir_button"><i
                                                        class="fa fa-ellipsis-h"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Referans No</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="acenta_ref" disabled>
<!--                                        <div class="input-group-append">-->
<!--                                            <button class="btn btn-warning btn-sm"-->
<!--                                                    id="ihracat_siparisleri_getir_button"><i-->
<!--                                                        class="fa fa-ellipsis-h"></i></button>-->
<!--                                        </div>-->
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Beyanname No</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="beyanname_no" disabled>
<!--                                        <div class="input-group-append">-->
<!--                                            <button class="btn btn-warning btn-sm"-->
<!--                                                    id="ithalat_siparisleri_getir_button"><i-->
<!--                                                        class="fa fa-ellipsis-h"></i></button>-->
<!--                                        </div>-->
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary btn-sm" id="konteynerleri_getir_button"><i
                                            class="fa fa-filter"></i> Hazırla
                                </button>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <input type="file" id="dosyaSec" accept=".xlsx, .csv">
                                    </div>
                                    <div class="col-md-7">
                                    <span style="font-weight: bold;color: red">
                                        LÜTFEN KONTEYNER NUMARLARININ BULUNDUĞU EXCEL'İ SEÇMEDEN ÖNCE LİSTENİZİ HAZIRLAYINIZ<br>
                                        KONTEYNER NUMARALARINIZ EXCEL'DE konteyner_no OLARAK BAŞLIKLANDIRINIZ
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row">
                                <table class="table table-sm table-bordered w-100 display nowrap"
                                       style="cursor:pointer;font-size: 13px;"
                                       id="konteyner_table_list">
                                    <thead>
                                    <tr>
                                        <th id="trigger1">No</th>
                                        <th>Konteyner No</th>
                                        <th>Konteyner Tipi</th>
                                        <th>İşlem</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="konteyner_tanim_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="konteynerleri_tanit_button"><i
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
            $("#konteyner_tanim_modal").modal("show");

            setTimeout(function () {
                $("#trigger1").trigger("click");
            }, 500);

            var konteyner_table = $('#konteyner_table_list').DataTable({
                scrollY: '30vh',
                scrollX: true,
                searching: false,
                order: [0, ["asc"]],
                createdRow: function (row) {
                    $(row).addClass("tanimlanan_konteynerler_list");
                    $(row).find("td").css("text-align", "left");
                    $(row).find("td").eq(5).css("text-align", "right");
                    $(row).find("td").eq(7).css("text-align", "right");
                },
                columns: [
                    {'data': 'no'},
                    {'data': 'konteyner_no'},
                    {'data': 'konteyner_tipi'},
                    {'data': 'islem'}
                ],
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
            });

            $("body").off("click", "#cari_getir_modal_irsaliye").on("click", "#cari_getir_modal_irsaliye", function () {
                $.get("modals/alis_modal/alis_irsaliye_page.php?islem=irsaliye_icin_carileri_getir", function (getModal) {
                    $("#carileri_getir_irsaliye").html("");
                    $("#carileri_getir_irsaliye").html(getModal);
                })
            });

            $("body").off("click", "#konteynerleri_getir_button").on("click", "#konteynerleri_getir_button", function () {
                let siparis_id = $("#siparis_ep_ref").attr("data-id");
                let epro_ref = $("#siparis_ep_ref").val();
                let beyanname_no = $("#beyanname_no").val();
                let referans_no = $("#referans_no").val();

                $.get("depo/controller/konteyner_controller/sql.php?islem=tanitilacak_konteynerler_sql", {
                    siparis_id: siparis_id,
                    epro_ref: epro_ref,
                    beyanname_no: beyanname_no,
                    referans_no: referans_no
                }, function (res) {
                    if (res != 2) {
                        var item = JSON.parse(res);
                        let basilacak = [];
                        let no = 1;
                        konteyner_table.clear().draw(false);
                        for (let i = 0; i < item.konteyner_sayisi; i++) {
                            let arr = {
                                no: no,
                                konteyner_no: "<input type='text' class='form-control form-control-sm col-9'>",
                                konteyner_tipi: item.konteyner_tipi,
                                islem: "<button class='btn btn-danger btn-sm tanitilan_konteyner_sil_sql'><i class='fa fa-trash'></i></button>"
                            };
                            basilacak.push(arr);
                            no += 1;
                        }
                        konteyner_table.rows.add(basilacak).draw(false);
                    }else {
                        konteyner_table.clear().draw(false);
                    }
                })
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
                    for (let i = 1; i < veri.length; i++) {
                        $(".tanimlanan_konteynerler_list").each(function (index) {
                            if (index < veri.length - 1) {
                                $(this).find("td:eq(1) input").val(veri[index + 1][konteynerNoIndex]);
                            }
                        });
                    }
                }
            };

            reader.readAsArrayBuffer(file);
        }


        $("body").off("click", "#konteynerleri_tanit_button").on("click", "#konteynerleri_tanit_button", function () {
            let siparis_id = $("#siparis_ep_ref").attr("data-id");
            let cari_id = $("#cari_id").attr("data-id");
            let gidecek_arr = [];


            $(".tanimlanan_konteynerler_list").each(function () {
                let konteyner_no = $(this).find("td:eq(1) input").val();
                let konteyner_tipi = $(this).find("td").eq(2).text();
                let newRow = {
                    konteyner_tipi: konteyner_tipi,
                    konteyner_no: konteyner_no
                };
                gidecek_arr.push(newRow);
            });

            if (cari_id == undefined || cari_id == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir Cari Belirtiniz...",
                    "warning"
                )
            } else {
                $.ajax({
                    url: "depo/controller/konteyner_controller/sql.php?islem=konteynerleri_tanit_sql",
                    type: "POST",
                    data: {
                        cari_id: cari_id,
                        is_emri_id: siparis_id,
                        gidecek_arr: gidecek_arr
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı!",
                                "Konteynerler Tanımlandı",
                                "success"
                            );
                            $("#konteyner_tanim_modal").modal("hide");
                            $.get("depo/view/is_emri_konteyner_tanim.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/is_emri_konteyner_tanim.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }
        });

        $("body").off("click", "#ihracat_siparisleri_getir_button").on("click", "#ihracat_siparisleri_getir_button", function () {
            $.get("depo/modals/ihracat_modal/konteyner_tanim_modal.php?islem=ihracat_kayitli_siparisleri_getir_modal", function (getModal) {
                $(".kayitli_siparisler_div").html(getModal);
            });
        });

        $("body").off("click", "#ithalat_siparisleri_getir_button").on("click", "#ithalat_siparisleri_getir_button", function () {
            $.get("depo/modals/ihracat_modal/konteyner_tanim_modal.php?islem=kayitli_siparisleri_getir_modal", function (getModal) {
                $(".kayitli_siparisler_div").html(getModal);
            });
        });

        $("body").off("click", "#tum_siparisleri_getir_button").on("click", "#tum_siparisleri_getir_button", function () {
            let cari_id = $("#cari_id").attr("data-id");
            $.get("depo/modals/konteyner_modal/arac_giris_yap_main_modal.php?islem=is_emirlerini_getir_sql", function (getModal) {
                $(".kayitli_siparisler_div").html(getModal);
            })
        });

        $("body").off("click", "#konteyner_tanim_modal_kapat").on("click", "#konteyner_tanim_modal_kapat", function () {
            $("#konteyner_tanim_modal").modal("hide");
        });

    </script>
    <?php
}