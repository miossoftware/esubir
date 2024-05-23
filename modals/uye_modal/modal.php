<?php

$islem = $_GET["islem"];

if ($islem == "uye_ekle_modal") {
    ?>
    <style>
        #uyeyi_guncelle_modal_getir {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="uyeyi_guncelle_modal_getir" data-bs-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 70%; max-width: 70%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="uye_tanim_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ÜYE TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="uye_tapulari"></div>
                            <div class="uye_tarife_tapulari"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Üye Türü</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="uye_turu">
                                                <option value="Üye">Üye</option>
                                                <option value="Üye Değil">Üye Değil</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>TC No:</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="tel" class="form-control form-control-sm"
                                                   id="main_tc_no" oninput="limitLength(this,11)">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Üye Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="uye_adi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Üye Numarası</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="uye_numarasi">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Cep No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="tel" class="form-control form-control-sm" id="cep_no"
                                                   oninput="limitLength(this,11)">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>İl / İlçe</label>
                                        </div>
                                        <div class="col-md-7 row no-gutters">
                                            <div class="col">
                                                <input type="text" class="form-control form-control-sm" id="il">
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control form-control-sm" id="ilce">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Doğum Tarihi</label>
                                        </div>
                                        <div class="col-md-7 ">
                                            <input type="date" class="form-control form-control-sm" id="dogum_tarihi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Baba Adı</label>
                                        </div>
                                        <div class="col-md-7 ">
                                            <input type="text" class="form-control form-control-sm" id="baba_adi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Adres</label>
                                        </div>
                                        <div class="col-md-7">
                                            <textarea class="form-control form-control-sm" id="adres" cols="30" rows="1"
                                                      style="resize: none"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ibox-title" style="background-color: #374f65;color: white;font-size: 18px">
                                <center><span style="font-weight: bold">TAPU BİLGİLERİ</span></center>
                            </div>
                            <div class="col-12 row mt-4">
                                <div class="col-6">
                                    <div class="ibox-title" style="background-color: #9DB2BF;color: white">
                                        <center><span>Taşınmaz Bilgileri</span></center>
                                    </div>
                                    <div class="mt-2"></div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>İl</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="tapu_il">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>İlçe</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="tapu_ilce" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Mahalle/Köy</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="mahalle_koy">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Ada / Parsel</label>
                                        </div>
                                        <div class="col-md-7 row no-gutters">
                                            <div class="col">
                                                <input type="text" placeholder="Ada" id="ada_parsel"
                                                       class="form-control form-control-sm">
                                            </div>
                                            <div class="col">
                                                <input type="text" placeholder="Parsel" id="parsel"
                                                       class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Yüz Ölçümü</label>
                                        </div>
                                        <div class="col-md-7 row no-gutters">
                                            <div class="col">
                                                <input type="text" style="text-align: right" id="yuz_olcumu"
                                                       placeholder="Yüz Ölçümü"
                                                       class="form-control form-control-sm">
                                            </div>
                                            <div class="col">
                                                <input type="text" style="text-align: right" id="sulama_alani"
                                                       placeholder="Sulama Alanı"
                                                       class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Cilt / Sayfa No</label>
                                        </div>
                                        <div class="col-md-7 row no-gutters">
                                            <input type="text" class="form-control form-control-sm" id="guncel_ciltno">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="ibox-title" style="background-color: #9DB2BF;color: white">
                                        <center><span>Tescile İlişkin Bilgiler</span></center>
                                    </div>
                                    <div class="mt-2"></div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Taşınmaz No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="tasinmaz_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Edinme Nedeni</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="edinme_nedeni">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Tescil Trh/Yevmiye</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="tescil_tarihi">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="ibox-title" style="background-color: #9DB2BF;color: white">
                                        <center><span>Malik Bilgileri</span></center>
                                    </div>
                                    <div class="mt-2"></div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Ad Soyad</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="malik_adi" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Baba Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="baba_adi" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="ibox-title" style="background-color: #9DB2BF;color: white">
                                        <center><span>Diğer Bilgiler</span></center>
                                    </div>
                                    <div class="mt-2"></div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-md-7">
                                        <textarea class="form-control form-control-sm" style="resize: none"
                                                  id="tapu_aciklama"
                                                  rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success btn-sm" id="tapu_ekle"><i class="fa fa-plus"></i>
                                            Tapu Ekle
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row">
                                <div class="ibox-title" style="background-color: #9DB2BF;color: white">
                                    <center><span>Üye'ye Ait Tapular</span></center>
                                </div>
                                <table class="table table-sm table-bordered w-100  nowrap" id="tapu_listesi"
                                       style="font-size: 13px;">
                                    <thead>
                                    <tr>
                                        <th id="tarife_click" style="width: 1% !important;">İl</th>
                                        <th>İlçe</th>
                                        <th>Mahalle/Köy</th>
                                        <th>Ada</th>
                                        <th>Parsel</th>
                                        <th>Yüz Ölçümü</th>
                                        <th>Sulama Alanı</th>
                                        <th>Cilt No</th>
                                        <th>Taşınmaz No</th>
                                        <th>Edinme Nedeni</th>
                                        <th>Tescil Trh.</th>
                                        <th>Ad Soyad</th>
                                        <th>Baba Adı</th>
                                        <th>Açıklama</th>
                                        <th>İşlem</th>
                                    </tr>
                                    </thead>
                                </table>
                                <div class="ibox-title" style="background-color: #374f65;color: white;font-size: 18px">
                                    <center><span style="font-weight: bold">TARİFE BİLGİLERİ</span></center>
                                </div>
                                <div class="mt-3"></div>
                                <div class="col-12 row">
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <label>Tapu</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm"
                                                           id="tapu_id">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-warning btn-sm"
                                                                id="uyeye_ait_tapulari_getir_button"><i
                                                                    class="fa fa-ellipsis-h"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <label>Tarife</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm"
                                                           id="tarife_id">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-warning btn-sm"
                                                                id="tarifeleri_getir_button"><i
                                                                    class="fa fa-ellipsis-h"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <label>MetreKare</label>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control form-control-sm" id="metrekare">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success btn-sm" id="tarife_ekle_button"><i
                                                    class="fa fa-plus"></i> Tarife Ekle
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <table class="table table-sm table-bordered w-100  nowrap" id="uye_tarife_listesi"
                                           style="font-size: 13px;">
                                        <thead>
                                        <tr>
                                            <th id="tarife_click123" style="width: 1% !important;">Tapu</th>
                                            <th>Tarife Kodu</th>
                                            <th>Tarife Fiyatı</th>
                                            <th>Metre Kare</th>
                                            <th>İşlem</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="uye_tanim_vazgec"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="uye_kaydet_button"><i class="fa fa-check"></i>
                                Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        $("body").off("focusout", "#uye_adi").on("focusout", "#uye_adi", function () {
            let val = $(this).val();
            $("#malik_adi").val(val);
        })

        function limitLength(element, maxLength) {
            if (element.value.length > maxLength) {
                element.value = element.value.slice(0, maxLength);
            }
            element.value = element.value.replace(/\D/g, '');
        }


        $("body").off("click", "#uyeye_ait_tapulari_getir_button").on("click", "#uyeye_ait_tapulari_getir_button", function () {
            let tc_no = $("#main_tc_no").val();
            $.get("modals/uye_modal/modal.php?islem=tapulari_getir_modal", {tc_no: tc_no}, function (getModal) {
                $(".uye_tapulari").html(getModal);
            })
        });

        $("body").off("click", "#tarifeleri_getir_button").on("click", "#tarifeleri_getir_button", function () {
            let tc_no = $("#main_tc_no").val();
            let uye_mi = $("#uye_turu").val();
            $.get("modals/uye_modal/modal.php?islem=tarifeleri_getir_modal", {
                tc_no: tc_no,
                uye_mi: uye_mi
            }, function (getModal) {
                $(".uye_tarife_tapulari").html(getModal);
            })
        });

        $(document).ready(function () {


            $("#uyeyi_guncelle_modal_getir").modal("show");

            var uye_tarifeleri = $('#uye_tarife_listesi').DataTable({
                scrollY: '15vh',
                scrollX: true,
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row, data, dataIndex) {
                    $(row).addClass("uye_tarife_selected");
                    $(row).find("td").css("text-align", "left");
                }
            });

            $("body").off("click", "#tarife_ekle_button").on("click", "#tarife_ekle_button", function () {
                let tapu_id = $("#tapu_id").attr("data-id");
                let tarife_id = $("#tarife_id").attr("data-id");
                let metre_kare = $("#metrekare").val();
                if (tapu_id == undefined || tapu_id == "") {
                    Swal.fire(
                        "Uyarı!",
                        "Lütfen Bir Tapu Seçiniz...",
                        "warning"
                    );
                } else if (tarife_id == undefined || tarife_id == "") {
                    Swal.fire(
                        "Uyarı!",
                        "Lütfen Bir Tarife Seçiniz...",
                        "warning"
                    );
                } else {
                    $.ajax({
                        url: 'controller/uye_controller/sql.php?islem=tapuya_tarife_ekle_sql',
                        type: "POST",
                        data: {
                            tapu_id: tapu_id,
                            tarife_id: tarife_id,
                            sulama_metrekare: metre_kare
                        },
                        success: function (res) {
                            if (res != 2) {
                                var item = JSON.parse(res);
                                let row = uye_tarifeleri.row.add([item.mahalle_koy, item.tarife_kodu, item.tarife_fiyati, item.sulama_metrekare, '<button class="btn btn-danger btn-sm tapu_tarife_sil_button" data-id="' + item.id + '"><i class="fa fa-trash"></i></button>']).draw(false).node();
                                $(row).attr("data-id", item.id);
                            }
                        }
                    });
                }
            });

            $("body").off("click", ".tapu_tarife_sil_button").on("click", ".tapu_tarife_sil_button", function () {
                let id = $(this).attr("data-id");
                var satir = $(this).closest('tr');

                $.ajax({
                    url: "controller/uye_controller/sql.php?islem=uye_tarifesini_sil_sql",
                    type: "POST",
                    data: {
                        id: id
                    },
                    success: function (res) {
                        if (res == 1) {
                            uye_tarifeleri.row(satir).remove().draw(false);
                        }
                    }
                });
            });

            var tapu_listesi = $('#tapu_listesi').DataTable({
                scrollY: '25vh',
                scrollX: true,
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row, data, dataIndex) {
                    $(row).addClass("tapu_tarife_selected");
                    $(row).find("td").css("text-align", "left");
                }
            });

            $("body").off("click", ".tapu_tarife_selected").on("click", ".tapu_tarife_selected", function () {
                $(".tapu_tarife_selected").removeClass("secilen_tapu")
                $(this).addClass("secilen_tapu")
                let orjinal_veri = $(this).attr("data-array");
                if (orjinal_veri == null || orjinal_veri == undefined) {
                    uye_tarifeleri.clear().draw(false);
                } else {
                    uye_tarifeleri.clear().draw(false);
                    orjinal_veri = JSON.parse(atob(orjinal_veri));
                    orjinal_veri.forEach(function (item) {
                        uye_tarifeleri.row.add([item.tarife_kodu, item.tarife_adi, item.tarife_fiyati, "<input type='text' class='form-control form-control-sm sulama_metrekare' value='" + item.metre_kare + "' style='width: 75%!important;' />"]).draw(false);
                    });
                }
            });

            $("body").off("click", "#tapu_ekle").on("click", "#tapu_ekle", function () {
                let tapu_il = $("#tapu_il").val();
                let tapu_ilce = $("#tapu_ilce").val();
                let mahalle = $("#mahalle_koy").val();
                let ada = $("#ada_parsel").val();
                let parsel = $("#parsel").val();
                let cilt_no = $("#guncel_ciltno").val();
                let yuz_olcumu = $("#yuz_olcumu").val();
                yuz_olcumu = yuz_olcumu.replace(/\./g, "").replace(",", ".");
                yuz_olcumu = parseFloat(yuz_olcumu);
                let sulama_alani = $("#sulama_alani").val();
                sulama_alani = sulama_alani.replace(/\./g, "").replace(",", ".");
                sulama_alani = parseFloat(sulama_alani);
                let tasinmaz_no = $("#tasinmaz_no").val();
                let edinme_nedeni = $("#edinme_nedeni").val();
                let tescil_tarihi = $("#tescil_tarihi").val();
                let ad_soyad = $("#malik_adi").val();
                let baba_adi = $("#baba_adi").val();
                let aciklama = $("#tapu_aciklama").val();
                let main_tc_no = $("#main_tc_no").val();

                if (main_tc_no == "") {
                    Swal.fire(
                        "Uyarı!",
                        "Lütfen Önce TC Giriniz...",
                        "warning"
                    );
                } else {
                    $.ajax({
                        url: 'controller/uye_controller/sql.php?islem=dummy_tapu_ekle_sql',
                        type: "POST",
                        data: {
                            il: tapu_il,
                            ilce: tapu_ilce,
                            mahalle_koy: mahalle,
                            ada: ada,
                            parsel: parsel,
                            cilt_no: cilt_no,
                            yuz_olcumu: yuz_olcumu,
                            sulama_alani: sulama_alani,
                            tasinmaz_no: tasinmaz_no,
                            edinme_nedeni: edinme_nedeni,
                            tescil_tarihi: tescil_tarihi,
                            ad_soyad: ad_soyad,
                            baba_adi: baba_adi,
                            aciklama: aciklama,
                            tc_no: main_tc_no
                        },
                        success: function (res) {
                            if (res != 500) {
                                let id = res;
                                id = id.split(":");
                                id = id[1];
                                tapu_listesi.row.add([tapu_il, tapu_ilce, mahalle, ada, parsel, yuz_olcumu, sulama_alani, cilt_no, tasinmaz_no, edinme_nedeni, tescil_tarihi, ad_soyad, baba_adi, aciklama, "<button class='btn btn-danger btn-sm tapu-sil-button' data-id='" + id + "'><i class='fa fa-trash'></i></button>"]).draw(false);
                                $("#tapu_il").val("");
                                $("#tapu_ilce").val("");
                                $("#mahalle_koy").val("");
                                $("#ada_parsel").val("");
                                $("#parsel").val("");
                                $("#guncel_ciltno").val("");
                                $("#yuz_olcumu").val("");
                                $("#sulama_alani").val("");
                                $("#tasinmaz_no").val("");
                                $("#edinme_nedeni").val("");
                                $("#tescil_tarihi").val("");
                                $("#malik_adi").val("");
                                $("#baba_adi").val("");
                                $("#tapu_aciklama").val("");
                            }
                        }
                    });
                }
            });
            $("body").off("click", ".tapu-sil-button").on("click", ".tapu-sil-button", function () {
                var satir = $(this).closest('tr');
                let id = $(this).attr("data-id");
                $.ajax({
                    url: 'controller/uye_controller/sql.php?islem=uyeye_ait_tapu_sil_sql',
                    type: "POST",
                    data: {
                        id: id
                    },
                    success: function (res) {
                        if (res == 1) {
                            tapu_listesi.row(satir).remove().draw(false);
                        }
                    }
                });
            });

            $("body").off("click", ".tarife_liste_selected").on("click", ".tarife_liste_selected", function () {
                let tarife_kodu = $(this).find("td").eq(0).text();
                let tarife_adi = $(this).find("td").eq(1).text();
                let tarife_fiyati = $(this).find("td").eq(2).text();
                let varmi = false;

                $(".uye_tarife_selected").each(function () {
                    let tarife_kodu2 = $(this).find("td").eq(0).text();
                    if (tarife_kodu == tarife_kodu2) {
                        varmi = true;
                    }
                });

                let tapu_varmi = false;
                $(".tapu_tarife_selected").each(function () {
                    if ($(this).hasClass("secilen_tapu")) {
                        tapu_varmi = true;
                    }
                })

                if (varmi == true) {
                    Swal.fire(
                        "Uyarı!",
                        "Seçtiğiniz Tarife Listede Mevcuttur...",
                        "warning"
                    );
                } else if (tapu_varmi == false) {
                    Swal.fire(
                        "Uyarı!",
                        "Lütfen Bir Tapu Seçiniz...",
                        "warning"
                    );
                } else {
                    uye_tarifeleri.row.add([tarife_kodu, tarife_adi, tarife_fiyati, "<input type='text' class='form-control form-control-sm sulama_metrekare' style='width: 75%!important;' />"]).draw(false);
                }
            });

            $("body").off("focusout", ".sulama_metrekare").on("focusout", ".sulama_metrekare", function () {
                let yerlesecek_arr = [];
                $(".uye_tarife_selected").each(function () {
                    let tarife_kodu = $(this).find("td").eq(0).text();
                    let tarife_adi = $(this).find("td").eq(1).text();
                    let tarife_fiyati = $(this).find("td").eq(2).text();
                    let metre_kare = $(this).find("td:eq(3) input").val();

                    let newRow = {
                        tarife_kodu: tarife_kodu,
                        tarife_adi: tarife_adi,
                        tarife_fiyati: tarife_fiyati,
                        metre_kare: metre_kare
                    };
                    yerlesecek_arr.push(newRow);
                });
                let jsonArray = btoa(JSON.stringify(yerlesecek_arr));
                $(".secilen_tapu").attr("data-array", jsonArray);
            });

            setTimeout(function () {
                $("#tarife_click").trigger("click");
                $("#tarife_click123").trigger("click");
                $("#clicker123").trigger("click");
            }, 500);
        });

        $("body").off("focusout", "#yuz_olcumu").on("focusout", "#yuz_olcumu", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("focusout", "#sulama_alani").on("focusout", "#sulama_alani", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("focusout", "#islem_bedeli").on("focusout", "#islem_bedeli", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("click", "#uye_tanim_vazgec").on("click", "#uye_tanim_vazgec", function () {
            $("#uyeyi_guncelle_modal_getir").modal("hide");
        });

        $("body").off("click", "#uye_kaydet_button").on("click", "#uye_kaydet_button", function () {
            let uye_turu = $("#uye_turu").val();
            let tc_no = $("#main_tc_no").val();
            let uye_adi = $("#uye_adi").val();
            let cep_no = $("#cep_no").val();
            let uye_numarasi = $("#uye_numarasi").val();
            let baba_adi = $("#baba_adi").val();
            let il = $("#il").val();
            let dogum_tarihi = $("#dogum_tarihi").val();
            let ilce = $("#ilce").val();
            let adres = $("#adres").val();

            if (tc_no == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen TC Belirtiniz...",
                    "warning"
                );
            } else if (cep_no == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Telefon Numarasını Seçiniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "controller/uye_controller/sql.php?islem=uye_tanimla_sql",
                    type: "POST",
                    data: {
                        uye_turu: uye_turu,
                        tc_no: tc_no,
                        uye_adi: uye_adi,
                        baba_adi: baba_adi,
                        uye_numarasi: uye_numarasi,
                        cep_no: cep_no,
                        dogum_tarihi: dogum_tarihi,
                        il: il,
                        ilce: ilce,
                        adres: adres
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı!",
                                "Üye Kaydedildi",
                                "success"
                            );
                            $("#uyeyi_guncelle_modal_getir").modal("hide");
                            $.get("view/uye_tanim.php", function (getList) {
                                $(".admin-modal-icerik").html(getList);
                            })
                            $.get("view/uye_tanim.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            })
                        } else if (res == 300) {
                            Swal.fire(
                                "Uyarı!",
                                "Bu Üye Zaten Kayıtlı!",
                                "warning"
                            );
                        } else {
                            Swal.fire(
                                "Oops..",
                                "Bilinmeyen Bir Hata Oluştu",
                                "error"
                            );
                        }
                    }
                });
            }
        });
    </script>
    <?php
}
if ($islem == "uye_guncelle_modal") {
    ?>
    <style>
        #uyeyi_guncelle_modal_getir {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="uyeyi_guncelle_modal_getir" data-bs-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 70%; max-width: 70%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="uye_tanim_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ÜYE TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="uye_tapulari"></div>
                            <div class="uye_tarife_tapulari"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Üye Türü</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="uye_turu">
                                                <option value="Üye">Üye</option>
                                                <option value="Üye Değil">Üye Değil</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>TC No:</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="tel" class="form-control form-control-sm"
                                                   id="tc_no" oninput="limitLength(this,11)">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Üye Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="uye_adi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Üye Numarası</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="uye_numarasi">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Cep No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="tel" class="form-control form-control-sm" id="cep_no"
                                                   oninput="limitLength(this,11)">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>İl / İlçe</label>
                                        </div>
                                        <div class="col-md-7 row no-gutters">
                                            <div class="col">
                                                <input type="text" class="form-control form-control-sm" id="il">
                                            </div>
                                            <div class="col">
                                                <input type="text" class="form-control form-control-sm" id="ilce">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Doğum Tarihi</label>
                                        </div>
                                        <div class="col-md-7 ">
                                            <input type="date" class="form-control form-control-sm" id="dogum_tarihi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Baba Adı</label>
                                        </div>
                                        <div class="col-md-7 ">
                                            <input type="text" class="form-control form-control-sm" id="baba_adi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Adres</label>
                                        </div>
                                        <div class="col-md-7">
                                            <textarea class="form-control form-control-sm" id="adres" cols="30" rows="1"
                                                      style="resize: none"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ibox-title" style="background-color: #374f65;color: white;font-size: 18px">
                                <center><span style="font-weight: bold">TAPU BİLGİLERİ</span></center>
                            </div>
                            <div class="col-12 row mt-4">
                                <div class="col-6">
                                    <div class="ibox-title" style="background-color: #9DB2BF;color: white">
                                        <center><span>Taşınmaz Bilgileri</span></center>
                                    </div>
                                    <div class="mt-2"></div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>İl</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="tapu_il">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>İlçe</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="tapu_ilce" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Mahalle/Köy</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="mahalle_koy">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Ada / Parsel</label>
                                        </div>
                                        <div class="col-md-7 row no-gutters">
                                            <div class="col">
                                                <input type="text" placeholder="Ada" id="ada_parsel"
                                                       class="form-control form-control-sm">
                                            </div>
                                            <div class="col">
                                                <input type="text" placeholder="Parsel" id="parsel"
                                                       class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Yüz Ölçümü</label>
                                        </div>
                                        <div class="col-md-7 row no-gutters">
                                            <div class="col">
                                                <input type="text" style="text-align: right" id="yuz_olcumu"
                                                       placeholder="Yüz Ölçümü"
                                                       class="form-control form-control-sm">
                                            </div>
                                            <div class="col">
                                                <input type="text" style="text-align: right" id="sulama_alani"
                                                       placeholder="Sulama Alanı"
                                                       class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Cilt / Sayfa No</label>
                                        </div>
                                        <div class="col-md-7 row no-gutters">
                                            <input type="text" class="form-control form-control-sm" id="guncel_ciltno">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="ibox-title" style="background-color: #9DB2BF;color: white">
                                        <center><span>Tescile İlişkin Bilgiler</span></center>
                                    </div>
                                    <div class="mt-2"></div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Taşınmaz No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="tasinmaz_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Edinme Nedeni</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="edinme_nedeni">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Tescil Trh/Yevmiye</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="tescil_tarihi">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="ibox-title" style="background-color: #9DB2BF;color: white">
                                        <center><span>Malik Bilgileri</span></center>
                                    </div>
                                    <div class="mt-2"></div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Ad Soyad</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="malik_adi" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Baba Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="baba_adi" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="ibox-title" style="background-color: #9DB2BF;color: white">
                                        <center><span>Diğer Bilgiler</span></center>
                                    </div>
                                    <div class="mt-2"></div>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-md-7">
                                        <textarea class="form-control form-control-sm" style="resize: none"
                                                  id="tapu_aciklama"
                                                  rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success btn-sm" id="tapu_ekle"><i class="fa fa-plus"></i>
                                            Tapu Ekle
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row">
                                <div class="ibox-title" style="background-color: #9DB2BF;color: white">
                                    <center><span>Üye'ye Ait Tapular</span></center>
                                </div>
                                <table class="table table-sm table-bordered w-100  nowrap" id="tapu_listesi"
                                       style="font-size: 13px;">
                                    <thead>
                                    <tr>
                                        <th id="tarife_click" style="width: 1% !important;">İl</th>
                                        <th>İlçe</th>
                                        <th>Mahalle/Köy</th>
                                        <th>Ada</th>
                                        <th>Parsel</th>
                                        <th>Yüz Ölçümü</th>
                                        <th>Sulama Alanı</th>
                                        <th>Cilt No</th>
                                        <th>Taşınmaz No</th>
                                        <th>Edinme Nedeni</th>
                                        <th>Tescil Trh.</th>
                                        <th>Ad Soyad</th>
                                        <th>Baba Adı</th>
                                        <th>Açıklama</th>
                                        <th>İşlem</th>
                                    </tr>
                                    </thead>
                                </table>
                                <div class="ibox-title" style="background-color: #374f65;color: white;font-size: 18px">
                                    <center><span style="font-weight: bold">TARİFE BİLGİLERİ</span></center>
                                </div>
                                <div class="mt-3"></div>
                                <div class="col-12 row">
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <label>Tapu</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm"
                                                           id="tapu_id">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-warning btn-sm"
                                                                id="uyeye_ait_tapulari_getir_button"><i
                                                                    class="fa fa-ellipsis-h"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <label>Tarife</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm"
                                                           id="tarife_id">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-warning btn-sm"
                                                                id="tarifeleri_getir_button"><i
                                                                    class="fa fa-ellipsis-h"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <label>MetreKare</label>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" class="form-control form-control-sm" id="metrekare">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success btn-sm" id="tarife_ekle_button"><i
                                                    class="fa fa-plus"></i> Tarife Ekle
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <table class="table table-sm table-bordered w-100  nowrap" id="uye_tarife_listesi"
                                           style="font-size: 13px;">
                                        <thead>
                                        <tr>
                                            <th id="tarife_click123" style="width: 1% !important;">Tapu</th>
                                            <th>Tarife Kodu</th>
                                            <th>Tarife Fiyatı</th>
                                            <th>Metre Kare</th>
                                            <th>İşlem</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="uye_tanim_vazgec"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="uye_kaydet_button"><i class="fa fa-check"></i>
                                Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function limitLength(element, maxLength) {
            if (element.value.length > maxLength) {
                element.value = element.value.slice(0, maxLength);
            }
            element.value = element.value.replace(/\D/g, '');
        }


        $("body").off("focusout", "#uye_adi").on("focusout", "#uye_adi", function () {
            let val = $(this).val();
            $("#malik_adi").val(val);
        })

        $("body").off("click", "#uyeye_ait_tapulari_getir_button").on("click", "#uyeye_ait_tapulari_getir_button", function () {
            let tc_no = $("#tc_no").val();
            $.get("modals/uye_modal/modal.php?islem=tapulari_getir_modal2", {tc_no: tc_no}, function (getModal) {
                $(".uye_tapulari").html(getModal);
            })
        });

        $("body").off("click", "#tarifeleri_getir_button").on("click", "#tarifeleri_getir_button", function () {
            let tc_no = $("#tc_no").val();
            let uye_mi = $("#uye_turu").val();
            $.get("modals/uye_modal/modal.php?islem=tarifeleri_getir_modal", {
                tc_no: tc_no,
                uye_mi: uye_mi
            }, function (getModal) {
                $(".uye_tarife_tapulari").html(getModal);
            })
        });
        var uye_tarifeleri = "";
        $(document).ready(function () {


            $("#uyeyi_guncelle_modal_getir").modal("show");

            uye_tarifeleri = $('#uye_tarife_listesi').DataTable({
                scrollY: '15vh',
                scrollX: true,
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row, data, dataIndex) {
                    $(row).addClass("uye_tarife_selected");
                    $(row).find("td").css("text-align", "left");
                }
            });
            $.get("controller/uye_controller/sql.php?islem=uyenini_tum_tarifelerini_getir_sql", {tc_no: "<?=$_GET["tc_no"]?>"}, function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    uye_tarifeleri.clear().draw(false);
                    json.forEach(function (item) {
                        let m2 = item.sulama_metrekare;
                        m2 = parseFloat(m2);
                        m2 = m2.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                        let tarife_fiyati = item.tarife_fiyati;
                        tarife_fiyati = parseFloat(tarife_fiyati);
                        tarife_fiyati = tarife_fiyati.toLocaleString("tr-TR", {
                            maximumFractionDigits: 2,
                            minimumFractionDigits: 2
                        });
                        uye_tarifeleri.row.add([item.mahalle_koy, item.tarife_kodu, tarife_fiyati, m2, "<button class='btn btn-sm btn-danger tapu_tarife_sil_button'><i class='fa fa-trash'></i></button>"]).draw(false);
                    });
                }
            })

            $.get("controller/uye_controller/sql.php?islem=secilen_uyeleri_getir_sql", {tc: "<?=$_GET["tc_no"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#uye_turu").val(item.abone_mi);
                    $("#tc_no").val(item.tc_no);
                    $("#uye_adi").val(item.uye_adi);
                    $("#baba_adi").val(item.baba_adi);
                    $("#cep_no").val(item.cep_no);
                    $("#il").val(item.il);
                    $("#ilce").val(item.ilce);
                    $("#dogum_tarihi").val(item.dogum_tarihi);
                    $("#uye_numarasi").val(item.uye_numarasi);
                    $("#adres").val(item.adres);
                }
            });

            $.get("controller/uye_controller/sql.php?islem=uyeye_ait_tapulari_getir_sql", {tc_no: "<?=$_GET["tc_no"]?>"}, function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        let yuz_olcumu = item.yuz_olcumu;
                        yuz_olcumu = parseFloat(yuz_olcumu);
                        yuz_olcumu = yuz_olcumu.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        let sulama_alani = item.sulama_alani;
                        sulama_alani = parseFloat(sulama_alani);
                        sulama_alani = sulama_alani.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        tapu_listesi.row.add([item.il, item.ilce, item.mahalle_koy, item.ada, item.parsel, yuz_olcumu, sulama_alani, item.cilt_no, item.tasinmaz_no, item.edinme_nedeni, item.tescil_tarihi, item.ad_soyad, item.baba_adi, item.aciklama, "<button class='btn btn-danger btn-sm tapu-sil-button' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false);
                    });
                }
            })

            $("body").off("click", "#tarife_ekle_button").on("click", "#tarife_ekle_button", function () {
                let tapu_id = $("#tapu_id").attr("data-id");
                let tarife_id = $("#tarife_id").attr("data-id");
                let metre_kare = $("#metrekare").val();
                if (tapu_id == undefined || tapu_id == "") {
                    Swal.fire(
                        "Uyarı!",
                        "Lütfen Bir Tapu Seçiniz...",
                        "warning"
                    );
                } else if (tarife_id == undefined || tarife_id == "") {
                    Swal.fire(
                        "Uyarı!",
                        "Lütfen Bir Tarife Seçiniz...",
                        "warning"
                    );
                } else {
                    $.ajax({
                        url: 'controller/uye_controller/sql.php?islem=tapuya_tarife_ekle_sql',
                        type: "POST",
                        data: {
                            tapu_id: tapu_id,
                            tarife_id: tarife_id,
                            sulama_metrekare: metre_kare,
                            tc_no: "<?=$_GET["tc_no"]?>"
                        },
                        success: function (res) {
                            if (res != 2) {
                                var item = JSON.parse(res);
                                let row = uye_tarifeleri.row.add([item.mahalle_koy, item.tarife_kodu, item.tarife_fiyati, item.sulama_metrekare, '<button class="btn btn-danger btn-sm tapu_tarife_sil_button" data-id="' + item.id + '"><i class="fa fa-trash"></i></button>']).draw(false).node();
                                $(row).attr("data-id", item.id);
                            }
                        }
                    });
                }
            });

            $("body").off("click", ".tapu_tarife_sil_button").on("click", ".tapu_tarife_sil_button", function () {
                let id = $(this).attr("data-id");
                var satir = $(this).closest('tr');

                $.ajax({
                    url: "controller/uye_controller/sql.php?islem=uye_tarifesini_sil_sql",
                    type: "POST",
                    data: {
                        id: id
                    },
                    success: function (res) {
                        if (res == 1) {
                            uye_tarifeleri.row(satir).remove().draw(false);
                        }
                    }
                });
            });

            var tapu_listesi = $('#tapu_listesi').DataTable({
                scrollY: '25vh',
                scrollX: true,
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row, data, dataIndex) {
                    $(row).addClass("tapu_tarife_selected");
                    $(row).find("td").css("text-align", "left");
                }
            });

            $("body").off("click", ".tapu_tarife_selected").on("click", ".tapu_tarife_selected", function () {
                $(".tapu_tarife_selected").removeClass("secilen_tapu")
                $(this).addClass("secilen_tapu")
                let orjinal_veri = $(this).attr("data-array");
                if (orjinal_veri == null || orjinal_veri == undefined) {
                    uye_tarifeleri.clear().draw(false);
                } else {
                    uye_tarifeleri.clear().draw(false);
                    orjinal_veri = JSON.parse(atob(orjinal_veri));
                    orjinal_veri.forEach(function (item) {
                        uye_tarifeleri.row.add([item.tarife_kodu, item.tarife_adi, item.tarife_fiyati, "<input type='text' class='form-control form-control-sm sulama_metrekare' value='" + item.metre_kare + "' style='width: 75%!important;' />"]).draw(false);
                    });
                }
            });

            $("body").off("click", "#tapu_ekle").on("click", "#tapu_ekle", function () {
                let tapu_il = $("#tapu_il").val();
                let tapu_ilce = $("#tapu_ilce").val();
                let mahalle = $("#mahalle_koy").val();
                let ada = $("#ada_parsel").val();
                let parsel = $("#parsel").val();
                let cilt_no = $("#guncel_ciltno").val();
                let yuz_olcumu = $("#yuz_olcumu").val();
                let sulama_alani = $("#sulama_alani").val();
                let tasinmaz_no = $("#tasinmaz_no").val();
                let edinme_nedeni = $("#edinme_nedeni").val();
                let tescil_tarihi = $("#tescil_tarihi").val();
                let ad_soyad = $("#malik_adi").val();
                let baba_adi = $("#baba_adi").val();
                let aciklama = $("#tapu_aciklama").val();
                let main_tc_no = $("#tc_no").val();

                if (main_tc_no == "") {
                    Swal.fire(
                        "Uyarı!",
                        "Lütfen Önce TC Giriniz...",
                        "warning"
                    );
                } else {
                    $.ajax({
                        url: 'controller/uye_controller/sql.php?islem=dummy_tapu_ekle_sql',
                        type: "POST",
                        data: {
                            il: tapu_il,
                            ilce: tapu_ilce,
                            mahalle_koy: mahalle,
                            ada: ada,
                            parsel: parsel,
                            cilt_no: cilt_no,
                            yuz_olcumu: yuz_olcumu,
                            sulama_alani: sulama_alani,
                            tasinmaz_no: tasinmaz_no,
                            edinme_nedeni: edinme_nedeni,
                            tescil_tarihi: tescil_tarihi,
                            ad_soyad: ad_soyad,
                            baba_adi: baba_adi,
                            aciklama: aciklama,
                            tc_no: main_tc_no
                        },
                        success: function (res) {
                            if (res != 500) {
                                let id = res;
                                id = id.split(":");
                                id = id[1];
                                tapu_listesi.row.add([tapu_il, tapu_ilce, mahalle, ada, parsel, yuz_olcumu, sulama_alani, cilt_no, tasinmaz_no, edinme_nedeni, tescil_tarihi, ad_soyad, baba_adi, aciklama, "<button class='btn btn-danger btn-sm tapu-sil-button' data-id='" + id + "'><i class='fa fa-trash'></i></button>"]).draw(false);
                                $("#tapu_il").val("");
                                $("#tapu_ilce").val("");
                                $("#mahalle_koy").val("");
                                $("#ada_parsel").val("");
                                $("#parsel").val("");
                                $("#guncel_ciltno").val("");
                                $("#yuz_olcumu").val("");
                                $("#sulama_alani").val("");
                                $("#tasinmaz_no").val("");
                                $("#edinme_nedeni").val("");
                                $("#tescil_tarihi").val("");
                                $("#malik_adi").val("");
                                $("#baba_adi").val("");
                                $("#tapu_aciklama").val("");
                            }
                        }
                    });
                }
            });
            $("body").off("click", ".tapu-sil-button").on("click", ".tapu-sil-button", function () {
                var satir = $(this).closest('tr');
                let id = $(this).attr("data-id");
                $.ajax({
                    url: 'controller/uye_controller/sql.php?islem=uyeye_ait_tapu_sil_sql',
                    type: "POST",
                    data: {
                        id: id
                    },
                    success: function (res) {
                        if (res == 1) {
                            tapu_listesi.row(satir).remove().draw(false);
                        }
                    }
                });
            });

            $("body").off("click", ".tarife_liste_selected").on("click", ".tarife_liste_selected", function () {
                let tarife_kodu = $(this).find("td").eq(0).text();
                let tarife_adi = $(this).find("td").eq(1).text();
                let tarife_fiyati = $(this).find("td").eq(2).text();
                let varmi = false;

                $(".uye_tarife_selected").each(function () {
                    let tarife_kodu2 = $(this).find("td").eq(0).text();
                    if (tarife_kodu == tarife_kodu2) {
                        varmi = true;
                    }
                });

                let tapu_varmi = false;
                $(".tapu_tarife_selected").each(function () {
                    if ($(this).hasClass("secilen_tapu")) {
                        tapu_varmi = true;
                    }
                })

                if (varmi == true) {
                    Swal.fire(
                        "Uyarı!",
                        "Seçtiğiniz Tarife Listede Mevcuttur...",
                        "warning"
                    );
                } else if (tapu_varmi == false) {
                    Swal.fire(
                        "Uyarı!",
                        "Lütfen Bir Tapu Seçiniz...",
                        "warning"
                    );
                } else {
                    uye_tarifeleri.row.add([tarife_kodu, tarife_adi, tarife_fiyati, "<input type='text' class='form-control form-control-sm sulama_metrekare' style='width: 75%!important;' />"]).draw(false);
                }
            });

            $("body").off("focusout", ".sulama_metrekare").on("focusout", ".sulama_metrekare", function () {
                let yerlesecek_arr = [];
                $(".uye_tarife_selected").each(function () {
                    let tarife_kodu = $(this).find("td").eq(0).text();
                    let tarife_adi = $(this).find("td").eq(1).text();
                    let tarife_fiyati = $(this).find("td").eq(2).text();
                    let metre_kare = $(this).find("td:eq(3) input").val();

                    let newRow = {
                        tarife_kodu: tarife_kodu,
                        tarife_adi: tarife_adi,
                        tarife_fiyati: tarife_fiyati,
                        metre_kare: metre_kare
                    };
                    yerlesecek_arr.push(newRow);
                });
                let jsonArray = btoa(JSON.stringify(yerlesecek_arr));
                $(".secilen_tapu").attr("data-array", jsonArray);
            });

            setTimeout(function () {
                $("#tarife_click").trigger("click");
                $("#tarife_click123").trigger("click");
                $("#clicker123").trigger("click");
            }, 500);
        });

        $("body").off("focusout", "#yuz_olcumu").on("focusout", "#yuz_olcumu", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("focusout", "#sulama_alani").on("focusout", "#sulama_alani", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("focusout", "#islem_bedeli").on("focusout", "#islem_bedeli", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("click", "#uye_tanim_vazgec").on("click", "#uye_tanim_vazgec", function () {
            $("#uyeyi_guncelle_modal_getir").modal("hide");
        });

        $("body").off("click", "#uye_kaydet_button").on("click", "#uye_kaydet_button", function () {
            let uye_turu = $("#uye_turu").val();
            let tc_no = $("#tc_no").val();
            let uye_adi = $("#uye_adi").val();
            let dogum_tarihi = $("#dogum_tarihi").val();
            let uye_numarasi = $("#uye_numarasi").val();
            let baba_adi = $("#baba_adi").val();
            let cep_no = $("#cep_no").val();
            let il = $("#il").val();
            let ilce = $("#ilce").val();
            let adres = $("#adres").val();

            if (tc_no == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen TC Belirtiniz...",
                    "warning"
                );
            } else if (cep_no == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Telefon Numarasını Seçiniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "controller/uye_controller/sql.php?islem=uye_guncelle_sql",
                    type: "POST",
                    data: {
                        uye_turu: uye_turu,
                        tc_no: tc_no,
                        uye_adi: uye_adi,
                        uye_numarasi: uye_numarasi,
                        dogum_tarihi: dogum_tarihi,
                        baba_adi: baba_adi,
                        cep_no: cep_no,
                        il: il,
                        ilce: ilce,
                        adres: adres
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı!",
                                "Üye Kaydedildi",
                                "success"
                            );
                            $("#uyeyi_guncelle_modal_getir").modal("hide");
                            $.get("view/uye_tanim.php", function (getList) {
                                $(".admin-modal-icerik").html(getList);
                            })
                            $.get("view/uye_tanim.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            })
                        } else if (res == 300) {
                            Swal.fire(
                                "Uyarı!",
                                "Bu Üye Zaten Kayıtlı!",
                                "warning"
                            );
                        } else {
                            Swal.fire(
                                "Oops..",
                                "Bilinmeyen Bir Hata Oluştu",
                                "error"
                            );
                        }
                    }
                });
            }
        });
    </script>
    <?php
}
if ($islem == "uyeleri_getir_modal") {
    ?>
    <div class="modal fade" id="fatura_cari_liste_modal_getir"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 80%; max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Üye Listesi
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="fatura_cari_liste">
                            <thead>
                            <tr>
                                <th id="click1">Üye Adı</th>
                                <th>TC No</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        $('input').click(function () {
            $(this).select();
        });

        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#fatura_cari_liste_modal_getir").modal("hide");
        })

        $(document).ready(function () {
            $("#fatura_cari_liste_modal_getir").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 300);
            var table = $('#fatura_cari_liste').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "uye_adi"},
                    {'data': "tc_no"},
                ],
                createdRow: function (row) {
                    $(row).addClass("uye_selected");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            });

            $.get("controller/uye_controller/sql.php?islem=uyeleri_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    table.rows.add(json).draw(false);
                }
            });

            $("body").off("click", ".uye_selected").on("click", ".uye_selected", function () {
                let tc = $(this).find("td").eq(1).text();
                $.get("controller/uye_controller/sql.php?islem=secilen_uyeleri_getir_sql", {tc: tc}, function (res) {
                    if (res != 2) {
                        var item = JSON.parse(res);
                        $("#tc_no").attr("data-id", item.id);
                        $("#tc_no").val(item.tc_no);
                        $("#uye_adi").val(item.uye_adi);
                        $(".selected_user").attr("data-id", item.id);
                        $(".selected_user").val(item.tc_no);
                        $("#fatura_cari_liste_modal_getir").modal("hide");
                    }
                })
            });

        });

    </script>
    <?php
}
if ($islem == "tapulari_getir_modal") {
    ?>
    <div class="modal fade" id="tapulari_getir_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 70%; max-width: 70%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="tarife_secim_vazgec_modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ÜYENİN TAPULARI</div>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12 row">
                                <table class="table table-sm table-bordered w-100  nowrap" id="tapu_listesi"
                                       style="font-size: 13px;">
                                    <thead>
                                    <tr>
                                        <th id="tarife_click" style="width: 1% !important;">İl</th>
                                        <th>İlçe</th>
                                        <th>Mahalle/Köy</th>
                                        <th>Ada</th>
                                        <th>Parsel</th>
                                        <th>Yüz Ölçümü</th>
                                        <th>Sulama Alanı</th>
                                        <th>Cilt No</th>
                                        <th>Taşınmaz No</th>
                                        <th>Edinme Nedeni</th>
                                        <th>Tescil Trh.</th>
                                        <th>Ad Soyad</th>
                                        <th>Baba Adı</th>
                                        <th>Açıklama</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function () {
            $("#tapulari_getir_modal").modal("show");
            var tapu_listesi = $('#tapu_listesi').DataTable({
                scrollY: '25vh',
                scrollX: true,
                "paging": false,
                columns: [
                    {'data': 'il'},
                    {'data': 'ilce'},
                    {'data': 'mahalle_koy'},
                    {'data': 'ada'},
                    {'data': 'parsel'},
                    {'data': 'yuz_olcumu'},
                    {'data': 'sulama_alani'},
                    {'data': 'cilt_no'},
                    {'data': 'tasinmaz_no'},
                    {'data': 'edinme_nedeni'},
                    {'data': 'tescil_tarihi'},
                    {'data': 'ad_soyad'},
                    {'data': 'baba_adi'},
                    {'data': 'aciklama'},
                ],
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row, data, dataIndex) {
                    $(row).addClass("tapu_selected");
                    $(row).attr("data-id", data.id);
                    $(row).find("td").css("text-align", "left");
                }
            });
            setTimeout(function () {
                $("#tarife_click").trigger("click");
            }, 500);

            $.get("controller/uye_controller/sql.php?islem=dummy_tapulari_getir_sql", {tc_no: "<?=$_GET["tc_no"]?>"}, function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    tapu_listesi.rows.add(json).draw(false);
                }
            })

        });

        $("body").off("click", ".tapu_selected").on("click", ".tapu_selected", function () {
            let id = $(this).attr("data-id");
            let tarife_adi = $(this).find("td").eq(2).text();
            let metrekare = $(this).find("td").eq(6).text();
            $("#tapu_id").attr("data-id", id);
            $("#tapu_id").val(tarife_adi);
            $("#metrekare").val(metrekare);
            $("#tapulari_getir_modal").modal("hide");
        });

        $("body").off("click", "#tarife_secim_vazgec_modal").on("click", "#tarife_secim_vazgec_modal", function () {
            $("#tapulari_getir_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "tapulari_getir_modal2") {
    ?>
    <div class="modal fade" id="tapulari_getir_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 70%; max-width: 70%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="tarife_secim_vazgec_modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ÜYENİN TAPULARI</div>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12 row">
                                <table class="table table-sm table-bordered w-100  nowrap" id="tapu_listesi"
                                       style="font-size: 13px;">
                                    <thead>
                                    <tr>
                                        <th id="tarife_click" style="width: 1% !important;">İl</th>
                                        <th>İlçe</th>
                                        <th>Mahalle/Köy</th>
                                        <th>Ada</th>
                                        <th>Parsel</th>
                                        <th>Yüz Ölçümü</th>
                                        <th>Sulama Alanı</th>
                                        <th>Cilt No</th>
                                        <th>Taşınmaz No</th>
                                        <th>Edinme Nedeni</th>
                                        <th>Tescil Trh.</th>
                                        <th>Ad Soyad</th>
                                        <th>Baba Adı</th>
                                        <th>Açıklama</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function () {
            $("#tapulari_getir_modal").modal("show");
            var tapu_listesi = $('#tapu_listesi').DataTable({
                scrollY: '25vh',
                scrollX: true,
                "paging": false,
                columns: [
                    {'data': 'il'},
                    {'data': 'ilce'},
                    {'data': 'mahalle_koy'},
                    {'data': 'ada'},
                    {'data': 'parsel'},
                    {'data': 'yuz_olcumu'},
                    {'data': 'sulama_alani'},
                    {'data': 'cilt_no'},
                    {'data': 'tasinmaz_no'},
                    {'data': 'edinme_nedeni'},
                    {'data': 'tescil_tarihi'},
                    {'data': 'ad_soyad'},
                    {'data': 'baba_adi'},
                    {'data': 'aciklama'},
                ],
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row, data, dataIndex) {
                    $(row).addClass("tapu_selected");
                    $(row).attr("data-id", data.id);
                    $(row).find("td").css("text-align", "left");
                }
            });
            setTimeout(function () {
                $("#tarife_click").trigger("click");
            }, 500);

            $.get("controller/uye_controller/sql.php?islem=dummy_tapulari_getir_sql", {tc_no: "<?=$_GET["tc_no"]?>"}, function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    tapu_listesi.rows.add(json).draw(false);
                }
            })

        });

        $("body").off("click", ".tapu_selected").on("click", ".tapu_selected", function () {
            let id = $(this).attr("data-id");
            let tarife_adi = $(this).find("td").eq(2).text();
            let metrekare = $(this).find("td").eq(6).text();
            metrekare = metrekare.replace(/\./g, "").replace(",", ".");
            metrekare = parseFloat(metrekare);
            $("#tapu_id").attr("data-id", id);
            $("#tapu_id").val(tarife_adi);
            $("#metrekare").val(metrekare);
            $.get("controller/uye_controller/sql.php?islem=tapuya_ait_tarifeleri_getir_sql", {id: id}, function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    uye_tarifeleri.clear().draw(false);
                    json.forEach(function (item) {
                        let m2 = item.sulama_metrekare;
                        m2 = parseFloat(m2);
                        m2 = m2.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                        let tarife_fiyati = item.tarife_fiyati;
                        tarife_fiyati = parseFloat(tarife_fiyati);
                        tarife_fiyati = tarife_fiyati.toLocaleString("tr-TR", {
                            maximumFractionDigits: 2,
                            minimumFractionDigits: 2
                        });
                        uye_tarifeleri.row.add([item.mahalle_koy, item.tarife_kodu, tarife_fiyati, m2, "<button class='btn btn-sm btn-danger tapu_tarife_sil_button'><i class='fa fa-trash'></i></button>"]).draw(false);
                    });
                }
            })
            $("#tapulari_getir_modal").modal("hide");
        });

        $("body").off("click", "#tarife_secim_vazgec_modal").on("click", "#tarife_secim_vazgec_modal", function () {
            $("#tapulari_getir_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "tarifeleri_getir_modal") {
    ?>

    <div class="modal fade" id="tarifeleri_getir_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 70%; max-width: 70%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="tarife_secim_vazgec_modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>TARİFELER</div>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12 row">
                                <table class="table table-sm table-bordered w-100 display nowrap"
                                       style="cursor:pointer;font-size: 13px;"
                                       id="tarife_getir_modal">
                                    <thead>
                                    <tr>
                                        <th id="click1">Tarife Kodu</th>
                                        <th>Tarife Adı</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function () {
            $("#tarifeleri_getir_modal").modal("show");
            //secilen_input
            var table = $('#tarife_getir_modal').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "tarife_kodu"},
                    {'data': "tarife_adi"}
                ],
                createdRow: function (row) {
                    $(row).addClass("tarife_selected");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            });

            $.get("controller/uye_controller/sql.php?islem=tum_tarifeleri_getir_sql", {uye_mi: "<?=$_GET["uye_mi"]?>"}, function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                }
            })

        });

        $("body").off("click", ".tarife_selected").on("click", ".tarife_selected", function () {
            let id = $(this).attr("data-id");
            let tarife_adi = $(this).find("td").eq(1).text();
            $("#tarife_id").val(tarife_adi);
            $("#tarife_id").attr("data-id", id);
            $("#tarifeleri_getir_modal").modal("hide");
        });

        $("body").off("click", "#tarife_secim_vazgec_modal").on("click", "#tarife_secim_vazgec_modal", function () {
            $("#tarifeleri_getir_modal").modal("hide");
        });

    </script>
    <?php
}