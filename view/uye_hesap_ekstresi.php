<style>
    .excel_alis {
        background-color: #2ecc71 !important;
        border-color: #27ad60 !important;
        color: white !important;
        border-radius: 20px !important;
        font-weight: bold !important;
    }
</style>
<div class="ibox-container">
    <div class="cari_getir_div_ekstre"></div>
    <div class="ibox mt-5">
        <div class="ibox-head">
            <div class="ibox-title" style=' font-weight:bold;'>ÜYE HESAP EKSTRESİ</div>
        </div>
        <div class="col-12 row no-gutters mt-3">
            <div class="col-md-1">
                <div class="input-group mb-3">
                    <input type="text" class="form-control form-control-sm secilen_cari"
                           aria-describedby="basic-addon1" id="cari_id_filter" placeholder="TC No">
                    <div class="input-group-append">
                        <button class="btn btn-warning btn-sm" id="cari_getir_modal"><i
                                class="fa fa-ellipsis-h"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mx-1">
                <input type="text" style="background-color: #e08e0b; font-weight: bold;color: white !important;"
                       class="form-control form-control-sm cari_adi_getir" disabled value="Üye Adı">
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
                <button class="btn btn-secondary btn-sm" id="ekstre_filtrele"><i class="fa fa-filter"></i> Hazırla
                </button>
            </div>
        </div>
        <div class="mt-3"></div>
        <div class="hesap_ekstre_genel_main">
            <div class="col-12 row mt-3">
                <table class="table table-sm table-bordered w-100  nowrap edit_list"
                       style="cursor:pointer;font-size: 13px;"
                       id="cari_hesap_ekstresi_listesi_rapor">
                    <thead>
                    <tr>
                        <th style="width: 0%">Tarih</th>
                        <th style="width: 1%">Belge No</th>
                        <th style="width: 1%">Belge Türü</th>
                        <th style="width: 2%">Açıklama</th>
                        <th style="width: 0%">Döviz Türü</th>
                        <th style="width: 1%">Borç</th>
                        <th style="width: 1%">Alacak</th>
                        <th style="width: 1%">Bakiye</th>
                        <th style="width: 0%">Durum</th>
                        <th style="width: 1%">Vade Tarihi</th>
                    </tr>
                    </thead>
                    <tfoot style="background-color: white">
                    <tr>
                        <th colspan="4" style="text-align: right; font-size: 14px;">TOPLAM:</th>
                        <th style="text-align: right; font-size: 14px;" class="toplam_borc">0,00</th>
                        <th style="text-align: right; font-size: 14px;" class="toplam_alacak">0,00</th>
                        <th style="text-align: right; font-size: 14px;" class="toplam_bakiye">0,00</th>
                        <th style="text-align: center; font-size: 14px;" class="b_durum_son">YOK</th>
                        <th style="text-align: center; font-size: 14px;" class=""></th>
                    </tr>
                    </tfoot>
                </table>

            </div>
        </div>
        <div class="paging_ekstre"></div>
        <!--        <div class="col-12 row no-gutters mt-1">-->
        <!--            <div class="col-3"></div>-->
        <!--            <div class="col-5">-->
        <!--                <table class="table table-sm table-bordered w-100 display nowrap" style="background-color: white">-->
        <!--                    <thead>-->
        <!--                    <tr>-->
        <!--                        <th style="text-align: center">Borç</th>-->
        <!--                        <th style="text-align: center">Alacak</th>-->
        <!--                        <th style="text-align: center">Bakiye</th>-->
        <!--                        <th style="text-align: center">Durum</th>-->
        <!--                    </tr>-->
        <!--                    </thead>-->
        <!--                    <tbody>-->
        <!--                    <tr>-->
        <!--                        <td class="toplam_borc" style="text-align: right">0,00 TL</td>-->
        <!--                        <td class="toplam_alacak" style="text-align: right">0,00 TL</td>-->
        <!--                        <td class="toplam_bakiye" style="text-align: right">0,00 TL</td>-->
        <!--                        <td class="b_durum_son" style="text-align: center">YOK</td>-->
        <!--                    </tr>-->
        <!--                    </tbody>-->
        <!--                </table>-->
        <!--            </div>-->
        <!--            <div class="col-3">-->
        <!--            </div>-->
        <!--        </div>-->
    </div>
</div>
<script>

    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });

    $("body").off("click", "#hesap_ekstre_genel").on("click", "#hesap_ekstre_genel", function () {
        $(".cari_page_color").removeClass("active");
        $(this).addClass("active");
        $(".hesap_ekstre_genel_main").show();
        $(".paging_ekstre").html("");
    })
    $("body").off("click", "#cari_alis_irsaliyeleri").on("click", "#cari_alis_irsaliyeleri", function () {
        $(".cari_page_color").removeClass("active");
        $(this).addClass("active");
        let filtrele_calistimi = $("#ekstre_filtrele").attr("data-name");
        if (filtrele_calistimi == "filtrele_calisti") {
            let cari_id = $("#cari_id_filter").attr("data-id");
            $.get("modals/ekstre_modal.php?islem=cariye_ait_acik_irsaliye_getir", {cari_id: cari_id}, function (getModal) {
                $(".paging_ekstre").html("");
                $(".paging_ekstre").html(getModal);
                $(".hesap_ekstre_genel_main").hide();
            })
        } else {
            $.get("modals/ekstre_modal.php?islem=cariye_ait_acik_irsaliye_getir", function (getModal) {
                $(".paging_ekstre").html("");
                $(".paging_ekstre").html(getModal);
                $(".hesap_ekstre_genel_main").hide();
            })
        }
    })
    $("body").off("click", "#cari_satis_irsaliyeleri").on("click", "#cari_satis_irsaliyeleri", function () {
        $(".cari_page_color").removeClass("active");
        $(this).addClass("active");
        let filtrele_calistimi = $("#ekstre_filtrele").attr("data-name");
        if (filtrele_calistimi == "filtrele_calisti") {
            let cari_id = $("#cari_id_filter").attr("data-id");
            $.get("modals/ekstre_modal.php?islem=cariye_ait_acik_satis_irsaliye_getir", {cari_id: cari_id}, function (getModal) {
                $(".paging_ekstre").html("");
                $(".paging_ekstre").html(getModal);
                $(".hesap_ekstre_genel_main").hide();
            })
        } else {
            $.get("modals/ekstre_modal.php?islem=cariye_ait_acik_satis_irsaliye_getir", function (getModal) {
                $(".paging_ekstre").html("");
                $(".paging_ekstre").html(getModal);
                $(".hesap_ekstre_genel_main").hide();
            })
        }
    })

    var table = "";

    $("body").off("keyup", "#cari_id_filter").on("keyup", "#cari_id_filter", function () {
        let val = $(this).val();
        $.get("controller/uye_controller/sql.php?islem=uye_bilgileri_getir_sql", {cari_kodu: val}, function (result) {
            if (result != 2) {
                var item = JSON.parse(result);
                $("#cari_id_filter").attr("data-id", item.id);
                $("#cari_id_filter").val(item.tc_no);
                $(".cari_adi_getir").val((item.uye_adi).toUpperCase());
            } else {
                $("#cari_id_filter").attr("data-id", "");
                $(".cari_adi_getir").val("Cari Adı");
            }
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

        var targetColumns = [4, 5, 6];
        table = $('#cari_hesap_ekstresi_listesi_rapor').DataTable({
            paging: false,
            scrollX: true,
            scrollY: "55vh",
            ordering: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "CARİ HESAP EKSTRESİ",
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
            "info": false,
            columns: [
                {"data": "tarih", "type": "date-eu"},
                {"data": "belge_no"},
                {"data": "belge_turu"},
                {"data": "aciklama"},
                {"data": "doviz_turu"},
                {"data": "borc"},
                {"data": "alacak"},
                {"data": "bakiye"},
                {"data": "b_durum"},
                {"data": "vade_tarihi"}
            ],
            "order": [[0, 'asc']],
            createdRow: function (row, data, dataIndex) {
                $(row).find("td").eq(0).css("text-align", "left");
                $(row).find("td").eq(1).css("text-align", "left");
                $(row).find("td").eq(2).css("text-align", "left");
                $(row).find("td").eq(3).css("text-align", "left");
                $(row).find("td").eq(7).css("text-align", "center");
                $(row).find("td").eq(8).css("text-align", "left");
            },
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        })
    })
    $("body").off("click", "#cari_getir_modal").on("click", "#cari_getir_modal", function () {
        $.get("modals/ekstre_modal.php?islem=cariler_listesi_getir_modal",{from:"uye_ekstre"}, function (getModal) {
            $(".cari_getir_div_ekstre").html("");
            $(".cari_getir_div_ekstre").html(getModal);
        })
    });

    $("body").off("click", "#ekstre_filtrele").on("click", "#ekstre_filtrele", function () {
        var toplam_borc = 0;
        var toplam_alacak = 0;
        var cari_id = $("#cari_id_filter").attr("data-id");
        let bas_tarih = $("#bas_tarih").val();
        let bit_tarih = $("#bit_tarih").val();
        let doviz_turu = $("#doviz_turu").val();
        $.get("controller/uye_controller/sql.php?islem=uye_hesap_ekstre_getir", {
            cari_id: cari_id,
            bas_tarih: bas_tarih,
            doviz_turu: doviz_turu,
            bit_tarih: bit_tarih
        }, function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                var basilacak = [];
                table.clear().draw(false);
                $("#ekstre_filtrele").attr("data-name", "filtrele_calisti");
                json.forEach(function (item) {
                    let gonderilen_tarih = item.tarih;
                    if (gonderilen_tarih == null) {

                    } else {
                        gonderilen_tarih = gonderilen_tarih.split(" ");
                        gonderilen_tarih = gonderilen_tarih[0];
                        gonderilen_tarih = gonderilen_tarih.split("-");
                        var gun = gonderilen_tarih[2];
                        var ay = gonderilen_tarih[1];
                        var yil = gonderilen_tarih[0];
                        var arr = [gun, ay, yil];
                        gonderilen_tarih = arr.join("/");
                    }


                    var karakterSiniri = 65; // Metin sınırı
                    let metin = item.aciklama;
                    if (metin.length > karakterSiniri) {
                        metin = metin.substring(0, karakterSiniri) + "...";
                    }

                    let vade_tarih = item.vade_tarihi;
                    if (vade_tarih == null) {

                    } else {
                        vade_tarih = vade_tarih.split(" ");
                        vade_tarih = vade_tarih[0];
                        vade_tarih = vade_tarih.split("-");
                        var gun1 = vade_tarih[2];
                        var ay1 = vade_tarih[1];
                        var yil1 = vade_tarih[0];
                        var arr1 = [gun1, ay1, yil1];
                        vade_tarih = arr1.join("/");
                    }

                    var borc = item.borc;
                    var alacak = item.alacak;
                    borc = parseFloat(borc);
                    toplam_borc += borc;
                    alacak = parseFloat(alacak);
                    toplam_alacak += alacak;
                    borc = borc.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    alacak = alacak.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    var bakiye = item.bakiye;
                    bakiye = parseFloat(bakiye);
                    bakiye = bakiye.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    basilacak.push({
                        tarih: gonderilen_tarih,
                        belge_no: item.belge_no,
                        belge_turu: item.belge_turu.toUpperCase(),
                        aciklama: metin.toUpperCase(),
                        borc: borc,
                        alacak: alacak,
                        bakiye: bakiye,
                        b_durum: item.b_durum,
                        vade_tarihi: vade_tarih,
                        doviz_turu:item.doviz_tur
                    })
                });
                let bdurum = "";
                let bakiye = toplam_borc - toplam_alacak;
                if (bakiye < 0) {
                    bakiye = -bakiye;
                    bdurum = "A";
                } else {
                    bdurum = "B";
                }
                toplam_borc = toplam_borc.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                toplam_alacak = toplam_alacak.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                bakiye = bakiye.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                $(".toplam_borc").html("");
                $(".toplam_borc").html(toplam_borc);
                $(".toplam_alacak").html("");
                $(".toplam_alacak").html(toplam_alacak);
                $(".toplam_bakiye").html("");
                $(".toplam_bakiye").html(bakiye);
                $(".b_durum_son").html("");
                $(".b_durum_son").html(bdurum);
                table.rows.add(basilacak).draw(false);
            }
        })
    });
</script>