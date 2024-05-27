import moment from "moment/moment.js";

export function formatDate(value) {
    if (value){
        return moment(String(value)).format('YYY-MM-DD')
    }
}
