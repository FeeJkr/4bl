import { authenticationConstants } from '../../constants/authentication.constants';

export function signUp(state = {isRegistered: false}, action) {
    switch (action.type) {
        case authenticationConstants.REGISTER_REQUEST:
            return {
                isLoading: true,
            };
        case authenticationConstants.REGISTER_SUCCESS:
            return {
                isRegistered: true,
            };
        case authenticationConstants.REGISTER_FAILURE:
            return {
                errors: action.errors,
            };
        case authenticationConstants.REGISTER_CLEAR_STATE:
            return {
                isRegistered: false,
                errors: [],
                isLoading: false,
            };

        default:
            return state
    }
}