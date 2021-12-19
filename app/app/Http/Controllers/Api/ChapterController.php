<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ChapterResource;
use App\Models\Chapter;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ChapterController extends Controller
{
    public function index(): ResourceCollection
    {
        $chapters = Chapter::all();
        $chapters->load('sections');
        return ChapterResource::collection($chapters);
    }
}
