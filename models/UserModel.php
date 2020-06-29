<?php
    namespace App\Models;
    use App\Core\Field;
    use App\Core\Model;
    use App\Validators\NumberValidator;
    use App\Validators\DateTimeValidator;
    use App\Validators\StringValidator;

    class UserModel extends Model {
        protected function getFields(): array {
            return [
                'user_id' => new Field((new NumberValidator())->setIntegerLength(10), false),
                'created_at' => new Field((new DateTimeValidator())->allowDate()->allowTime(), false),
                'username' =>   new Field((new StringValidator())->setMaxLength(64) ),
                'password' =>   new Field((new StringValidator())->setMaxLength(128) ),
                'email' =>   new Field((new StringValidator())->setMaxLength(255) ),
                'forename' =>   new Field((new StringValidator())->setMaxLength(64) ),
                'surname' =>   new Field((new StringValidator())->setMaxLength(64) ),
                'city' => new Field((new StringValidator())->setMaxLength(64) ),
                'phone' => new Field((new StringValidator())->setMaxLength(64) ),
            ];
        }

        public function getByUsername(string $username) {
            return $this->getByFieldName('username', $username);
        }
    } 