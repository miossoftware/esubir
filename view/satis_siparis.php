<style>
    #verilen_siparis_tablo_wrapper .dataTables_filter {
        display: none !important;
    }

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
        <div class="ibox-title" style=' font-weight:bold;'>SATIŞ SİPARİŞ</div>
    </div>
    <div class="col-md-12 row">
        <div class="verilen_siparis_buttons mx-2 mt-3">
            <button class="btn btn-success btn-sm" id="alinan_siparis_olustur_main"><i class="fa fa-plus"></i> Sipariş
                Oluştur
            </button>
            <button class="btn btn-info btn-sm btn-group-toggle" id="siparis_filtrele"
                    style="width: 7% !important;"><i
                        class="fa fa-filter"></i> Filtrele
            </button>
            <div class="col-md-3 row mt-2">
                <input type="text" placeholder="Başlangıç Tarihi" id="bas_tarih" onfocus="(this.type='date')"
                       class="form-control form-control-sm">
                <input type="text" placeholder="Bitiş Tarihi" id="bit_tarih" onfocus="(this.type='date')"
                       class="form-control form-control-sm mt-2">
                <select class="custom-select custom-select-sm mt-1" id="siparis_durumu">
                    <option value="">Sipariş Durumu</option>
                    <option value="0">Hepsi</option>
                    <option value="2">İrsaliyelendi</option>
                    <option value="1">Sipariş Oluşturuldu</option>
                </select>
            </div>
        </div>

        <div class="col-md-12 row mt-3">
            <table class="table table-sm table-bordered w-100  nowrap"
                   style="cursor:pointer;font-size: 13px;"
                   id="verilen_siparis_tablo">
                <thead>
                <tr>
                    <th>Sipariş No</th>
                    <th>Sipariş Tarihi</th>
                    <th>Termin Tarihi</th>
                    <th>Cari</th>
                    <th>Depo</th>
                    <th>Durumu</th>
                    <th>TL Tutar</th>
                    <th>Doviz Türü</th>
                    <th>Doviz Kuru</th>
                    <th>Açıklama</th>
                    <th>Tutar</th>
                    <th>İşlem</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="col-12 row mt-2 no-gutters">
        <div class="col-4"></div>
        <div class="col-md-1">
            <table class="table table-sm table-bordered display" style="background-color: white">
                <tr>
                    <th>Döviz Türü</th>
                </tr>
                <tr>
                    <th>TL</th>
                </tr>
                <tr id="usd_gorunum">
                    <th>USD</th>
                </tr>
                <tr id="euro_gorunum">
                    <th>EURO</th>
                </tr>
                <tr id="gbp_gorunum">
                    <th>GBP</th>
                </tr>
            </table>
        </div>
        <div class="col-md-2">
            <table class="table table-sm table-bordered w-100 display nowrap" style="background-color: white">
                <thead>
                <tr>
                    <th style="text-align: center">Genel Toplam</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="genel_toplam_tl_siparis" style="text-align: right;font-weight: bold">0,00 TL</td>
                </tr>
                <tr>
                    <td class="genel_toplam_usd_siparis" style="text-align: right;font-weight: bold">0,00 USD</td>
                </tr>
                <tr>
                    <td class="genel_toplam_euro_siparis" style="text-align: right;font-weight: bold">0,00 EURO</td>
                </tr>
                <tr>
                    <td class="genel_toplam_gbp_siparis" style="text-align: right;font-weight: bold">0,00 GBP</td>
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
        var table = $('#verilen_siparis_tablo').DataTable({
            scrollX: true,
            scrollY: '50vh',
            "info": false,
            // dom: 'Bfrtip',
            // buttons: [
            //     {
            //         extend: 'excel',
            //         title: "ALINAN SİPARİŞ LİSTESİ",
            //         text: "<i class='fa fa-download'></i> Excel'e Aktar",
            //         className: 'excel_alis', // Sınıfı burada tanımlayabilirsiniz
            //         customizeData: function (excelData) {
            //             // Özel veri dönüşümü ve formatlamaları yapabilirsiniz
            //             // excelData, dışa aktarılacak Excel verilerini temsil eder
            //
            //             // Örneğin, her hücreyi sayı olarak biçimlendirme
            //             for (var rowIdx = 0; rowIdx < excelData.body.length; rowIdx++) {
            //                 var rowData = excelData.body[rowIdx];
            //                 for (var cellIdx = 0; cellIdx < rowData.length; cellIdx++) {
            //                     var cellValue = excelData.body[rowIdx][cellIdx];
            //                     if (typeof cellValue === 'string') {
            //                         if (targetColumns.includes(cellIdx)) {
            //                             var parsedValue = parseFloat(cellValue.replace('.', '').replace(',', '.').replace(/\s/g, ''));
            //                             if (!isNaN(parsedValue)) {
            //                                 excelData.body[rowIdx][cellIdx] = parsedValue.toLocaleString("en-US", {
            //                                     maximumFractionDigits: 2,
            //                                     minimumFractionDigits: 2
            //                                 });
            //                             }
            //                         }
            //                     }
            //                 }
            //             }
            //         }
            //     }
            // ],
            createdRow: function (row, data, dataIndex) {
            },
            "rowCallback": function (row) {
                $(row).children().css('background-color', '#F9F3DF');
            },
            order: [[1, 'desc']],
            columnDefs: [
                {targets: 1, type: "date-eu"}
            ],
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        var tl_karsilik_bas_main = 0;
        var usd_karsilik_bas_main = 0;
        var eur_karsilik_bas_main = 0;
        var gbp_karsilik_bas_main = 0;
        $("body").off("click", "#siparis_filtrele").on("click", "#siparis_filtrele", function () {
            var bas_tarih = $("#bas_tarih").val();
            var bit_tarih = $("#bit_tarih").val();
            var siparis_durumu = $("#siparis_durumu").val();

            tl_karsilik_bas_main = 0;
            usd_karsilik_bas_main = 0;
            eur_karsilik_bas_main = 0;
            gbp_karsilik_bas_main = 0;
            if (bas_tarih > bit_tarih) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                Toast.fire({
                    icon: 'warning',
                    title: 'Bitiş Tarihi Başlangıç Tarihinden Küçük Olamaz'
                });
            } else {
                $.get("controller/satis_controller/sql.php?islem=satis_siparis_filtrele_main", {
                    bas_tarih: bas_tarih,
                    bit_tarih: bit_tarih,
                    siparis_durumu: siparis_durumu
                }, function (result) {
                    if (result != 2) {
                        var toplam_tutar = 0;
                        var toplam_siparis = 0;
                        var json = JSON.parse(result);
                        table.clear().draw(false);
                        var tl_karsilik_main = "";
                        var usd_karsilik_main = "";
                        var eur_karsilik_main = "";
                        var gbp_karsilik_main = "";
                        json.forEach(function (item) {
                            toplam_siparis += 1;
                            var siparisTarihi = item.siparis_tarihi;
                            var siparis_tarihi_explode = siparisTarihi.split(" ");
                            var explode_cikti3 = siparis_tarihi_explode[0];
                            var explode4 = explode_cikti3.split("-");
                            var gun1 = explode4[2];
                            var ay1 = explode4[1];
                            var yil1 = explode4[0];
                            var arr1 = [gun1, ay1, yil1];
                            var siparis_tarihi = arr1.join("/");

                            var terminTarihi = item.termin_tarihi;
                            var termin_tarihi_exlplode = terminTarihi.split(" ");
                            var explode_cikti1 = termin_tarihi_exlplode[0];
                            var explode2 = explode_cikti1.split("-");
                            var gun = explode2[2];
                            var ay = explode2[1];
                            var yil = explode2[0];
                            var arr = [gun, ay, yil];
                            var termin_tarihi = arr.join("/");

                            var genelToplam = item.genel_toplam;
                            var parse_genel_toplam = parseFloat(genelToplam);
                            var genel_toplam = parse_genel_toplam.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });


                            toplam_tutar += parse_genel_toplam;

                            var durum = "";
                            var aciklama = "";
                            if (item.status == 2) {
                                durum = "İrsaliyelendi"
                                aciklama = item.aciklama;
                            } else if (item.status == 3) {
                                durum = "İptal Edildi";
                                aciklama = item.delete_detail;
                            } else {
                                durum = "Sipariş Oluşturuldu";
                                aciklama = item.aciklama;
                            }
                            var genel_parse = parseFloat(item.genel_toplam);
                            var kur_fiyat_parse = parseFloat(item.kur_fiyat);
                            var tl_karsiligi = kur_fiyat_parse * genel_parse;
                            var tl_karsilik_bas = tl_karsiligi.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })


                            tl_karsilik_bas_main += tl_karsiligi;
                            tl_karsilik_main = tl_karsilik_bas_main.toLocaleString("tr-TR", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });

                            if (item.doviz_tur == "EURO") {
                                eur_karsilik_bas_main += genel_parse;
                                eur_karsilik_main = eur_karsilik_bas_main.toLocaleString("tr-TR", {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            } else if (item.doviz_tur == "USD") {
                                usd_karsilik_bas_main += genel_parse;
                                usd_karsilik_main = usd_karsilik_bas_main.toLocaleString("tr-TR", {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            } else if (item.doviz_tur == "GBP") {
                                gbp_karsilik_bas_main += genel_parse;
                                gbp_karsilik_main = gbp_karsilik_bas_main.toLocaleString("tr-TR", {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            }

                            $(".genel_toplam_tl_siparis").html("");
                            $(".genel_toplam_tl_siparis").html(tl_karsilik_main + " TL");
                            $(".genel_toplam_usd_siparis").html("");
                            $(".genel_toplam_usd_siparis").html(usd_karsilik_main + " USD");
                            $(".genel_toplam_euro_siparis").html("");
                            $(".genel_toplam_euro_siparis").html(eur_karsilik_main + " EURO");
                            $(".genel_toplam_gbp_siparis").html("");
                            $(".genel_toplam_gbp_siparis").html(gbp_karsilik_main + " GBP");
                            var new_row = table.row.add([item.siparis_no, siparis_tarihi, termin_tarihi, item.cari_adi, item.depo_adi, durum, tl_karsilik_bas + " TL", item.doviz_tur, item.kur_fiyat, aciklama.toUpperCase(), genel_toplam + " " + item.doviz_tur, "<button style='background-color: #F6FA70' class='btn btn-sm siparis_duzenle_button' data-id='" + item.id + "'><i class='fa fa-eye'></i></button>  <button class='btn btn-danger btn-sm siparis_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button> <button class='btn btn-danger btn-sm siparisi_iptal_et' data-id='" + item.id + "'><i class='	fa fa-close'></i> İptal Et</button>"]).draw(false).node();
                            $(new_row).find('td').eq(0).css('text-align', 'left');
                            $(new_row).find('td').eq(1).css('text-align', 'left');
                            $(new_row).find('td').eq(2).css('text-align', 'left');
                            $(new_row).find('td').eq(3).css('text-align', 'left');
                            $(new_row).find('td').eq(4).css('text-align', 'left');
                            $(new_row).find('td').eq(5).css('text-align', 'left');
                            $(new_row).find('td').eq(6).css('text-align', 'left');
                            $(new_row).find('td').eq(7).css('text-align', 'left');
                        });
                        if (usd_karsilik_bas_main == 0) {
                            $(".genel_toplam_usd_siparis").hide();
                            $("#usd_gorunum").hide();
                        } else {
                            $(".genel_toplam_usd_siparis").show();
                            $("#usd_gorunum").show();
                        }
                        if (eur_karsilik_bas_main == 0) {
                            $(".genel_toplam_euro_siparis").hide();
                            $("#euro_gorunum").hide();
                        } else {
                            $(".genel_toplam_euro_siparis").show();
                            $("#euro_gorunum").show();
                        }
                        if (gbp_karsilik_bas_main == 0) {
                            $(".genel_toplam_gbp_siparis").hide();
                            $("#gbp_gorunum").hide();
                        } else {
                            $(".genel_toplam_gbp_siparis").show();
                            $("#gbp_gorunum").show();
                        }
                    } else {
                        table.clear().draw(false);
                        $(".genel_toplam_tl_siparis").html("");
                        $(".genel_toplam_tl_siparis").html("0,00 TL");
                        $(".genel_toplam_gbp_siparis").hide();
                        $("#gbp_gorunum").hide();
                        $(".genel_toplam_euro_siparis").hide();
                        $("#euro_gorunum").hide();
                        $(".genel_toplam_usd_siparis").hide();
                        $("#usd_gorunum").hide();
                    }
                })
            }
        });
        $.get("controller/satis_controller/sql.php?islem=alinan_siparisleri_getir_sql", function (result) {
            if (result != 2) {
                var toplam_tutar = 0;
                var toplam_siparis = 0;
                var json = JSON.parse(result);
                table.clear().draw(false);
                var tl_karsilik_main = "";
                var usd_karsilik_main = "";
                var eur_karsilik_main = "";
                var gbp_karsilik_main = "";
                json.forEach(function (item) {
                    toplam_siparis += 1;
                    var siparisTarihi = item.siparis_tarihi;
                    var siparis_tarihi_explode = siparisTarihi.split(" ");
                    var explode_cikti3 = siparis_tarihi_explode[0];
                    var explode4 = explode_cikti3.split("-");
                    var gun1 = explode4[2];
                    var ay1 = explode4[1];
                    var yil1 = explode4[0];
                    var arr1 = [gun1, ay1, yil1];
                    var siparis_tarihi = arr1.join("/");

                    var terminTarihi = item.termin_tarihi;
                    var termin_tarihi_exlplode = terminTarihi.split(" ");
                    var explode_cikti1 = termin_tarihi_exlplode[0];
                    var explode2 = explode_cikti1.split("-");
                    var gun = explode2[2];
                    var ay = explode2[1];
                    var yil = explode2[0];
                    var arr = [gun, ay, yil];
                    var termin_tarihi = arr.join("/");

                    var genelToplam = item.genel_toplam;
                    var parse_genel_toplam = parseFloat(genelToplam);
                    var genel_toplam = parse_genel_toplam.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });


                    toplam_tutar += parse_genel_toplam;

                    var durum = "";
                    var aciklama = "";
                    if (item.status == 0) {
                        durum = "İrsaliyelendi"
                        aciklama = item.aciklama;
                    } else if (item.status == 3) {
                        durum = "İptal Edildi";
                        aciklama = item.delete_detail;
                    } else {
                        durum = "Sipariş Oluşturuldu";
                        aciklama = item.aciklama;
                    }

                    var genel_parse = parseFloat(item.genel_toplam);
                    var kur_fiyat_parse = parseFloat(item.kur_fiyat);
                    var tl_karsiligi = kur_fiyat_parse * genel_parse;
                    var tl_karsilik_bas = tl_karsiligi.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    })

                    tl_karsilik_bas_main += tl_karsiligi;
                    tl_karsilik_main = tl_karsilik_bas_main.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    if (item.doviz_tur == "EURO") {
                        eur_karsilik_bas_main += genel_parse;
                        eur_karsilik_main = eur_karsilik_bas_main.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    } else if (item.doviz_tur == "USD") {
                        usd_karsilik_bas_main += genel_parse;
                        usd_karsilik_main = usd_karsilik_bas_main.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    } else if (item.doviz_tur == "GBP") {
                        gbp_karsilik_bas_main += genel_parse;
                        gbp_karsilik_main = gbp_karsilik_bas_main.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    }
                    $(".genel_toplam_tl_siparis").html("");
                    $(".genel_toplam_tl_siparis").html(tl_karsilik_main + " TL");
                    $(".genel_toplam_usd_siparis").html("");
                    $(".genel_toplam_usd_siparis").html(usd_karsilik_main + " USD");
                    $(".genel_toplam_euro_siparis").html("");
                    $(".genel_toplam_euro_siparis").html(eur_karsilik_main + " EURO");
                    $(".genel_toplam_gbp_siparis").html("");
                    $(".genel_toplam_gbp_siparis").html(gbp_karsilik_main + " GBP");

                    var new_row = table.row.add([item.siparis_no, siparis_tarihi, termin_tarihi, item.cari_adi, item.depo_adi, durum, tl_karsilik_bas + " TL", item.doviz_tur, item.kur_fiyat, aciklama.toUpperCase(), genel_toplam + " " + item.doviz_tur, "<button style='background-color: #F6FA70' class='btn btn-sm siparis_duzenle_button' data-id='" + item.id + "'><i class='fa fa-eye'></i></button>  <button class='btn btn-danger btn-sm siparis_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button> <button class='btn btn-danger btn-sm siparisi_iptal_et' data-id='" + item.id + "'><i class='	fa fa-close'></i> İptal Et</button>"]).draw(false).node();
                    $(new_row).find('td').eq(0).css('text-align', 'left');
                    $(new_row).find('td').eq(1).css('text-align', 'left');
                    $(new_row).find('td').eq(2).css('text-align', 'left');
                    $(new_row).find('td').eq(3).css('text-align', 'left');
                    $(new_row).find('td').eq(4).css('text-align', 'left');
                    $(new_row).find('td').eq(5).css('text-align', 'left');
                    $(new_row).find('td').eq(6).css('text-align', 'left');
                    $(new_row).find('td').eq(7).css('text-align', 'left');
                });
                if (usd_karsilik_bas_main == 0) {
                    $(".genel_toplam_usd_siparis").hide();
                    $("#usd_gorunum").hide();
                }
                if (eur_karsilik_bas_main == 0) {
                    $(".genel_toplam_euro_siparis").hide();
                    $("#euro_gorunum").hide();
                }
                if (gbp_karsilik_bas_main == 0) {
                    $(".genel_toplam_gbp_siparis").hide();
                    $("#gbp_gorunum").hide();
                }
            } else {
                $(".genel_toplam_tl_siparis").html("");
                $(".genel_toplam_tl_siparis").html("0,00 TL");
                $(".genel_toplam_gbp_siparis").hide();
                $("#gbp_gorunum").hide();
                $(".genel_toplam_euro_siparis").hide();
                $("#euro_gorunum").hide();
                $(".genel_toplam_usd_siparis").hide();
                $("#usd_gorunum").hide();
            }
        })
    });

    $("body").off("click", ".siparis_duzenle_button").on("click", ".siparis_duzenle_button", function () {
        var id = $(this).attr("data-id");
        $.get("modals/satis_modal/siparis_page.php?islem=siparis_guncelle_modal_getir", {id: id}, function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        });
    });
    $("body").off("click", ".siparisi_iptal_et").on("click", ".siparisi_iptal_et", function () {
        var id = $(this).attr("data-id");
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Kaydı seçiniz',
                'warning'
            );
        } else {
            Swal.fire({
                title: 'Sipariş İptal Nedeni Giriniz',
                input: 'text',
                inputPlaceholder: 'İptal Sebebi',
                showCancelButton: true,
                confirmButtonText: 'Tamam',
                cancelButtonText: 'İptal',
                allowOutsideClick: false,
                inputValidator: (value) => {
                    if (!value) {
                        return 'İptal Nedeni Boş Bırakılamaz';
                    }
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    const delete_detail = result.value;
                    $.ajax({
                        url: "controller/satis_controller/sql.php?islem=alinan_siparis_iptal_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Sipariş Silindi',
                                    'success'
                                );
                                $.get("view/satis_siparis.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/satis_siparis.php", function (getList) {
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

    $("body").off("click", ".siparis_sil").on("click", ".siparis_sil", function () {
        var id = $(this).attr("data-id");
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
                        url: "controller/satis_controller/sql.php?islem=siparis_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Sipariş Silindi',
                                    'success'
                                );
                                $.get("view/satis_siparis.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/satis_siparis.php", function (getList) {
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

    $("body").off("click", "#alinan_siparis_olustur_main").on("click", "#alinan_siparis_olustur_main", function () {
        $.get("modals/satis_modal/siparis_modal.php?islem=satis_siparis_olustur", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

</script>