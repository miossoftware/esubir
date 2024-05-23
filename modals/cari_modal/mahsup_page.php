<?php

$islem = $_GET["islem"];
if ($islem == "mahsup_bilgileri_getir") {
    ?>
    <style>
        #cari_mahsup_fisi_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="cari_mahsup_fisi_modal" data-bs-keyboard="false"
         role="dialog">
    <div class="modal-dialog" style="width: 75%; max-width: 75%;">
        <div class="modal-content">
            <div class="modal-header text-white p-2">
                <button type="button" class="btn-close btn-close-white" id="mahsup_vazgec_cari"
                        aria-label="Close"></button>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head" style='background-color:#9DB2BF'>
                        <div class="ibox-title" style='color:white; font-weight:bold;'>MAHSUP FİŞİ</div>
                    </div>
                    <div class="modal-body">
                        <div class="mahsup_cari_getir_div"></div>
                        <div class="col-12 row">
                            <label style="font-weight: bold;font-size: 13px">&nbsp;&nbsp;Mahsup Fiş Bilgileri</label>
                            <div class="col-12 row mt-2 no-gutters">
                                <div class="col-md-1">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;İşlem Tarihi</label>
                                    <div class="input-group">
                                        <input type="date" value="<?= date("Y-m-d") ?>"
                                               class="form-control form-control-sm" id="islem_tarihi">
                                    </div>
                                </div>
                                <div class="col-md-1 mx-3">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;Döviz Türü</label>
                                    <select class="custom-select custom-select-sm" id="doviz_tur_mahsup">
                                        <option value="">Seçiniz...</option>
                                        <option value="TL" selected>TL</option>
                                        <option value="USD" id="usd_bas">USD</option>
                                        <option value="EURO" id="eur_bas">EURO</option>
                                        <option value="GBP" id="gbp_bas">GBP</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label style="font-size: 10px; font-weight: bold">&nbsp;Döviz Kuru</label>
                                    <input type="number" class="form-control form-control-sm" placeholder="Döviz Kuru"
                                           id="doviz_kur_mahsup" value="1.00">
                                </div>
                                <div class="col-md-1">
                                    <label style="font-size: 10px; font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Belge
                                        No</label>
                                    <input type="text" placeholder="Belge No"
                                           class="form-control form-control-sm mx-3" id="belge_no">
                                </div>
                                <div class="col-md-1 mx-2">
                                    <label style="font-size: 10px; font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Özel
                                        Kod</label>
                                    <input type="text" placeholder="Özel Kod"
                                           class="form-control form-control-sm mx-3" id="ozel_kod">
                                </div>
                                <div class="col-md-2">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Açıklama</label>
                                    <input type="text" placeholder="Açıklama"
                                           style=" width: 100%!important;"
                                           class="form-control form-control-sm mx-4" id="ust_aciklama">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 row mt-4 no-gutters">
                            <div class="col-md-2 mt-3">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;Cari Kodu</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm cari_kodu_getir"
                                           placeholder="Cari Kodu">
                                    <div class="input-group-append">
                                        <button class="btn btn-warning btn-sm"
                                                id="cari_adi_getir_mahsup">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 mt-3">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;Cari
                                    Adı</label>
                                <input type="text" disabled
                                       class="form-control form-control-sm mx-2 cari_adi_getir"
                                       placeholder="Cari Adı" id="">
                            </div>
                            <div class="col-md-1 mx-3 mt-3">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Borç</label>
                                <input type="text" style="text-align: right"
                                       class="form-control form-control-sm mx-2 ust_borc ust_borc_sifirla" value="0,00"
                                       placeholder="Borç" id="">
                            </div>
                            <div class="col-md-1 mt-3">
                                <label style="font-size: 10px; font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Alacak</label>
                                <input type="text" placeholder="Alacak" style="text-align: right"
                                       class="form-control form-control-sm mx-3 ust_alacak ust_alacak_sifirla"
                                       value="0,00"
                                       id="mahsup_alacak">
                            </div>
                            <div class="col-md-2 mt-3">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Açıklama</label>
                                <input type="text" placeholder="Açıklama"
                                       style=" width: 100%!important;"
                                       class="form-control form-control-sm mx-4" id="ust_aciklama_mahsup">
                            </div>
                            <div class="col-md-2 row mt-4 mx-3 mt-3">
                                <button style="width: 85% !important;"
                                        class="btn btn-success btn-sm mx-5 mahsup_fis_id" id="mahsup_fisi_ekle"><i
                                            class="fa fa-plus"></i> Ekle
                                </button>
                                <button style="background-color: #F6FA70; width: 85% !important;"
                                        class="mt-1 btn btn-sm mx-5 mahsup_fis_id"
                                        id="mahsup_fisi_guncelle"><i
                                            class="fa fa-refresh"></i> Güncelle
                                </button>
                            </div>
                        </div>
                        <div class="col-12 row mt-3">
                            <table class="table table-sm table-bordered w-100 display nowrap" id='new_mahsup_fis_acilis'
                                   style="font-size: 13px;">
                                <thead>
                                <tr>
                                    <th id="click_mahsup">Cari Kodu</th>
                                    <th>Cari Adı</th>
                                    <th>Açıklama</th>
                                    <th>Borç</th>
                                    <th>Alacak</th>
                                    <th>İşlem</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="col-12 row no-gutters mt-3">
                            <div class="col-6"></div>
                            <div class="col-2"></div>
                            <div class="col-4">
                                <div class="col-12 row no-gutters">
                                    <div class="col">
                                        <table class="table table-sm table-bordered w-80 display nowrap">
                                            <tr>
                                                <th>#</th>
                                            </tr>
                                            <tr>
                                                <th>Borç Tutar</th>
                                            </tr>
                                            <tr>
                                                <th>Alacak Tutar</th>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col">
                                        <table class="table table-sm table-bordered w-100 display nowrap">
                                            <thead>
                                            <tr>
                                                <th>Döviz Tutarı</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td id="doviz_borc" style="text-align: right">0,00 TL</td>
                                            </tr>
                                            <tr>
                                                <td id="doviz_alacak" style="text-align: right">0,00 TL</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col">
                                        <table class="table table-sm table-bordered w-100 display nowrap">
                                            <thead>
                                            <tr>
                                                <th>TL Karşılığı</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td class="tl_borc" style="text-align: right">0,00 TL</td>
                                            </tr>
                                            <tr>
                                                <td class="tl_alacak" style="text-align: right">0,00 TL</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-sm" id="mahsup_vazgec_cari"><i class="fa fa-close"></i>
                        Vazgeç
                    </button>
                    <button class="btn btn-success btn-sm" id="mahsup_kaydet"><i class="fa fa-plus"></i> Kaydet
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('input').click(function () {
            $(this).select();
        });
        var arr = [];
        $("body").off("click", "#cari_adi_getir_mahsup").on("click", "#cari_adi_getir_mahsup", function () {
            $.get("modals/cari_modal/mahsup_modal.php?islem=mahsup_icin_cari_getir", function (getModal) {
                $(".mahsup_cari_getir_div").html("");
                $(".mahsup_cari_getir_div").html(getModal);
            });
        });


        $("body").off("change", "#doviz_tur_mahsup").on("change", "#doviz_tur_mahsup", function () {
            var secilen = $(this).val();
            if (secilen == "TL") {
                $("#doviz_kur_mahsup").val("1.00");
            } else if (secilen == "USD") {
                var usd_kur = $("#doviz_tur_mahsup option:selected").attr("usd");
                $("#doviz_kur_mahsup").val(usd_kur);
            } else if (secilen == "EURO") {
                var eur_kur = $("#doviz_tur_mahsup option:selected").attr("eur");
                $("#doviz_kur_mahsup").val(eur_kur);
            } else if (secilen == "GBP") {
                var gbp_kur = $("#doviz_tur_mahsup option:selected").attr("gbp");
                $("#doviz_kur_mahsup").val(gbp_kur);
            }
            $("#doviz_borc").html("");
            $("#doviz_borc").html("0,00" + " " + secilen);
            $("#doviz_alacak").html("");
            $("#doviz_alacak").html("0,00" + " " + secilen);
        });

        $(".ust_borc").focusout(function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                $(this).val("0,00");
            } else {
                val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                $(this).val(val);
            }
        });

        $(".cari_kodu_getir").keyup(function () {
            var val = $(this).val();
            $.get("controller/cari_controller/sql.php?islem=cari_kodunun_bilgilerini_getir_sql", {cari_kodu: val}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $(".cari_kodu_getir").attr("data-id", item.id);
                    $(".cari_kodu_getir").val(item.cari_kodu);
                    $(".cari_adi_getir").val(item.cari_adi);
                } else {
                    $(".cari_kodu_getir").attr("data-id", "");
                    $(".cari_adi_getir").val("");
                }
            })
        });

        $("body").off("click", "#mahsup_kaydet").on("click", "#mahsup_kaydet", function () {
            var id = $("#mahsup_fisi_ekle").attr("data-id");
            var islem_tarih = $("#islem_tarihi").val();
            var belge_no = $("#belge_no").val();
            var ozel_kod = $("#ozel_kod").val();
            var aciklama = $("#ust_aciklama").val();
            var toplam_borc = 0;
            var toplam_alacak = 0;
            // table.rows().every(function () {
            //     var satir_verisi = this.data();
            //     var borc = satir_verisi[3];
            //     borc = borc.replace(/\./g, "").replace(",", ".");
            //     borc = parseFloat(borc);
            //     toplam_borc += borc;
            //     var alacak = satir_verisi[4];
            //     alacak = alacak.replace(/\./g, "").replace(",", ".");
            //     alacak = parseFloat(alacak);
            //     toplam_alacak += alacak;
            // })
            var tl_borc = $(".tl_borc").html();
            var tl_alacak = $(".tl_alacak").html();
            if (tl_borc != tl_alacak) {
                Swal.fire(
                    'Uyarı!',
                    'Toplam Alacak Miktarı Toplam Borç Miktarından Farklı Olamaz',
                    'warning'
                );
            } else if (belge_no == "") {
                Swal.fire(
                    'Uyarı!',
                    'Lütfen Belge No Giriniz',
                    'warning'
                );
            } else {
                $.ajax({
                    url: "controller/cari_controller/sql.php?islem=mahsup_fisini_kaydet",
                    type: "POST",
                    data: {
                        id: id,
                        islem_tarihi: islem_tarih,
                        belge_no: belge_no,
                        ozel_kod: ozel_kod,
                        aciklama: aciklama
                    },
                    success: function (result) {
                        if (result == 1) {
                            Swal.fire(
                                'Başarılı',
                                'Mahsup Fişi Kaydedildi',
                                'success'
                            );
                            $("#cari_mahsup_fisi_modal").modal("hide");
                            $.get("view/mahsup_fisleri.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("view/mahsup_fisleri.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                })
            }

        });

        $(".ust_alacak").focusout(function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                $(this).val("0,00");
            } else {
                val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                $(this).val(val);
            }
        });


        $.get("controller/alis_controller/sql.php?islem=guncel_kurlar", function (result) {
            var item = JSON.parse(result);
            var usd = item.USD[0];
            var eur = item.EUR[0];
            var gbp = item.GBP[0];
            $("#usd_bas").attr("usd", usd);
            $("#eur_bas").attr("eur", eur);
            $("#gbp_bas").attr("gbp", gbp);
        });
        var table = "";
        $("body").off("click", "#mahsup_fisi_ekle").on("click", "#mahsup_fisi_ekle", function () {
            var doviz_turu = $("#doviz_tur_mahsup").val();
            var kur_fiyat = $("#doviz_kur_mahsup").val();
            var cari_id = $(".cari_kodu_getir").attr("data-id");
            var borc = $(".ust_borc").val();
            borc = borc.replace(/\./g, "").replace(",", ".");
            borc = parseFloat(borc);
            var sorgu_borc = borc;
            var aciklama = $("#ust_aciklama_mahsup").val();
            var alacak = $("#mahsup_alacak").val();
            alacak = alacak.replace(/\./g, "").replace(",", ".");
            alacak = parseFloat(alacak);
            var sorgu_alacak = alacak;
            var mahsup_id = $(this).attr("data-id");
            // Listeye Bastırılacak İsimler
            var cari_adi = $(".cari_adi_getir").val();
            var cari_kodu = $(".cari_kodu_getir").val();

            if ((sorgu_borc == 0 && sorgu_alacak == 0) || (sorgu_borc != 0 && sorgu_alacak != 0)) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'warning',
                    title: 'Tutar Ve Borç Aynı Anda Girilemez'
                });
            } else if (cari_id == undefined) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'warning',
                    title: 'Lütfen Bir Cari Seçiniz'
                });
            } else {
                $.ajax({
                    url: "controller/cari_controller/sql.php?islem=cariye_mahsup_fisi_ekle",
                    type: "POST",
                    data: {
                        doviz_tur: doviz_turu,
                        cari_kodu: cari_kodu,
                        kur_fiyat: kur_fiyat,
                        cari_id: cari_id,
                        borc: borc,
                        alacak: alacak,
                        aciklama: aciklama,
                        mahsup_id: mahsup_id
                    },
                    success: function (result) {
                        if (result != 2) {
                            $(".cari_kodu_getir").attr("data-id", "");
                            $(".cari_kodu_getir").val("");
                            $(".cari_adi_getir").val("");
                            $("#ust_aciklama_mahsup").val("");
                            $(".ust_borc_sifirla").val("0,00");
                            $(".ust_alacak_sifirla").val("0,00");
                            var json = JSON.parse(result);
                            table.clear().draw(false);
                            json.forEach(function (item) {
                                var gelen_mahsup_id = item.mahsup_id;
                                var gelen_borc = item.borc;
                                gelen_borc = parseFloat(gelen_borc);
                                gelen_borc = gelen_borc.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                                var gelen_alacak = item.alacak;
                                gelen_alacak = parseFloat(gelen_alacak);
                                gelen_alacak = gelen_alacak.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                                $(".mahsup_fis_id").attr("data-id", gelen_mahsup_id);
                                if (item.cari_kodu != null) {
                                    cari_kodu = item.cari_kodu;
                                    cari_adi = item.cari_adi;
                                } else {
                                    cari_kodu = item.tc_no;
                                    cari_adi = item.uye_adi
                                }
                                var mahsup_id = table.row.add([cari_kodu, cari_adi, item.aciklama, gelen_borc + " " + doviz_turu, gelen_alacak + " " + doviz_turu, "<button class='btn btn-danger mahsup_eksilt' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                                $(mahsup_id).attr("data-id", item.id);
                                var toplam_borc = item.toplam_borc;
                                toplam_borc = parseFloat(toplam_borc);
                                var sorgu_toplam_borc = toplam_borc;
                                toplam_borc = toplam_borc.toLocaleString("tr-TR", {minimumFractionDigits: 2})

                                var toplam_alacak = item.toplam_alacak;
                                toplam_alacak = parseFloat(toplam_alacak);
                                var sorgu_toplam_alacak = toplam_alacak;
                                toplam_alacak = toplam_alacak.toLocaleString("tr-TR", {minimumFractionDigits: 2})

                                $("#doviz_borc").html("");
                                $("#doviz_borc").html(toplam_borc + " " + item.doviz_tur);
                                $("#doviz_alacak").html("");
                                $("#doviz_alacak").html(toplam_alacak + " " + item.doviz_tur);


                                var doviz_kur = item.doviz_kuru;
                                var kur_parse = parseFloat(doviz_kur);
                                var tl_borc = kur_parse * sorgu_toplam_borc;
                                tl_borc = parseFloat(tl_borc);
                                tl_borc = tl_borc.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                                var tl_alacak = kur_parse * sorgu_toplam_alacak;
                                tl_alacak = parseFloat(tl_alacak);
                                tl_alacak = tl_alacak.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                                $(".tl_borc").html("");
                                $(".tl_borc").html(tl_borc + " TL");
                                $(".tl_alacak").html("");
                                $(".tl_alacak").html(tl_alacak + " TL");
                            });
                        }
                    }
                });
            }
        });

        $("body").off("click", ".mahsup_eksilt").on("click", ".mahsup_eksilt", function () {
            var id = $(this).attr("data-id");
            var row = $(this).closest('tr');
            $.ajax({
                url: "controller/cari_controller/sql.php?islem=mahsup_fisi_eksilt_sql",
                type: "POST",
                data: {
                    id: id
                },
                success: function (result) {
                    if (result != 2) {
                        var item = JSON.parse(result);
                        table.row(row).remove().draw();
                        var toplam_borc = item.toplam_borc;
                        toplam_borc = parseFloat(toplam_borc);
                        var sorgu_toplam_borc = toplam_borc;
                        toplam_borc = toplam_borc.toLocaleString("tr-TR", {minimumFractionDigits: 2})

                        var toplam_alacak = item.toplam_alacak;
                        toplam_alacak = parseFloat(toplam_alacak);
                        var sorgu_toplam_alacak = toplam_alacak;
                        toplam_alacak = toplam_alacak.toLocaleString("tr-TR", {minimumFractionDigits: 2})

                        $("#doviz_borc").html("");
                        $("#doviz_borc").html(toplam_borc + " " + item.doviz_tur);
                        $("#doviz_alacak").html("");
                        $("#doviz_alacak").html(toplam_alacak + " " + item.doviz_tur);


                        var doviz_kur = item.doviz_kuru;
                        var kur_parse = parseFloat(doviz_kur);
                        var tl_borc = kur_parse * sorgu_toplam_borc;
                        tl_borc = parseFloat(tl_borc);
                        tl_borc = tl_borc.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                        var tl_alacak = kur_parse * sorgu_toplam_alacak;
                        tl_alacak = parseFloat(tl_alacak);
                        tl_alacak = tl_alacak.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                        $(".tl_borc").html("");
                        $(".tl_borc").html(tl_borc + " TL");
                        $(".tl_alacak").html("");
                        $(".tl_alacak").html(tl_alacak + " TL");
                    }
                }
            });
        });

        $("body").off("click", "#mahsup_fisi_guncelle").on("click", "#mahsup_fisi_guncelle", function () {
            var doviz_turu = $("#doviz_tur_mahsup").val();
            var kur_fiyat = $("#doviz_kur_mahsup").val();
            var cari_id = $(".cari_kodu_getir").attr("data-id");
            var borc = $(".ust_borc").val();
            borc = borc.replace(/\./g, "").replace(",", ".");
            borc = parseFloat(borc);
            var sorgu_borc = borc;
            var aciklama = $("#ust_aciklama_mahsup").val();
            var alacak = $("#mahsup_alacak").val();
            alacak = alacak.replace(/\./g, "").replace(",", ".");
            alacak = parseFloat(alacak);
            var sorgu_alacak = alacak;
            var mahsup_id = $(this).attr("data-id");
            // Listeye Bastırılacak İsimler
            var cari_adi = $(".cari_adi_getir").val();
            var cari_kodu = $(".cari_kodu_getir").val();


            if (cari_id == undefined || cari_id == "") {
                Swal.fire(
                    'Uyarı!',
                    'Herhangi Bir Cari Seçilmemiş Buradan Sadece Ürün Kaydı Güncelleyebilirsiniz',
                    'warning'
                );
            } else {
                var secilen_borc = arr[0];
                var secilen_alacak = arr[1];
                var borc_fark = 0;
                var alacak_fark = 0;

                secilen_borc = parseFloat(secilen_borc);
                secilen_alacak = parseFloat(secilen_alacak);
                borc_fark = sorgu_borc - secilen_borc;
                alacak_fark = sorgu_alacak - secilen_alacak

                if ((sorgu_borc == 0 && sorgu_alacak == 0) || (sorgu_borc != 0 && sorgu_alacak != 0)) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'warning',
                        title: 'Tutar Ve Borç Aynı Anda Girilemez'
                    });
                } else if (cari_id == undefined) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'warning',
                        title: 'Cari Boş Kalamaz'
                    });
                } else {
                    $.ajax({
                        url: "controller/cari_controller/sql.php?islem=mahsup_fis_guncelle_sql",
                        type: "POST",
                        data: {
                            doviz_tur: doviz_turu,
                            kur_fiyat: kur_fiyat,
                            secilen_borc: secilen_borc,
                            cari_kodu: cari_kodu,
                            secilen_alacak: secilen_alacak,
                            cari_id: cari_id,
                            borc: borc,
                            alacak: alacak,
                            aciklama: aciklama,
                            borc_fark: borc_fark,
                            alacak_fark: alacak_fark,
                            mahsup_id: mahsup_id
                        },
                        success: function (result) {
                            if (result != 2) {
                                $(".cari_kodu_getir").attr("data-id", "");
                                $(".cari_kodu_getir").val("");
                                $(".cari_adi_getir").val("");
                                $(".ust_borc").val("0,00");
                                $("#ust_aciklama_mahsup").val("");
                                $(".ust_alacak").val("0,00");

                                var json = JSON.parse(result);
                                table.clear().draw(false);
                                json.forEach(function (item) {
                                    var gelen_mahsup_id = item.mahsup_id;
                                    var gelen_borc = item.borc;
                                    gelen_borc = parseFloat(gelen_borc);
                                    gelen_borc = gelen_borc.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                                    var gelen_alacak = item.alacak;
                                    gelen_alacak = parseFloat(gelen_alacak);
                                    gelen_alacak = gelen_alacak.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                                    $(".mahsup_fis_id").attr("data-id", gelen_mahsup_id);
                                    let cari_kodu = "";
                                    let cari_adi = "";
                                    if (item.cari_kodu != null) {
                                        cari_kodu = item.cari_kodu;
                                        cari_adi = item.cari_adi;
                                    } else {
                                        cari_kodu = item.tc_no;
                                        cari_adi = item.uye_adi
                                    }
                                    var mahsup_id = table.row.add([cari_kodu, cari_adi, item.aciklama, gelen_borc + " " + doviz_turu, gelen_alacak + " " + doviz_turu, "<button class='btn btn-danger mahsup_eksilt' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                                    $(mahsup_id).attr("data-id", item.id);
                                    var toplam_borc = item.toplam_borc;
                                    toplam_borc = parseFloat(toplam_borc);
                                    var sorgu_toplam_borc = toplam_borc;
                                    toplam_borc = toplam_borc.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                                    var toplam_alacak = item.toplam_alacak;
                                    toplam_alacak = parseFloat(toplam_alacak);
                                    var sorgu_toplam_alacak = toplam_alacak;
                                    toplam_alacak = toplam_alacak.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                                    $("#doviz_borc").html("");
                                    $("#doviz_borc").html(toplam_borc + " " + item.doviz_tur);
                                    $("#doviz_alacak").html("");
                                    $("#doviz_alacak").html(toplam_alacak + " " + item.doviz_tur);
                                    var doviz_kur = item.doviz_kuru;
                                    var kur_parse = parseFloat(doviz_kur);
                                    var tl_borc = kur_parse * sorgu_toplam_borc;
                                    tl_borc = parseFloat(tl_borc);
                                    tl_borc = tl_borc.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                                    var tl_alacak = kur_parse * sorgu_toplam_alacak;
                                    tl_alacak = parseFloat(tl_alacak);
                                    tl_alacak = tl_alacak.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                                    $(".tl_borc").html("");
                                    $(".tl_borc").html(tl_borc + " TL");
                                    $(".tl_alacak").html("");
                                    $(".tl_alacak").html(tl_alacak + " TL");
                                });
                            }
                        }
                    });
                }
            }
        });

        $("body").off("click", "#mahsup_vazgec_cari").on("click", "#mahsup_vazgec_cari", function () {
            $("#cari_mahsup_fisi_modal").modal("hide");
        });

        $(document).ready(function () {

            $.get("controller/cari_controller/sql.php?islem=mahsup_bilgilerini_getir_sql", {id: "<?=$_GET["id"]?>"}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    var islem_tarihi = item.islem_tarihi;
                    var explode1 = islem_tarihi.split(" ");
                    setTimeout(function () {
                        $("#islem_tarihi").val(explode1[0]);
                        $("#doviz_tur_mahsup").val(item.doviz_tur);
                        $("#doviz_kur_mahsup").val(item.doviz_kuru);
                        $("#belge_no").val(item.belge_no);
                        $("#ozel_kod").val(item.ozel_kod);
                        $("#ust_aciklama").val(item.aciklama)
                        $("#mahsup_fisi_ekle").attr("data-id", item.id)
                    }, 500);
                }
            });

            $.get("controller/cari_controller/sql.php?islem=mahsup_urunleri_getir", {mahsup_id: "<?=$_GET["id"]?>"}, function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        var doviz_turu = $("#doviz_tur_mahsup").val();
                        var gelen_mahsup_id = item.mahsup_id;
                        var gelen_borc = item.borc;
                        gelen_borc = parseFloat(gelen_borc);
                        gelen_borc = gelen_borc.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                        var gelen_alacak = item.alacak;
                        gelen_alacak = parseFloat(gelen_alacak);
                        gelen_alacak = gelen_alacak.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                        $(".mahsup_fis_id").attr("data-id", gelen_mahsup_id);
                        let cari_kodu = "";
                        let cari_adi = "";
                        if (item.cari_adi != null) {
                            cari_adi = item.cari_adi;
                            cari_kodu = item.cari_kodu;
                        } else {
                            cari_adi = item.uye_adi;
                            cari_kodu = item.tc_no;
                        }
                        var mahsup_id = table.row.add([cari_kodu, cari_adi, item.aciklama, gelen_borc + " " + doviz_turu, gelen_alacak + " " + doviz_turu, "<button class='btn btn-danger mahsup_eksilt' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                        $(mahsup_id).attr("data-id", item.id);
                        var toplam_borc = item.toplam_borc;
                        toplam_borc = parseFloat(toplam_borc);
                        var sorgu_toplam_borc = toplam_borc;
                        toplam_borc = toplam_borc.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                        var toplam_alacak = item.toplam_alacak;
                        toplam_alacak = parseFloat(toplam_alacak);
                        var sorgu_toplam_alacak = toplam_alacak;
                        toplam_alacak = toplam_alacak.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                        $("#doviz_borc").html("");
                        $("#doviz_borc").html(toplam_borc + " " + item.doviz_tur);
                        $("#doviz_alacak").html("");
                        $("#doviz_alacak").html(toplam_alacak + " " + item.doviz_tur);
                        var doviz_kur = item.doviz_kuru;
                        var kur_parse = parseFloat(doviz_kur);
                        var tl_borc = kur_parse * sorgu_toplam_borc;
                        tl_borc = parseFloat(tl_borc);
                        tl_borc = tl_borc.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                        var tl_alacak = kur_parse * sorgu_toplam_alacak;
                        tl_alacak = parseFloat(tl_alacak);
                        tl_alacak = tl_alacak.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                        $(".tl_borc").html("");
                        $(".tl_borc").html(tl_borc + " TL");
                        $(".tl_alacak").html("");
                        $(".tl_alacak").html(tl_alacak + " TL");
                    });
                }
            })

            setTimeout(function () {
                $("#click_mahsup").trigger("click");
            }, 500);
            $("#cari_mahsup_fisi_modal").modal("show");
            table = $('#new_mahsup_fis_acilis').DataTable({
                scrollY: '25vh',
                scrollX: true,
                bAutoWidth: false,
                searching: false,
                aoColumns: [
                    {sWidth: '1%'},
                    {sWidth: '3%'},
                    {sWidth: '3%'},
                    {sWidth: '1%'},
                    {sWidth: '1%'},
                    {sWidth: '1%'}
                ],
                "info": false,
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row) {
                    $(row).addClass("cari_acilis_fisi");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                    $(row).find('td').eq(2).css('text-align', 'left');
                }
            })
        })

        $("body").off("click", ".cari_acilis_fisi").on("click", ".cari_acilis_fisi", function () {
            var id = $(this).attr("data-id");
            $.get("controller/cari_controller/sql.php?islem=secilen_kaydi_getir_mahsup", {id: id}, function (result) {
                if (result != 2) {
                    arr = [];
                    var item = JSON.parse(result);
                    let cari_id = "";
                    let cari_kodu = "";
                    let cari_adi = "";
                    if (item.cari_kodu != null) {
                        cari_adi = item.cari_adi;
                        cari_kodu = item.cari_kodu;
                        cari_id = item.cari_id;
                    } else {
                        cari_id = item.uye_id;
                        cari_kodu = item.tc_no;
                        cari_adi = item.uye_adi;
                    }
                    $(".cari_kodu_getir").attr("data-id", cari_id);
                    $(".cari_kodu_getir").val(cari_kodu);
                    $(".cari_adi_getir").val(cari_adi);
                    let ust_borc = item.borc;
                    ust_borc = parseFloat(ust_borc);
                    if (isNaN(ust_borc)) {
                        ust_borc = 0;
                    }
                    ust_borc = ust_borc.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    $(".ust_borc").val(ust_borc);
                    let ust_alacak = item.alacak;
                    ust_alacak = parseFloat(ust_alacak);
                    if (isNaN(ust_alacak)) {
                        ust_alacak = 0;
                    }
                    ust_alacak = ust_alacak.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    $(".ust_alacak").val(ust_alacak);
                    $("#ust_aciklama_mahsup").val(item.aciklama);
                    $("#mahsup_fisi_guncelle").attr("data-id", item.id);
                    arr.push(item.borc, item.alacak);
                }
            })
        })
    </script>
    <?php
}