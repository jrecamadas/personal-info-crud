import { EducationalAttainment } from '@common/model/EducationalAttainment';

const getEducationalAttainments = (context, payload) => {
    return EducationalAttainment.get(payload.query).then((res) => {
        context.commit('EDUCATIONAL_ATTAINMENTS_UPDATED', {data: res.data, extra: payload.extra});
    })
};

// get single employee specified by id
const getActiveEducationalAttainments = (context, payload) => {
    //console.log(context,"__CONTEXT__");
    //console.log(payload,"__PAYLOAD__");
    return EducationalAttainment.get(payload.query).then((res) => {
        let items = [];
        res.data.forEach((obj)=>{
            if(obj.is_active==1){
                items.push(obj);
            }
        });
        context.commit('EDUCATIONAL_ATTAINMENTS_ACTIVE_UPDATED', {data: items, extra: payload.extra});
    }).catch((e) => {
        //console.log(e,"__FULLLOG__");
        throw new Error('Can\'t find available active Educational Attainment options!');
    });;
};

export {
    getEducationalAttainments,
    getActiveEducationalAttainments
}
