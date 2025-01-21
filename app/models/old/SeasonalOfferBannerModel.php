<?php

class SeasonalOfferBannerModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getSeasonalOffer() {

        $this->db->query("SELECT * FROM seasonal_offers");
        $results = $this->db->resultSet();

        

        return $results;
        
    }
}


