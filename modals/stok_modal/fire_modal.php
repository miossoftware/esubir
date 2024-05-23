<?php

$islem = $_GET["islem"];
if ($islem == "stok_fire_ekle") {
    ?>
    <div class="modal fade" id="stok_fire_cikisi_ekle_modal" data-backdrop="static" data-bs-keyboard="false"
    role="dialog">
    <div class="modal-dialog modal-dialog-centered" style="width: 60%; max-width: 60%;">
        <div class="modal-content">
            <div class="modal-header text-white p-2">
                <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                        aria-label="Close"></button>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head" style='background-color:#9DB2BF'>
                        <div class="ibox-title" style='color:white; font-weight:bold;'>FİRE ÇIKIŞI</div>
                    </div>
                    <div class="modal-body">
                        <div id="stok_listesi_div"></div>
                        <div class="col-12 row mt-2 no-gutters">
                            <div class="col-md-2">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;Stok Kodu</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm stok_kodu_fire"
                                           placeholder="Stok Kodu">
                                    <div class="input-group-append">
                                        <button class="btn btn-warning btn-sm"
                                                id="stok_listesini_getir">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;Stok
                                    Adı</label>
                                <input type="text"
                                       class="form-control form-control-sm mx-2" disabled
                                       placeholder="Stok Adı" id="stok_adi">
                            </div>
                            <div class="col-md-1">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Birim</label>
                                <select class="custom-select custom-select-sm mx-1 fire_birim" id="birim_id">
                                    <option value="">Birim</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;Miktar</label>
                                <input type="text" class="form-control form-control-sm miktar" placeholder="Miktar"
                                       style="text-align: right" value="0,00">
                            </div>
                            <div class="col-md-2">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;Birim Fiyat</label>
                                <input type="text" class="form-control form-control-sm " id="birim_fiyat"
                                       style="text-align: right" placeholder="Birim Fiyat" value="0,00">
                            </div>
                            <div class="col-md-2">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Açıklama</label>
                                <input type="text" class="form-control form-control-sm" id="aciklama"
                                       placeholder="Açıklama">
                            </div>
                            <div class="col-md-2 mt-1 row">
                                <button style="width: 100% !important;"
                                        class="btn btn-success btn-sm mx-5" id="stok_fire_ekle"><i
                                            class="fa fa-plus"></i> Ekle
                                </button>
                                <button style="background-color: #F6FA70;width: 100% !important;"
                                        class="btn btn-sm mx-5 mt-1" id="fire_kaydi_guncelle"><i
                                            class="fa fa-refresh"></i> Kaydı Güncelle
                                </button>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <table class="table table-sm table-bordered w-100 display nowrap datatable"
                                   style="cursor:pointer;font-size: 13px;"
                                   id="stok_fire_table">
                                <thead>
                                <tr>
                                    <th id="click_bait">Stok Kodu</th>
                                    <th>Stok Adı</th>
                                    <th>Birimi</th>
                                    <th>Fire Miktar</th>
                                    <th>Birim Fiyat</th>
                                    <th>Fire Tutarı</th>
                                    <th>Açıklama</th>
                                    <th>İşlem</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-sm" id="modal_kapat"><i class="fa fa-close"></i> Vazgeç
                    </button>
                    <button class="btn btn-success btn-sm btn-kaydet"><i class="fa fa-close"></i> Kaydet
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('input').click(function () {
            $(this).select();
        });
        $("body").off("click", ".btn-kaydet").on("click", ".btn-kaydet", function () {
            Swal.fire(
                'Başarılı',
                'Fire Kaydedildi',
                'success'
            );
            $("#stok_fire_cikisi_ekle_modal").modal("hide");
            $.get("view/stok_fire.php", function (getList) {
                $(".modal-icerik").html("");
                $(".modal-icerik").html(getList);
            });
            $.get("view/stok_fire.php", function (getList) {
                $(".admin-modal-icerik").html("");
                $(".admin-modal-icerik").html(getList);
            });
        })
        $(".miktar").focusout(function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2})
            $(".miktar").val(val);
        })
        $("body").off("focusout", "#birim_fiyat").on("focusout", "#birim_fiyat", function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2})
            $(this).val(val);
        });
        var table = "";

        $("body").off("click", "#stok_fire_ekle").on("click", "#stok_fire_ekle", function () {
            var stok_kodu = $(".stok_kodu_fire").val();
            var stok_adi = $("#stok_adi").val();
            var birim_adi = $("#birim_id option:selected").text();
            let birim_fiyat = $("#birim_fiyat").val();
            birim_fiyat = birim_fiyat.replace(/\./g, "").replace(",", ".");
            birim_fiyat = parseFloat(birim_fiyat);
            let basilacak = birim_fiyat.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
            // VT YE GİDECEK DEĞERLER
            var miktar = $(".miktar").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            let ara_total = miktar * birim_fiyat;
            ara_total = parseFloat(ara_total);
            ara_total = ara_total.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
            var stok_id = $(".stok_kodu_fire").attr("data-id");
            var aciklama = $("#aciklama").val();
            var birim_id = $("#birim_id").val();
            if (miktar == 0 || miktar < 0) {
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
                    icon: 'warning',
                    title: 'Miktar 0 Veya - Değer Olamaz'
                });
            } else {
                $.ajax({
                    url: "controller/stok_controller/sql.php?islem=fire_cikisi_ekle",
                    type: "POST",
                    data: {
                        miktar: miktar,
                        stok_id: stok_id,
                        aciklama: aciklama,
                        birim_fiyat: birim_fiyat,
                        birim_id: birim_id
                    },
                    success: function (result) {
                        if (result != 2) {
                            var result_split = result.split(":");
                            var fire_id = result_split[1];
                            var data_id = table.row.add([stok_kodu, stok_adi.toUpperCase(), birim_adi.toUpperCase(), miktar, basilacak, ara_total, aciklama, "<button class='btn btn-danger btn-sm fire_cikis_eksilt' data-id='" + fire_id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                            $(data_id).attr("data-id", fire_id);
                            $(".stok_kodu_fire").attr("data-id", "");
                            $(".stok_kodu_fire").val("");
                            $("#stok_adi").val("");
                            $("#birim_id").val("");
                            $("#aciklama").val("");
                            $(".miktar").val("");
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
                                title: 'Fire Çıkışı Kaydedildi'
                            });
                        } else {
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
                                icon: 'error',
                                title: 'Bilinmeyen Bir Hata Oluştu'
                            });
                        }
                    }
                });
            }
        });

        $("body").off("click", ".fire_cikis_eksilt").on("click", ".fire_cikis_eksilt", function () {
            var id = $(this).attr("data-id");
            var row = $(this).closest('tr');
            $.ajax({
                url: 'controller/stok_controller/sql.php?islem=fire_cikis_sil_sql',
                type: "POST",
                data: {
                    id: id
                },
                success: function (result) {
                    if (result == 1) {
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
                            title: 'Fire Çıkışı Silindi'
                        });
                        table.row(row).remove().draw();
                    } else {
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
                            icon: 'error',
                            title: 'Bilinmeyen Bir Hata Oluştu'
                        });
                    }
                }
            })
        });

        var arr = [];
        $("body").off("click", "#fire_kaydi_guncelle").on("click", "#fire_kaydi_guncelle", function () {
            var fire_id = $(this).attr("data-id");
            var secilen_miktar = arr["miktar"];
            var secilen_stok_id = arr["stok_id"];
            var stok_kodu = $(".stok_kodu_fire").val();
            var stok_adi = $("#stok_adi").val();
            var birim_adi = $("#birim_id option:selected").text();
            var miktar = $(".miktar").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            var aciklama = $("#aciklama").val();
            var birim_id = $("#birim_id").val();
            var miktar_farki = Number(miktar) - Number(secilen_miktar);
            $.ajax({
                url: "controller/stok_controller/sql.php?islem=fire_bilgilerini_guncelle",
                type: "POST",
                data: {
                    stok_id: secilen_stok_id,
                    aciklama: aciklama,
                    miktar: miktar,
                    birim_id: birim_id,
                    miktar_farki: miktar_farki,
                    id: fire_id
                },
                success: function (result) {
                    if (result == 1) {
                        var row = $(".secildi").closest("tr");
                        table.row(row).remove().draw();
                        var data_id = table.row.add([stok_kodu, stok_adi.toUpperCase(), birim_adi.toUpperCase(), miktar, aciklama, "<button class='btn btn-danger btn-sm fire_cikis_eksilt' data-id='" + fire_id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                        $(data_id).attr("data-id", fire_id);
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
                            title: 'Fire Güncellendi'
                        });
                    } else {
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
                            icon: 'error',
                            title: 'Bilinmeyen Bir Hata Oluştu'
                        });
                    }
                }
            })

        });
        $(document).ready(function () {
            $.get("controller/alis_controller/sql.php?islem=birimleri_getir", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        var birimAdi = item.birim_adi;
                        $(".fire_birim").append("" +
                            "<option value='" + item.id + "'>" + birimAdi.toUpperCase() + "</option>" +
                            "");
                    })
                }
            });
            $("#stok_fire_cikisi_ekle_modal").modal("show");
            setTimeout(function () {
                $("#click_bait").trigger("click");
            }, 300);
            table = $('#stok_fire_table').DataTable({
                scrollY: '45vh',
                scrollX: true,
                searching: false,
                "info": false,
                "paging": false,
                bAutoWidth: false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row) {
                    $(row).addClass("fire_list");
                }
            })
        });


        $("body").off("click", ".fire_list").on("click", ".fire_list", function () {
            var id = $(this).attr("data-id");
            $(".fire_list").removeClass("secildi");
            $(this).addClass("secildi");
            $("#fire_kaydi_guncelle").attr("data-id", id);
            $.get("controller/stok_controller/sql.php?islem=secilenleri_getir", {id: id}, function (result) {
                if (result != 2) {
                    arr = [];
                    var item = JSON.parse(result);
                    var stok_id = item.stok_id;
                    var stok_adi = item.stok_adi;
                    var stok_kodu = item.stok_kodu;
                    var birim_id = item.birim_id;
                    var aciklama = item.aciklama;
                    var miktar = item.miktar;
                    arr["stok_id"] = stok_id;
                    arr["miktar"] = miktar;
                    $(".stok_kodu_fire").attr("data-id", stok_id);
                    $(".stok_kodu_fire").val(stok_kodu.toUpperCase());
                    $("#stok_adi").val(stok_adi.toUpperCase());
                    $("#birim_id").val(birim_id);
                    $("#aciklama").val(aciklama);
                    $(".miktar").val(miktar);
                }
            })
        });

        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            var list_ids = [];
            $(".fire_list").each(function () {
                var id = $(this).attr("data-id");
                list_ids.push(id);
            });
            $.ajax({
                url: "controller/stok_controller/sql.php?islem=fire_cikis_iptal_sql",
                type: "POST",
                data: {
                    list_ids: list_ids
                },
                success: function (result) {
                    if (list_ids == null || list_ids == "") {
                        $("#stok_fire_cikisi_ekle_modal").modal("hide");
                    } else {
                        if (result == 1) {
                            $("#stok_fire_cikisi_ekle_modal").modal("hide");
                        }
                    }
                }
            })
        });

        $("body").off("click", "#stok_listesini_getir").on("click", "#stok_listesini_getir", function () {
            $.get("modals/stok_modal/fire_modal.php?islem=stok_listesi_getir", function (getModal) {
                $("#stok_listesi_div").html("");
                $("#stok_listesi_div").html(getModal);
            })
        });

    </script>
    <?php
}
if ($islem == "stok_listesi_getir") {
    ?>
    <div class="modal fade" data-backdrop="static" id="fatura_stoklari_getir_modal_getir"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 50%; max-width: 50%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Stok Listesi
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat1"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="fatura_stok_liste">
                            <thead>
                            <tr>
                                <th id="click1_stok">Stok Kodu</th>
                                <th>Stok Adı</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $("#click1_stok").trigger("click");
            }, 300);
            $("#fatura_stoklari_getir_modal_getir").modal("show");

            var stok_table = $('#fatura_stok_liste').DataTable({
                scrollY: '35vh',
                scrollX: true,
                "info": false,
                "paging": false,
                "dom": '<"pull-left"f><"pull-right"l>tip',
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row) {
                    $(row).addClass("stock_select");
                }
            })
            $.get("controller/stok_controller/sql.php?islem=stok_listesi_getir", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        var stok_list = stok_table.row.add([item.stok_kodu, item.stok_adi]).draw(false).node();
                        $(stok_list).attr("data-id", item.id);
                        $(stok_list).find('td').eq(0).css('text-align', 'left');
                        $(stok_list).find('td').eq(1).css('text-align', 'left');
                    });
                }
            });

            $("body").off("click", ".stock_select").on("click", ".stock_select", function () {
                var id = $(this).attr("data-id");
                $.get("controller/alis_controller/sql.php?islem=secilen_stok_bilgileri", {id: id}, function (result) {
                    if (result != 2) {
                        var item = JSON.parse(result);
                        $(".stok_kodu_fire").val(item.stok_kodu);
                        $(".stok_kodu_fire").attr("data-id", id);
                        $("#stok_adi").val(item.stok_adi);
                        $(".fire_birim").val(item.birim);
                        $(".miktar").focus();
                        $(".miktar").select();
                        $("#fatura_stoklari_getir_modal_getir").modal("hide");
                    }
                })
            });
        });
        $("body").off("click", "#modal_kapat1").on("click", "#modal_kapat1", function () {
            $("#fatura_stoklari_getir_modal_getir").modal("hide");
        });
    </script>
    <?php
}
if ($islem == "stok_fire_guncelle") {
    ?>
    <div class="modal fade" id="stok_fire_guncelle_modal" data-backdrop="static" data-bs-keyboard="false"
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
                            <div class="ibox-title" style='color:white; font-weight:bold;'>STOK FİRE GÜNCELLE</div>
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
                                  <label>Birim</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="custom-select custom-select-sm" id="birim_id">
                                        <option value="">Birim Seçiniz...</option>
                                    </select>
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
                                           id="birim_fiyat">
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
                            <button class="btn btn-success btn-sm" id="stok_fire_guncelle_button"><i
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
            $.get("controller/alis_controller/sql.php?islem=birimleri_getir", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        var birimAdi = item.birim_adi;
                        $("#birim_id").append("" +
                            "<option value='" + item.id + "'>" + birimAdi.toUpperCase() + "</option>" +
                            "");
                    })
                }
            });
            $("#stok_fire_guncelle_modal").modal("show");
            $.get("controller/stok_controller/sql.php?islem=stok_fire_bilgileri_getir_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
                if (res != 2) {
                    var item = JSON.parse(res);
                    $(".stok_kodu_getir").attr("data-id", item.stok_id);
                    $(".stok_kodu_getir").val(item.stok_kodu);
                    $(".stok_adi_getir").val(item.stok_adi);
                    let birim_fiyat = item.birim_fiyat;
                    setTimeout(function (){
                        $("#birim_id").val(item.birim_id);
                    },500);
                    birim_fiyat = parseFloat(birim_fiyat);
                    $("#birim_fiyat").val(birim_fiyat.toLocaleString("tr-TR", {
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
        $("body").off("focusout", "#birim_fiyat").on("focusout", "#birim_fiyat", function () {
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

        $("body").off("click", "#stok_fire_guncelle_button").on("click", "#stok_fire_guncelle_button", function () {
            let birim_fiyat = $("#birim_fiyat").val();
            birim_fiyat = birim_fiyat.replace(/\./g, "").replace(",", ".");
            birim_fiyat = parseFloat(birim_fiyat);
            let miktar = $("#miktar").val();
            let birim_id = $("#birim_id").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            let aciklama = $("#aciklama").val();
            let depo_id = $("#depo_id").val();
            let cari_id = $(".stok_kodu_getir").attr("data-id");
            if (cari_id == undefined || cari_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Stok Belirtiniz...",
                    "warning"
                );
            }else if (birim_id == undefined || birim_id == "") {
                Swal.fire(
                    "Uyarı!",
                    "Lütfen Bir Birim Seçiniz...",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "controller/stok_controller/sql.php?islem=stok_fire_guncelle_sql",
                    type: "POST",
                    data: {
                        birim_fiyat: birim_fiyat,
                        miktar: miktar,
                        aciklama: aciklama,
                        birim_id: birim_id,
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
                            $("#stok_fire_guncelle_modal").modal("hide");
                            $.get("view/stok_fire.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("view/stok_fire.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }
        });

        $("body").off("click", "#acilis_vazgec_cari").on("click", "#acilis_vazgec_cari", function () {
            $("#stok_fire_guncelle_modal").modal("hide");
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