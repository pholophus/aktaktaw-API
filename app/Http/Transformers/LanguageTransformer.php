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
            'id' => $language->uuid,
            'name' => $language->name,
            'code' => $language->code,
            //'language_type' => $this->languages($language) ?? '',
            'is_active' => $language->is_active == 1 ? true : false,
        ];
    }
}