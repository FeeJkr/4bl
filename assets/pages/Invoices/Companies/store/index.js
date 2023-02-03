import {createAsyncThunk, createSlice} from "@reduxjs/toolkit";
import axios from "axios";
import {companiesDictionary} from "../../../../helpers/routes/invoices/companies/dictionary";
import {bankAccountsDictionary} from "../../../../helpers/routes/invoices/bankAccounts/dictionary";

export const getData = createAsyncThunk('appCompanies/getData', async () => {
    const response = await axios.get(companiesDictionary.GET_ALL_URL);

    return {
        data: response.data,
        total: response.data.length,
    };
});

export const getCompanyData = createAsyncThunk('appCompanies/getCompanyData', async (companyId) => {
    if (companyId === null) {
        return {
            data: null,
        };
    }

    const response = await axios.get(companiesDictionary.GET_ONE_URL.replace('{id}', companyId));

    return {
        data: response.data,
    };
});

export const addCompany = createAsyncThunk('appCompanies/addCompany', async (company, {dispatch, getState}) => {
    await axios.post(companiesDictionary.CREATE_URL, {
        name: company.name,
        identificationNumber: company.identificationNumber,
        email: company.email,
        phoneNumber: company.phoneNumber,
        isVatPayer: company.isVatPayer,
        vatRejectionReason: company.vatRejectionReason,
        address: {
            street: company.address.street,
            city: company.address.city,
            zipCode: company.address.zipCode,
        },
    });
    await dispatch(getData());
});

export const updateCompany = createAsyncThunk('appCompanies/updateCompany', async (company, {dispatch, getState}) => {


    await dispatch(getCompanyData(null));
    await dispatch(getData());
});

export const getBankAccounts = createAsyncThunk('appCompanies/getBankAccounts', async companyId => {
    const response = await axios.get(bankAccountsDictionary.GET_ALL_URL.replace('{companyId}', companyId));

    return {
        data: response.data,
        total: response.data.length,
    }
});

export const addBankAccount = createAsyncThunk('appCompanies/addBankAccounts', async (bankAccount, {dispatch, getState}) => {
    await axios.post(bankAccountsDictionary.CREATE_URL.replace('{companyId}', bankAccount.companyId), {
        name: bankAccount.name,
        companyId: bankAccount.companyId,
        bankName: bankAccount.bankName,
        bankAccountNumber: bankAccount.bankAccountNumber,
        currency: bankAccount.currency,
    });
    await dispatch(getBankAccounts(bankAccount.companyId));
});

export const updateBankAccount = createAsyncThunk('appCompanies/updateBankAccounts', async (bankAccount, {dispatch, getState}) => {
    await axios.post(bankAccountsDictionary.UPDATE_URL.replace('{id}', bankAccount.id).replace('{companyId}', bankAccount.companyId), {
        name: bankAccount.name,
        bankName: bankAccount.bankName,
        bankAccountNumber: bankAccount.bankAccountNumber,
        currency: bankAccount.currency,
    });
    await dispatch(getBankAccounts(bankAccount.companyId));
});

export const deleteBankAccount = createAsyncThunk('appCompanies/deleteBankAccounts', async (bankAccount, {dispatch, getState}) => {
    await axios.delete(bankAccountsDictionary.DELETE_URL.replace('{id}', bankAccount.id).replace('{companyId}', bankAccount.companyId));
    await dispatch(getBankAccounts(bankAccount.companyId));
});

export const appCompaniesSlice = createSlice({
    name: 'appCompanies',
    initialState: {
        data: [],
        total: 1,
        params: {},
        selectedCompany: null,
        bankAccounts: [],
        selectedBankAccount: null,
        company: null,
    },
    reducers: {
        selectCompany: (state, action) => {
            state.selectedCompany = {...action.payload};
        },
        selectBankAccount: (state, action) => {
            state.selectedBankAccount = action.payload ? { ...action.payload } : null;
        },
        clear: (state, action) => {
            state.selectedCompany = null;
            state.selectedBankAccount = null;
        },
    },
    extraReducers: builder => {
        builder
            .addCase(getData.fulfilled, (state, action) => {
                state.data = action.payload.data;
                state.total = action.payload.totalPages;
                state.params = action.payload.params;
            })
            .addCase(getBankAccounts.fulfilled, (state, action) => {
                state.bankAccounts = action.payload.data;
            })
            .addCase(getCompanyData.fulfilled, (state, action) => {
                state.company = action.payload.data;
            })
    }
});

export const {selectCompany, selectBankAccount, clear} = appCompaniesSlice.actions;

export default appCompaniesSlice.reducer;