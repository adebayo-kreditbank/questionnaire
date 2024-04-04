<?php

namespace App\Http\Controllers\Admin;

use App\Enum\CacheKeyEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AnswerRequest;
use App\Http\Resources\Admin\AnswerResource;
use App\Repositories\AnswerRepository;
use App\Traits\CacheTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AnswerController extends Controller
{
    use ResponseTrait, CacheTrait;

    /**
     * Inject relevant repository dependencies
     */
    public function __construct(
        private AnswerRepository $answerRepository
    ) {
    }


    /**
     * Get all Answers
     * @return Response|JsonResponse
     */
    public function index(): Response|JsonResponse
    {
        $data = $this->cacheToRemember(
            CacheKeyEnum::ANSWERS->value,
            fn () => $this->answerRepository->getAll(descOrder: true)
        );

        return $this->onSuccess(
            statusCode: Response::HTTP_OK,
            data: AnswerResource::collection($data)
        );
    }


    /**
     * create new answer
     * @param AnswerRequest $request
     * @return Response|JsonResponse
     */
    public function store(AnswerRequest $request): Response|JsonResponse
    {
        if ($answer = $this->answerRepository->create($request->validated())) {

            $this->forgetAllAnswersCached(); # delete from cache

            return $this->onSuccess(
                statusCode: Response::HTTP_OK,
                data: new AnswerResource($answer)
            );
        }

        return $this->onError(Response::HTTP_INTERNAL_SERVER_ERROR);
    }


    /**
     * upadate answer
     * @param AnswerRequest $request
     * @param int $id
     * @return Response|JsonResponse
     */
    public function update(AnswerRequest $request, int $id): Response|JsonResponse
    {
        if (!$this->answerRepository->getById($id)) {
            return $this->onError(Response::HTTP_NOT_FOUND);
        }

        if ($this->answerRepository->update($id, $request->validated())) {

            $this->forgetAllAnswersCached(); # delete from cache

            return $this->index();
        }

        return $this->onError(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Delete an answer
     * @param int $id
     * @return Response|JsonResponse
     */
    public function destroy(int $id)
    {
        if ($this->answerRepository->delete($id)) {

            $this->forgetAllAnswersCached(); # delete from cache

            return $this->index();
        }
    }


    /**
     * delete all cached data at once
     * @return void
     */
    private function forgetAllAnswersCached(): void
    {
        # delete from cache
        $this->forgetCache(CacheKeyEnum::ANSWERS->value);
    }
}
