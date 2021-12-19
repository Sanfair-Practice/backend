<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SectionResource;
use App\Models\Section;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SectionController extends Controller
{
    public function index(): ResourceCollection
    {
        $sections = Section::all();
        return SectionResource::collection($sections);
    }
}
