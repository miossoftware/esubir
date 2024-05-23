<style>
    .edit_list td {
        text-align: left;
    }

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
        <div class="ibox-title" style=' font-weight:bold;'>CARİ BORÇ ALACAK DURUM RAPORU</div>
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
        <div class="col-1 mx-2">
            <select class="custom-select custom-select-sm" id="cari_turu_getir">
                <option value="">Cari Türü Seçiniz...</option>
                <option value="0" selected>HEPSİ</option>
            </select>
        </div>
        <div class="col-1 mx-2">
            <button class="btn btn-secondary btn-sm" id="cari_borc_alacak_filtrele"><i class="fa fa-filter"></i> Hazırla
            </button>
        </div>
    </div>
    <div class="col-12 row mt-3">
        <table class="table table-sm table-bordered w-100  nowrap edit_list"
               style="cursor:pointer;font-size: 13px;"
               id="cari_table">
            <thead>
            <tr>
                <th>Cari Kodu</th>
                <th>Cari Ünvan</th>
                <th>Bilanço Kodu</th>
                <th>Cari Türü</th>
                <th>Borç</th>
                <th>Alacak</th>
                <th>Bakiyesi</th>
                <th>Durum</th>
            </tr>
            </thead>
            <tfoot style="background-color: white">
            <tr>
                <th colspan="4" style="text-align: right; font-size: 14px;">TOPLAM:</th>
                <th style="text-align: right; font-size: 14px;" class="toplam_borc"></th>
                <th style="text-align: right; font-size: 14px;" class="toplam_alacak">Alacak</th>
                <th style="text-align: right; font-size: 14px;" class="genel_bakiye">0,00</th>
                <th style="text-align: center; font-size: 14px;" class="borc_durumu">YOK</th>
            </tr>
            </tfoot>
        </table>
    </div>
    <!--    <div class="col-12 row no-gutters mt-2">-->
    <!--        <div class="col-8"></div>-->
    <!--        <div class="col-3">-->
    <!--            <table class="table table-sm table-bordered w-100 display nowrap" style="background-color: white">-->
    <!--                <thead>-->
    <!--                <tr>-->
    <!--                    <th style="text-align: center">Toplam Borç</th>-->
    <!--                    <th style="text-align: center">Toplam Alacak</th>-->
    <!--                </tr>-->
    <!--                </thead>-->
    <!--                <tbody>-->
    <!--                <tr>-->
    <!--                    <td class="toplam_borc" style="text-align: right">0,00 TL</td>-->
    <!--                    <td class="toplam_alacak" style="text-align: right">0,00 TL</td>-->
    <!--                </tr>-->
    <!--                </tbody>-->
    <!--            </table>-->
    <!--        </div>-->
    <!--    </div>-->
</div>
<script>

    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });

    $(document).ready(function () {

        $.get("controller/ekstre_controller/sql.php?islem=cari_turleri_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                json.forEach(function (item) {
                    if (item.gider_hesabi == 1) {

                    } else {
                        $("#cari_turu_getir").append("" +
                            "<option value='" + item.id + "'>" + item.cari_turu_adi + "</option>" +
                            "");
                    }
                })
            }
        })

        $.get("controller/ekstre_controller/sql.php?islem=cari_borc_alacak_durumu_filtrele",
            {
                bas_tarih: $("#bas_tarih").val(),
                bit_tarih: $("#bit_tarih").val()
            }
            , function (result) {
                if (result != 2) {
                    let toplam_borc = 0;
                    let toplam_alacak = 0;
                    var json = JSON.parse(result);
                    let arr = [];
                    json.forEach(function (item) {
                        let borc = item.borc;
                        borc = parseFloat(borc);
                        let alacak = item.alacak;
                        alacak = parseFloat(alacak)
                        let bakiye = parseFloat(borc) - parseFloat(alacak);
                        if (isNaN(bakiye)) {
                            bakiye = 0;
                        }
                        if (isNaN(borc)) {
                            borc = 0;
                        }
                        if (isNaN(alacak)) {
                            alacak = 0;
                        }
                        let b_durum = "";
                        if (bakiye > 0) {
                            b_durum = "B";
                        } else if (bakiye < 0) {
                            b_durum = "A";
                            bakiye = -bakiye
                        } else {
                            b_durum = "YOK";
                        }
                        if (bakiye == 0) {

                        } else {
                            toplam_borc += borc;
                            toplam_alacak += alacak;
                            borc = borc.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            alacak = alacak.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            bakiye = bakiye.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            if (bakiye != "0,00") {
                                var newRecord = {
                                    cari_kodu: item.cari_kodu,
                                    cari_unvan: item.cari_unvan,
                                    bilanco_kodu: item.bilanco_kodu,
                                    cari_grubu: item.cari_grubu,
                                    borc: borc,
                                    alacak: alacak,
                                    bakiye: bakiye,
                                    b_durum: b_durum
                                };
                                arr.push(newRecord);
                            }
                        }
                    })
                    let b_durum = "";
                    let bakiye = toplam_alacak - toplam_borc;
                    if (bakiye < 0) {
                        bakiye = -bakiye
                        b_durum = "B";
                    } else {
                        b_durum = "A";
                    }

                    bakiye = bakiye.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    toplam_borc = toplam_borc.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    toplam_alacak = toplam_alacak.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    $(".toplam_borc").html("");
                    $(".toplam_borc").html(toplam_borc);
                    $(".toplam_alacak").html("");
                    $(".toplam_alacak").html(toplam_alacak);
                    $(".genel_bakiye").html("");
                    $(".genel_bakiye").html(bakiye);
                    $(".borc_durumu").html("");
                    $(".borc_durumu").html(b_durum);

                    table.rows.add(arr).draw(false);
                }
            });

        // $.get("controller/cari_controller/sql.php?islem=carileri_getir", function (result) {
        //     if (result != 2) {
        //         let toplam_borc = 0;
        //         let toplam_alacak = 0;
        //         var json = JSON.parse(result);
        //         let arr = [];
        //         json.forEach(function (item) {
        //             let borc = item.borc;
        //             borc = parseFloat(borc);
        //             let alacak = item.alacak;
        //             alacak = parseFloat(alacak)
        //             let bakiye = parseFloat(borc) - parseFloat(alacak);
        //             if (isNaN(bakiye)) {
        //                 bakiye = 0;
        //             }
        //             if (isNaN(borc)) {
        //                 borc = 0;
        //             }
        //             if (isNaN(alacak)) {
        //                 alacak = 0;
        //             }
        //             let b_durum = "";
        //             if (bakiye > 0) {
        //                 b_durum = "B";
        //             } else if (bakiye < 0) {
        //                 b_durum = "A";
        //                 bakiye = -bakiye
        //             } else {
        //                 b_durum = "YOK";
        //             }
        //             if (bakiye == 0) {
        //
        //             } else {
        //                 toplam_borc += borc;
        //                 toplam_alacak += alacak;
        //                 borc = borc.toLocaleString("tr-TR", {minimumFractionDigits: 2});
        //                 alacak = alacak.toLocaleString("tr-TR", {minimumFractionDigits: 2});
        //                 bakiye = bakiye.toLocaleString("tr-TR", {minimumFractionDigits: 2});
        //
        //                 var karakterSiniri = 17; // Metin sınırı
        //                 let metin = item.cari_adi;
        //                 if (metin.length > karakterSiniri) {
        //                     metin = metin.substring(0, karakterSiniri) + "...";
        //                 }
        //
        //
        //
        //                 var newRecord = {
        //                     cari_kodu: item.cari_kodu,
        //                     cari_unvan: metin,
        //                     bilanco_kodu: item.bilanco_kodu,
        //                     cari_grubu: item.cari_grubu,
        //                     borc: borc,
        //                     alacak: alacak,
        //                     bakiye: bakiye,
        //                     b_durum: b_durum
        //                 };
        //                 arr.push(newRecord);
        //             }
        //         })
        //         toplam_borc = toplam_borc.toLocaleString("tr-TR", {minimumFractionDigits: 2});
        //         toplam_alacak = toplam_alacak.toLocaleString("tr-TR", {minimumFractionDigits: 2});
        //         $(".toplam_borc").html("");
        //         $(".toplam_borc").html(toplam_borc);
        //         $(".toplam_alacak").html("");
        //         $(".toplam_alacak").html(toplam_alacak);
        //         table.rows.add(arr).draw(false);
        //     }
        // })

        var targetColumns = [4, 5, 6];
        var table = $('#cari_table').DataTable({
            paging: false,
            scrollX: true,
            scrollY: "55vh",
            "info": false,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "CARİ BORÇ ALACAK DURUMU",
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
            columns: [
                {"data": "cari_kodu"},
                {"data": "cari_unvan"},
                {"data": "bilanco_kodu"},
                {"data": "cari_grubu"},
                {"data": "borc"},
                {"data": "alacak"},
                {"data": "bakiye"},
                {"data": "b_durum"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find("td").eq(4).css("text-align", "right");
                $(row).find("td").eq(5).css("text-align", "right");
                $(row).find("td").eq(6).css("text-align", "right");
                $(row).find("td").eq(7).css("text-align", "center");
            },
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        })
        $("body").off("click", "#cari_borc_alacak_filtrele").on("click", "#cari_borc_alacak_filtrele", function () {
            let bas_tarih = $("#bas_tarih").val();
            let bit_tarih = $("#bit_tarih").val();
            let cari_grubu = $("#cari_turu_getir").val();
            $.get("controller/ekstre_controller/sql.php?islem=cari_borc_alacak_durumu_filtrele",
                {
                    bas_tarih: bas_tarih,
                    bit_tarih: bit_tarih,
                    cari_turu: cari_grubu
                }
                , function (result) {
                    if (result != 2) {
                        let toplam_borc = 0;
                        let toplam_alacak = 0;
                        table.clear().draw(false);
                        var json = JSON.parse(result);
                        let arr = [];
                        json.forEach(function (item) {
                            let borc = item.borc;
                            borc = parseFloat(borc);
                            let alacak = item.alacak;
                            alacak = parseFloat(alacak)
                            let bakiye = parseFloat(borc) - parseFloat(alacak);
                            if (isNaN(bakiye)) {
                                bakiye = 0;
                            }
                            if (isNaN(borc)) {
                                borc = 0;
                            }
                            if (isNaN(alacak)) {
                                alacak = 0;
                            }
                            let b_durum = "";
                            if (bakiye > 0) {
                                b_durum = "B";
                            } else if (bakiye < 0) {
                                b_durum = "A";
                                bakiye = -bakiye
                            } else {
                                b_durum = "YOK";
                            }
                            if (bakiye == 0) {

                            } else {
                                toplam_borc += borc;
                                toplam_alacak += alacak;
                                borc = borc.toLocaleString("tr-TR", {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                                alacak = alacak.toLocaleString("tr-TR", {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                                bakiye = bakiye.toLocaleString("tr-TR", {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                                var newRecord = {
                                    cari_kodu: item.cari_kodu,
                                    cari_unvan: item.cari_unvan,
                                    bilanco_kodu: item.bilanco_kodu,
                                    cari_grubu: item.cari_grubu,
                                    borc: borc,
                                    alacak: alacak,
                                    bakiye: bakiye,
                                    b_durum: b_durum
                                };
                                arr.push(newRecord);
                            }
                        })

                        let b_durum = "";
                        let bakiye = toplam_alacak - toplam_borc;
                        if (bakiye < 0) {
                            bakiye = -bakiye
                            b_durum = "B";
                        } else {
                            b_durum = "A";
                        }


                        bakiye = bakiye.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        toplam_borc = toplam_borc.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        toplam_alacak = toplam_alacak.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });


                        $(".toplam_borc").html("");
                        $(".toplam_borc").html(toplam_borc);
                        $(".toplam_alacak").html("");
                        $(".toplam_alacak").html(toplam_alacak);
                        $(".genel_bakiye").html("");
                        $(".genel_bakiye").html(bakiye);
                        $(".borc_durumu").html("");
                        $(".borc_durumu").html(b_durum);

                        table.rows.add(arr).draw(false);
                    }
                });
        });
    });

</script>