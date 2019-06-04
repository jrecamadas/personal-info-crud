import { CheckPassword } from '@common/model/CheckPassword';

const check = (context, payload) => {
    let checkPass = new CheckPassword()
    return checkPass.save(payload).then((res) => {
        context.commit('CHECK_PASS', {data:res});
    });
};


export {
    check
}
