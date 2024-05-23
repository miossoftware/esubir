<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>STOK EKLE</div>
    </div>
    <div class="col-12 row">
        <div class="stok_buttons mt-3 mx-3">
            <button class="btn btn-success btn-sm" id="stok_ekle_button"><i class="fa fa-plus-square"
                                                                            aria-hidden="true"></i> Stok Ekle
            </button>
            <button class="btn  btn-sm" id="stok_guncelle" style="background-color: #F6FA70"><i class="fa fa-refresh"
                                                                                                aria-hidden="true"></i>
                Stok Güncelle
            </button>
            <button class="btn btn-danger btn-sm" id="stok_sil"><i class="fa fa-trash" aria-hidden="true"></i> Stok Sil
            </button>
        </div>
        <div class="col-12 row mx-1 mt-3">
            <table class="table table-sm table-bordered w-100  nowrap" id="stok_table" style="font-size: 13px;">
                <thead>
                <tr>
                    <th>Stok Kodu</th>
                    <th>Stok Adı</th>
                    <th>Barkod</th>
                    <th>Birimi</th>
                    <th>Ana Grubu</th>
                    <th>Alt Grubu</th>
                    <th>Marka</th>
                    <th>Model</th>
                    <th>Döviz</th>
                    <th>Alış Fiyatı</th>
                    <th>Satış Fiyatı</th>
                    <th>Tevkifat Kodu</th>
                    <th>Tevkifat (%)</th>
                    <th>Renk</th>
                    <th>En</th>
                    <th>Kalınlık</th>
                    <th>Kritik Limit Min.</th>
                    <th>Boy</th>
                    <th>Özkütle</th>
                    <th>Kritik Limit Max.</th>
                    <th>KDV (%)</th>
                    <th>İndirim (%)</th>
                </tr>
                </thead>
                <tbody id="stok_listesi">
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>

    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });

    $("body").off("click", "#stok_guncelle").on("click", "#stok_guncelle", function () {
        var stok_kodu = $(".selected").find("td").first().html();
        if (stok_kodu == "" || stok_kodu == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Kaydı seçiniz',
                'warning'
            );
        } else {
            $.get("modals/stok_modal/modal_page.php?islem=stok_guncelle_modal", {stok_kodu: stok_kodu}, function (getModal) {
                $(".getModals").html("");
                $(".getModals").html(getModal);
            })
        }
    });

    $(document).ready(function () {
        var table = $('#stok_table').DataTable({
            scrollY: "55vh",
            scrollX: true,
            paging:false,
            columns: [
                {"data": "stok_kodu"},
                {"data": "stok_adi"},
                {"data": "barkod"},
                {"data": "birim_adi"},
                {"data": "ana_grup_adi"},
                {"data": "altgrup_adi"},
                {"data": "marka_adi"},
                {"data": "model_adi"},
                {"data": "doviz_tur"},
                {"data": "alis_fiyat"},
                {"data": "satis_fiyat"},
                {"data": "tevkifat_kodu"},
                {"data": "tevkifat_yuzde"},
                {"data": "renk"},
                {"data": "en"},
                {"data": "kalinlik"},
                {"data": "kritik_limit_min"},
                {"data": "boy"},
                {"data": "oz_kutle"},
                {"data": "kritik_limit_max"},
                {"data": "kdv_orani"},
                {"data": "indirim"},
            ],
            createdRow: function (row,data,dataIndex) {
                $(row).addClass("stok_list_selected");
                $(row).find("td").eq(0).css("text-align", "left");
                $(row).find("td").eq(1).css("text-align", "left");
                $(row).find("td").eq(2).css("text-align", "left");
                $(row).find("td").eq(3).css("text-align", "left");
                $(row).find("td").eq(4).css("text-align", "left");
                $(row).find("td").eq(5).css("text-align", "left");
                $(row).find("td").eq(6).css("text-align", "left");
                $(row).find("td").eq(7).css("text-align", "left");
                $(row).find("td").eq(8).css("text-align", "left");
                $(row).find("td").eq(11).css("text-align", "left");
                $(row).find("td").eq(13).css("text-align", "left");
                $(row).find("td").css("text-transform","uppercase")
            },
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        $.get("controller/stok_controller/sql.php?islem=stoklari_getir", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                table.rows.add(json).draw(false);
            }
        })
    });


    $("body").off("click", "#stok_ekle_button").on("click", "#stok_ekle_button", function () {
        $.get("modals/stok_modal/modal.php?islem=stok_ekle_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    })


    $("body").off("click", ".stok_list_selected").on("click", ".stok_list_selected", function () {
        $('.stok_list_selected').css("background-color", "rgb(255, 255, 255)");
        $(this).css("background-color", "#60b3abad");
        $('.stok_list_selected').removeClass('selected');
        $(this).addClass("selected");
        $(".selected").css("background-color", "#B9EDDD");
    });

    $("body").off("click", "#stok_sil").on("click", "#stok_sil", function () {
        var stok_kodu = $(".selected").find("td").first().html();
        if (stok_kodu == "" || stok_kodu == undefined) {
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
                        url: "controller/stok_controller/sql.php?islem=stok_sil_sql",
                        type: "POST",
                        data: {
                            stok_kodu: stok_kodu,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                if (result == 300) {
                                    Swal.fire(
                                        'Uyarı!',
                                        'Bu Stoğa Ait Hareket Mevcut Lütfen Siliniz',
                                        'warning'
                                    );
                                } else {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Stok Silindi',
                                        'success'
                                    );
                                    $.get("view/add_stok_page.php", function (getList) {
                                        $(".modal-icerik").html("");
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("view/add_stok_page.php", function (getList) {
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
        }
    })
</script>