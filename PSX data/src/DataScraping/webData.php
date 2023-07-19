<?php
include('simple_html_dom.php');
require '..\Database\databaseConfig.php';

class DataScraper {
    private $url;
    private $html;
    private $database;
    private $conn;


    public function __construct($url) {
        $this->database = databaseConfig::getInstance();
        $this->conn = $this->database->getConn();

        $this->url = $url;
        $this->html = new simple_html_dom();
    }

    public function scrapeData($n) {
        $this->html->load_file($this->url);
        $links = $this->html->find('.tbl__body', $n);
        $table_data = $links->find('td');

        if ($table_data) {
            
            $state = $table_data[1]->plaintext;
            $trade = $table_data[2]->plaintext;
            $volume = $table_data[3]->plaintext;
            $value = $table_data[4]->plaintext;
            // echo "Market: $market<br>";
            // echo "State: $state<br>";
            // echo "Trades: $trade<br>";
            // echo "Volume: $volume<br>";
            // echo "Value: $value<br>";
            return array($state,$trade,$volume,$value);
        } else {
            echo "No data found";
        }

        $this->html->clear();
    }

    public function insertNDM(){
        // INSERT QUERIES
        $result=$this->scrapeData(7);
        mysqli_query($this->conn, "INSERT INTO ndm VALUES(NULL,'$result[0]','$result[1]','$result[2]','$result[3]')");
        // echo $result[0];
    }

    public function insertREG(){
        $result=$this->scrapeData(1);
        mysqli_query($this->conn, "INSERT INTO reg VALUES(NULL,'$result[0]','$result[1]','$result[2]','$result[3]')");
        // echo $result[0];
    }
    public function insertFUT(){
        $result=$this->scrapeData(3);
        mysqli_query($this->conn, "INSERT INTO fut VALUES(NULL,'$result[0]','$result[1]','$result[2]','$result[3]')");
        // echo $result[0];
    }
    public function insertODL(){
        $result=$this->scrapeData(4);
        mysqli_query($this->conn, "INSERT INTO odl VALUES(NULL,'$result[0]','$result[1]','$result[2]','$result[3]')");
        // echo $result[0];
    }
}

// Usage example
$url = 'WEBSITE URL';
$dataScraper = new DataScraper($url);

$dataScraper->insertNDM();
$dataScraper->insertODL();
$dataScraper->insertFUT();
$dataScraper->insertREG();
    
