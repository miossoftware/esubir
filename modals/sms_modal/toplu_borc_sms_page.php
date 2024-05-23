<?php

$islem = $_GET["islem"];


if ($islem == "toplu_sms_gonder_modal") {
    ?>
    <style>
        #borc_sms_i_gonder {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="borc_sms_i_gonder" data-backdrop="static" data-bs-keyboard="false"
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
                            <div class="col-12 row no-gutters">
                                <div class="col">
                                    <select class="custom-select custom-select-sm" id="tarife_ids">
                                        <option value="">Tarife Seçiniz...</option>
                                    </select>
                                </div>
                                <div class="col mx-1">
                                    <input type="text" class="form-control form-control-sm" placeholder="İlk Fiyat">
                                </div>
                                <div class="col mx-1">
                                    <input type="text" class="form-control form-control-sm" placeholder="Son Fiyat">
                                </div>
                                <div class="col mx-1">
                                    <button class="btn btn-secondary btn-sm" id="borc_alacak_getir_button"><i
                                                class="fa fa-filter"></i> Hazırla
                                    </button>
                                </div>
                            </div>
                            <input type="file" hidden id="dosyaSec" accept=".xlsx, .xls">
                            <div class="col-12 row">
                                <table class="table table-sm table-bordered w-100 display"
                                       style="cursor:pointer;font-size: 13px;"
                                       id="tahsile_verilen_cek_senet_tahsili_table">
                                    <thead>
                                    <tr>
                                        <th id="click_me">Ad Soyad</th>
                                        <th>Telefon</th>
                                        <th>Borç</th>
                                        <th style="width: 0% !important;">İşlem</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger btn-sm" id="ilk_tahsil_modal_vazgec"><i
                                            class="fa fa-close"></i> Vazgeç
                                </button>
                                <button class="btn btn-success btn-sm" id="borc_alacak_sms_gonder"><i
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
            $("#borc_sms_i_gonder").modal("show");
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

            $.get("controller/uye_controller/sql.php?islem=tarifeleri_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#tarife_ids").append("" +
                            "<option value='" + item.id + "'>" + item.tarife_adi + "</option>" +
                            "");
                    })
                }
            })

            sms_gidecek_kisiler = $('#tahsile_verilen_cek_senet_tahsili_table').DataTable({
                scrollY: '30vh',
                scrollX: true,
                "info": false,
                bAutoWidth: false,
                "order": [[0, 'desc']],
                searching: false,
                columns: [
                    {'data': 'cari_unvan'},
                    {'data': 'cep_no'},
                    {'data': 'bakiye'},
                    {'data': 'islem'}
                ],
                createdRow: function (row) {
                    $(row).addClass("sms_gonderilecekler_list");
                    $(row).find("td").eq(0).css("text-align", "left");
                    $(row).find("td").eq(1).css("text-align", "left");
                },
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
            })

            $("body").off("click", "#borc_alacak_getir_button").on("click", "#borc_alacak_getir_button", function () {
                let tarife_id = $("#tarife_ids").val();
                let ilk_fiyat = $("#ilk_fiyat").val();
                let son_fiyat = $("#son_fiyat").val();
                $.get("controller/uye_controller/sql.php?islem=borc_alacak_durumunu_getir_sql", {
                    tarife_id: tarife_id,
                    ilk_fiyat: ilk_fiyat,
                    son_fiyat: son_fiyat
                }, function (res) {
                    if (res != 2) {
                        var json = JSON.parse(res);
                        sms_gidecek_kisiler.clear().draw(false);
                        sms_gidecek_kisiler.rows.add(json).draw(false);
                    } else {
                        sms_gidecek_kisiler.clear().draw(false);
                    }
                })
            });
        });

        $("body").off("click", "#borc_alacak_sms_gonder").on("click", "#borc_alacak_sms_gonder", function () {
            let baslik = "Borç Bilgilendirmesi";
            let mesaj_icerigi = $("#icerik").val();
            let gidecek_arr = [];
            let telefonlar = [];
            $(".sms_gonderilecekler_list").each(function () {
                let ad_soyad = $(this).find("td").eq(0).text();
                let telefon = $(this).find("td").eq(1).text();
                let borc = $(this).find("td").eq(2).text();
                mesaj_icerigi = "ARSLANKÖY SULAMA BİRLİĞİ," +
                    "\n" +
                    "Değerli Üyemiz, 2024 dönemine ait  " + borc + " TL borcunuz bulunmaktadır. Ödeme yaptıysanız dikkate almayınız.."
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
                            }
                        });
                        Swal.fire(
                            "Başarılı!",
                            "SMS Gönderildi",
                            "success"
                        );
                        $("#borc_sms_i_gonder").modal("hide");
                    }
                }
            });

        });

        // document.getElementById('dosyaSec').addEventListener('change', function () {
        //     dosyaOku();
        // });
        //
        // $("body").off("click", "#excel_aktar").on("click", "#excel_aktar", function () {
        //     $("#dosyaSec").trigger("click");
        // })
        //
        // function dosyaOku() {
        //     var fileInput = document.getElementById('dosyaSec');
        //     var file = fileInput.files[0];
        //
        //     if (!file) {
        //         Swal.fire(
        //             "Uyarı",
        //             "Herhangi Bir Dosya Seçilmedi"
        //         )
        //         return;
        //     }
        //
        //     var dosyaUzanti = file.name.split('.').pop().toLowerCase();
        //     if (dosyaUzanti !== 'xlsx' && dosyaUzanti !== 'csv') {
        //         Swal.fire(
        //             "Uyarı",
        //             "Seçtiğiniz Dosya Excel Uzantılı Değildir...",
        //             "warning"
        //         )
        //         return;
        //     }
        //
        //     var reader = new FileReader();
        //     reader.onload = function (e) {
        //         var data = new Uint8Array(e.target.result);
        //         var workbook = XLSX.read(data, {type: 'array'});
        //
        //         // İlk çalışma sayfasını al
        //         var sheetName = workbook.SheetNames[0];
        //         var worksheet = workbook.Sheets[sheetName];
        //
        //         // Verileri alma
        //         var veri = XLSX.utils.sheet_to_json(worksheet, {header: 1});
        //
        //         // "konteyner_no" sütunundaki verileri al
        //         var scriptTagFound = false;
        //         for (let n = 0; n < veri.length; n++) {
        //             for (let j = 0; j < veri[n].length; j++) {
        //                 if (typeof veri[n][j] === 'string' && veri[n][j].includes('<script>')) {
        //                     scriptTagFound = true;
        //                     break;
        //                 }
        //             }
        //             if (scriptTagFound) {
        //                 break;
        //             }
        //         }
        //
        //         if (scriptTagFound) {
        //             Swal.fire(
        //                 "Uyarı",
        //                 "Excel dosyası içerisinde script bulundu!",
        //                 "warning"
        //             );
        //             $.ajax({
        //                 url: "controller/sql.php?islem=logout",
        //                 type: "POST",
        //                 data: {},
        //                 success: function () {
        //                     setTimeout(function () {
        //                         location.reload();
        //                     }, 800);
        //                 }
        //             });
        //         } else {
        //             let ad_soyad = veri[0].indexOf('ad_soyad');
        //             let konteynerNoIndex2 = veri[0].indexOf('telefon');
        //             let arr = [];
        //             for (let i = 1; i < veri.length; i++) {
        //                 let telefon = veri[i][konteynerNoIndex2];
        //                 let newRow = {
        //                     ad_soyad: veri[i][ad_soyad],
        //                     telefon: telefon,
        //                     islem: "<button class='btn btn-danger btn-sm sms_satir_sil_button' ><i class='fa fa-trash'></i></button>"
        //                 };
        //                 arr.push(newRow);
        //             }
        //             sms_gidecek_kisiler.rows.add(arr).draw(false);
        //         }
        //     };
        //
        //     reader.readAsArrayBuffer(file);
        // }

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
            $("#borc_sms_i_gonder").modal("hide");
        })
    </script>
    <?php
}