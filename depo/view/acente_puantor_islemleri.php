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
        <div class="ibox-title" style=' font-weight:bold;'>ACENTE ESTİMATE İŞLEMLERİ</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="acente_estimate_is_basi_button"><i class="fa fa-plus"></i>
                İş Ata
            </button>
            <button class="btn btn-success btn-sm" id="acente_ek_hizmet_ekle_button"><i class="fa fa-plus"></i>
                Ek Hizmet Ekle
            </button>
            <button class="btn btn-info btn-sm" id=""><i
                        class="fa fa-filter"></i> Hazırla
            </button>
        </div>
        <div class="col-12 row">
            <table class="table table-sm table-bordered w-100 nowrap datatable"
                   style="cursor:pointer;font-size: 13px;"
                   id="estimate_isleri_liste">
                <thead>
                <tr>
                    <th style=""></th>
                    <th>Acente Adı</th>
                    <th>Konteyner No</th>
                    <th>Konteyner Tipi</th>
                    <th>Hasar Açıklaması</th>
                    <th>İş Başı</th>
                    <th>İş Bitimi</th>
                    <th>Durumu</th>
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
        var table = $('#estimate_isleri_liste').DataTable({
            scrollX: true,
            scrollY: '45vh',
            "paging": false,
            columns: [
                {"data": "ek_hizmet"},
                {"data": "acente_adi"},
                {"data": "konteyner_no"},
                {"data": "konteyner_tipi"},
                {"data": "hasar_aciklamasi"},
                {"data": "is_basi"},
                {"data": "is_bitis_saat"},
                {"data": "durumu"},
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

        $.get("depo/controller/acente_controller/sql.php?islem=estimate_is_basi_yapilanlari_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        })

        function formatHiddenRow(data) {
            let renk_kodu = " background-color:#DDF7E3;";

            var html = '<tr class="hidden-row" style="text-align: left;' + renk_kodu + '">';
            html += '<td>HİZMET ADI:</td>';
            html += '<td style="text-align: left">' + data.ek_hizmet_adi + '</td>';
            html += '</tr>';
            return html;
        }


        $("body").off("click", ".estimate_hizmetleri_getir_button").on("click", ".estimate_hizmetleri_getir_button", function () {
            let konteyner_id = $(this).attr("data-id");
            var tr = $(this).closest("tr");
            var row = table.row(tr);
            $.get("depo/controller/acente_controller/sql.php?islem=estimate_hizmet_getir_sql", {konteyner_id: konteyner_id}, function (res) {
                if (res != 2) {
                    var json = JSON.parse(res);
                    if (row.child.isShown()) {
                        // Gizli satır zaten açıksa kapat
                        row.child.hide();
                        tr.removeClass('shown');
                    } else {
                        var html = "";
                        for (var i = 0; i < json.length; i++) {
                            html += formatHiddenRow(json[i]);
                        }
                        row.child(html).show();
                        tr.addClass('shown');
                    }
                }
            })
        });

        $("body").off("click", ".acente_estimate_islem_guncelle_button").on("click", ".acente_estimate_islem_guncelle_button", function () {
            let id = $(this).attr("data-id");
            $.get("depo/modals/acente_depo_modal/estimate_is_basi.php?islem=estimate_is_basi_guncelle_modal", {id: id}, function (getModal) {
                $(".getModals").html(getModal);
            })
        })
    });

    $("body").off("click", "#acente_estimate_is_basi_button").on("click", "#acente_estimate_is_basi_button", function () {
        $.get("depo/modals/acente_depo_modal/estimate_is_basi.php?islem=estimate_is_baslat_modal", function (getModal) {
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", "#acente_ek_hizmet_ekle_button").on("click", "#acente_ek_hizmet_ekle_button", function () {
        $.get("depo/modals/acente_depo_modal/estimate_is_basi.php?islem=acente_ek_hizmet_ekle_button", function (getModal) {
            $(".getModals").html(getModal);
        })
    });


    $("body").off("click", ".estimate_is_basi_sil_button").on("click", ".estimate_is_basi_sil_button", function () {
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
                        url: "depo/controller/acente_controller/sql.php?islem=estimate_sil_main_sql",
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
                                        'Bu İşlem Bitmiştir Silemezsiniz...',
                                        'warning'
                                    );
                                } else {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Estimate İş Başı Silindi',
                                        'success'
                                    );
                                    $.get("depo/view/acente_puantor_islemleri.php", function (getList) {
                                        $(".modal-icerik").html(getList);
                                    });
                                    $.get("depo/view/acente_puantor_islemleri.php", function (getList) {
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

    $("body").off("click", ".is_bitir_main_button").on("click", ".is_bitir_main_button", function () {
        var id = $(this).attr("data-id");
        $.ajax({
            url: "depo/controller/acente_controller/sql.php?islem=isi_tamamen_bitir_sql",
            type: "POST",
            data: {
                id: id
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
                            'Estimate İşi Bitirildi',
                            'success'
                        );
                        $.get("depo/view/acente_puantor_islemleri.php", function (getList) {
                            $(".modal-icerik").html("");
                            $(".modal-icerik").html(getList);
                        })
                        $.get("depo/view/acente_puantor_islemleri.php", function (getList) {
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
    });

</script>