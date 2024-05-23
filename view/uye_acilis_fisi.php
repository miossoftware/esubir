<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>ÜYE AÇILIŞ</div>
    </div>
    <div class="col-12 row mt-3">
        <div class="col-3">
            <button class="btn btn-success btn-sm" id="uye_acilis_fisi_ekle_button"><i class="fa fa-plus"></i> Yeni Üye
                Açılış
            </button>
        </div>
    </div>
    <div class="col-12 row">
        <table class="table table-sm table-bordered w-100  nowrap" id="uye_acilis_table" style="font-size: 13px;">
            <thead>
            <tr>
                <th>TC NO</th>
                <th>Üye Adı</th>
                <th>Tarih</th>
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
        var table = $('#uye_acilis_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            columns: [
                {'data': 'tc_no'},
                {'data': 'uye_adi'},
                {'data': 'tarih'},
                {'data': 'borc'},
                {'data': 'alacak'},
                {'data': 'islem'},
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).addClass("stok_list_selected");
                $(row).find("td").eq(0).css("text-align", "left");
                $(row).find("td").eq(1).css("text-align", "left");
                $(row).find("td").eq(2).css("text-align", "left");
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        $.get("controller/uye_controller/sql.php?islem=acilis_fislerini_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                $(".acilis_borc").html(json[0]["toplam_borc"])
                $(".acilis_alacak").html(json[0]["toplam_alacak"])
                table.rows.add(json).draw(false);
            }
        })
    });

    $("body").off("click", ".uye_acilis_guncelle_button").on("click", ".uye_acilis_guncelle_button", function () {
        let id = $(this).attr("data-id");
        $.get("modals/uye_modal/uye_acilis_modal.php?islem=uye_acilis_guncelle_modal", {id: id}, function (getModal) {
            $(".getModals").html(getModal);
        });
    });

    $("body").off("click", "#uye_acilis_fisi_ekle_button").on("click", "#uye_acilis_fisi_ekle_button", function () {
        $.get("modals/uye_modal/uye_acilis_modal.php?islem=uye_acilis_fisi_ekle_modal", function (getModal) {
            $(".getModals").html(getModal);
        });
    });

    $("body").off("click", ".acilis_fisi_sil_sql").on("click", ".acilis_fisi_sil_sql", function () {
        var id = $(this).attr("data-id");
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz uyeyi seçiniz',
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
                        url: "controller/uye_controller/sql.php?islem=acilis_fisi_sil_main_sql",
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
                                $.get("view/uye_acilis_fisi.php", function (getList) {
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/uye_acilis_fisi.php", function (getList) {
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