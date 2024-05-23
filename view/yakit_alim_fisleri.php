<style>
    .excel_alis {
        background-color: #2ecc71 !important;
        border-color: #27ad60 !important;
        color: white !important;
        border-radius: 20px !important;
        font-weight: bold !important;
    }
</style>
<div class="ibox-container">
    <div class="ibox mt-5">
        <div class="ibox-head">
            <div class="ibox-title" style=' font-weight:bold;'>YAKIT ALIM FİŞLERİ</div>
        </div>
        <div class="col-12 row">
            <div class="mx-2">
                <div class="btn-group" role="group">
                    <button class="btn btn-success btn-sm" id="yakit_fisi_olustur_button"><i class="fa fa-plus"></i>
                        Yakıt Fişi Oluştur
                    </button>
                </div>
                <button class="btn btn-info btn-sm" id=""><i
                            class="fa fa-filter"></i> Hazırla
                </button>
            </div>
            <div class="col-12 row">
                <div class="col-12 row mx-1 mt-3">
                    <div class="col-md-3 row">

                        <input type="text" placeholder="Başlangıç Tarihi" id="bas_tarih" onfocus="(this.type='date')"
                               class="form-control form-control-sm bas_tarih_havale_cikis">
                        <input type="text" placeholder="Bitiş Tarihi" id="bit_tarih" onfocus="(this.type='date')"
                               class="form-control form-control-sm mt-2 bit_tarih_havale_cikis">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 row mt-3">
            <table class="table table-sm table-bordered w-100  nowrap" style="cursor:pointer;font-size: 13px;"
                   id="konteyner_siparis_main_list">
                <thead>
                <tr>
                    <th>Alınan Yer</th>
                    <th>Alım Yöntemi</th>
                    <th>Kasa Adı</th>
                    <th>Banka Adı</th>
                    <th>Kart Adı</th>
                    <th>Tarih</th>
                    <th>Plaka</th>
                    <th>Sürücü</th>
                    <th>Fiş No</th>
                    <th>Miktar</th>
                    <th>Litre Fiyat</th>
                    <th>Tutar</th>
                    <th>Yakıt Tipi</th>
                    <th>İstasyon Adı</th>
                    <th>Son KM</th>
                    <th>Alınan KM</th>
                    <th>Fark KM</th>
                    <th>Açıklama</th>
                    <th>İşlem</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>

    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });

    $("body").off("click", "#yakit_fisi_olustur_button").on("click", "#yakit_fisi_olustur_button", function () {
        $.get("modals/arac_modal/yakit_alim_modal.php?islem=yakit_fisi_giris_modal", function (getModal) {
            $(".getModals").html(getModal);
        })
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
        var targetColumns = [7, 8, 9, 13, 14, 15];
        var table = $("#konteyner_siparis_main_list").DataTable({
            scrollY: '55vh',
            scrollX: true,
            "order": [[5, 'desc']],
            columnDefs: [
                {targets: 5, type: "date-eu"}
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "BİNEK YAKIT ÇIKIŞ FİŞLERİ",
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
                {"data": "alinan_yer"},
                {"data": "alim_yontem"},
                {"data": "kasa_adi"},
                {"data": "banka_adi"},
                {"data": "kart_adi"},
                {"data": "tarih"},
                {"data": "plaka"},
                {"data": "surucu"},
                {"data": "fis_no"},
                {"data": "miktar"},
                {"data": "litre_fiyati"},
                {"data": "tutar"},
                {"data": "yakit_tipi"},
                {"data": "istasyon_adi"},
                {"data": "son_km"},
                {"data": "alinan_km"},
                {"data": "fark_km"},
                {"data": "aciklama"},
                {"data": "islem"}
            ],
            createdRow: function (new_row,) {
                $(new_row).find('td').css('text-align', 'left');
                $(new_row).find("td").eq(9).css("text-align", "right");
                $(new_row).find("td").eq(10).css("text-align", "right");
                $(new_row).find("td").eq(11).css("text-align", "right");
                $(new_row).find("td").eq(14).css("text-align", "right");
                $(new_row).find("td").eq(15).css("text-align", "right");
                $(new_row).find("td").eq(16).css("text-align", "right");
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        });

        $.get("controller/arac_controller/sql.php?islem=tum_yakit_cikis_fislerini_getir_sql", function (result) {
            var json = JSON.parse(result);
            table.rows.add(json).draw(false);
        });

    });

    $("body").off("click", ".binek_yakit_alim_guncelle").on("click", ".binek_yakit_alim_guncelle", function () {
        let id = $(this).attr("data-id");
        $.get("modals/arac_modal/yakit_alim_modal.php?islem=yakit_alim_guncelle_modal", {id: id}, function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        });
    })

    $("body").off("click", ".binek_yakit_alim_sil_button").on("click", ".binek_yakit_alim_sil_button", function () {
        let closest = $(this).closest("tr");
        var id = $(this).attr("data-id");
        if ($(closest).find("td").eq(19).text() == "Fiş Faturalandı") {
            Swal.fire(
                "Uyarı!",
                "Bu Yakıt Fişi Faturalanmıştır Lütfen Önce Faturayı Siliniz...",
                "warning"
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
                        url: "controller/arac_controller/sql.php?islem=yakit_cikis_fisi_sil_sql",
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
                                        'Cariye Ait Hareket Bulunmaktadır Lütfen Öncelikli Olarak Hareketleri Siliniz...',
                                        'warning'
                                    );
                                } else {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Yakıt Fişi Silindi',
                                        'success'
                                    );
                                    $.get("view/yakit_alim_fisleri.php", function (getList) {
                                        $(".modal-icerik").html("");
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("view/yakit_alim_fisleri.php", function (getList) {
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
</script>