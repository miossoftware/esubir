<?php

$islem = $_GET["islem"];

if ($islem == "irsaliye_ekle_modal") {

    ?>

    <div class="modal fade" id="satis_irsaliye_modal" data-backdrop="static"

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
                        <div class="ibox-title" style='color:white; font-weight:bold;'>SATIŞ İRSALİYE GİRİŞ</div>
                    </div>
                <div class="modal-body" style="max-height: 75vh; overflow: auto;">

                    <div id="carileri_getir_irsaliye"></div>

                    <div id="stok_adi_getir_irsaliye"></div>

                    <div id="cariye_ait_siparisleri_getir"></div>

                    <div class="col-md-12 row ana_irsaliye">

                        <div class="col-4">

                            <div class="form-group row">

                                <div class="col-md-4 mt-1">

                                    <label>Cari Kodu</label>

                                </div>

                                <div class="col-8">

                                    <div class="input-group mb-3">

                                        <input type="text" class="form-control form-control-sm secilen_cari_irsaliye"

                                               aria-describedby="basic-addon1" id="cari_id">

                                        <div class="input-group-append">

                                            <button class="btn btn-warning btn-sm"

                                                    id="cari_getir_modal_irsaliye"><i

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

                                    <input type="text" class="form-control form-control-sm cari_adi_getir_irsaliye"

                                           disabled>

                                </div>

                            </div>

                            <div class="form-group row">

                                <div class="col-md-4 mt-1">

                                    Telefon

                                </div>

                                <div class="col-md-8">

                                    <input type="text" class="form-control form-control-sm cari_telefon_irsaliye"

                                           disabled>

                                </div>

                            </div>

                            <div class="form-group row">

                                <div class="col-md-4 mt-1">

                                    Yetkili

                                </div>

                                <div class="col-md-8">

                                    <input type="text" class="form-control form-control-sm yetkili_adi_irsaliye"

                                           disabled>

                                </div>

                            </div>

                            <div class="form-group row">

                                <div class="col-md-4 mt-1">

                                    Yetkili Cep

                                </div>

                                <div class="col-md-8">

                                    <input type="text" class="form-control form-control-sm yetkili_cep_irsaliye"

                                           disabled>

                                </div>

                            </div>

                            <div class="form-group row">

                                <div class="col-md-4 mt-1">

                                    Vergi Daire

                                </div>

                                <div class="col-md-8">

                                    <input type="text" class="form-control form-control-sm vergi_daire_irsaliye"

                                           disabled>

                                </div>

                            </div>

                            <div class="form-group row">

                                <div class="col-md-4 mt-1">

                                    Vergi No

                                </div>

                                <div class="col-md-8">

                                    <input type="text" class="form-control form-control-sm vergi_no_irsaliye" disabled>

                                </div>

                            </div>

                        </div>

                        <div class="col-4">

                            <div class="form-group row">

                                <div class="col-md-4 mt-1">

                                    Cari Adres

                                </div>

                                <div class="col-md-8">

                                    <textarea class="form-control form-control-sm cari_adres_irsaliye" disabled id=""

                                              cols="30"

                                              rows="3"></textarea>

                                </div>

                            </div>

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

                                    <input type="date" value="<?=date("Y-m-d")?>" class="form-control form-control-sm"

                                           id="irsaliye_tarih">

                                </div>

                            </div>

                            <div class="form-group row">

                                <div class="col-md-4 mt-1">

                                    Depo

                                </div>

                                <div class="col-md-8">

                                    <select class="custom-select custom-select-sm" id="depo_id_irsaliye">

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

                                        <select class="custom-select custom-select-sm doviz_tur_selected"

                                                id="doviz_tur_irsaliye">

                                            <option value="">Seçiniz...</option>

                                            <option selected value="TL">TL</option>

                                            <option id="usd_bas_irsaliye" value="USD">USD</option>

                                            <option id="eur_bas_irsaliye" value="EURO">EURO</option>

                                            <option id="gbp_bas_irsaliye" value="GBP">GBP</option>

                                        </select>

                                    </div>

                                    <div class="col">

                                        <input type="text" class="form-control form-control-sm" id="doviz_kuru_irsaliye"

                                               value="1.00"

                                               placeholder="Döviz Karşılığı">

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-4">

                            <div class="form-group row">

                                <div class="col-2">

                                    <label>Açıklama</label>

                                </div>

                                <div class="col-10">

                                        <textarea style="resize: none"

                                                  class="form-control form-control-sm aciklama_irsaliye"

                                                  id="aciklama_irsaliye" cols="30"

                                                  rows="12"></textarea>

                                </div>

                            </div>

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

                                                <button class="btn btn-warning btn-sm stok_adi"

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

                                    <div class="col-md-2 row">

                                        <button style="width: 100% !important;"

                                                class="btn btn-success btn-sm mx-5" id="irsaliyeye_ekle"><i

                                                    class="fa fa-plus"></i> Ekle

                                        </button>

                                        <button style="background-color: #F6FA70;width: 100% !important;"

                                                class="btn btn-sm mx-5 mt-1"

                                                id="irsaliye_kaydi_guncelle"><i

                                                    class="fa fa-refresh"></i> Kaydı Güncelle

                                        </button>

                                        <button style="width: 100% !important;"

                                                class="btn btn-secondary btn-sm mx-5 mt-1"

                                                id="cari_siparisleri"><i

                                                    class="fa fa-download"></i> Siparişten Aktar

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-12 mt-3">

                            <table class="table table-sm table-bordered w-100 display nowrap alis_irsaliye_urun_list_bastir"

                                   style="cursor:pointer;font-size: 13px;"

                                   id="alis_irsaliye_urun_list">

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

                                                <td id="doviz_ara_toplam_irsaliye" style="text-align: right">0,00 TL

                                                </td>

                                            </tr>

                                            <tr>

                                                <td id="doviz_kdv_irsaliye" style="text-align: right">0,00 TL</td>

                                            </tr>

                                            <tr>

                                                <td id="doviz_tevkifat_tutar_irsaliye" style="text-align: right">0,00

                                                    TL

                                                </td>

                                            </tr>

                                            <tr>

                                                <td id="doviz_iskonto_irsaliye" style="text-align: right">0,00 TL</td>

                                            </tr>

                                            <tr>

                                                <td id="doviz_genel_toplam_irsaliye" style="text-align: right">0,00 TL

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

                                                <td class="ara_toplam_bas_irsaliye" style="text-align: right">0,00 TL

                                                </td>

                                            </tr>

                                            <tr>

                                                <td class="kdv_toplam_bas_irsaliye" style="text-align: right">0,00 TL

                                                </td>

                                            </tr>

                                            <tr>

                                                <td class="tevkifat_tutari_bas_irsaliye" style="text-align: right">0,00

                                                    TL

                                                </td>

                                            </tr>

                                            <tr>

                                                <td class="iskonto_toplam_bas_irsaliye" style="text-align: right">0,00

                                                    TL

                                                </td>

                                            </tr>

                                            <tr>

                                                <td class="genel_toplam_bas_irsaliye" style="text-align: right">0,00

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

                    <button class="btn btn-danger modal_kapali btn-sm"><i class="fa fa-close"></i> Vazgeç

                    </button>

                    <button class="btn btn-success btn-sm" id="irsaliye_guncelle_ve_kaydet"><i

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




        $("body").off("click", "#cari_siparisleri").on("click", "#cari_siparisleri", function () {

            var cari_id = $("#cari_id").attr("data-id");
            if (cari_id == "" || cari_id == null) {

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

                    title: 'Cari Seçimi Yapınız'

                });

            } else {

                $.get("modals/satis_modal/irsaliye_modal.php?islem=cariye_ait_siparisleri_getir", {cari_id: cari_id}, function (getModal) {

                    $("#cariye_ait_siparisleri_getir").html("");

                    $("#cariye_ait_siparisleri_getir").html(getModal);

                })

            }

        });



        $("body").off("click", "#stok_adi").on("click", "#stok_adi", function () {

            $.get("modals/alis_modal/alis_irsaliye_page.php?islem=irsaliye_stok_getir_modal", function (getModal) {

                $("#stok_adi_getir_irsaliye").html("");

                $("#stok_adi_getir_irsaliye").html(getModal);

            })

        });



        $("body").off("click", "#cari_getir_modal_irsaliye").on("click", "#cari_getir_modal_irsaliye", function () {

            $.get("modals/alis_modal/alis_irsaliye_page.php?islem=irsaliye_icin_carileri_getir", function (getModal) {

                $("#carileri_getir_irsaliye").html("");

                $("#carileri_getir_irsaliye").html(getModal);

            })

        });



        var irsaliye_table = "";

        var arr = [];

        $(document).ready(function () {

            $.get("controller/alis_controller/sql.php?islem=guncel_kurlar", function (result) {

                var item = JSON.parse(result);

                var usd = item.USD[0];

                var eur = item.EUR[0];

                var gbp = item.GBP[0];

                $("#usd_bas_irsaliye").attr("usd", usd);

                $("#eur_bas_irsaliye").attr("eur", eur);

                $("#gbp_bas_irsaliye").attr("gbp", gbp);

            });

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



            setTimeout(function () {

                $("#click12").trigger("click");

            }, 300);

            $("#satis_irsaliye_modal").modal("show");

            irsaliye_table = $('#alis_irsaliye_urun_list').DataTable({

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

                    $(row).addClass("irsaliye_selected");

                },

                "paging": false,

                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},

            });



            $("body").off("click", ".irsaliye_selected").on("click", ".irsaliye_selected", function () {

                var id = $(this).attr("data-id");

                $.get("controller/satis_controller/sql.php?islem=siparisteki_urun_bilgileri", {id: id}, function (result) {

                    if (result != 2) {

                        $("#irsaliye_kaydi_guncelle").attr("data-id", id);

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



            $("body").off("click", "#irsaliye_kaydi_guncelle").on("click", "#irsaliye_kaydi_guncelle", function () {

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

                var irsaliye_id = $("#irsaliyeye_ekle").attr("data-id");



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

                if (toplam_tutar < 0){

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

                }else {

                    $.ajax({

                        url: "controller/satis_controller/sql.php?islem=irsaliye_urun_guncelle",

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

                            miktar_farki:miktar_farki,

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

                            irsaliye_id: irsaliye_id

                        },

                        success: function (result) {

                            if (result != 2) {

                                irsaliye_table.clear().draw(false);

                                var json = JSON.parse(result);

                                json.forEach(function (item) {

                                    var miktar = Number(item.giren_miktar) - Number(item.cikan_miktar);

                                    if (miktar < 0){

                                        // BURAYA DÖNÜLECEK

                                        Swal.fire(

                                            'Uyarı!',

                                            ' '+item.stok_adi+' Adlı Stoğun Stok Miktarı Eksiye Düşmüştür',

                                            'warning'

                                        );

                                    }

                                    $("#irsaliyeye_ekle").attr("data-id", item.irsaliye_id);

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



                                    if ($("#doviz_tur_irsaliye").val() != "TL") {

                                        $("#doviz_iskonto_irsaliye").html("");

                                        $("#doviz_iskonto_irsaliye").html(iskonto_yazi + " " + item.doviz_tur);

                                        $("#doviz_kdv_irsaliye").html("");

                                        $("#doviz_kdv_irsaliye").html(kdv_yazi + " " + item.doviz_tur);

                                        $("#doviz_ara_toplam_irsaliye").html("");

                                        $("#doviz_ara_toplam_irsaliye").html(ara_toplam_yazi + " " + item.doviz_tur);

                                        $("#doviz_genel_toplam_irsaliye").html("");

                                        $("#doviz_genel_toplam_irsaliye").html(genel_toplam_yazi + " " + item.doviz_tur);

                                        $("#doviz_tevkifat_tutar_irsaliye").html("");

                                        $("#doviz_tevkifat_tutar_irsaliye").html(tevkifat_yazi + " " + item.doviz_tur);



                                        var doviz_kuru = $("#doviz_kuru_irsaliye").val();

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

                                        $(".iskonto_toplam_bas_irsaliye").html("");

                                        $(".iskonto_toplam_bas_irsaliye").html(tl_iskonto + " TL");

                                        $(".kdv_toplam_bas_irsaliye").html("");

                                        $(".kdv_toplam_bas_irsaliye").html(tl_kdv + " TL");

                                        $(".ara_toplam_bas_irsaliye").html("");

                                        $(".ara_toplam_bas_irsaliye").html(tl_ara_toplam + " TL");

                                        $(".genel_toplam_bas_irsaliye").html("");

                                        $(".genel_toplam_bas_irsaliye").html(tl_genel_toplam + " TL");

                                        $(".tevkifat_tutari_bas_irsaliye").html("");

                                        $(".tevkifat_tutari_bas_irsaliye").html(tl_tevkifat + " TL");

                                    } else {

                                        $(".iskonto_toplam_bas_irsaliye").html("");

                                        $(".iskonto_toplam_bas_irsaliye").html(iskonto_yazi + " TL");

                                        $(".kdv_toplam_bas_irsaliye").html("");

                                        $(".kdv_toplam_bas_irsaliye").html(kdv_yazi + " TL");

                                        $(".ara_toplam_bas_irsaliye").html("");

                                        $(".ara_toplam_bas_irsaliye").html(ara_toplam_yazi + " TL");

                                        $(".genel_toplam_bas_irsaliye").html("");

                                        $(".genel_toplam_bas_irsaliye").html(genel_toplam_yazi + " TL");

                                        $(".tevkifat_tutari_bas_irsaliye").html("");

                                        $(".tevkifat_tutari_bas_irsaliye").html(tevkifat_yazi + " TL");

                                    }

                                    var alis_id = irsaliye_table.row.add([item.stok_kodu, item.stok_adi, item.birim_adi, item.miktar, birim_fiyat, "%" + item.kdv_orani, kdv_fiyat + " " + item.doviz_tur, "%" + item.iskonto, iskonto_tutari + " " + item.doviz_tur, item.tevkifat_kodu, tevkifat_tutari + " " + item.doviz_tur, toplam_tutar + " " + item.doviz_tur, "<button class='btn btn-danger irsaliyeden_cikart' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();

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



            $.get("controller/alis_controller/sql.php?islem=depolari_getir", function (result) {

                if (result != 2) {

                    var json = JSON.parse(result);

                    json.forEach(function (item) {

                        var depo_adi = item.depo_adi

                        $("#depo_id_irsaliye").append("" +

                            "<option value='" + item.id + "'>" + depo_adi.toUpperCase() + "</option>" +

                            "");

                    })

                }

            })

        });



        $("body").off("change", "#doviz_tur_irsaliye").on("change", "#doviz_tur_irsaliye", function () {

            var secilen = $(this).val();

            if (secilen == "TL") {

                $("#doviz_kuru_irsaliye").val("1.00");

            } else if (secilen == "USD") {

                var usd_kur = $("#doviz_tur_irsaliye option:selected").attr("usd");

                $("#doviz_kuru_irsaliye").val(usd_kur);

            } else if (secilen == "EURO") {

                var eur_kur = $("#doviz_tur_irsaliye option:selected").attr("eur");

                $("#doviz_kuru_irsaliye").val(eur_kur);

            } else if (secilen == "GBP") {

                var gbp_kur = $("#doviz_tur_irsaliye option:selected").attr("gbp");

                $("#doviz_kuru_irsaliye").val(gbp_kur);

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



        $("body").off("click", "#irsaliyeye_ekle").on("click", "#irsaliyeye_ekle", function () {

            var cari_id = $("#cari_id").attr("data-id");

            var doviz_tur = $("#doviz_tur_irsaliye").val();

            var kur_fiyat = $("#doviz_kuru_irsaliye").val();



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

            var irsaliye_id = $(this).attr("data-id");

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

            }else if (toplam_tutar < 0){

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

                    url: "controller/satis_controller/sql.php?islem=irsaliye_urun_ekle_sql",

                    type: "POST",

                    data: {

                        irsaliye_id: irsaliye_id,

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

                            irsaliye_table.clear().draw(false);

                            json.forEach(function (item) {

                                let miktar = Number(item.giren_miktar) - Number(item.cikan_miktar);

                                if (item.stok_turu != 3 && miktar < 0){

                                    Swal.fire(

                                        'Uyarı!',

                                        ''+item.stok_adi+' Adlı Stoğun Stok Miktarı Eksiye Düşmüştür',

                                        'warning'

                                    );

                                }

                                $("#irsaliyeye_ekle").attr("data-id", item.irsaliye_id);

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



                                if ($("#doviz_tur_irsaliye").val() != "TL") {

                                    $("#doviz_iskonto_irsaliye").html("");

                                    $("#doviz_iskonto_irsaliye").html(iskonto_yazi + " " + item.doviz_tur);

                                    $("#doviz_kdv_irsaliye").html("");

                                    $("#doviz_kdv_irsaliye").html(kdv_yazi + " " + item.doviz_tur);

                                    $("#doviz_ara_toplam_irsaliye").html("");

                                    $("#doviz_ara_toplam_irsaliye").html(ara_toplam_yazi + " " + item.doviz_tur);

                                    $("#doviz_genel_toplam_irsaliye").html("");

                                    $("#doviz_genel_toplam_irsaliye").html(genel_toplam_yazi + " " + item.doviz_tur);

                                    $("#doviz_tevkifat_tutar_irsaliye").html("");

                                    $("#doviz_tevkifat_tutar_irsaliye").html(tevkifat_yazi + " " + item.doviz_tur);



                                    var doviz_kuru = $("#doviz_kuru_irsaliye").val();

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

                                    $(".iskonto_toplam_bas_irsaliye").html("");

                                    $(".iskonto_toplam_bas_irsaliye").html(tl_iskonto + " TL");

                                    $(".kdv_toplam_bas_irsaliye").html("");

                                    $(".kdv_toplam_bas_irsaliye").html(tl_kdv + " TL");

                                    $(".ara_toplam_bas_irsaliye").html("");

                                    $(".ara_toplam_bas_irsaliye").html(tl_ara_toplam + " TL");

                                    $(".genel_toplam_bas_irsaliye").html("");

                                    $(".genel_toplam_bas_irsaliye").html(tl_genel_toplam + " TL");

                                    $(".tevkifat_tutari_bas_irsaliye").html("");

                                    $(".tevkifat_tutari_bas_irsaliye").html(tl_tevkifat + " TL");

                                } else {

                                    $(".iskonto_toplam_bas_irsaliye").html("");

                                    $(".iskonto_toplam_bas_irsaliye").html(iskonto_yazi + " TL");

                                    $(".kdv_toplam_bas_irsaliye").html("");

                                    $(".kdv_toplam_bas_irsaliye").html(kdv_yazi + " TL");

                                    $(".ara_toplam_bas_irsaliye").html("");

                                    $(".ara_toplam_bas_irsaliye").html(ara_toplam_yazi + " TL");

                                    $(".genel_toplam_bas_irsaliye").html("");

                                    $(".genel_toplam_bas_irsaliye").html(genel_toplam_yazi + " TL");

                                    $(".tevkifat_tutari_bas_irsaliye").html("");

                                    $(".tevkifat_tutari_bas_irsaliye").html(tevkifat_yazi + " TL");

                                }

                                var alis_id = irsaliye_table.row.add([item.stok_kodu, item.stok_adi, item.birim_adi, item.miktar, birim_fiyat, "%" + item.kdv_orani, kdv_fiyat + " " + item.doviz_tur, "%" + item.iskonto, iskonto_tutari + " " + item.doviz_tur, item.tevkifat_kodu, tevkifat_tutari + " " + item.doviz_tur, toplam_tutar + " " + item.doviz_tur, "<button class='btn btn-danger irsaliyeden_cikart' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();

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



        $("body").off("click", ".irsaliyeden_cikart").on("click", ".irsaliyeden_cikart", function () {

            var id = $(this).attr("data-id");

            var irsaliye_id = $("#irsaliyeye_ekle").attr("data-id");



            $.ajax({

                url: "controller/satis_controller/sql.php?islem=irsaliyeden_urun_cikart",

                type: "POST",

                data: {

                    id: id,

                    irsaliye_id: irsaliye_id

                },

                success: function (result) {

                    if (result != 500) {

                        if (result == 2) {

                            var doviz_tur = $("#doviz_tur_irsaliye").val();

                            irsaliye_table.clear().draw(false);

                            $("#doviz_iskonto_irsaliye").html("");

                            $("#doviz_iskonto_irsaliye").html("0,00" + doviz_tur);

                            $("#doviz_kdv_irsaliye").html("");

                            $("#doviz_kdv_irsaliye").html("0,00" + doviz_tur);

                            $("#doviz_ara_toplam_irsaliye").html("");

                            $("#doviz_ara_toplam_irsaliye").html("0,00" + doviz_tur);

                            $("#doviz_genel_toplam_irsaliye").html("");

                            $("#doviz_genel_toplam_irsaliye").html("0,00" + doviz_tur);

                            $("#doviz_tevkifat_tutar_irsaliye").html("");

                            $("#doviz_tevkifat_tutar_irsaliye").html("0,00" + doviz_tur);



                            $(".iskonto_toplam_bas_irsaliye").html("");

                            $(".iskonto_toplam_bas_irsaliye").html("0,00 TL");

                            $(".kdv_toplam_bas_irsaliye").html("");

                            $(".kdv_toplam_bas_irsaliye").html("0,00 TL");

                            $(".ara_toplam_bas_irsaliye").html("");

                            $(".ara_toplam_bas_irsaliye").html("0,00 TL");

                            $(".genel_toplam_bas_irsaliye").html("");

                            $(".genel_toplam_bas_irsaliye").html("0,00 TL");

                            $(".tevkifat_tutari_bas_irsaliye").html("");

                            $(".tevkifat_tutari_bas_irsaliye").html("0,00 TL");

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

                            irsaliye_table.clear().draw(false);

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



                                if ($("#doviz_tur_irsaliye").val() != "TL") {

                                    $("#doviz_iskonto_irsaliye").html("");

                                    $("#doviz_iskonto_irsaliye").html(iskonto_yazi + " " + item.doviz_tur);

                                    $("#doviz_kdv_irsaliye").html("");

                                    $("#doviz_kdv_irsaliye").html(kdv_yazi + " " + item.doviz_tur);

                                    $("#doviz_ara_toplam_irsaliye").html("");

                                    $("#doviz_ara_toplam_irsaliye").html(ara_toplam_yazi + " " + item.doviz_tur);

                                    $("#doviz_genel_toplam_irsaliye").html("");

                                    $("#doviz_genel_toplam_irsaliye").html(genel_toplam_yazi + " " + item.doviz_tur);

                                    $("#doviz_tevkifat_tutar_irsaliye").html("");

                                    $("#doviz_tevkifat_tutar_irsaliye").html(tevkifat_yazi + " " + item.doviz_tur);



                                    var doviz_kuru = $("#doviz_kuru_irsaliye").val();

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

                                    $(".iskonto_toplam_bas_irsaliye").html("");

                                    $(".iskonto_toplam_bas_irsaliye").html(tl_iskonto + " TL");

                                    $(".kdv_toplam_bas_irsaliye").html("");

                                    $(".kdv_toplam_bas_irsaliye").html(tl_kdv + " TL");

                                    $(".ara_toplam_bas_irsaliye").html("");

                                    $(".ara_toplam_bas_irsaliye").html(tl_ara_toplam + " TL");

                                    $(".genel_toplam_bas_irsaliye").html("");

                                    $(".genel_toplam_bas_irsaliye").html(tl_genel_toplam + " TL");

                                    $(".tevkifat_tutari_bas_irsaliye").html("");

                                    $(".tevkifat_tutari_bas_irsaliye").html(tl_tevkifat + " TL");

                                } else {

                                    $(".iskonto_toplam_bas_irsaliye").html("");

                                    $(".iskonto_toplam_bas_irsaliye").html(iskonto_yazi + " TL");

                                    $(".kdv_toplam_bas_irsaliye").html("");

                                    $(".kdv_toplam_bas_irsaliye").html(kdv_yazi + " TL");

                                    $(".ara_toplam_bas_irsaliye").html("");

                                    $(".ara_toplam_bas_irsaliye").html(ara_toplam_yazi + " TL");

                                    $(".genel_toplam_bas_irsaliye").html("");

                                    $(".genel_toplam_bas_irsaliye").html(genel_toplam_yazi + " TL");

                                    $(".tevkifat_tutari_bas_irsaliye").html("");

                                    $(".tevkifat_tutari_bas_irsaliye").html(tevkifat_yazi + " TL");

                                }

                                var alis_id = irsaliye_table.row.add([item.stok_kodu, item.stok_adi, item.birim_adi, item.miktar, birim_fiyat, "%" + item.kdv_orani, kdv_fiyat + " " + item.doviz_tur, "%" + item.iskonto, iskonto_tutari + " " + item.doviz_tur, item.tevkifat_kodu, tevkifat_tutari + " " + item.doviz_tur, toplam_tutar + " " + item.doviz_tur, "<button class='btn btn-danger irsaliyeden_cikart' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();

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



        $(".secilen_cari_irsaliye").keyup(function () {

            var cari_kodu = $(this).val();

            $.get("controller/alis_controller/sql.php?islem=girilen_cari_kodu_bilgileri", {cari_kodu: cari_kodu}, function (result) {

                if (result != 2) {

                    $.get("controller/satis_controller/sql.php?islem=irsaliye_siparis_son_belge_no_cek", {cari_id: item.id}, function (result) {

                        if (result != "") {

                            var item = JSON.parse(result);

                            $(".son_irsaliye").val(item)

                        } else {

                            $(".son_irsaliye").val("1");

                        }

                    })

                    var item = JSON.parse(result);

                    var yetkiliAdi1 = item.yetkili_adi1;

                    var yetkiliAdi2 = item.yetkili_ad2;

                    var yetkiliTel1 = item.yetkili_tel1;

                    var yetkiliTel2 = item.yetkili_tel2;

                    var vergiDairesi = item.vergi_dairesi;

                    var vergiNo = item.vergi_no;

                    var adres = item.adres;

                    $(".cari_telefon_irsaliye").val(item.telefon);

                    $(".cari_adi_getir_irsaliye").val((item.cari_adi).toUpperCase());

                    $(".secilen_cari_irsaliye").attr("data-id", item.id);

                    if (yetkiliAdi1 != null) {

                        $(".yetkili_adi_irsaliye").val(yetkiliAdi1.toUpperCase());

                        $(".yetkili_cep_irsaliye").val(yetkiliTel1);

                    } else {

                        $(".yetkili_adi_irsaliye").val(yetkiliAdi2.toUpperCase());

                        $(".yetkili_cep_irsaliye").val(yetkiliTel2);

                    }

                    if (vergiDairesi != "") {

                        $(".vergi_daire_irsaliye").val(vergiDairesi.toUpperCase());

                    }

                    $(".vergi_no_irsaliye").val(vergiNo);

                    $(".cari_adres_irsaliye").val(adres.toUpperCase());

                } else {

                    $(".cari_telefon_irsaliye").val("");

                    $(".cari_adi_getir_irsaliye").val("");

                    $(".secilen_cari_irsaliye").attr("data-id", "");

                    $(".yetkili_adi_irsaliye").val("");

                    $(".yetkili_cep_irsaliye").val("");

                    $(".vergi_daire_irsaliye").val("");

                    $(".vergi_no_irsaliye").val("");

                    $(".cari_adres_irsaliye").val("");

                }

            });

        })

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

        $(".stok_adi").keyup(function () {

            var stok_kodu = $(this).val();

            $.get("controller/alis_controller/sql.php?islem=stok_kodu_bilgileri_getir", {stok_kodu: stok_kodu}, function (result) {

                if (result != 2) {

                    var item = JSON.parse(result);

                    $(".gelecek_birim").val(item.birim);

                    $(".stok_adi").val(item.stok_adi);

                    $(".stok_adi").attr("data-id", item.id);

                    $(".kdv_yuzde").val(item.alis_kdv);

                    $(".tevkifat_kodu").val(item.tevkifat_kodu);

                    $(".birim_fiyat").val(item.alis_fiyat);

                    $(".tevkifat_yuzde").val(item.tevkifat_yuzde);

                    $("#fatura_stoklari_getir_modal_getir").modal("hide");

                    $(".miktar").focus();

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





        $("body").off("click", ".modal_kapali").on("click", ".modal_kapali", function () {

            var silinecek_id = $("#irsaliyeye_ekle").attr("data-id");

            if (silinecek_id != "") {

                $.ajax({

                    url: "controller/satis_controller/sql.php?islem=irsaliye_iptal_et_sql",

                    type: "POST",

                    data: {

                        id: silinecek_id

                    },

                    success: function (result) {

                        if (result == 1) {

                            $("#satis_irsaliye_modal").modal("hide");

                        } else {

                            $("#satis_irsaliye_modal").modal("hide");

                        }

                    }

                });

            } else {

                $("#satis_irsaliye_modal").modal("hide");

            }

        });



        $("body").off("click", "#irsaliye_guncelle_ve_kaydet").on("click", "#irsaliye_guncelle_ve_kaydet", function () {

            var irsaliye_id = $("#irsaliyeye_ekle").attr("data-id");

            var cari_id = $(".secilen_cari_irsaliye").attr("data-id");

            var irsaliye_no = $("#irsaliye_no").val();

            var irsaliye_tarihi = $("#irsaliye_tarih").val();

            var depo_id = $("#depo_id_irsaliye").val();

            var aciklama = $("#aciklama_irsaliye").val();



            if (depo_id == "") {

                Swal.fire(

                    'Uyarı!',

                    'Lütfen Bir Depo Giriniz',

                    'warning'

                );

            } else {

                $.ajax({

                    url: "controller/satis_controller/sql.php?islem=irsaliyeyi_guncelle_sql",

                    type: "POST",

                    data: {

                        cari_id: cari_id,

                        irsaliye_no: irsaliye_no,

                        irsaliye_tarihi: irsaliye_tarihi,

                        depo_id: depo_id,

                        aciklama: aciklama,

                        id: irsaliye_id

                    },

                    success: function (result) {

                        if (result == 1) {

                            var implode = result.split(":");

                            var id = implode[1];

                            $("#faturaya_ekle").attr("data-id", id);

                            $(".shadow_buttons").hide();

                            $(".fatura_icerik").css("display", "block");

                            $.get("view/satis_irsaliye.php", function (getList) {

                                $(".modal-icerik").html("");

                                $(".modal-icerik").html(getList);

                            });

                            $.get("view/satis_irsaliye.php", function (getList) {

                                $(".admin-modal-icerik").html("");

                                $(".admin-modal-icerik").html(getList);

                            });

                            Swal.fire(

                                'Başarılı!',

                                'İrsaliye Kaydedildi',

                                'success'

                            );

                            $("#satis_irsaliye_modal").modal("hide");

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

    </script>

    <?php

}

if ($islem == "cariye_ait_siparisleri_getir") {

    $id = $_GET["cari_id"];

    ?>

    <div class="modal fade" data-backdrop="static" id="cariye_ait_siparisler_modal"

         data-bs-keyboard="false" role="dialog">

        <div class="modal-dialog"

             style="width: 55%; max-width: 55%;">

            <div class="modal-content">

                <div class="modal-header text-white p-2">Cariye Ait Sipariş Listesi

                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"

                            aria-label="Close"></button>

                </div>

                <div class="modal-body">

                    <div class="col-md-12 row">

                        <table class="table table-sm table-bordered w-100 display nowrap"

                               style="cursor:pointer;font-size: 13px;"

                               id="cariye_ait_siparis_listesi">

                            <thead>

                            <tr>

                                <th id="click12">Seç</th>

                                <th>Sipariş No</th>

                                <th>Sipariş Tarihi</th>

                                <th>Termin Tarihi</th>

                                <th>Stok Kodu</th>

                                <th>Stok Adı</th>

                                <th>Birim</th>

                                <th>Döviz Türü</th>

                                <th>Miktar</th>

                                <th>Siparişten Kalan Miktar</th>

                            </tr>

                            </thead>

                        </table>

                    </div>

                </div>

                <div class="modal-footer">

                    <button class="btn btn-danger btn-sm" id="modal_kapat"><i class="fa fa-close"></i> Kapat

                    </button>

                    <button class="btn btn-success btn-sm" id="secilenleri_irsaliyeye_aktar"><i

                                class="fa fa-download"></i> Seçilenleri Aktar

                    </button>

                </div>

            </div>

        </div>

    </div>

    <script>

        var select_siparis = [];

        document.addEventListener('keydown', function (event) {

            if (event.key === 'Escape') {

                $("#cariye_ait_siparisler_modal").modal("hide");

            }

        });

        var siparis_table = "";

        $(document).ready(function () {

            setTimeout(function () {

                $("#click12").trigger("click");

            }, 500);

            $("#cariye_ait_siparisler_modal").modal("show");

            siparis_table = $('#cariye_ait_siparis_listesi').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row) {
                    $(row).addClass("cariye_ait_siparis_select");
                }
            })
            $.get("controller/satis_controller/sql.php?islem=cariye_ait_siparisleri_getir_sql", {cari_id: "<?=$id?>"}, function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        var fatura_tarihi = item.siparis_tarihi;
                        var explode1 = fatura_tarihi.split(" ");
                        var explode_cikti1 = explode1[0];
                        var explode2 = explode_cikti1.split("-");
                        var gun = explode2[2];
                        var ay = explode2[1];
                        var yil = explode2[0];
                        var arr = [gun, ay, yil];
                        var irsaliye_tarihi_bas = arr.join("/");
                        var vadeTarihi = item.termin_tarihi;
                        var vadeTarihi_explode = vadeTarihi.split(" ");
                        var explode_cikti3 = vadeTarihi_explode[0];
                        var explode4 = explode_cikti3.split("-");
                        var gun1 = explode4[2];
                        var ay1 = explode4[1];
                        var yil1 = explode4[0];
                        var arr1 = [gun1, ay1, yil1];
                        var termin_tarihi_bas = arr1.join("/");
                        siparis_table.row.add(["<input type='checkbox' class='secilen_siparisler' data-id='" + item.id + "'/>", item.siparis_no, irsaliye_tarihi_bas, termin_tarihi_bas, item.stok_kodu, item.stok_adi, item.birim_adi, item.doviz_tur, item.miktar + " " + item.birim_adi, item.miktar + " " + item.birim_adi]).draw(false);
                    })
                }
            })
        });

        $("body").off("click", "#secilenleri_irsaliyeye_aktar").on("click", "#secilenleri_irsaliyeye_aktar", function () {



            var checkboxes = document.querySelectorAll(".secilen_siparisler"); // Tüm checkbox'ları seçer

            checkboxes.forEach(function (checkbox) {
                if (checkbox.checked) {
                    select_siparis.push(checkbox.getAttribute("data-id")); // Seçili checkbox'ın data-id değerini alır ve diziye ekler
                }

            });
            $.ajax({
                url: "controller/satis_controller/sql.php?islem=secilen_siparisi_irsaliyelestir",
                type: "POST",
                data: {
                    select_siparis: select_siparis,
                },
                success: function (result) {
                    if (result != 2) {
                        var json = JSON.parse(result);
                        let irsaliye_id = 0;
                        json.forEach(function (item) {
                            $("#irsaliyeye_ekle").attr("data-id", item.irsaliye_id);
                            irsaliye_id = item.irsaliye_id;
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
                            let alis_id = irsaliye_table.row.add([item.stok_kodu, item.stok_adi, item.birim_adi, item.miktar, birim_fiyat, "%" + item.kdv_orani, kdv_fiyat + " " + item.doviz_tur, "%" + item.iskonto, iskonto_tutari + " " + item.doviz_tur, item.tevkifat_kodu, tevkifat_tutari + " " + item.doviz_tur, toplam_tutar + " " + item.doviz_tur, "<button class='btn btn-danger irsaliyeden_cikart' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                            $(alis_id).attr("data-id", item.id);
                        });

                        $.get("controller/satis_controller/sql.php?islem=secilen_irsaliye_bilgilerini_getir", {id: irsaliye_id}, function (result) {
                            var item = JSON.parse(result);
                            $("#cariye_ait_siparisler_modal").modal("hide");
                            $(".secilen_cari_irsaliye").attr("data-id", item.cari_id);
                            $.get("controller/alis_controller/sql.php?islem=secilen_cari_bilgileri", {id: item.cari_id}, function (result2) {
                                var item = JSON.parse(result2);

                                $(".cari_telefon_irsaliye").val(item.telefon);
                                $(".cari_adi_getir_irsaliye").val((item.cari_adi).toUpperCase());
                                $(".secilen_cari_irsaliye").attr("data-id", item.cari_id);
                                $(".secilen_cari_irsaliye").val(item.cari_kodu);
                                if (item.yetkili_adi1 != null) {
                                    $(".yetkili_adi_irsaliye").val((item.yetkili_adi1).toUpperCase());
                                    $(".yetkili_cep_irsaliye").val(item.yetkili_tel1);
                                } else {
                                    $(".yetkili_adi_irsaliye").val((item.yetkili_ad2).toUpperCase());
                                    $(".yetkili_cep_irsaliye").val(item.yetkili_tel2);
                                }
                                $(".vergi_daire_irsaliye").val((item.vergi_dairesi).toUpperCase());
                                $(".vergi_no_irsaliye").val(item.vergi_no);
                                if (item.adres != null) {
                                    $(".cari_adres_irsaliye").val((item.adres).toUpperCase())
                                }
                            })
                            setTimeout(function () {
                                $("#depo_id_irsaliye").val(item.depo_id);
                                $("#doviz_tur_irsaliye").val(item.doviz_tur);
                                $("#doviz_kuru_irsaliye").val(item.kur_fiyat)
                                $("#siparis_no").val(item.siparis_no);
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





                                if ($("#doviz_tur").val() != "TL") {

                                    $("#doviz_iskonto_irsaliye").html("");

                                    $("#doviz_iskonto_irsaliye").html(iskonto_yazi + " " + item.doviz_tur);

                                    $("#doviz_kdv_irsaliye").html("");

                                    $("#doviz_kdv_irsaliye").html(kdv_yazi + " " + item.doviz_tur);

                                    $("#doviz_ara_toplam_irsaliye").html("");

                                    $("#doviz_ara_toplam_irsaliye").html(ara_toplam_yazi + " " + item.doviz_tur);

                                    $("#doviz_genel_toplam_irsaliye").html("");

                                    $("#doviz_genel_toplam_irsaliye").html(genel_toplam_yazi + " " + item.doviz_tur);

                                    $("#doviz_tevkifat_tutar_irsaliye").html("");

                                    $("#doviz_tevkifat_tutar_irsaliye").html(tevkifat_yazi + " " + item.doviz_tur);



                                    var doviz_kuru = $("#doviz_kuru_irsaliye").val();

                                    var tl_karsilik_iskonto = iskonto_toplam * doviz_kuru;

                                    var tl_iskonto = tl_karsilik_iskonto.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                    var tl_karsilik_kdv = kdv_toplam * doviz_kuru;

                                    var tl_kdv = tl_karsilik_kdv.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                    var tl_karsilik_ara_toplam = ara_toplam * doviz_kuru;

                                    var tl_ara_toplam = tl_karsilik_ara_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                    var tl_karsilik_genel_toplam = genel_toplam * doviz_kuru;

                                    var tl_genel_toplam = tl_karsilik_genel_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                    var tl_karsilik_tevkifat_tutari = tevkifat_toplam * doviz_kuru;

                                    var tl_tevkifat = tl_karsilik_tevkifat_tutari.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})

                                    $(".iskonto_toplam_bas_irsaliye").html("");

                                    $(".iskonto_toplam_bas_irsaliye").html(tl_iskonto + " TL");

                                    $(".kdv_toplam_bas_irsaliye").html("");

                                    $(".kdv_toplam_bas_irsaliye").html(tl_kdv + " TL");

                                    $(".ara_toplam_bas_irsaliye").html("");

                                    $(".ara_toplam_bas_irsaliye").html(tl_ara_toplam + " TL");

                                    $(".genel_toplam_bas_irsaliye").html("");

                                    $(".genel_toplam_bas_irsaliye").html(tl_genel_toplam + " TL");

                                    $(".tevkifat_tutari_bas_irsaliye").html("");

                                    $(".tevkifat_tutari_bas_irsaliye").html(tl_tevkifat + " TL");

                                } else {

                                    $(".iskonto_toplam_bas_irsaliye").html("");

                                    $(".iskonto_toplam_bas_irsaliye").html(iskonto_yazi + " TL");

                                    $(".kdv_toplam_bas_irsaliye").html("");

                                    $(".kdv_toplam_bas_irsaliye").html(kdv_yazi + " TL");

                                    $(".ara_toplam_bas_irsaliye").html("");

                                    $(".ara_toplam_bas_irsaliye").html(ara_toplam_yazi + " TL");

                                    $(".genel_toplam_bas_irsaliye").html("");

                                    $(".genel_toplam_bas_irsaliye").html(genel_toplam_yazi + " TL");

                                    $(".tevkifat_tutari_bas_irsaliye").html("");

                                    $(".tevkifat_tutari_bas_irsaliye").html(tevkifat_yazi + " TL");

                                }

                            }, 500);



                        });

                    }

                }

            })

        });



        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {

            $("#cariye_ait_siparisler_modal").modal("hide");

        });

    </script>

    <?php

}