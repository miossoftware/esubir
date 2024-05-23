<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>BİRİM TANIMLA</div>
    </div>
    <div class="col-12 row">
        <div class="birim_buttons mt-3 mx-3">
            <button class="btn btn-success btn-sm" id="birim_ekle_main"><i class="fa fa-plus-square" aria-hidden="true"></i> Birim Ekle</button>
            <button class="btn  btn-sm" id="birim_guncelle" style="background-color: #F6FA70"><i class="fa fa-refresh" aria-hidden="true"></i> Birim Güncelle</button>
            <button class="btn btn-danger btn-sm" id="birim_sil"><i class="fa fa-trash" aria-hidden="true"></i> Birim Sil</button>
        </div>
        <div class="col-12 row mx-1 mt-3">
            <table class="table table-sm table-bordered w-100  nowrap" id="birim_listesi" style="font-size: 13px;">
                <thead>
                <tr>
                    <th>Birim Adı</th>
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
    $(document).ready(function (){
        var table = $('#birim_listesi').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
            createdRow: function (row,data,dataIndex) {
                $(row).addClass("birim_selected");
                $(row).find("td").css("text-align", "left");
            }
        })
        $.get("controller/birim_controller/sql.php?islem=birim_listesi_getir",function (result){
            if (result != 2){
                var json = JSON.parse(result);
                json.forEach(function (item){
                    var birim_adi = item.birim_adi;
                    var aciklama = item.aciklama;
                    var birim_table = table.row.add([birim_adi.toUpperCase(),aciklama.toUpperCase()]).draw(false).node();
                    $(birim_table).attr("data-id",item.id);
                });
            }
        });
    })

    $("body").off("click", "#birim_guncelle").on("click", "#birim_guncelle", function () {
        var id = $(".select").attr("data-id");
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Kaydı seçiniz',
                'warning'
            );
        } else {
            $.get("modals/birim_modal/modal_page.php?islem=birim_guncelle_modal", {id: id}, function (getModal) {
                $(".getModals").html("");
                $(".getModals").html(getModal);
            })
        }
    });

    $("body").off("click", ".birim_selected").on("click", ".birim_selected", function () {
        $('.birim_selected').css("background-color", "rgb(255, 255, 255)");
        $(this).css("background-color", "#60b3abad");
        $('.birim_selected').removeClass('select');
        $(this).addClass("select");
        $(".select").css("background-color", "#B9EDDD");
    });

    $("body").off("click", "#birim_sil").on("click", "#birim_sil", function () {
        var id = $(".select").attr("data-id");
        if (id == "" || id == undefined) {
            Swal.fire(
                'Uyarı!',
                'Lütfen İşlem Yapmak İstediğiniz Birimi seçiniz',
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
                        url: "controller/birim_controller/sql.php?islem=birim_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Birim Silindi',
                                    'success'
                                );
                                $.get("view/birim_tanim.php", function (getList) {
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

    $("body").off("click","#birim_ekle_main").on("click","#birim_ekle_main",function (){
        $.get("modals/birim_modal/modal.php",function (getModal){
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

</script>