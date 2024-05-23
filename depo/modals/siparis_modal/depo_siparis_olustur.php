<?php


$islem = $_GET["islem"];

if ($islem == "depo_siparis_olustur_modal_getir") {
    ?>
    <style>
        #depo_siparis_olustur_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="depo_siparis_olustur_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 75%; max-width: 75%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="depo_siparis_olustur_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>DEPO İHRACAT SİPARİŞİ</div>
                        </div>
                        <div class="modal-body">
                            <div class="mal_cinsleri_div"></div>
                            <div class="yeni_mal_cinsi_ekle"></div>
                            <div class="depo_stoklarini_getir_div"></div>
                            <div class="konteyner_irsaliye_firmalari_getir_div"></div>
                            <div class="col-12 row">
                                <div class="col-6">
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
                                            <label>Adres</label>
                                        </div>
                                        <div class="col-md-7">
                                            <textarea class="form-control form-control-sm" id="adres" rows="3"
                                                      style="resize: none" disabled></textarea>
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
                                            <input type="date" id="siparis_tarihi" class="form-control form-control-sm"
                                                   value="<?= date("Y-m-d") ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>CUT-OFF Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" id="cut_off_tarihi" class="form-control form-control-sm"
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
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="aciklama">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Alım Yeri</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="alim_yeri">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row no-gutters">
                                <div class="col">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;Hizmet Adı</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm hizmet_adi"
                                               placeholder="Hizmet Adı">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm" id="hizmetleri_getir_button"><i
                                                        class="fa fa-ellipsis-h"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fabrika
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
                                            <button class="btn btn-warning btn-sm" id="mal_cinslerini_getir_button"><i
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
                                    <input type="text" style="text-align: right" class="form-control form-control-sm"
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
                            <div class="col-12 mt-2 row">
                                <table class="table table-sm table-bordered w-100 display nowrap"
                                       style="cursor:pointer;font-size: 13px;"
                                       id="siparis_table_list">
                                    <thead>
                                    <tr>
                                        <th>Hizmet Adı</th>
                                        <th id="click12">Fabrika Ref.</th>
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
                            <div class="col-12 row">
                                <div class="col-4"></div>
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <div class="col-12 row no-gutters mt-2">
                                        <div class="col">
                                            <table class="table table-sm table-bordered w-80 display nowrap">
                                                <tr>
                                                    <th>#</th>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 2px">Toplam Yükleme Miktarı</th>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 2px">Toplam Sipariş</th>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 2px">Toplam Konteyner</th>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col">
                                            <table class="table table-sm table-bordered w-100 display nowrap">
                                                <thead>
                                                <tr>
                                                    <th>Toplamlar</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="yukleme_tot" style="text-align: right">0,00</td>
                                                </tr>
                                                <tr>
                                                    <td class="siparis_tot" style="text-align: right">0 ADET</td>
                                                </tr>
                                                <tr>
                                                    <td class="konteyner_tot" style="text-align: right">0 ADET</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="depo_siparis_olustur_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="depo_ihracat_siparisi_kaydet_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("body").off("click", "#musteri_firma_kodu_button").on("click", "#musteri_firma_kodu_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=musteri_firma_kodu", function (getModal) {
                $(".konteyner_irsaliye_firmalari_getir_div").html("");
                $(".konteyner_irsaliye_firmalari_getir_div").html(getModal);
            });
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

        var siparis_table = "";
        $(document).ready(function () {
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

            $.get("depo/controller/depo_controller/sql.php?islem=birimleri_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#birim_id").append("<option value='" + item.id + "'>" + item.birim_adi + "</option>");
                    })
                }
            })
            $("#depo_siparis_olustur_modal").modal("show");
            setTimeout(function () {
                $("#click12").trigger("click");
            }, 500);
            siparis_table = $('#siparis_table_list').DataTable({
                scrollY: '30vh',
                scrollX: true,
                searching: false,
                "info": false,
                createdRow: function (row) {
                    $(row).addClass("alis_urun_list");
                    $(row).find("td").css("text-align", "left");
                    $(row).find("td").eq(5).css("text-align", "right");
                    $(row).find("td").eq(7).css("text-align", "right");
                },
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
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

        $("body").off("click", ".ihracat_siparis_girisi_sil_button").on("click", ".ihracat_siparis_girisi_sil_button", function () {
            let row = $(this).closest("tr");
            siparis_table.row(row).remove().draw(false);
            if (siparis_table.rows().count() == 0) {
                $(".yukleme_tot").html("0,00");
                $(".konteyner_tot").html("0");
                $(".siparis_tot").html("0");
            } else {
                var yukleme_miktar_tot = 0
                var konteyner_sayisi_tot = 0
                var siparis_adet = 0
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
                }));
                $(".konteyner_tot").html(konteyner_sayisi_tot);
                $(".siparis_tot").html(siparis_adet);
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
            let row = siparis_table.row.add([hizmet_adi, fabrika_ref, ep_ref, mal_kodu, mal_adi, konteyner_sayisi, konteyner_tipi, yuk_miktari, birim_adi, "<button class='btn btn-danger btn-sm ihracat_siparis_girisi_sil_button'><i class='fa fa-trash'></i></button>"]).draw(false).node();
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

        $("body").off("click", "#depo_ihracat_siparisi_kaydet_button").on("click", "#depo_ihracat_siparisi_kaydet_button", function () {

            let gonderilecek_arr = [];
            $(".alis_urun_list").each(function () {
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
                gonderilecek_arr.push(newRow);
            });

            let cari_id = $("#firma_kodu").attr("data-id");
            let siparis_tarihi = $("#siparis_tarihi").val();
            let cut_off_tarihi = $("#cut_off_tarihi").val();
            let ardiyesiz_giris_tarihi = $("#ardiyesiz_giris_tarihi").val();
            let aciklama = $("#aciklama").val();
            let acenta = $("#acenta").val();
            let acenta_ref = $("#acenta_ref").val();
            let alim_yeri = $("#alim_yeri").val();

            if (cari_id == undefined || cari_id == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir Cari Belirtiniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "depo/controller/ihracat_controller/sql.php?islem=depo_konteyner_siparis_kaydet_sql",
                    type: "POST",
                    data: {
                        cari: cari_id,
                        siparis_tarihi: siparis_tarihi,
                        alim_yeri: alim_yeri,
                        cut_off_tarihi: cut_off_tarihi,
                        ardiyesiz_giris_tarihi: ardiyesiz_giris_tarihi,
                        aciklama: aciklama,
                        gonderilecek_arr: gonderilecek_arr,
                        acente_ref: acenta_ref,
                        acente: acenta
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı!",
                                "İhracat Siparişi Oluşturuldu",
                                "success"
                            );
                            $("#depo_siparis_olustur_modal").modal("hide");
                            $.get("depo/view/depo_siparis_islemleri.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/depo_siparis_islemleri.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }

        });

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

            $.get("depo/controller/ihracat_controller/sql.php?islem=mal_cinslerini_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                }
            })

            $("body").off("click", ".mal_select").on("click", ".mal_select", function () {
                let mal_adi = $(this).find("td").eq(0).html();
                let mal_kodu = $(this).find("td").eq(1).html();
                let id = $(this).attr("data-id");
                $(".mal_kodu").val(mal_kodu);
                $(".mal_kodu").attr("data-id", id);
                $(".mal_adi").val(mal_adi);
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
            $.get("depo/controller/ihracat_controller/sql.php?islem=hizmetleri_getir_sql", function (result) {
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
if ($islem == "depo_siparis_guncelle_modal_getir") {
    ?>
    <style>
        #depo_siparis_guncelle_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="depo_siparis_guncelle_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 75%; max-width: 75%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="depo_siparis_guncelle_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>DEPO İHRACAT SİPARİŞİ</div>
                        </div>
                        <div class="modal-body">
                            <div class="mal_cinsleri_div"></div>
                            <div class="yeni_mal_cinsi_ekle"></div>
                            <div class="depo_stoklarini_getir_div"></div>
                            <div class="konteyner_irsaliye_firmalari_getir_div"></div>
                            <div class="col-12 row">
                                <div class="col-6">
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
                                            <label>Adres</label>
                                        </div>
                                        <div class="col-md-7">
                                            <textarea class="form-control form-control-sm" id="adres" rows="3"
                                                      style="resize: none" disabled></textarea>
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
                                            <input type="date" id="siparis_tarihi" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>CUT-OFF Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" id="cut_off_tarihi" class="form-control form-control-sm">
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
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="aciklama">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Alım Yeri</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="alim_yeri">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row no-gutters">
                                <div class="col">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;Hizmet Adı</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm hizmet_adi"
                                               placeholder="Hizmet Adı">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm" id="hizmetleri_getir_button"><i
                                                        class="fa fa-ellipsis-h"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fabrika
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
                                            <button class="btn btn-warning btn-sm" id="mal_cinslerini_getir_button"><i
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
                                    <input type="text" style="text-align: right" class="form-control form-control-sm"
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
                            <div class="col-12 mt-2 row">
                                <table class="table table-sm table-bordered w-100 display nowrap"
                                       style="cursor:pointer;font-size: 13px;"
                                       id="siparis_table_list">
                                    <thead>
                                    <tr>
                                        <th>Hizmet Adı</th>
                                        <th id="click12">Fabrika Ref.</th>
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
                            <div class="col-12 row">
                                <div class="col-4"></div>
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <div class="col-12 row no-gutters mt-2">
                                        <div class="col">
                                            <table class="table table-sm table-bordered w-80 display nowrap">
                                                <tr>
                                                    <th>#</th>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 2px">Toplam Yükleme Miktarı</th>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 2px">Toplam Sipariş</th>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 2px">Toplam Konteyner</th>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col">
                                            <table class="table table-sm table-bordered w-100 display nowrap">
                                                <thead>
                                                <tr>
                                                    <th>Toplamlar</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="yukleme_tot" style="text-align: right">0,00</td>
                                                </tr>
                                                <tr>
                                                    <td class="siparis_tot" style="text-align: right">0 ADET</td>
                                                </tr>
                                                <tr>
                                                    <td class="konteyner_tot" style="text-align: right">0 ADET</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="depo_siparis_guncelle_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="depo_ihracat_siparisi_kaydet_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("body").off("click", "#musteri_firma_kodu_button").on("click", "#musteri_firma_kodu_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=musteri_firma_kodu", function (getModal) {
                $(".konteyner_irsaliye_firmalari_getir_div").html("");
                $(".konteyner_irsaliye_firmalari_getir_div").html(getModal);
            });
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

        var siparis_table = "";
        $(document).ready(function () {

            $.get("depo/controller/depo_controller/sql.php?islem=birimleri_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#birim_id").append("<option value='" + item.id + "'>" + item.birim_adi + "</option>");
                    })
                }
            });
            $("#depo_siparis_guncelle_modal").modal("show");
            setTimeout(function () {
                $("#click12").trigger("click");
            }, 500);
            siparis_table = $('#siparis_table_list').DataTable({
                scrollY: '30vh',
                scrollX: true,
                searching: false,
                "info": false,
                createdRow: function (row) {
                    $(row).addClass("alis_urun_list_guncelle");
                    $(row).find("td").css("text-align", "left");
                    $(row).find("td").eq(5).css("text-align", "right");
                    $(row).find("td").eq(7).css("text-align", "right");
                },
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            });

            $.get("depo/controller/ihracat_controller/sql.php?islem=guncellenecek_siparis_ana_bilgi", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#firma_kodu").val(item.cari_kodu);
                    $("#firma_kodu").attr("data-id", item.cari_id);
                    $("#firma_unvan").val(item.cari_adi);
                    $("#vergi_dairesi").val(item.vergi_dairesi);
                    $("#vergi_no").val(item.vergi_no);
                    $("#adres").val(item.adres);
                    $("#acenta_ref").val(item.acente_ref);
                    $("#acenta").val(item.acente);
                    let siparis_tarihi = item.siparis_tarihi;
                    siparis_tarihi = siparis_tarihi.split(" ");
                    let cutt_off_tarihi = item.cutt_off_tarihi;
                    cutt_off_tarihi = cutt_off_tarihi.split(" ");
                    let ardiyesiz_giris_tarihi = item.ardiyesiz_giris_tarihi;
                    ardiyesiz_giris_tarihi = ardiyesiz_giris_tarihi.split(" ");
                    $("#siparis_tarihi").val(siparis_tarihi[0]);
                    $("#cut_off_tarihi").val(cutt_off_tarihi[0]);
                    $("#ardiyesiz_giris_tarihi").val(ardiyesiz_giris_tarihi[0]);
                    $("#aciklama").val(item.aciklama);

                    $(".yukleme_tot").html(item.toplam_miktar);
                    $(".konteyner_tot").html(item.konteyner_sayisi);
                    $(".siparis_tot").html(item.siparis_adet);
                    $("#alim_yeri").val(item.alim_yeri);
                }
            })
        })

        $.get("depo/controller/ihracat_controller/sql.php?islem=siparis_ihracat_urun_bilgisi_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                json.forEach(function (item) {
                    let miktar = item.miktar;
                    miktar = parseFloat(miktar);
                    miktar = miktar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                    siparis_table.row.add([item.stok_adi, item.fabrika_ref, item.epro_ref, item.mal_kodu, item.urun_adi, item.konteyner_sayisi, item.konteyner_tipi, miktar, item.birim, item.islem]).draw(false);
                    $("#ep_ref").val(item.epro_ref);
                });
            }
        })

        $("body").off("click", "#depo_siparis_guncelle_modal_kapat").on("click", "#depo_siparis_guncelle_modal_kapat", function () {
            $("#depo_siparis_guncelle_modal").modal("hide");
        });

        $("body").off("click", "#mal_cinslerini_getir_button").on("click", "#mal_cinslerini_getir_button", function () {
            $.get("depo/modals/siparis_modal/depo_siparis_olustur.php?islem=mal_cinslerini_getir_modal", function (getModal) {
                $(".mal_cinsleri_div").html(getModal);
            })
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

        $("body").off("click", ".listedeki_urunu_sil_button").on("click", ".listedeki_urunu_sil_button", function () {
            let id = $(this).attr("data-id");
            let row = $(this).closest("tr");
            $.ajax({
                url: "depo/controller/ihracat_controller/sql.php?islem=ihracat_siparis_urunu_sil_sql",
                type: "POST",
                data: {
                    id: id
                },
                success: function (res) {
                    if (res == 1) {
                        siparis_table.row(row).remove().draw(false);
                        setTimeout(function () {
                            let yukleme_miktar_tot = 0;
                            let konteyner_sayisi_tot = 0;
                            let siparis_adet = 0;
                            $(".alis_urun_list_guncelle").each(function () {
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
                            }));
                            $(".konteyner_tot").html(konteyner_sayisi_tot);
                            $(".siparis_tot").html(siparis_adet);
                        }, 300);
                    } else {
                        Swal.fire(
                            "Oops...",
                            "Bilinmeyen Bir Hata Oluştu",
                            "error"
                        );
                    }
                }
            });
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
            let gmiktar = yuk_miktari.replace(/\./g, "").replace(",", ".");
            gmiktar = parseFloat(gmiktar);
            let birim_id = $("#birim_id").val();
            let birim_adi = $("#birim_id option:selected").text();
            $.ajax({
                url: "depo/controller/ihracat_controller/sql.php?islem=siparise_urun_ekle_sql",
                type: "POST",
                data: {
                    hizmet_id: hizmet_id,
                    fabrika_ref: fabrika_ref,
                    epro_ref: ep_ref,
                    mal_kodu: mal_kodu,
                    mal_id: mal_id,
                    konteyner_sayisi: konteyner_sayisi,
                    konteyner_tipi: konteyner_tipi,
                    urun_adi: mal_adi,
                    miktar: gmiktar,
                    birim_id: birim_id,
                    siparis_id: "<?=$_GET["id"]?>"
                },
                success: function (res) {
                    if (res != 1) {
                        let id = res.split(":");
                        id = id[1];
                        siparis_table.row.add([hizmet_adi, fabrika_ref, ep_ref, mal_kodu, mal_adi, konteyner_sayisi, konteyner_tipi, yuk_miktari, birim_adi, "<button class='btn btn-danger btn-sm listedeki_urunu_sil_button' data-id='" + id + "'><i class='fa fa-trash'></i></button>"]).draw(false);
                    } else {
                        Swal.fire(
                            "Oops...",
                            "Bilinmeyen Bir Hata Oluştu",
                            "error"
                        );
                    }
                }
            });


            let yukleme_miktar_tot = 0;
            let konteyner_sayisi_tot = 0;
            let siparis_adet = 0;

            setTimeout(function () {
                $(".alis_urun_list_guncelle").each(function () {
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
            }, 300);

            $(".hizmet_adi,#fabrika_ref,.mal_kodu,.mal_adi,#konteyner_sayisi,#konteyner_tipi,#yuk_miktari,#birim_id").val("");
            $(".hizmet_adi,.mal_kodu").attr("data-id", "");
        });

        $("body").off("click", "#depo_ihracat_siparisi_kaydet_button").on("click", "#depo_ihracat_siparisi_kaydet_button", function () {
            let cari_id = $("#firma_kodu").attr("data-id");
            let siparis_tarihi = $("#siparis_tarihi").val();
            let cut_off_tarihi = $("#cut_off_tarihi").val();
            let ardiyesiz_giris_tarihi = $("#ardiyesiz_giris_tarihi").val();
            let aciklama = $("#aciklama").val();
            let acenta = $("#acenta").val();
            let alim_yeri = $("#alim_yeri").val();
            let acenta_ref = $("#acenta_ref").val();

            if (cari_id == undefined || cari_id == "") {
                Swal.fire(
                    "Uyarı",
                    "Lütfen Bir Cari Belirtiniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "depo/controller/ihracat_controller/sql.php?islem=depo_konteyner_siparis_guncelle_sql",
                    type: "POST",
                    data: {
                        cari_id: cari_id,
                        siparis_tarihi: siparis_tarihi,
                        cutt_off_tarihi: cut_off_tarihi,
                        ardiyesiz_giris_tarihi: ardiyesiz_giris_tarihi,
                        aciklama: aciklama,
                        acente_ref: acenta_ref,
                        acente: acenta,
                        alim_yeri: alim_yeri,
                        id: "<?=$_GET["id"]?>"
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı!",
                                "İhracat Siparişi Güncellendi",
                                "success"
                            );
                            $("#depo_siparis_guncelle_modal").modal("hide");
                            $.get("depo/view/depo_siparis_islemleri.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/depo_siparis_islemleri.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }

        });

    </script>
    <?php
}