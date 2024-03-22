<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\ContactCollection;
use App\Http\Resources\ContactResource;
use App\Services\ContactServiceInterface;
use App\Services\Implements\ContactService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    protected ContactService $service;

    public function __construct(ContactServiceInterface $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return new ContactCollection($this->service->findAll());
        } catch (Exception $e) {
            return response()->error(Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        try {
            return new ContactResource($this->service->store($request->all()));
        } catch (\DomainException $domainException) {
            return response()->error($domainException->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            return new ContactResource($this->service->findById($id));
        } catch (ModelNotFoundException $e) {
            return response()->error(Response::$statusTexts[Response::HTTP_NOT_FOUND], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, int $id)
    {
        try {
            return new ContactResource($this->service->update($request->all(), $id));
        } catch (ModelNotFoundException $domainException) {
            return response()->error(Response::$statusTexts[Response::HTTP_NOT_FOUND], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $this->service->delete($id);
        } catch (ModelNotFoundException $e) {
            return response()->error(Response::$statusTexts[Response::HTTP_NOT_FOUND], Response::HTTP_NOT_FOUND);
        }
        return response()->success(null, Response::HTTP_NO_CONTENT);
    }
}
