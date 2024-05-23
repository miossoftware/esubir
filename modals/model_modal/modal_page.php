<?php

$islem = $_GET["islem"];
if ($islem == "model_guncelle_modal") {
    ?>
    <div class="modal fade" id="model_ekle_modal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="width: 30%; max-width: 30%;">
        <div class="modal-content">
            <div class="modal-header text-white p-2">
                <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                        aria-label="Close"></button>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head" style='background-color:#9DB2BF'>
                        <div class="ibox-title" style='color:white; font-weight:bold;'>MODEL GÜNCELLE</div>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 row">
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Marka Adı</label>
                                </div>
                                <div class="col-8">
                                    <select class="custom-select custom-select-sm" id="marka_id">
                                        <option value="">Seçiniz...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Model Adı</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="model_adi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Açıklama</label>
                                </div>
                                <div class="col-8">
                                <textarea class="form-control form-control-sm" id="aciklama" cols="30"
                                          rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-sm" id="modal_kapat">Kapat</button>
                    <button class="btn btn-success btn-sm" id="model_kaydet">Güncelle</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $.get("controller/model_controller/sql.php?islem=markalari_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        var markaAdi = item.marka_adi;
                        $("#marka_id").append("" +
                            "<option value='" + item.id + "'>" + markaAdi.toUpperCase() + "</option>" +
                            "");
                    })
                }
            })
            $("#model_ekle_modal").modal("show");
            $.get("controller/model_controller/sql.php?islem=model_bilgileri_getir", {id: "<?=$_GET["id"]?>"}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#marka_id").val(item.marka_id);
                    $("#model_adi").val(item.model_adi);
                    $("#aciklama").val(item.aciklama);
                }
            })
        })
        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#model_ekle_modal").modal("hide");
        })
        $("body").off("click", "#model_kaydet").on("click", "#model_kaydet", function () {
            var marka_id = $("#marka_id").val();
            var model_adi = $("#model_adi").val();
            var aciklama = $("#aciklama").val();
            $.ajax({
                url: "controller/model_controller/sql.php?islem=model_guncelle_sql",
                type: "POST",
                data: {
                    marka_id: marka_id,
                    model_adi: model_adi,
                    aciklama: aciklama,
                    id: "<?=$_GET["id"]?>"
                },
                success: function (result) {
                    if (result != 2) {
                        Swal.fire(
                            'Başarılı!',
                            'Model Tanımlandı',
                            'success'
                        );
                        $.get("view/model_listesi.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        })
                        $.get("view/model_listesi.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        })
                    } else {
                        Swal.fire(
                            'Oops...',
                            'Bilinmeyen Bir Hata Oluştu',
                            'error'
                        );
                    }
                }
            })
        })
    </script>
    <?php
}