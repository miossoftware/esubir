<style>
    .excel_alis {
        background-color: #2ecc71 !important;
        border-color: #27ad60 !important;
        color: white !important;
        border-radius: 20px !important;
        font-weight: bold !important;
    }
</style>
<div class="ibox-container">
    <div class="ibox mt-5">
        <div class="ibox-head">
            <div class="ibox-title" style=' font-weight:bold;'>YAKIT HAREKETLERİ</div>
        </div>
        <div class="row no-gutters">
            <div class="col-md-1 mx-1">
                <input type="date" value="<?= date("Y-m-01") ?>"
                       class="form-control form-control-sm" id="bas_tarih">
            </div>
            <div class="col-md-1 mx-1">
                <input type="date" value="<?= date("Y-m-t") ?>"
                       class="form-control form-control-sm" id="bit_tarih">
            </div>
            <div class="col-md-1 mx-1">
                <select class="custom-select custom-select-sm" id="alim_yeri">
                    <option value="">Alım Yeri...</option>
                    <option value="0">Hepsi</option>
                    <option value="1">İstasyondan</option>
                    <option value="2">Depodan</option>
                </select>
            </div>
            <div class="col-1 mx-3">
                <button class="btn btn-secondary btn-sm" id="yakit_ekstre_filtrele"><i class="fa fa-filter"></i> Hazırla
                </button>
            </div>
        </div>
        <div class="col-12 row mt-4">
            <table class="table table-sm table-bordered" style="cursor:pointer;font-size: 13px;"
                   id="yakit_hareketleri_table">
                <thead>
                <tr>
                    <th style="width: 0% !important;">Araç Grubu</th>
                    <th style="width: 0% !important;">Tarih</th>
                    <th style="width: 0% !important;">Fiş No</th>
                    <th style="width: 10% !important;">İstasyon</th>
                    <th>Plaka</th>
                    <th>Sürücü</th>
                    <th>Araç Cari</th>
                    <th>Miktar</th>
                    <th>Litre Fiyat</th>
                    <th>Tutar</th>
                    <th>Alınan KM</th>
                    <th>Son Km</th>
                    <th>Fark KM</th>
                    <th>Tuketim (%)</th>
                    <th style="width: 10% !important;">Açıklama</th>
                    <th style="width: 0% !important;">Fatura No</th>
                    <th style="width: 0% !important;">Fatura Tarihi</th>
                </tr>
                </thead>
                <tfoot style="background-color: white">
                <tr>
                    <th></th> <!-- Araç Grubu için boş hücre -->
                    <th></th> <!-- Tarih için boş hücre -->
                    <th></th> <!-- Fiş No için boş hücre -->
                    <th></th> <!-- İstasyon için boş hücre -->
                    <th></th> <!-- Plaka için boş hücre -->
                    <th></th> <!-- Sürücü için boş hücre -->
                    <th><span class="miktar_total">0,00</span></th> <!-- Miktar için boş hücre -->
                    <th></th> <!-- Litre Fiyatı için boş hücre -->
                    <th><span class="toplam_tutar">0,00</span></th> <!-- Tutar için boş hücre -->
                    <th></th> <!-- Alınan KM için boş hücre -->
                    <th></th> <!-- Son KM için boş hücre -->
                    <th><span class="fark_km_toplam">0</span></th> <!-- Fark KM için boş hücre -->
                    <th></th> <!-- Tüketim (%) için boş hücre -->
                    <th></th> <!-- Açıklama için boş hücre -->
                    <th></th> <!-- Fatura No için boş hücre -->
                    <th></th> <!-- Fatura Tarihi için boş hücre -->
                </tr>
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

    $(document).ready(function () {

        jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "date-eu-pre": function (dateString) {
                var parts = dateString.split('/');
                // YYYY-MM-DD formatına dönüştürerek Date nesnesi oluştur
                return new Date(parts[2], parts[1] - 1, parts[0]);
            },

            "date-eu-asc": function (a, b) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },

            "date-eu-desc": function (a, b) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        });
        var table = $("#yakit_hareketleri_table").DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            columnDefs: [
                { targets: 1, type: "date-eu" }
            ],
            "order": [[1, 'desc']],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "YAKIT HAREKETLERİ",
                    text: "<i class='fa fa-download'></i> Excel'e Aktar",
                    className: 'excel_alis', // Sınıfı burada tanımlayabilirsiniz
                }
            ],
            columns: [
                {"data": "arac_grubu"},
                {"data": "tarih"},
                {"data": "fis_no"},
                {"data": "istasyon_adi"},
                {"data": "plaka"},
                {"data": "surucu_adi"},
                {"data": "kiralik_cari"},
                {"data": "miktar"},
                {"data": "litre_fiyati"},
                {"data": "tl_tutar"},
                {"data": "yakit_km"},
                {"data": "son_alinan_km"},
                {"data": "fark_km"},
                {"data": "tuketim_yuzde"},
                {"data": "aciklama"},
                {"data": "fatura_no"},
                {"data": "fatura_tarihi"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find("td").eq(7).css("text-align", "right");
                $(row).find("td").eq(8).css("text-align", "right");
                $(row).find("td").eq(9).css("text-align", "right");
                $(row).find("td").eq(10).css("text-align", "right");
                $(row).find("td").eq(11).css("text-align", "right");
                $(row).find("td").eq(12).css("text-align", "right");
                $(row).find("td").eq(13).css("text-align", "right");

            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        });
        $.get("controller/arac_controller/sql.php?islem=yakit_hareketlerini_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                $(".miktar_total").html(json[0].toplam_miktar);
                $(".toplam_tutar").html(json[0].toplam_tutar);
                $(".fark_km_toplam").html(json[0].fark_km_toplam);
                table.rows.add(json).draw(false);
            }
        })

        $("body").off("click", "#yakit_ekstre_filtrele").on("click", "#yakit_ekstre_filtrele", function () {
            let bas_tarih = $("#bas_tarih").val();
            let bit_tarih = $("#bit_tarih").val();
            let arac_grubu = $("#arac_grubu").val();
            let alim_yeri = $("#alim_yeri").val();
            $.get("controller/arac_controller/sql.php?islem=yakit_hareketlerini_getir_sql", {
                bas_tarih: bas_tarih,
                arac_grubu: arac_grubu,
                alim_yeri: alim_yeri,
                bit_tarih: bit_tarih
            }, function (res) {
                if (res != 2) {
                    table.clear().draw(false);
                    var json = JSON.parse(res);
                    $(".miktar_total").html(json[0].toplam_miktar);
                    $(".toplam_tutar").html(json[0].toplam_tutar);
                    $(".fark_km_toplam").html(json[0].fark_km_toplam);
                    table.rows.add(json).draw(false);
                } else {
                    table.clear().draw(false);
                    $(".miktar_total").html("0,00");
                    $(".toplam_tutar").html("0,00");
                    $(".fark_km_toplam").html(0);
                }
            })
        })
    })

</script>