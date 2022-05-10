<?php

class Applied_jobs
{
    //DB Stuff
    private $conn;
    private $table = 'job_applied';

    //Props
    public $applied_id;
    public $company_id;
    public $applicant_id;
    public $status;
    public $interview_time;

    //Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //View all Applied Jobs (Applicant)
    public function list_applicant_jobs()
    {
        $query = 'SELECT * FROM 
        '. $this->table . ' 
        WHERE applicant_id = :applicant_id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->applicant_id = htmlspecialchars(strip_tags($this->applicant_id));

        //Bind data
        $stmt->BindParam(':applicant_id', $this->applicant_id);

        //Execute query
        if ($stmt->execute()) {
            return $stmt;
        }
    }

    //View all applied Jobs (Company)
    public function list_company_jobs()
    {
        $query = 'SELECT * FROM 
        ' . $this->table . ' 
        WHERE company_id = :company_id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Clean data
        $this->company_id = htmlspecialchars(strip_tags($this->company_id));

        //Bind data
        $stmt->BindParam(':company_id', $this->company_id);

        //Execute query
        if ($stmt->execute()) {
            return $stmt;
        }
    }

    //Delete job applied (Applicants)
    public function delete_job_applied()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE job_id = :job_id';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->job_id = htmlspecialchars(strip_tags($this->job_id));

        //Bind param
        $stmt->BindParam(':job_id', $this->job_id);

        //Execute
        if ($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }

    //Accept or reject applicant
    public function set_status()
    {
        $query = 'UPDATE ' .$this->table . ' 
        SET status = :status WHERE job_id = :job_id';

        //prepare statment
        $stmt = $this->conn->prepare($query);

        //clean data
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->job_id = htmlspecialchars(strip_tags($this->job_id));

        //Bind param
        $stmt->BindParam(':status', $this->status);
        $stmt->BindParam(':job_id', $this->job_id);

        //Execute
        if ($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }
}