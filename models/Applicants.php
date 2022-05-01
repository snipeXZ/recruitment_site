<?php

class Applicant
{
    //DB Stuff
    private $conn;
    private $table = 'applicants';

    //Applicants props
    public $id;
    public $status;
    public $email;
    public $password;
    public $account_status;
    public $resume;
    public $first_name;
    public $last_name;

    //Connect to DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //----------> Logout function <-------------
    public function logout()
    {
        session_start();

        //Unset all the session variables
        unset($_SESSION["loggedin"]);

        //Destry the session;
        session_destroy();

        return true;
    }
    //----------------> End <------------------

    //------------->Disable account <----------------------
    public function disable()
    {
        $query = 'SELECT status FROM '. $this->table . ' WHERE id = :id';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //bind the data
        $stmt->BindParam(':id', $this->id);

        if($stmt->execute())  {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //Set properties
            $this->status = $row['status'];

            //Check if account already disabled
            if($this->status === "disabled"){
                return false;
            }
        }//----------> END <------------------------

        //Update field if enabled
        $query = 'UPDATE '. $this->table. '
            SET status = :status
            WHERE id = :id';
        
        //prepare statement
        $stmt = $this->conn->prepare($query);

        //bind the data
        $stmt->BindParam(':id', $this->id);
        $stmt->BindParam(':status', $this->status);

        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    //------------------> END <-------------------

    //-----------------> ENABLE ACCOUNT <-------------------
    public function enable()
    {
        $query = 'SELECT status FROM '. $this->table . ' WHERE id = :id';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //bind the data
        $stmt->BindParam(':id', $this->id);

        if($stmt->execute())  {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //Set properties
            $this->status = $row['status'];

            //Check if account already disabled
            if($this->status === "enabled"){
                return false;
            }
        }

        //Update field if disabled
        $query = 'UPDATE '. $this->table. '
            SET status = :status
            WHERE id = :id';
        
        //prepare statement
        $stmt = $this->conn->prepare($query);

        //bind the data
        $stmt->BindParam(':id', $this->id);
        $stmt->BindParam(':status', $this->status);

        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    //-------------------> END <------------------------

    //----------------> Login function <-----------------------
    public function login()
    {
        $query = 'SELECT id, email, password FROM ' . $this->table . ' WHERE email = :email';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean the data
        $this->email = htmlspecialchars(strip_tags($this->email));

        //bind the data
        $stmt->BindParam(':email', $this->email);

        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //Set properties
            $this->id    = $row['id'];
            $this->email       = $row['email'];
            $this->hashed_password = $row['password'];

            //validate password
            if (password_verify($this->password, $this->hashed_password)) {
                return true;
            } else {
                return false;
            }
        } else {
            //email is incorrect
            return false;
        }
    }
    //--------------------> END <--------------------------------

    //-------------------> SignUp function <--------------------------
    public function signup()
    {
        //-----> EMAIL verify <--------
        //create query
        $query = 'SELECT email FROM ' . $this->table . ' WHERE email = :email';

        //preapre statement
        $stmt = $this->conn->prepare($query);

        //clean the email
        $this->email = htmlspecialchars(strip_tags($this->email));

        //Bind the email param
        $stmt->bindParam(':email', $this->email);

        //Execute query
        if ($stmt->execute()) {
            //result
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row == 1) {
                $this->email_err = "This email already exist";
            }
        } else {
            //If execution fails
            echo "Something went wrong";
        }
        //----> END OF VERIFY <-----

        //----> Insert data into database <--------
        $query = 'INSERT INTO ' . $this->table . ' 
            SET 
                email = :email, 
                password = :password, 
                resume = :resume, 
                first_name = :firstname, 
                last_name = :last_name';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean the userinputs
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->resume = htmlspecialchars(strip_tags($this->resume));
        $this->first_name = htmlspecialchars(strip_tags($this->first_name));
        $this->last_name = htmlspecialchars(strip_tags($this->last_name));

        //Bind data
        $stmt->BindParam(':email', $this->email);
        $stmt->BindParam(':password', $this->password);
        $stmt->BindParam(':resume', $this->resume);
        $stmt->BindParam(':first_name', $this->first_name);
        $stmt->BindParam(':last_name', $this->last_name);

        //Hash password
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        //Execute the query
        if($stmt->execute()) {
            return true;
        }

    }
}
