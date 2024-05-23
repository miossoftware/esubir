<?php
if (isset($_GET)) {
    $kasa_kodu = $_GET["kasa_kodu"];
    ?>
    <div class="modal fade" id="kasa_tanimla_modal_main" data-bs-backdrop="static" data-bs-keyboard="false"
         role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="width: 35%; max-width: 35%;">
        <div class="modal-content">
            <div class="modal-header text-white p-2">
                <button type="button" class="btn-close btn-close-white" id="modal_kapat" aria-label="Close"></button>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head" style='background-color:#9DB2BF'>
                        <div class="ibox-title" style='color:white; font-weight:bold;'>KASA GÜNCELLE</div>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 row">
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Kasa Kodu</label>
                                </div>
                                <div class="col-8">
                                    <input disabled value="<?= $kasa_kodu ?>" type="text"
                                           class="form-control form-control-sm" id="kasa_kodu">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Kasa Adı</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="kasa_adi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Varsayılan</label>
                                </div>
                                <div class="col-8">
                                    <select class="custom-select custom-select-sm" id="varsayilan_kasa">
                                        <option value="">Seçiniz...</option>
                                        <option value="1">Varsayılan</option>
                                        <option value="0">Varsayılan Değil</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Açıklama</label>
                                </div>
                                <div class="col-8">
                                    <textarea class="form-control form-control-sm" id="aciklama" cols="30"
                                              rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Giren</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" disabled id="giren">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Çıkan</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" disabled id="cikan">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Bakiye</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" disabled id="bakiye">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-sm" id="modal_kapat">Kapat</button>
                    <button class="btn btn-success btn-sm" id="kasa_guncelle">Kaydet</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('input').click(function() {
            $(this).select();
        });
        $('input').click(function() {
            $(this).select();
        });
        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#kasa_tanimla_modal_main").modal("hide");
        })
        $("body").off("click", "#kasa_guncelle").on("click", "#kasa_guncelle", function () {
            var kasa_kodu = $("#kasa_kodu").val();
            var kasa_adi = $("#kasa_adi").val();
            var aciklama = $("#aciklama").val();
            var varsayilan_kasa = $("#varsayilan_kasa").val();
            $.ajax({
                url: "controller/kasa_controller/sql.php?islem=kasa_guncelle_sql",
                type: "POST",
                data: {
                    kasa_kodu: kasa_kodu,
                    kasa_adi: kasa_adi,
                    aciklama: aciklama,
                    varsayilan_kasa: varsayilan_kasa
                },
                success: function (result) {
                    if (result != 2) {
                        Swal.fire(
                            'Başarılı!',
                            'Kasa Başarıyla Güncellendi',
                            'success'
                        );
                        $.get("view/kasa_tanim.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        })
                        $.get("view/kasa_tanim.php", function (getList) {
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
        $(document).ready(function () {
            $("#kasa_tanimla_modal_main").modal("show");
            $.get("controller/kasa_controller/sql.php?islem=kasa_bilgilerini_getir", {kasa_kodu: "<?=$kasa_kodu?>"}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    console.log(item);
                    $("#kasa_adi").val(item.kasa_adi);
                    $("#aciklama").val(item.aciklama);
                    $("#varsayilan_kasa").val(item.varsayilan_kasa);
                    $("#giren").val(item.giren);
                    $("#cikan").val(item.cikan);
                    if (item.bakiye == "") {
                        $("#bakiye").val("0,00 TL");
                    } else {
                        $("#bakiye").val(item.bakiye);
                    }
                }
            })
        });
    </script>
    <?php
}