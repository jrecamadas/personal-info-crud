import { Question } from '@common/model/client-feedback/Question';

const getQuestions = (context, payload) => Question.get(payload.query).then((res) => {
    context.commit('CLEAR_STATES');
    context.commit('GET_QUESTIONS', { data: res.data, extra: payload.extra });
    context.commit('SAVE_META', res.meta);
});

const saveQuestion = (context, payload) => {
    const { id } = payload;
    const data = {
        question: payload.question,
        questionCategoryId: payload.questionCategoryId,
    };

    const questions = id !== '' && id > 0 ? new Question({ id }) : new Question();
    return questions.save(data).then((res) => {
        context.commit('QUESTIONS_UPDATED', { data: res.data });
    });
};

const updateQuestionStatus = (context, payload) => {
    const { id } = payload;
    const data = {
        isActive: payload.isActive,
    };
    const question = new Question({ id });
    return question.save(data).then((res) => {
        context.commit('QUESTIONS_UPDATED', { data: res.data });
    });
};

const updateQuestionDisplaySequence = (context, payload) => {
    const { id } = payload;
    const data = {
        id: payload.id,
        displaySequence: payload.displaySequence,
    };
    const question = new Question({ id });

    return question.save(data).then((res) => {
        context.commit('QUESTIONS_UPDATED', { data: res.data });
    });
};

export {
    getQuestions, saveQuestion, updateQuestionStatus, updateQuestionDisplaySequence,
};
