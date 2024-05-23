<?php

$islem = $_GET["islem"];
if ($islem == "uye_acilis_fisi_ekle_modal") {
    ?>
    <div class="modal fade" id="uye_acilis_fisi_ekle_modal" data-bs-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 30%; max-width: 30%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="uye_acilis_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ÜYE AÇILIŞ FİŞİ</div>
                        </div>
                        <div class="modal-body">
                            <div id="uyeleri_getir_div"></div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>TC No</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="tc_no">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm" id="uye_getir_button"><i
                                                        class="fa fa-ellipsis-h"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Üye Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="uye_adi" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Tarih</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="date" class="form-control form-control-sm" id="tarih"
                                           value="<?= date("Y-m-d") ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Borç</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="borc" style="text-align: right"
                                           class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Alacak</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="alacak" style="text-align: right"
                                           class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="uye_acilis_vazgec"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="uye_acilis_fisi_kaydet"><i
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
            $("#uye_acilis_fisi_ekle_modal").modal("show");
        });

        $("body").off("click", "#uye_acilis_vazgec").on("click", "#uye_acilis_vazgec", function () {
            $("#uye_acilis_fisi_ekle_modal").modal("hide");
        });

        $("body").off("click", "#uye_getir_button").on("click", "#uye_getir_button", function () {
            $.get("modals/uye_modal/modal.php?islem=uyeleri_getir_modal", function (getModal) {
                $("#uyeleri_getir_div").html(getModal);
            })
        });
        $("body").off("focusout", "#borc").on("focusout", "#borc", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });
        $("body").off("focusout", "#alacak").on("focusout", "#alacak", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("click", "#uye_acilis_fisi_kaydet").on("click", "#uye_acilis_fisi_kaydet", function () {
            let uye_id = $("#tc_no").attr("data-id");
            let tarih = $("#tarih").val();
            let borc = $("#borc").val();
            borc = borc.replace(/\./g, "").replace(",", ".");
            borc = parseFloat(borc);
            let alacak = $("#alacak").val();
            alacak = alacak.replace(/\./g, "").replace(",", ".");
            alacak = parseFloat(alacak);
            if (uye_id == "" || uye_id == undefined) {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Üye Giriniz...",
                    "warning"
                );
            } else if (tarih == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Tarih Giriniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "controller/uye_controller/sql.php?islem=uye_acilis_fisi_kaydet_sql",
                    type: "POST",
                    data: {
                        uye_id: uye_id,
                        acilis_tarihi: tarih,
                        borc: borc,
                        alacak: alacak
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı!",
                                "Üye Açılış Fişi Kaydedildi",
                                "success"
                            );
                            $("#uye_acilis_fisi_ekle_modal").modal("hide");
                            $.get("view/uye_acilis_fisi.php", function (getList) {
                                $(".admin-modal-icerik").html(getList);
                            })
                            $.get("view/uye_acilis_fisi.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            })
                        } else {
                            Swal.fire(
                                "Oops...",
                                "Bilinmeyen Bir Hata Oluştu...",
                                "error"
                            );
                        }
                    }
                });
            }
        });

    </script>
    <?php
}
if ($islem == "uye_acilis_guncelle_modal") {
    ?>
    <div class="modal fade" id="uye_acilis_fisi_guncelle_modal" data-bs-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 30%; max-width: 30%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="uye_acilis_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ÜYE AÇILIŞ FİŞİ</div>
                        </div>
                        <div class="modal-body">
                            <div id="uyeleri_getir_div"></div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>TC No</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm" id="tc_no">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm" id="uye_getir_button"><i
                                                        class="fa fa-ellipsis-h"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Üye Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="uye_adi" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Tarih</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="date" class="form-control form-control-sm" id="tarih"
                                           value="<?= date("Y-m-d") ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Borç</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="borc" style="text-align: right"
                                           class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Alacak</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="alacak" style="text-align: right"
                                           class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="uye_acilis_vazgec"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="uye_acilis_fisi_kaydet"><i
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
            $("#uye_acilis_fisi_guncelle_modal").modal("show");
            $.get("controller/uye_controller/sql.php?islem=acilis_bilgilerini_getir_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#tc_no").attr("data-id", item.uye_id);
                    $("#tc_no").val(item.tc_no);
                    let tarih = item.acilis_tarihi;
                    tarih = tarih.split(" ");
                    tarih = tarih[0];
                    $("#tarih").val(tarih);
                    let borc = item.borc;
                    borc = parseFloat(borc);
                    borc = borc.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                    let alacak = item.alacak;
                    alacak = parseFloat(alacak);
                    alacak = alacak.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                    $("#borc").val(borc);
                    $("#alacak").val(alacak);
                }
            })
        });

        $("body").off("click", "#uye_acilis_vazgec").on("click", "#uye_acilis_vazgec", function () {
            $("#uye_acilis_fisi_guncelle_modal").modal("hide");
        });

        $("body").off("click", "#uye_getir_button").on("click", "#uye_getir_button", function () {
            $.get("modals/uye_modal/modal.php?islem=uyeleri_getir_modal", function (getModal) {
                $("#uyeleri_getir_div").html(getModal);
            })
        });
        $("body").off("focusout", "#borc").on("focusout", "#borc", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });
        $("body").off("focusout", "#alacak").on("focusout", "#alacak", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("click", "#uye_acilis_fisi_kaydet").on("click", "#uye_acilis_fisi_kaydet", function () {
            let uye_id = $("#tc_no").attr("data-id");
            let tarih = $("#tarih").val();
            let borc = $("#borc").val();
            borc = borc.replace(/\./g, "").replace(",", ".");
            borc = parseFloat(borc);
            let alacak = $("#alacak").val();
            alacak = alacak.replace(/\./g, "").replace(",", ".");
            alacak = parseFloat(alacak);
            if (uye_id == "" || uye_id == undefined) {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Üye Giriniz...",
                    "warning"
                );
            } else if (tarih == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Tarih Giriniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "controller/uye_controller/sql.php?islem=uye_acilis_fisi_guncelle_sql",
                    type: "POST",
                    data: {
                        uye_id: uye_id,
                        acilis_tarihi: tarih,
                        borc: borc,
                        alacak: alacak,
                        id: "<?=$_GET["id"]?>"
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı!",
                                "Üye Açılış Fişi Kaydedildi",
                                "success"
                            );
                            $("#uye_acilis_fisi_guncelle_modal").modal("hide");
                            $.get("view/uye_acilis_fisi.php", function (getList) {
                                $(".admin-modal-icerik").html(getList);
                            })
                            $.get("view/uye_acilis_fisi.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            })
                        } else {
                            Swal.fire(
                                "Oops...",
                                "Bilinmeyen Bir Hata Oluştu...",
                                "error"
                            );
                        }
                    }
                });
            }
        });

    </script>
    <?php
}