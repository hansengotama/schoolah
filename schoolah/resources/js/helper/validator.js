import moment from 'moment'

export default {
	required(value) {
		return (value.length < 1) ? true : false
    },
    
    requiredDate(value) {
	    return !moment(value).isValid()
    },

    endDate(startDate, endDate) {
        return !(startDate <= endDate)
    },

    min(value, min) {
        return (parseInt(value) < min) ? true : false
    },

    onlyText(value) {
        var regex = /\d/
        return regex.test(value)
    },

    emailFormat(value) {
        var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
        return !regex.test(String(value).toLowerCase())
    },
    
    modulus(value, multiples) {
        return (value % multiples == 0) ? false : true
    },
}