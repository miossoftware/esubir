<style>
    .excel_alis {
        background-color: #2ecc71 !important;
        border-color: #27ad60 !important;
        color: white !important;
        border-radius: 20px !important;
        font-weight: bold !important;
    }
</style>
<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>SATIŞ İRSALİYE</div>
    </div>
    <div class="mx-4 mt-3">
        <button class="btn btn-success btn-sm" id="alis_irsaliye_olustur_main"><i class="fa fa-plus"></i>
            İrsaliye
            Oluştur
        </button>
        <button class="btn btn-info btn-sm" id="alis_irsaliye_filtrele"><i
                    class="fa fa-filter"></i> Filtrele
        </button>
    </div>
    <div class="col-12 row">
        <div class="col-12 row mx-1 mt-3">
            <div class="col-md-3 row">

                <input type="text" placeholder="Başlangıç Tarihi" id="bas_tarih" onfocus="(this.type='date')"
                       class="form-control form-control-sm bas_tarih_alis">
                <input type="text" placeholder="Bitiş Tarihi" id="bit_tarih" onfocus="(this.type='date')"
                       class="form-control form-control-sm mt-2 bit_tarih_alis">
            </div>
        </div>
    </div>
    <div class="col-12 row mt-5">
        <table class="table table-sm table-bordered w-100 display nowrap datatable"
               style="cursor:pointer;font-size: 13px;"
               id="alis_irsaliye_table">
            <thead>
            <tr>
                <th>İrsaliye No</th>
                <th>İrsaliye Tarihi</th>
                <th>Cari Kodu</th>
                <th>Firma Adı</th>
                <th>Depo</th>
                <th>Durumu</th>
                <th>TL Tutar</th>
                <th>Döviz Tipi</th>
                <th>Döviz Kuru</th>
                <th>Açıklama</th>
                <th>Tutar</th>
                <th>İşlem</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<script>

    $("body").off("click", "#alis_irsaliye_olustur_main").on("click", "#alis_irsaliye_olustur_main", function () {
        $.get("modals/satis_modal/irsaliye_modal.php?islem=irsaliye_ekle_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        });
    });

    $(document).ready(function () {
        $.extend($.fn.dataTableExt.oSort, {
            "date-eu-pre": function (dateString) {
                var dateArray = dateString.split('/');
                var formattedDate = dateArray[2] + '-' + dateArray[1] + '-' + dateArray[0];
                return Date.parse(formattedDate) || 0;
            },

            "date-eu-asc": function (a, b) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },

            "date-eu-desc": function (a, b) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        });
        var table = $('#alis_irsaliye_table').DataTable({
            scrollX: true,
            scrollY: '50vh',
            "paging": false,
            columnDefs: [
                {targets: 1, type: "date-eu"}
            ],
            columns: [
                {'data': 'irsaliye_no'},
                {'data': 'irsaliye_tarihi'},
                {'data': 'cari_kodu'},
                {'data': 'cari_adi'},
                {'data': 'depo_adi'},
                {'data': 'durum'},
                {'data': 'tl_karsilik'},
                {'data': 'doviz_tur'},
                {'data': 'kur_fiyat'},
                {'data': 'aciklama'},
                {'data': 'toplam_tutar'},
                {'data': 'islem'}
            ],
            order: [[1, 'desc']],
            createdRow: function (row, data) {
                $(row).find('td').eq(0).css('text-align', 'left');
                $(row).find('td').eq(1).css('text-align', 'left');
                $(row).find('td').eq(2).css('text-align', 'left');
                $(row).find('td').eq(3).css('text-align', 'left');
                $(row).find('td').eq(4).css('text-align', 'left');
                $(row).find('td').eq(5).css('text-align', 'left');
                $(row).find('td').eq(7).css('text-align', 'left');
                $(row).find('td').eq(9).css('text-align', 'left');
                if (data.status != 1) {
                    $(row).css('background-color', '#E5F9DB');
                    $(row).find('td').css('background-color', '#E5F9DB');
                } else {
                    //FF0303
                    $(row).css('background-color', '#F15A59');
                    $(row).css('color', 'white');
                    $(row).find('td').css('background-color', '#F15A59');
                    // $(new_row).css('font-weight', 'bold');
                }
            },
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"
            }
        });
        $.get("controller/satis_controller/sql.php?islem=satis_irsaliyelerini_getir", function (result) {
            if (result != 2) {
                var json = JSON.parse(result)
                let basilacak_arr = [];
                json.forEach(function (item) {
                    var irsaliyeTarihi = item.irsaliye_tarihi;

                    var irsaliye_tarihi = "";
                    if (irsaliyeTarihi != null){

                        var explode_irsaliye = irsaliyeTarihi.split(" ");
                        var irsaliye_cikti1 = explode_irsaliye[0];
                        var explode_irsaliye2 = irsaliye_cikti1.split("-");
                        var gun = explode_irsaliye2[2];
                        var ay = explode_irsaliye2[1];
                        var yil = explode_irsaliye2[0];
                        var arr = [gun, ay, yil];
                        irsaliye_tarihi = arr.join("/");
                    }

                    var toplam_tutar = item.genel_toplam;
                    var parse_toplam = parseFloat(toplam_tutar);
                    var doviz_kuru = item.kur_fiyat;
                    var tl_karsilik = doviz_kuru * toplam_tutar;
                    toplam_tutar = parse_toplam.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    tl_karsilik = tl_karsilik.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    var durum = "";
                    if (item.status == 1) {
                        durum = "İrsaliye Oluşturuldu";
                    } else {
                        durum = "İrsaliye Faturalandı";
                    }
                    let newRow = {
                        irsaliye_no: item.irsaliye_no,
                        irsaliye_tarihi: irsaliye_tarihi,
                        cari_kodu: item.cari_kodu,
                        cari_adi: item.cari_adi,
                        depo_adi: item.depo_adi,
                        durum: durum,
                        tl_karsilik: tl_karsilik + " TL",
                        doviz_tur: item.doviz_tur,
                        kur_fiyat: item.kur_fiyat,
                        aciklama: item.aciklama,
                        toplam_tutar: toplam_tutar + " " + item.doviz_tur,
                        status: item.status,
                        id: item.id,
                        islem: "<button style='background-color: #F6FA70' class='btn btn-sm irsaliye_goruntule_main' data-id='" + item.id + "'><i class='fa fa-eye'></i></button> <button class='btn btn-danger btn-sm irsaliye_sil_main' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                    };
                    basilacak_arr.push(newRow);
                })
                table.rows.add(basilacak_arr).draw(false);
            }
        })
        $("body").off("click", ".irsaliye_sil_main").on("click", ".irsaliye_sil_main", function () {
            var id = $(this).attr("data-id");
            let closest = $(this).closest("tr");
            let durum = $(closest).find("td").eq(5).text();
            if (id == "" || id == undefined) {
                Swal.fire(
                    'Uyarı!',
                    'Lütfen İşlem Yapmak İstediğiniz Kaydı seçiniz',
                    'warning'
                );
            } else if (durum == "İrsaliye Faturalandı") {
                Swal.fire(
                    'Uyarı!',
                    'İrsaliye Faturalandırılmış Öncelikle Faturayı Silmeniz Gerekmektedir',
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
                            url: "controller/satis_controller/sql.php?islem=irsaliye_sil_sql",
                            type: "POST",
                            data: {
                                id: id,
                                delete_detail: delete_detail
                            },
                            success: function (result) {
                                if (result != 2) {
                                    Swal.fire(
                                        'Başarılı!',
                                        'İrsaliye Silindi',
                                        'success'
                                    );
                                    $.get("view/satis_irsaliye.php", function (getList) {
                                        $(".modal-icerik").html("");
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("view/satis_irsaliye.php", function (getList) {
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
        $("body").off("click", "#alis_irsaliye_filtrele").on("click", "#alis_irsaliye_filtrele", function () {
            var bas_tarih = $("#bas_tarih").val();
            var bit_tarih = $("#bit_tarih").val();

            $.get("controller/satis_controller/sql.php?islem=alis_irsaliye_filtrele", {
                bas_tarih: bas_tarih,
                bit_tarih: bit_tarih
            }, function (result) {
                if (result != 2) {
                    var json = JSON.parse(result)
                    table.clear().draw(false);
                    json.forEach(function (item) {
                        var irsaliyeTarihi = item.irsaliye_tarihi;
                        var explode_irsaliye = irsaliyeTarihi.split(" ");
                        var irsaliye_cikti1 = explode_irsaliye[0];
                        var explode_irsaliye2 = irsaliye_cikti1.split("-");
                        var gun = explode_irsaliye2[2];
                        var ay = explode_irsaliye2[1];
                        var yil = explode_irsaliye2[0];
                        var arr = [gun, ay, yil];
                        var irsaliye_tarihi = arr.join("/");

                        var toplam_tutar = item.genel_toplam;
                        var parse_toplam = parseFloat(toplam_tutar);
                        var doviz_kuru = item.kur_fiyat;
                        var tl_karsilik = doviz_kuru * toplam_tutar;
                        toplam_tutar = parse_toplam.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        tl_karsilik = tl_karsilik.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                        var durum = "";
                        if (item.status == 1) {
                            durum = "İrsaliye Oluşturuldu";
                        } else {
                            durum = "İrsaliye Faturalandı";
                        }

                        var new_row = table.row.add([item.irsaliye_no, irsaliye_tarihi, (item.cari_kodu).toUpperCase(), (item.cari_adi).toUpperCase(), (item.depo_adi).toUpperCase(), durum, tl_karsilik + " TL", item.doviz_tur, item.kur_fiyat, (item.aciklama).toUpperCase(), toplam_tutar + " " + item.doviz_tur, "<button style='background-color: #F6FA70' class='btn btn-sm irsaliye_goruntule_main' data-id='" + item.id + "'><i class='fa fa-eye'></i></button> <button class='btn btn-danger btn-sm irsaliye_sil_main' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                        $(new_row).find('td').eq(0).css('text-align', 'left');
                        $(new_row).find('td').eq(1).css('text-align', 'left');
                        $(new_row).find('td').eq(2).css('text-align', 'left');
                        $(new_row).find('td').eq(3).css('text-align', 'left');
                        $(new_row).find('td').eq(4).css('text-align', 'left');
                        $(new_row).find('td').eq(5).css('text-align', 'left');
                        $(new_row).find('td').eq(7).css('text-align', 'left');
                        $(new_row).find('td').eq(9).css('text-align', 'left');
                        if (item.status != 1) {
                            $(new_row).css('background-color', '#E5F9DB');
                            $(new_row).find('td:eq(1)').css('background-color', '#E5F9DB');
                        } else {
                            //FF0303
                            $(new_row).css('background-color', '#F15A59');
                            $(new_row).css('color', 'white');
                            $(new_row).find('td:eq(1)').css('background-color', '#F15A59');
                            // $(new_row).css('font-weight', 'bold');
                        }
                    })
                } else {
                    table.clear().draw(false);
                }
            })
        });
    });


    $("body").off("click", ".irsaliye_goruntule_main").on("click", ".irsaliye_goruntule_main", function () {
        var id = $(this).attr("data-id");
        let closest = $(this).closest("tr");
        let durum = $(closest).find("td").eq(5).text();
        if (durum == "İrsaliye Faturalandı") {
            Swal.fire(
                'Uyarı!',
                'İrsaliye Faturalandırılmış Öncelikle Faturayı Silmeniz Gerekmektedir',
                'warning'
            );
        } else {
            $.get("modals/satis_modal/satis_irsaliye_page.php?islem=olusan_irsaliye_goruntule_modal", {id: id}, function (getModal) {
                $(".getModals").html("");
                $(".getModals").html(getModal);
            })
        }
    })
</script>