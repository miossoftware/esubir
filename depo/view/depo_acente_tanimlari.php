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
        <div class="ibox-title" style=' font-weight:bold;'>HİZMET TANIM</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="yeni_depo_hizmet_button"><i class="fa fa-plus"></i>
                Hizmet Tanım Ekle
            </button>
        </div>
        <div class="mt-2"></div>
        <nav class="nav nav-pills flex-column flex-sm-row">
            <a class="flex-sm-fill text-sm-center nav-link active cari_page_color" aria-current="page"
               id="cari_tanimlari" style="font-weight: bold">MÜŞTERİYE HİZMET TANIMLA</a>
            <a class="flex-sm-fill text-sm-center nav-link cari_page_color" style="font-weight: bold"
               id="cari_alis_irsaliyeleri">MÜŞTERİLERE EK HİZMET TANIMLA</a>
        </nav>
        <div class="hesap_ekstre_genel_main">
            <div class="col-12 row">
                <table class="table table-sm table-bordered w-100  nowrap datatable"
                       style="cursor:pointer;font-size: 13px;"
                       id="cari_free_time_liste">
                    <thead>
                    <tr>
                        <th>Cari Adı</th>
                        <th>Free Time</th>
                        <th>Günlük Ücret</th>
                        <th>Depo Ücreti</th>
                        <th>Konteyner Tipi</th>
                        <th>İşlem</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="diger_tanimlar_page" style="display: none">
            <div class="col-12 row">
                <table class="table table-sm table-bordered w-100  nowrap datatable"
                       style="cursor:pointer;font-size: 13px;"
                       id="diger_tanim_listesi">
                    <thead>
                    <tr>
                        <th>Cari Adı</th>
                        <th id="click9">Hizmet Adı</th>
                        <th>Hizmet Fiyatı</th>
                        <th>Açıklama</th>
                        <th>İşlem</th>
                    </tr>
                    </thead>
                </table>
            </div>
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
        var table = $('#cari_free_time_liste').DataTable({
            scrollX: true,
            scrollY: '45vh',
            "paging": false,
            columns: [
                {"data": "cari_adi"},
                {"data": "free_time"},
                {"data": "gunluk_ucret"},
                {"data": "depo_ucreti"},
                {"data": "konteyner_tipi"},
                {"data": "islem"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find('td').eq(1).css('text-align', 'right');
                $(row).find('td').eq(2).css('text-align', 'right');
                $(row).find('td').eq(3).css('text-align', 'right');
                $(row).find("td").css("text-transform", "uppercase");

            },
            "rowCallback": function (row) {
            },
            order: [[1, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });

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

        var diger_tanim_listesi = $('#diger_tanim_listesi').DataTable({
            scrollX: true,
            scrollY: '45vh',
            "paging": false,
            columns: [
                {"data": "cari_adi"},
                {"data": "hizmet_adi"},
                {"data": "hizmet_fiyati"},
                {"data": "aciklama"},
                {"data": "islem"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find('td').css('text-align', 'left');
                $(row).find('td').eq(2).css('text-align', 'right');
                $(row).find("td").css("text-transform", "uppercase");
            },
            "rowCallback": function (row) {
            },
            order: [[1, 'desc']],
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        });

        $.get("depo/controller/acente_controller/sql.php?islem=acente_tanimlarini_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        });

        $.get("depo/controller/acente_controller/sql.php?islem=acente_ek_hizmetleri_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                diger_tanim_listesi.rows.add(json).draw(false);
            }
        })

    });

    $("body").off("click", "#cari_tanimlari").on("click", "#cari_tanimlari", function () {
        $(".cari_page_color").removeClass("active");
        $(this).addClass("active");
        $(".hesap_ekstre_genel_main").show();
        $(".diger_tanimlar_page").hide();
        $(".paging_ekstre").html("");
    })
    $("body").off("click", "#cari_alis_irsaliyeleri").on("click", "#cari_alis_irsaliyeleri", function () {
        $(".cari_page_color").removeClass("active");
        $(this).addClass("active");
        $(".hesap_ekstre_genel_main").hide();
        $(".diger_tanimlar_page").show();
        setTimeout(function () {
            $("#click9").trigger("click");
        }, 500);
    })


    $("body").off("click", ".tanimlanan_forkliftleri_sil_button").on("click", ".tanimlanan_forkliftleri_sil_button", function () {
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
                        url: "depo/controller/tanim_controller/sql.php?islem=tanimli_forklifti_sil_button",
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
                                        'Adreste Konteyner Bulunuyor Lütfen Önce Konteynerleri Siliniz...',
                                        'warning'
                                    );
                                } else {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Forklift Silindi',
                                        'success'
                                    );
                                    
                                    $.get("depo/view/forklift_tanim.php", function (getList) {
                                        $(".modal-icerik").html(getList);
                                    });
                                    $.get("depo/view/forklift_tanim.php", function (getList) {
                                        $(".admin-modal-icerik").html(getList);
                                    });
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

    $("body").off("click", "#yeni_depo_hizmet_button").on("click", "#yeni_depo_hizmet_button", function () {
        $.get("depo/modals/acente_depo_modal/depo_hizmet_tanimlari.php?islem=yeni_depo_hizmeti_tanim_button", function (getModal) {
            $(".getModals").html(getModal);
        });
    });

</script>