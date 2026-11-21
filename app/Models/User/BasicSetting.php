<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class BasicSetting extends Model
{
    public $table = "user_basic_settings";

    protected $fillable = [
        'user_id',
        'favicon',
        'preloader',
        'preloader_status',
        'logo',
        'dark_logo',
        'mobile_logo',
        'web_app_image',
        'cv',
        'base_color',
        'theme',
        'breadcrumb',
        'hero_section_background_image',
        'timezone',
        'email',
        'from_name',
        'sender_name',
        'sender_email',
        'sender_phone',
        'sender_address',
        'sender_city',
        'sender_state',
        'sender_zipcode',
        'sender_country',
        'is_ai',
        'is_gemini',
        'is_openai',
        'gemini_api_key',
        'openai_api_key',
        'ai_engine'
    ];

    public function language()
    {
        return $this->hasMany('App\Models\User\Language', 'user_id');
    }
}
