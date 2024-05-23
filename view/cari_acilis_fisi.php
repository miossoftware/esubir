<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>CARİ AÇILIŞ</div>
    </div>
    <div class="col-12 row mt-3">
        <div class="col-3">
            <button class="btn btn-success btn-sm" id="yeni_cari_acilis_fisi_ekle"><i class="fa fa-plus"></i> Yeni Cari
                Açılış Fişi
            </button>
        </div>
    </div>
    <div class="col-12 row">
        <table class="table table-sm table-bordered w-100  nowrap" id="cari_acilis_table" style="font-size: 13px;">
            <thead>
            <tr>
                <th>Cari Kodu</th>
                <th>Cari Adı</th>
                <th>Açıklama</th>
                <th>Borç</th>
                <th>Alacak</th>
                <th>İşlem</th>
            </tr>
            </thead>
            <tfoot style="background-color: white">
            <th></th>
            <th></th>
            <th></th>
            <th style="text-align: right" class="acilis_borc">0,00</th>
            <th style="text-align: right" class="acilis_alacak">0,00</th>
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
        var table = $('#cari_acilis_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            bAutoWidth: false,
            aoColumns: [
                {sWidth: '3%'},
                {sWidth: '10%'},
                {sWidth: '10%'},
                {sWidth: '1%'},
                {sWidth: '1%'},
                {sWidth: '1%'}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).addClass("stok_list_selected");
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });
        $.get("controller/cari_controller/sql.php?islem=tum_acilis_fislerini_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                let toplam_borc = 0;
                let toplam_alacak = 0;
                json.forEach(function (item) {
                    var borc = item.borc;
                    borc = parseFloat(borc);
                    toplam_borc += borc;
                    borc = borc.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})
                    var alacak = item.alacak;
                    alacak = parseFloat(alacak);
                    toplam_alacak += alacak;
                    alacak = alacak.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                    $(".acilis_borc").html(toplam_borc.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                    $(".acilis_alacak").html(toplam_alacak.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                    var cari_acilis = table.row.add([item.cari_kodu, item.cari_adi, item.aciklama, borc + " TL", alacak + " TL", "<button class='btn btn-sm cari_acilis_guncelle_button' data-id='" + item.id + "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm acilis_cari_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                    $(cari_acilis).find('td').eq(0).css('text-align', 'left');
                    $(cari_acilis).find('td').eq(1).css('text-align', 'left');
                    $(cari_acilis).find('td').eq(2).css('text-align', 'left');
                })
            }
        })
    });

    $("body").off("click", ".cari_acilis_guncelle_button").on("click", ".cari_acilis_guncelle_button", function () {
        let id = $(this).attr("data-id");
        $.get("modals/cari_modal/cari_acilis_modal.php?islem=cari_acilis_guncelle_modal", {id: id}, function (getModal) {
            $(".getModals").html(getModal);
        });
    });

    $("body").off("click", "#yeni_cari_acilis_fisi_ekle").on("click", "#yeni_cari_acilis_fisi_ekle", function () {
        $.get("modals/cari_modal/cari_acilis_modal.php?islem=yeni_cari_acilis_fisi_ekle", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".acilis_cari_sil").on("click", ".acilis_cari_sil", function () {
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
                        url: "controller/cari_controller/sql.php?islem=acilis_fisi_sil_main_sql",
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
                                $.get("view/cari_acilis_fisi.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/cari_acilis_fisi.php", function (getList) {
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
    })

</script>