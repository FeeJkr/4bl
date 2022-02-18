import {combineReducers} from "redux";
import {all} from "./all.reducer";

export const categories = combineReducers({
    all,
});