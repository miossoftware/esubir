<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>MESLEK TANIMLA</div>
    </div>
    <div class="col-12 row">
        <div class="banka_tanim_button mt-3 mx-3">
            <button class="btn btn-success btn-sm" id="meslek_ekle_modal"><i class="fa fa-plus-square"
                                                                                aria-hidden="true"></i>
                Meslek Ekle
            </button>
        </div>
        <div class="col-12 row mx-1 mt-3">
            <table class="table table-sm table-bordered w-100  nowrap" id="banka_listesi"
                   style="font-size: 13px;">
                <thead>
                <tr>
                    <th>Meslek Adı</th>
                    <th>İşlem</th>
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
    $(document).ready(function () {
        var table = $('#banka_listesi').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            "paging": false,
            bAutoWidth: false,
            aoColumns: [
                {sWidth: '1%'},
                {sWidth: '0%'}
            ],
            createdRow: function (row,data,dataIndex) {
                $(row).addClass("banka_selected");
                
            },
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        })
        $.get("controller/personel_controller/sql.php?islem=meslekleri_getir_sql",function (result){
            if (result != 2){
                var json = JSON.parse(result);
                json.forEach(function (item){
                    var new_row = table.row.add([item.meslek_adi,"<button class='btn btn-danger btn-sm meslek_sil' data-id='"+item.id+"'><i class='fa fa-trash'></i></button>"]).draw(false).node();
                    $(new_row).find("td").eq(0).css("text-align","left");
                    $(new_row).find("td").eq(1).css("text-align","left");
                })
            }
        })
    })

    $("body").off("click",".meslek_sil").on("click",".meslek_sil",function (){
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
                        url: "controller/personel_controller/sql.php?islem=meslek_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Meslek Silindi',
                                    'success'
                                );
                                $.get("view/meslek_tanim.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/meslek_tanim.php", function (getList) {
                                    $(".admin-modal-icerik").html("");
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
        }
    })

    $("body").off("click","#meslek_ekle_modal").on("click","#meslek_ekle_modal",function (){
        $.get("modals/personel_modal/meslek_ekle_modal.php?islem=meslek_ekle_modal_getir",function (getModal){
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    })

</script>