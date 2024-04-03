<?php

namespace App\Http\Controllers\Admin;

use App\Enum\CacheKeyEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\QuestionRequest;
use App\Http\Resources\Admin\QuestionResource;
use App\Repositories\QuestionRepository;
use App\Traits\CacheTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;

class QuestionController extends Controller
{
    use ResponseTrait, CacheTrait;

    /**
     * Inject relevant repository dependencies
     * use repository in case data layer needs to change
     */
    public function __construct(
        private QuestionRepository $questionRepository
    ) {
    }


    public function index()
    {
        $data = $this->cacheToRemember(
            CacheKeyEnum::QUESTIONS->value,
            fn () => $this->questionRepository->getAll(descOrder: true)
        );

        return $this->onSuccess(
            statusCode: Response::HTTP_OK,
            data: QuestionResource::collection($data)
        );
    }


    public function store(QuestionRequest $request)
    {
        if ($question = $this->questionRepository->create($request->validated())) {
            
            $this->forgetAllQuestionsCached(); # delete from cache

            return $this->onSuccess(
                statusCode: Response::HTTP_OK,
                data: new QuestionResource($question)
            );
        }

        return $this->onError(Response::HTTP_INTERNAL_SERVER_ERROR);
    }


    public function update(QuestionRequest $request, int $id)
    {
        if (!$this->questionRepository->getById($id)) {
            return $this->onError(Response::HTTP_NOT_FOUND);
        }

        if ($this->questionRepository->update($id, $request->validated())) {
            
            $this->forgetAllQuestionsCached(); # delete from cache

            return $this->index();
        }

        return $this->onError(Response::HTTP_INTERNAL_SERVER_ERROR);
    }


    public function destroy(int $id)
    {
        if ($this->questionRepository->delete($id)) {

            $this->forgetAllQuestionsCached(); # delete from cache
            
            return $this->index();
        }
    }

    
    private function forgetAllQuestionsCached(): void
    {
        # delete from cache
        $this->forgetCache(CacheKeyEnum::QUESTIONS->value);
        $this->forgetCache(CacheKeyEnum::QUESTIONNAIRE->value);
    }
}
