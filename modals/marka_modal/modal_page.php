<?php

$islem = $_GET["islem"];
if ($islem == "marka_guncelle_modal") {
    ?>
    <div class="modal fade" id="marka_ekle_modal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="width: 30%; max-width: 30%;">
        <div class="modal-content">
            <div class="modal-header text-white p-2">M
                <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                        aria-label="Close"></button>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head" style='background-color:#9DB2BF'>
                        <div class="ibox-title" style='color:white; font-weight:bold;'>´MARKA GÜNCELLE</div>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 row">
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Marka Adı</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="marka_adi">
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
                    <button class="btn btn-success btn-sm" id="marka_kaydet">Güncelle</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#marka_ekle_modal").modal("show");
            $.get("controller/marka_controller/sql.php?islem=marka_bilgileri_getir", {id: "<?=$_GET["id"]?>"}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#aciklama").val(item.aciklama);
                    $("#marka_adi").val(item.marka_adi);
                }
            })
        })
        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#marka_ekle_modal").modal("hide");
        })

        $("body").off("click", "#marka_kaydet").on("click", "#marka_kaydet", function () {
            var marka_adi = $("#marka_adi").val();
            var aciklama = $("#aciklama").val();
            $.ajax({
                url: "controller/marka_controller/sql.php?islem=marka_guncelle_sql",
                type: "POST",
                data: {
                    marka_adi: marka_adi,
                    aciklama: aciklama,
                    id: "<?=$_GET["id"]?>"
                },
                success: function (result) {
                    if (result != 2) {
                        Swal.fire(
                            'Başarılı!',
                            'Marka Tanımlandı',
                            'success'
                        );
                        $.get("view/marka_listesi.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        })
                        $.get("view/marka_listesi.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        })
                    } else {
                        Swal.fire(
                            'Oops...',
                            'Bilinmeyen Bir Hata İle Karşılaşıldı',
                            'error'
                        );
                    }
                }
            })
        })
    </script>
    <?php
}