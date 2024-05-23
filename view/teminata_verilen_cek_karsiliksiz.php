<div class="ibox mt-5">
    <div class="ibox-head">
        <div class="ibox-title" style=' font-weight:bold;'>TEMİNATA VERİLEN KARŞILIKSIZ ÇEKLER</div>
    </div>
    <div class="col-12 row">
        <div class="mx-2">
            <button class="btn btn-success btn-sm" id="teminata_verilen_cek_karsiliksiz_olustur"><i
                        class="fa fa-plus"></i>
                Karşılıksız Çek Oluştur
            </button>
            <button class="btn btn-info btn-sm" id=""><i
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
                   id="ciro_edilen_karsiliksiz_cekler">
                <thead>
                <tr>
                    <th>Fiş No</th>
                    <th>Tarih</th>
                    <th>Cari Adı</th>
                    <th>Tutar</th>
                    <th>Vadesi</th>
                    <th>Adet</th>
                    <th>Cari Sorumlusu</th>
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

        var table = $('#ciro_edilen_karsiliksiz_cekler').DataTable({
            scrollY: '55vh',
            scrollX: true,
            "info": false,
            "order": [[1, 'desc']],
            columnDefs: [
                {targets: 1, type: "date-eu"}
            ],
            columns: [
                {"data": "fis_no"},
                {"data": "kayit_tarihi"},
                {"data": "banka_adi"},
                {"data": "fiyat"},
                {"data": "vadesi"},
                {"data": "adet"},
                {"data": "sorumlusu"},
                {"data": "button"}
            ],
            createdRow: function (row, data, dataIndex) {
                $(row).addClass("list_selected");
                $(row).find("td").css("text-transform", "uppercase")
                $(row).find("td").eq(0).css("text-align", "left");
                $(row).find("td").eq(1).css("text-align", "left");
                $(row).find("td").eq(2).css("text-align", "left");
                $(row).find("td").eq(6).css("text-align", "left");
                $(row).find("td").eq(4).css("text-align", "left");
            },
            "paging": false,
            "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
        })
        $.get("controller/cek_senet_controller/sql.php?islem=karsiliksiz_teminata_verilen_cekleri_getir", function (result) {
            if (result != 2) {
                var json = JSON.parse(result);
                let basilacak_arr = [];
                json.forEach(function (item) {
                    let kayit_tarihi = item.karsiliksiz_tarih;
                    kayit_tarihi = kayit_tarihi.split(" ");
                    kayit_tarihi = kayit_tarihi[0];
                    kayit_tarihi = kayit_tarihi.split("-");
                    let gun = kayit_tarihi[2];
                    let ay = kayit_tarihi[1];
                    let yil = kayit_tarihi[0];
                    let arr = [gun, ay, yil];
                    kayit_tarihi = arr.join("/");
                    let vade_tarih = item.vade_tarih;
                    vade_tarih = vade_tarih.split(" ");
                    vade_tarih = vade_tarih[0];
                    vade_tarih = vade_tarih.split("-");
                    let gun2 = vade_tarih[2];
                    let ay2 = vade_tarih[1];
                    let yil2 = vade_tarih[0];
                    let arr2 = [gun2, ay2, yil2];
                    vade_tarih = arr2.join("/");
                    let fiyat = item.girilen_tutar;
                    fiyat = parseFloat(fiyat);
                    fiyat = fiyat.toLocaleString("tr-TR", {maximumFractionDigits: 2, minimumFractionDigits: 2});
                    let newRecord = {
                        'fis_no': item.seri_no,
                        'kayit_tarihi': kayit_tarihi,
                        'banka_adi': item.cari_adi,
                        'fiyat': fiyat,
                        'vadesi': vade_tarih,
                        'adet': "1,00",
                        'sorumlusu': item.yetkili_adi1,
                        'button': "<button class='btn btn-danger btn-sm teminata_verilen_cek_karsiliksiz_iptali' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>",
                    };
                    basilacak_arr.push(newRecord);
                })
                table.rows.add(basilacak_arr).draw(false);
            }
        })
    });

    $("body").off("click", ".teminata_verilen_cek_karsiliksiz_iptali").on("click", ".teminata_verilen_cek_karsiliksiz_iptali", function () {
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
                        url: "controller/cek_senet_controller/sql.php?islem=karsiliksiz_cek_iptal_et_sql",
                        type: "POST",
                        data: {
                            id: id,
                            delete_detail: delete_detail
                        },
                        success: function (result) {
                            if (result != 2) {
                                Swal.fire(
                                    'Başarılı!',
                                    'Karşılıksız Çek Silindi',
                                    'success'
                                );
                                $.get("view/teminata_verilen_cek_karsiliksiz.php", function (getList) {
                                    $(".modal-icerik").html("");
                                    $(".modal-icerik").html(getList);
                                })
                                $.get("view/teminata_verilen_cek_karsiliksiz.php", function (getList) {
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

    $("body").off("click", "#teminata_verilen_cek_karsiliksiz_olustur").on("click", "#teminata_verilen_cek_karsiliksiz_olustur", function () {
        $.get("modals/karsiliksiz_cek_modal/modal.php?islem=teminata_verilen_cekleri_getir_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        })
    });
</script>