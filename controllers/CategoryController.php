<?php   
    namespace App\Controllers;

    use App\Core\Controller;
    use App\Models\CategoryModel;
    use App\Models\AdModel;

    class CategoryController extends Controller{
        public function show($id) {
            $categoryModel = new CategoryModel($this->getDatabaseConnection());
            $category = $categoryModel->getById($id);

            if (!$category) {
                header('Location: /');
                exit;
            }

            $this->set('category', $category);

            $adModel = new AdModel($this->getDatabaseConnection());
            $adsInCategory = $adModel->getAllByCategoryId($id);
            $this->set('adsInCategory', $adsInCategory);
        }
    }