<?php
// namespace site;

use Illuminate\Database\Seeder;
// use site\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		// Comment::unguard();
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');		
		DB::table('comments')->truncate();
		DB::table('posts')->truncate();
		DB::table('users')->truncate();
        $this->call(BlogSeeder::class);
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		// Comment::guard();
    }
}
