<?php

    class Profile{

        //database connection
        private $conn;
        private $table_name = "profile";


        //object properties
        public $id;
        public $firstname;
        public $lastname;
        public $email;
        public $gender;
        public $profile_pic;
        public $phone1;
        public $phone2;
        public $faculty;
        public $department;
        public $designation;
        public $office_address;
        public $biography;

        public function __construct($db){
            $this->conn = $db;
        }



        // read profile
        function read(){
        
            // select all query
            $query = "SELECT
                        p.id, p.firstname, p.lastname, p.email, p.gender, p.profile_pic, p.date
                    FROM
                        " . $this->table_name . " p
                    ORDER BY
                        p.lastname";
        
            // prepare query statement
            $stmt = $this->conn->prepare($query);
        
            // execute query
            $stmt->execute();
        
            return $stmt;
        }

        // create product
        function create(){
        
            // query to insert record
            $query = "INSERT INTO
                        " . $this->table_name . "
                    SET
                        firstname=:firstname, lastname=:lastname, email=:email, gender=:gender, profile_pic=:profile_pic, phone1=:phone1, phone2=:phone2,
                        faculty=:faculty, department=:department, designation=:designation, office_address=:office_address, biography=:biography";
        
            // prepare query
            $stmt = $this->conn->prepare($query);
        
            // sanitize
            $this->firstname=htmlspecialchars(strip_tags($this->firstname));
            $this->lastname=htmlspecialchars(strip_tags($this->lastname));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->gender=htmlspecialchars(strip_tags($this->gender));
            $this->profile_pic=htmlspecialchars(strip_tags($this->profile_pic));
            $this->phone1=htmlspecialchars(strip_tags($this->phone1));
            $this->phone2=htmlspecialchars(strip_tags($this->phone2));
            $this->faculty=htmlspecialchars(strip_tags($this->faculty));
            $this->department=htmlspecialchars(strip_tags($this->department));
            $this->designation=htmlspecialchars(strip_tags($this->designation));
            $this->office_address=htmlspecialchars(strip_tags($this->office_address));
            $this->biography=htmlspecialchars(strip_tags($this->biography));
        
            // bind values
            $stmt->bindParam(":firstname", $this->firstname);
            $stmt->bindParam(":lastname", $this->lastname);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":gender", $this->gender);
            $stmt->bindParam(":profile_pic", $this->profile_pic);
            $stmt->bindParam(":phone1", $this->phone1);
            $stmt->bindParam(":phone2", $this->phone2);
            $stmt->bindParam(":faculty", $this->faculty);
            $stmt->bindParam(":department", $this->department);
            $stmt->bindParam(":designation", $this->designation);
            $stmt->bindParam(":office_address", $this->office_address);
            $stmt->bindParam(":biography", $this->biography);
        
            // execute query
            if($stmt->execute()){
                return true;
            }
        
            return false;
            
        }

        // read products with pagination
        public function readPaging($from_record_num, $records_per_page){
  
        // select all query
        $query = "SELECT
            p.id, p.firstname, p.lastname, p.email, p.gender, p.profile_pic, p.date
            FROM
                " . $this->table_name . " p
            ORDER BY
                p.lastname
                LIMIT ?, ?";
  
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
  
        // bind variable values
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
  
        // execute query
        $stmt->execute();
  
        // return values from database
        return $stmt;
    }

    // used for paging products
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
  
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
        return $row['total_rows'];
        }


    }
    


?>