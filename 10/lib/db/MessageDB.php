<?php

class MessageDB extends BaseDB {
  
  public function getById($id) {
    $query = "SELECT message.*, user.name FROM message"
            ." JOIN user ON user.id = message.owner_id"
            ." WHERE message.id = ?";
    $stmt = $this->db->prepare($query);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getAll() {
    $query = "SELECT message.*, user.name FROM message"
            ." JOIN user ON user.id = message.owner_id";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
