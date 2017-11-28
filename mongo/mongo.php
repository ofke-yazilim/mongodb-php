<?php

/**
 * Description of mongo
 *
 * @author o.kesmez
 */
class mongo {
    private $_connect      = null;
    private $_db           = null;
    private $_collection   = null;
    private $_table        = null;
    
    //Yapıcı sınıfınız ile mongo db servisine bağlanıyoruz.
    public function __construct() {
        //sınıfımız dahil ediliyor
        require 'vendor/autoload.php'; // include Composer's autoloader
        //<h4>Mongo db nesnesi oluşturuluyor 27017 portu üzerinde çalışır.</h4>
        $this->_connect = new MongoDB\Client("mongodb://localhost:27017");
    }   
    
    //Mongo db ile database oluşturulmasını sağlar
    /*
     * Tek bir giriş değeri alır ve tek bir değer döner
     * $databaseName => Oluşturulacak database adıdır.
    */
    public function createDatabase($databaseName) {
        $this->_db = $this->_connect->$databaseName;
        return $this->_db;
    }
    
    //Mongo db ile tablo yani Collection oluşturulmasını sağlar
    /*
     * Tek bir giriş değeri alır ve tek bir değer döner
     * $tableName => Oluşturulacak tablo yani collaction adıdır.
    */
    public function createTable($tableName) {
        $this->_collection = $this->_db->$tableName;
        $this->_table      = $tableName;
        return $this->_collection;
    }
    
    //Array olarak bulk insert yapar yani array olarak gönderilen verileri veri tabanına ekler.
    //Array veri alır tek bir değer döner
    /*
     * $data = array(array("name"=>"Ömer","surname"=>"KESMEZ"),array("name"=>"HAlil","surname"=>"KESMEZ"));
     */
    public function insertVery($data=array()){
        $insert = new MongoDB\Driver\Manager();
        $bulk = new MongoDB\Driver\BulkWrite;
        for($i=0;$i<count($data);$i++){
            $bulk->insert($data[$i]);
        }
        $insert->executeBulkWrite("$this->_db.$this->_table", $bulk);
    
    }
    
    //Sadece 1 adet veri eklenmesini sağlar
    //Array veri alır tek bir değer döner
    /*
     * $data = array("name"=>"Ömer","surname"=>"KESMEZ");
     */
    public function insertOne($data=array()){
        $result = $this->_collection->insertOne($data);
        return $result->getInsertedId();//Eklenen veriye ait id değeri dönülüyor.
    }
    
    
    //Gönderilen değerleri uygun verileri listeler
    /*
     * $sort  => desc : array("id" => -1) asc : array("id" => 1) order by desc,asc
     * $limit => kaç adet veri geleceğini belirtir
     * $where => Where içerisindeki sorguları içerir.
     * ################### Where Örnek Kullanımlar ###################
     *   "id"=>array('$lt'=>3) //id 3 değerinden büyük ise
     *   "id" => array('$in' => array(1,5),'$gt'=>1),//id 1 ve 5 içeriiyr ve 1 değerinden büyük ise
     *   '$or' => array(array("id"=>1),array("id"=>2))//id 1 ya da 2 olab kayıtlar
     *   '$or' => array(array('id' => array('$in' => array(4,5))), array('name' =>"omer"))//id 4 ya da 5 içeriyor ya da name omer ise getir.
     *   '$or' => array(array('id'=>array('$gt'=>2,'$in'=>array(5,6))),array("name"=>"omer"))
     */
    public function getLists($sort=array(),$where=array(),$limit){
        $filter = $where;
        $options = array(
            "sort" => $sort,//-1 desc demektir 1 asc demektir
            "limit"=> $limit //Elemen sayısı
        );
        $cursor  = $this->_collection->find($filter,$options);
        
        foreach($cursor as $obj){
            $data[] = $obj;
        }  
        
        return $data;
    }
    
    //Güncelleme yapmamızı sağlar 
    /*
     * $where => Güncelleme yapacağımız satırların koşul bilgisi örneğin : where id=12 and name="omer"
     * $set   => Güncelleme değerlerini tutar yani yeni değerler.
     * $where ve $set array türünde değerleridir.
     * $set = array(
           '$set' => array('id' => 12)
       );
     */
    public function update($where,$set) {

        $this->_collection->updateOne($where,$set);
    }
    
    
    //mongodb üzerinde belirtilen id değerli veriyi siler
    /*
     * $content => Silinecek veriye ait şartları yani where sorgusunu içeririr.
     */
    public function delete($where) {
        /*$where = array(
            'name' => 'Yeni'
        );*/
//        echo str_replace(array("{","}",":"),array("[","]","=>"), json_encode($where));exit;
        $this->_collection->deleteOne($where);
    }
    
}
