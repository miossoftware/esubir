<style>
    .excel_alis {
        background-color: #2ecc71 !important;
        border-color: #27ad60 !important;
        color: white !important;
        border-radius: 20px !important;
        font-weight: bold !important;
    }
</style>
<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>BANKA HESAP EKSTRESİ</div>
    </div>
    <div class="col-12 row no-gutters mt-3">
        <div class="col-md-1">
            <div class="input-group mb-3">
                <input type="text" class="form-control form-control-sm secilen_banka"
                       aria-describedby="basic-addon1" id="banka_id"  placeholder="Banka Kodu">
                <div class="input-group-append">
                    <button class="btn btn-warning btn-sm" id="banka_adi_button"><i
                                class="fa fa-ellipsis-h"></i></button>
                </div>
            </div>
        </div>
        <div class="col-md-2 mx-1">
            <input type="text" class="form-control form-control-sm banka_adi_getir" style="background-color: #e08e0b; font-weight: bold;color: white !important;" disabled value="Banka Adı">
        </div>
        <div class="col-md-2 mx-1">
            <input type="text" class="form-control form-control-sm sube_adi_getir" style="background-color: #e08e0b; font-weight: bold;color: white !important;" disabled value="Şube Adı">
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
            <button class="btn btn-secondary btn-sm" id="banka_ekstre_filtrele"><i class="fa fa-filter"></i> Hazırla
            </button>
        </div>
    </div>
    <div class="col-12 row">
        <table class="table table-sm table-bordered w-100  nowrap" id="banka_ekstre_main_list"
               style="font-size: 13px;">
            <thead>
            <tr>
                <th>Tarih</th>
                <th>Belge No</th>
                <th>Belge Türü</th>
                <th>Açıklama</th>
                <th>Çekilen</th>
                <th>Yatan</th>
                <th>Bakiye</th>
                <th>Durum</th>
            </tr>
            </thead>
            <tfoot style="background-color: white">
            <tr>
                <th colspan="4" style="text-align: right; font-size: 14px;">TOPLAM:</th>
                <th style="text-align: right; font-size: 14px;" class="toplam_cekilen">0,00</th>
                <th style="text-align: right; font-size: 14px;" class="toplam_yatan">0,00</th>
                <th style="text-align: right; font-size: 14px;" class="toplam_bakiye">0,00</th>
                <th style="text-align: right; font-size: 14px;" class="b_durum_son">YOK</th>
            </tr>
            </tfoot>
        </table>
    </div>
    <!--    <div class="col-12 row no-gutters mt-1">-->
    <!--        <div class="col-3"></div>-->
    <!--        <div class="col-5">-->
    <!--            <table class="table table-sm table-bordered w-100 display nowrap" style="background-color: white">-->
    <!--                <thead>-->
    <!--                <tr>-->
    <!--                    <th style="text-align: center">Çekilen</th>-->
    <!--                    <th style="text-align: center">Yatan</th>-->
    <!--                    <th style="text-align: center">Bakiye</th>-->
    <!--                    <th style="text-align: center">Durum</th>-->
    <!--                </tr>-->
    <!--                </thead>-->
    <!--                <tbody>-->
    <!--                <tr>-->
    <!--                    <td class="toplam_cekilen" style="text-align: right">0,00 TL</td>-->
    <!--                    <td class="toplam_yatan" style="text-align: right">0,00 TL</td>-->
    <!--                    <td class="toplam_bakiye" style="text-align: right">0,00 TL</td>-->
    <!--                    <td class="b_durum_son" style="text-align: center">YOK</td>-->
    <!--                </tr>-->
    <!--                </tbody>-->
    <!--            </table>-->
    <!--        </div>-->
    <!--        <div class="col-3">-->
    <!--        </div>-->
    <!--    </div>-->
</div>
<script>

    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });
    var banka_ekstre_table = "";
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

        var targetColumns = [4, 5, 6];
        banka_ekstre_table = $('#banka_ekstre_main_list').DataTable({
            scrollY: '55vh',
            scrollX: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "BANKA HESAP EKSTRESİ",
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
                {"data": "belge_no"},
                {"data": "belge_turu"},
                {"data": "aciklama"},
                {"data": "cekilen"},
                {"data": "yatan"},
                {"data": "bakiye"},
                {"data": "b_durum"}
            ],
            "order": [[0, 'asc']],
            createdRow: function (row,data,dataIndex) {
                $(row).find("td").eq(0).css("text-align", "left");
                $(row).find("td").eq(1).css("text-align", "left");
                $(row).find("td").eq(2).css("text-align", "left");
                $(row).find("td").eq(3).css("text-align", "left");
                $(row).find("td").eq(4).css("text-align", "right");
                $(row).find("td").eq(4).css("text-align", "right");
                $(row).find("td").eq(8).css("text-align", "center");
                
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });
    });

    $("body").off("click", "#banka_ekstre_filtrele").on("click", "#banka_ekstre_filtrele", function () {
        let banka_id = $("#banka_id").attr("data-id");
        let bas_tarih = $("#bas_tarih").val();
        let bit_tarih = $("#bit_tarih").val();
        let toplam_yatan = 0;
        let toplam_cekilen = 0;
        if (banka_id == "") {

        } else {
            $.get("controller/ekstre_controller/sql.php?islem=banka_hesap_ekstre_getir_sql",
                {
                    banka_id: banka_id,
                    bas_tarih: bas_tarih,
                    bit_tarih: bit_tarih
                }
                , function (result) {
                    if (result != 2) {
                        banka_ekstre_table.clear().draw(false);
                        var json = JSON.parse(result);
                        let basilacak = [];
                        json.forEach(function (item) {
                            let gonderilen_tarih = item.tarih;
                            gonderilen_tarih = gonderilen_tarih.split(" ");
                            gonderilen_tarih = gonderilen_tarih[0];
                            gonderilen_tarih = gonderilen_tarih.split("-");
                            var gun = gonderilen_tarih[2];
                            var ay = gonderilen_tarih[1];
                            var yil = gonderilen_tarih[0];
                            var arr = [gun, ay, yil];
                            gonderilen_tarih = arr.join("/");

                            var borc = item.yatan;
                            var alacak = item.cekilen;
                            borc = parseFloat(borc);
                            alacak = parseFloat(alacak);
                            toplam_yatan += borc;
                            toplam_cekilen += alacak;
                            borc = borc.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            alacak = alacak.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            var bakiye = item.bakiye;
                            bakiye = parseFloat(bakiye);
                            bakiye = bakiye.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });

                            basilacak.push({
                                tarih: gonderilen_tarih,
                                belge_no: item.belge_no,
                                belge_turu: item.belge_turu,
                                banka_adi: item.banka_adi,
                                sube_adi: item.sube_adi,
                                yatan: borc,
                                cekilen: alacak,
                                bakiye: bakiye,
                                b_durum: item.b_durum,
                                aciklama: item.aciklama
                            })
                        });

                        let basan_bakiye = toplam_yatan - toplam_cekilen;
                        toplam_yatan = toplam_yatan.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        $(".toplam_yatan").html("");
                        $(".toplam_yatan").html(toplam_yatan);
                        toplam_cekilen = toplam_cekilen.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        $(".toplam_cekilen").html("");
                        $(".toplam_cekilen").html(toplam_cekilen);
                        let b_durum = "";
                        if (basan_bakiye < 0) {
                            b_durum = "A";
                            basan_bakiye = -basan_bakiye;
                        } else if (basan_bakiye == 0) {
                            b_durum = "YOK";
                        } else {
                            b_durum = "B";
                        }
                        basan_bakiye = basan_bakiye.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        $(".toplam_bakiye").html("");
                        $(".toplam_bakiye").html(basan_bakiye);
                        $(".b_durum_son").html("");
                        $(".b_durum_son").html(b_durum);

                        banka_ekstre_table.rows.add(basilacak).draw(false);
                    }
                })
        }
    });

    $("body").off("click", "#banka_adi_button").on("click", "#banka_adi_button", function () {
        $.get("modals/ekstre_modal.php?islem=bankalari_getir_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    })
</script>