<?php

namespace App\Listeners;

use App\Events\DeletingAddress;
use App\Repository\AddressRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class DeletingAddressEmployee
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(DeletingAddress $deleting)
    {
        if($deleting->employee->id !== null && is_numeric($deleting->employee->id)){
           $address = App::make(AddressRepository::class);

           $address->delete($deleting->employee->addressRelation->id);
        }
    }
}
