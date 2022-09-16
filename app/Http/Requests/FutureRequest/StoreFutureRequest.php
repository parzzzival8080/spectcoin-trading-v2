<?php

namespace App\Http\Requests\FutureRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreFutureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();
        if($user->role == 'CLIENT')
        {
            return true;
        }
        
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'client_id' => 'required',
            'coin_pair_id' => 'required',
            'client_wallet_future_id' => 'required',
            'leverage' => 'required',
            'margin' => 'required',
        ];
    }
}
