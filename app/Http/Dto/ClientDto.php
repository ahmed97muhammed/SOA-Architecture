<?php

namespace App\Http\Dto;

use App\Http\Requests\ClientRequest;

class ClientDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $phone_1,
        public readonly ?string $phone_2 = null,
        public readonly int $status,
        public readonly ?string $email = null,
        public readonly ?string $address = null,
        public readonly int $branch_id,
        public ?string $opening_balance = null,
    )
    {

    }

    /**
     * @param ClientRequest $clientRequest
     * @return ClientDto
     */
    public static function extracted(ClientRequest $clientRequest): self
    {
        return new self(
            name: $clientRequest->validated('name'),
            phone_1: $clientRequest->validated('phone_1'),
            phone_2: $clientRequest->validated('phone_2'),
            status: $clientRequest->validated('status'),
            email: $clientRequest->validated('email'),
            address: $clientRequest->validated('address'),
            branch_id: $clientRequest->validated('branch_id'),
            opening_balance: $clientRequest->validated('opening_balance'),
        );
    }

    /**
     * @param ClientRequest $clientRequest
     * @return ClientDto
     */
    public static function update(ClientRequest $clientRequest): self
    {
        return self::extracted($clientRequest);
    }

    /**
     * @param ClientRequest $clientRequest
     * @return ClientDto
     */
    public static function store(ClientRequest $clientRequest): self
    {
        return self::extracted($clientRequest);
    }

}
