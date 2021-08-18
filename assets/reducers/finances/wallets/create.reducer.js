import {financesWalletsConstants} from "../../../constants/finances.wallets.constants";

export function create(state = {items: []}, action) {
    switch (action.type) {
        case financesWalletsConstants.CREATE_REQUEST:
            return {
                request: action.request,
                isLoading: true,
            };
        case financesWalletsConstants.CREATE_SUCCESS:
            return {};
        case financesWalletsConstants.CREATE_FAILURE:
            return {
                errors: action.errors,
            };
        case financesWalletsConstants.CREATE_VALIDATION_FAILURE:
            return {
                validationErrors: action.errors,
            };
        default:
            return state
    }
}