<?php

$islem = $_GET["islem"];

if ($islem == "meslek_ekle_modal_getir") {
    ?>
    <div class="modal fade" id="meslek_tanim_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="width: 25%; max-width: 25%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="meslek_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>MESLEK TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Meslek Adı</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control form-control-sm" id="meslek_adi">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="meslek_vazgec"><i class="fa fa-close"></i> Vazgeç</button>
                            <button class="btn btn-success btn-sm" id="departman_kaydet"><i class="fa fa-close"></i> Kaydet</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function (){
            $("#meslek_tanim_modal").modal("show");
        })

        $("body").off("click","#departman_kaydet").on("click","#departman_kaydet",function (){
            let gorev_adi = $("#meslek_adi").val();
            $.ajax({
                url:"controller/personel_controller/sql.php?islem=meslek_ekle_sql",
                type:"POST",
                data:{
                    meslek_adi:gorev_adi
                },
                success:function (result){
                    if (result == 1){
                        $("#meslek_tanim_modal").modal("hide");
                        Swal.fire(
                            'Başarılı!',
                            'Departman Kaydedildi',
                            'success'
                        );
                        $.get("view/meslek_tanim.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                        $.get("view/meslek_tanim.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                    }
                }
            })
        })

        $("body").off("click","#meslek_vazgec").on("click","#meslek_vazgec",function (){
            $("#meslek_tanim_modal").modal("hide");
        });

    </script>
    <?php
}