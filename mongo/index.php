<?php

/*
 * Aşağıda mongo db üzerinde kullanılan tanımların sql karşılıkları bulunur
SQL	         MongoDB
---------    ---------
Databas      Db
Table	     Collection
Row	     Document
Column       Field
*/

require_once 'mongo.php';
$mongo = new mongo();

//<h4>Sql deyimi ile database mongo db deyimi ile Db oluşturuluyor Deneme adında.<h4>
$database =  $mongo->createDatabase("deneme");//Mutlaka belirtilmeli

//<h4>Sql deyimi ile table mongo db deyimi ile colaction oluşturuluyor table adında.<h4>
$table    =  $mongo->createTable("table2");//Mutlaka belirtilmeli

//<h4>Sadece bilgileri verilen tek insert yapılıyor</h4>
echo $mongo->insertOne(array("id"=>8,"name"=>"omer","surname"=>"faruk"));

//<h4>Toplu insert işlemi gerçekleştiriyoruz</h4>
echo $mongo->insertVery(array(array("id"=>6,"name"=>"Önder","surname"=>"Bayram"),array("id"=>7,"name"=>"Halil","surname"=>"Yunus")));

//<h2>Aşağıda Select İşlemlerini Yapan Bir Kaç Örnek Mevcuttur</h2>
//<br>

//<h4>Getirilecek eleaman sayısını belirtir</h4>
$limit = 100;
//<h4>id değerine göre ascc olarak getir "order by id asc"</h4>
$sort  = array("id"=>1);
//<h4>id değerine göre desc olarak getir "order by id desc"</h4>
$sort  = array("id"=>-1);

//<h4>id 3 değerinden büyük ise</h4>
$where = array("id"=>array('$lt'=>3));
$data  = $mongo->getListele($sort,$where,$limit);
print_r($data);

//<h4>id 1 ve 5 içeriyor ve 1 değerinden büyük ise</h4>
$where = array("id" => array('$in' => array(1,5),'$gt'=>1));
$data  = $mongo->getListele($sort,$where,$limit);
//print_r($data);

//<h4>id 1 ya da 2 olab kayıtlar</h4>
$where = array('$or' => array(array("id"=>1),array("id"=>2)));
$data  = $mongo->getListele($sort,$where,$limit);
//print_r($data);

//<h4>id 4 ya da 5 içeriyor ya da name omer ise getir.</h4>
$where = array('$or' => array(array('id' => array('$in' => array(4,5))), array('name' =>"omer")));
$data  = $mongo->getListele($sort,$where,$limit);
//print_r($data);

//<h4>id 5 ya da 6 içeriyor ve 2 den büyük ise ya da name omer ise getir.</h4>
$where = array('$or' => array(array('id'=>array('$gt'=>2,'$in'=>array(5,6))),array("name"=>"omer")));
$data  = $mongo->getListele($sort,$where,$limit);
//print_r($data);

//<h4>Aşağıda güncelleme işlemi yapılıyor</h4>
$set = array(
    '$set' => array('name' => 'Yeni','surname'=> 'Yeni')
);
$where = array(
    '_id' => new \MongoDB\BSON\ObjectID('5a1d76f8ddf925225c0065b6')
);
$mongo->update($where, $set);

//<h4>Silme işlemleri</h4>
$where = array('name'=>'Yeni');
$mongo->delete($where);