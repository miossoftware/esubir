<?php
$islem = $_GET["islem"];
if ($islem == "yeni_kullanici_ekle_modal") {
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
                            <div class="ibox-title" style='color:white; font-weight:bold;'>YENİ KULLANICI EKLE</div>
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
                        <button class="btn btn-success btn-sm" id="kullanici_kaydet">Kaydet</button>
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
                $.ajax({
                    url: "controller/user_controller/sql.php?islem=kullanici_ekle_sql",
                    type: "POST",
                    data: {
                        username: username,
                        user_password: user_password,
                        user_root: user_root,
                        e_mail: e_mail,
                        name_surname: name_surname,
                        user_length: user_length
                    },
                    success: function (result) {
                        if (result != 2) {
                            Swal.fire(
                                'Başarılı!',
                                'Kullanıcı Kayıt Edildi',
                                'success'
                            );
                            $.get("admin_views/user_config.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            })
                        } else {
                            Swal.fire(
                                'Oops...',
                                'Bilinmeyen Bir Hata Oluştu',
                                'error'
                            );
                        }
                    }
                })
            })
        </script>
    <?php
}