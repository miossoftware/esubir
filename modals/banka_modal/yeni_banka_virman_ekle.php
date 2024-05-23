<?php

$islem = $_GET["islem"];


if ($islem == "yeni_banka_virman_ekle") {
    ?>
    <div class="modal fade" id="banka_virman_modal" data-bs-keyboard="false" data-backdrop="static"
    role="dialog">
    <div class="modal-dialog" style="width: 55%; max-width: 55%;">
        <div class="modal-content">
            <div class="modal-header text-white p-2">
                <button type="button" class="btn-close btn-close-white" id="virman_vazgec"
                        aria-label="Close"></button>
            </div>
            <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head" style='background-color:#9DB2BF'>
                        <div class="ibox-title" style='color:white; font-weight:bold;'>BANKA VİRMAN (TRANSFER)</div>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 row">
                            <div class="col-md-2">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;Gönderen Banka</label>
                                <select class="custom-select custom-select-sm" id="gonderen_banka">
                                    <option value="">Seçiniz...</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;Alan Banka</label>
                                <select class="custom-select custom-select-sm" id="alici_banka">
                                    <option value="">Seçiniz...</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label style="font-weight: bold;font-size: 10px">&nbsp;Gönderilen Miktar</label>
                                <input type="text" class="form-control form-control-sm" id="gonderilen_miktar">
                            </div>
                            <div class="col-md-2">
                                <label style="font-weight: bold;font-size: 10px">Virman Tarihi</label>
                                <input type="date" value="<?= date("Y-m-d") ?>" id="virman_tarihi"
                                       class="form-control form-control-sm">
                            </div>
                            <div class="col-md-2">
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
                                    <th id="clickbait12">G Banka Adı</th>
                                    <th>A Banka Adı</th>
                                    <th>Miktar</th>
                                    <th>Virman Tarihi</th>
                                    <th>Açıklama</th>
                                    <th>İşlem</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-sm" id="virman_vazgec"><i class="fa fa-close"></i> Vazgeç
                    </button>
                    <button class="btn btn-success btn-sm" id="banka_virman_kaydet"><i class="fa fa-plus"></i>
                        Kaydet
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>

        var table = "";
        $('input').click(function () {
            $(this).select();
        });
        $("body").off("click", "#banka_virman_kaydet").on("click", "#banka_virman_kaydet", function () {
            var arr = [];
            $(".virman_all_banka").each(function () {
                var gonderen_banka = $(this).attr("gonderen-id");
                var alici_banka = $(this).attr("alici-id");
                var gonderilen_miktar = $(this).find("td").eq(2).text();
                var virman_tarihi = $(this).find("td").eq(3).text();
                gonderilen_miktar = gonderilen_miktar.replace(/\./g, "").replace(",", ".");
                gonderilen_miktar = parseFloat(gonderilen_miktar);
                virman_tarihi = virman_tarihi.split("/");
                let gun = virman_tarihi[0];
                let ay = virman_tarihi[1];
                let yil = virman_tarihi[2];
                let yil_arr = [yil, ay, gun];
                virman_tarihi = yil_arr.join("-");
                var aciklama = $(this).find("td").eq(4).text();
                arr.push({
                    gonderen_bankaid: gonderen_banka,
                    virman_tarihi: virman_tarihi,
                    alici_bankaid: alici_banka,
                    gonderilen_miktar: gonderilen_miktar,
                    aciklama: aciklama
                });
            })
            $.ajax({
                url: "controller/banka_controller/sql.php?islem=banka_virman_ekle",
                type: "POST",
                data: {
                    arr: arr
                },
                success: function (result) {
                    if (result == 1) {
                        Swal.fire(
                            'Başarılı',
                            'Virman Kaydedildi',
                            'success'
                        );
                        $.get("view/banka_virman.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                        $.get("view/banka_virman.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                        $("#banka_virman_modal").modal("hide");
                    }
                }
            })
        });

        $("body").off("click", "#virman_ekle").on("click", "#virman_ekle", function () {
            var gonderen_banka = $("#gonderen_banka option:selected").text();
            var alici_banka = $("#alici_banka option:selected").text();
            var gonderilen_miktar = $("#gonderilen_miktar").val();
            var aciklama = $("#virman_aciklama").val();
            var virman_tarihi = $("#virman_tarihi").val();
            virman_tarihi = virman_tarihi.split("-");
            let gun = virman_tarihi[2];
            let ay = virman_tarihi[1];
            let yil = virman_tarihi[0];
            let yil_arr = [gun, ay, yil];
            virman_tarihi = yil_arr.join("/");
            var alici_bankaid = $("#alici_banka").val();
            var gonderen_bankaid = $("#gonderen_banka").val();
            var new_row = table.row.add([gonderen_banka, alici_banka, gonderilen_miktar, virman_tarihi, aciklama, "<button class='btn btn-danger btn-sm virman_eksilt'><i class='fa fa-trash'></i></button>"]).draw(false).node();
            $(new_row).attr("gonderen-id", gonderen_bankaid);
            $(new_row).attr("alici-id", alici_bankaid)

            $("#gonderen_banka").val("");
            $("#alici_banka").val("");
            $("#gonderilen_miktar").val("");
            $("#virman_aciklama").val("");
            $("#alici_banka").val("");
            $("#gonderen_banka").val("");
        })

        $("body").off("click", ".virman_eksilt").on("click", ".virman_eksilt", function () {
            var table_closest = $(this).closest("tr");
            table.row(table_closest).remove().draw();
        });

        $("body").off("click", "#virman_guncelle").on("click", "#virman_guncelle", function () {
            var rows = table.rows().nodes();
            $(rows).each(function () {
                if ($(this).hasClass('removelanan')) {
                    table.row(this).remove().draw();
                }
            })

            var gonderen_banka = $("#gonderen_banka option:selected").text();
            var alici_banka = $("#alici_banka option:selected").text();
            var gonderilen_miktar = $("#gonderilen_miktar").val();
            var aciklama = $("#virman_aciklama").val();
            var alici_bankaid = $("#alici_banka").val();
            var gonderen_bankaid = $("#gonderen_banka").val();
            var new_row = table.row.add([gonderen_banka, alici_banka, gonderilen_miktar, aciklama, "<button class='btn btn-danger btn-sm virman_eksilt'><i class='fa fa-trash'></i></button>"]).draw(false).node();
            $(new_row).attr("gonderen-id", gonderen_bankaid);
            $(new_row).attr("alici-id", alici_bankaid)

            $("#gonderen_banka").val("");
            $("#alici_banka").val("");
            $("#gonderilen_miktar").val("");
            $("#virman_aciklama").val("");
            $("#alici_banka").val("");
            $("#gonderen_banka").val("");
        });

        $(document).ready(function () {
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
                    {sWidth: '1%'},
                    {sWidth: '1%'},
                    {sWidth: '1%'},
                    {sWidth: '1%'},
                    {sWidth: '2%'},
                    {sWidth: '0%'}
                ],
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
                createdRow: function (row) {
                    $(row).addClass("virman_all_banka");
                    $(row).find("td").eq(0).css("text-align", "left");
                    $(row).find("td").eq(1).css("text-align", "left");
                    $(row).find("td").eq(3).css("text-align", "left");
                    $(row).find("td").eq(4).css("text-align", "left");
                }
            })

            $("body").off("click", ".virman_all_banka").on("click", ".virman_all_banka", function () {
                $(".virman_all_banka").removeClass("removelanan");
                $(this).addClass("removelanan");

                var gonderen_bankaid = $(this).attr("gonderen-id");
                var alici_id = $(this).attr("alici-id");
                var tutar = $(this).find("td").eq(2).text();
                var aciklama = $(this).find("td").eq(3).text();
                $("#gonderen_banka").val(gonderen_bankaid);
                $("#alici_banka").val(alici_id);
                $("#gonderilen_miktar").val(tutar);
                $("#virman_aciklama").val(aciklama);
            })

            $.get("controller/banka_controller/sql.php?islem=gonderen_banka_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#gonderen_banka").append("" +
                            "<option value='" + item.id + "'>" + item.banka_adi + "</option>" +
                            "");
                    })
                }
            })
            $("#banka_virman_modal").modal("show");
        })

        $("body").off("click", "#virman_vazgec").on("click", "#virman_vazgec", function () {
            $("#banka_virman_modal").modal("hide");
        })

        $("body").off("change", "#gonderen_banka").on("change", "#gonderen_banka", function () {
            var secilen_bankaid = $(this).val();
            $.get("controller/banka_controller/sql.php?islem=alabilecek_bankalari_getir_sql", {id: secilen_bankaid}, function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    $("#alici_banka").html("");
                    $("#alici_banka").append("" +
                        "<option>Seçiniz...</option>" +
                        "");
                    json.forEach(function (item) {
                        $("#alici_banka").append("" +
                            "<option value='" + item.id + "'>" + item.banka_adi + "</option>" +
                            "");
                    })
                }
            })
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

    </script>
    <?php
}
if ($islem == "banka_virman_guncelle") {
    ?>
    <div class="modal fade" id="banka_virman_modal_guncelle" data-bs-keyboard="false" data-backdrop="static"
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
                            <div class="ibox-title" style='color:white; font-weight:bold;'>BANKA VİRMAN (TRANSFER) GÜNCELLE</div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Gönderen Banka</label>
                                </div>
                                    <div class="col-md-7">
                                         <select class="custom-select custom-select-sm" id="gonderen_banka">
                                             <option value="">Seçiniz...</option>
                                         </select>
                                    </div>
                                </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Alıcı Banka</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="custom-select custom-select-sm" id="alici_banka">
                                        <option value="">Seçiniz...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                            <div class="col-md-4">
                            <label>Virman Tarihi</label>
</div>
<div class="col-md-7">
<input type="date" class="form-control form-control-sm" id="virman_tarihi">
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
                            <button class="btn btn-success btn-sm" id="virman_guncelle"><i class="fa fa-check"></i> Kaydet</button>
</div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function (){
        $("#banka_virman_modal_guncelle").modal("show");

            $.get("controller/banka_controller/sql.php?islem=gonderen_banka_getir_sql", function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $("#gonderen_banka").append("" +
                            "<option value='" + item.id + "'>" + item.banka_adi + "</option>" +
                            "");
                    })
                }
            })
        $.get("controller/banka_controller/sql.php?islem=alabilecek_bankalari_getir_sql", {id: secilen_bankaid}, function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                $("#alici_banka").html("");
                $("#alici_banka").append("" +
                    "<option>Seçiniz...</option>" +
                    "");
                json.forEach(function (item) {
                    $("#alici_banka").append("" +
                        "<option value='" + item.id + "'>" + item.banka_adi + "</option>" +
                        "");
                })
            }
        })
    })

    $("body").off("change", "#gonderen_banka").on("change", "#gonderen_banka", function () {
        var secilen_bankaid = $(this).val();
        $.get("controller/banka_controller/sql.php?islem=alabilecek_bankalari_getir_sql", {id: secilen_bankaid}, function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                $("#alici_banka").html("");
                $("#alici_banka").append("" +
                    "<option>Seçiniz...</option>" +
                    "");
                json.forEach(function (item) {
                    $("#alici_banka").append("" +
                        "<option value='" + item.id + "'>" + item.banka_adi + "</option>" +
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

    $.get("controller/banka_controller/sql.php?islem=virman_bilgilerini_getir_sql",{id:"<?=$_GET["id"]?>"},function (res){
        if (res != 2){
            var item = JSON.parse(res);
            var secilen_bankaid = item.gonderen_bankaid;
        $.get("controller/banka_controller/sql.php?islem=alabilecek_bankalari_getir_sql", {id: secilen_bankaid}, function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                $("#alici_banka").html("");
                $("#alici_banka").append("" +
                    "<option>Seçiniz...</option>" +
                    "");
                json.forEach(function (item) {
                    $("#alici_banka").append("" +
                        "<option value='" + item.id + "'>" + item.banka_adi + "</option>" +
                        "");
                })
            }
        })
        setTimeout(function (){
            $("#gonderen_banka").val(item.gonderen_bankaid);
            $("#alici_banka").val(item.alici_bankaid);
        },500);
        let virman_tarihi = item.virman_tarihi;
        if (virman_tarihi != null){
            virman_tarihi = virman_tarihi.split(" ");
        }
        $("#virman_tarihi").val(virman_tarihi[0]);
        let gonderilen_tutar = item.gonderilen_miktar;
        gonderilen_tutar = parseFloat(gonderilen_tutar);
        $("#gonderilen_miktar").val(gonderilen_tutar.toLocaleString("tr-TR",{minimumFractionDigits:2,maximumFractionDigits:2}));
        $("#aciklama").val(item.aciklama);
        }
    })

    $("body").off("click", "#virman_vazgec").on("click", "#virman_vazgec", function () {
        $("#banka_virman_modal_guncelle").modal("hide");
    });

    $("body").off("click","#virman_guncelle").on("click","#virman_guncelle",function (){
        let gonderen_bankaid = $("#gonderen_banka").val();
        let alici_bankaid = $("#alici_banka").val();
        let gonderilen_miktar = $("#gonderilen_miktar").val();
        gonderilen_miktar = gonderilen_miktar.replace(/\./g, "").replace(",", ".");
        gonderilen_miktar = parseFloat(gonderilen_miktar);
        let virman_tarihi = $("#virman_tarihi").val();
        let aciklama = $("#aciklama").val();
        $.ajax({
            url:"controller/banka_controller/sql.php?islem=virman_guncelle_sql",
            type:"POST",
            data:{
                gonderilen_miktar:gonderilen_miktar,
                alici_bankaid:alici_bankaid,
                gonderen_bankaid:gonderen_bankaid,
                virman_tarihi:virman_tarihi,
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
                        $.get("view/banka_virman.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        });
                        $.get("view/banka_virman.php", function (getList) {
                            $(".admin-modal-icerik").html("");
                            $(".admin-modal-icerik").html(getList);
                        });
                        $("#banka_virman_modal_guncelle").modal("hide");
                }
            }
        })
    });

</script>
    <?php
}