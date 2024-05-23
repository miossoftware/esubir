<?php

$islem = $_GET["islem"];

if ($islem == "ithalat_projesi_olsutur_modal") {
    ?>
    <style>
        #ithalat_is_emri_olustur_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="ithalat_is_emri_olustur_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 100%; max-width: 100%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="ithalat_is_emri_olustur_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>İŞ EMRİ OLUŞTUR</div>
                        </div>
                        <div class="modal-body">
                            <div class="col-12 row">
                                <div class="col-md-7">
                                    <div class="mal_cinsleri_div"></div>
                                    <div class="kayitli_is_emirlerini_getir_div"></div>
                                    <div class="kayitli_siparisler_div"></div>
                                    <div class="yeni_mal_cinsi_ekle"></div>
                                    <div class="depo_stoklarini_getir_div"></div>
                                    <div class="hizmetleri_getir_div"></div>
                                    <div class="konteyner_irsaliye_firmalari_getir_div"></div>
                                    <div class="col-12 row">
                                        <div class="col-6">
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <label>Cari Kodu</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-sm"
                                                               id="firma_kodu">
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
                                                    <input type="text" class="form-control form-control-sm"
                                                           id="firma_unvan"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <label>Vergi Dairesi</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control form-control-sm"
                                                           id="vergi_dairesi"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <label>Vergi No</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control form-control-sm"
                                                           id="vergi_no"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <label>Adres</label>
                                                </div>
                                                <div class="col-md-7">
                                            <textarea class="form-control form-control-sm" id="adres" rows="3"
                                                      style="resize: none" disabled></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <label>Ep. Referans</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-sm"
                                                               id="siparis_ep_ref">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-warning btn-sm"
                                                                    id="depo_siparisleri_getir_sql"><i
                                                                    class="fa fa-ellipsis-h"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <label>Acenta Referans</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" id="acenta_ref"
                                                           class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <label>Acenta</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" id="acenta"
                                                           class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <label>Sipariş Tarihi</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="date" id="siparis_tarihi"
                                                           class="form-control form-control-sm"
                                                           value="<?= date("Y-m-d") ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <label>CUT-OFF Tarihi</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="date" id="cut_off_tarihi"
                                                           class="form-control form-control-sm"
                                                           value="<?= date("Y-m-d") ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <label>Ardiyesiz Giriş Tarihi</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="date" class="form-control form-control-sm"
                                                           id="ardiyesiz_giris_tarihi"
                                                           value="<?= date("Y-m-d") ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <label>Alım Yeri</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control form-control-sm"
                                                           id="alim_yeri">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <label>Açıklama</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control form-control-sm"
                                                           id="aciklama">
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-12 row no-gutters">
                                        <div class="col">
                                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;Hiz.
                                                Adı</label>
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
                                        <div class="col">
                                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fab.
                                                Ref.</label>
                                            <input type="text" placeholder="Fabrika Referans" id="fabrika_ref"
                                                   class="form-control form-control-sm mx-4">
                                        </div>
                                        <div class="col mx-2">
                                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ep
                                                Ref.</label>
                                            <input type="text" placeholder="EPRO Referans" id="ep_ref" disabled
                                                   class="form-control form-control-sm mx-4">
                                        </div>
                                        <div class="col ">
                                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mal
                                                Cinsi</label>
                                            <div class="input-group mx-4">
                                                <input type="text" class="form-control form-control-sm mal_kodu"
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
                                        <div class="col mx-2">
                                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ürün</label>
                                            <input type="text" placeholder="Yüklenecek Ürün"
                                                   id="mal_adi"
                                                   class="form-control form-control-sm mx-4 mal_adi">
                                        </div>
                                        <div class="col mx-2">
                                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kont.
                                                Sayı</label>
                                            <input type="number" placeholder="Konteyner Sayısı" id="konteyner_sayisi"
                                                   style="text-align: right"
                                                   class="form-control form-control-sm mx-4">
                                        </div>
                                        <div class="col mx-4">
                                            <label style="font-weight: bold;font-size: 10px">Kont. Tipi</label>
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
                                        <div class="col">
                                            <label style="font-weight: bold;font-size: 10px">&nbsp;Miktar</label>
                                            <input type="text" style="text-align: right"
                                                   class="form-control form-control-sm"
                                                   placeholder="Yük Miktarı"
                                                   id="yuk_miktari">
                                        </div>
                                        <div class="col">
                                            <label style="font-weight: bold;font-size: 10px">&nbsp;Birim</label>
                                            <select class="custom-select custom-select-sm" id="birim_id">
                                                <option value="">Birim Seçiniz...</option>
                                            </select>
                                        </div>
                                        <div class="col mx-2">
                                            <button class="btn btn-success btn-sm mt-4" id="depo_ihracat_urun_ekle"><i
                                                    class="fa fa-plus"></i> Ekle
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-12 row mt-2">
                                        <label style="font-weight: bold;font-size: 13px;color: red">&nbsp;İşleme Devam
                                            Etmek İçin Lütfen Aşağıdaki Tablodan Bir Kayıt Seçiniz...</label>
                                        <table class="table table-sm table-bordered w-100 display nowrap"
                                               style="cursor:pointer;font-size: 13px;"
                                               id="is_emri_table_list">
                                            <thead>
                                            <tr>
                                                <th>Hizmet Adı</th>
                                                <th id="click123">Fabrika Ref.</th>
                                                <th>Ep Ref.</th>
                                                <th>Mal Cinsi</th>
                                                <th>Ürün</th>
                                                <th>Konteyner Sayısı</th>
                                                <th>Konteyner Tipi</th>
                                                <th>Miktar</th>
                                                <th>Birim</th>
                                                <th>İşlem</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <button class="btn btn-primary btn-sm" id="hizmet_sec"><i
                                            class="fa fa-check"></i> HİZMET SEÇ
                                    </button>
                                    <button class="btn btn-secondary btn-sm" id="kayitli_is"><i
                                            class="fa fa-file"></i> KAYITLI İŞ
                                        EMİRLERİ
                                    </button>
                                    <button class="btn btn-success btn-sm" id="kayitli_is_emirlerine_ekle"><i
                                            class="fa fa-plus"></i> KAYITLI İŞ
                                        EMİRLERİNE EKLE
                                    </button>
                                    <table class="table table-sm table-bordered w-100 display nowrap"
                                           style="cursor:pointer;font-size: 13px;"
                                           id="is_emri_kalemler_table">
                                        <thead>
                                        <tr>
                                            <th id="click12">Stok</th>
                                            <th>Birim</th>
                                            <th>Sefer Sayısı</th>
                                            <th style="width: 0% !important;">İşlem</th>
                                        </tr>
                                        </thead>
                                    </table>
                                    <div class="col-12 row mt-5">
                                        <label style="font-weight: bold;font-size: 13px;color: red">&nbsp;20 LİK
                                            KONTEYNERLERİNİZİN BOŞ TAŞIMA SEFER SAYISINI KONTROL EDİNİZ...</label>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <div class="col-md-4">
                                                    <label>Açıklama</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <textarea class="form-control form-control-sm" id="ana_aciklama"
                                                              style="resize: none" rows="4"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="ithalat_is_emri_olustur_modal_kapat"><i
                                    class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="is_emri_olutur_kaydet"><i class="fa fa-plus"></i>
                                Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var is_emri_table = "";
        var is_emri_kalemler_table = "";
        $.get("depo/controller/depo_controller/sql.php?islem=birimleri_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                json.forEach(function (item) {
                    $("#birim_id").append("<option value='" + item.id + "'>" + item.birim_adi + "</option>");
                })
            }
        });

        $(document).ready(function () {
            $("#ithalat_is_emri_olustur_modal").modal("show");
            is_emri_table = $('#is_emri_table_list').DataTable({
                scrollY: '30vh',
                scrollX: true,
                searching: false,
                "info": false,
                createdRow: function (row) {
                    $(row).addClass("depo_is_emir_siparisten_gelen_kalemler");
                    $(row).find("td").css("text-align", "left");
                    $(row).find("td").eq(5).css("text-align", "right");
                    $(row).find("td").eq(7).css("text-align", "right");
                },
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            });
            $.get("depo/controller/ihracat_controller/sql.php?islem=son_epro_referans_sql", function (res) {
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
                    $("#ep_ref").val("DEPO" + siparis_no);
                } else {
                    var tarih = new Date();
                    var yil = tarih.getFullYear();
                    var ay = tarih.getMonth();
                    ay = ay + 1;
                    ay = ay.toString().padStart(2, '0');
                    let basilacak = yil + "" + ay + "0001";
                    $("#ep_ref").val("DEPO" + basilacak);

                }
            })
            setTimeout(function () {
                $("#click123").trigger("click");
                $("#click12").trigger("click");
            }, 500);
            is_emri_kalemler_table = $('#is_emri_kalemler_table').DataTable({
                scrollY: '30vh',
                scrollX: true,
                searching: false,
                createdRow: function (row) {
                    $(row).addClass("alis_urun_list");
                    $(row).find("td").css("text-align", "left");
                    $(row).find("td").eq(3).css("text-align", "right");
                },
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            });
        });

        $("body").off("click", "#is_emri_olutur_kaydet").on("click", "#is_emri_olutur_kaydet", function () {
            let gonderilecek_siparis_arr = [];
            $(".depo_is_emir_siparisten_gelen_kalemler").each(function () {
                let hizmet_id = $(this).attr("hizmet_id");
                let fabrika_ref = $(this).find("td").eq(1).text();
                let epro_ref = $(this).find("td").eq(2).text();
                let mal_id = $(this).attr("mal_id");
                let mal_kodu = $(this).find("td").eq(3).text();
                let urun_adi = $(this).find("td").eq(4).text();
                let konteyner_sayisi = $(this).find("td").eq(5).text();
                let konteyner_tipi = $(this).find("td").eq(6).text();
                let miktar = $(this).find("td").eq(7).text();
                miktar = miktar.replace(/\./g, "").replace(",", ".");
                miktar = parseFloat(miktar);
                let birim_id = $(this).attr("birim_id");

                let newRow = {
                    'hizmet_id': hizmet_id,
                    'fabrika_ref': fabrika_ref,
                    "epro_ref": epro_ref,
                    "mal_id": mal_id,
                    "mal_kodu": mal_kodu,
                    "urun_adi": urun_adi,
                    "konteyner_sayisi": konteyner_sayisi,
                    "konteyner_tipi": konteyner_tipi,
                    "miktar": miktar,
                    "birim_id": birim_id
                };
                gonderilecek_siparis_arr.push(newRow);
            });

            let gonderilecek_islem_arr = [];

            $(".alis_urun_list").each(function () {
                let stok_id = $(this).attr("hizmet_id");
                let birim_id = $(this).find("td:eq(1) option:selected").val();
                let sefer_sayisi = $(this).find("td:eq(2) input").val();

                let newRow = {
                    stok_id: stok_id,
                    birim_id: birim_id,
                    sefer_sayisi: sefer_sayisi
                };
                gonderilecek_islem_arr.push(newRow);
            });

            let cari_id = $("#firma_kodu").attr("data-id");
            let siparis_tarihi = $("#siparis_tarihi").val();
            let cut_off_tarihi = $("#cut_off_tarihi").val();
            let ardiyesiz_giris_tarihi = $("#ardiyesiz_giris_tarihi").val();
            let aciklama = $("#aciklama").val();
            let acenta = $("#acenta").val();
            let acenta_ref = $("#acenta_ref").val();
            let alim_yeri = $("#alim_yeri").val();
            let ana_aciklama = $("#ana_aciklama").val();
            let siparis_id = $("#siparis_ep_ref").attr("data-id");

            if (cari_id == undefined || cari_id == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir Cari Belirtiniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "depo/controller/ihracat_controller/sql.php?islem=is_emri_olustur_ve_kaydet_sql",
                    type: "POST",
                    data: {
                        cari_id: cari_id,
                        siparis_tarihi: siparis_tarihi,
                        cut_off_tarihi: cut_off_tarihi,
                        ardiyesiz_giris_tarihi: ardiyesiz_giris_tarihi,
                        aciklama: aciklama,
                        acenta: acenta,
                        acenta_ref: acenta_ref,
                        alim_yeri: alim_yeri,
                        siparis_id: siparis_id,
                        ana_aciklama: ana_aciklama,
                        gonderilecek_islem_arr: gonderilecek_islem_arr,
                        gonderilecek_siparis_arr: gonderilecek_siparis_arr
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı!",
                                "İş Emri Başarı İle Oluşturuldu",
                                "success"
                            );
                            $("#ithalat_is_emri_olustur_modal").modal("hide");
                            $.get("depo/view/depo_konteyner_giris.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/depo_konteyner_giris.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                })
            }
        });

        $("body").off("click", "#depo_ihracat_urun_ekle").on("click", "#depo_ihracat_urun_ekle", function () {
            let hizmet_adi = $(".hizmet_adi").val();
            let hizmet_id = $(".hizmet_adi").attr("data-id");
            let fabrika_ref = $("#fabrika_ref").val();
            let ep_ref = $("#ep_ref").val();
            let mal_kodu = $(".mal_kodu").val();
            let mal_id = $(".mal_kodu").attr("data-id");
            let mal_adi = $(".mal_adi").val();
            let konteyner_sayisi = $("#konteyner_sayisi").val();
            let konteyner_tipi = $("#konteyner_tipi").val();
            let yuk_miktari = $("#yuk_miktari").val();
            let birim_id = $("#birim_id").val();
            let birim_adi = $("#birim_id option:selected").text();
            let row = is_emri_table.row.add([hizmet_adi, fabrika_ref, ep_ref, mal_kodu, mal_adi, konteyner_sayisi, konteyner_tipi, yuk_miktari, birim_adi, "<button class='btn btn-danger btn-sm ihracat_siparis_girisi_sil_button'><i class='fa fa-trash'></i></button>"]).draw(false).node();
            $(row).attr("birim_id", birim_id);
            $(row).attr("mal_id", mal_id);
            $(row).attr("hizmet_id", hizmet_id);

            let yukleme_miktar_tot = 0;
            let konteyner_sayisi_tot = 0;
            let siparis_adet = 0;

            $(".alis_urun_list").each(function () {
                let miktar = $(this).find("td").eq(7).html();
                miktar = miktar.replace(/\./g, "").replace(",", ".");
                miktar = parseFloat(miktar);

                let konteyner_sayisi = $(this).find("td").eq(5).html();
                konteyner_sayisi = konteyner_sayisi.replace(/\./g, "").replace(",", ".");
                konteyner_sayisi = parseFloat(konteyner_sayisi);

                yukleme_miktar_tot += miktar;
                konteyner_sayisi_tot += konteyner_sayisi;
                siparis_adet += 1;
            });
            $(".yukleme_tot").html(yukleme_miktar_tot.toLocaleString("tr-TR", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }) + " " + birim_adi);
            $(".konteyner_tot").html(konteyner_sayisi_tot);
            $(".siparis_tot").html(siparis_adet);

            $(".hizmet_adi,#fabrika_ref,.mal_kodu,.mal_adi,#konteyner_sayisi,#konteyner_tipi,#yuk_miktari,#birim_id").val("");
            $(".hizmet_adi,.mal_kodu").attr("data-id", "");
        });

        $("body").off("click", ".ihracat_siparis_girisi_sil_button").on("click", ".ihracat_siparis_girisi_sil_button", function () {
            let row = $(this).closest("tr");
            is_emri_table.row(row).remove().draw(false);
        });

        $("body").off("click", ".is_emri_hizmet_sil_button").on("click", ".is_emri_hizmet_sil_button", function () {
            let row = $(this).closest("tr");
            is_emri_kalemler_table.row(row).remove().draw(false);
        });

        $("body").off("click", ".depo_is_emir_siparisten_gelen_kalemler").on("click", ".depo_is_emir_siparisten_gelen_kalemler", function () {
            $("#kayitli_is").prop("disabled", false);
            $("#hizmet_sec").prop("disabled", false);
        });

        $("body").off("click", "#kayitli_is_emirlerine_ekle").on("click", "#kayitli_is_emirlerine_ekle", function () {

            let gidecek_arr = [];

            $(".alis_urun_list").each(function () {
                let hizmet_id = $(this).attr("hizmet_id");
                let birim_id = $(this).find("td:eq(1) option:selected").val();
                let sefer_sayisi = $(this).find("td:eq(2) input").val();

                let newRow = {
                    stok_id: hizmet_id,
                    birim_id: birim_id,
                    sefer_sayisi: sefer_sayisi
                };
                gidecek_arr.push(newRow);
            });

            if (gidecek_arr.length == 0) {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Tabloya En Az Bir Kayıt Giriniz...",
                    "warning"
                )
            } else {
                Swal.fire({
                    title: 'Kayıtlı İş Emri Ekle',
                    input: 'text',
                    inputPlaceholder: 'İş Emri Adı',
                    showCancelButton: true,
                    confirmButtonText: 'Tamam',
                    cancelButtonText: 'İptal',
                    allowOutsideClick: false,
                    inputValidator: (value) => {
                        if (!value) {
                            return 'İş Emri Adı Boş Bırakılamaz';
                        }
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        const delete_detail = result.value;
                        $.ajax({
                            url: "depo/controller/ihracat_controller/sql.php?islem=kayitli_is_emri_ekle_sql",
                            type: "POST",
                            data: {
                                gidecek_arr: gidecek_arr,
                                is_emri_adi: delete_detail
                            },
                            success: function (result) {
                                if (result != 2) {
                                    if (result == 300) {
                                        Swal.fire(
                                            'Uyarı!',
                                            'Bu İş Emri Zaten Kayıtlı',
                                            'warning'
                                        );
                                    } else {
                                        Swal.fire(
                                            "Başarılı",
                                            "İş Emri Başarı İle Kaydedildi",
                                            "success"
                                        );
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
            }
        });

        $("body").off("click", "#hizmet_sec").on("click", "#hizmet_sec", function () {
            let konteyner_sayisi = 0;
            let konteyner_tipi = 0;
            $(".depo_is_emir_siparisten_gelen_kalemler").each(function () {
                if ($(this).hasClass("selected")) {
                    let data1 = $(this).find("td:eq(5)").text();
                    let data2 = $(this).find("td:eq(6)").text();
                    konteyner_sayisi = parseFloat(data1);
                    konteyner_tipi = parseFloat(data2);
                }
            });
            $.get("depo/modals/ihracat_modal/modal.php?islem=hizmetleri_getir_sql", {
                konteyner_sayisi: konteyner_sayisi,
                konteyner_tipi: konteyner_tipi
            }, function (getModal) {
                $(".hizmetleri_getir_div").html(getModal);
            })
        });

        $("body").off("click", "#kayitli_is").on("click", "#kayitli_is", function () {
            $.get("depo/modals/ihracat_modal/modal.php?islem=kayitli_ihracat_is_emirlerini_getir_modal", function (getModal) {
                $(".kayitli_is_emirlerini_getir_div").html(getModal);
            });
        })

        $("body").off("click", "#depo_siparis_olustur_modal_kapat").on("click", "#depo_siparis_olustur_modal_kapat", function () {
            $("#depo_siparis_olustur_modal").modal("hide");
        });

        $("body").off("click", "#mal_cinslerini_getir_button").on("click", "#mal_cinslerini_getir_button", function () {
            $.get("depo/modals/siparis_modal/depo_siparis_olustur.php?islem=mal_cinslerini_getir_modal", function (getModal) {
                $(".mal_cinsleri_div").html(getModal);
            })
        });
        $("body").off("click", "#depo_siparisleri_getir_sql").on("click", "#depo_siparisleri_getir_sql", function () {
            let cari_id = $("#firma_kodu").attr("data-id");
            if (cari_id == undefined || cari_id == "") {
                Swal.fire(
                    "Uyarı",
                    "Cari Hesap Seçmediniz...",
                    "warning"
                )
            } else {
                $.get("depo/modals/ihracat_modal/modal.php?islem=kayitli_siparisleri_getir_modal", {cari_id: cari_id}, function (getModal) {
                    $(".kayitli_siparisler_div").html(getModal);
                });
            }
        });
        $("body").off("click", "#mal_cinsi_ekle_button").on("click", "#mal_cinsi_ekle_button", function () {
            $.get("depo/modals/siparis_modal/depo_siparis_olustur.php?islem=yeni_mal_cinsi_ekle_modal", function (getModal) {
                $(".yeni_mal_cinsi_ekle").html(getModal);
            })
        });
        $("body").off("click", "#hizmetleri_getir_button").on("click", "#hizmetleri_getir_button", function () {
            $.get("depo/modals/siparis_modal/depo_siparis_olustur.php?islem=depo_stoklarini_getir_modal", function (getModal) {
                $(".depo_stoklarini_getir_div").html(getModal);
            })
        });
        $("body").off("click", "#musteri_firma_kodu_button").on("click", "#musteri_firma_kodu_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=musteri_firma_kodu", function (getModal) {
                $(".konteyner_irsaliye_firmalari_getir_div").html(getModal);
            });
        });

        $("body").off("click", "#ithalat_is_emri_olustur_modal_kapat").on("click", "#ithalat_is_emri_olustur_modal_kapat", function () {
            $("#ithalat_is_emri_olustur_modal").modal("hide");
        });

    </script>
    <?php
}