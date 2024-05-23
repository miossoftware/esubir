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
        <div class="ibox-title" style=' font-weight:bold;'>DEPO İŞ EMİRLERİ</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="yeni_is_emri_olustur">İş Emri Oluştur</button>
            <button class="btn btn-info btn-sm" id=""><i
                        class="fa fa-filter"></i> Hazırla
            </button>
        </div>
        <div class="col-12 row mt-5">
            <table class="table table-sm table-bordered w-100 datatable"
                   style="cursor:pointer;font-size: 13px;"
                   id="depo_cikis_table">
                <thead>
                <tr>
                    <th>Sipariş Tarih</th>
                    <th>Cari Adı</th>
                    <th>Sipariş Sayısı</th>
                    <th>Epro Referans</th>
                    <th>Acenta Referans</th>
                    <th>Alım Yeri</th>
                    <th>CUT - OFF Tarihi</th>
                    <th>Ardiyesiz Giriş Tarihi</th>
                    <th>Konteyner Sayısı</th>
                    <th>Tamamlanan Konteynerler</th>
                    <th>Sipariş Açıklama</th>
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
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "DEPO İŞ EMİRLERİ",
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
            columns: [
                {"data": "siparis_tarihi"},
                {"data": "cari_adi"},
                {"data": "siparis_sayisi"},
                {"data": "epro_referans"},
                {"data": "acenta_referans"},
                {"data": "alim_yeri"},
                {"data": "cut_off_tarihi"},
                {"data": "ardiyesiz_giris"},
                {"data": "konteyner_sayisi"},
                {"data": "tamamlanan_konteynerler"},
                {"data": "siparis_aciklama"},
                {"data": "aciklama"},
                {"data": "islem"}
            ],
            columnDefs: [
                {targets: 1, type: "date-eu"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find('td').eq(2).css('text-align', 'right');
                $(row).find('td').eq(8).css('text-align', 'right');
                $(row).find('td').eq(9).css('text-align', 'right');
                $(row).find('td').eq(10).css('text-align', 'right');
                $(row).find("td").css("text-transform", "uppercase")

            },
            "rowCallback": function (row) {
            },
            order: [[1, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        $.get("depo/controller/ihracat_controller/sql.php?islem=tum_is_emirlerini_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        });

        $("body").off("click", ".is_emri_sil_main_button").on("click", ".is_emri_sil_main_button", function () {
            let id = $(this).attr("data-id");
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
                        url: "depo/controller/ihracat_controller/sql.php?islem=is_emrini_sil_sql",
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
                                        'İş Emrinin İş Başlangıcı Olmuştur Lütfen İş Emrine Ait İşleri Siliniz...',
                                        'warning'
                                    );
                                } else {
                                    Swal.fire(
                                        'Başarılı!',
                                        'İş Emri Silindi',
                                        'success'
                                    );
                                    $.get("depo/view/depo_konteyner_giris.php", function (getList) {
                                        $(".modal-icerik").html("");
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("depo/view/depo_konteyner_giris.php", function (getList) {
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
        });

        $("body").off("click", ".depo_is_emri_guncelleme_button").on("click", ".depo_is_emri_guncelleme_button", function () {
            let id = $(this).attr("data-id");
            $.get("depo/modals/ihracat_modal/modal.php?islem=depo_is_emri_guncelle_modal", {id: id}, function (getModal) {
                $(".getModals").html(getModal);
            });
        })

        $("body").off("click", "#yeni_is_emri_olustur").on("click", "#yeni_is_emri_olustur", function () {
            $.get("depo/modals/ihracat_modal/modal.php?islem=ihracat_projesi_olsutur_modal", function (getModal) {
                $(".getModals").html(getModal);
            })
        });
    });

</script>