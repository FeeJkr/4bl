import React, {useEffect, useState} from "react";
import {useParams} from "react-router-dom";
import {useDispatch, useSelector} from "react-redux";
import {periodsActions} from "../../../../actions/finances/budgets/periods.actions";
import {periodItemsActions} from "../../../../actions/finances/budgets/periodItems.actions";
import {periodCategoriesActions} from "../../../../actions/finances/budgets/periodCategories.actions";
import {PeriodItem} from "./PeriodItem";

function Show() {
    const period = useSelector(state => state.finances.budgets.periods.one.item)
    const periodItems = useSelector(state => state.finances.budgets.periods.items.all.items);
    const periodCategories = useSelector(state => state.finances.budgets.periods.categories.all.items);

    const {id} = useParams();
    const dispatch = useDispatch();

    useEffect(() => {
        dispatch(periodsActions.getOneById(id));
        dispatch(periodItemsActions.getAll(id));
        dispatch(periodCategoriesActions.getAll(id));
    }, []);

    return (
        <div className="container">
            {
                period
                && periodItems
                && periodCategories
                && <PeriodItem period={period} periodItems={periodItems} periodCategories={periodCategories} />
            }
        </div>
    );
}




export {Show};
