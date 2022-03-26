import {combineReducers} from "redux";
import {one} from "./one.reducer";
import {create} from "./create.reducer";
import {update} from "./update.reducer";
import {all} from "./all.reducer";
import {_delete} from "./delete.reducer";

export const companies = combineReducers({
    all,
    one,
    create,
    update,
    _delete,
});