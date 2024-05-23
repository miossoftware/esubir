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
            <div class="ibox-title" style=' font-weight:bold;'>AYLIK YAKITLAR LİTRE BAZINDA</div>
        </div>
        <div class="col-12 row mt-4">
            <table class="table table-sm table-bordered nowrap" style="cursor:pointer;font-size: 13px;"
                   id="yakit_hareketleri_table">
                <thead>
                <tr>
                    <th style="width: 0% !important;">No</th>
                    <th style="width: 0% !important;">Plaka No</th>
                    <th>Ocak</th>
                    <th style="width: 0% !important;">Şubat</th>
                    <th style="width: 10% !important;">Mart</th>
                    <th>Nisan</th>
                    <th>Mayıs</th>
                    <th>Haziran</th>
                    <th>Temmuz</th>
                    <th>Haziran</th>
                    <th>Eylül</th>
                    <th>Ekim</th>
                    <th>Kasım</th>
                    <th>Aralık</th>
                </tr>
                </thead>
                <tfoot style="background-color: white">
                <tr>
                    <th></th> <!-- İstasyon için boş hücre -->
                    <th></th> <!-- İstasyon için boş hücre -->
                    <th style="text-align: right" class="ocak_toplam">0,00</th> <!-- Plaka için boş hücre -->
                    <th style="text-align: right" class="subat_toplam">0,00</th> <!-- Sürücü için boş hücre -->
                    <th style="text-align: right" class="mart_toplam">0,00</th> <!-- Miktar için boş hücre -->
                    <th style="text-align: right" class="nisan_toplam">0,00</th> <!-- Litre Fiyatı için boş hücre -->
                    <th style="text-align: right" class="mayis_toplam">0,00</th> <!-- Tutar için boş hücre -->
                    <th style="text-align: right" class="haziran_toplam">0,00</th> <!-- Alınan KM için boş hücre -->
                    <th style="text-align: right" class="temmuz_toplam">0,00</th> <!-- Son KM için boş hücre -->
                    <th style="text-align: right" class="agustos_toplam">0,00</th> <!-- Fark KM için boş hücre -->
                    <th style="text-align: right" class="eylul_toplam">0,00</th> <!-- Tüketim (%) için boş hücre -->
                    <th style="text-align: right" class="ekim_toplam">0,00</th> <!-- Açıklama için boş hücre -->
                    <th style="text-align: right" class="kasim_toplam">0,00</th> <!-- Fatura No için boş hücre -->
                    <th style="text-align: right" class="aralik_toplam">0,00</th> <!-- Fatura Tarihi için boş hücre -->
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
                {"data": "ocak"},
                {"data": "subat"},
                {"data": "mart"},
                {"data": "nisan"},
                {"data": "mayis"},
                {"data": "haziran"},
                {"data": "temmuz"},
                {"data": "agustos"},
                {"data": "eylul"},
                {"data": "ekim"},
                {"data": "kasim"},
                {"data": "aralik"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'right');
                $(row).find("td").eq(0).css("text-align", "left");

            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        });
        $.get("konteyner/controller/yakit_controller/sql.php?islem=aylik_litre_bazinda_yakitlari_getir_sql",function (res){
            if (res != 2){
                var json = JSON.parse(res);
                $(".ocak_toplam").html(json[0].ocak_toplam);
                $(".subat_toplam").html(json[0].subat_toplam);
                $(".mart_toplam").html(json[0].mart_toplam);
                $(".nisan_toplam").html(json[0].nisan_toplam);
                $(".mayis_toplam").html(json[0].mayis_toplam);
                $(".haziran_toplam").html(json[0].haziran_toplam);
                $(".temmuz_toplam").html(json[0].temmuz_toplam);
                $(".agustos_toplam").html(json[0].agustos_toplam);
                $(".eylul_toplam").html(json[0].eylul_toplam);
                $(".ekim_toplam").html(json[0].ekim_toplam);
                $(".kasim_toplam").html(json[0].kasim_toplam);
                $(".aralik_toplam").html(json[0].aralik_toplam);

                table.rows.add(json).draw(false);
            }
        })
    })

</script>