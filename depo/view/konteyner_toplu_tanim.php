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
        <div class="ibox-title" style=' font-weight:bold;'>KONTEYNER TOPLU TANIM</div>
    </div>
    <div class="col-12 row no-gutters">
        <div class="col-md-1 ">
            <input type="text" placeholder="Başlangıç..." id="bas_tarih" onfocus="(this.type='date')"
                   class="form-control form-control-sm bas_tarih_alis">
        </div>
        <div class="col-md-1 mx-2">
            <input type="text" placeholder="Bitiş..." id="bit_tarih" onfocus="(this.type='date')"
                   class="form-control form-control-sm  bit_tarih_alis">
        </div>
        <div class="col-md-2 mx-2">
            <button class="btn btn-secondary btn-sm"><i class="fa fa-filter"></i> Hazırla</button>
            <button class="btn btn-success btn-sm" id="konteyner_toplu_tanim_button"><i class="fa fa-plus-square"></i>
                Toplu Tanım
            </button>
        </div>
    </div>
    <div class="col-12 row mt-2">
        <table class="table table-sm table-bordered w-100  nowrap" id="tanitilan_kont_table"
               style="font-size: 13px;">
            <thead>
            <tr>
                <th>Bildirim Tarihi</th>
                <th>Konteyner No</th>
                <th>Kont. Tipi</th>
                <th>Tipi</th>
                <th>Acenta Adı</th>
                <th>Acenta Kodu</th>
                <th>Açıklama</th>
                <th>İşlem</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        var table = $('#tanitilan_kont_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            dom: "Bfrtip",
            buttons: [
                {
                    extend: 'excel',
                    title: "GELMESİ BEKLENEN TOPLU KONTEYNERLER",
                    text: "<i class='fa fa-download'></i> Excel'e Aktar",
                    className: 'excel_alis', // Sınıfı burada tanımlayabilirsiniz
                }
            ],
            columns: [
                {'data': 'bildirim_tarihi'},
                {'data': 'konteyner_no'},
                {'data': 'konteyner_tipi'},
                {'data': 'tipi'},
                {'data': 'cari_adi'},
                {'data': 'cari_kodu'},
                {'data': 'aciklama'},
                {'data': 'islem'}
            ],
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            createdRow: function (row, data, dataIndex) {
                $(row).addClass("bilanco_selected");
                $(row).find("td").css("text-align", "left");

            }
        });

        $.get("depo/controller/acente_controller/sql.php?islem=tanimli_konteynerleri_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        })

    });

    $("body").off("click", ".acente_tanimli_konteyner_sil_button").on("click", ".acente_tanimli_konteyner_sil_button", function () {
        var id = $(this).attr("data-id");
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
                    url: "depo/controller/acente_controller/sql.php?islem=konteyner_tanim_sil_sql",
                    type: "POST",
                    data: {
                        id: id,
                        delete_detail: delete_detail
                    },
                    success: function (result) {
                        if (result == 1) {
                            Swal.fire(
                                'Başarılı!',
                                'Konteyner Tanımı Silindi',
                                'success'
                            );
                            $.get("depo/view/konteyner_toplu_tanim.php", function (getList) {
                                $(".modal-icerik").html(getList);
                            })
                            $.get("depo/view/konteyner_toplu_tanim.php", function (getList) {
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
    })

    $("body").off("click", "#konteyner_toplu_tanim_button").on("click", "#konteyner_toplu_tanim_button", function () {
        $.get("depo/modals/acente_depo_modal/konteyner_tanim.php?islem=konteyner_tanimla_modal", function (getModal) {
            $(".getModals").html(getModal);
        })
    });

</script>