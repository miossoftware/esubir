<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>STOK FİRE ÇIKIŞI</div>
    </div>
    <div class="col-12 row ">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="yeni_fire_cikisi"><i class="fa fa-plus"></i> Yeni Fire Çıkışı
            </button>
        </div>
    </div>
    <div class="col-md-12 row">
        <div class="col-md-12 row">
            <table class="table table-sm table-bordered w-100  nowrap" id="stok_table" style="font-size: 13px;">
                <thead>
                <tr>
                    <th>Stok Kodu</th>
                    <th>Stok Adı</th>
                    <th>Fire Miktar</th>
                    <th>Birim Fiyat</th>
                    <th>Fire Tutarı</th>
                    <th>Açıklama</th>
                    <th>İşlem</th>
                </tr>
                </thead>
                <tfoot style="background-color: white">
                <th></th>
                <th></th>
                <th style="text-align: right" class="fire_miktar">0,00</th>
                <th></th>
                <th style="text-align: right" class="fire_tutari">0,00</th>
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
        var table = $('#stok_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            createdRow: function (row, data, dataIndex) {
                $(row).addClass("stok_list_selected");
                $(row).find('td').eq(0).css('text-align', 'left');
                $(row).find('td').eq(1).css('text-align', 'left');
                $(row).find('td').eq(5).css('text-align', 'left');
            },
            columns: [
                {'data': 'stok_kodu'},
                {'data': 'stok_adi'},
                {'data': 'miktar'},
                {'data': 'birim_fiyat'},
                {'data': 'ara_total'},
                {'data': 'aciklama'},
                {'data': 'islem'}
            ],
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });
        $.get("controller/stok_controller/sql.php?islem=stok_fire_listesini_getir", function (result) {
            var json = JSON.parse(result);
            let basilacak_arr = [];
            let toplam_fire = 0;
            let toplam_fire_tutar = 0;
            json.forEach(function (item) {
                var miktar = item.miktar;
                miktar = parseFloat(miktar);
                toplam_fire += miktar;
                let birim_fiyat = item.birim_fiyat;
                birim_fiyat = parseFloat(birim_fiyat);
                let ara_total = birim_fiyat * miktar;
                toplam_fire_tutar += ara_total;
                miktar = miktar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})
                birim_fiyat = birim_fiyat.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                ara_total = ara_total.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                let newRow = {
                    stok_kodu: item.stok_kodu,
                    stok_adi: item.stok_adi,
                    miktar: miktar,
                    birim_fiyat: birim_fiyat,
                    ara_total: ara_total,
                    islem: "<button class='btn btn-sm stok_fire_guncelleme_button' style='background-color: #F6FA70' data-id='" + item.id + "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm stok_fire_sil_button' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>",
                    aciklama: item.aciklama
                }
                basilacak_arr.push(newRow);
            })
            $(".fire_miktar").html(toplam_fire.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
            $(".fire_tutar").html(toplam_fire_tutar.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
            table.rows.add(basilacak_arr).draw(false);
        });

    });

    $("body").off("click", ".stok_fire_sil_button").on("click", ".stok_fire_sil_button", function () {
        let id = $(this).attr("data-id");
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
                        url: "controller/stok_controller/sql.php?islem=stok_fire_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Stok Fire Başarı İle Silindi',
                                    'success'
                                );
                                $.get("view/stok_fire.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/stok_fire.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                })
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
        }
    });

    $("body").off("click", ".stok_fire_guncelleme_button").on("click", ".stok_fire_guncelleme_button", function () {
        let id = $(this).attr("data-id");
        $.get("modals/stok_modal/fire_modal.php?islem=stok_fire_guncelle", {id: id}, function (getModal) {
            $(".getModals").html(getModal);
        })
    })

    $("body").off("click", "#yeni_fire_cikisi").on("click", "#yeni_fire_cikisi", function () {
        $.get("modals/stok_modal/fire_modal.php?islem=stok_fire_ekle", function (getModal) {
            $(".getModals").html(getModal);
        })
    });
</script>