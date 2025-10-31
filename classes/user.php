<?php
class User{
    protected $table="users";
    protected $conn;

    public function __construct($db)
    {
        $this->conn=$db;
    }
    public function register($name,$email,$password,$role,$status){
        $sql="insert into $this->table (name, email, password, role, status) Values (:name, :email, :password, :role, :status)";
        $stmt= $this->conn->prepare($sql);
        
        $hashedpass=password_hash($password,PASSWORD_DEFAULT);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':password',$hashedpass);
        $stmt->bindParam(':role',$role);
        $stmt->bindParam(':status',$status);

        return $stmt->execute();
    }

    public function login($email,$password){
        $sql="select * from $this->table where email= :email";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user= $stmt->fetch(PDO::FETCH_ASSOC);
        if($user && password_verify($password,$user['password']))
        {
        return $user; //login success
        }
        else{
            return false; //login failed
        }
    }

    public function getById($id){
        $sql="select * from $this->table where id=:id";
        $stmt= $this->conn->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($id,$name,$email,$password,$role,$status){
        $sql="update $this->table SET name=:name, email=:email, password=:password, role=:role, status=:status where id=:id";
        $stmt=$this->conn->prepare($sql);
        $currentuser= $this->getById($id);

        if($currentuser['password']==$password){
            $storepass=$password;
        }
        else{
            $storepass=password_hash($password,PASSWORD_DEFAULT);
        }

        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':password',$storepass);
        $stmt->bindParam(':role',$role);
        $stmt->bindParam(':status',$status);

        return $stmt->execute();
    }


    public function changePassword($id,$password){
        $sql="update $this->table set password=:password where id=:id";
        $stmt= $this->conn->prepare($sql);
        $hashedpass=password_hash($password,PASSWORD_DEFAULT);
        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':password',$hashedpass);
        return $stmt->execute();
    }
}


?>