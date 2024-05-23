<?php
$islem = $_GET["islem"];

if ($islem == "personel_guncelle_modal") {
    ?>
    <div class="modal fade" id="personel_guncelle_modal" data-backdrop="static" data-bs-keyboard="false"
         role="dialog">
        <div class="modal-dialog" style="width: 100%; max-width: 100%;">
            <div class="modal-content">
                <div class="modal-header text-white p-2">
                    <button type="button" class="btn-close btn-close-white" id="personel_vazgec"
                            aria-label="Close"></button>
                </div>
                <div class="page-content fade-in-up">
                    <div class="ibox">
                        <div class="ibox-head" style='background-color:#9DB2BF'>
                            <div class="ibox-title" style='color:white; font-weight:bold;'>PERSONEL TANIMLA</div>
                        </div>
                        <div class="modal-body">
                            <div class="col-12 row">
                                <div class="col-4">
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>Personel Kodu</label>
                                        </div>
                                        <div class="col-8">
                                            <input disabled type="text" class="form-control form-control-sm"
                                                   placeholder="Personel Kodu" id="personel_kodu">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>Ad Soyad</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" placeholder="Ad Soyad" id="ad_soyad"
                                                   class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>Departman</label>
                                        </div>
                                        <div class="col-8">
                                            <select class="custom-select custom-select-sm departmans_id" id="departman_id">
                                                <option value="">Departman Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>Görevi</label>
                                        </div>
                                        <div class="col-8">
                                            <select class="custom-select custom-select-sm" id="gorev_id">
                                                <option value="">Görev Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>Mesleği</label>
                                        </div>
                                        <div class="col-8">
                                            <select class="custom-select custom-select-sm" id="meslek_id">
                                                <option value="">Meslek Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>Personel Tipi</label>
                                        </div>
                                        <div class="col-8">
                                            <select class="custom-select custom-select-sm" id="personel_tipi">
                                                <option value="">Personel Tipi Seçiniz...</option>
                                                <option value="Mavi Yaka">Mavi Yaka</option>
                                                <option value="Beyaz Yaka">Beyaz Yaka</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>Eğitim Durumu</label>
                                        </div>
                                        <div class="col-8">
                                            <select class="custom-select custom-select-sm" id="egitim_durumu">
                                                <option value="">Eğitim Durumu Seçiniz...</option>
                                                <option value="İlk Okul">İlk Okul</option>
                                                <option value="Lise">Lise</option>
                                                <option value="Lisans">Lisans</option>
                                                <option value="Ön Lisans">Ön Lisans</option>
                                                <option value="Yüksek Lisans">Yüksek Lisans</option>
                                                <option value="Doktora">Doktora</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--                                    <div class="form-group row">-->
                                    <!--                                        <div class="col-4">-->
                                    <!--                                            <label>Servis Bilgisi</label>-->
                                    <!--                                        </div>-->
                                    <!--                                        <div class="col-8">-->
                                    <!--                                            <select class="custom-select custom-select-sm" id="servis_id">-->
                                    <!--                                                <option value="">Servis Bilgisi Seçiniz...</option>-->
                                    <!--                                            </select>-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>Ev Telefonu</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" class="form-control form-control-sm" id="ev_tel"
                                                   placeholder="Ev Telefonu">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>Cep Telefonu</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" class="form-control form-control-sm"
                                                   placeholder="Cep Telefonu" id="cep_tel">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>E-Posta</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="email" class="form-control form-control-sm"
                                                   placeholder="E-Posta" id="e_mail">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>Bilanço</label>
                                        </div>
                                        <div class="col-8">
                                            <select class="custom-select custom-select-sm" id="bilanco_id">
                                                <option value="">Bilanço Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>İl</label>
                                        </div>
                                        <div class="col-8">
                                            <select class="custom-select custom-select-sm" id="il_id">
                                                <option value="">İl Seçiniz...</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>İlçe</label>
                                        </div>
                                        <div class="col-8">
                                            <select class="custom-select custom-select-sm" id="ilce_id">
                                                <option value="">İlçe Seçiniz</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>Özel Kod1</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" class="form-control form-control-sm"
                                                   placeholder="Özel Kod1" id="ozel_kod1">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>Özel Kod2</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" class="form-control form-control-sm"
                                                   placeholder="Özel Kod2" id="ozel_kod2">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-4">
                                            <label>Açıklama</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" placeholder="Açıklama"
                                                   class="form-control form-control-sm" id="aciklama">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row">
                                <nav class="nav nav-pills flex-column flex-sm-row">
                                    <a class="flex-sm-fill text-sm-center nav-link active cari_page_color"
                                       style="background-color: #9DB2BF; font-weight: bold" aria-current="page"
                                       id="">KİMLİK VE DETAY BİLGİLERİ</a>
                                </nav>
                                <div class="degisen_personel_sayfasi">
                                    <div class="col-12 row">
                                        <div class="col-3">
                                            <div class="form-group row">
                                                <div class="col-4">
                                                    <label>TC No</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" placeholder="Tc Kimlik"
                                                           class="form-control form-control-sm" id="tc_no">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-4">
                                                    <label>Baba Adı</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" placeholder="Baba Adı"
                                                           class="form-control form-control-sm" id="baba_adi">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-4">
                                                    <label>Ana Adı</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" placeholder="Ana Adı"
                                                           class="form-control form-control-sm" id="ana_adi">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-4">
                                                    <label>Medeni Hali</label>
                                                </div>
                                                <div class="col-8">
                                                    <select class="custom-select custom-select-sm" id="medeni_hal">
                                                        <option value="">Seçiniz...</option>
                                                        <option value="Evli">Evli</option>
                                                        <option value="Bekar">Bekar</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-4">
                                                    <label>İlk Soyad</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" class="form-control form-control-sm"
                                                           id="ilk_soyad">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-4">
                                                    <label>Doğum Tarihi</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="date" class="form-control form-control-sm"
                                                           id="dogum_tarihi">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group row">
                                                <div class="col-4">
                                                    <label>Doğum Yeri</label>
                                                </div>
                                                <div class="col-8 row">
                                                    <div class="col-12 row no-gutters">
                                                        <div class="col-md">
                                                            <select class="custom-select custom-select-sm"
                                                                    id="dogum_il">
                                                                <option value="">İl Seçiniz...</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md">
                                                            <select class="custom-select custom-select-sm"
                                                                    id="dogum_ilce">
                                                                <option value="">İlçe Seçiniz...</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-4">
                                                    <label>Mahalle/Köy</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" class="form-control form-control-sm"
                                                           id="mahalle_koy" placeholder="Mahalle/Köy">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-4">
                                                    <label>Kan Grubu</label>
                                                </div>
                                                <div class="col-8">
                                                    <select class="custom-select custom-select-sm" id="kan_grubu">
                                                        <option value="">Kan Grubu Seçiniz...</option>
                                                        <option value="0 Rh (-)">0 Rh (-)</option>
                                                        <option value="0 Rh (+)">0 Rh (+)</option>
                                                        <option value="A Rh (-)">A Rh (-)</option>
                                                        <option value="A Rh (+)">A Rh (+)</option>
                                                        <option value="B Rh (-)">B Rh (-)</option>
                                                        <option value="B Rh (+)">B Rh (+)</option>
                                                        <option value="AB Rh (-)">AB Rh (-)</option>
                                                        <option value="AB Rh (+)">AB Rh (+)</option>
                                                        <option value="Bilinmiyor">Bilinmiyor</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-4">
                                                    <label>Cinsiyet</label>
                                                </div>
                                                <div class="col-8">
                                                    <select class="custom-select custom-select-sm" id="cinsiyet">
                                                        <option value="">Cinsiyet Seçiniz...</option>
                                                        <option value="Erkek">Erkek</option>
                                                        <option value="Kadın">Kadın</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-4">
                                                    <label>Seri No</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" class="form-control form-control-sm"
                                                           id="seri_no">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group row">
                                                <div class="col-4">
                                                    <label>İşbaşı Tarih</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="date" class="form-control form-control-sm"
                                                           id="is_basi_tarih1">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-4">
                                                    <label>SSK Baş.</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="date" class="form-control form-control-sm"
                                                           id="ssk_bas_tarih">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-4">
                                                    <label>İşten A.T.</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="date" class="form-control form-control-sm"
                                                           id="isten_ayrilma_tarih">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-4">
                                                    <label>İşbaşı Tekrar</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="date" class="form-control form-control-sm"
                                                           id="isbasi_tekrar">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-4">
                                                    <label>SSK Baş. Tekrar</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="date" class="form-control form-control-sm"
                                                           id="ssk_bas_tekrar">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group row">
                                                <div class="col-4">
                                                    <label>Net Maaş</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" class="form-control form-control-sm"
                                                           id="net_maas">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-4">
                                                    <label>Haftalık Ücret</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" class="form-control form-control-sm"
                                                           id="haftalik_ucret">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-4">
                                                    <label>Günlük Ücret</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" class="form-control form-control-sm"
                                                           id="gunluk_ucret">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-4">
                                                    <label>Saat Ücreti</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="text" class="form-control form-control-sm"
                                                           id="saat_ucreti">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-4">
                                                    <label>Çocuk Sayısı</label>
                                                </div>
                                                <div class="col-8">
                                                    <input type="number" class="form-control form-control-sm"
                                                           id="cocuk_sayisi">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" id="personel_vazgec"><i class="fa fa-close"></i> Vazgeç</button>
                            <button class="btn btn-success btn-sm" id="personel_guncelle"><i class="fa fa-check"></i> Güncelle</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {

            $.get("controller/personel_controller/sql.php?islem=departman_getir_sql",function (result){
                if (result != 2){
                    var json = JSON.parse(result);
                    json.forEach(function (item){
                        $("#departman_id").append("" +
                            "<option value='"+item.id+"'>"+item.departman_adi+"</option>" +
                            "");
                    })
                }
            })
            $.get("controller/personel_controller/sql.php?islem=gorev_getir_sql",function (result){
                if (result != 2){
                    var json = JSON.parse(result);
                    json.forEach(function (item){
                        $("#gorev_id").append("" +
                            "<option value='"+item.id+"'>"+item.gorev_adi+"</option>" +
                            "");
                    })
                }
            })
            $.get("controller/personel_controller/sql.php?islem=meslek_getir_sql",function (result){
                if (result != 2){
                    var json = JSON.parse(result);
                    json.forEach(function (item){
                        $("#meslek_id").append("" +
                            "<option value='"+item.id+"'>"+item.meslek_adi+"</option>" +
                            "");
                    })
                }
            })

            $.get("controller/personel_controller/sql.php?islem=personel_bilgilerini_getir_sql",{id:"<?=$_GET["id"]?>"},function (result){
                if (result != 2){
                    var item = JSON.parse(result);
                    setTimeout(function (){
                        $("#personel_kodu").val(item.personel_kodu);
                        $("#ad_soyad").val(item.ad_soyad);
                        $("#departman_id").val(item.departman_id);
                        $("#gorev_id").val(item.gorev_id);
                        $("#meslek_id").val(item.meslek_id);
                        $("#personel_tipi").val(item.personel_tipi);
                        $("#egitim_durumu").val(item.egitim_durumu);
                        $("#cep_tel").val(item.cep_tel);
                        $("#ev_tel").val(item.ev_tel);
                        $("#bilanco_id").val(item.bilanco_id);
                        $("#il_id").val(item.il_id);
                        $("#e_mail").val(item.e_mail);
                        $("#ilce_id").append("" +
                         "<option value='"+item.ilce_id+"'>"+item.ilce_adi+"</option>" +
                            "");
                        $("#ilce_id").val(item.ilce_id);
                        $("#ozel_kod1").val(item.ozel_kod1);
                        $("#ozel_kod2").val(item.ozel_kod2);
                        $("#aciklama").val(item.aciklama);


                        $("#tc_no").val(item.tc_no);
                        $("#baba_adi").val(item.baba_adi);
                        $("#ana_adi").val(item.ana_adi);
                        $("#medeni_hal").val(item.medeni_hal);
                        $("#ilk_soyad").val(item.ilk_soyad);
                        $("#dogum_tarihi").val(item.dogum_tarihi);
                        $("#dogum_il").val(item.dogum_il);
                        $("#dogum_ilce").append("" +
                            "<option value='"+item.dogum_ilce+"'>"+item.dogum_ilce+"</option>" +
                            "");
                        $("#dogum_ilce").val(item.dogum_ilce);
                        $("#cinsiyet").val(item.cinsiyet);
                        $("#seri_no").val(item.seri_no);
                        $("#kan_grubu").val(item.kan_grubu);
                        $("#mahalle_koy").val(item.mahalle_koy);
                        $.get("controller/personel_controller/sql.php?islem=bilanco_kodu_ne_sql",{cari_kodu:item.personel_kodu},function (result2){
                            if (result2 != 2){
                                var item2 = JSON.parse(result2);
                                $("#bilanco_id").val(item2.bilanco_id)
                            }
                        });
                        var isbasi = item.is_basi_tarih1;
                        isbasi = isbasi.split(" ");
                        var ssk_bas = item.ssk_bas_tarih;
                        ssk_bas = ssk_bas.split(" ");
                        var ayrilmaTarih = item.isten_ayrilma_tarih;
                        ayrilmaTarih = ayrilmaTarih.split(" ");
                        var isbasiTekrar = item.isbasi_tekrar;
                        isbasiTekrar = isbasiTekrar.split(" ");
                        var basTarih = item.ssk_bas_tekrar;
                        basTarih = basTarih.split(" ");
                        $("#is_basi_tarih1").val(isbasi[0]);
                        $("#ssk_bas_tarih").val(ssk_bas[0]);
                        $("#isten_ayrilma_tarih").val(ayrilmaTarih[0]);
                        $("#isbasi_tekrar").val(isbasiTekrar[0]);
                        $("#ssk_bas_tekrar").val(basTarih[0]);
                        $("#net_maas").val(item.net_maas);
                        $("#haftalik_ucret").val(item.haftalik_ucret);
                        $("#gunluk_ucret").val(item.gunluk_ucret);
                        $("#saat_ucreti").val(item.saat_ucreti);
                        $("#cocuk_sayisi").val(item.cocuk_sayisi);
                    },400);
                }
            })

            $("#personel_guncelle_modal").modal("show");

            $.get("controller/personel_controller/sql.php?islem=bilancolari_getir",function (result){
                if (result != 2){
                    var json = JSON.parse(result);
                    json.forEach(function (item){
                        $("#bilanco_id").append("" +
                            "<option value='"+item.id+"'>"+item.bilanco_adi+"</option>" +
                            "");
                    })
                }
            })

            $.get("controller/personel_controller/sql.php?islem=il_getir",function (result){
                if (result != 2){
                    var json = JSON.parse(result);
                    json.forEach(function (item){
                        $("#il_id").append("" +
                            "<option value='"+item.id+"'>"+item.il_adi+"</option>" +
                            "");
                        $("#dogum_il").append("" +
                            "<option data-id='"+item.id+"' value='"+item.il_adi+"'>"+item.il_adi+"</option>" +
                            "");
                    });
                }
            })

        })

        $("body").off("click","#otomatik").on("click","#otomatik",function (){
            if ($(this).is(':checked')) {
                $('#cari_id').prop('disabled', true);
            } else {
                $('#cari_id').prop('disabled', false);
            }
        })
        $("body").off("change","#il_id").on("change","#il_id",function (){
            let id = $(this).val();
            $.get("controller/personel_controller/sql.php?islem=secilen_il_ilce_getir",{id:id},function (result){
                if (result != 2){
                    var json = JSON.parse(result);
                    $("#ilce_id").html("");
                    $("#ilce_id").append("" +
                        "<option>İlçe Seçiniz...</option>" +
                        "");
                    json.forEach(function (item){
                        $("#ilce_id").append("" +
                            "<option value='"+item.id+"'>"+item.ilce_adi+"</option>" +
                            "");
                    })
                }
            })
        })

        $("body").off("change","#dogum_il").on("change","#dogum_il",function (){
            let id = $("#dogum_il option:selected").attr("data-id");
            $.get("controller/personel_controller/sql.php?islem=secilen_il_ilce_getir",{id:id},function (result){
                if (result != 2){
                    var json = JSON.parse(result);
                    $("#dogum_ilce").html("");
                    $("#dogum_ilce").append("" +
                        "<option>İlçe Seçiniz...</option>" +
                        "");
                    json.forEach(function (item){
                        $("#dogum_ilce").append("" +
                            "<option value='"+item.ilce_adi+"'>"+item.ilce_adi+"</option>" +
                            "");
                    })
                }
            })
        })

        $("body").off("click","#personel_vazgec").on("click","#personel_vazgec",function (){
            $("#personel_guncelle_modal").modal("hide");
        })

        $("#cari_id").keyup(function (){
            var cari_kodu = $(this).val();
            $.get("controller/personel_controller/sql.php?islem=cari_kodu_bilgileri_getir_sql",{cari_kodu:cari_kodu},function (result){
                if (result != 2){
                    var item = JSON.parse(result);
                    $("#cari_id").val(item.cari_kodu)
                    $("#cari_id").attr("data-id",item.id);
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                    Toast.fire({
                        icon: 'success',
                        title: 'Cari Bulundu'
                    });
                }
            })
        })

        $("body").off("click","#personel_guncelle").on("click","#personel_guncelle",function (){
            //İLK TABLO
            let personel_kodu = $("#personel_kodu").val();
            let ad_soyad = $("#ad_soyad").val();
            let departman_id = $(".departmans_id").val();
            let gorev_id = $("#gorev_id").val();
            let meslek_id = $("#meslek_id").val();
            let personel_tipi = $("#personel_tipi").val();
            let egitim_durumu = $("#egitim_durumu").val();
            // let servis_id = $("#servis_id").val();
            let ev_tel = $("#ev_tel").val();
            let cep_tel = $("#cep_tel").val();
            let e_mail = $("#e_mail").val();
            let cari_id = $("#cari_id").attr("data-id");
            let il_id = $("#il_id").val();
            let ilce_id = $("#ilce_id").val();
            let ozel_kod1 = $("#ozel_kod1").val();
            let ozel_kod2 = $("#ozel_kod2").val();
            let aciklama = $("#aciklama").val();
            // İKİNCİ TABLO
            let tc_no = $("#tc_no").val();
            let baba_adi = $("#baba_adi").val();
            let ana_adi = $("#ana_adi").val();
            let medeni_hal = $("#medeni_hal").val();
            let ilk_soyad = $("#ilk_soyad").val();
            let dogum_tarihi = $("#dogum_tarihi").val();
            let dogum_il = $("#dogum_il").val();
            let dogum_ilce = $("#dogum_ilce").val();
            let cinsiyet = $("#cinsiyet").val();
            let seri_no = $("#seri_no").val();
            let kan_grubu = $("#kan_grubu").val();
            let mahalle_koy = $("#mahalle_koy").val();
            // ÜÇÜNCÜ TABLO
            let is_basi_tarih1 = $("#is_basi_tarih1").val();
            let ssk_bas_tarih = $("#ssk_bas_tarih").val();
            let isten_ayrilma_tarih = $("#isten_ayrilma_tarih").val();
            let isbasi_tekrar = $("#isbasi_tekrar").val();
            let ssk_bas_tekrar = $("#ssk_bas_tekrar").val();
            let net_maas = $("#net_maas").val();
            net_maas = net_maas.replace(/\./g, "").replace(",", ".");
            net_maas = parseFloat(net_maas);
            let haftalik_ucret = $("#haftalik_ucret").val();
            haftalik_ucret = haftalik_ucret.replace(/\./g, "").replace(",", ".");
            haftalik_ucret = parseFloat(haftalik_ucret);
            let gunluk_ucret = $("#gunluk_ucret").val();
            gunluk_ucret = gunluk_ucret.replace(/\./g, "").replace(",", ".");
            gunluk_ucret = parseFloat(gunluk_ucret);
            let saat_ucreti = $("#saat_ucreti").val();
            saat_ucreti = saat_ucreti.replace(/\./g, "").replace(",", ".");
            saat_ucreti = parseFloat(saat_ucreti);
            let cocuk_sayisi = $("#cocuk_sayisi").val();
            let bilanco_id = $("#bilanco_id").val();
            let otomatik = 1;
            if (bilanco_id == ""){
                Swal.fire(
                    'Uyarı!',
                    'Bilanço Seçiniz',
                    'warning'
                );
            }else {
                $.ajax({
                    url:"controller/personel_controller/sql.php?islem=personel_guncelle_sql",
                    type:"POST",
                    data:{
                        otomatik:otomatik,
                        id:"<?=$_GET["id"]?>",
                        bilanco_id:bilanco_id,
                        personel_kodu:personel_kodu,
                        ad_soyad:ad_soyad,
                        departman_id:departman_id,
                        gorev_id:gorev_id,
                        meslek_id:meslek_id,
                        personel_tipi:personel_tipi,
                        egitim_durumu:egitim_durumu,
                        // servis_id:servis_id,
                        ev_tel:ev_tel,
                        cep_tel:cep_tel,
                        e_mail:e_mail,
                        cari_id:cari_id,
                        il_id:il_id,
                        ilce_id:ilce_id,
                        ozel_kod1:ozel_kod1,
                        ozel_kod2:ozel_kod2,
                        aciklama:aciklama,
                        tc_no:tc_no,
                        baba_adi:baba_adi,
                        ana_adi:ana_adi,
                        medeni_hal:medeni_hal,
                        ilk_soyad:ilk_soyad,
                        dogum_tarihi:dogum_tarihi,
                        dogum_il:dogum_il,
                        dogum_ilce:dogum_ilce,
                        cinsiyet:cinsiyet,
                        seri_no:seri_no,
                        kan_grubu:kan_grubu,
                        mahalle_koy:mahalle_koy,
                        is_basi_tarih1:is_basi_tarih1,
                        ssk_bas_tarih:ssk_bas_tarih,
                        isten_ayrilma_tarih:isten_ayrilma_tarih,
                        isbasi_tekrar:isbasi_tekrar,
                        ssk_bas_tekrar:ssk_bas_tekrar,
                        net_maas:net_maas,
                        haftalik_ucret:haftalik_ucret,
                        gunluk_ucret:gunluk_ucret,
                        saat_ucreti:saat_ucreti,
                        cocuk_sayisi:cocuk_sayisi
                    },
                    success:function (result){
                        if (result == 1){
                            Swal.fire(
                                'Başarılı!',
                                'Personel Güncellendi',
                                'success'
                            );
                            $.get("view/personel_tanimla.php", function (getList) {
                                $(".modal-icerik").html("");
                                $(".modal-icerik").html(getList);
                            });
                            $.get("view/personel_tanimla.php", function (getList) {
                                $(".admin-modal-icerik").html("");
                                $(".admin-modal-icerik").html(getList);
                            });
                            $("#personel_guncelle_modal").modal("hide");
                        }else if (result == 300){
                            Swal.fire(
                                'Uyarı!',
                                'Oluşturmuş Olduğunuz Personel Kodu Kullanılıyor Lütfen Başka Bir Kod Seçiniz',
                                'warning'
                            );
                        }
                        else {
                            $("#personel_guncelle_modal").modal("hide");
                        }
                    }
                })
            }
        });

        $("#net_maas").keyup(function () {
            let net_maas = $(this).val();
            net_maas = net_maas.replace(/\./g, "").replace(",", ".");
            net_maas = parseInt(net_maas);
            let haftalik = net_maas / 4;
            if (isNaN(haftalik)) {
                haftalik = 0;
            }
            haftalik = haftalik.toLocaleString("tr-TR", {minimumFractionDigits: 2});
            let gunluk = net_maas / 30;
            if (isNaN(gunluk)) {
                gunluk = 0;
            }
            gunluk = gunluk.toLocaleString("tr-TR", {minimumFractionDigits: 2});
            let saatlik = net_maas / 240;
            if (isNaN(saatlik)) {
                saatlik = 0;
            }
            saatlik = saatlik.toLocaleString("tr-TR", {minimumFractionDigits: 2});
            $("#haftalik_ucret").val(haftalik);
            $("#gunluk_ucret").val(gunluk);
            $("#saat_ucreti").val(saatlik);
        })

        $("#net_maas").focusout(function () {
            let net_maas = $(this).val();
            net_maas = net_maas.replace(/\./g, "").replace(",", ".");
            net_maas = parseFloat(net_maas);
            if (isNaN(net_maas)) {
                net_maas = 0;
            }
            net_maas = net_maas.toLocaleString("tr-TR", {minimumFractionDigits: 2});
            $(this).val(net_maas);
        })
    </script>
    <?php
}