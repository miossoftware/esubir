<?php

$islem = $_GET["islem"];


if ($islem == "is_emri_olustur_ana_modal") {
    ?>
    <style>
        #is_emri_olustur_ana_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="is_emri_olustur_ana_modal" data-bs-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 100%; max-width: 100%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="is_emri_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>İŞ EMRİ GİRİŞ</div>
                        </div>
                        <div class="modal-body">
                            <div class="mal_cinsleri_div"></div>
                            <div class="yeni_mal_cinsi_ekle"></div>
                            <div class="konteyner_irsaliye_firmalari_getir_div"></div>
                            <div class="depo_stoklarini_getir_div"></div>
                            <div class="col-12 row">
                                <div class="col-4">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Epro Ref.</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" disabled
                                                   id="epro_ref">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Cari Kodu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="firma_kodu">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="musteri_firma_kodu_button"><i
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
                                            <input type="text" class="form-control form-control-sm" id="firma_unvan"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Vergi Dairesi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="vergi_dairesi"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Vergi No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="vergi_no"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Kont. Sayısı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="number" class="form-control form-control-sm"
                                                   id="konteyner_sayisi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Kont. Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="konteyner_tipi">
                                                <option value="">Konteyner Tipi</option>
                                                <option value="40 HC">40 HC</option>
                                                <option value="20 DC">20 DC</option>
                                                <option value="40 DC">40 DC</option>
                                                <option value="20 OT">20 OT</option>
                                                <option value="40 OT">40 OT</option>
                                                <option value="20 RF">20 RF</option>
                                                <option value="40 RF">40 RF</option>
                                                <option value="40 HC RF">40 HC RF</option>
                                                <option value="20 TANK">20 TANK</option>
                                                <option value="20 VENTILATED">20 VENTILATED</option>
                                                <option value="40 HC PAL. WIDE">40 HC PAL. WIDE</option>
                                                <option value="20 FALT">20 FALT</option>
                                                <option value="40 FLAT">40 FLAT</option>
                                                <option value="40 HC FLAT">40 HC FLAT</option>
                                                <option value="20 PLATFORM">20 PLATFORM</option>
                                                <option value="40 PLATFORM">40 PLATFORM</option>
                                                <option value="45 HC">45 HC</option>
                                                <option value="KARGO">KARGO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Hizmet Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm hizmet_adi"
                                                       placeholder="Hizmet Adı">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="hizmetleri_getir_button">
                                                        <i
                                                                class="fa fa-ellipsis-h"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Miktar</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" style="text-align: right"
                                                   class="form-control form-control-sm" id="yuk_miktari">
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
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="tipi">
                                                <option value="">Tipi</option>
                                                <option value="İHRACAT">İHRACAT</option>
                                                <option value="İTHALAT">İTHALAT</option>
                                            </select>
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
                                            <label>Referans</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="referans_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Acenta</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="acente">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-4">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Sipariş Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>" id="siparis_tarihi"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Demoraj Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" class="form-control form-control-sm" id="demoraj_tarihi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>CUT-OFF Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" class="form-control form-control-sm" id="cut_of_tarihi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Ardiyesiz Giriş Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" class="form-control form-control-sm"
                                                   id="ardiyesiz_giris_tarihi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Kont. Alım Yeri</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="kont_alim_yeri">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Kont. Teslim Yeri</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="kont_teslim_yeri">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Mal Cinsi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm mal_adi"
                                                       placeholder="Mal Cinsi"
                                                       id="mal_kodu">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="mal_cinslerini_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i>
                                                    </button>
                                                    <button class="btn btn-success btn-sm" id="mal_cinsi_ekle_button"><i
                                                                class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if (isset($_GET["kiralik"])):
                                        ?>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label>Kiralık Cari Adı</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm"
                                                           id="depo_cariid">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-warning btn-sm"
                                                                id="depo_musteri_firma_kodu_button"><i
                                                                    class="fa fa-ellipsis-h"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    endif;
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-12 row no-gutters">
                                <div class="col">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;Hizmet
                                        Adı</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm hizmet_adi2"
                                               placeholder="Hizmet Adı">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm" id="hizmetleri_getir_button2">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;Birim</label>
                                    <select class="custom-select custom-select-sm" id="birim_id_urun">
                                        <option value="">Birim Seçiniz...</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;Sefer Sayısı</label>
                                    <input type="text" class="form-control form-control-sm" id="sefer_sayisi"
                                           placeholder="Sefer Sayısı">
                                </div>
                                <div class="col">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;Hizmet Türü</label>
                                    <select class="custom-select custom-select-sm" id="hizmet_turu">
                                        <option value="Depo Hizmeti" selected>Depo Hizmeti</option>
                                        <option value="Taşıma Hizmeti">Taşıma Hizmeti</option>
                                        <option value="Aktarma Hizmeti">Aktarma Hizmeti</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;Prim Tutarı</label>
                                    <input type="text" id="prim_tutari" class="form-control form-control-sm"
                                           value="0,00"
                                           placeholder="Prim Tutarı">
                                </div>
                                <div class="col">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;Alış Fiyat</label>
                                    <input type="text" id="alis_fiyat" class="form-control form-control-sm" value="0,00"
                                           placeholder="Alış Fiyat">
                                </div>
                                <div class="col">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;Satış Fiyat</label>
                                    <input type="text" class="form-control form-control-sm" id="satis_fiyat"
                                           value="0,00"
                                           placeholder="Satış Fiyat">
                                </div>
                                <div class="col-md-2 row">
                                    <button style="width: 100% !important;"
                                            class="btn btn-success btn-sm mx-5" id="is_emrine_hizmet_ekle"><i
                                                class="fa fa-plus"></i> Ekle
                                    </button>
                                    <button class="btn btn-primary btn-sm mx-5 mt-1" id=""><i
                                                class="fa fa-save"></i> Kayıtlı İş Emrine Ekle
                                    </button>
                                    <button style="width: 100% !important;"
                                            class="btn btn-secondary btn-sm mx-5 mt-1" id=""><i
                                                class="fa fa-download"></i> Kayıtlı İş Emirleri
                                    </button>
                                </div>
                            </div>
                            <div class="col-12">
                                <table class="table table-sm table-bordered w-100 display nowrap"
                                       style="cursor:pointer;font-size: 13px;"
                                       id="konteyner_yakit_fis_fatura_list">
                                    <thead>
                                    <tr>
                                        <th style="width: 0% !important;">Hizmet Adı</th>
                                        <th id="istasyonclick">Birim</th>
                                        <th>Sefer Sayısı</th>
                                        <th>Hizmet Türü</th>
                                        <th>Prim Tutarı</th>
                                        <th>Alış Fiyat</th>
                                        <th>Satış Fiyat</th>
                                        <th>İşlem</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="col-12 row mt-2">
                                <div class="col-4"></div>
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Forklift Türü</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select custom-select-sm"
                                                    id="forklift_turu">
                                                <option value="Çatal">ÇATAL</option>
                                                <option value="Sıkma">SIKMA</option>
                                            </select>
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
                                            <label>Depo Bedeli</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="depo_bedeli">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Taşıma Bedeli</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="tasima_bedeli">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="is_emri_kapat"><i class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="is_emrini_kaydet_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("body").off("click", "#mal_cinsi_ekle_button").on("click", "#mal_cinsi_ekle_button", function () {
            $.get("depo/modals/is_emri_modal/is_emri_olustur_modal.php?islem=yeni_mal_cinsi_ekle_modal", function (getModal) {
                $(".yeni_mal_cinsi_ekle").html(getModal);
            })
        });


        $("body").off("click", "#mal_cinslerini_getir_button").on("click", "#mal_cinslerini_getir_button", function () {
            $.get("depo/modals/is_emri_modal/is_emri_olustur_modal.php?islem=mal_cinslerini_getir_modal", function (getModal) {
                $(".mal_cinsleri_div").html(getModal);
            })
        });

        $("body").off("focusout", "#satis_fiyat").on("focusout", "#satis_fiyat", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("focusout", "#tasima_bedeli").on("focusout", "#tasima_bedeli", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("focusout", "#depo_bedeli").on("focusout", "#depo_bedeli", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("focusout", "#alis_fiyat").on("focusout", "#alis_fiyat", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("focusout", "#prim_tutari").on("focusout", "#prim_tutari", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        var hizmet_table = "";
        $(document).ready(function () {
            $("#is_emri_olustur_ana_modal").modal("show");
            $.get("depo/controller/is_emri_controller/sql.php?islem=birimleri_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#birim_id").append("<option value='" + item.id + "'>" + item.birim_adi + "</option>");
                    })
                }
            })
            $.get("depo/controller/is_emri_controller/sql.php?islem=birimleri_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#birim_id_urun").append("<option value='" + item.id + "'>" + item.birim_adi + "</option>");
                    })
                }
            })

            setTimeout(function () {
                $("#istasyonclick").trigger("click");
            }, 500);
            hizmet_table = $("#konteyner_yakit_fis_fatura_list").DataTable({
                scrollY: '40vh',
                scrollX: true,
                "info": false,
                "order": [[0, 'desc']],
                autoWidth: false,
                columnDefs: [
                    {targets: 0, type: "date-eu"}
                ],
                createdRow: function (new_row) {
                    $(new_row).addClass("is_emri_hizmet_listesi");
                    $(new_row).find('td').css('text-align', 'left');
                    $(new_row).find("td").eq(2).css("text-align", "right");
                    $(new_row).find("td").eq(4).css("text-align", "right");
                    $(new_row).find("td").eq(5).css("text-align", "right");
                    $(new_row).find("td").eq(6).css("text-align", "right");
                    $(new_row).find("td").eq(7).css("text-align", "right");
                },
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
            });
            $.get("depo/controller/is_emri_controller/sql.php?islem=son_epro_referans_sql", function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    let gelen_siparis_no = item.epro_ref;
                    gelen_siparis_no = gelen_siparis_no.slice(-4);
                    let siparis_no = "";
                    gelen_siparis_no = parseInt(gelen_siparis_no);
                    gelen_siparis_no += 1;
                    gelen_siparis_no = gelen_siparis_no.toString().padStart(5, '0');
                    var simdikiTarih = new Date();
                    var bulundugumuzYil = simdikiTarih.getFullYear();
                    var bulundugumuzAy = (simdikiTarih.getMonth() + 1).toString().padStart(2, '0');
                    siparis_no = bulundugumuzYil + "" + bulundugumuzAy + gelen_siparis_no;
                    $("#epro_ref").val("DEPO" + siparis_no);
                } else {
                    var tarih = new Date();
                    var yil = tarih.getFullYear();
                    var ay = tarih.getMonth();
                    ay = ay + 1;
                    ay = ay.toString().padStart(2, '0');
                    let basilacak = yil + "" + ay + "0001";
                    $("#epro_ref").val("DEPO" + basilacak);

                }
            })
        });

        $("body").off("click", ".is_emri_hizmet_sil").on("click", ".is_emri_hizmet_sil", function () {
            hizmet_table.row($(this).parents('tr')).remove().draw();
        });

        $("body").off("click", "#is_emrine_hizmet_ekle").on("click", "#is_emrine_hizmet_ekle", function () {
            let hizmet_id = $(".hizmet_adi2").attr("data-id");
            let hizmet_adi = $(".hizmet_adi2").val();
            let birim_id = $("#birim_id_urun").val();
            let birim_adi = $("#birim_id_urun option:selected").text();
            let hizmet_turu = $("#hizmet_turu").val();
            let prim_tutari = $("#prim_tutari").val();
            let alis_fiyat = $("#alis_fiyat").val();
            let sefer_sayisi = $("#sefer_sayisi").val();
            let satis_fiyat = $("#satis_fiyat").val();
            if (hizmet_id == undefined || hizmet_id == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir Hizmet Giriniz...",
                    "warning"
                );
            } else if (birim_id == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Birim Giriniz...",
                    "warning"
                );
            } else {
                let row = hizmet_table.row.add([hizmet_adi, birim_adi, sefer_sayisi, hizmet_turu, prim_tutari, alis_fiyat, satis_fiyat, "<button class='btn btn-danger btn-sm is_emri_hizmet_sil'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                $(row).attr("hizmet_id", hizmet_id);
                $(row).attr("birim_id", birim_id);

                $(".hizmet_adi2").attr("data-id", "");
                $(".hizmet_adi2").val("");
                $("#birim_id_urun").val("");
                $("#hizmet_turu").val("");
                $("#prim_tutari").val("0,00");
                $("#alis_fiyat").val("0,00");
                $("#sefer_sayisi").val("");
                $("#satis_fiyat").val("0,00");
            }
        });

        $("body").off("click", "#is_emrini_kaydet_button").on("click", "#is_emrini_kaydet_button", function () {
            let epro_ref = $("#epro_ref").val();
            let cari_id = $("#firma_kodu").attr("data-id");
            let konteyner_sayisi = $("#konteyner_sayisi").val();
            let konteyner_tipi = $("#konteyner_tipi").val();
            let urun_adi = $(".mal_adi").val();
            let urun_id = $(".mal_adi").attr("data-id");
            let hizmet_id = $(".hizmet_adi").attr("data-id");
            let depo_cariid = $("#depo_cariid").attr("data-id");
            let miktar = $("#yuk_miktari").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            let birim_id = $("#birim_id").val();
            let tipi = $("#tipi").val();
            let beyanname_no = $("#beyanname_no").val();
            let referans_no = $("#referans_no").val();
            let acente = $("#acente").val();
            let siparis_tarihi = $("#siparis_tarihi").val();
            let demoraj_tarihi = $("#demoraj_tarihi").val();
            let cut_of_tarihi = $("#cut_of_tarihi").val();
            let ardiyesiz_giris_tarihi = $("#ardiyesiz_giris_tarihi").val();
            let kont_alim_yeri = $("#kont_alim_yeri").val();
            let depo_bedeli = $("#depo_bedeli").val();
            depo_bedeli = depo_bedeli.replace(/\./g, "").replace(",", ".");
            depo_bedeli = parseFloat(depo_bedeli);
            let tasima_bedeli = $("#tasima_bedeli").val();
            tasima_bedeli = tasima_bedeli.replace(/\./g, "").replace(",", ".");
            tasima_bedeli = parseFloat(tasima_bedeli);
            let aciklama = $("#aciklama").val();
            let forklift_turu = $("#forklift_turu").val();
            let kont_teslim_yeri = $("#kont_teslim_yeri").val();

            let urun_arr = [];

            $(".is_emri_hizmet_listesi").each(function () {
                let hizmet_id = $(this).attr("hizmet_id");
                let birim_id = $(this).attr("birim_id");
                let sefer_sayisi = $(this).find("td").eq(2).text();
                let hizmet_turu = $(this).find("td").eq(3).text();
                let prim_tutari = $(this).find("td").eq(4).text();
                prim_tutari = prim_tutari.replace(/\./g, "").replace(",", ".");
                prim_tutari = parseFloat(prim_tutari);
                let alis_fiyat = $(this).find("td").eq(5).text();
                alis_fiyat = alis_fiyat.replace(/\./g, "").replace(",", ".");
                alis_fiyat = parseFloat(alis_fiyat);
                let satis_fiyat = $(this).find("td").eq(6).text();
                satis_fiyat = satis_fiyat.replace(/\./g, "").replace(",", ".");
                satis_fiyat = parseFloat(satis_fiyat);

                let newRow = {
                    hizmet_id: hizmet_id,
                    birim_id: birim_id,
                    sefer_sayisi: sefer_sayisi,
                    hizmet_turu: hizmet_turu,
                    prim_tutari: prim_tutari,
                    alis_fiyat: alis_fiyat,
                    satis_fiyat: satis_fiyat
                };
                urun_arr.push(newRow);
            });

            if (cari_id == undefined || cari_id == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir Cari Seçiniz...",
                    "warning"
                );
            } else if (hizmet_id == undefined || hizmet_id == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir Hizmet Seçiniz...",
                    "warning"
                )
            } else {
                $.ajax({
                    url: "depo/controller/is_emri_controller/sql.php?islem=is_emri_kaydet_sql",
                    type: "POST",
                    data: {
                        epro_ref: epro_ref,
                        cari_id: cari_id,
                        konteyner_sayisi: konteyner_sayisi,
                        konteyner_tipi: konteyner_tipi,
                        aciklama: aciklama,
                        urun_adi: urun_adi,
                        forklift_turu: forklift_turu,
                        urun_arr: urun_arr,
                        hizmet_id: hizmet_id,
                        miktar: miktar,
                        depo_bedeli: depo_bedeli,
                        tasima_bedeli: tasima_bedeli,
                        birim_id: birim_id,
                        tipi: tipi,
                        depo_cariid: depo_cariid,
                        urun_id: urun_id,
                        beyanname_no: beyanname_no,
                        referans_no: referans_no,
                        acente: acente,
                        siparis_tarihi: siparis_tarihi,
                        demoraj_tarihi: demoraj_tarihi,
                        cut_of_tarihi: cut_of_tarihi,
                        ardiyesiz_giris_tarihi: ardiyesiz_giris_tarihi,
                        kont_alim_yeri: kont_alim_yeri,
                        kont_teslim_yeri: kont_teslim_yeri
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "İş Emri Kaydedildi",
                                "success"
                            );
                            $.get("depo/view/depo_ithalat_is_emri.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/depo_ithalat_is_emri.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                            $("#is_emri_olustur_ana_modal").modal("hide");
                        }
                    }
                });
            }
        });

        $("body").off("change", "#tipi").on("change", "#tipi", function () {
            let val = $(this).val();
            if (val == "İHRACAT") {
                $("#demoraj_tarihi,#beyanname_no").val("");
                $("#demoraj_tarihi,#beyanname_no").prop("disabled", true);
                $("#ardiyesiz_giris_tarihi,#cut_of_tarihi,#referans_no").prop("disabled", false);
            } else if (val == "İTHALAT") {
                $("#ardiyesiz_giris_tarihi,#cut_of_tarihi,#referans_no").prop("disabled", true);
                $("#demoraj_tarihi,#beyanname_no").prop("disabled", false);
                $("#ardiyesiz_giris_tarihi,#cut_of_tarihi,#referans_no").val("");
            } else {
                $("#ardiyesiz_giris_tarihi,#cut_of_tarihi,#referans_no").prop("disabled", true);
                $("#demoraj_tarihi,#beyanname_no").prop("disabled", true);
                $("#demoraj_tarihi,#beyanname_no").val("");
                $("#ardiyesiz_giris_tarihi,#cut_of_tarihi,#referans_no").val("");
            }
        });


        $("body").off("focusout", "#yuk_miktari").on("focusout", "#yuk_miktari", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));

        });


        $("body").off("click", "#hizmetleri_getir_button").on("click", "#hizmetleri_getir_button", function () {
            $.get("depo/modals/is_emri_modal/is_emri_olustur_modal.php?islem=depo_stoklarini_getir_modal", function (getModal) {
                $(".depo_stoklarini_getir_div").html(getModal);
            })
        });

        $("body").off("click", "#hizmetleri_getir_button2").on("click", "#hizmetleri_getir_button2", function () {
            $.get("depo/modals/is_emri_modal/is_emri_olustur_modal.php?islem=depo_stoklarini_getir_modal2", function (getModal) {
                $(".depo_stoklarini_getir_div").html(getModal);
            })
        });

        $("body").off("click", "#depo_musteri_firma_kodu_button").on("click", "#depo_musteri_firma_kodu_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=musteri_firma_kodu2", function (getModal) {
                $(".konteyner_irsaliye_firmalari_getir_div").html("");
                $(".konteyner_irsaliye_firmalari_getir_div").html(getModal);
            });
        });

        $("body").off("click", "#musteri_firma_kodu_button").on("click", "#musteri_firma_kodu_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=musteri_firma_kodu", function (getModal) {
                $(".konteyner_irsaliye_firmalari_getir_div").html("");
                $(".konteyner_irsaliye_firmalari_getir_div").html(getModal);
            });
        });


        $("body").off("click", "#is_emri_kapat").on("click", "#is_emri_kapat", function () {
            $("#is_emri_olustur_ana_modal").modal("hide");
        })

    </script>
    <?php
}
if ($islem == "depo_stoklarini_getir_modal") {
    ?>
    <div class="modal fade" data-backdrop="static" id="konteyner_irsaliye_ek_hizmetler"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 50%; max-width: 50%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">HİZMET LİSTESİ
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat1"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="konteyner_irsaliye_ek_hizmet_table">
                            <thead>
                            <tr>
                                <th id="click1_stok">Hizmet Kodu</th>
                                <th>Hizmet Adı</th>
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
            $("#konteyner_irsaliye_ek_hizmetler").modal("show");
            var stok_table = $('#konteyner_irsaliye_ek_hizmet_table').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                paging: false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "stok_adi"},
                    {'data': "stok_kodu"}
                ],
                createdRow: function (row) {
                    $(row).find("td").eq(0).css("text-align", "left");
                    $(row).find("td").eq(1).css("text-align", "left");
                    $(row).addClass("guzergah_select");
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id);
                }
            })
            $.get("depo/controller/is_emri_controller/sql.php?islem=hizmetleri_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    var basiacak_arr = [];
                    json.forEach(function (item) {
                        let prim = item.yol_primi;
                        prim = parseFloat(prim);
                        prim = prim.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2})
                        let newRow = {
                            stok_adi: item.stok_adi,
                            stok_kodu: item.stok_kodu,
                            yol_primi: prim,
                            id: item.id
                        }
                        basiacak_arr.push(newRow);
                    });

                    stok_table.rows.add(basiacak_arr).draw(false);
                }
            });

            $("body").off("click", ".guzergah_select").on("click", ".guzergah_select", function () {
                var id = $(this).attr("data-id");
                let guzergah_adi = $(this).find("td").eq(0).text();
                $(".hizmet_adi").val(guzergah_adi);
                $(".hizmet_adi").attr("data-id", id);
                $("#konteyner_irsaliye_ek_hizmetler").modal("hide");
            });
        });

        $("body").off("click", "#modal_kapat1").on("click", "#modal_kapat1", function () {
            $("#konteyner_irsaliye_ek_hizmetler").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "depo_stoklarini_getir_modal2") {
    ?>
    <div class="modal fade" data-backdrop="static" id="konteyner_irsaliye_ek_hizmetler2"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 50%; max-width: 50%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">HİZMET LİSTESİ
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat1"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="konteyner_irsaliye_ek_hizmet_table">
                            <thead>
                            <tr>
                                <th id="click1_stok">Hizmet Kodu</th>
                                <th>Hizmet Adı</th>
                                <th>Prim Tutarı</th>
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
            $("#konteyner_irsaliye_ek_hizmetler2").modal("show");
            var stok_table = $('#konteyner_irsaliye_ek_hizmet_table').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                paging: false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "stok_adi"},
                    {'data': "stok_kodu"},
                    {'data': "yol_primi"}
                ],
                createdRow: function (row) {
                    $(row).find("td").eq(0).css("text-align", "left");
                    $(row).find("td").eq(1).css("text-align", "left");
                    $(row).addClass("guzergah_select");
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id);
                }
            })
            $.get("depo/controller/is_emri_controller/sql.php?islem=hizmetleri_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    var basiacak_arr = [];
                    json.forEach(function (item) {
                        let prim = item.yol_primi;
                        prim = parseFloat(prim);
                        prim = prim.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2})
                        let newRow = {
                            stok_adi: item.stok_adi,
                            stok_kodu: item.stok_kodu,
                            yol_primi: prim,
                            id: item.id
                        }
                        basiacak_arr.push(newRow);
                    });

                    stok_table.rows.add(basiacak_arr).draw(false);
                }
            });

            $("body").off("click", ".guzergah_select").on("click", ".guzergah_select", function () {
                var id = $(this).attr("data-id");
                let guzergah_adi = $(this).find("td").eq(0).text();
                let prim_tutari = $(this).find("td").eq(2).text();
                $(".hizmet_adi2").val(guzergah_adi);
                $(".hizmet_adi2").attr("data-id", id);
                $("#prim_tutari").val(prim_tutari);
                $("#birim_id_urun").focus();
                $("#konteyner_irsaliye_ek_hizmetler2").modal("hide");
            });
        });

        $("body").off("click", "#modal_kapat1").on("click", "#modal_kapat1", function () {
            $("#konteyner_irsaliye_ek_hizmetler2").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "depo_is_emri_guncelle_modal") {
    ?>
    <style>
        #is_emrini_guncelle_main_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="is_emrini_guncelle_main_modal" data-bs-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 100%; max-width: 100%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="is_emri_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>İŞ EMRİ GİRİŞ</div>
                        </div>
                        <div class="modal-body">
                            <div class="mal_cinsleri_div"></div>
                            <div class="yeni_mal_cinsi_ekle"></div>
                            <div class="konteyner_irsaliye_firmalari_getir_div"></div>
                            <div class="depo_stoklarini_getir_div"></div>
                            <div class="col-12 row">
                                <div class="col-4">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Epro Ref.</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" disabled
                                                   id="epro_ref">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Cari Kodu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="firma_kodu">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="musteri_firma_kodu_button"><i
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
                                            <input type="text" class="form-control form-control-sm" id="firma_unvan"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Vergi Dairesi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="vergi_dairesi"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Vergi No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="vergi_no"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Kont. Sayısı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="number" class="form-control form-control-sm"
                                                   id="konteyner_sayisi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Kont. Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="konteyner_tipi">
                                                <option value="">Konteyner Tipi</option>
                                                <option value="40 HC">40 HC</option>
                                                <option value="20 DC">20 DC</option>
                                                <option value="40 DC">40 DC</option>
                                                <option value="20 OT">20 OT</option>
                                                <option value="40 OT">40 OT</option>
                                                <option value="20 RF">20 RF</option>
                                                <option value="40 RF">40 RF</option>
                                                <option value="40 HC RF">40 HC RF</option>
                                                <option value="20 TANK">20 TANK</option>
                                                <option value="20 VENTILATED">20 VENTILATED</option>
                                                <option value="40 HC PAL. WIDE">40 HC PAL. WIDE</option>
                                                <option value="20 FALT">20 FALT</option>
                                                <option value="40 FLAT">40 FLAT</option>
                                                <option value="40 HC FLAT">40 HC FLAT</option>
                                                <option value="20 PLATFORM">20 PLATFORM</option>
                                                <option value="40 PLATFORM">40 PLATFORM</option>
                                                <option value="45 HC">45 HC</option>
                                                <option value="KARGO">KARGO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Hizmet Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm hizmet_adi"
                                                       placeholder="Hizmet Adı">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="hizmetleri_getir_button">
                                                        <i
                                                                class="fa fa-ellipsis-h"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Miktar</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" style="text-align: right"
                                                   class="form-control form-control-sm" id="yuk_miktari">
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
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="tipi">
                                                <option value="İHRACAT">İHRACAT</option>
                                                <option value="İTHALAT">İTHALAT</option>
                                            </select>
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
                                            <label>Referans</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="referans_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Acenta</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="acente">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-4">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Sipariş Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>" id="siparis_tarihi"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Demoraj Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" class="form-control form-control-sm" id="demoraj_tarihi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>CUT-OFF Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" class="form-control form-control-sm" id="cut_of_tarihi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Ardiyesiz Giriş Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" class="form-control form-control-sm"
                                                   id="ardiyesiz_giris_tarihi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Kont. Alım Yeri</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="kont_alim_yeri">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Kont. Teslim Yeri</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="kont_teslim_yeri">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Mal Cinsi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm mal_adi_guncelle"
                                                       placeholder="Mal Cinsi"
                                                       id="mal_kodu">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="mal_cinslerini_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i>
                                                    </button>
                                                    <button class="btn btn-success btn-sm" id="mal_cinsi_ekle_button"><i
                                                                class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if (isset($_GET["kiralik"])):
                                        ?>
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label>Kiralık Cari Adı</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm"
                                                           id="depo_cariid">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-warning btn-sm"
                                                                id="depo_musteri_firma_kodu_button"><i
                                                                    class="fa fa-ellipsis-h"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    endif;
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-12 row no-gutters">
                                <div class="col">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;Hizmet
                                        Adı</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm hizmet_adi2"
                                               placeholder="Hizmet Adı">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm" id="hizmetleri_getir_button2">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;Birim</label>
                                    <select class="custom-select custom-select-sm" id="birim_id_urun">
                                        <option value="">Birim Seçiniz...</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;Sefer Sayısı</label>
                                    <input type="text" class="form-control form-control-sm" id="sefer_sayisi"
                                           placeholder="Sefer Sayısı">
                                </div>
                                <div class="col">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;Hizmet Türü</label>
                                    <select class="custom-select custom-select-sm" id="hizmet_turu">
                                        <option value="Depo Hizmeti" selected>Depo Hizmeti</option>
                                        <option value="Taşıma Hizmeti">Taşıma Hizmeti</option>
                                        <option value="Aktarma Hizmeti">Aktarma Hizmeti</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;Prim Tutarı</label>
                                    <input type="text" id="prim_tutari" class="form-control form-control-sm"
                                           value="0,00"
                                           placeholder="Prim Tutarı">
                                </div>
                                <div class="col">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;Alış Fiyat</label>
                                    <input type="text" id="alis_fiyat" class="form-control form-control-sm" value="0,00"
                                           placeholder="Alış Fiyat">
                                </div>
                                <div class="col">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;Satış Fiyat</label>
                                    <input type="text" class="form-control form-control-sm" id="satis_fiyat"
                                           value="0,00"
                                           placeholder="Satış Fiyat">
                                </div>
                                <div class="col-md-2 row">
                                    <button style="width: 100% !important;"
                                            class="btn btn-success btn-sm mx-5" id="is_emrine_hizmet_ekle"><i
                                                class="fa fa-plus"></i> Ekle
                                    </button>
                                    <button class="btn btn-primary btn-sm mx-5 mt-1" id=""><i
                                                class="fa fa-save"></i> Kayıtlı İş Emrine Ekle
                                    </button>
                                    <button style="width: 100% !important;"
                                            class="btn btn-secondary btn-sm mx-5 mt-1" id=""><i
                                                class="fa fa-download"></i> Kayıtlı İş Emirleri
                                    </button>
                                </div>
                            </div>
                            <div class="col-12">
                                <table class="table table-sm table-bordered w-100 display nowrap"
                                       style="cursor:pointer;font-size: 13px;"
                                       id="konteyner_yakit_fis_fatura_list">
                                    <thead>
                                    <tr>
                                        <th style="width: 0% !important;">Hizmet Adı</th>
                                        <th id="istasyonclick">Birim</th>
                                        <th>Sefer Sayısı</th>
                                        <th>Hizmet Türü</th>
                                        <th>Prim Tutarı</th>
                                        <th>Alış Fiyat</th>
                                        <th>Satış Fiyat</th>
                                        <th>İşlem</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="col-12 row mt-2">
                                <div class="col-4"></div>
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Forklift Türü</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select custom-select-sm"
                                                    id="forklift_turu">
                                                <option value="Çatal">ÇATAL</option>
                                                <option value="Sıkma">SIKMA</option>
                                            </select>
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
                                            <label>Depo Bedeli</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="depo_bedeli">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Taşıma Bedeli</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="tasima_bedeli">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="is_emri_kapat"><i class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="is_emrini_guncelle_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("body").off("click", "#mal_cinsi_ekle_button").on("click", "#mal_cinsi_ekle_button", function () {
            $.get("depo/modals/is_emri_modal/is_emri_olustur_modal.php?islem=yeni_mal_cinsi_ekle_modal", function (getModal) {
                $(".yeni_mal_cinsi_ekle").html(getModal);
            })
        });


        $("body").off("click", "#mal_cinslerini_getir_button").on("click", "#mal_cinslerini_getir_button", function () {
            $.get("depo/modals/is_emri_modal/is_emri_olustur_modal.php?islem=mal_cinslerini_getir_modal", function (getModal) {
                $(".mal_cinsleri_div").html(getModal);
            })
        });
        $("body").off("click", "#depo_musteri_firma_kodu_button").on("click", "#depo_musteri_firma_kodu_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=musteri_firma_kodu2", function (getModal) {
                $(".konteyner_irsaliye_firmalari_getir_div").html("");
                $(".konteyner_irsaliye_firmalari_getir_div").html(getModal);
            });
        });

        $("body").off("focusout", "#satis_fiyat").on("focusout", "#satis_fiyat", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("focusout", "#tasima_bedeli").on("focusout", "#tasima_bedeli", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("focusout", "#depo_bedeli").on("focusout", "#depo_bedeli", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("focusout", "#alis_fiyat").on("focusout", "#alis_fiyat", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("focusout", "#prim_tutari").on("focusout", "#prim_tutari", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        var hizmet_guncelle_table = "";
        $(document).ready(function () {
            $("#is_emrini_guncelle_main_modal").modal("show");
            $.get("depo/controller/is_emri_controller/sql.php?islem=birimleri_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#birim_id").append("<option value='" + item.id + "'>" + item.birim_adi + "</option>");
                    })
                }
            })
            $.get("depo/controller/is_emri_controller/sql.php?islem=birimleri_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#birim_id_urun").append("<option value='" + item.id + "'>" + item.birim_adi + "</option>");
                    })
                }
            });

            $.get("depo/controller/is_emri_controller/sql.php?islem=is_emrinin_ana_bilgilerini_getir_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#epro_ref").val(item.epro_ref);
                    $("#firma_kodu").attr("data-id", item.cari_id);
                    $("#firma_kodu").val(item.cari_kodu);
                    $("#firma_unvan").val(item.cari_adi);
                    $(".mal_adi_guncelle").val(item.urun_adi);
                    $(".mal_adi_guncelle").attr("data-id", item.urun_id);
                    $("#vergi_no").val(item.vergi_no);
                    $("#vergi_dairesi").val(item.vergi_dairesi);
                    $("#konteyner_sayisi").val(item.konteyner_sayisi);
                    $("#konteyner_tipi").val(item.konteyner_tipi);
                    $("#depo_cariid").attr("data-id", item.depo_cariid);
                    $("#depo_cariid").val(item.depo_cari);
                    $(".hizmet_adi").attr("data-id", item.hizmet_id);
                    $(".hizmet_adi").val(item.hizmet_adi);
                    let miktar = item.miktar;
                    miktar = parseFloat(miktar);
                    miktar = miktar.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });
                    $("#yuk_miktari").val(miktar);
                    setTimeout(function () {
                        $("#birim_id").val(item.birim_id);
                    }, 500);
                    $("#tipi").val(item.tipi);
                    $("#beyanname_no").val(item.beyanname_no);
                    $("#referans_no").val(item.referans_no);
                    $("#acente").val(item.acente);
                    $("#siparis_tarihi").val(item.siparis_tarihi);
                    $("#demoraj_tarihi").val(item.demoraj_tarihi);
                    $("#cut_of_tarihi").val(item.cut_of_tarihi);
                    $("#ardiyesiz_giris_tarihi").val(item.ardiyesiz_giris_tarihi);
                    $("#kont_alim_yeri").val(item.kont_alim_yeri);
                    let depo_bedeli = item.depo_bedeli;
                    depo_bedeli = parseFloat(depo_bedeli);
                    depo_bedeli = depo_bedeli.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });
                    let tasima_bedeli = item.tasima_bedeli;
                    tasima_bedeli = parseFloat(tasima_bedeli);
                    tasima_bedeli = tasima_bedeli.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });
                    $("#depo_bedeli").val(depo_bedeli);
                    $("#tasima_bedeli").val(tasima_bedeli);
                    $("#aciklama").val(item.aciklama);
                    $("#forklift_turu").val(item.forklift_turu);
                    $("#kont_teslim_yeri").val(item.kont_teslim_yeri);

                    if (item.tipi == "İHRACAT") {
                        $("#demoraj_tarihi,#beyanname_no").val("");
                        $("#demoraj_tarihi,#beyanname_no").prop("disabled", true);
                        $("#ardiyesiz_giris_tarihi,#cut_of_tarihi,#referans_no").prop("disabled", false);
                    } else if (item.tipi == "İTHALAT") {
                        $("#ardiyesiz_giris_tarihi,#cut_of_tarihi,#referans_no").prop("disabled", true);
                        $("#demoraj_tarihi,#beyanname_no").prop("disabled", false);
                        $("#ardiyesiz_giris_tarihi,#cut_of_tarihi,#referans_no").val("");
                    }
                }
            });

            $.get("depo/controller/is_emri_controller/sql.php?islem=is_emrina_ait_urunler_sql", {is_emri_id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        let prim_tutari = item.prim_tutari;
                        prim_tutari = parseFloat(prim_tutari)
                        prim_tutari = prim_tutari.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        let alis_fiyat = item.alis_fiyat;
                        alis_fiyat = parseFloat(alis_fiyat)
                        alis_fiyat = alis_fiyat.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        let satis_fiyat = item.satis_fiyat;
                        satis_fiyat = parseFloat(satis_fiyat)
                        satis_fiyat = satis_fiyat.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        hizmet_guncelle_table.row.add([item.hizmet_adi, item.birim_adi, item.sefer_sayisi, item.hizmet_turu, prim_tutari, alis_fiyat, satis_fiyat, item.islem]).draw(false);
                    })
                }
            })

            setTimeout(function () {
                $("#istasyonclick").trigger("click");
            }, 500);
            hizmet_guncelle_table = $("#konteyner_yakit_fis_fatura_list").DataTable({
                scrollY: '40vh',
                scrollX: true,
                "info": false,
                "order": [[0, 'desc']],
                autoWidth: false,
                columnDefs: [
                    {targets: 0, type: "date-eu"}
                ],
                createdRow: function (new_row) {
                    $(new_row).addClass("is_emri_hizmet_listesi");
                    $(new_row).find('td').css('text-align', 'left');
                    $(new_row).find("td").eq(2).css("text-align", "right");
                    $(new_row).find("td").eq(4).css("text-align", "right");
                    $(new_row).find("td").eq(5).css("text-align", "right");
                    $(new_row).find("td").eq(6).css("text-align", "right");
                    $(new_row).find("td").eq(7).css("text-align", "right");
                },
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
            });
        });

        $("body").off("click", "#is_emrine_hizmet_ekle").on("click", "#is_emrine_hizmet_ekle", function () {
            let hizmet_id = $(".hizmet_adi2").attr("data-id");
            let hizmet_adi = $(".hizmet_adi2").val();
            let birim_id = $("#birim_id_urun").val();
            let birim_adi = $("#birim_id_urun option:selected").text();
            let hizmet_turu = $("#hizmet_turu").val();
            let prim_tutari = $("#prim_tutari").val();
            prim_tutari = prim_tutari.replace(/\./g, "").replace(",", ".");
            prim_tutari = parseFloat(prim_tutari);
            let alis_fiyat = $("#alis_fiyat").val();
            alis_fiyat = alis_fiyat.replace(/\./g, "").replace(",", ".");
            alis_fiyat = parseFloat(alis_fiyat);
            let sefer_sayisi = $("#sefer_sayisi").val();
            let satis_fiyat = $("#satis_fiyat").val();
            let sat_fit = $("#satis_fiyat").val();
            let al_fit = $("#alis_fiyat").val();
            let prim_fit = $("#prim_tutari").val();
            satis_fiyat = satis_fiyat.replace(/\./g, "").replace(",", ".");
            satis_fiyat = parseFloat(satis_fiyat);

            if (hizmet_id == undefined || hizmet_id == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir Hizmet Giriniz...",
                    "warning"
                );
            } else if (birim_id == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Birim Giriniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "depo/controller/is_emri_controller/sql.php?islem=is_emrine_hizmet_ekle_sql",
                    type: "POST",
                    data: {
                        hizmet_id: hizmet_id,
                        birim_id: birim_id,
                        hizmet_turu: hizmet_turu,
                        prim_tutari: prim_tutari,
                        alis_fiyat: alis_fiyat,
                        satis_fiyat: satis_fiyat,
                        sefer_sayisi: sefer_sayisi,
                        is_emri_id: "<?=$_GET["id"]?>"
                    },
                    success: function (res) {
                        if (res != 2) {
                            let id = res;
                            id = id.split(":");
                            id = id[1];
                            let row = hizmet_guncelle_table.row.add([hizmet_adi, birim_adi, sefer_sayisi, hizmet_turu, prim_fit, al_fit, sat_fit, "<button class='btn btn-danger btn-sm is_emri_hizmeti_sil_guncelle' data-id='" + id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                            $(row).attr("hizmet_id", hizmet_id);
                            $(row).attr("birim_id", birim_id);
                        }
                    }
                });

                $(".hizmet_adi2").attr("data-id", "");
                $(".hizmet_adi2").val("");
                $("#birim_id_urun").val("");
                $("#hizmet_turu").val("");
                $("#prim_tutari").val("0,00");
                $("#alis_fiyat").val("0,00");
                $("#sefer_sayisi").val("");
                $("#satis_fiyat").val("0,00");
            }
        });

        $("body").off("click", ".is_emri_hizmeti_sil_guncelle").on("click", ".is_emri_hizmeti_sil_guncelle", function () {
            let id = $(this).attr("data-id");
            let closest = $(this).closest("tr");
            $.ajax({
                url: "depo/controller/is_emri_controller/sql.php?islem=is_emrini_listeden_sil_sql",
                type: "POST",
                data: {
                    id: id
                },
                success: function (res) {
                    if (res == 1) {
                        hizmet_guncelle_table.row(closest).remove().draw();
                    }
                }
            });
        });

        $("body").off("click", "#is_emrini_guncelle_button").on("click", "#is_emrini_guncelle_button", function () {
            let epro_ref = $("#epro_ref").val();
            let cari_id = $("#firma_kodu").attr("data-id");
            let konteyner_sayisi = $("#konteyner_sayisi").val();
            let konteyner_tipi = $("#konteyner_tipi").val();
            let hizmet_id = $(".hizmet_adi").attr("data-id");
            let mal_id = $(".mal_adi_guncelle").attr("data-id");
            let mal_adi = $(".mal_adi_guncelle").val();
            let miktar = $("#yuk_miktari").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            let birim_id = $("#birim_id").val();
            let tipi = $("#tipi").val();
            let beyanname_no = $("#beyanname_no").val();
            let depo_cariid = $("#depo_cariid").attr("data-id");
            let referans_no = $("#referans_no").val();
            let acente = $("#acente").val();
            let siparis_tarihi = $("#siparis_tarihi").val();
            let demoraj_tarihi = $("#demoraj_tarihi").val();
            let cut_of_tarihi = $("#cut_of_tarihi").val();
            let ardiyesiz_giris_tarihi = $("#ardiyesiz_giris_tarihi").val();
            let kont_alim_yeri = $("#kont_alim_yeri").val();
            let depo_bedeli = $("#depo_bedeli").val();
            depo_bedeli = depo_bedeli.replace(/\./g, "").replace(",", ".");
            depo_bedeli = parseFloat(depo_bedeli);
            let tasima_bedeli = $("#tasima_bedeli").val();
            tasima_bedeli = tasima_bedeli.replace(/\./g, "").replace(",", ".");
            tasima_bedeli = parseFloat(tasima_bedeli);
            let aciklama = $("#aciklama").val();
            let forklift_turu = $("#forklift_turu").val();
            let kont_teslim_yeri = $("#kont_teslim_yeri").val();

            if (cari_id == undefined || cari_id == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir Cari Seçiniz...",
                    "warning"
                );
            } else if (hizmet_id == undefined || hizmet_id == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir Hizmet Seçiniz...",
                    "warning"
                )
            } else {
                $.ajax({
                    url: "depo/controller/is_emri_controller/sql.php?islem=is_emri_guncelle_sql",
                    type: "POST",
                    data: {
                        epro_ref: epro_ref,
                        cari_id: cari_id,
                        konteyner_sayisi: konteyner_sayisi,
                        urun_id: mal_id,
                        urun_adi: mal_adi,
                        konteyner_tipi: konteyner_tipi,
                        aciklama: aciklama,
                        forklift_turu: forklift_turu,
                        hizmet_id: hizmet_id,
                        depo_cariid: depo_cariid,
                        id: "<?=$_GET["id"]?>",
                        miktar: miktar,
                        depo_bedeli: depo_bedeli,
                        tasima_bedeli: tasima_bedeli,
                        birim_id: birim_id,
                        tipi: tipi,
                        beyanname_no: beyanname_no,
                        referans_no: referans_no,
                        acente: acente,
                        siparis_tarihi: siparis_tarihi,
                        demoraj_tarihi: demoraj_tarihi,
                        cut_of_tarihi: cut_of_tarihi,
                        ardiyesiz_giris_tarihi: ardiyesiz_giris_tarihi,
                        kont_alim_yeri: kont_alim_yeri,
                        kont_teslim_yeri: kont_teslim_yeri
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "İş Emri Kaydedildi",
                                "success"
                            );
                            $.get("depo/view/depo_ithalat_is_emri.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/depo_ithalat_is_emri.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                            $("#is_emrini_guncelle_main_modal").modal("hide");
                        }
                    }
                });
            }
        });

        $("body").off("change", "#tipi").on("change", "#tipi", function () {
            let val = $(this).val();
            if (val == "İHRACAT") {
                $("#demoraj_tarihi,#beyanname_no").val("");
                $("#demoraj_tarihi,#beyanname_no").prop("disabled", true);
                $("#ardiyesiz_giris_tarihi,#cut_of_tarihi,#referans_no").prop("disabled", false);
            } else if (val == "İTHALAT") {
                $("#ardiyesiz_giris_tarihi,#cut_of_tarihi,#referans_no").prop("disabled", true);
                $("#demoraj_tarihi,#beyanname_no").prop("disabled", false);
                $("#ardiyesiz_giris_tarihi,#cut_of_tarihi,#referans_no").val("");
            }
        });


        $("body").off("focusout", "#yuk_miktari").on("focusout", "#yuk_miktari", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));

        });


        $("body").off("click", "#hizmetleri_getir_button").on("click", "#hizmetleri_getir_button", function () {
            $.get("depo/modals/is_emri_modal/is_emri_olustur_modal.php?islem=depo_stoklarini_getir_modal", function (getModal) {
                $(".depo_stoklarini_getir_div").html(getModal);
            })
        });

        $("body").off("click", "#hizmetleri_getir_button2").on("click", "#hizmetleri_getir_button2", function () {
            $.get("depo/modals/is_emri_modal/is_emri_olustur_modal.php?islem=depo_stoklarini_getir_modal2", function (getModal) {
                $(".depo_stoklarini_getir_div").html(getModal);
            })
        });

        $("body").off("click", "#musteri_firma_kodu_button").on("click", "#musteri_firma_kodu_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=musteri_firma_kodu", function (getModal) {
                $(".konteyner_irsaliye_firmalari_getir_div").html("");
                $(".konteyner_irsaliye_firmalari_getir_div").html(getModal);
            });
        });


        $("body").off("click", "#is_emri_kapat").on("click", "#is_emri_kapat", function () {
            $("#is_emrini_guncelle_main_modal").modal("hide");
        })

    </script>
    <?php
}
if ($islem == "mal_cinslerini_getir_modal") {
    ?>
    <div class="modal fade" id="mal_cinslerini_getir_modalin_modali" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 50%; max-width: 50%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="mal_cinslerini_getir_modalin_modali_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>MAL CİNSLERİ</div>
                        </div>
                        <div class="modal-body">
                            <table class="table table-sm table-bordered w-100 display nowrap"
                                   style="cursor:pointer;font-size: 13px;"
                                   id="fatura_cari_liste">
                                <thead>
                                <tr>
                                    <th id="click1">Mal Adı</th>
                                    <th>Mal Kodu</th>
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
            $("#mal_cinslerini_getir_modalin_modali").modal("show");

            setTimeout(function () {
                $("#click1").trigger("click");
            }, 500);

            var table = $('#fatura_cari_liste').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "mal_adi"},
                    {'data': "mal_kodu"}
                ],
                createdRow: function (row, data) {
                    $(row).addClass("mal_select");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                    $(row).attr("data-id", data.id);
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $.get("depo/controller/is_emri_controller/sql.php?islem=mal_cinslerini_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                }
            })

            $("body").off("click", ".mal_select").on("click", ".mal_select", function () {
                let mal_adi = $(this).find("td").eq(0).html();
                let id = $(this).attr("data-id");
                $(".mal_adi").attr("data-id", id);
                $(".mal_adi").val(mal_adi);
                $(".mal_adi_guncelle").attr("data-id", id);
                $(".mal_adi_guncelle").val(mal_adi);
                $("#mal_cinslerini_getir_modalin_modali").modal("hide");
            });
        });

        $("body").off("click", "#mal_cinslerini_getir_modalin_modali_kapat").on("click", "#mal_cinslerini_getir_modalin_modali_kapat", function () {
            $("#mal_cinslerini_getir_modalin_modali").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "yeni_mal_cinsi_ekle_modal") {
    ?>
    <div class="modal fade" id="mal_cinsi_tanimla" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 35%; max-width: 35%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="mal_cinsi_tanimla_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>MAL CİNSİ TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Mal Kodu</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="mal_kodu">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Mal Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="mal_adi">
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
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="mal_cinsi_tanimla_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="mal_cinsi_kaydet_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function () {
            $("#mal_cinsi_tanimla").modal("show");
        });

        $("body").off("click", "#mal_cinsi_tanimla_kapat").on("click", "#mal_cinsi_tanimla_kapat", function () {
            $("#mal_cinsi_tanimla").modal("hide");
        });

        $("body").off("click", "#mal_cinsi_kaydet_button").on("click", "#mal_cinsi_kaydet_button", function () {
            let mal_kodu = $("#mal_kodu").val();
            let mal_adi = $("#mal_adi").val();
            let aciklama = $("#aciklama").val();
            $.ajax({
                url: "depo/controller/tanim_controller/sql.php?islem=mal_cinsi_kaydet_sql",
                type: "POST",
                data: {
                    mal_adi: mal_adi,
                    mal_kodu: mal_kodu,
                    aciklama: aciklama
                },
                success: function (res) {
                    if (res == 1) {
                        Swal.fire(
                            "Başarılı!",
                            "Mal Cinsi Tanımlandı",
                            "success"
                        );
                        $("#mal_cinsi_tanimla").modal("hide");
                    } else if (res == 300) {
                        Swal.fire(
                            "Uyarı!",
                            "Bu Mal Kayıtlı",
                            "warning"
                        );
                    }
                }
            });
        });

    </script>
    <?php
}