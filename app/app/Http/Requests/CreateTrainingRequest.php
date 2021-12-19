<?php

namespace App\Http\Requests;

use App\Models\Chapter;
use App\Models\Section;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read array|null $chapters
 * @property-read array|null $sections
 */
class CreateTrainingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'chapters' => [
                'required_without:sections',
                'prohibits:sections',
                'array',
                'min:1',
                'exists:' . Chapter::class . ',id'
            ],
            'sections' => [
                'required_without:chapters',
                'prohibits:chapters',
                'array',
                'min:1',
                'exists:' . Section::class . ',id'
            ],
        ];
    }
}
