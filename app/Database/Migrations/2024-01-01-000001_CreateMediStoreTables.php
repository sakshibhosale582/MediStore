<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMediStoreTables extends Migration
{
    public function up()
    {
        // Users
        $this->forge->addField([
            'id'                 => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name'               => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'              => ['type' => 'VARCHAR', 'constraint' => 150],
            'password'           => ['type' => 'VARCHAR', 'constraint' => 255],
            'phone'              => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'role'               => ['type' => 'ENUM', 'constraint' => ['customer', 'pharmacist', 'admin'], 'default' => 'customer'],
            'avatar'             => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'email_verified'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'verification_token' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'reset_token'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'reset_expires'      => ['type' => 'DATETIME', 'null' => true],
            'remember_token'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'is_active'          => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
            'updated_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->addKey('role');
        $this->forge->createTable('users', true);

        // Addresses
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'      => ['type' => 'INT', 'unsigned' => true],
            'label'        => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'Home'],
            'name'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'phone'        => ['type' => 'VARCHAR', 'constraint' => 20],
            'address_line' => ['type' => 'TEXT'],
            'city'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'state'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'pincode'      => ['type' => 'VARCHAR', 'constraint' => 10],
            'is_default'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('addresses', true);

        // Categories
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 120],
            'description' => ['type' => 'TEXT', 'null' => true],
            'image'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('categories', true);

        // Brands
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 120],
            'description' => ['type' => 'TEXT', 'null' => true],
            'status'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('brands', true);

        // Manufacturers
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'description' => ['type' => 'TEXT', 'null' => true],
            'status'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('manufacturers', true);

        // Medicines
        $this->forge->addField([
            'id'                    => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'category_id'           => ['type' => 'INT', 'unsigned' => true],
            'brand_id'              => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'manufacturer_id'       => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'name'                  => ['type' => 'VARCHAR', 'constraint' => 200],
            'generic_name'          => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'slug'                  => ['type' => 'VARCHAR', 'constraint' => 220],
            'price'                 => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'discount_price'        => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'stock'                 => ['type' => 'INT', 'default' => 0],
            'description'           => ['type' => 'TEXT', 'null' => true],
            'usage_info'            => ['type' => 'TEXT', 'null' => true],
            'side_effects'          => ['type' => 'TEXT', 'null' => true],
            'storage_instructions'  => ['type' => 'TEXT', 'null' => true],
            'prescription_required' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'image'                 => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'expiry_date'           => ['type' => 'DATE', 'null' => true],
            'status'                => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'            => ['type' => 'DATETIME', 'null' => true],
            'updated_at'            => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey('category_id');
        $this->forge->addKey('name');
        $this->forge->addKey('generic_name');
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('brand_id', 'brands', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('manufacturer_id', 'manufacturers', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('medicines', true);

        // Coupons
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'code'       => ['type' => 'VARCHAR', 'constraint' => 50],
            'type'       => ['type' => 'ENUM', 'constraint' => ['percent', 'fixed'], 'default' => 'percent'],
            'value'      => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'min_order'  => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0],
            'max_uses'   => ['type' => 'INT', 'null' => true],
            'used_count' => ['type' => 'INT', 'default' => 0],
            'starts_at'  => ['type' => 'DATETIME', 'null' => true],
            'expires_at' => ['type' => 'DATETIME', 'null' => true],
            'status'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('code');
        $this->forge->createTable('coupons', true);

        // Prescriptions
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'       => ['type' => 'INT', 'unsigned' => true],
            'file'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'file_type'     => ['type' => 'VARCHAR', 'constraint' => 10],
            'notes'         => ['type' => 'TEXT', 'null' => true],
            'status'        => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected'], 'default' => 'pending'],
            'pharmacist_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'review_notes'  => ['type' => 'TEXT', 'null' => true],
            'reviewed_at'   => ['type' => 'DATETIME', 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addKey('status');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('pharmacist_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('prescriptions', true);

        // Wishlists
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'     => ['type' => 'INT', 'unsigned' => true],
            'medicine_id' => ['type' => 'INT', 'unsigned' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['user_id', 'medicine_id']);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('medicine_id', 'medicines', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('wishlists', true);

        // Orders
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'order_number'    => ['type' => 'VARCHAR', 'constraint' => 30],
            'user_id'         => ['type' => 'INT', 'unsigned' => true],
            'address_id'      => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'shipping_name'   => ['type' => 'VARCHAR', 'constraint' => 100],
            'shipping_phone'  => ['type' => 'VARCHAR', 'constraint' => 20],
            'shipping_address'=> ['type' => 'TEXT'],
            'subtotal'        => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'tax'             => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0],
            'delivery_charge' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0],
            'discount'        => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0],
            'coupon_id'       => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'grand_total'     => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'payment_method'  => ['type' => 'ENUM', 'constraint' => ['cod', 'online'], 'default' => 'cod'],
            'payment_status'  => ['type' => 'ENUM', 'constraint' => ['pending', 'paid', 'failed', 'refunded'], 'default' => 'pending'],
            'order_status'    => ['type' => 'ENUM', 'constraint' => ['placed', 'prescription_verified', 'payment_confirmed', 'packed', 'shipped', 'out_for_delivery', 'delivered', 'cancelled', 'return_requested'], 'default' => 'placed'],
            'notes'           => ['type' => 'TEXT', 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('order_number');
        $this->forge->addKey('user_id');
        $this->forge->addKey('order_status');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('coupon_id', 'coupons', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('orders', true);

        // Order Items
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'order_id'    => ['type' => 'INT', 'unsigned' => true],
            'medicine_id' => ['type' => 'INT', 'unsigned' => true],
            'medicine_name'=> ['type' => 'VARCHAR', 'constraint' => 200],
            'quantity'    => ['type' => 'INT'],
            'price'       => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'total'       => ['type' => 'DECIMAL', 'constraint' => '10,2'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('order_id');
        $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('medicine_id', 'medicines', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('order_items', true);

        // Order Tracking
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'order_id'   => ['type' => 'INT', 'unsigned' => true],
            'status'     => ['type' => 'VARCHAR', 'constraint' => 50],
            'notes'      => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('order_id');
        $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('order_tracking', true);

        // Reviews
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'     => ['type' => 'INT', 'unsigned' => true],
            'medicine_id' => ['type' => 'INT', 'unsigned' => true],
            'order_id'    => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'rating'      => ['type' => 'TINYINT', 'constraint' => 1],
            'comment'     => ['type' => 'TEXT', 'null' => true],
            'status'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('medicine_id', 'medicines', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('reviews', true);

        // Notifications
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'    => ['type' => 'INT', 'unsigned' => true],
            'title'      => ['type' => 'VARCHAR', 'constraint' => 200],
            'message'    => ['type' => 'TEXT'],
            'type'       => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'info'],
            'link'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'is_read'    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('user_id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('notifications', true);

        // Medicine Reminders
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'       => ['type' => 'INT', 'unsigned' => true],
            'medicine_id'   => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'medicine_name' => ['type' => 'VARCHAR', 'constraint' => 200],
            'dosage'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'reminder_time' => ['type' => 'TIME'],
            'frequency'     => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'daily'],
            'is_active'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('medicine_reminders', true);

        // FAQs
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'question'   => ['type' => 'TEXT'],
            'answer'     => ['type' => 'TEXT'],
            'sort_order' => ['type' => 'INT', 'default' => 0],
            'status'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('faqs', true);

        // Contact Queries
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'     => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'       => ['type' => 'VARCHAR', 'constraint' => 150],
            'subject'     => ['type' => 'VARCHAR', 'constraint' => 200],
            'message'     => ['type' => 'TEXT'],
            'status'      => ['type' => 'ENUM', 'constraint' => ['open', 'replied', 'closed'], 'default' => 'open'],
            'admin_reply' => ['type' => 'TEXT', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('contact_queries', true);

        // Banners
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'title'      => ['type' => 'VARCHAR', 'constraint' => 200],
            'subtitle'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'image'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'link'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'sort_order' => ['type' => 'INT', 'default' => 0],
            'status'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('banners', true);

        // Offers
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'title'             => ['type' => 'VARCHAR', 'constraint' => 200],
            'description'       => ['type' => 'TEXT', 'null' => true],
            'image'             => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'discount_percent'  => ['type' => 'DECIMAL', 'constraint' => '5,2', 'null' => true],
            'starts_at'         => ['type' => 'DATETIME', 'null' => true],
            'expires_at'        => ['type' => 'DATETIME', 'null' => true],
            'status'            => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('offers', true);

        // Return Requests
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'order_id'      => ['type' => 'INT', 'unsigned' => true],
            'user_id'       => ['type' => 'INT', 'unsigned' => true],
            'reason'        => ['type' => 'TEXT'],
            'status'        => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected'], 'default' => 'pending'],
            'refund_status' => ['type' => 'ENUM', 'constraint' => ['none', 'pending', 'processed'], 'default' => 'none'],
            'admin_notes'   => ['type' => 'TEXT', 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('return_requests', true);
    }

    public function down()
    {
        $tables = [
            'return_requests', 'offers', 'banners', 'contact_queries', 'faqs',
            'medicine_reminders', 'notifications', 'reviews', 'order_tracking',
            'order_items', 'orders', 'wishlists', 'prescriptions', 'coupons',
            'medicines', 'manufacturers', 'brands', 'categories', 'addresses', 'users',
        ];
        foreach ($tables as $table) {
            $this->forge->dropTable($table, true);
        }
    }
}
