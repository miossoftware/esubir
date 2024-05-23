<?php
$islem = $_GET["islem"];
if ($islem == "user_root_panel") {
    $user_id = $_GET["id"];
    ?>
    <div class="modal fade" id="user_root_modal" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog">
        <div class="modal-dialog" style="width: 45%; max-width: 45%;">
            <div class="modal-content">
                <div class="modal-header text-white">Kullanıcı Yetkileri
                    <button type="button" class="btn-close btn-close-white" id="modal_close"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <center><h4 id="user_name"></h4></center>
                    <div class="col-12 row mt-3">
                        <table class="table table-bordered table-hover bg-white w-100" style="font-size: 13px"
                               id="root_table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Panel Adı</th>
                                <th id="click123">Yetki</th>
                            </tr>
                            </thead>
                            <tbody class="get-equivalent" style="cursor: pointer;">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $("body").off("click", "#modal_close").on("click", "#modal_close", function () {
            $("#user_root_modal").modal("hide");
        });
        var root_table = "";
        $(document).ready(function () {
            setTimeout(function () {
                $("#click123").trigger("click");
            }, 300);
            $("#user_root_modal").modal("show");

            root_table = $("#root_table").DataTable({
                "responsive": true,
                info: false,
                paging: false,
                bAutoWidth: false,
                searching: false,
                "order": [[ 0, "asc" ]],
                aoColumns: [
                    {sWidth: '3%'},
                    {sWidth: '15%'},
                    {sWidth: '3%'}
                ],
                scrollX: true,
                scrollY: "50vh",
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"
                }
            });
            $.get("controller/sql.php?islem=get_username", {user_id: <?=$user_id?>}, function (result) {
                if (result != 2) {
                    var item = JSON.parse(result);
                    $("#user_name").html(item.name_surname);
                }
            });

            $.get("controller/sql.php?islem=get_all_panels_for_root", {user_id: <?=$user_id?>}, function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    json.forEach(function (item) {
                        $.get("controller/sql.php?islem=yetkisi_varmi", {panel_id: item.panel_id,user_id:<?=$user_id?>}, function (result2) {
                            if (result2 != 2){
                                var item2 = JSON.parse(result2);
                                if (item2.root_id == null) {
                                    root_table.row.add([item.panel_id, item.panel_name, "<button class='btn btn-outline-success btn-sm user_add_root' data-id='" + item.panel_id + "'>Yetkilendir</button>"]).draw(false);
                                } else {
                                    root_table.row.add([item.panel_id, item.panel_name, "<button class='btn btn-outline-danger btn-sm delete_user_root' data-id='" + item2.root_id + "'>Yetkiyi Kaldır</button>"]).draw(false);
                                }
                            }else {
                                root_table.row.add([item.panel_id, item.panel_name, "<button class='btn btn-outline-success btn-sm user_add_root' data-id='" + item.panel_id + "'>Yetkilendir</button>"]).draw(false);
                            }
                        });

                    });
                }
            });
        });
        $("body").off("click", ".delete_user_root").on("click", ".delete_user_root", function () {
            var id = $(this).attr("data-id");
            $.ajax({
                url: "controller/sql.php?islem=delete_user_root",
                type: "POST",
                data: {
                    rootpanel_id: id
                },
                success: function (result) {
                    if (result == 1) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });

                        Toast.fire({
                            icon: 'success',
                            title: 'Yetki Kaldırıldı'
                        });
                        $.get("controller/sql.php?islem=get_all_panels_for_root", {user_id: <?=$user_id?>}, function (result) {
                            if (result != 2) {
                                var json = JSON.parse(result);
                                root_table.clear().draw(false);
                                json.forEach(function (item) {
                                    $.get("controller/sql.php?islem=yetkisi_varmi", {panel_id: item.panel_id,user_id:<?=$user_id?>}, function (result2) {
                                        if (result2 != 2){
                                            var item2 = JSON.parse(result2);
                                            if (item2.root_id == null) {
                                                root_table.row.add([item.panel_id, item.panel_name, "<button class='btn btn-outline-success btn-sm user_add_root' data-id='" + item.panel_id + "'>Yetkilendir</button>"]).draw(false);
                                            } else {
                                                root_table.row.add([item.panel_id, item.panel_name, "<button class='btn btn-outline-danger btn-sm delete_user_root' data-id='" + item2.root_id + "'>Yetkiyi Kaldır</button>"]).draw(false);
                                            }
                                        }else {
                                            root_table.row.add([item.panel_id, item.panel_name, "<button class='btn btn-outline-success btn-sm user_add_root' data-id='" + item.panel_id + "'>Yetkilendir</button>"]).draw(false);
                                        }
                                    });

                                });
                            }
                        });
                    }
                }
            });
        });
        $("body").off("click", ".user_add_root").on("click", ".user_add_root", function () {
            var panel_id = $(this).attr("data-id");
            $.ajax({
                url: "controller/sql.php?islem=user_add_root",
                type: "POST",
                data: {
                    user_id: <?=$user_id?>,
                    rootpanel_id: panel_id
                },
                success: function (result) {
                    if (result == 1) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });

                        Toast.fire({
                            icon: 'success',
                            title: 'Kullanıcı Yetkilendirildi'
                        });
                        $.get("controller/sql.php?islem=get_all_panels_for_root", {user_id: <?=$user_id?>}, function (result) {
                            if (result != 2) {
                                var json = JSON.parse(result);
                                root_table.clear().draw(false);
                                json.forEach(function (item) {
                                    $.get("controller/sql.php?islem=yetkisi_varmi", {panel_id: item.panel_id,user_id:<?=$user_id?>}, function (result2) {
                                        if (result2 != 2){
                                            var item2 = JSON.parse(result2);
                                            if (item2.root_id == null) {
                                                root_table.row.add([item.panel_id, item.panel_name, "<button class='btn btn-outline-success btn-sm user_add_root' data-id='" + item.panel_id + "'>Yetkilendir</button>"]).draw(false);
                                            } else {
                                                root_table.row.add([item.panel_id, item.panel_name, "<button class='btn btn-outline-danger btn-sm delete_user_root' data-id='" + item2.root_id + "'>Yetkiyi Kaldır</button>"]).draw(false);
                                            }
                                        }else {
                                            root_table.row.add([item.panel_id, item.panel_name, "<button class='btn btn-outline-success btn-sm user_add_root' data-id='" + item.panel_id + "'>Yetkilendir</button>"]).draw(false);
                                        }
                                    });

                                });
                            }
                        });
                    } else if (result == 300) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });

                        Toast.fire({
                            icon: 'warning',
                            title: 'Bu Kullanıcın Bu Panel İçin Yetkisi Var'
                        });
                    } else {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        });

                        Toast.fire({
                            icon: 'error',
                            title: 'Bilinmeyen Bir Hata Oluştu'
                        });
                    }
                }
            });
        });
    </script>
<?php }