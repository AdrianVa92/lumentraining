<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model
{
    use Authenticatable, Authorizable;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function addCategory(Category $category)
    {
        return $this->categories()->save($category);
    }

    /**
     * @param $id
     * @return array
     */
    public function deleteCategory($categoryId)
    {
        $this->categories()->find($categoryId)->delete();
        return ["message"=>"Category has been deleted"];
    }

    /**
     * @param $categoryName
     * @return int
     */
    public function hasDuplicateCategory($categoryName)
    {
        return $this->categories()->where("name", $categoryName)->count();
    }

    /**
     * @param Ticket $ticket
     * @param $category_id
     * @return mixed
     */
    public function addTicket(Ticket $ticket, $category_id)
    {
        return $this->categories()->find($category_id)->tickets()->create([
            "name"=>$ticket->name,
            "description"=>$ticket->description,
            "user_id"=> $this->id
        ]);
    }

    /**
     * @param $category_id
     * @param $ticketName
     * @return mixed
     */
    public function hasDuplicateTicket($category_id, $ticketName)
    {
        return $this->categories()->find($category_id)->tickets()->where("name", $ticketName)->count();
    }
}
