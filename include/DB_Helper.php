<?php

/**
 * User: Nelson Ogueh
 */
class DB_Helper
{
    public $conn;
    public $user_id;
    public $date;
    public $this_user_id;

    private $db_host = "localhost";
    private $db_user = "cloudfri_Admin";
    private $db_pass = "Oghenevovwero1";
    private $db_name = "1688-items";

    function __construct()
    {
        // Using a constructor to initialize the connection
        $this->conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        $this->date = $this->getDate();
    }

    //---------- SITE OPTIONS ---------//

    function getDate()
    {
        return date("Y-m-d H:i:s");
    }


    function getOnlyDate()
    {
        return date("Y-m-d");
    }

   /* public function getFirstname($user_id)
    { // Fetch single record
        $stmt = $this->conn->prepare("SELECT firstname FROM users  WHERE (user_id= '$user_id')");

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $user = $result->fetch_array(MYSQLI_ASSOC);
            $stmt->close();
            return $user["firstname"];
        } else {
            return NULL;
        }
    }*/


    // USED
    public function fetchItemsWithSearch($start_at, $search_keyword, $length_to_pick)
    {
        $stmt = $this->conn->prepare("SELECT * FROM items  WHERE (item_name LIKE '%$search_keyword%' OR our_sku LIKE '%$search_keyword%' OR item_price_yuan LIKE '%$search_keyword%' OR item_weight_kg LIKE '%$search_keyword%' OR date_added LIKE '%$search_keyword%') ORDER BY id  DESC LIMIT ?, ?");

        $stmt->bind_param("ss", $start_at, $length_to_pick);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $post = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $post;
        } else {
            return NULL;
        }
    }


}
