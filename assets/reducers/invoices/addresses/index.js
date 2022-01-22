import {combineReducers} from "redux";
import {all} from "./all.reducer";
import {one} from "./one.reducer";

export const addresses = combineReducers({
    all,
    one,
});