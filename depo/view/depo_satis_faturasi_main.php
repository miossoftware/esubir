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
        <div class="ibox-title" style=' font-weight:bold;'>SATIŞ FATURALARI</div>
    </div>
    <div class="mx-2">
        <button class="btn btn-success btn-sm" id="depo_satis_faturasi_kes_button"><i class="fa fa-plus"></i>
            Satış Faturası Oluştur
        </button>
    </div>
    <div class="col-12 row">
        <table class="table table-sm table-bordered w-100  nowrap datatable"
               style="cursor:pointer;font-size: 13px;"
               id="depo_satis_faturasi_table">
            <thead>
            <tr>
                <th>Fatura No</th>
                <th>Fatura Türü</th>
                <th>Fatura Tarihi</th>
                <th>Cari Kodu</th>
                <th>Cari Adı</th>
                <th>Mal Tutarı</th>
                <th>KDV</th>
                <th>Genel Toplam</th>
                <th>Döviz Tipi</th>
                <th>Döviz Kuru</th>
                <th>Döviz Mal Tutarı</th>
                <th>Döviz Mal KDV</th>
                <th>Döviz Genel Toplam</th>
                <th>İşlem</th>
            </tr>
            </thead>
        </table>
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
            var targetColumns = [5, 6, 7, 10, 11, 12];
        var table = $('#depo_satis_faturasi_table').DataTable({
            scrollX: true,
            scrollY: '45vh',
            "paging": false,
            columns: [
                {"data": "fatura_no"},
                {"data": "fatura_turu"},
                {"data": "fatura_tarihi"},
                {"data": "cari_kodu"},
                {"data": "cari_adi"},
                {"data": "mal_tutari"},
                {"data": "kdv"},
                {"data": "genel_toplam"},
                {"data": "doviz_tipi"},
                {"data": "doviz_kuru"},
                {"data": "doviz_mal_tutari"},
                {"data": "doviz_kdv"},
                {"data": "doviz_genel_toplam"},
                {"data": "islem"}
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "CARİ HESAP EKSTRESİ",
                    text: "<i class='fa fa-download'></i> Excel'e Aktar",
                    className: 'excel_alis', // Sınıfı burada tanımlayabilirsiniz
                    customizeData: function (excelData) {
                        // Özel veri dönüşümü ve formatlamaları yapabilirsiniz
                        // excelData, dışa aktarılacak Excel verilerini temsil eder

                        // Örneğin, her hücreyi sayı olarak biçimlendirme
                        for (var rowIdx = 0; rowIdx < excelData.body.length; rowIdx++) {
                            var rowData = excelData.body[rowIdx];
                            for (var cellIdx = 0; cellIdx < rowData.length; cellIdx++) {
                                var cellValue = excelData.body[rowIdx][cellIdx];
                                if (typeof cellValue === 'string') {
                                    if (targetColumns.includes(cellIdx)) {
                                        var parsedValue = parseFloat(cellValue.replace('.', '').replace(',', '.').replace(/\s/g, ''));
                                        if (!isNaN(parsedValue)) {
                                            excelData.body[rowIdx][cellIdx] = parsedValue.toLocaleString("en-US", {
                                                maximumFractionDigits: 2,
                                                minimumFractionDigits: 2
                                            });
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find('td').eq(5).css('text-align', 'right');
                $(row).find('td').eq(6).css('text-align', 'right');
                $(row).find('td').eq(7).css('text-align', 'right');
                $(row).find('td').eq(9).css('text-align', 'right');
                $(row).find('td').eq(10).css('text-align', 'right');
                $(row).find('td').eq(11).css('text-align', 'right');
                $(row).find('td').eq(12).css('text-align', 'right');
                $(row).find("td").css("text-transform", "uppercase")

            },
            "rowCallback": function (row) {
            },
            order: [[1, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });
        $.get("depo/controller/satis_controller/sql.php?islem=kesilen_faturalari_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        })
    });

    $("body").off("click", ".depo_satis_faturasini_sil_button").on("click", ".depo_satis_faturasini_sil_button", function () {
        var id = $(this).attr("data-id");
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Siparişi seçiniz',
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
                        url: "depo/controller/satis_controller/sql.php?islem=faturayi_iptal_et_sql",
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
                                        'Siparişin Taşıması Başlamıştır Lütfen Önce Taşımaları Siliniz...',
                                        'warning'
                                    );
                                } else {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Fatura Silindi...',
                                        'success'
                                    );
                                    $.get("depo/view/depo_satis_faturasi_main.php", function (getList) {
                                        $(".modal-icerik").html("");
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("depo/view/depo_satis_faturasi_main.php", function (getList) {
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
    });

    $("body").off("click", "#depo_satis_faturasi_kes_button").on("click", "#depo_satis_faturasi_kes_button", function () {
        $.get("depo/modals/satis_modal/satis_fatura_modal.php?islem=satis_faturasi_olustur_modal", function (getModal) {
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".depo_satis_fat_guncelle_button").on("click", ".depo_satis_fat_guncelle_button", function () {
        let id = $(this).attr("data-id");
        $.get("depo/modals/satis_modal/satis_fatura_modal.php?islem=satis_faturasi_guncelle_modal", {id: id}, function (getModal) {
            $(".getModals").html(getModal);
        })
    });

</script>