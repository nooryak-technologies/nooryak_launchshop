<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class SeedRealBlogsAndCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Delete dummy categories and blogs
        $dummyCategoryNames = ['International', 'Tech', 'Miscellaneous', 'Lifestyle', 'General'];
        
        if (Schema::hasTable('bcategories')) {
            // Find dummy category IDs
            $dummyCatIds = DB::table('bcategories')
                ->whereIn('name', $dummyCategoryNames)
                ->pluck('id')
                ->toArray();
                
            if (!empty($dummyCatIds)) {
                if (Schema::hasTable('blogs')) {
                    DB::table('blogs')->whereIn('bcategory_id', $dummyCatIds)->delete();
                }
                DB::table('bcategories')->whereIn('id', $dummyCatIds)->delete();
            }
        }
        
        // 2. Fetch all languages
        if (Schema::hasTable('languages')) {
            $languages = DB::table('languages')->get();
        } else {
            $languages = [ (object) ['id' => 1] ];
        }
        
        // 3. Define the real categories and blogs
        $newCategories = [
            [
                'name' => 'CLOTHING',
                'serial_number' => 10,
                'blogs' => [
                    [
                        'image' => 'clothing_theme_blog.png',
                        'title' => 'How to Start a Highly Successful Online Clothing Store',
                        'content' => '<p>Starting an online clothing store is one of the most profitable eCommerce ventures today. However, success requires more than just listing products. In this guide, we dive deep into the essential steps to launch and scale a fashion brand:</p><ul><li><strong>Niche Selection:</strong> Identify a target audience with high demand (e.g., sustainable apparel, activewear, luxury street fashion).</li><li><strong>UX Design:</strong> Utilize high-conversion layouts, size charts, detailed imagery, and seamless filters.</li><li><strong>Inventory Management:</strong> Track stocks carefully and sync variants (size, color) to avoid out-of-stock orders.</li><li><strong>Marketing:</strong> Leverage social media marketing, influencer partnerships, and customer reviews to build trust.</li></ul><p>Launchshop provides premium clothing themes out-of-the-box, optimized for fast page speed and mobile responsiveness.</p>',
                    ]
                ]
            ],
            [
                'name' => 'ELECTRONICS',
                'serial_number' => 20,
                'blogs' => [
                    [
                        'image' => 'electronics_theme_blog.png',
                        'title' => 'Top Tech Themes: Optimizing Gadget Store User Experience',
                        'content' => '<p>Selling electronics and gadgets online comes with unique challenges. Customers want detailed specifications, comparisons, and assurances of quality. Here is how you can optimize your electronics storefront:</p><ul><li><strong>Product Specifications:</strong> Clear, tabular spec sheets showing technical details (CPU, battery, weight).</li><li><strong>High-Resolution Zoom:</strong> Allow users to inspect gadgets from multiple angles.</li><li><strong>Filter Systems:</strong> Enable filtering by brand, price range, storage capacity, and features.</li><li><strong>Trust Indicators:</strong> Display warranty details and customer reviews prominently.</li></ul><p>By using Launchshop tech templates, you get an interface designed specifically for electronics merchants, boosting customer confidence and conversion rates.</p>',
                    ]
                ]
            ],
            [
                'name' => 'JEWELRY',
                'serial_number' => 30,
                'blogs' => [
                    [
                        'image' => 'jewelry_theme_blog.png',
                        'title' => 'Elegant Luxury Themes for Accessories & Jewelry E-commerce',
                        'content' => '<p>Luxury accessories and jewelry require a digital experience that reflects their elegance. The key is minimalist design, rich typography, and beautiful product showcases:</p><ul><li><strong>Visual Storytelling:</strong> Use video headers and lookbooks to display necklaces, rings, and bracelets in real-world settings.</li><li><strong>Color Palette:</strong> Select warm golds, soft pastel backgrounds, and sleek dark modes that exude premium quality.</li><li><strong>Interactive Elements:</strong> Smooth micro-interactions, subtle hover effects, and elegant transitions keep users engaged.</li><li><strong>Secure Checkout:</strong> Emphasize trust badges and secure payment options for high-ticket purchases.</li></ul><p>Elevate your brand using Launchshop premium jewelry layouts, built with maximum aesthetic care.</p>',
                    ]
                ]
            ],
            [
                'name' => 'GROCERY',
                'serial_number' => 40,
                'blogs' => [
                    [
                        'image' => 'grocery_theme_blog.png',
                        'title' => 'Grocery Store Launch: Fast Checkout & Delivery Optimization',
                        'content' => '<p>Online grocery shopping is all about speed, convenience, and fresh presentation. To build a successful supermarket store, you need dedicated shopping features:</p><ul><li><strong>Instant Add-to-Cart:</strong> Let users add vegetables, fruits, and pantry items directly from the product listings page.</li><li><strong>Delivery Scheduling:</strong> Allow customers to pick convenient time slots for local neighborhood deliveries.</li><li><strong>Stock Alerts:</strong> Show real-time stock levels (e.g., "Only 3 left in stock") to encourage purchases.</li><li><strong>Clean Categories:</strong> Categorize products efficiently (organic vegetables, dairy, bakery) for quick navigation.</li></ul><p>Launchshop grocery templates are pre-configured with instant cart additions and optimized mobile speed for busy shoppers.</p>',
                    ]
                ]
            ],
            [
                'name' => 'BEAUTY',
                'serial_number' => 50,
                'blogs' => [
                    [
                        'image' => 'beauty_theme_blog.png',
                        'title' => 'Skincare & Cosmetics Themes: Designing Beauty Showrooms',
                        'content' => '<p>The beauty industry thrives on aesthetics and product education. Your online shop needs to offer a clean, natural, and premium look that makes products shine:</p><ul><li><strong>Routine Builder:</strong> Group complementary items together to help users construct complete skincare routines.</li><li><strong>Shade Finder:</strong> Provide guides and interactive options to help customers choose matching makeups.</li><li><strong>Ingredient Transparency:</strong> Detail clean ingredients and cruelty-free certifications prominently.</li><li><strong>Social Proof:</strong> Display user-submitted photos and reviews showing skincare progress.</li></ul><p>Launchshop beauty themes are designed to present cosmetics, organic items, and perfumes in a stunning digital showroom.</p>',
                    ]
                ]
            ]
        ];

        // 4. Seed categories and blogs for each language
        foreach ($languages as $lang) {
            foreach ($newCategories as $catData) {
                // Check if category already exists for this language
                $catId = DB::table('bcategories')
                    ->where('language_id', $lang->id)
                    ->where('name', $catData['name'])
                    ->value('id');

                if (!$catId) {
                    $catId = DB::table('bcategories')->insertGetId([
                        'language_id' => $lang->id,
                        'name' => $catData['name'],
                        'status' => 1,
                        'serial_number' => $catData['serial_number'],
                    ]);
                }

                // Insert blogs under this category
                foreach ($catData['blogs'] as $blogData) {
                    $slug = Str::slug($blogData['title']);
                    
                    // Check if blog already exists
                    $blogExists = DB::table('blogs')
                        ->where('language_id', $lang->id)
                        ->where('slug', $slug)
                        ->exists();

                    if (!$blogExists) {
                        DB::table('blogs')->insert([
                            'language_id' => $lang->id,
                            'bcategory_id' => $catId,
                            'title' => $blogData['title'],
                            'slug' => $slug,
                            'main_image' => $blogData['image'],
                            'content' => $blogData['content'],
                            'meta_keywords' => implode(', ', explode(' ', strtolower($blogData['title']))),
                            'meta_description' => strip_tags(substr($blogData['content'], 0, 150)),
                            'serial_number' => $catData['serial_number'],
                            'created_at' => now(),
                            'updated_at' => now()
                        ]);
                    }
                }
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
