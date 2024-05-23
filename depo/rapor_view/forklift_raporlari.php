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
        <div class="ibox-title" style=' font-weight:bold;'>FORKLİFT RAPORLARI</div>
    </div>
    <div class="col-12 row tetikle">
        <div class="col-12 row mt-5">
            <table class="table table-sm table-bordered w-100  nowrap datatable"
                   style="cursor:pointer;font-size: 13px;"
                   id="alis_fatura_table">
                <thead>
                <tr>
                    <th>Forklift Adı</th>
                    <th>Saati</th>
                    <th>Çatal</th>
                    <th>Sıkma</th>
                    <th>Bobin</th>
                    <th>Kova</th>
                    <th>Tomruk</th>
                    <th>Kürek</th>
                    <th>Palet</th>
                    <th>Çalışma Türü</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>

    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });
    $('.tetikle').on('keydown', function (event) {
        if (event.keyCode === 13) {
            $("#alis_fatura_filtrele").click();
        }
    });

    $(document).ready(function () {
        $.extend($.fn.dataTableExt.oSort, {
            "date-eu-pre": function (dateString) {
                var dateArray = dateString.split('/');
                var formattedDate = dateArray[2] + '-' + dateArray[1] + '-' + dateArray[0];
                return Date.parse(formattedDate) || 0;
            },

            "date-eu-asc": function (a, b) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },

            "date-eu-desc": function (a, b) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        });
        var table = $('#alis_fatura_table').DataTable({
            scrollX: true,
            scrollY: '45vh',
            "paging": false,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "DEPODA BULUNAN KONTEYNERLER LİSTESİ",
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
            columns: [
                {"data": "giris_tarihi"},
                {"data": "tasima_tipi"},
                {"data": "bos_dolu"},
                {"data": "depo_firma_adi"},
                {"data": "konteyner_no"},
                {"data": "firma_adi"},
                {"data": "acente_adi"},
                {"data": "tipi"},
                {"data": "plaka_no"},
                {"data": "plaka_cari"}
            ],
            columnDefs: [
                {targets: 2, type: "date-eu"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find('td').eq(15).css('text-align', 'right');
                $(row).find('td').eq(14).css('text-align', 'right');
                $(row).find('td').eq(17).css('text-align', 'right');
                $(row).find("td").css("text-transform", "uppercase")
            },
            "rowCallback": function (row) {
            },
            order: [[2, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        $.get("depo/controller/rapor_controllersql.php?islem=forklift_raporlarini_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        })

    });
</script>