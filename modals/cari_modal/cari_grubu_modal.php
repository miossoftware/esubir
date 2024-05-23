<?php

$islem = $_GET["islem"];

if ($islem == "cari_grubu_tanimla") {
    ?>
    <div class="modal fade" id="cari_grubu_tanim_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog modal-dialog-centered" style="width: 25%; max-width: 25%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="cari_grubu_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>CARİ GRUBU TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="col-12">
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Cari Grubu</label>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control form-control-sm" id="cari_grubu">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-4">
                                        <label>Gider Hesabı</label>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="custom-select custom-select-sm" id="gider_hesabi">
                                            <option value="0">Hayır</option>
                                            <option value="1">Evet</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="cari_grubu_vazgec"><i class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="cari_grubu_kaydet"><i class="fa fa-close"></i>
                                Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('input').click(function() {
            $(this).select();
        });
        $(document).ready(function (){
            $("#cari_grubu_tanim_modal").modal("show");
        })

        $("body").off("click","#cari_grubu_kaydet").on("click","#cari_grubu_kaydet",function (){
            var cari_grup_adi = $("#cari_grubu").val();
            var gider_hesabi = $("#gider_hesabi").val();
            $.ajax({
                url:"controller/cari_controller/sql.php?islem=cari_grubu_tanimla_sql",
                type:"POST",
                data:{
                    cari_grup_adi:cari_grup_adi,
                    gider_hesabi:gider_hesabi
                },
                success:function (result){
                    if (result == 1){
                        $("#cari_grubu_tanim_modal").modal("hide");
                        Swal.fire(
                            'Başarılı!',
                            'Cari Grubu Tanımlandı',
                            'success'
                        );
                        $.get("view/cari_grup_tanim.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                        $.get("view/cari_grup_tanim.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                    }
                }
            })
        });

        $("body").off("click","#cari_grubu_vazgec").on("click","#cari_grubu_vazgec",function (){
            $("#cari_grubu_tanim_modal").modal("hide");
        })
    </script>
    <?php
}