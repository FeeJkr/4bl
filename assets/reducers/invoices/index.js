import {combineReducers} from "redux";
import {contractors} from "./contractors/index";
import {addresses} from "./addresses/index";

export const invoices = combineReducers({
    contractors,
    addresses,
});
