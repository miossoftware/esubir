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
        <div class="ibox-title" style=' font-weight:bold;'>KONTEYNER TANIM</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="konteyner_tanim"><i class="fa fa-plus"></i>
                Konteyner Tanım
            </button>
            <button class="btn btn-info btn-sm" id=""><i
                        class="fa fa-filter"></i> Hazırla
            </button>
        </div>
        <div class="col-12 row mt-5">
            <table class="table table-sm table-bordered w-100  datatable"
                   style="cursor:pointer;font-size: 13px;"
                   id="depo_ihracat_siparis_table">
                <thead>
                <tr>
                    <th>Tarih</th>
                    <th>Tipi</th>
                    <th>Cari Adı</th>
                    <th>Epro Referans</th>
                    <th>Referans No</th>
                    <th>Beyanname No</th>
                    <th>Konteyner No</th>
                    <th>Konteyner Tipi</th>
                    <th>İşlem</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>
    $("body").off("click", "#konteyner_tanim").on("click", "#konteyner_tanim", function () {
        $.get("depo/modals/is_emri_modal/konteyner_tanim.php?islem=konteyner_tanimla_modal",function (getModal){
            $(".getModals").html(getModal);
        })
    })
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
    $(document).ready(function (){
        var targetColumns = [5, 6, 7, 12, 13, 14];
        var table = $('#depo_ihracat_siparis_table').DataTable({
            scrollX: true,
            scrollY: '45vh',
            "paging": false,
            columns: [
                {"data": "tarih"},
                {"data": "tipi"},
                {"data": "cari_adi"},
                {"data": "epro_ref"},
                {"data": "referans_no"},
                {"data": "beyanname_no"},
                {"data": "konteyner_no"},
                {"data": "konteyner_tipi"},
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

        $.get("depo/controller/konteyner_controller/sql.php?islem=tanimlanan_konteynerleri_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        })
    });

    $("body").off("click", ".tanitilan_kont_sil_button").on("click", ".tanitilan_kont_sil_button", function () {
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
                    url: "depo/controller/konteyner_controller/sql.php?islem=tanimlanan_konteyneri_sil_sql",
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
                                    'Araç İşlem Görmüştür Lütfen Önce Araca Ait İşleri Siliniz...',
                                    'warning'
                                );
                            } else {
                                Swal.fire(
                                    'Başarılı!',
                                    'Konteyner Tanım Silindi',
                                    'success'
                                );
                                $.get("depo/view/is_emri_konteyner_tanim.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("depo/view/is_emri_konteyner_tanim.php", function (getList) {
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

    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });

</script>