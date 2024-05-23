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
        <div class="ibox-title" style=' font-weight:bold;'>KASA ÖDEME</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="yeni_kasa_odeme_button"><i class="fa fa-plus"></i> Yeni Ödeme
            </button>
            <button class="btn btn-info btn-sm" id="kasa_odeme_filtrele"><i
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
               id="kasa_odeme_table">
            <thead>
            <tr>
                <th>İşlem Tarihi</th>
                <th>Kasa Kodu</th>
                <th>Kasa Adı</th>
                <th>Fiş No</th>
                <th>Açıklama</th>
                <th>Toplam Tutar</th>
                <th>İşlem</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="col-12 row no-gutters mt-1">
        <div class="col-12 row mt-2 no-gutters">
            <div class="col-3"></div>
            <div class="col-md-1">
                <table class="table table-sm table-bordered display" style="background-color: white">
                    <tr>
                        <th>Döviz Türü</th>
                    </tr>
                    <tr>
                        <th>TL</th>
                    </tr>
                    <tr id="usd_gorunum">
                        <th>USD</th>
                    </tr>
                    <tr id="euro_gorunum">
                        <th>EURO</th>
                    </tr>
                    <tr id="gbp_gorunum">
                        <th>GBP</th>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-sm table-bordered w-100 display nowrap" style="background-color: white">
                    <thead>
                    <tr>
                        <th style="text-align: center">Toplam Ödeme</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="tahsilat_tl" style="text-align: right">0,00 TL</td>
                    </tr>
                    <tr>
                        <td class="tahsilat_usd" style="text-align: right">0,00 USD</td>
                    </tr>
                    <tr>
                        <td class="tahsilat_eur" style="text-align: right">0,00 EURO</td>
                    </tr>
                    <tr>
                        <td class="tahsilat_gbp" style="text-align: right">0,00 GBP</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>


    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });

    $("body").off("click", "#yeni_kasa_odeme_button").on("click", "#yeni_kasa_odeme_button", function () {
        $.get("modals/kasa_modal/kasa_odeme_modal.php?islem=yeni_kasa_odeme_fisi_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

    $(document).ready(function () {
        var targetColumns = [5];
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
        var table = $('#kasa_odeme_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            "order": [[0, 'desc']],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "KASA ÖDEME LİSTESİ",
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
            createdRow: function (row, data, dataIndex) {
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        })

        $.get("controller/kasa_controller/sql.php?islem=odeme_fisleri_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                let tahsilat_tl = 0;
                let tahsilat_usd = 0;
                let tahsilat_gbp = 0;
                let tahsilat_euro = 0;
                json.forEach(function (item) {
                    var islemTarihi = item.islem_tarihi;
                    var explode = islemTarihi.split(" ");
                    var explode_cikti = explode[0];
                    var explode_2 = explode_cikti.split("-");
                    var gun = explode_2[2];
                    var ay = explode_2[1];
                    var yil = explode_2[0];
                    var arr = [gun, ay, yil];
                    var islem_tarihi = arr.join("/");

                    var tahsilat_toplam = item.odeme_toplam;
                    tahsilat_toplam = parseFloat(tahsilat_toplam);
                    if (item.doviz_turu == "TL") {
                        tahsilat_tl += tahsilat_toplam;
                    } else if (item.doviz_turu == "USD") {
                        tahsilat_usd += tahsilat_toplam;
                    } else if (item.doviz_turu == "GBP") {
                        tahsilat_gbp += tahsilat_toplam;
                    } else {
                        tahsilat_euro += tahsilat_toplam;
                    }
                    tahsilat_toplam = tahsilat_toplam.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    var new_row = table.row.add([islem_tarihi, item.kasa_kodu, item.kasa_adi, item.belge_no, item.aciklama, tahsilat_toplam + " " + item.doviz_turu, "<button style='background-color: #F6FA70' class='btn btn-sm odeme_guncelle' data-id='" + item.id + "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm odeme_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                    $(new_row).find('td').eq(0).css('text-align', 'left');
                    $(new_row).find('td').eq(1).css('text-align', 'left');
                    $(new_row).find('td').eq(2).css('text-align', 'left');
                    $(new_row).find('td').eq(3).css('text-align', 'left');
                    $(new_row).find('td').eq(4).css('text-align', 'left');
                    $(new_row).find('td').eq(6).css('text-align', 'left');
                });
                tahsilat_tl = tahsilat_tl.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                tahsilat_usd = tahsilat_usd.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                tahsilat_euro = tahsilat_euro.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                tahsilat_gbp = tahsilat_gbp.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                if (tahsilat_gbp == "0,00") {
                    $(".tahsilat_gbp").css("display", "none");
                    $("#gbp_gorunum").css("display", "none");
                }
                if (tahsilat_usd == "0,00") {
                    $(".tahsilat_usd").css("display", "none");
                    $("#usd_gorunum").css("display", "none");
                }
                if (tahsilat_euro == "0,00") {
                    $(".tahsilat_eur").css("display", "none");
                    $("#euro_gorunum").css("display", "none");
                }
                $(".tahsilat_tl").html("");
                $(".tahsilat_tl").html(tahsilat_tl + " TL");
                $(".tahsilat_eur").html("");
                $(".tahsilat_eur").html(tahsilat_euro + " TL");
                $(".tahsilat_usd").html("");
                $(".tahsilat_usd").html(tahsilat_usd + " TL");
                $(".tahsilat_gbp").html("");
                $(".tahsilat_gbp").html(tahsilat_gbp + " TL");
            }
        })

        $("body").off("click", "#kasa_odeme_filtrele").on("click", "#kasa_odeme_filtrele", function () {
            let bas_tarih = $(".bas_tarih_odeme").val();
            let bit_tarih = $(".bit_tarih_odeme").val();
            $.get("controller/kasa_controller/sql.php?islem=odeme_fisleri_getir_sql",
                {
                    bas_tarih: bas_tarih,
                    bit_tarih: bit_tarih
                }
                , function (result) {
                    table.clear().draw(false);
                    if (result != 2) {
                        var json = JSON.parse(result);
                        let tahsilat_tl = 0;
                        let tahsilat_usd = 0;
                        let tahsilat_gbp = 0;
                        let tahsilat_euro = 0;
                        json.forEach(function (item) {
                            var islemTarihi = item.islem_tarihi;
                            var explode = islemTarihi.split(" ");
                            var explode_cikti = explode[0];
                            var explode_2 = explode_cikti.split("-");
                            var gun = explode_2[2];
                            var ay = explode_2[1];
                            var yil = explode_2[0];
                            var arr = [gun, ay, yil];
                            var islem_tarihi = arr.join("/");

                            var tahsilat_toplam = item.odeme_toplam;
                            tahsilat_toplam = parseFloat(tahsilat_toplam);
                            if (item.doviz_turu == "TL") {
                                tahsilat_tl += tahsilat_toplam;
                            } else if (item.doviz_turu == "USD") {
                                tahsilat_usd += tahsilat_toplam;
                            } else if (item.doviz_turu == "GBP") {
                                tahsilat_gbp += tahsilat_toplam;
                            } else {
                                tahsilat_euro += tahsilat_toplam;
                            }
                            tahsilat_toplam = tahsilat_toplam.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });

                            var new_row = table.row.add([islem_tarihi, item.kasa_kodu, item.kasa_adi, item.belge_no, item.aciklama, tahsilat_toplam + " " + item.doviz_turu, "<button style='background-color: #F6FA70' class='btn btn-sm odeme_guncelle' data-id='" + item.id + "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm odeme_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                            $(new_row).find('td').eq(0).css('text-align', 'left');
                            $(new_row).find('td').eq(1).css('text-align', 'left');
                            $(new_row).find('td').eq(2).css('text-align', 'left');
                            $(new_row).find('td').eq(3).css('text-align', 'left');
                            $(new_row).find('td').eq(4).css('text-align', 'left');
                            $(new_row).find('td').eq(6).css('text-align', 'left');
                        });
                        tahsilat_tl = tahsilat_tl.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        tahsilat_usd = tahsilat_usd.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        tahsilat_euro = tahsilat_euro.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        tahsilat_gbp = tahsilat_gbp.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        if (tahsilat_gbp == "0,00") {
                            $(".tahsilat_gbp").css("display", "none");
                            $("#gbp_gorunum").css("display", "none");
                        }
                        if (tahsilat_usd == "0,00") {
                            $(".tahsilat_usd").css("display", "none");
                            $("#usd_gorunum").css("display", "none");
                        }
                        if (tahsilat_euro == "0,00") {
                            $(".tahsilat_eur").css("display", "none");
                            $("#euro_gorunum").css("display", "none");
                        }
                        $(".tahsilat_tl").html("");
                        $(".tahsilat_tl").html(tahsilat_tl + " TL");
                        $(".tahsilat_eur").html("");
                        $(".tahsilat_eur").html(tahsilat_euro + " TL");
                        $(".tahsilat_usd").html("");
                        $(".tahsilat_usd").html(tahsilat_usd + " TL");
                        $(".tahsilat_gbp").html("");
                        $(".tahsilat_gbp").html(tahsilat_gbp + " TL");
                    }
                })
        });

        $("body").off("click", ".odeme_guncelle").on("click", ".odeme_guncelle", function () {
            var id = $(this).attr("data-id");
            $.get("modals/kasa_modal/odeme_page.php?islem=odeme_bilgileri_guncelle", {id: id}, function (getModal) {
                $(".getModals").html("");
                $(".getModals").html(getModal);
            })
        });

        $("body").off("click", ".odeme_sil").on("click", ".odeme_sil", function () {
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
                            url: "controller/kasa_controller/sql.php?islem=odeme_iptal_et_main_sql",
                            type: "POST",
                            data: {
                                id: id,
                                delete_detail: delete_detail
                            },
                            success: function (result) {
                                if (result == 1) {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Ödeme Fişi Silindi',
                                        'success'
                                    );
                                    $.get("view/kasa_odeme.php", function (getList) {
                                        $(".modal-icerik").html("");
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("view/kasa_odeme.php", function (getList) {
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