<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>KREDİ KARTI TANIM</div>
    </div>
    <div class="col-12 row">
        <div class="banka_tanim_button mt-3 mx-3">
            <button class="btn btn-success btn-sm" id="kredi_karti_tanimla_main_button"><i class="fa fa-plus-square"
                                                                                           aria-hidden="true"></i>
                Kredi Kartı Tanımla
            </button>
        </div>
        <div class="col-12 row mx-1 mt-3">
            <table class="table table-sm table-bordered w-100 nowrap" id="kredi_kart_listesi"
                   style="font-size: 13px;">
                <thead>
                <tr>
                    <th>Kredi Kartı Adı</th>
                    <th>Kart Kodu</th>
                    <th>Banka Adı</th>
                    <th>Toplam Limit</th>
                    <th>Dönem İçi Harcama</th>
                    <th>Kullanılabilir Limit</th>
                    <th style="width: 0%">Hesap Kesim</th>
                    <th style="width: 0%">İşlem</th>
                </tr>
                </thead>
            </table>
        </div>
        <div class="col-12 row">
            <div class="col-3"></div>
            <div class="col-md-4">
                <table class="table table-sm table-bordered w-100 nowrap" style="background-color: white">
                    <thead>
                    <tr>
                        <th style="text-align: center">Toplam Borç</th>
                        <th style="text-align: center">Kullanılabilir Limit</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="toplam_harcama" style="text-align: right;font-weight: bold">0,00 TL</td>
                        <td class="toplam_limit" style="text-align: right;font-weight: bold">0,00 TL</td>
                    </tr>
                    </tbody>
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
    $(document).ready(function () {
        var table = $('#kredi_kart_listesi').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            "paging": false,
            autoWidth: false,
            columns: [
                {"data": "kart_adi"},
                {"data": "kart_kodu"},
                {"data": "banka_adi"},
                {"data": "toplam_limit"},
                {"data": "toplam_harcama"},
                // {"data": "toplam_harcama"},
                // {"data": "toplam_odeme"},
                {"data": "kullanilabilir_limit"},
                {"data": "vade_gunu"},
                {"data": "button"}
            ],
            createdRow: function (row) {
                $(row).find("td").css("text-transform", "uppercase")
                $(row).find("td").eq(0).css("text-align", "left");
                $(row).find("td").eq(1).css("text-align", "left");
                $(row).find("td").eq(2).css("text-align", "left");
                $(row).find("td").eq(6).css("text-align", "left");
            },
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        })

        $.get("controller/kart_controller/sql.php?islem=kredi_kartlarini_getir_sql", function (response) {
            if (response != 2) {
                var json = JSON.parse(response);
                let basilacak_arr = [];
                let tl = 0;
                let th = 0;
                json.forEach(function (item) {
                    let toplam_cekilen = item.toplam_cekilen;
                    toplam_cekilen = parseFloat(toplam_cekilen);
                    if (isNaN(toplam_cekilen)) {
                        toplam_cekilen = 0;
                    }
                    let toplam_cekilen1 = item.toplam_cekilen1;
                    toplam_cekilen1 = parseFloat(toplam_cekilen1);
                    if (isNaN(toplam_cekilen1)) {
                        toplam_cekilen1 = 0;
                    }

                    let toplam_cekilen2 = item.toplam_cekilen2;
                    toplam_cekilen2 = parseFloat(toplam_cekilen2);
                    if (isNaN(toplam_cekilen2)) {
                        toplam_cekilen2 = 0;
                    }

                    let toplam_cekilen5 = item.toplam_cekilen5;
                    toplam_cekilen5 = parseFloat(toplam_cekilen5);
                    if (isNaN(toplam_cekilen5)) {
                        toplam_cekilen5 = 0;
                    }

                    let toplam_cekilen6 = item.toplam_cekilen6;
                    toplam_cekilen6 = parseFloat(toplam_cekilen6);
                    if (isNaN(toplam_cekilen6)) {
                        toplam_cekilen6 = 0;
                    }

                    let toplam_cekilen4 = item.toplam_cekilen4;
                    toplam_cekilen4 = parseFloat(toplam_cekilen4);
                    if (isNaN(toplam_cekilen4)) {
                        toplam_cekilen4 = 0;
                    }

                    let toplam_cekilen3 = item.toplam_cekilen3;
                    toplam_cekilen3 = parseFloat(toplam_cekilen3);
                    if (isNaN(toplam_cekilen3)) {
                        toplam_cekilen3 = 0;
                    }

                    let toplam_odenen = item.toplam_odenen;
                    toplam_odenen = parseFloat(toplam_odenen);
                    if (isNaN(toplam_odenen)) {
                        toplam_odenen = 0;
                    }

                    let toplam_cekilen7 = item.toplam_cekilen7;
                    toplam_cekilen7 = parseFloat(toplam_cekilen7);
                    if (isNaN(toplam_cekilen7)) {
                        toplam_cekilen7 = 0;
                    }

                    let toplam_cekilen8 = item.toplam_cekilen8;
                    toplam_cekilen8 = parseFloat(toplam_cekilen8);
                    if (isNaN(toplam_cekilen8)) {
                        toplam_cekilen8 = 0;
                    }

                    let toplam_cekilen9 = item.toplam_cekilen9;
                    toplam_cekilen9 = parseFloat(toplam_cekilen9);
                    if (isNaN(toplam_cekilen9)) {
                        toplam_cekilen9 = 0;
                    }

                    let toplam_cekilen10 = item.toplam_cekilen10;
                    toplam_cekilen10 = parseFloat(toplam_cekilen10);
                    if (isNaN(toplam_cekilen10)) {
                        toplam_cekilen10 = 0;
                    }

                    let toplam_odenen1 = item.toplam_odenen1;
                    toplam_odenen1 = parseFloat(toplam_odenen1);
                    if (isNaN(toplam_odenen1)) {
                        toplam_odenen1 = 0;
                    }
                    toplam_cekilen += toplam_cekilen1;
                    toplam_cekilen += toplam_cekilen2;
                    toplam_cekilen += toplam_cekilen3;
                    toplam_cekilen += toplam_cekilen4;
                    toplam_cekilen += toplam_cekilen5;
                    toplam_cekilen += toplam_cekilen6;
                    toplam_cekilen += toplam_cekilen7;
                    toplam_cekilen += toplam_cekilen8;
                    toplam_cekilen += toplam_cekilen9;
                    toplam_cekilen += toplam_cekilen10;
                    toplam_odenen += toplam_odenen1;

                    let fark = toplam_cekilen - toplam_odenen;
                    th += fark;
                    let kart_limit = item.kart_limiti;
                    kart_limit = parseFloat(kart_limit);

                    toplam_odenen = toplam_odenen.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });
                    toplam_cekilen = toplam_cekilen.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let kalan_limit = kart_limit - fark;

                    tl += kalan_limit;

                    toplam_cekilen = toplam_cekilen.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    kart_limit = kart_limit.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });
                    kalan_limit = kalan_limit.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });
                    var today = new Date();
                    var year = today.getFullYear();
                    var month = String(today.getMonth() + 1).padStart(2, "0");
                    var day = item.hesap_kesim_gun;
                    if (day < 10) {
                        day = "0" + day
                    }
                    var formattedDate = day + "/" + month + "/" + year;
                    let newRow = {
                        'kart_adi': item.kart_adi,
                        'kart_kodu': item.kart_kodu,
                        'banka_adi': item.banka_adi,
                        'toplam_limit': kart_limit,
                        'toplam_harcama': fark.toLocaleString("tr-TR", {
                            maximumFractionDigits: 2,
                            minimumFractionDigits: 2
                        }),
                        'toplam_odeme': toplam_odenen,
                        'kullanilabilir_limit': kalan_limit,
                        'vade_gunu': formattedDate,
                        'button': "<button class='btn btn-sm kart_hesap_guncelle_main_button' style='background-color: #F6FA70' data-id='" + item.id + "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm tanimli_kart_sil_main_button' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>",
                    };
                    basilacak_arr.push(newRow);
                });
                $(".toplam_harcama").html(th.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) + " TL");
                $(".toplam_limit").html(tl.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) + " TL");
                table.rows.add(basilacak_arr).draw(false);
            }
        })
    })

    $("body").off("click", ".tanimli_kart_sil_main_button").on("click", ".tanimli_kart_sil_main_button", function () {
        let id = $(this).attr("data-id");
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
                    url: "controller/kart_controller/sql.php?islem=kart_sil_main_sql",
                    type: "POST",
                    data: {
                        id: id,
                        delete_detail: delete_detail
                    },
                    success: function (result) {
                        if (result != 2) {
                            if (result == 300) {
                                Swal.fire(
                                    'Uyarı!',
                                    'Kredi Kartına Ait Hareket Vardır Lütfen Önce Hareketi Siliniz',
                                    'warning'
                                );
                            } else {
                                Swal.fire(
                                    'Başarılı!',
                                    'Kart Silindi',
                                    'success'
                                );
                                $.get("view/kredi_karti_tanimla.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/kredi_karti_tanimla.php", function (getList) {
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
    });

    $("body").off("click", "#kredi_karti_tanimla_main_button").on("click", "#kredi_karti_tanimla_main_button", function () {
        $.get("modals/kredi_kart_modal/modal.php?islem=kredi_karti_tanim_modal_getir", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".kart_hesap_guncelle_main_button").on("click", ".kart_hesap_guncelle_main_button", function () {
        let id = $(this).attr("data-id");
        $.get("modals/kredi_kart_modal/modal_page.php?islem=guncelle_modal_getir", {id: id}, function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        });
    })

</script>