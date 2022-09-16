<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $auth = Auth::user();
        if( $auth->role == 'CLIENT')
        {
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'coin_pair_id' => 'required',
            'order_per_unit' => 'required',
            'number_of_order' => 'required',
            'delegate_type' => 'required'
        ];
    }
}
