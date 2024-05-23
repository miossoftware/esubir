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
        <div class="ibox-title" style=' font-weight:bold;'>GİDER FATURALARI</div>
    </div>
    <div class="col-12 row">
        <div class="col-12 row">
            <div class="mx-2">
                <button class="btn btn-success btn-sm" id="yeni_muhasebe_gider_button"><i class="fa fa-plus"></i> Yeni
                    Gider Ekle
                </button>
                <button class="btn btn-info btn-sm" id=""><i
                            class="fa fa-filter"></i> Hazırla
                </button>
            </div>
            <div class="col-12 row">
                <div class="col-12 row mx-1 mt-3">
                    <div class="col-md-3 row">

                        <input type="text" placeholder="Başlangıç Tarihi" id="bas_tarih" onfocus="(this.type='date')"
                               class="form-control form-control-sm bas_tarih_odeme">
                        <input type="text" placeholder="Bitiş Tarihi" id="bit_tarih" onfocus="(this.type='date')"
                               class="form-control form-control-sm mt-2 bit_tarih_odeme">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 row mt-3">
            <table class="table table-sm table-bordered w-100  nowrap" style="cursor:pointer;font-size: 13px;"
                   id="muhasebe_gider_faturalari_list">
                <thead>
                <tr>
                    <th>Fatura Tarihi</th>
                    <th>Fatura No</th>
                    <th>Cari Kodu</th>
                    <th>Cari Adı</th>
                    <th>Toplam Tutar</th>
                    <th>Açıklama</th>
                    <th>İşlem</th>
                </tr>
                </thead>
                <tfoot style="background-color: white">
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align: right" class="mb_toplam_tutar">0,00</th>
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

    $("body").off("click", "#yeni_muhasebe_gider_button").on("click", "#yeni_muhasebe_gider_button", function () {
        $.get("modals/muhasebe_gider/modal.php?islem=yeni_gider_ekle_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
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
        var targetColumns = [4];
        var table = $('#muhasebe_gider_faturalari_list').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            bAutoWidth: false,
            "order": [[0, 'desc']],
            columnDefs: [
                {targets: 0, type: "date-eu"}
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "GİDER FATURALARI",
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
                {"data": "fatura_tarihi"},
                {"data": "fatura_no"},
                {"data": "cari_kodu"},
                {"data": "cari_adi"},
                {"data": "toplam_tutar"},
                {"data": "aciklama"},
                {"data": "button"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find("td").eq(4).css("text-align", "right");
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        })

        $.get("controller/gider_controller/sql.php?islem=tum_gideleri_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                var basilacak_arr = [];
                let mb_toplam_tutar = 0;
                json.forEach(function (item) {

                    if ("muhasebe_toplam_tutar" in item) {
                        let toplam_tutar = item.muhasebe_toplam_tutar;
                        toplam_tutar = parseFloat(toplam_tutar);
                        mb_toplam_tutar += mb_toplam_tutar;
                        toplam_tutar = toplam_tutar.toLocaleString("tr-TR", {
                            maximumFractionDigits: 2,
                            minimumFractionDigits: 2
                        });
                        let fatura_tarihi = item.fatura_tarihi;
                        fatura_tarihi = fatura_tarihi.split(" ");
                        fatura_tarihi = fatura_tarihi[0];
                        fatura_tarihi = fatura_tarihi.split("-");
                        let gun = fatura_tarihi[2];
                        let ay = fatura_tarihi[1];
                        let yil = fatura_tarihi[0];
                        let arr = [gun, ay, yil];
                        fatura_tarihi = arr.join("/");
                        let newRow = {
                            fatura_tarihi: fatura_tarihi,
                            fatura_no: item.fatura_no,
                            cari_kodu: item.cari_kodu,
                            cari_adi: item.cari_adi,
                            toplam_tutar: toplam_tutar,
                            aciklama: item.aciklama,
                            button: "<button class='btn btn-sm muhasebe_gider_guncelle_button' style='background-color: #F6FA70' data-id='" + item.id + "'><i class='fa fa-eye'></i></button> <button class='btn btn-danger btn-sm muhasebe_gider_fisi_sil_sql' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                        };
                        basilacak_arr.push(newRow);
                    } else {
                        let fatura_tarihi = item.fatura_tarih;
                        fatura_tarihi = fatura_tarihi.split(" ");
                        fatura_tarihi = fatura_tarihi[0];
                        fatura_tarihi = fatura_tarihi.split("-");
                        let gun = fatura_tarihi[2];
                        let ay = fatura_tarihi[1];
                        let yil = fatura_tarihi[0];
                        let arr = [gun, ay, yil];
                        fatura_tarihi = arr.join("/");

                        let toplam_tutar = item.toplam_tutar;
                        toplam_tutar = parseFloat(toplam_tutar);
                        mb_toplam_tutar += toplam_tutar;
                        toplam_tutar = toplam_tutar.toLocaleString("tr-TR", {
                            maximumFractionDigits: 2,
                            minimumFractionDigits: 2
                        });


                        let newRow = {
                            fatura_tarihi: fatura_tarihi,
                            fatura_no: item.fatura_no,
                            cari_kodu: item.cari_kodu,
                            cari_adi: item.cari_adi,
                            toplam_tutar: toplam_tutar,
                            aciklama: item.aciklama,
                            button: "<button class='btn btn-secondary btn-sm sanayi_detay_button' data-id='" + item.id + "'><i class='fa fa-eye'></i></button> <button class='btn btn-danger btn-sm sanayi_fisi_fatura_main_button' disabled data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                        };
                        basilacak_arr.push(newRow);
                    }
                });
                $(".mb_toplam_tutar").html(mb_toplam_tutar.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }));
                table.rows.add(basilacak_arr).draw(false);
            }
        })

        $("body").off("click", ".muhasebe_gider_guncelle_button").on("click", ".muhasebe_gider_guncelle_button", function () {
            let id = $(this).attr("data-id");
            $.get("modals/muhasebe_gider/modal_page.php?islem=muhasebe_gider_faturasi_guncelle_modal", {id: id}, function (getModal) {
                $(".getModals").html("");
                $(".getModals").html(getModal);
            })
        });

        $("body").off("click", ".muhasebe_gider_fisi_sil_sql").on("click", ".muhasebe_gider_fisi_sil_sql", function () {
            let id = $(this).attr("data-id");
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
                            url: "controller/gider_controller/sql.php?islem=muhasebe_gider_sil_sql",
                            type: "POST",
                            data: {
                                id: id,
                                delete_detail: delete_detail
                            },
                            success: function (result) {
                                if (result == 1) {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Gider Faturası Silindi',
                                        'success'
                                    );
                                    $.get("view/muhasebe_gider_faturalari.php", function (getList) {
                                        $(".modal-icerik").html("");
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("view/muhasebe_gider_faturalari.php", function (getList) {
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

        $("body").off("click", ".sanayi_detay_button").on("click", ".sanayi_detay_button", function () {
            let id = $(this).attr("data-id");
            $.get("konteyner/modals/sanayi_modal/sanayi_fatura_detay.php?islem=sanayi_fatura_bilgileri_modal", {id: id}, function (getModal) {
                $(".getModals").html("");
                $(".getModals").html(getModal);
            })
        });

    });

</script>