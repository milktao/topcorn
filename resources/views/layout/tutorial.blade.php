<div class="modal fade" id="tutorial" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" ng-class="{'modal-lg':current_level>1}" role="document">

    <!--USERS MANUAL-->
    <div class="modal-content" ng-if="current_level < 2">
      <div class="modal-header">
        <h5 class="modal-title">Kullanım Klavuzu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Zaten kullanımı çok basit olan topcornun bütün temel özelliklerini öğrenmen ve mantığını kavraman için sana kısa bir kurs hazırladık. 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" ng-click="tutorial(1)">Sonra Yap</button>
        <button type="button" class="btn btn-primary" ng-click="tutorial(100)">Kursa Başlayalım</button>
      </div>
    </div>
    <!--USERS MANUAL-->



    <!--QUICK RATE-->
    <div class="modal-content" ng-if="current_level > 99 && current_level < 200">
      <div class="modal-header">
        <h5 class="modal-title">1 - Peş Peşe Oyla</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group">
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 100}">
            <div class="h6 text-muted">Ne İşe Yarar?</div>
            Topcorn, daha önce izlediğin filmlere verdiğin oylardan yola çıkarak senin film zevkini öğrenir ve sana özel film önerilerinde bulunur. Bu özellik en sıklıkla oylanan filmleri sana sorarak profilini güçlendirmene yardımcı olur. 
            <div class="h6 text-muted mt-4">Özelliğe Erişim</div>
            Peş Peşe Oylamak için sayfanın en üstündeki gezinti çubuğundaki <span class="badge badge-secondary"><i class="fa fa-star-half-o" aria-hidden="true"></i> Peş Peşe Oyla</span> tuşuna basabilirsin.
            <div class="py-2"><span class="text-muted">Görev: </span><span ng-class="{'badge badge-danger':current_level < 101}">Peş Peşe Oylama özelliğini çalıştır.</span> <i class="fa fa-check" ng-show="current_level > 100"></i></div>
          </li>
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 101}" ng-if="current_level > 100">
            <div class="h6 text-muted">Neye Göre Oy Vermelisin?</div>
            İzlediğin her film için cevap vermen gereken yalnızca bir soru vardır: 
            <div class="lead py-2">"Eğer bu filmi izlememiş olsaydın, Topcorn'un bunu sana önermesini ister miydin?"</div>
            Bu soruya verebileceğin 6 muhtemel yanıt vardır:
            <div class="py-2"><span class="badge badge-secondary">İzlemedim</span> -> İzlemediğin filmler için</div>
            <div class="py-2"><span class="badge badge-secondary">Sakın</span> -> İzlediğine çok pişman olduğun ve kesinlikle senin için zaman kaybı olduğunu düşündüğün filmler için</div>
            <div class="py-2"><span class="badge badge-secondary">Önerme</span> -> İzlemeseydim de olurdu dediğin filmler için</div>
            <div class="py-2"><span class="badge badge-secondary">Kararsız</span> -> İyi hatırlayamadığın, olumlu ya da olumsuz bir fikrinin olmadığı filmler için</div>
            <div class="py-2"><span class="badge badge-secondary">Öner</span> -> Beğendiğin filmler için</div>
            <div class="py-2"><span class="badge badge-secondary">Kesinlikle</span> -> Kesinlikle, ne olursa olsun izlenmesi gereken filmler için</div>
            <div class="h6 text-muted mt-4">Film Oylama</div>
            <div class="py-2"><span class="text-muted">Görev: </span><span ng-class="{'badge badge-danger':current_level < 102}">5 filmi oyla.</span> <i class="fa fa-check" ng-show="current_level > 101"></i></div>
            <div class="mt-2"><small>Filmin adına tıklayıp, filmin sayfasına gidebilirsin.</small></div>
            <div class="mt-2"><span class="h6 badge badge-secondary"><i class="fa fa-clock-o" aria-hidden="true"></i></span><small> tuşuna basıp, daha sonra izlemeye karar verdiğin filmleri "Sonra İzle" listene kaydedebilirsin.</small></div>
            <div class="mt-2"><span class="h6 badge badge-secondary"><i class="fa fa-ban" aria-hidden="true"></i></span><small> tuşuna basıp, tavsiye listende görmek istemediğin filmleri "Banlananlar" listene kaydedebilirsin.</small></div>
            <div class="mt-2"><span class="h6 badge badge-secondary"><i class="fa fa-undo" aria-hidden="true"></i></span><small> tuşuna basıp, son verdiğin oyu geri alabilirsin.</small></div>
          </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button ng-click="level_up(1)">level atla</button>
        <button type="button" class="btn btn-primary" ng-disabled="current_level < 102" ng-click="tutorial(200)">Sonraki Ders</button>
      </div>
    </div>
    <!--QUICK RATE-->




    <!--SEARCH-->
    <div class="modal-content" ng-if="current_level > 199 && current_level < 300">
      <div class="modal-header">
        <h5 class="modal-title">2 - Arama Sayfası</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group">
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 200}">
            <div class="h6 text-muted">Sayfaya Erişim</div>
            Arama sayfasına ulaşmak için sayfanın en üstündeki gezinti çubuğundaki <span class="h6 badge badge-secondary"><i class="fa fa-search" aria-hidden="true"></i> Ara</span> veya sayfanın en altında altbilgisindeki <span class="h6 badge badge-secondary">Film/Kişi/Kullanıcı Ara</span> linklerinden birine tıklayabilirsin.
            <div class="py-2"><span class="text-muted">Görev: </span><span ng-class="{'badge badge-danger':current_level < 201}">Arama sayfasına git.</span> <i class="fa fa-check" ng-show="current_level > 200"></i></div>
          </li>
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 201}" ng-if="current_level > 200">
            <div class="h6 text-muted">Film Arama</div>
            Film aramak için <span class="h6 badge badge-secondary">Film</span> sekmesinde arama çubuğuna aramak istediğin filmin adını yazabilirsin.
            <div class="py-2"><span class="text-muted">Görev: </span><span ng-class="{'badge badge-danger':current_level < 202}">Bir film ara.</span> <i class="fa fa-check" ng-show="current_level > 201"></i></div>
            <div class="h6 text-muted mt-4">Kişi Arama</div>
            Yönetmen, oyuncu, kameraman, yapımcı vb profesyonellerin hepsini kısaca kişi olarak adlandırdık. Kişi aramak için <span class="h6 badge badge-secondary">Kişi</span> sekmesinde arama çubuğuna aramak istediğin kişinin adını yazabilirsin.
            <div class="h6 text-muted mt-4">Kullanıcı Arama</div>
            Topcorn kullanıcılarını aramak için <span class="h6 badge badge-secondary">Kullanıcı</span> sekmesinde arama çubuğuna aramak istediğin kullanıcının adını veya e-postasını yazabilirsin.
          </li>
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 202}" ng-if="current_level > 201">
            <div class="h6 text-muted">Aratılan Filmi Oylama</div>
            Film aradıktan sonra çıkan listede muhtemelen birçok filmin olduğu liste göreceksin. Bu filmlerden aradığın filmin altındaki çubuktan <span class="badge badge-secondary"><i class="fa fa-star-half-o" aria-hidden="true"></i> İzledim</span> tuşuna basıp "1 - Peş Peşe Oylama" dersinde öğrendiğin gibi oylayabilirsin.
            <div class="py-2"><span class="text-muted">Görev: </span><span ng-class="{'badge badge-danger':current_level < 203}">İzlediğin 1 filmi oyla.</span> <i class="fa fa-check" ng-show="current_level > 202"></i></div>
            <div class="mt-2"><small>Filmin posterine tıklayıp, filmin sayfasına gidebilirsin.</small></div>
            <div class="mt-2"><span class="h6 badge badge-secondary"><i class="fa fa-clock-o" aria-hidden="true"></i></span><small> tuşuna basıp, daha sonra izlemeye karar verdiğin filmleri "Sonra İzle" listene kaydedebilirsin.</small></div>
            <div class="mt-2"><span class="h6 badge badge-secondary"><i class="fa fa-ban" aria-hidden="true"></i></span><small> tuşuna basıp, tavsiye listende görmek istemediğin filmleri "Banlananlar" listene kaydedebilirsin.</small></div>
          </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button ng-click="level_up(1)">level atla</button>
        <button type="button" class="btn btn-secondary" ng-click="level_up(110)">Önceki Ders</button>
        <button type="button" class="btn btn-primary" ng-disabled="current_level < 203" ng-click="tutorial(300)">Sonraki Ders</button>
      </div>
    </div>
    <!--SEARCH-->




    <!--RECOMMENDATIONS-->
    <div class="modal-content" ng-if="current_level > 299 && current_level < 400">
      <div class="modal-header">
        <h5 class="modal-title">3 - Tavsiyeler</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group">
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 300}">
            <div class="h6 text-muted">Sayfaya Erişim</div>
            Tavsiyeler sayfasına ulaşmak için sayfanın en üstündeki gezinti çubuğundaki <span class="h6 badge badge-secondary"><i class="fa fa-th-list" aria-hidden="true"></i> Tavsiyeler</span> veya sayfanın en altında altbilgisindeki <span class="h6 badge badge-secondary">Film Tavsiyeleri</span> linklerinden birine tıklayabilirsin.
            <div class="py-2"><span class="text-muted">Görev: </span><span ng-class="{'badge badge-danger':current_level < 301}">Tavsiyeler sayfasına git.</span> <i class="fa fa-check" ng-show="current_level > 300"></i></div>
          </li>
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 301}" ng-if="current_level > 300">
            <div class="h6 text-muted">En Yüksek Oy Alan Filmler</div>
            <span class="h6 badge badge-secondary">En Yüksek Oy Alan</span> sekmesinde en yüksek oyu alan filmleri görebilirsin.
            <div class="h6 text-muted mt-4">En Popüler Filmler</div>
            <span class="h6 badge badge-secondary">En Popüler</span> sekmesinde en popüler filmleri görebilirsin.
            <div class="h6 text-muted mt-4">Benim Zevkime Göre <small>(Bu kısmı kullanmadan önce kursu tamamlamanızı öneriyoruz.)</small></div>
            Bu liste, Topcorn'u Topcorn yapan listedir. Yalnızca size özel film önerilerini burada bulabilirsiniz. Unutmayın, Topcorn'a ne kadar tutarlı ve çok bilgi verirseniz bu liste o ölçüde zengin ve size uygun olacaktır.
            Yalnızca senin zevkine göre seçilmiş filmleri görmek için <span class="h6 badge badge-secondary">Benim Zevkime Göre</span> sekmesine tıklayabilirsin.
            <div class="h6 text-muted mt-4">Tavsiyelerdeki Filmleri Oylama</div>
            Muhtemelen birçok filmin olduğu liste göreceksin. Bu filmlerden izlediğin filmlerin altındaki çubuktan <span class="badge badge-secondary"><i class="fa fa-star-half-o" aria-hidden="true"></i> İzledim</span> tuşuna basıp "1 - Peş Peşe Oylama" dersinde öğrendiğin gibi oylayabilirsin.
            <div class="py-2"><span class="text-muted">Görev: </span><span ng-class="{'badge badge-danger':current_level < 302}">İzlediğin 1 filmi oyla.</span> <i class="fa fa-check" ng-show="current_level > 301"></i></div>
            <div class="h6 text-muted mt-4">Filmfiltre</div>
            <span class="h6 badge badge-secondary"><i class="fa fa-filter" aria-hidden="true"></i> SÜZGEÇ</span> tuşuna basıp filtreyi ayarlayabilir; listedeki filmleri orijinal diline, türüne ve yılına göre daraltabilirsin.
          </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button ng-click="level_up(1)">level atla</button>
        <button type="button" class="btn btn-secondary" ng-click="level_up(210)">Önceki Ders</button>
        <button type="button" class="btn btn-primary" ng-disabled="current_level < 302" ng-click="tutorial(400)">Son Ders</button>
      </div>
    </div>
    <!--RECOMMENDATIONS-->




    <!--VOTE MOVIES-->
    <div class="modal-content" ng-if="current_level > 399 && current_level < 500">
      <div class="modal-header">
        <h5 class="modal-title">4 - Son Görev</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group">
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 400}">
            <div class="h6 text-muted">Profilini Güçlendir</div>
            Peş Peşe Oylama, arama yapma veya tavsiye alma; hangisi kolayına geliyorsa onu kullanarak profilini güçlendirebilirsin.
            <div class="py-2"><span class="text-muted">Görev: </span><span ng-class="{'badge badge-danger':current_level < 401}">50 film oyla.</span> <i class="fa fa-check" ng-show="current_level > 400"></i></div>
          </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button ng-click="level_up(1)">level atla</button>
        <button type="button" class="btn btn-secondary" ng-click="level_up(310)">Önceki Ders</button>
        <button type="button" class="btn btn-primary" ng-disabled="current_level < 401" ng-click="tutorial(500)">Mezuniyet</button>
      </div>
    </div>
    <!--VOTE MOVIES-->




    <!--GRADUATION-->
    <div class="modal-content" ng-if="current_level > 499 && current_level < 600">
      <div class="modal-header">
        <h5 class="modal-title">5 - Ayarlar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group">
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 500}">
            <div class="h6 text-muted">Sayfaya Erişim</div>
            Ayarlar sayfasına ulaşmak için sayfanın en üstündeki gezinti çubuğundaki <span class="h6 badge badge-secondary"><i class="fa fa fa-caret-down" aria-hidden="true"></i></span> > <span class="h6 badge badge-secondary">Ayarlar</span> veya sayfanın en altında altbilgisindeki <span class="h6 badge badge-secondary">Ayarlar</span> linklerinden birine tıklayabilirsin.
            <div class="py-2"><span class="text-muted">Görev: </span><span class="badge badge-danger">Ayarlar sayfasına git.</span></div>
          </li>
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 501}" ng-if="current_level > 500">
            <div class="h6 text-muted">Kapak Fotoğrafı Seçme</div>
            Kapak fotoğrafı açılır listesinden en çok beğendiğin filmlerden birinin kapak fotoğrafını kendi kapak fotoğrafın olarak belirleyebilirsin.
            <div class="py-2"><span class="text-muted">Görev: </span><span class="badge badge-danger">Bir kapak fotoğrafı seç.</span></div>
          </li>
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 502}" ng-if="current_level > 501">
            <div class="h6 text-muted">Profil Fotoğrafı Seçme</div>
            Kapak fotoğrafı seçtikten sonra, o filmde oynayan oyunculardan birinin profil fotoğrafını; ya da facebook ile giriş yaptıysan facebook profil fotoğrafını profil fotoğrafı açılır listesinden belirleyebilirsin.
            <div class="py-2"><span class="text-muted">Görev: </span><span class="badge badge-danger">Bir profil fotoğrafı seç.</span></div>
          </li>
          <li class="list-group-item" ng-class="{'list-group-item-success':current_level > 503}" ng-if="current_level > 502">
            <div class="h6 text-muted">Değişiklikleri Kaydetme</div>
            Profilini ayarladıktan sonra değişiklikleri kaydetmek için <span class="h6 badge badge-secondary">Değişiklikleri Kaydet</span> tuşuna basabilirsin.
            <div class="py-2"><span class="text-muted">Görev: </span><span class="badge badge-danger">Değişiklikleri kaydet.</span></div>
          </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button ng-click="level_up(1)">level atla</button>
        <button type="button" class="btn btn-secondary" ng-click="level_up(410)">Önceki Ders</button>
        <button type="button" class="btn btn-primary" ng-disabled="current_level < 504" ng-click="tutorial(600)">Diplomanı Al</button>
      </div>
    </div>
    <!--GRADUATION-->

  </div>
</div>