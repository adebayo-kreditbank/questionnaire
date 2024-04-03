<?php

namespace App\Http\Controllers\Admin;

use App\Enum\CacheKeyEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AnswerRequest;
use App\Http\Resources\Admin\AnswerResource;
use App\Repositories\AnswerRepository;
use App\Traits\CacheTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;

class AnswerController extends Controller
{
    use ResponseTrait, CacheTrait;

    /**
     * Inject relevant repository dependencies
     * use repository in case data layer needs to change
     */
    public function __construct(
        private AnswerRepository $answerRepository
    ) {
    }


    public function index()
    {
        $this->forgetAllAnswersCached();
        $data = $this->cacheToRemember(
            CacheKeyEnum::ANSWERS->value,
            fn () => $this->answerRepository->getAll(descOrder: true)
        );

        return $this->onSuccess(
            statusCode: Response::HTTP_OK,
            data: AnswerResource::collection($data)
        );
    }


    public function store(AnswerRequest $request)
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


    public function update(AnswerRequest $request, int $id)
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


    public function destroy(int $id)
    {
        if ($this->answerRepository->delete($id)) {

            $this->forgetAllAnswersCached(); # delete from cache
            
            return $this->index();
        }
    }

    
    private function forgetAllAnswersCached(): void
    {
        # delete from cache
        $this->forgetCache(CacheKeyEnum::ANSWERS->value);
    }
}
