<?php

namespace App\Policies;

use App\Models\Payment;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentPolicy
{
    use HandlesAuthorization;

    public function viewAny(\App\Models\User $user)
    {
        return $user->can('ORDER_VIEW');
    }

    /**
     * Determine whether the user can view the category.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Payment $category
     * @return mixed
     */
    public function view(\App\Models\User $user, Payment $payment)
    {
        return ($user->id===$payment->invoice->customer_id) or $user->can('ORDER_VIEW');
    }

    /**
     * Determine whether the user can view the category.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Payment $category
     * @return mixed
     */
    public function create(\App\Models\User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the category.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Payment $category
     * @return mixed
     */
    public function update(\App\Models\User $user, Payment $payment)
    {
        return false;
    }

    /**
     * Determine whether the user can view the category.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Payment $category
     * @return mixed
     */
    public function delete(\App\Models\User $user, Payment $payment)
    {
        return $user->can('ORDER_DELETE');
    }
}
