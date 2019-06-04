export default {
    computed: {
        formatDate: function() {
            return (date, format) => moment(date).format(format);
        },
        getDate: function() {
            return (date) => moment(date).toDate();
        }
    },
    methods: {
        controlEnteredDate(instance, obj, node, avoidPreviousDate = true) {
            let regex = /([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))$/;
            if (instance.altInput.value == '') {
                obj[node] = "";
            } else if (!regex.test(instance.altInput.value)) {
                instance.altInput.value = instance.input.value;
            }

            /** This will override the "typed" date that is earlier than today. This is a logic
             *  which we require a date that is at least present or future dates. add parameter "false"
             *  if you don't need this
             */
            //Reset when typed date is yesterday or earlier
            if(avoidPreviousDate){
                if (instance.altInput.value.length > 0) {
                    let refDate = instance.altInput.value.split('-');
                    let enteredDate = new Date(parseInt(refDate[0]),parseInt(refDate[1])-1,parseInt(refDate[2]));
                    let nowDate = new Date();
                    nowDate.setHours(0,0,0);

                    if ((nowDate.getTime() - enteredDate.getTime()) > 0) {
                        instance.altInput.value = instance.input.value.length > 0 ? instance.input.value : '';
                    }
                }
            }
        }
    }
}
