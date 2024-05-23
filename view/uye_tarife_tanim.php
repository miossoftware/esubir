<style>
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
        <div class="ibox-title" style=' font-weight:bold;'>TARİFE TANIMLA</div>
    </div>
    <div class="col-12 row">
        <div class="tarife_buttons mt-3 mx-3">
            <button class="btn btn-success btn-sm" id="tarife_ekle_modal_button"><i class="fa fa-plus-square"
                                                                                    aria-hidden="true"></i> Tarife
                Tanımla
            </button>
            <button class="btn  btn-sm" id="tarife_guncelle_main" style="background-color: #F6FA70"><i
                        class="fa fa-refresh"
                        aria-hidden="true"></i> Tarife
                Güncelle
            </button>
            <button class="btn btn-danger btn-sm" id="tarife_tanim_sil"><i class="fa fa-trash"
                                                                           aria-hidden="true"></i> Tarife Sil
            </button>
        </div>
        <div class="col-12 row mx-1 mt-3">
            <table class="table table-sm table-bordered w-100  nowrap" id="tarife_listesi"
                   style="font-size: 13px;">
                <thead>
                <tr>
                    <th style="width: 1% !important;">Tarife Kodu</th>
                    <th>Tarife Adı</th>
                    <th>Açıklama</th>
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

    $("body").off("click", "#tarife_guncelle_main").on("click", "#tarife_guncelle_main", function () {
        var tarife_kodu = $(".select").find("td").eq(0).text();
        if (tarife_kodu == "" || tarife_kodu == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Kaydı seçiniz',
                'warning'
            );
        } else {
            $.get("modals/uye_modal/tarife_tanim.php?islem=tarife_guncelle", {id: tarife_kodu}, function (getModal) {
                $(".getModals").html("");
                $(".getModals").html(getModal);
            })
        }
    });

    $("body").off("click", "#tarife_tanim_sil").on("click", "#tarife_tanim_sil", function () {
        var tarife_kodu = $(".select").find("td").eq(0).text();
        if (tarife_kodu == "" || tarife_kodu == undefined) {
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
                        url: "controller/uye_controller/sql.php?islem=tarife_sil",
                        type: "POST",
                        data: {
                            tarife_kodu: tarife_kodu,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı!',
                                    'tarife Silindi',
                                    'success'
                                );
                                $.get("view/uye_tarife_tanim.php", function (getList) {
                                    $(".modal-icerik").html(getList);
                                });
                                $.get("view/uye_tarife_tanim.php", function (getList) {
                                    $(".admin-modal-icerik").html(getList);
                                });
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

    $("body").off("click", ".tarife_selected").on("click", ".tarife_selected", function () {
        $('.tarife_selected').css("background-color", "rgb(255, 255, 255)");
        $(this).css("background-color", "#60b3abad");
        $('.tarife_selected').removeClass('select');
        $(this).addClass("select");
        $(".select").css("background-color", "#B9EDDD");
    });


    $(document).ready(function () {
        var table = $('#tarife_listesi').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "paging": false,
            order: false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            createdRow: function (row, data, dataIndex) {
                $(row).addClass("tarife_selected");
                $(row).find("td").css("text-align", "left");

            }
        });
        $.get("controller/uye_controller/sql.php?islem=tarifeleri_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                json.forEach(function (item) {
                    table.row.add([item.tarife_kodu, item.tarife_adi, item.aciklama]).draw(false);
                })
            }
        })
    });

    $("body").off("click", "#tarife_ekle_modal_button").on("click", "#tarife_ekle_modal_button", function () {
        $.get("modals/uye_modal/tarife_tanim.php?islem=tarife_tanimla_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

</script>