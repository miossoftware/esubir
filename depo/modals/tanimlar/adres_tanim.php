<?php

$islem = $_GET["islem"];

if ($islem == "depo_adres_tanimlama_modal") {
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
                            <div class="ibox-title" style='color:white; font-weight:bold;'>DEPO ADRES TANIMLA
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Adres Kodu</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="adres_kodu">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Adres Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="adres_adi">
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
                            <button class="btn btn-success btn-sm" id="depo_adres_kaydet_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function () {
            $("#depo_adres_tanim_modal").modal("show");
        });

        $("body").off("click", "#depo_adres_tanim_modal_kapat").on("click", "#depo_adres_tanim_modal_kapat", function () {
            $("#depo_adres_tanim_modal").modal("hide");
        });

        $("body").off("click", "#depo_adres_kaydet_button").on("click", "#depo_adres_kaydet_button", function () {
            let adres_kodu = $("#adres_kodu").val();
            let adres_adi = $("#adres_adi").val();
            let aciklama = $("#aciklama").val();

            $.ajax({
                url: "depo/controller/tanim_controller/sql.php?islem=depo_adresi_kaydet_sql",
                type: "POST",
                data: {
                    adres_kodu: adres_kodu,
                    adres_adi: adres_adi,
                    aciklama: aciklama
                },
                success: function (res) {
                    if (res == 1) {
                        Swal.fire(
                            "Başarılı!",
                            "Adres Başarılı İle Tanımlandı",
                            "success"
                        );
                        $("#depo_adres_tanim_modal").modal("hide");
                        $.get("depo/view/konteyner_adres_tanimi.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                        $.get("depo/view/konteyner_adres_tanimi.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                    } else if (res == 300) {
                        Swal.fire(
                            "Uyarı!",
                            "Bu Adres Sistemde Tanımlıdır...",
                            "warning"
                        );
                    }
                }
            });
        });

    </script>
    <?php
}
if ($islem == "depo_adres_guncelleme_modal") {
    ?>
    <style>
        #depo_adresi_guncelle_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="depo_adresi_guncelle_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 40%; max-width: 40%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="depo_adresi_guncelle_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>DEPO ADRES TANIMLA
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Adres Kodu</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" disabled class="form-control form-control-sm" id="adres_kodu">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Adres Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="adres_adi">
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
                            <button class="btn btn-danger btn-sm" id="depo_adresi_guncelle_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="depo_adres_kaydet_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function () {
            $("#depo_adresi_guncelle_modal").modal("show");
            $.get("depo/controller/tanim_controller/sql.php?islem=adres_tanim_bilgilerini_getir_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#adres_adi").val(item.adres_adi);
                    $("#adres_kodu").val(item.adres_kodu);
                    $("#aciklama").val(item.aciklama);
                }
            })
        });

        $("body").off("click", "#depo_adresi_guncelle_modal_kapat").on("click", "#depo_adresi_guncelle_modal_kapat", function () {
            $("#depo_adresi_guncelle_modal").modal("hide");
        });

        $("body").off("click", "#depo_adres_kaydet_button").on("click", "#depo_adres_kaydet_button", function () {
            let adres_kodu = $("#adres_kodu").val();
            let adres_adi = $("#adres_adi").val();
            let aciklama = $("#aciklama").val();

            $.ajax({
                url: "depo/controller/tanim_controller/sql.php?islem=depo_adresi_guncelle_sql",
                type: "POST",
                data: {
                    adres_kodu: adres_kodu,
                    adres_adi: adres_adi,
                    aciklama: aciklama,
                    id: "<?=$_GET["id"]?>"
                },
                success: function (res) {
                    if (res == 1) {
                        Swal.fire(
                            "Başarılı!",
                            "Adres Başarılı İle Tanımlandı",
                            "success"
                        );
                        $("#depo_adresi_guncelle_modal").modal("hide");
                        $.get("depo/view/konteyner_adres_tanimi.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                        $.get("depo/view/konteyner_adres_tanimi.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                    } else if (res == 300) {
                        Swal.fire(
                            "Uyarı!",
                            "Bu Adres Sistemde Tanımlıdır...",
                            "warning"
                        );
                    }
                }
            });
        });

    </script>
    <?php
}