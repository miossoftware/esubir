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
        <div class="ibox-title" style=' font-weight:bold;'>DEPODA BULUNAN ÜRÜNLER</div>
    </div>
    <div class="col-12 row tetikle">
        <div class="col-12 row mt-5">
            <table class="table table-sm table-bordered w-100  nowrap datatable"
                   style="cursor:pointer;font-size: 13px;"
                   id="alis_fatura_table">
                <thead>
                <tr>
                    <th>Müşteri Adı</th>
                    <th>Mal Cinsi</th>
                    <th>Giren Miktar</th>
                    <th>Çıkan Miktar</th>
                    <th>Kalan Miktar</th>
                </tr>
                </thead>
                <tfoot style="background-color: white">
                <th></th>
                <th></th>
                <th class="giren_tot" style="text-align: right">0</th>
                <th class="cikan_tot" style="text-align: right">0</th>
                <th class="toplam_tot" style="text-align: right">0</th>
                </tfoot>
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
                    className: 'excel_alis',
                    customizeData: function (excelData) {
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
                {"data": "cari_adi"},
                {"data": "mal_cinsi"},
                {"data": "giren_miktar"},
                {"data": "cikan_miktar"},
                {"data": "kalan_miktar"}
            ],
            columnDefs: [
                {targets: 2, type: "date-eu"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find('td').eq(2).css('text-align', 'right');
                $(row).find('td').eq(3).css('text-align', 'right');
                $(row).find('td').eq(4).css('text-align', 'right');
                $(row).find("td").css("text-transform", "uppercase")
            },
            "rowCallback": function (row) {
            },
            order: [[2, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        $.get("depo/controller/acente_controller/sql.php?islem=depodaki_urunleri_getir_sql", function (res) {
            if (res != 2) {
                let json = JSON.parse(res);
                $(".giren_tot").html(json[0]["giren_tot"]);
                $(".cikan_tot").html(json[0]["cikan_tot"]);
                $(".is_emri_tot").html(json[0]["is_emri_tot"]);
                $(".toplam_tot").html(json[0]["toplam_tot"]);
                table.rows.add(json).draw(false);
            }
        })

    });
</script>