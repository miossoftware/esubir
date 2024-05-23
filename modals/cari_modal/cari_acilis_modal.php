<?php
$islem = $_GET["islem"];
if ($islem == "yeni_cari_acilis_fisi_ekle") {
    ?>
    <style>
        #cari_acilis_fisi_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="cari_acilis_fisi_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="width: 75%; max-width: 75%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="acilis_vazgec_cari"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>CARİ AÇILIŞ FİŞİ</div>
                        </div>
                        <div class="modal-body">
                            <div id="carileri_getir_acilis_div"></div>
                            <div class="col-12 row mt-2 no-gutters">
                                <div class="col-md-1">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;Cari Kodu</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm cari_kodu_getir"
                                               placeholder="Cari Kodu">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm"
                                                    id="cari_adi_getir_acilis">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;Cari
                                        Adı</label>
                                    <input type="text" disabled
                                           class="form-control form-control-sm mx-2 cari_adi_getir"
                                           placeholder="Cari Adı" id="">
                                </div>
                                <div class="col-md-1">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Borç</label>
                                    <input type="text" style="text-align: right"
                                           class="form-control form-control-sm mx-2 ust_borc"
                                           placeholder="Borç" id="">
                                </div>
                                <div class="col-md-1">
                                    <label style="font-size: 10px; font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Alacak</label>
                                    <input type="text" placeholder="Alacak" style="text-align: right"
                                           class="form-control form-control-sm mx-3 ust_alacak" id="">
                                </div>
                                <div class="col-md-1">
                                    <label style="font-size: 10px; font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Açılış
                                        Tarihi</label>
                                    <input type="date" value="<?= date("Y-m-d") ?>" placeholder=""
                                           style="text-align: right"
                                           class="form-control form-control-sm mx-3" id="acilis_tarihi">
                                </div>
                                <div class="col-md-1 mx-3">
                                    <label style="font-size: 10px; font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Döviz
                                        Türü</label>
                                    <select class="custom-select custom-select-sm" id="doviz_turu">
                                        <option value="">Döviz Türü Seçiniz...</option>
                                        <option selected value="TL">TL</option>
                                        <option id="usd_bas" value="USD">USD</option>
                                        <option id="eur_bas" value="EURO">EURO</option>
                                        <option id="gbp_bas" value="GBP">GBP</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label style="font-size: 10px; font-weight: bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Döviz
                                        Kuru</label>
                                    <input type="text" value="1,00" placeholder=""
                                           style="text-align: right"
                                           class="form-control form-control-sm mx-3" id="doviz_kuru">
                                </div>
                                <div class="col-md-2">
                                    <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Açıklama</label>
                                    <input type="text" placeholder="Açıklama"
                                           style=" width: 100%!important;"
                                           class="form-control form-control-sm mx-4" id="ust_aciklama">
                                </div>
                                <div class="col-md-2 row mt-4 mx-3">
                                    <button style="width: 85% !important;"
                                            class="btn btn-success btn-sm mx-5" id="cari_acilis_fisi_ekle"><i
                                                class="fa fa-plus"></i> Ekle
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-3 row">
                            <table class="table table-sm table-bordered w-100 display nowrap" id='new_stok_acilis_table'
                                   style="font-size: 13px;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th id="click_cari">Stok Kodu</th>
                                    <th>Cari Adı</th>
                                    <th>Borç</th>
                                    <th>Alacak</th>
                                    <th>Döviz Türü</th>
                                    <th>Döviz Kuru</th>
                                    <th>Açıklama</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="col-md-12 mt-3 row">
                            <div class="col-1">
                                <button class="btn btn-danger btn-sm" id="acilis_vazgec_cari"><i
                                            class="fa fa-close"></i>
                                    Vazgeç
                                </button>
                            </div>
                            <div class="col-1">
                                <button class="btn btn-success btn-sm" id="acilislari_kaydet_cari"><i
                                            class="fa fa-plus"></i> Kaydet
                                </button>
                            </div>
                            <div class="col-1">
                                <button class="btn btn-secondary btn-sm" id="tum_carileri_getir"><i
                                            class="fa fa-refresh"></i> Hazırla
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
    </div>
    <script>
        $('input').click(function () {
            $(this).select();
        });


        $.get("controller/alis_controller/sql.php?islem=guncel_kurlar", function (result) {

            var item = JSON.parse(result);
            var usd = item.USD[0];

            var eur = item.EUR[0];

            var gbp = item.GBP[0];
            $("#usd_bas").attr("usd", usd);
            $("#eur_bas").attr("eur", eur);
            $("#gbp_bas").attr("gbp", gbp);

        });

        $("body").off("change", "#doviz_turu").on("change", "#doviz_turu", function () {

            var value = $(this).val();

            if (value == "TL") {

                $("#doviz_kuru").val("1.00");

            } else if (value == "EURO") {

                var eur_kur = $("#doviz_turu option:selected").attr("eur");

                $("#doviz_kuru").val(eur_kur);

            } else if (value == "USD") {

                var usd_kur = $("#doviz_turu option:selected").attr("usd");

                $("#doviz_kuru").val(usd_kur);

            } else if (value == "GBP") {

                var gbp_kur = $("#doviz_turu option:selected").attr("gbp");

                $("#doviz_kuru").val(gbp_kur);

            } else {

                $("#doviz_kuru").val("");

            }

        });
        $("body").off("click", "#cari_acilis_fisi_ekle").on("click", "#cari_acilis_fisi_ekle", function () {
            var cari_id = $(".cari_kodu_getir").attr("data-id");
            var borc = $(".ust_borc").val();
            borc = borc.replace(/\./g, "").replace(",", ".");
            borc = parseFloat(borc);
            let acilis_tarihi = $("#acilis_tarihi").val();
            var alacak = $(".ust_alacak").val();
            alacak = alacak.replace(/\./g, "").replace(",", ".");
            alacak = parseFloat(alacak);
            var aciklama = $("#ust_aciklama").val();
            let doviz_turu = $("#doviz_turu").val();
            let doviz_kuru = $("#doviz_kuru").val();
            $.ajax({
                url: "controller/cari_controller/sql.php?islem=cari_acilis_fisi_ekle_sql",
                type: "POST",
                data: {
                    cari_id: cari_id,
                    acilis_tarihi: acilis_tarihi,
                    borc: borc,
                    alacak: alacak,
                    doviz_turu: doviz_turu,
                    doviz_kuru: doviz_kuru,
                    aciklama: aciklama
                },
                success: function (result) {
                    if (result != 2) {
                        var item = JSON.parse(result);
                        let alacak = item.alacak;
                        alacak = parseFloat(alacak);
                        alacak = alacak.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                        let borc = item.borc;
                        borc = parseFloat(borc);
                        borc = borc.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                        var cari_acilis = table.row.add(["<input type='checkbox' class='col-6 secilecek_acilislar'/>", item.cari_kodu, item.cari_adi, "<input type='text' class='form-control form-control-sm borc_acilis_fisi' value='" + borc + "' placeholder='Borç' style='width: 85% !important;'/>", "<input type='text' placeholder='Alacak' class='form-control form-control-sm alacak_acilis' value='" + alacak + "' style='width: 85% !important;'/>", doviz_turu, doviz_kuru, "<input type='text' class='form-control form-control-sm acilis_aciklama' value='" + item.aciklama + "' placeholder='Açıklama' style='width: 85% !important;'/>"]).draw(false).node();
                        $(cari_acilis).attr("data-id", cari_id);
                        $(cari_acilis).attr("acilis_id", item.id);
                        $(cari_acilis).find('td').eq(1).css('text-align', 'left');
                        $(cari_acilis).find('td').eq(2).css('text-align', 'left');
                    }
                }
            })
        });

        $(".ust_borc").focusout(function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2})
            $(this).val(val);
        });

        $(".ust_alacak").focusout(function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2})
            $(this).val(val);
        });

        $("body").off("focusout", ".borc_acilis_fisi").on("focusout", ".borc_acilis_fisi", function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            var borc_miktar = val;
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2})
            $(this).val(val);
            var dataId = $(this).closest("tr");
            var acilis_id = dataId.attr("acilis_id");
            var cari_id = $(this).closest("tr").data("id");
            $.ajax({
                url: "controller/cari_controller/sql.php?islem=acilis_borc_miktari_guncelle_sql",
                type: "POST",
                data: {
                    borc: borc_miktar,
                    id: acilis_id,
                    cari_id: cari_id
                },
                success: function (result) {
                    if (result != 2) {
                        var split = result.split(":");
                        var id = split[1];
                        dataId.attr("acilis_id", id);
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
                url: "controller/cari_controller/sql.php?islem=secilen_acilislari_sil",
                type: "POST",
                data: {
                    silinecek_acilisids: silinecek_acilisids
                },
                success: function () {
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

        $("body").off("click", "#tum_acilislari_sil").on("click", "#tum_acilislari_sil", function () {
            var silinecek_acilisids = [];
            $(".cari_acilis_fisi").each(function () {
                var dataId = $(this).closest("tr");
                var acilis_id = dataId.attr("acilis_id");
                silinecek_acilisids.push(acilis_id);
            })
            $.ajax({
                url: "controller/cari_controller/sql.php?islem=tum_acilislari_sil",
                type: "POST",
                data: {
                    silinecek_acilisids: silinecek_acilisids
                },
                success: function () {
                    table.clear().draw(false);
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

        $("body").off("click", "#acilislari_kaydet_cari").on("click", "#acilislari_kaydet_cari", function () {
            var verilecek_mesaj = "";
            $(".cari_acilis_fisi").each(function () {
                var acilis_fis = $(this).closest("tr");
                var data_id = acilis_fis.attr("acilis_id")
                if (data_id != undefined) {
                    verilecek_mesaj = "Kayıt Var";
                }
            })
            if (verilecek_mesaj == "Kayıt Var") {
                Swal.fire(
                    'Başarılı',
                    'Değişiklikler Kaydedildi',
                    'success'
                );
                $("#cari_acilis_fisi_modal").modal("hide");
                $.get("view/cari_acilis_fisi.php", function (getList) {
                    $(".modal-icerik").html("");
                    $(".modal-icerik").html(getList);
                });
                $.get("view/cari_acilis_fisi.php", function (getList) {
                    $(".admin-modal-icerik").html("");
                    $(".admin-modal-icerik").html(getList);
                });
            } else {
                Swal.fire(
                    'Başarılı',
                    'Hiçbir Değişiklik Yapmadınız',
                    'success'
                );
                $("#cari_acilis_fisi_modal").modal("hide");
                $.get("view/cari_acilis_fisi.php", function (getList) {
                    $(".modal-icerik").html("");
                    $(".modal-icerik").html(getList);
                });
                $.get("view/cari_acilis_fisi.php", function (getList) {
                    $(".admin-modal-icerik").html("");
                    $(".admin-modal-icerik").html(getList);
                });
            }
        });

        $("body").off("click", "#acilis_vazgec_cari").on("click", "#acilis_vazgec_cari", function () {
            var gonderilecek_ids = [];
            $(".cari_acilis_fisi").each(function () {
                var id = $(this).attr("acilis_id");
                if (id != undefined || id != "") {
                    gonderilecek_ids.push(id);
                }
            });

            $.ajax({
                url: "controller/cari_controller/sql.php?islem=tum_acilislari_sil",
                type: "POST",
                data: {
                    silinecek_acilisids: gonderilecek_ids
                },
                success: function () {
                    $("#cari_acilis_fisi_modal").modal("hide");
                }
            });
        });

        $("body").off("click", "#tum_carileri_getir").on("click", "#tum_carileri_getir", function () {
            $.get("controller/cari_controller/sql.php?islem=tum_carileri_getir_sql", function (result) {
                table.clear().draw(false);
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        var cari_acilis = table.row.add(["<input type='checkbox' class='col-6 secilecek_acilislar'/>", item.cari_kodu, item.cari_adi, "<input type='text' class='form-control form-control-sm borc_acilis_fisi' placeholder='Borç' style='width: 85% !important;'/>", "<input type='text' placeholder='Alacak' class='form-control form-control-sm alacak_acilis'  style='width: 85% !important;'/>", "<input type='text' class='form-control form-control-sm acilis_aciklama'  placeholder='Açıklama' style='width: 85% !important;'/>"]).draw(false).node();
                        $(cari_acilis).attr("data-id", item.id);
                        $(cari_acilis).find('td').eq(1).css('text-align', 'left');
                        $(cari_acilis).find('td').eq(2).css('text-align', 'left');
                    });
                }
            })
        });

        $("body").off("focusout", ".acilis_aciklama").on("focusout", ".acilis_aciklama", function () {
            var aciklama = $(this).val();
            var dataId = $(this).closest("tr");
            var acilis_id = dataId.attr("acilis_id");
            var cari_id = $(this).closest("tr").data("id");
            $.ajax({
                url: "controller/cari_controller/sql.php?islem=acilis_aciklama_ekle_guncelle_sql",
                type: "POST",
                data: {
                    aciklama: aciklama,
                    id: acilis_id,
                    cari_id: cari_id
                },
                success: function (result) {
                    if (result != 2) {
                        var split = result.split(":");
                        var id = split[1];
                        dataId.attr("acilis_id", id);
                    }
                }
            })
        })

        $("body").off("focusout", ".alacak_acilis").on("focusout", ".alacak_acilis", function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            var alacak_miktar = val;
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2})
            $(this).val(val);
            var dataId = $(this).closest("tr");
            var acilis_id = dataId.attr("acilis_id");
            var cari_id = $(this).closest("tr").data("id");
            $.ajax({
                url: "controller/cari_controller/sql.php?islem=acilis_alacak_miktari_guncelle_sql",
                type: "POST",
                data: {
                    alacak: alacak_miktar,
                    id: acilis_id,
                    cari_id: cari_id
                },
                success: function (result) {
                    if (result != 2) {
                        var split = result.split(":");
                        var id = split[1];
                        dataId.attr("acilis_id", id);
                    }
                }
            })
        })

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
                    $("#cari_acilis_fisi_modal").modal("hide");
                }
            });
        });

        $("body").off("click", "#cari_adi_getir_acilis").on("click", "#cari_adi_getir_acilis", function () {
            $.get("modals/cari_modal/cari_acilis_modal.php?islem=carileri_getir_modal", function (getModal) {
                $("#carileri_getir_acilis_div").html("");
                $("#carileri_getir_acilis_div").html(getModal);
            })
        });

        var table = "";
        $(document).ready(function () {
            $("#cari_acilis_fisi_modal").modal("show");
            setTimeout(function () {
                $("#click_cari").trigger("click");
            }, 500);
            table = $('#new_stok_acilis_table').DataTable({
                scrollY: '63vh',
                scrollX: true,
                bAutoWidth: false,
                searching: false,
                aoColumns: [
                    {sWidth: '1%'},
                    {sWidth: '1%'},
                    {sWidth: '3%'},
                    {sWidth: '1%'},
                    {sWidth: '1%'},
                    {sWidth: '1%'},
                    {sWidth: '1%'},
                    {sWidth: '2%'}
                ],
                "info": false,
                "paging": true,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row) {
                    $(row).addClass("cari_acilis_fisi");
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
        })

        $(".ust_miktar").focusout(function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2})
            $(this).val(val);
        });
        $(".ust_alis_fiyat").focusout(function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
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
        })

    </script>
    <?php
}
if ($islem == "carileri_getir_modal") {
    ?>
    <div class="modal fade" data-backdrop="static" id="acilis_cari_liste"
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
        var cari_table = "";
        $(document).ready(function () {
            $("#acilis_cari_liste").modal("show");
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 300);
            cari_table = $('#fatura_cari_liste').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                columns: [
                    {'data': "cari_adi"},
                    {'data': "cari_kodu"},
                ],
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row) {
                    $(row).addClass("acilis_cari_select");
                    $(row).find('td').eq(0).css('text-align', 'left');
                    $(row).find('td').eq(1).css('text-align', 'left');
                },
                "rowCallback": function (row, data) {
                    $(row).attr("data-id", data.id); // Her satıra data-id attribütü ekleyin
                }
            })

            $.get("controller/cari_controller/sql.php?islem=acilis_icin_cari_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    cari_table.rows.add(json).draw(false);
                }
            })

        })

        $("body").off("click", ".acilis_cari_select").on("click", ".acilis_cari_select", function () {
            var id = $(this).attr("data-id");
            $.get("controller/cari_controller/sql.php?islem=acilis_secilen_cari_bilgileri_sql", {id: id}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);

                    $(".cari_kodu_getir").val(item.cari_kodu);
                    $(".cari_kodu_getir").attr("data-id", item.id);
                    $(".cari_adi_getir").val(item.cari_adi);
                    $("#acilis_cari_liste").modal("hide");
                }
            })
        });

        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#acilis_cari_liste").modal("hide");
        });

    </script>
    <?php
}
if ($islem == "cari_acilis_guncelle_modal") {
    ?>
    <div class="modal fade" id="cari_acilis_fisi_guncelle_modal" data-backdrop="static" data-bs-keyboard="false"
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
                            <div class="ibox-title" style='color:white; font-weight:bold;'>CARİ AÇILIŞ FİŞİ GÜNCELLE
                            </div>
                        </div>
                        <div class="modal-body">
                            <div id="carileri_getir_acilis_div"></div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Cari Kodu</label>
                                </div>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm cari_kodu_getir"
                                               placeholder="Cari Kodu">
                                        <div class="input-group-append">
                                            <button class="btn btn-warning btn-sm"
                                                    id="cari_adi_getir_acilis">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Cari Adı</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" disabled
                                           class="form-control form-control-sm cari_adi_getir"
                                           placeholder="Cari Adı" id="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Borç</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" style="text-align: right"
                                           id="borc">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Alacak</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" style="text-align: right"
                                           id="alacak">
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
            $("#cari_acilis_fisi_guncelle_modal").modal("show");
            $.get("controller/cari_controller/sql.php?islem=acilis_bilgilerini_getir_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $(".cari_kodu_getir").attr("data-id", item.cari_id);
                    $(".cari_kodu_getir").val(item.cari_kodu);
                    $(".cari_adi_getir").val(item.cari_adi);
                    let borc = item.borc;
                    borc = parseFloat(borc);
                    $("#borc").val(borc.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                    let alacak = item.alacak;
                    alacak = parseFloat(alacak);
                    $("#alacak").val(alacak.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                    $("#aciklama").val(item.aciklama);
                }
            })
        });
        $("body").off("focusout", "#borc").on("focusout", "#borc", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("focusout", "#alacak").on("focusout", "#alacak", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2}));
        });

        $("body").off("click", "#acilis_fisi_guncelle_button").on("click", "#acilis_fisi_guncelle_button", function () {
            let borc = $("#borc").val();
            borc = borc.replace(/\./g, "").replace(",", ".");
            borc = parseFloat(borc);
            let alacak = $("#alacak").val();
            alacak = alacak.replace(/\./g, "").replace(",", ".");
            alacak = parseFloat(alacak);
            let aciklama = $("#aciklama").val();
            let cari_id = $(".cari_kodu_getir").attr("data-id");
            if (cari_id == undefined || cari_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Cari Belirtiniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "controller/cari_controller/sql.php?islem=acilis_fisi_guncelle_sql",
                    type: "POST",
                    data: {
                        borc: borc,
                        alacak: alacak,
                        aciklama: aciklama,
                        cari_id: cari_id,
                        id: "<?=$_GET["id"]?>"
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Açılış Fişi Güncellendi",
                                "success"
                            );
                            $("#cari_acilis_fisi_guncelle_modal").modal("hide");
                            $.get("view/cari_acilis_fisi.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("view/cari_acilis_fisi.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }
        });


        $("body").off("click", "#acilis_vazgec_cari").on("click", "#acilis_vazgec_cari", function () {
            $("#cari_acilis_fisi_guncelle_modal").modal("hide");
        });

        $("body").off("click", "#cari_adi_getir_acilis").on("click", "#cari_adi_getir_acilis", function () {
            $.get("modals/cari_modal/cari_acilis_modal.php?islem=carileri_getir_modal", function (getModal) {
                $("#carileri_getir_acilis_div").html("");
                $("#carileri_getir_acilis_div").html(getModal);
            })
        });

    </script>
    <?php
}