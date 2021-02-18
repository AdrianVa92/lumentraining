<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\Models\User::class, 10)->create();

        try {
            DB::beginTransaction();

            $faker = Faker::create();

            $admin_user_id = $faker->uuid;

            DB::table('users')->insert([
                'name' => 'Adrian Valbuena',
                'email' => 'adrianva@cloudstaff.com',
                'password' => Hash::make('@adrian'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
