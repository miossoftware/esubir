<?php

$islem = $_GET["islem"];

if ($islem == "sanayi_fisi_girisi_modal_getir") {
    ?>
    <style>
        #binek_sanayi_fisleri_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="binek_sanayi_fisleri_modal" data-bs-keyboard="false" data-backdrop="static"
         role="dialog">
        <div class="modal-dialog" style="width: 75%; max-width: 75%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="ozmal_sanayi_vazgec"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>SANAYİ FİŞİ GİRİŞİ
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="plakalari_getir_div"></div>
                            <div class="carileri_getir_div"></div>
                            <div class="col-12 row">
                                <div class="ibox-title"
                                     style="background-color: #9DB2BF;color: white;text-align: center">
                                    <span>Fiş Bilgileri</span>
                                </div>
                                <div class="mt-4"></div>
                                <div class="col-12 row">
                                    <div class="col-6">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label>Cari Kodu</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm"
                                                           id="cari_kodu">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-warning btn-sm" id="cari_kodu_button"><i
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
                                                <input type="text" id="cari_adi" class="form-control form-control-sm"
                                                       disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label>Adres</label>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" id="cari_adres" class="form-control form-control-sm"
                                                       disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label>Vergi Dairesi</label>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" id="vergi_dairesi"
                                                       class="form-control form-control-sm" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label>Vergi No</label>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" id="vergi_no" class="form-control form-control-sm"
                                                       disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label>Fiş No</label>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control form-control-sm" id="fis_no">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label>Tarih</label>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="date" value="<?= date("Y-m-d") ?>" id="tarih"
                                                       class="form-control form-control-sm">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label>Açıklama</label>
                                            </div>
                                            <div class="col-md-7">
                                                <textarea class="form-control form-control-sm" id="sanayi_aciklama"
                                                          rows="6"
                                                          style="resize: none"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row mt-2 no-gutters">
                                <div class="ibox-title"
                                     style="background-color: #9DB2BF;color: white;text-align: center">
                                    <span>Ürün Bilgileri</span>
                                </div>
                                <div class="mt-2"></div>
                                <div class="col-md-1">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;Plaka</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="plaka_no_input"
                                               placeholder="Plaka No">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm" id="plaka_button"><i
                                                    class="fa fa-ellipsis-h"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;Plaka
                                        Cari</label>
                                    <input type="text" disabled class="form-control form-control-sm" id="plaka_cari"
                                           placeholder="Plaka Cari">
                                </div>
                                <div class="col-md-1 ">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;Servis
                                        Tipi</label>
                                    <select class="custom-select custom-select-sm" id="servis_tipi">
                                        <option value="">Servis Tipi Seç...</option>
                                        <option value="Akü">Akü</option>
                                        <option value="Lastik Tamiri">Lastik Tamiri</option>
                                        <option value="İşçilik">İşçilik</option>
                                        <option value="Boya/Kaporta">Boya/Kaporta</option>
                                        <option value="Elektrik Malzemeleri">Elektrik Malzemeleri</option>
                                        <option value="Fren Malzemeleri">Fren Malzemeleri</option>
                                        <option value="Motor">Motor</option>
                                        <option value="Periyodik Bakım">Periyodik Bakım</option>
                                        <option value="Root Balans">Root Balans</option>
                                        <option value="Şanzuman">Şanzuman</option>
                                        <option value="Yağ">Yağ</option>
                                        <option value="Diğer">Diğer</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;Miktar</label>
                                    <input style="text-align: right" type="text"
                                           class="form-control form-control-sm mx-2"
                                           placeholder="Miktar" id="sanayi_miktar" value="0,00">
                                </div>
                                <div class="col-md-1">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Birim</label>
                                    <select class="custom-select custom-select-sm mx-1" id="birim_id">
                                        <option value="">Birim</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Birim
                                        Fiyat</label>
                                    <input type="text" style="text-align: right"
                                           class="form-control form-control-sm mx-2 "
                                           placeholder="Birim Fiyat" id="sanayi_birim_fiyat" value="0,00">
                                </div>
                                <div class="col-md-1">
                                    <label style="font-size: 10px; font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kdv(%)</label>
                                    <input type="text" placeholder="KDV(%)" style="text-align: right"
                                           class="form-control form-control-sm mx-3" value="0,00" kdv_tutar="0,00"
                                           id="kdv_sanayi">
                                </div>
                                <div class="col-md-1">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;İskonto(%)</label>
                                    <input type="text" placeholder="İskonto(%)" style="text-align: right"
                                           class="form-control form-control-sm mx-4" iskonto_tutar="0,00" value="0,00"
                                           id="sanayi_iskonto_yuzde">
                                </div>
                                <div class="col-md-1">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Toplam
                                    </label>
                                    <input type="text" placeholder="Toplam" disabled style="text-align: right"
                                           class="form-control form-control-sm mx-4" value="0,00" id="toplam_tutar">
                                </div>
                                <div class="col-md-2 mx-4">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;Açıklama</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="aciklama"
                                               placeholder="Açıklama">
                                        <div class="input-group-append">
                                            <button style="width: 100% !important;"
                                                    class="btn btn-success btn-sm" id="yeni_sanayi_fisi_ekle"><i
                                                    class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!--                                    <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Açıklama-->
                                    <!--                                    </label>-->
                                    <!--                                    <input type="text" placeholder="Açıklama"-->
                                    <!--                                           class="form-control form-control-sm mx-4" id="aciklama">-->
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <table class="table table-sm table-bordered w-100 display nowrap" id="banka_listesi"
                                       style="font-size: 13px;">
                                    <thead>
                                    <tr>
                                        <th id="servis_fisi">Plaka</th>
                                        <th>Plaka Cari</th>
                                        <th>Servis Tipi</th>
                                        <th>Miktar</th>
                                        <th>Birim</th>
                                        <th>Birim Fiyat</th>
                                        <th>KDV (%)</th>
                                        <th>KDV Tutar</th>
                                        <th>İskonto (%)</th>
                                        <th>İskonto Tutar</th>
                                        <th>Ara Toplam</th>
                                        <th>Toplam</th>
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
                                                    <th>Ara Toplam</th>
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
                                                    <td class="sanayi_ara_toplam_bas" style="text-align: right">0,00
                                                        TL
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="sanayi_kdv_toplam_bas" style="text-align: right">0,00
                                                        TL
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="sanayi_iskonto_toplam_bas" style="text-align: right">0,00
                                                        TL
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="sanayi_genel_toplam_bas" style="text-align: right">0,00
                                                        TL
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="ozmal_sanayi_vazgec"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="sanayi_fisi_kaydet"><i class="fa fa-check"></i>
                                Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("input").click(function () {
            $(this).select();
        });

        $("body").off("click", "#plaka_button").on("click", "#plaka_button", function () {
            $.get("modals/arac_modal/yakit_alim_modal.php?islem=irsaliye_plakalari_getir", function (getModal) {
                $(".plakalari_getir_div").html("");
                $(".plakalari_getir_div").html(getModal);
            })
        });

        $("body").off("click", "#cari_kodu_button").on("click", "#cari_kodu_button", function () {
            $.get("konteyner/modals/sanayi_modal/ozmal_sanayi.php?islem=carileri_getir", function (getModal) {
                $(".carileri_getir_div").html("");
                $(".carileri_getir_div").html(getModal);
            })
        });

        $("body").off("keyup", "#plaka_no_input").on("keyup", "#plaka_no_input", function () {
            let val = $(this).val();
            $.get("controller/arac_controller/sql.php?islem=arac_bilgilerini_getir_sql", {plaka_no: val}, function (response) {
                if (response != 2) {
                    var item = JSON.parse(response);
                    $("#plaka_no_input").val(item.arac_plaka);
                    $("#plaka_no_input").attr("data-id", item.id);
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'Plaka Bulundu'
                    });
                } else {
                    $("#plaka_cari").val("");
                    $("#plaka_no_input").attr("data-id", "");
                }
            })
        });

        var oz_mal_servis_fisi = "";

        $("body").off("focusout", "#sanayi_miktar").on("focusout", "#sanayi_miktar", function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }

            let birim_fiyat = $("#sanayi_birim_fiyat").val();
            birim_fiyat = birim_fiyat.replace(/\./g, "").replace(",", ".");
            birim_fiyat = parseFloat(birim_fiyat);

            let kdv_yuzde = $("#kdv_sanayi").val();
            kdv_yuzde = kdv_yuzde.replace(/\./g, "").replace(",", ".");
            kdv_yuzde = parseFloat(kdv_yuzde);
            kdv_yuzde = kdv_yuzde / 100;

            let iskonto_yuzde = $("#sanayi_iskonto_yuzde").val();
            iskonto_yuzde = iskonto_yuzde.replace(/\./g, "").replace(",", ".");
            iskonto_yuzde = parseFloat(iskonto_yuzde);
            iskonto_yuzde = iskonto_yuzde / 100;

            let tutar = birim_fiyat * val;
            let iskonto_tutar = tutar * iskonto_yuzde;
            if (isNaN(iskonto_tutar)) {
                iskonto_tutar = 0
            }
            $("#sanayi_iskonto_yuzde").attr("iskonto_tutar", iskonto_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            tutar = tutar - iskonto_tutar;
            let kdv_tutar = tutar * kdv_yuzde;
            if (isNaN(kdv_tutar)) {
                kdv_tutar = 0
            }
            $("#kdv_sanayi").attr("kdv_tutar", kdv_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            tutar = tutar + kdv_tutar;
            if (isNaN(tutar)) {
                tutar = 0;
            }
            $("#toplam_tutar").val(tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}))


            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})
            $(this).val(val);
        });

        $("body").off("click", "#sanayi_fisi_kaydet").on("click", "#sanayi_fisi_kaydet", function () {
            let cari_id = $("#cari_kodu").attr("data-id");
            let fis_no = $("#fis_no").val();
            let tarih = $("#tarih").val();
            let aciklama = $("#sanayi_aciklama").val();
            var gidecek_arr = [];


            var rowCount = oz_mal_servis_fisi.rows().count();
            if (rowCount == 0) {
                Swal.fire(
                    "Uyarı!",
                    'Herhangi Bir Fiş Girişi Yapmadınız',
                    "warning"
                );
            } else if (cari_id == undefined || cari_id == "") {
                Swal.fire(
                    "Uyarı!",
                    'Lütfen Bir Cari Seçiniz...',
                    "warning"
                );
            } else {
                $(".eklenen_sanayiler").each(function () {
                    let plaka_id = $(this).attr("data-id");
                    let birim_id = $(this).attr("birim_id");
                    let servis_tipi = $(this).find("td").eq(2).text();
                    let miktar = $(this).find("td").eq(3).text();
                    miktar = miktar.replace(/\./g, "").replace(",", ".");
                    miktar = parseFloat(miktar);
                    let birim_fiyat = $(this).find("td").eq(5).text();
                    birim_fiyat = birim_fiyat.replace(/\./g, "").replace(",", ".");
                    birim_fiyat = parseFloat(birim_fiyat);
                    let kdv_yuzde = $(this).find("td").eq(6).text();
                    kdv_yuzde = kdv_yuzde.replace(/\./g, "").replace(",", ".");
                    kdv_yuzde = parseFloat(kdv_yuzde);
                    let kdv_tutar = $(this).find("td").eq(7).text();
                    kdv_tutar = kdv_tutar.replace(/\./g, "").replace(",", ".");
                    kdv_tutar = parseFloat(kdv_tutar);
                    let iskonto_yuzde = $(this).find("td").eq(8).text();
                    iskonto_yuzde = iskonto_yuzde.replace(/\./g, "").replace(",", ".");
                    iskonto_yuzde = parseFloat(iskonto_yuzde);
                    let iskonto_tutar = $(this).find("td").eq(9).text();
                    iskonto_tutar = iskonto_tutar.replace(/\./g, "").replace(",", ".");
                    iskonto_tutar = parseFloat(iskonto_tutar);
                    let ara_toplam = $(this).find("td").eq(10).text();
                    ara_toplam = ara_toplam.replace(/\./g, "").replace(",", ".");
                    ara_toplam = parseFloat(ara_toplam);
                    let genel_toplam = $(this).find("td").eq(11).text();
                    genel_toplam = genel_toplam.replace(/\./g, "").replace(",", ".");
                    genel_toplam = parseFloat(genel_toplam);
                    let aciklama_urun = $(this).find("td").eq(12).text();

                    let newRow = {
                        plaka_id: plaka_id,
                        birim_id: birim_id,
                        servis_tipi: servis_tipi,
                        miktar: miktar,
                        birim_fiyat: birim_fiyat,
                        kdv_yuzde: kdv_yuzde,
                        kdv_tutar: kdv_tutar,
                        iskonto_tutar: iskonto_tutar,
                        iskonto_yuzde: iskonto_yuzde,
                        ara_toplam: ara_toplam,
                        genel_toplam: genel_toplam,
                        aciklama: aciklama_urun
                    };
                    gidecek_arr.push(newRow);
                });

                $.ajax({
                    url: "controller/arac_controller/sql.php?islem=sanayi_fisi_kaydet_sql",
                    type: "POST",
                    data: {
                        cari_id: cari_id,
                        fis_no: fis_no,
                        tarih: tarih,
                        aciklama: aciklama,
                        gidecek_arr: gidecek_arr
                    },
                    success: function (response) {
                        if (response == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Sanayi Fişi Kaydedildi",
                                "success"
                            );
                            $("#binek_sanayi_fisleri_modal").modal("hide");
                            $.get("view/binek_sanayi_fisleri.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("view/binek_sanayi_fisleri.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                        } else {
                            Swal.fire(
                                "Oops...",
                                "Bilinmeyen Bir Hata Oluştu",
                                "error"
                            );

                            $("#binek_sanayi_fisleri_modal").modal("hide");
                        }
                    }
                });

            }
        });


        $("body").off("focusout", "#sanayi_iskonto_yuzde").on("focusout", "#sanayi_iskonto_yuzde", function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }


            let birim_fiyat = $("#sanayi_birim_fiyat").val();
            birim_fiyat = birim_fiyat.replace(/\./g, "").replace(",", ".");
            birim_fiyat = parseFloat(birim_fiyat);
            let miktar = $("#sanayi_miktar").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);

            let kdv_yuzde = $("#kdv_sanayi").val();
            kdv_yuzde = kdv_yuzde.replace(/\./g, "").replace(",", ".");
            kdv_yuzde = parseFloat(kdv_yuzde);
            kdv_yuzde = kdv_yuzde / 100;

            let iskonto_yuzde = $("#sanayi_iskonto_yuzde").val();
            iskonto_yuzde = iskonto_yuzde.replace(/\./g, "").replace(",", ".");
            iskonto_yuzde = parseFloat(iskonto_yuzde);
            iskonto_yuzde = iskonto_yuzde / 100;

            let tutar = birim_fiyat * miktar;
            let iskonto_tutar = tutar * iskonto_yuzde;
            if (isNaN(iskonto_tutar)) {
                iskonto_tutar = 0
            }
            $("#sanayi_iskonto_yuzde").attr("iskonto_tutar", iskonto_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            tutar = tutar - iskonto_tutar;
            let kdv_tutar = tutar * kdv_yuzde;
            if (isNaN(kdv_tutar)) {
                kdv_tutar = 0
            }
            $("#kdv_sanayi").attr("kdv_tutar", kdv_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));

            tutar = tutar + kdv_tutar;
            if (isNaN(tutar)) {
                tutar = 0;
            }
            $("#toplam_tutar").val(tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}))

            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})
            $(this).val(val);
        });
        $("body").off("focusout", "#kdv_sanayi").on("focusout", "#kdv_sanayi", function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }


            let birim_fiyat = $("#sanayi_birim_fiyat").val();
            birim_fiyat = birim_fiyat.replace(/\./g, "").replace(",", ".");
            birim_fiyat = parseFloat(birim_fiyat);
            let miktar = $("#sanayi_miktar").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);

            let kdv_yuzde = $("#kdv_sanayi").val();
            kdv_yuzde = kdv_yuzde.replace(/\./g, "").replace(",", ".");
            kdv_yuzde = parseFloat(kdv_yuzde);
            kdv_yuzde = kdv_yuzde / 100;

            let iskonto_yuzde = $("#sanayi_iskonto_yuzde").val();
            iskonto_yuzde = iskonto_yuzde.replace(/\./g, "").replace(",", ".");
            iskonto_yuzde = parseFloat(iskonto_yuzde);
            iskonto_yuzde = iskonto_yuzde / 100;

            let tutar = birim_fiyat * miktar;
            let iskonto_tutar = tutar * iskonto_yuzde;
            if (isNaN(iskonto_tutar)) {
                iskonto_tutar = 0
            }
            $("#sanayi_iskonto_yuzde").attr("iskonto_tutar", iskonto_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            tutar = tutar - iskonto_tutar;
            let kdv_tutar = tutar * kdv_yuzde;
            if (isNaN(kdv_tutar)) {
                kdv_tutar = 0
            }
            $("#kdv_sanayi").attr("kdv_tutar", kdv_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            tutar = tutar + kdv_tutar;
            if (isNaN(tutar)) {
                tutar = 0;
            }
            $("#toplam_tutar").val(tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}))

            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})
            $(this).val(val);
        });
        $("body").off("focusout", "#sanayi_birim_fiyat").on("focusout", "#sanayi_birim_fiyat", function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }

            let miktar = $("#sanayi_miktar").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);

            let kdv_yuzde = $("#kdv_sanayi").val();
            kdv_yuzde = kdv_yuzde.replace(/\./g, "").replace(",", ".");
            kdv_yuzde = parseFloat(kdv_yuzde);
            kdv_yuzde = kdv_yuzde / 100;

            let iskonto_yuzde = $("#sanayi_iskonto_yuzde").val();
            iskonto_yuzde = iskonto_yuzde.replace(/\./g, "").replace(",", ".");
            iskonto_yuzde = parseFloat(iskonto_yuzde);
            iskonto_yuzde = iskonto_yuzde / 100;

            let tutar = miktar * val;
            let iskonto_tutar = tutar * iskonto_yuzde;
            if (isNaN(iskonto_tutar)) {
                iskonto_tutar = 0
            }
            $("#sanayi_iskonto_yuzde").attr("iskonto_tutar", iskonto_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            tutar = tutar - iskonto_tutar;
            let kdv_tutar = tutar * kdv_yuzde;
            if (isNaN(kdv_tutar)) {
                kdv_tutar = 0
            }
            $("#kdv_sanayi").attr("kdv_tutar", kdv_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            }));
            tutar = tutar + kdv_tutar;
            if (isNaN(tutar)) {
                tutar = 0;
            }
            $("#toplam_tutar").val(tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}))


            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})
            $(this).val(val);
        });

        $("body").off("click", "#yeni_sanayi_fisi_ekle").on("click", "#yeni_sanayi_fisi_ekle", function () {
            let plaka_adi = $("#plaka_no_input").val();
            let plaka_cari = $("#plaka_cari").val();
            let servis_tipi = $("#servis_tipi").val();
            let miktar = $("#sanayi_miktar").val();
            let miktar2 = miktar.replace(/\./g, "").replace(",", ".");
            miktar2 = parseFloat(miktar2);
            let birim_id = $("#birim_id option:selected").attr("data-id");
            let birim_adi = $("#birim_id").val();

            let birim_fiyat = $("#sanayi_birim_fiyat").val();
            let birim_fiyat2 = birim_fiyat.replace(/\./g, "").replace(",", ".");
            birim_fiyat2 = parseFloat(birim_fiyat2);
            let toplam_tutar = $("#toplam_tutar").val();
            let plaka_id = $("#plaka_no_input").attr("data-id");
            let kdv_tutar = $("#kdv_sanayi").attr("kdv_tutar");
            let kdv_yuzde = $("#kdv_sanayi").val();
            let iskonto_tutar = $("#sanayi_iskonto_yuzde").attr("iskonto_tutar");
            let iskonto_yuzde = $("#sanayi_iskonto_yuzde").val();
            let ara_toplam = birim_fiyat2 * miktar2;
            let aciklama = $("#aciklama").val();
            ara_toplam = ara_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
            if (plaka_id == undefined || plaka_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Plaka Seçiniz...",
                    "warning"
                );
            } else if (birim_id == undefined || birim_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Birim Seçiniz...",
                    "warning"
                );
            } else if (servis_tipi == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Servis Tipi Seçiniz...",
                    "warning"
                );
            } else {
                let table = oz_mal_servis_fisi.row.add([plaka_adi, plaka_cari, servis_tipi, miktar, birim_adi, birim_fiyat, kdv_yuzde, kdv_tutar, iskonto_yuzde, iskonto_tutar, ara_toplam, toplam_tutar, aciklama, "<button class='btn btn-danger btn-sm sanayi_fisi_eksilt_list_button'><i class='fa fa-trash'></i></button>"]).draw(false).node()
                $(table).attr("data-id", plaka_id);
                $(table).attr("birim_id", birim_id);
                var ara_toplam_total = 0;
                var genel_toplam_total = 0;
                var kdv_toplam_total = 0;
                var iskonto_toplam_total = 0;

                $(".eklenen_sanayiler").each(function () {
                    let ara_toplam_list = $(this).find("td").eq(10).text();
                    ara_toplam_list = ara_toplam_list.replace(/\./g, "").replace(",", ".");
                    ara_toplam_list = parseFloat(ara_toplam_list);
                    ara_toplam_total += ara_toplam_list;

                    let kdv_toplam_list = $(this).find("td").eq(7).text();
                    kdv_toplam_list = kdv_toplam_list.replace(/\./g, "").replace(",", ".");
                    kdv_toplam_list = parseFloat(kdv_toplam_list);
                    kdv_toplam_total += kdv_toplam_list;

                    let iskonto_toplam_list = $(this).find("td").eq(9).text();
                    iskonto_toplam_list = iskonto_toplam_list.replace(/\./g, "").replace(",", ".");
                    iskonto_toplam_list = parseFloat(iskonto_toplam_list);
                    iskonto_toplam_total += iskonto_toplam_list;

                    let genel_toplam_list = $(this).find("td").eq(11).text();
                    genel_toplam_list = genel_toplam_list.replace(/\./g, "").replace(",", ".");
                    genel_toplam_list = parseFloat(genel_toplam_list);
                    genel_toplam_total += genel_toplam_list;

                    $(".sanayi_ara_toplam_bas").html("");
                    $(".sanayi_ara_toplam_bas").html(ara_toplam_total.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }) + " TL");
                    $(".sanayi_kdv_toplam_bas").html("");
                    $(".sanayi_kdv_toplam_bas").html(kdv_toplam_total.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }) + " TL");
                    $(".sanayi_iskonto_toplam_bas").html("");
                    $(".sanayi_iskonto_toplam_bas").html(iskonto_toplam_total.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }) + " TL");
                    $(".sanayi_genel_toplam_bas").html("");
                    $(".sanayi_genel_toplam_bas").html(genel_toplam_total.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }) + " TL");

                });

                $("#plaka_no_input").val("");
                $("#plaka_cari").val("");
                $("#servis_tipi").val("");
                $("#kdv_sanayi").attr("kdv_tutar", "0,00");
                $("#kdv_sanayi").val("0,00");
                $("#sanayi_iskonto_yuzde").attr("ískonto_tutar", "0,00");
                $("#sanayi_iskonto_yuzde").val("0,00");
                $("#sanayi_miktar").val("0,00");
                $("#birim_id").val("");
                $("#sanayi_birim_fiyat").val("0,00");
                $("#toplam_tutar").val("0,00");
                $("#plaka_no_input").attr("data-id", "");
                $("#kdv_sanayi").attr("kdv_tutar", "0,00");
                $("#sanayi_iskonto_yuzde").attr("iskonto_tutar", "0,00");
            }


        });

        $("body").off("click", ".sanayi_fisi_eksilt_list_button").on("click", ".sanayi_fisi_eksilt_list_button", function () {
            var row = $(this).closest('tr');
            oz_mal_servis_fisi.row(row).remove().draw(false);

            var ara_toplam_total = 0
            var genel_toplam_total = 0
            var kdv_toplam_total = 0
            var iskonto_toplam_total = 0
            var rowCount = oz_mal_servis_fisi.rows().count();

            if (rowCount == 0) {
                $(".sanayi_ara_toplam_bas").html("");
                $(".sanayi_ara_toplam_bas").html("0,00 TL");
                $(".sanayi_kdv_toplam_bas").html("");
                $(".sanayi_kdv_toplam_bas").html("0,00 TL");
                $(".sanayi_iskonto_toplam_bas").html("");
                $(".sanayi_iskonto_toplam_bas").html("0,00 TL");
                $(".sanayi_genel_toplam_bas").html("");
                $(".sanayi_genel_toplam_bas").html("0,00 TL");

            }

            $(".eklenen_sanayiler").each(function () {
                let ara_toplam_list = $(this).find("td").eq(10).text();
                ara_toplam_list = ara_toplam_list.replace(/\./g, "").replace(",", ".");
                ara_toplam_list = parseFloat(ara_toplam_list);
                ara_toplam_total += ara_toplam_list;

                let kdv_toplam_list = $(this).find("td").eq(7).text();
                kdv_toplam_list = kdv_toplam_list.replace(/\./g, "").replace(",", ".");
                kdv_toplam_list = parseFloat(kdv_toplam_list);
                kdv_toplam_total += kdv_toplam_list;

                let iskonto_toplam_list = $(this).find("td").eq(9).text();
                iskonto_toplam_list = iskonto_toplam_list.replace(/\./g, "").replace(",", ".");
                iskonto_toplam_list = parseFloat(iskonto_toplam_list);
                iskonto_toplam_total += iskonto_toplam_list;

                let genel_toplam_list = $(this).find("td").eq(11).text();
                genel_toplam_list = genel_toplam_list.replace(/\./g, "").replace(",", ".");
                genel_toplam_list = parseFloat(genel_toplam_list);
                genel_toplam_total += genel_toplam_list;

                $(".sanayi_ara_toplam_bas").html("");
                $(".sanayi_ara_toplam_bas").html(ara_toplam_total.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }) + " TL");
                $(".sanayi_kdv_toplam_bas").html("");
                $(".sanayi_kdv_toplam_bas").html(kdv_toplam_total.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }) + " TL");
                $(".sanayi_iskonto_toplam_bas").html("");
                $(".sanayi_iskonto_toplam_bas").html(iskonto_toplam_total.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }) + " TL");
                $(".sanayi_genel_toplam_bas").html("");
                $(".sanayi_genel_toplam_bas").html(genel_toplam_total.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }) + " TL");

            });
        });

        $(document).ready(function () {
            $("#binek_sanayi_fisleri_modal").modal("show");

            setTimeout(function () {
                $("#servis_fisi").trigger("click");
            }, 500);

            $.get("controller/alis_controller/sql.php?islem=birimleri_getir", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        var birimAdi = item.birim_adi;
                        $("#birim_id").append("" +
                            "<option data-id='" + item.id + "' value='" + birimAdi + "'>" + birimAdi + "</option>" +
                            "");
                    })
                }
            });

            $("body").off("keyup", "#cari_kodu").on("keyup", "#cari_kodu", function () {
                let val = $(this).val();
                $.get("konteyner/controller/sanayi_controller/sql.php?islem=cari_kodu_bilgilerini_getir", {cari_kodu: val}, function (response) {
                    if (response != 2) {
                        var item = JSON.parse(response);
                        $("#cari_kodu").val(item.cari_kodu);
                        $("#cari_kodu").attr("data-id", item.id);
                        $("#cari_adi").val((item.cari_adi).toUpperCase());
                        $("#cari_adres").val(item.adres);
                        $("#vergi_dairesi").val(item.vergi_dairesi);
                        $("#vergi_no").val(item.vergi_no);
                    } else {
                        $("#cari_kodu").attr("data-id", "");
                        $("#cari_adi").val("");
                        $("#cari_adres").val("");
                        $("#vergi_dairesi").val("");
                        $("#vergi_no").val("");
                    }
                })
            });

            oz_mal_servis_fisi = $('#banka_listesi').DataTable({
                scrollY: '30vh',
                scrollX: true,
                "info": false,
                "paging": false,
                createdRow: function (row) {
                    $(row).find("td").css("text-transform", "uppercase")
                    $(row).addClass("eklenen_sanayiler")
                    $(row).find("td").eq(0).css("text-align", "left");
                    $(row).find("td").eq(1).css("text-align", "left");
                },
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            })
        });

        $("body").off("click", "#ozmal_sanayi_vazgec").on("click", "#ozmal_sanayi_vazgec", function () {
            $("#binek_sanayi_fisleri_modal").modal("hide");
        });

    </script>
    <?php
}