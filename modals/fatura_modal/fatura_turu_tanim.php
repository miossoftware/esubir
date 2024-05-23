<?php

$islem = $_GET["islem"];

if ($islem == "fatura_turu_tanimla_modal") {
    ?>
    <div class="modal fade" id="fatura_turu_tanim_main_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="width: 25%; max-width: 25%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="fatura_turu_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>FATURA TÜRÜ TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Modül Tipi</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="custom-select custom-select-sm" id="modul_id">
                                            <option value="">Seçiniz...</option>
                                            <option value="1" selected>Alış Yönetimi</option>
                                            <option value="2">Satış Yönetimi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Fatura Türü</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control form-control-sm" id="gorev_adi">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="fatura_turu_vazgec"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="fatura_turu_kaydet"><i class="fa fa-close"></i>
                                Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#fatura_turu_tanim_main_modal").modal("show");
        })

        $("body").off("click", "#fatura_turu_kaydet").on("click", "#fatura_turu_kaydet", function () {
            let fatura_turu_adi = $("#gorev_adi").val();
            let modul_id = $("#modul_id").val();
            $.ajax({
                url: "controller/fatura_controller/sql.php?islem=fatura_turu_olustur_sql",
                type: "POST",
                data: {
                    fatura_turu_adi: fatura_turu_adi,
                    modul_id: modul_id
                },
                success: function (result) {
                    if (result == 1) {
                        $("#fatura_turu_tanim_main_modal").modal("hide");
                        Swal.fire(
                            'Başarılı!',
                            'Fatura Türü Kaydedildi',
                            'success'
                        );
                        $.get("view/fatura_turu.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                        $.get("view/fatura_turu.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                    }
                }
            });
        })

        $("body").off("click", "#fatura_turu_vazgec").on("click", "#fatura_turu_vazgec", function () {
            $("#fatura_turu_tanim_main_modal").modal("hide");
        })
    </script>
    <?php
}
if ($islem == "fatura_tipi_tanimla_modal") {
    ?>
    <div class="modal fade" id="fatura_tipi_tanim_main_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="width: 25%; max-width: 25%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="fatura_tipi_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>FATURA TİPİ TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Modül Tipi</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="custom-select custom-select-sm" id="modul_id">
                                            <option value="">Seçiniz...</option>
                                            <option value="1" selected>Alış Yönetimi</option>
                                            <option value="2">Satış Yönetimi</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Fatura Tipi</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control form-control-sm" id="gorev_adi">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="fatura_tipi_vazgec"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="fatura_tipi_kaydet"><i class="fa fa-close"></i>
                                Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function (){
            $("#fatura_tipi_tanim_main_modal").modal("show");
        })

        $("body").off("click","#fatura_tipi_vazgec").on("click","#fatura_tipi_vazgec",function (){
            $("#fatura_tipi_tanim_main_modal").modal("hide");
        })

        $("body").off("click","#fatura_tipi_kaydet").on("click","#fatura_tipi_kaydet",function (){
            let fatura_turu_adi = $("#gorev_adi").val();
            let modul_id = $("#modul_id").val();
            $.ajax({
                url:"controller/fatura_controller/sql.php?islem=fatura_tipi_kaydet_sql",
                type:"POST",
                data:{
                    fatura_tip_adi:fatura_turu_adi,
                    modul_id:modul_id
                },
                success:function (result){
                    if (result == 1){
                        $("#fatura_tipi_tanim_main_modal").modal("hide");
                        Swal.fire(
                            'Başarılı!',
                            'Fatura Tipi Kaydedildi',
                            'success'
                        );
                        $.get("view/fatura_tipi.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                        $.get("view/fatura_tipi.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                    }
                }
            })
        });

    </script>
    <?php
}