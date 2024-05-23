<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>ÖDENECEK ÇEK VE SENETLER LİSTESİ</div>
    </div>

    <div class="col-12 row">
        <div class="col-12 row mx-1 mt-3">
            <div class="col-md-2 row">
                <input type="text" placeholder="Başlangıç Tarihi" id="bas_tarih" onfocus="(this.type='date')"
                       class="form-control form-control-sm bas_tarih_alis">
                <input type="text" placeholder="Bitiş Tarihi" id="bit_tarih" onfocus="(this.type='date')"
                       class="form-control form-control-sm mt-2 bit_tarih_alis">
            </div>
            <div class="col-md-2 row mx-1">
                <input type="text" placeholder="Firma Adı" id="cari_adi"
                       class="form-control form-control-sm">
                <button class="btn btn-info btn-sm" id="odenecek_cek_ve_senet_filtrele"><i
                            class="fa fa-filter"></i> Filtrele
                </button>
            </div>
        </div>
    </div>
    <div class="col-md-12 row">
        <table class="table table-sm table-bordered w-100  nowrap"
               style="cursor:pointer;font-size: 13px;"
               id="verilen_siparis_tablo">
            <thead>
            <tr>
                <th>Tarih</th>
                <th>Vade Tarihi</th>
                <th>Keşide Yeri</th>
                <th>Tutar</th>
                <th>Banka Adı</th>
                <th>Şube Adı</th>
                <th>Çek Seri No</th>
                <th>Açıklama</th>
                <th>Özel Kod</th>
                <th>Son Durum</th>
            </tr>
            </thead>
            <tfoot style="background-color: white">
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align: right" class="toplam_tot">0,00</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </tfoot>
        </table>
    </div>
    <div class="gosterilecek_tablo" style="display: none">
        <table class="table table-sm table-bordered w-100  nowrap"
               style="cursor:pointer;font-size: 13px;"
               id="cek_detay_tablo">
            <thead>
            <tr>
                <th>Tarih</th>
                <th>Bordro No</th>
                <th>Cari Adı</th>
                <th>Banka Adı</th>
                <th>TL Tutar</th>
                <th>Döviz Türü</th>
                <th>Döviz Kuru</th>
                <th>Döviz Tutarı</th>
                <th>Durum</th>
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

        var table = $('#verilen_siparis_tablo').DataTable({
            scrollX: true,
            scrollY: '50vh',
            "info": false,
            createdRow: function (row, data) {
                $(row).attr("data-id", data.id);
                $(row).attr("came_from", data.geldigi_yer);
                $(row).find("td").eq(0).css("text-align", "left");
                $(row).find("td").eq(1).css("text-align", "left");
                $(row).find("td").eq(2).css("text-align", "left");
                $(row).find("td").eq(4).css("text-align", "left");
                $(row).find("td").eq(5).css("text-align", "left");
                $(row).find("td").eq(6).css("text-align", "left");
                $(row).find("td").eq(7).css("text-align", "left");
                $(row).find("td").eq(8).css("text-align", "left");
                $(row).find("td").eq(9).css("text-align", "left");
                $(row).addClass("detail_list")
            },
            "rowCallback": function (row) {
                $(row).children().css('background-color', '#F9F3DF');
            },
            columns: [
                {'data': "tarih"},
                {'data': "vade_tarih"},
                {'data': "keside_yeri"},
                {'data': "tutar"},
                {'data': "banka_adi"},
                {'data': "sube_adi"},
                {'data': "seri_no"},
                {'data': "aciklama"},
                {'data': "ozel_kod"},
                {'data': "son_durum"}
            ],
            "paging": false,
            order: [[1, 'desc']],
            columnDefs: [
                {targets: 1, type: "date-eu"}
            ],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });
        var detay_table = $('#cek_detay_tablo').DataTable({
            scrollX: true,
            scrollY: '15vh',
            "info": false,
            createdRow: function (row, data) {
                $(row).find("td").eq(0).css("text-align", "left");
                $(row).find("td").eq(1).css("text-align", "left");
                $(row).find("td").eq(2).css("text-align", "left");
                $(row).find("td").eq(3).css("text-align", "left");
                $(row).find("td").eq(5).css("text-align", "left");
            },
            searching: false,
            "rowCallback": function (row) {
                $(row).children().css('background-color', '#F9F3DF');
            },
            columns: [
                {'data': "tarih"},
                {'data': "bordro_no"},
                {'data': "cari_adi"},
                {'data': "banka_adi"},
                {'data': "tutar"},
                {'data': "doviz_turu"},
                {'data': "doviz_kuru"},
                {'data': "doviz_tutar"},
                {'data': "durum"}
            ],
            "paging": false,
            order: [[0, 'asc']],
            columnDefs: [
                {targets: 0, type: "date-eu"}
            ],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });
        $.get("controller/cek_senet_controller/sql.php?islem=odenecek_cek_ve_senetler", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                $(".toplam_tot").html(json[0]["odenmemis_tutar"]);
                table.rows.add(json).draw(false);
            }
        });

        $("body").off("click", "#odenecek_cek_ve_senet_filtrele").on("click", "#odenecek_cek_ve_senet_filtrele", function () {
            let bas_tarih = $("#bas_tarih").val();
            let bit_tarih = $("#bit_tarih").val();
            let cari_adi = $("#cari_adi").val();

            $.get("controller/cek_senet_controller/sql.php?islem=odenecek_cek_ve_senetler", {
                bas_tarih: bas_tarih,
                bit_tarih: bit_tarih,
                cari_adi: cari_adi
            }, function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.clear().draw(false);
                    $(".toplam_tot").html(json[0]["toplam_tutar"]);
                    table.rows.add(json).draw(false);
                }else {
                    table.clear().draw(false);
                }
            });
        });

        $("body").off("click", ".detail_list").on("click", ".detail_list", function () {
            $(".gosterilecek_tablo").css("display", "block");
            let id = $(this).attr("data-id");
            let geldigi_yer = $(this).attr("came_from"); // 1 ise borç karşılığı 0 ise bizim
            if (geldigi_yer == 1) {
                $.get("controller/cek_senet_controller/sql.php?islem=ciro_verdigimiz_cek_detayi_sql", {id: id}, function (res) {
                    if (res != 2) {
                        detay_table.clear().draw(false);
                        var json = JSON.parse(res);
                        detay_table.rows.add(json).draw(false);
                    } else {
                        detay_table.clear().draw(false);
                    }
                })
            } else if (geldigi_yer == 0) {
                $.get("controller/cek_senet_controller/sql.php?islem=bizim_verdigimiz_cek_detayi_sql", {id: id}, function (res) {
                    if (res != 2) {
                        detay_table.clear().draw(false);
                        var json = JSON.parse(res);
                        detay_table.rows.add(json).draw(false);
                    } else {
                        detay_table.clear().draw(false);
                    }
                })
            }
        });
    });


</script>