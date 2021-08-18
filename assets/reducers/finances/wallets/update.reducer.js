import {financesWalletsConstants} from "../../../constants/finances.wallets.constants";

export function update(state = {}, action) {
    switch (action.type) {
        case financesWalletsConstants.UPDATE_REQUEST:
            return {
                isLoading: true,
            };
        case financesWalletsConstants.UPDATE_SUCCESS:
            return {
                isUpdated: true,
            };
        case financesWalletsConstants.UPDATE_FAILURE:
            return {
                errors: action.errors,
            };
        case financesWalletsConstants.UPDATE_VALIDATION_FAILURE:
            return {
                validationErrors: action.errors,
            };
        case financesWalletsConstants.CLEAR_ALERTS:
            return {
                ...state,
                isUpdated: false,
            };
        default:
            return state
    }
}