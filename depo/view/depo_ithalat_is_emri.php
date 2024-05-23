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
        <div class="ibox-title" style=' font-weight:bold;'>İŞ EMİRLERİ</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="ithalat_is_emri_olustur">İş Emri Oluştur</button>
        </div>
        <div class="col-12 row mt-5">
            <table class="table table-sm table-bordered nowrap w-100 datatable"
                   style="cursor:pointer;font-size: 13px;"
                   id="depo_cikis_table">
                <thead>
                <tr>
                    <th>Tipi</th>
                    <th>Sipariş Tarih</th>
                    <th>Cari Adı</th>
                    <th>Kont. Tipi</th>
                    <th>Konteyner Sayısı</th>
                    <th>Gelen Konteyner</th>
                    <th>Tamamlanan Konteyner</th>
                    <th>Hizmet Adı</th>
                    <th>Miktar</th>
                    <th>Birim</th>
                    <th>Beyanname No</th>
                    <th>Demoraj Tarihi</th>
                    <th>Referans No</th>
                    <th>Acente</th>
                    <th>Ardiyesiz Giriş Tarihi</th>
                    <th>CUT-OFF Tarihi</th>
                    <th>Alım Yeri</th>
                    <th>Teslim Yeri</th>
                    <th>İşlem</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>

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
        var table = $('#depo_cikis_table').DataTable({
            scrollX: true,
            scrollY: '45vh',
            "paging": false,
            columns: [
                {"data": "tipi"},
                {"data": "siparis_tarihi"},
                {"data": "cari_adi"},
                {"data": "konteyner_tipi"},
                {"data": "konteyner_sayisi"},
                {"data": "gelen_konteyner"},
                {"data": "tamamlanan_konteyner"},
                {"data": "hizmet_adi"},
                {"data": "miktar"},
                {"data": "birim"},
                {"data": "beyanname_no"},
                {"data": "demoraj_tarihi"},
                {"data": "referans_no"},
                {"data": "acente"},
                {"data": "ardiyesiz_giris_tarihi"},
                {"data": "cut_of_tarihi"},
                {"data": "alim_yeri"},
                {"data": "teslim_yeri"},
                {"data": "islem"}
            ],
            columnDefs: [
                {targets: 1, type: "date-eu"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find('td').eq(4).css('text-align', 'right');
                $(row).find('td').eq(5).css('text-align', 'right');
                $(row).find('td').eq(6).css('text-align', 'right');
                $(row).find('td').eq(8).css('text-align', 'right');
                $(row).find("td").css("text-transform", "uppercase")

            },
            "rowCallback": function (row) {
            },
            order: [[1, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        $.get("depo/controller/is_emri_controller/sql.php?islem=ozmal_is_emirlerini_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        });

        $("body").off("click", ".is_emrini_sil_button").on("click", ".is_emrini_sil_button", function () {
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
                        url: "depo/controller/is_emri_controller/sql.php?islem=is_emrini_sil_sql",
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
                                        'İş Emrinin İş Başlangıcı Olmuştur Lütfen İş Emrine Ait İşleri Siliniz...',
                                        'warning'
                                    );
                                } else {
                                    Swal.fire(
                                        'Başarılı!',
                                        'İş Emri Silindi',
                                        'success'
                                    );
                                    $.get("depo/view/depo_ithalat_is_emri.php", function (getList) {
                                        $(".modal-icerik").html("");
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("depo/view/depo_ithalat_is_emri.php", function (getList) {
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

        $("body").off("click", ".is_emrini_guncelle_button").on("click", ".is_emrini_guncelle_button", function () {
            let id = $(this).attr("data-id");
            $.get("depo/modals/is_emri_modal/is_emri_olustur_modal.php?islem=depo_is_emri_guncelle_modal", {id: id}, function (getModal) {
                $(".getModals").html(getModal);
            });
        })

        $("body").off("click", "#ithalat_is_emri_olustur").on("click", "#ithalat_is_emri_olustur", function () {
            $.get("depo/modals/is_emri_modal/is_emri_olustur_modal.php?islem=is_emri_olustur_ana_modal", function (getModal) {
                $(".getModals").html(getModal);
            })
        });
    });

</script>