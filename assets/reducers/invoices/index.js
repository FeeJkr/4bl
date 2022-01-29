import {combineReducers} from "redux";
import {contractors} from "./contractors/index";
import {documents} from "./documents/index";
import {companies} from "./companies/index";

export const invoices = combineReducers({
    contractors,
    documents,
    companies,
});
