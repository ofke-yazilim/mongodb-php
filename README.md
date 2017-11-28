# mongodb-php
Php 7.0.3 , mongodb 3.4.10 , windows wamp server 


Hazırlamış olduğum Mongo DB örneği PHP 7.0.23 programlama dili kullanılarak windows makina üzerine kurulmuş olan Wamp server üzerinde hazırlanmıştır. Aşağıda anlatacağım adımlar. Wamp server kurulumu yaptıktan sonra gerçekleşen aşamalardır.
1- Windows Üzerine Mongo DB Kurulumu ve Wamp Üzerinde Aktif Edilmesi
https://www.mongodb.com/download-center adresine gidilerek bize uygun versiyonu indirilir uygun versiyondan kastım işletim sistemine uygun olan yazılım. İndirme işlemi tamamlandıktan sonra sağ tıklanarak uygulamanın ismi kopyalanır örneğin benim indirdiğim sürümün adı "mongodb-win32-x86_64-2008plus-3.4.10-signed" kopyalanan isim wamp server'ın kurulduğu dosya yoluna gidilerek bin klasörünün içeriğine girilir ve mongodb adında bir klasör oluşturulur ardından oluşturulan mongodb klasörünün içerisine girilerek yukarıda ismini kopyaladığımız isimde bir klasör daha oluşturuyoruz. Yani artık C:\wamp64\bin\mongodb\mongodb-win32-x86_64-2008plus-3.4.10-signed şeklinde bir dosya yoluna sahibiz. Şimdi mongo db için kullanacağımız klasör ve dosyaları oluşturalım. Oluştururken yukarıda kopyaladığımız ismi kullanmaya devam edeceğiz. Command ekranını açarak aşağıda bulunan kodları çalıştıracağız.

mkdir c:\wamp64\bin\mongodb\mongodb-win32-x86_64-2008plus-3.4.10-signed\data
mkdir c:\wamp64\bin\mongodb\mongodb-win32-x86_64-2008plus-3.4.10-signed\data\db
mkdir c:\wamp64\bin\mongodb\mongodb-win32-x86_64-2008plus-3.4.10-signed\logs
mkdir c:\wamp64\bin\mongodb\mongodb-win32-x86_64-2008plus-3.4.10-signed\conf
mkdir c:\data
mkdir c:\data\db
Yukarıda mongo db için kullanacağımız klasörleri oluşturduk sıra c:\wamp64\bin\mongodb\mongodb-win32-x86_64-2008plus-3.4.10-signed\conf
dosya yoluna gidilerek içerisine mongodb.conf dosyası oluşturulur ve içerisine aşağıdaki şekilde doldurulur.

# data lives here
dbpath=C:\wamp64\bin\mongodb\mongodb-win32-x86_64-2008plus-3.4.10-signed\data\db
# where to log
logpath=C:\wamp64\bin\mongodb\mongodb-win32-x86_64-2008plus-3.4.10-signed\logs\mongodb.log
logappend=true
# only run on localhost for development
bind_ip = 127.0.0.1                                                             
port = 27017
rest = true
Şimdi https://www.mongodb.com/download-center adresinden indirdiğimiz .msi dosyasını çalıştırıyor custom sekmesini saçiyor ve C:\wamp64\bin\mongodb\mongodb-win32-x86_64-2008plus-3.4.10-signed dosya yolu üzerine kuruyoruz. Kurulumumuz tamamlandı . Ardından aşağıda bulunan kodları command ekranında çalıştrıyoruz. 

mongod.exe --install --config c:\wamp64\bin\mongodb\mongodb-win32-x86_64-2008plus-3.4.10-signed\conf\mongodb.conf --logpath c:\wamp64\bin\mongodb\mongodb-win32-x86_64-2008plus-3.4.10-signed\logs\mongodb.log
Eğer çalışmaz ve hata verirse Denetim masası üzerinden Sistem sekmesi tıklanır açılan ekranda Sol tarafta bulunan menülerden en altta bulunan Gelişmiş Sistem Ayarları sekmesi tıklanır. Açılan pencerenin en altında bulunan Ortam Değişkenleri tıklanır açılan pencerede Sistem değişkenleri kısmında bulunan Path kısmı aranır bulunur ve yeni tıklanarak mongod.exe dosya yolu yazılarak kayıt edilir. Örneğin benim kayıt ettiğim dosya yolu "C:\wamp64\bin\mongodb\mongodb-win32-x86_64-2008plus-3.4.10-signed\bin" şeklindedir. Şimdi yukarıda bulunan kodları command ekranına yazarak tekrar çalıştıralım.

Mongo db bilgisayarımıza kuruldu sıra mongo db'nin Wamp server üzerine tanıtılmasına geldi bunun için https://pecl.php.net/package/mongodb/1.3.3/windows (1.2.0 Mongo Db versiyonunu belirtir bilgisara kurduğun versiyon ile aynı olmalı) adresi üzerinden kullandığımmız PHP sürümüne , işletim sistemine ve güvenlik protokolümüze uygun dll dosyaları indirlir veindirlen dll dosyası C:\wamp64\bin\php\php7.0.23\ext içerisine kopyalanır ardından C:\wamp64\bin\apache\apache2.4.27\bin\php.ini dosyası açılarak uygun yere extension=php_mongo.dll yazılır ve wamp server servisleri y restart edilir artık wamp server üzerinde apache server üzerine mongo db tanımlanmış ve kurulum bitmiş oldu.
Kod yazmaya başlamak için mongo db php kütüphanelerini projemize dahil etmemiz gerekiyor. Wamp server üzerinde php projeleri www klasörü altında oluşturuluyor ben çalışcağım projenin yolunu şu şekilde oluşturdum : C:\wamp64\www\mongo işte tam bu projeye php mongo db kütüphanelerini dahil etmeliyim kütüphaneleri Composer kullanarak yükleyeceğim Öncelikle eğer window üzerinde Composer kurulu değil ise https://getcomposer.org/download/ adresinden indirilerek makina üzerine kurulur. Kurulum bittikten sonra command ekranında projemizin bulunduğu dizine(C:\wamp64\www\mongo) giderek "composer init" komutu çalıştırılır ve projemiz içerisine composer dahil edilir komutu yazdıktan sonra command ekranında bizden bir kaç bilgi isteyecek doğru formatta girerek enterı tuşlayalım. Composer kurulumu bitti şimdi https://packagist.org/ adresine gdilerek mongo db aranır ve nasıl yükleneceği öğrenilir. adresi mongo db'nin Composer kullanılarak projeye nasıl dahil edileceğini içerir. Command ekranında projemizin bulunduğu dizin açlır ve composer require mongodb/mongodb --ignore-platform-reqs kodu çalıştırılır. Php kütüphanelerimiz projeye eklenmiş olur. Projemiz içerisine index.php oluşturup içerisine aşağıdaki kodları yazarak mongo db uygulamasının çalışma durumunu kontrol edebiliriz.
//sınıfımız dahil ediliyor
require 'vendor/autoload.php'; // include Composer's autoloader
//<h4>Mongo db nesnesi oluşturuluyor 27017 portu üzerinde çalışır.</h4>
$this->_connect = new MongoDB\Client("mongodb://localhost:27017");
Önemli : Mongodb uygulamsı yazabimek için C:\wamp64\bin\mongodb\mongodb-win32-x86_64-2008plus-3.4.10-signed \mongod.exe sürekli çalışır vaziyette kalmalıdır.


