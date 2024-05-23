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
        <div class="ibox-title" style=' font-weight:bold;'>SENET TAHSİLAT (GİRİŞ)</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <div class="btn-group" role="group">
                <button id="btnGroupVerticalDrop1" type="button"
                        class="btn btn-success dropdown-toggle btn-sm" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    Senetler Tahsili <i class="fa fa-angle-down arrow"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" id="tahsile_verilen_senet_tahsili" href="#">Tahsile Verilmiş Senet
                        Tahsili</a>
                    <a class="dropdown-item" id="teminata_verilen_senet_tahsili" href="#">Teminata Verilmiş
                        Senet Tahsili</a>
                    <a class="dropdown-item" id="elden_senet_tahsili" href="#">Elden Senet Tahsili</a>
                </div>
            </div>
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
                    <th>Bordro No</th>
                    <th>Banka Adı</th>
                    <th>Bordro Tarih</th>
                    <th>Tutar</th>
                    <th>Döviz</th>
                    <th>Özel Kod</th>
                    <th style="width: 0% !important;">İşlem</th>
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
    $(document).ready(function () {
        var targetColumns = [3];
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
            "order": [[2, 'desc']],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "SENET TAHSİL BORDROLARI",
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
                {targets: 2, type: "date-eu"}
            ],
            columns: [
                {"data": "belge_no"},
                {"data": "banka_adi"},
                {"data": "tarih"},
                {"data": "tutar"},
                {"data": "doviz_tur"},
                {"data": "ozel_kod"},
                {"data": "button"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').eq(0).css('text-align', 'left');
                $(row).find('td').eq(1).css('text-align', 'left');
                $(row).find('td').eq(2).css('text-align', 'left');
                $(row).find('td').eq(4).css('text-align', 'left');
                $(row).find('td').eq(5).css('text-align', 'left');
                $(row).find('td').eq(6).css('text-align', 'left');
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        })

        $.get("controller/senet_controller/sql.php?islem=tum_tahsilatlari_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                var bastirilacak_arr = [];
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
                    let tutar = item.tutar;
                    tutar = parseFloat(tutar);
                    tutar = tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    if (item.banka_adi == "" || item.banka_adi == null) {
                        let newRow = {
                            "belge_no": item.belge_no,
                            "banka_adi": item.kasa_adi,
                            "tarih": tarih,
                            "tutar": tutar,
                            "doviz_tur": item.doviz_tur,
                            "ozel_kod": item.ozel_kod,
                            "button": "<button class='btn btn-danger btn-sm elden_senet_tahsil_sil_button_main' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                        };
                        bastirilacak_arr.push(newRow);
                    } else {
                        let newRow = {
                            "belge_no": item.belge_no,
                            "banka_adi": item.banka_adi,
                            "tarih": tarih,
                            "tutar": tutar,
                            "doviz_tur": item.doviz_tur,
                            "ozel_kod": item.ozel_kod,
                            "button": "<button class='btn btn-danger btn-sm senet_tahsili_sil_button_main' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                        };
                        bastirilacak_arr.push(newRow);
                    }

                });
                table.rows.add(bastirilacak_arr).draw(false);
            }
        })
    });

    $("body").off("click", ".senet_tahsili_sil_button_main").on("click", ".senet_tahsili_sil_button_main", function () {
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
                        url: "controller/senet_controller/sql.php?islem=tahsil_edilen_seneti_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Tahsil Edilen Senet Silindi',
                                    'success'
                                );
                                $.get("view/senet_tahsil.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                });
                                $.get("view/senet_tahsil.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                });
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


    $("body").off("click", ".elden_senet_tahsil_sil_button_main").on("click", ".elden_senet_tahsil_sil_button_main", function () {
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
                        url: "controller/senet_controller/sql.php?islem=elden_cek_tahsil_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Tahsil Edilen Senet Silindi',
                                    'success'
                                );
                                $.get("view/senet_tahsil.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                });
                                $.get("view/senet_tahsil.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                });
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

    $("body").off("click", "#tahsile_verilen_senet_tahsili").on("click", "#tahsile_verilen_senet_tahsili", function () {
        $.get("modals/senet_tahsil/modal.php?islem=senet_tahsil_et_modal_getir", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });
    $("body").off("click", "#teminata_verilen_senet_tahsili").on("click", "#teminata_verilen_senet_tahsili", function () {
        $.get("modals/senet_tahsil/teminata_verilmis_senet_tahsili.php?islem=cek_senet_tahsil_et_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", "#elden_senet_tahsili").on("click", "#elden_senet_tahsili", function () {
        $.get("modals/senet_tahsil/elden_senet_tahsili.php?islem=elden_cek_senet_tahsili_getir_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

</script>