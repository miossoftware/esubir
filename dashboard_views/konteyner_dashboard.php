<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-success color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong" id="konteyner_siparisler">0</h2>
                    <div class="m-b-5">SİPARİŞLER</div>
                    <i class="fa fa-shopping-basket widget-stat-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-info color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong" id="haftalik_sefer">0</h2>
                    <div class="m-b-5">HAFTALIK SEFER</div>
                    <i class="fa fa-road widget-stat-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-warning color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong" id="ozmal_ciro">0,00</h2>
                    <div class="m-b-5">ÖZ MAL CİRO</div>
                    <i class="fa fa-turkish-lira widget-stat-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-danger color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong" id="kiralik_ciro">0,00</h2>
                    <div class="m-b-5">KİRALIK CİRO</div>
                    <i class="fa fa-turkish-lira widget-stat-icon"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-success color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong" id="aylik_yakit_ort">0,00</h2>
                    <div class="m-b-5">AYLIK YAKIT ORTALAMASI</div>
                    <i class="fa fa-tachometer widget-stat-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-info color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong" id="muayenesi_yaklasanlar">0</h2>
                    <div class="m-b-5">MUAYENESİ YAKLAŞAN ARAÇLAR</div>
                    <i class="fa fa-truck widget-stat-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-warning color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong" id="sigortasi_yaklasanlar">0</h2>
                    <div class="m-b-5">SİGORTASI YAKLAŞAN ARAÇLAR</div>
                    <i class="fa fa-truck widget-stat-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="ibox bg-danger color-white widget-stat">
                <div class="ibox-body">
                    <h2 class="m-b-5 font-strong" id="yarinki_sevkiyat">0</h2>
                    <div class="m-b-5">YARINKİ SEVKİYAT</div>
                    <i class="fa fa-cubes widget-stat-icon"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6" style="background-color: oldlace">
        <center><span>AYLIK CİRO</span></center>
        <canvas id="aylik_sefer_sayi"></canvas>
    </div>
    <div class="col-lg-6" style="background-color: oldlace;">
        <center><span>AYLIK SEFER</span></center>
        <canvas id="oz_mal_kiralik"></canvas>
        <!--                   BURDAKAİ CANVASI TEKRARDAN GÖZDEN GEÇİR ÇOK ÇİRKİN DURDU-->
    </div>
</div>
<div class="row" style="background-color: oldlace">
    <div class="col-12 row mt-3">
        <table class="table table-bordered" style="cursor:pointer;font-size: 13px;background-color: white"
               id="konteyner_siparis_main_list">
            <thead>
            <tr>
                <th>Sipariş No</th>
                <th>Sipariş Tarihi</th>
                <th>Müşteri Adı</th>
                <th>Tipi</th>
                <th>Yükleme Tarihi</th>
                <th>Güzergah</th>
                <th>İl</th>
                <th>Konteyner No</th>
                <th>Referans No</th>
                <th>Alım Yeri</th>
                <th>İhracat Firması</th>
                <th>Konteyner Tipi</th>
                <th>Acenta</th>
                <th>Açıklama</th>
                <th>Aktarma Plaka</th>
                <th>Aktarma Sürücü</th>
                <th>Plaka No</th>
                <th>Dorse Plaka</th>
                <th>Sürücü</th>
                <th>Yükleme Adres</th>
                <th>Durum</th>
                <th>İptal Sebebi</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    $.get("konteyner/controller/ekstre_controller/sql.php?islem=konteyner_dashboard_sql",function (res){
        if (res != 2){
            var item = JSON.parse(res);
            $("#konteyner_siparisler").html(item.toplam_siparis);
            $("#haftalik_sefer").html(item.haftalik_sefer);
            $("#yarinki_sevkiyat").html(item.yarinki_sevkiyat);
            $("#aylik_yakit_ort").html(item.yakit_tuketim);
            $("#muayenesi_yaklasanlar").html(item.muayenesi_yaklasanlar);
            $("#sigortasi_yaklasanlar").html(item.sigortasi_yaklasanlar);
            $("#ozmal_ciro").html(item.ozmal_gelirleri);
            $("#kiralik_ciro").html(item.kiralik_gelirleri);
        }
    })

    $.get("konteyner/controller/ekstre_controller/sql.php?islem=konteyner_dashboard_grafikler", function(res) {
        try {
            var json = JSON.parse(res);
            if (json) {
                for (var key in json) {
                    if (json.hasOwnProperty(key) && key !== 'toplam_ciro') {
                        json[key] = parseFloat(json[key]);
                    }
                }

                // Toplam ciro dizisini al
                var toplamCiroArray = json['toplam_ciro'];

                // Grafik oluştur
                var ctx = document.getElementById('aylik_sefer_sayi').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(toplamCiroArray),
                        datasets: [{
                            label: 'Aylık Sefer Sayısı',
                            data: Object.values(toplamCiroArray),
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                var ctx2 = document.getElementById('oz_mal_kiralik').getContext('2d');
                var myChart2 = new Chart(ctx2, {
                    type: 'doughnut',
                    data: {
                        labels: ['Öz Mal', 'Kiralık'],
                        datasets: [{
                            data: [json["ozmal_sefer"], json["kiralik_sefer"]],
                            backgroundColor: ['#F99417', "#64CCC5"]
                        }]
                    }
                });
            } else {
                console.error("JSON parse hatası: Veri boş veya geçersiz.");
            }
        } catch (e) {
            console.error("Bir hata oluştu: " + e.message);
        }
    });

    var table = $("#konteyner_siparis_main_list").DataTable({
        scrollY: '55vh',
        scrollX: true,
        "order": [[4, 'asc']],
        columnDefs: [
            {targets: 0, type: "date-eu"}
        ],
        columns: [
            {"data": "siparis_no"},
            {"data": "siparis_tarihi"},
            {"data": "musteri_adi"},
            {"data": "tipi"},
            {"data": "yukleme_tarihi"},
            {"data": "guzergah"},
            {"data": "yukleme_il"},
            {"data": "konteyner_no"},
            {"data": "referans_no"},
            {"data": "alim_yeri_main"},
            {"data": "alim_yeri"},
            {"data": "konteyner_tipi"},
            {"data": "hat_acenta"},
            {"data": "aciklama"},
            {"data": "aktarma_plaka"},
            {"data": "aktarma_surucu"},
            {"data": "plaka_no"},
            {"data": "dorse_plaka"},
            {"data": "surucu_adi"},
            {"data": "yukleme_adres"},
            {"data": "durum"},
            {"data": "iptal_sebebi"}
        ],
        createdRow: function (row, data, dataIndex) {
            $(row).find('td').css('text-align', 'left');

        },
        "paging": false,
        "language": {"url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json"}
    });
    $.get("konteyner/controller/siparis_controller/sql.php?islem=siparisleri_getir_sql", function (response) {
        if (response != 2) {
            var json = JSON.parse(response);
            var basilacak_arr = [];

            json.forEach(function (item) {
                let siparis_tarihi = item.siparis_tarihi;
                siparis_tarihi = siparis_tarihi.split(" ");
                siparis_tarihi = siparis_tarihi[0];
                siparis_tarihi = siparis_tarihi.split("-");
                let gun1 = siparis_tarihi[2];
                let ay1 = siparis_tarihi[1];
                let yil1 = siparis_tarihi[0];
                let arr3 = [gun1, ay1, yil1];
                siparis_tarihi = arr3.join("/");

                let yukleme_tarihi = item.yukleme_tarihi;
                yukleme_tarihi = yukleme_tarihi.split(" ");
                let saati = yukleme_tarihi[1];
                yukleme_tarihi = yukleme_tarihi[0];
                yukleme_tarihi = yukleme_tarihi.split("-");
                let gun = yukleme_tarihi[2];
                let ay = yukleme_tarihi[1];
                let yil = yukleme_tarihi[0];
                let arr = [gun, ay, yil];
                let yeni = arr.join("/");
                yukleme_tarihi = yeni + " " + saati
                let durum = "";
                if (item.siparis_durum == 1) {
                    durum = "Bekliyor";
                } else if (item.siparis_durum == 2) {
                    durum = "İrsaliyesi Kesildi";
                } else {
                    durum = "İptal Edildi";
                }
                let konteyner_no = "";
                let konteyner_harf = item.konteyner_no_harf;
                let konteyner_rakam1 = item.konteyner_no_rakam1;
                let konteyner_rakam = item.konteyner_no;
                konteyner_no = konteyner_harf + " " + konteyner_rakam1 + "-" + konteyner_rakam;

                let tipi = "";
                if (item.tipi == 1) {
                    tipi = "İhracat";
                } else if (item.tipi == 2) {
                    tipi = "İthalat";
                } else if (item.tipi == 3) {
                    tipi = "Kargo";
                }

                let konteyner_tipi = "";

                if (item.konteyner_tipi == 1) {
                    konteyner_tipi = "20 DC";
                } else if (item.konteyner_tipi == 2) {
                    konteyner_tipi = "40 DC";
                } else if (item.konteyner_tipi == 3) {
                    konteyner_tipi = "20 OT";
                } else if (item.konteyner_tipi == 4) {
                    konteyner_tipi = "40 OT";
                } else if (item.konteyner_tipi == 5) {
                    konteyner_tipi = "20 RF";
                } else if (item.konteyner_tipi == 6) {
                    konteyner_tipi = "40 RF";
                } else if (item.konteyner_tipi == 7) {
                    konteyner_tipi = "40 HC RF";
                } else if (item.konteyner_tipi == 8) {
                    konteyner_tipi = "40 HC";
                } else if (item.konteyner_tipi == 9) {
                    konteyner_tipi = "20 TANK";
                } else if (item.konteyner_tipi == 10) {
                    konteyner_tipi = "20 VENTİLATED";
                } else if (item.konteyner_tipi == 11) {
                    konteyner_tipi = "40 HC PAL. WIDE";
                } else if (item.konteyner_tipi == 12) {
                    konteyner_tipi = "20 FLAT";
                } else if (item.konteyner_tipi == 13) {
                    konteyner_tipi = "40 FLAT";
                } else if (item.konteyner_tipi == 14) {
                    konteyner_tipi = "40 HC FLAT";
                } else if (item.konteyner_tipi == 15) {
                    konteyner_tipi = "20 PLATFORM";
                } else if (item.konteyner_tipi == 16) {
                    konteyner_tipi = "40 PLATFORM";
                } else if (item.konteyner_tipi == 17) {
                    konteyner_tipi = "45 HC";
                } else if (item.konteyner_tipi == 18) {
                    konteyner_tipi = "KARGO";
                }


                let newRow = {
                    siparis_no: item.siparis_no,
                    siparis_tarihi: siparis_tarihi,
                    musteri_kodu: item.musteri_kodu,
                    musteri_adi: item.musteri_unvani,
                    tipi: tipi,
                    yukleme_tarihi: yukleme_tarihi,
                    guzergah: item.guzergah_adi,
                    konteyner_no: konteyner_no,
                    referans_no: item.referans_no,
                    konteyner_tipi: konteyner_tipi,
                    aktarma_plaka: item.aktarma_plaka_no,
                    aktarma_surucu: item.aktarma_surucu,
                    yukleme_il: item.yukleme_il,
                    plaka_no: item.tasima_plaka_no,
                    dorse_plaka: item.dorse_adi,
                    surucu_adi: item.surucu_adi,
                    hat_acenta: item.hat_acenta,
                    yukleme_firmasi: item.yukleme_firmasi,
                    alim_yeri_main: item.alim_yeri_main,
                    alim_yeri: item.alim_yeri,
                    yukleme_adres: item.yukleme_adres,
                    aciklama: item.siparis_aciklama,
                    durum: durum,
                    iptal_sebebi: item.silme_nedeni,
                    button: "<button class='btn btn-secondary btn-sm siparis_guncelle_main_button' data-id='" + item.id + "'><i class='fa fa-eye'></i></button> <button class='btn btn-danger btn-sm konteyner_siparis_iptali_main' data-id='" + item.id + "'><i class='fa fa-trash'></i></button>"
                };
                basilacak_arr.push(newRow);
            });
            table.rows.add(basilacak_arr).draw(false);
        }
    })
</script>