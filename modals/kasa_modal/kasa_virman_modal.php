<?php
$islem = $_GET["islem"];
if ($islem == "yeni_virman_ekle_modal") {
    ?>
    <div class="modal fade" id="kasa_virman_modal" data-bs-keyboard="false" data-backdrop="static"
    role="dialog">
    <div class="modal-dialog" style="width: 55%; max-width: 55%;">
        <div class="modal-content">
            <div class="modal-header text-white p-2">Kasa Virman (Transfer)
                <button type="button" class="btn-close btn-close-white" id="virman_vazgec"
                        aria-label="Close"></button>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head" style='background-color:#9DB2BF'>
                        <div class="ibox-title" style='color:white; font-weight:bold;'>KASA VİRMAN (TRANSFER)</div>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 row">
                            <div class="col">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;Gönderen Kasa</label>
                                <select class="custom-select custom-select-sm" id="gonderen_kasa">
                                    <option value="">Seçiniz...</option>
                                </select>
                            </div>
                            <div class="col">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;Alan Kasa</label>
                                <select class="custom-select custom-select-sm" id="alici_kasa">
                                    <option value="">Seçiniz...</option>
                                </select>
                            </div>
                            <div class="col">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;Gönderilen Miktar</label>
                                <input type="text" class="form-control form-control-sm" id="gonderilen_miktar">
                            </div>
                            <div class="col">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;Tarih</label>
                                <input type="date" value="<?=date("Y-m-d")?>" class="form-control form-control-sm" id="tarih">
                            </div>
                            <div class="col">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;Açıklama</label>
                                <input type="text" class="form-control form-control-sm" id="virman_aciklama">
                            </div>
                            <div class="col-md-2 mt-3 row">
                                <button style="width: 100% !important;"
                                        class="btn btn-success btn-sm mx-5" id="virman_ekle"><i
                                            class="fa fa-plus"></i> Ekle
                                </button>
                                <button style="background-color: #F6FA70;width: 100% !important;"
                                        class="btn btn-sm mx-5 mt-1"
                                        id="virman_guncelle"><i
                                            class="fa fa-refresh"></i> Kaydı Güncelle
                                </button>
                            </div>
                        </div>
                        <div class="col-12 row mt-2">
                            <table class="table table-sm table-bordered w-100 display nowrap"
                                   style="cursor:pointer;font-size: 13px;"
                                   id="add_virman_table">
                                <thead>
                                <tr>
                                    <th>Tarih</th>
                                    <th id="clickbait12">G Kasa Kodu</th>
                                    <th>G Kasa Adı</th>
                                    <th>A Kasa Kodu</th>
                                    <th>A Kasa Adı</th>
                                    <th>Miktar</th>
                                    <th>Açıklama</th>
                                    <th>İşlem</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="virman_vazgec"><i class="fa fa-close"></i> Vazgeç
                            </button>
                            <button class="btn btn-success btn-sm" id="virman_kaydet"><i class="fa fa-plus"></i> Kaydet
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

        $("body").off("click", "#virman_kaydet").on("click", "#virman_kaydet", function () {
            $("#kasa_virman_modal").modal("hide");
            Swal.fire(
                'Başarılı!',
                'Virman Girişleri Kaydedildi',
                'success'
            );
            $.get("view/kasa_virman.php", function (getList) {
                $(".admin-modal-icerik").html("");
                $(".admin-modal-icerik").html(getList);
            });
            $.get("view/kasa_virman.php", function (getList) {
                $(".modal-icerik").html("");
                $(".modal-icerik").html(getList);
            });
        })
        $(document).ready(function () {
            $("#kasa_virman_modal").modal("show");
            setTimeout(function () {
                $("#clickbait12").trigger("click");
            }, 500);
            table = $('#add_virman_table').DataTable({
                scrollY: '55vh',
                scrollX: true,
                "info": false,
                searching: false,
                bAutoWidth: false,
                aoColumns: [
                    {sWidth: '0%'},
                    {sWidth: '1%'},
                    {sWidth: '1%'},
                    {sWidth: '1%'},
                    {sWidth: '1%'},
                    {sWidth: '2%'},
                    {sWidth: '1%'},
                    {sWidth: '0%'}
                ],
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row) {
                    $(row).addClass("virman_all");
                }
            });

            $("body").off("click", "#virman_ekle").on("click", "#virman_ekle", function () {
                var gonderen_kasaid = $("#gonderen_kasa").val();
                var tarih = $("#tarih").val();
                var alan_kasaid = $("#alici_kasa").val();
                var gonderilen_miktar = $("#gonderilen_miktar").val();
                gonderilen_miktar = gonderilen_miktar.replace(/\./g, "").replace(",", ".");
                gonderilen_miktar = parseFloat(gonderilen_miktar);
                var aciklama = $("#virman_aciklama").val();
                if (tarih == ""){
                    Swal.fire(
                        "Uyarı!",
                        "Lütfen Tarih Giriniz...",
                        "warning"
                    );
                }else {
                    $.ajax({
                    url: "controller/kasa_controller/sql.php?islem=yeni_kasa_virman_ekle",
                    type: "POST",
                    data: {
                        gonderen_kasaid: gonderen_kasaid,
                        alan_kasaid: alan_kasaid,
                        tarih: tarih,
                        gonderilen_miktar: gonderilen_miktar,
                        aciklama: aciklama
                    },
                    success: function (result) {
                        if (result != 2) {
                            var item = JSON.parse(result);
                            var miktar = item.gonderilen_miktar;
                            miktar = parseFloat(miktar);
                            tarih = tarih.split("-");
                            let g = tarih[2];
                            let a = tarih[1];
                            let y = tarih[0];
                            let arr = [g,a,y];
                            tarih = arr.join("/");

                            miktar = miktar.toLocaleString("tr-TR", {minimumFractionDigits: 2});
                            var new_row = table.row.add([tarih,item.gonderen_kodu, item.gonderen_adi, item.kasa_kodu, item.kasa_adi, miktar, item.aciklama, "<button class='btn btn-danger btn-sm virman_eksilt' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                            $(new_row).attr("data-id", item.id);
                            $(new_row).find('td').eq(0).css('text-align', 'left');
                            $(new_row).find('td').eq(1).css('text-align', 'left');
                            $(new_row).find('td').eq(2).css('text-align', 'left');
                            $(new_row).find('td').eq(3).css('text-align', 'left');
                            $(new_row).find('td').eq(5).css('text-align', 'left');
                        }
                    }
                });
                }
            });

            $.get("controller/kasa_controller/sql.php?islem=gonderen_kasa_getir", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#gonderen_kasa").append("" +
                            "<option value='" + item.id + "'>" + item.kasa_adi + "</option>" +
                            "");
                    })
                }
            })
        })

        $("body").off("click", "#virman_guncelle").on("click", "#virman_guncelle", function () {
            var id = $(this).attr("data-id");
            var rows = table.rows().nodes();
            $.ajax({
                url: "controller/kasa_controller/sql.php?islem=virman_cikart",
                type: "POST",
                data: {
                    id: id
                },
                success: function (result) {
                    $(rows).each(function () {
                        if ($(this).hasClass('remove')) {
                            table.row(this).remove().draw();
                        }
                    })
                    if (result == 1) {
                        var gonderen_kasaid = $("#gonderen_kasa").val();
                        var alan_kasaid = $("#alici_kasa").val();
                        var gonderilen_miktar = $("#gonderilen_miktar").val();
                        let tarih = $("#tarih").val();
                        gonderilen_miktar = gonderilen_miktar.replace(/\./g, "").replace(",", ".");
                        gonderilen_miktar = parseFloat(gonderilen_miktar);
                        var aciklama = $("#virman_aciklama").val();

                        $.ajax({
                            url: "controller/kasa_controller/sql.php?islem=yeni_kasa_virman_ekle",
                            type: "POST",
                            data: {
                                gonderen_kasaid: gonderen_kasaid,
                                alan_kasaid: alan_kasaid,
                                gonderilen_miktar: gonderilen_miktar,
                                tarih: tarih,
                                aciklama: aciklama
                            },
                            success: function (result) {
                                if (result != 2) {
                                    var item = JSON.parse(result);
                                    var miktar = item.gonderilen_miktar;
                                    miktar = parseFloat(miktar);
                                    miktar = miktar.toLocaleString("tr-TR", {minimumFractionDigits: 2});

                                    tarih = tarih.split("-");
                                    let g = tarih[2];
                                    let a = tarih[1];
                                    let y = tarih[0];
                                    let arr = [g,a,y];
                                    tarih = arr.join("/");

                                    var new_row = table.row.add([tarih,item.gonderen_kodu, item.gonderen_adi, item.kasa_kodu, item.kasa_adi, miktar, item.aciklama, "<button class='btn btn-danger btn-sm virman_eksilt' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                                    $(new_row).attr("data-id", item.id);
                                    $(new_row).find('td').eq(0).css('text-align', 'left');
                                    $(new_row).find('td').eq(1).css('text-align', 'left');
                                    $(new_row).find('td').eq(2).css('text-align', 'left');
                                    $(new_row).find('td').eq(3).css('text-align', 'left');
                                    $(new_row).find('td').eq(5).css('text-align', 'left');
                                }
                            }
                        });
                    }
                }
            });
        });

        $("body").off("click", ".virman_all").on("click", ".virman_all", function () {
            var id = $(this).attr("data-id");
            $(".virman_all").removeClass("remove");
            $(".virman_all").addClass("remove");
            $.get("controller/kasa_controller/sql.php?islem=virman_bilgileri_getir_sql", {id: id}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#gonderen_kasa").val(item.gonderen_kasaid)
                    $("#alici_kasa").val(item.alan_kasaid)
                    $("#gonderilen_miktar").val(item.gonderilen_miktar)
                    $("#virman_aciklama").val(item.aciklama)
                    $("#virman_guncelle").attr("data-id", id);
                }
            })
        });

        $("body").off("click", "#virman_vazgec").on("click", "#virman_vazgec", function () {
            let arr = [];
            $(".virman_all").each(function () {
                let id = $(this).attr("data-id");
                arr.push(id);
            })
            $.ajax({
                url: "controller/kasa_controller/sql.php?islem=virman_vazgec_sql",
                type: "POST",
                data: {
                    id: arr
                },
                success: function (result) {
                    if (result == 1) {
                        $("#kasa_virman_modal").modal("hide");
                    } else {
                        $("#kasa_virman_modal").modal("hide");
                    }
                }
            })
        });

        $("body").off("click", ".virman_eksilt").on("click", ".virman_eksilt", function () {
            var id = $(this).attr("data-id");
            var row = $(this).closest('tr');
            $.ajax({
                url: "controller/kasa_controller/sql.php?islem=virman_cikart",
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

        $("body").off("change", "#gonderen_kasa").on("change", "#gonderen_kasa", function () {
            var kasa_id = $(this).val();
            $.get("controller/kasa_controller/sql.php?islem=alici_kasa_getir_sql", {id: kasa_id}, function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    $("#alici_kasa").html("");
                        $("#alici_kasa").append("" +
                            "<option>Seçiniz...</option>" +
                            "");
                    json.forEach(function (item) {
                        $("#alici_kasa").append("" +
                            "<option value='" + item.id + "'>" + item.kasa_adi + "</option>" +
                            "");
                    })
                }
            })
        });

    </script>
    <?php
}
if ($islem == "yeni_virman_guncelle_modal") {
    ?>
     <div class="modal fade" id="kasa_virman_guncelle_modal" data-bs-keyboard="false" data-backdrop="static"
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
                            <div class="ibox-title" style='color:white; font-weight:bold;'>KASA VİRMAN (TRANSFER) GÜNCELLE</div>
                        </div>
                        <div class="modal-body">
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
                                    <label>Alıcı Kasa</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="custom-select custom-select-sm" id="alici_banka">
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
                                    <label>Tarih</label>
                                </div>
                                <div class="col-md-7">
                                     <input type="date" class="form-control form-control-sm" id="tarih">
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
                            <button class="btn btn-success btn-sm" id="kasa_virman_guncelle"><i class="fa fa-check"></i> Kaydet</button>
</div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function (){
        $("#kasa_virman_guncelle_modal").modal("show");

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

    $.get("controller/kasa_controller/sql.php?islem=virman_bilgilerini_getir_sql",{id:"<?=$_GET["id"]?>"},function (res){
        if (res != 2){
            var item = JSON.parse(res);
            var secilen_bankaid = item.gonderen_kasaid;
        $.get("controller/kasa_controller/sql.php?islem=alici_kasa_getir_sql", {id: secilen_bankaid}, function (result) {
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
        setTimeout(function (){
            $("#gonderen_banka").val(item.gonderen_kasaid);
            $("#alici_banka").val(item.alan_kasaid);
        },500);
        let gonderilen_tutar = item.gonderilen_miktar;
        let tarih = item.tarih;
        tarih = tarih.split(" ");
        $("#tarih").val(tarih[0]);
        gonderilen_tutar = parseFloat(gonderilen_tutar);
        $("#gonderilen_miktar").val(gonderilen_tutar.toLocaleString("tr-TR",{minimumFractionDigits:2,maximumFractionDigits:2}));
        $("#aciklama").val(item.aciklama);
        }
    })

    $("body").off("click", "#virman_vazgec").on("click", "#virman_vazgec", function () {
        $("#kasa_virman_guncelle_modal").modal("hide");
    });

    $("body").off("click","#kasa_virman_guncelle").on("click","#kasa_virman_guncelle",function (){
        let gonderen_bankaid = $("#gonderen_banka").val();
        let alici_bankaid = $("#alici_banka").val();
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
            url:"controller/kasa_controller/sql.php?islem=kasa_virman_guncelle_sql",
            type:"POST",
            data:{
                gonderilen_miktar:gonderilen_miktar,
                alan_kasaid:alici_bankaid,
                tarih:tarih,
                gonderen_kasaid:gonderen_bankaid,
                id:"<?=$_GET["id"]?>",
                aciklama:aciklama
            },
            success:function (res){
                if (res == 1){
Swal.fire(
                            'Başarılı',
                            'Virman Güncellendi',
                            'success'
                        );
                        $.get("view/kasa_virman.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                        $.get("view/kasa_virman.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                        $("#kasa_virman_guncelle_modal").modal("hide");
                }
            }
        })
        }
    });

</script>
    <?php
}