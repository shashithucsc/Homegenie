<?php

class SeasonalOfferModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getSeasonalOffers() {
        $query = "SELECT id, description, image FROM seasonal_offers";
        $this->db->query($query);
        $results = $this->db->resultSet();
        return $results;
    }

    public function addSeasonalOffer($description, $image) {
        $query = "INSERT INTO seasonal_offers (description, image) VALUES (:description, :image)";
        $this->db->query($query);
        $this->db->bind(':description', $description);
        $this->db->bind(':image', $image);
        return $this->db->execute();
    }

    public function updateSeasonalOffer($id, $description, $image) {
        $query = "UPDATE seasonal_offers SET description = :description" .
                 ($image ? ", image = :image" : "") . 
                 " WHERE id = :id";
        $this->db->query($query);
        $this->db->bind(':description', $description);
        $this->db->bind(':id', $id);
        if ($image) {
            $this->db->bind(':image', $image);
        }
        return $this->db->execute();
    }

    public function deleteSeasonalOffer($id) {
        $query = "DELETE FROM seasonal_offers WHERE id = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}