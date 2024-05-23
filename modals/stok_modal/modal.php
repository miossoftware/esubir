<?php
date_default_timezone_set('Europe/Istanbul');
session_start();
$islem = $_GET["islem"];
if ($islem == "stok_ekle_modal") {
    ?>
    <div class="modal fade" id="stok_ekle_modali" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog" style="width: 80%; max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Yeni Stok Kart Tanımla
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>YENİ STOK KART TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <nav class="nav nav-pills flex-column flex-sm-row">
                                <a class="flex-sm-fill text-sm-center nav-link active stok_page_color"
                                   aria-current="page"
                                   id="stok_genel_bilgileri">Stok Bilgileri</a>
                                <a class="flex-sm-fill text-sm-center nav-link stok_page_color"
                                   id="stok_detay_bilgileri">Detay
                                    Bilgi</a>
                            </nav>
                            <div class="col-12 row stok_kart_pagination">
                                <div class="col-4">
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Stok Türü</label>
                                        </div>
                                        <div class="col-7">
                                            <select class="custom-select custom-select-sm" id="stok_turu">
                                                <option value="">Seçiniz...</option>
                                                <option value="1">Malzeme</option>
                                                <option value="2">Demirbaş</option>
                                                <option value="3">Hizmet</option>
                                                <option value="4">Sarf Malzeme</option>
                                                <option value="5">Ticari Mal</option>
                                                <option value="6">Ürün</option>
                                                <option value="7">Yarım Mamül</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Stok Kodu</label>
                                        </div>
                                        <div class="col-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="stok_kodu">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="stok_son_no_getir"><i
                                                                class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Stok Adı</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="text" class="form-control form-control-sm" id="stok_adi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Barkod</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="text" class="form-control form-control-sm" id="barkod">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Marka</label>
                                        </div>
                                        <div class="col-7">
                                            <select class="custom-select custom-select-sm" id="marka">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Model</label>
                                        </div>
                                        <div class="col-7">
                                            <select class="custom-select custom-select-sm" id="model">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Birim</label>
                                        </div>
                                        <div class="col-7">
                                            <select class="custom-select custom-select-sm" id="birim">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Döviz Türü</label>
                                        </div>
                                        <div class="col-7">
                                            <select class="custom-select custom-select-sm" id="doviz_tur">
                                                <option value="">Seçiniz...</option>
                                                <option value="TL">TL</option>
                                                <option value="EURO">EURO</option>
                                                <option value="USD">USD</option>
                                                <option value="GBP">GBP</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Tevkifat Kodu</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="text" class="form-control form-control-sm" id="tevkifat_kodu">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Tevkifat (%)</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="number" class="form-control form-control-sm"
                                                   id="tevkifat_yuzde">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Stok Ana Grubu</label>
                                        </div>
                                        <div class="col-7">
                                            <select class="custom-select custom-select-sm" id="stok_ana_grupid">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Stok Alt Grubu</label>
                                        </div>
                                        <div class="col-7">
                                            <select class="custom-select custom-select-sm" id="stok_alt_grupid">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Renk</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="text" class="form-control form-control-sm" id="renk">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>En (cm)</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="number" class="form-control form-control-sm" id="en">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Kalınlık</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="number" class="form-control form-control-sm" id="kalinlik">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Kritik Limit Min.</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="number" class="form-control form-control-sm"
                                                   id="kritik_limit_min">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Boy (cm)</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="number" class="form-control form-control-sm" id="boy">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Öz Kütle</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="number" class="form-control form-control-sm" id="oz_kutle">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Kritik Limit Max.</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="number" class="form-control form-control-sm"
                                                   id="kritik_limit_max">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>KDV Oran (%)</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="number" class="form-control form-control-sm" id="kdv_orani">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Alış Fiyatı</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="number" class="form-control form-control-sm" id="alis_fiyat">
                                        </div>
                                    </div>
                                    <!--                                    <div class="form-group row">-->
                                    <!--                                        <div class="col-5">-->
                                    <!--                                            <label>Alış Fiyatı (KDV)</label>-->
                                    <!--                                        </div>-->
                                    <!--                                        <div class="col-7">-->
                                    <!--                                            <input type="number" class="form-control form-control-sm" id="alis_kdv">-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Kar (%)</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="number" class="form-control form-control-sm" id="kar">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>İndirim (%)</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="number" class="form-control form-control-sm" id="indirim">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Satış Fiyatı</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="number" class="form-control form-control-sm" id="satis_fiyat">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Stok Miktarı</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="number" disabled class="form-control form-control-sm"
                                                   id="stok_miktari">
                                        </div>
                                    </div>
                                    <div class="form-group row" id="prim_loj">
                                        <div class="col-5">
                                            <label>Yol Primi</label>
                                        </div>
                                        <div class="col-7">
                                            <input type="text" style="text-align: right" disabled
                                                   class="form-control form-control-sm"
                                                   id="yol_primi">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-danger btn-sm" id="modal_kapat">Kapat</button>
                                    <button class="btn btn-success btn-sm" id="stok_kart_kaydet">Kaydet</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>

            $("body").off("focusout", "#yol_primi").on("focusout", "#yol_primi", function () {
                var val = $(this).val();
                val = val.replace(/\./g, "").replace(",", ".");
                val = parseFloat(val);
                if (isNaN(val)) {
                    val = 0;
                }
                val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})
                $(this).val(val);
            });

            $('input').click(function () {
                $(this).select();
            });
            $("body").off("change", "#marka").on("change", "#marka", function () {
                var id = $(this).val();
                $.get("controller/stok_controller/sql.php?islem=markaya_ait_model_getir", {id: id}, function (result) {
                    if (result != 2) {
                        $("#model").html("");
                        $("#model").append("" +
                            "<option value=''>Seçiniz...</option>" +
                            "");
                        var json = JSON.parse(result);
                        json.forEach(function (item) {
                            var model_adi = item.model_adi;
                            $("#model").append("" +
                                "<option value='" + item.id + "'>" + model_adi.toUpperCase() + "</option>" +
                                "");
                        })
                    } else {
                        $("#model").html("");
                        $("#model").append("" +
                            "<option value=''>Seçiniz...</option>" +
                            "");
                    }
                })
            })

            $("body").off("click", "#stok_son_no_getir").on("click", "#stok_son_no_getir", function () {
                let stok_kodu = $("#stok_kodu").val();
                $.get("controller/stok_controller/sql.php?islem=stok_kod_getir_sql", {stok_kodu: stok_kodu}, function (res) {
                    if (res != 2) {
                        var kod = res;
                        $("#stok_kodu").val(kod.toUpperCase());
                    }
                })
            });

            $(document).ready(function () {
                $("#stok_ekle_modali").modal("show");


                $.get("controller/stok_controller/sql.php?islem=birimleri_getir", function (result) {
                    if (result != 2) {
                        var json = JSON.parse(result);
                        json.forEach(function (item) {
                            var birimAdi = item.birim_adi;
                            $("#birim").append("" +
                                "<option value='" + item.id + "'>" + birimAdi.toUpperCase() +
                                "</option>" +
                                ""
                            )
                            ;
                        })
                    }
                })

                $.get("controller/stok_controller/sql.php?islem=ana_grup_getir", function (result) {
                    if (result != 2) {
                        var json = JSON.parse(result);
                        json.forEach(function (item) {
                            var anaGrupAdi = item.ana_grup_adi;
                            $("#stok_ana_grupid").append("" +
                                "<option value='" + item.id + "'>" + anaGrupAdi.toUpperCase() +
                                "</option>" +
                                ""
                            );
                        })
                    }
                });
                $.get("controller/stok_controller/sql.php?islem=marka_listesi_getir", function (result) {
                    if (result != 2) {
                        var json = JSON.parse(result);
                        json.forEach(function (item) {
                            var markaAdi = item.marka_adi;
                            $("#marka").append("" +
                                "<option value='" + item.id + "'>" + markaAdi.toUpperCase() +
                                "</option>" +
                                ""
                            );
                        })
                    }
                });
            });

            $("body").off("change", "#stok_ana_grupid").on("change", "#stok_ana_grupid", function () {
                var id = $(this).val();
                $.get("controller/stok_controller/sql.php?islem=anagrup_ait_alt_grup_getir", {id: id}, function (result) {
                    $("#stok_alt_grupid").html("");
                    $("#stok_alt_grupid").append("" +
                        "<option value=''>Seçiniz...</option>" +
                        "");
                    if (result != 2) {
                        var json = JSON.parse(result);
                        json.forEach(function (item) {
                            var altgrupAdi = item.altgrup_adi;
                            $("#stok_alt_grupid").append("" +
                                "<option value='" + item.id + "'>" + altgrupAdi.toUpperCase() + "</option>" +
                                "");
                        });
                    }
                })
                if (id == 1) {
                    $("#yol_primi").prop("disabled", false);
                } else {
                    $("#yol_primi").prop("disabled", true);
                }
            });

            $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
                $("#stok_ekle_modali").modal("hide");
            })

            $("body").off("click", "#stok_genel_bilgileri").on("click", "#stok_genel_bilgileri", function () {
                $(".stok_page_color").removeClass("active");
                $(this).addClass("active");
                $.get("modals/stok_modal/modal_page.php?islem=stok_bilgileri_getir_page", function (getModal) {
                    $(".stok_kart_pagination").html("");
                    $(".stok_kart_pagination").html(getModal);
                });
            });


            $("body").off("click", "#stok_kart_kaydet").on("click", "#stok_kart_kaydet", function () {
                var stok_turu = $("#stok_turu").val();
                var stok_kodu = $("#stok_kodu").val();
                var yol_primi = $("#yol_primi").val();
                yol_primi = yol_primi.replace(/\./g, "").replace(",", ".");
                yol_primi = parseFloat(yol_primi);
                var stok_adi = $("#stok_adi").val();
                var barkod = $("#barkod").val();
                var marka = $("#marka").val();
                var model = $("#model").val();
                var birim = $("#birim").val();
                var stok_alt_grupid = $("#stok_alt_grupid").val();
                var stok_ana_grupid = $("#stok_ana_grupid").val();
                var doviz_tur = $("#doviz_tur").val();
                var renk = $("#renk").val();
                var kalinlik = $("#kalinlik").val();
                var kritik_limit_min = $("#kritik_limit_min").val();
                var boy = $("#boy").val();
                var oz_kutle = $("#oz_kutle").val();
                var kritik_limit_max = $("#kritik_limit_max").val();
                var kdv_orani = $("#kdv_orani").val();
                var alis_fiyat = $("#alis_fiyat").val();
                // var alis_kdv = $("#alis_kdv").val();
                var kar = $("#kar").val();
                var indirim = $("#indirim").val();
                var satis_fiyat = $("#satis_fiyat").val();
                var stok_miktari = $("#stok_miktari").val();
                var en = $("#en").val();
                var tevkifat_kodu = $("#tevkifat_kodu").val();
                var tevkifat_yuzde = $("#tevkifat_yuzde").val();
                if (stok_alt_grupid == "" || stok_ana_grupid == "") {
                    Swal.fire(
                        'Uyarı!',
                        'Stok Grupları Boş Kalamaz',
                        'warning'
                    );
                } else if (birim == "" || birim == null) {
                    Swal.fire(
                        'Uyarı!',
                        'Birim Boş Kalamaz',
                        'warning'
                    );
                } else if (stok_kodu == null || stok_kodu == "") {
                    Swal.fire(
                        'Uyarı!',
                        'Stok Kodu Boş Kalamaz',
                        'warning'
                    );
                } else {
                    $.ajax({
                        url: "controller/stok_controller/sql.php?islem=stok_ekle",
                        type: "POST",
                        data: {
                            tevkifat_kodu: tevkifat_kodu,
                            tevkifat_yuzde: tevkifat_yuzde,
                            stok_turu: stok_turu,
                            stok_kodu: stok_kodu,
                            stok_adi: stok_adi,
                            barkod: barkod,
                            marka: marka,
                            model: model,
                            birim: birim,
                            yol_primi: yol_primi,
                            stok_alt_grupid: stok_alt_grupid,
                            stok_ana_grupid: stok_ana_grupid,
                            doviz_tur: doviz_tur,
                            renk: renk,
                            kalinlik: kalinlik,
                            kritik_limit_min: kritik_limit_min,
                            boy: boy,
                            oz_kutle: oz_kutle,
                            kritik_limit_max: kritik_limit_max,
                            kdv_orani: kdv_orani,
                            alis_fiyat: alis_fiyat,
                            // alis_kdv: alis_kdv,
                            kar: kar,
                            indirim: indirim,
                            satis_fiyat: satis_fiyat,
                            stok_miktari: stok_miktari,
                            en: en
                        },
                        success: function (result) {
                            if (result != 2) {
                                if (result == 300) {

                                    Swal.fire(
                                        'Uyarı!',
                                        'Bu Stok Daha Önce Kaydedilmiştir',
                                        'warning'
                                    );
                                } else {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Stok Kartı Kayıt Edildi',
                                        'success'
                                    );
                                    $.get("view/add_stok_page.php", function (getList) {
                                        $(".modal-icerik").html("");
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("view/add_stok_page.php", function (getList) {
                                        $(".admin-modal-icerik").html("");
                                        $(".admin-modal-icerik").html(getList);
                                    })
                                }
                            } else {
                                Swal.fire(
                                    'Oops...',
                                    'Bilinmeyen Bir Hata Oluştu',
                                    'error'
                                );
                            }
                        }
                    });
                }
            });

            $("body").off("click", "#stok_detay_bilgileri").on("click", "#stok_detay_bilgileri", function () {
                $(".stok_page_color").removeClass("active");
                $(this).addClass("active");
                $.get("modals/stok_modal/modal_page.php?islem=stok_detay_bilgileri_page", function (getModal) {
                    $(".stok_kart_pagination").html("");
                    $(".stok_kart_pagination").html(getModal);
                });
            });
        </script>
    <?php
}