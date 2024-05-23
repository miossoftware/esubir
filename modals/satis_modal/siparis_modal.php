<?php


$islem = $_GET["islem"];

if ($islem == "satis_siparis_olustur") {

    ?>

    <div class="modal fade" id="satis_siparis_olustur" data-backdrop="static"

         data-bs-keyboard="false" role="dialog">

    <div class="modal-dialog modal-sm"

         style="width: 100%; max-width: 100%;">

        <div class="modal-content">

            <div class="modal-header text-white p-2">

                <button type="button" class="btn-close btn-close-white modal_kapali" id="modal_kapat"

                        aria-label="Close"></button>

            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head" style='background-color:#9DB2BF'>
                        <div class="ibox-title" style='color:white; font-weight:bold;'>ALINAN SİPARİŞ</div>
                    </div>
                    <div class="modal-body" style="max-height: 75vh; overflow: auto;">

                        <div id="cari_getir_satis_siparis"></div>

                        <div id="stok_adi_getir_satis_siparis"></div>

                        <div class="col-md-12 row">

                            <div class="col-4">

                                <div class="form-group row">

                                    <div class="col-md-4 mt-1">

                                        <label>Cari Kodu</label>

                                    </div>

                                    <div class="col-8">

                                        <div class="input-group mb-3">

                                            <input type="text" class="form-control form-control-sm siparis_secilen_cari"

                                                   aria-describedby="basic-addon1" id="siparis_cari_id">

                                            <div class="input-group-append">

                                                <button class="btn btn-warning btn-sm" id="cari_getir_siparis_button"><i

                                                            class="fa fa-ellipsis-h"></i></button>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <div class="col-md-4 mt-1">

                                        Cari Adı

                                    </div>

                                    <div class="col-md-8">

                                        <input type="text" class="form-control form-control-sm cari_adi_siparis"
                                               disabled>

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <div class="col-md-4 mt-1">

                                        Telefon

                                    </div>

                                    <div class="col-md-8">

                                        <input type="text" class="form-control form-control-sm cari_telefon_siparis"
                                               disabled>

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <div class="col-md-4 mt-1">

                                        Yetkili

                                    </div>

                                    <div class="col-md-8">

                                        <input type="text" class="form-control form-control-sm cari_yetkili_adi"
                                               disabled>

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <div class="col-md-4 mt-1">

                                        Yetkili Cep

                                    </div>

                                    <div class="col-md-8">

                                        <input type="text" class="form-control form-control-sm yetkili_cep_siparis"
                                               disabled>

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <div class="col-md-4 mt-1">

                                        Vergi Daire

                                    </div>

                                    <div class="col-md-8">

                                        <input type="text" class="form-control form-control-sm siparis_vergi_daire"
                                               disabled>

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <div class="col-md-4 mt-1">

                                        Vergi No

                                    </div>

                                    <div class="col-md-8">

                                        <input type="text" class="form-control form-control-sm siparis_vergi_no"
                                               disabled>

                                    </div>

                                </div>

                            </div>

                            <div class="col-4">

                                <div class="form-group row">

                                    <div class="col-md-4 mt-1">

                                        Cari Adres

                                    </div>

                                    <div class="col-md-8">

                                    <textarea class="form-control form-control-sm siparis_cari_adres" disabled id=""
                                              cols="30"

                                              rows="3"></textarea>

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <div class="col-md-4 mt-1">

                                        Sipariş No

                                    </div>

                                    <div class="col-md-8">

                                        <input type="number" class="form-control form-control-sm son_siparis_no"
                                               id="siparis_no">

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <div class="col-md-4 mt-1">

                                        Sipariş Tarihi

                                    </div>

                                    <div class="col-md-8">

                                        <input type="date" value="<?= date("Y-m-d") ?>"
                                               class="form-control form-control-sm" id="siparis_tarihi">

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <div class="col-md-4 mt-1">

                                        Termin Tarihi

                                    </div>

                                    <div class="col-md-8">

                                        <input type="date" value="<?= date("Y-m-d") ?>"
                                               class="form-control form-control-sm" id="termin_tarihi">

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <div class="col-md-4 mt-1">

                                        Depo Adı

                                    </div>

                                    <div class="col-md-8">

                                        <select class="custom-select custom-select-sm" id="depo_id">

                                            <option value="">Seçiniz...</option>

                                        </select>

                                    </div>

                                </div>

                            </div>

                            <div class="col-4">

                                <div class="form-group row">

                                    <div class="col-3">

                                        <label>Döviz Türü</label>

                                    </div>

                                    <div class="col-9 row no-gutters">

                                        <div class="col">

                                            <select class="custom-select custom-select-sm" id="doviz_tur">

                                                <option value="">Seçiniz...</option>

                                                <option value="TL" selected>TL</option>

                                                <option value="USD" id="usd_bas_siparis">USD</option>

                                                <option value="EURO" id="euro_bas_siparis">EURO</option>

                                                <option value="GBP" id="gbp_bas_siparis">GBP</option>

                                            </select>

                                        </div>

                                        <div class="col">

                                            <input type="text" class="form-control form-control-sm" id="kur_fiyat"
                                                   value="1,00">

                                        </div>

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <div class="col-3">

                                        <label>Açıklama</label>

                                    </div>

                                    <div class="col-9">

                                        <textarea class="form-control form-control-sm" style="resize: none"
                                                  id="aciklama" cols="30" rows="8"></textarea>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="fatura_icerik">

                            <div class="card">

                                <div class="card-body">

                                    <div class="col-12 row mt-2 no-gutters">

                                        <div class="col-md-1">

                                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;Stok
                                                Adı</label>

                                            <div class="input-group">

                                                <input type="text" class="form-control form-control-sm stok_adi_siparis"

                                                       placeholder="Stok Adı">

                                                <div class="input-group-append">

                                                    <button class="btn btn-warning btn-sm"

                                                            id="stok_adi_siparis">

                                                        <i class="fa fa-ellipsis-h"></i>

                                                    </button>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-1">

                                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;Miktar</label>

                                            <input style="text-align: right" type="text"

                                                   class="form-control form-control-sm mx-2 miktar"

                                                   placeholder="Miktar" id="miktar">

                                        </div>

                                        <div class="col-md-1">

                                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Birim</label>

                                            <select class="custom-select custom-select-sm mx-1 gelecek_birim"
                                                    id="birim_id">

                                                <option value="">Birim</option>

                                            </select>

                                        </div>

                                        <div class="col-md-1">

                                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Birim
                                                Fiyat</label>

                                            <input type="text" style="text-align: right"

                                                   class="form-control form-control-sm mx-2 birim_fiyat"

                                                   placeholder="Birim Fiyat" id="birim_fiyat">

                                        </div>

                                        <div class="col-md-1">

                                            <label style="font-size: 10px; font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kdv(%)</label>

                                            <input type="number" placeholder="KDV(%)" style="text-align: right"

                                                   class="form-control form-control-sm mx-3 kdv_yuzde" id="kdv">

                                        </div>

                                        <div class="col-md-1">

                                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;İskonto(%)</label>

                                            <input type="number" placeholder="İskonto(%)" style="text-align: right"

                                                   class="form-control form-control-sm mx-4" id="iskonto_yuzde">

                                        </div>

                                        <div class="col-md-1">

                                            <label style="font-weight: bold; font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tevkifat

                                                Kodu</label>

                                            <input type="text" placeholder="Tevkifat Kodu" style="text-align: right"

                                                   class="form-control form-control-sm mx-4 tevkifat_kodu"

                                                   id="tevkifat_kodu">

                                        </div>

                                        <div class="col-md-1">

                                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tevkifat(%)</label>

                                            <input type="number" placeholder="Tevkifat(%)" style="text-align: right"

                                                   class="form-control form-control-sm mx-4 tevkifat_yuzde"

                                                   id="tevkifat_yuzde">

                                        </div>

                                        <div class="col-md-1">

                                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tevkifat

                                                Tutar</label>

                                            <input type="number" placeholder="Tevkifat Tutar" style="text-align: right"

                                                   class="form-control form-control-sm mx-4" id="tevkifat_tutar">

                                        </div>

                                        <div class="col-md-1">

                                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Toplam

                                                Tutar</label>

                                            <input type="text" placeholder="Toplam" disabled style="text-align: right"

                                                   class="form-control form-control-sm mx-4" id="toplam_tutar">

                                        </div>

                                        <div class="col-md-2 row mt-4">

                                            <button style="width: 100% !important;" class="btn btn-success btn-sm mx-5"
                                                    id="alinan_siparis_ekle_button"><i

                                                        class="fa fa-plus"></i> Ekle

                                            </button>

                                            <button style="background-color: #F6FA70;width: 100% !important;"
                                                    class="btn btn-sm mx-5 mt-1" id="kaydi_guncelle_satis_siparis"><i

                                                        class="fa fa-refresh"></i> Kaydı Güncelle

                                            </button>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-md-12 mt-3">

                                <table class="table table-sm table-bordered w-100 display nowrap"

                                       style="cursor:pointer;font-size: 13px;"

                                       id="siparis_table_list">

                                    <thead>

                                    <tr>

                                        <th id="click12">Stok Kodu</th>

                                        <th>Stok</th>

                                        <th>Birim</th>

                                        <th>Miktar</th>

                                        <th>Birim Fiyat</th>

                                        <th>KDV</th>

                                        <th>KDV Tutar</th>

                                        <th>İskonto</th>

                                        <th>İskonto Tutarı</th>

                                        <th>Tevkifat Kodu</th>

                                        <th>Tevkifat Tutarı</th>

                                        <th>Toplam</th>

                                        <th>İşlem</th>

                                    </tr>

                                    </thead>

                                </table>

                            </div>

                            <div class="col-md-12 row">

                                <div class="col-8"></div>

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

                                            <table class="table table-sm table-bordered w-100 display nowrap">

                                                <thead>

                                                <tr>

                                                    <th>Döviz Karşılığı</th>

                                                </tr>

                                                </thead>

                                                <tbody>

                                                <tr>

                                                    <td class="doviz_ara_toplam_bas_siparis" style="text-align: right">
                                                        0,00 TL
                                                    </td>

                                                </tr>

                                                <tr>

                                                    <td class="doviz_kdv_toplam_bas_siparis" style="text-align: right">
                                                        0,00 TL
                                                    </td>

                                                </tr>

                                                <tr>

                                                    <td class="doviz_tevkifat_tutari_bas_siparis"
                                                        style="text-align: right">0,00 TL
                                                    </td>

                                                </tr>

                                                <tr>

                                                    <td class="doviz_iskonto_toplam_bas_siparis"
                                                        style="text-align: right">0,00 TL
                                                    </td>

                                                </tr>

                                                <tr>

                                                    <td class="doviz_genel_toplam_bas_siparis"
                                                        style="text-align: right">0,00 TL
                                                    </td>

                                                </tr>

                                                </tbody>

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

                                                    <td class="ara_toplam_bas_siparis" style="text-align: right">0,00
                                                        TL
                                                    </td>

                                                </tr>

                                                <tr>

                                                    <td class="kdv_toplam_bas_siparis" style="text-align: right">0,00
                                                        TL
                                                    </td>

                                                </tr>

                                                <tr>

                                                    <td class="tevkifat_tutari_bas_siparis" style="text-align: right">
                                                        0,00 TL
                                                    </td>

                                                </tr>

                                                <tr>

                                                    <td class="iskonto_toplam_bas_siparis" style="text-align: right">
                                                        0,00 TL
                                                    </td>

                                                </tr>

                                                <tr>

                                                    <td class="genel_toplam_bas_siparis" style="text-align: right">0,00
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

                    </div>
                </div>
                <div class="modal-footer">

                    <button class="btn btn-danger modal_kapali btn-sm"><i class="fa fa-close"></i> Vazgeç</button>

                    <button class="btn btn-success btn-sm" id="alinan_siparisi_olustur"><i

                                class="fa fa-plus"></i> Kaydet

                    </button>

                </div>

            </div>

        </div>

    </div>

    <script>
        $('input').click(function() {
            $(this).select();
        });
        var siparis_table = "";

        var arr = [];


        $(".stok_adi_siparis").keyup(function () {

            var stok_kodu = $(this).val();

            $.get("controller/alis_controller/sql.php?islem=stok_kodu_bilgileri_getir", {stok_kodu: stok_kodu}, function (result) {

                if (result != 2) {

                    var item = JSON.parse(result);

                    $(".gelecek_birim").val(item.birim);

                    $(".stok_adi_siparis").val(item.stok_adi);

                    $(".stok_adi_siparis").attr("data-id", item.id);

                    $(".kdv_yuzde").val(item.alis_kdv);

                    $(".tevkifat_kodu").val(item.tevkifat_kodu);

                    $(".birim_fiyat").val(item.alis_fiyat);

                    $(".tevkifat_yuzde").val(item.tevkifat_yuzde);

                    $("#fatura_stoklari_getir_modal_getir").modal("hide");

                    $(".miktar").focus();

                }

            })

        });


        $(".siparis_secilen_cari").keyup(function () {

            var this_val = $(this).val();

            $.get("controller/alis_controller/sql.php?islem=girilen_cari_kodu_bilgileri", {cari_kodu: this_val}, function (result) {

                if (result != 2) {

                    var item = JSON.parse(result);

                    var cari_id = item.id;

                    $.get("controller/satis_controller/sql.php?islem=satis_siparis_son_belge_no_cek", {cari_id: cari_id}, function (result) {

                        if (result != "") {

                            var item = JSON.parse(result);

                            $(".son_siparis_no").val(item)

                        } else {

                            $(".son_siparis_no").val("1");

                        }

                    })


                    var yetkiliAdi1 = item.yetkili_adi1;

                    var yetkiliAdi2 = item.yetkili_ad2;

                    var yetkiliTel1 = item.yetkili_tel1;

                    var yetkiliTel2 = item.yetkili_tel2;

                    var vergiDairesi = item.vergi_dairesi;

                    var vergiNo = item.vergi_no;

                    var adres = item.adres;

                    $(".cari_telefon_siparis").val(item.telefon);

                    $(".cari_adi_siparis").val((item.cari_adi).toUpperCase());

                    $(".siparis_secilen_cari").attr("data-id", item.id);

                    if (yetkiliAdi1 != null) {

                        $(".cari_yetkili_adi").val(yetkiliAdi1.toUpperCase());

                        $(".yetkili_cep_siparis").val(yetkiliTel1);

                    } else {

                        $(".cari_yetkili_adi").val(yetkiliAdi2.toUpperCase());

                        $(".yetkili_cep_siparis").val(yetkiliTel2);

                    }

                    if (vergiDairesi != "") {

                        $(".siparis_vergi_daire").val(vergiDairesi.toUpperCase());

                    }

                    $(".siparis_vergi_no").val(vergiNo);

                    $(".siparis_cari_adres").val(adres.toUpperCase());

                } else {


                    $(".cari_telefon_siparis").val("");

                    $(".cari_adi_siparis").val("");

                    $(".siparis_secilen_cari").attr("data-id", "");

                    $(".cari_yetkili_adi").val("");

                    $(".yetkili_cep_siparis").val("");

                    $(".son_siparis_no").val("");

                    $(".siparis_vergi_daire").val("");

                    $(".siparis_vergi_no").val("");

                    $(".siparis_cari_adres").val("");

                }

            });

        })


        $("body").off("click", "#alinan_siparisi_olustur").on("click", "#alinan_siparisi_olustur", function () {

            var siparis_id = $("#alinan_siparis_ekle_button").attr("data-id");

            var cari_id = $(".siparis_secilen_cari").attr("data-id");

            var siparis_no = $("#siparis_no").val();

            var siparis_tarihi = $("#siparis_tarihi").val();

            var termin_tarihi = $("#termin_tarihi").val();

            var depo_id = $("#depo_id").val();

            var aciklama = $("#aciklama").val();


            if (depo_id == "") {

                Swal.fire(
                    'Uyarı!',

                    'Lütfen Bir Depo Giriniz',

                    'warning'
                );

            } else {

                $.ajax({

                    url: "controller/satis_controller/sql.php?islem=satis_siparisi_guncelle_sql",

                    type: "POST",

                    data: {

                        cari_id: cari_id,

                        siparis_no: siparis_no,

                        siparis_tarihi: siparis_tarihi,

                        termin_tarihi: termin_tarihi,

                        depo_id: depo_id,

                        aciklama: aciklama,

                        id: siparis_id

                    },

                    success: function (result) {

                        if (result == 1) {

                            var implode = result.split(":");

                            var id = implode[1];

                            $("#faturaya_ekle").attr("data-id", id);

                            $(".shadow_buttons").hide();

                            $(".fatura_icerik").css("display", "block");

                            $.get("view/satis_siparis.php", function (getList) {

                                $(".modal-icerik").html("");

                                $(".modal-icerik").html(getList);

                            })

                            $.get("view/satis_siparis.php", function (getList) {

                                $(".admin-modal-icerik").html("");

                                $(".admin-modal-icerik").html(getList);

                            })

                            Swal.fire(
                                'Başarılı!',

                                'Sipariş Kaydedildi',

                                'success'
                            );

                            $("#satis_siparis_olustur").modal("hide");

                        } else {

                            Swal.fire(
                                'Oops...',

                                'Bilinmeyen Bir Hata Oluştu',

                                'error'
                            );

                        }

                    }

                })

            }

        });


        $("body").off("click", "#alinan_siparis_ekle_button").on("click", "#alinan_siparis_ekle_button", function () {

            var cari_id = $("#siparis_cari_id").attr("data-id");

            var doviz_tur = $("#doviz_tur").val();

            var kur_fiyat = $("#kur_fiyat").val();


            var stok_id = $(".stok_adi_siparis").attr("data-id");

            var birim_id = $("#birim_id").val();

            var miktar = $("#miktar").val();

            miktar = miktar.replace(/\./g, "").replace(",", ".");

            miktar = parseFloat(miktar);

            var birim_fiyat = $("#birim_fiyat").val();

            birim_fiyat = birim_fiyat.replace(/\./g, "").replace(",", ".");

            birim_fiyat = parseFloat(birim_fiyat);

            var kdv_orani = $("#kdv").val();

            var kdv_tutari = $("#kdv").attr("kdv_tutari");

            var iskonto = $("#iskonto_yuzde").val();

            var iskonto_tutari = $("#iskonto_yuzde").attr("iskonto_tutari");

            var tevkifat_kodu = $("#tevkifat_kodu").val();

            var tevkifat_yuzde = $("#tevkifat_yuzde").val();

            var toplam_tutar = $("#toplam_tutar").val();

            toplam_tutar = toplam_tutar.replace(/\./g, "").replace(",", ".");

            toplam_tutar = parseFloat(toplam_tutar);

            var tevkifat_tutari = $("#tevkifat_tutar").val();

            var tevkifat_doviz_tutari = $("#tevkifat_tutar").attr("doviz_tutari");

            var siparis_id = $("#alinan_siparis_ekle_button").attr("data-id");

            if (cari_id == null || stok_id == null) {

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

                    icon: 'warning',

                    title: 'Stok Ve Cari Boş Kalamaz'

                });

            } else if (toplam_tutar < 0) {

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

                })


                Toast.fire({

                    icon: 'warning',

                    title: 'Toplam Tutar Eksi Olamaz'

                });

            } else {

                $.ajax({

                    url: "controller/satis_controller/sql.php?islem=alinan_siparis_urun_ekle_sql",

                    type: "POST",

                    data: {

                        siparis_id: siparis_id,

                        cari_id: cari_id,

                        stok_id: stok_id,

                        birim_id: birim_id,

                        miktar: miktar,

                        birim_fiyat: birim_fiyat,

                        doviz_tur: doviz_tur,

                        kur_fiyat: kur_fiyat,

                        kdv_orani: kdv_orani,

                        kdv_tutari: kdv_tutari,

                        iskonto: iskonto,

                        iskonto_tutari: iskonto_tutari,

                        tevkifat_kodu: tevkifat_kodu,

                        tevkifat_yuzde: tevkifat_yuzde,

                        toplam_tutar: toplam_tutar,

                        tevkifat_tutari: tevkifat_tutari,

                        tevkifat_doviz_tutari: tevkifat_doviz_tutari,

                    },

                    success: function (result) {

                        if (result != 1) {

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

                                title: 'Ürün Eklendi'

                            });

                            var json = JSON.parse(result);

                            siparis_table.clear().draw(false);

                            json.forEach(function (item) {

                                $("#alinan_siparis_ekle_button").attr("data-id", item.siparis_id);

                                var iskonto_toplam = item.iskonto_toplam;

                                var kdv_toplam = item.kdv_toplam;

                                var ara_toplam = item.ara_toplam;

                                var genel_toplam = item.genel_toplam;

                                var tevkifat_toplam = item.tevkifat_toplam;


                                iskonto_toplam = parseFloat(iskonto_toplam);

                                kdv_toplam = parseFloat(kdv_toplam);

                                ara_toplam = parseFloat(ara_toplam);

                                genel_toplam = parseFloat(genel_toplam);

                                tevkifat_toplam = parseFloat(tevkifat_toplam);

                                var iskonto_yazi = iskonto_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                var kdv_yazi = kdv_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                var ara_toplam_yazi = ara_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                var genel_toplam_yazi = genel_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                var tevkifat_yazi = tevkifat_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                                var birimFiyat = item.birim_fiyat;

                                var parse_birim = parseFloat(birimFiyat);

                                var birim_fiyat = parse_birim.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                                var kdvTutari = item.kdv_tutari;

                                var parse_kdv = parseFloat(kdvTutari);

                                var kdv_fiyat = parse_kdv.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                                var iskontoTutari = item.iskonto_tutari;

                                var parse_iskonto = parseFloat(iskontoTutari);

                                var iskonto_tutari = parse_iskonto.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                                var tevkifatTutari = item.tevkifat_tutari;

                                var parse_tevkifat = parseFloat(tevkifatTutari);

                                var tevkifat_tutari = parse_tevkifat.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                                var toplamTutar = item.toplam_tutar;

                                var parse_toplam = parseFloat(toplamTutar);

                                var toplam_tutar = parse_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                                if ($("#doviz_tur").val() != "TL") {

                                    $(".doviz_iskonto_toplam_bas_siparis").html("");

                                    $(".doviz_iskonto_toplam_bas_siparis").html(iskonto_yazi + " " + item.doviz_tur);

                                    $(".doviz_kdv_toplam_bas_siparis").html("");

                                    $(".doviz_kdv_toplam_bas_siparis").html(kdv_yazi + " " + item.doviz_tur);

                                    $(".doviz_ara_toplam_bas_siparis").html("");

                                    $(".doviz_ara_toplam_bas_siparis").html(ara_toplam_yazi + " " + item.doviz_tur);

                                    $(".doviz_genel_toplam_bas_siparis").html("");

                                    $(".doviz_genel_toplam_bas_siparis").html(genel_toplam_yazi + " " + item.doviz_tur);

                                    $(".doviz_tevkifat_tutari_bas_siparis").html("");

                                    $(".doviz_tevkifat_tutari_bas_siparis").html(tevkifat_yazi + " " + item.doviz_tur);


                                    var doviz_kuru = $("#kur_fiyat").val();

                                    var tl_karsilik_iskonto = parse_iskonto * doviz_kuru;

                                    var tl_iskonto = tl_karsilik_iskonto.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                    var tl_karsilik_kdv = parse_kdv * doviz_kuru;

                                    var tl_kdv = tl_karsilik_kdv.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                    var tl_karsilik_ara_toplam = ara_toplam * doviz_kuru;

                                    var tl_ara_toplam = tl_karsilik_ara_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                    var tl_karsilik_genel_toplam = genel_toplam * doviz_kuru;

                                    var tl_genel_toplam = tl_karsilik_genel_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                    var tl_karsilik_tevkifat_tutari = parse_tevkifat * doviz_kuru;

                                    var tl_tevkifat = tl_karsilik_tevkifat_tutari.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                    $(".iskonto_toplam_bas_siparis").html("");

                                    $(".iskonto_toplam_bas_siparis").html(tl_iskonto + " TL");

                                    $(".kdv_toplam_bas_siparis").html("");

                                    $(".kdv_toplam_bas_siparis").html(tl_kdv + " TL");

                                    $(".ara_toplam_bas_siparis").html("");

                                    $(".ara_toplam_bas_siparis").html(tl_ara_toplam + " TL");

                                    $(".genel_toplam_bas_siparis").html("");

                                    $(".genel_toplam_bas_siparis").html(tl_genel_toplam + " TL");

                                    $(".tevkifat_tutari_bas_siparis").html("");

                                    $(".tevkifat_tutari_bas_siparis").html(tl_tevkifat + " TL");

                                } else {

                                    $(".iskonto_toplam_bas_siparis").html("");

                                    $(".iskonto_toplam_bas_siparis").html(iskonto_yazi + " TL");

                                    $(".kdv_toplam_bas_siparis").html("");

                                    $(".kdv_toplam_bas_siparis").html(kdv_yazi + " TL");

                                    $(".ara_toplam_bas_siparis").html("");

                                    $(".ara_toplam_bas_siparis").html(ara_toplam_yazi + " TL");

                                    $(".genel_toplam_bas_siparis").html("");

                                    $(".genel_toplam_bas_siparis").html(genel_toplam_yazi + " TL");

                                    $(".tevkifat_tutari_bas_siparis").html("");

                                    $(".tevkifat_tutari_bas_siparis").html(tevkifat_yazi + " TL");

                                }

                                var alis_id = siparis_table.row.add([item.stok_kodu, item.stok_adi, item.birim_adi, item.miktar, birim_fiyat, "%" + item.kdv_orani, kdv_fiyat + " " + item.doviz_tur, "%" + item.iskonto, iskonto_tutari + " " + item.doviz_tur, item.tevkifat_kodu, tevkifat_tutari + " " + item.doviz_tur, toplam_tutar + " " + item.doviz_tur, "<button class='btn btn-danger satis_siparisden_cikart' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();

                                $(alis_id).attr("data-id", item.id);

                            });

                            $(".stok_adi_siparis").attr("data-id", "");

                            $("#birim_id").val("");

                            $("#miktar").val("");

                            $("#birim_fiyat").val("");

                            $("#kdv").val("");

                            $("#kdv").attr("kdv_tutari", "");

                            $("#iskonto_yuzde").val("");

                            $("#iskonto_yuzde").attr("iskonto_tutari", "");

                            $("#tevkifat_kodu").val("");

                            $("#tevkifat_yuzde").val("");

                            $("#toplam_tutar").val("");

                            $("#tevkifat_tutar").val("");

                            $("#tevkifat_tutar").attr("doviz_tutari", "");

                        }

                    }

                })

            }

        });


        $("body").off("click", ".alis_urun_list").on("click", ".alis_urun_list", function () {

            var id = $(this).attr("data-id");

            $.get("controller/satis_controller/sql.php?islem=alinan_siparisteki_urun_bilgilerini_getir", {id: id}, function (result) {

                if (result != 2) {

                    $("#kaydi_guncelle_satis_siparis").attr("data-id", id);

                    arr = [];

                    var item = JSON.parse(result);

                    $(".stok_adi").attr("data-id", item.stok_id);

                    $(".stok_adi").val(item.stok_adi);

                    $("#birim_id").val(item.birim);

                    $("#miktar").val(item.miktar);

                    $("#birim_fiyat").val(item.birim_fiyat);

                    $("#kdv").val(item.kdv_orani);

                    $("#iskonto_yuzde").val(item.iskonto);

                    $("#tevkifat_kodu").val(item.tevkifat_kodu);

                    $("#tevkifat_yuzde").val(item.tevkifat_yuzde);

                    $("#tevkifat_tutar").val(item.tevkifat_tutari);

                    $("#toplam_tutar").val(item.toplam_tutar);

                    arr.push(item.kdv_tutari, item.iskonto_tutari, item.toplam_tutar, item.miktar, item.birim_fiyat, item.tevkifat_tutari);

                }

            })

        });


        $("body").off("click", "#kaydi_guncelle_satis_siparis").on("click", "#kaydi_guncelle_satis_siparis", function () {

            var id = $(this).attr("data-id");

            var stok_id = $(".stok_adi").attr("data-id");

            var birim_id = $("#birim_id").val();

            var miktar = $("#miktar").val();

            miktar = miktar.replace(/\./g, "").replace(",", ".");

            miktar = parseFloat(miktar);

            var birim_fiyat = $("#birim_fiyat").val();

            birim_fiyat = birim_fiyat.replace(/\./g, "").replace(",", ".");

            birim_fiyat = parseFloat(birim_fiyat);

            var kdv_orani = $("#kdv").val();

            var kdv_tutari = $("#kdv").attr("kdv_tutari");

            var iskonto = $("#iskonto_yuzde").val();

            var iskonto_tutari = $("#iskonto_yuzde").attr("iskonto_tutari");

            var tevkifat_kodu = $("#tevkifat_kodu").val();

            var tevkifat_yuzde = $("#tevkifat_yuzde").val();

            var toplam_tutar = $("#toplam_tutar").val();

            toplam_tutar = toplam_tutar.replace(/\./g, "").replace(",", ".");

            toplam_tutar = parseFloat(toplam_tutar);

            var tevkifat_tutari = $("#tevkifat_tutar").val();

            var tevkifat_doviz_tutari = $("#tevkifat_tutar").attr("doviz_tutari");

            var siparis_id = $("#alinan_siparis_ekle_button").attr("data-id");


            var secilen_kdv_tutar = arr[0];

            var secilen_iskonto_tutari = arr[1];

            var secilen_toplam_tutar = arr[2];

            var secilen_miktar = arr[3];

            var secilen_birim_fiyat = arr[4];

            var secilen_tevkifat_tutari = arr[5];


            var eski_ara_toplam = 0;

            var yeni_ara_toplam = 0;

            if (secilen_iskonto_tutari != 0 || iskonto_tutari != 0) {

                var eski_tutar = secilen_birim_fiyat - secilen_iskonto_tutari;

                eski_ara_toplam = eski_tutar * secilen_miktar;


                var yeni_tutar = birim_fiyat - iskonto_tutari;

                yeni_ara_toplam = yeni_tutar * miktar;

            } else {

                eski_ara_toplam = secilen_birim_fiyat * secilen_miktar;

                yeni_ara_toplam = birim_fiyat * miktar;

            }

            var kdv_fark = kdv_tutari - secilen_kdv_tutar;

            var iskonto_fark = iskonto_tutari - secilen_iskonto_tutari;

            var tutar_fark = toplam_tutar - secilen_toplam_tutar;

            var tevkifat_fark = tevkifat_tutari - secilen_tevkifat_tutari;

            var ara_toplam_fark = yeni_ara_toplam - eski_ara_toplam;


            $.ajax({

                url: "controller/satis_controller/sql.php?islem=satis_siparis_urun_guncelle",

                type: "POST",

                data: {

                    stok_id: stok_id,

                    birim_id: birim_id,

                    kdv_fark: kdv_fark,

                    iskonto_fark: iskonto_fark,

                    tutar_fark: tutar_fark,

                    tevkifat_fark: tevkifat_fark,

                    ara_toplam_fark: ara_toplam_fark,

                    miktar: miktar,

                    birim_fiyat: birim_fiyat,

                    kdv_orani: kdv_orani,

                    kdv_tutari: kdv_tutari,

                    iskonto: iskonto,

                    iskonto_tutari: iskonto_tutari,

                    tevkifat_kodu: tevkifat_kodu,

                    tevkifat_yuzde: tevkifat_yuzde,

                    toplam_tutar: toplam_tutar,

                    tevkifat_tutari: tevkifat_tutari,

                    tevkifat_doviz_tutari: tevkifat_doviz_tutari,

                    id: id,

                    siparis_id: siparis_id

                },

                success: function (result) {

                    if (result != 2) {

                        siparis_table.clear().draw(false);

                        var json = JSON.parse(result);

                        json.forEach(function (item) {

                            var iskonto_toplam = item.iskonto_toplam;

                            var kdv_toplam = item.kdv_toplam;

                            var ara_toplam = item.ara_toplam;

                            var genel_toplam = item.genel_toplam;

                            var tevkifat_toplam = item.tevkifat_toplam;


                            iskonto_toplam = parseFloat(iskonto_toplam);

                            kdv_toplam = parseFloat(kdv_toplam);

                            ara_toplam = parseFloat(ara_toplam);

                            genel_toplam = parseFloat(genel_toplam);

                            tevkifat_toplam = parseFloat(tevkifat_toplam);

                            var iskonto_yazi = iskonto_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                            var kdv_yazi = kdv_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                            var ara_toplam_yazi = ara_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                            var genel_toplam_yazi = genel_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                            var tevkifat_yazi = tevkifat_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                            var birimFiyat = item.birim_fiyat;

                            var parse_birim = parseFloat(birimFiyat);

                            var birim_fiyat = parse_birim.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                            var kdvTutari = item.kdv_tutari;

                            var parse_kdv = parseFloat(kdvTutari);

                            var kdv_fiyat = parse_kdv.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                            var iskontoTutari = item.iskonto_tutari;

                            var parse_iskonto = parseFloat(iskontoTutari);

                            var iskonto_tutari = parse_iskonto.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                            var tevkifatTutari = item.tevkifat_tutari;

                            var parse_tevkifat = parseFloat(tevkifatTutari);

                            var tevkifat_tutari = parse_tevkifat.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                            var toplamTutar = item.toplam_tutar;

                            var parse_toplam = parseFloat(toplamTutar);

                            var toplam_tutar = parse_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                            if ($("#doviz_tur").val() != "TL") {

                                $(".doviz_iskonto_toplam_bas_siparis").html("");

                                $(".doviz_iskonto_toplam_bas_siparis").html(iskonto_yazi + " " + item.doviz_tur);

                                $(".doviz_kdv_toplam_bas_siparis").html("");

                                $(".doviz_kdv_toplam_bas_siparis").html(kdv_yazi + " " + item.doviz_tur);

                                $(".doviz_ara_toplam_bas_siparis").html("");

                                $(".doviz_ara_toplam_bas_siparis").html(ara_toplam_yazi + " " + item.doviz_tur);

                                $(".doviz_genel_toplam_bas_siparis").html("");

                                $(".doviz_genel_toplam_bas_siparis").html(genel_toplam_yazi + " " + item.doviz_tur);

                                $(".doviz_tevkifat_tutari_bas_siparis").html("");

                                $(".doviz_tevkifat_tutari_bas_siparis").html(tevkifat_yazi + " " + item.doviz_tur);


                                var doviz_kuru = $("#kur_fiyat").val();

                                var tl_karsilik_iskonto = parse_iskonto * doviz_kuru;

                                var tl_iskonto = tl_karsilik_iskonto.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                var tl_karsilik_kdv = parse_kdv * doviz_kuru;

                                var tl_kdv = tl_karsilik_kdv.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                var tl_karsilik_ara_toplam = ara_toplam * doviz_kuru;

                                var tl_ara_toplam = tl_karsilik_ara_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                var tl_karsilik_genel_toplam = genel_toplam * doviz_kuru;

                                var tl_genel_toplam = tl_karsilik_genel_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                var tl_karsilik_tevkifat_tutari = parse_tevkifat * doviz_kuru;

                                var tl_tevkifat = tl_karsilik_tevkifat_tutari.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                $(".iskonto_toplam_bas_siparis").html("");

                                $(".iskonto_toplam_bas_siparis").html(tl_iskonto + " TL");

                                $(".kdv_toplam_bas_siparis").html("");

                                $(".kdv_toplam_bas_siparis").html(tl_kdv + " TL");

                                $(".ara_toplam_bas_siparis").html("");

                                $(".ara_toplam_bas_siparis").html(tl_ara_toplam + " TL");

                                $(".genel_toplam_bas_siparis").html("");

                                $(".genel_toplam_bas_siparis").html(tl_genel_toplam + " TL");

                                $(".tevkifat_tutari_bas_siparis").html("");

                                $(".tevkifat_tutari_bas_siparis").html(tl_tevkifat + " TL");

                            } else {

                                $(".iskonto_toplam_bas_siparis").html("");

                                $(".iskonto_toplam_bas_siparis").html(iskonto_yazi + " TL");

                                $(".kdv_toplam_bas_siparis").html("");

                                $(".kdv_toplam_bas_siparis").html(kdv_yazi + " TL");

                                $(".ara_toplam_bas_siparis").html("");

                                $(".ara_toplam_bas_siparis").html(ara_toplam_yazi + " TL");

                                $(".genel_toplam_bas_siparis").html("");

                                $(".genel_toplam_bas_siparis").html(genel_toplam_yazi + " TL");

                                $(".tevkifat_tutari_bas_siparis").html("");

                                $(".tevkifat_tutari_bas_siparis").html(tevkifat_yazi + " TL");

                            }

                            var alis_id = siparis_table.row.add([item.stok_kodu, item.stok_adi, item.birim_adi, item.miktar, birim_fiyat, "%" + item.kdv_orani, kdv_fiyat + " " + item.doviz_tur, "%" + item.iskonto, iskonto_tutari + " " + item.doviz_tur, item.tevkifat_kodu, tevkifat_tutari + " " + item.doviz_tur, toplam_tutar + " " + item.doviz_tur, "<button class='btn btn-danger satis_satis_siparisden_cikart' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();

                            $(alis_id).attr("data-id", item.id);

                        });

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

                        })


                        Toast.fire({

                            icon: 'success',

                            title: 'Ürün Güncellendi'

                        });


                        $(".stok_adi").attr("data-id", "");

                        $("#birim_id").val("");

                        $("#miktar").val("");

                        $("#birim_fiyat").val("");

                        $("#kdv").val("");

                        $("#kdv").attr("kdv_tutari", "");

                        $("#iskonto_yuzde").val("");

                        $("#iskonto_yuzde").attr("iskonto_tutari", "");

                        $("#tevkifat_kodu").val("");

                        $("#tevkifat_yuzde").val("");

                        $("#toplam_tutar").val("");

                        $("#tevkifat_tutar").val("");

                        $("#tevkifat_tutar").attr("doviz_tutari", "");

                    } else {

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

                        })


                        Toast.fire({

                            icon: 'error',

                            title: 'Bilinmeyen Bir Hata Oluştu'

                        })


                    }

                }

            });

        })


        $("body").off("click", ".satis_siparisden_cikart").on("click", ".satis_siparisden_cikart", function () {

            var id = $(this).attr("data-id");

            var siparis_id = $("#alinan_siparis_ekle_button").attr("data-id");


            $.ajax({

                url: "controller/satis_controller/sql.php?islem=satis_siparisten_urun_cikart",

                type: "POST",

                data: {

                    id: id,

                    siparis_id: siparis_id

                },

                success: function (result) {

                    if (result != 500) {

                        if (result == 2) {

                            var doviz_tur = $("#doviz_tur").val();

                            siparis_table.clear().draw(false);

                            $(".doviz_iskonto_toplam_bas_siparis").html("");

                            $(".doviz_iskonto_toplam_bas_siparis").html("0,00" + doviz_tur);

                            $(".doviz_kdv_toplam_bas_siparis").html("");

                            $(".doviz_kdv_toplam_bas_siparis").html("0,00" + doviz_tur);

                            $(".doviz_ara_toplam_bas_siparis").html("");

                            $(".doviz_ara_toplam_bas_siparis").html("0,00" + doviz_tur);

                            $(".doviz_genel_toplam_bas_siparis").html("");

                            $(".doviz_genel_toplam_bas_siparis").html("0,00" + doviz_tur);

                            $(".doviz_tevkifat_tutari_bas_siparis").html("");

                            $(".doviz_tevkifat_tutari_bas_siparis").html("0,00" + doviz_tur);

                            $(".iskonto_toplam_bas_siparis").html("");

                            $(".iskonto_toplam_bas_siparis").html("0,00 TL");

                            $(".kdv_toplam_bas_siparis").html("");

                            $(".kdv_toplam_bas_siparis").html("0,00 TL");

                            $(".ara_toplam_bas_siparis").html("");

                            $(".ara_toplam_bas_siparis").html("0,00 TL");

                            $(".genel_toplam_bas_siparis").html("");

                            $(".genel_toplam_bas_siparis").html("0,00 TL");

                            $(".tevkifat_tutari_bas_siparis").html("");

                            $(".tevkifat_tutari_bas_siparis").html("0,00 TL");

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

                            })

                            Toast.fire({

                                icon: 'success',

                                title: 'Ürün Silindi'

                            })

                        } else {

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

                            })

                            Toast.fire({

                                icon: 'success',

                                title: 'Ürün Silindi'

                            })

                            siparis_table.clear().draw(false);

                            var json = JSON.parse(result);

                            json.forEach(function (item) {

                                $("#alinan_siparis_ekle_button").attr("data-id", item.siparis_id);

                                var iskonto_toplam = item.iskonto_toplam;

                                var kdv_toplam = item.kdv_toplam;

                                var ara_toplam = item.ara_toplam;

                                var genel_toplam = item.genel_toplam;

                                var tevkifat_toplam = item.tevkifat_toplam;


                                iskonto_toplam = parseFloat(iskonto_toplam);

                                kdv_toplam = parseFloat(kdv_toplam);

                                ara_toplam = parseFloat(ara_toplam);

                                genel_toplam = parseFloat(genel_toplam);

                                tevkifat_toplam = parseFloat(tevkifat_toplam);

                                var iskonto_yazi = iskonto_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                var kdv_yazi = kdv_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                var ara_toplam_yazi = ara_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                var genel_toplam_yazi = genel_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                var tevkifat_yazi = tevkifat_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                                var birimFiyat = item.birim_fiyat;

                                var parse_birim = parseFloat(birimFiyat);

                                var birim_fiyat = parse_birim.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                                var kdvTutari = item.kdv_tutari;

                                var parse_kdv = parseFloat(kdvTutari);

                                var kdv_fiyat = parse_kdv.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                                var iskontoTutari = item.iskonto_tutari;

                                var parse_iskonto = parseFloat(iskontoTutari);

                                var iskonto_tutari = parse_iskonto.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                                var tevkifatTutari = item.tevkifat_tutari;

                                var parse_tevkifat = parseFloat(tevkifatTutari);

                                var tevkifat_tutari = parse_tevkifat.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                                var toplamTutar = item.toplam_tutar;

                                var parse_toplam = parseFloat(toplamTutar);

                                var toplam_tutar = parse_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                                if ($("#doviz_tur").val() != "TL") {

                                    $(".doviz_iskonto_toplam_bas_siparis").html("");

                                    $(".doviz_iskonto_toplam_bas_siparis").html(iskonto_yazi + " " + item.doviz_tur);

                                    $(".doviz_kdv_toplam_bas_siparis").html("");

                                    $(".doviz_kdv_toplam_bas_siparis").html(kdv_yazi + " " + item.doviz_tur);

                                    $(".doviz_ara_toplam_bas_siparis").html("");

                                    $(".doviz_ara_toplam_bas_siparis").html(ara_toplam_yazi + " " + item.doviz_tur);

                                    $(".doviz_genel_toplam_bas_siparis").html("");

                                    $(".doviz_genel_toplam_bas_siparis").html(genel_toplam_yazi + " " + item.doviz_tur);

                                    $(".doviz_tevkifat_tutari_bas_siparis").html("");

                                    $(".doviz_tevkifat_tutari_bas_siparis").html(tevkifat_yazi + " " + item.doviz_tur);


                                    var doviz_kuru = $("#kur_fiyat").val();

                                    var tl_karsilik_iskonto = parse_iskonto * doviz_kuru;

                                    var tl_iskonto = tl_karsilik_iskonto.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                    var tl_karsilik_kdv = parse_kdv * doviz_kuru;

                                    var tl_kdv = tl_karsilik_kdv.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                    var tl_karsilik_ara_toplam = ara_toplam * doviz_kuru;

                                    var tl_ara_toplam = tl_karsilik_ara_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                    var tl_karsilik_genel_toplam = genel_toplam * doviz_kuru;

                                    var tl_genel_toplam = tl_karsilik_genel_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                    var tl_karsilik_tevkifat_tutari = parse_tevkifat * doviz_kuru;

                                    var tl_tevkifat = tl_karsilik_tevkifat_tutari.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                    $(".iskonto_toplam_bas_siparis").html("");

                                    $(".iskonto_toplam_bas_siparis").html(tl_iskonto + " TL");

                                    $(".kdv_toplam_bas_siparis").html("");

                                    $(".kdv_toplam_bas_siparis").html(tl_kdv + " TL");

                                    $(".ara_toplam_bas_siparis").html("");

                                    $(".ara_toplam_bas_siparis").html(tl_ara_toplam + " TL");

                                    $(".genel_toplam_bas_siparis").html("");

                                    $(".genel_toplam_bas_siparis").html(tl_genel_toplam + " TL");

                                    $(".tevkifat_tutari_bas_siparis").html("");

                                    $(".tevkifat_tutari_bas_siparis").html(tl_tevkifat + " TL");

                                } else {

                                    $(".iskonto_toplam_bas_siparis").html("");

                                    $(".iskonto_toplam_bas_siparis").html(iskonto_yazi + " TL");

                                    $(".kdv_toplam_bas_siparis").html("");

                                    $(".kdv_toplam_bas_siparis").html(kdv_yazi + " TL");

                                    $(".ara_toplam_bas_siparis").html("");

                                    $(".ara_toplam_bas_siparis").html(ara_toplam_yazi + " TL");

                                    $(".genel_toplam_bas_siparis").html("");

                                    $(".genel_toplam_bas_siparis").html(genel_toplam_yazi + " TL");

                                    $(".tevkifat_tutari_bas_siparis").html("");

                                    $(".tevkifat_tutari_bas_siparis").html(tevkifat_yazi + " TL");

                                }

                                var alis_id = siparis_table.row.add([item.stok_kodu, item.stok_adi, item.birim_adi, item.miktar, birim_fiyat, "%" + item.kdv_orani, kdv_fiyat + " " + item.doviz_tur, "%" + item.iskonto, iskonto_tutari + " " + item.doviz_tur, item.tevkifat_kodu, tevkifat_tutari + " " + item.doviz_tur, toplam_tutar + " " + item.doviz_tur, "<button class='btn btn-danger satis_siparisden_cikart' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();

                                $(alis_id).attr("data-id", item.id);

                            });

                        }

                    } else {

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

                        })

                        Toast.fire({

                            icon: 'error',

                            title: 'Bilinmeyen Bir Hata Oluştu'

                        })

                    }

                }

            });


        });


        $("body").off("click", "#cari_getir_siparis_button").on("click", "#cari_getir_siparis_button", function () {

            $.get("modals/satis_modal/siparis_page.php?islem=carileri_getir_alis_siparis", function (getModal) {

                $("#cari_getir_satis_siparis").html("");

                $("#cari_getir_satis_siparis").html(getModal);

            })

        });


        $("body").off("click", "#stok_adi_siparis").on("click", "#stok_adi_siparis", function () {

            $.get("modals/satis_modal/siparis_page.php?islem=siparis_stok_getir_modal", function (getModal) {

                $("#stok_adi_getir_satis_siparis").html("");

                $("#stok_adi_getir_satis_siparis").html(getModal);

            })

        });


        $("#tevkifat_kodu").keyup(function () {

            var val = $(this).val();

            if (val == "" || val == null) {

                $(".tevkifat_yuzde").val(0);

                $("#tevkifat_tutar").val(0);

            }

        })

        $("#tevkifat_yuzde").keyup(function () {

            var val = $(this).val();

            if (val == "" || val == null) {

                $(".tevkifat_yuzde").val(0);

                $("#tevkifat_tutar").val(0);

            }

        })


        $("body").off("change", "#doviz_tur").on("change", "#doviz_tur", function () {

            var secilen = $(this).val();

            if (secilen == "TL") {

                $("#kur_fiyat").val("1.00");

            } else if (secilen == "USD") {

                var usd_kur = $("#doviz_tur option:selected").attr("usd");

                $("#kur_fiyat").val(usd_kur);

            } else if (secilen == "EURO") {

                var eur_kur = $("#doviz_tur option:selected").attr("eur");

                $("#kur_fiyat").val(eur_kur);

            } else if (secilen == "GBP") {

                var gbp_kur = $("#doviz_tur option:selected").attr("gbp");

                $("#kur_fiyat").val(gbp_kur);

            }


            $(".doviz_iskonto_toplam_bas_siparis").html("");

            $(".doviz_iskonto_toplam_bas_siparis").html("0,00" + " " + secilen);

            $(".doviz_kdv_toplam_bas_siparis").html("");

            $(".doviz_kdv_toplam_bas_siparis").html("0,00" + " " + secilen);

            $(".doviz_ara_toplam_bas_siparis").html("");

            $(".doviz_ara_toplam_bas_siparis").html("0,00" + " " + secilen);

            $(".doviz_genel_toplam_bas_siparis").html("");

            $(".doviz_genel_toplam_bas_siparis").html("0,00" + " " + secilen);

            $(".doviz_tevkifat_tutari_bas_siparis").html("");

            $(".doviz_tevkifat_tutari_bas_siparis").html("0,00" + " " + secilen);

        });


        $(document).ready(function () {

            $.get("controller/alis_controller/sql.php?islem=guncel_kurlar", function (result) {

                var item = JSON.parse(result);

                var usd = item.USD[0];

                var eur = item.EUR[0];

                var gbp = item.GBP[0];

                $("#usd_bas_siparis").attr("usd", usd);

                $("#euro_bas_siparis").attr("eur", eur);

                $("#gbp_bas_siparis").attr("gbp", gbp);

            });

            $.get("controller/alis_controller/sql.php?islem=depolari_getir", function (result) {

                if (result != 2) {

                    var json = JSON.parse(result);

                    json.forEach(function (item) {

                        var depo_adi = item.depo_adi

                        $("#depo_id").append("" +

                            "<option value='" + item.id + "'>" + depo_adi.toUpperCase() + "</option>" +

                            "");

                    })

                }

            })


            setTimeout(function () {

                $("#click12").trigger("click");

            }, 500);

            $("#satis_siparis_olustur").modal("show");

            siparis_table = $('#siparis_table_list').DataTable({

                scrollY: '30vh',

                scrollX: true,

                searching: false,

                "info": false,

                bAutoWidth: false,

                aoColumns: [

                    {sWidth: '1%'},

                    {sWidth: '5%'},

                    {sWidth: '1%'},

                    {sWidth: '1%'},

                    {sWidth: '1%'},

                    {sWidth: '1%'},

                    {sWidth: '1%'},

                    {sWidth: '1%'},

                    {sWidth: '1%'},

                    {sWidth: '1%'},

                    {sWidth: '1%'},

                    {sWidth: '1%'},

                    {sWidth: '1%'}

                ],

                createdRow: function (row) {

                    $(row).addClass("alis_urun_list");

                },

                "paging": false,

                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},

            });

        })


        $.get("controller/alis_controller/sql.php?islem=birimleri_getir", function (result) {

            if (result != 2) {

                var json = JSON.parse(result);

                json.forEach(function (item) {

                    var birimAdi = item.birim_adi;

                    $(".gelecek_birim").append("" +

                        "<option value='" + item.id + "'>" + birimAdi.toUpperCase() + "</option>" +

                        "");

                })

            }

        });


        $("body").off("click", ".modal_kapali").on("click", ".modal_kapali", function () {

            var silinecek_id = $("#alinan_siparis_ekle_button").attr("data-id");

            if (silinecek_id != "") {

                $.ajax({

                    url: "controller/satis_controller/sql.php?islem=alinan_siparisi_iptal_et_sql",

                    type: "POST",

                    data: {

                        id: silinecek_id

                    },

                    success: function (result) {

                        if (result == 1) {

                            $("#satis_siparis_olustur").modal("hide");

                        } else {

                            $("#satis_siparis_olustur").modal("hide");

                        }

                    }

                });

            } else {

                $("#satis_siparis_olustur").modal("hide");

            }

        });

        var toplam_tutar = 0;


        $(".birim_fiyat").focusout(function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)){
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})
            $(".birim_fiyat").val(val);
        })
        $(".miktar").focusout(function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)){
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})
            $(".miktar").val(val);
        })
        $(".miktar").keyup(function () {
            var value = $(this).val();
            value = value.replace(/\./g, "").replace(",", ".");
            value = parseFloat(value);
            if (isNaN(value)){
                value = 0;
            }
            var birim_fiyat = $(".birim_fiyat").val();
            birim_fiyat = birim_fiyat.replace(/\./g, "").replace(",", ".");
            birim_fiyat = parseFloat(birim_fiyat);
            toplam_tutar = Number(birim_fiyat) * Number(value);
            var kdv = $("#kdv").val();
            var kdv_yuzdeli = kdv / 100;
            var kdv_li_tutar = Number(toplam_tutar) * Number(kdv_yuzdeli)
            $("#kdv").attr("kdv_tutari", kdv_li_tutar.toFixed(2));
            var tevkifatsiz_tutar = toplam_tutar + kdv_li_tutar;
            var tevkifat = $(".tevkifat_yuzde").val();
            if (tevkifat == null || tevkifat == "") {
                tevkifat = 0;
            }
            var tevkifat_yuzde = tevkifat / 100;
            var tevkifat_tutar = kdv_li_tutar * tevkifat_yuzde;
            var tevkifatli_tutar = tevkifatsiz_tutar - tevkifat_tutar;
            if (tevkifat == "") {
                var toplam_tutar = tevkifatsiz_tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})
                $("#toplam_tutar").val(toplam_tutar);
            } else {
                var toplam_tutar = tevkifatli_tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})
                $("#tevkifat_tutar").val(tevkifat_tutar.toFixed(2));
                $("#toplam_tutar").val(toplam_tutar)
            }
        });


        $("#iskonto_yuzde").keyup(function () {


            var iskonto = $(this).val();


            var iskonto_yuzde = iskonto / 100;


            var value = $(".miktar").val();

            value = value.replace(/\./g, "").replace(",", ".");

            value = parseFloat(value);


            var birim_fiyat = $(".birim_fiyat").val();

            birim_fiyat = birim_fiyat.replace(/\./g, "").replace(",", ".");

            birim_fiyat = parseFloat(birim_fiyat);


            var iskonto_tutar = Number(birim_fiyat) * Number(iskonto_yuzde);


            $("#iskonto_yuzde").attr("iskonto_tutari", iskonto_tutar.toFixed(2));


            var iskontolu_fiyat = birim_fiyat - iskonto_tutar;


            toplam_tutar = Number(iskontolu_fiyat) * Number(value);


            var kdv = $("#kdv").val();


            var kdv_yuzdeli = kdv / 100;


            var kdv_li_tutar = Number(toplam_tutar) * Number(kdv_yuzdeli);


            $("#kdv").attr("kdv_tutari", kdv_li_tutar.toFixed(2));


            var tevkifatsiz_tutar = toplam_tutar + kdv_li_tutar;


            var tevkifat = $(".tevkifat_yuzde").val();


            if (tevkifat == null || tevkifat == "") {


                tevkifat = 0;


            }


            var tevkifat_yuzde = tevkifat / 100;


            var tevkifat_tutar = kdv_li_tutar * tevkifat_yuzde;


            var tevkifatli_tutar = tevkifatsiz_tutar - tevkifat_tutar;


            if (tevkifat == "") {


                var toplam_tutar = tevkifatsiz_tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                $("#toplam_tutar").val(toplam_tutar);


            } else {


                var toplam_tutar = tevkifatli_tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                $("#tevkifat_tutar").val(tevkifat_tutar.toFixed(2));


                $("#toplam_tutar").val(toplam_tutar)


            }


        });


        $(".tevkifat_yuzde").keyup(function () {


            var iskonto = $("#iskonto_yuzde").val();


            var iskonto_yuzde = iskonto / 100;


            var value = $(".miktar").val();

            value = value.replace(/\./g, "").replace(",", ".");

            value = parseFloat(value);


            var birim_fiyat = $(".birim_fiyat").val();

            birim_fiyat = birim_fiyat.replace(/\./g, "").replace(",", ".");

            birim_fiyat = parseFloat(birim_fiyat);


            var iskonto_tutar = Number(birim_fiyat) * Number(iskonto_yuzde);


            $("#iskonto_yuzde").attr("iskonto_tutari", iskonto_tutar.toFixed(2));


            var iskontolu_fiyat = birim_fiyat - iskonto_tutar;


            toplam_tutar = Number(iskontolu_fiyat) * Number(value);


            var kdv = $("#kdv").val();


            var kdv_yuzdeli = kdv / 100;


            var kdv_li_tutar = Number(toplam_tutar) * Number(kdv_yuzdeli);


            $("#kdv").attr("kdv_tutari", kdv_li_tutar.toFixed(2));


            var tevkifatsiz_tutar = toplam_tutar + kdv_li_tutar;


            var tevkifat = $(this).val();


            if (tevkifat == null || tevkifat == "") {


                tevkifat = 0;


            }


            var tevkifat_yuzde = tevkifat / 100;


            var tevkifat_tutar = kdv_li_tutar * tevkifat_yuzde;


            var tevkifatli_tutar = tevkifatsiz_tutar - tevkifat_tutar;


            if (tevkifat == "") {


                var toplam_tutar = tevkifatsiz_tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                $("#toplam_tutar").val(toplam_tutar);


            } else {


                var toplam_tutar = tevkifatli_tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                $("#tevkifat_tutar").val(tevkifat_tutar.toFixed(2));


                $("#toplam_tutar").val(toplam_tutar)


            }


        });


        $(".kdv_yuzde").keyup(function () {


            var iskonto = $("#iskonto_yuzde").val();


            var iskonto_yuzde = iskonto / 100;


            var value = $(".miktar").val();

            value = value.replace(/\./g, "").replace(",", ".");

            value = parseFloat(value);


            var birim_fiyat = $(".birim_fiyat").val();

            birim_fiyat = birim_fiyat.replace(/\./g, "").replace(",", ".");

            birim_fiyat = parseFloat(birim_fiyat);


            var iskonto_tutar = Number(birim_fiyat) * Number(iskonto_yuzde);


            $("#iskonto_yuzde").attr("iskonto_tutari", iskonto_tutar.toFixed(2));


            var iskontolu_fiyat = birim_fiyat - iskonto_tutar;


            toplam_tutar = Number(iskontolu_fiyat) * Number(value);


            var kdv = $(this).val();


            var kdv_yuzdeli = kdv / 100;


            var kdv_li_tutar = Number(toplam_tutar) * Number(kdv_yuzdeli);


            $("#kdv").attr("kdv_tutari", kdv_li_tutar.toFixed(2));


            var tevkifatsiz_tutar = toplam_tutar + kdv_li_tutar;


            var tevkifat = $(".tevkifat_yuzde").val();


            if (tevkifat == null || tevkifat == "") {


                tevkifat = 0;


            }


            var tevkifat_yuzde = tevkifat / 100;


            var tevkifat_tutar = kdv_li_tutar * tevkifat_yuzde;


            var tevkifatli_tutar = tevkifatsiz_tutar - tevkifat_tutar;


            if (tevkifat == "") {


                var toplam_tutar = tevkifatsiz_tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                $("#toplam_tutar").val(toplam_tutar);


            } else {


                var toplam_tutar = tevkifatli_tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})


                $("#tevkifat_tutar").val(tevkifat_tutar.toFixed(2));


                $("#toplam_tutar").val(toplam_tutar)


            }


        });

    </script>

    <?php

}