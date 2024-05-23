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
        <div class="ibox-title" style=' font-weight:bold;'>MÜŞTERİLERE GÖRE FATURA LİSTESİ</div>
    </div>

    <div class="col-12 row">
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
                <input type="text" placeholder="Firma Adı" id="cari_adi"
                       class="form-control form-control-sm mt-2">
            </div>
            <div class="col-md-2 row mx-1">
                <select class="custom-select custom-select-sm" id="cari_turu">
                    <option value="">Cari Türü</option>
                    <option value="">Hepsi</option>
                </select>
                <button class="btn btn-info btn-sm" id="saticilara_gore_fatura_filtrele"><i
                        class="fa fa-filter"></i> Filtrele
                </button>
            </div>
        </div>
    </div>
    <div class="col-12 row">
        <div class="col-12 row mt-5">
            <table class="table table-sm table-bordered w-100  nowrap datatable"
                   style="cursor:pointer;font-size: 13px;"
                   id="alis_fatura_table">
                <thead>
                <tr>
                    <th>Firma Adı</th>
                    <th>Firma Kodu</th>
                    <th>Doviz Tipi</th>
                    <th>Toplam Fatura</th>
                    <th>Ara Toplam</th>
                    <th>KDV Toplam</th>
                    <th>Genel Toplam</th>
                </tr>
                </thead>
            </table>
        </div>
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

    $(document).ready(function () {


        $.get("controller/cari_controller/sql.php?islem=cari_turleri_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                json.forEach(function (item) {
                    $("#cari_turu").append("" +
                        "<option value='" + item.id + "'>" + item.cari_turu_adi + "</option>" +
                        "");
                })
            }
        })

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
        var targetColumns = [3, 4, 5];
        var table = $('#alis_fatura_table').DataTable({
            scrollX: true,
            scrollY: '50vh',
            "paging": false,
            searching: false,
            columns: [
                {"data": "cari_adi"},
                {"data": "cari_kodu"},
                {"data": "doviz_tur"},
                {"data": "toplam_fatura"},
                {"data": "ara_toplam"},
                {"data": "kdv_toplam"},
                {"data": "genel_toplam"}
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "MÜŞTERİLERE GÖRE FATURA LİSTESİ",
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
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').eq(0).css('text-align', 'left');
                $(row).find('td').eq(1).css('text-align', 'left');
                $(row).find('td').eq(2).css('text-align', 'left');
            },
            columnDefs: [
                {targets: 2, type: "date-eu"}
            ],
            order: [[2, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        });

        $("body").off("click", "#saticilara_gore_fatura_filtrele").on("click", "#saticilara_gore_fatura_filtrele", function () {
            let bas_tarih = $("#bas_tarih").val();
            let bit_tarih = $("#bit_tarih").val();
            let doviz_turu = $("#doviz_tur_filter").val();
            let cari_adi = $("#cari_adi").val();
            let cari_turu_adi = $("#cari_turu").val();

            table.clear().draw(false);
            $.get("controller/satis_controller/sql.php?islem=saticilara_gore_fatura_listesi_sql", {
                bas_tarih: bas_tarih,
                bit_tarih: bit_tarih,
                doviz_turu: doviz_turu,
                cari_adi: cari_adi,
                cari_turu_adi: cari_turu_adi
            }, function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                    let gbp = "";
                    let usd = "";
                    let eur = "";
                    json.forEach(function (item) {
                        if (item.doviz_tur == "GBP") {
                            gbp = "Var";
                        } else if (item.doviz_tur == "EUR") {
                            eur = "Var";
                        } else if (item.doviz_tur == "USD") {
                            usd = "Var";
                        }
                    })

                    $(".ara_toplam_tl").html(json[0]["tl_ara_tot"] + " TL");
                    $(".kdv_toplam_tl").html(json[0]["tl_kdv_tot"] + " TL");
                    $(".genel_toplam_tl").html(json[0]["tl_genel_tot"] + " TL");

                    if (gbp == "") {
                        $(".ara_toplam_gbp").hide();
                        $(".kdv_toplam_gbp").hide();
                        $(".genel_toplam_gbp").hide();
                        $("#gbp_gorunum").hide();
                    }
                    if (eur == "") {
                        $("#euro_gorunum").hide();
                        $(".genel_toplam_euro").hide();
                        $(".kdv_toplam_euro").hide();
                        $(".ara_toplam_euro").hide();
                    }
                    if (usd == "") {
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
            })
        });

        $.get("controller/satis_controller/sql.php?islem=saticilara_gore_fatura_listesi_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                table.rows.add(json).draw(false);
                let gbp = "";
                let usd = "";
                let eur = "";
                json.forEach(function (item) {
                    if (item.doviz_tur == "GBP") {
                        gbp = "Var";
                    } else if (item.doviz_tur == "EUR") {
                        eur = "Var";
                    } else if (item.doviz_tur == "USD") {
                        usd = "Var";
                    }
                })

                $(".ara_toplam_tl").html(json[0]["tl_ara_tot"] + " TL");
                $(".kdv_toplam_tl").html(json[0]["tl_kdv_tot"] + " TL");
                $(".genel_toplam_tl").html(json[0]["tl_genel_tot"] + " TL");

                if (gbp == "") {
                    $(".ara_toplam_gbp").hide();
                    $(".kdv_toplam_gbp").hide();
                    $(".genel_toplam_gbp").hide();
                    $("#gbp_gorunum").hide();
                }
                if (eur == "") {
                    $("#euro_gorunum").hide();
                    $(".genel_toplam_euro").hide();
                    $(".kdv_toplam_euro").hide();
                    $(".ara_toplam_euro").hide();
                }
                if (usd == "") {
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
    });
</script>