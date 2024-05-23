<?php
$islem = $_GET["islem"];
if ($islem == "yeni_banka_tanimla") {
    ?>
    <div class="modal fade" id="banka_tanimla_modal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="width: 55%; max-width: 55%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>BANKA TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>Banka Kodu</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" class="form-control form-control-sm" id="banka_kodu">
                                        </div>
                                    </div>
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
                                            <label>Adres</label>
                                        </div>
                                        <div class="col-8">
                                            <textarea class="form-control form-control-sm" id="adres" style="resize: none" cols="30"
                                                      rows="4"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
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
                                            <textarea class="form-control form-control-sm" style="resize: none" id="aciklama" cols="30"
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
                                                <option selected value="TL">TL</option>
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
                $("#banka_tanimla_modal").modal("show");
            });

            $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
                $("#banka_tanimla_modal").modal("hide");
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
                var banka_adi = $("#banka_adi").val();
                var sube_adi = $("#sube_adi").val();
                var yetkili_adi = $("#yetkili_adi").val();
                var doviz_tipi = $("#doviz_tipi").val();
                var yekili_mail = $("#yekili_mail").val();
                var aciklama = $("#aciklama").val();
                $.ajax({
                    url: "controller/banka_controller/sql.php?islem=yeni_banka_tanimla",
                    type: "POST",
                    data: {
                        banka_kodu: banka_kodu,
                        sube_kodu: sube_kodu,
                        doviz_tipi: doviz_tipi,
                        hesap_adi: hesap_adi,
                        hesap_no: hesap_no,
                        iban_no: iban_no,
                        telefon: telefon,
                        faks: faks,
                        adres: adres,
                        banka_adi: banka_adi,
                        sube_adi: sube_adi,
                        yetkili_adi: yetkili_adi,
                        yekili_mail: yekili_mail,
                        aciklama: aciklama
                    },
                    success: function (result) {
                        if (result != 2) {
                            if (result == 300) {
                                Swal.fire(
                                    'Uyarı!',
                                    'Bu Banka Kodu Zaten Kayıtlı',
                                    'warning'
                                );
                            } else {
                                Swal.fire(
                                    'Başarılı!',
                                    'Banka Tanımlandı',
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
                    }
                });
            })


        </script>
    <?php
}