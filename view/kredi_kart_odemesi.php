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
        <div class="ibox-title" style=' font-weight:bold;'>KREDİ KART ÖDEMESİ</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="yeni_kart_ode_main_button"><i class="fa fa-plus"></i> Yeni Kart
                Ödeme
            </button>
            <button class="btn btn-info btn-sm" id="cek_senet_cikis_hazirla_buton"><i
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
                    <th>Tarih</th>
                    <th>Hesap Adı</th>
                    <th>Hesap Kodu</th>
                    <th>Kart Adı</th>
                    <th>Ödeme Tutarı</th>
                    <th>Açıklama</th>
                    <th style="width: 0% !important;">İşlem</th>
                </tr>
                </thead>
                <tfoot style="background-color: white">
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align: right" class="toplam_geri_odeme">0,00</th>
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
    $(document).ready(function () {
        var targetColumns = [4];
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
            "order": [[0, 'desc']],
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
                {"data": "tarih"},
                {"data": "hesap_adi"},
                {"data": "hesap_kodu"},
                {"data": "banka_adi"},
                {"data": "tutar"},
                {"data": "aciklama"},
                {"data": "button"},
            ],
            createdRow: function (new_row) {
                $(new_row).find('td').eq(0).css('text-align', 'left');
                $(new_row).find('td').eq(1).css('text-align', 'left');
                $(new_row).find('td').eq(2).css('text-align', 'left');
                $(new_row).find('td').eq(3).css('text-align', 'left');
                $(new_row).find('td').eq(7).css('text-align', 'left');
                $(new_row).find('td').eq(8).css('text-align', 'left');
                $(new_row).find('td').eq(5).css('text-align', 'left');
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        })

        $.get("controller/kart_controller/sql.php?islem=karttan_odenenleri_getir", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                var basilacak_arr = [];
                let toplam_geri_odeme = 0;
                json.forEach(function (item) {
                    let tarih = item.islem_tarihi;
                    tarih = tarih.split(" ");
                    tarih = tarih[0];
                    tarih = tarih.split("-");
                    let gun = tarih[2];
                    let ay = tarih[1];
                    let yil = tarih[0];
                    let arr = [gun, ay, yil];
                    tarih = arr.join("/");

                    let tutar = item.tutar;
                    tutar = parseFloat(tutar);
                    toplam_geri_odeme += tutar;
                    tutar = tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    let newRow = {
                        "tarih": tarih,
                        'hesap_adi': item.hesap_adi,
                        'hesap_kodu': item.hesap_kodu,
                        'banka_adi': item.kart_adi,
                        'tutar': tutar,
                        'aciklama': item.aciklama,
                        'button': "<button class='btn btn-danger btn-sm odemeyi_iptal_et_sql' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                    };
                    basilacak_arr.push(newRow);
                });
                $(".toplam_geri_odeme").html(toplam_geri_odeme.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }))
                table.rows.add(basilacak_arr).draw(false);
            }
        })

    });

    $("body").off("click", ".odemeyi_iptal_et_sql").on("click", ".odemeyi_iptal_et_sql", function () {
        let cari_kodu = $(this).attr("data-id");
        if (cari_kodu == "" || cari_kodu == undefined) {
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
                        url: "controller/kart_controller/sql.php?islem=kart_odemesini_iptal_et_sql",
                        type: "POST",
                        data: {
                            id: cari_kodu,
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
                                        'Ödeme Silindi',
                                        'success'
                                    );
                                    $.get("view/kredi_kart_odemesi.php", function (getList) {
                                        $(".modal-icerik").html("");
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("view/kredi_kart_odemesi.php", function (getList) {
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

    $("body").off("click", "#yeni_kart_ode_main_button").on("click", "#yeni_kart_ode_main_button", function () {
        $.get("modals/kredi_kart_modal/kredi_kartini_ode_modal.php?islem=kredi_kartini_ode_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

</script>