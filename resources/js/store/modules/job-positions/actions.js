import { JobPosition } from '@common/model/JobPosition';

const getJobPositions = (context, payload) => {
    return JobPosition.get(payload.query).then((res) => {
    	context.commit('CLEAR_JOB_POSITIONS');
        context.commit('JOB_POSITIONS_UPDATED', {data: res.data, extra: payload.extra});
        context.commit('SAVE_META', res.meta);
    })
};

const getJobPosition = (context, id) => {
	console.log(id, '_IDIDIDI_')
    return JobPosition.get({id:id}).then((res) => {
        context.commit('JOB_POSITION_UPDATED', {data: res.data});
    }).catch((e) => {
        throw new Error('Can\'t find position!');
    })
}

const savePosition = (context, payload) => {
	const id    = payload.id;
    const data  = {job_title:payload.job_title, job_description:payload.job_description};
    const position = (id != "" && id > 0) ? new JobPosition({id:id}) : new JobPosition();
    return position.save(data);
}

const clearJobPositions = (context) => {
    context.commit('CLEAR_JOB_POSITIONS');
};

const deletePosition = (context, id) => {
    const position = new JobPosition({id: id});
    return position.delete().then((res) => {
        context.commit('DELETE_JOB_POSITION');
    });
};

const saveMeta = (context, meta) => {
    context.commit('SAVE_META', meta);
};

export {
	saveMeta,
    getJobPositions,
    getJobPosition,
    clearJobPositions,
    deletePosition,
    savePosition
}
