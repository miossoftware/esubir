<?php
date_default_timezone_set('Europe/Istanbul');
session_start();
$islem = $_GET["islem"];
if ($islem == "yeni_depo_ekle") {
    ?>
    <div class="modal fade" id="depo_ekle_modal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog" style="width: 35%; max-width: 35%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>YENİ DEPO EKLE</div>
                        </div>
                        <div class="modal-body">
                            <div class="col-12 row">
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Depo Adı</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control form-control-sm" id="depo_adi">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Adresi</label>
                                    </div>
                                    <div class="col-8">
                                        <textarea class="form-control form-control-sm" id="adres" cols="30"
                                                  rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Açıklama</label>
                                    </div>
                                    <div class="col-8">
                                        <textarea class="form-control form-control-sm" id="aciklama" cols="30"
                                                  rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Depo Türü</label>
                                    </div>
                                    <div class="col-8">
                                        <select class="custom-select custom-select-sm" id="varsayilan_depo">
                                            <option value="">Seçiniz...</option>
                                            <option value="1">Varsayılan</option>
                                            <option value="0">Varsayılan Değil</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger btn-sm" id="modal_kapat">Kapat</button>
                        <button class="btn btn-success btn-sm" id="depo_kaydet">Kaydet</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $("#depo_ekle_modal").modal("show");
            })

            $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
                $("#depo_ekle_modal").modal("hide")
            })
            $("body").off("click", "#depo_kaydet").on("click", "#depo_kaydet", function () {
                var depo_adi = $("#depo_adi").val();
                var adres = $("#adres").val();
                var aciklama = $("#aciklama").val();
                var varsayilan_depo = $("#varsayilan_depo").val();
                $.ajax({
                    url: "controller/depo_controller/sql.php?islem=yeni_depo_tanimla",
                    type: "POST",
                    data: {
                        depo_adi: depo_adi,
                        adres: adres,
                        aciklama: aciklama,
                        varsayilan_depo: varsayilan_depo
                    },
                    success: function (result) {
                        if (result != 2) {
                            Swal.fire(
                                'Başarılı!',
                                'Depo Başarıyla Tanımlandı',
                                'success'
                            );
                            $.get("view/depolar.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            })
                            $.get("view/depolar.php", function (getList) {
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