<?php

namespace App\Http\Controllers\Admin;

use App\Facades\ResponseFacade;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Facades\ClientFacade;
use App\Http\Requests\ClientRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Dto\ClientDto;
use App\Http\Controllers\SharedController;
use Exception;
use App\Http\Requests\StatusChangeRequest;

class ClientsController extends SharedController
{

    public function __construct()
    {
        $this->activeNav = 'clients_salesCollection';
    }

    /**
     * @return mixed
     */
    public function index(): mixed
    {
        abort_if(!canDo('clients_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        shareViewDate(["activeNav"=> $this->activeNav,'activeItem'=>'clients','title'=> p('clients')]);
     
        return view('dashboard.modules.clients.index');
    }

    /**
     * @return mixed
     */
    public function datatable(): mixed
    {
        return ClientFacade::datatable();
    }

    /**
     * @return mixed
     */
    public function create(): mixed
    {
        abort_if(!canDo('clients_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        shareViewDate(["activeNav"=> $this->activeNav,'activeItem'=>'clients','title'=> p('create').' '.p('clients')]);
        
        return view('dashboard.modules.clients.create');
    }

    /**
     * @param ClientRequest $clientRequest
     * @return mixed
     */
    public function store(ClientRequest $clientRequest): mixed
    {
        abort_if(!canDo('clients_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        try{
            $client = ClientFacade::store(ClientDto::store($clientRequest), Admin());
            return back()->with('success',p('done_successfully'));
        }
        catch(Exception $e)
        {
            return back()->with('error',p('error_ocurred').getException($e));
        }
    }

      /**
     * @param Client $client
     * @return mixed
     */
    public function statusChange(Client $client,StatusChangeRequest $request): mixed
    {
        abort_if(!canDo('clients_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return $client->update(["status"=>$request->status]);
    }
    /**
     * @param Client $client
     * @return mixed
     */
    public function show(Client $client): mixed
    {
        abort_if(!canDo('clients_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        shareViewDate(["activeNav"=> $this->activeNav,'activeItem'=>'clients','title'=>p('show').' '. p('clients')]);
     
        return view('dashboard.modules.clients.show');
    }
  
    /**
     * @param Client $client
     * @return mixed
     */
    public function edit(Client $client): mixed
    {
        abort_if(!canDo('clients_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        abort_if(activeBranchId() != $client->branch_id, Response::HTTP_FORBIDDEN, '403 Forbidden');
        shareViewDate(["activeNav"=> $this->activeNav,'activeItem'=>'clients','title'=>p('edit').' '. p('clients')]);
    
        return view('dashboard.modules.clients.edit',compact('client'));
    }

    /**
     * @param ClientRequest $clientRequest
     * @param Client $client
     * @return mixed
     */
    public function update(ClientRequest $clientRequest, Client $client): mixed
    {
        abort_if(!canDo('clients_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        abort_if(activeBranchId() != $client->branch_id, Response::HTTP_FORBIDDEN, '403 Forbidden');
        try{
            $client = ClientFacade::update(ClientDto::update($clientRequest),$client, Admin());
            return back()->with('success',p('done_successfully'));
        }
        catch(Exception $e)
        {
            return back()->with('error',p('error_ocurred').getException($e));
        }
    }
   
    /**
     * @param Client $client
     * @return mixed
     */
    public function destroy(Client $client): mixed
    {
        abort_if(!canDo('clients_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        abort_if(activeBranchId() != $client->branch_id, Response::HTTP_FORBIDDEN, '403 Forbidden');
        try{
            ClientFacade::destroy($client, Admin());
            return back()->with('success',p('done_successfully'));
        }
        catch(Exception $e)
        {
            return back()->with('error',p('error_ocurred').getException($e));
        }
       
    }

}
