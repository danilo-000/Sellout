<?php
   namespace App\Models;
   
   use App\Core\Model;
   use App\Core\Field;
   use App\Validators\NumberValidator;
   use App\Validators\DateTimeValidator;
   use App\Validators\StringValidator;
   use App\Validators\BitValidator;

   class AdModel extends Model {     
        protected function getFields(): array {
            return [
                'ad_id' => new Field((new NumberValidator())->setIntegerLength(10), false),
                'user_id' => new Field((new NumberValidator())->setIntegerLength(10)),
                'created_at' => new Field((new DateTimeValidator())->allowDate()->allowTime(), false),
                
                'title' => new Field((new StringValidator())->setMaxLength(255) ),
                'description' => new Field((new StringValidator())->setMaxLength(64*1024) ),
                'price' => new Field((new NumberValidator())->setDecimal()
                                                                     ->setUnsigned()
                                                                     ->setIntegerLength(7)
                                                                     ->setMaxDecimalDigits(2)),
                'ends_at' =>  new Field((new DateTimeValidator())->allowDate()->allowTime()),
                'category_id' => new Field((new NumberValidator())->setIntegerLength(10)),
                'phone' =>  new Field((new StringValidator())->setMaxLength(64) ),
                'email' =>   new Field((new StringValidator())->setMaxLength(64) ),
                'image_path' => new Field((new StringValidator())->setMaxLength(255))
            ];
        }
        public function  getAllByCategoryId(int $categoryId): array {
           return $this->getAllByFieldName('category_id', $categoryId);
        }

        public function  getAllByUserId(int $userId): array {
            return $this->getAllByFieldName('user_id', $userId);
        }

        public function getAllBySearch(string $keywords) {
            $sql = 'SELECT * FROM `ad` WHERE  `title` LIKE ? OR `description` LIKE ?;';

            $keywords = '%' . $keywords . '%';

            $prep = $this->getConnection()->prepare($sql);
            if (!$prep) {
                return [];
            }

            $res = $prep->execute([$keywords, $keywords]);
            if (!$res) {
                return [];
            }

            return $prep->fetchAll(\PDO::FETCH_OBJ);
        }
    }