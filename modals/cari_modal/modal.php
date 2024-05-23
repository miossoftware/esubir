<?php
date_default_timezone_set('Europe/Istanbul');
session_start();
$islem = $_GET["islem"];
if ($islem == "cari_ekle_modal") {
    ?>
    <div class="modal fade" id="cari_ekleme_modal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog" style="width: 80%; max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat" data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>YENİ CARİ EKLE</div>
                        </div>

                        <div class="modal-body">
                            <div class="col-12 row mt-3">
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
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="cari_kodu">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="cari_kodu_olustur"><i
                                                                class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>Cari Ünvanı</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" class="form-control form-control-sm cari_unvan"
                                                   id="cari_unvani">
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
                                            <input type="text" class="form-control form-control-sm"
                                                   id="internet_sitesi">
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
                                    <div class="ibox-title" style="background-color: #9DB2BF;color: white"><span>1. Yetkili</span>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>Adı Soyadı</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="yetkili_adi1">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>Cep</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="yetkili_tel1">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>E-Posta</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="yetkili_mail1">
                                        </div>
                                    </div>
                                    <div class="ibox-title" style="background-color: #9DB2BF; color: white"><span>2. Yetkili</span>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>Adı Soyadı</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="yetkili_ad2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>Cep</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="yetkili_tel2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>E-Posta</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="yetkili_mail">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3"></div>
                            <nav class="nav nav-pills flex-column flex-sm-row">
                                <a class="flex-sm-fill text-sm-center nav-link cari_page_color active"
                                   id="adres_detay_bilgileri">Adres
                                    Ve Detay Bilgileri</a>
                                <a class="flex-sm-fill text-sm-center nav-link cari_page_color"
                                   id="cari_banka_bilgileri_button">Cari Banka Bilgileri</a>
                                <!--                                <a class="flex-sm-fill text-sm-center nav-link cari_page_color"-->
                                <!--                                   id="cari_sube_bilgileri">Cari-->
                                <!--                                    Şube Bilgileri</a>-->
                            </nav>
                            <div class="cari_adres_bilgileri_div">
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
                                        <!--                                        <div class="form-group row">-->
                                        <!--                                            <div class="col-4">-->
                                        <!--                                                <label>İlçe</label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-8">-->
                                        <!--                                                <select class="custom-select custom-select-sm" id="ilce">-->
                                        <!--                                                    <option value="">Seçiniz...</option>-->
                                        <!--                                                </select>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <div class="form-group row">
                                            <div class="col-4">
                                                <label>Adres</label>
                                            </div>
                                            <div class="col-8">
                                                <textarea class="form-control form-control-sm" id="adres" cols="30"
                                                          style="resize: none"
                                                          rows="7"></textarea>
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
                                </div>
                            </div>
                            <div class="cari_banka_bilgileri_div" style="display: none">
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
                                                <input type="text" class="form-control form-control-sm"
                                                       id="aciklama_banka">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="car_banka_buttons mt-2">
                                        <button class="btn btn-success btn-sm" id="cariye_banka_ekle"><i
                                                    class="fa fa-plus-square"
                                                    aria-hidden="true"></i> Banka Ekle
                                        </button>
                                    </div>
                                    <div class="col-12 row mt-2">
                                        <table class="table table-sm table-bordered w-100 display nowrap"
                                               id="cari_banka" style="font-size: 13px">
                                            <thead>
                                            <tr>
                                                <th>Banka Adı</th>
                                                <th>Şube Adı</th>
                                                <th>Şube Kodu</th>
                                                <th>Hesap Numarası</th>
                                                <th>IBAN Numarası</th>
                                                <th>Açıklama</th>
                                                <th>İşlem</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="cari_sube_bilgileri_div" style="display: none">
                                <div class="col-12 row">
                                    <div class="col-6">
                                        <div class="form-group row">
                                            <div class="col-4">
                                                <label>Şube Adı</label>
                                            </div>
                                            <div class="col-8">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="sube_adi_sube">
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
                                                <textarea class="form-control form-control-sm" id="adres" cols="30"
                                                          style="resize: none"
                                                          rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-4">
                                                <label>Açıklama</label>
                                            </div>
                                            <div class="col-8">
                                                <textarea class="form-control form-control-sm" id="aciklama_sube"
                                                          cols="30"
                                                          rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="car_banka_buttons">
                                    <button class="btn btn-success btn-sm" id="sube_ekle"><i class="fa fa-plus-square"
                                                                                             aria-hidden="true"></i>
                                        Şube
                                        Ekle
                                    </button>
                                    <button class="btn btn-danger btn-sm" id="sube_sil"><i class="fa fa-trash"
                                                                                           aria-hidden="true"></i> Şube
                                        Sil
                                    </button>
                                </div>
                                <div class="col-12 row mt-2">
                                    <table class="table table-sm table-bordered w-100 display nowrap" id="cari_sube"
                                           style="font-size: 13px;">
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
                            </div>
                            <div class="cari_paging"></div>
                            <div class="modal-footer">
                                <button class="btn btn-danger btn-sm" data-bs-dismiss="modal" id="modal_kapat">
                                    Kapat
                                </button>
                                <button class="btn btn-success btn-sm" id="cari_ekle">Cari Ekle</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('input').click(function () {
                $(this).select();
            });
            $(".cari_unvan").keyup(function () {
                var val = $(this).val();
                $(".cari_ad").val(val);
            });

            $("body").off("click", "#cari_kodu_olustur").on("click", "#cari_kodu_olustur", function () {
                var harf_kodu = $("#cari_kodu").val();
                $.get("controller/cari_controller/sql.php?islem=son_cari_kodu_cek", {harf_kodu: harf_kodu}, function (result) {
                    if (result != "") {
                        $("#cari_kodu").val("");
                        $("#cari_kodu").val(result);
                    } else {
                        $("#cari_kodu").val("");
                        $("#cari_kodu").val(harf_kodu + "1");
                    }
                });
            });

            $("body").off("click", "#cariye_banka_ekle").on("click", "#cariye_banka_ekle", function () {
                let banka_adi = $("#banka_adi").val();
                let sube_adi = $("#sube_adi").val();
                let sube_kodu = $("#sube_kodu").val();
                let hesap_no = $("#hesap_no").val();
                let iban_no = $("#iban_no").val();
                let aciklama = $("#aciklama_banka").val();
                banka_table.row.add([banka_adi, sube_adi, sube_kodu, hesap_no, iban_no, aciklama, "<button class='btn btn-danger btn-sm cariye_ait_banka_sil_list_button'><i class='fa fa-trash'></i></button>"]).draw(false);
            });

            $("body").off("click", ".cariye_ait_banka_sil_list_button").on("click", ".cariye_ait_banka_sil_list_button", function () {
                var row = $(this).closest('tr');
                banka_table.row(row).remove().draw();
            });

            $("body").off("change", "#il").on("click", "#il", function () {
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
            });


            var banka_table = "";
            var sube_table = "";
            $(document).ready(function () {

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

                sube_table = $('#cari_sube').DataTable({
                    scrollY: '35vh',
                    scrollX: true,
                    "info": false,
                    "paging": false,
                    createdRow: function (row) {
                        $(row).addClass("sube_selected");
                    },
                    "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                })
                banka_table = $('#cari_banka').DataTable({
                    scrollY: '35vh',
                    scrollX: true,
                    "info": false,
                    "paging": false,
                    "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                    createdRow: function (row) {
                        $(row).addClass("added_banks");
                    }
                })
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

                $("#cari_ekleme_modal").modal("show");
                $.get("controller/cari_controller/sql.php?islem=bilancolari_getir_sql", function (result) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#bilanco_id").append("" +
                            "<option value='" + item.id + "'>" + item.bilanco_adi + "</option>" +
                            "");
                    })
                })
            })

            $("body").off("change", "#cari_turu").on("change", "#cari_turu", function () {
                let val = $(this).val();
                if (val == 3) {
                    $("#cari_grubu").val("3");
                    $("#cari_grubu").prop("disabled", true);
                } else if (val == 13) {
                    $("#cari_grubu").val("15");
                    $("#cari_grubu").prop("disabled", true);
                } else if (val == 1 || val == 4) {
                    $("#cari_grubu").val("11");
                    $("#cari_grubu").prop("disabled", true);
                } else if (val == 2) {
                    $("#cari_grubu").val("15");
                } else {
                    $("#cari_grubu").val("1");
                }
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
                var eksilenMetin = cari_kodu.slice(0, -1);
                var son_no = cari_kodu.slice(-1);

                // CARİ ADRES BİLGİLERİ

                let cari_il = $("#il").val();
                let cari_ilce = $("#ilce").val();
                let adres = $("#adres").val();
                let ozel_kod1 = $("#ozel_kod1").val();
                let ozel_kod2 = $("#ozel_kod2").val();
                let ozel_kod3 = $("#ozel_kod3").val();

                // CARİ BANKA BİLGİLERİ
                var banka_arr = [];

                $(".added_banks").each(function () {
                    let banka_adi = $(this).find("td").eq(0).text();
                    let sube_adi = $(this).find("td").eq(1).text();
                    let sube_kodu = $(this).find("td").eq(2).text();
                    let hesap_no = $(this).find("td").eq(3).text();
                    let iban_no = $(this).find("td").eq(4).text();
                    let aciklama = $(this).find("td").eq(5).text();

                    let newRow = {
                        banka_adi: banka_adi,
                        sube_adi: sube_adi,
                        sube_kodu: sube_kodu,
                        hesap_no: hesap_no,
                        iban_no: iban_no,
                        aciklama: aciklama
                    };
                    banka_arr.push(newRow);
                });

                if (bilanco_id == null || bilanco_id == "") {
                    Swal.fire(
                        'Uyarı!',
                        'Bilanço Kodu Boş Kalamaz',
                        'warning'
                    );
                } else {
                    $.ajax({
                        url: "controller/cari_controller/sql.php?islem=cari_ekle",
                        type: "POST",
                        data: {
                            cari_turu: cari_turu,
                            cari_kodu: cari_kodu.toUpperCase(),
                            cari_adi: cari_unvani,
                            vergi_dairesi: vergi_dairesi,
                            vergi_no: vergi_no,
                            son_no: son_no,
                            harf_kodu: eksilenMetin,
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
                            cari_il: cari_il,
                            cari_ilce: cari_ilce,
                            adres: adres,
                            ozel_kod3: ozel_kod3,
                            ozel_kod2: ozel_kod2,
                            ozel_kod1: ozel_kod1,
                            banka_arr: banka_arr
                        },
                        success: function (result) {
                            if (result != 2) {
                                if (result == 500) {
                                    Swal.fire(
                                        'Uyarı!',
                                        'Bu Cari Zaten Kayıtlı',
                                        'warning'
                                    );
                                } else {
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
                                }
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

            $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
                var cari_kodu = $("#cari_kodu").val();
                var eksilenMetin = cari_kodu.slice(0, -1);

                $("#cari_ekleme_modal").modal("hide");
            })


            $("body").off("click", "#adres_detay_bilgileri").on("click", "#adres_detay_bilgileri", function () {
                $(".cari_page_color").removeClass("active");
                $(this).addClass("active");
                $(".cari_adres_bilgileri_div").css("display", "block");
                $(".cari_banka_bilgileri_div").css("display", "none");
                $(".cari_sube_bilgileri_div").css("display", "none");
            });

            $("body").off("click", "#cari_banka_bilgileri_button").on("click", "#cari_banka_bilgileri_button", function () {
                $(".cari_page_color").removeClass("active");
                $(this).addClass("active");
                $(".cari_banka_bilgileri_div").css("display", "block");
                $(".cari_adres_bilgileri_div").css("display", "none");
                $(".cari_sube_bilgileri_div").css("display", "none");
            })
            $("body").off("click", "#cari_sube_bilgileri").on("click", "#cari_sube_bilgileri", function () {
                $(".cari_page_color").removeClass("active");
                $(this).addClass("active");
                $(".cari_sube_bilgileri_div").css("display", "block");
                $(".cari_banka_bilgileri_div").css("display", "none");
                $(".cari_adres_bilgileri_div").css("display", "none");
            })
        </script>
    <?php
}