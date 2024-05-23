<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>BANKA TANIMLA</div>
    </div>
    <div class="col-12 row">
        <div class="banka_tanim_button mt-3 mx-3">
            <button class="btn btn-success btn-sm" id="banka_tanimla_main_button"><i class="fa fa-plus-square"
                                                                                     aria-hidden="true"></i> Banka
                Ekle
            </button>
            <button class="btn  btn-sm" id="banka_guncelle_main" style="background-color: #F6FA70"><i
                        class="fa fa-refresh" aria-hidden="true"></i> Banka Güncelle
            </button>
            <button class="btn btn-danger btn-sm" id="banka_sil"><i class="fa fa-trash" aria-hidden="true"></i> Banka
                Sil
            </button>
        </div>
        <div class="col-12 row mx-1 mt-3">
            <table class="table table-sm table-bordered w-100  nowrap" id="banka_listesi"
                   style="font-size: 13px;">
                <thead>
                <tr>
                    <th>Banka Kodu</th>
                    <th>Banka Adı</th>
                    <th>Şube Kodu</th>
                    <th>Şube Adı</th>
                    <th>Hesap Adı</th>
                    <th>Hesap No</th>
                    <th>Yatan</th>
                    <th>Çekilen</th>
                    <th>Bakiye</th>
                    <th>B.Durumu</th>
                    <th>Döviz Tipi</th>
                    <th>IBAN No</th>
                    <th>Yetkili Adı</th>
                    <th>Yetkili Mail</th>
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
                        <td class="toplam_y" style="text-align: right;font-weight: bold">0,00</td>
                        <td class="toplam_c" style="text-align: right;font-weight: bold">0,00</td>
                        <td class="toplam_b" style="text-align: right;font-weight: bold">0,00</td>
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
    $("body").off("click", "#banka_guncelle_main").on("click", "#banka_guncelle_main", function () {
        var banka_kodu = $(".select").find("td").first().html();
        if (banka_kodu == "" || banka_kodu == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Bankayı seçiniz',
                'warning'
            );
        } else {
            $.get("modals/banka_modal/modal_page.php?islem=banka_guncelle_modal", {banka_kodu: banka_kodu}, function (getModal) {
                $(".getModals").html("");
                $(".getModals").html(getModal);
            })
        }
    });
    $("body").off("click", ".banka_selected").on("click", ".banka_selected", function () {
        $('.banka_selected').css("background-color", "rgb(255, 255, 255)");
        $(this).css("background-color", "#60b3abad");
        $('.banka_selected').removeClass('select');
        $(this).addClass("select");
        $(".select").css("background-color", "#B9EDDD");
    });

    $(document).ready(function () {
        var table = $('#banka_listesi').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            "paging": false,
            createdRow: function (row, data, dataIndex) {
                $(row).addClass("banka_selected");
            },
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        })
        $.get("controller/banka_controller/sql.php?islem=banka_listesi_getir", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                let ty = 0;
                let tc = 0;
                let tb = 0;
                json.forEach(function (item) {
                    var cekilen = item.cekilen;
                    var yatan = item.yatan;
                    ty += yatan;
                    tc += cekilen;
                    var b_durum = "";

                    cekilen = parseFloat(cekilen);
                    yatan = parseFloat(yatan);
                    if (yatan > cekilen) {
                        b_durum = "B";
                    } else if (yatan === cekilen) {
                        b_durum = "YOK";
                    } else {
                        b_durum = "A";
                    }
                    let bakiye = cekilen - yatan;
                    if (bakiye < 0) {
                        bakiye = -bakiye;
                    }
                    tb += bakiye;
                    bakiye = bakiye.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    cekilen = cekilen.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    yatan = yatan.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    var bankaKodu = item.banka_kodu;
                    var bankaAdi = item.hesap_adi;
                    var subeKodu = item.sube_kodu;
                    var subeAdi = item.sube_adi;
                    var hesapAdi = item.hesap_adi;
                    let new_row = table.row.add([bankaKodu, bankaAdi, subeKodu, subeAdi, hesapAdi,item.hesap_no, yatan, cekilen, bakiye, b_durum,item.doviz_tipi,item.iban_no,item.yetkili_adi,item.yetkili_mail]).draw(false).node();

                    $(new_row).find("td").eq(0).css("text-align", "left");
                    $(new_row).find("td").eq(1).css("text-align", "left");
                    $(new_row).find("td").eq(2).css("text-align", "left");
                    $(new_row).find("td").eq(3).css("text-align", "left");
                    $(new_row).find("td").eq(4).css("text-align", "left");
                    $(new_row).find("td").eq(5).css("text-align", "left");
                    $(new_row).find("td").eq(9).css("text-align", "left");
                    $(new_row).find("td").eq(10).css("text-align", "left");
                    $(new_row).find("td").eq(11).css("text-align", "left");
                    $(new_row).find("td").eq(12).css("text-align", "left");
                    $(new_row).find("td").eq(13).css("text-align", "left");
                });
                $(".toplam_y").html(ty.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }));
                $(".toplam_c").html(tc.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }));
                $(".toplam_b").html(tb.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }));
            }
        })
    })

    $("body").off("click", "#banka_tanimla_main_button").on("click", "#banka_tanimla_main_button", function () {
        $.get("modals/banka_modal/modal.php?islem=yeni_banka_tanimla", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        });
    });
    $("body").off("click", "#banka_sil").on("click", "#banka_sil", function () {
        var banka_kodu = $(".select").find("td").first().html();
        if (banka_kodu == "" || banka_kodu == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Bankayı seçiniz',
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
                        url: "controller/banka_controller/sql.php?islem=banka_sil",
                        type: "POST",
                        data: {
                            banka_kodu: banka_kodu,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Banka Silindi',
                                    'success'
                                );
                                $.get("view/banka_tanim.php", function (getList) {
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
    });

</script>