<?php

$islem = $_GET["islem"];

if ($islem == "cek_senet_odeme_al") {
    ?>
    <style>
        #cek_senet_odeme_modal_main {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="cek_senet_odeme_modal_main" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 75%; max-width: 75%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="cek_senet_odeme_main"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ÇEK ÖDEME
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="odenecekleri_getir_div"></div>
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
                                <button class="btn btn-danger btn-sm" id="cek_senet_odeme_main"><i
                                            class="fa fa-close"></i> Vazgeç
                                </button>
                                <button class="btn btn-success btn-sm" id="secilen_cek_senetleri_ode"><i
                                            class="fa fa-check"></i> Kaydet
                                </button>
                                <button class="btn btn-info btn-sm" id="cek_senet_odenecekleri_getir"><i
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

        $("body").off("click","#secilen_cek_senetleri_ode").on("click","#secilen_cek_senetleri_ode",function (){
            var gidecek_arr = [];
            var firstTrDataId = cek_senet_odeme_table.row(':eq(0)').data()[6];
            let varmi = false;
            $(".secilenl_odemeler_selected").each(function () {
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
                let tutar = $(this).find("td").eq(4).text();
                tutar = tutar.replace(/\./g, "").replace(",", ".");
                tutar = parseFloat(tutar);
                let keside_yeri = $(this).find("td").eq(5).text();
                let ozel_kod = $(this).find("td").eq(9).text();
                let cek_id = $(this).attr("cek_id");
                let cari_id = $(this).attr("cari_id");
                gidecek_arr.push(
                    {
                        banka_id: banka_id,
                        cek_id: cek_id,
                        cari_id: cari_id,
                        seri_no: seri_no,
                        vade_tarih: vade_tarih,
                        asil_borclu: asil_borclu,
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
                let aciklama = $("#aciklama_cek_senet_tahsilat").val();
                $.ajax({
                    url: "controller/cek_senet_tahsil_odeme_controller/sql.php?islem=odemeyi_gerceklestir_sql",
                    type: "POST",
                    data: {
                        tarih: tarih,
                        belge_no: belge_no,
                        ozel_kod: ozel_kod,
                        doviz_tur: doviz_tur,
                        aciklama: aciklama,
                        arr: gidecek_arr
                    },
                    success: function (result) {
                        if (result == 1) {
                            Swal.fire(
                                'Başarılı',
                                'Ödeme Kaydedildi',
                                'success'
                            );
                            $("#cek_senet_odeme_modal_main").modal("hide");
                            $.get("view/cek_senet_odeme.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                            $.get("view/cek_senet_odeme.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }
        });

        $("body").off("click", "#cek_senet_odenecekleri_getir").on("click", "#cek_senet_odenecekleri_getir", function () {
            $.get("modals/cek_senet_odeme_modal/modal.php?islem=cek_senet_odenecekleri_getir", function (getModal) {
                $(".odenecekleri_getir_div").html("");
                $(".odenecekleri_getir_div").html(getModal);
            });
        });

        var cek_senet_odeme_table = "";
        $(document).ready(function () {
            $("#cek_senet_odeme_modal_main").modal("show");
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
            cek_senet_odeme_table = $('#tahsile_verilen_cek_senet_tahsili_table').DataTable({
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
                    $(row).addClass("secilenl_odemeler_selected");
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
        })
        $("body").off("click",".odenecek_cekleri_sil").on("click",".odenecek_cekleri_sil",function (){
            var row = $(this).closest('tr');
            cek_senet_odeme_table.row(row).remove().draw(false);
        });

        $("body").off("click", "#cek_senet_odeme_main").on("click", "#cek_senet_odeme_main", function () {
            $("#cek_senet_odeme_modal_main").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "cek_senet_odenecekleri_getir") {
    ?>
    <div class="modal fade" id="tahsile_verilen_cekler_ve_senetleri_getir"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 55%; max-width: 55%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2" style="font-weight: bold">Kendi Çeklerimiz
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
            $("#tahsile_verilen_cekler_ve_senetleri_getir").modal("show");
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
                    $(row).find("td").eq(2).css("text-align", "left");
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
            $.get("controller/cek_senet_tahsil_odeme_controller/sql.php?islem=bizim_cekleri_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        let asil_borclu = "BİZ";
                        if ("asil_borclu" in item){
                            asil_borclu = item.asil_borclu;
                        }
                        let ciro_edilen = "";
                        if ("ciro_edilmis" in item){
                            ciro_edilen = item.ciro_edilmis;
                        }else {
                            ciro_edilen = item.cari_adi;
                        }
                        let vade_tarih = item.vade_tarih;
                        vade_tarih = vade_tarih.split(" ");
                        vade_tarih = vade_tarih[0];
                        vade_tarih = vade_tarih.split("-");
                        let gun = vade_tarih[2];
                        let ay = vade_tarih[1];
                        let yil = vade_tarih[0];
                        let arr = [gun, ay, yil];
                        vade_tarih = arr.join("/");
                        let tutar = item.tutar;
                        tutar = parseFloat(tutar);
                        tutar = tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        let table = cek_senet_tahsildekiler_main.row.add(["<input type='checkbox' class='col-9 secilen_tahsillikler' data-id='" + item.id + "'>", item.seri_no, vade_tarih, asil_borclu, ciro_edilen, tutar, item.keside_yeri, item.banka_adi, item.sube_adi, item.hesap_no, item.ozel_kod]).draw(false).node();
                        $(table).attr("banka_id", item.banka_id);
                        $(table).attr("data-id", item.id);
                        $(table).attr("cari_id",item.cari_id)
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
            cek_senet_odeme_table.clear().draw(false);
            $(".tahsile_verilen_selected").each(function () {
                if ($(this).hasClass("tahsil_secildi")) {
                    let cek_id = $(this).attr("data-id");
                    let cari_id = $(this).attr("cari_id");
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
                    let secilenler = cek_senet_odeme_table.row.add([seri_no, vade_tarih, asil_borclu, ciro_edilmis, tutar, keside_yeri, banka_adi, sube_adi, hesap_no, ozel_kod, "ÖDENDİ", "BİZİM", "<button class='btn btn-danger btn-sm odenecek_cekleri_sil'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                    $(secilenler).attr("banka_id", banka_id);
                    $(secilenler).attr("banka_adi", banka_adi);
                    $(secilenler).attr("cek_id", cek_id)
                    $(secilenler).attr("cari_id", cari_id)
                } else {

                }
            });
            $("#tahsile_verilen_cekler_ve_senetleri_getir").modal("hide");
        });

        $("body").off("click", "#tahsil_modal_kapat").on("click", "#tahsil_modal_kapat", function () {
            $("#tahsile_verilen_cekler_ve_senetleri_getir").modal("hide");
        });

    </script>
    <?php
}