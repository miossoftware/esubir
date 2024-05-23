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
        <div class="ibox-title" style=' font-weight:bold;'>ÇEK GİRİŞ BORDROSU</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="alinan_cek_senetler_girisi"><i class="fa fa-plus"></i> Alınan
                Çekler Girişi
            </button>
            <button class="btn btn-info btn-sm" id="cek_senet_giris_hazirla_buton"><i
                        class="fa fa-filter"></i> Hazırla
            </button>
        </div>
        <div class="col-12 row">
            <div class="col-12 row mx-1 mt-3">
                <div class="col-md-3 row">

                    <input type="text" placeholder="Başlangıç Tarihi" id="bas_tarih_cek_senet"
                           onfocus="(this.type='date')"
                           class="form-control form-control-sm">
                    <input type="text" placeholder="Bitiş Tarihi" id="bit_tarih_cek_senet" onfocus="(this.type='date')"
                           class="form-control form-control-sm mt-2">
                </div>
            </div>
        </div>
        <div class="col-12 row mt-3">
            <table class="table table-sm table-bordered w-100  nowrap" style="cursor:pointer;font-size: 13px;"
                   id="cek_senet_giris_table">
                <thead>
                <tr>
                    <th>Bordro No</th>
                    <th>Cari</th>
                    <th>Bordro Tarih</th>
                    <th>Tutar</th>
                    <th>Ort. Vade</th>
                    <th>Ort. Gün</th>
                    <th>Döviz</th>
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

    $("body").off("click", "#alinan_cek_senetler_girisi").on("click", "#alinan_cek_senetler_girisi", function () {
        $.get("modals/cek_senet_modal/alinan_cek_senet.php?islem=yeni_alinan_cek_senet_olustur", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click",".ana_sayfadan_cek_senet_guncelle_button").on("click",".ana_sayfadan_cek_senet_guncelle_button",function (){
        let id = $(this).attr("data-id");
        $.get("modals/cek_senet_modal/alinan_cek_senet_page.php?islem=cek_senet_guncelle_modal_getir",{id:id},function (getModal){
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

    $(document).ready(function () {
        var targetColumns = [3];
        jQuery.extend(jQuery.fn.dataTableExt.oSort, {
            "date-eu-pre": function (dateString) {
                var parts = dateString.split('/');
                return Date.parse(parts[2] + '/' + parts[1] + '/' + parts[0]) || 0;
            },

            "date-eu-asc": function (a, b) {
                return ((a < b) ? -1 : ((a > b) ? 1 : 0));
            },

            "date-eu-desc": function (a, b) {
                return ((a < b) ? 1 : ((a > b) ? -1 : 0));
            }
        });
        var table = $('#cek_senet_giris_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            "order": [[2, 'desc']],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "ÇEK GİRİŞ BORDROLARI",
                    text: "<i class='fa fa-download'></i> Excel'e Aktar",
                    className: 'excel_alis', // Sınıfı burada tanımlayabilirsiniz
                    customizeData: function (excelData) {
                        // Özel veri dönüşümü ve formatlamaları yapabilirsiniz
                        // excelData, dışa aktarılacak Excel verilerini temsil eder

                        // Örneğin, her hücreyi sayı olarak biçimlendirme
                        for (var rowIdx = 0; rowIdx < excelData.body.length; rowIdx++) {
                            var rowData = excelData.body[rowIdx];
                            for (var cellIdx = 0; cellIdx < rowData.length; cellIdx++) {
                                var cellValue = excelData.body[rowIdx][cellIdx];
                                if (typeof cellValue === 'string') {
                                    if (targetColumns.includes(cellIdx)) {
                                        var parsedValue = parseFloat(cellValue.replace('.', '').replace(',', '.').replace(/\s/g, ''));
                                        if (!isNaN(parsedValue)) {
                                            excelData.body[rowIdx][cellIdx] = parsedValue.toLocaleString("en-US", {
                                                maximumFractionDigits: 2,
                                                minimumFractionDigits: 2
                                            });
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            ],
            columnDefs: [
                {targets: 2, type: "date-eu"}
            ],
            columns: [
                {"data": "belge_no"},
                {"data": "cari_adi"},
                {"data": "tarih"},
                {"data": "tutar"},
                {"data": "ort_vade"},
                {"data": "ort_gun"},
                {"data": "doviz_tur"},
                {"data": "button"}
            ],
            createdRow: function (row,data,dataIndex) {
                $(row).find('td').eq(0).css('text-align', 'left');
                $(row).find('td').eq(1).css('text-align', 'left');
                $(row).find('td').eq(2).css('text-align', 'left');
                $(row).find('td').eq(4).css('text-align', 'left');
                $(row).find('td').eq(5).css('text-align', 'left');
                $(row).find('td').eq(6).css('text-align', 'left');
                
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        })

        $("body").off("click", "#cek_senet_giris_hazirla_buton").on("click", "#cek_senet_giris_hazirla_buton", function () {
            let bas_tarih = $("#bas_tarih_cek_senet").val();
            let bit_tarih = $("#bit_tarih_cek_senet").val();
            $.get("controller/cek_senet_controller/sql.php?islem=tum_cek_ve_senetleri_getir_sql",
                {
                    bas_tarih: bas_tarih,
                    bit_tarih: bit_tarih
                }
                , function (result) {
                    if (result != 2) {
                        var json = JSON.parse(result);
                        let basilacak_arr = [];
                        table.clear().draw(false);
                        json.forEach(function (item) {
                            let tarih = item.tarih;
                            tarih = tarih.split(" ");
                            tarih = tarih[0];
                            tarih = tarih.split("-");
                            let gun = tarih[2];
                            let ay = tarih[1];
                            let yil = tarih[0];
                            let arr = [gun, ay, yil];
                            tarih = arr.join("/");

                            let ortVade = item.ort_vade;
                            ortVade = ortVade.split(" ");
                            ortVade = ortVade[0];
                            ortVade = ortVade.split("-");
                            let gun1 = ortVade[2];
                            let ay1 = ortVade[1];
                            let yil1 = ortVade[0];
                            let arr1 = [gun1, ay1, yil1];
                            ortVade = arr1.join("/");

                            let tutar = item.tutar;
                            tutar = parseFloat(tutar);
                            tutar = tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            let newRecord = {
                                'belge_no': item.belge_no,
                                'cari_adi': item.cari_adi,
                                'tarih': tarih,
                                'tutar': tutar,
                                'ort_vade': ortVade,
                                'ort_gun': item.ort_gun,
                                'doviz_tur': item.doviz_tur,
                                'button': "<button class='btn btn-sm ana_sayfadan_cek_senet_guncelle_button' data-id='"+item.id+"' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm ana_sayfadan_cek_senet_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                            };
                            basilacak_arr.push(newRecord);
                        })
                        table.rows.add(basilacak_arr).draw(false);
                    } else {
                        table.clear().draw(false);
                    }
                })
        });

        $.get("controller/cek_senet_controller/sql.php?islem=tum_cek_ve_senetleri_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                let basilacak_arr = [];
                json.forEach(function (item) {
                    let tarih = item.tarih;
                    tarih = tarih.split(" ");
                    tarih = tarih[0];
                    tarih = tarih.split("-");
                    let gun = tarih[2];
                    let ay = tarih[1];
                    let yil = tarih[0];
                    let arr = [gun, ay, yil];
                    tarih = arr.join("/");

                    let ortVade = item.ort_vade;
                    ortVade = ortVade.split(" ");
                    ortVade = ortVade[0];
                    ortVade = ortVade.split("-");
                    let gun1 = ortVade[2];
                    let ay1 = ortVade[1];
                    let yil1 = ortVade[0];
                    let arr1 = [gun1, ay1, yil1];
                    ortVade = arr1.join("/");

                    let tutar = item.tutar;
                    tutar = parseFloat(tutar);
                    tutar = tutar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    let newRecord = {
                        'belge_no': item.belge_no,
                        'cari_adi': item.cari_adi,
                        'tarih': tarih,
                        'tutar': tutar,
                        'ort_vade': ortVade,
                        'ort_gun': item.ort_gun,
                        'doviz_tur': item.doviz_tur,
                        'button': "<button class='btn btn-sm ana_sayfadan_cek_senet_guncelle_button' data-id='"+item.id+"' style='background-color: #F6FA70'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm ana_sayfadan_cek_senet_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                    };
                    basilacak_arr.push(newRecord);
                })
                table.rows.add(basilacak_arr).draw(false);
            }
        })
    });

    $("body").off("click", ".ana_sayfadan_cek_senet_sil").on("click", ".ana_sayfadan_cek_senet_sil", function () {
        let id = $(this).attr("data-id");
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
                        url: "controller/cek_senet_controller/sql.php?islem=cek_senet_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Çek Girişi Silindi',
                                    'success'
                                );
                                $.get("view/cek_senet_giris_bordrosu.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/cek_senet_giris_bordrosu.php", function (getList) {
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

</script>