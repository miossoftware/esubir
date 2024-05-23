<?php
$islem = $_GET["islem"];
if ($islem == "alis_faturasi_ekle") {
    ?>
    <div class="modal fade" id="alis_fatura_modal" data-backdrop="static"
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
                        <div class="ibox-title" style='color:white; font-weight:bold;'>ALIŞ FATURASI GİRİŞ</div>
                    </div>
                <div class="modal-body" style="max-height: 75vh; overflow: auto;">
                    <div id="carileri_getir_div"></div>
                    <div id="stok_adi_getir_div"></div>
                    <div id="cariye_ait_irsaliye"></div>
                    <div class="col-md-12 row ana_fatura">
                        <div class="col-4">
                            <div class="form-group row">
                                <div class="col-md-4 mt-1">
                                    <label>Cari Kodu</label>
                                </div>
                                <div class="col-8">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control form-control-sm secilen_cari"
                                               aria-describedby="basic-addon1" id="cari_id">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm" id="cari_getir_modal"><i
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
                                    <input type="text" class="form-control form-control-sm cari_adi_getir" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4 mt-1">
                                    Telefon
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm cari_telefon" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4 mt-1">
                                    Yetkili
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm yetkili_adi" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4 mt-1">
                                    Yetkili Cep
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm yetkili_cep" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4 mt-1">
                                    Vergi Daire
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm vergi_daire" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4 mt-1">
                                    Vergi No
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control form-control-sm vergi_no" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group row">
                                <div class="col-md-4 mt-1">
                                    Cari Adres
                                </div>
                                <div class="col-md-8">
                                    <textarea class="form-control form-control-sm cari_adres" disabled id="" cols="30"
                                              rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4 mt-1">
                                    Fatura Türü
                                </div>
                                <div class="col-md-8">
                                    <select class="custom-select custom-select-sm" id="fatura_turu_alis">
                                        <option value="">Seçiniz...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Fatura Tipi</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="custom-select custom-select-sm" id="alis_fatura_tipi">
                                        <option value="">Seçiniz...</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-md-4 mt-1">

                                    Fatura No

                                </div>

                                <div class="col-md-8">

                                    <input type="text" class="form-control form-control-sm fatura_no_alis_fatura" id="fatura_no">

                                </div>

                            </div>

                            <div class="form-group row">

                                <div class="col-md-4 mt-1">

                                    Fatura Tarihi

                                </div>

                                <div class="col-md-8">

                                    <input type="date" value="<?= date("Y-m-d") ?>"

                                           class="form-control form-control-sm fatura_tarihi fatura_tarihi_satis_faturasi" id="fatura_tarihi">

                                </div>

                            </div>

                            <div class="form-group row">

                                <div class="col-md-4 mt-1">

                                    Vade Tarihi

                                </div>

                                <div class="col-md-8">

                                    <input type="date" class="form-control form-control-sm vade_tarihi_ayarla"

                                           id="vade_tarihi">

                                </div>

                            </div>

                        </div>

                        <div class="col-4">

                            <div class="form-group row">

                                <div class="col-md-4 mt-1">

                                    İrsaliye No

                                </div>

                                <div class="col-md-8">

                                    <input type="text" class="form-control form-control-sm" id="irsaliye_no">

                                </div>

                            </div>

                            <div class="form-group row">

                                <div class="col-md-4 mt-1">

                                    İrsaliye Tarihi

                                </div>

                                <div class="col-md-8">

                                    <input type="date" class="form-control form-control-sm"

                                           id="irsaliye_tarih">

                                </div>

                            </div>

                            <div class="form-group row">

                                <div class="col-md-4 mt-1">

                                    Depo

                                </div>

                                <div class="col-md-8">

                                    <select class="custom-select custom-select-sm" id="depo_id">

                                        <option value="">Seçiniz...</option>

                                    </select>

                                </div>

                            </div>

                            <div class="form-group row">

                                <div class="col-md-4 mt-1">

                                    Döviz Türü

                                </div>

                                <div class="col-md-8 row no-gutters">

                                    <div class="col">

                                        <select class="custom-select custom-select-sm doviz_tur_selected aktar_doviz_tur"

                                                id="doviz_tur">

                                            <option value="">Seçiniz...</option>

                                            <option selected value="TL">TL</option>

                                            <option id="usd_bas" value="USD">USD</option>

                                            <option id="eur_bas" value="EURO">EURO</option>

                                            <option id="gbp_bas" value="GBP">GBP</option>

                                        </select>

                                    </div>

                                    <div class="col">

                                        <input type="text" class="form-control form-control-sm" id="doviz_kuru"

                                               value="1.00"

                                               placeholder="Döviz Karşılığı">

                                    </div>

                                </div>

                            </div>

<!--                            <div class="form-group row">-->
<!---->
<!--                                <div class="col-md-4 mt-1">-->
<!---->
<!--                                    Muhtelif-->
<!---->
<!--                                </div>-->
<!---->
<!--                                <div class="col-md-8">-->
<!---->
<!--                                    <select class="custom-select custom-select-sm fatura_turu_muhtelif" id="fatura_turu">-->
<!--                                        <option value="">Seçiniz...</option>-->
<!--                                        <option value="1">Muhtelif</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!--                            </div>-->
                        </div>
                    </div>
                    <div class="fatura_icerik">

                        <div class="card">

                            <div class="card-body">

                                <div class="col-12 row mt-2 no-gutters">

                                    <div class="col-md-1">

                                        <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;Stok Adı</label>

                                        <div class="input-group">

                                            <input type="text" class="form-control form-control-sm stok_adi"

                                                   placeholder="Stok Adı">

                                            <div class="input-group-append">

                                                <button class="btn btn-warning btn-sm stok_adi_getir"

                                                        id="stok_adi">

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

                                        <select class="custom-select custom-select-sm mx-1 gelecek_birim" id="birim_id">

                                            <option value="">Birim</option>

                                        </select>

                                    </div>

                                    <div class="col-md-1">

                                        <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Birim

                                            Fiyat</label>

                                        <input type="text" style="text-align: right"

                                               class="form-control form-control-sm mx-2 birim_fiyat duzenle_birim_fiyat"

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

                                    <div class="col-md-2 row">

                                        <button style="width: 100% !important;"

                                                class="btn btn-success btn-sm mx-5" id="faturaya_ekle"><i

                                                    class="fa fa-plus"></i> Ekle

                                        </button>

                                        <button style="background-color: #F6FA70; width: 100% !important;"

                                                class="btn btn-sm mx-5 mt-1" id="kaydi_guncelle"><i

                                                    class="fa fa-refresh"></i> Kaydı Güncelle

                                        </button>

                                        <button style="width: 100% !important;"

                                                class="btn btn-secondary btn-sm mx-5 mt-1" id="cariye_ait_irsaliyeler"><i

                                                    class="fa fa-download"></i> İrsaliyeden Aktar

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-12 mt-3">

                            <table class="table table-sm table-bordered w-100 display nowrap"

                                   style="cursor:pointer;font-size: 13px;"

                                   id="alis_fatura_list">

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

                            <div class="col-8 mt-2">

                                <div class="form-group row">

                                    <div class="col-1">

                                        <label>Açıklama</label>

                                    </div>

                                    <div class="col-11">

                                        <textarea class="form-control form-control-sm aciklama_siparis" id="aciklama"

                                                  cols="30"

                                                  rows="10"></textarea>

                                    </div>

                                </div>

                            </div>

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
                                                <th>Döviz Tutarı</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td id="doviz_ara_toplam" style="text-align: right">0,00 TL</td>
                                            </tr>
                                            <tr>
                                                <td id="doviz_kdv" style="text-align: right">0,00 TL</td>
                                            </tr>
                                            <tr>
                                                <td id="doviz_tevkifat_tutar" style="text-align: right">0,00 TL</td>
                                            </tr>
                                            <tr>
                                                <td id="doviz_iskonto" style="text-align: right">0,00 TL</td>
                                            </tr>
                                            <tr>
                                                <td id="doviz_genel_toplam" style="text-align: right">0,00 TL</td>
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
                                                <td class="ara_toplam_bas" style="text-align: right">0,00 TL</td>
                                            </tr>
                                            <tr>
                                                <td class="kdv_toplam_bas" style="text-align: right">0,00 TL</td>
                                            </tr>
                                            <tr>
                                                <td class="tevkifat_tutari_bas" style="text-align: right">0,00 TL</td>
                                            </tr>
                                            <tr>
                                                <td class="iskonto_toplam_bas" style="text-align: right">0,00 TL</td>
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
                        <div class="modal-footer">
                    <button class="btn btn-danger modal_kapali btn-sm"><i class="fa fa-close"></i> Vazgeç
                    </button>
                    <button class="btn btn-success btn-sm" id="fatura_olustur"><i
                                class="fa fa-plus"></i> Kaydet
                    </button>
                </div>
                    </div>
                </div>
    </div>
            </div>
        </div>
    </div>

    <script>
    $("body").off("focusout",".fatura_tarihi_satis_faturasi").on("focusout",".fatura_tarihi_satis_faturasi",function (){
            let val = $(this).val();
            var baslangicTarihi = new Date(val);
            var yeniTarih = new Date(baslangicTarihi);
            let cari_id = $(".secilen_cari").attr("data-id");
            $.get("controller/satis_controller/sql.php?islem=vade_tarihi_getir_sql",{cari_id:cari_id},function (result){
                if (result != 2){
                    var item = JSON.parse(result);
                    var vade_tarihi = item.vade_gunu;
                    vade_tarihi = parseInt(vade_tarihi);
                    yeniTarih.setDate(baslangicTarihi.getDate() + vade_tarihi);
                    $(".vade_tarihi_ayarla").val(yeniTarih.toISOString().split('T')[0]);
                }
            })
        });

     $('input').click(function() {
            $(this).select();
        });


        $(".secilen_cari").keyup(function () {

            var cari_kodu = $(this).val();

            $.get("controller/alis_controller/sql.php?islem=girilen_cari_kodu_bilgileri", {cari_kodu: cari_kodu}, function (result) {

                if (result != 2) {

                    var item = JSON.parse(result);

                    var telefon = item.telefon;

                    var yetkiliAdi1 = item.yetkili_adi1;

                    var yetkiliTel1 = item.yetkili_tel1;

                    var vergiDairesi = item.vergi_dairesi;

                    var cariAdi = item.cari_adi;

                    var vergiNo = item.vergi_no;

                    $(".cari_adi_getir").val(cariAdi)

                    var adres = item.adres;

                    var vade_gunu = item.vade_gunu;

                    var tarih1 = $(".fatura_tarihi");

                    var tarih = new Date(tarih1.val());

                    var vade_tarihi = new Date(tarih.getTime() + (vade_gunu * 24 * 60 * 60 * 1000));

                    var yeniTarihString = vade_tarihi.getFullYear() + '-' + ('0' + (vade_tarihi.getMonth() + 1)).slice(-2) + '-' + ('0' + vade_tarihi.getDate()).slice(-2);

                    $(".vade_tarihi_ayarla").val(yeniTarihString)

                    $(".cari_telefon").val(telefon);

                    $(".secilen_cari").attr("data-id", item.id);

                    $(".secilen_cari").val(item.cari_kodu);

                    $(".yetkili_adi").val(yetkiliAdi1);

                    $(".yetkili_cep").val(yetkiliTel1);

                    $(".vergi_daire").val(vergiDairesi);

                    $(".vergi_no").val(vergiNo);

                    $(".cari_adres").val(adres);

                } else {

                    $(".vade_tarihi_ayarla").val("")

                    $(".cari_telefon").val("");

                    $(".secilen_cari").attr("data-id", "");

                    $(".yetkili_adi").val("");

                    $(".yetkili_cep").val("");

                    $(".vergi_daire").val("");

                    $(".vergi_no").val("");

                    $(".cari_adres").val("");

                }

            })

        })



        $(".stok_adi").keyup(function () {

            var stok_kodu = $(this).val();

            $.get("controller/alis_controller/sql.php?islem=stok_kodu_bilgileri_getir", {stok_kodu: stok_kodu}, function (result) {

                if (result != 2) {

                    var item = JSON.parse(result);

                    $(".gelecek_birim").val(item.birim);

                    $(".stok_adi").val(item.stok_adi);

                    $(".stok_adi").attr("data-id", item.id);

                    setTimeout(function (){
                        $(".kdv_yuzde").val(item.kdv_orani);
                    },100)

                    $(".tevkifat_kodu").val(item.tevkifat_kodu);

                    $(".birim_fiyat").val(item.alis_fiyat);

                    $(".tevkifat_yuzde").val(item.tevkifat_yuzde);

                    $("#fatura_stoklari_getir_modal_getir").modal("hide");

                    $(".miktar").focus();

                }

            })

        });



        var alis_table = "";

        var arr = [];





        $("body").off("change", "#doviz_tur").on("change", "#doviz_tur", function () {

            var value = $(this).val();

            if (value == "TL") {

                $("#doviz_kuru_irsaliye").val("1.00");

            } else if (value == "EURO") {

                var eur_kur = $(".doviz_tur_selected option:selected").attr("eur");

                $("#doviz_kuru_irsaliye").val(eur_kur);

            } else if (value == "USD") {

                var usd_kur = $(".doviz_tur_selected option:selected").attr("usd");

                $("#doviz_kuru_irsaliye").val(usd_kur);

            } else if (value == "GBP") {

                var gbp_kur = $(".doviz_tur_selected option:selected").attr("gbp");

                $("#doviz_kuru_irsaliye").val(gbp_kur);

            } else {

                $("#doviz_kuru_irsaliye").val("");

            }

            $("#doviz_iskonto").html("");

            $("#doviz_iskonto").html("0,00" + " " + value);

            $("#doviz_kdv").html("");

            $("#doviz_kdv").html("0,00" + " " + value);

            $("#doviz_ara_toplam").html("");

            $("#doviz_ara_toplam").html("0,00" + " " + value);

            $("#doviz_genel_toplam").html("");

            $("#doviz_genel_toplam").html("0,00" + " " + value);

            $("#doviz_tevkifat_tutar").html("");

            $("#doviz_tevkifat_tutar").html("0,00" + " " + value);

        });





        $(document).ready(function () {
$.get("controller/alis_controller/sql.php?islem=fatura_turlerini_getir_sql",function (result){
                if (result != 2){
                    var json = JSON.parse(result);
                    json.forEach(function (item){
                        $("#fatura_turu_alis").append("" +
                         "<option value='"+item.id+"'>"+item.fatura_turu_adi+"</option>" +
                          "");
                    })
                }
            })
$.get("controller/alis_controller/sql.php?islem=fatura_tipi_getir_sql",function (result){
                if (result != 2){
                    var json = JSON.parse(result);
                    json.forEach(function (item){
                        $("#alis_fatura_tipi").append("" +
                         "<option value='"+item.id+"'>"+item.fatura_tip_adi+"</option>" +
                          "");
                    })
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



            setTimeout(function () {

                $("#click12").trigger("click");

            }, 300);



            alis_table = $('#alis_fatura_list').DataTable({

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

                    $(row).addClass("fatura_urun_list");
                    $(row).find("td").eq(0).css("text-align","left");
                    $(row).find("td").eq(1).css("text-align","left");
                    $(row).find("td").eq(2).css("text-align","left");

                },

                "paging": false,

                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},

            });



            $("body").off("click", "#kaydi_guncelle").on("click", "#kaydi_guncelle", function () {



                var fatura_tipi = $("#fatura_tipi").val();



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



                var fatura_id = $("#faturaya_ekle").attr("data-id");





                var secilen_kdv_tutar = arr[0];



                var secilen_iskonto_tutari = arr[1];



                var secilen_toplam_tutar = arr[2];



                var secilen_miktar = arr[3];



                var secilen_birim_fiyat = arr[4];



                var secilen_tevkifat_tutari = arr[5];



                var miktar_farki = miktar - secilen_miktar;





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





                if (fatura_tipi == 1) {



                    $.ajax({



                        url: "controller/alis_controller/sql.php?islem=faturadaki_urunu_guncelle",



                        type: "POST",



                        data: {

                            stok_id: stok_id,

                            kdv_fark: kdv_fark,

                            iskonto_fark: iskonto_fark,

                            tutar_fark: tutar_fark,

                            tevkifat_fark: tevkifat_fark,

                            ara_toplam_fark: ara_toplam_fark,

                            birim_id: birim_id,

                            miktar_farki:miktar_farki,

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

                            alis_muhtelifid: fatura_id

                        },

                        success: function (result) {

                            if (result != 2) {

                                alis_table.clear();

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

                                    var birim_fiyat = parse_birim.toLocaleString("tr-TR", {minimumFractionDigits: 8, maximumFractionDigits: 8})

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

                                        $("#doviz_iskonto").html("");

                                        $("#doviz_iskonto").html(iskonto_yazi + " " + item.doviz_tur);

                                        $("#doviz_kdv").html("");

                                        $("#doviz_kdv").html(kdv_yazi + " " + item.doviz_tur);

                                        $("#doviz_ara_toplam").html("");

                                        $("#doviz_ara_toplam").html(ara_toplam_yazi + " " + item.doviz_tur);

                                        $("#doviz_genel_toplam").html("");

                                        $("#doviz_genel_toplam").html(genel_toplam_yazi + " " + item.doviz_tur);

                                        $("#doviz_tevkifat_tutar").html("");

                                        $("#doviz_tevkifat_tutar").html(tevkifat_yazi + " " + item.doviz_tur);

                                        var doviz_kuru = $("#doviz_kuru").val();

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

                                        $(".iskonto_toplam_bas").html("");

                                        $(".iskonto_toplam_bas").html(tl_iskonto + " TL");

                                        $(".kdv_toplam_bas").html("");

                                        $(".kdv_toplam_bas").html(tl_kdv + " TL");

                                        $(".ara_toplam_bas").html("");

                                        $(".ara_toplam_bas").html(tl_ara_toplam + " TL");

                                        $(".genel_toplam_bas").html("");

                                        $(".genel_toplam_bas").html(tl_genel_toplam + " TL");

                                        $(".tevkifat_tutari_bas").html("");

                                        $(".tevkifat_tutari_bas").html(tl_tevkifat + " TL");

                                    } else {

                                        $(".iskonto_toplam_bas").html("");

                                        $(".iskonto_toplam_bas").html(iskonto_yazi + " TL");

                                        $(".kdv_toplam_bas").html("");

                                        $(".kdv_toplam_bas").html(kdv_yazi + " TL");

                                        $(".ara_toplam_bas").html("");

                                        $(".ara_toplam_bas").html(ara_toplam_yazi + " TL");

                                        $(".genel_toplam_bas").html("");

                                        $(".genel_toplam_bas").html(genel_toplam_yazi + " TL");

                                        $(".tevkifat_tutari_bas").html("");

                                        $(".tevkifat_tutari_bas").html(tevkifat_yazi + " TL");

                                    }

                                    var alis_id = alis_table.row.add([item.stok_kodu, item.stok_adi, item.birim_adi, item.miktar, birim_fiyat, "%" + item.kdv_orani, kdv_fiyat + " " + item.doviz_tur, "%" + item.iskonto, iskonto_tutari + " " + item.doviz_tur, item.tevkifat_kodu, tevkifat_tutari + " " + item.doviz_tur, toplam_tutar + " " + item.doviz_tur, "<button class='btn btn-danger faturadan_eksilt' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();

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
                                });
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



                                });



                                Toast.fire({



                                    icon: 'error',



                                    title: 'Bilinmeyen Bir Hata Oluştu'



                                });



                            }



                        }



                    });



                } else {



                    $.ajax({



                        url: "controller/alis_controller/sql.php?islem=faturadaki_urunu_guncelle",



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

                            miktar_farki:miktar_farki,

                            tevkifat_tutari: tevkifat_tutari,

                            tevkifat_doviz_tutari: tevkifat_doviz_tutari,

                            id: id,

                            alis_defaultid: fatura_id

                        },



                        success: function (result) {



                            if (result != 2) {



                                alis_table.clear();



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

                                    var birim_fiyat = parse_birim.toLocaleString("tr-TR", {minimumFractionDigits: 8, maximumFractionDigits: 8})



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

                                        $("#doviz_iskonto").html("");

                                        $("#doviz_iskonto").html(iskonto_yazi + " " + item.doviz_tur);

                                        $("#doviz_kdv").html("");

                                        $("#doviz_kdv").html(kdv_yazi + " " + item.doviz_tur);

                                        $("#doviz_ara_toplam").html("");

                                        $("#doviz_ara_toplam").html(ara_toplam_yazi + " " + item.doviz_tur);

                                        $("#doviz_genel_toplam").html("");

                                        $("#doviz_genel_toplam").html(genel_toplam_yazi + " " + item.doviz_tur);

                                        $("#doviz_tevkifat_tutar").html("");

                                        $("#doviz_tevkifat_tutar").html(tevkifat_yazi + " " + item.doviz_tur);



                                        var doviz_kuru = $("#doviz_kuru").val();
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
                                        $(".iskonto_toplam_bas").html("");
                                        $(".iskonto_toplam_bas").html(tl_iskonto + " TL");
                                        $(".kdv_toplam_bas").html("");
                                        $(".kdv_toplam_bas").html(tl_kdv + " TL");
                                        $(".ara_toplam_bas").html("");
                                        $(".ara_toplam_bas").html(tl_ara_toplam + " TL");
                                        $(".genel_toplam_bas").html("");
                                        $(".genel_toplam_bas").html(tl_genel_toplam + " TL");
                                        $(".tevkifat_tutari_bas").html("");
                                        $(".tevkifat_tutari_bas").html(tl_tevkifat + " TL");
                                    } else {
                                        $(".iskonto_toplam_bas").html("");
                                        $(".iskonto_toplam_bas").html(iskonto_yazi + " TL");
                                        $(".kdv_toplam_bas").html("");
                                        $(".kdv_toplam_bas").html(kdv_yazi + " TL");
                                        $(".ara_toplam_bas").html("");
                                        $(".ara_toplam_bas").html(ara_toplam_yazi + " TL");
                                        $(".genel_toplam_bas").html("");
                                        $(".genel_toplam_bas").html(genel_toplam_yazi + " TL");
                                        $(".tevkifat_tutari_bas").html("");
                                        $(".tevkifat_tutari_bas").html(tevkifat_yazi + " TL");
                                    }
                                    var alis_id = alis_table.row.add([item.stok_kodu, item.stok_adi, item.birim_adi, item.miktar, birim_fiyat, "%" + item.kdv_orani, kdv_fiyat + " " + item.doviz_tur, "%" + item.iskonto, iskonto_tutari + " " + item.doviz_tur, item.tevkifat_kodu, tevkifat_tutari + " " + item.doviz_tur, toplam_tutar + " " + item.doviz_tur, "<button class='btn btn-danger faturadan_eksilt' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
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



                }



            })



            $("body").off("click", ".fatura_urun_list").on("click", ".fatura_urun_list", function () {

                var id = $(this).attr("data-id");

                $.get("controller/alis_controller/sql.php?islem=faturadaki_urunun_bilgilerini_getir", {id: id}, function (result) {

                    if (result != 2) {

                        $("#kaydi_guncelle").attr("data-id", id);

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





            $("body").off("click", "#faturaya_ekle").on("click", "#faturaya_ekle", function () {

                var faturaTarihi = new Date($('#fatura_tarihi').val());

                var irsaliyeTarihi = new Date($('#irsaliye_tarih').val());



                if (faturaTarihi < irsaliyeTarihi) {

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

                        title: 'İrsaliye Tarihi Fatura Tarihinden Büyük Olamaz'

                    });



                } else {

                    var fatura_tipi = $(".fatura_turu_muhtelif").val();

                    var cari_id = $(".secilen_cari").attr("data-id");

                    var doviz_tur = $(".doviz_tur_selected").val();



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

                            title: 'Cari Seçimi Veya Stok Seçimi Boş Kalamaz'

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

                        if (fatura_tipi == 1) {

                            var alis_muhtelifid = $(this).attr("data-id");

                            $.ajax({

                                url: "controller/alis_controller/sql.php?islem=muhtelif_faturaya_urun_ekle",

                                type: "POST",

                                data: {

                                    alis_muhtelifid: alis_muhtelifid,

                                    stok_id: stok_id,

                                    cari_id: cari_id,

                                    birim_id: birim_id,

                                    miktar: miktar,

                                    kdv_orani: kdv_orani,

                                    birim_fiyat: birim_fiyat,

                                    doviz_tur: doviz_tur,

                                    kdv_tutari: kdv_tutari,

                                    iskonto: iskonto,

                                    iskonto_tutari: iskonto_tutari,

                                    tevkifat_kodu: tevkifat_kodu,

                                    tevkifat_yuzde: tevkifat_yuzde,

                                    toplam_tutar: toplam_tutar,

                                    tevkifat_tutari: tevkifat_tutari,

                                    tevkifat_doviz_tutari: tevkifat_doviz_tutari

                                },

                                success: function (result) {

                                    if (result != 2 && result != 500) {

                                        $("#fatura_tipi").prop("disabled", true);

                                        alis_table.clear();

                                        var json = JSON.parse(result);

                                        json.forEach(function (item) {

                                            var fatura_id = item.alis_muhtelifid;

                                            $("#faturaya_ekle").attr("data-id", fatura_id);



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

                                            var birim_fiyat = parse_birim.toLocaleString("tr-TR", {minimumFractionDigits: 8, maximumFractionDigits: 8})



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

                                                $("#doviz_iskonto").html("");

                                                $("#doviz_iskonto").html(iskonto_yazi + " " + item.doviz_tur);

                                                $("#doviz_kdv").html("");

                                                $("#doviz_kdv").html(kdv_yazi + " " + item.doviz_tur);

                                                $("#doviz_ara_toplam").html("");

                                                $("#doviz_ara_toplam").html(ara_toplam_yazi + " " + item.doviz_tur);

                                                $("#doviz_genel_toplam").html("");

                                                $("#doviz_genel_toplam").html(genel_toplam_yazi + " " + item.doviz_tur);

                                                $("#doviz_tevkifat_tutar").html("");

                                                $("#doviz_tevkifat_tutar").html(tevkifat_yazi + " " + item.doviz_tur);



                                                var doviz_kuru = $("#doviz_kuru").val();

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

                                                $(".iskonto_toplam_bas").html("");

                                                $(".iskonto_toplam_bas").html(tl_iskonto + " TL");

                                                $(".kdv_toplam_bas").html("");

                                                $(".kdv_toplam_bas").html(tl_kdv + " TL");

                                                $(".ara_toplam_bas").html("");

                                                $(".ara_toplam_bas").html(tl_ara_toplam + " TL");

                                                $(".genel_toplam_bas").html("");

                                                $(".genel_toplam_bas").html(tl_genel_toplam + " TL");

                                                $(".tevkifat_tutari_bas").html("");

                                                $(".tevkifat_tutari_bas").html(tl_tevkifat + " TL");

                                            } else {

                                                $(".iskonto_toplam_bas").html("");

                                                $(".iskonto_toplam_bas").html(iskonto_yazi + " TL");

                                                $(".kdv_toplam_bas").html("");

                                                $(".kdv_toplam_bas").html(kdv_yazi + " TL");

                                                $(".ara_toplam_bas").html("");

                                                $(".ara_toplam_bas").html(ara_toplam_yazi + " TL");

                                                $(".genel_toplam_bas").html("");

                                                $(".genel_toplam_bas").html(genel_toplam_yazi + " TL");

                                                $(".tevkifat_tutari_bas").html("");

                                                $(".tevkifat_tutari_bas").html(tevkifat_yazi + " TL");

                                            }



                                            var alis_id = alis_table.row.add([item.stok_kodu, item.stok_adi, item.birim_adi, item.miktar, birim_fiyat, "%" + item.kdv_orani, kdv_fiyat + " " + item.doviz_tur, "%" + item.iskonto, iskonto_tutari + " " + item.doviz_tur, item.tevkifat_kodu, tevkifat_tutari + " " + item.doviz_tur, toplam_tutar + " " + item.doviz_tur, "<button class='btn btn-danger faturadan_eksilt' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();

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

                                            title: 'Ürün Oluşturuldu'

                                        })

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

                        } else {

                            var alis_defaultid = $(this).attr("data-id");

                            $.ajax({

                                url: "controller/alis_controller/sql.php?islem=faturaya_urun_ekle_sql",

                                type: "POST",

                                data: {

                                    alis_defaultid: alis_defaultid,

                                    stok_id: stok_id,

                                    birim_id: birim_id,

                                    miktar: miktar,

                                    cari_id: cari_id,

                                    kdv_orani: kdv_orani,

                                    birim_fiyat: birim_fiyat,

                                    kdv_tutari: kdv_tutari,

                                    iskonto: iskonto,

                                    iskonto_tutari: iskonto_tutari,

                                    doviz_tur: doviz_tur,

                                    tevkifat_kodu: tevkifat_kodu,

                                    tevkifat_yuzde: tevkifat_yuzde,

                                    toplam_tutar: toplam_tutar,

                                    tevkifat_tutari: tevkifat_tutari,

                                    tevkifat_doviz_tutari: tevkifat_doviz_tutari

                                },

                                success: function (result) {

                                    if (result != 2 && result != 500) {

                                        $("#fatura_tipi").prop("disabled", true);

                                        alis_table.clear();

                                        var json = JSON.parse(result);

                                        json.forEach(function (item) {

                                            var fatura_id = item.alis_defaultid;

                                            $("#faturaya_ekle").attr("data-id", fatura_id);



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

                                            var birim_fiyat = parse_birim.toLocaleString("tr-TR", {minimumFractionDigits: 8, maximumFractionDigits: 8})



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

                                                $("#doviz_iskonto").html("");

                                                $("#doviz_iskonto").html(iskonto_yazi + " " + item.doviz_tur);

                                                $("#doviz_kdv").html("");

                                                $("#doviz_kdv").html(kdv_yazi + " " + item.doviz_tur);

                                                $("#doviz_ara_toplam").html("");

                                                $("#doviz_ara_toplam").html(ara_toplam_yazi + " " + item.doviz_tur);

                                                $("#doviz_genel_toplam").html("");

                                                $("#doviz_genel_toplam").html(genel_toplam_yazi + " " + item.doviz_tur);

                                                $("#doviz_tevkifat_tutar").html("");

                                                $("#doviz_tevkifat_tutar").html(tevkifat_yazi + " " + item.doviz_tur);



                                                var doviz_kuru = $("#doviz_kuru").val();

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

                                                $(".iskonto_toplam_bas").html("");

                                                $(".iskonto_toplam_bas").html(tl_iskonto + " TL");

                                                $(".kdv_toplam_bas").html("");

                                                $(".kdv_toplam_bas").html(tl_kdv + " TL");

                                                $(".ara_toplam_bas").html("");

                                                $(".ara_toplam_bas").html(tl_ara_toplam + " TL");

                                                $(".genel_toplam_bas").html("");

                                                $(".genel_toplam_bas").html(tl_genel_toplam + " TL");

                                                $(".tevkifat_tutari_bas").html("");

                                                $(".tevkifat_tutari_bas").html(tl_tevkifat + " TL");

                                            } else {

                                                $(".iskonto_toplam_bas").html("");

                                                $(".iskonto_toplam_bas").html(iskonto_yazi + " TL");

                                                $(".kdv_toplam_bas").html("");

                                                $(".kdv_toplam_bas").html(kdv_yazi + " TL");

                                                $(".ara_toplam_bas").html("");

                                                $(".ara_toplam_bas").html(ara_toplam_yazi + " TL");

                                                $(".genel_toplam_bas").html("");

                                                $(".genel_toplam_bas").html(genel_toplam_yazi + " TL");

                                                $(".tevkifat_tutari_bas").html("");

                                                $(".tevkifat_tutari_bas").html(tevkifat_yazi + " TL");

                                            }



                                            var alis_id = alis_table.row.add([item.stok_kodu, item.stok_adi, item.birim_adi, item.miktar, birim_fiyat, "%" + item.kdv_orani, kdv_fiyat + " " + item.doviz_tur, "%" + item.iskonto, iskonto_tutari + " " + item.doviz_tur, item.tevkifat_kodu, tevkifat_tutari + " " + item.doviz_tur, toplam_tutar + " " + item.doviz_tur, "<button class='btn btn-danger faturadan_eksilt' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();

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

                                            title: 'Ürün Oluşturuldu'

                                        })

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

                        }

                    }

                }

            });



            $("body").off("click", ".faturadan_eksilt").on("click", ".faturadan_eksilt", function () {

                var id = $(this).attr("data-id");

                var fatura_turu = $("#fatura_tipi").val();

                var fatura_id = $("#faturaya_ekle").attr("data-id");

                if (fatura_turu == 1) {

                    $.ajax({

                        url: "controller/alis_controller/sql.php?islem=muhtelif_faturdan_urunu_cikart",

                        type: "POST",

                        data: {

                            id: id,

                            fatura_turu: "muhtelif",

                            fatura_id: fatura_id

                        },

                        success: function (result) {

                            if (result != 500) {

                                if (result == 2) {

                                    var doviz_tur = $("#doviz_tur").val();

                                    alis_table.clear().draw(false);

                                    if (doviz_tur != "TL") {

                                        $("#doviz_iskonto").html("");

                                        $("#doviz_iskonto").html("0,00 " + doviz_tur);

                                        $("#doviz_kdv").html("");

                                        $("#doviz_kdv").html("0,00 " + doviz_tur);

                                        $("#doviz_ara_toplam").html("");

                                        $("#doviz_ara_toplam").html("0,00 " + doviz_tur);

                                        $("#doviz_genel_toplam").html("");

                                        $("#doviz_genel_toplam").html("0,00 " + doviz_tur);

                                        $("#doviz_tevkifat_tutar").html("");

                                        $("#doviz_tevkifat_tutar").html("0,00 " + doviz_tur);



                                        $(".iskonto_toplam_bas").html("");

                                        $(".iskonto_toplam_bas").html("0,00 TL");

                                        $(".kdv_toplam_bas").html("");

                                        $(".kdv_toplam_bas").html("0,00 TL");

                                        $(".ara_toplam_bas").html("");

                                        $(".ara_toplam_bas").html("0,00 TL");

                                        $(".genel_toplam_bas").html("");

                                        $(".genel_toplam_bas").html("0,00 TL");

                                        $(".tevkifat_tutari_bas").html("");

                                        $(".tevkifat_tutari_bas").html("0,00 TL");

                                    } else {

                                        $(".iskonto_toplam_bas").html("");

                                        $(".iskonto_toplam_bas").html("0,00 TL");

                                        $(".kdv_toplam_bas").html("");

                                        $(".kdv_toplam_bas").html("0,00 TL");

                                        $(".ara_toplam_bas").html("");

                                        $(".ara_toplam_bas").html("0,00 TL");

                                        $(".genel_toplam_bas").html("");

                                        $(".genel_toplam_bas").html("0,00 TL");

                                        $(".tevkifat_tutari_bas").html("");

                                        $(".tevkifat_tutari_bas").html("0,00 TL");

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

                                        icon: 'success',

                                        title: 'Ürün Silindi'

                                    })

                                    alis_table.clear();

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

                                        var birim_fiyat = parse_birim.toLocaleString("tr-TR", {minimumFractionDigits: 8, maximumFractionDigits: 8})

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

                                            $("#doviz_iskonto").html("");

                                            $("#doviz_iskonto").html(iskonto_yazi + " " + item.doviz_tur);

                                            $("#doviz_kdv").html("");

                                            $("#doviz_kdv").html(kdv_yazi + " " + item.doviz_tur);

                                            $("#doviz_ara_toplam").html("");

                                            $("#doviz_ara_toplam").html(ara_toplam_yazi + " " + item.doviz_tur);

                                            $("#doviz_genel_toplam").html("");

                                            $("#doviz_genel_toplam").html(genel_toplam_yazi + " " + item.doviz_tur);

                                            $("#doviz_tevkifat_tutar").html("");

                                            $("#doviz_tevkifat_tutar").html(tevkifat_yazi + " " + item.doviz_tur);



                                            var doviz_kuru = $("#doviz_kuru").val();

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

                                            $(".iskonto_toplam_bas").html("");

                                            $(".iskonto_toplam_bas").html(tl_iskonto + " TL");

                                            $(".kdv_toplam_bas").html("");

                                            $(".kdv_toplam_bas").html(tl_kdv + " TL");

                                            $(".ara_toplam_bas").html("");

                                            $(".ara_toplam_bas").html(tl_ara_toplam + " TL");

                                            $(".genel_toplam_bas").html("");

                                            $(".genel_toplam_bas").html(tl_genel_toplam + " TL");

                                            $(".tevkifat_tutari_bas").html("");

                                            $(".tevkifat_tutari_bas").html(tl_tevkifat + " TL");

                                        } else {

                                            $(".iskonto_toplam_bas").html("");

                                            $(".iskonto_toplam_bas").html(iskonto_yazi + " TL");

                                            $(".kdv_toplam_bas").html("");

                                            $(".kdv_toplam_bas").html(kdv_yazi + " TL");

                                            $(".ara_toplam_bas").html("");

                                            $(".ara_toplam_bas").html(ara_toplam_yazi + " TL");

                                            $(".genel_toplam_bas").html("");

                                            $(".genel_toplam_bas").html(genel_toplam_yazi + " TL");

                                            $(".tevkifat_tutari_bas").html("");

                                            $(".tevkifat_tutari_bas").html(tevkifat_yazi + " TL");

                                        }

                                        var alis_id = alis_table.row.add([item.stok_kodu, item.stok_adi, item.birim_adi, item.miktar, birim_fiyat, "%" + item.kdv_orani, kdv_fiyat + " " + item.doviz_tur, "%" + item.iskonto, iskonto_tutari + " " + item.doviz_tur, item.tevkifat_kodu, tevkifat_tutari + " " + item.doviz_tur, toplam_tutar + " " + item.doviz_tur, "<button class='btn btn-danger faturadan_eksilt' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();

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

                    })

                } else {

                    $.ajax({

                        url: "controller/alis_controller/sql.php?islem=urunu_faturadan_cikart",

                        type: "POST",

                        data: {

                            id: id,

                            fatura_turu: "default",

                            fatura_id: fatura_id

                        },

                        success: function (result) {

                            if (result != 500) {

                                if (result == 2) {

                                    var doviz_tur = $("#doviz_tur").val();

                                    alis_table.clear().draw(false);

                                    if (doviz_tur != "TL") {

                                        $("#doviz_iskonto").html("");

                                        $("#doviz_iskonto").html("0,00 " + doviz_tur);

                                        $("#doviz_kdv").html("");

                                        $("#doviz_kdv").html("0,00 " + doviz_tur);

                                        $("#doviz_ara_toplam").html("");

                                        $("#doviz_ara_toplam").html("0,00 " + doviz_tur);

                                        $("#doviz_genel_toplam").html("");

                                        $("#doviz_genel_toplam").html("0,00 " + doviz_tur);

                                        $("#doviz_tevkifat_tutar").html("");

                                        $("#doviz_tevkifat_tutar").html("0,00 " + doviz_tur);



                                        $(".iskonto_toplam_bas").html("");

                                        $(".iskonto_toplam_bas").html("0,00 TL");

                                        $(".kdv_toplam_bas").html("");

                                        $(".kdv_toplam_bas").html("0,00 TL");

                                        $(".ara_toplam_bas").html("");

                                        $(".ara_toplam_bas").html("0,00 TL");

                                        $(".genel_toplam_bas").html("");

                                        $(".genel_toplam_bas").html("0,00 TL");

                                        $(".tevkifat_tutari_bas").html("");

                                        $(".tevkifat_tutari_bas").html("0,00 TL");

                                    } else {

                                        $(".iskonto_toplam_bas").html("");

                                        $(".iskonto_toplam_bas").html("0,00 TL");

                                        $(".kdv_toplam_bas").html("");

                                        $(".kdv_toplam_bas").html("0,00 TL");

                                        $(".ara_toplam_bas").html("");

                                        $(".ara_toplam_bas").html("0,00 TL");

                                        $(".genel_toplam_bas").html("");

                                        $(".genel_toplam_bas").html("0,00 TL");

                                        $(".tevkifat_tutari_bas").html("");

                                        $(".tevkifat_tutari_bas").html("0,00 TL");

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

                                        icon: 'success',

                                        title: 'Ürün Silindi'

                                    })

                                    alis_table.clear();

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

                                        var birim_fiyat = parse_birim.toLocaleString("tr-TR", {minimumFractionDigits: 8, maximumFractionDigits: 8})



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

                                            $("#doviz_iskonto").html("");

                                            $("#doviz_iskonto").html(iskonto_yazi + " " + item.doviz_tur);

                                            $("#doviz_kdv").html("");

                                            $("#doviz_kdv").html(kdv_yazi + " " + item.doviz_tur);

                                            $("#doviz_ara_toplam").html("");

                                            $("#doviz_ara_toplam").html(ara_toplam_yazi + " " + item.doviz_tur);

                                            $("#doviz_genel_toplam").html("");

                                            $("#doviz_genel_toplam").html(genel_toplam_yazi + " " + item.doviz_tur);

                                            $("#doviz_tevkifat_tutar").html("");

                                            $("#doviz_tevkifat_tutar").html(tevkifat_yazi + " " + item.doviz_tur);



                                            var doviz_kuru = $("#doviz_kuru").val();

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

                                            $(".iskonto_toplam_bas").html("");

                                            $(".iskonto_toplam_bas").html(tl_iskonto + " TL");

                                            $(".kdv_toplam_bas").html("");

                                            $(".kdv_toplam_bas").html(tl_kdv + " TL");

                                            $(".ara_toplam_bas").html("");

                                            $(".ara_toplam_bas").html(tl_ara_toplam + " TL");

                                            $(".genel_toplam_bas").html("");

                                            $(".genel_toplam_bas").html(tl_genel_toplam + " TL");

                                            $(".tevkifat_tutari_bas").html("");

                                            $(".tevkifat_tutari_bas").html(tl_tevkifat + " TL");

                                        } else {

                                            $(".iskonto_toplam_bas").html("");

                                            $(".iskonto_toplam_bas").html(iskonto_yazi + " TL");

                                            $(".kdv_toplam_bas").html("");

                                            $(".kdv_toplam_bas").html(kdv_yazi + " TL");

                                            $(".ara_toplam_bas").html("");

                                            $(".ara_toplam_bas").html(ara_toplam_yazi + " TL");

                                            $(".genel_toplam_bas").html("");

                                            $(".genel_toplam_bas").html(genel_toplam_yazi + " TL");

                                            $(".tevkifat_tutari_bas").html("");

                                            $(".tevkifat_tutari_bas").html(tevkifat_yazi + " TL");

                                        }

                                        var alis_id = alis_table.row.add([item.stok_kodu, item.stok_adi, item.birim_adi, item.miktar, birim_fiyat, "%" + item.kdv_orani, kdv_fiyat + " " + item.doviz_tur, "%" + item.iskonto, iskonto_tutari + " " + item.doviz_tur, item.tevkifat_kodu, tevkifat_tutari + " " + item.doviz_tur, toplam_tutar + " " + item.doviz_tur, "<button class='btn btn-danger faturadan_eksilt' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();

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

                    })

                }

            });





            $("body").off("click", "#stok_adi").on("click", "#stok_adi", function () {

                $.get("modals/alis_modal/modal_page.php?islem=stok_kartlari_getir_modal", function (getModal) {

                    $("#stok_adi_getir_div").html("");

                    $("#stok_adi_getir_div").html(getModal);

                })

            });



            $("#alis_fatura_modal").modal("show");

            $.get("controller/alis_controller/sql.php?islem=birimleri_getir", function (result) {

                if (result != 2) {

                    var json = JSON.parse(result);

                    json.forEach(function (item) {

                        var birimAdi = item.birim_adi;

                        $(".gelecek_birim").append("" +

                            "<option value='" + item.id + "'>" + birimAdi + "</option>" +

                            "");

                    })

                }

            });

            $.get("controller/alis_controller/sql.php?islem=depolari_getir", function (result) {

                if (result != 2) {

                    var json = JSON.parse(result);

                    json.forEach(function (item) {

                        var depo_adi = item.depo_adi
                        let varsayilan = item.varsayilan_depo;
                        let selected = "";
                        if (varsayilan == 1){
                            selected = "selected";
                        }

                        $("#depo_id").append("" +

                            "<option "+selected+" value='" + item.id + "'>" + depo_adi + "</option>" +

                            "");

                    })

                }

            })

        })



        $("body").off("click", "#fatura_olustur").on("click", "#fatura_olustur", function () {
                var cari_id = $(".secilen_cari").attr("data-id");
                let cari_kodu = $(".secilen_cari").val();
                var fatura_turu = $("#fatura_turu_alis").val();
                var fatura_no = $(".fatura_no_alis_fatura").val();
                var fatura_tarihi = $("#fatura_tarihi").val();
                var vade_tarihi = $("#vade_tarihi").val();
                var doviz_tur = $("#doviz_tur").val();
                var irsaliye_no = $("#irsaliye_no").val();
                var irsaliye_tarih = $("#irsaliye_tarih").val();
                var depo_id = $("#depo_id").val();
                var doviz_kuru = $("#doviz_kuru").val();
                var fatura_id = $("#faturaya_ekle").attr("data-id");
                var alis_fatura_tipi = $("#alis_fatura_tipi").val();
                var fatura_tipi = $("#fatura_tipi").val();
                var aciklama = $(".aciklama_siparis").val();
                var kur_fiyat = $("#doviz_kuru").val();
                var faturaTarihi = new Date($('#fatura_tarihi').val());
                var irsaliyeTarihi = new Date($('#irsaliye_tarih').val());
                if (faturaTarihi < irsaliyeTarihi) {
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
                        title: 'İrsaliye Tarihi Fatura Tarihinden Büyük Olamaz'
                    });
                }else if (faturaTarihi == "0000-00-00"){
                    Swal.fire(
                        "Uyarı!",
                        "Lütfen Geçerli Bir Fatura Tarihi Giriniz",
                        "warning"
                    )
                }else if (fatura_turu == ""){
                    Swal.fire(
                        "Uyarı!",
                        "Lütfen Fatura Türü Giriniz...",
                        "warning"
                    )
                }else if (alis_fatura_tipi == ""){
                    Swal.fire(
                        "Uyarı!",
                        "Lütfen Fatura Tipi Giriniz...",
                        "warning"
                    )
                }else {
                    if (depo_id == "") {
                        Swal.fire(
                            'Uyarı!',
                            'Lütfen Bir Depo Giriniz',
                            'warning'
                        );
                    } else {
                        $.ajax({
                            url: "controller/alis_controller/sql.php?islem=faturayi_guncelle_sql",
                            type: "POST",
                            data: {
                                cari_id: cari_id,
                                id: fatura_id,
                                kur_fiyat: kur_fiyat,
                                cari_kodu: cari_kodu,
                                fatura_turu: fatura_turu,
                                aciklama: aciklama,
                                fatura_no: fatura_no,
                                fatura_tarihi: fatura_tarihi,
                                fatura_tipi:alis_fatura_tipi,
                                vade_tarihi: vade_tarihi,
                                doviz_tur: doviz_tur,
                                irsaliye_no: irsaliye_no,
                                irsaliye_tarih: irsaliye_tarih,
                                depo_id: depo_id,
                                doviz_kuru: doviz_kuru,
                                muhtelif_tipi: fatura_tipi
                            },
                            success: function (result) {
                                if (result != 2) {
                                    if (result == 300) {
                                        Swal.fire(
                                            'Uyarı!',
                                            'Bu Fatura Numarası Zaten Kayıtlı',
                                            'warning'
                                        );
                                    } else {
                                        var implode = result.split(":");
                                        var id = implode[1];
                                        $("#faturaya_ekle").attr("data-id", id);
                                        $(".shadow_buttons").hide();
                                        $(".fatura_icerik").css("display", "block");
                                        $.get("view/alis_fatura.php", function (getList) {
                                            $(".modal-icerik").html("");
                                            $(".modal-icerik").html(getList);
                                        })
                                        $.get("view/alis_fatura.php", function (getList) {
                                            $(".admin-modal-icerik").html("");
                                            $(".admin-modal-icerik").html(getList);
                                        })
                                        Swal.fire(
                                            'Başarılı!',
                                            'Fatura Kaydedildi',
                                            'success'
                                        );
                                        $("#alis_fatura_modal").modal("hide");
                                    }
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
                }
            })





        var toplam_tutar = 0;



        $(".birim_fiyat").focusout(function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)){
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 8, maximumFractionDigits: 8})
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



        $("body").off("click", "#cari_getir_modal").on("click", "#cari_getir_modal", function () {

            $.get("modals/alis_modal/modal_page.php?islem=cariler_listesi_getir_modal", function (getModal) {

                $("#carileri_getir_div").html(getModal);

            })

        });



        $("body").off("click", ".modal_kapali").on("click", ".modal_kapali", function () {

            var silinecek_id = $("#faturaya_ekle").attr("data-id");
            
            if (silinecek_id != "") {

                $.ajax({

                    url: "controller/alis_controller/sql.php?islem=faturayi_iptal_et_sql",

                    type: "POST",

                    data: {

                        id: silinecek_id

                    },

                    success: function (result) {

                        if (result == 1) {

                            $("#alis_fatura_modal").modal("hide");

                        } else {

                            $("#alis_fatura_modal").modal("hide");

                        }

                    }

                });

            } else {

                $("#alis_fatura_modal").modal("hide");

            }

        });

        $("body").off("click", "#cariye_ait_irsaliyeler").on("click", "#cariye_ait_irsaliyeler", function () {

            var cari_id = $("#cari_id").attr("data-id");

            let fatura_main_id = $("#faturaya_ekle").attr("data-id");
            alis_table.clear().draw(false);
            $("#doviz_ara_toplam,#doviz_kdv,#doviz_tevkifat_tutar,#doviz_iskonto,#doviz_genel_toplam").html("0,00 TL");
            $(".ara_toplam_bas,.kdv_toplam_bas,.tevkifat_tutari_bas,.iskonto_toplam_bas,.genel_toplam_bas").html("0,00 TL");
            $.ajax({

                    url: "controller/alis_controller/sql.php?islem=faturayi_iptal_et_sql",

                    type: "POST",

                    data: {

                        id: fatura_main_id

                    }

                });

            if (cari_id == "" || cari_id == undefined){

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

                    title: 'Lütfen Bir Cari Seçiniz'

                });

            }else {

                $.get("modals/alis_modal/modal.php?islem=cariye_ait_irsaliyeleri_getir", {cari_id: cari_id}, function (getModal) {

                    $("#cariye_ait_irsaliye").html("");

                    $("#cariye_ait_irsaliye").html(getModal);

                })

            }

        })

    </script>

    <?php

}

if ($islem == "cariye_ait_irsaliyeleri_getir") {

    $id = $_GET["cari_id"];

    ?>
    
    <div class="modal fade" data-backdrop="static" id="cariye_ait_irsaliyeler_modal"

         data-bs-keyboard="false" role="dialog">

        <div class="modal-dialog"

             style="width: 55%; max-width: 55%;">

            <div class="modal-content">

                <div class="modal-header text-white p-2">Cariye Ait İrsaliye Listesi

                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"

                            aria-label="Close"></button>

                </div>

                <div class="modal-body">
                <div class="col-12 row no-gutters">
                <div class="col-2">
                <input type="date" class="form-control form-control-sm bas_tarih_aktar" id="" value="<?=date("1883-m-d")?>">
</div>
                <div class="col-2">
                <input type="date" class="form-control form-control-sm bit_tarih_aktar" id="" value="<?=date("Y-m-d")?>">
</div>
<div class="col-1 mx-1">

<button class="btn btn-secondary btn-sm" id="irsaliye_filtrele"><i class="fa fa-filter"></i> Hazırla</button>
</div>
                <div class="col-1 mx-1">

<button class="btn btn-primary btn-sm" id="alis_irsaliyeden_aktar_tumunu_secmek_icin_button"><i class="fa fa-check"></i> Tümünü Seç</button>
</div>

</div>
                    <div class="col-md-12 row">

                        <table class="table table-sm table-bordered w-100 display nowrap"

                               style="cursor:pointer;font-size: 13px;"

                               id="cariye_ait_siparis_listesi">

                            <thead>

                            <tr>

                                <th id="click1245">Seç</th>
                                <th>Geldiği Yer</th>
                                <th>İrsaliye No</th>
                                <th>İrsaliye Tarihi</th>
                                <th>Stok Kodu</th>
                                <th>Stok Adı</th>
                                <th>Birim</th>
                                <th>Döviz Türü</th>
                                <th>Miktar</th>
                                <th>Açıklama</th>
                                <th>Fiyat</th>

                            </tr>

                            </thead>

                        </table>

                    </div>

                </div>

                <div class="modal-footer">

                    <button class="btn btn-danger btn-sm" id="modal_kapat"><i class="fa fa-close"></i> Kapat

                    </button>

                    <button class="btn btn-success btn-sm" id="secilenleri_faturaya_aktar"><i

                                class="fa fa-download"></i> Seçilenleri Aktar

                    </button>

                </div>

            </div>

        </div>

    </div>

    <script>

        document.addEventListener('keydown', function (event) {

            if (event.key === 'Escape') {

                $("#cariye_ait_irsaliyeler_modal").modal("hide");

            }

        });
        var irsaliye_table = "";

        $("body").off("click","#irsaliye_filtrele").on("click","#irsaliye_filtrele",function (){
            let bas_tarih = $(".bas_tarih_aktar").val();
            let bit_tarih = $(".bit_tarih_aktar").val();
            $.get("controller/alis_controller/sql.php?islem=cariye_ait_irsaliyeler_getir_sql", {
                cari_id: "<?=$id?>",
                bas_tarih:bas_tarih,
                bit_tarih:bit_tarih
                }, function (result) {

                if (result != 2) {

                    var json = JSON.parse(result);
                    irsaliye_table.clear().draw(false);
                    json.forEach(function (item) {
                        if ("hizmet_id" in item){
                            let fatura_tarihi = item.irsaliye_tarih;
                            fatura_tarihi = fatura_tarihi.split(" ");
                            fatura_tarihi = fatura_tarihi[0];
                            fatura_tarihi = fatura_tarihi.split("-");
                            let gun = fatura_tarihi[2];
                            let ay = fatura_tarihi[1];
                            let yil = fatura_tarihi[0];
                            let arr = [gun,ay,yil];
                            fatura_tarihi = arr.join("/");
                        let fiyat = item.alis_fiyat;
                        fiyat = parseFloat(fiyat);
                        fiyat = fiyat.toLocaleString("tr-TR",{minimumFractionDigits:2,maximumFractionDigits:2});
                            irsaliye_table.row.add(["<input type='checkbox' class='secilen_ek_hizmetler' data-id='" + item.id + "'/>","Konteyner Ek Hizmet", item.irsaliye_no, fatura_tarihi, item.stok_kodu, item.stok_adi, item.birim_adi, "TL", 1 + " " + item.birim_adi,item.konteyner_no1,fiyat]).draw(false);
                        }else if ("demoraj_tarihi" in item){
                            let fatura_tarihi = item.tarih;
                            fatura_tarihi = fatura_tarihi.split(" ");
                            fatura_tarihi = fatura_tarihi[0];
                            fatura_tarihi = fatura_tarihi.split("-");
                            let gun = fatura_tarihi[2];
                            let ay = fatura_tarihi[1];
                            let yil = fatura_tarihi[0];
                            let arr = [gun,ay,yil];
                            fatura_tarihi = arr.join("/");
                        let fiyat = item.arac_kirasi;
                        fiyat = parseFloat(fiyat);
                        fiyat = fiyat.toLocaleString("tr-TR",{minimumFractionDigits:2,maximumFractionDigits:2});
                            irsaliye_table.row.add(["<input type='checkbox' class='depo_giris_kiralik' data-id='" + item.id + "'/>", "Depo Giriş","", fatura_tarihi, item.stok_kodu, item.stok_adi, "ADET", "TL", 1 + " ADET",item.konteyner_no,fiyat]).draw(false);
                        }else if ("stok_kiralik" in item){
                            let fatura_tarihi = item.cikis_tarih;
                            fatura_tarihi = fatura_tarihi.split(" ");
                            fatura_tarihi = fatura_tarihi[0];
                            fatura_tarihi = fatura_tarihi.split("-");
                            let gun = fatura_tarihi[2];
                            let ay = fatura_tarihi[1];
                            let yil = fatura_tarihi[0];
                            let arr = [gun,ay,yil];
                            fatura_tarihi = arr.join("/");
                        let fiyat = item.arac_kirasi;
                        fiyat = parseFloat(fiyat);
                        fiyat = fiyat.toLocaleString("tr-TR",{minimumFractionDigits:2,maximumFractionDigits:2});
                            irsaliye_table.row.add(["<input type='checkbox' class='depo_cikis_kiralik' data-id='" + item.id + "'/>", "Depo Çıkış","", fatura_tarihi, item.stok_kiralik, item.stok_adi, "ADET", "TL", 1 + " ADET",item.konteyner_no,fiyat]).draw(false);
                        }else if ("depocu_free_time" in item){
                            let fatura_tarihi = item.cikis_tarih;
                            fatura_tarihi = fatura_tarihi.split(" ");
                            fatura_tarihi = fatura_tarihi[0];
                            fatura_tarihi = fatura_tarihi.split("-");
                            let gun = fatura_tarihi[2];
                            let ay = fatura_tarihi[1];
                            let yil = fatura_tarihi[0];
                            let arr = [gun,ay,yil];
                            fatura_tarihi = arr.join("/");
                        let fiyat = item.depo_bedeli;
                        fiyat = parseFloat(fiyat);
                        fiyat = fiyat.toLocaleString("tr-TR",{minimumFractionDigits:2,maximumFractionDigits:2});
                            irsaliye_table.row.add(["<input type='checkbox' class='depo_cikis_firma' data-id='" + item.id + "'/>", "Depo İrsaliye","", fatura_tarihi, item.stok_kodu, item.stok_adi, "ADET", "TL", 1 + " ADET",item.konteyner_no,fiyat]).draw(false);
                        }else {
                        var fatura_tarihi = item.irsaliye_tarihi;
                        var explode1 = fatura_tarihi.split(" ");
                        var explode_cikti1 = explode1[0];
                        var explode2 = explode_cikti1.split("-");
                        var gun = explode2[2];
                        var ay = explode2[1];
                        var yil = explode2[0];
                        var arr = [gun, ay, yil];
                        var irsaliye_tarihi_bas = arr.join("/");
                        let fiyat = item.genel_toplam;
                        fiyat = parseFloat(fiyat);
                        fiyat = fiyat.toLocaleString("tr-TR",{minimumFractionDigits:2,maximumFractionDigits:2});
                        irsaliye_table.row.add(["<input type='checkbox' class='alis_secilen_irsaliyeler' data-id='" + item.ai_id + "'/>","Alış İrsaliyeleri", item.irsaliye_no, irsaliye_tarihi_bas, item.stok_kodu, item.stok_adi, item.birim_adi, item.doviz_tur, item.miktar + " " + item.birim_adi,item.aciklama,fiyat]).draw(false);
                        }
                    })

                }else {
                    irsaliye_table.clear().draw(false);
                }

            })
        });

        $("body").off("click","#alis_irsaliyeden_aktar_tumunu_secmek_icin_button").on("click","#alis_irsaliyeden_aktar_tumunu_secmek_icin_button",function (){
            $("input[type='checkbox']").prop("checked",true);
        });

        $(document).ready(function () {
            setTimeout(function () {
                $("#click1245").trigger("click");

            }, 600);

            $("#cariye_ait_irsaliyeler_modal").modal("show");
            irsaliye_table = $('#cariye_ait_siparis_listesi').DataTable({

                scrollY: '35vh',

                scrollX: true,

                "paging": false,

                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},

                createdRow: function (row) {

                    $(row).addClass("cariye_ait_irsaliye_select");
                    $(row).find("td").css("text-align","left");
                    $(row).find("td").eq(7).css("text-align","right");

                }

            })

            $.get("controller/alis_controller/sql.php?islem=cariye_ait_irsaliyeler_getir_sql", {cari_id: "<?=$id?>"}, function (result) {

                if (result != 2) {

                    var json = JSON.parse(result);

                    json.forEach(function (item) {
                        if ("hizmet_id" in item){
                            let fatura_tarihi = item.irsaliye_tarih;
                            fatura_tarihi = fatura_tarihi.split(" ");
                            fatura_tarihi = fatura_tarihi[0];
                            fatura_tarihi = fatura_tarihi.split("-");
                            let gun = fatura_tarihi[2];
                            let ay = fatura_tarihi[1];
                            let yil = fatura_tarihi[0];
                            let arr = [gun,ay,yil];
                            fatura_tarihi = arr.join("/");
                        let fiyat = item.alis_fiyat;
                        fiyat = parseFloat(fiyat);
                        fiyat = fiyat.toLocaleString("tr-TR",{minimumFractionDigits:2,maximumFractionDigits:2});
                            irsaliye_table.row.add(["<input type='checkbox' class='secilen_ek_hizmetler' data-id='" + item.id + "'/>","Konteyner Ek Hizmet", item.irsaliye_no, fatura_tarihi, item.stok_kodu, item.stok_adi, item.birim_adi, "TL", 1 + " " + item.birim_adi,item.konteyner_no1,fiyat]).draw(false);
                        }else if ("demoraj_tarihi" in item){
                            let fatura_tarihi = item.tarih;
                            fatura_tarihi = fatura_tarihi.split(" ");
                            fatura_tarihi = fatura_tarihi[0];
                            fatura_tarihi = fatura_tarihi.split("-");
                            let gun = fatura_tarihi[2];
                            let ay = fatura_tarihi[1];
                            let yil = fatura_tarihi[0];
                            let arr = [gun,ay,yil];
                            fatura_tarihi = arr.join("/");
                        let fiyat = item.arac_kirasi;
                        fiyat = parseFloat(fiyat);
                        fiyat = fiyat.toLocaleString("tr-TR",{minimumFractionDigits:2,maximumFractionDigits:2});
                            irsaliye_table.row.add(["<input type='checkbox' class='depo_giris_kiralik' data-id='" + item.id + "'/>", "Depo Giriş","", fatura_tarihi, item.stok_kodu, item.stok_adi, "ADET", "TL", 1 + " ADET",item.konteyner_no,fiyat]).draw(false);
                        }else if ("stok_kiralik" in item){
                            let fatura_tarihi = item.cikis_tarih;
                            fatura_tarihi = fatura_tarihi.split(" ");
                            fatura_tarihi = fatura_tarihi[0];
                            fatura_tarihi = fatura_tarihi.split("-");
                            let gun = fatura_tarihi[2];
                            let ay = fatura_tarihi[1];
                            let yil = fatura_tarihi[0];
                            let arr = [gun,ay,yil];
                            fatura_tarihi = arr.join("/");
                        let fiyat = item.arac_kirasi;
                        fiyat = parseFloat(fiyat);
                        fiyat = fiyat.toLocaleString("tr-TR",{minimumFractionDigits:2,maximumFractionDigits:2});
                            irsaliye_table.row.add(["<input type='checkbox' class='depo_cikis_kiralik' data-id='" + item.id + "'/>", "Depo Çıkış","", fatura_tarihi, item.stok_kiralik, item.stok_adi, "ADET", "TL", 1 + " ADET",item.konteyner_no,fiyat]).draw(false);
                        }else if ("depocu_free_time" in item){
                            let fatura_tarihi = item.cikis_tarih;
                            fatura_tarihi = fatura_tarihi.split(" ");
                            fatura_tarihi = fatura_tarihi[0];
                            fatura_tarihi = fatura_tarihi.split("-");
                            let gun = fatura_tarihi[2];
                            let ay = fatura_tarihi[1];
                            let yil = fatura_tarihi[0];
                            let arr = [gun,ay,yil];
                            fatura_tarihi = arr.join("/");
                        let fiyat = item.depo_bedeli;
                        fiyat = parseFloat(fiyat);
                        fiyat = fiyat.toLocaleString("tr-TR",{minimumFractionDigits:2,maximumFractionDigits:2});
                            irsaliye_table.row.add(["<input type='checkbox' class='depo_cikis_firma' data-id='" + item.id + "'/>", "Depo İrsaliye","", fatura_tarihi, item.stok_kodu, item.stok_adi, "ADET", "TL", 1 + " ADET",item.konteyner_no,fiyat]).draw(false);
                        }else {
                        var fatura_tarihi = item.irsaliye_tarihi;
                        var explode1 = fatura_tarihi.split(" ");
                        var explode_cikti1 = explode1[0];
                        var explode2 = explode_cikti1.split("-");
                        var gun = explode2[2];
                        var ay = explode2[1];
                        var yil = explode2[0];
                        var arr = [gun, ay, yil];
                        var irsaliye_tarihi_bas = arr.join("/");
                        let fiyat = item.genel_toplam;
                        fiyat = parseFloat(fiyat);
                        fiyat = fiyat.toLocaleString("tr-TR",{minimumFractionDigits:2,maximumFractionDigits:2});
                        irsaliye_table.row.add(["<input type='checkbox' class='alis_secilen_irsaliyeler' data-id='" + item.ai_id + "'/>","Alış İrsaliyeleri", item.irsaliye_no, irsaliye_tarihi_bas, item.stok_kodu, item.stok_adi, item.birim_adi, item.doviz_tur, item.miktar + " " + item.birim_adi,item.aciklama,fiyat]).draw(false);
                        }
                    })

                }

            })

        });

        $("body").off("click", "#secilenleri_faturaya_aktar").on("click", "#secilenleri_faturaya_aktar", function () {

            var checkboxes = document.querySelectorAll(".alis_secilen_irsaliyeler"); // Tüm checkbox'ları seçer
            var select_alis_irsaliye = [];
            checkboxes.forEach(function (checkbox) {

                if (checkbox.checked) {

                    select_alis_irsaliye.push(checkbox.getAttribute("data-id")); // Seçili checkbox'ın data-id değerini alır ve diziye ekler

                }

            });

            var checkboxes2 = document.querySelectorAll(".depo_cikis_firma"); // Tüm checkbox'ları seçer
            var select_depo_cikis_firma = [];
            checkboxes2.forEach(function (checkbox) {

                if (checkbox.checked) {

                    select_depo_cikis_firma.push(checkbox.getAttribute("data-id")); // Seçili checkbox'ın data-id değerini alır ve diziye ekler

                }

            });

            var checkboxes3 = document.querySelectorAll(".depo_giris_kiralik"); // Tüm checkbox'ları seçer
            var select_giris_kiralik = [];
            checkboxes3.forEach(function (checkbox) {

                if (checkbox.checked) {

                    select_giris_kiralik.push(checkbox.getAttribute("data-id")); // Seçili checkbox'ın data-id değerini alır ve diziye ekler

                }

            });

            var checkboxes4 = document.querySelectorAll(".depo_cikis_kiralik"); // Tüm checkbox'ları seçer
            var select_cikis_kiralik = [];
            checkboxes4.forEach(function (checkbox) {

                if (checkbox.checked) {

                    select_cikis_kiralik.push(checkbox.getAttribute("data-id")); // Seçili checkbox'ın data-id değerini alır ve diziye ekler

                }

            })

            var checkboxes1 = document.querySelectorAll(".secilen_ek_hizmetler"); // Tüm checkbox'ları seçer
            var ek_hizmet_arr = [];
            checkboxes1.forEach(function (checkbox) {

                if (checkbox.checked) {
                    ek_hizmet_arr.push(checkbox.getAttribute("data-id")); // Seçili checkbox'ın data-id değerini alır ve diziye ekler

                }

            });
            let kayit_sayisi = 0;
            $(".cariye_ait_irsaliye_select").each(function (){
                let checkbox = $(this).find("td:eq(0) input");
                if (checkbox.prop("checked")){
                    kayit_sayisi += 1;
                }
            });


            var fatura_tipi = $("#fatura_tipi").val();
            if (kayit_sayisi == 0){
                Swal.fire(
                    "Uyarı",
                    "Herhangi Bir Kayıt Seçmediniz!",
                    "warning"
                )
            }else {
             $.ajax({
                url:"controller/alis_controller/sql.php?islem=aktarma_icin_satis_faturasi_olustur_sql",
                type:"POST",
                data:{
                    cari_id:"<?=$id?>"
                },
                success:function (response){
                    if (response != 2){
                        var satis_id = response;
                        satis_id = satis_id.split(":");
                        satis_id = satis_id[1];
                        $("#faturaya_ekle").attr("data-id",satis_id);
                        $.ajax({
                            url: "controller/alis_controller/sql.php?islem=secilen_irsaliyeyi_faturalastir",
                            type: "POST",
                            data: {
                                select_alis_irsaliye: select_alis_irsaliye,
                                ek_hizmet_arr: ek_hizmet_arr,
                                select_depo_cikis_firma: select_depo_cikis_firma,
                                select_giris_kiralik: select_giris_kiralik,
                                select_cikis_kiralik: select_cikis_kiralik,
                                satis_defaultid:satis_id
                                },
                            success: function (result) {
                                let ara_toplam = 0;
                                let kdv_toplam = 0;
                                let tevkifat_toplam = 0;
                                let iskonto_toplam = 0;
                                let genel_toplam = 0;
                                if (result != 2) {
                                    var json = JSON.parse(result);
                                    let irsaliye_id = 0;
                                    json.forEach(function (item) {
                                        let birim_t = item.birim_fiyat;
                                        let m = item.miktar;
                                        m = parseFloat(m);
                                        birim_t = parseFloat(birim_t);
                                        let ara_t = birim_t * m;
                                        ara_t = parseFloat(ara_t);
                                        ara_toplam += ara_t;

                                        let kdv_t = item.kdv_tutari;
                                        kdv_t = parseFloat(kdv_t);
                                        kdv_toplam += kdv_t;

                                        let iskonto_t = item.iskonto_tutari;
                                        iskonto_t = parseFloat(iskonto_t);
                                        iskonto_toplam += iskonto_t;

                                        let tevkifat_t = item.tevkifat_tutari;
                                        tevkifat_t = parseFloat(tevkifat_t);
                                        tevkifat_toplam += tevkifat_t;

                                        let toplam_t = item.toplam_tutar;
                                        toplam_t = parseFloat(toplam_t);
                                        genel_toplam += toplam_t;

                                    irsaliye_id = item.alis_defaultid;
                                        var birimFiyat = item.birim_fiyat;
                                        var parse_birim = parseFloat(birimFiyat);
                                        var birim_fiyat = parse_birim.toLocaleString("tr-TR", {minimumFractionDigits: 8, maximumFractionDigits: 8});
                                        var kdvTutari = item.kdv_tutari;
                                        var parse_kdv = parseFloat(kdvTutari);
                                        var kdv_fiyat = parse_kdv.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                                        var iskontoTutari = item.iskonto_tutari;
                                        var parse_iskonto = parseFloat(iskontoTutari);
                                        var iskonto_tutari = parse_iskonto.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                                        var tevkifatTutari = item.tevkifat_tutari;
                                        var parse_tevkifat = parseFloat(tevkifatTutari);
                                        var tevkifat_tutari = parse_tevkifat.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                                        var toplamTutar = item.toplam_tutar;
                                        var parse_toplam = parseFloat(toplamTutar);
                                        var toplam_tutar = parse_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                                        let alis_id = alis_table.row.add([item.stok_kodu, item.stok_adi, item.birim_adi, item.miktar, birim_fiyat, "%" + item.kdv_orani, kdv_fiyat + " " + item.doviz_tur, "%" + item.iskonto, iskonto_tutari + " " + item.doviz_tur, item.tevkifat_kodu, tevkifat_tutari + " " + item.doviz_tur, toplam_tutar + " " + item.doviz_tur, ""]).draw(false).node();
                                        $("#kaydi_guncelle_satis").prop("disabled",true);
                                        $(alis_id).attr("data-id", item.id);
                                    });
                                    $.get("controller/alis_controller/sql.php?islem=secilen_fatura_bilgilerini_getir", {
                                        id: irsaliye_id,
                                        genel_toplam:genel_toplam,
                                        kdv_toplam:kdv_toplam,
                                        ara_toplam:ara_toplam,
                                        iskonto_toplam:iskonto_toplam,
                                        tevkifat_toplam:tevkifat_toplam
                                    }, function (result) {
                                        var item = JSON.parse(result);
                                        $("#irsaliye_no").val(item.irsaliye_no);
                                        $("#cariye_ait_irsaliyeler_modal").modal("hide");
                                        $(".secilen_cari_irsaliye").attr("data-id", item.cari_id);
                                        $.get("controller/satis_controller/sql.php?islem=secilen_cari_bilgileri", {id: item.cari_id}, function (result2) {
                                            var item = JSON.parse(result2);
                                            $(".cari_telefon_irsaliye").val(item.telefon);
                                            $(".cari_adi_getir_irsaliye").val((item.cari_adi));
                                            $(".secilen_cari_irsaliye").attr("data-id", item.cari_id);
                                            $(".secilen_cari_irsaliye").val(item.cari_kodu);
                                            if (item.yetkili_adi1 != null) {
                                                $(".yetkili_adi_irsaliye").val((item.yetkili_adi1));
                                                $(".yetkili_cep_irsaliye").val(item.yetkili_tel1);
                                            } else {
                                                $(".yetkili_adi_irsaliye").val((item.yetkili_ad2));
                                                $(".yetkili_cep_irsaliye").val(item.yetkili_tel2);
                                            }
                                            $(".vergi_daire_irsaliye").val((item.vergi_dairesi));
                                            $(".vergi_no_irsaliye").val(item.vergi_no);
                                            if (item.adres != null) {
                                                $(".cari_adres_irsaliye").val((item.adres))
                                            }
                                        })
                                        setTimeout(function () {
                                            $("#doviz_tur_irsaliye").val(item.doviz_tur);
                                            $("#doviz_kuru_irsaliye").val(item.kur_fiyat)
                                            $("#siparis_no").val(item.siparis_no);
                                            $("#depo_id_irsaliye").val(item.depo_id);
                                            $("#aciklama_irsaliye").val(item.aciklama);
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
                                            if (item.doviz_tur == "TL") {
                                                $("#doviz_iskonto").html("");
                                                $("#doviz_iskonto").html(iskonto_yazi + " " + item.doviz_tur);
                                                $("#doviz_kdv").html("");
                                                $("#doviz_kdv").html(kdv_yazi + " " + item.doviz_tur);
                                                $("#doviz_ara_toplam").html("");
                                                $("#doviz_ara_toplam").html(ara_toplam_yazi + " " + item.doviz_tur);
                                                $("#doviz_genel_toplam").html("");
                                                $("#doviz_genel_toplam").html(genel_toplam_yazi + " " + item.doviz_tur);
                                                $("#doviz_tevkifat_tutar").html("");
                                                $("#doviz_tevkifat_tutar").html(tevkifat_yazi + " " + item.doviz_tur);
                                                var doviz_kuru = $("#doviz_kuru").val();
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
                                                $(".iskonto_toplam_bas").html("");
                                                $(".iskonto_toplam_bas").html(tl_iskonto + " TL");
                                                $(".kdv_toplam_bas").html("");
                                                $(".kdv_toplam_bas").html(tl_kdv + " TL");
                                                $(".ara_toplam_bas").html("");
                                                $(".ara_toplam_bas").html(tl_ara_toplam + " TL");
                                                $(".genel_toplam_bas").html("");
                                                $(".genel_toplam_bas").html(tl_genel_toplam + " TL");
                                                $(".tevkifat_tutari_bas").html("");
                                                $(".tevkifat_tutari_bas").html(tl_tevkifat + " TL");
                                            } else {
                                                $(".iskonto_toplam_bas").html("");
                                                $(".iskonto_toplam_bas").html(iskonto_yazi + " TL");
                                                $(".kdv_toplam_bas").html("");
                                                $(".kdv_toplam_bas").html(kdv_yazi + " TL");
                                                $(".ara_toplam_bas").html("");
                                                $(".ara_toplam_bas").html(ara_toplam_yazi + " TL");
                                                $(".genel_toplam_bas").html("");
                                                $(".genel_toplam_bas").html(genel_toplam_yazi + " TL");
                                                $(".tevkifat_tutari_bas").html("");
                                                $(".tevkifat_tutari_bas").html(tevkifat_yazi + " TL");
                                            }
                                        }, 500);
                                    });
                                }
                                let val = $(".fatura_tarihi_satis_faturasi").val();
                                var baslangicTarihi = new Date(val);
                                var yeniTarih = new Date(baslangicTarihi);
                                let cari_id = $(".secilen_cari").attr("data-id");
                                $.get("controller/alis_controller/sql.php?islem=vade_tarihi_getir_sql",{cari_id:cari_id},function (result){
                                    if (result != 2){
                                        var item = JSON.parse(result);
                                        var vade_tarihi = item.vade_gunu;
                                        vade_tarihi = parseInt(vade_tarihi);
                                        yeniTarih.setDate(baslangicTarihi.getDate() + vade_tarihi);
                                        $(".vade_tarihi_ayarla").val(yeniTarih.toISOString().split('T')[0]);
                                    }
                                })
                            }
                    })
                    }
                }
            });
            }
        });



        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {

            $("#cariye_ait_irsaliyeler_modal").modal("hide");

        });

    </script>

    <?php

}