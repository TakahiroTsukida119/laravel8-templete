<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\BranchUser;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\User;
use App\Models\Role;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;

/**
 * ユーザー
 * Class UserTableSeeder
 * @package Database\Seeders
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $baseAt = CarbonImmutable::create(2022, 3);
        $deletedAt = $baseAt->addDays(28);
        $password = Hash::make('password');
        $data = LazyCollection::range(1, 30)->map(fn (int $index) => [
            'id' => Str::orderedUuid(),
            'name' => "ユーザー{$index}",
            'email' => "user{$index}@example.com",
            'password' => $password,
            'created_at' => $baseAt,
            'updated_at' => $baseAt,
            'deleted_at' => $index % 5 ? null : $deletedAt,
        ])->all();
        User::insert($data);
    }
}
