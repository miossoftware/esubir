<?php

$islem = $_GET["islem"];

if ($islem == "konteyner_girisi_yap_modal") {
    ?>

    <style>
        #konteyner_giris_main_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="konteyner_giris_main_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="konteyner_giris_main_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>KONTEYNER GİRİŞ</div>
                        </div>
                        <div class="modal-body">
                            <div class="konteyner_irasliye_suruculeri_getir_div"></div>
                            <div class="tanimli_konteynerleri_getir_div"></div>
                            <div class="konteyner_irasliye_plakalari_getir_div"></div>
                            <div class="kayitli_siparisler_div"></div>
                            <div id="carileri_getir_irsaliye"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Konteyner No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="konteyner_no">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="tanimli_konteynerleri_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Giriş Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" class="form-control form-control-sm" id="giris_tarihi"
                                                   value="<?= date("Y-m-d") ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Cari Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="cari_id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="cari_getir_modal_irsaliye"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Epro. Referans</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="epro_ref">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="tum_siparisleri_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Referans</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="referans_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Beyanname No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="beyanname_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Mühür No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="muhur_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>2.Konteyner</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="konteyner2_varmi">
                                                <option value="yok">Yok</option>
                                                <option value="var">Var</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row konteyner2_hidden" style="display: none">
                                        <div class="col-md-4">
                                            <label>2.Konteyner No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="konteyner_no1">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="tanimli_konteynerleri_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row konteyner2_hidden" style="display: none">
                                        <div class="col-md-4">
                                            <label>2.Mühür No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="muhur_no2">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Boş / Dolu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="bos_dolu">
                                                <option value="Boş">Boş</option>
                                                <option value="Dolu">Dolu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Plaka No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="plaka_id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="irsaliye_plakalari_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Sürücü Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="surucu_id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="irsaliye_icin_suruculeri_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Plaka Cari</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="arac_cari_adi"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="aciklama">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="tipi" disabled>
                                                <option value="İHRACAT">İHRACAT</option>
                                                <option value="İTHALAT">İTHALAT</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Sahaya Serilsin</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="sahaya_ser">
                                                <option value="2">Serilmesin</option>
                                                <option value="1">Serilsin</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="konteyner_giris_main_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="konteyner_giris_kaydet_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>


        $("body").off("click", "#cari_getir_modal_irsaliye").on("click", "#cari_getir_modal_irsaliye", function () {
            $.get("modals/alis_modal/alis_irsaliye_page.php?islem=irsaliye_icin_carileri_getir", function (getModal) {
                $("#carileri_getir_irsaliye").html("");
                $("#carileri_getir_irsaliye").html(getModal);
            })
        });


        $(document).ready(function () {
            $("#konteyner_giris_main_modal").modal("show");

            $.get("depo/controller/depo_controller/sql.php?islem=birimleri_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#birim_id").append("<option value='" + item.id + "'>" + item.birim_adi + "</option>");
                    })
                }
            });
        });

        $("body").off("change", "#konteyner2_varmi").on("change", "#konteyner2_varmi", function () {
            let val = $(this).val();
            if (val == "var") {
                $(".konteyner2_hidden").show();
            } else {
                $(".konteyner2_hidden").hide();
            }
        });

        $("body").off("click", "#tum_siparisleri_getir_button").on("click", "#tum_siparisleri_getir_button", function () {
            let cari_id = $("#cari_id").attr("data-id");
            $.get("depo/modals/konteyner_modal/konteyner_giris.php?islem=is_emirlerini_getir_sql", {cari_id: cari_id}, function (getModal) {
                $(".kayitli_siparisler_div").html(getModal);
            })
        });

        $("body").off("click", "#irsaliye_plakalari_getir_button").on("click", "#irsaliye_plakalari_getir_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=irsaliye_plakalari_getir", function (getModal) {
                $(".konteyner_irasliye_plakalari_getir_div").html("");
                $(".konteyner_irasliye_plakalari_getir_div").html(getModal);
            });
        });
        
        $("body").off("focusout", "#arac_kirasi").on("focusout", "#arac_kirasi", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });

        $("body").off("focusout", "#miktar").on("focusout", "#miktar", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });

        $("body").off("focusout", "#surucu_prim").on("focusout", "#surucu_prim", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });

        $("body").off("click", "#konteyner_giris_kaydet_button").on("click", "#konteyner_giris_kaydet_button", function () {
            let giris_tarihi = $("#giris_tarihi").val();
            let konteyner_no = $("#konteyner_no").val();
            let konteyner_id = $("#konteyner_no").attr("data-id");
            let konteyner_id1 = $("#konteyner_id1").attr("data-id");
            let referans_no = $("#referans_no").val();
            let is_emri_id = $("#epro_ref").attr("data-id");
            let beyanname_no = $("#beyanname_no").val();
            let muhur_no = $("#muhur_no").val();
            let tipi = $("#tipi").val();
            let sahaya_ser = $("#sahaya_ser").val();
            let bos_dolu = $("#bos_dolu").val();
            let konteyner_no1 = $("#konteyner_no1").val();
            let muhur_no2 = $("#muhur_no2").val();
            let plaka_id = $("#plaka_id").attr("data-id");
            let surucu_id = $("#surucu_id").attr("data-id");
            let surucu_adi = $("#surucu_id").val();
            let cari_id = $("#cari_id").attr("data-id");
            let aciklama = $("#aciklama").val();
            if (konteyner_no == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Konteyner No Giriniz...",
                    "warning"
                );
            } else if (plaka_id == undefined || plaka_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Tanımlı Plaka Belirtiniz...",
                    "warning"
                );
            } else if (giris_tarihi == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Giriş Tarihi Belirtiniz...",
                    "warning"
                );
            } else if (cari_id == undefined || cari_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Cari Seçiniz...",
                    "warning"
                );
            } else if (is_emri_id == undefined || is_emri_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir İş Emri Seçiniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "depo/controller/konteyner_controller/sql.php?islem=konteyner_giris_kaydet_sql",
                    type: "POST",
                    data: {
                        giris_tarihi: giris_tarihi,
                        is_emri_id: is_emri_id,
                        konteyner_no: konteyner_no,
                        muhur_no2: muhur_no2,
                        konteyner_id: konteyner_id,
                        konteyner_no1: konteyner_no1,
                        konteyner_id1: konteyner_id1,
                        muhur_no: muhur_no,
                        referans_no: referans_no,
                        cari_id: cari_id,
                        sahaya_ser: sahaya_ser,
                        tipi: tipi,
                        bos_dolu: bos_dolu,
                        beyanname_no: beyanname_no,
                        plaka_id: plaka_id,
                        surucu_id: surucu_id,
                        surucu_adi: surucu_adi,
                        aciklama: aciklama
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Konteyner Giriş Kaydedildi",
                                "success"
                            );
                            $("#konteyner_giris_main_modal").modal("hide");
                            $.get("depo/view/konteyner_giris_main.php", function (getList) {
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/konteyner_giris_main.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }
        });

        $("body").off("keyup", "#konteyner_no").on("keyup", "#konteyner_no", function () {
            let val = $(this).val();
            $.get("depo/controller/konteyner_controller/sql.php?islem=tanimli_konteynerleri_getir_sql", {konteyner_no: val}, function (res) {
                if (res != 2) {

                    var item = JSON.parse(res);
                    if (item.id != null) {
                        $("#konteyner_no").attr("data-id", item.id);
                        $("#referans_no").val(item.acente_ref);
                        $("#beyanname_no").val(item.beyanname_no);
                        $("#konteyner_tipi").val(item.konteyner_tipi);
                        let epro_ref = "";
                        let tipi = "";
                        if (item.ithalat_epro == null) {
                            epro_ref = item.ihracat_epro;
                            tipi = "İHRACAT";
                        } else {
                            epro_ref = item.ithalat_epro;
                            tipi = "İTHALAT";
                        }

                        let miktar = 0;
                        let birim = 0;
                        let kont_sayi = 0;
                        if (item.ihracat_miktar == null) {
                            miktar = item.ithalat_miktar
                            kont_sayi = item.ithalat_kont_sayi;
                        } else {
                            miktar = item.ihracat_miktar;
                            kont_sayi = item.ihracat_kont_sayi;
                        }
                        miktar = parseFloat(miktar);
                        kont_sayi = parseFloat(kont_sayi);
                        miktar = miktar / kont_sayi;
                        $("#miktar").val(miktar.toLocaleString("tr-TR", {
                            maximumFractionDigits: 2,
                            minimumFractionDigits: 2
                        }));
                        if (item.ihracat_birim == null) {
                            birim = item.ithalat_birim;
                        } else {
                            birim = item.ihracat_birim;
                        }
                        $("#birim_id").val(birim);
                        $("#epro_ref").val(epro_ref);
                        $("#cari_id").val(item.cari_adi)
                        $("#cari_id").attr("data-id", item.cari_id)
                        let cut_of = item.cutt_off_tarihi;
                        if (cut_of != null) {
                            cut_of = cut_of.split(" ");
                            cut_of = cut_of[0];
                        }
                        let ardiyesiz_giris_tarihi = item.ardiyesiz_giris_tarihi;
                        if (ardiyesiz_giris_tarihi != null) {
                            ardiyesiz_giris_tarihi = ardiyesiz_giris_tarihi.split(" ");
                            ardiyesiz_giris_tarihi = ardiyesiz_giris_tarihi[0];
                        }
                        let demoraj_tarihi = item.demoraj_tarihi;
                        if (demoraj_tarihi != null) {
                            demoraj_tarihi = demoraj_tarihi.split(" ");
                            demoraj_tarihi = demoraj_tarihi[0];
                        }
                        $("#cut_off_tarihi").val(cut_of);
                        $("#ardiyesiz_giris_tarihi").val(ardiyesiz_giris_tarihi);
                        $("#demoraj_tarihi").val(demoraj_tarihi);
                        $("#tipi").val(item.tipi);
                        if (tipi == "İHRACAT") {
                            $("#bos_dolu").val("Boş");
                        } else {
                            $("#bos_dolu").val("Dolu");
                        }
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        Toast.fire({
                            icon: "success",
                            title: "Konteyner Bulundu"
                        });
                    } else {
                        $("#konteyner_no").attr("data-id", "");
                        $("#referans_no").val("");
                        $("#beyanname_no").val("");
                        $("#konteyner_tipi").val("");
                        let epro_ref = "";
                        if (item.ithalat_epro == null) {
                            epro_ref = item.ihracat_epro;
                        } else {
                            epro_ref = item.ithalat_epro;
                        }
                        $("#epro_ref").val("");
                        $("#cari_id").val("")
                        $("#cari_id").attr("data-id", "")
                        let cut_of = item.cutt_off_tarihi;
                        if (cut_of != null) {
                            cut_of = cut_of.split(" ");
                            cut_of = cut_of[0];
                        }
                        let ardiyesiz_giris_tarihi = item.ardiyesiz_giris_tarihi;
                        if (ardiyesiz_giris_tarihi != null) {
                            ardiyesiz_giris_tarihi = ardiyesiz_giris_tarihi.split(" ");
                            ardiyesiz_giris_tarihi = ardiyesiz_giris_tarihi[0];
                        }
                        let demoraj_tarihi = item.demoraj_tarihi;
                        if (demoraj_tarihi != null) {
                            demoraj_tarihi = demoraj_tarihi.split(" ");
                            demoraj_tarihi = demoraj_tarihi[0];
                        }
                        $("#cut_off_tarihi").val("");
                        $("#ardiyesiz_giris_tarihi").val("");
                        $("#demoraj_tarihi").val("");
                        $("#tipi").val("");
                    }

                }
            })
        });

        $("body").off("keyup", "#plaka_id").on("keyup", "#plaka_id", function () {
            let val = $(this).val();
            $.get("konteyner/controller/irsaliye_controller/sql.php?islem=plaka_bilgilerini_getir_sql", {plaka_no: val}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#dorse_id").attr("data-id", item.dorse_id);
                    $("#plaka_id").val((item.plaka_no).toUpperCase());
                    if (item.cari_adi != null) {
                        $("#arac_cari_adi").val((item.cari_adi).toUpperCase())
                    }
                    if (item.dorse_plaka != null) {
                        $("#dorse_id").val((item.dorse_plaka).toUpperCase());
                    }
                    if (item.surucu_adi != null) {
                        $("#surucu_id").val((item.surucu_adi).toUpperCase());
                    }
                    $("#plaka_id").attr("data-id", item.id);
                    $("#surucu_tel").val(item.surucu_tel);
                    $("#surucu_id").attr("data-id", item.surucu_id);

                    if (item.arac_grubu == "Kiralık") {
                        $("#surucu_prim").val("0,00");
                        $("#surucu_prim").prop("disabled", true);
                        $("#arac_kirasi").prop("disabled", false);
                    } else if (item.arac_grubu == "Öz Mal") {
                        $("#surucu_prim").prop("disabled", false);
                        $("#arac_kirasi").prop("disabled", true);
                        $("#arac_kirasi").val("0,00");
                    } else {
                        $("#arac_kirasi").prop("disabled", false);
                        $("#surucu_prim").prop("disabled", false);
                    }

                } else {
                    $("#dorse_id").attr("data-id", "");
                    $("#plaka_id").attr("data-id", "");
                    $("#arac_kirasi").prop("disabled", false);
                    $("#surucu_prim").prop("disabled", false);
                    $("#dorse_id").val("");
                    $("#surucu_tel").val("");
                    $("#arac_cari_adi").val("")
                    $("#surucu_id").val("");
                    $("#surucu_id").attr("data-id", "");
                }
            })
        });

        $("body").off("click", "#irsaliye_icin_suruculeri_getir_button").on("click", "#irsaliye_icin_suruculeri_getir_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=irsaliye_icin_suruculeri_getir", function (getModal) {
                $(".konteyner_irasliye_suruculeri_getir_div").html("");
                $(".konteyner_irasliye_suruculeri_getir_div").html(getModal);
            });
        });

        $("body").off("click", "#tanimli_konteynerleri_getir_button").on("click", "#tanimli_konteynerleri_getir_button", function () {
            $.get("depo/modals/konteyner_modal/konteyner_giris.php?islem=tanimli_konteynerleri_getir_modal", function (getModal) {
                $(".tanimli_konteynerleri_getir_div").html("");
                $(".tanimli_konteynerleri_getir_div").html(getModal);
            });
        });

        $("body").off("click", "#konteyner_giris_main_modal_kapat").on("click", "#konteyner_giris_main_modal_kapat", function () {
            $("#konteyner_giris_main_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "is_emirlerini_getir_sql") {
    ?>

    <div class="modal fade" id="konteyner_giris_is_emir_listesi"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 100%; max-width: 100%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">İŞ EMRİ LİSTESİ
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="is_emri_select_liste">
                            <thead>
                            <tr>
                                <th id="click1">Sipariş Tarihi</th>
                                <th>Tipi</th>
                                <th>Epro. Ref.</th>
                                <th>Referans No</th>
                                <th>Acente</th>
                                <th>Beyanname No</th>
                                <th>CUT-OFF Tarihi</th>
                                <th>Ardiyesiz Giriş Tarihi</th>
                                <th>Demoraj Tarihi</th>
                                <th>Alım Yeri</th>
                                <th>Teslim Yeri</th>
                                <th>Açıklama</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var table = "";

        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#konteyner_giris_is_emir_listesi").modal("hide");
        })

        $(document).ready(function () {
            $("#konteyner_giris_is_emir_listesi").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 300);
            table = $('#is_emri_select_liste').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "siparis_tarihi"},
                    {'data': "tipi"},
                    {'data': "epro_ref"},
                    {'data': "referans_no"},
                    {'data': "acente"},
                    {'data': "beyanname_no"},
                    {'data': "cut_of_tarihi"},
                    {'data': "ardiyesiz_giris_tarihi"},
                    {'data': "demoraj_tarihi"},
                    {'data': "alim_yeri"},
                    {'data': "teslim_yeri"},
                    {'data': "aciklama"}
                ],
                createdRow: function (row) {
                    $(row).addClass("is_emri_selected");
                    $(row).find('td').css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            });
            $.get("depo/controller/is_emri_controller/sql.php?islem=tum_is_emirlerini_getir_sql", {cari_id: "<?=$_GET["cari_id"]?>"}, function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    table.rows.add(json).draw(false);
                }
            })

        })


        $("body").off("click", ".is_emri_selected").on("click", ".is_emri_selected", function () {
            var id = $(this).attr("data-id");
            $.get("depo/controller/is_emri_controller/sql.php?islem=is_emrinin_ana_bilgilerini_getir_sql", {id: id}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#cari_id").attr("data-id", item.cari_id);
                    $("#cari_id").val(item.cari_adi);
                    $("#epro_ref").val(item.epro_ref);
                    $("#referans_no").val(item.referans_no);
                    $("#beyanname_no").val(item.beyanname_no);
                    $("#tipi").val(item.tipi);
                    $("#epro_ref").attr("data-id", id);
                    if (item.tipi == "İHRACAT") {
                        $("#bos_dolu").val("Boş");
                    } else {
                        $("#bos_dolu").val("Dolu");
                    }
                }
            })
            $("#konteyner_giris_is_emir_listesi").modal("hide");
        })

    </script>
    <?php
}
if ($islem == "tanimli_konteynerleri_getir_modal") {
    ?>

    <div class="modal fade" id="konteyner_giris_is_emir_listesi"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 100%; max-width: 100%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">İŞ EMRİ LİSTESİ
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="is_emri_select_liste">
                            <thead>
                            <tr>
                                <th id="click1">Tipi</th>
                                <th>Epro. Ref.</th>
                                <th>Konteyner No</th>
                                <th>Konteyner Tipi</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var table = "";

        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#konteyner_giris_is_emir_listesi").modal("hide");
        })

        $(document).ready(function () {
            $("#konteyner_giris_is_emir_listesi").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 300);
            table = $('#is_emri_select_liste').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "tipi"},
                    {'data': "epro_ref"},
                    {'data': "konteyner_no"},
                    {'data': "konteyner_tipi"}
                ],
                createdRow: function (row) {
                    $(row).addClass("tanimli_konteyner_selected");
                    $(row).find('td').css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            });
            $.get("depo/controller/konteyner_controller/sql.php?islem=tanimlanan_konteynerleri_getir_sql", {cari_id: "<?=$_GET["cari_id"]?>"}, function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    table.rows.add(json).draw(false);
                }
            })

        })


        $("body").off("click", ".tanimli_konteyner_selected").on("click", ".tanimli_konteyner_selected", function () {
            var id = $(this).attr("data-id");
            $.get("depo/controller/konteyner_controller/sql.php?islem=secilen_konteyner_bilgilerini_getir_sql", {id: id}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#cari_id").attr("data-id", item.cari_id);
                    $("#cari_id").val(item.cari_adi);
                    $("#epro_ref").val(item.epro_ref);
                    $("#epro_ref").attr("data-id", item.is_emri_id);
                    $("#referans_no").val(item.referans_no);
                    $("#beyanname_no").val(item.beyanname_no);
                    $("#tipi").val(item.tipi);
                    $("#konteyner_no").val(item.konteyner_no)
                    $("#bos_dolu").val(item.bos_dolu);
                    $("#konteyner_no").attr("data-id", id);
                }
            })
            $("#konteyner_giris_is_emir_listesi").modal("hide");
        })

    </script>
    <?php
}