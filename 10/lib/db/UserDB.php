<?php

class UserDB extends BaseDB
{

    public function hasUser($__username)
    {
        $query = "SELECT username FROM user WHERE username = $__username";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
