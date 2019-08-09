<?php

namespace App\Http\Transformers;

use App\Concerns\Formatter;
use App\Models\UserLanguage as LanguageModel;
use League\Fractal\TransformerAbstract;

class LanguageUserTransformer extends TransformerAbstract
{
    use Formatter;

    public function transform(LanguageModel $language)
    {
        return [
            'id' => $language->uuid,
            'language name' => $language->language_name,
            'created_at' => $language->created_at->format('c'),
            'updated_at' => $language->created_at->format('c'),
        ];
    }
}