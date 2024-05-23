<div class="ibox mt-4">

    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>PERSONEL DEVAMSIZLIK</div>
    </div>
    <div class="col-12 mt-2">
        <div class="col-3">
            <button class="btn btn-success btn-sm" id="personel_devamsizlik_ekle_main"><i class="fa fa-plus"></i>
                Devamsızlık Ekle
            </button>
        </div>
    </div>

    <div class="col-12 row">
        <table class="table table-sm table-bordered w-100  nowrap" style="cursor:pointer;font-size: 13px;"
               id="personel_devamsizlik_table">
            <thead>
            <tr>
                <th>Ad Soyad</th>
                <th>Devamsızlık Türü</th>
                <th>Başlama Tarihi</th>
                <th>Bitiş Tarihi</th>
                <th>Gün</th>
                <th>Açıklama</th>
                <th>Maaş Etkisi</th>
                <th>İşlem</th>
            </tr>
            </thead>
            <tfoot style="background-color: white">
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th class="devamsizlik_tot">0</th>
            <th></th>
            <th></th>
            <th></th>
            </tfoot>
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
        var table = $('#personel_devamsizlik_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            columnDefs: [
                {targets: 2, type: "date-eu"}
            ],
            "order": [[2, 'desc']],
            "info": false,
            createdRow: function (row, data, dataIndex) {
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        });

        $.get("controller/personel_controller/sql.php?islem=personel_devamsizliklari", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                let devamsizlik_tot = 0;
                json.forEach(function (item) {
                    let hesaplama = "";
                    if (item.hesaplama_sekli == 1) {
                        hesaplama = "Aylık"
                    } else {
                        hesaplama = "Günlük"
                    }
                    let etki = "";
                    if (item.maas_etkilensin == 1) {
                        etki = "Etkiler"
                    } else {
                        etki = "Etkilemez"
                    }
                    let gonderilen_tarih = item.devamsizlik_bas;
                    gonderilen_tarih = gonderilen_tarih.split(" ");
                    gonderilen_tarih = gonderilen_tarih[0];
                    gonderilen_tarih = gonderilen_tarih.split("-");
                    var gun = gonderilen_tarih[2];
                    var ay = gonderilen_tarih[1];
                    var yil = gonderilen_tarih[0];
                    var arr = [gun, ay, yil];
                    gonderilen_tarih = arr.join("/");
                    let devamsizlik_suresi = item.devamsizlik_suresi;
                    devamsizlik_suresi = parseFloat(devamsizlik_suresi);
                    devamsizlik_tot += devamsizlik_suresi;

                    let devamsizlikBit = item.devamsizlik_bit;
                    devamsizlikBit = devamsizlikBit.split(" ");
                    devamsizlikBit = devamsizlikBit[0];
                    devamsizlikBit = devamsizlikBit.split("-");
                    var gun1 = devamsizlikBit[2];
                    var ay1 = devamsizlikBit[1];
                    var yil1 = devamsizlikBit[0];
                    var arr1 = [gun1, ay1, yil1];
                    devamsizlikBit = arr1.join("/");

                    $(".devamsizlik_tot").html(devamsizlik_tot+" GÜN");
                    var new_row = table.row.add([item.ad_soyad, item.devamsizlik_turu, gonderilen_tarih, devamsizlikBit, item.devamsizlik_suresi+" GÜN", item.aciklama, etki, "<button class='btn btn-danger btn-sm devamsizlik_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                    $(new_row).find("td").eq(0).css("text-align", "left");
                    $(new_row).find("td").eq(1).css("text-align", "left");
                    $(new_row).find("td").eq(2).css("text-align", "left");
                    $(new_row).find("td").eq(3).css("text-align", "left");
                    $(new_row).find("td").eq(4).css("text-align", "left");
                    $(new_row).find("td").eq(5).css("text-align", "left");
                    $(new_row).find("td").eq(6).css("text-align", "left");
                    $(new_row).find("td").eq(7).css("text-align", "left");
                })
            }
        })
    })

    $("body").off("click", ".devamsizlik_sil").on("click", ".devamsizlik_sil", function () {
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
                        url: "controller/personel_controller/sql.php?islem=personel_devamsizlik_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Devamsızlık Silindi',
                                    'success'
                                );
                                $.get("view/personel_devamsizlik.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/personel_devamsizlik.php", function (getList) {
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

    $("body").off("click", "#personel_devamsizlik_ekle_main").on("click", "#personel_devamsizlik_ekle_main", function () {
        $.get("modals/personel_modal/devamsizlik_modal.php?islem=personel_devamsizlik_ekle", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    })

</script>
