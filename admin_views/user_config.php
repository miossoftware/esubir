<?php
session_start();
?>
<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>KULLANICI TANIMLA</div>
    </div>
    <div class="col-12 mx-4 mt-3">
        <button class="btn btn-success btn-sm" id="kullanici_ekle_main"><i class="fa fa-plus"></i> Kullanıcı Ekle
        </button>
        <button class="btn btn-sm" style="background-color: #F6FA70" id="kullanici_guncelle_main"><i
                    class="fa fa-refresh"></i> Kullanıcı
            Güncelle
        </button>
        <button class="btn btn-danger btn-sm" id="kullanici_sil_main"><i class="fa fa-trash"></i> Kullanıcı Sil
        </button>
    </div>
    <div class="col-12 row mx-1">
        <table class="table table-sm table-bordered w-100 display nowrap" id="kullanıcı_tablo"
               style="cursor:pointer;font-size: 13px;">
            <thead>
            <tr>
                <th>ID</th>
                <th>Kullanıcı Adı</th>
                <th>E-Mail</th>
                <th>Ad Soyad</th>
                <th>Max. Kullanıcı Sayısı</th>
                <th>Durum</th>
                <th>İşlem</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    $("body").off("click", "#kullanici_ekle_main").on("click", "#kullanici_ekle_main", function () {
        $.get("modals/user_modal/modal.php?islem=yeni_kullanici_ekle_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", "#kullanici_guncelle_main").on("click", "#kullanici_guncelle_main", function () {
        var id = $(".select").find("td").first().html();
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Kullanıcıyı seçiniz',
                'warning'
            );
        } else {
            $.get("modals/user_modal/modal_page.php?islem=kullanici_guncelle_modal", {id: id}, function (getModal) {
                $(".getModals").html("");
                $(".getModals").html(getModal);
            })
        }
    });

    $(document).ready(function () {
        var user_table = $('#kullanıcı_tablo').DataTable({
            scrollY: '73vh',
            scrollX: true,
            "info": false,
            bAutoWidth: false,
            aoColumns: [
                {sWidth: '1%'},
                {sWidth: '2%'},
                {sWidth: '2%'},
                {sWidth: '3%'},
                {sWidth: '1%'},
                {sWidth: '1%'},
                {sWidth: '1%'}
            ],
            "paging": false,
            createdRow: function (row) {
                $(row).addClass("user_list_selected");
            },
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        $.get("controller/user_controller/sql.php?islem=kullanicilari_getir", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                $.get("controller/user_controller/sql.php?islem=user_yetkisi", function (yetki) {
                    if (yetki == 2) {
                        json.forEach(function (item) {
                            var durum = "";
                            var durum_button = "";
                            if (item.status == 1) {
                                durum = "<label style='color: green'>Aktif</label>"
                                durum_button = "<button class='mx-2 btn btn-danger btn-sm kullanici_pasif' data-id='" + item.id + "'>Pasif Et</button>";
                            } else if (item.status == 4) {
                                durum = "<label style='color:orange'>Onay Bekliyor</label>"
                                durum_button = "<button class='mx-2 btn btn-success btn-sm kullanici_aktif' data-id='" + item.id + "'>Aktif Et</button>";
                            } else {
                                durum = "<label style='color: red'>Pasif</label>";
                                durum_button = "<button class='mx-2 btn btn-success btn-sm kullanici_aktif' data-id='" + item.id + "'>Aktif Et</button>";
                            }
                            user_table.row.add([item.id, item.username, item.e_mail, item.name_surname, item.user_length, durum, durum_button + "<button class='btn btn-warning btn-sm kullanici_yetkilendir' data-id='" + item.id + "'>Yetkilendir</button>"]).draw(false);
                        });
                    } else {
                        json.forEach(function (item) {
                            var durum = "";
                            var durum_button = "";
                            if (item.status == 1) {
                                durum = "<label style='color: green'>Aktif</label>"
                                durum_button = "<button class='mx-2 btn btn-danger btn-sm kullanici_pasif' data-id='" + item.id + "'>Pasif Et</button>";
                            } else if (item.status == 4) {
                                durum = "<label style='color:orange'>Onay Bekliyor</label>"
                                durum_button = "<button class='mx-2 btn btn-success btn-sm kullanici_aktif' data-id='" + item.id + "'>Aktif Et</button>";
                            } else {
                                durum = "<label style='color: red'>Pasif</label>";
                                durum_button = "<button class='mx-2 btn btn-success btn-sm kullanici_aktif' data-id='" + item.id + "'>Aktif Et</button>";
                            }
                            var design_table = user_table.row.add([item.id, item.username, item.e_mail, item.name_surname, item.user_length, durum, durum_button]).draw(false).node();

                            $(design_table).find("td").eq(0).css("text-align", "left");
                            $(design_table).find("td").eq(1).css("text-align", "left");
                            $(design_table).find("td").eq(2).css("text-align", "left");
                            $(design_table).find("td").eq(3).css("text-align", "left");
                            $(design_table).find("td").eq(4).css("text-align", "left");
                            $(design_table).find("td").eq(5).css("text-align", "left");
                            $(design_table).find("td").eq(6).css("text-align", "left");
                        });
                    }
                });
            }
        })
    });

    $("body").off("click", ".kullanici_yetkilendir").on("click", ".kullanici_yetkilendir", function () {
        var id = $(this).attr("data-id");
        $.get("modals/user_modal/modal_page.php?islem=kullanici_yetki_ayarlari_modal", {id: id}, function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    })


    $("body").off("click", ".kullanici_aktif").on("click", ".kullanici_aktif", function () {
        var id = $(this).attr("data-id");
        $.ajax({
            url: "controller/user_controller/sql.php?islem=kullanici_aktif_et_sql",
            type: "POST",
            data: {
                id: id
            },
            success: function (result) {
                if (result != 2) {
                    if (result == 404) {
                        Swal.fire(
                            'Başarılı!',
                            'Bu Kullanıcıyı Sadece Süper Admin Aktif Edebilir',
                            'warning'
                        );
                    } else {
                        Swal.fire(
                            'Başarılı!',
                            'Kullanıcı Aktif Edildi',
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
    });

    $("body").off("click", ".kullanici_pasif").on("click", ".kullanici_pasif", function () {
        var id = $(this).attr("data-id");
        $.ajax({
            url: "controller/user_controller/sql.php?islem=kullanici_pasif_et_sql",
            type: "POST",
            data: {
                id: id
            },
            success: function (result) {
                if (result != 2) {
                    Swal.fire(
                        'Başarılı!',
                        'Kullanıcı Pasif Edildi',
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
    });

    $("body").off("click", ".user_list_selected").on("click", ".user_list_selected", function () {
        $('.user_list_selected').css("background-color", "rgb(255, 255, 255)");
        $(this).css("background-color", "#60b3abad");
        $('.user_list_selected').removeClass('select');
        $(this).addClass("select");
        $(".select").css("background-color", "#B9EDDD");
    });

    $("body").off("click", "#kullanici_sil_main").on("click", "#kullanici_sil_main", function () {
        var id = $(".select").find("td").first().html();
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Kullanıcıyı seçiniz',
                'warning'
            );
        } else {
            Swal.fire({
                title: 'Silme Nedeni Giriniz',
                input: 'text',
                inputPlaceholder: 'Silme Nedeni',
                showCancelButton: true,
                confirmButtonText: 'Tamam',
                cancelButtonText: 'İptal',
                allowOutsideClick: false,
                inputValidator: (value) => {
                    if (!value) {
                        return 'Silme Nedeni Boş Bırakılamaz';
                    }
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    const delete_detail = result.value;
                    $.ajax({
                        url: "controller/user_controller/sql.php?islem=kullaniciyi_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Kullanıcı Silindi',
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
                    });
                }
            });
        }
    });

</script>