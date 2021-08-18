import {combineReducers} from "redux";
import {categories} from "./categories";
import {wallets} from "./wallets";

export const finances = combineReducers({
    categories,
    wallets,
});