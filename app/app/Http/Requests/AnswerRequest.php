<?php

namespace App\Http\Requests;

use App\Models\Question;
use App\Models\Variant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property-read string $answer
 */
class AnswerRequest extends FormRequest
{
    public function rules(): array
    {
        /** @var Variant $variant */
        $variant = $this->route('variant');
        /** @var Question $question */
        $question = $this->route('question');
        return [
            'answer' => ['required', 'size:32', 'alpha_num', Rule::in($variant->getChoicesFor($question))]
        ];
    }
}
