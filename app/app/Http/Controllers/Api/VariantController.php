<?php

namespace App\Http\Controllers\Api;

use App\Enums;
use App\Http\Controllers\Controller;
use App\Http\Requests\AnswerRequest;
use App\Http\Resources\VariantResource;
use App\Models\Question;
use App\Models\Test;
use App\Models\User;
use App\Models\Variant;

class VariantController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view,user')->only('show');
        $variant = Variant::class;
        $this->middleware("can:view,{$variant},variant")->only('show');
        $this->middleware("can:update,{$variant},user,variant")->only('update');
        $this->middleware("can:answer,{$variant},user,variant")->only('answer');
        $test = Test::class;
        $this->middleware("can:update,{$test},user,training")->only(['update', 'answer']);
    }

    public function show(User $user, Test $training, Variant $variant): VariantResource
    {
        $variant->load('questions');
        return VariantResource::make($variant);
    }

    public function update(User $user, Test $training, Variant $variant): VariantResource
    {
        $variant->status = Enums\Variant\Status::STARTED;
        $variant->save();

        $training->status = Enums\Test\Status::STARTED;
        $training->save();

        $variant->load('questions');
        return VariantResource::make($variant);
    }

    public function answer(
        AnswerRequest $request,
        User $user,
        Test $training,
        Variant $variant,
        Question $question
    ): VariantResource {
        $variant->submitAnswer($question, $request->answer);
        $variant->updateStatus();
        $variant->save();

        $training->updateStatus();
        $training->save();

        $variant->load('questions');
        return VariantResource::make($variant);
    }
}
