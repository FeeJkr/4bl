import {financesWalletsConstants} from "../../../constants/finances.wallets.constants";

export function all(state = {items: []}, action) {
    switch (action.type) {
        case financesWalletsConstants.GET_ALL_REQUEST:
            return {
                loading: true
            };
        case financesWalletsConstants.GET_ALL_SUCCESS:
            return {
                items: action.items
            };
        case financesWalletsConstants.GET_ALL_FAILURE:
            return {
                errors: action.errors
            };
        case financesWalletsConstants.UPDATE_AFTER_SUCCESS_DELETE:
            return {
                items: state.items.filter(wallet => wallet.id !== action.id)
            };
        default:
            return state
    }
}