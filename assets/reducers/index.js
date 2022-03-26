import { combineReducers } from 'redux';
import {invoices} from "./invoices";
import {authentication} from "./authentication";
import {finances} from "./finances";

const rootReducer = combineReducers({
    authentication,
    invoices,
    finances,
});

export default rootReducer;