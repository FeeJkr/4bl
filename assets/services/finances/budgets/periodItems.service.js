import axios from "axios";
import {periodItemsDictionary as dictionary} from "../../../helpers/routes/finances/budgets/periodItems.dictionary";

export const periodItemsService = {
    getAll,
};

function getAll(periodId) {
    return axios
        .get(dictionary.GET_ALL_URL.replace('{periodId}', periodId))
        .then((response) => response.data);
}
