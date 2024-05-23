<?php

$islem = $_GET["islem"];


if ($islem == "kredi_karti_tanim_modal_getir") {
    ?>
    <div class="modal fade" id="kredi_kart_tanim_main_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 65%; max-width: 65%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="kart_tanim_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>KREDİ KARTI TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="kredi_kart_icin_cari_getir_div"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Kart Kodu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="kart_kodu" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Kredi Kartı Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input id="kart_adi" type="text"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Banka Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="banka_adi">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Şube Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="sube_adi" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Hesap Kesim Günü</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input id="vade_gunu" style="text-align: right" type="text" maxlength="2"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5">
                                            <label>Kart Limiti</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" style="text-align: right" id="kart_limiti">
                                        </div>
                                    </div>
<!--                                    <div class="form-group row">-->
<!--                                        <div class="col-md-5">-->
<!--                                            <label>Komisyon Oran</label>-->
<!--                                        </div>-->
<!--                                        <div class="col-md-7">-->
<!--                                            <input type="text" id="komisyon_orani" style="text-align: right"-->
<!--                                                   class="form-control form-control-sm">-->
<!--                                        </div>-->
<!--                                    </div>-->

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger btn-sm" id="kart_tanim_vazgec"><i class="fa fa-close"></i>
                                    Vazgeç
                                </button>
                                <button class="btn btn-success btn-sm" id="kart_tanim_kaydet"><i class="fa fa-check"></i>
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
            if (miktar > 31){
                miktar = 31;
            }
            if (isNaN(miktar)){
                miktar = 0;
            }
            miktar = miktar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
            $("#vade_gunu").val(miktar);
        });

        $("#kart_limiti").focusout(function () {
            let miktar = $(this).val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            if (isNaN(miktar)){
                miktar = 0;
            }
            miktar = miktar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
            $("#kart_limiti").val(miktar);
        });

        $("#komisyon_orani").focusout(function () {
            let miktar = $(this).val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            miktar = miktar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
            $("#komisyon_orani").val(miktar);
        });

        $("body").off("click", "#kart_tanim_kaydet").on("click", "#kart_tanim_kaydet", function () {
            let kart_kodu = $("#kart_kodu").val();
            let banka_adi = $("#banka_adi").val();
            let sube_adi = $("#sube_adi").val();
            let kart_limiti = $("#kart_limiti").val();
            kart_limiti = kart_limiti.replace(/\./g, "").replace(",", ".");
            kart_limiti = parseFloat(kart_limiti);
            let vade_gunu = $("#vade_gunu").val();
            let kart_adi = $("#kart_adi").val();
            // let komisyon_orani = $("#komisyon_orani").val();
            let cari_id = $("#kart_cari_kodu").attr("data-id");
            $.ajax({
                url: "controller/kart_controller/sql.php?islem=yeni_kart_kaydet_sql",
                type: "POST",
                data: {
                    kart_adi: kart_adi,
                    kart_kodu: kart_kodu,
                    kart_limiti: kart_limiti,
                    sube_adi: sube_adi,
                    banka_adi: banka_adi,
                    hesap_kesim_gun: vade_gunu
                },
                success: function (result) {
                    if (result == 1) {
                        Swal.fire(
                            'Başarılı',
                            'Kredi Kartı Başarıyla Oluşturuldu',
                            'success'
                        );
                        $("#kredi_kart_tanim_main_modal").modal("hide");
                        $.get("view/kredi_karti_tanimla.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                        $.get("view/kredi_karti_tanimla.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                    }else if (result == 300){
                        Swal.fire(
                            'Uyarı!',
                            'Bu Kart Zaten Tanımlı',
                            'warning'
                        );
                    } else {
                        Swal.fire(
                            'Oops!',
                            'Bilinmeyen Bir Hata Oluştu',
                            'error'
                        );
                        $("#kredi_kart_tanim_main_modal").modal("hide");
                    }
                }
            })
        });

        $(document).ready(function () {
            $("#kredi_kart_tanim_main_modal").modal("show");
            $.get("controller/pos_controller/sql.php?islem=pos_tanim_bankalar_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#kart_tanim_bankalar").append("" +
                            "<option value='" + item.id + "'>" + item.banka_adi + "</option>" +
                            "");
                    });
                }
            })
        });

        $("body").off("change", "#kart_tanim_bankalar").on("change", "#kart_tanim_bankalar", function () {
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

        $("#kart_cari_kodu").keyup(function () {
            let val = $(this).val();
            $.get("controller/pos_controller/sql.php?islem=cari_kodu_bilgileri_getir_sql", {cari_kodu: val}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#kart_cari_kodu").val(item.cari_kodu)
                    $("#kart_cari_kodu").attr("data-id", item.id)
                    $("#kart_cari_adi").val(item.cari_adi);
                }else {
                    $("#kart_cari_kodu").attr("data-id", "")
                    $("#kart_cari_adi").val("");
                }
            })
        });

        $("body").off("click", "#kart_tanim_vazgec").on("click", "#kart_tanim_vazgec", function () {
            $("#kredi_kart_tanim_main_modal").modal("hide");
        });

        $("body").off("click", "#cari_bilgileri_getir_kart_button").on("click", "#cari_bilgileri_getir_kart_button", function () {
            $.get("modals/kredi_kart_modal/modal.php?islem=kart_icin_carileri_getir", function (getModal) {
                $(".kredi_kart_icin_cari_getir_div").html("");
                $(".kredi_kart_icin_cari_getir_div").html(getModal);
            })
        });


    </script>
    <?php
}
if ($islem == "kart_icin_carileri_getir") {
    ?>
    <div class="modal fade" id="kart_cari_liste_modal_getir"

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
            $("#kart_cari_liste_modal_getir").modal("hide");
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
            $("#kart_cari_liste_modal_getir").modal("show");

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
            $("#kart_cari_liste_modal_getir").modal("hide");
            $.get("controller/alis_controller/sql.php?islem=secilen_cari_bilgileri", {id: id}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#kart_cari_adi").val(item.cari_adi);
                    $("#kart_cari_kodu").val(item.cari_kodu);
                    $("#kart_cari_kodu").attr("data-id", item.id);
                }
            });
        })
    </script>
    <?php
}