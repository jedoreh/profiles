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
        public $username;

        public function __construct($db){
            $this->conn = $db;
        }



        // read profile
        function read(){
        
            // select all query
            $query = "SELECT
                        p.id, p.firstname, p.lastname, p.email, p.designation, p.department, p.gender, p.profile_pic, p.date
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

                
        // used when filling up the update product form
        function readOne(){
        
            // query to read single record
            $query = "SELECT 
                        id, firstname, lastname, email, gender, profile_pic, phone1, phone2, faculty, department, designation, office_address, biography, profile_show, username
                    FROM
                        " . $this->table_name . "
                    WHERE
                        username = ?
                    LIMIT
                        0,1";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // bind id of product to be updated
            $stmt->bindParam(1, $this->username);
        
            // execute query
            $stmt->execute();
        
            // get retrieved row
             $row = $stmt->fetch(PDO::FETCH_ASSOC);
            //return $stmt;
            // set values to object properties
          
            $this->id = $row['id'];
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];
            $this->email = $row['email'];
            $this->gender = $row['gender'];
            $this->profile_pic = $row['profile_pic'];
            $this->phone1 = $row['phone1'];
            $this->phone2 = $row['phone2'];
            $this->faculty = $row['faculty'];
            $this->department = $row['department'];
            $this->designation = $row['designation'];
            $this->office_address = $row['office_address'];
            $this->biography = $row['biography'];
            $this->profile_show = $row['profile_show'];
            $this->username = $row['username'];
        }

        // create product
        function create(){
        
            // query to insert record
            $query = "INSERT INTO
                        " . $this->table_name . "
                    SET
                        firstname=:firstname, lastname=:lastname, email=:email, gender=:gender, profile_pic=:profile_pic, phone1=:phone1, phone2=:phone2,
                        faculty=:faculty, department=:department, designation=:designation, office_address=:office_address, biography=:biography, profile_show=:profile_show, username=:username";
        


            
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
            $this->profile_show=htmlspecialchars(strip_tags($this->profile_show));
            $this->username=htmlspecialchars(strip_tags($this->username));

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
            $stmt->bindParam(":profile_show", $this->profile_show);
            $stmt->bindParam(":username", $this->username);
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
            p.id, p.firstname, p.lastname, p.email, p.designation, p.department, p.gender, p.profile_pic, p.date
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

        // update the profile
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    firstname = :firstname,
                    lastname = :lastname,
                    email = :email,
                    gender = :gender,
                    profile_pic = :profile_pic,
                    phone1 = :phone1,
                    phone2 = :phone2,
                    faculty = :faculty,
                    department = :department,
                    designation = :designation,
                    office_address = :office_address,
                    biography = :biography,
                    profile_show = :profile_show,
                    username = :username
                WHERE
                    id = :id";
    
        // prepare query statement
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
        $this->profile_show=htmlspecialchars(strip_tags($this->profile_show));
        $this->username=htmlspecialchars(strip_tags($this->username));
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        // bind new values
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':gender', $this->gender);
        $stmt->bindParam(':profile_pic', $this->profile_pic);
        $stmt->bindParam(':phone1', $this->phone1);
        $stmt->bindParam(':phone2', $this->phone2);
        $stmt->bindParam(':faculty', $this->faculty);
        $stmt->bindParam(':department', $this->department);
        $stmt->bindParam(':designation', $this->designation);
        $stmt->bindParam(':office_address', $this->office_address);
        $stmt->bindParam(':biography', $this->biography);
        $stmt->bindParam(':profile_show', $this->profile_show);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':id', $this->id);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }


    }
    


?>