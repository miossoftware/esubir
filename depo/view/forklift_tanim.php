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
        <div class="ibox-title" style=' font-weight:bold;'>FORKLİFT TANIM</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="yeni_forklift_ekle_button"><i class="fa fa-plus"></i>
                Forklift Ekle
            </button>
            <button class="btn btn-info btn-sm" id=""><i
                    class="fa fa-filter"></i> Hazırla
            </button>
        </div>
        <div class="col-12 row mt-5">
            <table class="table table-sm table-bordered w-100  nowrap datatable"
                   style="cursor:pointer;font-size: 13px;"
                   id="forklift_tanim_table">
                <thead>
                <tr>
                    <th>Forklift Grubu</th>
                    <th>Forklift Adı</th>
                    <th>Forklift Kodu</th>
                    <th>Sürücü Adı</th>
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
                {"data": "forklift_grubu"},
                {"data": "forklift_adi"},
                {"data": "forklift_kodu"},
                {"data": "surucu_adi"},
                {"data": "islem"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find("td").css("text-transform", "uppercase");

            },
            "rowCallback": function (row) {
            },
            order: [[1, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        $.get("depo/controller/tanim_controller/sql.php?islem=tum_forkliftleri_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        })
    });

    $("body").off("click", ".tanimlanan_forkliftleri_sil_button").on("click", ".tanimlanan_forkliftleri_sil_button", function () {
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
                        url: "depo/controller/tanim_controller/sql.php?islem=tanimli_forklifti_sil_button",
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
                                        'Forklift Silindi',
                                        'success'
                                    );
                                    $.get("depo/view/forklift_tanim.php", function (getList) {
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("depo/view/forklift_tanim.php", function (getList) {
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

    $("body").off("click", "#yeni_forklift_ekle_button").on("click", "#yeni_forklift_ekle_button", function () {
        $.get("depo/modals/tanimlar/forklfit_tanim_modal.php?islem=yeni_forklift_tanit_main_modal", function (getModal) {
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".tanimli_forklifti_guncelle_main_button").on("click", ".tanimli_forklifti_guncelle_main_button", function () {
        let id = $(this).attr("data-id");
        $.get("depo/modals/tanimlar/forklfit_tanim_modal.php?islem=forklift_tanim_guncelle_modal", {id: id}, function (getModal) {
            $(".getModals").html(getModal);
        })
    });

</script>