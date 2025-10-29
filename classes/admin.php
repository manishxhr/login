<?php
require "user.php";
class Admin extends User{

    public function getAllUsers(){
        $sql="select * from $this->table ";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUser($id){
        $sql="delete from $this->table where id=:id";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(':id',$id);
        return $stmt->execute();
    }

    public function updatestatus($id,$status){
        $sql="update $this->table set status=:status where id=:id";
        $stmt= $this->conn->prepare($sql);
          if($status==="active"){
            $status="inactive";
        }
        else{
            $status="active";
        }
        // or $status=($status==="active") ? "inactive" : "active";
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':status',$status);
        return $stmt->execute();
    }

    public function searchUser($keyword){
        $sql="select * from $this->table where name LIKE :keyword OR email Like :keyword";
        $stmt=$this->conn->prepare($sql);
        $likekeyword="%$keyword%";
        $stmt->bindParam(':keyword',$likekeyword);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } 

    public function resetUserPassword($id,$password){
        $sql="update $this->table SET password=:password where id=:id";
        $stmt=$this->conn->prepare($sql);
        $hashedpass=password_hash($password,PASSWORD_DEFAULT);
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':password',$hashedpass);
        return $stmt->execute();

    }

    public function countUser(){
        $sql="select count (*) as total_users from $this->table";
        $stmt= $this->conn->prepare($sql);
        $stmt->execute();
        $total= $stmt->fetch(PDO::FETCH_ASSOC);
        return $total['total_users'];
    }


}


?>