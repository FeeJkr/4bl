import React, {useEffect, useState} from 'react';
import './List.css';
import {useDispatch, useSelector} from "react-redux";
import {Link} from "react-router-dom";
import {Toast} from "react-bootstrap";
import {financesCategoriesActions} from "../../../actions/finances.categories.actions";

function List() {
    const categories = useSelector(state => state.finances.categories.all.items);
    const dispatch = useDispatch();
    const [showToast, setShowToast] = useState(false);

    useEffect(() => {
        dispatch(financesCategoriesActions.getAll());
    }, []);

    function handleDelete(id) {
        dispatch(financesCategoriesActions.deleteCategory(id));
        setShowToast(true);
    }

    return (
        <div className="container-fluid">
            <h4 style={{fontSize: '18px', fontWeight: 600, textTransform: 'uppercase', color: '#495057'}}>Categories</h4>

            <div className="row">
                <div className="col-12">
                    <div className="card">
                        <div className="card-body">
                            <div className="mb-2 row">
                                <div className="col-md-12" style={{textAlign: 'right'}}>
                                    <Link to={'/finances/categories/create'} className="button-create-new btn btn-success">
                                        <i className="bi bi-plus"/>
                                        Create new
                                    </Link>
                                </div>
                            </div>

                            <div>
                                <table className="table align-middle table-nowrap table-check">
                                    <thead className="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th width="80px">Icon</th>
                                        <th width="80px">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {categories && categories.map(function (category, key) {
                                        return (
                                            <tr key={category.id}>
                                                <th scope="row">{++key}</th>
                                                <td>{category.name}</td>
                                                <td>{category.type}</td>
                                                <td>{category.icon}</td>
                                                <td>
                                                    <div className="gap-3"
                                                         style={{display: 'flex', gridGap: '1 rem'}}>
                                                        <Link to={'/finances/categories/edit/' + category.id}>
                                                            <i className="bi bi-pencil edit-company-button"
                                                                style={{color: '#34c38f'}}
                                                            />
                                                        </Link>
                                                        <a onClick={() => handleDelete(category.id)}
                                                              style={{color: '#f46a6a', fontSize: '18 px', cursor: 'pointer'}}>
                                                            <i className="bi bi-trash delete-company-button"
                                                                style={{color: '#f46a6a'}}
                                                            />
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        );
                                    })}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <Toast style={{position: 'absolute', bottom: 80, right: 20, backgroundColor: '#00ca72'}}
                   onClose={() => setShowToast(false)}
                   show={showToast}
                   delay={5000}
                   autohide
            >
                <Toast.Header closeButton={false} style={{backgroundColor: '#00ca72', borderBottom: 0}}>
                    <strong className="me-auto" style={{color: '#fff'}}>Success!</strong>
                </Toast.Header>
                <Toast.Body style={{color: '#fff'}}>
                    Category was successfully deleted.
                </Toast.Body>
            </Toast>
        </div>
    );
}

export {List};