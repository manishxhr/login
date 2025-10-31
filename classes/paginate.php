<?php
class Pagination{
    private $table;
    private $conn;
    private $limit;
    private $currentPage;

    public function __construct($table,$conn,$limit= 10)
    {
        $this->table= $table;
        $this->conn= $conn;
        $this->limit= $limit;
        $this->currentPage= $this->getCurrentPage();
    }

    public function getCurrentPage(){
        if(isset($_GET['page'])){
            $page=$_GET['page'];
        }
        return $page;
    }

    public function offset(){
        return ($this->currentPage -1)*$this->limit;
    }

    //fetch paginated data
    public function getData($columns="*", $condition="", $orderBy="", $params=[]){
        $sql="select $columns from $this->table";
        if($condition) $sql.= "where $condition";
        if($orderBy) $sql.= "ORDER BY $orderBy";
        $sql.= "LIMIT :limit OFFSET :offset";

        $stmt= $this->conn->prepare($sql);

        //bind user supplied parameters in $params
        foreach($params as $param =>$value){
            $stmt->bindValue($param, $value);
        }

        //bind limit and offset
        $stmt->bindValue(':limit',$this->limit,PDO::PARAM_INT);
        $stmt->bindValue(':offset',$this->offset(),PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


?>