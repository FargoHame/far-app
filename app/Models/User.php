<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Laravel\Cashier\Billable;


class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'role',
        'first_name',
        'last_name',
        'school',
        'degree',
        'email',
        'password',
        'oauth_provider',
        'oauth_user_id',
        'oauth_token',
        'oauth_refresh_token',
        'affiliate_id',
        'referral_code',
        'gigwage_id',
        'description',
        'speciality',
        'social_links',
        'location',
        'user_roles',
        "career_id",
        "student_type_per_careers_id"
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function name() {
        return $this->first_name.' '.$this->last_name;
    }

    public function stripeName()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function files() {
        return $this->hasMany('App\Models\File');
    }

    public function photo() {
        if ($this->profile_image != null) {
            return $this->profile_image;
        }
        return '/images/blank-profile.png';
    }

    public function get_code_prefinary() {
        if ($this->code_prefinary != null) {
            return $this->code_prefinary;
        }
        return 'null';
    }
    public function get_referral_code() {
        if ($this->referral_code != null) {
            return $this->referral_code;
        }
        return 'null';
    }
    public function getUSStates()
    {
        return array(
            'AL' => 'ALABAMA',
            'AK' => 'ALASKA',
            'AS' => 'AMERICAN SAMOA',
            'AZ' => 'ARIZONA',
            'AR' => 'ARKANSAS',
            'CA' => 'CALIFORNIA',
            'CO' => 'COLORADO',
            'CT' => 'CONNECTICUT',
            'DE' => 'DELAWARE',
            'DC' => 'DISTRICT OF COLUMBIA',
            'FM' => 'FEDERATED STATES OF MICRONESIA',
            'FL' => 'FLORIDA',
            'GA' => 'GEORGIA',
            'GU' => 'GUAM GU',
            'HI' => 'HAWAII',
            'ID' => 'IDAHO',
            'IL' => 'ILLINOIS',
            'IN' => 'INDIANA',
            'IA' => 'IOWA',
            'KS' => 'KANSAS',
            'KY' => 'KENTUCKY',
            'LA' => 'LOUISIANA',
            'ME' => 'MAINE',
            'MH' => 'MARSHALL ISLANDS',
            'MD' => 'MARYLAND',
            'MA' => 'MASSACHUSETTS',
            'MI' => 'MICHIGAN',
            'MN' => 'MINNESOTA',
            'MS' => 'MISSISSIPPI',
            'MO' => 'MISSOURI',
            'MT' => 'MONTANA',
            'NE' => 'NEBRASKA',
            'NV' => 'NEVADA',
            'NH' => 'NEW HAMPSHIRE',
            'NJ' => 'NEW JERSEY',
            'NM' => 'NEW MEXICO',
            'NY' => 'NEW YORK',
            'NC' => 'NORTH CAROLINA',
            'ND' => 'NORTH DAKOTA',
            'MP' => 'NORTHERN MARIANA ISLANDS',
            'OH' => 'OHIO',
            'OK' => 'OKLAHOMA',
            'OR' => 'OREGON',
            'PW' => 'PALAU',
            'PA' => 'PENNSYLVANIA',
            'PR' => 'PUERTO RICO',
            'RI' => 'RHODE ISLAND',
            'SC' => 'SOUTH CAROLINA',
            'SD' => 'SOUTH DAKOTA',
            'TN' => 'TENNESSEE',
            'TX' => 'TEXAS',
            'UT' => 'UTAH',
            'VT' => 'VERMONT',
            'VI' => 'VIRGIN ISLANDS',
            'VA' => 'VIRGINIA',
            'WA' => 'WASHINGTON',
            'WV' => 'WEST VIRGINIA',
            'WI' => 'WISCONSIN',
            'WY' => 'WYOMING',
            'AE' => 'ARMED FORCES AFRICA \ CANADA \ EUROPE \ MIDDLE EAST',
            'AA' => 'ARMED FORCES AMERICA (EXCEPT CANADA)',
            'AP' => 'ARMED FORCES PACIFIC'
        );
    }
}
