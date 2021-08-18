import {financesWalletsConstants} from "../../../constants/finances.wallets.constants";

export function _delete(state = {items: []}, action) {
    switch (action.type) {
        case financesWalletsConstants.DELETE_REQUEST:
            return {
                request: action.request
            };
        case financesWalletsConstants.DELETE_SUCCESS:
            return {};
        case financesWalletsConstants.DELETE_FAILURE:
            return {
                errors: action.errors,
            };
        default:
            return state
    }
}