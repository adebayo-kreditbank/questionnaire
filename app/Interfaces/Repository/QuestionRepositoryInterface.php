<?php

namespace App\Interfaces\Repository;

interface QuestionRepositoryInterface extends RepositoryInterface
{
    # extends declarations from the parent Interface before this

    public function getAllWithAnswers();

    public function getWithAnswersAndBehaviours(int $questionId);

    public function getQuestionAnswerBehaviourById(int $questionId, int $answerId);
}
