<?php

$islem = $_GET["islem"];

if ($islem == "depo_giris_guncelle_modal") {
    ?>
    <style>
        #nakliye_depolama_giris_guncelle_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="nakliye_depolama_giris_guncelle_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 80%; max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="nakliye_depolama_giris_guncelle_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>DEPO KONTEYNER GİRİŞ İŞLEMİ
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="depo_carileri_getir_div"></div>
                            <div class="siparis_icin_aktarma_plaka_getir_div"></div>
                            <div class="konteyner_irasliye_suruculeri_getir_div"></div>
                            <div class="konteyner_irsaliye_ek_hizmetler_getir_div"></div>
                            <div class="depo_giris_carileri_getir_div"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Tarih</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>" id="tarih"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Depo Kodu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="depo_cari_kodu">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="depo_cari_kod_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Depo Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="depo_cari_adi"
                                                   style="font-weight: bold" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Konteyner No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="konteyner_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Firma Kodu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="firma_kodu">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="firma_kodu_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Firma Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="firma_adi"
                                                   style="font-weight: bold" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Konteyner Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="konteyner_tipi">
                                                <option value="">Konteyner Tipi Seçiniz...</option>
                                                <option value="1">20 DC</option>
                                                <option value="2">40 DC</option>
                                                <option value="3">20 OT</option>
                                                <option value="4">40 OT</option>
                                                <option value="5">20 RF</option>
                                                <option value="6">40 RF</option>
                                                <option value="7">40 HC RF</option>
                                                <option value="8">40 HC</option>
                                                <option value="9">20 TANK</option>
                                                <option value="10">20 VENTILATED</option>
                                                <option value="11">40 HC PAL. WIDE</option>
                                                <option value="12">20 FLAT</option>
                                                <option value="13">40 FLAT</option>
                                                <option value="14">40 HC FLAT</option>
                                                <option value="15">20 PLATFORM</option>
                                                <option value="16">40 PLATFORM</option>
                                                <option value="17">45 HC</option>
                                                <option value="18">KARGO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="aciklama">
                                        </div>
                                    </div>
                                    <input type="checkbox" id="surucu_prim_yaz"> <label
                                            style="font-weight: bold" for="surucu_prim_yaz">Sürücüye Prim
                                        Yazılsın</label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Taşıma Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="tasima_tipi">
                                                <option value="">Taşıma Tipi Belirtiniz...</option>
                                                <option value="İHRACAT">İHRACAT</option>
                                                <option value="İTHALAT">İTHALAT</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Plaka</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="plaka_no">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="plakalar_button"><i
                                                                class="fa fa-ellipsis-h"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Araç Cari</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="arac_cari_adi"
                                                   style="font-weight: bold" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Sürücü</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="surucu_id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="irsaliye_icin_suruculeri_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Boş / Dolu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="bos_dolu">
                                                <option value="">Boş Dolu Hizmeti Seçiniz...</option>
                                                <option value="Boş Aktarma">Boş Aktarma</option>
                                                <option value="Dolu Aktarma">Dolu Aktarma</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Ardiye Giriş Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>" id="ardiye_giris_tarih"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>CUT-OFF Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>" id="cutt_off_tarihi"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Demoraj Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>" id="demoraj_tarihi"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Sürücü Prim</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="surucu_prim_getir"
                                                   style="text-align: right">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Araç Kirası</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="arac_kirasi"
                                                   style="text-align: right">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="nakliye_depolama_giris_guncelle_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="depo_konteyner_giris_kaydet_sql"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $("body").off("keyup", "#plaka_no").on("keyup", "#plaka_no", function () {
                let val = $(this).val();
                $.get("konteyner/controller/irsaliye_controller/sql.php?islem=plaka_bilgilerini_getir_sql", {plaka_no: val}, function (result) {
                    if (result != 2) {
                        var item = JSON.parse(result);
                        $("#dorse_id").attr("data-id", item.dorse_id);
                        $("#arac_carisi").val(item.cari_adi);
                        $("#plaka_no").val((item.plaka_no).toUpperCase());
                        if (item.cari_adi != null) {
                            $("#arac_cari_adi").val((item.cari_adi).toUpperCase())
                        }
                        if (item.dorse_plaka != null) {
                            $("#dorse_id").val((item.dorse_plaka).toUpperCase());
                        }
                        if (item.surucu_adi != null) {
                            $("#surucu_id").val((item.surucu_adi).toUpperCase());
                        }
                        $("#plaka_no").attr("data-id", item.id);
                        $("#surucu_tel").val(item.surucu_tel);
                        $("#surucu_id").attr("data-id", item.surucu_id);

                        if (item.arac_grubu == "Kiralık") {
                            $("#surucu_prim_getir").val("0,00");
                            $("#surucu_prim_getir").prop("disabled", true);
                            $("#arac_kirasi").prop("disabled", false);
                        } else if (item.arac_grubu == "Öz Mal") {
                            $("#surucu_prim_getir").prop("disabled", false);
                            $("#arac_kirasi").prop("disabled", true);
                            $("#arac_kirasi").val("0,00");
                        } else {
                            $("#arac_kirasi").prop("disabled", false);
                            $("#yol_primi").prop("disabled", false);
                        }

                    } else {
                        $("#dorse_id").attr("data-id", "");
                        $("#plaka_id").attr("data-id", "");
                        $("#arac_kirasi").prop("disabled", false);
                        $("#surucu_prim_getir").prop("disabled", false);
                        $("#dorse_id").val("");
                        $("#surucu_tel").val("");
                        $("#arac_cari_adi").val("")
                        $("#surucu_id").val("");
                        $("#surucu_id").attr("data-id", "");
                    }
                })
            });

            $("body").off("click", "#irsaliye_icin_suruculeri_getir_button").on("click", "#irsaliye_icin_suruculeri_getir_button", function () {
                $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=irsaliye_icin_suruculeri_getir", function (getModal) {
                    $(".konteyner_irasliye_suruculeri_getir_div").html("");
                    $(".konteyner_irasliye_suruculeri_getir_div").html(getModal);
                });
            });

            $("body").off("click", "#depo_konteyner_giris_kaydet_sql").on("click", "#depo_konteyner_giris_kaydet_sql", function () {
                let tarih = $("#tarih").val();
                let depo_id = $("#depo_cari_kodu").attr("data-id");
                let konteyner_no = $("#konteyner_no").val();
                let bos_dolu = $("#bos_dolu").val();
                let aciklama = $("#aciklama").val();
                let surucu_adi = $("#surucu_id").val();
                let surucu_id = $("#surucu_id").attr("data-id");
                let firma_id = $("#firma_kodu").attr("data-id");
                let konteyner_tipi = $("#konteyner_tipi").val();
                let surucu_primi = 0;
                if ($("#surucu_prim_yaz").prop("checked")) {
                    surucu_primi = 1;
                } else {
                    surucu_primi = 2;
                }
                let tasima_tipi = $("#tasima_tipi").val();
                let plaka = $("#plaka_no").attr("data-id");
                let ardiye_giris_tarih = $("#ardiye_giris_tarih").val();
                let cutt_off_tarihi = $("#cutt_off_tarihi").val();
                let demoraj_tarihi = $("#demoraj_tarihi").val();
                let surucu_prim_getir = $("#surucu_prim_getir").val();
                surucu_prim_getir = surucu_prim_getir.replace(/\./g, "").replace(",", ".");
                surucu_prim_getir = parseFloat(surucu_prim_getir);
                let arac_kirasi = $("#arac_kirasi").val();
                arac_kirasi = arac_kirasi.replace(/\./g, "").replace(",", ".");
                arac_kirasi = parseFloat(arac_kirasi);
                let konteyner_irsaliye_id = $("#konteyner_no").attr("konteyner_id");
                let konteyner_siparis_id = $("#konteyner_no").attr("siparis_id");

                if (depo_id == undefined || depo_id == "") {
                    Swal.fire(
                        "Uyarı!",
                        "Lütfen Bir Depo Carisi Belirtiniz...",
                        "warning"
                    )
                } else if (firma_id == undefined || firma_id == "") {
                    Swal.fire(
                        "Uyarı!",
                        "Lütfen Bir Firma Belirtiniz...",
                        "warning"
                    );
                } else if (plaka == undefined || plaka == "") {
                    Swal.fire(
                        "Uyarı!",
                        "Lütfen Bir Plaka Belirtiniz...",
                        "warning"
                    );
                } else if (bos_dolu == "") {
                    Swal.fire(
                        "Uyarı!",
                        'Lütfen Boş Dolu Tipi Seçiniz...',
                        'warning'
                    );
                } else if (konteyner_no == "") {
                    Swal.fire(
                        "Uyarı!",
                        "Lütfen Konteyner No Giriniz...",
                        "warning"
                    );
                } else if (konteyner_tipi == "") {
                    Swal.fire(
                        "Uyarı!",
                        "Lütfen Konteyner Tipi Seçiniz...",
                        "warning"
                    );
                } else if (tasima_tipi == "") {
                    Swal.fire(
                        "Uyarı!",
                        "Lütfen Taşıma Tipi Seçiniz...",
                        "warning"
                    );
                } else {
                    $.ajax({
                        url: "depo/controller/nakliye_controller/sql.php?islem=depo_konteyner_girisi_guncelle_sql",
                        type: "POST",
                        data: {
                            tarih: tarih,
                            surucu_id: surucu_id,
                            surucu_adi: surucu_adi,
                            konteyner_no: konteyner_no,
                            konteyner_irsaliye_id: konteyner_irsaliye_id,
                            konteyner_siparis_id: konteyner_siparis_id,
                            konteyner_tipi: konteyner_tipi,
                            prim_yazilsin: surucu_primi,
                            depo_cari_id: depo_id,
                            firma_cari_id: firma_id,
                            tasima_tipi: tasima_tipi,
                            id: "<?=$_GET["id"]?>",
                            plaka_id: plaka,
                            bos_dolu: bos_dolu,
                            ardiye_giris_tarih: ardiye_giris_tarih,
                            cutt_off_tarihi: cutt_off_tarihi,
                            demoraj_tarihi: demoraj_tarihi,
                            aciklama: aciklama,
                            surucu_prim: surucu_prim_getir,
                            arac_kirasi: arac_kirasi
                        },
                        success: function (res) {
                            if (res == 1) {
                                Swal.fire(
                                    "Başarılı",
                                    "Depo Giriş Başarı İle Güncellendi",
                                    "success"
                                );
                                $("#nakliye_depolama_giris_guncelle_modal").modal("hide");
                                $.get("depo/view/nakliye_depolama_islemleri.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                });
                                $.get("depo/view/nakliye_depolama_islemleri.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                });
                            } else if (res == 300) {
                                Swal.fire(
                                    "Uyarı!",
                                    "Bu Konteyner Depoda Mevcut",
                                    "warning"
                                );
                            }
                        }
                    })
                }
            });


            $("body").off("focusout", "#arac_kirasi").on("focusout", "#arac_kirasi", function () {
                let val = $(this).val();
                val = val.replace(/\./g, "").replace(",", ".");
                val = parseFloat(val);
                if (isNaN(val)) {
                    val = 0;
                }
                $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
            });


            $("body").off("focusout", "#surucu_prim_getir").on("focusout", "#surucu_prim_getir", function () {
                let val = $(this).val();
                val = val.replace(/\./g, "").replace(",", ".");
                val = parseFloat(val);
                if (isNaN(val)) {
                    val = 0;
                }
                $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
            });

            $("body").off("keyup", "#konteyner_no").on("keyup", "#konteyner_no", function () {
                let val = $(this).val();
                $.get("depo/controller/nakliye_controller/sql.php?islem=konteyner_irsaliye_bilgisi_cek", {konteyner_no: val}, function (res) {
                    if (res != 2) {
                        var item = JSON.parse(res);
                        $("#firma_kodu").attr("data-id", item.cari_id);
                        $("#firma_kodu").val(item.cari_kodu);
                        $("#firma_adi").val((item.cari_adi).toUpperCase());
                        $("#konteyner_tipi").val(item.konteyner_tipi);
                        $("#tasima_tipi").val(item.tipi);
                        $("#plaka_no").val(item.plaka_no);
                        $("#plaka_no").attr("data-id", item.plaka_id);
                        $("#arac_cari_adi").val(item.arac_cari);

                        if ("konteyner_no1" in item) {
                            $("#konteyner_no").attr("konteyner_id", item.id)
                        } else {
                            $("#konteyner_no").attr("siparis_id", item.id)
                        }
                    } else {
                        $("#firma_kodu,#plaka_no").attr("data-id", "");
                        $("#firma_kodu,#firma_adi,#tasima_tipi,#konteyner_tipi,#plaka_no,#arac_cari_adi").val("");
                    }
                })
            });

            $(document).ready(function () {
                $("#nakliye_depolama_giris_guncelle_modal").modal("show");

                $.get("depo/controller/nakliye_controller/sql.php?islem=depo_giris_bilgileri_getir_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                    if (res != 2) {
                        var item = JSON.parse(res);
                        let tarih = item.tarih;
                        tarih = tarih.split(" ");
                        $("#tarih").val(tarih[0]);
                        $("#depo_cari_kodu").val(item.depo_adi);
                        $("#aciklama").val(item.aciklama);
                        $("#depo_cari_kodu").attr("data-id", item.depo_cari_id);
                        $("#depo_cari_adi").val(item.depo_kodu);
                        $("#konteyner_no").val(item.konteyner_no);
                        $("#firma_kodu").val(item.firma_kodu);
                        $("#firma_kodu").attr("data-id", item.firma_cari_id);
                        $("#firma_adi").val(item.firma_adi);
                        $("#konteyner_tipi").val(item.konteyner_tipi);
                        $("#tasima_tipi").val(item.tasima_tipi);
                        $("#plaka_no").val(item.plaka_no)
                        $("#plaka_no").attr("data-id", item.plaka_id);
                        $("#arac_cari_adi").val(item.arac_cari)
                        $("#surucu_id").val(item.surucu_adi)
                        $("#surucu_id").attr("data-id",item.surucu_id)
                        $("#bos_dolu").val(item.bos_dolu);
                        let ardiye_giris = item.ardiye_giris_tarih;
                        ardiye_giris = ardiye_giris.split(" ");
                        ardiye_giris = ardiye_giris[0];
                        $("#ardiye_giris_tarih").val(ardiye_giris);
                        let cutt_off = item.cutt_off_tarihi;
                        cutt_off = cutt_off.split(" ");
                        cutt_off = cutt_off[0];
                        $("#cutt_off_tarihi").val(cutt_off);
                        let demoraj_tarihi = item.demoraj_tarihi;
                        demoraj_tarihi = demoraj_tarihi.split(" ");
                        demoraj_tarihi = demoraj_tarihi[0];
                        $("#demoraj_tarihi").val(demoraj_tarihi);
                        let prim = item.surucu_prim;
                        prim = parseFloat(prim);
                        prim = prim.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                        $("#surucu_prim_getir").val(prim);
                        let arac_kirasi = item.arac_kirasi;
                        arac_kirasi = parseFloat(arac_kirasi);
                        arac_kirasi = arac_kirasi.toLocaleString("tr-TR", {
                            maximumFractionDigits: 2,
                            minimumFractionDigits: 2
                        });
                        $("#arac_kirasi").val(arac_kirasi);

                        if (item.prim_yazilsin == 2) {

                        } else {
                            $("#surucu_prim_yaz").prop("checked", true);
                        }
                    }
                })
            });

            $("body").off("click", "#nakliye_depolama_giris_guncelle_modal_kapat").on("click", "#nakliye_depolama_giris_guncelle_modal_kapat", function () {
                $("#nakliye_depolama_giris_guncelle_modal").modal("hide");
            })

            $("body").off("click", "#depo_cari_kod_button").on("click", "#depo_cari_kod_button", function () {
                $.get("depo/modals/nakliye_depolama_modal/nakliye_depolama.php?islem=depo_carileri_getir", function (getModal) {
                    $(".depo_carileri_getir_div").html("");
                    $(".depo_carileri_getir_div").html(getModal);
                })
            })


            $("body").off("click", "#firma_kodu_button").on("click", "#firma_kodu_button", function () {
                $.get("depo/modals/nakliye_depolama_modal/nakliye_depolama.php?islem=nakliye_giris_carileri_getir", function (getModal) {
                    $(".depo_giris_carileri_getir_div").html("");
                    $(".depo_giris_carileri_getir_div").html(getModal);
                })
            })


            $("body").off("click", "#plakalar_button").on("click", "#plakalar_button", function () {
                $.get("konteyner/modals/sefer_modal/siparis_olustur.php?islem=konteyner_icin_plakalari_getir", function (getModal) {
                    $(".siparis_icin_aktarma_plaka_getir_div").html("");
                    $(".siparis_icin_aktarma_plaka_getir_div").html(getModal);
                })
            })

            $("body").off("click", "#ek_hizmet_kodu_getir_button").on("click", "#ek_hizmet_kodu_getir_button", function () {
                $.get("depo/modals/nakliye_depolama_modal/depo_cikis_page.php?islem=ek_hizmetleri_getir", function (getModal) {
                    $(".konteyner_irsaliye_ek_hizmetler_getir_div").html("");
                    $(".konteyner_irsaliye_ek_hizmetler_getir_div").html(getModal);
                });
            });


        </script>
    </div>
    <?php
}