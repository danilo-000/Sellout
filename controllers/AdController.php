<?php   
    namespace App\Controllers;

    use App\Core\Controller;
    use App\Models\AdModel;
    use App\Models\AdViewModel;

    class AdController extends Controller{
        public function show($id) {
            $adModel = new AdModel($this->getDatabaseConnection());
            $ad = $adModel->getById($id);

            if (!$ad) {
                header('Location: /');
                exit;
            }

            $this->set('ad', $ad);

            $adViewModel = new AdViewModel($this->getDatabaseConnection());

            $ipAddress = filter_input(INPUT_SERVER, 'REMOTE_ADDR');
            $userAgent = filter_input(INPUT_SERVER, 'HTTP_USER_AGENT');

            $adViewModel->add(
                [
                    'ad_id' => $id,
                    'ip_address' => $ipAddress, 
                    'user_agent' => $userAgent
                ]
            );
        }

        private function normaliseKeywords(string $keywords): string {
            $keywords = trim($keywords);
            $keywords = preg_match('/ +/', ' ', $keywords);
            return $keywords;
        }

        public function postSearch() {
            $adModel = new AdModel($this->getDatabaseConnection());

            $q = filter_input(INPUT_POST, 'q', FILTER_SANITIZE_STRING);

            $keywords = $this->normaliseKeywords($q);

            $ads = $adModel->getAllBySearch($q);

            $this->set('ads', $ads);
        }
    }