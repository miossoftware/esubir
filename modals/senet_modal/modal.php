<?php

$islem = $_GET["islem"];

if ($islem == "senet_giris_modal_getir_sql") {
    ?>
    <style>
        #yeni_alinan_senet_olustur_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="yeni_alinan_senet_olustur_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 75%; max-width: 75%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="senet_vazgec_main"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ALINAN SENET GİRİŞ</div>
                        </div>
                        <div class="modal-body">
                            <div class="yeni_cek_girisi"></div>
                            <div class="yeni_cek_icin_cari"></div>
                            <div class="cek_guncelleme_modali"></div>
                            <div class="col-12 mx-1 row no-gutteras" style="border: 1px solid #000">
                                <div class="col-6 mt-2">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Cari Kodu</label>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="cek_senet_giris_cariid">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm cek_senet_icin_cari_getir"
                                                            id=""><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Cari Adı</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control form-control-sm" disabled
                                                   id="cari_adi_cek_senet">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Telefon</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" id="cari_tel" disabled
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Yetkili Adı</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" id="cari_yetkili" disabled
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Yetkili Cep</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" disabled id="yetkili_tel"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Vergi Dairesi</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" disabled id="vergi_dairesi"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Vergi No</label>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" disabled id="vergi_no"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Cari Adres</label>
                                        </div>
                                        <div class="col-md-6">
                                            <textarea disabled style="resize: none" class="form-control form-control-sm"
                                                      id="cari_adres" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mt-2">
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
                                       id="cek_senet_giris_kalem_table">
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
                                <button class="btn btn-danger btn-sm" id="senet_vazgec_main"><i class="fa fa-close"></i>
                                    Vazgeç
                                </button>
                                <button class="btn btn-success btn-sm" id="alinan_senet_giris_onayla"><i
                                            class="fa fa-check"></i>Kaydet
                                </button>
                                <button class="btn btn-primary btn-sm" id="yeni_senet_giris_olustur_button"><i
                                            class="fa fa-plus"></i> Yeni Senet
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var cek_table_main = "";
        $("body").off("change", ".doviz_tur_cek_senet").on("change", ".doviz_tur_cek_senet", function () {

            var value = $(this).val();

            if (value == "TL") {

                $("#doviz_kuru").val("1.00");

            } else if (value == "EURO") {

                var eur_kur = $(".doviz_tur_cek_senet option:selected").attr("eur");

                $("#doviz_kuru").val(eur_kur);

            } else if (value == "USD") {

                var usd_kur = $(".doviz_tur_cek_senet option:selected").attr("usd");

                $("#doviz_kuru").val(usd_kur);

            } else if (value == "GBP") {

                var gbp_kur = $(".doviz_tur_cek_senet option:selected").attr("gbp");

                $("#doviz_kuru").val(gbp_kur);

            } else {

                $("#doviz_kuru").val("");

            }

        });
        $("body").off("click", "#senet_vazgec_main").on("click", "#senet_vazgec_main", function () {
            let cek_id = $("#yeni_senet_giris_olustur_button").attr("data-id");
            let senet_id = $("#yeni_senet_girisi_olustur_button_modal").attr("data-id");
            if (cek_id != "" || cek_id != undefined) {
                $.ajax({
                    url: "controller/senet_controller/sql.php?islem=cek_senet_vazgec_sql",
                    type: "POST",
                    data: {
                        senet_id: cek_id
                    },
                    success: function (result) {
                        if (result == 1) {
                            $("#yeni_alinan_senet_olustur_modal").modal("hide");
                        } else {
                            $("#yeni_alinan_senet_olustur_modal").modal("hide");
                        }
                    }
                });
            } else if (senet_id != "" || senet_id != undefined) {
                $.ajax({
                    url: "controller/cek_senet_controller/sql.php?islem=cek_senet_vazgec_sql",
                    type: "POST",
                    data: {
                        senet_id: senet_id
                    },
                    success: function (result) {
                        if (result == 1) {
                            $("#yeni_alinan_senet_olustur_modal").modal("hide");
                        } else {
                            $("#yeni_alinan_senet_olustur_modal").modal("hide");
                        }
                    }
                });
            }
        })
        $("body").off("click", ".cek_senet_icin_cari_getir").on("click", ".cek_senet_icin_cari_getir", function () {
            $.get("modals/cek_senet_modal/another_modal.php?islem=carileri_getir_modal", function (getModal) {
                $(".yeni_cek_icin_cari").html("");
                $(".yeni_cek_icin_cari").html(getModal);
            })
        });
        $(document).ready(function () {
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
                $("#click_me").trigger("click");
            }, 500);
            $("#yeni_alinan_senet_olustur_modal").modal("show");
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
            cek_table_main = $('#cek_senet_giris_kalem_table').DataTable({
                scrollY: '30vh',
                scrollX: true,
                "info": false,
                bAutoWidth: false,
                "order": [[0, 'desc']],
                searching: false,
                columnDefs: [
                    {targets: 0, type: "date-eu"}
                ],
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
            })
        });

        $("#cek_senet_giris_cariid").keyup(function () {
            let cari_kodu = $(this).val();
            $.get("controller/alis_controller/sql.php?islem=girilen_cari_kodu_bilgileri", {cari_kodu: cari_kodu}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#cari_tel").val(item.telefon);
                    $("#cari_adi_cek_senet").val(item.cari_adi)
                    $("#cek_senet_giris_cariid").val(item.cari_kodu);
                    $("#cek_senet_giris_cariid").attr("data-id", item.id);
                    $("#cari_yetkili").val(item.yetkili_adi1);
                    $("#yetkili_tel").val(item.yetkili_tel1);
                    $("#vergi_dairesi").val(item.vergi_dairesi);
                    $("#vergi_no").val(item.vergi_no);
                    $("#cari_adres").val(item.adres.toUpperCase());
                } else {
                    $("#cari_tel").val("");
                    $("#cari_yetkili").val("");
                    $("#cek_senet_giris_cariid").attr("data-id", "");
                    $("#yetkili_tel").val("");
                    $("#vergi_dairesi").val("");
                    $("#vergi_no").val("");
                    $("#cari_adres").val("");
                }
            })
        })

        $("body").off("click", "#alinan_senet_giris_onayla").on("click", "#alinan_senet_giris_onayla", function () {
            let cari_id = $("#cek_senet_giris_cariid").attr("data-id");
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
            let senet_id = $("#yeni_senet_giris_olustur_button").attr("data-id");
            $.ajax({
                url: "controller/senet_controller/sql.php?islem=alinan_senet_onayla_sql",
                type: "POST",
                data: {
                    cari_id: cari_id,
                    tarih: tarih,
                    doviz_tur: doviz_tur,
                    doviz_kuru: doviz_kuru,
                    belge_no: belge_no,
                    ort_vade: ort_vade,
                    ort_gun: ort_gun,
                    mutabakat: mutabakat,
                    ozel_kod1: ozel_kod1,
                    ozel_kod2: ozel_kod2,
                    aciklama: aciklama,
                    senet_id: senet_id
                },
                success: function (result) {
                    if (result == 1) {
                        $("#yeni_alinan_senet_olustur_modal").modal("hide");
                        $.get("view/senet_giris_bordrosu.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                        $.get("view/senet_giris_bordrosu.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                    } else {
                        $("#yeni_alinan_senet_olustur_modal").modal("hide");
                    }
                }
            });
        });

        $("body").off("click", ".senet_kaydi_guncelle_list_button").on("click", ".senet_kaydi_guncelle_list_button", function () {
            let id = $(this).attr("data-id");
            let cari_id = $("#cek_senet_giris_cariid").attr("data-id");
            let cek_id = $("#yeni_senet_giris_olustur_button").attr("data-id");
            $.get("modals/senet_modal/modal.php?islem=cek_senet_guncelle_modal", {
                cari_id: cari_id,
                id: id,
                cek_id: cek_id
            }, function (getModal) {
                $(".cek_guncelleme_modali").html("");
                $(".cek_guncelleme_modali").html(getModal);
            })
        });

        $("body").off("click", ".senet_iptal_list_main").on("click", ".senet_iptal_list_main", function () {
            let id = $(this).attr("data-id");
            var closest = $(this).closest("tr");
            let cek_id = $("#yeni_senet_giris_olustur_button").attr("data-id");
            $.ajax({
                url: "controller/senet_controller/sql.php?islem=senet_iptal_et_sql",
                type: "POST",
                data: {
                    id: id,
                    cek_id: cek_id
                },
                success: function (result) {
                    if (result != 2) {
                        closest.remove();
                        var json = JSON.parse(result);
                        let toplam_tutar = 0;
                        let toplam_ana_tutar = 0;
                        json.forEach(function (item) {
                            let tutar = item.girilen_tutar;
                            tutar = parseFloat(tutar);
                            let vade_tarihi = item.vade_tarih;
                            vade_tarihi = vade_tarihi.split(" ");
                            let bugun = new Date();
                            bugun.setDate(bugun.getDate() - 1);
                            let vade_fark = new Date(vade_tarihi);
                            let fark_ms = vade_fark - bugun;
                            let farkgun = Math.floor(fark_ms / (1000 * 60 * 60 * 24));
                            let net_toplam = farkgun * tutar;
                            net_toplam = parseInt(net_toplam);
                            toplam_tutar += net_toplam;
                            toplam_ana_tutar += tutar;
                        })
                        let vade_gun_fark = toplam_tutar / toplam_ana_tutar;
                        vade_gun_fark = parseInt(vade_gun_fark);
                        $("#ort_gun").val(vade_gun_fark);
                        let farkTarih = new Date();
                        farkTarih.setDate(farkTarih.getDate() + vade_gun_fark);
                        var formattedTarih = farkTarih.toISOString().slice(0, 10);
                        $("#ort_vade").val(formattedTarih);
                    } else if (result == 2) {
                        $("#yeni_senet_giris_olustur_button").attr("data-id", "");
                        cek_table_main.clear().draw(false);
                        $("#yeni_senet_girisi_olustur_button_modal").prop("disabled", false);
                        $("#ort_vade").val("<?=date("Y-m-d")?>");
                        $("#ort_gun").val("0");
                    }
                }
            });
        });

        $("body").off("click", "#yeni_senet_giris_olustur_button").on("click", "#yeni_senet_giris_olustur_button", function () {
            let cari_id = $("#cek_senet_giris_cariid").attr("data-id");
            let cek_id = $("#yeni_senet_giris_olustur_button").attr("data-id");
            if (cari_id == "" || cari_id == undefined) {
                Swal.fire(
                    'Uyarı!',
                    'Lütfen Bir Cari Seçiniz',
                    'warning'
                );
            } else {
                $.get("modals/senet_modal/modal.php?islem=yeni_senet_girisi_modal_getir", {
                    cari_id: cari_id,
                    cek_id: cek_id
                }, function (getModal) {
                    $(".yeni_cek_girisi").html("");
                    $(".yeni_cek_girisi").html(getModal);
                })
            }
        });

    </script>
    <?php
}
if ($islem == "yeni_senet_girisi_modal_getir") {
    ?>
    <div class="modal fade" id="yeni_senet_giris_modal_baslat" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 75%; max-width: 75%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="acilis_vazgec_cari"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ALINAN ÇEK SENET GİRİŞ</div>
                        </div>
                        <div class="modal-body">
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Seri No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="seri_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Vadesi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>"
                                                   class="form-control form-control-sm" id="vade_tarih">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="tipi">
                                                <option value="Asıl Borçludan">Asıl Borçludan</option>
                                                <option value="Ciro Edilmiş">Ciro Edilmiş</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Tutar</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" style="text-align: right"
                                                   class="form-control form-control-sm" value="0,00" id="girilen_tutar">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Asıl Borçlu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="asil_borclu">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Ciro Edilmiş</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="ciro_edilmis">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Keşide Yeri</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="keside_yeri">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Banka Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="banka_adi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Banka Şubesi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="banka_subesi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Hesap No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="hesap_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Özel Kod</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="ozel_kod_second">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger btn-sm" id="acilis_vazgec_cari"><i
                                            class="fa fa-close"></i> Vazgeç
                                </button>
                                <button class="btn btn-success btn-sm" id="alinan_cek_girisi_kaydet"><i
                                            class="fa fa-check"></i> Kaydet
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function () {
            $("#yeni_senet_giris_modal_baslat").modal("show");
            $.get("controller/alis_controller/sql.php?islem=secilen_cari_bilgileri", {id: "<?=$_GET["cari_id"]?>"}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#asil_borclu").val(item.cari_adi);
                    $("#ciro_edilmis").val(item.cari_adi);
                }
            })
        });

        $("body").off("click", "#acilis_vazgec_cari").on("click", "#acilis_vazgec_cari", function () {
            $("#yeni_senet_giris_modal_baslat").modal("hide");
        })

        $("#girilen_tutar").focusout(function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})
            $("#girilen_tutar").val(val);
        })

        $("body").off("click", "#girilen_tutar").on("click", "#girilen_tutar", function () {
            $(this).select();
        })

        $("body").off("click", "#alinan_cek_girisi_kaydet").on("click", "#alinan_cek_girisi_kaydet", function () {
            let alinan_cekid = $("#yeni_senet_giris_olustur_button").attr("data-id");
            let ozel_kod = $("#ozel_kod_second").val();
            let seri_no = $("#seri_no").val();
            let cari_id = "<?=$_GET["cari_id"]?>";
            let vade_tarih = $("#vade_tarih").val();
            let tipi = $("#tipi").val();
            let asil_borclu = $("#asil_borclu").val();
            let ciro_edilmis = $("#ciro_edilmis").val();
            let keside_yeri = $("#keside_yeri").val();
            let banka_adi = $("#banka_adi").val();
            let banka_sube = $("#banka_subesi").val();
            let hesap_no = $("#hesap_no").val();
            let girilen_tutar = $("#girilen_tutar").val();
            girilen_tutar = girilen_tutar.replace(/\./g, "").replace(",", ".");
            girilen_tutar = parseFloat(girilen_tutar);
            $.ajax({
                url: "controller/senet_controller/sql.php?islem=yeni_alinan_senet_girisi_sql",
                type: "POST",
                data: {
                    alinan_senetid: alinan_cekid,
                    ozel_kod: ozel_kod,
                    cari_id: cari_id,
                    seri_no: seri_no,
                    vade_tarih: vade_tarih,
                    tipi: tipi,
                    asil_borclu: asil_borclu,
                    ciro_edilmis: ciro_edilmis,
                    keside_yeri: keside_yeri,
                    banka_adi: banka_adi,
                    banka_sube: banka_sube,
                    hesap_no: hesap_no,
                    girilen_tutar: girilen_tutar
                },
                success: function (result) {
                    if (result != 2) {
                        var json = JSON.parse(result);
                        cek_table_main.clear().draw(false);
                        let toplam_tutar = 0;
                        let toplam_ana_tutar = 0;
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
                            let bugun = new Date();
                            bugun.setDate(bugun.getDate() - 1);
                            let vade_fark = new Date(vade_tarihi);
                            let fark_ms = vade_fark - bugun;
                            let farkgun = Math.floor(fark_ms / (1000 * 60 * 60 * 24));
                            let net_toplam = farkgun * tutar;
                            net_toplam = parseInt(net_toplam);
                            toplam_tutar += net_toplam;
                            toplam_ana_tutar += tutar;
                            tutar = tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                            vade_tarihi = vade_tarihi[0];
                            vade_tarihi = vade_tarihi.split("-");
                            let gun = vade_tarihi[2];
                            let ay = vade_tarihi[1];
                            let yil = vade_tarihi[0];
                            let arr = [gun, ay, yil];
                            vade_tarihi = arr.join("/");
                            $("#yeni_senet_giris_olustur_button").attr("data-id", item.alinan_senetid);
                            cek_table_main.row.add([item.seri_no, vade_tarihi, item.asil_borclu, item.ciro_edilmis, tutar, item.keside_yeri, item.banka_adi, item.banka_sube, item.hesap_no, item.ozel_kod, son_durum, bizim_mi, "<button class='btn btn-sm senet_kaydi_guncelle_list_button' style='background-color: #F6FA70' data-id='" + item.id + "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm senet_iptal_list_main' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false);
                        })
                        let vade_gun_fark = toplam_tutar / toplam_ana_tutar;
                        vade_gun_fark = parseInt(vade_gun_fark);
                        $("#ort_gun").val(vade_gun_fark);
                        let farkTarih = new Date();
                        farkTarih.setDate(farkTarih.getDate() + vade_gun_fark);
                        var formattedTarih = farkTarih.toISOString().slice(0, 10);
                        $("#yeni_senet_giris_modal_baslat").modal("hide");
                        $("#ort_vade").val(formattedTarih);
                        $("#yeni_senet_girisi_olustur_button_modal").prop("disabled", true);
                    }
                }
            });
        });

        $("body").off("change", "#tipi").on("change", "#tipi", function () {
            let tipi = $(this).val();
            if (tipi == "Asıl Borçludan") {
                let asil_borclu = $("#ciro_edilmis").val();
                $("#asil_borclu").val(asil_borclu);
            } else {
                $("#asil_borclu").val("");
            }
        });

    </script>
    <?php
}
if ($islem == "cek_senet_guncelle_modal") {
    ?>
    <div class="modal fade" id="senet_guncelle_baslat_modal" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 75%; max-width: 75%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="acilis_vazgec_cari_guncelle"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ALINAN SENET GÜNCELLE</div>
                        </div>
                        <div class="modal-body">
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Seri No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="seri_no_guncelle">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Vadesi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>"
                                                   class="form-control form-control-sm" id="vade_tarih_guncelle">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="tipi_guncelle">
                                                <option value="Asıl Borçludan">Asıl Borçludan</option>
                                                <option value="Ciro Edilmiş">Ciro Edilmiş</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Tutar</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" style="text-align: right"
                                                   class="form-control form-control-sm" value="0,00"
                                                   id="girilen_tutar_guncelle">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Asıl Borçlu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="asil_borclu_guncelle">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Ciro Edilmiş</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="ciro_edilmis_guncelle">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Keşide Yeri</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="keside_yeri_guncelle">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Banka Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="banka_adi_guncelle">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Banka Şubesi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="banka_subesi_guncelle">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Hesap No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="hesap_no_guncelle">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Özel Kod</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="ozel_kod_second_guncelle">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger btn-sm" id="acilis_vazgec_cari_guncelle"><i
                                            class="fa fa-close"></i> Vazgeç
                                </button>
                                <button class="btn btn-success btn-sm" id="alinan_cek_girisi_guncelle"><i
                                            class="fa fa-check"></i> Kaydet
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function () {

            $.get("controller/senet_controller/sql.php?islem=cek_bilgileri_getir_sql", {id: "<?=$_GET["id"]?>"}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    let vade_tarih = item.vade_tarih;
                    vade_tarih = vade_tarih.split(" ");
                    $("#ozel_kod_second_guncelle").val(item.ozel_kod);
                    $("#seri_no_guncelle").val(item.seri_no);
                    $("#vade_tarih_guncelle").val(vade_tarih[0]);
                    $("#tipi_guncelle").val(item.tipi);
                    $("#asil_borclu_guncelle").val(item.asil_borclu);
                    $("#ciro_edilmis_guncelle").val(item.ciro_edilmis);
                    $("#keside_yeri_guncelle").val(item.keside_yeri);
                    $("#banka_adi_guncelle").val(item.banka_adi);
                    $("#banka_subesi_guncelle").val(item.banka_sube);
                    $("#hesap_no_guncelle").val(item.hesap_no);
                    let girilen_tutar = item.girilen_tutar;
                    girilen_tutar = parseFloat(girilen_tutar);
                    girilen_tutar = girilen_tutar.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });
                    $("#girilen_tutar_guncelle").val(girilen_tutar);
                }
            })

            $("#senet_guncelle_baslat_modal").modal("show");
        });

        $("body").off("click", "#acilis_vazgec_cari_guncelle").on("click", "#acilis_vazgec_cari_guncelle", function () {
            $("#senet_guncelle_baslat_modal").modal("hide");
        })

        $("#girilen_tutar_guncelle").focusout(function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2})
            $("#girilen_tutar_guncelle").val(val);
        })

        $("body").off("click", "#girilen_tutar_guncelle").on("click", "#girilen_tutar_guncelle", function () {
            $(this).select();
        })

        $("body").off("click", "#alinan_cek_girisi_guncelle").on("click", "#alinan_cek_girisi_guncelle", function () {
            let alinan_cekid = "<?=$_GET["cek_id"]?>";
            let ozel_kod = $("#ozel_kod_second_guncelle").val();
            let seri_no = $("#seri_no_guncelle").val();
            let cari_id = "<?=$_GET["cari_id"]?>";
            let kayit_id = "<?=$_GET["id"]?>";
            let vade_tarih = $("#vade_tarih_guncelle").val();
            let tipi = $("#tipi_guncelle").val();
            let asil_borclu = $("#asil_borclu_guncelle").val();
            let ciro_edilmis = $("#ciro_edilmis_guncelle").val();
            let keside_yeri = $("#keside_yeri_guncelle").val();
            let banka_adi = $("#banka_adi_guncelle").val();
            let banka_sube = $("#banka_subesi_guncelle").val();
            let hesap_no = $("#hesap_no_guncelle").val();
            let girilen_tutar = $("#girilen_tutar_guncelle").val();
            girilen_tutar = girilen_tutar.replace(/\./g, "").replace(",", ".");
            girilen_tutar = parseFloat(girilen_tutar);
            $.ajax({
                url: "controller/senet_controller/sql.php?islem=yeni_alinan_cek_guncelle_sql",
                type: "POST",
                data: {
                    alinan_senetid: alinan_cekid,
                    ozel_kod: ozel_kod,
                    cari_id: cari_id,
                    id: kayit_id,
                    seri_no: seri_no,
                    vade_tarih: vade_tarih,
                    tipi: tipi,
                    asil_borclu: asil_borclu,
                    ciro_edilmis: ciro_edilmis,
                    keside_yeri: keside_yeri,
                    banka_adi: banka_adi,
                    banka_sube: banka_sube,
                    hesap_no: hesap_no,
                    girilen_tutar: girilen_tutar
                },
                success: function (result) {
                    if (result != 2) {
                        var json = JSON.parse(result);
                        cek_table_main.clear().draw(false);
                        let toplam_tutar = 0;
                        let toplam_ana_tutar = 0;
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
                            let bugun = new Date();
                            bugun.setDate(bugun.getDate() - 1);
                            let vade_fark = new Date(vade_tarihi);
                            let fark_ms = vade_fark - bugun;
                            let farkgun = Math.floor(fark_ms / (1000 * 60 * 60 * 24));
                            let net_toplam = farkgun * tutar;
                            net_toplam = parseInt(net_toplam);
                            toplam_tutar += net_toplam;
                            toplam_ana_tutar += tutar;
                            tutar = tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                            vade_tarihi = vade_tarihi[0];
                            vade_tarihi = vade_tarihi.split("-");
                            let gun = vade_tarihi[2];
                            let ay = vade_tarihi[1];
                            let yil = vade_tarihi[0];
                            let arr = [gun, ay, yil];
                            vade_tarihi = arr.join("/");
                            $("#yeni_cek_girisi_olustur_button_modal").attr("data-id", item.alinan_cekid);
                            cek_table_main.row.add([item.seri_no, vade_tarihi, item.asil_borclu, item.ciro_edilmis, tutar, item.keside_yeri, item.banka_adi, item.banka_sube, item.hesap_no, item.ozel_kod, son_durum, bizim_mi, "<button class='btn btn-sm senet_kaydi_guncelle_list_button' style='background-color: #F6FA70' data-id='" + item.id + "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm senet_iptal_list_main' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false);
                        })
                        let vade_gun_fark = toplam_tutar / toplam_ana_tutar;
                        vade_gun_fark = parseInt(vade_gun_fark);
                        $("#ort_gun").val(vade_gun_fark);
                        let farkTarih = new Date();
                        farkTarih.setDate(farkTarih.getDate() + vade_gun_fark);
                        var formattedTarih = farkTarih.toISOString().slice(0, 10);
                        $("#senet_guncelle_baslat_modal").modal("hide");
                        $("#ort_vade").val(formattedTarih);
                        $("#yeni_senet_girisi_olustur_button_modal").prop("disabled", true);
                    }
                }
            });
        });

        $("body").off("change", "#tipi").on("change", "#tipi", function () {
            let tipi = $(this).val();
            if (tipi == "Asıl Borçludan") {
                let asil_borclu = $("#ciro_edilmis").val();
                $("#asil_borclu").val(asil_borclu);
            } else {
                $("#asil_borclu").val("");
            }
        });

    </script>
    <?php
}