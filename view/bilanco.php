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
        <div class="ibox-title" style=' font-weight:bold;'>BİLANÇO TANIMLA</div>
    </div>
    <div class="col-12 row">
        <div class="bilanco_buttons mt-3 mx-3">
            <button class="btn btn-success btn-sm" id="bilanco_ekle_modal_button"><i class="fa fa-plus-square"
                                                                                     aria-hidden="true"></i> Bilanço
                Tanımla
            </button>
            <button class="btn  btn-sm" id="bilanco_guncelle_main" style="background-color: #F6FA70"><i
                        class="fa fa-refresh"
                        aria-hidden="true"></i> Bilanço
                Güncelle
            </button>
            <button class="btn btn-danger btn-sm" id="bilanco_tanim_sil"><i class="fa fa-trash"
                                                                            aria-hidden="true"></i> Bilanço Sil
            </button>
        </div>
        <div class="col-12 row mx-1 mt-3">
            <table class="table table-sm table-bordered w-100  nowrap" id="bilanco_listesi"
                   style="font-size: 13px;">
                <thead>
                <tr>
                    <th style="width: 1% !important;">Bilanço Kodu</th>
                    <th>Bilanço</th>
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

    $("body").off("click", "#bilanco_guncelle_main").on("click", "#bilanco_guncelle_main", function () {
        var id = $(".select").attr("data-id");
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Kaydı seçiniz',
                'warning'
            );
        } else {
            $.get("modals/bilanco_modal/modal_page.php?islem=bilanco_guncelle", {id: id}, function (getModal) {
                $(".getModals").html("");
                $(".getModals").html(getModal);
            })
        }
    });

    $("body").off("click", "#bilanco_tanim_sil").on("click", "#bilanco_tanim_sil", function () {
        var id = $(".select").attr("data-id");
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
                        url: "controller/bilanco_controller/sql.php?islem=bilanco_sil",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Bilanco Silindi',
                                    'success'
                                );
                                $.get("view/bilanco.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
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

    $("body").off("click", ".bilanco_selected").on("click", ".bilanco_selected", function () {
        $('.bilanco_selected').css("background-color", "rgb(255, 255, 255)");
        $(this).css("background-color", "#60b3abad");
        $('.bilanco_selected').removeClass('select');
        $(this).addClass("select");
        $(".select").css("background-color", "#B9EDDD");
    });


    $(document).ready(function () {
        var table = $('#bilanco_listesi').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            dom: "Bfrtip",
            buttons: [
                {
                    extend: 'excel',
                    title: "Bilançolar",
                    text: "<i class='fa fa-download'></i> Excel'e Aktar",
                    className: 'excel_alis', // Sınıfı burada tanımlayabilirsiniz
                }
            ],
            "paging": false,
            order: false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            createdRow: function (row, data, dataIndex) {
                $(row).addClass("bilanco_selected");
                $(row).find("td").css("text-align", "left");

            }
        });
        $.get("controller/bilanco_controller/sql.php?islem=bilancolari_getir", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                json.forEach(function (item) {
                    var bilancoAdi = item.bilanco_adi;
                    var aciklama = item.aciklama;
                    var bilanco_rows = table.row.add([item.bilanco_kodu, bilancoAdi, aciklama]).draw(false).node();

                    $(bilanco_rows).attr("data-id", item.id);
                    $(bilanco_rows).find("td").eq(0).css("text-align", "left");
                    $(bilanco_rows).find("td").eq(1).css("text-align", "left");
                })
            }
        })
    });

    $("body").off("click", "#bilanco_ekle_modal_button").on("click", "#bilanco_ekle_modal_button", function () {
        $.get("modals/bilanco_modal/modal.php?islem=bilanco_tanimla", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

</script>