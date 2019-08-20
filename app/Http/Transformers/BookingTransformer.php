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
            'origin' => $booking->origin,
            'booking_date' => $booking->booking_date ?? '',
            'booking_time' => $booking->booking_time ?? '',
            //'call_duration' => $booking->call_duration ?? '',
            'end_call' => $booking->end_call ?? '',  
            'notes' => $booking->notes ?? '',
            'language' => $booking->language ?? '',
            // 'translator' => $this->translator($booking) ?? '',
            'origin' => $this->origin($booking) ?? '',
            'expertise' => $this->expertise($booking) ?? '',
            'type' => $this->type($booking) ?? '',
            // 'status' => $this->status($booking) ?? '',
            'created_at' => $booking->created_at->format('c'),
            'updated_at' => $booking->created_at->format('c'),
        ];
    }

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
    public function origin(BookingModel $booking)
    {
        $user = $booking->user;

        $item [] = [
            'id' => $user->uuid ?? '',
            'first_name' => $user->profile->first_name ?? '',
            'last_name' => $user->profile->last_name ?? '',
        ];
        
        return $item;
    }
    public function expertise(BookingModel $booking)
    {
        $expertise = $booking->expertise;
        $item[] = [
            'id' => $expertise->uuid,
            'name' => $expertise->name,
            'slug' => $expertise->slug,
        ];

        return $item;
    }
    public function type(BookingModel $booking)
    {
        $type = $booking->type;
        $item[] = [
            'id' => $type->uuid,
            'name' => $type->name,
            'category' => $type->category,
        ];

        return $item;
    }
}
