<?php

$islem = $_GET["islem"];

if ($islem == "yeni_acilis_fisi_ekle") {
    ?>

    <div class="modal fade" id="banka_acilis_fisi_modal" data-bs-keyboard="false"
    role="dialog">
    <div class="modal-dialog" style="width: 75%; max-width: 75%;">
        <div class="modal-content">
            <div class="modal-header text-white p-2">
                <button type="button" class="btn-close btn-close-white" id="banka_acilis_vazgec"
                        aria-label="Close"></button>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head" style='background-color:#9DB2BF'>
                        <div class="ibox-title" style='color:white; font-weight:bold;'>BANKA AÇILIŞ FİŞİ</div>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 row no-gutters mx-3">
                            <div class="col-md-2">
                                <label style="font-weight: bold;font-size: 10px">Banka Adı</label>
                                <select class="custom-select custom-select-sm banka_ids" id="banka_adlari">
                                    <option value="">Seçiniz...</option>
                                </select>
                            </div>
                            <div class="col-md-2 mx-2">
                                <label style="font-weight: bold;font-size: 10px">Yatan Tutar</label>
                                <input type="text" class="form-control form-control-sm" id="yatan_tutar"
                                       value="0,00">
                            </div>
                            <div class="col-md-2 mx-2">
                                <label style="font-weight: bold;font-size: 10px">Çekilen Tutar</label>
                                <input type="text" class="form-control form-control-sm" id="cekilen_tutar"
                                       value="0,00">
                            </div>
                            <div class="col-md-1">
                                <label style="font-weight: bold;font-size: 10px">Açılış Tarihi</label>
                                <input type="date" class="form-control form-control-sm" id="banka_acilis_tarihi"
                                       value="<?= date("Y-m-d") ?>">
                            </div>
                            <div class="col-md-2 mx-2">
                                <label style="font-weight: bold;font-size: 10px">Açıklama</label>
                                <input type="text" class="form-control form-control-sm" id="aciklama">
                            </div>
                            <div class="col-md-2 mt-2 row">
                                <button style="width: 100% !important;"
                                        class="btn btn-success btn-sm mx-5" id="banka_acilis_ekle"><i
                                            class="fa fa-plus"></i> Ekle
                                </button>
                                <button style="background-color: #F6FA70;width: 100% !important;"
                                        class="btn btn-sm mx-5 mt-1"
                                        id="banka_acilis_kaydi_guncelle"><i
                                            class="fa fa-refresh"></i> Kaydı Güncelle
                                </button>
                            </div>
                        </div>
                        <div class="col-12">
                            <table class="table table-sm table-bordered w-100 display nowrap"
                                   style="cursor:pointer;font-size: 13px;"
                                   id="banka_acilis_table_icerik">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th id="acilis2">Banka Adı</th>
                                    <th>Banka Kodu</th>
                                    <th>Yatan Tutar</th>
                                    <th>Çekilen Tutar</th>
                                    <th>Açıklama</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-12 row">
                        <div class="col-md-1">
                            <button class="btn btn-danger btn-sm" id="banka_acilis_vazgec"><i
                                        class="fa fa-close"></i>
                                Vazgeç
                            </button>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-success btn-sm" id="banka_acilislari_kaydet"><i
                                        class="fa fa-plus"></i> Kaydet
                            </button>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-danger btn-sm" id="secilen_banka_acilis_sil"><i
                                        class="fa fa-minus-square"></i> Seçilenleri Sil
                            </button>
                        </div>
                        <div class="col-md-1 mx-4">
                            <button class="btn btn-danger btn-sm" id="banka_acilislarin_hepsini_sil"><i
                                        class="fa fa-trash"></i> Açılışları Sil
                            </button>
                        </div>
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
        $(document).ready(function () {
            $("#banka_acilis_fisi_modal").modal("show");
            setTimeout(function () {
                $("#acilis2").trigger("click");
            }, 500);
            table = $('#banka_acilis_table_icerik').DataTable({
                scrollY: '55vh',
                scrollX: true,
                searching: false,
                "info": false,
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row) {
                    $(row).addClass("banka_acilis_select");
                }
            });

            $.get("controller/banka_controller/sql.php?islem=bankalari_getir", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#banka_adlari").append("" +
                            "<option value='" + item.id + "'>" + item.banka_adi + "</option>" +
                            "")
                    })
                }
            })
        })

        $("body").off("click", ".banka_acilis_select").on("click", ".banka_acilis_select", function () {
            var id = $(this).attr("data-id");
            $("#banka_acilis_kaydi_guncelle").attr("data-id", id);
            $(".banka_acilis_select").removeClass("banka_acilis_sil_selected")
            $(this).addClass("banka_acilis_sil_selected")
            $.get("controller/banka_controller/sql.php?islem=acilis_bilgileri_getir", {id: id}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);

                    var cekilen_tutar = item.cekilen_tutar;
                    cekilen_tutar = parseFloat(cekilen_tutar);
                    cekilen_tutar = cekilen_tutar.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2,
                    })
                    var yatan_tutar = item.yatan_tutar;
                    yatan_tutar = parseFloat(yatan_tutar);
                    yatan_tutar = yatan_tutar.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })
                    $("#banka_adlari").val(item.banka_id);
                    $("#yatan_tutar").val(yatan_tutar);
                    $("#cekilen_tutar").val(cekilen_tutar);
                    $("#aciklama").val(item.aciklama);
                }
            })
        });

        $("body").off("click", "#banka_acilislari_kaydet").on("click", "#banka_acilislari_kaydet", function () {
            $("#banka_acilis_fisi_modal").modal("hide");
            var arr = [];
            $(".banka_acilis_select").each(function () {
                let id = $(this).attr("data-id");
                arr.push(id);
            })
            if (arr.length === 0) {
                $.get("view/banka_acilis_fisi.php", function (getList) {
                    $(".admin-modal-icerik").html("");
                    $(".admin-modal-icerik").html(getList);
                });
                $.get("view/banka_acilis_fisi.php", function (getList) {
                    $(".modal-icerik").html("");
                    $(".modal-icerik").html(getList);
                });
            } else {
                Swal.fire(
                    'Başarılı!',
                    'Açılış Fişleri Kaydedildi',
                    'success'
                );
                $.get("view/banka_acilis_fisi.php", function (getList) {
                    $(".admin-modal-icerik").html("");
                    $(".admin-modal-icerik").html(getList);
                });
                $.get("view/banka_acilis_fisi.php", function (getList) {
                    $(".modal-icerik").html("");
                    $(".modal-icerik").html(getList);
                });
            }
        })

        $("body").off("click", "#banka_acilis_kaydi_guncelle").on("click", "#banka_acilis_kaydi_guncelle", function () {
            var id = $(this).attr("data-id");
            var arr = [];
            arr.push(id);
            var rows = table.rows().nodes();
            $.ajax({
                url: "controller/banka_controller/sql.php?islem=secilen_acilislari_sil_sql",
                type: "POST",
                data: {
                    id: arr
                },
                success: function (result) {
                    if (result == 1) {
                        $(rows).each(function () {
                            if ($(this).hasClass('banka_acilis_sil_selected')) {
                                table.row(this).remove().draw();
                            }
                        })
                        var banka_id = $("#banka_adlari").val();
                        var yatan_tutar = $("#yatan_tutar").val();
                        var acilis_tarih = $("#banka_acilis_tarihi").val();
                        yatan_tutar = yatan_tutar.replace(/\./g, "").replace(",", ".");
                        yatan_tutar = parseFloat(yatan_tutar);
                        var cekilen_tutar = $("#cekilen_tutar").val();
                        cekilen_tutar = cekilen_tutar.replace(/\./g, "").replace(",", ".");
                        cekilen_tutar = parseFloat(cekilen_tutar);
                        var aciklama = $("#aciklama").val();
                        if (isNaN(yatan_tutar)) {
                            yatan_tutar = 0;
                        }
                        if (isNaN(cekilen_tutar)) {
                            cekilen_tutar = 0;
                        }
                        if (banka_id == "" && (yatan_tutar == "0" || cekilen_tutar == "0")) {

                        } else {
                            $.ajax({
                                url: "controller/banka_controller/sql.php?islem=banka_acilis_fisi_ekle_sql",
                                type: "POST",
                                data: {
                                    banka_id: banka_id,
                                    yatan_tutar: yatan_tutar,
                                    cekilen_tutar: cekilen_tutar,
                                    acilis_tarih: acilis_tarih,
                                    aciklama: aciklama
                                },
                                success: function (result) {
                                    if (result != 2) {
                                        var item = JSON.parse(result);
                                        let yatan = item.yatan_tutar;
                                        let cekilen = item.cekilen_tutar;
                                        yatan = parseFloat(yatan);
                                        cekilen = parseFloat(cekilen);
                                        yatan = yatan.toLocaleString("tr-TR", {
                                            maximumFractionDigits: 2,
                                            minimumFractionDigits: 2
                                        });
                                        cekilen = cekilen.toLocaleString("tr-TR", {
                                            minimumFractionDigits: 2,
                                            maximumFractionDigits: 2
                                        })


                                        let new_row = table.row.add(["<input type='checkbox' class='eklenen_acilislar' />", item.banka_adi, item.banka_kodu, yatan, cekilen, item.aciklama]).draw(false).node();
                                        $(new_row).attr("data-id", item.id);
                                        $(new_row).find('td').eq(1).css('text-align', 'left');
                                        $(new_row).find('td').eq(2).css('text-align', 'left');
                                        $(new_row).find('td').eq(5).css('text-align', 'left');
                                        $("#banka_adlari,#aciklama").val("");
                                        $("#yatan_tutar").val("0,00");
                                        $("#cekilen_tutar").val("0,00");
                                    }
                                }
                            })
                        }
                    }
                }
            })
        });

        $("body").off("click", "#banka_acilis_ekle").on("click", "#banka_acilis_ekle", function () {
            var banka_id = $(".banka_ids").val();
            var yatan_tutar = $("#yatan_tutar").val();
            var acilis_tarih = $("#banka_acilis_tarihi").val();
            yatan_tutar = yatan_tutar.replace(/\./g, "").replace(",", ".");
            yatan_tutar = parseFloat(yatan_tutar);
            var cekilen_tutar = $("#cekilen_tutar").val();
            cekilen_tutar = cekilen_tutar.replace(/\./g, "").replace(",", ".");
            cekilen_tutar = parseFloat(cekilen_tutar);
            if (isNaN(cekilen_tutar)) {
                cekilen_tutar = 0;
            }
            if (isNaN(yatan_tutar)) {
                yatan_tutar = 0;
            }
            var aciklama = $("#aciklama").val();
            if (banka_id == "" || (yatan_tutar == "0" && cekilen_tutar == "0")) {

            } else {
                $.ajax({
                    url: "controller/banka_controller/sql.php?islem=banka_acilis_fisi_ekle_sql",
                    type: "POST",
                    data: {
                        banka_id: banka_id,
                        yatan_tutar: yatan_tutar,
                        cekilen_tutar: cekilen_tutar,
                        acilis_tarih: acilis_tarih,
                        aciklama: aciklama
                    },
                    success: function (result) {
                        if (result != 2) {
                            var item = JSON.parse(result);
                            let yatan_bastir = item.yatan_tutar;
                            yatan_bastir = parseFloat(yatan_bastir);
                            yatan_bastir = yatan_bastir.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            let cekilenTutar = item.cekilen_tutar;
                            cekilenTutar = parseFloat(cekilenTutar);
                            cekilenTutar = cekilenTutar.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            let new_row = table.row.add(["<input type='checkbox' class='eklenen_acilislar' />", item.banka_adi, item.banka_kodu, yatan_bastir, cekilenTutar, item.aciklama]).draw(false).node();
                            $(new_row).attr("data-id", item.id);
                            $(new_row).find('td').eq(1).css('text-align', 'left');
                            $(new_row).find('td').eq(2).css('text-align', 'left');
                            $(new_row).find('td').eq(5).css('text-align', 'left');
                            $("#banka_adlari,#aciklama").val("");
                            $("#yatan_tutar").val("0,00");
                            $("#cekilen_tutar").val("0,00");
                        }
                    }
                })
            }
        })

        $("body").off("click", "#banka_acilislarin_hepsini_sil").on("click", "#banka_acilislarin_hepsini_sil", function () {
            var arr = [];
            var selectedRows = [];
            $(".banka_acilis_select").each(function () {
                let id = $(this).closest("tr").data("id");
                arr.push(id);
                var row = $(this).closest("tr");
                selectedRows.push(row);
            })
            $.ajax({
                url: "controller/banka_controller/sql.php?islem=secilen_acilislari_sil_sql",
                type: "POST",
                data: {
                    id: arr
                },
                success: function (result) {
                    if (result == 1) {
                        for (var i = 0; i < selectedRows.length; i++) {
                            var row = selectedRows[i];
                            table.row(row).remove().draw();
                        }
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
                            icon: 'success',
                            title: 'Silme İşlemi Başarılı'
                        });
                    } else {
                        table.clear().draw(false);
                    }
                }
            })
        })

        $("body").off("click", "#banka_acilis_vazgec").on("click", "#banka_acilis_vazgec", function () {
            var arr = [];
            var selectedRows = [];
            $(".banka_acilis_select").each(function () {
                let id = $(this).closest("tr").data("id");
                arr.push(id);
                var row = $(this).closest("tr");
                selectedRows.push(row);
            })
            $.ajax({
                url: "controller/banka_controller/sql.php?islem=secilen_acilislari_sil_sql",
                type: "POST",
                data: {
                    id: arr
                },
                success: function (result) {
                    if (result == 1) {
                        $("#banka_acilis_fisi_modal").modal("hide");
                    } else {
                        $("#banka_acilis_fisi_modal").modal("hide");
                    }
                }
            })
        })

        $("body").off("click", "#secilen_banka_acilis_sil").on("click", "#secilen_banka_acilis_sil", function () {
            var arr = [];
            var selectedRows = [];
            $(".checked_opening_bank").each(function () {
                let id = $(this).closest("tr").data("id");
                arr.push(id);
                var row = $(this).closest("tr");
                selectedRows.push(row);
            })
            $.ajax({
                url: "controller/banka_controller/sql.php?islem=secilen_acilislari_sil_sql",
                type: "POST",
                data: {
                    id: arr
                },
                success: function (result) {
                    if (result == 1) {
                        for (var i = 0; i < selectedRows.length; i++) {
                            var row = selectedRows[i];
                            table.row(row).remove().draw();
                        }
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
                            icon: 'success',
                            title: 'Silme İşlemi Başarılı'
                        });
                    }
                }
            })
        });

        $("body").off("change", ".eklenen_acilislar").on("change", ".eklenen_acilislar", function () {
            if ($(this).prop('checked')) {
                $(this).addClass("checked_opening_bank");
            } else {
                $(this).removeClass("checked_opening_bank");
            }
        });


        $("#yatan_tutar").focusout(function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2})
            $("#yatan_tutar").val(val);
        });
        $("#cekilen_tutar").focusout(function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2})
            $("#cekilen_tutar").val(val);
        });

    </script>
    <?php
}
if ($islem == "acilis_fisi_guncelle_modal") {
    ?>
      <div class="modal fade" id="banka_acilis_fisi_guncelle_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 35%; max-width: 35%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="acilis_vazgec_cari"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>BANKA AÇILIŞ FİŞİ GÜNCELLE</div>
                        </div>
                        <div class="modal-body">
                            <div id="stoklari_getir_acilis_div"></div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Banka</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="custom-select custom-select-sm banka_ids" id="banka_adlari">
                                    <option value="">Seçiniz...</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Açılış Tarihi</label>
                                </div>
                                <div class="col-md-7">
                                <input type="date" class="form-control form-control-sm" id="banka_acilis_tarihi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Yatan Tutar</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" style="text-align: right"
                                           id="yatan_tutar">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Çekilen Tutar</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" style="text-align: right"
                                           id="cekilen_tutar">
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
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="acilis_vazgec_cari"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="acilis_fisi_guncelle_button"><i
                                        class="fa fa-check"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("input").click(function () {
            $(this).select();
        });
        $(document).ready(function () {
            $.get("controller/banka_controller/sql.php?islem=bankalari_getir", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#banka_adlari").append("" +
                            "<option value='" + item.id + "'>" + item.banka_adi + "</option>" +
                            "")
                    })
                }
            })

            $("#banka_acilis_fisi_guncelle_modal").modal("show");
            $.get("controller/banka_controller/sql.php?islem=acilis_bilgilerini_getir_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    setTimeout(function (){

                    $("#banka_adlari").val(item.banka_id);
                    },500);
                    let acilis_tarihi = item.acilis_tarih;
                    if (acilis_tarihi != null){
                        acilis_tarihi = acilis_tarihi.split(" ");
                    }
                    $("#banka_acilis_tarihi").val(acilis_tarihi[0]);
                    let cekilen_tutar = item.cekilen_tutar;
                    cekilen_tutar = parseFloat(cekilen_tutar);
                    $("#cekilen_tutar").val(cekilen_tutar.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                    let yatan_tutar = item.yatan_tutar;
                    yatan_tutar = parseFloat(yatan_tutar);
                    $("#yatan_tutar").val(yatan_tutar.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                    $("#aciklama").val(item.aciklama);
                    setTimeout(function () {
                        $("#depo_id").val(item.depo_id);
                    }, 500);
                }
            })
        });
        $("body").off("focusout", "#cekilen_tutar").on("focusout", "#cekilen_tutar", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("focusout", "#yatan_tutar").on("focusout", "#yatan_tutar", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("click", "#acilis_fisi_guncelle_button").on("click", "#acilis_fisi_guncelle_button", function () {
            let cekilen_tutar = $("#cekilen_tutar").val();
            cekilen_tutar = cekilen_tutar.replace(/\./g, "").replace(",", ".");
            cekilen_tutar = parseFloat(cekilen_tutar);
            let yatan_tutar = $("#yatan_tutar").val();
            yatan_tutar = yatan_tutar.replace(/\./g, "").replace(",", ".");
            yatan_tutar = parseFloat(yatan_tutar);
            let aciklama = $("#aciklama").val();
            let acilis_tarihi = $("#banka_acilis_tarihi").val();
            let cari_id = $("#banka_adlari").val();
            if (cari_id == undefined || cari_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Banka Belirtiniz...",
                    "warning"
                );
            }else {
                $.ajax({
                    url: "controller/banka_controller/sql.php?islem=acilis_fisi_guncelle_sql",
                    type: "POST",
                    data: {
                        cekilen_tutar: cekilen_tutar,
                        yatan_tutar: yatan_tutar,
                        aciklama: aciklama,
                        banka_id: cari_id,
                        acilis_tarih: acilis_tarihi,
                        id: "<?=$_GET["id"]?>"
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Açılış Fişi Güncellendi",
                                "success"
                            );
                            $("#banka_acilis_fisi_guncelle_modal").modal("hide");
                            $.get("view/banka_acilis_fisi.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("view/banka_acilis_fisi.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }
        });

        $("body").off("click", "#acilis_vazgec_cari").on("click", "#acilis_vazgec_cari", function () {
            $("#banka_acilis_fisi_guncelle_modal").modal("hide");
        });

        $("body").off("click", "#stok_adi_getir_acilis").on("click", "#stok_adi_getir_acilis", function () {
            $.get("modals/stok_modal/modal_page.php?islem=stoklari_getir_acilis", function (getModal) {
                $("#stoklari_getir_acilis_div").html("");
                $("#stoklari_getir_acilis_div").html(getModal);
            });
        });

    </script>
    <?php
}