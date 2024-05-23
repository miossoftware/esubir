<div class="ibox-container">
    <div class="ibox mt-5">
        <div class="ibox-head">
            <div class="ibox-title" style=' font-weight:bold;'>YAKIT ALIM FATURALARI</div>
        </div>
        <div class="cari_buttons mt-3 mx-3">
            <button class="btn btn-success btn-sm" id="binek_yakit_alim_fat_button"><i class="fa fa-plus-square"
                                                                                       aria-hidden="true"></i> Yakıt
                Fişi Faturalandır
            </button>
        </div>
        <div class="col-12 row">
            <table class="table table-sm table-bordered w-100 display nowrap" style="cursor:pointer;font-size: 13px;"
                   id="konteyner_yakit_fis_faturalari">
                <thead>
                <tr>
                    <th>Fatura Tarihi</th>
                    <th>Fatura No</th>
                    <th>İstasyon Adı</th>
                    <th>Miktar</th>
                    <th>Mal Tutarı</th>
                    <th>KDV Tutarı</th>
                    <th>Toplam Tutar</th>
                    <th>Yakıt Tipi</th>
                    <th>Araç Tipi</th>
                    <th>İşlem</th>
                </tr>
                </thead>
                <tfoot style="background-color: white">
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align: right" class="yakit_fat_miktar">0,00</th>
                <th style="text-align: right" class="yakit_fat_ara_tot">0,00</th>
                <th style="text-align: right" class="yakit_fat_kdv_tot">0,00</th>
                <th style="text-align: right" class="yakit_fat_toplam_tot">0,00</th>
                <th></th>
                <th></th>
                <th></th>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
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
        var table = $("#konteyner_yakit_fis_faturalari").DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            "order": [[0, 'desc']],
            columnDefs: [
                {targets: 0, type: "date-eu"}
            ],
            columns: [
                {"data": "fatura_tarihi"},
                {"data": "fatura_no"},
                {"data": "istasyon_adi"},
                {"data": "miktar"},
                {"data": "mal_tutari"},
                {"data": "kdv_tutari"},
                {"data": "tutar"},
                {"data": "yakit_tipi"},
                {"data": "arac_tipi"},
                {"data": "button"}
            ],
            createdRow: function (new_row) {
                $(new_row).find('td').css('text-align', 'left');
                $(new_row).find("td").eq(3).css("text-align", "right");
                $(new_row).find("td").eq(4).css("text-align", "right");
                $(new_row).find("td").eq(5).css("text-align", "right");
                $(new_row).find("td").eq(6).css("text-align", "right");
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        });

        $.get("controller/arac_controller/sql.php?islem=yakit_faturalarini_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                var basilacak_arr = [];
                let yakit_fat_miktar = 0;
                let yakit_fat_ara_tot = 0;
                let yakit_fat_kdv_tot = 0;
                let yakit_fat_toplam_tot = 0;
                json.forEach(function (item) {

                    let fatura_tarihi = item.fatura_tarihi;
                    fatura_tarihi = fatura_tarihi.split(" ");
                    fatura_tarihi = fatura_tarihi[0];
                    fatura_tarihi = fatura_tarihi.split("-");
                    let gun = fatura_tarihi[2];
                    let ay = fatura_tarihi[1];
                    let yil = fatura_tarihi[0];
                    let arr = [gun, ay, yil];
                    fatura_tarihi = arr.join("/");


                    let yakit_alim_tarih = item.tarih;
                    yakit_alim_tarih = yakit_alim_tarih.split(" ");
                    yakit_alim_tarih = yakit_alim_tarih[0];
                    yakit_alim_tarih = yakit_alim_tarih.split("-");
                    let g = yakit_alim_tarih[2];
                    let a = yakit_alim_tarih[1];
                    let y = yakit_alim_tarih[0];
                    let arr2 = [g, a, y];
                    yakit_alim_tarih = arr2.join("/");

                    let miktar = item.miktar;
                    miktar = parseFloat(miktar);
                    yakit_fat_miktar += miktar;
                    let litre_fiyati = item.litre_fiyati;
                    litre_fiyati = parseFloat(litre_fiyati);

                    let tl_tutar = item.tl_tutar;
                    tl_tutar = parseFloat(tl_tutar);
                    yakit_fat_toplam_tot += tl_tutar;

                    let mal_tutari = tl_tutar / 1.20;
                    yakit_fat_ara_tot += mal_tutari;

                    let kdv_tutari = tl_tutar - mal_tutari;
                    yakit_fat_kdv_tot += kdv_tutari;

                    mal_tutari = mal_tutari.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    tl_tutar = tl_tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    kdv_tutari = kdv_tutari.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    litre_fiyati = litre_fiyati.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    miktar = miktar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});


                    let newRow = {
                        fatura_tarihi: fatura_tarihi,
                        fatura_no: item.fatura_no,
                        plaka_no: item.plaka_no,
                        surucu_adi: item.surucu_adi,
                        fis_no: item.fis_no,
                        yakit_alim_tarih: yakit_alim_tarih,
                        miktar: miktar,
                        mal_tutari: mal_tutari,
                        kdv_tutari: kdv_tutari,
                        litre_fiyat: litre_fiyati,
                        tutar: tl_tutar,
                        yakit_tipi: item.yakit_tipi,
                        istasyon_adi: item.cari_adi,
                        arac_tipi: "BİNEK",
                        button: "<button class='btn btn-primary btn-sm binek_yakit_alim_fatura_detayi' data-id='" + item.id + "'><i class='fa fa-eye'></i></button> <button class='btn btn-danger btn-sm binek_fatura_sil_button' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                    };
                    basilacak_arr.push(newRow);
                });
                $(".yakit_fat_miktar").html(yakit_fat_miktar.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }));
                $(".yakit_fat_ara_tot").html(yakit_fat_ara_tot.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }));
                $(".yakit_fat_kdv_tot").html(yakit_fat_kdv_tot.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }));
                $(".yakit_fat_toplam_tot").html(yakit_fat_toplam_tot.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }));
                table.rows.add(basilacak_arr).draw(false);

            }
        })

    });

    $("body").off("click", ".binek_fatura_sil_button").on("click", ".binek_fatura_sil_button", function () {
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
                        url: "controller/arac_controller/sql.php?islem=yakit_cikis_fislerini_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Yakıt Faturası Silindi',
                                    'success'
                                );
                                $.get("view/binek_yakit_alim_faturasi.php", function (getList) {
                                    $(".admin-modal-icerik").html(getList);
                                });
                                $.get("view/binek_yakit_alim_faturasi.php", function (getList) {
                                    $(".modal-icerik").html(getList);
                                });
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


    $("body").off("click", "#binek_yakit_alim_fat_button").on("click", "#binek_yakit_alim_fat_button", function () {
        $.get("modals/arac_modal/yakit_fisleri_fatura.php?islem=faturalanacak_yakit_fisleri_modal", function (getModal) {
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".binek_yakit_alim_fatura_detayi").on("click", ".binek_yakit_alim_fatura_detayi", function () {
        let id = $(this).attr("data-id");
        $.get("modals/arac_modal/yakit_fisleri_fatura.php?islem=yakit_faturalari_detay_modal", {id: id}, function (getModal) {
            $(".getModals").html(getModal);
        })
    });

</script>