<?php
$islem = $_GET["islem"];
if ($islem == "kullanici_guncelle_modal") {
    ?>
    <div class="modal fade" id="kullanici_ekle_modal_main" data-bs-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 40%; max-width: 40%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                <div class="ibox">
                    <div class="ibox-head" style='background-color:#9DB2BF'>
                        <div class="ibox-title" style='color:white; font-weight:bold;'>KULLANICI GÜNCELLE</div>
                    </div>
                <div class="modal-body">
                    <div class="col-12 row">
                        <div class="form-group row">
                            <div class="col-4">
                                <label>Ad Soyad</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" id="name_surname">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-4">
                                <label>E Mail</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" id="e_mail">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-4">
                                <label>Kullanıcı Adı</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" id="username">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-4">
                                <label>Max. Kullanıcı Sayısı</label>
                            </div>
                            <div class="col-8">
                                <input type="number" class="form-control form-control-sm" id="user_length">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-4">
                                <label>Şifre</label>
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control form-control-sm" id="user_password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-4">
                                <label>Yetki</label>
                            </div>
                            <div class="col-8">
                                <select class="custom-select custom-select-sm" id="user_root">
                                    <option value="">Seçiniz...</option>
                                    <option value="1">Admin</option>
                                    <option value="3">User</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-sm" id="modal_kapat">Kapat</button>
                    <button class="btn btn-success btn-sm" id="kullanici_kaydet">Güncelle</button>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function () {
            $("#kullanici_ekle_modal_main").modal("show");
            $.get("controller/user_controller/sql.php?islem=yetkisi_nedir_sql", function (result) {
                if (result == 2) {
                    $("#user_root").append("<option value='2'>Süper Admin</option>")
                }
            });
            $.get("controller/user_controller/sql.php?islem=kullanici_bilgileri_getir_sql", {id: "<?=$_GET["id"]?>"}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#username").val(item.username);
                    $("#user_root").val(item.user_root);
                    $("#e_mail").val(item.e_mail);
                    $("#name_surname").val(item.name_surname);
                    $("#user_length").val(item.user_length);
                }
            });
        })

        $("body").off("click", "#modal_kapat").on("click", "#modal_kapat", function () {
            $("#kullanici_ekle_modal_main").modal("hide");
        })

        $("body").off("click", "#kullanici_kaydet").on("click", "#kullanici_kaydet", function () {
            var username = $("#username").val();
            var user_password = $("#user_password").val();
            var user_root = $("#user_root").val();
            var e_mail = $("#e_mail").val();
            var name_surname = $("#name_surname").val();
            var user_length = $("#user_length").val();
            if (user_password == "") {
                $.ajax({
                    url: "controller/user_controller/sql.php?islem=kullanici_guncelle",
                    type: "POST",
                    data: {
                        username: username,
                        user_root: user_root,
                        e_mail: e_mail,
                        name_surname: name_surname,
                        id: "<?=$_GET["id"]?>",
                        user_length: user_length
                    },
                    success: function (result) {
                        if (result != 2) {
                            if (result == 404) {
                                Swal.fire(
                                    'Uyarı!',
                                    'Kullanıcı Aktif Değil Lütfen Öncelikle Aktif Ediniz',
                                    'warning'
                                );
                            } else {
                                Swal.fire(
                                    'Başarılı!',
                                    'Kullanıcı Güncellendi',
                                    'success'
                                );
                                $.get("admin_views/user_config.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                })
                            }
                        } else {
                            Swal.fire(
                                'Oops...',
                                'Bilinmeyen Bir Hata Oluştu',
                                'error'
                            );
                        }
                    }
                })
            } else {
                $.ajax({
                    url: "controller/user_controller/sql.php?islem=kullanici_guncelle",
                    type: "POST",
                    data: {
                        username: username,
                        user_password: user_password,
                        user_root: user_root,
                        e_mail: e_mail,
                        name_surname: name_surname,
                        id: "<?=$_GET["id"]?>",
                        user_length: user_length
                    },
                    success: function (result) {
                        if (result != 2) {
                            if (result == 404) {
                                Swal.fire(
                                    'Uyarı!',
                                    'Kullanıcı Aktif Değil Lütfen Öncelikle Aktif Ediniz',
                                    'warning'
                                );
                            } else {
                                Swal.fire(
                                    'Başarılı!',
                                    'Kullanıcı Güncellendi',
                                    'success'
                                );
                                $.get("admin_views/user_config.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                })
                            }
                        } else {
                            Swal.fire(
                                'Oops...',
                                'Bilinmeyen Bir Hata Oluştu',
                                'error'
                            );
                        }
                    }
                })
            }

        })
    </script>
    <?php
}
if ($islem == "kullanici_yetki_ayarlari_modal") {
    ?>
    <div class="modal fade" id="kullanici_yetkilendirme" data-bs-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 40%; max-width: 40%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">Kullanıcı Yetkilendir
                    <button type="button" class="btn-close btn-close-white" id="modal_kapat"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12 row">

                        <table class="table table-sm table-bordered w-100 display nowrap" id="yetkilendirme_tablosu"
                               style="cursor:pointer;font-size: 13px;">
                            <thead>
                            <tr>
                                <th id="click123">Aktif/Pasif</th>
                                <th>Kullanıcı Ekler</th>
                                <th>Kullanıcı Günceller</th>
                                <th>Kullanıcı Silebilir</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function (){
            setTimeout(function (){
                $("#click123").trigger("click");
            },300);
            $("#kullanici_yetkilendirme").modal("show");
            var root_table = $('#yetkilendirme_tablosu').DataTable({
                scrollY: '10vh',
                scrollX: true,
                "info": false,
                bAutoWidth: false,
                searching:false,
                aoColumns: [
                    {sWidth: '2%'},
                    {sWidth: '2%'},
                    {sWidth: '2%'},
                    {sWidth: '3%'}
                ],
                "paging": false,
                "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            });
            $.get("controller/user_controller/sql.php?islem=kullanici_yetkileri_getir",{id:"<?=$_GET["id"]?>"},function (result){
                if (result != 2){
                    var item = JSON.parse(result);
                    var aktif_pasif = "";
                    var kullanici_ekler = "";
                    var kullanici_gunceller = "";
                    var kullanici_silebilir = "";
                    if (item.aktif_pasif_edebilir == false){
                        aktif_pasif = "<button class='btn btn-success btn-sm aktif_yetki' data-id='"+item.id+"'>Yetkilendir</button>";
                    }else {
                        aktif_pasif = "<button class='btn btn-danger btn-sm aktif_yetkisiz' data-id='"+item.id+"'>Yetkiyi Kaldır</button>";
                    }

                    if (item.kullanici_ekleyebilir == false){
                        kullanici_ekler = "<button class='btn btn-success btn-sm ekle_yetki' data-id='"+item.id+"'>Yetkilendir</button>"
                    }else{
                        kullanici_ekler = "<button class='btn btn-danger btn-sm ekle_yetkisiz' data-id='"+item.id+"'>Yetkiyi Kaldır</button>";
                    }
                    if (item.guncelleyebilir == false){
                        kullanici_gunceller = "<button class='btn btn-success btn-sm guncelle_yetki' data-id='"+item.id+"'>Yetkilendir</button>";
                    }else {
                        kullanici_gunceller = "<button class='btn btn-danger btn-sm guncelle_yetkisiz' data-id='"+item.id+"'>Yetkiyi Kaldır</button>";
                    }
                    if (item.kullanici_silebilir == false){
                        kullanici_silebilir = "<button class='btn btn-success btn-sm sil_yetki' data-id='"+item.id+"'>Yetkilendir</button>";
                    }else {
                        kullanici_silebilir = "<button class='btn btn-danger btn-sm sil_yetkisiz' data-id='"+item.id+"'>Yetkiyi Kaldır</button>";
                    }

                    root_table.row.add([aktif_pasif,kullanici_ekler,kullanici_gunceller,kullanici_silebilir]).draw(false);
                }
            });
        });

        $("body").off("click","#modal_kapat").on("click","#modal_kapat",function (){
            $("#kullanici_yetkilendirme").modal("hide");
        });

    </script>
    <?php
}