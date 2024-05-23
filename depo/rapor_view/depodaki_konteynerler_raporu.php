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
        <div class="ibox-title" style=' font-weight:bold;'>DEPODA BULUNAN KONTEYNERLER</div>
    </div>
    <div class="col-12 row tetikle">
        <div class="col-12 row mt-5">
            <table class="table table-sm table-bordered w-100  nowrap datatable"
                   style="cursor:pointer;font-size: 13px;"
                   id="alis_fatura_table">
                <thead>
                <tr>
                    <th>Giriş Tarihi</th>
                    <th>Taşıma Tipi</th>
                    <th>Boş / Dolu</th>
                    <th>Depo Firma Adı</th>
                    <th>Konteyner No</th>
                    <th>Firma Adı</th>
                    <th>Acente Adı</th>
                    <th>Tipi</th>
                    <th>Plaka No</th>
                    <th>Plaka Cari</th>
                    <th>Ardiye Giriş Tarihi</th>
                    <th>CUT OFF Tarihi</th>
                    <th>Demoraj Tarihi</th>
                    <th>Açıklama</th>
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
    $('.tetikle').on('keydown', function (event) {
        if (event.keyCode === 13) {
            $("#alis_fatura_filtrele").click();
        }
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
        var table = $('#alis_fatura_table').DataTable({
            scrollX: true,
            scrollY: '45vh',
            "paging": false,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "DEPODA BULUNAN KONTEYNERLER LİSTESİ",
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
                {"data": "giris_tarihi"},
                {"data": "tasima_tipi"},
                {"data": "bos_dolu"},
                {"data": "depo_firma_adi"},
                {"data": "konteyner_no"},
                {"data": "firma_adi"},
                {"data": "acente_adi"},
                {"data": "tipi"},
                {"data": "plaka_no"},
                {"data": "plaka_cari"},
                {"data": "ardiye_giris_tarihi"},
                {"data": "cut_off_tarihi"},
                {"data": "demoraj_tarihi"},
                {"data": "aciklama"}
            ],
            columnDefs: [
                {targets: 2, type: "date-eu"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find('td').eq(15).css('text-align', 'right');
                $(row).find('td').eq(14).css('text-align', 'right');
                $(row).find('td').eq(17).css('text-align', 'right');
                $(row).find("td").css("text-transform", "uppercase")
            },
            "rowCallback": function (row) {
            },
            order: [[2, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        $.get("depo/controller/acente_controller/sql.php?islem=depoda_bulunan_konteynerleri_getir_sql", function (res) {
            if (res != 2) {
                let json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        })

    });

    $("body").off("click", ".depo_giris_guncelle_button").on("click", ".depo_giris_guncelle_button", function () {
        let id = $(this).attr("data-id");
        $.get("depo/modals/nakliye_depolama_modal/depo_giris_page.php?islem=depo_giris_guncelle_modal", {id: id}, function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        });
    });


    $("body").off("click", "#depolama_hizmeti_ekle_button").on("click", "#depolama_hizmeti_ekle_button", function () {
        $.get("depo/modals/nakliye_depolama_modal/nakliye_depolama.php?islem=nakliyeci_depolama_hizmetleri_getir", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".girisi_yapilan_konteyner_sil_button").on("click", ".girisi_yapilan_konteyner_sil_button", function () {
        var id = $(this).attr("data-id");
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Kaydı seçiniz',
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
                        url: "depo/controller/nakliye_controller/sql.php?islem=depodan_giris_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Konteyner Depodan Silindi',
                                    'success'
                                );
                                $.get("depo/view/nakliye_depolama_islemleri.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("depo/view/nakliye_depolama_islemleri.php", function (getList) {
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