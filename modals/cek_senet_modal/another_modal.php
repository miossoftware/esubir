<?php

$islem = $_GET["islem"];


if ($islem == "carileri_getir_modal") {
    ?>
    <div class="modal fade" id="fatura_cari_liste_modal_getir"

         data-bs-keyboard="false" role="dialog">

        <div class="modal-dialog"

             style="width: 100%; max-width: 100%;">

            <div class="modal-content">

                <div class="modal-header text-white p-2">Cari Listesi

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

        $('input').click(function () {
            $(this).select();
        });
        var table = "";

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

            table = $('#fatura_cari_liste').DataTable({

                scrollY: '35vh',

                scrollX: true,

                "info": false,

                "paging": false,

                "dom": '<"pull-left"f><"pull-right"l>tip',

                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "cari_adi"},
                    {'data': "cari_kodu"},
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

            $.get("controller/alis_controller/sql.php?islem=carileri_getir", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    table.rows.add(json).draw(false);
                }
            })

        })


        $("body").off("click", ".cari_select").on("click", ".cari_select", function () {
            var id = $(this).attr("data-id");
            var cari_adi = $(this).find("td").eq(0).text();
            var cari_kodu = $(this).find("td").eq(1).text();
            $(".secilen_cari").val(cari_kodu);
            $(".secilen_cari").attr("data-id", id);
            $(".cari_adi_getir").val(cari_adi);
            $(".cari_adi").val(cari_adi);
            $("#fatura_cari_liste_modal_getir").modal("hide");
            $.get("controller/alis_controller/sql.php?islem=secilen_cari_bilgileri", {cari_kodu: cari_kodu}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#cari_tel").val(item.telefon);
                    $("#cari_adi_cek_senet").val(item.cari_adi);
                    $("#cek_senet_giris_cariid").val(item.cari_kodu);
                    $("#cek_senet_giris_cariid").attr("data-id", item.id);
                    $("#cek_senet_cikis_cariid").val(item.cari_kodu);
                    $("#cek_senet_cikis_cariid").attr("data-id", item.id);
                    $("#cari_yetkili").val(item.yetkili_adi1);
                    $("#yetkili_tel").val(item.yetkili_tel1);
                    $("#vergi_dairesi").val(item.vergi_dairesi);
                    $("#vergi_no").val(item.vergi_no);
                    $("#cari_adres").val(item.adres);
                }

            });

        })

    </script>
    <?php
}
if ($islem == "banka_listesi_getir_modal") {
    ?>
    <div class="modal fade" id="bankalar_listesi_cek_senet_modal"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 100%; max-width: 100%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Banka Listesi
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="banka_liste_cek_senet">
                            <thead>
                            <tr>
                                <th id="click1">Banka Adı</th>
                                <th>Banka Kodu</th>
                                <th>Şube Adı</th>
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
            $("#bankalar_listesi_cek_senet_modal").modal("hide");
        })
        $(document).ready(function () {
            $("#bankalar_listesi_cek_senet_modal").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 300);
            var table = $('#banka_liste_cek_senet').DataTable({
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
                let val = $(this).find("td").eq(1).text();
                $.get("controller/cek_senet_controller/sql.php?islem=banka_kodu_bilgileri_getir_sql", {banka_kodu: val}, function (result) {
                    if (result != 2) {
                        var item = JSON.parse(result);
                        $("#cek_senet_getir_bankaid").attr("data-id", item.id);
                        $("#cek_senet_getir_bankaid").val(item.banka_kodu);
                        $("#banka_adi_cek_senet").val(item.banka_adi);
                        $("#banka_adres").val(item.adres);
                        $("#banka_adi").val(item.banka_adi);
                        $("#banka_kodu_cek_stok").val(item.banka_kodu);
                        $("#banka_kodu_cek_stok").attr("data-id", item.id);
                        $("#yetkili_adi").attr("data-id", item.id);
                    } else {
                        $("#cek_senet_getir_bankaid").attr("data-id", "");
                        $("#banka_adi_cek_senet").val("");
                        $("#banka_adres").val("");
                    }
                })
                $("#bankalar_listesi_cek_senet_modal").modal("hide");
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
if ($islem == "kasalar_listesi_modal") {
    ?>
    <div class="modal fade" id="kasalar_listesi_cek_senet_modal"
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
                               id="banka_liste_cek_senet">
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
            $("#kasalar_listesi_cek_senet_modal").modal("hide");
        })
        $(document).ready(function () {
            $("#kasalar_listesi_cek_senet_modal").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 300);
            var table = $('#banka_liste_cek_senet').DataTable({
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
                    $(row).addClass("banka_selected");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $("body").off("click", ".banka_selected").on("click", ".banka_selected", function () {
                let val = $(this).find("td").eq(1).text();
                $.get("controller/cek_senet_controller/sql.php?islem=kasa_kodu_bilgileri_getir", {banka_kodu: val}, function (result) {
                    if (result != 2) {
                        var item = JSON.parse(result);
                        $("#kasa_kodu_ceksenid").attr("data-id", item.id);
                        $("#kasa_kodu_ceksenid").val(item.kasa_kodu);
                        $("#kasa_adi_ceksenetid").val((item.kasa_adi).toUpperCase());
                    } else {
                        $("#cek_senet_getir_bankaid").attr("data-id", "");
                        $("#banka_adi_cek_senet").val("");
                        $("#banka_adres").val("");
                    }
                })
                $("#kasalar_listesi_cek_senet_modal").modal("hide");
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
if ($islem == "bankalarimizi_getir") {
    ?>
    <div class="modal fade" id="bankalar_listesi_kendi_cekimiz"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 55%; max-width: 55%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Banka Listesi
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="banka_liste_cek_senet">
                            <thead>
                            <tr>
                                <th id="click1">Banka Adı</th>
                                <th>Banka Kodu</th>
                                <th>Şube Adı</th>
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
            $("#bankalar_listesi_kendi_cekimiz").modal("hide");
        })

        $(document).ready(function () {
            $("#bankalar_listesi_kendi_cekimiz").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 300);
            var table = $('#banka_liste_cek_senet').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "banka_adi"},
                    {'data': "banka_kodu"},
                    {'data': "sube_adi"}
                ],
                createdRow: function (row) {
                    $(row).addClass("secilen_banka");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                    $(row).find('td').eq(2).css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $("body").off("click", ".secilen_banka").on("click", ".secilen_banka", function () {
                let val = $(this).find("td").eq(1).text();
                $.get("controller/banka_controller/sql.php?islem=banka_kodu_bilgileri_sql", {banka_kodu: val}, function (result) {
                    if (result != 2) {
                        var item = JSON.parse(result);
                        $.get("controller/cek_senet_controller/sql.php?islem=bankaya_ait_ceklerimizi_getir_sql", {banka_id: item.id}, function (response) {
                            if (response != 2) {
                                var item1 = JSON.parse(response);
                                let baslangic_kodu = item1.cek_baslangic_no;
                                var harfVarMi = /[a-zA-Z]/.test(baslangic_kodu);
                                let metinsel_degerler = "";
                                if (harfVarMi){
                                    metinsel_degerler = baslangic_kodu.match(/[a-zA-Z]/g).join("");
                                }
                                $("#bizim_cek_seri_no").val(metinsel_degerler + (item1.cek_no))
                            }
                        });

                        $("#banka_sube").val(item.sube_adi);
                        $("#banka_hesap_no").val(item.hesap_no);
                        $("#banka_adi").val(item.banka_adi);
                        $("#banka_kodu").attr("data-id", item.id);
                        $("#banka_kodu").val(item.banka_kodu);
                    } else {
                        $("#banka_sube").val("");
                        $("#banka_hesap_no").val("");
                        $("#banka_adi").val("");
                        $("#banka_kodu").attr("data-id", "");
                        $("#seri_no").val("");
                    }
                })
                $("#bankalar_listesi_kendi_cekimiz").modal("hide");
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
if ($islem == "bankaya_ait_cek_kocanlari_getir") {
    ?>
    <div class="modal fade" id="bankalar_kendi_ceklerimizi_getirdim"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 55%; max-width: 55%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Çek Listesi
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="bankaya_ait_cek_kocanlari_list_main">
                            <thead>
                            <tr>
                                <th id="click1">Çek No</th>
                                <th>Banka Adı</th>
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
            $("#bankalar_kendi_ceklerimizi_getirdim").modal("hide");
        })

        $(document).ready(function () {
            $("#bankalar_kendi_ceklerimizi_getirdim").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 300);
            var table = $('#bankaya_ait_cek_kocanlari_list_main').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "cek_no"},
                    {'data': "banka_adi"}
                ],
                createdRow: function (row) {
                    $(row).addClass("secilen_cek_kocanlari");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                    $(row).find('td').eq(2).css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $("body").off("click", ".secilen_cek_kocanlari").on("click", ".secilen_cek_kocanlari", function () {
                let cek_no = $(this).find("td").eq(0).text();
                $("#bizim_cek_seri_no").val(cek_no)
                $("#bankalar_kendi_ceklerimizi_getirdim").modal("hide");
            });

            $.get("controller/cek_senet_controller/sql.php?islem=bize_ait_cekleri_getir",{banka_id:"<?=$_GET["banka_id"]?>"}, function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    var basilacak_arr = [];
                    json.forEach(function (item){
                        let baslangic_kodu = item.cek_baslangic_no;
                        var harfVarMi = /[a-zA-Z]/.test(baslangic_kodu);
                        let metinsel_degerler = "";
                        if (harfVarMi){
                            metinsel_degerler = baslangic_kodu.match(/[a-zA-Z]/g).join("");
                        }

                        let newRow = {
                            cek_no:metinsel_degerler+(item.cek_no),
                            banka_adi:item.banka_adi,
                        };
                        basilacak_arr.push(newRow);
                    });
                    table.rows.add(basilacak_arr).draw(false);
                }
            })
        })
    </script>
    <?php
}