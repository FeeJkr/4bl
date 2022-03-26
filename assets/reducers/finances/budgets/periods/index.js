import {all} from "./all.reducer";
import {create} from "./create.reducer";
import {combineReducers} from "redux";
import {_delete} from "./delete.reducer";
import {one} from "./one.reducer";
import {update} from "./update.reducer";
import {items} from "./items";
import {categories} from "./categories";

export const periods = combineReducers({
    all,
    create,
    _delete,
    one,
    update,
    items,
    categories,
});