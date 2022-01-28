import {combineReducers} from "redux";
import {all} from "./all.reducer";
import {one} from "./one.reducer";
import {update} from "./update.reducer";

export const addresses = combineReducers({
    all,
    one,
    update,
});