<?php

$islem = $_GET["islem"];

if ($islem == "yeni_izin_tanimla") {
    ?>

    <div class="modal fade" id="personele_izin_ekle" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog " style="width: 45%; max-width: 45%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="izin_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>PERSONEL İZİN EKLE</div>
                        </div>
                        <div class="modal-body">
                            <div class="per_getir_div"></div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Personel Kodu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="personel_kodu">
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning btn-sm"
                                                            id="personelleri_getir_modal"><i
                                                                class="fa fa-ellipsis-h"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>İzin Başlangıç</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>"
                                                   class="form-control form-control-sm" id="izin_bas">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>İzin Bitiş</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" class="form-control form-control-sm" id="izin_bit">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>İzin Gün</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="number" class="form-control form-control-sm" id="gun">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>İzin Türü</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="izin_turu">
                                                <option value="">İzin Türü Seçiniz...</option>
                                                <option value="Yıllık İzin">Yıllık İzin</option>
                                                <option value="Ücretsiz İzin">Ücretsiz İzin</option>
                                                <option value="Günlük İzin">Günlük İzin</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Dönüş Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" class="form-control form-control-sm" id="donus_tarih">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>İzin Adresi</label>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea style="resize: none" class="form-control form-control-sm"
                                                      id="izin_adres" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea style="resize: none" class="form-control form-control-sm"
                                                      id="aciklama" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="izin_vazgec"><i class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="izin_kaydet"><i class="fa fa-check"></i> Kaydet</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("body").off("click","#izin_kaydet").on("click","#izin_kaydet",function (){
            let personel_id = $("#personel_kodu").attr("data-id");
            let izin_baslangic = $("#izin_bas").val();
            let izin_bitis = $("#izin_bit").val();
            let izin_turu = $("#izin_turu").val();
            let donus_tarih = $("#donus_tarih").val();
            let izin_gun = $("#gun").val();
            let izin_adresi = $("#izin_adres").val();
            let aciklama = $("#aciklama").val();
            if (personel_id == undefined){
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
                    title: 'Personel Seçiniz...'
                });
            }else if (izin_gun == ""){
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
                    title: 'İzin Gün Boş Kalamaz'
                });
            }else {
                $.ajax({
                    url:"controller/personel_controller/sql.php?islem=personele_izin_ekle_sql",
                    type:"POST",
                    data:{
                        personel_id:personel_id,
                        izin_baslangic:izin_baslangic,
                        izin_bitis:izin_bitis,
                        izin_turu:izin_turu,
                        donus_tarih:donus_tarih,
                        izin_gun:izin_gun,
                        izin_adresi:izin_adresi,
                        aciklama:aciklama
                    },
                    success:function (result){
                        if (result == 1){
                            $("#personele_izin_ekle").modal("hide");
                            Swal.fire(
                                'Başarılı!',
                                'İzin Kaydedildi',
                                'success'
                            );
                            $.get("view/personel_izin.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                            $.get("view/personel_izin.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                        }else {
                            $("#personele_izin_ekle").modal("hide");
                        }
                    }
                });
            }
        });

        $(document).ready(function () {
            $("#personele_izin_ekle").modal("show");
        })

        $("body").off("click","#izin_vazgec").on("click","#izin_vazgec",function (){
            $("#personele_izin_ekle").modal("hide");
        });

        $("#izin_bit").focusout(function () {
            let bas_tarih = new Date($("#izin_bas").val());
            let bit_tarih = new Date($(this).val());
            if (bit_tarih < bas_tarih) {
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
                    title: 'İzin Başlangıç Tarihi Bitiş Tarihinden Küçük Olamaz'
                });
                $("#gun").val("0");
                $("#gun").prop("disabled", true);
            } else {
                $("#gun").prop("disabled", false);
                let farkMilisaniye = bit_tarih.getTime() - bas_tarih.getTime();
                let farkGun = Math.ceil(farkMilisaniye / (1000 * 60 * 60 * 24));
                if (isNaN(farkGun)){
                    farkGun = 0;
                }
                $("#gun").val(farkGun);
            }
        })

        $("body").off("click", "#personelleri_getir_modal").on("click", "#personelleri_getir_modal", function () {
            $.get("modals/personel_modal/izin_modal.php?islem=personelleri_getir", function (getModal) {
                $(".per_getir_div").html("");
                $(".per_getir_div").html(getModal);
            })
        })

        $("#personel_kodu").keyup(function (){
           var val = $(this).val();
           $.get("controller/personel_controller/sql.php?islem=girilen_personel_bilgisi",{personel_kodu:val},function (result){
               if (result != 2){
                   var item = JSON.parse(result);
                   $("#personel_kodu").attr("data-id",item.id)
                   $("#personel_kodu").val(item.personel_kodu)
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
                       title: 'Personel Eşleşti'
                   });
               }
           })
        });
    </script>
    <?php
}
if ($islem == "personelleri_getir") {
    ?>
    <div class="modal fade" data-backdrop="static" id="personel_getir_modal"
         data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog"
             style="width: 60%; max-width: 60%;">
            <div class="modal-content scrollsuz">
                <div class="modal-header text-white p-2">Personel Listesi
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 row">
                        <table class="table table-sm table-bordered w-100 display nowrap"
                               style="cursor:pointer;font-size: 13px;"
                               id="per_listesi">
                            <thead>
                            <tr>
                                <th id="click1">Personel Adı</th>
                                <th>Personel Kodu</th>
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
            var table = $('#per_listesi').DataTable({
                scrollY: '25vh',
                scrollX: true,
                scrollable:false,
                "info": false,
                createdRow: function (row) {
                    $(row).addClass("secilen_personel")
                },
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
            });
            $.get("controller/personel_controller/sql.php?islem=personelleri_getir_sql",function (result){
                if (result != 2){
                    var json = JSON.parse(result);
                    json.forEach(function (item){
                        var new_row = table.row.add([item.ad_soyad,item.personel_kodu]).draw(false).node();
                        $(new_row).attr("data-id",item.id);
                        $(new_row).find("td").eq(0).css("text-align","left");
                        $(new_row).find("td").eq(1).css("text-align","left");
                    })
                }
            })
            setTimeout(function (){
                $("#click1").trigger("click");
            },400)
            $("#personel_getir_modal").modal("show");
        });

        $("body").off("click",".secilen_personel").on("click",".secilen_personel",function (){
            let id = $(this).attr("data-id");
            let personel_kodu = $(this).find("td").eq(1).text();
            $("#personel_kodu").attr("data-id",id);
            $("#personel_kodu").val(personel_kodu);
            $("#personel_getir_modal").modal("hide");
        });



        $("body").off("click","#modal_kapat").on("click","#modal_kapat",function (){
            $("#personel_getir_modal").modal("hide");
        })
    </script>
    <?php
}
