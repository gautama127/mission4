<?php
 //接続
 $dsn = 'データベース名';
 $user ='ユーザー名';
 $password = 'パスワード';
 $pdo = new PDO($dsn, $user, $password);

 //テーブル作成
 $sql="CREATE TABLE mission_4_2"
 ."("
 ."id INT,"
 ."name char(32),"
 ."comment TEXT,"
 ."time TEXT,"
 ."password char(32)"
 .");";
 $stmt=$pdo->query($sql);
 
 //テーブル表示
 $sql = 'SHOW TABLES';
 $result = $pdo->query($sql);
 foreach($result as $row){
  echo $row[0];
  echo '<br>';
 }

 echo "<hr>";


 $sql ='SHOW CREATE TABLE mission_4_2';
 $result = $pdo->query($sql);
 foreach($result as $row){
  print_r($row);
 }
 
 echo"<hr>";


 //編集番号取得,対象の表示 
 if(!empty($_POST["edit"]) && !empty($_POST["password3"])){
  $id = htmlspecialchars($_POST['edit']);
  $pass = htmlspecialchars($_POST['password3']);
  $judge=0;
  $sql = 'SELECT * FROM mission_4_2 ORDER BY id;';
  $results = $pdo->query($sql);
  foreach($results as $row){
   if($id == $row['id'] && $pass == $row['password']){
    $a = $row['name'];
    $b = $row['comment'];
    $c   = $_POST["edit"];
    $judge=1;
   }
 }
 if($judge==0){ //パスワードが違う場合
   $no = "<br />違います";
  }
} 

?>


<form action="mission_4_2.php" method="post">
   
   <input type="text" name="name" placeholder="名前" value="<?= $a?>"> <br>
   
   <input type="text" name="message"  placeholder="コメント" value="<?= $b?>"> <br>
   <input type="hidden" name="edit2" value="<?= $c?>"> 

   
   <input type="text" name="password"  placeholder="パスワード" value=>
   <input type="submit"value="送信" /><br> <br>
   
   <input type="text" name="derete"  placeholder="削除対象番号" value=> <br>
   <input type="text" name="password2"  placeholder="パスワード" value=>
   <input type="submit"value="送信" /><br> <br>
   
   <input type="text" name="edit"  placeholder="編集" value=><br>
   <input type="text" name="password3"  placeholder="パスワード"value=>
   <input type="submit"value="送信" /> <br>
   <?= $no?>
</form>

<?php

 //編集
 if(!empty($_POST["edit2"])){
   $id = htmlspecialchars($_POST['edit2']);
   
   if(!empty($_POST["name"]) && !empty($_POST["message"])){
    $nm =  htmlspecialchars($_POST['name']);
    $kome = htmlspecialchars($_POST['message']);
    $time = date("Y/m/d/H:i:s");

    $sql = "update mission_4_2 set name='$nm', comment='$kome', time='$time'where id=$id";
    $result = $pdo->query($sql);

    $sql = 'SELECT * FROM mission_4_2 ORDER BY id;';
    $results = $pdo->query($sql);
    foreach($results as $row){
     echo $row['id']. ',';
     echo $row['name']. ',';
     echo $row['comment']. ',';
     echo $row['time']. '<br>';
   }
 }
}

 //名前、コメント取得
 else if(!empty($_POST["name"]) && !empty($_POST["message"])){ 
  $sql = $pdo->prepare("INSERT INTO mission_4_2(id, name, comment, time, password)VALUES(:id, :name, :comment, :time, :password)");

  $results=$pdo->query('SELECT * FROM mission_4_2 ORDER BY id;'); //投稿番号ソート
  foreach($results as $row){
   $id = $row['id'];
 }

  $sql->bindParam(':id', $id, PDO::PARAM_STR);
  $sql->bindParam(':name', $name, PDO::PARAM_STR);
  $sql->bindParam(':comment', $comment, PDO::PARAM_STR);
  $sql->bindParam(':time', $time, PDO::PARAM_STR);
  $sql->bindParam(':password', $pass, PDO::PARAM_STR);

  $id=$id+1;
  $name = htmlspecialchars($_POST['name']);
  $comment = htmlspecialchars($_POST['message']);
  $pass = htmlspecialchars($_POST['password']);
  $time = date("Y/m/d/H:i:s");
  $sql->execute();

 //表示
 $sql = 'SELECT * FROM mission_4_2 ORDER BY id;';
 $results = $pdo->query($sql);
 foreach($results as $row){
  echo $row['id']. ',';
  echo $row['name']. ',';
  echo $row['comment']. ',';
  echo $row['password']. ',';
  echo $row['time'].  '<br>';
 }
}


 //削除
 if(!empty($_POST["derete"]) && !empty($_POST["password2"])){

  $id = htmlspecialchars($_POST['derete']);
  $pass = htmlspecialchars($_POST['password2']);

 // $sql = "delete from mission_4_2 where id=$id and password=$pass";
 // $result = $pdo->query($sql);
 $sql = 'SELECT * FROM mission_4_2 ORDER BY id;';
 $results = $pdo->query($sql);
 $judge=0;
 foreach($results as $row){
   if($id == $row['id'] && $pass == $row['password']){
    $sql = "delete from mission_4_2 where id=$id ";
    $result = $pdo->query($sql);
    $judge=1;
 }
}
 //表示
 if($judge==0){
    echo "違います";
 }else{
 $sql = 'SELECT * FROM mission_4_2 ORDER BY id;';
 $results = $pdo->query($sql);
 foreach($results as $row){
  echo $row['id']. ',';
  echo $row['name']. ',';
  echo $row['comment']. ',';
  echo $row['time']. '<br>';
  }
 }
}


?> 
 

 