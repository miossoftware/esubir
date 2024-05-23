<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>ÇEK STOK TANIM</div>
    </div>
    <div class="col-12 row">
        <div class="banka_tanim_button mt-3 mx-3">
            <button class="btn btn-success btn-sm" id="cek_giris_tanim"><i class="fa fa-plus-square"
                                                                           aria-hidden="true"></i>
                Çek Girişi Ekle
            </button>
            <button class="btn btn-danger btn-sm" id="cek_iptal_giris_buton"><i class="fa fa-close"
                                                                           aria-hidden="true"></i>
                Çek İptal Et
            </button>
        </div>
        <div class="col-12 row mx-1 mt-3">
            <table class="table table-sm table-bordered w-100  nowrap" id="banka_listesi"
                   style="font-size: 13px;">
                <thead>
                <tr>
                    <th>Tarih</th>
                    <th>Banka Adı</th>
                    <th>Koçan İçerisindeki Adet</th>
                    <th>Kullanılan Çek</th>
                    <th>Kalan Çek</th>
                    <th>İptal Edilen Çek</th>
                    <th style="width: 0%">İşlem</th>
                </tr>
                </thead>
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
        var table = $('#banka_listesi').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            "paging": false,
            columns: [
                {"data": "geldigi_tarih"},
                {"data": "banka_adi"},
                {"data": "yaprak_sayisi"},
                {"data": "kullanilan_cek"},
                {"data": "kalan_cek"},
                {"data": "iptal_miktari"},
                {"data": "button"}
            ],
            createdRow: function (row,data,dataIndex) {
                $(row).find("td").css("text-transform", "uppercase")
                $(row).find("td").eq(0).css("text-align", "left");
                $(row).find("td").eq(1).css("text-align", "left");
                
            },
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        })

        $.get("controller/cek_senet_controller/sql.php?islem=tanimli_cekleri_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                var basilacak_arr = [];
                json.forEach(function (item) {
                    let tarih = item.geldigi_tarih;
                    tarih = tarih.split(" ");
                    tarih = tarih[0];
                    tarih = tarih.split("-");
                    let gun = tarih[2];
                    let ay = tarih[1];
                    let yil = tarih[0];
                    let arr = [gun, ay, yil];
                    tarih = arr.join("/");

                    let kalan_cek = parseInt(item.yaprak_sayisi) - (parseInt(item.tanimlanandaki_kullanilan) + parseInt(item.iptal_miktari));
                    let yaprak_sayisi = item.yaprak_sayisi;
                    yaprak_sayisi = parseInt(yaprak_sayisi);
                    yaprak_sayisi = yaprak_sayisi.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    let kullanilan_miktar = item.tanimlanandaki_kullanilan;
                    kullanilan_miktar = parseInt(kullanilan_miktar);
                    kullanilan_miktar = kullanilan_miktar.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    let iptal_miktari = item.iptal_miktari;
                    iptal_miktari = parseInt(iptal_miktari);
                    iptal_miktari = iptal_miktari.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    kalan_cek = kalan_cek.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    let newRow = {
                        "geldigi_tarih": tarih,
                        "banka_adi": item.banka_adi,
                        "yaprak_sayisi": yaprak_sayisi,
                        "kullanilan_cek": kullanilan_miktar,
                        "kalan_cek": kalan_cek,
                        "iptal_miktari": iptal_miktari,
                        'button': "<button class='btn btn-danger btn-sm tanimlanan_ceki_sil_button' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                    };
                    basilacak_arr.push(newRow);
                })
                table.rows.add(basilacak_arr).draw(false);
            }
        })
    })

    $("body").off("click","#cek_iptal_giris_buton").on("click","#cek_iptal_giris_buton",function (){
        $.get("modals/cek_senet_modal/cek_stok_iptal_tanim.php?islem=cek_iptal_et_modal",function (getModal){
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", "#cek_giris_tanim").on("click", "#cek_giris_tanim", function () {
        $.get("modals/cek_senet_modal/cek_stok_tanim.php?islem=yeni_cek_girisi_tanimla_main", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

</script>