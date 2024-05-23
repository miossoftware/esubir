<?php

$islem = $_GET["islem"];

if ($islem == "konteyner_estimate_ekle_modal") {
    ?>
    <style>
        #estimate_konteyner_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="estimate_konteyner_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="estimate_konteyner_modal_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>KONTEYNER ESTİMATE</div>
                        </div>
                        <div class="modal-body">
                            <div class="giris-yapmis-konteynerler"></div>
                            <div class="col-12 row">
                                <div class="ibox-title" style="background-color: #9DB2BF;color: white">
                                    <span>KONTEYNER BİLGİLERİ</span>
                                </div>
                                <div class="mt-2"></div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Konteyner No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="konteyner_no">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="giris_yapmis_konteynerler"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Acente Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="acente_adi"
                                                   disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Hasar Açıklaması</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="hasar_aciklamasi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Konteyner Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="konteyner_tipi"
                                                   disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="no-gutters row">
                                <div class="ibox-title" style="background-color: #9DB2BF;color: white">
                                    <span>İŞLEM BİLGİLERİ</span>
                                </div>
                                <div class="mt-2 mx-2"></div>
                                <div class="col">
                                    <input type="date" class="form-control form-control-sm" id="islem_tarihi"
                                           value="<?= date("Y-m-d") ?>">
                                </div>
                                <div class="col mx-2">
                                    <input type="text" class="form-control form-control-sm"
                                           placeholder="Uygulanan İşlem" id="uygulanan_islem">
                                </div>
                                <div class="col mx-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="Fiyat"
                                           id="fiyat"
                                           style="text-align: right">
                                </div>
                                <div class="col mx-2">
                                    <input type="text" class="form-control form-control-sm" id="aciklama"
                                           placeholder="Açıklama">
                                </div>
                                <div class="col mx-2">
                                    <button class="btn btn-success btn-sm" id="konteyner_hizmeti_ekle"><i
                                                class="fa fa-plus"></i> Ekle
                                    </button>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <table class="table table-sm table-bordered w-100 display nowrap"
                                       style="cursor:pointer;font-size: 13px;"
                                       id="konteyner_eklenen_hizmetler_listesi">
                                    <thead>
                                    <tr>
                                        <th style="width: 0% !important;">Tarih</th>
                                        <th id="istasyonclick">Uygulanan İşlem</th>
                                        <th>İşlem Ücreti</th>
                                        <th>Açıklama</th>
                                        <th>İşlem</th>
                                    </tr>
                                    </thead>
                                    <tfoot style="background-color: white">
                                    <th>Toplam Tutar:</th>
                                    <th style="text-align: right" class="toplam_islem_tutari">0,00</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="estimate_konteyner_modal_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="estimate_listesini_kaydet_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var hizmet_table = "";
        $(document).ready(function () {
            $("#estimate_konteyner_modal").modal("show");
            hizmet_table = $("#konteyner_eklenen_hizmetler_listesi").DataTable({
                scrollY: '40vh',
                scrollX: true,
                "info": false,
                "order": [[0, 'desc']],
                autoWidth: false,
                columnDefs: [
                    {targets: 0, type: "date-eu"}
                ],
                createdRow: function (new_row) {
                    $(new_row).addClass("konteyner_estimate_listesi");
                    $(new_row).find('td').css('text-align', 'left');
                    $(new_row).find("td").eq(2).css("text-align", "right");
                    $(new_row).find("td").eq(4).css("text-align", "right");
                    $(new_row).find("td").eq(5).css("text-align", "right");
                    $(new_row).find("td").eq(6).css("text-align", "right");
                    $(new_row).find("td").eq(7).css("text-align", "right");
                },
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
            });

            setTimeout(function () {
                $("#istasyonclick").trigger("click");
            }, 500);
        });
        $("input").click(function () {
            $(this).select();
        })

        $("body").off("click", "#konteyner_hizmeti_ekle").on("click", "#konteyner_hizmeti_ekle", function () {
            let tarih = $("#islem_tarihi").val();
            let uygulanan_islem = $("#uygulanan_islem").val();
            let fiyat = $("#fiyat").val();
            let aciklama = $("#aciklama").val();
            if (tarih != "") {
                tarih = tarih.split("-");
                let g = tarih[2];
                let a = tarih[1];
                let y = tarih[0];
                let arr = [g, a, y];
                tarih = arr.join("/");
                hizmet_table.row.add([tarih, uygulanan_islem, "<input type='text' class='form-control form-control-sm col-9 list_fiyat' style='width: 70% !important;text-align: right' value='" + fiyat + "'/>", aciklama, "<button class='btn btn-danger btn-sm delete_row'><i class='fa fa-trash'></i></button>"]).draw(false);
                let toplam_tutar = 0;
                $(".konteyner_estimate_listesi").each(function () {
                    let val = $(this).find("td:eq(2) input").val();
                    val = val.replace(/\./g, "").replace(",", ".");
                    val = parseFloat(val);
                    toplam_tutar += val;
                });
                toplam_tutar = parseFloat(toplam_tutar);
                toplam_tutar = toplam_tutar.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                });
                $(".toplam_islem_tutari").html(toplam_tutar);
            } else {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Tarih Giriniz...",
                    "warning"
                );
            }
        });

        $("body").off("click", ".delete_row").on("click", ".delete_row", function () {
            var satir = $(this).closest('tr');
            hizmet_table.row(satir).remove().draw(false);

            let toplam_tutar = 0;
            $(".konteyner_estimate_listesi").each(function () {
                let val = $(this).find("td:eq(2) input").val();
                val = val.replace(/\./g, "").replace(",", ".");
                val = parseFloat(val);
                toplam_tutar += val;
            });
            toplam_tutar = parseFloat(toplam_tutar);
            toplam_tutar = toplam_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            });
            $(".toplam_islem_tutari").html(toplam_tutar)
        });

        $("body").off("focusout", "#fiyat").on("focusout", "#fiyat", function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
            $(this).val(val);
        });

        $("body").off("click", "#estimate_listesini_kaydet_button").on("click", "#estimate_listesini_kaydet_button", function () {
            let konteyner_no = $("#konteyner_no").val();
            let konteyner_id = $("#konteyner_no").attr("data-id");
            let acente_adi = $("#acente_adi").val();
            let hasar_aciklamasi = $("#hasar_aciklamasi").val();
            let konteyner_tipi = $("#konteyner_tipi").val();

            let gidecek_arr = [];
            $(".konteyner_estimate_listesi").each(function () {
                let tarih = $(this).find("td").eq(0).html();
                tarih = tarih.split("/");
                let g = tarih[0];
                let a = tarih[1];
                let y = tarih[2];
                let arr = [y, a, g];
                tarih = arr.join("-");

                let uygulanan_islem = $(this).find("td").eq(1).html();
                let islem_ucreti = $(this).find("td:eq(2) input").val();
                islem_ucreti = islem_ucreti.replace(/\./g, "").replace(",", ".");
                islem_ucreti = parseFloat(islem_ucreti);
                let aciklama = $(this).find("td").eq(3).html();

                let newRow = {
                    tarih: tarih,
                    uygulanan_islem: uygulanan_islem,
                    islem_ucreti: islem_ucreti,
                    aciklama: aciklama
                };
                gidecek_arr.push(newRow);
            });
            if (konteyner_id == undefined || konteyner_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Konteyner Seçiniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "depo/controller/acente_controller/sql.php?islem=estimate_kaydet_sql",
                    type: "POST",
                    data: {
                        konteyner_no: konteyner_no,
                        konteyner_tipi: konteyner_tipi,
                        konteyner_id: konteyner_id,
                        acente_adi: acente_adi,
                        hasar_aciklamasi: hasar_aciklamasi,
                        gidecek_arr: gidecek_arr
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı!",
                                "Estimate İşlemleri Kaydedildi",
                                "success"
                            );
                            $("#estimate_konteyner_modal").modal("hide");
                            $.get("depo/view/estimate_islemleri.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/estimate_islemleri.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }

        });

        $("body").off("focusout", ".list_fiyat").on("focusout", ".list_fiyat", function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
            $(this).val(val);

            let toplam_tutar = 0;
            $(".konteyner_estimate_listesi").each(function () {
                let val = $(this).find("td:eq(2) input").val();
                val = val.replace(/\./g, "").replace(",", ".");
                val = parseFloat(val);
                toplam_tutar += val;
            });
            toplam_tutar = parseFloat(toplam_tutar);
            toplam_tutar = toplam_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            });
            $(".toplam_islem_tutari").html(toplam_tutar)
        });

        $("body").off("click", "#estimate_konteyner_modal_kapat").on("click", "#estimate_konteyner_modal_kapat", function () {
            $("#estimate_konteyner_modal").modal("hide");
        });

        $("body").off("click", "#giris_yapmis_konteynerler").on("click", "#giris_yapmis_konteynerler", function () {
            $.get("depo/modals/acente_depo_modal/estimate_modal.php?islem=giris_yapmis_konteynerleri_getir", function (getModal) {
                $(".giris-yapmis-konteynerler").html(getModal)
            })
        });

    </script>
    <?php
}
if ($islem == "giris_yapmis_konteynerleri_getir") {
    ?>
    <div class="modal fade" id="tanimli_konteynerler_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="acente_giris_konteynerleri"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>GİRİŞ YAPAN KONTEYNERLER
                            </div>
                        </div>
                        <div class="modal-body">
                            <table class="table table-sm table-bordered w-100 display nowrap"
                                   style="cursor:pointer;font-size: 13px;"
                                   id="is_emri_select_liste">
                                <thead>
                                <tr>
                                    <th id="click1">Giriş Tarihi</th>
                                    <th>Konteyner No</th>
                                    <th>Acente Adı</th>
                                    <th>Referans No</th>
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
            $("#tanimli_konteynerler_modal").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 500);
            var table = $('#is_emri_select_liste').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "giris_tarihi"},
                    {'data': "konteyner_no"},
                    {'data': "acente_adi"},
                    {'data': "referans_no"},
                    {'data': "aciklama"}
                ],
                createdRow: function (row) {
                    $(row).addClass("giris_yapan_kont_selected");
                    $(row).find('td').css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                    $(row).addClass("giris_yapan_kont_selected");
                }
            });

            $.get("depo/controller/acente_controller/sql.php?islem=konteyner_girisleri_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                }
            })

            $("body").off("click", ".giris_yapan_kont_selected").on("click", ".giris_yapan_kont_selected", function () {
                let id = $(this).attr("data-id");
                $.get("depo/controller/acente_controller/sql.php?islem=konteyner_giris_bilgileri_sql", {id: id}, function (res) {
                    if (res != 2) {
                        var item = JSON.parse(res);
                        $("#konteyner_no").attr("data-id", item.id);
                        $("#konteyner_no").val(item.konteyner_no);
                        $("#tipi").val(item.tipi);
                        $("#konteyner_tipi").val(item.konteyner_tipi);
                        $("#acente_adi").val(item.acente_adi);
                        $("#free_time").val(item.free_time);
                        $("#referans_no").val(item.referans_no);
                        $("#tanimli_konteynerler_modal").modal("hide");
                    }
                });
            });

        });

        $("body").off("click", "#acente_giris_konteynerleri").on("click", "#acente_giris_konteynerleri", function () {
            $("#tanimli_konteynerler_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "estimate_guncelle_main_modal") {
    ?>
    <style>
        #estimate_guncelle_main {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="estimate_guncelle_main" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white"
                            id="estimate_guncelle_main_kapat"
                            data-bss-dissmiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>KONTEYNER ESTİMATE</div>
                        </div>
                        <div class="modal-body">
                            <div class="giris-yapmis-konteynerler"></div>
                            <div class="col-12 row">
                                <div class="ibox-title" style="background-color: #9DB2BF;color: white">
                                    <span>KONTEYNER BİLGİLERİ</span>
                                </div>
                                <div class="mt-2"></div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Konteyner No</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="konteyner_no">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="giris_yapmis_konteynerler"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Acente Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="acente_adi"
                                                   disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Hasar Açıklaması</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm"
                                                   id="hasar_aciklamasi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Konteyner Tipi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="konteyner_tipi"
                                                   disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="no-gutters row">
                                <div class="ibox-title" style="background-color: #9DB2BF;color: white">
                                    <span>İŞLEM BİLGİLERİ</span>
                                </div>
                                <div class="mt-2 mx-2"></div>
                                <div class="col">
                                    <input type="date" class="form-control form-control-sm" id="islem_tarihi"
                                           value="<?= date("Y-m-d") ?>">
                                </div>
                                <div class="col mx-2">
                                    <input type="text" class="form-control form-control-sm"
                                           placeholder="Uygulanan İşlem" id="uygulanan_islem">
                                </div>
                                <div class="col mx-2">
                                    <input type="text" class="form-control form-control-sm" placeholder="Fiyat"
                                           id="fiyat"
                                           style="text-align: right">
                                </div>
                                <div class="col mx-2">
                                    <input type="text" class="form-control form-control-sm" id="aciklama"
                                           placeholder="Açıklama">
                                </div>
                                <div class="col mx-2">
                                    <button class="btn btn-success btn-sm" id="konteyner_hizmeti_ekle"><i
                                                class="fa fa-plus"></i> Ekle
                                    </button>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <table class="table table-sm table-bordered w-100 display nowrap"
                                       style="cursor:pointer;font-size: 13px;"
                                       id="konteyner_eklenen_hizmetler_listesi">
                                    <thead>
                                    <tr>
                                        <th style="width: 0% !important;">Tarih</th>
                                        <th id="istasyonclick">Uygulanan İşlem</th>
                                        <th>İşlem Ücreti</th>
                                        <th>Açıklama</th>
                                        <th>İşlem</th>
                                    </tr>
                                    </thead>
                                    <tfoot style="background-color: white">
                                    <th>Toplam Tutar:</th>
                                    <th style="text-align: right" class="toplam_islem_tutari">0,00</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="estimate_guncelle_main_kapat"><i
                                        class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="estimte_listesini_guncelle_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var hizmet_table = "";
        $(document).ready(function () {
            $("#estimate_guncelle_main").modal("show");
            hizmet_table = $("#konteyner_eklenen_hizmetler_listesi").DataTable({
                scrollY: '40vh',
                scrollX: true,
                "info": false,
                "order": [[0, 'desc']],
                autoWidth: false,
                columnDefs: [
                    {targets: 0, type: "date-eu"}
                ],
                createdRow: function (new_row) {
                    $(new_row).addClass("konteyner_estimate_listesi");
                    $(new_row).find('td').css('text-align', 'left');
                    $(new_row).find("td").eq(2).css("text-align", "right");
                    $(new_row).find("td").eq(4).css("text-align", "right");
                    $(new_row).find("td").eq(5).css("text-align", "right");
                    $(new_row).find("td").eq(6).css("text-align", "right");
                    $(new_row).find("td").eq(7).css("text-align", "right");
                },
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
            });

            $.get("depo/controller/acente_controller/sql.php?islem=estimate_ana_bilgileri_getir_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#konteyner_no").val(item.konteyner_no);
                    $("#konteyner_no").attr("data-id", item.konteyner_id);
                    $("#acente_adi").val(item.acente_adi);
                    $("#hasar_aciklamasi").val(item.hasar_aciklamasi);
                    $("#konteyner_tipi").val(item.konteyner_tipi);
                }
            });

            $.get("depo/controller/acente_controller/sql.php?islem=estimate_urunlerini_getir_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        let islem_ucreti = item.islem_ucreti;
                        islem_ucreti = parseFloat(islem_ucreti);
                        islem_ucreti = islem_ucreti.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        let tarih = item.tarih;
                        if (tarih != null || tarih != "0000-00-00 00:00:00") {
                            tarih = tarih.split(" ");
                            tarih = tarih[0];
                            tarih = tarih.split("-");
                            let g = tarih[2];
                            let y = tarih[0];
                            let a = tarih[1];
                            let arr = [g, a, y];
                            tarih = arr.join("/");
                        }
                        hizmet_table.row.add([tarih, item.uygulanan_islem, "<input type='text' class='form-control form-control-sm col-9 list_fiyat' style='width: 70% !important;text-align: right' value='" + islem_ucreti + "'/>", item.aciklama, "<button class='btn btn-danger btn-sm delete_row_update' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false);
                    });
                    let toplam_tutar = 0;
                    $(".konteyner_estimate_listesi").each(function () {
                        let val = $(this).find("td:eq(2) input").val();
                        val = val.replace(/\./g, "").replace(",", ".");
                        val = parseFloat(val);
                        toplam_tutar += val;
                    });
                    toplam_tutar = parseFloat(toplam_tutar);
                    toplam_tutar = toplam_tutar.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });
                    $(".toplam_islem_tutari").html(toplam_tutar)
                }
            });

            setTimeout(function () {
                $("#istasyonclick").trigger("click");
            }, 500);
        });
        $("input").click(function () {
            $(this).select();
        })

        $("body").off("click", "#konteyner_hizmeti_ekle").on("click", "#konteyner_hizmeti_ekle", function () {
            let tarih = $("#islem_tarihi").val();
            let tarih1 = tarih;
            let uygulanan_islem = $("#uygulanan_islem").val();
            let fiyat = $("#fiyat").val();
            let aciklama = $("#aciklama").val();
            if (tarih != "") {
                tarih = tarih.split("-");
                let g = tarih[2];
                let a = tarih[1];
                let y = tarih[0];
                let arr = [g, a, y];
                tarih = arr.join("/");
                let f1 = fiyat;
                f1 = f1.replace(/\./g, "").replace(",", ".");
                f1 = parseFloat(f1);
                $.ajax({
                    url: "depo/controller/acente_controller/sql.php?islem=konteyner_estimate_urun_ekle_sql",
                    type: "POST",
                    data: {
                        tarih: tarih1,
                        uygulanan_islem: uygulanan_islem,
                        islem_ucreti: f1,
                        aciklama: aciklama,
                        estimate_id: "<?=$_GET["id"]?>"
                    },
                    success: function (res) {
                        if (res != 2) {
                            let id = res;
                            id = id.split(":");
                            id = id[1];
                            hizmet_table.row.add([tarih, uygulanan_islem, "<input type='text' class='form-control form-control-sm col-9 list_fiyat' style='width: 70% !important;text-align: right' value='" + fiyat + "'/>", aciklama, "<button class='btn btn-danger btn-sm delete_row_update' data-id='" + id + "'><i class='fa fa-trash'></i></button>"]).draw(false);
                            let toplam_tutar = 0;
                            $(".konteyner_estimate_listesi").each(function () {
                                let val = $(this).find("td:eq(2) input").val();
                                val = val.replace(/\./g, "").replace(",", ".");
                                val = parseFloat(val);
                                toplam_tutar += val;
                            });
                            toplam_tutar = parseFloat(toplam_tutar);
                            toplam_tutar = toplam_tutar.toLocaleString("tr-TR", {
                                maximumFractionDigits: 2,
                                minimumFractionDigits: 2
                            });
                            $(".toplam_islem_tutari").html(toplam_tutar);
                        } else {
                            Swal.fire(
                                "Uyarı!",
                                "Bilinmeyen Bir Hata Oluştu",
                                "error"
                            );
                        }
                    }
                });


            } else {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Tarih Giriniz...",
                    "warning"
                );
            }
        });

        $("body").off("click", ".delete_row_update").on("click", ".delete_row_update", function () {
            var satir = $(this).closest('tr');
            let id = $(this).attr("data-id");
            $.ajax({
                url: "depo/controller/acente_controller/sql.php?islem=listedeki_estimate_urunu_sil_sql",
                type: "POST",
                data: {
                    id: id
                },
                success: function (res) {
                    if (res == 1) {

                        hizmet_table.row(satir).remove().draw(false);

                        let toplam_tutar = 0;
                        $(".konteyner_estimate_listesi").each(function () {
                            let val = $(this).find("td:eq(2) input").val();
                            val = val.replace(/\./g, "").replace(",", ".");
                            val = parseFloat(val);
                            toplam_tutar += val;
                        });
                        toplam_tutar = parseFloat(toplam_tutar);
                        toplam_tutar = toplam_tutar.toLocaleString("tr-TR", {
                            maximumFractionDigits: 2,
                            minimumFractionDigits: 2
                        });
                        $(".toplam_islem_tutari").html(toplam_tutar)
                    } else {
                        Swal.fire(
                            "Uyarı!",
                            "Bilinmeyen Bir Hata Oluştu",
                            "error"
                        )
                    }
                }
            });
        });

        $("body").off("focusout", "#fiyat").on("focusout", "#fiyat", function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
            $(this).val(val);
        });

        $("body").off("click", "#estimte_listesini_guncelle_button").on("click", "#estimte_listesini_guncelle_button", function () {
            let konteyner_no = $("#konteyner_no").val();
            let konteyner_id = $("#konteyner_no").attr("data-id");
            let acente_adi = $("#acente_adi").val();
            let hasar_aciklamasi = $("#hasar_aciklamasi").val();
            let konteyner_tipi = $("#konteyner_tipi").val();

            let gidecek_arr = [];
            $(".konteyner_estimate_listesi").each(function () {
                let tarih = $(this).find("td").eq(0).html();
                let uygulanan_islem = $(this).find("td").eq(1).html();
                let islem_ucreti = $(this).find("td:eq(2) input").val();
                islem_ucreti = islem_ucreti.replace(/\./g, "").replace(",", ".");
                islem_ucreti = parseFloat(islem_ucreti);
                let aciklama = $(this).find("td").eq(3).html();

                let newRow = {
                    tarih: tarih,
                    uygulanan_islem: uygulanan_islem,
                    islem_ucreti: islem_ucreti,
                    aciklama: aciklama
                };
                gidecek_arr.push(newRow);
            });
            if (konteyner_id == undefined || konteyner_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Konteyner Seçiniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "depo/controller/acente_controller/sql.php?islem=estimate_guncelle_sql",
                    type: "POST",
                    data: {
                        konteyner_no: konteyner_no,
                        konteyner_tipi: konteyner_tipi,
                        konteyner_id: konteyner_id,
                        acente_adi: acente_adi,
                        hasar_aciklamasi: hasar_aciklamasi,
                        id: "<?=$_GET["id"]?>"
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı!",
                                "Estimate İşlemleri Kaydedildi",
                                "success"
                            );
                            $("#estimate_guncelle_main").modal("hide");
                            $.get("depo/view/estimate_islemleri.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("depo/view/estimate_islemleri.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }

        });

        $("body").off("focusout", ".list_fiyat").on("focusout", ".list_fiyat", function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
            $(this).val(val);

            let toplam_tutar = 0;
            $(".konteyner_estimate_listesi").each(function () {
                let val = $(this).find("td:eq(2) input").val();
                val = val.replace(/\./g, "").replace(",", ".");
                val = parseFloat(val);
                toplam_tutar += val;
            });
            toplam_tutar = parseFloat(toplam_tutar);
            toplam_tutar = toplam_tutar.toLocaleString("tr-TR", {
                maximumFractionDigits: 2,
                minimumFractionDigits: 2
            });
            $(".toplam_islem_tutari").html(toplam_tutar)
        });

        $("body").off("click", "#estimate_guncelle_main_kapat").on("click", "#estimate_guncelle_main_kapat", function () {
            $("#estimate_guncelle_main").modal("hide");
        });

        $("body").off("click", "#giris_yapmis_konteynerler").on("click", "#giris_yapmis_konteynerler", function () {
            $.get("depo/modals/acente_depo_modal/estimate_modal.php?islem=giris_yapmis_konteynerleri_getir", function (getModal) {
                $(".giris-yapmis-konteynerler").html(getModal)
            })
        });

    </script>
    <?php
}