<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>KASA TANIMLA</div>
    </div>
    <div class="col-12 row">
        <div class="kasa_tanim_buttons mt-3 mx-3">
            <button class="btn btn-success btn-sm" id="kasa_tanimla_main_button"><i class="fa fa-plus-square"
                                                                                    aria-hidden="true"></i> Kasa
                Tanımla
            </button>
            <button class="btn  btn-sm" id="kasa_guncelle_main" style="background-color: #F6FA70"><i
                        class="fa fa-refresh"
                        aria-hidden="true"></i> Kasa Güncelle
            </button>
            <button class="btn btn-danger btn-sm" id="kasa_sil"><i class="fa fa-trash" aria-hidden="true"></i> Kasa
                Sil
            </button>
        </div>
        <div class="col-12 row mx-1 mt-3">
            <table class="table table-sm table-bordered w-100 display nowrap" id="kasa_tablo"
                   style="cursor:pointer;font-size: 13px;">
                <thead>
                <tr>
                    <th>Kasa Kodu</th>
                    <th>Kasa Adı</th>
                    <th>Giren Tutar</th>
                    <th>Çıkan Tutar</th>
                    <th>Bakiye</th>
                    <th>B.Durum</th>
                    <th>Varsayılan</th>
                </tr>
                </thead>
            </table>
        </div>
        <div class="col-12 row">
            <div class="col-3"></div>
            <div class="col-md-6">
                <table class="table table-sm table-bordered w-100 display nowrap" style="background-color: white">
                    <thead>
                    <tr>
                        <th style="text-align: center">Toplam Yatan</th>
                        <th style="text-align: center">Toplam Çekilen</th>
                        <th style="text-align: center">Toplam Bakiye</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="toplam_y" style="text-align: right;font-weight: bold">0,00 TL</td>
                        <td class="toplam_c" style="text-align: right;font-weight: bold">0,00 TL</td>
                        <td class="toplam_b" style="text-align: right;font-weight: bold">0,00 TL</td>
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

    $("body").off("click", "#kasa_guncelle_main").on("click", "#kasa_guncelle_main", function () {
        var kasa_kodu = $(".select").find("td").first().html();
        if (kasa_kodu == "" || kasa_kodu == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Kasayı seçiniz',
                'warning'
            );
        } else {
            $.get("modals/kasa_modal/modal_page.php", {kasa_kodu: kasa_kodu}, function (getModal) {
                $(".getModals").html("");
                $(".getModals").html(getModal);
            });
        }
    })

    $(document).ready(function () {
        var table = $('#kasa_tablo').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            columns: [
                {"data": "kasa_kodu"},
                {"data": "kasa_adi"},
                {"data": "giren_tutar"},
                {"data": "cikan_tutar"},
                {"data": "bakiye"},
                {"data": "b_durum"},
                {"data": "varsayilan"}
            ],
            "paging": false,
            createdRow: function (row, data, dataIndex) {
                $(row).addClass("kasa_list_selected");
                $(row).find("td").css("text-align", "left");
                $(row).find("td").eq(2).css("text-align", "right")
                $(row).find("td").eq(3).css("text-align", "right")
                $(row).find("td").eq(4).css("text-align", "right")
            },
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });
        $.get("controller/kasa_controller/sql.php?islem=kasalari_getir", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                var basilacak_arr = [];
                let ty = 0;
                let tc = 0;
                let tb = 0;
                json.forEach(function (item) {
                    var kasaKodu = item.kasa_kodu;
                    var kasaAdi = item.kasa_adi;
                    var borc_durumu = "";
                    let yatan = item.giren_tutar;
                    let cekilen = item.cikan_tutar;
                    yatan = parseFloat(yatan);
                    cekilen = parseFloat(cekilen);
                    ty += yatan;
                    tc += cekilen;
                    let bakiye = yatan - cekilen;

                    if (bakiye < 0) {
                        borc_durumu = "A";
                        bakiye = -bakiye;
                    } else if (bakiye == 0) {
                        borc_durumu = "YOk";
                    } else {
                        borc_durumu = "B";
                    }
                    tb += bakiye;
                    yatan = yatan.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    cekilen = cekilen.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    bakiye = bakiye.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    var varsayilan = "";
                    if (item.varsayilan_kasa == 1) {
                        varsayilan = "checked";
                    } else {
                        varsayilan = "";
                    }
                    let newRow = {
                        'kasa_kodu': kasaKodu,
                        'kasa_adi': kasaAdi,
                        'giren_tutar': yatan,
                        'cikan_tutar': cekilen,
                        'bakiye': bakiye,
                        'b_durum': borc_durumu,
                        'varsayilan': '<input type="checkbox" class="col-9" disabled ' + varsayilan + '>'
                    };
                    basilacak_arr.push(newRow);
                })
                $(".toplam_y").html(ty.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) + " TL");
                $(".toplam_c").html(tc.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) + " TL");
                $(".toplam_b").html(tb.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) + " TL");
                table.rows.add(basilacak_arr).draw(false);
            }
        })
    });

    $("body").off("click", "#kasa_tanimla_main_button").on("click", "#kasa_tanimla_main_button", function () {
        $.get("modals/kasa_modal/modal.php", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        });
    });

    $("body").off("click", ".kasa_list_selected").on("click", ".kasa_list_selected", function () {
        $('.kasa_list_selected').css("background-color", "rgb(255, 255, 255)");
        $(this).css("background-color", "#60b3abad");
        $('.kasa_list_selected').removeClass('select');
        $(this).addClass("select");
        $(".select").css("background-color", "#B9EDDD");
    });


    $("body").off("click", "#kasa_sil").on("click", "#kasa_sil", function () {
        var kasa_kodu = $(".select").find("td").first().html();
        if (kasa_kodu == "" || kasa_kodu == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Kasayı seçiniz',
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
                        url: "controller/kasa_controller/sql.php?islem=kasa_sil",
                        type: "POST",
                        data: {
                            kasa_kodu: kasa_kodu,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Kasa Silindi',
                                    'success'
                                );
                                $.get("view/kasa_tanim.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
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
    $("body").off("click", ".kasa_list_selected").on("click", ".kasa_list_selected", function () {
        $('.kasa_list_selected').css("background-color", "rgb(255, 255, 255)");
        $(this).css("background-color", "#60b3abad");
        $('.kasa_list_selected').removeClass('select');
        $(this).addClass("select");
        $(".select").css("background-color", "#B9EDDD");
    });
</script>