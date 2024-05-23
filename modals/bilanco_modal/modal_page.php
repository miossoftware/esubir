<?php
$islem = $_GET["islem"];
if ($islem == "bilanco_guncelle") {
    ?>
    <div class="modal fade" id="bilanco_guncelle" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="width: 35%; max-width: 35%;">
        <div class="modal-content">
            <div class="modal-header text-white p-2">
                <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                        aria-label="Close"></button>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head" style='background-color:#9DB2BF'>
                        <div class="ibox-title" style='color:white; font-weight:bold;'>BİLANÇO GÜNCELLE</div>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 row">
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Bilanço Kodu</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" disabled id="bilanco_kodu">
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
                    <button class="btn btn-success btn-sm" id="bilanco_guncelle_button">Kaydet</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#bilanco_guncelle").modal("show");
            $.get("controller/bilanco_controller/sql.php?islem=bilanco_bilgileri_getir", {id: "<?=$_GET["id"]?>"}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#bilanco_kodu").val(item.bilanco_kodu);
                    $("#bilanco_adi").val(item.bilanco_adi);
                    $("#aciklama").val(item.aciklama);
                }
            })
        })
        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#bilanco_guncelle").modal("hide");
        })
        $("body").off("click", "#bilanco_guncelle_button").on("click", "#bilanco_guncelle_button", function () {
            var bilanco_kodu = $("#bilanco_kodu").val();
            var bilanco_adi = $("#bilanco_adi").val();
            var aciklama = $("#aciklama").val();

            $.ajax({
                url: "controller/bilanco_controller/sql.php?islem=bilanco_guncelle",
                type: "POST",
                data: {
                    bilanco_adi: bilanco_adi,
                    bilanco_kodu: bilanco_kodu,
                    aciklama: aciklama,
                    id: "<?=$_GET["id"]?>"
                },
                success: function (result) {
                    if (result != 2) {
                        Swal.fire(
                            'Başarılı!',
                            'Bilanço Güncellendi',
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