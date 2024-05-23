<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>STOK SAYIM FAZLASI</div>
    </div>
    <div class="col-12 row ">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="yeni_stok_sayim_fazlasi"><i class="fa fa-plus"></i> Yeni Stok
                Fazlas
            </button>
        </div>
    </div>
    <div class="col-md-12 row">
        <div class="col-md-12 row">
            <table class="table table-sm table-bordered w-100  nowrap" id="stok_table" style="font-size: 13px;">
                <thead>
                <tr>
                    <th>Tarih</th>
                    <th>Stok Kodu</th>
                    <th>Stok Adı</th>
                    <th>Fazla Miktar</th>
                    <th>Birim Fiyat</th>
                    <th>Fazla Tutar</th>
                    <th>Açıklama</th>
                    <th>İşlem</th>
                </tr>
                </thead>
                <tfoot style="background-color: white">
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align: right" class="fazla_miktar">0,00</th>
                <th></th>
                <th style="text-align: right" class="fazla_tutari">0,00</th>
                <th></th>
                <th></th>
                </tfoot>
                <tbody id="stok_listesi">
                </tbody>
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
        var table = $('#stok_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            createdRow: function (row, data, dataIndex) {
                $(row).addClass("stok_list_selected");
                $(row).find('td').eq(0).css('text-align', 'left');
                $(row).find('td').eq(1).css('text-align', 'left');
                $(row).find('td').eq(2).css('text-align', 'left');
                $(row).find('td').eq(6).css('text-align', 'left');
            },
            "order": [[0, 'desc']],
            columnDefs: [
                {targets: 0, type: "date-eu"}
            ],
            columns: [
                {'data': 'tarih'},
                {'data': 'stok_kodu'},
                {'data': 'stok_adi'},
                {'data': 'miktar'},
                {'data': 'birim_fiyat'},
                {'data': 'ara_total'},
                {'data': 'aciklama'},
                {'data': 'islem'}
            ],
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });
        $.get("controller/stok_controller/sql.php?islem=sayim_fazlalarini_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                let basilacak_arr = [];
                let fazla_miktar = 0;
                let fazla_tutari = 0;
                json.forEach(function (item) {
                    let tarih = item.tarih;
                    tarih = tarih.split("-");
                    let g = tarih[2];
                    let a = tarih[1];
                    let y = tarih[0];
                    let arr = [g, a, y];
                    tarih = arr.join("/");

                    let miktar = item.miktar;
                    miktar = parseFloat(miktar);
                    fazla_miktar += miktar;
                    let birim_fiyat = item.birim_fiyat;
                    birim_fiyat = parseFloat(birim_fiyat);
                    let ara_total = birim_fiyat * miktar;
                    fazla_tutari += ara_total;
                    birim_fiyat = birim_fiyat.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    ara_total = ara_total.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    miktar = miktar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});

                    let newRow = {
                        tarih: tarih,
                        islem: "<button class='btn btn-sm stok_sayim_faszlasi_guncelle_button' style='background-color: #F6FA70' data-id='" + item.id + "'><i class='fa fa-refresh'></i></button> <button class='btn btn-danger btn-sm stok_sayim_fazlasi_sil_button' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>",
                        stok_kodu: item.stok_kodu,
                        stok_adi: item.stok_adi,
                        miktar: miktar,
                        birim_fiyat: birim_fiyat,
                        ara_total: ara_total,
                        aciklama: item.aciklama
                    };
                    basilacak_arr.push(newRow);
                })
                $(".fazla_tutari").html(fazla_tutari.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }))
                $(".fazla_miktar").html(fazla_miktar.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }))
                table.rows.add(basilacak_arr).draw(false);
            }
        })
    });

    $("body").off("click", ".stok_sayim_faszlasi_guncelle_button").on("click", ".stok_sayim_faszlasi_guncelle_button", function () {
        let id = $(this).attr("data-id");
        $.get("modals/stok_modal/sayim_fazlasi_modal.php?islem=sayim_fazlasi_guncelle_modal_getir", {id: id}, function (getModal) {
            $(".getModals").html(getModal);
        })
    })

    $("body").off("click", ".stok_sayim_fazlasi_sil_button").on("click", ".stok_sayim_fazlasi_sil_button", function () {
        let id = $(this).attr("data-id");
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
                        url: "controller/stok_controller/sql.php?islem=sayim_fazlasi_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Stok Fire Başarı İle Silindi',
                                    'success'
                                );
                                $.get("view/stok_sayim_fazlasi.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/stok_sayim_fazlasi.php", function (getList) {
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

    $("body").off("click", "#yeni_stok_sayim_fazlasi").on("click", "#yeni_stok_sayim_fazlasi", function () {
        $.get("modals/stok_modal/sayim_fazlasi_modal.php?islem=sayim_fazlasi_ekle_modal_getir", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });
</script>