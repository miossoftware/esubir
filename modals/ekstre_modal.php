<?php

$islem = $_GET["islem"];
if ($islem == "cariler_listesi_getir_modal") {
    ?>
    <div class="modal fade" id="fatura_cari_liste_modal_getir"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 30%; max-width: 30%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Cari Listesi
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="cari_liste_ekstre">
                            <thead>
                            <tr>
                                <th id="click1">Cari Adı</th>
                                <th>Cari Kodu</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#fatura_cari_liste_modal_getir").modal("hide");
        })
        $(document).ready(function () {
            $.get("controller/alis_controller/sql.php?islem=fatura_turlerini_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#fatura_turu").append("" +
                            "<option value='" + item.id + "'>" + item.fatura_turu_adi + "</option>" +
                            "");
                    })
                }
            })
            $("#fatura_cari_liste_modal_getir").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 300);
            var table = $('#cari_liste_ekstre').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "cari_adi"},
                    {'data': "cari_kodu"}
                ],
                createdRow: function (row) {
                    $(row).addClass("cari_select");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })
            $.get("controller/alis_controller/sql.php?islem=carileri_getir2",{from:"<?=$_GET["from"]?>"}, function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    table.rows.add(json).draw(false);
                }
            })
            $("body").off("click", ".cari_select").on("click", ".cari_select", function () {
                var id = $(this).attr("data-id");
                var cari_adi = $(this).find("td").eq(0).text();
                var cari_kodu = $(this).find("td").eq(1).text();
                $(".secilen_cari").val(cari_kodu);
                $(".secilen_cari").attr("data-id", id);
                $(".cari_adi_getir").val(cari_adi);
                $("#fatura_cari_liste_modal_getir").modal("hide");
                $.get("controller/alis_controller/sql.php?islem=secilen_cari_bilgileri", {id: id}, function (result) {
                    if (result != 2) {
                        var item = JSON.parse(result);
                        var telefon = item.telefon;
                        var yetkiliAdi1 = item.yetkili_adi1;
                        var yetkiliTel1 = item.yetkili_tel1;
                        var vergiDairesi = item.vergi_dairesi;
                        var vergiNo = item.vergi_no;
                        var adres = item.adres;
                        var vade_gunu = item.vade_gunu;
                        var tarih1 = $(".fatura_tarihi");
                        var tarih = new Date(tarih1.val());
                        var vade_tarihi = new Date(tarih.getTime() + (vade_gunu * 24 * 60 * 60 * 1000));
                        var yeniTarihString = vade_tarihi.getFullYear() + '-' + ('0' + (vade_tarihi.getMonth() + 1)).slice(-2) + '-' + ('0' + vade_tarihi.getDate()).slice(-2);
                        $(".vade_tarihi_ayarla").val(yeniTarihString)
                        $(".cari_telefon").val(telefon);
                        $(".yetkili_adi").val(yetkiliAdi1);
                        $(".yetkili_cep").val(yetkiliTel1);
                        $(".vergi_daire").val(vergiDairesi);
                        $(".vergi_no").val(vergiNo);
                        $(".cari_adres").val(adres);
                    }
                });
            })
        })
    </script>
    <?php
}
if ($islem == "bankalari_getir_modal") {
    ?>
    <div class="modal fade" id="bankalar_listesi_modal"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 65%; max-width: 65%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Banka Listesi
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="banka_liste_ekstre">
                            <thead>
                            <tr>
                                <th id="click1">Banka Adı</th>
                                <th>Banka Kodu</th>
                                <th>Şube Adı</th>
                                <th>Hesap Adı</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#bankalar_listesi_modal").modal("hide");
        })
        $(document).ready(function () {
            $("#bankalar_listesi_modal").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 300);
            var table = $('#banka_liste_ekstre').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "banka_adi"},
                    {'data': "banka_kodu"},
                    {'data': "sube_adi"},
                    {'data': "hesap_adi"},
                ],
                createdRow: function (row) {
                    $(row).addClass("banka_selected");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                    $(row).find('td').eq(2).css('text-align', 'left');
                    $(row).find('td').eq(3).css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $("body").off("click", ".banka_selected").on("click", ".banka_selected", function () {
                let id = $(this).attr("data-id");
                let banka_adi = $(this).find("td").eq(0).text();
                let banka_kodu = $(this).find("td").eq(1).text();
                let sube_adi = $(this).find("td").eq(2).text();

                $(".sube_adi_getir").val(sube_adi);
                $(".banka_adi_getir").val(banka_adi);
                $(".secilen_banka").attr("data-id", id);
                $(".secilen_banka").val(banka_kodu);
                $("#bankalar_listesi_modal").modal("hide");
            });

            $.get("controller/banka_controller/sql.php?islem=bankalari_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    table.rows.add(json).draw(false);
                }
            })
        })
    </script>
    <?php
}
if ($islem == "kasa_listesi_getir_modal") {
    ?>
    <div class="modal fade" id="kasa_listesi_modal"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 30%; max-width: 30%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Kasa Listesi
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="kasa_liste_ekstre">
                            <thead>
                            <tr>
                                <th id="click1">Kasa Adı</th>
                                <th>Kasa Kodu</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#kasa_listesi_modal").modal("hide");
        })
        $(document).ready(function () {
            $("#kasa_listesi_modal").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 300);
            var table = $('#kasa_liste_ekstre').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "kasa_adi"},
                    {'data': "kasa_kodu"}
                ],
                createdRow: function (row) {
                    $(row).addClass("kasa_selected_for_reports");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $("body").off("click", ".kasa_selected_for_reports").on("click", ".kasa_selected_for_reports", function () {
                let id = $(this).attr("data-id");
                let banka_adi = $(this).find("td").eq(0).text();
                let banka_kodu = $(this).find("td").eq(1).text();

                $(".kasa_adi_getir").val(banka_adi);
                $(".secilen_kasa").attr("data-id", id);
                $(".secilen_kasa").val(banka_kodu);
                $("#kasa_listesi_modal").modal("hide");
            });

            $.get("controller/kasa_controller/sql.php?islem=kasalari_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    table.rows.add(json).draw(false);
                }
            })
        })
    </script>
    <?php
}
if ($islem == "stok_listesi_getir_modal") {
    ?>
    <div class="modal fade" id="stok_listesi_modal"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 30%; max-width: 30%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Stok Listesi
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="stok_liste_ekstre">
                            <thead>
                            <tr>
                                <th id="click1">Stok Adı</th>
                                <th>Stok Kodu</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#stok_listesi_modal").modal("hide");
        })
        $(document).ready(function () {
            $("#stok_listesi_modal").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 300);
            var table = $('#stok_liste_ekstre').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "stok_adi"},
                    {'data': "stok_kodu"}
                ],
                createdRow: function (row) {
                    $(row).addClass("stok_selected_for_reports");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $("body").off("click", ".stok_selected_for_reports").on("click", ".stok_selected_for_reports", function () {
                let id = $(this).attr("data-id");
                let banka_adi = $(this).find("td").eq(0).text();
                let banka_kodu = $(this).find("td").eq(1).text();

                $(".stok_adi_getir").val(banka_adi);
                $(".secilen_stok").attr("data-id", id);
                $(".secilen_stok").val(banka_kodu);
                $("#stok_listesi_modal").modal("hide");
            });

            $.get("controller/stok_controller/sql.php?islem=stoklari_getir",{aktif_modul:"<?=$_GET["aktif_modul"]?>"}, function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    table.rows.add(json).draw(false);
                }
            })
        })
    </script>
    <?php
}
if ($islem == "cariye_ait_acik_irsaliye_getir") {
    $cari_id = "";
    if (isset($_GET["cari_id"])) {
        $cari_id = $_GET["cari_id"];
    }
    ?>
    <div class="col-12 row mt-3">
        <table class="table table-sm table-bordered w-100 display nowrap edit_list"
               style="cursor:pointer;font-size: 13px;"
               id="cari_acik_alis_irsaliye">
            <thead>
            <tr>
            <tr>
                <th>Tarih</th>
                <th>Ürün</th>
                <th>Miktar</th>
                <th>Fiyat</th>
                <th>Tutar</th>
            </tr>
            </tr>
            </thead>
            <tfoot style="background-color: white">
            <tr>
                <th colspan="2" style="text-align: right; font-size: 14px;">TOPLAM:</th>
                <th style="text-align: right; font-size: 14px;" class="alis_irsaliye_miktar_t">0,00</th>
                <th style="text-align: center; font-size: 14px;" class="alis_irsaliye_fiyat_t">0,00</th>
                <th style="text-align: right; font-size: 14px;" class="alis_irsaliye_tutar_t">0,00</th>
            </tr>
            </tfoot>
        </table>

    </div>
    <script>

        $(document).ready(function () {
            jQuery.extend(jQuery.fn.dataTableExt.oSort, {
                "date-eu-pre": function (dateString) {
                    var parts = dateString.split('/');
                    return Date.parse(parts[2] + '/' + parts[1] + '/' + parts[0]) || 0;
                },

                "date-eu-asc": function (a, b) {
                    return ((a < b) ? -1 : ((a > b) ? 1 : 0));
                },

                "date-eu-desc": function (a, b) {
                    return ((a < b) ? 1 : ((a > b) ? -1 : 0));
                }
            });

            var targetColumns = [2, 3, 4];
            var acik_alis_irsaliye = $('#cari_acik_alis_irsaliye').DataTable({
                paging: false,
                scrollX: true,
                scrollY: "55vh",
                ordering: true,
                // bAutoWidth: false,
                // aoColumns: [
                //     {width: '0%'},
                //     {width: '0%'},
                //     {width: '1%'},
                //     {width: '5%'},
                //     {width: '0%'},
                //     {width: '0%'},
                //     {width: '1%'},
                //     {width: '0%'},
                //     {width: '1%'}
                // ],
                "info": false,
                columns: [
                    {"data": "tarih", "type": "date-eu"},
                    {"data": "urun_adi"},
                    {"data": "miktar"},
                    {"data": "fiyat"},
                    {"data": "toplam_tutar"}
                ],
                "order": [[0, 'asc']],
                createdRow: function (row) {
                    $(row).find("td").eq(0).css("text-align", "left");
                },
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
            })
            let bas_tarih = $("#bas_tarih").val();
            let bit_tarih = $("#bit_tarih").val();
            $.get("controller/ekstre_controller/sql.php?islem=cariye_ait_acik_alis_irsaliyelerini_getir", {
                cari_id: "<?=$cari_id?>",
                bas_tarih: bas_tarih,
                bit_tarih: bit_tarih
            }, function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    let basilacak_arr = [];
                    let toplam_fiyat = 0;
                    let toplam_tutar_main = 0;
                    let toplam_miktar = 0;
                    json.forEach(function (item) {

                        let tarih = item.irsaliye_tarihi;
                        tarih = tarih.split(" ");
                        tarih = tarih[0];
                        tarih = tarih.split("-");
                        let gun = tarih[2];
                        let ay = tarih[1];
                        let yil = tarih[0];
                        let arr = [gun, ay, yil];
                        tarih = arr.join("/");

                        let miktar = item.miktar;
                        miktar = parseFloat(miktar);
                        toplam_miktar += miktar;
                        miktar = miktar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                        let birim_fiyat = item.birim_fiyat;
                        birim_fiyat = parseFloat(birim_fiyat);
                        toplam_fiyat += birim_fiyat;
                        birim_fiyat = birim_fiyat.toLocaleString("tr-TR", {
                            maximumFractionDigits: 2,
                            minimumFractionDigits: 2
                        });
                        let toplam_tutar = item.toplam_tutar;
                        toplam_tutar = parseFloat(toplam_tutar);
                        toplam_tutar_main += toplam_tutar;
                        toplam_tutar = toplam_tutar.toLocaleString("tr-TR", {
                            maximumFractionDigits: 2,
                            minimumFractionDigits: 2
                        });
                        let newRow = {
                            'tarih': tarih,
                            'urun_adi': item.stok_adi,
                            'miktar': miktar,
                            "fiyat": birim_fiyat,
                            "toplam_tutar": toplam_tutar
                        }
                        basilacak_arr.push(newRow);
                    });
                    toplam_fiyat = toplam_fiyat.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });
                    toplam_tutar_main = toplam_tutar_main.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    toplam_miktar = toplam_miktar.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });
                    $(".alis_irsaliye_miktar_t").html("");
                    $(".alis_irsaliye_miktar_t").html(toplam_miktar);
                    $(".alis_irsaliye_fiyat_t").html("");
                    $(".alis_irsaliye_fiyat_t").html(toplam_fiyat);
                    $(".alis_irsaliye_tutar_t").html("");
                    $(".alis_irsaliye_tutar_t").html(toplam_tutar_main);
                    acik_alis_irsaliye.rows.add(basilacak_arr).draw(false);
                }
            });
        })
    </script>
    <?php
}
if ($islem == "cariye_ait_acik_satis_irsaliye_getir") {
    $cari_id = "";
    if (isset($_GET["cari_id"])) {
        $cari_id = $_GET["cari_id"];
    }
    ?>
    <div class="col-12 row mt-3">
        <table class="table table-sm table-bordered w-100 display nowrap edit_list"
               style="cursor:pointer;font-size: 13px;"
               id="cari_acik_satis_irsaliye">
            <thead>
            <tr>
                <th style="width: 0%">Tarih</th>
                <th style="width: 0%">Ürün</th>
                <th style="width: 0%">Miktar</th>
                <th style="width: 0%">Fiyat</th>
                <th style="width: 0%">Tutar</th>
            </tr>
            </thead>
            <tfoot style="background-color: white">
            <tr>
                <th colspan="2" style="text-align: right; font-size: 14px;">TOPLAM:</th>
                <th style="text-align: right; font-size: 14px;" class="toplam_miktar_satis">0,00</th>
                <th style="text-align: center; font-size: 14px;" class="toplam_fiyat_satis">0,00</th>
                <th style="text-align: right; font-size: 14px;" class="toplam_tutar_satis">0,00</th>
            </tr>
            </tfoot>
        </table>

    </div>
    <script>

        $(document).ready(function () {
            jQuery.extend(jQuery.fn.dataTableExt.oSort, {
                "date-eu-pre": function (dateString) {
                    var parts = dateString.split('/');
                    return Date.parse(parts[2] + '/' + parts[1] + '/' + parts[0]) || 0;
                },

                "date-eu-asc": function (a, b) {
                    return ((a < b) ? -1 : ((a > b) ? 1 : 0));
                },

                "date-eu-desc": function (a, b) {
                    return ((a < b) ? 1 : ((a > b) ? -1 : 0));
                }
            });

            var targetColumns = [2, 3, 4];
            var acik_satis_irsaliye = $('#cari_acik_satis_irsaliye').DataTable({
                paging: false,
                scrollX: true,
                scrollY: "55vh",
                ordering: true,
                // bAutoWidth: false,
                // aoColumns: [
                //     {width: '0%'},
                //     {width: '0%'},
                //     {width: '1%'},
                //     {width: '5%'},
                //     {width: '0%'},
                //     {width: '0%'},
                //     {width: '1%'},
                //     {width: '0%'},
                //     {width: '1%'}
                // ],
                "info": false,
                columns: [
                    {"data": "tarih", "type": "date-eu"},
                    {"data": "urun_adi"},
                    {"data": "miktar"},
                    {"data": "fiyat"},
                    {"data": "toplam_tutar"}
                ],
                "order": [[0, 'asc']],
                createdRow: function (row) {
                    $(row).find("td").eq(0).css("text-align", "left");
                    $(row).find("td").eq(1).css("text-align", "left");
                },
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
            })
            let bas_tarih = $("#bas_tarih").val();
            let bit_tarih = $("#bit_tarih").val();
            $.get("controller/ekstre_controller/sql.php?islem=cariye_ait_acik_satis_irsaliyelerini_getir", {
                cari_id: "<?=$cari_id?>",
                bas_tarih: bas_tarih,
                bit_tarih: bit_tarih
            }, function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    let basilacak_arr = [];
                    let toplam_tutar_main = 0;
                    let toplam_fiyat = 0;
                    let toplam_miktar = 0;
                    json.forEach(function (item) {

                        let tarih = item.irsaliye_tarihi;
                        tarih = tarih.split(" ");
                        tarih = tarih[0];
                        tarih = tarih.split("-");
                        let gun = tarih[2];
                        let ay = tarih[1];
                        let yil = tarih[0];
                        let arr = [gun, ay, yil];
                        tarih = arr.join("/");

                        let miktar = item.miktar;
                        miktar = parseFloat(miktar);
                        toplam_miktar += miktar;
                        miktar = miktar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                        let birim_fiyat = item.birim_fiyat;
                        birim_fiyat = parseFloat(birim_fiyat);
                        toplam_fiyat += birim_fiyat;
                        birim_fiyat = birim_fiyat.toLocaleString("tr-TR", {
                            maximumFractionDigits: 2,
                            minimumFractionDigits: 2
                        });
                        let toplam_tutar = item.toplam_tutar;
                        toplam_tutar = parseFloat(toplam_tutar);
                        toplam_tutar_main += toplam_tutar;
                        toplam_tutar = toplam_tutar.toLocaleString("tr-TR", {
                            maximumFractionDigits: 2,
                            minimumFractionDigits: 2
                        });
                        let newRow = {
                            'tarih': tarih,
                            'urun_adi': item.stok_adi,
                            'miktar': miktar,
                            "fiyat": birim_fiyat,
                            "toplam_tutar": toplam_tutar
                        }
                        basilacak_arr.push(newRow);
                    });
                    toplam_fiyat = toplam_fiyat.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });
                    toplam_tutar_main = toplam_tutar_main.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    toplam_miktar = toplam_miktar.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });
                    $(".toplam_miktar_satis").html("");
                    $(".toplam_miktar_satis").html(toplam_miktar);
                    $(".toplam_fiyat_satis").html("");
                    $(".toplam_fiyat_satis").html(toplam_fiyat);
                    $(".toplam_tutar_satis").html("");
                    $(".toplam_tutar_satis").html(toplam_tutar_main);
                    acik_satis_irsaliye.rows.add(basilacak_arr).draw(false);

                }
            });

        })
    </script>
    <?php
}
if ($islem == "pos_hesaplarini_getir_modal") {
    ?>
    <div class="modal fade" id="pos_hesaplar_listesi_modal"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 30%; max-width: 30%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">POS HESAP LİSTESİ
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="pos_hesaplar_listesi">
                            <thead>
                            <tr>
                                <th id="click1">Banka Adı</th>
                                <th>Banka Kodu</th>
                                <th>Hesap Adı</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#pos_hesaplar_listesi_modal").modal("hide");
        })
        $(document).ready(function () {
            $("#pos_hesaplar_listesi_modal").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 300);
            var table = $('#pos_hesaplar_listesi').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "banka_adi"},
                    {'data': "banka_kodu"},
                    {'data': "hesap_adi"},
                ],
                createdRow: function (row) {
                    $(row).addClass("banka_selected");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                    $(row).find('td').eq(2).css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $("body").off("click", ".banka_selected").on("click", ".banka_selected", function () {
                let id = $(this).attr("data-id");
                let banka_adi = $(this).find("td").eq(0).text();
                let banka_kodu = $(this).find("td").eq(1).text();
                $(".pos_hesap_banka_adi").val(banka_adi);
                $(".secilen_pos_hesabı").attr("data-id", id);
                $(".secilen_pos_hesabı").val(banka_kodu);
                $("#pos_hesaplar_listesi_modal").modal("hide");
            });

            $.get("controller/pos_controller/sql.php?islem=poslari_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    table.rows.add(json).draw(false);
                }
            })
        })
    </script>
    <?php
}