<?php

namespace App\Http\Transformers;

use App\Concerns\Formatter;
use App\Models\Booking as BookingModel;
use League\Fractal\TransformerAbstract;

class BookingTransformer extends TransformerAbstract
{
    use Formatter;

    public function transform(BookingModel $booking)
    {
        return [
            'id' => $booking->uuid,
            'booking_type' => $booking->booking_type ?? '',
           // 'origin' => $booking->origin,
            'booking_date' => $booking->booking_date ?? '',
            'booking_time' => $booking->booking_time ?? '',
            'call_duration' => $booking->call_duration ?? '',
            'end_call' => $booking->end_call ?? '',  
            'notes' => $booking->notes ?? '',
            'booking_fee' => $booking->booking_fee ?? '',
            'booking_status' => $booking->booking_status ?? '',
            'created_by' => $this->creator($booking) ?? '',
            'request_by' => $this->requester($booking) ?? '',
            'translator_id' => $this->translator($booking) ?? '',
            'language_id' => $this->language($booking) ?? '',
            'expertise' => $this->expertise($booking) ?? '',
            'created_at' => $booking->created_at->format('c'),
            'updated_at' => $booking->created_at->format('c'),
        ];
    }

    public function translator(BookingModel $booking)
    {
        $id = $booking->translator_id;
        $translator = $booking->user->where('id',$id)->first();

            $item[] = [
                'id' => $translator->uuid,
                'name' => $translator->profile->first_name .' '. $translator->profile->last_name ?? '' ,
            ];
 
        return $item;
    }
    public function creator(BookingModel $booking)
    {
        $creator = $booking->user;
        

        $item [] = [
            'id' => $creator->uuid ?? '',
            'name' => $creator->profile->first_name .' '. $creator->profile->last_name ?? '' ,
            'role_id' => $creator->role->first()->uuid ?? '',
        ];
        
        return $item;
    }

    public function requester(BookingModel $booking)
    {
        $id = $booking->requester_id;
        //dd($id);
        $requester = $booking->user->where('id',$id)->first();
        //dd($requester);
        $item [] = [
            'id' => $requester->uuid ?? '',
            'name' => $requester->profile->first_name .' '. $requester->profile->last_name ?? '' ,
        ];
        
        return $item;
    }

    public function expertise(BookingModel $booking)
    {
        $expertise = $booking->expertise;
        $item[] = [
            'id' => $expertise->uuid,
            'name' => $expertise->name,
        ];

        return $item;
    }
    // public function language(BookingModel $booking)
    // {
    //     $language = $booking->language;
    //     $item[] = [
    //         'id' => $language->uuid,
    //         'name' => $language->language_name,
    //     ];

    //     return $item;
    // }


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
