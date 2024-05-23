<?php

$islem = $_GET["islem"];

if ($islem == "guncelle_modal_getir") {
    ?>
    <div class="modal fade" id="pos_tanim_main_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 65%; max-width: 65%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="pos_tanim_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>POS GÜNCELLE</div>
                        </div>
                        <div class="modal-body">
                            <div class="pos_icin_cari_getir_div"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Banka Kodu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="pos_tanim_bankalar">
                                                <option value="">Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Hesap Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="hesap_adi" class="form-control form-control-sm"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Şube Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="sube_adi" class="form-control form-control-sm"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>IBAN</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="iban_no" class="form-control form-control-sm"
                                                   disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Vade Günü</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input id="vade_gunu" style="text-align: right" type="text"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Komisyon Oran</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="komisyon_orani" style="text-align: right"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Cari Kodu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="pos_cari_kodu">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="cari_bilgileri_getir_pos_button"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Cari Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="pos_cari_adi"
                                                   disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger btn-sm" id="pos_tanim_vazgec"><i class="fa fa-close"></i>
                                    Vazgeç
                                </button>
                                <button class="btn btn-success btn-sm" id="pos_tanim_guncelle"><i
                                            class="fa fa-check"></i>
                                    Kaydet
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("#vade_gunu").focusout(function () {
            let miktar = $(this).val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            miktar = miktar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
            $("#vade_gunu").val(miktar);
        });

        $("#komisyon_orani").focusout(function () {
            let miktar = $(this).val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            miktar = miktar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
            $("#komisyon_orani").val(miktar);
        });

        $("body").off("click", "#pos_tanim_guncelle").on("click", "#pos_tanim_guncelle", function () {
            let banka_id = $("#pos_tanim_bankalar").val();
            let vade_gunu = $("#vade_gunu").val();
            let komisyon_orani = $("#komisyon_orani").val();
            komisyon_orani = komisyon_orani.replace(/\./g, "").replace(",", ".");
            komisyon_orani = parseFloat(komisyon_orani);
            let cari_id = $("#pos_cari_kodu").attr("data-id");
            if (banka_id == "") {
                Swal.fire(
                    'Uyarı!',
                    'Banka Boş Kalamaz Lütfen Bir Banka Seçiniz...',
                    'warning'
                );
            } else if (cari_id == "" || cari_id == undefined) {
                Swal.fire(
                    'Uyarı!',
                    'Cari Boş Kalamaz Lütfen Bir Cari Seçiniz...',
                    'warning'
                );
            } else {
                $.ajax({
                    url: "controller/pos_controller/sql.php?islem=pos_guncelle_sql",
                    type: "POST",
                    data: {
                        banka_id: banka_id,
                        vade_gunu: vade_gunu,
                        id: "<?=$_GET["id"]?>",
                        komisyon_orani: komisyon_orani,
                        cari_id: cari_id
                    },
                    success: function (result) {
                        if (result == 1) {
                            Swal.fire(
                                'Başarılı',
                                'POS Hesabı Başarıyla Güncellendi',
                                'success'
                            );
                            $("#pos_tanim_main_modal").modal("hide");
                            $.get("view/pos_hesap_tanim.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                            $.get("view/pos_hesap_tanim.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                        } else {
                            Swal.fire(
                                'Oops!',
                                'Bilinmeyen Bir Hata Oluştu',
                                'error'
                            );
                            $("#pos_tanim_main_modal").modal("hide");
                        }
                    }
                })
            }
        });

        $(document).ready(function () {
            $("#pos_tanim_main_modal").modal("show");
            $.get("controller/pos_controller/sql.php?islem=pos_tanim_bankalar_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#pos_tanim_bankalar").append("" +
                            "<option value='" + item.id + "'>" + item.banka_adi + "</option>" +
                            "");
                    });
                }
            })
            $.get("controller/pos_controller/sql.php?islem=secilen_pos_bilgilerini_getir_sql", {id: "<?=$_GET["id"]?>"}, function (response) {
                if (response != 2) {
                    var item = JSON.parse(response);
                    $("#pos_tanim_bankalar").val(item.banka_id);
                    let vade_gun = item.vade_gunu;
                    vade_gun = parseFloat(vade_gun);
                    vade_gun = vade_gun.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    let komisyon = item.komisyon_orani;
                    komisyon = parseFloat(komisyon);
                    komisyon = komisyon.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                    $("#vade_gunu").val(vade_gun);
                    $("#komisyon_orani").val(komisyon);
                    $("#pos_cari_kodu").attr("data-id", item.cari_id);
                    $("#pos_cari_kodu").val(item.cari_kodu);
                    $("#pos_cari_adi").val(item.cari_adi);
                    $("#hesap_adi").val(item.hesap_adi);
                    $("#sube_adi").val(item.sube_adi);
                    $("#iban_no").val(item.iban_no);
                }
            })
        });

        $("body").off("change", "#pos_tanim_bankalar").on("change", "#pos_tanim_bankalar", function () {
            let id = $(this).val();
            $.get("controller/pos_controller/sql.php?islem=secilen_banka_bilgilerini_getir_sql", {id: id}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#hesap_adi").val(item.hesap_adi);
                    $("#sube_adi").val(item.sube_adi);
                    $("#iban_no").val(item.iban_no);
                }
            })
        });

        $("#pos_cari_kodu").keyup(function () {
            let val = $(this).val();
            $.get("controller/pos_controller/sql.php?islem=cari_kodu_bilgileri_getir_sql", {cari_kodu: val}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#pos_cari_kodu").val(item.cari_kodu);
                    $("#pos_cari_kodu").attr("data-id", item.id);
                    $("#pos_cari_adi").val(item.cari_adi);
                }
            })
        });

        $("body").off("click", "#pos_tanim_vazgec").on("click", "#pos_tanim_vazgec", function () {
            $("#pos_tanim_main_modal").modal("hide");
        });

        $("body").off("click", "#cari_bilgileri_getir_pos_button").on("click", "#cari_bilgileri_getir_pos_button", function () {
            $.get("modals/pos_modal/modal_page.php?islem=pos_icin_carileri_getir", function (getModal) {
                $(".pos_icin_cari_getir_div").html("");
                $(".pos_icin_cari_getir_div").html(getModal);
            })
        });


    </script>
    <?php
}
if ($islem == "pos_icin_carileri_getir") {
    ?>
    <div class="modal fade" id="pos_cari_liste_modal_getir"

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
            $("#pos_cari_liste_modal_getir").modal("hide");
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
            $("#pos_cari_liste_modal_getir").modal("show");

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
            $("#pos_cari_liste_modal_getir").modal("hide");
            $.get("controller/alis_controller/sql.php?islem=secilen_cari_bilgileri", {id: id}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#pos_cari_adi").val(item.cari_adi);
                    $("#pos_cari_kodu").val(item.cari_kodu);
                    $("#pos_cari_kodu").attr("data-id", item.id);
                }
            });
        })
    </script>
    <?php
}