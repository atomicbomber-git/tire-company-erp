import moment from 'moment'

export function dateFormat(value) {
    return moment(value).format("DD MMMM Y hh:mm:ss")
}
