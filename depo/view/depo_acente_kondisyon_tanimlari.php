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
        <div class="ibox-title" style=' font-weight:bold;'>KONDİSYON TANIM</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="yeni_depo_kondisyon_button"><i class="fa fa-plus"></i>
                Kondisyon Tanımı
            </button>
        </div>
        <div class="mt-2"></div>
        <div class="hesap_ekstre_genel_main">
            <div class="col-12 row">
                <table class="table table-sm table-bordered w-100  nowrap datatable"
                       style="cursor:pointer;font-size: 13px;"
                       id="cari_free_time_liste">
                    <thead>
                    <tr>
                        <th>Kondisyon Adı</th>
                        <th style="width: 0% !important;">İşlem</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script>

    $(document).ready(function () {
        $.extend($.fn.dataTableExt.oSort, {
            "date-eu-pre": function (dateString) {
                var dateArray = dateString.split('/');
                var formattedDate = dateArray[2] + '-' + dateArray[1] + '-' + dateArray[0];
                return Date.parse(formattedDate) || 0;
            },
            "date-eu-asc": function (a, b) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },
            "date-eu-desc": function (a, b) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        });
        var table = $('#cari_free_time_liste').DataTable({
            scrollX: true,
            scrollY: '45vh',
            "paging": false,
            columns: [
                {"data": "kondisyon_adi"},
                {"data": "islem"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find('td').eq(1).css('text-align', 'right');
                $(row).find('td').eq(2).css('text-align', 'right');
                $(row).find('td').eq(3).css('text-align', 'right');
                $(row).find("td").css("text-transform", "uppercase");

            },
            "rowCallback": function (row) {
            },
            order: [[1, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        $.get("depo/controller/acente_controller/sql.php?islem=kondisyon_tanimlari_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        })

    });

    $("body").off("click", ".kondisyon_tanim_sil_sql").on("click", ".kondisyon_tanim_sil_sql", function () {
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
                        url: "depo/controller/acente_controller/sql.php?islem=kondisyon_tanim_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                if (result == 300) {
                                    Swal.fire(
                                        'Uyarı!',
                                        'Adreste Konteyner Bulunuyor Lütfen Önce Konteynerleri Siliniz...',
                                        'warning'
                                    );
                                } else {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Kondisyon Tanımı Silindi',
                                        'success'
                                    );

                                    $.get("depo/view/depo_acente_kondisyon_tanimlari.php", function (getList) {
                                        $(".modal-icerik").html(getList);
                                    });
                                    $.get("depo/view/depo_acente_kondisyon_tanimlari.php", function (getList) {
                                        $(".admin-modal-icerik").html(getList);
                                    });
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
    });

    $("body").off("focusout", ".guncellenecek_kondisyon_adi").on("focusout", ".guncellenecek_kondisyon_adi", function () {
        let id = $(this).attr("data-id");
        let kondisyon_adi = $(this).val();
        $.ajax({
            url: "depo/controller/acente_controller/sql.php?islem=kondisyon_guncelle_sql",
            type: "POST",
            data: {
                id: id,
                kondisyon_adi: kondisyon_adi
            },
            success: function (res) {
                if (res == 1) {
                    Swal.fire(
                        "Başarılı",
                        "Güncelleme Sağlandı...",
                        "success"
                    );
                }
            }
        });
    });

    $("body").off("click", "#yeni_depo_kondisyon_button").on("click", "#yeni_depo_kondisyon_button", function () {
        $.get("depo/modals/acente_depo_modal/depo_hizmet_tanimlari.php?islem=yeni_depo_kondisyon_tanim_button", function (getModal) {
            $(".getModals").html(getModal);
        });
    });

</script>