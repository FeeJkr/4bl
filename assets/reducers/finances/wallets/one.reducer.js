import {financesWalletsConstants} from "../../../constants/finances.wallets.constants";

export function one(state = {items: []}, action) {
    switch (action.type) {
        case financesWalletsConstants.GET_ONE_REQUEST:
            return {};
        case financesWalletsConstants.GET_ONE_SUCCESS:
            return {
                item: action.item,
            };
        case financesWalletsConstants.GET_ONE_FAILURE:
            return {
                errors: action.errors,
            };
        case financesWalletsConstants.GET_ONE_CHANGED:
            return {
                item: {...state.item, ...action.item},
            };
        default:
            return state
    }
}