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
        <div class="ibox-title" style=' font-weight:bold;'>DEPO ADRES TANIMLARI</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="yeni_depo_adres_tanim_button"><i class="fa fa-plus"></i>
                Yeni Adres Tanımı
            </button>
            <button class="btn btn-info btn-sm" id=""><i
                        class="fa fa-filter"></i> Hazırla
            </button>
        </div>
        <div class="col-12 row mt-5">
            <table class="table table-sm table-bordered w-100  nowrap datatable"
                   style="cursor:pointer;font-size: 13px;"
                   id="depo_cikis_table">
                <thead>
                <tr>
                    <th>Depo Adresi</th>
                    <th>Adres Kodu</th>
                    <th>Açıklama</th>
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
        var table = $('#depo_cikis_table').DataTable({
            scrollX: true,
            scrollY: '45vh',
            "paging": false,
            columns: [
                {"data": "adres_adi"},
                {"data": "adres_kodu"},
                {"data": "aciklama"},
                {"data": "islem"}
            ],
            columnDefs: [
                {targets: 1, type: "date-eu"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find('td').eq(3).css('text-align', 'right');
                $(row).find("td").css("text-transform", "uppercase")

            },
            "rowCallback": function (row) {
            },
            order: [[1, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        $.get("depo/controller/tanim_controller/sql.php?islem=tanimlanan_adresleri_getir_sql", function (res) {
            if (res != 2) {
                let json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        })
    });

    $("body").off("click", ".tanimlanan_adresi_sil_button").on("click", ".tanimlanan_adresi_sil_button", function () {
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
                        url: "depo/controller/tanim_controller/sql.php?islem=tanimlanan_adresi_sil_sql",
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
                                        'Adres Silindi',
                                        'success'
                                    );
                                    $.get("depo/view/konteyner_adres_tanimi.php", function (getList) {
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("depo/view/konteyner_adres_tanimi.php", function (getList) {
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

    $("body").off("click", "#yeni_depo_adres_tanim_button").on("click", "#yeni_depo_adres_tanim_button", function () {
        $.get("depo/modals/tanimlar/adres_tanim.php?islem=depo_adres_tanimlama_modal", function (getModal) {
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".tanimlanan_adresi_guncelle_button").on("click", ".tanimlanan_adresi_guncelle_button", function () {
        let id = $(this).attr("data-id");
        $.get("depo/modals/tanimlar/adres_tanim.php?islem=depo_adres_guncelleme_modal", {id: id}, function (getModal) {
            $(".getModals").html(getModal);
        })
    });

</script>