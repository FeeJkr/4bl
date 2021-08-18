import React, {useState} from 'react';
import 'emoji-mart/css/emoji-mart.css'
import {Link} from "react-router-dom";
import {useDispatch, useSelector} from "react-redux";
import Select from "react-select";
import {financesCategoriesActions} from "../../../actions/finances.categories.actions";


function Create() {
    const dispatch = useDispatch();
    const validationErrors = useSelector(state => state.finances.categories.create.validationErrors);
    const [showEmojiPicker, setShowEmojiPicker] = useState(false);
    let errors = [];
    const [inputs, setInputs] = useState({
        name: '',
        type: 'income',
        icon: '',
    });

    function handleChange(e) {
        const { name, value } = e.target;
        setInputs(inputs => ({ ...inputs, [name]: value }));
    }

    const handleTypeChange = (data) => {
        setInputs(inputs => ({...inputs, type: data.value}));
    }

    function handleSubmit(e) {
        e.preventDefault();

        dispatch(financesCategoriesActions.createCategory(inputs));
    }

    const onEmojiClick = (emoji) => {
        setInputs(inputs => ({...inputs, icon: emoji.native}));
        setShowEmojiPicker(false);
    };

    if(validationErrors) {
        validationErrors.forEach(function (element) {
            errors[element.propertyPath] = element;
        });
    }

    return (
        <div className="container-fluid">
            <div
                style={{display: 'flex', alignItems: 'center', justifyContent: 'space-between'}}>
                <h4 style={{fontSize: '18px', fontWeight: 600, textTransform: 'uppercase', color: '#495057'}}>Create new</h4>
                <div>
                    <nav>
                        <ol className="breadcrumb m-0">
                            <li className="breadcrumb-item">
                                <Link to={'/finances/categories'}
                                   style={{textDecoration: 'none', color: '#495057'}}>Categories</Link>
                            </li>
                            <li className="active breadcrumb-item">
                                <Link to={'/finances/categories/create'}
                                   style={{textDecoration: 'none', color: '#74788d'}}>Add Category</Link>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div className="row">
                <div className="col-12">
                    <div className="card">
                        <div className="card-body">
                            <div className="mb-4" style={{fontSize: '15px', margin: '0 0 7px', fontWeight: 600}}>
                                New category details
                            </div>
                            <form id="create-company-form" onSubmit={handleSubmit}>
                                <div className="row">
                                    <div className="col-sm-1">
                                        <div className="mb-3 form-group">
                                            <label htmlFor="type"
                                                   style={{marginBottom: '.5rem', fontWeight: 500}}>Icon</label>

                                            <button type="button" className="btn emoji-picker-button form-control" onClick={() => setShowEmojiPicker(!showEmojiPicker)}>
                                                {inputs.icon === '' ? <i className="bi bi-emoji-smile"/> : inputs.icon}
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
                                                defaultValue={{value: 'income', label: 'Income'}}
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
        </div>
    );
}

export {Create};