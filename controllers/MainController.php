<?php   
    namespace App\Controllers;

    use App\Models\CategoryModel;
    use App\Models\AdModel;
    use App\Core\DatabaseConnection;
    use App\Core\Controller;
    use App\Validators\StringValidator;
    use App\Models\UserModel;

    class MainController extends Controller {
        public function home() {
            $categoryModel = new CategoryModel($this->getDatabaseConnection());
            $categories = $categoryModel->getAll();
            $this->set('categories', $categories);
        }

        public function getRegister() {

        }

        public function postRegister() {
            $email = \filter_input(INPUT_POST, 'reg_email', FILTER_SANITIZE_EMAIL);
            $forename = \filter_input(INPUT_POST, 'reg_forename', FILTER_SANITIZE_STRING);
            $surname = \filter_input(INPUT_POST, 'reg_surname', FILTER_SANITIZE_STRING);
            $phone = \filter_input(INPUT_POST, 'reg_phone', FILTER_SANITIZE_STRING);
            $username = \filter_input(INPUT_POST, 'reg_username', FILTER_SANITIZE_STRING);
            $password1 = \filter_input(INPUT_POST, 'reg_password_1', FILTER_SANITIZE_STRING);
            $password2 = \filter_input(INPUT_POST, 'reg_password_2', FILTER_SANITIZE_STRING);
            
            if ($password1 !== $password2) {
                $this->set('message', 'Došlo je do greške: Niste uneli dva puta istu lozinku.');
                return;
            }

            $validanPassword = (new StringValidator)
                                ->setMinLength(7)
                                ->setMaxLength(120)
                                ->isValid($password1);

            if (!$validanPassword) {
                $this->set('message', 'Došlo je do greške: Lozinka nije ispravnog formata.');
                return;
            }

            $userModel = new UserModel($this->getDatabaseConnection());

            $user = $userModel->getByFieldName('email', $email);
            if ($user) {
                $this->set('message', 'Došlo je do greške: Već postoji korisnik sa tom adresom e-pošte.');
                return;
            }

            $user = $userModel->getByFieldName('username', $username);
            if ($user) {
                $this->set('message', 'Došlo je do greške: Već postoji korisnik sa tim korisničkim imenom.');
                return;
            }

            $passwordHash = \password_hash($password1, PASSWORD_DEFAULT);

            $userId = $userModel->add([
                'username' => $username,
                'password' => $passwordHash,
                'email' => $email,
                'forename' => $forename,
                'surname' => $surname,
                'phone' => $phone

            ]);

            if (!$userId) {
                $this->set('message', 'Došlo je do greške: Nije bilo uspešno registrovanje naloga.');
                return;
            }

            $this->set('message', 'Napravljen je nov nalog. Sada možete da se privjavite.');

        }

        public function getLogin() {

        }

        public function postLogin() {
            $username = \filter_input(INPUT_POST, 'login_username', FILTER_SANITIZE_STRING);
            $password = \filter_input(INPUT_POST, 'login_password', FILTER_SANITIZE_STRING);

            $validanPassword = (new StringValidator())
                                ->setMinLength(7)
                                ->setMaxLength(120)
                                ->isValid($password);

            if ( !$validanPassword) {
                $this->set('message', 'Došlo je do greške: Lozinka nije ispravnog formata.');
                return;
            }

            $userModel = new UserModel($this->getDatabaseConnection());

            $user = $userModel->getByFieldName('username', $username);
            if (!$user) {
                $this->set('message', 'Došlo je do greške: Ne postoji korisnik sa tim kosrisničkim imenom.');
                return;
            }

            if (!password_verify($password, $user->password)) {
                sleep(1);
                $this->set('message', 'Došlo je do greške: Lozinka nije ispravna.');
                return;
            }

            $this->getSession()->put('user_id', $user->user_id);
            $this->getSession()->save();

            $this->redirect(\Configuration::BASE . 'user/profile');
        }

        public function getLogout() {
            $this->getSession()->remove('user_id');
            $this->getSession()->save();
            $this->redirect(\Configuration::BASE);
        }
    }

