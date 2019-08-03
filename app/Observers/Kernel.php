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
            // \App\Models\UserBranch::class,
            // \App\Models\Branch::class,
            // \App\Models\Newsboard::class,
            // \App\Models\NewsboardInteraction::class,
            // \App\Models\Assignment::class,
            // \App\Models\AssignmentInteraction::class,
            // \App\Models\Notification::class,
            // \App\Models\Group::class,
             \App\Models\Role::class,
             \App\Models\Booking::class,
             \App\Models\Profile::class,
             \App\Models\Expertise::class,
            // \App\Models\Attachment::class,
            // \App\Models\Customer::class,
            // \App\Models\Group::class,
            // \App\Models\Conversation::class,
            // //kyc

            // \App\Models\KycQuestion::class,
            // \App\Models\KycQuestionSet::class,
            // \App\Models\KycAnswer::class,
            // \App\Models\KycType::class,
            // \App\Models\SiteVisit::class,

            // //attribtues
            // \App\Models\CallLog::class,
            // \App\Models\CreditLog::class,
            // \App\Models\CreditApplication::class,
            // \App\Models\CreditSecurity::class,
            // \App\Models\Note::class,
            // \App\Models\SalesAttribute::class,
            // \App\Models\PicContact::class
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
