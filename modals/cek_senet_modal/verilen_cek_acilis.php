<?php

$islem = $_GET["islem"];

if ($islem == "cek_acilis_verilen_cekler_modal") {
    ?>
    <style>
        #verilen_cek_acilis_main_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="verilen_cek_acilis_main_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 35%; max-width: 35%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="pos_cekim_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>VERİLEN ÇEK AÇILIŞI</div>
                        </div>
                        <div class="modal-body">
                            <div class="yeni_cek_icin_cari"></div>
                            <div class="col-12 row">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Açılış Tarihi</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="date" value="<?= date("Y-m-d") ?>"
                                               class="form-control form-control-sm"
                                               id="acilis_tarihi">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Vade Tarihi</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="date" class="form-control form-control-sm" id="vade_tarih"
                                               value="<?= date("Y-m-d") ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Cari Kodu</label>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="input-group">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="cek_senet_giris_cariid">
                                            <div class="input-group-append">
                                                <button class="btn btn-warning btn-sm cek_senet_icin_cari_getir" id="">
                                                    <i
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
                                        <input type="text" class="form-control form-control-sm cari_adi" disabled
                                               style="font-weight: bold">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Seri No</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" id="seri_no">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Tutar</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm"
                                               style="text-align: right" value="0,00"
                                               id="tutar">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Keşide Yeri</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm"
                                               id="keside_yeri">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Banka Adı</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" id="banka_adi">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Aslı Borçlu</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" id="asil_borclu">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Ciro Edilmiş</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" class="form-control form-control-sm" id="ciro_edilmis">
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
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="pos_cekim_vazgec"><i
                                        class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="verilen_cek_acilisi_kaydet_button"><i
                                        class="fa fa-plus"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("body").off("click", ".cek_senet_icin_cari_getir").on("click", ".cek_senet_icin_cari_getir", function () {
            $.get("modals/cek_senet_modal/another_modal.php?islem=carileri_getir_modal", function (getModal) {
                $(".yeni_cek_icin_cari").html("");
                $(".yeni_cek_icin_cari").html(getModal);
            })
        });
        $("input").click(function () {
            $(this).select();
        });

        $("body").off("click", "#verilen_cek_acilisi_kaydet_button").on("click", "#verilen_cek_acilisi_kaydet_button", function () {
            let acilis_tarihi = $("#acilis_tarihi").val();
            let vade_tarihi = $("#vade_tarih").val();
            let seri_no = $("#seri_no").val();
            let ciro_edilmis = $("#ciro_edilmis").val();
            let cari_id = $("#cek_senet_giris_cariid").attr("data-id");
            let asil_borclu = $("#asil_borclu").val();
            let tutar = $("#tutar").val();
            tutar = tutar.replace(/\./g, "").replace(",", ".");
            tutar = parseFloat(tutar);
            let keside_yeri = $("#keside_yeri").val();
            let banka_adi = $("#banka_adi").val();
            let aciklama = $("#aciklama").val();
            if (tutar == 0) {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Geçerli Bir Tutar Giriniz",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "controller/cek_senet_controller/sql.php?islem=alinan_cek_acilis_kaydet_sql",
                    type: "POST",
                    data: {
                        acilis_tarihi: acilis_tarihi,
                        cari_id: cari_id,
                        vade_tarihi: vade_tarihi,
                        seri_no: seri_no,
                        tutar: tutar,
                        keside_yeri: keside_yeri,
                        banka_adi: banka_adi,
                        asil_borclu: asil_borclu,
                        ciro_edilmis: ciro_edilmis,
                        aciklama: aciklama
                    }, success: function (response) {
                        if (response == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Çek Açılışı Kaydedildi",
                                "success"
                            );
                            $.get("view/cek_acilis_fisi.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("view/cek_acilis_fisi.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                            $("#verilen_cek_acilis_main_modal").modal("hide");
                        }
                    }
                });
            }

        });

        $("body").off("click", "#focusout").on("focusout", "#tutar", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });

        $(document).ready(function () {
            $("#verilen_cek_acilis_main_modal").modal("show");

            $.get("controller/banka_controller/sql.php?islem=bankalari_getir", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#banka_ids").append("" +
                            "<option value='" + item.id + "'>" + item.hesap_adi + "</option>" +
                            "")
                    });
                }
            });
        });

        $("body").off("click", "#pos_cekim_vazgec").on("click", "#pos_cekim_vazgec", function () {
            $("#verilen_cek_acilis_main_modal").modal("hide");
        })

    </script>
    <?php
}