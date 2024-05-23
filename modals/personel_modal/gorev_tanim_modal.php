<?php

$islem = $_GET["islem"];

if ($islem == "gorev_tanimla_modal") {
    ?>
    <div class="modal fade" id="gorev_tanim_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="width: 25%; max-width: 25%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="gorev_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>GÖREV TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Görev Adı</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control form-control-sm" id="gorev_adi">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="gorev_vazgec"><i class="fa fa-close"></i> Vazgeç</button>
                            <button class="btn btn-success btn-sm" id="gorev_kaydet"><i class="fa fa-close"></i> Kaydet</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function (){
            $("#gorev_tanim_modal").modal("show");
        })

        $("body").off("click","#gorev_kaydet").on("click","#gorev_kaydet",function (){
            let gorev_adi = $("#gorev_adi").val();
            $.ajax({
                url:"controller/personel_controller/sql.php?islem=gorev_tanimla_sql",
                type:"POST",
                data:{
                    gorev_adi:gorev_adi
                },
                success:function (result){
                    if (result == 1){
                        $("#gorev_tanim_modal").modal("hide");
                        Swal.fire(
                            'Başarılı!',
                            'Görev Kaydedildi',
                            'success'
                        );
                        $.get("view/gorev_tanim.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                        $.get("view/gorev_tanim.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                    }
                }
            })
        })

        $("body").off("click","#gorev_vazgec").on("click","#gorev_vazgec",function (){
            $("#gorev_tanim_modal").modal("hide");
        });

    </script>
    <?php
}