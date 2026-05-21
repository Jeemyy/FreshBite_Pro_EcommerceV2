<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Admin::firstOrCreate(
            ['email' => 'super@admin.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $superAdminRole = Role::where('slug', 'super-admin')->first();
        if ($superAdminRole) {
            $superAdmin->roles()->syncWithoutDetaching([$superAdminRole->id]);
        }

        $productManager = Admin::firstOrCreate(
            ['email' => 'product@admin.com'],
            [
                'name' => 'Product Manager',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $productManagerRole = Role::where('slug', 'product-manager')->first();
        if ($productManagerRole) {
            $productManager->roles()->syncWithoutDetaching([$productManagerRole->id]);
        }

        $orderManager = Admin::firstOrCreate(
            ['email' => 'orders@admin.com'],
            [
                'name' => 'Order Manager',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $orderManagerRole = Role::where('slug', 'order-manager')->first();
        if ($orderManagerRole) {
            $orderManager->roles()->syncWithoutDetaching([$orderManagerRole->id]);
        }

        $paymentManager = Admin::firstOrCreate(
            ['email' => 'payment@admin.com'],
            [
                'name' => 'Payment Manager',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $paymentManagerRole = Role::where('slug', 'payment-manager')->first();
        if ($paymentManagerRole) {
            $paymentManager->roles()->syncWithoutDetaching([$paymentManagerRole->id]);
        }

        $deliveryManager = Admin::firstOrCreate(
            ['email' => 'delivery@admin.com'],
            [
                'name' => 'Delivery Manager',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $deliveryManagerRole = Role::where('slug', 'delivery-manager')->first();
        if ($deliveryManagerRole) {
            $deliveryManager->roles()->syncWithoutDetaching([$deliveryManagerRole->id]);
        }

        $deliveryEmployee = Admin::firstOrCreate(
            ['email' => 'deliveryemp@admin.com'],
            [
                'name' => 'Delivery Employee',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $deliveryEmployeeRole = Role::where('slug', 'delivery-employee')->first();
        if ($deliveryEmployeeRole) {
            $deliveryEmployee->roles()->syncWithoutDetaching([$deliveryEmployeeRole->id]);
        }

        $customerSupport = Admin::firstOrCreate(
            ['email' => 'support@admin.com'],
            [
                'name' => 'Customer Support',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $customerSupportRole = Role::where('slug', 'customer-support')->first();
        if ($customerSupportRole) {
            $customerSupport->roles()->syncWithoutDetaching([$customerSupportRole->id]);
        }
    }
}
