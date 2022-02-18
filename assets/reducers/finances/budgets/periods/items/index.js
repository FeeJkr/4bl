import {combineReducers} from "redux";
import {all} from "./all.reducer";

export const items = combineReducers({
    all,
});