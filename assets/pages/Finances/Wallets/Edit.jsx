import React, {useEffect, useState} from 'react';
import {Link, useParams} from 'react-router-dom';
import {companiesActions} from "../../../actions/companies.actions";
import {useDispatch, useSelector} from "react-redux";
import {Toast} from "react-bootstrap";
import {Picker} from "emoji-mart";
import Select from "react-select";
import {financesCategoriesActions} from "../../../actions/finances.categories.actions";

function Edit() {
    const category = useSelector(state => state.finances.categories.one.category);
    const [showEmojiPicker, setShowEmojiPicker] = useState(false);

    let successUpdate = useSelector(state => state.finances.categories.update.isUpdated);
    const dispatch = useDispatch();
    const {id} = useParams();
    const validationErrors = useSelector(state => state.finances.categories.update.validationErrors);
    let errors = [];

    useEffect(() => {
        dispatch(financesCategoriesActions.getOne(id));
    }, []);

    function handleChange(e) {
        const { name, value } = e.target;
        category[name] = value;
    }

    function handleSubmit(e) {
        e.preventDefault();

        dispatch(financesCategoriesActions.updateCategory(id, category));
    }

    function closeToast() {
        dispatch(financesCategoriesActions.clearAlerts());
    }

    if(validationErrors) {
        validationErrors.forEach(function (element) {
            errors[element.propertyPath] = element;
        });
    }

    const handleTypeChange = (data) => {
        category.type = data.value;
    }

    const onEmojiClick = (emoji) => {
        category.icon = emoji.native;
        setShowEmojiPicker(false);
    };

    return (category
        ?
            <div className="container-fluid">
                <div
                    style={{display: 'flex', alignItems: 'center', justifyContent: 'space-between'}}>
                    <h4 style={{fontSize: '18px', fontWeight: 600, textTransform: 'uppercase', color: '#495057'}}>
                        Edit category {category.name}
                    </h4>
                    <div>
                        <nav>
                            <ol className="breadcrumb m-0">
                                <li className="breadcrumb-item">
                                    <Link to="/finances/categories"
                                       style={{textDecoration: 'none', color: '#495057'}}>Categories</Link>
                                </li>
                                <li className="active breadcrumb-item">
                                    <Link to={'/finances/categories/' + category.id}
                                       style={{textDecoration: 'none', color: '#74788d'}}>Edit Category</Link>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>

                <div className="row">
                    <div className="col-12">
                        <div className="card">
                            <div className="card-body">
                                <div className="mb-4"
                                     style={{fontSize: '15px', margin: '0 0 7px', fontWeight: 600}}
                                >
                                    Details
                                </div>
                                <form id="create-company-form" onSubmit={handleSubmit}>
                                    <div className="row">
                                        <div className="col-sm-1">
                                            <div className="mb-3 form-group">
                                                <label htmlFor="type"
                                                       style={{marginBottom: '.5rem', fontWeight: 500}}>Icon</label>

                                                <button type="button" className="btn emoji-picker-button form-control" onClick={() => setShowEmojiPicker(!showEmojiPicker)}>
                                                    {category.icon}
                                                </button>

                                                {showEmojiPicker &&
                                                <div style={{position: 'absolute', left: '15px', top: '140px', zIndex: 2000}}>
                                                    <Picker onSelect={onEmojiClick}/>
                                                </div>
                                                }
                                            </div>
                                        </div>
                                        <div className="col-sm-3">
                                            <div className="mb-3 form-group">
                                                <label htmlFor="type"
                                                       style={{marginBottom: '.5rem', fontWeight: 500}}>Type</label>
                                                <Select
                                                    name="type"
                                                    options={[{value: 'income', label: 'Income'}, {value: 'expenses', label: 'Expenses'}]}
                                                    defaultValue={{value: category.type, label: category.type.charAt(0).toUpperCase() + category.type.slice(1)}}
                                                    defaultOptions
                                                    onChange={handleTypeChange}
                                                    placeholder={'Category type'}
                                                />
                                                {errors['type'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{errors['type'].message}</span>
                                                }
                                            </div>
                                        </div>
                                        <div className="col-sm-8">
                                            <div className="mb-3 form-group">
                                                <label htmlFor="name"
                                                       style={{marginBottom: '.5rem', fontWeight: 500}}>Name</label>
                                                <input id="name" name="name"
                                                       placeholder="Enter category name..." type="text"
                                                       className="form-control"
                                                       style={{padding: '.47rem .75rem', fontSize: '.8125rem', display: 'block', fontWeight: 400, lineHeight: 1.5}}
                                                       onChange={handleChange}
                                                       defaultValue={category.name}
                                                />
                                                {errors['name'] &&
                                                <span style={{color: 'red', fontSize: '10px'}}>{errors['name'].message}</span>
                                                }
                                            </div>
                                        </div>
                                    </div>

                                    <div className="justify-content-end row">
                                        <div className="col-lg-12">
                                            <input type="submit" className="btn btn-primary" style={{fontSize: '13px'}} value="Save Changes"/>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div style={{position: 'absolute', bottom: 80, right: 20}}>
                    <Toast style={{backgroundColor: '#00ca72'}}
                           onClose={closeToast}
                           show={!!successUpdate}
                           delay={3000}
                           autohide
                    >
                        <Toast.Header closeButton={false} style={{backgroundColor: '#00ca72', borderBottom: 0}}>
                            <strong className="me-auto" style={{color: '#fff'}}>Success!</strong>
                        </Toast.Header>
                        <Toast.Body style={{color: '#fff'}}>
                            Category was successfully updated.
                        </Toast.Body>
                    </Toast>
                </div>

            </div>
        :
            <div>Loading</div>
    );
}

export {Edit};