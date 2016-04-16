<?php
// namespace site;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use site\User;
use site\Post;
use site\Comment;

class BlogSeeder extends Seeder {

public function run()
{
	$numberOfAdmin=1;
	$numberOfAuthor=5;
	$numberOfSubscriber=10;
	$numberOfUser=(int)($numberOfAdmin+$numberOfAuthor+$numberOfSubscriber);
	$maxNumOfPost=15;
	$maxNumOfComment=20;
	$faker = \Faker\Factory::create();
	for ($i=1;$i<=($numberOfAdmin+$numberOfAuthor+$numberOfSubscriber);$i++) {
		$fakerDateTime = $faker->dateTimeThisDecade();
		User::create([
            'name' => (string)$i,//$faker->name;
            'email' => (string)$i. '@net.com',//$faker->unique()->email;
            'password' => bcrypt('111111'),
			'role' => ($i<=$numberOfAdmin ? 'admin' : ($i<=$numberOfAdmin+$numberOfAuthor ? 'author' : 'subscriber')),
			'created_at' => $fakerDateTime,
			'updated_at' => $fakerDateTime
		]); 
	}
	foreach (User::all()->where('role','author') as $user) {
		$numberOfPost = $faker->numberBetween(0,$maxNumOfPost);
		 for ($i=1;$i<=$numberOfPost;$i++) {
			$fakerTitle = $faker->sentence(10,true);
			$fakerDateTime = $faker->dateTimeBetween($user->created_at,'now');
			$post = new Post;
			$post->user_id = $user->id;
			$post->title = $fakerTitle;
			$post->body = $faker->paragraphs(8,true);
			$post->slug = str_slug($fakerTitle);
			$post->active = true;
			$post->created_at = $fakerDateTime;
			$post->updated_at = $fakerDateTime;
			$user->posts()->save($post);
		 }
	}
	foreach (Post::all() as $post) {
			$numberOfComment = $faker->numberBetween(0,$maxNumOfComment);
			for ($j=1;$j<=$numberOfComment;$j++) {
				$userId = $faker->numberBetween(1,$numberOfUser);
				// $user = User::find($userId);
				$fakerDateTime = $faker->dateTimeBetween($post->created_at,'now');
				$comment = new Comment;
				$comment->body = $faker->sentences(8,true);
				$comment->created_at = $fakerDateTime;
				$comment->updated_at = $fakerDateTime;
				$comment->post_id = $post->id;
				$comment->user_id = $userId;
				$comment->save();
				// $user->comments()->save($comment);
				// $post->comments()->save($comment);
			}
	}
/* 	$populator = new Faker\ORM\Propel\Populator($generator);
	$populator->addEntity('site\User', $numberOfAdmin, array('role' => 'admin'));
	$populator->addEntity('site\User', $numberOfAuthor, array('role' => 'author'));
	$populator->addEntity('site\User', $numberOfSubscriber, array('role' => 'subscriber'));
	$populator->addEntity('site\Post', $maxNumOfPost);
	$populator->addEntity('site\Comment', $maxNumOfComment);
	$insertedPKs = $populator->execute();
 */
}

}