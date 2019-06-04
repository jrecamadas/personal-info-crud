import { ReferralType } from '@common/model/ReferralType';

const getReferralTypes = (context, payload) => {
    return ReferralType.get(payload.query).then((res) => {
        context.commit('REFERRAL_TYPES', {data: res.data, extra: payload.extra});
    })
};

export {
    getReferralTypes,
}
