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
        <div class="ibox-title" style=' font-weight:bold;'>YENİ KREDİ KULLANIMI</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="yeni_kredi_kullan_button"><i class="fa fa-plus"></i> Yeni Kredi
                Ekle
            </button>
            <button class="btn btn-info btn-sm" id=""><i
                        class="fa fa-filter"></i> Hazırla
            </button>
        </div>
        <div class="col-12 row">
            <div class="col-12 row mx-1 mt-3">
                <div class="col-md-3 row">
                    <input type="text" placeholder="Başlangıç Tarihi" id="bas_tarih_cek_senet"
                           onfocus="(this.type='date')"
                           class="form-control form-control-sm">
                    <input type="text" placeholder="Bitiş Tarihi" id="bit_tarih_cek_senet" onfocus="(this.type='date')"
                           class="form-control form-control-sm mt-2">
                </div>
            </div>
        </div>
        <div class="col-12 row mt-3">
            <table class="table table-sm table-bordered w-100 nowrap" style="cursor:pointer;font-size: 13px;"
                   id="cek_senet_tahsil_table">
                <thead>
                <tr>
                    <th>Kredi Kodu</th>
                    <th>Kullanım Tarihi</th>
                    <th>İlk Ödeme Tarihi</th>
                    <th>Kullanım Nedeni</th>
                    <th>Banka Adı</th>
                    <th>Kredi Tutarı</th>
                    <th>Geri Ödenmiş Tutar</th>
                    <th>Kalan Tutar</th>
                    <th>Toplam Geri Ödeme</th>
                    <th>Faiz Oranı</th>
                    <th>Açıklama</th>
                    <th style="width: 0% !important;">İşlem</th>
                </tr>
                </thead>
<!--                <tfoot style="background-color: white">  DEVAM EDİLECEK-->
<!--                <th></th>-->
<!--                <th></th>-->
<!--                <th></th>-->
<!--                <th></th>-->
<!--                <th></th>-->
<!--                <th style="text-align: right" class="k_tot">0,00</th>-->
<!--                <th style="text-align: right" class="go_tot">0,00</th>-->
<!--                <th style="text-align: right" class="k_tot">0,00</th>-->
<!--                <th style="text-align: right" class="tgo_tot">0,00</th>-->
<!--                <th></th>-->
<!--                <th></th>-->
<!--                <th></th>-->
<!--                </tfoot>-->
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var targetColumns = [5, 6, 7, 8, 9, 10];
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
        var table = $('#cek_senet_tahsil_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            "order": [[1, 'desc']],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "Kredi Kart Ödemesi",
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
            columnDefs: [
                {targets: 0, type: "date-eu"}
            ],
            columns: [
                {"data": "kredi_kodu"},
                {"data": "kullanim_tarihi"},
                {"data": "ilk_odeme_tarih"},
                {"data": "kullanim_nedeni"},
                {"data": "banka_adi"},
                {"data": "kredi_tutari"},
                {"data": "geri_odenmis_tutar"},
                {"data": "kalan_tutar"},
                {"data": "toplam_geri_odeme"},
                {"data": "faiz_orani"},
                {"data": "aciklama"},
                {"data": "button"}
            ],
            createdRow: function (new_row) {
                $(new_row).find('td').eq(0).css('text-align', 'left');
                $(new_row).find('td').eq(1).css('text-align', 'left');
                $(new_row).find('td').eq(2).css('text-align', 'left');
                $(new_row).find('td').eq(3).css('text-align', 'left');
                $(new_row).find('td').eq(4).css('text-align', 'left');
                $(new_row).find('td').eq(10).css('text-align', 'left');
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        });

        $.get("controller/kredi_controller/sql.php?islem=kullanilan_kredileri_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        })


        $("body").off("click", "#yeni_kredi_kullan_button").on("click", "#yeni_kredi_kullan_button", function () {
            $.get("modals/kredi_modal/yeni_kredi_kullan.php?islem=yeni_kredi_kullan_modal", function (getModal) {
                $(".getModals").html(getModal);
            })
        });
    });

    $("body").off("click", ".kullanilan_kredi_sil_main_button").on("click", ".kullanilan_kredi_sil_main_button", function () {
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
                        url: "controller/kredi_controller/sql.php?islem=kullanilan_kredi_sil_sql",
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
                                        'Krediye Ait Ödeme Bulunmaktadır Lütfen Önce Ödemeyi Siliniz',
                                        'warning'
                                    );
                                } else {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Kredi Başarı İle Silindi',
                                        'success'
                                    );
                                    $.get("view/yeni_kredi_kullanimi.php", function (getList) {
                                        $(".modal-icerik").html("");
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("view/yeni_kredi_kullanimi.php", function (getList) {
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