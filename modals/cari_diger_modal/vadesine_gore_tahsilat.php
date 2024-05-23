<?php

$islem = $_GET["islem"];

if ($islem == "vade_kriterleri_modal") {
    ?>
    <div class="modal fade" id="vade_kriterleri_modal" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 30%; max-width: 30%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="vade_filtre_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>Vadesine Göre Tahsilat
                                Maddeleri
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>İlk Vade Tarihi</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="date" value="<?= date("1899-m-d") ?>" id="ilk_vade"
                                           class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Son Vade Tarihi</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="date" value="<?= date("Y-m-d") ?>" id="son_vade"
                                           class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>İlk Bakiye</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" style="text-align: right"
                                           id="bakiye_limit"
                                           value="1,00">
                                </div>
                            </div>
<!--                            <div class="form-group row">-->
<!--                                <div class="col-md-4">-->
<!--                                    <label>Cari Grubu</label>-->
<!--                                </div>-->
<!--                                <div class="col-md-7">-->
<!--                                    <select class="custom-select custom-select-sm" id="cari_grubu">-->
<!--                                        <option value="0">Hepsi</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Cari Türü</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="custom-select custom-select-sm" id="cari_turu">
                                        <option value="0">Hepsi</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="vade_filtre_vazgec"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-secondary btn-sm" id="vadesine_gore_borc_alacak_hazirla_button"><i
                                        class="fa fa-filter"></i> Hazırla
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("body").off("click", "#vade_filtre_vazgec").on("click", "#vade_filtre_vazgec", function () {
            $("#vade_kriterleri_modal").modal("hide");
        });

        $("body").off("focusout", "#bakiye_limit").on("focusout", "#bakiye_limit", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        })

        $("input").click(function () {
            $(this).select();
        });

        $(document).ready(function () {
            $("#vade_kriterleri_modal").modal("show");

            $.get("controller/cari_controller/sql.php?islem=cari_turleri_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#cari_turu").append("" +
                            "<option value='" + item.id + "' gider_mi='"+item.gider_hesabi+"'>" + item.cari_turu_adi + "</option>" +
                            "");
                    })
                }
            })
            $.get("controller/cari_controller/sql.php?islem=cari_gruplarini_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#cari_grubu").append("" +
                            "<option value='" + item.id + "'>" + item.cari_grup_adi + "</option>" +
                            "");
                    })
                }
            })
        });

        $("body").off("click", "#vadesine_gore_borc_alacak_hazirla_button").on("click", "#vadesine_gore_borc_alacak_hazirla_button", function () {
            let ilk_vade = $("#ilk_vade").val();
            let son_vade = $("#son_vade").val();
            let bakiye_limit = $("#bakiye_limit").val();
            bakiye_limit = bakiye_limit.replace(/\./g, "").replace(",", ".");
            bakiye_limit = parseFloat(bakiye_limit);
            let cari_grubu = $("#cari_grubu").val();
            let cari_turu = $("#cari_turu").val();
            let cari_gider_mi = $("#cari_turu option:selected").attr("gider_mi");
            if (cari_gider_mi == 1){
                Swal.fire(
                    "Uyarı",
                    "Gider Raporlarına Diğer Rapor Seçeneklerinden Bakabilirsiniz...",
                    "warning"
                )
            }else {
                $.get("controller/cari_diger_controller/sql.php?islem=vadesine_gore_borc_alacak_filtrele", {
                    ilk_vade: ilk_vade,
                    son_vade: son_vade,
                    bakiye_limit: bakiye_limit,
                    cari_grubu: cari_grubu,
                    cari_turu: cari_turu
                }, function (res) {
                    if (res != 2) {
                        var jsonString = JSON.stringify(res);

                        $.ajax({
                            url: "view/cari_vadesine_gore_tahsilat.php",
                            type: "POST",
                            data: {
                                data: jsonString
                            },
                            success: function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            }
                        });
                        $.ajax({
                            url: "view/cari_vadesine_gore_tahsilat.php",
                            type: "POST",
                            data: {
                                data: jsonString
                            },
                            success: function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            }
                        });

                        $("#vade_kriterleri_modal").modal("hide");
                    } else {
                        Swal.fire(
                            "Uyarı",
                            "Belirlediğiniz Kriterlere Uygun Tahsilat Bulunamadı",
                            "warning"
                        )
                    }
                })
            }
        });

    </script>
    <?php
}