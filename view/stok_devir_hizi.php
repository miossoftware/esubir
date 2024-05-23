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
        <div class="ibox-title" style=' font-weight:bold;'>STOK DEVİR HIZI</div>
    </div>
    <div class="col-12 row no-gutters">
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
        <div class="col-md-2 mx-2">
            <button class="btn btn-secondary btn-sm" id="" data-name="stok_filter"><i
                        class="fa fa-filter"></i> Hazırla
            </button>
        </div>
    </div>
    <div class="col-12 row mt-3">
        <table class="table table-sm table-bordered w-100  nowrap" id="stok_table" style="font-size: 13px;">
            <thead>
            <tr>
                <th style="width: 0% !important;">Stok Kodu</th>
                <th style="width: 0% !important;">Stok Adı</th>
                <th style="width: 0% !important;">Barkod</th>
                <th style="width: 0% !important;">Birimi</th>
                <th style="width: 0% !important;">Ana Grubu</th>
                <th style="width: 0% !important;">Alt Grubu</th>
                <th style="width: 0% !important;">DBS</th>
                <th style="width: 0% !important;">DSS</th>
                <th style="width: 0% !important;">Satış Maliyeti</th>
                <th style="width: 1% !important;">Stok Devir Hızı</th>
                <th style="width: 1% !important;">Yıl Sonu Devir Hızı</th>
            </tr>
            </thead>
            <tbody id="stok_listesi">
            </tbody>
            <!--            <tfoot style="background-color: white">-->
            <!--            <tr>-->
            <!--                <th colspan="6" style="text-align: right; font-size: 14px;">TOPLAM:</th>-->
            <!--                <th style="text-align: right; font-size: 14px;" class="toplam_giren"></th>-->
            <!--                <th style="text-align: right; font-size: 14px;" class="toplam_alis"></th>-->
            <!--                <th style="text-align: right; font-size: 14px;" class="toplam_cikan"></th>-->
            <!--                <th style="text-align: right; font-size: 14px;" class="toplam_satis"></th>-->
            <!--                <th style="text-align: right; font-size: 14px;" class="kalan_miktar"></th>-->
            <!--                <th style="text-align: right; font-size: 14px;" class="maliyet"></th>-->
            <!--                <th style="text-align: right; font-size: 14px;" class="envanter_tutari"></th>-->
            <!--                <th></th>-->
            <!--            </tr>-->
            <!--            </tfoot>-->
        </table>
    </div>
</div>
<script>

    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });
    $(document).ready(function () {
        var targetColumns = [6, 7, 8, 9];
        var table = $('#stok_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            columns: [
                {"data": "stok_kodu"},
                {"data": "stok_adi"},
                {"data": "barkod"},
                {"data": "birim_adi"},
                {"data": "ana_grup_adi"},
                {"data": "altgrup_adi"},
                {"data": "donem_basi"},
                {"data": "donem_sonu"},
                {"data": "satis_maliyet"},
                {"data": "stok_devir_hizi"},
                {"data": "yil_sonu_devir_hizi"}
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "STOK RAPORLARI",
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
            createdRow: function (row, data, dataIndex) {
                $(row).find("td").eq(0).css("text-align", "left");
                $(row).find("td").eq(1).css("text-align", "left");
                $(row).find("td").eq(2).css("text-align", "left");
                $(row).find("td").eq(3).css("text-align", "left");
                $(row).find("td").eq(4).css("text-align", "left");
                $(row).find("td").eq(5).css("text-align", "left");
                $(row).find("td").eq(6).css("text-align", "right");
                $(row).find("td").eq(7).css("text-align", "right");
                $(row).find("td").eq(8).css("text-align", "right");
                $(row).find("td").eq(9).css("text-align", "left");
                $(row).find("td").eq(10).css("text-align", "left");

            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });
        $.get("controller/ekstre_controller/sql.php?islem=stok_devir_hizi_getir_sql", {
            bas_tarih: $("#bas_tarih").val(),
            bit_tarih: $("#bit_tarih").val(),
        }, function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                let basilacak_arr = [];
                json.forEach(function (item) {
                    let donem_basi_stok = item.donem_basi_stok;
                    donem_basi_stok = parseFloat(donem_basi_stok);
                    if (isNaN(donem_basi_stok)) {
                        donem_basi_stok = 0;
                    }
                    let donem_sonu_stok = item.donem_sonu_stok;
                    donem_sonu_stok = parseFloat(donem_sonu_stok);
                    if (isNaN(donem_sonu_stok)) {
                        donem_sonu_stok = 0;
                    }
                    let topla = donem_basi_stok + donem_sonu_stok;
                    let maliyet_tutar = item.elimdeki_maliyet;
                    maliyet_tutar = parseFloat(maliyet_tutar);
                    if (isNaN(maliyet_tutar)) {
                        maliyet_tutar = 0;
                    }
                    let cikan_mitar = item.cikan_miktar;
                    cikan_mitar = parseFloat(cikan_mitar);
                    if (isNaN(cikan_mitar)) {
                        cikan_mitar = 0;
                    }
                    let satilan_mal_maliyet = (maliyet_tutar / donem_sonu_stok) * cikan_mitar;
                    let sdh = satilan_mal_maliyet / (topla / 2);
                    if (isNaN(sdh)){
                        sdh = 0;
                    }
                    let ydh = 360 / sdh;
                    if (isNaN(ydh)){
                        ydh = 0;
                    }
                    let eklenecek_bosluk = "";
                    if (sdh < 9) {
                        eklenecek_bosluk = "&nbsp&nbsp&nbsp&nbsp&nbsp";
                    } else if (sdh > 9 && sdh < 99) {
                    }
                    let newRow = {
                        stok_kodu: item.stok_kodu,
                        stok_adi: item.stok_adi,
                        barkod: item.barkod,
                        birim_adi: item.birim_adi,
                        ana_grup_adi: item.ana_grup_adi,
                        altgrup_adi: item.altgrup_adi,
                        donem_basi: donem_basi_stok.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }),
                        donem_sonu: donem_sonu_stok.toLocaleString("tr-TR", {
                            maximumFractionDigits: 2,
                            minimumFractionDigits: 2
                        }),
                        satis_maliyet: maliyet_tutar.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }),
                        stok_devir_hizi: "" + eklenecek_bosluk + "" + sdh.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }) + "| Stok " + sdh.toLocaleString("tr-TR", {
                            maximumFractionDigits: 2,
                            minimumFractionDigits: 2
                        }) + " Kez Yenilenmiştir",
                        yil_sonu_devir_hizi: " " + eklenecek_bosluk + "" + ydh.toLocaleString("tr-TR", {
                            maximumFractionDigits: 2,
                            minimumFractionDigits: 2
                        }) + "| Stokta Kalma Süresi: " + ydh.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }) + " Gün"
                    };
                    basilacak_arr.push(newRow);
                });
                table.rows.add(basilacak_arr).draw(false);
            }
        })
    });
</script>