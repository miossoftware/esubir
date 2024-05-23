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
        <div class="ibox-title" style=' font-weight:bold;'>GENEL STOK RAPORU</div>
    </div>
    <div class="col-12 row no-gutters">
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
        <div class="col-md-2 mx-2">
            <button class="btn btn-secondary btn-sm" id="stok_ekstre_tekrar_filtre" data-name="stok_filter"><i
                        class="fa fa-filter"></i> Hazırla
            </button>
        </div>
    </div>
    <nav class="nav nav-pills flex-column flex-sm-row mt-3">
        <a class="flex-sm-fill text-sm-center nav-link active stok_page_color secilen_modul" aria-current="page"
           id="stok_ekstresi_paging" style="font-weight: bold">STOK ENVANTER RAPORU</a>
        <a class="flex-sm-fill text-sm-center nav-link stok_page_color" style="font-weight: bold"
           id="hizmet_ekstresi">HİZMET ENVANTER RAPORU</a>
    </nav>
    <div class="col-12 row mt-3">
        <table class="table table-sm table-bordered w-100  nowrap" id="stok_table" style="font-size: 13px;">
            <thead>
            <tr>
                <th>Stok Kodu</th>
                <th>Stok Adı</th>
                <th>Barkod</th>
                <th>Birimi</th>
                <th>Ana Grubu</th>
                <th>Alt Grubu</th>
                <th id="alinan_hizmet">Giren</th>
                <th id="hizmet_alis">Alış Tutarı</th>
                <th id="yapilan_hizmet">Çıkan</th>
                <th id="hizmet_satis">Satış Tutarı</th>
                <th id="toplam_hizmet">Kalan Miktar</th>
                <th id="toplam_hizmet_tutari">Maliyet</th>
                <th id="envanter_tutari">Envanter Tutarı</th>
            </tr>
            </thead>
            <tbody id="stok_listesi">
            </tbody>
            <tfoot style="background-color: white">
            <tr>
                <th colspan="6" style="text-align: right; font-size: 14px;">TOPLAM:</th>
                <th style="text-align: right; font-size: 14px;" class="toplam_giren"></th>
                <th style="text-align: right; font-size: 14px;" class="toplam_alis"></th>
                <th style="text-align: right; font-size: 14px;" class="toplam_cikan"></th>
                <th style="text-align: right; font-size: 14px;" class="toplam_satis"></th>
                <th style="text-align: right; font-size: 14px;" class="kalan_miktar"></th>
                <th style="text-align: right; font-size: 14px;" class="maliyet"></th>
                <th style="text-align: right; font-size: 14px;" class="envanter_tutari"></th>
                <th></th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
<script>

    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });
    $(document).ready(function () {
        var targetColumns = [6, 7, 8, 9, 10, 11, 12];
        var table = $('#stok_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            columns: [
                {"data": "stok_kodu"},
                {"data": "stok_adi"},
                {"data": "barkod"},
                {"data": "birim_adi"},
                {"data": "ana_grup_adi"},
                {"data": "altgrup_adi"},
                {"data": "giren_miktar"},
                {"data": "alis_tutar"},
                {"data": "cikan_miktar"},
                {"data": "satis_tutar"},
                {"data": "kalan_miktar"},
                {"data": "maliyet_tutar"},
                {"data": "toplam_mal_tutari"},
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "STOK RAPORLARI",
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
                $(row).find("td").eq(0).css("text-align", "left");
                $(row).find("td").eq(1).css("text-align", "left");
                $(row).find("td").eq(2).css("text-align", "left");
                $(row).find("td").eq(3).css("text-align", "left");
                $(row).find("td").eq(4).css("text-align", "left");
                $(row).find("td").eq(5).css("text-align", "left");
                $(row).find("td").eq(6).css("text-align", "right");
                $(row).find("td").eq(7).css("text-align", "right");
                $(row).find("td").eq(8).css("text-align", "right");

            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        $.get("controller/ekstre_controller/sql.php?islem=stok_genel_ekstre",
            {
                bas_tarih: $("#bas_tarih").val(),
                bit_tarih: $("#bit_tarih").val()
            }
            , function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);

                    let arr = [];
                    let toplam_giren = 0;
                    let toplam_cikan = 0;
                    let toplam_alis = 0;
                    let toplam_satis = 0;
                    let toplam_maliyet = 0;
                    let toplam_envater = 0;
                    json.forEach(function (item) {
                        var stok_kodu = item.stok_kodu;
                        var stokAdi = item.stok_adi;
                        var barkod = item.barkod;
                        var ana_grupid = item.ana_grup_adi;
                        var altGrupid = item.altgrup_adi;
                        var birim = item.birim_adi;
                        var giren_miktar = item.giren_miktar;
                        var cikan_miktar = item.cikan_miktar;
                        cikan_miktar = parseFloat(cikan_miktar);
                        toplam_cikan += cikan_miktar;
                        giren_miktar = parseFloat(giren_miktar)
                        var elimdeki_maliyet = item.elimdeki_maliyet;
                        elimdeki_maliyet = parseFloat(elimdeki_maliyet)
                        toplam_envater += elimdeki_maliyet;
                        var alis_tutar = item.alis_tutar;
                        alis_tutar = parseFloat(alis_tutar)
                        toplam_alis += alis_tutar;
                        var satis_tutar = item.satis_tutar;
                        satis_tutar = parseFloat(satis_tutar)
                        toplam_satis += satis_tutar;
                        var maliyet_tutar = item.maliyet_tutar;
                        maliyet_tutar = parseFloat(maliyet_tutar)
                        toplam_maliyet += maliyet_tutar;
                        var kalan_miktar = giren_miktar - cikan_miktar;
                        kalan_miktar = parseFloat(kalan_miktar);
                        toplam_giren += giren_miktar;
                        giren_miktar = giren_miktar.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        satis_tutar = satis_tutar.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        maliyet_tutar = maliyet_tutar.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        alis_tutar = alis_tutar.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        elimdeki_maliyet = elimdeki_maliyet.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        cikan_miktar = cikan_miktar.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        kalan_miktar = kalan_miktar.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        arr.push({
                            stok_kodu: stok_kodu,
                            stok_adi: stokAdi,
                            barkod: barkod,
                            birim_adi: birim,
                            ana_grup_adi: ana_grupid,
                            altgrup_adi: altGrupid,
                            alis_tutar: alis_tutar,
                            satis_tutar: satis_tutar,
                            giren_miktar: giren_miktar,
                            cikan_miktar: cikan_miktar,
                            maliyet_tutar: maliyet_tutar,
                            toplam_mal_tutari: elimdeki_maliyet,
                            kalan_miktar: kalan_miktar
                        })
                    });
                    toplam_giren = toplam_giren.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    toplam_cikan = toplam_cikan.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    toplam_alis = toplam_alis.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    toplam_envater = toplam_envater.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    toplam_satis = toplam_satis.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    toplam_maliyet = toplam_maliyet.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    $(".toplam_giren").html("");
                    $(".toplam_giren").html(toplam_giren);
                    $(".toplam_cikan").html("");
                    $(".toplam_cikan").html(toplam_cikan);
                    $(".envanter_tutari").html("");
                    $(".envanter_tutari").html(toplam_envater + " TL");
                    $(".toplam_alis").html("");
                    $(".toplam_alis").html(toplam_alis + " TL");
                    $(".toplam_satis").html("");
                    $(".toplam_satis").html(toplam_satis + " TL");
                    $(".maliyet").html("");
                    $(".maliyet").html(toplam_maliyet + " TL");
                    table.rows.add(arr).draw(false);
                }
            })

        $("body").off("click", "#stok_ekstresi_paging").on("click", "#stok_ekstresi_paging", function () {
            $(".stok_page_color").removeClass("active");
            $(".stok_page_color").removeClass("secilen_modul");
            $(this).addClass("active");
            $(this).addClass("secilen_modul");
            $("#stok_ekstre_tekrar_filtre").attr("data-name", "stok_filter");
            $("#alinan_hizmet").html("Giren Miktar");
            $("#yapilan_hizmet").html("Çıkan Miktar");
            $("#toplam_hizmet").html("Kalan Miktar");
            $("#hizmet_alis").html("Alış Tutar");
            $("#hizmet_satis").html("Satış Tutar");
            $("#toplam_hizmet_tutari").html("Maliyet");
            $("#envanter_tutari").html("Envanter Tutarı");
            $(".toplam_giren").html("");
            $(".toplam_cikan").html("");
            $(".envanter_tutari").html("");
            $(".toplam_alis").html("");
            $(".toplam_satis").html("");
            $(".maliyet").html("");
            $("#stok_id_filter").attr("data-id", "");
            $("#stok_id_filter").val("");
            $(".stok_adi_getir").val("");
            table.clear().draw(false);
            $.get("controller/ekstre_controller/sql.php?islem=stok_genel_ekstre",
                {
                    bas_tarih: $("#bas_tarih").val(),
                    bit_tarih: $("#bit_tarih").val()
                }
                , function (result) {
                    if (result != 2) {
                        var json = JSON.parse(result);

                        let arr = [];
                        let toplam_giren = 0;
                        let toplam_cikan = 0;
                        let toplam_alis = 0;
                        let toplam_satis = 0;
                        let toplam_maliyet = 0;
                        let toplam_envater = 0;
                        json.forEach(function (item) {
                            var stok_kodu = item.stok_kodu;
                            var stokAdi = item.stok_adi;
                            var barkod = item.barkod;
                            var ana_grupid = item.ana_grup_adi;
                            var altGrupid = item.altgrup_adi;
                            var birim = item.birim_adi;
                            var giren_miktar = item.giren_miktar;
                            var cikan_miktar = item.cikan_miktar;
                            cikan_miktar = parseFloat(cikan_miktar);
                            toplam_cikan += cikan_miktar;
                            giren_miktar = parseFloat(giren_miktar)
                            var elimdeki_maliyet = item.elimdeki_maliyet;
                            elimdeki_maliyet = parseFloat(elimdeki_maliyet)
                            toplam_envater += elimdeki_maliyet;
                            var alis_tutar = item.alis_tutar;
                            alis_tutar = parseFloat(alis_tutar)
                            toplam_alis += alis_tutar;
                            var satis_tutar = item.satis_tutar;
                            satis_tutar = parseFloat(satis_tutar)
                            toplam_satis += satis_tutar;
                            var maliyet_tutar = item.maliyet_tutar;
                            maliyet_tutar = parseFloat(maliyet_tutar)
                            toplam_maliyet += maliyet_tutar;
                            var kalan_miktar = giren_miktar - cikan_miktar;
                            kalan_miktar = parseFloat(kalan_miktar);
                            toplam_giren += giren_miktar;
                            giren_miktar = giren_miktar.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            satis_tutar = satis_tutar.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            maliyet_tutar = maliyet_tutar.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            alis_tutar = alis_tutar.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            elimdeki_maliyet = elimdeki_maliyet.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            cikan_miktar = cikan_miktar.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            kalan_miktar = kalan_miktar.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            arr.push({
                                stok_kodu: stok_kodu,
                                stok_adi: stokAdi,
                                barkod: barkod,
                                birim_adi: birim,
                                ana_grup_adi: ana_grupid,
                                altgrup_adi: altGrupid,
                                alis_tutar: alis_tutar,
                                satis_tutar: satis_tutar,
                                giren_miktar: giren_miktar,
                                cikan_miktar: cikan_miktar,
                                maliyet_tutar: maliyet_tutar,
                                toplam_mal_tutari: elimdeki_maliyet,
                                kalan_miktar: kalan_miktar
                            })
                        });
                        toplam_giren = toplam_giren.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        toplam_cikan = toplam_cikan.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        toplam_alis = toplam_alis.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        toplam_envater = toplam_envater.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        toplam_satis = toplam_satis.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        toplam_maliyet = toplam_maliyet.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        $(".toplam_giren").html("");
                        $(".toplam_giren").html(toplam_giren);
                        $(".toplam_cikan").html("");
                        $(".toplam_cikan").html(toplam_cikan);
                        $(".envanter_tutari").html("");
                        $(".envanter_tutari").html(toplam_envater + " TL");
                        $(".toplam_alis").html("");
                        $(".toplam_alis").html(toplam_alis + " TL");
                        $(".toplam_satis").html("");
                        $(".toplam_satis").html(toplam_satis + " TL");
                        $(".maliyet").html("");
                        $(".maliyet").html(toplam_maliyet + " TL");
                        table.rows.add(arr).draw(false);
                    }

                })
        });

        $("body").off("click", "#hizmet_ekstresi").on("click", "#hizmet_ekstresi", function () {
            $(".stok_page_color").removeClass("active");
            $(".stok_page_color").removeClass("secilen_modul");
            $("#stok_ekstre_tekrar_filtre").attr("data-name", "hizmet_filter");
            $("#alinan_hizmet").html("Alınan Hizmet");
            $("#yapilan_hizmet").html("Verilen Hizmet");
            $("#toplam_hizmet").html("Toplam Hizmet");
            $("#hizmet_alis").html("Alınan Hizmet Tutarı");
            $("#hizmet_satis").html("Verilen Hizmet Tutarı");
            $("#toplam_hizmet_tutari").html("Toplam Hizmet Bedeli");
            $("#envanter_tutari").html("");
            $(this).addClass("active");
            $(this).addClass("secilen_modul");

            $(".toplam_giren").html("");
            $(".toplam_cikan").html("");
            $(".envanter_tutari").html("");
            $(".toplam_alis").html("");
            $(".toplam_satis").html("");
            $(".maliyet").html("");
            $("#stok_id_filter").attr("data-id", "");
            $("#stok_id_filter").val("");
            $(".stok_adi_getir").val("");
            table.clear().draw(false);
            $.get("controller/ekstre_controller/sql.php?islem=hizmet_genel_ekstre",
                {
                    bas_tarih: $("#bas_tarih").val(),
                    bit_tarih: $("#bit_tarih").val()
                }
                , function (result) {
                    if (result != 2) {
                        var json = JSON.parse(result);

                        let arr = [];
                        let toplam_giren = 0;
                        let toplam_cikan = 0;
                        let toplam_alis = 0;
                        let toplam_satis = 0;
                        let toplam_maliyet = 0;
                        let toplam_envater = 0;
                        let toplam_kalan = 0;
                        json.forEach(function (item) {
                            var stok_kodu = item.stok_kodu;
                            var stokAdi = item.stok_adi;
                            var barkod = item.barkod;
                            var ana_grupid = item.ana_grup_adi;
                            var altGrupid = item.altgrup_adi;
                            var birim = item.birim_adi;
                            var giren_miktar = item.giren_miktar;
                            var cikan_miktar = item.cikan_miktar;
                            cikan_miktar = parseFloat(cikan_miktar);
                            toplam_cikan += cikan_miktar;
                            giren_miktar = parseFloat(giren_miktar)
                            var elimdeki_maliyet = item.elimdeki_maliyet;
                            elimdeki_maliyet = parseFloat(elimdeki_maliyet)
                            toplam_envater += elimdeki_maliyet;
                            var alis_tutar = item.alis_tutar;
                            alis_tutar = parseFloat(alis_tutar)
                            toplam_alis += alis_tutar;
                            var satis_tutar = item.satis_tutar;
                            satis_tutar = parseFloat(satis_tutar)
                            toplam_satis += satis_tutar;
                            var maliyet_tutar = item.maliyet_tutar;
                            maliyet_tutar = parseFloat(maliyet_tutar)
                            toplam_maliyet += satis_tutar;
                            var kalan_miktar = giren_miktar + cikan_miktar;
                            toplam_kalan += kalan_miktar;
                            kalan_miktar = parseFloat(kalan_miktar);
                            toplam_giren += giren_miktar;
                            giren_miktar = giren_miktar.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            satis_tutar = satis_tutar.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            maliyet_tutar = maliyet_tutar.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            alis_tutar = alis_tutar.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            elimdeki_maliyet = elimdeki_maliyet.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            cikan_miktar = cikan_miktar.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            kalan_miktar = kalan_miktar.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            arr.push({
                                stok_kodu: stok_kodu,
                                stok_adi: stokAdi,
                                barkod: barkod,
                                birim_adi: birim,
                                ana_grup_adi: ana_grupid,
                                altgrup_adi: altGrupid,
                                alis_tutar: alis_tutar,
                                satis_tutar: satis_tutar,
                                giren_miktar: giren_miktar,
                                cikan_miktar: cikan_miktar,
                                maliyet_tutar: satis_tutar,
                                toplam_mal_tutari: "",
                                kalan_miktar: kalan_miktar
                            })
                        });
                        toplam_giren = toplam_giren.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        toplam_cikan = toplam_cikan.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        toplam_alis = toplam_alis.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        toplam_envater = toplam_envater.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        toplam_satis = toplam_satis.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        toplam_maliyet = toplam_maliyet.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        toplam_kalan = toplam_kalan.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        $(".toplam_giren").html("");
                        $(".toplam_giren").html(toplam_giren);
                        $(".toplam_cikan").html("");
                        $(".toplam_cikan").html(toplam_cikan);
                        $(".envanter_tutari").html("");
                        $(".toplam_alis").html("");
                        $(".toplam_alis").html(toplam_alis + " TL");
                        $(".toplam_satis").html("");
                        $(".toplam_satis").html(toplam_satis + " TL");
                        $(".maliyet").html("");
                        $(".maliyet").html(toplam_maliyet + " TL");
                        $(".kalan_miktar").html("");
                        $(".kalan_miktar").html(toplam_kalan);
                        table.rows.add(arr).draw(false);
                    }

                })
        });
        $("body").off("click", "#stok_ekstre_tekrar_filtre").on("click", "#stok_ekstre_tekrar_filtre", function () {
            let data_name = $(this).attr("data-name");
            let islem = "";
            if (data_name == "stok_filter") {
                islem = "stok_genel_ekstre";
            } else {
                islem = "hizmet_genel_ekstre";
            }
            $.get("controller/ekstre_controller/sql.php?islem=" + islem + "",
                {
                    bas_tarih: $("#bas_tarih").val(),
                    bit_tarih: $("#bit_tarih").val()
                }
                , function (result) {
                    if (result != 2) {
                        var json = JSON.parse(result);
                        table.clear().draw(false);
                        let arr = [];
                        let toplam_giren = 0;
                        let toplam_cikan = 0;
                        let toplam_alis = 0;
                        let toplam_satis = 0;
                        let toplam_maliyet = 0;
                        let toplam_envater = 0;
                        json.forEach(function (item) {
                            var stok_kodu = item.stok_kodu;
                            var stokAdi = item.stok_adi;
                            var barkod = item.barkod;
                            var ana_grupid = item.ana_grup_adi;
                            var altGrupid = item.altgrup_adi;
                            var birim = item.birim_adi;
                            var giren_miktar = item.giren_miktar;
                            var cikan_miktar = item.cikan_miktar;
                            cikan_miktar = parseFloat(cikan_miktar);
                            toplam_cikan += cikan_miktar;
                            giren_miktar = parseFloat(giren_miktar)
                            var elimdeki_maliyet = item.elimdeki_maliyet;
                            elimdeki_maliyet = parseFloat(elimdeki_maliyet)
                            toplam_envater += elimdeki_maliyet;
                            var alis_tutar = item.alis_tutar;
                            alis_tutar = parseFloat(alis_tutar)
                            toplam_alis += alis_tutar;
                            var satis_tutar = item.satis_tutar;
                            satis_tutar = parseFloat(satis_tutar)
                            toplam_satis += satis_tutar;
                            var maliyet_tutar = item.maliyet_tutar;
                            maliyet_tutar = parseFloat(maliyet_tutar)
                            toplam_maliyet += maliyet_tutar;
                            var kalan_miktar = giren_miktar - cikan_miktar;
                            kalan_miktar = parseFloat(kalan_miktar);
                            toplam_giren += giren_miktar;
                            giren_miktar = giren_miktar.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            satis_tutar = satis_tutar.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            maliyet_tutar = maliyet_tutar.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            alis_tutar = alis_tutar.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            elimdeki_maliyet = elimdeki_maliyet.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            cikan_miktar = cikan_miktar.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            kalan_miktar = kalan_miktar.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            arr.push({
                                stok_kodu: stok_kodu,
                                stok_adi: stokAdi,
                                barkod: barkod,
                                birim_adi: birim,
                                ana_grup_adi: ana_grupid,
                                altgrup_adi: altGrupid,
                                alis_tutar: alis_tutar,
                                satis_tutar: satis_tutar,
                                giren_miktar: giren_miktar,
                                cikan_miktar: cikan_miktar,
                                maliyet_tutar: maliyet_tutar,
                                toplam_mal_tutari: elimdeki_maliyet,
                                kalan_miktar: kalan_miktar
                            })
                        });
                        toplam_giren = toplam_giren.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        toplam_cikan = toplam_cikan.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        toplam_alis = toplam_alis.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        toplam_envater = toplam_envater.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        toplam_satis = toplam_satis.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        toplam_maliyet = toplam_maliyet.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        $(".toplam_giren").html("");
                        $(".toplam_giren").html(toplam_giren);
                        $(".toplam_cikan").html("");
                        $(".toplam_cikan").html(toplam_cikan);
                        $(".envanter_tutari").html("");
                        $(".envanter_tutari").html(toplam_envater + " TL");
                        $(".toplam_alis").html("");
                        $(".toplam_alis").html(toplam_alis + " TL");
                        $(".toplam_satis").html("");
                        $(".toplam_satis").html(toplam_satis + " TL");
                        $(".maliyet").html("");
                        $(".maliyet").html(toplam_maliyet + " TL");
                        table.rows.add(arr).draw(false);
                    }

                })
        })
    });
</script>