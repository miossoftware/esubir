<?php
date_default_timezone_set('Europe/Istanbul');
session_start();
$islem = $_GET["islem"];
if ($islem == "bilanco_tanimla") {
    ?>
    <div class="modal fade" id="bilanco_tanimla" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="width: 35%; max-width: 35%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Bilanço Tanımla
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>BİLANÇO TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="col-12 row">
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Bilanço Kodu</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control form-control-sm" id="bilanco_kodu">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Bilanço Adı</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control form-control-sm" id="bilanco_adi">
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
                        <button class="btn btn-success btn-sm" id="bilanco_kaydet">Kaydet</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $("#bilanco_tanimla").modal("show");
            })
            $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
                $("#bilanco_tanimla").modal("hide");
            })
            $("body").off("click", "#bilanco_kaydet").on("click", "#bilanco_kaydet", function () {
                var bilanco_kodu = $("#bilanco_kodu").val();
                var bilanco_adi = $("#bilanco_adi").val();
                var aciklama = $("#aciklama").val();

                $.ajax({
                    url: "controller/bilanco_controller/sql.php?islem=yeni_bilanco_tanimla",
                    type: "POST",
                    data: {
                        bilanco_adi: bilanco_adi,
                        bilanco_kodu: bilanco_kodu,
                        aciklama: aciklama
                    },
                    success: function (result) {
                        if (result != 2) {
                            if (result == 300) {
                                Swal.fire(
                                    'Uyarı!',
                                    'Bu Bilanço Kayıtlı',
                                    'warning'
                                );
                            } else {
                                Swal.fire(
                                    'Başarılı!',
                                    'Bilanço Tanımlandı',
                                    'success'
                                );
                                $.get("view/bilanco.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/bilanco.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                })
                            }
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