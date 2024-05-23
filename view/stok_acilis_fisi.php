<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>STOK AÇILIŞ FİŞİ</div>
    </div>
    <div class="col-2 row mx-3 mt-3">
        <button class="btn btn-success btn-sm" id="acilis_fis_modal"><i class="fa fa-plus"></i>Yeni Stok Açılış Fişi
        </button>
    </div>
    <div class="col-12 mt-3 row">
        <table class="table table-sm table-bordered w-100  nowrap" id='stok_acilis_table'
               style="font-size: 13px;">
            <thead>
            <tr>
                <th>Stok Kodu</th>
                <th>Stok Adı</th>
                <th>Birimi</th>
                <th>Miktar</th>
                <th>Alış Fiyat</th>
                <th>Toplam Tutar</th>
                <th>Depo</th>
                <th>Açıklama</th>
                <th>İşlem</th>
            </tr>
            </thead>
            <tfoot style="background-color: white">
            <th></th>
            <th></th>
            <th></th>
            <th style="text-align: right" class="stok_acilis_miktar">0,00</th>
            <th></th>
            <th style="text-align: right" class="stok_acilis_toplam_tutar">0,00</th>
            <th></th>
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
    $("body").off("click", "#acilis_fis_modal").on("click", "#acilis_fis_modal", function () {
        $.get("modals/stok_modal/stok_acilis_fisi.php?islem=yeni_stok_acilis_fisi_modal_getir", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });
    $(document).ready(function () {
        var table = $('#stok_acilis_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            createdRow: function (row, data, dataIndex) {
                $(row).addClass("stok_acilis_fisi");
                $(row).find('td').eq(0).css('text-align', 'left');
                $(row).find('td').eq(1).css('text-align', 'left');
                $(row).find('td').eq(2).css('text-align', 'left');
                $(row).find('td').eq(6).css('text-align', 'left');
                $(row).find('td').eq(7).css('text-align', 'left');
            },
            columns: [
                {'data': 'stok_kodu'},
                {'data': 'stok_adi'},
                {'data': 'birim_adi'},
                {'data': 'miktar'},
                {'data': 'alis_fiyat'},
                {'data': 'ara_total'},
                {'data': 'depo_adi'},
                {'data': 'aciklama'},
                {'data': 'islem'},
            ]
        })

        $.get("controller/stok_controller/sql.php?islem=acilis_fislerini_getir", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                let basilacak_arr = [];
                let toplam_miktar = 0;
                let toplam_tutar = 0;
                json.forEach(function (item) {
                    var miktar = item.miktar;
                    miktar = parseFloat(miktar);
                    toplam_miktar += miktar;
                    var alis_fiyat = item.alis_fiyat;
                    alis_fiyat = parseFloat(alis_fiyat);
                    let ara_total = alis_fiyat * miktar;
                    toplam_tutar += ara_total;
                    miktar = miktar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})
                    ara_total = ara_total.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})
                    alis_fiyat = alis_fiyat.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })
                    let newRow = {
                        stok_kodu: item.stok_kodu,
                        stok_adi: item.stok_adi,
                        birim_adi: item.birim_adi,
                        miktar: miktar,
                        alis_fiyat: alis_fiyat,
                        ara_total: ara_total,
                        depo_adi: item.depo_adi,
                        aciklama: item.aciklama,
                        islem: "<button class='btn btn-sm stok_acilis_fisi_guncelle_button' style='background-color: #F6FA70' data-id='" + item.id + "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm acilis_fisi_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i><button"
                    }
                    basilacak_arr.push(newRow);
                });
                $(".stok_acilis_toplam_tutar").html(toplam_tutar.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }));
                $(".stok_acilis_miktar").html(toplam_miktar.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }));
                table.rows.add(basilacak_arr).draw(false);
            }
        })
    })

    $("body").off("click", ".stok_acilis_fisi_guncelle_button").on("click", ".stok_acilis_fisi_guncelle_button", function () {
        let id = $(this).attr("data-id");
        $.get("modals/stok_modal/stok_acilis_fisi.php?islem=acilis_fisi_guncelle_modal", {id: id}, function (getModal) {
            $(".getModals").html(getModal);
        });
    });

    $("body").off("click", ".acilis_fisi_sil").on("click", ".acilis_fisi_sil", function () {
        var id = $(this).attr("data-id");
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Cariyi seçiniz',
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
                        url: "controller/stok_controller/sql.php?islem=acilis_fisi_sil_main_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Açılış Fişi Silindi',
                                    'success'
                                );
                                $.get("view/stok_acilis_fisi.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/stok_acilis_fisi.php", function (getList) {
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

</script>