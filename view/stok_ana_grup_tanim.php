<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>STOK ANA GRUP TANIMLA</div>
    </div>
    <div class="col-12 row">
        <div class="ana_grup_buttons mt-3 mx-3">
            <button class="btn btn-success btn-sm" id="ana_grup_ekle_modal_button"><i class="fa fa-plus-square"
                                                                                      aria-hidden="true"></i> Ana
                Grup Ekle
            </button>
            <button class="btn  btn-sm" id="ana_grup_guncelle_main" style="background-color: #F6FA70"><i class="fa fa-refresh" aria-hidden="true"></i> Ana Grup
                Güncelle
            </button>
            <button class="btn btn-danger btn-sm" id="ana_grup_sil_button"><i class="fa fa-trash" aria-hidden="true"></i> Ana Grup Sil
            </button>
        </div>
        <div class="col-12 row mx-1 mt-3">
            <table class="table table-sm table-bordered w-100  nowrap" id="ana_grup_listesi" style="font-size: 13px;">
                <thead>
                <tr>
                    <th>Stok Ana Grup Adı</th>
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

    $("body").off("click","#ana_grup_guncelle_main").on("click","#ana_grup_guncelle_main",function (){
        var id = $(".select").attr("data-id");
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Kaydı seçiniz',
                'warning'
            );
        } else {
            $.get("modals/anagrup_modal/modal_page.php?islem=ana_grup_guncelle_modal",{id:id},function (getModal){
                $(".getModals").html("");
                $(".getModals").html(getModal);
            })
        }
    })

    $(document).ready(function () {
        var table = $('#ana_grup_listesi').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            createdRow: function (row,data,dataIndex) {
                $(row).addClass("ana_grup_selected");
                $(row).find("td").css("text-align", "left");
            }
        })

        $("body").off("click", ".ana_grup_selected").on("click", ".ana_grup_selected", function () {
            $('.ana_grup_selected').css("background-color", "rgb(255, 255, 255)");
            $(this).css("background-color", "#60b3abad");
            $('.ana_grup_selected').removeClass('select');
            $(this).addClass("select");
            $(".select").css("background-color", "#B9EDDD");
        });

        $.get("controller/anagrup_controller/sql.php?islem=ana_grup_listesi_getir", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                json.forEach(function (item) {
                    var anaGrupAdi = item.ana_grup_adi;
                    var aciklama = item.aciklama;
                    var ana_grup_list = table.row.add([anaGrupAdi.toUpperCase(),aciklama.toUpperCase()]).draw(false).node();
                    $(ana_grup_list).attr("data-id",item.id);
                });
            }
        });
    })

    $("body").off("click", "#ana_grup_sil_button").on("click", "#ana_grup_sil_button", function () {
        var id = $(".select").attr("data-id");
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Kaydı seçiniz',
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
                        url: "controller/anagrup_controller/sql.php?islem=ana_grup_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Kayıt Silindi',
                                    'success'
                                );
                                $.get("view/stok_ana_grup_tanim.php", function (getList) {
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

    $("body").off("click", "#ana_grup_ekle_modal_button").on("click", "#ana_grup_ekle_modal_button", function () {
        $.get("modals/anagrup_modal/modal.php", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

</script>