<?php

namespace App\Http\Transformers;

use App\Concerns\Formatter;
use App\Models\Language as LanguageModel;
use League\Fractal\TransformerAbstract;

class LanguageUserTransformer extends TransformerAbstract
{
    use Formatter;

    public function transform(LanguageModel $language)
    {
        return [
            'id' => $language->uuid,
            'language name' => $language->language_name,
            'language code' => $language->language_code,
            'type_id' => $this->types($language) ?? '',
            'created_at' => $language->created_at->format('c'),
            'updated_at' => $language->created_at->format('c'),
        ];
    }

    public function types(LanguageModel $language)
    {
        $items = [];
        $types = $language->type()->get();
        foreach ($types as $type) {
            array_push($items, [
                'id' => $type->uuid,
                'name' => $type->name,
                'category' => $type->category
            ]);
        }
        return $items;
    }
}