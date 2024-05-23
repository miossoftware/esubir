<?php

$islem = $_GET["islem"];

if ($islem == "perakende_satis_yap") {
    ?>
    <style>
        #perakende_satis_ekleme_sayfasi {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="perakende_satis_ekleme_sayfasi" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 75%; max-width: 75%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="perakende_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>PERAKENDE SATIŞ</div>
                        </div>
                        <div class="modal-body">
                            <div class="perakende_satis_kasalar_div"></div>
                            <div class="perakende_satis_stoklar_div"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="col-12 row mt-2">
                                        <div class="form-group row mt-2">
                                            <div class="col-md-4">
                                                <label>Müşteri</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="musteri_adi">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label>Telefon</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control form-control-sm" id="telefon">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label>E-Posta</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control form-control-sm" id="e_posta">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label>Vergi Dairesi</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="vergi_dairesi">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label>Vergi No</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control form-control-sm" id="vergi_no">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row mt-3">
                                        <div class="col-md-4">
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea class="form-control form-control-sm" style="resize: none"
                                                      id="aciklama"
                                                      rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Adres</label>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea class="form-control form-control-sm" style="resize: none"
                                                      id="adres"
                                                      rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 row mt-1 ">
                                    <div style="border: 1px solid #000" class="col-9 ">
                                        <div class="form-group row mt-3">
                                            <div class="col-md-3">
                                                <label>Barkod / Stok Kodu</label>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <input type="text" style="font-size: 15px; font-weight: bold"
                                                           class="form-control form-control-sm"
                                                           id="stok_barkod_perakende">
                                                    <div class="input-group-append mx-1">
                                                        <button class="btn btn-warning"
                                                                id="perakende_icin_stoklari_getir"><i
                                                                    class="fa fa-ellipsis-h"></i> Seç
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <table class="table table-sm table-bordered w-100 display nowrap"
                                               style="cursor:pointer;font-size: 13px;"
                                               id="perakende_kalemleri_listesi">
                                            <thead>
                                            <tr>
                                                <th id="stok_kodu_click">Stok Kodu</th>
                                                <th>Stok Adı</th>
                                                <th>Birim</th>
                                                <th>Miktar</th>
                                                <th>Birim Fiyat</th>
                                                <th>KDV (%)</th>
                                                <th>KDV Tutar</th>
                                                <th>İskonto (%)</th>
                                                <th>İskonto Tutar</th>
                                                <th>Ara Toplam</th>
                                                <th>Toplam</th>
                                                <th>İşlem</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div style="border: 1px solid #000;" class="col-3">
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Fatura No</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control form-control-sm" id="fatura_no">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Fatura Tarihi</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="date" value="<?= date("Y-m-d") ?>"
                                                       class="form-control form-control-sm" id="fatura_tarihi">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Depo</label>
                                            </div>
                                            <div class="col-md-6">
                                                <select class="custom-select custom-select-sm" id="perakende_depoid">
                                                    <option value="">Depo Seçiniz...</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>İskonto Toplam</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" style="text-align: right" disabled
                                                       class="form-control form-control-sm" value="0,00"
                                                       id="iskonto_toplam">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>KDV Toplam</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" style="text-align: right" disabled
                                                       class="form-control form-control-sm" value="0,00"
                                                       id="kdv_toplam">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Ara Toplam</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" style="text-align: right" disabled
                                                       class="form-control form-control-sm" value="0,00"
                                                       id="toplam_ara_toplam">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label style="font-weight: bold; font-size: 15px">Genel Toplam</label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <input type="text"
                                                       style=" text-align: right; font-size: 20px; font-weight: bold"
                                                       value="0,00" disabled class="form-control form-control-sm"
                                                       id="toplam_genel_toplam">
                                            </div>
                                        </div>
                                        <div class="col-12 row">
                                            <div class="col-6">
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <button class="btn" id="nakit_odeme_kasalari_getir"
                                                                style="width: 105%;background-color: #C7E8CA">
                                                            <div class="d-flex flex-column align-items-center">
                                                                <i class="fa fa-money"></i>
                                                                <span class="mt-2">Nakit</span>
                                                            </div>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <button class="btn " id="kart_odemesi_icin_poslari_getir"
                                                                style="width: 105%;background-color: #CBFFA9">
                                                            <div class="d-flex flex-column align-items-center">
                                                                <i class="fa fa-credit-card"></i>
                                                                <span class="mt-2">Kredi Kartı</span>
                                                            </div>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mx-1">
                                            <div class="mx-5"></div>
                                            <div class="col-md-6 mx-5">
                                                <button class="btn mx-4" id="havale_icin_bankalari_getir"
                                                        style="width: 105%;background-color: #A2FF86">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <i class="fa fa-credit-card"></i>
                                                        <span class="mt-2">Havale</span>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("body").off("click", "#nakit_odeme_kasalari_getir").on("click", "#nakit_odeme_kasalari_getir", function () {
            $.get("modals/satis_modal/perakende_satis.php?islem=satis_icin_kasalari_getir", function (getModal) {
                $(".perakende_satis_kasalar_div").html("");
                $(".perakende_satis_kasalar_div").html(getModal);
            });
        });

        $("body").off("click", "#kart_odemesi_icin_poslari_getir").on("click", "#kart_odemesi_icin_poslari_getir", function () {
            $.get("modals/satis_modal/perakende_satis.php?islem=satis_icin_pos_cihazlarini_getir", function (getModal) {
                $(".perakende_satis_kasalar_div").html("");
                $(".perakende_satis_kasalar_div").html(getModal);
            });
        });

        $("body").off("click", "#havale_icin_bankalari_getir").on("click", "#havale_icin_bankalari_getir", function () {
            $.get("modals/satis_modal/perakende_satis.php?islem=satis_icin_bankalari_getir", function (getModal) {
                $(".perakende_satis_kasalar_div").html("");
                $(".perakende_satis_kasalar_div").html(getModal);
            });
        });

        $("body").off("click", "#perakende_icin_stoklari_getir").on("click", "#perakende_icin_stoklari_getir", function () {
            $.get("modals/satis_modal/perakende_satis.php?islem=perakende_satis_icin_stoklari_getir", function (getModal) {
                $(".perakende_satis_stoklar_div").html("");
                $(".perakende_satis_stoklar_div").html(getModal);
            })
        });


        var perakende_table = "";
        $("#stok_barkod_perakende").keyup(function (e) {
            let value = $(this).val();
            if (e.which === 13) {
                $.get("controller/perakende_controller/sql.php?islem=girilen_stok_bilgileri_getir_sql", {value: value}, function (response) {
                    if (response != 2) {
                        var item = JSON.parse(response);
                        let birim_fiyat = item.satis_fiyat;
                        birim_fiyat = parseFloat(birim_fiyat);
                        birim_fiyat = birim_fiyat.toLocaleString("tr-TR", {
                            maximumFractionDigits: 2,
                            minimumFractionDigits: 2
                        });
                        var rowCount = perakende_table.rows().count();
                        rowCount = rowCount + 1;
                        let kdv = item.kdv_orani;
                        kdv = parseFloat(kdv);
                        kdv = kdv.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        perakende_table.row.add([item.stok_kodu, item.stok_adi, item.birim_adi, "<input type='text' data-id='" + rowCount + "' class='form-control form-control-sm col-9 miktar_perakende' value='0,00'/>", "<input type='text' data-id='" + rowCount + "' class='form-control form-control-sm col-9 birim_fiyat_perakende' value='" + birim_fiyat + "'/>", "<input type='text' data-id='" + rowCount + "' class='form-control form-control-sm col-9 kdv_perakende' value='" + kdv + "'/>", "0,00", "<input type='text' class='form-control form-control-sm col-9 iskonto_perakende' data-id='" + rowCount + "' value='0,00'/>", "0,00", "0,00", "0,00", "<button class='btn btn-danger btn-sm perakende_iptal_et_list_main_button'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                        $("#stok_barkod_perakende").val("");
                    }
                })
            }
        });


        $("body").off("click", ".perakende_iptal_et_list_main_button").on("click", ".perakende_iptal_et_list_main_button", function () {
            var row = $(this).closest('tr');
            perakende_table.row(row).remove().draw();
            let toplam_iskonto = 0;
            let kdv_toplam = 0;
            let ara_toplam = 0;
            let genel_toplam = 0;
            $(".perakende_listesi").each(function () {
                let kdv_tutar = $(this).find("td").eq(6).text();
                kdv_tutar = kdv_tutar.replace(/\./g, "").replace(",", ".");
                kdv_tutar = parseFloat(kdv_tutar);
                let iskonto_tutar = $(this).find("td").eq(8).text();
                iskonto_tutar = iskonto_tutar.replace(/\./g, "").replace(",", ".");
                iskonto_tutar = parseFloat(iskonto_tutar);
                let ara_tutar = $(this).find("td").eq(9).text();
                ara_tutar = ara_tutar.replace(/\./g, "").replace(",", ".");
                ara_tutar = parseFloat(ara_tutar);
                let genel_tutar = $(this).find("td").eq(10).text();
                genel_tutar = genel_tutar.replace(/\./g, "").replace(",", ".");
                genel_tutar = parseFloat(genel_tutar);
                toplam_iskonto += iskonto_tutar;
                kdv_toplam += kdv_tutar;
                ara_toplam += ara_tutar;
                genel_toplam += genel_tutar;
            })
            $("#iskonto_toplam").val(toplam_iskonto.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            $("#kdv_toplam").val(kdv_toplam.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            $("#toplam_ara_toplam").val(ara_toplam.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            $("#toplam_genel_toplam").val(genel_toplam.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
        })

        $("body").off("focusout", ".miktar_perakende").on("focusout", ".miktar_perakende", function () {
            let closest = $(this).closest("tr");
            let data_id = $(this).attr("data-id");
            let tutar = $(this).val();
            let birim_fiyat = $(".birim_fiyat_perakende[data-id='" + data_id + "']").val();
            birim_fiyat = birim_fiyat.replace(/\./g, "").replace(",", ".");
            birim_fiyat = parseFloat(birim_fiyat);
            if (isNaN(birim_fiyat)) {
                birim_fiyat = 0;
            }
            let kdv = $(".kdv_perakende[data-id='" + data_id + "']").val();
            kdv = kdv.replace(/\./g, "").replace(",", ".");
            kdv = parseFloat(kdv);
            if (isNaN(kdv)) {
                kdv = 0;
            }
            let iskonto = $(".iskonto_perakende[data-id='" + data_id + "']").val();
            iskonto = iskonto.replace(/\./g, "").replace(",", ".");
            iskonto = parseFloat(iskonto);
            if (isNaN(iskonto)) {
                iskonto = 0;
            }
            tutar = parseFloat(tutar);
            if (isNaN(tutar)) {
                tutar = 0;
            }
            let kdv_yuzde = kdv / 100;
            let iskonto_yuzde = iskonto / 100;
            let ara_tutar = tutar * birim_fiyat;
            $(closest).find("td").eq(9).text(ara_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            let kdv_tutar = ara_tutar * kdv_yuzde;
            $(closest).find("td").eq(6).text(kdv_tutar.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
            ara_tutar = kdv_tutar + ara_tutar;
            let iskonto_tutar = ara_tutar * iskonto_yuzde;
            $(closest).find("td").eq(8).text(iskonto_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            ara_tutar = ara_tutar - iskonto_tutar;
            $(closest).find("td").eq(10).text(ara_tutar.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
            tutar = tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
            $(this).val(tutar)
            let toplam_iskonto = 0;
            let kdv_toplam = 0;
            let ara_toplam = 0;
            let genel_toplam = 0;
            $(".perakende_listesi").each(function () {
                let kdv_tutar = $(this).find("td").eq(6).text();
                kdv_tutar = kdv_tutar.replace(/\./g, "").replace(",", ".");
                kdv_tutar = parseFloat(kdv_tutar);
                let iskonto_tutar = $(this).find("td").eq(8).text();
                iskonto_tutar = iskonto_tutar.replace(/\./g, "").replace(",", ".");
                iskonto_tutar = parseFloat(iskonto_tutar);
                let ara_tutar = $(this).find("td").eq(9).text();
                ara_tutar = ara_tutar.replace(/\./g, "").replace(",", ".");
                ara_tutar = parseFloat(ara_tutar);
                let genel_tutar = $(this).find("td").eq(10).text();
                genel_tutar = genel_tutar.replace(/\./g, "").replace(",", ".");
                genel_tutar = parseFloat(genel_tutar);
                toplam_iskonto += iskonto_tutar;
                kdv_toplam += kdv_tutar;
                ara_toplam += ara_tutar;
                genel_toplam += genel_tutar;
            })
            $("#iskonto_toplam").val(toplam_iskonto.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            $("#kdv_toplam").val(kdv_toplam.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            $("#toplam_ara_toplam").val(ara_toplam.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            $("#toplam_genel_toplam").val(genel_toplam.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
        });


        $("body").off("focusout", ".birim_fiyat_perakende").on("focusout", ".birim_fiyat_perakende", function () {
            let closest = $(this).closest("tr");
            let data_id = $(this).attr("data-id");
            let birim_fiyat = $(this).val(); // MİKTAR
            let miktar = $(".miktar_perakende[data-id='" + data_id + "']").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            if (isNaN(miktar)) {
                miktar = 0;
            }
            let kdv = $(".kdv_perakende[data-id='" + data_id + "']").val();
            kdv = kdv.replace(/\./g, "").replace(",", ".");
            kdv = parseFloat(kdv);
            if (isNaN(kdv)) {
                kdv = 0;
            }
            let iskonto = $(".iskonto_perakende[data-id='" + data_id + "']").val();
            iskonto = iskonto.replace(/\./g, "").replace(",", ".");
            iskonto = parseFloat(iskonto);
            if (isNaN(iskonto)) {
                iskonto = 0;
            }
            birim_fiyat = parseFloat(birim_fiyat);
            if (isNaN(birim_fiyat)) {
                birim_fiyat = 0;
            }
            let kdv_yuzde = kdv / 100;
            let iskonto_yuzde = iskonto / 100;
            let ara_tutar = birim_fiyat * miktar;
            $(closest).find("td").eq(9).text(ara_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            let kdv_tutar = ara_tutar * kdv_yuzde;
            $(closest).find("td").eq(6).text(kdv_tutar.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
            ara_tutar = kdv_tutar + ara_tutar;
            let iskonto_tutar = ara_tutar * iskonto_yuzde;
            $(closest).find("td").eq(8).text(iskonto_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            ara_tutar = ara_tutar - iskonto_tutar;
            $(closest).find("td").eq(10).text(ara_tutar.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
            birim_fiyat = birim_fiyat.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
            $(this).val(birim_fiyat);

            let toplam_iskonto = 0;
            let kdv_toplam = 0;
            let ara_toplam = 0;
            let genel_toplam = 0;
            $(".perakende_listesi").each(function () {
                let kdv_tutar = $(this).find("td").eq(6).text();
                kdv_tutar = kdv_tutar.replace(/\./g, "").replace(",", ".");
                kdv_tutar = parseFloat(kdv_tutar);
                let iskonto_tutar = $(this).find("td").eq(8).text();
                iskonto_tutar = iskonto_tutar.replace(/\./g, "").replace(",", ".");
                iskonto_tutar = parseFloat(iskonto_tutar);
                let ara_tutar = $(this).find("td").eq(9).text();
                ara_tutar = ara_tutar.replace(/\./g, "").replace(",", ".");
                ara_tutar = parseFloat(ara_tutar);
                let genel_tutar = $(this).find("td").eq(10).text();
                genel_tutar = genel_tutar.replace(/\./g, "").replace(",", ".");
                genel_tutar = parseFloat(genel_tutar);

                toplam_iskonto += iskonto_tutar;
                kdv_toplam += kdv_tutar;
                ara_toplam += ara_tutar;
                genel_toplam += genel_tutar;
            })
            $("#iskonto_toplam").val(toplam_iskonto.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            $("#kdv_toplam").val(kdv_toplam.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            $("#toplam_ara_toplam").val(ara_toplam.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            $("#toplam_genel_toplam").val(genel_toplam.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
        });

        $("body").off("focusout", ".kdv_perakende").on("focusout", ".kdv_perakende", function () {
            let closest = $(this).closest("tr");
            let data_id = $(this).attr("data-id");
            let kdv = $(this).val(); // kdv oranı
            let miktar = $(".miktar_perakende[data-id='" + data_id + "']").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            if (isNaN(miktar)) {
                miktar = 0;
            }
            let birim_fiyat = $(".birim_fiyat_perakende[data-id='" + data_id + "']").val();
            birim_fiyat = birim_fiyat.replace(/\./g, "").replace(",", ".");
            birim_fiyat = parseFloat(birim_fiyat);
            if (isNaN(birim_fiyat)) {
                birim_fiyat = 0;
            }
            let iskonto = $(".iskonto_perakende[data-id='" + data_id + "']").val();
            iskonto = iskonto.replace(/\./g, "").replace(",", ".");
            iskonto = parseFloat(iskonto);
            if (isNaN(iskonto)) {
                iskonto = 0;
            }
            kdv = parseFloat(kdv);
            if (isNaN(kdv)) {
                kdv = 0;
            }
            let kdv_yuzde = kdv / 100;
            let iskonto_yuzde = iskonto / 100;
            let ara_tutar = birim_fiyat * miktar;
            $(closest).find("td").eq(9).text(ara_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            let kdv_tutar = ara_tutar * kdv_yuzde;
            $(closest).find("td").eq(6).text(kdv_tutar.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
            ara_tutar = kdv_tutar + ara_tutar;
            let iskonto_tutar = ara_tutar * iskonto_yuzde;
            $(closest).find("td").eq(8).text(iskonto_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            ara_tutar = ara_tutar - iskonto_tutar;
            $(closest).find("td").eq(10).text(ara_tutar.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
            kdv = kdv.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
            $(this).val(kdv)

            let toplam_iskonto = 0;
            let kdv_toplam = 0;
            let ara_toplam = 0;
            let genel_toplam = 0;
            $(".perakende_listesi").each(function () {
                let kdv_tutar = $(this).find("td").eq(6).text();
                kdv_tutar = kdv_tutar.replace(/\./g, "").replace(",", ".");
                kdv_tutar = parseFloat(kdv_tutar);
                let iskonto_tutar = $(this).find("td").eq(8).text();
                iskonto_tutar = iskonto_tutar.replace(/\./g, "").replace(",", ".");
                iskonto_tutar = parseFloat(iskonto_tutar);
                let ara_tutar = $(this).find("td").eq(9).text();
                ara_tutar = ara_tutar.replace(/\./g, "").replace(",", ".");
                ara_tutar = parseFloat(ara_tutar);
                let genel_tutar = $(this).find("td").eq(10).text();
                genel_tutar = genel_tutar.replace(/\./g, "").replace(",", ".");
                genel_tutar = parseFloat(genel_tutar);

                toplam_iskonto += iskonto_tutar;
                kdv_toplam += kdv_tutar;
                ara_toplam += ara_tutar;
                genel_toplam += genel_tutar;
            })
            $("#iskonto_toplam").val(toplam_iskonto.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            $("#kdv_toplam").val(kdv_toplam.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            $("#toplam_ara_toplam").val(ara_toplam.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            $("#toplam_genel_toplam").val(genel_toplam.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
        });

        $("body").off("focusout", ".iskonto_perakende").on("focusout", ".iskonto_perakende", function () {
            let closest = $(this).closest("tr");
            let data_id = $(this).attr("data-id");
            let iskonto = $(this).val(); // kdv oranı
            let miktar = $(".miktar_perakende[data-id='" + data_id + "']").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            if (isNaN(miktar)) {
                miktar = 0;
            }
            let birim_fiyat = $(".birim_fiyat_perakende[data-id='" + data_id + "']").val();
            birim_fiyat = birim_fiyat.replace(/\./g, "").replace(",", ".");
            birim_fiyat = parseFloat(birim_fiyat);
            if (isNaN(birim_fiyat)) {
                birim_fiyat = 0;
            }
            let kdv = $(".kdv_perakende[data-id='" + data_id + "']").val();
            kdv = kdv.replace(/\./g, "").replace(",", ".");
            kdv = parseFloat(kdv);
            if (isNaN(kdv)) {
                kdv = 0;
            }
            iskonto = parseFloat(iskonto);
            if (isNaN(iskonto)) {
                iskonto = 0;
            }
            let kdv_yuzde = kdv / 100;
            let iskonto_yuzde = iskonto / 100;
            let ara_tutar = birim_fiyat * miktar;
            $(closest).find("td").eq(9).text(ara_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            let kdv_tutar = ara_tutar * kdv_yuzde;
            $(closest).find("td").eq(6).text(kdv_tutar.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
            ara_tutar = kdv_tutar + ara_tutar;
            let iskonto_tutar = ara_tutar * iskonto_yuzde;
            $(closest).find("td").eq(8).text(iskonto_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            ara_tutar = ara_tutar - iskonto_tutar;
            $(closest).find("td").eq(10).text(ara_tutar.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
            iskonto = iskonto.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
            $(this).val(iskonto)

            let toplam_iskonto = 0;
            let kdv_toplam = 0;
            let ara_toplam = 0;
            let genel_toplam = 0;
            $(".perakende_listesi").each(function () {
                let kdv_tutar = $(this).find("td").eq(6).text();
                kdv_tutar = kdv_tutar.replace(/\./g, "").replace(",", ".");
                kdv_tutar = parseFloat(kdv_tutar);
                let iskonto_tutar = $(this).find("td").eq(8).text();
                iskonto_tutar = iskonto_tutar.replace(/\./g, "").replace(",", ".");
                iskonto_tutar = parseFloat(iskonto_tutar);
                let ara_tutar = $(this).find("td").eq(9).text();
                ara_tutar = ara_tutar.replace(/\./g, "").replace(",", ".");
                ara_tutar = parseFloat(ara_tutar);
                let genel_tutar = $(this).find("td").eq(10).text();
                genel_tutar = genel_tutar.replace(/\./g, "").replace(",", ".");
                genel_tutar = parseFloat(genel_tutar);

                toplam_iskonto += iskonto_tutar;
                kdv_toplam += kdv_tutar;
                ara_toplam += ara_tutar;
                genel_toplam += genel_tutar;
            })
            $("#iskonto_toplam").val(toplam_iskonto.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            $("#kdv_toplam").val(kdv_toplam.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            $("#toplam_ara_toplam").val(ara_toplam.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            $("#toplam_genel_toplam").val(genel_toplam.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
        });

        $("body").off("click", "#perakende_vazgec").on("click", "#perakende_vazgec", function () {
            $("#perakende_satis_ekleme_sayfasi").modal("hide");
        });

        $(document).ready(function () {
            setTimeout(function () {
                $("#stok_kodu_click").trigger("click");
            }, 500);
            $("#perakende_satis_ekleme_sayfasi").modal("show");
            perakende_table = $("#perakende_kalemleri_listesi").DataTable({
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                scrollX: true,
                scrollY: "55vh",
                paging: false,
                searching: false,
                info: false,
                "initComplete": function () {
                    $('#cari_table').addClass('myCustomStyle');
                },
                createdRow: function (row) {
                    $(row).addClass("perakende_listesi");
                    $(row).find("td").css("text-transform", "uppercase");
                    $(row).find("td").eq(0).css("text-align", "left");
                    $(row).find("td").eq(1).css("text-align", "left");
                    $(row).find("td").eq(2).css("text-align", "left");
                }
            });

            $.get("controller/satis_controller/sql.php?islem=depolari_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        let selected = "";
                        if (item.varsayilan_depo == 1) {
                            selected = "selected";
                        }
                        $("#perakende_depoid").append("" +
                            "<option value='" + item.id + "' " + selected + ">" + item.depo_adi + "</option>" +
                            "");
                    })
                }
            })
        })
    </script>
    <?php
}
if ($islem == "satis_icin_kasalari_getir") {
    ?>
    <div class="modal fade" id="kasalar_listesi_cek_senet_modal"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 55%; max-width: 55%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Kasa Listesi
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="banka_liste_cek_senet">
                            <thead>
                            <tr>
                                <th id="click1">Kasa Adı</th>
                                <th>Kasa Kodu</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#kasalar_listesi_cek_senet_modal").modal("hide");
        })
        $(document).ready(function () {
            $("#kasalar_listesi_cek_senet_modal").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 300);
            var table = $('#banka_liste_cek_senet').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "kasa_adi"},
                    {'data': "kasa_kodu"}
                ],
                createdRow: function (row) {
                    $(row).addClass("perakende_secilen_banka");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $("body").off("click", ".perakende_secilen_banka").on("click", ".perakende_secilen_banka", function () {
                let depo_id = $("#perakende_depoid").val();
                let musteri_adi = $("#musteri_adi").val();
                let telefon = $("#telefon").val();
                let e_posta = $("#e_posta").val();
                let vergi_dairesi = $("#vergi_dairesi").val();
                let fatura_no = $("#fatura_no").val();
                let fatura_tarihi = $("#fatura_tarihi").val();
                let vergi_no = $("#vergi_no").val();
                let aciklama = $("#aciklama").val();
                let adres = $("#adres").val();
                let kasa_id = $(this).attr("data-id");
                var arr = [];
                $(".perakende_listesi").each(function () {
                    let stok_kodu = $(this).find("td").eq(0).text();
                    let stok_adi = $(this).find("td").eq(1).text();
                    let birim = $(this).find("td").eq(2).text();
                    let miktar = $(this).find(".miktar_perakende").val();
                    miktar = miktar.replace(/\./g, "").replace(",", ".");
                    miktar = parseFloat(miktar);
                    let birim_fiyat = $(this).find(".birim_fiyat_perakende").val();
                    birim_fiyat = birim_fiyat.replace(/\./g, "").replace(",", ".");
                    birim_fiyat = parseFloat(birim_fiyat);
                    let kdv_orani = $(this).find(".kdv_perakende").val();
                    kdv_orani = kdv_orani.replace(/\./g, "").replace(",", ".");
                    kdv_orani = parseFloat(kdv_orani);
                    let kdv_tutar = $(this).find("td").eq(6).text();
                    kdv_tutar = kdv_tutar.replace(/\./g, "").replace(",", ".");
                    kdv_tutar = parseFloat(kdv_tutar);
                    let iskonto_orani = $(this).find(".iskonto_perakende").val();
                    iskonto_orani = iskonto_orani.replace(/\./g, "").replace(",", ".");
                    iskonto_orani = parseFloat(iskonto_orani);
                    let iskonto_tutari = $(this).find("td").eq(8).text();
                    iskonto_tutari = iskonto_tutari.replace(/\./g, "").replace(",", ".");
                    iskonto_tutari = parseFloat(iskonto_tutari);
                    let ara_toplam = $(this).find("td").eq(9).text();
                    ara_toplam = ara_toplam.replace(/\./g, "").replace(",", ".");
                    ara_toplam = parseFloat(ara_toplam);
                    let genel_toplam = $(this).find("td").eq(10).text();
                    genel_toplam = genel_toplam.replace(/\./g, "").replace(",", ".");
                    genel_toplam = parseFloat(genel_toplam);

                    let newRow = {
                        stok_kodu: stok_kodu,
                        stok_adi: stok_adi,
                        birim: birim,
                        miktar: miktar,
                        birim_fiyat: birim_fiyat,
                        kdv_oran: kdv_orani,
                        kdv_tutar: kdv_tutar,
                        iskonto_oran: iskonto_orani,
                        iskonto_tutar: iskonto_tutari,
                        ara_toplam: ara_toplam,
                        genel_toplam: genel_toplam
                    };

                    arr.push(newRow);
                });
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'mx-3 btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Kasa Kayıt İşlemine Eminmisiniz',
                    text: "Tahsilatı Kasadan Yapacaksınız",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Evet Eminim',
                    cancelButtonText: 'Vazgeç',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'controller/perakende_controller/sql.php?islem=perakende_kasa_satisi_olustur',
                            type: "POST",
                            data: {
                                depo_id: depo_id,
                                musteri_adi: musteri_adi,
                                telefon: telefon,
                                e_posta: e_posta,
                                vergi_dairesi: vergi_dairesi,
                                vergi_no: vergi_no,
                                aciklama: aciklama,
                                adres: adres,
                                fatura_no: fatura_no,
                                fatura_tarihi: fatura_tarihi,
                                kasa_id: kasa_id,
                                arr: arr
                            },
                            success: function (result) {
                                if (result == 1) {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Perakende Satış Kaydedildi',
                                        'success'
                                    )
                                    $("#kasalar_listesi_cek_senet_modal").modal("hide");
                                    $("#perakende_satis_ekleme_sayfasi").modal("hide");
                                }
                            }
                        })

                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        Swal.fire(
                            'Uyarı!',
                            'Kasa Tahsilat İşleminden Vazgeçtiniz',
                            'warning'
                        )
                    }
                })

            });

            $.get("controller/kasa_controller/sql.php?islem=kasalari_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    table.rows.add(json).draw(false);
                }
            })
        })
    </script>
    <?php
}
if ($islem == "satis_icin_pos_cihazlarini_getir") {
    ?>
    <div class="modal fade" id="pos_cihazlarini_getir_modal"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 30%; max-width: 30%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">POS Listesi
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="banka_liste_cek_senet">
                            <thead>
                            <tr>
                                <th id="click1">POS Banka Adı</th>
                                <th>Vade Günü</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#pos_cihazlarini_getir_modal").modal("hide");
        })
        $(document).ready(function () {
            $("#pos_cihazlarini_getir_modal").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 300);
            var table = $('#banka_liste_cek_senet').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "banka_adi"},
                    {'data': "vade_gunu"}
                ],
                createdRow: function (row) {
                    $(row).addClass("banka_selected");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                    $(row).find('td').eq(2).css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $("body").off("click", ".banka_selected").on("click", ".banka_selected", function () {
                let depo_id = $("#perakende_depoid").val();
                let musteri_adi = $("#musteri_adi").val();
                let telefon = $("#telefon").val();
                let e_posta = $("#e_posta").val();
                let vergi_dairesi = $("#vergi_dairesi").val();
                let fatura_no = $("#fatura_no").val();
                let fatura_tarihi = $("#fatura_tarihi").val();
                let vergi_no = $("#vergi_no").val();
                let aciklama = $("#aciklama").val();
                let adres = $("#adres").val();
                let kasa_id = $(this).attr("data-id");
                var arr = [];
                $(".perakende_listesi").each(function () {
                    let stok_kodu = $(this).find("td").eq(0).text();
                    let stok_adi = $(this).find("td").eq(1).text();
                    let birim = $(this).find("td").eq(2).text();
                    let miktar = $(this).find(".miktar_perakende").val();
                    miktar = miktar.replace(/\./g, "").replace(",", ".");
                    miktar = parseFloat(miktar);
                    let birim_fiyat = $(this).find(".birim_fiyat_perakende").val();
                    birim_fiyat = birim_fiyat.replace(/\./g, "").replace(",", ".");
                    birim_fiyat = parseFloat(birim_fiyat);
                    let kdv_orani = $(this).find(".kdv_perakende").val();
                    kdv_orani = kdv_orani.replace(/\./g, "").replace(",", ".");
                    kdv_orani = parseFloat(kdv_orani);
                    let kdv_tutar = $(this).find("td").eq(6).text();
                    kdv_tutar = kdv_tutar.replace(/\./g, "").replace(",", ".");
                    kdv_tutar = parseFloat(kdv_tutar);
                    let iskonto_orani = $(this).find(".iskonto_perakende").val();
                    iskonto_orani = iskonto_orani.replace(/\./g, "").replace(",", ".");
                    iskonto_orani = parseFloat(iskonto_orani);
                    let iskonto_tutari = $(this).find("td").eq(8).text();
                    iskonto_tutari = iskonto_tutari.replace(/\./g, "").replace(",", ".");
                    iskonto_tutari = parseFloat(iskonto_tutari);
                    let ara_toplam = $(this).find("td").eq(9).text();
                    ara_toplam = ara_toplam.replace(/\./g, "").replace(",", ".");
                    ara_toplam = parseFloat(ara_toplam);
                    let genel_toplam = $(this).find("td").eq(10).text();
                    genel_toplam = genel_toplam.replace(/\./g, "").replace(",", ".");
                    genel_toplam = parseFloat(genel_toplam);

                    let newRow = {
                        stok_kodu: stok_kodu,
                        stok_adi: stok_adi,
                        birim: birim,
                        miktar: miktar,
                        birim_fiyat: birim_fiyat,
                        kdv_oran: kdv_orani,
                        kdv_tutar: kdv_tutar,
                        iskonto_oran: iskonto_orani,
                        iskonto_tutar: iskonto_tutari,
                        ara_toplam: ara_toplam,
                        genel_toplam: genel_toplam
                    };

                    arr.push(newRow);
                });
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'mx-3 btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Kasa Kayıt İşlemine Eminmisiniz',
                    text: "Tahsilatı Kasadan Yapacaksınız",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Evet Eminim',
                    cancelButtonText: 'Vazgeç',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'controller/perakende_controller/sql.php?islem=perakende_pos_satisi_olustur',
                            type: "POST",
                            data: {
                                depo_id: depo_id,
                                musteri_adi: musteri_adi,
                                telefon: telefon,
                                e_posta: e_posta,
                                vergi_dairesi: vergi_dairesi,
                                vergi_no: vergi_no,
                                aciklama: aciklama,
                                adres: adres,
                                fatura_no: fatura_no,
                                fatura_tarihi: fatura_tarihi,
                                pos_id: kasa_id,
                                arr: arr
                            },
                            success: function (result) {
                                if (result == 1) {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Perakende Satış Kaydedildi',
                                        'success'
                                    )
                                    $("#pos_cihazlarini_getir_modal").modal("hide");
                                    $("#perakende_satis_ekleme_sayfasi").modal("hide");
                                }
                            }
                        })

                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        Swal.fire(
                            'Uyarı!',
                            'Kasa Tahsilat İşleminden Vazgeçtiniz',
                            'warning'
                        )
                    }
                })
            });

            $.get("controller/perakende_controller/sql.php?islem=pos_cihazlarini_getir", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    table.rows.add(json).draw(false);
                }
            })
        })
    </script>
    <?php
}
if ($islem == "satis_icin_bankalari_getir") {
    ?>
    <div class="modal fade" id="perakende_satis_bankalari_getir"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 30%; max-width: 30%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Banka Listesi
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="banka_liste_cek_senet">
                            <thead>
                            <tr>
                                <th id="click1">Banka Adı</th>
                                <th>Banka Kodu</th>
                                <th>Şube Adı</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#perakende_satis_bankalari_getir").modal("hide");
        })
        $(document).ready(function () {
            $("#perakende_satis_bankalari_getir").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 300);
            var table = $('#banka_liste_cek_senet').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "banka_adi"},
                    {'data': "banka_kodu"},
                    {'data': "sube_adi"},
                ],
                createdRow: function (row) {
                    $(row).addClass("banka_selected");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                    $(row).find('td').eq(2).css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $("body").off("click", ".banka_selected").on("click", ".banka_selected", function () {
                let depo_id = $("#perakende_depoid").val();
                let musteri_adi = $("#musteri_adi").val();
                let telefon = $("#telefon").val();
                let e_posta = $("#e_posta").val();
                let vergi_dairesi = $("#vergi_dairesi").val();
                let fatura_no = $("#fatura_no").val();
                let fatura_tarihi = $("#fatura_tarihi").val();
                let vergi_no = $("#vergi_no").val();
                let aciklama = $("#aciklama").val();
                let adres = $("#adres").val();
                let kasa_id = $(this).attr("data-id");
                var arr = [];
                $(".perakende_listesi").each(function () {
                    let stok_kodu = $(this).find("td").eq(0).text();
                    let stok_adi = $(this).find("td").eq(1).text();
                    let birim = $(this).find("td").eq(2).text();
                    let miktar = $(this).find(".miktar_perakende").val();
                    miktar = miktar.replace(/\./g, "").replace(",", ".");
                    miktar = parseFloat(miktar);
                    let birim_fiyat = $(this).find(".birim_fiyat_perakende").val();
                    birim_fiyat = birim_fiyat.replace(/\./g, "").replace(",", ".");
                    birim_fiyat = parseFloat(birim_fiyat);
                    let kdv_orani = $(this).find(".kdv_perakende").val();
                    kdv_orani = kdv_orani.replace(/\./g, "").replace(",", ".");
                    kdv_orani = parseFloat(kdv_orani);
                    let kdv_tutar = $(this).find("td").eq(6).text();
                    kdv_tutar = kdv_tutar.replace(/\./g, "").replace(",", ".");
                    kdv_tutar = parseFloat(kdv_tutar);
                    let iskonto_orani = $(this).find(".iskonto_perakende").val();
                    iskonto_orani = iskonto_orani.replace(/\./g, "").replace(",", ".");
                    iskonto_orani = parseFloat(iskonto_orani);
                    let iskonto_tutari = $(this).find("td").eq(8).text();
                    iskonto_tutari = iskonto_tutari.replace(/\./g, "").replace(",", ".");
                    iskonto_tutari = parseFloat(iskonto_tutari);
                    let ara_toplam = $(this).find("td").eq(9).text();
                    ara_toplam = ara_toplam.replace(/\./g, "").replace(",", ".");
                    ara_toplam = parseFloat(ara_toplam);
                    let genel_toplam = $(this).find("td").eq(10).text();
                    genel_toplam = genel_toplam.replace(/\./g, "").replace(",", ".");
                    genel_toplam = parseFloat(genel_toplam);

                    let newRow = {
                        stok_kodu: stok_kodu,
                        stok_adi: stok_adi,
                        birim: birim,
                        miktar: miktar,
                        birim_fiyat: birim_fiyat,
                        kdv_oran: kdv_orani,
                        kdv_tutar: kdv_tutar,
                        iskonto_oran: iskonto_orani,
                        iskonto_tutar: iskonto_tutari,
                        ara_toplam: ara_toplam,
                        genel_toplam: genel_toplam
                    };

                    arr.push(newRow);
                });
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'mx-3 btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Kasa Kayıt İşlemine Eminmisiniz',
                    text: "Tahsilatı Kasadan Yapacaksınız",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Evet Eminim',
                    cancelButtonText: 'Vazgeç',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'controller/perakende_controller/sql.php?islem=perakende_banka_satisi_olustur',
                            type: "POST",
                            data: {
                                depo_id: depo_id,
                                musteri_adi: musteri_adi,
                                telefon: telefon,
                                e_posta: e_posta,
                                vergi_dairesi: vergi_dairesi,
                                vergi_no: vergi_no,
                                aciklama: aciklama,
                                adres: adres,
                                fatura_no: fatura_no,
                                fatura_tarihi: fatura_tarihi,
                                banka_id: kasa_id,
                                arr: arr
                            },
                            success: function (result) {
                                if (result == 1) {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Perakende Satış Kaydedildi',
                                        'success'
                                    )
                                    $("#perakende_satis_bankalari_getir").modal("hide");
                                    $("#perakende_satis_ekleme_sayfasi").modal("hide");
                                }
                            }
                        })

                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        Swal.fire(
                            'Uyarı!',
                            'Kasa Tahsilat İşleminden Vazgeçtiniz',
                            'warning'
                        )
                    }
                })
            });

            $.get("controller/banka_controller/sql.php?islem=bankalari_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    table.rows.add(json).draw(false);
                }
            })
        })
    </script>
    <?php
}
if ($islem == "perakende_satis_icin_stoklari_getir") {
    ?>

    <div class="modal fade" data-backdrop="static" id="perakende_satis_icin_stoklar"

         data-bs-keyboard="false" role="dialog">

        <div class="modal-dialog"

             style="width: 30%; max-width: 30%;">

            <div class="modal-content">

                <div class="modal-header text-white p-2">Stok Listesi

                    <button type="button" class="btn-close btn-close-white" id="modal_kapat1"

                            aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <div class="col-md-12 row">

                        <table class="table table-sm table-bordered w-100 display nowrap"

                               style="cursor:pointer;font-size: 13px;"

                               id="fatura_stok_liste">

                            <thead>

                            <tr>

                                <th id="click1_stok">Stok Kodu</th>

                                <th>Stok Adı</th>

                            </tr>

                            </thead>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>

        $(document).ready(function () {

            setTimeout(function () {

                $("#click1_stok").trigger("click");

            }, 300);

            $("#perakende_satis_icin_stoklar").modal("show");


            var stok_table = $('#fatura_stok_liste').DataTable({

                scrollY: '35vh',

                scrollX: true,

                "info": false,

                "paging": false,

                "dom": '<"pull-left"f><"pull-right"l>tip',

                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},

                createdRow: function (row) {

                    $(row).addClass("stock_select");

                }

            })

            $.get("controller/alis_controller/sql.php?islem=stok_listesi_getir", function (result) {

                if (result != 2) {

                    var json = JSON.parse(result);

                    json.forEach(function (item) {

                        var stok_list = stok_table.row.add([item.stok_kodu, item.stok_adi]).draw(false).node();

                        $(stok_list).attr("data-id", item.id);

                        $(stok_list).find('td').eq(0).css('text-align', 'left');

                        $(stok_list).find('td').eq(1).css('text-align', 'left');

                    });

                }

            });

            $("body").off("click", ".stock_select").on("click", ".stock_select", function () {
                let value = $(this).find("td").eq(0).text();
                $.get("controller/perakende_controller/sql.php?islem=girilen_stok_bilgileri_getir_sql", {value: value}, function (response) {
                    if (response != 2) {
                        var item = JSON.parse(response);
                        let birim_fiyat = item.satis_fiyat;
                        birim_fiyat = parseFloat(birim_fiyat);
                        birim_fiyat = birim_fiyat.toLocaleString("tr-TR", {
                            maximumFractionDigits: 2,
                            minimumFractionDigits: 2
                        });
                        var rowCount = perakende_table.rows().count();
                        rowCount = rowCount + 1;
                        let kdv = item.kdv_orani;
                        kdv = parseFloat(kdv);
                        kdv = kdv.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        perakende_table.row.add([item.stok_kodu, item.stok_adi, item.birim_adi, "<input type='text' data-id='" + rowCount + "' class='form-control form-control-sm col-9 miktar_perakende' value='0,00'/>", "<input type='text' data-id='" + rowCount + "' class='form-control form-control-sm col-9 birim_fiyat_perakende' value='" + birim_fiyat + "'/>", "<input type='text' data-id='" + rowCount + "' class='form-control form-control-sm col-9 kdv_perakende' value='" + kdv + "'/>", "0,00", "<input type='text' class='form-control form-control-sm col-9 iskonto_perakende' data-id='" + rowCount + "' value='0,00'/>", "0,00", "0,00", "0,00", "<button class='btn btn-danger btn-sm perakende_iptal_et_list_main_button'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                        $("#stok_barkod_perakende").val("");
                        $("#perakende_satis_icin_stoklar").modal("hide");
                    }
                })
            });
        });

        $("body").off("click", "#modal_kapat1").on("click", "#modal_kapat1", function () {
            $("#perakende_satis_icin_stoklar").modal("hide");
        });

    </script>
    <?php
}