<?php

namespace Listbook\Policies;

use Listbook\User;
use Listbook\ListElement;
use Listbook\UserList;
use Illuminate\Auth\Access\HandlesAuthorization;

class ListElementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can modify the list element in the userlist.
     *
     * @param  \Listbook\User  $user
     * @param  \Listbook\ListElement  $listElement
     * @return mixed
     */
    public function modify(User $user, ListElement $listElement)
    {
        //solo el creador de la lista podrá modificar la misma
        //dd($listElement->list()->user_id());
        $list_id = UserList::findOrFail($listElement->user_list_id);
        return $list_id->user_id == $user->id;
    }

}
