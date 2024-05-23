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
        <div class="ibox-title" style=' font-weight:bold;'>İTHALAT RAPORLARI</div>
    </div>
    <div class="col-12 row no-gutters mt-3">
        <div class="col-md-2">
            <div class="input-group mb-3">
                <input type="text" class="form-control form-control-sm"
                       aria-describedby="basic-addon1" id="epro_ref" placeholder="Epro Referans...">
                <div class="input-group-append">
                    <button class="btn btn-warning btn-sm" id="is_emirlerin_tamamini_getir_sql"><i
                                class="fa fa-ellipsis-h"></i></button>
                </div>
            </div>
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
            <button class="btn btn-secondary btn-sm" id="is_emri_bazli_filtrele"><i class="fa fa-filter"></i> Hazırla
            </button>
        </div>
    </div>
    <div class="col-12 row">
        <table class="table table-sm table-bordered w-100 nowrap datatable"
               style="cursor:pointer;font-size: 13px;"
               id="depo_ihracat_siparis_table">
            <thead>
            <tr>
                <th id="clickbait">No</th>
                <th>Sipariş Tarihi</th>
                <th>Cari Adı</th>
                <th>Liman Alım Tarihi</th>
                <th>Liman Alan Plaka</th>
                <th>Konteyner No</th>
                <th>Acente</th>
                <th>Referans No</th>
                <th>Mal Cinsi</th>
                <th id="birim_adi">KG</th>
                <th>Demoraj Tarihi</th>
                <th>Boş Teslim Yeri</th>
                <th>Boş Teslim Tarihi</th>
                <th>Müşteri Sevk Plaka</th>
                <th>Müşteri Sevk Tarihi</th>
                <th>İHR. Kont. No</th>
                <th>Yüklenen Miktar</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<script>
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
                {"data": "no"},
                {"data": "siparis_tarihi"},
                {"data": "cari_adi"},
                {"data": "liman_alim_tarihi"},
                {"data": "liman_alan_plaka"},
                {"data": "konteyner_no"},
                {"data": "acente"},
                {"data": "epro_ref"},
                {"data": "mal_cinsi"},
                {"data": "miktar"},
                {"data": "demoraj_tarihi"},
                {"data": "bos_teslim"},
                {"data": "bos_teslim_tarihi"},
                {"data": "sevk_plaka"},
                {"data": "sevk_tarihi"},
                {"data": "ihr_kont_no"},
                {"data": "yuklenen_miktar"}
            ],
            columnDefs: [
                {targets: 1, type: "date-eu"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find('td').eq(9).css('text-align', 'right');
                $(row).find('td').eq(16).css('text-align', 'right');
                $(row).find("td").css("text-transform", "uppercase");
            },
            "rowCallback": function (row) {
            },
            order: [[0, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        $("body").off("click", "#is_emri_bazli_filtrele").on("click", "#is_emri_bazli_filtrele", function () {
            let is_emri_id = $("#epro_ref").attr("data-id");
            let tipi = $("#epro_ref").attr("tipi");
            $.get("depo/controller/rapor_controller/sql.php?islem=is_emri_raporalirini_getir_sql", {
                tipi: tipi,
                is_emri_id: is_emri_id
            }, function (res) {
                if (res != 2) {
                    table.clear().draw(false);
                    let json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                    $("#birim_adi").html(json[0]["birim_adi"]);

                    setTimeout(function () {
                        $("#clickbait").trigger("click");
                    }, 500);
                }
            })
        });
    });

    $("body").off("click", "#is_emirlerin_tamamini_getir_sql").on("click", "#is_emirlerin_tamamini_getir_sql", function () {
        $.get("depo/modals/rapor_modal/tum_is_emirlerini_getir_modal.php?islem=tum_is_emirlerini_getir_modal", function (getModal) {
            $(".getModals").html(getModal);
        })
    });

</script>