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
        <div class="ibox-title" style=' font-weight:bold;'>KASA TAHSİLAT</div>
    </div>
    <div class="col-12 row ">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="yeni_tahsilat_fisi_ekle"><i class="fa fa-plus"></i> Yeni
                Tahsilat
            </button>
            <button class="btn btn-info btn-sm" id="kasa_tahsilat_filtre"><i
                        class="fa fa-filter"></i> Hazırla
            </button>
        </div>
        <div class="col-12 row">
            <div class="col-12 row mx-1 mt-3">
                <div class="col-md-3 row">

                    <input type="text" placeholder="Başlangıç Tarihi" id="bas_tarih" onfocus="(this.type='date')"
                           class="form-control form-control-sm bas_tarih_tahsilat">
                    <input type="text" placeholder="Bitiş Tarihi" id="bit_tarih" onfocus="(this.type='date')"
                           class="form-control form-control-sm mt-2 bit_tarih_tahsilat">
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 row mt-3">
        <table class="table table-sm table-bordered w-100  nowrap" style="cursor:pointer;font-size: 13px;"
               id="kasa_tahsilat_table">
            <thead>
            <tr>
                <th>İşlem Tarihi</th>
                <th>Kasa Kodu</th>
                <th>Kasa Adı</th>
                <th>Fiş No</th>
                <th>Açıklama</th>
                <th>Toplam Tutar</th>
                <th>İşlem</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="col-12 row no-gutters mt-1">
        <div class="col-12 row mt-2 no-gutters">
            <div class="col-3"></div>
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
            <div class="col-md-4">
                <table class="table table-sm table-bordered w-100 display nowrap" style="background-color: white">
                    <thead>
                    <tr>
                        <th style="text-align: center">Toplam Tahsilat</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="tahsilat_tl" style="text-align: right">0,00 TL</td>
                    </tr>
                    <tr>
                        <td class="tahsilat_usd" style="text-align: right">0,00 USD</td>
                    </tr>
                    <tr>
                        <td class="tahsilat_eur" style="text-align: right">0,00 EURO</td>
                    </tr>
                    <tr>
                        <td class="tahsilat_gbp" style="text-align: right">0,00 GBP</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>

    function tlCevir(sayi) {
        let rakam = sayi.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".").split(",");
        let tamsayi = rakam[0];
        let ondalik = rakam[1] || "";


        var birler = ["", "BİR", "İKİ", "ÜÇ", "DÖRT", "BEŞ", "ALTI", "YEDİ", "SEKİZ", "DOKUZ"];
        var onlar = ["", "ON", "YİRMİ", "OTUZ", "KIRK", "ELLİ", "ALTMIŞ", "YETMİŞ", "SEKSEN", "DOKSAN"];
        var binler = ["", "BİN", "MİLYON", "MİLYAR", "TRİLYON", "KATRİLYON", "KENTİLYON"];
        var sonuc = [];

        var adim = 0;
        for (let i = tamsayi.split(".").length; i > 0; i--) {
            sayi = tamsayi.split(".")[i - 1];
            if (sayi.length == 1) {
                sayi = "00" + sayi;
            }
            if (sayi.length == 2) {
                sayi = "0" + sayi;
            }
            let c = "";

            for (let j = 1; j < sayi.length + 1; j++) {
                if (j == 1 && sayi[j - 1] == 1) {
                    c += " YÜZ ";
                } else if (j == 1 && birler[sayi[j - 1]] != "") {
                    c += birler[sayi[j - 1]] + " YÜZ ";
                } else if (j == 2) {
                    c += onlar[sayi[j - 1]] + " ";
                } else if (j == 3 && tamsayi.length == 5 && sayi[j - 1] == 1 && adim == 1) {
                    c += " ";
                } else if (j == 3) {
                    c += birler[sayi[j - 1]] + " ";
                }
            }

            if (c != "") {
                sonuc.push(c + binler[adim]);
            }
            adim++;
        }

        if (sonuc.length != 0) {
            sonuc = sonuc.reverse().join(" ") + " TL";
        } else {
            sonuc = "";
        }
        if (ondalik.length == 1) {
            ondalik = ondalik + "0";
        }
        if (ondalik != "") {
            sonuc += " " + onlar[ondalik[0]] + " " + birler[ondalik[1]] + " KR";
        }

        sonuc = sonuc.replace(/ /g, " ").trim();

        return sonuc;
    }


    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });
    $("body").off("click", ".yazdir").on("click", ".yazdir", function () {
        let id = $(this).attr("data-id");
        $.get("controller/kasa_controller/sql.php?islem=tahsilat_fislerini_getir_sql", {id: id}, function (res) {
            if (res != 2) {
                let cari_adi = "";
                let tutar = "";
                let tarih = "";
                let item = JSON.parse(res);
                if (item.cari_adi != null) {
                    cari_adi = item.cari_adi;
                } else {
                    cari_adi = item.uye_adi;
                }
                tutar = item.tutar;
                tutar = parseFloat(tutar);
                var turkceMetin = tlCevir(tutar);
                tutar = tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                tarih = item.islem_tarihi;
                tarih = tarih.split(" ");
                tarih = tarih[0];
                tarih = tarih.split("-");
                let g = tarih[2];
                let a = tarih[1];
                let y = tarih[0];
                let arr = [g, a, y];
                tarih = arr.join("/");

                var yeniSayfa = window.open("yazdir.php?tutar=" + tutar + "&cari_adi=" + cari_adi + "&tarih=" + tarih + "&belge_no=" + item.belge_no + "&metinsel=" + turkceMetin, '_blank');

                // Yeni sayfanın yüklenmesini bekleyip yazdır
                yeniSayfa.onload = function () {
                    yeniSayfa.print();
                };
                return false;
            }
        });
    });
    $(document).ready(function () {
        var targetColumns = [5];
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
        var table = $('#kasa_tahsilat_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            bAutoWidth: false,
            "order": [[0, 'desc']],
            columnDefs: [
                {targets: 0, type: "date-eu"}
            ],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "KASA TAHSİLAT LİSTESİ",
                    text: "<i class='fa fa-download'></i> Excel'e Aktar",
                    className: 'excel_alis', // Sınıfı burada tanımlayabilirsiniz
                    customizeData: function (excelData) {
                        // Özel veri dönüşümü ve formatlamaları yapabilirsiniz
                        // excelData, dışa aktarılacak Excel verilerini temsil eder

                        // Örneğin, her hücreyi sayı olarak biçimlendirme
                        for (var rowIdx = 0; rowIdx < excelData.body.length; rowIdx++) {
                            var rowData = excelData.body[rowIdx];
                            for (var cellIdx = 0; cellIdx < rowData.length; cellIdx++) {
                                var cellValue = excelData.body[rowIdx][cellIdx];
                                if (typeof cellValue === 'string') {
                                    if (targetColumns.includes(cellIdx)) {
                                        var parsedValue = parseFloat(cellValue.replace('.', '').replace(',', '.').replace(/\s/g, ''));
                                        if (!isNaN(parsedValue)) {
                                            excelData.body[rowIdx][cellIdx] = parsedValue.toLocaleString("en-US", {
                                                maximumFractionDigits: 2,
                                                minimumFractionDigits: 2
                                            });
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            ],
            createdRow: function (row, data, dataIndex) {
            },
            aoColumns: [
                {sWidth: '0%'},
                {sWidth: '1%'},
                {sWidth: '1%'},
                {sWidth: '1%'},
                {sWidth: '2%'},
                {sWidth: '1%'},
                {sWidth: '0%'}
            ],
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        })

        $("body").off("click", "#kasa_tahsilat_filtre").on("click", "#kasa_tahsilat_filtre", function () {
            let bas_tarih = $(".bas_tarih_tahsilat").val();
            let bit_tarih = $(".bit_tarih_tahsilat").val();
            $.get("controller/kasa_controller/sql.php?islem=tahsilat_fisleri_getir_sql", {
                bas_tarih: bas_tarih,
                bit_tarih: bit_tarih
            }, function (result) {
                if (result != 2) {
                    var json = JSON.parse(result);
                    let tahsilat_tl = 0;
                    let tahsilat_usd = 0;
                    let tahsilat_gbp = 0;
                    let tahsilat_euro = 0;
                    table.clear().draw(false);
                    json.forEach(function (item) {
                        var islemTarihi = item.islem_tarihi;
                        var explode = islemTarihi.split(" ");
                        var explode_cikti = explode[0];
                        var explode_2 = explode_cikti.split("-");
                        var gun = explode_2[2];
                        var ay = explode_2[1];
                        var yil = explode_2[0];
                        var arr = [gun, ay, yil];
                        var islem_tarihi = arr.join("/");

                        var tahsilat_toplam = item.tahsilat_toplam;
                        tahsilat_toplam = parseFloat(tahsilat_toplam);
                        if (item.doviz_turu == "TL") {
                            tahsilat_tl += tahsilat_toplam;
                        } else if (item.doviz_turu == "USD") {
                            tahsilat_usd += tahsilat_toplam;
                        } else if (item.doviz_turu == "GBP") {
                            tahsilat_gbp += tahsilat_toplam;
                        } else {
                            tahsilat_euro += tahsilat_toplam;
                        }
                        tahsilat_toplam = tahsilat_toplam.toLocaleString("tr-TR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });

                        var new_row = table.row.add([islem_tarihi, item.kasa_kodu, item.kasa_adi, item.belge_no, item.aciklama, tahsilat_toplam + " " + item.doviz_turu, "<button style='background-color: #F6FA70' class='btn btn-sm tahsilat_guncelle' data-id='" + item.id + "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm tahsilat_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button> <button class='btn btn-primary btn-sm yazdir' data-id='" + item.id + "'><i class='fa fa-file'></i> Yazdır</button>"]).draw(false).node();
                        $(new_row).find('td').eq(0).css('text-align', 'left');
                        $(new_row).find('td').eq(1).css('text-align', 'left');
                        $(new_row).find('td').eq(2).css('text-align', 'left');
                        $(new_row).find('td').eq(3).css('text-align', 'left');
                        $(new_row).find('td').eq(4).css('text-align', 'left');
                        $(new_row).find('td').eq(6).css('text-align', 'left');
                    });
                    tahsilat_tl = tahsilat_tl.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    tahsilat_usd = tahsilat_usd.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    tahsilat_euro = tahsilat_euro.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    tahsilat_gbp = tahsilat_gbp.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    if (tahsilat_gbp == "0,00") {
                        $(".tahsilat_gbp").css("display", "none");
                        $("#gbp_gorunum").css("display", "none");
                    }
                    if (tahsilat_usd == "0,00") {
                        $(".tahsilat_usd").css("display", "none");
                        $("#usd_gorunum").css("display", "none");
                    }
                    if (tahsilat_euro == "0,00") {
                        $(".tahsilat_eur").css("display", "none");
                        $("#euro_gorunum").css("display", "none");
                    }
                    $(".tahsilat_tl").html("");
                    $(".tahsilat_tl").html(tahsilat_tl + " TL");
                    $(".tahsilat_eur").html("");
                    $(".tahsilat_eur").html(tahsilat_euro + " TL");
                    $(".tahsilat_usd").html("");
                    $(".tahsilat_usd").html(tahsilat_usd + " TL");
                    $(".tahsilat_gbp").html("");
                    $(".tahsilat_gbp").html(tahsilat_gbp + " TL");
                } else {
                    table.clear().draw(false);
                }
            })
        });

        $.get("controller/kasa_controller/sql.php?islem=tahsilat_fisleri_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                let tahsilat_tl = 0;
                let tahsilat_usd = 0;
                let tahsilat_gbp = 0;
                let tahsilat_euro = 0;
                json.forEach(function (item) {
                    var islemTarihi = item.islem_tarihi;
                    var explode = islemTarihi.split(" ");
                    var explode_cikti = explode[0];
                    var explode_2 = explode_cikti.split("-");
                    var gun = explode_2[2];
                    var ay = explode_2[1];
                    var yil = explode_2[0];
                    var arr = [gun, ay, yil];
                    var islem_tarihi = arr.join("/");

                    var tahsilat_toplam = item.tahsilat_toplam;
                    tahsilat_toplam = parseFloat(tahsilat_toplam);
                    if (item.doviz_turu == "TL") {
                        tahsilat_tl += tahsilat_toplam;
                    } else if (item.doviz_turu == "USD") {
                        tahsilat_usd += tahsilat_toplam;
                    } else if (item.doviz_turu == "GBP") {
                        tahsilat_gbp += tahsilat_toplam;
                    } else {
                        tahsilat_euro += tahsilat_toplam;
                    }
                    tahsilat_toplam = tahsilat_toplam.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    var new_row = table.row.add([islem_tarihi, item.kasa_kodu, item.kasa_adi, item.belge_no, item.aciklama, tahsilat_toplam + " " + item.doviz_turu, "<button style='background-color: #F6FA70' class='btn btn-sm tahsilat_guncelle' data-id='" + item.id + "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm tahsilat_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button> <button class='btn btn-primary btn-sm yazdir' data-id='" + item.id + "'><i class='fa fa-file'></i> Yazdır</button>"]).draw(false).node();
                    $(new_row).find('td').eq(0).css('text-align', 'left');
                    $(new_row).find('td').eq(1).css('text-align', 'left');
                    $(new_row).find('td').eq(2).css('text-align', 'left');
                    $(new_row).find('td').eq(3).css('text-align', 'left');
                    $(new_row).find('td').eq(4).css('text-align', 'left');
                    $(new_row).find('td').eq(6).css('text-align', 'left');
                });
                tahsilat_tl = tahsilat_tl.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                tahsilat_usd = tahsilat_usd.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                tahsilat_euro = tahsilat_euro.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                tahsilat_gbp = tahsilat_gbp.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                if (tahsilat_gbp == "0,00") {
                    $(".tahsilat_gbp").css("display", "none");
                    $("#gbp_gorunum").css("display", "none");
                }
                if (tahsilat_usd == "0,00") {
                    $(".tahsilat_usd").css("display", "none");
                    $("#usd_gorunum").css("display", "none");
                }
                if (tahsilat_euro == "0,00") {
                    $(".tahsilat_eur").css("display", "none");
                    $("#euro_gorunum").css("display", "none");
                }
                $(".tahsilat_tl").html("");
                $(".tahsilat_tl").html(tahsilat_tl + " TL");
                $(".tahsilat_eur").html("");
                $(".tahsilat_eur").html(tahsilat_euro + " TL");
                $(".tahsilat_usd").html("");
                $(".tahsilat_usd").html(tahsilat_usd + " TL");
                $(".tahsilat_gbp").html("");
                $(".tahsilat_gbp").html(tahsilat_gbp + " TL");
            }
        })
    })

    $("body").off("click", ".tahsilat_sil").on("click", ".tahsilat_sil", function () {
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
                        url: "controller/kasa_controller/sql.php?islem=tahsilat_iptal_et_main_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Tahsilat Fişi Silindi',
                                    'success'
                                );
                                $.get("view/kasa_tahsilat.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/kasa_tahsilat.php", function (getList) {
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

    $("body").off("click", ".tahsilat_guncelle").on("click", ".tahsilat_guncelle", function () {
        var id = $(this).attr("data-id");
        $.get("modals/kasa_modal/tahsilat_page.php?islem=kasa_tahsilat_modal", {id: id}, function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    })

    $("body").off("click", "#yeni_tahsilat_fisi_ekle").on("click", "#yeni_tahsilat_fisi_ekle", function () {
        $.get("modals/kasa_modal/kasa_tahsilat_modal.php?islem=kasa_tahsilat_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

</script>