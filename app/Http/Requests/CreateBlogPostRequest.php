<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBlogPostRequest extends FormRequest
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
            'description'  => 'required',
            'image'        => 'required|image|dimensions:min_width=200,min_height=200|mimes:jpeg,png',
            'title'        => 'required|max:255',
            'sub_title'    => 'required|max:255',
            'published_at' => 'date_format:Y-m-d H:i:s',
        ];
    }
}
