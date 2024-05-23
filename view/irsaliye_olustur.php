<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>ALIŞ İRSALİYESİ</div>
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
            <div class="col-md-3 mx-1 row">
                <select class="custom-select custom-select-sm" id="fatura_durumu">
                    <option value="">Hepsi</option>
                    <option value="1">Faturası Gelmeyenler</option>
                    <option value="2">Faturalandı</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-12 row">
        <table class="table table-sm table-bordered w-100  nowrap datatable"
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
            <tfoot style="background-color: white">
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th style="text-align: right" class="alis_i_tl_tot">0,00</th>
            <th></th>
            <th></th>
            <th></th>
            <th style="text-align: right" class="alis_i_doviz_tot">0,00</th>
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

    $("body").off("click", "#alis_irsaliye_olustur_main").on("click", "#alis_irsaliye_olustur_main", function () {
        $.get("modals/alis_modal/irsaliye_modal.php?islem=irsaliye_ekle_modal", function (getModal) {
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
                {"data": "irsaliye_no"},
                {"data": "irsaliye_tarih"},
                {"data": "cari_kodu"},
                {"data": "cari_adi"},
                {"data": "depo"},
                {"data": "durum"},
                {"data": "tl_tutar"},
                {"data": "doviz_tipi"},
                {"data": "doviz_kuru"},
                {"data": "aciklama"},
                {"data": "tutar"},
                {"data": "islem"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find("td").css("text-transform", "uppercase");
                if (data.status != 1) {
                    $(row).find("td").css('background-color', '#E5F9DB');
                } else {
                    //FF0303
                    $(row).find("td").css('background-color', '#F15A59');
                    $(row).css('color', 'white');
                }

                $(row).find('td').eq(0).css('text-align', 'left');
                $(row).find('td').eq(1).css('text-align', 'left');
                $(row).find('td').eq(2).css('text-align', 'left');
                $(row).find('td').eq(3).css('text-align', 'left');
                $(row).find('td').eq(4).css('text-align', 'left');
                $(row).find('td').eq(5).css('text-align', 'left');
                $(row).find('td').eq(7).css('text-align', 'left');
                $(row).find('td').eq(9).css('text-align', 'left');

            },
            // "rowCallback": function (row) {
            //     $(row).children().css('background-color', '#FFEEB3');
            // },
            order: [[1, 'desc']],
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"
            },
        });

        $("body").off("click", "#alis_irsaliye_filtrele").on("click", "#alis_irsaliye_filtrele", function () {
            var bas_tarih = $("#bas_tarih").val();
            var bit_tarih = $("#bit_tarih").val();
            var fatura_durumu = $("#fatura_durumu").val();

            $.get("controller/alis_controller/sql.php?islem=alis_irsaliye_filtrele", {
                bas_tarih: bas_tarih,
                bit_tarih: bit_tarih,
                fatura_durumu: fatura_durumu
            }, function (result) {
                let alis_i_tl_tot = 0;
                let alis_i_doviz_tot = 0;
                if (result != 2) {
                    var json = JSON.parse(result)
                    table.clear().draw(false);
                    var basilacak_arr = [];
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
                        alis_i_doviz_tot += parse_toplam;
                        var doviz_kuru = item.kur_fiyat;
                        var tl_karsilik = doviz_kuru * toplam_tutar;
                        alis_i_tl_tot += tl_karsilik;
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
                            irsaliye_tarih: irsaliye_tarihi,
                            cari_kodu: item.cari_kodu,
                            cari_adi: item.cari_adi,
                            depo: item.depo_adi,
                            durum: durum,
                            tl_tutar: tl_karsilik + " TL",
                            doviz_tipi: item.doviz_tur,
                            doviz_kuru: item.kur_fiyat,
                            aciklama: item.aciklama,
                            tutar: toplam_tutar + " " + item.doviz_tur,
                            islem: "<button class='btn  btn-sm irsaliye_goruntule_main' data-id='" + item.id + "' style='background-color: #F6FA70'><i class='fa fa-eye'></i></button> <button class='btn btn-danger btn-sm irsaliye_sil_main' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>",
                            status: item.status
                        };
                        basilacak_arr.push(newRow);
                    })
                    $(".alis_i_tl_tot").html(alis_i_tl_tot.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }) + " TL")
                    $(".alis_i_doviz_tot").html(alis_i_doviz_tot.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }) + " TL")
                    table.rows.add(basilacak_arr).draw(false);
                } else {
                    $(".alis_i_tl_tot").html(alis_i_tl_tot.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }) + " TL")
                    $(".alis_i_doviz_tot").html(alis_i_doviz_tot.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }) + " TL")
                    table.clear().draw(false);
                }
            })
        });

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
                            url: "controller/alis_controller/sql.php?islem=irsaliye_sil_sql",
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
                                    $.get("view/irsaliye_olustur.php", function (getList) {
                                        $(".modal-icerik").html("");
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("view/irsaliye_olustur.php", function (getList) {
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

        $.get("controller/alis_controller/sql.php?islem=alis_irsaliyelerini_getir", function (result) {
            if (result != 2) {
                var json = JSON.parse(result)
                var basilacak_arr = [];
                let alis_i_tl_tot = 0;
                let alis_i_doviz_tot = 0;
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
                    alis_i_doviz_tot += parse_toplam;
                    var doviz_kuru = item.kur_fiyat;
                    var tl_karsilik = doviz_kuru * toplam_tutar;
                    alis_i_tl_tot += tl_karsilik;
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
                        irsaliye_tarih: irsaliye_tarihi,
                        cari_kodu: item.cari_kodu,
                        cari_adi: item.cari_adi,
                        depo: item.depo_adi,
                        durum: durum,
                        tl_tutar: tl_karsilik + " TL",
                        doviz_tipi: item.doviz_tur,
                        doviz_kuru: item.kur_fiyat,
                        aciklama: item.aciklama,
                        tutar: toplam_tutar + " " + item.doviz_tur,
                        islem: "<button class='btn  btn-sm irsaliye_goruntule_main' data-id='" + item.id + "' style='background-color: #F6FA70'><i class='fa fa-eye'></i></button> <button class='btn btn-danger btn-sm irsaliye_sil_main' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>",
                        status: item.status
                    };
                    basilacak_arr.push(newRow);
                })
                $(".alis_i_tl_tot").html(alis_i_tl_tot.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) + " TL")
                $(".alis_i_doviz_tot").html(alis_i_doviz_tot.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }) + " TL")
                table.rows.add(basilacak_arr).draw(false);
            }
        })
    });

    $("body").off("click", ".irsaliye_goruntule_main").on("click", ".irsaliye_goruntule_main", function () {
        var id = $(this).attr("data-id");
        $.get("modals/alis_modal/alis_irsaliye_page.php?islem=olusan_irsaliye_goruntule_modal", {id: id}, function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    })
</script>