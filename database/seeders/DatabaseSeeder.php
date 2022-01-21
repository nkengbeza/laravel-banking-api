<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\BankAccount;
use App\Models\BankBranch;
use App\Models\Customer;
use App\Models\User;
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
        $this->seedUsers();
        $this->seedBanks();
        $this->seedBankBranches();
        $this->seedCustomers();
        $this->seedBankAccounts();
    }

    private function seedUsers()
    {
        if (User::count() == 0) {
            User::factory()->count(10)->create();
        }
    }

    private function seedBanks() {
        if (Bank::count() == 0) {
            Bank::factory()->count(1)->create();
        }
    }

    private function seedBankBranches() {
        if (BankBranch::count() == 0) {
            BankBranch::factory()->count(1)->create();
        }
    }

    private function seedCustomers() {
        if (Customer::count() == 0) {
            Customer::factory()->count(50)->create();
        }
    }

    private function seedBankAccounts() {
        if (BankAccount::count() == 0) {
            BankAccount::factory()->count(2)->create();
        }
    }
}
