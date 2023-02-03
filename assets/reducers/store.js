import { configureStore } from '@reduxjs/toolkit';
import rootReducer from "./rootReducer";
import thunkMiddleware from "redux-thunk";
import { createLogger } from "redux-logger";

const loggerMiddleware = createLogger();

const store = configureStore({
    reducer: rootReducer,
    middleware: getDefaultMiddleware => {
        return getDefaultMiddleware({
            serializableCheck: false
        }).concat([
            thunkMiddleware,
            loggerMiddleware,
        ]);
    },
});

export { store };