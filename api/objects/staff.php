<?php
// 'user' object
class Staff{
 
    // database connection and table name
    private $conn;
    private $table_name = "login";
 
    // object properties
    public $id;
    public $fullname;
    public $usersname;
    public $password;
    public $email;
 
    // constructor
    public function __construct($db){
        $this->conn = $db;
    }
 
// create() method will be here
// create new user record
function create(){
 
    // insert query
    $query = "INSERT INTO " . $this->table_name . "
            SET
                fullname = :fullname,
                usersname = :usersname,
                email = :email,
                password = :password";
 



    
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->fullname=htmlspecialchars(strip_tags($this->fullname));
    $this->usersname=htmlspecialchars(strip_tags($this->usersname));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->password=htmlspecialchars(strip_tags($this->password));

    
    // check username exists
    $this->usernameExists();
 
    // bind the values
    $stmt->bindParam(':fullname', $this->fullname);
    $stmt->bindParam(':usersname', $this->usersname);
    $stmt->bindParam(':email', $this->email);
 
    // hash the password before saving to database
    $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
    $stmt->bindParam(':password', $password_hash);
 
    // execute the query, also check if query was successful
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

// usernameExists() method will check that the username exists and update
function usernameExists(){
    //check if username already exixts
    $con = mysqli_connect("localhost","root","Pa55w0rd@1","staffprofile");
    $username = $this->usersname;
    $query = mysqli_query($con, "SELECT id FROM login WHERE usersname='$username'");
   

    $i = 0;
    while(mysqli_num_rows($query) != 0) {
        $i++;
        $username = $username . "_" . $i;
        $query = mysqli_query($con, "SELECT id FROM login WHERE usersname='$username'");
    }
    $this->usersname = $username;
}
 
// emailExists() method will be here
// check if given email exist in the database
function emailExists(){
 
    // query to check if email exists
    $query = "SELECT id, fullname, usersname, password
            FROM " . $this->table_name . "
            WHERE email = ?
            LIMIT 0,1";
 
    // prepare the query
    $stmt = $this->conn->prepare( $query );
 
    // sanitize
    $this->email=htmlspecialchars(strip_tags($this->email));
 
    // bind given email value
    $stmt->bindParam(1, $this->email);
 
    // execute the query
    $stmt->execute();
 
    // get number of rows
    $num = $stmt->rowCount();
 
    // if email exists, assign values to object properties for easy access and use for php sessions
    if($num>0){
 
        // get record details / values
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
        // assign values to object properties
        $this->id = $row['id'];
        $this->fullname = $row['fullname'];
        $this->usersname = $row['usersname'];
        $this->password = $row['password'];
 
        // return true because email exists in the database
        return true;
    }
 
    // return false if email does not exist in the database
    return false;
}
 
// update() method will be here
// update a user record
public function update(){
 
    // if password needs to be updated
    $password_set=!empty($this->password) ? ", password = :password" : "";
 
    // if no posted password, do not update the password
    $query = "UPDATE " . $this->table_name . "
            SET
                fullname = :fullname,
                usersname = :usersname,
                email = :email
                {$password_set}
            WHERE id = :id";
 
    // prepare the query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->fullname=htmlspecialchars(strip_tags($this->fullname));
    $this->usersname=htmlspecialchars(strip_tags($this->usersname));
    $this->email=htmlspecialchars(strip_tags($this->email));
 
    // bind the values from the form
    $stmt->bindParam(':fullname', $this->fullname);
    $stmt->bindParam(':usersname', $this->usersname);
    $stmt->bindParam(':email', $this->email);
 
    // hash the password before saving to database
    if(!empty($this->password)){
        $this->password=htmlspecialchars(strip_tags($this->password));
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);
    }
 
    // unique ID of record to be edited
    $stmt->bindParam(':id', $this->id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
}

?>