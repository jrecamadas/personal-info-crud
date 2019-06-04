import { Timezone } from "@common/model/Timezone";

const getTimezones = (context, payload) => {
    return Timezone.get(payload.query).then(res => {
        context.commit("CLEAR_STATES");
        context.commit("TIMEZONES_UPDATED", {
            data: res.data,
            extra: payload.extra
        });
        context.commit("SAVE_META", res.meta);
    });
};

const saveTimezone = (context, payload) => {
    const id = payload.id;
    const data = { name: payload.name, description: payload.description };
    const timezone =
        id != "" && id > 0 ? new Timezone({ id: id }) : new Timezone();
    return timezone.save(data);
};

const deleteTimezone = (context, id) => {
    const timezone = new Timezone({ id: id });
    return timezone.delete().then(res => {
        context.commit("DELETE_Timezone");
    });
};

const getTimezone = (context, id) => {
    return Timezone.get({ id: id })
        .then(res => {
            context.commit("EDIT_TimeZone", { data: res.data });
        })
        .catch(e => {
            throw new Error("Can't find Timezone!");
        });
};

const saveMeta = (context, meta) => {
    context.commit("SAVE_META", meta);
};

export {
    getTimezones,
    getTimezone,
    saveTimezone,
    saveMeta,
    deleteTimezone,
};
