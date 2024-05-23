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
        <div class="ibox-title" style=' font-weight:bold;'>ALIŞ FATURASI</div>
    </div>
    <div class="col-12 row tetikle">
        <div class="col-12 row mx-1 mt-3">
            <div class="col-md-2 row">
                <input type="text" placeholder="Başlangıç Tarihi" id="bas_tarih" onfocus="(this.type='date')"
                       class="form-control form-control-sm bas_tarih_alis">
                <input type="text" placeholder="Bitiş Tarihi" id="bit_tarih" onfocus="(this.type='date')"
                       class="form-control form-control-sm mt-2 bit_tarih_alis">
            </div>
            <div class="col-md-2 row mx-1">
                <select class="custom-select custom-select-sm" id="doviz_tur_filter">
                    <option value="">Döviz Türü</option>
                    <option value="TL">TL</option>
                    <option value="USD">USD</option>
                    <option value="EURO">EURO</option>
                    <option value="GBP">GBP</option>
                </select>
                <input type="text" placeholder="Fatura No" id="fatura_no"
                       class="form-control form-control-sm mt-2">
            </div>
            <div class="col-md-2 row">
                <input type="text" class="form-control form-control-sm" placeholder="Cari Kodu" id="cari_kodu">
                <input type="text" placeholder="Firma Adı" id="cari_adi"
                       class="form-control form-control-sm mt-2">
            </div>
            <div class="col-md-2 row mx-1">
                <input type="text" class="form-control form-control-sm" id="bas_fiyat" placeholder="Başlangıç Fiyat">
                <input type="text" placeholder="Bitiş Fiyat" id="bit_fiyat"
                       class="form-control form-control-sm mt-2">
            </div>
            <div class="col-md-2 row mx-1">
            <textarea style="resize: none" class="form-control form-control-sm" id="aciklama" placeholder="Açıklama"
                      cols="30" rows="2"></textarea>
            </div>
            <div class="col-md-2 row">
                <button class="btn btn-success btn-sm" id="alis_fatura_olustur_main"><i class="fa fa-plus"></i> Fatura
                    Oluştur
                </button>
                <button class="btn btn-info btn-sm" id="alis_fatura_filtrele"><i
                            class="fa fa-filter"></i> Filtrele
                </button>
            </div>
        </div>
        <div class="col-12 row mt-5">
            <table class="table table-sm table-bordered w-100  nowrap datatable"
                   style="cursor:pointer;font-size: 13px;"
                   id="alis_fatura_table">
                <thead>
                <tr>
                    <th>Fatura No</th>
                    <th>Fatura Türü</th>
                    <th>Fatura Tarihi</th>
                    <th>Cari Kodu</th>
                    <th>Firma Adı</th>
                    <th>Mal Tutarı</th>
                    <th>KDV</th>
                    <th>Genel Toplam</th>
                    <th>Döviz Tipi</th>
                    <th>Açıklama</th>
                    <th>Vade Tarihi</th>
                    <th>Döviz Kuru</th>
                    <th>Döviz Mal Tutarı</th>
                    <th>Döviz Mal KDV</th>
                    <th>Doviz Genel Toplam</th>
                    <th>İşlem</th>
                </tr>
                </thead>
            </table>
        </div>
        <div class="col-12 row mt-2 no-gutters">
            <div class="col-3"></div>
            <div class="col-1">
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
                        <th style="text-align: center">Ara Toplam</th>
                        <th style="text-align: center">KDV Toplam</th>
                        <th style="text-align: center">Genel Toplam</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="ara_toplam_tl" style="text-align: right;font-weight: bold">0,00 TL</td>
                        <td class="kdv_toplam_tl" style="text-align: right;font-weight: bold">0,00 TL</td>
                        <td class="genel_toplam_tl" style="text-align: right;font-weight: bold">0,00 TL</td>
                    </tr>
                    <tr>
                        <td class="ara_toplam_usd" style="text-align: right;font-weight: bold">0,00 USD</td>
                        <td class="kdv_toplam_usd" style="text-align: right;font-weight: bold">0,00 USD</td>
                        <td class="genel_toplam_usd" style="text-align: right;font-weight: bold">0,00 USD</td>
                    </tr>
                    <tr>
                        <td class="ara_toplam_euro" style="text-align: right;font-weight: bold">0,00 EURO</td>
                        <td class="kdv_toplam_euro" style="text-align: right;font-weight: bold">0,00 EURO</td>
                        <td class="genel_toplam_euro" style="text-align: right;font-weight: bold">0,00 EURO</td>
                    </tr>
                    <tr>
                        <td class="ara_toplam_gbp" style="text-align: right;font-weight: bold">0,00 GBP</td>
                        <td class="kdv_toplam_gbp" style="text-align: right;font-weight: bold">0,00 GBP</td>
                        <td class="genel_toplam_gbp" style="text-align: right;font-weight: bold">0,00 GBP</td>
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
    $('.tetikle').on('keydown', function (event) {
        if (event.keyCode === 13) {
            $("#alis_fatura_filtrele").click();
        }
    });

    $(document).ready(function () {
        var tl_ara_toplam_main = 0;
        var tl_kdv_toplam_main = 0;
        var tl_genel_toplam_main = 0;

        var usd_ara_toplam_main = 0;
        var usd_kdv_toplam_main = 0;
        var usd_genel_toplam_main = 0;

        var euro_ara_toplam_main = 0;
        var euro_kdv_toplam_main = 0;
        var euro_genel_toplam_main = 0;

        var gbp_ara_toplam_main = 0;
        var gbp_kdv_toplam_main = 0;
        var gbp_genel_toplam_main = 0;

        // jQuery.extend(jQuery.fn.dataTableExt.oSort, {
        //     "date-eu-pre": function (dateString) {
        //         var parts = dateString.split('/');
        //         return Date.parse(parts[2] + '/' + parts[1] + '/' + parts[0]) || 0;
        //     },
        //
        //     "date-eu-asc": function (a, b) {
        //         return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        //     },
        //
        //     "date-eu-desc": function (a, b) {
        //         return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        //     }
        // });
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
        var targetColumns = [5, 6, 7, 12, 13, 14];
        var table = $('#alis_fatura_table').DataTable({
            scrollX: true,
            scrollY: '45vh',
            "info": false,
            "paging": false,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "ALIŞ FATURALARI",
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
            searching: false,
            columns: [
                {"data": "fatura_no"},
                {"data": "fatura_turu_adi"},
                {"data": "fatura_tarihi"},
                {"data": "cari_kodu"},
                {"data": "cari_adi"},
                {"data": "tl_ara_toplam"},
                {"data": "tl_kdv"},
                {"data": "tl_genel_toplam"},
                {"data": "doviz_tur"},
                {"data": "aciklama"},
                {"data": "vade_tarihi"},
                {"data": "doviz_kuru"},
                {"data": "ara_toplam"},
                {"data": "kdv_toplam"},
                {"data": "genel_toplam"},
                {"data": "button"}
            ],
            columnDefs: [
                {targets: 2, type: "date-eu"}
            ],
            createdRow: function (new_row, data, dataIndex) {
                $(new_row).find('td').eq(0).css('text-align', 'left');
                $(new_row).find('td').eq(1).css('text-align', 'left');
                $(new_row).find('td').eq(2).css('text-align', 'left');
                $(new_row).find('td').eq(3).css('text-align', 'left');
                $(new_row).find('td').eq(4).css('text-align', 'left');
                $(new_row).find('td').eq(8).css('text-align', 'left');
                $(new_row).find('td').eq(9).css('text-align', 'left');
                $(new_row).find('td').eq(10).css('text-align', 'left');
                $(new_row).find("td").css("text-transform", "uppercase")
            },
            "rowCallback": function (row) {
                $(row).children().css('background-color', '#DDF7E3');
            },
            order: [[2, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        $.get("controller/alis_controller/sql.php?islem=faturalari_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                let basilacak_arr = [];

                json.forEach(function (item) {
                    let aciklama = item.aciklama;
                    if (aciklama != "" && aciklama.length > 25) {
                        aciklama = aciklama.substring(0, 25) + "...";
                    }
                    var fatura_tarihi = item.fatura_tarihi;
                    if (fatura_tarihi == null) {

                    } else {
                        var explode1 = fatura_tarihi.split(" ");
                        var explode_cikti1 = explode1[0];
                        var explode2 = explode_cikti1.split("-");
                        var gun = explode2[2];
                        var ay = explode2[1];
                        var yil = explode2[0];
                        var arr = [gun, ay, yil];
                        fatura_tarihi = arr.join("/");
                    }


                    var vadeTarihi = item.vade_tarihi;
                    let vade_tarihi_bas = "";
                    if (vadeTarihi == null) {
                        vade_tarihi_bas = vadeTarihi
                    } else {
                        var vadeTarihi_explode = vadeTarihi.split(" ");
                        var explode_cikti3 = vadeTarihi_explode[0];
                        var explode4 = explode_cikti3.split("-");
                        var gun1 = explode4[2];
                        var ay1 = explode4[1];
                        var yil1 = explode4[0];
                        var arr1 = [gun1, ay1, yil1];
                        vade_tarihi_bas = arr1.join("/");

                    }

                    var araToplam = item.ara_toplam;
                    var parse_ara_toplam = parseFloat(araToplam);
                    var ara_toplam = parse_ara_toplam.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })

                    var kdvToplam = item.kdv_toplam;
                    var parse_kdv = parseFloat(kdvToplam);
                    var kdv_toplam = parse_kdv.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })

                    var genelToplam = item.genel_toplam;
                    var parse_genel_toplam = parseFloat(genelToplam);
                    var genel_toplam = parse_genel_toplam.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })
                    var doviz_kuru = "";
                    let fatura_turu = ""
                    if ("doviz_kur" in item) {
                        doviz_kuru = item.doviz_kur;
                        fatura_turu = "Lastik Alış";
                    } else {
                        doviz_kuru = item.doviz_kuru;
                        fatura_turu = item.fatura_turu_adi;
                    }
                    var parse_kur = parseFloat(doviz_kuru);
                    var tl_kdv = parse_kur * item.kdv_toplam;
                    var tl_ara_toplam = parse_kur * item.ara_toplam;
                    var tl_genel_toplam = parse_kur * item.genel_toplam;

                    var tl_kdv_bas = tl_kdv.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })
                    var tl_ara_toplam_bas = tl_ara_toplam.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })
                    var tl_genel_toplam_bas = tl_genel_toplam.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })

                    tl_ara_toplam_main += tl_ara_toplam;
                    tl_kdv_toplam_main += tl_kdv;
                    tl_genel_toplam_main += tl_genel_toplam;

                    var tl_kdv_bas_main = tl_kdv_toplam_main.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })

                    var tl_ara_toplam_bas_main = tl_ara_toplam_main.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })

                    var tl_genel_toplam_bas_main = tl_genel_toplam_main.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })


                    $(".ara_toplam_tl").html("");
                    $(".ara_toplam_tl").html(tl_ara_toplam_bas_main + " TL");
                    $(".kdv_toplam_tl").html("");
                    $(".kdv_toplam_tl").html(tl_kdv_bas_main + " TL");
                    $(".genel_toplam_tl").html("");
                    $(".genel_toplam_tl").html(tl_genel_toplam_bas_main + " TL");

                    if (item.doviz_tur == "USD") {
                        usd_ara_toplam_main += parse_ara_toplam;
                        usd_genel_toplam_main += parse_genel_toplam;
                        usd_kdv_toplam_main += parse_kdv;

                        var usd_ara_toplam_bas_main = usd_ara_toplam_main.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })
                        var usd_genel_toplam_bas_main = usd_genel_toplam_main.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })
                        var usd_kdv_toplam_bas_main = usd_kdv_toplam_main.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })

                        $(".ara_toplam_usd").html("");
                        $(".ara_toplam_usd").html(usd_ara_toplam_bas_main + " " + item.doviz_tur);
                        $(".kdv_toplam_usd").html("");
                        $(".kdv_toplam_usd").html(usd_kdv_toplam_bas_main + " " + item.doviz_tur);
                        $(".genel_toplam_usd").html("");
                        $(".genel_toplam_usd").html(usd_genel_toplam_bas_main + " " + item.doviz_tur);

                    }
                    if (item.doviz_tur == "EURO") {
                        euro_ara_toplam_main += parse_ara_toplam;
                        euro_genel_toplam_main += parse_genel_toplam;
                        euro_kdv_toplam_main += parse_kdv;

                        var euro_ara_toplam_bas_main = euro_ara_toplam_main.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })
                        var euro_genel_toplam_bas_main = euro_genel_toplam_main.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })
                        var euro_kdv_toplam_bas_main = euro_kdv_toplam_main.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })
                        $(".ara_toplam_euro").html("");
                        $(".ara_toplam_euro").html(euro_ara_toplam_bas_main + " " + item.doviz_tur);
                        $(".kdv_toplam_euro").html("");
                        $(".kdv_toplam_euro").html(euro_kdv_toplam_bas_main + " " + item.doviz_tur);
                        $(".genel_toplam_euro").html("");
                        $(".genel_toplam_euro").html(euro_genel_toplam_bas_main + " " + item.doviz_tur);
                    }
                    if (item.doviz_tur == "GBP") {
                        gbp_ara_toplam_main += parse_ara_toplam;
                        gbp_genel_toplam_main += parse_genel_toplam;
                        gbp_kdv_toplam_main += parse_kdv;

                        var gbp_ara_toplam_bas_main = gbp_ara_toplam_main.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })
                        var gbp_genel_toplam_bas_main = gbp_genel_toplam_main.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })
                        var gbp_kdv_toplam_bas_main = gbp_kdv_toplam_main.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })

                        $(".ara_toplam_gbp").html("");
                        $(".ara_toplam_gbp").html(gbp_ara_toplam_bas_main + " " + item.doviz_tur);
                        $(".kdv_toplam_gbp").html("");
                        $(".kdv_toplam_gbp").html(gbp_kdv_toplam_bas_main + " " + item.doviz_tur);
                        $(".genel_toplam_gbp").html("");
                        $(".genel_toplam_gbp").html(gbp_genel_toplam_bas_main + " " + item.doviz_tur);
                    }

                    let disabled = "";
                    if (item.yakit_faturasi == 1) {
                        disabled = "disabled";
                    }

                    let cari_kodu = "";
                    if (item.cari_kodu != null) {
                        cari_kodu = item.cari_kodu
                    } else {
                        cari_kodu = item.tc_no;
                    }
                    let cari_adi = "";
                    if (item.cari_adi != null) {
                        cari_adi = item.cari_adi
                    } else {
                        cari_adi = item.uye_adi;
                    }

                    if ("doviz_kur" in item) {
                        let newRecord = {
                            fatura_no: item.fatura_no,
                            fatura_turu_adi: fatura_turu,
                            fatura_tarihi: fatura_tarihi,
                            cari_kodu: cari_kodu,
                            cari_adi: cari_adi,
                            tl_ara_toplam: tl_ara_toplam_bas,
                            tl_kdv: tl_kdv_bas,
                            tl_genel_toplam: tl_genel_toplam_bas,
                            doviz_tur: item.doviz_tur,
                            aciklama: aciklama,
                            vade_tarihi: vade_tarihi_bas,
                            doviz_kuru: doviz_kuru,
                            ara_toplam: ara_toplam,
                            kdv_toplam: kdv_toplam,
                            genel_toplam: genel_toplam,
                            button: "<button class='btn btn-sm' disabled style='background-color: #F6FA70' data-id='" + item.id + "'><i class='fa fa-eye'></i></button> <button disabled class='btn btn-danger btn-sm ' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                        };
                        basilacak_arr.push(newRecord);
                    } else {
                        let newRecord = {
                            fatura_no: item.fatura_no,
                            fatura_turu_adi: fatura_turu,
                            fatura_tarihi: fatura_tarihi,
                            cari_kodu: cari_kodu,
                            cari_adi: cari_adi,
                            tl_ara_toplam: tl_ara_toplam_bas,
                            tl_kdv: tl_kdv_bas,
                            tl_genel_toplam: tl_genel_toplam_bas,
                            doviz_tur: item.doviz_tur,
                            aciklama: aciklama,
                            vade_tarihi: vade_tarihi_bas,
                            doviz_kuru: doviz_kuru,
                            ara_toplam: ara_toplam,
                            kdv_toplam: kdv_toplam,
                            genel_toplam: genel_toplam,
                            button: "<button class='btn  btn-sm fatura_goruntule_button_main' " + disabled + " style='background-color: #F6FA70' data-id='" + item.id + "'><i class='fa fa-eye'></i></button> <button class='btn btn-danger btn-sm faturayi_sil' " + disabled + " data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                        };
                        basilacak_arr.push(newRecord);
                    }
                });
                table.rows.add(basilacak_arr).draw(false);
                if (gbp_ara_toplam_main == 0 || gbp_genel_toplam_main == 0 || gbp_kdv_toplam_main == 0) {
                    $(".ara_toplam_gbp").hide();
                    $(".kdv_toplam_gbp").hide();
                    $(".genel_toplam_gbp").hide();
                    $("#gbp_gorunum").hide();
                }
                if (euro_ara_toplam_main == 0 || euro_kdv_toplam_main == 0 || euro_genel_toplam_main == 0) {
                    $("#euro_gorunum").hide();
                    $(".genel_toplam_euro").hide();
                    $(".kdv_toplam_euro").hide();
                    $(".ara_toplam_euro").hide();
                }
                if (usd_ara_toplam_main == 0 || usd_kdv_toplam_main == 0 || usd_genel_toplam_main == 0) {
                    $(".ara_toplam_usd").hide();
                    $(".kdv_toplam_usd").hide();
                    $(".genel_toplam_usd").hide();
                    $("#usd_gorunum").hide();
                }
            } else {
                $(".ara_toplam_tl").html("");
                $(".ara_toplam_tl").html("0,00 TL");
                $(".kdv_toplam_tl").html("");
                $(".kdv_toplam_tl").html("0,00 TL");
                $(".genel_toplam_tl").html("");
                $(".genel_toplam_tl").html("0,00 TL");
                $(".ara_toplam_gbp").hide();
                $(".kdv_toplam_gbp").hide();
                $(".genel_toplam_gbp").hide();
                $("#gbp_gorunum").hide();
                $("#euro_gorunum").hide();
                $(".genel_toplam_euro").hide();
                $(".kdv_toplam_euro").hide();
                $(".ara_toplam_euro").hide();
                $(".ara_toplam_usd").hide();
                $(".kdv_toplam_usd").hide();
                $(".genel_toplam_usd").hide();
                $("#usd_gorunum").hide();

            }
        });
        $("body").off("click", "#alis_fatura_filtrele").on("click", "#alis_fatura_filtrele", function () {
            var bas_tarih = $(".bas_tarih_alis").val();
            var bit_tarih = $(".bit_tarih_alis").val();
            var bas_fiyat = $("#bas_fiyat").val();
            var bit_fiyat = $("#bit_fiyat").val();
            var doviz_tur = $("#doviz_tur_filter").val();
            var fatura_no = $("#fatura_no").val();
            var cari_kodu = $("#cari_kodu").val();
            var cari_adi = $("#cari_adi").val();
            var aciklama = $("#aciklama").val();

            if (bas_tarih > bit_tarih) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                Toast.fire({
                    icon: 'warning',
                    title: 'Bitiş Tarihi Başlangıç Tarihinden Küçük Olamaz'
                });
            } else {
                $.get("controller/alis_controller/sql.php?islem=alis_faturalari_filtrele_sql", {
                    bas_tarih: bas_tarih,
                    bit_tarih: bit_tarih,
                    bas_fiyat: bas_fiyat,
                    bit_fiyat: bit_fiyat,
                    doviz_tur: doviz_tur,
                    fatura_no: fatura_no,
                    cari_kodu: cari_kodu,
                    cari_adi: cari_adi,
                    aciklama: aciklama
                }, function (result) {
                    if (result != 2) {
                        var json = JSON.parse(result);
                        tl_ara_toplam_main = 0;
                        tl_kdv_toplam_main = 0;
                        tl_genel_toplam_main = 0;

                        usd_ara_toplam_main = 0;
                        usd_kdv_toplam_main = 0;
                        usd_genel_toplam_main = 0;

                        euro_ara_toplam_main = 0;
                        euro_kdv_toplam_main = 0;
                        euro_genel_toplam_main = 0;

                        gbp_ara_toplam_main = 0;
                        gbp_kdv_toplam_main = 0;
                        gbp_genel_toplam_main = 0;
                        table.clear().draw(false);
                        let basilacak_arr2 = [];
                        json.forEach(function (item) {
                            let aciklama = item.aciklama;
                            if (aciklama != "" && aciklama.length > 25) {
                                aciklama = aciklama.substring(0, 25) + "...";
                            }
                            var fatura_tarihi = item.fatura_tarihi;
                            var explode1 = fatura_tarihi.split(" ");
                            var explode_cikti1 = explode1[0];
                            var explode2 = explode_cikti1.split("-");
                            var gun = explode2[2];
                            var ay = explode2[1];
                            var yil = explode2[0];
                            var arr = [gun, ay, yil];
                            var fatura_tarihi_bas = arr.join("/");

                            var vadeTarihi = item.vade_tarihi;
                            var vadeTarihi_explode = vadeTarihi.split(" ");
                            var explode_cikti3 = vadeTarihi_explode[0];
                            var explode4 = explode_cikti3.split("-");
                            var gun1 = explode4[2];
                            var ay1 = explode4[1];
                            var yil1 = explode4[0];
                            var arr1 = [gun1, ay1, yil1];
                            var vade_tarihi_bas = arr1.join("/");

                            var araToplam = item.ara_toplam;
                            var parse_ara_toplam = parseFloat(araToplam);
                            var ara_toplam = parse_ara_toplam.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })

                            var kdvToplam = item.kdv_toplam;
                            var parse_kdv = parseFloat(kdvToplam);
                            var kdv_toplam = parse_kdv.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })

                            var genelToplam = item.genel_toplam;
                            var parse_genel_toplam = parseFloat(genelToplam);
                            var genel_toplam = parse_genel_toplam.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })

                            var doviz_kuru = item.doviz_kuru;
                            var parse_kur = parseFloat(doviz_kuru);
                            var tl_kdv = parse_kur * item.kdv_toplam;
                            var tl_ara_toplam = parse_kur * item.ara_toplam;
                            var tl_genel_toplam = parse_kur * item.genel_toplam;

                            var tl_kdv_bas = tl_kdv.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })
                            var tl_ara_toplam_bas = tl_ara_toplam.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })
                            var tl_genel_toplam_bas = tl_genel_toplam.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })

                            tl_ara_toplam_main += tl_ara_toplam;
                            tl_kdv_toplam_main += tl_kdv;
                            tl_genel_toplam_main += tl_genel_toplam;

                            var tl_kdv_bas_main = tl_kdv_toplam_main.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })
                            var tl_ara_toplam_bas_main = tl_ara_toplam_main.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })
                            var tl_genel_toplam_bas_main = tl_genel_toplam_main.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })

                            $(".ara_toplam_tl").html("");
                            $(".ara_toplam_tl").html(tl_ara_toplam_bas_main + " TL");
                            $(".kdv_toplam_tl").html("");
                            $(".kdv_toplam_tl").html(tl_kdv_bas_main + " TL");
                            $(".genel_toplam_tl").html("");
                            $(".genel_toplam_tl").html(tl_genel_toplam_bas_main + " TL");

                            if (item.doviz_tur == "USD") {
                                usd_ara_toplam_main += parse_ara_toplam;
                                usd_genel_toplam_main += parse_genel_toplam;
                                usd_kdv_toplam_main += parse_kdv;

                                var usd_ara_toplam_bas_main = usd_ara_toplam_main.toLocaleString("tr-TR", {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                })
                                var usd_genel_toplam_bas_main = usd_genel_toplam_main.toLocaleString("tr-TR", {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                })
                                var usd_kdv_toplam_bas_main = usd_kdv_toplam_main.toLocaleString("tr-TR", {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                })

                                $(".ara_toplam_usd").html("");
                                $(".ara_toplam_usd").html(usd_ara_toplam_bas_main + " " + item.doviz_tur);
                                $(".kdv_toplam_usd").html("");
                                $(".kdv_toplam_usd").html(usd_kdv_toplam_bas_main + " " + item.doviz_tur);
                                $(".genel_toplam_usd").html("");
                                $(".genel_toplam_usd").html(usd_genel_toplam_bas_main + " " + item.doviz_tur);

                            }
                            if (item.doviz_tur == "EURO") {
                                euro_ara_toplam_main += parse_ara_toplam;
                                euro_genel_toplam_main += parse_genel_toplam;
                                euro_kdv_toplam_main += parse_kdv;

                                var euro_ara_toplam_bas_main = euro_ara_toplam_main.toLocaleString("tr-TR", {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                })
                                var euro_genel_toplam_bas_main = euro_genel_toplam_main.toLocaleString("tr-TR", {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                })
                                var euro_kdv_toplam_bas_main = euro_kdv_toplam_main.toLocaleString("tr-TR", {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                })

                                $(".ara_toplam_euro").html("");
                                $(".ara_toplam_euro").html(euro_ara_toplam_bas_main + " " + item.doviz_tur);
                                $(".kdv_toplam_euro").html("");
                                $(".kdv_toplam_euro").html(euro_kdv_toplam_bas_main + " " + item.doviz_tur);
                                $(".genel_toplam_euro").html("");
                                $(".genel_toplam_euro").html(euro_genel_toplam_bas_main + " " + item.doviz_tur);
                            }
                            if (item.doviz_tur == "GBP") {
                                gbp_ara_toplam_main += parse_ara_toplam;
                                gbp_genel_toplam_main += parse_genel_toplam;
                                gbp_kdv_toplam_main += parse_kdv;

                                var gbp_ara_toplam_bas_main = gbp_ara_toplam_main.toLocaleString("tr-TR", {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                })
                                var gbp_genel_toplam_bas_main = gbp_genel_toplam_main.toLocaleString("tr-TR", {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                })
                                var gbp_kdv_toplam_bas_main = gbp_kdv_toplam_main.toLocaleString("tr-TR", {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                })

                                $(".ara_toplam_gbp").html("");
                                $(".ara_toplam_gbp").html(gbp_ara_toplam_bas_main + " " + item.doviz_tur);
                                $(".kdv_toplam_gbp").html("");
                                $(".kdv_toplam_gbp").html(gbp_kdv_toplam_bas_main + " " + item.doviz_tur);
                                $(".genel_toplam_gbp").html("");
                                $(".genel_toplam_gbp").html(gbp_genel_toplam_bas_main + " " + item.doviz_tur);
                            }

                            let newRecord = {
                                fatura_no: item.fatura_no,
                                fatura_turu_adi: item.fatura_turu_adi,
                                fatura_tarihi: fatura_tarihi_bas,
                                cari_kodu: item.cari_kodu,
                                cari_adi: item.cari_adi,
                                tl_ara_toplam: tl_ara_toplam_bas + " TL",
                                tl_kdv: tl_kdv_bas + " TL",
                                tl_genel_toplam: tl_genel_toplam_bas + " TL",
                                doviz_tur: item.doviz_tur,
                                aciklama: aciklama,
                                vade_tarihi: vade_tarihi_bas,
                                doviz_kuru: doviz_kuru,
                                ara_toplam: ara_toplam + " " + item.doviz_tur,
                                kdv_toplam: kdv_toplam + " " + item.doviz_tur,
                                genel_toplam: genel_toplam + " " + item.doviz_tur,
                                button: "<button class='btn  btn-sm fatura_goruntule_button_main' style='background-color: #F6FA70' data-id='" + item.id + "'><i class='fa fa-eye'></i></button> <button class='btn btn-danger btn-sm faturayi_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                            };
                            basilacak_arr2.push(newRecord);
                        });
                        table.rows.add(basilacak_arr2).draw(false);
                        if (gbp_ara_toplam_main == 0 || gbp_genel_toplam_main == 0 || gbp_kdv_toplam_main == 0) {
                            $(".ara_toplam_gbp").hide();
                            $(".kdv_toplam_gbp").hide();
                            $(".genel_toplam_gbp").hide();
                            $("#gbp_gorunum").hide();
                        } else {
                            $(".ara_toplam_gbp").show();
                            $(".kdv_toplam_gbp").show();
                            $(".genel_toplam_gbp").show();
                            $("#gbp_gorunum").show();
                        }
                        if (euro_ara_toplam_main == 0 || euro_kdv_toplam_main == 0 || euro_genel_toplam_main == 0) {
                            $("#euro_gorunum").hide();
                            $(".genel_toplam_euro").hide();
                            $(".kdv_toplam_euro").hide();
                            $(".ara_toplam_euro").hide();
                        } else {
                            $("#euro_gorunum").show();
                            $(".genel_toplam_euro").show();
                            $(".kdv_toplam_euro").show();
                            $(".ara_toplam_euro").show();
                        }
                        if (usd_ara_toplam_main == 0 || usd_kdv_toplam_main == 0 || usd_genel_toplam_main == 0) {
                            $(".ara_toplam_usd").hide();
                            $(".kdv_toplam_usd").hide();
                            $(".genel_toplam_usd").hide();
                            $("#usd_gorunum").hide();
                        } else {
                            $(".ara_toplam_usd").show();
                            $(".kdv_toplam_usd").show();
                            $(".genel_toplam_usd").show();
                            $("#usd_gorunum").show();
                        }
                    } else {
                        table.clear().draw(false);
                        $(".ara_toplam_usd").hide();
                        $(".kdv_toplam_usd").hide();
                        $(".genel_toplam_usd").hide();
                        $("#usd_gorunum").hide();
                        $("#euro_gorunum").hide();
                        $(".genel_toplam_euro").hide();
                        $(".kdv_toplam_euro").hide();
                        $(".ara_toplam_euro").hide();
                        $(".ara_toplam_gbp").hide();
                        $(".kdv_toplam_gbp").hide();
                        $(".genel_toplam_gbp").hide();
                        $("#gbp_gorunum").hide();
                        $(".ara_toplam_tl").html("");
                        $(".ara_toplam_tl").html("0,00 TL");
                        $(".kdv_toplam_tl").html("");
                        $(".kdv_toplam_tl").html("0,00 TL");
                        $(".genel_toplam_tl").html("");
                        $(".genel_toplam_tl").html("0,00 TL");
                    }
                })
            }
        });
    });


    $("body").off("click", "#alis_fatura_olustur_main").on("click", "#alis_fatura_olustur_main", function () {
        $.get("modals/alis_modal/modal.php?islem=alis_faturasi_ekle", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".fatura_goruntule_button_main").on("click", ".fatura_goruntule_button_main", function () {
        var id = $(this).attr("data-id");
        $.get("modals/alis_modal/modal_page.php?islem=faturayi_goruntule_ve_guncelle", {id: id}, function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });
    $("body").off("click", ".faturayi_sil").on("click", ".faturayi_sil", function () {
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
                        url: "controller/alis_controller/sql.php?islem=fatura_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Fatura Silindi',
                                    'success'
                                );
                                $.get("view/alis_fatura.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/alis_fatura.php", function (getList) {
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