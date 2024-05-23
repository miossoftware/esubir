<?php
$islem = $_GET["islem"];
if ($islem == "banka_guncelle_modal") {
    $banka_kodu = $_GET["banka_kodu"];
    ?>
    <div class="modal fade" id="banka_guncelle_modal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="width: 55%; max-width: 55%;">
        <div class="modal-content">
            <div class="modal-header text-white p-2">
                <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                        aria-label="Close"></button>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head" style='background-color:#9DB2BF'>
                        <div class="ibox-title" style='color:white; font-weight:bold;'>BANKA GÜNCELLE</div>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 row">
                            <div class="col-6">
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Banka Kodu</label>
                                    </div>
                                    <div class="col-8">
                                        <input value="<?= $banka_kodu ?>" disabled type="text"
                                               class="form-control form-control-sm" id="banka_kodu">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Şube Kodu</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control form-control-sm" id="sube_kodu">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Hesap Adı</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control form-control-sm" id="hesap_adi">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Hesap No</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control form-control-sm" id="hesap_no">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>IBAN</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control form-control-sm" id="iban_no">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Telefon</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control form-control-sm" id="telefon">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Faks</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control form-control-sm" id="faks">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Adres</label>
                                    </div>
                                    <div class="col-8">
                                        <textarea class="form-control form-control-sm" id="adres" cols="30"
                                                  rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Banka Adı</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control form-control-sm" id="banka_adi">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Şube Adı</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control form-control-sm" id="sube_adi">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Yetkili Adı</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control form-control-sm" id="yetkili_adi">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Yetkili E-Mail</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control form-control-sm" id="yetkili_mail">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Yatan</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" disabled class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Çekilen</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" disabled class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Bakiye</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" disabled class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Açıklama</label>
                                    </div>
                                    <div class="col-8">
                                        <textarea class="form-control form-control-sm" id="aciklama" cols="30"
                                                  rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Döviz Türü</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="custom-select custom-select-sm" id="doviz_tipi">
                                            <option value="">Döviz Türü Belirtiniz...</option>
                                            <option value="TL">TL</option>
                                            <option value="USD">USD</option>
                                            <option value="EURO">EURO</option>
                                            <option value="GBP">GBP</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-sm" id="modal_kapat">Kapat</button>
                    <button class="btn btn-success btn-sm" id="banka_kaydet">Kaydet</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('input').click(function() {
            $(this).select();
        });
        $(document).ready(function () {
            $("#banka_guncelle_modal").modal("show");
            $.get("controller/banka_controller/sql.php?islem=secili_banka_bilgileri", {banka_kodu: "<?=$banka_kodu?>"}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#sube_kodu").val(item.sube_kodu);
                    $("#hesap_adi").val(item.hesap_adi);
                    $("#hesap_no").val(item.hesap_no);
                    $("#iban_no").val(item.iban_no);
                    $("#telefon").val(item.telefon);
                    $("#faks").val(item.faks);
                    $("#adres").val(item.adres);
                    $("#banka_adi").val(item.banka_adi);
                    $("#sube_adi").val(item.sube_adi);
                    $("#yetkili_adi").val(item.yetkili_adi);
                    $("#yetkili_mail").val(item.yetkili_mail);
                    $("#aciklama").val(item.aciklama);
                    $("#doviz_tipi").val(item.doviz_tipi);
                }
            })
        });

        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#banka_guncelle_modal").modal("hide");
        })

        $("body").off("click", "#banka_kaydet").on("click", "#banka_kaydet", function () {
            var banka_kodu = $("#banka_kodu").val();
            var sube_kodu = $("#sube_kodu").val();
            var hesap_adi = $("#hesap_adi").val();
            var hesap_no = $("#hesap_no").val();
            var iban_no = $("#iban_no").val();
            var telefon = $("#telefon").val();
            var faks = $("#faks").val();
            var adres = $("#adres").val();
            var doviz_tipi = $("#doviz_tipi").val();
            var banka_adi = $("#banka_adi").val();
            var sube_adi = $("#sube_adi").val();
            var yetkili_adi = $("#yetkili_adi").val();
            var yetkili_mail = $("#yetkili_mail").val();
            var aciklama = $("#aciklama").val();
            $.ajax({
                url: "controller/banka_controller/sql.php?islem=banka_guncelle",
                type: "POST",
                data: {
                    banka_kodu: banka_kodu,
                    sube_kodu: sube_kodu,
                    hesap_adi: hesap_adi,
                    hesap_no: hesap_no,
                    iban_no: iban_no,
                    doviz_tipi: doviz_tipi,
                    telefon: telefon,
                    faks: faks,
                    adres: adres,
                    banka_adi: banka_adi,
                    sube_adi: sube_adi,
                    yetkili_adi: yetkili_adi,
                    yetkili_mail: yetkili_mail,
                    aciklama: aciklama
                },
                success: function (result) {
                    if (result != 2) {

                        $("#banka_guncelle_modal").modal("hide");
                        Swal.fire(
                            'Başarılı!',
                            'Banka Güncellendi',
                            'success'
                        );
                        $.get("view/banka_tanim.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        })
                        $.get("view/banka_tanim.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        })
                    }
                }
            });
        })
    </script>
    <?php
}