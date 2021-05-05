<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Room;

class RoomPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * ルームの閲覧権限
     * @param User $user
     * @param Room $room
     * @return bool
     */
    public function view(User $user, Room $room) {
        return $user->id === $room->user_id;
    }
}
