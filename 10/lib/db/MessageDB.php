<?php

class MessageDB extends BaseDB {

  public function getAllMessages()
  {
    $query = "SELECT message.*, user.username FROM message"
            ." JOIN user ON user.id = message.user_id";
    $stmt = $this -> db -> prepare($query);
    $stmt -> execute();
    return $stmt -> fetchAll(PDO::FETCH_ASSOC);
  }

  public function sendMessage($__username, $__message, $__ip)
  {
    $query = "INSERT INTO message(message_text, user_id, ip) "
            ."VALUES(?, (SELECT id FROM user WHERE username = ?), ?)";
    $stmt = $this -> db -> prepare($query);
    $stmt -> execute(array($__message, $__username, $__ip));
  }
}
