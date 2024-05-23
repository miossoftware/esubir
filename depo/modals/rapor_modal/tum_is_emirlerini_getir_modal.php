<?php

$islem = $_GET["islem"];

if ($islem == "tum_is_emirlerini_getir_modal") {
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
                                    <th>Cari Adı</th>
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
                    {'data': "cari_adi"},
                    {'data': "referans_no"},
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

            $.get("depo/controller/is_emri_controller/sql.php?islem=tum_is_emirlerini_getir_sql2", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                }
            })
        });

        $("body").off("click", ".depo_siparis_selected").on("click", ".depo_siparis_selected", function () {
            let id = $(this).attr("data-id");
            $.get("depo/controller/is_emri_controller/sql.php?islem=is_emrinin_ana_bilgilerini_getir_sql", {id: id}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#cari_id").val(item.cari_adi);
                    $("#cari_id").attr("data-id", item.cari_id);
                    $("#firma_unvan").val(item.cari_adi);
                    $("#vergi_dairesi").val(item.vergi_dairesi);
                    $("#vergi_no").val(item.vergi_no);
                    $("#adres").val(item.adres);
                    $("#referans_no").val(item.acente_ref);
                    $("#beyanname_no").val(item.beyanname_no);
                    $("#siparis_ep_ref").val(item.epro_ref);
                    $("#siparis_ep_ref").attr("data-id", id);
                    $("#epro_ref").val(item.epro_ref);
                    $("#epro_ref").attr("data-id", id);
                    $("#epro_ref").attr("tipi", item.tipi);
                    $("#acenta").val(item.acente);
                    $("#acenta_ref").val(item.referans_no);
                    $("#referans_no").val(item.referans_no);
                    $("#alim_yeri").val(item.alim_yeri);
                    $("#fabrika_ref").val(item.fabrika_ref);
                    $("#mal_kodu").attr("data-id", item.mal_id);
                    $("#mal_kodu").val(item.urun_adi);
                    $("#birim_id").val(item.birim_id);
                }
            })
            $("#depo_siparisleri_getir_modal").modal("hide");
        });

        $("body").off("click", "#depo_siparisleri_getir_modal_kapat").on("click", "#depo_siparisleri_getir_modal_kapat", function () {
            $("#depo_siparisleri_getir_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "ihracat_is_emirlerini_getir_modal") {
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
                                    <th>Cari Adı</th>
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
                    {'data': "cari_adi"},
                    {'data': "referans_no"},
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

            $.get("depo/controller/is_emri_controller/sql.php?islem=tum_is_emirlerini_getir_sql3", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    table.rows.add(json).draw(false);
                }
            })
        });

        $("body").off("click", ".depo_siparis_selected").on("click", ".depo_siparis_selected", function () {
            let id = $(this).attr("data-id");
            $.get("depo/controller/is_emri_controller/sql.php?islem=is_emrinin_ana_bilgilerini_getir_sql", {id: id}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#cari_id").val(item.cari_adi);
                    $("#cari_id").attr("data-id", item.cari_id);
                    $("#firma_unvan").val(item.cari_adi);
                    $("#vergi_dairesi").val(item.vergi_dairesi);
                    $("#vergi_no").val(item.vergi_no);
                    $("#adres").val(item.adres);
                    $("#referans_no").val(item.acente_ref);
                    $("#beyanname_no").val(item.beyanname_no);
                    $("#siparis_ep_ref").val(item.epro_ref);
                    $("#siparis_ep_ref").attr("data-id", id);
                    $("#epro_ref").val(item.epro_ref);
                    $("#epro_ref").attr("data-id", id);
                    $("#epro_ref").attr("tipi", item.tipi);
                    $("#acenta").val(item.acente);
                    $("#acenta_ref").val(item.referans_no);
                    $("#referans_no").val(item.referans_no);
                    $("#alim_yeri").val(item.alim_yeri);
                    $("#fabrika_ref").val(item.fabrika_ref);
                    $("#mal_kodu").attr("data-id", item.mal_id);
                    $("#mal_kodu").val(item.urun_adi);
                    $("#birim_id").val(item.birim_id);
                }
            })
            $("#depo_siparisleri_getir_modal").modal("hide");
        });

        $("body").off("click", "#depo_siparisleri_getir_modal_kapat").on("click", "#depo_siparisleri_getir_modal_kapat", function () {
            $("#depo_siparisleri_getir_modal").modal("hide");
        });

    </script>
    <?php
}