<?php

$islem = $_GET["islem"];

if ($islem == "kredi_kartini_ode_modal") {
    ?>
    <div class="modal fade" id="tahsil_edilecek_pos_islemleri"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 45%; max-width: 45%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2" style="font-weight: bold">KREDİ KARTINA ÖDEME
                    <button type="button" class="btn-close btn-close-white" id="tahsil_modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="banka_adlari"></div>
                    <div class="mt-2"></div>
                    <div class="col-12 row">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label>Hesap Kodu</label>
                            </div>
                            <div class="col-md-7">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm secilen_banka" id="banka_id"
                                           placeholder="Ödeyecek Hesap...">
                                    <div class="input-group-append">
                                        <button class="btn btn-warning btn-sm" id="banka_adi_button"><i
                                                    class="fa fa-ellipsis-h"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label>Hesap Adı</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control form-control-sm banka_adi_getir" disabled
                                       placeholder="Hesap Adı...">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label>Kredi Kartı</label>
                            </div>
                            <div class="col-md-7">
                                <select class="custom-select custom-select-sm" id="kredi_karti_id">
                                    <option value="">Banka Seçiniz...</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label>İşlem Tarihi</label>
                            </div>
                            <div class="col-md-7">
                                <input id="islem_tarihi" type="date" class="form-control form-control-sm"
                                       value="<?= date("Y-m-d") ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label>Tutar</label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" class="form-control form-control-sm" style="text-align: right"
                                       id="odenen_tutar">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label>Açıklama</label>
                            </div>
                            <div class="col-md-7">
                                <input id="pos_tahsil_aciklama" placeholder="Açıklama" type="text"
                                       class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-sm" id="tahsil_modal_kapat"><i class="fa fa-close"></i> Kapat
                    </button>
                    <button class="btn btn-success btn-sm" id="secilenleri_kredi_kartindan_ode"><i
                                class="fa fa-check"></i> Kaydet
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("body").off("click", "#banka_adi_button").on("click", "#banka_adi_button", function () {
            $.get("modals/ekstre_modal.php?islem=bankalari_getir_modal", function (getModal) {
                $(".banka_adlari").html("");
                $(".banka_adlari").html(getModal);
            })
        })
        // var pos_tahsil_table = "";

        $("body").off("focusout", "#odenen_tutar").on("focusout", "#odenen_tutar", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            $(this).val(val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });

        $(document).ready(function () {
            $.get("controller/kart_controller/sql.php?islem=tanimli_kredi_kartlari", function (response) {
                if (response != 2) {
                    var json = JSON.parse(response);
                    $("#kredi_karti_id").html("");
                    $("#kredi_karti_id").append("" +
                        "<option value=''>Kredi Kartı Seçiniz...</option>" +
                        "");
                    json.forEach(function (item) {
                        $("#kredi_karti_id").append("" +
                            "<option value='" + item.id + "'>" + item.kart_adi + "</option>" +
                            "");
                    })
                }
            })
            $("#tahsil_edilecek_pos_islemleri").modal("show");
            // setTimeout(function () {
            //     $("#click125").trigger("click");
            // }, 500);
            // jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            //     "date-eu-pre": function (dateString) {
            //         var parts = dateString.split('/');
            //         return Date.parse(parts[2] + '/' + parts[1] + '/' + parts[0]) || 0;
            //     },
            //
            //     "date-eu-asc": function (a, b) {
            //         return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            //     },
            //
            //     "date-eu-desc": function (a, b) {
            //         return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            //     }
            // });
            // pos_tahsil_table = $('#tahsile_verilen_cek_senetler_list').DataTable({
            //     scrollY: '30vh',
            //     scrollX: true,
            //     "info": false,
            //     "order": [[1, 'asc']],
            //     columns: [
            //         {"data": "sec"},
            //         {"data": "taksit"},
            //         {"data": "cari_adi"},
            //         {"data": "kart_adi"},
            //         {"data": "tahsil_tarihi"},
            //         {"data": "taksit_tutari"},
            //         {"data": "aciklama"},
            //     ],
            //     createdRow: function (row) {
            //         $(row).find("td").eq(0).css("text-align", "left");
            //         $(row).find("td").eq(1).css("text-align", "left");
            //         $(row).find("td").eq(2).css("text-align", "left");
            //         $(row).find("td").eq(3).css("text-align", "left");
            //         $(row).find("td").eq(4).css("text-align", "left");
            //         $(row).find("td").eq(6).css("text-align", "left");
            //     },
            //     "rowCallback": function (row, data) {
            //         $(row).attr("kart_cekimid", data.id);
            //         $(row).attr("kart_id", data.kart_id);
            //         $(row).attr("cari_id", data.cari_id);
            //     },
            //     columnDefs: [
            //         {targets: 0, type: "date-eu"}
            //     ],
            //     "paging": false,
            //     "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
            // })
            // $.get("controller/kart_controller/sql.php?islem=odenebilir_kart_islemleri", function (result) {
            //     if (result != 2) {
            //         var json = JSON.parse(result);
            //         var basilacak_arr = [];
            //         json.forEach(function (item) {
            //
            //
            //             let tahsil_tarihi = item.tahsil_tarihi;
            //             tahsil_tarihi = tahsil_tarihi.split(" ");
            //             tahsil_tarihi = tahsil_tarihi[0];
            //             tahsil_tarihi = tahsil_tarihi.split("-");
            //             let gun1 = tahsil_tarihi[2];
            //             let ay1 = tahsil_tarihi[1];
            //             let yil1 = tahsil_tarihi[0];
            //             let arr1 = [gun1, ay1, yil1];
            //             tahsil_tarihi = arr1.join("/");
            //
            //             let tutar = item.taksit_tutari;
            //             tutar = parseFloat(tutar);
            //             tutar = tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
            //             let newRow = {
            //                 'sec': "<input type='checkbox' class='col-6 secilen_pos_islemleri' data-id='" + item.id + "'/>",
            //                 'taksit': item.taksit,
            //                 'cari_adi': item.cari_adi,
            //                 'kart_adi': item.kart_adi,
            //                 'tahsil_tarihi': tahsil_tarihi,
            //                 'taksit_tutari': tutar,
            //                 'aciklama': item.aciklama,
            //                 'cari_id': item.cari_id,
            //                 'kart_id': item.kart_id,
            //                 'id': item.id
            //             };
            //             basilacak_arr.push(newRow);
            //         });
            //         pos_tahsil_table.rows.add(basilacak_arr).draw(false);
            //     }
            // })
        })

        // $("body").off("click", ".secilen_pos_islemleri").on("click", ".secilen_pos_islemleri", function () {
        //     let closest = $(this).closest("tr");
        //     if ($(this).prop("checked")) {
        //         closest.addClass("kart_tahsil_secildi");
        //     } else {
        //         closest.removeClass("kart_tahsil_secildi");
        //     }
        //
        // });

        $("body").off("click", "#secilenleri_kredi_kartindan_ode").on("click", "#secilenleri_kredi_kartindan_ode", function () {
            let banka_id = $("#banka_id").attr("data-id");
            let islem_tarihi = $("#islem_tarihi").val();
            let tutar = $("#odenen_tutar").val();
            tutar = tutar.replace(/\./g, "").replace(",", ".");
            tutar = parseFloat(tutar);
            if (isNaN(tutar)) {
                tutar = 0;
            }
            let kart_id = $("#kredi_karti_id").val();
            let aciklama = $("#pos_tahsil_aciklama").val();

            if (banka_id == undefined || banka_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Banka Seçiniz...",
                    "warning"
                )
            }else if (kart_id == ""){
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Kredi Kartını Giriniz...",
                    "warning"
                )
            } else if (tutar == 0) {
                Swal.fire(
                    "Uyarı!",
                    "Tutar 0 Olamaz Lütfen Geçerli Bir Tutar Giriniz...",
                    "warning"
                )
            } else {
                $.ajax({
                    url: 'controller/kart_controller/sql.php?islem=kredi_kart_odeme_yap_sql',
                    type: "POST",
                    data: {
                        banka_id: banka_id,
                        islem_tarihi: islem_tarihi,
                        tutar: tutar,
                        kart_id: kart_id,
                        aciklama: aciklama
                    },
                    success: function (result) {
                        if (result == 1) {
                            Swal.fire(
                                'Başarılı',
                                'Ödeme İşlemi Başarı İle Gerçekleşti',
                                'success'
                            );
                            $.get("view/kredi_kart_odemesi.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                            $.get("view/kredi_kart_odemesi.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $("#tahsil_edilecek_pos_islemleri").modal("hide");
                        } else {
                            Swal.fire(
                                'Oops..',
                                'Bilinmeyen Bir Hata Oluştu',
                                'error'
                            );
                            $("#tahsil_edilecek_pos_islemleri").modal("hide");
                        }
                    }
                });
            }
        });

        $("body").off("click", "#tahsil_modal_kapat").on("click", "#tahsil_modal_kapat", function () {
            $("#tahsil_edilecek_pos_islemleri").modal("hide");
        });

    </script>
    <?php
}