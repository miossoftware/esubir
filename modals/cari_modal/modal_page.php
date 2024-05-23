<?php
date_default_timezone_set('Europe/Istanbul');
session_start();
$islem = $_GET["islem"];
if ($islem == "cari_genel_bilgiler_page") {
    ?>
    <div class="col-4">
        <div class="form-group row">
            <div class="col-4">
                <label>Cari Türü</label>
            </div>
            <div class="col-8">
                <select class="custom-select custom-select-sm" id="cari_turu">
                    <option value="">Seçiniz...</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>Cari Kodu</label>
            </div>
            <div class="col-8">
                <input type="text" class="form-control form-control-sm" id="cari_kodu">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>Cari Ünvanı</label>
            </div>
            <div class="col-8">
                <input type="text" class="form-control form-control-sm" id="cari_unvani">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>Vergi Dairesi</label>
            </div>
            <div class="col-8">
                <input type="text" class="form-control form-control-sm" id="vergi_dairesi">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>Vergi No</label>
            </div>
            <div class="col-8">
                <input type="text" class="form-control form-control-sm" id="vergi_no">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>Web Sitesi</label>
            </div>
            <div class="col-8">
                <input type="text" class="form-control form-control-sm" id="internet_sitesi">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>Açıklama</label>
            </div>
            <div class="col-8">
                <input type="text" class="form-control form-control-sm" id="aciklama">
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group row">
            <div class="col-4">
                <label>Bilanço Kodu</label>
            </div>
            <div class="col-8">
                <select class="custom-select custom-select-sm" id="bilanco_id">
                    <option value="">Seçiniz...</option>
                    <option value="1">Test</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>Cari Grubu</label>
            </div>
            <div class="col-8">
                <select class="custom-select custom-select-sm" id="cari_grubu">
                    <option value="">Seçiniz...</option>
                    <option value="1">Test</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-4">
                <label>Vade Günü</label>
            </div>
            <div class="col-8">
                <input type="number" class="form-control form-control-sm" id="vade_gunu">
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
                <label>Cep Telefonu</label>
            </div>
            <div class="col-8">
                <input type="text" class="form-control form-control-sm" id="cep_telefonu">
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
                <label>E-Posta</label>
            </div>
            <div class="col-8">
                <input type="text" class="form-control form-control-sm" id="e_mail">
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <h5>1. Yetkili</h5>
                <div class="form-group row">
                    <div class="col-4">
                        <label>Adı Soyadı</label>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control form-control-sm" id="yetkili_adi1">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-4">
                        <label>Cep</label>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control form-control-sm" id="yetkili_tel1">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-4">
                        <label>E-Posta</label>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control form-control-sm" id="yetkili_mail1">
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5>2. Yetkili</h5>
                <div class="form-group row">
                    <div class="col-4">
                        <label>Adı Soyadı</label>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control form-control-sm" id="yetkili_ad2">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-4">
                        <label>Cep</label>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control form-control-sm" id="yetkili_tel2">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-4">
                        <label>E-Posta</label>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control form-control-sm" id="yetkili_mail">
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger btn-sm" id="modal_kapat2">Kapat</button>
        <button class="btn btn-success btn-sm" id="cari_ekle">Cari Ekle</button>
    </div>
    <script>
        $('input').click(function () {
            $(this).select();
        });
        $("body").off("click", "#cari_ekle").on("click", "#cari_ekle", function () {
            var cari_turu = $("#cari_turu").val();
            var cari_kodu = $("#cari_kodu").val();
            var cari_unvani = $("#cari_unvani").val();
            // var cari_adi = $("#cari_adi").val();
            var vergi_dairesi = $("#vergi_dairesi").val();
            var vergi_no = $("#vergi_no").val();
            var internet_sitesi = $("#internet_sitesi").val();
            var bilanco_id = $("#bilanco_id").val();
            var cari_grubu = $("#cari_grubu").val();
            var vade_gunu = $("#vade_gunu").val();
            var telefon = $("#telefon").val();
            var cep_telefonu = $("#cep_telefonu").val();
            var faks = $("#faks").val();
            var e_mail = $("#e_mail").val();
            var yetkili_adi1 = $("#yetkili_adi1").val();
            var yetkili_tel1 = $("#yetkili_tel1").val();
            var yetkili_mail1 = $("#yetkili_mail1").val();
            var yetkili_ad2 = $("#yetkili_ad2").val();
            var yetkili_tel2 = $("#yetkili_tel2").val();
            var yetkili_mail = $("#yetkili_mail").val();
            var aciklama = $("#aciklama").val();
            $.ajax({
                url: "controller/cari_controller/sql.php?islem=cari_ekle",
                type: "POST",
                data: {
                    cari_turu: cari_turu,
                    cari_kodu: cari_kodu,
                    cari_adi: cari_unvani,
                    // cari_adi: cari_adi,
                    vergi_dairesi: vergi_dairesi,
                    vergi_no: vergi_no,
                    internet_sitesi: internet_sitesi,
                    bilanco_id: bilanco_id,
                    cari_grubu: cari_grubu,
                    vade_gunu: vade_gunu,
                    telefon: telefon,
                    cep_telefonu: cep_telefonu,
                    faks: faks,
                    e_mail: e_mail,
                    yetkili_adi1: yetkili_adi1,
                    yetkili_tel1: yetkili_tel1,
                    yetkili_mail1: yetkili_mail1,
                    yetkili_ad2: yetkili_ad2,
                    yetkili_tel2: yetkili_tel2,
                    yetkili_mail: yetkili_mail,
                    aciklama: aciklama
                },
                success: function (result) {
                    if (result != 2) {
                        Swal.fire(
                            'Başarılı!',
                            'Cari Kayıt Edildi',
                            'success'
                        );
                        $.get("view/add_cari_page.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        })
                        $.get("view/add_cari_page.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        })
                    } else {
                        Swal.fire(
                            'Oops...',
                            'Bilinmeyen Bir Hata Oluştu',
                            'error'
                        )
                    }
                }
            })
        })

        $("body").off("click", "#modal_kapat2").on("click", "#modal_kapat2", function () {
            $("#cari_ekleme_modal").modal("hide");
        })
    </script>
    <?php
}
if ($islem == "adres_bilgileri_modal") {
    $cari_kodu = "";
    if (isset($_GET["cari_kodu"])) {
        $cari_kodu = $_GET["cari_kodu"];
    }
    ?>
    <div class="col-12 row">
        <div class="col-6">
            <div class="form-group row">
                <div class="col-4">
                    <label>İl</label>
                </div>
                <div class="col-8">
                    <select class="custom-select custom-select-sm" id="il">
                        <option value="">Seçiniz...</option>
                    </select>
                </div>
            </div>
            <!--            <div class="form-group row">-->
            <!--                <div class="col-4">-->
            <!--                    <label>İlçe</label>-->
            <!--                </div>-->
            <!--                <div class="col-8">-->
            <!--                    <select class="custom-select custom-select-sm" id="ilce">-->
            <!--                        <option value="">Seçiniz...</option>-->
            <!--                    </select>-->
            <!--                </div>-->
            <!--            </div>-->
            <div class="form-group row">
                <div class="col-4">
                    <label>Adres</label>
                </div>
                <div class="col-8">
                    <textarea class="form-control form-control-sm" id="adres" cols="30" rows="7"></textarea>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group row">
                <div class="col-4">
                    <label>Özel Kod 1</label>
                </div>
                <div class="col-8">
                    <input type="text" class="form-control form-control-sm" id="ozel_kod1">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-4">
                    <label>Özel Kod 2</label>
                </div>
                <div class="col-8">
                    <input type="text" class="form-control form-control-sm" id="ozel_kod2">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-4">
                    <label>Özel Kod 3</label>
                </div>
                <div class="col-8">
                    <input type="text" class="form-control form-control-sm" id="ozel_kod3">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-danger btn-sm modal_kapat5" id="modal_kapat5">Kapat</button>
            <button class="btn btn-success btn-sm" id="adres_ve_detay_bilgi_kaydet">Kaydet</button>
        </div>
    </div>
    <script>
        $("body").off("click", ".modal_kapat5").on("click", ".modal_kapat5", function () {
            $("#cari_ekleme_modal").modal("hide");
        })

        $(document).ready(function () {
            $.get("controller/cari_controller/sql.php?islem=adres_bilgileri_getir", {cari_kodu: "<?=$cari_kodu?>"}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $.get("controller/cari_controller/sql.php?islem=ile_ait_ilceleri_getir", {cari_kodu: "<?=$cari_kodu?>"}, function (result) {
                        if (result != 2) {
                            var json = JSON.parse(result);
                            json.forEach(function (item) {
                                $("#ilce").append("" +
                                    "<option value='" + item.id + "'>" + item.ilce_adi + "</option>" +
                                    "");
                            })
                        }
                    })
                    setTimeout(function () {
                        $("#il").val(item.il);
                        $("#ilce").val(item.ilce);
                        $("#ozel_kod1").val(item.ozel_kod1);
                        $("#ozel_kod2").val(item.ozel_kod2);
                        $("#ozel_kod3").val(item.ozel_kod3);
                        $("#adres").val(item.adres);
                    }, 150);
                }
            })
            $.get("controller/cari_controller/sql.php?islem=illeri_getir", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#il").append("" +
                            "<option value='" + item.id + "'>" + item.il_adi + "</option>" +
                            "");
                    })
                }
            })
        })

        $("body").off("change", "#il").on("change", "#il", function () {
            var il_id = $(this).val();
            $.get("controller/cari_controller/sql.php?islem=ilceleri_getir", {il_id: il_id}, function (result) {
                if (result != 2) {
                    $("#ilce").html("");
                    $("#ilce").append("" +
                        "<option>Seçiniz...</option>" +
                        "");
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#ilce").append("" +
                            "<option value='" + item.id + "'>" + item.ilce_adi + "</option>" +
                            "");
                    })
                }
            })
        });

        $("body").off("click", "#adres_ve_detay_bilgi_kaydet").on("click", "#adres_ve_detay_bilgi_kaydet", function () {
            var il = $("#il").val();
            var ilce = $("#ilce").val();
            var ozel_kod1 = $("#ozel_kod1").val();
            var ozel_kod2 = $("#ozel_kod2").val();
            var ozel_kod3 = $("#ozel_kod3").val();
            var adres = $("#adres").val();
            $.ajax({
                url: "controller/cari_controller/sql.php?islem=cari_adres_bilgi_guncelle",
                type: "POST",
                data: {
                    il: il,
                    ilce: ilce,
                    ozel_kod1: ozel_kod1,
                    ozel_kod2: ozel_kod2,
                    ozel_kod3: ozel_kod3,
                    cari_id: "<?=$cari_kodu?>",
                    adres: adres
                },
                success: function (result) {
                    if (result != 2) {
                        if (result == 400) {
                            Swal.fire(
                                'Uyarı',
                                'Cari Kodu Bulunamadı',
                                'warning'
                            );
                        } else {
                            Swal.fire(
                                'Başarılı!',
                                'Adres Güncellendi',
                                'success'
                            );
                        }
                    } else {
                        Swal.fire(
                            'Oops...',
                            'Bilinmeyen Bir Hata Oluştu',
                            'error'
                        );
                    }
                }
            });
        });
    </script>
    <?php
}
if ($islem == "cari_banka_bilgileri_modal") {
    $cari_kodu = "";
    if (isset($_GET["cari_kodu"])) {
        $cari_kodu = $_GET["cari_kodu"];
    }
    ?>
    <div class="col-12 row">
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
                    <label>Şube Kodu</label>
                </div>
                <div class="col-8">
                    <input type="text" class="form-control form-control-sm" id="sube_kodu">
                </div>
            </div>
        </div>
        <div class="col-6">
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
                    <label>Açıklama</label>
                </div>
                <div class="col-8">
                    <input type="text" class="form-control form-control-sm" id="aciklama">
                </div>
            </div>
        </div>
        <div class="car_banka_buttons mt-2">
            <button class="btn btn-success btn-sm" id="cariye_banka_ekle"><i class="fa fa-plus-square"
                                                                             aria-hidden="true"></i> Banka
                Ekle
            </button>
            <button class="btn btn-danger btn-sm" id="cariye_bagli_banka_sil"><i class="fa fa-trash"
                                                                                 aria-hidden="true"></i> Banka
                Sil
            </button>
        </div>
        <div class="col-12 row mt-2">
            <table class="table table-sm table-bordered w-100 display nowrap" id="cari_banka" style="font-size: 13px">
                <thead>
                <tr>
                    <th>Banka Adı</th>
                    <th>Şube Adı</th>
                    <th>Şube Kodu</th>
                    <th>Hesap Numarası</th>
                    <th>IBAN Numarası</th>
                    <th>Açıklama</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <script>
        var table = "";

        $("body").off("click", "#cariye_bagli_banka_sil").on("click", "#cariye_bagli_banka_sil", function () {
            var id = $(".select_bank").attr("data-id");
            $.ajax({
                url: "controller/cari_controller/sql.php?islem=cariye_ait_banka_sil",
                type: "POST",
                data: {
                    id: id
                },
                success: function (result) {
                    if (result != 500) {
                        if (result == 2) {
                            table.clear().draw(false);
                            Swal.fire(
                                'Başarılı!',
                                'Banka Silindi',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Başarılı!',
                                'Banka Silindi',
                                'success'
                            );
                            var json = JSON.parse(result);
                            table.clear().draw(false);
                            json.forEach(function (item) {
                                var banka_table = table.row.add([item.banka_adi, item.sube_adi, item.sube_kodu, item.hesap_no, item.iban_no, item.aciklama]).draw(false).node();
                                $(banka_table).attr("data-id", item.id);
                            })
                        }
                    } else {
                        Swal.fire(
                            'Oops...',
                            'Bilinmeyen Bir Hata İle Karşılaşıldı',
                            'error'
                        );
                    }
                }
            });
        })

        $("body").off("click", ".banka_selected").on("click", ".banka_selected", function () {
            $('.banka_selected').css("background-color", "rgb(255, 255, 255)");
            $(this).css("background-color", "#60b3abad");
            $('.banka_selected').removeClass('select_bank');
            $(this).addClass("select_bank");
            $(".select").css("background-color", "#B9EDDD");
        });

        $(document).ready(function () {
            table = $('#cari_banka').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row) {
                    $(row).addClass("banka_selected");
                }
            })
            $.get("controller/cari_controller/sql.php?islem=carinin_bankalarini_getir", {cari_kodu: "<?=$cari_kodu?>"}, function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        var banka_table = table.row.add([item.banka_adi, item.sube_adi, item.sube_kodu, item.hesap_no, item.iban_no, item.aciklama]).draw(false).node();
                        $(banka_table).attr("data-id", item.id);
                    })
                }
            });
        });

        $("body").off("click", "#cariye_banka_ekle").on("click", "#cariye_banka_ekle", function () {
            var banka_adi = $("#banka_adi").val();
            var sube_adi = $("#sube_adi").val();
            var sube_kodu = $("#sube_kodu").val();
            var hesap_no = $("#hesap_no").val();
            var iban_no = $("#iban_no").val();
            var aciklama = $("#aciklama").val();
            if (iban_no == "") {
                Swal.fire({
                    title: "İban Numarası Girilmedi",
                    text: "Kaydınız İban Numarası Olmadan Yapılacaktır",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Kaydet"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "controller/cari_controller/sql.php?islem=cariye_banka_ekle",
                            type: "POST",
                            data: {
                                banka_adi: banka_adi,
                                sube_adi: sube_adi,
                                sube_kodu: sube_kodu,
                                hesap_no: hesap_no,
                                iban_no: iban_no,
                                aciklama: aciklama,
                                cari_kodu: "<?=$cari_kodu?>"
                            },
                            success: function (result) {
                                if (result == 1) {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Cari Bankaya Tanımlandı',
                                        'success'
                                    );
                                    $.get("controller/cari_controller/sql.php?islem=carinin_bankalarini_getir", {cari_kodu: "<?=$cari_kodu?>"}, function (result) {
                                        if (result != 2) {
                                            var json = JSON.parse(result);
                                            table.clear();
                                            json.forEach(function (item) {
                                                var banka_table = table.row.add([item.banka_adi, item.sube_adi, item.sube_kodu, item.hesap_no, item.iban_no, item.aciklama]).draw(false).node();
                                                $(banka_table).attr("data-id", item.id);
                                            })
                                        }
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
                    }
                });
            } else {
                $.ajax({
                    url: "controller/cari_controller/sql.php?islem=cariye_banka_ekle",
                    type: "POST",
                    data: {
                        banka_adi: banka_adi,
                        sube_adi: sube_adi,
                        sube_kodu: sube_kodu,
                        hesap_no: hesap_no,
                        iban_no: iban_no,
                        aciklama: aciklama,
                        cari_kodu: "<?=$cari_kodu?>"
                    },
                    success: function (result) {
                        if (result == 1) {
                            Swal.fire(
                                'Başarılı!',
                                'Cari Bankaya Tanımlandı',
                                'success'
                            );
                            $.get("controller/cari_controller/sql.php?islem=carinin_bankalarini_getir", {cari_kodu: "<?=$cari_kodu?>"}, function (result) {
                                if (result != 2) {
                                    var json = JSON.parse(result);
                                    table.clear();
                                    json.forEach(function (item) {
                                        var banka_table = table.row.add([item.banka_adi, item.sube_adi, item.sube_kodu, item.hesap_no, item.iban_no, item.aciklama]).draw(false).node();
                                        $(banka_table).attr("data-id", item.id);
                                    })
                                }
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
            }
        });

    </script>
    <?php
}
if ($islem == "cari_sube_bilgileri_modal") {
    $cari_kodu = "";
    if (isset($_GET["cari_kodu"])) {
        $cari_kodu = $_GET["cari_kodu"];
    }
    ?>
    <div class="col-12 row">
        <div class="col-6">
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
                    <label>İl</label>
                </div>
                <div class="col-8">
                    <select class="custom-select custom-select-sm" id="il_sube">
                        <option value="">Seçiniz...</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-4">
                    <label>İlçe</label>
                </div>
                <div class="col-8">
                    <select class="custom-select custom-select-sm" id="ilce">
                        <option value="">Seçiniz...</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-4">
                    <label>Yetkili Personel</label>
                </div>
                <div class="col-8">
                    <select class="custom-select custom-select-sm" id="personel_id">
                        <option value="">Seçiniz...</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group row">
                <div class="col-4">
                    <label>Adres</label>
                </div>
                <div class="col-8">
                    <textarea class="form-control form-control-sm" id="adres" cols="30" rows="3"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-4">
                    <label>Açıklama</label>
                </div>
                <div class="col-8">
                    <textarea class="form-control form-control-sm" id="aciklama" cols="30" rows="3"></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="car_banka_buttons">
        <button class="btn btn-success btn-sm" id="sube_ekle"><i class="fa fa-plus-square"
                                                                 aria-hidden="true"></i> Şube
            Ekle
        </button>
        <button class="btn btn-danger btn-sm" id="sube_sil"><i class="fa fa-trash" aria-hidden="true"></i> Şube Sil
        </button>
    </div>
    <div class="col-12 row mt-2">
        <table class="table table-sm table-bordered w-100 display nowrap" id="cari_sube" style="font-size: 13px;">
            <thead>
            <tr>
                <th>Şube Adı</th>
                <th>Adres</th>
                <th>İl</th>
                <th>İlçe</th>
                <th>Yetkili Personel</th>
                <th>Açıklama</th>
            </tr>
            </thead>
        </table>
    </div>
    <script>

        $("body").off("click", "#sube_ekle").on("click", "#sube_ekle", function () {
            var sube_adi = $("#sube_adi").val();
            var il = $("#il_sube").val();
            var ilce = $("#ilce").val();
            var adres = $("#adres").val();
            var aciklama = $("#aciklama").val();
            $.ajax({
                url: "controller/cari_controller/sql.php?islem=cariye_sube_ekle",
                type: "POST",
                data: {
                    sube_adi: sube_adi,
                    il: il,
                    ilce: ilce,
                    adres: adres,
                    aciklama: aciklama,
                    cari_kodu: "<?=$cari_kodu?>"
                },
                success: function (result) {
                    if (result != 2 || result != 500) {
                        Swal.fire(
                            'Başarılı!',
                            'Şube Eklendi',
                            'success'
                        )
                        var json = JSON.parse(result);
                        table.clear().draw(false);
                        json.forEach(function (item) {
                            let sube_bilgi_table = table.row.add([(item.sube_adi).toUpperCase(), (item.adres).toUpperCase(), (item.il_adi).toUpperCase(), (item.ilce_adi).toUpperCase(), item.yetkili_personelid, (item.aciklama).toUpperCase()]).draw(false).node();
                            $(sube_bilgi_table).attr("data-id", item.id);
                        })
                    } else {
                        Swal.fire(
                            'Oops...',
                            'Bilinmeyen Bir Hata Oluştu',
                            'error'
                        )
                    }
                }
            });
        })

        $("body").off("change", "#il_sube").on("change", "#il_sube", function () {
            var il_id = $(this).val();
            $.get("controller/cari_controller/sql.php?islem=ilceleri_getir", {il_id: il_id}, function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    $("#ilce").html("");
                    $("#ilce").append("" +
                        "<option>Seçiniz...</option>" +
                        "");
                    json.forEach(function (item) {
                        $("#ilce").append("" +
                            "<option value='" + item.id + "'>" + item.ilce_adi + "</option>" +
                            "");
                    })
                }
            })
        })
        $("body").off("click", ".sube_selected").on("click", ".sube_selected", function () {
            $('.sube_selected').css("background-color", "rgb(255, 255, 255)");
            $(this).css("background-color", "#60b3abad");
            $('.sube_selected').removeClass('select_sube');
            $(this).addClass("select_sube");
            $(".select").css("background-color", "#B9EDDD");
        });
        var table = "";

        $("body").off("click", "#sube_sil").on("click", "#sube_sil", function () {
            var id = $(".select_sube").attr("data-id");
            $.ajax({
                url: "controller/cari_controller/sql.php?islem=cariye_ait_sube_sil",
                type: "POST",
                data: {
                    id: id
                },
                success: function (result) {
                    if (result != 500) {
                        if (result == 2) {
                            table.clear().draw(false);
                            Swal.fire(
                                'Başarılı!',
                                'Şube Silindi',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Başarılı!',
                                'Şube Silindi',
                                'success'
                            );
                            var json = JSON.parse(result);
                            table.clear().draw(false);
                            json.forEach(function (item) {
                                let sube_bilgi_table = table.row.add([(item.sube_adi).toUpperCase(), (item.adres).toUpperCase(), (item.il_adi).toUpperCase(), (item.ilce_adi).toUpperCase(), item.yetkili_personelid, (item.aciklama).toUpperCase()]).draw(false).node();
                                $(sube_bilgi_table).attr("data-id", item.id);
                            })
                        }
                    } else {
                        Swal.fire(
                            'Oops...',
                            'Bilinmeyen Bir Hata İle Karşılaşıldı',
                            'error'
                        );
                    }
                }
            });
        });

        $(document).ready(function () {
            table = $('#cari_sube').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                createdRow: function (row) {
                    $(row).addClass("sube_selected");
                },
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            })
            $.get("controller/cari_controller/sql.php?islem=illeri_getir", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#il_sube").append("" +
                            "<option value='" + item.id + "'>" + item.il_adi + "</option>" +
                            "");
                    })
                }
            })
            $.get("controller/cari_controller/sql.php?islem=carinin_subeleri", {cari_kodu: "<?=$cari_kodu?>"}, function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        let sube_bilgi_table = table.row.add([(item.sube_adi).toUpperCase(), (item.adres).toUpperCase(), (item.il_adi).toUpperCase(), (item.ilce_adi).toUpperCase(), item.yetkili_personelid, (item.aciklama).toUpperCase()]).draw(false).node();
                        $(sube_bilgi_table).attr("data-id", item.id);
                    })
                }
            })
        });
    </script>
    <?php
}
if ($islem == "cari_guncelle") {
    $cari_kodu = $_GET["cari_kodu"];
    ?>
    <div class="modal fade" id="cari_guncelle_modal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog" style="width: 80%; max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Cari Güncelle
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat5"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <nav class="nav nav-pills flex-column flex-sm-row">
                        <a class="flex-sm-fill text-sm-center nav-link active cari_page_color" aria-current="page"
                           id="cari_genel_bilgiler">Cari Genel Bilgileri</a>
                        <a class="flex-sm-fill text-sm-center nav-link cari_page_color" id="adres_detay_bilgileri">Adres
                            Ve Detay Bilgileri</a>
                        <a class="flex-sm-fill text-sm-center nav-link cari_page_color"
                           id="cari_banka_bilgileri_button">Cari Banka Bilgileri</a>
                    </nav>
                    <div class="cari_paging"></div>
                    <div class="col-12 row mt-3 cari_genel_bilgiler">
                        <div class="col-4">
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Cari Türü</label>
                                </div>
                                <div class="col-8">
                                    <select class="custom-select custom-select-sm" id="cari_turu">
                                        <option value="">Seçiniz...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Cari Kodu</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" disabled
                                           value="<?= $cari_kodu ?>" id="cari_kodu">
                                </div>
                            </div>
                            <!--                            <div class="form-group row">-->
                            <!--                                <div class="col-4">-->
                            <!--                                    <label>Cari Ünvanı</label>-->
                            <!--                                </div>-->
                            <!--                                <div class="col-8">-->
                            <!--                                    <input type="text" class="form-control form-control-sm" id="cari_unvani">-->
                            <!--                                </div>-->
                            <!--                            </div>-->
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Cari Ünvanı</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="cari_adi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Vergi Dairesi</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="vergi_dairesi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Vergi No</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="vergi_no">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Web Sitesi</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="internet_sitesi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Açıklama</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="aciklama">
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Bilanço Kodu</label>
                                </div>
                                <div class="col-8">
                                    <select class="custom-select custom-select-sm" id="bilanco_id">
                                        <option value="">Seçiniz...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Cari Grubu</label>
                                </div>
                                <div class="col-8">
                                    <select class="custom-select custom-select-sm" id="cari_grubu">
                                        <option value="">Seçiniz...</option>
                                        <option value="1">Test</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Vade Günü</label>
                                </div>
                                <div class="col-8">
                                    <input type="number" class="form-control form-control-sm" id="vade_gunu">
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
                                    <label>Cep Telefonu</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="cep_telefonu">
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
                                    <label>E-Posta</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="e_mail">
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="ibox-title" style="background-color: #9DB2BF;color: white">
                                <span>1. Yetkili</span>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Adı Soyadı</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="yetkili_adi1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Cep</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="yetkili_tel1">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>E-Posta</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="yetkili_mail1">
                                </div>
                            </div>
                            <div class="ibox-title" style="background-color: #9DB2BF;color: white">
                                <span>2. Yetkili</span>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Adı Soyadı</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="yetkili_ad2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>Cep</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="yetkili_tel2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-4">
                                    <label>E-Posta</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control form-control-sm" id="yetkili_mail">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" data-bs-dismiss="modal" id="modal_kapat5">
                                Kapat
                            </button>
                            <button class="btn btn-success btn-sm" id="cari_guncelle">Cari Güncelle</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("body").off("click", "#modal_kapat5").on("click", "#modal_kapat5", function () {
            $("#cari_guncelle_modal").modal("hide");
        })
        $(document).ready(function () {
            $.get("controller/cari_controller/sql.php?islem=cari_turleri_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#cari_turu").append("" +
                            "<option value='" + item.id + "'>" + item.cari_turu_adi + "</option>" +
                            "");
                    })
                }
            })
            $.get("controller/cari_controller/sql.php?islem=cari_gruplarini_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#cari_grubu").append("" +
                            "<option value='" + item.id + "'>" + item.cari_grup_adi + "</option>" +
                            "");
                    })
                }
            })
            $.get("controller/cari_controller/sql.php?islem=bilancolari_getir_sql", function (result) {
                var json = JSON.parse(result);
                json.forEach(function (item) {
                    $("#bilanco_id").append("" +
                        "<option value='" + item.id + "'>" + item.bilanco_adi + "</option>" +
                        "");
                });
            });

            $("#cari_guncelle_modal").modal("show");
            $.get("controller/cari_controller/sql.php?islem=cari_bilgileri_getir", {cari_kodu: "<?=$cari_kodu?>"}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#cari_turu").val(item.cari_turu);
                    $("#cari_kodu").val(item.cari_kodu);
                    $("#cari_adi").val(item.cari_adi);
                    $("#vergi_dairesi").val(item.vergi_dairesi);
                    $("#vergi_no").val(item.vergi_no);
                    $("#internet_sitesi").val(item.internet_sitesi);
                    $("#bilanco_id").val(item.bilanco_id);
                    $("#cari_grubu").val(item.cari_grubu);
                    $("#vade_gunu").val(item.vade_gunu);
                    $("#telefon").val(item.telefon);
                    $("#cep_telefonu").val(item.cep_telefonu);
                    $("#faks").val(item.faks);
                    $("#e_mail").val(item.e_mail);
                    $("#yetkili_adi1").val(item.yetkili_adi1);
                    $("#yetkili_tel1").val(item.yetkili_tel1);
                    $("#yetkili_mail1").val(item.yetkili_mail1);
                    $("#yetkili_ad2").val(item.yetkili_ad2);
                    $("#yetkili_tel2").val(item.yetkili_tel2);
                    $("#yetkili_mail").val(item.yetkili_mail);
                    $("#aciklama").val(item.aciklama);
                }
            })
        })

        $("body").off("click", "#cari_guncelle").on("click", "#cari_guncelle", function () {
            var cari_turu = $("#cari_turu").val();
            var cari_kodu = $("#cari_kodu").val();
            var cari_unvani = $("#cari_adi").val();
            var cari_adi = $("#cari_adi").val();
            var vergi_dairesi = $("#vergi_dairesi").val();
            var vergi_no = $("#vergi_no").val();
            var internet_sitesi = $("#internet_sitesi").val();
            var bilanco_id = $("#bilanco_id").val();
            var cari_grubu = $("#cari_grubu").val();
            var vade_gunu = $("#vade_gunu").val();
            var telefon = $("#telefon").val();
            var cep_telefonu = $("#cep_telefonu").val();
            var faks = $("#faks").val();
            var e_mail = $("#e_mail").val();
            var yetkili_adi1 = $("#yetkili_adi1").val();
            var yetkili_tel1 = $("#yetkili_tel1").val();
            var yetkili_mail1 = $("#yetkili_mail1").val();
            var yetkili_ad2 = $("#yetkili_ad2").val();
            var yetkili_tel2 = $("#yetkili_tel2").val();
            var yetkili_mail = $("#yetkili_mail").val();
            var aciklama = $("#aciklama").val();
            if (cari_turu == "") {
                Swal.fire(
                    'Uyarı!',
                    'Lütfen Bir Cari Türü Seçiniz...',
                    'warning'
                );
            } else {
                $.ajax({
                    url: "controller/cari_controller/sql.php?islem=cari_guncelle",
                    type: "POST",
                    data: {
                        cari_turu: cari_turu,
                        cari_kodu: cari_kodu,
                        cari_unvani: cari_unvani,
                        cari_adi: cari_adi,
                        vergi_dairesi: vergi_dairesi,
                        vergi_no: vergi_no,
                        internet_sitesi: internet_sitesi,
                        bilanco_id: bilanco_id,
                        cari_grubu: cari_grubu,
                        vade_gunu: vade_gunu,
                        telefon: telefon,
                        cep_telefonu: cep_telefonu,
                        faks: faks,
                        e_mail: e_mail,
                        yetkili_adi1: yetkili_adi1,
                        yetkili_tel1: yetkili_tel1,
                        yetkili_mail1: yetkili_mail1,
                        yetkili_ad2: yetkili_ad2,
                        yetkili_tel2: yetkili_tel2,
                        yetkili_mail: yetkili_mail,
                        aciklama: aciklama,
                    },
                    success: function (result) {
                        if (result != 2) {
                            Swal.fire(
                                'Başarılı!',
                                'Cari Güncellendi Edildi',
                                'success'
                            );
                            $.get("view/add_cari_page.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            })
                        } else {
                            Swal.fire(
                                'Oops...',
                                'Bilinmeyen Bir Hata Oluştu',
                                'error'
                            )
                        }
                    }
                })
            }
        })

        $("body").off("click", "#modal_kapat5").on("click", "#modal_kapat5", function () {
            $("#cari_guncelle_modal").modal("hide");
        })

        $("body").off("click", "#cari_genel_bilgiler").on("click", "#cari_genel_bilgiler", function () {
            $(".cari_page_color").removeClass("active");
            $(this).addClass("active");
            $.get("modals/cari_modal/modal_page.php?islem=cari_genel_bilgiler_page", function (getList) {

                $(".cari_paging").html("");
                $(".cari_genel_bilgiler").show();
            });
        })

        $("body").off("click", "#adres_detay_bilgileri").on("click", "#adres_detay_bilgileri", function () {
            $(".cari_page_color").removeClass("active");
            $(this).addClass("active");
            $.get("modals/cari_modal/modal_page.php?islem=adres_bilgileri_modal", {cari_kodu: "<?=$_GET["cari_kodu"]?>"}, function (getList) {
                $(".cari_genel_bilgiler").hide();
                $(".cari_paging").html("");
                $(".cari_paging").html(getList);
            });
        });

        $("body").off("click", "#cari_banka_bilgileri_button").on("click", "#cari_banka_bilgileri_button", function () {
            $(".cari_page_color").removeClass("active");
            $(this).addClass("active");
            $.get("modals/cari_modal/modal_page.php?islem=cari_banka_bilgileri_modal", {cari_kodu: "<?=$_GET["cari_kodu"]?>"}, function (getList) {
                $(".cari_genel_bilgiler").hide();
                $(".cari_paging").html("");
                $(".cari_paging").html(getList);
            });
        })
        $("body").off("click", "#cari_sube_bilgileri").on("click", "#cari_sube_bilgileri", function () {
            $(".cari_page_color").removeClass("active");
            $(this).addClass("active");
            $.get("modals/cari_modal/modal_page.php?islem=cari_sube_bilgileri_modal", {cari_kodu: "<?=$_GET["cari_kodu"]?>"}, function (getList) {
                $(".cari_genel_bilgiler").hide();
                $(".cari_paging").html("");
                $(".cari_paging").html(getList);
            });
        })
    </script>
    <?php
}