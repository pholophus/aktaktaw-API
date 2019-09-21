<?php

namespace App\Http\Transformers;

use App\Concerns\Formatter;
use App\Models\Booking as BookingModel;
use App\Models\Language as LanguageModel;
use League\Fractal\TransformerAbstract;

class BookingTransformer extends TransformerAbstract
{
    use Formatter;

    public function transform(BookingModel $booking)
    {
        return [
            'id' => $booking->uuid,
            'type' => $booking->type,
            'status' => $booking->status,
           // 'origin' => $booking->origin,
            'start_call_at' => $booking->start_call_at->format('c'),
            'end_call_at' => $booking->end_call_at ? $booking->end_call_at->format('c') : '', 
            'notes' => $booking->notes ?? '',
            // 'booking_fee' => $booking->booking_fee ?? '',
            'created_by' => $this->creator($booking) ?? $this->null(),
            'request_by' => $this->requester($booking) ?? $this->null(),
            'translator' => $booking->translator ? $this->translator($booking) : $this->null(),
            'requested_language' => $booking->requested_language_id ? $this->language($booking->request_language) : $this->null(),
            'spoken_language' => $booking->spoken_language_id ? $this->language($booking->spoken_language) : $this->null(),
            'expertise' => $this->expertise($booking) ?? $this->null(),
            'created_at' => $booking->created_at->format('c'),
            'updated_at' => $booking->created_at->format('c'),
        ];
    }

    public function translator(BookingModel $booking)
    {
        $translator = $booking->translator;
        return [
            'id' => $translator->uuid,
            'name' => $translator->profile->name,
        ];
    }

    public function creator(BookingModel $booking)
    {
        $creator = $booking->user;
        
        return [
            'id' => $creator->uuid ?? '',
            'name' => $creator->profile->name ?? '' ,
            'role_id' => $creator->roles()->first()->uuid ?? '',
        ];
    }

    public function requester(BookingModel $booking)
    {
        $id = $booking->requester_id;
        //dd($id);
        $requester = $booking->user->where('id',$id)->first();
        //dd($requester);
        return [
            'id' => $requester->uuid ?? '',
            'name' => $requester->profile->name ?? '' ,
        ];
        
        return $item;
    }

    public function expertise(BookingModel $booking)
    {
        $expertise = $booking->expertise;
        return [
            'id' => $expertise->uuid ?? '' ,
            'name' => $expertise->expertise_name ?? '' ,
        ];
    }

    public function language(LanguageModel $language)
    {
        return [
            'id' => $language->uuid ?? '' ,
            'name' => $language->name ?? '' ,
        ];
    }


    //iqbal

    
    // public function translator(BookingModel $booking)
    // {
    //     $translators = $booking->translators;
    //     $item = [];
    //     foreach ($translators as $translator) {
    //         $item[] = [
    //             'id' => $translator->uuid,
    //             'name' => $translator->name,
    //             'code' => $translator->code
    //         ];
    //     }
    //     return $item;
    // }
    // public function groups(BookingModel $booking)
    // {
    //     $groups = $booking->groups;
    //     $item = [];
    //     foreach ($groups as $group) {
    //         $item[] = [
    //             'id' => $group->uuid,
    //             'name' => $group->name,
    //             'slug' => $group->slug
    //         ];
    //     }
    //     return $item;
    // }
    // public function roles(BookingModel $booking)
    // {
    //     $items = [];
    //     $roles = $booking->roles()->get();
    //     foreach ($roles as $role) {
    //         array_push($items, [
    //             'id' => $role->uuid,
    //             'slug' => $role->slug,
    //             'name' => $role->name
    //         ]);
    //     }
    //     return $items;
    // }
}
