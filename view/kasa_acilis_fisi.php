<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>KASA AÇILIŞ FİŞİ</div>
    </div>
    <div class="col-12 mt-3">
        <div class="col-2">
            <button class="btn btn-success btn-sm" id="kasa_acilis_fisi_olustur_main"><i class="fa fa-plus"></i>
                Kasa Açılış Fişi Ekle
            </button>
        </div>
    </div>
    <div class="col-12 row">
        <table class="table table-sm table-bordered w-100  nowrap" style="cursor:pointer;font-size: 13px;"
               id="bankadan_cekilen_table">
            <thead>
            <tr>
                <th>Kasa Adı</th>
                <th>Kasa Kodu</th>
                <th>Giren Tutar</th>
                <th>Çıkan Tutar</th>
                <th>Açıklama</th>
                <th>İşlem</th>
            </tr>
            </thead>
            <tfoot style="background-color: white">
            <th></th>
            <th></th>
            <th style="text-align: right" class="ka_giren">0,00</th>
            <th style="text-align: right" class="ka_cikan">0,00</th>
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
        var table = $('#bankadan_cekilen_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            createdRow: function (row, data, dataIndex) {
                $(row).addClass("stok_list_selected");

            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        });
        $.get("controller/kasa_controller/sql.php?islem=kasa_acilis_fislerini_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                let ka_giren = 0;
                let ka_cikan = 0;
                json.forEach(function (item) {
                    var giren_tutar = item.giren_tutar;
                    giren_tutar = parseFloat(giren_tutar);
                    ka_giren += giren_tutar;
                    giren_tutar = giren_tutar.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })
                    var cikanTutar = item.cikan_tutar;
                    cikanTutar = parseFloat(cikanTutar);
                    ka_cikan += cikanTutar;
                    cikanTutar = cikanTutar.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })

                    $(".ka_giren").html(ka_giren.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                    $(".ka_cikan").html(ka_cikan.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                    var new_row = table.row.add([item.kasa_adi, item.kasa_kodu, giren_tutar, cikanTutar, item.aciklama, "<button class='btn btn-sm kasa_acilis_fisi_guncelle' style='background-color: #F6FA70' data-id='" + item.id + "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm acilisi_sil_main' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                    $(new_row).find('td').eq(0).css('text-align', 'left');
                    $(new_row).find('td').eq(1).css('text-align', 'left');
                    $(new_row).find('td').eq(4).css('text-align', 'left');
                })
            }
        })
    });

    $("body").off("click", ".kasa_acilis_fisi_guncelle").on("click", ".kasa_acilis_fisi_guncelle", function () {
        let id = $(this).attr("data-id");
        $.get("modals/kasa_modal/kasa_acilis_fisi.php?islem=kasa_acilis_fisi_guncelle_modal", {id: id}, function (getModal) {
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".acilisi_sil_main").on("click", ".acilisi_sil_main", function () {
        var arr = [];
        var id = $(this).attr("data-id");
        arr.push(id);
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Kaydı seçiniz',
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
                        url: "controller/kasa_controller/sql.php?islem=secilen_acilislari_sil_sql",
                        type: "POST",
                        data: {
                            id: arr,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Açılış Fişi Silindi',
                                    'success'
                                );
                                $.get("view/kasa_acilis_fisi.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                });
                                $.get("view/kasa_acilis_fisi.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                });
                            }
                        }
                    })
                }
            });
        }
    });

    $("body").off("click", "#kasa_acilis_fisi_olustur_main").on("click", "#kasa_acilis_fisi_olustur_main", function () {
        $.get("modals/kasa_modal/kasa_acilis_fisi.php?islem=yeni_kasa_acilis_fisi_ekle", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    })

</script>