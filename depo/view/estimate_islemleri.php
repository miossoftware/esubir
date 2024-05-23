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
        <div class="ibox-title" style=' font-weight:bold;'>KONTEYNER ESTİMATE</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="konteynere_estimate_ekle"><i class="fa fa-plus"></i>
                Estimate Ekle
            </button>
        </div>
        <div class="col-12 row mt-5">
            <table class="table table-sm table-bordered w-100  nowrap datatable"
                   style="cursor:pointer;font-size: 13px;"
                   id="forklift_tanim_table">
                <thead>
                <tr>
                    <th>Konteyner No</th>
                    <th>Acente Adı</th>
                    <th>Hasar Açıklaması</th>
                    <th>Konteyner Tipi</th>
                    <th>Toplam İşlem</th>
                    <th>Toplam Tutar</th>
                    <th>İşlem</th>
                </tr>
                </thead>
            </table>
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
        var targetColumns = [5, 6, 7, 12, 13, 14];
        var table = $('#forklift_tanim_table').DataTable({
            scrollX: true,
            scrollY: '45vh',
            "paging": false,
            columns: [
                {"data": "konteyner_no"},
                {"data": "acente_adi"},
                {"data": "hasar_aciklamasi"},
                {"data": "konteyner_tipi"},
                {"data": "toplam_islem"},
                {"data": "toplam_fiyat"},
                {"data": "islem"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find('td').eq(5).css('text-align', 'right');
                $(row).find("td").css("text-transform", "uppercase");

            },
            "rowCallback": function (row) {
            },
            order: [[1, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        $.get("depo/controller/acente_controller/sql.php?islem=estimate_emirlerini_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        })

    });

    $("body").off("click", "#konteynere_estimate_ekle").on("click", "#konteynere_estimate_ekle", function () {
        $.get("depo/modals/acente_depo_modal/estimate_modal.php?islem=konteyner_estimate_ekle_modal", function (getModal) {
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".estimate_islemi_sil_button").on("click", ".estimate_islemi_sil_button", function () {
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
                        url: "depo/controller/acente_controller/sql.php?islem=estimate_sil_sql",
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
                                        'Estimate İşlmei Silindi',
                                        'success'
                                    );
                                    $.get("depo/view/estimate_islemleri.php", function (getList) {
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("depo/view/estimate_islemleri.php", function (getList) {
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
    });

    $("body").off("click", ".konteyner_estimate_guncelle_button").on("click", ".konteyner_estimate_guncelle_button", function () {
        let id = $(this).attr("data-id");
        $.get("depo/modals/acente_depo_modal/estimate_modal.php?islem=estimate_guncelle_main_modal", {id: id}, function (getModal) {
            $(".getModals").html(getModal);
        })
    });

</script>