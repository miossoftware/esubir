<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>CARİ TÜRÜ TANIMLA</div>
    </div>
    <div class="col-12 row">
        <div class="banka_tanim_button mt-3 mx-3">
            <button class="btn btn-success btn-sm" id="cari_turu_ekle_modal"><i class="fa fa-plus-square"
                                                                                aria-hidden="true"></i>
                Cari Türü Tanımla
            </button>
        </div>
        <div class="col-12 row mx-1 mt-3">
            <table class="table table-sm table-bordered w-100  nowrap" id="cari_turu_list"
                   style="font-size: 13px;">
                <thead>
                <tr>
                    <th>Cari Türü Adı</th>
                    <th>İşlem</th>
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
        var table = $('#cari_turu_list').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            "paging": false,
            bAutoWidth: false,
            order: false,
            aoColumns: [
                {sWidth: '1%'},
                {sWidth: '0%'}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).addClass("banka_selected");
            },
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        })

        $.get("controller/cari_controller/sql.php?islem=cari_turleri_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                json.forEach(function (item) {
                    var new_row = table.row.add(["<input type='text' class='form-control form-control-sm col-9 cari_turu_adi_guncelle' data-id='" + item.id + "' value='" + item.cari_turu_adi + "'/>", "<button class='btn btn-danger btn-sm cari_turu_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i><button"]).draw(false).node();
                    $(new_row).find("td").eq(0).css("text-align", "left");
                });
            }
        })
    })

    $("body").off("focusout", ".cari_turu_adi_guncelle").on("focusout", ".cari_turu_adi_guncelle", function () {
        let id = $(this).attr("data-id");
        let cari_turu_adi = $(this).val();
        $.ajax({
            url: "controller/cari_controller/sql.php?islem=cari_turu_adi_degistir",
            type: "POST",
            data: {
                id: id,
                cari_turu_adi: cari_turu_adi
            },
            success:function (res){
                if (res == 1){
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'Güncelleme Başarılı'
                    });
                }
            }
        });
    });


    $("body").off("click", "#cari_turu_ekle_modal").on("click", "#cari_turu_ekle_modal", function () {
        $.get("modals/cari_modal/cari_turu_ekle_modal.php?islem=cari_turu_tanimla", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    })

    $("body").off("click", ".cari_turu_sil").on("click", ".cari_turu_sil", function () {
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
                        url: "controller/cari_controller/sql.php?islem=cari_turu_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Cari Türü Silindi',
                                    'success'
                                );
                                $.get("view/cari_turu_tanim.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/cari_turu_tanim.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                })
                            }else if (result == 300){
                                Swal.fire(
                                    'Uyarı',
                                    'Bu Cari Türünde Bir Cari Var Lütfen Önce Cariyi Siliniz...',
                                    'warning'
                                );
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