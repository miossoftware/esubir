<?php

$islem = $_GET["islem"];

if ($islem == "toplu_sms_gonder_modal") {
    ?>
    <style>
        #yeni_sms_gonder_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="yeni_sms_gonder_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 50%; max-width: 50%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="ilk_tahsil_modal_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>SMS GÖNDER</div>
                        </div>
                        <div class="modal-body">
                            <div class="sms_uyeleri"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Başlık</label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control form-control-sm" id="baslik">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Mesaj İçeriği</label>
                                        </div>
                                        <div class="col-md-9">
                                            <textarea class="form-control form-control-sm" style="resize: none"
                                                      id="icerik"
                                                      cols="30" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-success btn-sm" id="excel_aktar"><i class="fa fa-file"></i> Excel'den
                                Aktar
                            </button>
                            <button class="btn btn-success btn-sm" id="uyeleri_getir"><i class="fa fa-user"></i> Üyeleri
                                Getir
                            </button>
                            <input type="file" hidden id="dosyaSec" accept=".xlsx, .xls">
                            <div class="col-12 row">
                                <table class="table table-sm table-bordered w-100 display"
                                       style="cursor:pointer;font-size: 13px;"
                                       id="tahsile_verilen_cek_senet_tahsili_table">
                                    <thead>
                                    <tr>
                                        <th id="click_me">Ad Soyad</th>
                                        <th>Telefon</th>
                                        <th style="width: 0% !important;">İşlem</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger btn-sm" id="ilk_tahsil_modal_vazgec"><i
                                            class="fa fa-close"></i> Vazgeç
                                </button>
                                <button class="btn btn-success btn-sm" id="smsleri_gonder"><i
                                            class="fa fa-send"></i> Gönder
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var sms_gidecek_kisiler = "";
        $(document).ready(function () {
            $("#yeni_sms_gonder_modal").modal("show");
            setTimeout(function () {
                $("#click_me").trigger("click");
            }, 400);

            jQuery.extend(jQuery.fn.dataTableExt.oSort, {
                "date-eu-pre": function (dateString) {
                    var parts = dateString.split('/');
                    return Date.parse(parts[2] + '/' + parts[1] + '/' + parts[0]) || 0;
                },
                "date-eu-asc": function (a, b) {
                    return ((a < b) ? -1 : ((a > b) ? 1 : 0));
                },

                "date-eu-desc": function (a, b) {
                    return ((a < b) ? 1 : ((a > b) ? -1 : 0));
                }
            });
            sms_gidecek_kisiler = $('#tahsile_verilen_cek_senet_tahsili_table').DataTable({
                scrollY: '30vh',
                scrollX: true,
                "info": false,
                bAutoWidth: false,
                "order": [[0, 'desc']],
                searching: false,
                columns: [
                    {'data': 'ad_soyad'},
                    {'data': 'telefon'},
                    {'data': 'islem'},
                ],
                createdRow: function (row) {
                    $(row).addClass("sms_gonderilecekler_list");
                    $(row).find("td").eq(0).css("text-align", "left");
                    $(row).find("td").eq(1).css("text-align", "left");
                },
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
            })
        });

        $("body").off("click", "#uyeleri_getir").on("click", "#uyeleri_getir", function () {
            $.get("modals/sms_modal/sms_gonder.php?islem=uyeleri_getir_modal", function (getModal) {
                $(".sms_uyeleri").html(getModal)
            })
        });

        $("body").off("click", "#smsleri_gonder").on("click", "#smsleri_gonder", function () {
            let baslik = $("#baslik").val();
            let mesaj_icerigi = $("#icerik").val();
            let gidecek_arr = [];
            let telefonlar = [];
            $(".sms_gonderilecekler_list").each(function () {
                let ad_soyad = $(this).find("td").eq(0).text();
                let telefon = $(this).find("td").eq(1).text();
                let newRow = {
                    baslik: baslik,
                    icerik: mesaj_icerigi,
                    ad_soyad: ad_soyad,
                    telefon: telefon
                }
                let telefon2 = "90" + telefon;
                telefonlar.push(telefon2);
                gidecek_arr.push(newRow);
            });

            $.ajax({
                url: "controller/sms_controller/sql.php?islem=genel_sms_gonder_sql",
                type: "POST",
                data: {
                    gidecek_arr: gidecek_arr
                },
                success: function (res) {
                    if (res == 1) {
                        $.ajax({
                            url: "controller/send_sms.php?islem=cogul_mesaj_yolla_sql",
                            type: "POST",
                            data: {
                                baslik: baslik,
                                mesaj_icerigi: mesaj_icerigi,
                                telefonlar: telefonlar
                            },
                            success: function () {

                            }
                        });
                        Swal.fire(
                            "Başarılı!",
                            "SMS Gönderildi",
                            "success"
                        );
                        $("#yeni_sms_gonder_modal").modal("hide");
                    }
                }
            });

        });

        document.getElementById('dosyaSec').addEventListener('change', function () {
            dosyaOku();
        });

        $("body").off("click", "#excel_aktar").on("click", "#excel_aktar", function () {
            $("#dosyaSec").trigger("click");
        })

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
                    let ad_soyad = veri[0].indexOf('ad_soyad');
                    let konteynerNoIndex2 = veri[0].indexOf('telefon');
                    let arr = [];
                    for (let i = 1; i < veri.length; i++) {
                        let telefon = veri[i][konteynerNoIndex2];
                        let newRow = {
                            ad_soyad: veri[i][ad_soyad],
                            telefon: telefon,
                            islem: "<button class='btn btn-danger btn-sm sms_satir_sil_button' ><i class='fa fa-trash'></i></button>"
                        };
                        arr.push(newRow);
                    }
                    sms_gidecek_kisiler.rows.add(arr).draw(false);
                }
            };

            reader.readAsArrayBuffer(file);
        }

        $("body").off("click", ".sms_satir_sil_button").on("click", ".sms_satir_sil_button", function () {
            var row = $(this).closest('tr');
            sms_gidecek_kisiler.row(row).remove().draw();
        });

        $("body").off("click", "#tahsile_verilen_tahsil_edilecek_senetler").on("click", "#tahsile_verilen_tahsil_edilecek_senetler", function () {
            $.get("modals/senet_tahsil/modal.php?islem=tahsil_edilecek_cekleri_getir_modal", function (getModals) {
                $(".tahsil_edilecekleri_getir_div").html("");
                $(".tahsil_edilecekleri_getir_div").html(getModals);
            })
        });

        $("body").off("click", "#ilk_tahsil_modal_vazgec").on("click", "#ilk_tahsil_modal_vazgec", function () {
            $("#yeni_sms_gonder_modal").modal("hide");
        })
    </script>
    <?php
}
if ($islem == "uyeleri_getir_modal") {
    ?>
    <div class="modal fade" id="uyeleri_getir_sms_modal"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 80%; max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Üye Listesi
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <div class="col-12 row">
                            <div class="col-10"></div>
                            <div class="col-md-2">
                                <button class="btn btn-primary btn-sm" id="tumunu_sec_button"><i
                                            class="fa fa-check"></i> Hepsini Seç
                                </button>
                            </div>
                        </div>
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="fatura_cari_liste">
                            <thead>
                            <tr>
                                <th>Seç</th>
                                <th id="click1">Üye Adı</th>
                                <th>TC No</th>
                                <th>Telefon</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-success" id="secilenleri_aktar"><i class="fa fa-check"></i> Aktar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>

        $('input').click(function () {
            $(this).select();
        });

        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#uyeleri_getir_sms_modal").modal("hide");
        })

        $(document).ready(function () {
            $("#uyeleri_getir_sms_modal").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 300);
            var table = $('#fatura_cari_liste').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "sec"},
                    {'data': "uye_adi"},
                    {'data': "tc_no"},
                    {'data': "telefon"},
                ],
                createdRow: function (row) {
                    $(row).addClass("uye_selected_sms");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            });

            $.get("controller/uye_controller/sql.php?islem=uyeleri_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    let basilacak_arr = [];

                    json.forEach(function (item) {
                        let newRow = {
                            sec: "<input type='checkbox' class='col-md-9 secilen_uyeler' />",
                            uye_adi: item.uye_adi,
                            tc_no: item.tc_no,
                            telefon: item.cep_no
                        };
                        basilacak_arr.push(newRow);
                    });
                    table.rows.add(basilacak_arr).draw(false);
                }
            });

            $("body").off("click", "#secilenleri_aktar").on("click", "#secilenleri_aktar", function () {
                let listeye_gidecek = [];
                $(".uye_selected_sms").each(function () {
                    if ($(this).find("td:eq(0) input").prop("checked")) {
                        let uye_adi = $(this).find("td").eq(1).text();
                        let telefon = $(this).find("td").eq(3).text();
                        let newRow = {
                            ad_soyad: uye_adi,
                            telefon: telefon,
                            islem: "<button class='btn btn-danger btn-sm sms_satir_sil_button' ><i class='fa fa-trash'></i></button>"
                        };
                        listeye_gidecek.push(newRow);
                    }
                });
                sms_gidecek_kisiler.clear().draw(false)
                sms_gidecek_kisiler.rows.add(listeye_gidecek).draw(false);
                $("#uyeleri_getir_sms_modal").modal("hide");
            });

            $("body").off("click", "#tumunu_sec_button").on("click", "#tumunu_sec_button", function () {
                $(".uye_selected_sms").each(function (){
                    $(this).find("td:eq(0) input").prop("checked",true);
                });
            });

        });

    </script>
    <?php
}