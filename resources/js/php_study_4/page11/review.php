<?php
class Review {
  private $menuName;
  // $userNameというprivateなプロパティを定義してください
  private $userName;
  
  private $body;

  // 2つ目の引数として$userNameを追加してください
  public function __construct($menuName, $userName, $body) {
    $this->menuName = $menuName;
    // userNameプロパティに$userNameを代入してください
    $this->userName = $userName;
    
    $this->body = $body;
  }

  public function getMenuName() {
    return $this->menuName;
  }

  public function getBody() {
    return $this->body;
  }
  
  // getUserメソッドを定義してください
  public function getUser($users){
    foreach($users as $user){
      if ( $user->getName() == $this->userName){
        return $user;
      }
    }
  }
  
}

?>