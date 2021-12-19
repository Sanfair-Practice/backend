<?php

namespace App\Http\Controllers\Api;

use App\Enums\Test\Type;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTrainingRequest;
use App\Http\Resources\TestResource;
use App\Models\Chapter;
use App\Models\Section;
use App\Models\Test;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Str;

class TrainingController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:view,user');
        $model = Test::class;
        $this->middleware("can:create,${model},user")->only('store');
    }

    public function index(User $user): ResourceCollection
    {
        return TestResource::collection($user->trainings);
    }

    public function store(CreateTrainingRequest $request, User $user): TestResource
    {
        $chapters = $request->chapters !== null ?
            Chapter::findMany($request->chapters) : new Collection();
        $chapters->load('sections');

        $sections = $chapters->isNotEmpty() ?
            new Collection($chapters->flatMap->sections) : Section::findMany($request->sections);
        $sections->loadCount('questions');

        $test = Test::make();
        $test->user()->associate($user);
        $test->errors = -1;
        $test->quantity = $sections->sum->questions_count;
        $test->time = $test->quantity * 15;
        $test->type = Type::TRAINING;
        $test->save();

        $test->sections()->attach(new Collection($sections->all()));
        $test->chapters()->attach(new Collection($chapters->all()));

        $variant = Variant::make();
        $variant->test()->associate($test);
        $variant->errors = -1;
        $variant->seed = Str::uuid();
        $variant->time = $test->time;
        $variant->save();
        $variant->questions()->attach($test->questions);
        $test->variants()->attach(new Collection([$variant]));

        $test->load('chapters', 'sections', 'variants');
        return new TestResource($test);
    }

    public function show(User $user, Test $training): TestResource
    {
        $training->load('chapters', 'sections', 'variants');
        return TestResource::make($training);
    }
}
