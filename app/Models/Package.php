<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public $table = "packages";

    protected $fillable = [
        'title',
        'slug',
        'price',
        'term',
        'featured',
        'recommended',
        'icon',
        'is_trial',
        'trial_days',
        'post_limit',
        'product_limit',
        'categories_limit',
        'subcategories_limit',
        'order_limit',
        'language_limit',
        'number_of_custom_page',
        'status',
        'features',
        'meta_keywords',
        'meta_description',
        'ai_engine',
        'ai_token_limit',
        'ai_image_limit'
    ];

    public static function ensureMonthlyPremiumExists(): void
    {
        try {
            if (!\Illuminate\Support\Facades\Schema::hasTable('packages')) {
                return;
            }

            // 1. Rename 'Free .in Domain' to 'Free .com Domain' in package_features if exists
            if (\Illuminate\Support\Facades\Schema::hasTable('package_features')) {
                \Illuminate\Support\Facades\DB::table('package_features')
                    ->where('name', 'Free .in Domain')
                    ->orWhere('keyword', 'Free .in Domain')
                    ->update([
                        'name' => 'Free .com Domain',
                        'keyword' => 'Free .com Domain',
                        'updated_at' => now(),
                    ]);
            }

            // 2. Rename in existing packages' features JSON
            $packagesWithIn = self::where('features', 'like', '%Free .in Domain%')->get();
            foreach ($packagesWithIn as $pkg) {
                $feats = json_decode($pkg->features, true) ?: [];
                $updated = false;
                foreach ($feats as $k => $f) {
                    if ($f === 'Free .in Domain') {
                        $feats[$k] = 'Free .com Domain';
                        $updated = true;
                    }
                }
                if ($updated) {
                    $pkg->features = json_encode(array_values($feats));
                    $pkg->save();
                }
            }

            // 3. Ensure Monthly Premium package exists (price: 799, all features except Custom Domain and Free Domain)
            $existing = self::where('title', 'Premium')->where('term', 'monthly')->first();
            if (!$existing) {
                $premiumMonthlyFeatures = [
                    "Subdomain",
                    "QR Builder",
                    "Blog",
                    "Custom Page",
                    "Google Login",
                    "Google Analytics",
                    "Facebook Pixel",
                    "Google Recaptcha",
                    "WhatsApp Chat Button",
                    "Tawk to",
                    "Disqus",
                    "Advanced Report Admin Panel",
                    "Mail Notifications",
                    "Push Notification Updates",
                    "Wishlist Features",
                    "Themes",
                    "New Themes",
                    "GST Billing",
                    "Offline Payment Options",
                    "Bank Transfer Integrations",
                    "Phonepe Payment Options",
                    "Razor Pay Payment Integration",
                    "Inventory management",
                    "Product Individual Reports",
                    "Orders Individual Reports",
                    "Shipping Integration",
                    "Order Tracking Feature",
                    "Good Customer Support",
                    "Priority WhatsApp Support",
                    "24/7 Call Support",
                    "Staff Accounts",
                    "Staff Management",
                    "Bulk_Product_Upload",
                    "App_Install_Feature",
                    "Unlimited Customers",
                    "Pwt Feature",
                    "Push Notification",
                    "Contact",
                    "Footer Mail",
                    "Profile Listing"
                ];

                self::create([
                    'title' => 'Premium',
                    'slug' => 'premium-monthly',
                    'price' => 799,
                    'term' => 'monthly',
                    'featured' => '1',
                    'recommended' => '0',
                    'icon' => 'fas fa-crown',
                    'is_trial' => '0',
                    'trial_days' => 0,
                    'post_limit' => 999999,
                    'product_limit' => 999,
                    'categories_limit' => 150,
                    'subcategories_limit' => 150,
                    'order_limit' => 999999,
                    'coupon_limit' => 150,
                    'language_limit' => 4,
                    'number_of_custom_page' => 40,
                    'status' => '1',
                    'features' => json_encode($premiumMonthlyFeatures),
                ]);
            }
        } catch (\Throwable $e) {
            // Non-blocking
        }
    }

    public function memberships()
    {
        return $this->hasMany('App\Models\Membership');
    }
}
