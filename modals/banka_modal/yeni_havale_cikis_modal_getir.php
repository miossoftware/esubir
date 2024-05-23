<?php

$islem = $_GET["islem"];


if ($islem == "yeni_havale_cikis_modal_getir") {
    ?>
    <style>
        #banka_havale_cikis_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="banka_havale_cikis_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
    <div class="modal-dialog" style="width: 75%; max-width: 75%;">
        <div class="modal-content">
            <div class="modal-header text-white p-2">Banka Havale Çıkış
                <button type="button" class="btn-close btn-close-white" id="cikis_vazgec"
                        aria-label="Close"></button>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head" style='background-color:#9DB2BF'>
                        <div class="ibox-title" style='color:white; font-weight:bold;'>BANKA HAVALE ÇIKIŞ</div>
                    </div>
                    <div class="modal-body">
                        <div class="havale_giris_cari_listesi_div"></div>
                        <div class="col-12 row mt-2 no-gutters">
                            <div class="col-md-1">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;Banka
                                    Adı</label>
                                <select class="custom-select custom-select-sm" id="banka_adlari">
                                    <option value="">Seçiniz...</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hesap
                                    No</label>
                                <input type="text" class="form-control form-control-sm" disabled id="hesap_no">
                            </div>
                            <div class="col-md-1">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Belge
                                    No</label>
                                <input type="text" class="form-control form-control-sm" id="belge_no">
                            </div>
                            <div class="col-md-1">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;İşlem
                                    Tarihi</label>
                                <input type="date" value="<?= date("Y-m-d") ?>" class="form-control form-control-sm"
                                       id="islem_tarihi">
                            </div>
                            <div class="col-md-2">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Açıklama</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Açıklama"
                                       id="ust_aciklama">
                            </div>
                        </div>
                        <div class="col-12 row mt-2 no-gutters">
                            <div class="col-md-2">
                                <label style="font-weight: bold;font-size: 10px">Cari Kodu</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" id="cari_kodu_getir"
                                           placeholder="Cari Kodu">
                                    <div class="input-group-append">
                                        <button class="btn btn-warning btn-sm"
                                                id="havel_giris_cari_kodu">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 mx-2">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cari
                                    Adı</label>
                                <input type="text" class="form-control form-control-sm" disabled placeholder="Cari Adı"
                                       id="cari_adi">
                            </div>
                            <div class="col-md-1 mx-2">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tutar</label>
                                <input type="text" class="form-control form-control-sm tahsilat_guncelle_tutar"
                                       id="giris_tutar"
                                       placeholder="Tutar">
                            </div>
                            <div class="col-md-2">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Açıklama</label>
                                <input type="text" class="form-control form-control-sm" id="alt_aciklama"
                                       placeholder="Açıklama">
                            </div>
                            <div class="col-md-2 mt-4 row">
                                <button style="width: 100% !important;"
                                        class="btn btn-success btn-sm mx-5" id="havale_giris_ekle"><i
                                            class="fa fa-plus"></i> Ekle
                                </button>
                                <button style="background-color: #F6FA70;width: 100% !important;"
                                        class="btn btn-sm mx-5 mt-1"
                                        id="cikis_kaydi_guncelle"><i
                                            class="fa fa-refresh"></i> Kaydı Güncelle
                                </button>
                            </div>
                        </div>
                        <div class="col-12 row mt-2">
                            <table class="table table-sm table-bordered w-100 display nowrap"
                                   style="cursor:pointer;font-size: 13px;"
                                   id="banka_havale_list">
                                <thead>
                                <tr>
                                    <th id="clickbait4">Cari Kodu</th>
                                    <th>Cari Adı</th>
                                    <th>Açıklama</th>
                                    <th>Tutar</th>
                                    <th>İşlem</th>
                                </tr>
                                </thead>
                                <tfoot style="background-color: white">
                                <th></th>
                                <th></th>
                                <th style="text-align: right">TOPLAM:</th>
                                <th class="toplam_havale_cikis" style="text-align: right">0,00</th>
                                <th></th>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-sm" id="cikis_vazgec"><i class="fa fa-close"></i>
                        Vazgeç
                    </button>
                    <button class="btn btn-success btn-sm" id="havale_giris_kaydet"><i class="fa fa-plus"></i>
                        Kaydet
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('input').click(function () {
            $(this).select();
        });
        $("body").off("click", "#cikis_vazgec").on("click", "#cikis_vazgec", function () {
            let tahsilat_id = $("#havale_giris_ekle").attr("data-id");
            if (tahsilat_id != "") {
                $.ajax({
                    url: 'controller/banka_controller/sql.php?islem=cikis_iptal_et_sql',
                    type: "POST",
                    data: {
                        id: tahsilat_id
                    },
                    success: function (result) {
                        if (result == 1) {
                            $("#banka_havale_cikis_modal").modal("hide");
                        } else {
                            $("#banka_havale_cikis_modal").modal("hide");
                        }
                    }
                });
            } else {
                $("#banka_havale_cikis_modal").modal("hide");
            }
        })

        var table = "";
        $("body").off("click", ".havale_cikis_selected").on("click", ".havale_cikis_selected", function () {
            var id = $(this).attr("data-id");
            var cari_id = $(this).attr("cari");
            var cari_kodu = $(this).find('td').eq(0).text();
            var cari_adi = $(this).find('td').eq(1).text();
            var aciklama = $(this).find('td').eq(2).text();
            var tutar = $(this).find('td').eq(3).text();
            $("#cikis_kaydi_guncelle").attr("data-id", id);
            $("#cari_kodu_getir").val(cari_kodu);
            $("#cari_kodu_getir").attr("data-id", cari_id);
            $("#cari_adi_getir").val(cari_adi);
            $("#alt_aciklama").val(aciklama);
            $("#giris_tutar").val(tutar);
        });

        $(document).ready(function () {
            setTimeout(function () {
                $("#clickbait4").trigger("click");
            }, 500);
            $("#banka_havale_cikis_modal").modal("show");

            table = $('#banka_havale_list').DataTable({
                scrollY: '35vh',
                scrollX: true,
                searching: false,
                "info": false,
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row) {
                    $(row).addClass("havale_cikis_selected");
                    $(row).find("td").eq(0).css("text-align", "left");
                    $(row).find("td").eq(1).css("text-align", "left");
                    $(row).find("td").eq(2).css("text-align", "left");
                }
            })


            $.get("controller/banka_controller/sql.php?islem=havale_giris_bankalari_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#banka_adlari").append("" +
                            "<option data-name='" + item.hesap_no + "' value='" + item.id + "'>" + item.banka_adi + "</option>" +
                            "");
                    })
                }
            })
        })
        $("body").off("click", "#havale_giris_kaydet").on("click", "#havale_giris_kaydet", function () {
            var id = $("#havale_giris_ekle").attr("data-id");
            var aciklama = $("#ust_aciklama").val();
            var belge_no = $("#belge_no").val();
            var islem_tarihi = $("#islem_tarihi").val();

            $.ajax({
                url: "controller/banka_controller/sql.php?islem=havale_cikis_kaydet",
                type: "POST",
                data: {
                    id: id,
                    aciklama: aciklama,
                    belge_no: belge_no,
                    islem_tarihi: islem_tarihi
                },
                success: function (result) {
                    if (result == 1) {
                        $("#banka_havale_cikis_modal").modal("hide");
                        $.get("view/havale_cikis.php", function (getList) {
                            $(".admin-modal-icerik").html(getList);
                        });
                        $.get("view/havale_cikis.php", function (getList) {
                            $(".modal-icerik").html(getList);
                        });
                    } else {
                        $("#banka_havale_cikis_modal").modal("hide");
                    }
                }
            });
        });

        $("body").off("click", "#cikis_kaydi_guncelle").on("click", "#cikis_kaydi_guncelle", function () {
            var id = $(this).attr("data-id");
            $.ajax({
                url: "controller/banka_controller/sql.php?islem=banka_cikis_kaydi_sil_sql",
                type: "POST",
                data: {
                    id: id
                },
                success: function (result) {
                    if (result == 1) {
                        let banka_id = $("#banka_adlari").val();
                        let cari_id = $("#cari_kodu_getir").attr("data-id");
                        let giris_tutar = $("#giris_tutar").val();
                        giris_tutar = giris_tutar.replace(/\./g, "").replace(",", ".");
                        giris_tutar = parseFloat(giris_tutar);
                        let aciklama = $("#alt_aciklama").val();
                        let giris_id = $("#havale_giris_ekle").attr("data-id");
                        if (banka_id == "" || cari_id == undefined) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'warning',
                                title: 'Banka Veya Cari Boş Kalamaz'
                            });
                        } else if (giris_tutar == 0 || isNaN(giris_tutar)) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'warning',
                                title: 'Tutar 0 Olamaz'
                            });
                        } else {
                            $.ajax({
                                url: "controller/banka_controller/sql.php?islem=havale_cikis_ekle_sql",
                                type: "POST",
                                data: {
                                    banka_id: banka_id,
                                    cari_id: cari_id,
                                    cikis_tutar: giris_tutar,
                                    aciklama: aciklama,
                                    cikis_id: giris_id
                                },
                                success: function (result) {
                                    if (result != 2) {

                                        let toplam_tutar = 0;
                                        table.clear().draw(false);
                                        var json = JSON.parse(result);
                                        json.forEach(function (item) {
                                            var tutar = item.cikis_tutar;
                                            tutar = parseFloat(tutar);
                                            toplam_tutar += tutar;
                                            tutar = tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                                            toplam_tutar = parseFloat(toplam_tutar);
                                            $(".toplam_havale_cikis").html(toplam_tutar.toLocaleString("tr-TR", {
                                                maximumFractionDigits: 2,
                                                minimumFractionDigits: 2
                                            }));
                                            var tahsilat_id = table.row.add([item.cari_kodu, item.cari_adi, item.aciklama, tutar, "<button class='btn btn-danger havale_cikis_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button"]).draw(false).node();
                                            $(tahsilat_id).attr("data-id", item.id);
                                            $(tahsilat_id).attr("cari", item.cari_id);
                                            $("#giris_kaydi_guncelle").attr("data-id", "");
                                            $("#havale_giris_ekle").attr("data-id", item.cikis_id)
                                            $("#cari_kodu_getir").val("");
                                            $("#cari_kodu_getir").attr("data-id", "");
                                            $("#cari_adi_getir").val("");
                                            $("#alt_aciklama").val("");
                                            $("#giris_tutar").val("");
                                        })
                                    }
                                }
                            });
                        }
                    }
                }
            });
        })

        $("#cari_kodu_getir").keyup(function () {
            var cari_kodu = $(this).val();
            $.get("controller/banka_controller/sql.php?islem=girilen_cari_kodu_bilgileri", {cari_kodu: cari_kodu}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#cari_kodu_getir").attr("data-id", item.id);
                    $("#cari_adi").val(item.cari_adi);
                    $("#cari_kodu_getir").val(item.cari_kodu);
                } else {

                    $("#cari_kodu_getir").attr("data-id", "");
                    $("#cari_adi").val("");
                }
            })
        })

        $("body").off("click", "#havale_giris_ekle").on("click", "#havale_giris_ekle", function () {
            let banka_id = $("#banka_adlari").val();
            let cari_id = $("#cari_kodu_getir").attr("data-id");
            let giris_tutar = $("#giris_tutar").val();
            giris_tutar = giris_tutar.replace(/\./g, "").replace(",", ".");
            giris_tutar = parseFloat(giris_tutar);
            let aciklama = $("#alt_aciklama").val();
            let giris_id = $("#havale_giris_ekle").attr("data-id");
            if (banka_id == "" || cari_id == undefined) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'warning',
                    title: 'Banka Veya Cari Boş Kalamaz'
                });
            } else if (giris_tutar == 0 || isNaN(giris_tutar)) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    icon: 'warning',
                    title: 'Tutar 0 Olamaz'
                });
            } else {
                $.ajax({
                    url: "controller/banka_controller/sql.php?islem=havale_cikis_ekle_sql",
                    type: "POST",
                    data: {
                        banka_id: banka_id,
                        cari_id: cari_id,
                        cikis_tutar: giris_tutar,
                        aciklama: aciklama,
                        cikis_id: giris_id
                    },
                    success: function (result) {
                        if (result != 2) {
                            table.clear().draw(false);
                            var json = JSON.parse(result);
                            let toplam_tutar = 0;
                            json.forEach(function (item) {
                                var tutar = item.cikis_tutar;
                                tutar = parseFloat(tutar);
                                toplam_tutar += tutar;
                                tutar = tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                                toplam_tutar = parseFloat(toplam_tutar);
                                $(".toplam_havale_cikis").html(toplam_tutar.toLocaleString("tr-TR", {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }));
                                var tahsilat_id = table.row.add([item.cari_kodu, item.cari_adi, item.aciklama, tutar, "<button class='btn btn-danger havale_cikis_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button"]).draw(false).node();
                                $(tahsilat_id).attr("data-id", item.id);
                                $(tahsilat_id).attr("cari", item.cari_id);
                                $("#giris_kaydi_guncelle").attr("data-id", "");
                                $("#havale_giris_ekle").attr("data-id", item.cikis_id)
                                $("#cari_kodu_getir").val("");
                                $("#cari_kodu_getir").attr("data-id", "");
                                $("#cari_adi_getir").val("");
                                $("#alt_aciklama").val("");
                                $("#giris_tutar").val("");
                            })
                        }
                    }
                });
            }
        });

        $("body").off("click", ".havale_cikis_sil").on("click", ".havale_cikis_sil", function () {
            var id = $(this).attr("data-id");
            var row = $(this).closest('tr');
            $.ajax({
                url: "controller/banka_controller/sql.php?islem=banka_cikis_kaydi_sil_sql",
                type: "POST",
                data: {
                    id: id
                },
                success: function (result) {
                    if (result == 1) {
                        table.row(row).remove().draw(false);
                        let toplam_tutar = 0;
                        $(".havale_cikis_selected").each(function () {
                            let tutar = $(this).find("td").eq(3).html();
                            tutar = tutar.replace(/\./g, "").replace(",", ".");
                            tutar = parseFloat(tutar);
                            toplam_tutar += tutar;
                        });
                        toplam_tutar = parseFloat(toplam_tutar);
                        $(".toplam_havale_cikis").html(toplam_tutar.toLocaleString("tr-TR", {
                            maximumFractionDigits: 2,
                            minimumFractionDigits: 2
                        }));
                    }
                }
            });
        });

        $("#giris_tutar").focusout(function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2})
            $("#giris_tutar").val(val);
        });

        $("body").off("click", "#havel_giris_cari_kodu").on("click", "#havel_giris_cari_kodu", function () {
            $.get("modals/banka_modal/havale_giris_modal.php?islem=cari_listesi_getir_modal", function (getModal) {
                $(".havale_giris_cari_listesi_div").html("");
                $(".havale_giris_cari_listesi_div").html(getModal);
            })
        });

        $("body").off("change", "#banka_adlari").on("change", "#banka_adlari", function () {
            let hesap_no = $("#banka_adlari option:selected").attr("data-name");
            $("#hesap_no").val(hesap_no);
        });


    </script>
    <?php
}