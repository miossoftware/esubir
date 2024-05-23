<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>BİREYSEL TAHAKKUK İŞLEMLERİ</div>
    </div>
    <div class="col-12 row mt-3">
        <div class="col-3">
            <button class="btn btn-success btn-sm" id="bireysel_tahakkuk_islemi"><i class="fa fa-plus"></i> Üye
                Tahakkuk İşlemi
            </button>
        </div>
    </div>
    <div class="col-12 row">
        <table class="table table-sm table-bordered w-100  nowrap" id="uye_acilis_table" style="font-size: 13px;">
            <thead>
            <tr>
                <th>TC NO</th>
                <th>Üye Adı</th>
                <th>Tarih</th>
                <th style="width: 0% !important;">Ödeme Yöntemi</th>
                <th>Tutar</th>
                <th>Tarife</th>
                <th>Açıklama</th>
                <th>İşlem</th>
            </tr>
            </thead>
            <tfoot style="background-color: white">
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th style="text-align: right" class="toplam_tahakkuk">0,00</th>
            <th></th>
            <th></th>
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
        var table = $('#uye_acilis_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            columns: [
                {'data': 'tc_no'},
                {'data': 'uye_adi'},
                {'data': 'tarih'},
                {'data': 'odeme_yontemi'},
                {'data': 'tutar'},
                {'data': 'tarife'},
                {'data': 'aciklama'},
                {'data': 'islem'},
            ],
            columnDefs: [
                {targets: 2, type: "date-eu"}
            ],
            order: [2, ["desc"]],
            createdRow: function (row, data, dataIndex) {
                $(row).addClass("stok_list_selected");
                $(row).find("td").css("text-align", "left");
                $(row).find("td").eq(4).css("text-align", "right");
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        $.get("controller/uye_controller/sql.php?islem=bireysel_tahakku_islemlerini_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                $(".toplam_tahakkuk").html(json[0]["toplam_tahakkuk"]);
                table.rows.add(json).draw(false);
            }
        })
    });

    $("body").off("click", ".bireysel_tahakkuk_guncelle_button").on("click", ".bireysel_tahakkuk_guncelle_button", function () {
        let id = $(this).attr("data-id");
        $.get("modals/uye_modal/tahakkuk_modal.php?islem=bireysel_tahakkuk_guncelle_modal", {id: id}, function (getModal) {
            $(".getModals").html(getModal);
        });
    });

    $("body").off("click", "#bireysel_tahakkuk_islemi").on("click", "#bireysel_tahakkuk_islemi", function () {
        $.get("modals/uye_modal/tahakkuk_modal.php?islem=bireysel_tahakkuk_islemi", function (getModal) {
            $(".getModals").html(getModal);
        });
    });

    $("body").off("click", ".yukleme_sil_button").on("click", ".yukleme_sil_button", function () {
        var id = $(this).attr("data-id");
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz uyeyi seçiniz',
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
                        url: "controller/uye_controller/sql.php?islem=bireysel_tahakkuk_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Açılış Fişi Silindi',
                                    'success'
                                );
                                $.get("view/bireysel_tahakkuk_islemleri.php", function (getList) {
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/bireysel_tahakkuk_islemleri.php", function (getList) {
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