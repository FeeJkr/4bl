import {bankAccountsConstants as constants} from "../../../constants/invoices/bankAccounts/constants";

export function all(state = {items: []}, action) {
    switch (action.type) {
        case constants.GET_ALL_REQUEST:
            return {
                loading: true
            };
        case constants.GET_ALL_SUCCESS:
            return {
                items: action.items
            };
        case constants.GET_ALL_FAILURE:
            return {
                errors: action.errors
            };
        case constants.UPDATE_AFTER_SUCCESS_DELETE:
            return {
                items: state.items.filter(bankAccount => bankAccount.id !== action.id)
            };
        case constants.UPDATE_AFTER_SUCCESS_CREATE:
            return {
                items: state.items.concat(action.item),
            };
        default:
            return state
    }
}
