<?php

class Companies
{
    //DB Stuff
    private $conn;
    private $table = 'companies';

    //Applicants props
    public $company_id;
    public $name;
    public $email;
    public $account_status;
    public $passwod;

    //Connect to DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //---> Logout function
    public function logout()
    {
        session_start();

        //Unset all the session variables
        unset($_SESSION["loggedin"]);

        //Destry the session;
        session_destroy();

        return true;
    }

    //---> Login function
    public function login()
    {
        $query = 'SELECT company_id, email, password FROM ' . $this->table . ' WHERE email = :email';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean the data
        $this->email = htmlspecialchars(strip_tags($this->email));

        //bind the data
        $stmt->BindParam(':email', $this->email);

        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //Set properties
            $this->company_id    = $row['company_id'];
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

    //---> SignUp function
    public function signup()
    {
        //-----> EMAIL verfiry <--------
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

        //----> Insert data into database <--------
        $query = 'INSERT INTO ' . $this->table . ' 
            SET 
                email = :email, 
                password = :password, 
                name = :name';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean the userinputs
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->name = htmlspecialchars(strip_tags($this->name));

        //Bind data
        $stmt->BindParam(':email', $this->email);
        $stmt->BindParam(':password', $this->password);
        $stmt->BindParam(':name', $this->name);

        //Hash password
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        //Execute the query
        if($stmt->execute()) {
            return true;
        }

    }
}
