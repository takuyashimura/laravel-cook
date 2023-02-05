<?php
require_once('drink.php');
require_once('food.php');
// review.phpを読み込んでください
require_once('review.php');


$juice = new Drink('JUICE', 600, 'https://s3-ap-northeast-1.amazonaws.com/progate/shared/images/lesson/php/juice.png', 'アイス');
$coffee = new Drink('COFFEE', 500, 'https://s3-ap-northeast-1.amazonaws.com/progate/shared/images/lesson/php/coffee.png', 'ホット');
$curry = new Food('CURRY', 900, 'https://s3-ap-northeast-1.amazonaws.com/progate/shared/images/lesson/php/curry.png', 3);
$pasta = new Food('PASTA', 1200, 'https://s3-ap-northeast-1.amazonaws.com/progate/shared/images/lesson/php/pasta.png', 1);

$menus = array($juice, $coffee, $curry, $pasta);

// 変数$review1にReviewクラスのインスタンスを代入してください
$review1 = new Review($juice -> getName(),"果肉たっぷりのオレンジジュースです！");

// 変数$review2にReviewクラスのインスタンスを代入してください
$review2 = new Review($curry -> getName(),"具がゴロゴロしていてとてもおいしいです");

// 変数$reviewsに$review1と$review2を要素とする配列を代入してください
$reviews = array($review1, $review2);

?>