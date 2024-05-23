<style>
    .excel_alis {
        background-color: #2ecc71 !important;
        border-color: #27ad60 !important;
        color: white !important;
        border-radius: 20px !important;
        font-weight: bold !important;
    }

    #cari_hesap_ekstresi_listesi_rapor td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100px;
    }
</style>
<div class="ibox-container">
    <div class="cari_getir_div_ekstre"></div>
    <div class="ibox mt-5">
        <div class="ibox-head">
            <div class="ibox-title" style=' font-weight:bold;'>STOK EKSTRESİ</div>
        </div>
        <div class="col-12 row no-gutters mt-3">
            <div class="col-md-1">
                <div class="input-group mb-3">
                    <input type="text" class="form-control form-control-sm secilen_stok"
                           aria-describedby="basic-addon1" id="stok_id_filter" placeholder="Stok Kodu">
                    <div class="input-group-append">
                        <button class="btn btn-warning btn-sm" id="cari_getir_modal"><i
                                    class="fa fa-ellipsis-h"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-1 mx-1">
                <input type="text" class="form-control form-control-sm stok_adi_getir" disabled placeholder="Stok Adı">
            </div>
            <div class="col-md-1 mx-2">
                <input type="date" value="<?php
                $yil_basi = new DateTime();
                $yil_basi->modify('first day of January ' . $yil_basi->format('Y'));

                $yil_basi = $yil_basi->format('Y-m-d');
                echo $yil_basi;
                ?>"
                       class="form-control form-control-sm" id="bas_tarih">
            </div>

            <div class="col-md-1 mx-1">
                <input type="date" value="<?= date("Y-m-d") ?>"
                       class="form-control form-control-sm" id="bit_tarih">
            </div>
            <div class="col-1 mx-3">
                <button class="btn btn-secondary btn-sm" id="stok_ekstre_filtrele" data-name="stok_filter"><i
                            class="fa fa-filter"></i> Hazırla
                </button>
            </div>
        </div>
        <nav class="nav nav-pills flex-column flex-sm-row mt-3">
            <a class="flex-sm-fill text-sm-center nav-link active stok_page_color secilen_modul" aria-current="page"
               id="stok_ekstresi_paging" style="font-weight: bold">STOK EKSTRESİ</a>
            <a class="flex-sm-fill text-sm-center nav-link stok_page_color" style="font-weight: bold"
               id="hizmet_ekstresi">HİZMET EKSTRESİ</a>
        </nav>

        <div class="col-12 row mt-3">
            <table class="table table-sm table-bordered w-100  nowrap edit_list"
                   style="cursor:pointer;font-size: 13px;"
                   id="cari_hesap_ekstresi_listesi_rapor">
                <thead>
                <tr>
                    <th style="width: 0% !important;">Tarih</th>
                    <th style="width: 0% !important;">Belge No</th>
                    <th style="width: 0% !important;">Belge Türü</th>
                    <th style="width: 1% !important;">Açıklama</th>
                    <th style="width: 0% !important;" id="alinan_hizmet">Giren Miktar</th>
                    <th style="width: 0% !important;" id="yapilan_hizmet">Çıkan Miktar</th>
                    <th style="width: 0% !important;" id="toplam_hizmet">Kalan Miktar</th>
                    <th style="width: 0% !important;">Fiyat</th>
                    <th style="width: 0% !important;" id="hizmet_alis">Alış Tutar</th>
                    <th style="width: 0% !important;" id="hizmet_satis">Satış Tutar</th>
                </tr>
                </thead>
                <tfoot style="background-color: white">
                <tr>
                    <th colspan="4" style="text-align: right; font-size: 14px;">TOPLAM:</th>
                    <th style="text-align: right; font-size: 14px;" class="toplam_giren">0,00</th>
                    <th style="text-align: right; font-size: 14px;" class="toplam_cikan">0,00</th>
                    <th style="text-align: right; font-size: 14px;" class="toplam_kalan">0,00</th>
                    <th style="text-align: right; font-size: 14px;" class="fiyat"></th>
                    <th style="text-align: right; font-size: 14px;" class="alis_fiyat">0,00</th>
                    <th style="text-align: right; font-size: 14px;" class="satis_fiyat">0,00</th>
                </tr>
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
    var table = "";
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
        var targetColumns = [4, 5, 6, 7, 8, 9];
        table = $('#cari_hesap_ekstresi_listesi_rapor').DataTable({
            paging: false,
            scrollX: true,
            scrollY: "55vh",
            ordering: true,
            "info": false,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "STOK EKSTRESİ",
                    text: "<i class='fa fa-download'></i> Excel'e Aktar",
                    className: 'excel_alis',
                    customizeData: function (excelData) {
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
                {"data": "tarih", "type": "date-eu"},
                {"data": "belge_no"},
                {"data": "belge_turu"},
                {"data": "aciklama"},
                {"data": "giren_miktar"},
                {"data": "cikan_miktar"},
                {"data": "kalan_miktar"},
                {"data": "fiyat"},
                {"data": "alis_tutar"},
                {"data": "satis_tutar"},
            ],
            "order": [[0, 'asc']],
            createdRow: function (row, data, dataIndex) {
                $(row).find("td").eq(0).css("text-align", "left");
                $(row).find("td").eq(1).css("text-align", "left");
                $(row).find("td").eq(2).css("text-align", "left");
                $(row).find("td").eq(3).css("text-align", "left");
            },
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        })
    });

    $("body").off("click", "#stok_ekstresi_paging").on("click", "#stok_ekstresi_paging", function () {
        $(".stok_page_color").removeClass("active");
        $(".stok_page_color").removeClass("secilen_modul");
        $(this).addClass("active");
        $(this).addClass("secilen_modul");
        $("#stok_ekstre_filtrele").attr("data-name", "stok_filter");
        $("#alinan_hizmet").html("Giren Miktar");
        $("#yapilan_hizmet").html("Çıkan Miktar");
        $("#toplam_hizmet").html("Kalan Miktar");
        $("#hizmet_alis").html("Alış Tutar");
        $("#hizmet_satis").html("Satış Tutar");
        $(".toplam_giren").html("0,00");
        $(".toplam_cikan").html("0,00");
        $(".toplam_kalan").html("0,00");
        $(".alis_fiyat").html("0,00");
        $(".satis_fiyat").html("0,00");
        $("#stok_id_filter").attr("data-id", "");
        $("#stok_id_filter").val("");
        $(".stok_adi_getir").val("");
        table.clear().draw(false);
    });

    $("body").off("click", "#hizmet_ekstresi").on("click", "#hizmet_ekstresi", function () {
        $(".stok_page_color").removeClass("active");
        $(".stok_page_color").removeClass("secilen_modul");
        $("#stok_ekstre_filtrele").attr("data-name", "hizmet_filter");
        $("#alinan_hizmet").html("Alınan Hizmet");
        $("#yapilan_hizmet").html("Yapılan Hizmet");
        $("#toplam_hizmet").html("Toplam Hizmet");
        $("#hizmet_alis").html("Hizmet Alış Tutarı");
        $("#hizmet_satis").html("Hizmet Satış Tutarı");
        $(this).addClass("active");
        $(this).addClass("secilen_modul");

        $(".toplam_giren").html("0,00");
        $(".toplam_cikan").html("0,00");
        $(".toplam_kalan").html("0,00");
        $(".alis_fiyat").html("0,00");
        $(".satis_fiyat").html("0,00");
        $("#stok_id_filter").attr("data-id", "");
        $("#stok_id_filter").val("");
        $(".stok_adi_getir").val("");
        table.clear().draw(false);
    });

    $("body").off("click", "#cari_getir_modal").on("click", "#cari_getir_modal", function () {
        let aktif_modul = $(".secilen_modul").text();
        $.get("modals/ekstre_modal.php?islem=stok_listesi_getir_modal", {aktif_modul: aktif_modul}, function (getModal) {
            $(".cari_getir_div_ekstre").html("");
            $(".cari_getir_div_ekstre").html(getModal);
        })
    });

    $("body").off("click", "#stok_ekstre_filtrele").on("click", "#stok_ekstre_filtrele", function () {
        let stok_id = $("#stok_id_filter").attr("data-id");
        let bas_tarih = $("#bas_tarih").val();
        let bit_tarih = $("#bit_tarih").val();
        let data_name = $("#stok_ekstre_filtrele").attr("data-name");
        let islem = "";
        if (data_name == "stok_filter") {
            islem = "stok_ekstresi_getir_sql";
        } else {
            islem = "hizmet_ekstresi_getir_sql";
        }
        $.get("controller/ekstre_controller/sql.php?islem=" + islem + "",
            {
                stok_id: stok_id,
                bas_tarih: bas_tarih,
                bit_tarih: bit_tarih
            }
            , function (result) {
                if (result != 2) {
                    let arr = [];
                    let toplam_borc = 0;
                    let toplam_alacak = 0;
                    let toplam_alis = 0;
                    let toplam_satis = 0;
                    table.clear().draw(false);
                    var json = JSON.parse(result);
                    let basilacak = [];
                    json.forEach(function (item) {
                        let gonderilen_tarih = item.tarih;
                        gonderilen_tarih = gonderilen_tarih.split(" ");
                        gonderilen_tarih = gonderilen_tarih[0];
                        gonderilen_tarih = gonderilen_tarih.split("-");
                        var gun = gonderilen_tarih[2];
                        var ay = gonderilen_tarih[1];
                        var yil = gonderilen_tarih[0];
                        var arr = [gun, ay, yil];
                        gonderilen_tarih = arr.join("/");

                        var borc = item.giren_miktar;
                        var alacak = item.cikan_miktar;
                        borc = parseFloat(borc);
                        toplam_borc += borc;
                        alacak = parseFloat(alacak);
                        toplam_alacak += alacak;
                        var bakiye = 0;
                        bakiye = item.kalan_miktar;
                        bakiye = parseFloat(bakiye);
                        bakiye = bakiye.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        borc = borc.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        alacak = alacak.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        var alis_tutar = item.alis_tutar;
                        alis_tutar = parseFloat(alis_tutar);
                        if (isNaN(alis_tutar)) {
                            alis_tutar = 0;
                        }
                        toplam_alis += alis_tutar;
                        alis_tutar = alis_tutar.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        var satis_tutar = item.satis_tutar;
                        satis_tutar = parseFloat(satis_tutar);
                        if (isNaN(satis_tutar)) {
                            satis_tutar = 0;
                        }
                        toplam_satis += satis_tutar;
                        var fiyat = item.fiyat;
                        fiyat = parseFloat(fiyat);
                        if (isNaN(fiyat)) {
                            fiyat = 0;
                        }
                        satis_tutar = satis_tutar.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        fiyat = fiyat.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        basilacak.push({
                            tarih: gonderilen_tarih,
                            belge_no: item.belge_no,
                            belge_turu: item.belge_turu,
                            aciklama: item.aciklama,
                            giren_miktar: borc,
                            cikan_miktar: alacak,
                            fiyat: fiyat,
                            alis_tutar: alis_tutar,
                            satis_tutar: satis_tutar,
                            kalan_miktar: bakiye
                        })
                    });
                    let bakiye = 0;
                    if (data_name == "hizmet_filter") {
                        bakiye = toplam_borc + toplam_alacak;
                    } else {
                        bakiye = toplam_borc - toplam_alacak;
                    }
                    bakiye = bakiye.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    toplam_borc = toplam_borc.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    toplam_alacak = toplam_alacak.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    $(".toplam_giren").html("");
                    $(".toplam_giren").html(toplam_borc);
                    $(".toplam_cikan").html("");
                    $(".toplam_cikan").html(toplam_alacak);
                    $(".toplam_kalan").html("");
                    $(".toplam_kalan").html(bakiye);
                    $(".toplam_kalan").html("");
                    $(".toplam_kalan").html(bakiye);
                    $(".alis_fiyat").html("");
                    $(".alis_fiyat").html(toplam_alis.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }));
                    $(".satis_fiyat").html("");
                    $(".satis_fiyat").html(toplam_satis.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }));
                    table.rows.add(basilacak).draw(false);
                }
            });
    });

</script>