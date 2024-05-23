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
        <div class="ibox-title" style=' font-weight:bold;'>POS TAHSİLİ</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="yeni_pos_tahsili_main_button"><i class="fa fa-plus"></i> Yeni Pos
                Tahsili
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
            <table class="table table-sm table-bordered w-100  nowrap" style="cursor:pointer;font-size: 13px;"
                   id="cek_senet_tahsil_table">
                <thead>
                <tr>
                    <th>Tarih</th>
                    <th>Cari Adı</th>
                    <th>Cari Kodu</th>
                    <th>Çekilen Pos</th>
                    <th>Tutar</th>
                    <th>Komisyon Tutarı</th>
                    <th>Hesaba Geçen Tutar</th>
                    <th>Açıklama</th>
                    <th style="width: 0% !important;">İşlem</th>
                </tr>
                </thead>
                <tfoot style="background-color: white">
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align: right" class="pc_tahsil_tot">0,00</th>
                <th style="text-align: right" class="pc_komisyon_tot">0,00</th>
                <th style="text-align: right" class="pc_hesap_tot">0,00</th>
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
        var targetColumns = [4, 5, 6];
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
                    title: "POS TAHSİLAT LİSTESİ",
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
                {"data": "cari_adi"},
                {"data": "cari_kodu"},
                {"data": "banka_adi"},
                {"data": "tutar"},
                {"data": "komisyon_tutari"},
                {"data": "hesaba_gecen"},
                {"data": "aciklama"},
                {"data": "button"},
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').eq(0).css('text-align', 'left');
                $(row).find('td').eq(1).css('text-align', 'left');
                $(row).find('td').eq(2).css('text-align', 'left');
                $(row).find('td').eq(3).css('text-align', 'left');
                $(row).find('td').eq(7).css('text-align', 'left');
                $(row).find('td').eq(8).css('text-align', 'left');
                $(row).find('td').eq(9).css('text-align', 'left');

            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        })

        $.get("controller/pos_controller/sql.php?islem=tahsil_edilenleri_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                var basilacak_arr = [];
                let pc_tahsil_tot = 0;
                let pc_komisyon_tot = 0;
                let pc_hesap_tot = 0;

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
                    pc_tahsil_tot += tutar;
                    let komisyon_tutari = item.kesilen_komisyon;
                    komisyon_tutari = parseFloat(komisyon_tutari);
                    pc_komisyon_tot += komisyon_tutari;

                    let hesaba_gecen = tutar - komisyon_tutari;
                    pc_hesap_tot += hesaba_gecen;


                    komisyon_tutari = komisyon_tutari.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    hesaba_gecen = hesaba_gecen.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    tutar = tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    let newRow = {
                        "tarih": tarih,
                        'cari_adi': item.cari_adi,
                        'cari_kodu': item.cari_kodu,
                        'banka_adi': item.banka_adi,
                        'tutar': tutar,
                        'komisyon_tutari': komisyon_tutari,
                        'hesaba_gecen': hesaba_gecen,
                        'aciklama': item.aciklama,
                        'button': "<button class='btn btn-danger btn-sm tahsili_iptal_et_main_button' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                    };
                    basilacak_arr.push(newRow);
                });
                $(".pc_tahsil_tot").html(pc_tahsil_tot.toLocaleString("tr-TR",{minimumFractionDigits:2,maximumFractionDigits:2}));
                $(".pc_komisyon_tot").html(pc_komisyon_tot.toLocaleString("tr-TR",{minimumFractionDigits:2,maximumFractionDigits:2}));
                $(".pc_hesap_tot").html(pc_hesap_tot.toLocaleString("tr-TR",{minimumFractionDigits:2,maximumFractionDigits:2}));
                table.rows.add(basilacak_arr).draw(false);
            }
        })

    });

    $("body").off("click", ".tahsili_iptal_et_main_button").on("click", ".tahsili_iptal_et_main_button", function () {
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
                        url: "controller/pos_controller/sql.php?islem=tahsili_iptal_et_sql",
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
                                        'Tahsil Silindi',
                                        'success'
                                    );
                                    $.get("view/pos_tahsil_main.php", function (getList) {
                                        $(".modal-icerik").html("");
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("view/pos_tahsil_main.php", function (getList) {
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

    $("body").off("click", "#yeni_pos_tahsili_main_button").on("click", "#yeni_pos_tahsili_main_button", function () {
        $.get("modals/pos_modal/pos_tahsil_modal_getir.php?islem=pos_tahsil_modal_getir", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

</script>