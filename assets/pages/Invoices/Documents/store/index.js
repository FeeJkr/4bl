import {createAsyncThunk, createSlice} from "@reduxjs/toolkit";
import axios from "axios";
import {invoicesDictionary} from "../../../../helpers/routes/invoices.dictionary";

export const getData = createAsyncThunk('appDocuments/getData', async params => {
    const response = await axios.get(invoicesDictionary.GET_ALL_URL, params);

    return {
        params,
        data: response.data,
        allData: response.data,
        totalPages: response.data.length,
    };
});

export const deleteDocument = createAsyncThunk('appDocuments/deleteDocument', async (id, {dispatch, getState}) => {
    await axios.delete(invoicesDictionary.DELETE_URL.replace('{id}', id));
    await dispatch(getData(getState().documents.params));

    return id;
})

export const appDocumentsSlice = createSlice({
    name: 'appDocuments',
    initialState: {
        data: [],
        total: 1,
        params: {},
        allData: [],
    },
    reducers: {},
    extraReducers: builder => {
        builder.addCase(getData.fulfilled, (state, action) => {
            state.data = action.payload.data;
            state.allData = action.payload.allData;
            state.total = action.payload.totalPages;
            state.params = action.payload.params;
        })
    }
});

export default appDocumentsSlice.reducer;