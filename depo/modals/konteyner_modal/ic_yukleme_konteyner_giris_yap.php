<?php

$islem = $_GET["islem"];

if ($islem == "konteyner_girisi_yap_modal") {
    ?>
    <style>
        #konteyner_ic_yukleme_giris_yap_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="konteyner_ic_yukleme_giris_yap_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="konteyner_ic_yukleme_giris_yap_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>KONTEYNER İÇ YÜKLEME GİRİŞ
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="konteyner_irasliye_suruculeri_getir_div"></div>
                            <div class="tanimli_konteynerleri_getir_div"></div>
                            <div class="konteyner_irsaliye_guzergahlari_getir_div"></div>
                            <div class="konteyner_irasliye_plakalari_getir_div"></div>
                            <div id="carileri_getir_irsaliye"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Konteyner No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="konteyner_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>İş Emri</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="epro_ref">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="is_emirlerini_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Güzergah</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="guzergah_kodu">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="konteyner_irsaliye_guzergahlar_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Giriş Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" class="form-control form-control-sm" id="giris_tarihi"
                                                   value="<?= date("Y-m-d") ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Referans</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="referans_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Beyanname No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="beyanname_no">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Konteyner Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="konteyner_tipi">
                                                <option value="">Konteyner Tipi</option>
                                                <option value="40 HC">40 HC</option>
                                                <option value="20 DC">20 DC</option>
                                                <option value="40 DC">40 DC</option>
                                                <option value="20 OT">20 OT</option>
                                                <option value="40 OT">40 OT</option>
                                                <option value="20 RF">20 RF</option>
                                                <option value="40 RF">40 RF</option>
                                                <option value="40 HC RF">40 HC RF</option>
                                                <option value="20 TANK">20 TANK</option>
                                                <option value="20 VENTILATED">20 VENTILATED</option>
                                                <option value="40 HC PAL. WIDE">40 HC PAL. WIDE</option>
                                                <option value="20 FLAT">20 FLAT</option>
                                                <option value="40 FLAT">40 FLAT</option>
                                                <option value="40 HC FLAT">40 HC FLAT</option>
                                                <option value="20 PLATFORM">20 PLATFORM</option>
                                                <option value="40 PLATFORM">40 PLATFORM</option>
                                                <option value="45 HC">45 HC</option>
                                                <option value="KARGO">KARGO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="tipi">
                                                <option value="İHRACAT">İHRACAT</option>
                                                <option value="İTHALAT">İTHALAT</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Boş / Dolu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="bos_dolu">
                                                <option value="Boş">Boş</option>
                                                <option value="Dolu">Dolu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Plaka No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="plaka_id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="irsaliye_plakalari_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Sürücü Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="surucu_id">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="irsaliye_icin_suruculeri_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Plaka Cari</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="arac_cari_adi"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Araç Kirası</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   style="text-align: right" value="0,00" id="arac_kirasi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Sürücü Prim</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   style="text-align: right" value="0,00" id="surucu_prim">
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
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Sahaya Serilsin</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="sahaya_ser">
                                                <option value="2">Serilmesin</option>
                                                <option value="1">Serilsin</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="konteyner_ic_yukleme_giris_yap_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="ic_yukleme_kont_giris_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>


        $("body").off("click", "#cari_getir_modal_irsaliye").on("click", "#cari_getir_modal_irsaliye", function () {
            $.get("modals/alis_modal/alis_irsaliye_page.php?islem=irsaliye_icin_carileri_getir", function (getModal) {
                $("#carileri_getir_irsaliye").html("");
                $("#carileri_getir_irsaliye").html(getModal);
            })
        });


        $(document).ready(function () {
            $("#konteyner_ic_yukleme_giris_yap_modal").modal("show");
        });


        $("body").off("click", "#irsaliye_plakalari_getir_button").on("click", "#irsaliye_plakalari_getir_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=irsaliye_plakalari_getir", function (getModal) {
                $(".konteyner_irasliye_plakalari_getir_div").html("");
                $(".konteyner_irasliye_plakalari_getir_div").html(getModal);
            });
        });

        $("body").off("click", "#is_emirlerini_getir_button").on("click", "#is_emirlerini_getir_button", function () {
            $.get("depo/modals/konteyner_modal/ic_yukleme_konteyner_giris_yap.php?islem=is_emirlerini_getir_sql", function (getModal) {
                $("#carileri_getir_irsaliye").html(getModal);
            })
        });

        $("body").off("focusout", "#arac_kirasi").on("focusout", "#arac_kirasi", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });

        $("body").off("focusout", "#surucu_prim").on("focusout", "#surucu_prim", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });

        $("body").off("click", "#ic_yukleme_kont_giris_button").on("click", "#ic_yukleme_kont_giris_button", function () {
            let konteyner_no = $("#konteyner_no").val();
            let epro_ref = $("#epro_ref").val();
            let is_emri_id = $("#epro_ref").attr("data-id");
            let guzergah_id = $("#guzergah_kodu").attr("data-id");
            let giris_tarihi = $("#giris_tarihi").val();
            let referans = $("#referans_no").val();
            let beyanname_no = $("#beyanname_no").val();
            let konteyner_tipi = $("#konteyner_tipi").val();
            let tipi = $("#tipi").val();
            let sahaya_ser = $("#sahaya_ser").val();
            let bos_dolu = $("#bos_dolu").val();
            let plaka_id = $("#plaka_id").attr("data-id");
            let plaka_no = $("#plaka_id").val();
            let surucu_id = $("#surucu_id").attr("data-id");
            let surucu_adi = $("#surucu_adi").val();
            let arac_kirasi = $("#arac_kirasi").val();
            arac_kirasi = arac_kirasi.replace(/\./g, "").replace(",", ".");
            arac_kirasi = parseFloat(arac_kirasi);
            let surucu_prim = $("#surucu_prim").val();
            surucu_prim = surucu_prim.replace(/\./g, "").replace(",", ".");
            surucu_prim = parseFloat(surucu_prim);
            let aciklama = $("#aciklama").val();

            if (konteyner_no == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Konteyner Numarası Giriniz...",
                    "warning"
                );
            } else if (guzergah_id == "" || guzergah_id == undefined) {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Güzergah Giriniz...",
                    "warning"
                );
            } else if (is_emri_id == undefined || is_emri_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir İş Emri Seçiniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "depo/controller/konteyner_controller/sql.php?islem=ic_yukleme_konteyner_girisi",
                    type: "POST",
                    data: {
                        konteyner_no: konteyner_no,
                        epro_ref: epro_ref,
                        is_emri_id: is_emri_id,
                        guzergah_id: guzergah_id,
                        giris_tarihi: giris_tarihi,
                        referans: referans,
                        sahaya_ser: sahaya_ser,
                        beyanname_no: beyanname_no,
                        konteyner_tipi: konteyner_tipi,
                        tipi: tipi,
                        bos_dolu: bos_dolu,
                        plaka_id: plaka_id,
                        plaka_no: plaka_no,
                        surucu_id: surucu_id,
                        surucu_adi: surucu_adi,
                        arac_kirasi: arac_kirasi,
                        surucu_prim: surucu_prim,
                        aciklama: aciklama
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Konteyner Kaydedildi...",
                                "success"
                            );
                            $.get("depo/view/konteyner_ic_yukleme_girisi.php", function (getList) {
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/konteyner_ic_yukleme_girisi.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            });
                            $("#konteyner_ic_yukleme_giris_yap_modal").modal("hide");
                        }
                    }
                });
            }

        });

        $("body").off("keyup", "#plaka_id").on("keyup", "#plaka_id", function () {
            let val = $(this).val();
            $.get("konteyner/controller/irsaliye_controller/sql.php?islem=plaka_bilgilerini_getir_sql", {plaka_no: val}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#dorse_id").attr("data-id", item.dorse_id);
                    $("#plaka_id").val((item.plaka_no).toUpperCase());
                    if (item.cari_adi != null) {
                        $("#arac_cari_adi").val((item.cari_adi).toUpperCase());
                    }
                    if (item.dorse_plaka != null) {
                        $("#dorse_id").val((item.dorse_plaka).toUpperCase());
                    }
                    if (item.surucu_adi != null) {
                        $("#surucu_id").val((item.surucu_adi).toUpperCase());
                    }
                    $("#plaka_id").attr("data-id", item.id);
                    $("#surucu_tel").val(item.surucu_tel);
                    $("#surucu_id").attr("data-id", item.surucu_id);

                    if (item.arac_grubu == "Kiralık") {
                        $("#surucu_prim").val("0,00");
                        $("#surucu_prim").prop("disabled", true);
                        $("#arac_kirasi").prop("disabled", false);
                    } else if (item.arac_grubu == "Öz Mal") {
                        $("#surucu_prim").prop("disabled", false);
                        $("#arac_kirasi").prop("disabled", true);
                        $("#arac_kirasi").val("0,00");
                    } else {
                        $("#arac_kirasi").prop("disabled", false);
                        $("#surucu_prim").prop("disabled", false);
                    }

                } else {
                    $("#dorse_id").attr("data-id", "");
                    $("#plaka_id").attr("data-id", "");
                    $("#arac_kirasi").prop("disabled", false);
                    $("#surucu_prim").prop("disabled", false);
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

        $("body").off("click", "#tanimli_konteynerleri_getir_button").on("click", "#tanimli_konteynerleri_getir_button", function () {
            $.get("depo/modals/konteyner_modal/konteyner_giris.php?islem=tanimli_konteynerleri_getir_modal", function (getModal) {
                $(".tanimli_konteynerleri_getir_div").html("");
                $(".tanimli_konteynerleri_getir_div").html(getModal);
            });
        });

        $("body").off("click", "#konteyner_ic_yukleme_giris_yap_modal_kapat").on("click", "#konteyner_ic_yukleme_giris_yap_modal_kapat", function () {
            $("#konteyner_ic_yukleme_giris_yap_modal").modal("hide");
        });

        $("body").off("click", "#konteyner_irsaliye_guzergahlar_button").on("click", "#konteyner_irsaliye_guzergahlar_button", function () {
            $.get("konteyner/modals/sefer_modal/irsaliye_islemleri.php?islem=konteyner_irsaliye_guzergahlarini_getir", function (getModal) {
                $(".konteyner_irsaliye_guzergahlari_getir_div").html("");
                $(".konteyner_irsaliye_guzergahlari_getir_div").html(getModal);
            });
        });

    </script>
    <?php
}
if ($islem == "is_emirlerini_getir_sql") {
    ?>
    <div class="modal fade" id="depo_siparisleri_getir_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="depo_siparisleri_getir_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>SİPARİŞLER</div>
                        </div>
                        <div class="modal-body">
                            <table class="table table-sm table-bordered w-100 display nowrap"
                                   style="cursor:pointer;font-size: 13px;"
                                   id="is_emri_depo_siparsileri_table_list">
                                <thead>
                                <tr>
                                    <th id="click1">Acenta</th>
                                    <th>Referans</th>
                                    <th>Beyanname No</th>
                                    <th>Sipariş Tarihi</th>
                                    <th>CUT - OFF Tarihi</th>
                                    <th>Ardiyesiz Giriş</th>
                                    <th>Demoraj Tarihi</th>
                                    <th>Alım Yeri</th>
                                    <th>Epro Ref.</th>
                                    <th>Tipi</th>
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
    <script>

        $(document).ready(function () {
            $("#depo_siparisleri_getir_modal").modal("show");

            setTimeout(function () {
                $("#click1").trigger("click");
            }, 500);

            var table = $('#is_emri_depo_siparsileri_table_list').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "acente"},
                    {'data': "acente_ref"},
                    {'data': "beyanname_no"},
                    {'data': "siparis_tarihi"},
                    {'data': "cut_of_tarihi"},
                    {'data': "ardiyesiz_giris_tarihi"},
                    {'data': "demoraj_tarihi"},
                    {'data': "alim_yeri"},
                    {'data': "epro_ref"},
                    {'data': "tipi"},
                    {'data': "aciklama"}
                ],
                createdRow: function (row, data) {
                    $(row).addClass("depo_siparis_selected");
                    $(row).find('td').css('text-align', 'left');
                    $(row).attr("data-id", data.id);
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $.get("depo/controller/ihracat_controller/sql.php?islem=tum_siparisleri_getir2", {
                cari_id: "<?=$_GET["cari_id"]?>",
                modul: "<?=$_GET["modul"]?>"
            }, function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                }
            })
        });

        $("body").off("click", ".depo_siparis_selected").on("click", ".depo_siparis_selected", function () {
            let id = $(this).attr("data-id");
            let tipi = $(this).find("td").eq(9).text();
            $("#tipi").val(tipi);
            if (tipi == "İHRACAT") {
                $.get("depo/controller/ihracat_controller/sql.php?islem=guncellenecek_siparis_ana_bilgi1", {id: id}, function (res) {
                    if (res != 2) {
                        var item = JSON.parse(res);
                        $("#cari_id").val(item.cari_adi);
                        $("#cari_id").attr("data-id", item.cari_id);
                        $("#firma_unvan").val(item.cari_adi);
                        $("#vergi_dairesi").val(item.vergi_dairesi);
                        $("#vergi_no").val(item.vergi_no);
                        $("#adres").val(item.adres);
                        $("#bos_dolu").val("Boş");
                        $("#referans_no").val(item.acente_ref);
                        $("#konteyner_tipi").val(item.konteyner_tipi);
                        $("#beyanname_no").val(item.beyanname_no);
                        $("#epro_ref").val(item.epro_ref);
                        $("#epro_ref").attr("data-id", id);
                        $("#siparis_ep_ref").val(item.epro_ref);
                        $("#siparis_ep_ref").attr("data-id", id);
                        $("#acenta").val(item.acente);
                        $("#alim_yeri").val(item.alim_yeri);
                        $("#fabrika_ref").val(item.fabrika_ref);
                        $("#mal_kodu").attr("data-id", item.mal_id);
                        $("#mal_kodu").val(item.urun_adi);
                        $("#birim_id").val(item.birim_id);
                    }
                })
            } else {
                $.get("depo/controller/ithalat_controller/sql.php?islem=guncellenecek_siparis_ana_bilgi1", {id: id}, function (res) {
                    if (res != 2) {
                        var item = JSON.parse(res);
                        $("#cari_id").val(item.cari_adi);
                        $("#bos_dolu").val("Dolu");
                        $("#cari_id").attr("data-id", item.cari_id);
                        $("#konteyner_tipi").val(item.konteyner_tipi);
                        $("#beyanname_no").val(item.beyanname_no);
                        $("#referans_no").val(item.acente_ref);
                        $("#epro_ref").val(item.epro_ref);
                        $("#epro_ref").attr("data-id", id);
                        $("#siparis_ep_ref").val(item.epro_ref);
                        $("#siparis_ep_ref").attr("data-id", id);
                        $("#fabrika_ref").val(item.fabrika_ref);
                        $("#alim_yeri").val(item.alim_yeri);
                        $("#mal_kodu").attr("data-id", item.mal_id);
                        $("#mal_kodu").val(item.urun_adi);
                        $("#birim_id").val(item.birim_id);
                    }
                })
            }
            $("#depo_siparisleri_getir_modal").modal("hide");
        });

        $("body").off("click", "#depo_siparisleri_getir_modal_kapat").on("click", "#depo_siparisleri_getir_modal_kapat", function () {
            $("#depo_siparisleri_getir_modal").modal("hide");
        });

    </script>
    <?php
}