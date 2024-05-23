<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>POS HESAP TANIM</div>
    </div>
    <div class="col-12 row">
        <div class="banka_tanim_button mt-3 mx-3">
            <button class="btn btn-success btn-sm" id="pos_hesap_tanimla_main_button"><i class="fa fa-plus-square"
                                                                                         aria-hidden="true"></i>
                POS Hesap Tanımla
            </button>
        </div>
        <div class="col-12 row mx-1 mt-3">
            <table class="table table-sm table-bordered w-100  nowrap" id="banka_listesi"
                   style="font-size: 13px;">
                <thead>
                <tr>
                    <th>Banka Kodu</th>
                    <th>Banka Adı</th>
                    <th>Hesap Adı</th>
                    <th>Vade Günü</th>
                    <th>Komisyon Oranı</th>
                    <th>Bakiye</th>
                    <th style="width: 0%">İşlem</th>
                </tr>
                </thead>
                <tfoot style="background-color: white">
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align: right" class="pos_bakiye">0,00</th>
                <th></th>
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
        var table = $('#banka_listesi').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            "paging": false,
            columns: [
                {"data": "banka_kodu"},
                {"data": "banka_adi"},
                {"data": "hesap_adi"},
                {"data": "vade_gunu"},
                {"data": "komisyon_orani"},
                {"data": "bakiye"},
                {"data": "button"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find("td").css("text-transform", "uppercase")
                $(row).find("td").eq(0).css("text-align", "left");
                $(row).find("td").eq(1).css("text-align", "left");
                $(row).find("td").eq(2).css("text-align", "left");
                $(row).find("td").eq(8).css("text-align", "left");
            },
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        })

        $.get("controller/pos_controller/sql.php?islem=poslari_getir_sql", function (response) {
            if (response != 2) {
                var json = JSON.parse(response);
                let basilacak_arr = [];
                let pos_bakiye = 0;
                json.forEach(function (item) {
                    let komisyon_orani = item.komisyon_orani;
                    komisyon_orani = parseFloat(komisyon_orani);
                    komisyon_orani = komisyon_orani.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let toplam_cekilen = item.toplam_cekilen;
                    toplam_cekilen = parseFloat(toplam_cekilen);
                    if (isNaN(toplam_cekilen)) {
                        toplam_cekilen = 0;
                    }

                    let toplam_cekilen2 = item.toplam_cekilen2;
                    toplam_cekilen2 = parseFloat(toplam_cekilen2);
                    if (isNaN(toplam_cekilen2)) {
                        toplam_cekilen2 = 0;
                    }
                    pos_bakiye += toplam_cekilen;
                    pos_bakiye += toplam_cekilen2;

                    let t = toplam_cekilen + toplam_cekilen2;
                    t = t.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                    let newRow = {
                        'banka_kodu': item.banka_kodu,
                        'banka_adi': item.banka_adi,
                        'hesap_adi': item.hesap_adi,
                        'vade_gunu': item.vade_gunu,
                        'komisyon_orani': komisyon_orani,
                        'bakiye': t,
                        'button': "<button class='btn btn-sm pos_hesap_guncelle_main_button' style='background-color: #F6FA70' data-id='" + item.id + "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm tanimli_pos_sil_main_button' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>",
                    };
                    basilacak_arr.push(newRow);
                });
                $(".pos_bakiye").html(pos_bakiye.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }))
                table.rows.add(basilacak_arr).draw(false);
            }
        })
    })

    $("body").off("click", ".tanimli_pos_sil_main_button").on("click", ".tanimli_pos_sil_main_button", function () {
        let id = $(this).attr("data-id");
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
                    url: "controller/pos_controller/sql.php?islem=pos_sil_main_sql",
                    type: "POST",
                    data: {
                        id: id,
                        delete_detail: delete_detail
                    },
                    success: function (result) {
                        if (result != 2) {
                            if (result == 300) {
                                Swal.fire(
                                    'Uyarı!',
                                    'POS Cihazına Ait Hareket Vardır Lütfen Önce Hareketi Siliniz',
                                    'warning'
                                );
                            } else {
                                Swal.fire(
                                    'Başarılı!',
                                    'POS Silindi',
                                    'success'
                                );
                                $.get("view/pos_hesap_tanim.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/pos_hesap_tanim.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                })
                            }
                        } else {
                            Swal.fire(
                                'Oops...',
                                'Bilinmeyen Bir Hata Oluştu',
                                'error'
                            );
                        }
                    }
                });
            }
        });
    });

    $("body").off("click", "#pos_hesap_tanimla_main_button").on("click", "#pos_hesap_tanimla_main_button", function () {
        $.get("modals/pos_modal/modal.php?islem=pos_hesap_tanimla_modal_getir", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".pos_hesap_guncelle_main_button").on("click", ".pos_hesap_guncelle_main_button", function () {
        let id = $(this).attr("data-id");
        $.get("modals/pos_modal/modal_page.php?islem=guncelle_modal_getir", {id: id}, function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        });
    })

</script>