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
            <div class="ibox-title" style=' font-weight:bold;'>YAKIT ÇIKIŞ FİŞLERİ</div>
        </div>
        <div class="col-12 row">
            <div class="mx-2">
                <button class="btn btn-success btn-sm" id="araclara_yakit_cikisi"><i class=""></i> Yakıt Çıkışı</button>
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
                    <th>Tarih</th>
                    <th>Forklift / Kalmar</th>
                    <th>Sürücü</th>
                    <th>Fiş No</th>
                    <th>Miktar</th>
                    <th>Litre Fiyat</th>
                    <th>Tutar</th>
                    <th>Yakıt Tipi</th>
                    <th>İstasyon Adı</th>
                    <th>Araç Tipi</th>
                    <th>Son Saat</th>
                    <th>Alınan Saat</th>
                    <th>Fark Saat</th>
                    <th>Fatura No</th>
                    <th>Fatura Tarihi</th>
                    <th>Durum</th>
                    <th>İşlem</th>
                </tr>
                </thead>
                <tfoot style="background-color: white">
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align: right" class="miktar_tot">0,00</th>
                <th></th>
                <th style="text-align: right" class="tutar_tot">0,00</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th class="fark_tot" style="text-align: right">0</th>
                <th></th>
                <th></th>
                <th></th>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<script>

    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });

    $("body").off("click", "#konteyner_sefer_irsaliye_olustur_button").on("click", "#konteyner_sefer_irsaliye_olustur_button", function () {
        $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=yeni_sefer_irsaliyesi_olustur_modal_getir", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        });
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
            "order": [[1, 'desc']],
            columnDefs: [
                {targets: 1, type: "date-eu"}
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "ÖZ MAL YAKIT ÇIKIŞ FİŞLERİ",
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
                {"data": "alim_yeri"},
                {"data": "tarih"},
                {"data": "arac_adi"},
                {"data": "surucu_adi"},
                {"data": "fis_no"},
                {"data": "miktar"},
                {"data": "litre_fiyat"},
                {"data": "tutar"},
                {"data": "yakit_tipi"},
                {"data": "istasyon_adi"},
                {"data": "arac_tipi"},
                {"data": "son_alinan_saat"},
                {"data": "yakit_alim_saat"},
                {"data": "fark_saat"},
                {"data": "fatura_no"},
                {"data": "fatura_tarihi"},
                {"data": "durum"},
                {"data": "islem"}
            ],
            createdRow: function (new_row, data) {
                $(new_row).find('td').css('text-align', 'left');
                $(new_row).find("td").eq(5).css("text-align", "right");
                $(new_row).find("td").eq(6).css("text-align", "right");
                $(new_row).find("td").eq(7).css("text-align", "right");
                $(new_row).find("td").eq(11).css("text-align", "right");
                $(new_row).find("td").eq(12).css("text-align", "right");
                $(new_row).find("td").eq(13).css("text-align", "right");
                if (data.durum == "Fiş Faturalandı") {
                    $(new_row).css("background-color", "#DDF7E3");
                    $(new_row).css("color", "gray");
                    $(new_row).find("td").css("background-color", "#DDF7E3");
                }
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        });

        $.get("depo/controller/yakit_controller/sql.php?islem=yakit_fislerini_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                $(".miktar_tot").html(json[0]["miktar_tot"]);
                $(".tutar_tot").html(json[0]["tutar_tot"]);
                $(".fark_tot").html(json[0]["fark_tot"]);
                table.rows.add(json).draw(false);
            }
        })

    });

    $("body").off("click", ".depo_yakit_fisleri_guncelle_button").on("click", ".depo_yakit_fisleri_guncelle_button", function () {
        let id = $(this).attr("data-id");
        $.get("depo/modals/yakit_modal/araclara_yakit_cik.php?islem=depo_araclarina_yakit_cikis_guncelle", {id: id}, function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        });
    })

    $("body").off("click", ".depo_yakit_sil_button").on("click", ".depo_yakit_sil_button", function () {
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
                        url: "depo/controller/yakit_controller/sql.php?islem=yakit_cikis_fisi_sil_sql",
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
                                    $.get("depo/view/depo_yakit_islemleri.php", function (getList) {
                                        $(".modal-icerik").html("");
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("depo/view/depo_yakit_islemleri.php", function (getList) {
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

    $("body").off("click", "#araclara_yakit_cikisi").on("click", "#araclara_yakit_cikisi", function () {
        $.get("depo/modals/yakit_modal/araclara_yakit_cik.php?islem=depo_araclarina_yakit_cikis", function (getModal) {
            $(".getModals").html(getModal);
        })
    })

</script>