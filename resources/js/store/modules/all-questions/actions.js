import { AllQuestion } from "@common/model/AllQuestion";

const getAllQuestions = (context, payload) => {
    return AllQuestion.get(payload.query).then(res => {
        context.commit("UPDATE_ALL_QUESTIONS", { data: res.data });
    }).catch(e => {
        throw new Error("Can't find resource!");
    });
};

export { getAllQuestions };
