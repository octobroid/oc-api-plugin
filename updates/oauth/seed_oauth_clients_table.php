<?php namespace Octobro\API\Updates;

use DB;
use October\Rain\Database\Updates\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->insert([
            'id' => $this->generateRandomString(15, true),
            'secret' => $this->generateRandomString(32),
            'name' => 'My App'
        ]);
    }

    protected function generateRandomString($length = 10, $isNumber = false) {
        $characters = $isNumber ? '012345667890' : '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
?>