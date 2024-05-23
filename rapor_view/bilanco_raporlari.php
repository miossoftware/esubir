<style>
    table {
        border-collapse: collapse; /* Tablo hücreleri arasındaki boşluğu kaldırır */
        width: 100%; /* Tabloyu tam ekran genişliğinde yapar (isteğe bağlı) */
    }


    th {
        background-color: #f2f2f2; /* Başlık hücrelerine arka plan rengi ekler (isteğe bağlı) */
    }

    .custom-div {
        position: absolute;
        bottom: 3vh;
        left: 0;
        right: 0;
        padding: 15px;
        transform: translateY(50%);
    }
</style>
<div class="ibox-container">
    <div class="cari_getir_div_ekstre"></div>
    <div class="ibox mt-5">
        <div class="ibox-head">
            <div class="ibox-title" style=' font-weight:bold;'>GENEL DURUM BİLANÇOSU</div>
        </div>
        <div class="col-12 row no-gutters">
            <div class="col-md-1 mx-2">
                <select class="custom-select custom-select-sm" id="secilen_ay">
                    <option value="01">OCAK</option>
                    <option value="02">ŞUBAT</option>
                    <option value="03">MART</option>
                    <option value="04">NİSAN</option>
                    <option value="05">MAYIS</option>
                    <option value="06">HAZİRAN</option>
                    <option value="07">TEMMUZ</option>
                    <option value="08">AĞUSTOS</option>
                    <option value="09">EYLÜL</option>
                    <option value="10">EKİM</option>
                    <option value="11">KASIM</option>
                    <option value="12">ARALIK</option>
                </select>
            </div>
            <div class="col-md-1 mx-2">
                <select class="custom-select custom-select-sm" id="secilen_yil">
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>
                    <option value="2031">2031</option>
                    <option value="2032">2032</option>
                    <option value="2033">2033</option>
                    <option value="2034">2034</option>
                    <option value="2035">2035</option>
                    <option value="2036">2036</option>
                    <option value="2037">2037</option>
                    <option value="2038">2038</option>
                    <option value="2039">2039</option>
                    <option value="2040">2040</option>
                </select>
            </div>
            <div class="col-md-2 mx-2">
                <button class="btn btn-secondary btn-sm" id="bilanco_filtrele_button"><i
                            class="fa fa-filter"></i> Hazırla
                </button>
            </div>
        </div>
        <div class="col-12 row mt-5">
            <div class="col-md-6">
                <nav class="nav nav-pills flex-column flex-sm-row">
                    <a class="flex-sm-fill text-sm-center nav-link active"
                       aria-current="page"
                       id="">AKTİF VARLIKLAR</a>
                </nav>
                <table class="table table-sm" style="width: 100%">
                    <tbody>
                    <tr>
                        <td style="font-weight: bold;background-color: #9DB2BF;color: #374f65;text-align: left">DÖNEN
                            VARLIKLAR
                        </td>
                        <td style="background-color: #9DB2BF"></td>
                        <td style="background-color: #374f65;color: white;text-align: right" id="donen_varliklar_total">
                            13.000.000,00 ₺
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left">KASALAR</td>
                        <td style="text-align: right" id="kasalar_bilanco_total"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="text-align: left">BANKALAR</td>
                        <td style="text-align: right" id="bankalar_toplam">13.000.000,00 ₺</td>
                    </tr>
                    <tr>
                        <td style="text-align: left">ALINAN ÇEKLER</td>
                        <td style="text-align: right" id="alinan_cekler_toplami"></td>
                    </tr>
                    <tr>
                        <td style="text-align: left">MÜŞTERİLER</td>
                        <td style="text-align: right" id="musteri_total">13.000.000,00 ₺</td>
                    </tr>
                    <tr>
                        <td style="text-align: left">ALACAK SENETLERİ</td>
                        <td style="text-align: right" id="alinan_senetler_total">13.000.000,00 ₺</td>
                    </tr>
                    <tr>
                        <td style="text-align: left">EMTİA (STOKLAR)</td>
                        <td style="text-align: right" id="emtia_stok_total">13.000.000,00 ₺</td>
                    </tr>
                    <tr>
                        <td style="text-align: left">PERSONEL AVANSLARI</td>
                        <td style="text-align: right" id="personel_avanslari_total">13.000.000,00 ₺</td>
                    </tr>
                    <tr>
                        <td style="text-align: left">DİĞER VARLIKLAR</td>
                        <td style="text-align: right" id="diger_varlik_total">13.000.000,00 ₺</td>
                    </tr>
                    <tr>
                        <td style="text-align: left">SATICILARA VERİLEN AVANSLAR</td>
                        <td style="text-align: right" id="saticilara_verilen_avanslar_total">13.000.000,00 ₺</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;background-color: #9DB2BF;color: #374f65;text-align: left">DURAN
                            VARLIKLAR
                        </td>
                        <td style="background-color: #9DB2BF"></td>
                        <td style="background-color: #374f65;color: white;text-align: right" id="duran_varliklar_total">
                            13.000.000,00 ₺
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left;">&nbsp;DEMİRBAŞLAR</td>
                        <td style="text-align: right" id="demirbaslar_total">13.000.000,00</td>
                    </tr>
                    <tr>
                        <td style="text-align: left">&nbsp;MAKİNE VE EKİPMAN</td>
                        <td style="text-align: right" id="makine_ekipman_total">13.000.000,00</td>
                    </tr>
                    <tr>
                        <td style="text-align: left">&nbsp;TAŞITLAR</td>
                        <td style="text-align: right" id="tasitlar_total">13.000.000,00</td>
                    </tr>
                    <tr>
                        <td style="text-align: left">&nbsp;BİNALAR,ARAZİ VE ARSALAR</td>
                        <td style="text-align: right" id="bina_arazi_total">13.000.000,00</td>
                    </tr>
                    </tbody>
                </table>
                <div class="mt-2"></div>
            </div>
            <div class="col-md-6">
                <nav class="nav nav-pills flex-column flex-sm-row">
                    <a class="flex-sm-fill text-sm-center nav-link active"
                       aria-current="page"
                       id="">PASİF VARLIKLAR</a>
                </nav>
                <table class="table table-sm" style="width: 100%;">
                    <tbody>
                    <tr>
                        <td style="font-weight: bold;background-color: #9DB2BF;color: #374f65;text-align: left">CARİ
                            DÖNEM BORÇLARI
                        </td>
                        <td style="background-color: #9DB2BF"></td>
                        <td style="background-color: #374f65;color: white;text-align: right" id="donem_borclar_totali">
                            13.000.000,00 ₺
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: left;width: 67% !important;">&nbsp;SATICILAR</td>
                        <td id="saticilar_total">13.000.000,00 ₺</td>
                    </tr>
                    <tr>
                        <td style="text-align: left">&nbsp;VERİLEN ÇEKLER</td>
                        <td id="verilen_cek_total">13.000.000,00 ₺</td>
                    </tr>
                    <tr>
                        <td style="text-align: left">&nbsp;VERİLEN SENETLER</td>
                        <td id="verilen_senetler_total">13.000.000,00 ₺</td>
                    </tr>
                    <tr>
                        <td style="text-align: left">&nbsp;KREDİLER</td>
                        <td id="krediler_total">13.000.000,00 ₺</td>
                    </tr>
                    <tr>
                        <td style="text-align: left">&nbsp;DİĞER BORÇLAR</td>
                        <td id="diger_borclar_toplam">13.000.000,00 ₺</td>
                    </tr>
                    <tr>
                        <td style="text-align: left">&nbsp;ÖDENECEK VERGİ VS.</td>
                        <td id="odenecek_vergi_vs_total">13.000.000,00 ₺</td>
                    </tr>
                    </tbody>
                </table>
                <div class="custom-div">
                    <div class="col-12 row no-gutters" style="padding: 0px !important;">
                        <div class="col-6">
                            <nav class="nav nav-pills flex-column flex-sm-row">
                                <a class="flex-sm-fill text-sm-left nav-link active"
                                   aria-current="page" style="font-size: 18px"
                                   id="">BİLANÇO FARKI <span id="kar_zarar_durumu_metin"></span></a>
                            </nav>
                        </div>
                        <div class="col-6">
                            <nav class="nav nav-pills flex-column flex-sm-row">
                                <a class="flex-sm-fill text-sm-right nav-link active"
                                   aria-current="page" style="font-size: 18px"
                                   id="kar_zarar_durumu">100.000.000,00</a>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 row " style="padding: 0px !important;">
            <div class="col-6">
                <div class="col-12 row no-gutters" style="padding: 0px !important;">
                    <div class="col-6">
                        <nav class="nav nav-pills flex-column flex-sm-row">
                            <a class="flex-sm-fill text-sm-left nav-link active"
                               aria-current="page" style="font-size: 18px"
                               id="">VARLIKLAR TOPLAMI</a>
                        </nav>
                    </div>
                    <div class="col-6">
                        <nav class="nav nav-pills flex-column flex-sm-row">
                            <a class="flex-sm-fill text-sm-right nav-link active"
                               aria-current="page" style="font-size: 18px"
                               id="aktif_varliklar_aktif_total">100.000.000,00</a>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="col-12 row no-gutters" style="padding: 0px !important;">
                    <div class="col-6">
                        <nav class="nav nav-pills flex-column flex-sm-row">
                            <a class="flex-sm-fill text-sm-left nav-link active"
                               aria-current="page" style="font-size: 18px"
                               id="">PASİF KAYNAKLAR TOPLAMI</a>
                        </nav>
                    </div>
                    <div class="col-6">
                        <nav class="nav nav-pills flex-column flex-sm-row">
                            <a class="flex-sm-fill text-sm-right nav-link active"
                               aria-current="page" style="font-size: 18px"
                               id="pasif_varlik_aktif_toplam">100.000.000,00</a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    $(document).ready(function () {
        $.get("controller/rapor_controller/sql.php?islem=bilanco_tutarlarini_getir_sql", {
            secilen_ay:$("#secilen_ay").val(),
            secilen_yil:$("#secilen_yil").val()
        }, function (result) {
            if (result != 2) {
                var item = JSON.parse(result);
                let kasalar = item.kasalar;
                kasalar = parseFloat(kasalar);
                kasalar = kasalar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                let bankalar = item.bankalar;
                bankalar = parseFloat(bankalar);
                bankalar = bankalar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                let alinan_cekler_toplami = item.alinan_cekler_toplami;
                alinan_cekler_toplami = parseFloat(alinan_cekler_toplami);
                alinan_cekler_toplami = alinan_cekler_toplami.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let donen_varlik_total = item.donen_varlik_total;
                donen_varlik_total = parseFloat(donen_varlik_total);
                donen_varlik_total = donen_varlik_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let verilen_cek_total = item.verilen_cek_total;
                verilen_cek_total = parseFloat(verilen_cek_total);
                verilen_cek_total = verilen_cek_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let musteri_total = item.musteri_total;
                musteri_total = parseFloat(musteri_total);
                musteri_total = musteri_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let diger_varlik_total = item.diger_varlik_total;
                diger_varlik_total = parseFloat(diger_varlik_total);
                diger_varlik_total = diger_varlik_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let saticilara_verilen_avanslar_total = item.saticilara_verilen_avanslar_total;
                saticilara_verilen_avanslar_total = parseFloat(saticilara_verilen_avanslar_total);
                saticilara_verilen_avanslar_total = saticilara_verilen_avanslar_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let demirbaslar_total = item.demirbaslar_total;
                demirbaslar_total = parseFloat(demirbaslar_total);
                demirbaslar_total = demirbaslar_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let makine_ekipman_total = item.makine_ekipman_total;
                makine_ekipman_total = parseFloat(makine_ekipman_total);
                makine_ekipman_total = makine_ekipman_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let tasitlar_total = item.tasitlar_total;
                tasitlar_total = parseFloat(tasitlar_total);
                tasitlar_total = tasitlar_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let bina_arazi_total = item.bina_arazi_total;
                bina_arazi_total = parseFloat(bina_arazi_total);
                bina_arazi_total = bina_arazi_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let personel_avanslari_total = item.personel_avanslari_total;
                personel_avanslari_total = parseFloat(personel_avanslari_total);
                personel_avanslari_total = personel_avanslari_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let alinan_senetler_total = item.alinan_senetler_total;
                alinan_senetler_total = parseFloat(alinan_senetler_total);
                alinan_senetler_total = alinan_senetler_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let saticilar_total = item.saticilar_total;
                saticilar_total = parseFloat(saticilar_total);
                saticilar_total = saticilar_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let verilen_senetler_total = item.verilen_senetler_total;
                verilen_senetler_total = parseFloat(verilen_senetler_total);
                verilen_senetler_total = verilen_senetler_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let diger_borclar_toplam = item.diger_borclar_toplam;
                diger_borclar_toplam = parseFloat(diger_borclar_toplam);
                diger_borclar_toplam = diger_borclar_toplam.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let odenecek_vergi_vs_total = item.odenecek_vergi_vs_total;
                odenecek_vergi_vs_total = parseFloat(odenecek_vergi_vs_total);
                odenecek_vergi_vs_total = odenecek_vergi_vs_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let donem_borclar_totali = item.donem_borclar_totali;
                donem_borclar_totali = parseFloat(donem_borclar_totali);
                let duran_varliklar_total = item.duran_varliklar_total;
                duran_varliklar_total = parseFloat(duran_varliklar_total);
                duran_varliklar_total = duran_varliklar_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let emtia_stok_total = item.emtia_stok_total;
                emtia_stok_total = parseFloat(emtia_stok_total);
                emtia_stok_total = emtia_stok_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let aktif_varliklar_aktif_total = item.aktif_varliklar_aktif_total;
                aktif_varliklar_aktif_total = parseFloat(aktif_varliklar_aktif_total);

                let kar_zarar_durumu = aktif_varliklar_aktif_total - donem_borclar_totali;
                let basilacak_kar_zarar = "";
                let basilacak_kar_zarar_metin = "";
                if (kar_zarar_durumu > 0) {
                    basilacak_kar_zarar = kar_zarar_durumu.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }) + " ₺";
                    basilacak_kar_zarar_metin = " (KAR)";
                } else if (kar_zarar_durumu < 0) {
                    kar_zarar_durumu = -kar_zarar_durumu;
                    basilacak_kar_zarar = kar_zarar_durumu.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }) + " ₺";
                    basilacak_kar_zarar_metin = " (ZARAR)";
                } else {
                    basilacak_kar_zarar = kar_zarar_durumu.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }) + " ₺";
                }

                aktif_varliklar_aktif_total = aktif_varliklar_aktif_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let krediler_total = item.krediler_total;
                krediler_total = parseFloat(krediler_total);
                krediler_total = krediler_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                donem_borclar_totali = donem_borclar_totali.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });


                $("#kasalar_bilanco_total").html(kasalar + " ₺");
                $("#alinan_cekler_toplami").html(alinan_cekler_toplami + " ₺");
                $("#donen_varliklar_total").html(donen_varlik_total + " ₺");
                $("#verilen_cek_total").html(verilen_cek_total + " ₺");
                $("#bankalar_toplam").html(bankalar + " ₺");
                $("#musteri_total").html(musteri_total + " ₺");
                $("#diger_varlik_total").html(diger_varlik_total + " ₺");
                $("#saticilara_verilen_avanslar_total").html(saticilara_verilen_avanslar_total + " ₺");
                $("#demirbaslar_total").html(demirbaslar_total + " ₺");
                $("#makine_ekipman_total").html(makine_ekipman_total + " ₺");
                $("#tasitlar_total").html(tasitlar_total + " ₺");
                $("#bina_arazi_total").html(bina_arazi_total + " ₺");
                $("#personel_avanslari_total").html(personel_avanslari_total + " ₺");
                $("#alinan_senetler_total").html(alinan_senetler_total + " ₺");
                $("#saticilar_total").html(saticilar_total + " ₺");
                $("#verilen_senetler_total").html(verilen_senetler_total + " ₺");
                $("#diger_borclar_toplam").html(diger_borclar_toplam + " ₺");
                $("#odenecek_vergi_vs_total").html(odenecek_vergi_vs_total + " ₺");
                $("#donem_borclar_totali").html(donem_borclar_totali + " ₺");
                $("#duran_varliklar_total").html(duran_varliklar_total + " ₺");
                $("#emtia_stok_total").html(emtia_stok_total + " ₺");
                $("#aktif_varliklar_aktif_total").html(aktif_varliklar_aktif_total + " ₺");
                $("#pasif_varlik_aktif_toplam").html(donem_borclar_totali + " ₺");
                $("#krediler_total").html(krediler_total + " ₺");
                $("#kar_zarar_durumu").html(basilacak_kar_zarar);
                $("#kar_zarar_durumu_metin").html(basilacak_kar_zarar_metin);
            }
        })
    })

    $("body").off("click","#bilanco_filtrele_button").on("click","#bilanco_filtrele_button",function (){
        $.get("controller/rapor_controller/sql.php?islem=bilanco_tutarlarini_getir_sql", {
            secilen_ay:$("#secilen_ay").val(),
            secilen_yil:$("#secilen_yil").val()
        }, function (result) {
            if (result != 2) {
                var item = JSON.parse(result);
                let kasalar = item.kasalar;
                kasalar = parseFloat(kasalar);
                kasalar = kasalar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                let bankalar = item.bankalar;
                bankalar = parseFloat(bankalar);
                bankalar = bankalar.toLocaleString("tr-TR", {minimumFractionDigits: 2, maximumFractionDigits: 2});
                let alinan_cekler_toplami = item.alinan_cekler_toplami;
                alinan_cekler_toplami = parseFloat(alinan_cekler_toplami);
                alinan_cekler_toplami = alinan_cekler_toplami.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let donen_varlik_total = item.donen_varlik_total;
                donen_varlik_total = parseFloat(donen_varlik_total);
                donen_varlik_total = donen_varlik_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let verilen_cek_total = item.verilen_cek_total;
                verilen_cek_total = parseFloat(verilen_cek_total);
                verilen_cek_total = verilen_cek_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let musteri_total = item.musteri_total;
                musteri_total = parseFloat(musteri_total);
                musteri_total = musteri_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let diger_varlik_total = item.diger_varlik_total;
                diger_varlik_total = parseFloat(diger_varlik_total);
                diger_varlik_total = diger_varlik_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let saticilara_verilen_avanslar_total = item.saticilara_verilen_avanslar_total;
                saticilara_verilen_avanslar_total = parseFloat(saticilara_verilen_avanslar_total);
                saticilara_verilen_avanslar_total = saticilara_verilen_avanslar_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let demirbaslar_total = item.demirbaslar_total;
                demirbaslar_total = parseFloat(demirbaslar_total);
                demirbaslar_total = demirbaslar_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let makine_ekipman_total = item.makine_ekipman_total;
                makine_ekipman_total = parseFloat(makine_ekipman_total);
                makine_ekipman_total = makine_ekipman_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let tasitlar_total = item.tasitlar_total;
                tasitlar_total = parseFloat(tasitlar_total);
                tasitlar_total = tasitlar_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let bina_arazi_total = item.bina_arazi_total;
                bina_arazi_total = parseFloat(bina_arazi_total);
                bina_arazi_total = bina_arazi_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let personel_avanslari_total = item.personel_avanslari_total;
                personel_avanslari_total = parseFloat(personel_avanslari_total);
                personel_avanslari_total = personel_avanslari_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let alinan_senetler_total = item.alinan_senetler_total;
                alinan_senetler_total = parseFloat(alinan_senetler_total);
                alinan_senetler_total = alinan_senetler_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let saticilar_total = item.saticilar_total;
                saticilar_total = parseFloat(saticilar_total);
                saticilar_total = saticilar_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let verilen_senetler_total = item.verilen_senetler_total;
                verilen_senetler_total = parseFloat(verilen_senetler_total);
                verilen_senetler_total = verilen_senetler_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let diger_borclar_toplam = item.diger_borclar_toplam;
                diger_borclar_toplam = parseFloat(diger_borclar_toplam);
                diger_borclar_toplam = diger_borclar_toplam.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let odenecek_vergi_vs_total = item.odenecek_vergi_vs_total;
                odenecek_vergi_vs_total = parseFloat(odenecek_vergi_vs_total);
                odenecek_vergi_vs_total = odenecek_vergi_vs_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let donem_borclar_totali = item.donem_borclar_totali;
                donem_borclar_totali = parseFloat(donem_borclar_totali);
                let duran_varliklar_total = item.duran_varliklar_total;
                duran_varliklar_total = parseFloat(duran_varliklar_total);
                duran_varliklar_total = duran_varliklar_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let emtia_stok_total = item.emtia_stok_total;
                emtia_stok_total = parseFloat(emtia_stok_total);
                emtia_stok_total = emtia_stok_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let aktif_varliklar_aktif_total = item.aktif_varliklar_aktif_total;
                aktif_varliklar_aktif_total = parseFloat(aktif_varliklar_aktif_total);

                let kar_zarar_durumu = aktif_varliklar_aktif_total - donem_borclar_totali;
                let basilacak_kar_zarar = "";
                let basilacak_kar_zarar_metin = "";
                if (kar_zarar_durumu > 0) {
                    basilacak_kar_zarar = kar_zarar_durumu.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }) + " ₺";
                    basilacak_kar_zarar_metin = " (KAR)";
                } else if (kar_zarar_durumu < 0) {
                    kar_zarar_durumu = -kar_zarar_durumu;
                    basilacak_kar_zarar = kar_zarar_durumu.toLocaleString("tr-TR", {
                        maximumFractionDigits: 2,
                        minimumFractionDigits: 2
                    }) + " ₺";
                    basilacak_kar_zarar_metin = " (ZARAR)";
                } else {
                    basilacak_kar_zarar = kar_zarar_durumu.toLocaleString("tr-TR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }) + " ₺";
                }

                aktif_varliklar_aktif_total = aktif_varliklar_aktif_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                let krediler_total = item.krediler_total;
                krediler_total = parseFloat(krediler_total);
                krediler_total = krediler_total.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                donem_borclar_totali = donem_borclar_totali.toLocaleString("tr-TR", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });


                $("#kasalar_bilanco_total").html(kasalar + " ₺");
                $("#alinan_cekler_toplami").html(alinan_cekler_toplami + " ₺");
                $("#donen_varliklar_total").html(donen_varlik_total + " ₺");
                $("#verilen_cek_total").html(verilen_cek_total + " ₺");
                $("#bankalar_toplam").html(bankalar + " ₺");
                $("#musteri_total").html(musteri_total + " ₺");
                $("#diger_varlik_total").html(diger_varlik_total + " ₺");
                $("#saticilara_verilen_avanslar_total").html(saticilara_verilen_avanslar_total + " ₺");
                $("#demirbaslar_total").html(demirbaslar_total + " ₺");
                $("#makine_ekipman_total").html(makine_ekipman_total + " ₺");
                $("#tasitlar_total").html(tasitlar_total + " ₺");
                $("#bina_arazi_total").html(bina_arazi_total + " ₺");
                $("#personel_avanslari_total").html(personel_avanslari_total + " ₺");
                $("#alinan_senetler_total").html(alinan_senetler_total + " ₺");
                $("#saticilar_total").html(saticilar_total + " ₺");
                $("#verilen_senetler_total").html(verilen_senetler_total + " ₺");
                $("#diger_borclar_toplam").html(diger_borclar_toplam + " ₺");
                $("#odenecek_vergi_vs_total").html(odenecek_vergi_vs_total + " ₺");
                $("#donem_borclar_totali").html(donem_borclar_totali + " ₺");
                $("#duran_varliklar_total").html(duran_varliklar_total + " ₺");
                $("#emtia_stok_total").html(emtia_stok_total + " ₺");
                $("#aktif_varliklar_aktif_total").html(aktif_varliklar_aktif_total + " ₺");
                $("#pasif_varlik_aktif_toplam").html(donem_borclar_totali + " ₺");
                $("#krediler_total").html(krediler_total + " ₺");
                $("#kar_zarar_durumu").html(basilacak_kar_zarar);
                $("#kar_zarar_durumu_metin").html(basilacak_kar_zarar_metin);
            }
        })
    });

</script>