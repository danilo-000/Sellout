<?php
    namespace App\Controllers;

    use App\Core\Role\UserRoleController;
    use App\Models\CategoryModel;

    class UserCategoryManagmentController extends UserRoleController {
        public function categories() {
            $categoryModel = new CategoryModel($this->getDatabaseConnection());
            $categories = $categoryModel->getAll();
            $this->set('categories', $categories);
        }

        public function getEdit($categoryId) {
            $categoryModel = new CategoryModel($this->getDatabaseConnection());
            $category = $categoryModel->getById($categoryId);

            if (!$category) {
                $this->redirect(\Configuration::BASE . 'user/categories');
            }

            $this->set('category', $category);

            return $categoryModel;
        }

        public function postEdit($categoryId) {
            $categoryModel = $this->getEdit($categoryId);

            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);

            $categoryModel->editById($categoryId, [
                'name' => $name
            ]);

            $this->redirect(\Configuration::BASE . 'user/categories');
        }

        public function getAdd() {

        }

        public function postAdd() {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $categoryModel = new CategoryModel($this->getDatabaseConnection());

            $categoryId =$categoryModel->add([
                'name' => $name
            ]);

            if ($categoryId) {
                $this->redirect(\Configuration::BASE . 'user/categories');
            }

            $this->set('message', 'Došlo je do greške: Nije moguće dodati ovu kategoriju!');
        }
    }