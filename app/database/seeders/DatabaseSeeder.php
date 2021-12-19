<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Section;
use App\Models\Tag;
use App\Models\Test;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        Variant::truncate();
        Question::truncate();
        User::truncate();
        Tag::truncate();
        Category::truncate();
        Section::truncate();

        /** @var Collection<Chapter> $chapters */
        $chapters = Chapter::factory(7)->create();
        $chapters->each(static function (Chapter $chapter) {
            /** @var Collection<Section> $sections */
            $sections = Section::factory(9)->create();
            $chapter->sections()->attach($sections);
        });

        /** @var Collection<Category> $categories */
        $categories = Category::factory(5)->create();
        /** @var Collection<Tag> $tags */
        $tags = Tag::factory(150)->create();
        /** @var Collection<Section> $sections */
        $sections = Section::all();
        $sections->each(static function (Section $section) use ($categories, $tags) {
            /** @var Collection<Question> $questions */
            $questions = Question::factory(25)
                ->afterMaking(function (Question $question) use ($categories) {
                    $question->category()->associate($categories->random());
                })
                ->afterCreating(function (Question $question) use ($tags) {
                    $question->tags()->attach($tags->random(random_int(0, 10)));
                })
                ->create();
            $section->questions()->attach($questions);
        });

        /** @var Collection<User> $users */
        $users = User::factory(10)->create();
        $users->each(static function (User $user) use ($chapters) {
            Test::factory(5)
                ->afterMaking(function (Test $test) use ($user) {
                    $test->user()->associate($user);
                })
                ->afterCreating(function (Test $test) use ($chapters) {
                    $test->chapters()->attach($chapters->random(random_int(1, $chapters->count())));
                    $test->sections()->attach($test->chapters->flatMap->sections->map->id->all());
                })
                ->create();
        });

        /** @var Collection<Test> $tests */
        $tests = Test::all();
        $tests->each(static function (Test $test) {
            /** @var Collection<Variant> $variants */
            $variants = Variant::factory(random_int(1, 5))
                ->afterMaking(static function (Variant $variant) use ($test) {
                    $variant->test()->associate($test);
                })
               ->afterCreating(static function (Variant $variant) use ($test) {
                   $variant->questions()->attach($test->questions->random(10));
               })
               ->create();

            $test->variants()->attach($variants);
        });
    }
}
