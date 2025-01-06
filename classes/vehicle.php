<?php

class Vehicle {
    private $vehicle_id;
    private $vehicle_name;
    private $model;
    private $price;
    private $category_id;
    private $picture;
    private $reservation_id;
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function ShowVehicles() {
        $query = "SELECT * FROM vehicles";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function ShowVehicleDetails($id) {
        $query = "SELECT * FROM vehicles WHERE vehicle_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function SearchVehicles($keyword) {
        $query = "SELECT * FROM vehicles WHERE vehicle_name LIKE ? OR model LIKE ? OR price LIKE ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute(["%$keyword%", "%$keyword%", "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Modified to handle an array of vehicle data
    public function AddVehicles($vehicles_data) {
        $success = true;
        foreach ($vehicles_data as $data) {
            $query = "INSERT INTO vehicles (vehicle_name, model, price, category_id, picture)
                     VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute([
                $data['vehicle_name'],
                $data['model'],
                $data['price'],
                $data['category_id'],
                $data['picture']
            ]);
            if (!$result) {
                $success = false;
            }
        }
        return $success;
    }

    public function ModifyVehicle($id, $data) {
        $query = "UPDATE vehicles
                 SET vehicle_name = ?,
                     model = ?,
                     price = ?,
                     picture = ?,
                     category_id = ?
                 WHERE vehicle_id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            $data['vehicle_name'],
            $data['model'],
            $data['price'],
            $data['picture'],
            $data['category_id'],
            $id
        ]);
    }

    public function DeleteVehicle($id) {
        $query = "DELETE FROM vehicles WHERE vehicle_id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }
}