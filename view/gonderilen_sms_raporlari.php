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
        <div class="ibox-title" style=' font-weight:bold;'>GÖNDERİLEN SMS RAPORLARI</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-info btn-sm" id=""><i
                        class="fa fa-filter"></i> Hazırla
            </button>
        </div>
        <div class="col-12 row">
            <div class="col-12 row mx-1 mt-3">
                <div class="col-md-3 row">
                    <input type="text" placeholder="Başlangıç Tarihi" id="bas_tarih_cek_senet"
                           onfocus="(this.type='date')"
                           class="form-control form-control-sm">
                    <input type="text" placeholder="Bitiş Tarihi" id="bit_tarih_cek_senet" onfocus="(this.type='date')"
                           class="form-control form-control-sm mt-2">
                </div>
            </div>
        </div>
        <div class="col-12 row mt-3">
            <table class="table table-sm table-bordered w-100 nowrap" style="cursor:pointer;font-size: 13px;"
                   id="cek_senet_tahsil_table">
                <thead>
                <tr>
                    <th style="width: 0% !important;">#</th>
                    <th style="width: 0% !important;">Gönderim Tarihi</th>
                    <th style="width: 0% !important;">Gönderen Kullanıcı</th>
                    <th style="width: 0% !important;">Gönderilen Kişi Sayısı</th>
                    <th style="width: 0% !important;">Başlık</th>
                    <th>Mesaj İçeriği</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var targetColumns = [5, 6, 7, 8, 9, 10];
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

        var table = $('#cek_senet_tahsil_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "order": [[1, 'desc']],
            columnDefs: [
                {targets: 0, type: "date-eu"}
            ],
            columns: [
                {"data": "#"},
                {"data": "gonderim_tarihi"},
                {"data": "gonderen_kullanici"},
                {"data": "kisi_sayisi"},
                {"data": "baslik"},
                {"data": "icerik"}
            ],
            createdRow: function (new_row) {
                $(new_row).find('td').css('text-align', 'left');
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        });
        $.get("controller/sms_controller/sql.php?islem=gonderilen_smsleri_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        })

        $("body").off("click", "#yeni_kredi_kullan_button").on("click", "#yeni_kredi_kullan_button", function () {
            $.get("modals/kredi_modal/yeni_kredi_kullan.php?islem=yeni_kredi_kullan_modal", function (getModal) {
                $(".getModals").html(getModal);
            })
        });

        // Gizli satırın içeriğini biçimlendir
        function formatHiddenRow(data) {
            var html = '<tr class="hidden-row" style="text-align: left;">';
            html += '<td>Gönderilen Kişi</td>';
            html += '<td style="text-align: left">' + data.ad_soyad + '</td>';
            html += '</tr>';
            return html;
        }

        $("body").off("click", ".kredi_detaylari_button").on("click", ".kredi_detaylari_button", function () {
            let id = $(this).attr("data-id");
            var tr = $(this).closest("tr");
            var row = table.row(tr);
            $.get("controller/uye_controller/sql.php?islem=sms_yollanan_kisiler", {id: id}, function (res) {
                var ek_arr = JSON.parse(res);

                if (row.child.isShown()) {
                    // Gizli satır zaten açıksa kapat
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    var html = "";
                    for (var i = 0; i < ek_arr.length; i++) {
                        html += formatHiddenRow(ek_arr[i]);
                    }
                    row.child(html).show();
                    tr.addClass('shown');
                }
            })
        });

    });

</script>