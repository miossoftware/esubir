<style>
    .excel_alis {
        background-color: #2ecc71 !important;
        border-color: #27ad60 !important;
        color: white !important;
        border-radius: 20px !important;
        font-weight: bold !important;
    }
</style>
<div class="ibox-container">
    <div class="cari_getir_div_ekstre"></div>
    <div class="ibox mt-5">
        <div class="ibox-head">
            <div class="ibox-title" style=' font-weight:bold;'>POS HESAP EKSTRESİ</div>
        </div>
        <div class="col-12 row no-gutters mt-3">
            <div class="col-md-1">
                <div class="input-group mb-3">
                    <input type="text" class="form-control form-control-sm secilen_pos_hesabı"
                           aria-describedby="basic-addon1" id="cari_id_filter" placeholder="POS Kodu">
                    <div class="input-group-append">
                        <button class="btn btn-warning btn-sm" id="pos_hesaplarini_getir_button"><i
                                    class="fa fa-ellipsis-h"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mx-1">
                <input type="text" style="background-color: #e08e0b; font-weight: bold;color: white !important;"
                       class="form-control form-control-sm pos_hesap_banka_adi" disabled value="POS Banka Adı">
            </div>
            <div class="col-md-1 mx-2">
                <input type="date" value="<?php
                $yil_basi = new DateTime();
                $yil_basi->modify('first day of January ' . $yil_basi->format('Y'));

                $yil_basi = $yil_basi->format('Y-m-d');
                echo $yil_basi;
                ?>"
                       class="form-control form-control-sm" id="bas_tarih">
            </div>

            <div class="col-md-1 mx-1">
                <input type="date" value="<?= date("Y-m-d") ?>"
                       class="form-control form-control-sm" id="bit_tarih">
            </div>
            <div class="col-1 mx-3">
                <button class="btn btn-secondary btn-sm" id="pos_hesap_ekstresi_filterle"><i class="fa fa-filter"></i>
                    Hazırla
                </button>
            </div>
        </div>
        <div class="mt-3"></div>
        <div class="hesap_ekstre_genel_main">
            <div class="col-12 row mt-3">
                <table class="table table-sm table-bordered w-100  nowrap edit_list"
                       style="cursor:pointer;font-size: 13px;"
                       id="pos_hesap_ekstresi_liste_rapor">
                    <thead>
                    <tr>
                        <th style="width: 0%">Tarih</th>
                        <th style="width: 1%">Belge Türü</th>
                        <th style="width: 2%">Açıklama</th>
                        <th style="width: 1%">POS Giren</th>
                        <th style="width: 1%">POS Çekilen</th>
                        <th style="width: 1%">POS Bakiye</th>
                    </tr>
                    </thead>
                    <tfoot style="background-color: white">
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="text-align: right" class="phe_giren">0,00</th>
                    <th style="text-align: right" class="phe_cikan">0,00</th>
                    <th style="text-align: right" class="phe_bakiye">0,00</th>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</div>
<script>
    var table = "";
    $(document).ready(function () {
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

        var targetColumns = [3, 4, 5];
        table = $('#pos_hesap_ekstresi_liste_rapor').DataTable({
            paging: false,
            scrollX: true,
            scrollY: "55vh",
            ordering: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "POS HESAP EKSTRESİ",
                    text: "<i class='fa fa-download'></i> Excel'e Aktar",
                    className: 'excel_alis', // Sınıfı burada tanımlayabilirsiniz
                    customizeData: function (excelData) {
                        // Özel veri dönüşümü ve formatlamaları yapabilirsiniz
                        // excelData, dışa aktarılacak Excel verilerini temsil eder

                        // Örneğin, her hücreyi sayı olarak biçimlendirme
                        for (var rowIdx = 0; rowIdx < excelData.body.length; rowIdx++) {
                            var rowData = excelData.body[rowIdx];
                            for (var cellIdx = 0; cellIdx < rowData.length; cellIdx++) {
                                var cellValue = excelData.body[rowIdx][cellIdx];
                                if (typeof cellValue === 'string') {
                                    if (targetColumns.includes(cellIdx)) {
                                        var parsedValue = parseFloat(cellValue.replace('.', '').replace(',', '.').replace(/\s/g, ''));
                                        if (!isNaN(parsedValue)) {
                                            excelData.body[rowIdx][cellIdx] = parsedValue.toLocaleString("en-US", {
                                                maximumFractionDigits: 2,
                                                minimumFractionDigits: 2
                                            });
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            ],
            "info": false,
            columns: [
                {"data": "tarih", "type": "date-eu"},
                {"data": "belge_turu"},
                {"data": "aciklama"},
                {"data": "pos_bakiye"},
                {"data": "pos_cekilen"},
                {"data": "bakiye"},
            ],
            "order": [[0, 'asc']],
            createdRow: function (row, data, dataIndex) {
                $(row).find("td").eq(0).css("text-align", "left");
                $(row).find("td").eq(1).css("text-align", "left");
                $(row).find("td").eq(2).css("text-align", "left");
                $(row).find("td").eq(7).css("text-align", "center");
                $(row).find("td").eq(8).css("text-align", "left");
            },
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        })

        $("body").off("click", "#pos_hesap_ekstresi_filterle").on("click", "#pos_hesap_ekstresi_filterle", function () {
            let bas_tarih = $("#bas_tarih").val();
            let bit_tarih = $("#bit_tarih").val();
            let pos_id = $(".secilen_pos_hesabı").attr("data-id");
            $.get("controller/ekstre_controller/sql.php?islem=pos_banka_hesap_ekstresi_getir_sql",
                {
                    bas_tarih: bas_tarih,
                    bit_tarih: bit_tarih,
                    pos_id: pos_id
                }
                , function (response) {
                    if (response != 2) {
                        var json = JSON.parse(response);
                        var basilacak_ekstre = [];
                        table.clear().draw(false);
                        let phe_giren = 0;
                        let phe_cikan = 0;
                        let phe_bakiye = 0;
                        json.forEach(function (item) {

                            let tarih = item.tarih;
                            tarih = tarih.split(" ");
                            tarih = tarih[0];
                            tarih = tarih.split("-");
                            let gun = tarih[2];
                            let ay = tarih[1];
                            let yil = tarih[0];
                            let arr = [gun, ay, yil];
                            tarih = arr.join("/");

                            let giren = item.alacak;
                            let cikan = item.borc;
                            giren = parseFloat(giren);
                            cikan = parseFloat(cikan);
                            phe_giren += giren;
                            phe_cikan += cikan;
                            let kalan = item.bakiye;
                            kalan = parseFloat(kalan);
                            phe_bakiye += kalan;
                            kalan = kalan.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            giren = giren.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                            cikan = cikan.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});

                            let newRow = {
                                tarih: tarih,
                                belge_turu: item.belge_turu,
                                aciklama: item.aciklama,
                                pos_bakiye: giren,
                                pos_cekilen: cikan,
                                bakiye: kalan
                            };
                            basilacak_ekstre.push(newRow);
                        })
                        $(".phe_giren").html(phe_giren.toLocaleString("tr-TR", {
                            maximumFractionDigits: 2,
                            minimumFractionDigits: 2
                        }))
                        $(".phe_cikan").html(phe_cikan.toLocaleString("tr-TR", {
                            maximumFractionDigits: 2,
                            minimumFractionDigits: 2
                        }))
                        $(".phe_bakiye").html(phe_bakiye.toLocaleString("tr-TR", {
                            maximumFractionDigits: 2,
                            minimumFractionDigits: 2
                        }))
                        table.rows.add(basilacak_ekstre).draw(false);
                    }
                })
        });
    })

    $("body").off("click", "#pos_hesaplarini_getir_button").on("click", "#pos_hesaplarini_getir_button", function () {
        $.get("modals/ekstre_modal.php?islem=pos_hesaplarini_getir_modal", function (getModal) {
            $(".cari_getir_div_ekstre").html("");
            $(".cari_getir_div_ekstre").html(getModal);
        })
    });


</script>