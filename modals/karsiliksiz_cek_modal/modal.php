<?php

$islem = $_GET["islem"];

if ($islem == "ciro_edilen_karsiliksiz_cekleri_getir_modal") {
    ?>
    <div class="modal fade" id="ciro_edilen_cek_senetleri_getir"

         data-bs-keyboard="false" role="dialog">

        <div class="modal-dialog"

             style="width: 55%; max-width: 55%;">

            <div class="modal-content">

                <div class="modal-header text-white p-2" style="font-weight: bold">CİRO EDİLEN ÇEK VE SENETLER

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
                    <button class="btn btn-success btn-sm" id="ciro_edilmis_secilen_cek_ve_senetleri_aktar"><i
                                class="fa fa-download"></i> Seçilenler Karşılıksız
                    </button>

                </div>

            </div>

        </div>

    </div>
    <script>
        var cek_ve_senetler_table = "";

        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#ciro_edilen_cek_senetleri_getir").modal("hide");
        })
        $(document).ready(function () {
            setTimeout(function () {
                $("#click124").trigger("click");
            }, 500);
            $("#ciro_edilen_cek_senetleri_getir").modal("show");
            cek_ve_senetler_table = $('#carinini_cek_ve_senetleri_listesi').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                searching: false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row) {
                    $(row).addClass("ciroya_ait_cekler_ve_senetler_selected");
                }
            })

            $.get("controller/cek_senet_controller/sql.php?islem=ciro_edilen_cekleri_getir_sql", {cari_id: "<?=$_GET["cari_id"]?>"}, function (result) {
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
                        $(new_row).attr("alinan_cekid", item.id);
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

        $("body").off("click", "#ciro_edilmis_secilen_cek_ve_senetleri_aktar").on("click", "#ciro_edilmis_secilen_cek_ve_senetleri_aktar", function () {
            let arr = [];
            $(".ciroya_ait_cekler_ve_senetler_selected").each(function () {
                if ($(this).hasClass("cek_secildi")) {
                    let id = $(this).attr("alinan_cekid");
                    let belge_no = $(this).find("td").eq(1).text();
                    let vade_tarihi = $(this).find("td").eq(2).text();
                    let asil_borclu = $(this).find("td").eq(3).text();
                    let ciro_edilen = $(this).find("td").eq(4).text();
                    let tutar = $(this).find("td").eq(5).text();
                    tutar = tutar.replace(/\./g, "").replace(",", ".");
                    tutar = parseFloat(tutar);
                    let keside_yeri = $(this).find("td").eq(6).text();
                    let banka_adi = $(this).find("td").eq(7).text();
                    let sube_adi = $(this).find("td").eq(8).text();
                    let hesap_no = $(this).find("td").eq(9).text();
                    let ozel_kod = $(this).find("td").eq(10).text();
                    let durumu = "Çek Karşılıksız";
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
                            bizim: bizim
                        }
                    );
                } else if ($(this).hasClass("senet_secildi")) {
                    let id = $(this).attr("senet_secildi");
                    let belge_no = $(this).find("td").eq(1).text();
                    let vade_tarihi = $(this).find("td").eq(2).text();
                    let asil_borclu = $(this).find("td").eq(3).text();
                    let ciro_edilen = $(this).find("td").eq(4).text();
                    let tutar = $(this).find("td").eq(5).text();
                    tutar = tutar.replace(/\./g, "").replace(",", ".");
                    tutar = parseFloat(tutar);
                    let keside_yeri = $(this).find("td").eq(6).text();
                    let banka_adi = $(this).find("td").eq(7).text();
                    let sube_adi = $(this).find("td").eq(8).text();
                    let hesap_no = $(this).find("td").eq(9).text();
                    let ozel_kod = $(this).find("td").eq(10).text();
                    let durumu = "Karşılıksız Senet";
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
                            bizim: bizim
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
                if (hasSenetid == true) {

                } else {
                    $.ajax({
                        url:"controller/cek_senet_controller/sql.php?islem=ciro_edilen_cek_karsiliksiz_sql",
                        type:"POST",
                        data:{
                            arr:arr
                        },
                        success:function (result){
                            if (result == 1){
                                $("#ciro_edilen_cek_senetleri_getir").modal("hide");
                                $.get("view/ciro_edilen_cek_karsiliksiz.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                });
                                $.get("view/ciro_edilen_cek_karsiliksiz.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                });
                            }
                        }
                    });
                }
            }
        })
    </script>
    <?php
}
if ($islem == "tahsilata_verilen_cekleri_getir_modal") {
    ?>
    <div class="modal fade" id="tahsile_verilen_cek_ve_senetleri_getir"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 55%; max-width: 55%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2" style="font-weight: bold">TAHSİLE VERİLEN ÇEK VE SENETLER
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
                    <button class="btn btn-success btn-sm" id="tahsile_verilip_secilmis_cek_ve_senetleri_aktar"><i
                                class="fa fa-download"></i> Seçilenler Karşılıksız
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var cek_ve_senetler_table = "";
        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#tahsile_verilen_cek_ve_senetleri_getir").modal("hide");
        })
        $(document).ready(function () {
            setTimeout(function () {
                $("#click124").trigger("click");
            }, 500);
            $("#tahsile_verilen_cek_ve_senetleri_getir").modal("show");
            cek_ve_senetler_table = $('#carinini_cek_ve_senetleri_listesi').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                searching: false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row) {
                    $(row).addClass("tahsile_ait_cekler_ve_senetler_selected");
                }
            })

            $.get("controller/cek_senet_controller/sql.php?islem=tahsile_verilen_cekleri_getir_sql", {cari_id: "<?=$_GET["cari_id"]?>"}, function (result) {
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
                        $(new_row).attr("alinan_cekid", item.id);
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

        $("body").off("click", "#tahsile_verilip_secilmis_cek_ve_senetleri_aktar").on("click", "#tahsile_verilip_secilmis_cek_ve_senetleri_aktar", function () {
            let arr = [];
            let toplam_tutar_cek = 0;
            let toplam_ana_tutar_cek = 0;
            let toplam_tutar_senet = 0;
            let toplam_ana_tutar_senet = 0;
            $(".tahsile_ait_cekler_ve_senetler_selected").each(function () {
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
                if (hasSenetid == true) {

                } else {
                    $.ajax({
                        url:"controller/cek_senet_controller/sql.php?islem=tahsile_verilen_cek_karsiliksiz_sql",
                        type:"POST",
                        data:{
                            arr:arr
                        },
                        success:function (result){
                            if (result == 1){
                                $("#tahsile_verilen_cek_ve_senetleri_getir").modal("hide");
                                $.get("view/tahsile_verilen_cek_karsiliksiz.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                });
                                $.get("view/tahsile_verilen_cek_karsiliksiz.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                });
                            }
                        }
                    });
                }
                $("#tahsile_verilen_cek_ve_senetleri_getir").modal("hide");
            }

        })
    </script>
    <?php
}
if ($islem == "teminata_verilen_cekleri_getir_modal") {
    ?>
    <div class="modal fade" id="teminata_verilen_cek_ve_senetleri_getir"

         data-bs-keyboard="false" role="dialog">

        <div class="modal-dialog"

             style="width: 55%; max-width: 55%;">

            <div class="modal-content">

                <div class="modal-header text-white p-2" style="font-weight: bold">TEMİNATA VERİLEN ÇEK VE SENETLER

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
                    <button class="btn btn-success btn-sm" id="teminata_verilip_secilmis_cek_ve_senetleri_aktar"><i

                                class="fa fa-download"></i> Seçilenler Karşılıksız

                    </button>

                </div>

            </div>

        </div>

    </div>
    <script>
        var cek_ve_senetler_table = "";

        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#teminata_verilen_cek_ve_senetleri_getir").modal("hide");
        })
        $(document).ready(function () {
            setTimeout(function () {
                $("#click124").trigger("click");
            }, 500);
            $("#teminata_verilen_cek_ve_senetleri_getir").modal("show");
            cek_ve_senetler_table = $('#carinini_cek_ve_senetleri_listesi').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                searching: false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row) {
                    $(row).addClass("teminata_ait_cekler_ve_senetler_selected");
                }
            })

            $.get("controller/cek_senet_controller/sql.php?islem=teminata_verilen_cekleri_getir_sql", {cari_id: "<?=$_GET["cari_id"]?>"}, function (result) {
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
                        $(new_row).attr("alinan_cekid", item.id);
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

        $("body").off("click", "#teminata_verilip_secilmis_cek_ve_senetleri_aktar").on("click", "#teminata_verilip_secilmis_cek_ve_senetleri_aktar", function () {
            let arr = [];
            let toplam_tutar_cek = 0;
            let toplam_ana_tutar_cek = 0;
            let toplam_tutar_senet = 0;
            let toplam_ana_tutar_senet = 0;
            $(".teminata_ait_cekler_ve_senetler_selected").each(function () {
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
                if (hasSenetid == true) {

                } else {
                    $.ajax({
                        url:"controller/cek_senet_controller/sql.php?islem=teminata_verilen_cek_karsiliksiz_sql",
                        type:"POST",
                        data:{
                            arr:arr
                        },
                        success:function (result){
                            if (result == 1){
                                $("#teminata_verilen_cek_ve_senetleri_getir").modal("hide");
                                $.get("view/teminata_verilen_cek_karsiliksiz.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                });
                                $.get("view/teminata_verilen_cek_karsiliksiz.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                });
                            }
                        }
                    });
                }
                $("#teminata_verilen_cek_ve_senetleri_getir").modal("hide");
            }

        })
    </script>
    <?php
}
if ($islem == "portfoydeki_cek_karsiliksiz") {
    ?>
    <div class="modal fade" id="portfoydeki_cek_ve_senetleri_getir"

         data-bs-keyboard="false" role="dialog">

        <div class="modal-dialog"

             style="width: 55%; max-width: 55%;">

            <div class="modal-content">

                <div class="modal-header text-white p-2" style="font-weight: bold">PORTFÖYDEKİ ÇEK VE SENETLER

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
                    <button class="btn btn-success btn-sm" id="portfoydeki_secilmis_cek_ve_senetleri_aktar"><i

                                class="fa fa-download"></i> Seçilenler Karşılıksız

                    </button>

                </div>

            </div>

        </div>

    </div>
    <script>
        var cek_ve_senetler_table = "";

        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#portfoydeki_cek_ve_senetleri_getir").modal("hide");
        })
        $(document).ready(function () {
            setTimeout(function () {
                $("#click124").trigger("click");
            }, 500);
            $("#portfoydeki_cek_ve_senetleri_getir").modal("show");
            cek_ve_senetler_table = $('#carinini_cek_ve_senetleri_listesi').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                searching: false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row) {
                    $(row).addClass("portfoye_ait_cekler_ve_senetler_selected");
                }
            })
            $.get("controller/cek_senet_controller/sql.php?islem=portfoydeki_cekleri_getir_sql", {cari_id: "<?=$_GET["cari_id"]?>"}, function (result) {
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
                        $(new_row).attr("alinan_cekid", item.id);
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

        $("body").off("click", "#portfoydeki_secilmis_cek_ve_senetleri_aktar").on("click", "#portfoydeki_secilmis_cek_ve_senetleri_aktar", function () {
            let arr = [];
            let toplam_tutar_cek = 0;
            let toplam_ana_tutar_cek = 0;
            let toplam_tutar_senet = 0;
            let toplam_ana_tutar_senet = 0;
            $(".portfoye_ait_cekler_ve_senetler_selected").each(function () {
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
                if (hasSenetid == true) {

                } else {
                    $.ajax({
                        url:"controller/cek_senet_controller/sql.php?islem=portfoydeki_cek_karsiliksiz_sql",
                        type:"POST",
                        data:{
                            arr:arr
                        },
                        success:function (result){
                            if (result == 1){
                                $("#portfoydeki_cek_ve_senetleri_getir").modal("hide");
                                $.get("view/portfoydeki_karsiliksiz_cek.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                });
                                $.get("view/portfoydeki_karsiliksiz_cek.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                });
                            }
                        }
                    });
                }
                $("#portfoydeki_cek_ve_senetleri_getir").modal("hide");
            }

        })
    </script>
    <?php
}
?>