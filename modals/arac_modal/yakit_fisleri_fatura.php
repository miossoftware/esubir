<?php

$islem = $_GET["islem"];

if ($islem == "faturalanacak_yakit_fisleri_modal") {
    ?>
    <style>
        #binek_yakit_fatura_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="binek_yakit_fatura_modal" data-bs-keyboard="false" data-backdrop="static"
         role="dialog">
        <div class="modal-dialog" style="width: 70%; max-width: 70%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="konteyner_kiralik_yakit_cikis_vazgec"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'> İSTASYONDAN ALINAN FİŞLERİ
                                FATURALANDIR
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="fatura_icin_istasyonlari_getir_div"></div>
                            <div class="ibox-title" style="background-color: #9DB2BF;color: white;text-align: center">
                                <span>Filtreleme İçeriği</span>
                            </div>
                            <div class="col-12 row mt-3">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Cari Kodu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="cari_id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="yakit_fatura_cari"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Cari Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" disabled class="form-control form-control-sm"
                                                   id="cari_adi" style="font-weight: bold">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Başlangıç Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("1888-m-d") ?>" id="bas_tarih"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Bitiş Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" class="form-control form-control-sm" id="bit_tarih"
                                                   value="<?= date("Y-m-d") ?>">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary btn-sm"
                                                id="tumunu_sec_button"><i class="fa fa-check-square-o"></i>
                                            Tümünü Seç
                                        </button>
                                        <button class="btn btn-danger btn-sm"
                                                id="tumunu_kaldir_button" style="display: none"><i
                                                    class="fa fa-minus-square"></i>
                                            Tümünü Kaldır
                                        </button>
                                        <button class="btn btn-secondary btn-sm"
                                                id="kesilecek_yakit_fisleri_getir_button"><i class="fa fa-filter"></i>
                                            Hazırla
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row">
                                <table class="table table-sm table-bordered w-100 display nowrap"
                                       style="cursor:pointer;font-size: 13px;"
                                       id="konteyner_yakit_fis_fatura_list">
                                    <thead>
                                    <tr>
                                        <th style="width: 0% !important;">Seç</th>
                                        <th id="istasyonclick">İstasyon Kodu</th>
                                        <th>İstasyon Adı</th>
                                        <th>Plaka</th>
                                        <th>Tarih</th>
                                        <th>Araç Grubu</th>
                                        <th>Miktar</th>
                                        <th>Litre Fiyat</th>
                                        <th>Tutar</th>
                                    </tr>
                                    </thead>
                                    <tfoot style="background-color: white">
                                    <tr>
                                        <th colspan="4" style="text-align: right; font-size: 14px;">TOPLAM:</th>
                                        <th style="text-align: right; font-size: 14px;" class="secilmeyen_toplam">0,00
                                        </th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="mt-3"></div>
                            <div class="ibox-title" style="background-color: #9DB2BF;color: white;text-align: center">
                                <span>Fatura Bilgileri</span>
                            </div>
                            <div class="col-12 row mt-2">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Fatura No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="fatura_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Fatura Tarih</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>" id="fatura_tarihi"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-md-7">
                                            <textarea class="form-control form-control-sm" style="resize: none"
                                                      id="aciklama" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1"></div>
                                <div class="col-5">
                                    <div class="col-12 row no-gutters mt-2">
                                        <div class="col">
                                            <table class="table table-sm table-bordered w-80 nowrap"
                                                   style="font-size: 11px !important; font-weight: bold">
                                                <tr>
                                                    <th>#</th>
                                                </tr>
                                                <tr>
                                                    <th>Miktar</th>
                                                </tr>
                                                <tr>
                                                    <th>Ara Toplam</th>
                                                </tr>
                                                <tr>
                                                    <th>KDV Toplamı</th>
                                                </tr>
                                                <tr>
                                                    <th>Tevkifat Tutarı</th>
                                                </tr>
                                                <tr>
                                                    <th>İskonto Toplamı</th>
                                                </tr>
                                                <tr>
                                                    <th>Genel Toplam</th>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col">
                                            <table class="table table-sm table-bordered w-100 nowrap"
                                                   style="font-size: 11px !important;">
                                                <thead>
                                                <tr>
                                                    <th>TL Karşılığı</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="total_miktar" style="text-align: right">0,00 LT</td>
                                                </tr>
                                                <tr>
                                                    <td class="ara_toplam_bas" style="text-align: right">0,00 TL</td>
                                                </tr>
                                                <tr>
                                                    <td class="kdv_toplam_bas" style="text-align: right">0,00 TL</td>
                                                </tr>
                                                <tr>
                                                    <td class="tevkifat_tutari_bas" style="text-align: right">0,00 TL
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="iskonto_toplam_bas" style="text-align: right">0,00 TL
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="genel_toplam_bas" style="text-align: right">0,00 TL</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="konteyner_kiralik_yakit_cikis_vazgec"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="yakit_fislerini_faturalandir"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("body").off("click", "#tumunu_sec_button").on("click", "#tumunu_sec_button", function () {
            $("#tumunu_sec_button").hide();
            $("#tumunu_kaldir_button").show();
            toplam_tutar = 0;
            toplam_miktar = 0;
            $(".tum_yakitlar_list").each(function () {
                $(this).find("td:eq(0) input").prop("checked", true);
                $(this).find("td:eq(0) input").addClass("yakit_fisi_secildi");
                let tutar = $(this).find("td").eq(8).text();
                tutar = tutar.replace(/\./g, "").replace(",", ".");
                tutar = parseFloat(tutar);
                let miktar = $(this).find("td").eq(6).text();
                miktar = miktar.replace(/\./g, "").replace(",", ".");
                miktar = parseFloat(miktar);
                toplam_tutar += tutar;
                toplam_miktar += miktar;
            })
            let kdv_islem = "1." + kdv_orani;
            kdv_islem = parseFloat(kdv_islem);
            let ara_toplam = toplam_tutar / kdv_islem;
            let kdv_yuzde = parseFloat(kdv_orani) / 100;
            let kdv_tutar = ara_toplam * kdv_yuzde;
            $(".genel_toplam_bas").html("");
            $(".genel_toplam_bas").html(toplam_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }) + " TL")

            $(".ara_toplam_bas").html("");
            $(".ara_toplam_bas").html(ara_toplam.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }) + " TL")

            $(".kdv_toplam_bas").html("");
            $(".kdv_toplam_bas").html(kdv_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }) + " TL")
            $(".total_miktar").html("");
            $(".total_miktar").html(toplam_miktar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }) + " LT")
        });

        $("body").off("click", "#tumunu_kaldir_button").on("click", "#tumunu_kaldir_button", function () {
            $("#tumunu_sec_button").show();
            $("#tumunu_kaldir_button").hide();
            $(".tum_yakitlar_list").each(function () {
                $(this).find("td:eq(0) input").removeClass("yakit_fisi_secildi");
                $(this).find("td:eq(0) input").prop("checked", false);
            })
            toplam_tutar = 0;
            toplam_miktar = 0;
            $(".genel_toplam_bas").html("");
            $(".genel_toplam_bas").html("0,00 TL");


            $(".ara_toplam_bas").html("");
            $(".ara_toplam_bas").html("0,00 TL")

            $(".kdv_toplam_bas").html("");
            $(".kdv_toplam_bas").html("0,00 TL")

            $(".total_miktar").html("");
            $(".total_miktar").html("0,00 LT");
        });

        var yakit_fisleri_table = "";
        var toplam_tutar = 0;
        var kdv_orani = 0;
        var toplam_miktar = 0;

        $("body").off("click", "#yakit_fatura_cari").on("click", "#yakit_fatura_cari", function () {
            $.get("konteyner/modals/yakit_modal/ozmal_yakit_cikis.php?islem=istasyonlari_modal_getir", function (getModal) {
                $(".fatura_icin_istasyonlari_getir_div").html("");
                $(".fatura_icin_istasyonlari_getir_div").html(getModal);
            });
        });

        $("body").off("click", "#kesilecek_yakit_fisleri_getir_button").on("click", "#kesilecek_yakit_fisleri_getir_button", function () {
            let cari_id = $("#cari_id").attr("data-id");
            let bas_tarih = $("#bas_tarih").val();
            let bit_tarih = $("#bit_tarih").val();
            if (cari_id == undefined || cari_id == "") {
                Swal.fire(
                    'Uyarı!',
                    'Lütfen Bir Cari Seçiniz...',
                    'warning'
                );
            } else {
                $.get("controller/arac_controller/sql.php?islem=kesilecek_yakit_fislerini_getir_sql",
                    {
                        cari_id: cari_id,
                        bas_tarih: bas_tarih,
                        bit_tarih: bit_tarih
                    }
                    , function (response) {
                        if (response != 2) {
                            var json = JSON.parse(response);
                            $("#cari_id").prop("disabled", true);
                            var basilacak_arr = [];
                            $("#yakit_fatura_cari").prop("disabled", true);
                            yakit_fisleri_table.clear().draw(false);
                            var tutar_t = 0;
                            json.forEach(function (item) {
                                let tl_tutar = item.tl_tutar;
                                tl_tutar = parseFloat(tl_tutar);
                                tutar_t += tl_tutar;
                                tl_tutar = tl_tutar.toLocaleString("tr-TR", {
                                    maximumFractionDigits: 2,
                                    minimumFractionDigits: 2
                                });
                                let litre_fiyati = item.litre_fiyati;
                                litre_fiyati = parseFloat(litre_fiyati);
                                litre_fiyati = litre_fiyati.toLocaleString("tr-TR", {
                                    maximumFractionDigits: 2,
                                    minimumFractionDigits: 2
                                });
                                let miktar = item.miktar;
                                miktar = parseFloat(miktar);
                                miktar = miktar.toLocaleString("tr-TR", {
                                    maximumFractionDigits: 2,
                                    minimumFractionDigits: 2
                                });

                                let tarih = item.tarih;
                                tarih = tarih.split(" ");
                                tarih = tarih[0];
                                tarih = tarih.split("-");
                                let gun = tarih[2];
                                let ay = tarih[1];
                                let yil = tarih[0];
                                let arr = [gun, ay, yil];
                                tarih = arr.join("/");


                                let newRow = {
                                    sec: "<input type='checkbox' class='secilen_yakit_fisleri' data-id='" + item.id + "'/>",
                                    cari_kodu: item.cari_kodu,
                                    cari_adi: item.cari_adi,
                                    plaka: item.plaka,
                                    tarih: tarih,
                                    arac_grubu: "Binek",
                                    miktar: miktar,
                                    litre_fiyati: litre_fiyati,
                                    tl_tutar: tl_tutar
                                };
                                basilacak_arr.push(newRow);
                            });
                            $(".secilmeyen_toplam").html("");
                            $(".secilmeyen_toplam").html(tutar_t.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }) + " TL");
                            yakit_fisleri_table.rows.add(basilacak_arr).draw(false);
                        }
                    })
            }
        });

        $("body").off("click", "#yakit_fislerini_faturalandir").on("click", "#yakit_fislerini_faturalandir", function () {
            let yakit_fisleri = [];
            $(".secilen_yakit_fisleri").each(function () {
                if ($(this).hasClass("yakit_fisi_secildi")) {
                    let id = $(this).attr("data-id");
                    yakit_fisleri.push(id);
                }
            });

            let kdv_toplam = $(".kdv_toplam_bas").html();
            kdv_toplam = kdv_toplam.replace(/\./g, "").replace(",", ".");
            kdv_toplam = parseFloat(kdv_toplam);
            let ara_toplam = $(".ara_toplam_bas").html();
            ara_toplam = ara_toplam.replace(/\./g, "").replace(",", ".");
            ara_toplam = parseFloat(ara_toplam);
            let miktar = $(".total_miktar").html();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            let genel_toplam = $(".genel_toplam_bas").html();
            genel_toplam = genel_toplam.replace(/\./g, "").replace(",", ".");
            genel_toplam = parseFloat(genel_toplam);
            let birim_fiyat = ara_toplam / miktar;

            let cari_id = $("#cari_id").attr("data-id");
            let fatura_no = $("#fatura_no").val();
            let fatura_tarihi = $("#fatura_tarihi").val();
            let aciklama = $("#aciklama").val();
            if (cari_id == "" || cari_id == undefined) {
                Swal.fire(
                    'Uyarı!',
                    'Lütfen Bir Cari Seçiniz...'
                );
            } else {
                $.ajax({
                    url: "controller/arac_controller/sql.php?islem=yakit_fislerini_faturalandir",
                    type: "POST",
                    data: {
                        fatura_no: fatura_no,
                        cari_id: cari_id,
                        fatura_tarihi: fatura_tarihi,
                        yakit_fisleri: yakit_fisleri,
                        birim_fiyat: birim_fiyat,
                        kdv_toplam: kdv_toplam,
                        kdv_orani: kdv_orani,
                        ara_toplam: ara_toplam,
                        miktar: miktar,
                        genel_toplam: genel_toplam,
                        aciklama: aciklama
                    },
                    success: function (response) {
                        if (response == 1) {
                            Swal.fire(
                                "Başarılı!",
                                "Yakıt Fişleri Faturalandı",
                                "success"
                            );
                            $("#binek_yakit_fatura_modal").modal("hide");
                            $.get("view/binek_yakit_alim_faturasi.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                            $.get("view/binek_yakit_alim_faturasi.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }
        });

        $("body").off("click", ".secilen_yakit_fisleri").on("click", ".secilen_yakit_fisleri", function () {
            let this_c = $(this);
            let closest = $(this).closest("tr");
            let miktar = $(closest).find("td").eq(6).text();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            if (this.checked) {
                $(this_c).addClass("yakit_fisi_secildi");
                let tutar = $(closest).find("td").eq(8).text();
                tutar = tutar.replace(/\./g, "").replace(",", ".");
                tutar = parseFloat(tutar);
                toplam_tutar += tutar;
                toplam_miktar += miktar;

            } else {
                $(this_c).removeClass("yakit_fisi_secildi")
                let tutar = $(closest).find("td").eq(8).text();
                tutar = tutar.replace(/\./g, "").replace(",", ".");
                tutar = parseFloat(tutar);
                toplam_tutar -= tutar;
                toplam_miktar -= miktar;
            }
            let kdv_islem = "1." + kdv_orani;
            kdv_islem = parseFloat(kdv_islem);
            let ara_toplam = toplam_tutar / kdv_islem;
            let kdv_yuzde = parseFloat(kdv_orani) / 100;
            let kdv_tutar = ara_toplam * kdv_yuzde;
            $(".genel_toplam_bas").html("");
            $(".genel_toplam_bas").html(toplam_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }) + " TL")

            $(".ara_toplam_bas").html("");
            $(".ara_toplam_bas").html(ara_toplam.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }) + " TL")

            $(".kdv_toplam_bas").html("");
            $(".kdv_toplam_bas").html(kdv_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }) + " TL")
            $(".total_miktar").html("");
            $(".total_miktar").html(toplam_miktar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }) + " LT")
        });

        $("body").off("keyup", "#cari_id").on("keyup", "#cari_id", function () {
            let val = $(this).val();
            let this_s = $(this);
            $.get("konteyner/controller/irsaliye_controller/sql.php?islem=cari_kodu_bilgileri_getir_sql", {cari_kodu: val}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $(this_s).attr("data-id", item.id);
                    $(this_s).val(item.cari_kodu);
                    $("#cari_adi").val((item.cari_adi).toUpperCase())
                } else {
                    $(this_s).attr("data-id", "");
                    $("#cari_adi").val("")
                }
            })
        });

        $(document).ready(function () {
            $.get("konteyner/controller/yakit_controller/sql.php?islem=motorin_kdv_getir_sql", function (res) {
                if (res != 2) {
                    kdv_orani = res;
                }
            });

            setTimeout(function () {
                $("#istasyonclick").trigger("click");
            }, 500);

            yakit_fisleri_table = $("#konteyner_yakit_fis_fatura_list").DataTable({
                scrollY: '40vh',
                scrollX: true,
                "info": false,
                "order": [[0, 'desc']],
                columnDefs: [
                    {targets: 0, type: "date-eu"}
                ],
                columns: [
                    {"data": "sec"},
                    {"data": "cari_kodu"},
                    {"data": "cari_adi"},
                    {"data": "plaka"},
                    {"data": "tarih"},
                    {"data": "arac_grubu"},
                    {"data": "miktar"},
                    {"data": "litre_fiyati"},
                    {"data": "tl_tutar"},
                ],
                createdRow: function (new_row) {
                    $(new_row).addClass("tum_yakitlar_list")
                    $(new_row).find('td').css('text-align', 'left');
                    $(new_row).find("td").eq(6).css("text-align", "right");
                    $(new_row).find("td").eq(7).css("text-align", "right");
                    $(new_row).find("td").eq(8).css("text-align", "right");
                },
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
            });

            $.get("konteyner/controller/yakit_controller/sql.php?islem=kesilecek_olan_yakit_fislerini_getir_sql")

            $("#binek_yakit_fatura_modal").modal("show");

        });

        $("body").off("click", "#konteyner_kiralik_yakit_cikis_vazgec").on("click", "#konteyner_kiralik_yakit_cikis_vazgec", function () {
            $("#binek_yakit_fatura_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "yakit_faturalari_detay_modal") {
    ?>
    <style>
        #yakit_alim_fatura_detayi {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="yakit_alim_fatura_detayi" data-bs-keyboard="false" data-backdrop="static"
         role="dialog">
        <div class="modal-dialog" style="width: 70%; max-width: 70%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="konteyner_kiralik_yakit_cikis_vazgec"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'> İSTASYONDAN ALINAN FİŞLERİ
                                FATURALANDIR
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="fatura_icin_istasyonlari_getir_div"></div>
                            <div class="ibox-title" style="background-color: #9DB2BF;color: white;text-align: center">
                                <span>Filtreleme İçeriği</span>
                            </div>
                            <div class="col-12 row mt-3">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Cari Kodu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" disabled
                                                       id="cari_id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" disabled
                                                            id="yakit_fatura_cari"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Cari Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" disabled class="form-control form-control-sm"
                                                   id="cari_adi" style="font-weight: bold">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row">
                                <table class="table table-sm table-bordered w-100 display nowrap"
                                       style="cursor:pointer;font-size: 13px;"
                                       id="konteyner_yakit_fis_fatura_list">
                                    <thead>
                                    <tr>
                                        <th style="width: 0% !important;">#</th>
                                        <th id="istasyonclick">İstasyon Kodu</th>
                                        <th>İstasyon Adı</th>
                                        <th>Plaka</th>
                                        <th>Tarih</th>
                                        <th>Araç Grubu</th>
                                        <th>Miktar</th>
                                        <th>Litre Fiyat</th>
                                        <th>Tutar</th>
                                    </tr>
                                    </thead>
                                    <tfoot style="background-color: white">
                                    <tr>
                                        <th colspan="4" style="text-align: right; font-size: 14px;">TOPLAM:</th>
                                        <th style="text-align: right; font-size: 14px;" class="secilmeyen_toplam">0,00
                                        </th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="mt-3"></div>
                            <div class="ibox-title" style="background-color: #9DB2BF;color: white;text-align: center">
                                <span>Fatura Bilgileri</span>
                            </div>
                            <div class="col-12 row mt-2">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Fatura No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="fatura_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Fatura Tarih</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>" id="fatura_tarihi"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-md-7">
                                            <textarea class="form-control form-control-sm" style="resize: none"
                                                      id="aciklama" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1"></div>
                                <div class="col-5">
                                    <div class="col-12 row no-gutters mt-2">
                                        <div class="col">
                                            <table class="table table-sm table-bordered w-80 nowrap"
                                                   style="font-size: 11px !important; font-weight: bold">
                                                <tr>
                                                    <th>#</th>
                                                </tr>
                                                <tr>
                                                    <th>Miktar</th>
                                                </tr>
                                                <tr>
                                                    <th>Ara Toplam</th>
                                                </tr>
                                                <tr>
                                                    <th>KDV Toplamı</th>
                                                </tr>
                                                <tr>
                                                    <th>Tevkifat Tutarı</th>
                                                </tr>
                                                <tr>
                                                    <th>İskonto Toplamı</th>
                                                </tr>
                                                <tr>
                                                    <th>Genel Toplam</th>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col">
                                            <table class="table table-sm table-bordered w-100 nowrap"
                                                   style="font-size: 11px !important;">
                                                <thead>
                                                <tr>
                                                    <th>TL Karşılığı</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="total_miktar" style="text-align: right">0,00 LT</td>
                                                </tr>
                                                <tr>
                                                    <td class="ara_toplam_bas" style="text-align: right">0,00 TL</td>
                                                </tr>
                                                <tr>
                                                    <td class="kdv_toplam_bas" style="text-align: right">0,00 TL</td>
                                                </tr>
                                                <tr>
                                                    <td class="tevkifat_tutari_bas" style="text-align: right">0,00 TL
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="iskonto_toplam_bas" style="text-align: right">0,00 TL
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="genel_toplam_bas" style="text-align: right">0,00 TL</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="konteyner_kiralik_yakit_cikis_vazgec"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="faturalanmis_fisi_guncelle_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("body").off("click", "#tumunu_sec_button").on("click", "#tumunu_sec_button", function () {
            $("#tumunu_sec_button").hide();
            $("#tumunu_kaldir_button").show();
            toplam_tutar = 0;
            toplam_miktar = 0;
            $(".tum_yakitlar_list").each(function () {
                $(this).find("td:eq(0) input").prop("checked", true);
                $(this).find("td:eq(0) input").addClass("yakit_fisi_secildi");
                let tutar = $(this).find("td").eq(8).text();
                tutar = tutar.replace(/\./g, "").replace(",", ".");
                tutar = parseFloat(tutar);
                let miktar = $(this).find("td").eq(6).text();
                miktar = miktar.replace(/\./g, "").replace(",", ".");
                miktar = parseFloat(miktar);
                toplam_tutar += tutar;
                toplam_miktar += miktar;
            })
            let kdv_islem = "1." + kdv_orani;
            kdv_islem = parseFloat(kdv_islem);
            let ara_toplam = toplam_tutar / kdv_islem;
            let kdv_yuzde = parseFloat(kdv_orani) / 100;
            let kdv_tutar = ara_toplam * kdv_yuzde;
            $(".genel_toplam_bas").html("");
            $(".genel_toplam_bas").html(toplam_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }) + " TL")

            $(".ara_toplam_bas").html("");
            $(".ara_toplam_bas").html(ara_toplam.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }) + " TL")

            $(".kdv_toplam_bas").html("");
            $(".kdv_toplam_bas").html(kdv_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }) + " TL")
            $(".total_miktar").html("");
            $(".total_miktar").html(toplam_miktar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }) + " LT")
        });

        $("body").off("click", "#tumunu_kaldir_button").on("click", "#tumunu_kaldir_button", function () {
            $("#tumunu_sec_button").show();
            $("#tumunu_kaldir_button").hide();
            $(".tum_yakitlar_list").each(function () {
                $(this).find("td:eq(0) input").removeClass("yakit_fisi_secildi");
                $(this).find("td:eq(0) input").prop("checked", false);
            })
            toplam_tutar = 0;
            toplam_miktar = 0;
            $(".genel_toplam_bas").html("");
            $(".genel_toplam_bas").html("0,00 TL");


            $(".ara_toplam_bas").html("");
            $(".ara_toplam_bas").html("0,00 TL")

            $(".kdv_toplam_bas").html("");
            $(".kdv_toplam_bas").html("0,00 TL")

            $(".total_miktar").html("");
            $(".total_miktar").html("0,00 LT");
        });

        var yakit_fisleri_table = "";
        var toplam_tutar = 0;
        var kdv_orani = 0;
        var toplam_miktar = 0;

        $("body").off("click", "#yakit_fatura_cari").on("click", "#yakit_fatura_cari", function () {
            $.get("konteyner/modals/yakit_modal/ozmal_yakit_cikis.php?islem=istasyonlari_modal_getir", function (getModal) {
                $(".fatura_icin_istasyonlari_getir_div").html("");
                $(".fatura_icin_istasyonlari_getir_div").html(getModal);
            });
        });

        $("body").off("click", "#kesilecek_yakit_fisleri_getir_button").on("click", "#kesilecek_yakit_fisleri_getir_button", function () {
            let cari_id = $("#cari_id").attr("data-id");
            let bas_tarih = $("#bas_tarih").val();
            let bit_tarih = $("#bit_tarih").val();
            if (cari_id == undefined || cari_id == "") {
                Swal.fire(
                    'Uyarı!',
                    'Lütfen Bir Cari Seçiniz...',
                    'warning'
                );
            } else {
                $.get("controller/arac_controller/sql.php?islem=kesilecek_yakit_fislerini_getir_sql",
                    {
                        cari_id: cari_id,
                        bas_tarih: bas_tarih,
                        bit_tarih: bit_tarih
                    }
                    , function (response) {
                        if (response != 2) {
                            var json = JSON.parse(response);
                            $("#cari_id").prop("disabled", true);
                            var basilacak_arr = [];
                            $("#yakit_fatura_cari").prop("disabled", true);
                            yakit_fisleri_table.clear().draw(false);
                            var tutar_t = 0;
                            json.forEach(function (item) {
                                let tl_tutar = item.tl_tutar;
                                tl_tutar = parseFloat(tl_tutar);
                                tutar_t += tl_tutar;
                                tl_tutar = tl_tutar.toLocaleString("tr-TR", {
                                    maximumFractionDigits: 2,
                                    minimumFractionDigits: 2
                                });
                                let litre_fiyati = item.litre_fiyati;
                                litre_fiyati = parseFloat(litre_fiyati);
                                litre_fiyati = litre_fiyati.toLocaleString("tr-TR", {
                                    maximumFractionDigits: 2,
                                    minimumFractionDigits: 2
                                });
                                let miktar = item.miktar;
                                miktar = parseFloat(miktar);
                                miktar = miktar.toLocaleString("tr-TR", {
                                    maximumFractionDigits: 2,
                                    minimumFractionDigits: 2
                                });

                                let tarih = item.tarih;
                                tarih = tarih.split(" ");
                                tarih = tarih[0];
                                tarih = tarih.split("-");
                                let gun = tarih[2];
                                let ay = tarih[1];
                                let yil = tarih[0];
                                let arr = [gun, ay, yil];
                                tarih = arr.join("/");


                                let newRow = {
                                    sec: "<input type='checkbox' class='secilen_yakit_fisleri' data-id='" + item.id + "'/>",
                                    cari_kodu: item.cari_kodu,
                                    cari_adi: item.cari_adi,
                                    plaka: item.plaka,
                                    tarih: tarih,
                                    arac_grubu: "Binek",
                                    miktar: miktar,
                                    litre_fiyati: litre_fiyati,
                                    tl_tutar: tl_tutar
                                };
                                basilacak_arr.push(newRow);
                            });
                            $(".secilmeyen_toplam").html("");
                            $(".secilmeyen_toplam").html(tutar_t.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }) + " TL");
                            yakit_fisleri_table.rows.add(basilacak_arr).draw(false);
                        }
                    })
            }
        });

        $("body").off("click", "#faturalanmis_fisi_guncelle_button").on("click", "#faturalanmis_fisi_guncelle_button", function () {
            let yakit_fisleri = [];
            $(".secilen_yakit_fisleri").each(function () {
                if ($(this).hasClass("yakit_fisi_secildi")) {
                    let id = $(this).attr("data-id");
                    yakit_fisleri.push(id);
                }
            });

            let kdv_toplam = $(".kdv_toplam_bas").html();
            kdv_toplam = kdv_toplam.replace(/\./g, "").replace(",", ".");
            kdv_toplam = parseFloat(kdv_toplam);
            let ara_toplam = $(".ara_toplam_bas").html();
            ara_toplam = ara_toplam.replace(/\./g, "").replace(",", ".");
            ara_toplam = parseFloat(ara_toplam);
            let miktar = $(".total_miktar").html();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            let genel_toplam = $(".genel_toplam_bas").html();
            genel_toplam = genel_toplam.replace(/\./g, "").replace(",", ".");
            genel_toplam = parseFloat(genel_toplam);
            let birim_fiyat = ara_toplam / miktar;

            let cari_id = $("#cari_id").attr("data-id");
            let fatura_no = $("#fatura_no").val();
            let fatura_tarihi = $("#fatura_tarihi").val();
            let aciklama = $("#aciklama").val();
            if (cari_id == "" || cari_id == undefined) {
                Swal.fire(
                    'Uyarı!',
                    'Lütfen Bir Cari Seçiniz...'
                );
            } else {
                $.ajax({
                    url: "controller/arac_controller/sql.php?islem=faturalanmis_fisi_guncelle_sql",
                    type: "POST",
                    data: {
                        fatura_no: fatura_no,
                        fatura_tarihi: fatura_tarihi,
                        aciklama: aciklama,
                        id: "<?=$_GET["id"]?>"
                    },
                    success: function (response) {
                        if (response == 1) {
                            Swal.fire(
                                "Başarılı!",
                                "Yakıt Fişleri Faturalandı",
                                "success"
                            );
                            $("#yakit_alim_fatura_detayi").modal("hide");
                            $.get("view/binek_yakit_alim_faturasi.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                            $.get("view/binek_yakit_alim_faturasi.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }
        });

        $("body").off("click", ".secilen_yakit_fisleri").on("click", ".secilen_yakit_fisleri", function () {
            let this_c = $(this);
            let closest = $(this).closest("tr");
            let miktar = $(closest).find("td").eq(6).text();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            if (this.checked) {
                $(this_c).addClass("yakit_fisi_secildi");
                let tutar = $(closest).find("td").eq(8).text();
                tutar = tutar.replace(/\./g, "").replace(",", ".");
                tutar = parseFloat(tutar);
                toplam_tutar += tutar;
                toplam_miktar += miktar;

            } else {
                $(this_c).removeClass("yakit_fisi_secildi")
                let tutar = $(closest).find("td").eq(8).text();
                tutar = tutar.replace(/\./g, "").replace(",", ".");
                tutar = parseFloat(tutar);
                toplam_tutar -= tutar;
                toplam_miktar -= miktar;
            }
            let kdv_islem = "1." + kdv_orani;
            kdv_islem = parseFloat(kdv_islem);
            let ara_toplam = toplam_tutar / kdv_islem;
            let kdv_yuzde = parseFloat(kdv_orani) / 100;
            let kdv_tutar = ara_toplam * kdv_yuzde;
            $(".genel_toplam_bas").html("");
            $(".genel_toplam_bas").html(toplam_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }) + " TL")

            $(".ara_toplam_bas").html("");
            $(".ara_toplam_bas").html(ara_toplam.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }) + " TL")

            $(".kdv_toplam_bas").html("");
            $(".kdv_toplam_bas").html(kdv_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }) + " TL")
            $(".total_miktar").html("");
            $(".total_miktar").html(toplam_miktar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }) + " LT")
        });

        $("body").off("keyup", "#cari_id").on("keyup", "#cari_id", function () {
            let val = $(this).val();
            let this_s = $(this);
            $.get("konteyner/controller/irsaliye_controller/sql.php?islem=cari_kodu_bilgileri_getir_sql", {cari_kodu: val}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $(this_s).attr("data-id", item.id);
                    $(this_s).val(item.cari_kodu);
                    $("#cari_adi").val((item.cari_adi).toUpperCase())
                } else {
                    $(this_s).attr("data-id", "");
                    $("#cari_adi").val("")
                }
            })
        });

        $(document).ready(function () {
            $.get("konteyner/controller/yakit_controller/sql.php?islem=motorin_kdv_getir_sql", function (res) {
                if (res != 2) {
                    kdv_orani = res;
                }
            });


            setTimeout(function () {
                $("#istasyonclick").trigger("click");
            }, 500);

            yakit_fisleri_table = $("#konteyner_yakit_fis_fatura_list").DataTable({
                scrollY: '40vh',
                scrollX: true,
                "info": false,
                "order": [[0, 'desc']],
                columnDefs: [
                    {targets: 0, type: "date-eu"}
                ],
                columns: [
                    {"data": "sec"},
                    {"data": "cari_kodu"},
                    {"data": "cari_adi"},
                    {"data": "plaka"},
                    {"data": "tarih"},
                    {"data": "arac_grubu"},
                    {"data": "miktar"},
                    {"data": "litre_fiyati"},
                    {"data": "tl_tutar"},
                ],
                createdRow: function (new_row) {
                    $(new_row).addClass("tum_yakitlar_list")
                    $(new_row).find('td').css('text-align', 'left');
                    $(new_row).find("td").eq(6).css("text-align", "right");
                    $(new_row).find("td").eq(7).css("text-align", "right");
                    $(new_row).find("td").eq(8).css("text-align", "right");
                },
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
            });
            $.get("controller/arac_controller/sql.php?islem=yakit_fatura_detayi_ana_bilgi_getir_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#cari_id").val(item.cari_kodu);
                    $("#cari_id").attr("data-id", item.cari_id);
                    $("#cari_adi").val(item.cari_adi);
                    $("#fatura_no").val(item.fatura_no);
                    let fatura_tarihi = item.fatura_tarihi;
                    fatura_tarihi = fatura_tarihi.split(" ");
                    fatura_tarihi = fatura_tarihi[0];
                    $("#fatura_tarihi").val(fatura_tarihi);
                    $("#aciklama").val(item.aciklama);
                    let toplam_tutar = item.toplam_tutar;
                    toplam_tutar = parseFloat(toplam_tutar);
                    let toplam_lt = item.toplam_lt;
                    toplam_lt = parseFloat(toplam_lt);
                    let girecek_kdv = "1." + kdv_orani;
                    girecek_kdv = parseFloat(girecek_kdv);
                    let ara_tot = toplam_tutar / girecek_kdv;
                    let kdv_tot = toplam_tutar - ara_tot;
                    ara_tot = ara_tot.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                    kdv_tot = kdv_tot.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    toplam_tutar = toplam_tutar.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });
                    toplam_lt = toplam_lt.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    $(".genel_toplam_bas").html(toplam_tutar + " TL");
                    $(".ara_toplam_bas").html("");
                    $(".ara_toplam_bas").html(ara_tot.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }) + " TL")

                    $(".kdv_toplam_bas").html("");
                    $(".kdv_toplam_bas").html(kdv_tot.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }) + " TL");

                    $(".total_miktar").html("");
                    $(".total_miktar").html(toplam_lt.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }) + " LT")
                }
            })

            $.get("controller/arac_controller/sql.php?islem=yakit_alim_fat_icerik_bilgi", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    let basilacak_arr = [];
                    let adet = 1;
                    let tutar = 0;
                    json.forEach(function (item) {
                        let tarih = item.tarih;
                        tarih = tarih.split(" ");
                        tarih = tarih[0];
                        tarih = tarih.split("-");
                        let g = tarih[2];
                        let a = tarih[1];
                        let y = tarih[0];
                        let arr = [g, a, y];
                        tarih = arr.join("/");

                        let miktar = item.miktar;
                        miktar = parseFloat(miktar);
                        miktar = miktar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});

                        let litre_fiyati = item.litre_fiyati;
                        litre_fiyati = parseFloat(litre_fiyati);
                        litre_fiyati = litre_fiyati.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });

                        let tl_tutar = item.tl_tutar;
                        tl_tutar = parseFloat(tl_tutar);
                        tutar += tl_tutar;
                        tl_tutar = tl_tutar.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });

                        let newRow = {
                            sec: adet,
                            cari_kodu: item.istasyon_kodu,
                            cari_adi: item.istasyon_adi,
                            plaka: item.arac_plaka,
                            tarih: tarih,
                            arac_grubu: "BİNEK",
                            miktar: miktar,
                            litre_fiyati: litre_fiyati,
                            tl_tutar: tl_tutar
                        };
                        basilacak_arr.push(newRow);
                        adet++;
                    });
                    tutar = tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                    $(".secilmeyen_toplam").html(tutar);
                    yakit_fisleri_table.rows.add(basilacak_arr).draw(false);
                }
            })
            $("#yakit_alim_fatura_detayi").modal("show");

        });

        $("body").off("click", "#konteyner_kiralik_yakit_cikis_vazgec").on("click", "#konteyner_kiralik_yakit_cikis_vazgec", function () {
            $("#yakit_alim_fatura_detayi").modal("hide");
        });

    </script>
    <?php
}