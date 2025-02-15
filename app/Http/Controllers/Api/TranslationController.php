<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TranslationRequest;
use App\Interfaces\TranslationServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(title="Translation API", version="1.0")
 * @OA\Tag(name="Translations", description="API Endpoints for managing translations")
 */
class TranslationController extends Controller
{
    private TranslationServiceInterface $service;

    public function __construct(TranslationServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Get all translations.
     *
     * @OA\Get(
     *     path="/translations",
     *     summary="Retrieve all translations",
     *     tags={"Translations"},
     *     @OA\Response(response=200, description="List of translations"),
     *     @OA\Response(response=401,description="Unauthorized")
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json($this->service->getAllTranslations());
    }

    /**
     * Store a new translation.
     *
     * @OA\Post(
     *     path="/translations",
     *     summary="Create a new translation",
     *     tags={"Translations"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"locale", "key", "value"},
     *             @OA\Property(property="locale", type="string", example="en"),
     *             @OA\Property(property="key", type="string", example="greeting"),
     *             @OA\Property(property="value", type="string", example="Hello"),
     *             @OA\Property(property="tags", type="array", @OA\Items(type="string"))
     *         )
     *     ),
     *     @OA\Response(response=201, description="Translation created successfully"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(TranslationRequest $request): JsonResponse
    {
        try {
            $translation = $this->service->createTranslation($request->validated());
            return response()->json($translation, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Update an existing translation.
     *
     * @OA\Put(
     *     path="/translations/{id}",
     *     summary="Update a translation",
     *     tags={"Translations"},
     *     @OA\Parameter(name="id", in="path", required=true, description="Translation ID", @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"locale", "key", "value"},
     *             @OA\Property(property="locale", type="string", example="fr"),
     *             @OA\Property(property="key", type="string", example="welcome"),
     *             @OA\Property(property="value", type="string", example="Bienvenue"),
     *             @OA\Property(property="tags", type="array", @OA\Items(type="string"))
     *         )
     *     ),
     *     @OA\Response(response=200, description="Translation updated successfully"),
     *     @OA\Response(response=422, description="Validation error"),
     *     @OA\Response(response=404, description="Translation not found")
     * )
     */
    public function update(TranslationRequest $request, int $id): JsonResponse
    {
        try {
            $translation = $this->service->updateTranslation($id, $request->validated());
            return response()->json($translation);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Delete a translation.
     *
     * @OA\Delete(
     *     path="/translations/{id}",
     *     summary="Delete a translation",
     *     tags={"Translations"},
     *     @OA\Parameter(name="id", in="path", required=true, description="Translation ID", @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Translation deleted successfully"),
     *     @OA\Response(response=404, description="Translation not found")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $deleted = $this->service->deleteTranslation($id);

            if ($deleted) {
                return response()->json(null, 204);
            }

            return response()->json(['error' => 'Translation not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * Search translations.
     *
     * @OA\Get(
     *     path="/translations/search",
     *     summary="Search translations",
     *     tags={"Translations"},
     *     @OA\Parameter(name="key", in="query", description="Search by key", @OA\Schema(type="string")),
     *     @OA\Parameter(name="value", in="query", description="Search by value", @OA\Schema(type="string")),
     *     @OA\Parameter(name="tags", in="query", description="Search by tags", @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Successful search results"),
     *     @OA\Response(response=400, description="No search parameters provided")
     * )
     */
    public function search(Request $request): JsonResponse
    {
        $filters = $request->only(['key', 'value', 'tags']);

        if (empty($filters)) {
            return response()->json(['error' => 'No search parameters provided'], 400);
        }

        return response()->json($this->service->searchTranslations($filters));
    }

    /**
     * Export translations.
     *
     * @OA\Get(
     *     path="/translations/export",
     *     summary="Export translations",
     *     tags={"Translations"},
     *     @OA\Response(response=200, description="Exported translations data")
     * )
     */
    public function export(): JsonResponse
    {
        return response()->json($this->service->exportTranslations());
    }
}
