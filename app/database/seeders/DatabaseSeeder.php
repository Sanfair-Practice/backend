<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Section;
use App\Models\Tag;
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

        /** @var Collection<User> $users */
        $users = User::factory(10)->create();
        /** @var Collection<Category> $categories */
        $categories = Category::factory(5)->create();
        /** @var Collection<Tag> $tags */
        $tags = Tag::factory(150)->create();

        /** @var Collection<Question> $questions */
        $questions = Question::factory(1500)
            ->afterMaking(function (Question $question) use ($categories) {
                $question->category()->associate($categories->random());
            })
            ->afterCreating(function (Question $question) use ($tags) {
                $question->tags()->attach($tags->random(random_int(0, 10)));
            })
            ->create();

        foreach ($questions->split(25) as $chunk) {
            Section::factory()
                ->afterCreating(function (Section $section) use ($chunk) {
                    $section->questions()->attach($chunk);
                })
                ->create();
        }
        $sections = Section::all();

        foreach ($sections->split(7) as $chunk) {
            Chapter::factory()
                ->afterCreating(function (Chapter $chapter) use ($chunk) {
                    $chapter->sections()->attach($chunk);
                })
                ->create();
        }

        foreach ($users as $user) {
            Variant::factory(10)
                ->afterMaking(function (Variant $variant) use ($user) {
                    $variant->user()->associate($user);
                })
                ->afterCreating(function (Variant $variant) use ($questions) {
                    $variant->questions()->attach($questions->random(10));
                })
                ->create();
        }
    }
}
