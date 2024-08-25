<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Client;
use App\Repositories\ClientRepository;
use App\Http\Dto\ClientDto;
use Illuminate\Database\Eloquent\Model;
use App\Services\BaseService;

class ClientService extends BaseService
{

    public function __construct()
    {
        parent::__constructor();
        $this->repository = new ClientRepository();
        $this->repository->enableAudit();

    }

    /**
     * @return mixed
     */
    public function list(): mixed
    {
        return $this->repository->list();
    }

    /**
     * @return mixed
     */
    public function datatable(): mixed
    {  
        return $this->repository->datatable();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function restoreTrash(int $id): bool
    {
        $client = $this->repository->restoreTrash($id);
        return (bool)$client;
    }
      /**
     * @return mixed
     */
    public function trashed(): mixed
    {
        return $this->repository->datatables(true);
    }
    /****
     * @return array
     */
    protected function selectColumn(): array
    {
        return $this->repository->model->selectedColumns();
    }
    /**
     * @param Client $client
     * @return Client
     */
    public function show(Client $client): Client
    {
        return $this->repository->load($client, ['createdUser', 'updatedUser']);
    }
    /**
     * @param Client $client
     * @param Client $client
     * @return bool
     */
    public function destroy(Client $client, Admin $madeByAdmin): bool
    {
        return $this->repository->destroy($client, $madeByAdmin);
    }

    /**
     * @param ClientDto $clientDto
     * @param Client $client
     * @return Model
     */
    public function store(ClientDto $clientDto, Admin $admin): Client
    {
        $client = $this->repository->create($this->setDtoAttr($clientDto), $admin);
       
        return $this->repository->load($client);
    }

    /**
     * @param ClientDto $clientDto
     * @param Client $client
     * @param Admin $madeByAdmin
     * @return Model
     */
    public function update(ClientDto $clientDto, Client $client, Admin $madeByAdmin): Model
    {
        $client =  $this->repository->update($this->setDtoAttr($clientDto), $client, $madeByAdmin);
       
        return $this->repository->load($client);
    }
    /**
     * @param ClientDto $clientDto
     * @return array
     */
    protected function setDtoAttr(ClientDto $clientDto): array
    {
        $array = [
            'name' => $clientDto->name,
            'phone_1' => $clientDto->phone_1,
            'phone_2' => $clientDto->phone_2,
            'email' => $clientDto->email,
            'branch_id' => $clientDto->branch_id,
            'address' => $clientDto->address,
            'status' => $clientDto->status,
            'opening_balance' => $clientDto->opening_balance,
            'country_id' => getActiveCountry()->id??null,
        ];
        
        return $array;
    }
   
}
