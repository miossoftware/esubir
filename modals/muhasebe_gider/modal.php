<?php

$islem = $_GET["islem"];

if ($islem == "yeni_gider_ekle_modal") {
    ?>
    <style>
        #gider_faturasi_kes_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="gider_faturasi_kes_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 80%; max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="gider_fatura_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>GİDER FATURASI</div>
                        </div>
                        <div class="modal-body">
                            <div class="carileri_getir_div"></div>
                            <div class="col-12 row">
                                <div class="ibox-title"
                                     style="background-color: #9DB2BF;color: white;text-align: center">
                                    <span>Fatura Ana Başlık Bilgileri</span>
                                </div>
                                <div class="mt-4"></div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Fatura No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="gider_fatura_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Fatura Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>"
                                                   class="form-control form-control-sm" id="fatura_tarihi">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-md-7">
                                            <textarea class="form-control form-control-sm" id="gider_aciklama" rows="4"
                                                      style="resize: none"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row">
                                <div class="ibox-title"
                                     style="background-color: #9DB2BF;color: white;text-align: center">
                                    <span>Fatura İçerik Bilgileri</span>
                                </div>
                                <div class="row no-gutters">
                                    <div class="col-md-2">
                                        <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;Cari
                                            Kodu</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="cari_id"
                                                   placeholder="Cari Kodu">
                                            <div class="input-group-append">
                                                <button class="btn btn-warning btn-sm" id="cari_kodu_button"><i
                                                            class="fa fa-ellipsis-h"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;Cari
                                            Adı</label>
                                        <input type="text" class="form-control form-control-sm"
                                               id="cari_adi"
                                               placeholder="Cari Adı" disabled style="font-weight: bold">
                                    </div>
                                    <div class="col-md-2">
                                        <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;Açıklama</label>
                                        <input type="text" class="form-control form-control-sm"
                                               id="aciklama"
                                               placeholder="Açıklama" style="font-weight: bold">
                                    </div>
                                    <div class="col-md-1">
                                        <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;Fiyat</label>
                                        <input type="text" class="form-control form-control-sm"
                                               id="gider_fiyat" value="0,00"
                                               placeholder="Fiyat" style="font-weight: bold;text-align: right">
                                    </div>
                                    <div class="col-md-1">
                                        <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;KDV</label>
                                        <input type="text" class="form-control form-control-sm"
                                               id="gider_kdv" kdv_tutar="0,00" value="0,00"
                                               placeholder="KDV (%)" style="font-weight: bold;text-align: right">
                                    </div>
                                    <div class="col-md-1">
                                        <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;İskonto</label>
                                        <input type="text" class="form-control form-control-sm"
                                               id="gider_iskonto" value="0,00" iskonto_tutar="0,00"
                                               placeholder="İskonto (%)" style="font-weight: bold;text-align: right">
                                    </div>
                                    <div class="col-md-1">
                                        <label style="font-weight: bold;font-size: 10px">Genel Toplam</label>
                                        <input type="text" class="form-control form-control-sm"
                                               id="gider_genel_toplam" value="0,00"
                                               placeholder="Genel Toplam" disabled
                                               style="font-weight: bold;text-align: right">
                                    </div>
                                    <div class="col-md-2 mt-4">
                                        <button style="width: 100% !important;"
                                                class="btn btn-success btn-sm mx-5" id="yeni_muhasebe_gider_fisi_ekle">
                                            <i
                                                    class="fa fa-plus"></i> Ekle
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row">
                                <table class="table table-sm table-bordered w-100 display nowrap"
                                       id="muhasebe_gider_faturalari_modal_list"
                                       style="font-size: 13px;">
                                    <thead>
                                    <tr>
                                        <th id="muhasebe_gider">Cari Kodu</th>
                                        <th>Cari Adı</th>
                                        <th>KDV (%)</th>
                                        <th>KDV Tutar</th>
                                        <th>İskonto (%)</th>
                                        <th>İskonto Tutar</th>
                                        <th>Ara Toplam</th>
                                        <th>Genel Toplam</th>
                                        <th>Açıklama</th>
                                        <th style="width: 0%">İşlem</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="col-12 row">
                                <div class="col-4"></div>
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <div class="col-12 row no-gutters mt-2">

                                        <div class="col">

                                            <table class="table table-sm table-bordered w-80 display nowrap">
                                                <tr>
                                                    <th>#</th>
                                                </tr>
                                                <tr>
                                                    <th>KDV Toplamı</th>
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
                                            <table class="table table-sm table-bordered w-100 display nowrap">
                                                <thead>
                                                <tr>
                                                    <th>TL Karşılığı</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="kdv_toplam_bas" style="text-align: right">0,00 TL</td>
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
                            <button class="btn btn-danger btn-sm" id="gider_fatura_vazgec"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="muhasebe_gider_kaydet"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var muhasebe_gider_faturalari = "";

        $("body").off("click", "#muhasebe_gider_kaydet").on("click", "#muhasebe_gider_kaydet", function () {
            let fatura_no = $("#gider_fatura_no").val();
            let fatura_tarihi = $("#fatura_tarihi").val();
            let aciklama = $("#gider_aciklama").val();

            var basilacak_arr = [];
            $(".eklenen_muhasebe_giderleri").each(function () {
                let cari_id = $(this).attr("cari_id");
                let kdv_yuzde = $(this).find("td").eq(2).text();
                kdv_yuzde = kdv_yuzde.replace(/\./g, "").replace(",", ".");
                kdv_yuzde = parseFloat(kdv_yuzde);
                let kdv_tutar = $(this).find("td").eq(3).text();
                kdv_tutar = kdv_tutar.replace(/\./g, "").replace(",", ".");
                kdv_tutar = parseFloat(kdv_tutar);
                let iskonto_yuzde = $(this).find("td").eq(4).text();
                iskonto_yuzde = iskonto_yuzde.replace(/\./g, "").replace(",", ".");
                iskonto_yuzde = parseFloat(iskonto_yuzde);
                let iskonto_tutar = $(this).find("td").eq(5).text();
                iskonto_tutar = iskonto_tutar.replace(/\./g, "").replace(",", ".");
                iskonto_tutar = parseFloat(iskonto_tutar);
                let ara_toplam = $(this).find("td").eq(6).text();
                ara_toplam = ara_toplam.replace(/\./g, "").replace(",", ".");
                ara_toplam = parseFloat(ara_toplam);
                let genel_toplam = $(this).find("td").eq(7).text();
                genel_toplam = genel_toplam.replace(/\./g, "").replace(",", ".");
                genel_toplam = parseFloat(genel_toplam);
                let aciklama = $(this).find("td").eq(8).text();


                let newRow = {
                    cari_id: cari_id,
                    kdv_yuzde: kdv_yuzde,
                    kdv_tutar: kdv_tutar,
                    iskonto_yuzde: iskonto_yuzde,
                    iskonto_tutar: iskonto_tutar,
                    ara_toplam: ara_toplam,
                    genel_toplam: genel_toplam,
                    aciklama: aciklama
                };
                basilacak_arr.push(newRow);
            });

            $.ajax({
                url: "controller/gider_controller/sql.php?islem=yeni_muhasebe_gider_ekle_sql",
                type: "POST",
                data: {
                    basilacak_arr: basilacak_arr,
                    fatura_no: fatura_no,
                    fatura_tarihi: fatura_tarihi,
                    aciklama: aciklama
                },
                success: function (result) {
                    if (result == 1) {
                        Swal.fire(
                            "Başarılı",
                            "Gider Faturası Kaydedildi",
                            "success"
                        );
                        $.get("view/muhasebe_gider_faturalari.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                        $.get("view/muhasebe_gider_faturalari.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                        $("#gider_faturasi_kes_modal").modal("hide");
                    } else {
                        Swal.fire(
                            "Oops...",
                            "Bilinmeyen Bir Hata Oluştu...",
                            "error"
                        );
                        $("#gider_faturasi_kes_modal").modal("hide");
                    }
                }
            });

        });

        $("body").off("click", "#yeni_muhasebe_gider_fisi_ekle").on("click", "#yeni_muhasebe_gider_fisi_ekle", function () {
            let cari_kodu = $("#cari_id").val();
            let cari_adi = $("#cari_adi").val();
            let cari_id = $("#cari_id").attr("data-id");
            let aciklama = $("#aciklama").val();
            let kdv_tutar = $("#gider_kdv").attr("kdv_tutar");
            let kdv_yuzde = $("#gider_kdv").val();
            let iskonto_tutar = $("#gider_iskonto").attr("iskonto_tutar");
            let iskonto_yuzde = $("#gider_iskonto").val();
            let gider_fiyat = $("#gider_fiyat").val();
            let genel_toplam = $("#gider_genel_toplam").val();
            if (cari_id == undefined || cari_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Cari Seçiniz...",
                    "warning"
                );
                $("#cari_id").focus();
            } else {
                let table = muhasebe_gider_faturalari.row.add([cari_kodu, cari_adi, kdv_yuzde, kdv_tutar, iskonto_yuzde, iskonto_tutar, gider_fiyat, genel_toplam, aciklama, "<button class='btn btn-danger btn-sm gideri_listeden_sil'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                let total_kdv = 0;
                let total_iskonto = 0;
                let total = 0;
                $(".eklenen_muhasebe_giderleri").each(function () {
                    let kdv = $(this).find("td").eq(3).text();
                    kdv = kdv.replace(/\./g, "").replace(",", ".");
                    kdv = parseFloat(kdv);
                    let iskonto = $(this).find("td").eq(5).text();
                    iskonto = iskonto.replace(/\./g, "").replace(",", ".");
                    iskonto = parseFloat(iskonto);
                    let genel_toplam = $(this).find("td").eq(7).text();
                    genel_toplam = genel_toplam.replace(/\./g, "").replace(",", ".");
                    genel_toplam = parseFloat(genel_toplam);
                    total_kdv += kdv;
                    total_iskonto += iskonto;
                    total += genel_toplam;
                });

                $(".kdv_toplam_bas").html("");
                $(".kdv_toplam_bas").html(total_kdv.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) + " TL");

                $(".iskonto_toplam_bas").html("");
                $(".iskonto_toplam_bas").html(total_iskonto.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) + " TL");

                $(".genel_toplam_bas").html("");
                $(".genel_toplam_bas").html(total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) + " TL");

                $(table).attr("cari_id", cari_id);
                $("#cari_id").val("");
                $("#cari_adi").val("");
                $("#cari_id").attr("data-id", "");
                $("#aciklama").val("");
                $("#gider_kdv").attr("kdv_tutar", "0,00");
                $("#gider_kdv").val("0,00");
                $("#gider_iskonto").attr("iskonto_tutar", "0,00");
                $("#gider_iskonto").val("0,00");
                $("#gider_fiyat").val("0,00");
                $("#gider_genel_toplam").val("0,00");
                $("#cari_id").focus();
            }
        });

        $("body").off("click", ".gideri_listeden_sil").on("click", ".gideri_listeden_sil", function () {
            var row = $(this).closest('tr');
            muhasebe_gider_faturalari.row(row).remove().draw(false);

            let total_kdv = 0;
            let total_iskonto = 0;
            let total = 0;


            var rowCount = muhasebe_gider_faturalari.rows().count();
            $(".eklenen_muhasebe_giderleri").each(function () {
                let kdv = $(this).find("td").eq(3).text();
                kdv = kdv.replace(/\./g, "").replace(",", ".");
                kdv = parseFloat(kdv);
                let iskonto = $(this).find("td").eq(5).text();
                iskonto = iskonto.replace(/\./g, "").replace(",", ".");
                iskonto = parseFloat(iskonto);
                let genel_toplam = $(this).find("td").eq(7).text();
                genel_toplam = genel_toplam.replace(/\./g, "").replace(",", ".");
                genel_toplam = parseFloat(genel_toplam);
                total_kdv += kdv;
                total_iskonto += iskonto;
                total += genel_toplam;
            });

            if (rowCount == 0) {
                $(".kdv_toplam_bas").html("");
                $(".kdv_toplam_bas").html("0,00 TL");

                $(".iskonto_toplam_bas").html("");
                $(".iskonto_toplam_bas").html("0,00 TL");

                $(".genel_toplam_bas").html("");
                $(".genel_toplam_bas").html("0,00 TL");
            } else {
                $(".kdv_toplam_bas").html("");
                $(".kdv_toplam_bas").html(total_kdv.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) + " TL");

                $(".iskonto_toplam_bas").html("");
                $(".iskonto_toplam_bas").html(total_iskonto.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) + " TL");

                $(".genel_toplam_bas").html("");
                $(".genel_toplam_bas").html(total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) + " TL");
            }
        });

        $("body").off("click", "#cari_kodu_button").on("click", "#cari_kodu_button", function () {
            $.get("konteyner/modals/sanayi_modal/ozmal_sanayi.php?islem=carileri_getir", function (getModal) {
                $(".carileri_getir_div").html("");
                $(".carileri_getir_div").html(getModal);
            })
        });
        $("input").click(function () {
            $(this).select();
        })
        $("body").off("focusout", "#gider_fiyat").on("focusout", "#gider_fiyat", function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }

            let kdv = $("#gider_kdv").val();
            kdv = kdv.replace(/\./g, "").replace(",", ".");
            kdv = parseFloat(kdv);
            let kdv_yuzde = kdv / 100;
            let kdv_tutar = val * kdv_yuzde;
            $("#gider_kdv").attr("kdv_tutar", kdv_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));

            let iskonto = $("#gider_iskonto").val();
            iskonto = iskonto.replace(/\./g, "").replace(",", ".");
            iskonto = parseFloat(iskonto);
            let iskonto_yuzde = iskonto / 100;
            let iskonto_tutar = val * iskonto_yuzde;
            $("#gider_iskonto").attr("iskonto_tutar", iskonto_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));

            let tutar = val - iskonto_tutar;
            tutar = tutar + kdv_tutar;
            $("#gider_genel_toplam").val(tutar.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));


            $(this).val(val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });
        $("body").off("focusout", "#gider_kdv").on("focusout", "#gider_kdv", function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }

            let fiyat = $("#gider_fiyat").val();
            fiyat = fiyat.replace(/\./g, "").replace(",", ".");
            fiyat = parseFloat(fiyat);

            let kdv = $("#gider_kdv").val();
            kdv = kdv.replace(/\./g, "").replace(",", ".");
            kdv = parseFloat(kdv);
            let kdv_yuzde = kdv / 100;
            let kdv_tutar = fiyat * kdv_yuzde;
            $("#gider_kdv").attr("kdv_tutar", kdv_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));

            let iskonto = $("#gider_iskonto").val();
            iskonto = iskonto.replace(/\./g, "").replace(",", ".");
            iskonto = parseFloat(iskonto);
            let iskonto_yuzde = iskonto / 100;
            let iskonto_tutar = fiyat * iskonto_yuzde;
            $("#gider_iskonto").attr("iskonto_tutar", iskonto_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));

            let tutar = fiyat - iskonto_tutar;
            tutar = tutar + kdv_tutar;
            $("#gider_genel_toplam").val(tutar.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
            $(this).val(val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });
        $("body").off("focusout", "#gider_iskonto").on("focusout", "#gider_iskonto", function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }

            let fiyat = $("#gider_fiyat").val();
            fiyat = fiyat.replace(/\./g, "").replace(",", ".");
            fiyat = parseFloat(fiyat);

            let kdv = $("#gider_kdv").val();
            kdv = kdv.replace(/\./g, "").replace(",", ".");
            kdv = parseFloat(kdv);
            let kdv_yuzde = kdv / 100;
            let kdv_tutar = fiyat * kdv_yuzde;
            $("#gider_kdv").attr("kdv_tutar", kdv_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));

            let iskonto = $("#gider_iskonto").val();
            iskonto = iskonto.replace(/\./g, "").replace(",", ".");
            iskonto = parseFloat(iskonto);
            let iskonto_yuzde = iskonto / 100;
            let iskonto_tutar = fiyat * iskonto_yuzde;
            $("#gider_iskonto").attr("iskonto_tutar", iskonto_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));

            let tutar = fiyat - iskonto_tutar;
            tutar = tutar + kdv_tutar;
            $("#gider_genel_toplam").val(tutar.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));

            $(this).val(val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });
        $(document).ready(function () {
            $("#gider_faturasi_kes_modal").modal("show");
            setTimeout(function () {
                $("#gider_fatura_no").focus();
                $("#muhasebe_gider").trigger("click");
            }, 500);
            muhasebe_gider_faturalari = $('#muhasebe_gider_faturalari_modal_list').DataTable({
                scrollY: '30vh',
                scrollX: true,
                "info": false,
                "paging": false,
                createdRow: function (row) {
                    $(row).find("td").css("text-transform", "uppercase")
                    $(row).addClass("eklenen_muhasebe_giderleri")
                    $(row).find("td").eq(0).css("text-align", "left");
                    $(row).find("td").eq(1).css("text-align", "left");
                },
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            })
        });

        $("body").off("keyup", "#cari_id").on("keyup", "#cari_id", function () {
            let val = $(this).val();
            $.get("konteyner/controller/sanayi_controller/sql.php?islem=cari_kodu_bilgilerini_getir", {cari_kodu: val}, function (response) {
                if (response != 2) {
                    var item = JSON.parse(response);
                    $("#cari_id").val(item.cari_kodu);
                    $("#cari_id").attr("data-id", item.id);
                    $("#cari_adi").val((item.cari_adi).toUpperCase());
                } else {
                    $("#cari_id").attr("data-id", "");
                    $("#cari_adi").val("");
                    $("#cari_adres").val("");
                    $("#vergi_dairesi").val("");
                    $("#vergi_no").val("");
                }
            })
        });

        $("body").off("click", "#gider_fatura_vazgec").on("click", "#gider_fatura_vazgec", function () {
            $("#gider_faturasi_kes_modal").modal("hide");
        });
    </script>
    <?php
}