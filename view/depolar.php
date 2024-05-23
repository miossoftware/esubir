<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>DEPO TANIMLA</div>
    </div>
    <div class="col-12 row">
        <div class="depolar_buttons mt-3 mx-3">
            <button class="btn btn-success btn-sm" id="depo_ekle_button_main"><i class="fa fa-plus-square"
                                                                                 aria-hidden="true"></i> Depo Ekle
            </button>
            <button class="btn  btn-sm" id="depo_guncelle_model" style="background-color: #F6FA70"><i class="fa fa-refresh" aria-hidden="true"></i> Depo Güncelle
            </button>
            <button class="btn btn-danger btn-sm" id="depo_sil_button"><i class="fa fa-trash" aria-hidden="true"></i> Depo Sil</button>
        </div>
        <div class="col-12 row mx-1 mt-3">
            <table class="table table-sm table-bordered w-100  nowrap" id="depo_listesi" style="font-size: 13px;">
                <thead>
                <tr>
                    <th>Depo Adı</th>
                    <th>Adresi</th>
                    <th>Açıklama</th>
                    <th>Varsayılan</th>
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

    $("body").off("click", "#depo_guncelle_model").on("click", "#depo_guncelle_model", function () {
        var id = $(".select").attr("data-id");
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Depoyu seçiniz',
                'warning'
            );
        } else {
            $.get("modals/depo_modal/modal_page.php?islem=depo_bilgi_guncelle_modal",{id:id},function (getModal){
                $(".getModals").html("");
                $(".getModals").html(getModal);
            })
        }
    });

    $("body").off("click", "#depo_sil_button").on("click", "#depo_sil_button", function () {
        var id = $(".select").attr("data-id");
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Depoyu seçiniz',
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
                        url: "controller/depo_controller/sql.php?islem=depo_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Depo Silindi',
                                    'success'
                                );
                                $.get("view/depolar.php", function (getList) {
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

    $("body").off("click", ".depo_selected").on("click", ".depo_selected", function () {
        $('.depo_selected').css("background-color", "rgb(255, 255, 255)");
        $(this).css("background-color", "#60b3abad");
        $('.depo_selected').removeClass('select');
        $(this).addClass("select");
        $(".select").css("background-color", "#B9EDDD");
    });

    $(document).ready(function () {
        var table = $('#depo_listesi').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            "paging": false,
            createdRow: function (row,data,dataIndex) {
                $(row).addClass("depo_selected");
                $(row).find("td").css("text-align", "left");
            },
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        })
        $.get("controller/depo_controller/sql.php?islem=depolari_getir", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                json.forEach(function (item) {
                    var depo_adi = item.depo_adi;
                    var adresi = item.adres;
                    var aciklama = item.aciklama;
                    var varsayilanDepo = item.varsayilan_depo;
                    var varsayilan_cikti = "";
                    if (varsayilanDepo == 1) {
                        varsayilan_cikti = "checked"
                    } else {
                        varsayilan_cikti = ""
                    }
                    var depo_list = table.row.add([depo_adi.toUpperCase(), adresi.toUpperCase(), aciklama.toUpperCase(), "<input type='checkbox' class='col-8'" + varsayilan_cikti + " disabled>"]).draw(false).node();
                    $(depo_list).attr("data-id",item.id);
                });
            }
        })
    })
    $("body").off("click", "#depo_ekle_button_main").on("click", "#depo_ekle_button_main", function () {
        $.get("modals/depo_modal/modal.php?islem=yeni_depo_ekle", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    })
</script>