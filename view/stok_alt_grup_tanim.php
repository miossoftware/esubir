<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>STOK ALT GRUP TANIMLA</div>
    </div>
    <div class="col-12 row">
        <div class="alt_grup_buttons mt-3 mx-3">
            <button class="btn btn-success btn-sm" id="alt_grup_ekle_main"><i class="fa fa-plus-square"
                                                                              aria-hidden="true"></i> Alt Grup Ekle
            </button>
            <button class="btn  btn-sm" id="alt_grup_guncelle" style="background-color: #F6FA70"><i
                        class="fa fa-refresh" aria-hidden="true"></i> Alt Grup Güncelle
            </button>
            <button class="btn btn-danger btn-sm" id="alt_grup_sil"><i class="fa fa-trash" aria-hidden="true"></i> Alt
                Grup Sil
            </button>
        </div>
        <div class="col-12 row mx-1 mt-3">
            <table class="table table-sm table-bordered w-100  nowrap" id="alt_grup_listesi"
                   style="font-size: 13px;">
                <thead>
                <tr>
                    <th>Stok Ana Grup Adı</th>
                    <th>Stok Alt Grup Adı</th>
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


    $("body").off("click", "#alt_grup_guncelle").on("click", "#alt_grup_guncelle", function () {
        var id = $(".select").attr("data-id");
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Kaydı seçiniz',
                'warning'
            );
        } else {
            $.get("modals/altgrup_modal/modal_page.php?islem=alt_grup_guncelle_modal", {id: id}, function (getModal) {
                $(".getModals").html("");
                $(".getModals").html(getModal);
            })
        }
    });

    $("body").off("click", "#alt_grup_sil").on("click", "#alt_grup_sil", function () {
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
                        url: "controller/altgrup_controller/sql.php?islem=alt_grup_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Kayıt Silindi',
                                    'success'
                                );
                                $.get("view/stok_alt_grup_tanim.php", function (getList) {
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

    $("body").off("click", ".alt_grup_selected").on("click", ".alt_grup_selected", function () {
        $('.alt_grup_selected').css("background-color", "rgb(255, 255, 255)");
        $(this).css("background-color", "#60b3abad");
        $('.alt_grup_selected').removeClass('select');
        $(this).addClass("select");
        $(".select").css("background-color", "#B9EDDD");
    });

    $(document).ready(function () {
        var table = $('#alt_grup_listesi').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            "paging": false,
            createdRow: function (row, data, dataIndex) {
                $(row).addClass("alt_grup_selected");
                $(row).find("td").css("text-align", "left");
            },
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        })
        $.get("controller/altgrup_controller/sql.php?islem=alt_grup_listesi_getir", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                json.forEach(function (item) {
                    var anaGrupID = item.ana_grupid;
                    $.get("controller/altgrup_controller/sql.php?islem=ana_grup_adi_getir_list", {id: anaGrupID}, function (result2) {
                        if (result2 != 2) {
                            var item2 = JSON.parse(result2);
                            var ad = item2.ana_grup_adi;
                            var altGrupAdi = item.altgrup_adi;
                            var aciklama = item.aciklama;
                            var alt_grup_list = table.row.add([ad.toUpperCase(), altGrupAdi.toUpperCase(), aciklama.toUpperCase()]).draw(false).node();
                            $(alt_grup_list).attr("data-id", item.id);
                        }
                    });

                });
            }
        });
    });

    $("body").off("click", "#alt_grup_ekle_main").on("click", "#alt_grup_ekle_main", function () {
        $.get("modals/altgrup_modal/modal.php", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", "#ana_grup_ekle_modal_button").on("click", "#ana_grup_ekle_modal_button", function () {
        $.get("modals/anagrup_modal/modal.php", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

</script>