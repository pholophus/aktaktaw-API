<?php

namespace App\Observers;

/**
 *
 */
class Kernel
{
    /**
     * Array of model-observer
     * @var array
     */
    protected $observers = [
        //observe 1 observers
        // \App\User::class => \App\Observers\NewsboardObserver::class,
    ];

    protected $observeBy = [
        \App\Observers\OnCreatingObserver::class => [
            /**
             * Models add below here
             */
            \App\Models\User::class,
            \App\Models\Role::class,
            \App\Models\Language::class,
            \App\Models\Base::class,
            \App\Models\Language::class,
            \App\Models\Notification::class,
            \App\Models\Booking::class,
            \App\Models\Profile::class,
            \App\Models\Expertise::class,
            \App\Models\Media::class,
            \App\Models\Wallet::class,
            \App\Models\Fee::class,
            \App\Models\Loc::class,
            \App\Models\Investor::class,
        ],
    ];

    /**
     * Make this class
     * @return \App\Observers\Kernel
     */
    public static function make()
    {
        return (new self);
    }

    /**
     * Register observers
     * @return void
     */
    public function observes()
    {
        $this->observeSingle();
        $this->observeBy();
    }

    /**
     * Observe One-on-One Model-Observer
     * @return void
     */
    private function observeSingle()
    {
        if (count($this->observers) > 0) {
            foreach ($this->observers as $model => $observer) {
                if (class_exists($model) && class_exists($observer)) {
                    $model::observe($observer);
                }
            }
        }
    }
    private function observeBy()
    {
        if (count($this->observeBy) > 0) {
            foreach ($this->observeBy as $observer => $models) {
                foreach ($models as $model) {
                    if (class_exists($model) && class_exists($observer)) {
                        $model::observe($observer);
                    }
                }
            }
        }
    }
}
