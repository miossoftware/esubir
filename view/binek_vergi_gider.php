<div class="ibox-container">
    <div class="ibox mt-5">
        <div class="ibox-head">
            <div class="ibox-title" style=' font-weight:bold;'>BİNEK ARAÇ VERGİ GİDER GİRİŞİ</div>
        </div>
        <div class="col-12 row">
            <div class="cari_buttons mt-3 mx-3">
                <button class="btn btn-success btn-sm" id="binek_arac_hgs_gider_ekle_button"><i class="fa fa-plus-square"
                                                                                                aria-hidden="true"></i> Vergi
                    Gideri Ekle
                </button>
            </div>
            <div class="col-12 row mx-1 mt-3">
                <table class="table table-sm table-bordered w-100  nowrap edit_list"
                       style="cursor:pointer;font-size: 13px;"
                       id="arac_table">
                    <thead>
                    <tr>
                        <th>Tarih</th>
                        <th>Tutar</th>
                        <th>Açıklama</th>
                        <th style="width: 0% !important;">İşlem</th>
                    </tr>
                    </thead>
                    <tfoot style="background-color: white">
                    <th></th>
                    <th style="text-align: right" class="hgs_gider_tot">0,00</th>
                    <th></th>
                    <th></th>
                    </tfoot>
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
        var table = $('#arac_table').DataTable({
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            scrollX: true,
            paging: false,
            scrollY: "55vh",
            "initComplete": function () {
                $('#arac_table').addClass('myCustomStyle');
            },
            columns: [
                {"data": "tarih"},
                {"data": "tutar"},
                {"data": "aciklama"},
                {"data": "button"}
            ],
            "order": [[0, 'desc']],
            columnDefs: [
                {targets: 0, type: "date-eu"}
            ],
            info: false,
            createdRow: function (row, data, dataIndex) {
                $(row).find("td").css("text-transform", "uppercase");
                $(row).find("td").css("text-align", "left");
                $(row).find("td").eq(1).css("text-align", "right");
            }
        });
        $.get("controller/arac_controller/sql.php?islem=vergi_gider_fislerini_getir_sql", function (response) {
            if (response != 2) {
                var json = JSON.parse(response);
                var basilacak_arr = [];
                let hgs_gider_tot = 0;
                json.forEach(function (item) {

                    let tarih = item.tarih;
                    tarih = tarih.split(" ");
                    tarih = tarih[0];
                    tarih = tarih.split("-");
                    let gun = tarih[2];
                    let ay = tarih[1];
                    let yil = tarih[0];
                    let arr = [gun, ay, yil];
                    tarih = arr.join("/");

                    let tutar = item.tutar;
                    tutar = parseFloat(tutar);
                    hgs_gider_tot += tutar;
                    tutar = tutar.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});

                    let newRow = {
                        tarih: tarih,
                        tutar: tutar,
                        aciklama: item.aciklama,
                        button: "<button class='btn btn-sm binek_vergi_gider_fisi_guncelle_main_button' data-id='" + item.id + "' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm vergi_gider_fisi_sil_main_list_button' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>",
                    };
                    basilacak_arr.push(newRow);
                });
                $(".hgs_gider_tot").html(hgs_gider_tot.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }))
                table.rows.add(basilacak_arr).draw(false);
            }
        })
    });

    $("body").off("click", "#binek_arac_hgs_gider_ekle_button").on("click", "#binek_arac_hgs_gider_ekle_button", function () {
        $.get("modals/arac_modal/vergi_gider.php?islem=vergi_gider_girisi_modal", function (getModal) {
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".binek_vergi_gider_fisi_guncelle_main_button").on("click", ".binek_vergi_gider_fisi_guncelle_main_button", function () {
        let id = $(this).attr("data-id");
        $.get("modals/arac_modal/vergi_gider.php?islem=vergri_gider_fisi_detay_modal_getir", {id: id}, function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".vergi_gider_fisi_sil_main_list_button").on("click", ".vergi_gider_fisi_sil_main_list_button", function () {
        var cari_kodu = $(this).attr("data-id");
        if (cari_kodu == "" || cari_kodu == undefined) {
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
                        url: "controller/arac_controller/sql.php?islem=vergi_gider_fisi_tum_sil_sql",
                        type: "POST",
                        data: {
                            id: cari_kodu,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Vergi Gider Fişi Silindi',
                                    'success'
                                );
                                $.get("view/binek_vergi_gider.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
                                    $(".admin-modal-icerik").html(getList);
                                });
                                $.get("view/binek_vergi_gider.php", function (getList) {
                                    $(".modal-icerik").html("");
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

</script>