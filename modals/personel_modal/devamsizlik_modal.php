<?php

$islem = $_GET["islem"];

if ($islem == "personel_devamsizlik_ekle") {
    ?>
    <div class="modal fade" id="personel_devamsizlik_ekle" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog " style="width: 45%; max-width: 45%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="devamsizlik_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>PERSONEL DEVAMSIZLIK EKLE
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="devamsizlik_per_div"></div>
                            <div class="col-12 row">
                                <div class="col-6">

                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Personel Kodu</label>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control form-control-sm"
                                                       id="personel_kodu_devamsizlik">
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
                                            <label>Devamsızlık Türü</label>
                                        </div>
                                        <div class="col-md-7">
                                            <select class="custom-select custom-select-sm" id="devamsizlik_turu">
                                                <option value="">Devamsızlık Türü Seçiniz...</option>
                                                <option value="Raporlu">Raporlu</option>
                                                <option value="Devamsızlık">Devamsızlık</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Başlangıç Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" value="<?= date("Y-m-d") ?>"
                                                   class="form-control form-control-sm" id="devamsizlik_bas">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Bitiş Tarihi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="date" class="form-control form-control-sm" id="devamsizlik_bit">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-5">
                                            <label>Devamsızlık Süresi</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control form-control-sm" id="devamsizlik_suresi">
                                        </div>
                                    </div>
                                    <input type="checkbox" id="etkilensin"> <label for="etkilensin">Maaş Etkilensin</label>
                                </div>
                                <div class="col-6">
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea class="form-control form-control-sm" id="aciklama" style="resize: none" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn btn-danger btn-sm" id="devamsizlik_vazgec"><i class="fa fa-close"></i>
                                Vazgeç
                            </div>
                            <div class="btn btn-success btn-sm" id="devamszilik_kaydet"><i class="fa fa-checked"></i> Kaydet</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#personel_devamsizlik_ekle").modal("show");
        })

        $("body").off("click", "#devamsizlik_vazgec").on("click", "#devamsizlik_vazgec", function () {
            $("#personel_devamsizlik_ekle").modal("hide");
        });

        $("body").off("click","#devamszilik_kaydet").on("click","#devamszilik_kaydet",function (){
            let personel_id = $("#personel_kodu_devamsizlik").attr("data-id");
            let devamsizlik_bas = $("#devamsizlik_bas").val();
            let devamsizlik_turu = $("#devamsizlik_turu").val();
            let devamsizlik_bit = $("#devamsizlik_bit").val();
            let devamsizlik_suresi = $("#devamsizlik_suresi").val();

            let aciklama = $("#aciklama").val();
            if (personel_id == undefined || personel_id == ""){

            }else if (devamsizlik_suresi == 0){

            }else {
                let maas_etkilensin = 0;
                if ($("#etkilensin").is(":checked")){
                    maas_etkilensin = 1;
                }
                let hesaplama_sekli = 2;
                if (devamsizlik_suresi > 30){
                    hesaplama_sekli = 1;
                }
                $.ajax({
                    url:"controller/personel_controller/sql.php?islem=personel_devamsizlik_ekle_sql",
                    type:"POST",
                    data:{
                        hesaplama_sekli:hesaplama_sekli,
                        personel_id:personel_id,
                        devamsizlik_bas:devamsizlik_bas,
                        devamsizlik_turu:devamsizlik_turu,
                        devamsizlik_bit:devamsizlik_bit,
                        devamsizlik_suresi:devamsizlik_suresi,
                        maas_etkilensin:maas_etkilensin,
                        aciklama:aciklama
                    },
                    success:function (result){
                        if (result == 1){
                            $("#personel_devamsizlik_ekle").modal("hide");
                            Swal.fire(
                                'Başarılı!',
                                'Devamsizlik Kaydedildi',
                                'success'
                            );
                            $.get("view/personel_devamsizlik.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                            $.get("view/personel_devamsizlik.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                        }
                    }
                });
            }

        });

        $("#devamsizlik_bit").focusout(function () {
            let bas_tarih = new Date($("#devamsizlik_bas").val());
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
                    title: 'Devamsızlık Başlangıç Tarihi Bitiş Tarihinden Küçük Olamaz'
                });
                $("#devamsizlik_suresi").val("0");
                $("#devamsizlik_suresi").prop("disabled", true);
            } else {
                $("#devamsizlik_suresi").prop("disabled", false);
                let farkMilisaniye = bit_tarih.getTime() - bas_tarih.getTime();
                let farkGun = Math.ceil(farkMilisaniye / (1000 * 60 * 60 * 24));
                if (isNaN(farkGun)) {
                    farkGun = 0;
                }
                $("#devamsizlik_suresi").val(farkGun);
            }
        })

        $("#personel_kodu_devamsizlik").keyup(function () {
            var val = $(this).val();
            $.get("controller/personel_controller/sql.php?islem=girilen_personel_bilgisi", {personel_kodu: val}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#personel_kodu_devamsizlik").attr("data-id", item.id);
                    $("#personel_kodu_devamsizlik").val(item.personel_kodu);
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
        })

        $("body").off("click", "#personelleri_getir_modal").on("click", "#personelleri_getir_modal", function () {
            $.get("modals/personel_modal/devamsizlik_modal.php?islem=devamsizlik_icin_personel_getir", function (getModal) {
                $(".devamsizlik_per_div").html("");
                $(".devamsizlik_per_div").html(getModal);
            })
        })
    </script>
    <?php
}
if ($islem == "devamsizlik_icin_personel_getir") {
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
                scrollable: false,
                "info": false,
                createdRow: function (row) {
                    $(row).addClass("secilen_personel")
                },
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
            });
            $.get("controller/personel_controller/sql.php?islem=personelleri_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        var new_row = table.row.add([item.ad_soyad, item.personel_kodu]).draw(false).node();
                        $(new_row).attr("data-id", item.id);
                        $(new_row).find("td").eq(0).css("text-align", "left");
                        $(new_row).find("td").eq(1).css("text-align", "left");
                    })
                }
            })
            setTimeout(function () {
                $("#click1").trigger("click");
            }, 400)
            $("#personel_getir_modal").modal("show");
        });

        $("body").off("click", ".secilen_personel").on("click", ".secilen_personel", function () {
            let id = $(this).attr("data-id");
            let personel_kodu = $(this).find("td").eq(1).text();
            $("#personel_kodu_devamsizlik").attr("data-id", id);
            $("#personel_kodu_devamsizlik").val(personel_kodu);
            $("#personel_getir_modal").modal("hide");
        });


        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#personel_getir_modal").modal("hide");
        })
    </script>
    <?php
}