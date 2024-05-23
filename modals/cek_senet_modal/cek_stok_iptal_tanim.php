<?php

$islem = $_GET["islem"];

if ($islem == "cek_iptal_et_modal") {
    ?>
    <div class="modal fade" id="cek_iptal_tanim_modal" data-backdrop="static"
         data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 55%; max-width: 55%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="vazgec_cek_stok_iptal"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>ÇEK İPTAL GİRİŞ
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="cek_tanim_icin_banka_getir"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Banka Kodu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-sm" id="banka_kodu_cek_stok">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm" id="banka_liste_getir_cek_tanim"><i class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Banka Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" disabled class="form-control form-control-sm" id="banka_adi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Şube Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" disabled class="form-control form-control-sm" id="sube_adi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Yetkili Adı</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" disabled class="form-control form-control-sm" id="yetkili_adi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>İptal Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" class="form-control form-control-sm" value="<?=date("Y-m-d")?>" id="iptal_tarihi">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>Çek Numarası</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="cek_numarasi">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label>İptal Sebebi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <textarea class="form-control form-control-sm" id="cekin_iptal_sebebi" style="resize: none" rows="8"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger btn-sm" id="vazgec_cek_stok_iptal"><i class="fa fa-close"></i> Vazgeç</button>
                                <button class="btn btn-success btn-sm" id="stok_iptal_kaydet"><i class="fa fa-check"></i> Kaydet</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("body").off("click","#stok_iptal_kaydet").on("click","#stok_iptal_kaydet",function (){
            let banka_id = $("#banka_kodu_cek_stok").attr("data-id");
            let iptal_tarihi = $("#iptal_tarihi").val();
            let cek_numarasi = $("#cek_numarasi").val();
            let cekin_iptal_sebebi = $("#cekin_iptal_sebebi").val();
            if (banka_id == "" || banka_id == undefined){
                Swal.fire(
                    'Uyarı!',
                    'Lütfen Banka Giriniz...',
                    'warning'
                );
            }else {
                $.ajax({
                    url:"controller/cek_senet_controller/sql.php?islem=tanimlanmis_ceki_iptal_et_sql",
                    type:"POST",
                    data:{
                        banka_id:banka_id,
                        iptal_tarihi:iptal_tarihi,
                        cek_numarasi:cek_numarasi,
                        cekin_iptal_sebebi:cekin_iptal_sebebi
                    },
                    success:function (result){
                        if (result == 1){

                        }
                    }
                });
            }
        });

        $("body").off("click","#vazgec_cek_stok_iptal").on("click","#vazgec_cek_stok_iptal",function (){
            $("#cek_iptal_tanim_modal").modal("hide");
        })

        $(document).ready(function (){
            $("#cek_iptal_tanim_modal").modal("show");
        })

        $("body").off("click","#banka_liste_getir_cek_tanim").on("click","#banka_liste_getir_cek_tanim",function (){
            $.get("modals/cek_senet_modal/another_modal.php?islem=banka_listesi_getir_modal",function (getModal){
                $(".cek_tanim_icin_banka_getir").html("");
                $(".cek_tanim_icin_banka_getir").html(getModal);
            })
        })

    </script>
    <?php
}