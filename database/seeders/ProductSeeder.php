<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\ProductFeature;
use App\Models\DepartmentCategory;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates 200 products distributed across different categories
     */
    public function run(): void
    {
        // Schema::disableForeignKeyConstraints();
        Product::truncate();

        // Get all categories and brands
        $categories = Category::all();
        $brands = Brand::all();
        
        if ($categories->isEmpty() || $brands->isEmpty()) {
            $this->command->warn('Please run CategorySeeder and BrandSeeder first!');
            return;
        }

        // Product templates for different categories
        $productTemplates = [
            // DSLR Cameras (Category 1)
            [
                'category_id' => 1,
                'titles_ar' => ['كاميرا كانون EOS', 'كاميرا نيكون D', 'كاميرا سوني Alpha', 'كاميرا باناسونيك Lumix', 'كاميرا فوجي فيلم X-T'],
                'titles_en' => ['Canon EOS Camera', 'Nikon D Camera', 'Sony Alpha Camera', 'Panasonic Lumix Camera', 'Fujifilm X-T Camera'],
                'conditions' => ['new', 'used'],
            ],
            // Mirrorless Cameras (Category 2)
            [
                'category_id' => 2,
                'titles_ar' => ['كاميرا كانون EOS R', 'كاميرا نيكون Z', 'كاميرا سوني A7', 'كاميرا باناسونيك GH', 'كاميرا فوجي فيلم X-Pro'],
                'titles_en' => ['Canon EOS R Camera', 'Nikon Z Camera', 'Sony A7 Camera', 'Panasonic GH Camera', 'Fujifilm X-Pro Camera'],
                'conditions' => ['new', 'used'],
            ],
            // Video Cameras (Category 3)
            [
                'category_id' => 3,
                'titles_ar' => ['كاميرا سوني FX', 'كاميرا كانون C', 'كاميرا باناسونيك AG', 'كاميرا بلاك ماجيك', 'كاميرا ريد'],
                'titles_en' => ['Sony FX Camera', 'Canon C Camera', 'Panasonic AG Camera', 'Blackmagic Camera', 'Red Camera'],
                'conditions' => ['new', 'used', 'rent'],
            ],
            // Lenses (Category 4)
            [
                'category_id' => 4,
                'titles_ar' => ['عدسة كانون', 'عدسة نيكون', 'عدسة سوني', 'عدسة سيجما', 'عدسة تامرون'],
                'titles_en' => ['Canon Lens', 'Nikon Lens', 'Sony Lens', 'Sigma Lens', 'Tamron Lens'],
                'conditions' => ['new', 'used', 'rent'],
            ],
            // Lighting Equipment (Category 5)
            [
                'category_id' => 5,
                'titles_ar' => ['إضاءة جودوكس', 'إضاءة بروفوتو', 'إضاءة إل إي دي', 'إضاءة استوديو', 'إضاءة محمولة'],
                'titles_en' => ['Godox Lighting', 'Profoto Lighting', 'LED Lighting', 'Studio Lighting', 'Portable Lighting'],
                'conditions' => ['new', 'used', 'rent'],
            ],
            // Tripods & Stands (Category 6)
            [
                'category_id' => 6,
                'titles_ar' => ['حامل مانفروتو', 'حامل جيتز', 'حامل سيروي', 'حامل ثلاثي القوائم', 'حامل احترافي'],
                'titles_en' => ['Manfrotto Tripod', 'Gitzo Tripod', 'Sirui Tripod', 'Three-Legged Stand', 'Professional Tripod'],
                'conditions' => ['new', 'used', 'rent'],
            ],
            // Tripod (Category 7)
            [
                'category_id' => 7,
                'titles_ar' => ['حامل كاميرا', 'حامل منزلق', 'حامل رأس كرة', 'حامل سريع', 'حامل مضغوط'],
                'titles_en' => ['Camera Stand', 'Slider Stand', 'Ball Head Stand', 'Quick Stand', 'Compact Stand'],
                'conditions' => ['new', 'used', 'rent'],
            ],
            // Microphones (Category 8)
            [
                'category_id' => 8,
                'titles_ar' => ['ميكروفون رود', 'ميكروفون شور', 'ميكروفون لاسلكي', 'ميكروفون بندقية', 'ميكروفون لافالير'],
                'titles_en' => ['Rode Microphone', 'Shure Microphone', 'Wireless Microphone', 'Shotgun Microphone', 'Lavalier Microphone'],
                'conditions' => ['new', 'used', 'rent'],
            ],
            // Cinema Camera (Category 9)
            [
                'category_id' => 9,
                'titles_ar' => ['كاميرا سينمائية سوني', 'كاميرا سينمائية كانون', 'كاميرا سينمائية ريد', 'كاميرا سينمائية بلاك ماجيك', 'كاميرا سينمائية ARRI'],
                'titles_en' => ['Sony Cinema Camera', 'Canon Cinema Camera', 'Red Cinema Camera', 'Blackmagic Cinema Camera', 'ARRI Cinema Camera'],
                'conditions' => ['new', 'used', 'rent'],
            ],
        ];

        $productCounter = 0;
        $totalProducts = 200;
        $categoriesCount = count($productTemplates);
        $productsPerCategory = floor($totalProducts / $categoriesCount);
        $remainingProducts = $totalProducts % $categoriesCount;

        // Image URLs for different categories (using Unsplash Source API)
        $categoryImages = [
            1 => ['camera', 'dslr', 'photography', 'canon', 'nikon'], // DSLR Cameras
            2 => ['mirrorless', 'camera', 'sony', 'fujifilm'], // Mirrorless Cameras
            3 => ['video-camera', 'cinema', 'filming', 'camera'], // Video Cameras
            4 => ['camera-lens', 'lens', 'photography', 'canon-lens'], // Lenses
            5 => ['studio-lighting', 'light', 'photography-studio'], // Lighting Equipment
            6 => ['tripod', 'camera-stand', 'photography'], // Tripods & Stands
            7 => ['tripod', 'camera-stand', 'photography'], // Tripod
            8 => ['microphone', 'audio', 'recording'], // Microphones
            9 => ['cinema-camera', 'film-camera', 'professional-camera'], // Cinema Camera
        ];

        // Create products distributed across categories
        foreach ($productTemplates as $index => $template) {
            $categoryId = $template['category_id'];
            $titlesAr = $template['titles_ar'];
            $titlesEn = $template['titles_en'];
            $conditions = $template['conditions'];
            
            // Distribute remaining products to first categories
            $currentCategoryProducts = $productsPerCategory + ($index < $remainingProducts ? 1 : 0);
            
            for ($i = 0; $i < $currentCategoryProducts && $productCounter < $totalProducts; $i++) {
                $productCounter++;
                
                // Random selection
                $titleAr = $titlesAr[array_rand($titlesAr)] . ' ' . $productCounter;
                $titleEn = $titlesEn[array_rand($titlesEn)] . ' ' . $productCounter;
                $condition = $conditions[array_rand($conditions)];
                $brand = $brands->random();
                
                // Determine department based on condition
                $departmentId = ($condition === 'rent') ? 1 : 2; // 1 = Renting, 2 = Buying
                
                // Get department_category_id
                $departmentCategory = DepartmentCategory::where('department_id', $departmentId)
                    ->where('category_id', $categoryId)
                    ->first();

                // Generate description
                $descriptionAr = "منتج احترافي عالي الجودة - {$titleAr}. مناسب للاستخدام الاحترافي والهواة.";
                $descriptionEn = "Professional high-quality product - {$titleEn}. Suitable for professional and amateur use.";

                // Generate feature text
                $featureAr = "ميزات {$titleAr}:\n\n- جودة احترافية عالية\n- تصميم متين وموثوق\n- سهولة الاستخدام\n- مناسب للمحترفين والهواة";
                $featureEn = "Features of {$titleEn}:\n\n- High professional quality\n- Durable and reliable design\n- Easy to use\n- Suitable for professionals and amateurs";

                // Download and save product main image
                $mainImageName = $this->downloadProductImage($categoryId, $productCounter, 'main');
                
                // Create product
                $product = Product::create([
                    'image' => $mainImageName,
                    'department_id' => $departmentId,
                    'brand_id' => $brand->id,
                    'category_id' => $categoryId,
                    'department_category_id' => $departmentCategory ? $departmentCategory->id : null,
                    'type' => 'standard',
                    'condition' => $condition,
                    'status' => 1,
                ]);

                // Set translations
                $product->setTranslations([
                    'ar' => [
                        'title' => $titleAr,
                        'description' => $descriptionAr,
                    ],
                    'en' => [
                        'title' => $titleEn,
                        'description' => $descriptionEn,
                    ],
                ]);

                // Create variant
                $skuNumber = str_pad($productCounter, 4, '0', STR_PAD_LEFT);
                $basePrice = 1000 + ($productCounter * 25);
                $discountPercentage = ($condition === 'used') ? 15 : (($condition === 'rent') ? 0 : 10);
                $finalPrice = $condition === 'used' 
                    ? $basePrice * 0.85 
                    : (($condition === 'rent') ? $basePrice : $basePrice * 0.9);

                $product->variant()->create([
                    'sku' => ($condition === 'rent') ? "RENT-{$skuNumber}" : "PROD-{$skuNumber}",
                    'attribute_values' => '',
                    'price_before_discount' => $basePrice,
                    'discount_percentage' => $discountPercentage,
                    'price' => $finalPrice,
                    'quantity' => ($condition === 'used') ? rand(1, 3) : (($condition === 'rent') ? rand(2, 5) : rand(5, 20)),
                    'status' => 1,
                ]);

                // Create product images (3-5 images per product)
                $imageCount = rand(3, 5);
                for ($img = 1; $img <= $imageCount; $img++) {
                    $imageName = $this->downloadProductImage($categoryId, $productCounter, $img);
                    $product->images()->create([
                        'image' => $imageName,
                    ]);
                }

                // Create product feature
                $productFeature = ProductFeature::create([
                    'product_id' => $product->id,
                ]);
                $productFeature->setTranslations([
                    'ar' => [
                        'title' => 'ميزات المنتج',
                        'description' => $featureAr,
                    ],
                    'en' => [
                        'title' => 'Product Features',
                        'description' => $featureEn,
                    ],
                ]);
            }
        }

        $this->command->info("Created {$productCounter} products successfully!");
    }

    /**
     * Download product image from Unsplash or use placeholder
     * 
     * @param int $categoryId
     * @param int $productCounter
     * @param string|int $imageIndex
     * @return string Image filename
     */
    private function downloadProductImage($categoryId, $productCounter, $imageIndex): string
    {
        $uploadPath = public_path('upload/general');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }

        $imageName = "product-{$productCounter}-{$imageIndex}.jpg";
        $imagePath = $uploadPath . '/' . $imageName;

        // If image already exists, return the name
        if (File::exists($imagePath)) {
            return $imageName;
        }

        // Get image keywords based on category
        $keywords = [
            1 => ['camera', 'dslr', 'photography'],
            2 => ['mirrorless', 'camera', 'sony'],
            3 => ['video-camera', 'cinema', 'filming'],
            4 => ['camera-lens', 'lens', 'photography'],
            5 => ['studio-lighting', 'light', 'photography-studio'],
            6 => ['tripod', 'camera-stand'],
            7 => ['tripod', 'camera-stand'],
            8 => ['microphone', 'audio', 'recording'],
            9 => ['cinema-camera', 'film-camera', 'professional'],
        ];

        $categoryKeywords = $keywords[$categoryId] ?? ['camera', 'photography'];
        $keyword = $categoryKeywords[array_rand($categoryKeywords)];

        // Use a deterministic approach based on product counter for consistent images
        $seed = ($productCounter * 100) + (is_numeric($imageIndex) ? (int)$imageIndex : 1);

        // Use Picsum Photos (Lorem Picsum) - reliable placeholder service
        try {
            $placeholderUrl = "https://picsum.photos/800/800?random={$seed}";
            $response = Http::timeout(15)->get($placeholderUrl);
            if ($response->successful() && $response->header('Content-Type') && strpos($response->header('Content-Type'), 'image') !== false) {
                File::put($imagePath, $response->body());
                $this->command->info("Downloaded image: {$imageName}");
                return $imageName;
            }
        } catch (\Exception $e) {
            $this->command->warn("Failed to download from Picsum: " . $e->getMessage());
        }

        // Try Unsplash Source API as fallback
        try {
            $unsplashUrl = "https://source.unsplash.com/800x800/?{$keyword}";
            $response = Http::timeout(15)->get($unsplashUrl, [
                'allow_redirects' => true,
            ]);
            if ($response->successful()) {
                File::put($imagePath, $response->body());
                $this->command->info("Downloaded image from Unsplash: {$imageName}");
                return $imageName;
            }
        } catch (\Exception $e) {
            $this->command->warn("Failed to download from Unsplash: " . $e->getMessage());
        }

        // Final fallback: Copy existing image if available
        $existingImages = ['Cinema-camera.png', 'Cinema-camera1.png', 'Cinema-camera2.png'];
        if (File::exists($uploadPath . '/' . $existingImages[0])) {
            $ext = pathinfo($existingImages[0], PATHINFO_EXTENSION);
            $newImageName = "product-{$productCounter}-{$imageIndex}.{$ext}";
            File::copy($uploadPath . '/' . $existingImages[0], $uploadPath . '/' . $newImageName);
            return $newImageName;
        }

        // If all fails, return a default name
        return $imageName;
    }
}
