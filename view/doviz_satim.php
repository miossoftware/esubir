<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>DÖVİZ SATIM</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="doviz_satis_yap_button"><i class="fa fa-plus"></i> Satım Yap
            </button>
            <button class="btn btn-info btn-sm" id=""><i
                    class="fa fa-filter"></i> Hazırla
            </button>
        </div>
        <div class="col-12 row">
            <div class="col-12 row mx-1 mt-3">
                <div class="col-md-3 row">
                    <input type="text" placeholder="Başlangıç Tarihi" id="bas_tarih" onfocus="(this.type='date')"
                           class="form-control form-control-sm bas_tarih_banka_virman">
                    <input type="text" placeholder="Bitiş Tarihi" id="bit_tarih" onfocus="(this.type='date')"
                           class="form-control form-control-sm mt-2 bit_tarih_banka_virman">
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 row">
        <table class="table table-sm table-bordered w-100  nowrap" style="cursor:pointer;font-size: 13px;"
               id="banka_virman_table">
            <thead>
            <tr>
                <th>Alım Tarihi</th>
                <th>Döviz Hesabı</th>
                <th>TL Hesabı</th>
                <th>Satış Miktarı</th>
                <th>Döviz Türü</th>
                <th>TL Tutarı</th>
                <th>Masraf Tutarı</th>
                <th>Masraf Carisi</th>
                <th>İşlem</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<script>

    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });
    $(document).ready(function () {
        jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "date-eu-pre": function (dateString) {
                var parts = dateString.split('/');
                return Date.parse(parts[2] + '/' + parts[1] + '/' + parts[0]) || 0;
            },

            "date-eu-asc": function (a, b) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },

            "date-eu-desc": function (a, b) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        });
        var table = $('#banka_virman_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            bAutoWidth: false,
            "order": [[0, 'desc']],
            columnDefs: [
                {targets: 0, type: "date-eu"}
            ],
            columns: [
                {'data': 'tarih'},
                {'data': 'doviz_hesabi'},
                {'data': 'tl_hesabi'},
                {'data': 'doviz_miktari'},
                {'data': 'doviz_turu'},
                {'data': 'tl_tutari'},
                {'data': 'masraf_tutari'},
                {'data': 'cari_adi'},
                {'data': 'islem'}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).attr("data-id", data.id);
                $(row).find("td").css("text-align", "left");
                $(row).find("td").eq(3).css("text-align", "right");
                $(row).find("td").eq(5).css("text-align", "right");
                $(row).find("td").eq(6).css("text-align", "right");
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        })

        $.get("controller/banka_controller/sql.php?islem=doviz_satimlari_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        })

        $("body").off("click", ".banka_satim_guncelle_button").on("click", ".banka_satim_guncelle_button", function () {
            let id = $(this).attr("data-id");
            $.get("modals/banka_modal/doviz_satis_modal.php?islem=doviz_satis_guncelle_modal", {id: id}, function (getModal) {
                $(".getModals").html(getModal);
            })
        })


    });

    $("body").off("click", ".doviz_satim_sil_button").on("click", ".doviz_satim_sil_button", function () {
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
                        url: "controller/banka_controller/sql.php?islem=doviz_satim_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Döviz Satım Silindi',
                                    'success'
                                );
                                $.get("view/doviz_satim.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/doviz_satim.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
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

    $("body").off("click", "#doviz_satis_yap_button").on("click", "#doviz_satis_yap_button", function () {
        $.get("modals/banka_modal/doviz_satis_modal.php?islem=yeni_doviz_satis_yap_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

</script>