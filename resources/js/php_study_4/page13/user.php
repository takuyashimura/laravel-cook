<?php
class User {
  // $idというprivateなプロパティを定義してください
  private $id =0;
  private $name;
  private $gender;
  // $countというprivateなクラスプロパティを、初期値を数値の0として定義してください
  private static $count=0;
  
  public function __construct($name, $gender) {
    $this->name = $name;
    $this->gender = $gender;
    // クラスプロパティ$countの値に1を足してくださいßß
    self::$count ++;
    
    // idプロパティにクラスプロパティ$countの値を代入してください
    $this->id=self::$count;
    
  }
  
  // getIdメソッドを定義してください
  public function getId(){
    return $this->id;
  }
  
  public function getName() {
    return $this->name;
  }

  public function getGender() {
    return $this->gender;
  }
}

?>