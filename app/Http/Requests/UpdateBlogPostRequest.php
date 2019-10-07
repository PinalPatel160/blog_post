<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => 'image|dimensions:min_width=200,min_height=200',
            'title' => 'max:255',
            'sub_title' => 'max:255',
            'is_published' => 'boolean',
            'published_at' => 'date_format:Y-m-d H:i:s',
        ];
    }
}
