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
        <div class="ibox-title" style=' font-weight:bold;'>GEÇMİŞ KONTEYNER GİRİŞLERİ</div>
    </div>
    <div class="col-12 row tetikle">
        <div class="col-12 row mt-5">
            <table class="table table-sm table-bordered w-100  nowrap datatable"
                   style="cursor:pointer;font-size: 13px;"
                   id="alis_fatura_table">
                <thead>
                <tr>
                    <th>Giriş Tarihi</th>
                    <th>Boş / Dolu</th>
                    <th>Depo Firma Adı</th>
                    <th>Konteyner No</th>
                    <th>Firma Adı</th>
                    <th>Tipi</th>
                    <th>Taşıma Tipi</th>
                    <th>Plaka No</th>
                    <th>Plaka Cari</th>
                    <th>Hizmet Kodu</th>
                    <th>Hizmet Adı</th>
                    <th>Ardiye Giriş Tarihi</th>
                    <th>CUT OFF Tarihi</th>
                    <th>Demoraj Tarihi</th>
                    <th>Sürücü Primi</th>
                    <th>Araç Kirası</th>
                    <th>Açıklama</th>
                    <th>İşlem</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="col-12 row mt-2 no-gutters">
        <div class="col-3"></div>
        <div class="col-md-5">
            <table class="table table-sm table-bordered w-100 display nowrap" style="background-color: white">
                <thead>
                <tr>
                    <th style="text-align: center">Kiralık Araç Sayısı</th>
                    <th style="text-align: center">Özmal Araç Sayısı</th>
                    <th style="text-align: center">Sürücü Prim</th>
                    <th style="text-align: center">Kira Bedeli</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="kiralik_adet" style="text-align: right;font-weight: bold">0 Adet</td>
                    <td class="ozmal_adet" style="text-align: right;font-weight: bold">0 Adet</td>
                    <td class="surucu_prim" style="text-align: right;font-weight: bold">0,00 TL</td>
                    <td class="arac_kira" style="text-align: right;font-weight: bold">0,00 TL</td>
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
    $('.tetikle').on('keydown', function (event) {
        if (event.keyCode === 13) {
            $("#alis_fatura_filtrele").click();
        }
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
        var targetColumns = [5, 6, 7, 12, 13, 14];
        var table = $('#alis_fatura_table').DataTable({
            scrollX: true,
            scrollY: '45vh',
            "paging": false,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "GEÇMİŞ DEPO GİRİŞ LİSTESİ",
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
            columns: [
                {"data": "giris_tarihi"},
                {"data": "bos_dolu"},
                {"data": "depo_firma_adi"},
                {"data": "konteyner_no"},
                {"data": "firma_adi"},
                {"data": "konteyner_tipi"},
                {"data": "tasima_tipi"},
                {"data": "plaka_no"},
                {"data": "plaka_cari"},
                {"data": "hizmet_kodu"},
                {"data": "hizmet_adi"},
                {"data": "ardiye_giris_tarih"},
                {"data": "cutt_off_tarihi"},
                {"data": "demoraj_tarihi"},
                {"data": "surucu_primi"},
                {"data": "arac_kirasi"},
                {"data": "aciklama"},
                {"data": "button"}
            ],
            columnDefs: [
                {targets: 2, type: "date-eu"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find('td').eq(15).css('text-align', 'right');
                $(row).find('td').eq(14).css('text-align', 'right');
                $(row).find('td').eq(17).css('text-align', 'right');
                $(row).find("td").css("text-transform", "uppercase")
            },
            "rowCallback": function (row) {
            },
            order: [[2, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        $.get("depo/controller/nakliye_controller/sql.php?islem=depodaki_konteynerleri_getir_sql2", function (response) {
            if (response != 2) {
                var json = JSON.parse(response);
                let basilacak_arr = [];

                let kiralik_adet = 0;
                let ozmal_adet = 0;
                let kira_tutari = 0;
                let prim_tutari = 0;

                json.forEach(function (item) {

                    let giris_tarih = item.tarih;
                    giris_tarih = giris_tarih.split(" ");
                    giris_tarih = giris_tarih[0];
                    giris_tarih = giris_tarih.split("-");
                    let gun = giris_tarih[2];
                    let ay = giris_tarih[1];
                    let yil = giris_tarih[0];
                    let arr = [gun, ay, yil];
                    giris_tarih = arr.join("/");

                    let ardiye_giris_tarih = item.ardiye_giris_tarih;
                    ardiye_giris_tarih = ardiye_giris_tarih.split(" ");
                    ardiye_giris_tarih = ardiye_giris_tarih[0];
                    ardiye_giris_tarih = ardiye_giris_tarih.split("-");
                    let gun1 = ardiye_giris_tarih[2];
                    let ay1 = ardiye_giris_tarih[1];
                    let yil1 = ardiye_giris_tarih[0];
                    let arr1 = [gun1, ay1, yil1];
                    ardiye_giris_tarih = arr1.join("/");

                    let cutt_off_tarihi = item.cutt_off_tarihi;
                    cutt_off_tarihi = cutt_off_tarihi.split(" ");
                    cutt_off_tarihi = cutt_off_tarihi[0];
                    cutt_off_tarihi = cutt_off_tarihi.split("-");
                    let gun2 = cutt_off_tarihi[2];
                    let ay2 = cutt_off_tarihi[1];
                    let yil2 = cutt_off_tarihi[0];
                    let arr2 = [gun2, ay2, yil2];
                    cutt_off_tarihi = arr2.join("/");

                    let demoraj_tarihi = item.demoraj_tarihi;
                    demoraj_tarihi = demoraj_tarihi.split(" ");
                    demoraj_tarihi = demoraj_tarihi[0];
                    demoraj_tarihi = demoraj_tarihi.split("-");
                    let gun3 = demoraj_tarihi[2];
                    let ay3 = demoraj_tarihi[1];
                    let yil3 = demoraj_tarihi[0];
                    let arr3 = [gun3, ay3, yil3];
                    demoraj_tarihi = arr3.join("/");

                    let arac_kira = item.arac_kirasi;
                    arac_kira = parseFloat(arac_kira);


                    let surucu_prim = item.surucu_prim;
                    surucu_prim = parseFloat(surucu_prim);

                    kira_tutari += arac_kira;
                    prim_tutari += surucu_prim;
                    if (item.arac_carisi != null) {
                        kiralik_adet += 1;
                    } else {
                        ozmal_adet += 1;
                    }

                    surucu_prim = surucu_prim.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    arac_kira = arac_kira.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});

                    let konteyner_tipi = "";

                    if (item.konteyner_tipi == 1) {
                        konteyner_tipi = "20 DC";
                    } else if (item.konteyner_tipi == 2) {
                        konteyner_tipi = "40 DC";
                    } else if (item.konteyner_tipi == 3) {
                        konteyner_tipi = "20 OT";
                    } else if (item.konteyner_tipi == 4) {
                        konteyner_tipi = "40 OT";
                    } else if (item.konteyner_tipi == 5) {
                        konteyner_tipi = "20 RF";
                    } else if (item.konteyner_tipi == 6) {
                        konteyner_tipi = "40 RF";
                    } else if (item.konteyner_tipi == 7) {
                        konteyner_tipi = "40 HC RF";
                    } else if (item.konteyner_tipi == 8) {
                        konteyner_tipi = "40 HC";
                    } else if (item.konteyner_tipi == 9) {
                        konteyner_tipi = "20 TANK";
                    } else if (item.konteyner_tipi == 10) {
                        konteyner_tipi = "20 VENTİLATED";
                    } else if (item.konteyner_tipi == 11) {
                        konteyner_tipi = "40 HC PAL. WIDE";
                    } else if (item.konteyner_tipi == 12) {
                        konteyner_tipi = "20 FLAT";
                    } else if (item.konteyner_tipi == 13) {
                        konteyner_tipi = "40 FLAT";
                    } else if (item.konteyner_tipi == 14) {
                        konteyner_tipi = "40 HC FLAT";
                    } else if (item.konteyner_tipi == 15) {
                        konteyner_tipi = "20 PLATFORM";
                    } else if (item.konteyner_tipi == 16) {
                        konteyner_tipi = "40 PLATFORM";
                    } else if (item.konteyner_tipi == 17) {
                        konteyner_tipi = "45 HC";
                    } else if (item.konteyner_tipi == 18) {
                        konteyner_tipi = "KARGO";
                    }


                    let depo_adi = item.depo_adi;
                    if (depo_adi.length > 10) {
                        depo_adi = depo_adi.substring(0, 10) + "...";
                    }

                    let firma_adi = item.firma_adi;
                    if (firma_adi.length > 15) {
                        firma_adi = firma_adi.substring(0, 20) + "...";
                    }

                    let newRow = {
                        giris_tarihi: giris_tarih,
                        depo_firma_kodu: item.depo_kodu,
                        depo_firma_adi: depo_adi,
                        bos_dolu: item.bos_dolu,
                        konteyner_no: item.konteyner_no,
                        firma_kodu: item.firma_kodu,
                        firma_adi: firma_adi,
                        konteyner_tipi: konteyner_tipi,
                        tasima_tipi: item.tasima_tipi,
                        plaka_no: item.plaka_no,
                        plaka_cari: item.arac_carisi,
                        hizmet_kodu: item.hizmet_kodu,
                        hizmet_adi: item.hizmet_adi,
                        ardiye_giris_tarih: ardiye_giris_tarih,
                        cutt_off_tarihi: cutt_off_tarihi,
                        demoraj_tarihi: demoraj_tarihi,
                        surucu_primi: surucu_prim,
                        arac_kirasi: arac_kira,
                        aciklama: item.aciklama,
                        button: "<button class='btn  btn-sm depo_giris_guncelle_button' data-id='" + item.id + "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm girisi_yapilan_konteyner_sil_button' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>",
                    };
                    basilacak_arr.push(newRow);
                })

                $(".kiralik_adet").html(kiralik_adet + " ADET");
                $(".ozmal_adet").html(ozmal_adet + " ADET");
                $(".surucu_prim").html(prim_tutari.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }) + " TL");
                $(".arac_kira").html(kira_tutari.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }) + " TL");

                table.rows.add(basilacak_arr).draw(false);
            }
        })
    });

    $("body").off("click", ".depo_giris_guncelle_button").on("click", ".depo_giris_guncelle_button", function () {
        let id = $(this).attr("data-id");
        $.get("depo/modals/nakliye_depolama_modal/depo_giris_page.php?islem=depo_giris_guncelle_modal", {id: id}, function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        });
    });


    $("body").off("click", "#depolama_hizmeti_ekle_button").on("click", "#depolama_hizmeti_ekle_button", function () {
        $.get("depo/modals/nakliye_depolama_modal/nakliye_depolama.php?islem=nakliyeci_depolama_hizmetleri_getir", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".girisi_yapilan_konteyner_sil_button").on("click", ".girisi_yapilan_konteyner_sil_button", function () {
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
                        url: "depo/controller/nakliye_controller/sql.php?islem=depodan_giris_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Konteyner Depodan Silindi',
                                    'success'
                                );
                                $.get("depo/view/nakliye_depolama_islemleri.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("depo/view/nakliye_depolama_islemleri.php", function (getList) {
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
</script>