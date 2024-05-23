<?php
$islem = $_GET["islem"];

if ($islem == "yeni_stok_acilis_fisi_modal_getir") {
    ?>
    <div class="modal fade" id="stok_acilis_fisi_gir" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="width: 75%; max-width: 75%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Stok Açılış Fişi
                    <button type="button" class="btn-close btn-close-white" id="acilis_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="stoklari_getir_acilis_div"></div>
                    <div class="col-12 row mt-2 no-gutters">
                        <div class="col-md-1">
                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;Stok Kodu</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm stok_kodu_getir"
                                       placeholder="Stok Kodu">
                                <div class="input-group-append">
                                    <button class="btn btn-warning btn-sm acilis_stok_adi"
                                            id="stok_adi_getir_acilis">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;Stok Adı</label>
                            <input type="text" disabled
                                   class="form-control form-control-sm mx-2 stok_adi_getir"
                                   placeholder="Stok Adı" id="">
                        </div>
                        <div class="col-md-1">
                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;Açılış
                                Tarihi</label>
                            <input type="date" value="<?= date("Y-m-d") ?>"
                                   class="form-control form-control-sm mx-2"
                                   id="stok_acilis_tarih">
                        </div>
                        <div class="col-md-1 mx-3">
                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Birim</label>
                            <select class="custom-select custom-select-sm mx-1 stok_acilis_gelecek_birim">
                                <option value="">Birim</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Miktar</label>
                            <input type="text" style="text-align: right"
                                   class="form-control form-control-sm mx-2 ust_miktar"
                                   placeholder="Miktar" id="">
                        </div>
                        <div class="col-md-1">
                            <label style="font-size: 10px; font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Alış
                                Fiyat</label>
                            <input type="text" placeholder="Alış Fiyat" style="text-align: right"
                                   class="form-control form-control-sm mx-3 ust_alis_fiyat" id="">
                        </div>
                        <div class="col-md-2">
                            <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Açıklama</label>
                            <input type="text" placeholder="Açıklama"
                                   style=" width: 100%!important;"
                                   class="form-control form-control-sm mx-4" id="ust_aciklama">
                        </div>
                        <div class="col-md-2 row mt-4 mx-3">
                            <button style="width: 85% !important;"
                                    class="btn btn-success btn-sm mx-5" id="stok_acilis_fisi_ekle"><i
                                        class="fa fa-plus"></i> Ekle
                            </button>
                        </div>
                    </div>
                    <div class="col-12 mt-3 row">
                        <table class="table table-sm table-bordered w-100 display nowrap" id='new_stok_acilis_table'
                               style="font-size: 13px;">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th id="click_stok">Stok Kodu</th>
                                <th>Stok Adı</th>
                                <th>Birim</th>
                                <th>Miktar</th>
                                <th>Depo</th>
                                <th>Alış Fiyat</th>
                                <th>Açıklama</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="col-md-12 mt-3 row">
                        <div class="col-1">
                            <button class="btn btn-danger btn-sm" id="acilis_vazgec"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-success btn-sm" id="acilislari_kaydet"><i
                                        class="fa fa-plus"></i> Kaydet
                            </button>
                        </div>
                        <div class="col-1">
                            <button class="btn btn-danger btn-sm" id="secilen_acilislari_sil"><i
                                        class="fa fa-minus-square"></i> Seçilenleri
                                Sil
                            </button>
                        </div>
                        <div class="col-1 mx-5">
                            <button class="btn btn-danger btn-sm" id="tum_acilislari_sil"><i
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
        $("body").off("click", "#acilislari_kaydet").on("click", "#acilislari_kaydet", function () {
            var hata_mesajı = "";
            var verilecek_mesaj = "";
            $(".depo_ids").each(function () {
                var acilis_fis = $(this).closest("tr");
                var data_id = acilis_fis.attr("acilis_id")
                var val = $(this).val();
                if (val == "Depo Adı" && data_id != undefined) {
                    hata_mesajı = "Hata";
                }
                if (data_id != undefined) {
                    verilecek_mesaj = "Kayıt Var";
                }
            })
            if (hata_mesajı == "Hata") {
                Swal.fire(
                    "Uyarı!",
                    'Boş Depo Kalamaz Lütfen Depoları Seçiniz',
                    'warning'
                );
            } else {
                if (verilecek_mesaj == "Kayıt Var") {
                    Swal.fire(
                        'Başarılı',
                        'Değişiklikler Kaydedildi',
                        'success'
                    );
                    $("#stok_acilis_fisi_gir").modal("hide");
                    $.get("view/stok_acilis_fisi.php", function (getList) {
                        $(".modal-icerik").html("");
                        $(".modal-icerik").html(getList);
                    });
                    $.get("view/stok_acilis_fisi.php", function (getList) {
                        $(".admin-modal-icerik").html("");
                        $(".admin-modal-icerik").html(getList);
                    });
                } else {
                    Swal.fire(
                        'Başarılı',
                        'Hiçbir Değişiklik Yapmadınız',
                        'success'
                    );
                    $("#stok_acilis_fisi_gir").modal("hide");
                    $.get("view/stok_acilis_fisi.php", function (getList) {
                        $(".modal-icerik").html("");
                        $(".modal-icerik").html(getList);
                    });
                    $.get("view/stok_acilis_fisi.php", function (getList) {
                        $(".admin-modal-icerik").html("");
                        $(".admin-modal-icerik").html(getList);
                    });
                }
            }
        });

        $("body").off("click", "#tum_acilislari_sil").on("click", "#tum_acilislari_sil", function () {
            var gonderilecek_ids = [];
            $(".stok_acilis_fisi").each(function () {
                var id = $(this).attr("acilis_id");
                if (id != undefined || id != "") {
                    gonderilecek_ids.push(id);
                }
            });

            $.ajax({
                url: "controller/stok_controller/sql.php?islem=tum_kayitlari_sil",
                type: "POST",
                data: {
                    gonderilecek_ids: gonderilecek_ids
                },
                success: function (result) {
                    table.clear().draw(false);
                }
            });
        });
        $("body").off("click", "#acilis_vazgec").on("click", "#acilis_vazgec", function () {
            var gonderilecek_ids = [];
            $(".stok_acilis_fisi").each(function () {
                var id = $(this).attr("acilis_id");
                if (id != undefined || id != "") {
                    gonderilecek_ids.push(id);
                }
            });

            $.ajax({
                url: "controller/stok_controller/sql.php?islem=tum_kayitlari_sil",
                type: "POST",
                data: {
                    gonderilecek_ids: gonderilecek_ids
                },
                success: function () {
                    $("#stok_acilis_fisi_gir").modal("hide");
                }
            });
        });

        $("body").off("click", "#stok_adi_getir_acilis").on("click", "#stok_adi_getir_acilis", function () {
            $.get("modals/stok_modal/modal_page.php?islem=stoklari_getir_acilis", function (getModal) {
                $("#stoklari_getir_acilis_div").html("");
                $("#stoklari_getir_acilis_div").html(getModal);
            });
        });

        var table = "";
        $("body").off("click", "#stok_acilis_fisi_ekle").on("click", "#stok_acilis_fisi_ekle", function () {
            var stok_id = $(".stok_kodu_getir").attr("data-id");
            var birim_id = $(".stok_acilis_gelecek_birim").val();
            var alis_fiyat = $(".ust_alis_fiyat").val();
            alis_fiyat = alis_fiyat.replace(/\./g, "").replace(",", ".");
            alis_fiyat = parseFloat(alis_fiyat);
            var miktar = $(".ust_miktar").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            var aciklama = $("#ust_aciklama").val();
            var acilis_tarih = $("#stok_acilis_tarih").val();
            $.ajax({
                url: "controller/stok_controller/sql.php?islem=yeni_ust_acilis_fisi_olustur_sql",
                type: "POST",
                data: {
                    stok_id: stok_id,
                    acilis_tarih: acilis_tarih,
                    birim_id: birim_id,
                    alis_fiyat: alis_fiyat,
                    miktar: miktar,
                    aciklama: aciklama
                },
                success: function (result) {
                    if (result != 2) {
                        $.get("controller/alis_controller/sql.php?islem=birimleri_getir", function (result) {
                            if (result != 2) {
                                var json = JSON.parse(result);
                                json.forEach(function (item) {
                                    var birimAdi = item.birim_adi;
                                    $(".stok_birimleri").append("" +
                                        "<option value='" + item.id + "'>" + birimAdi.toUpperCase() + "</option>" +
                                        "");
                                })
                            }
                        });
                        $.get("controller/alis_controller/sql.php?islem=depolari_getir", function (result) {
                            if (result != 2) {
                                var json = JSON.parse(result);
                                json.forEach(function (item) {
                                    var depo_adi = item.depo_adi
                                    $(".depo_ids").append("" +
                                        "<option value='" + item.id + "'>" + depo_adi.toUpperCase() + "</option>" +
                                        "");
                                })
                            }
                        })
                        var item = JSON.parse(result);
                        var stok_acilis = table.row.add(["<input type='checkbox' class='col-6 secilecek_acilislar'/>", item.stok_kodu, item.stok_adi, "<select style='width: 55% !important;' class='custom-select custom-select-sm stok_birimleri'>" +
                        "<option value='" + item.birim_id + "'>" + item.birim_adi + "</option>" +
                        "</select>", "<input type='text' class='form-control form-control-sm miktar_acilis_fisi' value='" + item.miktar + "' placeholder='miktar' style='width: 85% !important;'/>", "<select style='width: 55% !important;' class='custom-select custom-select-sm depo_ids'>" +
                        "<option>Depo Adı</option>" +
                        "</select>", "<input type='text' placeholder='Alış Fiyat' class='form-control form-control-sm alis_fiyat_acilis' value='" + item.alis_fiyat + "' style='width: 85% !important;'/>", "<input type='text' class='form-control form-control-sm acilis_aciklama' value='" + item.aciklama + "' placeholder='Açıklama' style='width: 85% !important;'/>"]).draw(false).node();
                        $(stok_acilis).attr("data-id", item.stok_id);
                        $(stok_acilis).attr("acilis_id", item.id);
                        $(stok_acilis).find('td').eq(0).css('text-align', 'left');
                        $(stok_acilis).find('td').eq(1).css('text-align', 'left');
                        $(stok_acilis).find('td').eq(2).css('text-align', 'left');
                        $(stok_acilis).find('td').eq(3).css('text-align', 'left');
                        $(stok_acilis).find('td').eq(4).css('text-align', 'left');
                        $(stok_acilis).find('td').eq(5).css('text-align', 'left');
                        $(stok_acilis).find('td').eq(6).css('text-align', 'left');
                        $(stok_acilis).find('td').eq(7).css('text-align', 'left');
                    }
                }
            });
        });
        $(document).ready(function () {
            setTimeout(function () {
                $("#click_stok").trigger("click");
            }, 500);
            $("#stok_acilis_fisi_gir").modal("show")
            table = $('#new_stok_acilis_table').DataTable({
                scrollY: '63vh',
                scrollX: true,
                bAutoWidth: false,
                searching: false,
                aoColumns: [
                    {sWidth: '1%'},
                    {sWidth: '3%'},
                    {sWidth: '5%'},
                    {sWidth: '1%'},
                    {sWidth: '3%'},
                    {sWidth: '2%'},
                    {sWidth: '1%'},
                    {sWidth: '5%'}
                ],
                "info": false,
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row) {
                    $(row).addClass("stok_acilis_fisi");
                }
            })
        })

        $.get("controller/alis_controller/sql.php?islem=birimleri_getir", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                json.forEach(function (item) {
                    var birimAdi = item.birim_adi;
                    $(".stok_acilis_gelecek_birim").append("" +
                        "<option value='" + item.id + "'>" + birimAdi.toUpperCase() + "</option>" +
                        "");
                })
            }
        });
        $("body").off("click", "#tum_stoklari_cek").on("click", "#tum_stoklari_cek", function () {

            $.get("controller/stok_controller/sql.php?islem=acilis_fisleri_icin_stoklari_getir_sql", function (result) {
                table.clear().draw(false);
                if (result != 2) {
                    var json = JSON.parse(result);
                    $.get("controller/alis_controller/sql.php?islem=birimleri_getir", function (result) {
                        if (result != 2) {
                            var json = JSON.parse(result);
                            json.forEach(function (item) {
                                var birimAdi = item.birim_adi;
                                $(".stok_birimleri").append("" +
                                    "<option value='" + item.id + "'>" + birimAdi.toUpperCase() + "</option>" +
                                    "");
                            })
                        }
                    });
                    $.get("controller/alis_controller/sql.php?islem=depolari_getir", function (result) {
                        if (result != 2) {
                            var json = JSON.parse(result);
                            json.forEach(function (item) {
                                var depo_adi = item.depo_adi
                                $(".depo_ids").append("" +
                                    "<option value='" + item.id + "'>" + depo_adi.toUpperCase() + "</option>" +
                                    "");
                            })
                        }
                    })
                    json.forEach(function (item) {
                        var stok_acilis = table.row.add(["<input type='checkbox' class='col-6 secilecek_acilislar'/>", item.stok_kodu, item.stok_adi, "<select style='width: 55% !important;' class='custom-select custom-select-sm stok_birimleri'>" +
                        "<option value='" + item.birim + "'>" + item.birim_adi + "</option>" +
                        "</select>", "<input type='text' class='form-control form-control-sm miktar_acilis_fisi' placeholder='miktar' style='width: 85% !important;'/>", "<select style='width: 55% !important;' class='custom-select custom-select-sm depo_ids'>" +
                        "<option>Depo Adı</option>" +
                        "</select>", "<input type='text' placeholder='Alış Fiyat' class='form-control form-control-sm alis_fiyat_acilis' style='width: 85% !important;'/>", "<input type='text' class='form-control form-control-sm acilis_aciklama' placeholder='Açıklama' style='width: 85% !important;'/>"]).draw(false).node();
                        $(stok_acilis).attr("data-id", item.id);
                        $(".stok_birimleri").val(item.birim);
                        $(stok_acilis).find('td').eq(0).css('text-align', 'left');
                        $(stok_acilis).find('td').eq(1).css('text-align', 'left');
                        $(stok_acilis).find('td').eq(2).css('text-align', 'left');
                        $(stok_acilis).find('td').eq(3).css('text-align', 'left');
                        $(stok_acilis).find('td').eq(4).css('text-align', 'left');
                        $(stok_acilis).find('td').eq(5).css('text-align', 'left');
                        $(stok_acilis).find('td').eq(6).css('text-align', 'left');
                        $(stok_acilis).find('td').eq(7).css('text-align', 'left');
                    });
                }
            })
        })

        $("body").off("change", ".stok_birimleri").on("change", ".stok_birimleri", function () {
            var birim_id = $(this).val();
            var dataId = $(this).closest("tr");
            var acilis_id = dataId.attr("acilis_id");
            $.ajax({
                url: "controller/stok_controller/sql.php?islem=stok_acilis_fisi_birim_ekle",
                type: "POST",
                data: {
                    birim_id: birim_id,
                    id: acilis_id
                },
                success: function (result) {
                    if (result != 2) {
                        var result_split = result.split(":");
                        var id = result_split[1];
                        dataId.attr("acilis_id", id);
                    } else {
                        alert("hata");
                    }
                }
            })
        });

        $("body").off("change", ".depo_ids").on("change", ".depo_ids", function () {
            var depo_id = $(this).val();
            var dataId = $(this).closest("tr");
            var acilis_id = dataId.attr("acilis_id");
            $.ajax({
                url: "controller/stok_controller/sql.php?islem=stok_acilis_depo_ekle",
                type: "POST",
                data: {
                    depo_id: depo_id,
                    id: acilis_id
                },
                success: function (result) {
                    if (result != 2) {
                        var result_split = result.split(":");
                        var id = result_split[1];
                        dataId.attr("acilis_id", id);
                    } else {
                        alert("hata");
                    }
                }
            })
        });

        $("body").off("click", ".secilecek_acilislar").on("click", ".secilecek_acilislar", function () {
            if ($(this).prop('checked')) {
                $(this).addClass("secilen_acilis");
            } else {
                $(this).removeClass("secilen_acilis");
            }
        })

        $("body").off("click", "#secilen_acilislari_sil").on("click", "#secilen_acilislari_sil", function () {
            var silinecek_acilisids = [];
            $(".secilen_acilis").each(function () {
                var dataId = $(this).closest("tr");
                var acilis_id = dataId.attr("acilis_id");
                silinecek_acilisids.push(acilis_id);
            })
            $.ajax({
                url: "controller/stok_controller/sql.php?islem=secilen_acilislari_sil",
                type: "POST",
                data: {
                    silinecek_acilisids: silinecek_acilisids
                },
                success: function (result) {
                    $(".secilen_acilis").each(function () {
                        var row = $(this).closest("tr");
                        table.row(row).remove().draw();
                    })
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
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'Kayıtlar Silindi'
                    });
                }
            });
        });

        $("body").off("focusout", ".acilis_aciklama").on("focusout", ".acilis_aciklama", function () {
            var aciklama = $(this).val();
            var dataId = $(this).closest("tr");
            var acilis_id = dataId.attr("acilis_id");
            $.ajax({
                url: "controller/stok_controller/sql.php?islem=stok_acilis_fisi_aciklama_ekle",
                type: "POST",
                data: {
                    aciklama: aciklama,
                    id: acilis_id
                },
                success: function (result) {
                    if (result != 2) {
                        var result_split = result.split(":");
                        var id = result_split[1];
                        dataId.attr("acilis_id", id);
                    } else {
                        alert("hata");
                    }
                }
            })
        })

        $("body").off("focusout", ".miktar_acilis_fisi").on("focusout", ".miktar_acilis_fisi", function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            var miktar = val;
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2})
            $(this).val(val);
            var dataId = $(this).closest("tr");
            var acilis_id = dataId.attr("acilis_id");
            var stok_id = $(this).closest("tr").data("id");
            $.ajax({
                url: "controller/stok_controller/sql.php?islem=stok_acilis_fisi_miktar_ekle",
                type: "POST",
                data: {
                    miktar: miktar,
                    id: acilis_id,
                    stok_id: stok_id
                },
                success: function (result) {
                    if (result != 2) {
                        var result_split = result.split(":");
                        var id = result_split[1];
                        dataId.attr("acilis_id", id);
                    } else {
                        alert("hata");
                    }
                }
            })
        })

        $(".ust_miktar").focusout(function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2})
            $(this).val(val);
        });
        $(".ust_alis_fiyat").focusout(function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2})
            $(this).val(val);
        });

        $("body").off("focusout", ".alis_fiyat_acilis").on("focusout", ".alis_fiyat_acilis", function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            var alis_fiyat = val;
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2})
            $(this).val(val);

            var dataId = $(this).closest("tr");
            var acilis_id = dataId.attr("acilis_id");
            var stok_id = $(this).closest("tr").data("id");
            $.ajax({
                url: "controller/stok_controller/sql.php?islem=acilis_alis_fiyat_guncelle_sql",
                type: "POST",
                data: {
                    stok_id: stok_id,
                    id: acilis_id,
                    alis_fiyat: alis_fiyat
                },
                success: function (result) {
                    if (result != 2) {

                    } else {
                        alert("hata");
                    }
                }
            });
        })

    </script>
    <?php
}
if ($islem == "acilis_fisi_guncelle_modal") {
    ?>
    <div class="modal fade" id="stok_acilis_fisi_guncelle_modal" data-backdrop="static" data-bs-keyboard="false"
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
                            <div class="ibox-title" style='color:white; font-weight:bold;'>STOK AÇILIŞ FİŞİ GÜNCELLE
                            </div>
                        </div>
                        <div class="modal-body">
                            <div id="stoklari_getir_acilis_div"></div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Stok Kodu</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm stok_kodu_getir"
                                               placeholder="Stok Kodu">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm acilis_stok_adi"
                                                    id="stok_adi_getir_acilis">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Stok Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" disabled
                                           class="form-control form-control-sm stok_adi_getir"
                                           placeholder="Stok Adı" id="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Miktar</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" style="text-align: right"
                                           id="miktar">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Birim Fiyat</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" style="text-align: right"
                                           id="alis_fiyat">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Depo</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="custom-select custom-select-sm" id="depo_id">
                                        <option value="">Depo Seçiniz...</option>
                                    </select>
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

            $.get("controller/alis_controller/sql.php?islem=depolari_getir", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        var depo_adi = item.depo_adi
                        $("#depo_id").append("" +
                            "<option value='" + item.id + "'>" + depo_adi.toUpperCase() + "</option>" +
                            "");
                    })
                }
            })
            $("#stok_acilis_fisi_guncelle_modal").modal("show");
            $.get("controller/stok_controller/sql.php?islem=acilis_bilgilerini_getir_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $(".stok_kodu_getir").attr("data-id", item.stok_id);
                    $(".stok_kodu_getir").val(item.stok_kodu);
                    $(".stok_adi_getir").val(item.stok_adi);
                    let alis_fiyat = item.alis_fiyat;
                    alis_fiyat = parseFloat(alis_fiyat);
                    $("#alis_fiyat").val(alis_fiyat.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                    let miktar = item.miktar;
                    miktar = parseFloat(miktar);
                    $("#miktar").val(miktar.toLocaleString("tr-TR", {
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
        $("body").off("focusout", "#alis_fiyat").on("focusout", "#alis_fiyat", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("focusout", "#miktar").on("focusout", "#miktar", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("click", "#acilis_fisi_guncelle_button").on("click", "#acilis_fisi_guncelle_button", function () {
            let alis_fiyat = $("#alis_fiyat").val();
            alis_fiyat = alis_fiyat.replace(/\./g, "").replace(",", ".");
            alis_fiyat = parseFloat(alis_fiyat);
            let miktar = $("#miktar").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            let aciklama = $("#aciklama").val();
            let depo_id = $("#depo_id").val();
            let cari_id = $(".stok_kodu_getir").attr("data-id");
            if (cari_id == undefined || cari_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Cari Belirtiniz...",
                    "warning"
                );
            }else if (depo_id == undefined || depo_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Depo Belirtiniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "controller/stok_controller/sql.php?islem=acilis_fisi_guncelle_sql",
                    type: "POST",
                    data: {
                        alis_fiyat: alis_fiyat,
                        miktar: miktar,
                        aciklama: aciklama,
                        depo_id: depo_id,
                        stok_id: cari_id,
                        id: "<?=$_GET["id"]?>"
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Açılış Fişi Güncellendi",
                                "success"
                            );
                            $("#stok_acilis_fisi_guncelle_modal").modal("hide");
                            $.get("view/stok_acilis_fisi.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("view/stok_acilis_fisi.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }
        });
        
        $("body").off("click", "#acilis_vazgec_cari").on("click", "#acilis_vazgec_cari", function () {
            $("#stok_acilis_fisi_guncelle_modal").modal("hide");
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