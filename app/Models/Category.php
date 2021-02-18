<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 22/07/2018
 * Time: 14:37
 */

namespace App\Models;

class Category extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * @param Ticket $ticket
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public function addTicket(Ticket $ticket)
    {
        return $this->tickets()->save($ticket);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
