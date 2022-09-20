<?php

namespace App\Http\Requests\FutureTransfer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreFutureTransferRequest extends FormRequest
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
            'coin_id' => 'required',
            'state' => 'required',
            'draw_type' => 'required',
            'transfer_amount' => 'required',
        ];
    }
}
