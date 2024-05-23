<?php


$islem = $_GET["islem"];

if ($islem == "yeni_forklift_tanit_main_modal") {
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
                            <div class="ibox-title" style='color:white; font-weight:bold;'>FORKLİFT TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="konteyner_irasliye_suruculeri_getir_div"></div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Forklift Grubu</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="custom-select custom-select-sm" id="forklift_grubu">
                                        <option value="Öz Mal">Öz Mal</option>
                                        <option value="Kiralık">Kiralık</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Forklift Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="forklift_adi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Forklift Kodu</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="forklift_kodu">
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
                            <button class="btn btn-danger btn-sm" id="depo_adres_tanim_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="forklift_tanim_modal_button"><i
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
            $("#depo_adres_tanim_modal").modal("show");
        });

        $("body").off("click", "#depo_adres_tanim_modal_kapat").on("click", "#depo_adres_tanim_modal_kapat", function () {
            $("#depo_adres_tanim_modal").modal("hide");
        });

        $("body").off("click", "#forklift_tanim_modal_button").on("click", "#forklift_tanim_modal_button", function () {
            let forklift_grubu = $("#forklift_grubu").val();
            let forklift_adi = $("#forklift_adi").val();
            let forklift_kodu = $("#forklift_kodu").val();
            let surucu_adi = $("#surucu_id").val();
            let surucu_id = $("#surucu_id").attr("data-id");

            $.ajax({
                url: "depo/controller/tanim_controller/sql.php?islem=yeni_forklift_tanimla",
                type: "POST",
                data: {
                    forklift_grubu: forklift_grubu,
                    forklift_adi: forklift_adi,
                    forklift_kodu: forklift_kodu,
                    surucu_id: surucu_id,
                    surucu_adi: surucu_adi
                },
                success: function (res) {
                    if (res == 1) {
                        Swal.fire(
                            "Başarılı!",
                            "Yeni Forklift Tanımlandı...",
                            "success"
                        );
                        $("#depo_adres_tanim_modal").modal("hide");
                        $.get("depo/view/forklift_tanim.php", function (getList) {
                            $(".admin-modal-icerik").html(getList);
                        });
                        $.get("depo/view/forklift_tanim.php", function (getList) {
                            $(".modal-icerik").html(getList);
                        });
                    } else if (res == 300) {
                        Swal.fire(
                            "Uyarı",
                            "Bu Forklift Zaten Tanımlı...",
                            "warning"
                        )
                    }
                }
            });

        });

    </script>
    <?php
}
if ($islem == "forklift_tanim_guncelle_modal") {
    ?>
    <style>
        #tanimlanan_forklifti_guncelle_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="tanimlanan_forklifti_guncelle_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 40%; max-width: 40%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="tanimlanan_forklifti_guncelle_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>FORKLİFT TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="konteyner_irasliye_suruculeri_getir_div"></div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Forklift Grubu</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="custom-select custom-select-sm" id="forklift_grubu">
                                        <option value="Öz Mal">Öz Mal</option>
                                        <option value="Kiralık">Kiralık</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Forklift Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="forklift_adi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Forklift Kodu</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="forklift_kodu" disabled>
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
                            <button class="btn btn-danger btn-sm" id="tanimlanan_forklifti_guncelle_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="forklift_guncelle_modal_button"><i
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
            $("#tanimlanan_forklifti_guncelle_modal").modal("show");
            $.get("depo/controller/tanim_controller/sql.php?islem=tanimlanan_forklift_bilgisi_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#forklift_grubu").val(item.forklift_grubu);
                    $("#forklift_adi").val(item.forklift_adi);
                    $("#forklift_kodu").val(item.forklift_kodu);
                    $("#surucu_id").val(item.surucu_adi);
                    $("#surucu_id").attr("data-id", item.surucu_id);
                }
            })
        });

        $("body").off("click", "#tanimlanan_forklifti_guncelle_modal_kapat").on("click", "#tanimlanan_forklifti_guncelle_modal_kapat", function () {
            $("#tanimlanan_forklifti_guncelle_modal").modal("hide");
        });

        $("body").off("click", "#forklift_guncelle_modal_button").on("click", "#forklift_guncelle_modal_button", function () {
            let forklift_grubu = $("#forklift_grubu").val();
            let forklift_adi = $("#forklift_adi").val();
            let forklift_kodu = $("#forklift_kodu").val();
            let surucu_adi = $("#surucu_id").val();
            let surucu_id = $("#surucu_id").attr("data-id");

            $.ajax({
                url: "depo/controller/tanim_controller/sql.php?islem=yeni_forklift_guncelle_sql",
                type: "POST",
                data: {
                    forklift_grubu: forklift_grubu,
                    forklift_adi: forklift_adi,
                    forklift_kodu: forklift_kodu,
                    surucu_id: surucu_id,
                    surucu_adi: surucu_adi,
                    id: "<?=$_GET["id"]?>"
                },
                success: function (res) {
                    if (res == 1) {
                        Swal.fire(
                            "Başarılı!",
                            "Yeni Forklift Tanımlandı...",
                            "success"
                        );
                        $("#tanimlanan_forklifti_guncelle_modal").modal("hide");
                        $.get("depo/view/forklift_tanim.php", function (getList) {
                            $(".admin-modal-icerik").html(getList);
                        });
                        $.get("depo/view/forklift_tanim.php", function (getList) {
                            $(".modal-icerik").html(getList);
                        });
                    } else if (res == 300) {
                        Swal.fire(
                            "Uyarı",
                            "Bu Forklift Zaten Tanımlı...",
                            "warning"
                        )
                    }
                }
            });

        });

    </script>
    <?php
}