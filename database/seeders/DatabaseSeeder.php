<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // eventmie pro tables
        $this->call(BannersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(TaxesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(TicketsTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(PostsTableSeeder::class);

        // voyager tables
        $this->call(DataTypesTableSeeder::class);
        $this->call(DataRowsTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(MenuItemsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PermissionRoleTableSeeder::class);
        $this->call(TranslationsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
    }
}
