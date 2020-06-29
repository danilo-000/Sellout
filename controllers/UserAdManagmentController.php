<?php
    namespace App\Controllers;

    use App\Core\Role\UserRoleController;
    use App\Models\AdModel;
    use App\Models\CategoryModel;

    class UserAdManagmentController extends UserRoleController {
        public function ads() {
            $userId = $this->getSession()->get('user_id');

            $adModel = new AdModel($this->getDatabaseConnection());
            $ads = $adModel->getAllByUserId($userId);

            $this->set('ads', $ads);
        }

        public function getAdd() {
            $categoryModel = new CategoryModel($this->getDatabaseConnection());
            $categories = $categoryModel->getAll();
            $this->set('categories', $categories);
        }

        public function postAdd() {
            $addData = [
                'title' =>  \filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING),
                'description' => \filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING),
                'price' => sprintf("%.2f", \filter_input(INPUT_POST, 'price', FILTER_SANITIZE_STRING)),
                'ends_at' => \filter_input(INPUT_POST, 'ends_at', FILTER_SANITIZE_STRING),
                'category_id' => \filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT),
                'email' =>  \filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING),
                'phone' =>  \filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING),
                'user_id' => $this->getSession()->get('user_id')
            ];

            $adModel = new AdModel($this->getDatabaseConnection());

            $adId = $adModel->add($addData);

            if (!$adId) {
                $this->set('message', 'Oglas nije dodat.');
                return;
            }

            $uploadStatus = $this->doImageUpload('image', $adId);
            if (!$uploadStatus) {
                return;
            }

            $this->redirect( \Configuration::BASE . 'user/ads');

        }

        public function getEdit($adId) {
            $adModel = new AdModel($this->getDatabaseConnection());
            $ad = $adModel->getById($adId);

            if (!$ad) {
                $this->redirect( \Configuration::BASE . 'user/ads' );
                return;
            }

            if ($ad->user_id != $this->getSession()->get('user_id')) {
                $this->redirect( \Configuration::BASE . 'user/ads' );
                return; 
            }

            $ad->ends_at = str_replace(' ', 'T', substr($ad->ends_at, 0, 16));

            $this->set('ad', $ad);

            $categoryModel = new CategoryModel($this->getDatabaseConnection());
            $categories = $categoryModel->getAll();
            $this->set('categories', $categories);
        }

        public function postEdit($adId) {
            $this->getEdit($adId);

            $editData = [
                'title' =>  \filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING),
                'description' => \filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING),
                'price' => sprintf("%.2f", \filter_input(INPUT_POST, 'price', FILTER_SANITIZE_STRING)),
                'ends_at' => \filter_input(INPUT_POST, 'ends_at', FILTER_SANITIZE_STRING),
                'category_id' => \filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT),
                'email' =>  \filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING),
                'phone' =>  \filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING),
                ];

            $adModel = new AdModel($this->getDatabaseConnection());

            $res = $adModel->editById($adId, $editData);
            if (!$res) {
                $this->set('message', 'Nije bilo moguće izmeniti oglas.');
                return;
            }

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $uploadStatus = $this->doImageUpload('image', $adId);
                if (!$uploadStatus) {
                    return;
                }
            }

            $this->redirect( \Configuration::BASE . 'user/ads ');
        }

        private function doImageUpload(string $fieldName, string $adId): bool {
            $adModel = new AdModel($this->getDatabaseConnection());
            $ad = $adModel->getById(intval($adId));

            unlink(\Configuration::UPLOAD_DIR . $ad->image_path);

            $uploadPath = new \Upload\Storage\FileSystem(\Configuration::UPLOAD_DIR);
            $file = new \Upload\File($fieldName, $uploadPath);
            $file->setName($adId);
            $file->addValidations([
                new \Upload\Validation\Mimetype(["image/jpeg", "image/png"]),
                new \Upload\Validation\Size("3M"),
            ]);

            try {
                $file->upload();

                $fullFileName = $file->getNameWithExtension();

                $adModel->editById(intval($adId), [
                    "image_path" => $fullFileName
                ]);

                $this->doResize(
                    \Configuration::UPLOAD_DIR . $fullFileName,
                    \Configuration::DEFAULT_IMAGE_WIDTH,
                    \Configuration::DEFAULT_IMAGE_HEIGHT
                );

                return true;
            } catch (Exception $e) {
                $this->set('message', 'Greška: ' . implode(', ', $file->getErrors()));
                return false;
            }
        }

        private function doResize(string $filePath, int $w, int $h) {
            $longer = max($w, $h);

            $image = new \Gumlet\ImageResize($filePath);
            $image->resizeToBestFit($longer, $longer);
            $image->crop($w, $h);
            $image->save($filePath);
        }

    }
