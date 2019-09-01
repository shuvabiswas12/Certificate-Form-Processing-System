<?php
/**
 * Created by PhpStorm.
 * User: Shuva
 * Date: 8/2/2019
 * Time: 1:23 PM
 */

namespace App\Documents;


use App\Message\Message;
use App\Model\Database;
use Exception;

class Documents extends Database
{
    private $sscCertificate, $hscCertificate, $bscCertificate, $nid, $certficateFee, $studentID;

    public function __construct()
    {
        parent::__construct();
    }

    private function initVar($postArray)
    {
        if (array_key_exists("SSC", $postArray))
            $this->sscCertificate = $postArray["SSC"];

        if (array_key_exists("HSC", $postArray))
            $this->hscCertificate = $postArray["HSC"];

        if (array_key_exists("BSC", $postArray))
            $this->bscCertificate = $postArray["BSC"];

        if (array_key_exists("NID", $postArray))
            $this->nid = $postArray["NID"];

        if (array_key_exists("Fee", $postArray))
            $this->certficateFee = $postArray["Fee"];

        if (array_key_exists("studentID", $postArray))
            $this->studentID = $postArray["studentID"];
    }


    public function storeDocuments($postArray)
    {
        $this->initVar($postArray);

        $query = "INSERT INTO `documents` (`student_id`, `ssc_certificate`, `hsc_certificate`, `honours_certificate`, `certificate_fee`, `nid`) VALUES (?,?,?,?,?,?)";
        $dataArray = [$this->studentID, $this->sscCertificate, $this->hscCertificate, $this->bscCertificate, $this->certficateFee, $this->nid];

        try {
            $statement = $this->dbconnection->prepare($query); // return a boolean value
            $status = $statement->execute($dataArray); // return a boolean value

            if ($status) {
                Message::message("Success! Data has been inserted successfully.<br>");
                return true;
            } else {
                Message::message("Failed! Data doesn't not insert.<br>");
                return false;
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function isIdUnique() {
        $decision = false;

        $query = "SELECT student_id FROM `documents` WHERE student_id= $this->studentID ";
        $statement = $this->dbconnection->prepare($query);
        $statement->execute();
        while ($statement->fetch()) {
            $decision = true;
            break;
        }
        if ($decision) {
            Message::message("Failed! Duplicate ID can't be insert.<br>");
        }

        return $decision;
    }


    public function updateDocuments()
    {

    }

}