<?php

$islem = $_GET["islem"];
if ($islem == "ana_grup_guncelle_modal") {
    ?>
    <div class="modal fade" id="anagrup_guncelle_modal" data-bs-backdrop="static" data-bs-keyboard="false"
         role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="width: 35%; max-width: 35%;">
        <div class="modal-content">
            <div class="modal-header text-white p-2">
                <button type="button" class="btn-close btn-close-white" id="modal_kapat" aria-label="Close"></button>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head" style='background-color:#9DB2BF'>
                        <div class="ibox-title" style='color:white; font-weight:bold;'>ANA GRUP GUNCELLE</div>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 row">
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Ana Grup Adı</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="ana_grup_adi">
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
                    <button class="btn btn-danger btn-sm" data-bs-dismiss="modal" id="modal_kapat">Kapat</button>
                    <button class="btn btn-success btn-sm" id="anagrup_ekle_button">Ana Grup Güncelle</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#anagrup_guncelle_modal").modal("show");
            $.get("controller/anagrup_controller/sql.php?islem=anagrup_bilgileri_getir_sql", {id: "<?=$_GET["id"]?>"}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#ana_grup_adi").val(item.ana_grup_adi);
                    $("#aciklama").val(item.aciklama);
                }
            })
        })

        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#anagrup_guncelle_modal").modal("hide");
        })

        $("body").off("click", "#anagrup_ekle_button").on("click", "#anagrup_ekle_button", function () {
            var ana_grup_name = $("#ana_grup_adi").val();
            var aciklama = $("#aciklama").val();
            $.ajax({
                url: "controller/anagrup_controller/sql.php?islem=ana_grup_guncelle_sql",
                type: "POST",
                data: {
                    ana_grup_adi: ana_grup_name,
                    aciklama: aciklama,
                    id: "<?=$_GET["id"]?>"
                },
                success: function (result) {
                    if (result != 2) {
                        Swal.fire(
                            'Başarılı!',
                            'Ana Grup Tanımlandı',
                            'success'
                        );
                        $.get("view/stok_ana_grup_tanim.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        })
                        $.get("view/stok_ana_grup_tanim.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        })
                    } else {
                        Swal.fire(
                            'Oops...',
                            'Bilinmeyen Bir Hata İle Karşılaşılıdı',
                            'error'
                        );
                    }
                }
            });
        })
    </script>
    <?php
}