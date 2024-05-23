<?php

$islem = $_GET["islem"];

if ($islem == "sayim_fazlasi_ekle_modal_getir") {
    ?>

    <style>
        #sayim_fazlasi_ekle_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="sayim_fazlasi_ekle_modal" data-backdrop="static" data-bs-keyboard="false"
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
                        <div class="ibox-title" style='color:white; font-weight:bold;'>STOK SAYIM FAZLASI</div>
                    </div>
                    <div class="modal-body">
                        <div id="stok_listesi_div"></div>
                        <div class="col-12 row mt-2 no-gutters">
                            <div class="col-md-2">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;Tarih</label>
                                <input type="date" value="<?= date("Y-m-d") ?>"
                                       class="form-control form-control-sm mx-2"
                                       placeholder="" id="tarih">
                            </div>
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
                                <input type="text" class="form-control form-control-sm miktar"
                                       style="text-align: right" placeholder="Miktar" value="0,00">
                            </div>
                            <div class="col-md-2">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;Birim
                                    Fiyat</label>
                                <input type="text" class="form-control form-control-sm " id="birim_fiyat"
                                       style="text-align: right" placeholder="Birim Fiyat" value="0,00">
                            </div>
                            <div class="col-md-2">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Açıklama</label>
                                <input type="text" class="form-control form-control-sm" id="aciklama"
                                       placeholder="Açıklama">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="col-2">
                                <button style="width: 100% !important;"
                                        class="btn btn-success btn-sm mx-5" id="sayim_fazlasi_ekle_button"><i
                                            class="fa fa-plus"></i> Ekle
                                </button>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <table class="table table-sm table-bordered w-100 display nowrap datatable"
                                   style="cursor:pointer;font-size: 13px;"
                                   id="stok_fire_table">
                                <thead>
                                <tr>
                                    <th>Tarih</th>
                                    <th id="click_bait">Stok Kodu</th>
                                    <th>Stok Adı</th>
                                    <th>Birimi</th>
                                    <th>Fazla Miktar</th>
                                    <th>Birim Fiyat</th>
                                    <th>Tutar</th>
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
                    <button class="btn btn-success btn-sm" id="stok_sayim_fazlasi_kaydet_button"><i
                                class="fa fa-close"></i> Kaydet
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('input').click(function () {
            $(this).select();
        });
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

        $("body").off("click", "#stok_sayim_fazlasi_kaydet_button").on("click", "#stok_sayim_fazlasi_kaydet_button", function () {
            let gidecek_arr = [];

            $(".sayim_fazlasi_list").each(function () {
                let tarih = $(this).find("td").eq(0).text();
                tarih = tarih.split("/");
                let g = tarih[0];
                let a = tarih[1];
                let y = tarih[2];
                let arr = [y, a, g];
                tarih = arr.join("-");
                let stok_id = $(this).attr("stok_id");
                let birim_id = $(this).attr("birim_id");
                let fazla_miktar = $(this).find("td").eq(4).text();
                fazla_miktar = fazla_miktar.replace(/\./g, "").replace(",", ".");
                fazla_miktar = parseFloat(fazla_miktar);
                let birim_fiyat = $(this).find("td").eq(5).text();
                birim_fiyat = birim_fiyat.replace(/\./g, "").replace(",", ".");
                birim_fiyat = parseFloat(birim_fiyat);
                let aciklama = $(this).find("td").eq(7).text();

                let newRow = {
                    tarih: tarih,
                    stok_id: stok_id,
                    birim_id: birim_id,
                    miktar: fazla_miktar,
                    birim_fiyat: birim_fiyat,
                    aciklama: aciklama
                };
                gidecek_arr.push(newRow);
            });
            if (gidecek_arr.length === 0) {
                Swal.fire(
                    "Uyarı",
                    "Herhangi Bir Giriş Olmadı",
                    "warning"
                );
            } else {
                $.ajax({
                    url: "controller/stok_controller/sql.php?islem=stok_sayim_fazlasi_kaydet_sql",
                    type: "POST",
                    data: {
                        gidecek_arr: gidecek_arr
                    },
                    success: function (res) {
                        if (res == 1) {
                            Swal.fire(
                                "Başarılı",
                                "Stok Sayım Fazlası Kaydedildi",
                                "success"
                            );
                            $("#sayim_fazlasi_ekle_modal").modal("hide");
                            $.get("view/stok_sayim_fazlasi.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("view/stok_sayim_fazlasi.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }
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
            $("#sayim_fazlasi_ekle_modal").modal("show");
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
                    $(row).addClass("sayim_fazlasi_list");
                }
            })
        });

        $("body").off("click", "#sayim_fazlasi_ekle_button").on("click", "#sayim_fazlasi_ekle_button", function () {
            let stok_id = $(".stok_kodu_fire").attr("data-id");
            let stok_kodu = $(".stok_kodu_fire").val();
            let stok_adi = $("#stok_adi").val();
            let birim_id = $("#birim_id").val();
            let tarih = $("#tarih").val();
            tarih = tarih.split("-");
            let g = tarih[2];
            let a = tarih[1];
            let y = tarih[0];
            let arr = [g, a, y];
            tarih = arr.join("/");
            let birim_adi = $("#birim_id option:selected").text();
            let aciklama = $("#aciklama").val();
            let miktar = $(".miktar").val();
            let birim_fiyat = $("#birim_fiyat").val();
            let miktar_hesap = miktar.replace(/\./g, "").replace(",", ".");
            miktar_hesap = parseFloat(miktar_hesap);
            let birim_fiyat_hesap = birim_fiyat.replace(/\./g, "").replace(",", ".");
            birim_fiyat_hesap = parseFloat(birim_fiyat_hesap);
            let ara_toplam = birim_fiyat_hesap * miktar_hesap;
            ara_toplam = ara_toplam.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
            let rows = table.row.add([tarih, stok_adi, stok_kodu, birim_adi, miktar, birim_fiyat, ara_toplam, aciklama, "<button class='btn btn-danger btn-sm fazlayi_sil_button'><i class='fa fa-trash'></i></button>"]).draw(false).node();
            $(rows).attr("stok_id", stok_id);
            $(rows).attr("birim_id", birim_id);

            $(".stok_kodu_fire").attr("data-id", "");
            $(".stok_kodu_fire").val("");
            $("#stok_adi").val("");
            $("#birim_id").val("");
            $("#aciklama").val("");
            $(".miktar").val("");
            $("#birim_fiyat").val("");
        });

        $("body").off("click", ".fazlayi_sil_button").on("click", ".fazlayi_sil_button", function () {
            var row = $(this).closest('tr');
            table.row(row).remove().draw(false);
        });


        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {

            $("#sayim_fazlasi_ekle_modal").modal("hide");
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
if ($islem == "sayim_fazlasi_guncelle_modal_getir") {
    ?>
      <div class="modal fade" id="stok_sayim_fazlasi_guncelle_modal" data-backdrop="static" data-bs-keyboard="false"
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
                            <button class="btn btn-success btn-sm" id="stok_sayim_fazlasi_guncelle_list_button"><i
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
            $("#stok_sayim_fazlasi_guncelle_modal").modal("show");
            $.get("controller/stok_controller/sql.php?islem=stok_sayim_fazlasi_bilgileri_getir_sql", {id: "<?=$_GET["id"]?>"}, function (res) {
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

        $("body").off("click", "#stok_sayim_fazlasi_guncelle_list_button").on("click", "#stok_sayim_fazlasi_guncelle_list_button", function () {
            let birim_fiyat = $("#birim_fiyat").val();
            birim_fiyat = birim_fiyat.replace(/\./g, "").replace(",", ".");
            birim_fiyat = parseFloat(birim_fiyat);
            let miktar = $("#miktar").val();
            let birim_id = $("#birim_id").val();
            miktar = miktar.replace(/\./g, "").replace(",", ".");
            miktar = parseFloat(miktar);
            let aciklama = $("#aciklama").val();
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
                    url: "controller/stok_controller/sql.php?islem=stok_sayim_fazlasi_guncelle_sql",
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
                            $("#stok_sayim_fazlasi_guncelle_modal").modal("hide");
                            $.get("view/stok_sayim_fazlasi.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("view/stok_sayim_fazlasi.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }
        });

        $("body").off("click", "#acilis_vazgec_cari").on("click", "#acilis_vazgec_cari", function () {
            $("#stok_sayim_fazlasi_guncelle_modal").modal("hide");
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