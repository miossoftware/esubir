<?php

$islem = $_GET["islem"];

if ($islem == "kredi_karti_acilis_fisi_modal") {
    ?>
    <style>
        #kredi_karti_acilis_fisi_ekle_modal {
            overflow-y: scroll;
        }
    </style>
    <div class="modal fade" id="kredi_karti_acilis_fisi_ekle_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 35%; max-width: 35%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="pos_cekim_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>KREDİ KARTI AÇILIŞ FİŞİ</div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label>Kredi Kartı</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="custom-select custom-select-sm" id="kart_id">
                                        <option value="">Kredi Kartı Seçiniz...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label>Açılış Tarihi</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="date" value="<?= date("Y-m-d") ?>" class="form-control form-control-sm"
                                           id="acilis_tarihi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label>Borç</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" style="text-align: right" value="0,00"
                                           id="borc">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label>Alacak</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" style="text-align: right" value="0,00"
                                           id="alacak">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label>Açıklama</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control form-control-sm" style="text-align: right"
                                           id="aciklama">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="pos_cekim_vazgec"><i
                                        class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="acilislari_kaydet_cari"><i
                                        class="fa fa-plus"></i> Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#kredi_karti_acilis_fisi_ekle_modal").modal("show");
            $.get("controller/kart_controller/sql.php?islem=kartlari_getir_sql", function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    json.forEach(function (item) {
                        $("#kart_id").append("" +
                            "<option value='" + item.id + "'>" + item.kart_adi + "</option>" +
                            "");
                    });
                }
            })
        });

        $("body").off("click", "#pos_cekim_vazgec").on("click", "#pos_cekim_vazgec", function () {
            $("#kredi_karti_acilis_fisi_ekle_modal").modal("hide");
        });

        $("body").off("click", "#acilislari_kaydet_cari").on("click", "#acilislari_kaydet_cari", function () {
            let kart_id = $("#kart_id").val();
            let acilis_tarihi = $("#acilis_tarihi").val();
            let borc = $("#borc").val();
            borc = borc.replace(/\./g, "").replace(",", ".");
            borc = parseFloat(borc);
            let alacak = $("#alacak").val();
            alacak = alacak.replace(/\./g, "").replace(",", ".");
            alacak = parseFloat(alacak);
            let aciklama = $("#aciklama").val();
            if (kart_id == "") {
                Swal.fire(
                    'Uyarı!',
                    'Lütfen Bir Kart Seçiniz...',
                    'warning'
                );
            } else {
                $.ajax({
                    url: "controller/kart_controller/sql.php?islem=kart_acilis_fisi_kaydet_sql",
                    type: "POST",
                    data: {
                        kart_id: kart_id,
                        acilis_tarihi: acilis_tarihi,
                        borc: borc,
                        alacak: alacak,
                        aciklama: aciklama
                    },
                    success:function (res){
                        if (res == 1){
                            Swal.fire(
                                "Başarılı",
                                "Kredi Kartı Açılış Fişi Kaydedildi",
                                "success"
                            );
                            $("#kredi_karti_acilis_fisi_ekle_modal").modal("hide");
                            $.get("view/kredi_kart_acilis_fisi.php",function (getList){
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $.get("view/kredi_kart_acilis_fisi.php",function (getList){
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }
        });


        $("body").off("focusout", "#borc").on("focusout", "#borc", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });

        $("body").off("focusout", "#alacak").on("focusout", "#alacak", function () {
            let val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            $(this).val(val.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        });

    </script>
    <?php
}