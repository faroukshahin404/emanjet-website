<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'active',
        'type',
        'code',
        'department_id',
        'employeeJob_id',
        'employeeSituation_id',
        'birthdate',
        'appointDate',
        'degree',
        'reservation_design',
        'limeted_number',
        'admin_id',
        'office_id',
        'print_type',
        'code_sign'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'password_value',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
        'birthdate' => 'date',
        'appointDate' => 'date',
        'last_login_at' => 'datetime',
        'last_logout_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the login username field.
     *
     * @return string
     */
    public function username()
    {
        // You can change this to 'email' or 'mobile' based on your login requirement
        return 'email';
    }
}
