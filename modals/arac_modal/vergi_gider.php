<?php

$islem = $_GET["islem"];

if ($islem == "vergi_gider_girisi_modal") {
    ?>
    <style>
        #binek_arac_vergi_gider_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="binek_arac_vergi_gider_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="arac_hgs_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>VERGİ GİDER FİŞİ</div>
                        </div>
                        <div class="modal-body">
                            <div class="arac_hgs_giderleri_plaka_getir_div"></div>
                            <div class="konteyner_hgs_kasalar"></div>
                            <div class="konteyner_hgs_bankalar"></div>
                            <div class="konteyner_hgs_kartlar"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Tarih</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>" id="gider_tarih"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Ödeme Yöntemi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="odeme_yontemi">
                                                <option value="">Ödeme Yöntemi Seçiniz...</option>
                                                <option value="Nakit">Nakit</option>
                                                <option value="Havale">Havale</option>
                                                <option value="Kart">Kart</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Tutar</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="hgs_tutar"
                                                   value="0,00"
                                                   style="text-align: right">
                                        </div>
                                    </div>
                                    <div class="form-group row kart_show" style="display: none;">
                                        <div class="col-md-4">
                                            <label>Kredi Kartı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       placeholder="Kredi Kartı Kodu..."
                                                       id="kredi_kart_id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="kartlari_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row banka_show" style="display: none;">
                                        <div class="col-md-4">
                                            <label>Banka</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="banka_id"
                                                       placeholder="Banka Kodu...">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="bankalari_getir_button">
                                                        <i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row kasa_show" style="display: none;">
                                        <div class="col-md-4">
                                            <label>Kasa</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="kasa_id"
                                                       placeholder="Kasa Kodu...">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="kasa_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Plaka</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="plaka_id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="toplu_irsaliye_plakalar">
                                                        <i class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="aciklama">
                                                <div class="input-group-append">
                                                    <button class="btn btn-success btn-sm" id="hgs_gider_fisi_kaydet"><i
                                                                class="fa fa-plus"></i>
                                                        Ekle
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row mx-1 mt-3">
                                <table class="table table-sm table-bordered w-100 display nowrap edit_list"
                                       style="cursor:pointer;font-size: 13px;"
                                       id="arac_hgs_giderleri_kalem">
                                    <thead>
                                    <tr>
                                        <th>Tarih</th>
                                        <th>Plaka</th>
                                        <th>Ödeme Yöntemi</th>
                                        <th>Banka Adı</th>
                                        <th>Kredi Kartı</th>
                                        <th>Kasa Adı</th>
                                        <th>Tutar</th>
                                        <th>Açıklama</th>
                                        <th>İşlem</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="col-12">
                            <label>Genel Açıklama</label>
                            <textarea class="form-control form-control-sm" id="genel_aciklama" style="resize: none"
                                      rows="4"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="arac_hgs_modal_kapat"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="hgs_gider_kaydet_main_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("body").off("keyup", "#hgs_ogs_no").on("keyup", "#hgs_ogs_no", function () {
            let val = $(this).val();
            $.get("controller/arac_controller/sql.php?islem=hgsye_ait_arac_getir_sql", {hgs: val}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#plaka_id").val(item.arac_plaka);
                    $("#plaka_id").attr("data-id", item.id);
                } else {
                    $("#plaka_id").val("");
                    $("#plaka_id").attr("data-id", "");
                }
            })
        });

        $("body").off("click", "#kasa_getir_button").on("click", "#kasa_getir_button", function () {
            $.get("konteyner/modals/arac_modal/hgs_gider_giris.php?islem=kasalari_getir_modal", function (getModal) {
                $(".konteyner_hgs_kasalar").html("");
                $(".konteyner_hgs_kasalar").html(getModal);
            })
        });
        $("body").off("click", "#bankalari_getir_button").on("click", "#bankalari_getir_button", function () {
            $.get("konteyner/modals/arac_modal/hgs_gider_giris.php?islem=bankalari_getir_modal", function (getModal) {
                $(".konteyner_hgs_bankalar").html("");
                $(".konteyner_hgs_bankalar").html(getModal);
            })
        });
        $("body").off("click", "#kartlari_getir_button").on("click", "#kartlari_getir_button", function () {
            $.get("konteyner/modals/arac_modal/hgs_gider_giris.php?islem=kartlari_getir_modal", function (getModal) {
                $(".konteyner_hgs_kartlar").html("");
                $(".konteyner_hgs_kartlar").html(getModal);
            })
        });

        $("body").off("click", "#hgs_gider_kaydet_main_button").on("click", "#hgs_gider_kaydet_main_button", function () {
            let gidecek_arr = [];

            $(".hgs_giderleri_kalem").each(function () {
                let tarih = $(this).find("td").eq(0).text();
                let odeme_yontemi = $(this).find("td").eq(2).text();
                let tutar = $(this).find("td").eq(6).text();
                let aciklama = $(this).find("td").eq(7).text();
                tutar = tutar.replace(/\./g, "").replace(",", ".");
                tutar = parseFloat(tutar);

                let kasa_id = $(this).attr("kasa_id");
                let banka_id = $(this).attr("banka_id");
                let kart_id = $(this).attr("kart_id");
                let plaka_id = $(this).attr("plaka_id");
                tarih = tarih.split("/");
                let gun = tarih[0];
                let ay = tarih[1];
                let yil = tarih[2];
                let arr = [yil, ay, gun];
                tarih = arr.join("-");

                let newRow = {
                    tarih: tarih,
                    odeme_yontemi: odeme_yontemi,
                    kasa_id: kasa_id,
                    banka_id: banka_id,
                    kart_id: kart_id,
                    plaka_id: plaka_id,
                    tutar: tutar,
                    aciklama: aciklama
                };
                gidecek_arr.push(newRow);
            });
            let aciklama = $("#genel_aciklama").val();
            $.ajax({
                url: "controller/arac_controller/sql.php?islem=vergi_gider_fisi_kaydet_sql",
                type: "POST",
                data: {
                    gidecek_arr: gidecek_arr,
                    g_aciklama: aciklama
                },
                success: function (result) {
                    if (result == 1) {
                        Swal.fire(
                            'Başarılı',
                            "Vergi Gider Fişi Kaydedildi",
                            "success"
                        );
                        $("#binek_arac_vergi_gider_modal").modal("hide");
                        $.get("view/binek_vergi_gider.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                        $.get("view/binek_vergi_gider.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                    } else {
                        Swal.fire(
                            'Oops...',
                            "Bilinmeyen Bir Hata Oluştu",
                            "error"
                        );
                        $("#binek_arac_vergi_gider_modal").modal("hide");
                    }
                }
            });

        });

        var hgs_gider_table = "";
        $('input').click(function () {
            $(this).select();
        });

        $("body").off("click", "#hgs_gider_fisi_kaydet").on("click", "#hgs_gider_fisi_kaydet", function () {
            let tarih = $("#gider_tarih").val();
            tarih = tarih.split("-");
            let gun = tarih[2];
            let ay = tarih[1];
            let yil = tarih[0];
            let arr = [gun, ay, yil];
            tarih = arr.join("/");

            let odeme_yontemi = $("#odeme_yontemi").val();
            let kasa_id = $("#kasa_id").attr("data-id");
            let kasa_adi = $("#kasa_id").val();
            let banka_id = $("#banka_id").attr("data-id");
            let banka_adi = $("#banka_id").val();
            let kart_id = $("#kredi_kart_id").attr("data-id");
            let kart_adi = $("#kredi_kart_id").val();
            let plaka_id = $("#plaka_id").attr("data-id");
            let plaka = $("#plaka_id").val();
            let tutar = $("#hgs_tutar").val();
            let aciklama = $("#aciklama").val();
            if (plaka_id == "" || plaka_id == undefined) {
                Swal.fire(
                    'Uyarı!',
                    "Lütfen Bir Plaka Seçiniz...",
                    "warning"
                );
            } else if (tutar == 0) {
                Swal.fire(
                    'Uyarı!',
                    "Tutar 0 Olamaz",
                    "warning"
                );
            } else if (odeme_yontemi == "Nakit") {
                let table = hgs_gider_table.row.add([tarih, plaka, odeme_yontemi, banka_adi, kart_adi, kasa_adi, tutar, aciklama, "<button class='btn btn-danger btn-sm hgs_gider_sil_list'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                $(table).attr("banka_id", banka_id);
                $(table).attr("kasa_id", kasa_id);
                $(table).attr("kart_id", kart_id);
                $(table).attr("plaka_id", plaka_id);
            } else if (odeme_yontemi == "Havale") {
                let table = hgs_gider_table.row.add([tarih, plaka, odeme_yontemi, banka_adi, kart_adi, kasa_adi, tutar, aciklama, "<button class='btn btn-danger btn-sm hgs_gider_sil_list'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                $(table).attr("banka_id", banka_id);
                $(table).attr("kasa_id", kasa_id);
                $(table).attr("kart_id", kart_id);
                $(table).attr("plaka_id", plaka_id);
            } else if (odeme_yontemi == "Kart") {
                let table = hgs_gider_table.row.add([tarih, plaka, odeme_yontemi, banka_adi, kart_adi, kasa_adi, tutar, aciklama, "<button class='btn btn-danger btn-sm hgs_gider_sil_list'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                $(table).attr("banka_id", banka_id);
                $(table).attr("kasa_id", kasa_id);
                $(table).attr("kart_id", kart_id);
                $(table).attr("plaka_id", plaka_id);
            } else {
                let table = hgs_gider_table.row.add([tarih, plaka, odeme_yontemi, banka_adi, kart_adi, kasa_adi, tutar, aciklama, "<button class='btn btn-danger btn-sm hgs_gider_sil_list'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                $(table).attr("banka_id", banka_id);
                $(table).attr("kasa_id", kasa_id);
                $(table).attr("kart_id", kart_id);
                $(table).attr("plaka_id", plaka_id);
            }
            $("#odeme_yontemi").val("");
            $("#kasa_id").attr("data-id", "");
            $("#kasa_id").val("");
            $("#kasa_id").val("");
            $("#banka_id").attr("data-id", "");
            $("#banka_id").val("");
            $("#banka_id").val("");
            $("#kredi_kart_id").attr("data-id", "");
            $("#kredi_kart_id").val("");
            $("#kredi_kart_id").val("");
            $("#plaka_id").attr("data-id", "");
            $("#plaka_id").val("");
            $("#plaka_id").val("");
            $("#hgs_tutar").val("");
            $("#aciklama").val("");
        });

        $("body").off("focusout", "#hgs_tutar").on("focusout", "#hgs_tutar", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("click", ".hgs_gider_sil_list").on("click", ".hgs_gider_sil_list", function () {
            var row = $(this).closest('tr');
            hgs_gider_table.row(row).remove().draw(false);
        });

        $("body").off("click", "#toplu_irsaliye_plakalar").on("click", "#toplu_irsaliye_plakalar", function () {
            $.get("modals/arac_modal/yakit_alim_modal.php?islem=irsaliye_plakalari_getir", function (getModal) {
                $(".arac_hgs_giderleri_plaka_getir_div").html("");
                $(".arac_hgs_giderleri_plaka_getir_div").html(getModal);
            })
        });

        $("body").off("keyup", "#plaka_id").on("keyup", "#plaka_id", function () {
            let val = $(this).val();
            $.get("controller/arac_controller/sql.php?islem=arac_bilgilerini_getir_sql", {plaka_no: val}, function (response) {
                if (response != 2) {
                    var item = JSON.parse(response);
                    $("#plaka_id").val(item.arac_plaka);
                    $("#plaka_id").attr("data-id", item.id);
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
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'Plaka Bulundu'
                    });
                } else {
                    $("#plaka_cari").val("");
                    $("#plaka_no_input").attr("data-id", "");
                }
            })
        });

        $("body").off("change", "#odeme_yontemi").on("change", "#odeme_yontemi", function () {
            let val = $(this).val();
            if (val == "Nakit") {
                $(".kasa_show").show();
                $("#kredi_kart_id").val("");
                $("#kredi_kart_id").attr("data-id", "");
                $(".kart_show").hide();
                $("#banka_id").val("");
                $("#banka_id").attr("data-id", "");
                $(".banka_show").hide();
            } else if (val == "Havale") {
                $(".kasa_show").hide();
                $(".kart_show").hide();
                $("#kasa_id").val("");
                $("#kasa_id").attr("data-id", "");
                $(".banka_show").show();
                $("#kredi_kart_id").val("");
                $("#kredi_kart_id").attr("data-id", "");
            } else if (val == "Kart") {
                $(".kasa_show").hide();
                $(".kart_show").show();
                $("#banka_id").val("");
                $("#banka_id").attr("data-id", "");
                $(".banka_show").hide();
                $("#kasa_id").val("");
                $("#kasa_id").attr("data-id", "");
            } else {
                $("#kredi_kart_id").val("");
                $("#kredi_kart_id").attr("data-id", "");
                $(".kasa_show").hide();
                $(".kart_show").hide();
                $("#banka_id").val("");
                $("#banka_id").attr("data-id", "");
                $(".banka_show").hide();
                $("#kasa_id").val("");
                $("#kasa_id").attr("data-id", "");
            }
        });

        $("body").off("keyup", "#kredi_kart_id").on("keyup", "#kredi_kart_id", function () {
            let val = $("#kredi_kart_id").val();
            $.get("konteyner/controller/arac_giderleri/sql.php?islem=kredi_karti_getir_sql", {kart_kodu: val}, function (response) {
                if (response != 2) {
                    var item = JSON.parse(response);
                    $("#kredi_kart_id").val(item.kart_adi);
                    $("#kredi_kart_id").attr("data-id", item.id);
                } else {
                    $("#kredi_kart_id").attr("data-id", "");
                }
            })
        });

        $("body").off("keyup", "#banka_id").on("keyup", "#banka_id", function () {
            let val = $("#banka_id").val();
            $.get("konteyner/controller/arac_giderleri/sql.php?islem=bankalari_getir_sql", {banka_kodu: val}, function (response) {
                if (response != 2) {
                    var item = JSON.parse(response);
                    $("#banka_id").val(item.banka_adi);
                    $("#banka_id").attr("data-id", item.id);
                } else {
                    $("#banka_id").attr("data-id", "");
                }
            })
        });

        $("body").off("keyup", "#kasa_id").on("keyup", "#kasa_id", function () {
            let val = $("#kasa_id").val();
            $.get("konteyner/controller/arac_giderleri/sql.php?islem=kasalari_getir_sql", {kasa_kodu: val}, function (response) {
                if (response != 2) {
                    var item = JSON.parse(response);
                    $("#kasa_id").val(item.kasa_adi);
                    $("#kasa_id").attr("data-id", item.id);
                } else {
                    $("#kasa_id").attr("data-id", "");
                }
            })
        });

        $("body").off("click", "#arac_hgs_modal_kapat").on("click", "#arac_hgs_modal_kapat", function () {
            $("#binek_arac_vergi_gider_modal").modal("hide");
        });

        $(document).ready(function () {
            $("#binek_arac_vergi_gider_modal").modal("show");
            hgs_gider_table = $('#arac_hgs_giderleri_kalem').DataTable({
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                scrollX: true,
                scrollY: "25vh",
                paging: false,
                info: false,
                createdRow: function (row) {
                    $(row).find("td").css("text-transform", "uppercase");
                    $(row).find("td").css("text-align", "left");
                    $(row).find("td").eq(6).css("text-align", "right");
                    $(row).addClass("hgs_giderleri_kalem")
                }
            });
        });

    </script>
    <?php
}
if ($islem == "vergri_gider_fisi_detay_modal_getir") {
    ?>
    <style>
        #vergi_guncelle_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="vergi_guncelle_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="arac_hgs_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>VERGİ GİDER FİŞİ</div>
                        </div>
                        <div class="modal-body">
                            <div class="arac_hgs_giderleri_plaka_getir_div"></div>
                            <div class="konteyner_hgs_kasalar"></div>
                            <div class="konteyner_hgs_bankalar"></div>
                            <div class="konteyner_hgs_kartlar"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Tarih</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>" id="gider_tarih"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Ödeme Yöntemi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="odeme_yontemi">
                                                <option value="">Ödeme Yöntemi Seçiniz...</option>
                                                <option value="Nakit">Nakit</option>
                                                <option value="Havale">Havale</option>
                                                <option value="Kart">Kart</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Tutar</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="hgs_tutar"
                                                   value="0,00"
                                                   style="text-align: right">
                                        </div>
                                    </div>
                                    <div class="form-group row kart_show" style="display: none;">
                                        <div class="col-md-4">
                                            <label>Kredi Kartı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       placeholder="Kredi Kartı Kodu..."
                                                       id="kredi_kart_id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="kartlari_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row banka_show" style="display: none;">
                                        <div class="col-md-4">
                                            <label>Banka</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="banka_id"
                                                       placeholder="Banka Kodu...">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="bankalari_getir_button">
                                                        <i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row kasa_show" style="display: none;">
                                        <div class="col-md-4">
                                            <label>Kasa</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="kasa_id"
                                                       placeholder="Kasa Kodu...">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="kasa_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Plaka</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="plaka_id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="toplu_irsaliye_plakalar">
                                                        <i class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="aciklama">
                                                <div class="input-group-append">
                                                    <button class="btn btn-success btn-sm" id="hgs_gider_fisi_guncelle"><i
                                                                class="fa fa-plus"></i>
                                                        Ekle
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row mx-1 mt-3">
                                <table class="table table-sm table-bordered w-100 display nowrap edit_list"
                                       style="cursor:pointer;font-size: 13px;"
                                       id="arac_hgs_giderleri_kalem">
                                    <thead>
                                    <tr>
                                        <th id="clickbait2">Tarih</th>
                                        <th>Plaka</th>
                                        <th>Ödeme Yöntemi</th>
                                        <th>Banka Adı</th>
                                        <th>Kredi Kartı</th>
                                        <th>Kasa Adı</th>
                                        <th>Tutar</th>
                                        <th>Açıklama</th>
                                        <th>İşlem</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="col-12">
                            <label>Genel Açıklama</label>
                            <textarea class="form-control form-control-sm" id="genel_aciklama" style="resize: none"
                                      rows="4"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="arac_hgs_modal_kapat"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="hgs_gider_kaydet_main_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("body").off("keyup", "#hgs_ogs_no").on("keyup", "#hgs_ogs_no", function () {
            let val = $(this).val();
            $.get("controller/arac_controller/sql.php?islem=hgsye_ait_arac_getir_sql", {hgs: val}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#plaka_id").val(item.arac_plaka);
                    $("#plaka_id").attr("data-id", item.id);
                } else {
                    $("#plaka_id").val("");
                    $("#plaka_id").attr("data-id", "");
                }
            })
        });

        $("body").off("click", "#kasa_getir_button").on("click", "#kasa_getir_button", function () {
            $.get("konteyner/modals/arac_modal/hgs_gider_giris.php?islem=kasalari_getir_modal", function (getModal) {
                $(".konteyner_hgs_kasalar").html("");
                $(".konteyner_hgs_kasalar").html(getModal);
            })
        });
        $("body").off("click", "#bankalari_getir_button").on("click", "#bankalari_getir_button", function () {
            $.get("konteyner/modals/arac_modal/hgs_gider_giris.php?islem=bankalari_getir_modal", function (getModal) {
                $(".konteyner_hgs_bankalar").html("");
                $(".konteyner_hgs_bankalar").html(getModal);
            })
        });
        $("body").off("click", "#kartlari_getir_button").on("click", "#kartlari_getir_button", function () {
            $.get("konteyner/modals/arac_modal/hgs_gider_giris.php?islem=kartlari_getir_modal", function (getModal) {
                $(".konteyner_hgs_kartlar").html("");
                $(".konteyner_hgs_kartlar").html(getModal);
            })
        });

        $("body").off("click", "#hgs_gider_kaydet_main_button").on("click", "#hgs_gider_kaydet_main_button", function () {
            let genel_aciklama = $("#genel_aciklama").val();
            let tarih = $("#gider_tarih").val();
            $.ajax({
                url: "controller/arac_controller/sql.php?islem=vergi_gider_fisi_guncelle_sql",
                type: "POST",
                data: {
                    aciklama: genel_aciklama,
                    id: "<?=$_GET["id"]?>",
                    tarih: tarih
                }, success: function (response) {
                    if (response == 1) {
                        Swal.fire(
                            'Başarılı',
                            "HGS Gider Fişi Güncellendi",
                            "success"
                        );
                        $("#vergi_guncelle_modal").modal("hide");
                        $.get("view/binek_vergi_gider.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                        $.get("view/binek_vergi_gider.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                    } else {
                        Swal.fire(
                            'Oops...',
                            "Bilinmeyen Bir Hata Oluştu",
                            "error"
                        );
                        $("#vergi_guncelle_modal").modal("hide");
                    }
                }
            });

        });

        var hgs_gider_table = "";
        $('input').click(function () {
            $(this).select();
        });

        $("body").off("click", "#hgs_gider_fisi_guncelle").on("click", "#hgs_gider_fisi_guncelle", function () {
            let tarih = $("#gider_tarih").val();
            tarih = tarih.split("-");
            let gun = tarih[2];
            let ay = tarih[1];
            let yil = tarih[0];
            let arr = [gun, ay, yil];
            tarih = arr.join("/");

            let odeme_yontemi = $("#odeme_yontemi").val();
            let kasa_id = $("#kasa_id").attr("data-id");
            let kasa_adi = $("#kasa_id").val();
            let banka_id = $("#banka_id").attr("data-id");
            let banka_adi = $("#banka_id").val();
            let kart_id = $("#kredi_kart_id").attr("data-id");
            let kart_adi = $("#kredi_kart_id").val();
            let plaka_id = $("#plaka_id").attr("data-id");
            let plaka = $("#plaka_id").val();
            let tutar = $("#hgs_tutar").val();
            tutar = tutar.replace(/\./g, "").replace(",", ".");
            tutar = parseFloat(tutar);
            let aciklama = $("#aciklama").val();
            if (plaka_id == "" || plaka_id == undefined) {
                Swal.fire(
                    'Uyarı!',
                    "Lütfen Bir Plaka Seçiniz...",
                    "warning"
                );
            } else if (tutar == 0) {
                Swal.fire(
                    'Uyarı!',
                    "Tutar 0 Olamaz",
                    "warning"
                );
            } else if (odeme_yontemi == "Nakit") {
                $.ajax({
                    url: "controller/arac_controller/sql.php?islem=vergi_gider_fisi_ekle_sql",
                    type: "POST",
                    data: {
                        odeme_yontemi: odeme_yontemi,
                        kasa_id: kasa_id,
                        banka_id: banka_id,
                        kart_id: kart_id,
                        plaka_id: plaka_id,
                        tutar: tutar,
                        gider_id: "<?=$_GET["id"]?>",
                        aciklama: aciklama
                    },
                    success: function (response) {
                        if (response != 500) {
                            var id = response;
                            id = id.split(":");
                            id = id[1];
                            tutar = parseFloat(tutar);
                            tutar = tutar.toLocaleString("tr-TR", {
                                maximumFractionDigits: 2,
                                minimumFractionDigits: 2
                            });
                            let table = hgs_gider_table.row.add([tarih, plaka, odeme_yontemi, banka_adi, kart_adi, kasa_adi, tutar, aciklama, "<button class='btn btn-danger btn-sm hgs_gider_sil_list' data-id='" + id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                            $(table).attr("banka_id", banka_id);
                            $(table).attr("kasa_id", kasa_id);
                            $(table).attr("kart_id", kart_id);
                            $(table).attr("plaka_id", plaka_id);
                        }
                    }
                });
            } else if (odeme_yontemi == "Havale") {
                $.ajax({
                    url: "controller/arac_controller/sql.php?islem=vergi_gider_fisi_ekle_sql",
                    type: "POST",
                    data: {
                        odeme_yontemi: odeme_yontemi,
                        kasa_id: kasa_id,
                        banka_id: banka_id,
                        kart_id: kart_id,
                        plaka_id: plaka_id,
                        tutar: tutar,
                        gider_id: "<?=$_GET["id"]?>",
                        aciklama: aciklama
                    },
                    success: function (response) {
                        if (response != 500) {
                            var id = response;
                            id = id.split(":");
                            id = id[1];
                            tutar = parseFloat(tutar);
                            tutar = tutar.toLocaleString("tr-TR", {
                                maximumFractionDigits: 2,
                                minimumFractionDigits: 2
                            });
                            let table = hgs_gider_table.row.add([tarih, plaka, odeme_yontemi, banka_adi, kart_adi, kasa_adi, tutar, aciklama, "<button class='btn btn-danger btn-sm hgs_gider_sil_list' data-id='" + id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                            $(table).attr("banka_id", banka_id);
                            $(table).attr("kasa_id", kasa_id);
                            $(table).attr("kart_id", kart_id);
                            $(table).attr("plaka_id", plaka_id);
                        }
                    }
                });
            } else if (odeme_yontemi == "Kart") {
                $.ajax({
                    url: "controller/arac_controller/sql.php?islem=vergi_gider_fisi_ekle_sql",
                    type: "POST",
                    data: {
                        odeme_yontemi: odeme_yontemi,
                        kasa_id: kasa_id,
                        banka_id: banka_id,
                        kart_id: kart_id,
                        plaka_id: plaka_id,
                        tutar: tutar,
                        gider_id: "<?=$_GET["id"]?>",
                        aciklama: aciklama
                    },
                    success: function (response) {
                        if (response != 500) {
                            var id = response;
                            id = id.split(":");
                            id = id[1];
                            tutar = parseFloat(tutar);
                            tutar = tutar.toLocaleString("tr-TR", {
                                maximumFractionDigits: 2,
                                minimumFractionDigits: 2
                            });
                            let table = hgs_gider_table.row.add([tarih, plaka, odeme_yontemi, banka_adi, kart_adi, kasa_adi, tutar, aciklama, "<button class='btn btn-danger btn-sm hgs_gider_sil_list' data-id='" + id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                            $(table).attr("banka_id", banka_id);
                            $(table).attr("kasa_id", kasa_id);
                            $(table).attr("kart_id", kart_id);
                            $(table).attr("plaka_id", plaka_id);
                        }
                    }
                });
            } else {
                $.ajax({
                    url: "controller/arac_controller/sql.php?islem=vergi_gider_fisi_ekle_sql",
                    type: "POST",
                    data: {
                        odeme_yontemi: odeme_yontemi,
                        kasa_id: kasa_id,
                        banka_id: banka_id,
                        kart_id: kart_id,
                        plaka_id: plaka_id,
                        tutar: tutar,
                        gider_id: "<?=$_GET["id"]?>",
                        aciklama: aciklama
                    },
                    success: function (response) {
                        if (response != 500) {
                            var id = response;
                            id = id.split(":");
                            id = id[1];
                            tutar = parseFloat(tutar);
                            tutar = tutar.toLocaleString("tr-TR", {
                                maximumFractionDigits: 2,
                                minimumFractionDigits: 2
                            });
                            let table = hgs_gider_table.row.add([tarih, plaka, odeme_yontemi, banka_adi, kart_adi, kasa_adi, tutar, aciklama, "<button class='btn btn-danger btn-sm hgs_gider_sil_list' data-id='" + id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                            $(table).attr("banka_id", banka_id);
                            $(table).attr("kasa_id", kasa_id);
                            $(table).attr("kart_id", kart_id);
                            $(table).attr("plaka_id", plaka_id);
                        }
                    }
                });
            }
            $("#odeme_yontemi").val("");
            $("#kasa_id").attr("data-id", "");
            $("#kasa_id").val("");
            $("#kasa_id").val("");
            $("#banka_id").attr("data-id", "");
            $("#banka_id").val("");
            $("#banka_id").val("");
            $("#kredi_kart_id").attr("data-id", "");
            $("#kredi_kart_id").val("");
            $("#kredi_kart_id").val("");
            $("#plaka_id").attr("data-id", "");
            $("#plaka_id").val("");
            $("#plaka_id").val("");
            $("#hgs_tutar").val("");
            $("#aciklama").val("");
        });

        $("body").off("focusout", "#hgs_tutar").on("focusout", "#hgs_tutar", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("click", ".hgs_gider_sil_list").on("click", ".hgs_gider_sil_list", function () {
            var row = $(this).closest('tr');
            let id = $(this).attr("data-id");
            $.ajax({
                url: "controller/arac_controller/sql.php?islem=vergi_gider_fisi_sil_sql",
                type: "POST",
                data: {
                    id: id
                },
                success: function (response) {
                    if (response == 1) {
                        hgs_gider_table.row(row).remove().draw(false);
                    }
                }
            });
        });

        $("body").off("click", "#toplu_irsaliye_plakalar").on("click", "#toplu_irsaliye_plakalar", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=irsaliye_plakalari_getir", function (getModal) {
                $(".arac_hgs_giderleri_plaka_getir_div").html("");
                $(".arac_hgs_giderleri_plaka_getir_div").html(getModal);
            })
        });

        $("body").off("keyup", "#plaka_id").on("keyup", "#plaka_id", function () {
            let val = $(this).val();
            $.get("konteyner/controller/irsaliye_controller/sql.php?islem=plaka_bilgilerini_getir_sql", {plaka_no: val}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#plaka_id").val(item.plaka_no);
                    $("#plaka_id").attr("data-id", item.id);
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
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'Plaka Bulundu'
                    });
                } else {
                    $("#plaka_id").attr("data-id", "");
                }
            })
        });

        $("body").off("change", "#odeme_yontemi").on("change", "#odeme_yontemi", function () {
            let val = $(this).val();
            if (val == "Nakit") {
                $(".kasa_show").show();
                $("#kredi_kart_id").val("");
                $("#kredi_kart_id").attr("data-id", "");
                $(".kart_show").hide();
                $("#banka_id").val("");
                $("#banka_id").attr("data-id", "");
                $(".banka_show").hide();
            } else if (val == "Havale") {
                $(".kasa_show").hide();
                $(".kart_show").hide();
                $("#kasa_id").val("");
                $("#kasa_id").attr("data-id", "");
                $(".banka_show").show();
                $("#kredi_kart_id").val("");
                $("#kredi_kart_id").attr("data-id", "");
            } else if (val == "Kart") {
                $(".kasa_show").hide();
                $(".kart_show").show();
                $("#banka_id").val("");
                $("#banka_id").attr("data-id", "");
                $(".banka_show").hide();
                $("#kasa_id").val("");
                $("#kasa_id").attr("data-id", "");
            } else {
                $("#kredi_kart_id").val("");
                $("#kredi_kart_id").attr("data-id", "");
                $(".kasa_show").hide();
                $(".kart_show").hide();
                $("#banka_id").val("");
                $("#banka_id").attr("data-id", "");
                $(".banka_show").hide();
                $("#kasa_id").val("");
                $("#kasa_id").attr("data-id", "");
            }
        });

        $("body").off("keyup", "#kredi_kart_id").on("keyup", "#kredi_kart_id", function () {
            let val = $("#kredi_kart_id").val();
            $.get("konteyner/controller/arac_giderleri/sql.php?islem=kredi_karti_getir_sql", {kart_kodu: val}, function (response) {
                if (response != 2) {
                    var item = JSON.parse(response);
                    $("#kredi_kart_id").val(item.kart_adi);
                    $("#kredi_kart_id").attr("data-id", item.id);
                } else {
                    $("#kredi_kart_id").attr("data-id", "");
                }
            })
        });

        $("body").off("keyup", "#banka_id").on("keyup", "#banka_id", function () {
            let val = $("#banka_id").val();
            $.get("konteyner/controller/arac_giderleri/sql.php?islem=bankalari_getir_sql", {banka_kodu: val}, function (response) {
                if (response != 2) {
                    var item = JSON.parse(response);
                    $("#banka_id").val(item.banka_adi);
                    $("#banka_id").attr("data-id", item.id);
                } else {
                    $("#banka_id").attr("data-id", "");
                }
            })
        });

        $("body").off("keyup", "#kasa_id").on("keyup", "#kasa_id", function () {
            let val = $("#kasa_id").val();
            $.get("konteyner/controller/arac_giderleri/sql.php?islem=kasalari_getir_sql", {kasa_kodu: val}, function (response) {
                if (response != 2) {
                    var item = JSON.parse(response);
                    $("#kasa_id").val(item.kasa_adi);
                    $("#kasa_id").attr("data-id", item.id);
                } else {
                    $("#kasa_id").attr("data-id", "");
                }
            })
        });

        $("body").off("click", "#arac_hgs_modal_kapat").on("click", "#arac_hgs_modal_kapat", function () {
            $("#vergi_guncelle_modal").modal("hide");
        });

        $(document).ready(function () {

            setTimeout(function () {
                $("#clickbait2").trigger("click");
            }, 500);

            $("#vergi_guncelle_modal").modal("show");
            hgs_gider_table = $('#arac_hgs_giderleri_kalem').DataTable({
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                scrollX: true,
                scrollY: "25vh",
                paging: false,
                info: false,
                createdRow: function (row) {
                    $(row).find("td").css("text-transform", "uppercase");
                    $(row).find("td").css("text-align", "left");
                    $(row).find("td").eq(6).css("text-align", "right");
                    $(row).addClass("hgs_giderleri_kalem")
                }
            });

            $.get("controller/arac_controller/sql.php?islem=vergi_gider_fisi_bilgilerini_getir_sql", {gider_id: "<?=$_GET["id"]?>"}, function (response) {
                if (response != 2) {
                    var json = JSON.parse(response);
                    json.forEach(function (item) {
                        let tutar = item.tutar;
                        tutar = parseFloat(tutar);
                        tutar = tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});

                        let banka_adi = "";
                        let kart_adi = "";
                        let kasa_adi = "";
                        if (item.kart_adi != null) {
                            kart_adi = item.kart_adi;
                        }
                        if (item.banka_adi != null) {
                            banka_adi = item.banka_adi;
                        }
                        if (item.kasa_adi != null) {
                            kasa_adi = item.kasa_adi;
                        }
                        let tarih = item.tarih;
                        tarih = tarih.split(" ");
                        tarih = tarih[0];
                        tarih = tarih.split("-");
                        let gun = tarih[2];
                        let ay = tarih[1];
                        let yil = tarih[0];
                        let arr = [gun, ay, yil];
                        tarih = arr.join("/");
                        $("#genel_aciklama").val(item.genel_aciklama)
                        hgs_gider_table.row.add([tarih, item.arac_plaka, item.odeme_yontemi, banka_adi, kart_adi, kasa_adi, tutar, item.aciklama, "<button class='btn btn-danger btn-sm hgs_gider_sil_list' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false);
                    });
                }
            })

        });

    </script>
    <?php
}