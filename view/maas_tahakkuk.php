<div class="ibox mt-4">

    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>MAAŞ TAHAKKUK</div>
    </div>
    <div class="col-12 mt-2">
        <div class="col-3">
            <button class="btn btn-success btn-sm" id="maas_tahakkuk_modal_main"><i class="fa fa-plus"></i>
                Yeni Kayıt
            </button>
        </div>
    </div>

    <div class="col-12 row">
        <table class="table table-sm table-bordered w-100  nowrap edit_list" style="cursor:pointer;font-size: 13px;"
               id="maas_tahakkuk_table">
            <thead>
            <tr>
                <th>Oluşturma Tarihi</th>
                <th>Açıklama</th>
                <th>Toplam</th>
                <th>İşlem</th>
            </tr>
            </thead>
            <tfoot style="background-color: white">
            <th></th>
            <th></th>
            <th style="text-align: right" class="maas_odeme_tot">0,00</th>
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
        var table = $('#maas_tahakkuk_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "order": [[0, 'desc']],
            "info": false,
            "paging": false,
            columnDefs: [
                {targets: 0, type: "date-eu"}
            ],
            aoColumns: [
                {sWidth: '1%'},
                {sWidth: '1%'},
                {sWidth: '1%'},
                {sWidth: '0%'}
            ],
            createdRow: function (row, data, dataIndex) {
            },
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        });
        $.get("controller/personel_controller/sql.php?islem=tum_personel_maaslarini_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                let toplam_odenen_maas = 0;
                json.forEach(function (item) {
                    let gonderilen_tarih = item.olusturma_tarihi;
                    gonderilen_tarih = gonderilen_tarih.split(" ");
                    gonderilen_tarih = gonderilen_tarih[0];
                    gonderilen_tarih = gonderilen_tarih.split("-");
                    var gun = gonderilen_tarih[2];
                    var ay = gonderilen_tarih[1];
                    var yil = gonderilen_tarih[0];
                    var arr = [gun, ay, yil];
                    gonderilen_tarih = arr.join("/");

                    let tutar = item.toplam;
                    tutar = parseFloat(tutar);
                    toplam_odenen_maas += tutar;
                    tutar = tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});

                    var new_row = table.row.add([gonderilen_tarih, item.aciklama, tutar, "<button class='btn btn-sm maas_tahakkuk_guncelle' data-id='" + item.id + "' style='background-color: #F6FA70;'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm tahakkuk_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                    $(new_row).find('td').eq(0).css('text-align', 'left');
                    $(new_row).find('td').eq(1).css('text-align', 'left');
                })

                $(".maas_odeme_tot").html(toplam_odenen_maas.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }));
            }
        })
    })

    $("body").off("click", ".maas_tahakkuk_guncelle").on("click", ".maas_tahakkuk_guncelle", function () {
        let id = $(this).attr("data-id");
        $.get("modals/personel_modal/maas_tahakkuk_modal.php?islem=tahakkuk_guncelle_modal_getir", {id: id}, function (getModal) {
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".tahakkuk_sil").on("click", ".tahakkuk_sil", function () {
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
                        url: "controller/personel_controller/sql.php?islem=tahakkuk_iptal_et_sql",
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
                                $.get("view/maas_tahakkuk.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/maas_tahakkuk.php", function (getList) {
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

    $("body").off("click", "#maas_tahakkuk_modal_main").on("click", "#maas_tahakkuk_modal_main", function () {
        $.get("modals/personel_modal/maas_tahakkuk_modal.php?islem=yeni_tahakkuk_ekle_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    })

</script>
