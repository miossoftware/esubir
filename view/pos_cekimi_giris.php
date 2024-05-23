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
        <div class="ibox-title" style=' font-weight:bold;'>POS ÇEKİMİ</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="yeni_pos_islemi_main_button"><i class="fa fa-plus"></i> Yeni Pos
                İşlemi
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
                    <th>POS Banka</th>
                    <th>Tutar</th>
                    <th>Tahsil Edilen Tutar</th>
                    <th>Kalan Tutar</th>
                    <th>Tahsil Tarihi</th>
                    <th>Açıklama</th>
                    <th style="width: 0% !important;">İşlem</th>
                </tr>
                </thead>
                <tfoot style="background-color: white">
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align: right" class="pc_toplam">0,00</th>
                <th style="text-align: right" class="pc_tahsil_edilen">0,00</th>
                <th style="text-align: right" class="pc_kalan_tutar">0,00</th>
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
                    title: "POS ÇEKİM LİSTESİ",
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
                {"data": "tahsil_edilen_tutar"},
                {"data": "kalan_tutar"},
                {"data": "tahsil_tarihi"},
                {"data": "aciklama"},
                {"data": "button"},
            ],
            createdRow: function (row) {
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

        $.get("controller/pos_controller/sql.php?islem=pos_cekimlerini_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                var basilacak_arr = [];
                let pc_toplam = 0;
                let pc_tahsil_edilen = 0;
                let pc_kalan_tutar = 0;

                json.forEach(function (item) {
                    let tarih = item.tarih;
                    tarih = tarih.split(" ");
                    tarih = tarih[0];
                    tarih = tarih.split("-");
                    let gun = tarih[2];
                    let ay = tarih[1];
                    let yil = tarih[0];
                    let arr = [gun, ay, yil];
                    tarih = arr.join("/");

                    let tahsil_tarihi = item.tahsil_tarihi;
                    tahsil_tarihi = tahsil_tarihi.split(" ");
                    tahsil_tarihi = tahsil_tarihi[0];
                    tahsil_tarihi = tahsil_tarihi.split("-");
                    let gun1 = tahsil_tarihi[2];
                    let ay1 = tahsil_tarihi[1];
                    let yil1 = tahsil_tarihi[0];
                    let arr1 = [gun1, ay1, yil1];
                    tahsil_tarihi = arr1.join("/");

                    let tutar = item.tutar;
                    tutar = parseFloat(tutar);
                    pc_toplam += tutar;

                    let miktari = item.toplam_tahsil_miktari
                    miktari = parseFloat(miktari);
                    pc_tahsil_edilen += miktari;
                    let kalan_tutar = tutar - miktari;
                    pc_kalan_tutar += kalan_tutar;

                    tutar = tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                    kalan_tutar = kalan_tutar.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });
                    miktari = miktari.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});

                    let newRow = {
                        'tarih': tarih,
                        'cari_adi': item.cari_adi,
                        'cari_kodu': item.cari_kodu,
                        'banka_adi': item.banka_adi,
                        'tutar': tutar,
                        'tahsil_edilen_tutar': miktari,
                        'kalan_tutar': kalan_tutar,
                        'tahsil_tarihi': tahsil_tarihi,
                        'aciklama': item.aciklama,
                        'button': "<button class='btn btn-danger btn-sm pos_cekim_islemi_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                    };
                    basilacak_arr.push(newRow);
                })
                $(".pc_toplam").html(pc_toplam.toLocaleString("tr-TR",{maximumFractionDigits:2,minimumFractionDigits:2}));
                $(".pc_tahsil_edilen").html(pc_tahsil_edilen.toLocaleString("tr-TR",{maximumFractionDigits:2,minimumFractionDigits:2}));
                $(".pc_kalan_tutar").html(pc_kalan_tutar.toLocaleString("tr-TR",{maximumFractionDigits:2,minimumFractionDigits:2}));
                table.rows.add(basilacak_arr).draw(false);
            }
        })
    });

    $("body").off("click", "#yeni_pos_islemi_main_button").on("click", "#yeni_pos_islemi_main_button", function () {
        $.get("modals/pos_modal/yeni_pos_cekimi_modal.php?islem=pos_cekim_modal_getir", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".pos_cekim_islemi_sil").on("click", ".pos_cekim_islemi_sil", function () {
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
                        url: "controller/pos_controller/sql.php?islem=pos_cekim_sil_sql",
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
                                        'Bu POS Çekimi Tahsil Edilmiş Silemezsiniz',
                                        'warning'
                                    );
                                } else {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Çekim İşlemi Silindi',
                                        'success'
                                    );
                                    $.get("view/pos_cekimi_giris.php", function (getList) {
                                        $(".modal-icerik").html("");
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("view/pos_cekimi_giris.php", function (getList) {
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