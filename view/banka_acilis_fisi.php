<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>BANKA AÇILIŞ FİŞİ</div>
    </div>
    <div class="col-12 row mt-3">
        <div class="col-md-2">
            <button class="btn btn-success btn-sm" id="banka_acilis_ekle_main"><i class="fa fa-plus"></i> Banka
                Açılış Ekle
            </button>
        </div>
    </div>
    <div class="col-12 row">
        <table class="table table-sm table-bordered w-100  nowrap" style="cursor:pointer;font-size: 13px;"
               id="banka_acilis_table">
            <thead>
            <tr>
                <th>Banka Adı</th>
                <th>Banka Kodu</th>
                <th>Yatan Tutar</th>
                <th>Çekilen Tutar</th>
                <th>Açıklama</th>
                <th>İşlem</th>
            </tr>
            </thead>
            <tfoot style="background-color: white">
            <th></th>
            <th></th>
            <th style="text-align: right" class="ba_yatan">0,00</th>
            <th style="text-align: right" class="ba_cekilen">0,00</th>
            <th></th>
            <th></th>
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
        var table = $('#banka_acilis_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            createdRow: function (row, data, dataIndex) {
                $(row).addClass("stok_list_selected");
                if (dataIndex % 2 === 0) {
                    $(row).find("td").css("background-color", "#5CD2E6");
                } else {
                    $(row).find("td").css("background-color", "#3085C3");
                    $(row).find("td").css("color", "white");
                }
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });
        $.get("controller/banka_controller/sql.php?islem=kayitli_banka_acilislari_getir", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                let ba_cekilen = 0;
                let ba_yatan = 0;
                json.forEach(function (item) {
                    var yatan_tutar = item.yatan_tutar;
                    yatan_tutar = parseFloat(yatan_tutar);
                    ba_yatan += yatan_tutar;
                    yatan_tutar = yatan_tutar.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    var cekilen_tutar = item.cekilen_tutar;
                    cekilen_tutar = parseFloat(cekilen_tutar);
                    ba_cekilen += cekilen_tutar;
                    cekilen_tutar = cekilen_tutar.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    $(".ba_yatan").html(ba_yatan.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }))
                    $(".ba_cekilen").html(ba_cekilen.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }))
                    var new_row = table.row.add([item.banka_adi, item.banka_kodu, yatan_tutar, cekilen_tutar, item.aciklama, "<button class='btn btn-sm banka_acilis_fisi_guncelle_button' style='background-color: #F6FA70' data-id='" + item.id + "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm banka_acilis_sil_main' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                    $(new_row).find('td').eq(0).css('text-align', 'left');
                    $(new_row).find('td').eq(1).css('text-align', 'left');
                    $(new_row).find('td').eq(4).css('text-align', 'left');
                });
            }
        })
    })

    $("body").off("click", ".banka_acilis_fisi_guncelle_button").on("click", ".banka_acilis_fisi_guncelle_button", function () {
        let id = $(this).attr("data-id");
        $.get("modals/banka_modal/acilis_fisi_modal.php?islem=acilis_fisi_guncelle_modal", {id: id}, function (getModal) {
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".banka_acilis_sil_main").on("click", ".banka_acilis_sil_main", function () {
        var id = $(this).attr("data-id");
        var arr = [];
        arr.push(id);
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Kaydı seçiniz',
                'warning'
            );
        } else {
            Swal.fire({
                title: 'Silme Nedeni Giriniz',
                input: 'text',
                inputPlaceholder: 'Silme Nedeni',
                showCancelButton: true,
                confirmButtonText: 'Tamam',
                cancelButtonText: 'İptal',
                allowOutsideClick: false,
                inputValidator: (value) => {
                    if (!value) {
                        return 'Silme Nedeni Boş Bırakılamaz';
                    }
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    const delete_detail = result.value;
                    $.ajax({
                        url: "controller/banka_controller/sql.php?islem=secilen_acilislari_sil_sql",
                        type: "POST",
                        data: {
                            id: arr,
                            delete_detail: delete_detail
                        },
                        success: function () {
                            Swal.fire(
                                'Başarılı!',
                                'Açılış Fişi Silindi',
                                'success'
                            );
                            $.get("view/banka_acilis_fisi.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                            $.get("view/banka_acilis_fisi.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                        }
                    })
                }
            });
        }

    });

    $("body").off("click", "#banka_acilis_ekle_main").on("click", "#banka_acilis_ekle_main", function () {
        $.get("modals/banka_modal/acilis_fisi_modal.php?islem=yeni_acilis_fisi_ekle", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

</script>