<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class SeedDummyDataForSathika extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Find user sathikaqiq121@gmail.com
        $user = DB::table('users')->where('email', 'sathikaqiq121@gmail.com')->first();
        if (!$user) {
            return;
        }

        // 2. Resolve default user language
        $defaultLang = null;
        if (Schema::hasTable('user_languages')) {
            $defaultLang = DB::table('user_languages')
                ->where('user_id', $user->id)
                ->where('is_default', 1)
                ->first();
            if (!$defaultLang) {
                $defaultLang = DB::table('user_languages')
                    ->where('user_id', $user->id)
                    ->first();
            }
        }
        $langId = $defaultLang ? $defaultLang->id : 1;

        // 3. Resolve user currency
        $userCurrency = null;
        if (Schema::hasTable('user_currencies')) {
            $userCurrency = DB::table('user_currencies')
                ->where('user_id', $user->id)
                ->where('is_default', 1)
                ->first();
            if (!$userCurrency) {
                $userCurrency = DB::table('user_currencies')
                    ->where('user_id', $user->id)
                    ->first();
            }
        }
        $currencyId = $userCurrency ? $userCurrency->id : 1;

        // 4. Seed 150 Categories
        if (Schema::hasTable('user_item_categories')) {
            $currentCatCount = DB::table('user_item_categories')->where('user_id', $user->id)->count();
            if ($currentCatCount < 150) {
                $categoriesToInsert = [];
                for ($i = $currentCatCount + 1; $i <= 150; $i++) {
                    $categoriesToInsert[] = [
                        'unique_id' => uniqid() . '_' . $i,
                        'name' => 'Category ' . $i,
                        'color' => '1c2d3d',
                        'language_id' => $langId,
                        'status' => 1,
                        'slug' => 'category-' . $i . '-' . uniqid(),
                        'user_id' => $user->id,
                        'is_feature' => 1,
                        'serial_number' => $i,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                DB::table('user_item_categories')->insert($categoriesToInsert);
            }
        }

        // Fetch user category IDs for product association
        $categoryIds = [];
        if (Schema::hasTable('user_item_categories')) {
            $categoryIds = DB::table('user_item_categories')
                ->where('user_id', $user->id)
                ->pluck('id')
                ->toArray();
        }

        // 5. Seed 600 Products
        if (Schema::hasTable('user_items') && Schema::hasTable('user_item_contents')) {
            $currentItemCount = DB::table('user_items')->where('user_id', $user->id)->count();
            if ($currentItemCount < 600) {
                $contentsToInsert = [];
                for ($i = $currentItemCount + 1; $i <= 600; $i++) {
                    $itemId = DB::table('user_items')->insertGetId([
                        'user_id' => $user->id,
                        'stock' => 100,
                        'sku' => 'SKU-' . uniqid() . '-' . $i,
                        'status' => 1,
                        'current_price' => 10.00 + ($i % 50),
                        'previous_price' => 15.00 + ($i % 50),
                        'currency_id' => $currencyId,
                        'type' => 'physical',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    $catId = !empty($categoryIds) ? $categoryIds[($i - 1) % count($categoryIds)] : null;

                    $contentsToInsert[] = [
                        'item_id' => $itemId,
                        'user_id' => $user->id,
                        'language_id' => $langId,
                        'category_id' => $catId,
                        'title' => 'Product ' . $i,
                        'slug' => 'product-' . $i . '-' . uniqid(),
                        'summary' => 'Summary of product ' . $i,
                        'description' => 'Description of product ' . $i,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];

                    if (count($contentsToInsert) >= 100) {
                        DB::table('user_item_contents')->insert($contentsToInsert);
                        $contentsToInsert = [];
                    }
                }
                if (!empty($contentsToInsert)) {
                    DB::table('user_item_contents')->insert($contentsToInsert);
                }
            }
        }

        // 6. Seed 40 Custom Pages
        if (Schema::hasTable('user_pages') && Schema::hasTable('user_page_contents')) {
            $currentPageCount = DB::table('user_pages')->where('user_id', $user->id)->count();
            if ($currentPageCount < 40) {
                for ($i = $currentPageCount + 1; $i <= 40; $i++) {
                    $pageId = DB::table('user_pages')->insertGetId([
                        'user_id' => $user->id,
                        'status' => 1,
                        'serial_number' => $i,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    DB::table('user_page_contents')->insert([
                        'page_id' => $pageId,
                        'user_id' => $user->id,
                        'language_id' => $langId,
                        'title' => 'Custom Page ' . $i,
                        'slug' => 'custom-page-' . $i . '-' . uniqid(),
                        'body' => 'Body content for Custom Page ' . $i,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }

        // Resolve blog category
        $blogCategoryId = null;
        if (Schema::hasTable('user_blog_categories')) {
            $blogCategory = DB::table('user_blog_categories')
                ->where('user_id', $user->id)
                ->first();
            if (!$blogCategory) {
                $blogCategoryId = DB::table('user_blog_categories')->insertGetId([
                    'user_id' => $user->id,
                    'name' => 'General',
                    'status' => 1,
                    'serial_number' => 1,
                    'language_id' => $langId,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                $blogCategoryId = $blogCategory->id;
            }
        }

        // 7. Seed 100 Blogs
        if (Schema::hasTable('user_blogs') && Schema::hasTable('user_blog_contents')) {
            $currentBlogCount = DB::table('user_blogs')->where('user_id', $user->id)->count();
            if ($currentBlogCount < 100) {
                for ($i = $currentBlogCount + 1; $i <= 100; $i++) {
                    $blogId = DB::table('user_blogs')->insertGetId([
                        'user_id' => $user->id,
                        'status' => 1,
                        'serial_number' => $i,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    DB::table('user_blog_contents')->insert([
                        'blog_id' => $blogId,
                        'user_id' => $user->id,
                        'language_id' => $langId,
                        'category_id' => $blogCategoryId,
                        'title' => 'Blog Post ' . $i,
                        'slug' => 'blog-post-' . $i . '-' . uniqid(),
                        'content' => 'Full article body text for blog post number ' . $i,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }

        // 8. Seed 150 Coupons
        if (Schema::hasTable('user_coupons')) {
            $currentCouponCount = DB::table('user_coupons')->where('user_id', $user->id)->count();
            if ($currentCouponCount < 150) {
                $couponsToInsert = [];
                for ($i = $currentCouponCount + 1; $i <= 150; $i++) {
                    $couponsToInsert[] = [
                        'user_id' => $user->id,
                        'name' => 'Coupon ' . $i,
                        'code' => 'COUPON' . $i . '-' . strtoupper(Str::random(4)),
                        'type' => 'percentage',
                        'value' => 10,
                        'currency_id' => $currencyId,
                        'minimum_spend' => 50,
                        'start_date' => now()->toDateString(),
                        'end_date' => now()->addYear()->toDateString(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                DB::table('user_coupons')->insert($couponsToInsert);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
