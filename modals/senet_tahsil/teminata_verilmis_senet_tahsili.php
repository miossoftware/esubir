<?php

$islem = $_GET["islem"];

if ($islem == "cek_senet_tahsil_et_modal") {
    ?>
    <style>
        #ikinci_tahsil_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="ikinci_tahsil_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 75%; max-width: 75%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="ikinci_tahsil_modal_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>TEMİNATA VERİLMİŞ SENET
                                TAHSİLİ
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="tahsil_edilecekleri_getir_div"></div>
                            <div class="col-12 row">
                                <div class="col-4">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Tarih</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>"
                                                   class="form-control form-control-sm" id="tarih_tahsilat">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Belge No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="belge_no_tahsilat">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Özel Kod1</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="ozel_kod1_tahsilat">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4 ">
                                            Döviz Türü
                                        </div>
                                        <div class="col-md-8 row no-gutters">
                                            <div class="col-md">
                                                <select class="custom-select custom-select-sm"
                                                        id="doviz_tur_cek_senet_tahsilat">
                                                    <option value="">Seçiniz...</option>
                                                    <option selected="" value="TL">TL</option>
                                                    <option id="usd_bas" value="USD">USD</option>
                                                    <option id="eur_bas" value="EURO">EURO</option>
                                                    <option id="gbp_bas" value="GBP">GBP</option>
                                                </select>
                                            </div>
                                            <!--                                            <div class="col-md">-->
                                            <!--                                                <input type="text"-->
                                            <!--                                                       class="form-control form-control-sm doviz_kuru_cek_senet_tahsilat"-->
                                            <!--                                                       id="doviz_kuru" value="1.00" placeholder="Döviz Karşılığı">-->
                                            <!--                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-md-7">
                                            <textarea class="form-control form-control-sm"
                                                      id="aciklama_cek_senet_tahsilat" rows="6"
                                                      style="resize: none"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row">
                                <table class="table table-sm table-bordered w-100 display nowrap"
                                       style="cursor:pointer;font-size: 13px;"
                                       id="tahsile_verilen_cek_senet_tahsili_table">
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
                                <button class="btn btn-danger btn-sm" id="ikinci_tahsil_modal_vazgec"><i class="fa fa-close"></i> Vazgeç</button>
                                <button class="btn btn-success btn-sm" id="secilen_cek_senetleri_tahsil_et"><i
                                        class="fa fa-check"></i> Kaydet
                                </button>
                                <button class="btn btn-info btn-sm" id="tahsile_verilen_tahsil_edilecek_cekler"><i
                                        class="fa fa-list"></i> Senet Listesi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var tahsile_verilen_tahsilat_main = "";
        $(document).ready(function () {
            $("#ikinci_tahsil_modal").modal("show");
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
            tahsile_verilen_tahsilat_main = $('#tahsile_verilen_cek_senet_tahsili_table').DataTable({
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
                    $(row).addClass("secilenler_tahsil_icin_gonder_table");
                    $(row).find("td").eq(0).css("text-align", "left");
                    $(row).find("td").eq(1).css("text-align", "left");
                    $(row).find("td").eq(2).css("text-align", "left");
                    $(row).find("td").eq(3).css("text-align", "left");
                    $(row).find("td").eq(5).css("text-align", "left");
                    $(row).find("td").eq(6).css("text-align", "left");
                    $(row).find("td").eq(7).css("text-align", "left");
                    $(row).find("td").eq(8).css("text-align", "left");
                    $(row).find("td").eq(9).css("text-align", "left");
                    $(row).find("td").eq(10).css("text-align", "left");
                    $(row).find("td").eq(11).css("text-align", "left");
                    $(row).find("td").eq(12).css("text-align", "left");
                },
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
            })
        });

        $("body").off("click", "#secilen_cek_senetleri_tahsil_et").on("click", "#secilen_cek_senetleri_tahsil_et", function () {
            var gidecek_arr = [];
            var firstTrDataId = tahsile_verilen_tahsilat_main.row(':eq(0)').data()[6];
            let varmi = false;
            $(".secilenler_tahsil_icin_gonder_table").each(function () {
                let banka_adi = $(this).find("td").eq(6).text();
                let banka_id = $(this).attr("banka_id");
                let seri_no = $(this).find("td").eq(0).text();
                let vade_tarih = $(this).find("td").eq(1).text();
                vade_tarih = vade_tarih.split("/");
                let gun = vade_tarih[0];
                let ay = vade_tarih[1];
                let yil = vade_tarih[2];
                let arr = [yil, ay, gun];
                vade_tarih = arr.join("-");
                let asil_borclu = $(this).find("td").eq(2).text();
                let ciro_edilmis = $(this).find("td").eq(3).text();
                let tutar = $(this).find("td").eq(4).text();
                tutar = tutar.replace(/\./g, "").replace(",", ".");
                tutar = parseFloat(tutar);
                let keside_yeri = $(this).find("td").eq(5).text();
                let ozel_kod = $(this).find("td").eq(9).text();
                let cek_id = $(this).attr("cek_id");
                gidecek_arr.push(
                    {
                        banka_id: banka_id,
                        cek_id: cek_id,
                        seri_no: seri_no,
                        vade_tarih: vade_tarih,
                        asil_borclu: asil_borclu,
                        ciro_edilmis: ciro_edilmis,
                        tutar: tutar,
                        keside_yeri: keside_yeri,
                        ozel_kod: ozel_kod
                    }
                );
                if (banka_adi == firstTrDataId) {
                    varmi = true;
                } else {
                    varmi = false;
                }
            });
            if (varmi == false) {
                Swal.fire(
                    'Uyarı!',
                    'Lütfen Farklı Bankalar Girmeyiniz...',
                    'warning'
                );
            } else {
                let tarih = $("#tarih_tahsilat").val();
                let belge_no = $("#belge_no_tahsilat").val();
                let ozel_kod = $("#ozel_kod1_tahsilat").val();
                let doviz_tur = $("#doviz_tur_cek_senet_tahsilat").val();
                // let doviz_kur = $(".doviz_kuru_cek_senet_tahsilat").val();
                let aciklama = $("#aciklama_cek_senet_tahsilat").val();
                $.ajax({
                    url: "controller/senet_controller/sql.php?islem=teminata_verilen_tahsilati_gerceklestir_sql",
                    type: "POST",
                    data: {
                        tarih: tarih,
                        belge_no: belge_no,
                        ozel_kod: ozel_kod,
                        doviz_tur: doviz_tur,
                        // doviz_kur: doviz_kur,
                        aciklama: aciklama,
                        arr: gidecek_arr
                    },
                    success: function (result) {
                        if (result == 1) {
                            Swal.fire(
                                'Başarılı',
                                'Tahsil Kaydedildi',
                                'success'
                            );
                            $("#ikinci_tahsil_modal").modal("hide");
                            $.get("view/senet_tahsil.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                            $.get("view/senet_tahsil.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }
        });

        $("body").off("click", ".teminat_edilecek_senet_sil_main_list_button").on("click", ".teminat_edilecek_senet_sil_main_list_button", function () {
            var row = $(this).closest('tr');
            tahsile_verilen_tahsilat_main.row(row).remove().draw();
        });

        $("body").off("click", "#tahsile_verilen_tahsil_edilecek_cekler").on("click", "#tahsile_verilen_tahsil_edilecek_cekler", function () {
            $.get("modals/senet_tahsil/teminata_verilmis_senet_tahsili.php?islem=tahsil_edilecek_cekleri_getir_modal", function (getModals) {
                $(".tahsil_edilecekleri_getir_div").html("");
                $(".tahsil_edilecekleri_getir_div").html(getModals);
            })
        })

        $("body").off("click", "#ikinci_tahsil_modal_vazgec").on("click", "#ikinci_tahsil_modal_vazgec", function () {
            $("#ikinci_tahsil_modal").modal("hide");
        })
    </script>
    <?php
}
if ($islem == "tahsil_edilecek_cekleri_getir_modal") {
    ?>
    <div class="modal fade" id="teminata_verilen_cekler_ve_senetleri_getir"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 55%; max-width: 55%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2" style="font-weight: bold">Teminata Verilen Senetler
                    <button type="button" class="btn-close btn-close-white" id="tahsil_modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="tahsile_verilen_cek_senetler_list">
                            <thead>
                            <tr>
                                <th id="click125">Seç</th>
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
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-sm" id="tahsil_modal_kapat"><i class="fa fa-close"></i> Kapat
                    </button>
                    <button class="btn btn-success btn-sm" id="secilen_tahsilleri_aktar"><i
                            class="fa fa-download"></i> Seçilenleri Aktar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#teminata_verilen_cekler_ve_senetleri_getir").modal("show");
            setTimeout(function () {
                $("#click125").trigger("click");
            }, 500);
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
            var cek_senet_tahsildekiler_main = $('#tahsile_verilen_cek_senetler_list').DataTable({
                scrollY: '30vh',
                scrollX: true,
                "info": false,
                bAutoWidth: false,
                "order": [[0, 'desc']],
                createdRow: function (row) {
                    $(row).addClass("tahsile_verilen_selected");
                    $(row).find("td").eq(0).css("text-align", "left");
                    $(row).find("td").eq(1).css("text-align", "left");
                    $(row).find("td").eq(3).css("text-align", "left");
                    $(row).find("td").eq(4).css("text-align", "left");
                    $(row).find("td").eq(6).css("text-align", "left");
                    $(row).find("td").eq(7).css("text-align", "left");
                    $(row).find("td").eq(8).css("text-align", "left");
                    $(row).find("td").eq(9).css("text-align", "left");
                    $(row).find("td").eq(10).css("text-align", "left");
                },
                searching: false,
                columnDefs: [
                    {targets: 0, type: "date-eu"}
                ],
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
            })
            $.get("controller/senet_controller/sql.php?islem=teminata_verilen_cek_senetleri_getir", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        let vade_tarih = item.vade_tarih;
                        vade_tarih = vade_tarih.split(" ");
                        vade_tarih = vade_tarih[0];
                        vade_tarih = vade_tarih.split("-");
                        let gun = vade_tarih[2];
                        let ay = vade_tarih[1];
                        let yil = vade_tarih[0];
                        let arr = [gun, ay, yil];
                        vade_tarih = arr.join("/");
                        let tutar = item.girilen_tutar;
                        tutar = parseFloat(tutar);
                        tutar = tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        let table = cek_senet_tahsildekiler_main.row.add(["<input type='checkbox' class='col-9 secilen_tahsillikler' data-id='" + item.id + "'>", item.seri_no, vade_tarih, item.asil_borclu, item.ciro_edilmis, tutar, item.keside_yeri, item.banka_adi, item.sube_adi, item.hesap_no, item.ozel_kod]).draw(false).node();
                        $(table).attr("banka_id", item.banka_id);
                        $(table).attr("data-id", item.id);
                    })
                }
            })
        })

        $("body").off("click", ".secilen_tahsillikler").on("click", ".secilen_tahsillikler", function () {
            let closest = $(this).closest("tr");
            if ($(this).prop("checked")) {
                closest.addClass("tahsil_secildi");
            } else {
                closest.removeClass("tahsil_secildi");
            }

        });

        $("body").off("click", "#secilen_tahsilleri_aktar").on("click", "#secilen_tahsilleri_aktar", function () {
            tahsile_verilen_tahsilat_main.clear().draw(false);
            $(".tahsile_verilen_selected").each(function () {
                if ($(this).hasClass("tahsil_secildi")) {
                    let cek_id = $(this).attr("data-id");
                    let seri_no = $(this).find("td").eq(1).text();
                    let vade_tarih = $(this).find("td").eq(2).text();
                    let asil_borclu = $(this).find("td").eq(3).text();
                    let ciro_edilmis = $(this).find("td").eq(4).text();
                    let tutar = $(this).find("td").eq(5).text();
                    let keside_yeri = $(this).find("td").eq(6).text();
                    let banka_id = $(this).attr("banka_id");
                    let banka_adi = $(this).find("td").eq(7).text();
                    let sube_adi = $(this).find("td").eq(8).text();
                    let hesap_no = $(this).find("td").eq(9).text();
                    let ozel_kod = $(this).find("td").eq(10).text();
                    let secilenler = tahsile_verilen_tahsilat_main.row.add([seri_no, vade_tarih, asil_borclu, ciro_edilmis, tutar, keside_yeri, banka_adi, sube_adi, hesap_no, ozel_kod, "TAHSİL EDİLDİ", "MÜŞTERİNİN", "<button class='btn btn-danger btn-sm teminat_edilecek_senet_sil_main_list_button'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                    $(secilenler).attr("banka_id", banka_id);
                    $(secilenler).attr("banka_adi", banka_adi);
                    $(secilenler).attr("cek_id", cek_id)
                } else {

                }
            });
            $("#teminata_verilen_cekler_ve_senetleri_getir").modal("hide");
        });

        $("body").off("click", "#tahsil_modal_kapat").on("click", "#tahsil_modal_kapat", function () {
            $("#teminata_verilen_cekler_ve_senetleri_getir").modal("hide");
        });

    </script>
    <?php
}