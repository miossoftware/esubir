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
        <div class="ibox-title" style=' font-weight:bold;'>KONTEYNERE ÜRÜN AKTAR</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="sahadaki_urunleri_aktar">Ürün Aktar <i class="fa fa-plus"></i>
            </button>
            <button class="btn btn-info btn-sm" id=""><i
                        class="fa fa-filter"></i> Hazırla
            </button>
            <div class="mt-2"></div>
        </div>
        <div class="col-12 row">
            <table class="table table-sm table-bordered w-100 nowrap datatable"
                   style="cursor:pointer;font-size: 13px;"
                   id="sahadaki_urunler_listesi">
                <thead>
                <tr>
                    <th>Giriş Tarihi</th>
                    <th>Yükleme Tarihi</th>
                    <th>Cari Adı</th>
                    <th>Plaka No</th>
                    <th>Gelen Miktar</th>
                    <th>Epro. Referans</th>
                    <th>Referans</th>
                    <th>Beyanname No</th>
                    <th>Konteyner No1</th>
                    <th>Yüklenen Miktar</th>
                    <th>Birim1</th>
                    <th>Konteyner No2</th>
                    <th>Yüklenen Miktar</th>
                    <th>Birim2</th>
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
        var table = $('#sahadaki_urunler_listesi').DataTable({
            scrollX: true,
            scrollY: '45vh',
            "paging": false,
            columns: [
                {"data": "giris_tarihi"},
                {"data": "tarih"},
                {"data": "cari_adi"},
                {"data": "plaka_no"},
                {"data": "miktar"},
                {"data": "epro_ref"},
                {"data": "referans_no"},
                {"data": "beyanname_no"},
                {"data": "konteyner_no1"},
                {"data": "yuklenen_miktar1"},
                {"data": "birim_adi1"},
                {"data": "konteyner_no2"},
                {"data": "yuklenen_miktar2"},
                {"data": "birim_adi2"},
                {"data": "islem"}
            ],
            columnDefs: [
                {targets: 0, type: "date-eu"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find('td').eq(4).css('text-align', 'right');
                $(row).find('td').eq(9).css('text-align', 'right');
                $(row).find('td').eq(12).css('text-align', 'right');
                $(row).find("td").css("text-transform", "uppercase");
            },
            "rowCallback": function (row) {
            },
            order: [[0, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        $.get("depo/controller/puantor_controller/sql.php?islem=konteynere_aktarilan_urunleri_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        });

    });

    $("body").off("click", ".konteynere_aktarilan_kaydi_sil_button").on("click", ".konteynere_aktarilan_kaydi_sil_button", function () {
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
                        url: "depo/controller/puantor_controller/sql.php?islem=aktarilan_konteyneri_sil_sql",
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
                                        'Aktarılan Konteyner Silindi',
                                        'success'
                                    );
                                    $.get("depo/view/konteynere_urun_aktar.php", function (getList) {
                                        $(".modal-icerik").html(getList);
                                    });
                                    $.get("depo/view/konteynere_urun_aktar.php", function (getList) {
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

    $("body").off("click", "#sahadaki_urunleri_aktar").on("click", "#sahadaki_urunleri_aktar", function () {
        $.get("depo/modals/puantor_modal/sahadaki_urunleri_konteynere_aktar.php?islem=sahadaki_urunleri_aktar", function (getModal) {
            $(".getModals").html(getModal);
        })
    });
</script>