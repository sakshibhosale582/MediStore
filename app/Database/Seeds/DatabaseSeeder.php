<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory as FakerFactory;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $faker = FakerFactory::create('en_IN');
        $now   = date('Y-m-d H:i:s');

        helper('url');

        $this->truncateTables();

        // Users
        $users = [
            [
                'name'           => 'MediStore Admin',
                'email'          => 'admin@medistore.com',
                'password'       => password_hash('Admin@123', PASSWORD_DEFAULT),
                'phone'          => '9876543210',
                'role'           => 'admin',
                'email_verified' => 1,
                'is_active'      => 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'name'           => 'Rajesh Kumar',
                'email'          => 'pharmacist@medistore.com',
                'password'       => password_hash('Pharma@123', PASSWORD_DEFAULT),
                'phone'          => '9876543211',
                'role'           => 'pharmacist',
                'email_verified' => 1,
                'is_active'      => 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'name'           => 'Priya Sharma',
                'email'          => 'customer@medistore.com',
                'password'       => password_hash('Customer@123', PASSWORD_DEFAULT),
                'phone'          => '9876543212',
                'role'           => 'customer',
                'email_verified' => 1,
                'is_active'      => 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
        ];
        $this->db->table('users')->insertBatch($users);

        // Categories
        $categoryNames = [
            'Pain Relief',
            'Antibiotics',
            'Vitamins',
            'Diabetes',
            'Skin Care',
            'Heart Care',
        ];
        $categories = [];
        foreach ($categoryNames as $name) {
            $categories[] = [
                'name'        => $name,
                'slug'        => url_title($name, '-', true),
                'description' => $faker->sentence(12),
                'status'      => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }
        $this->db->table('categories')->insertBatch($categories);

        $categoryIds = array_column(
            $this->db->table('categories')->select('id, slug')->get()->getResultArray(),
            'id',
            'slug'
        );

        // Brands
        $brandNames = ['Cipla', 'Sun Pharma', 'Dr. Reddy\'s', 'Abbott', 'Himalaya'];
        $brands     = [];
        foreach ($brandNames as $name) {
            $brands[] = [
                'name'        => $name,
                'slug'        => url_title($name, '-', true),
                'description' => $faker->sentence(10),
                'status'      => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }
        $this->db->table('brands')->insertBatch($brands);

        $brandIds = array_column(
            $this->db->table('brands')->select('id, slug')->get()->getResultArray(),
            'id',
            'slug'
        );

        // Manufacturers
        $manufacturerNames = [
            'Cipla Ltd.',
            'Sun Pharmaceutical Industries Ltd.',
            'Dr. Reddy\'s Laboratories Ltd.',
            'Abbott Healthcare Pvt. Ltd.',
            'Torrent Pharmaceuticals Ltd.',
            'Himalaya Drug Company',
        ];
        $manufacturers = [];
        foreach ($manufacturerNames as $name) {
            $manufacturers[] = [
                'name'        => $name,
                'slug'        => url_title($name, '-', true),
                'description' => $faker->sentence(10),
                'status'      => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ];
        }
        $this->db->table('manufacturers')->insertBatch($manufacturers);

        $manufacturerIds = array_column(
            $this->db->table('manufacturers')->select('id, slug')->get()->getResultArray(),
            'id',
            'slug'
        );

        // Medicines
        $medicines = [
            ['name' => 'Crocin Advance 500mg', 'generic_name' => 'Paracetamol', 'category' => 'pain-relief', 'brand' => 'cipla', 'manufacturer' => 'cipla-ltd', 'price' => 35.00, 'discount_price' => 32.00, 'stock' => 250, 'prescription_required' => 0],
            ['name' => 'Dolo 650mg Tablet', 'generic_name' => 'Paracetamol', 'category' => 'pain-relief', 'brand' => 'micro-labs', 'manufacturer' => 'torrent-pharmaceuticals-ltd', 'price' => 30.00, 'discount_price' => 28.00, 'stock' => 300, 'prescription_required' => 0],
            ['name' => 'Combiflam Tablet', 'generic_name' => 'Ibuprofen + Paracetamol', 'category' => 'pain-relief', 'brand' => 'sanofi', 'manufacturer' => 'sanofi-india-ltd', 'price' => 45.00, 'discount_price' => 42.00, 'stock' => 180, 'prescription_required' => 0],
            ['name' => 'Voveran SR 100', 'generic_name' => 'Diclofenac Sodium', 'category' => 'pain-relief', 'brand' => 'novartis', 'manufacturer' => 'novartis-india-ltd', 'price' => 120.00, 'discount_price' => 110.00, 'stock' => 90, 'prescription_required' => 1],
            ['name' => 'Azithromycin 500mg', 'generic_name' => 'Azithromycin', 'category' => 'antibiotics', 'brand' => 'cipla', 'manufacturer' => 'cipla-ltd', 'price' => 85.00, 'discount_price' => 78.00, 'stock' => 120, 'prescription_required' => 1],
            ['name' => 'Amoxyclav 625', 'generic_name' => 'Amoxicillin + Clavulanic Acid', 'category' => 'antibiotics', 'brand' => 'abbott', 'manufacturer' => 'abbott-healthcare-pvt-ltd', 'price' => 195.00, 'discount_price' => 185.00, 'stock' => 75, 'prescription_required' => 1],
            ['name' => 'Ciplox 500mg', 'generic_name' => 'Ciprofloxacin', 'category' => 'antibiotics', 'brand' => 'cipla', 'manufacturer' => 'cipla-ltd', 'price' => 65.00, 'discount_price' => 60.00, 'stock' => 100, 'prescription_required' => 1],
            ['name' => 'Revital H Capsule', 'generic_name' => 'Multivitamin + Minerals', 'category' => 'vitamins', 'brand' => 'sun-pharma', 'manufacturer' => 'sun-pharmaceutical-industries-ltd', 'price' => 310.00, 'discount_price' => 295.00, 'stock' => 150, 'prescription_required' => 0],
            ['name' => 'Vitamin D3 60K', 'generic_name' => 'Cholecalciferol', 'category' => 'vitamins', 'brand' => 'sun-pharma', 'manufacturer' => 'sun-pharmaceutical-industries-ltd', 'price' => 95.00, 'discount_price' => 88.00, 'stock' => 200, 'prescription_required' => 0],
            ['name' => 'Zincovit Syrup 200ml', 'generic_name' => 'Multivitamin + Zinc', 'category' => 'vitamins', 'brand' => 'apex', 'manufacturer' => 'apex-laboratories-pvt-ltd', 'price' => 145.00, 'discount_price' => 135.00, 'stock' => 80, 'prescription_required' => 0],
            ['name' => 'Glycomet 500 SR', 'generic_name' => 'Metformin Hydrochloride', 'category' => 'diabetes', 'brand' => 'usv', 'manufacturer' => 'usv-private-limited', 'price' => 55.00, 'discount_price' => 50.00, 'stock' => 220, 'prescription_required' => 1],
            ['name' => 'Amaryl 2mg', 'generic_name' => 'Glimepiride', 'category' => 'diabetes', 'brand' => 'sanofi', 'manufacturer' => 'sanofi-india-ltd', 'price' => 125.00, 'discount_price' => 118.00, 'stock' => 110, 'prescription_required' => 1],
            ['name' => 'Janumet 50/500', 'generic_name' => 'Sitagliptin + Metformin', 'category' => 'diabetes', 'brand' => 'msd', 'manufacturer' => 'msd-pharmaceuticals-pvt-ltd', 'price' => 420.00, 'discount_price' => 399.00, 'stock' => 60, 'prescription_required' => 1],
            ['name' => 'Betnovate-C Cream 20g', 'generic_name' => 'Betamethasone + Clioquinol', 'category' => 'skin-care', 'brand' => 'glaxosmithkline', 'manufacturer' => 'glaxosmithkline-pharmaceuticals-ltd', 'price' => 78.00, 'discount_price' => 72.00, 'stock' => 95, 'prescription_required' => 1],
            ['name' => 'Cetaphil Moisturizing Lotion 250ml', 'generic_name' => 'Emollient Lotion', 'category' => 'skin-care', 'brand' => 'galderma', 'manufacturer' => 'galderma-india-pvt-ltd', 'price' => 650.00, 'discount_price' => 599.00, 'stock' => 70, 'prescription_required' => 0],
            ['name' => 'Acne-Aid Soap 75g', 'generic_name' => 'Sulfur + Resorcinol', 'category' => 'skin-care', 'brand' => 'himalaya', 'manufacturer' => 'himalaya-drug-company', 'price' => 95.00, 'discount_price' => 89.00, 'stock' => 140, 'prescription_required' => 0],
            ['name' => 'Atorva 10mg', 'generic_name' => 'Atorvastatin', 'category' => 'heart-care', 'brand' => 'cipla', 'manufacturer' => 'cipla-ltd', 'price' => 98.00, 'discount_price' => 92.00, 'stock' => 130, 'prescription_required' => 1],
            ['name' => 'Amlong 5mg', 'generic_name' => 'Amlodipine', 'category' => 'heart-care', 'brand' => 'micro-labs', 'manufacturer' => 'micro-labs-ltd', 'price' => 45.00, 'discount_price' => 42.00, 'stock' => 160, 'prescription_required' => 1],
            ['name' => 'Ecosprin 75', 'generic_name' => 'Aspirin', 'category' => 'heart-care', 'brand' => 'usv', 'manufacturer' => 'usv-private-limited', 'price' => 38.00, 'discount_price' => 35.00, 'stock' => 280, 'prescription_required' => 0],
            ['name' => 'Telma 40', 'generic_name' => 'Telmisartan', 'category' => 'heart-care', 'brand' => 'glenmark', 'manufacturer' => 'glenmark-pharmaceuticals-ltd', 'price' => 165.00, 'discount_price' => 155.00, 'stock' => 85, 'prescription_required' => 1],
        ];

        $brandSlugMap = [
            'cipla'           => 'cipla',
            'sun-pharma'      => 'sun-pharma',
            'dr-reddys'       => 'dr-reddys',
            'abbott'          => 'abbott',
            'himalaya'        => 'himalaya',
            'micro-labs'      => 'cipla',
            'sanofi'          => 'abbott',
            'novartis'        => 'dr-reddys',
            'apex'            => 'sun-pharma',
            'usv'             => 'cipla',
            'msd'             => 'abbott',
            'glaxosmithkline' => 'dr-reddys',
            'galderma'        => 'abbott',
            'glenmark'        => 'sun-pharma',
        ];

        $manufacturerSlugMap = [
            'cipla-ltd'                              => 'cipla-ltd',
            'sun-pharmaceutical-industries-ltd'      => 'sun-pharmaceutical-industries-ltd',
            'dr-reddys-laboratories-ltd'             => 'dr-reddys-laboratories-ltd',
            'abbott-healthcare-pvt-ltd'              => 'abbott-healthcare-pvt-ltd',
            'torrent-pharmaceuticals-ltd'            => 'torrent-pharmaceuticals-ltd',
            'sanofi-india-ltd'                       => 'cipla-ltd',
            'novartis-india-ltd'                     => 'dr-reddys-laboratories-ltd',
            'apex-laboratories-pvt-ltd'              => 'sun-pharmaceutical-industries-ltd',
            'usv-private-limited'                    => 'cipla-ltd',
            'msd-pharmaceuticals-pvt-ltd'            => 'abbott-healthcare-pvt-ltd',
            'glaxosmithkline-pharmaceuticals-ltd'    => 'dr-reddys-laboratories-ltd',
            'galderma-india-pvt-ltd'                 => 'abbott-healthcare-pvt-ltd',
            'himalaya-drug-company'                  => 'himalaya-drug-company',
            'micro-labs-ltd'                         => 'torrent-pharmaceuticals-ltd',
            'glenmark-pharmaceuticals-ltd'           => 'sun-pharmaceutical-industries-ltd',
        ];

        $medicineRows = [];
        foreach ($medicines as $medicine) {
            $categorySlug     = $medicine['category'];
            $brandSlug        = $brandSlugMap[$medicine['brand']] ?? 'cipla';
            $manufacturerSlug = $manufacturerSlugMap[$medicine['manufacturer']] ?? 'cipla-ltd';

            $medicineRows[] = [
                'category_id'           => $categoryIds[$categorySlug],
                'brand_id'              => $brandIds[$brandSlug],
                'manufacturer_id'       => $manufacturerIds[$manufacturerSlug],
                'name'                  => $medicine['name'],
                'generic_name'          => $medicine['generic_name'],
                'slug'                  => url_title($medicine['name'], '-', true),
                'price'                 => $medicine['price'],
                'discount_price'        => $medicine['discount_price'],
                'stock'                 => $medicine['stock'],
                'description'           => $faker->paragraph(2),
                'usage_info'            => 'Take as directed by your physician. ' . $faker->sentence(8),
                'side_effects'          => 'May cause mild nausea or dizziness. ' . $faker->sentence(6),
                'storage_instructions'  => 'Store in a cool, dry place away from direct sunlight.',
                'prescription_required' => $medicine['prescription_required'],
                'expiry_date'           => date('Y-m-d', strtotime('+18 months')),
                'status'                => 1,
                'created_at'            => $now,
                'updated_at'            => $now,
            ];
        }
        $this->db->table('medicines')->insertBatch($medicineRows);

        // Coupons
        $coupons = [
            [
                'code'       => 'WELCOME10',
                'type'       => 'percent',
                'value'      => 10.00,
                'min_order'  => 299.00,
                'max_uses'   => 500,
                'used_count' => 0,
                'starts_at'  => $now,
                'expires_at' => date('Y-m-d H:i:s', strtotime('+6 months')),
                'status'     => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code'       => 'FLAT50',
                'type'       => 'fixed',
                'value'      => 50.00,
                'min_order'  => 499.00,
                'max_uses'   => 200,
                'used_count' => 0,
                'starts_at'  => $now,
                'expires_at' => date('Y-m-d H:i:s', strtotime('+3 months')),
                'status'     => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code'       => 'SAVE20',
                'type'       => 'percent',
                'value'      => 20.00,
                'min_order'  => 999.00,
                'max_uses'   => 100,
                'used_count' => 0,
                'starts_at'  => $now,
                'expires_at' => date('Y-m-d H:i:s', strtotime('+1 year')),
                'status'     => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
        $this->db->table('coupons')->insertBatch($coupons);

        // FAQs
        $faqs = [
            [
                'question'   => 'How do I upload a prescription?',
                'answer'     => 'Add prescription-required medicines to your cart, then upload a clear photo or PDF of your doctor\'s prescription at checkout. Our pharmacist will verify it before dispatch.',
                'sort_order' => 1,
                'status'     => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question'   => 'What are the delivery charges?',
                'answer'     => 'Orders above ₹499 qualify for free home delivery. A flat ₹49 delivery fee applies to smaller orders within city limits.',
                'sort_order' => 2,
                'status'     => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question'   => 'Can I return medicines after delivery?',
                'answer'     => 'Opened or temperature-sensitive medicines cannot be returned for safety reasons. Unopened OTC products may be returned within 7 days if the seal is intact.',
                'sort_order' => 3,
                'status'     => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question'   => 'Is cash on delivery available?',
                'answer'     => 'Yes, cash on delivery is available for most pin codes. Prescription orders may require online payment after pharmacist approval.',
                'sort_order' => 4,
                'status'     => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'question'   => 'How long does prescription verification take?',
                'answer'     => 'Our licensed pharmacists typically verify prescriptions within 2–4 business hours during store operating times.',
                'sort_order' => 5,
                'status'     => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
        $this->db->table('faqs')->insertBatch($faqs);

        // Banners
        $banners = [
            [
                'title'      => 'Up to 20% Off on Vitamins',
                'subtitle'   => 'Boost your immunity with trusted multivitamins',
                'image'      => 'banners/vitamins-offer.jpg',
                'link'       => '/medicines?category=vitamins',
                'sort_order' => 1,
                'status'     => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title'      => 'Free Delivery on Orders Above ₹499',
                'subtitle'   => 'Fast doorstep delivery across the city',
                'image'      => 'banners/free-delivery.jpg',
                'link'       => '/offers',
                'sort_order' => 2,
                'status'     => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
        $this->db->table('banners')->insertBatch($banners);

        // Offers
        $offers = [
            [
                'title'            => 'Monsoon Health Sale',
                'description'      => 'Save on immunity boosters, pain relief, and skin care essentials this monsoon season.',
                'image'            => 'offers/monsoon-sale.jpg',
                'discount_percent' => 15.00,
                'starts_at'        => $now,
                'expires_at'       => date('Y-m-d H:i:s', strtotime('+2 months')),
                'status'           => 1,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'title'            => 'Diabetes Care Bundle',
                'description'      => 'Special discounts on glucose monitors, test strips, and prescription diabetes medicines.',
                'image'            => 'offers/diabetes-care.jpg',
                'discount_percent' => 12.00,
                'starts_at'        => $now,
                'expires_at'       => date('Y-m-d H:i:s', strtotime('+4 months')),
                'status'           => 1,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
        ];
        $this->db->table('offers')->insertBatch($offers);
    }

    private function truncateTables(): void
    {
        $this->db->disableForeignKeyChecks();

        $tables = [
            'return_requests',
            'offers',
            'banners',
            'contact_queries',
            'faqs',
            'medicine_reminders',
            'notifications',
            'reviews',
            'order_tracking',
            'order_items',
            'orders',
            'wishlists',
            'prescriptions',
            'coupons',
            'medicines',
            'manufacturers',
            'brands',
            'categories',
            'addresses',
            'users',
        ];

        foreach ($tables as $table) {
            $this->db->table($table)->truncate();
        }

        $this->db->enableForeignKeyChecks();
    }
}
