<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Procedures;
use App\Models\Specialities;

class Hospital extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'phone_no',
        'city',
        'pincode',
        'country',
        'beds_quantity',
        'specialities_id',
        'procedures_id',
        'image',
        'registration_details',
        'registration_file',
        'accredition_details',
        'accredition_certificate',
        'empanelments',
        'about',
        'facilities_avialable',
        'latitude',
        'longitude',
        'type',
        'name_on_bank',
        'bank_name',
        'branch_name',
        'ifsc',
        'ac_no',
        'ac_type',
        'micr_code',
        'pan_no',
        'cancel_cheque',
        'pan_image',
        'slug',
        'is_deleted',

    ];
    public function procedure()
    {
        return $this->belongsTo(Procedures::class, 'procedures_id');
    }
    public function specialities()
    {
        return $this->belongsTo(Specialities::class, 'specialities_id');
    }
}
