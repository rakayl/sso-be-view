<?php

namespace Modules\Advert\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Create extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'img_bottom' => 'sometimes|dimensions:width=1080,height=360|dimensions:ratio=3/1',
            'img_top'    => 'sometimes|dimensions:width=1080,height=360|dimensions:ratio=3/1',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
