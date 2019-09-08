<?php

namespace App\Http\Transformers;

use App\Concerns\Formatter;
use App\Models\Language as LanguageModel;
use League\Fractal\TransformerAbstract;

class LanguageTransformer extends TransformerAbstract
{
    use Formatter;

    public function transform(LanguageModel $language)
    {
        return [
            'language_id' => $language->uuid,
            'language_name' => $language->language_name,
            'language_code' => $language->language_code,
            'language_type' => $this->languages($language) ?? '',
            'language_status' => $language->language_status,
        ];
    }

    public function languages(LanguageModel $language)
    {
        $type = '';

        if($language->language_type == 0){
            $type = 'Native Language';
        }else if($language->language_type == 1){
            $type = 'Speaking Language';
        }else if($language->language_type == 2){
            $type = 'Other Language';
        }else{
            $type = 'Booking Language';
        }

        return $type;
    }
}