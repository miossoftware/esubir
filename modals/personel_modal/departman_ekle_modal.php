<?php

$islem = $_GET["islem"];

if ($islem == "departman_ekle_modal_getir") {
    ?>
    <div class="modal fade" id="departman_tanim_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="width: 25%; max-width: 25%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="departman_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>DEPARTMAN TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Departman Adı</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control form-control-sm" id="departman_adi">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="departman_vazgec"><i class="fa fa-close"></i> Vazgeç</button>
                            <button class="btn btn-success btn-sm" id="departman_kaydet"><i class="fa fa-close"></i> Kaydet</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function (){
            $("#departman_tanim_modal").modal("show");
        })

        $("body").off("click","#departman_kaydet").on("click","#departman_kaydet",function (){
            let gorev_adi = $("#departman_adi").val();
            $.ajax({
                url:"controller/personel_controller/sql.php?islem=departman_ekle_sql",
                type:"POST",
                data:{
                    departman_adi:gorev_adi
                },
                success:function (result){
                    if (result == 1){
                        $("#departman_tanim_modal").modal("hide");
                        Swal.fire(
                            'Başarılı!',
                            'Departman Kaydedildi',
                            'success'
                        );
                        $.get("view/departman_tanim.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                        $.get("view/departman_tanim.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                    }
                }
            })
        })

        $("body").off("click","#departman_vazgec").on("click","#departman_vazgec",function (){
            $("#departman_tanim_modal").modal("hide");
        });

    </script>
    <?php
}