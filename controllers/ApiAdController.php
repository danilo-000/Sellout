<?php
    namespace App\Controllers;
    
    use App\Core\ApiController;
    use App\Models\AdModel;

    class ApiAdController extends ApiController {
        public function show($id) {
            $adModel = new AdModel($this->getDatabaseConnection());
            $ad = $adModel->getById($id);
            $this->set('ad', $ad);
        }
    }