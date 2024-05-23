<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>ÇEK AÇILIŞ FİŞİ</div>
    </div>
    <div class="col-12 row mt-3">
        <div class="col-3">
            <div class="btn-group" role="group">
                <button id="btnGroupVerticalDrop1" type="button"
                        class="btn btn-success dropdown-toggle btn-sm" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    Çek Açılış Fişi <i class="fa fa-angle-down arrow"></i>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" id="cek_acilis_ekle_button" href="#">Verdiğimiz Çekler</a>
                    <a class="dropdown-item" id="cek_acilis_verilen_cekler_button" href="#">Aldığımız Çekler</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 row">
        <table class="table table-sm table-bordered w-100  nowrap" id="kart_acilis_table" style="font-size: 13px;">
            <thead>
            <tr>
                <th style="width: 0%">Çek Türü</th>
                <th style="width: 0%">Açılış Tarihi</th>
                <th style="width: 0%">Seri No</th>
                <th style="width: 0%">Tutar</th>
                <th style="width: 0%">Keşide Yeri</th>
                <th style="width: 0%">Banka Adı</th>
                <th style="width: 0%">Asıl Borçlu</th>
                <th style="width: 0%">Ciro Edilmiş</th>
                <th style="width: 0%">Açıklama</th>
                <th style="width: 0%">Vade Tarihi</th>
                <th style="width: 0%">İşlem</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="col-12 row">
        <div class="col-3"></div>
        <div class="col-md-4">
            <table class="table table-sm table-bordered w-100 display nowrap" style="background-color: white">
                <thead>
                <tr>
                    <th style="text-align: center">Verilen Çekler</th>
                    <th style="text-align: center">Alınan Çekler</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="verilen_cek" style="text-align: right;font-weight: bold">0,00 TL</td>
                    <td class="alinan_cek" style="text-align: right;font-weight: bold">0,00 TL</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>

    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });
    $(document).ready(function () {
        var table = $('#kart_acilis_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            bAutoWidth: false,
            columns: [
                {"data": "cek_turu"},
                {"data": "acilis_tarihi"},
                {"data": "seri_no"},
                {"data": "tutar"},
                {"data": "keside_yeri"},
                {"data": "banka_adi"},
                {"data": "asil_borclu"},
                {"data": "ciro_edilen"},
                {"data": "aciklama"},
                {"data": "vade_tarihi"},
                {"data": "button"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).addClass("stok_list_selected");
                $(row).find("td").css("text-align", "left");
                $(row).find("td").eq(3).css("text-align", "right");
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });
        $.get("controller/cek_senet_controller/sql.php?islem=acilis_ceklerini_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                let basilacak_arr = [];
                let alinan_cek = 0;
                let verilen_cek = 0;
                json.forEach(function (item) {
                    if ("kendi_banka" in item) {
                        let tutar = item.tutar;
                        tutar = parseFloat(tutar);
                        verilen_cek += tutar;

                        let acilis_tarih = item.acilis_tarihi;
                        if (acilis_tarih == null) {

                        } else {
                            acilis_tarih = acilis_tarih.split("-");
                            let g = acilis_tarih[2];
                            let a = acilis_tarih[1];
                            let y = acilis_tarih[0];
                            let arr = [g, a, y];
                            acilis_tarih = arr.join("/");
                        }

                        let vade_tarihi = item.vade_tarihi;
                        if (acilis_tarih == null) {

                        } else {
                            vade_tarihi = vade_tarihi.split("-");
                            let g = vade_tarihi[2];
                            let a = vade_tarihi[1];
                            let y = vade_tarihi[0];
                            let arr = [g, a, y];
                            vade_tarihi = arr.join("/");
                        }

                        let newRow = {
                            'cek_turu': "Verilen Çek",
                            'acilis_tarihi': acilis_tarih,
                            'seri_no': item.seri_no,
                            'tutar': tutar.toLocaleString("tr-TR", {
                                maximumFractionDigits: 2,
                                minimumFractionDigits: 2
                            }),
                            'keside_yeri': item.keside_yeri,
                            'banka_adi': item.kendi_banka,
                            'asil_borclu': "",
                            'ciro_edilen': "",
                            'aciklama': item.aciklama,
                            'vade_tarihi': vade_tarihi,
                            'button': "<button class='btn btn-danger btn-sm verilen_cek_sil_button' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>",
                        };
                        basilacak_arr.push(newRow);
                    } else {
                        let tutar = item.tutar;
                        tutar = parseFloat(tutar);
                        alinan_cek += tutar;

                        let acilis_tarih = item.acilis_tarihi;
                        if (acilis_tarih == null) {

                        } else {
                            acilis_tarih = acilis_tarih.split("-");
                            let g = acilis_tarih[2];
                            let a = acilis_tarih[1];
                            let y = acilis_tarih[0];
                            let arr = [g, a, y];
                            acilis_tarih = arr.join("/");
                        }

                        let vade_tarihi = item.vade_tarihi;
                        if (acilis_tarih == null) {

                        } else {
                            vade_tarihi = vade_tarihi.split("-");
                            let g = vade_tarihi[2];
                            let a = vade_tarihi[1];
                            let y = vade_tarihi[0];
                            let arr = [g, a, y];
                            vade_tarihi = arr.join("/");
                        }

                        let newRow = {
                            'cek_turu': "ALINAN ÇEK",
                            'acilis_tarihi': acilis_tarih,
                            'seri_no': item.seri_no,
                            'tutar': tutar.toLocaleString("tr-TR", {
                                maximumFractionDigits: 2,
                                minimumFractionDigits: 2
                            }),
                            'keside_yeri': item.keside_yeri,
                            'banka_adi': item.banka_adi,
                            'asil_borclu': item.asil_borclu,
                            'ciro_edilen': item.ciro_edilmis,
                            'aciklama': item.aciklama,
                            'vade_tarihi': vade_tarihi,
                            'button': "<button class='btn btn-danger btn-sm alinan_cek_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>",
                        };
                        basilacak_arr.push(newRow);
                    }
                })
                $(".verilen_cek").html(verilen_cek.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) + " TL");
                $(".alinan_cek").html(alinan_cek.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) + " TL");
                table.rows.add(basilacak_arr).draw(false);
            }
        })

    });

    $("body").off("click", "#cek_acilis_ekle_button").on("click", "#cek_acilis_ekle_button", function () {
        $.get("modals/cek_senet_modal/cek_acilis_ekle.php?islem=cek_acilis_modal_getir", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", "#cek_acilis_verilen_cekler_button").on("click", "#cek_acilis_verilen_cekler_button", function () {
        $.get("modals/cek_senet_modal/verilen_cek_acilis.php?islem=cek_acilis_verilen_cekler_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".verilen_cek_sil_button").on("click", ".verilen_cek_sil_button", function () {
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
                        url: "controller/cek_senet_controller/sql.php?islem=verilen_cek_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Açılış Fişi Silindi',
                                    'success'
                                );
                                $.get("view/cek_acilis_fisi.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/cek_acilis_fisi.php", function (getList) {
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

    $("body").off("click", ".alinan_cek_sil").on("click", ".alinan_cek_sil", function () {
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
                        url: "controller/cek_senet_controller/sql.php?islem=alinan_cek_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Açılış Fişi Silindi',
                                    'success'
                                );
                                $.get("view/cek_acilis_fisi.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/cek_acilis_fisi.php", function (getList) {
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