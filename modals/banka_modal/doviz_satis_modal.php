<?php

$islem = $_GET["islem"];

if ($islem == "yeni_doviz_satis_yap_modal") {
    ?>
    <div class="modal fade" id="doviz_satim_yap_main_modal" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 50%; max-width: 50%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="banka_acilis_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>DÖVİZ SATIM</div>
                        </div>
                        <div class="modal-body">
                            <div class="havale_giris_cari_listesi_div"></div>
                            <div class="col-12 row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Tarih</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" class="form-control form-control-sm" id="tarih"
                                                   value="<?= date("Y-m-d") ?>">
                                        </div>
                                    </div>
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
                                            <label>Döviz Hesabı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="doviz_hesaplari">
                                                <option value="">Bir Döviz Hesabı Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>TL Hesabı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="tl_hesaplari_satim">
                                                <option value="">Bir TL Hesabı Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Döviz Türü</label>
                                        </div>
                                        <div class="col-md-7 no-gutters row">
                                            <div class="col">
                                                <select class="custom-select custom-select-sm" id="doviz_turu" disabled>
                                                    <option value="">Bir Döviz Türü Seçiniz...</option>
                                                    <option id="usd_bas_irsaliye" value="USD">USD</option>
                                                    <option id="eur_bas_irsaliye" value="EURO">EURO</option>
                                                    <option id="gbp_bas_irsaliye" value="GBP">GBP</option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control form-control-sm"
                                                       placeholder="Döviz Kuru Giriniz..." id="doviz_kuru_irsaliye">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Döviz Miktarı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" value="0,00" class="form-control form-control-sm"
                                                   id="doviz_miktari">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>TL Tutarı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="tl_tutari" value="0,00"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Masraf Tutarı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" value="0,00" class="form-control form-control-sm"
                                                   id="masraf_tutari">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Masraf Carisi</label>
                                        </div>
                                        <div class="col-md-7 row no-gutters">
                                            <div class="col">
                                                <select class="custom-select custom-select-sm" id="dusulecek_hesap">
                                                    <option value="">Düşülecek Hesap</option>
                                                    <option value="TL Hesabı">TL Hesabı</option>
                                                    <option value="Döviz Hesabı">Döviz Hesabı</option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <div class="input-group">
                                                    <input type="text" placeholder="Masraf Carisi"
                                                           class="form-control form-control-sm" id="masraf_cari">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-warning btn-sm"
                                                                id="masraf_carilerini_getir_button">
                                                            <i class="fa fa-ellipsis-h"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="banka_acilis_vazgec"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="doviz_satim_kaydet"><i class="fa fa-check"></i>
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
        })

        $(document).ready(function () {
            $("#doviz_satim_yap_main_modal").modal("show");

            $.get("controller/banka_controller/sql.php?islem=doviz_hesaplari_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#doviz_hesaplari").append("" +
                            "<option doviz_tipi='" + item.doviz_tipi + "' value='" + item.id + "'>" + item.hesap_adi + "</option>" +
                            "");
                    });
                }
            })

            $.get("controller/alis_controller/sql.php?islem=guncel_kurlar", function (result) {

                var item = JSON.parse(result);
                var usd = item.USD[0];

                var eur = item.EUR[0];

                var gbp = item.GBP[0];
                $("#usd_bas_irsaliye").attr("usd", usd);
                $("#eur_bas_irsaliye").attr("eur", eur);
                $("#gbp_bas_irsaliye").attr("gbp", gbp);

            });

        });

        $("body").off("click", "#masraf_carilerini_getir_button").on("click", "#masraf_carilerini_getir_button", function () {
            $.get("modals/banka_modal/havale_giris_modal.php?islem=cari_listesi_getir_modal", function (getModal) {
                $(".havale_giris_cari_listesi_div").html("");
                $(".havale_giris_cari_listesi_div").html(getModal);
            })
        });

        $("body").off("click", "#doviz_satim_kaydet").on("click", "#doviz_satim_kaydet", function () {
            let fis_no = $("#fis_no").val();
            let tarih = $("#tarih").val();
            let tl_hesaplari = $("#tl_hesaplari_satim").val();
            let doviz_hesaplari = $("#doviz_hesaplari").val();
            let doviz_turu = $("#doviz_turu").val();
            let doviz_kuru_irsaliye = $("#doviz_kuru_irsaliye").val();
            doviz_kuru_irsaliye = doviz_kuru_irsaliye.replace(/\./g, "").replace(",", ".");
            doviz_kuru_irsaliye = parseFloat(doviz_kuru_irsaliye);
            let doviz_miktari = $("#doviz_miktari").val();
            doviz_miktari = doviz_miktari.replace(/\./g, "").replace(",", ".");
            doviz_miktari = parseFloat(doviz_miktari);
            let tl_tutari = $("#tl_tutari").val();
            tl_tutari = tl_tutari.replace(/\./g, "").replace(",", ".");
            tl_tutari = parseFloat(tl_tutari);
            let masraf_tutari = $("#masraf_tutari").val();
            masraf_tutari = masraf_tutari.replace(/\./g, "").replace(",", ".");
            masraf_tutari = parseFloat(masraf_tutari);
            let dusulecek_hesap = $("#dusulecek_hesap").val();
            let cari_id = $("#masraf_cari").attr("data-id");

            if (tl_hesaplari == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir TL Hesabı Seçiniz...",
                    "warning"
                )
            } else if (doviz_hesaplari == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir Döviz Hesabı Seçiniz...",
                    "warning"
                )
            } else if (doviz_turu == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir Döviz Türü Seçiniz...",
                    "warning"
                )
            } else if (doviz_kuru_irsaliye == "" || doviz_kuru_irsaliye == 0) {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Döviz Kuru Giriniz...",
                    "warning"
                )
            } else if (doviz_miktari == "" || doviz_miktari == 0) {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Alınacak Döviz Miktarı Giriniz...",
                    "warning"
                )
            } else if (tl_tutari == "" || tl_tutari == 0) {
                Swal.fire(
                    "Uyarı",
                    "TL Tutarı 0 Olamaz",
                    "warning"
                )
            } else {
                $.ajax({
                    url: "controller/banka_controller/sql.php?islem=doviz_satim_kaydet_sql",
                    type: "POST",
                    data: {
                        fis_no: fis_no,
                        tl_hesap: tl_hesaplari,
                        doviz_hesap: doviz_hesaplari,
                        tarih: tarih,
                        doviz_turu: doviz_turu,
                        doviz_kuru: doviz_kuru_irsaliye,
                        doviz_miktari: doviz_miktari,
                        tl_tutar: tl_tutari,
                        masraf_tutari: masraf_tutari,
                        dusulecek_hesap: dusulecek_hesap,
                        cari_id: cari_id
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Döviz Satım Başarılı",
                                "success"
                            )
                            $("#doviz_satim_yap_main_modal").modal("hide");
                            $.get("view/doviz_satim.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("view/doviz_satim.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                })
            }
        });

        $("body").off("focusout", "#doviz_miktari").on("focusout", "#doviz_miktari", function () {
            let miktar = $(this).val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            if (isNaN(miktar)) {
                miktar = 0;
            }
            let doviz_kur = $("#doviz_kuru_irsaliye").val();
            doviz_kur = doviz_kur.replace(",", ".");
            doviz_kur = parseFloat(doviz_kur);
            if (isNaN(doviz_kur)) {
                doviz_kur = 0;
            }
            let tl_tutari = doviz_kur * miktar;
            $("#tl_tutari").val(tl_tutari.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
            $(this).val(miktar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });
        $("body").off("focusout", "#masraf_tutari").on("focusout", "#masraf_tutari", function () {
            let miktar = $(this).val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            if (isNaN(miktar)) {
                miktar = 0;
            }
            $(this).val(miktar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("change", "#doviz_turu").on("change", "#doviz_turu", function () {
            var value = $(this).val();
            if (value == "TL") {
                $("#doviz_kuru_irsaliye").val("1.00");
            } else if (value == "EURO") {
                var eur_kur = $("#doviz_turu option:selected").attr("eur");
                $("#doviz_kuru_irsaliye").val(eur_kur);
            } else if (value == "USD") {
                var usd_kur = $("#doviz_turu option:selected").attr("usd");
                $("#doviz_kuru_irsaliye").val(usd_kur);
            } else if (value == "GBP") {
                var gbp_kur = $("#doviz_turu option:selected").attr("gbp");
                $("#doviz_kuru_irsaliye").val(gbp_kur);
            } else {
                $("#doviz_kuru_irsaliye").val("");
            }
        });
        $("body").off("change", "#doviz_hesaplari").on("change", "#doviz_hesaplari", function () {
            let banka_adi = $("option:selected", this).text();
            let doviz_tipi = $("option:selected").attr("doviz_tipi");
            $("#doviz_turu").val(doviz_tipi);
            if (doviz_tipi == "TL") {
                $("#doviz_kuru_irsaliye").val("1.00");
            } else if (doviz_tipi == "EURO") {
                var eur_kur = $("#doviz_turu option:selected").attr("eur");
                $("#doviz_kuru_irsaliye").val(eur_kur);
            } else if (doviz_tipi == "USD") {
                var usd_kur = $("#doviz_turu option:selected").attr("usd");
                $("#doviz_kuru_irsaliye").val(usd_kur);
            } else if (doviz_tipi == "GBP") {
                var gbp_kur = $("#doviz_turu option:selected").attr("gbp");
                $("#doviz_kuru_irsaliye").val(gbp_kur);
            } else {
                $("#doviz_kuru_irsaliye").val("");
            }
            $.get("controller/banka_controller/sql.php?islem=bankaya_ait_tl_hesaplari_sql", {banka_adi: banka_adi}, function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    $("#tl_hesaplari_satim").html("");
                    $("#tl_hesaplari_satim").append("<option value=''>Bir TL Hesabı Seçiniz...</option>");
                    json.forEach(function (item) {
                        $("#tl_hesaplari_satim").append("" +
                            "<option value='" + item.id + "'>" + item.hesap_adi + "</option>" +
                            "");
                    })
                }
            })
        });

        $("body").off("click", "#banka_acilis_vazgec").on("click", "#banka_acilis_vazgec", function () {
            $("#doviz_satim_yap_main_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "doviz_satis_guncelle_modal") {
    ?>
    <div class="modal fade" id="doviz_satim_guncelle_main_modal" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 50%; max-width: 50%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="banka_acilis_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>DÖVİZ SATIM GÜNCELLE</div>
                        </div>
                        <div class="modal-body">
                            <div class="havale_giris_cari_listesi_div"></div>
                            <div class="col-12 row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Tarih</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" class="form-control form-control-sm" id="tarih"
                                                   value="<?= date("Y-m-d") ?>">
                                        </div>
                                    </div>
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
                                            <label>Döviz Hesabı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="doviz_hesaplari">
                                                <option value="">Bir Döviz Hesabı Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>TL Hesabı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="tl_hesaplari_satim">
                                                <option value="">Bir TL Hesabı Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Döviz Türü</label>
                                        </div>
                                        <div class="col-md-7 no-gutters row">
                                            <div class="col">
                                                <select class="custom-select custom-select-sm" id="doviz_turu" disabled>
                                                    <option value="">Bir Döviz Türü Seçiniz...</option>
                                                    <option id="usd_bas_irsaliye" value="USD">USD</option>
                                                    <option id="eur_bas_irsaliye" value="EURO">EURO</option>
                                                    <option id="gbp_bas_irsaliye" value="GBP">GBP</option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control form-control-sm"
                                                       placeholder="Döviz Kuru Giriniz..." id="doviz_kuru_irsaliye">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Döviz Miktarı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" value="0,00" class="form-control form-control-sm"
                                                   id="doviz_miktari">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>TL Tutarı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="tl_tutari" value="0,00"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Masraf Tutarı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" value="0,00" class="form-control form-control-sm"
                                                   id="masraf_tutari">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Masraf Carisi</label>
                                        </div>
                                        <div class="col-md-7 row no-gutters">
                                            <div class="col">
                                                <select class="custom-select custom-select-sm" id="dusulecek_hesap">
                                                    <option value="">Düşülecek Hesap</option>
                                                    <option value="TL Hesabı">TL Hesabı</option>
                                                    <option value="Döviz Hesabı">Döviz Hesabı</option>
                                                </select>
                                            </div>
                                            <div class="col">
                                                <div class="input-group">
                                                    <input type="text" placeholder="Masraf Carisi"
                                                           class="form-control form-control-sm" id="masraf_cari">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-warning btn-sm"
                                                                id="masraf_carilerini_getir_button">
                                                            <i class="fa fa-ellipsis-h"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="banka_acilis_vazgec"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="doviz_satim_kaydet"><i class="fa fa-check"></i>
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
        })

        $(document).ready(function () {
            $("#doviz_satim_guncelle_main_modal").modal("show");

            $.get("controller/banka_controller/sql.php?islem=doviz_hesaplari_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#doviz_hesaplari").append("" +
                            "<option doviz_tipi='" + item.doviz_tipi + "' value='" + item.id + "'>" + item.hesap_adi + "</option>" +
                            "");
                    });
                }
            })
            $.get("controller/banka_controller/sql.php?islem=bankaya_ait_tl_hesaplari_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    $("#tl_hesaplari_satim").html("");
                    $("#tl_hesaplari_satim").append("<option value=''>Bir TL Hesabı Seçiniz...</option>");
                    json.forEach(function (item) {
                        $("#tl_hesaplari_satim").append("" +
                            "<option value='" + item.id + "'>" + item.hesap_adi + "</option>" +
                            "");
                    })
                }
            })

            $.get("controller/banka_controller/sql.php?islem=banka_satim_bilgileri_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    let tarih = item.tarih;
                    tarih = tarih.split(" ");
                    $("#tarih").val(tarih[0]);
                    $("#fis_no").val(item.fis_no);
                    setTimeout(function () {
                        $("#doviz_hesaplari").val(item.doviz_hesap);
                        $("#tl_hesaplari_satim").val(item.tl_hesap);
                    }, 500);
                    $("#doviz_turu").val(item.doviz_turu);
                    $("#doviz_kuru_irsaliye").val(item.doviz_kuru);
                    let doviz_miktar = item.doviz_miktari;
                    doviz_miktar = parseFloat(doviz_miktar);
                    doviz_miktar = doviz_miktar.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    let tl_tutar = item.tl_tutar;
                    tl_tutar = parseFloat(tl_tutar);
                    tl_tutar = tl_tutar.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    let masraf_tutari = item.masraf_tutari;
                    masraf_tutari = parseFloat(masraf_tutari);
                    masraf_tutari = masraf_tutari.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    $("#doviz_miktari").val(doviz_miktar);
                    $("#tl_tutari").val(tl_tutar);
                    $("#masraf_tutari").val(masraf_tutari);
                    $("#dusulecek_hesap").val(item.dusulecek_hesap);
                    $("#masraf_cari").val(item.cari_adi)
                    $("#masraf_cari").attr("data-id", item.cari_id)
                }
            })

            $.get("controller/alis_controller/sql.php?islem=guncel_kurlar", function (result) {

                var item = JSON.parse(result);
                var usd = item.USD[0];

                var eur = item.EUR[0];

                var gbp = item.GBP[0];
                $("#usd_bas_irsaliye").attr("usd", usd);
                $("#eur_bas_irsaliye").attr("eur", eur);
                $("#gbp_bas_irsaliye").attr("gbp", gbp);

            });

        });

        $("body").off("click", "#masraf_carilerini_getir_button").on("click", "#masraf_carilerini_getir_button", function () {
            $.get("modals/banka_modal/havale_giris_modal.php?islem=cari_listesi_getir_modal", function (getModal) {
                $(".havale_giris_cari_listesi_div").html("");
                $(".havale_giris_cari_listesi_div").html(getModal);
            })
        });

        $("body").off("click", "#doviz_satim_kaydet").on("click", "#doviz_satim_kaydet", function () {
            let fis_no = $("#fis_no").val();
            let tarih = $("#tarih").val();
            let tl_hesaplari = $("#tl_hesaplari_satim").val();
            let doviz_hesaplari = $("#doviz_hesaplari").val();
            let doviz_turu = $("#doviz_turu").val();
            let doviz_kuru_irsaliye = $("#doviz_kuru_irsaliye").val();
            doviz_kuru_irsaliye = doviz_kuru_irsaliye.replace(/\./g, "").replace(",", ".");
            doviz_kuru_irsaliye = parseFloat(doviz_kuru_irsaliye);
            let doviz_miktari = $("#doviz_miktari").val();
            doviz_miktari = doviz_miktari.replace(/\./g, "").replace(",", ".");
            doviz_miktari = parseFloat(doviz_miktari);
            let tl_tutari = $("#tl_tutari").val();
            tl_tutari = tl_tutari.replace(/\./g, "").replace(",", ".");
            tl_tutari = parseFloat(tl_tutari);
            let masraf_tutari = $("#masraf_tutari").val();
            masraf_tutari = masraf_tutari.replace(/\./g, "").replace(",", ".");
            masraf_tutari = parseFloat(masraf_tutari);
            let dusulecek_hesap = $("#dusulecek_hesap").val();
            let cari_id = $("#masraf_cari").attr("data-id");

            if (tl_hesaplari == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir TL Hesabı Seçiniz...",
                    "warning"
                )
            } else if (doviz_hesaplari == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir Döviz Hesabı Seçiniz...",
                    "warning"
                )
            } else if (doviz_turu == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir Döviz Türü Seçiniz...",
                    "warning"
                )
            } else if (doviz_kuru_irsaliye == "" || doviz_kuru_irsaliye == 0) {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Döviz Kuru Giriniz...",
                    "warning"
                )
            } else if (doviz_miktari == "" || doviz_miktari == 0) {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Alınacak Döviz Miktarı Giriniz...",
                    "warning"
                )
            } else if (tl_tutari == "" || tl_tutari == 0) {
                Swal.fire(
                    "Uyarı",
                    "TL Tutarı 0 Olamaz",
                    "warning"
                )
            } else {
                $.ajax({
                    url: "controller/banka_controller/sql.php?islem=doviz_satim_guncelle_sql",
                    type: "POST",
                    data: {
                        fis_no: fis_no,
                        tl_hesap: tl_hesaplari,
                        doviz_hesap: doviz_hesaplari,
                        tarih: tarih,
                        doviz_turu: doviz_turu,
                        doviz_kuru: doviz_kuru_irsaliye,
                        doviz_miktari: doviz_miktari,
                        tl_tutar: tl_tutari,
                        masraf_tutari: masraf_tutari,
                        dusulecek_hesap: dusulecek_hesap,
                        cari_id: cari_id,
                        id: "<?=$_GET["id"]?>"
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Döviz Satım Güncellendi",
                                "success"
                            )
                            $("#doviz_satim_guncelle_main_modal").modal("hide");
                            $.get("view/doviz_satim.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("view/doviz_satim.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                })
            }
        });

        $("body").off("focusout", "#doviz_miktari").on("focusout", "#doviz_miktari", function () {
            let miktar = $(this).val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            if (isNaN(miktar)) {
                miktar = 0;
            }
            let doviz_kur = $("#doviz_kuru_irsaliye").val();
            doviz_kur = doviz_kur.replace(",", ".");
            doviz_kur = parseFloat(doviz_kur);
            if (isNaN(doviz_kur)) {
                doviz_kur = 0;
            }
            let tl_tutari = doviz_kur * miktar;
            $("#tl_tutari").val(tl_tutari.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
            $(this).val(miktar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });
        $("body").off("focusout", "#masraf_tutari").on("focusout", "#masraf_tutari", function () {
            let miktar = $(this).val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            if (isNaN(miktar)) {
                miktar = 0;
            }
            $(this).val(miktar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("change", "#doviz_turu").on("change", "#doviz_turu", function () {
            var value = $(this).val();
            if (value == "TL") {
                $("#doviz_kuru_irsaliye").val("1.00");
            } else if (value == "EURO") {
                var eur_kur = $("#doviz_turu option:selected").attr("eur");
                $("#doviz_kuru_irsaliye").val(eur_kur);
            } else if (value == "USD") {
                var usd_kur = $("#doviz_turu option:selected").attr("usd");
                $("#doviz_kuru_irsaliye").val(usd_kur);
            } else if (value == "GBP") {
                var gbp_kur = $("#doviz_turu option:selected").attr("gbp");
                $("#doviz_kuru_irsaliye").val(gbp_kur);
            } else {
                $("#doviz_kuru_irsaliye").val("");
            }
        });
        $("body").off("change", "#doviz_hesaplari").on("change", "#doviz_hesaplari", function () {
            let banka_adi = $("option:selected", this).text();
            let doviz_tipi = $("option:selected").attr("doviz_tipi");
            $("#doviz_turu").val(doviz_tipi);
            if (doviz_tipi == "TL") {
                $("#doviz_kuru_irsaliye").val("1.00");
            } else if (doviz_tipi == "EURO") {
                var eur_kur = $("#doviz_turu option:selected").attr("eur");
                $("#doviz_kuru_irsaliye").val(eur_kur);
            } else if (doviz_tipi == "USD") {
                var usd_kur = $("#doviz_turu option:selected").attr("usd");
                $("#doviz_kuru_irsaliye").val(usd_kur);
            } else if (doviz_tipi == "GBP") {
                var gbp_kur = $("#doviz_turu option:selected").attr("gbp");
                $("#doviz_kuru_irsaliye").val(gbp_kur);
            } else {
                $("#doviz_kuru_irsaliye").val("");
            }
            $.get("controller/banka_controller/sql.php?islem=bankaya_ait_tl_hesaplari_sql", {banka_adi: hesap_adi}, function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    $("#tl_hesaplari_satim").html("");
                    $("#tl_hesaplari_satim").append("<option value=''>Bir TL Hesabı Seçiniz...</option>");
                    json.forEach(function (item) {
                        $("#tl_hesaplari_satim").append("" +
                            "<option value='" + item.id + "'>" + item.hesap_adi + "</option>" +
                            "");
                    })
                }
            })
        });

        $("body").off("click", "#banka_acilis_vazgec").on("click", "#banka_acilis_vazgec", function () {
            $("#doviz_satim_guncelle_main_modal").modal("hide");
        });

    </script>
    <?php
}