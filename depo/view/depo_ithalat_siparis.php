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
        <div class="ibox-title" style=' font-weight:bold;'>SİPARİŞ İŞLEMLERİ</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="ithalat_siparis_button"><i class="fa fa-plus"></i>
                Sipariş Oluştur
            </button>
            <button class="btn btn-info btn-sm" id=""><i
                        class="fa fa-filter"></i> Hazırla
            </button>
        </div>
        <div class="col-12 row">
            <table class="table table-sm table-bordered w-100  datatable"
                   style="cursor:pointer;font-size: 13px;"
                   id="depo_ihracat_siparis_table">
                <thead>
                <tr>
                    <th>Sipariş Tarihi</th>
                    <th>Cari Kodu</th>
                    <th>Cari Adı</th>
                    <th>Demoraj Tarihi</th>
                    <th>Acenta</th>
                    <th>Beyanname No</th>
                    <th>Toplam Yükleme</th>
                    <th>Sip. Sayısı</th>
                    <th>Kont. Tipi</th>
                    <th>Açıklama</th>
                    <th>Alım Yeri</th>
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
        $("body").off("click", "tr").on("click", "tr", function () {
            $('tr').removeClass('selected');
            $(this).addClass("selected");
        });
        var targetColumns = [5, 6, 7, 12, 13, 14];
        var table = $('#depo_ihracat_siparis_table').DataTable({
            scrollX: true,
            scrollY: '45vh',
            "paging": false,
            columns: [
                {"data": "siparis_tarihi"},
                {"data": "cari_kodu"},
                {"data": "cari_adi"},
                {"data": "demoraj_tarihi"},
                {"data": "acente"},
                {"data": "beyanname_no"},
                {"data": "toplam_yukleme_miktari"},
                {"data": "toplam_siparis"},
                {"data": "konteyner_tipleri"},
                {"data": "aciklama"},
                {"data": "alim_yeri"},
                {"data": "islem"}
            ],
            columnDefs: [
                {targets: 0, type: "date-eu"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find('td').eq(7).css('text-align', 'right');
                $(row).find('td').eq(8).css('text-align', 'right');
                $(row).find("td").css("text-transform", "uppercase")
            },
            "rowCallback": function (row) {
            },
            order: [[0, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

        $("body").off("click", ".depo_ithalat_siparis_guncelle").on("click", ".depo_ithalat_siparis_guncelle", function () {
            let id = $(this).attr("data-id");
            $.get("depo/modals/siparis_modal/ithalat_siparis.php?islem=siparisi_guncelle_modal_getir", {id: id}, function (getModal) {
                $(".getModals").html(getModal);
            })
        });

        $.get("depo/controller/ithalat_controller/sql.php?islem=ithalat_siparislerini_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        })
    });

    $("body").off("click", "#ithalat_siparis_button").on("click", "#ithalat_siparis_button", function () {
        $.get("depo/modals/siparis_modal/ithalat_siparis.php?islem=depo_siparis_olustur_modal_getir", function (getModal) {
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".depo_ihracat_siparis_guncelle").on("click", ".depo_ihracat_siparis_guncelle", function () {
        let id = $(this).attr("data-id");
        $.get("depo/modals/siparis_modal/depo_siparis_olustur.php?islem=depo_siparis_guncelle_modal_getir", {id: id}, function (getModal) {
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".depo_ithalat_siparis_islemleri_sil_button").on("click", ".depo_ithalat_siparis_islemleri_sil_button", function () {
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
                        url: "depo/controller/ithalat_controller/sql.php?islem=depo_ithlat_siparisi_sil_sql",
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
                                        'Sipariş Silindi',
                                        'success'
                                    );
                                    $.get("depo/view/depo_ithalat_siparis.php", function (getList) {
                                        $(".modal-icerik").html("");
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("depo/view/depo_ithalat_siparis.php", function (getList) {
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