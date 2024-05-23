<?php


$islem = $_GET["islem"];


if ($islem == "yeni_kalmar_tanit_main_modal") {
    ?>
    <style>
        #yeni_kalmar_tanim_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="yeni_kalmar_tanim_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 40%; max-width: 40%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="yeni_kalmar_tanim_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>KALMAR TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="konteyner_irasliye_suruculeri_getir_div"></div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Kalmar Grubu</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="custom-select custom-select-sm" id="kalmar_grubu">
                                        <option value="Öz Mal">Öz Mal</option>
                                        <option value="Kiralık">Kiralık</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Kalmar Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="kalmar_adi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Kalmar Kodu</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="kalmar_kodu">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Sürücü</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm"
                                               id="surucu_id">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm"
                                                    id="irsaliye_icin_suruculeri_getir_button"><i
                                                        class="fa fa-ellipsis-h"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="yeni_kalmar_tanim_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="kalmar_tanim_modal_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("body").off("click", "#irsaliye_icin_suruculeri_getir_button").on("click", "#irsaliye_icin_suruculeri_getir_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=irsaliye_icin_suruculeri_getir", function (getModal) {
                $(".konteyner_irasliye_suruculeri_getir_div").html("");
                $(".konteyner_irasliye_suruculeri_getir_div").html(getModal);
            });
        });

        $(document).ready(function () {
            $("#yeni_kalmar_tanim_modal").modal("show");
        });

        $("body").off("click", "#yeni_kalmar_tanim_modal_kapat").on("click", "#yeni_kalmar_tanim_modal_kapat", function () {
            $("#yeni_kalmar_tanim_modal").modal("hide");
        });

        $("body").off("click", "#kalmar_tanim_modal_button").on("click", "#kalmar_tanim_modal_button", function () {
            let kalmar_grubu = $("#kalmar_grubu").val();
            let kalmar_adi = $("#kalmar_adi").val();
            let kalmar_kodu = $("#kalmar_kodu").val();
            let surucu_adi = $("#surucu_id").val();
            let surucu_id = $("#surucu_id").attr("data-id");

            $.ajax({
                url: "depo/controller/tanim_controller/sql.php?islem=yeni_kalmar_tanimla",
                type: "POST",
                data: {
                    kalmar_grubu: kalmar_grubu,
                    kalmar_adi: kalmar_adi,
                    kalmar_kodu: kalmar_kodu,
                    surucu_id: surucu_id,
                    surucu_adi: surucu_adi
                },
                success: function (res) {
                    if (res == 1) {
                        Swal.fire(
                            "Başarılı!",
                            "Yeni Kalmar Tanımlandı...",
                            "success"
                        );
                        $("#yeni_kalmar_tanim_modal").modal("hide");
                        $.get("depo/view/kalmar_tanim.php", function (getList) {
                            $(".admin-modal-icerik").html(getList);
                        });
                        $.get("depo/view/kalmar_tanim.php", function (getList) {
                            $(".modal-icerik").html(getList);
                        });
                    } else if (res == 300) {
                        Swal.fire(
                            "Uyarı",
                            "Bu kalmar Zaten Tanımlı...",
                            "warning"
                        )
                    }
                }
            });

        });

    </script>
    <?php
}
if ($islem == "kalmar_tanim_guncelle_modal") {
    ?>
    <style>
        #yeni_kalmar_tanim_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="yeni_kalmar_tanim_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 40%; max-width: 40%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="yeni_kalmar_tanim_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>KALMAR TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="konteyner_irasliye_suruculeri_getir_div"></div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Kalmar Grubu</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="custom-select custom-select-sm" id="kalmar_grubu">
                                        <option value="Öz Mal">Öz Mal</option>
                                        <option value="Kiralık">Kiralık</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Kalmar Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="kalmar_adi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Kalmar Kodu</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="kalmar_kodu" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Sürücü</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm"
                                               id="surucu_id">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm"
                                                    id="irsaliye_icin_suruculeri_getir_button"><i
                                                        class="fa fa-ellipsis-h"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="yeni_kalmar_tanim_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="kalmar_guncelle_modal_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("body").off("click", "#irsaliye_icin_suruculeri_getir_button").on("click", "#irsaliye_icin_suruculeri_getir_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=irsaliye_icin_suruculeri_getir", function (getModal) {
                $(".konteyner_irasliye_suruculeri_getir_div").html("");
                $(".konteyner_irasliye_suruculeri_getir_div").html(getModal);
            });
        });

        $(document).ready(function () {
            $("#yeni_kalmar_tanim_modal").modal("show");
            $.get("depo/controller/tanim_controller/sql.php?islem=ilgili_kalmari_getir_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#kalmar_grubu").val(item.kalmar_grubu);
                    $("#kalmar_adi").val(item.kalmar_adi);
                    $("#kalmar_kodu").val(item.kalmar_kodu);
                    $("#surucu_id").val(item.surucu_adi);
                    $("#surucu_id").attr("data-id", item.surucu_id);
                }
            })
        });

        $("body").off("click", "#yeni_kalmar_tanim_modal_kapat").on("click", "#yeni_kalmar_tanim_modal_kapat", function () {
            $("#yeni_kalmar_tanim_modal").modal("hide");
        });

        $("body").off("click", "#kalmar_guncelle_modal_button").on("click", "#kalmar_guncelle_modal_button", function () {
            let kalmar_grubu = $("#kalmar_grubu").val();
            let kalmar_adi = $("#kalmar_adi").val();
            let kalmar_kodu = $("#kalmar_kodu").val();
            let surucu_adi = $("#surucu_id").val();
            let surucu_id = $("#surucu_id").attr("data-id");

            $.ajax({
                url: "depo/controller/tanim_controller/sql.php?islem=yeni_kalmar_guncelle",
                type: "POST",
                data: {
                    kalmar_grubu: kalmar_grubu,
                    kalmar_adi: kalmar_adi,
                    kalmar_kodu: kalmar_kodu,
                    surucu_id: surucu_id,
                    surucu_adi: surucu_adi,
                    id: "<?=$_GET["id"]?>"
                },
                success: function (res) {
                    if (res == 1) {
                        Swal.fire(
                            "Başarılı!",
                            "Yeni Kalmar Tanımlandı...",
                            "success"
                        );
                        $("#yeni_kalmar_tanim_modal").modal("hide");
                        $.get("depo/view/kalmar_tanim.php", function (getList) {
                            $(".admin-modal-icerik").html(getList);
                        });
                        $.get("depo/view/kalmar_tanim.php", function (getList) {
                            $(".modal-icerik").html(getList);
                        });
                    } else if (res == 300) {
                        Swal.fire(
                            "Uyarı",
                            "Bu kalmar Zaten Tanımlı...",
                            "warning"
                        )
                    }
                }
            });

        });

    </script>
    <?php
}