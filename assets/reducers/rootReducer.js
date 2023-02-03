import {authentication} from "./authentication";
import documents from '../pages/Invoices/Documents/store';
import companies from '../pages/Invoices/Companies/store';
import {combineReducers} from "redux";

const invoices = combineReducers({documents, companies});

const rootReducer = {
    authentication,
    invoices,
};

export default rootReducer;