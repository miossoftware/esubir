<?php

$islem = $_GET["islem"];

if ($islem == "kredi_taksit_ode_modal") {
    ?>
    <style>
        #kredi_taksiti_ode_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="kredi_taksiti_ode_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 60%; max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="pos_cekim_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>YENİ KREDİ KULLANIMI</div>
                        </div>
                        <div class="modal-body">
                            <div class="kredileri_getir_div"></div>
                            <div class="col-12 row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Kredi Kodu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="kredi_kodu_bilgileri_getir">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="kullanilan_kredileri_getir_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Ödeme Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>"
                                                   class="form-control form-control-sm" id="odeme_tarihi">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="aciklama">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 row">
                                    <div class="col-md-2">
                                        <button class="btn btn-primary btn-sm" id="tumunu_sec"><i
                                                    class="fa fa-check"></i> Tümünü Seç
                                        </button>
                                    </div>
                                    <table class="table table-sm table-bordered w-100  nowrap"
                                           id="kredi_taksitleri_table"
                                           style="font-size: 13px;">
                                        <thead>
                                        <tr>
                                            <th style="width: 0px !important;">Seç</th>
                                            <th id="clikcable123" style="width: 0px !important;">Taksit</th>
                                            <th>Vadesi</th>
                                            <th>Ana Para</th>
                                            <th>Faiz Tutarı</th>
                                            <th>Toplam Ödeme</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="pos_cekim_vazgec"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="odemeyi_al"><i class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var table = "";
        $("body").off("click", ".toplam_odenecekler_input").on("click", ".toplam_odenecekler_input", function () {
            $(this).select();
        });


        $("body").off("click", "#odemeyi_al").on("click", "#odemeyi_al", function () {
            var secilenler = [];
            $(".kredi_taksit_odeme_list").each(function () {
                let id = $(this).find("td:eq(0) input").attr("data-id");
                let tutar = $(this).find("td:eq(5) input").val();
                tutar = tutar.replace(".", "").replace(",", ".");
                tutar = parseFloat(tutar);
                let aciklama = $("#aciklama").val();
                let odeme_tarihi = $("#odeme_tarihi").val();
                if ($(this).find("td:eq(0) input").prop("checked")) {
                    let newRow = {
                        kredi_id: id,
                        odeme_tarihi: odeme_tarihi,
                        aciklama: aciklama,
                        toplam_odeme: tutar
                    };
                    secilenler.push(newRow);
                }
            })
            $.ajax({
                url: "controller/kredi_controller/sql.php?islem=odemeyi_al_sql",
                type: "POST",
                data: {
                    secilenler: secilenler
                },
                success: function (res) {
                    if (res == 1) {
                        Swal.fire(
                            "Başarılı",
                            "Taksit Ödemesi Başarılı",
                            'success'
                        );
                        $("#kredi_taksiti_ode_modal").modal("hide");
                        $.get("view/kredi_taksit_odeme.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        })
                        $.get("view/kredi_taksit_odeme.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        })
                    }
                }
            });
        });

        $("body").off("click", "#kullanilan_kredileri_getir_button").on("click", "#kullanilan_kredileri_getir_button", function () {
            $.get("modals/kredi_modal/kredi_taksiti_ode_modal.php?islem=kredileri_getir_modal", function (getModal) {
                $(".kredileri_getir_div").html(getModal);
            });
        });

        $("body").off("focusout", ".toplam_odenecekler_input").on("focusout", ".toplam_odenecekler_input", function () {
            let val = $(this).val();
            val = val.replace(".", "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}))
        })

        $("body").off("keyup", "#kredi_kodu_bilgileri_getir").on("keyup", "#kredi_kodu_bilgileri_getir", function () {
            let val = $(this).val();
            $.get("controller/kredi_controller/sql.php?islem=kredi_kodu_bilgileri_getir_sql", {
                kredi_kodu: val
            }, function (response) {
                if (response != 2) {
                    table.clear().draw(false);
                    var json = JSON.parse(response);
                    table.rows.add(json).draw(false);
                } else {
                    table.clear().draw(false);
                }
            })
        });

        $("body").off("click", "#tumunu_sec").on("click", "#tumunu_sec", function () {
            $("input").prop("checked", true);
        });

        $(document).ready(function () {

            setTimeout(function () {
                $("#clikcable123").trigger("click");
            }, 500);

            $("#kredi_taksiti_ode_modal").modal("show");
            table = $('#kredi_taksitleri_table').DataTable({
                scrollY: '30vh',
                scrollX: true,
                searching: false,
                "paging": false,
                ordering: false,
                columns: [
                    {'data': 'sec'},
                    {'data': 'taksit'},
                    {'data': 'vade_tarihi'},
                    {'data': 'ana_para'},
                    {'data': 'faiz_tutari'},
                    {'data': 'toplam_odeme'}
                ],
                columnDefs: [
                    {targets: 1, type: "number"},
                ],
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row) {
                    $(row).find('td').eq(0).css('text-align', 'center');
                    $(row).find('td').eq(1).css('text-align', 'left');
                    $(row).addClass("kredi_taksit_odeme_list")
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })
        });

        $("body").off("click", "#pos_cekim_vazgec").on("click", "#pos_cekim_vazgec", function () {
            $("#kredi_taksiti_ode_modal").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "kredileri_getir_modal") {
    ?>
    <div class="modal fade" id="kredileri_getir_modal"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 100%; max-width: 100%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">KREDİ LİSTESİ
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="kredi_main_table">
                            <thead>
                            <tr>
                                <th id="click1">Kredi Kodu</th>
                                <th>Kullanım Tarihi</th>
                                <th>Kullanım Nedeni</th>
                                <th>Masraf Cari Adı</th>
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
            $("#kredileri_getir_modal").modal("hide");
        })

        $(document).ready(function () {
            $("#kredileri_getir_modal").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 500);
            var table = $('#kredi_main_table').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                columns: [
                    {'data': "kredi_kodu"},
                    {'data': "kullanim_tarihi"},
                    {'data': "kullanim_nedeni"},
                    {'data': "masraf_cari_adi"}
                ],
                createdRow: function (row) {
                    $(row).addClass("cari_select");
                    $(row).find('td').css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })
            $.get("controller/kredi_controller/sql.php?islem=kullanilan_kredileri_getir_sql2", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    table.rows.add(json).draw(false);
                }
            })
        })

        $("body").off("click", ".cari_select").on("click", ".cari_select", function () {
            var id = $(this).attr("data-id");
            $("#kredi_kodu_bilgileri_getir").attr("data-id", id);
            let kredi_kodu = $(this).find("td").eq(0).text();
            let masraf_carisi = $(this).find("td").eq(3).text();
            $("#kredi_kodu_bilgileri_getir").val(kredi_kodu);
            $("#masraf_cari_adi").val(masraf_carisi);
            if ("<?=$_GET["geldigi_yer"]?>" != "ekstre"){
                $.get("controller/kredi_controller/sql.php?islem=kredi_kodu_bilgileri_getir_sql", {
                    kredi_kodu: kredi_kodu
                }, function (response) {
                    if (response != 2) {
                        table.clear().draw(false);
                        var json = JSON.parse(response);
                        table.rows.add(json).draw(false);
                    } else {
                        table.clear().draw(false);
                    }
                })
            }
            $("#kredileri_getir_modal").modal("hide");
        })
    </script>
    <?php
}