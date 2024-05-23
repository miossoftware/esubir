<style>
    .edit_list td {
        text-align: left;
    }
</style>
<div class="ibox-container">
    <div class="ibox mt-5">
        <div class="ibox-head">
            <div class="ibox-title" style=' font-weight:bold;'>BİNEK ARAÇ TANIM</div>
        </div>
        <div class="col-12 row">
            <div class="cari_buttons mt-3 mx-3">
                <button class="btn btn-success btn-sm" id="tasit_kart_tanim"><i class="fa fa-plus-square"
                                                                                aria-hidden="true"></i> Araç
                    Tanımla
                </button>
            </div>
            <div class="col-12 row mx-1 mt-3">
                <table class="table table-sm table-bordered w-100  nowrap edit_list"
                       style="cursor:pointer;font-size: 13px;"
                       id="arac_table">
                    <thead>
                    <tr>
                        <th>Plaka</th>
                        <th>Sürücü</th>
                        <th>Marka</th>
                        <th>Model</th>
                        <th>Model Yılı</th>
                        <th>Yakıt Tipi</th>
                        <th>Ehliyet No</th>
                        <th>Güncel KM</th>
                        <th>Muayene Tarihi</th>
                        <th>HGS No</th>
                        <th>Fiyat</th>
                        <th>İşlem</th>
                    </tr>
                    </thead>
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

    $("body").off("click", ".list_selected").on("click", ".list_selected", function () {
        $('.list_selected').css("background-color", "rgb(255, 255, 255)");
        $(this).css("background-color", "#60b3abad");
        $('.list_selected').removeClass('select');
        $(this).addClass("select");
        $(".select").css("background-color", "#B9EDDD");
    });

    $(document).ready(function () {
        var table = $('#arac_table').DataTable({
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            scrollX: true,
            scrollY: "55vh",
            paging: false,
            "initComplete": function () {
                $('#arac_table').addClass('myCustomStyle');
            },
            columns: [
                {"data": "arac_plaka"},
                {"data": "surucu_adi"},
                {"data": "marka_adi"},
                {"data": "model_adi"},
                {"data": "model_yili"},
                {"data": "yakit_tipi"},
                {"data": "ehliyet_no"},
                {"data": "guncel_km"},
                {"data": "muayene_tarihi"},
                {"data": "hgs_no"},
                {"data": "degeri"},
                {"data": "islem"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).find("td").css("text-transform", "uppercase");
                $(row).find("td").css("text-align", "left");
                $(row).find("td").eq(7).css("text-align", "right")
                $(row).find("td").eq(10).css("text-align", "right")
            }
        })
        $.get("controller/arac_controller/sql.php?islem=binekleri_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                table.rows.add(json).draw(false);
            }
        })
    });


    $("body").off("click", ".binek_guncelle_button").on("click", ".binek_guncelle_button", function () {
        let id = $(this).attr("data-id");
        $.get("modals/arac_modal/modal.php?islem=yeni_arac_guncelle_modal", {id: id}, function (getModal) {
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".binek_kartlari_sil_button").on("click", ".binek_kartlari_sil_button", function () {
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
                        url: "controller/arac_controller/sql.php?islem=binek_arac_sil_sql",
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
                                        'Araca Ait Hareket Bulunmaktadır Lütfen Öncelikli Olarak Hareketleri Siliniz...',
                                        'warning'
                                    );
                                } else {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Araç Sillindi',
                                        'success'
                                    );
                                    $.get("view/binek_arac_tanim.php", function (getList) {
                                        $(".modal-icerik").html("");
                                        $(".modal-icerik").html(getList);
                                    });
                                    $.get("view/binek_arac_tanim.php", function (getList) {
                                        $(".admin-modal-icerik").html("");
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

    $("body").off("click", "#tasit_kart_tanim").on("click", "#tasit_kart_tanim", function () {
        $.get("modals/arac_modal/modal.php?islem=yeni_arac_tanimla_modal", function (getModal) {
            $(".getModals").html(getModal);
        })
    });

</script>