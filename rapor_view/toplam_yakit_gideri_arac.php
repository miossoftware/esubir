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
            <div class="ibox-title" style=' font-weight:bold;'>TOPLAM YAKIT GİDERLERİ</div>
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
            <div class="col-1 mx-3">
                <button class="btn btn-secondary btn-sm" id="toplam_yakit_giderleri_button"><i class="fa fa-filter"></i>
                    Hazırla
                </button>
            </div>
        </div>
        <div class="col-12 row mt-4">
            <table class="table table-sm table-bordered nowrap" style="cursor:pointer;font-size: 13px;"
                   id="yakit_hareketleri_table">
                <thead>
                <tr>
                    <th style="width: 0% !important;">No</th>
                    <th style="width: 0% !important;">Plaka No</th>
                    <th>Bölge</th>
                    <th>Araç Tipi</th>
                    <th>Marka</th>
                    <th>İlk KM</th>
                    <th>Son KM</th>
                    <th>Fark KM</th>
                    <th>Yakıt Tüketim (&)</th>
                    <th>Yakıt Miktarı</th>
                    <th>Yakıt Tutarı</th>
                </tr>
                </thead>
                <tfoot style="background-color: white">
                <tr>
                    <th></th> <!-- İstasyon için boş hücre -->
                    <th></th> <!-- İstasyon için boş hücre -->
                    <th></th> <!-- İstasyon için boş hücre -->
                    <th></th> <!-- İstasyon için boş hücre -->
                    <th></th> <!-- İstasyon için boş hücre -->
                    <th></th> <!-- İstasyon için boş hücre -->
                    <th></th> <!-- İstasyon için boş hücre -->
                    <th style="text-align: right" class="fark_km_toplam">0,00</th> <!-- Plaka için boş hücre -->
                    <th style="text-align: right" class="sirket_yakit_tuketim">0,00</th> <!-- Sürücü için boş hücre -->
                    <th style="text-align: right" class="miktar_toplam">0,00</th> <!-- Miktar için boş hücre -->
                    <th style="text-align: right" class="yakit_toplam">0,00</th> <!-- Miktar için boş hücre -->
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
        var table = $("#yakit_hareketleri_table").DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            "order": [[0, 'asc']],
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
                {"data": "no"},
                {"data": "plaka_no"},
                {"data": "bolge"},
                {"data": "arac_tipi"},
                {"data": "marka"},
                {"data": "ilk_yakit_km"},
                {"data": "son_yakit_km"},
                {"data": "fark_km"},
                {"data": "yakit_tuketim"},
                {"data": "yakit_miktar"},
                {"data": "yakit_tutar"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'right');
                $(row).find("td").eq(0).css("text-align", "left");
                $(row).find("td").eq(1).css("text-align", "left");
                $(row).find("td").eq(2).css("text-align", "left");
                $(row).find("td").eq(3).css("text-align", "left");
                $(row).find("td").eq(4).css("text-align", "left");
                $(row).find("td").eq(5).css("text-align", "left");

            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        });
        $.get("konteyner/controller/yakit_controller/sql.php?islem=aylik_arac_bazinda_toplam_hareketler", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                $(".fark_km_toplam").html(json[0].fark_km_toplam);
                $(".miktar_toplam").html(json[0].yakit_miktar_topkam);
                $(".yakit_toplam").html(json[0].yakit_tutar_toplam);
                $(".sirket_yakit_tuketim").html(json[0].sirkte_yakit_tuketim);

                table.rows.add(json).draw(false);
            }
        })
        $("body").off("click", "#toplam_yakit_giderleri_button").on("click", "#toplam_yakit_giderleri_button", function () {
            let bas_tarih = $("#bas_tarih").val();
            let bit_tarih = $("#bit_tarih").val();
            $.get("konteyner/controller/yakit_controller/sql.php?islem=aylik_arac_bazinda_toplam_hareketler", {
                bas_tarih: bas_tarih,
                bit_tarih: bit_tarih
            }, function (res) {
                if (res != 2) {
                    table.clear().draw(false);
                    var json = JSON.parse(res);
                    $(".fark_km_toplam").html(json[0].fark_km_toplam);
                    $(".miktar_toplam").html(json[0].yakit_miktar_topkam);
                    $(".yakit_toplam").html(json[0].yakit_tutar_toplam);
                    $(".sirket_yakit_tuketim").html(json[0].sirkte_yakit_tuketim);

                    table.rows.add(json).draw(false);
                }else {
                    table.clear().draw(false);
                }
            })
        })
    })

</script>