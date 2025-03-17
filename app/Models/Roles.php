<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
class Roles extends MY_Model
{
    use SoftDeletes;
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $fillable = ['name','guard_name'];

    public function acls(){
        return $this->hasMany(Acl_Roles::class,'role_id','id');
    }
    public function createdBy(){
        return $this->hasOne(User::class,'id','created_at');
    }
}
