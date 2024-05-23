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
        <div class="ibox-title" style=' font-weight:bold;'>HAVALE GİRİŞ</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="havale_giris_main"><i class="fa fa-plus"></i> Yeni
                Havale Girişi
            </button>
            <button class="btn btn-info btn-sm" id="havale_giris_filtrele"><i
                        class="fa fa-filter"></i> Hazırla
            </button>
        </div>
        <div class="col-12 row">
            <div class="col-12 row mx-1 mt-3">
                <div class="col-md-3 row">

                    <input type="text" placeholder="Başlangıç Tarihi" id="bas_tarih" onfocus="(this.type='date')"
                           class="form-control form-control-sm bas_tarih_havale">
                    <input type="text" placeholder="Bitiş Tarihi" id="bit_tarih" onfocus="(this.type='date')"
                           class="form-control form-control-sm mt-2 bit_tarih_havale">
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 row mt-3">
        <table class="table table-sm table-bordered w-100  nowrap" style="cursor:pointer;font-size: 13px;"
               id="havale_giris_table">
            <thead>
            <tr>
                <th>İşlem Tarihi</th>
                <th>Banka Kodu</th>
                <th>Banka Adı</th>
                <th>Fiş No</th>
                <th>Açıklama</th>
                <th>Toplam Tutar</th>
                <th>İşlem</th>
            </tr>
            </thead>
        </table>
    </div>
    <div class="col-12 row no-gutters mt-1">
        <div class="col-12 row mt-2 no-gutters">
            <div class="col-3"></div>
            <div class="col-md-1">
                <table class="table table-sm table-bordered display" style="background-color: white">
                    <tr>
                        <th>Döviz Türü</th>
                    </tr>
                    <tr>
                        <th>TL</th>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-sm table-bordered w-100 display nowrap" style="background-color: white">
                    <thead>
                    <tr>
                        <th style="text-align: center">Toplam Giriş</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="giris_tl" style="text-align: right;font-weight: bold;">0,00 TL</td>
                    </tr>
                    </tbody>
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
    $(document).ready(function () {
        var targetColumns = [5];
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
        var table = $('#havale_giris_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            "order": [[0, 'desc']],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: "HAVALE GİRİŞ LİSTESİ",
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
                { targets: 0, type: "date-eu" }
            ],
            columns: [
                {"data": "islem_tarihi"},
                {"data": "banka_kodu"},
                {"data": "banka_adi"},
                {"data": "belge_no"},
                {"data": "aciklama"},
                {"data": "giris_toplam"},
                {"data": "button"}
            ],
            createdRow: function (row,data,dataIndex) {
                $(row).addClass("list_selected");
                $(row).find('td').eq(0).css('text-align', 'left');
                $(row).find('td').eq(1).css('text-align', 'left');
                $(row).find('td').eq(2).css('text-align', 'left');
                $(row).find('td').eq(3).css('text-align', 'left');
                $(row).find('td').eq(4).css('text-align', 'left');
                
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        })

        $.get("controller/banka_controller/sql.php?islem=banka_havale_girisleri_getir_sql", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                let giris = 0;

                var basilacak_arr = [];
                json.forEach(function (item) {

                    var islemTarihi = item.islem_tarihi;
                    if (islemTarihi == ""){

                    }else {
                        var explode = islemTarihi.split(" ");
                        var explode_cikti = explode[0];
                        var explode_2 = explode_cikti.split("-");
                        var gun = explode_2[2];
                        var ay = explode_2[1];
                        var yil = explode_2[0];
                        var arr = [gun, ay, yil];
                        islemTarihi = arr.join("/");
                    }


                    var giris_toplam = item.giris_toplam;
                    giris_toplam = parseFloat(giris_toplam);
                    giris += giris_toplam;
                    giris_toplam = giris_toplam.toLocaleString('tr-TR', {minimumFractionDigits: 2, maximumFractionDigits: 2});

                    let newRecord = {
                        'islem_tarihi':islemTarihi,
                        'banka_kodu':item.banka_kodu,
                        'banka_adi':item.banka_adi,
                        'belge_no':item.belge_no,
                        'aciklama':item.aciklama,
                        'giris_toplam':giris_toplam+" "+item.doviz_tipi,
                        'button':"<button class='btn  btn-sm havale_giris_detay_modal' style='background-color: #F6FA70' data-id='" + item.id + "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm havale_giris_sil_main' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                    };
                    basilacak_arr.push(newRecord)
                });
                table.rows.add(basilacak_arr).draw(false);
                giris = giris.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                $(".giris_tl").html("");
                $(".giris_tl").html(giris);
            }
        })

        $("body").off("click","#havale_giris_filtrele").on("click","#havale_giris_filtrele",function (){
            let bas_tarih = $(".bas_tarih_havale").val();
            let bit_tarih = $(".bit_tarih_havale").val();
            $.get("controller/banka_controller/sql.php?islem=banka_havale_girisleri_getir_sql",
                {
                    bas_tarih:bas_tarih,
                    bit_tarih:bit_tarih
                }
                , function (result) {
                table.clear().draw(false);
                if (result != 2) {
                    var json = JSON.parse(result);
                    let giris = 0;
                    var basilacak_arr = [];
                    table.clear().draw(false);
                    json.forEach(function (item) {

                        var islemTarihi = item.islem_tarihi;
                        var explode = islemTarihi.split(" ");
                        var explode_cikti = explode[0];
                        var explode_2 = explode_cikti.split("-");
                        var gun = explode_2[2];
                        var ay = explode_2[1];
                        var yil = explode_2[0];
                        var arr = [gun, ay, yil];
                        var islem_tarihi = arr.join("/");

                        var giris_toplam = item.giris_toplam;
                        giris_toplam = parseFloat(giris_toplam);
                        giris += giris_toplam;
                        giris_toplam = giris_toplam.toLocaleString('tr-TR', {minimumFractionDigits: 2, maximumFractionDigits: 2});

                        let newRecord = {
                            'islem_tarihi':islem_tarihi,
                            'banka_kodu':item.banka_kodu,
                            'banka_adi':item.banka_adi,
                            'belge_no':item.belge_no,
                            'aciklama':item.aciklama,
                            'giris_toplam':giris_toplam,
                            'button':"<button class='btn  btn-sm havale_giris_detay_modal' style='background-color: #F6FA70' data-id='" + item.id + "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm havale_giris_sil_main' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                        };
                        basilacak_arr.push(newRecord)
                    });
                    table.rows.add(basilacak_arr).draw(false);
                    giris = giris.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    $(".giris_tl").html("");
                    $(".giris_tl").html(giris);
                }
            })
        });

    })

    $("body").off("click", ".havale_giris_detay_modal").on("click", ".havale_giris_detay_modal", function () {
        var id = $(this).attr("data-id");
        $.get("modals/banka_modal/havale_giris_detay.php?islem=havale_giris_detay_goster_modal", {id: id}, function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".havale_giris_sil_main").on("click", ".havale_giris_sil_main", function () {
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
                        url: "controller/banka_controller/sql.php?islem=giris_iptal_et_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Havale Girişi Silindi',
                                    'success'
                                );
                                $.get("view/havale_giris.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/havale_giris.php", function (getList) {
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

    $("body").off("click", "#havale_giris_main").on("click", "#havale_giris_main", function () {
        $.get("modals/banka_modal/havale_giris_modal.php?islem=yeni_havale_giris_ekle", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });


</script>