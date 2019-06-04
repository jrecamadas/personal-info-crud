/* eslint-disable import/no-extraneous-dependencies */
import { QuestionCategory } from '@common/model/client-feedback/QuestionCategory';

const getCategories = (context, payload) => QuestionCategory.get(payload.query).then((res) => {
    context.commit('CLEAR_STATES');
    context.commit('GET_CATEGORIES', {
        data: res.data,
        extra: payload.extra,
    });
    context.commit('SAVE_META', res.meta);
});

const createCategory = (context, payload) => {
    const data = {
        questionnaireId: payload.questionnaireId,
        name: payload.createName,
    };
    const category = new QuestionCategory();

    return category.save(data).then((res) => {
        context.commit('CATEGORIES_UPDATED', {
            data: res.data,
        });
    });
};

const updateCategoryName = (context, payload) => {
    const { id } = payload;
    const data = {
        id: payload.id,
        name: payload.name,
    };
    const category = new QuestionCategory({
        id,
    });

    return category.save(data).then((res) => {
        context.commit('CATEGORIES_UPDATED', {
            data: res.data,
        });
    });
};

const updateCategoryStatus = (context, payload) => {
    const { id } = payload;
    const data = {
        id: payload.id,
        isActive: payload.isActive,
    };
    const category = new QuestionCategory({
        id,
    });

    return category.save(data).then((res) => {
        context.commit('CATEGORIES_UPDATED', {
            data: res.data,
        });
    });
};

const updateCategoryDisplaySequenceById = (context, payload) => {
    const { id } = payload;
    const data = {
        id: payload.id,
        questionnaireId: payload.questionnaireId,
        displaySequence: payload.displaySequence,
    };
    const category = new QuestionCategory({
        id,
    });

    return category.save(data).then((res) => {
        context.commit('CATEGORIES_UPDATED', {
            data: res.data,
        });
    });
};

const updateCategoryList = (context, categories) => {
    context.commit('CLEAR_STATES');
    context.commit('CATEGORIES_UPDATED', {
        data: categories,
    });
};

export {
    createCategory,
    getCategories,
    updateCategoryName,
    updateCategoryStatus,
    updateCategoryDisplaySequenceById,
    updateCategoryList,
};
