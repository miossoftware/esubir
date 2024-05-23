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
        <div class="ibox-title" style=' font-weight:bold;'>SATIŞ HİZMET LİSTESİ</div>
    </div>
    <div class="col-12 row">
        <table class="table table-sm table-bordered w-100  nowrap datatable"
               style="cursor:pointer;font-size: 13px;"
               id="depo_cikis_table">
            <thead>
            <tr>
                <th>Cari Adı</th>
                <th>Sipariş Tarihi</th>
                <th>Hizmet Türü</th>
                <th>Konteyner No</th>
                <th>Giriş Tarihi</th>
                <th>Çıkış Tarihi</th>
                <th>Hizmet Bedeli</th>
                <th>Beyanname No</th>
                <th>Referans No</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<script>

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
        var targetColumns = [5, 6, 7, 12, 13, 14];
        var table = $('#depo_cikis_table').DataTable({
            scrollX: true,
            scrollY: '45vh',
            "paging": false,
            columns: [
                {"data": "cari"},
                {"data": "siparis_tarihi"},
                {"data": "hizmet_turu"},
                {"data": "konteyner_no"},
                {"data": "giris_tarihi"},
                {"data": "cikis_tarihi"},
                {"data": "ucret"},
                {"data": "beyanname_no"},
                {"data": "referans_no"},
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find('td').eq(5).css('text-align', 'right');
                $(row).find('td').eq(6).css('text-align', 'right');
                $(row).find("td").css("text-transform", "uppercase")

            },
            "rowCallback": function (row) {
            },
            order: [[1, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });
        $.get("depo/controller/satis_controller/sql.php?islem=gelmesi_beklenen_faturalari_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        })
    });

</script>