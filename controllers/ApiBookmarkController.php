<?php
    namespace App\Controllers;
    
    use App\Core\ApiController;
    use App\Models\AdModel;

    class ApiBookmarkController extends ApiController {
        public function getBookmarks() {
            $bookmarks =  $this->getSession()->get('bookmarks', []);
            $this->set('bookmarks', $bookmarks);
        }

        public function addBookmark($adId) {
            $adModel = new AdModel($this->getDatabaseConnection());
            $ad = $adModel->getById($adId);

            if(!$ad) {
                $this->set('error', -1);
                return;
            }

            $bookmarks = $this->getSession()->get('bookmarks', []);

            foreach ($bookmarks as $bookmark) {
                if($bookmark->ad_id == $adId) {
                    $this->set('error', -2);
                    return;
                }
            }

            $bookmarks[] = $ad;
            $this->getSession()->put('bookmarks', $bookmarks);
            $this->set('error', 0);
        }

        public function clear() {
            $this->getSession()->put('bookmarks', []);
            $this->set('error', 0);
        }
    }

