<style>
    @media screen and (max-width: 768px) {
        .container {
            height: auto;
            width: 100%;
            max-width: 720px;
        }
    }

    /* Mobil boyutları için stil kuralları */
    @media screen and (max-width: 480px) {
        .container {
            height: auto;
            width: 100%;
            max-width: 360px;
        }
    }
</style>
<div class="page-wrapper duzenle_body">
    <!-- START HEADER-->
    <header class="header" style="background-color: #374f65">
        <div class="page-brand">
        </div>
        <div class="flexbox flex-1">
            <!-- START TOP-LEFT TOOLBAR-->
            <ul class="nav navbar-toolbar">
                <li>
                    <a class="nav-link sidebar-toggler js-sidebar-toggler" style="color: white"><i class="ti-menu"></i></a>
                </li>
            </ul>
            <!-- END TOP-LEFT TOOLBAR-->
            <!-- START TOP-RIGHT TOOLBAR-->
            <ul class="nav navbar-toolbar">
                <li class="dropdown dropdown-user">
                    <a class="nav-link dropdown-toggle link" data-toggle="dropdown">
                        <img src="./assets/img/admin-avatar4.png"/>
                        <span style="color: white"><?= $_SESSION["name_surname"] ?><i
                                    class="fa fa-angle-down m-l-5"></i></span></a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href=""><i class="fa fa-user"></i>Hesabım</a>
                        <a class="dropdown-item" href=""><i class="fa fa-cog"></i>Ayarlar</a>
                        <a class="dropdown-item" href=""><i class="fa fa-support"></i>Destek</a>
                        <li class="dropdown-divider"></li>
                        <a class="dropdown-item" style="cursor: pointer" id="cikis_yap"><i class="fa fa-power-off"></i>Çıkış
                            Yap</a>
                    </ul>
                </li>
            </ul>
            <!-- END TOP-RIGHT TOOLBAR-->
        </div>
    </header>
    <!-- END HEADER-->
    <!-- START SIDEBAR-->
    <nav class="page-sidebar" id="sidebar">
        <div id="sidebar-collapse">
            <div class="admin-block d-flex">
                <div>
                    <img src="./assets/img/admin-avatar.png" width="45px"/>
                </div>
                <div class="admin-info">
                    <div class="font-strong"><?= mb_strtoupper($_SESSION["name_surname"]) ?></div>
                    <small><?php if ($_SESSION["user_root"] == 1) {
                            echo "Yönetici";
                        } else {
                            echo 'Kullanıcı';
                        } ?></small></div>
            </div>
            <ul class="side-menu metismenu">
                <li>
                    <a class="active" style="cursor: pointer; color: white"><i
                                class="sidebar-item-icon fa fa-th-large"></i>
                        <span class="nav-label">Anasayfa</span>
                    </a>
                </li>
                <li class="heading">Modüller</li>
<!--                <li>-->
<!--                    <a href=""><i class="sidebar-item-icon fa fa-calculator"></i>-->
<!--                        <span class="nav-label">Muhasebe</span><i class="fa fa-angle-left arrow"></i></a>-->
<!--                    <ul>-->
<!--                        <li>-->
<!--                            <a href=""><i class="sidebar-item-icon fa fa-briefcase"></i>-->
<!--                                <span class="nav-label">Cari Hesap Yönetimi</span><i class="fa fa-angle-left arrow"></i></a>-->
<!--                            <ul class="nav-2-level collapse">-->
<!--                                <li>-->
<!--                                    <a style="color: white; cursor: pointer" id="cari_tanimla">Cari Tanımla</a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="">Cari İşlemleri<i class="fa fa-angle-left arrow"></i></a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="cari_acilis_fisi">Cari Açılış-->
<!--                                                Fişi</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="mahsup_fisleri">Mahsup Fişi</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="">Cari Raporları<i class="fa fa-angle-left arrow"></i></a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="cursor: pointer; color: white" id="cari_hesap_ekstre">Cari Hesap-->
<!--                                                Ekstresi</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="cursor: pointer; color: white" id="cari_raporlari">Cari Borç-->
<!--                                                Alacak Durumu</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="cursor: pointer; color: white" id="cari_vadesin_gore_tahsilat">Vadesine Göre Tahsilat-->
<!--                                                Listesi</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="cursor: pointer; color: white" id="cari_vadesine_gore_odeme">Vadesine Göre Ödeme-->
<!--                                                Listesi</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="cursor: pointer; color: white" id="aylik_tahsilat_listesi">Aylık Tahsilat Listesi</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-barcode"></i>-->
<!--                                <span class="nav-label">Stok/Hizmet Yönetimi</span><i-->
<!--                                        class="fa fa-angle-left arrow"></i></a>-->
<!--                            <ul class="nav-2-level collapse">-->
<!--                                <li>-->
<!--                                    <a style="color: white; cursor: pointer" id="stok_tanimla_main">Stok Tanımla</a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="">Stok İşlemleri<i class="fa fa-angle-left arrow"></i></a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="stok_fire_cikis">Stok Fire-->
<!--                                                Çıkışı</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="stok_acilis">Stok Açılış-->
<!--                                                Fişi</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a style="cursor: pointer;color: white" id="">Stok Raporları<i-->
<!--                                                class="fa fa-angle-left arrow"></i></a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="stok_raporlari">Stok Raporu</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="stok_ekstresi">Stok-->
<!--                                                Ekstresi</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="">Stok Envanter Raporu</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="">Ürün Giriş Çıkış Analizi</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="">Son Fiyat Üzerinden Maliyet-->
<!--                                                Raporu</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="">Kritik Seviye Listesi</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="">Stok Devir Hızı</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="">Stok Listesi</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-shopping-basket"></i>-->
<!--                                <span class="nav-label">Alış Yönetimi</span><i class="fa fa-angle-left arrow"></i></a>-->
<!--                            <ul class="nav-2-level collapse">-->
<!--                                <li>-->
<!--                                    <a style="color: white; cursor: pointer" id="alis_faturasi_getir_main">Alış-->
<!--                                        Faturası</a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a style="color: white; cursor: pointer" id="irsaliyeler">Alış İrsaliyesi</a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a style="color: white; cursor: pointer" id="verilen_siparisler">Verilen-->
<!--                                        Siparişler</a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a style="color: white; cursor: pointer" id="muhasebe_gider_faturalari">Gider-->
<!--                                        Faturaları</a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="">Alış Faturası Raporları<i class="fa fa-angle-left arrow"></i></a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="cursor: pointer; color: white" id="">Müşteriye Göre Fatura-->
<!--                                                Listesi</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="cursor: pointer; color: white" id="">Satıcılara Göre Fatura-->
<!--                                                Listesi</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="cursor: pointer; color: white" id="">KDV Durum Raporu</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="cursor: pointer; color: white" id="">Fatura Karlılk Analizi</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <a href="javascript:;"><i class="sidebar-item-icon fa fa-shopping-cart"></i>-->
<!--                                <span class="nav-label">Satış Yönetimi</span><i class="fa fa-angle-left arrow"></i></a>-->
<!--                            <ul class="nav-2-level collapse">-->
<!--                                <li>-->
<!--                                    <a style="color: white; cursor: pointer" id="satis_faturasi_getir">Satış-->
<!--                                        Faturası</a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a style="color: white; cursor: pointer" id="satis_irsaliye_getir">Satış-->
<!--                                        İrsaliye</a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a style="color: white; cursor: pointer" id="alinan_siparisler">Alınan Sipariş</a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a style="color: white; cursor: pointer" id="perakende_satis">Perakende Satış</a>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        <li>-->
<!--                            <a href="">Satış Faturası Raporları<i class="fa fa-angle-left arrow"></i></a>-->
<!--                            <ul class="nav-2-level collapse">-->
<!--                                <li>-->
<!--                                    <a style="cursor: pointer; color: white" id="">Müşteriye Göre Fatura Listesi</a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a style="cursor: pointer; color: white" id="">Satıcılara Göre Fatura Listesi</a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a style="cursor: pointer; color: white" id="">KDV Durum Raporu</a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a style="cursor: pointer; color: white" id="">Fatura Karlılk Analizi</a>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </li>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <a href=""><i class="sidebar-item-icon fa fa-money"></i>-->
<!--                                <span class="nav-label">Nakit Yönetimi</span><i class="fa fa-angle-left arrow"></i></a>-->
<!--                            <ul class="nav-2-level collapse">-->
<!--                                <li>-->
<!--                                    <a style="color: white; cursor: pointer" id="kasa_tanimla_main">Kasa Tanımla</a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="">Kasa İşlemleri<i class="fa fa-angle-left arrow"></i></a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="kasa_acilis_fisi">Kasa Açılış-->
<!--                                                Fişi</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="kasa_tahsilat">Kasa-->
<!--                                                Tahsilat</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="kasa_odeme">Kasa Ödeme</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="kasa_virman">Kasa Virman</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="bankaya_yatan">Bankaya-->
<!--                                                Yatan</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="bankadan_cekilen">Bankadan-->
<!--                                                Çekilen</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="">Kasa Raporları<i class="fa fa-angle-left arrow"></i></a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="kasa_hesap_ekstresi">Kasa Hesap-->
<!--                                                Ekstersi</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <a href=""><i class="sidebar-item-icon fa fa fa-university"></i>-->
<!--                                <span class="nav-label">Finans Yönetimi</span><i class="fa fa-angle-left arrow"></i></a>-->
<!--                            <ul class="nav-2-level collapse">-->
<!--                                <li>-->
<!--                                    <a style="color: white; cursor: pointer" id="banka_tanimla_main">Banka Tanımla</a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="">Banka İşlemleri<i class="fa fa-angle-left arrow"></i></a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="banka_acilis_fisi">Banka Açılış-->
<!--                                                Fişi</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="havale_giris">EFT/Havale-->
<!--                                                Giriş</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="havale_cikis">EFT/Havale-->
<!--                                                Çıkış</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="banka_virman">Banka Virman</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="">POS İşlemleri<i class="fa fa-angle-left arrow"></i></a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="pos_hesap_tanim">POS Hesap-->
<!--                                                Tanımları</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="pos_cekimi_giris">POS-->
<!--                                                Çekimi</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="pos_tahsil_main">POS-->
<!--                                                Tahsili</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a href="">POS Raporları<i class="fa fa-angle-left arrow"></i></a>-->
<!--                                            <ul class="nav-2-level collapse">-->
<!--                                                <li>-->
<!--                                                    <a style="color: white; cursor: pointer" id="pos_hesap_ekstresi">POS-->
<!--                                                        Hesap Ekstresi</a>-->
<!--                                                </li>-->
<!--                                            </ul>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="">Kredi Kartı İşlemleri<i class="fa fa-angle-left arrow"></i></a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="kredi_karti_tanimla">Kredi-->
<!--                                                Kartı Tanımları</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="kredi_kartindan_odeme">Kredi-->
<!--                                                Kartından Ödeme</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="kredi_kart_odemesi">Kredi Kart-->
<!--                                                Ödemesi</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href=""><i class="fa fa-angle-left arrow"></i> Banka Raporları</a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="banka_hesap_ekstresi">Banka-->
<!--                                                Hesap Ekstresi</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href=""><i class="fa fa-angle-left arrow"></i> POS Hesap Ekstresi</a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="">POS Hesap Ekstresi</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href=""><i class="fa fa-angle-left arrow"></i> Kredi Kart Ekstresi</a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="kredi_kart_hesap_ekstresi">Kredi-->
<!--                                                Kart Ekstresi</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <a href=""><i class="sidebar-item-icon fa fa-list-alt"></i>-->
<!--                                <span class="nav-label">Çek-Senet</span><i class="fa fa-angle-left arrow"></i></a>-->
<!--                            <ul class="nav-2-level collapse">-->
<!--                                <li>-->
<!--                                    <a style="color: white; cursor: pointer" id="cek_stok_giris">Çek Stok</a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="">Çek İşlemleri<i class="fa fa-angle-left arrow"></i></a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="cek_senet_giris_bordrosu">Çek-->
<!--                                                Giriş Bordrosu</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="cek_senet_cikis_bordrosu">Çek-->
<!--                                                Çıkış Bordrosu</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="cek_senet_tahsil">Çek-->
<!--                                                Tahsil</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="cek_senet_odeme">Çek Ödeme</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="">Senet İşlemleri <i class="fa fa-angle-left arrow"></i></a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="senet_giris_bordrosu">Senet-->
<!--                                                Giriş Bordrosu</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="senet_cikis_bordrosu">Senet-->
<!--                                                Çıkış Bordrosu</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="senet_tahsil">Senet Tahsil</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="senet_odeme">Senet Ödeme</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="">Karşılıksız Çek İşlemleri<i class="fa fa-angle-left arrow"></i></a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="ciro_edilen_cek_karsiliksiz">Ciro-->
<!--                                                Edilen Çek Karşılıksız</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer"-->
<!--                                               id="tahsile_verilen_cek_karsiliksiz">Tahsile Verilen Çek Karşılıksız</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer"-->
<!--                                               id="teminata_verilen_cek_karsiliksiz">Teminata Verilen Çek-->
<!--                                                Karşılıksız</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="portfoydeki_karsiliksiz_cek">Portföydeki-->
<!--                                                Çek Karşılıksız</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href=""><i class="fa fa-angle-left arrow"></i> Çek - Senet Raporları</a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="">Çek Ve Senetler Listesi</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="">Çek Senet Giriş Listesi</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="">Çek Senet Çıkış Listesi</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="">Karşılıksız Çek Listesi</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <a href=""><i class="sidebar-item-icon fa fa-cog"></i>-->
<!--                                <span class="nav-label">Tanımlamalar</span><i class="fa fa-angle-left arrow"></i></a>-->
<!--                            <ul class="nav-2-level collapse">-->
<!--                                <li>-->
<!--                                    <a href="">Cari Parametreleri<i class="fa fa-angle-left arrow"></i></a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="bilanco_tanimlari">Bilanço-->
<!--                                                Tanımları</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="cari_turu_tanim">Cari Türü-->
<!--                                                Ekle</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="cari_grup_tanim">Cari Grubu-->
<!--                                                Ekle</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="">Fatura Tanımları<i class="fa fa-angle-left arrow"></i></a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="fatura_turu_tanim">Fatura Türü-->
<!--                                                Tanımları</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="fatura_tipi_tanim">Fatura Tipi-->
<!--                                                Tanımları</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="">Stok Tanımları<i class="fa fa-angle-left arrow"></i></a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="birim_tanim">Birim</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="ana_grup">Stok Ana Grubu</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="alt_grup">Stok Alt Grubu</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="marka_listesi_main">Marka-->
<!--                                                Listesi</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="model_listesi_main">Model-->
<!--                                                Listesi</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="depo_listesi_main">Depolar</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <a href=""><i class="sidebar-item-icon fa fa-users"></i>-->
<!--                                <span class="nav-label">Personel Yönetimi</span><i-->
<!--                                        class="fa fa-angle-left arrow"></i></a>-->
<!--                            <ul class="nav-2-level collapse">-->
<!--                                <li>-->
<!--                                    <a href="">Personel İşlemleri<i class="fa fa-angle-left arrow"></i></a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="personel_tanimla">Personel-->
<!--                                                Tanımla</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="maas_tahakkuk">Maaş-->
<!--                                                Tahakkukları</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="personel_izin">Personel-->
<!--                                                İzin</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="personel_devamsizlik">Personel-->
<!--                                                Devamsızlık</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="">Personel Tanımları<i class="fa fa-angle-left arrow"></i></a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="gorev_tanim">Görev Tanım</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="departman_tanim">Departman-->
<!--                                                Tanım</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="meslek_tanim">Meslek Tanım</a>-->
<!--                                        </li>-->
<!--                                        <!--                                <li>-->-->
<!--                                        <!--                                    <a style="color: white; cursor: pointer" id="servis_tanim">Servis Tanım</a>-->-->
<!--                                        <!--                                </li>-->-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </li>-->
<!--                        <li>-->
<!--                            <a href="javascript:" id="users_root"><i class="sidebar-item-icon fa fa-user"></i>-->
<!--                                <span class="nav-label">Kullanıcılar</span></a>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                </li>-->
                <li>
                    <a href=""><i class="sidebar-item-icon fa fa-truck"></i>
                        <span class="nav-label" style="font-weight: bold; color: white">KONTEYNER İŞLEMLERİ</span><i class="fa fa-angle-left arrow"></i></a>
                    <ul>
                        <li>
                            <a href=""><i class="sidebar-item-icon fa fa-car"></i>
                                <span class="nav-label" style="font-weight: bold; color: white">ARAÇ YÖNETİMİ</span><i class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a style="color: white; cursor: pointer" id="arac_tanimla_main">Araç Tanımla</a>
                                </li>
<!--                                <li>-->
<!--                                    <a href="">Araç İşlemleri<i class="fa fa-angle-left arrow"></i></a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="arac_hgs_giderleri">HGS-->
<!--                                                Giderleri</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="arac_sgk_giderleri">SGK-->
<!--                                                Giderleri</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="arac_vergi_giderleri">Vergi-->
<!--                                                Ödemeleri</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="yonetim_giderleri">Yönetim-->
<!--                                                Giderleri</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="arac_gider">Araç Giderleri</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="arac_kaza_ceza_giderleri">Kaza-->
<!--                                                - Ceza Giderleri</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="">Araç Raporları<i class="fa fa-angle-left arrow"></i></a>-->
<!--                                    <ul class="nav-2-level collapse">-->
<!--                                        <li>-->
<!--                                            <a style="cursor: pointer; color: white" id="">Araç Ekstresi</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="cursor: pointer; color: white" id="">Araç Borç Alacak Durumu</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
                            </ul>
                        </li>
                        <li>
                            <a href=""><i class="sidebar-item-icon fa fa-play-circle"></i>
                                <span class="nav-label" style="font-weight: bold; color: white">SEFER İŞLEMLERİ</span><i class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a style="color: white; cursor: pointer" id="siparis_islemleri_nakliye">Sipariş
                                        İşlemleri</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="nakliye_irsaliye_islemleri">İrsaliye
                                        İşlemleri</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="nakliye_toplu_irsaliye_islemleri">Toplu
                                        İrsaliye İşlemleri</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="tum_sefer_irsaliye_listesi">Tüm Sefer
                                        İrsaliyeleri</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="toplu_siparis_listesi">Toplu Sipariş Listesi</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href=""><i class="sidebar-item-icon fa fa-hand-lizard-o"></i>
                                <span class="nav-label" style="font-weight: bold; color: white">YAKIT İŞLEMLERİ</span><i class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a style="color: white; cursor: pointer" id="yakit_cikis_fisleri">Yakıt Çıkış
                                        Fişleri</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="kiralik_yakit_cikis_fisleri_list">Kiralık
                                        Yakıt Çıkış Fişleri Listesi</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="yakit_fis_faturasi">Yakıt
                                        Faturaları</a>
                                </li>
                                <li>
                                    <a href=""><i class="sidebar-item-icon"></i>
                                        <span class="nav-label">Depo İşlemleri</span><i
                                                class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="yakit_deposu_tanimla_main">Yakıt
                                                Deposu Tanımla</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
<!--                        <li>-->
<!--                            <a href=""><i class="sidebar-item-icon fa fa-industry"></i>-->
<!--                                <span class="nav-label">Sanayi İşlemleri</span><i-->
<!--                                        class="fa fa-angle-left arrow"></i></a>-->
<!--                            <ul class="nav-2-level collapse">-->
<!--                                <li>-->
<!--                                    <a style="color: white; cursor: pointer" id="sanayi_fisleri">Sanayi Fişleri</a>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a style="color: white; cursor: pointer" id="sanayi_faturalandir">Sanayi Fişi-->
<!--                                        Faturalandır</a>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </li>-->
                        <li>
                            <a href=""><i class="sidebar-item-icon fa fa-money"></i>
                                <span class="nav-label" style="font-weight: bold; color: white">SÜRÜCÜ PRİM</span><i class="fa fa-angle-left arrow"></i></a>
                            <ul class="nav-2-level collapse">
                                <li>
                                    <a style="color: white; cursor: pointer" id="surucu_prim_odeme">Sürücü Prim Ödeme</a>
                                </li>
                                <li>
                                    <a href=""><i class="sidebar-item-icon"></i>
                                        <span class="nav-label">Sürücü Prim Raporları</span><i
                                                class="fa fa-angle-left arrow"></i></a>
                                    <ul class="nav-2-level collapse">
                                        <li>
                                            <a style="color: white; cursor: pointer" id="prim_kazanc_listesi">Ödenmiş
                                                Primler</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="odenmemis_primler_listesi">Ödenmemiş
                                                Primler</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="">Aylara
                                                Göre Sürücü Prim</a>
                                        </li>
                                        <li>
                                            <a style="color: white; cursor: pointer" id="">Aylara
                                                Göre Araç Prim</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" id=""><i class="sidebar-item-icon fa fa-cube"></i>
                                <span class="nav-label" id="" style="font-weight: bold; color: white">NAKLİYE DEPOLAMA</span><i
                                        class="fa fa-angle-left arrow"></i></a>
                            <ul>
                                <li>
                                    <a style="color: white; cursor: pointer" id="nakliye_depolama_islemleri">Nakliye
                                        Depo Giriş</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="nakliye_depolama_cikis">Nakliye Depo
                                        Çıkış</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href=""><i class="sidebar-item-icon fa fa-pie-chart"></i>
                        <span class="nav-label" style="font-weight: bold; color: white">DEPO HİZMETLERİ</span><i class="fa fa-angle-left arrow"></i></a>
                    <ul>
                        <li>
                            <a href="#" id=""><i class="sidebar-item-icon fa fa-cube"></i>
                                <span class="nav-label" id="" style=" color: white">ACENTE HİZMETLERİ</span><i
                                        class="fa fa-angle-left arrow"></i></a>
                            <ul>
                                <li>
                                    <a style="color: white; cursor: pointer" id="acente_konteyner_giris">Konteyner Giriş</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="acente_konteyner_cikis">Konteyner Çıkış</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="depo_acente_tanimlari">Hizmet Tanımları</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="depo_acente_kondisyon_tanimlari">Kondisyon Tanımları</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="konteyner_toplu_tanim">Konteyner Toplu
                                        Tanım</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="estimate_islemleri">Estimate İşlemleri</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" id=""><i class="sidebar-item-icon fa fa-cube"></i>
                                <span class="nav-label" id="" style=" color: white">DEPO HİZMETLERİ</span><i
                                        class="fa fa-angle-left arrow"></i></a>
                            <ul>
                                <li>
                                    <a style="color: white; cursor: pointer" id="depo_ithalat_is_emri">Özmal Depo İş Emri</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="kiralik_depo_is_emri">Kiralık Depo İş Emri</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer"
                                       id="is_emri_konteyner_tanim">Konteyner Tanım</a>
                                </li>
                                <!--                                <li>-->
                                <!--                                    <a style="color: white; cursor: pointer"-->
                                <!--                                       id="gelmesi_beklenen_konteynerler_listesi">Gelmesi Beklenen Konteynerler</a>-->
                                <!--                                </li>-->
                                <li>
                                    <a style="color: white;cursor:pointer;" id="konteyner_giris_main"><span class="nav-label">Konteyner Giriş</span></a>
                                </li>
                                <li>
                                    <a style="color: white;cursor:pointer;" id="konteyner_cikis_main"><span class="nav-label">Konteyner Çıkış</span></a>
                                </li>
                                <li>
                                    <a style="color: white;cursor:pointer;" id="depo_arac_tanim"><span class="nav-label">Araç Tanım</span></a>
                                </li>
                                <li>
                                    <a style="color: white;cursor:pointer;" id="arac_giris_main"><span class="nav-label">Araç Giriş</span></a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" id=""><i class="sidebar-item-icon fa fa-cog"></i>
                                <span class="nav-label" id="" style=" color: white">TANIMLAMALAR</span><i
                                        class="fa fa-angle-left arrow"></i></a>
                            <ul>
                                <li>
                                    <a style="color: white; cursor: pointer" id="konteyner_adres_tanimi">Adres
                                        Tanımlama</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="mal_cinsi_tanimi">Mal Cinsi Tanımı</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="forklift_tanim_button">Forklift
                                        Tanım</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="kalmar_tanim_button">Kalmar Tanım</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" id=""><i class="sidebar-item-icon fa fa-check"></i>
                                <span class="nav-label" id="" style=" color: white">PUANTÖR İŞLEMLERİ</span><i
                                        class="fa fa-angle-left arrow"></i></a>
                            <ul>
                                <li>
                                    <a style="color: white; cursor: pointer" id="acente_puantor_islemleri">Acente İşlemleri</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="sahaya_urun_ser">Sahaya Serme
                                        İşlemleri</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="konteynere_urun_aktar">Konteynere Ürün
                                        Aktar</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" id=""><i class="sidebar-item-icon fa fa-file"></i>
                                <span class="nav-label" id="" style=" color: white">RAPORLAR</span><i
                                        class="fa fa-angle-left arrow"></i></a>
                            <ul>
                                <li>
                                    <a style="color: white; cursor: pointer" id="is_emri_bazli_raporlar">İTHALAT Raporları</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="is_emri_ihracat_raporlari">İHRACAT Raporları</a>
                                </li>
                                <li>
                                    <a style="color: white; cursor: pointer" id="">Genel Raporlar</a>
                                </li>
                            </ul>
                        </li>
<!--                        <li>-->
<!--                            <a href="#" id=""><i class="sidebar-item-icon fa fa-shopping-basket"></i>-->
<!--                                <span class="nav-label" id="" style=" color: white">FATURALANDIRMA</span><i-->
<!--                                        class="fa fa-angle-left arrow"></i></a>-->
<!--                            <ul>-->
<!--                                <li>-->
<!--                                    <a href="#" id=""><span class="nav-label" id="" style=" color: white">ALIŞ YÖNETİMİ</span><i-->
<!--                                                class="fa fa-angle-left arrow"></i></a>-->
<!--                                    <ul>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="depo_alis_faturasi_main">Alış-->
<!--                                                Faturası</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="alis_hizmet_listesi">Alış-->
<!--                                                Hizmet Listesi</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                                <li>-->
<!--                                    <a href="#" id=""><span class="nav-label" id="" style=" color: white">SATIŞ YÖNETİMİ</span><i-->
<!--                                                class="fa fa-angle-left arrow"></i></a>-->
<!--                                    <ul>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="depo_satis_faturasi_main">Satış-->
<!--                                                Faturası</a>-->
<!--                                        </li>-->
<!--                                        <li>-->
<!--                                            <a style="color: white; cursor: pointer" id="gelmesi_beklenen_faturalar">Satış-->
<!--                                                Hizmet Listesi</a>-->
<!--                                        </li>-->
<!--                                    </ul>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </li>-->
                    </ul>
                </li>
<!--                <li>-->
<!--                    <a href=""><i class="sidebar-item-icon fa fa-pie-chart"></i>-->
<!--                        <span class="nav-label">Depo Hizmetleri</span><i class="fa fa-angle-left arrow"></i></a>-->
<!--                    <ul>-->
<!--                        <li>-->
<!--                            <a href="#"><i class="sidebar-item-icon fa fa-pie-chart"></i>-->
<!--                                <span class="nav-label">Acenta Hizmetleri</span><i class="fa fa-angle-left arrow"></i></a>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                </li>-->
            </ul>
        </div>
    </nav>
    <!-- END SIDEBAR-->
    <div class="content-wrapper" style="background-color: #9DB2BF;">
        <div class="modal-icerik"></div>
    </div>
</div>
<div class="sidenav-backdrop backdrop"></div>
<div class="preloader-backdrop">
    <div class="page-preloader">Loading</div>
</div>
<script src="./assets/vendors/jquery/dist/jquery.min.js" type="text/javascript"></script>
<script src="./assets/vendors/popper.js/dist/umd/popper.min.js" type="text/javascript"></script>
<script src="./assets/vendors/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
<script src="./assets/vendors/metisMenu/dist/metisMenu.min.js" type="text/javascript"></script>
<script src="./assets/vendors/chart.js/dist/Chart.min.js" type="text/javascript"></script>
<script src="./assets/vendors/jvectormap/jquery-jvectormap-2.0.3.min.js" type="text/javascript"></script>
<script src="./assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
<script src="./assets/vendors/jvectormap/jquery-jvectormap-us-aea-en.js" type="text/javascript"></script>
<script src="assets/js/app.min.js" type="text/javascript"></script>
<script src="./assets/js/scripts/dashboard_1_demo.js" type="text/javascript"></script>

<script>
    $("body").off("click", "#stok_fire_cikis").on("click", "#stok_fire_cikis", function () {
        $.get("view/stok_fire.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#stok_acilis").on("click", "#stok_acilis", function () {
        $.get("view/stok_acilis_fisi.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#nakliye_depolama_cikis").on("click", "#nakliye_depolama_cikis", function () {
        $.get("depo/view/nakliye_depolama_cikis.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#konteyner_giris_main").on("click", "#konteyner_giris_main", function () {
        $.get("depo/view/konteyner_giris_main.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#arac_giris_main").on("click", "#arac_giris_main", function () {
        $.get("depo/view/arac_giris_main.php", function (getList) {
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#konteyner_cikis_main").on("click", "#konteyner_cikis_main", function () {
        $.get("depo/view/konteyner_cikis_main.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#depo_arac_tanim").on("click", "#depo_arac_tanim", function () {
        $.get("depo/view/depo_arac_tanim.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#depo_siparis_islemleri").on("click", "#depo_siparis_islemleri", function () {
        $.get("depo/view/depo_siparis_islemleri.php", function (getList) {
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#forklift_tanim_button").on("click", "#forklift_tanim_button", function () {
        $.get("depo/view/forklift_tanim.php", function (getList) {
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kalmar_tanim_button").on("click", "#kalmar_tanim_button", function () {
        $.get("depo/view/kalmar_tanim.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#sahaya_urun_ser").on("click", "#sahaya_urun_ser", function () {
        $.get("depo/view/sahaya_urun_ser.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#acente_puantor_islemleri").on("click", "#acente_puantor_islemleri", function () {
        $.get("depo/view/acente_puantor_islemleri.php", function (getList) {
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#sahaya_konteyner_ser").on("click", "#sahaya_konteyner_ser", function () {
        $.get("depo/view/sahaya_konteyner_ser.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#konteynere_urun_aktar").on("click", "#konteynere_urun_aktar", function () {
        $.get("depo/view/konteynere_urun_aktar.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#gelmesi_beklenen_faturalar").on("click", "#gelmesi_beklenen_faturalar", function () {
        $.get("depo/view/gelmesi_beklenen_faturalar.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#alis_hizmet_listesi").on("click", "#alis_hizmet_listesi", function () {
        $.get("depo/view/alis_hizmet_listesi.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#depo_alis_faturasi_main").on("click", "#depo_alis_faturasi_main", function () {
        $.get("depo/view/depo_alis_faturasi_main.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#depo_satis_faturasi_main").on("click", "#depo_satis_faturasi_main", function () {
        $.get("depo/view/depo_satis_faturasi_main.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#is_emri_bazli_raporlar").on("click", "#is_emri_bazli_raporlar", function () {
        $.get("depo/view/is_emri_bazli_raporlar.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#is_emri_ihracat_raporlari").on("click", "#is_emri_ihracat_raporlari", function () {
        $.get("depo/view/is_emri_ihracat_raporlari.php", function (getList) {
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#depo_ithalat_siparis").on("click", "#depo_ithalat_siparis", function () {
        $.get("depo/view/depo_ithalat_siparis.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#depo_ithalat_is_emri").on("click", "#depo_ithalat_is_emri", function () {
        $.get("depo/view/depo_ithalat_is_emri.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kiralik_depo_is_emri").on("click", "#kiralik_depo_is_emri", function () {
        $.get("depo/view/kiralik_depo_is_emri.php", function (getList) {
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#konteyner_adres_tanimi").on("click", "#konteyner_adres_tanimi", function () {
        $.get("depo/view/konteyner_adres_tanimi.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#mal_cinsi_tanimi").on("click", "#mal_cinsi_tanimi", function () {
        $.get("depo/view/mal_cinsi_tanimi.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#depo_konteyner_giris").on("click", "#depo_konteyner_giris", function () {
        $.get("depo/view/depo_konteyner_giris.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#is_emri_konteyner_tanim").on("click", "#is_emri_konteyner_tanim", function () {
        $.get("depo/view/is_emri_konteyner_tanim.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#gelmesi_beklenen_konteynerler_listesi").on("click", "#gelmesi_beklenen_konteynerler_listesi", function () {
        $.get("depo/view/gelmesi_beklenen_konteynerler_listesi.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#konteyner_toplu_tanim").on("click", "#konteyner_toplu_tanim", function () {
        $.get("depo/view/konteyner_toplu_tanim.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#depo_acente_kondisyon_tanimlari").on("click", "#depo_acente_kondisyon_tanimlari", function () {
        $.get("depo/view/depo_acente_kondisyon_tanimlari.php", function (getList) {
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#depo_acente_tanimlari").on("click", "#depo_acente_tanimlari", function () {
        $.get("depo/view/depo_acente_tanimlari.php", function (getList) {
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#acente_konteyner_giris").on("click", "#acente_konteyner_giris", function () {
        $.get("depo/view/acente_konteyner_giris.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#acente_konteyner_cikis").on("click", "#acente_konteyner_cikis", function () {
        $.get("depo/view/acente_konteyner_cikis.php", function (getList) {
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#estimate_islemleri").on("click", "#estimate_islemleri", function () {
        $.get("depo/view/estimate_islemleri.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#nakliye_depolama_islemleri").on("click", "#nakliye_depolama_islemleri", function () {
        $.get("depo/view/nakliye_depolama_islemleri.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#gecmis_konteyner_girisleri").on("click", "#gecmis_konteyner_girisleri", function () {
        $.get("depo/view/gecmis_konteyner_girisleri.php", function (getList) {
            $(".modal-icerik").html(getList);
        });
    });
    // BURADAYIM
    $("body").off("click", "#muhasebe_gider_faturalari").on("click", "#muhasebe_gider_faturalari", function () {
        $.get("view/muhasebe_gider_faturalari.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cari_vadesin_gore_tahsilat").on("click", "#cari_vadesin_gore_tahsilat", function () {
        $(".modal-icerik").html("");
        $(".modal-icerik").html("");
        $.get("modals/cari_diger_modal/vadesine_gore_tahsilat.php?islem=vade_kriterleri_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        });
    });
    $("body").off("click", "#prim_kazanc_listesi").on("click", "#prim_kazanc_listesi", function () {
        $.get("konteyner/view/prim_kazanc_listesi.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#odenmemis_primler_listesi").on("click", "#odenmemis_primler_listesi", function () {
        $.get("konteyner/view/odenmemis_primler_listesi.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#aylik_tahsilat_listesi").on("click", "#aylik_tahsilat_listesi", function () {
        $(".modal-icerik").html("");
        $(".modal-icerik").html("");
        $.get("modals/cari_diger_modal/aylik_tahsilat.php?islem=aylik_tahsilat_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        });
    });
    $("body").off("click", "#cari_vadesine_gore_odeme").on("click", "#cari_vadesine_gore_odeme", function () {
        $(".modal-icerik").html("");
        $(".modal-icerik").html("");
        $.get("modals/cari_diger_modal/vadesine_gore_odeme.php?islem=vade_kriterleri_modal", function (getModal) {
            $(".getModals").html("");
            $(".getModals").html(getModal);
        });
    });
    $("body").off("click", "#tahsile_verilen_cek_karsiliksiz").on("click", "#tahsile_verilen_cek_karsiliksiz", function () {
        $.get("view/tahsile_verilen_cek_karsiliksiz.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kredi_kart_hesap_ekstresi").on("click", "#kredi_kart_hesap_ekstresi", function () {
        $.get("view/kredi_kart_hesap_ekstresi.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#yakit_cikis_fisleri").on("click", "#yakit_cikis_fisleri", function () {
        $.get("konteyner/view/yakit_cikis_fisleri.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#lastik_alis_fatura").on("click", "#lastik_alis_fatura", function () {
        $.get("konteyner/view/lastik_alis_yap.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#nakliye_depolama_islemleri").on("click", "#nakliye_depolama_islemleri", function () {
        $.get("depo/view/nakliye_depolama_islemleri.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#toplu_siparis_listesi").on("click", "#toplu_siparis_listesi", function () {
        $.get("konteyner/view/toplu_siparis_listesi.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#nakliye_depolama_cikis").on("click", "#nakliye_depolama_cikis", function () {
        $.get("depo/view/nakliye_depolama_cikis.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#lastik_alis_irsaliye").on("click", "#lastik_alis_irsaliye", function () {
        $.get("konteyner/view/lastik_alis_irsaliye.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#tum_sefer_irsaliye_listesi").on("click", "#tum_sefer_irsaliye_listesi", function () {
        $.get("konteyner/view/tum_sefer_irsaliye_listesi.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#surucu_prim_raporlari").on("click", "#surucu_prim_raporlari", function () {
        $.get("konteyner/view/surucu_prim_raporlari.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#surucu_prim_odeme").on("click", "#surucu_prim_odeme", function () {
        $.get("konteyner/view/surucu_prim_odeme.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#sanayi_fisleri").on("click", "#sanayi_fisleri", function () {
        $.get("konteyner/view/sanayi_fisleri.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#lastik_takma_main").on("click", "#lastik_takma_main", function () {
        $.get("konteyner/view/lastik_takma.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#sanayi_faturalandir").on("click", "#sanayi_faturalandir", function () {
        $.get("konteyner/view/sanayi_faturalandir.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#yonetim_giderleri").on("click", "#yonetim_giderleri", function () {
        $.get("konteyner/view/yonetim_giderleri.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#arac_hgs_giderleri").on("click", "#arac_hgs_giderleri", function () {
        $.get("konteyner/view/arac_hgs_giderleri.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#arac_vergi_giderleri").on("click", "#arac_vergi_giderleri", function () {
        $.get("konteyner/view/arac_vergi_giderleri.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#arac_gider").on("click", "#arac_gider", function () {
        $.get("konteyner/view/arac_gider.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kredi_kartindan_odeme").on("click", "#kredi_kartindan_odeme", function () {
        $.get("view/kredi_kartindan_odeme.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#arac_tanimla_main").on("click", "#arac_tanimla_main", function () {
        $.get("konteyner/view/arac_tanimla.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#yakit_fis_faturasi").on("click", "#yakit_fis_faturasi", function () {
        $.get("konteyner/view/yakit_fis_faturasi.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#siparis_islemleri_nakliye").on("click", "#siparis_islemleri_nakliye", function () {
        $.get("konteyner/view/siparis_islemleri_nakliye.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#arac_sgk_giderleri").on("click", "#arac_sgk_giderleri", function () {
        $.get("konteyner/view/arac_sgk_giderleri.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#arac_kaza_ceza_giderleri").on("click", "#arac_kaza_ceza_giderleri", function () {
        $.get("konteyner/view/arac_kaza_ceza_giderleri.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#yakit_deposu_tanimla_main").on("click", "#yakit_deposu_tanimla_main", function () {
        $.get("konteyner/view/yakit_deposu_tanimla.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#nakliye_toplu_irsaliye_islemleri").on("click", "#nakliye_toplu_irsaliye_islemleri", function () {
        $.get("konteyner/view/nakliye_toplu_irsaliye_islemleri.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#nakliye_irsaliye_islemleri").on("click", "#nakliye_irsaliye_islemleri", function () {
        $.get("konteyner/view/nakliye_irsaliye_islemleri.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kiralik_yakit_cikis_fisleri_list").on("click", "#kiralik_yakit_cikis_fisleri_list", function () {
        $.get("konteyner/view/kiralik_yakit_cikis_fisleri_list.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#pos_hesap_tanim").on("click", "#pos_hesap_tanim", function () {
        $.get("view/pos_hesap_tanim.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#pos_cekimi_giris").on("click", "#pos_cekimi_giris", function () {
        $.get("view/pos_cekimi_giris.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#pos_tahsil_main").on("click", "#pos_tahsil_main", function () {
        $.get("view/pos_tahsil_main.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#senet_cikis_bordrosu").on("click", "#senet_cikis_bordrosu", function () {
        $.get("view/senet_cikis_bordrosu.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#teminata_verilen_cek_karsiliksiz").on("click", "#teminata_verilen_cek_karsiliksiz", function () {
        $.get("view/teminata_verilen_cek_karsiliksiz.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#senet_tahsil").on("click", "#senet_tahsil", function () {
        $.get("view/senet_tahsil.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kredi_kart_odemesi").on("click", "#kredi_kart_odemesi", function () {
        $.get("view/kredi_kart_odemesi.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#senet_giris_bordrosu").on("click", "#senet_giris_bordrosu", function () {
        $.get("view/senet_giris_bordrosu.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cek_stok_giris").on("click", "#cek_stok_giris", function () {
        $.get("view/cek_stok_giris.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cek_senet_tahsil").on("click", "#cek_senet_tahsil", function () {
        $.get("view/cek_senet_tahsil.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cek_senet_odeme").on("click", "#cek_senet_odeme", function () {
        $.get("view/cek_senet_odeme.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#portfoydeki_karsiliksiz_cek").on("click", "#portfoydeki_karsiliksiz_cek", function () {
        $.get("view/portfoydeki_karsiliksiz_cek.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cek_senet_giris_bordrosu").on("click", "#cek_senet_giris_bordrosu", function () {
        $.get("view/cek_senet_giris_bordrosu.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#ciro_edilen_cek_karsiliksiz").on("click", "#ciro_edilen_cek_karsiliksiz", function () {
        $.get("view/ciro_edilen_cek_karsiliksiz.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#stok_ekstresi").on("click", "#stok_ekstresi", function () {
        $.get("view/stok_ekstresi.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#senet_odeme").on("click", "#senet_odeme", function () {
        $.get("view/senet_odeme.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cek_senet_cikis_bordrosu").on("click", "#cek_senet_cikis_bordrosu", function () {
        $.get("view/cek_senet_cikis_bordrosu.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#fatura_tipi_tanim").on("click", "#fatura_tipi_tanim", function () {
        $.get("view/fatura_tipi.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#perakende_satis").on("click", "#perakende_satis", function () {
        $.get("view/perakende_satis.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cari_hesap_ekstre").on("click", "#cari_hesap_ekstre", function () {
        $.get("view/cari_hesap_ekstre.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kasa_hesap_ekstresi").on("click", "#kasa_hesap_ekstresi", function () {
        $.get("view/kasa_hesap_ekstresi.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cari_turu_tanim").on("click", "#cari_turu_tanim", function () {
        $.get("view/cari_turu_tanim.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#banka_hesap_ekstresi").on("click", "#banka_hesap_ekstresi", function () {
        $.get("view/banka_hesap_ekstresi.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#havale_cikis").on("click", "#havale_cikis", function () {
        $.get("view/havale_cikis.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cari_grup_tanim").on("click", "#cari_grup_tanim", function () {
        $.get("view/cari_grup_tanim.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#servis_tanim").on("click", "#servis_tanim", function () {
        $.get("view/servis_tanim.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kasa_odeme").on("click", "#kasa_odeme", function () {
        $.get("view/kasa_odeme.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#personel_devamsizlik").on("click", "#personel_devamsizlik", function () {
        $.get("view/personel_devamsizlik.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#gorev_tanim").on("click", "#gorev_tanim", function () {
        $.get("view/gorev_tanim.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#fatura_turu_tanim").on("click", "#fatura_turu_tanim", function () {
        $.get("view/fatura_turu.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#banka_virman").on("click", "#banka_virman", function () {
        $.get("view/banka_virman.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#maas_tahakkuk").on("click", "#maas_tahakkuk", function () {
        $.get("view/maas_tahakkuk.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#meslek_tanim").on("click", "#meslek_tanim", function () {
        $.get("view/meslek_tanim.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#departman_tanim").on("click", "#departman_tanim", function () {
        $.get("view/departman_tanim.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#personel_tanimla").on("click", "#personel_tanimla", function () {
        $.get("view/personel_tanimla.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#personel_izin").on("click", "#personel_izin", function () {
        $.get("view/personel_izin.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kasa_virman").on("click", "#kasa_virman", function () {
        $.get("view/kasa_virman.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#bankaya_yatan").on("click", "#bankaya_yatan", function () {
        $.get("view/bankaya_yatan.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#banka_acilis_fisi").on("click", "#banka_acilis_fisi", function () {
        $.get("view/banka_acilis_fisi.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#havale_giris").on("click", "#havale_giris", function () {
        $.get("view/havale_giris.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kasa_acilis_fisi").on("click", "#kasa_acilis_fisi", function () {
        $.get("view/kasa_acilis_fisi.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#bankadan_cekilen").on("click", "#bankadan_cekilen", function () {
        $.get("view/bankadan_cekilen.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#stok_raporlari").on("click", "#stok_raporlari", function () {
        $.get("view/stok_raporlari.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cari_raporlari").on("click", "#cari_raporlari", function () {
        $.get("view/cari_raporlari.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#kasa_tahsilat").on("click", "#kasa_tahsilat", function () {
        $.get("view/kasa_tahsilat.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#mahsup_fisleri").on("click", "#mahsup_fisleri", function () {
        $.get("view/mahsup_fisleri.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cari_acilis_fisi").on("click", "#cari_acilis_fisi", function () {
        $.get("view/cari_acilis_fisi.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        });
    });
    $("body").off("click", "#cari_tanimla").on("click", "#cari_tanimla", function () {
        $.get("view/add_cari_page.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#stok_tanimla_main").on("click", "#stok_tanimla_main", function () {
        $.get("view/add_stok_page.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#alinan_siparisler").on("click", "#alinan_siparisler", function () {
        $.get("view/satis_siparis.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#satis_irsaliye_getir").on("click", "#satis_irsaliye_getir", function () {
        $.get("view/satis_irsaliye.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        })
    })

    $("body").off("click", "#cikis_yap").on("click", "#cikis_yap", function () {
        $.ajax({
            url: "controller/sql.php?islem=logout",
            type: "POST",
            success: function (result) {
                if (result != 2) {
                    Swal.fire(
                        'Başarılı!',
                        'Güvenli Çıkış Sağlanıyor',
                        'success'
                    );
                    setTimeout(function () {
                        location.reload();
                    }, 800);
                }
            }
        });
    });

    $("body").off("click", "#birim_tanim").on("click", "#birim_tanim", function () {
        $.get("view/birim_tanim.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        })
    })

    $("body").off("click", "#ana_grup").on("click", "#ana_grup", function () {
        $.get("view/stok_ana_grup_tanim.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#irsaliyeler").on("click", "#irsaliyeler", function () {
        $.get("view/irsaliye_olustur.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        })
    })

    $("body").off("click", "#alt_grup").on("click", "#alt_grup", function () {
        $.get("view/stok_alt_grup_tanim.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        })
    })

    $("body").off("click", "#marka_listesi_main").on("click", "#marka_listesi_main", function () {
        $.get("view/marka_listesi.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#model_listesi_main").on("click", "#model_listesi_main", function () {
        $.get("view/model_listesi.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#depo_listesi_main").on("click", "#depo_listesi_main", function () {
        $.get("view/depolar.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#bilanco_tanimlari").on("click", "#bilanco_tanimlari", function () {
        $.get("view/bilanco.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#kasa_tanimla_main").on("click", "#kasa_tanimla_main", function () {
        $.get("view/kasa_tanim.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#banka_tanimla_main").on("click", "#banka_tanimla_main", function () {
        $.get("view/banka_tanim.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#satis_faturasi_getir").on("click", "#satis_faturasi_getir", function () {
        $.get("view/satis_fatura.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#alis_faturasi_getir_main").on("click", "#alis_faturasi_getir_main", function () {
        $.get("view/alis_fatura.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#pos_hesap_ekstresi").on("click", "#pos_hesap_ekstresi", function () {
        $.get("view/pos_hesap_ekstresi.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        })
    })
    $("body").off("click", "#verilen_siparisler").on("click", "#verilen_siparisler", function () {
        $.get("view/verilen_siparisler.php", function (getList) {
            $(".modal-icerik").html("");
            $(".modal-icerik").html(getList);
        })
    })
</script>