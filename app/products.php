<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    protected $fillable = [
        'Product_name',
        'description',
        'section_id',

    ];
    //protected $guarded = [];  بيعمل نفس وظيفة الي فوق 
    public function section()
    {
        return $this->belongsTo('App\sections');
    }
}
