<?php

$islem = $_GET["islem"];

if ($islem == "cek_senet_cikisi_ekle_main_modal") {
    ?>
    <style>
        #yeni_cek_senet_cikis_olustur_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="yeni_cek_senet_cikis_olustur_modal" data-backdrop="static" data-bs-keyboard="false"
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
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ÇEK ÇIKIŞ CİROSU</div>
                        </div>
                        <div class="modal-body">
                            <div class="yeni_cek_cikisi"></div>
                            <div class="yeni_cek_icin_cari"></div>
                            <div class="kendi_ceklerimiz_cikisi"></div>
                            <div class="cek_guncelleme_modali_cikis"></div>
                            <div class="col-12 mx-1 row no-gutteras" style="border: 1px solid #000">
                                <div class="col-6 mt-2">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Cari Kodu</label>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="cek_senet_cikis_cariid">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm cek_senet_icin_cari_getir"><i
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
                                       id="cek_senet_cikis_kalem_table">
                                    <thead>
                                    <tr>
                                        <th id="click_me2">Belge No</th>
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
                                <button class="btn btn-success btn-sm" id="alinan_cek_cikisi_onayla"><i
                                            class="fa fa-check"></i>Kaydet
                                </button>
                                <div class="btn-group" role="group">
                                    <button id="btnGroupVerticalDrop1" type="button"
                                            class="btn btn-primary dropdown-toggle btn-sm btngrouplock"
                                            data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                        Kendi Çekimiz <i class="fa fa-angle-down arrow"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" id="kendi_cekimizi_olustur_cikis_modal" href="#">Kendi
                                            Çekimiz</a>
                                    </div>
                                </div>
                                <button class="btn btn-info btn-sm" id="cek_senet_listesi_cikis_modal_button"><i
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
        var cek_table_cikis_main = "";
        $("body").off("click", ".cek_senet_icin_cari_getir").on("click", ".cek_senet_icin_cari_getir", function () {
            $.get("modals/cek_senet_modal/another_modal.php?islem=carileri_getir_modal", function (getModal) {
                $(".yeni_cek_icin_cari").html("");
                $(".yeni_cek_icin_cari").html(getModal);
            })
        });
        $("body").off("click", "#kendi_cekimizi_olustur_cikis_modal").on("click", "#kendi_cekimizi_olustur_cikis_modal", function () {
            let cari_id = $("#cek_senet_cikis_cariid").attr("data-id");
            if (cari_id == "" || cari_id == undefined) {
                Swal.fire(
                    'Uyarı!',
                    'Lütfen Bir Cari Seçiniz...',
                    'warning'
                );
            } else {
                $.get("modals/cek_senet_modal/cek_senet_cikis_modal.php?islem=kendi_ceklerimizi_olustur", {cari_id: cari_id}, function (getModal) {
                    $(".kendi_ceklerimiz_cikisi").html("");
                    $(".kendi_ceklerimiz_cikisi").html(getModal);
                })
            }
        });

        $("body").off("click", ".bizim_ceki_iptal_et_sql").on("click", ".bizim_ceki_iptal_et_sql", function () {
            let id = $(this).attr("data-id");
            let closest = $(this).closest("tr");
            $.ajax({
                url: "controller/cek_senet_controller/sql.php?islem=kendi_cekimizi_iptal_et_sql",
                type: "POST",
                data: {
                    id: id
                },
                success: function (result) {
                    if (result == 1) {
                        cek_table_cikis_main.row(closest).remove().draw();
                        $("#cek_senet_listesi_cikis_modal_button").prop("disabled", false);
                        $("#kendi_cekimizi_olustur_cikis_modal").attr("data-id", "");
                    }
                }
            })
        });

        $("body").off("click", "#alinan_cek_cikisi_onayla").on("click", "#alinan_cek_cikisi_onayla", function () {
            var arr = [];
            let kendi_cekimiz_mi = $("#kendi_cekimizi_olustur_cikis_modal").attr("data-id");
            $(".cek_senet_cikis_table").each(function () {
                let islem = $(this).attr("data-name");
                if (islem == "cek_senet_cirosu") {
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
            let cari_id = $("#cek_senet_cikis_cariid").attr("data-id");
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
            if (kendi_cekimiz_mi == "" || kendi_cekimiz_mi == undefined) {
                $.ajax({
                    url: "controller/cek_senet_controller/sql.php?islem=cek_senet_cikis_kaydet_sql",
                    type: "POST",
                    data: {
                        cari_id: cari_id,
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
                            $("#yeni_cek_senet_cikis_olustur_modal").modal("hide");
                            $.get("view/cek_senet_cikis_bordrosu.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                            $.get("view/cek_senet_cikis_bordrosu.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            Swal.fire(
                                'Başarılı',
                                'Çek Kaydedildi',
                                'success'
                            );
                        } else {
                            $("#yeni_cek_senet_cikis_olustur_modal").modal("hide");
                        }
                    }
                })
            } else {
                $.ajax({
                    url: "controller/cek_senet_controller/sql.php?islem=kendi_cekimizin_bilgilerini_guncelle",
                    type: "POST",
                    data: {
                        cari_id: cari_id,
                        tarih: tarih,
                        belge_no: belge_no,
                        id: kendi_cekimiz_mi,
                        doviz_kuru: doviz_kuru,
                        doviz_turu: doviz_tur,
                        ort_vade: ort_vade,
                        ort_gun: ort_gun,
                        mutabakat: mutabakat,
                        ozel_kod1: ozel_kod1,
                        ozel_kod2: ozel_kod2,
                        aciklama: aciklama
                    },
                    success: function (result) {
                        if (result == 1) {
                            $("#yeni_cek_senet_cikis_olustur_modal").modal("hide");
                            $.get("view/cek_senet_cikis_bordrosu.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                            $.get("view/cek_senet_cikis_bordrosu.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            Swal.fire(
                                'Başarılı',
                                'Çek Kaydedildi',
                                'success'
                            );
                        } else {
                            $("#yeni_cek_senet_cikis_olustur_modal").modal("hide");
                        }
                    }
                });
            }

        })

        $("body").off("click", "#cek_senet_vazgec_main").on("click", "#cek_senet_vazgec_main", function () {
            let kendi_cekimiz_mi = $("#kendi_cekimizi_olustur_cikis_modal").attr("data-id");
            if (kendi_cekimiz_mi == "" || kendi_cekimiz_mi == undefined) {
                $("#yeni_cek_senet_cikis_olustur_modal").modal("hide");
            } else {
                $.ajax({
                    url: "controller/cek_senet_controller/sql.php?islem=kendi_cekimiz_vazgec_sql",
                    type: "POST",
                    data: {
                        id: kendi_cekimiz_mi
                    },
                    success: function (result) {
                        if (result == 1) {
                            $("#yeni_cek_senet_cikis_olustur_modal").modal("hide");
                        } else {
                            $("#yeni_cek_senet_cikis_olustur_modal").modal("hide");
                        }
                    }
                })
            }
        });

        $(document).ready(function () {
            setTimeout(function () {
                $("#click_me2").trigger("click");
            }, 500);

            $("#yeni_cek_senet_cikis_olustur_modal").modal("show");
            $.get("controller/alis_controller/sql.php?islem=guncel_kurlar", function (result) {
                var item = JSON.parse(result);
                var usd = item.USD[0];
                var eur = item.EUR[0];
                var gbp = item.GBP[0];
                $("#usd_bas").attr("usd", usd);
                $("#eur_bas").attr("eur", eur);
                $("#gbp_bas").attr("gbp", gbp);
            });
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
            cek_table_cikis_main = $('#cek_senet_cikis_kalem_table').DataTable({
                scrollY: '30vh',
                scrollX: true,
                "info": false,
                bAutoWidth: false,
                "order": [[0, 'desc']],
                createdRow: function (row) {
                    $(row).addClass("cek_senet_cikis_table");
                    $(row).addClass("cek_senet_kendi_cekler_vade_ort");
                },
                searching: false,
                columnDefs: [
                    {targets: 0, type: "date-eu"}
                ],
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
            })
        })

        $("body").off("click", ".cek_cikis_iptal_et").on("click", ".cek_cikis_iptal_et", function () {
            var row = $(this).closest('tr');
            cek_table_cikis_main.row(row).remove().draw();
            var veriSayisi = cek_table_cikis_main.rows().count();
            if (veriSayisi === 0) {
                $(".btngrouplock").prop("disabled", false);
            }
        })

        $("body").off("click", "#cek_senet_listesi_cikis_modal_button").on("click", "#cek_senet_listesi_cikis_modal_button", function () {
            let cari_id = $("#cek_senet_cikis_cariid").attr("data-id");
            if (cari_id == "" || cari_id == undefined) {
                Swal.fire(
                    'Uyarı!',
                    'Lütfen Bir Cari Seçiniz...',
                    'warning'
                );
            } else {
                $.get("modals/cek_senet_modal/cek_senet_cikis_modal.php?islem=kesilen_giris_ceklerini_getir_list_modal", {cari_id: cari_id}, function (getModal) {
                    $(".yeni_cek_cikisi").html("");
                    $(".yeni_cek_cikisi").html(getModal);
                })
            }
        });

        $("#cek_senet_cikis_cariid").keyup(function () {
            let cari_kodu = $(this).val();
            $.get("controller/alis_controller/sql.php?islem=girilen_cari_kodu_bilgileri", {cari_kodu: cari_kodu}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#cari_tel").val(item.telefon);
                    $("#cari_adi_cek_senet").val(item.cari_adi)
                    $("#cek_senet_cikis_cariid").val(item.cari_kodu);
                    $("#cek_senet_cikis_cariid").attr("data-id", item.id);
                    $("#cari_yetkili").val(item.yetkili_adi1);
                    $("#yetkili_tel").val(item.yetkili_tel1);
                    $("#vergi_dairesi").val(item.vergi_dairesi);
                    $("#vergi_no").val(item.vergi_no);
                    $("#cari_adres").val(item.adres.toUpperCase());
                } else {
                    $("#cari_tel").val("");
                    $("#cari_yetkili").val("");
                    $("#cek_senet_cikis_cariid").attr("data-id", "");
                    $("#yetkili_tel").val("");
                    $("#vergi_dairesi").val("");
                    $("#vergi_no").val("");
                    $("#cari_adres").val("");
                }
            })
        })
    </script>
    <?php
}
if ($islem == "kesilen_giris_ceklerini_getir_list_modal") {
    ?>
    <div class="modal fade" id="cariye_ait_girilen_cekleri_getir"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 55%; max-width: 55%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2" style="font-weight: bold">CARİYE AİT ÇEKLER
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
            $("#cariye_ait_girilen_cekleri_getir").modal("hide");
        })
        $(document).ready(function () {
            setTimeout(function () {
                $("#click124").trigger("click");
            }, 500);
            $("#cariye_ait_girilen_cekleri_getir").modal("show");
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

            $.get("controller/cek_senet_controller/sql.php?islem=cekler_ve_senetleri_cikis_icin_getir_sql", {cari_id: "<?=$_GET["cari_id"]?>"}, function (result) {
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
                    let durumu = "Ciro Edildi"
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
                cek_table_cikis_main.clear().draw(false);
                arr.forEach(function (item) {
                    let girilen_tutar = item.girilen_tutar;
                    girilen_tutar = parseFloat(girilen_tutar);
                    girilen_tutar = girilen_tutar.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });
                    let table = cek_table_cikis_main.row.add([item.seri_no, item.vade_tarih, item.asil_borclu, item.ciro_edilen, girilen_tutar, item.keside_yeri, item.banka_adi, item.hesap_no, item.sube_adi, item.ozel_kod, item.son_durum, item.bizim, "</button> <button class='btn btn-danger btn-sm cek_cikis_iptal_et'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                    $(table).attr("data-name", "cek_senet_cirosu");
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
                $("#cariye_ait_girilen_cekleri_getir").modal("hide");
                $(".btngrouplock").prop("disabled", true);
            }

        })
    </script>
    <?php
}
if ($islem == "kendi_ceklerimizi_olustur") {
    ?>
    <div class="modal fade" id="kendi_cekimizi_ver_modal_main"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2" style="font-weight: bold">BİZE AİT ÇEK VER
                    <button type="button" class="btn-close btn-close-white" id="vazgec_button_kendi_cek"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="kendi_ceklerimiz_bankalari"></div>
                    <div class="bankamiza_ait_kocanlar_div"></div>
                    <div class="col-12 row">
                        <div class="col-6">
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Vadesi</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="date" value="<?= date("Y-m-d") ?>" class="form-control form-control-sm"
                                           id="bizim_cek_vade">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Tutar</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" style="text-align: right" class="form-control form-control-sm"
                                           id="bizim_cektutar">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Keşide Yeri</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="bizim_cek_kesideyeri">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Açıklama</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="bizim_cekaciklama">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Özel Kod</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="bizim_cekozelkod">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group row">
                                <div class="col-5">
                                    <label>Banka Kodu</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="banka_kodu">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm" id="kendi_ceklerimiz_icin_bankalar">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-5">
                                    <label>Banka Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" disabled class="form-control form-control-sm" id="banka_adi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-5">
                                    <label>Seri No</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="bizim_cek_seri_no">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm"
                                                    id="kendi_ceklerimizi_getir_main_button"><i
                                                        class="fa fa-ellipsis-h"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-5">
                                    <label>Şube</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="banka_sube">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-5">
                                    <label>Hesap No</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="banka_hesap_no">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger btn-sm" id="vazgec_button_kendi_cek"><i class="fa fa-close"></i>
                            Vazgeç
                        </button>
                        <button class="btn btn-success btn-sm" id="kendi_ceklerimize_ekle"><i class="fa fa-check"></i>
                            Kaydet
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("body").off("click", "#kendi_ceklerimiz_icin_bankalar").on("click", "#kendi_ceklerimiz_icin_bankalar", function () {
            $.get("modals/cek_senet_modal/another_modal.php?islem=bankalarimizi_getir", function (getModal) {
                $(".kendi_ceklerimiz_bankalari").html("");
                $(".kendi_ceklerimiz_bankalari").html(getModal);
            })
        })

        $(document).ready(function () {
            $("#kendi_cekimizi_ver_modal_main").modal("show");
        })

        $("body").off("click", "#kendi_ceklerimizi_getir_main_button").on("click", "#kendi_ceklerimizi_getir_main_button", function () {
            let banka_id = $("#banka_kodu").attr("data-id");
            $.get("modals/cek_senet_modal/another_modal.php?islem=bankaya_ait_cek_kocanlari_getir", {banka_id: banka_id}, function (getModal) {
                $(".bankamiza_ait_kocanlar_div").html("");
                $(".bankamiza_ait_kocanlar_div").html(getModal);
            })
        })

        $("#bizim_cektutar").focusout(function () {
            var value = $(this).val();
            value = value.replace(/\./g, "").replace(",", ".");
            value = parseFloat(value);
            if (isNaN(value)) {
                value = 0;
            }
            value = value.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
            $(this).val(value);
        })

        function gunSayisiBul(baslangic, bitis) {
            var baslangicTarih = new Date(baslangic);
            var bitisTarih = new Date(bitis);
            var gunFarki = Math.abs(bitisTarih - baslangicTarih);
            var gunSayisi = Math.ceil(gunFarki / (1000 * 60 * 60 * 24));
            return gunSayisi;
        }

        $("body").off("click", "#kendi_ceklerimize_ekle").on("click", "#kendi_ceklerimize_ekle", function () {
            let seri_no = $("#bizim_cek_seri_no").val();
            seri_no = seri_no.match(/\d+/);
            seri_no = seri_no[0];
            let vade_tarih = $("#bizim_cek_vade").val();
            let tutar = $("#bizim_cektutar").val();
            tutar = tutar.replace(/\./g, "").replace(",", ".");
            tutar = parseFloat(tutar);
            let keside_yeri = $("#bizim_cek_kesideyeri").val();
            let aciklama = $("#bizim_cekaciklama").val();
            let banka_id = $("#banka_kodu").attr("data-id");
            let cari_id = $("#cek_senet_cikis_cariid").attr("data-id");
            let ozel_kod = $("#bizim_cekozelkod").val();
            let bizim_cekid = $("#kendi_cekimizi_olustur_cikis_modal").attr("data-id");
            if (banka_id == "" || banka_id == undefined) {
                Swal.fire(
                    'Uyarı!',
                    'Lütfen Bir Banka Seçiniz...',
                    'warning'
                );
            } else {
                $.ajax({
                    url: "controller/cek_senet_controller/sql.php?islem=bize_ait_cek_olustur_sql",
                    type: "POST",
                    data: {
                        seri_no: seri_no,
                        cari_id: cari_id,
                        vade_tarih: vade_tarih,
                        tutar: tutar,
                        bizim_cekid: bizim_cekid,
                        keside_yeri: keside_yeri,
                        aciklama: aciklama,
                        banka_id: banka_id,
                        ozel_kod: ozel_kod
                    },
                    success: function (result) {
                        if (result != 2) {
                            var json = JSON.parse(result);
                            cek_table_cikis_main.clear().draw(false);
                            json.forEach(function (item) {
                                $("#kendi_cekimizi_olustur_cikis_modal").attr("data-id", item.bizim_cekid);
                                let vade_tarih = item.vade_tarih;
                                vade_tarih = vade_tarih.split(" ");
                                vade_tarih = vade_tarih[0];
                                vade_tarih = vade_tarih.split("-");
                                let gun = vade_tarih[2];
                                let ay = vade_tarih[1];
                                let yil = vade_tarih[0];
                                let arr = [gun, ay, yil];
                                vade_tarih = arr.join("/");
                                let girilen_tutar = item.tutar;
                                girilen_tutar = parseFloat(girilen_tutar);
                                girilen_tutar = girilen_tutar.toLocaleString("tr-TR", {
                                    maximumFractionDigits: 2,
                                    minimumFractionDigits: 2
                                });
                                let ciro_edilen = $("#cari_adi_cek_senet").val();
                                let table = cek_table_cikis_main.row.add([item.seri_no, vade_tarih, "BİZ", ciro_edilen, girilen_tutar, item.keside_yeri, item.banka_adi, item.hesap_no, item.sube_adi, item.ozel_kod, "CİRO EDİLDİ", "BİZİM", "</button> <button class='btn btn-danger btn-sm bizim_ceki_iptal_et_sql' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                                $(table).attr("alinan_cekid", item.bizim_cekid);
                                let bugun = "<?=date("Y-m-d")?>";
                                let toplam_gun = 0;
                                let toplam_borc = 0;
                                let toplam_k_borc = 0;
                                $(".cek_senet_kendi_cekler_vade_ort").each(function () {
                                    let vade_tarihi = $(this).find("td").eq(1).text();
                                    vade_tarihi = vade_tarihi.split("/");
                                    let gun = vade_tarihi[0];
                                    let ay = vade_tarihi[1];
                                    let yil = vade_tarihi[2];
                                    let arr = [yil, ay, gun];
                                    vade_tarihi = arr.join("-");
                                    let gunSayisi = gunSayisiBul(bugun, vade_tarihi);
                                    toplam_gun += gunSayisi;
                                    let borc = $(this).find("td").eq(4).text();
                                    borc = borc.replace(/\./g, "").replace(",", ".")
                                    borc = parseFloat(borc);
                                    let toplamb = borc * gunSayisi;
                                    toplam_borc += toplamb;
                                    toplam_k_borc += borc;
                                });
                                let vade_gunu = toplam_borc / toplam_k_borc;
                                vade_gunu = parseInt(vade_gunu);
                                var bugun_tarih = new Date();
                                bugun_tarih.setDate(bugun_tarih.getDate() + vade_gunu);
                                var yeniTarih = bugun_tarih.toISOString().slice(0, 10);
                                $("#ort_vade").val(yeniTarih);
                                $("#ort_gun").val(vade_gunu);
                                $("#cek_senet_listesi_cikis_modal_button").prop("disabled", true);
                                $("#kendi_cekimizi_ver_modal_main").modal("hide");
                            });
                        }
                    }
                });
            }
        });


        $("body").off("click", "#vazgec_button_kendi_cek").on("click", "#vazgec_button_kendi_cek", function () {
            $("#kendi_cekimizi_ver_modal_main").modal("hide");

        });

        $("#banka_kodu").keyup(function () {
            let val = $(this).val();
            $.get("controller/banka_controller/sql.php?islem=banka_kodu_bilgileri_sql", {banka_kodu: val}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $.get("controller/cek_senet_controller/sql.php?islem=bankaya_ait_ceklerimizi_getir_sql", {banka_id: item.id}, function (response) {
                        if (response != 2) {
                            var item1 = JSON.parse(response);
                            let baslangic_kodu = item1.cek_baslangic_no;
                            var harfVarMi = /[a-zA-Z]/.test(baslangic_kodu);
                            let metinsel_degerler = "";
                            if (harfVarMi){
                                metinsel_degerler = baslangic_kodu.match(/[a-zA-Z]/g).join("");
                            }
                            $("#bizim_cek_seri_no").val(metinsel_degerler + (item1.cek_no))
                        }
                    });

                    $("#banka_sube").val(item.sube_adi);
                    $("#banka_hesap_no").val(item.hesap_no);
                    $("#banka_adi").val(item.banka_adi);
                    $("#banka_kodu").attr("data-id", item.id);
                    $("#banka_kodu").val(item.banka_kodu);
                } else {
                    $("#banka_sube").val("");
                    $("#banka_hesap_no").val("");
                    $("#banka_adi").val("");
                    $("#banka_kodu").attr("data-id", "");
                    $("#seri_no").val("");
                }
            })
        });
    </script>
    <?php
}