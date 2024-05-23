<div class="ibox-container">
    <div class="ibox mt-5">
        <div class="ibox-head">
            <div class="ibox-title" style=' font-weight:bold;'>PERAKENDE SATIŞLAR</div>
        </div>
        <div class="col-12 row">
            <div class="mx-2">
                <button class="btn btn-success btn-sm" id="perakende_satis_olustur_main_button"><i
                            class="fa fa-plus"></i> Perakende Satış Yap
                </button>
                <button class="btn btn-info btn-sm" id="perakende_satis_filter"><i
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
                   id="perakende_satis_list">
                <thead>
                <tr>
                    <th>Fatura No</th>
                    <th>Fatura Tarihi</th>
                    <th>Tahsil Türü</th>
                    <th>Tahsil Edildiği Yer</th>
                    <th>Depo</th>
                    <th>Müşteri Adı</th>
                    <th>Müşteri Telefon</th>
                    <th>Tutar</th>
                    <th>Açıklama</th>
                    <th>İşlem</th>
                </tr>
                </thead>
                <tfoot style="background-color: white">
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align: right" class="perakende_toplam">0,00 TL</th>
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

    $("body").off("click", "#perakende_satis_olustur_main_button").on("click", "#perakende_satis_olustur_main_button", function () {
        $.get("modals/satis_modal/perakende_satis.php?islem=perakende_satis_yap", function (getModal) {
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
        var table = $("#perakende_satis_list").DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            "order": [[1, 'desc']],
            // dom: 'Bfrtip',
            // buttons: [
            //     {
            //         extend: 'excel',
            //         title: "HAVALE ÇIKIŞ LİSTESİ",
            //         text: "<i class='fa fa-download'></i> Excel'e Aktar",
            //         className: 'excel_alis', // Sınıfı burada tanımlayabilirsiniz
            //         customizeData: function (excelData) {
            //             // Özel veri dönüşümü ve formatlamaları yapabilirsiniz
            //             // excelData, dışa aktarılacak Excel verilerini temsil eder
            //
            //             // Örneğin, her hücreyi sayı olarak biçimlendirme
            //             for (var rowIdx = 0; rowIdx < excelData.body.length; rowIdx++) {
            //                 var rowData = excelData.body[rowIdx];
            //                 for (var cellIdx = 0; cellIdx < rowData.length; cellIdx++) {
            //                     var cellValue = excelData.body[rowIdx][cellIdx];
            //                     if (typeof cellValue === 'string') {
            //                         if (targetColumns.includes(cellIdx)) {
            //                             var parsedValue = parseFloat(cellValue.replace('.', '').replace(',', '.').replace(/\s/g, ''));
            //                             if (!isNaN(parsedValue)) {
            //                                 excelData.body[rowIdx][cellIdx] = parsedValue.toLocaleString("en-US", {
            //                                     maximumFractionDigits: 2,
            //                                     minimumFractionDigits: 2
            //                                 });
            //                             }
            //                         }
            //                     }
            //                 }
            //             }
            //         }
            //     }
            // ],
            columnDefs: [
                {targets: 1, type: "date-eu"}
            ],
            columns: [
                {"data": "fatura_no"},
                {"data": "fatura_tarihi"},
                {"data": "tahsil_turu"},
                {"data": "tahsil_edildigi_yer"},
                {"data": "depo_adi"},
                {"data": "musteri_adi"},
                {"data": "musteri_tel"},
                {"data": "tutar"},
                {"data": "aciklama"},
                {"data": "button"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).addClass("list_selected");
                $(row).find('td').eq(0).css('text-align', 'left');
                $(row).find('td').eq(1).css('text-align', 'left');
                $(row).find('td').eq(2).css('text-align', 'left');
                $(row).find('td').eq(3).css('text-align', 'left');
                $(row).find('td').eq(4).css('text-align', 'left');
                $(row).find('td').eq(5).css('text-align', 'left');
                $(row).find('td').eq(6).css('text-align', 'left');
                $(row).find('td').eq(8).css('text-align', 'left');
                $(row).find('td').eq(9).css('text-align', 'left');

            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        });

        $.get("controller/perakende_controller/sql.php?islem=perakende_satislari_getir_sql", function (response) {
            if (response != 2) {
                var json = JSON.parse(response);
                var basilacak_arr = [];
                let perakende_toplam = 0;
                json.forEach(function (item) {
                    let tahsil_turu = "";
                    let tahsil_edildigi_yer = "";
                    if (item.banka_id != 0) {
                        tahsil_turu = "Banka Havale";
                        tahsil_edildigi_yer = item.banka_adi;

                    } else if (item.kasa_id != 0) {
                        tahsil_turu = "Nakit Ödeme";
                        tahsil_edildigi_yer = item.kasa_adi;
                    } else if (item.pos_id != 0) {
                        tahsil_turu = "POS İle Kart Çekim";
                        tahsil_edildigi_yer = item.pos_banka_adi
                    }

                    let fatura_tarihi = item.fatura_tarihi;
                    fatura_tarihi = fatura_tarihi.split(" ");
                    fatura_tarihi = fatura_tarihi[0];
                    fatura_tarihi = fatura_tarihi.split("-");
                    let gun = fatura_tarihi[2];
                    let ay = fatura_tarihi[1];
                    let yil = fatura_tarihi[0];
                    let arr = [gun, ay, yil];
                    fatura_tarihi = arr.join("/");

                    let tutar = item.toplam_tutar;
                    tutar = parseFloat(tutar);
                    perakende_toplam += tutar;
                    tutar = tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});

                    let newRow = {
                        fatura_no: item.fatura_no,
                        fatura_tarihi: fatura_tarihi,
                        tahsil_turu: tahsil_turu,
                        tahsil_edildigi_yer: tahsil_edildigi_yer,
                        depo_adi: item.depo_adi,
                        musteri_adi: item.musteri_adi,
                        musteri_tel: item.telefon,
                        tutar: tutar,
                        aciklama: item.aciklama,
                        button: "<button class='btn btn-secondary btn-sm perakende_satis_detay_gor_button' data-id='" + item.id + "'><i class='fa fa-eye'></i></button> <button class='btn btn-danger btn-sm perakende_satis_sil_main_button' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                    };
                    basilacak_arr.push(newRow);
                });
                $(".perakende_toplam").html(perakende_toplam.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }));
                table.rows.add(basilacak_arr).draw(false);

            }
        })

        $("body").off("click", "#perakende_satis_filter").on("click", "#perakende_satis_filter", function () {
            let bas_tarih = $("#bas_tarih").val();
            let bit_tarih = $("#bit_tarih").val();
            $.get("controller/perakende_controller/sql.php?islem=perakende_satislari_getir_sql", {
                bas_tarih: bas_tarih,
                bit_tarih: bit_tarih
            }, function (response) {
                if (response != 2) {
                    var json = JSON.parse(response);
                    var basilacak_arr = [];
                    let perakende_toplam = 0;
                    json.forEach(function (item) {
                        let tahsil_turu = "";
                        let tahsil_edildigi_yer = "";
                        if (item.banka_id != 0) {
                            tahsil_turu = "Banka Havale";
                            tahsil_edildigi_yer = item.banka_adi;

                        } else if (item.kasa_id != 0) {
                            tahsil_turu = "Nakit Ödeme";
                            tahsil_edildigi_yer = item.kasa_adi;
                        } else if (item.pos_id != 0) {
                            tahsil_turu = "POS İle Kart Çekim";
                            tahsil_edildigi_yer = item.pos_banka_adi
                        }

                        let fatura_tarihi = item.fatura_tarihi;
                        fatura_tarihi = fatura_tarihi.split(" ");
                        fatura_tarihi = fatura_tarihi[0];
                        fatura_tarihi = fatura_tarihi.split("-");
                        let gun = fatura_tarihi[2];
                        let ay = fatura_tarihi[1];
                        let yil = fatura_tarihi[0];
                        let arr = [gun, ay, yil];
                        fatura_tarihi = arr.join("/");

                        let tutar = item.toplam_tutar;
                        tutar = parseFloat(tutar);
                        perakende_toplam += tutar;
                        tutar = tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});

                        let newRow = {
                            fatura_no: item.fatura_no,
                            fatura_tarihi: fatura_tarihi,
                            tahsil_turu: tahsil_turu,
                            tahsil_edildigi_yer: tahsil_edildigi_yer,
                            depo_adi: item.depo_adi,
                            musteri_adi: item.musteri_adi,
                            musteri_tel: item.telefon,
                            tutar: tutar,
                            aciklama: item.aciklama,
                            button: "<button class='btn btn-secondary btn-sm perakende_satis_detay_gor_button' data-id='" + item.id + "'><i class='fa fa-eye'></i></button> <button class='btn btn-danger btn-sm perakende_satis_sil_main_button' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                        };
                        basilacak_arr.push(newRow);
                    });
                    $(".perakende_toplam").html(perakende_toplam.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }));
                    table.rows.add(basilacak_arr).draw(false);

                }
            })
        });

        $("body").off("click", ".perakende_satis_detay_gor_button").on("click", ".perakende_satis_detay_gor_button", function () {
            let id = $(this).attr("data-id");
            $.get("modals/satis_modal/perakende_detay.php?islem=perakende_detay_getir_modal", {id: id}, function (getModal) {
                $(".getModals").html("");
                $(".getModals").html(getModal);
            })
        });

        $("body").off("click", ".perakende_satis_sil_main_button").on("click", ".perakende_satis_sil_main_button", function () {
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
                            url: "controller/perakende_controller/sql.php?islem=perakende_satis_sil_sql",
                            type: "POST",
                            data: {
                                id: id,
                                delete_detail: delete_detail
                            },
                            success: function (result) {
                                if (result != 2) {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Perakende Satış Silindi',
                                        'success'
                                    );
                                    $.get("view/perakende_satis.php", function (getList) {
                                        $(".modal-icerik").html("");
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("view/perakende_satis.php", function (getList) {
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

    })
</script>