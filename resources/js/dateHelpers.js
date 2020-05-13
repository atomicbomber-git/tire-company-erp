import moment from 'moment'

export function formatDate(value) {
    return moment(value).format("DD MMMM Y hh:mm:ss")
}
