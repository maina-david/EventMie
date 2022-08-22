<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Classiebit\Eventmie\Models\Event as BaseModel;
use DB;

class Event extends BaseModel
{
    // search customers
    public function search_customers($email = null)
    {
        $query = DB::table('users'); 
        $query->select('name', 'id', 'email', 'phone')
                ->where('role_id', 2)
                ->where('email', $email);
        
        $result = $query->get();
        return to_array($result);
    }
}
