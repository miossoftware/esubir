<?php

$islem = $_GET["islem"];
if ($islem == "tarife_tanimla_modal") {
    ?>
    <div class="modal fade" id="tarife_tanim_ekle_modal" data-bs-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 30%; max-width: 30%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="tarife_tanim_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>TARİFE TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Üye Türü</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="custom-select custom-select-sm" id="uye_turu">
                                        <option value="Üye">Üye</option>
                                        <option value="Üye Değil">Üye Değil</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Tarife Kodu</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="tarife_kodu">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Tarife Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="tarife_adi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Tarife Fiyat</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="tarife_fiyati"
                                           style="text-align: right">
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
                            <button class="btn btn-danger btn-sm" id="tarife_tanim_vazgec"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="tarife_kaydet_button"><i class="fa fa-check"></i>
                                Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("body").off("click", "#tarife_kaydet_button").on("click", "#tarife_kaydet_button", function () {
            let tarife_kodu = $("#tarife_kodu").val();
            let tarife_adi = $("#tarife_adi").val();
            let uye_turu = $("#uye_turu").val();
            let tarife_fiyati = $("#tarife_fiyati").val();
            tarife_fiyati = tarife_fiyati.replace(/\./g, "").replace(",", ".");
            tarife_fiyati = parseFloat(tarife_fiyati);
            let aciklama = $("#aciklama").val();
            if (tarife_kodu == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Tarife Kodu Giriniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "controller/uye_controller/sql.php?islem=tarife_tanim_sql",
                    type: "POST",
                    data: {
                        tarife_kodu: tarife_kodu,
                        tarife_adi: tarife_adi,
                        tarife_fiyati: tarife_fiyati,
                        uye_mi: uye_turu,
                        aciklama: aciklama
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı!",
                                "Tarife Tanımlandı",
                                "success"
                            );
                            $("#tarife_tanim_ekle_modal").modal("hide");
                            $.get("view/uye_tarife_tanim.php", function (getList) {
                                $(".admin-modal-icerik").html(getList);
                            })
                            $.get("view/uye_tarife_tanim.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            })
                        } else if (res == 300) {
                            Swal.fire(
                                "Uyarı",
                                "Bu Tarife Tanımlı",
                                "warning"
                            );
                        } else {
                            Swal.fire(
                                "Oops...",
                                "Bilinmeyen Bir Hata Oluştur",
                                "error"
                            );
                        }
                    }
                });
            }
        });
        $("body").off("focusout", "#tarife_fiyati").on("focusout", "#tarife_fiyati", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 5, minimumFractionDigits: 5}));
        });

        $(document).ready(function () {
            $("#tarife_tanim_ekle_modal").modal("show");
        });

        $("body").off("click", "#tarife_tanim_vazgec").on("click", "#tarife_tanim_vazgec", function () {
            $("#tarife_tanim_ekle_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "tarife_guncelle") {
    ?>
    <div class="modal fade" id="tarife_guncelle_modal" data-bs-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 30%; max-width: 30%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="tarife_tanim_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>TARİFE TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Üye Türü</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="custom-select custom-select-sm" id="uye_turu">
                                        <option value="">Seçiniz...</option>
                                        <option value="Üye">Üye</option>
                                        <option value="Üye Değil">Üye Değil</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Tarife Kodu</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="tarife_kodu" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Tarife Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="tarife_adi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Tarife Fiyatı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" id="tarife_fiyati"
                                           style="text-align: right">
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
                            <button class="btn btn-danger btn-sm" id="tarife_tanim_vazgec"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="tarife_guncelle_button"><i
                                        class="fa fa-check"></i>
                                Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("body").off("click", "#tarife_guncelle_button").on("click", "#tarife_guncelle_button", function () {
            let tarife_kodu = $("#tarife_kodu").val();
            let tarife_adi = $("#tarife_adi").val();
            let aciklama = $("#aciklama").val();
            let uye_turu = $("#uye_turu").val();
            let tarife_fiyati = $("#tarife_fiyati").val();
            tarife_fiyati = tarife_fiyati.replace(/\./g, "").replace(",", ".");
            tarife_fiyati = parseFloat(tarife_fiyati);
            if (tarife_kodu == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Tarife Kodu Giriniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "controller/uye_controller/sql.php?islem=tarife_guncelle_sql",
                    type: "POST",
                    data: {
                        tarife_kodu: tarife_kodu,
                        tarife_adi: tarife_adi,
                        tarife_fiyati: tarife_fiyati,
                        uye_mi: uye_turu,
                        aciklama: aciklama
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı!",
                                "Tarife Güncellendi...",
                                "success"
                            );
                            $("#tarife_guncelle_modal").modal("hide");
                            $.get("view/uye_tarife_tanim.php", function (getList) {
                                $(".admin-modal-icerik").html(getList);
                            })
                            $.get("view/uye_tarife_tanim.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            })
                        } else if (res == 300) {
                            Swal.fire(
                                "Uyarı",
                                "Bu Tarife Tanımlı",
                                "warning"
                            );
                        } else {
                            Swal.fire(
                                "Oops...",
                                "Bilinmeyen Bir Hata Oluştur",
                                "error"
                            );
                        }
                    }
                });
            }
        });

        $(document).ready(function () {
            $("#tarife_guncelle_modal").modal("show");

            $.get("controller/uye_controller/sql.php?islem=secilen_tarifeyi_getir_sql", {tarife_kodu: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#tarife_kodu").val(item.tarife_kodu);
                    $("#tarife_adi").val(item.tarife_adi);
                    $("#aciklama").val(item.aciklama);
                    $("#uye_turu").val(item.uye_mi)
                    let tarife_fiyati = item.tarife_fiyati;
                    tarife_fiyati = parseFloat(tarife_fiyati);
                    tarife_fiyati = tarife_fiyati.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })
                    $("#tarife_fiyati").val(tarife_fiyati);
                }
            })

        });


        $("body").off("focusout", "#tarife_fiyati").on("focusout", "#tarife_fiyati", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 5, minimumFractionDigits: 5}));
        });

        $("body").off("click", "#tarife_tanim_vazgec").on("click", "#tarife_tanim_vazgec", function () {
            $("#tarife_guncelle_modal").modal("hide");
        });

    </script>
    <?php
}