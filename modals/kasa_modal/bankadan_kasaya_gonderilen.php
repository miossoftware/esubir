<?php

$islem = $_GET["islem"];

if ($islem == "bankadan_para_gonder_modal") {
    ?>

    <div class="modal fade" id="bankadan_kasaya_gonder_modal" data-bs-keyboard="false"
    role="dialog">
    <div class="modal-dialog" style="width: 75%; max-width: 75%;">
        <div class="modal-content">
            <div class="modal-header text-white p-2">Bankadan Kasaya Para Gönder
                <button type="button" class="btn-close btn-close-white" id="banka_transferden_vazgec"
                        aria-label="Close"></button>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head" style='background-color:#9DB2BF'>
                        <div class="ibox-title" style='color:white; font-weight:bold;'>BANKADAN KASAYA PARA GÖNDER</div>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 row no-gutters">
                            <div class="col mx-1">
                                <label style="font-weight: bold;font-size: 10px">Tarih</label>
                                <input type="date" value="<?=date("Y-m-d")?>" class="form-control form-control-sm" id="tarih">
                            </div>
                            <div class="col mx-1">
                                <label style="font-weight: bold;font-size: 10px">Kasa Adı</label>
                                <select class="custom-select custom-select-sm" id="kasa_adlari">
                                    <option value="">Seçiniz...</option>
                                </select>
                            </div>
                            <div class="col">
                                <label style="font-weight: bold;font-size: 10px">Banka Adı</label>
                                <select class="custom-select custom-select-sm" id="banka_adlari">
                                    <option value="">Seçiniz...</option>
                                </select>
                            </div>
                            <div class="col mx-1">
                                <label style="font-weight: bold;font-size: 10px">Gönderilen Miktar</label>
                                <input type="text" class="form-control form-control-sm" id="gonderilen_miktar">
                            </div>
                            <div class="col mx-1">
                                <label style="font-weight: bold;font-size: 10px">Açıklama</label>
                                <input type="text" class="form-control form-control-sm" id="aciklama">
                            </div>
                            <div class="col mt-2 row">
                                <button style="width: 70% !important;"
                                        class="btn btn-success btn-sm mx-5" id="bankadan_para_cek"><i
                                            class="fa fa-plus"></i> Ekle
                                </button>
                                <button style="background-color: #F6FA70;width: 70% !important;"
                                        class="btn btn-sm mx-5 mt-1"
                                        id="bankadan_transfer_kaydi_guncelle"><i
                                            class="fa fa-refresh"></i> Kaydı Güncelle
                                </button>
                            </div>
                        </div>
                        <div class="col-12">
                            <table class="table table-sm table-bordered w-100 display nowrap"
                                   style="cursor:pointer;font-size: 13px;"
                                   id="bankaya_gonderilen_table">
                                <thead>
                                <tr>
                                    <th>Tarih</th>
                                    <th id="yatan1">Gönderen Banka</th>
                                    <th>Yatan Kasa</th>
                                    <th>Gönderilen Tutar</th>
                                    <th>Açıklama</th>
                                    <th>İşlem</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="banka_transferden_vazgec"><i
                                        class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="bankadan_transferi_onayla"><i
                                        class="fa fa-plus"></i>
                                Kaydet
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('input').click(function () {
            $(this).select();
        });
        var table = "";
        $("#gonderilen_miktar").focusout(function () {
            var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2})
            $("#gonderilen_miktar").val(val);
        });
        $(document).ready(function () {

            setTimeout(function () {
                $("#yatan1").trigger("click");
            }, 500);

            $("#bankadan_kasaya_gonder_modal").modal("show");
            $.get("controller/kasa_controller/sql.php?islem=bankalari_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#banka_adlari").append("" +
                            "<option value='" + item.id + "'>" + item.banka_adi + "</option>" +
                            "");
                    })
                }
            })

            $.get("controller/kasa_controller/sql.php?islem=kasalari_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        let varsayilan = "";
                        if (item.varsayilan_kasa == 1) {
                            varsayilan = "selected";
                        }

                        $("#kasa_adlari").append("" +
                            "<option value='" + item.id + "' " + varsayilan + ">" + item.kasa_adi + "</option>" +
                            "");
                    })
                }
            })

            $("#bankaya_para_gonder_modal").modal("show");
            table = $('#bankaya_gonderilen_table').DataTable({
                scrollY: '55vh',
                scrollX: true,
                searching: false,
                "info": false,
                createdRow: function (row) {
                    $(row).addClass("bankadan_kasaya");
                },
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            });
        })

        $("body").off("click", "#bankadan_para_cek").on("click", "#bankadan_para_cek", function () {
            let banka_id = $("#banka_adlari").val();
            let kasa_id = $("#kasa_adlari").val();
            let tarih = $("#tarih").val();
            let gonderilen_miktar = $("#gonderilen_miktar").val();
            gonderilen_miktar = gonderilen_miktar.replace(/\./g, "").replace(",", ".");
            gonderilen_miktar = parseFloat(gonderilen_miktar);
            let aciklama = $("#aciklama").val();


            if (banka_id == "" || kasa_id == "") {
                Swal.fire(
                    'Uyarı!',
                    'Banka Veya Kasa Boş Kalamaz',
                    'warning'
                );
            } else if (tarih == ""){
                Swal.fire(
                    'Uyarı!',
                    'Lütfen Tarih Giriniz...',
                    'warning'
                );
            }else {
                $.ajax({
                    url: "controller/kasa_controller/sql.php?islem=bankadan_para_cek",
                    type: "POST",
                    data: {
                        banka_id: banka_id,
                        kasa_id: kasa_id,
                        tarih: tarih,
                        gonderilen_tutar: gonderilen_miktar,
                        aciklama: aciklama
                    },
                    success: function (result) {
                        if (result != 2) {
                            var item = JSON.parse(result);
                            let gonderilenTutar = item.gonderilen_tutar;
                            gonderilenTutar = parseFloat(gonderilenTutar);
                            gonderilenTutar = gonderilenTutar.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                            tarih = tarih.split("-");
                            let g = tarih[2];
                            let a = tarih[1];
                            let y = tarih[0];
                            let arr = [g,a,y];
                            tarih = arr.join("/");

                            var new_row = table.row.add([tarih,item.banka_adi, item.kasa_adi, gonderilenTutar, item.aciklama, "<button class='btn btn-danger bankadan_gonderimi_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                            $(new_row).attr("data-id", item.id);
                            $(new_row).find('td').eq(0).css('text-align', 'left');
                            $(new_row).find('td').eq(1).css('text-align', 'left');
                            $(new_row).find('td').eq(3).css('text-align', 'left');
                        }
                    }
                });
            }
        });

        $("body").off("click", ".bankadan_kasaya").on("click", ".bankadan_kasaya", function () {
            let id = $(this).attr("data-id");
            $("#bankadan_transfer_kaydi_guncelle").attr("data-id", id)
            $.get("controller/kasa_controller/sql.php?islem=bankada_transfer_guncellenecek_bilgiler", {id: id}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    setTimeout(function () {
                        $("#banka_adlari").val(item.banka_id)
                        $("#kasa_adlari").val(item.kasa_id)
                    }, 400);

                    $("#gonderilen_miktar").val(item.gonderilen_tutar)
                    $("#aciklama").val(item.aciklama)
                }
            })
            $(".bankadan_kasaya").removeClass("remove_bankadan_transfer");
            $(this).addClass("remove_bankadan_transfer");
        })

        $("body").off("click", "#banka_transferden_vazgec").on("click", "#banka_transferden_vazgec", function () {
            var arr = [];
            $(".bankadan_kasaya").each(function () {
                let id = $(this).attr("data-id");
                arr.push(id);
            })
            $.ajax({
                url: "controller/kasa_controller/sql.php?islem=bankadan_transfer_vazgec",
                type: "POST",
                data: {
                    id: arr
                },
                success: function (result) {
                    if (result == 1) {
                        $("#bankadan_kasaya_gonder_modal").modal("hide")
                    } else {
                        $("#bankadan_kasaya_gonder_modal").modal("hide")
                    }
                }
            })
        });
        $("body").off("click", "#bankadan_transferi_onayla").on("click", "#bankadan_transferi_onayla", function () {
            $("#bankadan_kasaya_gonder_modal").modal("hide");
            var arr = [];
            $(".bankadan_kasaya").each(function () {
                let id = $(this).attr("data-id");
                arr.push(id);
            })
            if (arr.length === 0) {
                $.get("view/bankadan_cekilen.php", function (getList) {
                    $(".admin-modal-icerik").html("");
                    $(".admin-modal-icerik").html(getList);
                });
                $.get("view/bankadan_cekilen.php", function (getList) {
                    $(".modal-icerik").html("");
                    $(".modal-icerik").html(getList);
                });
            } else {
                Swal.fire(
                    'Başarılı!',
                    'Para Bankadan Çekildi',
                    'success'
                );
                $.get("view/bankadan_cekilen.php", function (getList) {
                    $(".admin-modal-icerik").html("");
                    $(".admin-modal-icerik").html(getList);
                });
                $.get("view/bankadan_cekilen.php", function (getList) {
                    $(".modal-icerik").html("");
                    $(".modal-icerik").html(getList);
                });
            }

        })

        $("body").off("click", "#bankadan_transfer_kaydi_guncelle").on("click", "#bankadan_transfer_kaydi_guncelle", function () {
            var id = $(this).attr("data-id");
            var rows = table.rows().nodes();
            $.ajax({
                url: "controller/kasa_controller/sql.php?islem=bankadan_kasaya_iptal_et_sql",
                type: "POST",
                data: {
                    id: id
                },
                success: function (result) {
                    if (result == 1) {
                        $(rows).each(function () {
                            if ($(this).hasClass('remove_bankadan_transfer')) {
                                table.row(this).remove().draw();
                            }
                        })
                        let banka_id = $("#banka_adlari").val();
                        let kasa_id = $("#kasa_adlari").val();
                        let gonderilen_miktar = $("#gonderilen_miktar").val();
                        gonderilen_miktar = gonderilen_miktar.replace(/\./g, "").replace(",", ".");
                        gonderilen_miktar = parseFloat(gonderilen_miktar);
                        let tarih = $("#tarih").val();
                        let aciklama = $("#aciklama").val();


                        if (banka_id == "" || kasa_id == "") {
                            Swal.fire(
                                'Uyarı!',
                                'Banka Veya Kasa Boş Kalamaz',
                                'warning'
                            );
                        } else {
                            $.ajax({
                                url: "controller/kasa_controller/sql.php?islem=bankadan_para_cek",
                                type: "POST",
                                data: {
                                    banka_id: banka_id,
                                    kasa_id: kasa_id,
                                    tarih: tarih,
                                    gonderilen_tutar: gonderilen_miktar,
                                    aciklama: aciklama
                                },
                                success: function (result) {
                                    if (result != 2) {
                                        var item = JSON.parse(result);
                                        let gonderilenTutar = item.gonderilen_tutar;
                                        gonderilenTutar = parseFloat(gonderilenTutar);
                                        gonderilenTutar = gonderilenTutar.toLocaleString("tr-TR", {minimumFractionDigits: 2})
                                        tarih = tarih.split("-");

                                        let g = tarih[2];
                                        let a = tarih[1];
                                        let y = tarih[0];
                                        let arr = [g,a,y];
                                        tarih = arr.join("/");

                                        var new_row = table.row.add([tarih,item.banka_adi, item.kasa_adi, gonderilenTutar, item.aciklama, "<button class='btn btn-danger bankadan_gonderimi_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                                        $(new_row).attr("data-id", item.id);
                                        $(new_row).find('td').eq(0).css('text-align', 'left');
                                        $(new_row).find('td').eq(1).css('text-align', 'left');
                                        $(new_row).find('td').eq(3).css('text-align', 'left');
                                    }
                                }
                            });
                        }
                    }
                }
            });
        });

        $("body").off("click", ".bankadan_gonderimi_sil").on("click", ".bankadan_gonderimi_sil", function () {
            var id = $(this).attr("data-id");
            var row = $(this).closest('tr');
            $.ajax({
                url: "controller/kasa_controller/sql.php?islem=bankadan_kasaya_iptal_et_sql",
                type: "POST",
                data: {
                    id: id
                },
                success: function (result) {
                    if (result == 1) {
                        table.row(row).remove().draw();
                    }
                }
            });
        })

    </script>
    <?php
}
if ($islem == "bankadan_para_gonder_guncelle_modal") {
    ?>
       <div class="modal fade" id="kasaya_para_cek_guncelle_modal" data-bs-keyboard="false" data-backdrop="static"
         role="dialog">
        <div class="modal-dialog" style="width: 35%; max-width: 35%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="virman_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>KASADAN BANKAYA</div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Tarih</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="date" class="form-control form-control-sm" id="tarih">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Gönderen Banka</label>
                                </div>
                                <div class="col-md-7">
                                     <select class="custom-select custom-select-sm" id="banka_adlari">
                                        <option value="">Seçiniz...</option>
                                     </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Alan Kasa</label>
                                </div>
                                <div class="col-md-7">
                                     <select class="custom-select custom-select-sm" id="gonderen_banka">
                                         <option value="">Seçiniz...</option>
                                     </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Gönderilen Miktar</label>
                                </div>
                                <div class="col-md-7">
                                     <input type="text" class="form-control form-control-sm" id="gonderilen_miktar" style="text-align: right">
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
                            <button class="btn btn-danger btn-sm" id="virman_vazgec"><i class="fa fa-close"></i> Vazgeç</button>
                            <button class="btn btn-success btn-sm" id="transferi_guncelle_banka_cekilen"><i class="fa fa-check"></i> Kaydet</button>
</div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function (){
        $("#kasaya_para_cek_guncelle_modal").modal("show");

            $.get("controller/kasa_controller/sql.php?islem=gonderen_kasa_getir", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#gonderen_banka").append("" +
                            "<option value='" + item.id + "'>" + item.kasa_adi + "</option>" +
                            "");
                    })
                }
            })
            $.get("controller/kasa_controller/sql.php?islem=bankalari_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#banka_adlari").append("" +
                            "<option value='" + item.id + "'>" + item.banka_adi + "</option>" +
                            "");
                    })
                }
            })
    })

    $("body").off("change", "#gonderen_banka").on("change", "#gonderen_banka", function () {
            var kasa_id = $(this).val();
            $.get("controller/kasa_controller/sql.php?islem=alici_kasa_getir_sql", {id: kasa_id}, function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    $("#alici_banka").html("");
                        $("#alici_banka").append("" +
                            "<option>Seçiniz...</option>" +
                            "");
                    json.forEach(function (item) {
                        $("#alici_banka").append("" +
                            "<option value='" + item.id + "'>" + item.kasa_adi + "</option>" +
                            "");
                    })
                }
            })
        });
    $("body").off("focusout","#gonderilen_miktar").on("focusout","#gonderilen_miktar",function (){
 var val = $(this).val();
            val = val.replace(/\./g, "").replace(",", ".");
            val = parseFloat(val);
            if (isNaN(val)) {
                val = 0;
            }
            val = val.toLocaleString("tr-TR", {minimumFractionDigits: 2})
            $(this).val(val);
    });

    $.get("controller/kasa_controller/sql.php?islem=bankadan_kasaya_bilgileri_sql",{id:"<?=$_GET["id"]?>"},function (res){
        if (res != 2){
            var item = JSON.parse(res);
        setTimeout(function (){
            $("#gonderen_banka").val(item.kasa_id);
            $("#banka_adlari").val(item.banka_id);
        },500);
        let gonderilen_tutar = item.gonderilen_tutar;
        gonderilen_tutar = parseFloat(gonderilen_tutar);
        $("#gonderilen_miktar").val(gonderilen_tutar.toLocaleString("tr-TR",{minimumFractionDigits:2,maximumFractionDigits:2}));
        $("#aciklama").val(item.aciklama);
        let tarih = item.tarih;
        tarih = tarih.split(" ");
        $("#tarih").val(tarih[0]);
        }
    })

    $("body").off("click", "#virman_vazgec").on("click", "#virman_vazgec", function () {
        $("#kasaya_para_cek_guncelle_modal").modal("hide");
    });

    $("body").off("click","#transferi_guncelle_banka_cekilen").on("click","#transferi_guncelle_banka_cekilen",function (){
        let kasa_id = $("#gonderen_banka").val();
        let banka_id = $("#banka_id").val();
        let gonderilen_miktar = $("#gonderilen_miktar").val();
        gonderilen_miktar = gonderilen_miktar.replace(/\./g, "").replace(",", ".");
        gonderilen_miktar = parseFloat(gonderilen_miktar);
        let aciklama = $("#aciklama").val();
        let tarih = $("#tarih").val();
        if (tarih == ""){
            Swal.fire(
                "Uyarı!",
                "Lütfen Tarih Giriniz...",
                "warning"
            );
        }else {
        $.ajax({
            url:"controller/kasa_controller/sql.php?islem=transferi_guncelle_banka_cekilen_sql",
            type:"POST",
            data:{
                gonderilen_tutar:gonderilen_miktar,
                banka_id:banka_id,
                kasa_id:kasa_id,
                tarih:tarih,
                id:"<?=$_GET["id"]?>",
                aciklama:aciklama
            },
            success:function (res){
                if (res == 1){
Swal.fire(
                            'Başarılı',
                            'Kayıt Güncellendi',
                            'success'
                        );
                        $.get("view/bankadan_cekilen.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                        $.get("view/bankadan_cekilen.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                        $("#kasaya_para_cek_guncelle_modal").modal("hide");
                }
            }
        })
        }
    });

</script>
    <?php
}