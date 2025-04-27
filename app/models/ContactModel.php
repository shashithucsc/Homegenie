<?php
    class ContactModel{

        private $db;

        public function __construct(){
            $this->db = new Database();

        }

        public function createContact($data){
            $this->db->query("INSERT INTO contact (full_name, email, phone,subject, message) VALUES (:full_name, :email, :phone, :subject, :message)");

            $this->db->bind(':full_name',$data['full_name']);
            $this->db->bind(':email',$data['email']);
            $this->db->bind(':phone',$data['phone']);
            $this->db->bind(':subject',$data['subject']);
            $this->db->bind(':message',$data['message']);

            return $this->db->execute();
        }
    }