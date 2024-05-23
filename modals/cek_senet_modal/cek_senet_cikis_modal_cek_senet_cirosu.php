<?php

$islem = $_GET["islem"];

if ($islem == "cek_senet_cirosu_guncelle") {
    ?>
    <style>
        #yeni_cek_senet_cikis_guncelle_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="yeni_cek_senet_cikis_guncelle_modal" data-backdrop="static" data-bs-keyboard="false"
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
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ÇEK ÇIKIŞ CİROSU
                                GÜNCELLE
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="yeni_cek_cikisi"></div>
                            <div class="yeni_cek_icin_cari"></div>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("body").off("click",".cek_senet_icin_cari_getir").on("click",".cek_senet_icin_cari_getir",function (){
            $.get("modals/cek_senet_modal/another_modal.php?islem=carileri_getir_modal",function (getModal){
                $(".yeni_cek_icin_cari").html("");
                $(".yeni_cek_icin_cari").html(getModal);
            })
        });
        $("body").off("click", "#cek_senet_vazgec_main").on("click", "#cek_senet_vazgec_main", function () {
            $("#yeni_cek_senet_cikis_guncelle_modal").modal("hide");
        })

        var cek_table_cikis_main = "";
        $("body").off("click", "#alinan_cek_cikisi_onayla").on("click", "#alinan_cek_cikisi_onayla", function () {
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
            $.ajax({
                url: "controller/cek_senet_controller/sql.php?islem=cek_senet_cikis_guncelle_sql",
                type: "POST",
                data: {
                    cari_id: cari_id,
                    tarih: tarih,
                    id:"<?=$_GET["id"]?>",
                    belge_no: belge_no,
                    doviz_kuru: doviz_kuru,
                    doviz_tur: doviz_tur,
                    ort_vade: ort_vade,
                    ort_gun: ort_gun,
                    mutabakat: mutabakat,
                    ozel_kod1: ozel_kod1,
                    ozel_kod2: ozel_kod2,
                    aciklama: aciklama
                },
                success: function (result) {
                    if (result == 1) {
                        $("#yeni_cek_senet_cikis_guncelle_modal").modal("hide");
                        $.get("view/cek_senet_cikis_bordrosu.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                        $.get("view/cek_senet_cikis_bordrosu.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                    } else {
                        $("#yeni_cek_senet_cikis_guncelle_modal").modal("hide");
                    }
                }
            })
        })

        $(document).ready(function () {

            $.get("controller/cek_senet_controller/sql.php?islem=alinan_cikis_cek_ana_bilgiler_sql", {id: "<?=$_GET["id"]?>"}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    let tarih = item.tarih;
                    tarih = tarih.split(" ");
                    let vade = item.ort_vade;
                    vade = vade.split(" ");
                    $("#cek_senet_cikis_cariid").attr("data-id",item.cari_id);
                    $("#cari_adi_cek_senet").val(item.cari_adi);
                    $("#cek_senet_tarih").val(tarih[0]);
                    $("#cek_senet_belge_no").val(item.belge_no);
                    $(".doviz_kuru_cek_senet").val(item.doviz_kuru);
                    $(".doviz_tur_cek_senet").val(item.doviz_tur);
                    $("#ort_vade").val(vade[0]);
                    $("#ort_gun").val(item.ort_gun);
                    $("#mutabakat").val(item.mutabakat);
                    $("#ozel_kod1_ceksenet").val(item.ozel_kod1);
                    $("#ozel_kod2_ceksenet").val(item.ozel_kod2);
                    $("#cek_senet_aciklama").val(item.aciklama);
                    $("#cari_tel").val(item.telefon);

                    $("#cari_adi_cek_senet").val()
                    $("#cek_senet_cikis_cariid").val(item.cari_kodu);
                    $("#cari_yetkili").val(item.yetkili_adi1);
                    $("#yetkili_tel").val(item.yetkili_tel1);
                    $("#vergi_dairesi").val(item.vergi_dairesi);
                    $("#vergi_no").val(item.vergi_no);
                    $("#cari_adres").val(item.adres.toUpperCase());
                }
            })

            $.get("controller/cek_senet_controller/sql.php?islem=cek_senet_bilgilerini_getir_cikis", {id: "<?=$_GET["id"]?>"}, function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
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
                        tutar = tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                        vade_tarihi = vade_tarihi[0];
                        vade_tarihi = vade_tarihi.split("-");
                        let gun = vade_tarihi[2];
                        let ay = vade_tarihi[1];
                        let yil = vade_tarihi[0];
                        let arr = [gun, ay, yil];
                        vade_tarihi = arr.join("/");
                        $("#yeni_cek_girisi_olustur_button_modal").attr("data-id", item.alinan_cekid);
                        cek_table_cikis_main.row.add([item.seri_no, vade_tarihi, item.asil_borclu, item.ciro_edilmis, tutar, item.keside_yeri, item.banka_adi, item.banka_sube, item.hesap_no, item.ozel_kod, son_durum, bizim_mi, "<button class='btn btn-danger btn-sm' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false);
                    })
                }
            });

            $("body").off("click", ".cek_iptal_cikis_main").on("click", ".cek_iptal_cikis_main", function () {
                let id = $(this).attr("data-id");
                let closest = $(this).closest("tr");
                $.ajax({
                    url: "controller/cek_senet_controller/sql.php?islem=cek_cikisi_iptal_et_sql",
                    type: "POST",
                    data: {
                        id: id
                    },
                    success: function (result) {
                        if (result == 1) {
                            cek_table_cikis_main.row(closest).remove().draw(false);
                            let toplam_tutar = 0;
                            let toplam_ana_tutar = 0;
                            $(".cek_senet_cikis_table").each(function () {
                                let vade_tarih = $(this).find("td").eq(1).text();
                                vade_tarih = vade_tarih.split("/");
                                let yeni_tarih = vade_tarih[2] + "-" + vade_tarih[1] + "-" + vade_tarih[0]
                                let tutar = $(this).find("td").eq(4).text();
                                tutar = parseFloat(tutar);
                                let bugun = new Date();
                                bugun.setDate(bugun.getDate() - 1);
                                let vade_fark = new Date(yeni_tarih);
                                let fark_ms = vade_fark - bugun;
                                let farkgun = Math.floor(fark_ms / (1000 * 60 * 60 * 24));
                                let net_toplam = farkgun * tutar;
                                net_toplam = parseInt(net_toplam);
                                if (isNaN(net_toplam)){
                                    net_toplam = 0;
                                }
                                toplam_tutar += net_toplam;
                                toplam_ana_tutar += tutar;
                                tutar = tutar.toLocaleString("tr-TR", {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            });
                            let vade_gun_fark = toplam_tutar / toplam_ana_tutar;
                            vade_gun_fark = parseInt(vade_gun_fark);
                            $("#ort_gun").val(vade_gun_fark);
                            let farkTarih = new Date();
                            farkTarih.setDate(farkTarih.getDate() + vade_gun_fark);
                            var formattedTarih = farkTarih.toISOString().slice(0, 10);
                            $("#ort_vade").val(formattedTarih);
                        }
                    }
                })
            });

            setTimeout(function () {
                $("#click_me2").trigger("click");
            }, 500);

            $("#yeni_cek_senet_cikis_guncelle_modal").modal("show");
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
                $("#cek_senet_listesi_cikis_modal_button").prop("disabled", false);
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