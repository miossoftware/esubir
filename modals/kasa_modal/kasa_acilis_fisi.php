<?php

$islem = $_GET["islem"];

if ($islem == "yeni_kasa_acilis_fisi_ekle") {
    ?>
    <div class="modal fade" id="kasa_acilis_fisi_modal" data-backdrop="static" data-bs-keyboard="false"
    role="dialog">
    <div class="modal-dialog" style="width: 75%; max-width: 75%;">
        <div class="modal-content">
            <div class="modal-header text-white p-2">Kasa Açılış Fişi
                <button type="button" class="btn-close btn-close-white" id="kasa_acilis_vazgec"
                        aria-label="Close"></button>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head" style='background-color:#9DB2BF'>
                        <div class="ibox-title" style='color:white; font-weight:bold;'>KASA AÇILIŞ FİŞİ</div>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 row no-gutters mx-3">
                            <div class="col-md-2">
                                <label style="font-weight: bold;font-size: 10px">Kasa Adı</label>
                                <select class="custom-select custom-select-sm" id="kasa_adlari">
                                    <option value="">Seçiniz...</option>
                                </select>
                            </div>
                            <div class="col-md-2 mx-2">
                                <label style="font-weight: bold;font-size: 10px">Giren Tutar</label>
                                <input type="text" class="form-control form-control-sm" id="giren_tutar"
                                       value="0,00">
                            </div>
                            <div class="col-md-2 mx-2">
                                <label style="font-weight: bold;font-size: 10px">Çıkan Tutar</label>
                                <input type="text" class="form-control form-control-sm" id="cikan_tutar"
                                       value="0,00">
                            </div>
                            <div class="col-md-1">
                                <label style="font-weight: bold;font-size: 10px">Açılış Tarihi</label>
                                <input type="date" class="form-control form-control-sm" id="kasa_acilis_tarihi"
                                       value="<?= date("Y-m-d") ?>">
                            </div>
                            <div class="col-md-2 mx-2">
                                <label style="font-weight: bold;font-size: 10px">Açıklama</label>
                                <input type="text" class="form-control form-control-sm" id="aciklama">
                            </div>
                            <div class="col-md-2 mt-2 row">
                                <button style="width: 100% !important;"
                                        class="btn btn-success btn-sm mx-5" id="kasa_acilis_fisi_ekle"><i
                                            class="fa fa-plus"></i> Ekle
                                </button>
                                <button style="background-color: #F6FA70;width: 100% !important;"
                                        class="btn btn-sm mx-5 mt-1"
                                        id="kasa_acilis_guncelle"><i
                                            class="fa fa-refresh"></i> Kaydı Güncelle
                                </button>
                            </div>
                        </div>
                        <div class="col-12">
                            <table class="table table-sm table-bordered w-100 display nowrap"
                                   style="cursor:pointer;font-size: 13px;"
                                   id="kasa_acilis_table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th id="acilis1">Kasa Adı</th>
                                    <th>Kasa Kodu</th>
                                    <th>Giren Tutar</th>
                                    <th>Çıkan Tutar</th>
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
                            <button class="btn btn-danger btn-sm" id="kasa_acilis_vazgec"><i
                                        class="fa fa-close"></i>
                                Vazgeç
                            </button>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-success btn-sm" id="acilislari_kaydet"><i
                                        class="fa fa-plus"></i> Kaydet
                            </button>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-danger btn-sm" id="secilen_kasa_acilis_sil"><i
                                        class="fa fa-minus-square"></i> Seçilenleri Sil
                            </button>
                        </div>
                        <div class="col-md-1 mx-4">
                            <button class="btn btn-danger btn-sm" id="acilislarin_hepsini_sil"><i
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

        $("body").off("click", "#acilislari_kaydet").on("click", "#acilislari_kaydet", function () {
            $("#kasa_acilis_fisi_modal").modal("hide");
            var arr = [];
            $(".acilis_selected").each(function () {
                let id = $(this).attr("data-id");
                arr.push(id);
            })
            if (arr.length === 0) {
                $.get("view/kasa_acilis_fisi.php", function (getList) {
                    $(".admin-modal-icerik").html("");
                    $(".admin-modal-icerik").html(getList);
                });
                $.get("view/kasa_acilis_fisi.php", function (getList) {
                    $(".modal-icerik").html("");
                    $(".modal-icerik").html(getList);
                });
            } else {
                Swal.fire(
                    'Başarılı!',
                    'Açılış Fişleri Kaydedildi',
                    'success'
                );
                $.get("view/kasa_acilis_fisi.php", function (getList) {
                    $(".admin-modal-icerik").html("");
                    $(".admin-modal-icerik").html(getList);
                });
                $.get("view/kasa_acilis_fisi.php", function (getList) {
                    $(".modal-icerik").html("");
                    $(".modal-icerik").html(getList);
                });
            }
        })

        $(document).ready(function () {
            $("#kasa_acilis_fisi_modal").modal("show");

            setTimeout(function () {
                $("#acilis1").trigger("click");
            }, 500);

            table = $('#kasa_acilis_table').DataTable({
                scrollY: '55vh',
                scrollX: true,
                searching: false,
                "info": false,
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row) {
                    $(row).addClass("acilis_selected");
                }
            });

            $.get("controller/kasa_controller/sql.php?islem=acilis_icin_kasalari_getir", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        var selected = "";
                        if (item.varsayilan_kasa == 1) {
                            selected = "selected";
                        }
                        $("#kasa_adlari").append("" +
                            "<option value='" + item.id + "' " + selected + ">" + item.kasa_adi + "</option>" +
                            "");
                    })
                }
            })
        });
        $("#giren_tutar").focusout(function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2})
            $("#giren_tutar").val(val);
        });

        $("body").off("click", ".acilis_selected").on("click", ".acilis_selected", function () {
            var id = $(this).attr("data-id");
            $(".acilis_selected").removeClass("remove_acilis");
            $(this).addClass("remove_acilis");
            $.get("controller/kasa_controller/sql.php?islem=secilen_kasa_acilis_bilgileri_sql", {id: id}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#kasa_adlari").val(item.kasa_id);
                    let giren = item.giren_tutar;
                    giren = parseFloat(giren);
                    giren = giren.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    })
                    let cikan = item.cikan_tutar;
                    cikan = parseFloat(cikan);
                    cikan = cikan.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })
                    $("#giren_tutar").val(giren);
                    $("#cikan_tutar").val(cikan);
                    $("#aciklama").val(item.aciklama);
                    $("#kasa_acilis_guncelle").attr("data-id", id);
                }
            })
        })

        $("body").off("click", "#kasa_acilis_guncelle").on("click", "#kasa_acilis_guncelle", function () {
            var id = $(this).attr("data-id");
            var arr = [];
            arr.push(id);
            var rows = table.rows().nodes();
            $.ajax({
                url: "controller/kasa_controller/sql.php?islem=secilen_acilislari_sil_sql",
                type: "POST",
                data: {
                    id: arr
                },
                success: function (result) {
                    if (result == 1) {
                        $(rows).each(function () {
                            if ($(this).hasClass('remove_acilis')) {
                                table.row(this).remove().draw();
                            }
                        })
                        var kasa_id = $("#kasa_adlari").val();
                        var giren_tutar = $("#giren_tutar").val();
                        giren_tutar = giren_tutar.replace(/\./g, "").replace(",", ".");
                        giren_tutar = parseFloat(giren_tutar);
                        var cikan_tutar = $("#cikan_tutar").val();
                        cikan_tutar = cikan_tutar.replace(/\./g, "").replace(",", ".");
                        cikan_tutar = parseFloat(cikan_tutar);
                        var aciklama = $("#aciklama").val();
                        $.ajax({
                            url: "controller/kasa_controller/sql.php?islem=kasa_acilis_fisi_ekle",
                            type: "POST",
                            data: {
                                kasa_id: kasa_id,
                                giren_tutar: giren_tutar,
                                cikan_tutar: cikan_tutar,
                                aciklama: aciklama
                            },
                            success: function (result) {
                                if (result != 2) {
                                    $("#kasa_adlari,#giren_tutar,#cikan_tutar,#aciklama").val("");
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
                                        title: 'Kayıt Başarılı'
                                    });
                                    var item = JSON.parse(result);
                                    let giren = item.giren_tutar;
                                    let cikan = item.cikan_tutar;
                                    giren = parseFloat(giren);
                                    giren = giren.toLocaleString("tr-TR", {
                                        maximumFractionDigits: 2,
                                        minimumFractionDigits: 2
                                    });
                                    cikan = parseFloat(cikan);
                                    cikan = cikan.toLocaleString("tr-TR", {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    });
                                    var new_row = table.row.add(["<input type='checkbox' class='secilen_acilislar'/>", item.kasa_adi, item.kasa_kodu, giren, cikan, item.aciklama]).draw(false).node();
                                    $(new_row).attr("data-id", item.id);
                                    $(new_row).find('td').eq(1).css('text-align', 'left');
                                    $(new_row).find('td').eq(2).css('text-align', 'left');
                                    $(new_row).find('td').eq(5).css('text-align', 'left');
                                }
                            }
                        })
                    }
                }
            })
        })

        $("#cikan_tutar").focusout(function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2})
            $("#cikan_tutar").val(val);
        });

        $("body").off("click", "#kasa_acilis_fisi_ekle").on("click", "#kasa_acilis_fisi_ekle", function () {
            var kasa_id = $("#kasa_adlari").val();
            var giren_tutar = $("#giren_tutar").val();
            giren_tutar = giren_tutar.replace(/\./g, "").replace(",", ".");
            giren_tutar = parseFloat(giren_tutar);
            var cikan_tutar = $("#cikan_tutar").val();
            cikan_tutar = cikan_tutar.replace(/\./g, "").replace(",", ".");
            cikan_tutar = parseFloat(cikan_tutar);
            var aciklama = $("#aciklama").val();
            var acilis_tarihi = $("#kasa_acilis_tarihi").val();

            if (kasa_id == "" || (giren_tutar == 0 && cikan_tutar == 0)) {
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
                    title: 'Giren Miktar İle Çıkan Miktar 0 Olamaz'
                });
            } else {
                $.ajax({
                    url: "controller/kasa_controller/sql.php?islem=kasa_acilis_fisi_ekle",
                    type: "POST",
                    data: {
                        kasa_id: kasa_id,
                        giren_tutar: giren_tutar,
                        cikan_tutar: cikan_tutar,
                        acilis_tarihi: acilis_tarihi,
                        aciklama: aciklama
                    },
                    success: function (result) {
                        if (result != 2) {
                            $("#kasa_adlari,#giren_tutar,#cikan_tutar,#aciklama").val("");
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
                                title: 'Kayıt Başarılı'
                            });
                            var item = JSON.parse(result);
                            let giren = item.giren_tutar;
                            let cikan = item.cikan_tutar;
                            giren = parseFloat(giren);
                            giren = giren.toLocaleString("tr-TR", {
                                maximumFractionDigits: 2,
                                minimumFractionDigits: 2
                            });
                            cikan = parseFloat(cikan);
                            cikan = cikan.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            var new_row = table.row.add(["<input type='checkbox' class='secilen_acilislar'/>", item.kasa_adi, item.kasa_kodu, giren, cikan, item.aciklama]).draw(false).node();
                            $(new_row).attr("data-id", item.id);
                            $(new_row).find('td').eq(1).css('text-align', 'left');
                            $(new_row).find('td').eq(2).css('text-align', 'left');
                            $(new_row).find('td').eq(5).css('text-align', 'left');
                        }
                    }
                })
            }
        });

        $("body").off("click", "#kasa_acilis_vazgec").on("click", "#kasa_acilis_vazgec", function () {
            var arr = [];
            var selectedRows = [];
            $(".secilen_acilislar").each(function () {
                let id = $(this).closest("tr").data("id");
                arr.push(id);
                var row = $(this).closest("tr");
                selectedRows.push(row);
            })
            $.ajax({
                url: "controller/kasa_controller/sql.php?islem=secilen_acilislari_sil_sql",
                type: "POST",
                data: {
                    id: arr
                },
                success: function (result) {
                    if (result == 1) {
                        $("#kasa_acilis_fisi_modal").modal("hide");
                    } else {
                        $("#kasa_acilis_fisi_modal").modal("hide");
                    }
                }
            })
        })

        $("body").off("click", "#acilislarin_hepsini_sil").on("click", "#acilislarin_hepsini_sil", function () {
            var arr = [];
            var selectedRows = [];
            $(".secilen_acilislar").each(function () {
                let id = $(this).closest("tr").data("id");
                arr.push(id);
                var row = $(this).closest("tr");
                selectedRows.push(row);
            })
            $.ajax({
                url: "controller/kasa_controller/sql.php?islem=secilen_acilislari_sil_sql",
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

        $("body").off("click", "#secilen_kasa_acilis_sil").on("click", "#secilen_kasa_acilis_sil", function () {
            var arr = [];
            var selectedRows = [];
            $(".checked_opening").each(function () {
                let id = $(this).closest("tr").data("id");
                arr.push(id);
                var row = $(this).closest("tr");
                selectedRows.push(row);
            })
            $.ajax({
                url: "controller/kasa_controller/sql.php?islem=secilen_acilislari_sil_sql",
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

        $("body").off("change", ".secilen_acilislar").on("change", ".secilen_acilislar", function () {
            var id = $(this).closest("tr").data("id");
            if ($(this).prop('checked')) {
                $(this).addClass("checked_opening");
            } else {
                $(this).removeClass("checked_opening");
            }
        })

    </script>
    <?php
}
if ($islem == "kasa_acilis_fisi_guncelle_modal") {
    ?>
    <div class="modal fade" id="kasa_acilis_fisi_guncelle_modal" data-backdrop="static" data-bs-keyboard="false"
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
                            <div class="ibox-title" style='color:white; font-weight:bold;'>KASA AÇILIŞ FİŞİ GÜNCELLE</div>
                        </div>
                        <div class="modal-body">
                            <div id="stoklari_getir_acilis_div"></div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Kasa</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="custom-select custom-select-sm" id="kasa_adlari">
                                    <option value="">Seçiniz...</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Açılış Tarihi</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="date" class="form-control form-control-sm" id="kasa_acilis_tarihi"
                                        value="<?= date("Y-m-d") ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Giren Tutar</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" style="text-align: right"
                                           id="giren_tutar">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Çıkan Tutar</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" style="text-align: right"
                                           id="cikan_tutar">
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
            $.get("controller/kasa_controller/sql.php?islem=acilis_icin_kasalari_getir", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        var selected = "";
                        if (item.varsayilan_kasa == 1) {
                            selected = "selected";
                        }
                        $("#kasa_adlari").append("" +
                            "<option value='" + item.id + "' " + selected + ">" + item.kasa_adi + "</option>" +
                            "");
                    })
                }
            })
            $("#kasa_acilis_fisi_guncelle_modal").modal("show");
            $.get("controller/kasa_controller/sql.php?islem=acilis_bilgilerini_getir_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $("#kasa_adlari").val(item.kasa_id);
                    let acilis_tarihi = item.acilis_tarihi;
                    if (acilis_tarihi != null){
                        acilis_tarihi = acilis_tarihi.split(" ");
                    }
                    $("#kasa_acilis_tarihi").val(acilis_tarihi[0]);
                    let cikan_tutar = item.cikan_tutar;
                    cikan_tutar = parseFloat(cikan_tutar);
                    $("#cikan_tutar").val(cikan_tutar.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                    let giren_tutar = item.giren_tutar;
                    giren_tutar = parseFloat(giren_tutar);
                    $("#giren_tutar").val(giren_tutar.toLocaleString("tr-TR", {
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
        $("body").off("focusout", "#cikan_tutar").on("focusout", "#cikan_tutar", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("focusout", "#giren_tutar").on("focusout", "#giren_tutar", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("click", "#acilis_fisi_guncelle_button").on("click", "#acilis_fisi_guncelle_button", function () {
            let cikan_tutar = $("#cikan_tutar").val();
            cikan_tutar = cikan_tutar.replace(/\./g, "").replace(",", ".");
            cikan_tutar = parseFloat(cikan_tutar);
            let giren_tutar = $("#giren_tutar").val();
            giren_tutar = giren_tutar.replace(/\./g, "").replace(",", ".");
            giren_tutar = parseFloat(giren_tutar);
            let aciklama = $("#aciklama").val();
            let cari_id = $("#kasa_adlari").val();
            let acilis_tarihi = $("#kasa_acilis_tarihi").val();
            if (cari_id == undefined || cari_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Cari Belirtiniz...",
                    "warning"
                );
            }else {
                $.ajax({
                    url: "controller/kasa_controller/sql.php?islem=acilis_fisi_guncelle_sql",
                    type: "POST",
                    data: {
                        cikan_tutar: cikan_tutar,
                        giren_tutar: giren_tutar,
                        acilis_tarihi: acilis_tarihi,
                        aciklama: aciklama,
                        kasa_id: cari_id,
                        id: "<?=$_GET["id"]?>"
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Açılış Fişi Güncellendi",
                                "success"
                            );
                            $("#kasa_acilis_fisi_guncelle_modal").modal("hide");
                            $.get("view/kasa_acilis_fisi.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("view/kasa_acilis_fisi.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }
        });

        $("body").off("click", "#acilis_vazgec_cari").on("click", "#acilis_vazgec_cari", function () {
            $("#kasa_acilis_fisi_guncelle_modal").modal("hide");
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