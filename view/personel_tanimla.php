<style>
    .excel_alis {
        background-color: #2ecc71 !important;
        border-color: #27ad60 !important;
        color: white !important;
        border-radius: 20px !important;
        font-weight: bold !important;
    }
</style>
<div class="ibox mt-4">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>PERSONEL TANIMLA</div>
    </div>
    <div class="col-12 ">
        <div class="col-md-2">
            <button class="btn btn-success btn-sm" id="personel_tanim_main"><i class="fa fa-plus"></i> Personel Tanımla</button>
        </div>
    </div>
    <div class="col-12 row mt-3">
        <table class="table table-sm table-bordered w-100  nowrap" style="cursor:pointer;font-size: 13px;"
               id="personeller_table">
            <thead>
            <tr>
                <th>Ad Soyad</th>
                <th>Ünvanı</th>
                <th>Tc Kimlik</th>
                <th>Departman</th>
                <th>Mesleği</th>
                <th>Eğitim Durumu</th>
                <th>Personel Tipi</th>
                <th>İşe Başlama Tarih</th>
                <th>İşlem</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<script>

    $("body").off("click", "tr").on("click", "tr", function () {
        $('tr').removeClass('selected');
        $(this).addClass("selected");
    });

    $(document).ready(function (){
        var table = $('#personeller_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            createdRow: function (row,data,dataIndex) {
            },
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "Personel Listesi",
                    text: "<i class='fa fa-download'></i> Excel'e Aktar",
                    className: 'excel_alis', // Sınıfı burada tanımlayabilirsiniz
                }
            ],
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        });
        $.get("controller/personel_controller/sql.php?islem=personelleri_getir_sql",function (result){
            if (result != 2){
                var json = JSON.parse(result);
                json.forEach(function (item){
                    let gonderilen_tarih = item.is_basi_tarih1;
                    gonderilen_tarih = gonderilen_tarih.split(" ");
                    gonderilen_tarih = gonderilen_tarih[0];
                    gonderilen_tarih = gonderilen_tarih.split("-");
                    var gun = gonderilen_tarih[2];
                    var ay = gonderilen_tarih[1];
                    var yil = gonderilen_tarih[0];
                    var arr = [gun, ay, yil];
                    gonderilen_tarih = arr.join("/");
                    var new_row = "";
                    if (item.status == 1){
                        new_row = table.row.add([item.ad_soyad,item.gorev_adi,item.tc_no,item.departman_adi,item.meslek_adi,item.egitim_durumu,item.personel_tipi,gonderilen_tarih,"<button class='btn btn-sm personel_bilgileri_goruntule' style='background-color: #F6FA70;' data-id='"+item.id+"'><i class='fa fa-eye'></i></button> <button class='btn btn-danger btn-sm personel_sil' data-id='"+item.id+"'><i class='fa fa-close'></i> Pasif Et</button>"]).draw(false).node();
                    }else {
                        new_row = table.row.add([item.ad_soyad,item.gorev_adi,item.tc_no,item.departman_adi,item.meslek_adi,item.egitim_durumu,item.personel_tipi,gonderilen_tarih,"<button class='btn btn-sm personel_bilgileri_goruntule' style='background-color: #F6FA70;' data-id='"+item.id+"'><i class='fa fa-eye'></i></button> <button class='btn btn-success btn-sm personel_aktif' data-id='"+item.id+"'><i class='fa fa-check'></i> Aktif Et</button>"]).draw(false).node();
                    }
                    $(new_row).find('td').eq(0).css('text-align', 'left');
                    $(new_row).find('td').eq(1).css('text-align', 'left');
                    $(new_row).find('td').eq(2).css('text-align', 'left');
                    $(new_row).find('td').eq(3).css('text-align', 'left');
                    $(new_row).find('td').eq(4).css('text-align', 'left');
                    $(new_row).find('td').eq(5).css('text-align', 'left');
                    $(new_row).find('td').eq(6).css('text-align', 'left');
                    $(new_row).find('td').eq(7).css('text-align', 'left');
                });
            }
        })
    });
    $("body").off("click",".personel_aktif").on("click",".personel_aktif",function (){
        var id = $(this).attr("data-id");
        $.ajax({
            url:"controller/personel_controller/sql.php?islem=personel_aktif_et_sql",
            type:"POST",
            data: {
                id:id
            },
            success:function (result){
                if (result == 1){
                    Swal.fire(
                        'Başarılı!',
                        'Personel Aktif Edildi',
                        'success'
                    );
                    $.get("view/personel_tanimla.php", function (getList) {
                        $(".modal-icerik").html("");
                        $(".modal-icerik").html(getList);
                    })
                    $.get("view/personel_tanimla.php", function (getList) {
                        $(".admin-modal-icerik").html("");
                        $(".admin-modal-icerik").html(getList);
                    })
                }
            }
        })
    })

    $("body").off("click",".personel_bilgileri_goruntule").on("click",".personel_bilgileri_goruntule",function (){
        var id = $(this).attr("data-id");
        $.get("modals/personel_modal/modal_page.php?islem=personel_guncelle_modal",{id:id},function (getModal){
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    })

    $("body").off("click",".personel_sil").on("click",".personel_sil",function (){
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
                        url: "controller/personel_controller/sql.php?islem=personel_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Personel Pasif Edildi',
                                    'success'
                                );
                                $.get("view/personel_tanimla.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/personel_tanimla.php", function (getList) {
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
    });

    $("body").off("click","#personel_tanim_main").on("click","#personel_tanim_main",function (){
        $.get("modals/personel_modal/modal.php?islem=yeni_personel_tanimla",function (getModal){
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

</script>