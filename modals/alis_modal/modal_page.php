<?php


$islem = $_GET["islem"];

if ($islem == "cariler_listesi_getir_modal") {

    ?>
    <div class="modal fade" id="fatura_cari_liste_modal_getir"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 30%; max-width: 30%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Cari Listesi
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="fatura_cari_liste">
                            <thead>
                            <tr>
                                <th id="click1">Cari Adı</th>
                                <th>Cari Kodu</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("body").off("focusout", ".fatura_tarihi_satis_faturasi").on("focusout", ".fatura_tarihi_satis_faturasi", function () {
            let val = $(this).val();
            var baslangicTarihi = new Date(val);
            var yeniTarih = new Date(baslangicTarihi);
            let cari_id = $(".secilen_cari").attr("data-id");
            $.get("controller/satis_controller/sql.php?islem=vade_tarihi_getir_sql", {cari_id: cari_id}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    var vade_tarihi = item.vade_gunu;
                    vade_tarihi = parseInt(vade_tarihi);
                    yeniTarih.setDate(baslangicTarihi.getDate() + vade_tarihi);
                    $(".vade_tarihi_ayarla").val(yeniTarih.toISOString().split('T')[0]);
                }
            })
        });

        $('input').click(function () {
            $(this).select();
        });
        var table = "";

        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#fatura_cari_liste_modal_getir").modal("hide");
        })

        $(document).ready(function () {
            $.get("controller/alis_controller/sql.php?islem=fatura_turlerini_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#fatura_turu_alis").append("" +
                            "<option value='" + item.id + "'>" + item.fatura_turu_adi + "</option>" +
                            "");
                    })
                }
            })
            $("#fatura_cari_liste_modal_getir").modal("show");

            setTimeout(function () {

                $("#click1").trigger("click");

            }, 300);

            table = $('#fatura_cari_liste').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "cari_adi"},
                    {'data': "cari_kodu"},
                ],
                createdRow: function (row) {
                    $(row).addClass("cari_select");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }

            })
            
            $.get("controller/alis_controller/sql.php?islem=carileri_getir", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    table.rows.add(json).draw(false);
                }
            })

        })


        $("body").off("click", ".cari_select").on("click", ".cari_select", function () {
            var id = $(this).attr("data-id");
            var cari_adi = $(this).find("td").eq(0).text();
            var cari_kodu = $(this).find("td").eq(1).text();
            $(".secilen_cari").val(cari_kodu);
            $(".secilen_cari").attr("data-id", id);
            $(".cari_adi_getir").val(cari_adi);
            $(".cari_adi").val(cari_adi);
            $("#fatura_cari_liste_modal_getir").modal("hide");
            $.get("controller/alis_controller/sql.php?islem=secilen_cari_bilgileri", {id: id}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    var telefon = item.telefon;
                    var yetkiliAdi1 = item.yetkili_adi1;
                    var yetkiliTel1 = item.yetkili_tel1;
                    var vergiDairesi = item.vergi_dairesi;
                    var vergiNo = item.vergi_no;
                    var adres = item.adres;
                    var vade_gunu = item.vade_gunu;
                    var tarih1 = $(".fatura_tarihi");
                    var tarih = new Date(tarih1.val());
                    var vade_tarihi = new Date(tarih.getTime() + (vade_gunu * 24 * 60 * 60 * 1000));
                    var yeniTarihString = vade_tarihi.getFullYear() + '-' + ('0' + (vade_tarihi.getMonth() + 1)).slice(-2) + '-' + ('0' + vade_tarihi.getDate()).slice(-2);
                    $(".vade_tarihi_ayarla").val(yeniTarihString)
                    $(".cari_telefon").val(telefon);
                    $(".yetkili_adi").val(yetkiliAdi1);
                    $(".yetkili_cep").val(yetkiliTel1);
                    $(".vergi_daire").val(vergiDairesi);

                    $(".vergi_no").val(vergiNo);

                    $(".cari_adres").val(adres);

                }

            });

        })

    </script>

    <?php

}

if ($islem == "stok_kartlari_getir_modal") {

    ?>

    <div class="modal fade" data-backdrop="static" id="fatura_stoklari_getir_modal_getir"

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

            }, 500);

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
                    stok_table.rows.add(json);
                }

            });

            $("body").off("click", ".stock_select").on("click", ".stock_select", function () {

                var id = $(this).attr("data-id");

                $.get("controller/alis_controller/sql.php?islem=secilen_stok_bilgileri", {id: id}, function (result) {

                    if (result != 2) {

                        var item = JSON.parse(result);

                        $(".gelecek_birim").val(item.birim);

                        $(".stok_adi").val(item.stok_adi);

                        $(".stok_adi").attr("data-id", id);

                        $(".kdv_yuzde").val(item.kdv_orani);

                        $(".tevkifat_kodu").val(item.tevkifat_kodu);

                        $(".birim_fiyat").val(item.alis_fiyat);

                        $(".tevkifat_yuzde").val(item.tevkifat_yuzde);

                        $("#fatura_stoklari_getir_modal_getir").modal("hide");

                        $(".miktar").focus();

                    }

                })

            });

        });

        $("body").off("click", "#modal_kapat1").on("click", "#modal_kapat1", function () {

            $("#fatura_stoklari_getir_modal_getir").modal("hide");

        });

    </script>

    <?php

}

if ($islem == "faturayi_goruntule_ve_guncelle") {

    $id = $_GET["id"];

    ?>

    <div class="modal fade" id="faturayi_goruntule_modal" data-backdrop="static"

         data-bs-keyboard="false" role="dialog">

        <div class="modal-dialog modal-sm"

             style="width: 100%; max-width: 100%;">

            <div class="modal-content">

                <div class="modal-header text-white p-2">

                    <button type="button" class="btn-close btn-close-white alis_modal_kapat" id="modal_kapat"

                            aria-label="Close"></button>

                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ALIŞ FATURASI GİRİŞ</div>
                        </div>
                    </div>

                    <div class="modal-body" style="max-height: 75vh; overflow: auto;">


                        <div id="carileri_getir_div"></div>

                        <div id="stok_adi_getir_div"></div>

                        <div class="col-md-12 row ana_fatura">

                            <div class="col-4">

                                <div class="form-group row">

                                    <div class="col-md-4 mt-1">

                                        <label>Cari Kodu/Adı</label>

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
                                <!--                            <div class="form-group row">-->
                                <!--                                <div class="col-md-4">-->
                                <!--                                    <label>Fatura Tipi</label>-->
                                <!--                                </div>-->
                                <!--                                <div class="col-md-8">-->
                                <!--                                    <select class="custom-select custom-select-sm" id="fatura_tipi">-->
                                <!--                                        <option value="">Seçiniz...</option>-->
                                <!--                                    </select>-->
                                <!--                                </div>-->
                                <!--                            </div>-->

                                <div class="form-group row">

                                    <div class="col-md-4 mt-1">

                                        Fatura No

                                    </div>

                                    <div class="col-md-8">

                                        <input type="text" class="form-control form-control-sm fatura_no_alis_fatura"
                                               id="fatura_no">

                                    </div>

                                </div>

                                <div class="form-group row">

                                    <div class="col-md-4 mt-1">

                                        Fatura Tarihi

                                    </div>

                                    <div class="col-md-8">

                                        <input type="date" value="<?= date("Y-m-d") ?>"

                                               class="form-control form-control-sm fatura_tarihi fatura_tarihi_satis_faturasi"
                                               id="fatura_tarihi">

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

                                            <select class="custom-select custom-select-sm" id="doviz_tur">

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
                                <!--                                    <select class="custom-select custom-select-sm" disabled id="fatura_tipi">-->
                                <!---->
                                <!--                                        <option value="">Seçiniz...</option>-->
                                <!---->
                                <!--                                        <option value="1">Muhtelif</option>-->
                                <!---->
                                <!--                                    </select>-->
                                <!---->
                                <!--                                </div>-->
                                <!---->
                                <!--                            </div>-->

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

                                            <select class="custom-select custom-select-sm mx-1 gelecek_birim"
                                                    id="birim_id">

                                                <option value="">Birim</option>

                                            </select>

                                        </div>

                                        <div class="col-md-1">

                                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Birim
                                                Fiyat</label>

                                            <input type="text" style="text-align: right"

                                                   class="form-control form-control-sm mx-2 birim_fiyat birim_fiyat_degistir_duzenle"

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

                                        <div class="col-md-2 row mt-1">

                                            <button style="width: 100% !important;"

                                                    class="btn btn-success btn-sm mx-5" id="faturaya_ekle"><i

                                                        class="fa fa-plus"></i> Ekle

                                            </button>

                                            <button style="background-color: #F6FA70;width: 100% !important;"

                                                    class="btn btn-sm mx-5 mt-1" id="kaydi_guncelle"><i

                                                        class="fa fa-refresh"></i> Kaydı Güncelle

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

                                        <textarea class="form-control form-control-sm aciklama_ekle alis_aciklamasi"
                                                  id="aciklama"
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

                                                    <td class="tevkifat_tutari_bas" style="text-align: right">0,00 TL
                                                    </td>

                                                </tr>

                                                <tr>

                                                    <td class="iskonto_toplam_bas" style="text-align: right">0,00 TL
                                                    </td>

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

                        </div>

                    </div>
                </div>
                <div class="modal-footer">

                    <button class="btn btn-danger alis_modal_kapat btn-sm"><i class="fa fa-close"></i> Vazgeç

                    </button>

                    <button class="btn btn-success btn-sm" id="fatura_olustur"><i

                                class="fa fa-plus"></i> Kaydet

                    </button>

                </div>

            </div>

        </div>

    </div>

    <script>
        var alis_table = "";
        var arr = [];
        $("body").off("click", ".alis_modal_kapat").on("click", ".alis_modal_kapat", function () {
            $("#faturayi_goruntule_modal").modal("hide");
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
                    var adres = item.adres;
                    var vade_gunu = item.vade_gunu;
                    var tarih1 = $(".fatura_tarihi");
                    var tarih = new Date(tarih1.val());
                    var vade_tarihi = new Date(tarih.getTime() + (vade_gunu * 24 * 60 * 60 * 1000));
                    var yeniTarihString = vade_tarihi.getFullYear() + '-' + ('0' + (vade_tarihi.getMonth() + 1)).slice(-2) + '-' + ('0' + vade_tarihi.getDate()).slice(-2);
                    $(".vade_tarihi_ayarla").val(yeniTarihString)
                    $(".cari_telefon").val(telefon);
                    $(".secilen_cari").attr("data-id", item.id);
                    $(".secilen_cari").val(item.cari_kodu + " " + cariAdi.toUpperCase());
                    $(".yetkili_adi").val(yetkiliAdi1.toUpperCase());
                    $(".yetkili_cep").val(yetkiliTel1);
                    $(".vergi_daire").val(vergiDairesi.toUpperCase());
                    $(".vergi_no").val(vergiNo);
                    $(".cari_adres").val(adres.toUpperCase());
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
                    $(".kdv_yuzde").val(item.kdv_orani);
                    $(".tevkifat_kodu").val(item.tevkifat_kodu);
                    $(".birim_fiyat").val(item.alis_fiyat);
                    $(".tevkifat_yuzde").val(item.tevkifat_yuzde);
                    $("#fatura_stoklari_getir_modal_getir").modal("hide");
                    $(".miktar").focus();
                }
            })
        });
        $("body").off("change", "#doviz_tur").on("change", "#doviz_tur", function () {
            var value = $(this).val();
            if (value == "TL") {
                $("#doviz_kuru").val("1.00");
            } else if (value == "EURO") {
                var eur_kur = $("#doviz_tur option:selected").attr("eur");
                var parse_eur = parseFloat(eur_kur);
                $("#doviz_kuru").val(parse_eur.toFixed(2));
            } else if (value == "USD") {
                var usd_kur = $("#doviz_tur option:selected").attr("usd");
                var parse_usd = parseFloat(usd_kur);
                $("#doviz_kuru").val(parse_usd.toFixed(2));
            } else if (value == "GBP") {
                var gbp_kur = $("#doviz_tur option:selected").attr("gbp");
                var parse_gbp = parseFloat(gbp_kur);
                $("#doviz_kuru").val(parse_gbp.toFixed(2));
            } else {
                $("#doviz_kuru").val("");
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

            $.get("controller/alis_controller/sql.php?islem=fatura_turlerini_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#fatura_turu_alis").append("" +
                            "<option value='" + item.id + "'>" + item.fatura_turu_adi + "</option>" +
                            "");
                    })
                }
            })
            $.get("controller/alis_controller/sql.php?islem=fatura_tipi_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#alis_fatura_tipi").append("" +
                            "<option value='" + item.id + "'>" + item.fatura_tip_adi + "</option>" +
                            "");
                    })
                }
            })
            var ilk_tutar = 0;
            $.get("controller/alis_controller/sql.php?islem=fatura_ana_bilgileri_getir", {id: "<?=$id?>"}, function (result) {
                var item = JSON.parse(result);
                ilk_tutar = item.genel_toplam;
                $(".secilen_cari").attr("data-id", item.cari_id);
                $(".alis_aciklamasi").val(item.aciklama);
                $.get("controller/alis_controller/sql.php?islem=secilen_cari_bilgileri", {id: item.cari_id}, function (result2) {
                    var item = JSON.parse(result2);
                    $(".cari_telefon").val(item.telefon);
                    $(".secilen_cari").val((item.cari_adi).toUpperCase());
                    if (item.yetkili_adi1 != null) {
                        $(".yetkili_adi").val((item.yetkili_adi1).toUpperCase());
                        $(".yetkili_cep").val(item.yetkili_tel1);
                    } else {
                        $(".yetkili_adi").val((item.yetkili_ad2).toUpperCase());
                        $(".yetkili_cep").val(item.yetkili_tel2);
                    }
                    $(".vergi_daire").val((item.vergi_dairesi).toUpperCase());
                    $(".vergi_no").val(item.vergi_no);
                    if (item.adres != null) {
                        $(".cari_adres").val((item.adres).toUpperCase())
                    }
                })

                $("#fatura_turu_alis").val(item.fatura_turu);

                $(".fatura_no_alis_fatura").val(item.fatura_no);

                var gelen_tarih = item.fatura_tarihi;

                var explode1 = gelen_tarih.split(" ");

                var fatura_tarihi = explode1[0];


                var irsaliye_tarihi = item.irsaliye_tarih;
                if (irsaliye_tarihi == null) {

                } else {

                    var explode2 = irsaliye_tarihi.split(" ");
                    irsaliye_tarihi = explode2[0];
                }


                var vade_tarihi = item.vade_tarihi;
                if (vade_tarihi == null) {

                } else {
                    var explode3 = vade_tarihi.split(" ");

                    vade_tarihi = explode3[0];
                }


                setTimeout(function () {

                    $("#fatura_tarihi").val(fatura_tarihi);
                    $("#alis_fatura_tipi").val(item.fatura_tipi);
                    $("#vade_tarihi").val(vade_tarihi);

                    $("#doviz_tur").val(item.doviz_tur);

                    $("#irsaliye_no").val(item.irsaliye_no);

                    $("#irsaliye_tarih").val(irsaliye_tarihi);

                    $("#depo_id").val(item.depo_id);

                    $("#doviz_kuru").val(item.doviz_kuru);

                    $("#faturaya_ekle").attr("data-id", item.id);

                    $("#fatura_tipi").val(item.fatura_tipi);

                    $("#aciklama").val(item.aciklama);

                    $("#doviz_kuru").val(item.doviz_kuru);


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

                    var iskonto_yazi = iskonto_toplam.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })

                    var kdv_yazi = kdv_toplam.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })

                    var ara_toplam_yazi = ara_toplam.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })

                    var genel_toplam_yazi = genel_toplam.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })

                    var tevkifat_yazi = tevkifat_toplam.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })


                    if (item.doviz_tur != "TL") {

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


                        var tl_karsilik_iskonto = iskonto_toplam * (item.kur_fiyat);

                        var tl_iskonto = tl_karsilik_iskonto.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })

                        var tl_karsilik_kdv = kdv_toplam * (item.kur_fiyat);

                        var tl_kdv = tl_karsilik_kdv.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })

                        var tl_karsilik_ara_toplam = ara_toplam * (item.kur_fiyat);

                        var tl_ara_toplam = tl_karsilik_ara_toplam.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })

                        var tl_karsilik_genel_toplam = genel_toplam * (item.kur_fiyat);

                        var tl_genel_toplam = tl_karsilik_genel_toplam.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })

                        var tl_karsilik_tevkifat_tutari = tevkifat_toplam * (item.kur_fiyat);

                        var tl_tevkifat = tl_karsilik_tevkifat_tutari.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })

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

                        $(".kdv_toplam_bas").html(kdv_yazi + " " + " TL");

                        $(".ara_toplam_bas").html("");

                        $(".ara_toplam_bas").html(ara_toplam_yazi + " TL");

                        $(".genel_toplam_bas").html("");

                        $(".genel_toplam_bas").html(genel_toplam_yazi + " TL");

                        $(".tevkifat_tutari_bas").html("");

                        $(".tevkifat_tutari_bas").html(tevkifat_yazi + " TL");

                    }

                }, 500);

            });

            $("body").off("click", "#fatura_olustur").on("click", "#fatura_olustur", function () {
                var cari_id = $(".secilen_cari").attr("data-id");
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
                var aciklama = $(".aciklama_ekle").val();
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
                }else if (fatura_turu == ""){
                    Swal.fire(
                        "Uyarı",
                        "Lütfen Fatura Türü Giriniz...",
                        "warning"
                    );
                } else {
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
                                fatura_turu: fatura_turu,
                                aciklama: aciklama,
                                ilk_tutar: ilk_tutar,
                                fatura_no: fatura_no,
                                fatura_tarihi: fatura_tarihi,
                                fatura_tipi: alis_fatura_tipi,
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
                                        $("#faturayi_goruntule_modal").modal("hide");
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

            $.get("controller/alis_controller/sql.php?islem=faturanini_urunlerini_getir", {alis_defaultid: "<?=$id?>"}, function (result) {

                if (result != 2) {

                    var json = JSON.parse(result);
                    let toplam_kdv = 0
                    let toplam_tutar1 = 0;
                    json.forEach(function (item) {

                        var birimFiyat = item.birim_fiyat;

                        var parse_birim = parseFloat(birimFiyat);

                        var birim_fiyat = parse_birim.toLocaleString("tr-TR", {
                            minimumFractionDigits: 8,
                            maximumFractionDigits: 8
                        })


                        var kdvTutari = item.kdv_tutari;

                        var parse_kdv = parseFloat(kdvTutari);
                        toplam_kdv += parse_kdv;
                        var kdv_fiyat = parse_kdv.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })


                        var iskontoTutari = item.iskonto_tutari;

                        var parse_iskonto = parseFloat(iskontoTutari);

                        var iskonto_tutari = parse_iskonto.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })


                        var tevkifatTutari = item.tevkifat_tutari;

                        var parse_tevkifat = parseFloat(tevkifatTutari);

                        var tevkifat_tutari = parse_tevkifat.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })


                        var toplamTutar = item.toplam_tutar;

                        var parse_toplam = parseFloat(toplamTutar);
                        toplam_tutar1 += parse_toplam;

                        var toplam_tutar = parse_toplam.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        })


                        var alis_id = alis_table.row.add([item.stok_kodu, item.stok_adi, item.birim_adi, item.miktar, birim_fiyat, "%" + item.kdv_orani, kdv_fiyat + " " + item.doviz_tur, "%" + item.iskonto, iskonto_tutari + " " + item.doviz_tur, item.tevkifat_kodu, tevkifat_tutari + " " + item.doviz_tur, toplam_tutar + " " + item.doviz_tur, "<button class='btn btn-danger faturadan_eksilt' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();

                        $(alis_id).attr("data-id", item.id);

                    });
                }

            });


            $("#faturayi_goruntule_modal").modal("show");

            $.get("controller/alis_controller/sql.php?islem=guncel_kurlar", function (result) {

                var item = JSON.parse(result);

                var usd = item.USD[0];

                var eur = item.EUR[0];

                var gbp = item.GBP[0];

                $("#usd_bas").attr("usd", usd);

                $("#eur_bas").attr("eur", eur);

                $("#gbp_bas").attr("gbp", gbp);

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

                                    var iskonto_yazi = iskonto_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })

                                    var kdv_yazi = kdv_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })

                                    var ara_toplam_yazi = ara_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })

                                    var genel_toplam_yazi = genel_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })

                                    var tevkifat_yazi = tevkifat_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })


                                    var birimFiyat = item.birim_fiyat;

                                    var parse_birim = parseFloat(birimFiyat);

                                    var birim_fiyat = parse_birim.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 8,
                                        maximumFractionDigits: 8
                                    })


                                    var kdvTutari = item.kdv_tutari;

                                    var parse_kdv = parseFloat(kdvTutari);

                                    var kdv_fiyat = parse_kdv.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })


                                    var iskontoTutari = item.iskonto_tutari;

                                    var parse_iskonto = parseFloat(iskontoTutari);

                                    var iskonto_tutari = parse_iskonto.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })


                                    var tevkifatTutari = item.tevkifat_tutari;

                                    var parse_tevkifat = parseFloat(tevkifatTutari);

                                    var tevkifat_tutari = parse_tevkifat.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })


                                    var toplamTutar = item.toplam_tutar;

                                    var parse_toplam = parseFloat(toplamTutar);

                                    var toplam_tutar = parse_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })


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

                                        var tl_iskonto = tl_karsilik_iskonto.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var tl_karsilik_kdv = parse_kdv * doviz_kuru;

                                        var tl_kdv = tl_karsilik_kdv.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var tl_karsilik_ara_toplam = ara_toplam * doviz_kuru;

                                        var tl_ara_toplam = tl_karsilik_ara_toplam.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var tl_karsilik_genel_toplam = genel_toplam * doviz_kuru;

                                        var tl_genel_toplam = tl_karsilik_genel_toplam.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var tl_karsilik_tevkifat_tutari = parse_tevkifat * doviz_kuru;

                                        var tl_tevkifat = tl_karsilik_tevkifat_tutari.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

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

                                    var iskonto_yazi = iskonto_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })

                                    var kdv_yazi = kdv_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })

                                    var ara_toplam_yazi = ara_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })

                                    var genel_toplam_yazi = genel_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })

                                    var tevkifat_yazi = tevkifat_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })


                                    var birimFiyat = item.birim_fiyat;

                                    var parse_birim = parseFloat(birimFiyat);

                                    var birim_fiyat = parse_birim.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 8,
                                        maximumFractionDigits: 8
                                    })


                                    var kdvTutari = item.kdv_tutari;

                                    var parse_kdv = parseFloat(kdvTutari);

                                    var kdv_fiyat = parse_kdv.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })


                                    var iskontoTutari = item.iskonto_tutari;

                                    var parse_iskonto = parseFloat(iskontoTutari);

                                    var iskonto_tutari = parse_iskonto.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })


                                    var tevkifatTutari = item.tevkifat_tutari;

                                    var parse_tevkifat = parseFloat(tevkifatTutari);

                                    var tevkifat_tutari = parse_tevkifat.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })


                                    var toplamTutar = item.toplam_tutar;

                                    var parse_toplam = parseFloat(toplamTutar);

                                    var toplam_tutar = parse_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })


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

                                        var tl_iskonto = tl_karsilik_iskonto.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var tl_karsilik_kdv = parse_kdv * doviz_kuru;

                                        var tl_kdv = tl_karsilik_kdv.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var tl_karsilik_ara_toplam = ara_toplam * doviz_kuru;

                                        var tl_ara_toplam = tl_karsilik_ara_toplam.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var tl_karsilik_genel_toplam = genel_toplam * doviz_kuru;

                                        var tl_genel_toplam = tl_karsilik_genel_toplam.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var tl_karsilik_tevkifat_tutari = parse_tevkifat * doviz_kuru;

                                        var tl_tevkifat = tl_karsilik_tevkifat_tutari.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

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


            $("#doviz_kuru").focusout(function () {

                var kur = $(this).val();

                var id = $("#faturaya_ekle").attr("data-id");

                $.ajax({

                    url: "controller/alis_controller/sql.php?islem=doviz_kur_guncelle_sql",

                    type: "POST",

                    data: {

                        doviz_kuru: kur,

                        kur_fiyat: kur,

                        id: id

                    },

                    success: function (result) {

                        if (result == 1) {

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

                                title: 'Kur Fiyat Güncellendi'

                            });

                        }

                    }

                });

            });


            $("body").off("change", "#doviz_tur").on("change", "#doviz_tur", function () {

                var doviz_tur = $(this).val();

                var kur_fiyat = $("#doviz_kuru").val();

                var fatura_id = $("#faturaya_ekle").attr("data-id");

                if ($("#fatura_tipi").val() == "") {

                    $.ajax({

                        url: "controller/alis_controller/sql.php?islem=doviz_kur_degistir",

                        type: "POST",

                        data: {

                            doviz_tur: doviz_tur,

                            kur_fiyat: kur_fiyat,

                            doviz_kuru: kur_fiyat,

                            alis_defaultid: fatura_id

                        },

                        success: function (result) {

                            if (result != 2 || result != 500) {

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

                                    var iskonto_yazi = iskonto_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })

                                    var kdv_yazi = kdv_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })

                                    var ara_toplam_yazi = ara_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })

                                    var genel_toplam_yazi = genel_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })

                                    var tevkifat_yazi = tevkifat_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })


                                    var birimFiyat = item.birim_fiyat;

                                    var parse_birim = parseFloat(birimFiyat);

                                    var birim_fiyat = parse_birim.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 4,
                                        maximumFractionDigits: 4
                                    })


                                    var kdvTutari = item.kdv_tutari;

                                    var parse_kdv = parseFloat(kdvTutari);

                                    var kdv_fiyat = parse_kdv.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })


                                    var iskontoTutari = item.iskonto_tutari;

                                    var parse_iskonto = parseFloat(iskontoTutari);

                                    var iskonto_tutari = parse_iskonto.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })


                                    var tevkifatTutari = item.tevkifat_tutari;

                                    var parse_tevkifat = parseFloat(tevkifatTutari);

                                    var tevkifat_tutari = parse_tevkifat.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })


                                    var toplamTutar = item.toplam_tutar;

                                    var parse_toplam = parseFloat(toplamTutar);

                                    var toplam_tutar = parse_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })


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

                                        var tl_iskonto = tl_karsilik_iskonto.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var tl_karsilik_kdv = parse_kdv * doviz_kuru;

                                        var tl_kdv = tl_karsilik_kdv.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var tl_karsilik_ara_toplam = ara_toplam * doviz_kuru;

                                        var tl_ara_toplam = tl_karsilik_ara_toplam.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var tl_karsilik_genel_toplam = genel_toplam * doviz_kuru;

                                        var tl_genel_toplam = tl_karsilik_genel_toplam.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var tl_karsilik_tevkifat_tutari = parse_tevkifat * doviz_kuru;

                                        var tl_tevkifat = tl_karsilik_tevkifat_tutari.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

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

                                    title: 'Döviz Kuru Değiştirildi'

                                });

                            }

                        }

                    });

                } else {

                    $.ajax({

                        url: "controller/alis_controller/sql.php?islem=doviz_kur_degistir",

                        type: "POST",

                        data: {

                            doviz_tur: doviz_tur,

                            kur_fiyat: kur_fiyat,

                            doviz_kuru: kur_fiyat,

                            alis_muhtelifid: fatura_id

                        },

                        success: function (result) {

                            if (result != 2 || result != 500) {

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

                                    var iskonto_yazi = iskonto_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })

                                    var kdv_yazi = kdv_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })

                                    var ara_toplam_yazi = ara_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })

                                    var genel_toplam_yazi = genel_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })

                                    var tevkifat_yazi = tevkifat_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })


                                    var birimFiyat = item.birim_fiyat;

                                    var parse_birim = parseFloat(birimFiyat);

                                    var birim_fiyat = parse_birim.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 8,
                                        maximumFractionDigits: 8
                                    })


                                    var kdvTutari = item.kdv_tutari;

                                    var parse_kdv = parseFloat(kdvTutari);

                                    var kdv_fiyat = parse_kdv.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })


                                    var iskontoTutari = item.iskonto_tutari;

                                    var parse_iskonto = parseFloat(iskontoTutari);

                                    var iskonto_tutari = parse_iskonto.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })


                                    var tevkifatTutari = item.tevkifat_tutari;

                                    var parse_tevkifat = parseFloat(tevkifatTutari);

                                    var tevkifat_tutari = parse_tevkifat.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })


                                    var toplamTutar = item.toplam_tutar;

                                    var parse_toplam = parseFloat(toplamTutar);

                                    var toplam_tutar = parse_toplam.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })


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

                                        var tl_iskonto = tl_karsilik_iskonto.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var tl_karsilik_kdv = parse_kdv * doviz_kuru;

                                        var tl_kdv = tl_karsilik_kdv.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var tl_karsilik_ara_toplam = ara_toplam * doviz_kuru;

                                        var tl_ara_toplam = tl_karsilik_ara_toplam.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var tl_karsilik_genel_toplam = genel_toplam * doviz_kuru;

                                        var tl_genel_toplam = tl_karsilik_genel_toplam.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var tl_karsilik_tevkifat_tutari = parse_tevkifat * doviz_kuru;

                                        var tl_tevkifat = tl_karsilik_tevkifat_tutari.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

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

                                    title: 'Döviz Kuru Değiştirildi'

                                });

                            }

                        }

                    });

                }


            });


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

                        console.log(arr);

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

                    var fatura_tipi = $("#fatura_tipi").val();

                    var cari_id = $(".secilen_cari").attr("data-id");

                    var doviz_tur = $("#doviz_tur").val();


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

                                            var iskonto_yazi = iskonto_toplam.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })

                                            var kdv_yazi = kdv_toplam.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })

                                            var ara_toplam_yazi = ara_toplam.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })

                                            var genel_toplam_yazi = genel_toplam.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })

                                            var tevkifat_yazi = tevkifat_toplam.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })


                                            var birimFiyat = item.birim_fiyat;

                                            var parse_birim = parseFloat(birimFiyat);

                                            var birim_fiyat = parse_birim.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 8,
                                                maximumFractionDigits: 8
                                            })


                                            var kdvTutari = item.kdv_tutari;

                                            var parse_kdv = parseFloat(kdvTutari);

                                            var kdv_fiyat = parse_kdv.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })


                                            var iskontoTutari = item.iskonto_tutari;

                                            var parse_iskonto = parseFloat(iskontoTutari);

                                            var iskonto_tutari = parse_iskonto.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })


                                            var tevkifatTutari = item.tevkifat_tutari;

                                            var parse_tevkifat = parseFloat(tevkifatTutari);

                                            var tevkifat_tutari = parse_tevkifat.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })


                                            var toplamTutar = item.toplam_tutar;

                                            var parse_toplam = parseFloat(toplamTutar);

                                            var toplam_tutar = parse_toplam.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })


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

                                                var tl_iskonto = tl_karsilik_iskonto.toLocaleString("tr-TR", {
                                                    minimumFractionDigits: 2,
                                                    maximumFractionDigits: 2
                                                })

                                                var tl_karsilik_kdv = parse_kdv * doviz_kuru;

                                                var tl_kdv = tl_karsilik_kdv.toLocaleString("tr-TR", {
                                                    minimumFractionDigits: 2,
                                                    maximumFractionDigits: 2
                                                })

                                                var tl_karsilik_ara_toplam = ara_toplam * doviz_kuru;

                                                var tl_ara_toplam = tl_karsilik_ara_toplam.toLocaleString("tr-TR", {
                                                    minimumFractionDigits: 2,
                                                    maximumFractionDigits: 2
                                                })

                                                var tl_karsilik_genel_toplam = genel_toplam * doviz_kuru;

                                                var tl_genel_toplam = tl_karsilik_genel_toplam.toLocaleString("tr-TR", {
                                                    minimumFractionDigits: 2,
                                                    maximumFractionDigits: 2
                                                })

                                                var tl_karsilik_tevkifat_tutari = parse_tevkifat * doviz_kuru;

                                                var tl_tevkifat = tl_karsilik_tevkifat_tutari.toLocaleString("tr-TR", {
                                                    minimumFractionDigits: 2,
                                                    maximumFractionDigits: 2
                                                })

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

                                            var iskonto_yazi = iskonto_toplam.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })

                                            var kdv_yazi = kdv_toplam.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })

                                            var ara_toplam_yazi = ara_toplam.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })

                                            var genel_toplam_yazi = genel_toplam.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })

                                            var tevkifat_yazi = tevkifat_toplam.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })


                                            var birimFiyat = item.birim_fiyat;

                                            var parse_birim = parseFloat(birimFiyat);

                                            var birim_fiyat = parse_birim.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 8,
                                                maximumFractionDigits: 8
                                            })


                                            var kdvTutari = item.kdv_tutari;

                                            var parse_kdv = parseFloat(kdvTutari);

                                            var kdv_fiyat = parse_kdv.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })


                                            var iskontoTutari = item.iskonto_tutari;

                                            var parse_iskonto = parseFloat(iskontoTutari);

                                            var iskonto_tutari = parse_iskonto.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })


                                            var tevkifatTutari = item.tevkifat_tutari;

                                            var parse_tevkifat = parseFloat(tevkifatTutari);

                                            var tevkifat_tutari = parse_tevkifat.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })


                                            var toplamTutar = item.toplam_tutar;

                                            var parse_toplam = parseFloat(toplamTutar);

                                            var toplam_tutar = parse_toplam.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })


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

                                                var tl_iskonto = tl_karsilik_iskonto.toLocaleString("tr-TR", {
                                                    minimumFractionDigits: 2,
                                                    maximumFractionDigits: 2
                                                })

                                                var tl_karsilik_kdv = parse_kdv * doviz_kuru;

                                                var tl_kdv = tl_karsilik_kdv.toLocaleString("tr-TR", {
                                                    minimumFractionDigits: 2,
                                                    maximumFractionDigits: 2
                                                })

                                                var tl_karsilik_ara_toplam = ara_toplam * doviz_kuru;

                                                var tl_ara_toplam = tl_karsilik_ara_toplam.toLocaleString("tr-TR", {
                                                    minimumFractionDigits: 2,
                                                    maximumFractionDigits: 2
                                                })

                                                var tl_karsilik_genel_toplam = genel_toplam * doviz_kuru;

                                                var tl_genel_toplam = tl_karsilik_genel_toplam.toLocaleString("tr-TR", {
                                                    minimumFractionDigits: 2,
                                                    maximumFractionDigits: 2
                                                })

                                                var tl_karsilik_tevkifat_tutari = parse_tevkifat * doviz_kuru;

                                                var tl_tevkifat = tl_karsilik_tevkifat_tutari.toLocaleString("tr-TR", {
                                                    minimumFractionDigits: 2,
                                                    maximumFractionDigits: 2
                                                })

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

                                        var iskonto_yazi = iskonto_toplam.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var kdv_yazi = kdv_toplam.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var ara_toplam_yazi = ara_toplam.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var genel_toplam_yazi = genel_toplam.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var tevkifat_yazi = tevkifat_toplam.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })


                                        var birimFiyat = item.birim_fiyat;

                                        var parse_birim = parseFloat(birimFiyat);

                                        var birim_fiyat = parse_birim.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 8,
                                            maximumFractionDigits: 8
                                        })


                                        var kdvTutari = item.kdv_tutari;

                                        var parse_kdv = parseFloat(kdvTutari);

                                        var kdv_fiyat = parse_kdv.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })


                                        var iskontoTutari = item.iskonto_tutari;

                                        var parse_iskonto = parseFloat(iskontoTutari);

                                        var iskonto_tutari = parse_iskonto.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })


                                        var tevkifatTutari = item.tevkifat_tutari;

                                        var parse_tevkifat = parseFloat(tevkifatTutari);

                                        var tevkifat_tutari = parse_tevkifat.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })


                                        var toplamTutar = item.toplam_tutar;

                                        var parse_toplam = parseFloat(toplamTutar);

                                        var toplam_tutar = parse_toplam.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })


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

                                            var tl_iskonto = tl_karsilik_iskonto.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })

                                            var tl_karsilik_kdv = parse_kdv * doviz_kuru;

                                            var tl_kdv = tl_karsilik_kdv.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })

                                            var tl_karsilik_ara_toplam = ara_toplam * doviz_kuru;

                                            var tl_ara_toplam = tl_karsilik_ara_toplam.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })

                                            var tl_karsilik_genel_toplam = genel_toplam * doviz_kuru;

                                            var tl_genel_toplam = tl_karsilik_genel_toplam.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })

                                            var tl_karsilik_tevkifat_tutari = parse_tevkifat * doviz_kuru;

                                            var tl_tevkifat = tl_karsilik_tevkifat_tutari.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })

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

                                        var iskonto_yazi = iskonto_toplam.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var kdv_yazi = kdv_toplam.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var ara_toplam_yazi = ara_toplam.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var genel_toplam_yazi = genel_toplam.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })

                                        var tevkifat_yazi = tevkifat_toplam.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })


                                        var birimFiyat = item.birim_fiyat;

                                        var parse_birim = parseFloat(birimFiyat);

                                        var birim_fiyat = parse_birim.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 8,
                                            maximumFractionDigits: 8
                                        })


                                        var kdvTutari = item.kdv_tutari;

                                        var parse_kdv = parseFloat(kdvTutari);

                                        var kdv_fiyat = parse_kdv.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })


                                        var iskontoTutari = item.iskonto_tutari;

                                        var parse_iskonto = parseFloat(iskontoTutari);

                                        var iskonto_tutari = parse_iskonto.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })


                                        var tevkifatTutari = item.tevkifat_tutari;

                                        var parse_tevkifat = parseFloat(tevkifatTutari);

                                        var tevkifat_tutari = parse_tevkifat.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })


                                        var toplamTutar = item.toplam_tutar;

                                        var parse_toplam = parseFloat(toplamTutar);

                                        var toplam_tutar = parse_toplam.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })


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

                                            var tl_iskonto = tl_karsilik_iskonto.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })

                                            var tl_karsilik_kdv = parse_kdv * doviz_kuru;

                                            var tl_kdv = tl_karsilik_kdv.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })

                                            var tl_karsilik_ara_toplam = ara_toplam * doviz_kuru;

                                            var tl_ara_toplam = tl_karsilik_ara_toplam.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })

                                            var tl_karsilik_genel_toplam = genel_toplam * doviz_kuru;

                                            var tl_genel_toplam = tl_karsilik_genel_toplam.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })

                                            var tl_karsilik_tevkifat_tutari = parse_tevkifat * doviz_kuru;

                                            var tl_tevkifat = tl_karsilik_tevkifat_tutari.toLocaleString("tr-TR", {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            })

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
        })

        var toplam_tutar = 0;

        $(".birim_fiyat").focusout(function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 8, maximumFractionDigits: 8})
            $(".birim_fiyat").val(val);
        })
        $(".miktar").focusout(function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})
            $(".miktar").val(val);
        })
        $(".miktar").keyup(function () {
            var value = $(this).val();
            value = value.replace(/\./g, "").replace(",", ".");
            value = parseFloat(value);
            if (isNaN(value)) {
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
                var toplam_tutar = tevkifatsiz_tutar.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })
                $("#toplam_tutar").val(toplam_tutar);
            } else {
                var toplam_tutar = tevkifatli_tutar.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })
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
                var toplam_tutar = tevkifatsiz_tutar.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })
                $("#toplam_tutar").val(toplam_tutar);
            } else {
                var toplam_tutar = tevkifatli_tutar.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })
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
                var toplam_tutar = tevkifatsiz_tutar.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })
                $("#toplam_tutar").val(toplam_tutar);
            } else {
                var toplam_tutar = tevkifatli_tutar.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })
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
                var toplam_tutar = tevkifatsiz_tutar.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })
                $("#toplam_tutar").val(toplam_tutar);
            } else {
                var toplam_tutar = tevkifatli_tutar.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                })
                $("#tevkifat_tutar").val(tevkifat_tutar.toFixed(2));
                $("#toplam_tutar").val(toplam_tutar)
            }
        });
    </script>
    <?php
}