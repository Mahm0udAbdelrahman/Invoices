<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'file_name',
        'invoice_number',
        'created_by',

    ];

    // protected function getFileNameAttribute($value)
    // {
    //     if ($value) {
    //         return asset('media/invoice/' . $value);
    //     } else {
    //         return asset('media/invoice/default.png');
    //     }
    // }

    // public function setFileNameAttribute($value)
    // {
    //     if ($value) {

    //          $file_name = time() . '.' . $value->getClientOriginalExtension();
    //         $value->move(public_path('media/invoice/'), $file_name);
    //         $this->attributes['file_name'] = $file_name;
    //     }
    // }
}
