<?php

$islem = $_GET["islem"];

if ($islem == "bankaya_para_gonder_modal") {
    ?>
    <div class="modal fade" id="bankaya_para_gonder_modal" data-bs-keyboard="false"
    role="dialog">
    <div class="modal-dialog" style="width: 75%; max-width: 75%;">
        <div class="modal-content">
            <div class="modal-header text-white p-2">Bankaya Para Gönder
                <button type="button" class="btn-close btn-close-white" id="transferden_vazgec"
                        aria-label="Close"></button>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head" style='background-color:#9DB2BF'>
                        <div class="ibox-title" style='color:white; font-weight:bold;'>BANKAYA PARA GÖNDER</div>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 row no-gutters">
                            <div class="col">
                                <label style="font-weight: bold;font-size: 10px">Tarih</label>
                                <input type="date" class="form-control form-control-sm" value="<?=date("Y-m-d")?>" id="tarih">
                            </div>
                            <div class="col">
                                <label style="font-weight: bold;font-size: 10px">Banka Adı</label>
                                <select class="custom-select custom-select-sm" id="banka_adlari">
                                    <option value="">Seçiniz...</option>
                                </select>
                            </div>
                            <div class="col mx-1">
                                <label style="font-weight: bold;font-size: 10px">Kasa Adı</label>
                                <select class="custom-select custom-select-sm" id="kasa_adlari">
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
                                        class="btn btn-success btn-sm mx-5" id="bankaya_para_gonder"><i
                                            class="fa fa-plus"></i> Ekle
                                </button>
                                <button style="background-color: #F6FA70;width: 70% !important;"
                                        class="btn btn-sm mx-5 mt-1"
                                        id="transfer_kaydi_guncelle"><i
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
                                    <th id="gonderilen1">Gönderen Kasa</th>
                                    <th>Yatan Banka Hesabı</th>
                                    <th>Gönderilen Tutar</th>
                                    <th>Açıklama</th>
                                    <th>İşlem</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="transferden_vazgec"><i class="fa fa-close"></i>
                                Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="transferi_onayla"><i class="fa fa-plus"></i>
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
        $(document).ready(function () {
            setTimeout(function () {
                $("#gonderilen1").trigger("click");
            }, 500);

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
                    $(row).addClass("kasadan_bankaya_list");
                },
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            });
        })

        $("body").off("click", ".kasadan_bankaya_list").on("click", ".kasadan_bankaya_list", function () {
            let id = $(this).attr("data-id");
            $("#transfer_kaydi_guncelle").attr("data-id", id)
            $.get("controller/kasa_controller/sql.php?islem=transfer_guncellenecek_bilgiler", {id: id}, function (result) {
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
            $(".kasadan_bankaya_list").removeClass("remove_transfer");
            $(this).addClass("remove_transfer");
        });

        $("body").off("click", "#transfer_kaydi_guncelle").on("click", "#transfer_kaydi_guncelle", function () {
            var id = $(this).attr("data-id");
            var rows = table.rows().nodes();
            $.ajax({
                url: "controller/kasa_controller/sql.php?islem=kasadan_bankaya_iptal_sql",
                type: "POST",
                data: {
                    id: id
                },
                success: function (result) {
                    $(rows).each(function () {
                        if ($(this).hasClass('remove_transfer')) {
                            table.row(this).remove().draw();
                        }
                    })
                    if (result == 1) {
                        let banka_id = $("#banka_adlari").val();
                        let kasa_id = $("#kasa_adlari").val();
                        let gonderilen_miktar = $("#gonderilen_miktar").val();
                        gonderilen_miktar = gonderilen_miktar.replace(/\./g, "").replace(",", ".");
                        gonderilen_miktar = parseFloat(gonderilen_miktar);
                        let aciklama = $("#aciklama").val();
                        let tarih = $("#tarih").val();


                        if (banka_id == "" || kasa_id == "") {
                            Swal.fire(
                                'Uyarı!',
                                'Banka Veya Kasa Boş Kalamaz',
                                'warning'
                            );
                        } else {
                            $.ajax({
                                url: "controller/kasa_controller/sql.php?islem=bankaya_para_gonder_sql",
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

                                        var new_row = table.row.add([tarih,item.kasa_adi, item.banka_adi, gonderilenTutar, item.aciklama, "<button class='btn btn-danger gonderimi_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
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

        $("body").off("click", "#bankaya_para_gonder").on("click", "#bankaya_para_gonder", function () {
            let banka_id = $("#banka_adlari").val();
            let kasa_id = $("#kasa_adlari").val();
            let gonderilen_miktar = $("#gonderilen_miktar").val();
            gonderilen_miktar = gonderilen_miktar.replace(/\./g, "").replace(",", ".");
            gonderilen_miktar = parseFloat(gonderilen_miktar);
            let aciklama = $("#aciklama").val();
            let tarih = $("#tarih").val();


            if (banka_id == "" || kasa_id == "") {
                Swal.fire(
                    'Uyarı!',
                    'Banka Veya Kasa Boş Kalamaz',
                    'warning'
                );
            } else {
                $.ajax({
                    url: "controller/kasa_controller/sql.php?islem=bankaya_para_gonder_sql",
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
                            var new_row = table.row.add([tarih,item.kasa_adi, item.banka_adi, gonderilenTutar, item.aciklama, "<button class='btn btn-danger gonderimi_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                            $(new_row).attr("data-id", item.id);
                            $(new_row).find('td').eq(0).css('text-align', 'left');
                            $(new_row).find('td').eq(1).css('text-align', 'left');
                            $(new_row).find('td').eq(3).css('text-align', 'left');
                        }
                    }
                });
            }
        });

        $("body").off("click", ".gonderimi_sil").on("click", ".gonderimi_sil", function () {
            var id = $(this).attr("data-id");
            var row = $(this).closest('tr');
            $.ajax({
                url: "controller/kasa_controller/sql.php?islem=kasadan_bankaya_iptal_sql",
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
        });
        $("body").off("click", "#transferi_onayla").on("click", "#transferi_onayla", function () {
            $("#bankaya_para_gonder_modal").modal("hide");
            var arr = [];
            $(".kasadan_bankaya_list").each(function () {
                let id = $(this).attr("data-id");
                arr.push(id);
            })
            if (arr.length === 0) {
                $.get("view/bankaya_yatan.php", function (getList) {
                    $(".admin-modal-icerik").html("");
                    $(".admin-modal-icerik").html(getList);
                });
                $.get("view/bankaya_yatan.php", function (getList) {
                    $(".modal-icerik").html("");
                    $(".modal-icerik").html(getList);
                });
            } else {
                Swal.fire(
                    'Başarılı!',
                    'Para Bankaya Transfer Oldu',
                    'success'
                );
                $.get("view/bankaya_yatan.php", function (getList) {
                    $(".admin-modal-icerik").html("");
                    $(".admin-modal-icerik").html(getList);
                });
                $.get("view/bankaya_yatan.php", function (getList) {
                    $(".modal-icerik").html("");
                    $(".modal-icerik").html(getList);
                });
            }

        })

        $("body").off("click", "#transferden_vazgec").on("click", "#transferden_vazgec", function () {
            var arr = [];
            $(".kasadan_bankaya_list").each(function () {
                let id = $(this).attr("data-id");
                arr.push(id);
            })
            $.ajax({
                url: "controller/kasa_controller/sql.php?islem=kasadan_transfer_vazgec",
                type: "POST",
                data: {
                    id: arr
                },
                success: function (result) {
                    if (result == 1) {
                        $("#bankaya_para_gonder_modal").modal("hide");
                    } else {
                        $("#bankaya_para_gonder_modal").modal("hide");
                    }
                }
            })
        });

    </script>
    <?php
}
if ($islem == "bankaya_para_gonder_guncelle_modal") {
    ?>
    <div class="modal fade" id="bankaya_para_gonder_guncelle_modal" data-bs-keyboard="false" data-backdrop="static"
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
                            <div class="ibox-title" style='color:white; font-weight:bold;'>Bankadan Kasaya</div>
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
                                    <label>Gönderen Kasa</label>
                                </div>
                                <div class="col-md-7">
                                     <select class="custom-select custom-select-sm" id="gonderen_banka">
                                         <option value="">Seçiniz...</option>
                                     </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Banka Adı</label>
                                </div>
                                <div class="col-md-7">
                                     <select class="custom-select custom-select-sm" id="banka_adlari">
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
                            <button class="btn btn-success btn-sm" id="transferi_guncelle"><i class="fa fa-check"></i> Kaydet</button>
</div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function (){
        $("#bankaya_para_gonder_guncelle_modal").modal("show");

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

    $.get("controller/kasa_controller/sql.php?islem=kasadan_bankaya_bilgileri_sql",{id:"<?=$_GET["id"]?>"},function (res){
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
        $("#bankaya_para_gonder_guncelle_modal").modal("hide");
    });

    $("body").off("click","#transferi_guncelle").on("click","#transferi_guncelle",function (){
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
            url:"controller/kasa_controller/sql.php?islem=transferi_guncelle_sql",
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
                        $.get("view/bankaya_yatan.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                        $.get("view/bankaya_yatan.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                        $("#bankaya_para_gonder_guncelle_modal").modal("hide");
                }
            }
        })
        }
    });

</script>
    <?php
}