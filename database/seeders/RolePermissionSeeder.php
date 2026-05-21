<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // Products
            ['name' => 'View Products', 'slug' => 'view-products', 'group' => 'Products'],
            ['name' => 'Create Products', 'slug' => 'create-products', 'group' => 'Products'],
            ['name' => 'Edit Products', 'slug' => 'edit-products', 'group' => 'Products'],
            ['name' => 'Delete Products', 'slug' => 'delete-products', 'group' => 'Products'],

            // Categories
            ['name' => 'View Categories', 'slug' => 'view-categories', 'group' => 'Categories'],
            ['name' => 'Create Categories', 'slug' => 'create-categories', 'group' => 'Categories'],
            ['name' => 'Edit Categories', 'slug' => 'edit-categories', 'group' => 'Categories'],
            ['name' => 'Delete Categories', 'slug' => 'delete-categories', 'group' => 'Categories'],

            // Orders
            ['name' => 'View Orders', 'slug' => 'view-orders', 'group' => 'Orders'],
            ['name' => 'Create Orders', 'slug' => 'create-orders', 'group' => 'Orders'],
            ['name' => 'Edit Orders', 'slug' => 'edit-orders', 'group' => 'Orders'],
            ['name' => 'Delete Orders', 'slug' => 'delete-orders', 'group' => 'Orders'],
            ['name' => 'Update Order Status', 'slug' => 'update-order-status', 'group' => 'Orders'],

            // Payments
            ['name' => 'View Payments', 'slug' => 'view-payments', 'group' => 'Payments'],
            ['name' => 'Approve Payments', 'slug' => 'approve-payments', 'group' => 'Payments'],
            ['name' => 'Refund Payments', 'slug' => 'refund-payments', 'group' => 'Payments'],
            ['name' => 'View Transaction Reports', 'slug' => 'view-transaction-reports', 'group' => 'Payments'],

            // Deliveries
            ['name' => 'View Deliveries', 'slug' => 'view-deliveries', 'group' => 'Deliveries'],
            ['name' => 'Assign Deliveries', 'slug' => 'assign-deliveries', 'group' => 'Deliveries'],
            ['name' => 'Update Delivery Status', 'slug' => 'update-delivery-status', 'group' => 'Deliveries'],

            // Roles & Admins
            ['name' => 'View Roles', 'slug' => 'view-roles', 'group' => 'Roles'],
            ['name' => 'Create Roles', 'slug' => 'create-roles', 'group' => 'Roles'],
            ['name' => 'Edit Roles', 'slug' => 'edit-roles', 'group' => 'Roles'],
            ['name' => 'Delete Roles', 'slug' => 'delete-roles', 'group' => 'Roles'],
            ['name' => 'Manage Admins', 'slug' => 'manage-admins', 'group' => 'Admins'],

            // Settings
            ['name' => 'View Settings', 'slug' => 'view-settings', 'group' => 'Settings'],
            ['name' => 'Edit Settings', 'slug' => 'edit-settings', 'group' => 'Settings'],

            // Reports
            ['name' => 'View Reports', 'slug' => 'view-reports', 'group' => 'Reports'],

            // Invoices
            ['name' => 'View Invoices', 'slug' => 'view-invoices', 'group' => 'Invoices'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(
                ['slug' => $perm['slug']],
                $perm
            );
        }

        $roles = [
            'super-admin' => [
                'name' => 'Super Admin',
                'description' => 'Full access to all system features',
                'permissions' => Permission::pluck('slug')->toArray(),
            ],
            'product-manager' => [
                'name' => 'Product Manager',
                'description' => 'Manages products and categories',
                'permissions' => [
                    'view-products', 'create-products', 'edit-products', 'delete-products',
                    'view-categories', 'create-categories', 'edit-categories', 'delete-categories',
                    'view-orders', 'view-invoices',
                ],
            ],
            'order-manager' => [
                'name' => 'Order Manager',
                'description' => 'Manages customer orders',
                'permissions' => [
                    'view-orders', 'create-orders', 'edit-orders', 'delete-orders', 'update-order-status',
                    'view-products', 'view-categories',
                    'view-invoices',
                ],
            ],
            'payment-manager' => [
                'name' => 'Payment Manager',
                'description' => 'Manages payment operations and transactions',
                'permissions' => [
                    'view-payments', 'approve-payments', 'refund-payments', 'view-transaction-reports',
                    'view-orders', 'view-invoices',
                ],
            ],
            'delivery-manager' => [
                'name' => 'Delivery Manager',
                'description' => 'Manages delivery operations and assigns employees',
                'permissions' => [
                    'view-deliveries', 'assign-deliveries', 'update-delivery-status',
                    'view-orders', 'view-invoices',
                ],
            ],
            'delivery-employee' => [
                'name' => 'Delivery Employee',
                'description' => 'Handles assigned deliveries and updates status',
                'permissions' => [
                    'view-deliveries', 'update-delivery-status',
                ],
            ],
            'customer-support' => [
                'name' => 'Customer Support',
                'description' => 'Views orders and helps customers',
                'permissions' => [
                    'view-orders', 'view-products', 'view-categories',
                    'view-payments', 'view-invoices',
                ],
            ],
        ];

        foreach ($roles as $slug => $data) {
            $role = Role::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'guard_name' => 'admin',
                ]
            );

            $permSlugs = $data['permissions'];
            $permIds = Permission::whereIn('slug', $permSlugs)->pluck('id');
            $role->permissions()->sync($permIds);
        }
    }
}
