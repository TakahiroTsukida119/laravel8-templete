<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\AdminRole;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;

/**
 * 管理ユーザー
 * Class AdminsTableSeeder
 * @package Database\Seeders
 */
class AdminsTableSeeder extends Seeder
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
            'name' => "管理ユーザー{$index}",
            'email' => "admin{$index}@example.com",
            'password' => $password,
            'created_at' => $baseAt,
            'updated_at' => $baseAt,
            'deleted_at' => $index % 5 ? null : $deletedAt,
        ])->all();
        Admin::insert($data);
    }
}
