<style>
    .edit_list td {
        text-align: left;
    }

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
        <div class="ibox-title" style=' font-weight:bold;'>Aylık Tahsilat Listesi</div>
    </div>
    <div class="col-12 row mt-3">
        <table class="table table-sm table-bordered w-100 display nowrap edit_list"
               style="cursor:pointer;font-size: 13px;"
               id="cari_table">
            <thead>
            <tr>
                <th id="clicker">Cari Kodu</th>
                <th>Cari Ünvan</th>
                <th>Cari Türü</th>
                <th>Toplam Borç</th>
                <th>Toplam Alacak</th>
                <th>Bakiyesi</th>
                <th>Durum</th>
            </tr>
            </thead>
            <tfoot style="background-color: white">
            <tr>
                <th colspan="3" style="text-align: right; font-size: 14px;">TOPLAM:</th>
                <th style="text-align: right; font-size: 14px;" class="toplam_borc">0,00</th>
                <th style="text-align: right; font-size: 14px;" class="toplam_alacak">0,00</th>
                <th style="text-align: right; font-size: 14px;" class="genel_bakiye">0,00</th>
                <th style="text-align: center; font-size: 14px;" class="borc_durumu">YOK</th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
<script>


    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });

    $(document).ready(function () {
        setTimeout(function () {
            $("#clicker").trigger("click");
        }, 500);
        var table = $('#cari_table').DataTable({
            paging: false,
            scrollX: true,
            scrollY: "55vh",
            "info": false,
            columns: [
                {"data": "cari_kodu"},
                {"data": "cari_unvan"},
                {"data": "cari_grubu"},
                {"data": "borc"},
                {"data": "alacak"},
                {"data": "bakiye"},
                {"data": "b_durum"}
            ],
            createdRow: function (row,data,dataIndex) {
                $(row).find("td").eq(3).css("text-align", "right");
                $(row).find("td").eq(4).css("text-align", "right");
                $(row).find("td").eq(5).css("text-align", "right");
                $(row).find("td").eq(6).css("text-align", "center");
                
            },
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        })


        let toplam_borc = 0;
        let toplam_alacak = 0;
        let total_vadesi_gecmis = 0;
        var json = JSON.parse(<?=$_POST["data"]?>);
        let arr = [];
        json.forEach(function (item) {
            let borc = item.borc;
            borc = parseFloat(borc);
            let alacak = item.alacak;
            alacak = parseFloat(alacak)
            let vadesi_gecmis = item.vadesi_gecmis;
            vadesi_gecmis = parseFloat(vadesi_gecmis)
            total_vadesi_gecmis += vadesi_gecmis;
            let bakiye = parseFloat(borc) - parseFloat(alacak);
            if (isNaN(bakiye)) {
                bakiye = 0;
            }
            if (isNaN(borc)) {
                borc = 0;
            }
            if (isNaN(alacak)) {
                alacak = 0;
            }
            let b_durum = "";
            if (bakiye > 0) {
                b_durum = "B";
            } else if (bakiye < 0) {
                b_durum = "A";
                bakiye = -bakiye
            } else {
                b_durum = "YOK";
            }
            if (bakiye == 0) {

            } else {
                toplam_borc += borc;
                toplam_alacak += alacak;
                borc = borc.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                alacak = alacak.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                bakiye = bakiye.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                vadesi_gecmis = vadesi_gecmis.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                var newRecord = {
                    cari_kodu: item.cari_kodu,
                    cari_unvan: item.cari_unvan,
                    cari_grubu: item.cari_grubu,
                    borc: borc,
                    alacak: alacak,
                    bakiye: bakiye,
                    b_durum: b_durum
                };
                arr.push(newRecord);
            }
        })
        let b_durum = "";
        let bakiye = toplam_alacak - toplam_borc;
        if (bakiye < 0) {
            bakiye = -bakiye
            b_durum = "B";
        } else {
            b_durum = "A";
        }
        if (isNaN(total_vadesi_gecmis)){
            total_vadesi_gecmis = 0;
        }
        bakiye = bakiye.toLocaleString("tr-TR", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        toplam_borc = toplam_borc.toLocaleString("tr-TR", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        toplam_alacak = toplam_alacak.toLocaleString("tr-TR", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        total_vadesi_gecmis = total_vadesi_gecmis.toLocaleString("tr-TR", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        $(".toplam_borc").html("");
        $(".toplam_borc").html(toplam_borc);
        $(".toplam_alacak").html("");
        $(".toplam_alacak").html(toplam_alacak);
        $(".genel_bakiye").html("");
        $(".genel_bakiye").html(bakiye);
        $(".borc_durumu").html("");
        $(".borc_durumu").html(b_durum);
        $(".vadesi_gecen_total").html("");
        $(".vadesi_gecen_total").html(total_vadesi_gecmis);

        table.rows.add(arr).draw(false);
    });

</script>