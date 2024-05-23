<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>MODEL LİSTESİ</div>
    </div>
    <div class="col-12 row">
        <div class="cari_buttons mt-3 mx-3">
            <button class="btn btn-success btn-sm" id="model_ekle_main_button"><i class="fa fa-plus-square"
                                                                                  aria-hidden="true"></i> Model Ekle
            </button>
            <button class="btn  btn-sm" id="model_guncelle_main" style="background-color: #F6FA70"><i class="fa fa-refresh" aria-hidden="true"></i> Model Güncelle
            </button>
            <button class="btn btn-danger btn-sm" id="model_sil"><i class="fa fa-trash" aria-hidden="true"></i> Model Sil</button>
        </div>
        <div class="col-12 row mx-1 mt-3">
            <table class="table table-sm table-bordered w-100  nowrap" id="model_listesi_table" style="font-size: 13px;">
                <thead>
                <tr>
                    <th>Marka Adı</th>
                    <th>Model Adı</th>
                    <th>Açıklama</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script>

    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });

    $("body").off("click","#model_guncelle_main").on("click","#model_guncelle_main",function (){
        var id = $(".select").attr("data-id");
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Modeli seçiniz',
                'warning'
            );
        } else {
            $.get("modals/model_modal/modal_page.php?islem=model_guncelle_modal",{id:id},function (getModal){
                $(".getModals").html("");
                $(".getModals").html(getModal);
            })
        }
    });

    $(document).ready(function () {
        var table = $('#model_listesi_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            createdRow: function (row,data,dataIndex) {
                $(row).addClass("model_listesi");
                $(row).find("td").css("text-align", "left");
            }
        })

        $("body").off("click", "#model_sil").on("click", "#model_sil", function () {
            var id = $(".select").attr("data-id");
            if (id == "" || id == undefined) {
                Swal.fire(
                    'Uyarı!',
                    'Lütfen İşlem Yapmak İstediğiniz Modeli seçiniz',
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
                            url: "controller/model_controller/sql.php?islem=model_sil_sql",
                            type: "POST",
                            data: {
                                id: id,
                                delete_detail: delete_detail
                            },
                            success: function (result) {
                                if (result != 2) {
                                    Swal.fire(
                                        'Başarılı!',
                                        'Model Silindi',
                                        'success'
                                    );
                                    $.get("view/model_listesi.php", function (getList) {
                                        $(".modal-icerik").html("");
                                        $(".modal-icerik").html(getList);
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
            }
        });

        $("body").off("click", ".model_listesi").on("click", ".model_listesi", function () {
            $('.model_listesi').css("background-color", "rgb(255, 255, 255)");
            $(this).css("background-color", "#60b3abad");
            $('.model_listesi').removeClass('select');
            $(this).addClass("select");
            $(".select").css("background-color", "#B9EDDD");
        });

        $.get("controller/model_controller/sql.php?islem=modelleri_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                json.forEach(function (item) {
                    var markaId = item.marka_id
                    $.get("controller/model_controller/sql.php?islem=marka_adi_getir", {id: markaId}, function (result2) {
                        if (result2 != 2) {
                            var item2 = JSON.parse(result2);
                            var markaAdi = item2.marka_adi;
                            var modelAdi = item.model_adi;
                            var aciklama = item.aciklama;
                            var model_list = table.row.add([markaAdi.toUpperCase(),modelAdi.toUpperCase(),aciklama.toUpperCase()]).draw(false).node();

                            $(model_list).attr("data-id",item.id);
                        }
                    });
                });
            } else {

            }
        });
    })

    $("body").off("click", "#model_ekle_main_button").on("click", "#model_ekle_main_button", function () {
        $.get("modals/model_modal/modal.php?islem=model_ekle_modal_getir", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });
</script>