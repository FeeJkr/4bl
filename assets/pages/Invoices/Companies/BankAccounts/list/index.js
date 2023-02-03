import React, {useEffect} from "react";
import {useDispatch, useSelector} from "react-redux";
import {getBankAccounts} from "../../store";
import DataTable from "react-data-table-component";
import {columns} from "./columns";

const List = (props) => {
    const company = props.company;

    const dispatch = useDispatch();
    const store = useSelector(state => state.invoices.companies);

    useEffect(() => {
        dispatch(getBankAccounts(company.id));
    }, [company]);

    return (
        <>
            <DataTable
                pagination={false}
                columns={columns}
                responsive={true}
                data={store.bankAccounts}
                defaultSortFieldId='id'
            />
        </>
    );
}

export default List;