<style>
    .edit_list td{
        text-align: left;
    }
</style>
<div class="ibox-container">
    <div class="ibox mt-5">
        <div class="ibox-head">
            <div class="ibox-title" style=' font-weight:bold;'>CARİ EKLE</div>
        </div>
        <div class="col-12 row">
            <div class="cari_buttons mt-3 mx-3">
                <button class="btn btn-success btn-sm" id="cari_ekle_main"><i class="fa fa-plus-square"
                                                                              aria-hidden="true"></i> Cari Ekle
                </button>
                <button class="btn  btn-sm" id="cari_guncelle_main" style="background-color: #F6FA70"><i
                            class="fa fa-refresh"
                            aria-hidden="true"></i> Cari Güncelle
                </button>
                <button class="btn btn-danger btn-sm" id="cari_sil"><i class="fa fa-trash" aria-hidden="true"></i> Cari
                    Sil
                </button>
            </div>
            <div class="col-12 row mx-1 mt-3">
                <table class="table table-sm table-bordered w-100 nowrap edit_list"
                       style="cursor:pointer;font-size: 13px;"
                       id="cari_table">
                    <thead>
                    <tr>
                        <th style="width: 1% !important;">Cari Türü</th>
                        <th>Cari Kodu</th>
                        <th>Cari Ünvanı</th>
                        <th>Vergi Dairesi</th>
                        <th>Vergi No</th>
                        <th>Bilanço Kodu</th>
                        <th>Cari Grubu</th>
                        <th>Vade Günü</th>
                        <th>Telefon</th>
                        <th>E Posta</th>
                        <th>Yetkili Adı</th>
                        <th>Yetkili Tel</th>
                        <th>Yetkili Mail</th>
                        <th style="width: 1px !important;">İl</th>
                        <th>Adres</th>
                        <th>Banka Adı</th>
                        <th>Banka Şube Adı</th>
                        <th>IBAN No</th>
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

    $("body").off("click", "#cari_guncelle_main").on("click", "#cari_guncelle_main", function () {
        var cari_kodu = $(".select").find("td").eq(1).html();
        if (cari_kodu == "" || cari_kodu == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Cariyi seçiniz',
                'warning'
            );
        } else {
            $.get("modals/cari_modal/modal_page.php?islem=cari_guncelle", {cari_kodu: cari_kodu}, function (getModal) {
                $(".getModals").html("");
                $(".getModals").html(getModal);
            })
        }
    });


    $("body").off("click", "#cari_sil").on("click", "#cari_sil", function () {
        var cari_kodu = $(".select").find("td").eq(1).html();
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
                        url: "controller/cari_controller/sql.php?islem=cariyi_sil_sql",
                        type: "POST",
                        data: {
                            cari_kodu: cari_kodu,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                if (result == 300){
                                    Swal.fire(
                                        'Uyarı!',
                                        'Cariye Ait Hareket Bulunmaktadır Lütfen Öncelikli Olarak Hareketleri Siliniz...',
                                        'warning'
                                    );
                                }else {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Cari Silindi',
                                        'success'
                                    );
                                    $.get("view/add_cari_page.php", function (getList) {
                                        $(".modal-icerik").html("");
                                        $(".modal-icerik").html(getList);
                                    })
                                    $.get("view/add_cari_page.php", function (getList) {
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

    $("body").off("click", ".list_selected").on("click", ".list_selected", function () {
        $('.list_selected').css("background-color", "rgb(255, 255, 255)");
        $(this).css("background-color", "#60b3abad");
        $('.list_selected').removeClass('select');
        $(this).addClass("select");
        $(".select").css("background-color", "#B9EDDD");
    });

    $(document).ready(function () {
        var table = $('#cari_table').DataTable({
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            scrollX: true,
            paging:false,
            autoWidth:false,
            scrollY:"55vh",
            order:[1,"asc"],
            "initComplete": function() {
                $('#cari_table').addClass('myCustomStyle');
            },
            columns: [
                {"data": "cari_turu"},
                {"data": "cari_kodu"},
                {"data": "cari_adi"},
                {"data": "vergi_dairesi"},
                {"data": "vergi_no"},
                {"data": "bilanco_kodu"},
                {"data": "cari_grubu"},
                {"data": "vade_gunu"},
                {"data": "telefon"},
                {"data": "e_mail"},
                {"data": "yetkili_adi1"},
                {"data": "yetkili_tel1"},
                {"data": "yetkili_mail1"},
                {"data": "il_adi"},
                {"data": "cari_adres"},
                {"data": "banka_adi"},
                {"data": "banka_sube"},
                {"data": "iban_no"}
            ],
            createdRow: function (row,data,dataIndex) {
                $(row).addClass("list_selected");
                $(row).find("td").css("text-transform","uppercase")
            }
        })

        $.get("controller/cari_controller/sql.php?islem=cari_bilgilerini_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                table.rows.add(json).draw(false);
            }
        })

    });

    $("body").off("click", "#cari_ekle_main").on("click", "#cari_ekle_main", function () {
        $.get("modals/cari_modal/modal.php?islem=cari_ekle_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    })
</script>