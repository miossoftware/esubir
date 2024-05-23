<?php


$islem = $_GET["islem"];


if ($islem == "yeni_arac_tanit_modal") {
    ?>
    <style>
        #depo_adres_tanim_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="depo_adres_tanim_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 40%; max-width: 40%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="depo_adres_tanim_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ARAÇ TANIM</div>
                        </div>
                        <div class="modal-body">
                            <div id="carileri_getir_irsaliye"></div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>İş Emri</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="epro_ref">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm" id="is_emirlerini_getir_button"><i
                                                        class="fa fa-ellipsis-h"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Plaka No</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="arac_tanim_plaka_no">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Dorse Plaka</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="dorse_plaka">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Sürücü Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="surucu_adi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Sürücü Tel</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="surucu_tel">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Açıklama</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="aciklama">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="depo_adres_tanim_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="depo_arac_tanim_kaydet_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("body").off("click", "#is_emirlerini_getir_button").on("click", "#is_emirlerini_getir_button", function () {
            $.get("depo/modals/konteyner_modal/arac_giris_yap_main_modal.php?islem=is_emirlerini_getir_sql", function (getModal) {
                $("#carileri_getir_irsaliye").html(getModal);
            })
        });

        $("body").off("click", "#depo_arac_tanim_kaydet_button").on("click", "#depo_arac_tanim_kaydet_button", function () {
            let is_id = $("#epro_ref").attr("data-id");
            let metin = $("#epro_ref").val();
            metin = metin.match(/^İTH/);
            let tipi = "";
            if (metin) {
                tipi = "İTHALAT";
            } else {
                tipi = "İHRACAT";
            }
            let arac_tanim_plaka_no = $("#arac_tanim_plaka_no").val();
            let dorse_plaka = $("#dorse_plaka").val();
            let surucu_adi = $("#surucu_adi").val();
            let surucu_tel = $("#surucu_tel").val();
            let aciklama = $("#aciklama").val();
            $.ajax({
                url: "depo/controller/tanim_controller/sql.php?islem=arac_tanim_kaydet_sql",
                type: "POST",
                data: {
                    is_emri_id: is_id,
                    tipi: tipi,
                    plaka_no: arac_tanim_plaka_no,
                    dorse_plaka: dorse_plaka,
                    surucu_adi: surucu_adi,
                    surucu_tel: surucu_tel,
                    aciklama: aciklama
                },
                success: function (res) {
                    if (res == 1) {
                        Swal.fire(
                            "Başarılı!",
                            "Araç Tanımlandı...",
                            "success"
                        );
                        $("#depo_adres_tanim_modal").modal("hide");
                        $.get("depo/view/depo_arac_tanim.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                        $.get("depo/view/depo_arac_tanim.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                    }
                }
            });
        });

        $(document).ready(function () {
            $("#depo_adres_tanim_modal").modal("show");
        });

        $("body").off("click", "#depo_adres_tanim_modal_kapat").on("click", "#depo_adres_tanim_modal_kapat", function () {
            $("#depo_adres_tanim_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "yeni_arac_guncelle_modal") {
    ?>
    <style>
        #depo_arac_tanim_guncelle_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="depo_arac_tanim_guncelle_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 40%; max-width: 40%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="depo_arac_tanim_guncelle_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ARAÇ TANIM</div>
                        </div>
                        <div class="modal-body">
                            <div id="carileri_getir_irsaliye"></div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>İş Emri</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="epro_ref">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm" id="is_emirlerini_getir_button"><i
                                                        class="fa fa-ellipsis-h"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Plaka No</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="arac_tanim_plaka_no">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Dorse Plaka</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="dorse_plaka">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Sürücü Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="surucu_adi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Sürücü Tel</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="surucu_tel">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Açıklama</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="aciklama">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="depo_arac_tanim_guncelle_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="depo_arac_tanim_kaydet_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("body").off("click", "#is_emirlerini_getir_button").on("click", "#is_emirlerini_getir_button", function () {
            $.get("depo/modals/konteyner_modal/arac_giris_yap_main_modal.php?islem=is_emirlerini_getir_sql", function (getModal) {
                $("#carileri_getir_irsaliye").html(getModal);
            })
        });

        $("body").off("click", "#depo_arac_tanim_kaydet_button").on("click", "#depo_arac_tanim_kaydet_button", function () {
            let is_id = $("#epro_ref").attr("data-id");
            let metin = $("#epro_ref").val();
            metin = metin.match(/^İTH/);
            let tipi = "";
            if (metin) {
                tipi = "İTHALAT";
            } else {
                tipi = "İHRACAT";
            }
            let arac_tanim_plaka_no = $("#arac_tanim_plaka_no").val();
            let dorse_plaka = $("#dorse_plaka").val();
            let surucu_adi = $("#surucu_adi").val();
            let surucu_tel = $("#surucu_tel").val();
            let aciklama = $("#aciklama").val();
            $.ajax({
                url: "depo/controller/tanim_controller/sql.php?islem=arac_tanim_guncelle_sql",
                type: "POST",
                data: {
                    is_emri_id: is_id,
                    tipi: tipi,
                    plaka_no: arac_tanim_plaka_no,
                    dorse_plaka: dorse_plaka,
                    surucu_adi: surucu_adi,
                    surucu_tel: surucu_tel,
                    aciklama: aciklama,
                    id: "<?=$_GET["id"]?>"
                },
                success: function (res) {
                    if (res == 1) {
                        Swal.fire(
                            "Başarılı!",
                            "Araç Tanımlandı...",
                            "success"
                        );
                        $("#depo_arac_tanim_guncelle_modal").modal("hide");
                        $.get("depo/view/depo_arac_tanim.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                        $.get("depo/view/depo_arac_tanim.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                    }
                }
            });
        });

        $(document).ready(function () {
            $("#depo_arac_tanim_guncelle_modal").modal("show");
            $.get("depo/controller/tanim_controller/sql.php?islem=tanitilan_arac_bilgilerini_getir_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#epro_ref").attr("data-id", item.is_emri_id)
                    $("#epro_ref").val(item.epro_ref);
                    $("#arac_tanim_plaka_no").val(item.plaka_no)
                    $("#dorse_plaka").val(item.dorse_plaka)
                    $("#surucu_adi").val(item.surucu_adi)
                    $("#surucu_tel").val(item.surucu_tel)
                    $("#aciklama").val(item.aciklama)
                }
            })
        });

        $("body").off("click", "#depo_arac_tanim_guncelle_modal_kapat").on("click", "#depo_arac_tanim_guncelle_modal_kapat", function () {
            $("#depo_arac_tanim_guncelle_modal").modal("hide");
        });

    </script>
    <?php
}