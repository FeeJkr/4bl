import {combineReducers} from "redux";
import {categories} from "./categories";
import {wallets} from "./wallets";
import {budgets} from "./budgets";

export const finances = combineReducers({
    categories,
    wallets,
    budgets,
});