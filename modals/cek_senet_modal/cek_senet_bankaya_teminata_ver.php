<?php

$islem = $_GET["islem"];

if ($islem == "cek_senet_bankaya_teminata_ver_modal") {
    ?>
    <div class="modal fade" id="cek_senet_banka_teminat_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 75%; max-width: 75%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="cek_senet_vazgec_main"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ALINAN ÇEK BANKAYA
                                TEMİNATA VER
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="yeni_cek_girisi"></div>
                            <div class="cek_senet_icin_banka_getir"></div>
                            <div class="cek_guncelleme_modali"></div>
                            <div class="col-12 mx-1 row no-gutteras" style="border: 1px solid #000">
                                <div class="col-6 mt-2">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Banka Kodu</label>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm "
                                                       id="cek_senet_getir_bankaid">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm cek_senet_icin_banka_modali"><i
                                                            class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Banka Adı</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control form-control-sm" disabled
                                                   id="banka_adi_cek_senet">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Banka Adres</label>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea disabled style="resize: none" class="form-control form-control-sm"
                                                      id="banka_adres" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Tarih</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="date" value="<?= date("Y-m-d") ?>" id="cek_senet_tarih"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3 mt-1">
                                            Döviz Türü
                                        </div>
                                        <div class="col-md-8 row no-gutters">
                                            <div class="col-md">
                                                <select class="custom-select custom-select-sm doviz_tur_cek_senet"
                                                        id="doviz_tur">
                                                    <option value="">Seçiniz...</option>
                                                    <option selected="" value="TL">TL</option>
                                                    <option id="usd_bas" value="USD">USD</option>
                                                    <option id="eur_bas" value="EURO">EURO</option>
                                                    <option id="gbp_bas" value="GBP">GBP</option>
                                                </select>
                                            </div>
                                            <div class="col-md">
                                                <input type="text"
                                                       class="form-control form-control-sm doviz_kuru_cek_senet"
                                                       id="doviz_kuru" value="1.00" placeholder="Döviz Karşılığı">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mt-2">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Belge No</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="cek_senet_belge_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Ort. Vade</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input disabled type="date" class="form-control form-control-sm"
                                                   id="ort_vade">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Ort. Gün</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input disabled type="text" id="ort_gun"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Mutabakat</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control form-control-sm" id="mutabakat">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Özel Kod 1</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="ozel_kod1_ceksenet">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Özel Kod 2</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="ozel_kod2_ceksenet">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-md-8 ">
                                            <textarea class="form-control form-control-sm" id="cek_senet_aciklama"
                                                      rows="2"
                                                      style="resize: none"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row">
                                <table class="table table-sm table-bordered w-100 display nowrap"
                                       style="cursor:pointer;font-size: 13px;"
                                       id="cek_senet_bankaya_teminata_verme">
                                    <thead>
                                    <tr>
                                        <th id="click_me">Belge No</th>
                                        <th>Vadesi</th>
                                        <th>Asıl Borçlusu</th>
                                        <th>Ciro Edilen</th>
                                        <th>Tutarı</th>
                                        <th>Keşide Yeri</th>
                                        <th>Bankası</th>
                                        <th>Şubesi</th>
                                        <th>Hesap No</th>
                                        <th>Özel Kod</th>
                                        <th>Son Durumu</th>
                                        <th>Bizim</th>
                                        <th>İşlem</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-danger btn-sm" id="cek_senet_vazgec_main"><i
                                        class="fa fa-close"></i> Vazgeç
                                </button>
                                <button class="btn btn-success btn-sm" id="alinan_cek_tahsile_ver_onayla"><i
                                        class="fa fa-check"></i>Kaydet
                                </button>
                                <button class="btn btn-info btn-sm" id="bankaya_teminat_icin_liste_getir"><i
                                        class="fa fa-list"></i> Çek Listesi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var tahsil_table = "";
        $("body").off("click",".cek_senet_icin_banka_modali").on("click",".cek_senet_icin_banka_modali",function (){
            $.get("modals/cek_senet_modal/another_modal.php?islem=banka_listesi_getir_modal",function (getModal){
                $(".cek_senet_icin_banka_getir").html("");
                $(".cek_senet_icin_banka_getir").html(getModal);
            })
        })
        $("body").off("click","#cek_senet_vazgec_main").on("click","#cek_senet_vazgec_main",function (){
            $("#cek_senet_banka_teminat_modal").modal("hide");
        });

        $(document).ready(function () {
            $("#cek_senet_banka_teminat_modal").modal("show");
            jQuery.extend(jQuery.fn.dataTableExt.oSort, {
                "date-eu-pre": function (dateString) {
                    var parts = dateString.split('/');
                    return Date.parse(parts[2] + '/' + parts[1] + '/' + parts[0]) || 0;
                },

                "date-eu-asc": function (a, b) {
                    return ((a < b) ? -1 : ((a > b) ? 1 : 0));
                },

                "date-eu-desc": function (a, b) {
                    return ((a < b) ? 1 : ((a > b) ? -1 : 0));
                }
            });
            tahsil_table = $('#cek_senet_bankaya_teminata_verme').DataTable({
                scrollY: '30vh',
                scrollX: true,
                "info": false,
                bAutoWidth: false,
                "order": [[0, 'desc']],
                searching: false,
                columnDefs: [
                    {targets: 0, type: "date-eu"}
                ],
                createdRow: function (row) {
                    $(row).addClass("tahsil_edilecek_cek_senetler");
                },
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
            })
        })

        $("body").off("click",".cek_cikis_tahsil_iptal_et").on("click",".cek_cikis_tahsil_iptal_et",function (){
            var row = $(this).closest('tr');
            tahsil_table.row(row).remove().draw();
        })

        $("body").off("click", "#bankaya_teminat_icin_liste_getir").on("click", "#bankaya_teminat_icin_liste_getir", function () {
            let banka_id = $("#cek_senet_getir_bankaid").attr("data-id");
            if (banka_id == "" || banka_id == undefined) {
                Swal.fire(
                    'Uyarı!',
                    'Lütfen Bir Banka Seçiniz...',
                    'warning'
                );
            } else {
                $.get("modals/cek_senet_modal/cek_senet_bankaya_teminata_ver.php?islem=cekler_seneter_listesi", function (getModal) {
                    $(".yeni_cek_girisi").html("");
                    $(".yeni_cek_girisi").html(getModal);
                })
            }
        })

        $("#cek_senet_getir_bankaid").keyup(function () {
            let val = $(this).val();
            $.get("controller/cek_senet_controller/sql.php?islem=banka_kodu_bilgileri_getir_sql", {banka_kodu: val}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#cek_senet_getir_bankaid").attr("data-id", item.id);
                    $("#cek_senet_getir_bankaid").val(item.banka_kodu);
                    $("#banka_adi_cek_senet").val(item.banka_adi);
                    $("#banka_adres").val(item.adres);
                } else {
                    $("#cek_senet_getir_bankaid").attr("data-id", "");
                    $("#banka_adi_cek_senet").val("");
                    $("#banka_adres").val("");
                }
            })
        })

        $("body").off("click","#alinan_cek_tahsile_ver_onayla").on("click","#alinan_cek_tahsile_ver_onayla",function (){
            var arr = [];
            $(".tahsil_edilecek_cek_senetler").each(function () {
                let islem = $(this).attr("data-name");
                if (islem == "bankaya_teminata_verme") {
                    let alinan_cekid = $(this).attr("alinan_cekid");
                    let belge_no = $(this).find("td").eq(0).text();
                    let vade_tarihi = $(this).find("td").eq(1).text();
                    var parcalar = vade_tarihi.split('/');
                    var yeniTarih2 = parcalar[2] + '-' + parcalar[1] + '-' + parcalar[0];
                    let asil_borclu = $(this).find("td").eq(2).text();
                    let ciro_edilen = $(this).find("td").eq(3).text();
                    let tutar = $(this).find("td").eq(4).text();
                    tutar = tutar.replace(/\./g, "").replace(",", ".");
                    tutar = parseFloat(tutar);
                    let keside_yeri = $(this).find("td").eq(5).text();
                    let banka_adi = $(this).find("td").eq(6).text();
                    let sube_adi = $(this).find("td").eq(7).text();
                    let hesap_no = $(this).find("td").eq(8).text();
                    let ozel_kod = $(this).find("td").eq(9).text();
                    let durumu = 2;
                    let bizim = $(this).find("td").eq(11).text();
                    if (bizim == "MÜŞTERİNİN") {
                        bizim = 2;
                    } else {
                        bizim = 1;
                    }
                    arr.push(
                        {
                            islem: islem,
                            seri_no: belge_no,
                            alinan_cekid: alinan_cekid,
                            vade_tarih: yeniTarih2,
                            asil_borclu: asil_borclu,
                            ciro_edilmis: ciro_edilen,
                            girilen_tutar: tutar,
                            keside_yeri: keside_yeri,
                            banka_adi: banka_adi,
                            banka_sube: sube_adi,
                            hesap_no: hesap_no,
                            ozel_kod: ozel_kod,
                            son_durum: durumu,
                            bizim: bizim
                        }
                    );
                } else {

                }
            })
            let cari_id = $("#cek_senet_getir_bankaid").attr("data-id");
            let tarih = $("#cek_senet_tarih").val();
            let belge_no = $("#cek_senet_belge_no").val();
            let doviz_kuru = $(".doviz_kuru_cek_senet").val();
            let doviz_tur = $(".doviz_tur_cek_senet").val();
            let ort_vade = $("#ort_vade").val();
            let ort_gun = $("#ort_gun").val();
            let mutabakat = $("#mutabakat").val();
            let ozel_kod1 = $("#ozel_kod1_ceksenet").val();
            let ozel_kod2 = $("#ozel_kod2_ceksenet").val();
            let aciklama = $("#cek_senet_aciklama").val();
            $.ajax({
                url: "controller/cek_senet_controller/sql.php?islem=cek_senet_cikis_kaydet_sql",
                type: "POST",
                data: {
                    banka_id: cari_id,
                    tarih: tarih,
                    belge_no: belge_no,
                    doviz_kuru: doviz_kuru,
                    doviz_tur: doviz_tur,
                    ort_vade: ort_vade,
                    ort_gun: ort_gun,
                    mutabakat: mutabakat,
                    ozel_kod1: ozel_kod1,
                    ozel_kod2: ozel_kod2,
                    aciklama: aciklama,
                    arr: arr
                },
                success: function (result) {
                    if (result == 1) {
                        $("#cek_senet_banka_teminat_modal").modal("hide");
                        $.get("view/cek_senet_cikis_bordrosu.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                        $.get("view/cek_senet_cikis_bordrosu.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                    } else {
                        $("#cek_senet_banka_teminat_modal").modal("hide");
                    }
                }
            })
        });

    </script>
    <?php
}
if ($islem == "cekler_seneter_listesi") {
    ?>
    <div class="modal fade" id="cariye_ait_girilen_cekleri_getir_teminat"

         data-bs-keyboard="false" role="dialog">

        <div class="modal-dialog"

             style="width: 55%; max-width: 55%;">

            <div class="modal-content">

                <div class="modal-header text-white p-2" style="font-weight: bold">TÜM ÇEKLER

                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"

                            aria-label="Close"></button>

                </div>

                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="carinini_cek_ve_senetleri_listesi">
                            <thead>
                            <tr>
                                <th id="click124">Seç</th>
                                <th>Belge No</th>
                                <th>Vadesi</th>
                                <th>Asıl Borçlusu</th>
                                <th>Ciro Edilen</th>
                                <th>Tutarı</th>
                                <th>Keşide Yeri</th>
                                <th>Bankası</th>
                                <th>Şubesi</th>
                                <th>Hesap No</th>
                                <th>Özel Kodu</th>
                                <th>Durumu</th>
                                <th>Bizim</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-sm" id="modal_kapat"><i class="fa fa-close"></i> Kapat
                    </button>
                    <button class="btn btn-success btn-sm" id="secilen_cekler_ve_senetleri_aktar"><i

                                class="fa fa-download"></i> Seçilenleri Aktar

                    </button>

                </div>

            </div>

        </div>

    </div>
    <script>
        var cek_ve_senetler_table = "";

        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#cariye_ait_girilen_cekleri_getir_teminat").modal("hide");
        })
        $(document).ready(function () {
            setTimeout(function () {
                $("#click124").trigger("click");
            }, 500);
            $("#cariye_ait_girilen_cekleri_getir_teminat").modal("show");
            cek_ve_senetler_table = $('#carinini_cek_ve_senetleri_listesi').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                searching: false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row) {
                    $(row).addClass("cariye_ait_cekler_ve_senetler_selected");
                }
            })

            $.get("controller/cek_senet_controller/sql.php?islem=cekler_ve_senetleri_cikis_banka_icin_getir_sql", function (result) {
                if (result != 2) {
                    let json = JSON.parse(result);
                    json.forEach(function (item) {
                        let son_durum = "";
                        if (item.son_durum == 1) {
                            son_durum = "PORTFÖYDE";
                        } else if (item.son_durum == 2) {
                            son_durum = "CİRO EDİLDİ";
                        } else if (item.son_durum == 3) {
                            son_durum = "TAHSİL EDİLDİ";
                        } else {
                            son_durum = "ÖDENDİ";
                        }
                        let bizim_mi = "";
                        if (item.bizim == 1) {
                            bizim_mi = "BİZİM";
                        } else {
                            bizim_mi = "MÜŞTERİNİN";
                        }
                        let tutar = item.girilen_tutar;
                        tutar = parseFloat(tutar);

                        let vade_tarihi = item.vade_tarih;
                        vade_tarihi = vade_tarihi.split(" ");
                        tutar = tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                        vade_tarihi = vade_tarihi[0];
                        vade_tarihi = vade_tarihi.split("-");
                        let gun = vade_tarihi[2];
                        let ay = vade_tarihi[1];
                        let yil = vade_tarihi[0];
                        let arr = [gun, ay, yil];
                        vade_tarihi = arr.join("/");
                        let new_row = cek_ve_senetler_table.row.add(["<input type='checkbox' class='col-9 secilecek_cek' />", item.seri_no, vade_tarihi, item.asil_borclu, item.ciro_edilmis, tutar, item.keside_yeri, item.banka_adi, item.banka_sube, item.hesap_no, item.ozel_kod, son_durum, bizim_mi]).draw(false).node();
                        $(new_row).attr("alinan_cekid", item.alinan_cekid);
                    })
                }
            })
        })

        $("body").off("click", ".secilecek_cek").on("click", ".secilecek_cek", function () {
            let this_checked = $(this).closest("tr");
            if ($(this).is(':checked')) {
                this_checked.addClass("cek_secildi")
            } else {
                this_checked.removeClass("cek_secildi")
            }
        })

        $("body").off("click", "#secilen_cekler_ve_senetleri_aktar").on("click", "#secilen_cekler_ve_senetleri_aktar", function () {
            let arr = [];
            let toplam_tutar_cek = 0;
            let toplam_ana_tutar_cek = 0;
            let toplam_tutar_senet = 0;
            let toplam_ana_tutar_senet = 0;
            $(".cariye_ait_cekler_ve_senetler_selected").each(function () {
                if ($(this).hasClass("cek_secildi")) {
                    let id = $(this).attr("alinan_cekid");
                    let belge_no = $(this).find("td").eq(1).text();
                    let vade_tarihi = $(this).find("td").eq(2).text();
                    let vade_tarihi2 = $(this).find("td").eq(2).text();
                    let asil_borclu = $(this).find("td").eq(3).text();
                    let ciro_edilen = $(this).find("td").eq(4).text();
                    let tutar = $(this).find("td").eq(5).text();
                    tutar = tutar.replace(/\./g, "").replace(",", ".");
                    tutar = parseFloat(tutar);
                    var parcalar = vade_tarihi2.split('/');
                    var yeniTarih = parcalar[2] + '-' + parcalar[1] + '-' + parcalar[0];
                    let bugun = new Date();
                    bugun.setDate(bugun.getDate() - 1);
                    let vade_fark = new Date(yeniTarih);
                    let fark_ms = vade_fark - bugun;
                    let farkgun = Math.floor(fark_ms / (1000 * 60 * 60 * 24));
                    let net_toplam = farkgun * tutar;
                    net_toplam = parseInt(net_toplam);
                    toplam_tutar_cek += net_toplam;
                    toplam_ana_tutar_cek += tutar;
                    let keside_yeri = $(this).find("td").eq(6).text();
                    let banka_adi = $(this).find("td").eq(7).text();
                    let sube_adi = $(this).find("td").eq(8).text();
                    let hesap_no = $(this).find("td").eq(9).text();
                    let ozel_kod = $(this).find("td").eq(10).text();
                    let durumu = "Teminata Verildi"
                    let bizim = $(this).find("td").eq(12).text();
                    arr.push(
                        {
                            alinan_cekid: id,
                            seri_no: belge_no,
                            vade_tarih: vade_tarihi,
                            asil_borclu: asil_borclu,
                            ciro_edilen: ciro_edilen,
                            girilen_tutar: tutar,
                            keside_yeri: keside_yeri,
                            banka_adi: banka_adi,
                            sube_adi: sube_adi,
                            hesap_no: hesap_no,
                            ozel_kod: ozel_kod,
                            son_durum: durumu,
                            bizim: bizim,
                        }
                    );
                } else if ($(this).hasClass("senet_secildi")) {
                    let id = $(this).attr("senet_secildi");
                    let belge_no = $(this).find("td").eq(1).text();
                    let vade_tarihi = $(this).find("td").eq(2).text();
                    let vade_tarihi2 = $(this).find("td").eq(2).text();
                    let asil_borclu = $(this).find("td").eq(3).text();
                    let ciro_edilen = $(this).find("td").eq(4).text();
                    let tutar = $(this).find("td").eq(5).text();
                    tutar = tutar.replace(/\./g, "").replace(",", ".");
                    tutar = parseFloat(tutar);
                    var parcalar2 = vade_tarihi2.split('/');
                    var yeniTarih2 = parcalar2[2] + '-' + parcalar2[1] + '-' + parcalar2[0];
                    let bugun = new Date();
                    bugun.setDate(bugun.getDate() - 1);
                    let vade_fark = new Date(yeniTarih2);
                    let fark_ms = vade_fark - bugun;
                    let farkgun = Math.floor(fark_ms / (1000 * 60 * 60 * 24));
                    let net_toplam = farkgun * tutar;
                    net_toplam = parseInt(net_toplam);
                    toplam_tutar_senet += net_toplam;
                    toplam_ana_tutar_senet += tutar;
                    let keside_yeri = $(this).find("td").eq(6).text();
                    let banka_adi = $(this).find("td").eq(7).text();
                    let sube_adi = $(this).find("td").eq(8).text();
                    let hesap_no = $(this).find("td").eq(9).text();
                    let ozel_kod = $(this).find("td").eq(10).text();
                    let durumu = "Ciro Edildi"
                    let bizim = $(this).find("td").eq(12).text();
                    arr.push(
                        {
                            alinan_senetid: id,
                            seri_no: belge_no,
                            vade_tarih: vade_tarihi,
                            asil_borclu: asil_borclu,
                            ciro_edilen: ciro_edilen,
                            girilen_tutar: tutar,
                            keside_yeri: keside_yeri,
                            banka_adi: banka_adi,
                            sube_adi: sube_adi,
                            hesap_no: hesap_no,
                            ozel_kod: ozel_kod,
                            son_durum: durumu,
                            bizim: bizim,
                        }
                    );
                }
            });
            var hasSenetid = false;
            var hasCekid = false;

            for (var i = 0; i < arr.length; i++) {
                var obj = arr[i];
                if ('alinan_senetid' in obj) {
                    hasSenetid = true;
                }
                if ('alinan_cekid' in obj) {
                    hasCekid = true;
                }
            }

            if (hasSenetid == true && hasCekid == true) {
                Swal.fire(
                    'Uyarı!',
                    'Hem Çek Hem Senet Giremezsiniz Lütfen Sadece Birini Giriniz...',
                    'warning'
                );
            } else if (hasSenetid == false && hasCekid == false) {
                Swal.fire(
                    'Uyarı!',
                    'Herhangi Bir Seçim Yapmadınız...',
                    'warning'
                );
            } else {
                tahsil_table.clear().draw(false);
                arr.forEach(function (item) {
                    let girilen_tutar = item.girilen_tutar;
                    girilen_tutar = parseFloat(girilen_tutar);
                    girilen_tutar = girilen_tutar.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });
                    let table = tahsil_table.row.add([item.seri_no, item.vade_tarih, item.asil_borclu, item.ciro_edilen, girilen_tutar, item.keside_yeri, item.banka_adi, item.hesap_no, item.sube_adi, item.ozel_kod, item.son_durum, item.bizim, "</button> <button class='btn btn-danger btn-sm cek_cikis_tahsil_iptal_et'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                    $(table).attr("data-name", "bankaya_teminata_verme");
                    $(table).attr("alinan_cekid", item.alinan_cekid);
                })
                if (hasSenetid == true) {

                } else {
                    let vade_gun_fark = toplam_tutar_cek / toplam_ana_tutar_cek;
                    vade_gun_fark = parseInt(vade_gun_fark);
                    $("#ort_gun").val(vade_gun_fark);
                    let farkTarih = new Date();
                    farkTarih.setDate(farkTarih.getDate() + vade_gun_fark);
                    var formattedTarih = farkTarih.toISOString().slice(0, 10);
                    $("#ort_vade").val(formattedTarih);
                }
                $("#cariye_ait_girilen_cekleri_getir_teminat").modal("hide");
            }

        })
    </script>
    <?php
}