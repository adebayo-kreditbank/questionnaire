<?php

namespace App\Http\Controllers\Admin;

use App\Enum\CacheKeyEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MappingRequest;
use App\Http\Requests\Admin\QuestionRequest;
use App\Http\Resources\Admin\MappingQuestionResource;
use App\Http\Resources\Admin\QuestionResource;
use App\Models\Behaviour;
use App\Repositories\AnswerRepository;
use App\Repositories\BehaviourRepository;
use App\Repositories\QuestionRepository;
use App\Traits\CacheTrait;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    use ResponseTrait, CacheTrait;

    /**
     * Inject relevant repository dependencies
     * use repository in case data layer needs to change
     */
    public function __construct(
        private QuestionRepository $questionRepository,
        private BehaviourRepository $behaviourRepository,
        private AnswerRepository $answerRepository
    ) {
    }


    /**
     * Get all Questions
     * @return Response|JsonResponse
     */
    public function index(): Response|JsonResponse
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


    /**
     * create new questions
     * @param QuestionRequest $request
     * @return Response|JsonResponse
     */
    public function store(QuestionRequest $request): Response|JsonResponse
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


    /**
     * Update a resource
     * @param QuestionRequest $request
     * @param int $id
     */
    public function update(QuestionRequest $request, int $id): Response|JsonResponse
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


    /**
     * Delete a question
     * @param int $id
     * @return Response|JsonResponse
     */
    public function destroy(int $id): Response|JsonResponse
    {
        if ($this->questionRepository->delete($id)) {

            $this->forgetAllQuestionsCached(); # delete from cache

            return $this->index();
        }
    }

    

    /**
     * create pivot relationship mapping for question, answer and behaviour
     * @param MappingRequest $request
     * @param int $id
     * @return Response|JsonResponse
     */
    public function storeMapping(MappingRequest $request, $id): Response|JsonResponse
    {
        $validated = $request->validated();

        # create Behaviour for pivot binding between question, answer, and behaviour
        foreach ($validated["answerOptions"] as $answerId) {
            try {
                if ($answerId == 0) continue;

                /** @var Answer */
                $answer = $this->answerRepository->getById($answerId);
                if ($answer->behaviours()->wherePivot('question_id', $id)->count() > 0) continue;

                /** @var int|null */
                $nextQuestionId = optional($validated["nextQuestions"])[$answerId];

                /** @var Behaviour */
                $behaviour = $this->behaviourRepository->create(["question_id" => $nextQuestionId]);

                # set the nextQuestion as child Question
                $this->questionRepository->update((int) $nextQuestionId, ['parent_question_id' => $id]);

                $this->behaviourRepository->syncAnswerWithQuestion($behaviour, $answerId, $id);

            } catch (Exception $e) {
                Log::debug($e->getMessage());
            }
        }

        return $this->onSuccess(
            statusCode: Response::HTTP_OK,
            data: $validated["answerOptions"]
        );
    }



    /**
     * Get Pivot Mapping
     * @return Response|JsonResponse
     */
    public function getMapping(): Response|JsonResponse
    {
        $data = $this->cacheToRemember(
            CacheKeyEnum::QUESTIONS->value,
            fn () => $this->questionRepository->getAll(descOrder: true)
        );

        return $this->onSuccess(
            statusCode: Response::HTTP_OK,
            data: MappingQuestionResource::collection($data)
        );
    }


    /**
     * delete all cached data at once
     * @return void
     */
    private function forgetAllQuestionsCached(): void
    {
        # delete from cache
        $this->forgetCache(CacheKeyEnum::QUESTIONS->value);
        $this->forgetCache(CacheKeyEnum::QUESTIONNAIRE->value);
    }
}
