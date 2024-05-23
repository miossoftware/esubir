<div class="ibox-container">
    <div class="ibox mt-5">
        <div class="ibox-head">
            <div class="ibox-title" style=' font-weight:bold;'>SANAYİ FİŞİ FATURALARI</div>
        </div>
        <div class="cari_buttons mt-3 mx-3">
            <button class="btn btn-success btn-sm" id="binek_sanayi_faturalandir_button"><i class="fa fa-plus-square"
                                                                                      aria-hidden="true"></i> Sanayi
                Fişi Faturalandır
            </button>
        </div>
        <div class="col-12 row">
            <table class="table table-sm table-bordered w-100  nowrap" style="cursor:pointer;font-size: 13px;"
                   id="konteyner_yakit_fis_faturalari">
                <thead>
                <tr>
                    <th>Fatura Tarihi</th>
                    <th>Fatura No</th>
                    <th>Cari Adı</th>
                    <th>Ara Toplam</th>
                    <th>Kdv Toplam</th>
                    <th>İskonto Toplam</th>
                    <th>Genel Toplam</th>
                    <th>Açıklama</th>
                    <th>İşlem</th>
                </tr>
                </thead>
                <tfoot style="background-color: white">
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align: right" class="ara_tot_sanayi">0,00</th>
                <th style="text-align: right" class="kdv_tot_sanayi">0,00</th>
                <th style="text-align: right" class="iskonto_tot_sanayi">0,00</th>
                <th style="text-align: right" class="genel_tot_sanayi">0,00</th>
                <th></th>
                <th></th>
                </tfoot>
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
                {"data": "cari_adi"},
                {"data": "ara_toplam"},
                {"data": "kdv_toplam"},
                {"data": "iskonto_toplam"},
                {"data": "toplam_tutar"},
                {"data": "aciklama"},
                {"data": "button"}
            ],
            createdRow: function (row,data,dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find("td").eq(3).css("text-align", "right");
                $(row).find("td").eq(4).css("text-align", "right");
                $(row).find("td").eq(5).css("text-align", "right");
                $(row).find("td").eq(6).css("text-align", "right");

            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        });

        $.get("controller/arac_controller/sql.php?islem=faturalanmis_sanayi_fisleri_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                var basilacak_arr = [];

                let ara_tot_sanayi = 0;
                let kdv_tot_sanayi = 0;
                let iskonto_tot_sanayi = 0;
                let genel_tot_sanayi = 0;
                json.forEach(function (item) {
                    let fatura_tarihi = item.fatura_tarih;
                    fatura_tarihi = fatura_tarihi.split(" ");
                    fatura_tarihi = fatura_tarihi[0];
                    fatura_tarihi = fatura_tarihi.split("-");
                    let gun = fatura_tarihi[2];
                    let ay = fatura_tarihi[1];
                    let yil = fatura_tarihi[0];
                    let arr = [gun, ay, yil];
                    fatura_tarihi = arr.join("/");

                    let toplam_tutar = item.toplam_tutar;
                    toplam_tutar = parseFloat(toplam_tutar);
                    genel_tot_sanayi += toplam_tutar;
                    toplam_tutar = toplam_tutar.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });
                    let iskonto_toplam = item.iskonto_tutar;
                    iskonto_toplam = parseFloat(iskonto_toplam);
                    iskonto_tot_sanayi += iskonto_toplam;
                    iskonto_toplam = iskonto_toplam.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });
                    let kdv_toplam = item.kdv_tutar;
                    kdv_toplam = parseFloat(kdv_toplam);
                    kdv_tot_sanayi += kdv_toplam;
                    kdv_toplam = kdv_toplam.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });
                    let ara_toplam = item.ara_toplam;
                    ara_toplam = parseFloat(ara_toplam);
                    ara_tot_sanayi += ara_toplam;
                    ara_toplam = ara_toplam.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    });

                    let newRow = {
                        fatura_tarihi: fatura_tarihi,
                        fatura_no: item.fatura_no,
                        cari_adi: item.cari_adi,
                        ara_toplam: ara_toplam,
                        kdv_toplam: kdv_toplam,
                        iskonto_toplam: iskonto_toplam,
                        toplam_tutar: toplam_tutar,
                        aciklama: item.aciklama,
                        button: "<button class='btn btn-secondary btn-sm binek_sanayi_fat_detay' data-id='" + item.id + "'><i class='fa fa-eye'></i></button> <button class='btn btn-danger btn-sm binek_fisi_fatura_sil_button' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                    };
                    basilacak_arr.push(newRow);
                });
                $(".ara_tot_sanayi").html(ara_tot_sanayi.toLocaleString("tr-TR",{maximumFractionDigits:2,minimumFractionDigits:2}));
                $(".kdv_tot_sanayi").html(kdv_tot_sanayi.toLocaleString("tr-TR",{maximumFractionDigits:2,minimumFractionDigits:2}));
                $(".iskonto_tot_sanayi").html(iskonto_tot_sanayi.toLocaleString("tr-TR",{maximumFractionDigits:2,minimumFractionDigits:2}));
                $(".genel_tot_sanayi").html(genel_tot_sanayi.toLocaleString("tr-TR",{maximumFractionDigits:2,minimumFractionDigits:2}));
                table.rows.add(basilacak_arr).draw(false);
            }
        })

    });

    $("body").off("click", ".binek_sanayi_fat_detay").on("click", ".binek_sanayi_fat_detay", function () {
        let id = $(this).attr("data-id");
        $.get("modals/arac_modal/sanayi_fatura_detay.php?islem=sanayi_fatura_bilgileri_modal", {id: id}, function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });


    $("body").off("click", ".binek_fisi_fatura_sil_button").on("click", ".binek_fisi_fatura_sil_button", function () {
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
                    url: "controller/arac_controller/sql.php?islem=sanayi_faturasini_sil_sql",
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
                                    'Cariye Ait Hareket Bulunmaktadır Lütfen Öncelikli Olarak Hareketleri Siliniz...',
                                    'warning'
                                );
                            } else {
                                Swal.fire(
                                    'Başarılı!',
                                    'Sanayi Fişi Silindi',
                                    'success'
                                );
                                $.get("konteyner/view/sanayi_faturalandir.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("konteyner/view/sanayi_faturalandir.php", function (getList) {
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


    $("body").off("click", "#binek_sanayi_faturalandir_button").on("click", "#binek_sanayi_faturalandir_button", function () {
        $.get("modals/arac_modal/sanayi_fisleri_faturalandir.php?islem=sanayi_fisleri_faturalandir_modal_getir", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

</script>