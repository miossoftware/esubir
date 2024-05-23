<?php
date_default_timezone_set('Europe/Istanbul');
session_start();
$islem = $_GET["islem"];
if ($islem == "stok_detay_bilgileri_page") {
    ?>
    <div class="col-12 row">
        <div class="col-6">
            <div class="form-group row">
                <div class="col-4">
                    <label>Açıklama</label>
                </div>
                <div class="col-8">
                    <textarea class="form-control form-control-sm" id="" cols="30" rows="10"></textarea>
                </div>
            </div>
        </div>
        <div class="col-6 row">
            <div class="row align-items-center ">
                <div class="col-auto">
                    <img src="assets/img/mersin-teknopark-epromnet-975346.jpg" alt="Resim Açıklaması"
                         class="img-fluid">
                </div>
                <div class="col-auto d-grid gap-2">
                    <button class="btn btn-success btn-sm me-2">Kaydet</button>
                    <button class="btn btn-danger btn-sm">Temizle</button>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-danger btn-sm" id="modal_kapat">Kapat</button>
            <button class="btn btn-success btn-sm">Kaydet</button>
        </div>
    </div>
    <script>

        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#stok_ekle_modali").modal("hide");
        })
    </script>
    <?php
}
if ($islem == "stok_bilgileri_getir_page") {
    ?>
    <div class="col-4">
        <div class="form-group row">
            <div class="col-4">
                <label>Stok Türü</label>
            </div>
            <div class="col-8">
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
            <div class="col-4">
                <label>Stok Kodu</label>
            </div>
            <div class="col-8">
                <input type="text" class="form-control form-control-sm" id="stok_kodu">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>Stok Adı</label>
            </div>
            <div class="col-8">
                <input type="text" class="form-control form-control-sm" id="stok_adi">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>Barkod</label>
            </div>
            <div class="col-8">
                <input type="text" class="form-control form-control-sm" id="barkod">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>Marka</label>
            </div>
            <div class="col-8">
                <select class="custom-select custom-select-sm" id="marka">
                    <option value="">Seçiniz...</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>Model</label>
            </div>
            <div class="col-8">
                <select class="custom-select custom-select-sm" id="model">
                    <option value="">Seçiniz...</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>Birim</label>
            </div>
            <div class="col-8">
                <select class="custom-select custom-select-sm" id="birim">
                    <option value="">Seçiniz...</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>Döviz Türü</label>
            </div>
            <div class="col-8">
                <select class="custom-select custom-select-sm" id="doviz_tur">
                    <option value="">Seçiniz...</option>
                    <option value="TL">TL</option>
                    <option value="EURO">EURO</option>
                    <option value="USD">USD</option>
                    <option value="GBP">GBP</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group row">
            <div class="col-4">
                <label>Stok Ana Grubu</label>
            </div>
            <div class="col-8">
                <select class="custom-select custom-select-sm" id="stok_ana_grupid">
                    <option value="">Seçiniz...</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>Stok Alt Grubu</label>
            </div>
            <div class="col-8">
                <select class="custom-select custom-select-sm" id="stok_alt_grupid">
                    <option value="">Seçiniz...</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>Renk</label>
            </div>
            <div class="col-8">
                <input type="text" class="form-control form-control-sm" id="renk">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>En (cm)</label>
            </div>
            <div class="col-8">
                <input type="number" class="form-control form-control-sm" id="en">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>Kalınlık</label>
            </div>
            <div class="col-8">
                <input type="number" class="form-control form-control-sm" id="kalinlik">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>Kritik Limit Min.</label>
            </div>
            <div class="col-8">
                <input type="number" class="form-control form-control-sm" id="kritik_limit_min">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>Boy (cm)</label>
            </div>
            <div class="col-8">
                <input type="number" class="form-control form-control-sm" id="boy">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>Öz Kütle</label>
            </div>
            <div class="col-8">
                <input type="number" class="form-control form-control-sm" id="oz_kutle">
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group row">
            <div class="col-4">
                <label>Kritik Limit Max.</label>
            </div>
            <div class="col-8">
                <input type="number" class="form-control form-control-sm" id="kritik_limit_max">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>KDV Oran (%)</label>
            </div>
            <div class="col-8">
                <input type="number" class="form-control form-control-sm" id="kdv_orani">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>Alış Fiyatı</label>
            </div>
            <div class="col-8">
                <input type="number" class="form-control form-control-sm" id="alis_fiyat">
            </div>
        </div>
        <!--        <div class="form-group row">-->
        <!--            <div class="col-4">-->
        <!--                <label>Alış Fiyatı (KDV)</label>-->
        <!--            </div>-->
        <!--            <div class="col-8">-->
        <!--                <input type="number" class="form-control form-control-sm" id="alis_kdv">-->
        <!--            </div>-->
        <!--        </div>-->
        <div class="form-group row">
            <div class="col-4">
                <label>Kar (%)</label>
            </div>
            <div class="col-8">
                <input type="number" class="form-control form-control-sm" id="kar">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>İndirim (%)</label>
            </div>
            <div class="col-8">
                <input type="number" class="form-control form-control-sm" id="indirim">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>Satış Fiyatı</label>
            </div>
            <div class="col-8">
                <input type="number" class="form-control form-control-sm" id="satis_fiyat">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>Stok Miktarı</label>
            </div>
            <div class="col-8">
                <input type="number" disabled class="form-control form-control-sm" id="stok_miktari">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger btn-sm" id="modal_kapat">Kapat</button>
        <button class="btn btn-success btn-sm" id="stok_kart_kaydet">Kaydet</button>
    </div>
    <script>
        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#stok_ekle_modali").modal("hide");
        })

        $("body").off("click", "#stok_kart_kaydet").on("click", "#stok_kart_kaydet", function () {
            var stok_turu = $("#stok_turu").val();
            var stok_kodu = $("#stok_kodu").val();
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

            $.ajax({
                url: "controller/stok_controller/sql.php?islem=stok_ekle",
                type: "POST",
                data: {
                    stok_turu: stok_turu,
                    stok_kodu: stok_kodu,
                    stok_adi: stok_adi,
                    barkod: barkod,
                    marka: marka,
                    model: model,
                    birim: birim,
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
                        Swal.fire(
                            'Başarılı!',
                            'Stok Kartı Kayıt Edildi',
                            'success'
                        );
                        $.get("view/add_stok_page.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        })
                    } else {
                        Swal.fire(
                            'Oops...',
                            'Bilinmeyen Bir Hata Oluştu',
                            'error'
                        );
                    }
                }
            });
        });
    </script>
    <?php
}
if ($islem == "stok_guncelle_modal") {
    $stok_kodu = $_GET["stok_kodu"];
    ?>
    <div class="modal fade" id="stok_ekle_modali" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog" style="width: 80%; max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Stok Kart Güncelle
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <nav class="nav nav-pills flex-column flex-sm-row">
                        <a class="flex-sm-fill text-sm-center nav-link active stok_page_color" aria-current="page"
                           id="stok_genel_bilgileri">Stok Bilgileri</a>
                        <a class="flex-sm-fill text-sm-center nav-link stok_page_color" id="stok_detay_bilgileri">Detay
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
                                    <input disabled value="<?= $stok_kodu ?>" type="text"
                                           class="form-control form-control-sm" id="stok_kodu">
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
                                    <select class="custom-select custom-select-sm model_bastir" id="model">
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
                                    <input type="text" class="form-control form-control-sm" id="tevkifat_yuzde">
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
                                    <input type="number" class="form-control form-control-sm" id="kritik_limit_min">
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
                                    <input type="number" class="form-control form-control-sm" id="kritik_limit_max">
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
                            <!--                            <div class="form-group row">-->
                            <!--                                <div class="col-5">-->
                            <!--                                    <label>Alış Fiyatı (KDV)</label>-->
                            <!--                                </div>-->
                            <!--                                <div class="col-7">-->
                            <!--                                    <input type="number" class="form-control form-control-sm" id="alis_kdv">-->
                            <!--                                </div>-->
                            <!--                            </div>-->
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
                                    <input type="text" style="text-align: right" class="form-control form-control-sm"
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
    <script>
        $('input').click(function () {
            $(this).select();
        });

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

        $(document).ready(function () {
            $.get("controller/stok_controller/sql.php?islem=modelleri_getir", {stok_kodu: "<?=$stok_kodu?>"}, function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        var modelAdi = item.model_adi;
                        $("#model").append("" +
                            "<option value='" + item.id + "'>" + modelAdi.toUpperCase() +
                            "</option>" +
                            ""
                        )
                        ;
                    })
                }
            })
            $.get("controller/stok_controller/sql.php?islem=alt_gruplari_getir", {stok_kodu: "<?=$stok_kodu?>"}, function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        var altgrupAdi = item.altgrup_adi;
                        $("#stok_alt_grupid").append("" +
                            "<option value='" + item.id + "'>" + altgrupAdi.toUpperCase() + "</option>" +
                            "");
                    })
                }
            })

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

            $.get("controller/stok_controller/sql.php?islem=stok_bilgileri_getir", {stok_kodu: "<?=$stok_kodu?>"}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    setTimeout(function () {
                        $("#stok_turu").val(item.stok_turu);
                        $("#stok_adi").val(item.stok_adi);
                        $("#barkod").val(item.barkod);
                        $("#marka").val(item.marka);
                        $("#birim").val(item.birim);
                        $("#stok_ana_grupid").val(item.stok_ana_grupid);
                        $("#doviz_tur").val(item.doviz_tur);
                        $("#renk").val(item.renk);
                        $("#kalinlik").val(item.kalinlik);
                        $("#kritik_limit_min").val(item.kritik_limit_min);
                        $("#boy").val(item.boy);
                        $("#oz_kutle").val(item.oz_kutle);
                        $("#kritik_limit_max").val(item.kritik_limit_max);
                        $("#kdv_orani").val(item.kdv_orani);
                        $("#alis_fiyat").val(item.alis_fiyat);
                        $("#alis_kdv").val(item.alis_kdv);
                        $("#kar").val(item.kar);
                        $("#indirim").val(item.indirim);
                        $("#satis_fiyat").val(item.satis_fiyat);
                        $("#stok_miktari").val(item.stok_miktari);
                        $("#en").val(item.en);
                        $("#stok_alt_grupid").val(item.stok_alt_grupid);
                        $("#tevkifat_kodu").val(item.tevkifat_kodu);
                        $("#tevkifat_yuzde").val(item.tevkifat_yuzde);
                        $("#model").val(item.model);
                        let yol_prim = item.yol_primi;
                        yol_prim = parseFloat(yol_prim);
                        yol_prim = yol_prim.toLocaleString("tr-TR", {
                            maximumFractionDigits: 2,
                            minimumFractionDigits: 2
                        })
                        $("#yol_primi").val(yol_prim);
                    }, 300);
                }
            })

            $("#stok_ekle_modali").modal("show");
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
            var stok_adi = $("#stok_adi").val();
            var yol_primi = $("#yol_primi").val();
            yol_primi = yol_primi.replace(/\./g, "").replace(",", ".");
            yol_primi = parseFloat(yol_primi);
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
            var alis_kdv = $("#alis_kdv").val();
            var kar = $("#kar").val();
            var indirim = $("#indirim").val();
            var satis_fiyat = $("#satis_fiyat").val();
            var stok_miktari = $("#stok_miktari").val();
            var en = $("#en").val();
            var tevkifat_kodu = $("#tevkifat_kodu").val();
            var tevkifat_yuzde = $("#tevkifat_yuzde").val();

            $.ajax({
                url: "controller/stok_controller/sql.php?islem=stok_guncelle",
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
                    yol_primi: yol_primi,
                    birim: birim,
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
                    alis_kdv: alis_kdv,
                    kar: kar,
                    indirim: indirim,
                    satis_fiyat: satis_fiyat,
                    stok_miktari: stok_miktari,
                    en: en
                },
                success: function (result) {
                    if (result != 2) {
                        Swal.fire(
                            'Başarılı!',
                            'Stok Kartı Kayıt Edildi',
                            'success'
                        );
                        $.get("view/add_stok_page.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        })
                    } else {
                        Swal.fire(
                            'Oops...',
                            'Bilinmeyen Bir Hata Oluştu',
                            'error'
                        );
                    }
                }
            });
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
if ($islem == "stoklari_getir_acilis") {
    ?>
    <div class="modal fade" data-backdrop="static" id="fatura_stoklari_getir_modal_getir"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 85%; max-width: 85%;">
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
            $("#fatura_stoklari_getir_modal_getir").modal("show");
            var stok_table = $('#fatura_stok_liste').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': 'stok_kodu'},
                    {'data': 'stok_adi'},
                ],
                createdRow: function (row, data) {
                    $(row).attr("data-id", data.id)
                    $(row).addClass("stock_select");
                    $(row).find("td").css("text-align", "left");
                }
            })
            $.get("controller/alis_controller/sql.php?islem=stok_listesi_getir", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    let basilacak = [];
                    json.forEach(function (item) {
                        let newRow = {
                            'stok_kodu': item.stok_kodu,
                            'stok_adi': item.stok_adi,
                            'id': item.id
                        };
                        basilacak.push(newRow);
                    });
                    stok_table.rows.add(basilacak).draw(false);
                }
            });
            $("body").off("click", ".stock_select").on("click", ".stock_select", function () {
                var id = $(this).attr("data-id");
                $.get("controller/alis_controller/sql.php?islem=secilen_stok_bilgileri", {id: id}, function (result) {
                    var item = JSON.parse(result);
                    $(".stok_adi_getir").val(item.stok_adi);
                    $(".stok_kodu_getir").val(item.stok_kodu);
                    $(".stok_kodu_getir").attr("data-id", item.id);
                    $(".stok_acilis_gelecek_birim").val(item.birim);
                    $(".ust_alis_fiyat").val(item.alis_fiyat);
                    $("#fatura_stoklari_getir_modal_getir").modal("hide");
                })
            });

        });

        $("body").off("click", "#modal_kapat1").on("click", "#modal_kapat1", function () {
            $("#fatura_stoklari_getir_modal_getir").modal("hide");
        });

    </script>
    <?php
}