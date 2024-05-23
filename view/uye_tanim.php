<style>
    .edit_list td {
        text-align: left;
    }
</style>
<div class="ibox-container">
    <div class="ibox mt-5">
        <div class="ibox-head">
            <div class="ibox-title" style=' font-weight:bold;'>ÜYE TANIMLA</div>
        </div>
        <div class="col-12 row">
            <div class="uye_buttons mt-3 mx-3">
                <button class="btn btn-success btn-sm" id="uye_ekle_main"><i class="fa fa-plus-square"
                                                                             aria-hidden="true"></i> Üye Ekle
                </button>
                <button class="btn  btn-sm" id="uye_guncelle_main" style="background-color: #F6FA70"><i
                            class="fa fa-refresh"
                            aria-hidden="true"></i> Üye Güncelle
                </button>
            </div>
            <div class="col-12 row mx-1 mt-3">
                <table class="table table-sm table-bordered w-100 nowrap edit_list"
                       style="cursor:pointer;font-size: 13px;"
                       id="uye_table">
                    <thead>
                    <tr>
                        <th style="width: 0% !important;">#</th>
                        <th style="width: 1% !important;">Üye Türü</th>
                        <th>TC No</th>
                        <th>Üye Adı</th>
                        <th>Cep No</th>
                        <th>İl</th>
                        <th>İlçe</th>
                        <th>Adres</th>
                        <th>İşlem</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<script>

    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });

    $("body").off("click", "#uye_guncelle_main").on("click", "#uye_guncelle_main", function () {
        var uye_kodu = $(".select").find("td").eq(2).html();
        if (uye_kodu == "" || uye_kodu == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz uyeyi seçiniz',
                'warning'
            );
        } else {
            $.get("modals/uye_modal/modal.php?islem=uye_guncelle_modal", {tc_no: uye_kodu}, function (getModal) {
                $(".getModals").html("");
                $(".getModals").html(getModal);
            })
        }
    });

    function formatHiddenRow(data) {
        var html = '<tr class="hidden-row" style="text-align: left;">';
        html += '<td>İl: </td>';
        html += '<td style="text-align: left">' + data.il + '</td>';
        html += '<td>İlçe: </td>';
        html += '<td style="text-align: left">' + data.ilce + '</td>';
        html += '<td>Mahalle: </td>';
        html += '<td>' + data.mahalle_koy + '</td>';
        html += '<td>Ada: </td>';
        html += '<td>' + data.ada + '</td>';
        html += '<td>Parsel: </td>';
        html += '<td>' + data.parsel + '</td>';
        html += '<td>Yüz Ölçümü: </td>';
        let yuz_olcumu = data.yuz_olcumu;
        yuz_olcumu = parseFloat(yuz_olcumu);
        yuz_olcumu = yuz_olcumu.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
        html += '<td>' + yuz_olcumu + '</td>';
        let sulama_alani = data.sulama_alani;
        sulama_alani = parseFloat(sulama_alani);
        sulama_alani = sulama_alani.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
        html += '<td>Sulama Alanı: </td>';
        html += '<td>' + sulama_alani + '</td>';
        html += '<td>Cilt No: </td>';
        html += '<td>' + data.cilt_no + '</td>';
        html += '<td>Edinme Nedeni</td>';
        html += '<td style="text-align: left">' + data.edinme_nedeni + '</td>';
        html += '</tr>';
        return html;
    }


    $("body").off("click", ".uye_sil_button").on("click", ".uye_sil_button", function () {
        var uye_kodu = $(this).attr("data-id");
        if (uye_kodu == "" || uye_kodu == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Üyeyi seçiniz',
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
                        url: "controller/uye_controller/sql.php?islem=uyeyi_sil_sql",
                        type: "POST",
                        data: {
                            tc_no: uye_kodu,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                if (result == 300) {
                                    Swal.fire(
                                        'Uyarı!',
                                        'Üyeye Ait Hareket Bulunmaktadır Lütfen Öncelikli Olarak Hareketleri Siliniz...',
                                        'warning'
                                    );
                                } else {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Üye Silindi',
                                        'success'
                                    );
                                    $.get("view/uye_tanim.php", function (getList) {
                                        $(".modal-icerik").html("");
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("view/uye_tanim.php", function (getList) {
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
                    });
                }
            });
        }
    });

    $("body").off("click", ".uye_aktif_button").on("click", ".uye_aktif_button", function () {
        var uye_kodu = $(this).attr("data-id");
        if (uye_kodu == "" || uye_kodu == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Üyeyi seçiniz',
                'warning'
            );
        } else {
            $.ajax({
                url: "controller/uye_controller/sql.php?islem=uyeyi_aktif_et_sql",
                type: "POST",
                data: {
                    id: uye_kodu
                },
                success: function (result) {
                    if (result != 2) {
                        if (result == 300) {
                            Swal.fire(
                                'Uyarı!',
                                'Üyeye Ait Hareket Bulunmaktadır Lütfen Öncelikli Olarak Hareketleri Siliniz...',
                                'warning'
                            );
                        } else {
                            Swal.fire(
                                'Başarılı!',
                                'Üye Aktif Edildi',
                                'success'
                            );
                            $.get("view/uye_tanim.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            })
                            $.get("view/uye_tanim.php", function (getList) {
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
            });
        }
    });

    $("body").off("click", ".list_selected").on("click", ".list_selected", function () {
        $('.list_selected').css("background-color", "rgb(255, 255, 255)");
        $(this).css("background-color", "#60b3abad");
        $('.list_selected').removeClass('select');
        $(this).addClass("select");
        $(".select").css("background-color", "#B9EDDD");
    });

    $(document).ready(function () {
        var table = $('#uye_table').DataTable({
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            scrollX: true,
            paging: false,
            autoWidth: false,
            scrollY: "55vh",
            order: [1, "asc"],
            "initComplete": function () {
                $('#uye_table').addClass('myCustomStyle');
            },
            columns: [
                {"data": "tapular"},
                {"data": "abone_mi"},
                {"data": "tc_no"},
                {"data": "uye_adi"},
                {"data": "cep_no"},
                {"data": "uye_il"},
                {"data": "uye_ilce"},
                {"data": "adres"},
                {"data": "islem"},
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).addClass("list_selected");
                $(row).find("td").css("text-transform", "uppercase")
                $(row).find("td").eq(11).css("text-align", "right");
                $(row).find("td").eq(12).css("text-align", "right");
                $(row).find("td").eq(17).css("text-align", "right");
            }
        })
        $("body").off("click", ".uyeye_ait_tapulari_getir").on("click", ".uyeye_ait_tapulari_getir", function () {
            let id = $(this).attr("data-id");
            var tr = $(this).closest("tr");
            var row = table.row(tr);
            $.get("controller/uye_controller/sql.php?islem=uyeye_ait_tapulari_getir_sql", {id: id}, function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);

                    if (row.child.isShown()) {
                        // Gizli satır zaten açıksa kapat
                        row.child.hide();
                        tr.removeClass('shown');
                    } else {
                        var html = "";
                        for (var i = 0; i < json.length; i++) {
                            html += formatHiddenRow(json[i]);
                        }
                        row.child(html).show();
                        tr.addClass('shown');
                    }
                }
            })
        });
        $.get("controller/uye_controller/sql.php?islem=uyeleri_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        })

    });

    $("body").off("click", "#uye_ekle_main").on("click", "#uye_ekle_main", function () {
        $.get("modals/uye_modal/modal.php?islem=uye_ekle_modal", function (getModal) {
            $(".getModals").html(getModal);
        })
    })
</script>