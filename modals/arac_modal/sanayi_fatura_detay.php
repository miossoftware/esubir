<?php

$islem = $_GET["islem"];

if ($islem == "sanayi_fatura_bilgileri_modal") {
    ?>
    <style>
        #sanayi_faturalanan_fisler {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="sanayi_faturalanan_fisler" data-bs-keyboard="false" data-backdrop="static"
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
                            <div class="ibox-title" style='color:white; font-weight:bold;'> FATURALANAN SANAYİ FİŞİ
                                DETAYI
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
                                                <input type="text" class="form-control form-control-sm" id="cari_id"
                                                       style="font-weight: bold" disabled>
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="yakit_fatura_cari"
                                                            disabled><i
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
                                        <th id="istasyonclick">Cari Kodu</th>
                                        <th>Cari Adı</th>
                                        <th>Plaka</th>
                                        <th>Ara Toplam</th>
                                        <th>KDV Yüzde</th>
                                        <th>KDV Tutar</th>
                                        <th>İskonto Yüzde</th>
                                        <th>İskonto Tutar</th>
                                        <th>Tutar</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="mt-3"></div>
                            <div class="ibox-title" style="background-color: #9DB2BF;color: white;text-align: center">
                                <span>Fatura Bilgileri</span>
                            </div>
                            <div class="col-12 row mt-2">
                                <div class="col-4">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Fatura No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="fatura_no"
                                                   style="font-weight: bold" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Fatura Tarih</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>" id="fatura_tarihi"
                                                   class="form-control form-control-sm" style="font-weight: bold"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="aciklama"
                                                   style="font-weight: bold" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Fatura Türü</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="fatura_tur"
                                                    style="font-weight: bold" disabled>
                                                <option value="">Bir Fatura Türü Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Fatura Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="fatura_tip"
                                                    style="font-weight: bold" disabled>
                                                <option value="">Bir Fatura Tipi Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="col-12 row no-gutters mt-2">
                                        <div class="col">
                                            <table class="table table-sm table-bordered w-80 display nowrap">
                                                <tr>
                                                    <th>#</th>
                                                </tr>
                                                <tr>
                                                    <th>KDV Toplam</th>
                                                </tr>
                                                <tr>
                                                    <th>İskonto Toplam</th>
                                                </tr>
                                                <tr>
                                                    <th>Toplam</th>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col">
                                            <table class="table table-sm table-bordered w-100 display nowrap">
                                                <thead>
                                                <tr>
                                                    <th>TL Karşılığı</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="kdv_toplam" style="text-align: right">0,00 TL</td>
                                                </tr>
                                                <tr>
                                                    <td class="iskonto_toplam" style="text-align: right">0,00 TL</td>
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
                                    class="fa fa-close"></i> Kapat
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        var sanayi_fisleri_table = "";
        var toplam_tutar = 0;

        $("body").off("click", "#secilen_sanayi_fislerini_faturalandir_button").on("click", "#secilen_sanayi_fislerini_faturalandir_button", function () {
            let cari_id = $("#cari_id").attr("data-id");
            let fatura_no = $("#fatura_no").val();
            let fatura_tarihi = $("#fatura_tarihi").val();
            let aciklama = $("#aciklama").val();

            let gidecek_sanayi = [];
            $(".sanayi_fisi_secildi").each(function () {
                let sanayi_fis_id = $(this).attr("data-id");
                let newRow = {
                    sanayi_fisid: sanayi_fis_id
                };
                gidecek_sanayi.push(newRow);
            });

            $.ajax({
                url: "konteyner/controller/sanayi_controller/sql.php?islem=sanayi_fis_fatura_kaydet_sql",
                type: "POST",
                data: {
                    cari_id: cari_id,
                    fatura_no: fatura_no,
                    fatura_tarih: fatura_tarihi,
                    aciklama: aciklama,
                    gidecek_sanayi: gidecek_sanayi
                },
                success: function (result) {
                    if (result == 1) {
                        Swal.fire(
                            "Başarılı",
                            "Sanayi Fişi Faturalandı...",
                            "success"
                        );
                        $.get("konteyner/view/sanayi_faturalandir.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                        $.get("konteyner/view/sanayi_faturalandir.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                        $("#sanayi_faturalanan_fisler").modal("hide");
                    } else if (result == 300) {
                        Swal.fire(
                            "Uyarı!",
                            "Hiç Bir Sanayi Fişi Seçmediniz Lütfen En Az Bir Sanayi Fişi Seçiniz...",
                            "warning"
                        );
                    } else {
                        Swal.fire(
                            "Oops...",
                            "Bilinmeyen Bir Hata Oluştu",
                            "error"
                        );
                        $("#sanayi_faturalanan_fisler").modal("hide");
                    }
                }
            });

        });


        $("body").off("click", "#tumunu_sec_sanayi_button").on("click", "#tumunu_sec_sanayi_button", function () {
            $("#tumunu_sec_sanayi_button").hide();
            $("#tumunu_kaldir_sanayi_button").show();
            toplam_tutar = 0;
            $(".tum_servis_fisleri_selected").each(function () {
                $(this).find("td:eq(0) input").prop("checked", true);
                $(this).find("td:eq(0) input").addClass("sanayi_fisi_secildi");
                let tutar = $(this).find("td").eq(6).text();
                tutar = tutar.replace(/\./g, "").replace(",", ".");
                tutar = parseFloat(tutar);
                toplam_tutar += tutar;
            })
            $(".genel_toplam_bas").html("");
            $(".genel_toplam_bas").html(toplam_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }) + " TL");
        });

        $("body").off("click", "#tumunu_kaldir_sanayi_button").on("click", "#tumunu_kaldir_sanayi_button", function () {
            $("#tumunu_sec_sanayi_button").show();
            $("#tumunu_kaldir_sanayi_button").hide();
            $(".tum_servis_fisleri_selected").each(function () {
                $(this).find("td:eq(0) input").removeClass("sanayi_fisi_secildi");
                $(this).find("td:eq(0) input").prop("checked", false);
            })
            toplam_tutar = 0;
            $(".genel_toplam_bas").html("");
            $(".genel_toplam_bas").html("0,00 TL");
        });


        $("body").off("click", "#yakit_fatura_cari").on("click", "#yakit_fatura_cari", function () {
            $.get("konteyner/modals/sanayi_modal/ozmal_sanayi.php?islem=carileri_getir", function (getModal) {
                $(".fatura_icin_istasyonlari_getir_div").html("");
                $(".fatura_icin_istasyonlari_getir_div").html(getModal);
            });
        });

        $("body").off("click", "#kesilecek_sanayi_fisleri_getir_button").on("click", "#kesilecek_sanayi_fisleri_getir_button", function () {
            let cari_id = $("#cari_id").attr("data-id");
            let bas_tarih = $("#bas_tarih").val()
            let bit_tarih = $("#bit_tarih").val()

            if (cari_id == undefined || cari_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Cari Seçiniz...",
                    "warning"
                );
            } else {
                let toplam = 0;
                $.ajax({
                    url: "konteyner/controller/sanayi_controller/sql.php?islem=kesilecek_sanayi_fisleri_sql",
                    type: "POST",
                    data: {
                        cari_id: cari_id,
                        bas_tarih: bas_tarih,
                        bit_tarih: bit_tarih
                    },
                    success: function (result) {
                        if (result != 2) {
                            var json = JSON.parse(result);

                            var basilacak_arr = [];

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

                                let ara_toplam = item.ara_toplam;
                                ara_toplam = parseFloat(ara_toplam);
                                ara_toplam = ara_toplam.toLocaleString("tr-TR", {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });

                                let genel_toplam = item.genel_toplam;
                                genel_toplam = parseFloat(genel_toplam);
                                toplam += genel_toplam;
                                genel_toplam = genel_toplam.toLocaleString("tr-TR", {
                                    maximumFractionDigits: 2,
                                    minimumFractionDigits: 2
                                });

                                let newRow = {
                                    sec: "<input type='checkbox' class='secilecek_sanayi_fisler' data-id='" + item.id + "'/>",
                                    cari_kodu: item.cari_kodu,
                                    cari_adi: item.cari_adi,
                                    plaka: item.plaka_no,
                                    tarih: tarih,
                                    ara_toplam: ara_toplam,
                                    toplam: genel_toplam
                                };
                                basilacak_arr.push(newRow);
                            });
                            $(".secilmeyen_toplam").html("");
                            $(".secilmeyen_toplam").html(toplam.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }) + " TL");
                            sanayi_fisleri_table.rows.add(basilacak_arr).draw(false);

                            $("#cari_id").prop("disabled", true);
                            $("#yakit_fatura_cari").prop("disabled", true);
                        }
                    }
                });
            }
        });

        $("body").off("change", ".secilecek_sanayi_fisler").on("change", ".secilecek_sanayi_fisler", function () {
            let this_c = $(this);
            let closest = $(this).closest("tr");
            if (this.checked) {
                $(this_c).addClass("sanayi_fisi_secildi");
                let tutar = $(closest).find("td").eq(6).text();
                tutar = tutar.replace(/\./g, "").replace(",", ".");
                tutar = parseFloat(tutar);
                toplam_tutar += tutar;
            } else {
                $(this_c).removeClass("sanayi_fisi_secildi")
                let tutar = $(closest).find("td").eq(6).text();
                tutar = tutar.replace(/\./g, "").replace(",", ".");
                tutar = parseFloat(tutar);
                toplam_tutar -= tutar;
            }
            $(".genel_toplam_bas").html("");
            $(".genel_toplam_bas").html(toplam_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }) + " TL")
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
            $.get("controller/alis_controller/sql.php?islem=fatura_turlerini_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#fatura_tur").append("" +
                            "<option value='" + item.id + "'>" + item.fatura_turu_adi + "</option>" +
                            "");
                    });
                }
            });

            $.get("controller/alis_controller/sql.php?islem=fatura_tipi_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#fatura_tip").append("" +
                            "<option value='" + item.id + "'>" + item.fatura_tip_adi + "</option>" +
                            "");
                    });
                }
            });

            $.get("controller/arac_controller/sql.php?islem=fatura_ana_bilgileri_getir_sql", {id: "<?=$_GET["id"]?>"}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#cari_id").val((item.cari_kodu).toUpperCase());
                    $("#cari_adi").val((item.cari_adi).toUpperCase());
                    $("#fatura_no").val(item.fatura_no);
                    let tarih = item.fatura_tarih;
                    tarih = tarih.split(" ");
                    tarih = tarih[0];
                    $("#fatura_tarihi").val(tarih);
                    $("#aciklama").val(item.aciklama);
                    setTimeout(function () {
                        $("#fatura_tur").val(item.fatura_tur);
                        $("#fatura_tip").val(item.fatura_tip);
                    }, 500);
                }
            })

            $.get("controller/arac_controller/sql.php?islem=sanayi_fatura_kalemleri_getir_sql", {fatura_id: "<?=$_GET["id"]?>"}, function (response) {
                if (response != 2) {
                    var json = JSON.parse(response);
                    var basilacak_arr = [];
                    let total_kdv = 0
                    let total_iskonto = 0
                    let toplam_tutar_main = 0;
                    json.forEach(function (item) {

                        let ara_toplam = item.ara_toplam;
                        ara_toplam = parseFloat(ara_toplam);
                        ara_toplam = ara_toplam.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });

                        let iskonto_toplam = item.iskonto_tutar;
                        iskonto_toplam = parseFloat(iskonto_toplam);
                        total_iskonto += iskonto_toplam;
                        iskonto_toplam = iskonto_toplam.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });

                        let iskonto_yuzde = item.iskonto_yuzde;
                        iskonto_yuzde = parseFloat(iskonto_yuzde);
                        iskonto_yuzde = iskonto_yuzde.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });

                        let kdv_toplam = item.kdv_tutar;
                        kdv_toplam = parseFloat(kdv_toplam);
                        total_kdv += kdv_toplam;
                        kdv_toplam = kdv_toplam.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });

                        let kdv_yuzde = item.kdv_yuzde;
                        kdv_yuzde = parseFloat(kdv_yuzde);
                        kdv_yuzde = kdv_yuzde.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });

                        let genel_toplam = item.genel_toplam;
                        genel_toplam = parseFloat(genel_toplam);
                        toplam_tutar_main += genel_toplam;
                        genel_toplam = genel_toplam.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });

                        let newRow = {
                            cari_kodu: item.cari_kodu,
                            cari_adi: item.cari_adi,
                            plaka: item.arac_plaka,
                            ara_toplam: ara_toplam,
                            kdv_yuzde: kdv_yuzde,
                            kdv_toplam: kdv_toplam,
                            iskonto_yuzde: iskonto_yuzde,
                            iskonto_toplam: iskonto_toplam,
                            toplam: genel_toplam
                        };
                        basilacak_arr.push(newRow);
                    });
                    sanayi_fisleri_table.rows.add(basilacak_arr).draw(false);
                    $(".genel_toplam_bas").html("");
                    toplam_tutar_main = parseFloat(toplam_tutar_main);
                    $(".genel_toplam_bas").html(toplam_tutar_main.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }) + " TL");
                    $(".kdv_toplam").html("");
                    total_kdv = parseFloat(total_kdv);
                    $(".kdv_toplam").html(total_kdv.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }) + " TL");
                    $(".iskonto_toplam").html("");
                    total_iskonto = parseFloat(total_iskonto);
                    $(".iskonto_toplam").html(total_iskonto.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }) + " TL");
                }
            })

            setTimeout(function () {
                $("#istasyonclick").trigger("click");
            }, 500);

            sanayi_fisleri_table = $("#konteyner_yakit_fis_fatura_list").DataTable({
                scrollY: '40vh',
                scrollX: true,
                "info": false,
                "order": [[0, 'desc']],
                columnDefs: [
                    {targets: 0, type: "date-eu"}
                ],
                columns: [
                    {"data": "cari_kodu"},
                    {"data": "cari_adi"},
                    {"data": "plaka"},
                    {"data": "ara_toplam"},
                    {"data": "kdv_yuzde"},
                    {"data": "kdv_toplam"},
                    {"data": "iskonto_yuzde"},
                    {"data": "iskonto_toplam"},
                    {"data": "toplam"}
                ],
                createdRow: function (new_row) {
                    $(new_row).addClass("tum_servis_fisleri_selected");
                    $(new_row).find('td').css('text-align', 'left');
                    $(new_row).find("td").eq(3).css("text-align", "right");
                    $(new_row).find("td").eq(4).css("text-align", "right");
                    $(new_row).find("td").eq(5).css("text-align", "right");
                    $(new_row).find("td").eq(6).css("text-align", "right");
                    $(new_row).find("td").eq(7).css("text-align", "right");
                    $(new_row).find("td").eq(8).css("text-align", "right");
                },
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
            });

            $("#sanayi_faturalanan_fisler").modal("show");

        });

        $("body").off("click", "#konteyner_kiralik_yakit_cikis_vazgec").on("click", "#konteyner_kiralik_yakit_cikis_vazgec", function () {
            $("#sanayi_faturalanan_fisler").modal("hide");
        });

    </script>
    <?php
}