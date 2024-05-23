<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>MARKA TANIMLA</div>
    </div>
    <div class="col-12 row">
        <div class="marka_buttons mt-3 mx-3">
            <button class="btn btn-success btn-sm" id="marka_ekle_main_button"><i class="fa fa-plus-square"
                                                                                  aria-hidden="true"></i> Marka Ekle
            </button>
            <button class="btn  btn-sm" id="marka_guncelle_main" style="background-color: #F6FA70"><i class="fa fa-refresh"
                                                                               aria-hidden="true"></i> Marka
                Güncelle
            </button>
            <button class="btn btn-danger btn-sm" id="marka_sil"><i class="fa fa-trash" aria-hidden="true"></i>
                Marka Sil
            </button>
        </div>
        <div class="col-12 row mx-1 mt-3">
            <table class="table table-sm table-bordered w-100  nowrap" id="marka_listesi_table"
                   style="font-size: 13px;">
                <thead>
                <tr>
                    <th>Marka Adı</th>
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

    $("body").off("click", "#marka_ekle_main_button").on("click", "#marka_ekle_main_button", function () {
        $.get("modals/marka_modal/modal.php?islem=marka_ekle_modal_getir", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        });
    });

    $("body").off("click", "#marka_guncelle_main").on("click", "#marka_guncelle_main", function () {
        var id = $(".select").attr("data-id");
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Markayı Seçiniz',
                'warning'
            );
        } else {
            $.get("modals/marka_modal/modal_page.php?islem=marka_guncelle_modal",{id:id}, function (getModal) {
                $(".getModals").html("");
                $(".getModals").html(getModal);
            });
        }
    });

    $("body").off("click", "#marka_sil").on("click", "#marka_sil", function () {
        var id = $(".select").attr("data-id");
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Markayı Seçiniz',
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
                        url: "controller/marka_controller/sql.php?islem=marka_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Marka Silindi',
                                    'success'
                                );
                                $.get("view/marka_listesi.php", function (getList) {
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

    $("body").off("click", ".marka_selected").on("click", ".marka_selected", function () {
        $('.marka_selected').css("background-color", "rgb(255, 255, 255)");
        $(this).css("background-color", "#60b3abad");
        $('.marka_selected').removeClass('select');
        $(this).addClass("select");
        $(".select").css("background-color", "#B9EDDD");
    });

    $(document).ready(function () {
        var table = $('#marka_listesi_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            createdRow: function (row,data,dataIndex) {
                $(row).addClass("marka_selected");
                $(row).find("td").css("text-align", "left")
            }
        })
        $.get("controller/marka_controller/sql.php?islem=marka_listesi_getir", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                json.forEach(function (item) {
                    var markaAdi = item.marka_adi;
                    var aciklama = item.aciklama;
                    var marka_rows = table.row.add([markaAdi.toUpperCase(), aciklama.toUpperCase()]).draw(false).node();
                    $(marka_rows).attr("data-id", item.id);
                });
            }
        });
    })
</script>