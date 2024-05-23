<div class="ibox mt-4">

    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>ÜYE TAHAKKUK İŞLEMLERİ</div>
    </div>
    <div class="col-12 mt-2">
        <div class="col-3">
            <button class="btn btn-success btn-sm" id="uye_tahakkuk_islemleri_button"><i class="fa fa-plus"></i>
                Yeni Kayıt
            </button>
        </div>
    </div>

    <div class="col-12 row">
        <table class="table table-sm table-bordered w-100  nowrap edit_list" style="cursor:pointer;font-size: 13px;"
               id="sulama_tahakkuk_table">
            <thead>
            <tr>
                <th>Tarih</th>
                <th>Tahakuk Tutarı</th>
                <th>Açıklama</th>
                <th>İşlem</th>
            </tr>
            </thead>
            <tfoot style="background-color: white">
            <th></th>
            <th style="text-align: right" class="uye_odeme_tot">0,00</th>
            <th></th>
            </tfoot>
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
        var table = $('#sulama_tahakkuk_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "order": [[0, 'desc']],
            "info": false,
            "paging": false,
            columnDefs: [
                {targets: 0, type: "date-eu"}
            ],
            columns: [
                {'data': 'tarih'},
                {'data': 'tahakkuk_tutari'},
                {'data': 'aciklama'},
                {'data': 'islem'},
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find("td").css("text-align", "left");
                $(row).find("td").eq(1).css("text-align", "right");
            },
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        });
        $.get("controller/uye_controller/sql.php?islem=tum_tahakkuklari_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                $(".uye_odeme_tot").html(json[0]["toplam_tah"]);
                table.rows.add(json).draw(false);
            }
        })
    });

    $("body").off("click", "#uye_tahakkuk_islemleri_button").on("click", "#uye_tahakkuk_islemleri_button", function () {
        $.get("modals/uye_modal/tahakkuk_modal.php?islem=uye_tahakkuk_yap_modal", function (getModal) {
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".maas_tahakkuk_guncelle").on("click", ".maas_tahakkuk_guncelle", function () {
        let id = $(this).attr("data-id");
        $.get("modals/personel_modal/maas_tahakkuk_modal.php?islem=tahakkuk_guncelle_modal_getir", {id: id}, function (getModal) {
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".uye_tahakkuk_sil_button").on("click", ".uye_tahakkuk_sil_button", function () {
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
                        url: "controller/uye_controller/sql.php?islem=tahakkuk_iptal_et_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Tahakkuk Silindi',
                                    'success'
                                );
                                $.get("view/uye_tahakkuk_islemleri.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/uye_tahakkuk_islemleri.php", function (getList) {
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
    })

</script>
