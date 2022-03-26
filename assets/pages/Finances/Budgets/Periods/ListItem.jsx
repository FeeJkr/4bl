import React from "react";
import {Link} from "react-router-dom";
import {useDispatch} from "react-redux";
import {periodsActions} from "../../../../actions/finances/budgets/periods.actions";

export default function ListItem (props) {
    const dispatch = useDispatch();
    const period = props.period;

    function handleDelete(id) {
        dispatch(periodsActions.deletePeriod(id));
        props.setShowToast(true);
    }

    return <tr key={period.id}>
        <th scope="row">{props.number}</th>
        <td>{period.name}</td>
        <td>{period.startAt}</td>
        <td>{period.endAt}</td>
        <td>
            <div className="gap-3"
                 style={{display: 'flex', gridGap: '1 rem'}}>
                <Link to={'/finances/budgets/' + period.id}>
                    <i className="bi bi-info-circle"/>
                </Link>
                <Link to={'/finances/budgets/edit/' + period.id}>
                    <i className="bi bi-pencil edit-contractors-button"
                       style={{color: '#34c38f'}}
                    />
                </Link>
                <a onClick={() => handleDelete(period.id)}
                   style={{color: '#f46a6a', fontSize: '18 px', cursor: 'pointer'}}>
                    <i className="bi bi-trash delete-contractors-button"
                       style={{color: '#f46a6a'}}
                    />
                </a>
            </div>
        </td>
    </tr>
}