<?php

class Job_post
{
    //DB Stuff
    private $conn;
    private $table = 'jobs';

    //Props
    public $post_id;
    public $company_id;
    public $job_name;
    public $discription;
    public $requirements;
    public $status;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;   
    }

    //post a job
    public function post_job()
    {
        $query = 'INSERT INTO ' . $this->table . '
            SET
                company_id = :company_id,
                job_name = :job_name,
                discription = :discription,
                requirements = :requirements
                status = :status
        ';

        //prepare statment
        $stmt = $this->conn->prepare($query);

        //Clean and set data
        $this->company_id = htmlspecialchars(strip_tags($this->company_id));
        $this->job_name = htmlspecialchars(strip_tags($this->job_name));
        $this->discription = htmlspecialchars(strip_tags($this->discription));
        $this->requirements = htmlspecialchars(strip_tags($this->requirements));
        $this->status = htmlspecialchars(strip_tags($this->status));

        //Bind data
        $stmt->BindParam(':company_id', $this->company_id);
        $stmt->BindParam(':job_name', $this->job_name);
        $stmt->BindParam(':requirements', $this->requirements);
        $stmt->BindParam(':discription', $this->discription);
        $stmt->BindParam(':status', $this->status);

        //Execute query
        if($stmt->execute()) {
            return $stmt;
        }
    }

    //List all jobs
    public function list_all_jobs()
    {
        $query = '
            SELECT 
                job_id, 
                company_id, 
                job_name, 
                discription, 
                requirements
            FROM ' . $this->table . ' 
            WHERE status = open' ;

        //prepare query
        $stmt = $this->conn->prepare($query);
        
        //Execute query
        if ($stmt->execute()){
            return $stmt;
        }
    }

    //Public list company Jobs
    public function list_company_jobs()
    {
        $query = '
            SELECT 
                job_id, 
                company_id, 
                job_name, 
                discription, 
                requirements,
                status
            FROM ' . $this->table . ' 
            WHERE company_id = :company_id' ;

        //prepare query
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->company_id = htmlspecialchars(strip_tags($this->company_id));

        //Bind param
        $stmt->BindParam(':company_id', $this->company_id);
        
        //Execute query
        if ($stmt->execute()){
            return $stmt;
        }
    }

    //Toggle Job
    public function toggle_job(){
        $query = '
            SELECT status FROM 
            '. $this->table . ' 
            WHERE job_id = :job_id';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //bind the data
        $stmt->BindParam(':job_id', $this->job_id);

        if($stmt->execute())  {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //Set properties
            $this->status = $row['status'];

            //Check if job already closed
            if($this->status == "closed"){
                $this->status = "opened";
            } else {
                $this->status = "closed";
            }
        }//----------> END <------------------------

        //Update field if open
        $query = 'UPDATE '. $this->table. '
            SET status = :status
            WHERE id = :id';
        
        //prepare statement
        $stmt = $this->conn->prepare($query);

        //bind the data
        $stmt->BindParam(':job_id', $this->job_id);
        $stmt->BindParam(':status', $this->status);

        if($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    //------------------> END <-------------------

}