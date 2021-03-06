<?php

return [
    'donation' => 'topcorn.xyz, tamamen sinemaseverlerin destekleriyle ayakta kalan bir projedir. Size daha iyi sonuçlar sunabilmek, daha kullanışlı bir deneyim sağlayabilmek için bize destek olun.',
    'hint_secondary_language' => 'Ana Dil\'de bulunamayan bilgiler varsa, bunlar İkinci Dil ile doldurulur. İkinci Dil ile yazılmış eleştiri yazılarını ve İkinci Dil\'deki fragmanları da görürsünüz.',
    'hint_hover_title' => 'Film linklerinin üzerine fare imlecini götürdüğünüzde filmin orijinal ya da İkinci Dil\'inizdeki adını görebilirsiniz. Bu ayar arama sayfasını etkilemez.',
    'hint_image_quality' => 'İnternet bağlantınıza uygun olarak görsel kalitesini seçebilirsiniz. Bu ayar, fragmanları etkilemez.',
    'hint_full_screen' => 'Sağdan ve soldan bırakılan boşlukları azaltır.',
    'hint_open_new_tab' => 'Film, kişi ve kullanıcıları yeni sekmede açar.',
    'hint_open_new_tab' => 'Film, kişi ve kullanıcıları yeni sekmede açar.',
    'hint_theme' => 'Tercihinize göre sitenin arka planının rengini değiştirebilirsiniz.',
    'hint_pagination' => 'Tavsiyeler sayfasında bir sayfada gösterilen film sayısıdır.',
    'hint_show_crew' => 'Film detay sayfasında oyunculara ilave olarak film ekibini de gösterir.',
    'hint_advanced_filter' => 'Tavsiyelerde daha fazla seçenek ve bilgi yükler.',
    'hint_cover_photo' => 'Efsanevi filmlerinden birisini seç.',                            
    'hint_profile_pic' => 'Facebook profil resmini veya bir oyuncunun fotoğrafını profil fotoğrafın olarak seç.',
    'hint_when_user_interaction' => 'Başka bir kullanıcı senin listeni, eleştirini beğenirse; seni takibe başlarsa vb.',
    'hint_when_automatic_notification' => 'Sonra izle\'ndeki dizinin yeni sezon veya bölüm tarihi belli olduğunda vb. otomatik oluşturulan hatırlatmalar.',
    'hint_when_system_change' => 'Yeni bir özellik geldiğinde veya sistemde bir değişiklik olduğunda.',
    'home' => array(
      'h1' => 'Film çok, zaman yok!',
      't11' => 'topcorn.xyz senin film zevkini anlar, senin seveceğini anladığı filmleri sana sıralar. Hazırsan başlayalım!',
      't12' => 'topcorn.xyz ile her türden, her dilden filmler arasından EN doğru seçimi yapmak artık çok kolay.',

      'h2' => 'Tanışalım!',
      't21' => 'Ne kadar film oylarsan, seni o kadar iyi tanırız. Ve tabii sana hazırlayacağımız filmlistesi de o kadar isabetli olur.',
      't22' => 'Peş peşe oylama bu süreci hızlandırabilir, hemen filmlere gömülebilirsin.',

      'h3' => 'Sana özel filmler, seni bekler!',
      't31' => 'topcorn.xyz ne istediğini ve ne izlediğini bilen filmseverler için özel olarak geliştirilmiştir.',
      't32' => 'Sizi daha yakından tanımamız için filmleri oylayın, gerisini topcorn.xyz\'ya bırakın.',

      'h4' => 'Tamamen ücretsiz!',
      't41' => 'Daha ne duruyorsun?',

      'description' => 'Eşsiz zevkine göre film ve dizi önerileri burada. Tamamen ücretsiz.',
    ),
    'notifications' => array(
      'air_date' => "<a ng-href=\"series/{{notification.data[0].movie_id}}\" class=\"text-dark\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"{{notification.data[0].original_title}} {{notification.data[0].release_date.length>0?'('+notification.data[0].release_date.substring(0, 4)+')':''}}\">{{notification.data[0].title}}</a> yeni bölüm tarihi belirlendi. Tarih: {{notification.data[0].next_episode_air_date.substring(0, 10)}} ({{notification.data[0].day_difference_next}} gün sonra)",
      'airing_today' => "<a ng-href=\"series/{{notification.data[0].movie_id}}\" class=\"text-dark\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"{{notification.data[0].original_title}} {{notification.data[0].release_date.length>0?'('+notification.data[0].release_date.substring(0, 4)+')':''}}\">{{notification.data[0].title}}</a> yeni bölümü bugün yayınlanıyor. <small class=\"text-muted scrollmenu\">Bildirim oluşturulma zamanı: {{notification.data[0].created_at}}</small>",
      'like' => "{{notification.total}} kullanıcı senin <a ng-href=\"{{notification.data[0].review_mode==1?'movie':'series'}}/{{notification.data[0].movie_id}}\" class=\"text-dark\" ng-if=\"notification.data[0].notification_mode==0\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"{{notification.data[0].original_title}} {{notification.data[0].release_date.length>0?'('+notification.data[0].release_date.substring(0, 4)+')':''}}\">{{notification.data[0].title}} eleştirini</a><a ng-href=\"list/{{notification.data[0].list_id}}\" class=\"text-dark\" ng-if=\"notification.data[0].notification_mode==1\">{{notification.data[0].title}} listeni</a> beğendi. {{notification.total>1?'Kullanıcılar':'Kullanıcı'}}: <span ng-repeat=\"item in notification.data\"><span ng-hide=\"&dollar;index==0\">, </span><a ng-href=\"profile/{{item.user_id}}\" class=\"text-dark\">{{item.user_name}}</a></span>",
      'sent_movie' => "<a ng-href=\"{{notification.data[0].notification_mode==4?'movie':'series'}}/{{notification.data[0].movie_id}}\" class=\"text-dark\" data-toggle=\"tooltip\" data-placement=\"top\" data-original-title=\"{{notification.data[0].original_title}} {{notification.data[0].release_date.length>0?'('+notification.data[0].release_date.substring(0, 4)+')':''}}\">{{notification.data[0].title}}</a>, {{notification.total}} kullanıcı tarafından sana tavsiye edildi. {{notification.total>1?'Kullanıcılar':'Kullanıcı'}}: <span ng-repeat=\"item in notification.data\"><span ng-hide=\"&dollar;index==0\">, </span>{{item.user_name}}</span>",
      'watch_together' => "<a ng-href=\"profile/{{notification.data[0].user_id}}\" class=\"text-dark\">{{notification.data[0].user_name}}</a> seninle beraber izledi. Paylaş tuşunu kullanarak bu kullanıcıya film ve dizi önerebilirsin.",
      'started_following' => "<a ng-href=\"profile/{{notification.data[0].user_id}}\" class=\"text-dark\">{{notification.data[0].user_name}}</a> seni takibe başladı.",
    ),
    'person' => array(
      'description' => 'Filmler, tv dizileri, görseller ve daha fazlası...',
    ),
    'profile' => array(
      'description' => 'Beğendiği filmler, izlediği diziler, yazdığı yorumlar, oluşturduğu listeler ve daha fazlası...',
    )
];