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
    <div class="ibox mt-5">
        <div class="ibox-head">
            <div class="ibox-title" style='font-weight:bold;'>KREDİ KARTI HESAP EKSTRESİ</div>
        </div>
        <div class="col-12 row no-gutters mt-3">
            <div class="col-md-1">
                <div class="input-group mb-3">
                    <input type="text" class="form-control form-control-sm secilen_kart"
                           aria-describedby="basic-addon1" id="banka_id" placeholder="Kart Kodu">
                    <div class="input-group-append">
                        <button class="btn btn-warning btn-sm" id="kart_adi_button"><i
                                    class="fa fa-ellipsis-h"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-2 mx-1">
                <input type="text" class="form-control form-control-sm kart_adi_getir"
                       style="background-color: #e08e0b; font-weight: bold;color: white !important;" disabled
                       value="Kart Adı">
            </div>
            <div class="col-md-2 mx-1">
                <input type="text" class="form-control form-control-sm sube_adi_getir"
                       style="background-color: #e08e0b; font-weight: bold;color: white !important;" disabled
                       value="Şube Adı">
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
                <button class="btn btn-secondary btn-sm" id="kredi_kart_ekstre_filtrele"><i class="fa fa-filter"></i>
                    Hazırla
                </button>
            </div>
        </div>
        <div class="col-12 row">
            <table class="table table-sm table-bordered w-100 nowrap" id="kredi_karti_ekstre_main_list"
                   style="font-size: 13px;">
                <thead>
                <tr>
                    <th>Tarih</th>
                    <th>Belge Türü</th>
                    <th>Cari Adı / Banka Adı</th>
                    <th>Açıklama</th>
                    <th>Borç</th>
                    <th>Alacak</th>
                    <th>Bakiye</th>
                    <th>Durum</th>
                    <th>Vade Tarihi</th>
                </tr>
                </thead>
                <!--                <tfoot style="background-color: white">-->
                <!--                <tr>-->
                <!--                    <th colspan="3" style="text-align: right; font-size: 14px;">TOPLAM:</th>-->
                <!--                    <th style="text-align: right; font-size: 14px;" class="toplam_cekilen_kart">0,00 TL</th>-->
                <!--                    <th style="text-align: right; font-size: 14px;" class="toplam_yatan_kart">0,00 TL</th>-->
                <!--                    <th style="text-align: right; font-size: 14px;" class="toplam_bakiye_kart">0,00 TL</th>-->
                <!--                    <th style="text-align: right; font-size: 14px;" class="b_durum_son_kart">YOK</th>-->
                <!--                </tr>-->
                <!--                </tfoot>-->
            </table>
        </div>
    </div>
</div>
<script>

    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });
    var kart_hesap_ekstre = "";
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
        kart_hesap_ekstre = $('#kredi_karti_ekstre_main_list').DataTable({
            scrollY: '55vh',
            scrollX: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "KREDİ KARTI HESAP EKSTRESİ",
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
                {"data": "belge_turu"},
                {"data": "cari_adi"},
                {"data": "aciklama"},
                {"data": "borc"},
                {"data": "alacak"},
                {"data": "bakiye"},
                {"data": "b_durum"},
                {"data": "vade_tarihi"}
            ],
            "order": [[0, 'asc']],
            createdRow: function (row) {
                $(row).find("td").eq(0).css("text-align", "left");
                $(row).find("td").eq(1).css("text-align", "left");
                $(row).find("td").eq(2).css("text-align", "left");
                $(row).find("td").eq(3).css("text-align", "left");
                $(row).find("td").eq(4).css("text-align", "right");
                $(row).find("td").eq(4).css("text-align", "right");
                $(row).find("td").eq(8).css("text-align", "center");
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });
    });

    $("body").off("click", "#kredi_kart_ekstre_filtrele").on("click", "#kredi_kart_ekstre_filtrele", function () {
        let kart_id = $(".secilen_kart").attr("data-id");
        let bas_tarih = $("#bas_tarih").val();
        let bit_tarih = $("#bit_tarih").val();
        $.get("controller/kart_ekstre_controller/sql.php?islem=kredi_kart_ekstresini_getir",
            {
                kart_id: kart_id,
                bas_tarih: bas_tarih,
                bit_tarih: bit_tarih
            },
            function (result) {
                if (result != 2) {
                    kart_hesap_ekstre.clear().draw(false);
                    var json = JSON.parse(result);
                    var ekstre_arr = [];
                    json.forEach(function (item) {
                        let tarih = item.tarih;
                        let bakiye = item.bakiye;
                        tarih = tarih.split(" ");
                        tarih = tarih[0];
                        tarih = tarih.split("-");
                        let gun = tarih[2];
                        let ay = tarih[1];
                        let yil = tarih[0];
                        let arr = [gun, ay, yil];
                        tarih = arr.join("/");

                        let borc = item.borc;
                        let alacak = item.alacak;
                        borc = parseFloat(borc);
                        borc = borc.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        bakiye = parseFloat(bakiye);
                        bakiye = bakiye.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        alacak = parseFloat(alacak);
                        alacak = alacak.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});

                        let newRow = {
                            tarih: tarih,
                            belge_turu: item.belge_turu,
                            cari_adi: item.cari_adi,
                            aciklama: item.aciklama,
                            borc: borc,
                            alacak: alacak,
                            bakiye: bakiye,
                            b_durum: item.b_durum,
                            vade_tarihi: tarih,
                        };
                        ekstre_arr.push(newRow);
                    })
                    kart_hesap_ekstre.rows.add(ekstre_arr).draw(false);
                }
            });

    });

    $("body").off("click", "#kart_adi_button").on("click", "#kart_adi_button", function () {
        $.get("modals/kredi_kart_modal/another_modal.php?islem=kredi_kartlarini_getir", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

</script>