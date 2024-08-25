<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class ClientRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {

        return [
            'name' => $this->name(),
            'phone_1' => $this->phone(true),
            'phone_2' => $this->phone(false),
            'email' => $this->email(false),
            'status' => $this->bool(),
            'branch_id' => $this->isExists('branches'),
            'address' => $this->text(false,200),
            'opening_balance' => $this->isFloat(false),
        ];
    
    }
}
