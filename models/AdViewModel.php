<?php
    namespace App\Models;

    use App\Core\Model;
    use App\Core\Field;
    use App\Validators\NumberValidator;
    use App\Validators\DateTimeValidator;
    use App\Validators\StringValidator;

    class AdViewModel extends Model {
        protected function getFields(): array {
            return [
                'ad_view_id' => new Field((new NumberValidator())->setIntegerLength(11), false),
                'created_at'      => new Field((new DateTimeValidator())->allowDate()->allowTime() , false),

                'ad_id'      => new Field((new NumberValidator())->setIntegerLength(11)),
                'ip_address'      => new Field((new StringValidator(7, 255)) ),
                'user_agent'      => new Field((new StringValidator(0, 255)) )
            ];
        }

        public function getAllByAdId(int $adId): array {
            return $this->getAllByFieldName('ad_id', $adId);
        }

        public function getAllByIpAddress(string $ipAddress): array {
            return $this->getAllByFieldName('ip_address', $ipAddress);
        }
    }
