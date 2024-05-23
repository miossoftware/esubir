<div class="ibox mt-4">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>PERSONEL İZİN</div>
    </div>
    <div class="col-12 ">
        <div class="col-md-2">
            <button class="btn btn-success btn-sm" id="personel_izin_main"><i class="fa fa-plus"></i> Personel İzin Ekle
            </button>
        </div>
    </div>
    <div class="col-12 row">
        <table class="table table-sm table-bordered w-100  nowrap" style="cursor:pointer;font-size: 13px;"
               id="personel_izin_table">
            <thead>
            <tr>
                <th>İzin Türü</th>
                <th>Başlama Tarihi</th>
                <th>Bitiş Tarihi</th>
                <th>Gün</th>
                <th>Dönüş Tarihi</th>
                <th>Açıklama</th>
                <th>İşlem</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<script>

    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });

    $(document).ready(function () {
        jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "date-eu-pre": function (dateString) {
                var parts = dateString.split('/');
                return Date.parse(parts[2] + '/' + parts[1] + '/' + parts[0]) || 0;
            },

            "date-eu-asc": function (a, b) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },

            "date-eu-desc": function (a, b) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        });
        var table = $('#personel_izin_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            "order": [[1, 'desc']],
            columnDefs: [
                {targets: 1, type: "date-eu"}
            ],
            createdRow: function (row, data, dataIndex) {
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        });
        $.get("controller/personel_controller/sql.php?islem=izinli_personeller_listesi", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                json.forEach(function (item) {
                    let gonderilen_tarih = item.izin_baslangic;
                    gonderilen_tarih = gonderilen_tarih.split(" ");
                    gonderilen_tarih = gonderilen_tarih[0];
                    gonderilen_tarih = gonderilen_tarih.split("-");
                    var gun = gonderilen_tarih[2];
                    var ay = gonderilen_tarih[1];
                    var yil = gonderilen_tarih[0];
                    var arr = [gun, ay, yil];
                    gonderilen_tarih = arr.join("/");

                    let gonderilen_tarih1 = item.izin_bitis;
                    gonderilen_tarih1 = gonderilen_tarih1.split(" ");
                    gonderilen_tarih1 = gonderilen_tarih1[0];
                    gonderilen_tarih1 = gonderilen_tarih1.split("-");
                    var gun1 = gonderilen_tarih1[2];
                    var ay1 = gonderilen_tarih1[1];
                    var yil1 = gonderilen_tarih1[0];
                    var arr1 = [gun1, ay1, yil1];
                    gonderilen_tarih1 = arr1.join("/");

                    let don = item.donus_tarih;
                    don = don.split(" ");
                    don = don[0];
                    don = don.split("-");
                    var gun2 = don[2];
                    var ay2 = don[1];
                    var yil2 = don[0];
                    var arr2 = [gun2, ay2, yil2];
                    don = arr2.join("/");


                    var new_row = table.row.add([item.izin_turu, gonderilen_tarih, gonderilen_tarih1, item.izin_gun, don, item.aciklama, "<button class='btn btn-danger izni_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                    $(new_row).find("td").eq(0).css("text-align", "left");
                    $(new_row).find("td").eq(1).css("text-align", "left");
                    $(new_row).find("td").eq(2).css("text-align", "left");
                    $(new_row).find("td").eq(3).css("text-align", "left");
                    $(new_row).find("td").eq(4).css("text-align", "left");
                    $(new_row).find("td").eq(5).css("text-align", "left");
                    $(new_row).find("td").eq(6).css("text-align", "left");
                })
            }
        })
    });

    $("body").off("click", ".izni_sil").on("click", ".izni_sil", function () {
        var id = $(this).attr("data-id");
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Cariyi seçiniz',
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
                        url: "controller/personel_controller/sql.php?islem=personel_izni_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı!',
                                    'İzin Silindi',
                                    'success'
                                );
                                $.get("view/personel_izin.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/personel_izin.php", function (getList) {
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
    })

    $("body").off("click", "#personel_izin_main").on("click", "#personel_izin_main", function () {
        $.get("modals/personel_modal/izin_modal.php?islem=yeni_izin_tanimla", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

</script>