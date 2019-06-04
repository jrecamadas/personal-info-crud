import { AllQuestionResponse } from "@common/model/AllQuestionResponse";

const getAllQuestionResponses = (context, payload) => {
    return AllQuestionResponse.get(payload.query).then(res => {
        context.commit("UPDATE_ALL_QUESTION_RESPONSES", { data: res.data });
    }).catch(e => {
        throw new Error("Can't find resource!");
    });
};

const saveResponses = (context, payload) => {
    const response = new AllQuestionResponse();
    return response.save(payload).then(res => {
        context.commit("UPDATE_ALL_QUESTION_RESPONSES", { data: res.data });
    }).catch(e => {
        throw new Error("Internal Error occured!");
    });
};

export {
    getAllQuestionResponses,
    saveResponses,
};
