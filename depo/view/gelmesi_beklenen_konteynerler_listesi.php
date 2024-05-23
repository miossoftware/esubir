<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>GELMESİ BEKLENEN KONTEYNERLER</div>
    </div>
    <div class="col-12 row">
        <div class="col-12 row mt-5">
            <table class="table table-sm table-bordered w-100  datatable"
                   style="cursor:pointer;font-size: 13px;"
                   id="depo_ihracat_siparis_table">
                <thead>
                <tr>
                    <th>Tipi</th>
                    <th>Konteyner No</th>
                    <th>Konteyner Tipi</th>
                    <th>Referans No</th>
                    <th>Beyanname No</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
    $("body").off("click", "#konteyner_tanim").on("click", "#konteyner_tanim", function () {
        $.get("depo/modals/ihracat_modal/ihracat_konteyner_tanim.php?islem=ihracat_konteyner_tanimla_modal", function (getModal) {
            $(".getModals").html(getModal);
        })
    })
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
    $(document).ready(function () {
        var targetColumns = [5, 6, 7, 12, 13, 14];
        var table = $('#depo_ihracat_siparis_table').DataTable({
            scrollX: true,
            scrollY: '45vh',
            "paging": false,
            columns: [
                /**
                 *
                 ktu.*,
                 is_s2.beyanname_no,
                 is_s1.acente_ref as referans_no,
                 kt.tipi
                 */
                {"data": "tipi"},
                {"data": "konteyner_no"},
                {"data": "konteyner_tipi"},
                {"data": "referans_no"},
                {"data": "beyanname_no"}
            ],
            columnDefs: [
                {targets: 0, type: "date-eu"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find('td').eq(7).css('text-align', 'right');
                $(row).find('td').eq(8).css('text-align', 'right');
                $(row).find("td").css("text-transform", "uppercase")
            },
            "rowCallback": function (row) {
            },
            order: [[0, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        $.get("depo/controller/konteyner_controller/sql.php?islem=gelmesi_beklenen_konteynerleri_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        })
    });

</script>