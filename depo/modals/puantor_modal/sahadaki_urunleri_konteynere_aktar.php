<?php


$islem = $_GET["islem"];

if ($islem == "sahadaki_urunleri_aktar") {
    ?>
    <style>
        #konteynere_urun_aktar_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="konteynere_urun_aktar_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="konteynere_urun_aktar_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>KONTEYNERE ÜRÜN AKTAR</div>
                        </div>
                        <div class="modal-body">
                            <div class="sahadaki_urun_plakalari"></div>
                            <div class="arac_girislerini_getir_div"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="ibox-title" style="background-color: #9DB2BF;color: white;">
                                        <center><span>Ürün Bilgileri</span></center>
                                    </div>
                                    <div class="mt-2"></div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Tarih</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" id="tarih" class="form-control form-control-sm"
                                                   value="<?= date("Y-m-d") ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Plaka No / Saha</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="plaka_no">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="sahadaki_urunler"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Dolu Kont. No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="konteyner_no">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="dolu_konteynerler_button"><i
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
                                            <input type="text" class="form-control form-control-sm" id="epro_ref"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Beyanname No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="beyanname_no"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Referans No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="referans_no"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Miktar</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" value="0,00"
                                                   id="miktar"
                                                   style="text-align: right">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Birim</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="birim_id">
                                                <option value="">Birim Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="ibox-title" style="background-color: #9DB2BF;color: white;">
                                        <center><span>Yüklenecek Konteyner Bilgileri</span></center>
                                    </div>
                                    <div class="mt-2"></div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>1. Konteyner</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="1konteyner_no">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="sahadaki_konteynerleri_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Yüklenen Miktar</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="1yuklenen_miktar"
                                                   style="text-align: right" value="0,00">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Birim</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="yuklenen_birim_id">
                                                <option value="">Birim Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>2. Konteyner</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="2konteyner_no">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="sahadaki_konteynerleri_getir_button2"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Yüklenen Miktar</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="2yuklenen_miktar"
                                                   style="text-align: right" value="0,00">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Birim</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="2yuklenen_birim_id">
                                                <option value="">Birim Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Forklift</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="forklift_id">
                                                <option value="">Forklift Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Kalmar</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="kalmar_id">
                                                <option value="">Kalmar Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="konteynere_urun_aktar_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="konteynere_urun_aktar_kaydet_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("body").off("keyup", "#konteyner_no").on("keyup", "#konteyner_no", function () {
            let val = $(this).val();
            $.get("depo/controller/konteyner_controller/sql.php?islem=secilen_dolu_giris_konteynerleri_getir_sql", {konteyner_no: val}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#cari_adi").val(item.cari_adi);
                    $("#cari_kodu").val(item.cari_kodu);
                    $("#surucu_adi").val(item.surucu_adi);
                    $("#konteyner_no").attr("data-id", item.id);
                    $("#konteyner_no").val(item.konteyner_no);
                    let birim_id = "";
                    if (item.ithalat_birim == null) {
                        birim_id = item.ihracat_birim;
                    } else {
                        birim_id = item.ithalat_birim;
                    }
                    $("#birim_id").val(birim_id);
                    $("#plaka_id").attr("data-id", "");
                    $("#plaka_id").val(item.plaka_no);
                    $("#plaka_no").val(item.plaka_no);
                    $("#surucu_tel").val(item.surucu_tel);
                    let miktar = item.miktar;
                    miktar = parseFloat(miktar);
                    $("#miktar").val(miktar.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                    $("#1yuklenen_miktar").val(miktar.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                    $("#referans").val(item.referans_no);
                    $("#fabrika_ref").val(item.fabrika_ref);
                    $("#epro_ref").val(item.epro_ref);
                } else {
                    $("#cari_adi").val("");
                    $("#cari_kodu").val("");
                    $("#surucu_adi").val("");
                    $("#konteyner_no").attr("data-id", "");
                    $("#birim_id").val("");
                    $("#plaka_id").attr("data-id", "");
                    $("#plaka_id").val("");
                    $("#plaka_no").val("");
                    $("#surucu_tel").val("");
                    $("#1yuklenen_miktar").val("");
                    $("#referans").val("");
                    $("#fabrika_ref").val("");
                    $("#epro_ref").val("");
                }
            })
        });

        $("body").off("keyup", "#1konteyner_no").on("keyup", "#1konteyner_no", function () {
            let val = $(this).val();
            $.get("depo/controller/konteyner_controller/sql.php?islem=guncellenecek_konteyner_girisleri_getir_sql", {konteyner_no: val}, function (res) {
                if (res != 2 && res != "") {
                    var item = JSON.parse(res);
                    $("#1konteyner_no").val(item.konteyner_no);
                    $("#1konteyner_no").attr("data-id", item.id);
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
                    $("#1konteyner_no").attr("data-id", "");
                }
            })
        });

        $("body").off("keyup", "#2konteyner_no").on("keyup", "#2konteyner_no", function () {
            let val = $(this).val();
            $.get("depo/controller/konteyner_controller/sql.php?islem=guncellenecek_konteyner_girisleri_getir_sql", {konteyner_no: val}, function (res) {
                if (res != 2 && res != "") {
                    var item = JSON.parse(res);
                    $("#1konteyner_no").val(item.konteyner_no);
                    $("#1konteyner_no").attr("data-id", item.id);
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
                    $("#1konteyner_no").attr("data-id", "");
                }
            })
        });

        $("body").off("click", "#sahadaki_urunler").on("click", "#sahadaki_urunler", function () {
            $.get("depo/modals/puantor_modal/sahadaki_urunleri_konteynere_aktar.php?islem=sahadaki_urunleri_getir_modal", function (getModal) {
                $(".sahadaki_urun_plakalari").html(getModal);
            });
        });

        $("body").off("click", "#dolu_konteynerler_button").on("click", "#dolu_konteynerler_button", function () {
            $.get("depo/modals/puantor_modal/sahaya_urun_ser.php?islem=dolu_giris_yapan_konteynerleri_getir_modal", function (getModal) {
                $(".arac_girislerini_getir_div").html(getModal);
            })
        });

        $("body").off("focusout", "#1yuklenen_miktar").on("focusout", "#1yuklenen_miktar", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });

        $("body").off("focusout", "#2yuklenen_miktar").on("focusout", "#2yuklenen_miktar", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });


        $("body").off("click", "#konteynere_urun_aktar_kaydet_button").on("click", "#konteynere_urun_aktar_kaydet_button", function () {
            let urun_id = $("#plaka_no").attr("data-id");
            let geldigi_yer = $("#plaka_no").attr("geldigi_yer");
            let konteyner_urunid = $("#konteyner_no").attr("data-id");
            let konteyner_no = $("#konteyner_no").val();
            let tarih = $("#tarih").val();
            let konteyner_id1 = $("#1konteyner_no").attr("data-id");
            let kalmar_id = $("#kalmar_id").val();
            let forklift_id = $("#forklift_id").val();
            let konteyner_id2 = $("#2konteyner_no").attr("data-id");
            let yuklenen_miktar1 = $("#1yuklenen_miktar").val();
            yuklenen_miktar1 = yuklenen_miktar1.replace(/\./g, "").replace(",", ".");
            yuklenen_miktar1 = parseFloat(yuklenen_miktar1);
            let yuklenen_miktar2 = $("#2yuklenen_miktar").val();
            yuklenen_miktar2 = yuklenen_miktar2.replace(/\./g, "").replace(",", ".");
            yuklenen_miktar2 = parseFloat(yuklenen_miktar2);
            let miktar = $("#miktar").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            let birim_id2 = $("#2yuklenen_birim_id").val();
            let birim_id1 = $("#yuklenen_birim_id").val();
            let tot = yuklenen_miktar1 + yuklenen_miktar2;

            if ((urun_id == undefined || urun_id == "") && (konteyner_urunid == undefined || konteyner_urunid == "")) {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Aktarılacak Ürünü Seçiniz...",
                    "warning"
                );
            } else if ((konteyner_id1 == undefined || konteyner_id1 == "") && (konteyner_id2 == undefined || konteyner_id2 == "")) {
                Swal.fire(
                    "Uyarı",
                    "Lütfen En Az Bir Konteyner Seçiniz...",
                    "warning"
                );
            } else if (tot != miktar) {
                Swal.fire(
                    "Uyarı",
                    "Toplam Yükleme Miktarları Ürün Miktarından Eksik Veya Fazladır...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "depo/controller/puantor_controller/sql.php?islem=konteynere_urun_aktar_kaydet_sql",
                    type: "POST",
                    data: {
                        urun_id: urun_id,
                        konteyner_id1: konteyner_id1,
                        kalmar_id: kalmar_id,
                        forklift_id: forklift_id,
                        tarih: tarih,
                        konteyner_id2: konteyner_id2,
                        geldigi_yer: geldigi_yer,
                        yuklenen_miktar1: yuklenen_miktar1,
                        yuklenen_miktar2: yuklenen_miktar2,
                        konteyner_no: konteyner_no,
                        konteyner_urunid: konteyner_urunid,
                        birim_id1: birim_id1,
                        birim_id2: birim_id2
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Konteynere Ürün Aktarıldı",
                                "success"
                            );
                            $.get("depo/view/konteynere_urun_aktar.php", function (getList) {
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/konteynere_urun_aktar.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            });
                            $("#konteynere_urun_aktar_modal").modal("hide");
                        }
                    }
                });
            }
        });

        $("body").off("click", "#sahadaki_konteynerleri_getir_button").on("click", "#sahadaki_konteynerleri_getir_button", function () {
            let epro_ref = $("#epro_ref").val();
            if (epro_ref == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Ürünü Seçiniz...",
                    "warning"
                );
            } else {
                $.get("depo/modals/puantor_modal/sahadaki_urunleri_konteynere_aktar.php?islem=sahadaki_konteynerleri_getir_modal1", {epro_ref: epro_ref}, function (getModal) {
                    $(".sahadaki_urun_plakalari").html(getModal);
                });
            }
        });

        $("body").off("click", "#sahadaki_konteynerleri_getir_button2").on("click", "#sahadaki_konteynerleri_getir_button2", function () {
            let epro_ref = $("#epro_ref").val();
            if (epro_ref == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Ürünü Seçiniz...",
                    "warning"
                );
            } else {
                $.get("depo/modals/puantor_modal/sahadaki_urunleri_konteynere_aktar.php?islem=sahadaki_konteynerleri_getir_modal2", {epro_ref: epro_ref}, function (getModal) {
                    $(".sahadaki_urun_plakalari").html(getModal);
                });
            }
        });

        $(document).ready(function () {
            $("#konteynere_urun_aktar_modal").modal("show");
            $.get("depo/controller/is_emri_controller/sql.php?islem=birimleri_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#birim_id").append("<option value='" + item.id + "'>" + item.birim_adi + "</option>");
                    })
                }
            });

            $.get("depo/controller/is_emri_controller/sql.php?islem=birimleri_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#yuklenen_birim_id").append("<option value='" + item.id + "'>" + item.birim_adi + "</option>");
                    })
                }
            });

            $.get("depo/controller/tanim_controller/sql.php?islem=tum_forkliftleri_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#forklift_id").append("<option value='" + item.id + "'>" + item.forklift_adi + "</option>");
                    })
                }
            });

            $.get("depo/controller/tanim_controller/sql.php?islem=tum_kalmarlari_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#kalmar_id").append("<option value='" + item.id + "'>" + item.forklift_adi + "</option>");
                    })
                }
            });

            $.get("depo/controller/is_emri_controller/sql.php?islem=birimleri_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#2yuklenen_birim_id").append("<option value='" + item.id + "'>" + item.birim_adi + "</option>");
                    })
                }
            });

        });

        $("body").off("click", "#konteynere_urun_aktar_modal_kapat").on("click", "#konteynere_urun_aktar_modal_kapat", function () {
            $("#konteynere_urun_aktar_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "sahadaki_urunleri_getir_modal") {
    ?>
    <div class="modal fade" id="sahadaki_urunlerin_bilgileri_modal" data-backdrop="static"
         data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 100%; max-width: 100%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="sahadaki_urunlerin_bilgileri_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>SAHADAKİ ÜRÜNLER</div>
                        </div>
                        <div class="modal-body">
                            <table class="table table-sm table-bordered w-100 display nowrap"
                                   style="cursor:pointer;font-size: 13px;"
                                   id="arac_girisleri_list">
                                <thead>
                                <tr>
                                    <th>Giriş Tarihi</th>
                                    <th>Cari Adı</th>
                                    <th id="click1">Plaka No</th>
                                    <th>Bulunduğu Yer</th>
                                    <th>Konteyner No</th>
                                    <th>Miktar</th>
                                    <th>Birim</th>
                                    <th>Sürücü Adı</th>
                                    <th>Epro. Referans</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function () {
            $("#sahadaki_urunlerin_bilgileri_modal").modal("show");

            setTimeout(function () {
                $("#click1").trigger("click");
            }, 500);

            var table = $('#arac_girisleri_list').DataTable({
                scrollY: '30vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "giris_tarihi"},
                    {'data': "cari_adi"},
                    {'data': "plaka_no"},
                    {'data': "bulundugu_yer"},
                    {'data': "konteyner_no"},
                    {'data': "miktar"},
                    {'data': "birim_adi"},
                    {'data': "surucu_adi"},
                    {'data': "epro_ref"}
                ],
                createdRow: function (row, data) {
                    $(row).addClass("sahadaki_urunleri_getir_list_selected");
                    $(row).find('td').css('text-align', 'left');
                    $(row).find('td').eq(5).css('text-align', 'right');
                    $(row).attr("data-id", data.id);
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $.get("depo/controller/puantor_controller/sql.php?islem=sahadaki_urunleri_ve_plakalari_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                }
            })
        });

        $("body").off("click", ".sahadaki_urunleri_getir_list_selected").on("click", ".sahadaki_urunleri_getir_list_selected", function () {
            let id = $(this).attr("data-id");
            let geldigi_yer = $(this).find("td").eq(3).text();
            // BURADA ARAÇ GİRİŞİNDEN Mİ YOKSA DİREKT OLARAK SAHADANMI ÜRÜNÜN GELDİĞİNİN FİLTRESİNİ YAPIYORUZ
            if (geldigi_yer == "SAHADA") {
                $.get("depo/controller/puantor_controller/sql.php?islem=secilen_saha_urunu_bilgisini_getir_sql", {id: id}, function (res) {
                    if (res != 2) {
                        var item = JSON.parse(res);
                        $("#plaka_no").attr("data-id", item.id);
                        $("#plaka_no").attr("plaka_id", item.plaka_id);
                        $("#plaka_no").attr("geldigi_yer", "sahadan");
                        $("#plaka_no").val(item.plaka_no);
                        $("#konteyner_no").attr("data-id", item.k_girisid);
                        $("#konteyner_no").val(item.konteyner_no);
                        $("#epro_ref").val(item.epro_ref);
                        $("#beyanname_no").val(item.beyanname_no);
                        let miktar = item.miktar;
                        miktar = parseFloat(miktar);
                        miktar = miktar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                        $("#miktar").val(miktar);
                        $("#1yuklenen_miktar").val(miktar);
                        $("#yuklenen_birim_id").val(item.birim_id);
                        $("#birim_id").val(item.birim_id);
                    }
                });
            } else {
                $.get("depo/controller/konteyner_controller/sql.php?islem=giris_yapan_aracin_bilgilerini_getir_sql", {id: id}, function (res) {
                    if (res != 2) {
                        var item = JSON.parse(res);
                        $("#plaka_no").attr("data-id", item.id);
                        $("#plaka_no").attr("plaka_id", item.plaka_id);
                        $("#plaka_no").attr("geldigi_yer", "arac_giristen");
                        $("#plaka_no").val(item.plaka_no);
                        $("#konteyner_no").attr("data-id", item.k_girisid);
                        $("#konteyner_no").val(item.konteyner_no);
                        $("#epro_ref").val(item.epro_ref);
                        $("#beyanname_no").val(item.beyanname_no);
                        let miktar = item.miktar;
                        miktar = parseFloat(miktar);
                        miktar = miktar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                        $("#miktar").val(miktar);
                        $("#1yuklenen_miktar").val(miktar);
                        $("#yuklenen_birim_id").val(item.birim_id);
                        $("#birim_id").val(item.birim_id);
                    }
                });
            }
            $("#sahadaki_urunlerin_bilgileri_modal").modal("hide");
        });

        $("body").off("click", "#sahadaki_urunlerin_bilgileri_modal_kapat").on("click", "#sahadaki_urunlerin_bilgileri_modal_kapat", function () {
            $("#sahadaki_urunlerin_bilgileri_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "sahadaki_konteynerleri_getir_modal1") {
    ?>
    <div class="modal fade" id="sahadaki_konteynerler_modal1" data-backdrop="static"
         data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 100%; max-width: 100%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="sahadaki_konteynerler_modal1_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>SAHADAKİ BOŞ KONTEYNERLER
                            </div>
                        </div>
                        <div class="modal-body">
                            <table class="table table-sm table-bordered w-100 display nowrap"
                                   style="cursor:pointer;font-size: 13px;"
                                   id="arac_girisleri_list">
                                <thead>
                                <tr>
                                    <th>Giriş Tarihi</th>
                                    <th>Konteyner No</th>
                                    <th id="click1">Cari Adı</th>
                                    <th>Referans No</th>
                                    <th>Beyanname No</th>
                                    <th>Konteyner Tipi</th>
                                    <th>Durumu</th>
                                    <th>Plaka No</th>
                                    <th>Sürücü Adı</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function () {
            $("#sahadaki_konteynerler_modal1").modal("show");

            setTimeout(function () {
                $("#click1").trigger("click");
            }, 500);

            var table = $('#arac_girisleri_list').DataTable({
                scrollY: '30vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "giris_tarihi"},
                    {'data': "konteyner_no"},
                    {'data': "cari_adi"},
                    {'data': "referans"},
                    {'data': "beyanname_no"},
                    {'data': "konteyner_tipi"},
                    {'data': "durumu"},
                    {'data': "plaka_no"},
                    {'data': "surucu_adi"}
                ],
                createdRow: function (row, data) {
                    $(row).addClass("sahadaki_konteynerleri_getir_list_selected1");
                    $(row).find('td').css('text-align', 'left');
                    $(row).attr("data-id", data.id);
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $.get("depo/controller/puantor_controller/sql.php?islem=sahadaki_konteynerleri_getir_sql2", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                }
            })
        });

        $("body").off("click", ".sahadaki_konteynerleri_getir_list_selected1").on("click", ".sahadaki_konteynerleri_getir_list_selected1", function () {
            let id = $(this).attr("data-id");
            $.get("depo/controller/puantor_controller/sql.php?islem=guncellenecek_konteyner_girisleri_getir_sql", {id: id}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#1konteyner_no").val(item.konteyner_no);
                    $("#1konteyner_no").attr("data-id", item.id);
                }
            })
            $("#sahadaki_konteynerler_modal1").modal("hide");
        });

        $("body").off("click", "#sahadaki_konteynerler_modal1_kapat").on("click", "#sahadaki_konteynerler_modal1_kapat", function () {
            $("#sahadaki_konteynerler_modal1").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "sahadaki_konteynerleri_getir_modal2") {
    ?>
    <div class="modal fade" id="sahadaki_konteynerler_modal2" data-backdrop="static"
         data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 100%; max-width: 100%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="sahadaki_konteynerler_modal2_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>SAHADAKİ BOŞ KONTEYNERLER
                            </div>
                        </div>
                        <div class="modal-body">
                            <table class="table table-sm table-bordered w-100 display nowrap"
                                   style="cursor:pointer;font-size: 13px;"
                                   id="sahadaki_urun_list">
                                <thead>
                                <tr>
                                    <th>Giriş Tarihi</th>
                                    <th>Konteyner No</th>
                                    <th id="click1">Cari Adı</th>
                                    <th>Referans No</th>
                                    <th>Beyanname No</th>
                                    <th>Konteyner Tipi</th>
                                    <th>Durumu</th>
                                    <th>Plaka No</th>
                                    <th>Sürücü Adı</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function () {
            $("#sahadaki_konteynerler_modal2").modal("show");

            setTimeout(function () {
                $("#click1").trigger("click");
            }, 500);

            var table = $('#sahadaki_urun_list').DataTable({
                scrollY: '30vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "giris_tarihi"},
                    {'data': "konteyner_no"},
                    {'data': "cari_adi"},
                    {'data': "referans"},
                    {'data': "beyanname_no"},
                    {'data': "konteyner_tipi"},
                    {'data': "durumu"},
                    {'data': "plaka_no"},
                    {'data': "surucu_adi"}
                ],
                createdRow: function (row, data) {
                    $(row).addClass("sahadaki_konteynerleri_getir_list_selected1");
                    $(row).find('td').css('text-align', 'left');
                    $(row).attr("data-id", data.id);
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $.get("depo/controller/puantor_controller/sql.php?islem=sahadaki_konteynerleri_getir_sql2", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                }
            })
        });

        $("body").off("click", ".sahadaki_konteynerleri_getir_list_selected1").on("click", ".sahadaki_konteynerleri_getir_list_selected1", function () {
            let id = $(this).attr("data-id");
            $.get("depo/controller/puantor_controller/sql.php?islem=guncellenecek_konteyner_girisleri_getir_sql", {id: id}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#2konteyner_no").val(item.konteyner_no);
                    $("#2konteyner_no").attr("data-id", item.id);
                }
            });
            $("#sahadaki_konteynerler_modal2").modal("hide");
        });

        $("body").off("click", "#sahadaki_konteynerler_modal2_kapat").on("click", "#sahadaki_konteynerler_modal2_kapat", function () {
            $("#sahadaki_konteynerler_modal2").modal("hide");
        });

    </script>
    <?php
}