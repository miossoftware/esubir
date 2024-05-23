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
        <div class="ibox-title" style=' font-weight:bold;'>KONTEYNER GİRİŞ</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="konteyner_giris_main_button"><i class="fa fa-plus"></i>
                Konteyner Giriş
            </button>
            <button class="btn btn-info btn-sm" id=""><i
                        class="fa fa-filter"></i> Hazırla
            </button>
        </div>
        <div class="col-12 row">
            <table class="table table-sm table-bordered w-100 nowrap datatable"
                   style="cursor:pointer;font-size: 13px;"
                   id="depo_ihracat_siparis_table">
                <thead>
                <tr>
                    <th>Araç Tipi</th>
                    <th>Tipi</th>
                    <th>Cari Adı</th>
                    <th>Referans No</th>
                    <th>Beyanname No</th>
                    <th>Mühür No</th>
                    <th>Konteyner No</th>
                    <th>Plaka No</th>
                    <th>Araç Cari</th>
                    <th>Sürücü Adı</th>
                    <th>Giriş Tarihi</th>
                    <th>Boş Dolu</th>
                    <th>Açıklama</th>
                    <th>İşlem</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>

    $(document).ready(function () {
        // ARDİYESİZ GİRİŞ TARİHİ VE DİĞER TARİHLER EKLENECEKMİ DİYE SORACAK
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
        var table = $('#depo_ihracat_siparis_table').DataTable({
            scrollX: true,
            scrollY: '45vh',
            "paging": false,
            columns: [
                {"data": "arac_grubu"},
                {"data": "tipi"},
                {"data": "cari_adi"},
                {"data": "referans_no"},
                {"data": "beyanname_no"},
                {"data": "muhur_no"},
                {"data": "konteyner_no"},
                {"data": "plaka_no"},
                {"data": "arac_cari"},
                {"data": "surucu_adi"},
                {"data": "giris_tarihi"},
                {"data": "bos_dolu"},
                {"data": "aciklama"},
                {"data": "islem"}
            ],
            columnDefs: [
                {targets: 0, type: "date-eu"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find("td").css("text-transform", "uppercase");
            },
            "rowCallback": function (row) {
            },
            order: [[0, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        $.get("depo/controller/konteyner_controller/sql.php?islem=konteyner_girisleri_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        })

        $("body").off("click", ".depo_ithalat_siparis_guncelle").on("click", ".depo_ithalat_siparis_guncelle", function () {
            let id = $(this).attr("data-id");
            $.get("depo/modals/siparis_modal/ithalat_siparis.php?islem=siparisi_guncelle_modal_getir", {id: id}, function (getModal) {
                $(".getModals").html(getModal);
            })
        });

        // $.get("depo/controller/ithalat_controller/sql.php?islem=ithalat_siparislerini_getir_sql", function (res) {
        //     if (res != 2) {
        //         var json = JSON.parse(res);
        //         table.rows.add(json).draw(false);
        //     }
        // })
    });

    $("body").off("click", "#konteyner_giris_main_button").on("click", "#konteyner_giris_main_button", function () {
        $.get("depo/modals/konteyner_modal/konteyner_giris.php?islem=konteyner_girisi_yap_modal", function (getModal) {
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".konteyner_giris_guncelle").on("click", ".konteyner_giris_guncelle", function () {
        let id = $(this).attr("data-id");
        $.get("depo/modals/konteyner_modal/konteyner_giris.php?islem=konteyner_giris_guncelle_modal", {id: id}, function (getModal) {
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".tanimli_konteyner_sil_button").on("click", ".tanimli_konteyner_sil_button", function () {
        var id = $(this).attr("data-id");
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Siparişi seçiniz',
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
                        url: "depo/controller/konteyner_controller/sql.php?islem=konteyner_giris_sil_sql",
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
                                        'Siparişin Taşıması Başlamıştır Lütfen Önce Taşımaları Siliniz...',
                                        'warning'
                                    );
                                } else {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Konteyner Giriş Silindi',
                                        'success'
                                    );
                                    $.get("depo/view/konteyner_giris_main.php", function (getList) {
                                        $(".modal-icerik").html("");
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("depo/view/konteyner_giris_main.php", function (getList) {
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
        }
    });

</script>