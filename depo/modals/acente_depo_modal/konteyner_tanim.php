<?php


$islem = $_GET["islem"];

if ($islem == "konteyner_tanimla_modal") {
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
                                    <label>Referans No</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="referans_no">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <input type="file" id="dosyaSec" accept=".xlsx, .csv">
                                </div>
                                <div class="col-md-7">
                                    <span style="font-weight: bold;color: red">
                                        <img src="assets/img/ornek1.png" alt="">
                                        <!--                                        KONTEYNER NUMARALARINIZ EXCEL'DE konteyner_no OLARAK BAŞLIKLANDIRINIZ<br>-->
                                        <!--                                        KONTEYNER TİPLERİNİZİ ARALARINDA BOŞLUK OLARAK VE BÜYÜK HARFLERLE YAZINIZ! ÖRNEK:(40 HC)<br>-->
                                        <!--                                        HER KONTEYNERİN TİPİ OLMASI GEREKİR AKSİ TAKDİRDE HATA ALIRSINIZ-->
                                    </span>
                                </div>
                            </div>
                            <button class="btn btn-success btn-sm yeni_satir_ekle"><i class="fa fa-plus"></i> Satır Ekle
                            </button>
                            <div class="col-12 row">
                                <div class="col-12 row mt-2">
                                    <table class="table table-sm table-bordered w-100  nowrap"
                                           id="konteyner_toplu_table"
                                           style="font-size: 13px;">
                                        <thead>
                                        <tr>
                                            <th id="ant_1">Konteyner No</th>
                                            <th>Tipi</th>
                                            <th>Açıklama</th>
                                            <th>İşlem</th>
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
                order: [0, ["asc"]],
                columnDefs: [
                    {
                        type: 'natural',
                        targets: 0 // Konteyner No sütunu için
                    }
                ],
                columns: [
                    {'data': 'konteyner_no'},
                    {'data': 'tipi'},
                    {'data': 'aciklama'},
                    {'data': 'islem'}
                ],
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row, data, dataIndex) {
                    $(row).addClass("acente_konteyner_tanim_selected");
                    $(row).find("td").css("text-align", "left");

                }
            });
        });

        jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "natural-asc": function (a, b) {
                return naturalSort(a, b);
            },

            "natural-desc": function (a, b) {
                return naturalSort(a, b) * -1;
            }
        });

        function naturalSort(a, b) {
            var ax = [],
                bx = [];

            a.replace(/(\d+)|(\D+)/g, function (_, $1, $2) {
                ax.push([$1 || Infinity, $2 || ""]);
            });

            b.replace(/(\d+)|(\D+)/g, function (_, $1, $2) {
                bx.push([$1 || Infinity, $2 || ""]);
            });

            while (ax.length && bx.length) {
                var an = ax.shift();
                var bn = bx.shift();
                var nn = an[0] - bn[0] || an[1].localeCompare(bn[1]);
                if (nn) return nn;
            }

            return ax.length - bx.length;
        }

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
                    let konteynerNoIndex2 = veri[0].indexOf('konteyner_tipi');
                    let konteynerNoIndex3 = veri[0].indexOf('aciklama');
                    let arr = [];
                    for (let i = 1; i < veri.length; i++) {
                        let tipi = veri[i][konteynerNoIndex2];
                        let newRow = {
                            konteyner_no: "<input type='text' value='" + veri[i][konteynerNoIndex] + "'  class='form-control form-control-sm col-9' />",
                            tipi: "<select class='custom-select custom-select-sm' style='width: 50%'>" +
                                "<option value='' " + (tipi == '' ? 'selected' : '') + ">Konteyner Tipi...</option>" +
                                "<option value='40 HC' " + (tipi == '40 HC' ? 'selected' : '') + ">40 HC</option>" +
                                "<option value='40 DC' " + (tipi == '40 DC' ? 'selected' : '') + ">40 DC</option>" +
                                "<option value='20 DC' " + (tipi == '20 DC' ? 'selected' : '') + ">20 DC</option>" +
                                "<option value='20 OT' " + (tipi == '20 OT' ? 'selected' : '') + ">20 OT</option>" +
                                "<option value='40 OT' " + (tipi == '40 OT' ? 'selected' : '') + ">40 OT</option>" +
                                "<option value='20 RF' " + (tipi == '20 RF' ? 'selected' : '') + ">20 RF</option>" +
                                "<option value='40 RF' " + (tipi == '40 RF' ? 'selected' : '') + ">40 RF</option>" +
                                "<option value='40 HC RF' " + (tipi == '40 HC RF' ? 'selected' : '') + ">40 HC RF</option>" +
                                "<option value='20 TANK' " + (tipi == '20 TANK' ? 'selected' : '') + ">20 TANK</option>" +
                                "<option value='20 VENTILATED' " + (tipi == '20 VENTILATED' ? 'selected' : '') + ">20 VENTILATED</option>" +
                                "<option value='40 HC PAL. WIDE' " + (tipi == '40 HC PAL. WIDE' ? 'selected' : '') + ">40 HC PAL. WIDE</option>" +
                                "<option value='20 FLAT' " + (tipi == '20 FLAT' ? 'selected' : '') + ">20 FLAT</option>" +
                                "<option value='40 FLAT' " + (tipi == '40 FLAT' ? 'selected' : '') + ">40 FLAT</option>" +
                                "<option value='40 HC FLAT' " + (tipi == '40 HC FLAT' ? 'selected' : '') + ">40 HC FLAT</option>" +
                                "<option value='20 PLATFORM' " + (tipi == '20 PLATFORM' ? 'selected' : '') + ">20 PLATFORM</option>" +
                                "<option value='40 PLATFORM' " + (tipi == '40 PLATFORM' ? 'selected' : '') + ">40 PLATFORM</option>" +
                                "<option value='45 HC' " + (tipi == '45 HC' ? 'selected' : '') + ">45 HC</option>" +
                                "<option value='KARGO' " + (tipi == 'KARGO' ? 'selected' : '') + ">KARGO</option>" +
                                "</select>",
                            aciklama: "<input type='text' value='" + veri[i][konteynerNoIndex3] + "' class='form-control form-control-sm col-9' style='width: 100%' />",
                            islem: "<button class='btn btn-success btn-sm yeni_satir_ekle'><i class='fa fa-plus'></i></button> <button class='btn btn-danger btn-sm satiri_sil_button' ><i class='fa fa-trash'></i></button>"
                        };
                        arr.push(newRow);
                    }
                    toplu_table.rows.add(arr).draw(false);
                }
            };

            reader.readAsArrayBuffer(file);
        }

        $("body").off("click", ".yeni_satir_ekle").on("click", ".yeni_satir_ekle", function () {
            let arr = [];
            let newRow = {
                konteyner_no: "<input type='text' class='form-control form-control-sm col-9' style='width: 100%'/>",
                tipi: "<select class='custom-select custom-select-sm' style='width: 50%'>" +
                    "<option value=''>Konteyner Tipi...</option>" +
                    "<option value='40 HC'>40 HC</option>" +
                    "<option value='40 DC'>40 DC</option>" +
                    "<option value='20 DC'>20 DC</option>" +
                    "<option value='20 OT'>20 OT</option>" +
                    "<option value='40 OT'>40 OT</option>" +
                    "<option value='20 RF'>20 RF</option>" +
                    "<option value='40 RF'>40 RF</option>" +
                    "<option value='40 HC RF'>40 HC RF</option>" +
                    "<option value='20 TANK'>20 TANK</option>" +
                    "<option value='20 VENTILATED'>20 VENTILATED</option>" +
                    "<option value='40 HC PAL. WIDE'>40 HC PAL. WIDE</option>" +
                    "<option value='20 FLAT'>20 FLAT</option>" +
                    "<option value='40 FLAT'>40 FLAT</option>" +
                    "<option value='40 HC FLAT'>40 HC FLAT</option>" +
                    "<option value='20 PLATFORM'>20 PLATFORM</option>" +
                    "<option value='40 PLATFORM'>40 PLATFORM</option>" +
                    "<option value='45 HC'>45 HC</option>" +
                    "<option value='KARGO'>KARGO</option>" +
                    "</select>",
                aciklama: "<input type='text' class='form-control form-control-sm col-9' style='width: 100%'/>",
                islem: "<button class='btn btn-success btn-sm yeni_satir_ekle'><i class='fa fa-plus'></i></button> <button class='btn btn-danger btn-sm satiri_sil_button'><i class='fa fa-trash'></i></button>"
            };
            arr.push(newRow) // diziye bir küme ekler
            arr.reverse(); // diziyi tersine çevirir.
            toplu_table.rows.add(arr).draw(false);
        });


        $("body").off("click", "#konteyner_toplu_tanim_modal_kapat").on("click", "#konteyner_toplu_tanim_modal_kapat", function () {
            $("#konteyner_toplu_tanim_modal").modal("hide");
        });

        $("body").off("click", ".satiri_sil_button").on("click", ".satiri_sil_button", function () {
            var row = toplu_table.row($(this).closest('tr'));

            // Silme işlemi için onay al
            Swal.fire({
                title: 'Emin misiniz?',
                text: 'Bu satırı silmek istediğinizden emin misiniz?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Evet, sil',
                cancelButtonText: 'İptal',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Satırı sil
                    row.remove().draw(false);
                    Swal.fire(
                        'Silindi!',
                        'Satır başarıyla silindi.',
                        'success'
                    );
                }
            });
        });

        $("body").off("click", "#firma_kodu_button").on("click", "#firma_kodu_button", function () {
            $.get("depo/modals/nakliye_depolama_modal/nakliye_depolama.php?islem=nakliye_giris_carileri_getir", function (getModal) {
                $(".konteyner_tanim_cari_div").html(getModal);
            })
        });

        $("body").off("click", "#depo_konteyner_tanimla").on("click", "#depo_konteyner_tanimla", function () {
            let tipi = $("#tipi").val();
            let cari_id = $("#firma_kodu").attr("data-id");
            let bildirim_tarihi = $("#bildirim_tarihi").val();
            let referans_no = $("#referans_no").val();
            let gidecek_arr = [];

            $(".acente_konteyner_tanim_selected").each(function () {
                let konteyner_no = $(this).find("td:eq(0) input").val();
                let konteyner_tipi = $(this).find("td:eq(1) option:selected").val();
                let aciklama = $(this).find("td:eq(2) input").val();

                let newRow = {
                    konteyner_no: konteyner_no,
                    konteyner_tipi: konteyner_tipi,
                    aciklama: aciklama
                };
                gidecek_arr.push(newRow);
            });
            if (cari_id == "" || cari_id == undefined) {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Acente Seçiniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "depo/controller/acente_controller/sql.php?islem=acente_konteyner_tanimla_sql",
                    type: "POST",
                    data: {
                        tipi: tipi,
                        cari_id: cari_id,
                        bildirim_tarihi: bildirim_tarihi,
                        referans_no: referans_no,
                        gidecek_arr: gidecek_arr
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Konteynerler Tanımlandı...",
                                "success"
                            );
                            $("#konteyner_toplu_tanim_modal").modal("hide");
                            $.get("depo/view/konteyner_toplu_tanim.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/konteyner_toplu_tanim.php", function (getList) {
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