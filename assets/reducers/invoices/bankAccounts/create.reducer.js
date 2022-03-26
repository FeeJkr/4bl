import {bankAccountsConstants as constants} from "../../../constants/invoices/bankAccounts/constants";

export function create(state = {items: []}, action) {
    switch (action.type) {
        case constants.CREATE_REQUEST:
            return {
                request: action.request,
                isLoading: true,
            };
        case constants.CREATE_SUCCESS:
            return {};
        case constants.CREATE_FAILURE:
            return {
                errors: action.errors,
            };
        case constants.CREATE_VALIDATION_FAILURE:
            return {
                validationErrors: action.errors,
            };
        default:
            return state
    }
}
