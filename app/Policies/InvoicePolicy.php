<?php

namespace App\Policies;

use App\Models\Invoice;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
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
     * @param \App\Models\Invoice $category
     * @return mixed
     */
    public function view(\App\Models\User $user, Invoice $invoice)
    {
        return ($user->id===$invoice->customer_id) or $user->can('ORDER_VIEW');
    }

    /**
     * Determine whether the user can view the category.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Invoice $category
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
     * @param \App\Models\Invoice $category
     * @return mixed
     */
    public function update(\App\Models\User $user, Invoice $invoice)
    {
        return ($user->id===$invoice->customer_id) or $user->can('ORDER_UPDATE');
    }

    /**
     * Determine whether the user can view the category.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Invoice $category
     * @return mixed
     */
    public function delete(\App\Models\User $user, Invoice $invoice)
    {
        return $user->can('ORDER_DELETE');
    }
}
