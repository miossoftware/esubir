<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>KREDİ KARTI AÇILIŞ FİŞLERİ</div>
    </div>
    <div class="col-12 row mt-3">
        <div class="col-3">
            <button class="btn btn-success btn-sm" id="kredi_karti_acilis_fisi_ekle"><i class="fa fa-plus"></i> Kredi
                Kartı Açılış Fişi
            </button>
        </div>
    </div>
    <div class="col-12 row">
        <table class="table table-sm table-bordered w-100  nowrap" id="kart_acilis_table" style="font-size: 13px;">
            <thead>
            <tr>
                <th>Tarih</th>
                <th>Kart Kodu</th>
                <th>Kart Adı</th>
                <th>Borç</th>
                <th>Alacak</th>
                <th>Açıklama</th>
                <th style="padding: 0px !important;">İşlem</th>
            </tr>
            </thead>
            <tfoot style="background-color: white">
            <th></th>
            <th></th>
            <th></th>
            <th style="text-align: right" class="ka_borc">0,00</th>
            <th style="text-align: right" class="ka_alacak">0,00</th>
            <th></th>
            <th></th>
            </tfoot>
        </table>
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
        var table = $('#kart_acilis_table').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            bAutoWidth: false,
            "order": [[0, 'desc']],
            columnDefs: [
                {targets: 0, type: "date-eu"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).addClass("stok_list_selected");
                $(row).find("td").css("text-align", "left");
                $(row).find("td").eq(3).css("text-align", "right");
                $(row).find("td").eq(4).css("text-align", "right");
            },
            columns: [
                {'data': 'tarih'},
                {'data': 'kart_kodu'},
                {'data': 'kart_adi'},
                {'data': 'borc'},
                {'data': 'alacak'},
                {'data': 'aciklama'},
                {'data': 'islem'},
            ],
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"},
        });
        $.get("controller/kart_controller/sql.php?islem=kredi_kart_acilislari_getir_sql", function (res) {
            if (res != 2) {
                var json = JSON.parse(res);
                let ka_borc = 0;
                let ka_alacak = 0;
                let basilacak_arr = [];
                json.forEach(function (item) {
                    let tarih = item.acilis_tarihi;
                    if (tarih == null) {

                    } else {
                        tarih = tarih.split("-");
                        let g = tarih[2];
                        let a = tarih[1];
                        let y = tarih[0];
                        let arr = [g, a, y];
                        tarih = arr.join("/");
                    }
                    let borc = item.borc;
                    borc = parseFloat(borc);
                    ka_borc += borc;
                    borc = borc.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                    let alacak = item.alacak;
                    alacak = parseFloat(alacak);
                    ka_alacak += alacak;
                    alacak = alacak.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                    let newRow = {
                        tarih:tarih,
                        kart_kodu:item.kart_kodu,
                        kart_adi:item.kart_adi,
                        borc:borc,
                        alacak:alacak,
                        aciklama:item.aciklama,
                        islem:"<button class='btn btn-danger btn-sm kart_acilis_sil' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                    };
                    basilacak_arr.push(newRow);
                });
                $(".ka_borc").html(ka_borc.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }))
                $(".ka_alacak").html(ka_alacak.toLocaleString("tr-TR", {
                    maximumFractionDigits: 2,
                    minimumFractionDigits: 2
                }))
                table.rows.add(basilacak_arr).draw(false);
            }
        })

    });

    $("body").off("click", "#kredi_karti_acilis_fisi_ekle").on("click", "#kredi_karti_acilis_fisi_ekle", function () {
        $.get("modals/kredi_kart_modal/kart_acilis.php?islem=kredi_karti_acilis_fisi_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });

    $("body").off("click", ".kart_acilis_sil").on("click", ".kart_acilis_sil", function () {
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
                        url: "controller/kart_controller/sql.php?islem=kart_acilis_sil_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Açılış Fişi Silindi',
                                    'success'
                                );
                                $.get("view/kredi_kart_acilis_fisi.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/kredi_kart_acilis_fisi.php", function (getList) {
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

</script>