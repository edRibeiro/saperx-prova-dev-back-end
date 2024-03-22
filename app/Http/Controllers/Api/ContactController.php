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
     * @OA\Get(
     *     path="/api/contacts",
     *     summary="Retorna todos os contatos registrados",
     *     tags={"Contacts"},
     *     @OA\Response(
     *         response=200,
     *         description="Operação bem sucedida",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Contact")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno do servidor"
     *     )
     * )
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
     * @OA\Post(
     *     path="/api/contacts",
     *     summary="Cria um novo contato",
     *     tags={"Contacts"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados do contato",
     *         @OA\JsonContent(
     *             required={"name", "email", "birth_date", "phones"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="birth_date", type="string", format="date", example="1990-01-01"),
     *             @OA\Property(
     *                 property="phones",
     *                 type="array",
     *                 @OA\Items(type="string", example="(99) 9999-9999")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Contato criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Contact")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Entidade não processável",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="The email field is required.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno do servidor"
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/contacts/{id}",
     *     summary="Retorna um contato específico pelo ID",
     *     tags={"Contacts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do contato",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Operação bem-sucedida",
     *         @OA\JsonContent(ref="#/components/schemas/Contact")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contato não encontrado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno do servidor"
     *     )
     * )
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
     * @OA\Put(
     *     path="/api/contacts/{id}",
     *     summary="Atualiza um contato existente pelo ID",
     *     tags={"Contacts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do contato",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados do contato",
     *         @OA\JsonContent(
     *             required={"name", "email", "birth_date", "phones"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="birth_date", type="string", format="date", example="1990-01-01"),
     *             @OA\Property(
     *                 property="phones",
     *                 type="array",
     *                 @OA\Items(
     *                     type="string",
     *                     example="(99) 9999-9999"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Contato atualizado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Contact")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contato não encontrado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno do servidor"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/contacts/{id}",
     *     summary="Exclui um contato existente pelo ID",
     *     tags={"Contacts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do contato a ser excluído",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Contato excluído com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Contato não encontrado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro interno do servidor"
     *     )
     * )
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
