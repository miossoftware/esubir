<?php
$islem = $_GET["islem"];

if ($islem == "yeni_cek_girisi_tanimla_main") {
    ?>
    <div class="modal fade" id="cek_tanim_main_modal" data-backdrop="static"
         data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 55%; max-width: 55%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="vazgec_cek_stok"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ÇEK STOK GİRİŞİ
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="cek_tanim_icin_banka_getir"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Banka Kodu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="banka_kodu_cek_stok">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="banka_liste_getir_cek_tanim"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Banka Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" disabled class="form-control form-control-sm"
                                                   id="banka_adi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Şube Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" disabled class="form-control form-control-sm"
                                                   id="sube_adi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Yetkili Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" disabled class="form-control form-control-sm"
                                                   id="yetkili_adi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Geldiği Tarih</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" class="form-control form-control-sm"
                                                   value="<?= date("Y-m-d") ?>" id="geldigi_tarih">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>İşlem Biçimi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="islem_bicimi">
                                                <option value="">İşlem Biçimi...</option>
                                                <option value="Otomatik Artsın">Çek Numarası Otomatik Artsın</option>
                                                <option value="Manuel Giriş">Çek Numarasını Manuel Olarak Gireceğim
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Yaprak Sayısı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="number" class="form-control form-control-sm"
                                                   id="yaprak_sayisi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Başlangıç No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="cek_baslangic_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Bitiş No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="cek_bitis_no">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger btn-sm" id="vazgec_cek_stok"><i class="fa fa-close"></i>
                                    Vazgeç
                                </button>
                                <button class="btn btn-success btn-sm" id="cek_stok_giris_kaydet"><i
                                            class="fa fa-check"></i> Kaydet
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("body").off("click", "#banka_liste_getir_cek_tanim").on("click", "#banka_liste_getir_cek_tanim", function () {
            $.get("modals/cek_senet_modal/another_modal.php?islem=banka_listesi_getir_modal", function (getModal) {
                $(".cek_tanim_icin_banka_getir").html("");
                $(".cek_tanim_icin_banka_getir").html(getModal);
            })
        });

        $("body").off("click", "#vazgec_cek_stok").on("click", "#vazgec_cek_stok", function () {
            $("#cek_tanim_main_modal").modal("hide");
        });

        $(document).ready(function () {
            $("#cek_tanim_main_modal").modal("show");
        })

        $("#banka_kodu_cek_stok").keyup(function () {
            let val = $(this).val();
            $.get("controller/cek_senet_controller/sql.php?islem=banka_kodu_bilgileri_getir_sql", {banka_kodu: val}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#banka_kodu_cek_stok").val(item.banka_kodu);
                    $("#banka_kodu_cek_stok").attr("data-id", item.id);
                    $("#banka_adi").val(item.banka_adi);
                    $("#sube_adi").val(item.sube_adi);
                    $("#yetkili_adi").val(item.yetkili_adi);
                } else {
                    $("#banka_kodu_cek_stok").attr("data-id", "");
                    $("#banka_adi").val("");
                    $("#sube_adi").val("");
                    $("#yetkili_adi").val("");
                }
            })
        })

        $("#yaprak_sayisi").focusout(function () {
            var inputValue = $("#cek_baslangic_no").val();
            var numbersOnly = inputValue.match(/[0-9]+/g);
            let bitis_sayisi = 0;
            let yaprak_sayisi = $(this).val();
            if (numbersOnly) {
                var numberString = numbersOnly.join("");
                bitis_sayisi = parseInt(numberString) + parseInt(yaprak_sayisi);
                bitis_sayisi = bitis_sayisi - 1;
            }
            if (isNaN(bitis_sayisi)) {
                bitis_sayisi = 0;
            }

            var lettersOnly = inputValue.match(/[a-zA-Z]+/g);
            let metni = "";
            if (lettersOnly) {
                var letterString = lettersOnly.join("");
                letterString = letterString.toUpperCase();
                metni = letterString;
            }
            let bastirilacak = metni + bitis_sayisi;
            $("#cek_bitis_no").val(bastirilacak);
        });

        $("#cek_baslangic_no").focusout(function () {
            var inputValue = $(this).val();
            var numbersOnly = inputValue.match(/[0-9]+/g);
            let bitis_sayisi = 0;
            let yaprak_sayisi = $("#yaprak_sayisi").val();
            if (numbersOnly) {
                var numberString = numbersOnly.join("");
                bitis_sayisi = parseInt(numberString) + parseInt(yaprak_sayisi);
                bitis_sayisi = bitis_sayisi - 1;
            }
            if (isNaN(bitis_sayisi)) {
                bitis_sayisi = 0;
            }

            var lettersOnly = inputValue.match(/[a-zA-Z]+/g);
            let metni = "";
            if (lettersOnly) {
                var letterString = lettersOnly.join("");
                letterString = letterString.toUpperCase();
                metni = letterString;
            }
            let bastirilacak = metni + bitis_sayisi;
            $("#cek_bitis_no").val(bastirilacak);
        });

        $("body").off("click", "#cek_stok_giris_kaydet").on("click", "#cek_stok_giris_kaydet", function () {
            let cek_baslangic_no = $("#cek_baslangic_no").val();
            let yaprak_sayisi = $("#yaprak_sayisi").val();
            let cek_bitis_no = $("#cek_bitis_no").val();
            let islem_bicimi = $("#islem_bicimi").val();
            let geldigi_tarih = $("#geldigi_tarih").val();
            let banka_id = $("#banka_kodu_cek_stok").attr("data-id");
            if (banka_id == "" || banka_id == undefined) {
                Swal.fire(
                    'Uyarı!',
                    'Lütfen Banka Giriniz...',
                    'warning'
                );
            } else {
                $.ajax({
                    url: "controller/cek_senet_controller/sql.php?islem=cek_stok_tanimla_sql",
                    type: "POST",
                    data: {
                        cek_baslangic_no: cek_baslangic_no,
                        banka_id: banka_id,
                        yaprak_sayisi: yaprak_sayisi,
                        cek_bitis_no: cek_bitis_no,
                        geldigi_tarih: geldigi_tarih,
                        islem_bicimi: islem_bicimi
                    },
                    success: function (result) {
                        if (result == 1) {
                            $("#cek_tanim_main_modal").modal("hide");
                            $.get("view/cek_stok_giris.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                            $.get("view/cek_stok_giris.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }
        })

    </script>
    <?php
}