<?php

$islem = $_GET["islem"];

if ($islem == "depo_adres_tanimlama_modal") {
    ?>
    <style>
        #mal_cinsi_tanimla {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="mal_cinsi_tanimla" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 35%; max-width: 35%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="mal_cinsi_tanimla_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>MAL CİNSİ TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Mal Kodu</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="mal_kodu">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Mal Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="mal_adi">
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
                            <button class="btn btn-danger btn-sm" id="mal_cinsi_tanimla_kapat"><i
                                    class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="mal_cinsi_kaydet_button"><i
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
            $("#mal_cinsi_tanimla").modal("show");
        });

        $("body").off("click", "#mal_cinsi_tanimla_kapat").on("click", "#mal_cinsi_tanimla_kapat", function () {
            $("#mal_cinsi_tanimla").modal("hide");
        });

        $("body").off("click", "#mal_cinsi_kaydet_button").on("click", "#mal_cinsi_kaydet_button", function () {
            let mal_kodu = $("#mal_kodu").val();
            let mal_adi = $("#mal_adi").val();
            let aciklama = $("#aciklama").val();
            $.ajax({
                url: "depo/controller/tanim_controller/sql.php?islem=mal_cinsi_kaydet_sql",
                type: "POST",
                data: {
                    mal_adi: mal_adi,
                    mal_kodu: mal_kodu,
                    aciklama: aciklama
                },
                success: function (res) {
                    if (res == 1) {
                        Swal.fire(
                            "Başarılı!",
                            "Mal Cinsi Tanımlandı",
                            "success"
                        );
                        $("#mal_cinsi_tanimla").modal("hide");
                        $.get("depo/view/mal_cinsi_tanimi.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                        $.get("depo/view/mal_cinsi_tanimi.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                    } else if (res == 300) {
                        Swal.fire(
                            "Uyarı!",
                            "Bu Mal Kayıtlı",
                            "warning"
                        );
                    }
                }
            });
        });

    </script>
    <?php
}
if ($islem == "mal_cinsi_guncelle_button") {
    ?>
    <style>
        #mal_cinsi_guncelle_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="mal_cinsi_guncelle_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 35%; max-width: 35%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="mal_cinsi_guncelle_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>MAL CİNSİ TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Mal Kodu</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="mal_kodu" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Mal Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="mal_adi">
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
                            <button class="btn btn-danger btn-sm" id="mal_cinsi_guncelle_modal_kapat"><i
                                    class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="mal_cinsi_kaydet_button"><i
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
            $("#mal_cinsi_guncelle_modal").modal("show");
            $.get("depo/controller/tanim_controller/sql.php?islem=mal_cinsi_detayini_getir_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#mal_kodu").val(item.mal_kodu);
                    $("#mal_adi").val(item.mal_adi);
                    $("#aciklama").val(item.aciklama);
                }
            })
        });

        $("body").off("click", "#mal_cinsi_guncelle_modal_kapat").on("click", "#mal_cinsi_guncelle_modal_kapat", function () {
            $("#mal_cinsi_guncelle_modal").modal("hide");
        });

        $("body").off("click", "#mal_cinsi_kaydet_button").on("click", "#mal_cinsi_kaydet_button", function () {
            let mal_kodu = $("#mal_kodu").val();
            let mal_adi = $("#mal_adi").val();
            let aciklama = $("#aciklama").val();
            $.ajax({
                url: "depo/controller/tanim_controller/sql.php?islem=mal_cinsi_guncelle_sql",
                type: "POST",
                data: {
                    mal_adi: mal_adi,
                    mal_kodu: mal_kodu,
                    aciklama: aciklama,
                    id:"<?=$_GET["id"]?>"
                },
                success: function (res) {
                    if (res == 1) {
                        Swal.fire(
                            "Başarılı!",
                            "Mal Cinsi Tanımlandı",
                            "success"
                        );
                        $("#mal_cinsi_guncelle_modal").modal("hide");
                        $.get("depo/view/mal_cinsi_tanimi.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                        $.get("depo/view/mal_cinsi_tanimi.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                    } else if (res == 300) {
                        Swal.fire(
                            "Uyarı!",
                            "Bu Mal Kayıtlı",
                            "warning"
                        );
                    }
                }
            });
        });

    </script>
    <?php
}