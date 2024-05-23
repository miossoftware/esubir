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
        <div class="ibox-title" style=' font-weight:bold;'>ARAÇ HESAPLARI</div>
    </div>
    <div class="col-12 row no-gutters">
        <div class="col-md-1 mx-2">
            <input type="date" class="form-control form-control-sm" value="<?=date("Y-m-01")?>" id="bas_tarih">
        </div>
        <div class="col-md-1 mx-2">
            <input type="date" class="form-control form-control-sm" id="bit_tarih" value="<?=date("Y-m-t")?>">
        </div>
        <div class="col-md-2 mx-2">
            <button class="btn btn-secondary btn-sm" id="arac_hesap_filtrele"><i
                        class="fa fa-filter"></i> Hazırla
            </button>
        </div>
    </div>
    <div class="col-12 row mt-3">
        <table class="table table-sm table-bordered w-80 nowrap" id="stok_table" style="font-size: 13px;">
            <thead>
            <tr>
                <th style="width: 0% !important;">No</th>
                <th style="width: 0% !important;">Plaka</th>
                <th>Ciro</th>
                <th>Masraf</th>
                <th>Kar/Zarar</th>
                <th>Motorin</th>
                <th>Prim</th>
                <th>HGS</th>
                <th>Maaş</th>
                <th>SGK</th>
                <th style="width: 0% !important;">Ceza / MTV</th>
                <th style="width: 0% !important;">Araç Giderleri</th>
                <th style="width: 0% !important;">Sanayi</th>
                <th style="width: 0% !importantr">Lastik</th>
                <th style="text-align: center">Bölge</th>
            </tr>
            </thead>
            <tbody id="stok_listesi">
            </tbody>
            <tfoot style="background-color: white">
            <tr>
                <th></th>
                <th style="text-align: right; font-size: 14px;">TOPLAM:</th>
                <th style="text-align: right; font-size: 14px;" class="toplam_ciro">0,00</th>
                <th style="text-align: right; font-size: 14px;" class="toplam_masraf">0,00</th>
                <th style="text-align: right; font-size: 14px;" class="kar_zarar">0,00</th>
                <th style="text-align: right; font-size: 14px;" class="motorin">0,00</th>
                <th style="text-align: right; font-size: 14px;" class="prim">0,00</th>
                <th style="text-align: right; font-size: 14px;" class="hgs">0,00</th>
                <th style="text-align: right; font-size: 14px;" class="maas">0,00</th>
                <th style="text-align: right; font-size: 14px;" class="sgk">0,00</th>
                <th style="text-align: right; font-size: 14px;" class="ceza_mtv_tot">0,00</th>
                <th style="text-align: right; font-size: 14px;" class="arac_gider_toplam">0,00</th>
                <th style="text-align: right; font-size: 14px;" class="sanayi">0,00</th>
                <th style="text-align: right; font-size: 14px;" class="lastik">0,00</th>
                <th></th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
<script>

    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });
    $(document).ready(function () {
        var targetColumns = [2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
        var table = $('#stok_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            columns: [
                {"data": "no"},
                {"data": "plaka_no"},
                {"data": "ciro"},
                {"data": "masraf"},
                {"data": "kar_zarar"},
                {"data": "yakit_tutar"},
                {"data": "prim_odeme"},
                {"data": "hgs_tutar"},
                {"data": "maas_tutar"},
                {"data": "sgk_tutari"},
                {"data": "ceza_mtv"},
                {"data": "aracgider"},
                {"data": "sanayi_toplam"},
                {"data": "lastik_tutar"},
                {"data": "bolgesi"}
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "Araç Hesapları",
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
            createdRow: function (row) {
                $(row).find("td").eq(0).css("text-align", "left");
                $(row).find("td").eq(1).css("text-align", "left");

            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        $("body").off("click", "#arac_hesap_filtrele").on("click", "#arac_hesap_filtrele", function () {
            let bas_tarih = $("#bas_tarih").val();
            let bit_tarih = $("#bit_tarih").val();
            $.get("controller/rapor_controller/sql.php?islem=arac_hesaplari_sql", {bas_tarih: bas_tarih, bit_tarih: bit_tarih}, function (res) {
                if (res != 2) {
                    table.clear().draw(false);
                    var json = JSON.parse(res);
                    $(".toplam_ciro").html(json[0].ciro_toplam);
                    $(".toplam_masraf").html(json[0].masraf_toplam);
                    $(".kar_zarar").html(json[0].kar_zarar_toplam);
                    $(".prim").html(json[0].prim_toplam);
                    $(".hgs").html(json[0].hgs_toplam);
                    $(".maas").html(json[0].maas_toplam);
                    $(".sgk").html(json[0].sgk_toplam);
                    $(".motorin").html(json[0].motorin_toplam);
                    $(".sanayi").html(json[0].sanayi_toplam_main);
                    $(".lastik").html(json[0].lastik_toplam);
                    $(".ceza_mtv_tot").html(json[0].ceza_mtv_tot);
                    $(".arac_gider_toplam").html(json[0].arac_gider_toplam);
                    table.rows.add(json).draw(false);
                }
            })
        });
    });
</script>