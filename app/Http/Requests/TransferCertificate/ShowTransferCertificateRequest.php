<?php

namespace App\Http\Requests\TransferCertificate;

use Illuminate\Foundation\Http\FormRequest;

class ShowTransferCertificateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $auth = Auth::user();
        if($auth->role == 'ADMINISTRATOR')
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
            //
        ];
    }
}
